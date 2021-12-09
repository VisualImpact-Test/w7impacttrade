<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_surtido extends MY_Model{
	
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
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? " AND uh.idTipoUsuario=".$input['tipoUsuario_filtro'] : "";
		$filtros .= !empty($input['usuario_filtro']) ? " AND uh.idUsuario=".$input['usuario_filtro'] : "";

		$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		}
		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion($input);

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT
				r.idRuta
				, CONVERT(VARCHAR,r.fecha,103) AS fecha
				, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
				, r.idUsuario
				, r.nombreUsuario
				, r.tipoUsuario
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

				, gc.nombre grupoCanal
				, ct.nombre subCanal
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
				and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				and uh.idProyecto=r.idProyecto

			JOIN {$this->sessBDCuenta}.trade.data_visitaSurtido dvv ON dvv.idVisita=v.idVisita
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			JOIN trade.cliente c ON v.idCliente = c.idCliente
			JOIN {$cliente_historico} ch ON ch.idCliente = c.idCliente AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1 AND ch.idProyecto = {$input['proyecto_filtro']}
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo

			LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
			LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal subca ON subca.idSubCanal = sn.idSubcanal
			LEFT JOIN trade.cliente_tipo ct
					ON ct.idClienteTipo = sn.idClienteTipo
			{$segmentacion['join']}
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			--AND r.demo = 0 
			AND r.estado = 1 
			AND v.estado=1
			{$filtros}
			ORDER BY fecha, departamento, canal, tipoUsuario, supervisor, nombreUsuario  ASC
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_detalle_surtido($input=array()){
		$filtros = "";

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
			$filtros .= !empty($input['idElemento']) ? ' AND ele.idProducto IN ('.$input['idElemento'].')' : '';
		}

		// DATOS DEMO
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
            SELECT DISTINCT
			r.idRuta
			, r.fecha
			, v.idVisita
			, dvd.idProducto
			, ele.nombre 'elemento'
			, pc.idCategoria
			, pc.nombre 'categoria'
			, dvd.presencia
			, vf.fotoUrl 'foto'
			, dvd.observacion 
            FROM {$this->sessBDCuenta}.trade.data_ruta r
            JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
            JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
            JOIN trade.canal ca ON ca.idCanal=v.idCanal
            JOIN {$this->sessBDCuenta}.trade.data_visitaSurtido dvv ON dvv.idVisita=v.idVisita
            JOIN {$this->sessBDCuenta}.trade.data_visitaSurtidoDet dvd ON dvd.idVisitaSurtido=dvv.idVisitaSurtido
            JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
            JOIN trade.producto_categoria pc ON pc.idCategoria=ele.idCategoria
            LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=dvd.idVisitaFoto
            WHERE r.fecha BETWEEN @fecIni AND @fecFin
            AND r.estado = 1 
			AND v.estado = 1{$filtros}
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_lista_elementos_surtido($input=array()){
		$filtros = "";

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
		}

		// DATOS DEMO
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT 
				v.idVisita 
				, lstd.idProducto
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaSurtido vi ON vi.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.list_surtido lst ON lst.idListSurtido=v.idListSurtido
			JOIN {$this->sessBDCuenta}.trade.list_surtidoDet lstd ON lstd.idListSurtido=lst.idListSurtido
	
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
	
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			AND r.estado = 1 AND v.estado = 1{$filtros}
		";

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

	public function obtener_elementos($input=array()){
		$sql = "
			select distinct ele.idProducto, ele.nombre 
			from trade.producto ele
			where ele.estado=1 and ele.idCuenta=".$input['idCuenta']."
			order by ele.nombre;
		";
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}
		return $result;
	}
}
?>