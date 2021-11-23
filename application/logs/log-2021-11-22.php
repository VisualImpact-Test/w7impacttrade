<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-22 21:42:03 --> Severity: error --> Exception: C:\wamp64\visualimpact_test\w7impacttrade\application\models/M_cronjob.php exists, but doesn't declare class M_cronjob C:\wamp64\visualimpact_test\w7impacttrade\system\core\Loader.php 340
ERROR - 2021-11-22 21:42:14 --> Unable to load the requested class: FirePHP
ERROR - 2021-11-22 21:42:21 --> Severity: Notice --> Undefined property: CronJob::$bd C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 14
ERROR - 2021-11-22 21:42:21 --> Severity: error --> Exception: Call to a member function get_distribuidoras_sucursal() on null C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 14
ERROR - 2021-11-22 21:42:31 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Debe declarar la variable escalar "@fecIni". - Invalid query: 
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
			, i.observacion
            
						, d.nombre AS distribuidora
						, ubi1.provincia AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						, ds.idDistribuidoraSucursal
						, z.nombre AS zona
						
		FROM
			ImpactTrade_small.trade.data_ruta r
			JOIN ImpactTrade_small.trade.data_visita v
				ON r.idRuta = v.idRuta
                AND r.demo=0
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN ImpactTrade_small.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN ImpactTrade_small.trade.cliente_historico ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
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
             JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(3,13)
		
ERROR - 2021-11-22 21:44:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Debe declarar la variable escalar "@fecIni". - Invalid query: 
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
			, i.observacion
            
						, d.nombre AS distribuidora
						, ubi1.provincia AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						, ds.idDistribuidoraSucursal
						, z.nombre AS zona
						
		FROM
			ImpactTrade_small.trade.data_ruta r
			JOIN ImpactTrade_small.trade.data_visita v
				ON r.idRuta = v.idRuta
                AND r.demo=0
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN ImpactTrade_small.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN ImpactTrade_small.trade.cliente_historico ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
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
             JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional  JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional   LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal  LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora  LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo LEFT JOIN trade.zona z ON ch.idZona = z.idZona
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(3,13)
		
ERROR - 2021-11-22 21:44:32 --> Severity: Warning --> Illegal string offset 'idGrupoCanal' C:\wamp64\visualimpact_test\w7impacttrade\application\models\M_cronjob.php 131
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:46 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:47 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 30
ERROR - 2021-11-22 22:46:48 --> Severity: error --> Exception: Call to a member function result() on array C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 34
ERROR - 2021-11-22 22:46:48 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp64\visualimpact_test\w7impacttrade\system\core\Exceptions.php:271) C:\wamp64\visualimpact_test\w7impacttrade\system\core\Common.php 570
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:47:29 --> Severity: Notice --> Undefined index: idDS C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 24
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 36
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 37
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 38
ERROR - 2021-11-22 22:59:52 --> Severity: Notice --> Trying to get property of non-object C:\wamp64\visualimpact_test\w7impacttrade\application\controllers\CronJob.php 39
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vD C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 45
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vL C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 46
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vV C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 47
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vP C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 48
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vD C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 52
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vD C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 53
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vL C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 55
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vL C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 56
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vV C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 58
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vV C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 59
ERROR - 2021-11-22 23:12:57 --> Severity: Notice --> Undefined index: vP C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 61
ERROR - 2021-11-22 23:12:58 --> Severity: Notice --> Undefined index: vP C:\wamp64\visualimpact_test\w7impacttrade\application\views\cronjob\ejecucion_total\hfs_correo.php 62
