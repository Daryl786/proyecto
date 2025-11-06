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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
INSERT INTO `Categories` VALUES
(1,'Desarrollo Web Full Stack','Desarrollo completo de aplicaciones web, frontend y backend integrados','2025-11-03 01:05:09'),
(2,'Programación y Algoritmos','Desarrollo de software, lógica de programación y estructuras de datos','2025-11-03 01:05:09'),
(3,'Bases de Datos y Big Data','Diseño, administración y análisis de datos a gran escala','2025-11-03 01:05:09'),
(4,'Inteligencia Artificial y ML','Machine Learning, Deep Learning y soluciones de IA','2025-11-03 01:05:09'),
(5,'Seguridad Informática','Ciberseguridad, auditorías y protección de sistemas','2025-11-03 01:05:09'),
(6,'Infraestructura y Cloud','DevOps, cloud computing, contenedores y automatización','2025-11-03 01:05:09'),
(7,'Diseño UX/UI','Experiencia de usuario, interfaces y prototipado','2025-11-03 01:05:09'),
(8,'Marketing Digital','SEO, SEM, redes sociales y estrategias digitales','2025-11-03 01:05:09'),
(9,'Desarrollo Móvil','Aplicaciones para iOS, Android y multiplataforma','2025-11-03 01:05:09'),
(10,'Consultoría Tecnológica','Asesoramiento en tecnología, transformación digital y estrategia','2025-11-03 01:05:09'),
(11,'Blockchain y Criptomonedas','Desarrollo blockchain, smart contracts y Web3','2025-11-03 01:05:09'),
(12,'Gaming y Multimedia','Desarrollo de videojuegos, optimización y contenido multimedia','2025-11-03 01:05:09'),
(13,'IoT y Sistemas Embebidos','Internet de las cosas, Arduino, Raspberry Pi y automatización','2025-11-03 01:05:09'),
(14,'Testing y QA','Pruebas de software, automatización de tests y aseguramiento de calidad','2025-11-03 01:05:09'),
(15,'Realidad Virtual y Aumentada','Experiencias inmersivas, VR, AR y metaverso','2025-11-03 01:05:09');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contrataciones`
--

LOCK TABLES `Contrataciones` WRITE;
/*!40000 ALTER TABLE `Contrataciones` DISABLE KEYS */;
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
(1,2),
(1,3),
(1,4),
(1,5),
(6,1),
(6,34),
(11,1),
(11,12),
(11,47),
(16,7),
(16,9),
(21,14),
(21,15),
(26,16),
(26,17),
(31,7),
(31,50),
(36,1),
(36,2),
(41,24),
(41,31),
(41,32);
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Posts`
--

