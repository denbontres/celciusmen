  <script src="<?=base_url('asset/backend/')?>plugins/ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" href="<?= base_url('asset/backend/')?>plugins/assettag/jquery.tagsinput-revisited.css" />
  <script src="<?= base_url('asset/backend/')?>plugins/assettag/jquery.tagsinput-revisited.js"></script>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$judul?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?=$judul?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data <?=$judul?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?=base_url('admin/Faq/editFaq/').$faq['id']?>" method="post"  enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="judul">Judul</label>
                          <input type="text" name="judul" id="judul" class="form-control" value="<?=$faq['judul']?>">
                          <?= form_error('judul','<small class="text-danger pl-3" id="error-judul">','</small>');?>
                        </div>
                        <div class="form-group">
                          <label for="isi"></label>
                          <textarea name="isi" id="isi" rows="10" cols="80"><?=$faq['isi']?></textarea>
                          <?= form_error('isi','<small class="text-danger pl-3" id="error-isi">','</small>');?>
                        </div>
                      </div>
                    </div>
                    <input type="submit" value="Simpan" class="btn btn-primary">
                </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <script>
    CKEDITOR.replace( 'isi' );
    CKEDITOR.config.height = '20em';  
    $(document).ready(function(){
        if($('#error-foto').val()!=undefined){
            $('#notice-foto').hide();
        }
    });
  </script>
  <script>
    var UIController = (function (){
      var DOMString = {
        'judul':'#judul',
        'errorJudul':'#error-judul',        
        'isi':'#isi',
        'errorIsi':'#error-isi', 
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
        $('#tag').tagsInput();
        $(dom.judul).on('change',function(){
          uiCtr.bersihError(dom.errorJudul);
        });
        
        $(dom.isi).on('change',function(){
          uiCtr.bersihError(dom.errorIsi);
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