<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_inteligencia extends MY_Model{
	
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
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT
				r.idRuta
				, CONVERT(varchar, r.fecha, 103) fecha
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
				--, ubi1.cod_ubigeo AS codUbigeoDisitrito

				{$segmentacion['columnas_bd']}
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN ".getClienteHistoricoCuenta()." ch
				ON ch.idCliente = v.idCliente AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
			JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
			 and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
			 and uh.idProyecto=r.idProyecto


			LEFT JOIN trade.cliente c ON v.idCliente = c.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc 
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			JOIN trade.data_visitaInteligencia dvv ON dvv.idVisita=v.idVisita
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN trade.grupoCanal gc ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo

			LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
			LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
			LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
			{$segmentacion['join']}
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			AND r.demo = 0 AND r.estado = 1 AND v.estado = 1{$filtros}
			ORDER BY fecha, departamento, canal, tipoUsuario, supervisor, nombreUsuario  ASC
		";		
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_detalle_inteligencia($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
			$filtros .= !empty($input['idTipo']) ? ' AND cp.idTipoElementoCompetencia='.$input['idTipo'] : '';
			
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT
				r.idRuta
				, r.fecha
				, v.idVisita
				, pm.idMarca
				, pm.nombre 'marca'
				, pc.idCategoria
				, pc.nombre 'categoria'
				, vitd.idTipoElementoCompetencia
				, cp.nombre 'tipo'

				, vitd.nombreSku
				, vitd.versionSku
				, vitd.tamanoSku
				, vitd.precioSku

				, vitd.nombreElemento

				, vitd.objetivoIniciativa
				, vitd.vigenciaIniIniciativa
				, vitd.vigenciaFinIniciativa

				, vitd.nombreSkuPrecio
				, vitd.tamanoPrecio
				, vitd.precioAnterior
				, vitd.precioActual

				, vitd.descripcionActivacion
				, vitd.vigenciaIniActivacion
				, vitd.vigenciaFinActivacion

				, vitd.nombreSku
				, vitd.cantidadSku
				, umi.nombre AS umSku
				, vitd.accion

				, vf.fotoUrl 'foto'
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal 
			JOIN trade.data_visitaInteligencia vit ON vit.idVisita=v.idVisita
			JOIN trade.data_visitaInteligenciaDet vitd ON vitd.idVisitaInteligencia=vit.idVisitaInteligencia
	
			JOIN trade.producto_categoria pc ON pc.idCategoria=vitd.idCategoria
			JOIN trade.producto_marca pm ON pm.idMarca=vitd.idMarca
			JOIN trade.tipoElementoCompetencia cp ON cp.idTipoElementoCompetencia=vitd.idTipoElementoCompetencia
			LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto=vitd.idVisitaFoto
			LEFT JOIN trade.unidadMedidaInteligencia umi ON vitd.idUnidadMedida = umi.idUnidadMedida
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			AND r.demo = 0 AND r.estado = 1 AND v.estado = 1{$filtros}
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
				trade.data_visitaFotos vf
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
  
  
}
?>