<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Ruang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Ruang</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Sunting Ruang</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('ruang/update') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="ruang_nama">Nama Ruang</label>
                  <input type="text" class="form-control" id="ruang_nama" name="ruang_nama" placeholder="Nama Ruang" value="<?= $ruang_data['name']; ?>"  autocomplete="on"/>
                </div>

                <div class="form-group">
                  <label for="ruang_nomer">Nomer Ruang</label>
                  <input type="text" class="form-control" id="ruang_nomer" name="ruang_nomer" placeholder="Nomer Ruang" value="<?= $ruang_data['no_ruangan']; ?>" autocomplete="on" />
                </div>

                <div class="form-group">
                  <label for="gedung">Gedung</label>
                  <select class="form-control" id="gedung" name="gedung">
                    <?php foreach ($gedung as $k => $v): ?>
                    <option value="<?php echo $v['id'] ?>"<?php if($ruang_data['gedung_id'] == $v['id']) {echo "selected='selected'";}?>><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="active">Status</label>
                  <select class="form-control" id="active" name="active">
                    <option value="1" <?php if($ruang_data['active'] == 1) { echo "selected='selected'";}; ?>>Aktif</option>
                    <option value="2" <?php if($ruang_data['active'] == 2) { echo "selected='selected'";}; ?>>Non-aktif</option>
                    </select>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('ruang/') ?>" class="btn btn-warning">Kembali</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  
  $(document).ready(function() {

    $("#mainRuangNav").addClass('active');
    $("#manageRuangNav").addClass('active');

  });
</script>