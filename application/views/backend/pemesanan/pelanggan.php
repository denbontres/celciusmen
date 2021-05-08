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
    <section class="content">
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
            <?php foreach($user as $r):?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                            <h2 class="lead"><b><?=$r['nama']?></b></h2>
                        </div>
                        <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-9">
                            <ul class="ml-2 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : <?=$r['notelpon']?></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: <?=$r['email']?></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar"></i></span> Terdaftar: <?=tglIndo($r['tgl_daftar'])?></li>
                            </ul>
                            </div>
                            <div class="col-3 text-center">
                            <img src="<?=base_url('asset/backend/')?>dist/img/user2-160x160.jpg"  class="img-circle img-fluid">
                            </div>
                        </div>
                        </div>
                        <div class="card-footer">
                        <div class="text-right">
                            <a href="<?=base_url('admin/Pemesanan/Pemesanan?email=').$r['email']?>" class="btn btn-sm btn-info">
                            <i class="fas fa-book mr-1"></i> History Pemesanan
                            </a>
                        </div>
                        </div>
                    </div>
            </div>
            <?php endforeach;?>   
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <?php echo $this->pagination->create_links();?>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    </div>