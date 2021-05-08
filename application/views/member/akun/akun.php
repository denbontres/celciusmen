<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body">
                        <center>
                            <img src="<?=base_url('asset/member_area/')?>images/logo.jpg" alt="Foto User" style="width:100px;height:100px;border-radius:50%;">
                        </center>
                        <h6 class="text-center mt-2"><?=$user['nama']?></h6>
                        <p class="text-center">Customer</p>
                        <hr>
                        <b>Email</b><br>
                        <?=$this->session->userdata('email')?>
                        <hr>
                        <b>No. Telpon</b><br>
                        <?=$user['notelpon']?>
                        <hr>
                        <b>Terdaftar</b><br>
                        <?=tglIndo($user['tgl_daftar'])?>
                        <hr>
                    </div>
                </div>
            </div>        
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="<?=base_url('member/Akun')?>" method="POST">
                            <div class="form-group">
                                <label for="nama">Nama</label>                                
                                <input type="text" name="nama" id="nama" value="<?=$user['nama']?>" class="form-control">
                                <?= form_error('nama','<small class="text-danger pl-3" id="error-nama">','</small>');?>
                            </div>
                            <div class="form-group">
                                <label for="nohp">No Telpon</label>                                
                                <input type="text" name="nohp" value="<?=$user['notelpon']?>" id="nohp" class="form-control">
                                <?= form_error('nohp','<small class="text-danger pl-3" id="error-nohp">','</small>');?>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>                                
                                <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3"><?=$user['alamat']?></textarea>
                                <?= form_error('alamat','<small class="text-danger pl-3" id="error-alamat">','</small>');?>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="provinsi">Provinsi</label>
                                    <select name="provinsi" id="provinsi" class="form-control">
                                        <option value="">--Provinsi--</option>
                                        <?php foreach($provinsi as $r):?>
                                            <option value="<?=$r['id_provinsi']?>" <?=$r['id_provinsi']==$user['id_provinsi']?'selected':''?>><?=$r['nama_provinsi']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="kota">Kota</label>
                                    <select name="kota" id="kota" class="form-control">
                                        <option value="">--Kota--</option>
                                        <?php foreach($kota as $r):?>
                                            <option value="<?=$r['id_kota']?>" <?=$r['id_kota']==$user['id_kota']?'selected':''?>><?=$r['nama_kota']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="kodepos">Kode Pos</label>
                                    <input type="text" name="kodepos" id="kodepos" value="<?=$user['kode_pos']?>" class="form-control">
                                    <?= form_error('kodepos','<small class="text-danger pl-3" id="error-kodepos">','</small>');?>
                                </div>
                            </div>
                            <input type="submit" value="Simpan" class="form-control btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>     
        </div>   
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"> 
                        <!-- <h5 class="card-title text-center">Ganti Password</h5> -->
                        <form action="<?=base_url('member/Akun/updatePassword')?>" method="post" >
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="old-password">Old Password</label>
                                    <input type="password" name="old-password" id="old-password" class="form-control"  value="<?=set_value('old-password')?>">
                                    <?= form_error('old-password','<small class="text-danger pl-3" id="error-old-password">','</small>');?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"  value="<?=set_value('password')?>">
                                    <?= form_error('password','<small class="text-danger pl-3" id="error-password">','</small>');?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="repassword">Re Password</label>
                                    <input type="password" name="repassword" id="repassword" class="form-control"  value="<?=set_value('repassword')?>">
                                    <?= form_error('repassword','<small class="text-danger pl-3" id="error-repassword">','</small>');?>
                                </div>
                            </div>
                            
                            <input type="submit" value="Simpan" class="form-control btn btn-primary">
                            <input type="reset" value="Batal" class="form-control btn btn-danger mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.js"></script>
<?= $this->session->flashdata('pesan')?>
<script>
    var base_url = '<?=base_url()?>';
    $('#provinsi').on('change',function(){
        var id= $(this).val();
        getKota(id);
    });
    function getKota(idprovinsi){
        $.ajax({
            url:base_url+'member/Akun/getKota',
            data:{id:idprovinsi},
            type:'post',
            dataType:'JSON',
            success:function(data){
                var newData = hapusDuplicateKota(data);
                tampilKota(newData);
                
            }
        });
    }
    function tampilKota(data){
        var html;
        if(data.length==0){
            html +='<option value="">--Kota/Kabupaten--</option>';
        }else{
            for(var i=0;i<data.length;i++){
                html +='<option value="'+data[i].id_kota+'" >'+data[i].nama_kota+'</option>';
            }
        }
        $('#kota').html(html);
    }
    function hapusDuplicateKota(data){
            var namaKota = Object.values(data.reduce((acc,cur)=>Object.assign(acc,{[cur.nama_kota]:cur}),{}));
            var idKota = Object.values(namaKota.reduce((acc,cur)=>Object.assign(acc,{[cur.id_kota]:cur}),{}));
            return idKota;
        }
</script>
<script>
    var UIController = (function (){
      var DOMString = {       
        'nama':'#nama',
        'errorNama':'#error-nama',        
        'nohp':'#nohp',       
        'errorNohp':'#error-nohp',
        'alamat':'#alamat',       
        'errorAlamat':'#error-alamat',
        'kodepos':'#kodepos',       
        'errorKodepos':'#error-kodepos',
        'oldPassword':'#old-password',
        'errorOldPassword':'#error-old-password',
        'password':'#password',       
        'errorPassword':'#error-password',
        'repassword':'#repassword',       
        'errorRepassword':'#error-repassword',
      };
      return {
        getDOM:function(){
          return DOMString;
        },
        bersihError:function(dom){
          $(dom).text("");
        }  
      }
    })();

    var Controller = (function (uiCtr){
      var dom;
      var setupEventListener = function(){
        dom = uiCtr.getDOM();

        $(dom.nama).on('change',function(){
          uiCtr.bersihError(dom.errorNama);
        });

        $(dom.nohp).on('change',function(){
          uiCtr.bersihError(dom.errorNohp);
        });

        $(dom.alamat).on('change',function(){
          uiCtr.bersihError(dom.errorAlamat);
        });

        $(dom.kodepos).on('change',function(){
          uiCtr.bersihError(dom.errorKodepos);
        });

        $(dom.password).on('change',function(){
          uiCtr.bersihError(dom.errorPassword);
        });

        $(dom.repassword).on('change',function(){
          uiCtr.bersihError(dom.errorRepassword);
        });

        $(dom.oldPassword).on('change',function(){
          uiCtr.bersihError(dom.errorOldPassword);
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