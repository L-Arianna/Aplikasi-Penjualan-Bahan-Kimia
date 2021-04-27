<?php


include 'config_connect.php';
date_default_timezone_set("Asia/Jakarta");
$harisekarang = date('d');
$bulansekarang = date('m');

$tahunsekarang = date('Y');
$now = date('Y-m-d');
$bulanlalu = date('m', strtotime("-1 month"));
$tahunlalu = date('Y', strtotime("-1 year"));
$today = date('d-m-Y : H:i');

// Total Data1

$sqlx2 = "SELECT COUNT(userna_me) as data FROM user";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax1 = $row['data'];

// Total Data2

$sqlx2 = "SELECT COUNT(kode) as data FROM supplier";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax2 = $row['data'];

// Total Data3

$sqlx2 = "SELECT COUNT(kode) as data FROM barang";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax3 = $row['data'];

// Total Data4


$sql = "SELECT batas from backset";
$hasilx2 = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($hasilx2);
$alert = $row['batas'];


$sqlx2 = "SELECT COUNT(kode) as data FROM barang where sisa <= '$alert' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax4 = $row['data'];



// Data Stok

$sqlx2 = "SELECT SUM(sisa) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok1 = $row['data'];

$sqlx2 = "SELECT SUM(terjual) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok2 = $row['data'];

$sqlx2 = "SELECT SUM(terbeli) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok3 = $row['data'];

$sqlx2 = "SELECT COUNT(kode) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok4 = $row['data'];


$sqlx2 = "SELECT SUM(total) AS data FROM buy ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv11 = $row['data'];

$sqlx2 = "SELECT SUM(total) AS data FROM buy WHERE status LIKE '%dibayar%' OR status LIKE '%diterima%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv12 = $row['data'];

$sqlx2 = "SELECT SUM(total) AS data FROM buy WHERE status LIKE '%belum%' OR status LIKE '%hutang%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv13 = $row['data'];

$sqlx2 = "SELECT SUM(total) AS data FROM buy WHERE NOW() <= tglsale  AND status LIKE '%belum%' OR status LIKE '%hutang%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv14 = $row['data'];

$inv15 = $inv13 - $inv14;


// Total Data1-------------------------------------------------------------------

$sqlx2 = "SELECT COUNT(nota) as data FROM buy WHERE status LIKE '%belum%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data11 = $row['data'];

// Total Data2

$sqlx2 = "SELECT COUNT(nota) as data FROM buy WHERE status LIKE '%dibayar%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data21 = $row['data'];

// Total Data3

$sqlx2 = "SELECT COUNT(nota) as data FROM buy WHERE status LIKE '%hutang%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data31 = $row['data'];

// Total Data4

$sqlx2 = "SELECT COUNT(nota) as data FROM buy WHERE diterima!=''";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data41 = $row['data'];

// Total Data1 ------------------------------------------------------------------

$sqlx2 = "SELECT COUNT(nota) as data FROM bayar WHERE nota NOT IN (SELECT nota FROM transaksimasuk)";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data1 = $row['data'];

// Total Data2

$sqlx2 = "SELECT COUNT(nota) as data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data2 = $row['data'];

// Total Data3

$sqlx2 = "SELECT COUNT(nota) as data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data3 = $row['data'];

// Total Data4

$sqlx2 = "SELECT COUNT(nota) as data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data4 = $row['data'];

// Total Data1-------------------------------------------------------------------

$sqlx2 = "SELECT SUM(biaya) AS data FROM operasional";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data14 = $row['data'];

// Total Data2

$sqlx2 = "SELECT SUM(biaya) AS data FROM operasional WHERE tanggal LIKE '$tahunsekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data24 = $row['data'];

// Total Data3

$sqlx2 = "SELECT SUM(biaya) AS data FROM operasional WHERE tanggal LIKE '$tahunsekarang-$bulansekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data34 = $row['data'];

// Total Data4

$sqlx2 = "SELECT SUM(biaya) AS data FROM operasional WHERE tanggal LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data44 = $row['data'];

// Total Data1-------------------------------------------------------------------

$sqlx2 = "SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data12 = $row['data'];

// Total Data2

$sqlx2 = "SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data22 = $row['data'];

// Total Data3

$sqlx2 = "SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data32 = $row['data'];

// Total Data4

$sqlx2 = "SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data42 = $row['data'];
// Total Data1-------------------------------------------------------------------

$sqlx2 = "SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data13 = $row['data'];

// Total Data2

$sqlx2 = "SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data23 = $row['data'];

// Total Data3

$sqlx2 = "SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-%'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data33 = $row['data'];

// Total Data4

$sqlx2 = "SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$data43 = $row['data'];

// Invoice report


$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE status LIKE '%dibayar%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv1 = $row['data'];



$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE status LIKE '%belum%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv2 = $row['data'];


$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE tglsale LIKE '$tahunsekarang-$bulansekarang-%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv3 = $row['data'];


$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE tglsale LIKE '$tahunsekarang-$bulansekarang-$harisekarang' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$invx = $row['data'];
$inv4 = $invx + 0;

