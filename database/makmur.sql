-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Apr 2021 pada 03.29
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

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
-- Struktur dari tabel `backset`
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
-- Dumping data untuk tabel `backset`
--

INSERT INTO `backset` (`url`, `sessiontime`, `footer`, `themesback`, `responsive`, `namabisnis1`, `batas`) VALUES
('http://localhost/k2021', '100', 'KURNIA MAKMUR. PT', '1', '1', 'KURNIA MAKMUR. PT', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
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
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`no`, `kode`, `sku`, `nama`, `kategori`, `brand`, `keterangan`, `gudang`, `barcode`, `terjual`, `terbeli`, `sisa`, `retur`, `avatar`) VALUES
(11, '000001', 'SKU000001', 'asasas', 'enak', 'jojo', 'asasas', 'Gudang 1', 'SKU000016', 163, 585, 422, 0, 'dist/upload/'),
(16, '000003', 'SKU000003', 'HCI', 'segar', 'garnier', 'DFSDFSD', 'Gudang 2', 'SK000023', 45, 136, 91, 0, 'dist/upload/'),
(17, '000004', 'SKU000004', 'yoyo', 'mantap', 'jojo', 'asadada', 'Gudang 4', 'SK000023', 23, 200, 177, 0, 'dist/upload/'),
(18, '000005', 'SKU000005', 'fros', 'mantap', 'fafa', 'dasdad', 'Gudang 3', 'SK000025', 0, 0, 0, 0, 'dist/upload/'),
(19, '000006', 'SKU000006', 'es dingin', 'mantap', 'jojo', 'asasa', 'Gudang 1', 'SK000067', 0, 0, 0, 0, 'dist/upload/avatar.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar`
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
-- Dumping data untuk tabel `bayar`
--

INSERT INTO `bayar` (`nota`, `tglbayar`, `bayar`, `total`, `kembali`, `keluar`, `kasir`, `diskon`, `no`, `tipebayar`, `keterangan`) VALUES
('00001', '0000-00-00', 1100000, 1200000, -100000, 1320000, 'admin', 300000, 1, 'Cash', 'yoi'),
('00002', '0000-00-00', 160000, 149995, 10000, 132000, 'admin', 5, 2, 'Cash', 'a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beli`
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
-- Struktur dari tabel `brand`
--

CREATE TABLE `brand` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `brand`
--

INSERT INTO `brand` (`kode`, `nama`, `no`) VALUES
('0001', 'garnier', 1),
('0002', 'jojo', 2),
('0003', 'fafa', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buy`
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
-- Dumping data untuk tabel `buy`
--

INSERT INTO `buy` (`nota`, `tglsale`, `total`, `supplier`, `kasir`, `keterangan`, `no`, `status`, `diterima`) VALUES
('0002', '0000-00-00', 1320000, '0001', 'admin', ' yoo', 2, 'dibayar', 'Haryzzar'),
('0003', '0000-00-00', 1980000, '0001', 'admin', ' yoi', 3, 'dibayar', 'Haryzzar'),
('0004', '0000-00-00', 3300000, '0001', 'admin', ' sadadasd', 4, 'dibayar', 'Haryzzar'),
('0005', '0000-00-00', 1353000, '0001', 'admin', ' hfhfhfh', 5, 'hutang', 'Haryzzar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chmenu`
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
-- Dumping data untuk tabel `chmenu`
--

INSERT INTO `chmenu` (`userjabatan`, `menu1`, `menu2`, `menu3`, `menu4`, `menu5`, `menu6`, `menu7`, `menu8`, `menu9`, `menu10`, `menu11`) VALUES
('admin', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5'),
('demo', '0', '0', '0', '0', '5', '5', '0', '0', '0', '0', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data`
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
-- Dumping data untuk tabel `data`
--

INSERT INTO `data` (`nama`, `tagline`, `alamat`, `notelp`, `signature`, `avatar`, `no`) VALUES
('KURNIA MAKMUR. PT', 'App Penjualan', 'Jalan Jendral Sudirman Nomor 354, Semarang Barat, Kota Semarang.', '62999999999', 'Thank you for Shopping with us\r\n-- ini bisa di edit--', 'dist/upload/logo.jpg', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dataretur`
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
-- Dumping data untuk tabel `dataretur`
--

INSERT INTO `dataretur` (`nota`, `kode`, `nama`, `jumlah`, `harga`, `hargaakhir`, `no`) VALUES
('00001', '000001', 'adadasda', 120, 12500, 1500000, 1),
('00002', '000001', 'adadasda', 12, 12500, 150000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudang`
--

CREATE TABLE `gudang` (
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gudang`
--

INSERT INTO `gudang` (`kode`, `nama`, `no`) VALUES
('0001', 'Gudang 1', 3),
('0002', 'Gudang 2', 4),
('0003', 'Gudang 3', 6),
('0004', 'Gudang 4', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hutang`
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
-- Dumping data untuk tabel `hutang`
--

INSERT INTO `hutang` (`nota`, `kreditur`, `tgl`, `due`, `hutang`, `keterangan`, `status`, `no`) VALUES
('0005', '0001', '2021-03-26', '0000-00-00', 1353000, 'utang boss', 'hutang', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `info`
--

CREATE TABLE `info` (
  `nama` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `info`
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
-- Struktur dari tabel `invoicebeli`
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
-- Dumping data untuk tabel `invoicebeli`
--

INSERT INTO `invoicebeli` (`nota`, `kode`, `nama`, `harga`, `jumlah`, `terima`, `hargaakhir`, `no`) VALUES
('0002', '000001', 'adadasda', 11000, 120, 120, 1320000, 2),
('0003', '000001', 'adadasda', 11000, 180, 180, 1980000, 3),
('0004', '000001', 'adadasda', 11000, 300, 300, 3300000, 4),
('0005', '000001', 'adadasda', 11000, 123, 123, 1353000, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoicejual`
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
-- Dumping data untuk tabel `invoicejual`
--

INSERT INTO `invoicejual` (`nota`, `kode`, `nama`, `harga`, `jumlah`, `hargaakhir`, `modal`, `total_satuan`, `satuan`, `jumlah_satuan`, `no`) VALUES
('00001', '000001', 'asasas', 145000, 12, 1740000, 0, 2400, 'Liter', 200, 24),
('00002', '000002', 'segar dingin', 20000, 34, 680000, 0, 6800, 'Liter', 200, 26),
('00003', '000001', 'asasas', 145000, 24, 3480000, 0, 4800, 'Liter', 200, 23),
('00004', '000003', 'HCI', 450000, 12, 5400000, 0, 2400, 'Liter', 200, 27),
('00005', '000002', 'segar dingin', 1000000, 13, 13000000, 0, 2600, 'Liter', 200, 28),
('00006', '000002', 'segar dingin', 3200000, 43, 137600000, 0, 8600, 'Liter', 200, 29),
('00006', '000003', 'HCI', 20000, 21, 420000, 0, 4200, 'Liter', 200, 30),
('00007', '000001', 'asasas', 20000, 23, 460000, 0, 4600, 'Liter', 200, 31),
('00008', '000002', 'segar dingin', 320000, 12, 3840000, 0, 3000, 'Kg', 250, 32),
('00009', '000003', 'HCI', 20000, 12, 240000, 0, 2400, 'Liter', 200, 33),
('00010', '000004', 'yoyo', 450000, 23, 10350000, 0, 5750, 'Kg', 250, 34);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`kode`, `nama`, `no`) VALUES
('0001', 'admin', 28),
('0002', 'user', 34);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kode`, `nama`, `no`) VALUES
('0001', 'mantap', 1),
('0002', 'segar', 2),
('0003', 'enak', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi`
--

CREATE TABLE `mutasi` (
  `namauser` varchar(50) NOT NULL,
  `tgl` date NOT NULL,
  `kodebarang` varchar(10) NOT NULL,
  `sisa` int(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `no` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mutasi`
--

INSERT INTO `mutasi` (`namauser`, `tgl`, `kodebarang`, `sisa`, `jumlah`, `kegiatan`, `keterangan`, `no`, `status`) VALUES
('admin', '2021-04-28', '000003', 91, -12, 'menjual barang memakai invoice', '00009', 1, 'berhasil'),
('Haryzzar', '2021-04-28', '000004', 200, 200, 'stok masuk', 'PT TEGUS', 2, 'berhasil'),
('admin', '2021-04-28', '000004', 177, -23, 'menjual barang memakai invoice', '00010', 3, 'berhasil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notes`
--

CREATE TABLE `notes` (
  `kode` varchar(50) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `tgl` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `notes`
--

INSERT INTO `notes` (`kode`, `nama`, `judul`, `tgl`, `keterangan`, `no`) VALUES
('0001', 'HCI', 'A', '26-04-2021', '<p>ASLASLKASA</p>', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operasional`
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
-- Dumping data untuk tabel `operasional`
--

INSERT INTO `operasional` (`kode`, `nama`, `tanggal`, `biaya`, `keterangan`, `kasir`, `tipe`, `no`) VALUES
('0001', 'gaji admin', '2021-01-01', 1000000, '', 'admin', 'Gaji Karyawan', 1),
('0002', 'listrik', '2020-09-18', 10000, '', 'admin', 'Listrik', 2),
('0003', 'Pajak', '2020-09-18', 50000, '', 'admin', 'Pajak', 3),
('0004', 'gaji 2', '2020-09-18', 9999, '11', 'admin', 'Gaji Karyawan', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operasional_tipe`
--

CREATE TABLE `operasional_tipe` (
  `Kode` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `operasional_tipe`
--

INSERT INTO `operasional_tipe` (`Kode`, `nama`, `no`) VALUES
('0001', 'Gaji Karyawan', 3),
('0002', 'Listrik', 4),
('0003', 'Sewa Bangunan', 5),
('0004', 'Pajak', 6),
('0005', 'sdaadad', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `options`
--

CREATE TABLE `options` (
  `nama` varchar(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `options`
--

INSERT INTO `options` (`nama`, `tipe`, `no`) VALUES
('BCA', 'bank', 2),
('MANDIRI', 'bank', 4),
('Transfer', 'pay', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
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
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`tipe`, `nota`, `cara`, `bank`, `ref`, `payday`, `no`) VALUES
(1, '0004', 'Transfer', 'BCA', 'eafqrqrqqd', '2021-03-25', 2),
(1, '0002', 'Cash', 'BRI', 'eafqrqrqqd', '0000-00-00', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
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
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`kode`, `tgldaftar`, `nama`, `alamat`, `nohp`, `email`, `no`) VALUES
('0001', '2020-09-16', 'baju oblos', 'asdasdasdasdas', '11111', 'qqq@gmal.com', 1),
('0003', '2021-04-24', 'ea', 'asdafaeqwwq', '083286323011', 'sinta@gmail.com', 3),
('0004', '2021-04-27', 'L-Arianna', 'adadasd', '08754261212', 'dev@gmail.com', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pin`
--

CREATE TABLE `pin` (
  `pin` varchar(255) NOT NULL,
  `ubah` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pin`
--

INSERT INTO `pin` (`pin`, `ubah`) VALUES
('10470c3b4b1fed12c3baac014be15fac67c6e815', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `kode` varchar(10) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `norek` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`kode`, `bank`, `norek`, `nama`, `no`) VALUES
('0001', 'BCA', '111', 'baju oblos', 1),
('0002', 'MANDIRI', '232132131w21w21ww', 'Komputer', 2),
('0003', 'BRI', '34638653873', 'adadasda', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur`
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
-- Dumping data untuk tabel `retur`
--

INSERT INTO `retur` (`nota`, `tanggal`, `dana`, `status`, `petugas`, `no`) VALUES
('0001', '2020-08-30', 2000, 'Retur', 'admin', 1),
('00001', '2021-03-26', 1500000, 'Retur', 'admin', 2),
('00002', '2021-03-29', 150000, 'Retur', 'admin', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sale`
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
  `kasir` varchar(100) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `no` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `kirim` varchar(11) NOT NULL,
  `faktur_pajak` varchar(50) NOT NULL,
  `no_po` varchar(50) NOT NULL,
  `no_surat_jalan` varchar(50) NOT NULL,
  `nama_pt` varchar(255) DEFAULT NULL,
  `alamat_pt` varchar(255) DEFAULT NULL,
  `no_tlp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sale`
--

INSERT INTO `sale` (`nota`, `nomor`, `tglsale`, `duedate`, `total`, `diskon`, `potongan`, `biaya`, `pelanggan`, `kasir`, `keterangan`, `no`, `status`, `kirim`, `faktur_pajak`, `no_po`, `no_surat_jalan`, `nama_pt`, `alamat_pt`, `no_tlp`) VALUES
('00001', 'INV00001', '2021-04-24', '2021-04-24', 1968800, 12, 208800, 20000, '0003', 'admin', 'wewewrw', 23, 'dibayar', 'belum', '012.546.23', '11/12/2021', '587/456/2021', 'PT. Maju Jaya', 'jalan kedondong nomo 45, Semarang Utara', '024653987'),
('00002', 'INV00002', '2021-04-25', '2021-04-25', 868000, 10, 68000, 120000, '0003', 'admin', 'aa', 24, 'dibayar', 'belum', '0978', '4468', '20210424', 'PT Anjasmaya', 'jl amabarawa', '08754271223'),
('00003', 'INV00003', '2021-04-26', '2021-04-26', 4376000, 20, 696000, 200000, '0001', 'admin', 'dsadasda', 25, 'dibayar', 'belum', '6621', '1323', '2323', 'PT Anjasmaya', 'jl amabarawa', '08754271223'),
('00004', 'INV00004', '2021-04-26', '2021-04-26', 6168000, 12, 648000, 120000, '0001', 'admin', 'dsadasda', 26, 'dibayar', 'terkirim', '6621', '4468', '12342', 'PT Anjasmaya baru', 'jl amabarawa', '08754271223'),
('00005', 'INV00005', '2021-04-26', '2021-04-26', 15950000, 15, 1950000, 1000000, '0001', 'admin', 'asdasdasd', 27, 'dibayar', 'terkirim', '6621', '1323', '20210424', 'PT Anjasmaya baru', 'jl amabarawa', '08754271223'),
('00006', 'INV00006', '2021-04-27', '2021-04-27', 154682400, 12, 16562400, 100000, '0004', 'admin', 'asaas', 28, 'dibayar', 'belum', '12121', '34242', '2323', 'PT Anjasmaya lama', 'jl amabarawa', '08754271223'),
('00007', 'INV00007', '2021-04-28', '2021-04-28', 535200, 12, 55200, 20000, '0004', 'admin', 'dasdada', 29, 'belum', 'belum', '21', '12', '2312312', 'PT Anjasmaya lama', 'jl amabarawa', '08754271223'),
('00008', 'INV00008', '2021-04-28', '2021-04-28', 4420800, 12, 460800, 120000, '0003', 'admin', 'sadasda', 30, 'belum', 'belum', '21', '113', '1212', 'PT Anjasmaya', 'jl amabarawa', '08754271223'),
('00009', 'INV00009', '2021-04-28', '2021-04-28', 368800, 12, 28800, 100000, '0004', 'admin', 'sadasda', 31, 'belum', 'belum', '12', '1213', '2323', 'PT Anjasmaya', 'jl amabarawa', '08754271223'),
('00010', 'INV00010', '2021-04-28', '2021-04-28', 12592000, 12, 1242000, 1000000, '0003', 'admin', 'dffasfas', 32, 'belum', 'belum', '12121', 'asasa', 'sadasd', 'PT Anjasmaya lama', 'safasfas', '08754271223');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `kode` varchar(100) NOT NULL,
  `nama_satuan` varchar(100) NOT NULL,
  `convert` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`kode`, `nama_satuan`, `convert`, `jumlah`, `no`) VALUES
('0001', 'Liter', 'Drum', 200, 2),
('0002', 'Kg', 'Drum', 250, 3),
('0003', 'Sak', 'Kg', 50, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stokretur`
--

CREATE TABLE `stokretur` (
  `kode` varchar(100) NOT NULL,
  `stok` int(7) NOT NULL,
  `no` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_keluar`
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
-- Dumping data untuk tabel `stok_keluar`
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
('0010', '01', '2021-03-27', 'customer', '1', 'dasadadfs', 10),
('0011', '01', '2021-04-23', 'customer', '1', '', 11),
('0012', '01', '2021-04-23', 'customer', '1', 'ok', 12),
('0013', '01', '2021-04-23', 'customer', '1', '', 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_keluar_daftar`
--

CREATE TABLE `stok_keluar_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stok_keluar_daftar`
--

INSERT INTO `stok_keluar_daftar` (`nota`, `kode_barang`, `nama`, `jumlah`, `no`) VALUES
('0008', '000005', 'kategori', 1, 15),
('0009', '000004', 'manual liesa', 1, 16),
('0009', '000005', 'kategori', 1, 17),
('0010', '000001', 'adadasda', 1, 18),
('0011', '000001', 'adadasda', 501, 19),
('0012', '000001', 'asasas', 17, 20),
('0013', '000002', 'segar dingin', 12, 21);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `nota` varchar(10) NOT NULL,
  `tgl` date NOT NULL,
  `supplier` varchar(10) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stok_masuk`
--

INSERT INTO `stok_masuk` (`nota`, `tgl`, `supplier`, `userid`, `no`) VALUES
('0001', '2021-04-16', 'PT TEGUS', '1', 10),
('0002', '2021-04-16', 'PT TEGUS', '1', 11),
('0003', '2021-04-19', 'PT TEGUS', '1', 12),
('0004', '2021-04-22', 'PT TEGUS', '1', 13),
('0005', '2021-04-23', 'PT TEGUS', '1', 14),
('0006', '2021-04-23', 'PT TEGUS', '1', 15),
('0007', '2021-04-23', 'PT TEGUS', '1', 16),
('0008', '2021-04-23', 'PT TEGUS', '1', 17),
('0009', '2021-04-23', 'PT TEGUS', '1', 18),
('0010', '2021-04-23', 'PT TEGUS', '1', 19),
('0011', '2021-04-23', 'PT TEGUS', '1', 20),
('0012', '2021-04-23', 'PT TEGUS', '1', 21),
('0013', '2021-04-23', 'PT TEGUS', '1', 22),
('0014', '2021-04-23', 'PT TEGUS', '1', 23),
('0015', '2021-04-23', 'PT TEGUS', '1', 24),
('0016', '2021-04-23', 'PT TEGUS', '1', 25),
('0017', '2021-04-23', 'PT TEGUS', '1', 26),
('0018', '2021-04-23', 'PT TEGUS', '1', 27),
('0019', '2021-04-23', 'PT TEGUS', '1', 28),
('0020', '2021-04-23', 'PT TEGUS', '1', 29),
('0021', '2021-04-23', 'PT TEGUS', '1', 30),
('0022', '2021-04-23', 'PT TEGUS', '1', 31),
('0023', '2021-04-23', 'PT TEGUS', '1', 32),
('0024', '2021-04-23', 'PT TEGUS', '1', 33),
('0025', '2021-04-23', 'PT TEGUS', '1', 34),
('0026', '2021-04-23', 'PT TEGUS', '1', 35),
('0027', '2021-04-23', 'PT TEGUS', '1', 36),
('0028', '2021-04-26', 'PT TEGUS', '1', 37),
('0029', '2021-04-26', 'PT TEGUS', '1', 38),
('0030', '2021-04-28', 'PT TEGUS', '1', 39);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_masuk_daftar`
--

CREATE TABLE `stok_masuk_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stok_masuk_daftar`
--

INSERT INTO `stok_masuk_daftar` (`nota`, `kode_barang`, `nama`, `jumlah`, `no`) VALUES
('0001', '000003', 'Sianida', 120, 21),
('0001', '000001', 'segar', 120, 22),
('0001', '000002', 'segar dingin', 120, 23),
('0002', '000001', 'segar', 119, 24),
('0003', '000001', 'asasas', 120, 25),
('0004', '000001', 'asasas', 123, 26),
('0005', '000001', 'asasas', 1, 27),
('0006', '000001', 'asasas', 1, 28),
('0007', '000001', 'asasas', 100, 29),
('0008', '000001', 'asasas', 100, 30),
('0009', '000001', 'asasas', 12, 31),
('0010', '000002', 'segar dingin', 100, 32),
('0011', '000002', 'segar dingin', 100, 33),
('0012', '000002', 'segar dingin', 100, 34),
('0013', '000002', 'segar dingin', 100, 35),
('0014', '000001', 'asasas', 1, 36),
('0015', '000001', 'asasas', 1, 37),
('0016', '000001', 'asasas', 100, 38),
('0017', '000001', 'asasas', 100, 39),
('0018', '000001', 'asasas', 1, 40),
('0019', '000001', 'asasas', 200, 41),
('0021', '000002', 'segar dingin', 100, 42),
('0022', '000001', 'asasas', 100, 43),
('0023', '000002', 'segar dingin', 100, 44),
('0024', '000002', 'segar dingin', 45, 45),
('0025', '000002', 'segar dingin', 30, 46),
('0026', '000001', 'asasas', 45, 47),
('0027', '000002', 'segar dingin', 148, 48),
('0028', '000002', 'segar dingin', 38, 49),
('0029', '000003', 'HCI', 136, 50),
('0030', '000004', 'yoyo', 200, 51);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
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
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`kode`, `tgldaftar`, `nama`, `alamat`, `nohp`, `no`) VALUES
('0001', '2020-09-15', 'PT TEGUS', '', '11111', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksibeli`
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
-- Struktur dari tabel `transaksimasuk`
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
-- Dumping data untuk tabel `transaksimasuk`
--

INSERT INTO `transaksimasuk` (`nota`, `kode`, `nama`, `harga`, `hargabeli`, `jumlah`, `hargaakhir`, `hargabeliakhir`, `retur`, `no`) VALUES
('00001', '000001', 'adadasda', 12500, 11000, 0, 0, 0, 'YES', 1),
('00002', '000001', 'adadasda', 12500, 11000, 0, 0, 0, 'YES', 2),
('00003', '000001', 'adadasda', 12500, 11000, 12, 150000, 132000, 'NO', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `update_pelanggan`
--

CREATE TABLE `update_pelanggan` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nohp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `update_pelanggan`
--

INSERT INTO `update_pelanggan` (`kode`, `nama`, `alamat`, `nohp`) VALUES
('0001', 'baju a', 'asdasdasdasdas', '11111'),
('0003', 'antonio', 'asass', '083286323011');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userna_me`, `pa_ssword`, `nama`, `alamat`, `nohp`, `tgllahir`, `tglaktif`, `jabatan`, `avatar`, `no`) VALUES
('admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'Haryzzar', 'Jalan Kelud Raya No 67', '019101911', '2000-03-15', '2016-10-08', 'admin', 'dist/upload/avatar.png', 1),
('demo1', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'demo', 'demo demo demo', '321334', '0011-11-11', '0001-11-11', 'user', 'bootstrap/dist/upload/index.jpg', 23);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `backset`
--
ALTER TABLE `backset`
  ADD PRIMARY KEY (`url`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `jenis` (`kategori`),
  ADD KEY `gudang` (`gudang`);

--
-- Indeks untuk tabel `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no4` (`no`);

--
-- Indeks untuk tabel `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `chmenu`
--
ALTER TABLE `chmenu`
  ADD PRIMARY KEY (`userjabatan`);

--
-- Indeks untuk tabel `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `dataretur`
--
ALTER TABLE `dataretur`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `info`
--
ALTER TABLE `info`
  ADD KEY `id` (`id`);

--
-- Indeks untuk tabel `invoicebeli`
--
ALTER TABLE `invoicebeli`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indeks untuk tabel `invoicejual`
--
ALTER TABLE `invoicejual`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no4` (`no`);

--
-- Indeks untuk tabel `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `no_2` (`no`);

--
-- Indeks untuk tabel `operasional`
--
ALTER TABLE `operasional`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `operasional_tipe`
--
ALTER TABLE `operasional_tipe`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no3` (`no`);

--
-- Indeks untuk tabel `pin`
--
ALTER TABLE `pin`
  ADD PRIMARY KEY (`ubah`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `retur`
--
ALTER TABLE `retur`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indeks untuk tabel `stokretur`
--
ALTER TABLE `stokretur`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `stok_keluar_daftar`
--
ALTER TABLE `stok_keluar_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `stok_masuk_daftar`
--
ALTER TABLE `stok_masuk_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no3` (`no`);

--
-- Indeks untuk tabel `transaksibeli`
--
ALTER TABLE `transaksibeli`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `username` (`kode`),
  ADD KEY `kdbarang` (`harga`);

--
-- Indeks untuk tabel `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indeks untuk tabel `update_pelanggan`
--
ALTER TABLE `update_pelanggan`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userna_me`),
  ADD KEY `no` (`no`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `bayar`
--
ALTER TABLE `bayar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `beli`
--
ALTER TABLE `beli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `brand`
--
ALTER TABLE `brand`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `buy`
--
ALTER TABLE `buy`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `dataretur`
--
ALTER TABLE `dataretur`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gudang`
--
ALTER TABLE `gudang`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `hutang`
--
ALTER TABLE `hutang`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `invoicebeli`
--
ALTER TABLE `invoicebeli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `invoicejual`
--
ALTER TABLE `invoicejual`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mutasi`
--
ALTER TABLE `mutasi`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notes`
--
ALTER TABLE `notes`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `operasional`
--
ALTER TABLE `operasional`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `operasional_tipe`
--
ALTER TABLE `operasional_tipe`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `options`
--
ALTER TABLE `options`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rekening`
--
ALTER TABLE `rekening`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `retur`
--
ALTER TABLE `retur`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sale`
--
ALTER TABLE `sale`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `stokretur`
--
ALTER TABLE `stokretur`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `stok_keluar_daftar`
--
ALTER TABLE `stok_keluar_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `stok_masuk_daftar`
--
ALTER TABLE `stok_masuk_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksibeli`
--
ALTER TABLE `transaksibeli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
