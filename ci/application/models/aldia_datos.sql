-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-11-2011 a las 14:50:22
-- Versión del servidor: 5.1.54
-- Versión de PHP: 5.3.5-1ubuntu7.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `aldia`
--

--
-- Volcar la base de datos para la tabla `aldia_actividades`
--


--
-- Volcar la base de datos para la tabla `aldia_comunidad`
--

INSERT INTO `aldia_comunidad` (`com_id`, `com_nombre`, `com_habitantes`, `com_familias`, `com_estado`, `com_municipio`, `com_parroquia`, `com_area_geo`) VALUES
(1, 'Ojo de Agua', 4000, 1000, 'Miranda', 'Baruta', 'Nuestra Sr. del Rosario', '');

--
-- Volcar la base de datos para la tabla `aldia_config`
--


--
-- Volcar la base de datos para la tabla `aldia_fase`
--


--
-- Volcar la base de datos para la tabla `aldia_historico`
--


--
-- Volcar la base de datos para la tabla `aldia_organizacion`
--

INSERT INTO `aldia_organizacion` (`org_id`, `org_com_id`, `org_nombre`, `org_sectores`, `org_desc`) VALUES
(1, 1, 'Consejo Comunal', 'Los Pinos', 'Consejo Comunal de la comunidad Ojo de Agua'),
(2, 1, 'Sociedad Civil', '', '');

--
-- Volcar la base de datos para la tabla `aldia_pages`
--


--
-- Volcar la base de datos para la tabla `aldia_plan`
--


--
-- Volcar la base de datos para la tabla `aldia_proyectos`
--

INSERT INTO `aldia_proyectos` (`proy_id`, `proy_com_id`, `proy_fecha_creacion`, `proy_status`, `proy_tipo`, `proy_titulo`, `proy_justificacion`, `proy_obj_gen`, `proy_obj_esp`, `proy_cobertura_geo`, `proy_benef`, `proy_fam_benf_direc`, `proy_fam_benf_indirec`, `proy_resultado`, `proy_impacto`, `proy_fecha_culm`, `proy_fecha_fin`, `proy_costo`, `proy_fase_id`, `proy_org_id`) VALUES
(1, 1, '2011-11-25', 'disabled', 'social', 'Proyecto de prueba', '&lt;p&gt;&lt;span class=&quot;Apple-style-span&quot; style=&quot;font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt lorem sed arcu venenatis ac semper tellus consequat. Nulla id eros non dui commodo vehicula in eu nisi. Morbi ullamcorper fermentum eleifend. In sed massa vitae quam euismod ornare vitae euismod quam. Mauris at erat quis massa fringilla mattis at quis neque. Pellentesque leo est, consequat sed eleifend in, luctus in arcu. Nunc metus dui, ornare et imperdiet vel, congue quis mi. Praesent facilisis iaculis urna vel rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span class=&quot;Apple-style-span&quot; style=&quot;font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt lorem sed arcu venenatis ac semper tellus consequat. Nulla id eros non dui commodo vehicula in eu nisi. Morbi ullamcorper fermentum eleifend. In sed massa vitae quam euismod ornare vitae euismod quam. Mauris at erat quis massa fringilla mattis at quis neque. Pellentesque leo est, consequat sed eleifend in, luctus in arcu. Nunc metus dui, ornare et imperdiet vel, congue quis mi. Praesent facilisis iaculis urna vel rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/span&gt;&lt;/p&gt;', '', '', '', 0, 0, '', '', '2011-11-09', '0000-00-00', 0, 1, 1),
(2, 1, '2011-11-25', 'disabled', 'infraestructura', 'titulo', '&lt;p&gt;&lt;span class=&quot;Apple-style-span&quot; style=&quot;font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px;&quot;&gt;Justificaci&amp;oacute;n &amp;nbsp;- &amp;nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt lorem sed arcu venenatis ac semper tellus consequat. Nulla id eros non dui commodo vehicula in eu nisi. Morbi ullamcorper fermentum eleifend. In sed massa vitae quam euismod ornare vitae euismod quam. Mauris at erat quis massa fringilla mattis at quis neque. Pellentesque leo est, consequat sed eleifend in, luctus in arcu. Nunc metus dui, ornare et imperdiet vel, congue quis mi. Praesent facilisis iaculis urna vel rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span class=&quot;Apple-style-span&quot; style=&quot;font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px;&quot;&gt;General &amp;nbsp;- &amp;nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt lorem sed arcu venenatis ac semper tellus consequat. Nulla id eros non dui commodo vehicula in eu nisi. Morbi ullamcorper fermentum eleifend. In sed massa vitae quam euismod ornare vitae euismod quam. Mauris at erat quis massa fringilla mattis at quis neque. Pellentesque leo est, consequat sed eleifend in, luctus in arcu. Nunc metus dui, ornare et imperdiet vel, congue quis mi. Praesent facilisis iaculis urna vel rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;especificos&lt;/p&gt;', '&lt;p&gt;geografico&lt;/p&gt;', '&lt;p&gt;Beneficiarios&lt;/p&gt;', 10, 20, '&lt;p&gt;Resultados esperados&lt;/p&gt;', '&lt;p&gt;Impacto esperado&lt;/p&gt;', '2011-11-30', '0000-00-00', 0, 1, 1);

