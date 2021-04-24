<!DOCTYPE html>
<html>
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
if (!login_check()) {
?>
  <meta http-equiv="refresh" content="0; url=logout" />
<?php
  exit(0);
}
?>
<div class="wrapper">
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


      <!-- SETTING START-->

      <?php
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "configuration/config_chmod.php";
      $halaman = "stok_barang"; // halaman
      $dataapa = "Stok Barang"; // data
      $tabeldatabase = "barang"; // tabel database
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


      <h6 class="mb-0 text-uppercase"></h6>
      <hr />


      <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
          <div class="card radius-10 bg-primary bg-gradient">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div>
                  <p class="mb-0 text-white">Stok Tersedia</p>
                  <h3 class="mb-0 text-white"><sup style="font-size: 20px"></sup><?php echo number_format($stok1, $decimal, $a_decimal, $thousand) . ' '; ?></h3>
                </div>
                <div class="text-white ms-auto font-35"><i class='bx bx-package'></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card radius-10 bg-warning bg-gradient">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div>
                  <p class="mb-0 text-white">Barang keluar</p>
                  <h3 class="mb-0 text-white"><?php echo $stok2; ?></h3>
                </div>
                <div class="text-white ms-auto font-35"><i class='bx bx-archive-out'></i>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col">
          <div class="card radius-10 bg-success bg-gradient">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div>
                  <p class="mb-0 text-white">Barang Masuk</p>
                  <h3 class="mb-0 text-white"><?php echo $stok3; ?></h3>
                </div>
                <div class="text-white ms-auto font-35"><i class='bx bx-archive-in'></i>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col">
          <div class="card radius-10 bg-info bg-gradient">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div>
                  <p class="mb-0 text-white">Jumlah Produk</p>
                  <h3 class="mb-0 text-white"><?php echo $stok4; ?></h3>
                </div>
                <div class="text-white ms-auto font-35"><i class='bx bx-collection'></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



      <!-- BREADCRUMB -->

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

        <div class="card">
          <div class="card-header">
            <h3>Data <?php echo $dataapa ?> <span class="no-print label label-default" id="no-print"><?php echo $totaldata; ?></span>
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="box" id="tabel1">
                  <div class="no-print" id="no-print">
                    <form method="post">
                      <br />
                      <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control pull-right" placeholder="Cari">

                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>

                </div>

                <!-- /.box-header -->
                <!-- /.Paginasi -->
                <?php
                error_reporting(E_ALL ^ E_DEPRECATED);
                $sql    = "select * from barang order by kode";
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
                <div class="box-body table-responsive">
                  <table class="table table-hover ">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama barang</th>
                        <th>Gudang</th>
                        <th>Merek</th>
                        <th>Stok Keluar</th>
                        <th>Stok Masuk</th>
                        <th>Sisa Stok</th>

                      </tr>
                    </thead>
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    $search = $_POST['search'];

                    if ($search != null || $search != "") {

                      if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        if (isset($_POST['search'])) {
                          $query1 = "select * from barang where kode like '%$search%' or nama like '%$search%' or brand like '%$search%' order by barang.no limit $rpp";
                          $hasil = mysqli_query($conn, $query1);
                          $no = 1;
                          while ($fill = mysqli_fetch_assoc($hasil)) {
                    ?>
                            <tbody>
                              <tr>
                                <td><?php echo ++$no_urut; ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['terjual']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['terbeli']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['deposit']); ?></td>
                              </tr><?php;
                                }

                                  ?>
                            </tbody>
                  </table>
                  <div align="right"><?php if ($tcount >= $rpp) {
                                        echo paginate_one($reload, $page, $tpages);
                                      } else {
                                      } ?></div>
              <?php }
                        }
                      }
                    } else {
                      while (($count < $rpp) && ($i < $tcount)) {
                        mysqli_data_seek($result, $i);
                        $fill = mysqli_fetch_array($result);
              ?>
              <tbody>
                <tr>
                  <td><?php echo ++$no_urut; ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['terjual']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['terbeli']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['deposit']); ?></td>
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

            <?php } else {
          } ?>
            <div align="right" style="padding-right:15px" class="no-print" id="no-print">
              <div align="left" class="no-print" id="no-print"> <a onclick="javascript:printDiv('tabel1');" class="btn btn-default btn-flat" name="cetak" value="cetak"><span class="glyphicon glyphicon-print"></span></a><?php echo " "; ?>
                <a onclick="window.location.href='configuration/config_export?forward=<?php echo $forward; ?>&search=<?php echo $search; ?>'" class="btn btn-default btn-flat" name="cetak" value="export excel"><span class="glyphicon glyphicon-save-file"></span></a>
              </div> <br />
            </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h3>Data Dalam Satuan</h3>
          </div>
          <div class="card-body">
            <?php
            error_reporting(E_ALL ^ E_DEPRECATED);
            $sql    = "select * from barang order by kode";
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
            <div class="box-body table-responsive">
              <table class="table table-hover ">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama barang</th>
                    <th>Gudang</th>
                    <th>Merek</th>
                    <th>Stok Keluar</th>
                    <th>Stok Masuk</th>
                    <th>Sisa Stok</th>

                  </tr>
                </thead>
                <?php
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                $search = $_POST['search'];

                if ($search != null || $search != "") {

                  if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    if (isset($_POST['search'])) {
                      $query1 = "select * from barang where kode like '%$search%' or nama like '%$search%' or brand like '%$search%' order by barang.no limit $rpp";
                      $hasil = mysqli_query($conn, $query1);
                      $no = 1;
                      while ($fill = mysqli_fetch_assoc($hasil)) {
                ?>
                        <tbody>
                          <tr>
                            <td><?php echo ++$no_urut; ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['terjual']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['terbeli']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['deposit']); ?></td>
                          </tr><?php;
                                }

                                  ?>
                        </tbody>
              </table>
              <div align="right"><?php if ($tcount >= $rpp) {
                                    echo paginate_one($reload, $page, $tpages);
                                  } else {
                                  } ?></div>
          <?php }
                    }
                  }
                } else {
                  while (($count < $rpp) && ($i < $tcount)) {
                    mysqli_data_seek($result, $i);
                    $fill = mysqli_fetch_array($result);
          ?>
          <tbody>
            <tr>
              <td><?php echo ++$no_urut; ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['gudang']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['terjual'] * $fill['jumlah']); ?> <?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['terbeli']  * $fill['jumlah']); ?> <?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['sisa'] * $fill['jumlah']); ?> <?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['deposit']); ?></td>
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


          </div>
        </div>

    </div>
  </div>
</div>
</div>
<?php footer(); ?>