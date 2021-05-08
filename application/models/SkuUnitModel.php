<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SkuUnitModel extends MY_Model {
    var $table = 'tbl_sku_unit';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getKategori(){
        $this->db->select($this->table.'.id,nama as kategori,tipe,name_element,'.$this->table.'.id_kategori_variant');
        $this->db->from($this->table);
        $this->db->group_by('id_kategori_variant');
        $this->db->join('tbl_kategori_variant',$this->table.'.id_kategori_variant = tbl_kategori_variant.id');
        return $this->db->get()->result_array();
    }
    public function getKategoriByIdBarang($idBarang){
        $this->db->select($this->table.'.id,nama as kategori,tipe,name_element,'.$this->table.'.id_kategori_variant');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        $this->db->group_by('id_kategori_variant');
        $this->db->join('tbl_kategori_variant',$this->table.'.id_kategori_variant = tbl_kategori_variant.id');
        return $this->db->get()->result_array();
    }
    public function getVariant($idBarang,$idKategoriVariant){
        $this->db->select('nama,tbl_variant.id_kategori_variant,tbl_variant.id,kode_warna');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        $this->db->where('tbl_variant.id_kategori_variant',$idKategoriVariant);
        $this->db->group_by('id_variant');
        $this->db->join('tbl_variant',$this->table.'.id_variant = tbl_variant.id');
        return $this->db->get()->result_array();
    }
    public function getJumlahBarang($idBarang,$idKategoriVariant,$idVariant){
        return $this->db->query(
            "SELECT id_sku FROM `tbl_sku_unit` where id_barang = $idBarang and id_variant in ($idVariant) and id_kategori_variant in ($idKategoriVariant) and id_sku in ( select id_sku from tbl_sku_unit where id_barang = $idBarang and id_variant in ($idVariant) and id_kategori_variant in ($idKategoriVariant) GROUP BY id_sku HAVING COUNT(*) > 1)"
        )->row_array();
    }
    public function getJumlahBarangFor1Variant($idSku){
       
    }
    public function getSelect($idBarang,$idKategoriVariant){
        $this->db->select('id_variant');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        $this->db->where('id_kategori_variant',$idKategoriVariant);
        $this->db->group_by('id_variant');
        return $this->db->get()->result_array();
    }
}