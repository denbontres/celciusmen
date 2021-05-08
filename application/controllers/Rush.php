<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rush extends CI_Controller {

    public function __construct(){
        parent::__construct();
        cekSessionUser();
        hitCounter();
        //$this->load->model('FaqModel','faq');
    }

    public function index(){
        $data['title'] = 'RUSH';
        $data['group'] = 'RUSH';
        //$data['rush'] = $this->faq->getInfo('judul,isi');
        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/home/home_rush');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
    }
}