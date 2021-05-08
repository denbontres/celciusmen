<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactModel extends MY_Model {
    var $table = 'tbl_contact';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getAllContact(){
        $this->datatables->select($this->table.'.id,email,nama,waktu');
        $this->datatables->from($this->table);
        $this->datatables->edit_column('waktu','$1','tglIndo(waktu)');
        $this->datatables->add_column('view','  
            <a href="'.base_url('admin/Contact/detail/$1').'" class="btn btn-primary" data-id="$id"><i class="fas fa-eye"></i></a> 
        ','id');
        return $this->datatables->generate();
    }
}