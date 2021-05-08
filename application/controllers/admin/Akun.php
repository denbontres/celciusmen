<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Akun extends CI_Controller {
        public function __construct(){
                parent::__construct();
                $this->load->model('UserModel','user');
        }

        public function index(){
                $data['judul']="Profil";
                $data['group']="Profil";
                $data['user'] = $this->user->getDetailUserRow($this->session->userdata('email'));
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/user/profil');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }
        public function updateProfile(){
                $this->form_validation->set_rules('nama', 'Nama', 'required',
                                                [
                                                        'required'=>'%s harus diisi'
                                                ]);
                $this->form_validation->set_rules('notelpon', 'Nomor telpon', 'required',
                                                [
                                                        'required'=>'%s harus diisi'
                                                ]);
                $this->form_validation->set_rules('alamat', 'Alamat', 'required',
                                                [
                                                        'required'=>'%s harus diisi'
                                                ]);
                if($this->form_validation->run()==false){
                        $this->index();
                }else{
                        $data = [
                                "nama"=>htmlspecialchars($this->input->post('nama')),
                                "notelpon"=>htmlspecialchars($this->input->post('notelpon')),
                                "alamat"=>htmlspecialchars($this->input->post('alamat')),
                                "jekel"=>htmlspecialchars($this->input->post('jekel'))
                        ];
                        $where = ["email"=>$this->session->userdata('email')];
                        $foto = addGambar('./foto_user/',"foto");
                        $upload_image1= $_FILES['foto']['name'];
                        // kalau gambar di ganti maka gambar lama dihapus
                        if($upload_image1!=""){
                                $gambar = $this->user->getWhere('foto',$where);
                                deleteGambar('foto_user/',$gambar['foto']);
                                $data['foto'] = $foto;
                        }
                        $this->user->update($data,$where);
                        redirect('admin/Akun');
                }
        }
        public function gantiPassword(){
                $where = ['email'=>$this->session->userdata('email')];
                $data['info'] = $this->user->getWhere('password',$where);
                $this->form_validation->set_rules('oldpassword','Password lama','required|trim',
                                                  [
                                                    'required'=>'%s tidak boleh kosong'
                                                  ]);
                $this->form_validation->set_rules('newpassword','Password','required|trim|min_length[8]|matches[repassword]',
                                                  [
                                                    'required'=>'%s tidak boleh kosong',
                                                    'matches'=>'%s harus sama',
                                                    'min_length'=>'%s harus lebih 8 karakter'
                                                  ]);
                $this->form_validation->set_rules('repassword','Password','required|trim|matches[newpassword]',
                                                  [
                                                    'required'=>'%s tidak boleh kosong',
                                                    'matches'=>'%s harus sama'
                                                  ]);
                if($this->form_validation->run()==false){
                        $this->index();
                }else{
                  $passwordlama = md5(htmlspecialchars($this->input->post('oldpassword',true)));
                  $passwordbaru = md5(htmlspecialchars($this->input->post('newpassword',true)));
                  //ketika isi password lama tidak sama dengan password yang ada di database
                  if($data['info']['password']!=$passwordlama){
                        $this->session->set_flashdata('pesan','<script>toastr.error("Mohon masukan password lama dengan benar")</script>');
                    
                        redirect('admin/Akun');
                  }else{
                    // jika password yang baru sama dengan password lama
                    if($passwordlama==$passwordbaru){
                      $this->session->set_flashdata('pesan','<script>toastr.error("Password yang anda masukan sama dengan password sebelumnya")</script>');
                        redirect('admin/Akun');
                    }
                    // jika berhasil
                    else{
                      $newPassword = [
                        'password'=> $passwordbaru
                      ];
                      $this->user->update($newPassword,$where);
                      $this->session->set_flashdata('pesan','<script>toastr.success("Password behasil diubah")</script>');
                      redirect('admin/Akun');
                    }
                  }
                }
              }
        public function logout(){
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('id_jenis_user');
                redirect('admin/Authentikasi');
        }
}
?>