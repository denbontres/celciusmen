    <div class="py-2">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 pb-3">
                    <form action="<?=base_url('ResetPassword')?>" method="post">
                    <div class="px-3">
                        <h1 class="title-header-login">FORGOT PASSWORD</h1>
                        <p class="text-center">Enter your e-mail address and we will send you an e-mail telling you how to recover it.<br><br></p>
                        <div class="group">
                            <input class="ginput" type="text" required>
                            <label class="glabel">E-MAIL</label>
                        </div>
                    </div>
                    <div class="pos-btn"><button type="submit" class="btn btn-type5">RETRIEVE PASSWORD</button>
                    </div>
                    </form>
                </div>
 
            </div>
        </div>
    </div>


    <script>
    var UIController = (function (){
      var DOMString = {
        'email':'#email',
        'errorEmail':'#error-email',                   
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

      }    
      return {
          init:function(){
            setupEventListener();
          }
        }
    })(UIController);
    Controller.init();
</script>