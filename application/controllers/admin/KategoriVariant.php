<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class KategoriVariant extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Barang');
                $this->load->model('KategoriVariantModel','kategori');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Kategori Variant";
                $data['group']="Kategori Variant";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/kategoriVariant');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function getKategori(){
                header('Content-Type: application/json');
                $data = $this->kategori->getAllKategori();
                echo $data;
        }
}
?>