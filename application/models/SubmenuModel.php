<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubmenuModel extends MY_Model {
    var $table = "tbl_submenu";
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getAllSubmenu(){
        $this->datatables->select('tbl_submenu.id,nama,judul,url,icon,if(aktif=1,"Aktif","Tidak aktif") as aktif');
        $this->datatables->join('tbl_menu',$this->table. ".id_menu=tbl_menu.id");
        $this->db->order_by('id','asc');
        $this->datatables->from($this->table);
        $this->datatables->add_column('myicon','<i class="$1"></i>','icon');
        $this->datatables->add_column('view', 
                                    '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1"><i class="fas fa-edit"></i></a>  
                                    <a href="javascript:void(0);" class="btn btn-danger item_delete" id="btn-delete" data-id="$1" data-nama="$2"><i class="fas fa-trash"></i></a> 
                                    ','id,nama');
        return $this->datatables->generate();
    }
}