<!-- Blog Details Section Begin -->
<section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <div class="blog-detail-title">
                            <h2><?=$blog['judul']?></h2>
                            <p><?=$blog['kategori']?> <span>- <?=tglIndo($blog['waktu'])?></span></p>
                        </div>
                        <div class="blog-large-pic">
                            <img src="<?=base_url('resource/').$blog['photo']?>" alt="<?=$blog['judul']?>">
                        </div>
                        <div class="blog-detail-desc">
                            <?=$blog['isi']?>
                        </div>
                        <div class="blog-more">
                            <div class="row">
                                <?php foreach($related as $r):?>
                                    <div class="col-sm-4">
                                        <img src="<?=base_url('resource/').$blog['photo']?>" alt="<?=$blog['judul']?>">
                                        <a href="<?=base_url('Blog/'.$r['url'])?>"><h4><?=$r['judul']?></h4></a>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="tag-share">
                            
                            <div class="details-tag">
                                <ul>
                                    <li><i class="fa fa-tags"></i></li>
                                    <?php foreach($tag as $r):?>
                                        <li><?=str_replace(',','',$r)?></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <div class="blog-share">
                                <span>Share:</span>
                                <div class="social-links">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->