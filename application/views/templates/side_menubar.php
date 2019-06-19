<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?= base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

          <?php if(in_array('createBarang', $user_permission) || in_array('updateBarang', $user_permission) || in_array('viewBarang', $user_permission) || in_array('deleteBarang', $user_permission)): ?>
            <li class="treeview" id="mainBarangNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Barang</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createBarang', $user_permission)): ?>
                  <li id="addBarangNav"><a href="<?php echo base_url('barang/create') ?>"><i class="fa fa-circle-o"></i> Tambahkan Barang</a></li>
                <?php endif; ?>
                <?php if(in_array('updateBarang', $user_permission) || in_array('viewBarang', $user_permission) || in_array('deleteBarang', $user_permission)): ?>
                <li id="manageBarangNav"><a href="<?php echo base_url('barang') ?>"><i class="fa fa-circle-o"></i> Manajemen Barang</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>


          <?php if(in_array('createRuang', $user_permission) || in_array('updateRuang', $user_permission) || in_array('viewRuang', $user_permission) || in_array('deleteRuang', $user_permission)): ?>
            <li class="treeview" id="mainRuangNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Ruang</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createRuang', $user_permission)): ?>
                  <li id="addRuangNav"><a href="<?php echo base_url('ruang/create') ?>"><i class="fa fa-circle-o"></i> Tambahkan Ruang</a></li>
                <?php endif; ?>
                <?php if(in_array('updateRuang', $user_permission) || in_array('viewRuang', $user_permission) || in_array('deleteRuang', $user_permission)): ?>
                <li id="manageRuangNav"><a href="<?php echo base_url('ruang') ?>"><i class="fa fa-circle-o"></i> Manajemen ruang</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

          <?php if(in_array('createGedung', $user_permission) || in_array('updateGedung', $user_permission) || in_array('viewGedung', $user_permission) || in_array('deleteGedung', $user_permission)): ?>
            <li id="gedungNav">
              <a href="<?php echo base_url('gedung/') ?>">
                <i class="fa fa-files-o"></i> <span>Gedung</span>
              </a>
            </li>
          <?php endif; ?>
        <!-- <li class="header">Settings</li> -->

        <?php if(in_array('viewProfile', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profil</span></a></li>
        <?php endif; ?>
        <?php if(in_array('updateSetting', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Pengaturan</span></a></li>
        <?php endif; ?>

        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Keluar</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>