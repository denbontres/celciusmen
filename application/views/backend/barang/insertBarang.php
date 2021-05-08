  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url('asset/backend/')?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=base_url('asset/backend/')?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?=base_url('asset/backend/')?>plugins/select2/js/select2.full.min.js"></script>
  
  <style>
    .select2-selection__choice{
      background-color: #138496 !important;
    }
  </style>
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
    <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
    <script src="<?=base_url('asset/backend/')?>plugins/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="<?= base_url('asset/backend/')?>plugins/assettag/jquery.tagsinput-revisited.css" />
    <script src="<?= base_url('asset/backend/')?>plugins/assettag/jquery.tagsinput-revisited.js"></script>
    <script src="<?=base_url('asset/backend/')?>plugins/jquery/jquery.mask.min.js"></script>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?=$judul?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="<?=base_url('admin/Barang/insertBarang')?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Nama Barang
                            <input type="text" class="form-control" name="nama" id="nama-barang" value="<?=set_value('nama-barang')?>">
                            <?= form_error('nama','<small class="text-danger pl-3" id="error-nama">','</small>');?>
                        </div>
                        <div class="form-group">
                            Jenis Barang
                            <select name="jenis" id="jenis" class="form-control">
                                <?php foreach($jenis as $r):?>
                                <option value=<?=$r['id']?> <?=set_value('jenis')==$r['id']?'selected':''?>> <?=$r['nama']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            Kategori Barang
                            <select name="kategori" id="kategori" class="form-control">
                                <?php foreach($kategori as $r):?>
                                <option value=<?=$r['id']?> <?=set_value('kategori')==$r['id']?'selected':''?>> <?=$r['nama']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            Berat
                            <input type="text" class="form-control rupiah" name="berat" value="<?=set_value('berat')?>" id="berat">
                            <?= form_error('berat','<small class="text-danger pl-3" id="error-berat">','</small>');?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Harga
                            <input type="text" class="form-control rupiah" name="harga" id="harga-barang" value="<?=set_value('harga')?>">
                            <?= form_error('harga','<small class="text-danger pl-3" id="error-harga">','</small>');?>
                        </div>
                        <div class="form-group">
                            Diskon
                            <input type="number" max=100 min=0 class="form-control" name="diskon" id="diskon" value="<?=set_value('diskon')?>">
                            <?= form_error('diskon','<small class="text-danger pl-3" id="error-diskon">','</small>');?>
                        </div>
                        <div class="form-group">
                            Total Harga
                            <input type="text" class="form-control" name="total" id="total" disabled value="<?=set_value('total')?>"> 
                        </div>
                        <div class="form-group">
                            Brand
                            <input type="text" class="form-control" name="brand" id="brand" value="<?=set_value('brand')?>">
                            <?= form_error('brand','<small class="text-danger pl-3" id="error-brand">','</small>');?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            Deskripsi
                            <textarea name="deskripsi" class ="form-control" id="deskripsi" cols="30" rows="6"><?=set_value('deskripsi')?></textarea>
                            <?= form_error('deskripsi','<small class="text-danger pl-3" id="error-deskripsi">','</small>');?>
                        </div>
                        <div class="form-group">
                            Deskripsi Singkat
                            <textarea name="deskripsi-singkat" class ="form-control" id="deskripsi-singkat" cols="30" rows="6"><?=set_value('deskripsi-singkat')?></textarea>
                            <?= form_error('deskripsi-singkat','<small class="text-danger pl-3" id="error-deskripsi-singkat">','</small>');?>
                        </div>
                        <div class="form-group">
                          Foto Barang
                          <div class="row">
                              <div class="col-md-5">
                                  <img id="show" src="<?=base_url('resource/blank.jpg')?>" alt="your image" class="mb-2" width="130" height="150"/><br>
                                  <input type="file" name="foto" id="foto"><br>
                                  <?= form_error('foto','<small class="text-danger pl-3" id="error-foto">','</small>');?>
                              </div>
                              <div class="col-md-5">
                                  <img id="show2" src="<?=base_url('resource/blank.jpg')?>" alt="your image" class="mb-2" width="130" height="150"/><br>
                                  <input type="file" name="foto2" id="foto2"><br>
                                  <?= form_error('foto2','<small class="text-danger pl-3" id="error-foto2">','</small>');?>
                              </div>
                          </div>
                          <div class="row mt-5 mb-3">
                              <div class="col-md-5">
                                  <img id="show3" src="<?=base_url('resource/blank.jpg')?>" alt="your image" class="mb-2" width="130" height="150"/><br>
                                  <input type="file" name="foto3" id="foto3"><br>
                                  <?= form_error('foto3','<small class="text-danger pl-3" id="error-foto3">','</small>');?>
                              </div>
                              <div class="col-md-5">
                                  <img id="show4" src="<?=base_url('resource/blank.jpg')?>" alt="your image" class="mb-2" width="130" height="150"/><br>
                                  <input type="file" name="foto4" id="foto4"><br>
                                  <?= form_error('foto4','<small class="text-danger pl-3" id="error-foto4">','</small>');?>
                              </div>
                          </div>
                          <small><i>Foto Mininal 1 dan harus format JPG dan PNG, Dengan ukuran dibawah 1 MB</i></small>
                          <div class="form-group mt-3">
                              Tag
                              <input type="text" class="form-control" name="tag" id="tag" value="<?=set_value('tag')?>">
                              <?= form_error('tag','<small class="text-danger pl-3" id="error-tag">','</small>');?>
                          </div>
                          <div class="form-group mt-3">
                                Variant
                                <select class="select2" multiple="multiple" id="variant" name="variant[]" data-placeholder="Select a State" style="width: 100%;">
                                  <?php foreach($variant as $r):?>
                                    <option value="<?=$r['id']?>" <?=set_value('variant')==$r['id']?'selected':''?>><?=$r['nama']?></option>
                                  <?php endforeach;?>
                                </select>
                              <?= form_error('variant','<small class="text-danger pl-3" id="error-variant">','</small>');?>
                          </div>
                        </div>
                      </div>
                  </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-info mr-3">Simpan</button>
                    <button type="button" class="btn btn-danger" >Batal</button>
                  </div>
                </div>
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
  <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
  <?= $this->session->flashdata('pesan')?>
  <script>
        $(document).ready(function(){
            $('.rupiah').mask('000.000.000', {reverse: true});
            CKEDITOR.replace( 'deskripsi' );
            CKEDITOR.config.height = '20em';  
            $('#tag').tagsInput();
        });
  </script>
  <script>
  
  $(document).ready(function(){
    $('.rupiah').mask('000.000.000', {reverse: true});
  });

  var UIController = (function (){
    var DOMString = {
      'nama':'#nama-barang',
      'harga':'#harga-barang',
      'diskon':'#diskon',
      'berat':'#berat',
      'brand':'#brand',
      'total':'#total',
      'tag':'#tag',
      'deskripsiSingkat':'#deskripsi-singkat',
      'deskripsi':'#deskripsi',
      'foto':"#foto",
      'foto2':'#foto2',
      'foto3':'#foto3',
      'foto4':'#foto4',
      'show1':'#show',
      'show2':'#show2',
      'show3':'#show3',
      'show4':'#show4',
      'variant':'#variant',
      'errorNama':'#error-nama',
      'errorHarga':'#error-harga',
      'errorDiskon':'#error-diskon',
      'errorBerat':'#error-berat',
      'errorDeskripsi':'#error-deskripsi',
      'errorFoto':'#error-foto',
      'errorFoto2':'#error-foto2',
      'errorFoto3':'#error-foto3',
      'errorFoto4':'#error-foto4',
      'errorBrand':'#error-brand',
      'errorTag':'#error-tag',
      'errorDeskripsiSingkat':'#error-deskripsi-singkat',
    };
    return {
      getDOM:function(){
        return DOMString;
      },
      bersihError:function(dom){
          $(dom).text("");
      },
      tampilFoto:function(dom,url){
        $(dom).attr('src',url);
      },
      formatRupiah:function(angka){
        return parseFloat(angka).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace(/\,/g,'.').slice(0, -3);
      }
    }
  })();

  var Controller = (function (uiCtr){
    var base_url = "<?=base_url()?>";
    var dom;
    var table;
    var setupEventListener = function(){
      dom = uiCtr.getDOM();
      $('.select2').select2()
      $(dom.variant).on('change',function(){
        var value = $(this).val();
        if(value.includes('1')){
          $(this).find('[value="3"]').remove();
        }
        else if(value.includes('3')){
          $(this).find('[value="1"]').remove();
        }
        else{
          if(($(this).find('[value="3"]').val()==3)==false){
            $(dom.variant).append($('<option>', {
                value: 3,
                text: 'Size Angka'
            }));
          }
          if(!$(this).find('[value="1"]').val()==1){
            $(dom.variant).append($('<option>', {
                value: 1,
                text: 'Size'
            }));
          }
        } 
      });

      $(dom.nama).on('change',function(){
        uiCtr.bersihError(dom.errorNama);
      });
      
      $(dom.harga).on('change',function(){
        uiCtr.bersihError(dom.errorHarga);
        getTotal();
      });

      $(dom.berat).on('change',function(){
        uiCtr.bersihError(dom.errorBerat);
      });

      $(dom.diskon).on('change',function(){
        uiCtr.bersihError(dom.errorDiskon);
        getTotal();
      });

      $(dom.brand).on('change',function(){
        uiCtr.bersihError(dom.errorBrand);
      });

      $(dom.deskripsiSingkat).on('change',function(){
        uiCtr.bersihError(dom.errorDeskripsiSingkat);
      });

      $(dom.tag).on('change',function(){
        uiCtr.bersihError(dom.errorTag);
      });

      $(dom.foto).on('change',function(){
        tampilGambar(this,dom.show1);
        uiCtr.bersihError(dom.errorFoto);
      });

      $(dom.foto2).on('change',function(){
        tampilGambar(this,dom.show2);
        uiCtr.bersihError(dom.errorFoto2);
      });

      $(dom.foto3).on('change',function(){
        tampilGambar(this,dom.show3);
        uiCtr.bersihError(dom.errorFoto3);
      });

      $(dom.foto4).on('change',function(){
        tampilGambar(this,dom.show4);
        uiCtr.bersihError(dom.errorFoto4);
      });

    }
    function tampilGambar(input,dom) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $(dom)
                  .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function getTotal(){
      var harga = $(dom.harga).val().replace('.','');
      var diskon = $(dom.diskon).val();
      var total = harga - (harga * (diskon / 100));
      $(dom.total).val(uiCtr.formatRupiah(total)); 
    }
    return {
        init:function(){
          setupEventListener();
        }
      }
  })(UIController);
  Controller.init();
</script>
