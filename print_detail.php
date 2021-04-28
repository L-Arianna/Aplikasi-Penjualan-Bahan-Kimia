<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


include "configuration/config_chmod.php";
include "configuration/config_connect.php";
$halaman = "print_detail"; // halaman
$dataapa = "Detail Transaksi Pelanggan"; // data
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
$nomor = $row['nomor'];
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
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $dataapa ?></title>
	<style type="text/css" media="print">
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			font-size: 16px;
		}

		.cetak {
			width: 22cm;
			height: 14cm;
			padding: 1cm;
		}

		table {
			/* border: solid thin #000; */
			border: 1px solid black;
			border-collapse: collapse;
			margin: auto;
			align-items: center;
		}


		td,
		th {
			padding: 7px 29px;
			text-align: left;
			vertical-align: top;
			border: 1px solid black;
		}

		th {
			background-color: #F5F5F5;
			font-weight: bold;
			/* border: 1px solid black; */
		}

		h1 {
			text-align: center;
			text-transform: uppercase;
		}
	</style>
	<style type="text/css" media="screen">
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			font-size: 12px;
		}

		.cetak {
			width: 15cm;
			height: 20cm;
			padding: 1cm;
		}

		table {
			border: solid thin #000;
			border-collapse: collapse;

		}

		td,
		th {
			padding: 3mm 6mm;
			text-align: left;
			vertical-align: top;
		}

		th {
			background-color: #F5F5F5;
			font-weight: bold;
		}


		h1 {
			text-align: center;
			text-transform: uppercase;
		}
	</style>

</head>

<body onload="print()">
	<div class="cetak">
		<h1><?= $dataapa ?></h1>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="20%">NAMA PELANGGAN</th>
					<th><?= $customer ?> </th>
				</tr>
				<tr>
					<th width="20%">KODE TRANSAKSI</th>
					<th><?= $nomor ?> </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>TANGGAL</td>
					<td> <?= $tglbayar ?></td>
				</tr>
				<tr>
					<td>JUMLAH TOTAL</td>
					<td>Rp. <?= number_format($totalprice) ?> </td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
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
			<thead>
				<tr>
					<th>SATUAN</th>
					<th>QTY</th>
					<th>TOTAL QTY</th>
					<th>PRODUK</th>
					<th>PRICE/ITEM</th>
					<th>SUB TOTAL</th>
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
						<td>Rp. <?php echo mysqli_real_escape_string($conn, number_format($fill['harga'])); ?></td>
						<td>Rp. <?php echo mysqli_real_escape_string($conn, number_format(($fill['jumlah'] * $fill['harga']))); ?></td>
					</tr>
				<?php
				$i++;
				$count++;
			}
				?>
				</tbody>
		</table>
	</div>
</body>

</html>