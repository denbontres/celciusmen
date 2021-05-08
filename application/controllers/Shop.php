<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('KategoriBarangModel','kategori');
        $this->load->model('JenisBarangModel','jenis');
        $this->load->model('SkuUnitModel','skuUnit');
        $this->load->model('KategoriVariantModel','kategoriVariant');
        $this->load->model('VariantModel','variant');
        $this->load->model('BarangModel','barang');
        $this->load->model('RatingModel','rating');
        $this->load->model('SkuModel','sku');
        $this->load->model('JenisBarangModel','jenisBarang');
        $this->load->model('TagModel','tag');
        cekSessionUser();
        hitCounter();
    }

    public function index(){
        // ambil size dari input user
        $jenis = htmlspecialchars($this->input->get('jenis',true));
        $size = htmlspecialchars($this->input->get('size',true));
        $warna = htmlspecialchars($this->input->get('warna',true));
        $hargaMin = htmlspecialchars($this->input->get('harga-min',true));
        $hargaMax = htmlspecialchars($this->input->get('harga-max',true));
        $brandArray = $this->input->get('brand');
        $brand = $brandArray?implode ("','", $brandArray):'';
        $rating = htmlspecialchars($this->input->get('rating',true));

        $slugkategori = htmlspecialchars($this->input->get('kategori',true));
        $kategoriInDb = $this->kategori->getWhere('nama',['url'=>$slugkategori]);
        $kategori = $kategoriInDb['nama'];

        $search = htmlspecialchars($this->input->get('search',true));
        if($search){
            $jenisKategori = htmlspecialchars($this->input->get('jenis-kategori',true));
            $arrayElemenSearch = explode("-",$jenisKategori);
            $slugjenis = $arrayElemenSearch[0];
            $slugkategori = $arrayElemenSearch[1];

            $jenisInDb = $this->jenis->getWhere('nama',['url'=>$slugjenis]);
            $kategoriInDb = $this->kategori->getWhere('nama',['url'=>$slugkategori]);
        
            $jenis = $jenisInDb['nama'];
            $kategori = $kategoriInDb['nama'];
        }

        $url = "Shop";
        $start = ($this->input->get('per_page')?$this->input->get('per_page')-1:0) * 9;
        $this->_getView($hargaMin,$hargaMax,$jenis,$brand,$warna,$size,$search,$rating,$url,$start,$kategori);

    }

    private function _getView($hargaMin,$hargaMax,$jenis,$brand,$warna,$size,$search,$rating,$url,$start,$kategori){
        $data['title'] = 'Shop';
        $data['group'] = 'Shop';
        // data filter
        $data['listWarna'] = $this->variant->getListVariant(2);
        $data['listSizeAngka'] = $this->variant->getListVariant(3);
        $data['listSizeHuruf'] = $this->variant->getListVariant(1);
        $data['jenisBarang'] = $this->jenisBarang->getAll();
        $data['jumlahWarna']= $this->variant->getCountListVariant(2);
        $data['brand'] = $this->barang->getListBrand();
        $data['tag'] = $this->tag->getListTag();

        $this->load->library('pagination');
        $config['base_url'] = base_url().$url;
        $config['total_rows'] = $this->barang->getJumlahRowFilter($hargaMin,$hargaMax,$jenis,$brand,$warna,$size,$search,$rating,$kategori);
        $config['per_page']= 9;
        $data['perpage']= 9;
        $data['start'] = $start;

        $data['barang'] = $this->barang->getBarangByFilter($config['per_page'],$data['start'],$hargaMin,$hargaMax,$jenis,$brand,$warna,$size,$search,$rating,$kategori);
        $data['jumlahData'] = $config['total_rows'];

        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);
        
        $data['filter'] = 'frontend/template/filter';
        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/shop/shop');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');

    }
}