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
              <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#modal-tambah"  data-backdrop="static" data-keyboard="false" id="btn-tambah"><i class="fas fa-plus mr-2"></i><?=$judul?></button>
              <div class="table-responsive" id="data-table">
              </div>
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
  <div class="modal fade" id="modal-tambah"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal_add_title">Tambah <?=$judul?></h4>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="form-tambah">
                <div class="form-group">
                  <label for="">Kode Kupon</label>
                  <input type="text" class="form-control" name="kode_kupon">
                </div>
                <div class="form-group">
                  <label for="">Tipe Kupon</label>
                  <select name="tipe_kupon"  class="form-control tipe_kupon">
                    <option value="free_ongkir">Free Ongkir</option>
                    <option value="potongan_belanja">Potongan Belanja</option>
                  </select>
                </div>
                <div class="form-group potongan">
                  <label for="">Tipe Potongan</label>
                  <select name="tipe_potongan" class="form-control">
                    <option value="value">Nilai Belanja</option>
                    <option value="percent">Persentase</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Minimal Belanja</label>
                  <input type="number" class="form-control" value="0" name="min_value">
                </div>
                <div class="form-group">
                  <label for="">Potongan (Isi nominal atau persentase potongan)</label>
                  <input type="number" class="form-control" name="value" value="0">
                </div>
                <div class="form-group">
                  <label for="">Aktif Sampai Tanggal</label>
                  <input type="date" class="form-control" name="valid_until">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary save-btn" >Simpan</button>
            </div>
            </form>
          </div>
    </div>
  </div>
  <div class="modal fade" id="modal-ubah"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal_add_title">Tambah <?=$judul?></h4>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="form-ubah">
                <div class="form-group">
                  <label for="">Kode Kupon</label>
                  <input type="hidden" name="original_value" id="original_value">
                  <input type="text" class="form-control" name="kode_kupon" id="kode_kupon">
                </div>
                <div class="form-group">
                  <label for="">Tipe Kupon</label>
                  <select name="tipe_kupon"  id="tipe_kupon" class="form-control tipe_kupon">
                    <option value="free_ongkir">Free Ongkir</option>
                    <option value="potongan_belanja">Potongan Belanja</option>
                  </select>
                </div>
                <div class="form-group potongan">
                  <label for="">Tipe Potongan</label>
                  <select name="tipe_potongan" id="tipe_potongan" class="form-control">
                    <option value="value">Nilai Belanja</option>
                    <option value="percent">Persentase</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Minimal Belanja</label>
                  <input type="number" class="form-control" value="0" name="min_value" id="min_value">
                </div>
                <div class="form-group">
                  <label for="">Potongan (Isi nominal atau persentase potongan)</label>
                  <input type="number" class="form-control" name="value" id="value" value="0">
                </div>
                <div class="form-group">
                  <label for="">Aktif Sampai Tanggal</label>
                  <input type="date" class="form-control" name="valid_until" id="valid_until">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary update-btn" >Update</button>
            </div>
            </form>
          </div>
    </div>
  </div>
  <script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
  <script>
    fetch_data();

    function fetch_data() {
        $('.loading').show();
        $.ajax({
            url: "<?php echo base_url(); ?>admin/kupon/fetch_data",
            method: "POST",
            success: function(data) {
                $('#data-table').html(data);
                $("#dataTable").DataTable();
                $('.loading').hide();
            },
            error: function(err) {
                $('.loading').hide()
                console.log(err)
                swalError('Error ' + err.status, err.statusText);
            }
        })
    }
    $('.potongan').hide()
    $(document).on("change",".tipe_kupon",function() {
        console.log($(this).val())
        if($(this).val()=='free_ongkir'){
            $('.potongan').hide()
        }else{
            $('.potongan').show()
        }
    })
    $(document).on("click",".delete-btn",function() {
        if (confirm("Apakah anda yakin")) {
            $.ajax({
                url: '<?= base_url() ?>admin/kupon/delete',
                data: {
                    kode_kupon: $(this).data('kode_kupon')
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    $('.loader').hide()
                    toastr.success("Berhasil menghapus kupon");

                    fetch_data()
                },
                error(e) {
                    console.log(e)
                    $('.loader').hide()
                }
            })
        }
    })
    $(document).on("click",".save-btn",function() {
        var form_data = new FormData($('#form-tambah')[0])
        $.ajax({
            url: '<?= base_url() ?>admin/kupon/save_data',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
                console.log(response)
                $('.loader').hide()
                message = response.split("|")
                toastr.success(message[1]);

                if(message[0] == 'Success'){
                    $('#modal-tambah').modal('hide')
                    fetch_data()
                }
            },
            error: function(err) {
                $('.loader').hide()
                console.log(err)
                swalError('Error ' + err.status, err.statusText);
            }
        })
    })
    $(document).on("click",".edit-btn",function() {
        $('#original_value').val($(this).data('kode_kupon'))
        $('#kode_kupon').val($(this).data('kode_kupon'))
        $('#tipe_kupon').val($(this).data('tipe_kupon'))
        $('#tipe_potongan').val($(this).data('tipe_potongan'))
        $('#min_value').val($(this).data('min_value'))
        $('#value').val($(this).data('value'))
        $('#valid_until').val($(this).data('valid_until'))
        if($(this).data('tipe_kupon')=='free_ongkir'){
            $('.potongan').hide()
        }else{
            $('.potongan').show()
        }
        $('#modal-ubah').modal('show')
    })
    $(document).on("click",".update-btn",function() {
        var form_data = new FormData($('#form-ubah')[0])
        $.ajax({
            url: '<?= base_url() ?>admin/kupon/update_data',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
                console.log(response)
                $('.loader').hide()
                message = response.split("|")
                toastr.success(message[1]);
                if(message[0] == 'Success'){
                    $('#modal-ubah').modal('hide')
                    fetch_data()
                }
            },
            error: function(err) {
                $('.loader').hide()
                console.log(err)
                swalError('Error ' + err.status, err.statusText);
            }
        })
    })
  </script>    