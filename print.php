<?php ob_start(); ?>
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
date_default_timezone_set("Asia/Jakarta");
$now = date('Y-m-d');
?>
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "report_pelanggan"; // halaman
$dataapa = "Cetak Transaksi Pelanggan"; // data
$tabeldatabase = "sale"; // tabel database
$tabel = "invoicejual"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$today = date('Y-m-d');
?>
<html>

<head>

	<style>
		table {
			border: solid thin #000;
			border-collapse: collapse;
			/* border: 1px solid black; */
			/* margin: auto;
			align-items: center; */
			table-layout: fixed;
			width: 630px;
		}


		td,
		th {
			padding: 3px 6px;
			/* text-align: left;
			vertical-align: top; */
			border: 1px solid black;
			word-wrap: break-word;

		}

		th {
			background-color: #F5F5F5;
			font-weight: bold;
			border: 1px solid black;
		}

		/* 
		table {
			border: 1px solid black;
			border-collapse: collapse;
			table-layout: fixed;
			width: 630px;
		}

		table td {
			border: 1px solid black;
			word-wrap: break-word;
			width: 20%;
		} */
	</style>
</head>

<body>
	<?php
	if (isset($_GET['filter']) && !empty($_GET['filter'])) {
		$filter = $_GET['filter'];

		if ($filter == '1') {
			$tgl = date('d-m-y', strtotime($_GET['tanggal']));

			echo '<b>Data Transaksi Tanggal ' . $tgl . '</b> <br>';


			$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE DATE(tglsale)='" . $_GET['tanggal'] . "'";
		} else if ($filter == '2') {
			$nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
			echo '<b>Data Transaksi Bulan ' . $nama_bulan[$_GET['bulan']] . ' ' . $_GET['tahun'] . '</b> <br>';

			$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE MONTH(tglsale)='" . $_GET['bulan'] . "' AND YEAR(tglsale)='" . $_GET['tahun'] . "'";
		} elseif ($filter == '3') {
			echo '<b>Data Transaksi Tahun ' . $_GET['tahun'] . '</b> <br>';
			$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE YEAR(tglsale)='" . $_GET['tahun'] . "'";
		} else {
			echo '<b>Data Transaksi ' . $_GET['nama'] . '</b> <br>';
			$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE nama='" . $_GET['nama'] . "'";
		}
	} else {
		echo '<b>Semua Data Transaksi</b><br>';
		$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode ORDER BY tglsale";
	}
	?>
	</div>
	</div>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>No.Invoice</th>
				<th>Tgl Transaksi</th>
				<th>Pelanggan</th>
				<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
					<!-- <th>Opsi</th> -->
				<?php } else {
				} ?>
			</tr>
		</thead>

		<?php
		$sql = mysqli_query($conn, $query);
		$row = mysqli_num_rows($sql);

		if ($row > 0) {
			while ($data = mysqli_fetch_array($sql)) {
				$tgl = date('d-m-Y', strtotime($data['tglsale'])) ?>
				<tbody>
					<tr>
						<td><?php echo ++$no_urut; ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $data['nomor']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $tgl); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $data['nama']); ?></td>

					</tr>
				</tbody>
		<?php }
		} else { // Jika data tidak ada
			echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
		}
		?>
	</table>
</body>

</html>
<?php
$html = ob_get_contents();
ob_end_clean();






require_once "./assets/vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage("P", "", "", "", "", "15", "15", "15", "15", "", "", "", "", "", "", "", "", "", "", "", "A5");
$mpdf->WriteHTML($html);
$mpdf->Output();
