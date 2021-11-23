<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-21 05:10:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Sintaxis incorrecta cerca de 'r'. - Invalid query: 
			DECLARE
				@fecIni date='08/11/2021',
				@fecFin date='08/11/2021';

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
			)
			SELECT DISTINCT
				CONVERT(VARCHAR(10),r.fecha,103) fecha
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
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal

			LEFT JOIN trade.encargado e ON e.idEncargado = r.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario = e.idUsuario
			LEFT JOIN rrhh.dbo.empleado em ON em.numTipoDocuIdent = u_e.numDocumento
			JOIN trade.cuenta cu ON cu.idCuenta = r.idCuenta
			LEFT JOIN list_fotos_no_modulacion lfn ON lfn.idVisita=v.idVisita

			 JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona

			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
			r.demo = 0
			AND v.idTipoExclusion IS NULL AND r.idCuenta = 3 AND r.idProyecto = 3 AND gc.idGrupoCanal = 4 
			ORDER BY fecha , ciudad, canal, tipoUsuario, encargado, nombreUsuario  ASC
		
ERROR - 2021-11-21 18:12:45 --> Unable to connect to the database
