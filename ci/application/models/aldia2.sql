-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-07-2012 a las 14:17:29
-- Versión del servidor: 5.1.61
-- Versión de PHP: 5.3.5-1ubuntu7.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `aldia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_actividades`
--

CREATE TABLE IF NOT EXISTS `aldia_actividades` (
  `act_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `act_proy_id` bigint(20) NOT NULL,
  `act_desc` text NOT NULL,
  `act_responsables` text NOT NULL,
  `act_inicio` date DEFAULT NULL,
  `act_fin` date DEFAULT NULL,
  `act_status` varchar(10) NOT NULL DEFAULT 'none' COMMENT 'ENUM(''none'', ''processing'', ''finished'')',
  PRIMARY KEY (`act_id`),
  KEY `fk_aldia_actividades_aldia_proyecto1` (`act_proy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Cronograma de actividades planificadas para el proyecto.' AUTO_INCREMENT=10 ;

--
-- Volcar la base de datos para la tabla `aldia_actividades`
--

INSERT INTO `aldia_actividades` (`act_id`, `act_proy_id`, `act_desc`, `act_responsables`, `act_inicio`, `act_fin`, `act_status`) VALUES
(2, 1, 'Desplegar una campaña divulgativa a lo interno de la comunidad para ganar aliados(as)', 'Consejo Comunal', NULL, NULL, 'none'),
(3, 1, 'Explorar y diagnosticar el (los) terrenos disponibles, para definir el sitio exacto para viabilizar la construcción de la cancha', 'Club deportivo, Concejo Comunal, Prefecta', NULL, NULL, 'none'),
(4, 1, 'Elaboración, presentación aval y canalización del proyecto, la búsqueda del financiamiento y ejecución del mismo. Ejecución de la obra de construcción de la cancha para lograr dar respuesta a las expectativas de la comunidad de ojo de agua sectores los pinos, la planada, el Carmen, los mangos', 'Consejo Comunal', NULL, NULL, 'none'),
(5, 1, 'Desarrollar un programa de sensibilización y masificación del deporte y recreación', 'Consejo Comunal', NULL, NULL, 'none'),
(1, 1, 'Conformar un Equipo Promotor Deportivo dentro de la comunidad, para que gestione ante las instituciones y autoridades la asesoría y asistencia técnica necesaria para concretar el proyecto.', '2 voceros del Consejo Comunal, perteneciente al comité de trabajo deporte, cultura y recreación', NULL, NULL, 'none'),
(6, 1, 'Actividad con mapa', 'Yo', '2012-06-15', '2012-06-15', 'none'),
(7, 2, 'Actividad nueva 1', 'yo mismo', '2012-06-13', '2012-06-15', 'none'),
(8, 3, 'compra de materiales', 'Levi', '2012-06-02', '2012-06-16', 'none');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_comunidad`
--

CREATE TABLE IF NOT EXISTS `aldia_comunidad` (
  `com_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `com_nombre` varchar(45) NOT NULL,
  `com_habitantes` int(11) NOT NULL,
  `com_familias` int(11) NOT NULL,
  `com_estado` varchar(45) NOT NULL,
  `com_municipio` varchar(45) NOT NULL,
  `com_parroquia` varchar(45) NOT NULL,
  `com_area_geo` text NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `aldia_comunidad`
--

INSERT INTO `aldia_comunidad` (`com_id`, `com_nombre`, `com_habitantes`, `com_familias`, `com_estado`, `com_municipio`, `com_parroquia`, `com_area_geo`) VALUES
(1, 'Ojo de Agua', 4000, 1000, 'Miranda', 'Baruta', 'Nuestra Sr. del Rosario', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_config`
--

CREATE TABLE IF NOT EXISTS `aldia_config` (
  `config_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(45) NOT NULL,
  `config_value` longtext NOT NULL,
  `config_org_id` bigint(20) NOT NULL,
  PRIMARY KEY (`config_id`),
  KEY `fk_aldia_config_aldia_organizacion1` (`config_org_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `aldia_config`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_fase`
--

CREATE TABLE IF NOT EXISTS `aldia_fase` (
  `fase_id` int(11) NOT NULL,
  `fase_name` varchar(45) NOT NULL,
  `fase_objetivo` text NOT NULL,
  `fase_orden` int(11) NOT NULL,
  `fase_page_id` bigint(20) NOT NULL COMMENT 'Pagina de ayuda.\nLos detalles adicionales de la fase se encuentran en esta pagina',
  PRIMARY KEY (`fase_id`),
  KEY `fk_aldia_fase_aldia_pages1` (`fase_page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `aldia_fase`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_historico`
--

CREATE TABLE IF NOT EXISTS `aldia_historico` (
  `hist_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hist_texto` longtext NOT NULL,
  `hist_type` varchar(15) NOT NULL COMMENT 'Correccion, Observacion, Nota, Noticia',
  `hist_created` datetime NOT NULL,
  `aldia_proyecto_proy_id` bigint(20) NOT NULL,
  `aldia_usuarios_user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`hist_id`),
  KEY `fk_aldia_historico_aldia_proyecto1` (`aldia_proyecto_proy_id`),
  KEY `fk_aldia_historico_aldia_usuarios1` (`aldia_usuarios_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `aldia_historico`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_inversion`
--

CREATE TABLE IF NOT EXISTS `aldia_inversion` (
  `inv_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `inv_proy_id` bigint(20) NOT NULL,
  `inv_rubro` varchar(64) NOT NULL,
  `inv_unidad` varchar(32) NOT NULL,
  `inv_precio` float NOT NULL,
  `inv_cantidad` float NOT NULL,
  `inv_status` varchar(10) NOT NULL DEFAULT 'pendiente' COMMENT 'ENUM(''pendiente'', ''cancelado'')',
  `inv_inversionista` varchar(64) NOT NULL,
  `inv_fecha_aprob` date NOT NULL COMMENT 'Fecha en que fue aprobada la inversion',
  PRIMARY KEY (`inv_id`),
  KEY `fk_aldia_plan_aldia_proyecto1` (`inv_proy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Plan de inversion para el proyecto.' AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `aldia_inversion`
--

INSERT INTO `aldia_inversion` (`inv_id`, `inv_proy_id`, `inv_rubro`, `inv_unidad`, `inv_precio`, `inv_cantidad`, `inv_status`, `inv_inversionista`, `inv_fecha_aprob`) VALUES
(1, 1, 'Mano de obra', 'dia', 120, 60, 'pendiente', '', '0000-00-00'),
(2, 3, 'tuberías', '1', 2000, 4, 'pendiente', '', '0000-00-00'),
(3, 3, 'pago trabajadores', '1', 3000, 10, 'pendiente', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_maps`
--

CREATE TABLE IF NOT EXISTS `aldia_maps` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT,
  `map_act_id` int(11) NOT NULL,
  `map_lang` double NOT NULL,
  `map_lat` double NOT NULL,
  `map_desc` text NOT NULL,
  `map_proy_id` bigint(20) NOT NULL,
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `aldia_maps`
--

INSERT INTO `aldia_maps` (`map_id`, `map_act_id`, `map_lang`, `map_lat`, `map_desc`, `map_proy_id`) VALUES
(1, 1, -71.1919374999995, 7.61945717718906, 'actividad 1', 1),
(2, 6, -66.429364257812, 10.440202583806, 'actividad', 1),
(3, 7, -66.6030092959697, 9.67276469957268, 'actividad 1', 2),
(4, 8, -66.429364257812, 10.440202583806, 'actividad', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_organizacion`
--

CREATE TABLE IF NOT EXISTS `aldia_organizacion` (
  `org_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `org_com_id` bigint(20) NOT NULL,
  `org_nombre` varchar(100) NOT NULL,
  `org_sectores` varchar(100) NOT NULL,
  `org_desc` varchar(45) NOT NULL,
  PRIMARY KEY (`org_id`),
  KEY `fk_aldia_organizacion_aldia_comunidad1` (`org_com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `aldia_organizacion`
--

INSERT INTO `aldia_organizacion` (`org_id`, `org_com_id`, `org_nombre`, `org_sectores`, `org_desc`) VALUES
(1, 1, 'Consejo Comunal', 'Los Pinos', 'Consejo Comunal de la comunidad Ojo de Agua'),
(2, 1, 'Sociedad Civil', 'Los Pinos, y el resto', 'Sociedad Civil de Ojo de Agua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_pages`
--

CREATE TABLE IF NOT EXISTS `aldia_pages` (
  `page_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page_titulo` varchar(45) NOT NULL,
  `page_text` longtext NOT NULL,
  `page_com_id` bigint(20) NOT NULL COMMENT 'Las paginas de ayuda son creadas para comunidades especificas.\n0 indica que estan disponibles para todas las comunidades.',
  PRIMARY KEY (`page_id`),
  KEY `fk_aldia_pages_aldia_comunidad1` (`page_com_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `aldia_pages`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_proyectos`
--

CREATE TABLE IF NOT EXISTS `aldia_proyectos` (
  `proy_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `proy_com_id` bigint(20) NOT NULL,
  `proy_fecha_creacion` date NOT NULL,
  `proy_status` varchar(10) NOT NULL DEFAULT 'disabled' COMMENT '''disabled'', ''active'', ''deleted''',
  `proy_tipo` varchar(16) NOT NULL COMMENT 'ENUM(''infraestructura'', ''social'', ''productivo'')',
  `proy_titulo` varchar(126) NOT NULL,
  `proy_justificacion` text NOT NULL,
  `proy_obj_gen` text NOT NULL,
  `proy_obj_esp` text NOT NULL,
  `proy_cobertura_geo` text NOT NULL,
  `proy_benef` text NOT NULL,
  `proy_fam_benf_direc` int(11) NOT NULL,
  `proy_fam_benf_indirec` int(11) NOT NULL,
  `proy_resultado` text NOT NULL COMMENT 'Resultado esperado del proyecto',
  `proy_impacto` text NOT NULL COMMENT 'Impacto esperado del proyecto',
  `proy_fecha_culm` date NOT NULL COMMENT 'Fecha en que se espera terminar el proyecto',
  `proy_fecha_fin` date DEFAULT NULL,
  `proy_fecha_mod` datetime NOT NULL,
  `proy_costo` float NOT NULL,
  `proy_fase_id` int(11) NOT NULL,
  `proy_org_id` bigint(20) NOT NULL,
  PRIMARY KEY (`proy_id`),
  KEY `fk_aldia_proyecto_aldia_comunidad1` (`proy_com_id`),
  KEY `fk_aldia_proyecto_aldia_fase1` (`proy_fase_id`),
  KEY `fk_aldia_proyectos_aldia_organizacion1` (`proy_org_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `aldia_proyectos`
--

INSERT INTO `aldia_proyectos` (`proy_id`, `proy_com_id`, `proy_fecha_creacion`, `proy_status`, `proy_tipo`, `proy_titulo`, `proy_justificacion`, `proy_obj_gen`, `proy_obj_esp`, `proy_cobertura_geo`, `proy_benef`, `proy_fam_benf_direc`, `proy_fam_benf_indirec`, `proy_resultado`, `proy_impacto`, `proy_fecha_culm`, `proy_fecha_fin`, `proy_fecha_mod`, `proy_costo`, `proy_fase_id`, `proy_org_id`) VALUES
(1, 1, '2011-11-25', 'active', 'infraestructura', 'Construcción de una Cancha Deportiva', '&lt;p&gt;Ante las escasas &amp;aacute;reas o espacios para el esparcimiento, la recreaci&amp;oacute;n y el deporte dentro de la comunidad de Ojo de Agua los vecinos(as), j&amp;oacute;venes y ni&amp;ntilde;os (as) vienen manifestando desde hace d&amp;eacute;cadas la necesidad de poder contar con unas instalaciones acordes, &amp;oacute;ptimas y seguras para realizar diversas actividades que contribuyan con el desarrollo integral de los ciudadanos.&lt;/p&gt;\n&lt;p&gt;Dentro de esta comunidad los j&amp;oacute;venes son los que han sido mayormente afectados, debido que la no pr&amp;aacute;ctica deportiva y recreativa ha tra&amp;iacute;do consigo una serie de comportamientos desviados tales como: ocio, consumo de drogas licitas e il&amp;iacute;citas, entre otras.&lt;/p&gt;\n&lt;p&gt;Esta cancha contribuir&amp;aacute; en propiciar que los ni&amp;ntilde;os, adolescentes, j&amp;oacute;venes y adultos de la comunidad de ojo de agua dispongan de un sitio fijo donde ellos puedan en forma individual o colectiva practicar alguna disciplina deportiva que les guste.&lt;/p&gt;\n&lt;p&gt;Por otra parte, la construcci&amp;oacute;n de la cancha deportiva en el sector de los Pinos, se elevar&amp;aacute; notablemente la calidad de vida de todos sus habitantes en especial los m&amp;aacute;s j&amp;oacute;venes.&lt;br /&gt;En la actualidad, este sector no dispone de una cancha, por lo que la poblaci&amp;oacute;n infantil y juvenil realiza sus pr&amp;aacute;cticas y campeonatos de futbolito y voleibol en las &amp;aacute;reas no actas para tal fin y en la calle transversal adyacente a &amp;eacute;sta, lo que pone en riesgo la salud y la vida de los que all&amp;iacute; realizan actividades recreativas y deportivas, dado que el espacio no es el m&amp;aacute;s acorde, pr&amp;aacute;ctico y pertinente para la misma.&lt;/p&gt;\n&lt;p&gt;La ejecuci&amp;oacute;n de este tipo de actividades desmejora y deteriora las &amp;aacute;reas verdes y de descanso en dicha plaza.&lt;/p&gt;\n&lt;p&gt;Las autoridades p&amp;uacute;blicas en su accionar no han sido las m&amp;aacute;s diligentes para resolver este problema aunado a la poca participaci&amp;oacute;n de los vecinos(as) que coexisten permanentemente con esta situaci&amp;oacute;n. Para ello, se requerir&amp;aacute; de la voluntad oportuna tanto del apoyo de las instituciones estadales como de la comunidad para buscar y/o resolver la problem&amp;aacute;tica planteada.&lt;/p&gt;\n&lt;p&gt;Dentro de la comunidad un comit&amp;eacute; de deporte, quien ha venido realizando conjuntamente con sus miembros, los atletas del sector y algunas autoridades de la parroquia nuestra sr del rosario, gestiones desde hace m&amp;aacute;s de una d&amp;eacute;cada para que se les d&amp;eacute; una respuesta oportuna y efectiva acorde a las posibilidades y oportunidades reales que hay dentro de la comunidad.&lt;br /&gt;Parte de la acci&amp;oacute;n que se han adelantado apuntan hacia la desafecci&amp;oacute;n o compra de unos terrenos existentes dentro de la misma comunidad.&lt;/p&gt;\n&lt;p&gt;Este proyecto beneficiar&amp;aacute; directamente a 600 j&amp;oacute;venes, ni&amp;ntilde;os y adolescentes y 200 de manera indirecta y externa a la comunidad.&lt;/p&gt;\n&lt;p&gt;Dentro de la comunidad de Ojo de Agua, existe j&amp;oacute;venes y actores sociales organizados (atletas, profesionales y t&amp;eacute;cnicos) ganados para que las autoridades e instituciones competentes les d&amp;eacute; una respuesta pertinente y efectiva a un corto plazo.&lt;/p&gt;', '&lt;p&gt;Construir dentro de la comunidad de Ojo de Agua una cancha deportiva que contribuya a la masificaci&amp;oacute;n del deporte y al esparcimiento de los ni&amp;ntilde;os, adolescentes y j&amp;oacute;venes.&lt;/p&gt;', '&lt;ul&gt;\n&lt;li&gt;Buscar un terreno apto para la construcci&amp;oacute;n de la cancha.&lt;/li&gt;\n&lt;li&gt;Gestionar y dise&amp;ntilde;ar el proyecto de la cancha por el Consejo Comunal Ojo de Agua.&lt;/li&gt;\n&lt;li&gt;Propiciar la masificaci&amp;oacute;n del deporte.&lt;/li&gt;\n&lt;li&gt;Gestionar con las instituciones y las autoridades competentes para el financiamiento y la ejecuci&amp;oacute;n del proyecto.&lt;/li&gt;\n&lt;li&gt;Propiciar un programa de sensibilizaci&amp;oacute;n y salud con deportes para todos.&lt;/li&gt;\n&lt;li&gt;Armar un comit&amp;eacute; de vigilancia y mantenimiento de la cancha.&lt;/li&gt;\n&lt;li&gt;Definir un horario de uso de los mismos para que este perdure.&lt;/li&gt;\n&lt;li&gt;Metas&lt;/li&gt;\n&lt;li&gt;Contar con un terreno cuyas dimensiones sean de: 12mts de ancho por 24mts. de largo.&lt;/li&gt;\n&lt;li&gt;Mejorar las condiciones de vida, esparcimiento y recreaci&amp;oacute;n de la poblaci&amp;oacute;n infantil, adolescente y juvenil de la comunidad.&lt;/li&gt;\n&lt;li&gt;Disminuir los niveles de ocio, delincuencia y drogadicci&amp;oacute;n juvenil.&lt;/li&gt;\n&lt;li&gt;Disponer de 120.000.000,00, para administrar directamente la ejecuci&amp;oacute;n de la obra.&lt;/li&gt;\n&lt;li&gt;Construir una cancha deportiva en un (1) a&amp;ntilde;o con la participaci&amp;oacute;n directa de la comunidad organizada.&lt;/li&gt;\n&lt;/ul&gt;', '&lt;p&gt;El proyecto de construcci&amp;oacute;n de la cancha deportiva ser&amp;aacute; desarrollado dentro de la comunidad de ojo de agua, ubicada dentro de la Parroquia Nuestra Sr del Rosario, en el municipio Baruta.&lt;br /&gt;Dicha comunidad cuenta con cuatro mil (4.000) habitantes.&lt;/p&gt;', '&lt;p&gt;Con el proyecto se beneficiar&amp;aacute;n directamente los ni&amp;ntilde;os, adolescentes y j&amp;oacute;venes de esta comunidad, estimada en 600.&lt;/p&gt;', 600, 200, '', '', '2012-01-31', '0000-00-00', '2011-11-25 00:00:00', 0, 1, 1),
(2, 1, '2012-06-02', 'deleted', 'infraestructura', 'prueba', '&lt;p&gt;soy la naturaleza y la justificaci&amp;oacute;n de este proyecto, tengo m&amp;aacute;s de 40 car&amp;aacute;cteres.&lt;/p&gt;', '&lt;p&gt;soy la naturaleza y la justificaci&amp;oacute;n de este proyecto, tengo m&amp;aacute;s de 40 car&amp;aacute;cteres.&lt;/p&gt;', '&lt;p&gt;soy la naturaleza y la justificaci&amp;oacute;n de este proyecto, tengo m&amp;aacute;s de 40 car&amp;aacute;cteres.&lt;/p&gt;', '&lt;p&gt;ambito geofrafico&amp;nbsp;&lt;/p&gt;', '&lt;p&gt;beneficiario 1&lt;/p&gt;', 2, 2, '&lt;p&gt;resultados 1&lt;/p&gt;', '&lt;p&gt;impacto 1&lt;/p&gt;', '2012-06-20', NULL, '2012-06-02 10:05:56', 0, 1, 1),
(3, 1, '2012-06-02', 'disabled', 'infraestructura', 'Proyecto tuberías', '&lt;p&gt;este es proyecto es necesario para la comunidad, debido a la falla en una tuber&amp;iacute;a de agua.&lt;/p&gt;', '&lt;p&gt;solucionar el problema de la tuber&amp;iacute;a&lt;/p&gt;', '&lt;p&gt;comprar tuber&amp;iacute;a, buscar a las personas, buscar plomero, llamar a hidrocapital&lt;/p&gt;', '&lt;p&gt;unidad educativa lomas bajas&lt;/p&gt;', '&lt;p&gt;toda la comunidad&lt;/p&gt;', 2, 4, '&lt;p&gt;restablecer el servicio de agua&lt;/p&gt;', '&lt;p&gt;mejoramiento en la salud&lt;/p&gt;', '2012-12-02', NULL, '2012-06-02 10:25:13', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_sessions`
--

CREATE TABLE IF NOT EXISTS `aldia_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `aldia_sessions`
--

INSERT INTO `aldia_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('6fff82976676e06b9248e62f5ea43b4d', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.30 Safari/536.5', 1338653047, 'a:1:{s:9:"user_data";s:0:"";}'),
('3efc6c5f26fb4a3e2582f85f90d1354a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.30 Safari/536.5', 1342464302, 'a:1:{s:9:"user_data";s:0:"";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_usuarios`
--

CREATE TABLE IF NOT EXISTS `aldia_usuarios` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(10) NOT NULL DEFAULT 'regular' COMMENT 'regular, admin',
  `user_status` varchar(10) NOT NULL DEFAULT 'disabled' COMMENT 'disabled, active, deleted',
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_nombre` varchar(45) NOT NULL DEFAULT '',
  `user_apellido` varchar(45) NOT NULL DEFAULT '',
  `user_sex` enum('m','f') NOT NULL DEFAULT 'm',
  `user_ci` varchar(10) NOT NULL,
  `user_telf` varchar(14) NOT NULL,
  `user_telf_alt` varchar(14) NOT NULL,
  `user_dir` text NOT NULL,
  `user_registrado` date NOT NULL,
  `user_hash` varchar(32) NOT NULL COMMENT 'Usado para la recuperacion de la contrasena',
  `user_expire_hash` datetime NOT NULL COMMENT 'Indica cuando expira el hash de recuperacion de contrasena',
  `user_org_id` bigint(20) NOT NULL,
  `user_org_rol` varchar(10) NOT NULL DEFAULT 'miembro' COMMENT 'Rol que desempeña el usuario en sobre su comunidad.\nmiembro: pertenece a la comunidad\nadmin: puede cambiar configuraciones de la comunidad\nsuper: igual que admin, pero no puede ser borrado.',
  `user_com_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`),
  KEY `fk_aldia_usuarios_aldia_organizacion1` (`user_org_id`),
  KEY `fk_aldia_usuarios_aldia_comunidad1` (`user_com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `aldia_usuarios`
--

INSERT INTO `aldia_usuarios` (`user_id`, `user_type`, `user_status`, `user_email`, `user_pass`, `user_nombre`, `user_apellido`, `user_sex`, `user_ci`, `user_telf`, `user_telf_alt`, `user_dir`, `user_registrado`, `user_hash`, `user_expire_hash`, `user_org_id`, `user_org_rol`, `user_com_id`) VALUES
(1, 'admin', 'active', 'jormar.arellano@gmail.com', '$P$B2.is9I-uSV4FACOOoDAioH.NfMjbS.', 'Jormar', 'Arellano', 'm', '18760123', '04125740000', '', 'Ojo de Agua - Baruta', '2011-10-12', '', '0000-00-00 00:00:00', 1, 'super', 1),
(2, 'regular', 'active', 'prueba@a.com', '$P$B2.is9I-uSV4FACOOoDAioH.NfMjbS.', 'Prueba', 'Perez', 'm', '321321', '111111', '', 'Ojo de Agua - Alguna', '2011-10-12', '', '0000-00-00 00:00:00', 1, 'admin', 1),
(3, 'regular', 'active', 'prueba2@a.com', '$P$B2.is9I-uSV4FACOOoDAioH.NfMjbS.', 'Prueba 2', 'Gonzalez', 'f', '654654', '222222', '987987', 'Su dirección', '2011-10-13', '', '0000-00-00 00:00:00', 1, 'miembro', 1),
(4, 'regular', 'active', 'prueba3@a.com', '$P$Bq8Q3Zlzasr67vDTgksGABf/bVB4Hv/', 'Prueba 3', 'Pino', 'm', '987987', '333333', '987987', 'Otra dirección', '2011-10-14', '', '0000-00-00 00:00:00', 2, 'super', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aldia_usuario_participa`
--

CREATE TABLE IF NOT EXISTS `aldia_usuario_participa` (
  `proy_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `rol` varchar(45) NOT NULL COMMENT 'El roll que desempena un usuario en el proyecto.\ncreator, otro...',
  `p_modif_datos` tinyint(1) NOT NULL DEFAULT '0',
  `p_modif_repre` tinyint(1) NOT NULL DEFAULT '0',
  `p_ver_plan` tinyint(1) NOT NULL DEFAULT '0',
  `p_modif_activ` tinyint(1) NOT NULL DEFAULT '0',
  `p_modif_fase` tinyint(1) NOT NULL DEFAULT '0',
  `p_modif_histo` tinyint(1) NOT NULL DEFAULT '0',
  `p_export` tinyint(1) NOT NULL DEFAULT '0',
  `p_modif_inver` varchar(45) NOT NULL,
  PRIMARY KEY (`proy_id`,`user_id`),
  KEY `fk_aldia_proyecto_has_aldia_usuarios_aldia_usuarios1` (`user_id`),
  KEY `fk_aldia_proyecto_has_aldia_usuarios_aldia_proyecto1` (`proy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `aldia_usuario_participa`
--

INSERT INTO `aldia_usuario_participa` (`proy_id`, `user_id`, `rol`, `p_modif_datos`, `p_modif_repre`, `p_ver_plan`, `p_modif_activ`, `p_modif_fase`, `p_modif_histo`, `p_export`, `p_modif_inver`) VALUES
(1, 1, 'Creador', 1, 1, 1, 1, 1, 1, 1, '1'),
(2, 1, 'Creador', 1, 1, 1, 1, 1, 1, 1, '1'),
(3, 1, 'Creador', 1, 1, 1, 1, 1, 1, 1, '1');
