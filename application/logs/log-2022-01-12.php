<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-12 15:49:01 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:51:37 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:53:56 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:55:44 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:56:16 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:56:20 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:56:48 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 15:58:36 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 16:02:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'actualizado' no es válido. - Invalid query: INSERT INTO "ImpactTrade_pg"."trade"."peticionActualizarVisitas" ("idProyecto", "fechaIni", "fechaFin", "idUsuario", "estado", "idCuenta", "fechaActualizacion", "actualizado") VALUES ('3', '16/12/2021', '16/12/2021', '1', 1, '3', '2022-01-12T16:02:00', 0)
ERROR - 2022-01-12 16:04:33 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-12 16:43:15 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp64\visualimpact_test\w7impacttrade\system\libraries\Session\drivers\Session_files_driver.php:49) C:\wamp64\visualimpact_test\w7impacttrade\system\core\Common.php 570
ERROR - 2022-01-12 16:43:15 --> Severity: Error --> Class CI_Session_files_driver contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (SessionHandlerInterface::read) C:\wamp64\visualimpact_test\w7impacttrade\system\libraries\Session\drivers\Session_files_driver.php 49
ERROR - 2022-01-12 17:55:06 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'estadoIncidencia' no es válido. - Invalid query: 
        DECLARE @fechaHoy DATE = '12/01/2022';
        WITH lista_rutas AS (
            SELECT
                r.idRuta
                , v.idVisita
                , r.idUsuario
                , r.idTipoUsuario
                , v.horaIni
                , v.horaFin
                , v.idListIpp
                , v.ipp
                , v.idListProductos
                , v.productos
                , v.moduloFotos
            FROM ImpactTrade_aje.trade.data_ruta r WITH(NOLOCK)
            JOIN ImpactTrade_aje.trade.data_visita v WITH(NOLOCK) ON r.idRuta = v.idRuta
            JOIN ImpactTrade_aje.trade.cliente_historico ch WITH(NOLOCK) ON ch.idCliente = v.idCliente
                AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha)
                AND ch.idProyecto = r.idProyecto
            JOIN trade.canal c ON c.idCanal = v.idCanal
            JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
             JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona
            WHERE r.fecha = @fechaHoy 
            AND (r.demo = 0 OR r.demo IS NULL)
            AND r.estado = 1
            AND v.estado = 1
             AND r.idProyecto = 15  AND r.idCuenta = 2  AND gc.idGrupoCanal = 4  AND c.idCanal IN (8,22,13,9,10,11,12) 
            AND r.idTipoUsuario IN(1,18)
        ), lista_programados AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idVisita) AS programados
            FROM lista_rutas lr
            GROUP BY lr.idUsuario
        ), lista_efectivos AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idVisita) AS efectivos
            FROM lista_rutas lr
            WHERE v.horaIni IS NOT NULL 
            AND v.horaFin IS NOT NULL 
            AND v.numFotos >= 1 
            AND ISNULL(estadoIncidencia,0) <> 1
            GROUP BY lr.idUsuario
        ), lista_modulos AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idListIpp) AS ippProgramados
                , COUNT(lr.ipp) AS ippEfectuados
                , COUNT(lr.idListProductos) AS productosProgramados
                , COUNT(lr.productos) AS productosEfectuados
                , COUNT(lr.idVisita) AS fotosProgramados
                , COUNT(lr.moduloFotos) AS fotosEfectuados
            FROM lista_rutas lr
            GROUP BY lr.idUsuario
        )
        SELECT
            lp.idUsuario
            , u.nombres+' '+u.apePaterno+' '+u.apeMaterno AS usuario
            , lp.programados
            , ISNULL(le.efectivos, 0) AS efectivos
            , lm.*
        FROM lista_programados lp
        LEFT JOIN lista_efectivos le ON lp.idUsuario = le.idUsuario
        LEFT JOIN lista_modulos lm ON lp.idUsuario = lm.idUsuario
        JOIN trade.usuario u ON lp.idUSuario = u.idUsuario
        ORDER BY efectivos ASC, programados DESC
        
