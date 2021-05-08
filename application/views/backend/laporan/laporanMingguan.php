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
              <h2 class="card-title">Data <?=$judul?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form id="form">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            Minggu
                            <select name="minggu" id="minggu" class="form-control">
                                <?php for($i=1;$i<=5;$i++){?>
                                    <option value="<?=$i?>" <?=$this->input->get('minggu')==$i?'selected':''?>><?=$i?></option>
                                <?php }?>    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            Bulan
                            <select name="bulan" id="bulan" class="form-control">
                                <?php for($i=1;$i<=12;$i++){?>
                                    <option value="<?=$i?>" <?=$this->input->get('bulan')==$i?'selected':''?>><?=$i?></option>
                                <?php }?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            Tahun
                            <select name="tahun" id="tahun" class="form-control">
                                <?php for($i=2020;$i<=2070;$i++){?>
                                    <option value="<?=$i?>" <?=$this->input->get('tahun')==$i?'selected':''?>><?=$i?></option>
                                <?php }?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            Total
                            <input type="text" name="total" id="total" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-group">
                            <input class="btn btn-primary btn-md btn-block" value="Filter" id="filter"type="button">
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-group">
                            <input class="btn btn-success btn-md btn-block" value="Cetak" id="cetak"type="button">
                        </div>
                    </div>
                </div>
              </form>
              <table id="tabel" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="data">
                </tbody>
              </table>
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

    var UIController = (function (){
      var DOMString = {
        'data':'#data',
        'filter':'#filter',
        'cetak':'#cetak',
        'total':'#total'
      };
      return {
        getDOM:function(){
          return DOMString;
        },
        setValue:function(dom,value){
          $(dom).val(value);
        }
      }
    })();

    var Controller = (function (uiCtr){
      var base_url = "<?=base_url()?>";
      var dom;
      var table;

      <?php 
        $minggu = $this->input->get('minggu');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        if($bulan && $tahun && $minggu){ ?>
          var minggu = '<?=$minggu?>';
          var bulan = '<?=$bulan?>';
          var tahun = '<?=$tahun?>';
          tampilTabel(minggu,bulan,tahun);
          getTotal(minggu,bulan,tahun);
        <?php  }
      ?>
      
      var setupEventListener = function(){
        dom = uiCtr.getDOM();
        
        $(dom.filter).on('click',function(){
          var jumlahBaris = $('#tabel').find('tr').length;
          if(jumlahBaris > 1){
            bersihTabel();
          }
          var minggu = $('#minggu').val();
          var bulan = $('#bulan').val();
          var tahun = $('#tahun').val();
          tampilTabel(minggu,bulan,tahun);
          getTotal(minggu,bulan,tahun);

        })

        $(dom.cetak).on('click',function(){
          var minggu = $('#minggu').val();
          var bulan = $('#bulan').val();
          var tahun = $('#tahun').val();
          url = base_url + 'admin/Laporan/cetakLaporanMingguan/'+minggu+'/'+bulan+'/'+tahun;
          window.open(url, '_blank'); 
        });

      }
      function getTotal(minggu,bulan,tahun){
        $.ajax({
          type:'POST',
          data:{minggu,bulan,tahun},
          url:base_url+"admin/Laporan/getTotalMingguan",
          success:function(data){
            uiCtr.setValue(dom.total,data);
          }
        })
      }

      function bersihTabel(){
        table.fnClearTable();
        table.fnDraw();
        table.fnDestroy();
      }
      
      function tampilTabel(minggu,bulan,tahun){
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
          return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
        };
        
        table = $("#tabel").dataTable({
            
          initComplete: function() {
              var api = this.api();
              $('#tabel input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url().'admin/Laporan/getLaporanMingguan'?>", "type": "POST","data":{'minggu':minggu,'bulan':bulan,'tahun':tahun},'dataType':'json',

            },
                columns: [                     
                  {
                    "data": "nofaktur",
                    "orderable": false,
                    "searchable": false
                  },
                  {"data":"tanggal"},
                  {"data": "total",render: $.fn.dataTable.render.number('.', ',', '')},
                  {"data": "view","orderable": false,"searchable": false}         
                ],
                order: [[1, 'asc']],
                rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1)
                $('td:eq(0)', row).html(index);
          }
 
        });
      }
      
      return {
          init:function(){
            setupEventListener();
          }
        }
    })(UIController);
    Controller.init();
  </script>    