<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auditoria extends MY_Model{  

	public function __construct(){
		parent::__construct();
	}
	
	public function obtener_visitas( $input = [] ){
		$filtros = "";
		if( !empty($input['idCuenta']) ) $filtros .= " AND r.idCuenta = ".$input['idCuenta'];
		if( !empty($input['idProyecto']) ) $filtros .= " AND r.idProyecto = ".$input['idProyecto'];
		if( !empty($input['idCanal']) ) $filtros .= " AND ca.idCanal = ".$input['idCanal'];
		if( !empty($input['idGrupoCanal']) ) $filtros .= " AND ca.idGrupoCanal = ".$input['idGrupoCanal'];

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
		$filtros .= !empty($input['frecuencia_filtro']) ? ' AND v.idFrecuencia='.$input['frecuencia_filtro'] : '';

		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';

		$sessIdTipoUsuario = $this->idTipoUsuario;
		if( $sessIdTipoUsuario != 4 ) $filtros .=  " AND r.demo = 0";
		
		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
		
		$sql = "
			DECLARE
				@fecIni Date = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				  v.idVisita
				, v.idListVisibilidadTradObl
				, v.idListVisibilidadTradAdc
				, v.idListIniciativasTrad
				, CONVERT(VARCHAR, r.fecha, 103) AS fecha
				, v.idCliente
				, v.codCliente
				, c.codDist
				, ca.idGrupoCanal
				, gc.nombre AS grupoCanal
				, v.idCanal
				, v.canal
				, ct.nombre AS subCanal
				, ch.idZona
				, i.nombreIncidencia
				, i.observacion
				, v.estadoIncidencia
				, ct.nombre AS clienteTipo
				, ub1.departamento
				, ub1.provincia
				, ub1.distrito
				, v.razonSocial
				, v.direccion
				, r.nombreUsuario AS usuario
				, ut.nombre AS tipoUsuario
				, i.nombreIncidencia 
				, i.observacion
				, v.estadoIncidencia
				, v.frecuencia
				, '0' fotos
				, CASE WHEN ord.idOrden IS NOT NULL
						THEN ord.nombre ELSE vord.descripcion
					END AS ordenTrabajo
				, vmod.flagCorrecto AS modulacion
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModulacion vmod ON v.idVisita = vmod.idVisita
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrden vord ON v.idVisita = vord.idVisita
			LEFT JOIN trade.orden ord ON vord.idOrden = ord.idOrden
			LEFT JOIN trade.orden_estado orde ON vord.idOrdenEstado = orde.idOrdenEstado
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia i ON i.idVisita = v.idVisita
			JOIN ".getClienteHistoricoCuenta()." ch ON v.idCliente = ch.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
			AND ch.idProyecto=".$input['idProyecto']."
			JOIN trade.cliente c ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub1 ON ub1.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
			{$segmentacion['join']}
			WHERE r.fecha BETWEEN @fecIni AND @fecFin --AND r.idTipoUsuario = 4
			AND r.estado = 1 AND v.estado = 1{$filtros}
		";
		return $this->db->query($sql)->result_array();
	}


	public function obtener_visitas_old( $input = [] ){
		$filtros = "";
		if( !empty($input['idCuenta']) ) $filtros .= " AND r.idCuenta = ".$input['idCuenta'];
		if( !empty($input['idProyecto']) ) $filtros .= " AND r.idProyecto = ".$input['idProyecto'];
		if( !empty($input['idCanal']) ) $filtros .= " AND ca.idCanal = ".$input['idCanal'];
		if( !empty($input['idGrupoCanal']) ) $filtros .= " AND ca.idGrupoCanal = ".$input['idGrupoCanal'];

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
		$filtros .= !empty($input['frecuencia_filtro']) ? ' AND v.idFrecuencia='.$input['frecuencia_filtro'] : '';

		$sessIdTipoUsuario = $this->idTipoUsuario;
		if( $sessIdTipoUsuario != 4 ) $filtros .=  " AND r.demo = 0";

		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);

		$sql = "
			DECLARE
				@fecIni Date = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT 
				DISTINCT
				v.idVisita
				, idListVisibilidadTradObl
				, idListVisibilidadTradAdc
				, idListIniciativasTrad
				, CONVERT(VARCHAR, r.fecha, 103) AS fecha
				, v.idCliente
				, v.codCliente
				, c.codDist
				, ca.idGrupoCanal
				, gc.nombre AS grupoCanal
				, v.idCanal
				, v.canal
				, sc.nombre AS subCanal
				, ch.idZona
				, i.nombreIncidencia
				, i.observacion
				, v.estadoIncidencia
				, ct.nombre AS clienteTipo
				, ub1.departamento
				, ub1.provincia
				, ub1.distrito
				, v.razonSocial
				, v.direccion
				, r.nombreUsuario AS usuario
				, ut.nombre AS tipoUsuario
				, i.nombreIncidencia 
				, i.observacion
				, v.estadoIncidencia
				, v.frecuencia
				/* , (
					SELECT COUNT(vf.idVisitaFoto)
					FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
					WHERE vf.idVisita = v.idVisita
				) AS fotos */
				, '0' fotos
				, CASE WHEN ord.idOrden IS NOT NULL
						THEN ord.nombre ELSE vord.descripcion
					END AS ordenTrabajo
				, vmod.flagCorrecto AS modulacion
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vo ON vo.idVisita = v.idVisita
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModulacion vmod ON v.idVisita = vmod.idVisita
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrden vord ON v.idVisita = vord.idVisita
			LEFT JOIN trade.orden ord ON vord.idOrden = ord.idOrden
			LEFT JOIN trade.orden_estado orde ON vord.idOrdenEstado = orde.idOrdenEstado
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia i ON i.idVisita = v.idVisita
			JOIN ".getClienteHistoricoCuenta()." ch ON v.idCliente = ch.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
			AND ch.idProyecto=".$input['idProyecto']."
			JOIN trade.cliente c ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub1 ON ub1.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
			{$segmentacion['join']}
			WHERE r.fecha BETWEEN @fecIni AND @fecFin --AND r.idTipoUsuario = 4
			AND r.estado = 1 AND v.estado = 1{$filtros}
		";

		if( $input['visibFormato'] == 1 ){ // FORMATO ESTANDAR
			$sql .= "
				UNION

				SELECT 
					DISTINCT
					v.idVisita
					, idListVisibilidadTradObl
					, idListVisibilidadTradAdc
					, idListIniciativasTrad
					, CONVERT(varchar, r.fecha, 103) AS fecha
					, v.idCliente
					, v.codCliente
					, c.codDist
					, ca.idGrupoCanal
					, gc.nombre AS grupoCanal
					, v.idCanal
					, v.canal
					, sc.nombre AS subCanal
					, ch.idZona
					, i.nombreIncidencia
					, i.observacion
					, v.estadoIncidencia
					, ct.nombre AS clienteTipo
					, ub1.departamento
					, ub1.provincia
					, ub1.distrito
					, v.razonSocial
					, v.direccion
					, r.nombreUsuario AS usuario
					, ut.nombre AS tipoUsuario
					, i.nombreIncidencia
					, i.observacion
					, v.estadoIncidencia
					, v.frecuencia
					/* , (
						SELECT COUNT(vf.idVisitaFoto)
						FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
						WHERE vf.idVisita = v.idVisita
					) AS fotos */
					, '0' fotos
					, CASE WHEN ord.idOrden IS NOT NULL
							THEN ord.nombre ELSE vord.descripcion
						END AS ordenTrabajo
					, vmod.flagCorrecto AS modulacion
					{$segmentacion['columnas_bd']}
				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional vo ON vo.idVisita = v.idVisita
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModulacion vmod ON v.idVisita = vmod.idVisita
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrden vord ON v.idVisita = vord.idVisita
				LEFT JOIN trade.orden ord ON vord.idOrden = ord.idOrden
				LEFT JOIN trade.orden_estado orde ON vord.idOrdenEstado = orde.idOrdenEstado
				JOIN trade.canal ca ON ca.idCanal = v.idCanal
				LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia i ON i.idVisita = v.idVisita
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = v.idCliente
					AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
					AND ch.idProyecto=".$input['idProyecto']."
				JOIN trade.cliente c ON c.idCliente = v.idCliente
				LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
				LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
				LEFT JOIN trade.cliente_tipo ct ON ct.idClienteTipo = sn.idClienteTipo
				LEFT JOIN General.dbo.ubigeo ub1 ON ub1.cod_ubigeo = c.cod_ubigeo
				LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
				{$segmentacion['join']}
				WHERE r.fecha BETWEEN @fecIni AND @fecFin--AND r.idTipoUsuario = 4
				AND r.estado = 1 AND v.estado = 1{$filtros}

				UNION

				SELECT 
					DISTINCT
					v.idVisita
					, idListVisibilidadTradObl
					, idListVisibilidadTradAdc
					, idListIniciativasTrad
					, CONVERT(varchar, r.fecha, 103) AS fecha
					, v.idCliente
					, v.codCliente
					, c.codDist
					, ca.idGrupoCanal
					, gc.nombre AS grupoCanal
					, v.idCanal
					, v.canal
					, sc.nombre AS subCanal
					, ch.idZona
					, i.nombreIncidencia
					, i.observacion
					, v.estadoIncidencia
					, ct.nombre AS clienteTipo
					, ub1.departamento
					, ub1.provincia
					, ub1.distrito
					, v.razonSocial
					, v.direccion
					, r.nombreUsuario AS usuario
					, ut.nombre AS tipoUsuario
					, i.nombreIncidencia 
					, i.observacion
					, v.estadoIncidencia
					, v.frecuencia
					/* , (
						SELECT COUNT(vf.idVisitaFoto)
						FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
						WHERE vf.idVisita = v.idVisita
					) AS fotos */
					, '0' fotos
					, CASE WHEN ord.idOrden IS NOT NULL
							THEN ord.nombre ELSE vord.descripcion
						END AS ordenTrabajo
					, vmod.flagCorrecto AS modulacion
					{$segmentacion['columnas_bd']}
				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vo ON vo.idVisita = v.idVisita
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModulacion vmod ON v.idVisita = vmod.idVisita
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaOrden vord ON v.idVisita = vord.idVisita
				LEFT JOIN trade.orden ord ON vord.idOrden = ord.idOrden
				LEFT JOIN trade.orden_estado orde ON vord.idOrdenEstado = orde.idOrdenEstado
				JOIN trade.canal ca ON ca.idCanal = v.idCanal
				LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia i ON i.idVisita = v.idVisita
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = v.idCliente
					AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha) 
					AND ch.idProyecto=".$input['idProyecto']."
				JOIN trade.cliente c ON c.idCliente = v.idCliente
				LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
				LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
				LEFT JOIN trade.cliente_tipo ct ON ct.idClienteTipo = sn.idClienteTipo
				LEFT JOIN General.dbo.ubigeo ub1 ON ub1.cod_ubigeo = c.cod_ubigeo
				LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
				{$segmentacion['join']}
				WHERE r.fecha BETWEEN @fecIni AND @fecFin --AND r.idTipoUsuario = 4 
				AND r.estado = 1 AND v.estado = 1{$filtros}
			";
		}

		return $this->db->query($sql)->result_array();
	}

	public function obtener_clienteTipo( $input = [] ){
		$sql = "
			SELECT
				ct.idClienteTipo,
				ct.nombre
			FROM trade.cliente_tipo ct
			JOIN trade.canal ca ON ct.idCanal = ca.idCanal
			JOIN trade.grupoCanal gca ON ca.idGrupoCanal = gca.idGrupoCanal
			JOIN trade.proyectoGrupoCanal pygca ON gca.idGrupoCanal = pygca.idGrupoCanal
			JOIN trade.proyecto py ON pygca.idProyecto = py.idProyecto
			WHERE py.idCuenta = {$input['idCuenta']}
			AND py.idProyecto = {$input['idProyecto']}
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_elementos_obligatorios( $input = [] ){
		$filtros = "";
			if( !empty($input['idCuenta']) ) $filtros .= " AND py.idCuenta = ".$input['idCuenta'];
			if( !empty($input['idProyecto']) ) $filtros .= " AND py.idProyecto = ".$input['idProyecto'];

		$sql = "
			DECLARE
				@fecIni DATE = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				--lo.idListVisibilidadObl,
				ele.idElementoVis,
				ele.nombre
			FROM {$this->sessBDCuenta}.trade.list_visibilidadTradObl lo
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet lod ON lo.idListVisibilidadObl = lod.idListVisibilidadObl
			JOIN trade.elementoVisibilidadTrad ele ON lod.idElementoVis = ele.idElementoVis
			JOIN trade.proyecto py ON lo.idProyecto = py.idProyecto
			WHERE fn.datesBetween(lo.fecIni, lo.fecFin, @fecIni, @fecFin) = 1 
			AND lo.estado = 1{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_elementos_obligatorios_pm( $input = [] ){
		$filtros = "";
		//DECLARE @fecIni Date = '01/05/2020', @fecFin DATE = '15/05/2020';
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto='.$input['idProyecto'] : '';

		
		$sql = "
			DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
				select distinct
				vo.idListVisibilidadObl
				,vo.idGrupoCanal
				,evt.idElementoVis
				, evt.nombre
				from 
				{$this->sessBDCuenta}.trade.list_visibilidadTradObl vo
				JOIN trade.proyecto py ON py.idProyecto=vo.idProyecto
				JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet vod
					ON vod.idListVisibilidadObl = vo.idListVisibilidadObl
				JOIN trade.elementoVisibilidadTrad evt
					ON evt.idElementoVis = vod.idElementoVis
					WHERE
					vo.estado=1 
					AND (
					vo.fecIni <= ISNULL( vo.fecFin, @fecFin)
					AND (
					vo.fecIni BETWEEN @fecIni AND @fecFin
					OR
					ISNULL( vo.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
					OR
					@fecIni BETWEEN vo.fecIni AND ISNULL( vo.fecFin, @fecFin )
					OR
					@fecFin BETWEEN vo.fecIni AND ISNULL( vo.fecFin, @fecFin )
					)
					)
				$filtros
				";

		$query = $this->db->query($sql);

		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_elementos_adicionales( $input = [] ){
		$filtros = "";
			if( !empty($input['idCuenta']) ) $filtros .= " AND py.idCuenta = ".$input['idCuenta'];
			if( !empty($input['idProyecto']) ) $filtros .= " AND py.idProyecto = ".$input['idProyecto'];

		$sql = "
			DECLARE
				@fecIni DATE = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				--la.idListVisibilidadAdc,
				ele.idElementoVis,
				ele.nombre
			FROM {$this->sessBDCuenta}.trade.list_visibilidadTradAdc la
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradAdcDet lad ON la.idListVisibilidadAdc = lad.idListVisibilidadAdc
			JOIN trade.elementoVisibilidadTrad ele ON lad.idElementoVis = ele.idElementoVis
			JOIN trade.proyecto py ON py.idProyecto = la.idProyecto
			WHERE fn.datesBetween(la.fecIni, la.fecFin, @fecIni, @fecFin) = 1
			AND la.estado = 1{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_iniciativas( $input = [] ){
		$filtros = "";
			if( !empty($input['idCuenta']) ) $filtros .= " AND py.idCuenta = ".$input['idCuenta'];
			if( !empty($input['idProyecto']) ) $filtros .= " AND py.idProyecto = ".$input['idProyecto'];

		$sql = "
			DECLARE
				@fecIni DATE = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				--li.idListIniciativaTrad,
				ele.idElementoVis,
				ini.nombre + '<br>' + ele.nombre AS nombre
			FROM {$this->sessBDCuenta}.trade.list_iniciativaTrad li
			JOIN {$this->sessBDCuenta}.trade.list_iniciativaTradDet lid ON li.idListIniciativaTrad = lid.idListIniciativaTrad
			JOIN {$this->sessBDCuenta}.trade.list_iniciativaTradDetElemento lide ON lid.idListIniciativaTradDet = lide.idListIniciativaTradDet
			JOIN {$this->sessBDCuenta}.trade.iniciativaTrad ini ON lid.idIniciativa = ini.idIniciativa
			JOIN trade.elementoVisibilidadTrad ele ON lide.idElementoVis = ele.idElementoVis
			JOIN trade.proyecto py ON li.idProyecto = py.idProyecto
			WHERE fn.datesBetween(li.fecIni, li.fecFin, @fecIni, @fecFin) = 1
			AND li.estado = 1{$filtros}
			ORDER BY nombre
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_resultados_obligatorios( $input = [] ){
		$filtros = "";

			$sessIdTipoUsuario = $this->idTipoUsuario;
			if( $sessIdTipoUsuario != 4 ) $filtros .=  " AND r.demo = 0";

		$sql = "
			DECLARE
				@fecIni Date = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				v.idVisita
				,v.idCliente
				,vo.porcentaje
				,vod.idElementoVis
				,vod.idVariable
				,vv.descripcion
				,vod.presencia
				,vod.cantidad
				,o.descripcion
				,vod.idVisitaFoto
				,vf.fotoUrl
				, CASE WHEN listD.idElementoVis IS NOT NULL THEN 1 ELSE 0 END modulado
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta	
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vo ON vo.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vod ON vod.idVisitaVisibilidad = vo.idVisitaVisibilidad
			JOIN trade.variableVisibilidad vv ON vv.idVariable = vod.idVariable
			LEFT JOIN trade.observacionElementoVisibilidadObligatorio o ON o.idObservacion = vod.idObservacion
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = vod.idVisitaFoto
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradObl list ON list.idListVisibilidadObl = v.idListVisibilidadTradObl
			LEFT JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet listD ON listD.idListVisibilidadObl = list.idListVisibilidadObl
			WHERE r.fecha BETWEEN @fecIni AND @fecFin --AND r.idTipoUsuario = 4
			AND r.estado = 1 AND v.estado = 1{$filtros}
		";


		return $this->db->query($sql)->result_array();
	}

	public function obtener_resultados_adicionales( $input = [] ){
		$filtros = "";

			$sessIdTipoUsuario = $this->idTipoUsuario;
			if( $sessIdTipoUsuario != 4 ) $filtros .=  " AND r.demo = 0";

		$sql = "
			DECLARE
				@fecIni Date = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				v.idVisita,
				v.idCliente,
				vo.porcentaje,
				vod.idElementoVis,
				vod.presencia,
				vod.cant
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
		";

		if( $input['visibFormato'] == 2 ) // FORMATO EO
		$sql .= "
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vob ON v.idVisita = vob.idVisita
		";

		$sql .= "
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional vo ON vo.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet vod ON vod.idVisitaVisibilidad = vo.idVisitaVisibilidad
			WHERE r.fecha BETWEEN @fecIni AND @fecFin --AND r.idTipoUsuario=4
			AND r.estado = 1 AND v.estado = 1{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_resultados_iniciativas( $input = [] ){
		$filtros = "";

			$sessIdTipoUsuario = $this->idTipoUsuario;
			if( $sessIdTipoUsuario != 4 ) $filtros .=  " AND r.demo = 0";

		$sql = "
			DECLARE
				@fecIni Date = '{$input['fecIni']}',
				@fecFin DATE = '{$input['fecFin']}';

			SELECT DISTINCT
				v.idVisita,
				v.idCliente,
				vo.porcentaje,
				vod.idElementoVis,
				vod.presencia
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
		";

		if( $input['visibFormato'] == 2 ) // FORMATO EO
		$sql .= "
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vob ON v.idVisita = vob.idVisita
		";

		$sql .= "
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vo ON vo.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet vod ON vod.idVisitaVisibilidad = vo.idVisitaVisibilidad
			WHERE r.fecha BETWEEN @fecIni AND @fecFin --AND r.idTipoUsuario = 4
			AND r.estado = 1 AND v.estado = 1{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}

	public function get_visitas_observaciones($input = []){

		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto='.$input['idProyecto'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal='.$input['idCanal'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal='.$input['idGrupoCanal'] : '';

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';

		$filtros .= !empty($input['frecuencia_filtro']) ? ' AND v.idFrecuencia='.$input['frecuencia_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';

		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);

		$sql = "
		DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
		SELECT DISTINCT
			v.idVisita
			, CONVERT(varchar,r.fecha,103) fecha
			, v.idCliente
			, v.codCliente
			, c.codDist
			, v.idCanal
			, gc.nombre AS grupoCanal
			, v.canal
			, sc.nombre AS subCanal
			, ch.idZona
			, i.nombreIncidencia
			, i.observacion
			, v.estadoIncidencia
			, ct.nombre clienteTipo
			, ub1.departamento
			, ub1.provincia
			, ub1.distrito
			, v.razonSocial
			, v.direccion
			, ut.nombre AS tipoUsuario
			, r.nombreUsuario AS usuario
			, i.nombreIncidencia 
			, i.observacion
			, v.estadoIncidencia
			, evt.nombre AS elementoVisibilidad
			, CASE WHEN vvtd.presencia=1 THEN 'SI' ELSE 'NO' END presencia
			, vvv.descripcion variable
			, ISNULL(oeo.descripcion,'-') observacion
			{$segmentacion['columnas_bd']}
		FROM
			{$this->sessBDCuenta}.trade.data_visita v
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vo
				ON vo.idVisita = v.idVisita
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_ruta r
				ON r.idRuta = v.idRuta
				--AND r.idTipoUsuario=4 
				and r.demo=0
			JOIN ".getClienteHistoricoCuenta()." ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
			JOIN trade.cliente c
				ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc 
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			--LEFT JOIN trade.cliente_distribuidora cd
			--	ON cd.idCliente = v.idCliente
			--	AND General.dbo.fn_fechaVigente(cd.fecIni,cd.fecFin,@fecIni,@fecFin)=1
			--LEFT JOIN trade.distribuidoraSucursal ds
			--	ON ds.idDistribuidoraSucursal = cd.idDistribuidoraSucursal
			--LEFT JOIN trade.distribuidora dis
			--	ON dis.idDistribuidora = ds.idDistribuidora
			--LEFT JOIN General.dbo.ubigeo ub
			--	ON ub.cod_ubigeo = ds.cod_ubigeo
			LEFT JOIN General.dbo.ubigeo ub1
				ON ub1.cod_ubigeo = c.cod_ubigeo
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvt
				ON vvt.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvtd
				ON vvtd.idVisitaVisibilidad = vvt.idVisitaVisibilidad
			JOIN trade.elementoVisibilidadTrad evt
				ON evt.idElementoVis = vvtd.idElementoVis
			JOIN trade.variableVisibilidad vvv 
				ON vvv.idVariable = vvtd.idVariable
			JOIN trade.observacionElementoVisibilidadObligatorio oeo
				ON oeo.idObservacion = vvtd.idObservacion
			LEFT JOIN trade.usuario_tipo ut
				ON r.idTipoUsuario = ut.idTipoUsuario
			{$segmentacion['join']}
		WHERE 
			r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
		";

		return $this->db->query($sql);
	}
	
	public function hfs_data_resultados_precios_marcados($input = []){
		
		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto='.$input['idProyecto'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND c.idCanal='.$input['idCanal'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND gc.idGrupoCanal='.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
		$filtros .= !empty($input['frecuencia_filtro']) ? ' AND v.idFrecuencia='.$input['frecuencia_filtro'] : '';

		$sql = "
		DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
		SELECT DISTINCT
		v.idVisita
		,vvo.porcentajePM
		FROM
		{$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisita = v.idVisita
		LEFT JOIN trade.canal c ON v.idCanal = c.idCanal
		LEFT JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
		WHERE 
		r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		";

		return $this->db->query($sql);
	}
	
	public function elementos_visita(){
		$sql = "
		SELECT
		JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvt
		ON vvt.idVisita = v.idVisita
		JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvtd
			ON vvtd.idVisitaVisibilidad = vvt.idVisitaVisibilidad
		JOIN trade.elementoVisibilidadTrad evt
			ON evt.idElementoVis = vvtd.idElementoVis
		JOIN trade.variableVisibilidad vvv 
			ON vvv.idVariable = vvtd.idVariable
		JOIN trade.observacionElementoVisibilidadObligatorio oeo
			ON oeo.idObservacion = vvtd.idObservacion
		";

		return $this->db->query($sql);
	}
	
	public function obtener_resultados_auditores($input = [])
	{
		$filtros = "";
		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto='.$input['idProyecto'] : '';
	

		$sql = "
		DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
		SELECT DISTINCT
			tabla.idCliente,
			AVG(tabla.porcentajeCliente) over (partition by tabla.idCliente) as porcentajeCliente,
			AVG(tabla.porcentajeGTM) over (partition by tabla.idCliente) as porcentajeGTM
		FROM
		(
		SELECT DISTINCT
			v.idVisita,
			v.idCliente,
			vv.porcentaje as porcentajeEO,
			vv.porcentajeV,
			vv.porcentajePM,
			(vv.porcentaje*100/100) as porcentajeCliente,
			((vv.porcentajeV*80/100)+(vv.porcentajePM*20/100)) as porcentajeGTM
		FROM 
			{$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta=v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vv ON v.idVisita=vv.idVisita
		WHERE 
		r.fecha between @fecIni and @fecFin
		and r.estado='1' and r.demo = '0'and v.estado='1'
		{$filtros}
		)tabla";
		
		return $this->db->query($sql);
	}

	public function get_clientes($input = []){
		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto='.$input['idProyecto'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal='.$input['idCanal'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal='.$input['idGrupoCanal'] : '';

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';

		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
		$filtros .= !empty($input['frecuencia_filtro']) ? ' AND v.idFrecuencia='.$input['frecuencia_filtro'] : '';

		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);

		$sql = "
		DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
			SELECT DISTINCT
			v.idVisita
			, CONVERT(varchar,r.fecha,103) fecha
			, v.idCliente
			, v.codCliente
			, v.idCanal
			, gc.nombre AS grupoCanal
			, v.canal
			, sc.nombre AS subCanal
			, ch.idZona
			, v.estadoIncidencia
			, ct.nombre clienteTipo
			, ub1.departamento
			, ub1.provincia
			, ub1.distrito
			, v.razonSocial
			, v.direccion
			, ut.nombre AS tipoUsuario
			, r.nombreUsuario AS usuario
			, c.codDist AS codRD
			, c.codCliente
			{$segmentacion['columnas_bd']}
			, sum(case when (v.estado =1 )  then 1 else 0 end ) over(partition by v.idCliente) 'cantVisitas'
			, sum(case when (v.estado =1 )  then isnull(convert(tinyint,v.estadoIncidencia),0) else 0 end ) over(partition by v.idCliente) 'cantIncidencias'

		FROM
			{$this->sessBDCuenta}.trade.data_visita v
			JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vo
				ON vo.idVisita = v.idVisita
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc
				ON ca.idGrupoCanal=gc.idGrupoCanal
			JOIN {$this->sessBDCuenta}.trade.data_ruta r
				ON r.idRuta = v.idRuta
				--AND r.idTipoUsuario=4 
				and r.demo=0
			JOIN ".getClienteHistoricoCuenta()." ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
			JOIN trade.cliente c
				ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo

			--LEFT JOIN trade.zona z
			--	ON z.idZona = ch.idZona
			--LEFT JOIN trade.cliente_distribuidora cd
			--	ON cd.idCliente = v.idCliente
			--	AND General.dbo.fn_fechaVigente(cd.fecIni,cd.fecFin,@fecIni,@fecFin)=1
			--LEFT JOIN trade.distribuidoraSucursal ds
			--	ON ds.idDistribuidoraSucursal = cd.idDistribuidoraSucursal
			--LEFT JOIN trade.distribuidora dis
			--	ON dis.idDistribuidora = ds.idDistribuidora
			--LEFT JOIN General.dbo.ubigeo ub
			--	ON ub.cod_ubigeo = ds.cod_ubigeo

			LEFT JOIN General.dbo.ubigeo ub1
				ON ub1.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN trade.usuario_tipo ut
				ON r.idTipoUsuario = ut.idTipoUsuario
			{$segmentacion['join']}
		WHERE 
			r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
		";

		return $this->db->query($sql);
	}

	public function get_visitas_modulacion($input = []){
		$sql = "
			SELECT DISTINCT
				e.idElementoVis,
				e.nombre,
				vmodd.flagCorrecto
			FROM {$this->sessBDCuenta}.trade.data_visitaModulacion vmod
			JOIN {$this->sessBDCuenta}.trade.data_visitaModulacionDet vmodd ON vmod.idVisitaModulacion = vmodd.idVisitaModulacion
			JOIN trade.elementoVisibilidadTrad e ON vmodd.idElementoVis = e.idElementoVis
			WHERE vmod.idVisita = {$input['idVisita']}
			ORDER BY e.nombre
		";

		return $this->db->query($sql)->result_array();
	}

	public function listar_distribuidoras($params = [])
	{
		$filtros = "";

		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta=' . $params['idCuenta'] : '';
		$filtros .= !empty($params['idProyecto']) ? ' AND r.idProyecto=' . $params['idProyecto'] : '';
		$filtros .= !empty($params['idCanal']) ? ' AND c.idCanal=' . $params['idCanal'] : '';
		$filtros .= !empty($params['idGrupoCanal']) ? ' AND gc.idGrupoCanal=' . $params['idGrupoCanal'] : '';

		$sql = "
		DECLARE @fecIni AS DATE ='" . $params['fecIni'] . "', @fecFin AS DATE ='" . $params['fecFin'] . "';
		SELECT DISTINCT
			vd.idDistribuidoraSucursal,
			ubi.departamento AS ciudad,
			ubi.distrito AS distrito,
			dis.nombre AS distribuidora
		FROM 
		{$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
		JOIN trade.canal c ON v.idCanal = c.idCanal
		JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
		JOIN {$this->sessBDCuenta}.trade.data_visitaDet vd on v.idVisita = vd.idVisita
		JOIN trade.distribuidoraSucursal ds on vd.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
		JOIN trade.distribuidora dis on ds.idDistribuidora = dis.idDistribuidora
		JOIN General.dbo.ubigeo ubi ON ds.cod_ubigeo = ubi.cod_ubigeo
		WHERE 
		r.estado = 1
		AND r.demo = 0
		AND v.estado = 1
		AND r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY ciudad, distribuidora
		";

		return $this->db->query($sql);
	}

	public function get_usuarios($input = [])
	{
		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta=' . $input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto=' . $input['idProyecto'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
		$sql = "
			DECLARE @fecIni Date = '" . $input['fecIni'] . "', @fecFin DATE = '" . $input['fecFin'] . "';
			SELECT DISTINCT
				ub1.departamento ciudad
				, ub1.distrito
				, ut.nombre AS tipoUsuario
				, r.nombreUsuario
				, r.idUsuario
			FROM 
				{$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v 
					ON r.idRuta=v.idRuta 
				LEFT JOIN trade.usuario_tipo ut
					ON r.idTipoUsuario = ut.idTipoUsuario
				LEFT JOIN General.dbo.ubigeo ub1
					ON ub1.cod_ubigeo = v.cod_ubigeo
				
			WHERE 
				r.fecha between @fecIni and @fecFin
			{$filtros}
			";

		return $this->db->query($sql);
	}

	public function listar_canales($params = [])
	{
		$filtros = "";

		$filtros .= !empty($params['idGrupoCanal']) ? ' AND c.idGrupoCanal=' . $params['idGrupoCanal'] : '';

		$sql = "
			SELECT
			c.idCanal
				, c.nombre AS canal
			FROM trade.canal c
			WHERE estado = 1

			{$filtros}
		";

		return $this->db->query($sql);
	}

	public function obtener_clientes_distribuidoras($params = [])
	{
		$filtros = "";
		$subfiltros = "";

		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta=' . $params['idCuenta'] : '';
		$filtros .= !empty($params['idProyecto']) ? ' AND r.idProyecto=' . $params['idProyecto'] : '';
		$filtros .= !empty($params['idCanal']) ? ' AND c.idCanal=' . $params['idCanal'] : '';
		$filtros .= !empty($params['idGrupoCanal']) ? ' AND gc.idGrupoCanal=' . $params['idGrupoCanal'] : '';
		$filtros .= !empty($params['idClienteTipo']) ? ' AND sn.idClienteTipo=' . $params['idClienteTipo'] : '';
		$filtros .= !empty($params['idDistribuidora']) ? ' AND ds.idDistribuidora=' . $params['idDistribuidora'] : '';
		$filtros .= !empty($params['idFrecuencia']) ? ' AND v.idFrecuencia IN (' . $params['idFrecuencia'] . ')' : '';
		
		$subfiltros .= !empty($params['idCanal']) ? ' AND ch.idCanal=' . $params['idCanal'] : '';
		$subfiltros .= !empty($params['idDistribuidora']) ? ' AND dis.idDistribuidora=' . $params['idDistribuidora'] : '';
		$subfiltros .= !empty($params['idFrecuencia']) ? ' AND ch.idFrecuencia IN (' . $params['idFrecuencia'] . ')' : '';

		$sql = "
			DECLARE @fecha AS DATE = GETDATE(), @fecIni AS DATE ='" . $params['fecIni'] . "', @fecFin AS DATE ='" . $params['fecFin'] . "';
			WITH distribuidorasSucursales AS (
				SELECT DISTINCT
					vd.idDistribuidoraSucursal
				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
				JOIN trade.canal c ON v.idCanal = c.idCanal
				JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
				JOIN {$this->sessBDCuenta}.trade.data_visitaDet vd ON v.idVisita = vd.idVisita
				LEFT JOIN ".getClienteHistoricoCuenta()." ch ON v.idCliente = ch.idCliente
				LEFT JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
				JOIN trade.distribuidoraSucursal ds ON vd.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
				WHERE 
					r.estado = 1
					AND r.demo = 0
					AND v.estado = 1
					AND r.fecha BETWEEN @fecIni AND @fecFin
					{$filtros}
					--AND v.idZona = 0
					--AND ds.idDistribuidora = 0
					--AND vd.idDistribuidoraSucursal = 0
					--AND v.idCanal = 0
					--AND sn.idClienteTipo = 0
					--AND v.idFrecuencia IN (0)
			), clientesHistoricos AS (
				SELECT
					ch.idCliente
					, sn.idClienteTipo
					, sn.idCanal
					, ch.idFrecuencia
					--, ch.auditoria
					, ch.idClienteHist
					, ch.idSegClienteTradicional
					, ROW_NUMBER() OVER ( PARTITION BY ch.idCliente ORDER BY ch.idClienteHist DESC ) ROW
				FROM ".getClienteHistoricoCuenta()." ch
				JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
				WHERE fn.datesBetween(ch.fecIni, ch.fecFin, @fecIni, @fecFin) = 1
			)
			SELECT DISTINCT
				ds.idDistribuidoraSucursal
				, ch.idCanal
				, COUNT(c.idCliente) OVER (PARTITION BY ds.idDistribuidoraSucursal, ch.idCanal) AS cliDistCanal
				, COUNT(c.idCliente) OVER (PARTITION BY ds.idDistribuidoraSucursal) AS cliDist
				, COUNT(c.idCliente) OVER (PARTITION BY ch.idCanal) AS cliCanal
			FROM trade.cliente c
			JOIN clientesHistoricos ch ON c.idCliente = ch.idCliente AND row = 1 AND c.estado = 1 --AND ch.auditoria = 1
			JOIN trade.cliente_tipo ct ON ch.idClienteTipo = ct.idClienteTipo

			--LEFT JOIN trade.cliente_distribuidora cd ON cd.idCliente = c.idCliente AND fn.datesBetween(cd.fecIni,cd.fecFin,@fecIni,@fecFin) = 1
			LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional

			LEFT JOIN trade.distribuidoraSucursal ds ON sct.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
			LEFT JOIN trade.distribuidora dis ON ds.idDistribuidora = dis.idDistribuidora
			WHERE c.estado = 1
				AND ds.idDistribuidoraSucursal IN (SELECT idDistribuidoraSucursal FROM distribuidorasSucursales)
				{$subfiltros}
				----AND ds.idZona = 0
				--AND dis.idDistribuidora = 0
				--AND ds.idDistribuidoraSucursal = 0
				--AND ch.idCanal = 0
				--AND ch.idFrecuencia IN (0)
		";

		return $this->db->query($sql);
	}

	public function obtener_clientes_programados_distribuidoras($params = [])
	{
		$filtros = "";

		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta=' . $params['idCuenta'] : '';
		$filtros .= !empty($params['idProyecto']) ? ' AND r.idProyecto=' . $params['idProyecto'] : '';
		$filtros .= !empty($params['idCanal']) ? ' AND c.idCanal=' . $params['idCanal'] : '';
		$filtros .= !empty($params['idGrupoCanal']) ? ' AND gc.idGrupoCanal=' . $params['idGrupoCanal'] : '';
		$filtros .= !empty($params['idClienteTipo']) ? ' AND sn.idClienteTipo=' . $params['idClienteTipo'] : '';
		$filtros .= !empty($params['idDistribuidora']) ? ' AND ds.idDistribuidora=' . $params['idDistribuidora'] : '';
		$filtros .= !empty($params['idFrecuencia']) ? ' AND v.idFrecuencia IN (' . $params['idFrecuencia'] . ')' : '';

		$sql = "
			DECLARE @fecIni AS DATE ='" . $params['fecIni'] . "', @fecFin AS DATE ='" . $params['fecFin'] . "';
			WITH distribuidorasSucursales AS (
				SELECT DISTINCT
					vd.idDistribuidoraSucursal
					, v.idCanal
					, v.idCliente
				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
				JOIN trade.canal c ON v.idCanal = c.idCanal
				JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
				JOIN {$this->sessBDCuenta}.trade.data_visitaDet vd ON v.idVisita = vd.idVisita
				LEFT JOIN ".getClienteHistoricoCuenta()." ch ON v.idCliente = ch.idCliente
				LEFT JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
				JOIN trade.distribuidoraSucursal ds ON vd.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
				WHERE
				r.estado = 1
				AND r.demo = 0
				AND v.estado = 1
				AND r.fecha BETWEEN @fecIni AND @fecFin
				{$filtros}
			)
			SELECT DISTINCT
				ds_l.idDistribuidoraSucursal,
				ds_l.idCanal,
				COUNT(ds_l.idCliente) OVER (PARTITION BY ds_l.idDistribuidoraSucursal, ds_l.idCanal) AS cliDistCanal,
				COUNT(ds_l.idCliente) OVER (PARTITION BY ds_l.idDistribuidoraSucursal) AS cliDist,
				COUNT(ds_l.idCliente) OVER (PARTITION BY ds_l.idCanal) AS cliCanal
			FROM distribuidorasSucursales ds_l
		";

		return $this->db->query($sql);
	}

	public function detalle_cobertura_auditores($params = [])
	{
		$subfiltros = "";

		$subfiltros .= !empty($params['idCanal']) ? ' AND ch.idCanal=' . $params['idCanal'] : '';
		$subfiltros .= !empty($params['idDistribuidora']) ? ' AND dis.idDistribuidora=' . $params['idDistribuidora'] : '';
		$subfiltros .= !empty($params['idFrecuencia']) ? ' AND ch.idFrecuencia IN (' . $params['idFrecuencia'] . ')' : '';

		$sql = "
		DECLARE @idDistribuidoraSucursal AS INT ='" . $params['distSucursal'] . "', @idCanal AS INT ='" . $params['canal'] . "', @fecha AS DATE = GETDATE(), @fecIni AS DATE ='" . $params['fecIni'] . "', @fecFin AS DATE ='" . $params['fecFin'] . "';
		WITH clientesHistoricos AS (
			SELECT
				ch.idCliente
				, sn.idClienteTipo
				, sn.idCanal
				, ch.idFrecuencia
				--, ch.auditoria
				, ch.idClienteHist
				, ch.idSegClienteTradicional
				, ROW_NUMBER() OVER ( PARTITION BY ch.idCliente ORDER BY ch.idClienteHist DESC ) ROW
			FROM ".getClienteHistoricoCuenta()." ch
			JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
			WHERE fn.datesBetween(ch.fecIni, ch.fecFin, @fecIni, @fecFin) = 1
		)
		SELECT DISTINCT
			ds.idDistribuidoraSucursal
			, ch.idCanal
			, c.idCliente
			, c.codDist as codRD
			, c.razonSocial
			, c.direccion
		FROM trade.cliente c
		JOIN clientesHistoricos ch ON c.idCliente = ch.idCliente AND row = 1 AND c.estado = 1 --AND ch.auditoria = 1
		JOIN trade.cliente_tipo ct ON ch.idClienteTipo = ct.idClienteTipo

		--LEFT JOIN trade.cliente_distribuidora cd ON cd.idCliente = c.idCliente AND fn.datesBetween(cd.fecIni,cd.fecFin,@fecIni,@fecFin) = 1
		LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional

		LEFT JOIN trade.distribuidoraSucursal ds ON sct.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora dis ON ds.idDistribuidora = dis.idDistribuidora
		WHERE c.estado = 1
		AND ds.idDistribuidoraSucursal = @idDistribuidoraSucursal
		AND ch.idCanal = @idCanal
		{$subfiltros}
    ";

		return $this->db->query($sql);
	}

	public function obtener_resumen_usuarios($input = []){
		$filtros = "";

		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto='.$input['idProyecto'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND c.idCanal=' . $input['idCanal'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND gc.idGrupoCanal=' . $input['idGrupoCanal'] : '';

		$sql = "
      DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
      SELECT DISTINCT
        r.idUsuario,
        CONVERT(VARCHAR(10),r.fecha,103) as fecha,
        COUNT(v.idVisita) over (partition by r.idUsuario,r.fecha) as vProg,
        COUNT(v.idVisita) over (partition by r.idUsuario) as vProgTotalEmpleado,
        COUNT(v.idVisita) over (partition by r.fecha) as vProgTotalFecha,
        SUM(CASE WHEN v.horaIni is not null THEN 1 ELSE 0 END) over (partition by r.idUsuario,r.fecha) as vReal,
        SUM(CASE WHEN v.horaIni is not null THEN 1 ELSE 0 END) over (partition by r.idUsuario) as vRealTotalEmpleado,
        SUM(CASE WHEN v.horaIni is not null THEN 1 ELSE 0 END) over (partition by r.fecha) as vRealTotalFecha,
        SUM(CASE WHEN v.horaIni is not null and v.horaFin is not null and (v.estadoIncidencia=0 or v.estadoIncidencia is null) THEN 1 ELSE 0 END) over (partition by r.idUsuario,r.fecha) as vEfec,
        SUM(CASE WHEN v.horaIni is not null and v.horaFin is not null and (v.estadoIncidencia=0 or v.estadoIncidencia is null) THEN 1 ELSE 0 END) over (partition by r.idUsuario) as vEfecTotalEmpleado,
        SUM(CASE WHEN v.horaIni is not null and v.horaFin is not null and (v.estadoIncidencia=0 or v.estadoIncidencia is null) THEN 1 ELSE 0 END) over (partition by r.fecha) as vEfecTotalFecha
      FROM 
        {$this->sessBDCuenta}.trade.data_ruta r
        JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta=v.idRuta
		LEFT JOIN trade.canal c ON v.idCanal = c.idCanal
		LEFT JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
      WHERE 
        r.fecha between @fecIni and @fecFin
        {$filtros}
        ";

		return $this->db->query($sql);
	}

	public function detalle_cobertura_programados_auditores($params = [])
	{
		$filtros = "";

		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta=' . $params['idCuenta'] : '';
		$filtros .= !empty($params['idProyecto']) ? ' AND r.idProyecto=' . $params['idProyecto'] : '';
		$filtros .= !empty($params['idCanal']) ? ' AND c.idCanal=' . $params['idCanal'] : '';
		$filtros .= !empty($params['idGrupoCanal']) ? ' AND gc.idGrupoCanal=' . $params['idGrupoCanal'] : '';
		$filtros .= !empty($params['idClienteTipo']) ? ' AND sn.idClienteTipo=' . $params['idClienteTipo'] : '';
		$filtros .= !empty($params['idDistribuidora']) ? ' AND ds.idDistribuidora=' . $params['idDistribuidora'] : '';
		$filtros .= !empty($params['idFrecuencia']) ? ' AND v.idFrecuencia IN (' . $params['idFrecuencia'] . ')' : '';

		$sql = "
		DECLARE @idDistribuidoraSucursal AS INT ='" . $params['distSucursal'] . "', @idCanal AS INT ='" . $params['canal'] . "', @fecha AS DATE = GETDATE(), @fecIni AS DATE ='" . $params['fecIni'] . "', @fecFin AS DATE ='" . $params['fecFin'] . "';
		SELECT DISTINCT
			vd.idDistribuidoraSucursal
			, v.idCanal
			, v.idCliente
			, cl.codDist AS codRD
			, ch.razonSocial
			, ch.direccion
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
		JOIN trade.canal c ON v.idCanal = c.idCanal
		JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
		JOIN {$this->sessBDCuenta}.trade.data_visitaDet vd ON v.idVisita = vd.idVisita
		LEFT JOIN trade.cliente cl ON v.idCliente = cl.idCliente
		LEFT JOIN ".getClienteHistoricoCuenta()." ch ON v.idCliente = ch.idCliente
		LEFT JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
		JOIN trade.distribuidoraSucursal ds ON vd.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
		WHERE
		r.estado = 1
		AND r.demo = 0
		AND v.estado = 1
		AND r.fecha BETWEEN @fecIni AND @fecFin
		AND ds.idDistribuidoraSucursal = @idDistribuidoraSucursal
		AND v.idCanal = @idCanal
		{$filtros}
    ";

		return $this->db->query($sql);
	}

	public function listar_fechas($input = [])
	{
		$sql = "
		DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
		SELECT tt.idTiempo, CONVERT(VARCHAR(10),tt.fecha,103) as fecha, UPPER(tt.mes) as mes
		FROM 
			general.dbo.tiempo tt
		WHERE
			tt.fecha between @fecIni and @fecFin
		ORDER BY
			tt.fecha ASC
		";

		return $this->db->query($sql);
	}


	public function obtener_num_fotos($input = [] ){
		$sql ="
			DECLARE @fecIni Date = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
			
			SELECT DISTINCT v.idVisita,COUNT(vf.idVisitaFoto)OVER (PARTITION BY v.idVisita ) totalFotos
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta	
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisita=v.idVisita
			WHERE 
				 r.fecha BETWEEN @fecIni AND @fecFin
		";
		return $this->db->query($sql)->result_array();
	}
}
?>