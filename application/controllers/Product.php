<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('SlideModel','slide');
        $this->load->model('KategoriBarangModel','kategori');
        $this->load->model('SkuUnitModel','skuUnit');
        $this->load->model('KategoriVariantModel','kategoriVariant');
        $this->load->model('VariantModel','variant');
        $this->load->model('VariantSelectModel','select');
        $this->load->model('BarangModel','barang');
        $this->load->model('RatingModel','rating');
        $this->load->model('SkuModel','sku');
        $this->load->model('JenisBarangModel','jenisBarang');
        $this->load->model('TagModel','tag');
        $this->load->model('SpesifikasiBarangModel','spesifikasi');
        $this->load->model('DetailPemesananModel','orderDetail');
        cekSessionUser();
        hitCounter();
    }

    public function detailProduct($url){
        $data['title'] = 'Product';
        $data['group'] = 'Home';
        $data['filter'] = 'frontend/template/filter';
        $dbBarang = $this->barang->getWhere('id,slug',['slug'=>$url]);
        $id = $dbBarang['id'];
        $data['barang'] = $this->barang->getDetailBarang($id);
        $data['rating'] = $this->rating->getRatingBarang($id);
        $data['spesifikasi'] = $this->spesifikasi->getAllWhere('nama,nilai',['id_barang'=>$id]);
        $data['urlshare'] = "";
        $kategoriBrang = $data['barang']['id_kategori_barang'];
        $jenisBrang = $data['barang']['id_jenis_barang'];
        $data['related'] = $this->barang->getAllWhere('id,foto,nama,diskon,total_harga,harga,slug as url',['id_kategori_barang'=>$kategoriBrang,'id_jenis_barang'=>$jenisBrang,'id !='=>$id]);
        
        $data['allRating'] = $this->rating->ratingWithMessage($id);
        $data['id'] = $id;
        $data['skuUnit'] = $this->skuUnit->getKategori();
        $data['pemesanan'] = "";
        $i=0;
        foreach($data['skuUnit'] as $r){
            $data['variant'][$i++] = $this->skuUnit->getVariant($id,$r['id_kategori_variant']);
        }
        $data['urlshare'] = $dbBarang['slug'];
        $data['pemesanan'] = $this->_getPemesananPengiriman($id);
        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('frontend/productDetail/productDetail');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');

    }

    public function _getPemesananPengiriman($id){
        $email = $this->session->userdata('email');
        if($email){
            $pemesanan = $this->orderDetail->getPemesananOnKirim($id,$email);
        }else{
            $pemesanan = "";
        }
        return $pemesanan;
    }
    public function getJumlahBarang(){
        $idBarang = $this->input->post('idBarang');
        $select = $this->select->getCountRowWhere(['id_barang'=>$idBarang]);
        
        $data['skuUnit'] = $this->skuUnit->getKategoriByIdBarang($idBarang);

        $i=0;
        $isError=false;
        
        foreach($data['skuUnit'] as $r){
            $element = $r['name_element'];
            $idKategori[$i] = $r['id_kategori_variant']; ;
            $idVariant[$i] = $this->input->post($element);
            if($select == 2){
                if(!$idVariant[$i]){
                    $isError = true;
                }
            }
            $i++;
        }
   
        // jika jumlah variant yang di input kecil dari jenis variant yang disediakan misal ada varian size dan warna, maka variant yang di input harus 2 yaitu value untuk warna dan size
        if(!$isError){
            $kategori =  implode(',', $idKategori);
            $variant = implode(',', $idVariant);
            if($select == 2){
                $idSku = $this->skuUnit->getJumlahBarang($idBarang,$kategori,$variant);
            }else if($select == 1){
                $variant = str_replace(",",'',$variant);
                $variantSelectDb = $this->select->getWhere('id_kategori_variant',['id_barang'=>$idBarang]);
                $idKategoriVariant = $variantSelectDb['id_kategori_variant'];
                $idSku = $this->skuUnit->getWhere('id_sku',['id_barang'=>$idBarang,'id_kategori_variant'=>$idKategoriVariant,'id_variant'=>$variant]);
            }

            $sku = $this->sku->getWhere('jumlah,kode',['id'=>$idSku['id_sku']]);
           
            $data = [
                'sku'=>$idSku['id_sku'],
                'jumlah'=>$sku['jumlah'],
                'kode'=>$sku['kode']
            ];
            echo json_encode($data);
        }else{
            echo json_encode(['message'=>'Error']);
        }
    }
}