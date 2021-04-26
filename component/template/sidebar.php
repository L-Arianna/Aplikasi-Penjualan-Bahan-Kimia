<?php
include "configuration/config_connect.php";
include "configuration/config_chmod.php";
$nouser = $_SESSION['nouser'];
$user = "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['nama'];
$jabatan = $row['jabatan'];
$avatar = $row['avatar'];
?>
<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img src="assets/favicon/b.png" class="kk" alt="logo icon">
		</div>
		<div>
			<!-- <h4 class="logo-text">KURNIA MAKMUR</h4> -->
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
		</div>
	</div>
	<!--navigation-->
	<ul class="metismenu" id="menu">
		<li>
			<a href="index">
				<div class="parent-icon"><i class='bx bx-home-circle'></i>
				</div>
				<div class="menu-title">Dashboard</div>
			</a>
		</li>


		<?php

		if ($chmenu4 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>


			<li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class="bx bx-box"></i>
					</div>
					<div class="menu-title">Storage</div>
				</a>
				<ul>
					<li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Gudang</a>
						<ul>
							<!-- SUB MENU BARANG -->
							<li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Barang</a>
								<ul>
									<li> <a href="barang"><i class="bx bx-right-arrow-alt"></i>Data Barang</a>
									</li>
									<li> <a href="add_barang"><i class="bx bx-right-arrow-alt"></i>Tambah Barang</a>
									</li>
									<li> <a href="cetak_barcode"><i class="bx bx-right-arrow-alt"></i>Cetak Barcode</a>
									</li>
								</ul>
							</li>
							<!-- SUB MENU STOK -->
							<li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Stok</a>
								<ul>
									<li> <a href="stok_barang"><i class="bx bx-right-arrow-alt"></i>Data Stok</a>
									</li>
									<li> <a href="stok_in"><i class="bx bx-right-arrow-alt"></i>Stok Masuk</a>
									</li>
									<li> <a href="stok_out"><i class="bx bx-right-arrow-alt"></i>Stok Keluar</a>
									</li>
									<li> <a href="mutasi"><i class="bx bx-right-arrow-alt"></i>Mutasi Stok</a>
									</li>
									<li> <a href="stok_retur"><i class="bx bx-right-arrow-alt"></i>Stok Barang Retur</a>
									</li>
									<li> <a href="stok_menipis"><i class="bx bx-right-arrow-alt"></i>Stok Menipis</a>
									</li>
								</ul>
							</li>
							<!-- SUB MENU SUPPLIER -->
							<li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Supplier</a>
								<ul>
									<li> <a href="supplier"><i class="bx bx-right-arrow-alt"></i>Data Suppliere</a>
									</li>
									<li> <a href="add_supplier"><i class="bx bx-right-arrow-alt"></i>Tambah Supplier</a>
									</li>
								</ul>
							</li>
							<!-- sub menu Kategori dan Brand -->
							<li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Kategori dan Brand</a>
								<ul>
									<li> <a href="kategori"><i class="bx bx-right-arrow-alt"></i>Data Kategori</a>
									</li>
									<li> <a href="merek"><i class="bx bx-right-arrow-alt"></i>Data Brand</a>
									</li>
									<li> <a href="gudang"><i class="bx bx-right-arrow-alt"></i>Data Gudang</a>
									</li>
									<li> <a href="satuan"><i class="bx bx-right-arrow-alt"></i>Data Satuan</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>

				</ul>
			</li>



		<?php } else {
		}
		if ($chmenu5 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class='bx bx-store'></i>
					</div>
					<div class="menu-title">Menu Penjualan</div>
				</a>
				<ul>
					<!-- <li> <a href="add_jual"><i class="bx bx-right-arrow-alt"></i>Trx Retail</a>
					</li> -->
					<li> <a href="add_sale"><i class="bx bx-right-arrow-alt"></i>Buat Invoice</a>
					</li>
					<li> <a href="penjualan"><i class="bx bx-right-arrow-alt"></i>Data Invoice</a>
					</li>
					<li> <a href="pelanggan"><i class="bx bx-right-arrow-alt"></i>Pelanggan</a>
					</li>
					<li> <a href="retur"><i class="bx bx-right-arrow-alt"></i>Retur Barang</a>
					</li>
					<!-- <li> <a href="rekening"><i class="bx bx-right-arrow-alt"></i>Rekening Saya</a>
					</li> -->
				</ul>
			</li>
		<?php } else {
		}
		if ($chmenu6 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<!-- <li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"> <i class="bx bx-barcode-reader"></i>
					</div>
					<div class="menu-title">Stok</div>
				</a>
				<ul>
					<li> <a href="stok_barang"><i class="bx bx-right-arrow-alt"></i>Data Stok</a>
					</li>
					<li> <a href="stok_in"><i class="bx bx-right-arrow-alt"></i>Stok Masuk</a>
					</li>
					<li> <a href="stok_out"><i class="bx bx-right-arrow-alt"></i>Stok Keluar</a>
					</li>
					<li> <a href="mutasi"><i class="bx bx-right-arrow-alt"></i>Mutasi Stok</a>
					</li>
					<li> <a href="stok_retur"><i class="bx bx-right-arrow-alt"></i>Stok Barang Retur</a>
					</li>
					<li> <a href="stok_menipis"><i class="bx bx-right-arrow-alt"></i>Stok Menipis</a>
					</li>
				</ul>
			</li> -->

		<?php } else {
		}
		if ($chmenu7 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class='bx bx-spreadsheet'></i>
					</div>
					<div class="menu-title">Laporan</div>
				</a>
				<ul>
					<!-- <li> <a href="report_beli"><i class="bx bx-right-arrow-alt"></i>Pembelian</a>
					</li> -->
					<!-- <li> <a href="report_jual"><i class="bx bx-right-arrow-alt"></i>Penjualan Retail</a>
					</li> -->
					<li> <a href="report_inv"><i class="bx bx-right-arrow-alt"></i>Invoice Penjualan</a>
					</li>
					<li> <a href="report_kirim"><i class="bx bx-right-arrow-alt"></i>Invoice Pengiriman</a>
					</li>
					<li> <a href="report_labarugi"><i class="bx bx-right-arrow-alt"></i>Notes</a>
					</li>
				</ul>
			</li>
			</li>
		<?php } else {
		}
		if ($chmenu2 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class="bx bx-note"></i>
					</div>
					<div class="menu-title">Notes</div>
				</a>
				<ul>
					<li> <a href="notes"><i class="bx bx-right-arrow-alt"></i>My Notes</a>
					</li>
				</ul>
			</li>
		<?php } else {
		}
		if ($chmenu3 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<!-- <li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class="bx bx-food-menu"></i>
					</div>
					<div class="menu-title">Kategori dan Brand</div>
				</a>
				<ul>
					<li> <a href="kategori"><i class="bx bx-right-arrow-alt"></i>Data Kategori</a>
					</li>
					<li> <a href="add_kategori"><i class="bx bx-right-arrow-alt"></i>Tambah Kategori</a>
					</li>
					<li> <a href="merek"><i class="bx bx-right-arrow-alt"></i>Data Brand</a>
					</li>
					<li> <a href="add_merek"><i class="bx bx-right-arrow-alt"></i>Tambah Brand</a>
					</li>
				</ul>
			</li> -->

		<?php } else {
		}
		if ($chmenu1 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class="bx bx-user-plus"></i>
					</div>
					<div class="menu-title">Manajemen User</div>
				</a>
				<ul>
					<li> <a href="admin"><i class="bx bx-right-arrow-alt"></i>Daftar User</a>
					</li>
					<li> <a href="add_jabatan"><i class="bx bx-right-arrow-alt"></i>Jabatan User</a>
					</li>
					<li> <a href="pengumuman"><i class="bx bx-right-arrow-alt"></i>Pengumuman</a>
					</li>
				</ul>
			</li>
		<?php } else {
		}
		if ($chmenu8 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
			<li>
				<a class="has-arrow" href="javascript:;">
					<div class="parent-icon"><i class="bx bx-wrench"></i>
					</div>
					<div class="menu-title">Pengaturan</div>
				</a>
				<ul>
					<li> <a href="set_general"><i class="bx bx-right-arrow-alt"></i>General Setting</a>
					</li>
					<!-- <li> <a href="set_themes"><i class="bx bx-right-arrow-alt"></i>Theme Setting</a>
					</li> -->
					<li> <a href="backup"><i class="bx bx-right-arrow-alt"></i>Backup & restore</a>
					</li>
					<li> <a href="payment_options"><i class="bx bx-right-arrow-alt"></i>Metode Bayar</a>
					</li>
				</ul>
			</li>
		<?php } else {
		}

		?>
	</ul>
	<!--end navigation-->
</div>
<!--end sidebar wrapper -->