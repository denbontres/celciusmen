<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriVariantModel extends MY_Model {
    var $table = 'tbl_kategori_variant';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getAllKategori(){
        $this->datatables->select('id,nama,tipe');
        $this->datatables->from($this->table);
        return $this->datatables->generate();
    }
}