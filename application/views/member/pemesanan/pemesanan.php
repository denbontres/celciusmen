    <h1 class="text-center title-header">ACCOUNT</h1>
    <div class="text-center p-2"><a href="<?=base_url('Authentikasi/logout')?>" class="btn border rounded-0 shadow-sm" type="button" style="width: 100px;color: rgb(0,0,0);font-size: 14px;background-color: rgb(247,247,247);">Sign out</a></div><div class="container py-2">
<div class="p-3 bg-white rounded shadow mb-5">
    <!-- Bordered tabs-->
    <ul id="myTab1" role="tablist" class="nav nav-tabs nav-pills with-arrow flex-column flex-sm-row text-center">
      <li class="nav-item flex-sm-fill">
        <a id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 border active">Order History</a>
      </li>
      <li class="nav-item flex-sm-fill">
        <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 border">Profile</a>
      </li>
      <li class="nav-item flex-sm-fill">
        <a id="wishlist-tab" data-toggle="tab" href="#wishlist" role="tab" aria-controls="wishlist" aria-selected="false" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 border">Wishlist</a>
      </li>
      <li class="nav-item flex-sm-fill">
        <a id="gift-tab" data-toggle="tab" href="#gift" role="tab" aria-controls="gift" aria-selected="false" class="nav-link text-uppercase font-weight-bold rounded-0 border">Gift</a>
      </li>
      
    </ul>
    <div id="myTab1Content" class="tab-content">
      <div id="history" role="tabpanel" aria-labelledby="history-tab" class="tab-pane fade px-4 py-5 show active">

        <div class="col-4">
                                <form action="<?=base_url('member/Pemesanan/pemesanan')?>" method="post">
                        <select  name="status" onchange='this.form.submit()' class="form-control" style="border-radius: 0;">
                          <option value="all">All</option>
                          <option value="1" <?=set_value('status')=="1"?'selected':''?>>Menunggu Pembayaran</option>
                          <option value="2" <?=set_value('status')=="2"?'selected':''?>>Menunggu Konfirmasi</option>
                          <option value="3" <?=set_value('status')=="3"?'selected':''?>>Packing</option>
                          <option value="4" <?=set_value('status')=="4"?'selected':''?>>Dikirim</option>
                          <option value="5" <?=set_value('status')=="5"?'selected':''?>>Selesai</option>
                        </select>
                        <noscript><input type="submit" value="Submit" name="submit"></noscript>
                      </form>
        </div>

      
        <?php foreach($pemesanan as $r):?> 
        <!-- Contain-card-tabs-->
        <div class="card bg-light border-dark border rounded-0 shadow-sm" style="margin: 10px;">
          <div class="card-body">
              <div class="container">
                  <div class="row">
                      <div class="col-md-6 d-flex flex-column">
                        <span><strong>Order ID :</strong> #CEL<?=$r['nofaktur']?></span>
                        <span><strong>Date :</strong> <?=tglIndo($r['tanggal'])?></span>
                        <!--<span><strong>Items :</strong> 3</span>-->
                        <span><strong>Total transaction :</strong> IDR <?=number_format($r['total'],'0',',','.')?></span>
                        <span><strong>Status :</strong><?=getNameStatus($r['status'])?></span>
                      </div>
                      <div class="col-md-6">
                          <div class="tracking">
                              <div class="steps-progressbar">
                                  <ul style="font-size: 12px;">
                             
                                      <?php if($r['status']=='2'){?>
                                      <li class="active">Paid</li>
                                      <?php }else{?>
                                      <li class="previous">Paid</li>
                                      <?php }?>
                                      <?php if($r['status']=='3'){?>
                                      <li class="active">Packing</li>
                                      <?php }else{?>
                                      <li class="previous">Packing</li>
                                      <?php }?>
                                      <?php if($r['status']=='4'){?>
                                      <li class="active">Shipping</li>
                                      <?php }else{?>
                                      <li class="previous">Shipping</li>
                                      <?php }?>
                                      <?php if($r['status']=='5'){?>
                                      <li class="active">Delivered</li>
                                      <?php }else{?>
                                      <li class="previous">Delivered</li>
                                      <?php }?> 
                                  </ul>
                              </div>
                              <div class="text-center" style="padding-top: 5px;">
                                      

                                      <?php if($r['status']=='5'){?>
                                     <a href="<?=base_url('member/Pemesanan/review/'.$r['nofaktur'])?>" class="btn btn-primary border rounded-0" type="button" style="background-color: rgb(0,0,0);width: 150px;margin: 10px;font-size: 14px;">Review</a><!--Arahkan ke review-->
                                      <?php }else{?>
                                      <a href="<?=base_url('member/Pemesanan/detailPemesanan/'.$r['nofaktur'])?>" class="btn btn-primary border rounded-0" type="button" style="background-color: rgb(0,0,0);width: 150px;margin: 10px;font-size: 14px;">View order</a>
                                      <?php }?> 
                                      <?php if($r['status']=='1'){?>
                                      <a href="<?=base_url('member/Pemesanan/midtrans/'.$r['nofaktur'])?>" class="btn btn-primary border rounded-0" type="button" style="width: 150px;color: rgb(0,0,0);font-size: 14px;background-color: rgb(252,252,252);">Payment</a><!--Arahkan ke billing-->
                                      <?php } elseif($r['status']=='5'){?>
                                      <a href="#" class="btn btn-primary border rounded-0" type="button" style="width: 150px;color: rgb(0,0,0);font-size: 14px;background-color: rgb(252,252,252);">Finish</a><!--Arahkan ke billing-->
                                      <?php }else{?>
                                      <button class="btn btn-primary border rounded-0" type="button" style="width: 150px;color: rgb(0,0,0);font-size: 14px;background-color: rgb(252,252,252);">Tracking</button>
                                      <?php }?> 
                                
                              </div>
                          </div>
                  </div>
              </div>
          </div>
      </div>
      </div>
        <?php endforeach; ?>
        <!--Pagination-->
                      <?=$this->pagination->create_links();?>
      <!-- Contain-profil-->
      </div>
      <div id="profile" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
        <div class="container register">
          <div class="row">
              <div class="col-md-6" style="padding-bottom: 64px;">

                <div class="profile-contain">
                  <div class="name-email">
                      <h1 style="font-size: 40px;">LUGAS ANGKORO</h1>
                      <span class="padd-contain">lugasgilas@gmail.com</span>
                  </div>
                  <div class="d-flex flex-column padd-contain-15">
                      <h3 class="padd-contain-15" style="font-size: 25px;">SHIPPING DETAIL</h3>
                      <span>Address</span>
                      <span>Province</span>
                      <span>City</span>
                      <span>Distric</span>
                      <span>ZIP code</span>
                  </div>
              </div>

                  <button class="btn btn-sm text-center text-white btn-2" type="button">EDIT PROFILE</button></div>
              <div class="col-md-6 content-view">
                  <h4>Register make you special<br /><br /></h4><i class="icon-tag"></i><span>  10% off order after you register + free shipping<br /><br /></span><i class="fas fa-gifts"></i><span>  Exclusive gifts<br /><br /></span><i class="fa fa-calendar"></i><span>  Special event invites<br /><br /></span>
                  <i
                      class="fa fa-percent"></i><span>  Sale previews<br /></span></div>
          </div>
      </div>
      </div>


      <div id="wishlist" role="tabpanel" aria-labelledby="wishlist-tab" class="tab-pane fade px-4 py-5">
        <!-- Wishlist -->
        <div class="shopping-cart">


          <div class="pb-5">
            <div class="container">
              <div class="row shadow-sm py-4">
                <div class="col-lg-12">
        
                  <!-- Shopping cart table -->
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col" class="border-0 bg-light font-weight-bold">
                            <div class="p-2 px-3 text-uppercase">Product</div>
                          </th>
                          <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Price</div>
                          </th>
                          <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Qty</div>
                          </th>
                          <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Edit </div>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row" class="border-0">
                            <div class="p-2">
                              <img src="assets/img/prod1.jpg" class="cart-image">
                              <div class="contain-info d-inline-block align-middle">
                                <h3 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">
                                  Graphic Embro T-shirt Black</a></h3><span class="text-muted font-weight-normal d-block">Colour: White</span>
                                  <span class="text-muted font-weight-normal d-block">Size: S</span>
                              </div>
                            </div>
                          </th>
                          <td class="border-0 align-middle"><span>IDR 399.000</span></td>
                          <td class="border-0 align-middle"><span>1</span></td>
                          <td class="border-0 align-middle"><button class="btn btn-primary border rounded-0" type="button" style="background-color: rgb(0,0,0);width: 150px;margin: 10px;font-size: 14px;">Add to bag</button></td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <div class="p-2">
                              <img src="assets/img/prod1.jpg" class="cart-image">
                              <div class="contain-info d-inline-block align-middle">
                                <h3 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">
                                  Graphic Embro T-shirt Black</a></h3><span class="text-muted font-weight-normal d-block">Colour: White</span>
                                  <span class="text-muted font-weight-normal d-block">Size: S</span>
                              </div>
                            </div>
                          </th>
                          <td class="align-middle"><span><s>IDR 399.000</s></span><br><span>IDR 209.000</span></td>
                          <td class="align-middle"><span>1</span></td>
                          <td class="align-middle"><a href="#" class="text-dark"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <div class="p-2">
                              <img src="assets/img/prod1.jpg" class="cart-image">
                              <div class="contain-info d-inline-block align-middle">
                                <h3 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">
                                  Graphic Embro T-shirt Black</a></h3><span class="text-muted font-weight-normal d-block">Colour: White</span>
                                  <span class="text-muted font-weight-normal d-block">Size: S</span>
                              </div>
                            </div>
                            <td class="align-middle"><span>IDR 399.000</span></td>
                            <td class="align-middle"><span>1</span></td>
                            <td class="align-middle"><a href="#" class="text-dark"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- End -->
                </div>
              </div>
        
              
        
            </div>
          </div>
        </div>


      </div>

            <div id="gift" role="tabpanel" aria-labelledby="gift-tab" class="tab-pane fade px-4 py-5">
        <!-- Wishlist -->
     
      </div>
    </div>
    <!-- End bordered tabs -->
  </div>
</div>

          <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>