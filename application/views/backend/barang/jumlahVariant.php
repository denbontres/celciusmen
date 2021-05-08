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
              <h3 class="card-title">Jumlah Barang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?=base_url('admin/Barang/tambahVariant/'.$idBarang)?>" method="POST">
                    <?php $i=1; foreach($sku as $r):?>
                        <div class="form-group">
                            <label>Jumlah <?=$r['nama']?></label>
                            <input type="number" name="jumlah-<?=$i?>" value="<?=$r['jumlah_di_database']?>" class="form-control">
                            <?= form_error('jumlah-'.$i++,'<small class="text-danger pl-3">','</small>');?>
                        </div>
                    <?php endforeach;?>    
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