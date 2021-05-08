<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {
    var $key;
	public function __construct(){
        parent::__construct();
        $this->load->model('BasicModel','basic');
        $this->load->model('UserModel','user');
        if(!$this->session->userdata('email')){
            redirect('Login');
        }
        $this->setKey();
        hitCounter();
        cekSessionUser();
    }
    private function setKey(){
		$info = $this->basic->getRow('rajaongkir');
        $this->key  = $info['rajaongkir'];
	}

    public function index(){
		$this->_validation();
		if($this->form_validation->run()==false){
			$this->_viewAkun();
		}else{
            $email = $this->session->userdata('email');
			$data =[
				'nama'=>$this->input->post('nama'),
				'alamat'=>$this->input->post('alamat'),
				'notelpon'=>$this->input->post('nohp'),
				'kode_pos'=>$this->input->post('kodepos'),
				'id_provinsi'=>$this->input->post('provinsi'),
				'id_kota'=>$this->input->post('kota')
			];
            $this->user->update($data,['email'=>$email]);
            $this->session->set_flashdata('pesan',"<script>toastr.success('Perubahan data berhasil')</script>");
            redirect('member/Akun');
        }
	}

	public function updatePassword(){
        $this->form_validation->set_rules('old-password','Password lama','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);
        $this->form_validation->set_rules('password','Password','required|trim|min_length[8]|matches[repassword]',
                                            [
                                                'required'=>'%s tidak boleh kosong',
                                                'matches'=>'%s harus sama',
                                                'min_length'=>'%s harus lebih 8 karakter'
                                            ]);
        $this->form_validation->set_rules('repassword','Password','required|trim|matches[password]',
                                            [
                                                'required'=>'%s tidak boleh kosong',
                                                'matches'=>'%s harus sama'
                                            ]);
        if($this->form_validation->run()==false){         
            $this->_viewAkun();
        } 
        else{
            $email = $this->session->userdata('email');
            $data['user'] = $this->user->getWhere('password',['email'=>$email]);  
            $passwordlama = sha1(htmlspecialchars($this->input->post('old-password',true)));
            
            $passwordbaru = sha1(htmlspecialchars($this->input->post('password',true)));
            //ketika isi password lama tidak sama dengan password yang ada di database
            if($data['user']['password']!=$passwordlama){
                $this->session->set_flashdata('pesan',"<script>toastr.error('Mohon masukan password lama dengan benar')</script>");
                redirect('member/Akun');
            }else{
              // jika password yang baru sama dengan password lama
              if($passwordlama==$passwordbaru){
                $this->session->set_flashdata('pesan',"<script>toastr.error('Password yang anda masukan sama dengan sebelumnya')</script>");
				redirect('member/Akun');
              }
              // jika berhasil
              else{
                    $idUser = $this->session->userdata('id');
                    $newPassword = [
                        'password'=> $passwordbaru
                    ];
                    $this->user->update($newPassword,['id'=>$idUser]);
                    $this->session->set_flashdata('pesan',"<script>toastr.success('Pengantian password berhasil')</script>");
					redirect('member/Akun');
                }
            }
        }                          
    }

	private function _viewAkun(){
		$data['title'] = "Akun";
        $data['provinsi'] = $this->getRajaOngkir('provinsi','');
		$data['user'] = $this->user->getWhere('email,nama,jekel,alamat,notelpon,tgl_daftar,foto,kode_pos,id_provinsi,id_kota',['email'=>$this->session->userdata('email')]);
		// $data['kota'] = $this->getRajaOngkir('kota',$data['user']['id_provinsi']);
		$data['user']['id_provinsi']?$data['kota'] = $this->getRajaOngkir('kota',$data['user']['id_provinsi']):'';
		$this->load->view('member/template/header',$data);
        $this->load->view('member/template/navigation');
        $this->load->view('member/template/topNavigation');
        $this->load->view('member/akun/akun');
        $this->load->view('member/template/footer');
        $this->load->view('member/template/script');
	}
	public function getKota(){
		$id = $this->input->post('id');
		$data= $this->getRajaOngkir('kota',$id);
		echo json_encode($data);
    }
    public function getRajaOngkir($status,$idProvinsi){
		$curl = curl_init();
		if($status == 'kota'){
			
			$url = 'https://api.rajaongkir.com/starter/city?province='.$idProvinsi;
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
	private function _validation(){
        $this->form_validation->set_rules('nama','Nama','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);
        $this->form_validation->set_rules('alamat','Alamat','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);
        $this->form_validation->set_rules('nohp','Nomor Telpon','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);
        $this->form_validation->set_rules('provinsi','Provinsi','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);
        $this->form_validation->set_rules('kota','Kota','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);
        $this->form_validation->set_rules('kodepos','Kode POS','required|trim',
                                            [
                                                'required'=>'%s tidak boleh kosong'
                                            ]);

    }
}
