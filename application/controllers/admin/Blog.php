<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller {
    public function __construct(){
            parent::__construct();
            is_logged_in('Konten');
            $this->load->model('BlogModel','blog');
            $this->load->library('datatables'); 
    }

    public function index(){
            $data['judul']="Blog";
            $data['group']="Blog";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/blog/blog');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
    }
    public function insert(){
        $foto = isset($_FILES['foto']['name'])?$_FILES['foto']['name']:'';
        $this->_validation($foto);
        if($this->form_validation->run()==false){
                $data['judul']="Add Blog";
                $data['group']="Blog";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/blog/insertBlog');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }else{
                $judul = htmlspecialchars($this->input->post('judul',true));
                $url = $this->_seoFriendlyUrl($judul);
                $data = [
                        'judul'=>$judul,
                        'isi'=>$this->input->post('isi',false),
                        'deskripsi'=>htmlspecialchars($this->input->post('deskripsi',true)),
                        'tag'=>htmlspecialchars($this->input->post('tag',true)),
                        'url'=>$url,
                        'kategori'=>htmlspecialchars($this->input->post('kategori',true)),
                ];
                if($foto){
                        // config upload file
                        $foto = addGambar('./resource/',"foto"); 
                        $data['photo'] = $foto;
                }
                $this->blog->insert($data);
                $this->session->set_flashdata('pesan',"<script>toastr.success('$judul berhasil ditambahkan')</script>");
                redirect('admin/Blog');
        }
    }

    public function editBlog($id){
        $foto = isset($_FILES['foto']['name'])?$_FILES['foto']['name']:'';
        $this->_validation($foto);
        if($this->form_validation->run()==false){
                $data['judul']="Add Blog";
                $data['group']="Blog";
                $data['blog'] = $this->blog->getWhere('id,judul,isi,kategori,deskripsi,tag,photo',['id'=>$id]);
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/blog/editBlog');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }else{
                $judul = htmlspecialchars($this->input->post('judul',true));
                $url = $this->_seoFriendlyUrl($judul);
                $data = [
                    'judul'=>$judul,
                    'isi'=>$this->input->post('isi',false),
                    'deskripsi'=>htmlspecialchars($this->input->post('deskripsi',true)),
                    'tag'=>htmlspecialchars($this->input->post('tag',true)),
                    'url'=>$url,
                    'kategori'=>htmlspecialchars($this->input->post('kategori',true)),
                ];
                
                if($foto){
                        $blog = $this->blog->getWhere('photo',['id'=>$id]);
                        $blog['foto']?deleteGambar('resource/',$blog['foto']):'';
                        $foto = addGambar('./resource/',"foto");
                        $data['foto'] = $foto;
                }
                $this->blog->update($data,['id'=>$id]);
                $this->session->set_flashdata('pesan',"<script>toastr.info('Data berhasil diubah')</script>");
                redirect('admin/Blog');
        }
    }
    
    public function getBlog(){
        header('Content-Type: application/json');
        $data = $this->blog->getAllBlog();
        echo $data;
    }

    public function deleteBlog($id){
        $where = ['id'=>$id];
        $photo = $this->blog->getWhere('foto',$where);
        deleteGambar('resource/',$photo['foto']);
        $this->blog->delete(['id'=>$id]);
    }
    
    private function _validation($foto){
        $this->form_validation->set_rules('judul', 'Judul', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]);  

        $this->form_validation->set_rules('isi', 'Isi', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]);  

        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]);  
        $this->form_validation->set_rules('tag', 'Tag', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]); 
        $this->form_validation->set_rules('kategori', 'Kategori', 'required',
                                                [
                                                        'required'=>"%s harus diisi"
                                                ]); 
        
        if($foto){
                $this->form_validation->set_rules('foto','Foto','callback_validateSize|callback_validateTypeFile',
                                        [
                                                'validateTypeFile'=>'%s harus format JPG atau PNG',
                                                'validateSize'=>'%s hanya boleh dibawah 1 Mb'
                                        ]);
        }
    }

    private function _seoFriendlyUrl($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-')).'.html';
    }

    function validateTypeFile(){
        $allowed = array('png', 'jpg','JPG','PNG');
        $filename = $_FILES['foto']['name'];
        if($filename){
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                return false;
            }else{
                return true;
            }
        }
    }

    function validateSize(){
        $filename = $_FILES['foto']['name'];
        if($filename){
            if($_FILES['foto']['size'] > (1024*1000)){
                return false;
            }else{
                return true;
            }
        } 
    }

    function requiredImg(){
        $filename = $_FILES['foto']['name'];
        if($filename){
          return true;
        }else{
            return false;
        } 
    }

}   