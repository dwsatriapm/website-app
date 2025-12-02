/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.5.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: laundry_app
-- ------------------------------------------------------
-- Server version	10.5.29-MariaDB-ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `master`
--

DROP TABLE IF EXISTS `master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `master` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','Karyawan') NOT NULL DEFAULT 'Karyawan',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master`
--

LOCK TABLES `master` WRITE;
/*!40000 ALTER TABLE `master` DISABLE KEYS */;
INSERT INTO `master` VALUES (4,'Admin','admin@mail.com','admin','$2y$10$mi.Q/r6k5TFricaNcyr4y.3hm0qsFQeOWZEhXhJoN0h3W/bDQC/1m','Admin'),(13,'pram','pram@staff.co','pram','$2y$10$eeTGpysyBF/17V0D80slE.WL4fJAHRFG6Qwf77pKEUVpWeE9/mQzq','Karyawan'),(17,'faqih','faqih@staff.co','faqih','$2y$10$PgPDnxgk2m4Dc1SfH6lZUurh/CcqHgUJHD8HMjbM84gWVj.1Cujt6','Karyawan'),(18,'adimas','adimas@staff.co','adimas','$2y$10$chuxvce/pLAO7TGWQHCnI..4v.brPnDMm22kEKiRtwQUY2XxKcIgK','Karyawan'),(19,'nabil','nabil@staff.co','nabil','$2y$10$brlRggWcf78l3g44qJu0g..IgxMDGElspMCz5UItqxV.w4THe5haa','Karyawan');
/*!40000 ALTER TABLE `master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_cuci_komplit`
--

DROP TABLE IF EXISTS `tb_cuci_komplit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_cuci_komplit` (
  `id_ck` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket_ck` varchar(100) NOT NULL,
  `waktu_kerja_ck` varchar(20) NOT NULL,
  `kuantitas_ck` int(11) NOT NULL,
  `tarif_ck` int(11) NOT NULL,
  PRIMARY KEY (`id_ck`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cuci_komplit`
--

LOCK TABLES `tb_cuci_komplit` WRITE;
/*!40000 ALTER TABLE `tb_cuci_komplit` DISABLE KEYS */;
INSERT INTO `tb_cuci_komplit` VALUES (1,'Cuci Komplit Reguler','2 Hari',1,80000),(2,'Cuci Komplit Kilat','1 Hari',1,15000),(21,'Cuci Komplit Express','5 Jam',1,20000);
/*!40000 ALTER TABLE `tb_cuci_komplit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_cuci_satuan`
--

DROP TABLE IF EXISTS `tb_cuci_satuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_cuci_satuan` (
  `id_cs` int(11) NOT NULL AUTO_INCREMENT,
  `nama_cs` varchar(100) NOT NULL,
  `waktu_kerja_cs` varchar(20) NOT NULL,
  `kuantitas_cs` int(11) NOT NULL,
  `tarif_cs` int(11) NOT NULL,
  `keterangan_cs` text NOT NULL,
  PRIMARY KEY (`id_cs`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cuci_satuan`
--

LOCK TABLES `tb_cuci_satuan` WRITE;
/*!40000 ALTER TABLE `tb_cuci_satuan` DISABLE KEYS */;
INSERT INTO `tb_cuci_satuan` VALUES (1,'Jaket Kulit','1 Hari',1,15000,''),(2,'Jaket Non Kulit','1 Hari',1,6000,''),(3,'Boneka Mini','1 Hari',1,3000,''),(4,'Boneka Kecil','1 Hari',1,6000,''),(5,'Boneka Sedang','1 Hari',1,10000,''),(6,'Boneka Besar','1 Hari',1,20000,''),(7,'Sejadah','1 Hari',1,20000,''),(8,'Selimut','1 Hari',1,20000,''),(12,'Keset','1 Hari',1,20000,'-');
/*!40000 ALTER TABLE `tb_cuci_satuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_dry_clean`
--

DROP TABLE IF EXISTS `tb_dry_clean`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_dry_clean` (
  `id_dc` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket_dc` varchar(100) NOT NULL,
  `waktu_kerja_dc` varchar(20) NOT NULL,
  `kuantitas_dc` int(11) NOT NULL,
  `tarif_dc` int(11) NOT NULL,
  PRIMARY KEY (`id_dc`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_dry_clean`
--

LOCK TABLES `tb_dry_clean` WRITE;
/*!40000 ALTER TABLE `tb_dry_clean` DISABLE KEYS */;
INSERT INTO `tb_dry_clean` VALUES (1,'Cuci Kering Reguler','2 Hari',1,6000),(2,'Cuci Kering Kilat','1 Hari',1,9000),(3,'Cuci Kering Express','5 Jam',1,15000);
/*!40000 ALTER TABLE `tb_dry_clean` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_order_ck`
--

DROP TABLE IF EXISTS `tb_order_ck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_order_ck` (
  `id_order_ck` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `or_ck_number` varchar(10) DEFAULT NULL,
  `nama_pel_ck` varchar(100) NOT NULL,
  `no_telp_ck` char(13) NOT NULL,
  `alamat_ck` text NOT NULL,
  `jenis_paket_ck` varchar(100) NOT NULL,
  `wkt_krj_ck` varchar(30) DEFAULT NULL,
  `berat_qty_ck` int(11) NOT NULL,
  `harga_perkilo` int(11) DEFAULT NULL,
  `tgl_masuk_ck` date NOT NULL,
  `tgl_keluar_ck` date NOT NULL,
  `tot_bayar` double DEFAULT NULL,
  `keterangan_ck` text NOT NULL,
  PRIMARY KEY (`id_order_ck`),
  KEY `idx_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_order_ck`
--

LOCK TABLES `tb_order_ck` WRITE;
/*!40000 ALTER TABLE `tb_order_ck` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_order_ck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_order_cs`
--

DROP TABLE IF EXISTS `tb_order_cs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_order_cs` (
  `id_order_cs` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `or_cs_number` varchar(10) NOT NULL,
  `nama_pel_cs` varchar(100) NOT NULL,
  `no_telp_cs` varchar(13) NOT NULL,
  `alamat_cs` text NOT NULL,
  `jenis_paket_cs` varchar(100) NOT NULL,
  `wkt_krj_cs` varchar(30) DEFAULT NULL,
  `jml_pcs` int(11) NOT NULL,
  `harga_perpcs` int(11) NOT NULL,
  `tgl_masuk_cs` date NOT NULL,
  `tgl_keluar_cs` date NOT NULL,
  `tot_bayar` double NOT NULL,
  `keterangan_cs` text NOT NULL,
  PRIMARY KEY (`id_order_cs`),
  KEY `idx_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_order_cs`
--

LOCK TABLES `tb_order_cs` WRITE;
/*!40000 ALTER TABLE `tb_order_cs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_order_cs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_order_dc`
--

DROP TABLE IF EXISTS `tb_order_dc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_order_dc` (
  `id_order_dc` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `or_dc_number` varchar(10) NOT NULL,
  `nama_pel_dc` varchar(100) NOT NULL,
  `no_telp_dc` varchar(13) NOT NULL,
  `alamat_dc` text NOT NULL,
  `jenis_paket_dc` varchar(100) NOT NULL,
  `wkt_krj_dc` varchar(30) DEFAULT NULL,
  `berat_qty_dc` int(11) NOT NULL,
  `harga_perkilo` int(11) NOT NULL,
  `tgl_masuk_dc` date NOT NULL,
  `tgl_keluar_dc` date NOT NULL,
  `tot_bayar` double NOT NULL,
  `keterangan_dc` text NOT NULL,
  PRIMARY KEY (`id_order_dc`),
  KEY `idx_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_order_dc`
--

LOCK TABLES `tb_order_dc` WRITE;
/*!40000 ALTER TABLE `tb_order_dc` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_order_dc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pelanggan`
--

DROP TABLE IF EXISTS `tb_pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_pelanggan`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pelanggan`
--

LOCK TABLES `tb_pelanggan` WRITE;
/*!40000 ALTER TABLE `tb_pelanggan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_riwayat_ck`
--

DROP TABLE IF EXISTS `tb_riwayat_ck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_riwayat_ck` (
  `id_ck` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `or_number` varchar(20) NOT NULL,
  `pelanggan` varchar(100) NOT NULL,
  `no_telp` char(15) NOT NULL,
  `alamat` text NOT NULL,
  `j_paket` varchar(50) NOT NULL,
  `wkt_kerja` varchar(20) NOT NULL,
  `berat` int(5) NOT NULL,
  `h_perkilo` int(11) NOT NULL,
  `tgl_msk` varchar(40) NOT NULL,
  `tgl_klr` varchar(40) NOT NULL,
  `total` int(11) NOT NULL,
  `nominal_byr` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_ck`),
  KEY `idx_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_riwayat_ck`
--

LOCK TABLES `tb_riwayat_ck` WRITE;
/*!40000 ALTER TABLE `tb_riwayat_ck` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_riwayat_ck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_riwayat_cs`
--

DROP TABLE IF EXISTS `tb_riwayat_cs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_riwayat_cs` (
  `id_cs` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `or_number` varchar(20) DEFAULT NULL,
  `pelanggan` varchar(100) DEFAULT NULL,
  `no_telp` char(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `j_paket` varchar(50) DEFAULT NULL,
  `wkt_kerja` varchar(20) DEFAULT NULL,
  `jml_pcs` int(11) DEFAULT NULL,
  `h_perpcs` int(11) DEFAULT NULL,
  `tgl_msk` varchar(40) DEFAULT NULL,
  `tgl_klr` varchar(40) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `nominal_byr` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_cs`),
  KEY `idx_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_riwayat_cs`
--

LOCK TABLES `tb_riwayat_cs` WRITE;
/*!40000 ALTER TABLE `tb_riwayat_cs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_riwayat_cs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_riwayat_dc`
--

DROP TABLE IF EXISTS `tb_riwayat_dc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_riwayat_dc` (
  `id_dc` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) DEFAULT NULL,
  `or_number` varchar(20) DEFAULT NULL,
  `pelanggan` varchar(100) DEFAULT NULL,
  `no_telp` char(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `j_paket` varchar(40) DEFAULT NULL,
  `wkt_kerja` varchar(20) DEFAULT NULL,
  `berat` int(11) DEFAULT NULL,
  `h_perkilo` int(11) DEFAULT NULL,
  `tgl_msk` varchar(40) DEFAULT NULL,
  `tgl_klr` varchar(40) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `nominal_byr` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_dc`),
  KEY `idx_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_riwayat_dc`
--

LOCK TABLES `tb_riwayat_dc` WRITE;
/*!40000 ALTER TABLE `tb_riwayat_dc` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_riwayat_dc` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-02  8:05:08
