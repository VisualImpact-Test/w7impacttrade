<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ordenTrabajo extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function obtener_visitas($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
		$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
		$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';

		$filtros .= !empty($input['tipoUsuario_filtro']) ? " AND uh.idTipoUsuario=".$input['tipoUsuario_filtro'] : "";
		$filtros .= !empty($input['usuario_filtro']) ? " AND uh.idUsuario=".$input['usuario_filtro'] : "";

		$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		}

		$segmentacion = getSegmentacion($input);

		$sql = "
			DECLARE @fecIni DATE = '".$input['fecIni']."',@fecFin DATE = '".$input['fecFin']."';
			SELECT DISTINCT
				r.idRuta
				, CONVERT(VARCHAR,r.fecha,103) AS fecha
				, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
				, r.idUsuario
				, r.nombreUsuario
				, ut.nombre AS tipoUsuario
				, v.idVisita
				, gc.nombre AS grupoCanal
				, v.canal
				, sc.nombre AS subCanal
				, v.idCliente
				, v.codCliente
				, c.codDist
				, v.nombreComercial
				, v.razonSocial
				, ct.nombre AS tipoCliente
				, v.cod_ubigeo
				, ubi.departamento
				, ubi.provincia
				, ubi.distrito
				, v.direccion
				, v.idPlaza

				--, pl.nombre AS plaza
				--, v.idDistribuidoraSucursal
				--, ds.idDistribuidora
				--, d.nombre AS distribuidora
				--, ds.cod_ubigeo
				--, ubi1.distrito AS ciudadDistribuidoraSuc
				--, ubi1.cod_ubigeo AS codUbigeoDistrito
				--, z.nombre AS zona

				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
				AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				AND uh.idProyecto=r.idProyecto
				
			JOIN ".getClienteHistoricoCuenta()." ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
			LEFT JOIN trade.cliente c ON v.idCliente = c.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc 
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo

			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvd ON vvd.idVisitaVisibilidad=vvo.idVisitaVisibilidad

			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo

			--LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
			--LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
			--LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
			--LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo


			LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
			LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
			LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrdenTrabajoDet vot ON vot.idVisitaVisibilidad=vvd.idVisitaVisibilidad and vot.idElementoVis=vvd.idElementoVis and vot.estado=1
			{$segmentacion['join']}
			WHERE r.estado=1 
			AND v.estado=1 
			AND r.demo=0
			and (vvd.idObservacion NOT IN (1,2,3) OR vvd.idObservacion IS NULL)
			AND ( vot.validado IS NULL OR vot.validado=0)
			AND r.fecha BETWEEN @fecIni AND @fecFin
			$filtros
			ORDER BY fecha, departamento, canal, supervisor, nombreUsuario  ASC
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_detalle_orden($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
		}

		$sql = "
			DECLARE @fecIni DATE = '".$input['fecIni']."',@fecFin DATE = '".$input['fecFin']."';
			SELECT DISTINCT 
				r.idRuta
				, CONVERT(VARCHAR,r.fecha,103) AS fecha
				, v.idVisita
				, vvd.idVisitaVisibilidadDet
				, vvd.idVisitaVisibilidad
				, vvd.idElementoVis
				, ele.nombre elemento
				, vvd.idVariable
				, vvd.cantidad
				, vvd.presencia
				, vvd.comentario
				, vvd.idObservacion
				, obs.descripcion observacion
				, vvd.habilitarOt
				, vot.idVisitaOrdenTrabajoDet

				, vot.idVisitaFotoCerca
				, dvfCerca.fotoUrl fotoCerca

				, vot.idVisitaFotoPanoramica
				, dvfParo.fotoUrl fotoPanoramica
				, vot.validado

			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvd ON vvd.idVisitaVisibilidad=vvo.idVisitaVisibilidad

			JOIN trade.elementoVisibilidadTrad ele ON ele.idElementoVis=vvd.idElementoVis

			LEFT JOIN trade.observacionElementoVisibilidadObligatorio obs ON obs.idObservacion=vvd.idObservacion

			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrdenTrabajoDet vot ON vot.idVisitaVisibilidad=vvd.idVisitaVisibilidad and vot.idElementoVis=vvd.idElementoVis and vot.estado=1
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvfCerca ON dvfCerca.idVisitaFoto=vot.idVisitaFotoCerca
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvfParo ON dvfParo.idVisitaFoto=vot.idVisitaFotoPanoramica

			WHERE r.estado=1 
			AND v.estado=1 
			AND r.demo=0
			and (vvd.idObservacion NOT IN (1,2,3) OR vvd.idObservacion IS NULL)
			AND ( vot.validado IS NULL OR vot.validado=0)
			AND r.fecha BETWEEN @fecIni AND @fecFin
			$filtros
		";
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}


	public function obtener_permisos_modulos($input=array()){
		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND a.idCuenta='.$input['idCuenta'] : '';

		$sql="
			SELECT DISTINCT a.idCuenta, m.idTipoUsuario, mo.idModuloGrupo FROM trade.usuario_tipo_modulo m
			JOIN trade.aplicacion_modulo mo ON mo.idModulo = m.idModulo
			JOIN trade.aplicacion a ON a.idAplicacion = mo.idAplicacion
			WHERE m.estado = 1 $filtros ";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_fotos($idVisita){
		$sql="
			SELECT 
				UPPER(m.nombre) modulo
				, CONVERT(VARCHAR(8),vf.hora)hora
				, vf.fotoUrl foto
			FROM 
				{$this->sessBDCuenta}.trade.data_visitaFotos vf
				JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo
			WHERE 
				idVisita = $idVisita";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_tipos(){
		$sql="
			select 
				idTipoElementoCompetencia,nombre 
			from trade.tipoElementoCompetencia
			where estado=1";
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}
		return $result;
	}

	public function habilitar_visibilidad_auditoria($input=array()){

		$update = [
			'habilitarOt' =>$input['estado']
		];

		$where = [
			"idVisitaVisibilidad"=> $input['idVisitaVisibilidad'],
			"idElementoVis"=> $input['idElemento']
		];

		$this->db->where($where);
		$update = $this->db->update("{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet", $update);
		return $update;
	}


	public function validar_orden($input=array()){

		$update = [
			'validado' =>$input['estado']
		];

		$where = [
			"idVisitaOrdenTrabajoDet"=> $input['idVisitaOrdenTrabajoDet'],
		];

		$this->db->where($where);
		$update = $this->db->update("{$this->sessBDCuenta}.trade.data_visitaOrdenTrabajoDet", $update);
		return $update;
	}


	public function obtener_detallado_pdf($input=array()){
		$filtros = "";
		if(!empty($input['elementos_det'])){
			$filtros .= " AND ( ";
			$i=0;
			foreach($input['elementos_det'] as $row){
				if($i==0){
					$filtros .= " ( vvd.idVisitaVisibilidad=".$row['idVisitaVisibilidad']." AND vvd.idElementoVis=".$row['idElemento']." ) ";
				}else{
					$filtros .= " OR ( vvd.idVisitaVisibilidad=".$row['idVisitaVisibilidad']." AND vvd.idElementoVis=".$row['idElemento']." )";
				}
				$i++;
			}
			$filtros .= " )";
		}

		$sql = "
				SELECT distinct 
					r.idRuta
					, gc.idGrupoCanal
					, gc.nombre as grupoCanal
					, c.idCanal
					, c.nombre as canal
					, v.idVisita
					, v.idCliente
					, ch.razonSocial
					, ch.codCliente
					, r.idUsuario
					, u.apePaterno+' '+u.apeMaterno+' '+u.nombres as empleado
					, CONVERT(VARCHAR(10),r.fecha,103) as fecha
					
					, vvd.idVisitaVisibilidadDet
					, vvd.idVisitaVisibilidad
					, vvd.idElementoVis
					, ele.nombre elemento
					, vvd.idVariable
					, vvd.cantidad
					, vvd.presencia
					
					, vvd.comentario
					, vvd.idObservacion
					, obs.descripcion observacion
					, vvd.habilitarOt
					, vot.idVisitaOrdenTrabajoDet
					, v.codCliente

					, vot.idVisitaFotoCerca
					, dvfCerca.fotoUrl fotoCerca

					, vot.idVisitaFotoPanoramica
					, dvfParo.fotoUrl fotoPanoramica
					, vot.validado

					,dvf.idVisitaFoto
					,dvf.fotoUrl
					, dvf.hora

				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
				JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisita=v.idVisita
				JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvd ON vvd.idVisitaVisibilidad=vvo.idVisitaVisibilidad
				JOIN trade.canal c ON c.idCanal =  v.idCanal
				JOIN trade.usuario u ON u.idUsuario=r.idUsuario
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=v.idCliente  
					AND r.fecha between ch.fecIni and ISNULL(ch.fecFin,  r.fecha)
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal =  c.idGrupoCanal

				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvf ON dvf.idVisitaFoto=vvd.idVisitaFoto

				JOIN trade.elementoVisibilidadTrad ele ON ele.idElementoVis=vvd.idElementoVis

				LEFT JOIN trade.observacionElementoVisibilidadObligatorio obs ON obs.idObservacion=vvd.idObservacion

				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrdenTrabajoDet vot ON vot.idVisitaVisibilidad=vvd.idVisitaVisibilidad and vot.idElementoVis=vvd.idElementoVis and vot.estado=1
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvfCerca ON dvfCerca.idVisitaFoto=vot.idVisitaFotoCerca
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvfParo ON dvfParo.idVisitaFoto=vot.idVisitaFotoPanoramica

				WHERE r.estado=1 
				AND v.estado=1 
				AND r.demo=0
				and (vvd.idObservacion NOT IN (1,2,3) OR vvd.idObservacion IS NULL)
				AND ( vot.validado IS NULL OR vot.validado=0)
				$filtros ";
				

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}
  
  
}
?>