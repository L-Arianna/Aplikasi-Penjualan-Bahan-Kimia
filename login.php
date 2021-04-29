<?php
error_reporting(0);
session_start();
include "configuration/config_etc.php";
include "configuration/config_include.php";
include 'configuration/config_connect.php';
$queryback = "SELECT * FROM data";
$resultback = mysqli_query($conn, $queryback);
$rowback = mysqli_fetch_assoc($resultback);
$footer = $rowback['nama'];

$queryback = "SELECT * FROM backset";
$resultback = mysqli_query($conn, $queryback);
$rowback = mysqli_fetch_assoc($resultback);
connect();
timing();
?>
<?php head_auth(); ?>


<?php
$username = $password = "";


$tabeldatabase = "user"; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST['txtuser']);
  $password = mysqli_real_escape_string($conn, $_POST['txtpass']);
  $password = md5($password);
  $password = sha1($password);

  $sql = "select * from $forward where userna_me='$username' and pa_ssword='$password'";
  $hasil = mysqli_query($conn, $sql);
  if (mysqli_num_rows($hasil) > 0) {
    $data = mysqli_fetch_assoc($hasil);
    $_SESSION['username'] = $data['userna_me'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['jabatan'] = $data['jabatan'];
    $_SESSION['avatar'] = $data['avatar'];
    $_SESSION['nouser'] = $data['no'];
    $_SESSION['baseurl'] = $baseurl;
    login_validate();
    header("Location: index");
  } else if (mysqli_num_rows($hasil) <= 0) {
    $sql1 = "select * from guru where kode='$username' and password='$password'";
    $hasil1 = mysqli_query($conn, $sql1);
    $data = mysqli_fetch_assoc($hasil1);
    $_SESSION['username'] = $data['kode'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['jabatan'] = $data['jabatan'];
    $_SESSION['avatar'] = $data['avatar'];
    $_SESSION['nouser'] = $data['no'];
    $_SESSION['baseurl'] = $baseurl;
    login_validate();
    header("Location: index");
  } else {
    header("Location: loginagain");
  }
}
?>

<?php error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>
<div class="wrapper">
  <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
    <div class="container-fluid">
      <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
        <div class="col mx-auto">
          <div class="mb-2 text-center">
            <img src="assets/favicon/b.png" width="200" alt="logo icon">
          </div>
          <div class="card">
            <div class="card-body">
              <div class="border p-4 rounded">
                <div class="form-body">
                  <form class="row g-3" action="op.php" method="post">
                    <div class="col-12">
                      <label for="inputChooseUsername" class="form-label">Enter Username</label>
                      <input type="txt" class="form-control" name="txtuser" placeholder="Username" maxlength="20" required>
                    </div>
                    <div class="col-12">
                      <label for="inputChoosePassword" class="form-label">Enter Password</label>
                      <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control border-end-0" name="txtpass" placeholder="Password" maxlength="20" required>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Masuk</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end row-->
    </div>
  </div>
</div>
<?php footer_auth() ?>