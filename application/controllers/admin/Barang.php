<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barang extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Barang');
                $this->load->model('BarangModel','barang');
                $this->load->model('JenisBarangModel','jenis');
                $this->load->model('KategoriBarangModel','kategori');
                $this->load->model('KategoriVariantModel','kategorivariant');
                $this->load->model('VariantSelectModel','variantSelect');
                $this->load->model('VariantModel','variant');
                $this->load->model('SkuModel','sku');
                $this->load->model('SkuUnitModel','skuUnit');
                $this->load->library('datatables'); 
                $this->load->helper('cookie');
        }

        public function index(){
                $data['judul']="Barang";
                $data['group']="Barang";
                $data['jenis'] = $this->jenis->getAll();
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/barang');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }
        public function variant($idBarang){
                $data['judul']="Variant";
                $data['group']="Barang";
                $data['id_barang'] = $idBarang;
                $variantSelect = $this->variantSelect->getSelect($idBarang);
                $data['variantSelect'] = $variantSelect;
                $i=0;
                foreach($variantSelect as $r){
                        $data['select'][$i] = $this->skuUnit->getSelect($idBarang,$r['id_kategori_variant']);
                        $data['variant'][$i++] = $this->variant->getAllWhere('*',['id_kategori_variant'=>$r['id_kategori_variant']]);
                }
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/variantBarang');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');       
        }
        public function tambahVariant($idBarang){
                $variantSelect = $this->variantSelect->getSelect($idBarang);
                $variant=[];
                $i=0;

                foreach($variantSelect as $r){
                        $variant[$i] = $this->input->post('variant-'.$i,true);
                        $i++;
                }
                if($variant){
                        if($variant[0] != NUll){
                                $this->session->unset_userdata('variant');
                                $this->session->set_userdata('variant',$variant);
                        }else{
                                $variant = $this->session->userdata('variant');
                        }
                }
                
                $data['idBarang'] = $idBarang;
                $skuAndSkuUnit = $this->getSkuAndSkuUnit($variantSelect,$variant,$idBarang);
                $data['sku']= $skuAndSkuUnit['sku'];
                $skuUnit = $skuAndSkuUnit['sku_unit'];
                $i=1;

                foreach($data['sku'] as $r){
                        $this->form_validation->set_rules('jumlah-'.$i,'Jumlah','required',[
                                'required'=>'%s harus disi',
                        ]);
                        $sku = $this->sku->getWhere('jumlah',['id_barang'=>$idBarang,'nama'=>$r['nama']]);
                        $data['sku'][$i-1]['jumlah_di_database'] = $sku['jumlah'];
                        $i++;
                }

                if($this->form_validation->run()==false){
                        $data['judul']="Data Variant";
                        $data['group']="Barang";
                        $this->load->view('backend/template/header',$data);        
                        $this->load->view('backend/template/sidebar');  
                        $this->load->view('backend/barang/jumlahVariant');        
                        $this->load->view('backend/template/footer');        
                        $this->load->view('backend/template/script');     
                }else{
                        $i=1;
                        $storeName=[];
                        foreach($data['sku'] as $r){
                                $nama = $r['nama'];
                                $storeName[$i-1]=$nama;
                                $sku = $this->sku->getWhere('id',['id_barang'=>$idBarang,'nama'=>$nama]);
                                if($sku){
                                        $data = [
                                                'jumlah'=>$this->input->post('jumlah-'.$i++),
                                        ];
                                        $this->sku->update($data,['id'=>$sku['id']]);
                                        
                                }else{
                                        $data = [
                                                'kode'=>$r['kode'],
                                                'jumlah'=>$this->input->post('jumlah-'.$i++),
                                                'id_barang'=>$idBarang,
                                                'nama'=>$nama
                                        ];
                                        $this->sku->insert($data);
                                }
                                
                        }
                        
                        foreach($skuUnit as $r){
                                $kode = $r['kode'];
                                $sku = $this->sku->getWhere('id',['kode'=>$kode]);
                                if($sku){
                                        $data = [
                                                'id_sku'=>$sku['id'],
                                                'id_barang'=>$idBarang,
                                                'id_kategori_variant'=>$r['id_kategori_variant'],
                                                'id_variant'=>$r['id_variant']
                                        ];
                                        $skuUnitDb = $this->skuUnit->getWhere('id',$data);
                                        if(!$skuUnitDb){
                                                $this->skuUnit->insert($data); 
                                        }   
                                }
                        }
                        $skuDb = $this->sku->getSkuNotInputJumlah($idBarang,$storeName);
                        foreach($skuDb as $r){
                                $this->skuUnit->delete(['id_sku'=>$r['id']]);
                                $this->sku->delete(['id'=>$r['id']]);
                        }
                        redirect('admin/Barang/');
                }

        }
        private function getSkuAndSkuUnit($variantSelect,$variant,$idBarang){
                $skuUnit = [];
                $sku=[];
                $i=0;
                $inc = 0;
                $incSku = 0;
                $jumSelect = count($variantSelect);
                if($jumSelect>1){
                        foreach($variantSelect as $r){
                                if($variant[$i]){
                                        foreach($variant[$i] as $v){
                                                if(isset($variant[$i+1])){
                                                        foreach($variant[$i+1] as $x){
                                                                $kode = $this->generateRandomString();
                                                                $namaKategori1 = $this->variant->getWhere('nama,id_kategori_variant',['id'=>$v]);
                                                                $namaKategori2 = $this->variant->getWhere('nama,id_kategori_variant',['id'=>$x]);
                                                                $sku[$incSku++] = [
                                                                        'id_barang'=>$idBarang,
                                                                        'kode'=>$kode,
                                                                        'nama'=>$namaKategori2['nama'].' ('.$namaKategori1['nama'].')',
                                                                        'jumlah'=>0
                                                                ];
                                                                $skuUnit[$inc]=[
                                                                        'id_variant'=>$v,
                                                                        'id_kategori_variant'=>$namaKategori1['id_kategori_variant'],
                                                                        'kode'=>$kode
                                                                ];
                                                                $inc++;
                                                                $skuUnit[$inc]=[
                                                                        'id_variant'=>$x,
                                                                        'id_kategori_variant'=>$namaKategori2['id_kategori_variant'],
                                                                        'kode'=>$kode
                                                                ];
                                                                $inc++;
                
                                                        }
                                                }
                                                
                                        }
                                }else{
                                        redirect('admin/Barang/editBarang/'.$idBarang);
                                }
                                $i++;
                        }
                }else if($jumSelect == 1){
                        foreach($variantSelect as $r){
                                if($variant[$i]){
                                        foreach($variant[$i] as $v){
                                                $kode = $this->generateRandomString();
                                                $namaKategori1 = $this->variant->getWhere('nama,id_kategori_variant',['id'=>$v]);
                                                $sku[$incSku++] = [
                                                        'id_barang'=>$idBarang,
                                                        'kode'=>$kode,
                                                        'nama'=>$namaKategori1['nama'],
                                                        'jumlah'=>0
                                                ];
                                                $skuUnit[$inc]=[
                                                        'id_variant'=>$v,
                                                        'id_kategori_variant'=>$namaKategori1['id_kategori_variant'],
                                                        'kode'=>$kode
                                                ];
                                                $inc++;
        
                                        }
                                }else{
                                        redirect('admin/Barang/editBarang/'.$idBarang);
                                }
                                $i++;
                        }
                }
                return ['sku_unit'=>$skuUnit,'sku'=>$sku];
        }
        private function generateRandomString() {
                $length = 5;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
        }
        public function insertBarang(){
                $this->_validationBarang('insert');
                if($this->form_validation->run()==false){
                        $data['judul']="Tambah Barang";
                        $data['group']="Barang";
                        $data['jenis'] = $this->jenis->getAll();
                        $data['kategori'] = $this->kategori->getAll();
                        $data['variant'] = $this->kategorivariant->getAll();
                        $this->load->view('backend/template/header',$data);        
                        $this->load->view('backend/template/sidebar');        
                        $this->load->view('backend/barang/insertBarang');        
                        $this->load->view('backend/template/footer');        
                        $this->load->view('backend/template/script');       
                }else{
                        $i = $this->input;
                        $nama = htmlspecialchars($i->post('nama',true));
                        $harga = str_replace(".","",htmlspecialchars($i->post('harga',true)));
                        $diskon = str_replace(".","",htmlspecialchars($i->post('diskon',true)));
                        $berat = str_replace(".","",htmlspecialchars($i->post('berat',true)));
                        $total = $harga - ($harga * ($diskon / 100));
                        $foto = addGambar('./resource/',"foto");
                        $url = seoFriendlyUrl($nama);
                        $data = [
                                'nama'=>$nama,
                                'id_kategori_barang'=>htmlspecialchars($i->post('kategori',true)),
                                'id_jenis_barang'=>htmlspecialchars($i->post('jenis',true)),
                                'harga'=>$harga,
                                'diskon'=>$diskon,
                                'total_harga'=>$total,
                                'berat'=>$berat,
                                'slug'=>$url,
                                'short_deskripsi'=>htmlspecialchars($i->post('deskripsi-singkat',true)),
                                'deskripsi'=>$i->post('deskripsi'),
                                'tag'=>htmlspecialchars($i->post('tag',true)),
                                'brand'=>htmlspecialchars($i->post('brand',true)),
                                'brand_slug'=>makeSlug(htmlspecialchars($i->post('brand',true))),
                                'foto'=>$foto
                        ];
                        if($_FILES['foto2']['name']){
                                $foto2 = addGambar('./resource/',"foto2"); 
                                $data['foto2'] = $foto2; 
                        }
                        if($_FILES['foto3']['name']){
                                $foto3 = addGambar('./resource/',"foto3");  
                                $data['foto3'] = $foto3; 
                        }
                        if($_FILES['foto4']['name']){
                                $foto4 = addGambar('./resource/',"foto4");  
                                $data['foto4'] = $foto4; 
                        }
                        
                        $this->barang->insert($data);
                        $barang = $this->barang->getWhere('id',['slug'=>$url]);
                        $id = $barang['id'];
                        echo $id;
                        foreach($this->input->post("variant") as $r){
                                $variant = [
                                        'id_barang'=>$id,
                                        'id_kategori_variant'=>$r
                                ];
                                $this->variantSelect->insert($variant);
                        }

                        $this->session->set_flashdata('pesan', "<script>toastr.success('$nama Berhasil ditambahkan')</script>");
                        redirect('admin/Barang');
                }
        }
        public function editBarang($id){
                $this->_validationBarang('edit');
                if($this->form_validation->run()==false){
                        $data['judul']="Barang";
                        $data['group']="Barang";
                        $data['jenis'] = $this->jenis->getAll();
                        $data['kategori'] = $this->kategori->getAll();
                        // $data['variant'] = $this->kategorivariant->getAll();
                        $data['barang'] = $this->barang->getWhere('*',['id'=>$id]);
                        // $data['variantSelect'] = $this->variantSelect->getAllWhere('*',['id_barang'=>$id]);
                        $this->load->view('backend/template/header',$data);        
                        $this->load->view('backend/template/sidebar');      
                        $this->load->view('backend/barang/editBarang');   
                        $this->load->view('backend/template/footer');        
                        $this->load->view('backend/template/script');    
                }else{
                        $i = $this->input;
                        $nama = htmlspecialchars($i->post('nama',true));
                        $harga = str_replace(".","",htmlspecialchars($i->post('harga',true)));
                        $diskon = str_replace(".","",htmlspecialchars($i->post('diskon',true)));
                        $berat = str_replace(".","",htmlspecialchars($i->post('berat',true)));
                        $total = $harga - ($harga * ($diskon / 100));
                        $url = seoFriendlyUrl($nama);
                        $data = [
                                'nama'=>$nama,
                                'slug'=>$url,
                                'id_kategori_barang'=>htmlspecialchars($i->post('kategori',true)),
                                'id_jenis_barang'=>htmlspecialchars($i->post('jenis',true)),
                                'harga'=>$harga,
                                'diskon'=>$diskon,
                                'total_harga'=>$total,
                                'berat'=>$berat,
                                'short_deskripsi'=>htmlspecialchars($i->post('deskripsi-singkat',true)),
                                'deskripsi'=>$i->post('deskripsi'),
                                'tag'=>htmlspecialchars($i->post('tag',true)),
                                'brand'=>htmlspecialchars($i->post('brand',true)),
                                'brand_slug'=>makeSlug(htmlspecialchars($i->post('brand',true))),
                        ];
                        $where = ['id'=>$id];
                        $gambar = $this->barang->getWhere('foto,foto2,foto3,foto4',$where);

                        if($_FILES['foto']['name']){
                                $gambar['foto']?deleteGambar('resource/',$gambar['foto']):'';
                                $foto = addGambar('./resource/',"foto");
                                $data['foto'] = $foto; 
                        }
                        if($_FILES['foto2']['name']){
                                $gambar['foto2']?deleteGambar('resource/',$gambar['foto2']):'';
                                $foto2 = addGambar('./resource/',"foto2"); 
                                $data['foto2'] = $foto2; 
                        }
                        if($_FILES['foto3']['name']){
                                $gambar['foto3']?deleteGambar('resource/',$gambar['foto3']):'';
                                $foto3 = addGambar('./resource/',"foto3");  
                                $data['foto3'] = $foto3; 
                        }
                        if($_FILES['foto4']['name']){
                                $gambar['foto4']?deleteGambar('resource/',$gambar['foto4']):'';
                                $foto4 = addGambar('./resource/',"foto4");  
                                $data['foto4'] = $foto4; 
                        }
                        
                        $this->barang->update($data,$where);
                        
                        // $this->variantSelect->delete(['id_barang'=>$id]);

                        // foreach($this->input->post("variant") as $r){
                        //         $variant = [
                        //                 'id_barang'=>$id,
                        //                 'id_kategori_variant'=>$r
                        //         ];
                        //         $this->variantSelect->insert($variant);
                        // }

                        $this->session->set_flashdata('pesan', "<script>toastr.info('$nama Berhasil ditambah')</script>");
                        redirect('admin/Barang');
                }
                
        }
        private function _validationBarang($tipe){
                $this->form_validation->set_rules('nama', 'Nama Barang', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);
                $this->form_validation->set_rules('harga', 'Harga Barang', 'required',
                                                [
                                                    'required'=>"%s harus diisi"
                                                ]);
                $this->form_validation->set_rules('diskon', 'Diskon', 'numeric|max_length[2]',
                                                [
                                                    'numeric'=>"%s isi dengan angka",
                                                    'max_length[2]'=>"%s melebihi batas"               
                                                ]);
                $this->form_validation->set_rules('berat', 'Berat', 'required|numeric',
                                                [
                                                    'required'=>"%s harus diisi",    
                                                    'numeric'=>"%s isi dengan angka"               
                                                ]);
                $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required',
                                                [
                                                    'required'=>"%s harus diisi"              
                                                ]);
                $this->form_validation->set_rules('deskripsi-singkat', 'Deskripsi Singkat', 'required',
                                                [
                                                    'required'=>"%s harus diisi"              
                                                ]);
                $this->form_validation->set_rules('tag', 'Tag', 'required',
                                                [
                                                    'required'=>"%s harus diisi"              
                                                ]);
                $this->form_validation->set_rules('brand', 'Brand', 'required',
                                                [
                                                    'required'=>"%s harus diisi"              
                                                ]);
                if($tipe == "insert"){
                        $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]|callback_requiredFile[foto]',
                                                [
                                                        'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                        'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                        'requiredFile'=>'%s tidak boleh kosong'
                                                ]);
                }else{
                        $this->form_validation->set_rules('foto','Foto','callback_validateSize[foto]|callback_validateTypeFile[foto]',
                                                [
                                                        'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                        'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                ]);
                }
                $this->form_validation->set_rules('foto2','Foto','callback_validateSize[foto2]|callback_validateTypeFile[foto2]',
                                                [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                ]);
                $this->form_validation->set_rules('foto3','Foto','callback_validateSize[foto3]|callback_validateTypeFile[foto3]',
                                                [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                ]);
                $this->form_validation->set_rules('foto4','Foto','callback_validateSize[foto4]|callback_validateTypeFile[foto4]',
                                                [
                                                    'validateTypeFile'=>'%s harus berformat PNG dan JPG',
                                                    'validateSize'=>'%s hanya boleh dibawah 1 Mb',
                                                ]);
        }

        public function getBarang(){
                header('Content-Type: application/json');
                $data = $this->barang->getAllBarang();
                echo $data;
        }
        
        private function _hapusFotoProdukDetail($gambar){
                if($gambar['foto2']!=""){
                        deleteGambar('resource/',$gambar['foto2']); 
                }
                if($gambar['foto3']!=""){
                        deleteGambar('resource/',$gambar['foto3']); 
                }
                if($gambar['foto4']!=""){
                        deleteGambar('resource/',$gambar['foto4']); 
                }
        }

        public function deleteBarang($idBarang){
                $where = ['id'=>$idBarang];
                $gambar = $this->barang->getWhere('nama,foto,foto2,foto3,foto4',$where);
                $nama = $gambar['nama'];
                deleteGambar('resource/',$gambar['foto']);
                $this->_hapusFotoProdukDetail($gambar);
                $this->variantSelect->delete(['id_barang'=>$idBarang]);
                $this->skuUnit->delete(['id_barang'=>$idBarang]);
                $this->sku->delete(['id_barang'=>$idBarang]);
                $this->barang->delete(['id'=>$idBarang]);
                $result['pesan'] = "berhasil";
                $this->session->set_flashdata('pesan',"<script>toastr.error('$nama berhasil hapus')</script>");
		redirect('admin/Barang');
        }
        
        public function ambilByIdBarang(){
		$id=$this->input->post('id');
		$where = ['id'=>$id];
                $result = $this->barang->getWhere('*',$where);
                $result['harga'] = number_format($result['harga'],0,',','.');
                $result['berat'] = number_format($result['berat'],0,',','.');
		echo json_encode($result);
        }

        public function detailBarang($id){
                $data['judul']="Detail Barang";
                $data['group']="Barang";
                $data['barang'] = $this->barang->getDetailBarang($id);
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/detailbarang');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');       
        }

        public function JenisBarang(){
                $data['judul']="Jenis Barang";
                $data['group']="Jenis Barang";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/barang/jenisbarang');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        public function insertJenisBarang(){
                $validation = $this->_validationJenisBarang();
                if($validation['status']==0){
                        $validation['pesan'] = "Gagal";
                }else{
                        $id = htmlspecialchars($this->input->post('id'));
                        $data = [
                                "nama"=>htmlspecialchars($this->input->post('nama',true)),
                                'url'=>makeSlug(htmlspecialchars($this->input->post('nama',true)))
                        ];
                        // proses insert data
                        if($id == ""){
                                $this->jenis->insert($data);
                        // proses update data        
                        }else{
                                $where = ['id'=>$id];
                                $this->jenis->update($data,$where);
                        }
                        $validation['pesan'] = "Berhasil";
                }
                echo json_encode($validation);
        }

        private function _validationJenisBarang(){
                $result['status']=1;
                $this->form_validation->set_rules('nama', 'Jenis Barang', 'required',
                                                [
                                                    'required'=>"%s harus diisi"    
                                                ]);

                if ($this->form_validation->run() ==FALSE) {
                        $result['errornama'] = bersihKalimatError('nama');
                        $result['status']=0;
                }
                return $result;  
        }

        public function getJenis(){
                header('Content-Type: application/json');
                $data = $this->jenis->getAllJenis();
                echo $data;
        }

        public function deleteJenisBarang(){
                $where = ['id'=>htmlspecialchars($this->input->post('id',true))];
                $this->jenis->delete($where);
                $result['pesan'] = "berhasil";
		echo json_encode($result);
        }

        public function ambilByIdJenisBarang(){
		$id=$this->input->post('id');
		$where = ['id'=>$id];
                $result = $this->jenis->getWhere('*',$where);
		echo json_encode($result);
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
?>