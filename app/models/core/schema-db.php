<?php

//namespace app\models;

require_once __DIR__."/db_version.php";
require_once __DIR__."/../config/dbconfig.php";

print "Updating/Creating DB schema...".PHP_EOL;

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);

if(!$conn) die('connection db error');

// creacion inicial

$charset = "latin1";
$engine  = "InnoDB";
$id_def  = "`id` bigint(11) NOT NULL AUTO_INCREMENT";

$sqls = array();

$sqls['db_version'] = <<<EOD
CREATE TABLE IF NOT EXISTS `db_version` (
  {$id_def},
  `version` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$engine} DEFAULT CHARSET={$charset} AUTO_INCREMENT=1 ;
EOD;
$sqls['usuario'] = <<<EOD
CREATE TABLE IF NOT EXISTS `usuario` (
  {$id_def},
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$engine} DEFAULT CHARSET={$charset} AUTO_INCREMENT=1 ;
EOD;
$sqls['usuario.fixtures'] = <<<EOD
INSERT INTO  `usuario` (`email`, `pass`) VALUES
('admin',MD5('admin'));
EOD;
$sqls['juego'] = <<<EOD
CREATE TABLE IF NOT EXISTS `juego` (
  {$id_def},
  `titulo` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `edad` int(2) DEFAULT NULL,
  `duracion` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$engine} DEFAULT CHARSET={$charset} AUTO_INCREMENT=1 ;
EOD;
$sqls['estatica'] = <<<EOD
CREATE TABLE IF NOT EXISTS `estatica` (
  {$id_def},
  `slug` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$engine} DEFAULT CHARSET={$charset} AUTO_INCREMENT=1 ;
EOD;
$sqls['estatica.fixtures'] = <<<EOD
INSERT INTO  `estatica` (`slug`, `contenido`) VALUES
('sobre-mi','No hay mucho que decir sobre mi');
EOD;
$sqls['contacto'] = <<<EOD
CREATE TABLE IF NOT EXISTS `contacto` (
  {$id_def},
  `fecha_solicitud` datetime NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_acto` datetime NOT NULL,
  `desde` int(5) NOT NULL,
  `hasta` int(5) NOT NULL,
  `codigo_postal` int(5) NOT NULL,
  `edad_media` int(3) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `contestacion` text NULL,
  `fecha_contestacion` datetime NULL,
  `precio` float NULL,
  `suma` int(4) NULL,
  PRIMARY KEY (`id`)
) ENGINE={$engine} DEFAULT CHARSET={$charset} AUTO_INCREMENT=1 ;
EOD;

// primero averiguar que version tiene la base de datos
//$result = mysqli_query($conn,'SELECT * FROM `db` LIMIT 1 ORDER DESC `id`');

foreach ($sqls as $key=>$sql) {
    print $key.'...'.PHP_EOL;
    mysqli_query($conn,$sql);

    if (mysqli_errno($conn)) {
        print mysqli_error($conn);
        print PHP_EOL.$sql.PHP_EOL;
        die;
    }
}

mysqli_query($conn,'INSERT INTO `db_version` (`version`) VALUES ('.VERSION_DB.')');
