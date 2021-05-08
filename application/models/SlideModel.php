<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SlideModel extends MY_Model {
    var $table = 'tbl_slide';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getAllSlide(){
        $this->datatables->select('id,judul,sub_judul,foto,button_text,url,kategori,diskon');
        $this->datatables->from($this->table);
        $this->datatables->add_column('foto', '<img src="'.base_url('resource/').'$1" width=120>', 'foto');
        $this->datatables->add_column('view', 
                                    '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1"><i class="fas fa-edit"></i></a>  
                                    <a href="javascript:void(0);" class="btn btn-danger item_delete" id="btn-delete" data-id="$1" data-nama="$2"><i class="fas fa-trash"></i></a> 
                                    ','id,judul');
        return $this->datatables->generate();
    }
}