<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class KategoriBarang extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Barang');
                $this->load->model('KategoriBarangModel','kategori');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Kategori Barang";
                $data['group']="Kategori Barang";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/kategoriBarang');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function insertKategoriBarang(){
                $validation = $this->_validationKategoriBarang();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $data = [
                                "nama"=>htmlspecialchars($this->input->post('nama',true)),
                                'url'=>makeSlug(htmlspecialchars($this->input->post('nama',true)))
                        ];
                        // proses insert data
                        if($id == ""){
                                $this->kategori->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->kategori->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationKategoriBarang(){
                $result['status']=1;
                $this->form_validation->set_rules('nama', 'Kategori Barang', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getKategori(){
                header('Content-Type: application/json');
                $data = $this->kategori->getAllKategori();
                echo $data;
        }

        public function deleteKategoriBarang(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->kategori->delete($where);
                $result['pesan'] = "berhasil";
                echo json_encode($result);
        }

        public function ambilByIdKategoriBarang(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->kategori->getWhere('*',$where);
            echo json_encode($result);
        }

}
?>