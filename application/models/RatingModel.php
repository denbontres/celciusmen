<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RatingModel extends MY_Model {
    var $table = 'tbl_rating';
    public function __construct(){
        parent::__construct($this->table);
    }

    public function getRatingBarang($idBarang){
        $this->db->select('avg(rating) as rating,count(id) as jumlah');
        $this->db->from($this->table);
        $this->db->where('id_barang',$idBarang);
        $rating = $this->db->get()->row_array();
        return $rating;
    }

    public function ratingWithMessage($idBarang){
        $this->db->select('coment,waktu,rating,nama,foto');
        $this->db->from($this->table);
        $this->db->join('tbl_user',$this->table.'.id_user=tbl_user.id');
        $this->db->where('id_barang',$idBarang);
        return $this->db->get()->result_array();
    }

    public function getAllRating(){
        $this->datatables->select($this->table.'.rating,coment,nofaktur,tbl_user.nama as nama,tbl_barang.nama as barang,'.$this->table.'.id');
        $this->datatables->join('tbl_barang',$this->table. ".id_barang=tbl_barang.id");
        $this->datatables->join('tbl_user',$this->table. ".id_user=tbl_user.id");
        $this->datatables->edit_column('rating','$1','rating(rating)');
        $this->datatables->from($this->table);
        return $this->datatables->generate();
    }
}