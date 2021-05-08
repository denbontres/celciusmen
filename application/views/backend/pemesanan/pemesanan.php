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
              <table id="tabel" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Faktur</th>
                  <th>Tanggal</th>
                  <th>Email</th>
                  <th>Total</th>
                  <th>Status</th>
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

  <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal_update_title">Edit <?=$judul?></h4>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="form">
                <div class="form-group">
                  Status
                  <select name="status" id="status" class="form-control">
                    <option value="1">Menunggu Pembayaran</option>
                    <option value="2">Menunggu Konfirmasi</option>
                    <option value="3">Packing</option>
                    <option value="4">Pengiriman</option>
                    <option value="5">Selesai</option>
                  </select>
                  <input type="text" class="form-control" name="id" id="id" style="display:none">
                  <small class="text-danger" id="error-status"></small>
                </div>
                <div class="form-group">
                  <span style="display:none" id="txtkurir">Resi</span>
                  <input type="text" class="form-control" style="display:none" id="kurir" name="kurir">
                  <small class="text-danger" id="error-resi"></small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="save">Save</button>
            </div>
            </form>
          </div>
    </div>
  </div>
  <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
  <script>
    var UIController = (function (){
      var DOMString = {
        'id':'#id',
        'data':'#data',
        'btnEdit':'#btn-edit',
        'status':'#status',
        'kurir':'#kurir',
        'errorresi':'#error-resi',
        'txtkurir':'#txtkurir',
        'btnCloseModal':'#close',
        'modal' :'.modal',
        'save':'#save'
      };
      return {
        getDOM:function(){
          return DOMString;
        },
        tampilError:function(dom,tek){
            $(dom).text(tek);
        },
        bersihError:function(dom){
            $(dom).text("");
        },
        bersihKolom:function(dom){
            $(dom).val("");
        },
        isiKolom:function(dom,text){
          $(dom).val(text);
        },
        closeModal:function(dom){
            $(dom + " "+DOMString.btnCloseModal).click();
        },
        tampilToast:function(){
          toastr.info(' Data berhasil diubah');
        }
      }
    })();

    var Controller = (function (uiCtr){
      var base_url = "<?=base_url()?>";
      var dom;
      var table;
      var setupEventListener = function(){
        dom = uiCtr.getDOM();
        tampilTabel();

        $(dom.data).on('click',dom.btnEdit,function(){
          const id = $(this).data('id');
          const status = $(this).data('status');
          uiCtr.isiKolom(dom.status,status);
          uiCtr.isiKolom(dom.id,id);
          if(status == 3){
            $(dom.txtkurir).show();
            $(dom.kurir).show();
            ambilResi(id);
          }
          editModal();
        });

        $(dom.modal +" "+ dom.btnCloseModal).on('click',function(){
          bersihAllError();
          bersihAllKolom();
        });
        
        $(dom.kurir).on('change',function(){
          uiCtr.bersihError(dom.errorresi);
        });

        $(dom.status).on('change',function(){
          if($(this).val() == 3){
            $(dom.txtkurir).show();
            $(dom.kurir).show();
          }else{
            $(dom.txtkurir).hide();
            $(dom.kurir).hide();
          }
        });

        $(dom.save).on('click',function(){
          edit();
        });
      }
      function bersihAllKolom(){
        uiCtr.bersihKolom(dom.kurir);
        uiCtr.bersihKolom(dom.id);
        $(dom.status).val($(dom.status +" option:first").val());
        $(dom.txtkurir).hide();
        $(dom.kurir).hide();
      }

      function bersihAllError(){
        uiCtr.bersihError(dom.errorresi);
      }
      
      function edit(){
        var form_data = new FormData($('#form')[0]);
        $.ajax({
          type:'POST',
          data:form_data,
          url:base_url+"admin/Pemesanan/updatePemesanan",
          processData: false,
          contentType: false,
          dataType:"JSON",
          success:function(data){
            console.log(data);
            if(data.pesan == "Berhasil"){
              uiCtr.tampilToast();
              reload_ajax();
              uiCtr.closeModal(dom.modal);
            }else if (data.pesan =="Gagal"){
              uiCtr.tampilError(dom.errorresi,data.errorResi);
            }
          }
        })
      }

      function reload_ajax(){
        $('#tabel').DataTable().ajax.reload()
      }

      function ambilResi(faktur){
        $.ajax({
          type:'POST',
          data:{faktur:faktur},
          url:base_url+"admin/Pemesanan/getResi",
          dataType:"JSON",
          success:function(data){
            uiCtr.isiKolom(dom.kurir,data.resikurir);
          }
        })
      }
      function editModal(){
        $(dom.modal).modal({backdrop: 'static', keyboard: false});
        
      };

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
              ajax: {"url": "<?php echo base_url().'admin/Pemesanan/getPemesanan'?>", "type": "POST"},
                columns: [                     
                  {
                    "data": "nofaktur",
                    "orderable": false,
                    "searchable": false
                  },
                  {"data":"nofaktur"},
                  {"data":"tanggal"},
                  {"data":"email"},
                  {"data":"total",render: $.fn.dataTable.render.number('.', ',', '')},
                  {"data":"keterangan"},
                  {"data": "view", "orderable": false, "searchable": false}
                  
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
    function say(tanggal){
      console.log(tanggal);
    }
  </script>    