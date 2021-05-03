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


<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "jabatan"; // halaman
$dataapa = "Jabatan"; // data
$tabeldatabase = "jabatan"; // tabel database
$chmod = $chmenu10; // Hak akses Menu
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

<!--start page wrapper -->
<div class="page-wrapper">
  <div class="page-content">
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
    <hr />
    <div class="row">
      <div class="col-lg-6">
        <script>
          window.setTimeout(function() {
            $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
              $(this).remove();
            });
          }, 5000);
        </script>
        <?php
        if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
        ?>
          <div class="card">
            <div class="card-header">
              <h3>Data <?php echo $dataapa; ?></h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              <div class="table-responsive">
                <!----------------KONTEN------------------->
                <?php
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

                $kode = $nama = "";
                $no = $_GET["no"];
                $insert = '1';



                if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {

                  $sql = "select * from $tabeldatabase where no='$no'";
                  $hasil2 = mysqli_query($conn, $sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)) {


                    $kode = $fill["kode"];
                    $nama = $fill["nama"];
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

                                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="20" required>
                              <?php } else { ?>
                                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" maxlength="50" required readonly>
                              <?php } ?>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group">
                            <label for="nama" class="col-sm-3 control-label">Nama:</label>
                            <div class="col-md-12">

                              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan Nama Jabatan" maxlength="20" required="">
                            </div>
                          </div>
                        </div>


                        <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">
                      </div>
                    </form>
                  </div>
                  <?php

                  if (isset($_POST['simpan'])) {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                      $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                      $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
                      $insert = ($_POST["insert"]);


                      $sql = "select * from $tabeldatabase where kode='$kode'";
                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {
                        if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
                          $sql1 = "update $tabeldatabase set nama='$nama' where kode='$kode'";
                          $updatean = mysqli_query($conn, $sql1);
                          echo "<script type='text/javascript'>  alert('Berhasil, Data telah diupdate!'); </script>";
                          echo "<script type='text/javascript'>window.location = 'add_jabatan';</script>";
                        } else {
                          echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
                          echo "<script type='text/javascript'>window.location = 'add_jabatan';</script>";
                        }
                      } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {

                        $sql2 = "insert into $tabeldatabase values( '$kode','$nama','')";
                        $insertan = mysqli_query($conn, $sql2);
                        echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                        echo "<script type='text/javascript'>window.location = 'add_jabatan';</script>";
                      }
                    }
                  }

                  ?>

                  <script>
                    function myFunction() {
                      document.getElementById("Myform").submit();
                    }
                  </script>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-save"></span> Simpan</button>
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

      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3>Data <?php echo $forward ?> </span>
            </h3>
          </div>
          <?php
          error_reporting(E_ALL ^ E_DEPRECATED);
          $sql    = "select * from $forward order by no";
          $result = mysqli_query($conn, $sql);
          $rpp    = 5;
          $reload = "add_$halaman" . "?pagination=true";
          $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

          if ($page <= 0)
            $page = 1;
          $tcount  = mysqli_num_rows($result);
          $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
          $count   = 0;
          $i       = ($page - 1) * $rpp;
          $no_urut = ($page - 1) * $rpp;
          ?>
          <div class="card-body">
            <form method="post">
              <br />
              <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" name="search" class="form-control pull-right" placeholder="Cari">

                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Jabatan</th>
                    <th>Nama Jabatan</th>
                    <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                      <th>Opsi</th>
                    <?php } else {
                    } ?>
                  </tr>
                </thead>
                <?php
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                $search = $_POST['search'];

                if ($search != null || $search != "") {

                  if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    if (isset($_POST['search'])) {
                      $query1 = "SELECT * FROM  $forward where kode like '%$search%' or nama like '%$search%' order by no limit $rpp";
                      $hasil = mysqli_query($conn, $query1);
                      $no = 1;
                      while ($fill = mysqli_fetch_assoc($hasil)) {
                ?>
                        <tbody>
                          <tr>
                            <td><?php echo ++$no_urut; ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                            <td>
                              <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                <?php if ($fill['nama'] != 'admin') { ?>
                                  <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
                              <?php }
                              } else {
                              } ?>

                              <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>

                                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='set_chmod?no=<?php echo $fill['nama']; ?>'">HAK AKSES</button>

                                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo "jabatan" . '&'; ?>forwardpage=<?php echo 'add_jabatan' . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
                              <?php } else {
                              } ?>
                            </td>
                          </tr><?php } ?>
                        </tbody>
              </table>
            </div>
            <div align="right"><?php if ($tcount >= $rpp) {
                                  echo paginate_one($reload, $page, $tpages);
                                } else {
                                } ?></div>
          <?php
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
              <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              <td>
                <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                  <?php if ($fill['nama'] != 'admin') { ?>
                    <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
                <?php }
                    } else {
                    } ?>

                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>




                  <?php if ($fill['nama'] != 'admin') { ?>
                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='set_chmod?no=<?php echo $fill['nama']; ?>'">HAK AKSES</button>

                    <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo "jabatan" . '&'; ?>forwardpage=<?php echo 'add_jabatan' . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
                <?php }
                    } else {
                    } ?>
              </td>
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

          </div>
          <!-- /.box-body -->
          <p>Note: Jabatan admin dibuat agar tidak bisa dihapus/edit</p>
        </div>
      </div>

      <!-- ./wrapper -->
      <script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>

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