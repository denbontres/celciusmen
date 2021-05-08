<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected $table;
    
    public function __construct($table){
        $this->table = $table;
    }

    //fungsi untuk memasukan data kedalam tabel
    public function insert($data){
        $this->db->insert($this->table,$data);
    }

    //fungsi untuk mengupdate data yang ada ditabel
    public function update($data,$where){
        $this->db->update($this->table,$data,$where);
    }

    //fungsi untuk mengambil semua field yang ada ditabel
    public function getAll(){
        return $this->db->get($this->table)->result_array();
    }

    //fungsi untuk mengambil sebagian field yang ada ditabel
    public function getInfo($select){
        $this->db->select($select);
        return $this->db->get($this->table)->result_array();
    }

    //fungsi untuk mengambil field yang ada di tabel menggunakan where
    public function getWhere($select,$where){
        $hasil;
        /**
         * Jika yang diselect tidak ada maka tampilkan semua field,
         * Tapi jika ada yang diselect maka tampilkan apa yang ingin diselect
        */
        if($select==""){
            $hasil = $this->db->get_where($this->table,$where)->row_array();
        }else{
            $this->db->select($select);
            $hasil = $this->db->get_where($this->table,$where)->row_array();
        }
        return $hasil;
    }

    public function getAllRow(){
        return $this->db->get($this->table)->row_array();
    }
    public function getRow($select){
        $this->db->select($select);
        return $this->db->get($this->table)->row_array();
    }

    public function getAllWhere($select,$where){
        $hasil;
        /**
         * Jika yang diselect tidak ada maka tampilkan semua field,
         * Tapi jika ada yang diselect maka tampilkan apa yang ingin diselect
        */
        if($select==""){
            $hasil = $this->db->get_where($this->table,$where)->result_array();
        }else{
            $this->db->select($select);
            $hasil = $this->db->get_where($this->table,$where)->result_array();
        }
        return $hasil;
    }
    public function getSumWhere($select,$where){
        $this->db->select_sum($select);
        return $this->db->get_where($this->table,$where)->row_array();
    }
    
    public function getWhereIn($select,$id,$where){
        $this->db->select($select);
        $this->db->where_in($id,$where);
        return $this->db->get($this->table)->result_array();
    }

    public function getOrderWithLimit($select,$field,$tipe,$limit){
        $this->db->select($select);
        $this->db->order_by($field,$tipe);
        $this->db->limit($limit);
        return $this->db->get($this->table)->result_array();
    }
    //fungsi untuk mengahapus data yang ada ditabel
    public function delete($where){
        $this->db->delete($this->table,$where);
    }
    public function getCountRowWhere($where){
        return $this->db->get_where($this->table,$where)->num_rows();
    }
    public function getCountRow(){
        return $this->db->get($this->table)->num_rows();
    }
}