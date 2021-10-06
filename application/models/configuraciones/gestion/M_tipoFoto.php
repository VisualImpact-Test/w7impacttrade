<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tipoFoto extends My_Model
{
	var $aSessTrack = [];
	var $CI;

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'tipoFoto' => ['tabla' => 'trade.foto_tipo', 'id' => 'idTipoFoto'],
		];
		$this->CI =& get_instance();
	}


	public function actualizarMasivoTipoFoto($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_tipoFoto->tablas['tipoFoto']['id'] => $value['id']
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_tipoFoto->tablas['tipoFoto']['tabla'], $input, $this->m_tipoFoto->tablas['tipoFoto']['id']);
		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->m_tipoFoto->tablas['tipoFoto']['tabla'] ];
		return $update;
	}

	// SECCION ENCUESTAS
	public function getTipoFotos($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
		} else {
			if (!empty($post['id'])) $filtros .= " AND ft.".$this->tablas['tipoFoto']['id']." = " . $post['id'];
			if (!empty($post['cuenta'])) $filtros .= " AND p.idCuenta = " . $post['cuenta'];
			if (!empty($post['proyecto'])) $filtros .= " AND p.idProyecto = " . $post['proyecto'];
		}

		$sql = "
				select 
					ft.idTipoFoto,ft.nombre,ft.estado, p.nombre proyecto
					
				from ".$this->tablas['tipoFoto']['tabla']." ft
				JOIN trade.proyecto p ON p.idProyecto=ft.idProyecto
				where 1=1
				{$filtros} 
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['tipoFoto']['tabla'] ];
		return $this->db->query($sql);
	}

	public function getIdEncuesta($encuesta){
		$sql = $this->db->get_where('trade.encuesta',array('nombre'=>$encuesta));

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.encuesta' ];
		return ($sql);

	}

	public function registrarTipoFoto($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idProyecto' => trim($post['proyecto']) 
		];
		$insert = $this->db->insert($this->tablas['tipoFoto']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['tipoFoto']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function actualizarTipoFoto($post)
	{
		$update = [
			'nombre' => trim($post['nombre'])
		];

		$where = [
			$this->tablas['tipoFoto']['id'] => $post['idTipoFoto']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['tipoFoto']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['tipoFoto']['tabla'], 'id' => $post['idTipoFoto'] ];
		return $update;
	}


	public function checkNombreTipoFotoRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idTipoFoto'])) $where .= " AND " . $this->tablas['tipoFoto']['id'] . " != " . $post['idTipoFoto'];
		if (!empty($post['proyecto'])) $where .= " AND idProyecto = " . $post['proyecto'];
		return $this->verificarRepetido($this->tablas['tipoFoto']['tabla'], $where);
	}

	
	public function validar_elementos_unicos_HT($post){
		$elementos = array();

		foreach($post as $index => $value){
			$elementos[$index] = $value['nombre'];
		}

		if(count($elementos) != count(array_unique($elementos))){
			return false;
		}else{
			return true;
		}
	}

	public function registrar_elementos_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_tipoFoto->tablas['tipoFoto']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_tipoFoto->tablas['tipoFoto']['tabla'] ];
		return $insert;
	}
	



}
