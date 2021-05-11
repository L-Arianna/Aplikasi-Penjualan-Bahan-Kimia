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
		$halaman = "satuan"; // halaman
		$dataapa = "Satuan"; // data
		$tabeldatabase = "satuan"; // tabel database
		$chmod = $chmenu3; // Hak akses Menu
		$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
		$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
		$search = $_POST['search'];
		$insert = $_POST['insert'];

		function autoNumber()
		{
			include "configuration/config_connect.php";
			global $forward;
			$query = "SELECT MAX(RIGHT(kode_satuan, 4)) as max_id FROM $forward ORDER BY kode_satuan";
			$result = mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result);
			$id_max = $data['max_id'];
			$sort_num = (int) substr($id_max, 1, 4);
			$sort_num++;
			$new_code = sprintf("%04s", $sort_num);
			return $new_code;
		}
		?>
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
			<div class="card">
				<div class="card-header">
					<h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
				</div>
				<!-- /.card-header -->

				<div class="card-body">
					<?php
					error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

					$kode = $nama = "";
					$kode = $convert = "";
					$no = $_GET["no"];
					$insert = '1';



					if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {

						$sql = "select * from $tabeldatabase where no='$no'";
						$hasil2 = mysqli_query($conn, $sql);


						while ($fill = mysqli_fetch_assoc($hasil2)) {


							$kode = $fill["kode_satuan"];
							$nama = $fill["satuan_isi"];
							$convert = $fill["satuan_jual"];
							$insert = '3';
						}
					}
					?>
					<form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform">

						<div class="row">
							<div class="form-group">
								<label for="kode" class="col-sm-3 control-label">Kode:</label>
								<div class="col-md-12">
									<?php if ($no == null || $no == "") { ?>
										<input type="text" class="form-control" id="kode" name="kode_satuan" value="<?php echo autoNumber(); ?>" maxlength="50" required>
									<?php } else { ?>
										<input type="text" class="form-control" id="kode" name="kode_satuan" value="<?php echo $kode; ?>" maxlength="50" required readonly>
									<?php } ?>
								</div>
							</div>
						</div>


						<div class="row mb-1">
							<div class="form-group">
								<label for="convert" class="col-sm-3 control-label">Satuan jual</label>
								<div class="col-md-12">
									<input type="text" class="form-control" name="satuan_jual" value="<?php echo $convert; ?>">
								</div>
							</div>
						</div>

						<div class="row mb-1">
							<div class="form-group">
								<label for="nama" class="col-sm-3 control-label">Satuan isi</label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="nama" name="satuan_isi" value="<?php echo $nama; ?>">
								</div>
							</div>
						</div>

						<input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">


						<button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-save"></span> Simpan</button>



						<?php


						if ($_SERVER["REQUEST_METHOD"] == "POST") {

							$kode = mysqli_real_escape_string($conn, $_POST["kode_satuan"]);
							$nama = mysqli_real_escape_string($conn, $_POST["satuan_isi"]);
							$convert = mysqli_real_escape_string($conn, $_POST["satuan_jual"]);
							$insert = ($_POST["insert"]);


							$sql = "select * from $tabeldatabase where kode_satuan='$kode'";
							$result = mysqli_query($conn, $sql);

							if (mysqli_num_rows($result) > 0) {
								if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
									$sql1 = "update `satuan` SET `satuan_isi` = '$nama', `satuan_jual` = '$convert' WHERE kode_satuan = '$kode'";
									$updatean = mysqli_query($conn, $sql1);
									echo "<script type='text/javascript'>  alert('Berhasil, Data telah diupdate!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								} else {
									echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								}
							} else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {

								$sql2 = "insert into $tabeldatabase values( '$kode','$nama','$convert','')";
								if (mysqli_query($conn, $sql2)) {
									echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								} else {
									echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								}
								// print_r($sql2);
							}
						}
						?>

						<script>
							function myFunction() {
								document.getElementById("Myform").submit();
							}
						</script>
					</form>
				</div>
			</div>

		<?php
		} elseif ($chmod >= 2 || $_SESSION['jabatan'] == 'user') { ?>
			<div class="card">
				<div class="card-header">
					<h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
				</div>
				<!-- /.card-header -->

				<div class="card-body">
					<?php
					error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

					$kode = $nama = "";
					$kode = $convert = "";
					$no = $_GET["no"];
					$insert = '1';



					if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'user')) {

						$sql = "select * from $tabeldatabase where no='$no'";
						$hasil2 = mysqli_query($conn, $sql);


						while ($fill = mysqli_fetch_assoc($hasil2)) {


							$kode = $fill["kode_satuan"];
							$nama = $fill["satuan_isi"];
							$convert = $fill["satuan_jual"];
							$insert = '3';
						}
					}
					?>
					<form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform">

						<div class="row">
							<div class="form-group">
								<label for="kode" class="col-sm-3 control-label">Kode:</label>
								<div class="col-md-12">
									<?php if ($no == null || $no == "") { ?>
										<input type="text" class="form-control" id="kode" name="kode_satuan" value="<?php echo autoNumber(); ?>" maxlength="50" required>
									<?php } else { ?>
										<input type="text" class="form-control" id="kode" name="kode_satuan" value="<?php echo $kode; ?>" maxlength="50" required readonly>
									<?php } ?>
								</div>
							</div>
						</div>

						<div class="row mb-1">
							<div class="form-group">
								<label for="convert" class="col-sm-3 control-label">Satuan jual</label>
								<div class="col-md-12">
									<input type="text" class="form-control" name="satuan_jual" value="<?php echo $convert; ?>">
								</div>
							</div>
						</div>


						<div class="row mb-1">
							<div class="form-group">
								<label for="nama" class="col-sm-3 control-label">Satuan isi</label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="nama" name="satuan_isi" value="<?php echo $nama; ?>">
								</div>
							</div>
						</div>

						<input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">
						<button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-save"></span> Simpan</button>
						<?php
						if ($_SERVER["REQUEST_METHOD"] == "POST") {

							$kode = mysqli_real_escape_string($conn, $_POST["kode_satuan"]);
							$nama = mysqli_real_escape_string($conn, $_POST["satuan_isi"]);
							$convert = mysqli_real_escape_string($conn, $_POST["satuan_jual"]);
							$insert = ($_POST["insert"]);


							$sql = "select * from $tabeldatabase where kode='$kode'";
							$result = mysqli_query($conn, $sql);

							if (mysqli_num_rows($result) > 0) {
								if ($chmod >= 5 || $_SESSION['jabatan'] == 'user') {
									// $sql1 = "update $tabeldatabase set nama_satuan='$nama', convert='$convert', jumlah='$jumlah' where kode='$kode'";

									$sql1 = "update `satuan` SET `satuan_isi` = '$nama', `satuan_jual` = '$convert' WHERE kode_satuan = '$kode'";

									$updatean = mysqli_query($conn, $sql1);
									echo "<script type='text/javascript'>  alert('Berhasil, Data telah diupdate!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								} else {
									echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								}
							} else if (($chmod >= 2 || $_SESSION['jabatan'] == 'user')) {

								$sql2 = "insert into $tabeldatabase values( '$kode','$nama','$convert','')";
								if (mysqli_query($conn, $sql2)) {
									echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								} else {
									echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
									echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
								}
								// echo print_r($sql1);
							}
						}
						?>

						<script>
							function myFunction() {
								document.getElementById("Myform").submit();
							}
						</script>
					</form>
				</div>
			</div>
		<?php } else { ?>
			<div class="callout callout-danger">
				<h4>Info</h4>
				<b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
			</div>

		<?php } ?>
		<!-- ./col -->
	</div>
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
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/plugins/select2/select2.full.min.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/plugins/iCheck/icheck.min.js"></script>
<script>
	$(function() {
		//Initialize Select2 Elements
		$(".select2").select2();

		//Datemask dd/mm/yyyy
		$("#datemask").inputmask("yyyy-mm-dd", {
			"placeholder": "yyyy/mm/dd"
		});
		//Datemask2 mm/dd/yyyy
		$("#datemask2").inputmask("yyyy-mm-dd", {
			"placeholder": "yyyy/mm/dd"
		});
		//Money Euro
		$("[data-mask]").inputmask();

		//Date range picker
		$('#reservation').daterangepicker();
		//Date range picker with time picker
		$('#reservationtime').daterangepicker({
			timePicker: true,
			timePickerIncrement: 30,
			format: 'YYYY/MM/DD h:mm A'
		});
		//Date range as a button
		$('#daterange-btn').daterangepicker({
				ranges: {
					'Hari Ini': [moment(), moment()],
					'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
					'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
					'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
					'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(29, 'days'),
				endDate: moment()
			},
			function(start, end) {
				$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
		);

		//Date picker
		$('#datepicker').datepicker({
			autoclose: true
		});

		$('.datepicker').datepicker({
			dateFormat: 'yyyy-mm-dd'
		});

		//Date picker 2
		$('#datepicker2').datepicker('update', new Date());

		$('#datepicker2').datepicker({
			autoclose: true
		});

		$('.datepicker2').datepicker({
			dateFormat: 'yyyy-mm-dd'
		});


		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		//Red color scheme for iCheck
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red',
			radioClass: 'iradio_minimal-red'
		});
		//Flat red color scheme for iCheck
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});

		//Colorpicker
		$(".my-colorpicker1").colorpicker();
		//color picker with addon
		$(".my-colorpicker2").colorpicker();

		//Timepicker
		$(".timepicker").timepicker({
			showInputs: false
		});
	});
</script>
<?php footer(); ?>