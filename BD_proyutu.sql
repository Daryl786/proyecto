/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: proyutu
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

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
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
INSERT INTO `Categories` VALUES
(1,'Programacion',NULL,'2025-10-30 19:57:06'),
(2,'Desarrollo Web',NULL,'2025-10-30 19:57:06'),
(3,'Bases de Datos',NULL,'2025-10-30 19:57:06'),
(4,'Inteligencia Artificial',NULL,'2025-10-30 19:57:06'),
(5,'Ciberseguridad',NULL,'2025-10-30 19:57:06'),
(6,'DevOps',NULL,'2025-10-30 19:57:06'),
(7,'Cloud Computing',NULL,'2025-10-30 19:57:06'),
(8,'Marketing Digital',NULL,'2025-10-30 19:57:06'),
(9,'Diseño UX/UI',NULL,'2025-10-30 19:57:06'),
(10,'Emprendimiento',NULL,'2025-10-30 19:57:06'),
(11,'Ciencia de Datos',NULL,'2025-10-30 19:57:06'),
(12,'Machine Learning',NULL,'2025-10-30 19:57:06'),
(13,'Realidad Virtual',NULL,'2025-10-30 19:57:06'),
(14,'Blockchain',NULL,'2025-10-30 19:57:06'),
(15,'Big Data',NULL,'2025-10-30 19:57:06'),
(16,'Desarrollo Movil',NULL,'2025-10-30 19:57:06'),
(17,'Frontend',NULL,'2025-10-30 19:57:06'),
(18,'Backend',NULL,'2025-10-30 19:57:06'),
(19,'Testing de Software',NULL,'2025-10-30 19:57:06'),
(20,'Automatizacion',NULL,'2025-10-30 19:57:06'),
(21,'Internet de las Cosas',NULL,'2025-10-30 19:57:06'),
(22,'Gaming',NULL,'2025-10-30 19:57:06'),
(23,'limpiezaaaaa','sirve pa limpia ysi','2025-10-30 19:58:35');
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`post_id`),
  CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` VALUES
(1,1,2,'¡Excelente introducción! Muy claro para principiantes.','2023-02-01 14:00:00'),
(2,1,NULL,'¿Hay algún recurso para practicar los conceptos?','2023-02-01 15:00:00'),
(3,2,1,'Siempre me confundo con Grid y Flexbox, ¡esto ayuda mucho!','2023-02-03 18:00:00'),
(4,3,4,'La normalización es clave, buen recordatorio.','2023-02-05 13:00:00'),
(5,4,5,'Interesante, probaré Scikit-learn este fin de semana.','2023-02-07 15:00:00'),
(8,7,8,'AWS EC2 es un buen punto de partida para la nube.','2023-02-13 17:00:00'),
(9,8,9,'No había pensado en el SEO desde el código, ¡buen post!','2023-02-15 13:00:00'),
(10,9,10,'Los principios UX son fundamentales para cualquier producto.','2023-02-17 19:00:00'),
(11,10,1,'Emprender es un desafío, pero posts como este inspiran.','2023-02-19 15:00:00'),
(12,11,3,'POO en Java es la base, bien explicado.','2023-02-21 14:00:00'),
(13,12,4,'React Hooks simplifican mucho el desarrollo, ¡me encantan!','2023-02-23 18:00:00'),
(14,13,5,'Las JOINs siempre son un dolor de cabeza, pero este post ayuda.','2023-02-25 13:30:00'),
(16,15,7,'Seguridad es lo primero, gracias por los consejos.','2023-03-01 20:00:00'),
(17,16,8,'Jenkins es robusto, lo usamos en mi empresa.','2023-03-03 14:15:00'),
(18,17,9,'Serverless es el futuro, ¡muy interesante!','2023-03-05 17:45:00'),
(19,18,10,'El email marketing sigue siendo muy efectivo.','2023-03-07 13:40:00'),
(20,19,11,'Figma es una herramienta increíble para prototipar.','2023-03-09 19:30:00'),
(21,20,12,'Automatización con Python me ha ahorrado mucho tiempo.','2023-04-01 15:45:00'),
(22,21,13,'Pandas es una joya para el análisis de datos.','2023-03-13 14:00:00'),
(23,22,NULL,'¿Qué otros frameworks de Deep Learning recomiendan?','2023-03-15 18:30:00'),
(24,23,14,'Unity es muy potente para VR.','2023-03-17 13:15:00'),
(25,24,15,'Blockchain es complejo, pero este post lo hace más claro.','2023-03-19 15:00:00'),
(26,25,16,'Big Data es un campo con mucho futuro.','2023-03-21 20:45:00');
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Contrataciones`
--

