<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends MY_Model {
    var $table = 'tbl_user';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getUserLogin($where){
        $this->db->select('email,nama,password,id,id_jenis_user');
        $this->db->from($this->table);
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
    public function getDetailPelanggan($start,$limit){
        $this->db->select('tbl_user.email,tbl_user.nama,alamat,notelpon,tgl_daftar');
        $this->db->from($this->table);
        $this->db->where('id_jenis_user',4);
        $this->db->order_by($this->table.'.id','desc');
        $this->db->join('tbl_jenis_user',$this->table.' id_jenis_user = tbl_jenis_user.id');
        $this->db->limit($start,$limit);
        return $this->db->get()->result_array();
    }

    public function getDetailUserRow($email){
        $this->db->select('tbl_user.email,tbl_user.nama,alamat,notelpon,tgl_daftar,foto,tbl_jenis_user.nama as jenis');
        $this->db->from($this->table);
        $this->db->where('email',$email);
        $this->db->join('tbl_jenis_user',$this->table.' id_jenis_user = tbl_jenis_user.id');
        return $this->db->get()->row_array();
    }

    public function getDetailUser(){
        $this->db->select('tbl_user.email,tbl_user.nama,alamat,notelpon,tgl_daftar');
        $this->db->from($this->table);
        $this->db->where('id_jenis_user!=',4);
        $this->db->join('tbl_jenis_user',$this->table.' id_jenis_user = tbl_jenis_user.id');
        return $this->db->get()->result_array();
    }
    public function getAllUser(){
        $this->datatables->select('id,nama,email,foto');
        $this->datatables->from($this->table);
        $this->db->where('id_jenis_user!=',4);
        $this->datatables->add_column('foto', '<img src="'.base_url('foto_user/').'$1" width=120>', 'foto');
        $this->datatables->add_column('view', 
                                    '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1"><i class="fas fa-edit"></i></a>  
                                    <a href="javascript:void(0);" class="btn btn-danger item_delete" id="btn-delete" data-nama="$2" data-id="$1"><i class="fas fa-trash"></i></a> 
                                    ','id,nama');
        return $this->datatables->generate();
    }
    public function getUserForDashboard(){
        $this->db->select('nama,email,foto,tgl_daftar');
        $this->db->from($this->table);
        $this->db->order_by('id','desc');
        $this->db->limit(8);
        $this->db->where('id_jenis_user =',4);
        return $this->db->get()->result_array();
    }
    public function getRowUserForDashboard(){
        $this->db->select('nama');
        $this->db->from($this->table);
        $this->db->limit(8);
        $this->db->where('id_jenis_user =',4);
        return $this->db->get()->num_rows();
    }
}