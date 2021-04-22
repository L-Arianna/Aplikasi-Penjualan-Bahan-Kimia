-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2021 at 10:19 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `makmur`
--

-- --------------------------------------------------------

--
-- Table structure for table `backset`
--

CREATE TABLE `backset` (
  `url` varchar(100) NOT NULL,
  `sessiontime` varchar(4) DEFAULT NULL,
  `footer` varchar(50) DEFAULT NULL,
  `themesback` varchar(2) DEFAULT NULL,
  `responsive` varchar(2) DEFAULT NULL,
  `namabisnis1` tinytext NOT NULL,
  `batas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backset`
--

INSERT INTO `backset` (`url`, `sessiontime`, `footer`, `themesback`, `responsive`, `namabisnis1`, `batas`) VALUES
('http://localhost/k2021', '100', 'KURNIA MAKMUR. PT', '1', '0', 'KURNIA MAKMUR. PT', 50);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `no` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `sku` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kategori` varchar(20) DEFAULT 'NULL',
  `brand` text NOT NULL,
  `keterangan` varchar(200) DEFAULT 'NULL',
  `gudang` varchar(100) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `terjual` int(11) DEFAULT NULL,
  `terbeli` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  `retur` int(10) NOT NULL,
  `avatar` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`no`, `kode`, `sku`, `nama`, `kategori`, `brand`, `keterangan`, `gudang`, `barcode`, `terjual`, `terbeli`, `sisa`, `retur`, `avatar`) VALUES
(11, '000001', 'SKU000001', 'asasas', 'segar', 'garnier', 'asasas', 'Gudang 1', 'SKU000016', 111, 240, 129, 0, 'dist/upload/');

-- --------------------------------------------------------

--
-- Table structure for table `bayar`
--

CREATE TABLE `bayar` (
  `nota` varchar(20) NOT NULL,
  `tglbayar` date DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `kembali` int(11) DEFAULT NULL,
  `keluar` int(11) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `diskon` int(10) NOT NULL,
  `no` int(11) NOT NULL,
  `tipebayar` varchar(30) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bayar`
--

INSERT INTO `bayar` (`nota`, `tglbayar`, `bayar`, `total`, `kembali`, `keluar`, `kasir`, `diskon`, `no`, `tipebayar`, `keterangan`) VALUES
('00001', '0000-00-00', 1100000, 1200000, -100000, 1320000, 'admin', 300000, 1, 'Cash', 'yoi'),
('00002', '0000-00-00', 160000, 149995, 10000, 132000, 'admin', 5, 2, 'Cash', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `nota` varchar(20) NOT NULL,
  `tglbeli` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `supplier` varchar(20) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`kode`, `nama`, `no`) VALUES
('0001', 'garnier', 1);

-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

CREATE TABLE `buy` (
  `nota` varchar(20) NOT NULL,
  `tglsale` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `supplier` varchar(200) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `no` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `diterima` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy`
--

INSERT INTO `buy` (`nota`, `tglsale`, `total`, `supplier`, `kasir`, `keterangan`, `no`, `status`, `diterima`) VALUES
('0002', '0000-00-00', 1320000, '0001', 'admin', ' yoo', 2, 'dibayar', 'Haryzzar'),
('0003', '0000-00-00', 1980000, '0001', 'admin', ' yoi', 3, 'dibayar', 'Haryzzar'),
('0004', '0000-00-00', 3300000, '0001', 'admin', ' sadadasd', 4, 'dibayar', 'Haryzzar'),
('0005', '0000-00-00', 1353000, '0001', 'admin', ' hfhfhfh', 5, 'hutang', 'Haryzzar');

-- --------------------------------------------------------

--
-- Table structure for table `chmenu`
--

CREATE TABLE `chmenu` (
  `userjabatan` varchar(20) NOT NULL,
  `menu1` varchar(1) DEFAULT '0',
  `menu2` varchar(1) DEFAULT '0',
  `menu3` varchar(1) DEFAULT '0',
  `menu4` varchar(1) DEFAULT '0',
  `menu5` varchar(1) DEFAULT '0',
  `menu6` varchar(1) DEFAULT '0',
  `menu7` varchar(1) DEFAULT '0',
  `menu8` varchar(1) DEFAULT '0',
  `menu9` varchar(1) DEFAULT '0',
  `menu10` varchar(1) DEFAULT '0',
  `menu11` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chmenu`
--

INSERT INTO `chmenu` (`userjabatan`, `menu1`, `menu2`, `menu3`, `menu4`, `menu5`, `menu6`, `menu7`, `menu8`, `menu9`, `menu10`, `menu11`) VALUES
('admin', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5'),
('demo', '0', '0', '0', '0', '5', '5', '0', '0', '0', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `nama` varchar(100) DEFAULT NULL,
  `tagline` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`nama`, `tagline`, `alamat`, `notelp`, `signature`, `avatar`, `no`) VALUES
('KURNIA MAKMUR. PT', 'App Penjualan', 'Jalan Jendral Sudirman Nomor 354, Semarang Barat, Kota Semarang.', '62999999999', 'Thank you for Shopping with us\r\n-- ini bisa di edit--', 'dist/upload/logo.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dataretur`
--

CREATE TABLE `dataretur` (
  `nota` varchar(10) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` int(10) NOT NULL,
  `hargaakhir` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataretur`
--

INSERT INTO `dataretur` (`nota`, `kode`, `nama`, `jumlah`, `harga`, `hargaakhir`, `no`) VALUES
('00001', '000001', 'adadasda', 120, 12500, 1500000, 1),
('00002', '000001', 'adadasda', 12, 12500, 150000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`kode`, `nama`, `no`) VALUES
('0001', 'Gudang 1', 3),
('0002', 'Gudang 2', 4);

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `nota` varchar(10) NOT NULL,
  `kreditur` varchar(10) NOT NULL,
  `tgl` date NOT NULL,
  `due` date NOT NULL,
  `hutang` int(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`nota`, `kreditur`, `tgl`, `due`, `hutang`, `keterangan`, `status`, `no`) VALUES
('0005', '0001', '2021-03-26', '0000-00-00', 1353000, 'utang boss', 'hutang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `nama` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`nama`, `avatar`, `tanggal`, `isi`, `id`) VALUES
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1),
('iam Admin gantent', 'dist/upload/avatar.png', '2020-09-06', '<h1>TES</h1>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoicebeli`
--

CREATE TABLE `invoicebeli` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `terima` int(10) NOT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoicebeli`
--

INSERT INTO `invoicebeli` (`nota`, `kode`, `nama`, `harga`, `jumlah`, `terima`, `hargaakhir`, `no`) VALUES
('0002', '000001', 'adadasda', 11000, 120, 120, 1320000, 2),
('0003', '000001', 'adadasda', 11000, 180, 180, 1980000, 3),
('0004', '000001', 'adadasda', 11000, 300, 300, 3300000, 4),
('0005', '000001', 'adadasda', 11000, 123, 123, 1353000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `invoicejual`
--

CREATE TABLE `invoicejual` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `modal` int(10) NOT NULL,
  `total_satuan` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `jumlah_satuan` int(11) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoicejual`
--

INSERT INTO `invoicejual` (`nota`, `kode`, `nama`, `harga`, `jumlah`, `hargaakhir`, `modal`, `total_satuan`, `satuan`, `jumlah_satuan`, `no`) VALUES
('00003', '000001', 'asasas', 145000, 24, 3480000, 0, 4800, 'Liter', 200, 23);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kode`, `nama`, `no`) VALUES
('0001', 'admin', 28),
('0002', 'user', 34);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kode`, `nama`, `no`) VALUES
('0001', 'racun', 1),
('0002', 'segar', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE `mutasi` (
  `namauser` varchar(50) NOT NULL,
  `tgl` date NOT NULL,
  `kodebarang` varchar(10) NOT NULL,
  `gudang` varchar(100) NOT NULL,
  `sisa` int(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `no` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi`
--

INSERT INTO `mutasi` (`namauser`, `tgl`, `kodebarang`, `gudang`, `sisa`, `jumlah`, `kegiatan`, `keterangan`, `no`, `status`) VALUES
('admin', '2021-04-01', '000001', '', 589, -12, 'menjual barang memakai invoice', '00002', 1, 'berhasil'),
('admin', '2021-04-01', '000001', '', 577, -12, 'menjual barang memakai struk', '00003', 2, 'berhasil'),
('admin', '2021-04-14', '000001', '', 89, -12, 'menjual barang memakai invoice', '00002', 3, 'berhasil'),
('admin', '2021-04-14', '000001', '', 88, -1, 'menjual barang memakai invoice', '00003', 4, 'berhasil'),
('admin', '2021-04-14', '000001', '', 81, -12, 'menjual barang memakai invoice', '00001', 5, 'berhasil'),
('admin', '2021-04-14', '000001', '', 81, -12, 'menjual barang memakai invoice', '00001', 6, 'berhasil'),
('admin', '2021-04-14', '000001', '', 81, -12, 'menjual barang memakai invoice', '00001', 7, 'berhasil'),
('admin', '2021-04-14', '000001', '', 81, -12, 'menjual barang memakai invoice', '00001', 8, 'berhasil'),
('Haryzzar', '2021-04-14', '000002', '', 120, 120, 'stok masuk', 'PT TEGUS', 9, 'berhasil'),
('admin', '2021-04-15', '000002', '', 108, -12, 'menjual barang memakai invoice', '00004', 10, 'berhasil'),
('admin', '2021-04-15', '000001', '', 69, -12, 'menjual barang memakai invoice', '00004', 11, 'berhasil'),
('admin', '2021-04-15', '000002', '', 108, -12, 'menjual barang memakai invoice', '00004', 12, 'berhasil'),
('admin', '2021-04-15', '000001', '', 69, -12, 'menjual barang memakai invoice', '00004', 13, 'berhasil'),
('Haryzzar', '2021-04-15', '000002', '', 132, 12, 'stok masuk', 'PT TEGUS', 14, 'berhasil'),
('Haryzzar', '2021-04-15', '000003', '', 100, 100, 'stok masuk', '0008', 15, 'pending'),
('admin', '2021-04-15', '000003', '', 88, -12, 'menjual barang memakai invoice', '00002', 16, 'berhasil'),
('admin', '2021-04-16', '0007', '', 88, -12, 'menjual barang memakai invoice', '00002', 17, 'berhasil'),
('Haryzzar', '2021-04-16', '', '', 120, 120, 'stok masuk', '0008', 18, 'pending'),
('Haryzzar', '2021-04-16', '000003', '', 120, 120, 'stok masuk', 'PT TEGUS', 19, 'berhasil'),
('Haryzzar', '2021-04-16', '000001', '', 120, 120, 'stok masuk', 'PT TEGUS', 20, 'berhasil'),
('Haryzzar', '2021-04-16', '000002', '', 120, 120, 'stok masuk', 'PT TEGUS', 21, 'berhasil'),
('admin', '2021-04-16', '000003', '', 108, -12, 'menjual barang memakai invoice', '00002', 22, 'berhasil'),
('admin', '2021-04-16', '000001', '', 0, -120, 'menjual barang memakai invoice', '00002', 23, 'berhasil'),
('admin', '2021-04-16', '000002', '', 108, -12, 'menjual barang memakai invoice', '00003', 24, 'pending'),
('Haryzzar', '2021-04-16', '000001', '', 120, 119, 'stok masuk', 'PT TEGUS', 25, 'berhasil'),
('Haryzzar', '2021-04-19', '000001', '', 120, 120, 'stok masuk', 'PT TEGUS', 26, 'berhasil'),
('Haryzzar', '2021-04-19', '000001', '', 240, 120, 'stok masuk', '0004', 27, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `operasional`
--

CREATE TABLE `operasional` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `biaya` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kasir` varchar(20) DEFAULT NULL,
  `tipe` varchar(30) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operasional`
--

INSERT INTO `operasional` (`kode`, `nama`, `tanggal`, `biaya`, `keterangan`, `kasir`, `tipe`, `no`) VALUES
('0001', 'gaji admin', '2021-01-01', 1000000, '', 'admin', 'Gaji Karyawan', 1),
('0002', 'listrik', '2020-09-18', 10000, '', 'admin', 'Listrik', 2),
('0003', 'Pajak', '2020-09-18', 50000, '', 'admin', 'Pajak', 3),
('0004', 'gaji 2', '2020-09-18', 9999, '11', 'admin', 'Gaji Karyawan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `operasional_tipe`
--

CREATE TABLE `operasional_tipe` (
  `Kode` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operasional_tipe`
--

INSERT INTO `operasional_tipe` (`Kode`, `nama`, `no`) VALUES
('0001', 'Gaji Karyawan', 3),
('0002', 'Listrik', 4),
('0003', 'Sewa Bangunan', 5),
('0004', 'Pajak', 6),
('0005', 'sdaadad', 7);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `nama` varchar(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`nama`, `tipe`, `no`) VALUES
('BCA', 'bank', 2),
('MANDIRI', 'bank', 4),
('Transfer', 'pay', 6);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `tipe` int(1) NOT NULL,
  `nota` varchar(10) NOT NULL,
  `cara` varchar(20) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `payday` date NOT NULL,
  `no` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`tipe`, `nota`, `cara`, `bank`, `ref`, `payday`, `no`) VALUES
(1, '0004', 'Transfer', 'BCA', 'eafqrqrqqd', '2021-03-25', 2),
(1, '0003', 'Cash', 'Pilih Bank', '', '0000-00-00', 3),
(1, '0002', 'Cash', 'BRI', 'eafqrqrqqd', '0000-00-00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kode` varchar(20) NOT NULL,
  `tgldaftar` date DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(70) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`kode`, `tgldaftar`, `nama`, `alamat`, `nohp`, `email`, `no`) VALUES
('0001', '2020-09-16', 'baju oblos', '', '11111', 'qqq@gmal.com', 1),
('0002', '0000-00-00', 'L-arianna', 'sadafafafada', '083286323011', 'admin@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pin`
--

CREATE TABLE `pin` (
  `pin` varchar(255) NOT NULL,
  `ubah` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pin`
--

INSERT INTO `pin` (`pin`, `ubah`) VALUES
('10470c3b4b1fed12c3baac014be15fac67c6e815', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `kode` varchar(10) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `norek` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`kode`, `bank`, `norek`, `nama`, `no`) VALUES
('0001', 'BCA', '111', 'baju oblos', 1),
('0002', 'MANDIRI', '232132131w21w21ww', 'Komputer', 2),
('0003', 'BRI', '34638653873', 'adadasda', 4);

-- --------------------------------------------------------

--
-- Table structure for table `retur`
--

CREATE TABLE `retur` (
  `nota` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `dana` int(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `petugas` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur`
--

INSERT INTO `retur` (`nota`, `tanggal`, `dana`, `status`, `petugas`, `no`) VALUES
('0001', '2020-08-30', 2000, 'Retur', 'admin', 1),
('00001', '2021-03-26', 1500000, 'Retur', 'admin', 2),
('00002', '2021-03-29', 150000, 'Retur', 'admin', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `nota` varchar(20) NOT NULL,
  `nomor` varchar(20) NOT NULL,
  `tglsale` date DEFAULT NULL,
  `duedate` date NOT NULL,
  `total` int(11) DEFAULT NULL,
  `diskon` int(10) NOT NULL,
  `potongan` int(10) NOT NULL,
  `biaya` int(10) NOT NULL,
  `pelanggan` varchar(200) DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `no` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `faktur_pajak` varchar(50) NOT NULL,
  `no_po` varchar(50) NOT NULL,
  `no_surat_jalan` varchar(50) NOT NULL,
  `nama_pt` varchar(255) DEFAULT NULL,
  `alamat_pt` varchar(255) DEFAULT NULL,
  `no_tlp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`nota`, `nomor`, `tglsale`, `duedate`, `total`, `diskon`, `potongan`, `biaya`, `pelanggan`, `alamat`, `no_hp`, `kasir`, `keterangan`, `no`, `status`, `faktur_pajak`, `no_po`, `no_surat_jalan`, `nama_pt`, `alamat_pt`, `no_tlp`) VALUES
('00001', 'INV00001', '2021-04-15', '2021-04-15', 1332000, 12, 18000, 1200000, 'a', 'aa', '0989', 'admin', 'aasdasdasd', 19, 'belum', 'pjk003', 'po002', 'sjl0011', 'PT. Maju Jaya', 'jl.sidoarjo 12', '089764356671'),
('00002', 'INV00002', '2021-04-16', '2021-04-16', 1440000, 12, 180000, 120000, 'frassono', 'jalan hahadsdsd', '0989897537233', 'admin', 'asasAS', 20, 'belum', '1231312', '102021', '12012012', 'PT.andromedia', 'farnosudin', '08976537112');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `kode` varchar(100) NOT NULL,
  `nama_satuan` varchar(100) NOT NULL,
  `convert` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`kode`, `nama_satuan`, `convert`, `jumlah`, `no`) VALUES
('0001', 'Liter', 'Drum', 200, 2),
('0002', 'Kg', 'Drum', 250, 3);

-- --------------------------------------------------------

--
-- Table structure for table `stokretur`
--

CREATE TABLE `stokretur` (
  `kode` varchar(100) NOT NULL,
  `stok` int(7) NOT NULL,
  `no` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `nota` varchar(10) NOT NULL,
  `cabang` varchar(2) NOT NULL,
  `tgl` date NOT NULL,
  `pelanggan` varchar(10) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_keluar`
--

INSERT INTO `stok_keluar` (`nota`, `cabang`, `tgl`, `pelanggan`, `userid`, `keterangan`, `no`) VALUES
('0001', '01', '2020-12-28', 'customer', '1', '112eeqwdscdd', 1),
('0002', '01', '2020-12-30', 'customer', '42', 'rusaknanana', 2),
('0003', '01', '2020-12-30', 'customer', '42', 'resaa', 3),
('0004', '01', '2020-12-30', 'customer', '42', '112eeqwdscdd', 4),
('0005', '01', '2021-01-11', 'customer', '42', '112eeqwdscdd', 5),
('0006', '01', '2021-01-17', 'customer', '1', '', 6),
('0007', '01', '2021-01-17', 'customer', '1', '', 7),
('0008', '01', '2021-01-18', 'customer', '1', 'aaaa', 8),
('0009', '01', '2021-01-18', 'customer', '1', '112eeqwdscdd', 9),
('0010', '01', '2021-03-27', 'customer', '1', 'dasadadfs', 10);

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar_daftar`
--

CREATE TABLE `stok_keluar_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_keluar_daftar`
--

INSERT INTO `stok_keluar_daftar` (`nota`, `kode_barang`, `nama`, `jumlah`, `no`) VALUES
('0008', '000005', 'kategori', 1, 15),
('0009', '000004', 'manual liesa', 1, 16),
('0009', '000005', 'kategori', 1, 17),
('0010', '000001', 'adadasda', 1, 18),
('0011', '000001', 'adadasda', 501, 19);

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `nota` varchar(10) NOT NULL,
  `cabang` varchar(2) NOT NULL,
  `tgl` date NOT NULL,
  `supplier` varchar(10) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`nota`, `cabang`, `tgl`, `supplier`, `userid`, `no`) VALUES
('0001', '', '2021-04-16', 'PT TEGUS', '1', 10),
('0002', '', '2021-04-16', 'PT TEGUS', '1', 11),
('0003', '', '2021-04-19', 'PT TEGUS', '1', 12);

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk_daftar`
--

CREATE TABLE `stok_masuk_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `gudang` varchar(100) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_masuk_daftar`
--

INSERT INTO `stok_masuk_daftar` (`nota`, `kode_barang`, `nama`, `gudang`, `jumlah`, `no`) VALUES
('0001', '000003', 'Sianida', '', 120, 21),
('0001', '000001', 'segar', '', 120, 22),
('0001', '000002', 'segar dingin', '', 120, 23),
('0002', '000001', 'segar', '', 119, 24),
('0003', '000001', 'asasas', 'gudang 1', 120, 25),
('0004', '000001', 'asasas', '', 123, 26);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kode` varchar(20) NOT NULL,
  `tgldaftar` date DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(70) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kode`, `tgldaftar`, `nama`, `alamat`, `nohp`, `no`) VALUES
('0001', '2020-09-15', 'PT TEGUS', '', '11111', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksibeli`
--

CREATE TABLE `transaksibeli` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksimasuk`
--

CREATE TABLE `transaksimasuk` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `hargabeliakhir` int(11) DEFAULT NULL,
  `retur` varchar(3) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksimasuk`
--

INSERT INTO `transaksimasuk` (`nota`, `kode`, `nama`, `harga`, `hargabeli`, `jumlah`, `hargaakhir`, `hargabeliakhir`, `retur`, `no`) VALUES
('00001', '000001', 'adadasda', 12500, 11000, 0, 0, 0, 'YES', 1),
('00002', '000001', 'adadasda', 12500, 11000, 0, 0, 0, 'YES', 2),
('00003', '000001', 'adadasda', 12500, 11000, 12, 150000, 132000, 'NO', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userna_me` varchar(20) NOT NULL,
  `pa_ssword` varchar(70) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `tglaktif` date DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userna_me`, `pa_ssword`, `nama`, `alamat`, `nohp`, `tgllahir`, `tglaktif`, `jabatan`, `avatar`, `no`) VALUES
('admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'Haryzzar', 'Jalan Kelud Raya No 67', '019101911', '2000-03-15', '2016-10-08', 'admin', 'dist/upload/avatar.png', 1),
('demo1', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'demo', 'demo demo demo', '321334', '0011-11-11', '0001-11-11', 'user', 'bootstrap/dist/upload/index.jpg', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backset`
--
ALTER TABLE `backset`
  ADD PRIMARY KEY (`url`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `jenis` (`kategori`),
  ADD KEY `gudang` (`gudang`);

--
-- Indexes for table `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no4` (`no`);

--
-- Indexes for table `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `chmenu`
--
ALTER TABLE `chmenu`
  ADD PRIMARY KEY (`userjabatan`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `dataretur`
--
ALTER TABLE `dataretur`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD KEY `id` (`id`);

--
-- Indexes for table `invoicebeli`
--
ALTER TABLE `invoicebeli`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `invoicejual`
--
ALTER TABLE `invoicejual`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no4` (`no`);

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `operasional`
--
ALTER TABLE `operasional`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `operasional_tipe`
--
ALTER TABLE `operasional_tipe`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no3` (`no`);

--
-- Indexes for table `pin`
--
ALTER TABLE `pin`
  ADD PRIMARY KEY (`ubah`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `retur`
--
ALTER TABLE `retur`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `stokretur`
--
ALTER TABLE `stokretur`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_keluar_daftar`
--
ALTER TABLE `stok_keluar_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_masuk_daftar`
--
ALTER TABLE `stok_masuk_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no3` (`no`);

--
-- Indexes for table `transaksibeli`
--
ALTER TABLE `transaksibeli`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `username` (`kode`),
  ADD KEY `kdbarang` (`harga`);

--
-- Indexes for table `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userna_me`),
  ADD KEY `no` (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bayar`
--
ALTER TABLE `bayar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `beli`
--
ALTER TABLE `beli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buy`
--
ALTER TABLE `buy`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dataretur`
--
ALTER TABLE `dataretur`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoicebeli`
--
ALTER TABLE `invoicebeli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoicejual`
--
ALTER TABLE `invoicejual`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mutasi`
--
ALTER TABLE `mutasi`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `operasional`
--
ALTER TABLE `operasional`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `operasional_tipe`
--
ALTER TABLE `operasional_tipe`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `retur`
--
ALTER TABLE `retur`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stokretur`
--
ALTER TABLE `stokretur`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stok_keluar_daftar`
--
ALTER TABLE `stok_keluar_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stok_masuk_daftar`
--
ALTER TABLE `stok_masuk_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksibeli`
--
ALTER TABLE `transaksibeli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
