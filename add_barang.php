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
    $search = $_POST['search'];
    $insert = $_POST['insert'];

    function autoNumber()
    {
      include "configuration/config_connect.php";
      global $forward;
      $query = "SELECT MAX(RIGHT(kode, 6)) as max_id FROM $forward ORDER BY kode";
      $result = mysqli_query($conn, $query);
      $data = mysqli_fetch_array($result);
      $id_max = $data['max_id'];
      $sort_num = (int) substr($id_max, 1, 6);
      $sort_num++;
      $new_code = sprintf("%06s", $sort_num);
      return $new_code;
    }
    ?>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0 text-uppercase">Data <?php echo $dataapa; ?></h6>
          </div>
          <div class="card-body">
            <!-- BOX INSERT BERHASIL -->

            <script>
              window.setTimeout(function() {
                $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
                  $(this).remove();
                });
              }, 5000);
            </script>


            <!-- BOX INFORMASI -->
            <?php
            if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
            ?>
              <div class="card-body">
                <?php
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                $kode = $nama =  "";
                // $keterangan = $kategori = $brand = $gudang =
                $kode =  $keterangan =  "";
                $kode =  $kategori =  "";
                $kode =  $brand =  "";
                $kode =  $gudang =  "";
                $kode =  $satuan = "";
                $kode =  $avatar =  "";
                $kode =  $gambar =  "";
                $no = $_GET["no"];
                $insert = '1';
                if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {
                  $sql = "select * from $tabeldatabase where no='$no'";
                  $hasil2 = mysqli_query($conn, $sql);
                  while ($fill = mysqli_fetch_assoc($hasil2)) {
                    $kode = $fill["kode"];
                    $sku = $fill["sku"];
                    $nama = $fill["nama"];
                    $satuan = $fill["satuan"];
                    $brand = $fill["brand"];
                    $kategori = $fill["kategori"];
                    $keterangan = $fill["keterangan"];
                    $gudang = $fill["gudang"];
                    $gambar = $fill["avatar"];
                    $insert = '3';
                  }
                }
                ?>

                <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform" enctype="multipart/form-data">

                  <div class="row mb-1">
                    <div class="col-md-3">
                      <label for="form-control">Kode Barang</label>
                      <?php if ($no == null || $no == "") { ?>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
                      <?php } else { ?>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" maxlength="50" required readonly>
                      <?php } ?>

                      <!-- FORM INPUT SKU -->
                      <?php if ($no == null || $no == "") { ?>
                        <input type="hidden" class="form-control" id="sku" name="sku" value="SKU<?php echo autoNumber(); ?>" maxlength="10" required>
                      <?php } else { ?>
                        <input type="hidden" class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>" maxlength="50" required>
                      <?php } ?>
                      <!-- END FORM INPUT SKU -->
                    </div>
                    <div class="col-md-3">
                      <label for="form-control">Nama Barang *</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan Nama Barang" maxlength="50">
                    </div>
                    <div class="col-md-4">
                      <label for="form-control">Satuan Isi Barang*</label>
                      <div class="input-group mb-3">
                        <select class="form-control select2" name="satuan" id="produk" required>
                          <option value="pilih">Pilih</option>
                          <?php
                          $sql = mysqli_query($conn, "select * from satuan");
                          while ($row = mysqli_fetch_assoc($sql)) {
                            if ($satuan == $row['kode_satuan'])
                              echo "<option value='" . $row['kode_satuan'] .  "' satuan='" . $row['satuan_jual'] . "' selected='selected'>" . $row['satuan_isi'] . "</option>";
                            else
                              echo "<option value='" . $row['kode_satuan'] . "' satuan='" . $row['satuan_jual'] . "'>" . $row['satuan_isi'] . "</option>";
                          }
                          ?>
                        </select>
                        <label class="input-group-text satuanspan" for="inputGroupSelect01">Satuan Jual</label>
                      </div>
                    </div>




                    <div class="col-md-2">
                      <label for="form-control">Kategori *</label>
                      <select class="form-control select2" name="kategori">
                        <option value="0">Pilih</option>
                        <?php
                        $sql = mysqli_query($conn, "select * from kategori");
                        while ($row = mysqli_fetch_assoc($sql)) {
                          if ($kategori == $row['nama'])
                            echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                          else
                            echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <label for="form-control">Brand *</label>
                      <select class="form-control select2" name="brand">
                        <option value="0">Pilih</option>
                        <?php
                        $sql = mysqli_query($conn, "select * from brand");
                        while ($row = mysqli_fetch_assoc($sql)) {
                          if ($brand == $row['nama'])
                            echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                          else
                            echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="form-control">Gudang *</label>
                      <select class="form-control select2" name="gudang">
                        <option value="0">Pilih</option>
                        <?php
                        $sql = mysqli_query($conn, "select * from gudang");
                        while ($row = mysqli_fetch_assoc($sql)) {
                          if ($gudang == $row['nama'])
                            echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                          else
                            echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="form-control" value="<?php echo $avatar; ?>">Gambar</label>
                      <input type="file" name="avatar" class="form-control" value="<?php echo $gambar; ?>">
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-md-12">
                      <label for="form-control">Keterangan</label>
                      <textarea class="form-control" id="keterangan" name="keterangan" maxlength="255" placeholder="Masukan Keterangan"><?php echo $keterangan; ?></textarea>
                    </div>
                  </div>

                  <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">

                  <div class="row">
                    <div class="col-md-3">
                      <button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-plus"></span> Simpan</button>
                    </div>
                    <div class="d-flex flex-row-reverse mt-1">
                      <p>* :Wajib diisi.</p>
                    </div>
                  </div>
                </form>





                <script>
                  function sync() {
                    var autobar = document.getElementById('sku');
                    var barcode = document.getElementById('barcode');
                    barcode.value = autobar.value;
                  }
                </script>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                  $sku = mysqli_real_escape_string($conn, $_POST["sku"]);
                  $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
                  $satuan = mysqli_real_escape_string($conn, $_POST["satuan"]);
                  $kategori = mysqli_real_escape_string($conn, $_POST["kategori"]);
                  $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
                  $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
                  $gudang = mysqli_real_escape_string($conn, $_POST["gudang"]);
                  // $barcode = mysqli_real_escape_string($conn, $_POST["barcode"]);
                  $namaavatar = $_FILES['avatar']['name'];
                  $ukuranavatar = $_FILES['avatar']['size'];
                  $tipeavatar = $_FILES['avatar']['type'];
                  $tmp = $_FILES['avatar']['tmp_name'];
                  $avatar = "dist/upload/" . $namaavatar;
                  $insert = ($_POST["insert"]);

                  if ($sku == '0' || $nama == '' || $satuan == '0' || $kategori == '0' || $brand == '0' || $gudang == '0') {
                    echo "<div class='alert alert-danger' role='alert'>
                    Data Yang Anda Masukkan Tidak Sesuai
                    </div>";
                    exit();
                  }

                  $sql = "select * from $tabeldatabase where kode='$kode'";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                    if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
                      move_uploaded_file($tmp, $avatar);
                      $sql1 = "update $tabeldatabase set sku='$sku', nama='$nama', satuan='$satuan', kategori='$kategori', brand='$brand', keterangan='$keterangan', gudang='$gudang',avatar='$avatar' where kode='$kode'";
                      // echo print_r($sql1);
                      $updatean = mysqli_query($conn, $sql1);
                      echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    } else if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {

                      $avatar = "dist/upload/index.jpg";
                      $sql1 = "update $tabeldatabase set sku='$sku', nama='$nama', satuan='$satuan,' kategori='$kategori', brand='$brand', keterangan='$keterangan', gudang='$gudang, avatar='$avatar' where kode='$kode'";
                      $updatean = mysqli_query($conn, $sql1);

                      echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('Gagal, Data Input Tidak Sesuai, gagal diupdate! 318'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    }
                  } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {
                    move_uploaded_file($tmp, $avatar);
                    $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$brand','$keterangan','$gudang','','','','','$avatar','$satuan')";
                    if (mysqli_query($conn, $sql2)) {
                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    } else {
                      $avatar = "dist/upload/index.jpg";
                      $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$brand','$keterangan','$gudang','','','','','$avatar','$satuan')";

                      // echo print_r($sql1);

                      if (mysqli_query($conn, $sql2)) {
                        echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                        echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                      } else {

                        echo "<script type='text/javascript'>  alert('Gagal, Data Input Tidak Sesuai gagal disimpan! 338'); </script>";
                        echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                      }
                    }
                  }
                }

                ?>

                <script>
                  function myFunction() {
                    document.getElementById("Myform").submit();
                  }
                </script>
              </div>
          </div>
        </div>
        <!-- Mnenu untuk user -->
      <?php } elseif ($chmod >= 2 || $_SESSION['jabatan'] == 'user') { ?>
        <div class="card-body">
          <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
              $kode = $nama =  "";
              // $keterangan = $kategori = $brand = $gudang =
              $kode =  $keterangan =  "";
              $kode =  $kategori =  "";
              $kode =  $brand =  "";
              $kode =  $gudang =  "";
              $kode =  $satuan = "";
              $kode =  $avatar =  "";
              $kode =  $gambar =  "";
              $no = $_GET["no"];
              $insert = '1';
              if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'user')) {
                $sql = "select * from $tabeldatabase where no='$no'";
                $hasil2 = mysqli_query($conn, $sql);
                while ($fill = mysqli_fetch_assoc($hasil2)) {
                  $kode = $fill["kode"];
                  $sku = $fill["sku"];
                  $nama = $fill["nama"];
                  $satuan = $fill["satuan"];
                  $brand = $fill["brand"];
                  $kategori = $fill["kategori"];
                  $keterangan = $fill["keterangan"];
                  $gudang = $fill["gudang"];
                  $gambar = $fill["avatar"];
                  $insert = '3';
                }
              }
          ?>

          <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform" enctype="multipart/form-data">

            <div class="row mb-1">
              <div class="col-md-3">
                <label for="form-control">Kode Barang</label>
                <?php if ($no == null || $no == "") { ?>
                  <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
                <?php } else { ?>
                  <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" maxlength="50" required readonly>
                <?php } ?>

                <!-- FORM INPUT SKU -->
                <?php if ($no == null || $no == "") { ?>
                  <input type="hidden" class="form-control" id="sku" name="sku" value="SKU<?php echo autoNumber(); ?>" maxlength="10" required>
                <?php } else { ?>
                  <input type="hidden" class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>" maxlength="50" required>
                <?php } ?>
                <!-- END FORM INPUT SKU -->
              </div>
              <div class="col-md-3">
                <label for="form-control">Nama Barang</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan Nama Barang" maxlength="50">
              </div>
              <div class="col-md-3">
                <!-- <label for="form-control">Satuan</label> -->
                <div class="input-group mb-3">
                  <label class="input-group-text satuanspan" for="inputGroupSelect01">Satuan Jual</label>
                  <select class="form-control select2" style="width: 100%;" name="satuan" id="produk" required>
                    <option value="pilih">Pilih</option>
                    <?php
                    $sql = mysqli_query($conn, "select * from satuan");
                    while ($row = mysqli_fetch_assoc($sql)) {
                      if ($satuan == $row['kode_satuan'])
                        echo "<option value='" . $row['kode_satuan'] .  "' satuan='" . $row['satuan_jual'] . "' selected='selected'>" . $row['satuan_isi'] . "</option>";
                      else
                        echo "<option value='" . $row['kode_satuan'] . "' satuan='" . $row['satuan_jual'] . "'>" . $row['satuan_isi'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>




              <div class="col-md-3">
                <label for="form-control">Kategori</label>
                <select class="form-control select2" name="kategori">
                  <option value="pilih">Pilih</option>
                  <?php
                  $sql = mysqli_query($conn, "select * from kategori");
                  while ($row = mysqli_fetch_assoc($sql)) {
                    if ($kategori == $row['nama'])
                      echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                    else
                      echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <label for="form-control">Brand</label>
                <select class="form-control select2" name="brand">
                  <option value="pilih">Pilih</option>
                  <?php
                  $sql = mysqli_query($conn, "select * from brand");
                  while ($row = mysqli_fetch_assoc($sql)) {
                    if ($brand == $row['nama'])
                      echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                    else
                      echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-3">
                <label for="form-control">Gudang</label>
                <select class="form-control select2" name="gudang">
                  <option value="pilih">Pilih</option>
                  <?php
                  $sql = mysqli_query($conn, "select * from gudang");
                  while ($row = mysqli_fetch_assoc($sql)) {
                    if ($gudang == $row['nama'])
                      echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                    else
                      echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="form-control" value="<?php echo $avatar; ?>">Gambar</label>
                <input type="file" name="avatar" class="form-control" value="<?php echo $gambar; ?>">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-12">
                <label for="form-control">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" maxlength="255" placeholder="Masukan Keterangan"><?php echo $keterangan; ?></textarea>
              </div>
            </div>

            <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">

            <div class="row">
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-plus"></span> Simpan</button>
              </div>
            </div>
          </form>


          <script>
            function sync() {
              var autobar = document.getElementById('sku');
              var barcode = document.getElementById('barcode');
              barcode.value = autobar.value;
            }
          </script>
          <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                $sku = mysqli_real_escape_string($conn, $_POST["sku"]);
                $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
                $satuan = mysqli_real_escape_string($conn, $_POST["satuan"]);
                $kategori = mysqli_real_escape_string($conn, $_POST["kategori"]);
                $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
                $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
                $gudang = mysqli_real_escape_string($conn, $_POST["gudang"]);
                // $barcode = mysqli_real_escape_string($conn, $_POST["barcode"]);
                $namaavatar = $_FILES['avatar']['name'];
                $ukuranavatar = $_FILES['avatar']['size'];
                $tipeavatar = $_FILES['avatar']['type'];
                $tmp = $_FILES['avatar']['tmp_name'];
                $avatar = "dist/upload/" . $namaavatar;
                $insert = ($_POST["insert"]);

                $sql = "select * from $tabeldatabase where kode='$kode'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                  if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') {
                    move_uploaded_file($tmp, $avatar);
                    $sql1 = "update $tabeldatabase set sku='$sku', nama='$nama', satuan='$satuan', kategori='$kategori', brand='$brand', keterangan='$keterangan', gudang='$gudang',avatar='$avatar' where kode='$kode'";
                    // echo print_r($sql1);
                    $updatean = mysqli_query($conn, $sql1);
                    echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                    echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                  } else if ($chmod >= 3 || $_SESSION['jabatan'] == 'user') {

                    $avatar = "dist/upload/index.jpg";
                    $sql1 = "update $tabeldatabase set sku='$sku', nama='$nama', satuan='$satuan,' kategori='$kategori', brand='$brand', keterangan='$keterangan', gudang='$gudang, avatar='$avatar' where kode='$kode'";
                    $updatean = mysqli_query($conn, $sql1);

                    echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                    echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                  } else {
                    echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate! 318'); </script>";
                    echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                  }
                } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'user')) {
                  move_uploaded_file($tmp, $avatar);
                  $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$brand','$keterangan','$gudang','','','','','$avatar','$satuan')";
                  if (mysqli_query($conn, $sql2)) {
                    echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                    echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                  } else {
                    $avatar = "dist/upload/index.jpg";
                    $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$brand','$keterangan','$gudang','','','','','$avatar','$satuan')";

                    // echo print_r($sql1);

                    if (mysqli_query($conn, $sql2)) {
                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    } else {

                      echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! 338'); </script>";
                      echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                    }
                  }
                }
              }

          ?>

          <script>
            function myFunction() {
              document.getElementById("Myform").submit();
            }
          </script>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
  </div>
