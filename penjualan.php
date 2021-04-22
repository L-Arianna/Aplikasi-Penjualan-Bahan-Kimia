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

pagination();
date_default_timezone_set("Asia/Jakarta");
$now = date('Y-m-d');
?>
<?php
$decimal = "0";
$a_decimal = ",";
$thousand = ".";
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
<div class="page-wrapper">
  <div class="page-content">

    <h6 class="mb-0 text-uppercase"></h6>
    <hr />

    <!-- SETTING START-->

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "penjualan"; // halaman
    $dataapa = "invoice Penjualan"; // data
    $tabeldatabase = "sale"; // tabel database
    $tabel = "invoicejual"; // tabel database
    $chmod = $chmenu5; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $search = $_POST['search'];
    $today = date('Y-m-d');
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

    <?php
    if (isset($_POST["simpan"])) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
        $payday = mysqli_real_escape_string($conn, $_POST["payday"]);
        $bank = mysqli_real_escape_string($conn, $_POST["bank"]);
        $cara = mysqli_real_escape_string($conn, $_POST["cara"]);
        $ref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $tipe = 2;
        $bayar = "dibayar";

        $sql2 = "insert into payment values( '$tipe','$nota','$cara','$bank','$ref','$payday','')";
        $insertan = mysqli_query($conn, $sql2);
        $sale = "UPDATE sale SET status='$bayar' where nota='$nota'  ";
        $update = mysqli_query($conn, $sale);
        echo "<script type='text/javascript'>  alert('Berhasil, Pembayaran untuk kode transaksi $nota berhasil!'); </script>";
      }
    }
    ?>

    <!-- BREADCRUMB -->


    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
      <div class="col">
        <div class="card radius-10 bg-primary bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p>Penjualan Total</p>
                <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv1a, $decimal, $a_decimal, $thousand); ?></h3>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <a href="" class="text-white ms-auto">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-danger bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p>Dana Telah Diterima</p>
                <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv2a, $decimal, $a_decimal, $thousand); ?></h3>
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
                <p>Invoice Belum Dibayar</p>
                <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv3a, $decimal, $a_decimal, $thousand); ?></h3>
                <!-- <p class="mb-0 text-white">Total Supplier</p>
                      <h4 class="text-white my-1"><?php echo $datax2; ?></h4> -->
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
                <p>Invoice Lewat jatuh tempo</p>
                <h3 style="font-size: 30px"><sup style="font-size: 20px">Rp</sup><?php echo number_format($inv4a, $decimal, $a_decimal, $thousand); ?></h3>
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
    </div>
    <!-- /.row -->

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
      <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Berhasil!</strong> <?php echo $dataapa; ?> tidak bisa dihapus dari Data <?php echo $dataapa; ?> karena telah melakukan transaksi sebelumnya, gunakan menu update untuk merubah informasi <?php echo $dataapa; ?> .
      </div>
    <?php
    } elseif ($hapusberhasil == 8) {
    ?>
      <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Berhasil!</strong> <?php echo $dataapa; ?> telah berhasil diupdate status pembayarannya, pastikan terus tagih yang sudah lewat jatuh tempo!
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
    <div class="card">
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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data <?php echo $dataapa ?> <span class="label label-default"><?php echo $totaldata; ?></span>
              </h3>

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

            <!-- /.box-header -->
            <!-- /.Paginasi -->
            <?php
            error_reporting(E_ALL ^ E_DEPRECATED);
            // $sql    = "select * from sale inner join pelanggan on sale.pelanggan=pelanggan.kode order by sale.nota desc";
            $sql    = "select * from sale order by nota desc";
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
                    <th>No.Invoice</th>
                    <th>Tgl Pembuatan</th>
                    <th>Jatuh Tempo</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Kasir</th>
                    <th>Status</th>
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
                      $query1 = "SELECT * from sale where sale.nomor like '%$search%' or sale.pelanggan like '%$search%' or sale.status like '%$search%' or sale.duedate <= '$search' order by sale.nota DESC limit $rpp ";
                      $hasil = mysqli_query($conn, $query1);
                      $no = 1;
                      while ($fill = mysqli_fetch_assoc($hasil)) {
                ?>
                        <tbody>
                          <tr>
                            <td><?php echo ++$no_urut; ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['nomor']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['tglsale']); ?></td>
                            <?php $due = date("d-m-Y", strtotime($fill['duedate'])); ?>


                            <td><?php if ($fill['duedate'] <= $now) { ?> <span class="badge bg-warning text-dark"><?php echo $due; ?></span>
                              <?php } else { ?>
                                <span class="badge bg-danger"><?php echo $due; ?></span>
                              <?php } ?>
                            </td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['pelanggan']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>

                            <td><?php echo mysqli_real_escape_string($conn, $fill['status']); ?></td>

                            <td>


                              <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='penjualan_batal?q=<?php echo $fill['nota']; ?>'">Batal</button>
                              <?php } else {
                              } ?>

                              <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                <button type="button" class="btn btn-info btn-sm" onclick="window.location.href='Invoice_jual?nota=<?php echo $fill['nota'] ?>'">Detail</button>

                                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='surat_jalan?nota=<?php echo $fill['nota'] ?>'">Cetak Surat Jalan</button>

                                <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                                  <?php if ($fill['status'] == 'belum') { ?>

                                    <?php echo "<a href='#myModal' class='btn btn-warning btn-sm' id='custId' data-toggle='modal' data-id=" . $fill['nota'] . ">BAYAR</a>"; ?>
                              <?php  } else echo "<a href='#myModal' class='btn btn-success btn-sm' id='custId' data-toggle='modal' data-id=" . $fill['nota'] . ">INFO BAYAR</a>";
                                }
                              } else {
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
                                  }
                                  ?></div>
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
              <td><?php echo mysqli_real_escape_string($conn, $fill['nomor']); ?></td>
              <?php $tglsale = date("d-m-Y", strtotime($fill['tglsale'])); ?>
              <td><?php echo mysqli_real_escape_string($conn, $tglsale); ?></td>
              <?php $due = date("d-m-Y", strtotime($fill['duedate'])); ?>
              <td><?php if ($fill['duedate'] <= $now) { ?> <span class="badge bg-warning text-dark"><?php echo $due; ?></span>
                <?php } else { ?>
                  <span class="badge bg-danger"><?php echo $due; ?></span>
                <?php } ?>


              </td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['pelanggan']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['status']); ?></td>

              <td>

                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                  <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='penjualan_batal?q=<?php echo $fill['nota']; ?>'">Batal</button>
                <?php } else {
                    } ?>
                <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                  <button type="button" class="btn btn-info btn-sm" onclick="window.location.href='invoice_jual?nota=<?php echo $fill['nota'] ?>'">Detail</button>
                  <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='surat_jalan?nota=<?php echo $fill['nota'] ?>'">Cetak Surat Jalan</button>
                <?php } else {
                    } ?>

                <?php if ($fill['status'] == "dibayar") { ?>

                  <?php echo "<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modelId'" . $fill['nota'] . ">INFO BAYAR</button>"; ?>

                <?php  } else { ?>
                  <?php echo "<a href='#myModal' class='btn btn-warning btn-sm' id='custId' data-toggle='modal' data-id=" . $fill['nota'] . ">BAYAR</a>"; ?>
                <?php } ?>
              </td>
            </tr>
          <?php
                    $i++;
                    $count++;
                  }


          ?>
          <script>
            $('#exampleModal').on('show.bs.modal', event => {
              var button = $(event.relatedTarget);
              var modal = $(this);
              // Use above variables to manipulate the DOM

            });
          </script>
          </tbody>
          </table>
          <div align="right"><?php if ($tcount >= $rpp) {
                                echo paginate_one($reload, $page, $tpages);
                              } else {
                              } ?></div>
        <?php }  ?>
        <div class="col-xs-1" align="right">
          <a href="add_sale" class="btn btn-info" role="button">Tambah Penjualan</a>
        </div>
            </div>


            <!-- /.box-body -->
          </div>




        <?php
        } else {
        }
        ?>

      </div>
    </div>


    <script>
      $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM

      });
    </script>

    <script>
      $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM

      });
    </script>
    <div class="modal fade" id="modelId" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Detail Transaksi</h4>
          </div>
          <div class="modal-body">
            <div class="fetched-data"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
          </div>
        </div>
      </div>
    </div>


    <?php footer(); ?>