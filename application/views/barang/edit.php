<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Barang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Barang</li>
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
            <h3 class="box-title">Sunting Barang</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('barang/update') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="barang_nama">Nama Barang</label>
                  <input type="text" class="form-control" id="barang_nama" name="barang_nama" placeholder="Nama Barang" value="<?= $barang_data['name']; ?>"  autocomplete="on"/>
                  <small class="form-text text-danger"><?= form_error('barang_nama');?></small>
                </div>

                <div class="form-group">
                  <label for="kode_barang">Kode Barang</label>
                  <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang" value="<?= $barang_data['kode_barang']; ?>" autocomplete="on" />
                  <small class="form-text text-danger"><?= form_error('kode_barang');?></small>
                </div>

                <div class="form-group">
                  <label for="NUP">NUP</label>
                  <input type="text" class="form-control" id="NUP" name="NUP" placeholder="NUP" value="<?php echo $barang_data['NUP']; ?>" autocomplete="off" />
                  <small class="form-text text-danger"><?= form_error('NUP');?></small>
                </div>

                <div class="form-group">
                  <label for="tahun_perolehan">Tahun Perolehan</label>
                  <input type="text" class="form-control" id="tahun_perolehan" name="tahun_perolehan" placeholder="Tahun Perolehan" value="<?php echo $barang_data['tahun_perolehan']; ?>" autocomplete="on" />
                  <small class="form-text text-danger"><?= form_error('tahun_perolehan');?></small>
                </div>

                <div class="form-group">
                  <label for="penanggung_jawab">Penanggung Jawab</label>
                  <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" placeholder="Nama Penanggung Jawab" value="<?php echo $barang_data['penanggung_jawab']; ?>" autocomplete="on" />
                  <small class="form-text text-danger"><?= form_error('penanggung_jawab');?></small>
                </div>

                <div class="form-group">
                  <label for="merk">Merk Barang</label>
                  <input type="text" class="form-control" id="merk" name="merk" placeholder="Nama Merk Barang" value="<?php echo $barang_data['merk']; ?>" autocomplete="on" />
                  <small class="form-text text-danger"><?= form_error('merk');?></small>
                </div>

                <div class="form-group">
                  <label for="description">Keterangan Barang</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Keterangan Barang" autocomplete="off">
                    <?php echo $barang_data['description']; ?>
                  </textarea>
                </div>

                <div class="form-group">
                  <label for="gedung">Gedung</label>
                  <select class="form-control" id="gedung" name="gedung">
                    <?php foreach ($gedung as $k => $v): ?>
                    <option value="<?php echo $v['id'] ?>"<?php if($barang_data['gedung_id'] == $v['id']) {echo "selected='selected'";}?>><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="ruang">Ruang</label>
                  <select class="form-control" id="ruang" name="ruang">
                    <?php foreach ($ruang as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"<?php if($barang_data['ruang_id'] == $v['id']) {echo "selected='selected'";}?>><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="availability">Kondisi</label>
                  <select class="form-control" id="availability" name="availability">
                    <option value="1" <?php if($barang_data['availability'] == 1) { echo "selected='selected'"; } ?>>Baik</option>
                    <option value="2" <?php if($barang_data['availability'] == 2) { echo "selected='selected'"; } ?>>Rusak</option>
                    <option value="3" <?php if($barang_data['availability'] == 3) { echo "selected='selected'"; } ?>>Rusak Parah</option>
                  </select>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('barang/') ?>" class="btn btn-warning">Kembali</a>
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
    $("#description").wysihtml5();

    $("#mainBarangNav").addClass('active');
    $("#manageBarangNav").addClass('active');

    $("#barang_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });
</script>