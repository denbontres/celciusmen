<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ob_start();
class Pemesanan extends CI_Controller {
        
        public function __construct(){
                parent::__construct();
                is_logged_in('Pemesanan');
                $this->load->model('PemesananModel','pemesanan');
                $this->load->model('DetailPemesananModel','detail');
                $this->load->model('UserModel','user');
                $this->load->model('BasicModel','basic');
                $this->load->model('BarangModel','barang');
                $this->load->model('KonfirmasiModel','bukti');
                $this->load->library('datatables'); 
                $this->load->helper('status_helper'); 
        }

        public function index(){
                $data['judul']="Pemesanan";
                $data['group']="Pemesanan";
                $data['pemesanan'] = $this->pemesanan->getAll();
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/pemesanan/pemesanan');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function updatePemesanan(){
                $status = htmlspecialchars($this->input->post('status'));
                $id = htmlspecialchars($this->input->post('id'));
                $resi = htmlspecialchars($this->input->post('kurir'));
                $validation['status'] = 1;
                $data = ['status'=>$status];
                if($status == 3){
                        if($resi ==""){
                                $validation['status'] = 0;     
                                $validation['errorResi'] = "Resi harus diisi";
                        }else{
                                $data['resikurir'] = $resi;
                        }
                }else if($status == 4){
                        $this->_insertBarangJumJual($id);
                }else if($status !=4 || $status !=3){
                        $this->pemesanan->update(['resikurir'=>""],['nofaktur'=>$id]);
                }
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $this->pemesanan->update($data,['nofaktur'=>$id]);
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }
        
        public function getPemesanan(){
                header('Content-Type: application/json');
                $data = $this->pemesanan->getAllPemesanan();
                echo $data;
        }
        public function getResi(){
                $nofaktur = $this->input->post('faktur');
                $data = $this->pemesanan->getWhere('resikurir',['nofaktur'=>$nofaktur]);
                echo json_encode($data);
        }

        public function Pemesanan(){
                $data['judul']="Pemesanan";
                $data['group']="Pelanggan";
                $data['email']=htmlspecialchars($this->input->get('email',true));
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/pemesanan/pemesananwhere');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function getPemesananWhere(){
                $email = htmlspecialchars($this->input->get('email',true));
                header('Content-Type: application/json');
                $data = $this->pemesanan->getAllPemesananWhere($email);
                echo $data;
        }

        public function DetailPemesanan(){
                $data['judul'] = "Detail Pemesanan"; 
                $data['group']="Pemesanan";
                $data['basic'] = $this->basic->getAllRow(); 
                $nofaktur = $this->input->get('nofaktur');
                $where = ['nofaktur'=>$nofaktur ];
                $data['pemesanan'] = $this->pemesanan->getWhere('*',$where);
                $data['pembayaran'] = $this->detail->getSumWhere('subtotal',$where); 
                $data['detail']= $this->detail->getAllDetailPemesanan($nofaktur);
                $data['bukti'] = $this->bukti->getWhere('*',['nofaktur'=>$nofaktur]);
                $data['user'] = $this->user->getWhere('nama,alamat,notelpon',['email'=> $data['pemesanan']['email']]);
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/pemesanan/detailpemesanan');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');      
        }
        
        public function pelanggan(){
                $data['judul'] = "Pelanggan";
                $data['group'] = "Pelanggan";
                $this->load->library('pagination');
		
		$config['base_url'] = base_url()."/admin/Pemesanan/pelanggan";
		$config['total_rows'] = $this->user->getCountRowWhere(['id_jenis_user'=>4]);
		$config['per_page'] =6;
                $data['start'] = $this->uri->segment(4);

                $config['full_tag_open']='<nav><ul class="pagination justify-content-center m-0">';
		$config['full_tag_close'] = '</ul></nav>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li  class="page-item">';
                $config['num_tag_close'] = '</li>';
                $config['attributes'] = array('class' => 'page-link');
                
                $this->pagination->initialize($config);

                $data['user'] = $this->user->getDetailPelanggan($config['per_page'],$data['start']); 
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/pemesanan/pelanggan');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');   
        }
    // fungsi untuk menginsertkan jumlah jual barang pada tabel barang
        private function _insertBarangJumJual($faktur){
                $data['detail'] = $this->detail->getAllWhere('id_barang,jumlah',['nofaktur'=>$faktur]);
                foreach($data['detail'] as $r){
                        $idbarang = $r['id_barang'];
                        $jumlahterjual = $r['jumlah']; 
                        $data['barang'] = $this->barang->getWhere('jumlah_terjual',['id'=>$idbarang]);
                        $jumlahjuallama = $data['barang']['jumlah_terjual'];
                        $jumlahjualbaru = $jumlahjuallama + $jumlahterjual;
                        $barang = ["jumlah_terjual"=>$jumlahjualbaru];
                        $this->barang->update($barang,['id'=>$idbarang]);  
                }
        }
}
?>

