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
            <h3 class="box-title">Tambah Ruang</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('ruang/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="ruang_nama">Nama Ruang</label>
                  <input type="text" class="form-control" id="ruang_nama" name="ruang_nama" placeholder="Nama Ruang" autocomplete="on"/>
                  <small class="form-text text-danger"><?= form_error('ruang_nama');?></small>
                </div>

                <div class="form-group">
                  <label for="ruang_nomer">Nomor Ruang</label>
                  <input type="text" class="form-control" id="ruang_nomer" name="ruang_nomer" placeholder="Masukkan Nomor Ruang" autocomplete="on" />
                  <small class="form-text text-danger"><?= form_error('ruang_nomer');?></small>
                </div>

                <div class="form-group">
                  <label for="gedung">Gedung</label>
                  <select class="form-control" id="gedung" name="gedung">
                    <?php foreach ($gedung as $k => $v) : ?>
                        <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="active">Status</label>
                  <select class="form-control" id="active" name="active">
                    <option value="1">Aktif</option>
                    <option value="2">Non-Aktif</option>
                  </select>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('ruang/') ?>" class="btn btn-warning">Kembali</a>
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
    $("#addRuangNav").addClass('active');

  });
</script>