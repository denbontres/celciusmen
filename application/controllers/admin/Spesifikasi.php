<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Spesifikasi extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Barang');
                $this->load->model('SpesifikasiBarangModel','spesifikasi');
                $this->load->model('BarangModel','barang');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Spesifikasi Barang";
                $data['group']="Barang";
                $data['barang'] = $this->input->get('idbarang');
                $barang  = $this->barang->getWhere('nama',['id'=>$data['barang']]);
                $data['namaBarang']= $barang['nama'];
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/spesifikasi');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function insertSpesifikasiBarang(){
                $validation = $this->_validationSpesifikasiBarang();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $idBarang = htmlspecialchars($this->input->post('idBarang'));
                        $data = [
                                "nama"=>htmlspecialchars($this->input->post('nama',true)),
                                'nilai'=>makeSlug(htmlspecialchars($this->input->post('nilai',true)))
                        ];
                        // proses insert data
                        if($id == ""){
                                $data['id_barang']=$idBarang;
                                $this->spesifikasi->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->spesifikasi->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationSpesifikasiBarang(){
                $result['status']=1;
                $this->form_validation->set_rules('nama', 'Spesifikasi Barang', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                $this->form_validation->set_rules('nilai', 'Nilai', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        $result['errornilai'] = bersihKalimatError('nilai');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getSpesifikasi($idBarang){
                header('Content-Type: application/json');
                $data = $this->spesifikasi->getAllSpesifikasi($idBarang);
                echo $data;
        }

        public function deleteSpesifikasiBarang(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->spesifikasi->delete($where);
                $result['pesan'] = "berhasil";
                echo json_encode($result);
        }

        public function ambilByIdSpesifikasiBarang(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->spesifikasi->getWhere('*',$where);
            echo json_encode($result);
        }

}
?>