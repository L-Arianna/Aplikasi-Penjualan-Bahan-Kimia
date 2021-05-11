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
<div class="page-wrapper">
  <div class="page-content">

    <h6 class="mb-0 text-uppercase"></h6>
    <hr />
    <div class="card">
      <div class="card-body">
        <!-- ./col -->

        <!-- SETTING START-->

        <?php
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        include "configuration/config_chmod.php";
        $halaman = "bayar_inv"; // halaman
        $dataapa = "Penjualan"; // data
        $tabeldatabase = "barang"; // tabel database
        $chmod = $chmenu5; // Hak akses Menu
        $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
        $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
        $search = $_POST['search'];
        $insert = $_POST['insert'];
        $nota = $_GET['nota'];

        ?>


        <!-- SETTING STOP -->
        <?php

        if ($nota == null || $nota == "") {

          $sqle = "SELECT SUM(hargaakhir) as data FROM invoicejual WHERE nota='$nota' ";
          $hasile = mysqli_query($conn, $sqle);
          $row = mysqli_fetch_assoc($hasile);
          $datatotal = $row['data'];

          $sqle = "SELECT SUM(modal) as data FROM invoicejual WHERE nota='$nota'";
          $hasile = mysqli_query($conn, $sqle);
          $row = mysqli_fetch_assoc($hasile);
          $databelitotal = $row['data'];
        } else {

          $sqle = "SELECT SUM(hargaakhir) as data FROM invoicejual WHERE nota='$nota'";
          $hasile = mysqli_query($conn, $sqle);
          $row = mysqli_fetch_assoc($hasile);
          $datatotal = $row['data'];

          $sqle = "SELECT SUM(modal) as data FROM invoicejual WHERE nota='$nota'";
          $hasile = mysqli_query($conn, $sqle);
          $row = mysqli_fetch_assoc($hasile);
          $databelitotal = $row['data'];
        }

        ?>

        <!-- BREADCRUMB -->
        <?php
        //menyimpan ke tabel bayar
        if (isset($_POST["simpan"])) {
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
            $nomor = mysqli_real_escape_string($conn, $_POST["nomor"]);
            $duedate = mysqli_real_escape_string($conn, $_POST["duedate"]);
            $diskon = mysqli_real_escape_string($conn, $_POST["diskon"]);
            $pot = mysqli_real_escape_string($conn, $_POST["potongan"]);
            $biaya = mysqli_real_escape_string($conn, $_POST["biaya"]);
            $total = mysqli_real_escape_string($conn, $_POST["total"]);
            $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
            $pelanggan = mysqli_real_escape_string($conn, $_POST["pelanggan"]);
            $faktur_pajak = mysqli_real_escape_string($conn, $_POST["faktur_pajak"]);
            $no_po = mysqli_real_escape_string($conn, $_POST["no_po"]);
            $no_surat_jalan = mysqli_real_escape_string($conn, $_POST["no_surat_jalan"]);
            $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
            $databelitotal = mysqli_real_escape_string($conn, $_POST["beli"]);



            $kasir = $_SESSION["username"];
            $berhasil = "berhasil";
            $belum = "belum";
            $kirim = "belum";
            $insert = ($_POST["insert"]);


            $sql = "select * from sale where nota='$kode'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {

              echo "<script type='text/javascript'>  alert('Data penjualan yang sudah ada tidak bisa diubah!');</script>";
            } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {

              $sql2 = "insert into sale values( '$nota','$nomor','$tglnota','$duedate','$total','$diskon','$pot','$biaya','$pelanggan','$kasir','$keterangan','','$belum','$kirim', '$faktur_pajak', '$no_po', '$no_surat_jalan')";
              $insertan = mysqli_query($conn, $sql2);

              //update mutasi
              $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$nota'";
              $updatemutasi = mysqli_query($conn, $sql3);


              echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
              echo "<script type='text/javascript'>window.location = 'penjualan';</script>";
              // echo print_r($sql2);
            } else {
              echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan pembayaran benar');</script>";
            }
          }
        }


        ?>

        <!-- BREADCRUMB -->

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
          <!-- Default box -->
          <div class="col-lg-12">
            <div class="main box">



              <div class="row">


                <div class="box-body col-lg">


                  <!--tabel-->

                  <div class="box-body no-padding">
                    <?php

                    error_reporting(E_ALL ^ E_DEPRECATED);

                    $sql    = "select * from invoicejual where nota ='$nota' order by no";
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
                          <th>No</th>
                          <th>Nama Barang</th>
                          <th>Total Satuan</th>
                          <th>Jumlah Jual</th>
                          <th>Satuan Terjual</th>
                          <th>Total</th>
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
                            <td><?php echo ++$no_urut; ?></td>

                            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah_satuan']) . " "; ?><?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?> * <?php echo mysqli_real_escape_string($conn, $fill['jumlah']) . " "; ?><?php echo mysqli_real_escape_string($conn, $fill['satuan_jual']); ?> </td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> * <?php echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, number_format(($fill['total_satuan']))) ?> <?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?> </td>
                            <td><?php echo mysqli_real_escape_string($conn, number_format(($fill['jumlah'] * $fill['harga']), $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                          </tr>
                        <?php
                        $i++;
                        $count++;
                      }

                        ?>
                        </tbody>


                    </table>
                  </div>
                  <!--end tabel-->


                </div>

                <div class="box-body">
                  <div class="col-lg">
                    <script>
                      function sum1() {
                        var txtFirstNumberValue = document.getElementById('subtotal').value
                        var txtSecondNumberValue = document.getElementById('diskon').value;
                        var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
                        if (!isNaN(result)) {
                          document.getElementById('total').value = result;

                        }
                        if (!$(bayar).val()) {
                          document.getElementById('total').value = "0";
                        }
                        if (!$(total).val()) {
                          document.getElementById('total').value = "0";
                        }
                      }
                    </script>


                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                      <form method="post" id="Myform" class="form-user">

                        <table class="table table-striped">
                          <tr>



                            <th>Sub total</th>
                            <input type="hidden" value="<?php echo $nota; ?>" class="form-control" name="nota">
                            <input type="hidden" value="<?php echo $datatotal; ?>" class="form-control" id="subtotal">
                            <input type="hidden" value="<?php echo $databelitotal; ?>" class="form-control" name="beli">


                            <th><input type="text" value="<?php echo number_format($datatotal, $decimal, $a_decimal, $thousand) . ',-'; ?>" class="form-control" readonly></th>
                          </tr>
                          <tr>

                            <script>
                              function sum1() {
                                var txtFirstNumberValue = document.getElementById('subtotal').value
                                var txtSecondNumberValue = document.getElementById('diskon').value;

                                var diskon = (parseFloat(txtFirstNumberValue) / 100) * parseFloat(txtSecondNumberValue);

                                var nilaidiskon = Math.round(diskon);

                                var result = parseFloat(txtFirstNumberValue) + parseFloat(nilaidiskon);


                                if (!isNaN(result)) {
                                  document.getElementById('total').value = result;
                                  document.getElementById('tot').value = result;
                                  document.getElementById('potongan').value = nilaidiskon;

                                }
                                if (!$(diskon).val()) {
                                  document.getElementById('total').value = "0";

                                }
                                if (!$(total).val()) {
                                  document.getElementById('total').value = "0";
                                }
                              }
                            </script>

                            <td>PPn(%)</td>

                            <td><input type="text" class="form-control" autocomplete="off" id="diskon" name="diskon" value="0" onkeyup="sum1();" maxlength="3"></td>
                          </tr>
                          <tr>

                            <td>Potongan</td>

                            <td><input type="text" class="form-control" id="potongan" name="potongan" value="0" onkeyup="sum2();" autocomplete="off"></td>
                          </tr>


                          <script>
                            function sum2() {
                              var txtFirstNumberValue = document.getElementById('subtotal').value
                              var txtSecondNumberValue = document.getElementById('potongan').value;

                              var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
                              var diskon = (parseFloat(txtSecondNumberValue) / parseFloat(txtFirstNumberValue)) * 100;
                              var nilaidis = Math.round(diskon);

                              if (!isNaN(result)) {
                                document.getElementById('total').value = result;
                                document.getElementById('tot').value = result;
                                document.getElementById('diskon').value = nilaidis;

                              }
                              if (!$(diskon).val()) {
                                document.getElementById('total').value = "0";

                              }
                              if (!$(total).val()) {
                                document.getElementById('total').value = "0";
                              }
                            }
                          </script>


                          <input type="hidden" class="form-control" id="tot" value="<?php echo number_format($datatotal); ?>">

                          <tr>

                            <td>Biaya Kirim</td>

                            <td><input type="text" class="form-control" value="0" name="biaya" id="biaya" onkeyup="sum3();" autocomplete="off"></td>
                          </tr>
                          <tr>
                            <script>
                              function sum3() {
                                var txtFirstNumberValue = document.getElementById('biaya').value
                                var txtSecondNumberValue = document.getElementById('tot').value;
                                var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
                                if (!isNaN(result)) {
                                  document.getElementById('total').value = result;


                                }
                                if (!$(biaya).val()) {
                                  document.getElementById('total').value = "0";
                                }

                              }
                            </script>


                            <td>Total</td>

                            <td><input type="text" class="form-control" value="<?php echo number_format($datatotal); ?>" id="total" name="total" readonly></td>
                          </tr>
                          <tr>

                            <td>Tanggal Transaksi</td>

                            <td><input type="date" class="form-control" id="datepicker2" name="tglnota"></td>

                          </tr>

                          </tr>
                          <tr>

                            <td>Nomor Invoice</td>

                            <td><input type="text" class="form-control" value="INV<?php echo $nota; ?>" name="nomor"></td>

                          </tr>
                          <tr>

                            <td>Jatuh Tempo</td>

                            <td><input type="date" class="form-control" id="datepicker" name="duedate"></td>
                          </tr>

                          <tr>

                            <td>Pelanggan</td>

                            <td>
                              <select name="pelanggan" class="form-control">
                                <option>Pilih</option>
                                <?php
                                $sql = mysqli_query($conn, "select * from pelanggan");
                                while ($row = mysqli_fetch_assoc($sql)) {
                                  if ($pelanggan == $row['kode'])
                                    echo "<option value='" . $row['kode'] . "' selected='selected'>" . $row['kode'] . " | " . $row['nama'] . "</option>";
                                  else
                                    echo "<option value='" . $row['kode'] . "'>" . $row['kode'] . " | " . $row['nama'] . "</option>";
                                }
                                ?>
                              </select>
                            </td>


                          </tr>

                          <tr>
                            <td>Faktur Pajak</td>
                            <td><input type="text" name="faktur_pajak" class="form-control" required></td>
                          </tr>
                          <tr>
                            <td>Nomor PO</td>
                            <td><input type="text" name="no_po" class="form-control" required></td>
                          </tr>
                          <tr>
                            <td>Nomor Surat Jalan</td>
                            <td><input type="text" name="no_surat_jalan" class="form-control" required></td>
                          </tr>
                          <tr>
                            <td>Keterangan</td>
                            <td><textarea class="form-control" name="keterangan"></textarea> </td>
                          </tr>
                          <table>
                            <tr>
                              <td> <input type="button" class="btn btn-danger btn-sm" onclick="window.open('add_sale','_self')" value="KEMBALI" /> </td>
                              <td><button type="submit" class="btn btn-success btn-sm" name="simpan" onclick=" document.getElementById('Myform').submit();">SIMPAN</button></td>
                            </tr>
                          </table>
                      </form>
                    </div>
                    <!-- /.box-body -->
                  </div>





                </div>

              </div>
              <!-- /.box-body -->
            </div>
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
    $('#datepicker').datepicker('update', new Date());
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