--
-- Volcar la base de datos para la tabla `aldia_sessions`
--

INSERT INTO `aldia_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('cf7e727f85fc7ffce323bac19bce72e7', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', 1322331181, 'a:1:{s:9:"user_data";s:0:"";}'),
('a45088c0c2c5dfedffda54261fee882a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', 1322335180, 'a:3:{s:9:"user_data";s:0:"";s:7:"islogin";b:1;s:4:"user";a:18:{s:7:"user_id";s:1:"1";s:9:"user_type";s:5:"admin";s:11:"user_status";s:6:"active";s:10:"user_email";s:25:"jormar.arellano@gmail.com";s:9:"user_pass";s:34:"$P$B2.is9I-uSV4FACOOoDAioH.NfMjbS.";s:11:"user_nombre";s:8:"Jormar M";s:13:"user_apellido";s:8:"Arellano";s:8:"user_sex";s:1:"m";s:7:"user_ci";s:8:"18760123";s:9:"user_telf";s:11:"04125740000";s:13:"user_telf_alt";s:0:"";s:8:"user_dir";s:20:"Ojo de Agua - Baruta";s:15:"user_registrado";s:10:"2011-10-12";s:9:"user_hash";s:0:"";s:16:"user_expire_hash";s:19:"0000-00-00 00:00:00";s:11:"user_org_id";s:1:"1";s:12:"user_org_rol";s:5:"super";s:11:"user_com_id";s:1:"1";}}');

--
-- Volcar la base de datos para la tabla `aldia_usuarios`
--

INSERT INTO `aldia_usuarios` (`user_id`, `user_type`, `user_status`, `user_email`, `user_pass`, `user_nombre`, `user_apellido`, `user_sex`, `user_ci`, `user_telf`, `user_telf_alt`, `user_dir`, `user_registrado`, `user_hash`, `user_expire_hash`, `user_org_id`, `user_org_rol`, `user_com_id`) VALUES
(1, 'admin', 'active', 'jormar.arellano@gmail.com', '$P$B2.is9I-uSV4FACOOoDAioH.NfMjbS.', 'Jormar M', 'Arellano', 'm', '18760123', '04125740000', '', 'Ojo de Agua - Baruta', '2011-10-12', '', '0000-00-00 00:00:00', 1, 'super', 1),
(2, 'regular', 'deleted', '', '$P$B8QMLAYbV0QCpSX6.2tZT0dBZKTVV90', 'Otro', 'Usuario', 'm', '5465', '04125748226', '', 'Catia', '2011-11-22', '', '0000-00-00 00:00:00', 0, 'admin', 1),
(3, 'regular', 'active', 'a@a.com', '$P$Bq8Q3Zlzasr67vDTgksGABf/bVB4Hv/', 'Otro', 'Apellido', 'm', '564654', '65454', '65465', 'Catia', '2011-11-23', '', '0000-00-00 00:00:00', 1, 'admin', 1),
(4, 'regular', 'active', 'b@b.com', '$P$BE0fdKqy5BZY80yAhMb4gDCy1b7L04.', 'jormar', 'jormar', 'm', '45464', '46546', '', 'Otro', '2011-11-23', '', '0000-00-00 00:00:00', 1, 'miembro', 1);

--
-- Volcar la base de datos para la tabla `aldia_usuario_participa`
--

