<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengunjung extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Pengunjung');
                $this->load->model('PengunjungModel','pengunjung');
                $this->load->model('StatusModel','status');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Pengunjung";
                $data['group']="Pengunjung";
                $data['status'] = $this->status->getAll();
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/pengunjung/pengunjung');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function insertPengunjung(){
                $validation = $this->_validationPengunjung();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $data = [
                                "nama"=>htmlspecialchars($this->input->post('nama',true)),
                                "alamat"=>htmlspecialchars($this->input->post('alamat',true)),
                                "asal"=>htmlspecialchars($this->input->post('asal',true)),
                                "id_status"=>htmlspecialchars($this->input->post('status',true))
                        ];
                        // proses insert data
                        if($id == ""){
                                $this->pengunjung->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->pengunjung->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationPengunjung(){
                $result['status']=1;
                $this->form_validation->set_rules('nama', 'Nama', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                $this->form_validation->set_rules('alamat', 'Alamat', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                $this->form_validation->set_rules('asal', 'Asal', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        $result['erroralamat'] = bersihKalimatError('alamat');
                        $result['errorasal'] = bersihKalimatError('asal');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getPengunjung(){
                header('Content-Type: application/json');
                $data = $this->pengunjung->getAllPengunjung();
                echo $data;
        }

        public function deletePengunjung(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->pengunjung->delete($where);
                $result['pesan'] = "berhasil";
		        echo json_encode($result);
        }
        public function ambilByIdPengunjung(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->pengunjung->getWhere('*',$where);
            echo json_encode($result);
        }

        public function Status(){
                $data['judul']="Status";
                $data['group']="Status";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/pengunjung/status');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function insertStatus(){
                $validation = $this->_validationStatus();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $data = [
                                "status"=>htmlspecialchars($this->input->post('nama',true))
                        ];
                        // proses insert data
                        if($id == ""){
                                $this->status->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->status->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationStatus(){
                $result['status']=1;
                $this->form_validation->set_rules('nama', 'Status', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getStatus(){
                header('Content-Type: application/json');
                $data = $this->status->getAllStatus();
                echo $data;
        }

        public function deleteStatus(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->status->delete($where);
                $result['pesan'] = "berhasil";
                echo json_encode($result);
        }

        public function ambilByIdStatus(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->status->getWhere('*',$where);
            echo json_encode($result);
        }
}
?>