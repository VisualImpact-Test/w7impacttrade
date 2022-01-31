<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-27 14:02:23 --> Unable to connect to the database
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-27 14:02:23 --> Unable to connect to the database
ERROR - 2022-01-27 15:28:59 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:28:59 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2251
ERROR - 2022-01-27 15:28:59 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'ORDER'. - Invalid query: 
			DECLARE @fecha date=getdate();
			SELECT TOP 1  
				idUsuario,idProyecto,fechaIni,fechaFin,estado,porcentaje,
				idPeticion,
				CONVERT(varchar,hora,8) hora,
				CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
				CASE WHEN (porcentaje >= 100) THEN 1 ELSE 0 END actualizado
			FROM 
				ImpactTrade_small.trade.peticionActualizarVisitas
			WHERE 
			idProyecto=
			ORDER BY fechaActualizacion DESC,idPeticion DESC;
ERROR - 2022-01-27 15:35:11 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:35:11 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2251
ERROR - 2022-01-27 15:35:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'ORDER'. - Invalid query: 
			DECLARE @fecha date=getdate();
			SELECT TOP 1  
				idUsuario,idProyecto,fechaIni,fechaFin,estado,porcentaje,
				idPeticion,
				CONVERT(varchar,hora,8) hora,
				CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
				CASE WHEN (porcentaje >= 100) THEN 1 ELSE 0 END actualizado
			FROM 
				ImpactTrade_small.trade.peticionActualizarVisitas
			WHERE 
			idProyecto=
			ORDER BY fechaActualizacion DESC,idPeticion DESC;
ERROR - 2022-01-27 15:35:22 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:42:06 --> Severity: Notice --> Undefined index: fecIni C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1180
ERROR - 2022-01-27 15:42:06 --> Severity: Notice --> Undefined index: fecFin C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1181
ERROR - 2022-01-27 15:42:06 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 15:42:06 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'nombreRuta' no es válido. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_ruta" ("nombreRuta", "fecIni", "numClientes") VALUES ('Ruta demo 2 ', NULL, 0)
ERROR - 2022-01-27 15:42:15 --> Severity: Notice --> Undefined index: fecIni C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1180
ERROR - 2022-01-27 15:42:15 --> Severity: Notice --> Undefined index: fecFin C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1181
ERROR - 2022-01-27 15:42:15 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 15:42:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'nombreRuta' no es válido. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_ruta" ("nombreRuta", "fecIni", "numClientes") VALUES ('Ruta demo 2 ', NULL, 0)
ERROR - 2022-01-27 15:42:24 --> Severity: Notice --> Undefined index: fecIni C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1180
ERROR - 2022-01-27 15:42:24 --> Severity: Notice --> Undefined index: fecFin C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1181
ERROR - 2022-01-27 15:42:24 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 15:42:24 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'nombreRuta' no es válido. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_ruta" ("nombreRuta", "fecIni", "numClientes") VALUES ('Ruta demo 2 ', NULL, 0)
ERROR - 2022-01-27 15:44:05 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:44:28 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 15:49:32 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:49:32 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2251
ERROR - 2022-01-27 15:49:36 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:49:48 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 15:51:15 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 15:52:35 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:03:37 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 16:03:37 --> Severity: Notice --> Undefined index: tipoUsuario C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1184
ERROR - 2022-01-27 16:03:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
		DECLARE @fecIni DATE = '30/01/2022', @fecFin DATE = '05/02/2022';
		SELECT
		pr.idProgRuta
		FROM
		trade.programacion_ruta pr
		JOIN trade.programacion_rutaDet rdt ON pr.idProgRuta = rdt.idProgRuta
		WHERE
		General.dbo.fn_fechaVigente(pr.fecIni,pr.fecFin,@fecIni,@fecFin) = 1
		AND rdt.idUsuario = 
		AND rdt.idTipoUsuario = 
		AND pr.idProyecto = 17
		
ERROR - 2022-01-27 16:05:01 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:05:16 --> Severity: Notice --> Undefined index: idGtm C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1183
ERROR - 2022-01-27 16:05:16 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
		DECLARE @fecIni DATE = '27/01/2022', @fecFin DATE = '30/01/2022';
		SELECT
		pr.idProgRuta
		FROM
		trade.programacion_ruta pr
		JOIN trade.programacion_rutaDet rdt ON pr.idProgRuta = rdt.idProgRuta
		WHERE
		General.dbo.fn_fechaVigente(pr.fecIni,pr.fecFin,@fecIni,@fecFin) = 1
		AND rdt.idUsuario = 
		AND rdt.idTipoUsuario = 1
		AND pr.idProyecto = 17
		
