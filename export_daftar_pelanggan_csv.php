<?php
// Load file koneksi.php
include "configuration/config_connect.php";

// Load plugin PHPExcel nya
require_once 'PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$csv = new PHPExcel();

// Settingan awal fil excel
$csv->getProperties()->setCreator('IDwares')
	->setLastModifiedBy('Indotory Pro Plus')
	->setTitle("Daftar Nama Pelanggan")
	->setSubject("Daftar Nama Pelanggan")
	->setDescription("Daftar Nama Pelanggan Hasil Export Csv")
	->setKeywords("Daftar Nama Pelanggan");

// Buat header tabel nya pada baris ke 1
$csv->setActiveSheetIndex(0)->setCellValue('A1', "NO"); // Set kolom A1 dengan tulisan "NO"
$csv->setActiveSheetIndex(0)->setCellValue('B1', "Kode Supplier"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
$csv->setActiveSheetIndex(0)->setCellValue('C1', "Nama"); // Set kolom B1 dengan tulisan "NIS"
$csv->setActiveSheetIndex(0)->setCellValue('D1', "Tanggal Daftar"); // Set kolom C1 dengan tulisan "NAMA"
$csv->setActiveSheetIndex(0)->setCellValue('E1', "No Handphone"); // Set kolom C1 dengan tulisan "NAMA"
$csv->setActiveSheetIndex(0)->setCellValue('F1', "Email"); // Set kolom C1 dengan tulisan "NAMA"
$csv->setActiveSheetIndex(0)->setCellValue('G1', "Alamat"); // Set kolom C1 dengan tulisan "NAMA"

// Buat query untuk menampilkan semua data siswa
$sql = mysqli_query($conn, "SELECT * FROM pelanggan where kode");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
while ($data = mysqli_fetch_array($sql)) { // Ambil semua data dari hasil eksekusi $sql
	$csv->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
	$csv->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['kode']);
	$csv->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama']);
	$csv->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['tgldaftar']);
	$csv->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['nohp']);
	$csv->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['email']);
	$csv->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['alamat']);
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// Set orientasi kertas jadi LANDSCAPE
$csv->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$csv->getActiveSheet(0)->setTitle("Laporan Daftar Nama Pelanggan");
$csv->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Daftar Nama Pelanggan.csv"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = new PHPExcel_Writer_CSV($csv);
$write->save('php://output');
