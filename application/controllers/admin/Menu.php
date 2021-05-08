<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Menu');
                $this->load->model('MenuModel','menu');
                $this->load->model('SubmenuModel','submenu');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Menu";
                $data['group']="Menu";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/menu/menu');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function insertMenu(){
                $validation = $this->_validationMenu();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $data = [
                                "nama"=>htmlspecialchars($this->input->post('nama',true))
                        ];
                        // proses insert data
                        if($id == ""){
                                $this->menu->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->menu->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationMenu(){
                $result['status']=1;
                $this->form_validation->set_rules('nama', 'Nama menu', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getMenu(){
                header('Content-Type: application/json');
                $data = $this->menu->getAllMenu();
                echo $data;
        }

        public function deleteMenu(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->menu->delete($where);
                $result['pesan'] = "berhasil";
		        echo json_encode($result);
        }
        public function ambilByIdMenu(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->menu->getWhere('*',$where);
            echo json_encode($result);
        }
        public function Submenu(){
            $data['judul']="Submenu";
            $data['group']="Submenu";
            $data['menu'] = $this->menu->getAll();
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/menu/submenu');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
        }
        public function insertSubmenu(){
                $validation = $this->_validationSubmenu();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $data = [
                                "judul"=>htmlspecialchars($this->input->post('submenu',true)),
                                "id_menu"=>htmlspecialchars($this->input->post('menu',true)),
                                "url"=>htmlspecialchars($this->input->post('url',true)),
                                "icon"=>htmlspecialchars($this->input->post('icon',true)),
                                "aktif"=>htmlspecialchars($this->input->post('status',true))
                        ];
                        // proses insert data
                        if($id == ""){
                                $this->submenu->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->submenu->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationSubmenu(){
                $result['status']=1;
                $this->form_validation->set_rules('submenu', 'Submenu', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                $this->form_validation->set_rules('url', 'URL', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                $this->form_validation->set_rules('icon', 'Icon', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errorsubmenu'] = bersihKalimatError('submenu');
                        $result['errorurl'] = bersihKalimatError('url');
                        $result['erroricon'] = bersihKalimatError('icon');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getSubMenu(){
                header('Content-Type: application/json');
                $data = $this->submenu->getAllSubmenu();
                echo $data;
        }

        public function deleteSubmenu(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->submenu->delete($where);
                $result['pesan'] = "berhasil";
		        echo json_encode($result);
        }
        public function ambilByIdSubmenu(){
            $id=$this->input->post('id');
            $where = ['id'=>$id];
            $result = $this->submenu->getWhere('*',$where);
            echo json_encode($result);
        }
}
?>