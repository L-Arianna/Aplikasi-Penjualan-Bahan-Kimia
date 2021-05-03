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

$sql3 = "SELECT * FROM update_pelanggan where kode='$pelanggan' ";
$hasil3 = mysqli_query($conn, $sql3);
$row = mysqli_fetch_assoc($hasil3);

$kode_new = $row['kode'];
$customer_new = $row['nama'];
$nohp_new = $row['nohp'];
$address_new = $row['alamat'];

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
			font-size: 15px;
		}



		/* Create three equal columns that floats next to each other */
		.column {
			float: left;
			width: 28%;
			padding: 15px;
		}

		small,
		.date {
			text-align: right;
		}

		/* Clear floats after the columns */
		.row:after {
			content: "";
			display: table;
			clear: both;
		}

		table {
			border: solid thin #000;
			border-collapse: collapse;

		}

		/* td,
		th {
			padding: 3mm 6mm;
			text-align: left;
			vertical-align: top;
		}

		th {
			font-weight: bold;
		} */
		table,
		td,
		th {
			border: 1px solid black;
			/* text-align: right; */
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}
	</style>
</head>

<body>
	<div class="row">
		<div class="date">
			<small>SURAT JALAN || Date: <?php echo $today; ?></small>
		</div>

		<div class="column">
			<h4><?php echo $namapt; ?></h4>
			From : <br>
			<strong> <?php echo $namapt; ?></strong><br>
			<?php echo $alamatpt; ?><br>
			Phone: <?php echo $notelppt; ?><br>
			<b>No Surat Jalan : <?= $no_surat ?></b><br>
			<b>No PO : <?= $noPO ?></b><br>
		</div>
		<div class="column">
			<p>
			<p>
			<p>
		</div>
		<div class="column">
			<p>
			<p>
			<p>
				To : <br>
				<?php
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
	</div>
	<br>
	<br>
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
	<br>
	<br>
	<br>
	<br>
	<div class="row">
		<div class="column">
			Tanda Terima : <br>
			<?php if ($kode_new == null) { ?>
				<strong><?php echo $customer; ?></strong><br>
			<?php } elseif ($kode_new > 0) { ?>
				<strong><?php echo $customer_new; ?></strong><br>
			<?php } ?>
		</div>
		<div class="column">
			<p>
			<p>
			<p>
		</div>
		<div class="column">
			Hormat Kami :<br>
			<br>
			<br>
			<br>
			<strong>(----------------------)</strong>
		</div>
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
// 50,50,50,50,10,10