  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$judul?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$jumlahorder?></h3>

                <p>Total order hari ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a  class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=number_format($pendapatan,'0',',','.')?></h3>

                <p>Penjualan hari ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a  class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=number_format($pelanggan,'0',',','.')?></h3>

                <p>Pelanggan</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a  class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=number_format(tampilCounter(),'0',',','.')?></h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a  class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Grafik Penjualan</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <canvas id="myChart" width="100rem"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <!-- USERS LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Latest Members</h3>
                <div class="card-tools">
                  <span class="badge badge-danger"><?=$jumUser?> Pelanggan Baru</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="users-list clearfix">
                  <?php foreach($user as $r): ?>
                    <li>
                      <img src="<?=$r['foto']?base_url('foto_user/').$r['foto']:base_url('foto_user/').'default.jpg'?>" alt="User Image" style="width: 62px;height:62px">
                      <a class="users-list-name" href="#"><?=$r['email']?></a>
                      <span class="users-list-date"><?=tglIndo($r['tgl_daftar'])?></span>
                    </li>
                  <?php endforeach;?>
                </ul>
              </div>
              <div class="card-footer text-center">
                <a href="<?=base_url('admin/Pemesanan/pelanggan')?>">Selengkapnya ...</a>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Pemesanan</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                      <tr>
                        <th>Faktur</th>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($detail as $r):?>
                        <tr>
                          <td><?=$r['nofaktur']?></td>
                          <td><?=$r['barang'].' '.$r['sku']?></td>
                          <td><?=getNameStatus($r['status'])?></td>
                          <td><?=$r['email']?></td>
                        </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="<?=base_url('admin/Pemesanan')?>" class="btn btn-sm btn-info float-right">Selengkapnya ...</a>
              </div>
              <!-- /.card-footer -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Produk Terbaru</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <?php foreach($barang as $r):?>
                    <li class="item">
                      <div class="product-img">
                        <img src="<?=base_url('resource/').$r['foto']?>" alt="Product Image" class="img-size-50">
                      </div>
                      <div class="product-info">
                        <a href="javascript:void(0)" class="product-title"><?=$r['nama']?>
                          <span class="badge badge-warning float-right"><?=number_format($r['harga'],'0',',','.')?></span></a>
                        <span class="product-description">
                          <?=$r['short_deskripsi']?>
                        </span>
                      </div>
                    </li>
                  <?php endforeach?>
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="<?=base_url('admin/Barang')?>" class="uppercase">Selangkapnya ...</a>
              </div>
              <!-- /.card-footer -->
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>
  </div>

<!-- ChartJS -->
<script src="<?=base_url('asset/backend/')?>plugins/chart.js/Chart.min.js"></script>
<script>
  var UIController = (function (){
    var DOMString = {
      'chart':'myChart'
    };
    return {
      getDOM:function(){
        return DOMString;
      },
      tampiChart:function(data,labels){
        var ctx = document.getElementById(DOMString.chart).getContext('2d');
        var myChart = new Chart(ctx,{
          type:'bar',
          data:{
            labels:labels,
            datasets : [{
              label:'Pendapatan',
              backgroundColor:'rgba(54, 162, 235, 0.2)',
              borderColor:'rgba(54, 162, 235, 1)',
              data:data
            }],
          },
          options:{
            scales:{
              yAxes:[{
                ticks:{
                  beginAtZero:true
                }
              }]
            }
          },
        });
      }
    }
  })();
  var Controller = (function (uiCtr){
      var dom;
      var setupEventListener = function(){
        isiChart();
        function isiChart(){
          $.ajax({
            url:"<?=base_url('admin/Dasboard/getPendapatan'); ?>",
            type:'post',
            dataType:'json',
            success:function(data){
              console.log(data);
              var pendapatan =[];
              var labels=[];
              for(var i=0;i<data.length;i++){
                labels[i]=getBulan(parseFloat(data[i].bulan));
                pendapatan[i] = data[i].total;
              }
              uiCtr.tampiChart(pendapatan,labels);
            }
          });
        }
      }
      function getBulan(bulan){
        var hasil = "";
        switch(bulan){
          case 1:
          hasil = "Januari";
          break;
          case 2:
          hasil="Februari";
          break;
          case 3:
          hasil = "Maret";
          break;
          case 4:
          hasil="April";
          break;
          case 5:
          hasil = "Mei";
          break;
          case 6:
          hasil="Juni";
          break;
          case 7:
          hasil = "Juli";
          break;
          case 8:
          hasil="Agustus";
          break;
          case 9:
          hasil = "September";
          break;
          case 10:
          hasil="Oktober";
          break;
          case 11:
          hasil = "November";
          break;
          case 12:
          hasil="Desember";
          break;
        }
        return hasil;
      } 
      return {
          init:function(){
            setupEventListener();
          }
        }
    })(UIController);
    Controller.init();
</script>