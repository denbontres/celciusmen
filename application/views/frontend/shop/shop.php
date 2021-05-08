<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <?php $this->load->view($filter); ?>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                <p>Show <?=$start==0?sprintf("%02d",'1'):sprintf("%02d",$start)?> - 
                                <?php if($start==0){
                                    if($perpage > $jumlahData){
                                        echo sprintf("%02d", $jumlahData);
                                    }else{
                                        echo sprintf("%02d", $perpage);
                                    }
                                }else{
                                    $last = ($perpage+$start);
                                    if($last > $jumlahData){
                                        echo sprintf("%02d", $jumlahData);
                                    }else{
                                        echo sprintf("%02d", $last);
                                    }
                                }
                                ?> Of <?=sprintf("%02d", $jumlahData);?> Product</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            <?php foreach($barang as $r):?>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <img src="<?=base_url('resource/').$r['foto']?>" alt="">
                                            <?php if($r['diskon']>0){ ?>
                                                <div class="sale">Diskon</div>
                                            <?php } ?>    
                                            <div class="icon">
                                                <i class="icon_heart_alt wishlist" data-nama="<?=$r['nama']?>" data-id="<?=$r['id']?>"></i>
                                            </div>
                                        </div>
                                        <div class="pi-text">
                                            <div class="catagory-name"><?=$r['brand']?></div>
                                            <a href="<?=base_url('product/').$r['url']?>">
                                                <h5><?=$r['nama']?></h5>
                                            </a>
                                            <div class="product-price">
                                                <?=$r['diskon']>0?'Rp. '.number_format($r['total_harga'],'0',',','.').' <span>Rp. '.number_format($r['harga'],'0',',','.').'</span>':'Rp. '.number_format($r['total_harga'],'0',',','.')?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <!--Pagination-->
                    <?=$this->pagination->create_links();?>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->
