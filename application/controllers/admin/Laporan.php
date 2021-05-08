<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends CI_Controller {
        public function __construct(){
            parent::__construct('Laporan');
            $this->load->model('BarangModel','barang');
            $this->load->model('JenisBarangModel','jenis');
            $this->load->model('PemesananModel','pemesanan');
            $this->load->model('DetailPemesananModel','orderDetail');
            $this->load->library('datatables'); 
            $this->load->library('PDF'); 
        }

        public function index(){
            $data['judul']="Stok Sedikit";
            $data['group']="Stok sedikit";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');        
            $this->load->view('backend/laporan/barang');        
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');        
        }

        public function getBarang(){
            header('Content-Type: application/json');
            $data = $this->barang->getBarangSedikit();
            echo $data;
        }
        
        function cetakLaporanStokSedikit(){
            $title = 'Laporan Stok Barang Sedikit';
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);

            
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,6,'Laporan Stok Barang Sedikit',0,1,'C');
            
            $pdf->SetFont('Arial','',10);

            $barangSedikit = $this->barang->getLaporanBarangSedikit();
            $pdf->Cell(10,7,'',0,1);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(70,6,'BARANG',1,0,'C');
            $pdf->Cell(18,6,'JENIS',1,0,'C');
            $pdf->Cell(22,6,'DISKON (%)',1,0,'C');
            $pdf->Cell(30,6,'TOTAL HARGA',1,0,'C');
            $pdf->Cell(35,6,'STOK',1,1,'C');

            $pdf->SetFont('Arial','',10);
            $i=1;
            $cellWidth=70;
            $cellHeight=6;

            foreach($barangSedikit as $r){
                $line = $this->_getLineFpdf($pdf,$r['nama'],$cellWidth);
                $pdf->Cell(10,($line * $cellHeight),$i++,1,0,'C');

                // ini config supaya auto wrap untuk menampilkan nama barang
                $xPos=$pdf->GetX();
                $yPos=$pdf->GetY();
                $pdf->MultiCell($cellWidth,$cellHeight,$r['nama'],1);
                $pdf->SetXY($xPos + $cellWidth , $yPos);

                $pdf->Cell(18,($line * $cellHeight),$r['jenis'],1,0,'C');
                $pdf->Cell(22,($line * $cellHeight),$r['diskon'],1,0,'C');
                $pdf->Cell(30,($line * $cellHeight),number_format($r['total_harga'],0,',','.'),1,0,'C');
                $pdf->Cell(35,($line * $cellHeight),$r['jumlah'],1,1,'C');
            }

            $pdf->Output();

            
        }

        function cetakLaporanDetail($faktur){
            $title = $faktur;
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);
            $pdf->SetDisplayMode(100,'default');
            
            $pemesanan = $this->pemesanan->getDetailPemesanan($faktur);
            $kota = getKotaProvinsi('kota',$pemesanan['kota']);
            $provinsi = getKotaProvinsi('provinsi',$pemesanan['provinsi']);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(60,6,'Laporan Detail Berdasarkan Faktur',0,0,'C');
            $pdf->Cell(127,6,'Faktur : '.$faktur,0,1,'R');
            
            $pdf->Cell(10,7,'',0,1);
            $pdf->SetFont('Arial','',10);

            $pdf->Cell(35,6,'Nama ',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$pemesanan['nama'],0,0,'L');

            $pdf->Cell(40,6,'',0,0,'L');

            $pdf->Cell(20,6,'Tanggal',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'R');
            $pdf->Cell(30,6,tglIndo($pemesanan['tanggal']),0,1,'L');

            $pdf->Cell(35,6,'Nomor Telpon ',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$pemesanan['notelpon'],0,0,'L');

            $pdf->Cell(40,6,'',0,0,'L');

            $pdf->Cell(20,6,'Status',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'R');
            $pdf->Cell(30,6,'Selesai',0,1,'L');
            
            $pdf->Cell(35,6,'Email ',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$pemesanan['email'],0,0,'L');

            $pdf->Cell(40,6,'',0,0,'L');

            $pdf->Cell(20,6,'Nomor Resi',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'R');
            $pdf->Cell(30,6,$pemesanan['resikurir'],0,1,'L');
            
            $pdf->Cell(35,6,'Alamat ',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$pemesanan['alamat'],0,1,'L');
            
            $pdf->Cell(35,6,'Provinsi ',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$provinsi,0,1,'L');

            $pdf->Cell(35,6,'Kota ',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$kota,0,1,'L');

            $pdf->Cell(35,6,'Kode Pos',0,0,'L');
            $pdf->Cell(5,6,': ',0,0,'L');
            $pdf->Cell(50,6,$pemesanan['kode_pos'],0,1,'L');

            $orderDetail = $this->orderDetail->getAllDetailPemesanan($faktur);
            // var_dump($orderDetail);
            $pdf->Cell(10,7,'',0,1);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(70,6,'BARANG',1,0,'C');
            $pdf->Cell(20,6,'JUMLAH',1,0,'C');
            $pdf->Cell(40,6,'HARGA',1,0,'C');
            $pdf->Cell(45,6,'TOTAL',1,1,'C');

            $pdf->SetFont('Arial','',10);
            $i=1;
            $cellWidth=70;
            $cellHeight=6;

            foreach($orderDetail as $r){
                $line = $this->_getLineFpdf($pdf,$r->nama.' '.$r->sku,$cellWidth);
                $pdf->Cell(10,($line * $cellHeight),$i++,1,0,'C');

                // ini config supaya auto wrap untuk menampilkan nama barang
                $xPos=$pdf->GetX();
                $yPos=$pdf->GetY();
                $pdf->MultiCell($cellWidth,$cellHeight,$r->nama.' '.$r->sku,1);
                $pdf->SetXY($xPos + $cellWidth , $yPos);

                $pdf->Cell(20,($line * $cellHeight),$r->jumlah,1,0,'C');
                $pdf->Cell(40,($line * $cellHeight),number_format($r->total_harga,'0',',','.'),1,0,'C');
                $pdf->Cell(45,($line * $cellHeight),number_format($r->subtotal,'0',',','.'),1,1,'R');
            }

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(140,6,'SUBTOTAL',1,0,'C');
            $pdf->Cell(45,6,number_format($pemesanan['total'],'0',',','.'),1,1,'R');
            $pdf->Cell(140,6,'ONGKIR',1,0,'C');
            $pdf->Cell(45,6,number_format($pemesanan['ongkir'],'0',',','.'),1,1,'R');
            $pdf->Cell(140,6,'TOTAL',1,0,'C');
            $pdf->Cell(45,6,number_format($pemesanan['total']+$pemesanan['ongkir'],'0',',','.'),1,1,'R');
            $pdf->Output();

            
        }

        private function _getLineFpdf($pdf,$textToWrap,$cellWidth){
            $line = 0;
            if($pdf->GetStringWidth($textToWrap) < $cellWidth){
                $line=1;
            }else{
                $textLength=strlen($textToWrap); 
                $errMargin=10;  
                $startChar=0;  
                $maxChar=0;  
                $textArray=array(); 
                $tmpString="";  
                
                while($startChar < $textLength){ 
                    while($pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) && ($startChar+$maxChar) < $textLength ) {
                        $maxChar++;
                        $tmpString=substr($textToWrap,$startChar,$maxChar);
                    }
                    $startChar=$startChar+$maxChar;
                    array_push($textArray,$tmpString);
                    $maxChar=0;
                    $tmpString='';
                }
                //get number of line
                $line=count($textArray);
            }
            return $line;
        }

        // Laporan Harian
        public function laporanHarian(){
            $data['judul']="Laporan Harian";
            $data['group']="Laporan Harian";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');   
            $this->load->view('backend/laporan/laporanHarian'); 
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');     
        }
        public function getTotalByHarian(){
            $tanggal = $this->input->post('tanggal');
            $data = $this->pemesanan->getTotalByHarian($tanggal);
            echo number_format($data['total'],'0',',','.');
        }
        public function getLaporanByHarian(){
            header('Content-Type: application/json');
            $tanggal = $this->input->post('tanggal');
            $data = $this->pemesanan->getPemesananByHarian($tanggal);
            echo $data;
        }
        function cetakLaporanHarian($tanggal){
            $title = $tanggal;
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,6,'Laporan Harian',0,0,'C');
            $pdf->Cell(157,6,'Tanggal : '.tglIndo($tanggal),0,1,'R');

            $pdf->Cell(10,7,'',0,1);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(30,6,'FAKTUR',1,0,'C');
            $pdf->Cell(50,6,'CUSTOMER',1,0,'C');
            $pdf->Cell(30,6,'SUBTOTAL',1,0,'C');
            $pdf->Cell(30,6,'ONGKIR',1,0,'C');
            $pdf->Cell(35,6,'TOTAL',1,1,'C');

            $pdf->SetFont('Arial','',10);
            $pemesananHarian = $this->pemesanan->getPemesananCetakHarian($tanggal);
            $i=1;
            $totalPendapatanHarian = 0;
            foreach($pemesananHarian as $r){
                $total = $r['total']+$r['ongkir'];
                $totalPendapatanHarian +=$total;
                $pdf->Cell(10,6,$i++,1,0,'C');
                $pdf->Cell(30,6,$r['nofaktur'],1,0,'C');
                $pdf->Cell(50,6,$r['nama'],1,0,'C');
                $pdf->Cell(30,6,number_format($r['total'],'0',',','.'),1,0,'C');
                $pdf->Cell(30,6,number_format($r['ongkir'],'0',',','.'),1,0,'C');
                $pdf->Cell(35,6,number_format($total,'0',',','.'),1,1,'R');
            }

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(150,6,'TOTAL',1,0,'C');
            $pdf->Cell(35,6,number_format($totalPendapatanHarian,'0',',','.'),1,1,'R');

            $pdf->Output();
        }
        
        // laporan Mingguan
        public function laporanMingguan(){
            $data['judul']="Laporan Mingguan";
            $data['group']="Laporan Mingguan";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');   
            $this->load->view('backend/laporan/laporanMingguan'); 
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');     
        }
        public function getLaporanMingguan(){
            header('Content-Type: application/json');
            $minggu = $this->input->post('minggu');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $data = $this->pemesanan->getPemesananMingguan($minggu,$bulan,$tahun);
            echo $data;
        }
        public function getTotalMingguan(){
            $minggu = $this->input->post('minggu');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $data = $this->pemesanan->getTotalPemesananMingguan($minggu,$bulan,$tahun);
            echo number_format($data['total'],'0',',','.');
        }
        function cetakLaporanMingguan($minggu,$bulan,$tahun){
            $title = 'Laporan Minggu ke '.$minggu. ', '.getNamaBulan($bulan).' '.$tahun;
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(31,6,'Laporan Mingguan',0,0,'C');
            $pdf->Cell(157,6,'Waktu : '.'Minggu ke '.$minggu. ', '.getNamaBulan($bulan).' '.$tahun,0,1,'R');

            $pdf->Cell(10,7,'',0,1);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(70,6,'Tanggal',1,0,'C');
            $pdf->Cell(110,6,'Total',1,1,'C');

            $pdf->SetFont('Arial','',10);
            $pemesanan = $this->pemesanan->getPemesananCetakMingguan($minggu,$bulan,$tahun);
            
            $totalMingguan = 0 ;
            $i=1;
            foreach($pemesanan as $r){
                $totalMingguan +=$r['total'];
                $pdf->Cell(10,6,$i++,1,0,'C');
                $pdf->Cell(70,6,tglIndo($r['tanggal']),1,0,'C');
                $pdf->Cell(110,6,number_format($r['total'],'0',',','.'),1,1,'R');
            }

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,6,'TOTAL',1,0,'C');
            $pdf->Cell(110,6,number_format($totalMingguan,'0',',','.'),1,1,'R');

            $pdf->Output();
        }

        // laporan bulanan
        public function laporanBulanan(){
            $data['judul']="Laporan Bulanan";
            $data['group']="Laporan Bulanan";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');   
            $this->load->view('backend/laporan/laporanBulanan'); 
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');     
        }
        public function getLaporanBulanan(){
            header('Content-Type: application/json');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $data = $this->pemesanan->getPemesananBulanan($bulan,$tahun);
            echo $data;
        }
        public function getTotalBulan(){
            $tahun = $this->input->post('tahun');
            $bulan = $this->input->post('bulan');
            $data = $this->pemesanan->getTotalPemesananBulan($bulan,$tahun);
            echo number_format($data['total'],'0',',','.');
        }
        function cetakLaporanBulanan($bulan,$tahun){
            $title = 'Laporan Bulan '.getNamaBulan($bulan).' '.$tahun;
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(31,6,'Laporan Bulanan',0,0,'C');
            $pdf->Cell(157,6,'Waktu : '.'Bulan '.getNamaBulan($bulan).' '.$tahun,0,1,'R');

            $pdf->Cell(10,7,'',0,1);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(70,6,'Minggu',1,0,'C');
            $pdf->Cell(110,6,'Total',1,1,'C');

            $pdf->SetFont('Arial','',10);
            
            $pemesanan = $this->pemesanan->getPemesananCetakBulanan($bulan,$tahun);
            $totalBulanan = 0 ;
            $i=1;
            foreach($pemesanan as $r){
                $totalBulanan +=$r['total'];
                $pdf->Cell(10,6,$i++,1,0,'C');
                $pdf->Cell(70,6,$r['minggu'],1,0,'C');
                $pdf->Cell(110,6,number_format($r['total'],'0',',','.'),1,1,'R');
            }

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,6,'TOTAL',1,0,'C');
            $pdf->Cell(110,6,number_format($totalBulanan,'0',',','.'),1,1,'R');

            $pdf->Output();
        }

        // laporan tahunan
        public function laporanTahunan(){
            $data['judul']="Laporan Tahunan";
            $data['group']="Laporan Tahunan";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');   
            $this->load->view('backend/laporan/laporanTahunan'); 
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');     
        }
        public function getLaporanTahunan(){
            header('Content-Type: application/json');
            $tahun = $this->input->post('tahun');
            $data = $this->pemesanan->getPemesananTahunan($tahun);
            echo $data;
        }
        public function getTotalTahun(){
            $tahun = $this->input->post('tahun');
            $data = $this->pemesanan->getTotalPemesananTahun($tahun);
            echo number_format($data['total'],'0',',','.');
        }
        function cetakLaporanTahunan($tahun){
            $title = 'Laporan Tahun '.$tahun;
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(31,6,'Laporan Tahunan',0,0,'C');
            $pdf->Cell(157,6,'Waktu : '.'Tahun '.$tahun,0,1,'R');

            $pdf->Cell(10,7,'',0,1);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(70,6,'Bulan',1,0,'C');
            $pdf->Cell(110,6,'Total',1,1,'C');

            $pdf->SetFont('Arial','',10);
            
            $pemesanan = $this->pemesanan->getPemesananCetakTahun($tahun);
            $totalTahun = 0 ;
            $i=1;
            foreach($pemesanan as $r){
                $totalTahun +=$r['total'];
                $pdf->Cell(10,6,$i++,1,0,'C');
                $pdf->Cell(70,6,getNamaBulan($r['bulan']),1,0,'C');
                $pdf->Cell(110,6,number_format($r['total'],'0',',','.'),1,1,'R');
            }

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,6,'TOTAL',1,0,'C');
            $pdf->Cell(110,6,number_format($totalTahun,'0',',','.'),1,1,'R');

            $pdf->Output();
        }

        // laporan custom
        public function getTotalByCustom(){
            $tanggalawal = $this->input->post('tanggalawal');
            $tanggalakhir = $this->input->post('tanggalakhir');
            $data = $this->pemesanan->getTotalByCustom($tanggalawal,$tanggalakhir);
            echo number_format($data['total'],'0',',','.');
        }
        public function getLaporanByCustom(){
            header('Content-Type: application/json');
            $tanggalawal = $this->input->post('tanggalawal');
            $tanggalakhir = $this->input->post('tanggalakhir');
            $data = $this->pemesanan->getPemesananByCustom($tanggalawal,$tanggalakhir);
            echo $data;
        }
        public function laporanCustom(){
            $data['judul']="Laporan Custom";
            $data['group']="Laporan Custom";
            $this->load->view('backend/template/header',$data);        
            $this->load->view('backend/template/sidebar');   
            $this->load->view('backend/laporan/laporanCostum'); 
            $this->load->view('backend/template/footer');        
            $this->load->view('backend/template/script');     
        }
        function cetakLaporanCustom($tanggalawal,$tanggalakhir){
            $title = 'Laporan Dari '.tglIndo($tanggalawal). ' -  '.tglIndo($tanggalakhir);
            $pdf = new PDF('l','mm','A5');
            $pdf->AddPage();
            $pdf->SetTitle($title);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(31,6,'Laporan Custom',0,0,'C');
            $pdf->Cell(157,6,'Waktu : '.'Tanggal '.tglIndo($tanggalawal). ' - '.tglIndo($tanggalakhir),0,1,'R');

            $pdf->Cell(10,7,'',0,1);
            $pdf->Cell(10,6,'NO',1,0,'C');
            $pdf->Cell(70,6,'Tanggal',1,0,'C');
            $pdf->Cell(110,6,'Total',1,1,'C');

            $pdf->SetFont('Arial','',10);
            $pemesanan = $this->pemesanan->getPemesananCetakCustom($tanggalawal,$tanggalakhir);
            
            $totalCustom = 0 ;
            $i=1;
            foreach($pemesanan as $r){
                $totalCustom +=$r['total'];
                $pdf->Cell(10,6,$i++,1,0,'C');
                $pdf->Cell(70,6,tglIndo($r['tanggal']),1,0,'C');
                $pdf->Cell(110,6,number_format($r['total'],'0',',','.'),1,1,'R');
            }

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,6,'TOTAL',1,0,'C');
            $pdf->Cell(110,6,number_format($totalCustom,'0',',','.'),1,1,'R');

            $pdf->Output();
        }

}        
