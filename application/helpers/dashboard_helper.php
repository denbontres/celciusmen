<?php 
    function countBadge($judul){
        $jumlah="";
        switch($judul){
            case 'Pemesanan':
                $jumlah = countPemesananPending();
            break;
            case 'Contact US':
                $jumlah = countCountactNoRead();
            break;
        }
        return $jumlah;
    }
    function countPemesananPending(){
        $ci = get_instance();
        $ci->load->model('PemesananModel','pemesanan');
        $jumPemesananPending = $ci->pemesanan->getCountRowWhere(['status'=>2]);
        return $jumPemesananPending;
    }
    function countCountactNoRead(){
        $ci = get_instance();
        $ci->load->model('ContactModel','contact');
        $jumContact = $ci->contact->getCountRowWhere(['status'=>'0']);
        return $jumContact;
    }
?>