<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_archivo extends My_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'lista' => ['tabla' => 'trade.archivo', 'id' => 'idArchivo'],
		];
	}
 
	public function registrarLista($post)
	{

		$insert = [
			'nombreArchivo' => trim($post['nombre']),
			'idProyecto' => trim($post['proyecto']),
			'urlArchivo' => trim($post['url']),
			'estado'=>1
		];

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}
	
	public function actualizarLista($post)
	{
		
		$update = [
			'idProyecto' => trim($post['proyecto']),
			'urlArchivo' => trim($post['url']),
			'nombreArchivo' => trim($post['nombre']),
		];

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);
	
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
		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];
		/*=====*/
		$sql = "
				select 
				lst.*,
				p.nombre 'proyecto', c.nombre 'cuenta',c.idCuenta
				from ".$this->tablas['lista']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto=lst.idProyecto
				JOIN trade.cuenta c ON c.idCuenta=p.idCuenta
				$filtros
			";

		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
	
		$sql = "
				SELECT 
				e.*
				FROM 
				".$this->tablas['elemento']['tabla']." e
				JOIN ".$this->tablas['listaDet']['tabla']." lstd ON lstd.".$this->tablas['elemento']['id']." = e.".$this->tablas['elemento']['id']."
				WHERE lstd.".$this->tablas['lista']['id']." = ".$post['id'].";
			";
		return $this->db->query($sql);
	}

	public function actualizarMasivoLista($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['listaDet']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['listaDet']['tabla'], $input, $this->model->tablas['listaDet']['id']);
		return $update;
	}
	 
	public function getProyectos($post)
	{
		$filtros = "WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND idProyecto = " . $post['id'];

		$sql = "
				SELECT p.*, 
					c.nombre cuenta
				FROM trade.proyecto p
					INNER JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				$filtros
			";

		return $this->db->query($sql);
	}

	public function registrarLista_HT($post)
	{

		$insert = [
			'nombreArchivo' => trim($post['nombre']),
			'urlArchivo' => trim($post['url']),
			'idProyecto' =>trim($post['idProyecto']),
		];

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}
	public function validar_elementos_unicos_HT($post){
		$elementos = array();

		foreach($post as $index => $value){
			$elementos[$index] = $value['promocion'];
		}

		if(count($elementos) != count(array_unique($elementos))){
			return false;
		}else{
			return true;
		}
	}
	public function registrar_elementos_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->model->tablas['elemento']['tabla'], $input);
		return $insert;
	}
	public function getCuentas($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.idCuenta = " . $post['id'];
			if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario = " . $post['idUsuario'];
		}

		$sql = "
			DECLARE @fecha date=getdate();
			select c.idCuenta,c.nombre from  trade.usuario_historico uh 
			JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
			JOIN trade.cuenta c On c.idCuenta=p.idCuenta
			where uh.estado=1 
			and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
		
				$filtros
			";

		return $this->db->query($sql);
	}

	public function obtenerProyectos($post)
	{
		$filtros = "WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
		if (!empty($post['idCuenta'])) $filtros .= " AND p.idCuenta= " . $post['idCuenta'];
		
		$sql = "
				SELECT p.idProyecto,p.nombre proyecto, 
					c.nombre cuenta
				FROM trade.proyecto p
					INNER JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				$filtros
			";

		return $this->db->query($sql);
	}
}
