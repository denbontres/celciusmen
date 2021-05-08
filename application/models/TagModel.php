<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagModel extends MY_Model {
    var $table = 'tbl_tag';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getListTag(){
        $this->db->select('nama');
        $this->db->from($this->table);
        $this->db->where('kategori','barang');
        $this->db->limit(8);
        return $this->db->get()->result_array();
    }
}