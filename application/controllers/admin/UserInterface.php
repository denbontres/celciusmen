<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserInterface extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Userinterface');
                $this->load->library('datatables'); 
                $this->load->model('BasicModel','basic');
                $this->load->model('BrandModel','brand');
                $this->load->model('SlideModel','slide');
        }
        function validateTypeFile($input,$name){
                $allowed = array('JPG','jpg','JPEG','jpeg','PNG','png');
                $filename = $_FILES[$name]['name'];
                if($filename){
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                                return false;
                        }else{
                                return true;
                        }
                }
        }

        function validateSize($input,$name){
                $filename = $_FILES[$name]['name'];
                if($filename){
                        if($_FILES[$name]['size'] > (1024*1000)){
                                return false;
                        }else{
                                return true;
                        }
                } 
        }

        function requiredFile($input,$name){
                $filename = $_FILES[$name]['name'];
                if($filename){
                        return true;
                }else{
                        return false;
                } 
        }

        public function index(){
                $this->form_validation->set_rules('nama','Nama','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('alamat','Alamat','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('notelpon','Nomor telpon','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('deskripsi','Deskripsi','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('url','URL Midtrans','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('sandbox','PRODUCTION / SANDBOX','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('rajaongkir','Key api raja ongkir','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('midtrans','Mindtrans key','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('email','Email','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('map','Map','required',
                                                [
                                                'required'=>'%s tidak boleh kosong'
                                                ]);
                $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]',
                                                [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                ]);
                $this->form_validation->set_rules('foto2','Foto','callback_validateSize[foto2]|callback_validateTypeFile[foto2]',
                                                [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                ]);

                if($this->form_validation->run()==false){
                    $data['judul']="Dasar";
                    $data['group']="Dasar";
                    $data['basic'] = $this->basic->getAll();
                    $data['rajaongkir'] = $this->getRajaOngkir('provinsi');
                    $data['kota'] = getKotaProvinsi('kota',$data['basic'][0]['kota']);
                    $data['provinsi'] = getKotaProvinsi('provinsi',$data['basic'][0]['provinsi']);
                    $this->load->view('backend/template/header',$data);        
                    $this->load->view('backend/template/sidebar');        
                    $this->load->view('backend/userinterface/basic');        
                    $this->load->view('backend/template/footer');        
                    $this->load->view('backend/template/script');        
                }else{
                    $data = [
                        "nama_toko"=>htmlspecialchars($this->input->post('nama'),true),
                        "alamat"=>htmlspecialchars($this->input->post('alamat'),true),
                        "email"=>htmlspecialchars($this->input->post('email'),true),
                        "notelp"=>htmlspecialchars($this->input->post('notelpon'),true),
                        "deskripsi"=>htmlspecialchars($this->input->post('deskripsi'),true),
                        "map"=>$this->input->post('map'),
                        "facebook"=>htmlspecialchars($this->input->post('facebook'),true),
                        "twitter"=>htmlspecialchars($this->input->post('twitter'),true),
                        "linkin"=>htmlspecialchars($this->input->post('linkin'),true),
                        "youtube"=>htmlspecialchars($this->input->post('youtube'),true),
                        "rajaongkir"=>htmlspecialchars($this->input->post('rajaongkir'),true),
                        "midtrans"=>htmlspecialchars($this->input->post('midtrans'),true),
                        "midtrans_url"=>$this->input->post('url'),
                        "sandbox"=>htmlspecialchars($this->input->post('sandbox'),true),
                        "midtrans"=>htmlspecialchars($this->input->post('midtrans'),true),
                    ];
                    $upload_image = $_FILES['foto']['name'];
                    $upload_image2 = $_FILES['foto2']['name'];
                    
                    $provinsi=htmlspecialchars($this->input->post('provinsi'),true);
                    $kota=htmlspecialchars($this->input->post('kota'),true);

                    if($provinsi !=""){
                        $data['provinsi']= $provinsi;
                    }
                    if($kota !=""){
                        $data['kota'] = $kota;
                    }
                    $where = ["id"=>1];
                    if($upload_image!=""){
                        $image = $this->basic->getWhere('logo',$where);
                        deleteGambar('resource',$image['logo']);
                        $foto = addGambar('./resource','foto');
                        $data['logo']=$foto;
                    }
                    if($upload_image2!=""){
                        $image = $this->basic->getWhere('footer_logo',$where);
                        deleteGambar('resource',$image['footer_logo']);
                        $foto2 = addGambar('./resource','foto2');
                        $data['footer_logo']=$foto2;
                    }
                    $this->basic->update($data,$where);
                    $this->session->set_flashdata('pesan','<script>toastr.info("Data behasil diubah")</script>');
                    redirect('admin/UserInterface/');
                }
        }

        public function getKota(){
            $data= $this->getRajaOngkir('kota');
            echo json_encode($data);
        }

        public function getRajaOngkir($status){
            $curl = curl_init();
            if($status == 'kota'){
                $id = $this->input->post('id');
                $url = 'https://api.rajaongkir.com/starter/city?province='.$id;
            }else{
                $url = 'https://api.rajaongkir.com/starter/province';
            }
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 0b639a34e05261cd03dbd3ae40c4b197"
            ),
            ));
    
            $response = json_decode(curl_exec($curl),true);
            $i=0;
            
            for($i;$i< count($response['rajaongkir']['results']);$i++){
                
                if($status=='kota'){
                    $data[$i] = [
                        'nama_kota'=>$response['rajaongkir']['results'][$i]['city_name'],
                        'id_kota'=>$response['rajaongkir']['results'][$i]['city_id']
                    ];	
                }else{
                    $data[$i] = [
                        'id_provinsi'=>$response['rajaongkir']['results'][$i]['province_id'],
                        'nama_provinsi'=>$response['rajaongkir']['results'][$i]['province'],
                    ];
                }
            }
    
            $err = curl_error($curl);
            curl_close($curl);
            return $data;
        }
        
        public function Brand(){
            $data['judul']="Brand";
            $data['group']="Brand";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/userinterface/brand');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
        }

        public function insertBrand(){
            $id = htmlspecialchars($this->input->post('id'));
            $validation = $this->_validationBrand($id);
            if($validation['status']==0){
                    $validation['pesan'] = "Gagal";
            }else{
                    $foto = addGambar('./resource/',"foto");
                    $data = [
                            "nama"=>htmlspecialchars($this->input->post('nama',true)),
                    ];
                    // proses insert data
                    if($id == ""){
                            $upload_image = $_FILES['foto']['name'];
                            if($upload_image==""){
                                    $validation['errorfoto']="Foto harus diisi";
                                    $validation['status'] = 0;
                                    $validation['pesan'] = "Gagal";
                            }else{
                                    $data['foto'] = $foto;
                                    $this->brand->insert($data);
                                    $validation['pesan'] = "Berhasil";
                            }
                    // proses update data        
                    }else{
                            $where = ['id'=>$id];
                            $upload_image1= $_FILES['foto']['name'];
                            // kalau gambar di ganti maka gambar lama dihapus
                            if($upload_image1!=""){
                                    $gambar = $this->brand->getWhere('foto',$where);
                                    deleteGambar('resource/',$gambar['foto']);
                                    $data['foto'] = $foto;
                            }
                            $this->brand->update($data,$where);
                            $validation['pesan'] = "Berhasil";
                    }
            }
            echo json_encode($validation);
        }

        private function _validationBrand($id){
            $result['status']=1;
            $this->form_validation->set_rules('nama', 'Nama Brand', 'required',
                                            [
                                                'required'=>"%s harus diisi"    
                                            ]);
            if(!$id){
                $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]|callback_requiredFile[foto]',
                                            [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                    'requiredFile'=>'%s tidak boleh kosong'
                                            ]);
            }else{
                $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]',
                                            [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                            ]);
            }

            if ($this->form_validation->run() ==FALSE) {
                    $result['errornama'] = bersihKalimatError('nama');
                    $result['errorfoto'] = bersihKalimatError('foto');
                    $result['status']=0;
                }
            return $result;  
        }

        public function getBrand(){
            header('Content-Type: application/json');
            $data = $this->brand->getAllBrand();
            echo $data;
        }

        public function deleteBrand(){
            $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
            $gambar = $this->brand->getWhere('foto',$where);
            deleteGambar('resource/',$gambar['foto']);
            $this->brand->delete($where);
            $result['pesan'] = "berhasil";
            echo json_encode($result);
        }

        public function ambilByIdBrand(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->brand->getWhere('*',$where);
            echo json_encode($result);
        }
        public function Slide(){
            $data['judul']="Slide";
            $data['group']="Slide";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/userinterface/slide');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
        }

        public function insertSlide(){ 
            $kategori = htmlspecialchars($this->input->post('kategori'));
            $id = htmlspecialchars($this->input->post('id'));
            $validation = $this->_validationSlide($kategori,$id);
            if($validation['status']==0){
                    $validation['pesan'] = "Gagal";
            }
            else{
                    $foto = addGambar('./resource/',"foto");
                    $data = [
                            "judul"=>htmlspecialchars($this->input->post('judul',true)),
                            "sub_judul"=>htmlspecialchars($this->input->post('subjudul',true)),
                            "kategori"=>$kategori,
                            "url"=>htmlspecialchars($this->input->post('url',true))
                    ];
                    if($kategori == "Diskon"){
                        $data['diskon']= htmlspecialchars($this->input->post('diskon',true));
                        $data['button_text'] = 'SHOP NOW';
                    }else{
                        $data['diskon'] = 0;
                        $data['button_text'] = 'SEE MORE';
                    }
                    
                    // proses insert data
                    if($id == ""){
                        $data['foto'] = $foto;
                        $this->slide->insert($data);
                    // proses update data        
                    }else{
                            $where = ['id'=>$id];
                            $upload_image1= $_FILES['foto']['name'];
                            // kalau gambar di ganti maka gambar lama dihapus
                            if($upload_image1!=""){
                                    $gambar = $this->slide->getWhere('foto',$where);
                                    deleteGambar('resource/',$gambar['foto']);
                                    $data['foto'] = $foto;
                            }
                            $this->slide->update($data,$where);
                            $validation['pesan'] = "Berhasil";
                    }
            }
            echo json_encode($validation);
        }

        private function _validationSlide($kategori,$id){
            $result['status']=1;
            $this->form_validation->set_rules('judul', 'Judul', 'required',
                                            [
                                                'required'=>"%s harus diisi"    
                                            ]);
            $this->form_validation->set_rules('subjudul', 'Subjudul', 'required',
                                            [
                                                'required'=>"%s harus diisi"    
                                            ]);
            $this->form_validation->set_rules('url', 'Url', 'required',
                                            [
                                                'required'=>"%s harus diisi"    
                                            ]);
            if(!$id){
            $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]|callback_requiredFile[foto]',
                                            [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                    'requiredFile'=>'%s tidak boleh kosong'
                                            ]);
            }else{
                $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]',
                                            [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                            ]);
            }
            if($kategori =="Diskon"){
                $this->form_validation->set_rules('diskon', 'diskon', 'required|numeric',
                                            [
                                                'required'=>"%s harus diisi",    
                                                'numeric'=>"%s isi dengan angka",   
                                            ]);
            }
            if ($this->form_validation->run() ==FALSE) {
                    $result['errorjudul'] = bersihKalimatError('judul');
                    $result['errorsubjudul'] = bersihKalimatError('subjudul');
                    $result['errorurl'] = bersihKalimatError('url');
                    $result['errorfoto'] = bersihKalimatError('foto');
                    if($kategori == "Diskon"){
                        $result['errordiskon'] = bersihKalimatError('diskon');
                    }
                    $result['status']=0;
            }
            return $result;  
        }

        public function getSlide(){
            header('Content-Type: application/json');
            $data = $this->slide->getAllSlide();
            echo $data;
        }

        public function deleteSlide(){
            $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
            $gambar = $this->slide->getWhere('foto',$where);
            deleteGambar('resource/',$gambar['foto']);
            $this->slide->delete($where);
            $result['pesan'] = "berhasil";
            echo json_encode($result);
        }

        public function ambilByIdSlide(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->slide->getWhere('*',$where);
            echo json_encode($result);
        }
        
    }
?>