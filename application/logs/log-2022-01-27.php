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
