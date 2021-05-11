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
<div class="wrapper">
  <?php
  theader();
  menu();
  body();
  ?>
  <!--start page wrapper -->
  <div class="page-wrapper">
    <div class="page-content">
      <!-- BREADCRUMB -->
      <!-- SETTING START-->

      <?php
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "configuration/config_chmod.php";
      $halaman = "invoice_jual"; // halaman
      $dataapa = "Invoice Penjualan"; // data
      $tabeldatabase = "invoicejual"; // tabel database
      $chmod = $chmenu6; // Hak akses Menu
      $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
      $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
      $tabel = "sale";

      date_default_timezone_set("Asia/Jakarta");
      $today = date('d-m-Y');
      ?>
      <?php
      $decimal = "0";
      $a_decimal = ",";
      $thousand = ".";
      ?>
      <?php
      $nota = $_GET["nota"];

      $sql1 = "SELECT * FROM data";
      $hasil1 = mysqli_query($conn, $sql1);
      $row = mysqli_fetch_assoc($hasil1);
      $nama = $row['nama'];
      $alamat = $row['alamat'];
      $notelp = $row['notelp'];
      $tagline = $row['tagline'];
      $signature = $row['signature'];
      $avatar = $row['avatar'];

      $sql1 = "SELECT * , count(total) as totalprice FROM $tabel where nota='$nota'";
      $hasil1 = mysqli_query($conn, $sql1);
      $row = mysqli_fetch_assoc($hasil1);

      $sql2 = "SELECT * , sum(hargaakhir) as totalprice FROM invoicejual where nota='$nota'";
      $hasil2 = mysqli_query($conn, $sql2);
      $rowa = mysqli_fetch_assoc($hasil2);


      $tglbayar = date("d-m-Y", strtotime($row['tglsale']));

      $due = date("d-m-Y", strtotime($row['duedate']));



      $bayar = $row['kasir'];
      $total = $row['totalprice'];
      $keterangan = $row['keterangan'];
      $pelanggan = $row['pelanggan'];
      $status = $row['status'];
      $diskon = $row['diskon'];
      $pot = $row['potongan'];
      $biaya = $row['biaya'];
      $totalprice = $rowa['totalprice'];


      $totalall = $totalprice + $pot + $biaya;
      $sql2 = "SELECT * FROM pelanggan where kode='$pelanggan' ";
      $hasil2 = mysqli_query($conn, $sql2);
      $row = mysqli_fetch_assoc($hasil2);

      $customer = $row['nama'];
      $nohp = $row['nohp'];
      $address = $row['alamat'];

      $sql1 = "SELECT * FROM sale where nota='$nota' ";
      $hasil1 = mysqli_query($conn, $sql1);
      $row = mysqli_fetch_assoc($hasil1);

      $noPO = $row['no_po'];
      $faktur_pajak = $row['faktur_pajak'];
      $no_surat = $row['no_surat_jalan'];
      $namapt = $row['nama_pt'];
      $alamatpt = $row['alamat_pt'];
      $notelppt = $row['no_tlp'];
      ?>

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


        <!-- KONTEN BODY AWAL -->
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm">
                <h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
              </div>
              <div class="col-sm" style="text-align: right;">
                <small>Faktur Penjualan || Date: <?php echo $today; ?></small>
              </div>
            </div>
          </div>
          <!-- /.box-header -->

          <div class="card-body">
            <!-- <div class="table-responsive"> -->
            <!----------------KONTEN------------------->
            <?php

            ?>
            <!-- <section class="invoice"> -->

            <div class="row mb-1">
              <div class="col-md-4 ">
                Dari
                <address>
                  <strong> <?php echo $nama; ?></strong><br>
                  <?php echo $alamat; ?><br>
                  Telp : <?php echo $notelp; ?><br>
                  <b>No. Invoice #<?php echo $nota; ?></b><br>
                  <strong>No. Faktur Pajak: <?= $faktur_pajak ?></strong><br>
                  <strong>No. PO: <?= $noPO ?></strong><br>
                  <b>Jatuh Tempo</b> <?php echo $due; ?>
                </address>
              </div>
              <div class="col-md-4 ">

              </div>
              <div class="col-sm-4 invoice-col mt-2" style="text-align: right;">
                Kepada <br>
                <strong><?php echo $customer; ?></strong><br>
                <?php echo $address; ?><br>
                Telp : <?php echo $nohp; ?>
              </div>
            </div>
            <div class="row mb-2">
              <?php
              error_reporting(E_ALL ^ E_DEPRECATED);

              $sql    = "select * from $tabeldatabase where nota ='$nota' order by no";
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
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Total Qty</th>
                        <th>Product</th>
                        <th>Price/item</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    while (($count < $rpp) && ($i < $tcount)) {
                      mysqli_data_seek($result, $i);
                      $fill = mysqli_fetch_array($result);
                    ?>
                      <tbody>
                        <tr>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah_satuan']); ?> <?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']) . " "; ?><?php echo mysqli_real_escape_string($conn, $fill['satuan_jual']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total_satuan'])); ?> <?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                          <td>Rp. <?php echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                          <td>Rp. <?php echo mysqli_real_escape_string($conn, number_format(($fill['jumlah'] * $fill['harga']), $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                        </tr>


                      <?php
                      $i++;
                      $count++;
                    }

                      ?>
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <?php if ($status == 'belum') { ?>
                <div class="col-lg-6">
                  <p class="text-muted">Keterangan : <?php echo $keterangan; ?></p>
                  <p class="lead">Jatuh Tempo <?php echo $due; ?></p>
                </div>
              <?php } else { ?>
                <div class="col-lg-6 mb-2">
                  <h4></h4>
                </div>
              <?php } ?>

              <?php function penyebut($nilai)
              {
                $nilai = abs($nilai);
                $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                $temp = "";
                if ($nilai < 12) {
                  $temp = " " . $huruf[$nilai];
                } else if ($nilai < 20) {
                  $temp = penyebut($nilai - 10) . " belas";
                } else if ($nilai < 100) {
                  $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
                } else if ($nilai < 200) {
                  $temp = " seratus" . penyebut($nilai - 100);
                } else if ($nilai < 1000) {
                  $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
                } else if ($nilai < 2000) {
                  $temp = " seribu" . penyebut($nilai - 1000);
                } else if ($nilai < 1000000) {
                  $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
                } else if ($nilai < 1000000000) {
                  $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
                } else if ($nilai < 1000000000000) {
                  $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
                } else if ($nilai < 1000000000000000) {
                  $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
                }
                return $temp;
              }

              function terbilang($nilai)
              {
                if ($nilai < 0) {
                  $hasil = "minus " . trim(penyebut($nilai));
                } else {
                  $hasil = trim(penyebut($nilai));
                }
                return $hasil;
              }
              ?>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <th>Sub Total:</th>
                    <td>Rp. <?php echo number_format($totalprice, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                  </tr>
                  <tr>
                    <th>PPn(<?php echo $diskon; ?>)%:</th>
                    <td>Rp. <?php echo number_format($pot, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                  </tr>
                  <tr>
                    <th>Kirim Tambahan:</th>
                    <td>Rp. <?php echo number_format($biaya, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td><b>Rp. <?php echo number_format($totalall, $decimal, $a_decimal, $thousand) . ',-'; ?></b></td>
                  </tr>
                  <tr>
                    <th>Terbilang:</th>
                    <td><b><?php echo terbilang($totalall); ?> rupiah</b></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-3">
                <a href="print_jual?nota=<?php echo $nota; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-printer"></i> Print</a>
              </div>
            </div>
            <!-- </section> -->
            <!-- </div> -->
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



      <!-- Modal Hutang -->

      <div class="modal fade" id="modal-hutang">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Hutang Penjualan #<?php echo $nota; ?></h4>
            </div>
            <div class="modal-body">


              <form method="post">
                <input type="hidden" class="form-control" value="<?php echo $nota; ?>" id="nota" name="nota">
                <div class="row">




                  <div class="form-group col-md-8 col-xs-12">
                    <label for="nama" class="col-sm-3 control-label">Debitur:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="debitur" value="<?php echo $customer; ?>" readonly>
                    </div>
                  </div>
                </div>



                <div class="row">
                  <div class="form-group col-md-8 col-xs-12">
                    <label for="nama" class="col-sm-3 control-label">Jatuh Tempo:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="datepicker" name="ref">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-8 col-xs-12">
                    <label for="nama" class="col-sm-3 control-label">Jumlah:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="jml" name="jml" value="<?php echo $totalprice; ?>" readonly>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="form-group col-md-8 col-xs-12">
                    <label for="nama" class="col-sm-3 control-label">Keterangan:</label>
                    <div class="col-sm-9">
                      <textarea style="width:100%"></textarea>
                    </div>
                  </div>
                </div>

                <input type="hidden" class="form-control" id="jml1" name="jml1" value="<?php echo $totalprice; ?>" readonly>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
              <button type="submit" name="save" class="btn btn-primary">Simpan</button>
            </div>
          </div>

          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
  </div>


  <!-- ./wrapper -->

  <!-- Script -->
  <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

  <!-- jQuery UI -->
  <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
  <script src='jquery-ui.min.js' type='text/javascript'></script>

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
  <?php footer() ?>