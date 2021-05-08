<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dasboard extends CI_Controller {
        public function __construct(){
                parent::__construct();
                $this->load->model('PemesananModel','pemesanan');
                $this->load->model('BarangModel','barang');
                $this->load->model('DetailPemesananModel','detail');
                $this->load->model('UserModel','user');
                $this->load->helper('status_helper');
                is_logged_in('Dasboard');
        }

        public function index(){
                $data['judul']="Dasboard";
                $data['group']="Dasboard";
                $where = ['tanggal'=>date('Y-m-d')];
                $pendapatan = $this->pemesanan->getSumWhere('total',$where);
                $data['jumlahorder'] = $this->pemesanan->getCountRowWhere($where);
                $data['pelanggan'] = $this->user->getCountRowWhere(['id_jenis_user'=>4]);
                $data['pendapatan'] = $pendapatan['total'];
                $data['detail'] = $this->detail->getPemesananForDashboard();
                $data['barang'] = $this->barang->getBarangForDashboard();
                $data['user'] = $this->user->getUserForDashboard();
                $data['jumUser'] = $this->user->getRowUserForDashboard();
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/dasboard/dasboard');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }
        public function getPendapatan(){
                $data['pendapatan'] = $this->pemesanan->getReportPendapatan();
                echo json_encode($data['pendapatan']);
        }
}
?>