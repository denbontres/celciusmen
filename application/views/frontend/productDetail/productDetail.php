<style type="text/css" media="screen">
.product-details .pd-desc {
    margin-bottom: 24px;
}
/* Harga */
.product-details .pd-desc h4 {
    color: #e7ab3c;
    font-weight: 700;
}

.product-details .pd-desc h4 span {
    font-size: 18px;
    font-weight: 400;
    color: #b7b7b7;
    text-decoration: line-through;
    display: inline-block;
    margin-left: 13px;
}

/* Radio buttun size */
.product-details .pd-size-choose {
    margin-bottom: 15px;  
}    
.product-details .pd-size-choose .sc-item {
    display: inline-block;
    margin-right: 5px;
}
.product-details .pd-size-choose .sc-item input {
    position: absolute;
    visibility: hidden;
}

.product-details .pd-size-choose .sc-item label {
    font-size: 16px;
    color: #252525;
    font-weight: 700;
    height: 40px;
    width: 47px;
    border: 1px solid #ebebeb;
    text-align: center;
    line-height: 40px;
    text-transform: uppercase;
    cursor: pointer;
}
.product-details .pd-size-choose .sc-item label.active {
    background: #252525;
    color: #ffffff;
}

/* Radio Button Warna */
.product-details .pd-color {
    margin-bottom: 15px;
}
.product-details .pd-color h6 {
    color: #252525;
    font-weight: 700;
    float: left;
    margin-right: 28px;
}
.product-details .pd-color .pd-color-choose {
    display: inline-block;
}
.product-details .pd-color .pd-color-choose .cc-item {
    display: inline-block;
    margin-right: 10px;
}
.product-details .pd-color .pd-color-choose .cc-item input {
    position: absolute;
    visibility: hidden;
}
.product-details .pd-color .pd-color-choose .cc-item label {
    height: 20px;
    width: 20px;
    background: #252525;
    border-radius: 50%;
    cursor: pointer;
    margin-bottom: 0;
}
.product-details .pd-color .pd-color-choose .cc-item label.cc-yellow {
    background: #EEEE21;
}
.product-details .pd-color .pd-color-choose .cc-item label.cc-violet {
    background: #8230E3;
}

/*quatity */
.product-details .quantity {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 5px;
}

.product-details .quantity .pro-qty {
    width: 123px;
    height: 46px;
    border: 2px solid #ebebeb;
    padding: 0 15px;
    float: left;
    margin-right: 14px;
}

.product-details .quantity .pro-qty .qtybtn {
    font-size: 24px;
    color: #b2b2b2;
    float: left;
    line-height: 45px;
    cursor: pointer;
    width: 18px;
}

.product-details .quantity .pro-qty .qtybtn.dec {
    font-size: 30px;
}

.product-details .quantity .pro-qty input {
    text-align: center;
    width: 52px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    color: #4c4c4c;
    line-height: 40px;
    float: left;
}

.product-details .quantity .primary-btn.pd-cart {
    padding: 14px 70px 10px;
}

