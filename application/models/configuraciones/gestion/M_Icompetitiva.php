<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_icompetitiva extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.producto_categoria', 'id' => 'idCategoria'],
			'lista' => ['tabla' => 'trade.list_categoria_marca_competenciaTrad', 'id' => 'idListCategoriaMarcaComp'],
			'listaDet' => ['tabla'=>'trade.list_categoria_marca_competenciaTradDet','id'=>'idListCategoriaMarcaCompDet'],
			'tipoElemento' => ['tabla'=>'trade.competencia_tipo','id'=>'idTipoCompetencia'],
			
		];
	}

	/*Segmentacion Negocio*/
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
		JOIN ".getClienteHistoricoCuenta()." ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 {$filtro}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio' ];
		return $this->db->query($sql);
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
                FROM
                ".$this->tablas['elemento']['tabla']." p
				JOIN trade.list_categoria_marca cm ON cm.idCategoria = p.idCategoria AND cm.idProyecto = {$idProyecto}
                {$filtros}
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
		$sql = $this->db->get_where('trade.encuesta',array('nombre'=>$encuesta));

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.encuesta' ];
		return ($sql);

	}

	public function registrarElemento($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
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
		$idProyecto = $this->sessIdProyecto;
		$insert = [
			'idProyecto' => $idProyecto,
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
        
		// foreach($multiDataRefactorizada as $index => $row){
		// 	$new_array[] = $row['elemento_lista'];
		// 	$rs = $this->db->get_where($this->model->tablas['listaDet']['tabla'],array($this->model->tablas['lista']['id']=>$idLista,$this->model->tablas['elemento']['id']=>$row['elemento_lista']))->row_array();
		// 	if($rs!=null){
		// 		if(count($rs) > 0){
		// 			$repetidos = true;
	
		// 		}
		// 	}
		// }
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
					$input[$value['elemento_lista']] = [
						$this->model->tablas['lista']['id'] => $idLista,
						$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['listaDet']['tabla'], $input);
			$where = [
				'idListCategoriaMarcaComp' => $idLista,
			];

			$listDet = $this->db->get_where('trade.list_categoria_marca_competenciaTradDet',$where)->result_array(); 
			$lista = [];
			foreach($listDet as $r){
				$lista[$r['idCategoria']] = $r['idListCategoriaMarcaCompDet'];
			}

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {
					$input[$value['sl_marca']] = [
						'idListCategoriaMarcaCompDet' => $lista[$value['elemento_lista']],
						'idMarca' => $value['sl_marca'],
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch('trade.list_categoria_marca_competenciaTradDet_elemento', $input);
			$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->model->tablas['listaDet']['tabla'] ];
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

	// SECCION LISTA
	public function getListas($post)
	{
		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;


		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['lista']['id']." = " . $post['id'];

		/*Filtros */
		if(!empty($idProyecto))$filtros .= " AND p.idProyecto=".$idProyecto;
		if(!empty($post['sl_grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['sl_grupoCanal'];
		if(!empty($post['sl_canal']))$filtros .= " AND c.idCanal=".$post['sl_canal'];
		if(!empty($idCuenta))$filtros .= " AND p.idCuenta=".$idCuenta;
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
				,p.idCuenta
				,cu.nombre cuenta
				FROM ".$this->tablas['lista']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
                LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
                LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
	
		$sql = "
				SELECT 
				e.*
				,lstde.idMarca
				,m.nombre marca
				,lstde.idListCategoriaMarcaCompDetEle
				,lstd.".$this->model->tablas['listaDet']['id']."
				FROM 
				".$this->tablas['elemento']['tabla']." e
				JOIN ".$this->tablas['listaDet']['tabla']." lstd ON lstd.".$this->tablas['elemento']['id']." = e.".$this->tablas['elemento']['id']."
				JOIN trade.list_categoria_marca_competenciaTradDet_elemento lstde ON lstde.idListCategoriaMarcaCompDet = lstd.idListCategoriaMarcaCompDet
				JOIN trade.producto_marca m ON m.idMarca = lstde.idMarca
				WHERE lstd.".$this->tablas['lista']['id']." = ".$post['id'].";
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => null ];
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
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC
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
		$filtros = " ";
		if (!empty($post['nombre'])) $filtros .= " AND p.nombre =  '" . $post['nombre']."'";
		if (!empty($post['id'])) $filtros .= " AND idProyecto = " . $post['id'];
		if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario = " . $post['idUsuario'];

		$sql = "
				DECLARE @fecha date=getdate();
				select p.idProyecto,p.nombre
				from  trade.usuario_historico uh 
				JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
				where uh.estado=1 
				and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico', 'id' => null ];
		return $this->db->query($sql);
	}

	public function getGrupoCanales($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND gc.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idGrupoCanal = " . $post['id'];
		}

		$sql = "
				SELECT gc.*
				FROM trade.grupoCanal gc
				JOIN trade.proyectoGrupoCanal pgc ON pgc.idGrupoCanal = gc.idGrupoCanal AND pgc.idProyecto = {$idProyecto} 
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal', 'id' => null ];
		return $this->db->query($sql);
	}

	public function registrarLista_HT($post)
	{
		$idProyecto = $this->sessIdProyecto;
		
		$insert = [
			'idProyecto' => $idProyecto,
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

	public function validar_elementos_unicos_HT($post){
		$elementos = array();

		foreach($post as $index => $value){
			$elementos[$index] = $value['categoria'];
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

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->model->tablas['elemento']['tabla'], 'id' => null ];
		return $insert;
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
			".getClienteHistoricoCuenta()." ch
			JOIN ImpactTrade_bd.trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN ImpactTrade_bd.trade.canal ca
				ON ca.idCanal=sn.idCanal 
			JOIN ImpactTrade_bd.trade.grupoCanal gc 
			    ON gc.idGrupoCanal=ca.idGrupoCanal
			{$filtros}
		ORDER BY gc.idGrupoCanal
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta(), 'id' => null ];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico', 'id' => null ];
		return $this->db->query($sql);
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
	public function getMarcas($post = 'nulo')
	{

		$idProyecto = $this->sessIdProyecto;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND m.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND m.idMarca = " . $post['id'];
		}

			$sql = "
			SELECT 
			m.idMarca
			,m.nombre marca
			,c.idCategoria
			,c.nombre categoria
			FROM trade.producto_marca m
			JOIN trade.list_categoria_marca cm ON cm.idMarca = m.idMarca AND cm.estado = 1 
			JOIN trade.producto_categoria c ON c.idCategoria = cm.idCategoria AND c.estado = 1

			{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal', 'id' => null ];
		return $this->db->query($sql);
	}

}