DROP TABLE IF EXISTS `Contrataciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Contrataciones` (
  `contratacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha_contratacion` timestamp NULL DEFAULT current_timestamp(),
  `fecha_finalizacion` datetime DEFAULT NULL,
  `estado` enum('activo','finalizado','cancelado') DEFAULT 'activo',
  `notas` text DEFAULT NULL,
  PRIMARY KEY (`contratacion_id`),
  KEY `idx_post` (`post_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha_finalizacion` (`fecha_finalizacion`),
  KEY `idx_user_estado` (`user_id`,`estado`),
  CONSTRAINT `Contrataciones_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`post_id`) ON DELETE CASCADE,
  CONSTRAINT `Contrataciones_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contrataciones`
--

LOCK TABLES `Contrataciones` WRITE;
/*!40000 ALTER TABLE `Contrataciones` DISABLE KEYS */;
INSERT INTO `Contrataciones` VALUES
(1,31,26,'2025-10-30 20:37:24','2025-11-13 20:37:24','activo',NULL);
/*!40000 ALTER TABLE `Contrataciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PostTags`
--

DROP TABLE IF EXISTS `PostTags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PostTags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `PostTags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`post_id`),
  CONSTRAINT `PostTags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `Tags` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PostTags`
--

LOCK TABLES `PostTags` WRITE;
/*!40000 ALTER TABLE `PostTags` DISABLE KEYS */;
INSERT INTO `PostTags` VALUES
(1,1),
(1,27),
(2,4),
(2,24),
(3,3),
(3,19),
(4,13),
(4,19),
(5,14),
(7,9),
(7,16),
(8,10),
(8,24),
(9,11),
(9,12),
(10,18),
(11,1),
(12,6),
(12,24),
(13,3),
(14,20),
(15,14),
(16,15),
(17,9),
(17,16),
(18,17),
(19,11),
(20,1),
(20,27),
(21,1),
(21,19),
(22,20),
(23,28),
(24,21),
(25,22),
(27,6),
(27,24),
(28,7),
(28,25),
(29,2),
(29,26);
/*!40000 ALTER TABLE `PostTags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Posts`
--

DROP TABLE IF EXISTS `Posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `duracion` varchar(100) DEFAULT NULL,
  `nombre_empresa` varchar(200) DEFAULT NULL,
  `empresa` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `Posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `Posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Posts`
--

LOCK TABLES `Posts` WRITE;
/*!40000 ALTER TABLE `Posts` DISABLE KEYS */;
INSERT INTO `Posts` VALUES
(1,1,1,'Introducción a Python para Principiantes','Descubre los fundamentos de Python y por qué es ideal para empezar en la programación.',0.00,'A definir','',NULL,'2023-02-01 13:00:00','2025-10-13 20:45:43'),
(2,2,2,'CSS Grid vs Flexbox: ¿Cuál usar y cuándo?','Una guía completa para entender las diferencias y aplicaciones de CSS Grid y Flexbox.',0.00,'A definir','',NULL,'2023-02-03 17:30:00','2025-10-13 20:45:43'),
(3,3,3,'Normalización de Bases de Datos: Conceptos Clave','Exploramos las formas normales y su importancia en el diseño de bases de datos relacionales.',0.00,'A definir','',NULL,'2023-02-05 12:15:00','2025-10-13 20:45:43'),
(4,4,4,'Machine Learning con Scikit-learn: Un Primer Acercamiento','Cómo construir tu primer modelo de Machine Learning usando la librería Scikit-learn.',0.00,'A definir','',NULL,'2023-02-07 14:00:00','2025-10-13 20:45:43'),
(5,5,5,'Protegiendo tu Aplicación Web: Medidas Básicas de Seguridad','Consejos esenciales para proteger tu aplicación de ataques comunes.',0.00,'A definir','',NULL,'2023-02-09 19:45:00','2025-10-13 20:45:43'),
(7,7,7,'Despliegue en la Nube: AWS EC2 para Principiantes','Pasos para desplegar tu primera aplicación en una instancia EC2 de AWS.',0.00,'A definir','',NULL,'2023-02-13 16:00:00','2025-10-13 20:45:43'),
(8,8,8,'SEO para Desarrolladores: Optimizando tu Código','Cómo el código que escribes puede influir en el SEO de tu sitio web.',0.00,'A definir','',NULL,'2023-02-15 12:00:00','2025-10-13 20:45:43'),
(9,9,9,'Principios de Diseño UX: Creando Experiencias Intuitivas','Descubre los principios fundamentales del diseño de experiencia de usuario.',0.00,'A definir','',NULL,'2023-02-17 18:00:00','2025-10-13 20:45:43'),
(10,10,10,'De la Idea al Producto: Pasos para Emprender en Tech','Una guía para convertir tu idea en un producto tecnológico exitoso.',0.00,'A definir','',NULL,'2023-02-19 14:45:00','2025-10-13 20:45:43'),
(11,11,1,'Programación Orientada a Objetos en Java','Conceptos esenciales de POO aplicados en Java.',0.00,'A definir','',NULL,'2023-02-21 13:00:00','2025-10-13 20:45:43'),
(12,12,2,'React Hooks: Simplificando el Estado y el Ciclo de Vida','Cómo usar los Hooks de React para escribir componentes más limpios y funcionales.',0.00,'A definir','',NULL,'2023-02-23 17:00:00','2025-10-13 20:45:43'),
(13,13,3,'Consultas Avanzadas con SQL: JOINs y Subconsultas','Domina las consultas complejas para extraer datos de múltiples tablas.',0.00,'A definir','',NULL,'2023-02-25 12:30:00','2025-10-13 20:45:43'),
(14,14,4,'Redes Neuronales Convolucionales (CNNs) Explicadas','Entendiendo cómo las CNNs revolucionan el procesamiento de imágenes.',0.00,'A definir','',NULL,'2023-02-27 15:00:00','2025-10-13 20:45:43'),
(15,15,5,'Autenticación y Autorización en Aplicaciones Web','Diferencias y mejores prácticas para gestionar el acceso de usuarios.',0.00,'A definir','',NULL,'2023-03-01 19:00:00','2025-10-13 20:45:43'),
(16,16,6,'CI/CD con Jenkins: Automatizando tu Despliegue','Configura un pipeline de integración y entrega continua con Jenkins.',0.00,'A definir','',NULL,'2023-03-03 13:15:00','2025-10-13 20:45:43'),
(17,17,7,'Servidores Serverless con AWS Lambda','Construye aplicaciones escalables sin preocuparte por la infraestructura.',0.00,'A definir','',NULL,'2023-03-05 16:45:00','2025-10-13 20:45:43'),
(18,18,8,'Email Marketing Efectivo: Estrategias y Herramientas','Cómo diseñar campañas de email marketing que conviertan.',0.00,'A definir','',NULL,'2023-03-07 12:40:00','2025-10-13 20:45:43'),
(19,19,9,'Prototipado Rápido con Figma','Crea prototipos interactivos de tus diseños de UX/UI con Figma.',0.00,'A definir','',NULL,'2023-03-09 18:30:00','2025-10-13 20:45:43'),
(20,20,10,'Financiación para Startups: Opciones y Consejos','Explora las diferentes vías de financiación para tu emprendimiento tecnológico.',0.00,'A definir','',NULL,'2023-03-11 14:00:00','2025-10-13 20:45:43'),
(21,1,11,'Análisis Exploratorio de Datos con Pandas','Primeros pasos en el análisis de datos usando la librería Pandas en Python.',0.00,'A definir','',NULL,'2023-03-13 13:00:00','2025-10-13 20:45:43'),
(22,2,12,'Introducción al Deep Learning con TensorFlow','Conceptos básicos y cómo construir tu primera red neuronal profunda.',0.00,'A definir','',NULL,'2023-03-15 17:30:00','2025-10-13 20:45:43'),
(23,3,13,'Desarrollo de Aplicaciones de Realidad Virtual con Unity','Creando experiencias inmersivas desde cero.',0.00,'A definir','',NULL,'2023-03-17 12:15:00','2025-10-13 20:45:43'),
(24,4,14,'Entendiendo Blockchain: La Tecnología Detrás de las Criptomonedas','Una explicación sencilla de cómo funciona la tecnología blockchain.',0.00,'A definir','',NULL,'2023-03-19 14:00:00','2025-10-13 20:45:43'),
(25,5,15,'Big Data: Almacenamiento y Procesamiento Distribuido','Cómo manejar grandes volúmenes de datos con herramientas como Hadoop y Spark.',0.00,'A definir','',NULL,'2023-03-21 19:45:00','2025-10-13 20:45:43'),
(27,7,17,'Frameworks Frontend: Comparativa de React, Angular y Vue','Analizamos las ventajas y desventajas de los frameworks más populares.',0.00,'A definir','',NULL,'2023-03-25 16:00:00','2025-10-13 20:45:43'),
(28,8,18,'Desarrollo Backend con Node.js y Express','Construye APIs RESTful robustas y escalables con Node.js.',0.00,'A definir','',NULL,'2023-03-27 12:00:00','2025-10-13 20:45:43'),
(29,9,19,'Pruebas Unitarias en JavaScript con Jest','Asegura la calidad de tu código JavaScript con pruebas unitarias.',0.00,'A definir','',NULL,'2023-03-29 18:00:00','2025-10-13 20:45:43'),
(31,25,22,'Optimización Pro Gamer: ¡FPS Máximos!','¿Quieres más FPS y menos lag en tus juegos favoritos? Este servicio especializado incluye: ajuste fino de la configuración de Windows (modos de juego, prioridades, servicios en segundo plano), optimización de la configuración de la tarjeta gráfica (NVIDIA/AMD), limpieza de archivos basura que saturan la memoria y, si es necesario, actualización de drivers de GPU y chipset. ¡Prepara tu PC para el rendimiento de eSports!',100000.00,'2 semanas','',NULL,'2025-10-04 21:01:57','2025-10-13 20:51:18');
/*!40000 ALTER TABLE `Posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ratings`
--

DROP TABLE IF EXISTS `Ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ratings` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`rating_id`),
  UNIQUE KEY `unique_user_post` (`user_id`,`post_id`),
  KEY `idx_post_ratings` (`post_id`),
  KEY `idx_user_ratings` (`user_id`),
  CONSTRAINT `Ratings_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`post_id`) ON DELETE CASCADE,
  CONSTRAINT `Ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ratings`
--

LOCK TABLES `Ratings` WRITE;
/*!40000 ALTER TABLE `Ratings` DISABLE KEYS */;
INSERT INTO `Ratings` VALUES
(1,1,25,4,'z<dheh','2025-10-17 23:09:50','2025-10-17 23:10:05');
/*!40000 ALTER TABLE `Ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ServiceComments`
--

DROP TABLE IF EXISTS `ServiceComments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ServiceComments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`comment_id`),
  KEY `idx_post_comments` (`post_id`),
  KEY `idx_user_comments` (`user_id`),
  CONSTRAINT `ServiceComments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`post_id`) ON DELETE CASCADE,
  CONSTRAINT `ServiceComments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ServiceComments`
--

LOCK TABLES `ServiceComments` WRITE;
/*!40000 ALTER TABLE `ServiceComments` DISABLE KEYS */;
/*!40000 ALTER TABLE `ServiceComments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tags`
--

DROP TABLE IF EXISTS `Tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tags`
--

LOCK TABLES `Tags` WRITE;
/*!40000 ALTER TABLE `Tags` DISABLE KEYS */;
INSERT INTO `Tags` VALUES
(27,'Automatizacion'),
(9,'AWS'),
(25,'Backend'),
(22,'Big Data'),
(21,'Blockchain'),
(14,'Ciberseguridad'),
(16,'Cloud'),
(4,'CSS'),
(19,'Data Science'),
(20,'Deep Learning'),
(15,'DevOps'),
(8,'Docker'),
(18,'Emprendimiento'),
(24,'Frontend'),
(29,'Gaming'),
(5,'HTML'),
(28,'IoT'),
(2,'JavaScript'),
(13,'Machine Learning'),
(17,'Marketing'),
(23,'Mobile'),
(7,'Node.js'),
(1,'Python'),
(6,'React'),
(10,'SEO'),
(3,'SQL'),
(26,'Testing'),
(12,'UI'),
(11,'UX');
/*!40000 ALTER TABLE `Tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `cedula` varchar(20) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES
(1,'juanperez','lopez','juan.perez@example.com','usuario','12345678','otro','paris','hash_jperez123','2023-01-15 13:00:00'),
(2,'mariagomez',NULL,'maria.gomez@example.com','usuario',NULL,NULL,NULL,'hash_mgomez456','2023-01-18 14:30:00'),
(3,'carlosruiz',NULL,'carlos.ruiz@example.com','usuario',NULL,NULL,NULL,'hash_cruiz789','2023-01-20 17:45:00'),
(4,'laurafernandez',NULL,'laura.fernandez@example.com','usuario',NULL,NULL,NULL,'hash_lfernandez012','2023-02-01 12:15:00'),
(5,'pedrosanchez',NULL,'pedro.sanchez@example.com','usuario',NULL,NULL,NULL,'hash_psanchez345','2023-02-05 19:00:00'),
(7,'javierlopez',NULL,'javier.lopez@example.com','usuario',NULL,NULL,NULL,'hash_jlopez901','2023-02-12 16:05:00'),
(8,'sofiamartinez',NULL,'sofia.martinez@example.com','usuario',NULL,NULL,NULL,'hash_smartinez234','2023-02-15 20:30:00'),
(9,'diegovazquez',NULL,'diego.vazquez@example.com','usuario',NULL,NULL,NULL,'hash_dvazquez567','2023-02-20 11:40:00'),
(10,'elenamartin',NULL,'elena.martin@example.com','usuario',NULL,NULL,NULL,'hash_emartin890','2023-02-22 15:10:00'),
(11,'ricardodiaz',NULL,'ricardo.diaz@example.com','usuario',NULL,NULL,NULL,'hash_rdiaz123','2023-03-01 12:55:00'),
(12,'patriciahernandez',NULL,'patricia.hernandez@example.com','usuario',NULL,NULL,NULL,'hash_phernandez456','2023-03-05 17:00:00'),
(13,'miguelgonzalez',NULL,'miguel.gonzalez@example.com','usuario',NULL,NULL,NULL,'hash_mgonzalez789','2023-03-08 14:00:00'),
(14,'rociojimenez',NULL,'rocio.jimenez@example.com','usuario',NULL,NULL,NULL,'hash_rjimenez012','2023-03-10 19:30:00'),
(15,'fernandoruiz',NULL,'fernando.ruiz@example.com','usuario',NULL,NULL,NULL,'hash_fruiz345','2023-03-15 13:45:00'),
(16,'valeriasoto',NULL,'valeria.soto@example.com','usuario',NULL,NULL,NULL,'hash_vsoto678','2023-03-18 16:20:00'),
(17,'gabrielblanco',NULL,'gabriel.blanco@example.com','usuario',NULL,NULL,NULL,'hash_gblanco901','2023-03-20 12:00:00'),
(18,'luciaalonso',NULL,'lucia.alonso@example.com','usuario',NULL,NULL,NULL,'hash_lalonso234','2023-03-25 18:10:00'),
(19,'sergiomoreno',NULL,'sergio.moreno@example.com','usuario',NULL,NULL,NULL,'hash_smoreno567','2023-03-28 14:50:00'),
(20,'andrearomero',NULL,'andrea.romero@example.com','usuario',NULL,NULL,NULL,'hash_aromero890','2023-04-01 17:00:00'),
(21,'davidperez','popp','david.perez@example.com','usuario','14531252','Uruguay','sgh','hash_dperez111','2023-04-05 13:00:00'),
(25,'fede','gonzales','fede@gmail.com','admin','12345678','Uruguay','las piedras','$2y$10$3uwNKjPJOH9v9BnohVvF0ux7MOanA3WsxNptvz.JZmRV9mBu4abGm','2025-10-01 21:52:11'),
(26,'ignacio','prego','ignacio@gmail.com','usuario','34788965','Argentina','la panpa','$2y$10$FVKnJyEA0K4aw.orJoP60OHvbCn3SHYs6skj.luBCZeL84lSyOzRG','2025-10-30 20:36:58');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(128) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_token` (`token`),
  KEY `fk_password_resets_user` (`user_id`),
  CONSTRAINT `fk_password_resets_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-02 21:51:54
