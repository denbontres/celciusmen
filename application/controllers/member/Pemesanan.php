<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('PemesananModel','pemesanan');
        $this->load->model('KonfirmasiModel','konfirmasi');
        $this->load->model('DetailPemesananModel','orderDetail');
        $this->load->helper('status_helper');
        $this->load->model('BasicModel','basic');

        if(!$this->session->userdata('email')){
            redirect('Login');
        }
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0',false);
        header('Pragma: no-cache');
        hitCounter();
        cekSessionUser();
    }
    public function pemesanan(){
        $email = $this->session->userdata('email');

        $status = "";
        if($this->input->post('status') != NULL ){
            $status = htmlspecialchars($this->input->post('status',true));
            $this->session->set_userdata(["status"=>$status]);
        }else{
            if($this->session->userdata('status') != NULL){
                $status = $this->session->userdata('status');
            }
        } 
        $this->load->library('pagination');
        $config['base_url'] = base_url().'member/Pemesanan/pemesanan/';
        $config['total_rows'] = $this->pemesanan->getPemesananRow($email,$status);
        $config['per_page']= 7;
        $data['start'] = $this->uri->segment(4)?$this->uri->segment(4):0;

        $data['pemesanan'] = $this->pemesanan->getPemesanan($config['per_page'],$data['start'],$email,$status);
        $this->pagination->initialize($config);
        $data['title'] = "Pemesanan";
        /*$this->load->view('member/template/header',$data);
        $this->load->view('member/template/navigation');
        $this->load->view('member/template/topNavigation');
        $this->load->view('member/pemesanan/pemesanan');
        $this->load->view('member/template/footer');
        $this->load->view('member/template/script');*/

        $this->load->view('frontend/template/head',$data);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/template/navigation');
        $this->load->view('member/pemesanan/pemesanan');
        $this->load->view('frontend/template/partner');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/script');
    }

    public function midtrans($faktur){
        $email = $this->session->userdata('email');
        $pemesanan = $this->pemesanan->getWhere('token',['nofaktur'=>$faktur,'email'=>$email,'status'=>1]);
        $snapToken = $pemesanan['token'];

        $info = $this->basic->getRow('midtrans_url');
        $midtransUrl  = $info['midtrans_url'];

        $urlPembayaranMidtrans = $midtransUrl.$snapToken;
        redirect($urlPembayaranMidtrans);
	}
    
    public function detailPemesanan($faktur){
        $email = $this->session->userdata('email');
        $pemesanan = $this->pemesanan->getWhere('*',['nofaktur'=>$faktur,'email'=>$email]);
        if($pemesanan){
            $data['detail'] = $this->orderDetail->getAllDetailPemesanan($faktur);
            $data['title'] = "Detail Pemesanan";
            $data['pemesanan'] = $this->_makeTabel($pemesanan);
            $this->load->view('member/template/header',$data);
            $this->load->view('member/template/navigation');
            $this->load->view('member/template/topNavigation');
            $this->load->view('member/pemesanan/detail');
            $this->load->view('member/template/footer');
            $this->load->view('member/template/script');
        }else{
            redirect('member/Pemesanan/pemesanan');
        }
    }

    public function review($faktur){
        $email = $this->session->userdata('email');
        $pemesanan = $this->pemesanan->getWhere('*',['nofaktur'=>$faktur,'email'=>$email,'status'=>5]);
        if($pemesanan){
            $data['detail'] = $this->orderDetail->getAllDetailPemesanan($faktur);
            $data['title'] = "Review Pemesanan";
            $this->load->view('member/template/header',$data);
            $this->load->view('member/template/navigation');
            $this->load->view('member/template/topNavigation');
            $this->load->view('member/pemesanan/review');
            $this->load->view('member/template/footer');
            $this->load->view('member/template/script');
        }else{
            redirect('member/Pemesanan/pemesanan');
        }
    }

    public function konfirmasiPembayaran($faktur){
        $email = $this->session->userdata('email');
        $pemesanan = $this->pemesanan->getWhere('token',['nofaktur'=>$faktur,'email'=>$email,'status !='=>0,'status !='=>3,'status !='=>4,'status !='=>5]);
        $data['token'] = $pemesanan['token'];
        $data['konfirmasi'] = $this->konfirmasi->getWhere('nofaktur,rekening,jumlah,bukti',['nofaktur'=>$faktur]);
        $this->form_validation->set_rules('norek','Nomor Rekening','required|numeric',
                                        [
                                          'required'=>'%s tidak boleh kosong',
                                          'numeric'=>"%s isi dengan angka"
                                        ]);
        $this->form_validation->set_rules('jumlah','Jumlah Pembayaran','required|numeric',
                                        [
                                          'required'=>'%s tidak boleh kosong',
                                          'numeric'=>"%s isi dengan angka"
                                        ]);
        $this->form_validation->set_rules('bukti','Bukti','callback_validateSize[bukti]|callback_validateTypeFile[bukti]|callback_requiredFile[bukti]',
                                        [
                                            'validateTypeFile'=>'%s harus berformat PDF',
                                            'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                            'requiredFile'=>'%s tidak boleh kosong'
                                        ]);
        if($this->form_validation->run()==false){
            $data['title'] = "Konfirmasi Pembayaran";
            $data['faktur'] = $faktur;
            $this->load->view('member/template/header',$data);
            $this->load->view('member/template/navigation');
            $this->load->view('member/template/topNavigation');
            $this->load->view('member/pemesanan/konfirmasi');
            $this->load->view('member/template/footer');
            $this->load->view('member/template/script');
        }else{
           
            if(!$pemesanan){
                redirect('member/Pemesanan/pemesanan');
            }
            if($data['konfirmasi']){
                $this->konfirmasi->delete(['nofaktur'=>$faktur]);
                deleteGambar('resource/',$data['konfirmasi']['bukti']);
            }
            $bukti = addGambar('./resource/',"bukti");
            $data = [
                'nofaktur'=>$faktur,
                'rekening'=>htmlspecialchars($this->input->post('norek',true)),
                'jumlah'=>htmlspecialchars($this->input->post('jumlah',true)),
                'bukti'=>$bukti
            ];
            $this->konfirmasi->insert($data);
            redirect('member/Pemesanan/pemesanan');
        }
    }

    public function selesai($faktur){
        $email = $this->session->userdata('email');
        $pemesanan = $this->pemesanan->getWhere('token',['nofaktur'=>$faktur,'email'=>$email,'status'=>4]);
        if($pemesanan){
            $data = array('status'=>5);
            $this->pemesanan->update($data,['nofaktur'=>$faktur,'email'=>$email,'status'=>4]);
        }
        redirect('member/Pemesanan/pemesanan');
    }

    private function _makeTabel($pemesanan){
        $status = "";
        switch ($pemesanan['status']) {
            case 1:
                $status = "Menunggu Pembayaran";
                break;
            case 2:
                $status = "Menunggu Konfirmasi";
                break;
            case 3:
                $status = "Packing";
                break;
            case 4:
                $status = "Pengiriman";
                break;
            case 5:
                $status = "Selesai";
                break;
            
            default:
                $status = "Belum selesai";
                break;
        } 
        $tabel = [
            [
                'name' => 'Email',
                'value' => $pemesanan['email']
            ],
            [
                'name' => 'Tanggal Order',
                'value' => tglIndo($pemesanan['tanggal'])
            ],
            [
                'name' => 'Subtotal',
                'value' => number_format($pemesanan['total'],'0',',','.')
            ],
            [
                'name' => 'Ongkir',
                'value' => number_format($pemesanan['ongkir'],'0',',','.')
            ],
            [
                'name' => 'Discount',
                'value' => number_format($pemesanan['discount'],'0',',','.')
            ],
            [
                'name' => 'Total',
                'value' => number_format($pemesanan['ongkir']+$pemesanan['total']-$pemesanan['discount'],'0',',','.')
            ],
            [
                'name' => 'Berat',
                'value' => number_format($pemesanan['berat'],'0',',','.').' Kg'
            ],
            [
                'name' => 'Alamat',
                'value' => $pemesanan['alamat']
            ],
            [
                'name' => 'Status',
                'value' => $status
            ],
            [
                'name' => 'Resi Kurir',
                'value' => $pemesanan['resikurir']?$pemesanan['resikurir']:'-'
            ],
            [
                'name' => 'Waktu Bayar',
                'value' => $pemesanan['waktu_bayar']?tglIndowithJam($pemesanan['waktu_bayar']):'-'
            ]
        ];
        return $tabel;
    }

    function validateTypeFile($input,$name){
        $allowed = array('JPG','jpg','JPEG','jpeg','PNG','png');
        $filename = $_FILES[$name]['name'];
        if($filename){
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                return false;
            }else{
                return true;
            }
        }
    }

    function validateSize($input,$name){
            $filename = $_FILES[$name]['name'];
            if($filename){
                    if($_FILES[$name]['size'] > (1024*1000)){
                            return false;
                    }else{
                            return true;
                    }
            } 
    }

    function requiredFile($input,$name){
            $filename = $_FILES[$name]['name'];
            if($filename){
                    return true;
            }else{
                    return false;
            } 
    }

}
