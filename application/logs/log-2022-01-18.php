<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-18 00:00:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-18 00:01:29 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) C:\wamp64\www\w7impacttrade\application\core\MY_Controller.php 45
ERROR - 2022-01-18 00:01:50 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:01:50 --> Severity: Notice --> Undefined variable: _SESSION C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2307
ERROR - 2022-01-18 00:01:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_small.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 00:03:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-18 00:03:46 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-18 00:04:23 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:04:23 --> Severity: Notice --> Undefined variable: _SESSION C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2307
ERROR - 2022-01-18 00:04:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_small.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 00:05:00 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:05:00 --> Severity: Notice --> Undefined variable: _SESSION C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2307
ERROR - 2022-01-18 00:05:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_small.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 00:06:40 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:06:40 --> Severity: Notice --> Undefined variable: _SESSION C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2307
ERROR - 2022-01-18 00:06:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_small.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 00:06:47 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:06:47 --> Severity: Notice --> Undefined variable: _SESSION C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2307
ERROR - 2022-01-18 00:06:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_small.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 00:07:23 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:15:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:48 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:16:58 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:30 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:30 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:30 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:30 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:30 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:30 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:44 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:48 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:17:58 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:35 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:35 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:35 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:35 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:35 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:35 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:18:58 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:40 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:44 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:19:58 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:20:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:21:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:22:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:23:45 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:03 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:18 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:24:50 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:08 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:18 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:23 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:25:55 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:18 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:23 --> Unable to connect to the database
ERROR - 2022-01-18 00:26:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:00 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:15 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:15 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:15 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:18 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:23 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:27:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:05 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:20 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:20 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:20 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:23 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:28:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:29:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:30:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:31:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:32:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:33:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:34:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:35:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:36:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:37:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:38:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:39:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:40:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:41:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:42:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:10 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:25 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:43:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:44:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:45:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:46:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:27 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:47:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:11 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:26 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:28 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:33 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:38 --> Unable to connect to the database
ERROR - 2022-01-18 00:48:43 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:12 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:13 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:49:53 --> Unable to connect to the database
ERROR - 2022-01-18 00:50:05 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 00:50:06 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_aje.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_pg.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_pg.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 
		UNION
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_pg.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_aje.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1
		UNION 
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_pg.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 00:51:46 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 01:22:26 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 01:22:26 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_aje.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_pg.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_pg.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 
		UNION
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_pg.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_aje.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1
		UNION 
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			ImpactTrade_pg.trade.peticionActualizarVisitas v
			JOIN ImpactTrade_small.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-18 01:23:43 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 01:57:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		
ERROR - 2022-01-18 01:57:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		
ERROR - 2022-01-18 01:57:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		
ERROR - 2022-01-18 01:57:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		
ERROR - 2022-01-18 01:57:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:58:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 01:59:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:00:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:07 --> Severity: error --> Exception: syntax error, unexpected '}', expecting '(' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 301
ERROR - 2022-01-18 02:01:12 --> Severity: error --> Exception: syntax error, unexpected '}', expecting '(' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 301
ERROR - 2022-01-18 02:01:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:01:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:02:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:31 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:03:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:47 --> Severity: Compile Error --> Cannot redeclare M_control::get_peticion_actualizar_visitas_det() C:\wamp64\www\w7impacttrade\application\models\M_control.php 921
ERROR - 2022-01-18 02:04:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:04:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:05:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:06:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:07:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:08:32 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\models\M_control.php 923
ERROR - 2022-01-18 02:08:37 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\models\M_control.php 923
ERROR - 2022-01-18 02:08:42 --> Severity: error --> Exception: syntax error, unexpected '}', expecting ';' C:\wamp64\www\w7impacttrade\application\models\M_control.php 924
ERROR - 2022-01-18 02:08:47 --> Severity: error --> Exception: syntax error, unexpected '}', expecting ';' C:\wamp64\www\w7impacttrade\application\models\M_control.php 924
ERROR - 2022-01-18 02:08:52 --> Severity: error --> Exception: syntax error, unexpected '}', expecting ';' C:\wamp64\www\w7impacttrade\application\models\M_control.php 924
ERROR - 2022-01-18 02:08:57 --> Severity: error --> Exception: syntax error, unexpected '}', expecting ';' C:\wamp64\www\w7impacttrade\application\models\M_control.php 924
ERROR - 2022-01-18 02:09:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:34 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:09:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:10:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:11:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:12:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:13:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:14:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:15:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:16:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:17:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:18:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:19:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:20:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:21:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:21:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:21:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:21:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:22:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:22:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:23:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:23:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:24:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:24:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:25:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:25:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:26:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:26:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:36 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:27:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:28:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:29:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:30:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 77
		AND pdet.notificado = 1
		
