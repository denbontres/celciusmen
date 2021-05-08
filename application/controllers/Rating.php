<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('RatingModel','rating');
        $this->load->model('DetailPemesananModel','orderDetail');
        $this->load->model('PemesananModel','pemesanan');
        $this->load->model('BarangModel','barang');
        cekSessionUser();
        hitCounter();
    }
    public function tambahRating(){
        $idBarang = $this->input->post('id');
        $barang = $this->barang->getWhere('slug',['id'=>$idBarang]);
        $url = 'Product/detailProduct/'.$barang['slug'];
        $this->form_validation->set_rules('rating','Rating','required',
                                        [
                                          'required'=>'%s tidak boleh kosong'
                                        ]);
        $this->form_validation->set_rules('id','Barang','required',
                                        [
                                          'required'=>'%s tidak boleh kosong'
                                        ]);
        if($this->form_validation->run()==false){
            $this->session->set_flashdata('pesan',"<script>toastr.error('Rating Harus Diisi')</script>");
            redirect($url);
        }
        else{
            $email = $this->session->userdata('email');
            // cek pemesanan
            $pemesanan = $this->orderDetail->getPemesananRating($idBarang,$email);
            if($pemesanan){
                $nofaktur = $pemesanan['nofaktur'];

                $data = [
                    'rating'=>$this->input->post('rating'),
                    'coment'=>$this->input->post('komentar'),
                    'id_user'=>$this->session->userdata('id'),
                    'id_barang'=>$idBarang,
                    'nofaktur'=>$nofaktur
                ];
                // simpan data rating
                $this->rating->insert($data);

                // update order detail
                $this->orderDetail->update(['israting'=>1],['nofaktur'=>$nofaktur,'sku'=>$pemesanan['sku']]);

                // update status order jadi selesai, jika semua produk telah dirating, NOTE selesai (5)
                $orderDetail = $this->orderDetail->getAllWhere('id',['nofaktur'=>$nofaktur,'israting'=>0]);
                if(!$orderDetail){
                    $this->pemesanan->update(['status'=>'5'],['nofaktur'=>$nofaktur]);
                }
                $this->session->set_flashdata('pesan',"<script>toastr.success('Rating telah ditambahkan')</script>");
                redirect($url);
            }else{
                redirect($url);
            }
            
        }
    }
}