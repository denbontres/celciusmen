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
              <form id="form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            Tanggal
                            <input type="date" class="form-control" id="tanggal" value="<?=$this->input->get('tanggal')?$this->input->get('tanggal'):'';?>">
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
                  <th>No Faktur</th>
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
        'tanggal':'#tanggal',
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
        $tanggal = $this->input->get('tanggal');
        if($tanggal){ ?>
          var tanggal = '<?=$tanggal?>';
          tampilTabel(tanggal);
          getTotal(tanggal);
        <?php  }
      ?>

      var setupEventListener = function(){
        dom = uiCtr.getDOM();
        $(dom.filter).on('click',function(){
          var jumlahBaris = $('#tabel').find('tr').length;
          if(jumlahBaris > 1){
            bersihTabel();
          }
          var tanggal = $('#tanggal').val();
          tampilTabel(tanggal);
          getTotal(tanggal);
        })

        $(dom.cetak).on('click',function(){
          var tanggal = $('#tanggal').val();
          url = base_url + 'admin/Laporan/cetakLaporanHarian/'+tanggal;
          window.open(url, '_blank'); 
        });
      }
      
      function bersihTabel(){
        table.fnClearTable();
        table.fnDraw();
        table.fnDestroy();
      }

      function getTotal(tanggal){
        $.ajax({
          type:'POST',
          data:{tanggal},
          url:base_url+"admin/Laporan/getTotalByHarian",
          success:function(data){
            uiCtr.setValue(dom.total,data);
          }
        })
      }

      function tampilTabel(tanggal){
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
              ajax: {"url": "<?php echo base_url().'admin/Laporan/getLaporanByHarian'?>", "type": "POST","data":{'tanggal':tanggal},'dataType':'json',
          },
                columns: [                     
                  {
                    "data": "nofaktur",
                    "orderable": false,
                    "searchable": false
                  },
                  {"data":"nofaktur"},
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