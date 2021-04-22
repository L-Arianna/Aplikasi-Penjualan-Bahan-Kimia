<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PT. Kurnia Makmur| Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dist/ico/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/ico/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>



<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


include "configuration/config_chmod.php";
include "configuration/config_connect.php";
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

$sql1 = "SELECT * FROM $tabel where nota='$nota'";
$hasil1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($hasil1);

$bayar = $row['kasir'];
$total = $row['total'];
$status = $row['status'];
$keterangan = $row['keterangan'];
$pelanggan = $row['pelanggan'];
$diskon = $row['diskon'];
$pot = $row['potongan'];
$biaya = $row['biaya'];
$totalprice = $total + $pot - $biaya;

$tglbayar = date("d-m-Y", strtotime($row['tglsale']));

$due = date("d-m-Y", strtotime($row['duedate']));

$sql1 = "SELECT * FROM sale where nota='$nota' ";
$hasil1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($hasil1);
$customer = $row['pelanggan'];
$nohp = $row['no_hp'];
$address = $row['alamat'];
$noPO = $row['no_po'];
$faktur_pajak = $row['faktur_pajak'];
$no_surat = $row['no_surat_jalan'];
$namapt = $row['nama_pt'];
$alamatpt = $row['alamat_pt'];
$notelppt = $row['no_tlp'];

?>


<body onload="window.print();">
  <!--   -->
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?php echo $namapt; ?>
            <small class="pull-right">Date: <?php echo $today; ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?php echo $namapt; ?></strong><br>
            <?php echo $alamatpt; ?><br>
            Phone: <?php echo $notelppt; ?><br>
            <strong>Faktur Pajak: <?= $faktur_pajak ?></strong><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $customer; ?></strong><br>
            <?php echo $address; ?><br>
            Phone: <?php echo $nohp; ?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #<?php echo $nota; ?></b><br>
          <b>Payment Due:</b> <?php echo $due; ?><br>
          <b>No PO: <?= $noPO ?></b><br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
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
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Qty</th>
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
                  <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
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
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <?php if ($status == 'belum') { ?>
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <p class="lead">Payment Options:</p>
            <?php
            $query1 = "SELECT * FROM  rekening order by no ";
            $hasil = mysqli_query($conn, $query1);
            while ($fill = mysqli_fetch_assoc($hasil)) {
            ?>
              <p><strong><?php echo $fill['bank']; ?>:</strong> <?php echo $fill['norek']; ?> A.n <?php echo $fill['nama']; ?></p>
            <?php } ?>

            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              <?php echo $keterangan; ?>
            </p>
          </div>
          <div class="col-xs-6">
            <p class="lead"></p>
          </div>
        <?php } else { ?>

          <div class="col-xs-6">

            <img src="dist/img/lunas.png" alt="Visa">

          </div>
          <div class="col-xs-6">
            <p class="lead">Paid</p>
          </div>

        <?php } ?>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead"></p>
          <?php

          // FUNGSI TERBILANG OLEH : MALASNGODING.COM
          // WEBSITE : WWW.MALASNGODING.COM
          // AUTHOR : https://www.malasngoding.com/author/admin


          function penyebut($nilai)
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

          <table class="table">
            <tr>
              <th>Sub Total:</th>
              <td>Rp. <?php echo number_format($totalprice, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
            </tr>
            <tr>
              <th>PPn(<?php echo $diskon; ?>)%:</th>
              <td>Rp. <?php echo number_format($pot, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
            </tr>
            <tr>
              <th>Biaya Kirim:</th>
              <td>Rp. <?php echo number_format($biaya, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><b>Rp. <?php echo number_format($total, $decimal, $a_decimal, $thousand) . ',-'; ?></b></td>
            </tr>
            <tr>
              <th>Terbilang:</th>
              <td><b><?php echo terbilang($total); ?> rupiah</b></td>
            </tr>
          </table>

        </div>
      </div>
      <!-- /.col -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <H4 align="center"><?php echo $signature ?><H4>
      <!-- ./wrapper -->
</body>

</html>