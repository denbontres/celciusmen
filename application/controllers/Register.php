<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('UserModel','user');
        $this->load->model('PemesananModel','pemesanan');
    }

    public function index(){
        $this->form_validation->set_rules('email','email','required|trim|valid_email|is_unique[tbl_user.email]',
                                        [
                                          'required'=>'%s tidak boleh kosong',
                                          'valid_email'=>'%s tidak valid',
                                          'is_unique'=>'%s sudah digunakan'
                                        ]);
        $this->form_validation->set_rules('password','Password','required|trim|min_length[8]',
                                        [
                                          'required'=>'Password tidak boleh kosong',
                                          'min_length'=>'%s minimal harus 8 charakter' 
                                        ]);
        $this->form_validation->set_rules('nama','Nama','required',[
                                            'required'=>'%s harus disi',   
                                        ]);
                                
        $this->form_validation->set_rules('nohp','Nomor HP','required|numeric',[
                                            'required'=>'%s harus disi',   
                                            'numeric'=>"%s isi dengan angka"    
                                        ]);
        $this->form_validation->set_rules('password','Password','required|min_length[8]',[
                                            'required'=>'%s harus disi',
                                            'min_length'=>'%s minimal harus 8 charakter'
                                        ]);
        $this->form_validation->set_rules('repassword','Repeat password','required|matches[password]',[
                                            'required'=>'%s harus disi',
                                            'matches'=>'Password harus sama',   
                                        ]);
        if($this->form_validation->run()==false){
            $data['title'] = 'Register';
            $data['group'] = 'Home';
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
            $this->load->view('frontend/authentikasi/register');
            $this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
        }else{
            $data = [
                "nama"=>$this->input->post('nama'),
                "notelpon"=>$this->input->post('nohp'),
                "email" => $this->input->post('email'),
                "password"=>sha1($this->input->post('password')),
                "tgl_daftar"=>date('Y-m-d'),
                "id_jenis_user"=>4      
            ];
            $this->user->insert($data);
            $dataSession =[
                'nofaktur'=>$this->pemesanan->getNomorFaktur($data['email']),
                'nama'=>$data['nama'],
                'id_jenis_user'=>4,
                'email'=>$data['email']
            ];
            $this->session->set_userdata($dataSession);
            redirect('Home');    
        }

    }

}