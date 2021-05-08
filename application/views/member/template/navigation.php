<?php
    $ci = get_instance();
    $ci->load->model('BasicModel','basic');
    $basic = $ci->basic->getAllRow();
?>
    <nav class="navbar navbar-light navbar-expand-md shadow-sm">
        <div class="container-fluid"><a class="navbar-brand d-sm-flex align-items-sm-center" href="index.html"><img src="<?=base_url('asset/frontend/assets/')?>img/logo.png"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse d-md-flex justify-content-md-end" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item px-2" role="presentation"><a class="nav-link" href="<?=base_url('')?>" style="font-size: 14px;"><strong>MENS</strong></a></li>
                    <li class="nav-item px-2" role="presentation"><a class="nav-link" href="<?=base_url('rush')?>" style="font-size: 14px;"><strong>RUSH</strong></a></li>
                    <li class="nav-item px-2" role="presentation"><a class="nav-link" href="<?=base_url('kids')?>" style="font-size: 14px;"><strong>KIDS</strong></a></li>
                    <li class="nav-item px-2" role="presentation"><a class="nav-link" href="<?=base_url('catalog')?>" style="font-size: 14px;"><strong>CATALOG</strong></a></li>
                    <li class="nav-item px-2" role="presentation" data-toggle="tooltip" data-bs-tooltip="" data-placement="bottom" title="Location"><a class="nav-link" href="location.html"><i class="icon-location-pin"></i></a></li>
 
                    <?php if($this->session->userdata('email')) {?>
                    <li class="nav-item px-2" role="presentation" data-toggle="tooltip" data-bs-tooltip="" data-placement="bottom" title="Logout">
                        <a class="nav-link" href="<?=base_url('Authentikasi/logout')?>"><i class="icon-logout"></i></a>
                    </li>
                    <li class="nav-item px-2" role="presentation" data-toggle="tooltip" data-bs-tooltip="" data-placement="bottom" title="My Account">
                        <a class="nav-link" href="<?=base_url('member/Pemesanan/pemesanan')?>"><i class="icon-user"></i></a>
                    </li>
                     <?php }else { ?>
                    <li class="nav-item px-2" role="presentation" data-toggle="tooltip" data-bs-tooltip="" data-placement="bottom" title="Login">
                        <a class="nav-link" href="<?=base_url('Login')?>"><i class="icon-user"></i></a>
                    </li>
                    <?php } ?> 
                    <li class="nav-item pl-2" role="presentation" data-toggle="tooltip" data-bs-tooltip="" data-placement="bottom" title="Shopping bag"><a class="nav-link d-md-flex align-items-md-center" href="<?=base_url('Cart')?>"><i class="icon-bag"></i><span class="badge badge-pill badge-light" display="absolute">0</span></a></li>
                    <li class="nav-item d-lg-flex align-items-lg-center px-2"
                        role="presentation" title="Search">
                        <div id="myOverlay" class="overlay"><span class="closebtn" onclick="closeSearch()" title="Close Overlay"><i class="fa fa-close"></i></span>
                            <div class="overlay-content">
                                <h1 class="clean-block-15" style="font-size: 50px ; color: white;">You&nbsp;can&nbsp;search&nbsp;anything&nbsp;here<br></h1>
                                <form class="form-inline" action="/action_page.php"><input class="form-control" type="text" placeholder="Search.." name="search"><button class="btn" type="submit"><i class="fa fa-search"></i></button></form>
                            </div>
                        </div><button class="btn btn-primary openBtn py-2" data-toggle="tooltip" data-bs-tooltip="" data-placement="bottom" type="button" title="Search" onclick="openSearch()" style="padding: 0px;"><i class="icon-magnifier" style="color: rgb(145,145,145);"></i></button></li>
                </ul>
        </div>
        </div>
    </nav>