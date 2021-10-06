<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_premiaciones extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function query($sql){
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_premiacionesvisita($input=array()){
		$filtros = "";

		$externo = $this->flag_externo;
		$proyecto = $this->sessIdProyecto;
		(!empty($input['idPremiacion'])) ? $filtros .= " AND vp.idPremiacion = ".$input['idPremiacion'] : "";
		(!empty($input['idGrupoCanal'])) ? $filtros .= " AND gc.idGrupoCanal = ".$input['idGrupoCanal'] : "";
		(!empty($input['idCanal'])) ? $filtros .= " AND ca.idCanal = ".$input['idCanal'] : "";

		!empty($externo) ? $filtros.= " AND vp.estado = 1": '';

		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}
		$segmentacion = getSegmentacion(['grupoCanal_filtro'=>$input['idGrupoCanal']]);

		$sql = "
			DECLARE
				  @fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			SELECT 
				  gc.idGrupoCanal
				, gc.nombre grupoCanal
				, ca.nombre canal

				, v.idCliente
				, v.razonSocial
				, r.idUsuario
				, r.nombreUsuario
				, r.tipoUsuario
				, c.codCliente
				, c.codDist
				, CONVERT(VARCHAR,r.fecha,103) fecha
				, CONVERT(VARCHAR,vp.hora,108) hora
				, v.latIni
				, v.lonIni
				, vf.fotoUrl
				, p.idPremiacion
				, p.nombre premiacion
				, tp.idTipoPremiacion
				, tp.descripcion tipoPremiacion
				, vp.codigo
				, vp.monto
				, vp.premiado

				,vp.idVisitaPremiacion
				,vp.estado
				,vp.latitud as latitud_visita
				,vp.longitud as longitud_visita
				,ch.latitud as latitud_cliente
				,ch.longitud as longitud_cliente
				{$segmentacion['columnas_bd']}

			FROM 
				trade.data_visitaPremiacion vp
				LEFT JOIN trade.data_visita v
					ON v.idVisita = vp.idVisita
				LEFT JOIN trade.data_ruta r
					ON r.idRuta = v.idRuta
				JOIN trade.cliente c 
					ON c.idCliente = v.idCliente
				LEFT JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = v.idCliente
					AND General.dbo.fn_fechavigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
					AND ch.idProyecto={$proyecto}
				LEFT JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				LEFT JOIN trade.canal ca
					ON ca.idCanal = v.idCanal
				LEFT JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
				LEFT JOIN trade.data_visitaFotos vf
					ON vf.idVisitaFoto = vp.idVisitaFoto
				LEFT JOIN trade.premiacion p
					ON p.idPremiacion = vp.idPremiacion
				LEFT JOIN trade.tipo_premiacion tp
					ON tp.idTipoPremiacion = vp.idTipoPremiacion
				LEFT JOIN trade.subCanal subca ON subca.idSubCanal = sn.idSubcanal
				{$segmentacion['join']}

			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			{$filtro_demo}
			AND r.estado = 1 
			AND v.estado = 1{$filtros}
		";

		return $this->query($sql);
	}

	public function actualizarEstado($params = [])
	{
		$update = [
			'estado' => $params['status']
		];

		$this->db->where('idVisitaPremiacion', $params['id']);
		$this->db->update('trade.data_visitaPremiacion', $update);

		if ($this->db->affected_rows() != 1) {
			return false;
		} else {
			return true;
		}
	}

	public function obtener_premiaciones(){
		$result = [];
		$sql = "
		SELECT
			idPremiacion
			, nombre
			, CONVERT(VARCHAR,fechaInicio,103) AS fecIni
			, CONVERT(VARCHAR,fechaCaducidad,103) AS fecFin
		FROM trade.premiacion
		WHERE fechaCaducidad IS NOT NULL
		";
		$result['datos'] = $this->db->query($sql)->result_array();

		return $result;
	}

	public function obtener_premiaciones_cargos($params = []){
		$result = [];
		$filtros = "";
		(!empty($params['idPremiacion'])) ? $filtros .= " AND pc.idPremiacion = ".$params['idPremiacion'] : "";
		$sql = "
		SELECT
			pc.idCargo
			, UPPER(gc.nombre) AS grupoCanal
			, UPPER(p.nombre) AS plaza
			, UPPER(d.nombre) AS distribuidora
			, pc.foto
		FROM trade.data_visitaPremiacionCargo pc
		JOIN trade.canal gc ON pc.idGrupoCanal = gc.idCanal
		LEFT JOIN trade.plaza p ON pc.idPlaza = p.idPlaza
		LEFT JOIN trade.distribuidora d ON pc.idDistribuidora = d.idDistribuidora
		WHERE 1 = 1{$filtros}
		";

		$result['datos'] = $this->db->query($sql)->result_array();

		return $result;
	}

	public function get_grupoCanal($input = array()){
		$idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

		$filtro = "";
			$filtro .= getPermisos('grupoCanal', $idProyecto);

		$sql = "SELECT gca.idGrupoCanal AS id, gca.nombre AS value FROM trade.grupoCanal gca WHERE gca.estado = 1{$filtro} ORDER BY gca.nombre";
		return $this->db->query($sql)->result_array();
	}

	public function get_canal($input = array()){
		$idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

		$filtro = "";
			$filtro .= getPermisos('canal', $idProyecto);

		$sql = "SELECT ca.idCanal AS id, ca.nombre AS value, ca.idGrupoCanal FROM trade.canal ca WHERE ca.estado = 1{$filtro} ORDER BY ca.nombre";
		return $this->db->query($sql)->result_array();
	}

	public function get_plaza($input = array()){
		$idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

		$filtro = "";
			$filtro .= getPermisos('plaza', $idProyecto);

		$sql = "SELECT pl.idPlaza AS id, pl.nombre AS value FROM trade.plaza pl WHERE pl.estado = 1 AND pl.flagMayorista = 1{$filtro} ORDER BY pl.nombre";
		return $this->db->query($sql)->result_array();
	}

	public function get_distribuidora($input = array()){
		$idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

		$filtro = "";
			$filtro .= getPermisos('distribuidora', $idProyecto);

		$sql = "SELECT d.idDistribuidora AS id, d.nombre AS value FROM trade.distribuidora d WHERE d.estado = 1{$filtro} ORDER BY d.nombre";
		return $this->db->query($sql)->result_array();
	}

	public function insertarCargosPremiacion($params = []){
		$result = [];

		$this->db->trans_begin();

		$insert = [
			'idPremiacion' => $params['idPremiacion'],
			'idGrupoCanal' => $params['idCanal'],
			'idPlaza' => (!empty($params['idPlaza']) ? $params['idPlaza'] : NULL),
			'idDistribuidora' => (!empty($params['idDistribuidora']) ? $params['idDistribuidora'] : NULL),
			'foto' => $params['foto']
		];
		$query = $this->db->insert('trade.data_visitaPremiacionCargo', $insert);
		$result['id'] = $this->db->insert_id();

		if ($this->db->trans_status() === FALSE || !$query) {
			$this->db->trans_rollback();
			$result['status'] = 0;
		} else {
			$this->db->trans_commit();
			$result['status'] = 1;
		}

		return $result;
	}

	public function eliminar_cargo($params = []){
		$result = [];

		$this->db->trans_begin();

		$this->db->where('idCargo', $params['idCargo']);
		$this->db->delete('trade.data_visitaPremiacionCargo');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result['status'] = 0;
		} else {
			$this->db->trans_commit();
			$result['status'] = 1;
		}

		return $result;
	}

	public function obtener_premiaciones_objetivos($params = [])
	{
		$result = [];
		$filtros = "";
		(!empty($params['idPremiacion'])) ? $filtros .= " AND po.idPremiacion = " . $params['idPremiacion'] : "";
		(!empty($params['idObjetivo'])) ? $filtros .= " AND po.idObjetivo = " . $params['idObjetivo'] : "";
		$sql = "
		SELECT
			po.idObjetivo
			, UPPER(gc.nombre) AS grupoCanal
			, c.idCliente
			, UPPER(c.razonSocial) AS cliente
			, po.estado
			, po.comentario
		FROM trade.data_visitaPremiacionObjetivo po
		JOIN trade.canal gc ON po.idGrupoCanal = gc.idCanal
		JOIN trade.cliente c ON po.idCliente = c.idCliente
		WHERE 1 = 1{$filtros}
		";

		$result['datos'] = $this->db->query($sql)->result_array();

		return $result;
	}

	public function get_cliente($input = array())
	{
		$result = [];
		$idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;
		$idCuenta = !empty($input['idCuenta']) ? $input['idCuenta'] : 0;

		$sql = "
		DECLARE @fecha DATE = GETDATE();
		SELECT
		c.idCliente AS id
		, c.razonSocial AS value
		FROM trade.cliente c
		JOIN ".getClienteHistoricoCuenta()." ch ON c.idCliente = ch.idCliente
		AND @fecha BETWEEN ch.fecIni and ISNULL(ch.fecFin,@fecha) AND ch.estado=1
		WHERE ch.idCuenta = ? AND ch.idProyecto = ?
		";

		$result['datos'] = $this->db->query($sql, ['idCuenta' => $idCuenta, 'idProyecto' => $idProyecto])->result_array();

		return $result;
	}

	public function insertarMasivoObjetivos($params = [])
	{
		$result = [];
		
		$result['insert'] = $this->db->insert_batch('trade.data_visitaPremiacionObjetivo', array_unique($params, SORT_REGULAR));

		return $result;
	}

	public function actualizar_objetivos_estado($params = []){
		$result = [];

		$this->db->trans_begin();

		$update = [
			'estado' => $params['sel_formestado'],
			'comentario' => $params['txt_comentario']
		];

		$this->db->where('idObjetivo', $params['idObjetivo_formestado']);
		$this->db->update('trade.data_visitaPremiacionObjetivo', $update);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result['status'] = false;
		} else {
			$this->db->trans_commit();
			$result['status'] = true;
		}

		return $result;
	}
	
}
?>