ERROR - 2022-01-27 16:06:18 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:06:37 --> Severity: Notice --> Undefined property: Rutas::$validarRutaUsuario C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-01-27 16:06:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idTipoUsuario' no es válido. - Invalid query: 
		DECLARE @fecIni DATE = '27/01/2022', @fecFin DATE = '31/01/2022';
		SELECT
		pr.idProgRuta
		FROM
		trade.programacion_ruta pr
		JOIN trade.programacion_rutaDet rdt ON pr.idProgRuta = rdt.idProgRuta
		WHERE
		General.dbo.fn_fechaVigente(pr.fecIni,pr.fecFin,@fecIni,@fecFin) = 1
		AND rdt.idUsuario = 1
		AND rdt.idTipoUsuario = 1
		AND pr.idProyecto = 17
		
ERROR - 2022-01-27 16:14:52 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:15:31 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'nombreRuta' no es válido. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_ruta" ("nombreRuta", "fecIni", "numClientes", "fecFin") VALUES ('Ruta demo 2 ', '01/02/2022', 0, '06/02/2022')
ERROR - 2022-01-27 16:15:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Instrucción INSERT en conflicto con la restricción FOREIGN KEY "FK_visitaProgramada_rutaProgramada". El conflicto ha aparecido en la base de datos "ImpactTrade_pg", tabla "trade.programacion_ruta", column 'idProgRuta'. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_visita" ("idProgRuta", "idCliente") VALUES ('153', 33609)
ERROR - 2022-01-27 16:16:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Instrucción INSERT en conflicto con la restricción FOREIGN KEY "FK_visitaProgramada_rutaProgramada". El conflicto ha aparecido en la base de datos "ImpactTrade_pg", tabla "trade.programacion_ruta", column 'idProgRuta'. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_visita" ("idProgRuta", "idCliente") VALUES ('154', 33609)
ERROR - 2022-01-27 16:18:28 --> Severity: Notice --> Undefined offset: 33609 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:28 --> Severity: Notice --> Undefined offset: 33615 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:28 --> Severity: Notice --> Undefined offset: 33618 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:33 --> Severity: Notice --> Undefined offset: 33609 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:33 --> Severity: Notice --> Undefined offset: 33615 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:33 --> Severity: Notice --> Undefined offset: 33618 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:48 --> Severity: Notice --> Undefined offset: 33609 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:48 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:48 --> Severity: Notice --> Undefined offset: 33615 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:48 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:48 --> Severity: Notice --> Undefined offset: 33618 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:18:48 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1147
ERROR - 2022-01-27 16:20:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Instrucción INSERT en conflicto con la restricción FOREIGN KEY "FK_visitaProgramada_rutaProgramada". El conflicto ha aparecido en la base de datos "ImpactTrade_pg", tabla "trade.programacion_ruta", column 'idProgRuta'. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_visita" ("idProgRuta", "idCliente") VALUES ('159', 33609)
ERROR - 2022-01-27 16:23:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Instrucción INSERT en conflicto con la restricción FOREIGN KEY "FK_visitaProgramada_rutaProgramada". El conflicto ha aparecido en la base de datos "ImpactTrade_pg", tabla "trade.programacion_ruta", column 'idProgRuta'. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_visita" ("idProgRuta", "idCliente") VALUES ('161', 33609)
ERROR - 2022-01-27 16:35:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idDia' no es válido. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."programacion_visitaDet" ("idProgVisita", "idDia") VALUES ('23254', 1)
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 10 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1227
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined offset: 11 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1290
ERROR - 2022-01-27 16:37:55 --> Severity: Notice --> Undefined variable: value_c C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1291
ERROR - 2022-01-27 16:37:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'numClientes' no es válido. - Invalid query: UPDATE ImpactTrade_pg.trade.programacion_ruta SET numClientes=9 WHERE idProgRuta = 2163
ERROR - 2022-01-27 16:37:55 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp64\www\w7impacttrade\system\core\Exceptions.php:271) C:\wamp64\www\w7impacttrade\system\core\Common.php 570
ERROR - 2022-01-27 16:41:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'numClientes' no es válido. - Invalid query: UPDATE ImpactTrade_pg.trade.programacion_ruta SET numClientes=9 WHERE idProgRuta = 2164
ERROR - 2022-01-27 16:45:09 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:47:08 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:48:24 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:49:14 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 8 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1228
ERROR - 2022-01-27 16:52:43 --> Severity: Notice --> Undefined offset: 9 C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 1229
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:09:45 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:10:03 --> Severity: Notice --> Undefined index: dia C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 648
ERROR - 2022-01-27 17:15:40 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:21:07 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:07 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:27 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:29 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:29 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:29 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:29 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:29 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:37 --> Unable to connect to the database
ERROR - 2022-01-27 17:21:47 --> Unable to connect to the database
ERROR - 2022-01-27 17:22:01 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:22:15 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:29:15 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:32:06 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:32:23 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:32:43 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 17:34:16 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 18:01:08 --> Severity: Notice --> Undefined variable: iprg C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\master\Rutas.php 519
ERROR - 2022-01-27 18:01:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de '='. - Invalid query: DELETE FROM ImpactTrade_pg.trade.programacion_rutaDescanso WHERE idProgRuta =
ERROR - 2022-01-27 18:05:52 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 19:36:36 --> Unable to connect to the database
ERROR - 2022-01-27 19:57:30 --> Unable to connect to the database
ERROR - 2022-01-27 21:11:51 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Cuando se especifica SELECT DISTINCT, los elementos de ORDER BY deben aparecer en la lista de selección. - Invalid query: 
		DECLARE @fecha date=GETDATE();
		SELECT DISTINCT py.idProyecto AS id
		, ISNULL(py.nombreCorto,py.nombre)  
		FROM trade.proyecto py 
		JOIN trade.usuario_historico uh ON py.idProyecto = uh.idProyecto
			AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
			AND uh.idAplicacion IN(2)
			AND uh.estado = 1
		WHERE py.estado = 1 AND py.idCuenta = 2 
		AND uh.idUsuario = 1
		ORDER BY py.nombre
