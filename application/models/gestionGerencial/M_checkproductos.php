<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_checkproductos extends MY_Model{
	
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

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';

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

			--, pl.nombre AS plaza
			--, v.idDistribuidoraSucursal
			--, ds.idDistribuidora
			--, d.nombre AS distribuidora
			--, ds.cod_ubigeo
			--, ubi1.distrito AS ciudadDistribuidoraSuc
			--, ubi1.cod_ubigeo AS codUbigeoDisitrito

			, subca.nombre subCanal
			, gca.nombre grupoCanal
			{$segmentacion['columnas_bd']}
		FROM trade.data_ruta r
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		JOIN trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		--LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
		--LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		--LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		--LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
		JOIN {$cliente_historico} ch ON v.idCliente = ch.idCliente
			AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$input['proyecto_filtro']}
		LEFT JOIN trade.cliente c ON v.idCliente = c.idCliente
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
		LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
		LEFT JOIN trade.subCanal subca ON subca.idSubCanal = sn.idSubcanal
		{$segmentacion['join']}
		WHERE r.estado=1 AND v.estado=1 AND r.demo=0
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

	public function obtener_detalle_checklist($input=array()){
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
				, dvd.idProducto
				, ele.nombre 'elemento'
				, pc.idCategoria
				, pc.nombre 'categoria'
				, dvd.presencia
				, dvd.stock
				, dvd.idUnidadMedida
				, vf.fotoUrl 'foto'
				, um.nombre 'unidadMedida'
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
			JOIN trade.producto_categoria pc ON pc.idCategoria=ele.idCategoria
			LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto=dvd.idVisitaFoto
			LEFT JOIN trade.unidadMedida um ON um.idUnidadMedida = dvd.idUnidadMedida
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


	public function obtener_lista_elementos_visibilidad($input=array()){
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
				, lstd.idProducto
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.data_visitaProductos vi ON vi.idVisita=v.idVisita
			JOIN trade.list_productos lst ON lst.idListProductos=v.idListProductos
			JOIN trade.list_productosDet lstd ON lstd.idListProductos=lst.idListProductos
	
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

	public function obtener_quiebre($params = [])
	{
		$filtros = "";
		if(empty($params['proyecto_filtro'])){
			$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta='.$params['idCuenta'] : '';
			$filtros .= !empty($params['proyecto_filtro']) ? ' AND r.idProyecto='.$params['proyecto_filtro'] : '';
			$filtros .= !empty($params['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$params['grupoCanal_filtro'] : '';
			$filtros .= !empty($params['canal_filtro']) ? ' AND ca.idCanal='.$params['canal_filtro'] : '';
			$filtros .= !empty($params['quiebre']) ? ' AND dvd.quiebre='.$params['quiebre'] : ' AND (dvd.quiebre='.$params['quiebre'].' OR dvd.quiebre IS NULL)';

			$filtros .= !empty($params['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$params['distribuidora_filtro'] : '';
			$filtros .= !empty($params['zona_filtro']) ? ' AND z.idZona='.$params['zona_filtro'] : '';
			$filtros .= !empty($params['plaza_filtro']) ? ' AND pl.idPlaza='.$params['plaza_filtro'] : '';
			$filtros .= !empty($params['cadena_filtro']) ? ' AND cad.idCadena='.$params['cadena_filtro'] : '';
			$filtros .= !empty($params['banner_filtro']) ? ' AND ba.idBanner='.$params['banner_filtro'] : '';
		}

		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion($params);
		
		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}

		$sql = "
			DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecFin']."';
			SELECT
				cu.nombre AS cuenta
				, gca.nombre AS grupoCanal
				, ca.nombre AS canal
				, v.codCliente
				, v.nombreComercial
				, ele.nombre AS producto
				, ISNULL(dvd.quiebre,0) AS quiebre
				, mo.nombre AS motivo
				, subca.nombre subCanal
				, v.idCliente
				, v.razonSocial
				{$segmentacion['columnas_bd']}
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cliente cli ON v.idCliente = cli.idCliente
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$params['proyecto_filtro']}
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			JOIN trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			LEFT JOIN trade.motivo mo ON dvd.idMotivo=mo.idMotivo
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
			LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
			{$segmentacion['join']}
			WHERE r.estado = 1 AND v.estado = 1 
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
			{$filtro_demo}
			ORDER BY nombreComercial
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_fifo($params = [])
	{
		$filtros = "";
		if(empty($params['proyecto_filtro'])){
			$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta='.$params['idCuenta'] : '';
			$filtros .= !empty($params['proyecto_filtro']) ? ' AND r.idProyecto='.$params['proyecto_filtro'] : '';
			$filtros .= !empty($params['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$params['grupoCanal_filtro'] : '';
			$filtros .= !empty($params['canal_filtro']) ? ' AND ca.idCanal='.$params['canal_filtro'] : '';
			// $filtros .= ' AND dvd.quiebre='.$params['quiebre'];

			$filtros .= !empty($params['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$params['distribuidora_filtro'] : '';
			$filtros .= !empty($params['zona_filtro']) ? ' AND z.idZona='.$params['zona_filtro'] : '';
			$filtros .= !empty($params['plaza_filtro']) ? ' AND pl.idPlaza='.$params['plaza_filtro'] : '';
			$filtros .= !empty($params['cadena_filtro']) ? ' AND cad.idCadena='.$params['cadena_filtro'] : '';
			$filtros .= !empty($params['banner_filtro']) ? ' AND ba.idBanner='.$params['banner_filtro'] : '';
		}

		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion($params);

		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}

		$sql = "
			DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecFin']."';
			SELECT
				cu.nombre AS cuenta
				, gca.nombre AS grupoCanal
				, ca.nombre AS canal
				, subca.nombre subCanal
				, v.idCliente
				, v.codCliente
				, v.nombreComercial
				, v.razonSocial
				, ele.nombre AS producto
				, dvd.cantidadVencida
				, dvd.fechaVencido
				, um.nombre unidadMedida
				, CASE 
					WHEN dvd.fechaVencido IS NOT NULL THEN  CAST(DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) AS varchar) 
					WHEN dvd.fechaVencido IS NULL THEN 'No vence'
				END diasVencimiento
				, CASE 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) <= 0 THEN 'red' 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) <= 10 THEN '#fbbd08' 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) > 10 THEN '#08cf37' 
					WHEN dvd.fechaVencido IS NULL THEN '#08cf37'
				  END color
				{$segmentacion['columnas_bd']}
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cliente cli ON v.idCliente = cli.idCliente
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$params['proyecto_filtro']}
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			JOIN trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
			LEFT JOIN trade.unidadMedida um ON um.idUnidadMedida = dvd.idUnidadMedida
			LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
			{$segmentacion['join']}
			WHERE r.estado = 1 AND v.estado = 1 
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtro_demo}
			{$filtros}
			ORDER BY nombreComercial
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