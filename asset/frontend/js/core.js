var base_url = "http://celciuskids.com/";  

var UIController = (function(){
    var DOMString ={
        'btnAddCart':'.add-to-cart',
        'txtTotalBelanja':'.cart-price',
        'txtJumlahBelanja':'.cart-amunt',
        'sku':'#sku',
        'dataPemebelian':'#data-pembelian',
        'dataWishlist':'#data-wishlist',
        'hapusKeranjangHead':'.hapus-item',
        'hapusWishlist':'.hapus-item-wishlist',
        'cartMinus':'.minus',
        'dataCart':'#data-cart',
        'txtCartTotal':'#cart-total',
        'txtJumlahBeli':'.qty',
        'wishlist':'.wishlist',
        'txtJumlahWishLish':'#jumlah-wishlist',
    };
    return {
        getDOM:function(){
            return DOMString;
        },
        tampilTotalBelanja:function(total){
            $(DOMString.txtTotalBelanja).text('IDR '+total);
        },
        tampilJumlahBarang:function(jumlah){
            $(DOMString.txtJumlahBelanja).text(jumlah);
        },
        tampilJumlahBarangWishlist:function(jumlah){
            $(DOMString.txtJumlahWishLish).text(jumlah);
        },
        tampilToast:function(tipe,nama){
            if(tipe=="insert"){
              toastr.success(nama+' berhasil ditambahkan');
            }else if(tipe=="gagal"){
              toastr.error('Stok tidak mencukupi');
            }else if(tipe=="duplicate"){
                toastr.error('Produk ini telah ada diwishlist');
            }else if(tipe=="wishlist"){
                toastr.success(nama+' berhasil ditambahkan ke Wishlist');
            }
        },
        formatRupiah:function(angka){
            return parseFloat(angka).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace(/\,/g,'.').slice(0, -3);
        },

        // halaman pemesanan
        buatTabelPemesanan:function(data,fnTotal,fnJumlah){
            var i,foto,nama,idBarang,urlFoto,harga,id;
            var html ="";
            if(data.length==0){
                html += '<div class="row">'+
                        '<b>Keranjang Masih Kosong</b></div>';
            }else{
                for(i=0;i<data.length;i++){
                    id = data[i].id;
                    foto = data[i].foto;
                    // nama = this.limitKalimat(data[i].nama,15);
                    //nama = data[i].nama+' '+data[i].sku;
                    nama = data[i].nama;
                    warna = data[i].sku;
                    idBarang = data[i].id_barang;
                    harga = this.formatRupiah(data[i].total_harga);
                    jumlah = data[i].jumlah;
                    subtotal = this.formatRupiah(data[i].subtotal);
                    // url = base_url+"DetailProduk?id="+idBarang;
                    urlFoto = base_url+'resource/'+foto;
                    html +='<div class="row">'+
                            '<div class="col-md-3 col-lg-4"><img class="frame-img py-2" src="'+urlFoto+'"></div>'+
                            '<div class="col itemlist-desc py-2"><a class="prod-title" href="#go to product">'+nama+'</a>'+
                                '<div class="detail-prod">'+
                                    '<p>Colour : '+warna+'</p>'+
                                    '<p>SKU : IL2203B</p>'+
                                '</div>'+
                                '<div class="price-item-list">'+
                                    '<p class="normal-price-item-list">IDR '+harga+' &nbsp;&nbsp;&nbsp;&nbsp; Total : IDR '+subtotal+'</p>'+
                                '</div>'+
                                '<div class="warp-qty">'+
                                    '<div class="input-group pro-qty">'+
                                    '<span class="input-group-btn"><button class="btn btn-minus btn-number quantity-left-minus" type="button" data-type="minus" id="min" data-id="'+id+'"'+'data-harga='+harga+'><i class="icon ion-minus-round"></i></button></span>'+
                                    '<input type="text" id="quantity" value="'+jumlah+'" min="1" class=" qty form-control input-number">'+
                                    '<span class="input-group-btn"><a class="btn btn-plus btn-number quantity-right-plus" role="button" data-type="plus" id="plush" data-id="'+id+'"'+'data-harga='+harga+'><i class="icon ion-plus-round"></i></a></span>'+
                                    '</div>'+
                                '</div>'+
                                '<a class="btn btn-type1-small mr-2" role="button" href="index-mens.html"><i class="fa fa-heart"></i></a>'+
                                '<a class="btn btn-type1-small" id="hapus-item-wishlist" data-id="'+id+'" role="button" href="#"><i class="fa fa-remove"></i></a>'+
                            '</div>'+
                        '</div>';   
                }
                
            }
            $('#data').html(html);
            fnTotal;
            fnJumlah;
        },

        // halaman pemesanan
        buatTabelWishlist:function(data){
            var baris,i,foto,nama,idBarang,urlFoto,harga,id;
            if(data.length==0){
                baris += '<tr>'+
                        '<td colspan="4"><b>Wishlist Masih Kosong</b></td></tr>';
            }else{
                for(i=0;i<data.length;i++){
                    id = data[i].id;
                    foto = data[i].foto;
                    // nama = this.limitKalimat(data[i].nama,15);
                    nama = data[i].nama;
                    idBarang = data[i].id_barang;
                    harga = this.formatRupiah(data[i].total_harga);
                    urlFoto = base_url+'resource/'+foto;
                    baris += '<tr>'+
                        '<td class="cart-pic first-row"> <img src="'+urlFoto+'" style="width:12rem" alt="" ></td>'+
                        '<td class="cart-title first-row"><h5>'+nama+'</h5></td>'+
                        '<td class="p-price first-row">'+harga+'</td>'+
                        '<td class="close-td first-row hapus-item-wishlist" data-id="'+id+'"><i class="ti-close"></i></td>'+
                    '</tr>';   
                }
                
            }
            $('#wishlist').html(baris);
        },
        
        tampilTotalBelanjaKeranjang:function(total){
            $(DOMString.txtCartTotal).text(total);
        },
        limitKalimat:function(text,limit){
            return text.slice(0,limit)+" ...";
        },
        bersihKolom:function(dom){
            $(dom).val("");
        }
    }
})();