ERROR - 2022-01-27 21:14:12 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:14:42 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:16:56 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:17:24 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:17:44 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:29:21 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Cuando se especifica SELECT DISTINCT, los elementos de ORDER BY deben aparecer en la lista de selección. - Invalid query: 
		DECLARE @fecha date=GETDATE();
		SELECT DISTINCT py.idProyecto AS id
		, ISNULL(py.nombreCorto,py.nombre) ,'15' as idSelect 
		FROM trade.proyecto py 
		JOIN trade.usuario_historico uh ON py.idProyecto = uh.idProyecto
			AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
			AND uh.idAplicacion IN(2)
			AND uh.estado = 1
		WHERE py.estado = 1 
		AND uh.idUsuario = 1
		ORDER BY nombre
ERROR - 2022-01-27 21:31:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Cuando se especifica SELECT DISTINCT, los elementos de ORDER BY deben aparecer en la lista de selección. - Invalid query: 
		DECLARE @fecha date=GETDATE();
		SELECT DISTINCT py.idProyecto AS id
		, ISNULL(py.nombreCorto,py.nombre) ,'15' as idSelect 
		FROM trade.proyecto py 
		JOIN trade.usuario_historico uh ON py.idProyecto = uh.idProyecto
			AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
			AND uh.idAplicacion IN(2)
			AND uh.estado = 1
		WHERE py.estado = 1 
		AND uh.idUsuario = 1
		ORDER BY nombre
ERROR - 2022-01-27 21:31:43 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:31:43 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:31:52 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:31:53 --> Severity: error --> Exception: Too few arguments to function Carga_masiva::procesar_peticiones_actualizar_visitas(), 0 passed in C:\wamp64\www\w7impacttrade\system\core\CodeIgniter.php on line 532 and exactly 1 expected C:\wamp64\www\w7impacttrade\application\controllers\Carga_masiva.php 2251
ERROR - 2022-01-27 21:31:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'ORDER'. - Invalid query: 
			DECLARE @fecha date=getdate();
			SELECT TOP 1  
				idUsuario,idProyecto,fechaIni,fechaFin,estado,porcentaje,
				idPeticion,
				CONVERT(varchar,hora,8) hora,
				CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
				CASE WHEN (porcentaje >= 100) THEN 1 ELSE 0 END actualizado
			FROM 
				ImpactTrade_small.trade.peticionActualizarVisitas
			WHERE 
			idProyecto=
			ORDER BY fechaActualizacion DESC,idPeticion DESC;
