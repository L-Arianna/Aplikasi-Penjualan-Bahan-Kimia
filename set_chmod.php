<?php
include "configuration/config_include.php";
etc();
encryption();
session();
connect();
head();
body();
timing();
//alltotal();
//pagination();
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
    <div class="row">
      <?php
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $halaman = "chmod"; // halaman
      $dataapa = "Hak Akses"; // data
      $tabeldatabase = "chmenu"; // tabel database
      $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
      $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
      $search = $_POST['search'];
      ?>
      <?php
      if ($_SESSION['jabatan'] == 'admin') {
      ?>
        <?php

        $no = $_GET['no'];

        $sql = "select * from chmenu where userjabatan = '$no'";
        $hasil2 = mysqli_query($conn, $sql);


        while ($fill = mysqli_fetch_assoc($hasil2)) {

          $userjabatan = $fill['userjabatan'];
          $menu1 = $fill['menu1'];
          $menu2 = $fill['menu2'];
          $menu3 = $fill['menu3'];
          $menu4 = $fill['menu4'];
          $menu5 = $fill['menu5'];
          $menu6 = $fill['menu6'];
          $menu7 = $fill['menu7'];
          $menu8 = $fill['menu8'];
          $menu9 = $fill['menu9'];
          $menu10 = $fill['menu10'];
          $menu11 = $fill['menu11'];
        }

        ?>
    </div>


    <div class="row">
      <?php if ($_SESSION['jabatan'] != 'admin') {
        } else { ?>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3>General Setting</h3>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post">
                <div class="form-group">
                  <label for="menu1" class="col-sm-3 control-label">Jabatan</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="userjabatan" value="<?php echo $no; ?>" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="menu1" class="col-sm-3 control-label">Menu Storage</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="menu1" name="menu1" placeholder="Masukkan Hak Akses" value="<?php echo $menu1; ?>" maxlength="1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="menu2" class="col-sm-3 control-label">Menu Penjualan</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="menu2" name="menu2" placeholder="Masukkan Hak Akses" value="<?php echo $menu2; ?>" maxlength="1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="menu3" class="col-sm-3 control-label">Menu Laporan</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="menu3" name="menu3" placeholder="Masukkan Hak Akses" value="<?php echo $menu3; ?>" maxlength="1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="menu4" class="col-sm-3 control-label">Menu Notes</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="menu4" name="menu4" placeholder="Masukkan Hak Akses" value="<?php echo $menu4; ?>" maxlength="1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="menu5" class="col-sm-3 control-label">Menu Manajemen User</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="menu5" name="menu5" placeholder="Masukkan Hak Akses" value="<?php echo $menu5; ?>" maxlength="1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="menu5" class="col-sm-3 control-label">Menu Pengaturan</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="menu6" name="menu6" placeholder="Masukkan Hak Akses" value="<?php echo $menu6; ?>" maxlength="1">
                  </div>
                </div>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $userjabatan = $_POST['userjabatan'];
                  $menu1 = $_POST['menu1'];
                  $menu2 = $_POST['menu2'];
                  $menu3 = $_POST['menu3'];
                  $menu4 = $_POST['menu4'];
                  $menu5 = $_POST['menu5'];
                  $menu6 = $_POST['menu6'];
                  if (isset($_POST['simpan'])) {
                    $sql = "select * from chmenu where userjabatan = '$userjabatan'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {

                      $sql1 = "update chmenu set menu1='$menu1', menu2='$menu2', menu3='$menu3', menu4='$menu4', menu5='$menu5', menu6='$menu6' where userjabatan = '$userjabatan'";
                      $result = mysqli_query($conn, $sql1); ?>
                      <?php echo "<script type='text/javascript'>window.location = 'set_$forwardpage?no=$userjabatan';</script>"; ?><?php


                                                                                                                                  } else {
                                                                                                                                    $sql1 = "insert into chmenu values('$userjabatan','$menu1','$menu2','$menu3','$menu4','$menu5','$menu6')";
                                                                                                                                    $result = mysqli_query($conn, $sql1); ?>
                      <?php echo "<script type='text/javascript'>window.location = 'set_$forwardpage?no=$userjabatan';</script>"; ?><?php
                                                                                                                                  }
                                                                                                                                }
                                                                                                                              }
                                                                                                                                    ?>

                      <button type="submit" class="btn btn-primary btn-sm" name="simpan"><span class="bx bx-save"></span> Simpan</button>
                      <!-- </div> -->
              </form>
            </div>
          </div>
        <?php } ?>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3>Info</h3>
            </div>
            <div class="card-body">
              <p>Hak akses :</p>
              <p>Tulis angka 0 untuk hak akses <b>tidak bisa semua</b> .</p>
              <p>Tulis angka 1 untuk hak akses <b>baca</b> .</p>
              <p>Tulis angka 2 untuk hak akses <b>baca dan tambah</b> .</p>
              <p>Tulis angka 3 untuk hak akses <b>baca, tambah, dan edit</b> .</p>
              <p>Tulis angka 4 untuk hak akses <b>baca, tambah, edit, dan delete</b> .</p>
              <p>Tulis angka 5 untuk hak akses <b>semua bisa</b> .</p>
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
    </div>

    <!-- /.content -->
  </div>
</div>

<?php footer(); ?>