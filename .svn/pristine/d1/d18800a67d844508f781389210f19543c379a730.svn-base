<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Carpetas extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			// 'archivos' => ['tabla' => 'trade.gestorArchivos_archivo', 'id' => 'idArchivo'],
			'carpetas' => ['tabla' => 'trade.gestorArchivos_carpeta', 'id' => 'idCarpeta'],
		];
	}

	public function getGrupos()
	{	
		$filtros = "";
		$idCuenta = $this->sessIdCuenta;
		!empty($idCuenta) ? $filtros .= " AND idCuenta = {$idCuenta}": '' ;
		
		$sql = "
			SELECT *
			FROM trade.gestorArchivos_grupo
			WHERE estado = 1
			{$filtros}
			ORDER BY orden ASC;
		";

		return $this->db->query($sql);
	}

	public function getCarpetas($post)
	{
		$idCuenta = $this->sessIdCuenta;
		$filtros = " WHERE 1 = 1";
		if (!empty($post['grupoFiltro'])) $filtros .= " AND g.idGrupo = " . $post['grupoFiltro'];
		if (!empty($post['id'])) $filtros .= " AND c.idCarpeta = " . $post['id'];

		!empty($idCuenta) ? $filtros .= " AND g.idCuenta = {$idCuenta}": '' ;

		$sql = "
			SELECT DISTINCT 
				g.orden, 
				c.idCarpeta, 
				c.idGrupo, 
				c.nombre nombreCarpeta, 
				c.estado, 
				g.nombre nombreGrupo, 
				SUM(a.peso) OVER(PARTITION BY c.idCarpeta) espacioOcupado,
				c.fechaCreacion,
				c.fechaModificacion
			FROM trade.gestorArchivos_carpeta c
				JOIN trade.gestorArchivos_grupo g ON c.idGrupo = g.idGrupo
				LEFT JOIN trade.gestorArchivos_archivo a ON c.idCarpeta = a.idCarpeta
			$filtros
			ORDER BY g.orden ASC, 
					c.idCarpeta;
		";

		return $this->db->query($sql);
	}

	public function registrarCarpeta($post)
	{
		$insert = [
			'idGrupo' => $post['grupo'],
			'nombre' => trim($post['carpeta']),
			'idUsuarioCreador' => $post['idUsuario'],
			'ipUsuarioCreador' => getIp(),
		];

		$insert = $this->db->insert($this->tablas['carpetas']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarCarpeta($post)
	{
		$update = [
			'nombre' => trim($post['carpeta']),
			'idUsuarioEditor' => $post['idUsuario'],
			'ipUsuarioEditor' => getIp(),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['carpetas']['id'] => $post['idCarpeta']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['carpetas']['tabla'], $update);
		return $update;
	}

	public function checkNombreCarpetaRepetida($post)
	{
		$where = "nombre = '" . trim($post['carpeta']) . "' AND idGrupo = " . $post['grupo'];
		if (!empty($post['idCarpeta'])) $where .= " AND " . $this->tablas['carpetas']['id'] . " != " . $post['idCarpeta'];
		return $this->verificarRepetido($this->tablas['carpetas']['tabla'], $where);
	}

}
