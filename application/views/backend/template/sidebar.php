<aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="<?=base_url('asset/backend/')?>dist/img/favicon.png" alt="Admin Celcius" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Celcius</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url('foto_user/').$this->session->userdata('foto')?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?=base_url('admin/akun')?>" class="d-block"><?=$this->session->userdata('nama');?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <?php
                $jenis = $this->session->userdata('id_jenis_user');
                $querymenu = "select tbl_menu.id,nama
                              from tbl_menu join tbl_akses
                              on tbl_menu.id = tbl_akses.id_menu
                              where tbl_akses.id_jenis_user=$jenis
                              order by tbl_akses.id_menu asc";
                $menu = $this->db->query($querymenu)->result_array();
              ?>
                <!-- looping menu -->
              <?php foreach ($menu as $m):?>
                <li class="nav-header"><?=$m['nama'] ?></li>
                <?php
                $menuid = $m['id'];
                $querysubmenu = "select *
                              from tbl_submenu join tbl_menu
                              on tbl_submenu.id_menu = tbl_menu.id
                              where tbl_submenu.id_menu=$menuid
                              and tbl_submenu.aktif=1";
                $submenu = $this->db->query($querysubmenu)->result_array();
              ?>
                <?php foreach ($submenu as $sub) :?>
                  <li class="nav-item">
                  <?php if($sub['judul']==$group) {?>
                    <a href="<?=base_url($sub['url'])?>" class="nav-link active">
                  <?php
                  }
                  else{?>
                     <a href="<?=base_url($sub['url'])?>" class="nav-link">
                      <?php } ?>
                      <i class="nav-icon <?=$sub['icon']?>"></i>
                      <p><?=$sub['judul']?></p>
                      <?php $jumlah = countBadge($sub['judul']); ?>
                      <?php if($jumlah){ ?>
                        <span class="badge badge-primary right"><?=$jumlah?></span>
                      <?php }?>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endforeach; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>