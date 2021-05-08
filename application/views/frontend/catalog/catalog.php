<h1 class="text-center title-header">New Arrival</h1>

    <div class="clean-block-30">
        <div class="container-fluid">
            <!-- start filter -->
            <?php $this->load->view($filter); ?>
            <!-- end filter -->
            <div class="row catalog">
                
                            <?php foreach($barang as $r):?>
                                <div class="col-md-3 clean-block-25" data-aos="fade">
                                        <div class="disc"><?php if($r['diskon']>0){ ?><span><?=$r['diskon']?>%</span><?php } ?>
                                        </div>
                                        <a href="<?=base_url('product/').$r['url']?>"><img src="<?=base_url('resource/').$r['foto']?>"></a>
                                    <div class="text-left detail"><span class="name-prod"><?=$r['nama']?><br></span>
                                                <?=$r['diskon']>0?'<span class="disc-price"><strong>IDR '.number_format($r['total_harga'],'0',',','.').' </strong><br></span>'.
                                                '<span class="not-disc" style="text-decoration: line-through;">Rp. '.number_format($r['harga'],'0',',','.').'</span>':'<span> IDR '.number_format($r['total_harga'],'0',',','.').'</span>'?>
                                    </div>
                                </div>

                             
                            <?php endforeach;?>
                      
                   
               
            </div>
        </div>
    </div>
    <div class="show-product pb-5">
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

                    <!--Pagination-->
                    <?=$this->pagination->create_links();?>
                                <!--<a class="btn btn-type5" role="button" href="#">SHOW MORE</a>-->
    </div>
        <a class="cd-top js-cd-top cd-top--fade-out cd-top--show" style="background-image:url(&quot;<?=base_url('asset/frontend/assets/img/')?>cd-top-arrow.svg&quot;);" href="#0">Top</a>
    <!-- Product Shop Section End -->
<script src="<?=base_url('asset/frontend/assets/')?>js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>