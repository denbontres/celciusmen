    <h1 class="text-center title-header">SHOPPING BAG</h1>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="header-box">
                        <h1>Product</h1>
                    </div>
                    <div class="item-list px-4 py-2">
                        <div id="data">
                            
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header-box">
                        <h1>COUPON CODE</h1>
                    </div>
                    <div class="px-4 py-2">
                        <div class="py-2">
                            <p class="py-2"><em>If you have a coupon code, please enter it in the box below</em><br></p>
                        </div>
                        <div class="input-button-coupon clean-block-20">
                            <div class="group">
                                <input class="ginput" id="kupon" type="text" value="<?php if($pemesanan['kode_kupon'] != '') echo $pemesanan['kode_kupon']?>" required>
                                <label class="glabel">ENTER THE COUPON</label>
                            </div>
                            
                                    <a class="btn btn-type1-small" id="remove-coupon" role="button" href="#">REMOVE COUPON</a>
                               
                                    <a class="btn btn-type1-small" id="apply-coupon" role="button" href="#">APPLY COUPON</a>
                                
                        </div>
                    </div>
                    <div class="header-box">
                        <h1>ORDER SUMMARY</h1>
                    </div>
                    <div class="px-4 py-3">
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex justify-content-between py-3 border-bottom cart-total"><strong class="text-muted">Order Subtotal </strong><strong> <span id="subtotal" class="cart-price"></span></strong></li>
                            <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Ongkir </strong><strong>Belum Ditentukan</strong></li>
                            <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-success">Discount Belanja</strong><strong>- IDR <span id="discount"></span></strong></li>
                            <!-- <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-success">Discount Ongkir</strong><strong>- IDR <span id="discount_ongkir"></span></strong></li> -->
                            <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong><strong class="total-price-sum">IDR <span id="total"></span></strong></li>
                        </ul>
                    </div>
                    <div class="text-center pb-5"><a class="btn btn-type5" role="button" href="<?=base_url('Checkout')?>">NEXT TO SHIPPING</a></div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {

     $(document).on("click","#apply-coupon",function(e) {
        e.preventDefault()
        $.ajax({
                url: '<?= base_url() ?>cart/coupon_cek',
                data: {
                    kupon: $('#kupon').val()
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                   if(data['kode_kupon']){
                        toastr.success("Kupon berhasil ditambahkan");
                        get_pemesanan()
                   }else{
                    toastr.error(data);
                   }
                },
                error(e) {
                    console.log(e)
                    $('.loader').hide()
                }
            })
    })
     $(document).on("click","#remove-coupon",function(e) {
         e.preventDefault()
        $.ajax({
                url: '<?= base_url() ?>cart/remove_coupon',
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                  
                    toastr.success("Kupon berhasil dihapus");

                        get_pemesanan()
                  
                },
                error(e) {
                    console.log(e)
                    $('.loader').hide()
                }
            })
    })
    get_pemesanan();
    function get_pemesanan(){
        $.ajax({
            url: '<?= base_url() ?>cart/get_pemesanan',
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if(data['kode_kupon'] != ''){
                    $('#remove-coupon').show()
                    $('#apply-coupon').hide()
                }else{
                    $('#remove-coupon').hide()
                    $('#apply-coupon').show()
                }
                $('#kupon').val(data['kode_kupon'])
                $('#subtotal').html(formatNumber(data['subtotal']))
                $('#discount').html(formatNumber(data['discount']))
                $('#discount_ongkir').html(formatNumber(data['discount_ongkir']))
                $('#total').html(formatNumber(parseFloat(data['subtotal']) - parseFloat(data['discount']) ))
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
