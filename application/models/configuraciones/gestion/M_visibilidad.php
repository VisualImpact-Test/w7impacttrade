<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_visibilidad extends My_Model
{

	var $CI;
	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.producto_categoria', 'id' => 'idCategoria'],
			'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidad", 'id' => 'idListVisibilidad'],
			'listaDet' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_visibilidadDet",'id'=>'idListVisibilidadDet'],
			'marca' => ['tabla'=>'trade.producto_marca','id'=>'idMarca'],
		
			
		];

		$this->CI =& get_instance();
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT *
                FROM
                ".$this->tablas['elemento']['tabla']."
				$filtros
				
			";

		return $this->db->query($sql);
	}
	public function getMarcas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['marca'])) $filtros .= " AND ".$this->tablas['marca']['id']." = " . $post['marca'];
		}

		$sql = "
                SELECT *
                FROM
                trade.producto_marca
				$filtros
				
			";

		return $this->db->query($sql);
	}

	public function getIdEncuesta($encuesta){

		
		$sql = $this->db->get_where("{$this->sessBDCuenta}.trade.encuesta",array('nombre'=>$encuesta));
		
		return ($sql);

	}

	public function registrarElemento($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
		];


		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}
	public function registrarLista($post)
	{

		$insert = [
			'idCanal' => trim($post['canal']),
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['cliente'])){$insert['idCliente']=$post['cliente'];}


		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}
	
	public function registrarListaDetalle($idLista,$idEncuesta,$idMarca)
	{

		$insert = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento']['id'] => $idEncuesta,
		];
		$where = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento']['id'] => $idEncuesta,
			$this->tablas['marca']['id']=> $idMarca

		];

		$encuesta_repetida = $this->db->get_where($this->tablas['listaDet']['tabla'],$where)->row_array();
		// echo $this->db->last_query();
		if(count($encuesta_repetida)<1){
			$insert = $this->db->insert($this->tablas['listaDet']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();
		}else{
			$insert = false;
		}


		return $insert;
	}

	public function actualizarElemento($post)
	{

		$update = [
			'nombre' => trim($post['nombre']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['elemento']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento']['tabla'], $update);
		return $update;
	}

	public function actualizarLista($post)
	{
		
		$update = [
			'idCanal' => trim($post['canal']),
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);
		$delete = $this->db->delete($this->tablas['listaDet']['tabla'],$where);
		
		if($update && $delete){
			$update = 1;
		}else{
			$update = 0;
		}
		return $update;
	}

	public function checkNombreElementoRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['elemento']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['elemento']['tabla'], $where);
	}

	// SECCION LISTA
	public function getListas($post)
	{
		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['lista']['id']." = " . $post['id'];

		$sql = "
				SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.nombreComercial
				,cli.razonSocial
				,cli.codCliente
				FROM ".$this->tablas['lista']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				
				$filtros
			";

		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
	
		$sql = "
				SELECT 
				e.*,
				m.nombre marca
				FROM 
				".$this->tablas['elemento']['tabla']." e
				JOIN ".$this->tablas['listaDet']['tabla']." lstd ON lstd.".$this->tablas['elemento']['id']." = e.".$this->tablas['elemento']['id']."
				JOIN trade.producto_marca m ON lstd.idMarca = m.idMarca 
				WHERE lstd.".$this->tablas['lista']['id']." = ".$post['id'].";
			";
		return $this->db->query($sql);
	}

	public function registrarProyecto($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['encuesta']),
			'fecIni' => trim($post['fechaInicio']),
			'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
		];

		$insert = $this->db->insert($this->tablas['proyecto']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarProyecto($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['encuesta']),
			'fecIni' => trim($post['fechaInicio']),
			'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['proyecto']['id'] => $post['idProyecto']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['proyecto']['tabla'], $update);
		return $update;
	}

	public function getCuentas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idCuenta = " . $post['id'];
		}

		$sql = "
				SELECT 
				* 
				FROM
				trade.cuenta
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function getClientes($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idCuenta = " . $post['id'];
		}

		$sql = "
				SELECT 
				* 
				FROM
				trade.cliente
				$filtros
			";

		return $this->db->query($sql);
	}


}
