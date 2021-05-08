<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=$barang['nama']?></h1>
            <i><?=tglIndo($barang['tgl_post'])?></i>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?=$barang['nama']?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-3">
              <h3 class="d-inline-block d-sm-none"><?=$barang['nama']?></h3>
             
              <div class="col-12">
                <img src="<?=base_url('foto_produk/').$barang['foto']?>" class="product-image" style="width: 18rem" alt="Product Image">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <b><?=$barang['nama']?></b><br>

                <table>
                  <tr>
                    <td>Kategori</td>
                    <td>&nbsp;: &nbsp;</td>
                    <td><?=$barang['jenis']?></td>
                  </tr>
                  <tr>
                    <td>Jumlah</td>
                    <td>&nbsp;: &nbsp;</td>
                    <td><?=$barang['jumlah']?></td>
                  </tr>
                  <tr>
                    <td>Jumlah Terjual</td>
                    <td>&nbsp;: &nbsp;</td>
                    <td><?=$barang['jumlah_terjual']?></td>
                  </tr>
                  <tr>
                    <td>Harga</td>
                    <td>&nbsp;: &nbsp;</td>
                    <td>Rp. <?=number_format($barang['harga'],'0',',','.')?></td>
                  </tr>
                  <tr>
                    <td>Diskon</td>
                    <td>&nbsp;: &nbsp;</td>
                    <td><?=$barang['diskon']."%"?></td>
                  </tr>
                  <tr>
                    <td>Harga Sekarang</td>
                    <td>&nbsp;: &nbsp;</td>
                    <td>Rp. <?=number_format($barang['total_harga'],'0',',','.')?></td>
                  </tr>
                </table>
                <b>Foto</b><br>
                <?php if($barang['foto2']!=""){?>
                  <img src="<?=base_url('foto_produk/').$barang['foto2']?>" style="width: 5rem"> 
                <?php }?>
                <?php if($barang['foto3']!=""){?>
                  <img src="<?=base_url('foto_produk/').$barang['foto3']?>" style="width: 5rem"> 
                <?php }?>
                <?php if($barang['foto4']!=""){?>
                  <img src="<?=base_url('foto_produk/').$barang['foto4']?>" style="width: 5rem"> 
                <?php }?> 
              <br>
              <b>Deskripsi</b>
              <p><?=$barang['deskripsi']?></p>
              <a href="<?=base_url('admin/Barang')?>" class="btn btn-warning" ><i class="fas fa-arrow-left"> </i> Kembali</a>             
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->