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
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Akses</th>
                    </tr>
                </thead>
                <tbody id="isi">
                  <?php
                   $i=1;
                   foreach($menu as $r):?>
                    <tr>
                      <td><?=$i++?></td>
                      <td><?=$r['nama']?></td>
                      <td><input type="checkbox" class="form-check-input" <?=set_access($id_jenis_user,$r['id']);?>
                        data-idjenis="<?=$id_jenis_user?>" data-idmenu="<?=$r['id'] ?>"
                      ></td>
                   </tr>  
                  <?php endforeach;?>
                </tbody>
            </table>
            <a href="<?=base_url('admin/User/JenisUser')?>" class="btn btn-warning"><i class="fas fa-arrow-left"> </i> Kembali</a>
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
  $('.form-check-input').on('click',function(){
    const idjenis = $(this).data('idjenis');
    const idmenu = $(this).data('idmenu');
    $.ajax({
      url:"<?=base_url('admin/User/gantiAkses'); ?>",
      type:'post',
      data:{
        idmenu:idmenu,
        idjenis:idjenis
      },
      success:function(){
        document.location.href="<?=base_url('admin/User/RoleAkses/')?>"+idjenis;
      }
    });
  });
</script>