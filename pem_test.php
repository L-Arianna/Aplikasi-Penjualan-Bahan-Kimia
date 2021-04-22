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
//alltotal();
pagination();
?>
<?php
$decimal = "0";
$a_decimal = ",";
$thousand = ".";
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
		<?php
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		include "configuration/config_chmod.php";
		$halaman = "pembelian"; // halaman
		$dataapa = "Invoice Pembelian"; // data
		$tabeldatabase = "buy"; // tabel database
		$tabel = "invoicebeli"; // tabel database
		$chmod = $chmenu5; // Hak akses Menu
		$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
		$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
		$search = $_POST['search'];

		?>

		<!-- SETTING STOP -->
		<?php
		$decimal = "0";
		$a_decimal = ",";
		$thousand = ".";
		$today = date('Y-m-d');
		?>


		<!-- BREADCRUMB -->

		<ol class="breadcrumb ">
			<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard /</a></li>
			<li><a href="<?php echo $halaman; ?>"><?php echo $dataapa ?> /</a></li>
			<?php

			if ($search != null || $search != "") {
			?>
				<li> <a href="<?php echo $halaman; ?>">Data <?php echo $dataapa ?></a></li>
				<li class="active"><?php
											echo $search;
											?></li>
			<?php
			} else {
			?>
				<li class="active">Data <?php echo $dataapa ?></li>
			<?php
			}
			?>
		</ol>
		<h6 class="mb-0 text-uppercase"></h6>
		<hr />
		<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			<div class="col">
				<div class="card radius-10 bg-primary bg-gradient">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-white">Total Pembelian</p>
								<h4 class="my-1 text-white"><sup style="font-size: 15px">Rp</sup><?php echo number_format($inv11, $decimal, $a_decimal, $thousand); ?></h4>
							</div>
							<div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
							</div>
						</div>
						<div class="d-flex align-items-center">
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10 bg-info bg-aqua">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-white">Total Dibayar</p>
								<h4 class="my-1 text-white"><sup style="font-size: 15px">Rp</sup><?php echo number_format($inv12, $decimal, $a_decimal, $thousand); ?></h4>
							</div>
							<div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
							</div>
						</div>
						<div class="d-flex align-items-center">
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10 bg-danger bg-gradient">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-white">Hutang/Belum Dibayar</p>
								<h4 class="my-1 text-white"><sup style="font-size: 15px">Rp</sup><?php echo number_format($inv11, $decimal, $a_decimal, $thousand); ?></h4>
							</div>
							<div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
							</div>
						</div>
						<div class="d-flex align-items-center">
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10 bg-warning bg-gradient">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-white">Tagihan Jatuh Tempo</p>
								<h4 class="my-1 text-white"><sup style="font-size: 15px">Rp</sup><?php echo number_format($inv13, $decimal, $a_decimal, $thousand); ?></h4>
							</div>
							<div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
							</div>
						</div>
						<div class="d-flex align-items-center">
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			window.setTimeout(function() {
				$("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
					$(this).remove();
				});
			}, 5000);
		</script>

		<?php

		$sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
		$hasila = mysqli_query($conn, $sqla);
		$rowa = mysqli_fetch_assoc($hasila);
		$totaldata = $rowa['totaldata'];

		?>
		<?php
		if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<div class="card">
				<div class="card-header">
					Data <?php echo $dataapa ?>
					<span class="badge bg-danger" id="no-print"> <?php echo $totaldata; ?></span> &nbsp;&nbsp;
				</div>
				<div class="card-body">


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
						<div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Berhasil!</strong> <?php echo $dataapa; ?> tidak bisa dihapus dari Data <?php echo $dataapa; ?> karena telah melakukan transaksi sebelumnya, gunakan menu update untuk merubah informasi <?php echo $dataapa; ?> .
						</div>
					<?php
					} elseif ($hapusberhasil == 8) {
					?>
						<div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Berhasil!</strong> <?php echo $dataapa; ?> telah berhasil diupdate status barangnya, pastikan jangan terima bila barang rusak dan jangan konfirmasi bila belum terima barang!
						</div>
					<?php
					} elseif ($hapusberhasil == 3) {
					?>
						<div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Gagal!</strong> Hanya user tertentu yang dapat mengupdate Data <?php echo $dataapa; ?> .
						</div>
					<?php
					} ?>
					<?php
					if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') {
					} else {
					?>
						<div class="callout callout-danger">
							<h4>Info</h4>
							<b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
						</div>
					<?php
					}
					?>

					<div class="col-lg-12 col-md-12 col-sm-12 no-print">
						<form method="post">
							<div class="col-lg-3 col-md-3 col-sm-3">
							</div>
						</form>
						<div class="col-lg-3 col-md-3 col-sm-3">
							<form method="post">
								<div class="input-group input-group-sm" style="width: 100%;">
									<input type="text" name="search" class="form-control pull-right" placeholder="Cari">
									<div class="input-group-btn">
										<button type="submit" class="btn btn-default"><i class="bx bx-search"></i></button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3">
							<!-- isi -->
						</div>
						<?php
						$sqlw = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(nota) as nt, SUM(totalbeliakhir) as tt FROM pembelian WHERE cabang LIKE '%$cab%' AND status LIKE '%hutang%'")); ?>
						<div class="col-md-6 col-sm-6">
							<small class="text-danger">Barang yang telah dibeli harus diproses dan diterima dulu sebelum masuk kedalam data stok</small>
						</div>
					</div>

					<?php
					error_reporting(E_ALL ^ E_DEPRECATED);
					$sql    = "select * from buy inner join supplier on buy.supplier=supplier.kode order by buy.nota desc";
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
					<div class="table table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Nota</th>
									<th>Due Date</th>
									<th>Supplier</th>
									<th>Total</th>
									<th>Kasir</th>
									<th>Status</th>
									<th>Penerima</th>
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
										$query1 = "SELECT * from buy inner join supplier on buy.supplier=supplier.kode where buy.nota like '%$search%' or supplier.nama like '%$search%' or buy.status like '%$search%' or buy.tglsale <= '$search' order by buy.nota DESC limit $rpp ";
										$hasil = mysqli_query($conn, $query1);
										$no = 1;
										while ($fill = mysqli_fetch_assoc($hasil)) {
							?>
											<tbody>
												<tr>
													<td><?php echo ++$no_urut; ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
													<td><?php $newtgl = date("d-m-Y", strtotime($fill['tglsale']));
															echo mysqli_real_escape_string($conn, $newtgl); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>

													<td><?php echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
													<td><?php echo mysqli_real_escape_string($conn, $fill['diterima']); ?></td>

													<td>



														<?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>

															<?php if ($fill['diterima'] == '') { ?>

																<button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_invoice?nota=<?php echo $fill['nota'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>';myFunction()">Hapus</button>

															<?php } else { ?>

																<button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='pembelian_batal?q=<?php echo $fill['nota']; ?>'">Batal</button>

															<?php } ?>



														<?php } else {
														} ?>
														<?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>

															<?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
																<?php if ($fill['status'] != 'Diterima') { ?>

																	<?php if ($fill['status'] != 'Diterima') { ?>
																		<button type="button" class="btn btn-success btn-xs no-print btn-flat" style="width:55px" onclick="window.location.href='invoice_beli?nota=<?php echo $fill['nota'] ?>'">Proses</button>
														<?php }
																}
															}
														} else {
														} ?>
													</td>
												</tr><?php;
                                  }
                                    ?>
											</tbody>
						</table>
						<div align="right"><?php if ($tcount >= $rpp) {
														echo paginate_one($reload, $page, $tpages);
													} else {
													} ?></div>
					<?php } ?>
					<div class="col-xs-1" align="right">
						<a href="add_buy" class="btn btn-info" role="button">Beli barang</a>
					</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
<?php }
								}
							}
						} ?>
	</div>
</div>
</div>

</div>
<!--end page wrapper -->
<?php footer(); ?>