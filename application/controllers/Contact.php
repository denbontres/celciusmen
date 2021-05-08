<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('ContactModel','contact');
        $this->load->model('BasicModel','basic');
        cekSessionUser();
        hitCounter();
    }

    public function index(){
        $this->form_validation->set_rules('email','Email','required|trim|valid_email',
                                        [
                                          'required'=>'%s tidak boleh kosong',
                                          'valid_email'=>'%s tidak valid'
                                        ]);
        $this->form_validation->set_rules('nama','Nama','required|trim',
                                        [
                                          'required'=>'%s tidak boleh kosong'
                                        ]);
        $this->form_validation->set_rules('pesan','Pesan','required|trim',
                                        [
                                          'required'=>'%s tidak boleh kosong'
                                        ]);
        if($this->form_validation->run()==false){
            $data['title'] = 'Contact';
            $data['group'] = 'Contact';
            $data['basic'] = $this->basic->getRow('notelp,alamat,map,email');
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
            $this->load->view('frontend/contact/contact');
            $this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
        }else{
            $data = [
                'nama'=>htmlspecialchars($this->input->post('nama',true)),
                'email'=>htmlspecialchars($this->input->post('email',true)),
                'pesan'=>htmlspecialchars($this->input->post('pesan',true))
            ];

            $this->contact->insert($data);
            $this->session->set_flashdata('pesan',"<script>toastr.success('Pesan berhasil dikirim')</script>");
            redirect('Contact');
        }
    }
}