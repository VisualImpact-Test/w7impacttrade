<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_visibilidad extends My_Model
{
	var $CI;
	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [

			'lista_sos' => ['tabla' => "{$this->sessBDCuenta}.trade.list_sos", 'id' => 'idListSos'],
			'lista_sos_det' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_sos_det",'id'=>'idListSosDet'],
			'lista_sod' => ['tabla' => "{$this->sessBDCuenta}.trade.list_sod", 'id' => 'idListSod'],
			'lista_sod_det' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_sod_det",'id'=>'idListSodDet'],
			'elemento_sos' => ['tabla'=>"trade.producto_marca",'id'=>'idMarca'],
			'elemento_sod' => ['tabla'=>"trade.producto_marca",'id'=>'idMarca'],
		];

		$this->CI =& get_instance();
	}

	/*Segmentacion Negocio*/
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

	// SECCION ELEMENTO
	public function getListaSos($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;

		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['lista_sos']['id']." = " . $post['id'];
		/*Filtros */
		if(!empty($idProyecto))$filtros .= " AND lst.idProyecto=".$idProyecto;
		
		$cliente_historico = getClienteHistoricoCuenta();
		/*=====*/
		$sql = "
				DECLARE
					@fecIni DATE='{$post['fecIni']}',
					@fecFin DATE='{$post['fecFin']}';
				SELECT 
				lst.*
				,gc.nombre grupoCanal
				,ca.nombre canal
				,ch.razonSocial
				,ch.nombreComercial
				,ch.codCliente
				FROM ".$this->tablas['lista_sos']['tabla']." lst
				LEFT JOIN trade.grupoCanal gc ON lst.idGrupoCanal = gc.idGrupoCanal
				LEFT JOIN trade.canal ca ON lst.idCanal = ca.idCanal
				LEFT JOIN {$cliente_historico} ch ON lst.idCliente = ch.idCliente
					AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin) = 1
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['lista_sos']['tabla'] ];
		return $this->db->query($sql);
	}

	public function registrarElemento($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
            'idTipoPromocion' =>trim($post['tipo']),
        ];

		$insert = $this->db->insert($this->tablas['elemento_sos']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento_sos']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarElemento($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
            'idTipoPromocion' =>trim($post['tipo']),

			'fechaModificacion' => getActualDateTime(),
        ];
        
		$where = [
			$this->tablas['elemento_sos']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento_sos']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elemento_sos']['tabla'], 'id' => $post['idx'] ];
		return $update;
    }
    
	public function registrarLista($post)
	{
		$idProyecto = $this->sessIdProyecto ;

		$insert = [
			'idCanal' => trim($post['canal']),
			'idProyecto' => $idProyecto,
			'FecIni' => trim($post['fechaInicio']),
			'estado'=>1
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
			$this->tablas['elemento_sos']['id'] => $idEncuesta,
		];
		$where = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento_sos']['id'] => $idEncuesta,
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

	public function actualizarLista($post)
	{
		$idProyecto = $this->sessIdProyecto ;

		$update = [
			'idProyecto' => $idProyecto,
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		if(!empty($post['banner'])){$update['idBanner']= trim($post['banner']);}
		if(!empty($post['cadena'])){$update['idCadena']= trim($post['cadena']);}
		if(!empty($post['canal'])){$update['idCanal']= trim($post['canal']);}

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idlst'] ];
		return $update;
	}

	public function checkNombreElementoRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['elemento_sos']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['elemento_sos']['tabla'], $where);
	}
	public function checkNombreTipoPromocionRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['tipoPromocion']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['tipoPromocion']['tabla'], $where);
	}

	// SECCION LISTA
	public function getListas_sos($post)
	{
		$filtros = " ";
		if (!empty($post['id'])) $filtros .= " AND lst.idListSos = " . $post['id'];
		if (!empty($post['ids'])) $filtros .= " AND lst.idListSos IN (" . $post['ids'].")";

		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND c.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];

		if(empty($input['cuenta'])){
			$filtros.= getPermisos('cuenta');
		}
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];

		/*=====*/
		$fechas = ''; $whereFechas = '';
		if(empty($post['ids'])){
			if(!empty($post['fecIni'])){
				$fechas = "DECLARE @fecIni DATE = '{$post['fecIni']}', @fecFin DATE = '{$post['fecFin']}';";
				$whereFechas = "AND General.dbo.fn_fechaVigente(lst.fecIni,lst.fecFin,@fecIni,@fecFin) = 1 ";
			}
		}
		if(!empty($post['all'])){
			$fechas = '';
			$whereFechas = '';
		}
		$sql = "
				{$fechas}
				SELECT 
				lst.idListSos
			  , lst.idCanal
			  , lst.idCliente
			  , CONVERT(VARCHAR,lst.fecIni,103) fecIni
			  , CONVERT(VARCHAR,lst.fecFin,103) fecFin
			  , lst.idProyecto
			  , lst.estado
			  , CONVERT(VARCHAR,lst.fechaCreacion,103) fechaCreacion
			  , CONVERT(VARCHAR,lst.fechaModificacion,103) fechaModificacion
			  , p.nombre proyecto
			  , c.nombre canal 
			  , ISNULL(cli.nombreComercial,'-') nombreComercial
			  , ISNULL(cli.razonSocial,'-') razonSocial
			  , cli.codCliente
			  , gc.idGrupoCanal
			  , gc.nombre as grupoCanal
			  , ma.idMarca
			  , ma.nombre marca
				FROM 
				{$this->sessBDCuenta}.trade.list_sos lst
				LEFT JOIN {$this->sessBDCuenta}.trade.list_sos_det lstd ON lstd.idListSos=lst.idListSos
				LEFT JOIN trade.producto_marca ma ON ma.idMarca=lstd.idMarca
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				WHERE 
				1 = 1
				{$whereFechas}
				{$filtros}
				ORDER BY lst.fecIni DESC
			";

		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
	
		$sql = "
				SELECT 
				e.*
				FROM 
				".$this->tablas['elemento_sos']['tabla']." e
				JOIN ".$this->tablas['listaDet']['tabla']." lstd ON lstd.".$this->tablas['elemento_sos']['id']." = e.".$this->tablas['elemento_sos']['id']."
				WHERE lstd.".$this->tablas['lista']['id']." = ".$post['id'].";
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento_sos']['tabla'] ];
		return $this->db->query($sql);
	}

	public function actualizarMasivoLista($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['lista_sos_det']['id'] => $value['id'],
					 $this->model->tablas['elemento_sos']['id'] =>$value['elemento_lista'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['lista_sos_det']['tabla'], $input, $this->model->tablas['lista_sos_det']['id']);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['listaDet']['tabla'] ];
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
			$rs = $this->db->get_where($this->model->tablas['lista_sos_det']['tabla'],array($this->model->tablas['lista_sos']['id']=>$idLista,"idMarca"=>$row['elemento_lista']))->row_array();
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
						$this->model->tablas['lista_sos_det']['id'] => $idLista,
						 $this->model->tablas['elemento_sos']['id'] =>$value['elemento_lista'],
						
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['lista_sos_det']['tabla'], $input);
			$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista_sos_det']['tabla'] ];
		
		}

		return $insert;
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
    }

	public function getTiposPromocion($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idTipoPromocion = " . $post['id'];
		}

		$sql = "
				SELECT 
				* 
				FROM
				trade.tipoPromocion
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tipoPromocion' ];
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

	public function registrarLista_HT($post)
	{

		$insert = [
			'idGrupoCanal' => trim($post['idGrupoCanal']),
			'FecIni' => trim($post['fechaInicio']),
			'idProyecto' =>trim($post['idProyecto']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}
		if(!empty($post['idCanal'])){$insert['idCanal']=$post['idCanal'];}

		$insert = $this->db->insert($this->tablas['lista_sos']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista_sos']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function validar_elementos_unicos_HT($post){
		$elementos = array();

		foreach($post as $index => $value){
			$elementos[$index] = $value['promocion'];
		}

		if(count($elementos) != count(array_unique($elementos))){
			return false;
		}else{
			return true;
		}
	}

	public function registrar_elementos_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch( $this->model->tablas['elemento_sos']['tabla'], $input);

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento_sos']['tabla'] ];
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

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
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
			JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN trade.canal ca
				ON ca.idCanal=sn.idCanal 
		{$filtros}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
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
	public function registrarTipoPromocion($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
        ];

		$insert = $this->db->insert($this->tablas['tipoPromocion']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['tipoPromocion']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }

	public function actualizarTipoPromocion($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'fechaModificacion' => getActualDateTime(),
        ];
        
		$where = [
			$this->tablas['tipoPromocion']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['tipoPromocion']['tabla'], $update);

		$this->CI->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['tipoPromocion']['tabla'], 'id' => $post['idx'] ];
		return $update;
    }
	public function actualizarLista_HT($update)
	{
		$update_batch = $this->db->update_batch($this->tablas['lista_sos']['tabla'], $update,'idListSos');

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista_sos']['tabla'], 'id' => $this->insertId ];
		return $update_batch;
	}
    

}
