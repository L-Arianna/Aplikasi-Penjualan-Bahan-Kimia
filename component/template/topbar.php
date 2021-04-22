<?php
include "configuration/config_connect.php";
$nouser = $_SESSION['nouser'];
$user = "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['nama'];
$jabatan = $row['jabatan'];
$avatar = $row['avatar'];


$queryback = "SELECT * FROM backset";
$resultback = mysqli_query($conn, $queryback);
$rowback = mysqli_fetch_assoc($resultback);
$nama = $rowback['namabisnis1'];
?>


<!--start header -->
<header>
	<div class="topbar d-flex align-items-center">
		<nav class="navbar navbar-expand">
			<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
			</div>
			<div class="top-menu ms-auto">
				<ul class="navbar-nav align-items-center">
					<li class="nav-item dropdown dropdown-large">
						<div class="dropdown-menu dropdown-menu-end">
							<div class="header-notifications-list">
								<!--  -->
							</div>
						</div>
					</li>
					<li class="nav-item dropdown dropdown-large">
						<div class="dropdown-menu dropdown-menu-end">
							<div class="header-message-list">
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
								<a class="dropdown-item" href="javascript:;">

								</a>
							</div>
							<a href="javascript:;">
								<!-- <div class="text-center msg-footer">View All Messages</div> -->
							</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="user-box dropdown">
				<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="<?php echo $avatar; ?>" class="user-img" alt="user avatar">
					<div class="user-info ps-3">
						<p class="user-name mb-0"><?php echo $nama; ?></p>
						<p class="designattion mb-0"><?php echo $jabatan; ?></p>
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-end">
					<li><a class="dropdown-item" href="user_profil"><i class="bx bx-user"></i><span>Profile</span></a>
					</li>
					</li>
					<li>
						<div class="dropdown-divider mb-0"></div>
					</li>
					<li><a class="dropdown-item" href="logout?logout=1"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>
<!--end header -->