ERROR - 2022-01-27 21:32:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Cuando se especifica SELECT DISTINCT, los elementos de ORDER BY deben aparecer en la lista de selección. - Invalid query: 
		DECLARE @fecha date=GETDATE();
		SELECT DISTINCT py.idProyecto AS id
		, ISNULL(py.nombreCorto,py.nombre) ,'15' as idSelect 
		FROM trade.proyecto py 
		JOIN trade.usuario_historico uh ON py.idProyecto = uh.idProyecto
			AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
			AND uh.idAplicacion IN(2)
			AND uh.estado = 1
		WHERE py.estado = 1 
		AND uh.idUsuario = 1
		ORDER BY nombre
ERROR - 2022-01-27 21:33:00 --> Severity: Notice --> Undefined index: nombre C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 695
ERROR - 2022-01-27 21:33:00 --> Severity: Notice --> Undefined index: nombre C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 695
ERROR - 2022-01-27 21:33:00 --> Severity: Notice --> Undefined index: nombre C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 695
ERROR - 2022-01-27 21:33:00 --> Severity: Notice --> Undefined index: nombre C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 695
ERROR - 2022-01-27 21:33:00 --> Severity: Notice --> Undefined index: nombre C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 695
ERROR - 2022-01-27 21:33:00 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:33:00 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:33:02 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:33:02 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:33:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:33:03 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:34:30 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 21:34:31 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:50:19 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 21:59:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'nombre' es ambiguo. - Invalid query: 
            SELECT
            *
            FROM trade.grupoCanal AS gc
            JOIN trade.proyectoGrupoCanal pgc ON gc.idGrupoCanal = pgc.idGrupoCanal
            WHERE
            nombre = 'Grupo canal test' AND pgc.idProyecto = 15
        
ERROR - 2022-01-27 22:09:33 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:09:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:09:40 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:09:49 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:22:52 --> Severity: Notice --> Undefined property: Home::$idCuenta C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-01-27 22:22:57 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:22:59 --> Severity: Notice --> Undefined property: Home::$idCuenta C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-01-27 22:23:24 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:24:17 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:24:51 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:25:13 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:25:43 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:27:32 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:27:52 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:30:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "trade.idProyectoGrupoCanal" no se pudo enlazar. - Invalid query: UPDATE "trade"."proyectoGrupoCanal" SET "estado" = CASE 
WHEN "trade"."idProyectoGrupoCanal" = 19 THEN 0
ELSE "estado" END, "fechaModificacion" = CASE 
WHEN "trade"."idProyectoGrupoCanal" = 19 THEN '2022-01-27T22:30:50'
ELSE "fechaModificacion" END
WHERE "trade"."idProyectoGrupoCanal" IN(19)
ERROR - 2022-01-27 22:31:25 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'fechaModificacion' no es válido. - Invalid query: UPDATE "trade"."proyectoGrupoCanal" SET "estado" = CASE 
WHEN "idProyectoGrupoCanal" = 19 THEN 0
ELSE "estado" END, "fechaModificacion" = CASE 
WHEN "idProyectoGrupoCanal" = 19 THEN '2022-01-27T22:31:25'
ELSE "fechaModificacion" END
WHERE "idProyectoGrupoCanal" IN(19)
ERROR - 2022-01-27 22:35:25 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:25 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:25 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:25 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:25 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:33 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:33 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:33 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:33 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:33 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:36 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:36 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:36 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:36 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:36 --> Severity: Notice --> Undefined index: idProyectoGrupoCanal C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\canalTabla.php 21
ERROR - 2022-01-27 22:35:55 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:35:55 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:35:56 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:36:07 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:36:07 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:36:08 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:36:56 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:37:44 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:38:16 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:39:22 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:39:22 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:39:24 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:39:42 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:39:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:39:44 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-27 22:47:21 --> Severity: Notice --> Undefined variable: grupos C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:47:21 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\Configuraciones\Maestros\CuentasCanales\index.php 83
ERROR - 2022-01-27 22:47:22 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
