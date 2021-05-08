 <!-- Breadcrumb Section Begin -->
 <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1">
                    <div class="blog-sidebar">
                        <div class="search-form">
                            <h4>Search</h4>
                            <form action="<?=base_url('Blog')?>" method="GET">
                                <input type="text" name="search" value="<?=$this->input->get('search');?>" id="search" placeholder="Search . . .  ">
                                <button  type="submit" value="Search"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="blog-catagory">
                            <h4>Categories</h4>
                            <ul>
                                <?php foreach($kategori as $r):?>
                                    <li><a href="<?=base_url('Blog?kategori='.$r['kategori'])?>"><?=$r['kategori']?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <div class="recent-post">
                            <h4>Latest Post</h4>
                            <div class="recent-blog">
                                <?php foreach($latesArtikel as $r):?>
                                <a href="<?=base_url('Blog/'.$r['url'])?>" class="rb-item">
                                    <div class="rb-pic">
                                        <img src="<?=base_url('resource/').$r['photo']?>" alt="<?=$r['judul']?>">
                                    </div>
                                    <div class="rb-text">
                                        <h6><?=word_limiter($r['judul'], 4);?></h6>
                                        <p><?=$r['kategori']?> <span>- <?=tglIndo($r['waktu'])?></span></p>
                                    </div>
                                </a>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="blog-tags">
                            <h4>Product Tags</h4>
                            <div class="tag-item">
                                <?php foreach($uniqueTag as $r):?>
                                    <a href="<?=base_url('Blog?tag='.$r)?>"><?=$r?></a>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="row">
                        <?php foreach($blog as $r):?>
                            <div class="col-lg-6 col-sm-6">
                                <div class="blog-item">
                                    <div class="bi-pic">
                                        <img src="<?=base_url('resource/').$r['photo']?>" alt="<?=$r['judul']?>">
                                    </div>
                                    <div class="bi-text">
                                        <a href="<?=base_url('Blog/'.$r['url'])?>">
                                            <h4><?=word_limiter($r['judul'], 10);?></h4>
                                        </a>
                                        <p><?=$r['kategori']?> <span>- <?=tglIndo($r['waktu'])?></span></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>    
                        <div class="col-lg-12">
                            <!--Pagination-->
                            <?=$this->pagination->create_links();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->