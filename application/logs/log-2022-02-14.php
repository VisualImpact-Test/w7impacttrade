<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-02-14 15:43:22 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 15:47:24 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 16:57:42 --> Severity: Notice --> Undefined property: Visibilidad::$validar_filas_unicas_HT C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-02-14 16:59:00 --> Severity: Notice --> Undefined property: Visibilidad::$validar_filas_unicas_HT C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-02-14 17:04:01 --> Severity: Notice --> Undefined property: Visibilidad::$registrarLista_HT C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-02-14 17:04:02 --> Severity: Notice --> Undefined property: Visibilidad::$registrarLista_HT C:\wamp64\www\w7impacttrade\system\core\Model.php 73
ERROR - 2022-02-14 17:07:00 --> Severity: Notice --> Undefined index: lista C:\wamp64\www\w7impacttrade\application\models\configuraciones\gestion\M_visibilidad.php 478
ERROR - 2022-02-14 17:07:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de '('. - Invalid query: INSERT INTO  ("idGrupoCanal", "FecIni", "idProyecto", "idCanal") VALUES ('4', '14/02/2022', '3', 2)
ERROR - 2022-02-14 17:07:04 --> Severity: Notice --> Undefined index: lista C:\wamp64\www\w7impacttrade\application\models\configuraciones\gestion\M_visibilidad.php 478
ERROR - 2022-02-14 17:07:04 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de '('. - Invalid query: INSERT INTO  ("idGrupoCanal", "FecIni", "idProyecto", "idCanal") VALUES ('4', '14/02/2022', '3', 2)
ERROR - 2022-02-14 17:29:21 --> Severity: Notice --> Undefined property: Visibilidad::$m_tipopremiacion C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\gestion\Visibilidad.php 718
ERROR - 2022-02-14 17:29:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\gestion\Visibilidad.php 718
ERROR - 2022-02-14 17:31:48 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 17:45:48 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 17:46:32 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 17:56:55 --> Severity: Notice --> Indirect modification of overloaded property M_visibilidad::$aSessTrack has no effect C:\wamp64\www\w7impacttrade\application\models\configuraciones\gestion\M_visibilidad.php 284
ERROR - 2022-02-14 17:56:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idListPremiacion' no es válido. - Invalid query: 
				DECLARE @fecIni DATE = '14/02/2022', @fecFin DATE = '14/02/2022';
				SELECT 
				lst.idListPremiacion
			  , lst.idCanal
			  , lst.idCliente
			  , CONVERT(VARCHAR,lst.fecIni,103) fecIni
			  , CONVERT(VARCHAR,lst.fecFin,103) fecFin
			  , lst.idProyecto
			  , lst.idTipoUsuario
			  , lst.estado
			  , CONVERT(VARCHAR,lst.fechaCreacion,103) fechaCreacion
			  , CONVERT(VARCHAR,lst.fechaModificacion,103) fechaModificacion
			  , p.nombre proyecto
			  , c.nombre canal 
			  , ISNULL(cli.nombreComercial,'-') nombreComercial
			  , ISNULL(cli.razonSocial,'-') razonSocial
			  , cli.codCliente
			  , ut. nombre as tipo
			  , gc.idGrupoCanal
			  , gc.nombre as grupoCanal
			  , e.idPremiacion
			  , e.nombre premiacion
				FROM 
				ImpactTrade_pg.trade.list_sos lst
				LEFT JOIN ImpactTrade_pg.trade.list_sos_det lstd ON lstd.idListPremiacion=lst.idListPremiacion
				LEFT JOIN ImpactTrade_pg.trade.premiacion e ON e.idPremiacion=lstd.idPremiacion
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				LEFT JOIN trade.Usuario_tipo ut ON ut.idTipoUsuario = lst.idTipoUsuario
				WHERE 
				1 = 1
				AND General.dbo.fn_fechaVigente(lst.fecIni,lst.fecFin,@fecIni,@fecFin) = 1 
				  AND p.idProyecto=3 AND cu.idCuenta IN (13,2,3) AND p.idCuenta=3
				ORDER BY lst.fecIni DESC
			
