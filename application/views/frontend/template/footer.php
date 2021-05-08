<?php
    $ci = get_instance();
    $ci->load->model('BasicModel','basic');
    $basic = $ci->basic->getAllRow();
?>

        <div>
        <div class="container-fluid back-grey">
            <div class="row text-center padding-64 font-padd">
                <div class="col-md-4 contain-padd-40"><i class="fa fa-credit-card grey-icon"></i>
                    <p class="font-weight-3"><br>Payment by Midtrans<br></p>
                    <p class="pt-2">Easy shop and pay now at checkout<br></p>
                </div>
                <div class="col-md-4 contain-padd-40"><i class="fa fa-check-circle-o grey-icon"></i>
                    <p class="font-weight-3"><br>Transaction &amp; Data secure<br></p>
                    <p class="pt-2">Our web is secure and support payment 3rd party<br></p>
                </div>
                <div class="col-md-4 contain-padd-40"><i class="fa fa-whatsapp grey-icon"></i>
                    <p class="font-weight-3"><br>Support hotline 24/7<br></p>
                    <p class="pt-2">WA Official 087775019225<br></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-lg-flex justify-content-lg-end bahasa mt-3 py-2">
        <div>
            <p class="p-2"><strong>Language :&nbsp;</strong></p>
        </div>
        <div class="d-flex btn-bahasa"><a class="p-2" href="#">English</a></div>
        <div>
            <p class="p-2"><strong>|</strong></p>
        </div>
        <div class="btn-bahasa"><a class="d-flex p-2" href="#">Indonesia</a></div>
    </div>

    <hr>
    <div class="footer-clean">
        <footer>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-4 col-md-3">
                        <a href="help.html">
                            <h3 class="text-center py-4">HELP</h3>
                        </a>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <a href="catalog.html">
                            <h3 class="text-center py-4">EXPLORE</h3>
                        </a>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <a href="policy.html">
                            <h3 class="text-center py-4">POLICY</h3>
                        </a>
                    </div>
                    <div class="col-lg-3 item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="https://www.youtube.com/channel/UCTBavLm_Z1zr_4bxVvRAl1g"><i class="icon ion-social-youtube"></i></a><a href="https://www.instagram.com/celcius_idn/"><i class="icon ion-social-instagram"></i></a>
                        <p
                            class="copyright">Celciusmen © 2021</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>