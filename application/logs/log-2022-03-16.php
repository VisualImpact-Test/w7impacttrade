<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-03-16 14:19:16 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:19:16 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:19:50 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:19:50 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:21:09 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:21:09 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:26:23 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:26:23 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:32:24 --> Severity: Warning --> Illegal offset type in isset or empty C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 573
ERROR - 2022-03-16 14:32:24 --> Severity: Notice --> Undefined index: divHtml C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 663
ERROR - 2022-03-16 14:32:26 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:32:26 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:33:02 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:33:02 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:33:41 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:33:41 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:33:45 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:33:45 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:34:11 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:34:11 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:34:13 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:34:13 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:34:29 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:34:29 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:35:49 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:35:49 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:35:57 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:35:57 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:36:55 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:36:55 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:37:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "ca.nombre" no se pudo enlazar. - Invalid query: 
			SELECT DISTINCT 
				ft.idTipoFoto AS id
				, ft.nombre
			FROM trade.foto_tipo ft
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ft.idGrupoCanal
			WHERE ft.estado = 1 
			 AND ft.idProyecto = 14 AND ft.idGrupoCanal = 5 
			ORDER BY ca.nombre
		
ERROR - 2022-03-16 14:37:15 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:37:15 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:37:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "ca.nombre" no se pudo enlazar. - Invalid query: 
			SELECT DISTINCT 
				ft.idTipoFoto AS id
				, ft.nombre
			FROM trade.foto_tipo ft
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ft.idGrupoCanal
			WHERE ft.estado = 1 
			 AND ft.idProyecto = 14 AND ft.idGrupoCanal = 5 
			ORDER BY ca.nombre
		
ERROR - 2022-03-16 14:37:25 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:37:25 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:37:33 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:37:33 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
ERROR - 2022-03-16 14:39:46 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-03-16 14:39:46 --> Severity: error --> Exception: Call to undefined function sqlsrv_connect() C:\wamp64\www\w7impacttrade\system\database\drivers\sqlsrv\sqlsrv_driver.php 144
