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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <img src="<?=base_url('asset/backend/')?>dist/img/logoadmin.png" style="width: 8rem">
                    <small class="float-right"><?=tglIndo($pemesanan['tanggal'])?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong><?=$basic['nama_toko']?></strong><br>
                    <?=$basic['alamat'].', '.getKotaProvinsi('kota',$basic['kota'])?> <br>
                    Phone: <?=$basic['notelp']?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?=$user['nama']?></strong><br>
                    <?=$pemesanan['alamat'].', '.getKotaProvinsi('kota',$pemesanan['kota'])?>
                    <br>
                    Phone : <?=$user['notelpon']?><br>
                    Email: <?=$pemesanan['email']?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Faktur : </b><?=$pemesanan['nofaktur']?>
                  <br>
                  <?php 
                    $date = new DateTime($pemesanan['tanggal']);
                    $date->modify('+2 day');
                  ?>
                  <b>Jatuh Tempo:</b> <?=tglIndo($date->format('Y-m-d')) ?><br>
                  <b>Status :</b> <?php 
                  $status =getNameStatus($pemesanan['status']);
                  echo $status;
                ?>
                  <?php if($bukti){?>
                    <br>
                    <b>Bukti Pembayaran :</b>
                    <button class="btn btn-info" style="border-radius: 50%;" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i></button>
                  <?php }?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Barang</th>
                      <th>Jumlah</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach($detail as $r):?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=$r->nama?></td>
                                <td><?=$r->jumlah?></td>
                                <td><?=number_format($r->subtotal,'0',',','.')?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  
                </div>
                <!-- /.col -->
                <div class="col-6">

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><?=number_format($pembayaran['subtotal'],'0',',','.')?></td>
                      </tr>
                      <tr>
                        <th>Ongkir</th>
                        <td><?=number_format($pemesanan['ongkir'],'0',',','.')?></td>
                      </tr>
                      <tr>
                        <th>Discount</th>
                        <td><?=number_format($pemesanan['discount'],'0',',','.')?></td>
                      </tr>
                      <tr>
                        <th>Total</th>
                        <td><?=number_format(($pemesanan['total']+$pemesanan['ongkir']-$pemesanan['discount']),'0',',','.')?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?=base_url('admin/Pemesanan')?>" class="btn btn-warning"> <i class="fas fa-arrow-left"> </i> Kembali </a>
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php if($bukti){?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table>
              <tr>
                <td>Nomor Rekening</td>
                <td>:</td>
                <td><?=$bukti['rekening']?></td>
              </tr>
              <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?=number_format($bukti['jumlah'],'0',',','.')?></td>
              </tr>
              <tr>
                <td>Bukti</td>
                <td>:</td>
                <td><img src="<?=base_url('resource/'.$bukti['bukti'])?>" style="width: 30rem;"/></td>
              </tr>
              <tr>
                <td>Waktu</td>
                <td>:</td>
                <td><?=tglIndowithJam($bukti['waktu'])?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  <?php }?>