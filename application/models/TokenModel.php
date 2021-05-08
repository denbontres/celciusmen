<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TokenModel extends MY_Model {
    public function __construct(){
        $table = 'tbl_token';
        parent::__construct($table);
    }
    public function getToken($token,$email){
        return $this->db->get_where('tbl_token',['token'=>$token,'email'=>$email])->num_rows();
    }
    public function getAllToken(){
        $this->datatables->select('id,email,token');
        $this->datatables->from($this->table);
        return $this->datatables->generate();
    }
}