ERROR - 2022-01-12 17:55:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'estadoIncidencia' no es válido. - Invalid query: 
        DECLARE @fechaHoy DATE = '11/01/2022';
        WITH lista_rutas AS (
            SELECT
                r.idRuta
                , v.idVisita
                , r.idUsuario
                , r.idTipoUsuario
                , v.horaIni
                , v.horaFin
                , v.idListIpp
                , v.ipp
                , v.idListProductos
                , v.productos
                , v.moduloFotos
            FROM ImpactTrade_aje.trade.data_ruta r WITH(NOLOCK)
            JOIN ImpactTrade_aje.trade.data_visita v WITH(NOLOCK) ON r.idRuta = v.idRuta
            JOIN ImpactTrade_aje.trade.cliente_historico ch WITH(NOLOCK) ON ch.idCliente = v.idCliente
                AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha)
                AND ch.idProyecto = r.idProyecto
            JOIN trade.canal c ON c.idCanal = v.idCanal
            JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
             JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona
            WHERE r.fecha = @fechaHoy 
            AND (r.demo = 0 OR r.demo IS NULL)
            AND r.estado = 1
            AND v.estado = 1
             AND r.idProyecto = 15  AND r.idCuenta = 2  AND gc.idGrupoCanal = 4  AND c.idCanal IN (8,22,13,9,10,11,12) 
            AND r.idTipoUsuario IN(1,18)
        ), lista_programados AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idVisita) AS programados
            FROM lista_rutas lr
            GROUP BY lr.idUsuario
        ), lista_efectivos AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idVisita) AS efectivos
            FROM lista_rutas lr
            WHERE v.horaIni IS NOT NULL 
            AND v.horaFin IS NOT NULL 
            AND v.numFotos >= 1 
            AND ISNULL(estadoIncidencia,0) <> 1
            GROUP BY lr.idUsuario
        ), lista_modulos AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idListIpp) AS ippProgramados
                , COUNT(lr.ipp) AS ippEfectuados
                , COUNT(lr.idListProductos) AS productosProgramados
                , COUNT(lr.productos) AS productosEfectuados
                , COUNT(lr.idVisita) AS fotosProgramados
                , COUNT(lr.moduloFotos) AS fotosEfectuados
            FROM lista_rutas lr
            GROUP BY lr.idUsuario
        )
        SELECT
            lp.idUsuario
            , u.nombres+' '+u.apePaterno+' '+u.apeMaterno AS usuario
            , lp.programados
            , ISNULL(le.efectivos, 0) AS efectivos
            , lm.*
        FROM lista_programados lp
        LEFT JOIN lista_efectivos le ON lp.idUsuario = le.idUsuario
        LEFT JOIN lista_modulos lm ON lp.idUsuario = lm.idUsuario
        JOIN trade.usuario u ON lp.idUSuario = u.idUsuario
        ORDER BY efectivos ASC, programados DESC
        
ERROR - 2022-01-12 17:55:24 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "v.horaIni" no se pudo enlazar. - Invalid query: 
        DECLARE @fechaHoy DATE = '12/01/2022';
        WITH lista_rutas AS (
            SELECT
                r.idRuta
                , v.idVisita
                , r.idUsuario
                , r.idTipoUsuario
                , v.horaIni
                , v.horaFin
                , v.idListIpp
                , v.ipp
                , v.idListProductos
                , v.productos
                , v.moduloFotos
            FROM ImpactTrade_aje.trade.data_ruta r WITH(NOLOCK)
            JOIN ImpactTrade_aje.trade.data_visita v WITH(NOLOCK) ON r.idRuta = v.idRuta
            JOIN ImpactTrade_aje.trade.cliente_historico ch WITH(NOLOCK) ON ch.idCliente = v.idCliente
                AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha)
                AND ch.idProyecto = r.idProyecto
            JOIN trade.canal c ON c.idCanal = v.idCanal
            JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
             JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona
            WHERE r.fecha = @fechaHoy 
            AND (r.demo = 0 OR r.demo IS NULL)
            AND r.estado = 1
            AND v.estado = 1
             AND r.idProyecto = 15  AND r.idCuenta = 2  AND gc.idGrupoCanal = 4  AND c.idCanal IN (8,22,13,9,10,11,12) 
            AND r.idTipoUsuario IN(1,18)
        ), lista_programados AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idVisita) AS programados
            FROM lista_rutas lr
            GROUP BY lr.idUsuario
        ), lista_efectivos AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idVisita) AS efectivos
            FROM lista_rutas lr
            WHERE v.horaIni IS NOT NULL 
            AND v.horaFin IS NOT NULL 
            AND v.numFotos >= 1 
            AND ISNULL(v.estadoIncidencia,0) <> 1
            GROUP BY lr.idUsuario
        ), lista_modulos AS (
            SELECT
                lr.idUsuario
                , COUNT(lr.idListIpp) AS ippProgramados
                , COUNT(lr.ipp) AS ippEfectuados
                , COUNT(lr.idListProductos) AS productosProgramados
                , COUNT(lr.productos) AS productosEfectuados
                , COUNT(lr.idVisita) AS fotosProgramados
                , COUNT(lr.moduloFotos) AS fotosEfectuados
            FROM lista_rutas lr
            GROUP BY lr.idUsuario
        )
        SELECT
            lp.idUsuario
            , u.nombres+' '+u.apePaterno+' '+u.apeMaterno AS usuario
            , lp.programados
            , ISNULL(le.efectivos, 0) AS efectivos
            , lm.*
        FROM lista_programados lp
        LEFT JOIN lista_efectivos le ON lp.idUsuario = le.idUsuario
        LEFT JOIN lista_modulos lm ON lp.idUsuario = lm.idUsuario
        JOIN trade.usuario u ON lp.idUSuario = u.idUsuario
        ORDER BY efectivos ASC, programados DESC
        
