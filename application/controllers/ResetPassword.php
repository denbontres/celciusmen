<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResetPassword extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('UserModel','user');
        $this->load->model('TokenModel','token');
        
    }
    public function index(){
        $this->form_validation->set_rules('email','email','required|trim|valid_emai',
                                        [
                                          'required'=>'%s tidak boleh kosong',
                                          'valid_email'=>'%s tidak valid',
                                        ]);             

        if($this->form_validation->run()==false){
            $data['title'] = 'Reset Password';
            $data['group'] = 'Home';
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
            $this->load->view('frontend/authentikasi/resetPassword');
            $this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
        }
        else{
            
            $email = htmlspecialchars($this->input->post('email',true));

            // ambil jumlah baris dari tabel user dengan where email
            $user = $this->user->getCountRowCustomer($email);

            // jika jumlah baris besar sama 1
            if($user>=1){

                // generate token
                $token = urldecode(base64_encode(random_bytes(32)));
                
                // pembentukan data user token yang nantinya disimpan ke tabel token
                $user_token = [
                    'email'=>$email,
                    'token'=>$token,
                    'date_created'=>time()
                ];

                // simpan data ke dalam tabel token
                $this->token->insert($user_token);

                // jalankan fungsi reset email
                $this->_mailResetPassword($email,$token);
                
                // kirimkan pesan bahwa email sudah dikirim
                $this->session->set_flashdata('pesan','
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Periksa Email Anda! 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                redirect('Login');
            }
        }
    }
    private function _mailResetPassword($email,$token){
        $this->load->helper('mail');
        $nama = 'System';
        $url = base_url().'ResetPassword/redirectGantiPassword?email='.$email.'&token='.$token;
        $email_config = [
            'email_user'=>'admin@minangtech.com',
            'email_password'=>'17Juni99!',
            'nama'=>$nama,
            'reciver_email'=>$email,
            'subject'=>'Reset Password',
            'message'=>"Klik link ini untuk mereset password akun anda : <br>
                        <a href ='$url'>Reset Password</a>            
            "
        ];
        sendEmail($email_config);
    }

    public function redirectGantiPassword(){
        $email = htmlspecialchars($this->input->get('email',true));
        $token = $this->input->get('token');

        // hitung jumlah baris dari tabel user dengan where email
        $user = $this->user->getCountRowWhere(['email'=>$email]);

        // jika jumlah baris lebih atau sama dengan 1
        if($user >= 1){
            // ambil data token
            $user_token = $this->token->getWhere('date_created,tipe',['token'=>$token]);
            
            // jika data token ada
            if($user_token){

                // token masih belum expired
                if(time()-$user_token['date_created']<(60*60*3)){

                    // simpan email ke session
                    $this->session->set_userdata('reset_email',$email);

                    // jalankan fungsi ganti password
                    $this->gantiPassword();
                }
                // token expired
                else{

                    // hapus token dari tabel token
                    $this->token->delete(['email'=>$email]);

                    // kirimkan pesan token expired
                    $this->session->set_flashdata('pesan','
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Token Expired 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                    redirect('Login');    
                }
            }
            //ketika token salah
            else{
                $this->session->set_flashdata('pesan','
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Token Salah
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                redirect('Login');
            }
        }else{
            // ketika email salah
            $this->session->set_flashdata('pesan','
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Email Salah
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
            redirect('Login');
        }
    }
    public function gantiPassword(){
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]',
                                        [
                                            'required'=>"%s harus diisi",  
                                            'min_length'=>'%s minimal harus 8 charakter'
                                        ]);
        $this->form_validation->set_rules('repassword', 'Repeat Password', 'required|min_length[8]|matches[password]',
                                        [
                                            'required'=>"%s harus diisi",  
                                            'min_length'=>'%s minimal harus 8 charakter',
                                            'matches'=>'Password harus sama',
                                        ]);
        if($this->form_validation->run()==false){
            $data['title'] = 'Ganti Password';
            $data['group'] = 'Home';
            $this->load->view('frontend/template/head',$data);
            $this->load->view('frontend/template/header');
            $this->load->view('frontend/template/navigation');
            $this->load->view('frontend/authentikasi/gantiPassword');
            $this->load->view('frontend/template/partner');
            $this->load->view('frontend/template/footer');
            $this->load->view('frontend/template/script');
        }else{
            // ambil email reset dari session
            $email = $this->session->userdata('reset_email');
            
            // hapus token dari tabel token
            $where = ['email'=>$email];
            $this->token->delete($where);
            
            // simpan password
            $data = ['password'=>htmlspecialchars(sha1($this->input->post('password',true)))];
            
            // update password
            $this->user->update($data,$where);
            
            // hapus email reset dari session
            $this->session->unset_userdata('reset_email');

            // kirimkan pesan berhasil
            $this->session->set_flashdata('pesan','
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Password berhasil diganti  
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            redirect('Login');
        }
    }
}