var Controller = (function(uiCtr){
    var email,dom;
    email = $('body').attr('data-email');

    var setupEventListener = function(){
        dom = uiCtr.getDOM();
        
        if(email!=""){
            // getNomorFaktur();
            getJumlahBelanja();
            getTotalBelanja();
            getDataBelanja();
            getJumlahWishList();
            getDataWishlist();
        }
        
        $(dom.btnAddCart).on('click',function(){
            insertBelanja();
        });

        $(dom.wishlist).on('click',function(){
            var idBrang = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');
            insertWishLish(idBrang,nama);
        });

        $(dom.dataWishlist).on('click',dom.hapusWishlist,function(){
            var id = $(this).data('id');
            hapusItemWishlist(id);
        })
        
        $(dom.dataPemebelian).on('click',dom.hapusKeranjangHead,function(){
            var id = $(this).data('id');
            hapusItemKeranjang(id);
        })

        $('#data').on('click','#hapus-item-wishlist',function(){
            var id = $(this).data('id');
            hapusItemKeranjang(id);
        });

        $('#data').on('click','#plush',function(){
            var id = $(this).attr('data-id');
            var harga = $(this).attr('data-harga').replace(/\./g,'');
            var status = "tambah"
            plusMinKeranjang(id,status,harga);
        });

        $('#data').on('click','#min',function(){
            var id = $(this).attr('data-id');
            var harga = $(this).attr('data-harga').replace(/\./g,'');
            var status = "kurang";
            plusMinKeranjang(id,status,harga);
        });

        $('#data').on('click','#hapus',function(){
            var id = $(this).attr('data-id');
            hapusItemKeranjang(id);
        });

        // wishlist

        $('#wishlist').on('click',dom.hapusWishlist,function(){
            var id = $(this).attr('data-id');
            hapusItemWishlist(id);
        });

        function insertWishLish(idBarang,nama){
            $.ajax({
                type:'POST',
                url:base_url+'Wishlist/addWishlist',
                data:{idBarang:idBarang},
                success:function(data){
                    if(data=="Gagal"){
                        window.location.href =base_url+"Login";
                    }else if(data=="Sudah ada"){
                        uiCtr.tampilToast('duplicate','');
                    }else if(data =="Berhasil"){
                        uiCtr.tampilToast('wishlist',nama);
                        getJumlahWishList();
                        getDataWishlist();
                    }
                }
            })
        }

        function getJumlahWishList(){
            $.ajax({
                type:'POST',
                url:base_url+'Wishlist/getJumlahBarang',
                success:function(data){
                    uiCtr.tampilJumlahBarangWishlist(data);                           
                }
            }); 
        }
        function getDataWishlist(){
            $.ajax({
                type:'POST',
                url:base_url+'Wishlist/getWishlist',
                async : false,
                dataType: 'json',
                success:function(data){
                    var html ="";
                    var i;
                    for (i = 0; i < data.length ; i++) {
                        html += '<tr>' +
                            '<td class="si-pic"><img src="'+base_url+'resource/'+data[i].foto+'" alt="" style="width:7rem;height:7rem;"></td>'+
                            '<td class="si-text"> <div class="product-selected"> <p>' +uiCtr.formatRupiah(data[i].total_harga)  +'<h6>'+data[i].nama+'</p></h6> </div>'+'</td>' +
                            '<td class="si-close"><i class="ti-close hapus-item-wishlist" data-id='+data[i].id+'></i></td>' +
                            '</tr>';
                    }
                    
                    $(dom.dataWishlist).html(html);                          
                }
            }); 
        }

        function hapusItemWishlist(id){
            $.ajax({
                type:'POST',
                data:{id:id},
                url:base_url+'Wishlist/hapusItemWishlist',
                success:function(data){
                    getJumlahWishList();
                    getDataWishlist();
                    if(location.pathname.substring(1)=="Wishlist"){
                        getAllWishlist();
                    }
                }
            });
        }

        // end wishlist

        function plusMinKeranjang(id,status,harga){
            $.ajax({
                url:base_url+'Cart/plusminBelanja',
                data:{id:id,status:status,harga:harga},
                type:'post',
                success:function(data){
                    if(data=="gagal"){
                        uiCtr.tampilToast('gagal','');
                    }else{
                        getAllPemesanan();
                        get_pemesanan()
                    }
                },
            });
        }

        function insertBelanja(){
            var sku = $(dom.sku).val();
            var jumlahBeli = $(dom.txtJumlahBeli).val();
            if(email){
                $.ajax({
                    type:'POST',
                    data:{sku:sku,jumlahBeli:jumlahBeli},
                    url:base_url+"Pemesanan/addDataPemesanan",
                    dataType:"JSON",
                    success:function(data){
                      if(data.pesan == "Berhasil"){
                          getJumlahBelanja();
                          getTotalBelanja();
                          getDataBelanja();
                          uiCtr.tampilToast('insert',data.nama);
                          var stokTeksJs = $('#stok').text();
                          var stokTeks = stokTeksJs.split(" ");
                          var jumbaru =  stokTeks[0] - jumlahBeli;
                          if(jumbaru == 0){
                            $('#stok').text('Stok Habis');
                          }else{
                            $('#stok').text(jumbaru+' Tersisa');
                          }
                      }else if(data.pesan == "Gagal"){
                          uiCtr.tampilToast('gagal','');
                      }
                    }
                });
            }else{
                window.location.href =base_url+"Login";
            }
        }

        function hapusItemKeranjang(id){
            $.ajax({
                type:'POST',
                data:{id:id},
                url:base_url+'Pemesanan/hapusItemKeranjang',
                success:function(data){
                    getJumlahBelanja();
                    getTotalBelanja();
                    getDataBelanja();  
                    if(location.pathname.substring(1)=="Cart"){
                        getAllPemesanan();
                        get_pemesanan()                      
                    }
                }
            });
        }

        function getTotalBelanja(){
            $.ajax({
                type:'POST',
                url:base_url+'Pemesanan/getTotal',
                success:function(data){
                    uiCtr.tampilTotalBelanja(data);
                    if(location.pathname.substring(1)=="Cart"){
                        uiCtr.tampilTotalBelanjaKeranjang(data);
                    }                           
                }
            });
        }


        function getJumlahBelanja(){
            $.ajax({
                type:'POST',
                url:base_url+'Pemesanan/getJumlahBarang',
                success:function(data){
                    uiCtr.tampilJumlahBarang(data);                           
                }
            });    
        }

        function getDataBelanja(){
            $.ajax({
                type:'POST',
                url:base_url+'Pemesanan/getDataBelanja',
                async : false,
                dataType: 'json',
                success:function(data){
                    var html ="";
                    var i;
                    for (i = 0; i < data.length ; i++) {
                        html += '<tr>' +
                            '<td class="si-pic"><img src="'+base_url+'resource/'+data[i].foto+'" alt="" style="width:7rem;height:7rem;"></td>'+
                            '<td class="si-text"> <div class="product-selected"> <p>' +uiCtr.formatRupiah(data[i].total_harga) +' x '+ data[i].jumlah+'</p><h6>'+data[i].nama+'</h6> </div>'+'</td>' +
                            '<td class="si-close"><i class="ti-close hapus-item" data-id='+data[i].id+'></i></td>' +
                            '</tr>';
                    }
                    
                    $(dom.dataPemebelian).html(html);                          
                }
            }); 
        }

        function hapusItemKeranjang(id){
            $.ajax({
                type:'POST',
                data:{id:id},
                url:base_url+'Pemesanan/hapusItemKeranjang',
                success:function(data){
                    getJumlahBelanja();
                    getTotalBelanja();
                    getDataBelanja();  
                    if(location.pathname.substring(1)=="Cart"){
                        getAllPemesanan();
                        get_pemesanan()                      
                    }
                }
            });
        }

        if(location.pathname.substring(1)=="Cart"){
            getAllPemesanan();
            get_pemesanan()
        }

        if(location.pathname.substring(1)=="Wishlist"){
            getAllWishlist();
        }
        
        function getAllPemesanan(){
            $.ajax({
                type:"post",
                url:base_url+'Cart/getAll',
                dataType:'JSON',
                success:function(data){
                    uiCtr.buatTabelPemesanan(data,getTotalBelanja(),getJumlahBelanja());       
                }
            });
        }

        function getAllWishlist(){
            $.ajax({
                type:"post",
                url:base_url+'Wishlist/getAll',
                dataType:'JSON',
                success:function(data){
                    uiCtr.buatTabelWishlist(data);       
                }
            });
        }
    }

    return {
        init:function(){
            setupEventListener();
        }
    }
})(UIController);
Controller.init();

function get_pemesanan(){
    $.ajax({
        url: base_url+'cart/get_pemesanan',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
             console.log(data)
                if(data['kode_kupon'] != ''){
                    $('#remove-coupon').show()
                    $('#apply-coupon').hide()
                }else{
                    $('#remove-coupon').hide()
                    $('#apply-coupon').show()
                }
                $('#kupon').val(data['kode_kupon'])
                $('#subtotal').html(formatNumber(data['subtotal']))
                $('#discount').html(formatNumber(data['discount']))
                $('#discount_ongkir').html(formatNumber(data['discount_ongkir']))
                $('#total').html(formatNumber(parseFloat(data['subtotal']) - parseFloat(data['discount']) ))        },
        error(e) {
            console.log(e)
            $('.loader').hide()
        }
    })
}
function formatNumber(number){
    return number.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    ;
}