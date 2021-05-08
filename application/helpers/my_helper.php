<?php 
    // membuat tanggal menjadi format indonesia ex : 12 Januari 2020
    function tglIndo($tgl){
        $tanggal = ltrim(substr($tgl,8,2),0);
        $bulan = getNamaBulan(substr($tgl,5,2));
        $tahun = substr($tgl,0,4);
        return $tanggal.' '.$bulan.' '.$tahun; 
    }
    // helper untuk memperbaiki kalimat error, karena validasi via ajax ada skript html <p>nama harus di isi</p>
    function bersihKalimatError($namafield){
        return str_replace("</p>","",str_replace("<p>","",form_error($namafield)));
    }
    function tglIndowithJam($tgl){
        $tanggal = ltrim(substr($tgl,8,2),0);
        $bulan = getNamaBulan(substr($tgl,5,2));
        $tahun = substr($tgl,0,4);
        $result = explode(" ",$tgl);
        return $tanggal.' '.$bulan.' '.$tahun.' - '.substr($result[1], 0, 8);
    }
    function getKotaProvinsi($status,$id){
        $ci = get_instance();
        $ci->load->model('BasicModel','basic');
        $info = $ci->basic->getRow('rajaongkir');
        $key  = $info['rajaongkir'];
        $curl = curl_init();
        if($status == 'kota'){
            $url = 'https://api.rajaongkir.com/starter/city?id='.$id;
        }else{
            $url = 'https://api.rajaongkir.com/starter/province?id='.$id;
        }
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: $key"
        ),
        ));
        $response = json_decode(curl_exec($curl),true);
        if($status=='kota'){
            return $response['rajaongkir']['results']['city_name'];
        }else{
            return $response['rajaongkir']['results']['province'];
        }
        $err = curl_error($curl);
        curl_close($curl);

    }
    function formatRupiah($text){
        return number_format($text,'0',',','.');
    }

    function manageStok($idSku,$jumlahlama,$jumlah,$status){
        if($status=="tambah"){
            $jumlahbaru = $jumlahlama+$jumlah;
        }else if($status=="kurang"){
            $jumlahbaru = $jumlahlama-$jumlah;
        }
        $data = ['jumlah'=>$jumlahbaru];
        $ci = get_instance();
        $ci->load->model('SkuModel','sku');
		$ci->sku->update($data,['kode'=>$idSku]);
    }

    function is_logged_in($menu){
        $ci = get_instance();
        if(!$ci->session->userdata('email')){
          redirect('admin/Authentikasi');
        }
        else{
          $jenis = $ci->session->userdata('id_jenis_user');
          if($jenis == 4){
              redirect('Home');
          }
          $queryMenu = $ci->db->get_where('tbl_menu',['nama'=>$menu])->row_array();
          $idMenu = $queryMenu['id'];
          $useraccess = $ci->db->get_where('tbl_akses',['id_jenis_user'=>$jenis,'id_menu'=>$idMenu]);
          if($useraccess->num_rows()<1){
            redirect('admin/Authentikasi/block');
          }
        }
    }

    // function is_logged_in(){
    //     $ci = get_instance();
    //     if(!$ci->session->userdata('email')){
    //       redirect('Home');
    //     }
    //     else{
    //       $jenis = $ci->session->userdata('id_jenis_user');
    //       $menu = $ci->uri->segment(2);
    //       $queryMenu = $ci->db->get_where('tbl_menu',['nama'=>$menu])->row_array();
    //       $idMenu = $queryMenu['id'];
    //       $useraccess = $ci->db->get_where('tbl_akses',['id_jenis_user'=>$jenis,'id_menu'=>$idMenu]);
    //       if($useraccess->num_rows()<1){
    //         redirect('Authentikasi/block');
    //       }
    //     }
    // }

    function addGambar($tujuan,$name){
        $upload_image = $_FILES[$name]['name'];
        $ci = get_instance();
		if($upload_image){
			$config['upload_path'] = "$tujuan";
			$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
			$config['max_size']     = '1028'; // 1 MB
			$ci->load->library('upload', $config);
			if ($ci->upload->do_upload($name)){
                $gbr = $ci->upload->data();
                $config['image_library']='gd2';
                $config['source_image']=$tujuan.$gbr['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= FALSE;
                $config['quality']= '60%';
                $config['new_image']= $tujuan.$gbr['file_name'];
                $ci->load->library('image_lib', $config);
                $ci->image_lib->resize();
        		return $gbr['file_name'];
			}
			else{
				echo $ci->upload->display_errors();
			}
		}
	}

	function deleteGambar($tujuan,$namagambar){
		unlink(FCPATH.$tujuan.$namagambar);
	}
  
    function set_access($jenis_id,$menu_id){
        $ci = get_instance();
        $result = $ci->db->get_where('tbl_akses',['id_jenis_user'=>$jenis_id,
                                                  'id_menu'=>$menu_id]);
        if($result->num_rows()>0){
          return "checked = checked";
        }
    }

    function getNamaBulan($angka){
        $text ="";
        switch($angka){
            case 1:
                $text = "Januari";
                break;
            case 2:
                $text = "Februari";
                break;
            case 3:
                $text = "Maret";
                break;
            case 4:
                $text = "April";
                break;
            case 5:
                $text = "Mei";
                break;
            case 6:
                $text = "Juni";
                break;
            case 7:
                $text = "Juli";
                break;
            case 8:
                $text = "Agustus";
                break;
            case 9:
                $text = "September";
                break;
            case 10:
                $text = "Oktober";
                break;                              
            case 11:
                $text = "November";
                break;
            case 12:
                $text = "Desember";
                break;   
        }
        return $text;
    }
    function hitCounter(){
        $ci = get_instance();
        $ci->load->library('HitCounter');
        $hit = new HitCounter();
        $hit->Hitung();
      }
    
    function tampilCounter(){
        $ci = get_instance();
        $ci->load->library('HitCounter');
        $hit = new HitCounter();
        return $hit->tampil();
    }
    
    function cekSessionUser(){
        $ci = get_instance();
        if($ci->session->userdata('id_jenis_user') != 4){
            $ci->session->unset_userdata('email');
            $ci->session->unset_userdata('nofaktur');
        }
    }
    
    function getKategoriDanJenis(){
        $ci = get_instance();
        $ci->load->model('BarangModel','barang');
        return $ci->barang->getKategoriDanJenisBarang();
    }

    function getJenis(){
        $ci = get_instance();
        $ci->load->model('JenisBarangModel','jenis');
        return $ci->jenis->getInfo('nama,url');
    }
    function seoFriendlyUrl($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        //return strtolower(trim($string, '_')).'.html';
        return strtolower(trim($string, '_')).'';
    }
    function makeSlug($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '_'));
    }
    function rating($rating){
        $ratingText="";
        for($i=1;$i<=$rating;$i++){
            $ratingText.='<i class="fas fa-star" style="color:orange"></i>';
        }
        return $ratingText;
    }
?>