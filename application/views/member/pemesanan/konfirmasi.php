
<div class="card">
    <div class="card-body">
        <div>
            <h2 class="mb-4"><?=$title?></h2>
            <div class="row">
                <div class="col-md-6">
                    <form action="<?=base_url('member/Pemesanan/konfirmasiPembayaran/'.$faktur)?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="norek">Nomor Rekening <small class="text-danger">*</small></label>
                            <input type="text" name="norek" id="norek" value="<?=set_value('norek')?set_value('norek'):$konfirmasi['rekening']?$konfirmasi['rekening']:''?>" class="form-control">
                            <?= form_error('norek','<small class="text-danger pl-3" id="error-norek">','</small>');?>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Pembayaran <small class="text-danger">*</small></label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control" <?=set_value('jumlah')?set_value('jumlah'):$konfirmasi['jumlah']?$konfirmasi['jumlah']:''?>>
                            <?= form_error('jumlah','<small class="text-danger pl-3" id="error-jumlah">','</small>');?>
                        </div>
                        <div>
                            <label for="bukti">Bukti Pembayaran <small class="text-danger">*</small></label>
                            <input type="file" name="bukti" id="bukti" ><br>
                            <small class="text-danger" id="notice-bukti">Harus berformat JPG atau PNG,ukuran dibawah 1 Mb</small>
                            <?= form_error('bukti','<small class="text-danger pl-3" id="error-bukti">','</small>');?>
                        </div>
                        <?php if($token){?>
                          <div class="form-group">
                            <input type="submit" value="Kirim" class="btn btn-primary">
                            <input type="reset" value="batal" class="btn btn-danger">
                          </div>
                        <?php }?>
                    </form>
                </div>
                <div class="col-md-6">
                    <img src="<?=$konfirmasi['rekening']?base_url('resource/'.$konfirmasi['rekening']):base_url('resource/blank.jpg')?>" id="show" alt="Bukti Pembayaran" style="width:20rem;height:15rem"><br>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        if($('#error-bukti').val()!=undefined){
            $('#notice-bukti').hide();
        }
    });
  </script>
  <script>
    var UIController = (function (){
      var DOMString = {
        'norek':'#norek',
        'errorNorek':'#error-norek',              
        'jumlah':'#jumlah',
        'errorJumlah':'#error-jumlah',              
        'bukti':'#bukti',
        'errorBukti':'#error-bukti',  
        'noticeBukti':'#notice-bukti'            
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

        $(dom.norek).on('change',function(){
          uiCtr.bersihError(dom.errorNorek);
        });
        $(dom.jumlah).on('change',function(){
          uiCtr.bersihError(dom.errorJumlah);
        });

        $(dom.bukti).on('change',function(){
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                $('#show')
                    .attr('src', e.target.result)
                };
                reader.readAsDataURL(this.files[0]);
                if($(dom.bukti).val()){
                    $(dom.noticeBukti).hide();
                }else{
                    $(dom.noticeBukti).show();
                }
                uiCtr.bersihError(dom.errorBukti);
            }
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