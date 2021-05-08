    <div class="py-2">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 pb-3">

                    <form action="<?=base_url('Register')?>" method="post">
                    <div class="px-3">
                        <h1 class="title-header-login">REGISTER</h1>
                    <div class="group">
                        <input class="ginput" type="text" name="nama" id="nama">
                        <?= form_error('nama','<small class="text-danger pl-3" id="error-nama">','</small>');?>
                        <label for="nama" class="glabel">FULL NAME</label>
                    </div>
                    
                            <div class="group">
                                <input class="ginput" type="text" name="nohp" id="nohp">
                                <?= form_error('nohp','<small class="text-danger pl-3" id="error-nohp">','</small>');?>
                                <label for="nohp">No HP</label>
                            </div>

                    <div class="group">
                        <input class="ginput" type="email" name="email" id="email">
                        <?= form_error('email','<small class="text-danger pl-3" id="error-email">','</small>');?>
                        <label for="email" class="glabel">E-MAIL</label>
                    </div>


                    <div class="group">
                        <input class="ginput" type="password" name="password" id="password">
                        <?= form_error('password','<small class="text-danger pl-3" id="error-password">','</small>');?>
                        <label for="password" class="glabel">PASSWORD</label>
                    </div>


                    <div class="group">
                        <input class="ginput" type="password" name="repassword" id="repassword">
                        <?= form_error('repassword','<small class="text-danger pl-3" id="error-repassword">','</small>');?>
                        <label for="repassword" class="glabel">RE-PASSWORD</label>
                    </div>

                    </div>

                    <div class="py-3">
                        <div class="form-check text-center"><input type="checkbox" class="form-check-input" id="formCheck-1" /><label class="form-check-label" for="formCheck-1">I have read and understand the <a href="#">Privacy and Cookies Policy</a></label>
                        </div>
                    </div>
                    <div class="pos-btn"><button type="submit" class="btn btn-type5">CREATE ACCOUNT</button></div>
                </form>
                </div>
                <div class="col-md-6 pb-3">
                    <div class="p-5">
                        <h4>Register make you special<br><br></h4><i class="icon-tag"></i><span>&nbsp; 10% off order after you register + free shipping<br><br></span><i class="fas fa-gifts"></i><span>&nbsp; Exclusive gifts<br><br></span><i class="fa fa-calendar"></i><span>&nbsp; Special event invites<br><br></span>
                        <i
                            class="fa fa-percent"></i><span>&nbsp; Sale previews<br></span></div>
                </div>
            
            </div>
        </div>
    </div>

    
    <script>
    var UIController = (function (){
      var DOMString = {
        'email':'#email',
        'errorEmail':'#error-email',               
        'nama':'#nama',
        'errorNama':'#error-nama',               
        'nohp':'#nohp',
        'errorNohp':'#error-nohp',               
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

        $(dom.email).on('change',function(){
          uiCtr.bersihError(dom.errorEmail);
        });

        $(dom.nama).on('change',function(){
          uiCtr.bersihError(dom.errorNama);
        });

        $(dom.nohp).on('change',function(){
          uiCtr.bersihError(dom.errorNohp);
        });

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