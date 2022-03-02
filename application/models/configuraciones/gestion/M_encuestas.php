<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_encuestas extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'encuesta' => ['tabla' => "{$this->sessBDCuenta}.trade.encuesta", 'id' => 'idEncuesta'],
			'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_encuesta", 'id' => 'idListEncuesta'],
			'listaDet' => ['tabla'=>"{$this->sessBDCuenta}.trade.list_encuestaDet",'id'=>'idListEncuestaDet'],
			'pregunta' => ['tabla'=>"{$this->sessBDCuenta}.trade.encuesta_pregunta",'id'=>'idPregunta'],
			'alternativa'=> ['tabla'=>"{$this->sessBDCuenta}.trade.encuesta_alternativa",'id'=>'idAlternativa'],
			'alternativaOpcion'=> ['tabla'=>"{$this->sessBDCuenta}.trade.encuesta_alternativa_opcion",'id'=>'idAlternativaOpcion'],
			'tipoPregunta'=> ['tabla'=>'master.tipoPregunta','id'=>'idTipoPregunta'],
			
		];
	}
	//SECCION ALTERNATIVAS

	public function getAlternativas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idPregunta = " . $post['id'];
		}

		$sql = "
				SELECT 
				ea.*
				FROM
				{$this->sessBDCuenta}.trade.encuesta_alternativa ea
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_alternativa" ];
		return $this->db->query($sql);
	}
	//SECCION PREGUNTAS

	public function getPreguntas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND ep.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idEncuesta = " . $post['id'];
		}

		$sql = "
				SELECT 
				ep.*
				,tp.nombre tipo
				,epf.foto AS imagenReferencia
				FROM
				{$this->sessBDCuenta}.trade.encuesta_pregunta ep
				JOIN master.tipoPregunta tp ON tp.idTipoPregunta = ep.idTipoPregunta
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta_foto epf ON epf.idPregunta = ep.idPregunta
					AND epf.estado = 1
				{$filtros}

				order by ep.orden asc
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_pregunta" ];
		return $this->db->query($sql);
	}

	public function getPregunta($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idPregunta = " . $post['id'];
		}

		$sql = "
				SELECT 
				ep.*
				,tp.nombre tipo
				FROM
				{$this->sessBDCuenta}.trade.encuesta_pregunta ep
				JOIN master.tipoPregunta tp
				ON tp.idTipoPregunta = ep.idTipoPregunta
				{$filtros}

				order by ep.orden asc
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_pregunta" ];
		return $this->db->query($sql);
	}

	public function getTiposPreguntas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= "";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idEncuesta = " . $post['id'];
		}

		$sql = "
				SELECT 
				* 
				FROM master.tipoPregunta
				$filtros

			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.tipoPregunta' ];
		return $this->db->query($sql);
	}

	public function actualizarPreguntas($idPregeunta,$params)
	{
		$update = [
			'idTipoPregunta' => trim($params['idTipoPregunta']),
			'nombre' => trim($params['nombre']),
			'orden' => trim($params['orden']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['pregunta']['id'] => $idPregeunta,
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['pregunta']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['pregunta']['tabla'], 'id' => $idPregeunta ];
		return $update;
	}

	public function guardarMasivoPreguntas($multiDataRefactorizada, $idEncuesta, $fotos = [])
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idEncuesta' => $idEncuesta,
					'idTipoPregunta' =>$value['tipoPregunta'],
					'nombre'=>$value['textoPregunta'],
					'orden'=>$value['txtOrden'],
					'estado'=>$value['estadoPregunta'],
					'foto' => isset($value['chkFoto'])? 'true' : 'false',
					'obligatorio'=>isset($value['chkObligatorio'])? 'true' : 'false',
					'flagFotoObligatorio'=>!empty($value['chkFotoObligatorio'])? true : false,

				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_encuestas->tablas['pregunta']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_encuestas->tablas['pregunta']['tabla'] ];
		return $insert;
	}

	public function guardarMasivoListaEncuesta($multiDataRefactorizada, $idLista)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idListEncuesta' => $idLista,
					'idEncuesta' =>$value['sl_encuesta'],
					'obligatorio' =>$value['sl_obligatorio'],
					'flagFotoObligatorio' =>$value['sl_fotoObligatorio'],
					'flagFotoMultiple' =>$value['sl_fotoMultiple'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_encuestas->tablas['listaDet']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_encuestas->tablas['listaDet']['tabla'] ];
		return $insert;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{

		//Pasar a la vista
		$new_array = array();
        $repetidos = false;
        $insert ='repetido';

		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->tablas['listaDet']['tabla'],array($this->tablas['lista']['id']=>$idLista,$this->tablas['encuesta']['id']=>$row['elemento_lista']))->row_array();
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
						$this->tablas['lista']['id'] => $idLista,
						$this->tablas['encuesta']['id'] =>$value['elemento_lista'],
						"obligatorio" => $value['obligatorio']
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->tablas['listaDet']['tabla'], $input);
			$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->tablas['listaDet']['tabla'] ];
		
		}

		return $insert;
	}
	public function actualizarMasivoLista($insertMasivo, $deleteMasivo)
	{

		//Pasar a la vista

		if(!empty($deleteMasivo)){
			$this->db->where_in('idListEncuesta', $deleteMasivo);
			$this->db->delete($this->m_encuestas->tablas['listaDet']['tabla']);
		}

		
		return $this->db->insert_batch($this->m_encuestas->tablas['listaDet']['tabla'],$insertMasivo);
		
		
		
	}

	public function actualizarMasivoListaEncuesta($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_encuestas->tablas['listaDet']['id'] => $value['id'],
					'idEncuesta' =>$value['sl_encuesta'],
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_encuestas->tablas['listaDet']['tabla'], $input, $this->m_encuestas->tablas['listaDet']['id']);
		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->m_encuestas->tablas['listaDet']['tabla'] ];
		return $update;
	}

	public function actualizarMasivoPreguntas($multiDataRefactorizada, $fotos = [])
	{
		$input = [];
	
		foreach ($multiDataRefactorizada as $key => $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_encuestas->tablas['pregunta']['id'] => $value['id'],
					'idTipoPregunta' =>$value['tipoPregunta'],
					'nombre'=>$value['textoPregunta'],
					'orden'=>$value['txtOrden'],
					'estado'=>$value['estadoPregunta'],
					'foto' => isset($value['chkFoto'])? 'true' : 'false',
					'obligatorio'=>isset($value['chkObligatorio'])? 'true' : 'false',
					'flagFotoObligatorio'=>!empty($value['chkFotoObligatorio'])? true : false,
				];
				if(!empty($fotos[$key])){

					$updateArchivos[] = [
						$this->m_encuestas->tablas['pregunta']['id'] => $value['id'],
						'fecFin' =>  getFechaActual(),
						'estado' => false,
					];

					$inputArchivos[] = [
						$this->m_encuestas->tablas['pregunta']['id'] => $value['id'],
						'foto' => $fotos[$key],
						'fecIni' => getFechaActual(),
						'estado' => true,
					];
				}
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_encuestas->tablas['pregunta']['tabla'], $input, $this->m_encuestas->tablas['pregunta']['id']);

		//Imagenes de la pregunta
		if(!empty($updateArchivos)) $updateArchivos =  $this->actualizarMasivo("{$this->sessBDCuenta}.trade.encuesta_pregunta_foto", $updateArchivos, $this->m_encuestas->tablas['pregunta']['id']);
		if(!empty($inputArchivos)) $insertArchivos = $this->db->insert_batch("{$this->sessBDCuenta}.trade.encuesta_pregunta_foto", $inputArchivos);
		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->m_encuestas->tablas['pregunta']['tabla'] ];
		return $update;
	}

	public function guardarMasivoAlternativas($multiDataRefactorizada, $idPregunta)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idPregunta' => $idPregunta,
					'nombre'=>$value['textoAlternativa'],
					'estado'=>$value['estadoAlternativa'],
					'foto'=>isset($value['chkFoto'])? 'true' : 'false',
					'flagFotoObligatorio'=>!empty($value['chkFotoObligatorio'])? true : false


				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_encuestas->tablas['alternativa']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_encuestas->tablas['alternativa']['tabla'] ];
		return $insert;
	}

	public function actualizarMasivoAlternativas($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_encuestas->tablas['alternativa']['id'] => $value['id'],
					'nombre'=>$value['textoAlternativa'],
					'estado'=>$value['estadoAlternativa'],
					'foto'=>isset($value['chkFoto'])? 'true' : 'false',
					'flagFotoObligatorio'=>!empty($value['chkFotoObligatorio'])? true : false
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_encuestas->tablas['alternativa']['tabla'], $input, $this->m_encuestas->tablas['alternativa']['id']);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->m_encuestas->tablas['alternativa']['tabla'] ];
		return $update;
	}
	
	// SECCION ENCUESTAS
	public function getEncuestas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idEncuesta = " . $post['id'];
			if (!empty($post['idCuenta'])) $filtros .= " AND c.idCuenta = " . $post['idCuenta'];
			if (!empty($post['cuentas'])) $filtros .= " AND c.idCuenta  IN ( " . $post['cuentas'] .")";
		}

		$sql = "
				SELECT e.*,
				c.razonSocial, 
				c.nombre cuenta,
				c.nombreComercial 
				FROM {$this->sessBDCuenta}.trade.encuesta e
				JOIN trade.cuenta c
				ON e.idCuenta = c.idCuenta
				{$filtros}
				AND c.estado = 1
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta" ];
		return $this->db->query($sql);
	}

	public function getIdEncuesta($encuesta){
		$sql = $this->db->get_where("{$this->sessBDCuenta}.trade.encuesta",array('nombre'=>$encuesta));

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta" ];
		return ($sql);

	}

	public function registrarEncuesta($post)
	{
		if($post['foto'] == 2){
			$post['foto'] = 0;
		}
		$insert = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta']),
			'foto' => trim($post['foto']),
			'fechaCreacion' => getActualDateTime(),
		];
		$insert = $this->db->insert($this->tablas['encuesta']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['encuesta']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function registrarLista($post)
	{

		$insert = [
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['cliente_form'])){$insert['idCliente']=$post['cliente_form'];}
		if(!empty($post['grupoCanal_form'])){$insert['idGrupoCanal']=$post['grupoCanal_form'];}
		if(!empty($post['canal_form'])){$insert['idCanal']=$post['canal_form'];}
		if(!empty($post['tipoUsuario_form'])){$insert['idTipoUsuario']=$post['tipoUsuario_form'];}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function registrarListaDetalle($idLista,$idEncuesta)
	{

		$insert = [
			'idListEncuesta' => $idLista,
			'idEncuesta' => $idEncuesta,
		];

		$encuesta_repetida = $this->db->get_where($this->tablas['listaDet']['tabla'],array('idListEncuesta'=>$idLista,'idEncuesta'=>$idEncuesta))->row_array();

		if(count($encuesta_repetida)<1){
			$insert = $this->db->insert($this->tablas['listaDet']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();

			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $this->insertId ];
		}else{
			$insert = false;
		}

		return $insert;
	}

	public function actualizarEncuesta($post)
	{
		if($post['foto'] == 2){
			$post['foto'] = 0;
		}
		
		$update = [
			'nombre' => trim($post['nombre']),
			'foto' => trim($post['foto']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['encuesta']['id'] => $post['idEncuesta']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['encuesta']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['encuesta']['tabla'], 'id' => $post['idEncuesta'] ];
		return $update;
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

	public function checkNombreEncuestaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idEncuesta'])) $where .= " AND " . $this->tablas['encuesta']['id'] . " != " . $post['idEncuesta'];
		return $this->verificarRepetido($this->tablas['encuesta']['tabla'], $where);
	}

	// SECCION LISTA
	public function getListas($post)
	{
		$filtros = " ";
		if (!empty($post['id'])) $filtros .= " AND lst.idListEncuesta = " . $post['id'];
		if (!empty($post['ids'])) $filtros .= " AND lst.idListEncuesta IN (" . $post['ids'].")";

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
					  lst.idListEncuesta
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
					, e.idEncuesta
					, e.nombre encuesta
				FROM {$this->sessBDCuenta}.trade.list_encuesta lst
				LEFT JOIN {$this->sessBDCuenta}.trade.list_encuestaDet lstd	ON lstd.idListEncuesta=lst.idListEncuesta
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta=lstd.idEncuesta
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

	public function getListaEncuestas($post)
	{
	
		$sql = "
				SELECT 
				e.*
				,lstd.idListEncuestaDet
				,lstd.obligatorio
				,lstd.flagFotoMultiple
				,lstd.flagFotoObligatorio AS flagFotoObligatorioEncuesta
				FROM 
				{$this->sessBDCuenta}.trade.encuesta e
				JOIN {$this->sessBDCuenta}.trade.list_encuestaDet lstd ON lstd.idEncuesta = e.idEncuesta
				WHERE lstd.idListEncuesta = ".$post['id'].";
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_encuestaDet" ];
		return $this->db->query($sql);
	}

	public function registrarProyecto($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['encuesta']),
			'fecIni' => trim($post['fechaInicio']),
			'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
		];

		$insert = $this->db->insert($this->tablas['proyecto']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['proyecto']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function actualizarProyecto($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['encuesta']),
			'fecIni' => trim($post['fechaInicio']),
			'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['proyecto']['id'] => $post['idProyecto']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['proyecto']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['proyecto']['tabla'], 'id' => $post['idProyecto'] ];
		return $update;
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

	public function actualizarLista_HT($update)
	{
		$update_batch = $this->db->update_batch($this->tablas['lista']['tabla'], $update,'idListEncuesta');

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $update_batch;
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
	public function validar_elementos_unicos_HT($post){
		$elementos = array();

		foreach($post as $index => $value){
			$elementos[$index] = $value['encuesta'];
		}

		if(count($elementos) != count(array_unique($elementos))){
			return false;
		}else{
			return true;
		}
	}

	public function registrar_elementos_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_encuestas->tablas['encuesta']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_encuestas->tablas['encuesta']['tabla'] ];
		return $insert;
	}
	

	//SECCION PREGUNTAS HIJO

	public function getPreguntasHijo($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND ep.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ep.idAlternativaPadre = " . $post['id'];
		}

		$sql = "
				SELECT 
				ep.*
				FROM
				{$this->sessBDCuenta}.trade.encuesta_pregunta ep
				$filtros
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_pregunta" ];
		return $this->db->query($sql);
	}

	public function getAlternativa($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ea.idAlternativa = " . $post['id'];
			if (!empty($post['idAlternativa'])) $filtros .= " AND ea.idAlternativa = " . $post['idAlternativa'];
		}

		$sql = "
				SELECT 
				ea.*,
				ep.idEncuesta
				FROM
				{$this->sessBDCuenta}.trade.encuesta_alternativa ea
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ep.idPregunta=ea.idPregunta
				{$filtros}

			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_alternativa" ];
		return $this->db->query($sql);
	}
	public function getAlternativasOpciones($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['idAlternativaOpcion'])) $filtros .= " AND eao.idAlternativaOpcion = " . $post['idAlternativaOpcion'];
			if (!empty($post['idPregunta'])) $filtros .= " AND ep.idPregunta = " . $post['idPregunta'];
		}

		$sql = "
				SELECT 
				eao.*,
				ep.idEncuesta
				FROM
				{$this->sessBDCuenta}.trade.encuesta_alternativa_opcion eao
				LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ep.idPregunta=eao.idPregunta
				{$filtros}
				ORDER BY eao.orden asc

			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_alternativa" ];
		return $this->db->query($sql);
	}

	public function actualizarPreguntaHijo($post)
	{

		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_encuestas->tablas['pregunta']['id'] => $value['id'],
					'idTipoPregunta' =>$value['tipoPregunta'],
					'nombre'=>$value['textoPregunta'],
					'orden'=>$value['txtOrden'],
					'estado'=>$value['estadoPregunta'],
					'obligatorio'=>isset($value['chkObligatorio'])? 'true' : 'false'
					
				];
				// if(!empty($value['chkObligatorio'])){$input['obligatorio'] == $value['chkObligatorio'];}
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_encuestas->tablas['pregunta']['tabla'], $input, $this->m_encuestas->tablas['pregunta']['id']);
		return $update;

		$update = [
			'idAlternativaPadre' => trim($post['idAlternativaPadre'])
		];

		$where = [
			$this->tablas['pregunta']['id'] => $post['idPregunta']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['pregunta']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['pregunta']['tabla'], 'id' => $post['idPregunta'] ];
		return $update;
	}


	public function actualizarMasivoPreguntaHijo($multiDataRefactorizada, $idAlternativa, $post)
	{
		$result = [];
		if (!empty($post['idPregunta'])) {
			$update = [
				'idAlternativaPadre' => $idAlternativa
			];

			$where = [];

			if (!is_array($post['idPregunta'])) {
				$post['idPregunta'] = [$post['idPregunta']];
			}

			foreach ($post['idPregunta'] as $k => $v) {
				$where = [
					$this->tablas['pregunta']['id'] => $v
				];

				$this->db->where($where);
				$result['update'] = $this->db->update($this->tablas['pregunta']['tabla'], $update);
			}

			$this->aSessTrack[] = ['idAccion' => 7, 'tabla' => $this->tablas['pregunta']['tabla'], 'id' => $post['idPregunta'][0]];
		}
		return $result['update'];
	}

	public function deleteMasivoPreguntaHijo($multiDataRefactorizada,$idAlternativa)
	{
		$update=true;
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
				$update = [
					'idAlternativaPadre' => NULL
				];
		
				$where = [
					'idPregunta' => $value
				];

				$this->db->where($where);
				$update = $this->db->update($this->tablas['pregunta']['tabla'], $update);

				$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['pregunta']['tabla'], 'id' => $value ];
		}
		return $update;
	}
	
	
	public function obtenerCanalCuenta($post){
		$idProyecto = $this->sessIdProyecto;

		$filtro = "";
			$filtro .= getPermisos('grupoCanal', $idProyecto);

			if( !empty($idProyecto) ) $filtro .= " AND pgc.idProyecto = ".$idProyecto;
			if( !empty($input['idGrupoCanal']) ) $filtro .= " AND gca.idGrupoCanal = ".$input['idGrupoCanal'];

		$sql = "
			SELECT
				gca.idGrupoCanal,
				gca.nombre grupoCanal,
				ca.nombre,
				ca.idCanal,
				py.idCuenta
			FROM trade.grupoCanal gca
			JOIN trade.proyectoGrupoCanal pgc ON  gca.idGrupoCanal = pgc.idGrupoCanal AND pgc.estado = 1
			JOIN trade.canal ca	ON ca.idGrupoCanal = pgc.idGrupoCanal 
			JOIN trade.proyecto py ON py.idProyecto = pgc.idProyecto AND py.estado = 1
			WHERE gca.estado = 1 {$filtro}
			ORDER BY gca.nombre
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
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


	public function getTiposUsuario()
	{
		$sql = "
				select 
					idTipoUsuario,nombre
				from trade.usuario_tipo
				where estado=1
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_tipo' ];
		return $this->db->query($sql);
	}

	public function getTipoPregunta()
	{
		$sql = "
				select idTipoPregunta,nombre 
				from master.tipoPregunta 
				where estado=1
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.tipoPregunta' ];
		return $this->db->query($sql);
	}

	public function registrarEncuestaPregunta($post)
	{
		$insert = [
			'idEncuesta' => trim($post['idEncuesta']),
			'nombre' => trim($post['nombre']),
			'idTipoPregunta' => trim($post['idTipoPregunta']),
			'orden' => trim($post['orden']),
			'obligatorio' => trim($post['obligatorio']),
			'fechaCreacion' => getActualDateTime()
		];
		$insert = $this->db->insert($this->tablas['pregunta']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['pregunta']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function registrarPreguntaAlternativa($post)
	{
		$insert = [
			'idPregunta' => trim($post['idPregunta']),
			'nombre' => trim($post['nombre']) 
		];
		$insert = $this->db->insert($this->tablas['alternativa']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['alternativa']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}


	public function getGrupoCanales($post = 'nulo')
	{
			$filtros = " AND gc.estado = 1";
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
	public function actualizarMasivoAlternativasOpciones($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_encuestas->tablas['alternativaOpcion']['id'] => $value['id'],
					'nombre'=>$value['textoAlternativaOpcion'],
					'estado'=>$value['estadoAlternativaOpcion'],
					'orden'=>$value['txtOrden'],
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_encuestas->tablas['alternativaOpcion']['tabla'], $input, $this->m_encuestas->tablas['alternativaOpcion']['id']);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->m_encuestas->tablas['alternativaOpcion']['tabla'] ];
		return $update;
	}
	public function guardarMasivoAlternativasOpciones($multiDataRefactorizada, $idPregunta)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idPregunta' => $idPregunta,
					'nombre'=>$value['textoAlternativaOpcion'],
					'estado'=>$value['estadoAlternativaOpcion'],
					'orden'=>$value['txtOrden'],

				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_encuestas->tablas['alternativaOpcion']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_encuestas->tablas['alternativaOpcion']['tabla'] ];
		return $insert;
	}
	
	public function registrarPreguntaOpciones($insert)
	{
		
		$insert = $this->db->insert_batch($this->tablas['alternativaOpcion']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['alternativaOpcion']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

}
