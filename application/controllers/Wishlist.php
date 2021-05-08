<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wishlist extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('BarangModel','barang');
        $this->load->model('WishlistModel','wishlist');
        cekSessionUser();
        hitCounter();
    }

    public function index(){
        $data['title'] = 'Home';
        $data['group'] = 'Home';
        
		$this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/wishlist/wishlist');
        $this->load->view('frontend/template/partner');
		$this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
    }

    public function getAll(){
        $email = $this->session->userdata('email');
		$data= $this->wishlist->getAllWishlist($email);
		echo json_encode($data);
	}

    public function addWishlist(){
        $email = $this->session->userdata('email');
        if($email){
            $idBarang = $this->input->post('idBarang');
            $wishlist = $this->wishlist->getWhere('id',['email'=>$email,'id_barang'=>$idBarang]);
            if(!$wishlist){
                $data = [
                    'id_barang'=>$idBarang,
                    'email'=>$email
                ];
                $this->wishlist->insert($data);
                echo "Berhasil";
            }else{
                echo "Sudah ada";
            }
        }
        else{
            echo "Gagal";
        }
    }

    public function getJumlahBarang(){
        $email = $this->session->userdata('email');
        if($email){
            $jumlah = $this->wishlist->getCountRowWhere(['email'=>$email]);
            echo $jumlah;
        }
        else{
            echo "Gagal";
        }
    }
    public function getWishlist(){
        $email = $this->session->userdata('email');
        if($email){
            $wishlist = $this->wishlist->getDataWishlist($email);
		    echo json_encode($wishlist);
        }else{
            echo "Gagal";
        }
    }
    public function hapusItemWishlist(){
        $id = $this->input->post('id');
        $email = $this->session->userdata('email');
        if($email){
            $this->wishlist->delete(['id'=>$id]);
		    echo "Berhasil";
        }else{
            echo "Gagal";
        }
    }
}