ERROR - 2022-01-12 19:32:59 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]La transacción (id. de proceso 56) quedó en interbloqueo en bloqueo recursos con otro proceso y fue elegida como sujeto del interbloqueo. Ejecute de nuevo la transacción. - Invalid query: 
		DECLARE @fecha Date = GETDATE();
		SELECT DISTINCT
			v.idVisita
			, CONVERT(varchar,r.fecha,103) fecha
			, v.idCliente
            , v.razonSocial
			, v.idCanal
			, gc.nombre AS grupoCanal
			, v.canal
			, sc.nombre AS subCanal
			, v.estadoIncidencia
			, ct.nombre clienteTipo
			, ub1.departamento
			, ub1.provincia
			, v.direccion
			, ut.nombre AS tipoUsuario
			, r.nombreUsuario AS usuario
			, i.nombreIncidencia 
			, v.estadoIncidencia
			, i.observacion observacionIncidencia
			, v.observacion 
            , dvvo.porcentaje porcentajeEO
			, dvvo.porcentajeV
			, dvvo.porcentajePM
			, dvva.porcentaje porcentajeEA
			, dvvi.porcentaje porcentajeINI
			, vo.descripcion orden
            
						, pl.nombre AS plaza 
						, pl.idPlaza
						, z.nombre AS zona
						, ds.idDistribuidoraSucursal
						, ubpl.provincia ciudadPlaza
						
		FROM
			ImpactTrade_pg.trade.data_ruta r
			JOIN ImpactTrade_pg.trade.data_visita v
				ON r.idRuta = v.idRuta
                AND r.demo=0
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN ImpactTrade_pg.trade.cliente_historico ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecha,@fecha)=1
			JOIN trade.cliente c
				ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc 
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub1
				ON ub1.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN trade.usuario_tipo ut
				ON r.idTipoUsuario = ut.idTipoUsuario
            LEFT JOIN ImpactTrade_pg.trade.data_visitaVisibilidadObligatorio  dvvo 
				ON dvvo.idVisita = v.idVisita
			LEFT JOIN ImpactTrade_pg.trade.data_visitaVisibilidadAdicional dvva 
				ON dvva.idVisita = v.idVisita
			LEFT JOIN ImpactTrade_pg.trade.data_visitaVisibilidadIniciativa dvvi
				ON dvvi.idVisita = v.idVisita
			LEFT JOIN ImpactTrade_pg.trade.data_visitaOrden vo 
				ON vo.idVisita = v.idVisita
             JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional   LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional  LEFT JOIN trade.plaza pl ON pl.idPlaza = sct.idPlaza LEFT JOIN trade.zona z ON ch.idZona = z.idZona LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN General.dbo.ubigeo ubpl ON ubpl.cod_ubigeo = pl.cod_ubigeo 
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(13)
			 AND gc.idGrupoCanal = 5
		
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 79
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 80
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 81
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 82
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 83
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 85
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 19:44:53 --> Severity: Notice --> Undefined variable: resultados C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\whls_correo.php 86
ERROR - 2022-01-12 20:49:41 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'SELECT'. - Invalid query: 
			DECLARE
				@fecIni DATE='11/01/2022',
				@fecFin DATE='11/01/2022',
				@hoy DATE = GETDATE();

			WITH list_fotos_no_modulacion as (
				SELECT DISTINCT v.idVisita, 
				COUNT(vf.idVisitaFoto) OVER (PARTITION BY v.idVisita) as contFotos 
				FROM ImpactTrade_pg.trade.data_ruta r
				JOIN ImpactTrade_pg.trade.data_visita v ON r.idRuta = v.idRuta
				JOIN ImpactTrade_pg.trade.data_visitaFotos vf ON vf.idVisita=v.idVisita
				JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo
				JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo=m.idModuloGrupo
				WHERE  mg.idModuloGrupo<>9 
				and r.fecha between @fecIni and isnull(@fecFin,r.fecha)
			), list_usuarios_activos as(
				SELECT DISTINCT
				u.idUsuario
				FROM
				trade.usuario u 
				JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
				WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@hoy,@hoy) = 1 AND uh.idProyecto = 3
			)
			, list_visitas(
			SELECT DISTINCT
				CONVERT(VARCHAR(10),r.fecha,103) fecha
				, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
				, r.idUsuario cod_usuario
				, em.idEmpleado cod_empleado
				, r.nombreUsuario
				, CONVERT(VARCHAR(8), a.hora) hora_ini_asistencia
				, CONVERT(VARCHAR(8), v.horaIni) hora_ini
				, CONVERT(VARCHAR(8), v.horaFin) hora_fin
				, DATEDIFF(MINUTE,v.horaIni,v.horaFin) minutos
				, vi.nombreIncidencia indicencia_nombre
				, CASE 
					WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1 ) THEN 
					CASE 
						WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 3 --Efectiva
						ELSE 
							CASE 
							WHEN v.numFotos >=1 THEN 3 --Efectiva
							ELSE 1 --No efectiva
							END
					END 
					WHEN (v.estadoIncidencia = 1 ) THEN 2 --INCIDENCIA
					WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND ISNULL(v.numFotos,0) = 0  AND estadoIncidencia IS NULL ) THEN 0 -- No Visitado
					ELSE 1 --No Efectiva
					END condicion
				, v.idVisita
				, v.idCanal
				, v.canal
				, gc.nombre grupoCanal
				, gc.idGrupoCanal
				, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
				, ub.departamento ciudad
				, ub.cod_provincia
				, ub.provincia
				, ub.cod_distrito
				, ub.distrito
				, v.idCliente cod_visual
				, v.razonSocial
				, c.nombreComercial
				, c.direccion
				, v.encuesta
				, v.ipp
				, v.productos
				, v.precios
				, v.promociones
				, v.sod
				, v.sos
				, v.seguimientoPlan
				, v.despachos
				, v.encartes
				, v.numFotos fotos
				, v.frecuencia
				, v.qr
				, c.flagQR
				--
				, CASE WHEN (v.horaIni IS NULL) THEN 1 ELSE 0 END valHora
				, ISNULL(v.latIni,0) lati_ini
				, ISNULL(v.lonIni,0) long_ini
				, ISNULL(v.latFin,0) lati_fin
				, ISNULL(v.lonFin,0) long_fin
				, ISNULL(c.latitud,0) latitud
				, ISNULL(c.longitud,0) longitud
				-- , ROW_NUMBER() OVER (PARTITION BY r.idUsuario ORDER BY r.idUsuario) row
				, ISNULL(vi.idIncidencia,0) idTipoIncidencia
				, CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND vi.nombreIncidencia IS NULL ) OR (v.estadoIncidencia=0) THEN 1 ELSE 0 END as PDV_EFECTIVO
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND vi.nombreIncidencia IS NOT NULL) OR (v.estadoIncidencia=1) THEN 1 ELSE 0 END as PDV_NO_VISITADO
				, CASE WHEN (v.estadoIncidencia = 0) OR(v.estadoIncidencia IS NOT NULL)  THEN 1 ELSE 0 END as PDV_INCIDENCIA
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL) THEN 1 ELSE 0 END as PDV_SINVISITA
				, c.codCliente
				, vi.fotoUrl incidencia_foto
				, e.idEncargado
				, vi.nombreIncidencia incidencia_nombre
				, u_e.apePaterno + ' ' + u_e.apeMaterno + ' ' + u_e.nombres encargado
				, CONVERT(VARCHAR(8), vi.hora) incidencia_hora
				, vi.observacion incidencia_obs
				, r.idTipoUsuario
				, r.tipoUsuario
				, map.id_anychartmaps idMap
				----
				, v.inventario
				, v.visibilidad
				, 1 AS ventas
				, v.iniciativa AS iniciativas
				, v.inteligencia AS inteligenciaCompetitiva
				, v.ordenes AS ordenTrabajo
				, v.ordenAuditoria
				, v.modulacion
				, v.visibilidad_aud AS visibilidadAuditoria
				, v.premio
				, v.mantenimiento AS mantenimientoCliente
				, v.surtido
				, v.observacion AS observacion
				, v.tarea
				, v.evidenciaFotografica
				, lfn.contFotos fotosOtrosModulos
				, ctp.idClienteTipo
				, ctp.nombre subCanal
				, CASE WHEN vi.idVisitaIncidencia IS NOT NULL THEN  ROW_NUMBER() OVER (PARTITION BY vi.idVisita ORDER BY vi.idVisitaIncidencia ) END num_incidencia
				
						, d.nombre AS distribuidora
						, ubi1.provincia AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						, ds.idDistribuidoraSucursal
						, z.nombre AS zona
						

			FROM ImpactTrade_pg.trade.data_ruta r
			JOIN ImpactTrade_pg.trade.data_visita v ON r.idRuta = v.idRuta 
			LEFT JOIN General.dbo.ubigeo ub ON v.cod_ubigeo = ub.cod_ubigeo
			LEFT JOIN ImpactTrade_pg.trade.data_asistencia a ON a.idUsuario = r.idUsuario AND r.fecha = a.fecha AND a.idTipoAsistencia = 1
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita
			JOIN trade.cliente c ON c.idCliente = v.idCliente
			LEFT JOIN ImpactTrade_pg.trade.cliente_historico ch ON ch.idCliente = c.idCliente 
			AND (
				ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
				AND (
					ch.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				)
			) AND ch.idProyecto = 3
			JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal

			LEFT JOIN trade.encargado e ON e.idEncargado = r.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario = e.idUsuario
			LEFT JOIN rrhh.dbo.empleado em ON em.numTipoDocuIdent = u_e.numDocumento
			JOIN trade.cuenta cu ON cu.idCuenta = r.idCuenta
			LEFT JOIN list_fotos_no_modulacion lfn ON lfn.idVisita=v.idVisita

			 JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona

			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
			AND v.idTipoExclusion IS NULL AND r.idCuenta = 3 AND r.idProyecto = 3 AND gc.idGrupoCanal = 4 AND r.idUsuario IN (654) 
		)
		SELECT 
		* 
		FROM lista_visitas
		WHERE (num_incidencia = 1 OR num_incidencia IS NULL)
		ORDER BY fecha , ciudad, canal, tipoUsuario, encargado, nombreUsuario  ASC

		
