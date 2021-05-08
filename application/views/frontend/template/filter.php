
            <div class="row pb-3">
                <div class="col">
                <form action="<?=base_url('catalog')?>" method="get">
                    <div class="filter-grid">
                        <ul>
                            <li class="dropdown megamenu"><a id="megamneu" class="filterBtn" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter<i class="icon ion-plus-round"></i></a>
                                <div class="dropdown-menu border-0 p-0 m-0" aria-labelledby="megamneu">
                                    <div class="contain-frame">
                                        <div class="row bg-white rounded-0 m-0 shadow-sm">
                                            <div class="col">
                                                <div class="filter-list-frame">
                                                    <h1 class="filter-header">FILTER</h1>
                                                    <div class="row filter-padd">
                                                        <!--<div class="col-lg-3 mb-4">
                                                            <div class="type">
                                                                <h1 class="text-uppercase pb-3">TYPE</h1>
                                                                <div class="filter-list">
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Basic</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Graphic</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Long Sleeve</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Short Sleeve</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Oversize</label></div>
                                                                </div>
                                                            </div>
                                                        </div>-->

                                                        <div class="col-lg-3 mb-4">
                                                            <div class="type">
                                                                <h1 class="text-uppercase pb-3">COLOUR</h1>
                                                                <?php foreach($listWarna as $r):?>
                                                                <div class="filter-list">
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="warna" id="<?=strtolower($r['nama'])?>-warna" value="<?=$r['nama']?>" <?=$this->input->get('warna')==$r['nama']?'checked':''?>><label class="form-check-label" for="<?=strtolower($r['nama'])?>-warna"<?=$this->input->get('warna')==$r['nama']?"class='active-warna'":''?>><?=$r['nama']?></label></div>
                                                                </div>
                                                                <?php endforeach;?>  
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 mb-4">
                                                            <div class="type">
                                                                <h1 class="text-uppercase pb-3">SIZE - HURUF</h1>
                                                                <?php foreach($listSizeHuruf as $r):?>
                                                                <div class="filter-list">
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="size" id="<?=strtolower($r['nama'])?>-size" value="<?=$r['nama']?>" <?=$this->input->get('size')==$r['nama']?'checked':''?>><label class="form-check-label" for="<?=strtolower($r['nama'])?>-size"<?=$this->input->get('size')==$r['nama']?"class='active-size'":''?>><?=$r['nama']?></label></div>
                                                                </div>
                                                                <?php endforeach;?>  
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 mb-4">
                                                            <div class="type">
                                                                <h1 class="text-uppercase pb-3">SIZE - ANGKA</h1>
                                                                <?php foreach($listSizeAngka as $r):?>
                                                                <div class="filter-list">
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="size" id="<?=strtolower($r['nama'])?>-size" value="<?=$r['nama']?>" <?=$this->input->get('size')==$r['nama']?'checked':''?>><label class="form-check-label" for="<?=strtolower($r['nama'])?>-size"<?=$this->input->get('size')==$r['nama']?"class='active-size'":''?>><?=$r['nama']?></label></div>
                                                                </div>
                                                                <?php endforeach;?>  
                                                            </div>
                                                        </div>
                                                        <!--<div class="col-lg-3 mb-4">
                                                            <div class="type">
                                                                <h1 class="text-uppercase pb-3">PRICE</h1>
                                                                <div class="filter-list">
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 100000</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 150000</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 200000</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 250000</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 300000</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 400000</label></div>
                                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Up to IDR 500000</label></div>
                                                                </div>
                                                            </div>
                                                        </div>-->

                                                    </div>
                                                    <div class="row">
                                                        <div class="col pb-2 btn-pos"><input type="reset" value="RESET" class="btn btn-type1-small"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col pb-2 btn-pos"><input type="submit" value="SEE RESULT" class="btn btn-type1-small"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
                </div>
            </div>