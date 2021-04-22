<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();
encryption();
session();
connect();
head();
body();
timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
  <meta http-equiv="refresh" content="0; url=logout" />
<?php
  exit(0);
}
?>
<?php
theader();
menu();
body();
?>
<!--start page wrapper -->
<div class="page-wrapper">
  <div class="page-content">
    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "user_profil"; // halaman
    $dataapa = "Profil User"; // data
    $tabeldatabase = "user"; // tabel database
    $chmod = $chmenu4; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    ?>
    <?php

    if (isset($_GET['no'])) {
      $no = $_GET['no'];

      $sql = "SELECT * from $tabeldatabase where no = '$no' ";
      $query = mysqli_query($conn, $sql);
      $data = mysqli_fetch_assoc($query);
      $iduser = $data['userna_me'];
      $avatar = $data['avatar'];
      $namauser = $data['nama'];
      $jabatan = $data['jabatan'];
      $alamat = $data['alamat'];
      $nohp = $data['nohp'];
      $lahir = $data['tgllahir'];
      $tgl = $data['tglaktif'];
    } else {
      $namauser = $_SESSION['username'];
      $no = $_SESSION['nouser'];

      $sql = "SELECT * from $tabeldatabase where no = '$no' ";
      $query = mysqli_query($conn, $sql);
      $data = mysqli_fetch_assoc($query);
      $iduser = $data['userna_me'];
      $avatar = $data['avatar'];

      $jabatan = $data['jabatan'];
      $alamat = $data['alamat'];
      $nohp = $data['nohp'];
      $lahir = $data['tgllahir'];
      $tgl = $data['tglaktif'];
    }

    ?>

    <!-- SETTING STOP -->


    <!-- BREADCRUMB -->

    <ol class="breadcrumb ">
      <li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
      <li><a href="admin">Daftar User</a></li>
      <?php

      if ($search != null || $search != "") {
      ?>
        <li> <a href="<?php echo $halaman; ?>">Data <?php echo $dataapa ?></a></li>
        <li class="active"><?php
                            echo $search;
                            ?></li>
      <?php
      } else {
      ?>
        <li class="active">Data <?php echo $dataapa ?></li>
      <?php
      }
      ?>
    </ol>

    <!-- Hitung penjualan pembelian atas nama user -->



    <!-- BOX INSERT BERHASIL -->

    <script>
      window.setTimeout(function() {
        $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
          $(this).remove();
        });
      }, 5000);
    </script>


    <!-- BOX INFORMASI -->
    <?php
    if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
    ?>

      <hr />
      <div class="row">
        <!-- <div class="col-md-4"> -->
        <div class="card col-lg-4">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img class="rounded-circle p-1 bg-primary" width="110" src="<?php echo $avatar; ?>" alt="User profile picture">
              <h3><?php echo $namauser; ?></h3>
              <p><?php echo $jabatan; ?></p>
              <div class="button-group mb-1">
                <a href="edit_user?no=<?php echo $no; ?>" class="btn btn-primary btn-sm"><b>Edit Profil</b></a>
                <a href="edit_password?no=<?php echo $no; ?>" class="btn btn-warning btn-sm"><b>Ubah Password</b></a>
              </div>
            </div>
            <hr class="my-4" />
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <b>Telp</b> <a class="pull-right"><?php echo $nohp; ?></a>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <b>Tgl lahir</b> <a class="pull-right"><?php echo $lahir; ?></a>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <b>Tgl Gabung</b> <a class="pull-right"><?php echo $tgl; ?></a>
              </li>
            </ul>
            <hr class="my-4" />
            <h4>Data User</h4>
            <!-- /.box-header -->
            <strong><i class="bx bx-book margin-r-5"></i> Alamat</strong>
            <p class="text-muted">
              <?php echo $alamat; ?>
            </p>
            <hr>
            <strong><i class="bx bx-file margin-r-5"></i> Catatan</strong>
            <p>Fitur ini Masih dikembangkan, harap tunggu update selanjutny</p>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs nav-primary" role="tablist">

                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#activity" role="tab" aria-selected="true">
                      <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-accessibility font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Aktivitas terakhir</div>
                      </div>
                    </a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false">
                      <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Profile</div>
                      </div>
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">

                      </div>
                      <!-- /.user-block -->

                      <div class="box-body no-padding">
                        <?php
                        error_reporting(E_ALL ^ E_DEPRECATED);
                        $sql    = "select * from mutasi inner join barang on mutasi.kodebarang=barang.kode where mutasi.namauser='$namauser' order by tgl desc";
                        $result = mysqli_query($conn, $sql);
                        $rpp    = 15;
                        $reload = "$halaman" . "?pagination=true";
                        $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

                        if ($page <= 0)
                          $page = 1;
                        $tcount  = mysqli_num_rows($result);
                        $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
                        $count   = 0;
                        $i       = ($page - 1) * $rpp;
                        $no_urut = ($page - 1) * $rpp;
                        ?>
                        <table class="table table-condensed">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Tanggal</th>
                              <th>Aktivitas</th>
                              <th>Barang</th>
                              <th>jumlah</th>
                              <th>Stok</th>
                            </tr>
                          </thead>
                          <?php
                          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                          $search = $_POST['search'];

                          if ($search != null || $search != "") {

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                              if (isset($_POST['search'])) {
                                $query1 = "select * from mutasi where namauser='$username' order by tgl desc limit $rpp";
                                $hasil = mysqli_query($conn, $query1);
                                $no = 1;
                                while ($fill = mysqli_fetch_assoc($hasil)) {
                          ?>


                                  <tbody>
                                    <tr>
                                      <td><?php echo ++$no_urut; ?></td>
                                      <td><?php echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
                                      <td><?php echo mysqli_real_escape_string($conn, $fill['kegiatan']); ?></td>
                                      <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                                      <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                                      <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>

                                    </tr>
                                    <?php;
                                      }

                                        ?>
                                  </tbody>
                        </table>
                        <div align="right"><?php if ($tcount >= $rpp) {
                                              echo paginate_one($reload, $page, $tpages);
                                            } else {
                                            } ?></div>
                    <?php }
                              }
                            }
                          } else {
                            while (($count < $rpp) && ($i < $tcount)) {
                              mysqli_data_seek($result, $i);
                              $fill = mysqli_fetch_array($result);
                    ?>
                    <tbody>
                      <tr>
                        <td><?php echo ++$no_urut; ?></td>
                        <td><?php echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
                        <td><?php echo mysqli_real_escape_string($conn, $fill['kegiatan']); ?></td>
                        <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                        <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                        <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                      </tr>
                    <?php
                              $i++;
                              $count++;
                            }

                    ?>
                    </tbody>
                    </table>
                    <div align="right"><?php if ($tcount >= $rpp) {
                                          echo paginate_one($reload, $page, $tpages);
                                        } else {
                                        } ?></div>
                  <?php } ?>
                  </table>
                      </div>
                      <!-- /.box-body -->
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    isi
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Nama Lengkap</label>
                        <div class="col-md-12">
                          <input type="email" class="form-control" value="<?php echo $namauser; ?>" disabled placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Jabatan</label>
                        <div class="col-md-12">
                          <input type="email" class="form-control" value="<?php echo $jabatan; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">No Hp</label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="<?php echo $nohp; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">Alamat</label>
                        <div class="col-md-12">
                          <textarea class="form-control" disabled><?php echo $alamat; ?></textarea>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
          </div>
        </div>
      </div>
  </div>
