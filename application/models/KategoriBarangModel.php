<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriBarangModel extends MY_Model {
    var $table = 'tbl_kategori_barang';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getAllKategori(){
        $this->datatables->select('id,nama');
        $this->datatables->from($this->table);
        $this->datatables->add_column('view', 
                                    '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1"><i class="fas fa-edit"></i></a>  
                                    <a href="javascript:void(0);" class="btn btn-danger item_delete" id="btn-delete" data-id="$1" data-nama="$2"><i class="fas fa-trash"></i></a>
                                    ','id,nama');
        return $this->datatables->generate();
    }
}