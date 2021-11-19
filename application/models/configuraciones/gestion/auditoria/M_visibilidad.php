<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_visibilidad extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.elementoVisibilidadTrad', 'id' => 'idElementoVis'],
			'tipoElemento' => ['tabla' => 'trade.tipoElementoVisibilidadTrad', 'id' => 'idTipoElementoVis'],
			'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradObl", 'id' => 'idListVisibilidadObl'],
			'listaDet' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradOblDet", 'id' => 'idListVisibilidadOblDet'],
			'iniciativa' => ['tabla' => "{$this->sessBDCuenta}.trade.iniciativaTrad", 'id' => 'idIniciativa'],
			'listaIniciativa' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradIni", 'id' => 'idListVisibilidadIni'],
			'listaIniciativaDet' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet", 'id' => 'idListVisibilidadIniDet'],
			'listaIniciativaDetElemento' => ['tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento", 'id' => 'idListVisibilidadIniDetEle'],
		];
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND " . $this->tablas['elemento']['id'] . " = " . $post['id'];
		}

		/*if ($this->session->userdata('idProyecto') != null) {
			$filtros .= " AND p.idProyecto = " . $this->session->userdata('idProyecto');
		}*/
		if ($this->session->userdata('idCuenta') != null) $filtros .= " AND cu.idCuenta=" . $this->session->userdata('idCuenta') ;

		$sql = "
			SELECT
			p.*
			, t.nombre tipo
			, pc.nombre categoria
			FROM
			" . $this->tablas['elemento']['tabla'] . " p
			JOIN " . $this->tablas['tipoElemento']['tabla'] . " t ON t." . $this->tablas['tipoElemento']['id'] . " = p.idTipoElementoVisibilidad
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = p.idCategoria
			JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
			{$filtros} and p.idTipoElementoVisibilidad IN (1,2)
		";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla']];
		return $this->db->query($sql);
	}

	public function getElementosObligatorios($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND " . $this->tablas['elemento']['id'] . " = " . $post['id'];
		}

		if ($this->session->userdata('idProyecto') != null) {
			$filtros .= " AND p.idProyecto = " . $this->session->userdata('idProyecto');
		}
		if (!empty($post['cuenta'])) $filtros .= " AND py.idCuenta=" . $post['cuenta'];

		$sql = "
                SELECT
                p.*
                , t.nombre tipo
				, pc.nombre categoria
				, py.nombre AS proyecto
                FROM
                " . $this->tablas['elemento']['tabla'] . " p
                JOIN " . $this->tablas['tipoElemento']['tabla'] . " t ON t." . $this->tablas['tipoElemento']['id'] . " = p.idTipoElementoVisibilidad
                LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = p.idCategoria
                JOIN trade.proyecto py ON py.idProyecto=p.idProyecto
                {$filtros} and p.idTipoElementoVisibilidad IN (1)
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla']];
		return $this->db->query($sql);
	}

	public function getTiposElemento($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['tipo'])) $filtros .= " AND " . $this->tablas['tipoElemento']['id'] . " = " . $post['tipo'];
		}

		$sql = "
                SELECT *
                FROM
                " . $this->tablas['tipoElemento']['tabla'] . " t
				{$filtros}
				
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['tipoElemento']['tabla']];
		return $this->db->query($sql);
	}

	public function getCategoria($post = 'nulo')
	{

		$sql = "
                SELECT *
                FROM
					trade.producto_categoria
				WHERE
					estado=1
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.producto_categoria'];
		return $this->db->query($sql);
	}

	public function getIdEncuesta($encuesta)
	{


		$sql = $this->db->get_where("{$this->sessBDCuenta}.trade.encuesta", array('nombre' => $encuesta));

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta"];
		return ($sql);
	}

	public function registrarLista($post)
	{

		$insert = [
			'idProyecto' => trim($this->session->userdata('idProyecto')),
			'FecIni' => trim($post['fechaInicio']),
			//'idGrupoCanal' => trim($post['grupoCanal']),
		];
		if (!empty($post['idGrupoCanal'])) {
			$insert['idGrupoCanal'] = $post['idGrupoCanal'];
		}
		if (!empty($post['fechaFin'])) {
			$insert['fecFin'] = $post['fechaFin'];
		}
		if (!empty($post['cliente'])) {
			$insert['idCliente'] = $post['cliente'];
		}
		if (!empty($post['canal'])) {
			$insert['idCanal'] = trim($post['canal']);
		}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId];
		return $insert;
	}

	public function registrarListaDetalle($idLista, $idEncuesta, $idMarca)
	{

		$insert = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento']['id'] => $idEncuesta,
		];
		$where = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento']['id'] => $idEncuesta,
			$this->tablas['marca']['id'] => $idMarca

		];

		$encuesta_repetida = $this->db->get_where($this->tablas['listaDet']['tabla'], $where)->row_array();

		if (count($encuesta_repetida) < 1) {
			$insert = $this->db->insert($this->tablas['listaDet']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();

			$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $this->insertId];
		} else {
			$insert = false;
		}


		return $insert;
	}


	public function actualizarLista($post)
	{

		$update = [
			'idGrupoCanal' => (!empty($post['grupoCanal'])) ? $post['grupoCanal'] : null,
			'idCanal' => (!empty($post['canal'])) ? $post['canal'] : null,
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
			'idCliente' => (!empty($post['cliente'])) ? $post['cliente'] : null,
			'fecFin' => (!empty($post['fechaFin'])) ? $post['fechaFin'] : null
		];

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);

		$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idlst']];
		return $update;
	}

	public function actualizarMasivoLista($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['listaDet']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] => $value['elemento_lista'],


				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['listaDet']['tabla'], $input, $this->model->tablas['listaDet']['id']);

		$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla']];
		return $update;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{

		//Pasar a la vista
		$new_array = array();
		$repetidos = false;
		foreach ($multiDataRefactorizada as $index => $row) {
			$new_array[] = $row['elemento_lista'];
		}
		$elementos =  count($new_array);

		if ($elementos > 0) {
			if ($elementos != count(array_unique($new_array))) {
				$repetidos = true;
			}
		}

		if ($repetidos == false) {

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {
					$input[] = [
						$this->model->tablas['lista']['id'] => $idLista,
						$this->model->tablas['elemento']['id'] => $value['elemento_lista'],

					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['listaDet']['tabla'], $input);
			$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla']];
		} else {
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

	public function obtener_lista_categoria()
	{
		$sql = "SELECT pc.idCategoria, UPPER(pc.nombre) AS categoria 
		FROM trade.producto_categoria pc
		WHERE pc.estado=1";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.producto_categoria'];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cuenta_proyecto($input = array())
	{
		$filtros = '';
		$filtros .= !empty($input['listaCuentas']) ? " AND c.idCuenta IN (" . $input['listaCuentas'] . ")" : "";
		$filtros .= !empty($input['listaProyectos']) ? " AND p.idProyecto IN (" . $input['listaProyectos'] . ")" : "";
		$filtros .= !empty($input['proyectoNombre']) ? " AND p.nombre LIKE '" . $input['proyectoNombre'] . "'" : "";

		$sql = "
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

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_categoria($categoria)
	{
		$sql = "SELECT idCategoria 
		FROM trade.producto_categoria 
		WHERE nombre LIKE '{$categoria}'";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.producto_categoria'];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_elemento_visibilidad($input = array())
	{
		$aSessTrack = [];

		$table = 'trade.elementoVisibilidadTrad';
		$this->db->trans_begin();

		$insert = $this->db->insert($table, $input);
		$id = $this->db->insert_id();

		$aSessTrack = ['idAccion' => 6, 'tabla' => $table, 'id' => $id];

		if ($this->db->trans_status() === FALSE) {
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
		$filtros = "";
			if (!empty($post['id'])) $filtros .= " AND {$this->tablas['lista']['id']} = {$post['id']}";
			if (!empty($post['proyecto'])) $filtros .= " AND p.idProyecto = " . $post['proyecto'];
			if (!empty($post['grupoCanal'])) $filtros .= " AND gc.idGrupoCanal = " . $post['grupoCanal'];
			if (!empty($post['canal'])) $filtros .= " AND c.idCanal = " . $post['canal'];
			if (!empty($post['cuenta'])) $filtros .= " AND p.idCuenta = " . $post['cuenta'];

		$fecIni = $fecFin = date('d/m/Y');
			if (!empty($post['txt-fechas'])) {
				$fechas = explode('-', $post['txt-fechas']);
				$fechas = array_map('trim', $fechas);

				$fecIni = $fechas[0];
				$fecFin = $fechas[1];
			}

		$sql = "
			DECLARE
				@fecIni DATE = '{$fecIni}',
				@fecFin DATE = '{$fecFin}';

			SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.idCliente
				,cli.nombreComercial
				,cli.razonSocial
				,cli.codCliente
				,gc.nombre grupoCanal
				,p.idCuenta
				,p.idProyecto
				,cu.nombre 'cuenta'
			FROM {$this->tablas['lista']['tabla']} lst
			LEFT JOIN trade.proyecto p ON p.idProyecto = lst.idProyecto
			LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
			LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
			LEFT JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
			WHERE fn.datesBetween(lst.fecIni, lst.fecFin, @fecIni, @fecFin) = 1{$filtros}
		";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla']];
		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
		$filtros='';
		if(!empty($this->session->userdata('idCuenta'))) {
			$filtros.="AND e.idCuenta=".$this->session->userdata('idCuenta');
		}

		$sql = "
				SELECT 
				e.*
				,lstd." . $this->model->tablas['listaDet']['id'] . "
				FROM 
				" . $this->tablas['elemento']['tabla'] . " e
				JOIN " . $this->tablas['listaDet']['tabla'] . " lstd ON lstd." . $this->tablas['elemento']['id'] . " = e." . $this->tablas['elemento']['id'] . "
				WHERE lstd." . $this->tablas['lista']['id'] . " = " . $post['id'] . "  ".$filtros."
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla']];
		return $this->db->query($sql);
	}

	public function getClientes($post = 'nulo')
	{
		$filtros = "";
		
		$filtros .= " AND c.estado = 1";

		if (!empty($post['id'])) $filtros .= " AND c.estado=1 AND ch.idProyecto = " . $post['id'];


		$sql = "
			DECLARE @fecha DATE=GETDATE();
			SELECT
			c.idCliente, c.razonSocial
			FROM trade.cliente c
			JOIN " . getClienteHistoricoCuenta() . " ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cliente'];
		return $this->db->query($sql);
	}

	public function getCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		
		$filtros .= " AND c.estado = 1";

		if (!empty($post['id'])) $filtros .= " AND c.idCanal = " . $post['id'];
		if (!empty($this->session->userdata('idProyecto'))) $filtros .= " AND pgc.idProyecto = " . $this->session->userdata('idProyecto');


		$sql = "
				SELECT c.*, 
					gc.nombre grupoCanal
				FROM trade.canal c
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal=c.idGrupoCanal
				JOIN  trade.Proyectogrupocanal pgc 
				ON pgc.idGrupoCanal=gc.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.canal'];
		return $this->db->query($sql);
	}

	public function getProyectos($post)
	{
		$filtros = " ";
		if (!empty($post['nombre'])) $filtros .= " AND p.nombre =  '" . $post['nombre'] . "'";
		if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
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

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.usuario_historico'];
		return $this->db->query($sql);
	}

	public function getGrupoCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		
		$filtros .= " AND gc.estado = 1";
		//if (!empty($post['id'])) $filtros .= " AND idGrupoCanal = " . $post['id'];
		if (!empty($this->session->userdata('idProyecto'))) $filtros .= " AND pgc.idProyecto = " . $this->session->userdata('idProyecto');


		$sql = "
			SELECT 
				gc.*
					FROM trade.grupoCanal gc
			JOIN  trade.Proyectogrupocanal pgc 
			ON pgc.idGrupoCanal=gc.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.grupoCanal'];
		return $this->db->query($sql);
	}

	public function registrarLista_HT($post)
	{

		$insert = [
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
			//'idGrupoCanal' => trim($post['idGrupoCanal']),
		];
		if (!empty($post['idGrupoCanal'])) {
			$insert['idGrupoCanal'] = $post['idGrupoCanal'];
		}
		if (!empty($post['fechaFin'])) {
			$insert['fecFin'] = $post['fechaFin'];
		}
		if (!empty($post['idCliente'])) {
			$insert['idCliente'] = $post['idCliente'];
		}
		if (!empty($post['idCanal'])) {
			$insert['idCanal'] = trim($post['idCanal']);
		}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId];
		return $insert;
	}

	//LISTA MODULACION
	public function getIniciativas($post = 'nulo')
	{
		$filtros = "";
			if ($post == 'nulo') {
				$filtros .= " AND ini.estado = 1";
			} else {
				if (!empty($post['id'])) $filtros .= " AND ini.{$this->tablas['iniciativa']['id']} = {$post['id']}";
			}

			/*if ($this->session->userdata('idProyecto') != null) {
				$filtros .= " AND ini.idProyecto = ".$this->session->userdata('idProyecto');
			}*/
			if (!empty($post['cuenta'])) $filtros .= " AND ini.idCuenta = ".$post['cuenta'];

		$fecIni = $fecFin = date('d/m/Y');
			if (!empty($post['txt-fechas'])) {
				$fechas = explode('-', $post['txt-fechas']);
				$fechas = array_map('trim', $fechas);

				$fecIni = $fechas[0];
				$fecFin = $fechas[1];
			}

		$sql = "
			DECLARE
				@fecIni DATE = '{$fecIni}',
				@fecFin DATE = '{$fecFin}';

			SELECT
				ini.idIniciativa,
				ini.nombre
			FROM {$this->tablas['iniciativa']['tabla']} ini
			WHERE fn.datesBetween(ini.fecIni, ini.fecFin, @fecIni, @fecFin) = 1{$filtros}
		";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla']];
		return $this->db->query($sql);
	}

	public function getIniciativasElementos($post= 'nulo')
	{
		$filtros = " AND det.idTipoElementoVisibilidad=2 ";

			$filtros .= " AND det.estado = 1";

			if (!empty($post['id'])) $filtros .= " AND e.".$this->tablas['elemento']['id']." = " . $post['id'];
			if (!empty($post['cuenta'])) $filtros .= " AND  det.idCuenta = " . $post['cuenta'];

		$sql = "
			SELECT
				e.idIniciativa
				, e.idElementoVis 
				, det.nombre
				from  {$this->sessBDCuenta}.trade.iniciativaTradElemento e 
				JOIN trade.elementoVisibilidadTrad det ON e.idElementoVis = det.idElementoVis
				WHERE 1=1 {$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.elementoVisibilidadTrad', 'id' => null ];
		return $this->db->query($sql);
	}

	public function getListasIniciativa($post)
	{
		$filtros = "";
			if (!empty($post['id'])) $filtros .= " AND {$this->tablas['listaIniciativa']['id']} = {$post['id']}";
			if (!empty($post['proyecto'])) $filtros .= " AND p.idProyecto = " . $post['proyecto'];
			if (!empty($post['grupoCanal'])) $filtros .= " AND gc.idGrupoCanal = " . $post['grupoCanal'];
			if (!empty($post['canal'])) $filtros .= " AND c.idCanal = " . $post['canal'];
			if (!empty($post['cuenta'])) $filtros .= " AND p.idCuenta = " . $post['cuenta'];

		$fecIni = $fecFin = date('d/m/Y');
			if (!empty($post['txt-fechas'])) {
				$fechas = explode('-', $post['txt-fechas']);
				$fechas = array_map('trim', $fechas);

				$fecIni = $fechas[0];
				$fecFin = $fechas[1];
			}

		$sql = "
			DECLARE
				@fecIni DATE = '{$fecIni}',
				@fecFin DATE = '{$fecFin}';

			SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.idCliente
				,cli.nombreComercial
				,cli.razonSocial
				,cli.codCliente
				,gc.nombre grupoCanal
				,p.idCuenta
				,p.idProyecto
				,cu.nombre 'cuenta'
			FROM {$this->tablas['listaIniciativa']['tabla']} lst
			LEFT JOIN trade.proyecto p ON p.idProyecto = lst.idProyecto
			LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
			LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
			LEFT JOIN trade.cuenta cu ON cu.idCuenta=p.idCuenta
			WHERE fn.datesBetween(lst.fecIni, lst.fecFin, @fecIni, @fecFin) = 1{$filtros}
		";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla']];
		return $this->db->query($sql);
	}

	public function getListasIniciativaElementos($post)
	{
	
		$sql = "
			SELECT 
				e.idIniciativa,
				e.nombre as iniciativa,
				lstd.idListVisibilidadIniDet,
				lstd.idIniciativa,
				ev.idElementoVis,
				ev.nombre
			FROM {$this->sessBDCuenta}.trade.iniciativaTrad e
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradIniDet lstd ON lstd.idIniciativa = e.idIniciativa
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento lstdet On lstdet.idListVisibilidadIniDet = lstd.idListVisibilidadIniDet
			JOIN trade.elementoVisibilidadTrad ev ON ev.idElementoVis = lstdet.idElementoVis
			WHERE lstd.idListVisibilidadIni = ".$post['id'].";
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.iniciativaTrad" ];
		return $this->db->query($sql);
	}

	public function registrarListaIniciativa($post)
	{

		$insert = [
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
		];
		if (!empty($post['idGrupoCanal'])) {
			$insert['idGrupoCanal'] = $post['idGrupoCanal'];
		}
		if (!empty($post['fechaFin'])) {
			$insert['fecFin'] = $post['fechaFin'];
		}
		if (!empty($post['cliente'])) {
			$insert['idCliente'] = $post['cliente'];
		}
		if (!empty($post['canal'])) {
			$insert['idCanal'] = trim($post['canal']);
		}

		$insert = $this->db->insert($this->tablas['listaIniciativa']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => $this->tablas['listaIniciativa']['tabla'], 'id' => $this->insertId];
		return $insert;
	}

	public function registrarListaIniciativaDet($post,$idLista)
	{
		$aSessTrack = [];
		$insert=null;
		//segun elemento registrar iniciativa y luego elemento, igual como en generacion de lista modulacion iniciativa
		$this->db->delete($this->tablas['listaIniciativaDet']['tabla'], array($this->tablas['listaIniciativaDet']['id'] => $idLista));
		$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $idLista ];

		if(is_array($post['elemento_lista'])){

			foreach($post['elemento_lista'] as $index => $value){
				if($value!=""){
					//$rs_iniciativa = $this->db->get_where('trade.elementoVisibilidadTrad',array('idElementoVis'=>$value))->row_array();
					if( !empty($post['elemento_iniciativa'][$index])){
						$idIniciativa= $post['elemento_iniciativa'][$index];


						$arrayDetalle=array();
						$arrayDetalle['idIniciativa'] = $idIniciativa;
						$arrayDetalle['idListVisibilidadIni'] = $idLista;
						$arrayDetalle['estado'] = 1;
	
						//validar existencia
						$rs = $this->db->get_where("{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet",$arrayDetalle)->result_array();
						if($rs!=null){
							if(count($rs) >=1){
								//si existe iniciativa agregar detalle elemento
								$idListDetalle=$rs[0]['idListVisibilidadIniDet'];

								$arrayDetalleElemento=array();
								$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
								$arrayDetalleElemento['idElementoVis']=$value;
								$arrayDetalleElemento['estado']=1;

								//validar existencia
								$rs_elemento = $this->db->get_where("{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento",$arrayDetalleElemento)->result_array();
								if($rs_elemento==null){

									$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
									$this->db->trans_begin();
		
										$insert = $this->db->insert($table, $arrayDetalleElemento);
										$id = $this->db->insert_id();
		
										$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
		
									if ( $this->db->trans_status()===FALSE ) {
										$this->db->trans_rollback();
									} else {
										$this->db->trans_commit();
										$this->aSessTrack[] = $aSessTrack;
									}
								}
								
							}else{
								//insertar la iniciativa
								$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet";
								$this->db->trans_begin();
	
									$insert = $this->db->insert($table, $arrayDetalle);
									$id = $this->db->insert_id();
	
									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
									
	
									//detalle elemento
									$idListDetalle=$this->db->insert_id();
									$arrayDetalleElemento=array();
									$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
									$arrayDetalleElemento['idElementoVis']=$value;
									$arrayDetalleElemento['estado']=1;
	
									$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
									$this->db->trans_begin();
	
										$insert = $this->db->insert($table, $arrayDetalleElemento);
										$id = $this->db->insert_id();
	
										$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
									if ( $this->db->trans_status()===FALSE ) {
										$this->db->trans_rollback();
									} else {
										$this->db->trans_commit();
										$this->aSessTrack[] = $aSessTrack;
									}
								}
							}
						}else{
							//insertar la iniciativa
							$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet";
							$this->db->trans_begin();
	
								$insert = $this->db->insert($table, $arrayDetalle);
								$id = $this->db->insert_id();
	
								$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
							if ( $this->db->trans_status()===FALSE ) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								$this->aSessTrack[] = $aSessTrack;
	
								//detalle elemento
								$idListDetalle=$this->db->insert_id();
								$arrayDetalleElemento=array();
								$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
								$arrayDetalleElemento['idElementoVis']=$value;
								$arrayDetalleElemento['estado']=1;
	
								$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
								$this->db->trans_begin();
	
									$insert = $this->db->insert($table, $arrayDetalleElemento);
									$id = $this->db->insert_id();
	
									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
								}
							}
						}
					}
					

				}
				
 
			}
		}
 
		return $insert;
	}

	public function actualizarListaIniciativa($post)
	{
		
		$update = [
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		if(!empty($post['canal'])){$update['idCanal']= trim($post['canal']);}
		if(!empty($post['cliente'])){$update['idCliente']= trim($post['cliente']);}

		$where = [
			$this->tablas['listaIniciativa']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['listaIniciativa']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['listaIniciativa']['tabla'], 'id' => $post['idlst'] ];
		return $update;
	}

	public function deleteMasivoDetalleListaIniciativa($idLista)
	{
		$delete=null;
		$sql="
			DELETE {$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento where idListVisibilidadIniDet IN(
				SELECT idListVisibilidadIniDet from {$this->sessBDCuenta}.trade.list_visibilidadTradIniDet WHERE idListVisibilidadIni=$idLista
			);
		";
		$delete=$this->db->query($sql);
		if($delete){
			$sql="
				DELETE {$this->sessBDCuenta}.trade.list_visibilidadTradIniDet WHERE idListVisibilidadIni=$idLista
			";
			$delete=$this->db->query($sql);

			$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento", 'id' => arrayToString([ 'idListVisibilidadIni' => $idLista ]) ];
			$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet", 'id' => arrayToString([ 'idListVisibilidadIni' => $idLista ]) ];
		}
		return $delete;
	}

	public function actualizarMasivoListaIniciativa($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['listaDet']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] => $value['elemento_lista'],


				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['listaDet']['tabla'], $input, $this->model->tablas['listaDet']['id']);

		$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla']];
		return $update;
	}

	public function registrarListaIniciativa_HT($post)
	{

		$insert = [
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
			//'idGrupoCanal' => trim($post['idGrupoCanal']),
		];
		if (!empty($post['idGrupoCanal'])) {
			$insert['idGrupoCanal'] = $post['idGrupoCanal'];
		}
		if (!empty($post['fechaFin'])) {
			$insert['fecFin'] = $post['fechaFin'];
		}
		if (!empty($post['idCliente'])) {
			$insert['idCliente'] = $post['idCliente'];
		}
		if (!empty($post['idCanal'])) {
			$insert['idCanal'] = trim($post['idCanal']);
		}

		$insert = $this->db->insert($this->tablas['listaIniciativa']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => $this->tablas['listaIniciativa']['tabla'], 'id' => $this->insertId];
		return $insert;
	}

	public function guardarMasivoListaIniciativa($multiDataRefactorizada, $idLista)
	{
		$aSessTrack = [];

		//Pasar a la vista
		$new_array = array();
			$input = [];

			foreach($multiDataRefactorizada as $index => $row){
	
					$arrayDetalle=array();
					$arrayDetalle['idIniciativa'] = $row['iniciativa_lista'];
					$arrayDetalle['idListVisibilidadIni'] =  $idLista;
					$arrayDetalle['estado'] = 1;

				
	
					//validar existencia
					$rs = $this->db->get_where("{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet",$arrayDetalle)->result_array();
					if($rs!=null){
						if(count($rs) >=0){
							//si existe iniciativa agregar detalle elemento
							$idListDetalle=$rs[0]['idListVisibilidadIniDet'];

							$arrayDetalleElemento=array();
							$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
							$arrayDetalleElemento['idElementoVis']=$row['elemento_lista'];
							$arrayDetalleElemento['estado']=1;

							$rs_elementos = $this->db->get_where("{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento", $arrayDetalleElemento)->result_array();
							if( empty($rs_elementos)){
								$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
								$this->db->trans_begin();

									$insert = $this->db->insert($table, $arrayDetalleElemento);
									$id = $this->db->insert_id();

									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
								}
							}
							
						}else{
							//insertar la iniciativa
							$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet";
							$this->db->trans_begin();

								$insert = $this->db->insert($table, $arrayDetalle);
								$idListDetalle = $this->db->insert_id();
								$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $idListDetalle ];

							if ( $this->db->trans_status()===FALSE ) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								$this->aSessTrack[] = $aSessTrack;
	
								//detalle elemento


								$arrayDetalleElemento=array();
								$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
								$arrayDetalleElemento['idElementoVis']=$row['elemento_lista'];
								$arrayDetalleElemento['estado']=1;
	
								$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
								$this->db->trans_begin();

									$insert = $this->db->insert($table, $arrayDetalleElemento);
									$id = $this->db->insert_id();

									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
								}
							}
						}
					}else{
						//insertar la iniciativa
						$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet";
						$this->db->trans_begin();

							$insert = $this->db->insert($table, $arrayDetalle);
							$idListDetalle = $this->db->insert_id();
							$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $idListDetalle ];

						if ( $this->db->trans_status()===FALSE ) {
							$this->db->trans_rollback();
						} else {
							$this->db->trans_commit();
							$this->aSessTrack[] = $aSessTrack;

							//detalle elemento


							$arrayDetalleElemento=array();
							$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
							$arrayDetalleElemento['idElementoVis']=$row['elemento_lista'];
							$arrayDetalleElemento['estado']=1;

							$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
							$this->db->trans_begin();

								$insert = $this->db->insert($table, $arrayDetalleElemento);
								$id = $this->db->insert_id();

								$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

							if ( $this->db->trans_status()===FALSE ) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								$this->aSessTrack[] = $aSessTrack;
							}
						}
					}
			}
			
		
		return $insert;
	}









	public function getListasIniciativa_($post)
	{
		$filtros = '';
		if (!empty($post['id'])) $filtros .= " AND idLista = " . $post['id'];
		$sql = "
			SELECT 
				  idLista
				, CONVERT(VARCHAR(10),fecIni,103) fecIni  
				, CONVERT(VARCHAR(10),fecFin,103) fecFin
				, fecIni fecInicio
				, fecFin fecFinal
				, estado
			FROM 
				{$this->sessBDCuenta}.trade.master_listaElementos
			WHERE
				1=1
				{$filtros}
			ORDER BY estado DESC ,idLista DESC
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementos"];
		return $this->db->query($sql);
	}

	public function registrarListaModulacion($post)
	{

		$insert = [
			'FecIni' => trim($post['fechaInicio']),
		];
		if (!empty($post['fechaFin'])) {
			$insert['fecFin'] = $post['fechaFin'];
		}

		$insert = $this->db->insert("{$this->sessBDCuenta}.trade.master_listaElementos", $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementos", 'id' => $this->insertId];
		return $insert;
	}

	public function getListaElementosModulacion($post)
	{
		$sql = "
			SELECT 
				  idLista
				, idListaDet
				, idElementoVisibilidad
				, evt.nombre
				,t.nombre tipo
				, m.orden
			FROM 
				{$this->sessBDCuenta}.trade.master_listaElementosDet m
				JOIN trade.elementoVisibilidadTrad evt
					ON evt.idElementoVis = m.idElementoVisibilidad
				JOIN " . $this->tablas['tipoElemento']['tabla'] . " t ON t." . $this->tablas['tipoElemento']['id'] . " = evt.idTipoElementoVisibilidad
			WHERE 
				idLista='" . $post['id'] . "'
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementosDet"];
		return $this->db->query($sql);
	}

	public function actualizarListaModulacion($post)
	{
		$update = [
			'FecIni' => trim($post['fechaInicio']),
		];
		if (!empty($post['fechaFin'])) {
			$update['fecFin'] = $post['fechaFin'];
		}

		$where = [
			'idLista' => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update("{$this->sessBDCuenta}.trade.master_listaElementos", $update);

		$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementos", 'id' => $post['idlst']];
		return $update;
	}

	public function actualizarMasivoListaModulacion($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					'idListaDet' => $value['id'],
					'idElementoVisibilidad' => $value['elemento_lista'],
					'orden' => $value['orden_lista'],
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo("{$this->sessBDCuenta}.trade.master_listaElementosDet", $input, 'idLista');

		$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementosDet"];
		$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementosDet"];
		return $update;
	}

	public function guardarMasivoListaModulacion($multiDataRefactorizada, $idLista)
	{

		//Pasar a la vista
		$new_array = array();
		$repetidos = false;
		foreach ($multiDataRefactorizada as $index => $row) {
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where("{$this->sessBDCuenta}.trade.master_listaElementosDet", array('idLista' => $idLista, 'idElementoVisibilidad' => $row['elemento_lista']))->row_array();
			if ($rs != null) {
				if (count($rs) >= 1) {
					$repetidos = true;
				}
			}
		}
		$elementos =  count($new_array);

		if ($elementos > 0) {

			if ($elementos != count(array_unique($new_array))) {
				$repetidos = true;
			}
		}

		if ($repetidos == false) {

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {
					$input[] = [
						'idLista' => $idLista,
						'idElementoVisibilidad' => $value['elemento_lista'],
						'orden' => $value['orden_lista'],
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.master_listaElementosDet", $input);
			$this->aSessTrack[] = ['idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementosDet"];
		} else {
			$insert = 'repetido';
		}
		return $insert;
	}

	public function verificar_lista_modulacion($input = array())
	{
		$query = $this->db->select('idLista')
			->where($input)
			->get("{$this->sessBDCuenta}.trade.master_listaElementos");

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementos"];
		return $query->result_array();
	}

	public function insertar_lista_modulacion($input = array())
	{
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.master_listaElementos";
		$this->db->trans_begin();

		$insert = $this->db->insert($table, $input);
		$id = $this->db->insert_id();

		$aSessTrack = ['idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementos", 'id' => $id];

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function obtener_id_elemento($elemento)
	{
		$sql = "SELECT idElementoVis FROM trade.elementoVisibilidadTrad WHERE nombre LIKE '{$elemento}'";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.elementoVisibilidadTrad'];
		return $this->db->query($sql)->result_array();
	}

	public function verificar_lista_modulacion_detalle($input = array())
	{
		$query = $this->db->select('idListaDet')
			->where($input)
			->get("{$this->sessBDCuenta}.trade.master_listaElementosDet");

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_listaElementosDet"];
		return $query->result_array();
	}

	public function insertar_lista_modulacion_detalle($input = array())
	{
		$aSessTrack = [];
		$table = "{$this->sessBDCuenta}.trade.master_listaElementosDet";
		$this->db->trans_begin();

		$insert = $this->db->insert($table, $input);
		$id = $this->db->insert_id();

		$aSessTrack = ['idAccion' => 6, 'tabla' => $table, 'id' => $id];

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
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
			select DISTINCT c.idCuenta,c.nombre from  trade.usuario_historico uh 
			JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
			JOIN trade.cuenta c On c.idCuenta=p.idCuenta
			where uh.estado=1 
			and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
			{$filtros}
			";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
		return $this->db->query($sql);
	}

	public function obtenerCanalCuenta($post)
	{
		$filtros = "WHERE 1 = 1";
		if (!empty($post['idCuenta'])) $filtros .= " AND ch.idCuenta= " . $post['idCuenta'];

		$sql = "
		SELECT DISTINCT
			gc.idGrupoCanal,
			gc.nombre as 'grupoCanal',
			ca.idCanal
			,ca.nombre
			,ch.idCuenta
		FROM 
			" . getClienteHistoricoCuenta() . " ch
			JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			JOIN trade.canal ca
				ON ca.idCanal=sn.idCanal 
			JOIN trade.grupoCanal gc 
			    ON gc.idGrupoCanal=ca.idGrupoCanal
			{$filtros}
		ORDER BY gc.idGrupoCanal
		";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => getClienteHistoricoCuenta()];
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

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.proyecto'];
		return $this->db->query($sql);
	}
	public function getSegCliente($post)
	{
		$filtro = '';
		if (!empty($post['idCanal'])) {
			$filtro .= 'AND seg.idCanal=' . $post['idCanal'];
		}
		if (!empty($post['idProyecto'])) {
			$filtro .= 'AND ch.idProyecto=' . $post['idProyecto'];
		}
		if (!empty($post['idCuenta'])) {
			$filtro .= 'AND ch.idCuenta=' . $post['idCuenta'];
		}
		$sql = "
		SELECT DISTINCT
			c.idCliente
			,c.razonSocial
		FROM trade.cliente c
		JOIN " . getClienteHistoricoCuenta() . " ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 1=1 {$filtro}";

		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio'];
		return $this->db->query($sql);
	}
}
