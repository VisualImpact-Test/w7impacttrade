<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_productos extends My_Model
{

	var $CI;

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.producto', 'id' => 'idProducto'],
			'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_productos", 'id' => 'idListProductos'],
			'listaDet' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_productosDet",'id'=>'idListProductosDet'],
			'marca' => ['tabla'=>'trade.producto_marca','id'=>'idMarca'],
			'categoria' => ['tabla'=>'trade.producto_categoria','id'=>'idCategoria'],
			'precio' => ['tabla'=>'trade.producto_precios','id'=>'idPrecio'],
			'listaPrecio' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_precios",'id'=>'idListPrecio'],
			'unidadMedidaProducto' => ['tabla'=>'trade.unidadMedidaProducto','id'=>'idUnidadMedidaProducto'],
			'surtido' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_surtido",'id'=>'idListSurtido'],
			'surtidoDet' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_surtidoDet",'id'=>'idListSurtidoDet'],
			'motivo' => ['tabla'=>'trade.motivo','id'=>'idMotivo'],
		];

		$this->CI =& get_instance();
	}

	public function getSegCliente($post){

		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;

		$filtro='';
		if(!empty($post['idCanal'])){
			$filtro.='AND seg.idCanal='.$post['idCanal'];
		}
		if(!empty($idProyecto)){
			$filtro.='AND ch.idProyecto='.$idProyecto;
		}
		if(!empty($idCuenta)){
			$filtro.='AND ch.idCuenta='.$idCuenta;
		}
		
		$sql = "
		SELECT 
			c.idCliente
			,c.razonSocial
		FROM trade.cliente c
		JOIN ".getClienteHistoricoCuenta()." ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 {$filtro}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}

	public function getPrecioProductos($post = 'nulo')
	{
		$idCuenta = $this->sessIdCuenta;

		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['precio']['id']." = " . $post['id'];
		}

		if(!empty($idCuenta))$filtros .= " AND prod.idCuenta=".$idCuenta;
		$sql = "
                SELECT 
				p.*
				,prod.nombre producto,
				prod.idCuenta,
				cu.nombre cuenta
                FROM
				".$this->tablas['precio']['tabla']." p
				LEFT JOIN trade.producto prod ON prod.idProducto = p.idProducto
				LEFT JOIN trade.cuenta cu ON cu.idCuenta=prod.idCuenta
              	{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}
	
	public function getListaPrecios($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['listaPrecio']['id']." = " . $post['id'];
		}
		if(!empty($post['sl_grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['sl_grupoCanal'];
		if(!empty($post['sl_canal']))$filtros .= " AND c.idCanal=".$post['sl_canal'];
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];

		$sql = "
                SELECT 
				p.*
				,gc.nombre grupoCanal
				,c.nombre canal
                FROM
				".$this->tablas['listaPrecio']['tabla']." p
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal = p.idGrupoCanal
				LEFT JOIN trade.canal c ON c.idCanal = p.idCanal
              	{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['listaPrecio']['tabla'] ];
		return $this->db->query($sql);
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{	
		$idCuenta = $this->sessIdCuenta;
		$filtros = "WHERE 1 = 1";
		if (!empty($post['id'])) {
			$filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
		} else {
			$filtros .= "";
		}

		if(!empty($post['cuenta']))$filtros .= " AND c.idCuenta=".$post['cuenta'];

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
				ORDER BY p.idProducto DESC
			";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
		return $this->db->query($sql);
	}

	public function getMarcas($post = 'nulo')
	{
		$idCuenta = $this->sessIdCuenta;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= "";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['marca']['id']." = " . $post['id'];
		}
		if(!empty($idCuenta))$filtros .= " AND c.idCuenta=".$idCuenta;


		$sql = "
				SELECT
				 m.*
				 ,c.nombre cuenta
                FROM
				trade.producto_marca m
				JOIN trade.cuenta c ON c.idCuenta = m.idCuenta
				{$filtros}
				ORDER BY m.nombre ASC
				
			";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_marca' ];
		return $this->db->query($sql);
	}

	public function getCategorias($post = 'nulo')
	{
		$sql = "
				select idCategoria,nombre from trade.producto_categoria
				where estado=1
			";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_marca' ];
		return $this->db->query($sql);
	}

	public function getIdEncuesta($encuesta){
		$sql = $this->db->get_where("{$this->sessBDCuenta}.trade.encuesta",array('nombre'=>$encuesta));
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta" ];
		return ($sql);

	}

	public function registrarElemento($post)
	{
		$idCuenta =$this->sessIdCuenta;
		$insert = [
            'nombre' => trim($post['nombre']),
            'idCategoria' =>trim($post['categoria']),
            'idMarca' =>trim($post['marca']),
            'idCuenta' =>$idCuenta,
        ];
		if(!empty($post['nombreCorto'])){$insert['nombreCorto']= trim($post['nombreCorto']);}
		if(!empty($post['envase'])){$insert['idEnvase']= trim($post['envase']);}
		if(!empty($post['ean'])){$insert['ean']= trim($post['ean']);}
		(!empty($post['competencia']))? $insert['flagCompetencia'] = 1 : $insert['flagCompetencia'] = 0 ; 
        


		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}
	
	public function registrarPrecio($post)
	{
		$insert = [
            'idProducto' => trim($post['producto']),
            'precioSugerido' =>trim($post['precioSugerido']),
            'precioPromedio' =>trim($post['precioPromedio']),
			'FecIni' =>trim($post['fechaInicio']),
			'estado'=>1
        ];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
        

		$insert = $this->db->insert($this->tablas['precio']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['precio']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function registrarMarca($post)
	{
		$idCuenta =$this->sessIdCuenta;

		$insert = [
            'idCuenta' => trim($post['cuenta']),
            'nombre' => trim($post['marca']),
        ];

		$insert = $this->db->insert($this->tablas['marca']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['marca']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function registrarListaPrecio($post)
	{
		$insert = [
            'idGrupoCanal' => trim($post['grupoCanal']),
            'valorMin' =>trim($post['valorMin']),
            'valorMax' =>trim($post['valorMax']),
			'idCuenta' => trim($post['cuenta']),
        ];
		if(!empty($post['canal'])){$insert['idCanal']=$post['canal'];}
        

		$insert = $this->db->insert($this->tablas['listaPrecio']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['listaPrecio']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function registrarLista($post)
	{

		$insert = [
			'idGrupoCanal' => trim($post['grupoCanal']),
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
		// echo $this->db->last_query();
		if(count($encuesta_repetida)<1){
			$insert = $this->db->insert($this->tablas['listaDet']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();

			$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $this->insertId ];
		}else{
			$insert = false;
		}

		return $insert;
	}

	public function actualizarElemento($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
            'idCategoria' =>trim($post['categoria']),
            'idMarca' =>trim($post['marca']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['nombreCorto'])){$update['nombreCorto']= trim($post['nombreCorto']);}
		if(!empty($post['envase'])){$update['idEnvase']= trim($post['envase']);}
		if(!empty($post['ean'])){$update['ean']= trim($post['ean']);}
		(!empty($post['competencia']))? $update['flagCompetencia'] = 1 : $update['flagCompetencia'] = 0 ; 

		$where = [
			$this->tablas['elemento']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

	public function actualizarPrecio($post)
	{

		$update = [
			'idProducto' => trim($post['producto']),
			'precioSugerido' =>trim($post['precioSugerido']),
			'precioPromedio' =>trim($post['precioPromedio']),
			'FecIni' =>trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];

		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		$where = [
			$this->tablas['precio']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['precio']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['precio']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}
	
	public function actualizarMarca($post)
	{
		$update = [
			'nombre' => trim($post['marca'])
		];

		$where = [
			$this->tablas['marca']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['marca']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['marca']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

	public function getMarcasCuenta($post){
		$sql = "
		SELECT *
		FROM trade.producto_marca
		WHERE estado = 1 AND idCuenta = {$post['idCuenta']}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_marca' ];
		return $this->db->query($sql);
	}

	public function actualizarListaPrecio($post)
	{

		
		$update = [
			'idGrupoCanal' => trim($post['grupoCanal']),
			'valorMin' =>trim($post['valorMin']),
			'valorMax' =>trim($post['valorMax']),
			'fechaModificacion' => getActualDateTime(),
		];

		if(!empty($post['canal'])){$update['idCanal']=$post['canal'];}
		$where = [
			$this->tablas['listaPrecio']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['listaPrecio']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['listaPrecio']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

	public function actualizarLista($post)
	{
		
		$update = [
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		if(!empty($post['banner'])){$update['idBanner']= trim($post['banner']);}
		if(!empty($post['cadena'])){$update['idCadena']= trim($post['cadena']);}
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
		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->model->tablas['listaDet']['tabla'],array($this->model->tablas['lista']['id']=>$idLista,$this->model->tablas['elemento']['id']=>$row['elemento_lista']))->row_array();
			if($rs!=null){
				if(count($rs) >=1){
					$repetidos = true;
				}
			}
		}
		$elementos = count($new_array);

		if($elementos != count(array_unique($new_array))){
			$repetidos = true;
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

	public function checkNombreMarcaRepetido($post)
	{
		$where = "nombre = '" . trim($post['marca']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['marca']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['marca']['tabla'], $where);
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

	public function getProyectos($post)
	{
		$filtros = " ";
		if (!empty($post['nombre'])) $filtros .= " AND p.nombre =  '" . $post['nombre']."'";
		if (!empty($post['id'])) $filtros .= " AND idProyecto = " . $post['id'];
		if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario= " . $post['idUsuario'];

		$sql = "
				DECLARE @fecha date=getdate();
				select p.*,c.nombre as cuenta
				from  trade.usuario_historico uh 
				JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
				JOIN trade.cuenta c On c.idCuenta=p.idCuenta
				where uh.estado=1 
				and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}

	// SECCION LISTA
	public function getListas($post)
	{
		$idProyecto = $this->sessIdProyecto;

		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['lista']['id']." = " . $post['id'];
		/*Filtros */
		// if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($idProyecto))$filtros .= " AND p.idProyecto=".$idProyecto;
		if(!empty($post['sl_grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['sl_grupoCanal'];
		if(!empty($post['sl_canal']))$filtros .= " AND c.idCanal=".$post['sl_canal'];
		if(!empty($post['sl_cadena']))$filtros .= " AND cn.idCadena=".$post['sl_cadena'];
		if(!empty($post['sl_banner_filtro']))$filtros .= " AND b.idBanner =".$post['sl_banner_filtro'];
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
                ,cn.nombre cadena
				,b.nombre banner
				,p.idCuenta
				,cu.nombre cuenta
				,c.idGrupoCanal
				,gc.nombre grupoCanal
				
				FROM ".$this->tablas['lista']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta  = p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
                LEFT JOIN trade.cadena cn ON cn.idCadena = lst.idCadena
                LEFT JOIN trade.banner b ON b.idBanner = lst.idBanner
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
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			// if (!empty($post['id'])) $filtros .= " AND ch.idProyecto = " . $post['id'];
			if (!empty($post['id'])) $filtros .= " AND ch.idProyecto = " . $post['id'];
			if (!empty($post['cuenta'])) $filtros .= " AND ch.idCuenta= " . $post['cuenta'];
		}

		$sql = "
			DECLARE @fecha DATE=GETDATE();
			SELECT --TOP 6000
			c.idCliente, c.razonSocial
			FROM trade.cliente c
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND c.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}

	public function getEnvases($post = 'nulo')
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
				trade.producto_envase
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_envase' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cadena' ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.banner' ];
		return $this->db->query($sql);
	}

	public function getGrupoCanales($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND gc.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND gc.idGrupoCanal = " . $post['id'];
		}

		$sql = "
				SELECT gc.*
				FROM trade.grupoCanal gc
				JOIN trade.proyectoGrupoCanal pgc ON pgc.idGrupoCanal = gc.idGrupoCanal 
					AND pgc.idProyecto = {$idProyecto}
					AND pgc.estado = 1
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal' ];
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
		$insert = $this->db->insert_batch($this->model->tablas['elemento']['tabla'], $input);

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['elemento']['tabla'] ];
		return $insert;
	}

	public function registrar_marcas_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->model->tablas['marca']['tabla'], $input);

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['marca']['tabla'] ];
		return $insert;
	}

	public function registrarLista_HT($post)
	{

		$insert = [
			'idGrupoCanal' => trim($post['idGrupoCanal']),
			'idProyecto' => trim($post['idProyecto']),
			'fecIni' =>trim($post['fechaInicio']),
		];
		if(!empty($post['idCanal'])){$insert['idCanal']= trim($post['idCanal']);}
		if(!empty($post['idCadena'])){$insert['idCadena']= trim($post['idCadena']);}
		if(!empty($post['idBanner'])){$insert['idBanner']= trim($post['idBanner']);}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	//elemento filtrado
	public function getElementosProyecto($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
			$filtros .= " AND p.flagCompetencia = 0";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
		}

		if(!empty($post['idProyecto']))$filtros .= " AND pr.idProyecto=".$post['idProyecto'];
		if(!empty($post['idCuenta']))$filtros .= " AND c.idCuenta=".$post['idCuenta'];

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
				JOIN trade.proyecto pr ON pr.idCuenta = p.idCuenta
                LEFT JOIN trade.producto_envase e ON e.idEnvase = p.idEnvase
              	{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
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
			".getClienteHistoricoCuenta()." ch
			JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN trade.canal ca
				ON ca.idCanal=sn.idCanal 
			JOIN trade.grupoCanal gc 
			    ON gc.idGrupoCanal=ca.idGrupoCanal
			{$filtros}
		ORDER BY gc.idGrupoCanal
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $this->db->query($sql);
	}

	public function getUnidadMedidaProducto($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= "";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['unidadMedidaProducto']['id']." = " . $post['id'];
		}
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];


		$sql = "
				SELECT 
					umd.*,u.nombre as 'unidadMedida', p.nombre as 'producto' from trade.unidadMedidaProducto umd
				JOIN trade.unidadMedida u On u.idUnidadMedida=umd.idUnidadMedida
				JOIN trade.producto p ON p.idProducto=umd.idProducto
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.unidadMedida' ];
		return $this->db->query($sql);
	}

	public function getUnidadMedida()
	{
		$sql = "
			SELECT idUnidadMedida,nombre 
			FROM trade.unidadMedida
			WHERE estado=1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.unidadMedida' ];
		return $this->db->query($sql);
	}

	public function registrarUnidadMedidaProducto($post)
	{
		$insert = [
            'idProducto' => trim($post['producto']),
			'idUnidadMedida' => trim($post['unidadMedida']),
			'precio' => trim($post['precio']),
			'fechaCreacion' => getActualDateTime(),
        ];

		$insert = $this->db->insert($this->tablas['unidadMedidaProducto']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['unidadMedidaProducto']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function actualizarUnidadMedidaProducto($post)
	{
		$update = [
			'idProducto' => trim($post['producto']),
			'idUnidadMedida' => trim($post['unidadMedida']),
			'precio' => trim($post['precio']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['unidadMedidaProducto']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['unidadMedidaProducto']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['unidadMedidaProducto']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

	public function registrarUnidadMedidaProductoHT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->model->tablas['unidadMedidaProducto']['tabla'], $input);

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['unidadMedidaProducto']['tabla'] ];
		return $insert;
	}
	public function getSurtidos($post)
	{
		$idProyecto = $this->sessIdProyecto;

		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['surtido']['id']." = " . $post['id'];
		/*Filtros */
		// if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($idProyecto))$filtros .= " AND p.idProyecto=".$idProyecto;
		if(!empty($post['sl_grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['sl_grupoCanal'];
		if(!empty($post['sl_canal']))$filtros .= " AND c.idCanal=".$post['sl_canal'];
		if(!empty($post['sl_cadena']))$filtros .= " AND cn.idCadena=".$post['sl_cadena'];
		if(!empty($post['sl_banner_filtro']))$filtros .= " AND b.idBanner =".$post['sl_banner_filtro'];
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];

		 
		$fechas = explode(' - ', $post['txt-fechas'] );
		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		 
		/*=====*/


		$sql = "
				DECLARE @fecIni date='".$input['fecIni']."', @fecFin date='".$input['fecFin']."';
				SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.nombreComercial
				,cli.razonSocial
                ,cli.codCliente
				,p.idCuenta
				,cu.nombre cuenta
				,gc.nombre grupoCanal
				, lst.estado
				FROM ".$this->tablas['surtido']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta  = p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				{$filtros}
				AND (
					lst.fecIni <= ISNULL( lst.fecFin, @fecFin)
					AND (
					lst.fecIni BETWEEN @fecIni AND @fecFin
					OR
					ISNULL( lst.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
					OR
					@fecIni BETWEEN lst.fecIni AND ISNULL( lst.fecFin, @fecFin )
					OR
					@fecFin BETWEEN lst.fecIni AND ISNULL( lst.fecFin, @fecFin )
					)
				)
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['surtido']['tabla'] ];
		return $this->db->query($sql);
	}
	public function getSurtidoElementos($post)
	{
	
		$sql = "
				SELECT 
				e.*
				,lstd.".$this->model->tablas['surtidoDet']['id']."
				FROM 
				".$this->tablas['elemento']['tabla']." e
				JOIN ".$this->tablas['surtidoDet']['tabla']." lstd ON lstd.".$this->tablas['elemento']['id']." = e.".$this->tablas['elemento']['id']."
				WHERE lstd.".$this->tablas['surtido']['id']." = ".$post['id'].";
			"; 

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'] ];
		return $this->db->query($sql);
	}
	public function actualizarMasivoListaSurtido($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['surtidoDet']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['surtidoDet']['tabla'], $input, $this->model->tablas['surtidoDet']['id']);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->model->tablas['surtidoDet']['tabla'] ];
		return $update;
	}

	public function guardarMasivoListaSurtido($multiDataRefactorizada, $idLista)
	{
		//Pasar a la vista
		$new_array = array();
		$repetidos = false;
		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->model->tablas['surtidoDet']['tabla'],array($this->model->tablas['surtido']['id']=>$idLista,$this->model->tablas['elemento']['id']=>$row['elemento_lista']))->row_array();
			if($rs!=null){
				if(count($rs) >=1){
					$repetidos = true;
				}
			}
		}
		$elementos = count($new_array);

		if($elementos != count(array_unique($new_array))){
			$repetidos = true;
		}
		if(!$repetidos){

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {
					$input[] = [
						$this->model->tablas['surtido']['id'] => $idLista,
						$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
						
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['surtidoDet']['tabla'], $input);

			$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['surtidoDet']['tabla'] ];
		}else{
            $insert = 'repetido';
		}

		return $insert;
	}
	
	public function registrarListaSurtido($post)
	{

		$insert = [
			'idGrupoCanal' => trim($post['grupoCanal']),
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['cliente'])){$insert['idCliente']=$post['cliente'];}
		if(!empty($post['canal'])){$insert['idCanal']= trim($post['canal']);}

		$insert = $this->db->insert($this->tablas['surtido']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['surtido']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}
	public function registrarListaSurtido_HT($post)
	{

		$insert = [
			'idGrupoCanal' => trim($post['idGrupoCanal']),
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}
		if(!empty($post['idCanal'])){$insert['idCanal']= trim($post['idCanal']);}

		$insert = $this->db->insert($this->tablas['surtido']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['surtido']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function getElementoCategorias($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['categoria']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
                FROM
                ".$this->tablas['categoria']['tabla']." p
				LEFT JOIN  {$this->sessBDCuenta}.trade.list_categoria_marca cm ON cm.idCategoria = p.idCategoria AND cm.idProyecto = {$idProyecto}
                {$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['categoria']['tabla'] ];
		return $this->db->query($sql);
	}
	public function registrarCategoria($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
        ];

		$insert = $this->db->insert($this->tablas['categoria']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['categoria']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarCategoria($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),

        ];
        
		$where = [
			$this->tablas['categoria']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['categoria']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['categoria']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}
	public function checkNombreCategoriaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['categoria']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['categoria']['tabla'], $where);
	}

	public function registrar_categoria_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->model->tablas['categoria']['tabla'], $input);

		$this->CI->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->model->tablas['categoria']['tabla'], 'id' => null ];
		return $insert;
	}
	public function validar_categorias_unicas_HT($post){
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


	//SECCION MOTIVO
	public function getMotivos($post = 'nulo')
	{
		$idCuenta = $this->sessIdCuenta;
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= "";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['motivo']['id']." = " . $post['id'];
		}
		if(!empty($idCuenta))$filtros .= " AND c.idCuenta=".$idCuenta;


		$sql = "
				SELECT
				 m.*
				 ,c.nombre cuenta
                FROM
				trade.motivo m
				JOIN trade.cuenta c ON c.idCuenta = m.idCuenta
				{$filtros}
				ORDER BY m.nombre ASC
				
			";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.motivo' ];
		return $this->db->query($sql);
	}

	public function checkNombreMotivoRepetido($post)
	{
		$where = "nombre = '" . trim($post['motivo']) . "' ";
		$where .= " and  idCuenta= '" . trim($post['cuenta']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['motivo']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['motivo']['tabla'], $where);
	}

	public function registrarMotivo($post)
	{
		$idCuenta =$this->sessIdCuenta;

		$insert = [
            'idCuenta' => trim($post['cuenta']),
            'nombre' => trim($post['motivo']),
        ];

		$insert = $this->db->insert($this->tablas['motivo']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['motivo']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function actualizarMotivo($post)
	{
		$update = [
			'nombre' => trim($post['motivo'])
		];

		$where = [
			$this->tablas['motivo']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['motivo']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['motivo']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

}
