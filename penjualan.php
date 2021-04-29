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

    <?php
    if (isset($_POST["submit"])) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
        $bayar = "dibayar";
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
                <p class="mb-0 text-white">Penjualan Total</p>
                <h4 class="my-1 text-white"><sup>Rp</sup><?php echo number_format($inv1a, $decimal, $a_decimal, $thousand); ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-cart-alt'></i>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <a href="" class="text-white ms-auto">Info lengkap</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-danger bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Dana Telah Diterima</p>
                <h4 class="my-1 text-white"><sup>Rp</sup><?php echo number_format($inv2a, $decimal, $a_decimal, $thousand); ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-dollar'></i>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <a href="kategori" class="text-white ms-auto">Info lengkap</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-warning bg-gradient">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Invoice Belum Dibayar</p>
                <h4 class="my-1 text-white"><sup>Rp</sup><?php echo number_format($inv3a, $decimal, $a_decimal, $thousand); ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-user-pin'></i>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <a href="supplier" class="text-white ms-auto">Info lengkap</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 bg-info bg-aqua">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-white">Invoice Lewat jatuh tempo</p>
                <h4 class="my-1 text-white"><sup>Rp</sup><?php echo number_format($inv4a, $decimal, $a_decimal, $thousand); ?></h4>
              </div>
              <div class="text-white ms-auto font-35"><i class='bx bx-user-pin'></i>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <a href="supplier" class="text-white ms-auto">Info lengkap</a>
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
      <div class="card-header">
        <h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
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




          <!-- /.box-header -->
          <!-- /.Paginasi -->
          <?php
          error_reporting(E_ALL ^ E_DEPRECATED);
          $sql    = "select * from sale inner join pelanggan on sale.pelanggan=pelanggan.kode order by sale.nota desc";
          // $sql    = "select * from sale order by nota desc";
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
            <table class="table table-hover table-bordered">
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
                  <th>Pengiriman</th>
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
                    $query1 = "SELECT * from sale inner join pelanggan on sale.pelanggan=pelanggan.kode where sale.nomor like '%$search%' or pelanggan.nama like '%$search%' or sale.status like '%$search%' or sale.duedate <= '$search' or sale.kirim like '%$search%' order by sale.nota DESC limit $rpp ";
                    $hasil = mysqli_query($conn, $query1);
                    $no = 1;
                    while ($fill = mysqli_fetch_assoc($hasil)) {
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
                          <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
                          <td><?php echo mysqli_real_escape_string($conn, $fill['kirim']); ?></td>

                          <td>

                            <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>

                            <?php } ?>
                            <?php if ($fill['status'] == "belum") { ?>
                              <a type="button" class="btn btn-danger btn-sm" onclick="window.location.href='penjualan_batal?q=<?php echo $fill['nota']; ?>'" title="Batal"><i class="bx bx-x"></i></a>

                              <a type="button" class="btn btn-info btn-sm text-white" onclick="window.location.href='invoice_jual?nota=<?php echo $fill['nota'] ?>'" title="Detail"><i class="bx bx-detail"></i></a>

                              <a data-id="<?= $fill['nota'] ?>" data-nama="<?= $fill['nama'] ?>" data-nip="<?= number_format($fill['total']) ?>" data-bank="<?= $pegawai->nama_bank ?>" data-an="<?= $pegawai->atas_nama ?>" data-rek="<?= $pegawai->no_rek ?>" title="Bayar" class="open-AddBookDialog btn btn-success btn-sm"><i class="bx bx-credit-card"></i></a>

                            <?php } else { ?>
                              <a type="button" class="btn btn-info btn-sm text-white" onclick="window.location.href='invoice_jual?nota=<?php echo $fill['nota'] ?>'" title="Detail"><i class="bx bx-detail"></i></a>

                              <a type="button" class="btn btn-primary btn-sm" onclick="window.location.href='surat_jalan?nota=<?php echo $fill['nota'] ?>'" title="Cetak Surat Jalan"><i class="bx bx-printer"></i></a>
                            <?php } ?>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
            </table>
            <div align="right"><?php if ($tcount >= $rpp) {
                                  echo paginate_one($reload, $page, $tpages);
                                } else {
                                }
                                ?></div>
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
              <td><?php echo mysqli_real_escape_string($conn, $fill['nomor']); ?></td>
              <?php $tglsale = date("d-m-Y", strtotime($fill['tglsale'])); ?>
              <td><?php echo mysqli_real_escape_string($conn, $tglsale); ?></td>
              <?php $due = date("d-m-Y", strtotime($fill['duedate'])); ?>
              <td><?php if ($fill['duedate'] <= $now) { ?> <span class="badge bg-warning text-dark"><?php echo $due; ?></span>
                <?php } else { ?>
                  <span class="badge bg-danger"><?php echo $due; ?></span>
                <?php } ?>


              </td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
              <td><?php echo mysqli_real_escape_string($conn, $fill['kirim']); ?></td>

              <td>

                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>

                <?php } ?>
                <?php if ($fill['status'] == "belum") { ?>
                  <a type="button" class="btn btn-danger btn-sm" onclick="window.location.href='penjualan_batal?q=<?php echo $fill['nota']; ?>'" title="Batal"><i class="bx bx-x"></i></a>

                  <a type="button" class="btn btn-info btn-sm text-white" onclick="window.location.href='invoice_jual?nota=<?php echo $fill['nota'] ?>'" title="Detail"><i class="bx bx-detail"></i></a>

                  <a data-id="<?= $fill['nota'] ?>" data-nama="<?= $fill['nama'] ?>" data-nip="<?= number_format($fill['total']) ?>" data-bank="<?= $pegawai->nama_bank ?>" data-an="<?= $pegawai->atas_nama ?>" data-rek="<?= $pegawai->no_rek ?>" title="Bayar" class="open-AddBookDialog btn btn-success btn-sm"><i class="bx bx-credit-card"></i></a>

                <?php } else { ?>
                  <a type="button" class="btn btn-info btn-sm text-white" onclick="window.location.href='invoice_jual?nota=<?php echo $fill['nota'] ?>'" title="Detail"><i class="bx bx-detail"></i></a>

                  <a type="button" class="btn btn-primary btn-sm" onclick="window.location.href='surat_jalan?nota=<?php echo $fill['nota'] ?>'" title="Cetak Surat Jalan"><i class="bx bx-printer"></i></a>
                <?php } ?>
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
        <?php }  ?>
        <div class="col-xs-1" align="right">
          <a href="add_sale" class="btn btn-info btn-sm" role="button">Tambah Penjualan</a>
        </div>
          </div>
      </div>
    </div>
  <?php
        } else {
        }
  ?>
  <!-- Modal -->
  </div>
</div>
<div class="modal fade" id="addBookDialog" tabindex="-1" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selesaikan Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="row mb-1">
            <div class="col-md-4">
              <label for="form-control">Pelanggan</label>
              <input type="hidden" class="form-control" name="nota" id="id_gaji" value="" />
              <input type="text" name="nama" class="form-control" id="nama_pegawai" value="" readonly />
            </div>
            <div class="col-md-4">
              <label for="form-control">Total</label>
              <input type="text" name="total" class="form-control" id="nip" value="" readonly />
            </div>
            <div class="col-md-4">
              <label for="form-control">Status</label>
              <select name="status" class="form-control" required>
                <option value="">Pilih</option>
                <option value="dibayar">bayar</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php footer(); ?>