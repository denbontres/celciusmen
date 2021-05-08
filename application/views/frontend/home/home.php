      <div class="main-banner" style="background-image: url(&quot;<?=base_url('asset/frontend/assets/img/')?>moto1.jpg&quot;);">
        <div class="main-headline">
            <h1>SPEED REBEL</h1>
            <p class="pb-4">Discover the celcius speed rebel vol. 2<br></p><a class="btn btn-type4 px-5" role="button" href="index.html">VIEW</a></div>
    </div>
    <div style="position: relative;overflow: hidden;padding-top: 56.25%;"><iframe allowfullscreen="" frameborder="0" src="https://www.youtube.com/embed/ai3urgYqp84?loop=1&amp;playlist=ai3urgYqp84&amp;controls=0" style="width: 100%;height: 100%;position: absolute;top: 0;left: 0;"></iframe></div>
    <div class="main-banner" style="background-image: url(&quot;<?=base_url('asset/frontend/assets/img/')?>bann-col.jpg&quot;);">
        <div class="main-headline">
            <h1>COLLECTION</h1>
            <p class="pb-4">Discover the celcius speed rebel vol. 2<br></p><a class="btn btn-type4 px-5" role="button" href="index.html">VIEW</a></div>
    </div>
    <div class="main-banner" style="background-image: url(&quot;<?=base_url('asset/frontend/assets/img/')?>moto3.jpg&quot;);">
        <div class="main-headline">
            <h1>SPECIAL PRICE</h1>
            <p class="pb-4">Discover the celcius speed rebel vol. 2<br></p><a class="btn btn-type4 px-5" role="button" href="index.html">VIEW</a></div>
    </div>
    <div>
        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-md-6 p-3">
                    <div class="sub-main-headline">
                        <h1>RUSH</h1>
                        <p class="pb-4">Discover the celcius speed rebel vol. 2<br></p><a class="btn btn-type4 px-5" role="button" href="index.html">VIEW</a></div><img src="<?=base_url('asset/frontend/assets/')?>img/rush1.jpg" style="width: 100%;"></div>
                <div class="col-md-6 p-3">
                    <div class="sub-main-headline">
                        <h1>KIDS</h1>
                        <p class="pb-4">Discover the celcius speed rebel vol. 2<br></p><a class="btn btn-type4 px-5" role="button" href="index.html">VIEW</a></div><img src="<?=base_url('asset/frontend/assets/')?>img/kids2.jpg" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <!-- Latest Blog Section End -->
    <?php if($selesai == 200){?>
        <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
        <script>$(function () { toastr.success('Pembayaran Diterima');});</script>
    <?php }?>
    