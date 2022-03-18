<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_materialpop extends MY_Model{
	
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
		$filtros .= !empty($input['canal_filtro']) ? ' AND ca.idCanal='.$input['canal_filtro'] : '';
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';
		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND (z.idZona='.$input['zona_filtro']." OR uhz.idZona = {$input['zona_filtro']}) " : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';

		//Ubigeo
		$filtros .= !empty($input['departamento_filtro']) ? ' AND ubi.cod_departamento='.$input['departamento_filtro'] : '';
		$filtros .= !empty($input['provincia_filtro']) ? ' AND ubi.cod_provincia='.$input['provincia_filtro'] : '';
		$filtros .= !empty($input['distrito_filtro']) ? ' AND ubi.cod_ubigeo='.$input['distrito_filtro'] : '';

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
			, ISNULL(pgc.nombre,gca.nombre) grupoCanal

			{$segmentacion['columnas_bd']}
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN trade.usuario_historico uh ON r.idUsuario = uh.idUsuario
			AND uh.idProyecto = r.idProyecto
			AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,r.fecha,r.fecha) = 1
		LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist
			AND uhz.estado = 1
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaMaterialesPop dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
		LEFT JOIN trade.proyectoGrupoCanal pgc ON pgc.idGrupoCanal = gca.idGrupoCanal AND pgc.idProyecto = {$this->sessIdProyecto}
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
		JOIN {$cliente_historico} ch ON v.idCliente = ch.idCliente
			AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,r.fecha,r.fecha)=1 AND ch.idProyecto = {$input['proyecto_filtro']}
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
    public function obtener_detalle_material_pop($input=array()){
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
			

			if((!empty($input['flagPropios']) && empty($input['flagCompetencia'])) || (empty($input['flagPropios']) && !empty($input['flagCompetencia']))){
					$filtros .= !empty($input['flagPropios']) ? ' AND ele.flagCompetencia = 0': '';
					$filtros .= !empty($input['flagCompetencia']) ? ' AND ele.flagCompetencia = 1': '';
			} 
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT
                r.idRuta
                , r.fecha
                , v.idVisita
                , dvd.idMarca
                , m.nombre marca
                , dvd.cantidad
                , dvd.latitud
                , dvd.longitud
                , tm.idTipoMaterial
                , UPPER(tm.nombre) tipoMaterial
                , vf.fotoUrl foto
                , amg.carpetaFoto carpeta
            FROM {$this->sessBDCuenta}.trade.data_ruta r
            JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
            JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
            JOIN trade.canal ca ON ca.idCanal=v.idCanal
            JOIN {$this->sessBDCuenta}.trade.data_visitaMaterialesPop dvv ON dvv.idVisita=v.idVisita
            JOIN {$this->sessBDCuenta}.trade.data_visitaMaterialesPopDet dvd ON dvd.idVisitaMaterialPop=dvv.idVisitaMaterialPop
            LEFT JOIN {$this->sessBDCuenta}.trade.tipo_material tm ON tm.idTipoMaterial = dvd.idTipoMaterial
            LEFT JOIN trade.producto_marca m ON m.idMarca = dvd.idMarca
            LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=dvd.idVisitaFoto
            LEFT JOIN trade.aplicacion_modulo am ON am.idModulo = vf.idModulo
			LEFT JOIN trade.aplicacion_modulo_grupo amg ON amg.idModuloGrupo = am.idModuloGrupo
			WHERE r.estado=1 AND v.estado=1 
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
    public function obtener_lista_elementos_material_pop($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
			$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
			$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT 
				v.idVisita 
				, lstd.idMarca
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaMaterialesPop vi ON vi.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.list_material_pop_marca lst ON lst.idListMaterialesPopMarca=v.idListMaterialesPopMarca
			JOIN {$this->sessBDCuenta}.trade.list_material_pop_marca_det lstd ON lstd.idListMaterialesPopMarca=lst.idListMaterialesPopMarca
	
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
	
			WHERE r.estado=1 AND v.estado=1
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
}
?>