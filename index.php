<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";;
encryption();
session();
connect();
head();
body();
timing();
//pagination();
?>

<?php
$decimal = "0";
$a_decimal = ",";
$thousand = ".";
?>

<?php
theader();
menu();
body();
?>

<!--start page wrapper -->
<div class="page-wrapper">
  <div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Dashboard</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!--end breadcrumb-->
    <hr />

    <?php
    //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING) );
    $halaman = "index"; // halaman
    $dataapa = "Dashboard"; // data
    $tabeldatabase = "index"; // tabel database
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

    //$search = $_POST['search'];
    // hak tampil dashboard

    $jabatan = $_SESSION['jabatan'];
    $sqlnya = "SELECT * FROM chmenu where userjabatan = '$jabatan'";
    $hasilnya = mysqli_query($conn, $sqlnya);
    if (mysqli_num_rows($hasilnya) > 0) {
      $rownya = mysqli_fetch_assoc($hasilnya);
      $hak = $rownya['menu1'];
    } ?>

    <!-- NAVIGASI DASHBOARD -->
    <?php if ($_SESSION['jabatan'] != 'admin') {
    } else { ?>
      <?php
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $alert = $_GET['alert'];
      $sql1 = "SELECT url FROM backset";
      $hasil1 = mysqli_query($conn, $sql1);
      $row = mysqli_fetch_assoc($hasil1);
      $url = $row['url'];
      if ($alert == 1 && $url == 'http://idwares.esy.es') {
      ?>


        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
          Url Aplikasi belum disesuaikan dengan url anda sekarang. Klik Tombol pengaturan dibawah untuk menyesuaikan dengan url dimana anda menggunakan aplikasi. <br>
          <button type="button" class="btn btn-success btn btn-xs" data-toggle="modal" data-target="#modal-default">
            Pengaturan
          </button>
        </div>

      <?php } else { ?>
        <!--end row-->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
          <div class="col">
            <div class="card radius-10 bg-primary bg-gradient">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <p class="mb-0 text-white">Barang dg Stok dibawah <?php echo $alert; ?></p>
                    <h4 class="my-1 text-white"><?php echo $datax4; ?></h4>
                    <?php
                    $sql = "SELECT batas from backset";
                    $hasilx2 = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($hasilx2);
                    $alert = $row['batas'];

                    ?>
                  </div>
                  <div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="stok_menipis" class="text-white ms-auto">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10 bg-danger bg-gradient">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <p class="mb-0 text-white">Barang</p>
                    <h4 class="my-1 text-white"><?php echo $datax3; ?></h4>
                  </div>
                  <div class="text-white ms-auto font-35"><i class='bx bx-dollar'></i>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="kategori" class="text-white ms-auto">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10 bg-warning bg-gradient">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <p class="mb-0 text-white">Total Supplier</p>
                    <h4 class="text-white my-1"><?php echo $datax2; ?></h4>
                  </div>
                  <div class="text-white ms-auto font-35"><i class='bx bx-user-pin'></i>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="supplier" class="text-white ms-auto">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10 bg-info bg-aqua">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <p class="mb-0 text-white">Total Karyawan</p>
                    <h4 class="text-white my-1"><?php echo $datax1; ?></h4>
                  </div>
                  <div class="text-white ms-auto font-35"><i class='bx bx-user-pin'></i>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="admin" class="text-white ms-auto">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END NAVIGASI DASHBOARD -->
    <?php }
    } ?>
    <?php
    if ($_SESSION['jabatan'] != 'admin') {

      $sql = "select * from info";
      $hasil2 = mysqli_query($conn, $sql);

      while ($fill = mysqli_fetch_assoc($hasil2)) {

        $nama = $fill["nama"];
        $avatar = $fill["avatar"];
        $tanggal = $fill["tanggal"];
        $isi = $fill["isi"];
      }
    ?>
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Berita Informasi <span class="badge bg-green">oleh #<?php echo $nama; ?></span> pada tanggal <?php echo $tanggal; ?></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php echo $isi; ?>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php } ?>

    <!-- START TABLE -->
    <div class="row">
      <div class="col-xl-6 d-flex">
        <div class="card radius-10 w-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="mb-1">5 Barang dengan Stok paling banyak</h5>
                <p class="mb-0 font-13 text-secondary"><span class="badge bg-success">dari #<?php echo $stok1; ?></span> di gudang</p>
              </div>
              <div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
              </div>
            </div>
            <div class="table-responsive mt-4">
              <table class="table align-middle mb-0 table-hover" id="Transaction-History">
                <thead class="table-light">
                  <tr>
                    <thead>
                      <?php
                      $mySql  = "SELECT nama,sisa FROM barang ORDER BY sisa DESC LIMIT 5";
                      $myQry  = mysqli_query($conn, $mySql)  or die("Query  salah : " . mysqli_error());
                      $nomor  = 0; ?>
                      <th style="width: 10px">#</th>
                      <th>Barang</th>
                      <th>Stok</th>
                      <th style="width: 40px">Persentase</th>
                  </tr>
                </thead>
                <?php while ($kolomData = mysqli_fetch_array($myQry)) {
                  $nomor++;  ?>
                  <tbody>
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $kolomData['nama']; ?></td>
                      <td><?php echo $kolomData['sisa']; ?></td>
                      <td><span class="badge bg-danger"><?php echo round((($kolomData['sisa'] / $stok1) * 100), 2); ?></span></td>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 d-flex">
        <div class="card radius-10 w-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="mb-1">5 Barang Keluar Terbanyak</h5>
                <p class="mb-0 font-13 text-secondary"><span class="badge bg-success">dari #<?php echo $stok2; ?> keluar</p>
              </div>
              <div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
              </div>
            </div>
            <div class="table-responsive mt-4">
              <table class="table align-middle mb-0 table-hover" id="Transaction-History">
                <thead class="table-light">
                  <tr>
                    <thead>
                      <?php
                      $mySql  = "SELECT nama,terjual FROM barang ORDER BY terjual DESC LIMIT 5";
                      $myQry  = mysqli_query($conn, $mySql)  or die("Query  salah : " . mysqli_error());
                      $nomor  = 0;
                      ?>

                      <th style="width: 10px">#</th>
                      <th>Barang</th>
                      <th>Terjual</th>
                      <th style="width: 40px">Persentase</th>
                  </tr>
                </thead>
                <?php while ($kolomData = mysqli_fetch_array($myQry)) {
                  $nomor++;  ?>
                  <tbody>
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $kolomData['nama']; ?></td>
                      <td><?php echo $kolomData['terjual']; ?></td>
                      <td><span class="badge bg-info text-dark"><?php echo round((($kolomData['terjual'] / $stok2) * 100), 2); ?></span></td>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- END TABLE -->

    </div>
  </div>
</div>


<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Url Aplikasi</h4>
      </div>

      <form method="post">
        <div class="modal-body">
          <p> Url Aplikasi adalah alamat domain website/subdomain atau bisa berupa folder di localhost yang anda ketika pada address bar browser anda untuk mengakses aplikasi. Saat ini Url aplikasi seperti digambar, anda perlu menggantinya dengan milik anda sendiri. <img src="dist/img/url.png"></p>
          <p>Anda wajib ganti URL Aplikasi agar bisa berjalan dengan baik</p>



          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Url Aplikasi Baru</label>

            <div class="col-sm-5">
              <input type="text" class="form-control" name="url" placeholder="idwares.esy.es">
            </div>
          </div>

        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" name="save" class="btn btn-primary">Save changes</button>
        </div>
    </div>

    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php


if (isset($_POST['save'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = mysqli_real_escape_string($conn, $_POST['url']);

    $sqlu = "UPDATE backset SET url='$url' ";
    $query = mysqli_query($conn, $sqlu);


    if ($query) {
      echo "<script type='text/javascript'>  alert('Berhasil, Url Aplikasi telah diubah!'); </script>";
      echo "<script type='text/javascript'>window.location = 'index';</script>";
    }
  }
}

?>

<!--end page wrapper -->
<?php footer(); ?>