// inv laporan kirim
$sqlx2 = "SELECT SUM(biaya) AS data FROM sale WHERE status LIKE '%dibayar%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$lap1 = $row['data'];

$sqlx2 = "SELECT SUM(biaya) AS data FROM sale WHERE status LIKE '%belum%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$lap2 = $row['data'];


$sqlx2 = "SELECT SUM(biaya) AS data FROM sale WHERE tglsale LIKE '$tahunsekarang-$bulansekarang-%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$lap3 = $row['data'];


$sqlx2 = "SELECT SUM(biaya) AS data FROM sale WHERE tglsale LIKE '$tahunsekarang-$bulansekarang-$harisekarang' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$invx = $row['data'];
$lap4 = $invx + 0;

// Data Invoice

$sqlx2 = "SELECT SUM(total) AS data1 FROM sale ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv1a = $row['data1'];

$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE status LIKE '%dibayar%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv2a = $row['data'];

$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE status LIKE '%belum%' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv3a = $row['data'];

$sqlx2 = "SELECT SUM(total) AS data FROM sale WHERE duedate <= '$now' AND status LIKE '%belum%'  ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$inv4a = $row['data'];




//Dashboard stat

//Hutang

//  <0 days
$sqlx2 = "SELECT SUM(total) AS databeli FROM buy WHERE status LIKE '%belum%' AND tglsale > CURDATE() ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$buynow = $row['databeli'] + 0;

//  <30 days
$sqlx2 = "SELECT SUM(total) AS databeli FROM buy WHERE status LIKE '%belum%' AND tglsale BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$buy30 = $row['databeli'] + 0;

//  30 to 60 days
$sqlx2 = "SELECT SUM(total) AS databeli FROM buy WHERE status LIKE '%belum%' AND tglsale BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 30 DAY ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$buy3060 = $row['databeli'] + 0;

//  60 to 90 days
$sqlx2 = "SELECT SUM(total) AS databeli FROM buy WHERE status LIKE '%belum%' AND tglsale  BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND DATE_SUB(NOW(), INTERVAL 60 DAY) ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$buy6090 = $row['databeli'] + 0;

//  >90 days
$sqlx2 = "SELECT SUM(total) AS databeli FROM buy WHERE status LIKE '%belum%' AND tglsale < DATE_SUB(NOW(), INTERVAL 90 DAY) ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$buy90 = $row['databeli'] + 0;


//piutang
//  <0 days
$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%belum%' AND duedate > CURDATE() ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$salenow = $row['datasale'] + 0;

//  <30 days
$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%belum%' AND duedate BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$sale30 = $row['datasale'] + 0;

//  30 to 60 days
$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%belum%' AND duedate BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 30 DAY ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$sale3060 = $row['datasale'] + 0;

//  30 to 60 days
$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%belum%' AND duedate BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE() - INTERVAL 60 DAY ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$sale6090 = $row['datasale'] + 0;

//  >90 days
$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%belum%' AND duedate < DATE_SUB(NOW(), INTERVAL 90 DAY) ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$sale90 = $row['datasale'] + 0;

//retail 1

$sqlx2 = "SELECT SUM(total) AS retail FROM bayar WHERE YEAR(tglbayar) = '$tahunsekarang'  ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$retahun = $row['retail'] + 0;

$sqlx2 = "SELECT SUM(total) AS retail FROM bayar WHERE YEAR(tglbayar) = '$tahunsekarang' AND MONTH(tglbayar) = '$bulanlalu'  ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$rebulanlalu = $row['retail'] + 0;

$sqlx2 = "SELECT SUM(total) AS retail FROM bayar WHERE YEAR(tglbayar) = '$tahunsekarang' AND MONTH(tglbayar) = '$bulansekarang'  ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$rebulan = $row['retail'] + 0;

$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%dibayar%' AND YEAR(duedate) = '$tahunsekarang' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$saleyear = $row['datasale'] + 0;


$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%dibayar%' AND YEAR(duedate) = '$tahunsekarang' AND MONTH(duedate) = '$bulanlalu' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$salelastmonth = $row['datasale'] + 0;


$sqlx2 = "SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%dibayar%' AND YEAR(duedate) = '$tahunsekarang' AND MONTH(duedate) = '$bulansekarang' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$salemonth = $row['datasale'] + 0;



$sqlx2 = "SELECT SUM(biaya) AS operasi FROM operasional WHERE YEAR(tanggal) = '$tahunsekarang' AND MONTH(tanggal) = '$bulansekarang' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$opmonth = $row['operasi'] + 0;



$sqlx2 = "SELECT SUM(biaya) AS operasi FROM operasional WHERE YEAR(tanggal) = '$tahunsekarang' AND MONTH(tanggal) = '$bulanlalu' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$oplastm = $row['operasi'] + 0;

$sqlx2 = "SELECT SUM(biaya) AS operasi FROM operasional WHERE YEAR(tanggal) = '$tahunsekarang' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$opyear = $row['operasi'] + 0;



$sum1 = $rebulan + $salemonth - $opmonth;
$sum2 =  $rebulanlalu + $salelastmonth - $oplastm;
$sum3 =  $retahun + $saleyear - $opyear;
