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
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';
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

			, ct.nombre  subCanal
			, gca.nombre grupoCanal
			{$segmentacion['columnas_bd']}
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo

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
				, dvd.idProducto
				, ele.nombre 'elemento'
				, pc.idCategoria
				, pc.nombre 'categoria'
				, dvd.presencia
				, dvd.stock
				, dvd.idUnidadMedida
				, vf.fotoUrl 'foto'
				, um.nombre 'unidadMedida'
				, ele.flagCompetencia
				, mo.nombre AS motivo
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto 
			JOIN trade.producto_categoria pc ON pc.idCategoria=ele.idCategoria
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=dvd.idVisitaFoto
			LEFT JOIN trade.unidadMedida um ON um.idUnidadMedida = dvd.idUnidadMedida
			LEFT JOIN trade.motivo mo ON dvd.idMotivo=mo.idMotivo
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
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductos vi ON vi.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.list_productos lst ON lst.idListProductos=v.idListProductos
			JOIN {$this->sessBDCuenta}.trade.list_productosDet lstd ON lstd.idListProductos=lst.idListProductos
	
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

			if(!empty($params['quiebre']) && ($params['quiebre'] == 1 || $params['quiebre'] == 2)){
				$filtros .= $params['quiebre'] == 1  ? ' AND dvd.quiebre=1' : ''; 
				$filtros .= $params['quiebre'] == 2  ? ' AND (dvd.quiebre=0 OR dvd.quiebre IS NULL )' : ''; 
			}else{
				$filtros .= !empty($params['quiebre']) && $params['quiebre'] == 3  ? ' AND dvd.quiebre='.$params['quiebre'] : ''; 
			}

			$filtros .= !empty($params['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$params['distribuidora_filtro'] : '';
			$filtros .= !empty($params['zona_filtro']) ? ' AND z.idZona='.$params['zona_filtro'] : '';
			$filtros .= !empty($params['plaza_filtro']) ? ' AND pl.idPlaza='.$params['plaza_filtro'] : '';
			$filtros .= !empty($params['cadena_filtro']) ? ' AND cad.idCadena='.$params['cadena_filtro'] : '';
			$filtros .= !empty($params['banner_filtro']) ? ' AND ba.idBanner='.$params['banner_filtro'] : '';

			if((!empty($params['flagPropios']) && empty($params['flagCompetencia'])) || (empty($params['flagPropios']) && !empty($params['flagCompetencia']))){
				$filtros .= !empty($params['flagPropios']) ? ' AND ele.flagCompetencia = 0': '';
				$filtros .= !empty($params['flagCompetencia']) ? ' AND ele.flagCompetencia = 1': '';
			}
			
			$filtros .= !empty($params['clientes']) ? " AND v.idCliente IN({$params['clientes']})" : '';
			$filtros .= !empty($params['motivo']) ? " AND mo.idMotivo IN({$params['motivo']})" : "";
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
				, vf.fotoUrl 'foto'
				, mg.carpetaFoto
				, vf.idVisitaFoto
				, v.idVisita
				, ele.idProducto 
				, v.direccion
				, r.nombreUsuario
				, r.fecha
				, ele.ean 
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cliente cli ON v.idCliente = cli.idCliente
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$params['proyecto_filtro']}
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			LEFT JOIN trade.motivo mo ON dvd.idMotivo=mo.idMotivo
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
			LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=dvd.idVisitaFoto
			LEFT JOIN trade.aplicacion_modulo m ON m.idModulo = vf.idModulo
			LEFT JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo = m.idModuloGrupo
			
			{$segmentacion['join']}
			WHERE r.estado = 1 AND v.estado = 1 
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
			{$filtro_demo}
			ORDER BY r.fecha DESC ,{$segmentacion['orderBy']},v.razonSocial
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

			if(!empty($params['fifo']) && ($params['fifo'] == 1 || $params['fifo'] == 2)){
				$filtros .= $params['fifo'] == 1  ? ' AND DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) >= 0' : ''; 
				$filtros .= $params['fifo'] == 2  ? ' AND DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) < 0' : ''; 
			}else{
				$filtros .= !empty($params['fifo']) && $params['fifo'] == 3  ? 'AND  1<>1 ' : ''; 
			}

			if((!empty($params['flagPropios']) && empty($params['flagCompetencia'])) || (empty($params['flagPropios']) && !empty($params['flagCompetencia']))){
				$filtros .= !empty($params['flagPropios']) ? ' AND ele.flagCompetencia = 0': '';
				$filtros .= !empty($params['flagCompetencia']) ? ' AND ele.flagCompetencia = 1': '';
			}
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
				, r.fecha
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
				, ele.ean
				, CASE 
					WHEN dvd.fechaVencido IS NOT NULL THEN  CAST(DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) AS varchar) 
					WHEN dvd.fechaVencido IS NULL THEN 'No vence'
				END diasVencimiento
				, CASE 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) <= 25 THEN 'black' 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) <= 30 THEN 'red' 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) <= 38 THEN 'yellow' 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) <= 44 THEN '#08cf37' 
					WHEN DATEDIFF(DAY,GETDATE(),dvd.fechaVencido) >= 45 THEN '#08cf37' 
					WHEN dvd.fechaVencido IS NULL THEN '#08cf37'
				  END color
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cliente cli ON v.idCliente = cli.idCliente
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$params['proyecto_filtro']}
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto AND ele.flagCompetencia = 0
			LEFT JOIN trade.unidadMedida um ON um.idUnidadMedida = dvd.idUnidadMedida
			LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
			{$segmentacion['join']}
			WHERE r.estado = 1 AND v.estado = 1 
			AND r.fecha BETWEEN @fecIni AND @fecFin
			AND (dvd.fechaVencido IS NOT NULL  OR dvd.fechaVencido IS NOT NULL)
			{$filtro_demo}
			{$filtros}
			ORDER BY DATEDIFF(DAY,GETDATE(),dvd.fechaVencido),nombreComercial
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getTiendasVisitadas($params = [])
	{
		$idProyecto = $this->sessIdProyecto;
		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
        --
        WITH lista_visitas AS(
        SELECT DISTINCT
            v.idVisita
            , v.idCliente
            , r.fecha
            , CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1  ) THEN 3
              ELSE 
				CASE WHEN (v.horaIni IS NOT NULL ) THEN 1
              ELSE 
				CASE WHEN (estadoIncidencia IS NOT NULL OR estadoIncidencia = 1) THEN 2
              ELSE 0 END
                END
              END condicion
        FROM 
            {$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
            JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
        WHERE 
            r.fecha BETWEEN @fecIni AND @fecFin
            AND r.estado = 1
            AND v.estado = 1
            AND r.idProyecto = {$idProyecto}
            AND r.demo = 0
			
        ), lista_cliente AS (
        SELECT
             SUM(CASE WHEN condicion = 3 OR condicion = 2 THEN 1 ELSE 0 END) OVER (PARTITION BY idCliente) cobertura
            , ROW_NUMBER() OVER (PARTITION BY idCliente ORDER BY fecha DESC) fila
			,idCliente
		FROM lista_visitas
        )
        SELECT
			
             COUNT(CASE WHEN fila = 1 AND cobertura > 0 THEN 1 END) tiendasVisitadas
        FROM
            lista_cliente
		ORDER BY tiendasVisitadas desc
		";

		return $this->db->query($sql)->row_array();
	}
	public function getTiendasVisitadasAcumulado($params = [])
	{
		$idProyecto = $this->sessIdProyecto;
		$sql = "
		DECLARE 
		@fecIni date = NULL,
		@fecFin date='".$params['fecIni']."';
        SET @fecIni = DATEADD(MONTH, DATEDIFF(MONTH, 0, @fecFin), 0);
		--
        WITH lista_visitas AS(
        SELECT DISTINCT
            v.idVisita
            , v.idCliente
            , r.fecha
            , CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1  ) THEN 3
              ELSE 
				CASE WHEN (v.horaIni IS NOT NULL ) THEN 1
              ELSE 
				CASE WHEN (estadoIncidencia IS NOT NULL OR estadoIncidencia = 1) THEN 2
              ELSE 0 END
                END
              END condicion
        FROM 
            {$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
            JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
        WHERE 
            r.fecha BETWEEN @fecIni AND @fecFin
            AND r.estado = 1
            AND v.estado = 1
            AND r.idProyecto = {$idProyecto}
            AND r.demo = 0
			
        ), lista_cliente AS (
        SELECT
             SUM(CASE WHEN condicion = 3 OR condicion = 2 THEN 1 ELSE 0 END) OVER (PARTITION BY idCliente) cobertura
            , ROW_NUMBER() OVER (PARTITION BY idCliente ORDER BY fecha DESC) fila
			,idCliente
		FROM lista_visitas
        )
        SELECT
			
             COUNT(CASE WHEN fila = 1 AND cobertura > 0 THEN 1 END) tiendasVisitadas
        FROM
            lista_cliente
		ORDER BY tiendasVisitadas desc
		";

		return $this->db->query($sql)->row_array();
	}

	public function getDataResumen($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND ck.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND ck.idProyecto='.$params['proyecto_filtro'] : '';
		$filtros .= !empty($params['tipoResumen']) ? ' AND idTipoReporte='.$params['tipoResumen'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
		SELECT
		ck.fecha
		,ck.idCategoria
		,ck.categoria
		,ck.idMarca
		,ck.marca
		,ck.idProducto
		,ck.producto
		,ck.idCadena
		,ck.cadena
		,ck.idBanner
		,ck.banner
		,ck.presencia
		,ck.quiebres
		,ck.precios
		,ck.preciosTotal
		,DENSE_RANK() OVER (PARTITION BY ck.idCategoria,ck.idMarca order BY ck.idProducto) + DENSE_RANK() OVER (PARTITION BY ck.idCategoria,ck.idMarca order BY ck.idProducto desc) - 1 cantidadProductos
		,DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idMarca) + DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idMarca desc) - 1 cantidadMarcasCategoria
		,DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idProducto) + DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idProducto desc) - 1 cantidadProductosCategoria
		, ck.totalPresencia
		, ck.totalPresenciaBanner
		, ck.totalQuiebres
		, ck.totalQuiebresBanner
		, ck.totalPrecio
		, ck.totalPrecioBanner
		, ck.idTipoReporte
		FROM {$this->sessBDCuenta}.resumen.checkProducto ck
		WHERE ck.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY categoria,marca
		";

		return $this->db->query($sql)->result_array();
	}
	public function getDataResumenAcumulado($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND ck.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND ck.idProyecto='.$params['proyecto_filtro'] : '';
		$filtros .= !empty($params['tipoResumen']) ? ' AND idTipoReporte='.$params['tipoResumen'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
		SELECT
		ck.fecha
		,ck.idCategoria
		,ck.categoria
		,ck.idMarca
		,ck.marca
		,ck.idProducto
		,ck.producto
		,ck.idCadena
		,ck.cadena
		,ck.idBanner
		,ck.banner
		,ck.presencia
		,ck.quiebres
		,ck.precios
		,ck.preciosTotal
		,DENSE_RANK() OVER (PARTITION BY ck.idCategoria,ck.idMarca order BY ck.idProducto) + DENSE_RANK() OVER (PARTITION BY ck.idCategoria,ck.idMarca order BY ck.idProducto desc) - 1 cantidadProductos
		,DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idMarca) + DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idMarca desc) - 1 cantidadMarcasCategoria
		,DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idProducto) + DENSE_RANK() OVER (PARTITION BY ck.idCategoria order BY ck.idProducto desc) - 1 cantidadProductosCategoria
		, ck.totalPresencia
		, ck.totalPresenciaBanner
		, ck.totalQuiebres
		, ck.totalQuiebresBanner
		, ck.totalPrecio
		, ck.totalPrecioBanner
		, ck.idTipoReporte
		FROM {$this->sessBDCuenta}.resumen.checkProducto ck
		WHERE ck.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY categoria,marca
		";

		return $this->db->query($sql)->result_array();
	}
	public function getTopClientesCadena($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND r.idProyecto='.$params['proyecto_filtro'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',
				@fecFin date='".$params['fecIni']."';
		SELECT DISTINCT TOP 5
		cad.idCadena
		,cad.nombre cadena
		,DENSE_RANK() OVER (PARTITION BY cad.idCadena order BY v.idCliente) + DENSE_RANK() OVER (PARTITION BY cad.idCadena order BY v.idCliente desc) - 1 clientesCadena
		,cad.color_hex color
		FROM
		{$this->sessBDCuenta}.trade.data_ruta r 
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dv ON dv.idVisita = v.idVisita
		JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos = dv.idVisitaProductos
		JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON ch.idCliente = v.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha)
			AND ch.idProyecto = 14
		JOIN trade.segmentacionClienteModerno segmod ON segmod.idSegClienteModerno = ch.idSegClienteModerno
		JOIN trade.banner b ON b.idBanner = segmod.idBanner
		JOIN trade.cadena cad ON cad.idCadena = b.idCadena
		WHERE 
		r.fecha BETWEEN @fecIni AND @fecFin
		AND dvd.presencia = 1
		{$filtros}
		ORDER BY clientesCadena DESC
		";

		return $this->db->query($sql)->result_array();
	}
	public function getTopClientesCadenaAcumulado($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND r.idProyecto='.$params['proyecto_filtro'] : '';

		$sql = "
		DECLARE @fecIni DATE = NULL,@fecFin date='".$params['fecIni']."';
		SET @fecIni = DATEADD(MONTH, DATEDIFF(MONTH, 0, @fecFin), 0);
		SELECT DISTINCT TOP 5
		cad.idCadena
		,cad.nombre cadena
		,DENSE_RANK() OVER (PARTITION BY cad.idCadena order BY v.idCliente) + DENSE_RANK() OVER (PARTITION BY cad.idCadena order BY v.idCliente desc) - 1 clientesCadena
		,cad.color_hex color
		FROM
		{$this->sessBDCuenta}.trade.data_ruta r 
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dv ON dv.idVisita = v.idVisita
		JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos = dv.idVisitaProductos
		JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON ch.idCliente = v.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha)
			AND ch.idProyecto = 14
		JOIN trade.segmentacionClienteModerno segmod ON segmod.idSegClienteModerno = ch.idSegClienteModerno
		JOIN trade.banner b ON b.idBanner = segmod.idBanner
		JOIN trade.cadena cad ON cad.idCadena = b.idCadena
		WHERE 
		r.fecha BETWEEN @fecIni AND @fecFin
		AND dvd.presencia = 1
		{$filtros}
		ORDER BY clientesCadena DESC
		";

		return $this->db->query($sql)->result_array();
	}
	public function getTopProductosMasPresencia($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND ck.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND ck.idProyecto='.$params['proyecto_filtro'] : '';
		$filtros .= !empty($params['tipoResumen']) ? ' AND idTipoReporte='.$params['tipoResumen'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
		SELECT DISTINCT TOP 10
		ck.idProducto
		,UPPER(ck.producto) producto
		,ck.totalPresencia
		FROM
		{$this->sessBDCuenta}.resumen.checkProducto ck
		WHERE  
		ck.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY totalPresencia DESC
		";

		return $this->db->query($sql)->result_array();
	}
	public function getTopProductosMasPresenciaAcumulado($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND ck.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND ck.idProyecto='.$params['proyecto_filtro'] : '';
		$filtros .= !empty($params['tipoResumen']) ? ' AND idTipoReporte='.$params['tipoResumen'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
		SELECT DISTINCT TOP 10
		ck.idProducto
		,UPPER(ck.producto) producto
		,ck.totalPresencia
		FROM
		{$this->sessBDCuenta}.resumen.checkProducto ck
		WHERE  
		ck.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY totalPresencia DESC
		";

		return $this->db->query($sql)->result_array();
	}

	public function getTopProductosMenosPresencia($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND ck.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND ck.idProyecto='.$params['proyecto_filtro'] : '';
		$filtros .= !empty($params['tipoResumen']) ? ' AND idTipoReporte='.$params['tipoResumen'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
		SELECT DISTINCT TOP 10
		ck.idProducto
		,UPPER(ck.producto) producto
		,ck.totalQuiebres
		FROM
		{$this->sessBDCuenta}.resumen.checkProducto ck
		WHERE  
		ck.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY totalQuiebres DESC
		";

		return $this->db->query($sql)->result_array();
	}

	public function getTopProductosMenosPresenciaAcumulado($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND ck.idCuenta='.$params['idCuenta'] : '';
		$filtros .= !empty($params['proyecto_filtro']) ? ' AND ck.idProyecto='.$params['proyecto_filtro'] : '';
		$filtros .= !empty($params['tipoResumen']) ? ' AND idTipoReporte='.$params['tipoResumen'] : '';

		$sql = "
		DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecIni']."';
		SELECT DISTINCT TOP 10
		ck.idProducto
		,UPPER(ck.producto) producto
		,ck.totalQuiebres
		FROM
		{$this->sessBDCuenta}.resumen.checkProducto ck
		WHERE  
		ck.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY totalQuiebres DESC
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_clientes_resumen($params)
	{
		$filtros = '';
		$filtros .= !empty($params['idProducto']) ?  " AND v.idProducto = {$params['idProducto']}" : '';
		$filtros .= ($params['tipo']) == 'presencia' ?  " AND v.presencia = 1" : '';
		$filtros .= ($params['tipo']) == 'quiebre' ?  " AND v.quiebre = 1" : '';

		$filtroBanner = '';
		$filtroBanner .= !empty($params['banner']) ?  " AND ba.idBanner = {$params['banner']}" : '';
		
		$setFecIni = ($params['idTipoResumen']) == 2 ? 'SET @fecIni = DATEADD(MONTH, DATEDIFF(MONTH, 0, @fecFin), 0);' : 'SET @fecIni = @fecFin;' ;
		$idProyecto = $this->sessIdProyecto;
		$cliente_historico = getClienteHistoricoCuenta();
		$sql = "
		DECLARE @fecIni DATE = NULL ,@fecFin DATE='".$params['fecha']."';
		{$setFecIni}
		WITH list_visitasProductos AS (
            SELECT
                r.idRuta
                , r.fecha
                , r.idProyecto
                , ca.idGrupoCanal
                , ca.idCanal
                , v.idCliente
                , dvd.idProducto
				, dvd.presencia
				, dvd.quiebre
            FROM {$this->sessBDCuenta}.trade.data_ruta r
            JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
            JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
            JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
            LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
            LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
            WHERE r.estado = 1 AND v.estado = 1 AND r.demo = 0
            AND r.fecha BETWEEN @fecIni AND @fecFin
            AND r.idProyecto={$idProyecto} 
        ), lista_clientes AS (
        SELECT
			ch.idCliente
			, cli.codCliente
			, cli.codDist
			, ch.razonSocial
			, ch.direccion
            , ch.idClienteHist
            , ch.idSegClienteModerno
            , ch.idSegClienteTradicional

			, cad.idCadena
            , ba.idBanner
            , ba.nombre AS banner
            , cad.nombre AS cadena

			, d.nombre AS distribuidora
			, ubi1.provincia AS ciudadDistribuidoraSuc
			, ubi1.cod_ubigeo AS codUbigeoDisitrito
			, ds.idDistribuidoraSucursal
			, z.nombre AS zona

			, pl.nombre AS plaza 
			, pl.idPlaza
        FROM trade.cliente cli
        JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
        LEFT JOIN trade.segmentacionClienteModerno scm ON ch.idSegClienteModerno = scm.idSegClienteModerno   
		LEFT JOIN trade.banner ba ON ba.idBanner = scm.idBanner LEFT JOIN trade.cadena cad ON cad.idCadena = ba.idCadena
		LEFT JOIN trade.segmentacionClienteTradicional scmt ON scmt.idSegClienteTradicional = ch.idSegClienteTradicional
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = scmt.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora AND d.estado=1
		LEFT JOIN General.dbo.ubigeo ubd ON ubd.cod_ubigeo = ds.cod_ubigeo
		LEFT JOIN trade.plaza p ON p.idPlaza = scmt.idPlaza
		LEFT JOIN General.dbo.ubigeo ubp ON ubp.cod_ubigeo = p.cod_ubigeo
		LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.zona z ON ch.idZona = z.idZona
		LEFT JOIN trade.plaza pl ON pl.idPlaza = scmt.idPlaza
        WHERE ch.idProyecto = {$idProyecto} AND General.dbo.fn_fechaVigente(ch.fecIni, ch.fecFin, @fecIni, @fecFin) = 1
		{$filtroBanner}
        )
        SELECT DISTINCT 
			ch.idCliente
			, ch.codCliente
			, ch.codDist
			, ch.razonSocial
			, ch.direccion
			, ch.idCadena
			, ch.idBanner
			, ch.banner AS banner
			, ch.banner AS cadena
			, ch.distribuidora AS distribuidora
			, ch.ciudadDistribuidoraSuc AS ciudadDistribuidoraSuc
			, ch.codUbigeoDisitrito AS codUbigeoDisitrito
			, ch.idDistribuidoraSucursal
			, ch.zona AS zona
			, ch.plaza AS plaza 
			, ch.idPlaza
			,gca.nombre grupoCanal
			,ca.nombre canal
			,gca.idGrupoCanal
			,ca.idCanal
        FROM list_visitasProductos v
        LEFT JOIN lista_clientes ch ON v.idCliente = ch.idCliente
        LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
        LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
        LEFT JOIN trade.producto ele ON ele.idProducto=v.idProducto
		WHERE
		1=1
		{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_motivos($params = [])
	{
		$filtros = '';
		$filtros .= !empty($params['idCuenta']) ? ' AND idCuenta='.$params['idCuenta'] : '';

		$sql = "
		SELECT
			idMotivo
			, nombre
		FROM trade.motivo
		WHERE estado = 1
		{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}

}
?>