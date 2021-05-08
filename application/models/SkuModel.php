<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SkuModel extends MY_Model {
    var $table = 'tbl_sku';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getBarangBySku($sku){
        $this->db->select('total_harga,berat,id_barang,jumlah,'.$this->table.'.kode as sku,tbl_barang.nama as nama_barang,'.$this->table.'.nama');
        $this->db->from($this->table);
        $this->db->where($this->table.'.id',$sku);
        $this->db->join('tbl_barang',$this->table.'.id_barang=tbl_barang.id');
        return $this->db->get()->row_array();
    }
    public function getJumlahDanHarga($sku){
        $this->db->select('total_harga,jumlah');
        $this->db->from($this->table);
        $this->db->where($this->table.'.kode',$sku);
        $this->db->join('tbl_barang',$this->table.'.id_barang=tbl_barang.id');
        return $this->db->get()->row_array();
    }
    public function getSkuNotInputJumlah($idBarang,$listName){
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        foreach($listName as $r){
            $this->db->where('nama !=',$r);
        }
        return $this->db->get()->result_array();
    }
}