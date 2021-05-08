<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thankyou extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('PemesananModel','pemesanan');
        $this->load->model('DetailPemesananModel','orderDetail');
        $this->load->helper('status_helper');
        $this->load->model('BasicModel','basic');

        if(!$this->session->userdata('email')){
            redirect('Login');
        }
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0',false);
        header('Pragma: no-cache');
        hitCounter();
        cekSessionUser();
    }

    public function index(){

        $email = $this->session->userdata('email');
        $data['title'] = 'Thankyou';
        $data['group'] = 'Thankyou';
        $data['selesai'] = $this->input->get('status_code');
        
   
      
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
            $this->load->view('frontend/home/thankyoupages');
            $this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
       

    }
}