<?php } ?>
</div>
</div>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dist/plugins/jQuery/jquery-ui.min.js"></script>
<script>
  $(document).ready(function() {
    $("#produk").on("change", function() {

      // var nama = $("#produk option:selected").attr("nama");
      // var kode = $("#produk option:selected").attr("kode");
      // var stok = $("#produk option:selected").attr("stok");
      var satuan = $("#produk option:selected").attr("satuan");
      // $("#nama").val(nama);
      // $("#stok").val(stok);
      // $("#kode").val(kode);
      $(".satuanspan").html(satuan);
      //$(".satuanspan").html(satuan);
      //$("#jumlah").val(1);
    });
  });
</script>


<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/plugins/select2/select2.full.min.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="dist/plugins/iCheck/icheck.min.js"></script> -->

<!--fungsi AUTO Complete-->
<!-- Script -->
<script type='text/javascript'>
  $(function() {

    $("#barcode").autocomplete({
      source: function(request, response) {

        $.ajax({
          url: "server.php",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        $('#nama').val(ui.item.label);
        $('#barcode').val(ui.item.value); // display the selected text
        $('#hargajual').val(ui.item.hjual);
        $('#stok').val(ui.item.sisa); // display the selected text
        $('#hargabeli').val(ui.item.hbeli);
        $('#jumlah').val(ui.item.jumlah);
        $('#kode').val(ui.item.kode); // save selected id to input
        return false;

      }
    });

    // Multiple select
    $("#multi_autocomplete").autocomplete({
      source: function(request, response) {

        var searchText = extractLast(request.term);
        $.ajax({
          url: "server.php",
          type: 'post',
          dataType: "json",
          data: {
            search: searchText
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        var terms = split($('#multi_autocomplete').val());

        terms.pop();

        terms.push(ui.item.label);

        terms.push("");
        $('#multi_autocomplete').val(terms.join(", "));

        // Id
        var terms = split($('#selectuser_ids').val());

        terms.pop();

        terms.push(ui.item.value);

        terms.push("");
        $('#selectuser_ids').val(terms.join(", "));

        return false;
      }

    });
  });

  function split(val) {
    return val.split(/,\s*/);
  }

  function extractLast(term) {
    return split(term).pop();
  }
</script>

<!--AUTO Complete-->

<?php footer(); ?>