ERROR - 2022-01-18 02:30:30 --> Could not find the language line "update_batch() called with no data"
ERROR - 2022-01-18 02:30:32 --> Could not find the language line "update_batch() called with no data"
ERROR - 2022-01-18 02:31:03 --> Could not find the language line "update_batch() called with no data"
ERROR - 2022-01-18 02:32:48 --> Could not find the language line "update_batch() called with no data"
ERROR - 2022-01-18 02:32:55 --> Could not find the language line "update_batch() called with no data"
ERROR - 2022-01-18 02:33:18 --> Could not find the language line "update_batch() called with no data"
ERROR - 2022-01-18 02:33:32 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 03:01:56 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 03:03:49 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 03:07:46 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 03:10:57 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 03:25:30 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 04:39:56 --> Unable to connect to the database
ERROR - 2022-01-18 04:40:02 --> Unable to connect to the database
ERROR - 2022-01-18 14:23:54 --> Unable to connect to the database
ERROR - 2022-01-18 14:38:19 --> Unable to connect to the database
ERROR - 2022-01-18 14:58:11 --> Unable to connect to the database
ERROR - 2022-01-18 14:58:11 --> Unable to connect to the database
ERROR - 2022-01-18 14:59:43 --> Severity: error --> Exception: Too few arguments to function Home::execInBackground(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Home.php 436
ERROR - 2022-01-18 15:08:31 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:10:20 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:12:13 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:14:29 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:20:06 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:24:36 --> Severity: Compile Error --> Cannot redeclare execInBackground() (previously declared in C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php:1706) C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 1726
ERROR - 2022-01-18 15:29:44 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:32:31 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:49:08 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 15:52:55 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 16:06:42 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 16:09:51 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 16:11:41 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 16:20:42 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 16:51:05 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2301
ERROR - 2022-01-18 16:58:14 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:19:20 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:22:08 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:25:20 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:27:28 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:34:22 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:34:53 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:39:48 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:45:38 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:47:56 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:51:14 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 17:59:40 --> Severity: Notice --> Undefined index: idProyecto C:\wamp64\www\w7impacttrade\application\models\M_control.php 55
ERROR - 2022-01-18 17:59:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
			DECLARE @fecha date=getdate();
			SELECT
				cu.idCuenta,
				cu.nombre AS cuenta,
				cu.urlCSS AS cssCuenta,
				cu.urlLogo AS logoCuenta,
				cu.baseDatos AS sessBDCuenta,
				py.idProyecto,
				py.nombre AS proyecto,
				ISNULL(cu.abreviacion,'CUENTA') abreviacionCuenta,
				uh.idUsuarioHist,
				uh.idTipoUsuario
				
			FROM trade.cuenta cu
			JOIN trade.proyecto py ON cu.idCuenta = py.idCuenta
			JOIN trade.usuario_historico uh ON py.idProyecto = uh.idProyecto
				AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
				AND uh.idAplicacion IN(2)
				AND uh.estado = 1
			WHERE cu.idCuenta = 2
			AND py.idProyecto = 
			AND uh.idUsuario = 1
ERROR - 2022-01-18 18:05:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:06:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:07:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:08:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:09:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:10:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:11:53 --> Unable to connect to the database
ERROR - 2022-01-18 18:12:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:13:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:14:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:15:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:16:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:17:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:18:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:19:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:20:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:21:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:22:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:23:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:24:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:25:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:26:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:27:55 --> Unable to connect to the database
ERROR - 2022-01-18 18:28:24 --> Unable to connect to the database
ERROR - 2022-01-18 18:29:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:30:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:31:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:32:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:33:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:34:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:35:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:36:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:37:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:38:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:39:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:40:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:41:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:42:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:43:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:44:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:45:53 --> Unable to connect to the database
ERROR - 2022-01-18 18:46:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:47:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:48:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:49:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:50:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:51:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:52:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:53:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:54:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:55:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:56:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:57:52 --> Unable to connect to the database
ERROR - 2022-01-18 18:58:51 --> Unable to connect to the database
ERROR - 2022-01-18 18:59:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:00:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:01:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:02:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:03:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:04:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:05:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:06:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:07:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:08:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:09:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:10:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:11:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:12:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:13:52 --> Unable to connect to the database
ERROR - 2022-01-18 19:14:51 --> Unable to connect to the database
ERROR - 2022-01-18 19:15:53 --> Unable to connect to the database
ERROR - 2022-01-18 19:15:53 --> Unable to connect to the database
ERROR - 2022-01-18 19:17:00 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:18:58 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:21:34 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:23:42 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:26:13 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:28:34 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:30:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Se especificó una expresión no booleana en un contexto donde se esperaba una condición, cerca de 'demo'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		WHERE 
		pdet.idPeticion = 51
		AND pdet.notificado = 0
		AND hora IS NOT NULL
		AND r.demo 
		
ERROR - 2022-01-18 19:32:09 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'FROM'. - Invalid query: 
		SELECT 
		pdet.idPeticionDet,
		r.idUsuario,
		r.nombreUsuario,
		r.idTipoUsuario,
		r.tipoUsuario, 
		r.fecha,
		
		FROM
		ImpactTrade_pg.trade.peticionActualizarVisitasDet pdet
		JOIN ImpactTrade_pg.trade.data_ruta r ON r.idRuta = pdet.idRuta
		JOIN trade.usuario u ON u.idUsuario = r.idUsuario
		WHERE 
		pdet.idPeticion = 51
		AND pdet.notificado = 0
		AND hora IS NOT NULL
		AND (r.demo = 0 OR r.demo IS NULL)
		ORDER BY r.fecha, r.idUsuario
		
ERROR - 2022-01-18 19:33:36 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 19:44:30 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 20:36:32 --> Severity: Warning --> require_once(../phpExcel/Classes/PHPExcel.php): failed to open stream: No such file or directory C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1760
ERROR - 2022-01-18 20:36:32 --> Severity: Compile Error --> require_once(): Failed opening required '../phpExcel/Classes/PHPExcel.php' (include_path='.;C:\php\pear') C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1760
ERROR - 2022-01-18 21:02:02 --> Severity: error --> Exception: Call to undefined method M_rutas::obtener_horarios() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1891
ERROR - 2022-01-18 21:04:03 --> Severity: Notice --> Undefined variable: rs_permisos_clientes C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1899
ERROR - 2022-01-18 21:04:03 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1899
ERROR - 2022-01-18 21:04:09 --> Severity: Notice --> Undefined variable: rs_permisos_clientes C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1899
ERROR - 2022-01-18 21:04:09 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1899
ERROR - 2022-01-18 21:04:41 --> Severity: Notice --> Undefined variable: rs_permisos_clientes C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1899
ERROR - 2022-01-18 21:04:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1899
ERROR - 2022-01-18 21:36:04 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 21:36:04 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idTipoUsuario' no es válido. - Invalid query: 
			 SELECT 
				c.idCarga,
				c.fecIni,
				c.fecFin,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.generado,
				c.idCuenta,
				c.idProyecto,
				c.idTipoUsuario
			FROM 
				ImpactTrade_aje.trade.cargaRuta c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
			UNION

			SELECT 
				c.idCarga,
				c.fecIni,
				c.fecFin,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.generado,
				c.idCuenta,
				c.idProyecto,
				c.idTipoUsuario
			FROM 
				ImpactTrade_pg.trade.cargaRuta c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

			SELECT 
				c.idCarga,
				c.fecIni,
				c.fecFin,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.generado,
				c.idCuenta,
				c.idProyecto,
				c.idTipoUsuario
			FROM 
				ImpactTrade_small.trade.cargaRuta c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		
ERROR - 2022-01-18 21:42:41 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 22:15:10 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 22:21:20 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 22:46:24 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 22:48:34 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 22:54:47 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 22:58:49 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 23:00:23 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-18 23:02:36 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
