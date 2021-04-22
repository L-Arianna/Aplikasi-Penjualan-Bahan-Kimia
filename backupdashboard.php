<?php
if ($_SESSION['jabatan'] == 'admin' || $hak >= '1') { ?>
	<div class="col-xl-6 d-flex">
		<div class="card radius-10 w-100">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h5 class="mb-1">Hutang dan Piutang (Rp) </h5>
					</div>
				</div>
			</div>
			<div class="table-responsive mt-4">
				<table class="table align-middle mb-0 table-hover" id="Transaction-History">
					<thead class="table-light">
						<tr>
							<thead>
								<th></th>
								<th>Hutang</th>
								<th></th>
								<th>Piutang</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Segera Jatuh Tempo</td>
							<td>
								<h4><?php echo number_format($buynow); ?></h4>
							</td>
							<td>Segera Jatuh Tempo</td>
							<td>
								<h4><?php echo number_format($salenow); ?></h4>
							</td>
						</tr>

						<tr>
							<td>Jatuh Tempo
								<30 hari </td>
							<td>
								<h4><?php echo number_format($buy30); ?></h4>
							</td>
							<td>Jatuh Tempo
								<30 hari </td>
							<td>
								<h4><?php echo number_format($sale30); ?></h4>
							</td>
						</tr>

						<tr>
							<td>Jatuh Tempo 30-60 hari</td>
							<td>
								<h4><?php echo number_format($buy3060); ?></h4>
							</td>
							<td>Jatuh Tempo 30-60 hari</td>
							<td>
								<h4><?php echo number_format($sale3060); ?></h4>
							</td>
						</tr>

						<tr>
							<td>Jatuh Tempo 60-90 hari</td>
							<td>
								<h4><?php echo number_format($buy6090); ?></h4>
							</td>
							<td>Jatuh Tempo 60-90 hari</td>
							<td>
								<h4><?php echo number_format($sale6090); ?></h4>
							</td>
						</tr>

						<tr>
							<td>Jatuh Tempo >90 hari</td>
							<td>
								<h4><?php echo number_format($buy90); ?></h4>
							</td>
							<td>Jatuh Tempo >90 hari</td>
							<td>
								<h4><?php echo number_format($sale90); ?></h4>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xl-6 d-flex">
		<div class="card radius-10 w-100">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h5 class="mb-1">Ringkasan (Rp) </h5>
					</div>
				</div>
				<div class="table-responsive mt-4">
					<table class="table align-middle mb-0 table-hover" id="Transaction-History">
						<thead class="table-light">
							<tr>
								<thead>
									<th></th>
									<th>Bulan ini</th>
									<th>Bulan lalu</th>
									<th>Tahun ini</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Pendapatan Retail</td>
								<td>
									<h4><?php echo number_format($rebulan); ?></h4>
								</td>
								<td>
									<h4><?php echo number_format($rebulanlalu); ?></h4>
								</td>
								<td>
									<h4><?php echo number_format($retahun); ?></h4>
								</td>
							</tr>
							<tr>
								<td>Pendapatan Non Retail</td>
								<td>
									<h4><?php echo number_format($salemonth); ?>
								</td>
								<td>
									<h4><?php echo number_format($salelastmonth); ?>
								</td>
								<td>
									<h4><?php echo number_format($saleyear); ?></h4>
								</td>
							</tr>
							<tr>
								<td>Biaya Operasional</td>
								<td>
									<h4><?php echo number_format($opmonth); ?>
								</td>
								<td>
									<h4><?php echo number_format($oplastm); ?>
								</td>
								<td>
									<h4><?php echo number_format($opyear); ?>
								</td>
							</tr>
							<tr>
								<td>Net Income</td>
								<td>
									<h4><?php echo number_format($sum1); ?>
								</td>
								<td>
									<h4><?php echo number_format($sum2); ?>
								</td>
								<td>
									<h4><?php echo number_format($sum3); ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- start chart -->
	<div class="row">
		<div class="col-xl-6 d-flex">
			<div class="card radius-10 w-100">
				<div class="card-body">
					<?php $rtm       = mysqli_query($conn, "SELECT SUM(total) as retail FROM bayar");
					$r = mysqli_fetch_assoc($rtm) ?>

					<?php $inv       = mysqli_query($conn, "SELECT SUM(total) as total FROM sale where status LIKE '%dibayar' ");
					$i = mysqli_fetch_assoc($inv) ?>
					<?php $blm       = mysqli_query($conn, "SELECT SUM(total) as receive FROM sale where status LIKE '%belum' ");
					$b = mysqli_fetch_assoc($blm)

					?>

					<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
					<style type="text/css">

					</style>
					<script src="/libs/chart.bundle.js"></script>
					<style type="text/css">

					</style>


					<div class="chart-container">
						<canvas class="my-4 chartjs-render-monitor" id="myChart1" width="443" height="229" style="display: block; width: 443px; height: 229px;"></canvas>
						<center>
							<h2>Pendapatan Retail Vs Invoice</h2>
						</center>
					</div>
					<script>
						var ctx = document.getElementById("myChart1");
						var myChart = new Chart(ctx, {
							type: 'pie',
							data: {
								labels: ['penjualan retail', 'Invoice', 'Belum dibayar'],
								datasets: [{
									label: '# dalam rupiah',
									data: [<?php echo $r['retail']; ?>, <?php echo $i['total']; ?>, <?php echo $b['receive']; ?>],
									backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
									],
									borderColor: [
										'rgba(255,99,132,1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
									],
									borderWidth: 1
								}]
							},
							options: {
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true
										}
									}]
								}
							}
						});
					</script>
				</div>
				</section>
			</div>
			<!-- akhir chart -->
		</div>
		<div class="col-xl-6 d-flex">
			<div class="card radius-10 w-100">
				<div class="card-body">


					<?php $akun       = mysqli_query($conn, "SELECT nama FROM operasional_tipe order by no asc");  ?>

					<?php $biaya       = mysqli_query($conn, "SELECT tipe,SUM(biaya) as cost FROM operasional GROUP BY tipe order by no asc");  ?>

					<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
					<style type="text/css">

					</style>
					<script src="/libs/chart.bundle.js"></script>
					<style type="text/css">

					</style>


					<div class="chart-container">
						<canvas class="my-4 chartjs-render-monitor" id="myChart2" width="443" height="229" style="display: block; width: 443px; height: 229px;"></canvas>
						<h2 class="text-center">Pengeluaran</h2>
					</div>
					<script>
						var ctx = document.getElementById("myChart2");
						var myChart = new Chart(ctx, {
							type: 'pie',
							data: {
								labels: [<?php while ($b = mysqli_fetch_array($akun)) {
												echo '"' . $b['nama'] . '",';
											} ?>],
								datasets: [{
									label: '# dalam rupiah',
									data: [<?php while ($b = mysqli_fetch_array($biaya)) {
													echo '"' . $b['cost'] . '",';
												} ?>],
									backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
									],
									borderColor: [
										'rgba(255,99,132,1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
									],
									borderWidth: 1
								}]
							},
							options: {
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true
										}
									}]
								}
							}
						});
					</script>
				</div>
			</div>
		</div>
	<?php } ?>