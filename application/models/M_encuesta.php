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
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta = '.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal = '.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal = '.$input['idCanal'] : '';
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo='.$input['subcanal'] : '';
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
				, ct.idClienteTipo
				, ct.nombre subCanal
				--, e.idEncuesta
				--, e.nombre encuesta
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

			WHERE r.fecha between @fecIni AND @fecFin AND r.demo=0
				AND r.estado=1 AND v.estado=1
				{$filtros}
				{$orderby}
		";
	
		return $this->db->query($sql);
	}

	public function list_encuesta($input)
	{
		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		if (!empty($input['idEncuesta'])) $filtros .= " AND e.idEncuesta IN ( " . $input['idEncuesta']. ')';
		$filtros .= !empty($input['tipoPregunta']) ? ' AND ep.idTipoPregunta = '.$input['tipoPregunta'] : '';

		$sql = "
			DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
			SELECT DISTINCT
					e.idEncuesta,e.nombre 'encuesta',e.foto,
					ep.idPregunta,ep.nombre 'pregunta',ep.idTipoPregunta,ep.orden,
					ea.idAlternativa,ea.nombre 'alternativa'
				FROM {$this->sessBDCuenta}.trade.list_encuesta le
				JOIN {$this->sessBDCuenta}.trade.list_encuestaDet led ON le.idListEncuesta=led.idListEncuesta
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta e ON led.idEncuesta=e.idEncuesta
				JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON e.idEncuesta=ep.idEncuesta
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ep.idPregunta=ea.idPregunta
				LEFT JOIN trade.canal ca ON ca.idCanal = le.idCanal
				WHERE 
					le.fecIni<=isnull(le.fecFin,@fecFin)
					AND ( @fecIni between le.fecIni AND isnull(le.fecFin,@fecFin) or @fecFin between le.fecIni AND isnull(le.fecFin,@fecFin)
					or le.fecIni between @fecIni AND @fecFin or isnull(le.fecFin,@fecFin) between @fecIni AND @fecFin )
				$filtros
			ORDER BY e.idEncuesta,ep.orden
		";
		return $this->db->query($sql);
	}

	public function query_visitaEncuestaDet($input)
	{

		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta = '.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
		$filtros .= !empty($input['idGrupoCanal']) ? ' AND ca.idGrupoCanal = '.$input['idGrupoCanal'] : '';
		$filtros .= !empty($input['idCanal']) ? ' AND ca.idCanal = '.$input['idCanal'] : '';
		
		


		if (!empty($input['idEncuesta'])) $filtros .= " AND ve.idEncuesta IN ( " . $input['idEncuesta']. ')';

		if (!empty($input['elementos_det'])) $filtros .= " AND v.idVisita IN (  ".$input['elementos_det']." )";

		$sql = "
		DECLARE @fecIni DATE='" . $fechas[0] . "',@fecFin DATE='" . $fechas[1] . "';
			SELECT
			DISTINCT
				v.idVisita,ve.idEncuesta,vf.idVisitaFoto,vf.fotoUrl imgRef,
				ep.idPregunta,
				ep.idTipoPregunta,
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
			
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1 
			
			JOIN trade.usuario_historico uh ON uh.idUsuario=r.idUsuario
			JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta 
			LEFT JOIN trade.banner bn ON bn.idBanner=v.idBanner

			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=r.idUsuario
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado

			WHERE r.estado=1 AND v.estado=1  AND r.demo=0
			
			AND r.fecha between @fecIni AND @fecFin 
		$filtros
		";
		return $this->db->query($sql);
	}

	public function query_visitaEncuestaDetPdf($input)
	{

		$fechas = getFechasDRP($input["txt-fechas"]);

		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta = '.$input['idCuenta'] : '';
		$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
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

			WHERE r.estado=1 AND v.estado=1  AND r.demo=0
			
			AND r.fecha between @fecIni AND @fecFin 
		$filtros
		";

		
		return $this->db->query($sql);
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

			WHERE r.fecha between @fecIni AND @fecFin AND r.demo=0
				AND r.estado=1 AND v.estado=1
				{$filtros}
				{$orderby}
		";
	
		return $this->db->query($sql);
	}

	
}
