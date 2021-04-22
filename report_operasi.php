<script src="dist/plugins/chartjs/Chart.bundle.js"></script>
<script type="text/javascript" src="libs/chartjs/chartjs-plugin-colorschemes.js"></script>

<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
etc();
encryption();
session();
connect();
head();
body();
timing();
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

<?php
$decimal = "0";
$a_decimal = ",";
$thousand = ".";
?>
<!--start page wrapper -->
<div class="page-wrapper">
  <div class="page-content">



    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
      <div class="col">
        <div class="card radius-10 bg-success bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Total Semua</p>
                <h4 class="my-1 text-white"><sup style="font-size: 20px">Rp </sup><?php echo number_format($data14, $decimal, $a_decimal, $thousand) . ',-'; ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-money'></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-primary bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Total Tahun Ini</p>
                <h4 class="my-1 text-white"><sup style="font-size: 20px">Rp </sup><?php echo number_format($data24, $decimal, $a_decimal, $thousand) . ',-'; ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-money'></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-info bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Total Bulan Ini</p>
                <h4 class="my-1 text-white"><sup style="font-size: 20px">Rp </sup><?php echo number_format($data34, $decimal, $a_decimal, $thousand) . ',-'; ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-money'></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-warning bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Total Hari Ini</p>
                <h4 class="my-1 text-white"><sup style="font-size: 20px">Rp </sup><?php echo number_format($data44, $decimal, $a_decimal, $thousand) . ',-'; ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-money'></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "report_operasi"; // halaman
    $dataapa = "Operasional"; // data
    $tabeldatabase = "operasional"; // tabel database
    $chmod = $chmenu9; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    ?>

    <!-- SETTING STOP -->

    <textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
    <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
    <script type="text/javascript">
      function printDiv(elementId) {
        var a = document.getElementById('printing-css').value;
        var b = document.getElementById(elementId).innerHTML;
        window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
      }
    </script>

    <!-- BREADCRUMB -->


    <!-- BOX HAPUS BERHASIL -->

    <script>
      window.setTimeout(function() {
        $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
          $(this).remove();
        });
      }, 5000);
    </script>


    <!-- BOX INFORMASI -->
    <?php
    if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') { ?>


      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" method="get">
            <div class="row">
              <label for="tahun" class="col-md-1 control-label">Dari</label>
              <div class="col-md-4">
                <input type="date" class="form-control" id="datepicker" name="dari" autocomplete="off" placeholder="Dari">
              </div>
              <label for="bulan" class="col-md-1 control-label">Sampai</label>
              <div class="col-md-4">
                <input type="date" class="form-control" id="datepicker2" name="sampai">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-info pull-right" name='find'>Filter</button>
              </div>
            </div>
          </form>
        </div>
      </div>





      <?php
      if (isset($_GET["find"])) {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {


          $dr = $_GET['dari'];
          $sam = $_GET['sampai'];


          $caba       = mysqli_query($conn, "SELECT DISTINCT nama FROM operasional_tipe order by no asc");
          $biaya       = mysqli_query($conn, "SELECT tipe,SUM(biaya) as cost FROM operasional WHERE tanggal BETWEEN '" . $dr . "' AND  '" . $sam . "' GROUP BY tipe order by no asc");



          if ($dr != '') {

            $dari = date("d-m-Y", strtotime($dr));
          } else {
            $dari = "Awal";
          }


          $sampe = date("d-m-Y", strtotime($sam));

      ?>


          <section class="col-lg-12 connectedSortable">


            <div class="card">
              <div class="card-header">
                <h3>#Periode: <?php echo $dari; ?> - <?php echo $sampe; ?></h3>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-5">

                    <canvas id="percabang" style="height:280px"></canvas>
                    <script>
                      var ctx = document.getElementById("percabang").getContext("2d");

                      // Chart options
                      Chart.defaults.global.legend.display = false;
                      Chart.defaults.global.tooltips.enabled = true;

                      // tampilan chart
                      var piechart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                          // label nama setiap Value

                          labels: [<?php while ($b = mysqli_fetch_array($caba)) {
                                      echo '"' . $b['nama'] . '",';
                                    } ?>],

                          datasets: [{
                            // Jumlah Value yang ditampilkan
                            label: '# dalam rupiah',
                            data: [<?php while ($b = mysqli_fetch_array($biaya)) {
                                      echo '"' . $b['cost'] . '",';
                                    } ?>],

                            borderWidth: 1
                          }],
                        }


                      });
                    </script>

                  </div>

                  <div class="col-md-7">


                    <table class="table table-striped">
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>


                      </tr>

                      <?php


                      $sql = "SELECT tipe,SUM(biaya) as cost FROM operasional WHERE tanggal BETWEEN '" . $dr . "' AND  '" . $sam . "' GROUP BY tipe order by no asc";
                      $hasil = mysqli_query($conn, $sql);

                      $no_urut = 0;
                      while ($fill = mysqli_fetch_assoc($hasil)) { ?>

                        <tr>
                          <td><?php echo ++$no_urut; ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['tipe']); ?></td>
                          <td>Rp
                            <?php echo mysqli_real_escape_string($conn, $fill['cost']); ?>
                  </div>
                  </td>
                  </tr>

                <?php } ?>
                </table>
                </div>
              </div>
            </div>
  </div>


  </section>



<?php }
      } ?>


<section class="col-lg-12 connectedSortable">


  <div class="card" id="tabel1">
    <div class="card-header with-border">
      <h3>Data Pengeluaran Operasional Periode: <?php echo $dari; ?> - <?php echo $sampe; ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">#</th>
          <th>Nama</th>
          <th style="width: 20%">Tipe</th>
          <th style="width: 40px">Jumlah</th>
          <th>Keterangan</th>
          <th style="width: 40px">User</th>
        </tr>

        <?php

        if (isset($dr)) {

          $sql1 = "SELECT * FROM operasional WHERE tanggal BETWEEN '" . $dr . "' AND  '" . $sam . "' order by no desc";
        } else {
          $sql1 = "SELECT * FROM operasional ORDER BY no desc ";
        }

        $hasil1 = mysqli_query($conn, $sql1);

        $no_urut = 0;
        while ($fill = mysqli_fetch_assoc($hasil1)) { ?>

          <tr>
            <td><?php echo ++$no_urut; ?></td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td>
              <?php echo mysqli_real_escape_string($conn, $fill['tipe']); ?>
            </td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['biaya']); ?></td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
          </tr>


        <?php } ?>
      </table>
    </div>
  </div>

  <div align="right" style="padding-right:15px" class="no-print" id="no-print">
    <div align="left" class="no-print" id="no-print"> <a onclick="javascript:printDiv('tabel1');" class="btn btn-default btn-flat" name="cetak" value="cetak"><span class="glyphicon glyphicon-print"></span></a><?php echo " "; ?>
      <a onclick="window.location.href='configuration/config_export?forward=<?php echo $forward; ?>&search=&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>'" class="btn btn-default btn-flat" name="cetak" value="export excel"><span class="glyphicon glyphicon-save-file"></span></a>
    </div> <br />
  </div>
</section>
</div>




<?php } else {
?>
  <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
  </div>
<?php
    }
?>


<!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="1-11-4-jquery-ui.min.js"></script>
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


<!-- ChartJS 1.0.1 -->
<script src="dist/plugins/chartjs/Chart.min.js"></script>



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