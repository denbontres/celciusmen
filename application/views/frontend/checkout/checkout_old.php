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
                                <select class="form-control" name="provinsi" id="provinsi">
                                    <option value="">--Provinsi--</option>
                                    <?php foreach($provinsi as $r):?>
                                        <option value="<?=$r['id_provinsi']?>" <?=$r['id_provinsi']==$user['id_provinsi']?'selected':''?>><?=$r['nama_provinsi']?></option>
                                    <?php endforeach;?>
                                </select>   
                                <?= form_error('provinsi','<small class="text-danger pl-3" id="error-provinsi">','</small>');?>        
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="kota">Kota / Kabupaten<span>*</span></label>
                                <select class="form-control" name="kota" id="kota">
                                    <option value="">--Kota / Kabupaten--</option>
                                    <?php foreach($kota as $r):?>
                                            <option value="<?=$r['id_kota']?>" <?=$r['id_kota']==$user['id_kota']?'selected':''?>><?=$r['nama_kota']?></option>
                                    <?php endforeach;?>
                                </select>       
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
                            <div class="col-lg-6 mb-4">
                                <label for="kurir">Kurir<span>*</span></label>
                                <select class="form-control" name="kurir" id="kurir">
                                    <option value="">--Kurir--</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS</option>
                                </select>    
                                <?= form_error('kurir','<small class="text-danger pl-3" id="error-kurir">','</small>');?>       
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="layanan">Layanan<span>*</span></label>
                                <select class="form-control" name="layanan" id="layanan">
                                    <option value="">--Layanan--</option>
                                </select>           
                                <?= form_error('layanan','<small class="text-danger pl-3" id="error-layanan">','</small>');?>
                            </div>
                            <div class="col-lg-6">
                                <label for="ongkir">Ongkos Kirim<span>*</span></label>
                                <input class="form-control" type="text" id="ongkir" name="ongkir" readonly>
                                <?= form_error('ongkir','<small class="text-danger pl-3" id="error-ongkir">','</small>');?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pb-3">
                        <div class="header-box">
                            <h1>TOTAL PRODUCT</h1>
                        </div>
                        <div class="px-4 py-3">
                            <ul class="list-unstyled mb-4">
                                <?php foreach($order as $r):?>
                                        <li class="d-flex justify-content-between py-3 border-bottom"><?=$r['nama'].' '.$r['sku']?> x <?=$r['jumlah']?> <strong>IDR <?=number_format($r['total_harga'] * $r['jumlah'],'0',',','.')?></strong></li>
                                    <?php endforeach;?>
                            </ul>
                        </div>
                        <div class="header-box">
                            <h1>ORDER SUMMARY</h1>
                        </div>
                        <div class="px-4 py-3">
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>IDR <?=number_format($subtotal,'0',',','.')?></strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping</strong><strong id="text-ongkir">-</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Discount</strong><strong>IDR 0</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong><strong class="total-price-sum" id="text-total-ongkir">-</strong></li>
                            </ul>
                        </div>
                        
                        <div class="pos-btn"><button type="submit" class="btn btn-type5">NEXT YO PAYMENT</button></div>
                    </div>
            </div>
        </form>
        </div>
    </div>
    
    <script>

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
    </script>