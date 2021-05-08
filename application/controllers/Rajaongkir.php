<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rajaongkir extends CI_Controller
{
    private $api_key = '';
    private $province_from ='' ;
    private $city_from ='';
    public function __construct(){
		parent::__construct();
		$this->setKey();
    }
    public function setKey(){
        $basic = $this->db->query("SELECT * FROM tbl_basic limit 1")->row_array();
        $this->api_key = $basic['rajaongkir'];
        $this->province_from = $basic['provinsi'];
        $this->city_from = $basic['kota'];
    }
    public function get_all_province($selected='')
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 3000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ".$this->api_key
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $provinces = json_decode($response,TRUE);
            $output = '<select name ="provinsi" id="provinsi" class="form-control"><option value="">--Pilih Provinsi--</option>';
            if(isset($provinces['rajaongkir']['results'])){
                foreach ( $provinces['rajaongkir']['results'] as $province) {
                    $true = '';
                    if($selected == $province['province_id']){
                        $true = 'selected';
                    }else{
                        $true = '';
                    }
                    $output .= "<option value='".$province['province_id']."' ".$true.">".$province['province']."</option>";
                }
                $output .= "</select>";
                echo $output;
            }else{
                echo '<select name ="province_id" id="province_id" class="form-control"><option value="">Gagal load provinsi</option></select>';
            }
        }
    }
    public function get_city_by_province($province = '',$selected=''){
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=".$province,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 3000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ".$this->api_key
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            die();
        } else {
            $cities = json_decode($response,TRUE);
            if(isset($cities['rajaongkir']['results'])){
                
                $cities = json_decode($response,TRUE);
                $output = '<select name ="kota" id="kota" class="form-control"><option value="">--Pilih Kota--</option>';
                foreach ( $cities['rajaongkir']['results'] as $city) {
                    $true = '';
                    if($selected == $city['city_id']){
                        $true = 'selected';
                    }else{
                        $true = '';
                    }
                    $output .= "<option value='".$city['city_id']."' $true>".$city['city_name']."</option>";
                }
                $output .= "</select>";
                echo $output;
            }else{
                echo '<select name ="city_id" id="city_id" class="form-control"><option value="">Gagal load kota</option></select>';
            }
        }
    }
    public function get_kecamatan($city = '',$selected=''){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$city,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 3000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ".$this->api_key
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            die();
        } else {
            $cities = json_decode($response,TRUE);
            if(isset($cities['rajaongkir']['results'])){
                
                $cities = json_decode($response,TRUE);
                $output = '<select name ="kecamatan" id="kecamatan" class="form-control"><option value="">--Pilih Kecamatan--</option>';
                foreach ( $cities['rajaongkir']['results'] as $subdistrict) {
                    $true = '';
                    if($selected == $subdistrict['subdistrict_id']){
                        $true = 'selected';
                    }else{
                        $true = '';
                    }
                    $output .= "<option value='".$subdistrict['subdistrict_id']."' $true>".$subdistrict['subdistrict_name']."</option>";
                }
                $output .= "</select>";
                echo $output;
            }else{
                echo '<select name ="kecamatan" id="kecamatan" class="form-control"><option value="">Gagal load kecamatan</option></select>';
            }
        }
    }
    function get_courier(){
        //Courier available for basic package
        echo '<select name="courier" id="courier" class="form-control"><option>--Pilih Kurir--</option><option>jne</option><option>tiki</option><option>pos</option></select>';
    }
    function get_ongkir($destination='',$weight=0,$courier =''){
        // $company = $this->db->query("SELECT * FROM company limit 1")->row_array();

        // $province_origin = $company['province_id']; //Sumut
        // $city_origin = $company['city_id']; //Medan
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=".$this->city_from."&originType=city&destination=".$destination."&destinationType=subdistrict&weight=".$weight."&courier=".$courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: ".$this->api_key
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $cost = json_decode($response,TRUE);
            if(isset($cost['rajaongkir']['results'])){
                $cost = json_decode($response,TRUE);
                // echo var_dump($cost).'<br><br>';
                $output = '<select name ="layanan" id="layanan" class="form-control"><option value="">--Pilih Ongkir--</option>';
                $ongkir = $cost['rajaongkir']['results'][0]['costs'];

                foreach ( $ongkir as $cost_detail) {
                    // echo var_dump($cost_detail);
                    if($cost_detail['service'] != 'GOKIL'){
                        $output .= "<option value='".$cost_detail['cost'][0]['value']."|".$cost_detail['service']."|".$cost_detail['description']."|".$cost_detail['cost'][0]['etd']."'>".$cost_detail['description']." (Rp.".number_format($cost_detail['cost'][0]['value'],0,",",".").")</option>";
                    }
                }
                $output .= "</select>";
                echo $output;
            }else{
                echo '<select name ="layanan" id="layanan" class="form-control"><option value="">--Lengkapi Data Pengiriman--</option></select>';
            }
        }
    }
    function cek_resi(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "waybill=SOCAG00183235715&courier=jne",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: af82e0205fa12adf82341c4260ffca9f"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
    }

}
