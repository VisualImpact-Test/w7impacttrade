<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>ERROR - 2022-01-17 21:45:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto '.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta
		FROM 
			.trade.peticionActualizarVisitas v
			JOIN .trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-17 21:46:28 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto '.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta
		FROM 
			.trade.peticionActualizarVisitas v
			JOIN .trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-17 21:47:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de '.'. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta
		FROM 
			impactTrade_pg.trade.peticionActualizarVisitas v
			JOIN impactTrade_pg.trade.peticionActualizarVisitas v
			.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-17 21:48:06 --> Severity: Notice --> Undefined index: idRuta C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2315
ERROR - 2022-01-17 21:48:06 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de '='. - Invalid query: 
			UPDATE ImpactTrade_pg.trade.data_visita
			SET estado=estado
			where idRuta=
ERROR - 2022-01-17 21:48:42 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\wamp64\www\w7impacttrade\application\models\M_carga_masiva.php 2126
ERROR - 2022-01-17 21:54:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto '.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			.trade.peticionActualizarVisitas v
			JOIN .trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-17 21:56:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto '.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			.trade.peticionActualizarVisitas v
			JOIN .trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-17 22:01:59 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error al convertir una cadena de caracteres en fecha y/u hora. - Invalid query: 
        DECLARE @fecha DATE = '17/01/2022 - 17/01/2022';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = 3 
        
ERROR - 2022-01-17 22:11:42 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:12:49 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:14:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_pg.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
			DECLARE @fecha date=GETDATE();
			UPDATE ImpactTrade_pg.trade.peticionActualizarVisitasDet
				SET estado=0,hora=GETDATE()
			WHERE 
				idPeticion=42 AND idRuta=107899 
			;
ERROR - 2022-01-17 22:15:51 --> Unable to connect to the database
ERROR - 2022-01-17 22:15:52 --> Unable to connect to the database
ERROR - 2022-01-17 22:16:39 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_pg.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: INSERT INTO ImpactTrade_pg.trade.peticionActualizarVisitasDet
		SELECT '22',idRuta,1,null FROM ImpactTrade_pg.trade.data_ruta WHERE fecha  BETWEEN '01/12/2021' AND '30/12/2021' AND idProyecto='3'
ERROR - 2022-01-17 22:17:09 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:20:48 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:30:49 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server]Unspecified error occurred on SQL Server. Connection may have been terminated by the server. - Invalid query: 
			UPDATE ImpactTrade_pg.trade.data_visita
			SET estado=estado
			where idRuta=103811
ERROR - 2022-01-17 22:30:49 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server]Unspecified error occurred on SQL Server. Connection may have been terminated by the server. - Invalid query: 
			UPDATE ImpactTrade_pg.trade.data_visita
			SET estado=estado
			where idRuta=106212
ERROR - 2022-01-17 22:31:30 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:32:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server]Unspecified error occurred on SQL Server. Connection may have been terminated by the server. - Invalid query: 
			UPDATE ImpactTrade_pg.trade.data_visita
			SET estado=estado
			where idRuta=104510
ERROR - 2022-01-17 22:32:29 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:41:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server]Unspecified error occurred on SQL Server. Connection may have been terminated by the server. - Invalid query: 
			UPDATE ImpactTrade_pg.trade.data_visita
			SET estado=estado
			where idRuta=105649
ERROR - 2022-01-17 22:42:09 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:46:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'CONVERT'. - Invalid query: 
			DECLARE @fecha date=getdate();
			SELECT TOP 1  
				idUsuario,idProyecto,fechaIni,fechaFin,estado,porcentaje,
				idPeticion
				CONVERT(varchar,hora,8) hora,
				CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
				CASE WHEN (porcentaje IS NOT NULL) THEN 1 ELSE 0 END actualizado
			FROM 
				ImpactTrade_pg.trade.peticionActualizarVisitas
			WHERE 
			idProyecto=3
			ORDER BY fechaActualizacion DESC,idPeticion DESC;
ERROR - 2022-01-17 22:47:12 --> Severity: error --> Exception: syntax error, unexpected 'if' (T_IF) C:\wamp64\www\w7impacttrade\application\controllers\Control.php 293
ERROR - 2022-01-17 22:47:17 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 293
ERROR - 2022-01-17 22:47:17 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 293
ERROR - 2022-01-17 22:47:22 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 293
ERROR - 2022-01-17 22:47:27 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 293
ERROR - 2022-01-17 22:47:27 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\www\w7impacttrade\application\controllers\Control.php 293
ERROR - 2022-01-17 22:52:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna o los valores especificados no corresponden a la definición de la tabla. - Invalid query: INSERT INTO ImpactTrade_pg.trade.peticionActualizarVisitasDet
		SELECT '28',idRuta,1,null FROM ImpactTrade_pg.trade.data_ruta WHERE fecha  BETWEEN '15/12/2021' AND '15/12/2021' AND idProyecto='3'
ERROR - 2022-01-17 22:54:41 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 22:58:39 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:00:52 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:00:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto '.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			.trade.peticionActualizarVisitas v
			JOIN .trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 

			
ERROR - 2022-01-17 23:02:47 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:02:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
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

			
ERROR - 2022-01-17 23:03:57 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:03:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
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

			
ERROR - 2022-01-17 23:06:35 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:07:00 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:07:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
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

			
ERROR - 2022-01-17 23:07:13 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:07:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
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

			
ERROR - 2022-01-17 23:11:01 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:16:36 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:21:42 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:21:42 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2301
ERROR - 2022-01-17 23:33:19 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:33:20 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2301
ERROR - 2022-01-17 23:33:50 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:54:55 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-17 23:54:55 --> Severity: Notice --> Undefined variable: _SESSION C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2307
ERROR - 2022-01-17 23:54:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'ImpactTrade_small.trade.peticionActualizarVisitasDet' no es válido. - Invalid query: 
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

			
ERROR - 2022-01-17 23:55:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:55:59 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:56:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:56:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:56:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:56:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-17 23:56:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-17 23:57:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-17 23:58:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-17 23:58:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:58:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:58:36 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:16 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: 
        DECLARE @fecha DATE = '2022-01-17';
        SELECT
        COUNT(u.idUsuario) AS cantidadGtm
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
        AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
        LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
        LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
        LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
        LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
        LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
        WHERE uh.idTipoUsuario IN(1,18) AND u.demo = 0 AND u.estado = 1 AND uh.idAplicacion IN (1, 4, 8)
         AND py.idProyecto = 3  AND cu.idCuenta = P&G 
        
ERROR - 2022-01-17 23:59:16 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
ERROR - 2022-01-17 23:59:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'P' no es válido. - Invalid query: SELECT 
				tu.idTipoUsuario AS id, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1 AND tuc.idCuenta = P&G 
				ORDER BY tu.nombre
