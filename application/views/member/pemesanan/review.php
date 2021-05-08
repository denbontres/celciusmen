<style>
    .text-detail td{
        color:black
    }
</style>
<div class="card">
            <div class="card-body">
                <div>
                <h2 class="mb-4"><?=$title?></h2>
                  <div class="row mt-2">
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <tr class="text-center">
                          <th>No Faktur</th>
                          <th>Nama Barang</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </tr>
                        <?php foreach($detail as $r) :?>
                            <tr class="text-center">
                                <td><?=$r->nofaktur?></td>
                                <td><?=$r->nama.' '.$r->sku?></td>
                                <td><?=number_format($r->total_harga,'0',',','.')?></td>
                                <td><?=$r->jumlah?></td>
                                <td><?=number_format($r->subtotal,'0',',','.')?></td>
                                <?php if($r->israting == 0){?>
                                    <td><a href="<?=base_url('product/'.$r->slug)?>" target="_blank" class="btn btn-info">Review</a></td>
                                <?php }else{?>
                                    <td></td>
                                <?php }?>
                            </tr>
                        <?php endforeach;?>
                      </table>
                      <!--Pagination-->
                    </div>
                  </div>
                </div>
            </div>
          </div>