</div>


<?php
    } else {
?>
  <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
  </div>
<?php
    }
?>

<!-- /.content-wrapper -->


<!-- Script -->
<script src='jquery-3.1.1.min.js' type='text/javascript'></script>

<!-- jQuery UI -->
<link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dist/plugins/jQuery/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="dist/plugins/morris/morris.min.js"></script>
<script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="dist/plugins/knob/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
<script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/plugins/select2/select2.full.min.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/plugins/iCheck/icheck.min.js"></script>

<!--fungsi AUTO Complete-->
<!-- Script -->
<script type='text/javascript'>
  $(function() {

    $("#barcode").autocomplete({
      source: function(request, response) {

        $.ajax({
          url: "server.php",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        $('#nama').val(ui.item.label);
        $('#barcode').val(ui.item.value); // display the selected text
        $('#hargajual').val(ui.item.hjual);
        $('#stok').val(ui.item.sisa); // display the selected text
        $('#hargabeli').val(ui.item.hbeli);
        $('#jumlah').val(ui.item.jumlah);
        $('#kode').val(ui.item.kode); // save selected id to input
        return false;

      }
    });

    // Multiple select
    $("#multi_autocomplete").autocomplete({
      source: function(request, response) {

        var searchText = extractLast(request.term);
        $.ajax({
          url: "server.php",
          type: 'post',
          dataType: "json",
          data: {
            search: searchText
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        var terms = split($('#multi_autocomplete').val());

        terms.pop();

        terms.push(ui.item.label);

        terms.push("");
        $('#multi_autocomplete').val(terms.join(", "));

        // Id
        var terms = split($('#selectuser_ids').val());

        terms.pop();

        terms.push(ui.item.value);

        terms.push("");
        $('#selectuser_ids').val(terms.join(", "));

        return false;
      }

    });
  });

  function split(val) {
    return val.split(/,\s*/);
  }

  function extractLast(term) {
    return split(term).pop();
  }
</script>

<!--AUTO Complete-->

<script>
  $(function() {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {
      "placeholder": "yyyy/mm/dd"
    });
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {
      "placeholder": "yyyy/mm/dd"
    });
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      format: 'YYYY/MM/DD h:mm A'
    });
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Hari Ini': [moment(), moment()],
          'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
          'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
          'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
          'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    $('.datepicker').datepicker({
      dateFormat: 'yyyy-mm-dd'
    });

    //Date picker 2
    $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

    $('.datepicker2').datepicker({
      dateFormat: 'yyyy-mm-dd'
    });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
<?php footer(); ?>