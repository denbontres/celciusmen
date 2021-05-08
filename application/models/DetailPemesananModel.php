<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . '/third_party/midtrans/Midtrans.php';
class DetailPemesananModel extends MY_Model {
    var $table = 'tbl_detail_pemesanan';
    public function __construct(){
        parent::__construct($this->table);
    }

    public function getAllDetailPemesanan($nofaktur){
        $this->db->select('tbl_detail_pemesanan.*,tbl_barang.berat,tbl_barang.nama,tbl_barang.total_harga,tbl_barang.foto,tbl_sku.nama as sku,tbl_barang.slug');
        $this->db->from($this->table);
        $this->db->where('nofaktur',$nofaktur);
        $this->db->join('tbl_sku','tbl_detail_pemesanan.sku=tbl_sku.kode');
        $this->db->join('tbl_barang','tbl_sku.id_barang=tbl_barang.id');
        return $this->db->get()->result();
    }

    public function getOrderDetail($nofaktur){
        $this->db->select($this->table.'.jumlah,tbl_barang.berat,tbl_barang.nama,tbl_barang.total_harga,tbl_sku.nama as sku');
        $this->db->from($this->table);
        $this->db->where('nofaktur',$nofaktur);
        $this->db->join('tbl_sku','tbl_detail_pemesanan.sku=tbl_sku.kode');
        $this->db->join('tbl_barang','tbl_sku.id_barang=tbl_barang.id');
        return $this->db->get()->result_array();
    }
    public function getDataPemesanan($nofaktur){
        $this->db->select($this->table.'.id,tbl_barang.berat,tbl_barang.nama,harga,'.$this->table.'.jumlah,total_harga,foto');
        $this->db->from($this->table);
        $this->db->where('nofaktur',$nofaktur); 
        $this->db->join('tbl_sku',$this->table.'.sku=tbl_sku.kode');
        $this->db->join('tbl_barang','tbl_sku.id_barang=tbl_barang.id');
        return $this->db->get()->result();
    }
    public function getPemesananOnKirim($idBarang,$email){
        $this->db->select($this->table.'.nofaktur');
        $this->db->from($this->table);
        $this->db->join('tbl_sku',$this->table.'.sku = tbl_sku.kode');
        $this->db->join('tbl_barang','tbl_sku.id_barang = tbl_barang.id');
        $this->db->join('tbl_pemesanan',$this->table.'.nofaktur = tbl_pemesanan.nofaktur');
        $this->db->where('status !=',1);
        $this->db->where('status !=',2);
        $this->db->where('status !=',3);
        $this->db->where('tbl_barang.id',$idBarang);
        $this->db->where('tbl_pemesanan.email',$email);
        $this->db->where('israting',0);
        return $this->db->get()->row_array();
    }

    public function getPemesananRating($idBarang,$email){
        $this->db->select($this->table.'.nofaktur,sku');
        $this->db->from($this->table);
        $this->db->join('tbl_sku',$this->table.'.sku = tbl_sku.kode');
        $this->db->join('tbl_barang','tbl_sku.id_barang = tbl_barang.id');
        $this->db->join('tbl_pemesanan',$this->table.'.nofaktur = tbl_pemesanan.nofaktur');
        $this->db->where('status !=',1);
        $this->db->where('status !=',2);
        $this->db->where('status !=',3);
        $this->db->where('israting',0);
        $this->db->where('tbl_sku.id_barang',$idBarang);
        $this->db->where('tbl_pemesanan.email',$email);
        return $this->db->get()->row_array();
    }

    public function getPemesananForDashboard(){
        $this->db->select($this->table.'.nofaktur,tbl_barang.berat,tbl_barang.nama as barang,tbl_sku.nama as sku,status,tbl_pemesanan.email');
        $this->db->from($this->table);
        $this->db->order_by($this->table.'.id','desc');
        $this->db->join('tbl_sku',$this->table.'.sku = tbl_sku.kode');
        $this->db->join('tbl_barang','tbl_sku.id_barang = tbl_barang.id');
        $this->db->join('tbl_pemesanan',$this->table.'.nofaktur = tbl_pemesanan.nofaktur');
        $this->db->where('status !=',0);
        $this->db->limit(8);
        return $this->db->get()->result_array();
    }
}