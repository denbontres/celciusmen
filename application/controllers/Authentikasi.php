<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentikasi extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('UserModel','user');
    }

    public function index(){
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $data = [
            "email"=>$email,
            "password"=>$password
        ];
        $validation = $this->_validationLogin();
        if($validation['status']==0){
			$validation['pesan'] = "Gagal";
		}else{
            $user = $this->db->get_where('tbl_user',['email'=>$email])->row_array();
            if($user && ($password==$user['password'])){
                $data=[
                    'email'=>$email,
                    'id'=>$user['id'],
                    'nama'=>$user['nama'],
                    'foto'=>$user['foto'],
                    'id_jenis_user'=>$user['id_jenis_user'],
                    'tgl_daftar'=>$user['tgl_daftar']
                ];
                $this->session->set_userdata($data);
                $validation['pesan'] = "Berhasil";
            }else{
                $validation['pesan'] = "Salah";
            }
        }
        echo json_encode($validation);
    }

    private function _validationLogin(){
        $result['status'] = 1;
        
        $this->form_validation->set_rules('email','Email','required|valid_email',[
                                        'required'=>'%s harus disi',
                                        'valid_email'=>'%s email tidak valid'
        ]);
        $this->form_validation->set_rules('password','Password','required|min_length[8]',[
                                        'required'=>'%s harus disi',
                                        'min_length'=>'%s minimal harus 8 charakter' 
        ]);

        if($this->form_validation->run()==false){
            // hasil dari form_erro('txtEmail) = "</p>Email harus diisi</p>"
            $result['errorEmail'] =bersihKalimatError('email');
            $result['errorPassword'] = bersihKalimatError('password');
            $result['status']=0;
        }
        return $result;
    }
    public function block(){
        $data['judul']="Akses Diblokir";
        $this->load->view('backend/template/header',$data);        
        $this->load->view('backend/template/sidebar');        
        $this->load->view('backend/block');     
        $this->load->view('backend/template/footer');        
        $this->load->view('backend/template/script'); 
    }
    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_jenis_user');
        redirect('Home');
    }
    
}