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
              <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#modal-default"  data-backdrop="static" data-keyboard="false" id="btn-tambah"><i class="fas fa-plus mr-2"></i><?=$judul?></button>
              <table id="tabel" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Submenu</th>
                  <th>Menu</th>
                  <th>URL</th>
                  <th>Icon</th>
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
              <h4 class="modal-title" id="modal_add_title">Tambah <?=$judul?></h4>
              <h4 class="modal-title" id="modal_update_title">Edit <?=$judul?></h4>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="form">
                <div class="form-group">
                  Submenu
                  <input type="text" class="form-control" name="submenu" id="submenu">
                  <input type="text" class="form-control" name="id" id="id" style="display:none">
                  <small class="text-danger" id="error-submenu"></small>
                </div>
                <div class="form-group">
                  Menu
                  <select class="form-control" name="menu" id="menu">
                  <?php foreach ($menu as $r):?>
                    <option value="<?=$r['id']?>"><?=$r['nama']?></option>    
                  <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                  URL
                  <input type="text" class="form-control" name="url" id="url">
                  <small class="text-danger" id="error-URL"></small>
                </div>
                <div class="form-group">
                  Icon
                  <input type="text" class="form-control" name="icon" id="icon">
                  <small class="text-danger" id="error-icon"></small>
                </div>
                <div class="form-group">
                  Status
                  <select class="form-control" name="status" id="status">
                    <option value="1">Aktif</option> 
                    <option value="0">Tidak Aktif</option> 
                  </select>
                  <small class="text-danger" id="error-nama"></small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="save">Save</button>
              <button type="button" class="btn btn-primary" id="edit">Update</button>
            </div>
            </form>
          </div>
    </div>
  </div>
  <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
  <script>
    var UIController = (function (){
      var DOMString = {
        'submenu':'#submenu',
        'menu':'#menu',
        'url':'#url',
        'icon':'#icon',
        'status':'#status',
        'id':'#id',
        'save':'#save',
        'edit':'#edit',
        'errorSubmenu':'#error-submenu',
        'errorIcon':'#error-icon',
        'errorUrl':'#error-URL',
        'btnCloseModal':'#close',
        'modal' : '.modal',
        'data':'#data',
        'btnDelete':'#btn-delete',
        'btnEdit':'#btn-edit',
        'btnTambah':'#btn-tambah',
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
        tampilToast:function(tipe,nama){
          if(tipe=="insert"){
            toastr.success(nama+' berhasil ditambahkan');
          }else if(tipe=="edit"){
            toastr.info(' Data berhasil diubah');
          }else if(tipe=="delete"){
            toastr.error('Data berhasil dihapus');
          }
        },
        ambilNilai:function(dom){
          return $(dom).val();
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

        $(dom.submenu).on('change',function(){
          uiCtr.bersihError(dom.errorSubmenu);
        });
        
        $(dom.url).on('change',function(){
          uiCtr.bersihError(dom.errorUrl);
        });

        $(dom.icon).on('change',function(){
          uiCtr.bersihError(dom.errorIcon);
        });

        $(dom.modal +" "+ dom.btnCloseModal).on('click',function(){
          bersihAllError();
          bersihAllKolom();
        });

        $(dom.save).on('click',function(){
          insert();
        });

        $(dom.edit).on('click',function(){
          insert();
        });

        $(dom.data).on('click',dom.btnDelete,function(){
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
                hapus(id)
              }
          });
        });

        $(dom.btnTambah).on('click',function(){
          submit('tambah');
        });

        $(dom.data).on('click',dom.btnEdit,function(){
          const id = $(this).data('id');
          submit(id);
        });


      }

      function submit(keterangan){
        if(keterangan == 'tambah'){
          $(dom.save).show();
          $(dom.edit).hide();
          $('#modal_add_title').show();
          $('#modal_update_title').hide();
        }
        else{
          $(dom.save).hide();
          $(dom.edit).show();
          $(dom.modal).modal({backdrop: 'static', keyboard: false});
          $('#modal_add_title').hide();
          $('#modal_update_title').show();
          ambilData(keterangan);
        }
      }

      function bersihAllKolom(){
        uiCtr.bersihKolom(dom.submenu);
        uiCtr.bersihKolom(dom.url);
        uiCtr.bersihKolom(dom.icon);
        $(dom.menu).val($(dom.menu +" option:first").val());
        $(dom.status).val($(dom.status +" option:first").val());
        uiCtr.bersihKolom(dom.id);
      }

      function bersihAllError(){
        uiCtr.bersihError(dom.errorNama);
      }

      function reload_ajax(){
        $('#tabel').DataTable().ajax.reload()
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
              ajax: {"url": "<?php echo base_url().'admin/Menu/getSubmenu'?>", "type": "POST"},
                columns: [                     
                  {
                    "data": "id",
                    "orderable": false,
                    "searchable": false
                  },
                  {"data":"judul"},
                  {"data":"nama"},
                  {"data":"url"},
                  {"data":"myicon","orderable": false,"searchable": false}, 
                  {"data":"aktif"},
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

      function hapus(id) {
        $.ajax({
          type:'POST',
          data:{id:id},
          url:"<?=base_url('admin/Menu/deleteSubmenu')?>",
          dataType:'JSON',
          success:function(data){
            reload_ajax();
            uiCtr.tampilToast("delete","");
          }
        });
      }

      function insert(){
        var form_data = new FormData($('#form')[0]);
        $.ajax({
          type:'POST',
          data:form_data,
          url:base_url+"admin/Menu/insertSubmenu",
          processData: false,
          contentType: false,
          dataType:"JSON",
          success:function(data){
            if(data.pesan == "Berhasil"){
              var id = uiCtr.ambilNilai(dom.id);
              var nama = uiCtr.ambilNilai(dom.submenu);
              uiCtr.closeModal(dom.modal);
              if(id==""){
                uiCtr.tampilToast('insert',nama);
              }else{
                uiCtr.tampilToast('edit',nama);
              }
              reload_ajax();
            }else if (data.pesan =="Gagal"){
              uiCtr.tampilError(dom.errorSubmenu,data.errorsubmenu);
              uiCtr.tampilError(dom.errorUrl,data.errorurl);
              uiCtr.tampilError(dom.errorIcon,data.erroricon);
            }
          }
        });
      }

      function ambilData(id){
        $.ajax({
          type:'POST',
          data:'id='+id,
          url:"<?=base_url('admin/Menu/ambilByIDSubmenu')?>",
          dataType:'JSON',
          success:function(data){
            $('#id').val(data['id']);
            uiCtr.isiKolom(dom.submenu,data['judul']);
            uiCtr.isiKolom(dom.menu,data['id_menu']);
            uiCtr.isiKolom(dom.url,data['url']);
            uiCtr.isiKolom(dom.icon,data['icon']);
            uiCtr.isiKolom(dom.status,data['aktif']);
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