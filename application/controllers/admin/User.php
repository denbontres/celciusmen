<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('UserModel','user');
        $this->load->model('JenisUserModel','jenis');
        $this->load->model('TokenModel','token');
        $this->load->model('MenuModel','menu');
        $this->load->library('datatables'); 
        is_logged_in('User');
    }
    
    public function index(){
        $data['judul'] = "User"; 
        $data['group'] = "User"; 
        $data['user'] = $this->user->getDetailUser();
        $data['jenis'] = $this->jenis->getAllWhere('*',['id!='=>4]); 
        $this->load->view('backend/template/header',$data);        
        $this->load->view('backend/template/sidebar');        
        $this->load->view('backend/user/user');        
        $this->load->view('backend/template/footer');        
        $this->load->view('backend/template/script');      
    }

    public function insertUser(){
        $validation = $this->_validationUser();
        if($validation['status']==0){
            $validation['pesan'] = "Gagal";
        }else{
            $id = htmlspecialchars($this->input->post('id'));
            $foto = addGambar('./foto_user/',"foto");
            $email = htmlspecialchars($this->input->post('email',true));
            $password = htmlspecialchars($this->input->post('password',true));
            $data = [
                        "nama"=>htmlspecialchars($this->input->post('nama',true)),
                        "email"=>$email,
                        'jekel'=>htmlspecialchars($this->input->post('jekel',true)),
                        'id_jenis_user'=>htmlspecialchars($this->input->post('jenis',true)),
                        'notelpon'=>htmlspecialchars($this->input->post('notelpon',true)),
                        'alamat'=>htmlspecialchars($this->input->post('alamat',true))
                    ];
            // proses insert data
            if($id == ""){
                $upload_image = $_FILES['foto']['name'];
                $validation = $this->_validationPassword();
                $validation = $this->_validationEmail();
                if($upload_image==""){
                    $validation['errorfoto']="Foto harus diisi";
                    $validation['status'] = 0;
                    $validation['pesan'] = "Gagal";
                }else{
                    $data['password'] = md5($password);
                    $data['foto'] = $foto;
                }
                if($validation['status'] != 0){
                    $data['tgl_daftar'] = date('Y-m-d');
                    $this->user->insert($data);
                    $validation['pesan'] = "Berhasil";
                }
                // proses update data        
            }else{
                $where = ['id'=>$id];
                    $upload_image1= $_FILES['foto']['name'];
                    // kalau gambar di ganti maka gambar lama dihapus
                    if($upload_image1!=""){
                        $gambar = $this->user->getWhere('foto',$where);
                        deleteGambar('foto_user/',$gambar['foto']);
                        $data['foto'] = $foto;
                    }
                    if($password !=""){
                        $this->_validationPassword();
                        $data['password'] = md5($password);
                    }if($email !=""){
                        $this->_validationEmail();
                        $data['email'] = $email;
                    }
                    $this->user->update($data,$where);
                    $validation['pesan'] = "Berhasil";
                }
        }
        echo json_encode($validation);
    }

    private function _validationUser(){
        $result['status']=1;
        $this->form_validation->set_rules('nama', 'Nama', 'required',
                                        [
                                            'required'=>"%s harus diisi"    
                                        ]);
        
        $this->form_validation->set_rules('notelpon', 'Nomor telpon', 'required|numeric',
                                        [
                                            'required'=>"%s harus diisi",
                                            'numeric'=>'%s harus angka'    
                                        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required',
                                        [
                                            'required'=>"%s harus diisi"   
                                        ]);
                                        
        if ($this->form_validation->run() ==FALSE) {
            $result['errornama'] = bersihKalimatError('nama');
            $result['errornotelpon'] = bersihKalimatError('notelpon');
            $result['erroralamat'] = bersihKalimatError('alamat');
            $result['status']=0;
        }
        return $result;  
    }
    
    public function _validationEmail(){
        $result['status']=1;
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_user.email]',
                                        [
                                            'required'=>"%s harus diisi",
                                            'valid_email'=>'%s tidak valid',
                                            'is_unique'=>'%s sudah digunakan'    
                                        ]);
        if($this->form_validation->run() ==FALSE) {
            $result['erroremail'] = bersihKalimatError('email');
            $result['status']=0;
            $result['pesan'] = "Gagal";
        }
        return $result; 
    }

    public function _validationPassword(){
        $result['status']=1;
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]',
                                        [
                                            'required'=>"%s harus diisi",
                                            'min_length'=>'%s minimal harus 8 charakter'    
                                        ]);
        if($this->form_validation->run() ==FALSE) {
            $result['errorpassword'] = bersihKalimatError('password');
            $result['status']=0;
            $result['pesan'] = "Gagal";
        }
        return $result;  
    }

    public function getUser(){
        header('Content-Type: application/json');
        $data = $this->user->getAllUser();
        echo $data;
    }

    public function deleteUser(){
        $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
        $gambar = $this->user->getWhere('foto',$where);
        deleteGambar('foto_user/',$gambar['foto']);
        $this->user->delete($where);
        $result['pesan'] = "berhasil";
        echo json_encode($result);
    }
    public function ambilByIdUser(){
        $id=$this->input->post('id');
        $where = ['id'=>$id];
        $result = $this->user->getWhere('*',$where);
        echo json_encode($result);
    }

    public function JenisUser(){
        $data['judul']="Jenis User";
        $data['group'] = "Jenis User"; 
        $this->load->view('backend/template/header',$data);        
        $this->load->view('backend/template/sidebar');        
        $this->load->view('backend/user/jenisuser');        
        $this->load->view('backend/template/footer');        
        $this->load->view('backend/template/script');        
    }

    public function insertJenisUser(){
        $validation = $this->_validationJenisUser();
        if($validation['status']==0){
                $validation['pesan'] = "Gagal";
        }else{
                $id = htmlspecialchars($this->input->post('id'));
                $data = [
                        "nama"=>htmlspecialchars($this->input->post('nama',true))
                ];
                // proses insert data
                if($id == ""){
                        $this->jenis->insert($data);
                // proses update data        
                }else{
                        $where = ['id'=>$id];
                        $this->jenis->update($data,$where);
                }
                $validation['pesan'] = "Berhasil";
        }
        echo json_encode($validation);
    }

    private function _validationJenisUser(){
        $result['status']=1;
        $this->form_validation->set_rules('nama', 'Jenis', 'required',
                                        [
                                            'required'=>"%s harus diisi"    
                                        ]);

        if ($this->form_validation->run() ==FALSE) {
                $result['errornama'] = bersihKalimatError('nama');
                $result['status']=0;
        }
        return $result;  
    }

    public function getJenis(){
            header('Content-Type: application/json');
            $data = $this->jenis->getAllJenis();
            echo $data;
    }

    public function deleteJenisUser(){
        $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
        $this->jenis->delete($where);
        $result['pesan'] = "berhasil";
        echo json_encode($result);
    }
    
    public function ambilByIdJenis(){
        $id=$this->input->post('id');
        $where = ['id'=>$id];
        $result = $this->jenis->getWhere('*',$where);
        echo json_encode($result);
    }

    public function RoleAkses($id){
        $data['judul']="Role Akses";
        $data['group'] = "Jenis User"; 
        $data['menu'] = $this->menu->getAll();
        $data['id_jenis_user']=$id;
        $where= ['id'=>$id];
        $data['jenis'] = $this->jenis->getWhere('nama',$where);
        $this->load->view('backend/template/header',$data);        
        $this->load->view('backend/template/sidebar');        
        $this->load->view('backend/user/role');        
        $this->load->view('backend/template/footer');        
        $this->load->view('backend/template/script');        
    }
    
    public function gantiAkses(){
        $idjenis = $this->input->post('idjenis');
        $idmenu = $this->input->post('idmenu');
        $data=[
            "id_jenis_user"=>$idjenis,
            "id_menu"=>$idmenu
        ];
        $result=$this->db->get_where('tbl_akses',$data);
        if($result->num_rows()<1){
            $this->db->insert('tbl_akses',$data);
        }else{
            $this->db->delete('tbl_akses',$data);
        }
    }

    public function Token(){
        $data['judul']="Token";
        $data['group'] = "Token"; 
        $this->load->view('backend/template/header',$data);        
        $this->load->view('backend/template/sidebar');        
        $this->load->view('backend/user/token');        
        $this->load->view('backend/template/footer');        
        $this->load->view('backend/template/script');        
    }

    public function getToken(){
        header('Content-Type: application/json');
        $data = $this->token->getAllToken();
        echo $data;
    }
}
