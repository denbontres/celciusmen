<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('UserModel','user');
        $this->load->model('PemesananModel','pemesanan');
    }

    public function index(){
        $this->form_validation->set_rules('email','email','required|trim|valid_email',
                                        [
                                          'required'=>'%s tidak boleh kosong',
                                          'valid_email'=>'%s tidak valid'
                                        ]);
        $this->form_validation->set_rules('password','Password','required|trim|min_length[8]',
                                        [
                                          'required'=>'Password tidak boleh kosong',
                                          'min_length'=>'%s minimal harus 8 charakter' 
                                        ]);
        if($this->form_validation->run()==false){
            $data['title'] = 'Login';
            $data['group'] = 'Home';
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
            $this->load->view('frontend/authentikasi/login');
            $this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
        }else{
            $this->_login(); 
        }

    }

    private function _login(){
        $email = htmlspecialchars($this->input->post('email',true));
        $password = htmlspecialchars(sha1($this->input->post('password',true)));

        // mengambil data user berdasarkan email yang diinputkan
        $user = $this->user->getUserLogin(['email'=>$email]);

        // jika data user ditemukan dan password sama dengan yang ada di tabel user, serta jenis dari user tersebut adalah customer dan ship owner
        if($user && ($password==$user['password'])){
            // pembentukan data untuk disimpan ke session
            $data=[
                'email'=>$user['email'],
                'id'=>$user['id'],
                'nama'=>$user['nama'],
                'id_jenis_user'=>$user['id_jenis_user'],
                'nofaktur'=>$this->pemesanan->getNomorFaktur($email)
            ];
            $this->session->set_userdata($data);
            redirect('Home');
        }
        // login gagal
        else{
            // kirimkan pesan gagal!
          $this->session->set_flashdata('pesan','
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Email atau Password salah 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>');
          redirect('Login');
        }
    }
}