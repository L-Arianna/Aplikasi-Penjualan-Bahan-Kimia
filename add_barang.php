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
    <div class="row">
      <div class="col-xl-12">
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

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          <div class="breadcrumb-title pe-3">Dashboard</div>
          <div class="ps-3">
            <nav aria-label="breadcrumb">

              <!-- BREADCRUMB -->

              <ol class="breadcrumb mb-0 p-0">
                <li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard /</a></li>
                <li><a href="<?php echo $halaman; ?>"><?php echo $dataapa ?> / </a></li>
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
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <h6 class="mb-0 text-uppercase"></h6>
    <hr />

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
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


              <!-- KONTEN BODY AWAL -->
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Data <?php echo $dataapa; ?></h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                  <div class="table-responsive">
                    <!----------------KONTEN------------------->
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

                    $kode = $nama = $hargabeli = $hargajual = $keterangan = $kategori = $deposit = $brand = $gudang = "";
                    $no = $_GET["no"];
                    $insert = '1';



                    if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {

                      $sql = "select * from $tabeldatabase where no='$no'";
                      $hasil2 = mysqli_query($conn, $sql);


                      while ($fill = mysqli_fetch_assoc($hasil2)) {


                        $kode = $fill["kode"];
                        $sku = $fill["sku"];
                        $nama = $fill["nama"];
                        $brand = $fill["merk"];
                        $kategori = $fill["kategori"];
                        $keterangan = $fill["keterangan"];
                        $gudang = $fill["gudang"];
                        $barcode = $fill["barcode"];
                        $gambar = $fill["avatar"];
                        $insert = '3';
                      }
                    }
                    ?>
                    <div id="main">
                      <div class="container-fluid">

                        <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform" enctype="multipart/form-data">
                          <div class="box-body">

                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12">
                                <label for="kode" class="col-sm-3 control-label">Kode Induk:</label>
                                <div class="col-sm-9">
                                  <?php if ($no == null || $no == "") { ?>
                                    <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
                                  <?php } else { ?>
                                    <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" maxlength="50" required readonly>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>


                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12">
                                <label for="kode" class="col-sm-3 control-label">SKU:</label>
                                <div class="col-sm-9">
                                  <?php if ($no == null || $no == "") { ?>
                                    <input type="text" class="form-control" id="sku" name="sku" value="SKU<?php echo autoNumber(); ?>" maxlength="10" required>
                                  <?php } else { ?>
                                    <input type="text" class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>" maxlength="50" required>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12">
                                <label for="nama" class="col-sm-3 control-label">Nama Barang:</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan Nama" maxlength="50">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12 mb-2">
                                <label for="kategori" class="col-sm-3 control-label"> Kategori:</label>
                                <div class="col-sm-9">
                                  <select class="form-control select2" style="width: 100%;" name="kategori">
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

                              <div class="form-group col-md-6 col-xs-6">
                                <div class="col-sm-9">
                                  <div class="col-xs-1" align="left">
                                    <a href="add_kategori" class="btn btn-info btn-sm" role="button">Tambah Kategori</a>
                                  </div>
                                </div>
                              </div>
                            </div>


                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12 mb-2">
                                <label for="brand" class="col-sm-3 control-label"> Brand:</label>
                                <div class="col-sm-9">
                                  <select class="form-control select2" style="width: 100%;" name="brand">
                                    <option value="pilih">Pilih</option>
                                    <?php
                                    $sql = mysqli_query($conn, "select * from brand");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                      if ($brand == $row['kode'])
                                        echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                                      else
                                        echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group col-md-6 col-xs-6">
                                <div class="col-sm-9">
                                  <div class="col-xs-1" align="left">
                                    <a href="add_merek" class="btn btn-info btn-sm" role="button">Tambah Brand</a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12 mb-2">
                                <label for="brand" class="col-sm-3 control-label"> Gudang:</label>
                                <div class="col-sm-9">
                                  <select class="form-control select2" style="width: 100%;" name="gudang">
                                    <option value="pilih">Pilih</option>
                                    <?php
                                    $sql = mysqli_query($conn, "select * from gudang");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                      if ($gudang == $row['kode'])
                                        echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                                      else
                                        echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group col-md-6 col-xs-6">
                                <div class="col-sm-9">
                                  <div class="col-xs-1" align="left">
                                    <a href="add_gudang" class="btn btn-info btn-sm" role="button">Tambah Gudang</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-9 col-xs-12">
                                <label for="keterangan" class="col-sm-3 control-label">Keterangan:</label>
                                <div class="col-sm-9">
                                  <textarea class="form-control" rows="3" id="keterangan" name="keterangan" maxlength="255" placeholder="Masukan Keterangan" required><?php echo $keterangan; ?></textarea>
                                </div>
                              </div>
                            </div>

                            <?php
                            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                            ?>
                            <div class="row jus">
                              <div class="form-group col-md-9 col-xs-12 mb-2">
                                <label for="nama" class="col-sm-3 control-label">Label Barcode:</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="barcode" name="barcode" value="<?php echo $barcode; ?>" placeholder="Masukan Nama" maxlength="50">
                                </div>
                              </div>


                              <div class="form-group col-md-6 col-xs-6">
                                <div class="col-sm-9">
                                  <div class="col-xs-1" align="left">
                                    <button type="button" class="btn btn-info btn-sm" onclick="sync();">Barcode dr system</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-9 col-xs-12 mb-2">
                              <label for="avatar" value="<?php echo $avatar; ?>" class="col-sm-3 control-label">Gambar</label>
                              <div class="col-sm-9">
                                <input type="file" name="avatar" value="<?php echo $gambar; ?>">
                              </div>
                            </div>
                            <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">
                            <div class="col-sm-3">
                            </div>
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm" name="simpan" onclick="document.getElementById('Myform').submit();"><span class="bx bx-plus"></span> Simpan</button>
                          </div>
                          <!-- /.box-footer -->


                        </form>
                      </div>

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
                        $kategori = mysqli_real_escape_string($conn, $_POST["kategori"]);
                        $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
                        $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
                        $gudang = mysqli_real_escape_string($conn, $_POST["gudang"]);
                        $barcode = mysqli_real_escape_string($conn, $_POST["barcode"]);
                        $namaavatar = $_FILES['avatar']['name'];
                        $ukuranavatar = $_FILES['avatar']['size'];
                        $tipeavatar = $_FILES['avatar']['type'];
                        $tmp = $_FILES['avatar']['tmp_name'];
                        $avatar = "dist/upload/" . $namaavatar;
                        $insert = ($_POST["insert"]);



                        $sql = "select * from $tabeldatabase where kode='$kode'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                          if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
                            move_uploaded_file($tmp, $avatar);
                            $sql1 = "update $tabeldatabase set nama='$nama', sku='$sku', kategori='$kategori', brand='$brand', keterangan='$keterangan', gudang='$gudang','barcode='$barcode', avatar='$avatar' where kode='$kode'";
                            $updatean = mysqli_query($conn, $sql1);
                            echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                            echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                          } else if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {
                            $avatar = "dist/upload/index.jpg";
                            $sql1 = "update $tabeldatabase set nama='$nama', sku='$sku', kategori='$kategori', brand='$brand', keterangan='$keterangan', gudang='$gudang, barcode='$barcode', avatar='$avatar' where kode='$kode'";
                            $updatean = mysqli_query($conn, $sql1);
                            echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                            echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                          } else {

                            echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
                            echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                          }
                        } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {
                          move_uploaded_file($tmp, $avatar);
                          $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$brand','$keterangan','$gudang','$barcode','','','','','$avatar')";
                          if (mysqli_query($conn, $sql2)) {
                            echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                            echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                          } else {
                            $avatar = "dist/upload/index.jpg";
                            $sql2 = "insert into $tabeldatabase values( '','$kode','$sku','$nama','$kategori','$brand','$keterangan','$gudang','$barcode','','','','','$avatar')";

                            // print_r($sql2);

                            if (mysqli_query($conn, $sql2)) {
                              echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                              echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
                            } else {

                              echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
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

                      <!-- KONTEN BODY AKHIR -->

                    </div>
                  </div>

                  <!-- /.box-body -->
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
            <!-- ./col -->
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
footer();
?>