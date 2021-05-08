<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rating extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Pemesanan');
                $this->load->model('RatingModel','rating');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Rating";
                $data['group']="Rating";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar'); 
                $this->load->view('backend/pemesanan/rating');           
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }
        public function getRating(){
            header('Content-Type: application/json');
            $data = $this->rating->getAllRating();
            echo $data;
        }

}
?>