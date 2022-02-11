<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_evidenciaFoto extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function obtener_visitas($input=array()){
		
		$filtros = "";

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
		
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
		$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
		$filtros .= !empty($input['canal_filtro']) ? ' AND ca.idCanal='.$input['canal_filtro'] : '';
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';

		$filtros .= !empty($input['departamento_filtro']) ? ' AND ubi.cod_departamento='.$input['departamento_filtro'] : '';
		$filtros .= !empty($input['provincia_filtro']) ? ' AND ubi.cod_provincia='.$input['provincia_filtro'] : '';
		$filtros .= !empty($input['distrito_filtro']) ? ' AND ubi.cod_ubigeo='.$input['distrito_filtro'] : '';

		}
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}


		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion($input);
		
		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT
			r.idRuta
			, r.fecha
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
			, r.idUsuario
			, r.nombreUsuario
			, ut.nombre AS tipoUsuario
			, v.idVisita
			, v.canal
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

			, ct.nombre subCanal
			, gca.nombre grupoCanal
			{$segmentacion['columnas_bd']}
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotografica dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
		JOIN {$cliente_historico} ch ON v.idCliente = ch.idCliente
			AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1 AND ch.idProyecto = {$input['proyecto_filtro']}
		LEFT JOIN trade.cliente c ON v.idCliente = c.idCliente
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
		LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
		LEFT JOIN trade.subCanal subca ON subca.idSubCanal = sn.idSubcanal
		{$segmentacion['join']}
		WHERE r.estado=1 AND v.estado=1 
		AND r.fecha BETWEEN @fecIni AND @fecFin
		$filtros
		ORDER BY fecha, departamento, canal, tipoUsuario, supervisor, nombreUsuario  ASC
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_detalle_evidencia_fotografica($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
			$filtros .= !empty($input['idElemento']) ? ' AND ele.idProducto IN ('.$input['idElemento'].')' : '';
			$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
			$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
	
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT
				r.idRuta
				, r.fecha
				, v.idVisita
				, ISNULL(UPPER(tf.nombre),'OTROS') tipoFoto
				, ISNULL(CONVERT(VARCHAR,tf.idTipoFoto),'otros')  idTipoFoto
				, dvd.comentario 'comentario'
				, dvd.estado
				, vf.fotoUrl 'foto'
				, vf.idVisitaFoto
				, vft.idTipoFotoEvidencia
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotografica dvv ON dvv.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotograficaDet dvd ON dvd.idVisitaEvidenciaFotografica=dvv.idVisitaEvidenciaFotografica
			LEFT JOIN trade.foto_tipo tf ON tf.idTipoFoto = dvd.idTipoFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotograficaDetFoto vft ON vft.idVisitaEvidenciaFotograficaDet = dvd.idVisitaEvidenciaFotograficaDet
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vft.idVisitaFoto
			WHERE r.estado=1 AND v.estado=1 
			AND r.fecha BETWEEN @fecIni AND @fecFin
			$filtros

			ORDER BY idTipoFoto
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_fotos($fotos){
		$sql="
			SELECT 
				UPPER('evidenciaFotografica') modulo
				, CONVERT(VARCHAR(8),vf.hora)hora
				, vf.fotoUrl foto
			FROM 
				{$this->sessBDCuenta}.trade.data_visitaFotos vf
				JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo
			WHERE 
				vf.idVisitaFoto IN({$fotos})";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}
}
?> 