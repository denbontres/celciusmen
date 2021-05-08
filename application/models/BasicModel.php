<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BasicModel extends MY_Model {
    public function __construct(){
        $table = 'tbl_basic';
        parent::__construct($table);
    }
}