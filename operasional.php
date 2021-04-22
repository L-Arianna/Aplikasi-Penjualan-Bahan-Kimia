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


    <!-- SETTING START-->

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "operasional"; // halaman
    $dataapa = "Operasional"; // data
    $tabeldatabase = "operasional"; // tabel database
    $chmod = $chmenu7; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $search = $_POST['search'];

    ?>

    <!-- SETTING STOP -->
    <?php
    $decimal = "0";
    $a_decimal = ",";
    $thousand = ".";
    ?>

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

    <h6 class="mb-0 text-uppercase"></h6>
    <hr />
    <div class="card">
      <div class="card-header">
        <h3>Data <?php echo $forward ?> <span class="label label-default"><?php echo $totaldata; ?></span>
        </h3>
      </div>
      <div class="card-body">
        <?php
        if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') {
        ?>

          <?php

          $sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
          $hasila = mysqli_query($conn, $sqla);
          $rowa = mysqli_fetch_assoc($hasila);
          $totaldata = $rowa['totaldata'];

          ?>
          <form method="post">
            <br />
            <div class="input-group input-group-sm" style="width: 250px;">
              <input type="text" name="search" class="form-control pull-right" placeholder="Cari">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
              </div>
            </div>

          </form>


          <!-- /.box-header -->
          <!-- /.Paginasi -->
          <?php
          error_reporting(E_ALL ^ E_DEPRECATED);
          $sql    = "select * from $forward order by no";
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
            <table class="table table-hover ">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Operasional</th>
                  <th>Nama Keperluan</th>
                  <th>Tipe</th>
                  <th>Tanggal</th>
                  <th>Biaya</th>
                  <th>Keterangan</th>
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
                    $query1 = "SELECT * FROM  $forward where kode like '%$search%' or nama like '%$search%' or tanggal like '%$search%' order by no limit $rpp";
                    $hasil = mysqli_query($conn, $query1);
                    $no = 1;
                    while ($fill = mysqli_fetch_assoc($hasil)) {
              ?>
                      <tbody>
                        <tr>
                          <td><?php echo ++$no_urut; ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>

                          <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['tipe']); ?></td>
                          <?php $tgl = date("d-m-Y", strtotime($fill['tanggal'])); ?>
                          <td><?php echo mysqli_real_escape_string($conn, $tgl); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, number_format($fill['biaya'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
                          <td>
                            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                              <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
                            <?php } else {
                            } ?>

                            <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                              <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
                            <?php } else {
                            } ?>
                          </td>
                        </tr><?php;
                              }

                                ?>
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
        ?>
        <tbody>
          <tr>
            <td><?php echo ++$no_urut; ?></td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>

            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['tipe']); ?></td>
            <?php $tgl = date("d-m-Y", strtotime($fill['tanggal'])); ?>
            <td><?php echo mysqli_real_escape_string($conn, $tgl); ?></td>
            <td><?php echo mysqli_real_escape_string($conn, number_format($fill['biaya'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
            <td><?php echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
            <td>
              <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='add_<?php echo $halaman; ?>?no=<?php echo $fill['no']; ?>'">Edit</button>
              <?php } else {
                  } ?>

              <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
              <?php } else {
                  } ?>
            </td>
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
    </div>
  </div>
</div>
</div>
<!-- /.content-wrapper -->
<?php footer(); ?>