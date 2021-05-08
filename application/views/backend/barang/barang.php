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
              <a href="<?=base_url('admin/Barang/insertBarang')?>" class="btn btn-info mb-2"><i class="fas fa-plus mr-2"></i><?=$judul?></a>
              <table id="tabel" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th style="width: 30%;">Nama</th>
                  <th>Jenis</th>
                  <th>Kategori</th>
                  <th>Diskon</th>
                  <th>Harga</th>
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

  <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
  <?=$this->session->flashdata('pesan')?$this->session->flashdata('pesan'):''?>
  <script>
    var Controller = (function (){
      $('#tabel').on('click','.delete',function(e){
        e.preventDefault();
        var nama = $(this).data('nama');
          Swal.fire({
              title: 'Apa Anda Yakin?',
              text: "Anda mengahapus data "+nama,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Iya, Hapus',
              cancelButtonText: 'Batal'
          }).then((result) => {
              if (result.value) {
                var id = $(this).data('id');
                window.location = "<?=base_url('admin/Barang/deleteBarang/')?>"+id;
              }
          });
      });
      var base_url = "<?=base_url()?>";
      var table;
      var setupEventListener = function(){
        tampilTabel();
      }

      function tampilTabel(){
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
              ajax: {"url": "<?php echo base_url().'admin/Barang/getBarang'?>", "type": "POST"},
                columns: [                     
                  {
                    "data": "id",
                    "orderable": false,
                    "searchable": false
                  },
                  {"data":"nama"},
                  {"data":"jenis"},
                  {"data": "kategori"},
                  {"data": "diskon"},
                  {"data": "total_harga"},
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
    })();
    Controller.init();
  </script>    