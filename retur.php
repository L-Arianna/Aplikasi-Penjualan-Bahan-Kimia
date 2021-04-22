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
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- SETTING START-->

        <?php
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        include "configuration/config_chmod.php";
        $halaman = "retur"; // halaman
        $dataapa = "Retur"; // data
        $tabeldatabase = "bayar"; // tabel database
        $tabel = "transaksimasuk"; // tabel database
        $chmod = $chmenu6; // Hak akses Menu
        $forward = mysqli_real_escape_string($conn, $tabel); // tabel database
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
        <script>
            window.setTimeout(function() {
                $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
                    $(this).remove();
                });
            }, 5000);
        </script>
        <h6 class="mb-0 text-uppercase"></h6>
        <hr />
        <div class="card">
            <div class="card-body">
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

                <?php
                if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') {
                ?>

                    <?php

                    $sqla = "SELECT no, COUNT( * ) AS totaldata FROM bayar";
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
                        $sql    = "select * from bayar order by nota desc";
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
                                        <th>Nota</th>
                                        <th>Tgl</th>

                                        <th>Total</th>
                                        <th>Kasir</th>
                                        <th>Pembayaran</th>
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
                                            $query1 = "SELECT * from bayar where nota like '%$search%' or tglbayar like '%$search%' or kasir like '%$search%' order by nota DESC limit $rpp ";
                                            $hasil = mysqli_query($conn, $query1);
                                            $no = 1;
                                            while ($fill = mysqli_fetch_assoc($hasil)) {
                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo ++$no_urut; ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>

                                                        <?php $tglbayar = date("d-m-Y", strtotime($fill['tglbayar'])); ?>
                                                        <td><?php echo mysqli_real_escape_string($conn, $tglbayar); ?>

                                                        </td>

                                                        <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fill['tipebayar']); ?></td>


                                                        <td><?php $nota = $fill['nota'];
                                                            $sql1 = "SELECT * FROM retur where nota='$nota'";
                                                            $hasil1 = mysqli_query($conn, $sql1);
                                                            $row = mysqli_fetch_assoc($hasil1);
                                                            $status = $row['status'];
                                                            if ($status != "Retur") {
                                                                echo "Sukses";
                                                            } else {
                                                                echo $status;
                                                            } ?></td>

                                                        <td>

                                                        <td>




                                                            <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                                                <?php echo "<a href='#myModal' class='btn btn-info btn-sm' id='custId' data-toggle='modal' data-id=" . $fill['nota'] . ">Detail</a>"; ?>


                                                                <script>
                                                                    $('#exampleModal').on('show.bs.modal', event => {
                                                                        var button = $(event.relatedTarget);
                                                                        var modal = $(this);
                                                                        // Use above variables to manipulate the DOM

                                                                    });
                                                                </script>

                                                                <?php if (($chmod >= 4 || $_SESSION['jabatan'] == 'admin') && ($status != "Retur")) { ?>
                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='retur_jual?nota=<?php echo $fill['nota']; ?>'">RETUR</button>
                                                                <?php } else {
                                                                } ?>
                                                                <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                                                                    <button type="button" class="btn btn-success btn-sm" onclick="window.open('print_one?nota=<?php echo $fill['nota']; ?>')">Cetak Struk</button>

                                                            <?php  }
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
                            <td><?php echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
                            <?php $tglbayar = date("d-m-Y", strtotime($fill['tglbayar'])); ?>
                            <td><?php echo mysqli_real_escape_string($conn, $tglbayar); ?>

                            </td>

                            <td><?php echo mysqli_real_escape_string($conn, number_format($fill['total'], $decimal, $a_decimal, $thousand) . ',-'); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
                            <td><?php echo mysqli_real_escape_string($conn, $fill['tipebayar']); ?></td>

                            <td><?php $nota = $fill['nota'];
                                        $sql1 = "SELECT * FROM retur where nota='$nota'";
                                        $hasil1 = mysqli_query($conn, $sql1);
                                        $row = mysqli_fetch_assoc($hasil1);
                                        $status = $row['status'];
                                        if ($status != "Retur") {
                                            echo "Sukses";
                                        } else {
                                            echo $status;
                                        } ?></td>

                            <td>
                                <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                                    <?php echo "<a href='#myModal' class='btn btn-info btn-sm' id='custId' data-toggle='modal' data-id=" . $fill['nota'] . ">Detail</a>"; ?>
                                <?php } else {
                                        } ?>

                                <?php if (($chmod >= 4 || $_SESSION['jabatan'] == 'admin') && ($status != "Retur")) { ?>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='retur_jual?nota=<?php echo $fill['nota']; ?>'">RETUR</button>
                                <?php } else {
                                        } ?>

                                <?php if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                                    <button type="button" class="btn btn-success btn-sm" onclick="window.open('print_one?nota=<?php echo $fill['nota']; ?>')">Cetak Struk</button>

                                <?php  } ?>


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
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
        </div>
        <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->
    <script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>


    <div class="modal fade" id="myModal" role="dialog">
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

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myModal').on('show.bs.modal', function(e) {
                var rowid = $(e.relatedTarget).data('id');
                //menggunakan fungsi ajax untuk pengambilan data
                $.ajax({
                    type: 'post',
                    url: 'retur_fetch.php',
                    data: 'rowid=' + rowid,
                    success: function(data) {
                        $('.fetched-data').html(data); //menampilkan data ke dalam modal
                    }
                });
            });
        });
    </script>
    <?php footer(); ?>