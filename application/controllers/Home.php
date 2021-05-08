<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        // cekSessionUser();
        hitCounter();
        $this->load->model('SlideModel','slide');
        $this->load->model('KategoriBarangModel','kategori');
        $this->load->model('BarangModel','barang');
        $this->load->model('BlogModel','blog');
    }

    public function index(){
        $data['title'] = 'Home';
        $data['group'] = 'Home';
        $data['slide'] = $this->slide->getAll();
        $data['kategori'] = $this->kategori->getAll();
        $data['selesai'] = $this->input->get('status_code');
        
        // set barang per categori
        foreach($data['kategori'] as $r){
            $data['barangWomen'][$r['id']] = $this->barang->getAllWhere('id,foto,nama,harga,diskon,total_harga,slug as url,brand',['id_kategori_barang'=>$r['id'],'id_jenis_barang'=>2]);
        }

        foreach($data['kategori'] as $r){
            $data['barangMen'][$r['id']] = $this->barang->getAllWhere('id,foto,nama,harga,diskon,total_harga,slug as url,brand',['id_kategori_barang'=>$r['id'],'id_jenis_barang'=>1]);
        }

        foreach($data['kategori'] as $r){
            $data['barangKid'][$r['id']] = $this->barang->getAllWhere('id,foto,nama,harga,diskon,total_harga,slug as url,brand',['id_kategori_barang'=>$r['id'],'id_jenis_barang'=>3]);
        }

        $data['blog'] = $this->blog->getListArtikelForHome();
        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/home/home');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
    }
}