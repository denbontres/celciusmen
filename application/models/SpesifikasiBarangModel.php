<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SpesifikasiBarangModel extends MY_Model {
    public function __construct(){
        $table = 'tbl_spesifikasi_barang';
        parent::__construct($table);
    }
    public function getAllSpesifikasi($idBarang){
        $this->datatables->select($this->table.'.id,'.$this->table.'.nama,tbl_barang.nama as barang,nilai');
        $this->datatables->from($this->table);
        $this->datatables->where('id_barang',$idBarang);
        $this->datatables->join('tbl_barang',$this->table. ".id_barang=tbl_barang.id");
        $this->datatables->add_column('view', 
                                    '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1"><i class="fas fa-edit"></i></a>  
                                    <a href="javascript:void(0);" class="btn btn-danger item_delete" id="btn-delete" data-id="$1" data-nama="$2"><i class="fas fa-trash"></i></a>
                                    ','id,nama');
        return $this->datatables->generate();
    }
}