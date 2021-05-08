    <div class="py-2">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 pb-3">

                    <?= $this->session->flashdata('pesan')?>
                    <form action="<?=base_url('Login')?>" method="post">
                    <div class="px-3">
                        <h1 class="title-header-login">LOGIN</h1>
                        <div class="group">
                            <input class="ginput" type="email" id="email" name="email" value="<?=set_value('email')?>">
                                <?= form_error('email','<small class="text-danger pl-3" id="error-email">','</small>');?>
                                <label class="glabel">E-MAIL</label>
                        </div>
                        <div class="group">
                            <input class="ginput" type="password" id="password" name="password">
                            <?= form_error('password','<small class="text-danger pl-3" id="error-password">','</small>');?>
                            <label class="glabel">PASSWORD</label>
                        </div>
                    </div>
                    <p class="text-center py-1">Forgot password ?&nbsp;<a href="<?=base_url('ResetPassword')?>" class="forget-pass">Click here</a></p>
                    <div class="pos-btn"><button type="submit" class="btn btn-type5">LOGIN</button>
                    </div>
                    </form>
                </div>
                <div class="col-md-6 pb-3">
                    <h1 class="title-header-login">NEW USER</h1>
                    <p class="text-center">If you still don't have a Celciusmen.com account, use this option to access the registration form.<br><br>If you provide us with details, you will have a fast and enjoyable shopping experience at Celciusmen.com.<br><br></p>
                    <div class="pos-btn"><a href="<?=base_url('Register')?>" class="btn btn-type5">Or CREATE AN ACCOUNT</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
    var UIController = (function (){
      var DOMString = {
        'email':'#email',
        'errorEmail':'#error-email',               
        'password':'#password',
        'errorPassword':'#error-password'           
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

        $(dom.password).on('change',function(){
          uiCtr.bersihError(dom.errorPassword);
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