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
                  <th>Nama</th>
                  <th>Foto</th>
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
                  Nama Brand
                  <input type="text" class="form-control" name="nama" id="nama-brand">
                  <input type="text" class="form-control" name="id" id="id" style="display:none">
                  <small class="text-danger" id="error-nama"></small>
                </div>
                <div class="form-group">
                    Foto<br>
                    <img id="show" src="<?=base_url('resource/blank.jpg')?>" alt="your image" class="mb-2" width="80" height="100"/><br>
                    <input type="file" name="foto" id="foto"><br>
                    <small class="text-danger" id="notice">Foto Harus Berukuran Dibawah 1 MB dan Berformat JPG dan PNG</small>
                    <small class="text-danger" id="error-foto"></small>
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
        'id':'#id',
        'nama':'#nama-brand',
        'save':'#save',
        'edit':'#edit',
        'errorNama':'#error-nama',
        'errorFoto':'#error-foto',
        'notice':'#notice',
        'btnCloseModal':'#close',
        'modal' : '.modal',
        'data':'#data',
        'btnDelete':'#btn-delete',
        'btnEdit':'#btn-edit',
        'btnTambah':'#btn-tambah',
        'foto':"#foto",
        'show':'#show',
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
        tampilFoto:function(dom,url){
          $(dom).attr('src',url);
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

        $(dom.nama).on('change',function(){
          uiCtr.bersihError(dom.errorNama);
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
                hapus(id);
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

        $(dom.foto).on('change',function(){
          tampilGambar(this,dom.show);
          uiCtr.bersihError(dom.errorFoto);
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
        uiCtr.bersihKolom(dom.nama);
        uiCtr.bersihKolom(dom.id);
        uiCtr.tampilFoto(dom.show,base_url+"resource/blank.jpg");
        uiCtr.bersihKolom(dom.foto);
      }

      function bersihAllError(){
        uiCtr.bersihError(dom.errorNama);
        uiCtr.bersihError(dom.errorFoto);
        $(dom.notice).text('Foto Harus Berukuran Dibawah 1 MB dan Berformat JPG dan PNG');
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
              ajax: {"url": "<?php echo base_url().'admin/UserInterface/getBrand'?>", "type": "POST"},
                columns: [                     
                  {
                    "data": "id",
                    "orderable": false,
                    "searchable": false
                  },
                  {"data":"nama"},
                  {"data":"foto"},
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
      function tampilGambar(input,dom) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $(dom)
                  .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
      }

      function hapus(id) {
        $.ajax({
          type:'POST',
          data:{id:id},
          url:"<?=base_url('admin/UserInterface/deleteBrand')?>",
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
          url:base_url+"admin/UserInterface/insertBrand",
          processData: false,
          contentType: false,
          dataType:"JSON",
          success:function(data){
            if(data.pesan == "Berhasil"){
              var id = uiCtr.ambilNilai(dom.id);
              var nama = uiCtr.ambilNilai(dom.nama);
              uiCtr.closeModal(dom.modal);
              if(id==""){
                uiCtr.tampilToast('insert',nama);
              }else{
                uiCtr.tampilToast('edit',nama);
              }
              reload_ajax();
            }else if (data.pesan =="Gagal"){
              $(dom.notice).text('');
              uiCtr.tampilError(dom.errorNama,data.errornama);
              uiCtr.tampilError(dom.errorFoto,data.errorfoto);
            }
          }
        });
      }

      function ambilData(id){
        $.ajax({
          type:'POST',
          data:'id='+id,
          url:"<?=base_url('admin/UserInterface/ambilByIdBrand')?>",
          dataType:'JSON',
          success:function(data){
            $('#id').val(data['id']);
            uiCtr.isiKolom(dom.nama,data['nama']);
            uiCtr.tampilFoto(dom.show,base_url+'foto_brand/'+data['foto']);
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