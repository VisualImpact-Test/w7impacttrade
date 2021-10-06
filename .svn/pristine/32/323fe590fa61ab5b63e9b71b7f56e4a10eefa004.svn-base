<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_visibilidadtrad extends My_Model
{

	var $CI;

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.elementoVisibilidadTrad', 'id' => 'idElementoVis'],
			'lista' => ['tabla' => 'trade.list_visibilidadTrad', 'id' => 'idListVisibilidad'],
			'listaDet' => ['tabla'=>'trade.list_visibilidadTradDet','id'=>'idListVisibilidadDet'],
			'tipoElemento' => ['tabla'=>'trade.tipoElementoVisibilidadTrad','id'=>'idTipoElementoVis'],
		
			
		];

		$this->CI =& get_instance();
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
		if( $this->session->userdata('idProyecto')!=null ){
			$filtros .= " AND p.idProyecto = ".$this->session->userdata('idProyecto');
		}

		$sql = "
                SELECT top 100
                p.*
                FROM
                ".$this->tablas['elemento']['tabla']." p
                {$filtros} and p.idTipoElementoVisibilidad=1
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
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
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['tipoElemento']['tabla'] ];
		return $this->db->query($sql);
	}

	public function registrarElemento($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
			'FecIni' => trim($post['fechaInicio']),
            
        ];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['descripcion'])){$insert['descripcion']=$post['descripcion'];}

		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarElemento($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
        ];
		if(!empty($post['descripcion'])){$update['descripcion']=$post['descripcion'];}
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
        
		$where = [
			$this->tablas['elemento']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $post['idx'] ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
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

		if(count($encuesta_repetida)<1){
			$insert = $this->db->insert($this->tablas['listaDet']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();

			$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $this->insertId ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idlst'] ];
		return $update;
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->model->tablas['listaDet']['tabla'] ];
		return $update;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{

		//Pasar a la vista
		$new_array = array();
        $repetidos = false;
        $insert ='repetido';

		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->model->tablas['listaDet']['tabla'],array($this->model->tablas['lista']['id']=>$idLista,$this->model->tablas['elemento']['id']=>$row['elemento_lista']))->row_array();
			if($rs!=null){
				if(count($rs) > 0){
					$repetidos = true;
	
				}
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
						$this->model->tablas['lista']['id'] => $idLista,
						$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
						
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['listaDet']['tabla'], $input);
			$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['listaDet']['tabla'] ];
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
		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];
		/*=====*/
		$sql = "
				SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.nombreComercial
				,cli.razonSocial
                ,cli.codCliente
                ,gc.nombre grupoCanal
				FROM ".$this->tablas['lista']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
                LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
                LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla'] ];
		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
	
		$sql = "
				SELECT 
				e.*
				,lstd.".$this->model->tablas['listaDet']['id']."
				FROM 
				".$this->tablas['elemento']['tabla']." e
				JOIN ".$this->tablas['listaDet']['tabla']." lstd ON lstd.".$this->tablas['elemento']['id']." = e.".$this->tablas['elemento']['id']."
				WHERE lstd.".$this->tablas['lista']['id']." = ".$post['id'].";
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
		return $this->db->query($sql);
	}


	public function getClientes($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.estado=1 AND ch.idProyecto = " . $post['id'];
		}

		$sql = "
			SELECT 
			c.idCliente
			,c.razonSocial
			FROM trade.cliente c
			{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
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
		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['proyecto']['tabla'] ];
		return $insert;
	}

	public function registrarLista_HT($post)
	{

		$insert = [
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'idGrupoCanal' =>trim($post['idGrupoCanal']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}
		if(!empty($post['idCanal'])){$insert['idCanal']= trim($post['idCanal']);}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['proyecto']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}
	
	public function validar_filas_unicas_HT($post){
		$listas = array();
		foreach($post as $index => $value){
			$listas[$index] = $value['idLista'];
		}

		if(count($listas) != count(array_unique($listas))){
			return false;
		}else{
			return true;
		}

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
			{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}
	public function obtenerCanalCuenta($post){
		$filtros = "WHERE 1 = 1";
		//if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
		if (!empty($post['idCuenta'])) $filtros .= " AND ch.idCuenta= " . $post['idCuenta'];
		
		$sql ="
		SELECT DISTINCT
			ca.idCanal
			,ca.nombre
			,ch.idCuenta
		FROM 
			ImpactTrade_bd.trade.cliente_historico ch
			JOIN ImpactTrade_bd.trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN ImpactTrade_bd.trade.canal ca
				ON ca.idCanal=sn.idCanal 
		{$filtros}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente_historico' ];
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
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql);
	}

	public function getSegCliente($post){
		$filtro='';
		if(!empty($post['idCanal'])){
			$filtro.='AND seg.idCanal='.$post['idCanal'];
		}
		if(!empty($post['idProyecto'])){
			$filtro.='AND ch.idProyecto='.$post['idProyecto'];
		}
		if(!empty($post['idCuenta'])){
			$filtro.='AND ch.idCuenta='.$post['idCuenta'];
		}
		$sql = "
		SELECT 
			c.idCliente
			,c.razonSocial
		FROM trade.cliente c
		JOIN trade.cliente_historico ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 {$filtro}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}
}
