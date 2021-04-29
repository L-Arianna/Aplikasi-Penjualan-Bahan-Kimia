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

			<!-- SETTING START-->

			<?php
			error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			include "configuration/config_chmod.php";
			$halaman = "report_pelanggan"; // halaman
			$dataapa = "Laporan History Pelanggan"; // data
			$tabeldatabase = "sale"; // tabel database
			$tabel = "invoicejual"; // tabel database
			$chmod = $chmenu5; // Hak akses Menu
			$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
			$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
			$today = date('Y-m-d');
			?>

			<?php
			if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') {
			?>

				<?php

				$sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
				$hasila = mysqli_query($conn, $sqla);
				$rowa = mysqli_fetch_assoc($hasila);
				$totaldata = $rowa['totaldata'];

				?>
				<div class="card">
					<div class="card-header">
						<h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
					</div>
					<?php
					error_reporting(E_ALL ^ E_DEPRECATED);
					$sql    = "select * from sale inner join pelanggan on sale.pelanggan=pelanggan.kode order by sale.nota desc";
					// $sql    = "select * from sale order by nota desc";
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






					<div class="card-body table-responsive">


						<div class="row">
							<div class="col-md-6">
								<form method="get" action="">
									<label>Filter Berdasarkan</label><br>
									<select name="filter" id="filter" class="form-control mb-2">
										<option value="">Pilih</option>
										<option value="1">Per Tanggal</option>
										<option value="2">Per Bulan</option>
										<option value="3">Per Tahun</option>
										<option value="4">Per nama</option>
									</select>

									<div id="form-tanggal">
										<label>Tanggal</label><br>
										<input type="text" name="tanggal" class="input-tanggal form-control mb-2" />
									</div>

									<div id="form-nama">
										<label>Nama</label><br>
										<input type="text" name="nama" placeholder="Cari Nama Pembeli" class="form-control mb-2" />
									</div>

									<div id="form-bulan">
										<label>Bulan</label><br>
										<select name="bulan" class="form-control mb-2">
											<option value="">Pilih</option>
											<option value="1">Januari</option>
											<option value="2">Februari</option>
											<option value="3">Maret</option>
											<option value="4">April</option>
											<option value="5">Mei</option>
											<option value="6">Juni</option>
											<option value="7">Juli</option>
											<option value="8">Agustus</option>
											<option value="9">September</option>
											<option value="10">Oktober</option>
											<option value="11">November</option>
											<option value="12">Desember</option>
										</select>

									</div>

									<div id="form-tahun">
										<label>Tahun</label><br>
										<select name="tahun" class="form-control mb-2">
											<option value="">Pilih</option>
											<?php
											$query = "SELECT YEAR(tglsale) AS tahun FROM sale GROUP BY YEAR(tglsale)";
											$sql = mysqli_query($conn, $query);

											while ($data = mysqli_fetch_array($sql)) {
												echo '<option value="' . $data['tahun'] . '">' . $data['tahun'] . '</option>';
											}
											?>
										</select>
									</div>

									<div class="btn-group mb-2">
										<button type="submit" class="btn btn-primary btn-sm radius-30 px-4">Tampilkan</button>
									</div>
									<a href="report_pelanggan" class="btn btn-warning btn-sm radius-30 text-white mb-2">Reset Filter</a>
								</form>


								<?php
								if (isset($_GET['filter']) && !empty($_GET['filter'])) {
									$filter = $_GET['filter'];

									if ($filter == '1') {
										$tgl = date('d-m-y', strtotime($_GET['tanggal']));

										echo '<span class="badge bg-info">Data Transaksi Tanggal ' . $tgl . '</span> <br><br>';
										echo '<a href="print.php?filter=1&tanggal=' . $_GET['tanggal'] . '" class="btn btn-primary btn-sm radius-30">Cetak PDF</a>';

										$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE DATE(tglsale)='" . $_GET['tanggal'] . "'";
									} else if ($filter == '2') {
										$nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

										echo '<span class="badge bg-info">Data Transaksi Bulan ' . $nama_bulan[$_GET['bulan']] . ' ' . $_GET['tahun'] . '</span> <br><br>';
										echo '<a href="print.php?filter=2&bulan=' . $_GET['bulan'] . '&tahun=' . $_GET['tahun'] . '" class="btn btn-primary btn-sm radius-30">Cetak PDF</a>';

										$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE MONTH(tglsale)='" . $_GET['bulan'] . "' AND YEAR(tglsale)='" . $_GET['tahun'] . "'";
									} else if ($filter == '3') {
										$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE MONTH(tglsale)='" . $_GET['bulan'] . "' AND YEAR(tglsale)='" . $_GET['tahun'] . "'";
										echo '<span class="badge bg-info">Data Transaksi Tahun ' . $_GET['tahun'] . '</span> <br><br>';
										echo '<a href="print.php?filter=3&tahun=' . $_GET['tahun'] . '" class="btn btn-primary btn-sm radius-30">Cetak PDF</a>';

										$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE YEAR(tglsale)='" . $_GET['tahun'] . "'";
									} else {
										$query = "SELECT * FROM sale INNER JOIN pelanggan ON sale.pelanggan = pelanggan.kode WHERE nama='" . $_GET['nama'] . "'";

										echo '<span class="badge bg-info">Data Transaksi ' . $_GET['nama'] . '</span> <br><br>';

										echo '<a href="print.php?filter=4&nama=' . $_GET['nama'] . '" class="btn btn-primary btn-sm radius-30">Cetak PDF</a>';
									}
								} else {
									echo '<span class="badge bg-info">Semua Data Transaksi</span> <br><br>';
									echo '<a href="print.php" class="btn btn-primary btn-sm radius-30">Cetak PDF</a>';

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
										<th>Opsi</th>
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
											<td>
												<a type="button" class="btn btn-info btn-sm radius-30 px-4" onclick="window.location.href='history_detail?nota=<?php echo $data['nota'] ?>'">View Detail</a>
											</td>
										</tr>
									</tbody>
							<?php }
							} else { // Jika data tidak ada
								echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
							}
							?>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			<?php } ?>
		</div>
	</div>


	<?php footer(); ?>