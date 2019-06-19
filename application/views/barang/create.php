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
            <h3 class="box-title">Tambah Barang</h3>
            
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('barang/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="barang_nama">Nama Barang</label>
                  <input type="text" class="form-control" id="barang_nama" name="barang_nama" placeholder="Nama Barang" autocomplete="on"/>
                  <small class="form-text text-danger"><?= form_error('barang_nama');?></small>
                </div>

                <div class="form-group">
                  <label for="kode_barang">Kode Barang</label>
                  <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang" autocomplete="on" />
                  <small class="form-text text-danger"><?= form_error('kode_barang');?></small>
                </div>

                <div class="form-group">
                  <label for="NUP">NUP</label>
                  <input type="text" class="form-control" id="NUP" name="NUP" placeholder="NUP" autocomplete="off" />
                  <small class="form-text text-danger"><?= form_error('NUP');?></small>
                </div>

                <div class="form-group">
                  <label for="tahun_perolehan">Tahun Perolehan</label>
                  <input type="text" class="form-control" id="tahun_perolehan" name="tahun_perolehan" placeholder="Tahun Perolehan" autocomplete="on">
                  <small class="form-text text-danger"><?= form_error('tahun_perolehan');?></small>
                </div>

                <div class="form-group">
                  <label for="penanggung_jawab">Penanggung Jawab</label>
                  <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" placeholder="Nama Penanggung Jawab" autocomplete="on">
                  <small class="form-text text-danger"><?= form_error('penanggung_jawab');?></small>
                </div>

                <div class="form-group">
                  <label for="merk">Merk</label>
                  <input type="text" class="form-control" id="merk" name="merk" placeholder="Nama Merk Barang" autocomplete="on">
                  <small class="form-text text-danger"><?= form_error('merk');?></small>
                </div>

                <div class="form-group">
                  <label for="description">Deskripsi</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Deskripsi" autocomplete="off">
                  </textarea>
                </div>
                
                <div class="form-group">
                  <label for="gedung">Gedung</label>
                  <select class="form-control" id="gedung" name="gedung">
                    <?php foreach ($gedung as $k => $v): ?>
                      <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="ruang">Ruang</label>
                  <select class="form-control" id="ruang" name="ruang">
                    <?php foreach ($ruang as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['no_ruangan'] ?>. <?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="gedung">Kondisi</label>
                  <select class="form-control" id="availability" name="availability">
                    <option value="1">Baik</option>
                    <option value="2">Rusak</option>
                    <option value="3">Rusak Parah</option>
                  </select>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('barang/') ?>" class="btn btn-warning">Kembali</a>
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
    $("#addBarangNav").addClass('active'); 
    
  //   $('#import_file').on('submit', function(event){
	// 	event.preventDefault();
	// 	$.ajax({
	// 		url:"< echo base_url('barang/import_excel'); ?>",
	// 		method:"POST",
	// 		data:new FormData(this),
	// 		contentType:false,
	// 		cache:false,
	// 		processData:false,
	// 		success:function(data){
	// 			$('#file_source').val('');
	// 			load_data();
	// 			alert(data);
	// 		}
	// 	})
	// });
    // var btnCust = '<button type="button" class="btn btn-success" title="Import File Excel"></button>';  
    // $("#import_file").fileinput({
    //     overwriteInitial: true,
    //     showClose: false,
    //     showCaption: false,
    //     browseLabel: '',
    //     removeLabel: '',
    //     browseIcon: '<i class="btn btn-success">Import Excel</i>',
    //     removeIcon: '',
    //     elErrorContainer: '#kv-avatar-errors-1',
    //     msgErrorClass: 'alert alert-block alert-danger',
    //     // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
    //     allowedFileExtensions: ["xlsx", "xls"]
    // }); 
  });
</script>