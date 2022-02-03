<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_premiacion extends My_Model
{

    var $CI;
    var $aSessTrack = [];

    public function __construct()
    {
        parent::__construct();

        $this->tablas = [
            'tipoPremiacion' => ['tabla' => "{$this->sessBDCuenta}.trade.premiacion", 'id' => 'idPremiacion'],
            'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_premiaciones", 'id' => 'idListPremiacion'],
            'listaDet' => ['tabla' => "{$this->sessBDCuenta}.trade.list_premiacionesDet", 'id' => 'idListPremiacionDet'],
        ];

        $this->CI = &get_instance();
    }

    public function getPremiacion($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
          
        } else {
            if (!empty($post['id'])) $filtros .= " AND idPremiacion = " . $post['id'];
            if (!empty($post['cuenta_filtro'])) $filtros .= " AND idCuenta = " . $post['cuenta_filtro'];
        }

        $sql = "
				SELECT *
				FROM {$this->sessBDCuenta}.trade.premiacion
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
        return $this->db->query($sql);
    }

    public function checkTipoPremiacionRepetido($post)
    {
        $where = "descripcion = '" . trim($post['nombre']) . "' AND idCuenta = " . trim($post['cuenta_tipoPremiacion']);
        if (!empty($post['idTipoPremiacion'])) $where .= " AND idTipoPremiacion != " . $post['idTipoPremiacion'];
        return $this->verificarRepetido('trade.tipo_premiacion', $where);
    }

    public function registrarTipoPremiacion($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'idCuenta' => trim($post['cuenta_tipoPremiacion']),
            'fechaInicio' => trim($post['fechaInicio']),
        ];

		if(!empty($post['fechaFin'])){
			 $insert['fechaCaducidad']=trim($post['fechaFin']);
		}
		

        $insert = $this->db->insert("{$this->sessBDCuenta}.trade.premiacion", $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarTipoPremiacion($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'idCuenta' => trim($post['cuenta_tipoPremiacion']),
            'fechaInicio' => trim($post['fechaInicio']),
        ];
		
		if(!empty($post['fechaFin'])){
			 $update = [
				'fechaCaducidad' => trim($post['fechaFin'])
			];
		}

        $where = [
            'idPremiacion' => $post['idPremiacion']
        ];

        $this->db->where($where);
        $update = $this->db->update("{$this->sessBDCuenta}.trade.premiacion", $update);
        return $update;
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
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
		if(!empty($post['idTipoUsuario'])){$insert['idTipoUsuario']=$post['idTipoUsuario'];}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

    public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idListPremiacion' => $idLista,
					'idPremiacion' =>$value['elemento_lista'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_tipopremiacion->tablas['listaDet']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_tipopremiacion->tablas['listaDet']['tabla'] ];
		return $insert;
	}

	public function getListaPremiacion($post=array()){
		$filtros = " ";
		if (!empty($post['id'])) $filtros .= " AND lst.idListPremiacion = " . $post['id'];
		if (!empty($post['ids'])) $filtros .= " AND lst.idListPremiacion IN (" . $post['ids'].")";

		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND c.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];

		if(!empty($post['idTipoUsuario']))$filtros .= " AND lst.idTipoUsuario=".$post['idTipoUsuario'];
		/*=====*/
		/*$fechas = ''; $whereFechas = '';
		if(empty($post['ids'])){
			if(!empty($post['fecIni'])){
				$fechas = "DECLARE @fecIni DATE = '{$post['fecIni']}', @fecFin DATE = '{$post['fecFin']}';";
				$whereFechas = "AND General.dbo.fn_fechaVigente(lst.fecIni,lst.fecFin,@fecIni,@fecFin) = 1 ";
			}
		}*/
		//if(!empty($post['all'])){
			$fechas = '';
			$whereFechas = '';
		//}
		$sql = "
		{$fechas}
		SELECT 
			  lst.idListPremiacion
			, lstd.idListPremiacionDet
			, lst.idCanal
			, lst.idCliente
			, CONVERT(VARCHAR,lst.fecIni,103) fecIni
			, CONVERT(VARCHAR,lst.fecFin,103) fecFin
			, lst.idProyecto
			, lst.idTipoUsuario
			, lst.estado
			, CONVERT(VARCHAR,lst.fechaCreacion,103) fechaCreacion
			, CONVERT(VARCHAR,lst.fechaModificacion,103) fechaModificacion
			, p.nombre proyecto
			, c.nombre canal 
			, ISNULL(cli.nombreComercial,'-') nombreComercial
			, ISNULL(cli.razonSocial,'-') razonSocial
			, cli.codCliente
			, ut. nombre as tipo
			, gc.idGrupoCanal
			, gc.nombre as grupoCanal
			, e.idPremiacion
			, e.nombre premiacion
		FROM 
		{$this->sessBDCuenta}.trade.list_premiaciones lst
		LEFT JOIN {$this->sessBDCuenta}.trade.list_premiacionesDet lstd ON lstd.idListPremiacion=lst.idListPremiacion
		LEFT JOIN {$this->sessBDCuenta}.trade.premiacion e ON e.idPremiacion=lstd.idPremiacion
		JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
		JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
		LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lst.idGrupoCanal
		LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
		LEFT JOIN trade.Usuario_tipo ut ON ut.idTipoUsuario = lst.idTipoUsuario
		WHERE 
		1 = 1
		{$whereFechas}
		{$filtros}
		ORDER BY lst.fecIni DESC
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_premiaciones" ];
		return $this->db->query($sql);
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
			select distinct c.idCuenta,c.nombre from  trade.usuario_historico uh 
			JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
			JOIN trade.cuenta c On c.idCuenta=p.idCuenta
			where uh.estado=1 
			and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
			{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'usuario_historico' ];
		return $this->db->query($sql);
	}

	public function getTipoUsuario($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;
		$filtro = "";

		if( !empty($idCuenta) ){
			$filtro .= " AND tuc.idCuenta = {$idCuenta}";
		}

		$sql = "SELECT 
				tu.idTipoUsuario, 
				tu.nombre 
				FROM trade.usuario_tipo tu 
				JOIN trade.tipoUsuarioCuenta tuc ON tuc.idTipoUsuario = tu.idTipoUsuario
				WHERE tu.estado = 1{$filtro} 
				ORDER BY tu.nombre";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_tipo' ];
		return $this->db->query($sql);
	}

	public function getSegCliente($post){
		$filtro='';
		if(!empty($post['idCanal'])){
			$filtro.=' AND seg.idCanal='.$post['idCanal'];
		}
		if(!empty($post['idProyecto'])){
			$filtro.=' AND ch.idProyecto='.$post['idProyecto'];
		}
		if(!empty($post['idCuenta'])){
			$filtro.=' AND ch.idCuenta='.$post['idCuenta'];
		}
		$sql = "
		DECLARE @fecha date=getdate();
		SELECT 
			c.idCliente
			,c.razonSocial
		FROM trade.cliente c
		JOIN ".getClienteHistoricoCuenta()." ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 
		AND @fecha between ch.fecIni and isnull(ch.fecFin,@fecha)
		{$filtro}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}

	public function getGrupoCanales($post = 'nulo')
	{
		$idProyecto = $this->sessIdProyecto;

		$filtros= "";
			

			if( !empty($idProyecto) ) $filtros .= " AND gc.idProyecto = ".$idProyecto;
		$filtros.= " AND gc.estado = 1";
		$sql = "
				SELECT 
					gc.idGrupoCanal,
					gc.nombre
				FROM  trade.grupoCanal gc 
				WHERE 1=1
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal' ];
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
		if (!empty($post['nombre'])) $filtros .= " AND p.nombre =  '" . $post['nombre']."'";
		if (!empty($post['id'])) $filtros .= " AND idProyecto = " . $post['id'];
		if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario = " . $post['idUsuario'];

		$sql = "
				DECLARE @fecha date=getdate();
				select distinct p.idProyecto,p.nombre
				from  trade.usuario_historico uh 
				JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
				where uh.estado=1 
				and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}

	public function getListas($post)
	{
		$filtros = " ";
		if (!empty($post['id'])) $filtros .= " AND lst.idListPremiacion = " . $post['id'];
		if (!empty($post['ids'])) $filtros .= " AND lst.idListPremiacion IN (" . $post['ids'].")";

		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND c.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];

		if(empty($input['cuenta'])){
			$filtros.= getPermisos('cuenta');
		}
		if(!empty($post['cuenta']))$filtros .= " AND p.idCuenta=".$post['cuenta'];

		if(!empty($post['idTipoUsuario']))$filtros .= " AND lst.idTipoUsuario=".$post['idTipoUsuario'];
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
				lst.idListPremiacion
			  , lst.idCanal
			  , lst.idCliente
			  , CONVERT(VARCHAR,lst.fecIni,103) fecIni
			  , CONVERT(VARCHAR,lst.fecFin,103) fecFin
			  , lst.idProyecto
			  , lst.idTipoUsuario
			  , lst.estado
			  , CONVERT(VARCHAR,lst.fechaCreacion,103) fechaCreacion
			  , CONVERT(VARCHAR,lst.fechaModificacion,103) fechaModificacion
			  , p.nombre proyecto
			  , c.nombre canal 
			  , ISNULL(cli.nombreComercial,'-') nombreComercial
			  , ISNULL(cli.razonSocial,'-') razonSocial
			  , cli.codCliente
			  , ut. nombre as tipo
			  , gc.idGrupoCanal
			  , gc.nombre as grupoCanal
			  , e.idPremiacion
			  , e.nombre premiacion
				FROM 
				{$this->sessBDCuenta}.trade.list_premiaciones lst
				LEFT JOIN {$this->sessBDCuenta}.trade.list_premiacionesDet lstd ON lstd.idListPremiacion=lst.idListPremiacion
				LEFT JOIN {$this->sessBDCuenta}.trade.premiacion e ON e.idPremiacion=lstd.idPremiacion
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lst.idGrupoCanal
				LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				LEFT JOIN trade.Usuario_tipo ut ON ut.idTipoUsuario = lst.idTipoUsuario
				WHERE 
				1 = 1
				{$whereFechas}
				{$filtros}
				ORDER BY lst.fecIni DESC
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_encuesta" ];
		return $this->db->query($sql);
	}
	public function actualizarLista_HT($update)
	{
		$update_batch = $this->db->update_batch($this->tablas['lista']['tabla'], $update,'idListPremiacion');

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $update_batch;
	}
	public function actualizarMasivoLista($insertMasivo, $deleteMasivo)
	{
		if(!empty($deleteMasivo)){
			$this->db->where_in('idListPremiacion', $deleteMasivo);
			$this->db->delete($this->m_tipopremiacion->tablas['listaDet']['tabla']);
		}
		
		return $this->db->insert_batch($this->m_tipopremiacion->tablas['listaDet']['tabla'],$insertMasivo);
		
	}

	public function actualizarLista($post)
	{
		
		$update = [
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		if(!empty($post['grupoCanal_form'])){$update['idGrupoCanal']=$post['grupoCanal_form'];}
		if(!empty($post['canal_form'])){$update['idCanal']=$post['canal_form'];}else{$update['idCanal']=NULL;}
		if(!empty($post['cliente_form'])){$update['idCliente']=$post['cliente_form'];}else{$update['idCliente']=NULL;}
		if(!empty($post['tipoUsuario_form'])){$update['idTipoUsuario']=$post['tipoUsuario_form'];}else{$update['idTipoUsuario']=NULL;}

		$where = [
			$this->tablas['lista']['id'] => $post['idLista']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idLista'] ];
		return $update;
	}

	public function actualizarMasivoListaPremiacion($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_tipopremiaciones->tablas['listaDet']['id'] => $value['id'],
					'idPremiacion' =>$value['sl_encuesta'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_tipopremiaciones->tablas['listaDet']['tabla'], $input, $this->m_tipopremiaciones->tablas['listaDet']['id']);
		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->m_tipopremiaciones->tablas['listaDet']['tabla'] ];
		return $update;
	}

	public function guardarMasivoListaPremiacion($multiDataRefactorizada, $idLista)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idListPremiacion' => $idLista,
					'idPremiacion' =>$value['sl_encuesta'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_tipopremiacion->tablas['listaDet']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_tipopremiacion->tablas['listaDet']['tabla'] ];
		return $insert;
	}


}
