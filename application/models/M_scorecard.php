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
				trade.cliente c
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
		$filtros.=!empty($input['tipo'])?'AND sca.idClienteTipo ='.$input['idsubcanal'] :'';
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
				, c.razonSocial
				, c.direccion
				, ISNULL(co.cartera,0) cartera
				, COUNT(c.idCliente) OVER (PARTITION BY sca.idClienteTipo) total_subcanal
				, COUNT(c.idCliente) OVER () total
				
			FROM
				trade.cliente c
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente 
					AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
				JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
				JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1 
				JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado=1 AND ca.idCanal NOT IN (11)
				--LEFT JOIN trade.subCanal sca ON sca.idSubCanal = sn.idSubCanal AND sca.estado = 1
				JOIN trade.cliente_tipo sca ON sca.idClienteTipo = sn.idClienteTipo AND sca.estado = 1
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal 
				
				JOIN trade.segmentacionClienteTradicional scm ON scm.idSegClienteTradicional = ch.idSegClienteTradicional
				LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
				LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = scm.idDistribuidoraSucursal
				LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora AND d.estado=1
				LEFT JOIN General.dbo.ubigeo ubd ON ubd.cod_ubigeo = ds.cod_ubigeo
				LEFT JOIN trade.plaza p ON p.idPlaza = scm.idPlaza
				LEFT JOIN General.dbo.ubigeo ubp ON ubp.cod_ubigeo = p.cod_ubigeo

				LEFT JOIN trade.cartera_objetivo co
					ON co.idSubCanal = sca.idClienteTipo
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
		$subfiltros .= !empty($input['idProyecto']) ? 'AND r.idProyecto =' . $input['idProyecto'] : '';
		//$subfiltros .= !empty($input['idCuenta']) ? 'AND cu.idCuenta =' . $input['idCuenta'] : '';

		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $subfiltros .=  " AND r.demo = 0";
			else $subfiltros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$sql = "
			DECLARE @fecIni date='".$fecIni."',@fecFin date='".$fecFin."';
			SELECT 
				*
				, COUNT(idCliente) OVER (PARTITION BY idSubCanal,estadoVisita) total_subcanal
				, COUNT(idCliente) OVER (PARTITION BY idSubCanal) visitas_programadas
			FROM (
				SELECT DISTINCT 
					  v.idCliente
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
						WHEN v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND v.numFotos >= 1 AND estadoIncidencia <> 1 THEN 'EFECTIVA'  
						WHEN v.horaIni IS NULL AND v.horaFin IS NULL AND v.numFotos IS NULL AND estadoIncidencia = 1 THEN 'INCIDENCIA'
						ELSE 'NO EFECTIVA'
					END estadoVisita
					, v.idFrecuencia
				FROM
					trade.data_ruta r
					JOIN trade.data_visita v
						ON v.idRuta = r.idRuta
						AND r.fecha BETWEEN @fecIni AND @fecFin
					
					JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = v.idCliente 
						AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1 AND ch.idProyecto = {$sessIdProyecto} 
					JOIN trade.proyecto py ON py.idProyecto = r.idProyecto
					JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
					JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1 
					JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado=1 AND ca.idCanal NOT IN (11)
					--LEFT JOIN trade.subCanal sca ON sca.idSubCanal = sn.idSubCanal AND sca.estado = 1
					JOIN trade.cliente_tipo sca ON sca.idClienteTipo = sn.idClienteTipo AND sca.estado = 1
					JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal 
					
					LEFT JOIN trade.segmentacionClienteTradicional scm ON scm.idSegClienteTradicional = ch.idSegClienteTradicional
					LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = v.cod_ubigeo
					LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = scm.idDistribuidoraSucursal
					LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora AND d.estado=1
					LEFT JOIN General.dbo.ubigeo ubd ON ubd.cod_ubigeo = ds.cod_ubigeo
					LEFT JOIN trade.plaza p ON p.idPlaza = scm.idPlaza
					LEFT JOIN General.dbo.ubigeo ubp ON ubp.cod_ubigeo = p.cod_ubigeo
				WHERE
					1=1
					
					{$subfiltros}
			)a
			WHERE
				1=1
				{$filtro}
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $this->db->query($sql)->result_array();
	}

}
?>