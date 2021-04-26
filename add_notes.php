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

		<!-- ./col -->

		<!-- SETTING START-->

		<?php
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		include "configuration/config_chmod.php";
		$halaman = "notes"; // halaman
		$dataapa = "notes"; // data
		$tabeldatabase = "notes"; // tabel database
		$chmod = $chmenu3; // Hak akses Menu
		$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
		$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
		$search = $_POST['search'];
		$insert = $_POST['insert'];

		function autoNumber()
		{
			include "configuration/config_connect.php";
			global $forward;
			$query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM $forward ORDER BY kode";
			$result = mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result);
			$id_max = $data['max_id'];
			$sort_num = (int) substr($id_max, 1, 4);
			$sort_num++;
			$new_code = sprintf("%04s", $sort_num);
			return $new_code;
		}
		?>


		<!-- SETTING STOP -->


		<!-- BREADCRUMB -->

		<ol class="breadcrumb ">
			<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
			<li><a href="<?php echo $halaman; ?>"><?php echo $dataapa ?></a></li>
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

		<!-- BREADCRUMB -->

		<!-- BOX INSERT BERHASIL -->

		<script>
			window.setTimeout(function() {
				$("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
					$(this).remove();
				});
			}, 5000);
		</script>

		<!-- BOX INFORMASI -->
		<?php
		if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
		?>
			<hr />
			<!-- KONTEN BODY AWAL -->
			<div class="card">
				<div class="card-header">
					<h3>Data <?php echo $dataapa; ?></h3>
				</div>
				<!-- /.card-header -->

				<div class="card-body">
					<div class="table-responsive">
						<!----------------KONTEN------------------->
						<?php
						error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

						$kode = $nama = $judul = $tgl = $keterangan = "";
						$no = $_GET["no"];
						$insert = '1';



						if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {

							$sql = "select * from $tabeldatabase where no='$no'";
							$hasil2 = mysqli_query($conn, $sql);


							while ($fill = mysqli_fetch_assoc($hasil2)) {


								$kode = $fill["kode"];
								$nama = $fill["nama"];
								$judul = $fill["judul"];
								$tgl = $fill["tgl"];
								$keterangann = $fill["keterangann"];
								$insert = '3';
							}
						}
						?>
						<div id="main">
							<div class="container-fluid">

								<form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform">
									<div class="box-body">
										<div class="row">
											<div class="form-group">
												<label for="kode" class="col-sm-3 control-label">Kode:</label>
												<div class="col-md-12">
													<?php if ($no == null || $no == "") { ?>
														<input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required>
													<?php } else { ?>
														<input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" maxlength="50" required readonly>
													<?php } ?>
												</div>
											</div>
										</div>

										<div class="row mb-1">
											<div class="form-group">
												<label for="nama" class="col-sm-3 control-label">Nama Barang</label>
												<div class="col-md-12">
													<select class="form-control select2" style="width: 100%;" name="nama" required>
														<option value="">Pilih</option>
														<?php
														error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
														$sql = mysqli_query($conn, "select * from barang");
														// $sql = mysqli_query($conn, "SELECT * FROM `barang`");
														while ($row = mysqli_fetch_assoc($sql)) {
															if ($barang == $row['kode'])
																echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['sku'] . " | " . $row['nama'] . "|" .  $row['gudang'] . "</option>";
															else
																echo "<option value='" . $row['nama'] . "' >" . $row['sku'] . " | " . $row['nama'] . " | " . $row['gudang'] . "</option>";
														}
														?>
													</select>
												</div>
											</div>
										</div>

										<div class="row mb-1">
											<div class="form-group">
												<label for="nama" class="col-sm-3 control-label">Judul Notes</label>
												<div class="col-md-12">
													<input type="text" class="form-control" name="judul" value="<?php echo $judul; ?>" placeholder="Masukan Judul Notes">
												</div>
											</div>
										</div>

										<?php $tgl = date("d-m-Y"); ?>
										<div class="row mb-1">
											<div class="form-group">
												<label for="nama" class="col-sm-3 control-label">Tanggal</label>
												<div class="col-md-12">
													<input type="text" class="form-control" name="tgl" value="<?php echo $tgl; ?>" readonly>
												</div>
											</div>
										</div>

										<div class="row mb-1">
											<div class="form-group">
												<label for="nama" class="col-sm-3 control-label">Keterangan</label>
												<div class="col-md-12">
													<textarea id="mytextarea" name="keterangan" placeholder="masukan keterangan notes"><?= $keterangan ?></textarea>
												</div>
											</div>
										</div>

										<input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">

									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-save"></span> Simpan</button>
									</div>
									<!-- /.box-footer -->


								</form>
							</div>
							<?php


							if ($_SERVER["REQUEST_METHOD"] == "POST") {

								$kode = mysqli_real_escape_string($conn, $_POST["kode"]);
								$nama = mysqli_real_escape_string($conn, $_POST["nama"]);
								$judul = mysqli_real_escape_string($conn, $_POST["judul"]);
								$tgl = mysqli_real_escape_string($conn, $_POST["tgl"]);
								$keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
								$insert = ($_POST["insert"]);


								$sql = "select * from $tabeldatabase where kode='$kode'";
								$result = mysqli_query($conn, $sql);

								if (mysqli_num_rows($result) > 0) {
									if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
										$sql1 = "update $tabeldatabase set nama='$nama' judul='$judul' tgl='$tgl' keterangan='$keterangan' where kode='$kode'";
										$updatean = mysqli_query($conn, $sql1);
										echo "<script type='text/javascript'>  alert('Berhasil, Data telah diupdate!'); </script>";
										echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
									} else {
										echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
										echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
									}
								} else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {

									$sql2 = "insert into $tabeldatabase values( '$kode','$nama','$judul','$tgl','$keterangan','')";

									// echo print_r($sql2);
									if (mysqli_query($conn, $sql2)) {
										echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
										echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
									} else {
										echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
										echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
									}
								}
							}


							?>

							<script>
								function myFunction() {
									document.getElementById("Myform").submit();
								}
							</script>

							<!-- KONTEN BODY AKHIR -->

						</div>
					</div>

					<!-- /.box-body -->
				</div>
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

<?php footer(); ?>