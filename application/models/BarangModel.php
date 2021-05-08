<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangModel extends MY_Model {
    var $table = 'tbl_barang';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function getListBrand(){
        $this->db->select('brand,brand_slug');
        $this->db->group_by('brand');
        $this->db->limit(4);
        return $this->db->get($this->table)->result_array();
    }
    public function getBarangWithPagination($limit,$start,$filter){
        $this->db->select('id,foto,nama,harga,diskon,total_harga');
        // jika ada kategori yang di pilih
        if($filter['kategori']){
            $this->db->where('id_kategori_barang',$filter['kategori']);
        }
        $this->db->from($this->table);
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }
    public function make_query($hargaMin,$hargaMax,$jenis,$brand,$warna,$ukuran,$search,$rating,$kategori){
        $select = "SELECT tbl_barang.nama,harga,tbl_sku.nama as sku,diskon,harga,total_harga,tbl_barang.id,foto,tbl_barang.slug as url,
                        tbl_kategori_variant.nama as kategori,brand,tbl_variant.nama variant 
                        FROM tbl_sku_unit 
                        join tbl_barang on tbl_sku_unit.id_barang = tbl_barang.id 
                        join tbl_sku on tbl_sku_unit.id_sku = tbl_sku.id 
                        join tbl_kategori_variant on tbl_sku_unit.id_kategori_variant = tbl_kategori_variant.id 
                        join tbl_jenis_barang on tbl_barang.id_jenis_barang = tbl_jenis_barang.id
                        join tbl_kategori_barang on tbl_barang.id_kategori_barang = tbl_kategori_barang.id
                        join tbl_variant on tbl_sku_unit.id_variant = tbl_variant.id %size% %brand% %jenis% %kategori% %range% %cari% %rating%
                        and id_sku in(SELECT id_sku FROM tbl_sku_unit 
                        join tbl_sku on tbl_sku_unit.id_sku = tbl_sku.id 
                        join tbl_variant on tbl_sku_unit.id_variant = tbl_variant.id 
                        %color% ) GROUP by tbl_barang.nama"
                    ;
        // filter harga            
        if(isset($hargaMin, $hargaMax) && !empty($hargaMin) &&  !empty($hargaMax)){
            $select = str_replace('%range%',"and harga between $hargaMin and $hargaMax",$select);
        }else{
            $select = str_replace('%range%',"",$select);
        }

        // filter brand
        if($brand){
            $select = str_replace('%brand%',"and brand_slug in('$brand')",$select);
        }else{
            $select = str_replace('%brand%',"",$select);
        }

        // filter warna 
        if($warna){
            $select = str_replace('%color%','where tbl_variant.nama ="'.$warna.'"',$select);
        }else{
            $select = str_replace('%color%',"",$select);
        }

        // filter size
        if($ukuran){
            $select = str_replace('%size%','where tbl_variant.nama ="'.$ukuran.'"',$select);
        }else{
            $select = str_replace('%size%',"",$select);
        }
        
        // filter jenis
        if($jenis){
            $select = str_replace('%jenis%',"and tbl_jenis_barang.url = '$jenis' ",$select);
        }else{
            $select = str_replace('%jenis%',"",$select);
        }

        // filter kategori
        if($kategori){
            $select = str_replace('%kategori%',"and tbl_kategori_barang.url = '$kategori' ",$select);
        }else{
            $select = str_replace('%kategori%',"",$select);
        }

        // filter rating
        if($rating){
            $select = str_replace('%rating%',"and tbl_barang.rating = '$rating' ",$select);
        }else{
            $select = str_replace('%rating%',"",$select);
        }

        if($search){
            $select = str_replace('%cari%',"and tbl_barang.nama like '%$search%'",$select);
        }else{
            $select = str_replace('%cari%',"",$select);
        }
        return $select;
    }

    public function getBarangByFilter($limit,$start,$hargaMin,$hargaMax,$jenis,$brand,$warna,$ukuran,$search,$rating,$kategori){
        $query = $this->make_query($hargaMin,$hargaMax,$jenis,$brand,$warna,$ukuran,$search,$rating,$kategori);
        $query .= ' LIMIT '.$start.', ' . $limit;
        return $this->db->query($query)->result_array();
    }
    public function getJumlahRowFilter($hargaMin,$hargaMax,$jenis,$brand,$warna,$ukuran,$search,$rating,$kategori){
        $query = $this->make_query($hargaMin,$hargaMax,$jenis,$brand,$warna,$ukuran,$search,$rating,$kategori);
        return $this->db->query($query)->num_rows();
    }
    public function getKategoriDanJenisBarang(){
        $this->db->distinct();
        $this->db->select('tbl_kategori_barang.nama as kategori,tbl_jenis_barang.nama as jenis,tbl_kategori_barang.url as url_kategori,tbl_jenis_barang.url as url_jenis');
        $this->db->from($this->table);
        $this->db->join('tbl_kategori_barang',$this->table.'.id_kategori_barang =tbl_kategori_barang.id');
        $this->db->join('tbl_jenis_barang',$this->table.'.id_jenis_barang =tbl_jenis_barang.id');
        return $this->db->get()->result_array();
    }
    public function getDetailBarang($id){
        $this->db->select($this->table.'.id,harga,berat,short_deskripsi,diskon,total_harga,deskripsi,tag,'.$this->table.'.nama,tbl_kategori_barang.nama as kategori,brand,id_kategori_barang,id_jenis_barang,foto,foto2,foto3,foto4');
        $this->db->from($this->table);
        $this->db->where($this->table.'.id',$id);
        $this->db->join('tbl_kategori_barang',$this->table.'.id_kategori_barang=tbl_kategori_barang.id');
        return $this->db->get()->row_array();
    }

    public function getAllBarang(){
        $this->datatables->select('tbl_barang.nama,total_harga,diskon,slug,tbl_barang.id,tbl_jenis_barang.nama as jenis,tbl_kategori_barang.nama as kategori');
        $this->datatables->from($this->table);
        $this->datatables->join('tbl_jenis_barang',"$this->table. id_jenis_barang=tbl_jenis_barang.id");
        $this->datatables->join('tbl_kategori_barang',"$this->table. id_kategori_barang=tbl_kategori_barang.id");
        $this->datatables->edit_column('total_harga','$1','formatRupiah(total_harga)');
        $this->datatables->add_column('view', 
                                   '<a href="'.base_url('admin/Barang/editBarang/$1').'" class="btn btn-success" ><i class="fas fa-edit"></i></a>  
                                   <a href="'.base_url('admin/Barang/variant/$1').'" class="btn btn-warning" data-id="$1"><i class="fas fa-list"></i></a> 
                                   <a href="'.base_url('admin/Spesfikasi?idbarang=$1').'" class="btn btn-warning" data-id="$1"><i class="fas fa-cogs"></i></a> 
                                   <a href="'.base_url('product/$2').'" class="btn btn-primary" data-id="$1" target="_blank"><i class="fas fa-eye"></i></a>
                                   <a href="javascript:;" class="btn btn-danger delete" data-id="$1" data-nama="$3"><i class="fas fa-trash"></i></a>
                                    ','id,slug,nama');
        return $this->datatables->generate();
    }
    public function getBarangForDashboard(){
        $this->db->select('total_harga as harga,nama,foto,short_deskripsi');
        $this->db->order_by('id','desc');
        $this->db->from($this->table);
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }
    public function getBarangSedikit(){
        $this->datatables->select('concat(tbl_barang.nama," " ,tbl_sku.nama) as nama,total_harga,diskon,jumlah,tbl_barang.id,tbl_jenis_barang.nama as jenis,tbl_kategori_barang.nama as kategori,slug');
        $this->datatables->from('tbl_sku');
        $this->datatables->where('jumlah <=',5);
        $this->datatables->join('tbl_barang',"tbl_sku.id_barang=tbl_barang.id");
        $this->datatables->join('tbl_jenis_barang',"$this->table. id_jenis_barang=tbl_jenis_barang.id");
        $this->datatables->join('tbl_kategori_barang',"$this->table. id_kategori_barang=tbl_kategori_barang.id");
        $this->datatables->add_column('view', 
                                    '<a href="'.base_url('product/$1').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
                                    ','slug');
        return $this->datatables->generate();
    }
    
    public function getLaporanBarangSedikit(){
        $this->db->select('concat(tbl_barang.nama," " ,tbl_sku.nama) as nama,total_harga,diskon,jumlah,tbl_barang.id,tbl_jenis_barang.nama as jenis,tbl_kategori_barang.nama as kategori,slug');
        $this->db->from('tbl_sku');
        $this->db->where('jumlah <=',5);
        $this->db->join('tbl_barang',"tbl_sku.id_barang=tbl_barang.id");
        $this->db->join('tbl_jenis_barang',"$this->table. id_jenis_barang=tbl_jenis_barang.id");
        $this->db->join('tbl_kategori_barang',"$this->table. id_kategori_barang=tbl_kategori_barang.id");
        return $this->db->get()->result_array();
    }
}