<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_encuestas extends MY_Model
{
	var $resultado = [
		'query' => '',
		'estado' => false,
		'id' => null,
		'msg' => ''
	];

	public function __construct()
	{
		parent::__construct();
	}

	public function getTiposDePregunta()
	{
		$sql = "
			SELECT
			*
			FROM master.tipoPregunta;
		";

		$query = $this->db->query($sql);

		if ($query) {
			$this->resultado['query'] = $query;
			$this->resultado['estado'] = true;
		}

		return $this->resultado;
	}

	public function getEncuestasActivas($params = [])
	{
		$filtros = "";
		$filtros .= !empty($params['idCuenta']) ? ' AND e.idCuenta = ' . $params['idCuenta'] : '';

		$sql = "
			SELECT DISTINCT 
				e.idEncuesta, 
				e.nombre 'encuesta'
			FROM {$this->sessBDCuenta}.trade.list_encuesta le
				JOIN {$this->sessBDCuenta}.trade.list_encuestaDet led ON le.idListEncuesta = led.idListEncuesta
				JOIN {$this->sessBDCuenta}.trade.encuesta e ON led.idEncuesta = e.idEncuesta
			WHERE 1 = 1
				{$filtros}
			ORDER BY e.nombre;
		";

		$query = $this->db->query($sql);

		if ($query) {
			$this->resultado['query'] = $query;
			$this->resultado['estado'] = true;
		}

		return $this->resultado;
	}

	public function getCantidadFotosPorEncuesta($params = [])
	{
		$filtros = "";
		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta = ' . $this->sessIdCuenta : '';
		$filtros .= !empty($params['idProyecto']) ? ' AND r.idProyecto = ' . $this->sessIdProyecto : '';

		$filtros .= !empty($params['idGrupoCanal']) ? ' AND ca.idGrupoCanal = ' . $params['idGrupoCanal'] : '';
		$filtros .= !empty($params['idCanal']) ? ' AND ca.idCanal = ' . $params['idCanal'] : '';
		$filtros .= !empty($params['distribuidora_filtro']) ? ' AND d.idDistribuidora=' . $params['distribuidora_filtro'] : '';
		$filtros .= !empty($params['zona_filtro']) ? ' AND z.idZona=' . $params['zona_filtro'] : '';
		$filtros .= !empty($params['plaza_filtro']) ? ' AND pl.idPlaza=' . $params['plaza_filtro'] : '';
		$filtros .= !empty($params['cadena_filtro']) ? ' AND cad.idCadena=' . $params['cadena_filtro'] : '';
		$filtros .= !empty($params['banner_filtro']) ? ' AND ba.idBanner=' . $params['banner_filtro'] : '';

		$filtros .= !empty($params['idEncuesta']) ? " AND ve.idEncuesta IN ( " . $params['idEncuesta'] . ')' : '';

		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $params['idGrupoCanal']]);

		$sql = "
			DECLARE @fecIni DATE='{$params['fecIni']}',@fecFin DATE='{$params['fecFin']}';
			/* LISTA PARA OBTENER LAS FOTOS */
			WITH listaEncuestas AS
			(
				SELECT DISTINCT
					/* VISITA */
					v.idVisita
					, CONVERT(varchar,r.fecha,103) fecha
					, ve.idVisitaEncuesta
					, ve.idEncuesta
					, e.nombre encuesta
					/* USUARIO */
					, u.idUsuario
					, u.nombres + ' ' + u.apePaterno +  ' ' + u.apeMaterno AS usuario
					, ut.nombre AS tipoUsuario
					/* CLIENTE */
					, v.idCliente
					, c.codCliente
					, c.codDist
					, c.razonSocial
					, ca.nombre AS canal
					, gca.nombre AS grupoCanal
					/* FOTOS */
					, ve.flagFotoMultiple
					, vf.idVisitaFoto
					, vf.fotoUrl AS foto
					/* SEGMENTACION */
					{$segmentacion['columnas_bd']}
				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
				JOIN trade.cliente c ON v.idCliente = c.idCliente
				JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON ch.idCliente = c.idCliente
					AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha)
				LEFT JOIN trade.usuario u ON r.idUsuario = u.idUsuario
				LEFT JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
					AND r.fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,r.fecha)
				LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
				JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita = ve.idVisita
				JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ve.idVisitaEncuesta = ved.idVisitaEncuesta
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaFotos vef ON ve.idVisitaEncuesta = vef.idVisitaEncuesta
				JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta = ve.idEncuesta
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto = vef.idVisitaFoto
				LEFT JOIN trade.canal ca ON v.idCanal = ca.idCanal
				LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal = gca.idGrupoCanal
				{$segmentacion['join']}
				WHERE r.estado = 1 AND v.estado = 1
					AND r.fecha between @fecIni AND @fecFin
					{$filtros}
			)
			/* OBTENCION DE CANTIDAD DE FOTOS */
			--Se separa el query para realizar un conteo de fotos correcto.--
			SELECT DISTINCT
				/* VISITA */
				le.idVisita
				, le.fecha
				, le.idVisitaEncuesta
				, le.idEncuesta
				, le.encuesta
				/* USUARIO */
				, le.idUsuario
				, le.usuario
				, le.tipoUsuario
				/* CLIENTE */
				, le.idCliente
				, le.codCliente
				, le.codDist
				, le.razonSocial
				, le.canal
				, le.grupoCanal
				/* CANTIDAD DE FOTOS */
				, le.flagFotoMultiple
				, COUNT(le.idVisitaFoto) OVER (PARTITION BY le.idVisita) AS cantidadFotos
				/* SEGMENTACION */
				," . implode(',', $segmentacion['arreglo_columnas']) . "
			FROM listaEncuestas le
		";

		$query = $this->db->query($sql);

		if ($query) {
			$this->resultado['query'] = $query;
			$this->resultado['estado'] = true;
		}

		return $this->resultado;
	}

	public function getFotosPorEncuesta($params = [])
	{
		$sql = "
			SELECT
				vf.idVisita
				, vf.idVisitaFoto
				, vf.fotoUrl
				, vf.hora
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuesta ve
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaFotos vef ON ve.idVisitaEncuesta = vef.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vef.idVisitaFoto = vf.idVisitaFoto
			WHERE ve.idVisita = {$params['idVisita']}
		";

		$query = $this->db->query($sql);

		if ($query) {
			$this->resultado['query'] = $query;
			$this->resultado['estado'] = true;
		}

		return $this->resultado;
	}

	public function getTotalFotosPorEncuesta($params = [])
	{
		$filtros = "";
		$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta = ' . $this->sessIdCuenta : '';
		$filtros .= !empty($params['idProyecto']) ? ' AND r.idProyecto = ' . $this->sessIdProyecto : '';
		$filtros .= !empty($params['idEncuesta']) ? ' AND ve.idEncuesta = ' . $params['idEncuesta'] : '';

		// $filtros .= !empty($params['idGrupoCanal']) ? ' AND ca.idGrupoCanal = ' . $params['idGrupoCanal'] : '';

		$sql = "
			DECLARE @fecIni DATE='{$params['fecIni']}',@fecFin DATE='{$params['fecFin']}';
			SELECT
				ve.idVisitaEncuesta
				, vf.idVisitaFoto
				, vf.fotoUrl
				, vf.hora
				, 'ENCUESTA' AS tipo
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita = ve.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaFotos vef ON ve.idVisitaEncuesta = vef.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vef.idVisitaFoto = vf.idVisitaFoto
			WHERE r.estado = 1 AND v.estado = 1
				AND r.fecha between @fecIni AND @fecFin
				{$filtros}
			UNION
			SELECT
				ve.idVisitaEncuesta
				, vf.idVisitaFoto
				, vf.fotoUrl
				, vf.hora
				, 'ALTERNATIVA' AS tipo
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita = ve.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved ON ve.idVisitaEncuesta = ved.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON ved.idVisitaFoto = vf.idVisitaFoto
			WHERE r.estado = 1 AND v.estado = 1
				AND r.fecha between @fecIni AND @fecFin
				{$filtros}
			UNION
			SELECT
				ve.idVisitaEncuesta
				, vf.idVisitaFoto
				, vf.fotoUrl
				, vf.hora
				, 'ENCUESTA' AS tipo
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita = ve.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON ve.idVisitaFoto = vf.idVisitaFoto
			WHERE r.estado = 1 AND v.estado = 1
				AND r.fecha between @fecIni AND @fecFin
				{$filtros}
			UNION
			SELECT
				ve.idVisitaEncuesta
				, vf.idVisitaFoto
				, vf.fotoUrl
				, vf.hora
				, 'PREGUNTA' AS tipo
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuesta ve ON v.idVisita = ve.idVisita
			JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDetFoto vedf ON ve.idVisitaEncuesta = vedf.idVisitaEncuesta
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vedf.idVisitaFoto = vf.idVisitaFoto
			WHERE r.estado = 1 AND v.estado = 1
				AND r.fecha between @fecIni AND @fecFin
				{$filtros}
		";

		$query = $this->db->query($sql);

		if ($query) {
			$this->resultado['query'] = $query;
			$this->resultado['estado'] = true;
		}

		return $this->resultado;
	}
}
