<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	var $key;

    public function __construct(){
		parent::__construct();
		cekSessionUser();
		hitCounter();
        $this->load->model('DetailPemesananModel','orderDetail');
		$this->load->model('UserModel','user');
		$this->load->model('BasicModel','basic');
		$this->load->model('PemesananModel','pemesanan');
		$this->setKey();
    }

	private function setKey(){
		$info = $this->basic->getRow('rajaongkir');
        $this->key  = $info['rajaongkir'];
	}



    public function index(){
		$nofaktur  = $this->session->userdata('nofaktur');
		$orderDetail= $this->orderDetail->getSumWhere('subtotal',['nofaktur'=>$nofaktur]);
		$subtotal = $orderDetail['subtotal'];

        $this->form_validation->set_rules('nama','Nama','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('alamat','Alamat','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('provinsi','Provinsi','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('kota','Kota','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('kodepos','Kode Pos','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('kurir','Kurir','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('layanan','Layanan','required',[
			'required'=>'%s harus disi',   
		]);
        $this->form_validation->set_rules('ongkir','Ongkir','required',[
			'required'=>'%s harus disi',   
		]);

		if($this->form_validation->run()==false){
			$this->viewHalamanCheckout($subtotal,$nofaktur);
		}else{
			$ongkir = $this->session->userdata('ongkir');
			$total = $subtotal;

			$data = [
				'nofaktur'=>$this->session->userdata('nofaktur'),
				'email'=>$this->session->userdata('email'),
				'total'=>$total,
				'status'=>'1',
				'alamat'=>htmlspecialchars($this->input->post('alamat',true)),
				'kota'=>htmlspecialchars($this->input->post('kota',true)),
				'kode_pos'=>htmlspecialchars($this->input->post('kodepos',true)),
				'ongkir' => $ongkir
			];
			$this->pemesanan->update($data,['nofaktur'=>$nofaktur]);
			$data['faktur']=$this->pemesanan->getNomorFaktur($this->session->userdata('email'));
			$this->session->set_userdata(['nofaktur'=>$data['faktur']]);
			redirect('Pemesanan/midtrans/'.$nofaktur);
		}
        
    }

	private function viewHalamanCheckout($subtotal,$nofaktur){
		$data['title'] = 'Checkout';
		$data['group'] = 'Home';
        $data['provinsi'] = $this->getRajaOngkir('provinsi');
         
        $email = $this->session->userdata('email');
        $data['order'] = $this->orderDetail->getOrderDetail($nofaktur);
        $data['subtotal'] = $subtotal;
        $data['user'] = $this->user->getWhere('nama,alamat,kode_pos,id_provinsi,id_kota',['email'=>$email]);
		$data['user']['id_provinsi']?$data['kota'] = $this->getRajaOngkir('kota',$data['user']['id_provinsi']):'';
		if($data['order']){
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
			$this->load->view('frontend/checkout/checkout');
			$this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
        }else{
            redirect('Home');
        }
	}

    public function getKota(){
		$data= $this->getRajaOngkir('kota');
		echo json_encode($data);
    }
    
    public function getKurir(){
		$kurir = $this->input->post('kurir');
        $tujuan = $this->input->post('tujuan');
		$layanan = $this->getLayanan($kurir,$tujuan);
		echo json_encode($layanan);
    }
    
    public function getRajaOngkir($status){
		$curl = curl_init();
		if($status == 'kota'){
			$id = $this->input->post('id');
			$url = 'https://api.rajaongkir.com/starter/city?province='.$id;
		}else{
			$url = 'https://api.rajaongkir.com/starter/province';
		}
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 60,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"key: $this->key"
		),
		));

		$response = json_decode(curl_exec($curl),true);
		$i=0;
		
		for($i;$i< count($response['rajaongkir']['results']);$i++){
			
			if($status=='kota'){
				$data[$i] = [
					'nama_kota'=>$response['rajaongkir']['results'][$i]['city_name'],
					'id_kota'=>$response['rajaongkir']['results'][$i]['city_id']
				];	
			}else{
				$data[$i] = [
					'id_provinsi'=>$response['rajaongkir']['results'][$i]['province_id'],
					'nama_provinsi'=>$response['rajaongkir']['results'][$i]['province'],
				];
			}
		}

		$err = curl_error($curl);
		curl_close($curl);
		return $data;
    }

    public function getLayanan($kurir,$tujuan){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "origin=501&destination=$tujuan&weight=1700&courier=".$kurir,
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: $this->key"
		),
		));

		$response = json_decode(curl_exec($curl),true);
		
		// mengambil nama layanan tiap courir
		for ($i=0;$i<count($response['rajaongkir']['results'][0]['costs']);$i++){
			$data[$i] = [
				'layanan'=>$response['rajaongkir']['results'][0]['costs'][$i]['service'],
				'id'=>$i	
			];
		}
		return $data;
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		}
	}
	
	public function getOngkir(){
		$info = $this->basic->getRow('kota');
		$faktur = $this->session->userdata('nofaktur');
		$berat = $this->_getTotalBerat();
        $asal  = $info['kota'];
		$curl = curl_init(); 
		$kurir = $this->input->post('kurir');
		$tujuan = $this->input->post('tujuan');
		$layanan = $this->input->post('layanan');
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "origin=$asal&destination=$tujuan&weight=$berat&courier=$kurir",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: $this->key"
		),
		));

		$response = json_decode(curl_exec($curl),true);
		$ongkir = isset($response)?$response['rajaongkir']['results'][0]['costs'][$layanan]['cost'][0]['value']:0;

		$this->session->set_userdata('ongkir',$ongkir);
		echo $ongkir;
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		}
	}

	private function _getTotalBerat(){
		$nofaktur = $this->session->userdata('nofaktur');
		$where = [
			'nofaktur'=>$nofaktur
		];
		$data['detail'] = $this->orderDetail->getSumWhere('totalberat',$where);
		return $data['detail']['totalberat'];
	}
	
	
}