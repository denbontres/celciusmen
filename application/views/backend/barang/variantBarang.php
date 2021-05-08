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
              <h3 class="card-title">Pilih Variant</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?=base_url('admin/Barang/tambahVariant/'.$id_barang)?>" method="POST">
                    <?php $i=0;foreach($variantSelect as $r):?>
                        <div class="form-group">
                            <b><?=$r['nama']?></b><br>
                            <?php foreach($variant[$i] as $s):?>
                                <input type="checkbox" name="variant-<?=$i?>[]" value="<?=$s['id']?>" <?php foreach($select[$i] as $x){if($s['id']==$x['id_variant']){echo "checked";}}?> class="mr-2"><span class="mr-3"><?=$s['nama']?></span>
                            <?php endforeach;?>
                        </div>
                    <?php $i++;endforeach;?>
                    <input type="submit" value="Selanjutnya" class="btn btn-primary">
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