LOCK TABLES `Posts` WRITE;
/*!40000 ALTER TABLE `Posts` DISABLE KEYS */;
INSERT INTO `Posts` VALUES
(1,1,1,'Desarrollo de E-commerce Completo con Pasarela de Pagos','Creación de tienda online profesional con sistema de gestión de productos, carrito de compras, integración con múltiples pasarelas de pago (Stripe, PayPal, Mercado Pago), panel administrativo completo, gestión de inventario, sistema de envíos y facturación electrónica. Diseño responsive y optimizado para conversión.',2500.00,'2 meses',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(6,1,2,'Desarrollo de Software a Medida en Python/Java','Creación de aplicaciones de escritorio o scripts automatizados según tus necesidades específicas. Procesamiento de datos, automatización de tareas, integración de APIs, interfaces gráficas con PyQt/Tkinter/JavaFX. Código limpio, documentado y mantenible.',800.00,'3 semanas',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(11,1,4,'Sistema de Recomendación con Machine Learning','Desarrollo de motor de recomendaciones personalizado usando algoritmos de filtrado colaborativo y content-based. Análisis de comportamiento de usuarios, entrenamiento de modelos con scikit-learn/TensorFlow, API para integración, mejora continua del modelo. Perfecto para e-commerce y plataformas de contenido.',2800.00,'2 meses',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(16,1,5,'Implementación de Sistema de Seguridad Integral','Configuración completa de seguridad: firewall de aplicación (WAF), certificados SSL/TLS, autenticación multifactor (MFA), encriptación de datos sensibles, política de contraseñas robusta, logs de seguridad, backup automático cifrado y documentación de procedimientos de seguridad.',2500.00,'1 mes',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(21,1,7,'Diseño UX/UI Completo para Aplicación Móvil','Investigación de usuarios, arquitectura de información, wireframes, prototipos interactivos en Figma, diseño visual de alta fidelidad, sistema de diseño (design system), guías de estilo, assets para desarrollo, testing con usuarios reales y 3 rondas de iteración incluidas.',2000.00,'6 semanas',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(26,1,8,'Estrategia de Contenido y Social Media Management','Planificación y gestión de redes sociales: calendario editorial, creación de contenido (textos e imágenes), publicación programada, community management, análisis de métricas, estrategia de engagement. Redes: Instagram, Facebook, LinkedIn, Twitter/X. Reporte mensual de resultados.',900.00,'1 mes',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(31,1,10,'Auditoría Técnica de Código y Arquitectura','Revisión exhaustiva de tu proyecto: calidad de código, patrones de diseño, escalabilidad, seguridad, performance, deuda técnica. Informe detallado con recomendaciones priorizadas, estimación de esfuerzo para mejoras. Incluye sesión de Q&A con el equipo técnico.',1200.00,'2 semanas',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(36,1,12,'Edición Profesional de Video y Motion Graphics','Edición de video profesional para YouTube, redes sociales o publicidad: color grading, efectos visuales, motion graphics, animaciones 2D, sincronización de audio, subtítulos, intro/outro personalizados. Software: Adobe Premiere, After Effects, DaVinci Resolve.',400.00,'1 semana',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09'),
(41,1,15,'Experiencia de Realidad Virtual Inmersiva','Desarrollo de aplicación VR para Oculus Quest/HTC Vive: diseño de experiencia inmersiva, entorno 3D fotorrealista, interacciones naturales, optimización de performance 90fps, sonido espacial, testing con usuarios. Aplicaciones: capacitación, showroom virtual, gaming, turismo virtual.',4500.00,'3 meses',NULL,NULL,'2025-11-03 01:05:09','2025-11-03 01:05:09');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ratings`
--

LOCK TABLES `Ratings` WRITE;
/*!40000 ALTER TABLE `Ratings` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tags`
--

LOCK TABLES `Tags` WRITE;
/*!40000 ALTER TABLE `Tags` DISABLE KEYS */;
INSERT INTO `Tags` VALUES
(15,'Adobe XD'),
(37,'Angular'),
(26,'Arduino'),
(9,'AWS'),
(10,'Azure'),
(30,'Cypress'),
(34,'Django'),
(7,'Docker'),
(23,'Ethereum'),
(35,'FastAPI'),
(14,'Figma'),
(18,'Flutter'),
(50,'Git'),
(39,'Go'),
(17,'Google Ads'),
(11,'Google Cloud'),
(44,'GraphQL'),
(2,'JavaScript'),
(49,'Jenkins'),
(29,'Jest'),
(21,'Kotlin'),
(8,'Kubernetes'),
(42,'MongoDB'),
(45,'Next.js'),
(4,'Node.js'),
(6,'NoSQL'),
(31,'Oculus'),
(33,'PHP'),
(41,'PostgreSQL'),
(1,'Python'),
(13,'PyTorch'),
(27,'Raspberry Pi'),
(3,'React'),
(19,'React Native'),
(43,'Redis'),
(40,'Rust'),
(47,'Scikit-learn'),
(28,'Selenium'),
(16,'SEO'),
(22,'Solidity'),
(5,'SQL'),
(20,'Swift'),
(46,'Tailwind CSS'),
(12,'TensorFlow'),
(48,'Terraform'),
(32,'Three.js'),
(38,'TypeScript'),
(24,'Unity'),
(25,'Unreal Engine'),
(36,'Vue.js');
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES
(1,'juanperez','lopez','juan.perez@example.com','usuario','12345678','otro','paris','hash_jperez123','2023-01-15 13:00:00'),
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
(25,'fede','gonzales','fede@gmail.com','admin','12345678','Uruguay','las piedras','$2y$10$3uwNKjPJOH9v9BnohVvF0ux7MOanA3WsxNptvz.JZmRV9mBu4abGm','2025-10-01 21:52:11'),
(26,'ignacio','prego','ignacio@gmail.com','usuario','34788965','Argentina','la panpa','$2y$10$FVKnJyEA0K4aw.orJoP60OHvbCn3SHYs6skj.luBCZeL84lSyOzRG','2025-10-30 20:36:58'),
(27,'martin','garcia','martin@gmail.com','usuario','12334623','Uruguay','las piedras','$2y$10$YRy3Gfg7bXDFqjMNu7FKfeRu5Q4T7I13sT18C35SVdVx46FYvJocS','2025-11-03 01:16:16');
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

-- Dump completed on 2025-11-05 22:07:17
