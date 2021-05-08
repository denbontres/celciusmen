<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Variant extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Barang');
                $this->load->model('VariantModel','variant');
                $this->load->model('KategoriVariantModel','kategori');
                $this->load->library('datatables'); 
        }

        public function index(){
            $data['judul']="Variant";
            $data['group']="Variant";
            $data['kategori'] = $this->kategori->getAll();
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/barang/variant');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
        }
        public function insertVariant(){
                $idKategori = htmlspecialchars($this->input->post('kategori',true));
                $validation = $this->_validationvariant($idKategori);
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        
                        $nama = htmlspecialchars($this->input->post('nama',true));
                        $data = [
                                "nama"=>$nama,
                                "id_kategori_variant"=>$idKategori,
                        ];
                        if($idKategori == 2 ){
                            $data['kode_warna'] = $this->input->post('warna',true);
                            $data['kode_element'] = str_replace(" ","",strtolower($nama));
                        }
                        // proses insert data
                        if($id == ""){
                                $this->variant->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->variant->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationvariant($idKategori){
                $result['status']=1;
                if($idKategori == 3){
                        $this->form_validation->set_rules('nama', 'Nama', 'required|numeric',
                                                [
                                                        'required'=>"%s harus diisi" ,   
                                                        'numeric'=>'%s harus angka'   
                                                ]);   
                }else{
                        $this->form_validation->set_rules('nama', 'Nama', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                }
                if($idKategori == 2){
                    $this->form_validation->set_rules('warna', 'Warna', 'required',
                                                [
                                                    'required'=>"%s harus diisi",
                                                ]);
                }
                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        if($idKategori == 2){
                            $result['errorwarna'] = bersihKalimatError('warna');
                        }
                        
                        $result['status']=0;
                }
                return $result;  
        }

        public function getVariant(){
                header('Content-Type: application/json');
                $data = $this->variant->getAllVariant();
                echo $data;
        }

        public function deletevariant(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->variant->delete($where);
                $result['pesan'] = "berhasil";
		        echo json_encode($result);
        }
        public function ambilByIdvariant(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->variant->getWhere('*',$where);
            echo json_encode($result);
        }
}
?>