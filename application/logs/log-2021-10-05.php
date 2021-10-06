<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-05 10:37:43 --> Unable to connect to the database
ERROR - 2021-10-05 10:38:54 --> Unable to connect to the database
ERROR - 2021-10-05 10:39:01 --> Unable to connect to the database
ERROR - 2021-10-05 10:40:41 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'JOIN'. - Invalid query: 
		DECLARE @fecIni date='05/10/2021',@fecFin date='05/10/2021';
		SELECT DISTINCT
			c.idCliente
			, c.razonSocial
			, c.codCliente
			, c.codDist codPdv
			, c.direccion, c.ruc, c.dni
			, c.nombreComercial, ch.idFrecuencia frecuencia
			, ub.departamento, ub.provincia, ub.distrito, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
			, gc.idGrupoCanal, gc.nombre grupoCanal
			, ca.idCanal, ca.nombre canal
			, subc.idSubCanal, subc.nombre subCanal
			, map.id_anychartmaps idMap
			, cu.nombre cuenta
			, py.nombre proyecto
			, ch.flagCartera
			, 0 monto
			
						,d.nombre AS distribuidora
						, ubi1.distrito AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						
		FROM
			trade.cliente c
			JOIN trade.cliente_historico_pg ch ON ch.idCliente = c.idCliente 
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
				) --AND ch.flagCartera = 1
			JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado = 1
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN trade.subCanal subc ON sn.idSubCanal = subc.idSubCanal
			LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			 LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional AND sctd.idDistribuidoraSucursal =   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		WHERE
			c.estado = 1 
			 AND py.idCuenta=3 AND ch.idProyecto=3 AND ch.flagCartera=1 AND gc.idGrupoCanal=4
		ORDER BY canal, departamento, provincia, distrito, razonSocial ASC
		
ERROR - 2021-10-05 10:42:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'JOIN'. - Invalid query: 
		DECLARE @fecIni date='05/10/2021',@fecFin date='05/10/2021';
		SELECT DISTINCT
			c.idCliente
			, c.razonSocial
			, c.codCliente
			, c.codDist codPdv
			, c.direccion, c.ruc, c.dni
			, c.nombreComercial, ch.idFrecuencia frecuencia
			, ub.departamento, ub.provincia, ub.distrito, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
			, gc.idGrupoCanal, gc.nombre grupoCanal
			, ca.idCanal, ca.nombre canal
			, subc.idSubCanal, subc.nombre subCanal
			, map.id_anychartmaps idMap
			, cu.nombre cuenta
			, py.nombre proyecto
			, ch.flagCartera
			, 0 monto
			
						,d.nombre AS distribuidora
						, ubi1.distrito AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						
		FROM
			trade.cliente c
			JOIN trade.cliente_historico_pg ch ON ch.idCliente = c.idCliente 
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
				) --AND ch.flagCartera = 1
			JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado = 1
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN trade.subCanal subc ON sn.idSubCanal = subc.idSubCanal
			LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			 LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional AND sctd.idDistribuidoraSucursal =   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		WHERE
			c.estado = 1 
			 AND py.idCuenta=3 AND ch.idProyecto=3 AND ch.flagCartera=1 AND gc.idGrupoCanal=4
		ORDER BY canal, departamento, provincia, distrito, razonSocial ASC
		
ERROR - 2021-10-05 11:39:10 --> Unable to connect to the database
ERROR - 2021-10-05 11:43:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server]TCP Provider: Se ha forzado la interrupción de una conexión existente por el host remoto.
 - Invalid query: 
		DECLARE @fecIni date='05/10/2021',@fecFin date='05/10/2021';
		SELECT DISTINCT
			c.idCliente
			, c.razonSocial
			, c.codCliente
			, c.codDist codPdv
			, c.direccion, c.ruc, c.dni
			, c.nombreComercial, ch.idFrecuencia frecuencia
			, ub.departamento, ub.provincia, ub.distrito, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
			, gc.idGrupoCanal, gc.nombre grupoCanal
			, ca.idCanal, ca.nombre canal
			, subc.idSubCanal, subc.nombre subCanal
			, map.id_anychartmaps idMap
			, cu.nombre cuenta
			, py.nombre proyecto
			, ch.flagCartera
			, 0 monto
			
						,d.nombre AS distribuidora
						, ubi1.distrito AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						
		FROM
			trade.cliente c
			JOIN trade.cliente_historico_pg ch ON ch.idCliente = c.idCliente 
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
				) --AND ch.flagCartera = 1
			JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado = 1
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN trade.subCanal subc ON sn.idSubCanal = subc.idSubCanal
			LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			 LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional AND sctd.idDistribuidoraSucursal = 2  LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		WHERE
			c.estado = 1 
			 AND py.idCuenta=3 AND ch.idProyecto=3 AND ch.flagCartera=1 AND gc.idGrupoCanal=4
		ORDER BY canal, departamento, provincia, distrito, razonSocial ASC
		
