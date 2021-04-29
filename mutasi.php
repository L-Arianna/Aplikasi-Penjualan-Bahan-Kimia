<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
//include "configuration/config_alltotal.php";
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
<?php
$decimal = "0";
$a_decimal = ",";
$thousand = ".";
?>
<div class="page-wrapper">
  <div class="page-content">


    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "mutasi"; // halaman
    $dataapa = "Mutasi Barang"; // data
    $tabeldatabase = "mutasi"; // tabel database
    $chmod = $chmenu8; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $search = $_POST['search'];

    ?>

    <!-- SETTING STOP -->

    <textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
    <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
    <script type="text/javascript">
      function printDiv(elementId) {
        var a = document.getElementById('printing-css').value;
        var b = document.getElementById(elementId).innerHTML;
        window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
      }
    </script>

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
    } else {
    ?>
      <div class="callout callout-danger">
        <h4>Info</h4>
        <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
      </div>
    <?php
    }
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


      <div class="row mb-2">
        <form method="post" action="">
          <div class="col-lg-12 d-flex justify-content-end">
            <div class="ms-auto">
              <div class="btn-group">
                <div class="input-group">
                  <input type="text" name="search" class="form-control radius-30" placeholder="cari">
                  <span class="input-group-text">&</span>
                  <input type="text" name="search" class="form-control radius-30" placeholder="cari">
                  <button type="submit" class="btn btn-primary btn-sm radius-30"><i class="bx bx-search"></i></button>
                </div>
              </div>
              <button name="truncate" type="submit" class="btn btn-danger btn-sm radius-30"><i class="bx bx-trash"></i> Kosongkan</button>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <div class="card-header">
          <h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
        </div>
        <?php
        error_reporting(E_ALL ^ E_DEPRECATED);
        $sql    = "SELECT mutasi.namauser, mutasi.tgl, mutasi.kodebarang, mutasi.status, mutasi.jumlah, mutasi.sisa, mutasi.kegiatan, mutasi.keterangan, barang.nama, barang.brand, barang.kategori, barang.gudang FROM mutasi INNER JOIN barang ON mutasi.kodebarang = barang.kode ORDER BY mutasi.no ASC";
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
                  <th>Nama User</th>
                  <th>Tanggal</th>
                  <th>Barang</th>
                  <th>Brand</th>
                  <th>Kategori</th>
                  <th>Gudang</th>
                  <th>Jumlah</th>
                  <th>Stok Akhir</th>
                </tr>
              </thead>
              <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
              $search = $_POST['search'];

              if ($search != null || $search != "") {

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                  if (isset($_POST['search'])) {
                    // $query1 = "SELECT mutasi.namauser, mutasi.tgl, mutasi.kodebarang, mutasi.status, mutasi.jumlah, mutasi.sisa, mutasi.kegiatan, mutasi.keterangan, barang.nama, barang.brand, barang.kategori, barang.gudang FROM mutasi INNER JOIN barang ON mutasi.kodebarang = barang.kode WHERE barang.gudang LIKE '%$search%' AND barang.nama LIKE '%$search%' order by mutasi.no limit $rpp";

                    $query1 = "select mutasi.namauser,mutasi.tgl,mutasi.kodebarang,mutasi.status,mutasi.jumlah,mutasi.sisa,mutasi.kegiatan,mutasi.keterangan,barang.nama, barang.brand, barang.kategori, barang.gudang from mutasi inner join barang on mutasi.kodebarang=barang.kode where barang.nama like '%$search%' or barang.gudang like '%$search%' or barang.brand like '%$search%' or barang.kategori like '%$search%'or mutasi.namauser like '%$search%' order by mutasi.no limit $rpp";
                    $hasil = mysqli_query($conn, $query1);
                    $no = 1;
                    while ($fill = mysqli_fetch_assoc($hasil)) {

              ?>
                      <tbody>
                        <tr>
                          <td><?php echo ++$no_urut; ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['namauser']); ?></td>
                          <?php $tgl = date("d-m-Y", strtotime($fill['tgl'])); ?>
                          <td><?php echo mysqli_real_escape_string($conn, $tgl); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                        </tr>
                      <?php } ?>
                      </tbody>
            </table>
            <div align="right"><?php if ($tcount >= $rpp) {
                                  echo paginate_one($reload, $page, $tpages);
                                } else {
                                } ?></div>

          <?php }
                }
              } else {
                while (($count < $rpp) && ($i < $tcount)) {
                  mysqli_data_seek($result, $i);
                  $fill = mysqli_fetch_array($result);
          ?>


          <tbody>
            <tr>
              <td><?php echo ++$no_urut; ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['namauser']); ?></td>
              <?php $tgl = date("d-m-Y", strtotime($fill['tgl'])); ?>
              <td><?php echo mysqli_real_escape_string($conn, $tgl); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
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
      </div>

    <?php } else {
    } ?>
    <div align="right" style="padding-right:15px" class="no-print" id="no-print">
      <div align="left" class="no-print" id="no-print"> <a onclick="javascript:printDiv('tabel1');" class="btn btn-default btn-flat" name="cetak" value="cetak"><span class="glyphicon glyphicon-print"></span></a><?php echo " "; ?>
        <a onclick="window.location.href='configuration/config_export?forward=<?php echo $forward; ?>&search=<?php echo $search; ?>'" class="btn btn-default btn-flat" name="cetak" value="export excel"><span class="glyphicon glyphicon-save-file"></span></a>
      </div> <br />
    </div>
  </div>
  <!-- ./col -->
</div>



<?php

if (isset($_POST["truncate"])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT namauser FROM mutasi ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

      $truncate = mysqli_query($conn, 'TRUNCATE TABLE mutasi ');
      if ($truncate) {
        echo '<script>
    setTimeout(function() {
        swal({
    title: "Berhasil!",
    text: "Mutasi telah dikosongkan, klik ok untuk refresh!",
    type: "success"
}).then(function() {
    window.location = "mutasi";
});
    }, 1000);
</script>';
      } else {
        echo "<script type='text/javascript'>  alert('GAGAL, Mutasi gagal dikosongkan. Terjadi kesalahan silahkan hubungi admin!');</script>";
      }
    } else {
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal.fire("Gagal!","Mutasi sudah kosong, tidak bisa dikosongkan lagi!","error");';
      echo '}, 1000);</script>';
    }
  }
}
?>
<?php footer(); ?>