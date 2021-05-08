<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class RestTransaksi extends REST_Controller {
	public function __construct($config = 'rest'){
		parent::__construct($config);
        $this->load->database();
    }
    function index_post(){
        $this->load->model('PemesananModel','pemesanan');
        $status = $this->post('fraud_status');
        $where = ['nofaktur'=>$this->post('order_id')];
        
        if($status =='accept'){
            $data = array('status'=>2);
            $this->pemesanan->update($data,$where);
            $this->response(['message'=>'Success'], 200);
        }
        else if($this->post('transaction_status')=='expire'){
            $nofaktur = $this->post('order_id');
            $where = ['nofaktur'=>$nofaktur];
            $this->_hapusDetail($nofaktur);
            $this->pemesanan->delete($where);
            $this->response(['message'=>'Success'], 200);
        }
        
    }

    private function _hapusDetail($nofaktur){
        $this->load->model('DetailPemesananModel','detail');
		$data = $this->detail->getAllWhere('sku,jumlah,id',['nofaktur'=>$nofaktur]);
		foreach($data as $r):
			$sku = $r['sku'];
			$jumlahbeli = $r['jumlah'];
			$id = $r['id'];
			$stok = $this->_getStok($sku);
			manageStok($sku,$stok,$jumlahbeli,'tambah');
			$this->detail->delete(['id'=>$id]);
		endforeach;
	}

	private function _getStok($sku){
        $this->load->model('SkuModel','sku');
		$data = $this->sku->getWhere('jumlah',['id'=>$sku]);
		return $data['jumlah'];
    }
    
	
}