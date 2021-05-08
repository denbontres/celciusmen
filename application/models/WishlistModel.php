<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishlistModel extends MY_Model {
    var $table = 'tbl_wishlist';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getDataWishlist($email){
        $this->db->select($this->table.'.id,tbl_barang.nama,harga,total_harga,foto');
        $this->db->from($this->table);
        $this->db->where('email',$email); 
        $this->db->join('tbl_barang',$this->table.'.id_barang=tbl_barang.id');
        return $this->db->get()->result();
    }
    public function getAllWishlist($email){
        $this->db->select($this->table.'.id,tbl_barang.nama,total_harga,foto');
        $this->db->from($this->table);
        $this->db->where('email',$email);
        $this->db->join('tbl_barang',$this->table.'.id_barang=tbl_barang.id');
        return $this->db->get()->result();
    }
}