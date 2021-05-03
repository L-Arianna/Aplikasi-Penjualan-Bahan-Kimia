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
    $halaman = "cetak_barcode"; // halaman
    $dataapa = "Form Barcode"; // data
    $tabeldatabase = "barang"; // tabel database
    $chmod = $chmenu5; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    //$search = $_POST['search'];
    $kode = $_GET['kode'];
    $sql = "SELECT * from $tabeldatabase where kode = '$kode' ";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);
    $barcode = $data['barcode'];
    $produk = $data['produk'];
    $nama = $data['nama'];

    // echo print_r($barcode);

    ?>

    <div class="card">
      <div class="card-header with-border">
        <h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
      </div>
      <div class="card-body">
        <div class="col-lg-12">
          <!-- ./col -->
          <!-- SETTING START-->
          <script>
            window.setTimeout(function() {
              $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
                $(this).remove();
              });
            }, 5000);
          </script>
          <!-- BOX INFORMASI -->
          <?php if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') { ?>
            <div class="table-responsive">
              <form class="form-horizontal" method="get" action="print_barcode.php" target="_blank">
                <!-- <div class="box-body"> -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama Barang</label>

                  <div class="col-lg-12">
                    <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                      <option selected="selected"> Pilih Barang</option>
                      <?php
                      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                      $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                      while ($row = mysqli_fetch_assoc($sql)) {
                        if ($barcode == $row['barcode'])
                          echo "<option value='" . $row['nama'] . "' barcode='" . $row['barcode'] . "'  selected='selected'>" . $row['sku'] . " | " . $row['nama'] . "</option>";
                        else
                          echo "<option value='" . $row['nama'] . "' barcode='" . $row['barcode'] . "'  >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Barcode</label>

                  <div class="col-lg-12">
                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Barcode" value="<?php echo $barcode; ?>" required>
                  </div>
                </div>

                <div class="form-group mb-2">
                  <label for="inputPassword3" class="col-sm-2 control-label">Jumlah Print</label>

                  <div class="col-lg-12">
                    <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah print, isikan antara 1- 15" required>
                  </div>
                </div>
                <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>">
                <div class="box-footer">
                  <button type="submit" class="btn btn-info ">Print</button>
                </div>
              </form>
            </div>
          <?php } elseif ($chmod >= 2 || $_SESSION['jabatan'] == 'user') { ?>
            <div class="table-responsive">
              <form class="form-horizontal" method="get" action="print_barcode.php" target="_blank">
                <!-- <div class="box-body"> -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama Barang</label>

                  <div class="col-lg-12">
                    <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                      <option selected="selected"> Pilih Barang</option>
                      <?php
                      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                      $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                      while ($row = mysqli_fetch_assoc($sql)) {
                        if ($barcode == $row['barcode'])
                          echo "<option value='" . $row['nama'] . "' barcode='" . $row['barcode'] . "'  selected='selected'>" . $row['sku'] . " | " . $row['nama'] . "</option>";
                        else
                          echo "<option value='" . $row['nama'] . "' barcode='" . $row['barcode'] . "'  >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Barcode</label>

                  <div class="col-lg-12">
                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Barcode" value="<?php echo $barcode; ?>" required>
                  </div>
                </div>

                <div class="form-group mb-2">
                  <label for="inputPassword3" class="col-sm-2 control-label">Jumlah Print</label>

                  <div class="col-lg-12">
                    <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah print, isikan antara 1- 15" required>
                  </div>
                </div>
                <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>">
                <div class="box-footer">
                  <button type="submit" class="btn btn-info ">Print</button>
                </div>
              </form>
            </div>
          <?php } else { ?>
            <div class="callout callout-danger">
              <h4>Info</h4>
              <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
            </div>
          <?php } ?>
          <!-- ./col -->
        </div>
      </div>
    </div>

  </div>
</div>

<?php footer() ?>