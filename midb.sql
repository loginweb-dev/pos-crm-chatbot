-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: pos
-- ------------------------------------------------------
-- Server version	8.0.28-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caja_users`
--

DROP TABLE IF EXISTS `caja_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `caja_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `caja_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caja_users`
--

LOCK TABLES `caja_users` WRITE;
/*!40000 ALTER TABLE `caja_users` DISABLE KEYS */;
INSERT INTO `caja_users` VALUES (5,3,3,NULL,NULL,NULL),(6,3,2,NULL,NULL,NULL),(7,4,2,NULL,NULL,NULL);
/*!40000 ALTER TABLE `caja_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cajas`
--

DROP TABLE IF EXISTS `cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cajas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sucursal_id` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `estado` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas`
--

LOCK TABLES `cajas` WRITE;
/*!40000 ALTER TABLE `cajas` DISABLE KEYS */;
INSERT INTO `cajas` VALUES (3,1,NULL,'Caja#1','2022-02-20 00:26:16','2022-02-22 22:16:49',NULL,'open'),(4,1,NULL,'Caja# 2','2022-02-23 21:25:24','2022-02-23 21:25:24',NULL,'close');
/*!40000 ALTER TABLE `cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Menu Principal',NULL,NULL,'2022-02-15 22:32:25','2022-02-18 19:26:30',NULL),(2,'Refrescos y Gaceosas',NULL,NULL,'2022-02-15 22:33:32','2022-02-18 19:26:55',NULL),(3,'Extras',NULL,NULL,'2022-02-15 22:33:42','2022-02-15 22:33:42',NULL),(4,'Otros',NULL,NULL,'2022-02-15 22:35:29','2022-02-16 12:26:51',NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci_nit` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Cliente','Generico',NULL,'561901902',NULL,NULL,'cliente.generico@loginweb.dev','2022-02-16 14:50:00','2022-02-20 22:36:09',NULL),(2,'Jonathan Emanuel','Chavez Moscoso','70269362','6476764',NULL,NULL,NULL,'2022-02-20 21:51:37','2022-02-20 22:19:50',NULL);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `editor_id` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `costo` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupones`
--

DROP TABLE IF EXISTS `cupones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cupones` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupones`
--

LOCK TABLES `cupones` WRITE;
/*!40000 ALTER TABLE `cupones` DISABLE KEYS */;
INSERT INTO `cupones` VALUES (1,'Sin Cupon',NULL,0,'2022-02-19 16:27:29','2022-02-19 16:27:29',NULL),(2,'Descuento por Registro',NULL,10,'2022-02-21 01:00:21','2022-02-21 01:00:21',NULL),(3,'Descuento por Fiestas Patrias',NULL,20,'2022-02-22 20:23:12','2022-02-22 20:23:12',NULL);
/*!40000 ALTER TABLE `cupones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_rows`
--

DROP TABLE IF EXISTS `data_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_rows` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `data_type_id` int unsigned NOT NULL,
  `field` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `data_rows_data_type_id_foreign` (`data_type_id`),
  CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_rows`
--

LOCK TABLES `data_rows` WRITE;
/*!40000 ALTER TABLE `data_rows` DISABLE KEYS */;
INSERT INTO `data_rows` VALUES (1,1,'id','number','ID',1,0,0,0,0,0,NULL,1),(2,1,'name','text','Name',1,1,1,1,1,1,NULL,2),(3,1,'email','text','Email',1,1,1,1,1,1,NULL,3),(4,1,'password','password','Password',1,0,0,1,1,0,NULL,4),(5,1,'remember_token','text','Remember Token',0,0,0,0,0,0,NULL,5),(6,1,'created_at','timestamp','Created At',0,1,1,0,0,0,NULL,6),(7,1,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(8,1,'avatar','image','Avatar',0,1,1,1,1,1,NULL,8),(9,1,'user_belongsto_role_relationship','relationship','Role',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":0}',10),(10,1,'user_belongstomany_role_relationship','relationship','voyager::seeders.data_rows.roles',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}',11),(11,1,'settings','hidden','Settings',0,0,0,0,0,0,NULL,12),(12,2,'id','number','ID',1,0,0,0,0,0,NULL,1),(13,2,'name','text','Name',1,1,1,1,1,1,NULL,2),(14,2,'created_at','timestamp','Created At',0,0,0,0,0,0,NULL,3),(15,2,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,4),(16,3,'id','number','ID',1,0,0,0,0,0,NULL,1),(17,3,'name','text','Name',1,1,1,1,1,1,NULL,2),(18,3,'created_at','timestamp','Created At',0,0,0,0,0,0,NULL,3),(19,3,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,4),(20,3,'display_name','text','Display Name',1,1,1,1,1,1,NULL,5),(21,1,'role_id','text','Role',1,1,1,1,1,1,NULL,9),(22,4,'id','text','Id',1,1,1,0,0,0,'{}',1),(23,4,'name','text','Name',0,1,1,1,1,1,'{}',2),(24,4,'description','text_area','Description',0,1,1,1,1,1,'{}',3),(25,4,'image','image','Image',0,1,1,1,1,1,'{}',4),(26,4,'created_at','timestamp','Created At',0,0,1,0,0,0,'{}',5),(27,4,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',6),(28,4,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',7),(29,5,'id','text','Id',1,1,1,0,0,0,'{}',1),(30,5,'first_name','text','Nombres',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',2),(31,5,'last_name','text','Apellidos',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',3),(32,5,'phone','number','Telefono',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',4),(33,5,'ci_nit','text','Carnet o NIT',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',5),(34,5,'avatar','image','Perfil',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',6),(35,5,'direccion','text','Direccion',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',7),(36,5,'email','text','Email',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',8),(37,5,'created_at','timestamp','Creado',0,0,1,0,0,0,'{}',9),(38,5,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',10),(39,5,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',11),(40,6,'id','number','Id',1,1,1,0,0,0,'{}',1),(41,6,'name','text','Nombre',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',4),(42,6,'categoria_id','number','Categoría',0,1,1,1,1,0,'{}',5),(43,6,'description','text_area','Descripción',0,0,1,1,1,1,'{\"display\":{\"width\":6}}',9),(44,6,'image','image','Imagen',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',8),(45,6,'precio','number','Precio',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',6),(46,6,'stock','number','Stock',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',7),(47,6,'created_at','timestamp','Created At',0,0,1,0,0,0,'{}',10),(48,6,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',11),(49,6,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',13),(51,7,'id','text','Id',1,1,1,0,0,0,'{}',1),(52,7,'name','text','Nombre',0,1,1,1,1,1,'{}',2),(53,7,'ciudad','text','Ciudad',0,1,1,1,1,1,'{}',3),(54,7,'direccion','text_area','Dirección',0,1,1,1,1,1,'{}',5),(55,7,'observaciones','text_area','Observaciones',0,1,1,1,1,1,'{}',6),(56,7,'created_at','timestamp','Created At',0,0,0,1,0,0,'{}',7),(57,7,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',8),(58,7,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',9),(59,8,'id','text','Ticket',1,1,1,0,0,0,'{}',1),(60,8,'cliente_id','hidden','Cliente',0,1,1,1,1,0,'{}',11),(63,8,'observacion','hidden','Mensaje',0,0,1,1,1,0,'{}',10),(65,8,'cupon_id','hidden','Cupon',0,1,1,1,1,0,'{}',13),(66,8,'descuento','number','Desc',0,1,1,1,1,0,'{\"display\":{\"width\":6},\"default\":0}',8),(67,8,'total','number','Total',0,1,1,1,1,1,'{\"display\":{\"width\":6},\"default\":0}',9),(68,8,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',14),(69,8,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',15),(70,8,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',16),(71,6,'producto_belongsto_categoria_relationship','relationship','Categoria',0,1,1,1,1,1,'{\"display\":{\"width\":6},\"model\":\"App\\\\Categoria\",\"table\":\"categorias\",\"type\":\"belongsTo\",\"column\":\"categoria_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(72,9,'id','text','Id',1,1,1,0,0,0,'{}',1),(75,9,'phone','text','Phone',0,1,1,1,1,1,'{}',4),(76,9,'avatar','text','Avatar',0,1,1,1,1,1,'{}',5),(77,9,'statu','text','Statu',0,1,1,1,1,1,'{}',6),(78,9,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',7),(79,9,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',8),(80,9,'deleted_at','timestamp','Deleted At',0,1,1,1,1,1,'{}',9),(81,10,'id','text','Id',1,1,1,0,0,0,'{}',1),(82,10,'title','text','Title',0,1,1,1,1,1,'{}',2),(83,10,'statu','text','Statu',0,1,1,1,1,1,'{}',3),(84,10,'valor','text','Valor',0,1,1,1,1,1,'{}',4),(85,10,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',5),(86,10,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',6),(87,10,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',7),(88,11,'id','text','Id',1,1,1,0,0,0,'{}',1),(89,11,'name','text','Nombre',0,1,1,1,1,1,'{}',3),(90,11,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',5),(91,11,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',6),(92,11,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',7),(93,12,'id','text','Id',1,1,1,0,0,0,'{}',1),(95,12,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',8),(96,12,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',7),(97,12,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',9),(100,8,'option_id','radio_btn','Orden',0,1,1,1,1,1,'{\"display\":{\"width\":6},\"default\":\"Mesa\",\"options\":{\"Mesa\":\"Mesa\",\"Delivery\":\"Delivery\",\"Recoger\":\"Recoger\"}}',4),(102,13,'id','text','Id',1,1,1,0,0,0,'{}',1),(103,13,'title','text','Title',0,1,1,1,1,1,'{}',2),(104,13,'description','text','Description',0,1,1,1,1,1,'{}',3),(105,13,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',4),(106,13,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',5),(107,13,'deleted_at','timestamp','Deleted At',0,1,1,1,1,0,'{}',6),(111,14,'id','text','Id',1,1,1,0,0,0,'{}',1),(112,14,'title','text','Title',0,1,1,1,1,1,'{}',2),(113,14,'description','text_area','Description',0,1,1,1,1,1,'{}',3),(114,14,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',4),(115,14,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',5),(116,14,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',6),(118,8,'pago_id','hidden','Pasarela',0,1,1,1,1,0,'{}',6),(119,12,'description','text_area','Detalle',0,0,1,1,1,0,'{}',5),(120,12,'user_id','hidden','Editor',0,1,1,1,1,1,'{}',6),(121,12,'producto_id','text','Producto Id',0,1,1,1,1,1,'{}',10),(122,12,'cantidad','number','Cantidad',0,1,1,1,1,1,'{}',3),(123,12,'valor','number','Costo',0,1,1,1,1,1,'{}',4),(124,12,'production_belongsto_producto_relationship','relationship','Producto',0,1,1,1,1,1,'{\"model\":\"App\\\\Producto\",\"table\":\"productos\",\"type\":\"belongsTo\",\"column\":\"producto_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}',2),(125,11,'unidad_id','text','Unidad Id',0,1,1,1,1,1,'{}',8),(126,11,'description','text_area','Descripcion',0,1,1,1,1,1,'{}',4),(127,15,'id','text','Id',1,1,1,0,0,0,'{}',1),(128,15,'title','text','Title',0,1,1,1,1,1,'{}',2),(129,15,'description','text_area','Description',0,1,1,1,1,1,'{}',3),(130,15,'created_at','timestamp','Created At',0,0,1,0,0,0,'{}',4),(131,15,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',5),(132,15,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',6),(133,11,'insumo_belongsto_unidade_relationship','relationship','Unidad',0,1,1,1,1,1,'{\"model\":\"App\\\\Unidade\",\"table\":\"unidades\",\"type\":\"belongsTo\",\"column\":\"unidad_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}',2),(136,6,'sucursal_id','text','Sucursal Id',0,1,1,1,1,1,'{}',12),(137,6,'producto_belongsto_sucursale_relationship','relationship','Sucursal',0,1,1,1,1,1,'{\"model\":\"App\\\\Sucursale\",\"table\":\"sucursales\",\"type\":\"belongsTo\",\"column\":\"sucursal_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categorias\",\"pivot\":\"0\",\"taggable\":\"0\"}',2),(138,8,'factura','radio_btn','Tipo',0,1,1,1,1,1,'{\"default\":\"Recibo\",\"options\":{\"Recibo\":\"Recibo\",\"Factura\":\"Factura\"},\"display\":{\"width\":6}}',3),(139,7,'sucursale_belongstomany_user_relationship','relationship','users',0,1,1,1,1,1,'{\"foreign_pivot_key\":\"sucursal_id\",\"related_pivot_key\":\"user_id\",\"parent_key\":\"id\",\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"sucursal_users\",\"pivot\":\"1\",\"taggable\":\"0\"}',4),(140,16,'id','text','Id',1,1,1,0,0,0,'{}',1),(142,16,'sucursal_id','text','Sucursal Id',0,1,1,1,1,1,'{}',3),(143,16,'description','text_area','Description',0,0,1,1,1,1,'{\"display\":{\"width\":6}}',10),(144,16,'title','text','Title',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',2),(147,16,'created_at','timestamp','Created At',0,1,1,0,0,0,'{}',4),(148,16,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',5),(149,16,'deleted_at','timestamp','Deleted At',0,0,0,0,0,0,'{}',7),(150,8,'register_id','hidden','Editor',0,1,1,1,1,0,'{}',12),(152,11,'costo','text','Costo',0,1,1,1,1,1,'{}',8),(153,8,'status_id','hidden','Estado',0,1,1,1,1,0,'{}',7),(154,8,'ticket','hidden','Ticket',0,0,1,1,1,0,'{}',15),(155,16,'caja_belongstomany_user_relationship','relationship','Usuarios',0,1,1,1,1,1,'{\"display\":{\"width\":6},\"foreign_pivot_key\":\"caja_id\",\"related_pivot_key\":\"user_id\",\"parent_key\":\"id\",\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"caja_users\",\"pivot\":\"1\",\"taggable\":\"0\"}',9),(156,16,'caja_belongsto_sucursale_relationship','relationship','sucursales',0,1,1,1,1,1,'{\"display\":{\"width\":6},\"model\":\"App\\\\Sucursale\",\"table\":\"sucursales\",\"type\":\"belongsTo\",\"column\":\"sucursal_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"caja_users\",\"pivot\":\"0\",\"taggable\":\"0\"}',8),(157,8,'caja_id','hidden','Caja',0,1,1,1,1,0,'{}',16),(158,17,'id','text','Id',1,0,1,0,0,0,'{}',1),(159,17,'producto_id','text','Producto',0,1,1,1,1,0,'{}',2),(160,17,'venta_id','text','Venta',0,1,1,0,0,0,'{}',9),(161,17,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',8),(162,17,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',10),(163,17,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',11),(164,17,'precio','text','Precio',0,1,1,1,1,0,'{}',5),(165,17,'cantidad','text','Cantidad',0,1,1,1,1,0,'{}',6),(166,17,'total','text','Total',0,1,1,1,1,0,'{}',7),(167,18,'id','text','Id',1,0,0,0,0,0,'{}',1),(168,18,'production_id','text','Production Id',0,1,1,1,1,0,'{}',2),(169,18,'insumo_id','text','Insumo Id',0,1,1,1,1,1,'{}',3),(170,18,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',9),(171,18,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',4),(172,18,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',5),(173,18,'precio','text','Precio',0,1,1,1,1,0,'{}',6),(174,18,'cantidad','text','Cantidad',0,1,1,1,1,0,'{}',7),(175,18,'total','text','Total',0,1,1,1,1,0,'{}',8),(176,21,'id','text','Id',1,0,0,0,0,0,'{}',1),(177,21,'title','text','Title',0,1,1,1,1,1,'{}',2),(178,21,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',3),(179,21,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',4),(180,21,'deleted_at','timestamp','Deleted At',0,1,1,1,1,1,'{}',5),(181,8,'caja_status','hidden','Caja Status',0,0,1,1,1,0,'{}',17),(182,16,'estado','radio_btn','Estado',0,1,1,1,1,1,'{\"display\":{\"width\":6},\"default\":\"open\",\"options\":{\"close\":\"Cerrado\",\"open\":\"Abierto\"}}',6),(183,8,'delivery_id','hidden','Delivery',0,1,1,1,1,1,'{}',18),(184,9,'name','text','Name',0,1,1,1,1,1,'{}',8),(185,25,'id','text','Id',1,0,0,0,0,0,'{}',1),(186,25,'title','text','Title',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',2),(187,25,'direccion','text','Direccion',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',3),(188,25,'description','text_area','Description',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',4),(189,25,'created_at','timestamp','Created At',0,1,1,1,0,0,'{}',5),(190,25,'updated_at','timestamp','Updated At',0,0,0,1,0,0,'{}',6),(191,25,'deleted_at','timestamp','Deleted At',0,0,0,0,0,0,'{}',7),(192,17,'foto','image','Imagen',0,1,1,1,1,0,'{}',4),(193,26,'id','text','Id',1,1,1,0,0,0,'{}',1),(194,26,'name','text','Name',0,1,1,1,1,1,'{\"display\":{\"width\":6}}',2),(195,26,'description','text_area','Description',0,0,1,1,1,1,'{\"display\":{\"width\":6}}',3),(196,26,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',4),(197,26,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',5),(198,26,'deleted_at','timestamp','Deleted At',0,0,0,0,0,0,'{}',6),(199,26,'costo','number','Costo',0,1,1,1,1,1,'{}',7),(200,17,'name','text','Name',0,1,1,1,1,0,'{}',3),(201,37,'id','text','Id',1,1,1,0,0,0,'{}',1),(202,37,'producto_semi_id','text','Producto Semi Id',0,1,1,1,1,1,'{}',3),(203,37,'user_id','hidden','User Id',0,1,1,0,1,0,'{}',4),(204,37,'cantidad','text','Cantidad',0,1,1,1,1,1,'{}',5),(205,37,'valor','text','Valor',0,1,1,1,1,1,'{}',6),(206,37,'description','text_area','Description',0,0,1,1,1,1,'{}',7),(207,37,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',8),(208,37,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',9),(209,37,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',10),(211,38,'id','text','Id',1,0,0,0,0,0,'{}',1),(212,38,'production_semi_id','text','Production Semi Id',0,1,1,1,1,1,'{}',2),(213,38,'insumo_id','text','Insumo Id',0,1,1,1,1,1,'{}',3),(214,38,'precio','text','Precio',0,1,1,1,1,1,'{}',4),(215,38,'cantidad','text','Cantidad',0,1,1,1,1,1,'{}',5),(216,38,'total','text','Total',0,1,1,1,1,1,'{}',6),(217,38,'created_at','timestamp','Created At',0,1,1,0,0,0,'{}',7),(218,38,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',8),(219,38,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',9),(220,38,'proveedor_id','text','Proveedor Id',0,1,1,1,1,1,'{}',10),(221,18,'proveedor_id','hidden','Proveedor Id',0,1,1,1,1,1,'{}',10),(222,37,'production_semi_belongsto_producto_relationship','relationship','productos',0,1,1,1,1,1,'{\"model\":\"App\\\\ProductosSemiElaborado\",\"table\":\"productos\",\"type\":\"belongsTo\",\"column\":\"producto_semi_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"caja_users\",\"pivot\":\"0\",\"taggable\":\"0\"}',11),(223,39,'id','text','Id',1,1,1,0,0,0,'{}',1),(224,39,'title','text','Title',0,1,1,1,1,1,'{}',2),(225,39,'description','text','Description',0,0,1,1,1,1,'{}',3),(226,39,'editor_id','text','Editor Id',0,1,1,1,1,1,'{}',4),(227,39,'cantidad','text','Cantidad',0,1,1,1,1,1,'{}',5),(228,39,'costo','text','Costo',0,1,1,1,1,1,'{}',6),(229,39,'created_at','timestamp','Creado',0,1,1,0,0,0,'{}',7),(230,39,'updated_at','timestamp','Updated At',0,0,1,0,0,0,'{}',8),(231,39,'deleted_at','timestamp','Deleted At',0,0,1,0,0,0,'{}',9),(232,26,'image','text','Image',0,1,1,1,1,1,'{}',8),(233,26,'stock','text','Stock',0,1,1,1,1,1,'{}',9);
/*!40000 ALTER TABLE `data_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_types_name_unique` (`name`),
  UNIQUE KEY `data_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_types`
--

LOCK TABLES `data_types` WRITE;
/*!40000 ALTER TABLE `data_types` DISABLE KEYS */;
INSERT INTO `data_types` VALUES (1,'users','users','User','Users','voyager-person','TCG\\Voyager\\Models\\User','TCG\\Voyager\\Policies\\UserPolicy','TCG\\Voyager\\Http\\Controllers\\VoyagerUserController','',1,0,NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(2,'menus','menus','Menu','Menus','voyager-list','TCG\\Voyager\\Models\\Menu',NULL,'','',1,0,NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(3,'roles','roles','Role','Roles','voyager-lock','TCG\\Voyager\\Models\\Role',NULL,'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController','',1,0,NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(4,'categorias','categorias','Categoria','Categorias','voyager-tag','App\\Categoria',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}','2022-02-11 11:55:41','2022-02-15 23:09:46'),(5,'clientes','clientes','Cliente','Clientes','voyager-people','App\\Cliente',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"first_name\",\"scope\":null}','2022-02-11 11:55:55','2022-02-23 22:17:48'),(6,'productos','productos','Producto','Productos','voyager-basket','App\\Producto',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}','2022-02-11 11:56:21','2022-02-17 13:09:00'),(7,'sucursales','sucursales','Sucursal','Sucursales','voyager-shop','App\\Sucursale',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}','2022-02-11 11:56:57','2022-02-18 20:32:04'),(8,'ventas','ventas','Venta','Ventas','voyager-dollar','App\\Venta',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"id\",\"scope\":null}','2022-02-11 11:57:29','2022-02-23 20:30:47'),(9,'mensajeros','mensajeros','Mensajero','Mensajeros','voyager-truck','App\\Mensajero',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"statu\",\"scope\":null}','2022-02-15 20:38:50','2022-02-23 20:27:52'),(10,'cupones','cupones','Cupone','Cupones','voyager-gift','App\\Cupone',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"title\"}','2022-02-15 20:44:05','2022-02-15 20:44:05'),(11,'insumos','insumos','Insumo','Insumos','voyager-puzzle','App\\Insumo',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}','2022-02-15 20:49:24','2022-02-19 20:12:23'),(12,'productions','productions','Producción','Producciones','voyager-activity','App\\Production',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-15 20:50:05','2022-02-25 19:00:55'),(13,'options','options','Option','Options','voyager-pizza','App\\Option',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"title\"}','2022-02-15 21:29:37','2022-02-15 21:29:37'),(14,'pagos','pagos','Pago','Pagos','voyager-key','App\\Pago',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"title\"}','2022-02-15 21:50:16','2022-02-15 21:50:16'),(15,'unidades','unidades','Unidad','Unidades','voyager-milestone','App\\Unidade',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}','2022-02-15 22:42:17','2022-02-15 22:42:17'),(16,'cajas','cajas','Caja','Cajas',NULL,'App\\Caja',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":\"title\",\"scope\":null}','2022-02-18 21:07:53','2022-02-22 22:17:20'),(17,'detalle_ventas','detalle-ventas','Detalle Venta','Detalle Ventas','voyager-pizza','App\\DetalleVenta',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-20 18:53:52','2022-02-24 15:31:19'),(18,'production_insumos','production-insumos','Detalle Producto Elaborado','Insumos','voyager-window-list','App\\ProductionInsumo',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-20 20:33:15','2022-02-25 18:16:45'),(21,'estados','estados','Estado','Estados',NULL,'App\\Estado',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-20 23:38:44','2022-02-20 23:39:07'),(25,'proveedores','proveedores','Proveedor','Proveedores',NULL,'App\\Proveedore',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-23 21:29:23','2022-02-23 22:42:54'),(26,'productos_semi_elaborados','productos-semi-elaborados','Pre Elaborado','Pre Elaborados','voyager-helm','App\\ProductosSemiElaborado',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-23 22:27:07','2022-02-25 19:31:05'),(37,'production_semis','production-semis','Producción','Producciónes','voyager-helm','App\\ProductionSemi',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-24 18:39:45','2022-02-25 19:15:35'),(38,'detalle_production_semis','detalle-production-semis','Detalle Producto Semielaborado','Detalle Productos Semielaborados',NULL,'App\\DetalleProductionSemi',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-24 18:46:28','2022-02-25 11:41:57'),(39,'compras','compras','Compra','Compras','voyager-helm','App\\Compra',NULL,NULL,NULL,1,1,'{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}','2022-02-25 18:57:37','2022-02-25 18:58:17');
/*!40000 ALTER TABLE `data_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_cajas`
--

DROP TABLE IF EXISTS `detalle_cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_cajas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `monto_apertura` double DEFAULT NULL,
  `monto_cierre` double DEFAULT NULL,
  `detalle_apertura` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `detalle_cierre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_cajas`
--

LOCK TABLES `detalle_cajas` WRITE;
/*!40000 ALTER TABLE `detalle_cajas` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_production_semis`
--

DROP TABLE IF EXISTS `detalle_production_semis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_production_semis` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `production_semi_id` int DEFAULT NULL,
  `insumo_id` int DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `proveedor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_production_semis`
--

LOCK TABLES `detalle_production_semis` WRITE;
/*!40000 ALTER TABLE `detalle_production_semis` DISABLE KEYS */;
INSERT INTO `detalle_production_semis` VALUES (1,1,9,6,15,90,'2022-02-24 20:06:13','2022-02-24 20:06:13',NULL,3),(2,1,7,2,1,2,'2022-02-24 20:06:13','2022-02-24 20:06:13',NULL,2),(3,1,8,10,1,10,'2022-02-24 20:06:13','2022-02-24 20:06:13',NULL,3),(4,2,9,5,10,50,'2022-02-24 20:11:09','2022-02-24 20:11:09',NULL,2),(5,2,7,2,0.5,1,'2022-02-24 20:11:09','2022-02-24 20:11:09',NULL,2),(6,3,1,5,6,30,'2022-02-25 14:46:16','2022-02-25 14:46:16',NULL,1),(7,4,3,3,2,6,'2022-02-25 16:26:44','2022-02-25 16:26:44',NULL,3),(8,4,8,4,1,4,'2022-02-25 16:26:45','2022-02-25 16:26:45',NULL,8),(9,4,2,5,1,5,'2022-02-25 16:26:45','2022-02-25 16:26:45',NULL,2),(10,5,9,9,3,27,'2022-02-25 16:39:36','2022-02-25 16:39:36',NULL,3),(11,5,3,5,5,25,'2022-02-25 16:39:36','2022-02-25 16:39:36',NULL,2);
/*!40000 ALTER TABLE `detalle_production_semis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_ventas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `producto_id` int DEFAULT NULL,
  `venta_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ventas`
--

LOCK TABLES `detalle_ventas` WRITE;
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
INSERT INTO `detalle_ventas` VALUES (1,5,1,'2022-02-24 15:35:29','2022-02-24 15:35:29',NULL,15,1,15,'productos/February2022/CzmQCVkGvfgbiV1yXcMD.jpeg','Lomito'),(2,2,1,'2022-02-24 15:35:29','2022-02-24 15:35:29',NULL,35,1,35,'productos/February2022/0o07Oj8N6eSSdnVeYEM4.jpeg','Pipoca de Pollo - Familiar'),(3,17,1,'2022-02-24 15:35:29','2022-02-24 15:35:29',NULL,12,1,12,'productos/February2022/4FbNYnZlg1iu0aWqzNK1.png','Coca cola 2Lt'),(4,21,1,'2022-02-24 15:35:29','2022-02-24 15:35:29',NULL,12,1,12,'productos/February2022/neX5E6WnITVuqYicJFFu.jpeg','Sprite 2Lt');
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'Registrado','2022-02-20 23:41:49','2022-02-20 23:41:49',NULL),(2,'Cocina','2022-02-20 23:42:16','2022-02-20 23:42:16',NULL),(3,'Preparado','2022-02-20 23:42:24','2022-02-20 23:42:24',NULL),(4,'Delivery','2022-02-20 23:42:30','2022-02-20 23:42:30',NULL),(5,'Entregado','2022-02-20 23:42:38','2022-02-20 23:42:38',NULL),(6,'Cancelado','2022-02-20 23:42:46','2022-02-20 23:42:46',NULL);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insumos`
--

DROP TABLE IF EXISTS `insumos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `insumos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `unidad_id` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `costo` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumos`
--

LOCK TABLES `insumos` WRITE;
/*!40000 ALTER TABLE `insumos` DISABLE KEYS */;
INSERT INTO `insumos` VALUES (1,'Arroz','2022-02-15 22:46:00','2022-02-19 20:17:49',NULL,2,NULL,0),(2,'Lechuga','2022-02-16 00:22:00','2022-02-19 20:34:13',NULL,1,NULL,0),(3,'Papa','2022-02-16 15:07:00','2022-02-19 20:34:19',NULL,2,NULL,0),(4,'Papa','2022-02-16 15:08:00','2022-02-19 20:12:43',NULL,4,NULL,0),(5,'Arroz','2022-02-16 15:09:00','2022-02-19 20:12:36',NULL,4,NULL,0),(6,'Pollo','2022-02-16 15:10:00','2022-02-19 20:34:04',NULL,1,NULL,0),(7,'Sal','2022-02-16 15:11:00','2022-02-19 20:33:59',NULL,2,NULL,0),(8,'Aceite','2022-02-16 15:14:00','2022-02-19 20:33:55',NULL,3,NULL,0),(9,'Harina','2022-02-24 19:06:28','2022-02-24 19:06:28',NULL,2,NULL,0);
/*!40000 ALTER TABLE `insumos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajeros`
--

DROP TABLE IF EXISTS `mensajeros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensajeros` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajeros`
--

LOCK TABLES `mensajeros` WRITE;
/*!40000 ALTER TABLE `mensajeros` DISABLE KEYS */;
INSERT INTO `mensajeros` VALUES (1,NULL,NULL,NULL,'2022-02-23 20:28:22','2022-02-23 20:28:22',NULL,'Sin Delivery'),(2,'72312154',NULL,NULL,'2022-02-23 20:28:35','2022-02-23 20:28:35',NULL,'Go Delivery');
/*!40000 ALTER TABLE `mensajeros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (2,1,'Media','','_self','voyager-images',NULL,5,7,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.media.index',NULL),(3,1,'Users','','_self','voyager-person',NULL,5,6,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.users.index',NULL),(4,1,'Roles','','_self','voyager-lock',NULL,5,5,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.roles.index',NULL),(5,1,'Mas','','_self','voyager-tools','#000000',NULL,5,'2022-02-10 19:21:46','2022-02-25 19:43:38',NULL,''),(6,1,'Menu Builder','','_self','voyager-list',NULL,5,9,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.menus.index',NULL),(7,1,'Database','','_self','voyager-data',NULL,5,10,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.database.index',NULL),(8,1,'Compass','','_self','voyager-compass',NULL,5,11,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.compass.index',NULL),(9,1,'BREAD','','_self','voyager-bread',NULL,5,12,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.bread.index',NULL),(10,1,'Settings','','_self','voyager-settings',NULL,5,8,'2022-02-10 19:21:46','2022-02-25 19:43:38','voyager.settings.index',NULL),(13,1,'Productos','','_self','voyager-basket','#000000',NULL,2,'2022-02-11 11:56:21','2022-02-23 23:23:59','voyager.productos.index','null'),(15,1,'Ventas','','_self','voyager-dollar','#000000',NULL,1,'2022-02-11 11:57:29','2022-02-15 20:18:06','voyager.ventas.index','null'),(20,1,'Produccion','','_self','voyager-activity','#000000',NULL,4,'2022-02-15 20:50:05','2022-02-25 18:59:36','voyager.productions.index','null'),(21,1,'Visor Cocina','/cocina','_self','voyager-laptop','#000000',5,3,'2022-02-15 20:59:23','2022-02-25 19:43:38',NULL,''),(24,1,'Visor en Cola','/encola','_self','voyager-laptop','#000000',5,4,'2022-02-22 23:08:49','2022-02-25 19:43:38',NULL,''),(25,1,'Chat Bot','/admin/chatbot','_self','voyager-lightbulb','#000000',5,2,'2022-02-23 23:23:53','2022-02-25 19:43:38',NULL,''),(26,1,'Compras','','_self','voyager-helm','#000000',NULL,3,'2022-02-25 18:59:14','2022-02-25 18:59:36','voyager.compras.index',NULL),(27,1,'Metricas','#','_self','voyager-bar-chart','#000000',5,1,'2022-02-25 19:40:21','2022-02-25 19:43:38',NULL,'');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'admin','2022-02-10 19:21:46','2022-02-10 19:21:46');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_01_01_000000_add_voyager_user_fields',1),(4,'2016_01_01_000000_create_data_types_table',1),(5,'2016_05_19_173453_create_menu_table',1),(6,'2016_10_21_190000_create_roles_table',1),(7,'2016_10_21_190000_create_settings_table',1),(8,'2016_11_30_135954_create_permission_table',1),(9,'2016_11_30_141208_create_permission_role_table',1),(10,'2016_12_26_201236_data_types__add__server_side',1),(11,'2017_01_13_000000_add_route_to_menu_items_table',1),(12,'2017_01_14_005015_create_translations_table',1),(13,'2017_01_15_000000_make_table_name_nullable_in_permissions_table',1),(14,'2017_03_06_000000_add_controller_to_data_types_table',1),(15,'2017_04_21_000000_add_order_to_data_rows_table',1),(16,'2017_07_05_210000_add_policyname_to_data_types_table',1),(17,'2017_08_05_000000_add_group_to_settings_table',1),(18,'2017_11_26_013050_add_user_role_relationship',1),(19,'2017_11_26_015000_create_user_roles_table',1),(20,'2018_03_11_000000_add_user_settings',1),(21,'2018_03_14_000000_add_details_to_data_types_table',1),(22,'2018_03_16_000000_make_settings_value_nullable',1),(23,'2019_08_19_000000_create_failed_jobs_table',1),(24,'2019_12_14_000001_create_personal_access_tokens_table',1),(25,'2020_07_09_070051_create_pwa_settings_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,'En Mesa',NULL,'2022-02-15 21:30:11','2022-02-15 21:30:11',NULL);
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,'Efectivo',NULL,'2022-02-15 21:55:44','2022-02-15 21:55:44',NULL),(2,'Tarjeta',NULL,'2022-02-15 22:56:13','2022-02-15 22:56:13',NULL),(3,'Transferencia',NULL,'2022-02-16 12:44:42','2022-02-16 12:44:42',NULL);
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_role` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(1,3),(2,1),(3,1),(4,1),(4,3),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(26,3),(27,1),(27,3),(28,1),(28,3),(29,1),(29,3),(30,1),(31,1),(31,3),(32,1),(32,3),(33,1),(33,3),(34,1),(34,3),(35,1),(36,1),(36,3),(37,1),(37,3),(38,1),(38,3),(39,1),(39,3),(40,1),(41,1),(41,3),(42,1),(42,3),(43,1),(43,3),(44,1),(44,3),(45,1),(46,1),(46,3),(47,1),(48,1),(49,1),(49,3),(50,1),(51,1),(51,3),(52,1),(52,3),(53,1),(54,1),(55,1),(56,1),(56,3),(57,1),(57,3),(58,1),(58,3),(59,1),(59,3),(60,1),(61,1),(61,3),(62,1),(62,3),(63,1),(63,3),(64,1),(64,3),(65,1),(66,1),(66,3),(69,1),(69,3),(71,1),(71,3),(72,1),(72,3),(73,1),(73,3),(74,1),(74,3),(75,1),(76,1),(76,3),(77,1),(77,3),(78,1),(78,3),(79,1),(79,3),(80,1),(81,1),(81,3),(82,1),(82,3),(83,1),(83,3),(84,1),(84,3),(85,1),(86,1),(86,3),(87,1),(87,3),(88,1),(88,3),(89,1),(89,3),(90,1),(91,1),(91,3),(92,1),(93,1),(94,1),(95,1),(96,1),(96,3),(99,1),(111,1),(111,3),(112,1),(113,1),(114,1),(115,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(139,1),(166,1),(169,1),(171,1),(172,1),(173,1),(174,1),(175,1),(176,1),(177,1),(178,1),(179,1),(180,1);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_key_index` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'browse_admin',NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(2,'browse_bread',NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(3,'browse_database',NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(4,'browse_media',NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(5,'browse_compass',NULL,'2022-02-10 19:21:46','2022-02-10 19:21:46'),(6,'browse_menus','menus','2022-02-10 19:21:46','2022-02-10 19:21:46'),(7,'read_menus','menus','2022-02-10 19:21:46','2022-02-10 19:21:46'),(8,'edit_menus','menus','2022-02-10 19:21:46','2022-02-10 19:21:46'),(9,'add_menus','menus','2022-02-10 19:21:46','2022-02-10 19:21:46'),(10,'delete_menus','menus','2022-02-10 19:21:46','2022-02-10 19:21:46'),(11,'browse_roles','roles','2022-02-10 19:21:46','2022-02-10 19:21:46'),(12,'read_roles','roles','2022-02-10 19:21:46','2022-02-10 19:21:46'),(13,'edit_roles','roles','2022-02-10 19:21:46','2022-02-10 19:21:46'),(14,'add_roles','roles','2022-02-10 19:21:46','2022-02-10 19:21:46'),(15,'delete_roles','roles','2022-02-10 19:21:46','2022-02-10 19:21:46'),(16,'browse_users','users','2022-02-10 19:21:46','2022-02-10 19:21:46'),(17,'read_users','users','2022-02-10 19:21:46','2022-02-10 19:21:46'),(18,'edit_users','users','2022-02-10 19:21:46','2022-02-10 19:21:46'),(19,'add_users','users','2022-02-10 19:21:46','2022-02-10 19:21:46'),(20,'delete_users','users','2022-02-10 19:21:46','2022-02-10 19:21:46'),(21,'browse_settings','settings','2022-02-10 19:21:46','2022-02-10 19:21:46'),(22,'read_settings','settings','2022-02-10 19:21:46','2022-02-10 19:21:46'),(23,'edit_settings','settings','2022-02-10 19:21:46','2022-02-10 19:21:46'),(24,'add_settings','settings','2022-02-10 19:21:46','2022-02-10 19:21:46'),(25,'delete_settings','settings','2022-02-10 19:21:46','2022-02-10 19:21:46'),(26,'browse_categorias','categorias','2022-02-11 11:55:41','2022-02-11 11:55:41'),(27,'read_categorias','categorias','2022-02-11 11:55:41','2022-02-11 11:55:41'),(28,'edit_categorias','categorias','2022-02-11 11:55:41','2022-02-11 11:55:41'),(29,'add_categorias','categorias','2022-02-11 11:55:41','2022-02-11 11:55:41'),(30,'delete_categorias','categorias','2022-02-11 11:55:41','2022-02-11 11:55:41'),(31,'browse_clientes','clientes','2022-02-11 11:55:55','2022-02-11 11:55:55'),(32,'read_clientes','clientes','2022-02-11 11:55:55','2022-02-11 11:55:55'),(33,'edit_clientes','clientes','2022-02-11 11:55:55','2022-02-11 11:55:55'),(34,'add_clientes','clientes','2022-02-11 11:55:55','2022-02-11 11:55:55'),(35,'delete_clientes','clientes','2022-02-11 11:55:55','2022-02-11 11:55:55'),(36,'browse_productos','productos','2022-02-11 11:56:21','2022-02-11 11:56:21'),(37,'read_productos','productos','2022-02-11 11:56:21','2022-02-11 11:56:21'),(38,'edit_productos','productos','2022-02-11 11:56:21','2022-02-11 11:56:21'),(39,'add_productos','productos','2022-02-11 11:56:21','2022-02-11 11:56:21'),(40,'delete_productos','productos','2022-02-11 11:56:21','2022-02-11 11:56:21'),(41,'browse_sucursales','sucursales','2022-02-11 11:56:57','2022-02-11 11:56:57'),(42,'read_sucursales','sucursales','2022-02-11 11:56:57','2022-02-11 11:56:57'),(43,'edit_sucursales','sucursales','2022-02-11 11:56:57','2022-02-11 11:56:57'),(44,'add_sucursales','sucursales','2022-02-11 11:56:57','2022-02-11 11:56:57'),(45,'delete_sucursales','sucursales','2022-02-11 11:56:57','2022-02-11 11:56:57'),(46,'browse_ventas','ventas','2022-02-11 11:57:29','2022-02-11 11:57:29'),(47,'read_ventas','ventas','2022-02-11 11:57:29','2022-02-11 11:57:29'),(48,'edit_ventas','ventas','2022-02-11 11:57:29','2022-02-11 11:57:29'),(49,'add_ventas','ventas','2022-02-11 11:57:29','2022-02-11 11:57:29'),(50,'delete_ventas','ventas','2022-02-11 11:57:29','2022-02-11 11:57:29'),(51,'browse_mensajeros','mensajeros','2022-02-15 20:38:50','2022-02-15 20:38:50'),(52,'read_mensajeros','mensajeros','2022-02-15 20:38:50','2022-02-15 20:38:50'),(53,'edit_mensajeros','mensajeros','2022-02-15 20:38:50','2022-02-15 20:38:50'),(54,'add_mensajeros','mensajeros','2022-02-15 20:38:50','2022-02-15 20:38:50'),(55,'delete_mensajeros','mensajeros','2022-02-15 20:38:50','2022-02-15 20:38:50'),(56,'browse_cupones','cupones','2022-02-15 20:44:05','2022-02-15 20:44:05'),(57,'read_cupones','cupones','2022-02-15 20:44:05','2022-02-15 20:44:05'),(58,'edit_cupones','cupones','2022-02-15 20:44:05','2022-02-15 20:44:05'),(59,'add_cupones','cupones','2022-02-15 20:44:05','2022-02-15 20:44:05'),(60,'delete_cupones','cupones','2022-02-15 20:44:05','2022-02-15 20:44:05'),(61,'browse_insumos','insumos','2022-02-15 20:49:24','2022-02-15 20:49:24'),(62,'read_insumos','insumos','2022-02-15 20:49:24','2022-02-15 20:49:24'),(63,'edit_insumos','insumos','2022-02-15 20:49:24','2022-02-15 20:49:24'),(64,'add_insumos','insumos','2022-02-15 20:49:25','2022-02-15 20:49:25'),(65,'delete_insumos','insumos','2022-02-15 20:49:25','2022-02-15 20:49:25'),(66,'browse_productions','productions','2022-02-15 20:50:05','2022-02-15 20:50:05'),(67,'read_productions','productions','2022-02-15 20:50:05','2022-02-15 20:50:05'),(68,'edit_productions','productions','2022-02-15 20:50:05','2022-02-15 20:50:05'),(69,'add_productions','productions','2022-02-15 20:50:05','2022-02-15 20:50:05'),(70,'delete_productions','productions','2022-02-15 20:50:05','2022-02-15 20:50:05'),(71,'browse_options','options','2022-02-15 21:29:37','2022-02-15 21:29:37'),(72,'read_options','options','2022-02-15 21:29:37','2022-02-15 21:29:37'),(73,'edit_options','options','2022-02-15 21:29:37','2022-02-15 21:29:37'),(74,'add_options','options','2022-02-15 21:29:37','2022-02-15 21:29:37'),(75,'delete_options','options','2022-02-15 21:29:37','2022-02-15 21:29:37'),(76,'browse_pagos','pagos','2022-02-15 21:50:16','2022-02-15 21:50:16'),(77,'read_pagos','pagos','2022-02-15 21:50:16','2022-02-15 21:50:16'),(78,'edit_pagos','pagos','2022-02-15 21:50:16','2022-02-15 21:50:16'),(79,'add_pagos','pagos','2022-02-15 21:50:16','2022-02-15 21:50:16'),(80,'delete_pagos','pagos','2022-02-15 21:50:16','2022-02-15 21:50:16'),(81,'browse_unidades','unidades','2022-02-15 22:42:17','2022-02-15 22:42:17'),(82,'read_unidades','unidades','2022-02-15 22:42:17','2022-02-15 22:42:17'),(83,'edit_unidades','unidades','2022-02-15 22:42:17','2022-02-15 22:42:17'),(84,'add_unidades','unidades','2022-02-15 22:42:17','2022-02-15 22:42:17'),(85,'delete_unidades','unidades','2022-02-15 22:42:17','2022-02-15 22:42:17'),(86,'browse_cajas','cajas','2022-02-18 21:07:53','2022-02-18 21:07:53'),(87,'read_cajas','cajas','2022-02-18 21:07:53','2022-02-18 21:07:53'),(88,'edit_cajas','cajas','2022-02-18 21:07:53','2022-02-18 21:07:53'),(89,'add_cajas','cajas','2022-02-18 21:07:53','2022-02-18 21:07:53'),(90,'delete_cajas','cajas','2022-02-18 21:07:53','2022-02-18 21:07:53'),(91,'browse_detalle_ventas','detalle_ventas','2022-02-20 18:53:52','2022-02-20 18:53:52'),(92,'read_detalle_ventas','detalle_ventas','2022-02-20 18:53:52','2022-02-20 18:53:52'),(93,'edit_detalle_ventas','detalle_ventas','2022-02-20 18:53:52','2022-02-20 18:53:52'),(94,'add_detalle_ventas','detalle_ventas','2022-02-20 18:53:52','2022-02-20 18:53:52'),(95,'delete_detalle_ventas','detalle_ventas','2022-02-20 18:53:52','2022-02-20 18:53:52'),(96,'browse_production_insumos','production_insumos','2022-02-20 20:33:15','2022-02-20 20:33:15'),(97,'read_production_insumos','production_insumos','2022-02-20 20:33:15','2022-02-20 20:33:15'),(98,'edit_production_insumos','production_insumos','2022-02-20 20:33:15','2022-02-20 20:33:15'),(99,'add_production_insumos','production_insumos','2022-02-20 20:33:15','2022-02-20 20:33:15'),(100,'delete_production_insumos','production_insumos','2022-02-20 20:33:15','2022-02-20 20:33:15'),(111,'browse_estados','estados','2022-02-20 23:38:44','2022-02-20 23:38:44'),(112,'read_estados','estados','2022-02-20 23:38:44','2022-02-20 23:38:44'),(113,'edit_estados','estados','2022-02-20 23:38:44','2022-02-20 23:38:44'),(114,'add_estados','estados','2022-02-20 23:38:44','2022-02-20 23:38:44'),(115,'delete_estados','estados','2022-02-20 23:38:44','2022-02-20 23:38:44'),(131,'browse_proveedores','proveedores','2022-02-23 21:29:23','2022-02-23 21:29:23'),(132,'read_proveedores','proveedores','2022-02-23 21:29:23','2022-02-23 21:29:23'),(133,'edit_proveedores','proveedores','2022-02-23 21:29:23','2022-02-23 21:29:23'),(134,'add_proveedores','proveedores','2022-02-23 21:29:23','2022-02-23 21:29:23'),(135,'delete_proveedores','proveedores','2022-02-23 21:29:23','2022-02-23 21:29:23'),(136,'browse_productos_semi_elaborados','productos_semi_elaborados','2022-02-23 22:27:07','2022-02-23 22:27:07'),(137,'read_productos_semi_elaborados','productos_semi_elaborados','2022-02-23 22:27:07','2022-02-23 22:27:07'),(138,'edit_productos_semi_elaborados','productos_semi_elaborados','2022-02-23 22:27:07','2022-02-23 22:27:07'),(139,'add_productos_semi_elaborados','productos_semi_elaborados','2022-02-23 22:27:07','2022-02-23 22:27:07'),(140,'delete_productos_semi_elaborados','productos_semi_elaborados','2022-02-23 22:27:07','2022-02-23 22:27:07'),(166,'browse_production_semis','production_semis','2022-02-24 18:39:45','2022-02-24 18:39:45'),(167,'read_production_semis','production_semis','2022-02-24 18:39:45','2022-02-24 18:39:45'),(168,'edit_production_semis','production_semis','2022-02-24 18:39:45','2022-02-24 18:39:45'),(169,'add_production_semis','production_semis','2022-02-24 18:39:45','2022-02-24 18:39:45'),(170,'delete_production_semis','production_semis','2022-02-24 18:39:45','2022-02-24 18:39:45'),(171,'browse_detalle_production_semis','detalle_production_semis','2022-02-24 18:46:28','2022-02-24 18:46:28'),(172,'read_detalle_production_semis','detalle_production_semis','2022-02-24 18:46:28','2022-02-24 18:46:28'),(173,'edit_detalle_production_semis','detalle_production_semis','2022-02-24 18:46:28','2022-02-24 18:46:28'),(174,'add_detalle_production_semis','detalle_production_semis','2022-02-24 18:46:28','2022-02-24 18:46:28'),(175,'delete_detalle_production_semis','detalle_production_semis','2022-02-24 18:46:28','2022-02-24 18:46:28'),(176,'browse_compras','compras','2022-02-25 18:57:37','2022-02-25 18:57:37'),(177,'read_compras','compras','2022-02-25 18:57:37','2022-02-25 18:57:37'),(178,'edit_compras','compras','2022-02-25 18:57:37','2022-02-25 18:57:37'),(179,'add_compras','compras','2022-02-25 18:57:37','2022-02-25 18:57:37'),(180,'delete_compras','compras','2022-02-25 18:57:37','2022-02-25 18:57:37');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_insumos`
--

DROP TABLE IF EXISTS `production_insumos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `production_insumos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `production_id` int DEFAULT NULL,
  `insumo_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `proveedor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_insumos`
--

LOCK TABLES `production_insumos` WRITE;
/*!40000 ALTER TABLE `production_insumos` DISABLE KEYS */;
INSERT INTO `production_insumos` VALUES (3,6,5,'2022-02-20 20:49:49','2022-02-20 20:49:49',NULL,30,1,30,3),(4,6,2,'2022-02-20 20:49:49','2022-02-20 20:49:49',NULL,6,1,6,2),(5,7,8,'2022-02-20 20:51:10','2022-02-20 20:51:10',NULL,10,1,10,3),(6,7,7,'2022-02-20 20:51:10','2022-02-20 20:51:10',NULL,2,3,6,3),(7,13,1,'2022-02-25 16:48:59','2022-02-25 16:48:59',NULL,4,5,20,1),(8,13,5,'2022-02-25 16:48:59','2022-02-25 16:48:59',NULL,4,7,28,2),(9,15,6,'2022-02-25 16:51:04','2022-02-25 16:51:04',NULL,5,4,20,2),(10,12,2,'2022-02-25 18:04:35','2022-02-25 18:04:35',NULL,0,1,0,1);
/*!40000 ALTER TABLE `production_insumos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_semis`
--

DROP TABLE IF EXISTS `production_semis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `production_semis` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `producto_semi_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_semis`
--

LOCK TABLES `production_semis` WRITE;
/*!40000 ALTER TABLE `production_semis` DISABLE KEYS */;
INSERT INTO `production_semis` VALUES (1,0,1,0,102,'','2022-02-24 20:06:13','2022-02-24 20:06:13',NULL),(2,1,1,20,51,'prueba','2022-02-24 20:11:09','2022-02-24 20:11:09',NULL),(3,2,1,20,30,'Prueba','2022-02-25 14:46:16','2022-02-25 14:46:16',NULL),(4,3,1,1,15,'prueba','2022-02-25 16:26:44','2022-02-25 16:26:44',NULL),(5,2,1,10,52,'prurba 3','2022-02-25 16:39:36','2022-02-25 16:39:36',NULL);
/*!40000 ALTER TABLE `production_semis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productions`
--

DROP TABLE IF EXISTS `productions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `producto_id` int DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `valor` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productions`
--

LOCK TABLES `productions` WRITE;
/*!40000 ALTER TABLE `productions` DISABLE KEYS */;
INSERT INTO `productions` VALUES (6,'2022-02-20 20:49:49','2022-02-20 20:49:49',NULL,'Prueba Production',1,4,20,36),(7,'2022-02-20 20:51:10','2022-02-20 20:51:10',NULL,'Prueba 2',1,5,21,16),(8,'2022-02-25 16:10:43','2022-02-25 16:10:43',NULL,'prueba proveedor',1,1,20,164),(9,'2022-02-25 16:18:37','2022-02-25 16:18:37',NULL,'',1,0,0,49),(10,'2022-02-25 16:30:39','2022-02-25 16:30:39',NULL,'prueba',1,5,10,75),(11,'2022-02-25 16:40:56','2022-02-25 16:40:56',NULL,'prueba 3',1,3,15,32),(12,'2022-02-25 16:45:54','2022-02-25 16:45:54',NULL,'',1,0,0,0),(13,'2022-02-25 16:48:59','2022-02-25 16:48:59',NULL,'prueba4',1,4,32,48),(14,'2022-02-25 16:50:58','2022-02-25 16:50:58',NULL,'',1,1,10,60),(15,'2022-02-25 16:51:03','2022-02-25 16:51:03',NULL,'prueba4',1,8,23,20);
/*!40000 ALTER TABLE `productions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sucursal_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Pipoca de Pollo Personal','1',NULL,'productos/February2022/ez3Y3ZXJlp4xjpquS5T6.jpeg',25,NULL,'2022-02-15 20:28:00','2022-02-17 13:13:15',NULL,1),(2,'Pipoca de Pollo - Familiar','1',NULL,'productos/February2022/0o07Oj8N6eSSdnVeYEM4.jpeg',35,NULL,'2022-02-15 20:35:34','2022-02-17 13:14:45',NULL,1),(3,'Pollo Broaster - Cuarto Pecho','1',NULL,'productos/February2022/AbfnkeBtn5Glxd3meiL4.jpeg',25,NULL,'2022-02-15 20:39:41','2022-02-17 13:13:29',NULL,1),(4,'Keperi','1',NULL,'productos/February2022/nKknxg5jEOlE13xwaVQv.jpeg',15,NULL,'2022-02-15 20:43:00','2022-02-17 13:28:43',NULL,1),(5,'Lomito','1',NULL,'productos/February2022/CzmQCVkGvfgbiV1yXcMD.jpeg',15,NULL,'2022-02-15 20:43:08','2022-02-17 13:29:03',NULL,1),(6,'Charque Personal','1',NULL,'productos/February2022/rgaEs8R3f4zpyEY2ybGz.jpeg',15,NULL,'2022-02-15 20:44:09','2022-02-17 13:33:10',NULL,1),(7,'Charque p/2','1',NULL,'productos/February2022/FYSvVFlRjr4aPfX89kjg.jpeg',25,NULL,'2022-02-15 20:59:14','2022-02-17 13:32:51',NULL,1),(8,'Pollo Broaster - Cuarto Pierna','1',NULL,'productos/February2022/Ywo5VjE9er6TNEcb2K5e.jpeg',25,NULL,'2022-02-15 22:43:51','2022-02-17 13:27:44',NULL,1),(9,'Pollo Broaster - Economico Pecho','1',NULL,'productos/February2022/mYtwXpQgyJBlNkCOz2vF.jpeg',15,NULL,'2022-02-15 22:44:53','2022-02-17 13:27:29',NULL,1),(10,'Pollo Broaster - Economico Ala','1',NULL,'productos/February2022/U7GWrmi3RQlMC1uifuu5.jpeg',15,NULL,'2022-02-15 22:45:59','2022-02-17 13:27:15',NULL,1),(11,'Pollo Broaster - Economico Pierna','1',NULL,'productos/February2022/5u8lo0bHNzSxqIL75yEa.jpeg',13,NULL,'2022-02-15 22:47:10','2022-02-17 13:26:54',NULL,1),(12,'Pollo Broaster - Economico Entrepierna','1',NULL,'productos/February2022/xUQTe6k4X7oPwqQWHQGq.jpeg',13,NULL,'2022-02-15 22:54:51','2022-02-17 13:26:36',NULL,1),(13,'Porción de Arroz','3',NULL,'productos/February2022/z32YEAbbb6YfsN0bXCXu.jpeg',5,NULL,'2022-02-15 23:21:36','2022-02-17 13:26:17',NULL,1),(14,'Porción de Yuca Frita','3',NULL,'productos/February2022/tqxAfog5HShMLouseIMv.jpeg',7,NULL,'2022-02-16 12:28:04','2022-02-17 13:26:02',NULL,1),(15,'Porción de Yuca Hervida','3',NULL,'productos/February2022/aAEdpQQgmo6Dz7zqz0h2.jpeg',7,NULL,'2022-02-16 12:29:32','2022-02-17 13:25:41',NULL,1),(16,'Porción de Papa Frita','3',NULL,'productos/February2022/e8Y13Wgu9mkF51kbjxEV.jpeg',6,NULL,'2022-02-16 12:30:19','2022-02-17 13:25:17',NULL,1),(17,'Coca cola 2Lt','2',NULL,'productos/February2022/4FbNYnZlg1iu0aWqzNK1.png',12,NULL,'2022-02-16 12:39:54','2022-02-17 13:24:57',NULL,1),(18,'Coca cola 1Lt','2',NULL,'productos/February2022/MsKh8bzc3f4Vtoualefo.jpeg',10,NULL,'2022-02-16 12:40:50','2022-02-17 13:24:42',NULL,1),(19,'Fanta 2Lt','2',NULL,'productos/February2022/YV7ZMjej433vNGJzOb6U.jpeg',12,NULL,'2022-02-16 12:41:45','2022-02-17 13:24:29',NULL,1),(20,'Fanta 1Lt','2',NULL,'productos/February2022/A5I4tP19cS5LJeR4JfxM.jpeg',10,NULL,'2022-02-16 12:42:09','2022-02-17 13:24:12',NULL,1),(21,'Sprite 2Lt','2',NULL,'productos/February2022/neX5E6WnITVuqYicJFFu.jpeg',12,NULL,'2022-02-16 12:42:44','2022-02-17 13:23:50',NULL,1),(22,'Sprite 1Lt','2',NULL,'productos/February2022/QgH3GgKQcTOWJylTTnb9.jpeg',10,NULL,'2022-02-16 12:43:08','2022-02-17 13:16:28',NULL,1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_semi_elaborados`
--

DROP TABLE IF EXISTS `productos_semi_elaborados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_semi_elaborados` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `costo` double DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_semi_elaborados`
--

LOCK TABLES `productos_semi_elaborados` WRITE;
/*!40000 ALTER TABLE `productos_semi_elaborados` DISABLE KEYS */;
INSERT INTO `productos_semi_elaborados` VALUES (1,'Masa Pizza Mediana',NULL,'2022-02-24 12:12:44','2022-02-24 12:36:35',NULL,0,NULL,NULL),(2,'Masa Pizza Grande',NULL,'2022-02-24 12:12:59','2022-02-24 12:12:00',NULL,0,NULL,NULL),(3,'Salsa Tatu',NULL,'2022-02-24 12:36:03','2022-02-24 12:36:27',NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `productos_semi_elaborados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'Proveedor 1',NULL,NULL,'2022-02-24 14:17:14','2022-02-24 14:17:14',NULL),(2,'Proveedor 2',NULL,NULL,'2022-02-24 14:17:39','2022-02-24 14:17:39',NULL),(3,'Proveedor 3',NULL,NULL,'2022-02-24 14:18:40','2022-02-24 14:18:40',NULL);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pwa_settings`
--

DROP TABLE IF EXISTS `pwa_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pwa_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenant_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` json DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pwa_settings`
--

LOCK TABLES `pwa_settings` WRITE;
/*!40000 ALTER TABLE `pwa_settings` DISABLE KEYS */;
INSERT INTO `pwa_settings` VALUES (3,'lamarea.loginweb.dev',NULL,'{\"name\": \"Point of Sale\", \"manifest\": {\"name\": \"Point of Sale\", \"icons\": {\"72x72\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-72x72.png\", \"purpose\": \"any\"}, \"96x96\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-96x96.png\", \"purpose\": \"any\"}, \"128x128\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-128x128.png\", \"purpose\": \"any\"}, \"144x144\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-144x144.png\", \"purpose\": \"any\"}, \"152x152\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-152x152.png\", \"purpose\": \"any\"}, \"192x192\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-192x192.png\", \"purpose\": \"any\"}, \"384x384\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-384x384.png\", \"purpose\": \"any\"}, \"512x512\": {\"path\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-512x512.png\", \"purpose\": \"any\"}}, \"custom\": [], \"splash\": {\"640x1136\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-640x1136.png\", \"750x1334\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-750x1334.png\", \"828x1792\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-828x1792.png\", \"1125x2436\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-1125x2436.png\", \"1242x2208\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-1242x2208.png\", \"1242x2688\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-1242x2688.png\", \"1536x2048\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-1536x2048.png\", \"1668x2224\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-1668x2224.png\", \"1668x2388\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-1668x2388.png\", \"2048x2732\": \"https://lamarea.loginweb.dev/pwa/assets/images/icons/splash-2048x2732.png\"}, \"display\": \"standalone\", \"shortcuts\": [], \"start_url\": \"https://lamarea.loginweb.dev/\", \"short_name\": \"pos\", \"status_bar\": \"black\", \"orientation\": \"any\", \"theme_color\": \"#000000\", \"background_color\": \"#ffffff\"}, \"serviceworker\": \"        var staticCacheName = \\\"pwa-v\\\" + new Date().getTime();\\n        var filesToCache = [\\n            \'https://lamarea.loginweb.dev/offline\',\\n            \'https://lamarea.loginweb.dev/css/app.css\',\\n            \'https://lamarea.loginweb.dev/js/app.js\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-72x72.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-96x96.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-128x128.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-144x144.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-152x152.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-192x192.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-384x384.png\',\\n            \'https://lamarea.loginweb.dev/pwa/assets/images/icons/icon-512x512.png\',\\n        ];\\n\\n        // Cache on install\\n        self.addEventListener(\\\"install\\\", event => {\\n            this.skipWaiting();\\n            event.waitUntil(\\n                caches.open(staticCacheName)\\n                    .then(cache => {\\n                        return cache.addAll(filesToCache);\\n                    })\\n            )\\n        });\\n\\n        // Clear cache on activate\\n        self.addEventListener(\'activate\', event => {\\n            event.waitUntil(\\n                caches.keys().then(cacheNames => {\\n                    return Promise.all(\\n                        cacheNames\\n                            .filter(cacheName => (cacheName.startsWith(\\\"pwa-\\\")))\\n                            .filter(cacheName => (cacheName !== staticCacheName))\\n                            .map(cacheName => caches.delete(cacheName))\\n                    );\\n                })\\n            );\\n        });\\n\\n        // Serve from Cache\\n        self.addEventListener(\\\"fetch\\\", event => {\\n            event.respondWith(\\n                caches.match(event.request)\\n                    .then(response => {\\n                        return response || fetch(event.request);\\n                    })\\n                    .catch(() => {\\n                        return caches.match(\'offline\');\\n                    })\\n            )\\n        });\", \"register_serviceworker\": \"            // Get serviceworker contents\\n            var serviceworker = \\\"https://lamarea.loginweb.dev/serviceworker\\\";\\n            // Initialize the service worker\\n            if (\'serviceWorker\' in navigator) {\\n                navigator.serviceWorker.register(serviceworker, {\\n                    scope: \'.\'\\n                }).then(function (registration) {\\n                    // Registration was successful\\n                    console.log(\'Laravel PWA enable successfully. Enjoy it!\');\\n                }, function (err) {\\n                    // registration failed\\n                    console.log(\'Laravel PWA registration failed. Please check the error: \', err);\\n                });\\n            }\"}',1,'2022-02-22 21:36:47','2022-02-22 21:45:02');
/*!40000 ALTER TABLE `pwa_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrator','2022-02-10 19:21:46','2022-02-10 19:21:46'),(2,'user','Normal User','2022-02-10 19:21:46','2022-02-10 19:21:46'),(3,'Cajero','Cajero - POS','2022-02-15 20:11:24','2022-02-15 20:11:24');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site.title','Site Title','Site Title','','text',1,'Site'),(2,'site.description','Site Description','Site Description','','text',2,'Site'),(3,'site.logo','Site Logo','','','image',3,'Site'),(4,'site.google_analytics_tracking_id','Google Analytics Tracking ID',NULL,'','text',4,'Site'),(5,'admin.bg_image','Admin Background Image','','','image',5,'Admin'),(6,'admin.title','Admin Title','POS','','text',1,'Admin'),(7,'admin.description','Admin Description','Software de ventas - POS','','text',2,'Admin'),(8,'admin.loader','Admin Loader','','','image',3,'Admin'),(9,'admin.icon_image','Admin Icon Image','','','image',4,'Admin'),(10,'admin.google_analytics_client_id','Google Analytics Client ID (used for admin dashboard)',NULL,'','text',1,'Admin');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursal_users`
--

DROP TABLE IF EXISTS `sucursal_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sucursal_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sucursal_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursal_users`
--

LOCK TABLES `sucursal_users` WRITE;
/*!40000 ALTER TABLE `sucursal_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `sucursal_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sucursales` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursales`
--

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` VALUES (1,'Tienda Principal',NULL,NULL,NULL,'2022-02-15 23:24:12','2022-02-15 23:24:12',NULL);
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int unsigned NOT NULL,
  `locale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidades` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (1,'PZA','Insumo por Pieza un 1 kl','2022-02-15 22:45:53','2022-02-16 00:18:58',NULL),(2,'Kg',NULL,'2022-02-16 15:04:06','2022-02-16 15:04:06',NULL),(3,'Lt',NULL,'2022-02-16 15:04:12','2022-02-16 15:04:12',NULL),(4,'@',NULL,'2022-02-16 15:08:08','2022-02-16 15:08:08',NULL);
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`),
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (3,3);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin','admin@admin.com','users/default.png',NULL,'$2y$10$oEC0ImXzmiJBibFLNbxmCeU1h/z/KQ2EBoRgtVRoMnC97VkVZpthy',NULL,NULL,'2022-02-10 19:24:43','2022-02-10 19:24:43'),(2,3,'jchavez','jchavez@loginweb.dev','users/default.png',NULL,'$2y$10$yqyiEuxY2viWNd8Av/yI..YpixrEYreH6iFwF6G3pntF6oLz/xOeC','oADwicqsS1ivU9ifpPMd96Sxqh5MvhdmSqTpanCgC1ql42MzbOlrNyALEMWJ','{\"locale\":\"es\"}','2022-02-15 20:15:48','2022-02-15 20:15:48'),(3,NULL,'Tito Deiby','tito.deiby@loginweb.dev','users/default.png',NULL,'$2y$10$Vm9RsFTljQStCXPXVYV2zeEU0L9i.1qAvog48j9nZKHnGikzBa9lW','m2GNNcysrSqjCeQG1VsLA6hrF23anYnfkQRYxslDDV7WMDXwFucym02joATv','{\"locale\":\"es\"}','2022-02-15 20:26:34','2022-02-15 20:32:01');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `observacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cupon_id` int DEFAULT NULL,
  `descuento` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `option_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pago_id` int DEFAULT NULL,
  `factura` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_id` int DEFAULT NULL,
  `status_id` int DEFAULT NULL,
  `ticket` int DEFAULT NULL,
  `caja_id` int DEFAULT NULL,
  `caja_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,1,'',1,0,99,'2022-02-24 15:35:29','2022-02-24 15:35:29',NULL,'Mesa',1,'Recibo',2,1,NULL,4,'0',1);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-26 17:08:02
