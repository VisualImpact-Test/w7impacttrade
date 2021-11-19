<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Reprogramacion extends MY_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'reprogramacion' => ['tabla' => "{$this->sessBDCuenta}.trade.data_visitaReprogramacion", 'id' => 'idVisitaReprogramacion'],
			'ruta' => ['tabla' => "{$this->sessBDCuenta}.trade.data_ruta", 'id' => 'idRuta'],
			'visita' => ['tabla' => "{$this->sessBDCuenta}.trade.data_visita", 'id' => 'idVisita'],
		];
	}

	public function getEstadosReprogramacion(){
		$sql = "
			SELECT *
			FROM trade.estadoReprogramacion
			WHERE estado = 1;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.estadoReprogramacion' ];
		return $this->db->query($sql);
	}

	public function getVisitasReprogramacion($post = [])
	{
		$filtros = " WHERE 1 = 1 ";
		$fechas = getFechasDRP($post['txt-fechas']);
		$primeraFecha = date_change_format_bd($fechas[0]);
		$ultimaFecha = date_change_format_bd($fechas[1]);
		$filtros .= " AND dr.fecha BETWEEN '" . $primeraFecha . "' AND '" . $ultimaFecha . "'";
		if (!empty($post['id'])){
			$filtros .= " AND dvr.idVisitaReprogramacion = " . $post['id'];
		} else{
			if (!empty($post['idCuentaFiltro'])) $filtros .= " AND dr.idCuenta = " . $post['idCuentaFiltro'];
			if (!empty($post['idProyectoFiltro'])) $filtros .= " AND dr.idProyecto = " . $post['idProyectoFiltro'];
			if (!empty($post['estadoReprogramacionFiltro'])){
				if($post["estadoReprogramacionFiltro"] == 100) $filtros .= " AND er.idEstadoReprogramacion IS NULL ";
				if($post["estadoReprogramacionFiltro"] != 100) $filtros .= " AND er.idEstadoReprogramacion = " . $post["estadoReprogramacionFiltro"];
			}
		}

		$sql = "
			SELECT c.idCliente,
				dvr.idVisitaReprogramacion,
				dvr.idVisita,
				c.razonSocial,
				c.direccion,
				ubi.distrito,
				ubi.provincia,
				ubi.departamento,
				dr.fecha,
				dr.idCuenta,
				dr.idProyecto,
				f.idFrecuencia,
				f.nombre frecuencia,
				utd.idTipoDocumento,
				utd.breve tipoDocumento,
				ut.idTipoUsuario,
				ut.nombre tipoUsuario,
				u.idUsuario,
				u.numDocumento,
				u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno nombreCompleto,
				dvr.hora,
				mr.idMotivoReprogramacion,
				mr.nombre motivoReprogramacion,
				dvr.observacion,
				dvr.fotoUrl,
				dr2.fecha fechaNueva,
				dvr.comentario,
				dvr.idEstadoReprogramacion,
				u2.nombres + ' ' + u2.apePaterno + ' ' + u2.apeMaterno nombreCompletoUsuarioReprogramo
			FROM {$this->sessBDCuenta}.trade.data_visitaReprogramacion dvr
				LEFT JOIN trade.motivo_reprogramacion mr ON mr.idMotivoReprogramacion = dvr.idMotivo
				LEFT JOIN trade.estadoReprogramacion er ON er.idEstadoReprogramacion = dvr.idEstadoReprogramacion
				INNER JOIN {$this->sessBDCuenta}.trade.data_visita dv ON dv.idVisita = dvr.idVisita
				INNER JOIN {$this->sessBDCuenta}.trade.data_ruta dr ON dr.idRuta = dv.idRuta
				INNER JOIN trade.usuario u ON u.idUsuario = dr.idUsuario
				INNER JOIN trade.usuario_tipoDocumento utd ON utd.idTipoDocumento = u.idTipoDocumento
				INNER JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = dr.idTipoUsuario
				INNER JOIN trade.cliente c ON c.idCliente = dv.idCliente
				INNER JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo = c.cod_ubigeo
				LEFT JOIN trade.frecuencia f ON f.idFrecuencia = dv.idFrecuencia
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visita dv2 ON dv2.idVisita = dvr.idNuevaVisita
				LEFT JOIN {$this->sessBDCuenta}.trade.data_ruta dr2 ON dr2.idRuta = dv2.idRuta
				LEFT JOIN trade.usuario u2 ON u2.idUsuario = dvr.idUsuarioReprogramo
			$filtros
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaReprogramacion" ];
		return $this->db->query($sql);
	}

	public function getVisitasDecliente($post)
	{
		$idCliente = $post['idCliente'];
		$idCuenta = $post['idCuenta'];
		$idProyecto = $post['idProyecto'];

		$sql = "
			DECLARE @primerDia DATE= DATEADD(mm, DATEDIFF(mm, 0, GETDATE()), 0), @ultimoDia DATE= DATEADD (dd, -1, DATEADD(mm, DATEDIFF(mm, 0, GETDATE()) + 2, 0));
			SELECT dr.fecha,
				dv.idVisita,
				dv.idCliente,
				dr.idCuenta,
				dr.idProyecto,
				dv.estado
			FROM {$this->sessBDCuenta}.trade.data_visita dv
				INNER JOIN {$this->sessBDCuenta}.trade.data_ruta dr ON dv.idRuta = dr.idRuta
			WHERE dv.idCliente = {$idCliente}
				AND dr.idCuenta = {$idCuenta}
				AND dr.idProyecto = {$idProyecto}
				AND dv.estado = 1
				AND dr.fecha BETWEEN @primerDia AND @ultimoDia;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql);
	}

	public function getRutasDeUsuario($post)
	{
		$idUsuario = $post['idUsuario'];
		$idCuenta = $post['idCuenta'];
		$idProyecto = $post['idProyecto'];

		$sql = "
			DECLARE @primerDia DATE= DATEADD(mm, DATEDIFF(mm, 0, GETDATE()), 0), @ultimoDia DATE= DATEADD(dd, -1, DATEADD(mm, DATEDIFF(mm, 0, GETDATE()) + 2, 0));
			WITH dateRange
				AS (SELECT TOP (DATEDIFF(DAY, @primerDia, @ultimoDia) + 1) Date = DATEADD(DAY, ROW_NUMBER() OVER(
																								ORDER BY a.object_id) - 1, @primerDia)
					FROM sys.all_objects a
						CROSS JOIN sys.all_objects b),
				rutas
				AS (SELECT dr.idRuta, 
							dr.fecha, 
							dr.idUsuario
					FROM {$this->sessBDCuenta}.trade.data_ruta dr
					WHERE dr.idUsuario = {$idUsuario}
						AND dr.idCuenta = {$idCuenta}
						AND dr.idProyecto = {$idProyecto}
						AND dr.fecha BETWEEN @primerDia AND @ultimoDia
						AND dr.estado = 1)
				SELECT dr.Date fecha, 
						r.idRuta, 
						r.idUsuario, 
						ROW_NUMBER() OVER(
						ORDER BY
				(
					SELECT 1
				)) AS columnaDiferencia
				FROM dateRange dr
					LEFT JOIN rutas r ON r.fecha = dr.Date;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}

	public function actualizarReprogramacion($post)
	{
		$update = [
			'idUsuarioReprogramo' => $post['idUsuarioReprogramo'],
			'comentario' => !empty($post['comentario']) ? trim($post['comentario']) : null,
			'idEstadoReprogramacion' => $post['estadoReprogramacion'],
			'idNuevaVisita' => !empty($post['idNuevaVisita']) ? $post['idNuevaVisita'] : null,
		];

		$where = [
			$this->tablas['reprogramacion']['id'] => $post['idVisitaReprogramacion']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['reprogramacion']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['reprogramacion']['tabla'], 'id' => $post['idVisitaReprogramacion'] ];
		return $update;
	}

	public function agregarNuevaRuta($post)
	{
		$rutaAntigua = $this->getRutaByIdVisita($post['idVisita'])->row_array();

		$insert = [
			'idUsuario' => $rutaAntigua['idUsuario'],
			'fecha' => date_change_format_bd($post['fechaReprogramacion']),
			'demo' => $rutaAntigua['demo'],
			'nombreUsuario' => $rutaAntigua['nombreUsuario'],
			'idTipoUsuario' => $rutaAntigua['idTipoUsuario'],
			'tipoUsuario' => $rutaAntigua['tipoUsuario'],
			'idCuenta' => $rutaAntigua['idCuenta'],
			'idProyecto' => $rutaAntigua['idProyecto'],
			'estado' => 1,
			'idEncargado' => $rutaAntigua['idEncargado'],
		];

		$insert = $this->db->insert($this->tablas['ruta']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['ruta']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function getRutaByIdVisita($idVisita)
	{
		$sql = "
			SELECT dr.*
			FROM {$this->sessBDCuenta}.trade.data_visita dv
				INNER JOIN {$this->sessBDCuenta}.trade.data_ruta dr ON dr.idRuta = dv.idRuta
			WHERE idVisita = {$idVisita}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql);
	}

	public function actualizarVisitaAntigua($post)
	{
		$update = [
			'estado' => 0,
		];

		$where = [
			$this->tablas['visita']['id'] => $post['idVisita']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['visita']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['visita']['tabla'], 'id' => $post['idVisita'] ];
		return $update;
	}

	public function insertVisita($post)
	{
		$visitaAntigua = $this->getVisitaById($post['idVisita'])->row_array();
		unset($visitaAntigua['idVisita']);
		$visitaAntigua['idRuta'] = $post['idRutaReprogramacion'];
		$visitaAntigua['estado'] = 1;

		$insert = $visitaAntigua;

		$insert = $this->db->insert($this->tablas['visita']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['visita']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function getVisitaById($idVisita)
	{
		$sql = "
			SELECT *
			FROM {$this->sessBDCuenta}.trade.data_visita
			WHERE idVisita = {$idVisita}
		";

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['visita']['tabla'], 'id' => $this->insertId ];
		return $this->db->query($sql);
	}

	public function getFechaActual()
	{
		$sql = "
			SELECT CAST(GETDATE() AS DATE) AS fechaActual
		";

		return $this->db->query($sql);
	}

	public function checkIfVisitaYaFueReprogramada($post)
	{
		$where = "idVisita = '" . $post['idVisita']  . "' AND idNuevaVisita IS NOT NULL";
		return $this->verificarRepetido($this->tablas['reprogramacion']['tabla'], $where);
	}

	public function checkRutaExistenteParaFechaUsuario($post)
	{
		$where = "idUsuario = '" . $post['idUsuarioReprogramacion']  . "' AND fecha = '" . $post['fechaReprogramacion'] . "'";
		if (!empty($post['idRutaReprogramacion'])) $where .= " AND " . $this->tablas['ruta']['id'] . " != " . $post['idRutaReprogramacion'];
		return $this->verificarRepetido($this->tablas['ruta']['tabla'], $where);
	}

	public function checkVisitaExistenteParaRutaCliente($post)
	{
		$where = "idRuta = '" . $post['idRutaReprogramacion']  . "' AND idCliente = " . $post['idClienteReprogramacion'];
		return $this->verificarRepetido($this->tablas['visita']['tabla'], $where);
	}
}
