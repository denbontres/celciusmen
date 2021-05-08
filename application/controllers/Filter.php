<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $data = [
            'filter' =>
            [
                'kategori'=>$this->input->post('kategori'),
                'harga_min'=>$this->input->post('harga-min'),
                'harga_max'=>$this->input->post('harga-max'),
                'warna'=>$this->input->post('warna'),
                'brand'=>$this->input->post('brand')
            ]
            
        ];
        $this->session->set_userdata($data);
        redirect('Shop/Shop');
    }
}