<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>FAQs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Faq Section Begin -->
    <div class="faq-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq-accordin">
                        <div class="accordion" id="accordionExample">
                            <?php $i=1; foreach($faq as $r):?>
                                <div class="card">
                                    <div class="card-heading <?=$i==1?'active':''?>">
                                        <a class="<?=$i==1?'active':''?>" data-toggle="collapse" data-target="#collapse-<?=$i?>">
                                            <?=$r['judul']?>
                                        </a>
                                    </div>
                                    <div id="collapse-<?=$i?>" class="collapse <?=$i==1?'show':''?>" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p><?=$r['isi']?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; endforeach;?>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq Section End -->