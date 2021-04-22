<?php
// Load file koneksi.php
include "koneksi.php";

// Ambil data ID Provinsi yang dikirim via ajax post
$no = $_POST['provinsi'];

// Buat query untuk menampilkan data kota dengan provinsi tertentu (sesuai yang dipilih user pada form)
$sql = $pdo->prepare("SELECT * FROM satuan WHERE nama_satuan='" . $no . "' ");
$sql->execute(); // Eksekusi querynya

// Buat variabel untuk menampung tag-tag option nya
// Set defaultnya dengan tag option Pilih
$html = "<option value=''>Pilih</option>";

while ($data = $sql->fetch()) { // Ambil semua data dari hasil eksekusi $sql
	$html .= "<option value='" . $data['jumlah'] . "'>" . $data['jumlah'] .  $data['nama_satuan'] . "</option>"; // Tambahkan tag option ke variabel $html
}

$callback = array('data_kota' => $html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

echo json_encode($callback); // konversi varibael $callback menjadi JSON
