<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VariantSelectModel extends MY_Model {
    var $table = 'tbl_variant_select';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getSelect($idBarang){
        $this->db->select('id_kategori_variant,nama');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        $this->db->join('tbl_kategori_variant',$this->table.'.id_kategori_variant=tbl_kategori_variant.id');
        return $this->db->get()->result_array();
    }

    public function getVariantSelect($idBarang){
        $this->db->select('id_kategori_variant,nama');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        $this->db->join('tbl_kategori_variant',$this->table.'.id_kategori_variant=tbl_kategori_variant.id');
        return $this->db->get()->result_array();
    }
}