ERROR - 2022-02-14 17:57:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idListPremiacion' no es válido. - Invalid query: 
				DECLARE @fecIni DATE = '14/02/2022', @fecFin DATE = '14/02/2022';
				SELECT 
				lst.idListPremiacion
			  , lst.idCanal
			  , lst.idCliente
			  , CONVERT(VARCHAR,lst.fecIni,103) fecIni
			  , CONVERT(VARCHAR,lst.fecFin,103) fecFin
			  , lst.idProyecto
			  , lst.idTipoUsuario
			  , lst.estado
			  , CONVERT(VARCHAR,lst.fechaCreacion,103) fechaCreacion
			  , CONVERT(VARCHAR,lst.fechaModificacion,103) fechaModificacion
			  , p.nombre proyecto
			  , c.nombre canal 
			  , ISNULL(cli.nombreComercial,'-') nombreComercial
			  , ISNULL(cli.razonSocial,'-') razonSocial
			  , cli.codCliente
			  , ut. nombre as tipo
			  , gc.idGrupoCanal
			  , gc.nombre as grupoCanal
			  , e.idPremiacion
			  , e.nombre premiacion
				FROM 
				ImpactTrade_pg.trade.list_sos lst
				LEFT JOIN ImpactTrade_pg.trade.list_sos_det lstd ON lstd.idListPremiacion=lst.idListPremiacion
				LEFT JOIN ImpactTrade_pg.trade.premiacion e ON e.idPremiacion=lstd.idPremiacion
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				LEFT JOIN trade.Usuario_tipo ut ON ut.idTipoUsuario = lst.idTipoUsuario
				WHERE 
				1 = 1
				AND General.dbo.fn_fechaVigente(lst.fecIni,lst.fecFin,@fecIni,@fecFin) = 1 
				  AND p.idProyecto=3 AND cu.idCuenta IN (13,2,3) AND p.idCuenta=3
				ORDER BY lst.fecIni DESC
			
ERROR - 2022-02-14 17:58:30 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "ut.nombre" no se pudo enlazar. - Invalid query: 
				DECLARE @fecIni DATE = '14/02/2022', @fecFin DATE = '14/02/2022';
				SELECT 
				lst.idListSos
			  , lst.idCanal
			  , lst.idCliente
			  , CONVERT(VARCHAR,lst.fecIni,103) fecIni
			  , CONVERT(VARCHAR,lst.fecFin,103) fecFin
			  , lst.idProyecto
			  , lst.estado
			  , CONVERT(VARCHAR,lst.fechaCreacion,103) fechaCreacion
			  , CONVERT(VARCHAR,lst.fechaModificacion,103) fechaModificacion
			  , p.nombre proyecto
			  , c.nombre canal 
			  , ISNULL(cli.nombreComercial,'-') nombreComercial
			  , ISNULL(cli.razonSocial,'-') razonSocial
			  , cli.codCliente
			  , ut. nombre as tipo
			  , gc.idGrupoCanal
			  , gc.nombre as grupoCanal
			  , ma.idMarca
			  , ma.nombre marca
				FROM 
				ImpactTrade_pg.trade.list_sos lst
				LEFT JOIN ImpactTrade_pg.trade.list_sos_det lstd ON lstd.idListSos=lst.idListSos
				LEFT JOIN trade.producto_marca ma ON ma.idMarca=lstd.idMarca
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				WHERE 
				1 = 1
				AND General.dbo.fn_fechaVigente(lst.fecIni,lst.fecFin,@fecIni,@fecFin) = 1 
				  AND p.idProyecto=3 AND cu.idCuenta IN (13,2,3) AND p.idCuenta=3
				ORDER BY lst.fecIni DESC
			
