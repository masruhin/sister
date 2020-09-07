-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 03, 2020 at 11:11 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jpsdbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_mstkry`
--

CREATE TABLE IF NOT EXISTS `t_mstkry` (
  `str` varchar(1) NOT NULL,
  `userid` bigint(10) NOT NULL AUTO_INCREMENT,
  `kdestt` varchar(5) NOT NULL,
  `kdekry` varchar(10) NOT NULL,
  `nmakry` varchar(50) NOT NULL,
  `tmplhr` varchar(50) NOT NULL,
  `tgllhr` varchar(10) NOT NULL,
  `jnsklm` varchar(1) NOT NULL,
  `kdeagm` varchar(1) NOT NULL,
  `alm` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `kta` varchar(50) NOT NULL,
  `kdepos` varchar(5) NOT NULL,
  `tlp` varchar(50) NOT NULL,
  `hpakt` varchar(15) NOT NULL,
  `wrgngr` varchar(25) NOT NULL,
  `nmapsn` varchar(50) NOT NULL,
  `ktr` text NOT NULL,
  `gelar` varchar(15) DEFAULT NULL,
  `usernm` varchar(25) DEFAULT NULL,
  `psswrd` varchar(25) NOT NULL,
  `wkt` varchar(20) NOT NULL,
  `knj` int(10) NOT NULL,
  `kdeusr` varchar(10) NOT NULL,
  `tglrbh` varchar(10) NOT NULL,
  `jamrbh` time NOT NULL,
  `unit` varchar(5) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10000000159 ;

--
-- Dumping data for table `t_mstkry`
--

INSERT INTO `t_mstkry` (`str`, `userid`, `kdestt`, `kdekry`, `nmakry`, `tmplhr`, `tgllhr`, `jnsklm`, `kdeagm`, `alm`, `kta`, `kdepos`, `tlp`, `hpakt`, `wrgngr`, `nmapsn`, `ktr`, `gelar`, `usernm`, `psswrd`, `wkt`, `knj`, `kdeusr`, `tglrbh`, `jamrbh`, `unit`) VALUES
('A', 9999999999, '@@@', '@00000', 'ADMIN', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '@00000', '5cg87c4c1c6bdb7c5c5c2bc', '', 0, '', '', '00:00:00', ''),
('', 45, 'A01', '213120045', 'Zulmi Ibrahim ', 'Jakarta', '31/10/1986', 'L', '1', 'Peninggaran Rt.003/010 Cipulir Kebayoran Lama JakSel', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'zulmiibrahim', '55g858483', '', 0, '', '01-09-2020', '02:35:30', 'SD'),
('', 43, 'G01', '212070043', 'Rini Andriani', ' Sukabumi ', '14/09/1983', 'P', '1', 'Jl.Rahayu No. 1A Rt.012/004 Jelambar Grogol Petamburan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd.', 'riniandriani', '55g858483', '', 0, '', '01-09-2020', '12:34:01', 'SD'),
('', 41, 'PCP', '212070041', 'Herdina Tambunan ', 'Tambunan', '30/06/1982', 'P', '3', 'Jl.Bungur Besar XIII B/3A Rt.008/001 Kemayoran JakPus', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'herdinatambunan', '', '', 0, '', '01-09-2020', '02:34:16', 'SMA'),
('', 38, 'PCP', '212070038', 'Sikstus Bonaventura Goo', ' Kupang ', '08/07/1985', 'L', '2', 'Cipinang Asem GG.Kancil No.41 Rt.004/012 Kebun Pala Makasar JakTim', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'sikstusbonaventura', '55g858483', '', 0, '', '01-09-2020', '01:16:56', 'SD'),
('', 10000000154, 'G01', '219070173', 'Ferayaty Yulinda Mariana', 'JAKARTA ', '29/04/1993', 'P', '3', 'KP. KALISUREN RT002/RW003, DESA KALISUREN, TAJURHALANG.', 'BOGOR', '', '', '', '', '', '', NULL, 'ferayatyyulinda', '55g858483', '', 0, '', '01-09-2020', '12:23:01', 'SD'),
('', 37, 'G01', '212070037', 'Dian Kristiandari', ' Purworejo ', '02/11/1985', 'P', '3', 'Jl.Karangrejo No.94 Rt.007/001 Gendongan Tingkir Salatiga', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd.', 'diankristiandari', '55g858483', '', 0, '', '01-09-2020', '12:33:44', 'SD'),
('', 36, 'G01', '212070036', 'Dara Chitra Hedini ', ' Jakarta ', '22/06/1984', 'P', '1', 'KP.Kemang Rt.008/007 Jatiwaringin Pondokgede', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.S.', 'darachitra', '55g858483', '', 0, '', '01-09-2020', '12:33:13', 'SD'),
('', 35, 'G01', '212070035', 'Ida Basaria', 'Latong Holbung', '02/01/1988', 'P', '3', 'Meruya Selatan Rt.003/005 Meruya Selatan Kembangan JakBar', 'JAKARTA BARAT', '', '-', '-', 'INDONESIA', '', '', NULL, 'idabasaria', '', '', 0, '', '03-09-2020', '08:47:17', 'TK'),
('', 34, 'PCP', '212070034', 'Isabela Indah', 'Malang', '31/05/1984', 'P', '2', 'Jl.Palmerah barat I No.15 Rt007/007 Palmerah JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'isabelaindah', '55g858483', '', 0, '', '27-08-2020', '07:33:55', ''),
('', 10000000153, 'G01', '219020153', 'Asripah Lumina', 'JAKARTA', '27/9/1992', 'P', '2', 'PONDOK BAHAR PERMAI D.7/29 RT 002/RW 004, PONDOK BAHAR KARANG TENGAH.', 'TANGERANG', '', '', '', '', '', '', NULL, 'asripahlumina', '55g858483', '', 0, '', '01-09-2020', '12:22:16', 'SD'),
('', 32, 'G01', '211070032', 'Anastasia Destiningrum ', 'Pangkal Pinang', '12/10/1980', 'P', '2', 'Meruya Utara Rt.011/006 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'anastasiadestiningrum', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 30, 'G01', '211070030', 'Pintauli Butar-Butar ', ' Pabatu ', '01/08/1982', 'P', '3', 'Meruya Utara Rt.002/002 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'pintaulibutarbutar', '55g858483', '', 0, '', '01-09-2020', '12:32:49', 'SD'),
('', 25, 'A01', '211110025', 'Remita Handayani ', 'Jakarta', '01/06/1988', 'P', '3', 'Jln.Kalipasir Gg.Tembok No.41B Kebon Sirih,Menteng JakPus', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'remitahandayani', '55g858483', '', 0, '', '01-09-2020', '02:34:48', 'SMP'),
('', 22, 'SEC', '210070022', 'Tomi Apriyadi ', 'Jakarta', '06/04/1984', 'L', '', 'Jln. H.Berit Rt.006/010 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 20, 'G01', '210070020', 'Martian Habsari', 'Semarang', '22/03/1985', 'P', '2', 'Jl. Matoa VI Bulak Indah Karangasem Rt.001/007 Laweyan Surakarta', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'martianhabsari', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 19, 'WKL', '210070019', 'Novelyna', 'Jakarta', '12/11/1979', 'P', '3', 'Jl.H.Holil No.28 Rt.002/008 Kreo Larangan Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.T', 'novelyna', '', '', 0, '', '01-09-2020', '01:17:14', 'SD'),
('', 18, 'G01', '210070018', 'Muryani Sriastuti', 'Jakarta', '15/05/1977', 'P', '1', 'Komp.Polri Jl.J/34 Rt.07/06 Ragunan Pasar Minggu JakSel', 'JAKARTA SELATAN', '0', '-', '-', 'INDONESIA', '', '', NULL, 'muryanisriastuti', '', '', 0, '', '03-09-2020', '08:44:31', 'TK'),
('', 17, 'SEC', '210010017', 'Bahiar ', 'Jakarta', '05/07/1985', 'L', '', 'Meruya Selatan Rt.003/006 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 15, 'G01', '210030015', 'Markus Sumartono', 'Purworejo', '31/01/1972', 'L', '2', 'Jl.Kenangan III/17A Rt.010/001 Jaka Sampurna Bekasi', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd', 'markussumartono', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 13, 'SEC', '209090013', 'Subur ', 'Jakarta', '01/10/1985', 'L', '', 'Meruya Utara Rt.005/010 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 11, 'SEC', '208090011', 'Edi ', 'Jakarta', '10/04/1980', 'L', '', 'Jl.Panti Asuhan KP Ceger Rt.011/002 Jurangmangu Barat Pondok Aren Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 10, 'ADMH', '208070010', 'Yustina Rini Budiyatun ', 'Klaten', '16/02/1971', 'P', '', 'Kav.DKI Blok 154/18 Rt.003/006 Meruya Selatan Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'yustinarini', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 9, 'WKL', '208070009', 'Anom Ferawati ', 'Jakarta', '06/02/1981', 'P', '3', 'Jl.SMA Negeri 64 Rt.005/002 Cipayung JakTim', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'anomferawati', '', '', 0, '', '01-09-2020', '01:15:44', 'SD'),
('', 8, 'G01', '208070008', 'Grees Rentyulita', 'Jakarta', '29/08/1973', 'P', '3', 'Jl.Kalipasir GG Tembok No.41B Rt.008/010 Kebon Sirih Menteng JakPus', '-', '0', '-', '-', 'INDONESIA', '', '', ', SE', 'greesrentyulita', '55g858483', '', 0, '', '01-09-2020', '12:32:12', 'SD'),
('', 7, 'SEC', '208050007', 'Mahmud ', 'Jakarta', '03/02/1975', 'L', '', 'Meruya Selatan Rt.004/005 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 66, 'A01', '214070066', 'Lusia Putri Oktavia', 'Klaten', '07-10-1996', 'P', '', 'Jl.Lapangan Tenis No.56C Rt.006/005 Srengseng Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'lusiaputri', '', '', 0, '', '01-09-2020', '02:36:16', 'TK'),
('', 1, 'CEO', '206010001', 'Paulus Pontoh', 'Jakarta', '26/09/1965', 'L', '2', 'Puri Gardena Blok C-3/21 Rt.003/014 Pegadunagn Kalideres JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'pauluspontohpcp', '55g858483', '', 0, '', '27-08-2020', '07:40:51', ''),
('', 2, 'SEC', '207070002', 'Samsudin ', 'Jakarta', '07/05/1977', 'L', '', 'Villa Meruya Rt.001/010 Meruya Selatan Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 6, 'ADMS', '208040006', 'Evi Landa  ', 'Jakarta', '09/07/1988', 'P', '', 'Meruya Selatan Rt.005/005 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 5, 'ADMP', '207020005', 'Friska Sari ', 'Jakarta', '20/04/1984', 'P', '', 'Jln.Palma I Blok B-23 No.9 Pokdok Rejeki Rt.006/005 Kota Bary Pasar Kemis Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 4, 'MTC', '207020004', 'Rizal', 'Jakarta', '21/09/1971', 'L', '', 'Meruya Selatan Rt.004/005 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 3, 'SEC', '207070003', 'Liid ', 'Tangerang', '05/07/1962', 'L', '', 'Jl.Karyawan III Rt.001/007 Karang Timur Karang Tengah Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 48, 'G01', '213070048', 'Teresia Setyo Handayani', ' Sragen ', '20/01/1976', 'P', '2', 'Nglangon Rt.003/002 Karang Tengah Sragen', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd', 'teresiasetyo', '55g858483', '', 0, '', '01-09-2020', '12:34:22', 'SD'),
('', 49, 'G01', '213070049', 'Raymundus Hendra Setiawan ', ' Jakarta ', '12/07/1985', 'L', '2', 'Jl.H.Baping Rt.003/009 Ciracas JakTim', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'raymundushendra', '55g858483', '', 0, '', '01-09-2020', '12:34:42', 'SD'),
('', 51, 'G01', '213070051', 'Metanoya Kristanto P.P', ' Laupakam ', '20/08/1981', 'L', '2', 'Jl.Pepera LR Rukun Jaya No.343 Rt.007/003 20 Ilir III Palembang', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.S', 'metanoyakristanto', '55g858483', '', 0, '', '01-09-2020', '12:34:56', 'SD'),
('', 52, 'G01', '213070052', 'Wiliwaldus Salih SVD ', 'Baru', '07/07/1985', 'L', '2', 'Jl.Bunga No.01 Rt.005/005 Meruya Selatan Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'wiliwaldussalih', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 54, 'G01', '213070054', 'Christina Labert Karyani', 'Yogyakarta', '25/04/1982', 'P', '2', 'Dasana Indah SG.3 No.2 Rt.003/012 Bojong Nangka Kelapa Dua Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'christinalabert', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 56, 'G01', '214070056', 'Agustin Rena Puspita', 'Jakarta', '12/08/1991', 'P', '3', 'Jl.Utan Jati Rt.002/011 Pegadungan Kalideres JakBar', 'JAKARTA BARAT', '0', '-', '-', 'INDONESIA', '', '', NULL, 'agustinrena', '', '', 0, '', '03-09-2020', '08:49:10', 'TK'),
('', 57, 'WKL', '214080057', 'Rahael Widyaningsih', 'Ambarawa', '18/06/1976', 'P', '3', 'Tanah Tinggi Rt.001/006 Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', ', M.Pd.', 'rahaelwidyaningsih', '', '', 0, '', '01-09-2020', '01:17:28', 'SD'),
('', 59, 'G01', '214070059', 'Fransiskus Bonevasio Rodos', 'Tenda', '08/06/1982', 'L', '2', 'Meruya Selatan Rt.004/005 Kembangan JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', ', M.Th', 'fransiskusbonevasio', '55g858483', '', 0, '', '01-09-2020', '12:35:21', 'SD'),
('', 60, 'G01', '214070060', 'Fitri Asrina Simanjuntak', 'P.Siantar', '25/03/1991', 'P', '3', 'Lingkungan Tapian Nauli Rt.001/001 Siantar Marihat Pematang Siantar', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd.', 'fitriasrina', '55g858483', '', 0, '', '01-09-2020', '12:36:04', 'SD'),
('', 62, 'G01', '214070062', 'Yasinta Retnaningrum', 'Sleman', '06/02/1981', 'P', '2', 'Koroulon Kidul Rt.001/026 Bimomartani Ngemplak Sleman', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd.', 'yasintaretnaningrum', '55g858483', '', 0, '', '01-09-2020', '12:36:18', 'SD'),
('', 64, 'G01', '214070064', 'Bekti Yustiarti', 'Sukabumi', '13/01/1988', 'P', '2', 'Perum Grand Regency Blok C 1 No.47 Rt.005/022 Padurenan Mustika Jaya Bekasi', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd', 'bektiyustiarti', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 67, 'IT', '214100067', 'Agus Setyawan ', 'Solo', '23/08/1983', 'L', '', 'Komp.Puri Serpong D-6/19 Rt.008/002 SETU Tangerang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 69, 'G01', '215060069', 'Fransiska Indah Sulistiowati', 'Jakarta', '14/12/1975', 'P', '3', 'Jl.Cendrawasih II/33 Rt.009/007 Cengkareng Barat JakBar', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.E', 'fransiskaindah', '55g858483', '', 0, '', '01-09-2020', '12:37:20', 'SD'),
('', 79, 'WKL', '215070079', 'Hesti Mariance Nainggolan', 'Balata', '20/04/1982', 'P', '3', 'Komp.Rangkai Permata II F No.08 Rt.001/007 Koto Baru NAN XX Padang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'hestimariance', '', '', 0, '', '01-09-2020', '02:33:16', 'SMA'),
('', 80, 'G01', '215070080', 'Christine V.S', 'Medan', '22/12/1989', 'P', '3', 'Dusun IV Timur A Jl.Pemasyarakatan GG Padi No.1 Rw.003 Tanjung Dusta Medan', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd.', 'christinevs', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 84, 'G01', '215050084', 'Agata Separdiana Diyah Mumpuni', 'Semarang', '08/09/1984', 'P', '2', 'Jl.Layur Utara I/A-24 Rt.007/012 Ungaran Semarang', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'agatasepardiana', '55g858483', '', 0, '', '01-09-2020', '12:04:35', 'TK'),
('', 90, 'G01', '216070090', 'Lucia Manalu ', ' Parratusan ', '09/09/1993', 'P', '3', 'Parratusan Manalu Dolok Parmonangan Tapanuli Utara', 'TAPANULI UTARA', '0', '-', '-', 'INDONESIA', '', '', NULL, 'luciamanalu', '', '', 0, '', '03-09-2020', '08:51:21', 'TK'),
('', 94, 'G01', '216070094', 'Bonifasius Firman Perkasa P ', 'Medan', '05/03/1991', 'L', '2', 'Rawamangun Tegalan Rt.009/003 Pulo Gadung JakTim', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'bonifasiusfirman', '55g858483', '', 0, '', '03-05-2018', '01:31:36', ''),
('', 97, 'ADMP', '217020097', 'Ester Dahlan', 'Jakarta', '13/04/1975', 'P', '', '', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'esterdahlan', '55g858483', '', 0, '', '11-08-2020', '10:22:26', ''),
('', 101, 'MTC', '217050101', 'Fachrudin', 'JAKARTA', '10-01-1976', 'L', '1', 'JL. MENTENG WADAS SELATAN RT/RW 005/009', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '03-05-2018', '02:53:22', ''),
('', 102, 'G01', '217070102', 'Luminta Intan Klementina', 'Jakarta', '04/09/1994', 'P', '3', 'KP BULAK RT002/ RW004, CINANGKA, SAWANGAN', 'DEPOK', '0', '-', '-', 'INDONESIA', '', '', NULL, 'lumintaintan', '', '', 0, '', '03-09-2020', '08:58:55', 'TK'),
('', 103, 'WKL', '217070103', 'Hartati Solafide Manullang ', 'P. Siantar', '21/06/1993', 'P', '3', 'JL. STADION NO.35 RT001/RW002, SUKADAME. SIANTAR UTARA, PEMATANGSIANTAR', 'PEMATANGSIANTAR', '0', '-', '-', 'INDONESIA', '', '', NULL, 'hartatisolafide', '', '', 0, '', '03-09-2020', '08:55:34', 'TK'),
('', 107, 'G01', '217070107', 'Arniaty Bangnga', 'Rantepao', '19/02/1990', 'P', '2', '', '-', '0', '-', '-', 'INDONESIA', '', '', ', S.Pd.', 'arniatybangnga', '55g858483', '', 0, '', '01-09-2020', '12:37:37', 'SD'),
('', 109, 'G01', '217070109', 'Susan', 'Bandung', '30/05/1977', 'P', '3', '', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'susan', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 115, 'NRS', '217070115', 'Kamelia Sana', 'Lewurla', '03/03/1996', 'L', '2', '', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 116, 'DRV', '217070116', 'Ahmadi', 'Jakarta', '07/03/1975', 'L', '1', 'Jl. Meruya Selatan Gang H. Siti RT 7 RW 2 No 77 ', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '04-08-2020', '07:30:28', ''),
('', 120, 'G01', '217080120', 'Febril Darwati Waruwu', 'Tetehosi', '02/02/1993', 'P', '3', 'Jl. Pancasila N0.03 Dusun I', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'febrildarwati', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('A', 8999999999, '@@@', '800000', '8ADMINTK', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '800000', '55g858483', '', 0, '', '', '00:00:00', ''),
('A', 1999999999, '@@@', '100000', 'Paulus Pontoh', '', '', 'L', '', '', '', '', '', '', '', '', '', NULL, '100000', '55g858483', '', 0, '', '', '00:00:00', ''),
('', 123, 'G01', '217080123', 'Rentika', 'Tangerang', '01-07-1990', 'P', '3', 'Jl. Diponogoro 3 Blok L3 No. 19 Rt 03/08 Kel Alam Jaya Kec. Jatiwulung Tangerang', '', '', '', '', 'INDONESIA', '', '', NULL, 'rentika', '55g858483', '', 0, '', '01-09-2020', '12:38:44', 'SD'),
('A', 10000000144, '@@@', '200000', 'Parwin Beby', '', '', 'P', '', '', '', '', '', '', '', '', '', NULL, '200000', '55g858483', '', 0, '', '', '00:00:00', ''),
('A', 10000000145, '@@@', '700000', '7ADMINSD', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '700000', '55g858483', '', 0, '', '', '00:00:00', ''),
('', 129, 'G01', '218030129', 'Karto Pranata Bukit', 'Sibolga', '25-10-1992', 'L', '2', 'Jl. MELATI RAYA NO.43 RT/RW. 001/09 Kel. Kapuk Kec. Cengkareng', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'kartopranata', '55g858483', '', 0, '', '01-09-2020', '12:31:49', 'SD'),
('', 124, 'IT', '22007287', 'Daniel Parlindungan', 'Jakarta', '10-05-1987', 'L', '2', 'Komplek Pondok Bahar Permai Blok B1 no.6 Karang Tengah Tangerang', 'Tangerang', '15159', '', '089614208454', 'INDONESIA', '', '', ', S. Kom', 'danielparlindungan', '55g858483', '', 0, '', '27-08-2020', '09:04:11', ''),
('', 10000000128, 'MKT', '218020128', 'Tika', 'Yogyakarta', '07-08-1969', 'P', '2', 'Jl. Anyelir no. 138 Komplek Kodam Kebon Jeruk', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, 'tika', '55g858483', '', 0, '', '13/08/2012', '00:00:02', ''),
('', 130, 'SEC', '218040130', 'M. Sayuti', 'JAKARTA', '03-09-1985', 'L', '1', 'MERUYA SELATAN RT 003/006 KEMBANGAN', '-', '0', '-', '-', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '22-05-2018', '03:21:57', ''),
('', 133, 'G01', '218070133', 'Yolanda Octa Putri Bangun', 'MEDAN', '03-10-1993', 'P', '3', 'JL. TEROMPET NO. 09 MEDAN KEL. TITI RANTAI KEC. MEDAN BARU MEDAN', 'MEDAN', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '09:53:35', ''),
('', 132, 'G01', '218070132', 'BETHARIA SONATA SIMANJUNTAK', 'PEMATANGSIANTAR', '29-12-1989', 'P', '3', 'JL. SERIBU DOLOK RT/RW 012/004 KEL. NAGAHUTA KEC. SIANTAR MARIMBUN PEMATANGSIANTAR', 'PEMATANGSIANTAR', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '09:46:46', ''),
('', 139, 'G01', '218070139', 'Verzosa Rodel Romere', 'GUAGUA PAMPANGA', '24-08-1987', 'L', '', '', '', '', '', '', '', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '08:27:02', ''),
('', 85, '11090', '218070138', 'FITRIA NINGSIH RAJAGUKGUK', 'JAMBI', '28-09-1993', 'P', '3', 'JL. LINTAS TIMUR RT/RW 012/- KEL. PENYENGAT RENDAH KEC. TELANAIPURA JAMBI', 'JAMBI', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '08:42:59', ''),
('', 140, 'G01', '218070140', 'VERONIKA DAFLORENSIA PARERA', 'SAMARINDA', '27-04-1993', 'P', '2', 'JL. BPTP I / 37 - SIDOMULYO ASRI RT/RW 007/005 KEL. SIDOMULYO KEC. UNGARAN TIMUR SEMARANG', 'SEMARANG', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '08:45:09', ''),
('', 141, 'G01', '218070141', 'RISKI YANUARITA', 'CILACAP', '28-01-1980', 'P', '2', 'DSN BADAAN RT/RW 004/006 KEL. BEBENGAN KEC. BOJA KENDAL', 'KENDAL', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '08:47:11', ''),
('', 134, 'G01', '218070134', 'YULIUS BAYU GIRI', 'JAKARTA', '10-07-1987', 'L', '2', 'KOMP DPR RI BLOK K-36 A RT/RW 015/001 KEL. JOGLO KEC. KEMBANGAN JAKARTA BARAT', 'JAKARTA BARAT', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '06-07-2018', '09:59:14', ''),
('', 144, 'A01', '218070144', 'Romauli Theresia Sinaga', 'SALBE', '06-09-1980', 'P', '2', 'KOMPLEK BPK II D - 16 KEBON JERUK', '', '', '', '', 'INDONESIA', '', '', NULL, 'romaulitheresia', '55g858483', '', 0, '', '03-09-2020', '11:06:44', 'SMA'),
('', 10000000143, 'G01', '219070169', 'Doni Douglas Tambunan', 'Lima Puluh', '16-05-1991', 'L', '3', 'Lk. VI', '', '', '', '', '', '', '', NULL, 'donidouglas', '55g858483', '', 0, '', '04-08-2020', '07:37:21', ''),
('', 147, 'CCTV', '218080147', 'Febrianti Veronika', 'Tangerang', '26-02-1994', 'P', '3', 'Jl. Griya Asri blok G no. 10 RT 005 / RW 007  Kel. Jelupang Kec. Serpong Utara', '', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '27-08-2020', '02:18:09', ''),
('', 149, 'MTC', '218070149', 'FAHMI BURHAM', 'TANGERANG', '05-07-1999', 'L', '1', 'JL. H JALI RT/RW 005/002 KEL. KUNCIRAN JAYA KEC. PINANG KOTA TANGERANG', '', '', '', '', '', '', '', NULL, NULL, '55g858483', '', 0, '', '14-08-2018', '02:53:32', ''),
('', 150, '11090', '218080150', 'YOHAN MANTOVANI', 'JAKARTA', '1980', 'L', '3', '\r\n', 'JAKARTA BARAT', '', '', '', 'INDONESIA', '', '', NULL, NULL, '55g858483', '', 0, '', '11-08-2020', '08:27:35', ''),
('', 10000000155, 'G01', '219070178', 'Irine Kusuma Indah', 'JAKARTA', '29/4/1984', 'P', '3', 'JL. LONTAR BARAT NO.11 RT017/RW006, GROGOL PETAMBURAN', 'JAKARTA BARAT', '', '', '', '', '', '', NULL, 'irinekusuma', '55g858483', '', 0, '', '01-09-2020', '12:23:28', 'SD'),
('', 10000000156, 'G01', '2190701181', 'Giovanni Phoskharis Eulogia', 'YOGYAKARTA', '01/11/1991', 'L', '2', 'HARJOWINATAN PA 1/783 RT045/RW010, PURWOKINANTI, PAKUALAMAN', 'YOGYAKARTA', '', '', '', '', '', '', NULL, 'giovanniphoskharis', '55g858483', '', 0, '', '01-09-2020', '12:10:26', 'SD'),
('', 10000000157, 'G01', '219080183', 'Ester Matondang', 'LUMBAN MATONDANG', '06/11/1994', 'P', '3', 'LUMBAN MATONDANG, MATITI, DOLOK SANGGUL, SUMATERA UTARA', 'HUMBANG HASUNDUTAN', '', '', '', '', '', '', NULL, NULL, '55g858483', '', 0, '', '01-09-2020', '03:06:28', 'SD'),
('', 10000000158, 'G01', '22007284', 'Ridwanto', 'JAKARTA', '07/05/1990', 'L', '2', 'JL. CENDRAWASIH NO.22 RT001/RW014, BEIJI', 'DEPOK', '', '', '', '', '', '', NULL, NULL, '55g858483', '', 0, '', '01-09-2020', '03:14:58', 'SD');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
