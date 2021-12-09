<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_visibilidad extends MY_Model{
	
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

			// $filtros .= !empty($input['subcanal_filtro']) ? " AND subca.idSubCanal=".$input['subcanal_filtro'] : "";
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

		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}

		$segmentacion = getSegmentacion(['grupoCanal_filtro'=>$input['grupoCanal_filtro']]);

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT
			distinct
			r.idRuta
			, r.fecha
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
			, r.idUsuario
			, r.nombreUsuario
			, r.tipoUsuario
			, v.idVisita
			, v.canal
			, v.idCliente
			, v.codCliente
			, v.nombreComercial, v.razonSocial
			, v.cod_ubigeo
			, ubi.departamento
			, ubi.provincia
			, ubi.distrito
			, v.direccion
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ct.nombre subCanal
			{$segmentacion['columnas_bd']}

		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
				and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				and uh.idProyecto=r.idProyecto
		JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad dvv ON dvv.idVisita=v.idVisita
		JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
		JOIN trade.cliente c 
			ON c.idCliente = v.idCliente 
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		JOIN {$cliente_historico} ch 
			ON v.idCliente = ch.idCliente AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1 
			AND ch.idProyecto = {$input['proyecto_filtro']}
		LEFT JOIN trade.segmentacionNegocio segneg ON segneg.idSegNegocio = ch.idSegNegocio
		LEFT JOIN trade.subCanal subca ON subca.idSubCanal = segneg.idSubcanal
		LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = segneg.idClienteTipo
		{$segmentacion['join']}

		WHERE r.estado=1 
		AND v.estado=1 
		{$filtro_demo}
		AND r.fecha BETWEEN @fecIni AND @fecFin
		$filtros
		ORDER BY fecha , canal, tipoUsuario, supervisor, nombreUsuario  ASC
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_detalle_visibilidad($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
			$filtros .= !empty($input['idElemento']) ? ' AND ele.idElementoVis IN ('.$input['idElemento'].')' : '';
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT
				r.idRuta
				, r.fecha
				, v.idVisita
				, dvd.idElementoVis
				, ele.nombre 'elemento'
				, pc.idCategoria
				, pc.nombre 'categoria'
				, dvd.presencia
				, dvd.cantidad
				, dvd.idEstadoElemento
				, eev.nombre 'estado'
				, vf.fotoUrl 'foto'
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad dvv ON dvv.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet dvd ON dvd.idVisitaVisibilidad=dvv.idVisitaVisibilidad
			JOIN trade.elementoVisibilidadTrad ele ON ele.idElementoVis=dvd.idElementoVis
			JOIN trade.producto_categoria pc ON pc.idCategoria=ele.idCategoria
			LEFT JOIN trade.estadoElementoVisibilidad eev ON eev.idEstadoElemento=dvd.idEstadoElemento
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=dvd.idVisitaFoto
			WHERE r.estado=1 AND v.estado=1 
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
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
		}

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT DISTINCT 
				v.idVisita 
				, lstd.idElementoVis
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad vi ON vi.idVisita=v.idVisita
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradObl lst ON lst.idListVisibilidadObl=v.idListVisibilidadTradObl
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet lstd ON lstd.idListVisibilidadObl=lst.idListVisibilidadObl
	
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
	
			WHERE r.estado=1 AND v.estado=1
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
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

	public function detalle_encuesta($idVisita){
		$sql = "
			SELECT
				  ve.idVisita
				, ve.idEncuesta
				, e.nombre encuesta
				, ved.idPregunta
				, ep.nombre pregunta
				, vf.fotoUrl foto
				, ved.idAlternativa
				, CASE WHEN ved.idAlternativa IS NULL THEN respuesta ELSE ea.nombre END respuesta
			FROM
				{$this->sessBDCuenta}.trade.data_visitaEncuesta ve
				JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved
					ON ved.idVisitaEncuesta = ve.idVisitaEncuesta
				JOIN {$this->sessBDCuenta}.trade.encuesta e
					ON e.idEncuesta = ve.idEncuesta
				JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep
					ON ep.idEncuesta = e.idEncuesta
					AND ved.idPregunta=ep.idPregunta
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea
					ON ea.idAlternativa = ved.idAlternativa
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = ve.idVisitaFoto
			WHERE
				ve.idVisita=$idVisita	
			ORDER BY encuesta, pregunta, respuesta 
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_ipp($idVisita){
		$sql = "
			SELECT DISTINCT
				  ve.idVisita
				, ve.idIpp
				, e.nombre encuesta
				, ved.idPregunta
				, ep.nombre pregunta
				, vf.fotoUrl foto
				, ved.idAlternativa
				, ea.nombre alternativa
				, SUM(ved.puntaje) OVER (PARTITION BY ved.idPregunta) puntaje
				, ep.orden
			FROM
				{$this->sessBDCuenta}.trade.data_visitaIpp ve
				JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet ved
					ON ved.idVisitaIpp = ve.idVisitaIpp
				JOIN {$this->sessBDCuenta}.trade.ipp e
					ON e.idIpp = ve.idIpp
				JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ep
					ON ep.idIpp = e.idIpp
					AND ved.idPregunta=ep.idPregunta
				JOIN {$this->sessBDCuenta}.trade.ipp_alternativa ea
					ON ea.idAlternativa = ved.idAlternativa
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = ve.idVisitaFoto
			WHERE
				ve.idVisita=$idVisita	
			ORDER BY encuesta, ep.orden ASC
		";
		
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_checkproducto($idVisita){
		$sql="
			SELECT 
				 dvpd.idVisitaProductosDet
				,dvp.idVisita
				,dvpd.idVisitaProductos
				,dvpd.idProducto
				,p.nombre producto
				,dvpd.presencia
				,dvpd.quiebre
				,dvpd.stock
				,dvpd.idVisitaFoto
				,vf.fotoUrl foto
			FROM {$this->sessBDCuenta}.trade.data_visitaProductosDet dvpd
				JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvp ON dvpd.idVisitaProductos= dvp.idVisitaProductos
				JOIN trade.producto p ON p.idProducto = dvpd.idProducto
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvpd.idVisitaFoto
			WHERE 
				dvp.idVisita=$idVisita
			ORDER BY producto ASC		
		";
		
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_precio($idVisita){
		$sql = "
			SELECT 
				 dvpd.idVisitaPrecios
				,dvp.idVisita
				,dvpd.idVisitaPreciosDet
				,dvpd.idProducto
				,p.nombre producto
				,dvpd.precio
				,dvpd.precioRegular
				,dvpd.precioOferta
			FROM 
				{$this->sessBDCuenta}.trade.data_visitaPreciosDet dvpd
				JOIN {$this->sessBDCuenta}.trade.data_visitaPrecios dvp ON dvpd.idVisitaPrecios= dvp.idVisitaPrecios
				JOIN trade.producto p ON p.idProducto = dvpd.idProducto
			WHERE 
				dvp.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_promociones($idVisita){
		$sql="
			SELECT 
				 dvpd.idVisitaPromocionesDet
				, dvpd.idPromocion
				, tp.idTipoPromocion
				, tp.nombre tipoPromocion
				, p.nombre promocion
				, dvpd.nombrePromocion  
				, dvpd.presencia
				, dvpd.idVisitaFoto
				, vf.fotoUrl foto 
			FROM 
				{$this->sessBDCuenta}.trade.data_visitaPromocionesDet dvpd
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaPromociones dvp ON dvpd.idVisitaPromociones= dvp.idVisitaPromociones
				LEFT JOIN trade.promocion p ON p.idPromocion = dvpd.idPromocion
				left JOIN trade.tipoPromocion tp ON tp.idTipoPromocion = dvpd.idTipoPromocion OR tp.idTipoPromocion = p.idTipoPromocion
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvpd.idVisitaFoto
			WHERE
				dvp.idVisita=$idVisita
				AND nombrePromocion IS NOT NULL
				AND tp.idTipoPromocion<>1
			ORDER BY tipoPromocion, promocion ASC
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_sos($idVisita){
		$sql ="
			SELECT 
				 dvpd.idVisitaSosDet
				,dvp.idVisita
				,dvpd.idVisitaSos
				,dvpd.idCategoria
				,pc.nombre categoria
				,dvpd.idMarca
				,pm.nombre marca
				,dvpd.cm
				,dvpd.frentes
				,dvpd.flagCompetencia
				,vf.fotoUrl  foto 
			FROM {$this->sessBDCuenta}.trade.data_visitaSosDet dvpd
				JOIN {$this->sessBDCuenta}.trade.data_visitaSoS dvp ON dvpd.idVisitaSos= dvp.idVisitaSos
				JOIN trade.producto_categoria pc ON pc.idCategoria = dvpd.idCategoria
				JOIN trade.producto_marca pm ON pm.idMarca = dvpd.idMarca
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvp.idVisitaFoto
			WHERE
				dvp.idVisita=$idVisita
			ORDER BY idVisita,categoria,marca ASC	
		";
		
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_sod($idVisita){
		$sql ="
		SELECT
			ds.idVisitaSod 
			, dsd.idVisitaSodDet
			, dsd.idCategoria
			, pc.nombre categoria
			, dsd.idTipoElementoVisibilidad
			, te.nombre tipoElemento
			, dsd.idMarca
			, pm.nombre marca
			, ISNULL(dsd.cant,'0') cantidad
			, dsf.idVisitaFoto
			, vf.fotoUrl foto 
		FROM
			{$this->sessBDCuenta}.trade.data_visitaSod ds
			JOIN {$this->sessBDCuenta}.trade.data_visitaSodDet dsd ON dsd.idVisitaSod= ds.idVisitaSod
			JOIN trade.producto_categoria pc ON pc.idCategoria = dsd.idCategoria
			JOIN trade.producto_marca pm ON pm.idMarca = dsd.idMarca
			JOIN trade.tipoElementoVisibilidad te ON te.idTipoElementoVisibilidad = dsd.idTipoElementoVisibilidad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaSodDetFotos dsf ON dsf.idVisitaSod = ds.idVisitaSod AND dsf.idCategoria = pc.idCategoria AND dsf.idMarca = pm.idMarca AND dsf.idTipoElementoVisibilidad = dsd.idTipoElementoVisibilidad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dsf.idVisitaFoto 
		WHERE
			ds.idVisita=$idVisita
		ORDER BY categoria,tipoElemento,marca ASC 
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_encarte($idVisita){
		$sql ="
			SELECT 
				 dvpd.idVisitaEncartesDet id
				,dvp.idVisita
				,dvpd.idVisitaEncartes
				,dvpd.idCategoria
				,pc.nombre categoria
				,vf.fotoUrl foto 
			FROM {$this->sessBDCuenta}.trade.data_visitaEncartesDet dvpd
				JOIN {$this->sessBDCuenta}.trade.data_visitaEncartes dvp ON dvpd.idVisitaEncartes= dvp.idVisitaEncartes
				JOIN trade.producto_categoria pc ON pc.idCategoria = dvpd.idCategoria
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvpd.idVisitaFoto
			WHERE
				dvp.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_seguimiento_plan($idVisita){
		$sql = "
			SELECT 
				 dvpd.idVisitaSeguimientoPlanDet
				,dvp.idVisita
				,dvpd.idVisitaSeguimientoPlan
				, sp.idSeguimientoPlan
				, sp.nombre plan_
				,dvpd.idTipoElementoVisibilidad
				,te.nombre tipoElemento
				,dvpd.armado
				,dvpd.revestido
				,dvpd.idMotivo
				,mo.nombre motivo
				,dvpd.comentario
				,vf.fotoUrl foto 
			FROM
				{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlanDet dvpd
				JOIN {$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan dvp ON dvpd.idVisitaSeguimientoPlan= dvp.idVisitaSeguimientoPlan
				JOIN trade.tipoElementoVisibilidad te ON te.idTipoElementoVisibilidad = dvpd.idTipoElementoVisibilidad
				JOIN {$this->sessBDCuenta}.trade.seguimientoPlan sp ON sp.idSeguimientoPlan = dvp.idSeguimientoPlan
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvp.idVisitaFoto
				LEFT JOIN master.motivos mo ON mo.idMotivo = dvpd.idMotivo
			WHERE
				dvp.idVisita=$idVisita
			ORDER BY plan_, tipoElemento
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_despacho($idVisita){
		$sql ="
			SELECT 
				 dvpd.idVisitaDesapachosDet
				,dvp.idVisita
				,dvpd.idVisitaDespachos
				,dvpd.placa
				, CONVERT(VARCHAR(8),dvpd.horaIni)horaIni
				, CONVERT(VARCHAR(8),dvpd.horaFin)horaFin
				, dvpd.idIncidencia
				, mo.nombre incidencia
				, dvpd.comentario
				, dvdd.idVisitaDespachosDias
				, CASE 
					WHEN dvdd.idDia = 1 THEN 'LUNES'
					WHEN dvdd.idDia = 2 THEN 'MARTES'
					WHEN dvdd.idDia = 3 THEN 'MIERCOLES'
					WHEN dvdd.idDia = 4 THEN 'JUEVES'
					WHEN dvdd.idDia = 5 THEN 'VIERNES'
					WHEN dvdd.idDia = 6 THEN 'SABADO'
					WHEN dvdd.idDia = 7 THEN 'DOMINGO'
					END diaDespacho
				, dvdd.presencia
			FROM {$this->sessBDCuenta}.trade.data_visitaDespachos dvp
				JOIN {$this->sessBDCuenta}.trade.data_visitaDespachosDet dvpd  ON dvpd.idVisitaDespachos= dvp.idVisitaDespachos
				JOIN {$this->sessBDCuenta}.trade.data_visitaDespachosDias dvdd ON dvdd.idVisitaDespachos = dvp.idVisitaDespachos
				LEFT JOIN master.incidencias mo ON mo.idIncidencia = dvpd.idIncidencia
			WHERE
				dvp.idVisita=$idVisita
		";
		
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_inventario($idVisita){
		$sql="
			SELECT
				vid.idVisitaInventario
				, vid.idVisitaInventarioDet
				, vid.idProducto
				, p.nombre AS producto
				, vid.stock_inicial
				, vid.sellin
				, vid.stock
				, vid.validacion
				, vid.obs AS observacion
				, vid.comentario
				, CONVERT(VARCHAR,vid.fecVenc,103) AS fechaVencimiento
			FROM {$this->sessBDCuenta}.trade.data_visitaInventarioDet vid
			JOIN {$this->sessBDCuenta}.trade.data_visitaInventario vi ON vi.idVisitaInventario=vid.idVisitaInventario
			LEFT JOIN trade.producto p ON p.idProducto = vid.idProducto
			WHERE vi.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_visibilidad($input){
		$sql="
			SELECT
				vvt.idVisitaVisibilidad
				, vvtd.idVisitaVisibilidadDet
				, vvtd.idElementoVis
				, evt.nombre AS elementoVisibilidad
				, vvtd.presencia, vvtd.cantidad
				, vvtd.idEstadoElemento
				, eev.nombre AS elementoEstado
				, vvtd.idVisitaFoto
				, vf.fotoUrl AS foto
				, vvtd.condicion_elemento
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet vvtd
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad vvt ON vvt.idVisitaVisibilidad=vvtd.idVisitaVisibilidad
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvtd.idElementoVis
			LEFT JOIN trade.estadoElementoVisibilidad eev ON eev.idEstadoElemento=vvtd.idEstadoElemento
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vvtd.idVisitaFoto
			
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_mantenimientoCliente($idVisita){
		$sql="
			SELECT
				idVisitaMantCliente
				, CONVERT(VARCHAR(8),hora) AS hora
				, codCliente
				, nombreComercial
				, razonSocial
				, ruc
				, dni
				, cod_ubigeo
				, direccion
				, latitud
				, longitud
			FROM {$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente
			WHERE idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_iniciativas($idVisita){
		$sql="
			SELECT
				vitd.idVisitaIniciativaTrad
				, vitd.idVisitaIniciativaTradDet
				, vitd.idIniciativa
				, it.nombre AS iniciativa
				, vitd.idElementoIniciativa
				, eit.nombre AS elementoIniciativa
				, vitd.presencia
				, vitd.cantidad
				, vitd.idEstadoIniciativa
				, esit.nombre AS estadoIniciativa
				, vitd.producto AS idProducto
				, p.nombre AS producto
				, vitd.idVisitaFoto
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet vitd
			JOIN {$this->sessBDCuenta}.trade.data_visitaIniciativaTrad vit ON vit.idVisitaIniciativaTrad=vitd.idVisitaIniciativaTrad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vitd.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.iniciativatrad it ON it.idIniciativa=vitd.idIniciativa
			LEFT JOIN trade.elementovisibilidadTrad eit ON eit.idElementoVis=vitd.idElementoIniciativa
			LEFT JOIN trade.estadoIniciativaTrad esit ON esit.idEstadoIniciativa=vitd.idEstadoIniciativa
			LEFT JOIN trade.producto p ON p.idProducto=vitd.producto
			WHERE vit.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_inteligenciaCompetitiva($idVisita){
		$sql="
			SELECT
				vitd.idVisitaInteligenciaTrad
				, vitd.idVisitaInteligenciatradDet
				, vitd.idCategoria
				, pc.nombre AS categoria
				, vitd.idMarca
				, pm.nombre AS marca
				, vitd.idTipoCompetencia
				, ct.nombre AS tipoCompetencia
				, vitd.comentario
				, vitd.idVisitaFoto
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaInteligenciaTradDet vitd
			JOIN {$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad vit ON vit.idVisitaInteligenciaTrad=vitd.idVisitaInteligenciaTrad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vitd.idVisitaFoto
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=vitd.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=vitd.idMarca
			LEFT JOIN trade.competencia_tipo ct ON ct.idTipoCompetencia=vitd.idTipoCompetencia
			WHERE vit.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_ordenTrabajo($idVisita){
		$sql="
			SELECT
				vo.idVisitaOrden
				, vo.idOrden
				, o.nombre AS orden
				, vo.descripcion
				, vo.idOrdenEstado
				, oe.nombre AS ordenEstado
				, vo.flagOtro
				, vf.fotoUrl AS foto
				, CONVERT(VARCHAR(8),vf.hora) AS hora
			FROM {$this->sessBDCuenta}.trade.data_visitaOrden vo
			JOIN trade.orden o ON vo.idOrden=o.idOrden
			JOIN trade.orden_estado oe ON oe.idOrdenEstado=vo.idOrdenEstado
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vo.idVisitaFoto
			WHERE vo.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_visibilidadAuditoriaObligatoria($idVisita){
		$sql="
			SELECT
				vvod.idVisitaVisibilidad
				, vvo.porcentaje
				, vvo.porcentajeV
				, vvo.porcentajePM
				, vvod.idVisitaVisibilidadDet
				, vvod.idElementoVis
				, evt.nombre AS elementoVisibilidad
				, vvod.idVariable
				, vv.descripcion AS variable
				, vvod.presencia
				, vvod.idObservacion
				, oevo.descripcion AS observacion
				, vvod.comentario
				, vvod.cantidad
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvod
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisitaVisibilidad=vvod.idVisitaVisibilidad
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvod.idElementoVis
			LEFT JOIN trade.variableVisibilidad vv ON vv.idVariable=vvod.idVariable
			LEFT JOIN trade.observacionElementoVisibilidadObligatorio oevo ON oevo.idObservacion=vvod.idObservacion
			WHERE vvo.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_visibilidadAuditoriaIniciativa($idVisita){
		$sql="
			SELECT 
				vvid.idVisitaVisibilidad
				, vvi.porcentaje
				, vvid.idVisitaVisibilidadDet
				, ini.idIniciativa
				, ini.nombre as iniciativa
				, vvid.idElementoVis
				, evt.nombre AS elementoVisibilidad
				, vvid.presencia
				, vvid.comentario
				, vvid.idObservacion
				, oevi.descripcion AS observacion
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet vvid
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vvi ON vvi.idVisitaVisibilidad=vvid.idVisitaVisibilidad
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvid.idElementoVis
			LEFT JOIN {$this->sessBDCuenta}.trade.iniciativaTrad ini ON ini.idIniciativa=evt.idIniciativa
			LEFT JOIN trade.observacionElementoVisibilidadIniciativa oevi ON oevi.idObservacion=vvid.idObservacion
			WHERE vvi.idVisita=$idVisita
			ORDER BY ini.idIniciativa,evt.idElementoVis
		";
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_visibilidadAuditoriaAdicional($idVisita){
		$sql="
			SELECT 
				vvad.idVisitaVisibilidad
				, vva.porcentaje
				, vva.cant AS cantidadCabecera
				, vvad.idVisitaVisibilidadDet
				, vvad.idElementoVis
				, evt.nombre AS elementoVisibilidad
				, vvad.presencia
				, vvad.cant AS cantidad
				, vvad.comentario
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet vvad
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional vva ON vva.idVisitaVisibilidad=vvad.idVisitaVisibilidad
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvad.idElementoVis
			WHERE vva.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function detalle_encuestaPremio($idVisita){
		$sql="
			SELECT
				vep.idVisitaEncuesta
				, vepd.idVisitaEncuestaDet
				, vep.idEncuesta
				, UPPER(e.nombre) AS encuesta
				, vepd.idPregunta
				, ep.nombre AS pregunta
				, vepd.respuesta
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet vepd
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaPremio vep ON vep.idVisitaEncuesta=vepd.idVisitaEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta e On e.idEncuesta=vep.idEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep On ep.idPregunta=vepd.idPregunta
			WHERE vep.idVisita=$idVisita
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}


	public function detalle_observacion($idVisita){
		$sql = "
			SELECT 
				v.idVisitaObservacion,
				v.idVisita,
				vd.comentario
			from {$this->sessBDCuenta}.trade.data_visitaObservacion v
			JOIN {$this->sessBDCuenta}.trade.data_visitaObservacionDet vd ON vd.idVisitaObservacion=v.idVisitaObservacion
			WHERE
				v.idVisita=$idVisita		 
		";
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_elementos($input=array()){
		$sql = "
			select distinct ele.idElementoVis, ele.nombre 
			from trade.elementoVisibilidadTrad ele
			JOIN trade.proyecto p ON p.idProyecto=ele.idProyecto
			where ele.estado=1 and p.idCuenta=".$input['idCuenta']."
			order by ele.nombre;
		";
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}
		return $result;
	}

	public function obtener_detallado_pdf($input=array()){
		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
		$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND gc.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
		$filtros .= !empty($input['canal_filtro']) ? ' AND c.idCanal='.$input['canal_filtro'] : '';

		$filtros .= !empty($input['subcanal_filtro']) ? " AND subca.idSubCanal=".$input['subcanal_filtro'] : "";


		$filtros .= !empty($input['tipoUsuario_filtro']) ? " AND uh.idTipoUsuario=".$input['tipoUsuario_filtro'] : "";
		$filtros .= !empty($input['usuario_filtro']) ? " AND uh.idUsuario=".$input['usuario_filtro'] : "";

		$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		
		$segmentacion = getSegmentacion(['grupoCanal_filtro'=>$input['grupoCanal_filtro']]);

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		select 
			distinct
			gc.idGrupoCanal,
			gc.nombre as grupoCanal,
			c.idCanal,
			c.nombre as canal,
		 
			v.idCliente,
			ch.razonSocial,
			ch.codCliente,
			r.idUsuario,
			u.apePaterno+' '+u.apeMaterno+' '+u.nombres as empleado,
			CONVERT(VARCHAR(10),r.fecha,103) as fecha,
			CONVERT(VARCHAR(8),vi.hora, 108) as hora,

			vit.idVisitaVisibilidadDet,
			evt.idElementoVis,
			evt.nombre as elemento,
			vit.presencia,
			esit.idEstadoElemento AS idMotivo,
			esit.nombre as estado,
			vit.cantidad,

			vit.idVisitaFoto,
			vit.condicion_elemento,
			dvf.fotoUrl
			{$segmentacion['columnas_bd']}

		from  {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad vi

		JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet vit  ON vi.idVisitaVisibilidad=vit.idVisitaVisibilidad
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idVisita=vi.idVisita
		JOIN {$this->sessBDCuenta}.trade.data_ruta r ON r.idRuta=v.idRuta 
		JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
				and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				and uh.idProyecto=r.idProyecto

		JOIN trade.usuario u ON u.idUsuario=r.idUsuario
		JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=v.idCliente
			AND (
				ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
				AND (
				ch.fecIni BETWEEN @fecIni AND @fecFin
				OR
				ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
				OR
				@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				OR
				@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				)
			)

		JOIN trade.canal c ON c.idCanal =  v.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal =  c.idGrupoCanal
		JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vit.idElementoVis
		LEFT JOIN trade.estadoElementoVisibilidad esit ON esit.idEstadoElemento=vit.idEstadoElemento
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvf ON dvf.idVisitaFoto=vit.idVisitaFoto

		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		{$segmentacion['join']}

		where vi.idVisita IN (  ".$input['elementos_det']." )
		{$filtros}
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