ERROR - 2022-02-14 17:58:39 --> Severity: error --> Exception: DateTime::__construct(): Failed to parse time string (14/02/2022) at position 0 (1): Unexpected character C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 39
ERROR - 2022-02-14 18:00:05 --> Severity: error --> Exception: DateTime::__construct(): Failed to parse time string (14/02/2022) at position 0 (1): Unexpected character C:\wamp64\www\w7impacttrade\application\helpers\my_helper.php 39
ERROR - 2022-02-14 18:02:34 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 18:02:56 --> Severity: Notice --> Undefined property: Visibilidad::$m_tipopremiacion C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\gestion\Visibilidad.php 989
ERROR - 2022-02-14 18:02:56 --> Severity: error --> Exception: Call to a member function actualizarLista_HT() on null C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\gestion\Visibilidad.php 989
ERROR - 2022-02-14 18:04:29 --> Severity: error --> Exception: Call to undefined method M_visibilidad::actualizarLista_HT() C:\wamp64\www\w7impacttrade\application\controllers\configuraciones\gestion\Visibilidad.php 988
ERROR - 2022-02-14 18:05:01 --> Severity: Notice --> Indirect modification of overloaded property M_visibilidad::$aSessTrack has no effect C:\wamp64\www\w7impacttrade\application\models\configuraciones\gestion\M_visibilidad.php 639
ERROR - 2022-02-14 19:52:29 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 19:53:13 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 20:07:40 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 20:07:45 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 21:54:25 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 21:54:30 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:05:15 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:34:28 --> Severity: Notice --> Undefined variable: tabs C:\wamp64\www\w7impacttrade\application\views\modulos\GestionGerencial\Visibilidad\index.php 12
ERROR - 2022-02-14 22:34:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\GestionGerencial\Visibilidad\index.php 12
ERROR - 2022-02-14 22:34:28 --> Severity: Notice --> Undefined variable: tabs C:\wamp64\www\w7impacttrade\application\views\modulos\GestionGerencial\Visibilidad\index.php 150
ERROR - 2022-02-14 22:34:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\w7impacttrade\application\views\modulos\GestionGerencial\Visibilidad\index.php 150
ERROR - 2022-02-14 22:34:30 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:34:55 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:36:25 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:36:31 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'JOIN'. - Invalid query: 
			DECLARE @fecIni date='14/02/2022',@fecFin date='14/02/2022';
		SELECT
			distinct
			r.idRuta
			, r.fecha
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
			, r.idUsuario
			, r.nombreUsuario
			, r.tipoUsuario
			, v.idVisita
			, v.canal
			, v.idCliente
			, v.codCliente
			, v.nombreComercial, v.razonSocial
			, v.cod_ubigeo
			, ubi.departamento
			, ubi.provincia
			, ubi.distrito
			, v.direccion
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ct.nombre subCanal
			
						, cad.idCadena
						, ba.idBanner
						, ba.nombre AS banner
						, cad.nombre AS cadena
						

		FROM ImpactTrade_pg.trade.data_ruta r
		JOIN ImpactTrade_pg.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
				and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				and uh.idProyecto=r.idProyecto
		JOIN ImpactTrade_pg.trade.data_visitaVisibilidadTrad dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
		JOIN trade.cliente c 
			ON c.idCliente = v.idCliente 
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		JOIN ImpactTrade_pg.trade.cliente_historico ch 
			ON v.idCliente = ch.idCliente AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1 
			AND ch.idProyecto = 
		LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
		LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
		LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = segneg.idClienteTipo
		 JOIN trade.segmentacionClienteModerno scm ON ch.idSegClienteModerno = scm.idSegClienteModerno   LEFT JOIN trade.banner ba WITH(NOLOCK) ON ba.idBanner = scm.idBanner LEFT JOIN trade.cadena cad WITH(NOLOCK) ON cad.idCadena = ba.idCadena

		WHERE r.estado=1 
		AND v.estado=1 
		
		AND r.fecha BETWEEN @fecIni AND @fecFin
		 AND cu.idCuenta IN (13,2,3)
		ORDER BY fecha , canal, tipoUsuario, supervisor, nombreUsuario  ASC
		
ERROR - 2022-02-14 22:36:32 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:38:27 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:38:28 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'JOIN'. - Invalid query: 
			DECLARE @fecIni date='14/02/2022',@fecFin date='14/02/2022';
		SELECT
			distinct
			r.idRuta
			, r.fecha
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
			, r.idUsuario
			, r.nombreUsuario
			, r.tipoUsuario
			, v.idVisita
			, v.canal
			, v.idCliente
			, v.codCliente
			, v.nombreComercial, v.razonSocial
			, v.cod_ubigeo
			, ubi.departamento
			, ubi.provincia
			, ubi.distrito
			, v.direccion
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ct.nombre subCanal
			
						, cad.idCadena
						, ba.idBanner
						, ba.nombre AS banner
						, cad.nombre AS cadena
						

		FROM ImpactTrade_pg.trade.data_ruta r
		JOIN ImpactTrade_pg.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
				and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				and uh.idProyecto=r.idProyecto
		JOIN ImpactTrade_pg.trade.data_visitaVisibilidadTrad dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
		JOIN trade.cliente c 
			ON c.idCliente = v.idCliente 
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		JOIN ImpactTrade_pg.trade.cliente_historico ch 
			ON v.idCliente = ch.idCliente AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1 
			AND ch.idProyecto = 
		LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
		LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
		LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = segneg.idClienteTipo
		 JOIN trade.segmentacionClienteModerno scm ON ch.idSegClienteModerno = scm.idSegClienteModerno   LEFT JOIN trade.banner ba WITH(NOLOCK) ON ba.idBanner = scm.idBanner LEFT JOIN trade.cadena cad WITH(NOLOCK) ON cad.idCadena = ba.idCadena

		WHERE r.estado=1 
		AND v.estado=1 
		
		AND r.fecha BETWEEN @fecIni AND @fecFin
		 AND cu.idCuenta IN (13,2,3)
		ORDER BY fecha , canal, tipoUsuario, supervisor, nombreUsuario  ASC
		
ERROR - 2022-02-14 22:38:55 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
ERROR - 2022-02-14 22:39:32 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\www\w7impacttrade\application\config\config.php 26
