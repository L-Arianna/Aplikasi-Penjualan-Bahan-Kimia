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


    <!-- ./col -->

    <!-- SETTING START-->

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "operasional"; // halaman
    $dataapa = "Operasional"; // data
    $tabeldatabase = "operasional"; // tabel database
    $chmod = $chmenu7; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $search = $_POST['search'];
    $insert = $_POST['insert'];

    function autoNumber()
    {
      include "configuration/config_connect.php";
      global $forward;
      $query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM $forward ORDER BY kode";
      $result = mysqli_query($conn, $query);
      $data = mysqli_fetch_array($result);
      $id_max = $data['max_id'];
      $sort_num = (int) substr($id_max, 1, 4);
      $sort_num++;
      $new_code = sprintf("%04s", $sort_num);
      return $new_code;
    }
    ?>


    <!-- SETTING STOP -->


    <!-- BREADCRUMB -->

    <ol class="breadcrumb ">
      <li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
      <li><a href="<?php echo $halaman; ?>"><?php echo $dataapa ?></a></li>
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

    <!-- BREADCRUMB -->

    <!-- BOX INSERT BERHASIL -->

    <script>
      window.setTimeout(function() {
        $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
          $(this).remove();
        });
      }, 5000);
    </script>

    <h6 class="mb-0 text-uppercase"></h6>
    <hr />
    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">Data <?php echo $dataapa; ?></h3>
      </div>
      <div class="card-body">
        <!-- BOX INFORMASI -->
        <?php
        if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
        ?>

          <!-- /.box-header -->

          <div class="box-body">
            <div class="table-responsive">
              <!----------------KONTEN------------------->
              <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

              $kode = $nama = $tanggal = $biaya = $keterangan = "";
              $no = $_GET["no"];
              $insert = '1';



              if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {

                $sql = "select * from $tabeldatabase where no='$no'";
                $hasil2 = mysqli_query($conn, $sql);


                while ($fill = mysqli_fetch_assoc($hasil2)) {


                  $kode = $fill["kode"];
                  $nama = $fill["nama"];
                  $biaya = $fill["biaya"];
                  $tanggal = $fill["tanggal"];
                  $akun = $fill["tipe"];
                  $keterangan = $fill["keterangan"];
                  $insert = '3';
                }
              }
              ?>
              <div id="main">
                <div class="container-fluid">

                  <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform">
                    <div class="box-body">

                      <div class="row">
                        <div class="form-group">
                          <label for="kode" class="col-sm-3 control-label">Kode:</label>
                          <div class="col-md-12">
                            <?php if ($no == null || $no == "") { ?>
                              <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required>
                            <?php } else { ?>
                              <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" maxlength="50" required readonly>
                            <?php } ?>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group">
                          <label for="nama" class="col-sm-3 control-label">Nama Keperluan:</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan nama keperluan" maxlength="100" required>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group">
                          <label for="nama" class="col-sm-3 control-label">Jenis Pengeluaran:</label>
                          <div class="col-md-12">
                            <select class="form-control select2" style="width: 100%;" name="akun" required>
                              <?php
                              $sql = mysqli_query($conn, "select nama from operasional_tipe");
                              while ($row = mysqli_fetch_assoc($sql)) {
                                if ($akun == $row['nama'])
                                  echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                                else
                                  echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group">
                          <label for="biaya" class="col-sm-3 control-label">Biaya:</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" id="biaya" name="biaya" value="<?php echo $biaya; ?>" placeholder="Masukan Biaya" maxlength="50" required>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group">
                          <label for="tanggal" class="col-sm-3 control-label">Tanggal:</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control pull-right" id="datepicker2" name="tanggal" placeholder="Masukan Tanggal" value="<?php echo $tanggal; ?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="form-group">
                          <label for="keterangan" class="col-sm-3 control-label">Keterangan:</label>
                          <div class="col-md-12">
                            <textarea class="form-control" rows="3" id="keterangan" name="keterangan" maxlength="255" placeholder="Masukan Keterangan"><?php echo $keterangan; ?></textarea>
                          </div>
                        </div>
                      </div>



                      <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
                    </div>
                    <!-- /.box-footer -->


                  </form>
                </div>
                <?php


                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                  $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                  $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
                  $biaya = mysqli_real_escape_string($conn, $_POST["biaya"]);
                  $tanggal = mysqli_real_escape_string($conn, $_POST["tanggal"]);
                  $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
                  $kasir = mysqli_real_escape_string($conn, $_SESSION["username"]);
                  $akun = mysqli_real_escape_string($conn, $_POST["akun"]);
                  $insert = ($_POST["insert"]);


                  $sql = "select * from $tabeldatabase where kode='$kode'";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                    if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
                      $sql1 = "update $tabeldatabase set nama='$nama', biaya='$biaya', tanggal='$tanggal',tipe='$akun', keterangan='$keterangan' where kode='$kode'";
                      $updatean = mysqli_query($conn, $sql1);
                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah diupdate!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    }
                  } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {

                    $sql2 = "insert into $tabeldatabase values( '$kode','$nama','$tanggal','$biaya','$keterangan','$kasir','$akun','')";
                    if (mysqli_query($conn, $sql2)) {
                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    }
                  }
                }


                ?>

                <script>
                  function myFunction() {
                    document.getElementById("Myform").submit();
                  }
                </script>

                <!-- KONTEN BODY AKHIR -->

              </div>
            </div>

            <!-- /.box-body -->
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
    <!-- ./col -->
    </div>

    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <!-- /.Left col -->
    </div>
    <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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