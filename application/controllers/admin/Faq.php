<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq extends CI_Controller {
    public function __construct(){
            parent::__construct();
            is_logged_in('Konten');
            $this->load->model('FaqModel','faq');
            $this->load->library('datatables'); 
    }

    public function index(){
            $data['judul']="Faq";
            $data['group']="Faq";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/faq/faq');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
    }
    public function insert(){
        $this->_validation();
        if($this->form_validation->run()==false){
                $data['judul']="Add Faq";
                $data['group']="Faq";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/faq/insertFaq');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }else{
                $judul = htmlspecialchars($this->input->post('judul',true));
                $data = [
                        'judul'=>$judul,
                        'isi'=>$this->input->post('isi',false),
                ];
                $this->faq->insert($data);
                $this->session->set_flashdata('pesan',"<script>toastr.success('$judul berhasil ditambahkan')</script>");
                redirect('admin/Faq');
        }
    }

    public function editFaq($id){
        $this->_validation();
        if($this->form_validation->run()==false){
                $data['judul']="Add Faq";
                $data['group']="Faq";
                $data['faq'] = $this->faq->getWhere('id,judul,isi',['id'=>$id]);
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/faq/editFaq');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }else{
                $judul = htmlspecialchars($this->input->post('judul',true));
                $data = [
                    'judul'=>$judul,
                    'isi'=>$this->input->post('isi',false),
                ];
                
                $this->faq->update($data,['id'=>$id]);
                $this->session->set_flashdata('pesan',"<script>toastr.info('Data berhasil diubah')</script>");
                redirect('admin/Faq');
        }
    }
    
    public function getFaq(){
        header('Content-Type: application/json');
        $data = $this->faq->getAllFaq();
        echo $data;
    }

    public function deleteFaq($id){
        $where = ['id'=>$id];
        $this->faq->delete(['id'=>$id]);
    }
    
    private function _validation(){
        $this->form_validation->set_rules('judul', 'Judul', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]);  

        $this->form_validation->set_rules('isi', 'Isi', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]);  
    }

}   