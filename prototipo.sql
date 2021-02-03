-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.14-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla prototipo.alertas
CREATE TABLE IF NOT EXISTS `alertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` varchar(50) NOT NULL DEFAULT '0',
  `observacion` varchar(200) NOT NULL DEFAULT '0',
  `estado` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.alertas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `alertas` DISABLE KEYS */;
/*!40000 ALTER TABLE `alertas` ENABLE KEYS */;

-- Volcando estructura para tabla prototipo.areas
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL DEFAULT '0',
  `observacion` varchar(100) NOT NULL DEFAULT '0',
  `estado` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.areas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` (`id`, `descripcion`, `observacion`, `estado`) VALUES
	(1, 'Infraestructura', 'null', 1),
	(2, 'Ciberseguridad', 'null', 1),
	(3, 'SOC', 'null', 1);
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;

-- Volcando estructura para tabla prototipo.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) NOT NULL DEFAULT '0',
  `nombre_comercial` varchar(100) NOT NULL DEFAULT '0',
  `correo` varchar(100) NOT NULL DEFAULT '0',
  `telefono` varchar(100) NOT NULL DEFAULT '0',
  `direccion` varchar(100) NOT NULL DEFAULT '0',
  `is_deleted` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.clientes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `razon_social`, `nombre_comercial`, `correo`, `telefono`, `direccion`, `is_deleted`) VALUES
	(2, 'Municipio de Quito', 'Municipio de Quito', 'municipio.quito@gob.ec', '022089191', 'Antonio tandazo y affff', 0),
	(4, 'Banco bolivariano', 'Banco bolivariano', 'bbolivarioano@gob.ec', '0220875125', 'sjaahhsidosdf', 0);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla prototipo.contratos
CREATE TABLE IF NOT EXISTS `contratos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL DEFAULT '0',
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `cliente_id` int(11) NOT NULL DEFAULT 0,
  `pais_id` int(11) NOT NULL DEFAULT 0,
  `area_id` int(11) NOT NULL DEFAULT 0,
  `solucion` varchar(200) NOT NULL DEFAULT '0',
  `marca` varchar(200) NOT NULL DEFAULT '0',
  `frecuencia` int(11) NOT NULL DEFAULT 0,
  `mantenimientos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `observacion` varchar(200) NOT NULL DEFAULT '0',
  `fecha_creacion` date DEFAULT NULL,
  `estado` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_contratos_clientes` (`cliente_id`),
  KEY `FK_contratos_paises` (`pais_id`),
  KEY `FK_contratos_areas` (`area_id`),
  KEY `FK_contratos_frecuencias` (`frecuencia`),
  CONSTRAINT `FK_contratos_areas` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  CONSTRAINT `FK_contratos_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_contratos_frecuencias` FOREIGN KEY (`frecuencia`) REFERENCES `frecuencias` (`id`),
  CONSTRAINT `FK_contratos_paises` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.contratos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `contratos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contratos` ENABLE KEYS */;

-- Volcando estructura para tabla prototipo.frecuencias
CREATE TABLE IF NOT EXISTS `frecuencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL DEFAULT '0',
  `estado` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.frecuencias: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `frecuencias` DISABLE KEYS */;
INSERT INTO `frecuencias` (`id`, `descripcion`, `estado`) VALUES
	(1, 'DIARIA', 0),
	(2, 'SEMANAL', 1),
	(3, 'MENSUAL', 1),
	(4, 'TRIMESTRAL', 1),
	(5, 'SEMESTRAL', 1),
	(6, 'ANUAL', 1);
/*!40000 ALTER TABLE `frecuencias` ENABLE KEYS */;

-- Volcando estructura para tabla prototipo.mantenimientos
CREATE TABLE IF NOT EXISTS `mantenimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `alerta` smallint(6) NOT NULL DEFAULT 0,
  `observacion` varchar(100) NOT NULL DEFAULT '0',
  `estado` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_mantenimiento_contrato` (`contrato_id`),
  CONSTRAINT `FK_mantenimiento_contrato` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.mantenimientos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mantenimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantenimientos` ENABLE KEYS */;

-- Volcando estructura para tabla prototipo.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '0',
  `abreviatura` varchar(5) NOT NULL DEFAULT '0',
  `estado` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla prototipo.paises: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`id`, `nombre`, `abreviatura`, `estado`) VALUES
	(1, 'Ecuador', 'EC', 1);
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
