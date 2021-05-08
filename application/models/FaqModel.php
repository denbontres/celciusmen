<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FaqModel extends MY_Model {
    var $table = 'tbl_faq';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getAllFaq(){
        $this->datatables->select($this->table.'.id,judul');
        $this->datatables->from($this->table);
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Faq/editFaq/').'$1" class="btn btn-success" ><i class="fas fa-edit"></i></a>  
        <a href="javascript:;" class="btn btn-danger item_delete" data-id="$id"><i class="fas fa-trash"></i></a> 
        ','id');
        return $this->datatables->generate();
    }
}