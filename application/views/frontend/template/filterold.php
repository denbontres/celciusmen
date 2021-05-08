<div class="col-lg-3">
                    <form action="<?=base_url('Shop')?>" method="get">
                        <div class="filter-widget">
                            <h4 class="fw-title">Categories</h4>
                            <div class="fw-brand-radio">
                                <?php $i=1; foreach($jenisBarang as $r):?>
                                <div class="bc-item">
                                    <label for="jenis-<?=$i?>">
                                        <?=$r['nama']?>
                                        <input type="radio" name="jenis" id="jenis-<?=$i?>" value="<?=$r['url']?>" <?=$this->input->get('jenis')==$r['url']?'checked':''?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <?php $i++; endforeach;?>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4 class="fw-title">Brand</h4>
                            <div class="fw-brand-check">
                                <?php $i=1; foreach($brand as $r):?>
                                    <div class="bc-item">
                                        <label for="brand<?=$i?>">
                                            <?=$r['brand']?>
                                            <input type="checkbox" name="brand[]" value="<?=$r['brand_slug']?>" <?php if($this->input->get('brand')) { if (in_array($r['brand_slug'], $this->input->get('brand'))) {echo 'checked';}}?> id="brand<?=$i?>">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                <?php $i++; endforeach;?>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4 class="fw-title">Price</h4>
                            <div class="filter-range-wrap">
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="number" name="harga-min" value="<?=$this->input->get('harga-min')?>" id="minamount">
                                        <input type="number" name="harga-max" value="<?=$this->input->get('harga-max')?>" id="maxamount">
                                    </div>
                                </div>
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="<?=$this->input->get('harga-min')?$this->input->get('harga-min'):'10'?>" data-max="<?=$this->input->get('harga-max')?$this->input->get('harga-max'):'10000000'?>">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4 class="fw-title">Rating</h4>
                            <div class="fw-brand-radio">
                                <?php for($i=1;$i<=5;$i++){?>
                                    <div class="bc-item">
                                        <label for="rating-<?=$i?>">
                                            <?php for($j=1;$j<=$i;$j++){?><i class="fa fa-star text-warning"></i><?php }?>
                                            <input type="radio" name="rating" id="rating-<?=$i?>" value="<?=$i?>" <?=$this->input->get('rating')==$i?'checked':''?>>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="filter-widget mb-5">
                            <h4 class="fw-title">Color</h4>
                            <div class="fw-color-choose">
                                <?php foreach($listWarna as $r):?>
                                    <div class="cs-item">
                                        <input type="radio" name="warna" value="<?=$r['nama']?>" id="cs-<?=$r['kode_element']?>" <?=$this->input->get('warna')==$r['nama']?'checked':''?>>
                                        <label for="cs-<?=$r['kode_element']?>"  class="<?=$r['nama']==$this->input->get('warna')?'active-warna':''?>" id="<?=$r['kode_element']?>"><?=$r['nama']?></label>
                                        <style>
                                            <?='#'.$r['kode_element']?>:before {
                                                background: <?=$r['kode_warna']?> 
                                            }
                                        </style>
                                    </div>
                                <?php endforeach; ?>
                                <?php if($jumlahWarna%2!=0) { ?>
                                    <div class="cs-item" d>
                                        <input type="radio" id="cs-none" value="">
                                        <label class="cs-none" for="cs-none" id="none">&nbsp;</label>
                                        <style>
                                            #none:before {
                                                background: white 
                                            }
                                        </style>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4 class="fw-title">Size - Huruf</h4>
                            <div class="fw-size-choose">
                                <?php foreach($listSizeHuruf as $r):?> 
                                    <div class="sc-item">
                                        <input type="radio" name="size" id="<?=strtolower($r['nama'])?>-size" value="<?=$r['nama']?>" <?=$this->input->get('size')==$r['nama']?'checked':''?>>
                                        <label for="<?=strtolower($r['nama'])?>-size" <?=$this->input->get('size')==$r['nama']?"class='active-size'":''?>><?=$r['nama']?></label>
                                    </div>
                                <?php endforeach;?>           
                            </div>
                            
                            <h4 class="fw-title mt-3">Size - Angka</h4>
                            <div class="fw-size-choose">
                                <?php foreach($listSizeAngka as $r):?> 
                                    <div class="sc-item">
                                        <input type="radio" name="size" id="<?=strtolower($r['nama'])?>-size" value="<?=$r['nama']?>" <?=$this->input->get('size')==$r['nama']?'checked':''?>>
                                        <label for="<?=strtolower($r['nama'])?>-size" <?=$this->input->get('size')==$r['nama']?"class='active-size'":''?>><?=$r['nama']?></label>
                                    </div>
                                <?php endforeach;?>           
                            </div>

                            <!-- <h4 class="fw-title">Size</h4>
                            <div class="fw-size-choose">
                                <div class="sc-item">
                                    <input type="radio" name="size" id="s-size" value="S" <?=$this->input->get('size')=='S'?'checked':''?>>
                                    <label for="s-size" <?=$this->input->get('size')=='S'?"class='active-size'":''?>>S</label>
                                </div>
                                <div class="sc-item">
                                    <input type="radio" name="size" id="m-size" value="M" <?=$this->input->get('size')=='M'?'checked':''?>>
                                    <label for="m-size" <?=$this->input->get('size')=='M'?"class='active-size'":''?>>M</label>
                                </div>
                                <div class="sc-item">
                                    <input type="radio" name="size" id="l-size" value="L" <?=$this->input->get('size')=='L'?'checked':''?>>
                                    <label for="l-size" <?=$this->input->get('size')=='L'?"class='active-size'":''?>>L</label>
                                </div>
                                <div class="sc-item">
                                    <input type="radio" name="size" id="xs-size" value="XL" <?=$this->input->get('size')=='XL'?'checked':''?>>
                                    <label for="xs-size" <?=$this->input->get('size')=='XL'?"class='active-size'":''?>>XL</label>
                                </div>
                            </div> -->

                            <!-- <h4 class="fw-title mt-3">Size - Angka</h4>
                            <div class="fw-size-choose">
                                <div class="sc-item">
                                    <input type="radio" name="size" id="s-size" value="S" <?=$this->input->get('size')=='S'?'checked':''?>>
                                    <label for="s-size" <?=$this->input->get('size')=='S'?"class='active-size'":''?>>S</label>
                                </div>
                                <div class="sc-item">
                                    <input type="radio" name="size" id="m-size" value="M" <?=$this->input->get('size')=='M'?'checked':''?>>
                                    <label for="m-size" <?=$this->input->get('size')=='M'?"class='active-size'":''?>>M</label>
                                </div>
                                <div class="sc-item">
                                    <input type="radio" name="size" id="l-size" value="L" <?=$this->input->get('size')=='L'?'checked':''?>>
                                    <label for="l-size" <?=$this->input->get('size')=='L'?"class='active-size'":''?>>L</label>
                                </div>
                                <div class="sc-item">
                                    <input type="radio" name="size" id="xs-size" value="XL" <?=$this->input->get('size')=='XL'?'checked':''?>>
                                    <label for="xs-size" <?=$this->input->get('size')=='XL'?"class='active-size'":''?>>XL</label>
                                </div>
                            </div> -->
                            <input type="submit" value="Filter"  class="filter-btn mt-2">
                        </div>

                    </div>
                    </form> 
<script>
    $('input[type=radio]').click(function(){
        if (this.previous) {
            this.checked = false;
        }
        this.previous = this.checked;
    });
    $('input[name="warna"]').on('click',function(){
        $('.fw-color-choose label').removeClass("active-warna");
    });
    $('input[name="size"]').on('click',function(){
        $('.fw-size-choose label').removeClass("active-size");
        if($("input:radio[name='size']").is(":checked")) {
            
        }else{
            $('.fw-size-choose label').removeClass("active");
        }
    });
</script>