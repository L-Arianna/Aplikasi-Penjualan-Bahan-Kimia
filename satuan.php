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
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">

		<!-- SETTING START-->

		<?php
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		include "configuration/config_chmod.php";
		$halaman = "satuan"; // halaman
		$dataapa = "Satuan"; // data
		$tabeldatabase = "satuan"; // tabel database
		$chmod = $chmenu3; // Hak akses Menu
		$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
		$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
		$search = $_POST['search'];

		?>
		<script>
			window.setTimeout(function() {
				$("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
					$(this).remove();
				});
			}, 5000);
		</script>

		<?php
		$hapusberhasil = $_POST['hapusberhasil'];

		if ($hapusberhasil == 1) {
		?>
			<div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Berhasil!</strong> <?php echo $dataapa; ?> telah berhasil dihapus dari Data <?php echo $dataapa; ?>.
			</div>

			<!-- BOX HAPUS BERHASIL -->
		<?php
		} elseif ($hapusberhasil == 2) {
		?>
			<div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Gagal!</strong> <?php echo $dataapa; ?> tidak bisa dihapus dari Data <?php echo $dataapa; ?> karena telah melakukan transaksi sebelumnya, gunakan menu update untuk merubah informasi <?php echo $dataapa; ?> .
			</div>
		<?php
		} elseif ($hapusberhasil == 3) {
		?>
			<div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Gagal!</strong> Hanya user tertentu yang dapat mengupdate Data <?php echo $dataapa; ?> .
			</div>
		<?php
		}

		?>
		<!-- BOX INFORMASI -->
		<?php
		if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') {
		} elseif ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'user') { ?>
		<?php
		} else { ?>
			<div class="callout callout-danger">
				<h4>Info</h4>
				<b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
			</div>
		<?php }
		?>
		<div class="row mb-2">

			<form method="post" action="">
				<div class="col-lg-12 d-flex justify-content-end">
					<div class="ms-auto">
						<div class="btn-group">
							<div class="input-group">
								<input type="text" name="search" class="form-control radius-30" placeholder="cari">
								<button type="submit" class="btn btn-primary btn-sm radius-30"><i class="bx bx-search"></i></button>
							</div>
						</div>
						<a href="add_satuan" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i>Tambah Satuan</a>

					</div>
				</div>
			</form>
		</div>
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
					<h6 class="mb-0 text-uppercase">Data <?php echo $forward ?>
					</h6>
				</div>
				<?php
				error_reporting(E_ALL ^ E_DEPRECATED);
				$sql    = "select * from $forward order by no";
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
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode</th>
									<th>Nama satuan</th>
									<th>Converter satuan</th>
									<th>Jumlah satuan</th>
									<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
										<th>Opsi</th>
									<?php } else {
									} ?>
								</tr>
							</thead>
							<?php
							error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
							$search = $_POST['search'];

							if ($search != null || $search != "") {

								if ($_SERVER["REQUEST_METHOD"] == "POST") {

									if (isset($_POST['search'])) {
										$query1 = "SELECT * FROM  $forward where kode like '%$search%' or nama like '%$search%' order by no limit $rpp";
										$hasil = mysqli_query($conn, $query1);
										$no = 1;
										while ($fill = mysqli_fetch_assoc($hasil)) {
							?>
											<tbody>
												<tr>
													<td><?php echo ++$no_urut; ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['convert']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
													<td>
														<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
															<button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
														<?php } else {
														} ?>

														<?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
															<button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
														<?php } else {
														} ?>
													</td>
												</tr><?php } ?>
											</tbody>
						</table>
					</div>
					<div align="right"><?php if ($tcount >= $rpp) {
													echo paginate_one($reload, $page, $tpages);
												} else {
												} ?></div>
				<?php
									}
								}
							} else {
								while (($count < $rpp) && ($i < $tcount)) {
									mysqli_data_seek($result, $i);
									$fill = mysqli_fetch_array($result);
				?>
				<tbody>
					<tr>
						<td><?php echo ++$no_urut; ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['convert']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
						<td>
							<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
								<button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
							<?php } else {
									} ?>

							<?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
								<button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
							<?php } else {
									} ?>
						</td>
					</tr>
				<?php
									$i++;
									$count++;
								}

				?>
				</tbody>
				</table>
				<div align="right"><?php if ($tcount >= $rpp) {
												echo paginate_one($reload, $page, $tpages);
											} else {
											} ?></div>
			<?php } ?>

				</div>
				<!-- /.box-body -->
			</div>

		<?php } elseif ($chmod >= 1 || $_SESSION['jabatan'] == 'user') { ?>

			<?php

			$sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
			$hasila = mysqli_query($conn, $sqla);
			$rowa = mysqli_fetch_assoc($hasila);
			$totaldata = $rowa['totaldata'];

			?>


			<div class="card">
				<div class="card-header">
					<h6 class="mb-0 text-uppercase">Data <?php echo $forward ?>
					</h6>
				</div>
				<?php
				error_reporting(E_ALL ^ E_DEPRECATED);
				$sql    = "select * from $forward order by no";
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
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode</th>
									<th>Nama satuan</th>
									<th>Converter satuan</th>
									<th>Jumlah satuan</th>
									<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') { ?>
										<th>Opsi</th>
									<?php } else {
									} ?>
								</tr>
							</thead>
							<?php
							error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
							$search = $_POST['search'];

							if ($search != null || $search != "") {

								if ($_SERVER["REQUEST_METHOD"] == "POST") {

									if (isset($_POST['search'])) {
										$query1 = "SELECT * FROM  $forward where kode like '%$search%' or nama like '%$search%' order by no limit $rpp";
										$hasil = mysqli_query($conn, $query1);
										$no = 1;
										while ($fill = mysqli_fetch_assoc($hasil)) {
							?>
											<tbody>
												<tr>
													<td><?php echo ++$no_urut; ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['convert']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
													<td>
														<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') { ?>
															<button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
														<?php } else {
														} ?>

														<?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'user') { ?>
															<button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
														<?php } else {
														} ?>
													</td>
												</tr><?php } ?>
											</tbody>
						</table>
					</div>
					<div align="right"><?php if ($tcount >= $rpp) {
													echo paginate_one($reload, $page, $tpages);
												} else {
												} ?></div>
				<?php
									}
								}
							} else {
								while (($count < $rpp) && ($i < $tcount)) {
									mysqli_data_seek($result, $i);
									$fill = mysqli_fetch_array($result);
				?>
				<tbody>
					<tr>
						<td><?php echo ++$no_urut; ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['convert']); ?></td>
						<td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
						<td>
							<?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') { ?>
								<button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
							<?php } else {
									} ?>

							<?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'user') { ?>
								<button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
							<?php } else {
									} ?>
						</td>
					</tr>
				<?php
									$i++;
									$count++;
								}

				?>
				</tbody>
				</table>
				<div align="right"><?php if ($tcount >= $rpp) {
												echo paginate_one($reload, $page, $tpages);
											} else {
											} ?></div>
			<?php } ?>

				</div>
				<!-- /.box-body -->
			</div>
		<?php } ?>
	</div>
	<!-- ./col -->
</div>


<!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dist/plugins/jQuery/jquery-ui.min.js"></script>
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
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>

</body>

</html>
<?php footer(); ?>