</style>
    <div class="container-fluid p-4">
        <div class="backtobtn"><a href="catalog.html"><i class="fa fa-chevron-left"></i>&nbsp; &nbsp; &nbsp;<strong>BACK TO CATALOG</strong></a></div>
    </div>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                            <div class="container mx-auto">
                                <div class="row">
                                    <div class="col p-0">
                                        <div class="card pb-5">
                                            <div class="d-flex flex-column thumbnails">
                                                <?php if($barang['foto']) { ?>
                                                <div id="f1" class="tb tb-active"><img class="thumbnail-img fit-image" src="<?=base_url('resource/').$barang['foto']?>"></div>
                                                <?php } ?>
                                                <?php if($barang['foto2']) { ?>
                                                <div id="f2" class="tb"><img class="thumbnail-img fit-image" src="<?=base_url('resource/').$barang['foto2']?>"></div>
                                                <?php } ?>
                                                <?php if($barang['foto3']) { ?>
                                                <div id="f3" class="tb"><img class="thumbnail-img fit-image" src="<?=base_url('resource/').$barang['foto3']?>"></div>
                                                <?php } ?>
                                                <?php if($barang['foto4']) { ?>
                                                <div id="f4" class="tb"><img class="thumbnail-img fit-image" src="<?=base_url('resource/').$barang['foto4']?>"></div>
                                                <?php } ?>
                                            </div>
                                            <?php if($barang['foto']) { ?>
                                            <fieldset id="f11" class="active">
                                                <div class="product-pic"><img class="pic0" src="<?=base_url('resource/').$barang['foto']?>"></div>
                                            </fieldset>
                                            <?php } ?>
                                            <?php if($barang['foto2']) { ?>
                                            <fieldset id="f21">
                                                <div class="product-pic"><img class="pic0" src="<?=base_url('resource/').$barang['foto2']?>"></div>
                                            </fieldset>
                                            <?php } ?>
                                            <?php if($barang['foto3']) { ?>
                                            <fieldset id="f31">
                                                <div class="product-pic"><img class="pic0" src="<?=base_url('resource/').$barang['foto3']?>"></div>
                                            </fieldset>
                                            <?php } ?>
                                            <?php if($barang['foto4']) { ?>
                                            <fieldset id="f41">
                                                <div class="product-pic"><img class="pic0" src="<?=base_url('resource/').$barang['foto4']?>"></div>
                                            </fieldset>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="col-md-6 pb-5">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span><?=$barang['brand']?></span>
                                    <h3><?=$barang['nama']?></h3>
                                    <a href="javascript:;" class="heart-icon"><i class="icon_heart_alt wishlist" data-nama="<?=$barang['nama']?>" data-id="<?=$barang['id']?>"></i></a>
                                </div>
                                <div class="pd-rating">
                                    <?php for($i=1;$i<=round($rating['rating']);$i++){ ?>
                                        <i class="fa fa-star"></i>
                                    <?php } ?>

                                    <?php for($i=1;$i<=5-round($rating['rating']);$i++){ ?>
                                        <i class="fa fa-star-o"></i>
                                    <?php } ?>
                                    
                                    <span>(<?=$rating['jumlah']?>)</span>
                                </div>
                                <div class="pd-desc">
                                    <p><?=$barang['short_deskripsi']?></p>
                                    <h4><?=$barang['diskon']>0?'Rp. '.number_format($barang['total_harga'],'0',',','.').' <span>Rp. '.number_format($barang['harga'],'0',',','.').'</span>':'Rp. '.number_format($barang['total_harga'],'0',',','.')?></h4>
                                </div>

                                <?php $i=0;foreach($skuUnit as $r):?>
                                    <?php if($r['tipe']=="Warna"){?>
                                    <div class="pd-color">
                                        <h6><?=$r['kategori']?></h6>
                                        <div class="pd-color-choose">
                                            <?php $index=1; foreach($variant[$i] as $var):?>
                                                <?php if($var['id_kategori_variant']==$r['id_kategori_variant']){?>
                                                    <div class="cc-item">
                                                        <input type="radio" value="<?=$var['id']?>" name="warna" id="<?=$var['id']?>" <?=$index==1?'checked':''?>>
                                                        <label for="<?=$var['id']?>" <?=$index==1?"class='active'":''?> style="background:<?=$var['kode_warna']?>; border:1px black solid"></label>
                                                    <h4><?=$var['nama']?></h4>
                                                    </div>
                                                <?php } ?>
                                            <?php $index++; endforeach; ?>
                                        </div>
                                    </div>
                                    <?php } elseif($r['tipe']=="Tombol") { ?>
                                        <div class="pd-size-choose">
                                            <?php $index=1; foreach($variant[$i] as $var):?>
                                                <?php if($var['id_kategori_variant']==$r['id_kategori_variant']){?>
                                                    <div class="sc-item">
                                                        <input type="radio" class="<?=$r['name_element']?>" value="<?=$var['id']?>" name="<?=$r['name_element']?>" id="<?=$var['id']?>" <?=$index==1?'checked':''?>>
                                                        <label for="<?=$var['id']?>" <?=$index==1?"class='active'":''?>><?=$var['nama']?></label>
                                                    </div>
                                                    <?php } ?>
                                            <?php  $index++; endforeach; ?>
                                        </div>
                                    <?php } ?>    
                                <?php $i++; endforeach;?>
                                <!--<div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" class="qty">
                                    </div>
                                </div>-->
                                <div class="warp-qty">
                                    <div class="pb-3"><span class="sub-title" style="font-size: 14px;">QUANTITY :&nbsp;</span></div>
                                    <div class="input-group proqty">
                                        <span class="input-group-btn">
                                            <button class="btn btn-minus btn-number quantity-left-minus" type="button" data-type="minus" data-field=""><i class="icon ion-minus-round"></i></button>
                                        </span>
                                        <input type="text" id="quantity" value="1" min="1" class=" qty form-control input-number">
                                            <span class="input-group-btn"><a class="btn btn-plus btn-number quantity-right-plus" role="button" data-type="plus" data-field=""><i class="icon ion-plus-round"></i></a></span>
                                    </div>
                                </div>

                                <div class="stok">
                                     <span id="stok">50 Tersisa</span>
                                     <input type="text" name="sku" id="sku" style="display:none">
                                    <div class="pb-4">
                                        <div class="pb-3"><a class="btn btn-type5 add-to-cart" role="button" href="javascript:;">ADD TO BAG</a></div>
                                        <div class="pb-3"><a class="btn btn-type5 wishlist" role="button" href="javascript:;"  data-nama="<?=$barang['nama']?>" data-id="<?=$barang['id']?>">ADD TO WISHLIST</a></div>
                                    </div>
                                </div>
                                <ul class="pd-tags">
                                    <li><span>CATEGORIES</span>: <?=$barang['kategori']?></li>
                                    <li><span>TAGS</span>: <?=$barang['tag']?></li>
                                </ul>
                                <div class="pd-share">
                                    <div class="pd-social">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$urlshare?>" target="_blank"><i class="ti-facebook"></i></a>
                                        <a href="https://twitter.com/share?url=<?=$urlshare?>" target="_blank"><i class="ti-twitter-alt"></i></a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?=$urlshare?>"><i class="ti-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>


<?php if($related) {?> 
            <div class="related-product"><div class="container-fluid">
    <h1 class="">Relate product</h1>  
    <div class="owl-carousel owl-theme">
    <?php foreach($related as $r):?>
        <div class="item">
            <a href="#" >
               <img src="<?=base_url('resource/').$r['foto']?>" class="img-fluid">
            </a>
            <div class="text-left detail">
                <span class="rea"><?=$r['nama']?><br /></span>
                <span><?=$r['diskon']>0?'Rp. '.number_format($r['total_harga'],'0',',','.').' <span>Rp. '.number_format($r['harga'],'0',',','.').'</span>':'Rp. '.number_format($r['total_harga'],'0',',','.')?><br /></span>
            </div> 
        </div>
    <?php endforeach;?>    
    </div>   
      <script src="jquery.min.js" type="text/javascript"></script>
      <script src="owl.carousel.js" type="text/javascript"></script>
    
      <script type="text/javascript">
      $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:2
            },
            750:{
                items:3
            },
            900:{
                items:4
            },
            1080:{
                items:5
            }
        }
    })
      </script>

