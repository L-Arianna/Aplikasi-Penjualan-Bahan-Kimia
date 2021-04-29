<?php
include  "configuration/config_barcode.php"; // include php barcode 128 class
include "configuration/config_connect.php";

$kolom = 5;  // jumlah kolom

if ($_GET['jumlah'] == "") {
	$copy = "1";
} else {
	$copy = $_GET['jumlah'];
} // jumlah copy barcode

$barcode = $_GET['barcode'];
$produk = $_GET['produk'];
$kode = $_GET['kode'];
$counter = 1;
// sql query ke database
$sql_barcode = "SELECT * FROM barang WHERE kode='$kode' ";
$baca_barcode = mysqli_query($conn, $sql_barcode);
$data_barcode = mysqli_fetch_array($baca_barcode);

//menampilkan hasil generate barcode
echo "
<table cellpadding='10'>";
for ($ucopy = 1; $ucopy <= $copy; $ucopy++) {
	if (($counter - 1) % $kolom == '0') {
		echo "
<tr>";
	}
	echo "
<td class='merk'>" . substr($_GET['produk'], 0, 20) . "";
	echo bar128(stripslashes($_GET['barcode']));
	echo "<?php echo $barcode;?>";
	"</td>
";
	if ($counter % $kolom == '0') {
		echo "</tr>
";
	}
	$counter++;
}
echo "</table>
";
?>
<script>
	setTimeout(function() {
		window.print()
	}, 2000);
</script>