ERROR - 2021-10-05 11:51:47 --> Severity: Warning --> Illegal offset type in isset or empty C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 573
ERROR - 2021-10-05 11:51:47 --> Severity: Notice --> Undefined index: divHtml C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 639
ERROR - 2021-10-05 11:52:32 --> Severity: Warning --> Illegal offset type in isset or empty C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 573
ERROR - 2021-10-05 11:52:32 --> Severity: Notice --> Undefined index: divHtml C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 642
ERROR - 2021-10-05 12:14:07 --> Severity: Notice --> Undefined property: Control::$model C:\wamp64\visualimpact_test\w7impactTrade\application\controllers\Control.php 238
ERROR - 2021-10-05 12:14:07 --> Severity: error --> Exception: Call to a member function get_usuarios() on null C:\wamp64\visualimpact_test\w7impactTrade\application\controllers\Control.php 238
ERROR - 2021-10-05 12:14:07 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp64\visualimpact_test\w7impactTrade\system\core\Exceptions.php:271) C:\wamp64\visualimpact_test\w7impactTrade\system\core\Common.php 570
ERROR - 2021-10-05 12:14:22 --> Severity: Notice --> Indirect modification of overloaded property M_control::$aSessTrack has no effect C:\wamp64\visualimpact_test\w7impactTrade\application\models\M_control.php 505
ERROR - 2021-10-05 12:14:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "c.estado" no se pudo enlazar. - Invalid query: 
		SELECT DISTINCT 
		u.idUsuario id
		,CONVERT(varchar,u.idUsuario) + ' - ' + ISNULL((u.nombres + u.apePaterno),' ') +  ' - ' +ISNULL(u.numDocumento,' ') text
		FROM trade.usuario u
		WHERE c.estado=1
		 AND (u.nombres LIKE('%demo%') 
												OR u.apePaterno LIKE('%demo%') 
												OR u.apeMaterno LIKE('%demo%')
												OR u.idUsuario LIKE('%demo%')
												OR u.numDocumento LIKE('%demo%')
												)
		ORDER BY u.idUsuario DESC
ERROR - 2021-10-05 12:14:22 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp64\visualimpact_test\w7impactTrade\system\core\Exceptions.php:271) C:\wamp64\visualimpact_test\w7impactTrade\system\core\Common.php 570
ERROR - 2021-10-05 12:14:38 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "c.estado" no se pudo enlazar. - Invalid query: 
		SELECT DISTINCT 
		u.idUsuario id
		,CONVERT(varchar,u.idUsuario) + ' - ' + ISNULL((u.nombres + u.apePaterno),' ') +  ' - ' +ISNULL(u.numDocumento,' ') text
		FROM trade.usuario u
		WHERE c.estado=1
		 AND (u.nombres LIKE('%demo%') 
												OR u.apePaterno LIKE('%demo%') 
												OR u.apeMaterno LIKE('%demo%')
												OR u.idUsuario LIKE('%demo%')
												OR u.numDocumento LIKE('%demo%')
												)
		ORDER BY u.idUsuario DESC
ERROR - 2021-10-05 14:21:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Cuando se especifica SELECT DISTINCT, los elementos de ORDER BY deben aparecer en la lista de selección. - Invalid query: 
			SELECT DISTINCT
				ds.idDistribuidoraSucursal AS id,
				ubi.provincia AS nombre
			FROM trade.distribuidoraSucursal ds
			JOIN General.dbo.ubigeo ubi ON ds.cod_ubigeo = ubi.cod_ubigeo
			WHERE ds.estado = 1 AND ds.idDistribuidoraSucursal IN (2,17,20,21,22,26,44) AND ds.idDistribuidora = 2
			ORDER BY ds.nombre
		
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:46:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:47:57 --> Severity: Notice --> Array to string conversion C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:49:13 --> Severity: Notice --> Undefined index: idDistribuidoraSucursal C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 14:49:13 --> Severity: Warning --> implode(): Invalid arguments passed C:\wamp64\visualimpact_test\w7impactTrade\application\helpers\my_helper.php 1489
ERROR - 2021-10-05 15:26:20 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El identificador formado por varias partes "r.demo" no se pudo enlazar. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1

		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND r.demo = 0 AND ds.idDistribuidoraSucursal IN(2,17,20,21,22,26,44)
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 16:54:07 --> Severity: error --> Exception: syntax error, unexpected ')' C:\wamp64\visualimpact_test\w7impactTrade\application\models\M_control.php 75
ERROR - 2021-10-05 17:13:24 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'trade.trade.usuario_historicoZona' no es válido. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idDistribuidoraSucursal AND z.estado = 1
			LEFT JOIN trade.trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:13:59 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de objeto 'trade.trade.usuario_historicoZona' no es válido. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idDistribuidoraSucursal AND z.estado = 1
			LEFT JOIN trade.trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:14:05 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idDistribuidoraSucursal' no es válido. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idDistribuidoraSucursal AND z.estado = 1
			LEFT JOIN trade.trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:14:19 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idDistribuidoraSucursal' no es válido. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idDistribuidoraSucursal AND z.estado = 1
			LEFT JOIN trade.trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:14:21 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idDistribuidoraSucursal' no es válido. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idDistribuidoraSucursal AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:14:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]El nombre de columna 'idDistribuidoraSucursal' no es válido. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idDistribuidoraSucursal AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:15:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idZona AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.	 AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND  gc.idGrupoCanal=4 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:15:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idZona AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.	 AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:16:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idZona AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.	 AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
ERROR - 2021-10-05 17:16:25 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de la palabra clave 'AND'. - Invalid query: 
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='05/10/2021', @fecFin DATE='05/10/2021';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				trade.data_ruta r
				JOIN trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			AND (
				uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
				AND (
					uh.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idZona AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.	 AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			 AND cu.idCuenta=3 AND py.idProyecto=3 AND u.demo = 0
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC
