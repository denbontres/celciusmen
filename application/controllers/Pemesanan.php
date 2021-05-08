<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . '/third_party/midtrans/Midtrans.php';
class Pemesanan extends CI_Controller {
	var $midtranskey;
	var $midtransUrl;
	var $isProduction;

	public function __construct(){
		parent::__construct();
		hitCounter();
		cekSessionUser();
		$this->load->model('BarangModel','barang');
		$this->load->model('PemesananModel','pemesanan');
		$this->load->model('DetailPemesananModel','orderDetail');
		$this->load->model('BasicModel','basic');
		$this->load->model('SkuModel','sku');
		$this->load->model('UserModel','user');
		$this->setMindtransKey();
		$this->setMindtransUrl();
		$this->setIsProduction();
	}

	private function setMindtransKey(){
		$info = $this->basic->getRow('midtrans');
        $this->midtranskey  = $info['midtrans'];
	}

	private function setMindtransUrl(){
		$info = $this->basic->getRow('midtrans_url');
        $this->midtransUrl  = $info['midtrans_url'];
	}

	private function setIsProduction(){
		$info = $this->basic->getRow('sandbox');
        $this->isProduction  = $info['sandbox'];
	}

	public function getTotal(){
		if($this->session->userdata('email')){
			$nofaktur = $this->session->userdata('nofaktur');
			
			$where = [
				'nofaktur'=>$nofaktur
			];

			$jumlah = $this->orderDetail->getSumWhere('subtotal',$where);
			echo number_format($jumlah['subtotal'],'0',',','.');
		}
	}
	
	public function getJumlahBarang(){
		if($this->session->userdata('email')){
			$nofaktur = $this->session->userdata('nofaktur');
			$where = [
				'nofaktur'=>$nofaktur
			];

			$jumlah = $this->orderDetail->getSumWhere('jumlah',$where);
			echo $jumlah['jumlah'];
		}
	}

	public function addDataPemesanan(){
		$sku = htmlspecialchars($this->input->post('sku',true));
        $barang = $this->sku->getBarangbySku($sku);
		$nofaktur = $this->session->userdata('nofaktur');
		$jumlahbeli = $this->input->post('jumlahBeli',true);
		$harga = $barang['total_harga'];
		$berat = $barang['berat'];
        $stok = $barang['jumlah'];
        $kodeSku = $barang['sku'];
		$subtotal = $harga * $jumlahbeli;
        $jumlahberat = $jumlahbeli * $berat;
        
		$where = [
			'nofaktur'=>$nofaktur,
			'sku'=>$kodeSku
		];

		$data = [
			'sku'=>$kodeSku,
			'nofaktur'=>$nofaktur,
			'jumlah'=>$jumlahbeli,
			'subtotal'=>$subtotal,
			'totalberat'=>$jumlahberat
		];

		$orderDetail = $this->orderDetail->getWhere('jumlah,subtotal,totalberat',$where);

		if($stok >= $jumlahbeli){
			
			if($orderDetail>0){
				$orderDetail['jumlah']=$orderDetail['jumlah']+$jumlahbeli;
				$orderDetail['totalberat']+=$jumlahberat;
				$orderDetail['subtotal']+=$data['subtotal'];
	
				$update = [
					'jumlah'=>$orderDetail['jumlah'],
					'subtotal'=>$orderDetail['subtotal'],
					'totalberat'=>$orderDetail['totalberat']
				];
				$this->orderDetail->update($update,$where);
	
			}else{
				$pemesanan = $this->getPemesanan();
				if(!$pemesanan){
					$this->insertPemesanan();
				}
				$this->orderDetail->insert($data);	
			}
			manageStok($kodeSku,$barang['jumlah'],$jumlahbeli,'kurang');
			
			$data['pesan'] = "Berhasil";
			$data['nama'] = $barang['nama_barang'].' '.$barang['nama'];
		}else{
			$data['pesan'] = "Gagal";
		}
		echo json_encode($data);
	}

	private function getPemesanan(){
		$where = ['nofaktur'=>$this->session->userdata('nofaktur')];
		return $this->pemesanan->getWhere('nofaktur',$where);
	}

	private function insertPemesanan(){
	    date_default_timezone_set('Asia/Jakarta');
		$pemesanan = [
			'nofaktur'=>$this->session->userdata('nofaktur'),
			'email'=>$this->session->userdata('email'),
			'tanggal'=>date('Y-m-d'),
			'status'=>0
		]; 
		$this->pemesanan->insert($pemesanan);
	}

	// public function getNoFaktur(){
	// 	$data = [
	// 		'nofaktur'=>$this->session->userdata('nofaktur'),
	// 	];
	// 	echo json_encode($data);
	// }

