<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends CI_Controller {
    public function __construct(){
            parent::__construct();
            is_logged_in('Konten');
            $this->load->model('ContactModel','contact');
            $this->load->library('datatables'); 
    }

    public function index(){
            $data['judul']="Contact";
            $data['group']="Contact";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/contact/contact');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
    }

    public function detail($id){
            $data['judul']="Contact";
            $data['group']="Contact";
            $data['contact'] = $this->contact->getWhere('*',['id'=>$id]);
            $this->contact->update(['status'=>"1"],['id'=>$id]);
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/contact/detail');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
    }
    
    public function getContact(){
        header('Content-Type: application/json');
        $data = $this->contact->getAllContact();
        echo $data;
    }

}   