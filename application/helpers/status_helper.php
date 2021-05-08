<?php 
    function getNameStatus($nilai){
        $text ="";
        switch($nilai){
            case 1:
                $text = "Menunggu Pembayaran";
            break;
            case 2:
                $text = "Menunggu Konfirmasi";
            break;
            case 3:
                $text = "Packing";
            break;
            case 4:
                $text = "Pengiriman";
            break;
            case 5:
                $text = "Selesai";
            break;
        }
        return $text;
    }

?>