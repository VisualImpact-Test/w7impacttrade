<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_scorecard extends MY_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
	}
	//CANALES
	public function obtener_canales($input = array() ){
		$join = '';
		$filtros = '';

		$join .= !empty($input['idProyecto']) ? 'AND ch.idProyecto =' . $input['idProyecto'] : '';

		$filtros .= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal =' . $input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';
		$filtros .= !empty($input['idClienteTipo']) ? 'AND sn.idClienteTipo =' . $input['idClienteTipo'] : '';
		$sql = "
			DECLARE
				  @fecIni DATE = GETDATE()
				, @fecFin DATE = GETDATE();
			SELECT
				  idGrupoCanal
				, grupoCanal
				, idCanal
				, canal
				, idSubCanal
				, subCanal
				, COUNT(idGrupoCanal) OVER (PARTITION BY idGrupoCanal ) rowspangc
				, COUNT(idCanal) OVER (PARTITION BY idGrupoCanal,idCanal ) rowspanc
			FROM (
			SELECT DISTINCT
				  gc.idGrupoCanal
				, gc.nombre grupoCanal
				, ca.idCanal
				, ca.nombre canal
				--, sc.idSubCanal
				--, sc.nombre subCanal
				, sc.idClienteTipo AS idSubCanal
				, sc.nombre AS subCanal
				, COUNT(gc.idGrupoCanal) OVER (PARTITION BY gc.idGrupoCanal ) rowspangc
			FROM
				trade.cliente c WITH(NOLOCK)
				JOIN ".getClienteHistoricoCuenta()." ch
					ON c.idCliente = ch.idCliente
					{$join}
					AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				--LEFT JOIN trade.subCanal sc
					--ON sc.idSubCanal = sn.idSubCanal
				JOIN trade.cliente_tipo sc
					ON sc.idClienteTipo = sn.idClienteTipo AND sc.estado = 1
				JOIN trade.canal ca
					ON ca.idCanal = sn.idCanal
					AND ca.estado = 1
				JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
					AND gc.estado=1
					--AND sc.idSubCanal NOT IN (8)
				WHERE 1 = 1
				{$filtros}
			)a
			ORDER BY 
				idGrupoCanal,idCanal,idSubCanal
		";
		
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_cartera($input = array() ){
		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];
		$filtros = '';

		$filtros.=!empty($input['idsubcanal'])?'AND sca.idClienteTipo ='.$input['idsubcanal'] :'';
		// $filtros.=!empty($input['tipo'])?'AND sca.idClienteTipo ='.$input['idsubcanal'] :'';
		$filtros .=!empty($input['str_clientes'])?'AND c.idCliente IN ('.$input['str_clientes'].')' :'';
		$filtros .= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal =' . $input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';

		$filtros .= !empty($input['idProyecto']) ? 'AND py.idProyecto =' . $input['idProyecto'] : '';
		$filtros .= !empty($input['idCuenta']) ? 'AND cu.idCuenta =' . $input['idCuenta'] : '';

		$sql ="
			DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
			SELECT DISTINCT
				  c.idCliente
				, 'EJECUTIVO' ejecutivo
				, 'COORDINADOR' coordinador
				, 'SUPERVISOR' supervisor
				, gc.idGrupoCanal
				, gc.nombre grupoCanal
				 , CASE WHEN gc.idGrupoCanal=4 THEN d.nombre ELSE p.nombre END 'DISTRIBUIDORA-PLAZA'
				 , CASE WHEN gc.idGrupoCanal=4 THEN ubd.departamento ELSE ubp.departamento END 'CIUDAD'
				, ca.idCanal
				, ca.nombre canal
				--, sca.idSubCanal
				--, sca.nombre subcanal
				, sca.idClienteTipo AS idSubCanal
				, sca.nombre AS subcanal
				, c.codCliente
				, c.codDist
				, c.razonSocial
				, c.direccion
				, ISNULL(co.cartera,0) cartera
				, COUNT(c.idCliente) OVER (PARTITION BY ca.idCanal,sca.idClienteTipo) total_subcanal
				, COUNT(c.idCliente) OVER () total
				
			FROM
				trade.cliente c WITH(NOLOCK)
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente 
					AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
				JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
				JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1 
				JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado=1 AND ca.idCanal NOT IN (11)
				--LEFT JOIN trade.subCanal sca ON sca.idSubCanal = sn.idSubCanal AND sca.estado = 1
				JOIN trade.cliente_tipo sca ON sca.idClienteTipo = sn.idClienteTipo AND sca.estado = 1
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal 
				LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
				 
				 JOIN trade.segmentacionClienteTradicional scm ON scm.idSegClienteTradicional = ch.idSegClienteTradicional
				 LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = scm.idDistribuidoraSucursal
				 LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora AND d.estado=1
				 LEFT JOIN General.dbo.ubigeo ubd ON ubd.cod_ubigeo = ds.cod_ubigeo
				 LEFT JOIN trade.plaza p ON p.idPlaza = scm.idPlaza
				 LEFT JOIN General.dbo.ubigeo ubp ON ubp.cod_ubigeo = p.cod_ubigeo
				 LEFT JOIN {$this->sessBDCuenta}.trade.cartera_objetivo co ON co.idSubCanal = sca.idClienteTipo
				
			WHERE
				c.estado = 1 
				{$filtros}
		";
		
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_visitas($input = array() ){
		
		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
		$sessIdProyecto = $this->sessIdProyecto;

		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];
		$filtro = '';
		$subfiltros = '';

		$filtro.=!empty($input['idsubcanal'])?'AND idSubCanal ='.$input['idsubcanal'] :'';
		if(!empty($input['tipo'])){
			if($input['tipo']!='HABILES'){
				$filtro.=!empty($input['tipo'])?"AND estadoVisita ='".$input['tipo']."' ":'';
			}else{
				$filtro.=!empty($input['tipo'])?"AND estadoVisita NOT IN ('EXCLUIDAS')":'';
			}
		}

		$subfiltros .= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal =' . $input['idGrupoCanal'] : '';
		$subfiltros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';
		$subfiltros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';
		$subfiltros .= !empty($input['idProyecto']) ? 'AND r.idProyecto =' . $input['idProyecto'] : '';
		$subfiltros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';
		
		$subfiltros .= !empty($input['idClienteTipo']) ? 'AND sn.idClienteTipo =' . $input['idClienteTipo'] : '';

		//$subfiltros .= !empty($input['idCuenta']) ? 'AND cu.idCuenta =' . $input['idCuenta'] : '';
		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['idGrupoCanal']]);
		$sql = "
			DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
			SELECT 
				*
				, COUNT(idCliente) OVER (PARTITION BY idCanal,idSubCanal,estadoVisita) total_subcanal
				, COUNT(idCliente) OVER (PARTITION BY idCanal,idSubCanal) visitas_programadas
				, COUNT(CASE WHEN cant_cliente = 1 THEN idCliente END) OVER (PARTITION BY idCanal,idSubCanal,estadoVisita) cobertura_subcanal
			FROM (
				SELECT DISTINCT 
					  v.idCliente
					, 'EJECUTIVO' ejecutivo
					, 'COORDINADOR' coordinador
					, 'SUPERVISOR' supervisor
					, gc.idGrupoCanal
					, gc.nombre grupoCanal
					, ca.idCanal
					, ca.nombre canal
					--, sca.idSubCanal
					--, sca.nombre subcanal
					, sca.idClienteTipo AS idSubCanal
					, sca.nombre AS subcanal
					, v.codCliente
					, v.razonSocial
					, v.direccion
					, v.idVisita
					, v.numFotos
					, v.estadoIncidencia
					, v.horaIni
					, v.horaFin
					, v.estado
					, r.fecha
					, CASE 
						WHEN v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND ISNULL(CASE WHEN vi.idVisitaIncidencia IS NOT NULL THEN 1 ELSE NULL END ,0) <> 1 AND v.idTipoExclusion IS NULL THEN 
						CASE 
							WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 'EFECTIVA' 
							ELSE 
								CASE 
								WHEN v.numFotos >=1 THEN 'EFECTIVA'
								WHEN v.idCliente IN(21599, 21665) THEN 'EFECTIVA'
								ELSE 'NO EFECTIVA'
								END
						END 
						WHEN vi.idVisitaIncidencia IS NOT NULL AND v.idTipoExclusion IS NULL THEN 'INCIDENCIA'
						WHEN v.idTipoExclusion IS NOT NULL THEN 'EXCLUSION'
						ELSE 'NO EFECTIVA'
					END estadoVisita
					, v.idFrecuencia
					, ROW_NUMBER() OVER (PARTITION BY v.idCliente ORDER BY v.razonSocial) cant_cliente

					{$segmentacion['columnas_bd']}

				FROM
					{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
					JOIN {$this->sessBDCuenta}.trade.data_visita v
						ON v.idRuta = r.idRuta
						AND r.fecha BETWEEN @fecIni AND @fecFin
						AND r.idTIpoUsuario IN(1,18)
					JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = v.idCliente 
						AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,r.fecha,r.fecha)=1 AND ch.idProyecto = r.idProyecto
					JOIN trade.proyecto py ON py.idProyecto = r.idProyecto
					JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
					JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1 
					JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado=1 AND ca.idCanal NOT IN (11)
					--LEFT JOIN trade.subCanal sca ON sca.idSubCanal = sn.idSubCanal AND sca.estado = 1
					JOIN trade.cliente_tipo sca ON sca.idClienteTipo = sn.idClienteTipo AND sca.estado = 1
					JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal 
					LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita 
					{$segmentacion['join']}
					
				WHERE
					1=1
					AND (r.demo = 0 OR r.demo IS NULL)
					AND v.estado = 1
					AND r.estado = 1
					
					{$subfiltros}
					
			)a
			WHERE
				1=1
			{$filtro}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];

		$rs =  $this->db->query($sql)->result_array();
		return $rs;
	}

	public function obtener_visitas_seg($input = array() ){
		
		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
		$sessIdProyecto = $this->sessIdProyecto;
		$input['idProyecto'] = $sessIdProyecto;

		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];
		$filtro = '';
		$subfiltros = '';

		if(empty($input['flagTotal'])){
			
			$subfiltros .= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal =' . $input['idGrupoCanal'] : '';
			$subfiltros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';
			$subfiltros .= !empty($input['idsubcanal']) ? 'AND sn.idClienteTipo =' . $input['idsubcanal'] : '';
		}
		$subfiltros .=!empty($input['str_visitas'])?'AND v.idVisita IN ('.$input['str_visitas'].')' :'';
		
		$subfiltros .= !empty($input['idProyecto']) ? 'AND r.idProyecto =' . $input['idProyecto'] : '';
		//$subfiltros .= !empty($input['idCuenta']) ? 'AND cu.idCuenta =' . $input['idCuenta'] : '';

		if(empty($input['flagTotal']))
		{
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['idGrupoCanal']]);
		}

		if(!empty($input['flagTotal']))
		{
			$segmentacion['join'] = "JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional 
			LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional 
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal
			LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
			LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
			LEFT JOIN trade.zona z ON ch.idZona = z.idZona
			LEFT JOIN trade.plaza pl ON pl.idPlaza = sct.idPlaza
			";
			$segmentacion['columnas_bd'] = "  
			, d.nombre AS distribuidora
			, ubi1.provincia AS ciudadDistribuidoraSuc
			, ubi1.cod_ubigeo AS codUbigeoDisitrito
			, ds.idDistribuidoraSucursal
			, pl.nombre AS plaza 
			, pl.idPlaza
			";
		}

		$sql = "
			DECLARE @fecha DATE = GETDATE(),@fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
				WITH list_usuarios_activos as(
					SELECT DISTINCT
					u.idUsuario
					FROM
					trade.usuario u 
					JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
					WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@fecha,@fecha) = 1 AND uh.idProyecto IN (".$input['idProyecto'].")
				)
				SELECT DISTINCT 
					  v.idCliente
					, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
					, gc.idGrupoCanal
					, gc.nombre grupoCanal
					, ca.idCanal
					, ca.nombre canal
					--, sca.idSubCanal
					--, sca.nombre subcanal
					, sca.idClienteTipo AS idSubCanal
					, sca.nombre AS subcanal
					, v.codCliente
					, c.codDist
					, v.razonSocial
					, v.direccion
					, v.idVisita
					, v.numFotos
					, v.estadoIncidencia
					, v.horaIni
					, v.horaFin
					, CONVERT(VARCHAR(8), v.horaIni) hora_ini
					, CONVERT(VARCHAR(8), v.horaFin) hora_fin
					, DATEDIFF(MINUTE,v.horaIni,v.horaFin) minutos
					, v.estado
					, r.fecha
					, r.nombreUsuario
					, r.idUsuario
					, r.idTipoUsuario
					, r.tipoUsuario
					, (SELECT TOP 1 nombreIncidencia FROM {$this->sessBDCuenta}.trade.data_visitaIncidencia WHERE idVisita = v.idVisita ORDER BY idVisitaIncidencia DESC) incidencia_nombre
					, (SELECT TOP 1 CONVERT(VARCHAR(8), hora) FROM {$this->sessBDCuenta}.trade.data_visitaIncidencia WHERE idVisita = v.idVisita ORDER BY idVisitaIncidencia DESC) incidencia_hora
					, ISNULL(v.latIni,0) lati_ini
					, ISNULL(v.lonIni,0) long_ini
					, ISNULL(v.latFin,0) lati_fin
					, ISNULL(v.lonFin,0) long_fin
					, ISNULL(c.latitud,0) latitud
					, ISNULL(c.longitud,0) longitud
					, v.idFrecuencia
					{$segmentacion['columnas_bd']}

				FROM
					{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
					JOIN {$this->sessBDCuenta}.trade.data_visita v
						ON v.idRuta = r.idRuta
						AND r.fecha BETWEEN @fecIni AND @fecFin
						AND r.idTIpoUsuario IN(1,18)
					JOIN trade.cliente c ON c.idCliente = v.idCliente
					JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = v.idCliente 
						AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,r.fecha,r.fecha)=1 AND ch.idProyecto = {$sessIdProyecto} 
					JOIN trade.proyecto py ON py.idProyecto = r.idProyecto
					JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
					JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1 
					JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado=1 AND ca.idCanal NOT IN (11)
					JOIN trade.cliente_tipo sca ON sca.idClienteTipo = sn.idClienteTipo AND sca.estado = 1
					JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal 
					LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita
					{$segmentacion['join']}
				WHERE
					1=1
					AND (r.demo = 0 OR r.demo IS NULL)
					AND v.estado = 1
					AND r.estado = 1
					AND v.idVisita IN(
						357028
					)
					{$subfiltros}
	
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_cartera_seg($input = array() ){
		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];
		$filtros = '';

		$input['idProyecto'] = $this->sessIdProyecto;

		$filtros.=!empty($input['idsubcanal'])?'AND sca.idClienteTipo ='.$input['idsubcanal'] :'';
		// $filtros.=!empty($input['tipo'])?'AND sca.idClienteTipo ='.$input['idsubcanal'] :'';
		$filtros .=!empty($input['str_clientes'])?'AND c.idCliente IN ('.$input['str_clientes'].')' :'';

		if(empty($input['str_clientes'])){
			$filtros .= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal =' . $input['idGrupoCanal'] : '';
			$filtros .= !empty($input['idCanal']) ? 'AND ca.idCanal =' . $input['idCanal'] : '';
		}

		$filtros .= !empty($input['idProyecto']) ? 'AND py.idProyecto =' . $input['idProyecto'] : '';
		$filtros .= !empty($input['idCuenta']) ? 'AND cu.idCuenta =' . $input['idCuenta'] : '';

		if(empty($input['flagTotal']))
		{
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['idGrupoCanal']]);
		}
		if(!empty($input['flagTotal']))
		{
			$segmentacion['join'] = "  JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional 
			LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional 
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal
			LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
			LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
			LEFT JOIN trade.zona z ON ch.idZona = z.idZona
			LEFT JOIN trade.plaza pl ON pl.idPlaza = sct.idPlaza

			";
			$segmentacion['columnas_bd'] = "  
			, d.nombre AS distribuidora
			, ubi1.provincia AS ciudadDistribuidoraSuc
			, ubi1.cod_ubigeo AS codUbigeoDisitrito
			, ds.idDistribuidoraSucursal
			, pl.nombre AS plaza 
			, pl.idPlaza
			";
		}

		$sql ="
			DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
			WITH lista_cartera AS(
				SELECT DISTINCT
					c.idCliente
					, 'EJECUTIVO' ejecutivo
					, 'COORDINADOR' coordinador
					, 'SUPERVISOR' supervisor
					, gc.idGrupoCanal
					, gc.nombre grupoCanal
					-- , CASE WHEN gc.idGrupoCanal=4 THEN d.nombre ELSE p.nombre END 'DISTRIBUIDORA-PLAZA'
					-- , CASE WHEN gc.idGrupoCanal=4 THEN ubd.departamento ELSE ubp.departamento END 'CIUDAD'
					, ca.idCanal
					, ca.nombre canal
					--, sca.idSubCanal
					--, sca.nombre subcanal
					, sca.idClienteTipo AS idSubCanal
					, sca.nombre AS subcanal
					, c.codCliente
					, c.codDist
					, c.razonSocial
					, c.direccion
					, ISNULL(co.cartera,0) cartera
					, COUNT(c.idCliente) OVER (PARTITION BY ca.idCanal,sca.idClienteTipo) total_subcanal
					, COUNT(c.idCliente) OVER () total
					, ROW_NUMBER() OVER (PARTITION BY c.idCliente ORDER BY c.razonSocial) fila_cliente

					{$segmentacion['columnas_bd']}
					
				FROM
					trade.cliente c WITH(NOLOCK)
					JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente 
						AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
					JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
					JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
					JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1 
					JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado=1 AND ca.idCanal NOT IN (11)
					--LEFT JOIN trade.subCanal sca ON sca.idSubCanal = sn.idSubCanal AND sca.estado = 1
					JOIN trade.cliente_tipo sca ON sca.idClienteTipo = sn.idClienteTipo AND sca.estado = 1
					JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal 
					LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
					
					-- JOIN trade.segmentacionClienteTradicional scm ON scm.idSegClienteTradicional = ch.idSegClienteTradicional
					-- LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = scm.idDistribuidoraSucursal
					-- LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora AND d.estado=1
					-- LEFT JOIN General.dbo.ubigeo ubd ON ubd.cod_ubigeo = ds.cod_ubigeo
					-- LEFT JOIN trade.plaza p ON p.idPlaza = scm.idPlaza
					-- LEFT JOIN General.dbo.ubigeo ubp ON ubp.cod_ubigeo = p.cod_ubigeo
					LEFT JOIN {$this->sessBDCuenta}.trade.cartera_objetivo co
						ON co.idSubCanal = sca.idClienteTipo
					{$segmentacion['join']}
				WHERE
					c.estado = 1 
					{$filtros}
				)
				SELECT * FROM lista_cartera 
				WHERE fila_cliente = 1
		";
		
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtenerUsuariosPermisosDistribuidoraSucursal($input)
	{
		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];

		$sql = "
		DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
		SELECT DISTINCT
		u.idUsuario
		,ISNULL(u.nombres,'') + ' ' +ISNULL(u.apePaterno,'') + ' ' +ISNULL(u.apeMaterno,'') nombreUsuario
		,u.numDocumento
		,uhds.idDistribuidoraSucursal
		,ut.idTipoUsuario
		,ut.nombre tipoUsuario
		FROM trade.usuario u 
		JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario AND uh.idTipoUsuario IN(2,11,17) AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
		JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = uh.idTipoUsuario
		JOIN trade.usuario_historicoDistribuidoraSucursal uhds ON uhds.idUsuarioHist = uh.idUsuarioHist AND uhds.estado = 1
		";
		return $this->db->query($sql)->result_array();
	}
	public function obtenerUsuariosPermisosPlaza($input)
	{
		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];

		$sql = "
		DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
		SELECT DISTINCT
		u.idUsuario
		,ISNULL(u.nombres,'') + ' ' +ISNULL(u.apePaterno,'') + ' ' +ISNULL(u.apeMaterno,'') nombreUsuario
		,u.numDocumento
		,uhp.idPlaza
		,ut.idTipoUsuario
		,ut.nombre tipoUsuario
		FROM trade.usuario u 
		JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario AND uh.idTipoUsuario IN(2,11,17) AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
		JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = uh.idTipoUsuario
		JOIN trade.usuario_historicoPlaza uhp ON uhp.idUsuarioHist = uh.idUsuarioHist
		";
		return $this->db->query($sql)->result_array();
	}
	public function obtenerUsuariosPermisosBanner($input)
	{
		$fecIni = $input['fecIni'];
		$fecFin = $input['fecFin'];

		$sql = "
		DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
		SELECT DISTINCT
		u.idUsuario
		,ISNULL(u.nombres,'') + ' ' +ISNULL(u.apePaterno,'') + ' ' +ISNULL(u.apeMaterno,'') nombreUsuario
		,u.numDocumento
		,uhb.idBanner
		,ut.idTipoUsuario
		,ut.nombre tipoUsuario
		FROM trade.usuario u 
		JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario AND uh.idTipoUsuario IN(2,11,17) AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
		JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = uh.idTipoUsuario
		JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist
		";
		return $this->db->query($sql)->result_array();
	}

}
?>