<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KonfirmasiModel extends MY_Model {
    var $table = 'tbl_bukti';
    public function __construct(){
        parent::__construct($this->table);
    }
}