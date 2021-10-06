<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Gestores_ extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getDataDeUnaTabla($params)
	{
		if (isset($params['where']) && !empty($params['where'])) {
			foreach ($params['where'] as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		if (isset($params['fechas']) && !empty($params['fechas'])) {
			$this->db->where('fechaRegistro >=', $params['fechas'][0]);
			$this->db->where('fechaRegistro <=', $params['fechas'][1]);
		}

		return $this->db->get($params['tabla']);
	}

	public function actualizar($table, $input, $where)
	{
		$this->db->trans_begin();
		$this->db->where($where);
		$update = $this->db->update($table, $input);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $update;
	}

	public function verificarRepetido($tabla, $where)
	{
		$this->db->where($where);
		$incidencias = count($this->db->get($tabla)->result());

		if ($incidencias > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function guardar($table, $input)
	{
		$this->db->trans_begin();

		$insert = $this->db->insert($table, $input);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return $insert;
	}

	public function guardarMasivo($table, $input)
	{
		$this->db->trans_begin();

		$insert = $this->db->insert_batch($table, $input);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $insert;
	}

	public function borrarRegistros($table, $where)
	{
		$this->db->trans_begin();

		$this->db->where($where);
		$delete = $this->db->delete($table);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $delete;
	}
}
