<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct(){
        parent::__construct();
        cekSessionUser();
        hitCounter();
        $this->load->model('BlogModel','blog');
    }

    public function index(){
        $tag = htmlspecialchars($this->input->get('tag',true));
        $kategori = htmlspecialchars($this->input->get('kategori',true));
        $search = htmlspecialchars($this->input->get('search',true));
        $config['per_page'] = 6;
        $data['start'] = ($this->input->get('per_page')?$this->input->get('per_page')-1:0) * 6;
        $url = 'Blog';
        $data['konten'] = $this->blog->getBlogWithPaginationWhere($config['per_page'],$data['start'],$tag,$kategori,$search);
        $totalRow = $this->blog->getJumlahBlogForPagination($tag,$kategori,$search);
        $this->_viewBlog($data['konten'],$config['per_page'],$url,$totalRow);
    }

    private function _viewBlog($konten,$perpage,$url,$totalRow){
        $data['title'] = 'Blog';
        $data['group'] = 'Blog';
        // pembentukan pagination, dengan jumlah konten yang ditampilkan adalah 6 per halaman
        $this->load->library('pagination');
        $config['base_url'] = base_url().$url;
        $config['total_rows'] = $totalRow;
        $config['per_page'] = $perpage;

        // mengambil daftar artikel sesuai config dari pagination
        $data['blog'] = $konten;

        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $data['kategori'] = $this->blog->getKategori();
        $data['latesArtikel'] = $this->blog->getAllLatestArtikel();
        $tags = $this->blog->getRandomTag();
        $data['uniqueTag'] = array_filter(array_unique(explode(' ', $tags)),'strlen');
        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/blog/blog');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
    }

    public function blogDetail($url){
        $data['blog'] = $this->blog->getWhere('*',['url'=>$url]);
        $data['tag'] = array_filter(array_unique(explode(' ', $data['blog']['tag'])),'strlen');
        $data['title'] = $data['blog']['judul'];
        $data['group'] = 'Blog';
        $data['related'] = $this->blog->getRelated($url,$data['blog']['kategori']);
        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/blog/blogdetail');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
    }
}