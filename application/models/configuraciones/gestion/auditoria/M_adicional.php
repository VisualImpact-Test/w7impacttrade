<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_adicional extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.elementoVisibilidadTrad', 'id' => 'idElementoVis'],
			'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradAdc", 'id' => 'idListVisibilidadAdc'],
			'listaDet' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_visibilidadTradAdcDet",'id'=>'idListVisibilidadAdcDet'],
			'tipoElemento' => ['tabla'=>'trade.tipoElementoVisibilidadTrad','id'=>'idTipoElementoVis'],
		
			
		];
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1 ";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
		}
	
		if( $this->session->userdata('idProyecto')!=null ){
			$filtros .= " AND p.idProyecto = ".$this->session->userdata('idProyecto');
		}
		if(!empty($post['cuenta']))$filtros .= " AND py.idCuenta=".$post['cuenta'];

		$sql = "
                SELECT 
                p.*
                , t.nombre tipo
                , py.nombre AS proyecto
                FROM
                ".$this->tablas['elemento']['tabla']." p
                JOIN ".$this->tablas['tipoElemento']['tabla']." t ON t.".$this->tablas['tipoElemento']['id']." = p.idTipoElementoVisibilidad
                LEFT JOIN trade.proyecto py ON py.idProyecto=p.idProyecto
                {$filtros} and p.idTipoElementoVisibilidad=3
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['tipoElemento']['tabla'] ];
		return $this->db->query($sql);
	}

	public function getIdEncuesta($encuesta){
		$sql = $this->db->get_where("{$this->sessBDCuenta}.trade.encuesta",array('nombre'=>$encuesta));

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta" ];
		return ($sql);

	}

	public function registrarElemento($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
            $this->model->tablas['tipoElemento']['id'].'ibilidad' =>trim($post['tipo']),
        ];
        if( $this->session->userdata('idProyecto')!=null ){
			$insert["idProyecto"]=$this->session->userdata('idProyecto');
		}
 
		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarElemento($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
            $this->model->tablas['tipoElemento']['id'].'ibilidad' =>trim($post['tipo']),

        ];
        
		$where = [
			$this->tablas['elemento']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => arrayToString($where) ];
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
			'idGrupoCanal' => trim($post['grupoCanal']),
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

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => arrayToString($where) ];
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

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->model->tablas['listaDet']['tabla'] ];
		return $update;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{

		//Pasar a la vista
		$new_array = array();
		$repetidos = false;
		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->model->tablas['listaDet']['tabla'],array($this->model->tablas['lista']['id']=>$idLista,$this->model->tablas['elemento']['id']=>$row['elemento_lista']))->row_array();
			if(count($rs) >=1){
				$repetidos = true;

			}
		}
		$elementos =  count($new_array);

		if($elementos > 0){

			if($elementos != count(array_unique($new_array))){
				$repetidos = true;
			}
		}
			
		if($repetidos == false){

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
			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['listaDet']['tabla'] ];
		
		}else{
			$insert = 'repetido';
		}
		return $insert;
	}
	
	public function checkNombreElementoRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['elemento']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['elemento']['tabla'], $where);
	}

	public function obtener_lista_categoria(){
		$sql="SELECT pc.idCategoria, UPPER(pc.nombre) AS categoria 
		FROM trade.producto_categoria pc
		WHERE pc.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_categoria' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cuenta_proyecto($input=array()){
		$filtros='';
			$filtros.= !empty($input['listaCuentas']) ? " AND c.idCuenta IN (".$input['listaCuentas'].")":"";
			$filtros.= !empty($input['listaProyectos']) ? " AND p.idProyecto IN (".$input['listaProyectos'].")":"";
			$filtros.= !empty($input['proyectoNombre']) ? " AND p.nombre LIKE '".$input['proyectoNombre']."'":"";

		$sql="
		DECLARE @fecha DATE=GETDATE();
		SELECT
			c.idCuenta
			, UPPER(c.nombreComercial) AS cuenta
			, p.idProyecto
			, UPPER(p.nombre) AS proyecto
		FROM trade.cuenta c 
		JOIN trade.proyecto p ON p.idCuenta=c.idCuenta
		WHERE c.estado=1 AND p.estado=1
		AND @fecha BETWEEN p.fecIni AND ISNULL(p.fecFin,@fecha)
		{$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_categoria($categoria){
		$sql="SELECT idCategoria 
		FROM trade.producto_categoria 
		WHERE nombre LIKE '{$categoria}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_categoria' ];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_elemento_visibilidad($input=array()){
		$aSessTrack = [];

		$table = 'trade.elementoVisibilidadTrad';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	// SECCION LISTA
	public function getListas($post)
	{


		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['lista']['id']." = " . $post['id'];

		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];
		

		$sql = "
				SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.idCliente
				,cli.nombreComercial
				,cli.razonSocial
                ,cli.codCliente
                ,gc.nombre grupoCanal
				FROM ".$this->tablas['lista']['tabla']." lst
				LEFT JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
                LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
                LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla'] ];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
		return $this->db->query($sql);
	}


	public function getClientes($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.estado=1 AND ch.idProyecto = " . $post['id'];
		}

		$sql = "
			DECLARE @fecha DATE=GETDATE();
			SELECT --TOP 6000
			c.idCliente, c.razonSocial
			FROM trade.cliente c
			JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		return $this->db->query($sql);
	}

	public function getProyectos($post)
	{
		$filtros = " ";
		if (!empty($post['id'])) $filtros .= " AND idProyecto = " . $post['id'];
		if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario = " . $post['idUsuario'];

		$sql = "
				DECLARE @fecha date=getdate();
				select p.idProyecto,p.nombre AS proyecto
				from  trade.usuario_historico uh 
				JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
				where uh.estado=1 
				and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal' ];
		return $this->db->query($sql);
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

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
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
			{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}

	public function obtenerCanalCuenta($post){
		$filtros = "WHERE 1 = 1";
		//if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
		if (!empty($post['idCuenta'])) $filtros .= " AND ch.idCuenta= " . $post['idCuenta'];
		
		$sql ="
		SELECT DISTINCT
			gc.idGrupoCanal,
			gc.nombre as 'grupoCanal',
			ca.idCanal
			,ca.nombre
			,ch.idCuenta
		FROM 
			{$this->sessBDCuenta}.trade.cliente_historico ch
			JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN trade.canal ca
				ON ca.idCanal=sn.idCanal 
			JOIN trade.grupoCanal gc 
			    ON gc.idGrupoCanal=ca.idGrupoCanal
			{$filtros}
		ORDER BY gc.idGrupoCanal
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.cliente_historico" ];
		return $this->db->query($sql);
	}

	public function obtenerProyectos($post)
	{
		$filtros = "";
		if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
		if (!empty($post['idCuenta'])) $filtros .= " AND p.idCuenta= " . $post['idCuenta'];
		if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario= " . $post['idUsuario'];
		
		$sql = "
			DECLARE @fecha date=getdate();
			select p.idProyecto,p.nombre proyecto,
			c.idCuenta cuenta
			from  trade.usuario_historico uh 
			JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
			JOIN trade.cuenta c On c.idCuenta=p.idCuenta
			where uh.estado=1 
			and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
			{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
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
		JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 {$filtro}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio' ];
		return $this->db->query($sql);
	}

}
