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
    <?= $this->session->flashdata('pesan')?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Informasi Dasar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="<?=base_url('admin/UserInterface')?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Nama Toko
                            <input type="text" class="form-control" value="<?=$basic[0]['nama_toko']?>" name="nama" id="nama">
                            <?= form_error('nama','<small class="text-danger pl-3" id="errornama">','</small>');?>
                        </div>
                        <div class="form-group">
                            Provinsi
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" value="<?=$provinsi?>" id="txtprovinsi"class="form-control" disabled>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:;" class="btn btn-block btn-outline-primary edit"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                            <select name="provinsi" class="form-control provinsi" style="display: none;">
                                <option value="">--Provinsi--</option>
                                <?php foreach($rajaongkir as $r):?>
                                    <option value="<?=$r['id_provinsi']?>"><?=$r['nama_provinsi']?></option>
                                <?php endforeach;?>    
                            </select>
                            <?= form_error('provinsi','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Kota
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" value="<?=$kota?>" class="form-control" id="txtkota" disabled>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:;" class="btn btn-block btn-outline-primary edit"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                            <select rel="calc_shipping_state" class="kota form-control" name="kota" style="display: none;">
                                <option value="" >--Kota / Kabupaten--</option>
                            </select>
                            <?= form_error('kota','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Alamat
                            <input type="text" class="form-control" value="<?=$basic[0]['alamat']?>" name="alamat">
                            <?= form_error('alamat','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Notelpon
                            <input type="text" class="form-control" value="<?=$basic[0]['notelp']?>" name="notelpon">
                            <?= form_error('notelpon','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Logo<br>
                            <?php
                                if($basic[0]['logo']!=""){
                                    $foto = $basic[0]['logo'];
                                }else{
                                    $foto = "blank.jpg";
                                } 
                            ?>    
                            <img id="show" src="<?=base_url('resource/').$foto?>" alt="your image" class="mb-2" width="80" height="100"/><br>
                            <input type="file" name="foto" id="foto"><br>
                            <?= form_error('foto','<small class="text-danger pl-3" id="error-foto">','</small>');?>
                        </div>
                        <div class="form-group">
                            Key API Raja Ongkir
                            <input type="text" class="form-control" value="<?=$basic[0]['rajaongkir']?>" name="rajaongkir">
                            <?= form_error('rajaongkir','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Mindtrans Key
                            <input type="text" class="form-control" value="<?=$basic[0]['midtrans']?>" name="midtrans">
                            <?= form_error('midtrans','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            URL MIDTRANS
                            <input type="text" class="form-control" value="<?=$basic[0]['midtrans_url']?>" name="url" id="url">
                            <?= form_error('url','<small class="text-danger pl-3" id="errorurl">','</small>');?>
                        </div>
                        <div class="form-group">
                            PRODUCTION / SANDBOX
                            <select name="sandbox" id="sandbox" class="form-control">
                                <option value="0" <?=$basic[0]['sandbox']=="0"?'selected':''?>>Sandbox</option>
                                <option value="1" <?=$basic[0]['sandbox']=="1"?'selected':''?>>Production</option>
                            </select>
                        </div>
                        <div class="form-group">
                            Map
                            <?php 
                                $text = array(
                                    'name'        => 'map',
                                    'id'          => 'map',
                                    'value'       => $basic[0]['map'],
                                    'rows'        => '9',
                                    'cols'        => '30',
                                    'class'       => 'form-control', 
                                );
                                echo form_textarea($text);
                            ?>
                           <?= form_error('map','<small class="text-danger pl-3">','</small>');?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Deskripsi
                            <?php 
                                $text = array(
                                    'name'        => 'deskripsi',
                                    'id'          => 'deskripsi',
                                    'value'       => $basic[0]['deskripsi'],
                                    'rows'        => '9',
                                    'cols'        => '30',
                                    'class'       => 'form-control', 
                                );
                                echo form_textarea($text);
                            ?>
                           <?= form_error('deskripsi','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Facebook
                            <input type="text" class="form-control" value="<?=$basic[0]['facebook']?>" name="facebook">
                        </div>
                        <div class="form-group">
                            Twitter
                            <input type="text" class="form-control" value="<?=$basic[0]['twitter']?>" name="twitter">
                        </div>
                        <div class="form-group">
                            Linkin
                            <input type="text" class="form-control" value="<?=$basic[0]['linkin']?>" name="linkin">
                        </div>
                        <div class="form-group">
                            Youtube
                            <input type="text" class="form-control" value="<?=$basic[0]['youtube']?>" name="youtube">
                        </div>
                       <div class="form-group">
                            Email
                            <input type="email" class="form-control" value="<?=$basic[0]['email']?>" name="email">
                            <?= form_error('email','<small class="text-danger pl-3">','</small>');?>
                        </div>
                        <div class="form-group">
                            Logo Footer<br>
                            <?php
                                if($basic[0]['logo']!=""){
                                    $foto = $basic[0]['footer_logo'];
                                }else{
                                    $foto = "blank.jpg";
                                } 
                            ?>    
                            <img id="show2" src="<?=base_url('resource/').$foto?>" alt="your image" class="mb-2" width="80" height="100"/><br>
                            <input type="file" name="foto2" id="foto2"><br>
                            <?= form_error('foto2','<small class="text-danger pl-3" id="error-foto2">','</small>');?>
                        </div>
                        <small><i>Foto harus berformat JPG dan PNG, Dengan ukuran dibawah 1 MB</i></small>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?=base_url('admin/UserInterface')?>" class="btn btn-danger ml-2">Batal</a>
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
  <script>
        var base_url = "<?=base_url()?>";
        var UIController = (function (){
            var DOMString = {
                'cmbprovinsi':'.provinsi',
                'cmbkota':'.kota',
                'kota':'#txtkota',
                'provinsi':'#txtprovinsi',
                'foto':"#foto",
                'show':'#show',
                'errorFoto':'#error-foto',
                'errorFoto2':'#error-foto2',
                'foto2':"#foto2",
                'show2':'#show2',
                'edit':'.edit'
            };
            return {
                getDOM:function(){
                    return DOMString;
                },
                bersihError:function(dom){
                    $(dom).text("");
                },
                tampilKota:function(data){
                    var html;
            
                    if(data.length==0){
                        html +='<option value="">--Kota/Kabupaten--</option>';
                    }else{
                        var kota = parseFloat(<?=$basic[0]['kota']?>);
                        for(var i=0;i<data.length;i++){
                            html +='<option value="'+data[i].id_kota+'" '+' >'+data[i].nama_kota+'</option>';
                        }
                    }
                $(DOMString.cmbkota).html(html);
                },

                tampilFoto:function(dom,url){
                    $(dom).attr('src',url);
                }
            }
        })();

        var Controller = (function (uiCtr){
            var setupEventListener = function(){
                dom = uiCtr.getDOM();
                $(dom.cmbprovinsi).on('change',function(){
                    var id = $(this).find(":selected").val();
                    if(id!=""){
                        getKota(id);
                    }else{

                    }
                });
                
                $(dom.foto).on('change',function(){
                    tampilGambar(this,dom.show1);
                    uiCtr.bersihError(dom.errorFoto);
                });

                $(dom.foto2).on('change',function(){
                    tampilGambar(this,dom.show2);
                    uiCtr.bersihError(dom.errorFoto2);
                });

                $(dom.edit).on('click',function(){
                    $(dom.cmbprovinsi).show();
                    $(dom.cmbkota).show();
                    $(dom.provinsi).hide();
                    $(dom.kota).hide();
                    $(dom.edit).hide();
                });
            }

            function getKota(idprovinsi){
                $.ajax({
                    url:base_url+'admin/UserInterface/getKota',
                    data:{id:idprovinsi},
                    type:'post',
                    dataType:'JSON',
                    success:function(data){
                        var newData = hapusDuplicateKota(data);
                        uiCtr.tampilKota(newData);
                    }
                });
            }

            function hapusDuplicateKota(data){
                var namaKota = Object.values(data.reduce((acc,cur)=>Object.assign(acc,{[cur.nama_kota]:cur}),{}));
                var idKota = Object.values(namaKota.reduce((acc,cur)=>Object.assign(acc,{[cur.id_kota]:cur}),{}));
                return idKota;
            }
            
            function tampilGambar(input,dom) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(dom).attr('src', e.target.result)
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            return {
                init:function(){
                setupEventListener();
            }
        }

        })(UIController);
        Controller.init();
  </script>