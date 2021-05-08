
    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Ganti Password</h2>
                        <form action="<?=base_url('ResetPassword/gantiPassword')?>" method="post">
                            <div class="group-input">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password">
                                <?= form_error('password','<small class="text-danger pl-3" id="error-password">','</small>');?>
                            </div>
                            <div class="group-input">
                                <label for="repassword">Repeat Password</label>
                                <input type="password" name="repassword" id="repassword">
                                <?= form_error('repassword','<small class="text-danger pl-3" id="error-repassword">','</small>');?>
                            </div>
                            <button type="submit" class="site-btn login-btn">Ganti Password</button>
                        </form>
                        <div class="switch-login">
                            <a href="<?=base_url('Login')?>" class="or-login">Or Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->


    <script>
    var UIController = (function (){
      var DOMString = {             
        'password':'#password',
        'errorPassword':'#error-password',           
        'repassword':'#repassword',
        'errorRepassword':'#error-repassword'           
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

        $(dom.repassword).on('change',function(){
          uiCtr.bersihError(dom.errorRepassword);
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