<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	public function __construct(){
		parent::__construct();
		cekSessionUser();
		hitCounter();
		$this->load->model('DetailPemesananModel','detailpemesanan');
		$this->load->model('SkuModel','sku');
    }
    
    // note : jika tidak ada barang belanjaa buat tulisan keranjang kosong

    public function index(){
        // $data['url'] = ""; 
        $data['title'] = 'Keranjang';
        $data['group'] = 'Home';
		$nofaktur  = $this->session->userdata('nofaktur');
		$data['pemesanan']= $this->db->query("SELECT * FROM tbl_pemesanan WHERE nofaktur = '$nofaktur'")->row_array();
		$orderDetail= $this->detailpemesanan->getSumWhere('subtotal',['nofaktur'=>$nofaktur]);
		$data['subtotal'] = $orderDetail['subtotal'];
		// Update Value Kupon
		if($data['pemesanan']['kode_kupon']!= ''){
			$kupon = $data['pemesanan']['kode_kupon'];
			$coupon = $this->db->query("SELECT * FROM tbl_kupon WHERE BINARY kode_kupon ='$kupon'")->row_array();
			if($orderDetail['subtotal'] <= $coupon['min_value']){
				
				$this->db->set("kode_kupon",'');
				$this->db->set("keterangan",'');
				$this->db->set("discount",0);
				$this->db->set("discount_ongkir",0);
				$this->db->where("nofaktur",$nofaktur);
				$this->db->update('tbl_pemesanan');
			}else{
				// Update Kupon
				if($coupon['tipe_kupon'] == 'free_ongkir'){
					$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Ongkir Rp.".number_format($coupon['value'],0,",",".");
					$discount = 0;
					$discount_ongkir = $coupon['value'];
				}else{
					if($coupon['tipe_potongan'] == 'value'){
						$discount_ongkir = 0;
						$discount = $coupon['value'];
						$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Belanja Rp.".number_format($coupon['value'],0,",",".");
					}else{
						$discount_ongkir = 0;
						$discount = round(($coupon['value'] * $orderDetail['subtotal'])/100);
						$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Belanja Rp.".number_format($discount,0,",",".");
					}
				}
				$this->db->set("kode_kupon",$coupon['kode_kupon']);
				$this->db->set('keterangan',$keterangan);
				$this->db->set("discount",$discount);
				$this->db->set("discount_ongkir",$discount_ongkir);
				$this->db->where("nofaktur",$nofaktur);
				$this->db->update('tbl_pemesanan');
			}
			
		}
		$this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
		$this->load->view('frontend/cart/cart',$data);
		$this->load->view('frontend/template/partner');
		$this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
	}
	public function getAll(){
		$data= $this->detailpemesanan->getAllDetailPemesanan($this->session->userdata('nofaktur'));
		echo json_encode($data);
	}

	public function plusminBelanja(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');

		$where = [
			'id'=>$id
		];
		
		$detail = $this->detailpemesanan->getWhere('jumlah,sku',$where);
		$sku = $detail['sku'];
		
		$barang = $this->sku->getJumlahDanHarga($sku);
		$harga = $barang['total_harga'];
		$jumlah  = $barang['jumlah'];
		// echo $jumlah;die();
		if($status == "kurang"){
			if($detail['jumlah'] == 1){
				$this->detailpemesanan->delete($where);
			}else{
				$jumSekarang = $detail['jumlah']-1;			
			}
			manageStok($sku,$jumlah,1,'tambah');
			$subtotal = $jumSekarang * $harga;
		
		$data = [
			'jumlah'=>$jumSekarang,
			'subtotal'=>$subtotal
		];

		$this->detailpemesanan->update($data,$where);
		echo "berhasil";
		}else{
			if($jumlah>=1){
				$jumSekarang = $detail['jumlah']+1;
				manageStok($sku,$jumlah,1,'kurang');
			}else{
				$jumSekarang = $detail['jumlah'];
				$status = "gagal";
			}
			$subtotal = $jumSekarang * $harga;
		
			$data = [
				'jumlah'=>$jumSekarang,
				'subtotal'=>$subtotal
			];
			
			$this->detailpemesanan->update($data,$where);
			if($status!="gagal"){
				echo "berhasil";
			}else{
				echo "gagal";
			}
		}

	}

	public function deletePemesanan(){
		$where = [
			'id'=>$this->input->post('id')
		];

		$detail = $this->detailpemesanan->getWhere('id_barang,jumlah',$where);
		
		$idbarang = $detail['id_barang'];
		$jumlahbeli = $detail['jumlah'];
		
		$barang = $this->barang->getWhere('jumlah',['id'=>$idbarang]);
		$stok = $barang['jumlah'];
		
		manageStok($idbarang,$stok,$jumlahbeli,'tambah');
		$this->detailpemesanan->delete($where);
		echo 'berhasil';
	}
	// Coupon
	function coupon_cek(){
		$kupon = $_POST['kupon'];
		$today = date("Y-m-d");
		$coupon = $this->db->query("SELECT * FROM tbl_kupon WHERE BINARY kode_kupon ='$kupon'")->row_array();
		if($coupon){
			if($coupon['valid_until'] >= $today){
				$nofaktur  = $this->session->userdata('nofaktur');
				$orderDetail= $this->detailpemesanan->getSumWhere('subtotal',['nofaktur'=>$nofaktur]);
				if($orderDetail['subtotal'] >= $coupon['min_value']){
					// Update Kupon
					if($coupon['tipe_kupon'] == 'free_ongkir'){
						$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Ongkir Rp.".number_format($coupon['value'],0,",",".");
						$discount = 0;
						$discount_ongkir = $coupon['value'];
					}else{
						if($coupon['tipe_potongan'] == 'value'){
							$discount_ongkir = 0;
							$discount = $coupon['value'];
							$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Belanja Rp.".number_format($coupon['value'],0,",",".");
						}else{
							$discount_ongkir = 0;
							$discount = round(($coupon['value'] * $orderDetail['subtotal'])/100);
							$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Belanja Rp.".number_format($discount,0,",",".");
						}
					}
					$this->db->set("kode_kupon",$coupon['kode_kupon']);
					$this->db->set('keterangan',$keterangan);
					$this->db->set("discount",$discount);
					$this->db->set("discount_ongkir",$discount_ongkir);
					$this->db->where("nofaktur",$nofaktur);
					$this->db->update('tbl_pemesanan');

					echo json_encode($coupon);
				}else{
					echo json_encode("Kupon dapat digunakan dengan minimal belanja Rp".number_format($coupon['min_value'],0,",","."));
				}
				
				
			}else{
				echo json_encode("Kupon tidak Valid");
			}
		}else{
			echo json_encode("Kupon tidak Tersedia");
		}
	}
	function remove_coupon(){
		$nofaktur  = $this->session->userdata('nofaktur');

		$this->db->set("kode_kupon",'');
		$this->db->set("keterangan",'');
		$this->db->set("discount",0);
		$this->db->set("discount_ongkir",0);
		$this->db->where("nofaktur",$nofaktur);
		$this->db->update('tbl_pemesanan');
		echo json_encode("success");
	}
	function update_kupon_value($nofaktur){
		$pemesanan = $this->db->query("SELECT * FROM tbl_pemesanan WHERE nofaktur = '$nofaktur'")->row_array();
		if($pemesanan['kode_kupon'] != ''){
			$kupon = $pemesanan['kode_kupon'];
			$coupon = $this->db->query("SELECT * FROM tbl_kupon WHERE BINARY kode_kupon ='$kupon'")->row_array();
			$orderDetail= $this->detailpemesanan->getSumWhere('subtotal',['nofaktur'=>$nofaktur]);
			if($orderDetail['subtotal'] <= $coupon['min_value']){
				
				$this->db->set("kode_kupon",'');
				$this->db->set("keterangan",'');
				$this->db->set("discount",0);
				$this->db->set("discount_ongkir",0);
				$this->db->where("nofaktur",$nofaktur);
				$this->db->update('tbl_pemesanan');
			}else{
				// Update Kupon
				if($coupon['tipe_kupon'] == 'free_ongkir'){
					$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Ongkir Rp.".number_format($coupon['value'],0,",",".");
					$discount = 0;
					$discount_ongkir = $coupon['value'];
				}else{
					if($coupon['tipe_potongan'] == 'value'){
						$discount_ongkir = 0;
						$discount = $coupon['value'];
						$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Belanja Rp.".number_format($coupon['value'],0,",",".");
					}else{
						$discount_ongkir = 0;
						$discount = round(($coupon['value'] * $orderDetail['subtotal'])/100);
						$keterangan = "Voucer ".$coupon['kode_kupon']." Minimal belanja Rp.".number_format($coupon['min_value'],0,",",".")." dengan potongan Belanja Rp.".number_format($discount,0,",",".");
					}
				}
				$this->db->set("kode_kupon",$coupon['kode_kupon']);
				$this->db->set('keterangan',$keterangan);
				$this->db->set("discount",$discount);
				$this->db->set("discount_ongkir",$discount_ongkir);
				$this->db->where("nofaktur",$nofaktur);
				$this->db->update('tbl_pemesanan');
			}
		}
	}
	function get_pemesanan(){
		$nofaktur  = $this->session->userdata('nofaktur');
		$this->update_kupon_value($nofaktur);
		$orderDetail= $this->detailpemesanan->getSumWhere('subtotal',['nofaktur'=>$nofaktur]);
		$pemesanan = $this->db->query("SELECT * FROM tbl_pemesanan WHERE nofaktur = '$nofaktur'")->row_array();
		if($orderDetail['subtotal']){

			$pemesanan['subtotal'] = $orderDetail['subtotal'];
		}else{

			$pemesanan['subtotal'] = 0;
		}
		echo json_encode($pemesanan);
	}
}
