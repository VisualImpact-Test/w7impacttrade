<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_horario extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.horarios', 'id' => 'idHorario'],
			
		];
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
		}
		$sql = "
                SELECT 
				e.idHorario,
                CONVERT(VARCHAR,e.horaIni,108) horaIni,
                CONVERT(VARCHAR,e.horaFin,108) horaFin,
                e.estado,
                e.fechaModificacion,
                e.fechaRegistro
                FROM
				".$this->tablas['elemento']['tabla']." e
                {$filtros}
				ORDER BY e.idHorario DESC
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}


	public function registrarElemento($post)
	{
		$insert = [
            'horaIni' => trim($post['horaIni']),
			'horaFin' =>trim($post['horaFin']),
			'idCuenta' => $this->sessIdCuenta,
            
        ];

		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarElemento($post)
	{

		$update = [
            'horaIni' => trim($post['horaIni']),
			'horaFin' =>trim($post['horaFin']),
			'fechaModificacion' => getActualDateTime(),
        ];
        
		$where = [
			$this->tablas['elemento']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

	public function checkHorarioRepetido($post)
	{
		$where = "horaIni = '" . trim($post['horaIni']) . "' AND horaFin = '".trim($post['horaFin'])."'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['elemento']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['elemento']['tabla'], $where);
	}

	public function registroMasivoHorarios($insert){

		return $this->db->insert_batch("trade.horarios",$insert);
	}


}
