<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PemesananModel extends MY_Model {
    
    var $table = 'tbl_pemesanan';
    public function __construct(){
        parent::__construct($this->table);
    }

    public function getNomorFaktur($email){
        $where = [
            'email'=>$email,
        ];
        $this->db->order_by('created_at','DESC');
        $this->db->limit(1);
        $data = $this->db->get_where('tbl_pemesanan',$where)->row_array();
        $tgl = str_replace("-","",date('d-m-Y'));
        $status = $data['status'];
        if($status==1 || $data==""){
            $this->db->limit(1);
            $this->db->order_by('nofaktur','desc');
            $pemesanan = $this->db->get_where('tbl_pemesanan',['tanggal'=>date('Y-m-d')])->row_array();
            $rs = explode("-",$pemesanan['nofaktur']);
            if($pemesanan==""){
                $newKode = $tgl."-".sprintf("%'03d",1);
                $data = [
                    "status"=>0,
                    "nofaktur"=>$newKode
                ];
            }else{
                $newKode = $tgl."-".sprintf("%'03d",$rs[1]+1);
                $data['nofaktur']=$newKode;
            }
        }
        return $data['nofaktur'];
    }
    public function getNomorFakturLama($email){
        $this->db->select('nofaktur');
        $this->db->order_by('tanggal','DESC');
        return $this->db->get_where('tbl_pemesanan',['email'=>$email])->row_array();
    }
    
    public function getPemesanan($limit,$start,$email,$status){
        $this->db->select('nofaktur,tanggal,(total+ongkir) as total,status');
        $this->db->from($this->table);
        $this->db->order_by('tanggal','DESC');
        $this->db->where('email',$email);
        $this->db->where('status !=',0);
        if($status !="all" && $status !=""){
            $this->db->where('status',$status);
        }
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }
    public function getPemesananRow($email,$status){
        $this->db->select('nofaktur');
        $this->db->from($this->table);
        $this->db->where('email',$email);
        $this->db->where('status !=',0);
        if($status !="all" && $status !=""){
            $this->db->where('status',$status);
        }
        return $this->db->get()->num_rows();
    }

    public function getAllPemesanan(){
        $ket = "Menunggu Pembayaran";
        $this->datatables->select('nofaktur,tanggal,email,(total + ongkir) as total,if(status=1,"Pending",if(status=2,"Verifikasi",if(status=3,"Pengiriman","Selesai"))) as keterangan, status');
        $this->datatables->from($this->table);
        $this->db->order_by('tanggal','DESC');
        $this->db->where('status!=',0);
        $this->datatables->add_column('view', 
        '<a href="javascript:void(0);" class="btn btn-success" id="btn-edit" data-id="$1" data-status="$2"><i class="fas fa-edit"></i></a>   
        <a href="'.base_url('admin/Pemesanan/DetailPemesanan/?nofaktur=$1').'" class="btn btn-primary" data-id="$1" data-status="$2"><i class="fas fa-eye"></i></a>
        ','nofaktur,status');
        return $this->datatables->generate();
    }
    public function getAllPemesananWhere($email){
        $this->datatables->select('nofaktur,tanggal,email,(total + ongkir) as total');
        $this->datatables->from($this->table);
        $this->datatables->where('email',$email);
        $this->datatables->where('status!=',0);
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Pemesanan/DetailPemesanan/?nofaktur=$1').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
        ','nofaktur');
        return $this->datatables->generate();
    }

    public function getPemesananMingguan($minggu,$bulan,$tahun){
        $select = 'nofaktur,tanggal,SUM(total + ongkir) as total';
        $this->datatables->select($select);
        $this->datatables->from($this->table);
        $this->datatables->where('FLOOR((DAYOFMONTH(tanggal) - 1) / 7) + 1 =',$minggu);
        $this->datatables->where('MONTH(tanggal)',$bulan);
        $this->datatables->where('year(tanggal)',$tahun);
        $this->datatables->where('status ',5);
        $this->datatables->group_by('tanggal');
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Laporan/laporanHarian?tanggal=$1').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
        ','tanggal');
        $this->datatables->edit_column('tanggal','$1',"tglIndo(tanggal)");
        return $this->datatables->generate();
    }
    public function getTotalPemesananMingguan($minggu,$bulan,$tahun){
        $this->db->select('SUM(total +ongkir) as total');
        $this->db->from($this->table);
        $this->db->where('FLOOR((DAYOFMONTH(tanggal) - 1) / 7) + 1 =',$minggu);
        $this->db->where('MONTH(tanggal)',$bulan);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->where('status ',5);
        return $this->db->get()->row_array();
    }
    public function getPemesananCetakMingguan($minggu,$bulan,$tahun){
        $this->db->select('nofaktur,tanggal,SUM(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where('FLOOR((DAYOFMONTH(tanggal) - 1) / 7) + 1 =',$minggu);
        $this->db->where('MONTH(tanggal)',$bulan);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->group_by('tanggal');
        $this->db->where('status ',5);
        return $this->db->get()->result_array();
    }

    public function getPemesananBulanan($bulan,$tahun){
        $select = 'nofaktur,year(tanggal) as tahun,FLOOR((DAYOFMONTH(tanggal) - 1) / 7) + 1 as minggu,month(tanggal) as bulan,SUM(total + ongkir) as total';
        $this->datatables->select($select);
        $this->datatables->from($this->table);
        $this->db->where('MONTH(tanggal)',$bulan);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->where('status ',5);
        $this->datatables->group_by('YEARWEEK(tanggal)');

        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Laporan/laporanMingguan?bulan=$1&tahun=$2&minggu=$3').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
        ','bulan,tahun,minggu');
        $this->datatables->edit_column('bulan','$1',"getNamaBulan($bulan)");
        
        return $this->datatables->generate();
    }
    public function getTotalPemesananBulan($bulan,$tahun){
        $this->db->select('SUM(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->where('MONTH(tanggal)',$bulan);
        $this->db->where('status ',5);
        return $this->db->get()->row_array();
    }
    public function getPemesananCetakBulanan($bulan,$tahun){
        $this->db->select('nofaktur,FLOOR((DAYOFMONTH(tanggal) - 1) / 7) + 1 as minggu,tanggal,SUM(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)',$bulan);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->group_by('YEARWEEK(tanggal)');
        $this->db->where('status ',5);
        return $this->db->get()->result_array();
    }

    public function getPemesananTahunan($tahun){
        $select = 'nofaktur,year(tanggal) as tahun,month(tanggal) as bulan,SUM(total + ongkir) as total';
        $this->datatables->select($select);
        $this->datatables->from($this->table);
        $this->db->where('year(tanggal)',$tahun);
        $this->datatables->group_by('MONTH(tanggal)');
        $this->db->where('status ',5);
        $this->datatables->edit_column('bulan','$1',"getNamaBulan(bulan)");
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Laporan/LaporanBulanan?bulan=$1&tahun=$2').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
        ','bulan,tahun');
        return $this->datatables->generate();
    }
    public function getTotalPemesananTahun($tahun){
        $this->db->select('SUM(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->where('status ',5);
        return $this->db->get()->row_array();
    }
    public function getPemesananCetakTahun($tahun){
        $select = 'nofaktur,year(tanggal) as tahun,month(tanggal)as bulan,SUM(total + ongkir) as total';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where('year(tanggal)',$tahun);
        $this->db->group_by('MONTH(tanggal)');
        $this->db->where('status ',5);
        return $this->db->get()->result_array();
    }

    public function getPemesananByHarian($tanggal){
        $this->datatables->select('nofaktur,tanggal,sum(total + ongkir) as total');
        $this->datatables->from($this->table);
        $this->datatables->where('tanggal',$tanggal);
        $this->datatables->where('status ',5);
        $this->datatables->group_by('nofaktur');
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Pemesanan/DetailPemesanan/?nofaktur=$1').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
        <a href="'.base_url('admin/Laporan/cetakLaporanDetail/$1').'" target="_blank" class="btn btn-success" data-id="$1"><i class="fas fa-print"></i></a> 
        ','nofaktur');
        $this->datatables->edit_column('tanggal','$1','tglIndo(tanggal)');
        return $this->datatables->generate();
    }
    public function getTotalByHarian($tanggal){
        $this->db->select('sum(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where('tanggal',$tanggal);
        $this->db->where('status ',5);
        return $this->db->get()->row_array();
    }
    public function getPemesananCetakHarian($tanggal){
        $this->db->select($this->table.'.*,nama');
        $this->db->from($this->table);
        $this->db->join('tbl_user',$this->table.'.email=tbl_user.email');
        $this->db->order_by('tanggal','DESC');
        $this->db->where('tanggal',$tanggal);
        $this->db->where('status ',5);
        return $this->db->get()->result_array();
    }

    public function getPemesananByCustom($tanggalawal,$tanggalakhir){
        $this->datatables->select('nofaktur,tanggal,(total + ongkir) total');
        $this->datatables->from($this->table);
        $this->datatables->where("tanggal between '$tanggalawal' and '$tanggalakhir'");
        $this->datatables->where('status ',5);
        $this->datatables->group_by('tanggal');
        $this->datatables->add_column('view', 
        '<a href="'.base_url('admin/Laporan/laporanHarian?tanggal=$1').'" class="btn btn-primary" data-id="$1"><i class="fas fa-eye"></i></a> 
        ','tanggal');
        $this->datatables->edit_column('tanggal','$1','tglIndo(tanggal)');
        return $this->datatables->generate();
    }

    public function getTotalByCustom($tanggalawal,$tanggalakhir){
        $this->db->select('sum(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where("tanggal between '$tanggalawal' and '$tanggalakhir'");
        $this->db->where('status ',5);
        return $this->db->get()->row_array();
    }

    public function getPemesananCetakCustom($tanggalawal,$tanggalakhir){
        $this->db->select('nofaktur,tanggal,SUM(total + ongkir) as total');
        $this->db->from($this->table);
        $this->db->where("tanggal between '$tanggalawal' and '$tanggalakhir'");
        $this->db->group_by('tanggal');
        $this->db->where('status ',5);
        return $this->db->get()->result_array();
    }

    public function getDetailPemesanan($faktur){
        $this->db->select('nama,tbl_user.email,tbl_user.alamat,notelpon,tanggal,total,ongkir,resikurir,kota,provinsi,'.$this->table.'.kode_pos');
        $this->db->from($this->table);
        $this->db->where('status ',5);
        $this->db->where('nofaktur ',$faktur);
        $this->db->join('tbl_user',$this->table.'.email=tbl_user.email');
        return $this->db->get()->row_array();
    }
    
}