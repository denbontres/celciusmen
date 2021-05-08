<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentikasi extends CI_Controller {
	  public function __construct(){
        parent::__construct();
            $this->load->model('UserModel','user');
    }
    public function index(){
        if($this->session->userdata('email')){
            redirect('akun');
        }
        $this->form_validation->set_rules('email','Email','required|trim|valid_email',
                                        [
                                          'required'=>'Email tidak boleh kosong',
                                          'is_unique'=>'Email sudah digunakan',
                                          'valid_email'=>'Email tidak valid'
                                        ]);
        $this->form_validation->set_rules('password','Password','required|trim|min_length[8]',
                                        [
                                          'required'=>'Password tidak boleh kosong',
                                          'min_length'=>'%s minimal harus 8 charakter' 
                                        ]);
        if($this->form_validation->run()==false){
            $data['judul']="Login";
            $this->load->view('backend/authentikasi/header',$data);
            $this->load->view('backend/authentikasi/login');
            $this->load->view('backend/authentikasi/script');
        }
        else{
            $this->_login();
        } 
    }
    private function _login(){
      $email = $this->input->post('email',true);
      $password = md5($this->input->post('password',true));
      $user = $this->db->get_where('tbl_user',['email'=>$email])->row_array();
      if($user && ($password==$user['password']) && $user['id_jenis_user'] != 4){
          $data=[
              'email'=>$email,
              'nama'=>$user['nama'],
              'foto'=>$user['foto'],
              'id_jenis_user'=>$user['id_jenis_user'],
              'tgl_daftar'=>$user['tgl_daftar']
          ];
          $this->session->set_userdata($data);
          redirect('admin/Dasboard');
      }else{
        $this->session->set_flashdata('pesan','
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Email atau Password salah 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        redirect('admin/Authentikasi');
        
      }
    }
    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_jenis_user');
        redirect('admin/Authentikasi');
    }
    public function block(){
        if($this->session->userdata('email')){
            $data['judul']="Akses Diblokir";
            $data['group']="Akses Diblokir";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/block');     
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script'); 
        }else{
            is_logged_in();
        }
    }
}