	public function getDataBelanja(){
		$nofaktur = $this->session->userdata('nofaktur');
		$pemesanan = $this->orderDetail->getDataPemesanan($nofaktur);
		echo json_encode($pemesanan);
	}
	public function hapusItemKeranjang(){
		$where = [
			'id'=>htmlspecialchars($this->input->post('id',true))
		];
		

		// ambil jumlah barang yang dibeli
		$pemesanan = $this->orderDetail->getWhere('sku,jumlah',$where);
		$sku = $pemesanan['sku'];
		$jumlahBeli = $pemesanan['jumlah'];

		// ambil stok barang 
		$dataSku = $this->sku->getWhere('jumlah',['kode'=>$sku]);
		$stok = $dataSku['jumlah'];

		manageStok($sku,$stok,$jumlahBeli,'tambah');

		$this->orderDetail->delete($where);
	}

	public function midtrans($faktur){
		$email = $this->session->userdata('email');	
		$data['pemesanan'] = $this->pemesanan->getWhere('ongkir,alamat,kode_pos,kota,total,kurir,berat,layanan,discount,discount_ongkir,kode_kupon,keterangan',['nofaktur'=>$faktur]);
		$total = $this->orderDetail->getSumWhere('subtotal',['nofaktur'=>$faktur]);
		//Set Your server key
		\Midtrans\Config::$serverKey = $this->midtranskey;

		// Uncomment for production environment

		if($this->isProduction == "1"){
			\Midtrans\Config::$isProduction = true;
		}

		\Midtrans\Config::$isSanitized = true;
		\Midtrans\Config::$is3ds = true;

		
		// Fill transaction details
		$transaction_details = array(
		'order_id' => $faktur,
		'gross_amount' => $total['subtotal'] + $data['pemesanan']['ongkir'] - $data['pemesanan']['discount'] - $data['pemesanan']['discount_ongkir'], // no decimal allowed
		);

		// Mandatory for Mandiri bill payment and BCA KlikPay
		// Optional for other payment methods
		$data['detail'] = $this->orderDetail->getAllDetailPemesanan($faktur);
		$user = $this->user->getWhere('nama,email,alamat,notelpon',['email'=>$email]);
		$i = 0;
		foreach($data['detail'] as $r){
			$item1_details[$i]=[
				'id' => $r->id,
				'price' => $r->total_harga,
				'quantity' => $r->jumlah,
				'name' => $r->nama.' '.$r->sku
				];
			$i++;	
		}
		
		$item1_details[$i++]=[
			'id' => 0,
			'price' => $data['pemesanan']['ongkir'],
			'quantity' => 1,
			'name' => 'Pengiriman dengan kurir '.$data['pemesanan']['kurir']." (".$data['pemesanan']['layanan'].") - ".$data['pemesanan']['berat']." gram"
			];
		
		if($data['pemesanan']['discount'] + $data['pemesanan']['discount_ongkir'] > 0 ){
			$keterangan = "Voucer ".$data['pemesanan']['kode_voucer']." Potongan Belanja Rp.".number_format($data['pemesanan']['discount'],0,",",".");
			if($data['pemesanan']['discount_ongkir'] > 0){
				$keterangan = "Voucer ".$data['pemesanan']['kode_voucer']." Potongan Ongkir Sebesar Rp.".number_format($data['pemesanan']['discount_ongkir'],0,",",".");
			}
			$item1_details[$i++]=[
				'id' => 0,
				'price' => "-".($data['pemesanan']['discount_ongkir'] + $data['pemesanan']['discount']),
				'quantity' => 1,
				'name' => $keterangan
			];
		}
		


		for($i=0;$i<count($item1_details);$i++){
			$item_details[$i] =$item1_details[$i] ;
		}
		// Optional
		$shipping_address = array(
			'first_name'    => $user['nama'],
            'last_name'     => '',
            'address'       => $data['pemesanan']['alamat'],
            'city'          => getKotaProvinsi('kota',$data['pemesanan']['kota']),
            'postal_code'   => $data['pemesanan']['kode_pos']
			);

		$customer_details = array(
			'first_name'    => $user['nama'], //optional
			'email'         => $user['email'], //mandatory
			'phone'         => $user['notelpon'], //mandatory
			'shipping_address' => $shipping_address //optional
			);

		// Fill transaction details
		$transaction = array(
			'transaction_details' => $transaction_details,
			'customer_details' => $customer_details,
			'item_details' => $item_details,
			);

			$snapToken = \Midtrans\Snap::getSnapToken($transaction);
			
			date_default_timezone_set('Asia/Jakarta');
			$update = ['token'=>$snapToken,
						'token_create'=>date('Y-m-d H:i:s')
						];
			$this->pemesanan->update($update,['nofaktur'=>$faktur]);
			$urlPembayaranMidtrans = $this->midtransUrl.$snapToken;
			redirect($urlPembayaranMidtrans);
	}


}
