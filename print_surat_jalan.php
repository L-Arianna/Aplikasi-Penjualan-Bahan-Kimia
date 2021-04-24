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


<body onload="window.print();">
	<!--   -->
	<div class="wrapper">
		<!-- Main content -->
		<section class="invoice">
			<!-- title row -->
			<div class="row">
				<div class="col-lg-12">
					<h2 class="page-header">
						<i class="fa fa-globe"></i> <?php echo $namapt; ?>
						<small class="pull-right">SURAT JALAN || Date: <?php echo $today; ?></small>
					</h2>
				</div>
				<!-- /.col -->
			</div>
			<!-- info row -->
			<div class="row mb-2">
				<div class="col-sm-4 invoice-col">
					FROM:
					<address>
						<strong> <?php echo $namapt; ?></strong><br>
						<?php echo $alamatpt; ?><br>
						Phone: <?php echo $notelppt; ?><br>
						<b>No Surat Jalan : <?= $no_surat ?></b><br>
						<b>No PO : <?= $noPO ?></b><br>
					</address>
				</div>
				<!-- /.col -->
				<div class="col-sm-4 invoice-col">

				</div>
				<!-- /.col -->
				<div class="col-sm-4 invoice-col">
					To : <br>
					<?php
					$sql3 = "SELECT * FROM update_pelanggan where kode='$pelanggan' ";
					$hasil3 = mysqli_query($conn, $sql3);
					$row = mysqli_fetch_assoc($hasil3);

					$kode_new = $row['kode'];
					$customer_new = $row['nama'];
					$nohp_new = $row['nohp'];
					$address_new = $row['alamat'];

					if ($kode_new == null) { ?>
						<strong> <?php echo $customer; ?></strong><br>
						<?php echo $address; ?><br>
						Phone: <?php echo $nohp; ?><br>
					<?php } elseif ($kode_new > 0) { ?>
						<strong> <?php echo $customer_new; ?></strong><br>
						<?php echo $address_new; ?><br>
						Phone: <?php echo $nohp_new; ?><br>
					<?php } ?>
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
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Packing</th>
								<th>Qty</th>
								<th>Total Qty </th>
								<th>Product</th>
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
			<div class="col-lg-12">
				<table class="table table-print">
					<thead>
						<tr>
							<th>Tanda terima </th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>Hormat Kami</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php if ($kode_new == null) { ?>
									<strong><?php echo $customer; ?></strong><br>
								<?php } elseif ($kode_new > 0) { ?>
									<strong><?php echo $customer_new; ?></strong><br>
								<?php } ?>
							</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="4">
								<table class="table mb-10">
									<br>
									<br>
									<br>
									<br>
									<br>
									<u>(------------------------------)</u>
								</table>
							</td>
						</tr>
					</tbody>
				</table>



		</section>
		<!-- /.content -->
	</div>
	<H4 align="center"><?php echo $signature ?><H4>
			<!-- ./wrapper -->
</body>

</html>