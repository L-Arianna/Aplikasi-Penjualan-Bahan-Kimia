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

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "barang"; // halaman
    $dataapa = "Barang"; // data
    $tabeldatabase = "barang"; // tabel database
    $chmod = $chmenu4; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $search = $_POST['search']; ?>
    <!-- SETTING STOP -->
    <?php
    $decimal = "0";
    $a_decimal = ",";
    $thousand = ".";
    ?>

    <div class="row">
      <div class="col-xl-12">

        <div class="row mb-2">
          <div class="col-lg-12 d-flex justify-content-end">
            <div class="ms-auto">
              <form method="post">
                <div class="btn-group">
                  <div class="input-group">
                    <input type="text" name="search" class="form-control radius-15" placeholder="cari">
                    <button type="submit" class="btn btn-primary btn-sm radius-15"><i class="bx bx-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
          </div>
          <div class="card-body">
            <!-- BOX HAPUS BERHASIL -->
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
            if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $chmod == '6' || $_SESSION['jabatan'] == 'admin') {
            } elseif ($chmod == '1' ||  $_SESSION['jabatan'] == 'user') {
            } else { ?>
              <div class="callout callout-danger">
                <h4>Info</h4>
                <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
              </div>
            <?php } ?>

            <?php
            if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
              <?php
              $sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
              $hasila = mysqli_query($conn, $sqla);
              $rowa = mysqli_fetch_assoc($hasila);
              $totaldata = $rowa['totaldata'];
              ?>

              <div class="row mb-2">
                <div class="col-md-4">
                  <div class="ms-auto">
                    <a onclick="window.location.href='export_csv'" class="btn btn-secondary btn-sm radius-15" value="export excel">Export to Excel</a>
                  </div>
                </div>
              </div>
              <!-- </div> -->

              <?php
              error_reporting(E_ALL ^ E_DEPRECATED);
              $sql    = "select * from $tabeldatabase order by kode";
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

              <div class="table-responsive">
                <table class="example2 table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>SKU</th>
                      <th>Nama</th>
                      <th>Satuan</th>
                      <th>Merek</th>
                      <th>Kategori</th>
                      <th>Keterangan</th>
                      <th>Gudang</th>
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
                        $query1 = "SELECT a.*, b.nama_satuan from $tabeldatabase a, satuan b where a.satuan = b.kode AND a.sku like '%$search%' or a.nama like '%$search%' group by a.kode limit $rpp";
                        $hasil = mysqli_query($conn, $query1);
                        $no = 1;
                        while ($fill = mysqli_fetch_assoc($hasil)) { ?>
                          <tbody>
                            <tr>
                              <td><?php echo ++$no_urut; ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>

                              <td>
                                <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>

                                  <button type="button" class="btn btn-warning btn-sm" title="Edit" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'"> <i class="bx bx-edit-alt"></i></button>
                                <?php } else {
                                } ?>
                                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>

                                  <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'"><i class="bx bx-trash-alt"></i></button>
                                <?php } else {
                                } ?>
                                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                  <button type="button" class="btn btn-info btn-sm" title="Detail" onclick="window.location.href='barang_detail?no=<?php echo $fill['no'] ?>'"> <i class="bx bx-detail"></i></button>
                                <?php } else {
                                } ?>
                              </td>
                            </tr>
                          <?php } ?>
                          </tbody>
                </table>
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
                      $kodenih = $fill['satuan'];
                      $sqla = "SELECT nama_satuan FROM satuan WHERE kode ='$kodenih'";
                      $hasila = mysqli_query($conn, $sqla);
                      $rowa = mysqli_fetch_assoc($hasila); ?>
              <tbody>
                <tr>
                  <td><?php echo ++$no_urut; ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $rowa['nama_satuan']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
                  <td>
                    <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                      <button type="button" class="btn btn-warning btn-sm" title="Edit" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'"> <i class="bx bx-edit-alt"></i></button>
                    <?php } else {
                      } ?>
                    <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                      <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'"><i class="bx bx-trash-alt"></i></button>
                    <?php } else {
                      } ?>
                    <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                      <button type="button" class="btn btn-info btn-sm" title="Detail" onclick="window.location.href='barang_detail?no=<?php echo $fill['no'] ?>'"> <i class="bx bx-detail"></i></button>
                    <?php } else {
                      } ?>
                  </td>
                </tr>
              <?php
                      $i++;
                      $count++;
                    } ?>
              </tbody>
              </table>
              <div align="right"><?php if ($tcount >= $rpp) {
                                    echo paginate_one($reload, $page, $tpages);
                                  } else {
                                  } ?></div>
            <?php } ?>
              </div>
              <!-- MENU UNTUK USER -->
            <?php } else { ?>

              <?php
              $sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
              $hasila = mysqli_query($conn, $sqla);
              $rowa = mysqli_fetch_assoc($hasila);
              $totaldata = $rowa['totaldata'];
              ?>
              <div class="row mb-2">
                <div class="col-lg-12">
                  <div class="ms-auto">
                    <form method="post">
                      <div class="btn-group">
                        <div class="input-group">
                          <input type="text" name="search" class="form-control radius-15" placeholder="cari">
                          <button type="submit" class="btn btn-primary btn-sm radius-15"><i class="bx bx-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php
              error_reporting(E_ALL ^ E_DEPRECATED);
              $sql    = "select * from $tabeldatabase order by kode";
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

              <div class="table-responsive">
                <table class="example2 table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>SKU</th>
                      <th>Nama</th>
                      <th>Satuan</th>
                      <th>Merek</th>
                      <th>Kategori</th>
                      <th>Keterangan</th>
                      <th>Gudang</th>
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
                        $query1 = "SELECT a.*, b.nama_satuan from $tabeldatabase a, satuan b where a.satuan = b.kode AND a.sku like '%$search%' or a.nama like '%$search%' group by a.kode limit $rpp";
                        $hasil = mysqli_query($conn, $query1);
                        $no = 1;
                        while ($fill = mysqli_fetch_assoc($hasil)) { ?>
                          <tbody>
                            <tr>
                              <td><?php echo ++$no_urut; ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>

                              <td>
                                <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') { ?>

                                  <button type="button" class="btn btn-warning btn-sm" title="Edit" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'"> <i class="bx bx-edit-alt"></i></button>
                                <?php } else {
                                } ?>
                                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'user') { ?>

                                  <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'"><i class="bx bx-trash-alt"></i></button>
                                <?php } else {
                                } ?>
                                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'user') { ?>
                                  <button type="button" class="btn btn-info btn-sm" title="Detail" onclick="window.location.href='barang_detail?no=<?php echo $fill['no'] ?>'"> <i class="bx bx-detail"></i></button>
                                <?php } else {
                                } ?>
                              </td>
                            </tr>
                          <?php } ?>
                          </tbody>
                </table>
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
                      $kodenih = $fill['satuan'];
                      $sqla = "SELECT nama_satuan FROM satuan WHERE kode ='$kodenih'";
                      $hasila = mysqli_query($conn, $sqla);
                      $rowa = mysqli_fetch_assoc($hasila); ?>
              <tbody>
                <tr>
                  <td><?php echo ++$no_urut; ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $rowa['nama_satuan']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
                  <td>
                    <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') { ?>
                      <button type="button" class="btn btn-warning btn-sm" title="Edit" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'"> <i class="bx bx-edit-alt"></i></button>
                    <?php } else {
                      } ?>
                    <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'user') { ?>
                      <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'"><i class="bx bx-trash-alt"></i></button>
                    <?php } else {
                      } ?>
                    <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'user') { ?>
                      <button type="button" class="btn btn-info btn-sm" title="Detail" onclick="window.location.href='barang_detail?no=<?php echo $fill['no'] ?>'"> <i class="bx bx-detail"></i></button>
                    <?php } else {
                      } ?>
                  </td>
                </tr>
              <?php
                      $i++;
                      $count++;
                    } ?>
              </tbody>
              </table>
              <div align="right"><?php if ($tcount >= $rpp) {
                                    echo paginate_one($reload, $page, $tpages);
                                  } else {
                                  } ?></div>
            <?php } ?>
              </div>

            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end page wrapper -->
  <?php
  footer();
  ?>