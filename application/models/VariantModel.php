<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VariantModel extends MY_Model {
    var $table = 'tbl_variant';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getListVariant($kode){
        $this->db->select('id,nama,kode_warna,kode_element');
        return $this->db->get_where($this->table,['id_kategori_variant'=>$kode],8)->result_array();
    }
    public function getCountListVariant($kode){
        $this->db->select('id');
        return $this->db->get_where($this->table,['id_kategori_variant'=>$kode],8)->num_rows();
    }
    public function getAllVariant(){
        $this->datatables->select($this->table.'.id,kode_warna,'.$this->table.'.nama,tbl_kategori_variant.nama as kategori');
        $this->datatables->join('tbl_kategori_variant',$this->table. ".id_kategori_variant=tbl_kategori_variant.id");
        $this->datatables->from($this->table);
        $this->datatables->add_column('view', 
                                    '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1"><i class="fas fa-edit"></i></a>  
                                     <a href="javascript:void(0);" class="btn btn-danger item_delete" id="btn-delete" data-id="$1" data-nama="$2"><i class="fas fa-trash"></i></a> 
                                    ','id,nama');
        return $this->datatables->generate();
    }
}