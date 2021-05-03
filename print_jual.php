<?php ob_start(); ?>
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
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      /* margin: 10; */
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      width: 24cm;
      height: 28cm;
      font-size: 16px;
      padding: 10px;
    }

    .column {
      float: left;
      width: 28%;
      padding: 15px;
    }


    small,
    .date {
      text-align: right;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    table,
    td,
    th {
      border: 1px solid white;
      text-align: left;
      /* width: 40px; */
      height: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    .paid,
    .c,
    .b {
      border: 1px solid white;
    }

    .paid {
      width: 100%;
      border-collapse: collapse;
    }

    .right {
      position: absolute;
      right: 30px;
      width: 300px;
      padding: 10px;
    }
  </style>
</head>

<body>

  <div class="row">
    <div class="date">
      <small>Date: <?php echo $today; ?></small>
    </div>
    <div class="column">
      <h4></h4>
      From : <br>
      <strong> <?php echo $namapt; ?></strong><br>
      <?php echo $alamatpt; ?><br>
      Phone: <?php echo $notelppt; ?><br>
      Nomor Invoice #<?php echo $nota; ?><br>
      Faktur Pajak: <?= $faktur_pajak ?>
    </div>
    <div class="column">
      <p>
      <p>
        <!-- <p> -->
    </div>
    <div class="column">
      <p>
      <p>
        <!-- <p> -->
        To : <br>
        <strong><?php echo $customer; ?></strong><br>
        <?php echo $address; ?><br>
        Phone: <?php echo $nohp; ?><br>
        <?php if ($status == 'belum') { ?>
          Status : <br>
          Belum Dibayar<br>
        <?php } else { ?>
          Status : <br>
          Sudah Dibayar
        <?php } ?>
    </div>
  </div>
  <br>

  <!-- <br> -->
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
    <!-- <div class="col-xs-12 table-responsive"> -->
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
            <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
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
    <!-- </div> -->
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
    <!-- <br> -->
  </div>
  <div class="right">
    <table class="paid">
      <tr>
        <th class="b">Sub Total:</th>
        <td class="c">Rp. <?php echo number_format($totalprice, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
      </tr>
      <tr>
        <th class="b">PPn(<?php echo $diskon; ?>)%:</th>
        <td class="c">Rp. <?php echo number_format($pot, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
      </tr>
      <tr>
        <th class="b">Biaya Kirim:</th>
        <td class="c">Rp. <?php echo number_format($biaya, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
      </tr>
      <tr>
        <th class="b">Total:</th>
        <td class="c"><b>Rp. <?php echo number_format($total, $decimal, $a_decimal, $thousand) . ',-'; ?></b></td>
      </tr>
    </table>
  </div>
  <div class="row">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="table">
      <tr>
        <th>Terbilang:</th>
        <td><?php echo terbilang($total); ?> rupiah</td>
      </tr>
    </table>
    <br>
    <br>
    <br>
    <?php if ($status == 'belum') { ?>
      <p class="lead">Payment Options:</p>
      <?php
      $query1 = "SELECT * FROM  rekening order by no ";
      $hasil = mysqli_query($conn, $query1);
      while ($fill = mysqli_fetch_assoc($hasil)) {
      ?>
        <p><strong><?php echo $fill['bank']; ?>:</strong> <?php echo $fill['norek']; ?> A.n <?php echo $fill['nama']; ?></p>
      <?php } ?>
      <p> <?php echo $keterangan; ?> </p>
    <?php } else { ?>

      <p class="lead">Payment Options:</p>
      <?php
      $query1 = "SELECT * FROM  rekening order by no ";
      $hasil = mysqli_query($conn, $query1);
      while ($fill = mysqli_fetch_assoc($hasil)) {
      ?>
        <p><strong><?php echo $fill['bank']; ?>:</strong> <?php echo $fill['norek']; ?> A.n <?php echo $fill['nama']; ?></p>
      <?php } ?>
      Keterangan : <br>
      <p><?php echo $keterangan; ?></p>
    <?php } ?>
    <br>
    <br>
    <br>
    <H6 align="center"><?php echo $signature ?><H6>
  </div>

</body>

</html>
<?php
$html = ob_get_contents();
ob_end_clean();

require_once "./assets/vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage("P", "", "", "", "", "10", "10", "10", "10", "15", "15", "", "", "", "", "", "", "", "", "", "A4");
$mpdf->WriteHTML($html);
$mpdf->Output();