</div></div>
<?php } ?>    


    <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
    <?= $this->session->flashdata('pesan')?>
    <script>
        $( document ).ready(function() {
            panggilFungsiGetJumlah();
        });
    </script>
    <script>
        var arr = []
        <?php foreach($skuUnit as $r):?>
            $("input[name='<?=$r['name_element']?>']").click(function() {
                panggilFungsiGetJumlah();
            });
        <?php endforeach;?>
       
        function panggilFungsiGetJumlah(){
            var arr = []
            <?php foreach($skuUnit as $r):?>
                var selected = $("input[type='radio'][name='<?=$r['name_element']?>']:checked");
                arr['<?=$r['name_element']?>'] = selected.val();
                arr['idBarang'] = '<?=$id?>';
                arr = Object.assign({}, arr);
            <?php endforeach;?>
            getJumlah(arr);
        }
        function getJumlah(data){
            $.ajax({
                url:'<?=base_url('Product/getJumlahBarang')?>',
                method:'post',
                data:data,
                async : true,
                dataType:'json',
                success:function(result){
                    var jumlah = result['jumlah'];
                    if(jumlah > 0){
                        $('#stok').text(jumlah+' Tersisa');
                        $('#sku').val(result['sku']);
                    }else{
                        $('#stok').text('Tidak tersedia');
                        $('.add-to-cart').prop('disabled', true);
                        $('#sku').val('');
                    }
                },
                
            });
        }
        $('input[name="warna"]').on('click',function(){
            var id = ($(this).attr('id'));
            $('.cc-item label').css('border-color','black');
            $('.cc-item #'+id).next().css('border','orange solid 2px');
        });
    </script>

    <script>
    $(document).ready(function(){

    var proQty = $('.proqty');
    //var quantitiy=0;
       $('.quantity-right-plus').click(function(e){
            
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var proQty = parseInt($('#quantity').val());
            
            // If is not undefined
                
                $('#quantity').val(proQty + 1);

              
                // Increment
            
        });

         $('.quantity-left-minus').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var proQty = parseInt($('#quantity').val());
            
            // If is not undefined
          
                // Increment
                if(proQty>0){
                $('#quantity').val(proQty - 1);
                }
        });
        
    });
    </script>