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
<div class="page-wrapper">
  <div class="page-content">
    <!-- SETTING START-->

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    include "configuration/config_chmod.php";
    $halaman = "stok_out"; // halaman
    $dataapa = "Stok Keluar"; // data
    $tabeldatabase = "stok_keluar"; // tabel database
    $tabel = "stok_keluar_daftar";
    $chmod = $chmenu4; // Hak akses Menu
    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
    $search = $_POST['search'];
    $insert = $_POST['insert'];



    function autoNumber()
    {
      include "configuration/config_connect.php";
      global $forward;
      $query = "SELECT MAX(RIGHT(nota, 4)) as max_id FROM stok_keluar ORDER BY nota";
      $result = mysqli_query($conn, $query);
      $data = mysqli_fetch_array($result);
      $id_max = $data['max_id'];
      $sort_num = (int) substr($id_max, 1, 4);
      $sort_num++;
      $new_code = sprintf("%04s", $sort_num);
      return $new_code;
    }

    ?>
    <?php
    if (isset($_POST['barcode'])) {
      $barcode = mysqli_real_escape_string($conn, $_POST["barcode"]);
      $sql1 = "SELECT * FROM barang where barcode='$barcode'";
      $query = mysqli_query($conn, $sql1);
      $data = mysqli_fetch_assoc($query);
      $nama = $data['nama'];
      $kode = $data['kode'];

      $jumlah = '1';
    }
    ?>
    <!-- tambah -->
    <?php

    if (isset($_POST["keluar"])) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
        $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
        $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
        $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
        $stok = mysqli_real_escape_string($conn, $_POST["stok"]);

        $kegiatan = "Stok Keluar";
        $status = "pending";
        $usr = $_SESSION['nama'];
        $today = date('Y-m-d');
        if ($jumlah <= $stok) {

          $brg = mysqli_query($conn, "SELECT * FROM barang WHERE kode='$kode'");
          $ass = mysqli_fetch_assoc($brg);
          $oldstok = $ass['sisa'];
          $oldout = $ass['terjual'];
          $newstok = $oldstok - $jumlah;
          $newout = $oldout + $jumlah;

          $sqlx = "UPDATE barang SET sisa='$newstok', terjual='$newout' WHERE kode='$kode'";
          $updx = mysqli_query($conn, $sqlx);
          if ($updx) {

            $sql = "select * from stok_keluar_daftar where nota='$nota' and kode_barang='$kode'";
            $resulte = mysqli_query($conn, $sql);

            if (mysqli_num_rows($resulte) > 0) {
              $q = mysqli_fetch_assoc($resulte);
              $cart = $q['jumlah'];
              $newcart = $cart + $jumlah;
              $sqlu = "UPDATE stok_keluar_daftar SET jumlah='$newcart' where nota='$nota' AND kode_barang='$kode'";
              $ucart = mysqli_query($conn, $sqlu);
              if ($ucart) {
                echo "<script type='text/javascript'>  alert('Jumlah Stok keluar telah ditambah!');</script>";
                echo "<script type='text/javascript'>window.location = '$halaman';</script>";
              } else {
                echo "<script type='text/javascript'>  alert('GAGAL, Periksa kembali input anda!');</script>";
              }
            } else {

              $sql2 = "insert into stok_keluar_daftar values( '$nota','$kode','$nama','$jumlah','')";
              $insertan = mysqli_query($conn, $sql2);

              if ($insertan) {

                $sql9 = "INSERT INTO mutasi VALUES('$usr','$today','$kode','$newstok','$jumlah','stok keluar','$nota','','pending')";
                $mutasi = mysqli_query($conn, $sql9);


                echo "<script type='text/javascript'>  alert('Produk telah dimasukan dalam daftar!');</script>";
                echo "<script type='text/javascript'>window.location = '$halaman';</script>";
              } else {
                echo "<script type='text/javascript'>  alert('GAGAL memasukan produk, periksa kembali!');</script>";
              }
            }
          } else {
            echo "<script type='text/javascript'>  alert('Gagal mengupdate jumlah stok!');</script>";
            echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          }
        } else {

          echo "<script type='text/javascript'>  alert('Jumlah keluar tidak boleh lebih besar dari stok tersedia!');</script>";
          echo "<script type='text/javascript'>window.location = 'stok_out';</script>";
        }
      }
    }
    ?>
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
      <div class="row">
        <div class="col-lg-5 col-xs-12">
          <div class="card">
            <div class="card-header with-border">
              <h3>Form Stok Keluar</h3>
            </div>
            <div class="card-body">

              <body OnLoad='document.getElementById("barcode").focus();'>
                <form method="post" action="">
                  <div class="row">
                    <div class="form-group">
                      <label for="barang" class="col-sm-2 control-label">Barcode:</label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" id="barcode" name="barcode">
                      </div>
                      <div class="col-sm-2">
                        <b>atau</b>
                      </div>
                    </div>
                  </div>
                </form>

                <div class="row">
                  <div class="form-group">
                    <label for="barang" class="col-sm-2 control-label">Pilih Barang:</label>
                    <div class="col-md-12">
                      <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                        <option selected="selected"> Pilih Barang</option>
                        <?php
                        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                        $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                        while ($row = mysqli_fetch_assoc($sql)) {
                          if ($barcode == $row['barcode'])
                            echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' selected='selected'>" . $row['sku'] . " | " . $row['nama'] . "</option>";
                          else
                            echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <form method="post" action="">
                  <div class="row">
                    <div class="form-group">
                      <label for="barang" class="col-sm-2 control-label">Nama Produk:</label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" readonly id="nama" name="nama" value="<?php echo $nama; ?>">
                        <input type="hidden" class="form-control" readonly id="kode" name="kode" value="<?php echo $kode; ?>">
                        <input type="hidden" class="form-control" readonly id="nota" name="nota" value="<?php echo autoNumber(); ?>">

                      </div>

                    </div>
                  </div>

                  <?php
                  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                  ?>

                  <div class="row">
                    <div class="form-group">
                      <label for="barang" class="col-sm-2 control-label">Stok:</label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" id="stok" name="stok" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <label for="barang" class="col-sm-2 control-label">Jumlah:</label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>">
                      </div>
                      <div class="row mt-1">
                        <div class="col-sm-5">
                          <button type="submit" name="keluar" class="btn btn-warning btn-sm">Tambahkan</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
          </div>
        </div>

        <div class="col-lg-7 col-xs-12">
          <div class="card">
            <div class="card-header with-border">
              <h3>Daftar Keluar</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  error_reporting(E_ALL ^ E_DEPRECATED);

                  $sql    = "select * from stok_keluar_daftar where nota =" . autoNumber() . " order by no";
                  $result = mysqli_query($conn, $sql);
                  $rpp    = 30;
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
                    <table class="data table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th style="width:10px">No</th>
                          <th>Nama Barang</th>
                          <th style="width:10%">Jumlah Keluar</th>

                          <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                            <th style="width:10px">Opsi</th>
                          <?php } else {
                          } ?>
                        </tr>
                      </thead>
                      <?php
                      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                      while (($count < $rpp) && ($i < $tcount)) {
                        mysqli_data_seek($result, $i);
                        $fill = mysqli_fetch_array($result);
                      ?>
                        <tbody>
                          <tr>
                            <td><?php echo ++$no_urut; ?></td>


                            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>

                            <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>

                            <td>
                              <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_stok?get=<?php echo 'out' . '&'; ?>barang=<?php echo $fill['kode_barang'] . '&'; ?>jumlah=<?php echo $fill['jumlah'] . '&'; ?>&kode=<?php echo $kode . '&'; ?>no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $tabel . '&'; ?>forwardpage=<?php echo "" . $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
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
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <form method="post" action="">
                    <div class="row">
                      <div class="form-group col-md-12 col-xs-12">
                        <label for="barang" class="col-sm-2 control-label">Keterangan:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="ket">
                        </div>
                      </div>
                    </div>
                    <br>
                    <input type="hidden" class="form-control" readonly id="notae" name="notae" value="<?php echo autoNumber(); ?>">
                    <div class="row">
                      <div class="form-group col-md-12 col-xs-12">
                        <div class="col-lg-12">
                          <button type="submit" name="simpan" class="btn btn-primary btn-sm">SIMPAN</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>






<?php

      if (isset($_POST["simpan"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nota = mysqli_real_escape_string($conn, $_POST["notae"]);
          $ket = mysqli_real_escape_string($conn, $_POST["ket"]);
          $tgl = date('Y-m-d');
          $usr = $_SESSION['nouser'];
          $cab = '01';

          $kegiatan = "Stok Keluar";

          $sql2 = "insert into stok_keluar values( '$nota','$cab','$tgl','customer','$usr','$ket','')";
          $insertan = mysqli_query($conn, $sql2);

          $mut = "UPDATE mutasi SET status='berhasil', keterangan='$ket' WHERE keterangan='$nota' AND kegiatan='$kegiatan'";
          $muta = mysqli_query($conn, $mut);

          echo "<script type='text/javascript'>  alert('Stok selesai dikeluarkan!');</script>";
          echo "<script type='text/javascript'>window.location = 'stok_out';</script>";
        }
      } ?>
</div>

<?php } elseif ($chmod >= 2 || $_SESSION['jabatan'] == 'user') { ?>
  <div class="row">
    <div class="col-lg-5 col-xs-12">
      <div class="card">
        <div class="card-header with-border">
          <h3>Form Stok Keluar</h3>
        </div>
        <div class="card-body">

          <body OnLoad='document.getElementById("barcode").focus();'>
            <form method="post" action="">
              <div class="row">
                <div class="form-group">
                  <label for="barang" class="col-sm-2 control-label">Barcode:</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="barcode" name="barcode">
                  </div>
                  <div class="col-sm-2">
                    <b>atau</b>
                  </div>
                </div>
              </div>
            </form>

            <div class="row">
              <div class="form-group">
                <label for="barang" class="col-sm-2 control-label">Pilih Barang:</label>
                <div class="col-md-12">
                  <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                    <option selected="selected"> Pilih Barang</option>
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                    while ($row = mysqli_fetch_assoc($sql)) {
                      if ($barcode == $row['barcode'])
                        echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' selected='selected'>" . $row['sku'] . " | " . $row['nama'] . "</option>";
                      else
                        echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <form method="post" action="">
              <div class="row">
                <div class="form-group">
                  <label for="barang" class="col-sm-2 control-label">Nama Produk:</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" readonly id="nama" name="nama" value="<?php echo $nama; ?>">
                    <input type="hidden" class="form-control" readonly id="kode" name="kode" value="<?php echo $kode; ?>">
                    <input type="hidden" class="form-control" readonly id="nota" name="nota" value="<?php echo autoNumber(); ?>">

                  </div>

                </div>
              </div>

              <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
              ?>

              <div class="row">
                <div class="form-group">
                  <label for="barang" class="col-sm-2 control-label">Stok:</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="stok" name="stok" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group">
                  <label for="barang" class="col-sm-2 control-label">Jumlah:</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>">
                  </div>
                  <div class="row mt-1">
                    <div class="col-sm-5">
                      <button type="submit" name="keluar" class="btn btn-warning btn-sm">Tambahkan</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>

    <div class="col-lg-7 col-xs-12">
      <div class="card">
        <div class="card-header with-border">
          <h3>Daftar Keluar</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <?php
              error_reporting(E_ALL ^ E_DEPRECATED);

              $sql    = "select * from stok_keluar_daftar where nota =" . autoNumber() . " order by no";
              $result = mysqli_query($conn, $sql);
              $rpp    = 30;
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
                <table class="data table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th style="width:10px">No</th>
                      <th>Nama Barang</th>
                      <th style="width:10%">Jumlah Keluar</th>

                      <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                        <th style="width:10px">Opsi</th>
                      <?php } else {
                      } ?>
                    </tr>
                  </thead>
                  <?php
                  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                  while (($count < $rpp) && ($i < $tcount)) {
                    mysqli_data_seek($result, $i);
                    $fill = mysqli_fetch_array($result);
                  ?>
                    <tbody>
                      <tr>
                        <td><?php echo ++$no_urut; ?></td>


                        <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>

                        <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>

                        <td>
                          <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                            <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_stok?get=<?php echo 'out' . '&'; ?>barang=<?php echo $fill['kode_barang'] . '&'; ?>jumlah=<?php echo $fill['jumlah'] . '&'; ?>&kode=<?php echo $kode . '&'; ?>no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $tabel . '&'; ?>forwardpage=<?php echo "" . $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
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
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <form method="post" action="">
                <div class="row">
                  <div class="form-group col-md-12 col-xs-12">
                    <label for="barang" class="col-sm-2 control-label">Keterangan:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="ket">
                    </div>
                  </div>
                </div>
                <br>
                <input type="hidden" class="form-control" readonly id="notae" name="notae" value="<?php echo autoNumber(); ?>">
                <div class="row">
                  <div class="form-group col-md-12 col-xs-12">
                    <div class="col-lg-12">
                      <button type="submit" name="simpan" class="btn btn-primary btn-sm">SIMPAN</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>






  <?php

      if (isset($_POST["simpan"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nota = mysqli_real_escape_string($conn, $_POST["notae"]);
          $ket = mysqli_real_escape_string($conn, $_POST["ket"]);
          $tgl = date('Y-m-d');
          $usr = $_SESSION['nouser'];
          $cab = '01';

          $kegiatan = "Stok Keluar";

          $sql2 = "insert into stok_keluar values( '$nota','$cab','$tgl','customer','$usr','$ket','')";
          $insertan = mysqli_query($conn, $sql2);

          $mut = "UPDATE mutasi SET status='berhasil', keterangan='$ket' WHERE keterangan='$nota' AND kegiatan='$kegiatan'";
          $muta = mysqli_query($conn, $mut);

          echo "<script type='text/javascript'>  alert('Stok selesai dikeluarkan!');</script>";
          echo "<script type='text/javascript'>window.location = 'stok_out';</script>";
        }
      } ?>







  </div>
<?php } else { ?>
  <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
  </div>
<?php } ?>


<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dist/plugins/jQuery/jquery-ui.min.js"></script>




<script>
  $("#produk").on("change", function() {

    var nama = $("#produk option:selected").attr("nama");
    var kode = $("#produk option:selected").attr("kode");
    var stok = $("#produk option:selected").attr("stok");


    $("#nama").val(nama);
    $("#kode").val(kode);
    $("#stok").val(stok);
    $("#jumlah").val(1);
  });
</script>



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

<?php footer(); ?>