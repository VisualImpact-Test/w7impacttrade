<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_inventario extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
            'elemento' => ['tabla' => 'trade.producto', 'id' => 'idProducto'],
			'lista' => ['tabla' => 'trade.list_inventario', 'id' => 'idListInventario'],
			'listaDet' => ['tabla'=>'trade.list_inventarioDet','id'=>'idListInventarioDet'],
			'marca' => ['tabla'=>'trade.producto_marca','id'=>'idMarca'],
		];
	}

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
                p.*,
                cat.nombre categoria
                ,c.nombre cuenta
                ,m.nombre marca
                ,e.descripcion envase
                FROM
                ".$this->tablas['elemento']['tabla']." p
                JOIN trade.producto_categoria cat ON cat.idCategoria = p.idCategoria
                JOIN trade.producto_marca m ON m.idMarca = p.idMarca
                JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
                LEFT JOIN trade.producto_envase e ON e.idEnvase = p.idEnvase
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => null ];
		return $this->db->query($sql);
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
		if(!empty($post['banner'])){$insert['idBanner']= trim($post['banner']);}
		if(!empty($post['cadena'])){$insert['idCadena']= trim($post['cadena']);}
		if(!empty($post['canal'])){$insert['idCanal']= trim($post['canal']);}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
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

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->model->tablas['listaDet']['tabla'], 'id' => null ];
		return $update;
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
			'fecFin' => !empty($post['fechaFin']) ? $post['fechaFin'] : null
		];
		if(!empty($post['cliente'])){$update['idCliente']= trim($post['cliente']);}

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idlst'] ];
		return $update;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{

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

		}

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['listaDet']['tabla'] ];
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
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];
		/*=====*/
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
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
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
				FROM 
				".$this->tablas['elemento']['tabla']." e
				JOIN ".$this->tablas['listaDet']['tabla']." lstd ON lstd.".$this->tablas['elemento']['id']." = e.".$this->tablas['elemento']['id']."
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
			SELECT 
			c.idCliente, c.razonSocial
			FROM trade.cliente c
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente', 'id' => null ];
		return $this->db->query($sql);
	}

	public function getTiposPromocion($post = 'nulo')
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
				trade.tipoPromocion
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tipoPromocion', 'id' => null ];
		return $this->db->query($sql);
	}

	public function getCadenas($post = 'nulo')
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
				trade.cadena
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cadena', 'id' => null ];
		return $this->db->query($sql);
	}

	public function getBanners($post = 'nulo')
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
				trade.banner
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.banner', 'id' => null ];
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

	public function registrarLista_HT($post)
	{

		$insert = [
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'idCanal' =>trim($post['idCanal']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function obtenerCanalCuenta($post){
		$filtros = "WHERE 1 = 1";
			if (!empty($post['idCuenta'])) $filtros .= " AND ch.idCuenta= " . $post['idCuenta'];
		
		$sql ="
		SELECT DISTINCT
			ca.idCanal
			,ca.nombre
			,ch.idCuenta
		FROM 
			".getClienteHistoricoCuenta()." ch
			JOIN ImpactTrade_bd.trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN ImpactTrade_bd.trade.canal ca
				ON ca.idCanal=sn.idCanal 
		{$filtros}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta(), 'id' => null ];
		return $this->db->query($sql);
	}
	
	public function getCuentas($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idCuenta = " . $post['id'];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico', 'id' => null ];
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto', 'id' => null ];
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
		JOIN ".getClienteHistoricoCuenta()." ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 {$filtro}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente', 'id' => null ];
		return $this->db->query($sql);
	}

}
