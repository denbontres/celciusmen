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
                <form action="<?=base_url('admin/Blog/editBlog/').$blog['id']?>" method="post"  enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="judul">Judul</label>
                          <input type="text" name="judul" id="judul" class="form-control" value="<?=$blog['judul']?>">
                          <?= form_error('judul','<small class="text-danger pl-3" id="error-judul">','</small>');?>
                        </div>
                        <div class="form-group">
                          <label for="isi"></label>
                          <textarea name="isi" id="isi" rows="10" cols="80"><?=$blog['isi']?></textarea>
                          <?= form_error('isi','<small class="text-danger pl-3" id="error-isi">','</small>');?>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="deskripsi">Deskripsi</label>
                              <textarea name="deskripsi" class ="form-control" id="deskripsi" cols="30" rows="6"><?=$blog['deskripsi']?></textarea>
                              <?= form_error('deskripsi','<small class="text-danger pl-3" id="error-deskripsi">','</small>');?>
                          </div>
                          <div class="form-group">
                            <label for="foto">Foto</label><br>
                            <input type="file" name="foto" id="foto"><br>
                            <small class="text-danger pl-2" id="notice-foto">File harus dibawah 1 Mb dengan format jpg atau png</small>
                            <?= form_error('foto','<small class="text-danger pl-3" id="error-foto">','</small>');?>
                          </div>
                          <div class="form-group">
                            <label for="tag">Tag</label>
                            <input type="text" name="tag" id="tag" class="form-control" value="<?=$blog['tag']?>">
                            <?= form_error('tag','<small class="text-danger pl-3" id="error-tag">','</small>');?>
                          </div>
                          <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" value="<?=$blog['kategori']?>">
                            <?= form_error('kategori','<small class="text-danger pl-3" id="error-kategori">','</small>');?>
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
        'tag':'#tag',
        'errorTag':'#error-tag',        
        'kategori':'#kategori',
        'errorKategori':'#error-kategori',         
        'deskripsi':'#deskripsi',
        'errorDeskripsi':'#error-deskripsi', 
        'foto':'#foto',
        'errorFoto':'#error-foto',  
        'noticeFoto':'#notice-foto'         
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
        
        $(dom.tag).on('change',function(){
          uiCtr.bersihError(dom.errorTag);
        });

        $(dom.kategori).on('change',function(){
          uiCtr.bersihError(dom.errorKategori);
        });

        $(dom.deskripsi).on('change',function(){
          uiCtr.bersihError(dom.errorDeskripsi);
        });
        
        $(dom.isi).on('change',function(){
          uiCtr.bersihError(dom.errorIsi);
        });
        $(dom.foto).on('change',function(){
          if($(dom.foto).val()){
            $(dom.noticeFoto).hide();
          }else{
            $(dom.noticeFoto).show();
          }
          uiCtr.bersihError(dom.errorFoto);
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