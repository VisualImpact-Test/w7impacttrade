<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_info extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.live_tipoInfo', 'id' => 'idInfo'],
			'lista' => ['tabla' => 'trade.live_clienteInfo', 'id' => 'idClienteInfo'],
			'listaDet' => ['tabla'=>'trade.list_visibilidadTradDet','id'=>'idListVisibilidadDet'],
			'tipoElemento' => ['tabla'=>'trade.tipoElementoVisibilidadTrad','id'=>'idTipoElementoVis'],
		
			
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
		if(!empty($post['cuenta']))$filtros .= " AND c.idCuenta=".$post['cuenta'];
		$sql = "
                SELECT 
				p.*
				,c.nombre cuenta
                FROM
				".$this->tablas['elemento']['tabla']." p
				JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
                {$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function getTiposElemento($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['tipo'])) $filtros .= " AND ".$this->tablas['tipoElemento']['id']." = " . $post['tipo'];
		}

		$sql = "
                SELECT *
                FROM
                ".$this->tablas['tipoElemento']['tabla']." t
				$filtros
				
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['tipoElemento']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function registrarElemento($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
			'idCuenta' =>trim($post['cuenta']),
            
        ];

		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarElemento($post)
	{

		$update = [
			'nombre' => trim($post['nombre']),
			'idCuenta' =>trim($post['cuenta']),
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

	public function registrarLista($post)
	{

		$insert = [
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'idGrupoCanal' =>trim($post['grupoCanal']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['cliente'])){$insert['idCliente']=$post['cliente'];}
		if(!empty($post['canal'])){$insert['idCanal']= trim($post['canal']);}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
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

			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $this->insertId ];
		}else{
			$insert = false;
		}

		return $insert;
	}

	public function actualizarLista($post)
	{
		$update = [
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		if(!empty($post['canal'])){$update['idCanal']= trim($post['canal']);}
		if(!empty($post['Cliente'])){$update['idCanal']= trim($post['canal']);}

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idlst'] ];
		return $update;
	}

	public function actualizarMasivoLista($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['lista']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['lista']['tabla'], $input, $this->model->tablas['listaDet']['id']);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->model->tablas['lista']['tabla'], 'id' => null ];
		return $update;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista, $post)
	{

		//Pasar a la vista
		$new_array = array();
        $repetidos = false;
        $insert ='repetido';

		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->model->tablas['lista']['tabla'],array($this->model->tablas['lista']['id']=>$idLista,$this->model->tablas['elemento']['id']=>$row['elemento_lista']))->row_array();
			if(count($rs) > 0){
				$repetidos = true;

            }
            
        }
		$elementos =  count($new_array);
		if($elementos > 0){
           
			if($elementos != count(array_unique($new_array))){
				$repetidos = true;
			}
        }
        
		if(!$repetidos){

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {
					$input[] = [
						'idCliente'=> $idLista,
						$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
						"valor"=>$value['valor'],
						"fecIni"=>$value['fechaInicio'],
					];
					if(!empty($post['fechaFin'])){$input['fecFin']=$post['fechaFin'];}

				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['lista']['tabla'], $input);
			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['lista']['tabla'], 'id' => null ];
		}

		return $insert;
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
			* 
			FROM trade.cliente 
			WHERE estado = 1 
			AND idCliente 
			IN (SELECT 
					idCliente 
					FROM 
					trade.live_clienteInfo where estado = 1)
				
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente', 'id' => null ];
		return $this->db->query($sql);
	}

	
	public function getListaElementos($post)
	{
	
		$sql = "
		SELECT 
		ti.*,
		t.razonSocial,
		i.nombre,
		c.nombre canal
		FROM trade.live_clienteInfo ti
		JOIN trade.cliente t 
		ON t.idCliente = ti.idCliente
		JOIN ".getClienteHistoricoCuenta()." ch
		ON ch.idCliente = t.idCliente
		JOIN trade.live_tipoInfo i
		ON i.idInfo = ti.idInfo
		JOIN trade.canal c
		ON c.idCanal = ch.idSegNegocio
		WHERE t.idCliente = {$post['id']}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.live_clienteInfo', 'id' => null ];
		return $this->db->query($sql);
	}


	public function getClientes($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.estado=1 AND c.idCliente = " . $post['id'];
		}

		$sql = "
			SELECT TOP 500
			c.idCliente
			,c.razonSocial
			FROM trade.cliente c
			{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente', 'id' => null ];
		return $this->db->query($sql);
    }
    
	public function getCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.idCanal = " . $post['id'];
		}

		$sql = "
				SELECT c.*, 
					gc.nombre grupoCanal
				FROM trade.canal c
					INNER JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal', 'id' => null ];
		return $this->db->query($sql);
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
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto', 'id' => null ];
		return $this->db->query($sql);
	}

	public function getGrupoCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idGrupoCanal = " . $post['id'];
		}

		$sql = "
				SELECT *
				FROM trade.grupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal', 'id' => null ];
		return $this->db->query($sql);
	}
	public function getCanalesHT($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idGrupoCanal = " . $post['id'];
		}

		$sql = "
				SELECT *
				FROM trade.canal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal', 'id' => null ];
		return $this->db->query($sql);
	}
	public function guardarMasivoLista_HT($listas)
	{
		$input = [];
		foreach ($listas as $key => $value) {
			$input[$key] = [
				'nombre' => $value['nombre'],
				'idCuenta' => $value['idCuenta'],
				'fecIni' => date_change_format_bd($value['fechaInicio']),
				'fecFin' => date_change_format_bd($value['fechaFin'])
			];
		}

		$insert = $this->db->insert_batch($this->tablas['proyecto']['tabla'], $input);
		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['proyecto']['tabla'], 'id' => null ];
		return $insert;
	}

	public function registrarLista_HT($post)
	{

		$insert = [
			'idCliente' => trim($post['idCliente']),
			'FecIni' => trim($post['fechaInicio']),
			'idInfo' =>trim($post['idInfo']),
			'valor' =>trim($post['valor'])
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta', 'id' => null ];
		return $this->db->query($sql);
	}

}
