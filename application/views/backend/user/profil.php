 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=$judul?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?=$judul?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=base_url('foto_user/').$user['foto']?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$user['nama']?></h3>

                <p class="text-muted text-center"><?=$user['jenis']?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email</b> <a><br><?=$user['email']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>No Telpon</b> <a><br><?=$user['notelpon']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Terdaftar</b> <a><br><?=tglIndo($user['tgl_daftar'])?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Alamat</b> <a><br><?=$user['alamat']?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="row">
                <div class="card col-md-12">
                <?= $this->session->flashdata('pesan')?>
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item">Dasar</li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <form class="form-horizontal" action="<?=base_url('admin/Akun/updateProfile')?>" method="POST" enctype="multipart/form-data">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                              <input type="text" name ="nama" class="form-control" id="inputName" placeholder="Name" value="<?=$user['nama']?>">
                              <?= form_error('nama','<small class="text-danger pl-3">','</small>');?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Nomor Telpon</label>
                            <div class="col-sm-10">
                              <input type="text" name="notelpon" class="form-control" id="inputEmail" placeholder="Nomor Telpon" value="<?=$user['notelpon']?>">
                              <?= form_error('notelpon','<small class="text-danger pl-3">','</small>');?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                            <?php 
                                $text = array(
                                    'name'        => 'alamat',
                                    'id'          => 'inputAlamat',
                                    'value'       =>  $user['alamat'],
                                    'rows'        => '5',
                                    'cols'        => '30',
                                    'class'       => 'form-control', 
                                );
                                echo form_textarea($text);
                            ?>
                            <?= form_error('alamat','<small class="text-danger pl-3">','</small>');?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                              <input type="radio" name="jekel" id="jekel" class="mt-3" checked value="L">Laki-Laki
                              <input type="radio" name="jekel" id="jekel" class="mt-3 ml-2" value="P">Perempuan
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                                <img id="show" src="<?=base_url('foto_user/').$user['foto']?>" alt="your image" class="mb-2" width="80" height="100"/><br>
                                <input type="file" name="foto" id="foto">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                          </div>
                        </form>
                  </div><!-- /.card-body -->
                </div>
            </div>
            <div class="row">
                <div class="card col-md-12">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item">Password</li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <form class="form-horizontal" method="POST" action="<?=base_url('admin/Akun/gantiPassword')?>">
                          <div class="form-group row">
                            <label for="oldpassword" class="col-sm-2 col-form-label">Password Lama</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="oldpassword" placeholder="Password lama" name="oldpassword">
                              <?= form_error('oldpassword','<small class="text-danger pl-3">','</small>');?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="newpassword" class="col-sm-2 col-form-label">Password Baru</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="newpassword" placeholder="Password baru" name="newpassword">
                              <?= form_error('newpassword','<small class="text-danger pl-3">','</small>');?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="repassword" class="col-sm-2 col-form-label">Re Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="repassword" placeholder="Re Password" name="repassword">
                              <?= form_error('repassword','<small class="text-danger pl-3">','</small>');?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                          </div>
                        </form>
                  </div><!-- /.card-body -->
                </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>

var UIController = (function (){
      var DOMString = {
        'foto':"#foto",
        'show':'#show',
      };
      return {
        getDOM:function(){
          return DOMString;
        },
        tampilFoto:function(dom,url){
          $(dom).attr('src',url);
        }
      }
    })();

    var Controller = (function (uiCtr){
      var base_url = "<?=base_url()?>";
      var dom;
      var setupEventListener = function(){
        dom = uiCtr.getDOM();

        $(dom.foto).on('change',function(){
          tampilGambar(this,dom.show);
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
      
      return {
          init:function(){
            setupEventListener();
          }
        }
    })(UIController);
    Controller.init();
  </script>    