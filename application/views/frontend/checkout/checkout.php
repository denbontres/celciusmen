<!-- Loading Effect -->
<style>
    /* Absolute Center Spinner */
    .loading {
    position: fixed;
    z-index: 999999999;
    height: 2em;
    width: 2em;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    color:white;
    }

    /* Transparent Overlay */
    .loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));
    background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
    }
    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
    /* hide "loading..." text */
    font: 0/0 a;
    color: transparent;
    text-shadow: none;
    background-color: transparent;
    border: 0;
    }

    .loading:not(:required):after {
    content: '';
    display: block;
    font-size: 10px;
    width: 1em;
    height: 1em;
    margin-top: -0.5em;
    -webkit-animation: spinner 1500ms infinite linear;
    -moz-animation: spinner 1500ms infinite linear;
    -ms-animation: spinner 1500ms infinite linear;
    -o-animation: spinner 1500ms infinite linear;
    animation: spinner 1500ms infinite linear;
    border-radius: 0.5em;
    -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
    box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    @-moz-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    @-o-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
    @keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
    }
</style>
<div class="loading"></div>
<script>
	$(document).ready(function() {
		$('.loading').hide()
	})
</script>
<h1 class="text-center title-header">SHIPPING METHOD</h1>
    <div>
        <div class="container-fluid">
        <form action="<?=base_url('Checkout')?>" method="post" class="checkout-form">
            <div class="row">
                    <div class="col-lg-6 pb-3">
                        <p class="title-header-shipping">Choose your shipping address :</p>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label for="nama">Nama<span>*</span></label>
                                <input type="text" class="form-control" id="nama" value="<?=$user['nama']?>" name="nama">
                                <?= form_error('nama','<small class="text-danger pl-3" id="error-nama">','</small>');?>
                            </div>
                            
                            <div class="col-lg-12">
                                <label for="alamat">Alamat<span>*</span></label>
                                <textarea class="form-control mb-4" name="alamat" id="alamat" cols="30" rows="5"><?=$user['alamat']?></textarea>
                                <?= form_error('alamat','<small class="text-danger pl-3" id="error-alamat">','</small>');?>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="provinsi">Provinsi<span>*</span></label>
                                <div id="list_provinsi">

                                </div>
                                <!-- <select class="form-control" name="provinsi" id="provinsi">
                                    <option value="">--Provinsi--</option>
                                    <?php foreach($provinsi as $r):?>
                                        <option value="<?=$r['id_provinsi']?>" <?=$r['id_provinsi']==$user['id_provinsi']?'selected':''?>><?=$r['nama_provinsi']?></option>
                                    <?php endforeach;?>
                                </select>    -->
                                <?= form_error('provinsi','<small class="text-danger pl-3" id="error-provinsi">','</small>');?>        
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="kota">Kota / Kabupaten<span>*</span></label>
                                <div id="list_kota">
                                    <select class="form-control" name="kota" id="kota">
                                        <option value="">--Pilih Provinsi Dahulu--</option>
                                    </select>
                                </div>
                                <!-- <select class="form-control" name="kota" id="kota">
                                    <option value="">--Kota / Kabupaten--</option>
                                    <?php foreach($kota as $r):?>
                                            <option value="<?=$r['id_kota']?>" <?=$r['id_kota']==$user['id_kota']?'selected':''?>><?=$r['nama_kota']?></option>
                                    <?php endforeach;?>
                                </select>        -->
                                <?= form_error('kota','<small class="text-danger pl-3" id="error-kota">','</small>');?>    
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="kecamatan">Kecamatan<span>*</span></label>
                                <div id="list_kecamatan">
                                    <select class="form-control" name="kecamatan" id="kecamatan">
                                        <option value="">--Pilih Kota Dahulu--</option>
                                    </select>
                                </div>
                                <?= form_error('kota','<small class="text-danger pl-3" id="error-kota">','</small>');?>    
                            </div>
                             <!--<div class="col-lg-6 mb-4">
                                <label for="kota">Kota / Kabupaten<span>*</span></label>
                                <select class="form-control" name="kota" id="kota">
                                    <option value="">--Kota / Kabupaten--</option>
                                    <?php foreach($kota as $r):?>
                                            <option value="<?=$r['id_kota']?>" <?=$r['id_kota']==$user['id_kota']?'selected':''?>><?=$r['nama_kota']?></option>
                                    <?php endforeach;?>
                                </select>       
                                <?= form_error('kota','<small class="text-danger pl-3" id="error-kota">','</small>');?>    
                            </div>-->
                            <div class="col-lg-6">
                                <label for="kodepos">Kode POS<span>*</span></label>
                                <input type="text" class="form-control" value="<?=$user['kode_pos']?>" id="kodepos" name="kodepos">
                                <?= form_error('kodepos','<small class="text-danger pl-3" id="error-kodepos">','</small>');?>
                            </div>
                            <!--<div class="col-lg-6">
                                <label for="kodepos">Phone Number<span>*</span></label>
                                <input type="text" class="form-control" value="<?=$user['kode_pos']?>" id="kodepos" name="kodepos">
                                <?= form_error('kodepos','<small class="text-danger pl-3" id="error-kodepos">','</small>');?>
                            </div>-->
                            <div class="col-lg-12 mb-4">
                                <label for="kurir">Kurir<span>*</span></label>
                                <select class="form-control" name="kurir" id="kurir">
                                    <option value="sicepat" selected>Si Cepat</option>
                                    <!--<option value="jne">JNE</option>-->
                                </select>    
                                <?= form_error('kurir','<small class="text-danger pl-3" id="error-kurir">','</small>');?>       
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="layanan">Layanan Pengiriman (Ongkir)<span>*</span></label>
                                <div id="list_layanan">
                                    <select class="form-control" name="layanan" id="layanan">
                                        <option value="">--Lengkapi Data Pengiriman--</option>
                                    </select>
                                </div>          
                                <?= form_error('layanan','<small class="text-danger pl-3" id="error-layanan">','</small>');?>
                            </div>
                            <!-- <div class="col-lg-12">
                                <label for="ongkir">Ongkos Kirim<span>*</span></label>
                                <input class="form-control" type="text" id="ongkir" name="ongkir" readonly>
                                <?= form_error('ongkir','<small class="text-danger pl-3" id="error-ongkir">','</small>');?>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-md-6 pb-3">
                        <div class="header-box">
                            <h1>TOTAL PRODUCT</h1>
                        </div>
                        <div class="px-4 py-3">
                            <ul class="list-unstyled mb-4">
                                <?php 
                                $total_berat = 0;
                                foreach($order as $r):
                                $total_berat += $r['berat'] * $r['jumlah'];
                                ?>
                                        <li class="d-flex justify-content-between py-3 border-bottom"><?=$r['nama'].' '.$r['sku']?> x <?=$r['jumlah']?><br>Berat : <?=$r['jumlah'] * $r['berat']?> gram <strong>IDR <?=number_format($r['total_harga'] * $r['jumlah'],'0',',','.')?></strong>
                                        </li>
                                    <?php endforeach;?>
                            </ul>
                        </div>
                        <input type="hidden" name="berat" value="<?=$total_berat?>">
                        <div class="header-box">
                            <h1>ORDER SUMMARY</h1>
                        </div>
                        <div class="px-4 py-3">
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Product Weight </strong><strong><?=number_format($total_berat,'0',',','.')?> gram</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>IDR <?=number_format($subtotal,'0',',','.')?></strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping</strong><strong id="text-ongkir">-</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-success">Discount Belanja</strong><strong>- IDR <span id="discount"></span></strong></li>
                                <!-- <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-success">Discount Ongkir</strong><strong>- IDR <span id="discount_ongkir"></span></strong></li> -->
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong><strong class="total-price-sum">IDR <span id="total"></span></strong></li>
                            </ul>
                        </div>
                        
                        <div class="pos-btn"><button type="submit" class="btn btn-type5">NEXT YO PAYMENT</button></div>
                    </div>
            </div>
        </form>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        get_provinsi()
        function get_provinsi(){
            $('.loading').show()
            $.ajax({
                url: '<?= base_url() ?>rajaongkir/get_all_province/<?php if($user['id_provinsi'] != 0)echo $user['id_provinsi']?>',
                method: 'POST',
                success: function(data) {
                    $('#list_provinsi').html(data)
                    $('.loading').hide()
                    provinsi = $('#provinsi').val();
                    if(provinsi != ''){
                        get_city();
                    }
                },
                error: function(err) {
                    console.log(err)
                    $('.loading').hide()
                }
            })
        }
        $(document).on('change', "#provinsi", function() {
           get_city();
           get_ongkir()
           $('#list_kecamatan').html('<select class="form-control" name="kecamatan" id="kecamatan"><option value="">--Pilih Kota Dahulu--</option></select>')
        });
        function get_city(){
            $('.loading').show()
            provinsi = $('#provinsi').val();
            console.log(provinsi)
            if(provinsi != ''){
                $.ajax({
                    url: '<?= base_url() ?>rajaongkir/get_city_by_province/'+provinsi+"/<?php if($user['id_kota'] != 0)echo $user['id_kota']?>",
                    method: 'POST',
                    success: function(data) {
                        $('#list_kota').html(data)
                        $('.loading').hide()
                        var kota = $('#kota').val();
                        if(kota != ''){
                            get_kecamatan();
                        }
                    },
                    error: function(err) {
                        console.log(err)
                        $('.loading').hide()
                    }
                })
            }else{
                $('#list_kota').html('<select class="form-control" name="kota" id="kota"><option value="">--Pilih Provinsi Dahulu--</option></select>')
            }
           
        }
        $(document).on('change', "#kota", function() {
           get_kecamatan();
           get_ongkir()
           get_pemesanan();

        });
        $(document).on('change', "#kecamatan,#kurir", function() {
           get_ongkir()
            get_pemesanan();
        });
        function get_kecamatan(){
            $('.loading').show()
            kota = $('#kota').val();
            if(kota != ''){
                $.ajax({
                    url: '<?= base_url() ?>rajaongkir/get_kecamatan/'+kota,
                    method: 'POST',
                    success: function(data) {
                        $('#list_kecamatan').html(data)
                        $('.loading').hide()
                    },
                    error: function(err) {
                        console.log(err)
                        $('.loading').hide()
                    }
                })
            }else{
                $('#list_kecamatan').html('<select class="form-control" name="kecamatan" id="kecamatan"><option value="">--Pilih Kota Dahulu--</option></select>')
            }
            get_pemesanan(); 
        }
        function get_ongkir(){
            var provinsi = $('#provinsi').val()
            var kota = $('#kota').val()
            var kecamatan = $('#kecamatan').val()
            var kurir = $('#kurir').val()
            if(provinsi != '' && kota != '' && kecamatan != ''){
                $('.loading').show()
                $.ajax({
                    url: '<?= base_url() ?>rajaongkir/get_ongkir/'+kecamatan+"/<?=$total_berat?>/"+kurir,
                    method: 'POST',
                    success: function(data) {
                        $('#list_layanan').html(data)
                        $('.loading').hide()
                    },
                    error: function(err) {
                        console.log(err)
                        $('.loading').hide()
                    }
                })
            }else{
                $('#list_kecamatan').html('<select class="form-control" name="kecamatan" id="kecamatan"><option value="">--Lengkapi Data Pengiriman--</option></select>')
            }
           
        }
        // Get Ongkir Detail
        $(document).on('change', "#layanan", function() {
            var data = $(this).val().split("|");
            var subtotal = parseFloat(<?=$subtotal?>);
            var ongkir = parseFloat(data[0]);
            var total =  subtotal+ongkir;
            $('#ongkir').val(formatRupiah(ongkir));
            $('#text-ongkir').text('IDR '+formatRupiah(data[0]));
            $('#text-total-ongkir').text('IDR '+formatRupiah(total))
            get_pemesanan();
        });
        function formatRupiah(angka){
            return parseFloat(angka).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace(/\,/g,'.').slice(0, -3);
        }
        get_pemesanan();
        function get_pemesanan(){
            $.ajax({
                url: '<?= base_url() ?>cart/get_pemesanan',
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    var layanan = $('#layanan').val().split("|");
                    console.log(layanan)
                    var ongkir = 0;
                    if(layanan[1]){
                        ongkir = parseFloat(layanan[0])
                    }else{
                        $('#text-ongkir').text('IDR 0');
                    }
                    $('#kupon').val(data['kode_kupon'])
                    $('#subtotal').html(formatNumber(data['subtotal']))
                    $('#discount').html(formatNumber(data['discount']))
                    if(data['discount_ongkir'] > ongkir && ongkir != 0){
                        // alert("Discount ongkir disesuaikan")
                        data['discount_ongkir'] = ongkir;
                    }
                    $('#discount_ongkir').html(formatNumber(data['discount_ongkir']))
                    if(ongkir != 0){
                        $('#total').html(formatNumber(parseFloat(data['subtotal']) + parseFloat(ongkir) - parseFloat(data['discount']) - parseFloat(data['discount_ongkir']) ))
                    }else{
                        $('#total').html(formatNumber(parseFloat(data['subtotal']) + parseFloat(ongkir) - parseFloat(data['discount']) ))
                    }
                    
                },
                error(e) {
                    console.log(e)
                    $('.loader').hide()
                }
            })
        }
        function formatNumber(number){
            return number.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
        }
    })
    </script>
    <!-- <script>

        $('#provinsi').on('change',function(){
            var id= $(this).val();
            getKota(id);
        });
        function getKota(idprovinsi){
            $.ajax({
                url:base_url+'Checkout/getKota',
                data:{id:idprovinsi},
                type:'post',
                dataType:'JSON',
                success:function(data){
                    console.log(data)
                    var newData = hapusDuplicateKota(data);
                    // uiCtr.tampilKota(newData);
                    tampilKota(newData);
                    
                }
            });
        }

        $('#kurir').on('change',function(){
            // console.log("cba");
            var kurir = $(this).val();
            var kota = $('#kota').find(":selected").val();
            $.ajax({
                url:base_url+'Checkout/getKurir',
                data:{kurir:kurir,tujuan:kota},
                type:'post',
                dataType:'json',
                success:function(data){
                    tampilLayananKurir(data);
                }
            }); 
        })

        $('#layanan').on('change',function(){
            getOngkir();
        });

        $("input[name='payment']").on('click', function() {
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
        
        function getOngkir(){
            var tujuan = $('#kota').find(":selected").val();
            var layanan = $('#layanan').find(":selected").val();
            var kurir = $('#kurir').find(":selected").val();
            $.ajax({
                url:base_url+"Checkout/getOngkir",
                data:{tujuan:tujuan,layanan:layanan,kurir:kurir},
                type:'post',
                success:function(data){
                    // saat layanan ini dibuat terkadang raja ongkir mengirim pesan error
                    
                    if(data.substring(1, 4)=="<di"){
                        $('#ongkir').val('');
                    }else{
                        var subtotal = parseFloat(<?=$subtotal?>);
                        var ongkir = parseFloat(data);
                        var total =  subtotal+ongkir;
                        $('#ongkir').val(formatRupiah(ongkir));
                        $('#text-ongkir').text('IDR '+formatRupiah(data));
                        $('#text-total-ongkir').text('IDR '+formatRupiah(total))
                    }
                    
                    // uiCtr.tampilOngkir(data);
                    // uiCtr.tampilOngkirTabel(data);
                    // getTotalPembayaran();
                }
            });
        }

        function tampilKota(data){
            var html;
            if(data.length==0){
                html +='<option value="">--Kota/Kabupaten--</option>';
            }else{
                for(var i=0;i<data.length;i++){
                    html +='<option value="'+data[i].id_kota+'" >'+data[i].nama_kota+'</option>';
                }
            }
            $('#kota').html(html);
        }

        function tampilLayananKurir(data){
            var html;
            html +="<option>--Layanan--</option>";
            for(var i=0;i<data.length;i++){
                html +='<option value="'+data[i].id+'">'+data[i].layanan+'</option>';
            }
            $('#layanan').html(html);
            $('#layanan').prop("selectedIndex", 0);
        }

        // waktu skrip ini dibuat api raja ongkir masih ada bug, nama kota yang ganda
        function hapusDuplicateKota(data){
            var namaKota = Object.values(data.reduce((acc,cur)=>Object.assign(acc,{[cur.nama_kota]:cur}),{}));
            var idKota = Object.values(namaKota.reduce((acc,cur)=>Object.assign(acc,{[cur.id_kota]:cur}),{}));
            return idKota;
        }

        function formatRupiah(angka){
            return parseFloat(angka).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace(/\,/g,'.').slice(0, -3);
        }
    </script> -->