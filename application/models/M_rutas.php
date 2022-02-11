<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rutas extends MY_Model{

	public function __construct(){
		parent::__construct();
	}

	public function obtener_visitas($input = []){
		$sessIdCuenta = $this->sessIdCuenta;
		$sessIdProyecto = $this->sessIdProyecto;

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		$filtros = "";
            if( !empty($sessIdCuenta) ) $filtros .= " AND r.idCuenta = ".$sessIdCuenta;
            if( !empty($sessIdProyecto) ) $filtros .= " AND r.idProyecto = ".$sessIdProyecto;
            //if( !empty($input['grupo_filtro']) ) $filtros .= " AND gc.idGrupoCanal = ".$input['grupo_filtro'];
            if( !empty($input['canal_filtro']) ) $filtros .= " AND v.idCanal = ".$input['canal_filtro'];
			$filtros .= !empty($input['subcanal']) ? ' AND ctp.idClienteTipo='.$input['subcanal'] : '';
			$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
			$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
			$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
			$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
			$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
			$filtros .= !empty($input['plaza_filtro']) ? ' AND sct.idPlaza='.$input['plaza_filtro'] : '';
			$filtros .= !empty($input['cadena_filtro']) ? ' AND cd.idCadena='.$input['cadena_filtro'] : '';
			$filtros .= !empty($input['banner_filtro']) ? ' AND b.idBanner='.$input['banner_filtro'] : '';
			$filtros .= !empty($input['frecuencia_filtro']) ? ' AND v.idFrecuencia='.$input['frecuencia_filtro'] : '';
			$filtros .= !empty($input['tienda_perfecta']) ? (($input['tienda_perfecta'] == 1) ? ' AND v.flagTiendaPerfecta=1': ' AND v.flagTiendaPerfecta=0') : '';
			$filtros .= !empty($input['gps']) ? (($input['gps'] == 1) ? ' AND ((v.latIni IS NOT NULL AND v.lonIni IS NOT NULL ) OR (v.latFin IS NOT NULL AND v.lonFin IS NOT NULL)) ': ' AND v.latIni IS NULL AND v.lonIni IS NULL AND v.latFin IS NULL AND v.lonFin IS NULL') : '';

			//Ubigeo
			$filtros .= !empty($input['departamento_filtro']) ? ' AND ub.cod_departamento='.$input['departamento_filtro'] : '';
			$filtros .= !empty($input['provincia_filtro']) ? ' AND ub.cod_provincia='.$input['provincia_filtro'] : '';
			$filtros .= !empty($input['distrito_filtro']) ? ' AND ub.cod_ubigeo='.$input['distrito_filtro'] : '';

			if(empty($input['inc_desactivado']) || empty($input['inc'])){
				$filtros .= !empty($input['inc_desactivado']) ? ' AND (v.estadoIncidencia=0 OR v.estadoIncidencia IS NULL) '  : '';
				$filtros .= !empty($input['inc']) ? ' AND (v.estadoIncidencia=1) '  : '';
			}

			$filtros .= !empty($input['foto']) ? ' AND (v.numFotos >= 1) '  : '';
			$filtros .= !empty($input['obs']) ? ' AND (v.observacion = 1) '  : '';

			if(!empty($input['estadoUsuario']) && ($input['estadoUsuario'] == 1 || $input['estadoUsuario'] == 2)){
				$filtros .= $input['estadoUsuario'] == 1  ? ' AND r.idUsuario IN(SELECT idUsuario FROM list_usuarios_activos)' : ''; 
				$filtros .= $input['estadoUsuario'] == 2  ? ' AND r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos)' : ''; 
			}else{
				$filtros .= !empty($input['estadoUsuario']) && $input['estadoUsuario'] == 3  ? ' AND 1<>1 ' : ''; 
			}

			// DATOS DEMO
			if( $sessIdTipoUsuario != 4 ){
				if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
				else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
			}

			$cliente_historico = getClienteHistoricoCuenta();
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupo_filtro']]);
		
		$sql = "
			DECLARE
				@fecIni DATE='{$input['fecIni']}',
				@fecFin DATE='{$input['fecFin']}',
				@hoy DATE = GETDATE();

			WITH list_fotos_no_modulacion (idVisita, contFotos) as (
				SELECT vf.idVisita, COUNT(vf.idVisitaFoto)
				FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
				JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo 
				JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo=m.idModuloGrupo
				WHERE mg.idModuloGrupo<>9
				GROUP BY vf.idVisita
			) 
			, trade_data_asistencia_usuario_ruta (hora, idUsuario, fecha) as (
				SELECT a.hora, a.idUsuario, a.fecha FROM {$this->sessBDCuenta}.trade.data_asistencia a WHERE a.idTipoAsistencia = 1
			)
			, list_canal AS (
				SELECT ca.idCanal, gc.nombre, gc.idGrupoCanal 
				FROM trade.canal ca
				LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal AND gc.idGrupoCanal = {$input['grupo_filtro']}
			)
			, list_usuarios_activos as(
				SELECT u.idUsuario, u.numDocumento, u.apePaterno, u.apeMaterno, u.nombres FROM trade.usuario u
				JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario 
				WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@hoy,@hoy) = 1 AND uh.idProyecto = {$sessIdProyecto}
			)
			, list_visitas as(
			SELECT 
				CONVERT(VARCHAR(10),r.fecha,103) fecha
				, CASE WHEN lua.idUsuario IS NULL THEN 1 ELSE 0 END cesado
				, r.idUsuario cod_usuario
				, em.idEmpleado cod_empleado
				, r.nombreUsuario
				, CONVERT(VARCHAR(8), (SELECT TOP 1 hora from trade_data_asistencia_usuario_ruta WHERE idUsuario = r.idUsuario AND fecha = r.fecha)) hora_ini_asistencia
				, CONVERT(VARCHAR(8), v.horaIni) hora_ini
				, CONVERT(VARCHAR(8), v.horaFin) hora_fin
				, DATEDIFF(MINUTE,v.horaIni,v.horaFin) minutos
				, vi.nombreIncidencia indicencia_nombre
				, CASE 
					WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1 ) THEN 
					CASE 
						WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 3 --Efectiva
						ELSE 
							CASE 
							WHEN v.numFotos >=1 THEN 3 --Efectiva
							ELSE 1 --No efectiva
							END
					END 
					WHEN (v.estadoIncidencia = 1 ) THEN 2 --INCIDENCIA
					WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND ISNULL(v.numFotos,0) = 0  AND estadoIncidencia IS NULL ) THEN 0 -- No Visitado
					ELSE 1 --No Efectiva
					END condicion
				, v.idVisita
				, v.idCanal
				, v.canal
				, (SELECT lc.nombre FROM list_canal lc WHERE lc.idCanal = v.idCanal) AS grupoCanal
				, (SELECT lc.idGrupoCanal FROM list_canal lc WHERE lc.idCanal = v.idCanal) AS idGrupoCanal
				, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
				, ub.departamento ciudad
				, ub.cod_provincia
				, ub.provincia
				, ub.cod_distrito
				, ub.distrito
				, v.idCliente cod_visual
				, v.razonSocial
				, c.nombreComercial
				, c.direccion
				, v.encuesta
				, v.ipp
				, v.productos
				, v.precios
				, v.promociones
				, v.sod
				, v.sos
				, v.seguimientoPlan
				, v.despachos
				, v.encartes
				, v.numFotos fotos
				, v.frecuencia
				, v.qr
				, c.flagQR
				--
				, CASE WHEN (v.horaIni IS NULL) THEN 1 ELSE 0 END valHora
				, ISNULL(v.latIni,0) lati_ini
				, ISNULL(v.lonIni,0) long_ini
				, ISNULL(v.latFin,0) lati_fin
				, ISNULL(v.lonFin,0) long_fin
				, ISNULL(c.latitud,0) latitud
				, ISNULL(c.longitud,0) longitud
				-- , ROW_NUMBER() OVER (PARTITION BY r.idUsuario ORDER BY r.idUsuario) row
				, ISNULL(vi.idIncidencia,0) idTipoIncidencia
				, CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND vi.nombreIncidencia IS NULL ) OR (v.estadoIncidencia=0) THEN 1 ELSE 0 END as PDV_EFECTIVO
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND vi.nombreIncidencia IS NOT NULL) OR (v.estadoIncidencia=1) THEN 1 ELSE 0 END as PDV_NO_VISITADO
				, CASE WHEN (v.estadoIncidencia = 0) OR(v.estadoIncidencia IS NOT NULL)  THEN 1 ELSE 0 END as PDV_INCIDENCIA
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL) THEN 1 ELSE 0 END as PDV_SINVISITA
				, c.codCliente
				, vi.fotoUrl incidencia_foto
				, e.idEncargado
				, vi.nombreIncidencia incidencia_nombre
				, u_e.apePaterno + ' ' + u_e.apeMaterno + ' ' + u_e.nombres encargado
				, CONVERT(VARCHAR(8), vi.hora) incidencia_hora
				, vi.observacion incidencia_obs
				, r.idTipoUsuario
				, r.tipoUsuario
				, map.id_anychartmaps idMap
				----
				, v.inventario
				, v.visibilidad
				, 1 AS ventas
				, v.iniciativa AS iniciativas
				, v.inteligencia AS inteligenciaCompetitiva
				, v.ordenes AS ordenTrabajo
				, v.ordenAuditoria
				, v.modulacion
				, v.visibilidad_aud AS visibilidadAuditoria
				, v.premio
				, v.mantenimiento AS mantenimientoCliente
				, v.surtido
				, v.observacion AS observacion
				, v.tarea
				, v.evidenciaFotografica
				, lfn.contFotos fotosOtrosModulos
				, ctp.idClienteTipo
				, ctp.nombre subCanal
				, CASE WHEN vi.idVisitaIncidencia IS NOT NULL THEN  ROW_NUMBER() OVER (PARTITION BY vi.idVisita ORDER BY vi.idVisitaIncidencia ) END num_incidencia
				{$segmentacion['columnas_bd']}

			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta 
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita
			LEFT JOIN list_usuarios_activos lua ON r.idUsuario = lua.idUsuario

			JOIN trade.cliente c ON c.idCliente = v.idCliente
			LEFT JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente 
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
			) AND ch.idProyecto = {$sessIdProyecto}

			JOIN trade.cuenta cu ON cu.idCuenta = r.idCuenta
			LEFT JOIN list_fotos_no_modulacion lfn ON lfn.idVisita=v.idVisita

			LEFT JOIN General.dbo.ubigeo ub ON ch.cod_ubigeo = ub.cod_ubigeo
			LEFT JOIN trade.encargado e ON e.idEncargado = r.idEncargado 
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario = e.idUsuario 
			LEFT JOIN rrhh.dbo.empleado em ON em.numTipoDocuIdent = u_e.numDocumento 
		
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio 
			LEFT JOIN trade.cliente_tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo 
			
			{$segmentacion['join']}

			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 

			WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
			AND v.idTipoExclusion IS NULL{$filtros} 
		)
		SELECT 
		* 
		FROM list_visitas
		WHERE (num_incidencia = 1 OR num_incidencia IS NULL)
		ORDER BY fecha , ciudad, canal, tipoUsuario, encargado, nombreUsuario  ASC

		";
		
		return $this->db->query($sql)->result_array();
	}

	public function obtener_permisos_modulos($input=array()){
		$filtros = "";

		$idCuenta = $this->sessIdCuenta;
		$idProyecto = $this->sessIdProyecto;

		!empty($idCuenta) ? $filtros .= ' AND a.idCuenta='.$idCuenta : '';
		!empty($idProyecto) ? $filtros .= ' AND p.idProyecto='.$idProyecto : '';
	
		$sql = "
			SELECT DISTINCT 
			a.idCuenta, m.idTipoUsuario, mo.idModuloGrupo 
			FROM trade.aplicacion_modulo_tipoUsuario m
			JOIN trade.aplicacion_modulo mo ON mo.idModulo = m.idModulo
			JOIN trade.aplicacion a ON a.idAplicacion = mo.idAplicacion
			JOIN trade.proyecto p ON p.idCuenta = a.idCuenta
			WHERE m.estado = 1 {$filtros}";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_permisos_modulos_cuenta($input = []){
		$filtros = "";

		$idCuenta = $this->sessIdCuenta;
		$idProyecto = $this->sessIdProyecto;

		!empty($idCuenta) ? $filtros .= ' AND a.idCuenta='.$idCuenta : '';
		!empty($idProyecto) ? $filtros .= ' AND p.idProyecto='.$idProyecto : '';
	
		$sql = "
			SELECT
			mo.*
			FROM trade.aplicacion_modulo mo
			JOIN trade.aplicacion a ON a.idAplicacion = mo.idAplicacion
			JOIN trade.proyecto p ON p.idCuenta = a.idCuenta
			WHERE mo.estado = 1 {$filtros}";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_fotos($idVisita){
		$sql = "
			SELECT distinct 
				UPPER(m.nombre) AS modulo
				, CONVERT(VARCHAR(8),vf.hora) AS hora
				, vf.fotoUrl AS foto
				, mg.carpetaFoto
			FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
			LEFT JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo
			LEFT JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo=m.idModuloGrupo
			WHERE vf.idVisita={$idVisita} AND mg.idModuloGrupo<>9 
		";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_moduloFotos($idVisita){
		$sql = "
			SELECT distinct 
				dvm.nombreTipoFoto
				, CONVERT(VARCHAR(8),vf.hora) AS hora
				, vf.fotoUrl AS foto 
			FROM {$this->sessBDCuenta}.trade.data_visitaModuloFotos dvm 
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=dvm.idVisitaFoto
			WHERE vf.idVisita={$idVisita} 
		";
		return $this->db->query($sql)->result_array();
	}

	public function detalle_encuesta($idVisita){
		$sql = "
			SELECT
				  ve.idVisita
				, ve.idEncuesta
				, e.nombre AS encuesta
				, ved.idPregunta
				, ep.nombre AS pregunta
				, vf.fotoUrl AS fotoEncuesta
				, ved.idAlternativa
				, CASE WHEN ved.idAlternativa IS NULL THEN respuesta ELSE ea.nombre END AS respuesta
				, vfd.fotoUrl AS fotoRespuesta
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuesta ve
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ve.idVisitaEncuesta = ved.idVisitaEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON ve.idVisitaFoto = vf.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfd ON ved.idVisitaFoto = vfd.idVisitaFoto
			JOIN {$this->sessBDCuenta}.trade.encuesta e ON ve.idEncuesta = e.idEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON e.idEncuesta = ep.idEncuesta AND ved.idPregunta = ep.idPregunta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ea.idAlternativa = ved.idAlternativa
			WHERE ve.idVisita = {$idVisita}
			ORDER BY encuesta, pregunta, respuesta 
		";

		return $this->db->query($sql)->result_array();
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
				ve.idVisita = {$idVisita}
			ORDER BY encuesta, ep.orden ASC
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_checkproducto($idVisita, $idGrupoCanal = ''){
		$columnas_adicionales = getColumnasAdicionales(['idModulo' => 3, 'shortag' => 'dvpd', 'idGrupoCanal' => $idGrupoCanal])['columnas_adicionales'];
		
		if($columnas_adicionales!=null){
			if (strpos($columnas_adicionales, 'fechaVencido') !== false) {
				$columnas_adicionales=$columnas_adicionales.",dvpd.cantidadVencida";
			}
		}

		$sql = "
			SELECT 
				 dvpd.idVisitaProductosDet
				,dvp.idVisita
				,dvpd.idVisitaProductos
				,dvpd.idProducto
				,p.nombre AS producto
				,dvpd.presencia
				,dvpd.quiebre
				,dvpd.stock
				,dvpd.precio
				,und.idUnidadMedida
				,UPPER(und.nombre) AS unidadMedida
				,mv.idMotivo
				,mv.nombre AS motivo
				,vf.idVisitaFoto
				,vf.fotoUrl AS foto
				,p.flagCompetencia
				{$columnas_adicionales}
			FROM {$this->sessBDCuenta}.trade.data_visitaProductosDet dvpd
			JOIN {$this->sessBDCuenta}.trade.data_visitaProductos dvp ON dvpd.idVisitaProductos= dvp.idVisitaProductos
			JOIN trade.producto p ON p.idProducto = dvpd.idProducto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvpd.idVisitaFoto
			LEFT JOIN trade.unidadMedida und ON dvpd.idUnidadMedida = und.idUnidadMedida
			LEFT JOIN trade.motivo mv ON dvpd.idMotivo = mv.idMotivo
			WHERE dvp.idVisita = {$idVisita}
			ORDER BY producto ASC
		";	

		return $this->db->query($sql)->result_array();
	}

	public function detalle_precio($idVisita, $idGrupoCanal = ''){
		$columnas_adicionales = getColumnasAdicionales(['idModulo' => 10, 'shortag' => 'dvpd', 'idGrupoCanal' => $idGrupoCanal])['columnas_adicionales'];

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
				{$columnas_adicionales}
			FROM 
				{$this->sessBDCuenta}.trade.data_visitaPreciosDet dvpd
				JOIN {$this->sessBDCuenta}.trade.data_visitaPrecios dvp ON dvpd.idVisitaPrecios= dvp.idVisitaPrecios
				JOIN trade.producto p ON p.idProducto = dvpd.idProducto
			WHERE 
				dvp.idVisita = {$idVisita}
			ORDER BY producto
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_promociones($idVisita, $idGrupoCanal = ''){
		$columnas_adicionales = getColumnasAdicionales(['idModulo' => 7, 'shortag' => 'dvpd', 'idGrupoCanal' => $idGrupoCanal])['columnas_adicionales'];

	
		$join_adicional = '';
		if(!empty($columnas_adicionales)){
			$join_adicional = 'LEFT JOIN trade.producto pr ON dvpd.producto = pr.idProducto';
			$columnas_adicionales = str_replace('dvpd.producto', 'pr.nombre AS producto', $columnas_adicionales);
		}

		if($columnas_adicionales!=null){
			if (strpos($columnas_adicionales, 'fechaVigencia') !== false) {
				$columnas_adicionales=str_replace("fechaVigencia", "fechaVigenciaInicio", $columnas_adicionales);
				$columnas_adicionales=$columnas_adicionales.",dvpd.fechaVigenciaFin";
			}
		}

		$sql = "
			SELECT
				 dvpd.idVisitaPromocionesDet
				, dvpd.idPromocion
				, tp.idTipoPromocion
				, tp.nombre AS tipoPromocion
				, p.nombre AS promocion
				, dvpd.nombrePromocion
				, dvpd.presencia
				, dvpd.idVisitaFoto
				, vf.fotoUrl foto
				{$columnas_adicionales}
			FROM
				{$this->sessBDCuenta}.trade.data_visitaPromocionesDet dvpd
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaPromociones dvp ON dvpd.idVisitaPromociones= dvp.idVisitaPromociones
				LEFT JOIN trade.promocion p ON p.idPromocion = dvpd.idPromocion
				LEFT JOIN trade.tipoPromocion tp ON tp.idTipoPromocion = dvpd.idTipoPromocion OR tp.idTipoPromocion = p.idTipoPromocion
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = dvpd.idVisitaFoto
				{$join_adicional}
			WHERE
				dvp.idVisita = {$idVisita}
				--AND nombrePromocion IS NOT NULL
				--AND tp.idTipoPromocion <> 1
			ORDER BY tipoPromocion, promocion ASC
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_sos($idVisita){
		$sql = "
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
				dvp.idVisita = {$idVisita}
			ORDER BY idVisita,categoria,marca ASC	
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_sod($idVisita){
		$sql = "
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
			ds.idVisita = {$idVisita}
		ORDER BY categoria,tipoElemento,marca ASC 
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_encarte($idVisita){
		$sql = "
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
				dvp.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
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
				dvp.idVisita = {$idVisita}
			ORDER BY plan_, tipoElemento
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_despacho($idVisita){
		$sql = "
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
				dvp.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_inventario($idVisita){
		$sql = "
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
			WHERE vi.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_visibilidad($idVisita){
		$sql = "
			SELECT
				vvt.idVisitaVisibilidad
				, vvtd.idVisitaVisibilidadDet
				, vvtd.idElementoVis
				, evt.nombre AS elementoVisibilidad
				, vvtd.presencia
				, vvtd.cantidad
				, vvtd.idEstadoElemento
				, eev.nombre AS elementoEstado
				, vvtd.idVisitaFoto
				, vf.fotoUrl AS foto
				, vvtd.condicion_elemento AS condicion
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet vvtd
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad vvt ON vvt.idVisitaVisibilidad=vvtd.idVisitaVisibilidad
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvtd.idElementoVis
			LEFT JOIN trade.estadoElementoVisibilidad eev ON eev.idEstadoElemento=vvtd.idEstadoElemento
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vvtd.idVisitaFoto
			WHERE vvt.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_mantenimientoCliente($idVisita){
		$sql = "
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
			WHERE idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_iniciativas($idVisita){
		$sql = "
			SELECT
				vitd.idVisitaIniciativaTrad
				, vitd.idVisitaIniciativaTradDet
				, vitd.idIniciativa
				, it.nombre AS iniciativa
				, eit.idElementoVis
				, eit.nombre AS elementoIniciativa
				, vitd.presencia
				, vitd.cantidad
				, vitd.idEstadoIniciativa
				, esit.nombre AS estadoIniciativa
				, vitd.producto
				, vitd.idVisitaFoto
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet vitd
			JOIN {$this->sessBDCuenta}.trade.data_visitaIniciativaTrad vit ON vit.idVisitaIniciativaTrad=vitd.idVisitaIniciativaTrad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vitd.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.iniciativatrad it ON it.idIniciativa=vitd.idIniciativa
			LEFT JOIN trade.elementovisibilidadTrad eit ON eit.idElementoVis=vitd.idElementoIniciativa
			LEFT JOIN trade.estadoIniciativaTrad esit ON esit.idEstadoIniciativa=vitd.idEstadoIniciativa
			WHERE vit.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_inteligenciaCompetitiva($idVisita){
		$sql = "
			SELECT
				vitd.idVisitaInteligencia
				, vitd.idVisitaInteligenciaDet
				, vitd.idCategoria
				, pc.nombre AS categoria
				, vitd.idMarca
				, pm.nombre AS marca
				, ct.idTipoElementoCompetencia
				, ct.nombre AS tipoCompetencia

				, nombreSku
				, versionSku
				, tamanoSku
				, precioSku

				, nombreElemento

				, objetivoIniciativa
				, CONVERT(VARCHAR, vigenciaIniIniciativa, 103) AS vigenciaIniIniciativa
				, CONVERT(VARCHAR, vigenciaFinIniciativa, 103) AS vigenciaFinIniciativa

				, nombreSkuPrecio
				, tamanoPrecio
				, precioAnterior
				, precioActual

				, descripcionActivacion
				, CONVERT(VARCHAR, vigenciaIniActivacion, 103) AS vigenciaIniActivacion
				, CONVERT(VARCHAR, vigenciaFinActivacion, 103) AS vigenciaFinActivacion

				, vitd.idVisitaFoto
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaInteligenciaDet vitd
			JOIN {$this->sessBDCuenta}.trade.data_visitaInteligencia vit ON vit.idVisitaInteligencia = vitd.idVisitaInteligencia
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = vitd.idVisitaFoto
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = vitd.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca = vitd.idMarca
			LEFT JOIN trade.tipoElementoCompetencia ct ON ct.idTipoElementoCompetencia = vitd.idTipoElementoCompetencia
			WHERE vit.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_ordenTrabajo($idVisita){
		$sql = "
			SELECT
				vordd.idVisitaOrdenTrabajoDet,
				vord.idVisitaOrdenTrabajo,
				ele.idElementoVis,
				ele.nombre AS elemento,
				vfc.fotoUrl AS fotoCerca,
				vfp.fotoUrl AS fotoPanor
			FROM {$this->sessBDCuenta}.trade.data_visitaOrdenTrabajo vord
			JOIN {$this->sessBDCuenta}.trade.data_visitaOrdenTrabajoDet vordd ON vord.idVisitaOrdenTrabajo = vordd.idVisitaOrdenTrabajo
			LEFT JOIN trade.elementoVisibilidadTrad ele ON vordd.idElementoVis = ele.idElementoVis
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfc ON vordd.idVisitaFotoCerca = vfc.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfp ON vordd.idVisitaFotoPanoramica = vfp.idVisitaFoto
			WHERE vord.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_visibilidadAuditoriaObligatoria($idVisita){
		$sql = "
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
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvod
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisitaVisibilidad=vvod.idVisitaVisibilidad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vvod.idVisitaFoto = vf.idVisitaFoto
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvod.idElementoVis
			LEFT JOIN trade.variableVisibilidad vv ON vv.idVariable=vvod.idVariable
			LEFT JOIN trade.observacionElementoVisibilidadObligatorio oevo ON oevo.idObservacion=vvod.idObservacion
			WHERE vvo.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_visibilidadAuditoriaIniciativa($idVisita){
		$sql = "
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
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet vvid
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vvi ON vvi.idVisitaVisibilidad=vvid.idVisitaVisibilidad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vvid.idVisitaFoto = vf.idVisitaFoto
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvid.idElementoVis
			LEFT JOIN {$this->sessBDCuenta}.trade.iniciativaTrad ini ON ini.idIniciativa=evt.idIniciativa
			LEFT JOIN trade.observacionElementoVisibilidadIniciativa oevi ON oevi.idObservacion=vvid.idObservacion
			WHERE vvi.idVisita = {$idVisita}
			ORDER BY ini.idIniciativa,evt.idElementoVis
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_visibilidadAuditoriaAdicional($idVisita){
		$sql = "
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
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet vvad
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional vva ON vva.idVisitaVisibilidad=vvad.idVisitaVisibilidad
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vvad.idVisitaFoto = vf.idVisitaFoto
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvad.idElementoVis
			WHERE vva.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_encuestaPremio($idVisita){
		$sql = "
			SELECT
				vep.idVisitaEncuesta
				, vepd.idVisitaEncuestaDet
				, vep.idEncuesta
				, UPPER(e.nombre) AS encuesta
				, vepd.idPregunta
				, ep.nombre AS pregunta
				, vepd.respuesta
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet vepd
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaPremio vep ON vep.idVisitaEncuesta=vepd.idVisitaEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vep.idVisitaFoto = vf.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta e On e.idEncuesta=vep.idEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep On ep.idPregunta=vepd.idPregunta
			WHERE vep.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_premiacion($idVisita){
		$sql = "
			SELECT
				vprem.idVisitaPremiacion
				, vprem.hora
				, tprem.idTipoPremiacion
				, UPPER(tprem.descripcion) AS tipoPremiacion
				, prem.idPremiacion
				, UPPER(prem.nombre) AS premiacion
				, vprem.codigo
				, vprem.monto
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaPremiacion vprem
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vprem.idVisitaFoto = vf.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.premiacion prem ON vprem.idPremiacion = prem.idPremiacion
			LEFT JOIN trade.tipo_Premiacion tprem ON vprem.idTipoPremiacion = tprem.idTipoPremiacion
			WHERE vprem.idVisita = {$idVisita}
			ORDER BY tipoPremiacion, premiacion
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_surtido($idVisita){
		$sql = "
			SELECT
				vsurd.idVisitaSurtidoDet,
				vsur.idVisitaSurtido,
				prod.idProducto,
				prod.nombre AS producto,
				vsurd.presencia,
				vsurd.observacion,
				vf.idVisitaFoto,
				vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaSurtido vsur
			JOIN {$this->sessBDCuenta}.trade.data_visitaSurtidoDet vsurd ON vsur.idVisitaSurtido = vsurd.idVisitaSurtido
			JOIN trade.producto prod ON vsurd.idProducto = prod.idProducto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vsurd.idVisitaFoto = vf.idVisitaFoto
			WHERE vsur.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_sugerido($idVisita){
		$sql = "
			SELECT
				vsugd.idVisitaSugeridoDet,
				prod.idProducto,
				prod.nombre AS producto
			FROM {$this->sessBDCuenta}.trade.data_visitaSugerido vsug
			JOIN {$this->sessBDCuenta}.trade.data_visitaSugeridoDet vsugd ON vsug.idVisitaSugerido = vsugd.idVisitaSugerido
			JOIN trade.producto prod ON vsugd.idProducto = prod.idProducto
			WHERE vsug.idVisita = {$idVisita}
		";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_observacion($idVisita){
		$sql = "
		SELECT 
			v.idVisitaObservacion,
			v.idVisita,
			vd.comentario
		FROM {$this->sessBDCuenta}.trade.data_visitaObservacion v
		JOIN {$this->sessBDCuenta}.trade.data_visitaObservacionDet vd ON vd.idVisitaObservacion = v.idVisitaObservacion
		WHERE v.idVisita = {$idVisita}";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_tarea($idVisita){
		$sql = "
		SELECT 
			v.idVisitaTarea
			, v.idVisita
			, vd.presencia
			, vd.idTarea
			, t.nombre AS tarea
			, vd.comentario
			, vf.fotoUrl
		FROM {$this->sessBDCuenta}.trade.data_visitaTarea v
		JOIN {$this->sessBDCuenta}.trade.data_visitaTareaDet vd ON vd.idVisitaTarea = v.idVisitaTarea
		JOIN {$this->sessBDCuenta}.trade.tarea t ON vd.idTarea = t.idTarea
		JOIN {$this->sessBDCuenta}.trade.data_visitaTareaDetFoto vdf ON vd.idVisitaTareaDet = vdf.idVisitaTareaDet
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vdf.idVisitaFoto = vf.idVisitaFoto
		WHERE v.idVisita = {$idVisita}";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_evidenciaFotografica($idVisita){
		$sql = "
		SELECT 
			v.idVisitaEvidenciaFotografica
			, v.idVisita
			, vd.comentario
			, vdf.idTipoFotoEvidencia
			, vf.fotoUrl
		FROM {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotografica v
		JOIN {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotograficaDet vd ON vd.idVisitaEvidenciaFotografica = v.idVisitaEvidenciaFotografica
		JOIN {$this->sessBDCuenta}.trade.data_visitaEvidenciaFotograficaDetFoto vdf ON vd.idVisitaEvidenciaFotograficaDet = vdf.idVisitaEvidenciaFotograficaDet
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vdf.idVisitaFoto = vf.idVisitaFoto
		WHERE v.idVisita = {$idVisita}";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_orden($idVisita){
		$sql = "
			SELECT  
				dvo.idVisita
				,dvo.idOrden
				,o.nombre orden
				,dvo.descripcion
				,dvo.flagOtro 
				,dvf.fotoUrl as foto
			from {$this->sessBDCuenta}.trade.data_visitaOrden dvo
			LEFT JOIN trade.orden o ON o.idOrden=dvo.idOrden
			JOIN trade.orden_estado oe ON oe.idOrdenEstado=dvo.idOrdenEstado
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos dvf ON dvf.idVisitaFoto=dvo.idVisitaFoto
			where dvo.idVisita= {$idVisita}";

		return $this->db->query($sql)->result_array();
	}

	public function detalle_modulacion($idVisita){
		$sql = "
			SELECT
				dvm.idVisita,
				dvm.flagCorrecto,
				dvd.idElementoVis,
				ev.nombre elemento,
				dvd.flagCorrecto as flagCorrectoDet
			FROM {$this->sessBDCuenta}.trade.data_visitaModulacion dvm
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModulacionDet dvd ON dvd.idVisitaModulacion=dvm.idVisitaModulacion
			LEFT JOIN trade.elementoVisibilidadTrad ev ON ev.idElementoVis=dvd.idElementoVis
			where dvm.idVisita = {$idVisita}";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_cantidadFotos($idVisita){
		$sql = "

			SELECT distinct count(1)  as contFotos 
			FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
			JOIN trade.aplicacion_modulo m ON vf.idModulo = m.idModulo
			JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo=m.idModuloGrupo
			WHERE vf.idVisita={$idVisita} AND mg.idModuloGrupo<>9 
		";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_horarios(){
		$sql ="SELECT idHorario,CONVERT(VARCHAR,horaIni,108) horaIni,CONVERT(VARCHAR,horaFin,108) horaFin FROM ImpactTrade_pg.trade.horarios WHERE estado=1";
		return $this->db->query($sql)->result_array();
	}

}
?>