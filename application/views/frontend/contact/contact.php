<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Map Section Begin -->
    <div class="map spad">
        <div class="container">
            <div class="map-inner">
                <?=$basic['map']?>
            </div>
        </div>
    </div>
    <!-- Map Section Begin -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-title">
                        <h4>Contacts Us</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, maki years old.</p>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="ci-text">
                                <span>Address:</span>
                                <p><?=$basic['alamat']?></p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div class="ci-text">
                                <span>Phone:</span>
                                <p><?=$basic['notelp']?></p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Email:</span>
                                <p><?=$basic['email']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="contact-form">
                        <div class="leave-comment">
                            <h4>Leave A Comment</h4>
                            <p>Kami akan menghubungi anda melalui email yang diberikan.</p>
                            <form action="<?=base_url('Contact')?>" method="post" class="comment-form">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" placeholder="Nama" name="nama" id="nama" value="<?=set_value('nama')?>">
                                        <?= form_error('nama','<small class="text-danger pl-3" id="error-nama">','</small>');?>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" placeholder="Email" name="email" id="email" value="<?=set_value('email')?>">
                                        <?= form_error('email','<small class="text-danger pl-3" id="error-email">','</small>');?>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <textarea placeholder="Pesan" name="pesan" id="pesan"><?=set_value('pesan')?></textarea>
                                        <?= form_error('pesan','<small class="text-danger pl-3" id="error-pesan">','</small>');?>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="site-btn">Send message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
    <?= $this->session->flashdata('pesan')?>
    
    <script>
    var UIController = (function (){
      var DOMString = {
        'email':'#email',
        'errorEmail':'#error-email',               
        'nama':'#nama',
        'errorNama':'#error-nama',           
        'pesan':'#pesan',
        'errorPesan':'#error-pesan',           
      };
      return {
        getDOM:function(){
          return DOMString;
        },
        bersihError:function(dom){
          $(dom).text("");
        }  
      }
    })();

    var Controller = (function (uiCtr){
      var dom;
      var setupEventListener = function(){
        dom = uiCtr.getDOM();

        $(dom.email).on('change',function(){
          uiCtr.bersihError(dom.errorEmail);
        });

        $(dom.nama).on('change',function(){
          uiCtr.bersihError(dom.errorNama);
        });

        $(dom.pesan).on('change',function(){
          uiCtr.bersihError(dom.errorPesan);
        });

      }    
      return {
          init:function(){
            setupEventListener();
          }
        }
    })(UIController);
    Controller.init();
</script>