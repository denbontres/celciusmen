<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BlogModel extends MY_Model {
    var $table = 'tbl_blog';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getListArtikelForHome(){
        $this->db->select('id,url,photo,judul,deskripsi,waktu');
        $this->db->from($this->table);
        $this->db->limit(3);
        return $this->db->get()->result_array();
    }
    public function getKategori(){
        $this->db->select('kategori');
        $this->db->from($this->table);
        $this->db->group_by('kategori');
        return $this->db->get()->result_array();
    }
    public function getAllLatestArtikel(){
        $this->db->select('judul,kategori,url,waktu,photo');
        $this->db->from($this->table);
        $this->db->order_by('id','desc');
        $this->db->limit(4);
        return $this->db->get()->result_array();
    }
    public function getRandomTag(){
        $tags = $this->db->query("SELECT REPLACE(GROUP_CONCAT(DISTINCT tag SEPARATOR ','),',',' ') as tags FROM $this->table WHERE 1 ORDER BY RAND() LIMIT 10
        ")->row_array();
        return $tags['tags'];
    }
    public function getBlogWithPaginationWhere($limit,$start,$tag,$kontenKategori,$search){
        $this->db->select('judul,kategori,url,waktu,photo');
        if($tag){
            $this->db->like('tag',$tag);
        }
        if($kontenKategori){
            $this->db->where('kategori',$kontenKategori);
        }
        if($search){
            $this->db->like('judul',$search);
        }
        $this->db->from($this->table);
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }
    
    public function getJumlahBlogForPagination($tag,$kontenKategori,$search){
        $this->db->select($this->table.'.id');
        if($tag){
            $this->db->like('tag',$tag);
        }
        if($kontenKategori){
            $this->db->where('kategori',$kontenKategori);
        }
        if($search){
            $this->db->like('judul',$search);
        }
        $this->db->from($this->table);
        return $this->db->get()->num_rows();
    }

    public function getRelated($url,$kategori){
        $this->db->select('id,judul,photo,url');
        $this->db->from($this->table);
        $this->db->order_by('id','desc');
        $this->db->limit(3);
        $this->db->where('url !=',$url);
        $this->db->where('kategori',$kategori);
        return $this->db->get()->result_array();
    }
    public function getAllBlog(){
        $this->datatables->select($this->table.'.id,judul,deskripsi,kategori');
        $this->datatables->from($this->table);
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Blog/editBlog/').'$1" class="btn btn-success" ><i class="fas fa-edit"></i></a>  
        <a href="javascript:;" class="btn btn-danger item_delete" data-id="$1" data-nama="$2"><i class="fas fa-trash"></i></a> 
        ','id,judul');
        return $this->datatables->generate();
    }
}