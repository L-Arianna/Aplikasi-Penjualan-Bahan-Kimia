<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";

date_default_timezone_set("Asia/Jakarta");
$today = date('Y-m-d');

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

    <h6 class="mb-0 text-uppercase"></h6>
    <hr />
    <div class="card">
      <div class="card-body">
        <!-- ./col -->

        <!-- SETTING START-->

        <?php
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        include "configuration/config_chmod.php";
        $halaman = "add_sale"; // halaman
        $dataapa = "Invoice Penjualan"; // data
        $tabeldatabase = "invoicejual"; // tabel database
        $chmod = $chmenu6; // Hak akses Menu
        $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
        $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
        $search = $_POST['search'];
        $insert = $_POST['insert'];
        $tabel = "sale";

        function autoNumber()
        {
          include "configuration/config_connect.php";
          global $forward;
          $query = "SELECT MAX(RIGHT(nota, 5)) as max_id FROM sale ORDER BY nota";
          $result = mysqli_query($conn, $query);
          $data = mysqli_fetch_array($result);
          $id_max = $data['max_id'];
          $sort_num = (int) substr($id_max, 1, 5);
          $sort_num++;
          $new_code = sprintf("%05s", $sort_num);
          return $new_code;
        }
        ?>

        <?php
        $decimal = "0";
        $a_decimal = ",";
        $thousand = ".";
        ?>


        <!-- SETTING STOP -->

        <script>
          function SubmitForm() {
            var kode = $("#kode").val();
            var barang = $("#barang").val();
            var nama = $("#nama").val();
            var hargajual = $("#hargajual").val();
            var jumlah = $("#jumlah").val();
            var hargaakhir = $("#hargaakhir").val();
            var datatotal = $("#datatotal").val();

            //alert("Produk : "+nama+"\nTelah berhasil ditambahkan!");

            $.post("add_sale.php", {
              kode: kode,
              barang: barang,
              nama: nama,
              hargajual: hargajual,
              jumlah: jumlah,
              hargaakhir: hargaakhir,
              datatotal: datatotal
            }, function(data) {

            });


          }
        </script>

        <!-- BOX INSERT BERHASIL -->

        <script>
          window.setTimeout(function() {
            $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
              $(this).remove();
            });
          }, 5000);
        </script>
        <?php
        if ($insert == "10") {
        ?>
          <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> Berhasil!</strong> <?php echo $dataapa; ?> telah berhasil <b>ditambahkan</b> ke Data <?php echo $dataapa; ?>.
          </div>

        <?php
        }
        if ($insert == "3") {
        ?>
          <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> Berhasil!</strong> <?php echo $dataapa; ?> telah <b>terupdate</b>.
          </div>

          <!-- BOX UPDATE GAGAL -->
        <?php
        }
        ?>

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

                $kode = $nama = $hargajual = $jumlah = $hargaakhir = $tglnota = $bayar = $kembalian = "";
                $no = $_GET["no"];
                $kode = $_POST['kode'];
                $hargaakhir = $_POST['hargaakhir'];
                $tglnota = $_POST['tglnota'];
                $datatotal = $_POST['datatotal'];
                $insert = '1';



                if (($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')) {

                  $sql = "select * from $tabeldatabase where kode='$kode'";
                  $hasil2 = mysqli_query($conn, $sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)) {


                    $kode = $fill["kode"];
                    $nama = $fill["nama"];
                    $insert = '3';
                  }
                }
                ?>
                <?php

                if ($kode == null || $kode == "") {

                  $sqle = "SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota=" . autoNumber() . "";
                  $hasile = mysqli_query($conn, $sqle);
                  $row = mysqli_fetch_assoc($hasile);
                  $datatotal = $row['data'];
                } else {

                  $sqle = "SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota='$kode'";
                  $hasile = mysqli_query($conn, $sqle);
                  $row = mysqli_fetch_assoc($hasile);
                  $datatotal = $row['data'];
                }


                if (isset($_POST["tambah"])) {
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
                    $barang = mysqli_real_escape_string($conn, $_POST["barang"]);
                    $hargajual = mysqli_real_escape_string($conn, $_POST["hargajual"]);
                    $hargabeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
                    $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);

                    $modal = $hargabeli * $jumlah;

                    $total_satuan = mysqli_real_escape_string($conn, $_POST["total_satuan"]);
                    $satuan = mysqli_real_escape_string($conn, $_POST["satuan"]);
                    $jumlah_satuan = mysqli_real_escape_string($conn, $_POST["jumlah_satuan"]);

                    $hargaakhir = mysqli_real_escape_string($conn, $_POST["hargaakhir"]);
                    $stok = mysqli_real_escape_string($conn, $_POST["stok"]);
                    $kasir = $_SESSION["username"];
                    $kegiatan = "menjual barang memakai invoice";
                    $status = "pending";
                    $insert = ($_POST["insert"]);


                    $sql = "select * from $tabeldatabase where nota='$kode' and kode='$barang'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {

                      echo "<script type='text/javascript'>  alert('Barang sudah ada, silakan hapus dahulu untuk merubah!');</script>";
                    } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin') && ($jumlah <= $stok && $jumlah >= '1' && $stok >= '0')) {
                      //masukan ke cart
                      $sql2 = "insert into $tabeldatabase values( '$kode','$barang','$nama','$hargajual','$jumlah','$hargaakhir','$modal','$total_satuan','$satuan','$jumlah_satuan','')";
                      $insertan = mysqli_query($conn, $sql2);
                      //update stok barang
                      $sqle3 = "SELECT * FROM barang where kode='$barang'";
                      $hasile3 = mysqli_query($conn, $sqle3);
                      $row = mysqli_fetch_assoc($hasile3);
                      $sisaawal = $row['sisa'];
                      $terbeliawal = $row['terbeli'];
                      $terjualawal = $row['terjual'];

                      $terjualakhir = $terjualawal + $jumlah;
                      $sisaakhir = $sisaawal - $jumlah;
                      $kurang = 0 - $jumlah;


                      $sql3 = "UPDATE barang SET sisa='$sisaakhir',terjual='$terjualakhir' where kode='$barang'";
                      $updatestok = mysqli_query($conn, $sql3);
                      //merekam mutasi
                      $sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$barang','$sisaakhir','$kurang','$kegiatan','$kode','','$status')";
                      $mutasi = mysqli_query($conn, $sql4);

                      echo "<script type='text/javascript'>  alert('Berhasil, Produk telah berhasil ditambahkan!');</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('Gagal, Stok Kurang / Jumlah tidak boleh kosong!');</script>";
                    }
                  }
                }




                if (isset($_POST["simpan"])) {
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
                    $duedate = mysqli_real_escape_string($conn, $_POST["duedate"]);

                    $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
                    $supplier = mysqli_real_escape_string($conn, $_POST["supplier"]);
                    $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
                    $kasir = $_SESSION["username"];
                    $berhasil = "berhasil";
                    $belum = "belum";
                    $insert = ($_POST["insert"]);


                    $sql = "select * from $tabel where nota='$kode'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {

                      echo "<script type='text/javascript'>  alert('Data tidak bisa diubah!');</script>";
                    } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {

                      $sql2 = "insert into $tabel values( '$kode','$tglnota','$duedate','$datatotal','$supplier','$kasir','$keterangan','','$belum')";
                      $insertan = mysqli_query($conn, $sql2);
                      //update mutasi
                      $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$kode'";
                      $updatemutasi = mysqli_query($conn, $sql3);


                      echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                      echo "<script type='text/javascript'>window.location = 'penjualan';</script>";
                    } else {
                      echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan pembayaran benar');</script>";
                    }
                  }
                }



                if ($kode == null || $kode == "") {

                  $sqle = "SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota=" . autoNumber() . "";
                  $hasile = mysqli_query($conn, $sqle);
                  $row = mysqli_fetch_assoc($hasile);
                  $datatotal = $row['data'];
                } else {

                  $sqle = "SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota='$kode'";
                  $hasile = mysqli_query($conn, $sqle);
                  $row = mysqli_fetch_assoc($hasile);
                  $datatotal = $row['data'];
                }
                ?>


                <div id="main">
                  <div class="container-fluid">

                    <form class="form-horizontal" method="post" action="<?php echo $halaman; ?>" id="Myform" class="form-user">
                      <div class="box-body">

                        <div class="row">

                          <div class="col-md-6">
                            <div class="box box-info">
                              <div class="box-body">


                                <div class="form-group col-md-6 col-xs-12">
                                  <label for="kode" class="col-sm-4 control-label">Kode Transaksi:</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-xs-12">
                                  <label for="tglnota" class="col-sm-4 control-label">Jatuh Tempo:</label>
                                  <div class="col-sm-8">
                                    <input type="date" class="form-control pull-right" id="datepicker" name="duedate" placeholder="Masukan Tanggal Nota" value="<?php echo $tglnota; ?>">

                                    <input type="hidden" class="form-control pull-right" id="datepicker2" name="tglnota">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="barang" class="col-sm-2 control-label">Pilih Barang:</label>
                                    <div class="col-sm-10">
                                      <select class="form-control select2" style="width: 100%;" name="barang" id="barang">
                                        <option></option>
                                        <?php
                                        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                                        $sql = mysqli_query($conn, "select * from barang");
                                        // $sql = mysqli_query($conn, "SELECT * FROM `barang`");
                                        while ($row = mysqli_fetch_assoc($sql)) {
                                          if ($barang == $row['kode'])
                                            echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' gudang='" . $row['gudang'] . "' hargajual='" . $row['hargajual'] . "' hargabeli='" . $row['hargabeli'] . "' sisa='" . $row['sisa'] . "' selected='selected'>" . $row['sku'] . " | " . $row['nama'] . "|" .  $row['gudang'] . "</option>";
                                          else
                                            echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' gudang='" . $row['gudang'] .  "' hargajual='" . $row['hargajual'] . "' hargabeli='" . $row['hargabeli'] . "' sisa='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . " | " . $row['gudang'] . "</option>";
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="box box-danger">
                              <div class="box-body">

                                <div class="row">
                                  <div class="form-group col-md-12 col-xs-12">
                                    <div class="col-sm-10">

                                      <?php if ($datatotal == "" || $datatotal == null) { ?>
                                        <h1 align="center">Rp <?php echo '0' . ',-'; ?></h1>
                                      <?php } else { ?>
                                        <h1 align="center">Rp <?php echo number_format($datatotal, $decimal, $a_decimal, $thousand) . ',-'; ?></h1>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>


                              </div>
                            </div>
                          </div>


                          <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert; ?>" maxlength="1">


                        </div>

                        <div class="row">
                          <!-- <div class="col-md-12"> -->
                          <div class="box box-default">
                            <div class="box-body">

                              <div class="row">

                                <div class="col-sm-2">
                                  <label for="usr">Nama Barang</label>
                                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" readonly>
                                </div>

                                <div class="col-sm-1">
                                  <label for="usr">Sisa Stok</label>
                                  <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok; ?>" readonly>
                                </div>
                                <div class="col-sm-1">
                                  <label for="usr">Satuan</label>
                                  <select class="form-control" name="satuan" id="provinsi">
                                    <option value="">Pilih</option>
                                    <?php
                                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                                    $sqle7 = "SELECT * FROM satuan where kode='$satuan'";
                                    $hasile7 = mysqli_query($conn, $sqle7);
                                    $row = mysqli_fetch_assoc($hasile7);
                                    $sql = mysqli_query($conn, "select * from satuan");
                                    // $sql = mysqli_query($conn, "SELECT * FROM `barang`");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                      if ($satuan == $row['kode'])
                                        echo "<option value='" . $row['nama_satuan'] . "' nama='" . $row['nama_satuan'] . "' selected='selected'>" . $row['nama_satuan'] . $row['convert'] . "</option>";
                                      else
                                        echo "<option value='" . $row['nama_satuan'] . "' nama='" . $row['nama_satuan'] . "' >" . $row['nama_satuan'] . "(" . $row['convert'] . ")" . "</option>";
                                    }
                                    ?>
                                  </select>
                                  <!-- <input type="text" class="form-control" id="stok" name="stok" value=""> -->
                                </div>
                                <script>
                                  function sum() {
                                    var txtFirstNumberValue = document.getElementById('jumlah').value
                                    var txtSecondNumberValue = document.getElementById('hargajual').value;
                                    var txtTreeNumberValue = document.getElementById('kota').value;
                                    var txtFourNumberValue = document.getElementById('kotar').value;
                                    var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
                                    if (!isNaN(result)) {
                                      document.getElementById('hargaakhir').value = result;
                                    }
                                    if (!$(jumlah).val()) {
                                      document.getElementById('hargaakhir').value = "0";
                                    }
                                    if (!$(hargajual).val()) {
                                      document.getElementById('hargaakhir').value = "0";
                                    }

                                    var result = parseFloat(txtFirstNumberValue) * parseFloat(txtTreeNumberValue);
                                    if (!isNaN(result)) {
                                      document.getElementById('kotar').value = result;
                                    }
                                    if (!$(jumlah).val()) {
                                      document.getElementById('kotar').value = "0";
                                    }
                                    if (!$(kota).val()) {
                                      document.getElementById('kotar').value = "0";
                                    }
                                  }
                                </script>


                                <div class="col-sm-1">
                                  <label for="usr">Jumlah Satuan</label>
                                  <select class="form-control" name="jumlah_satuan" id="kota" onkeyup="sum();">
                                    <option value="">Pilih</option>
                                  </select>
                                </div>
                                <div class="col-sm-1">
                                  <label for="usr">Total Satuan</label>
                                  <input type="text" class="form-control" id="kotar" name="total_satuan" value="" readonly>
                                </div>
                                <div class="col-sm-2">
                                  <label for="usr">Harga</label>
                                  <input type="text" class="form-control" id="hargajual" name="hargajual" placeholder="masukan harga barang">
                                </div>

                                <div class="col-sm-2">
                                  <label for="usr">Jumlah Jual</label>
                                  <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" placeholder="Masukan Jumlah" onkeyup="sum();">
                                </div>

                                <div class="col-sm-2">
                                  <label for="usr">Total Bayaran</label>
                                  <input type="text" class="form-control" id="hargaakhir" name="hargaakhir" value="<?php echo $hargaakhir; ?>" readonly>
                                </div>

                              </div>
                              </br>
                              <button type="submit" class="btn btn-block pull-left btn-flat btn-info" name="tambah" onclick="SubmitForm()"><span class="glyphicon glyphicon-shopping-cart"></span> Tambah</button>



                            </div>
                          </div>
                          <!-- </div> -->
                        </div>



                        <div class="row">
                          <div class="col-md-12">
                            <div class="box box-success">
                              <div class="box-header with-border">
                                <b>Daftar Barang</b>
                              </div>

                              <?php
                              error_reporting(E_ALL ^ E_DEPRECATED);

                              $sql    = "select * from $tabeldatabase where nota =" . autoNumber() . " order by no";
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
                                <table class="data table table-hover table-bordered">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Kode Barang</th>
                                      <th>Nama Barang</th>
                                      <th>Harga</th>
                                      <th>Jenis Satuan</th>
                                      <th>Total Satuan</th>
                                      <th>Jumlah Jual</th>
                                      <th>Total Bayar</th>
                                      <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                        <th>Opsi</th>
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
                                        <td><?php echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
                                        <td><?php $cba = $fill['kode'];
                                            $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sku FROM barang WHERE kode='$cba'"));
                                            echo mysqli_real_escape_string($conn, $r['sku']); ?>
                                        </td>
                                        <td><?php echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                                        <td><?php echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
                                        <td><?php echo mysqli_real_escape_string($conn, $fill['total_satuan']); ?></td>
                                        <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                                        <td><?php echo mysqli_real_escape_string($conn, number_format(($fill['jumlah'] * $fill['harga']), $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                                        <td>
                                          <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_produk?get=<?php echo '1' . '&'; ?>barang=<?php echo $fill['kode'] . '&'; ?>jumlah=<?php echo $fill['jumlah'] . '&'; ?>kode=<?php echo $kode . '&'; ?>no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $forward . '&'; ?>forwardpage=<?php echo $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
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
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <div class="col-sm-6">
                          <input type="button" class="btn btn-block pull-left btn-flat btn-danger" onclick="window.open('bayar_inv?nota=<?php echo autoNumber(); ?>','_self')" value="SELANJUTNYA" />
                        </div>
                      </div>
                      <!-- /.box-footer -->


                    </form>
                  </div>
                  <script>
                    function myFunction() {
                      document.getElementById("Myform").submit();
                    }
                  </script>

                  <!-- KONTEN BODY AKHIR -->

                </div>








              </div>
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

      <!-- /.row (main row) -->
      <!-- /.content -->
    </div>
  </div>
</div>
<!-- /.content-wrapper -->

<!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="1-11-4-jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
  $("#barang").on("change", function() {

    var nama = $("#barang option:selected").attr("nama");
    var hargajual = $("#barang option:selected").attr("hargajual");
    var sisa = $("#barang option:selected").attr("sisa");
    var hargabeli = $("#barang option:selected").attr("hargabeli");

    $("#nama").val(nama);
    $("#hargajual").val(hargajual);
    $("#stok").val(sisa);
    $("#hargaakhir").val(0);
    $("#hargabeli").val(hargabeli);
    $("#jumlah").val(0);
  });
</script>

<!-- 
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="dist/plugins/morris/morris.min.js"></script>
<script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="dist/plugins/knob/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
<script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/plugins/select2/select2.full.min.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/plugins/iCheck/icheck.min.js"></script> -->
<script>
  $(function() {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {
      "placeholder": "yyyy/mm/dd"
    });
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {
      "placeholder": "yyyy/mm/dd"
    });
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      format: 'YYYY/MM/DD h:mm A'
    });
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Hari Ini': [moment(), moment()],
          'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
          'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
          'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
          'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
    );

    //Date picker
    $('#datepicker').datepicker('update', new Date());

    $('#datepicker').datepicker({
      autoclose: true
    });

    $('.datepicker').datepicker({
      dateFormat: 'yyyy-mm-dd'
    });

    //Date picker 2
    $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

    $('.datepicker2').datepicker({
      dateFormat: 'yyyy-mm-dd'
    });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
<?php footer(); ?>