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

			$sql1 = "SELECT * FROM $tabel where nota='$nota'";
			$hasil1 = mysqli_query($conn, $sql1);
			$row = mysqli_fetch_assoc($hasil1);


			$tglbayar = date("d-m-Y", strtotime($row['tglsale']));

			$due = date("d-m-Y", strtotime($row['duedate']));



			$bayar = $row['kasir'];
			$total = $row['total'];
			$keterangan = $row['keterangan'];
			$pelanggan = $row['pelanggan'];
			$status = $row['status'];
			$diskon = $row['diskon'];
			$pot = $row['potongan'];
			$biaya = $row['biaya'];
			$totalprice = $total + $pot - $biaya;

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
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Data <?php echo $dataapa; ?></div>
				<div class="ps-3">
				</div>
				<div class="ms-auto">
					<div class="btn-group">
						<a href="print_detail?nota=<?php echo $nota; ?>" target="_blank" class="btn btn-primary btn-sm radius-30 px-4"><i class="bx bx-printer"></i>Print</a>
					</div>
					<a href="report_pelanggan" class="btn btn-secondary btn-sm radius-30 px-4"><i class="bx bx-arrow-back"></i>Kembali</a>
				</div>
			</div>


			<?php
			if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
			?>



				<!-- KONTEN BODY AWAL -->
				<div class="card">
					<div class="card-body table-responsive">
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
									<th>Tanggal</th>
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
										<td><?= $tglbayar ?></td>
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
	</div>
	<?php footer() ?>