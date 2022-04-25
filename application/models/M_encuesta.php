<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_encuesta extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getTiposDePregunta()
	{
		$sql = "
			SELECT *
			FROM master.tipoPregunta;
		";

		return $this->db->query($sql);
	}

	public function getEncuestasActivas($input=array())
	{
		$filtros = "";
		$filtros .= !empty($input['idCuenta']) ? ' AND e.idCuenta = '.$input['idCuenta'] : '';

		$sql = "
			SELECT DISTINCT 
				e.idEncuesta, 
				e.nombre 'encuesta'
			FROM {$this->sessBDCuenta}.trade.list_encuesta le
				JOIN {$this->sessBDCuenta}.trade.list_encuestaDet led ON le.idListEncuesta = led.idListEncuesta
				JOIN {$this->sessBDCuenta}.trade.encuesta e ON led.idEncuesta = e.idEncuesta
			
			WHERE 1=1
				$filtros
			ORDER BY e.nombre;
		";
		

		return $this->db->query($sql);
	}

	public function query_visitaEncuesta($input)
	{
		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta = '.$this->sessIdCuenta : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$this->sessIdProyecto : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal = '.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal = '.$input['idCanal'] : '';
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';
		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';

		$filtros .= !empty($input['departamento_filtro']) ? ' AND ubi01.cod_departamento='.$input['departamento_filtro'] : '';
		$filtros .= !empty($input['provincia_filtro']) ? ' AND ubi01.cod_provincia='.$input['provincia_filtro'] : '';
		$filtros .= !empty($input['distrito_filtro']) ? ' AND ubi01.cod_ubigeo='.$input['distrito_filtro'] : '';

		if (!empty($input['idEncuesta'])) $filtros .= " AND ve.idEncuesta IN ( " . $input['idEncuesta']. ')';

		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);

		$orderby = '';
		if($segmentacion['grupoCanal'] == 'HSM' OR $segmentacion['grupoCanal'] == 'Moderno')
		{
			$orderby = 'ORDER BY fecha, tipoUsuario, cadena, canal, ciudad, provincia, distrito ASC';
		}
		if($segmentacion['grupoCanal'] == 'WHLS')
		{
			$orderby = 'ORDER BY fecha, tipoUsuario, zona, canal, ciudad, provincia, distrito ASC';
		}
		if($segmentacion['grupoCanal'] == 'HFS')
		{
			$orderby = 'ORDER BY fecha, tipoUsuario, distribuidora, canal, ciudad, provincia, distrito ASC';
		}

		if (!empty($input['elementos_det'])) $filtros .= " AND v.idVisita IN (  ".$input['elementos_det']." )";

		$sql = "
		DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
		SELECT DISTINCT
				v.idVisita
				, ubi01.departamento ciudad
				, v.idCliente
				, c.codCliente
				, c.codDist
				, v.razonSocial
				, ct.nombre AS tipoCliente
				, v.direccion
				, ubi01.distrito
				, CONVERT(varchar,r.fecha,103) fecha
				, r.idUsuario
				, r.nombreUsuario usuario
				, ISNULL(pgc.nombre,gc.nombre) AS grupoCanal
				, v.canal
				, sc.nombre AS subCanal
				, ubi01.provincia
				, upper(r.tipoUsuario) tipoUsuario
				, v.latIni latitud
				, v.lonIni longitud
				, ti.nombre incidencia
				, v.encuesta encuestado
				, v.horaIni
				, ct.idClienteTipo
				, ct.nombre subCanal
				{$segmentacion['columnas_bd']}
				--, e.idEncuesta
				--, e.nombre encuesta
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta=v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita=ve.idVisita
			
			JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta=ve.idEncuesta

			JOIN trade.cliente c ON v.idCliente=c.idCliente
			LEFT JOIN General.dbo.ubigeo ubi01 ON c.cod_ubigeo=ubi01.cod_ubigeo
			JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN trade.proyectoGrupoCanal pgc ON pgc.idGrupoCanal = gc.idGrupoCanal AND pgc.idProyecto = {$this->sessIdProyecto}

			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON  vi.idVisita = v.idVisita
			LEFT JOIN master.incidencias ti ON ti.idIncidencia = vi.idIncidencia

			JOIN trade.usuario_historico uh ON uh.idUsuario=r.idUsuario
			JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta 

			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=r.idUsuario
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado

			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			LEFT JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1 
			{$segmentacion['join']}
			WHERE r.fecha between @fecIni AND @fecFin --AND r.demo=0
				AND r.estado=1 AND v.estado=1
				{$filtros}
				--{$orderby}
		";
		$this->db->cache_on();
		return $this->db->query($sql);
	}

	public function list_encuesta($input)
	{
		$fechas = getFechasDRP($input["txt-fechas"]);
		$idProyecto = $this->sessIdProyecto ;
		$filtros = '';
		$filtrosPregunta = '';
		if (!empty($input['idEncuesta'])) $filtrosPregunta .= " AND e.idEncuesta IN ( " . $input['idEncuesta']. ')';
		$filtrosPregunta .= !empty($input['tipoPregunta']) ? ' AND ep.idTipoPregunta = '.$input['tipoPregunta'] : '';
		$filtros .= !empty($idProyecto) ? ' AND le.idProyecto = '.$idProyecto : '';

		$sql = "
			DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
			WITH lista_encuestas AS (
				SELECT DISTINCT
					idEncuesta
				FROM 
					{$this->sessBDCuenta}.trade.list_encuesta le
					JOIN {$this->sessBDCuenta}.trade.list_encuestaDet led ON le.idListEncuesta=led.idListEncuesta
				WHERE 
					General.dbo.fn_fechaVigente(le.fecIni,le.fecFin,@fecIni,@fecFin) = 1 
					{$filtros}
			)
			SELECT
				e.idEncuesta,UPPER(e.nombre) 'encuesta',e.foto,
				ep.idPregunta,UPPER(ep.nombre) 'pregunta',ep.idTipoPregunta,ep.orden,
				ea.idAlternativa,UPPER(ea.nombre) 'alternativa',
				eao.idAlternativaOpcion,
				UPPER(eao.nombre) opcion,
				epf.foto imagenPreg
			FROM 
				lista_encuestas l
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta e ON l.idEncuesta=e.idEncuesta AND e.estado = 1
				JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON e.idEncuesta=ep.idEncuesta AND ep.estado = 1
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ep.idPregunta=ea.idPregunta AND ea.estado = 1 
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa_opcion eao ON ep.idPregunta=eao.idPregunta AND eao.estado = 1
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta_foto epf ON ep.idPregunta=epf.idPregunta AND epf.estado = 1
				WHERE 
					1 = 1
				$filtrosPregunta
			ORDER BY e.idEncuesta,ep.orden
		";
		$rs =  $this->db->query($sql);
		
		return $rs;
	}

	public function query_visitaEncuestaDet($input)
	{

		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta = '.$this->sessIdCuenta : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto = '.$this->sessIdProyecto : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal = '.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal = '.$input['idCanal'] : '';

		if (!empty($input['idEncuesta'])) $filtros .= " AND ve.idEncuesta IN ( " . $input['idEncuesta']. ')';

		if (!empty($input['elementos_det'])) $filtros .= " AND v.idVisita IN (  ".$input['elementos_det']." )";

		$sql = "
		DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
			SELECT
			DISTINCT
				v.idVisita
				,ve.idEncuesta
				,vf.idVisitaFoto
				,vf.fotoUrl imgRef
				,vfd.fotoUrl imgRefSub
				,ep.idPregunta,
				ep.idTipoPregunta,
				CASE WHEN ep.idTipoPregunta = 1 THEN isnull(ea.nombre,ved.respuesta) ELSE  ea.nombre END  'respuesta'
				, v.idCliente
				, ep.nombre pregunta
				, ea.idAlternativa
				, e.nombre encuesta
				,ubi01.departamento
				,ubi01.provincia
				,ubi01.distrito
				, c.codCliente
				, c.razonSocial
				, CONVERT(varchar,r.fecha,103) fecha
				, ve.idVisitaEncuesta
				, ve.flagFotoMultiple
				, ved.idAlternativaOpcion
				, eaop.nombre alternativaOpcion
				, vfd2.fotoUrl imgPreg
				, ep.orden
				, te.nombre tipoPregunta
				, ved.comentario
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta=v.idRuta
			JOIN trade.cliente c ON v.idCliente=c.idCliente
			LEFT JOIN General.dbo.ubigeo ubi01 ON c.cod_ubigeo=ubi01.cod_ubigeo
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita=ve.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ve.idVisitaEncuesta=ved.idVisitaEncuesta
				AND ved.estado = 1
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDetFoto vedf ON vedf.idVisitaEncuesta = ve.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta = ve.idEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ved.idPregunta=ep.idPregunta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ved.idAlternativa=ea.idAlternativa
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa_opcion eaop ON ved.idAlternativaOpcion=eaop.idAlternativaOpcion
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = ve.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfd ON vfd.idVisitaFoto = ved.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfd2 ON vfd2.idVisitaFoto = vedf.idVisitaFoto
			LEFT JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN ImpactTrade_bd.master.tipoPregunta te ON te.idTipoPregunta = ep.idTipoPregunta
				AND te.estado = 1
				
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1 
			
			JOIN trade.usuario_historico uh ON uh.idUsuario=r.idUsuario
			JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta 
			LEFT JOIN trade.banner bn ON bn.idBanner=v.idBanner

			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=r.idUsuario
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado

			WHERE r.estado=1 AND v.estado=1  --AND r.demo=0
			
			AND r.fecha between @fecIni AND @fecFin 
		$filtros
		ORDER BY ep.orden,respuesta
		";

		$rs =  $this->db->query($sql)->result_array();
		
		return $rs;
	}

	public function query_visitaEncuestaDetPdf($input)
	{

		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta = '.$this->sessIdCuenta : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$this->sessIdCuenta : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal = '.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal = '.$input['idCanal'] : '';
		
		


		if (!empty($input['idEncuesta'])) $filtros .= " AND ve.idEncuesta IN ( " . $input['idEncuesta']. ')';

		if (!empty($input['elementos_det'])) $filtros .= " AND v.idVisita IN (  ".$input['elementos_det']." )";

		$sql = "
		DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
			SELECT
				distinct
				v.idVisita,ve.idEncuesta
				,vf.idVisitaFoto,vf.fotoUrl imgRef,
				ep.idPregunta,ep.idTipoPregunta,
				isnull(ea.nombre,ved.respuesta) 'respuesta'
				, v.idCliente
				, ep.nombre pregunta
				, ea.idAlternativa
				, e.nombre encuesta
				,ubi01.departamento
				,ubi01.provincia
				,ubi01.distrito
				, c.codCliente
				, c.razonSocial
				, CONVERT(varchar,r.fecha,103) fecha


				,vfAlt.idVisitaFoto idVisitaFotoAlt,vfAlt.fotoUrl imgRefAlt

			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta=v.idRuta
			JOIN trade.cliente c ON v.idCliente=c.idCliente
			LEFT JOIN General.dbo.ubigeo ubi01 ON c.cod_ubigeo=ubi01.cod_ubigeo
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita=ve.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ve.idVisitaEncuesta=ved.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta = ve.idEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ved.idPregunta=ep.idPregunta
			left JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ved.idAlternativa=ea.idAlternativa
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = ve.idVisitaFoto
			LEFT JOIN trade.canal ca ON ca.idCanal = v.idCanal

			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfAlt ON vfAlt.idVisitaFoto = ved.idVisitaFoto
			
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1 
			
			JOIN trade.usuario_historico uh ON uh.idUsuario=r.idUsuario
			JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta 
			LEFT JOIN trade.banner bn ON bn.idBanner=v.idBanner

			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=r.idUsuario
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado

			WHERE r.estado=1 AND v.estado=1  --AND r.demo=0
			
			AND r.fecha between @fecIni AND @fecFin 
		$filtros
		";

		
		$rs =  $this->db->query($sql);
		
		return $rs;
	}


	public function query_visitaEncuestaPdf($input)
	{
		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta = '.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal = '.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal = '.$input['idCanal'] : '';

		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';

		if (!empty($input['idEncuesta'])) $filtros .= " AND ve.idEncuesta IN ( " . $input['idEncuesta']. ')';

		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);

		$orderby = '';
		if($segmentacion['grupoCanal'] == 'HSM' OR $segmentacion['grupoCanal'] == 'Moderno')
		{
			$orderby = 'ORDER BY fecha, tipoUsuario, cadena, canal, ciudad, provincia, distrito ASC';
		}
		if($segmentacion['grupoCanal'] == 'WHLS')
		{
			$orderby = 'ORDER BY fecha, tipoUsuario, zona, canal, ciudad, provincia, distrito ASC';
		}
		if($segmentacion['grupoCanal'] == 'HFS')
		{
			$orderby = 'ORDER BY fecha, tipoUsuario, distribuidora, canal, ciudad, provincia, distrito ASC';
		}

		if (!empty($input['elementos_det'])) $filtros .= " AND v.idVisita IN (  ".$input['elementos_det']." )";

		$sql = "
		DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
		SELECT DISTINCT
				v.idVisita
				, ubi01.departamento ciudad
				, v.idCliente
				, c.codCliente
				, c.codDist
				, v.razonSocial
				, ct.nombre AS tipoCliente
				, v.direccion
				, ubi01.distrito
				, CONVERT(varchar,r.fecha,103) fecha
				, r.idUsuario
				, r.nombreUsuario usuario
				, gc.nombre AS grupoCanal
				, v.canal
				, sc.nombre AS subCanal
				, ubi01.provincia
				, upper(r.tipoUsuario) tipoUsuario
				, v.latIni latitud
				, v.lonIni longitud
				, ti.nombre incidencia
				, v.encuesta encuestado
				, v.horaIni
				, e.idEncuesta
				, e.nombre encuesta
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta=v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita=ve.idVisita
			
			JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta=ve.idEncuesta

			JOIN trade.cliente c ON v.idCliente=c.idCliente
			LEFT JOIN General.dbo.ubigeo ubi01 ON c.cod_ubigeo=ubi01.cod_ubigeo
			JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON  vi.idVisita = v.idVisita
			LEFT JOIN master.incidencias ti ON ti.idIncidencia = vi.idIncidencia

			JOIN trade.usuario_historico uh ON uh.idUsuario=r.idUsuario
			JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta 

			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=r.idUsuario
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado

			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			LEFT JOIN trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
			{$segmentacion['join']}
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1 

			WHERE r.fecha between @fecIni AND @fecFin --AND r.demo=0
				AND r.estado=1 AND v.estado=1
				{$filtros}
				{$orderby}
		";
	
		return $this->db->query($sql);
	}

	public function getVisitaEncuesta($params)
	{
		$sql = "
		DECLARE @fechaInicio DATE = '" . $params['fecIni'] . "', @fechaFin DATE = '" . $params['fecFin'] . "'
		SELECT DISTINCT
			r.idUsuario 
			, v.idCliente
			, ve.idEncuesta
			, COUNT(ve.idEncuesta) OVER (PARTITION BY r.idUsuario, v.idCliente, ve.idEncuesta) num
		FROM
			{$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON ve.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ved.idVisitaEncuesta=ve.idVisitaEncuesta
			JOIN ImpactTrade_bd.trade.cliente t ON t.idCliente = v.idCliente
				AND t.estado = 1
		WHERE 
			r.estado = 1
			AND v.estado = 1
			AND r.fecha BETWEEN @fechaInicio AND @fechaFin
		";

		return $this->db->query($sql);
	}

	public function getVisitaEncuestaDetallado($params)
	{
		$filtros = "";
		if (!empty($params['idEncuesta'])) $filtros .= " AND ve.idEncuesta IN ( " . $params['idEncuesta']. ')';

		$sql = "
		DECLARE @fechaInicio DATE = '" . $params['fecIni'] . "', @fechaFin DATE = '" . $params['fecFin'] . "'
		SELECT DISTINCT
			r.fecha
			, gca.nombre AS grupoCanal
			, ca.nombre AS canal
			, c.idCliente
			, c.razonSocial
			, e.nombre AS encuesta
			, ep.nombre AS pregunta
			, ea.nombre AS alternativa
			--, CASE WHEN ep.idTipoPregunta = 1 THEN isnull(ea.nombre,ved.respuesta) ELSE  ea.nombre END  'respuesta'
			, ved.respuesta
		FROM
			{$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON ve.idVisita = v.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ved.idVisitaEncuesta=ve.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta e ON ve.idEncuesta = e.idEncuesta
			JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ved.idPregunta = ep.idPregunta
			JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ved.idAlternativa = ea.idAlternativa
			JOIN ImpactTrade_bd.trade.cliente c ON v.idCliente = c.idCliente
				AND c.estado = 1
			JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON c.idCliente = ch.idCliente
			AND ch.idProyecto = r.idProyecto AND ch.fecFin IS NULL
			LEFT JOIN ImpactTrade_bd.trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
			LEFT JOIN ImpactTrade_bd.trade.canal ca ON sn.idCanal = ca.idCanal
			LEFT JOIN ImpactTrade_bd.trade.grupoCanal gca ON ca.idGrupoCanal = gca.idGrupoCanal
		WHERE 
			r.estado = 1
			AND v.estado = 1
			AND r.fecha BETWEEN @fechaInicio AND @fechaFin
			{$filtros}
		ORDER BY fecha, razonSocial, encuesta, pregunta, alternativa
		";

		return $this->db->query($sql);
	}

	public function obtenerFotosEncuesta($idVisitaEncuesta = ''){
		$filtros = '';
		!empty($idVisitaEncuesta) ? $filtros .= " AND ve.idVisita IN ({$idVisitaEncuesta})" : '';
		$sql = "
			SELECT DISTINCT
				CONVERT(VARCHAR(8),vf.hora) AS hora
				, ve.idVisita
				, ve.idVisitaEncuesta
				, vf.fotoUrl AS foto
				, CONVERT(VARCHAR(8),vfm.hora) AS horaMultiple
				, vfm.fotoUrl AS fotoMultiple
				, ISNULL(ve.flagFotoMultiple, 0) AS flagFotoMultiple
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuesta ve
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaFotos vef ON ve.idVisitaEncuesta = vef.idVisitaEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=ve.idVisitaFoto
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfm ON vfm.idVisitaFoto=vef.idVisitaFoto
			WHERE 
			1=1 
			{$filtros}
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtenerFotosEncuestaAlternativa($idVisitaEncuesta,$idPregunta){
		$sql = "
			SELECT DISTINCT
				CONVERT(VARCHAR(8),vf.hora) AS hora
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON ved.idVisitaFoto=vf.idVisitaFoto
			WHERE ved.idVisitaEncuesta={$idVisitaEncuesta} AND ved.idPregunta ={$idPregunta}
		";

		return $this->db->query($sql)->result_array();
	}
	public function obtenerFotosEncuestaPregunta($idVisitaEncuesta,$idPregunta){
		$sql = "
			SELECT DISTINCT
				CONVERT(VARCHAR(8),vf.hora) AS hora
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaDetFoto ved
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON ved.idVisitaFoto=vf.idVisitaFoto
			WHERE ved.idVisitaEncuesta={$idVisitaEncuesta} AND ved.idPregunta ={$idPregunta}
		";

		return $this->db->query($sql)->result_array();
	}
}