ERROR - 2022-01-12 20:54:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'SELECT'. - Invalid query: 
			DECLARE
				@fecIni DATE='11/01/2022',
				@fecFin DATE='11/01/2022',
				@hoy DATE = GETDATE();

			WITH list_fotos_no_modulacion as (
				SELECT DISTINCT v.idVisita, 
				COUNT(vf.idVisitaFoto) OVER (PARTITION BY v.idVisita) as contFotos 
				FROM ImpactTrade_pg.trade.data_ruta r
				JOIN ImpactTrade_pg.trade.data_visita v ON r.idRuta = v.idRuta
				JOIN ImpactTrade_pg.trade.data_visitaFotos vf ON vf.idVisita=v.idVisita
				JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo
				JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo=m.idModuloGrupo
				WHERE  mg.idModuloGrupo<>9 
				and r.fecha between @fecIni and isnull(@fecFin,r.fecha)
			), list_usuarios_activos as(
				SELECT DISTINCT
				u.idUsuario
				FROM
				trade.usuario u 
				JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
				WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@hoy,@hoy) = 1 AND uh.idProyecto = 3
			)
			, list_visitas(
			SELECT DISTINCT
				CONVERT(VARCHAR(10),r.fecha,103) fecha
				, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
				, r.idUsuario cod_usuario
				, em.idEmpleado cod_empleado
				, r.nombreUsuario
				, CONVERT(VARCHAR(8), a.hora) hora_ini_asistencia
				, CONVERT(VARCHAR(8), v.horaIni) hora_ini
				, CONVERT(VARCHAR(8), v.horaFin) hora_fin
				, DATEDIFF(MINUTE,v.horaIni,v.horaFin) minutos
				, vi.nombreIncidencia indicencia_nombre
				, CASE 
					WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1 ) THEN 
					CASE 
						WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 3 --Efectiva
						ELSE 
							CASE 
							WHEN v.numFotos >=1 THEN 3 --Efectiva
							ELSE 1 --No efectiva
							END
					END 
					WHEN (v.estadoIncidencia = 1 ) THEN 2 --INCIDENCIA
					WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND ISNULL(v.numFotos,0) = 0  AND estadoIncidencia IS NULL ) THEN 0 -- No Visitado
					ELSE 1 --No Efectiva
					END condicion
				, v.idVisita
				, v.idCanal
				, v.canal
				, gc.nombre grupoCanal
				, gc.idGrupoCanal
				, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
				, ub.departamento ciudad
				, ub.cod_provincia
				, ub.provincia
				, ub.cod_distrito
				, ub.distrito
				, v.idCliente cod_visual
				, v.razonSocial
				, c.nombreComercial
				, c.direccion
				, v.encuesta
				, v.ipp
				, v.productos
				, v.precios
				, v.promociones
				, v.sod
				, v.sos
				, v.seguimientoPlan
				, v.despachos
				, v.encartes
				, v.numFotos fotos
				, v.frecuencia
				, v.qr
				, c.flagQR
				--
				, CASE WHEN (v.horaIni IS NULL) THEN 1 ELSE 0 END valHora
				, ISNULL(v.latIni,0) lati_ini
				, ISNULL(v.lonIni,0) long_ini
				, ISNULL(v.latFin,0) lati_fin
				, ISNULL(v.lonFin,0) long_fin
				, ISNULL(c.latitud,0) latitud
				, ISNULL(c.longitud,0) longitud
				-- , ROW_NUMBER() OVER (PARTITION BY r.idUsuario ORDER BY r.idUsuario) row
				, ISNULL(vi.idIncidencia,0) idTipoIncidencia
				, CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND vi.nombreIncidencia IS NULL ) OR (v.estadoIncidencia=0) THEN 1 ELSE 0 END as PDV_EFECTIVO
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND vi.nombreIncidencia IS NOT NULL) OR (v.estadoIncidencia=1) THEN 1 ELSE 0 END as PDV_NO_VISITADO
				, CASE WHEN (v.estadoIncidencia = 0) OR(v.estadoIncidencia IS NOT NULL)  THEN 1 ELSE 0 END as PDV_INCIDENCIA
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL) THEN 1 ELSE 0 END as PDV_SINVISITA
				, c.codCliente
				, vi.fotoUrl incidencia_foto
				, e.idEncargado
				, vi.nombreIncidencia incidencia_nombre
				, u_e.apePaterno + ' ' + u_e.apeMaterno + ' ' + u_e.nombres encargado
				, CONVERT(VARCHAR(8), vi.hora) incidencia_hora
				, vi.observacion incidencia_obs
				, r.idTipoUsuario
				, r.tipoUsuario
				, map.id_anychartmaps idMap
				----
				, v.inventario
				, v.visibilidad
				, 1 AS ventas
				, v.iniciativa AS iniciativas
				, v.inteligencia AS inteligenciaCompetitiva
				, v.ordenes AS ordenTrabajo
				, v.ordenAuditoria
				, v.modulacion
				, v.visibilidad_aud AS visibilidadAuditoria
				, v.premio
				, v.mantenimiento AS mantenimientoCliente
				, v.surtido
				, v.observacion AS observacion
				, v.tarea
				, v.evidenciaFotografica
				, lfn.contFotos fotosOtrosModulos
				, ctp.idClienteTipo
				, ctp.nombre subCanal
				, CASE WHEN vi.idVisitaIncidencia IS NOT NULL THEN  ROW_NUMBER() OVER (PARTITION BY vi.idVisita ORDER BY vi.idVisitaIncidencia ) END num_incidencia
				
						, d.nombre AS distribuidora
						, ubi1.provincia AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						, ds.idDistribuidoraSucursal
						, z.nombre AS zona
						

			FROM ImpactTrade_pg.trade.data_ruta r
			JOIN ImpactTrade_pg.trade.data_visita v ON r.idRuta = v.idRuta 
			LEFT JOIN General.dbo.ubigeo ub ON v.cod_ubigeo = ub.cod_ubigeo
			LEFT JOIN ImpactTrade_pg.trade.data_asistencia a ON a.idUsuario = r.idUsuario AND r.fecha = a.fecha AND a.idTipoAsistencia = 1
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita
			JOIN trade.cliente c ON c.idCliente = v.idCliente
			LEFT JOIN ImpactTrade_pg.trade.cliente_historico ch ON ch.idCliente = c.idCliente 
			AND (
				ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
				AND (
					ch.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				)
			) AND ch.idProyecto = 3
			JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal

			LEFT JOIN trade.encargado e ON e.idEncargado = r.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario = e.idUsuario
			LEFT JOIN rrhh.dbo.empleado em ON em.numTipoDocuIdent = u_e.numDocumento
			JOIN trade.cuenta cu ON cu.idCuenta = r.idCuenta
			LEFT JOIN list_fotos_no_modulacion lfn ON lfn.idVisita=v.idVisita

			 JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona

			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
			AND v.idTipoExclusion IS NULL AND r.idCuenta = 3 AND r.idProyecto = 3 AND gc.idGrupoCanal = 4 AND r.idUsuario IN (654) 
		)
		SELECT 
		* 
		FROM lista_visitas
		WHERE (num_incidencia = 1 OR num_incidencia IS NULL)
		ORDER BY fecha , ciudad, canal, tipoUsuario, encargado, nombreUsuario  ASC

		
