<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_elementosVisibilidad extends My_Model{

	public function __construct(){
		parent::__construct();
	}

	public function obtener_elemento($idElemento){
		$sql="SELECT e.idElementoVis, e.nombre AS elemento, e.idTipoElementoVisibilidad
		, e.idCategoria, e.idProyecto, e.estado
		FROM trade.elementoVisibilidadTrad e
		WHERE 1=1 AND e.idElementoVis={$idElemento}";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_listado_tipoElementos(){
		$sql="SELECT te.idTipoElementoVis
		, te.nombre AS tipoElemento
		FROM trade.tipoElementoVisibilidadTrad te
		WHERE te.estado=1";

		return $this->db->query($sql)->result_array();		
	}

	public function obtener_lista_elementos($input=array()){
		$filtros = '';
		$filtros .= !empty($input['tipoElemento']) ? " AND t.idTipoElementoVis=".$input['tipoElemento'] : "";

		$sql="SELECT 
			evt.idElementoVis
			, evt.nombre AS elemento
			, evt.idTipoElementoVisibilidad, t.nombre AS tipoElemento
			, evt.idCategoria, pc.nombre AS categoria
			, CONVERT(VARCHAR,evt.fechaCreacion,103) AS fechaCreacion
			, CONVERT(VARCHAR,evt.fechaModificacion,103) AS fechaModificacion
			, evt.estado
		FROM trade.elementoVisibilidadTrad evt 
		JOIN trade.tipoElementoVisibilidadTrad t ON t.idTipoElementoVis = evt.idTipoElementoVisibilidad
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=evt.idCategoria
		WHERE 1=1 --AND evt.estado=1
		$filtros";

		return $this->db->query($sql)->result_array();
	}

	public function update_estado_elementoVisibilidad($where=array(),$params=array()){
		$table = 'trade.elementoVisibilidadTrad';

		$this->db->trans_begin();
		$this->db->where($where);

		$update = $this->db->update($table, $params );

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return $update;
	}

	public function obtener_lista_categoria(){
		$sql="SELECT pc.idCategoria, pc.nombre AS categoria 
		FROM trade.producto_categoria pc
		WHERE pc.estado=1";

		return $this->db->query($sql)->result_array();
	}

	public function insertar_elemento_visibilidad($input=array()){
		$table = 'trade.elementoVisibilidadTrad';
		$this->db->trans_begin();
		$insert = $this->db->insert($table, $input);

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $insert;
	}

	public function obtener_id_tipoElemento($elemento){
		$sql="SELECT idTipoElementoVis 
		FROM trade.tipoElementoVisibilidadTrad 
		WHERE nombre LIKE '{$elemento}'";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_categoria($categoria){
		$sql="SELECT idCategoria 
		FROM trade.producto_categoria 
		WHERE nombre LIKE '{$categoria}'";

		return $this->db->query($sql)->result_array();
	}

	/*==Visibilidad Auditoria==*/
	public function obtener_lista_auditoriaObligatoria($input=array()){
		$filtros = '';
		$filtros .= !empty($input['proyecto']) ? " AND p.idProyecto=".$input['proyecto'] : "";
		$filtros .= !empty($input['grupoCanal']) ? " AND gc.idGrupoCanal=".$input['grupoCanal'] : "";
		$filtros .= !empty($input['canal']) ? " AND c.idCanal=".$input['canal'] : "";

		$sql="DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		--------
		SELECT
			vo.idListVisibilidadObl
			, vo.idGrupoCanal, gc.nombre AS grupoCanal
			, vo.idCanal, cn.nombre AS canal
			, CONVERT(VARCHAR,vo.fecIni,103) AS fecIni
			, CONVERT(VARCHAR,vo.fecFin,103) AS fecFin
			, vo.idProyecto, p.nombre AS proyecto
			, vo.idCliente, c.nombreComercial AS cliente
			, CONVERT(VARCHAR,vo.fechaCreacion,103) AS fechaCreacion
			, vo.estado
		FROM {$this->sessBDCuenta}.trade.list_visibilidadTradObl vo
		LEFT JOIN trade.proyecto p ON p.idProyecto=vo.idProyecto
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=vo.idGrupoCanal
		LEFT JOIN trade.canal cn ON cn.idCanal=vo.idCanal
		LEFT JOIN trade.cliente c ON c.idCliente=vo.idCliente
		WHERE 1=1
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
		$filtros";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_auditoriaIniciativa($input=array()){
		$filtros = '';
		$filtros .= !empty($input['proyecto']) ? " AND p.idProyecto=".$input['proyecto'] : "";
		$filtros .= !empty($input['grupoCanal']) ? " AND gc.idGrupoCanal=".$input['grupoCanal'] : "";
		$filtros .= !empty($input['canal']) ? " AND c.idCanal=".$input['canal'] : "";

		$sql="DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		--------
		SELECT
			vi.idListVisibilidadIni
			, vi.idGrupoCanal, gc.nombre AS grupoCanal
			, vi.idCanal, cn.nombre AS canal
			, CONVERT(VARCHAR,vi.fecIni,103) AS fecIni
			, CONVERT(VARCHAR,vi.fecFin,103) AS fecFin
			, vi.idProyecto, p.nombre AS proyecto
			, vi.idCliente, c.nombreComercial AS cliente
			, CONVERT(VARCHAR,vi.fechaCreacion,103) AS fechaCreacion
			, vi.estado
		FROM {$this->sessBDCuenta}.trade.list_visibilidadTradIni vi
		LEFT JOIN trade.proyecto p ON p.idProyecto=vi.idProyecto
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=vi.idGrupoCanal
		LEFT JOIN trade.canal cn ON cn.idCanal=vi.idCanal
		LEFT JOIN trade.cliente c ON c.idCliente=vi.idCliente
		WHERE 1=1
			AND (
			vi.fecIni <= ISNULL( vi.fecFin, @fecFin)
				AND (
					vi.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( vi.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN vi.fecIni AND ISNULL( vi.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN vi.fecIni AND ISNULL( vi.fecFin, @fecFin )
				)
			)
		$filtros";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_auditoriaAdicional($input=array()){
		$filtros = '';
		$filtros .= !empty($input['proyecto']) ? " AND p.idProyecto=".$input['proyecto'] : "";
		$filtros .= !empty($input['grupoCanal']) ? " AND gc.idGrupoCanal=".$input['grupoCanal'] : "";
		$filtros .= !empty($input['canal']) ? " AND c.idCanal=".$input['canal'] : "";

		$sql="DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		--------
		SELECT
			va.idListVisibilidadAdc
			, va.idGrupoCanal, gc.nombre AS grupoCanal
			, va.idCanal, cn.nombre AS canal
			, CONVERT(VARCHAR,va.fecIni,103) AS fecIni
			, CONVERT(VARCHAR,va.fecFin,103) AS fecFin
			, va.idProyecto, p.nombre AS proyecto
			, va.idCliente, c.nombreComercial AS cliente
			, CONVERT(VARCHAR,va.fechaCreacion,103) AS fechaCreacion
			, va.estado
		FROM {$this->sessBDCuenta}.trade.list_visibilidadTradAdc va
		LEFT JOIN trade.proyecto p ON p.idProyecto=va.idProyecto
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=va.idGrupoCanal
		LEFT JOIN trade.canal cn ON cn.idCanal=va.idCanal
		LEFT JOIN trade.cliente c ON c.idCliente=va.idCliente
		WHERE 1=1
			AND (
			va.fecIni <= ISNULL( va.fecFin, @fecFin)
				AND (
					va.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( va.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN va.fecIni AND ISNULL( va.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN va.fecIni AND ISNULL( va.fecFin, @fecFin )
				)
			)
		$filtros";

		return $this->db->query($sql)->result_array();
	}

	public function update_lista_visibilidad($tabla,$where=array(),$params=array()){
		$table = $tabla;

		$this->db->trans_begin();
		$this->db->where($where);

		$update = $this->db->update($table, $params );

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return $update;
	}
}

?>