ERROR - 2022-01-12 20:55:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de 'r'. - Invalid query: 
			DECLARE
				@fecIni DATE='11/01/2022',
				@fecFin DATE='11/01/2022',
				@hoy DATE = GETDATE();

			WITH list_fotos_no_modulacion as (
				SELECT DISTINCT v.idVisita, 
				COUNT(vf.idVisitaFoto) OVER (PARTITION BY v.idVisita) as contFotos 
				FROM ImpactTrade_pg.trade.data_ruta WITH(NOLOCK) r
				JOIN ImpactTrade_pg.trade.data_visita v WITH(NOLOCK) ON r.idRuta = v.idRuta
				JOIN ImpactTrade_pg.trade.data_visitaFotos vf WITH(NOLOCK) ON vf.idVisita=v.idVisita
				JOIN trade.aplicacion_modulo m WITH(NOLOCK) ON vf.idModulo = m.idModulo
				JOIN trade.aplicacion_modulo_grupo mg WITH(NOLOCK) ON mg.idModuloGrupo=m.idModuloGrupo
				WHERE  mg.idModuloGrupo<>9 
				and r.fecha between @fecIni and isnull(@fecFin,r.fecha)
			), list_usuarios_activos as(
				SELECT DISTINCT
				u.idUsuario
				FROM
				trade.usuario u WITH(NOLOCK)
				JOIN trade.usuario_historico uh WITH(NOLOCK) ON uh.idUsuario = u.idUsuario
				WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@hoy,@hoy) = 1 AND uh.idProyecto = 3
			)
			, list_visitas as(
			SELECT DISTINCT
				CONVERT(VARCHAR(10),r.fecha,103) fecha
				, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
				, r.idUsuario cod_usuario
				, em.idEmpleado cod_empleado
				, r.nombreUsuario
				, CONVERT(VARCHAR(8), a.hora) hora_ini_asistencia
				, CONVERT(VARCHAR(8), v.horaIni) hora_ini
				, CONVERT(VARCHAR(8), v.horaFin) hora_fin
				, DATEDIFF(MINUTE,v.horaIni,v.horaFin) minutos
				, vi.nombreIncidencia indicencia_nombre
				, CASE 
					WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1 ) THEN 
					CASE 
						WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 3 --Efectiva
						ELSE 
							CASE 
							WHEN v.numFotos >=1 THEN 3 --Efectiva
							ELSE 1 --No efectiva
							END
					END 
					WHEN (v.estadoIncidencia = 1 ) THEN 2 --INCIDENCIA
					WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND ISNULL(v.numFotos,0) = 0  AND estadoIncidencia IS NULL ) THEN 0 -- No Visitado
					ELSE 1 --No Efectiva
					END condicion
				, v.idVisita
				, v.idCanal
				, v.canal
				, gc.nombre grupoCanal
				, gc.idGrupoCanal
				, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
				, ub.departamento ciudad
				, ub.cod_provincia
				, ub.provincia
				, ub.cod_distrito
				, ub.distrito
				, v.idCliente cod_visual
				, v.razonSocial
				, c.nombreComercial
				, c.direccion
				, v.encuesta
				, v.ipp
				, v.productos
				, v.precios
				, v.promociones
				, v.sod
				, v.sos
				, v.seguimientoPlan
				, v.despachos
				, v.encartes
				, v.numFotos fotos
				, v.frecuencia
				, v.qr
				, c.flagQR
				--
				, CASE WHEN (v.horaIni IS NULL) THEN 1 ELSE 0 END valHora
				, ISNULL(v.latIni,0) lati_ini
				, ISNULL(v.lonIni,0) long_ini
				, ISNULL(v.latFin,0) lati_fin
				, ISNULL(v.lonFin,0) long_fin
				, ISNULL(c.latitud,0) latitud
				, ISNULL(c.longitud,0) longitud
				-- , ROW_NUMBER() OVER (PARTITION BY r.idUsuario ORDER BY r.idUsuario) row
				, ISNULL(vi.idIncidencia,0) idTipoIncidencia
				, CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND vi.nombreIncidencia IS NULL ) OR (v.estadoIncidencia=0) THEN 1 ELSE 0 END as PDV_EFECTIVO
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND vi.nombreIncidencia IS NOT NULL) OR (v.estadoIncidencia=1) THEN 1 ELSE 0 END as PDV_NO_VISITADO
				, CASE WHEN (v.estadoIncidencia = 0) OR(v.estadoIncidencia IS NOT NULL)  THEN 1 ELSE 0 END as PDV_INCIDENCIA
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL) THEN 1 ELSE 0 END as PDV_SINVISITA
				, c.codCliente
				, vi.fotoUrl incidencia_foto
				, e.idEncargado
				, vi.nombreIncidencia incidencia_nombre
				, u_e.apePaterno + ' ' + u_e.apeMaterno + ' ' + u_e.nombres encargado
				, CONVERT(VARCHAR(8), vi.hora) incidencia_hora
				, vi.observacion incidencia_obs
				, r.idTipoUsuario
				, r.tipoUsuario
				, map.id_anychartmaps idMap
				----
				, v.inventario
				, v.visibilidad
				, 1 AS ventas
				, v.iniciativa AS iniciativas
				, v.inteligencia AS inteligenciaCompetitiva
				, v.ordenes AS ordenTrabajo
				, v.ordenAuditoria
				, v.modulacion
				, v.visibilidad_aud AS visibilidadAuditoria
				, v.premio
				, v.mantenimiento AS mantenimientoCliente
				, v.surtido
				, v.observacion AS observacion
				, v.tarea
				, v.evidenciaFotografica
				, lfn.contFotos fotosOtrosModulos
				, ctp.idClienteTipo
				, ctp.nombre subCanal
				, CASE WHEN vi.idVisitaIncidencia IS NOT NULL THEN  ROW_NUMBER() OVER (PARTITION BY vi.idVisita ORDER BY vi.idVisitaIncidencia ) END num_incidencia
				
						, d.nombre AS distribuidora
						, ubi1.provincia AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						, ds.idDistribuidoraSucursal
						, z.nombre AS zona
						

			FROM ImpactTrade_pg.trade.data_ruta r WITH(NOLOCK)
			JOIN ImpactTrade_pg.trade.data_visita v WITH(NOLOCK) ON r.idRuta = v.idRuta 
			LEFT JOIN General.dbo.ubigeo ub WITH(NOLOCK) ON v.cod_ubigeo = ub.cod_ubigeo
			LEFT JOIN ImpactTrade_pg.trade.data_asistencia a WITH(NOLOCK) ON a.idUsuario = r.idUsuario AND r.fecha = a.fecha AND a.idTipoAsistencia = 1
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia vi WITH(NOLOCK) ON vi.idVisita = v.idVisita
			JOIN trade.cliente c WITH(NOLOCK) ON c.idCliente = v.idCliente
			LEFT JOIN ImpactTrade_pg.trade.cliente_historico ch WITH(NOLOCK) ON ch.idCliente = c.idCliente 
			AND (
				ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
				AND (
					ch.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				)
			) AND ch.idProyecto = 3
			JOIN trade.canal ca WITH(NOLOCK) ON ca.idCanal = v.idCanal
			LEFT JOIN trade.segmentacionNegocio sn WITH(NOLOCK) ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ctp WITH(NOLOCK) ON sn.idClienteTipo = ctp.idClienteTipo
			LEFT JOIN trade.grupoCanal gc WITH(NOLOCK) ON ca.idGrupoCanal = gc.idGrupoCanal

			LEFT JOIN trade.encargado e WITH(NOLOCK) ON e.idEncargado = r.idEncargado
			LEFT JOIN trade.usuario u_e WITH(NOLOCK) ON u_e.idUsuario = e.idUsuario
			LEFT JOIN rrhh.dbo.empleado em WITH(NOLOCK) ON em.numTipoDocuIdent = u_e.numDocumento
			JOIN trade.cuenta cu WITH(NOLOCK) ON cu.idCuenta = r.idCuenta
			LEFT JOIN list_fotos_no_modulacion lfn WITH(NOLOCK) ON lfn.idVisita=v.idVisita

			 JOIN trade.segmentacionClienteTradicional sct WITH(NOLOCK) ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd WITH(NOLOCK) ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds WITH(NOLOCK) ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d WITH(NOLOCK) ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 WITH(NOLOCK) ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z WITH(NOLOCK) ON ch.idZona = z.idZona

			LEFT JOIN master.anychartmaps_ubigeo map WITH(NOLOCK) ON map.cod_departamento = ub.cod_departamento 
			
			WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
			AND v.idTipoExclusion IS NULL AND r.idCuenta = 3 AND r.idProyecto = 3 AND gc.idGrupoCanal = 4 AND r.idUsuario IN (654) 
		)
		SELECT 
		* 
		FROM list_visitas
		WHERE (num_incidencia = 1 OR num_incidencia IS NULL)
		ORDER BY fecha , ciudad, canal, tipoUsuario, encargado, nombreUsuario  ASC

		
