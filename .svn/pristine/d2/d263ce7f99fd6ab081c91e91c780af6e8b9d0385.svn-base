<?php defined('BASEPATH') or exit('No direct script access allowed');

class Visibilidad extends MY_Controller
{
	var $htmlNoResultado = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/auditoria/M_visibilidad', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarLista' => 'Actualizar Lista de Visibilidad',
			'registrarLista' => 'Registrar Lista de Visibilidad',
			'masivoLista' => 'Guardar Masivo Lista de Visibilidad',
			
			'actualizarListaIniciativa' => 'Actualizar Lista de Iniciativa',
			'registrarListaIniciativa' => 'Registrar Lista de Iniciativa',
			'masivoListaIniciativa' => 'Guardar Masivo Lista de Iniciativa',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/auditoria/vistas_generales/';

		$this->html = [
			'listaVisibilidad' => [
				'tabla' => $this->carpetaHtml .  'tablaListaVisibilidad',
				'new' => $this->carpetaHtml .  'formNewListaVisibilidad',
				'update' => $this->carpetaHtml .  'formUpdateListaVisibilidad',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaVisibilidad',
			],
			'listaIniciativa' => [
				'tabla' => $this->carpetaHtml .  'tablaListaIniciativa',
				'new' => $this->carpetaHtml .  'formNewListaIniciativa',
				'update' => $this->carpetaHtml .  'formUpdateListaIniciativa',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaIniciativa',
			],
		];
	}

	public function index()
	{
		$this->aSessTrack = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
				'assets/libs/dataTables-1.10.20/datatables',
				'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
				'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			];
		$config['js']['script'] = [
				'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
				'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
				'assets/libs/handsontable@7.4.2/dist/languages/all',
				'assets/libs/handsontable@7.4.2/dist/moment/moment',
				'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
				'assets/custom/js/core/HTCustom',
				'assets/custom/js/core/gestion',
				'assets/custom/js/configuraciones/gestion/auditoria/visibilidad'
			];

		$config['nav']['menu_active'] = '134';
		$config['data']['icon'] = 'fas fa-share-alt';
		$config['data']['title'] = 'Auditoria Visibilidad';
		$config['data']['message'] = 'Gestión';
		$config['view'] = 'modulos/configuraciones/gestion/auditoria/visibilidad/index';

		$this->view($config);
	}

	// public function cambiarEstado()
	// {
	// 	$result = $this->result;
	// 	$result['msg']['title'] = $this->titulo['cambiarEstado'];

	// 	$post = json_decode($this->input->post('data'), true);

	// 	$seccionActivo = $post['seccionActivo'];
	// 	$ids = $post['ids'];
	// 	$estado = ($post['estado'] == 0) ? 1 : 0;

	// 	switch ($seccionActivo) {
	// 		case 'ListaModulacion':
	// 			$tabla = $this->model->tablas['modulacion']['tabla'];
	// 			$idTabla = $this->model->tablas['modulacion']['id'];
	// 			break;
	// 		case 'Elemento':
	// 			$tabla = $this->model->tablas['lista']['tabla'];
	// 			$idTabla = $this->model->tablas['lista']['id'];
	// 			break;
	// 		case 'Lista':
	// 			$tabla = $this->model->tablas['lista']['tabla'];
	// 			$idTabla = $this->model->tablas['lista']['id'];
	// 			break;
	// 	}

	// 	$update = [];
	// 	$actualDateTime = getActualDateTime();
	// 	if( is_array($ids)){
	// 		foreach ($ids as $id) {
	// 			$update[] = [
	// 				$idTabla => $id,
	// 				'estado' => $estado,
	// 				'fechaModificacion' => $actualDateTime
	// 			];
	// 		}
	// 	}else{
	// 		$update[] = [
	// 			$idTabla => $ids,
	// 			'estado' => $estado,
	// 			'fechaModificacion' => $actualDateTime
	// 		];
	// 	}

	// 	$cambioEstado = $this->model->actualizarMasivo($tabla, $update, $idTabla);

	// 	if (!$cambioEstado) {
	// 		$result['result'] = 0;
	// 		$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
	// 	} else {
	// 		$result['result'] = 1;
	// 		$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
	// 	}

	// 	$this->aSessTrack = $this->model->aSessTrack;
	// 	echo json_encode($result);
	// }

	// SECCIÓN LISTA
	public function getTablaLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListas($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['listaVisibilidad']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewLista()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$params=array();
		$params['id']=$this->session->userdata('idProyecto');
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$post['idProyecto']=$this->session->userdata('idProyecto');
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes($params)->result_array();
		$dataParaVista['lista_elementos'] =  array();

		
		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;


		// $sl_clientes = $this->load->view($this->html['listaVisibilidad']['clientes'], $dataParaVista, true);
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaVisibilidad']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getClientesProyecto(){
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$dataParaVista['clientes'] = $this->model->getClientes($post)->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaVisibilidad']['clientes'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
	}

	public function getElementoLista(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getElementos($post)->row_array();
		$marca = $this->model->getMarcas($post)->row_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$html = "";
			$html .= "<tr id='fila_temporal_encuesta'>";
				$html .= "<td ><i class='fas fa-trash' id='eliminar_encuesta'></i></td>";
				$html .= "<td><input  readonly='readonly' style='border:none;' class ='form-control' id='elemento_".$data[$this->model->tablas['elemento']['id']]."' name='elemento_".$data[$this->model->tablas['elemento']['id']]."' value='".$data['nombre']."'></td>";
			$html .= "</tr>";
			$result['data']['html'] = $html;
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post=[];
		$post['idProyecto']=$this->session->userdata('idProyecto');
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaVisibilidad']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function registrarLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			//'canal' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
			//'grupoCanal' => ['selectRequerido'],
		];

		$elementosAValidarMulti = [
			'elemento_lista'=>['selectRequerido']
		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['idProyecto']=$this->session->userdata('idProyecto');
		$registro = $this->model->registrarLista($post);

		$idLista = $this->db->insert_id();

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['listaDet']['tabla'], $this->model->tablas['listaDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if($insert == 'repetido'){
					$this->db->trans_rollback();
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
				}
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$idLista = $post['idlst'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;
		
		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
		];
		$elementosAValidarMulti = [
			'elemento_lista'=>['selectRequerido']

		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);

		
		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;
		
		
		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->actualizarLista($post);

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['listaDet']['tabla'], $this->model->tablas['listaDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');

				if($insert == 'repetido'){
					$this->db->trans_rollback();
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
				}
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;		
		echo json_encode($result);
	}

	public function getFormCargaMasivaLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = [];
		$post['idProyecto']=$this->session->userdata('idProyecto');
		$gruposCanal = $this->model->getGrupoCanales($post)->result_array();
        $canales = $this->model->getCanales($post)->result_array();

        $clientes = $this->model->getClientes()->result_array();
        $elementos = $this->model->getElementos()->result_array();

		//REFACTORIZANDO DATA
		$gruposCanalRefactorizado = [];
		foreach ($gruposCanal as $row) {
			if (!in_array($row['nombre'], $gruposCanalRefactorizado)) $gruposCanalRefactorizado[] = $row['nombre'];
		}
        $gruposCanal = !empty($gruposCanalRefactorizado) ? $gruposCanalRefactorizado : [' '];
        
		$canalesRefactorizado = [];
		foreach ($canales as $row) {
			if (!in_array($row['nombre'], $canalesRefactorizado)) $canalesRefactorizado[] = $row['nombre'];
		}
        $canales = !empty($canalesRefactorizado) ? $canalesRefactorizado : [' '];
        
		$clientesRefactorizado = [];
		foreach ($clientes as $row) {
			if (!in_array($row['idCliente'], $clientesRefactorizado)) $clientesRefactorizado[] = $row['idCliente'];
		}
        $clientes = !empty($clientesRefactorizado) ? $clientesRefactorizado : [' '];
        
		$elementosRefactorizado = [];
		foreach ($elementos as $row) {
			if (!in_array($row['idElementoVis'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['idElementoVis'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
				['idLista' => null
                , 'grupoCanal' => null
                , 'canal' => null 
                , 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
			'headers' => ['Id Lista'
                , 'Grupo Canal'
                , 'Canal'
                , 'ID Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'grupoCanal', 'type' => 'myDropdown_grupoCanal', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown_canal', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'idCliente', 'type' => 'myDropdown', 'placeholder' => 'ID Cliente', 'source' => $clientes],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];
        
		$HT[1] = [
			'nombre' => 'Elemento',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Id Elemento'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementos ,'strict'=>true],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['listaVisibilidad']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }

	public function guardarCargaMasivaLista(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
        
        array_pop($elementos);

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
 
		$idCuenta=$this->session->userdata('idCuenta');

		$listasParams['grupos'][0] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' => 'idGrupoCanal'];
		$listasParams['grupos'][1] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		//$listasParams['grupos'][3] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);

		if(!$listas_unicas){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que todas las listas tengan un ID único'));

			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
        foreach($listas as $index => $value){

	
			$listasInsertadas = [];
			$multiDataRefactorizada = [] ;

			/*if(empty($value['idGrupoCanal'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Grupo Canal.<br> Lista N°: '.$value['idLista']));
				goto responder;
			}*/
            if(empty($value['fechaInicio'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe registrar una fecha de Inicio.<br> Lista N°: '.$value['idLista']));
		        goto responder;
            }
            if(!empty($value['fechaFin'])){
                $fechaInicio = strtotime(str_replace('/','-',$value['fechaInicio']));
                $fechaFin = strtotime(str_replace('/','-',$value['fechaFin']));

               
                if($fechaFin < $fechaInicio){
                    $result['result'] = 0;
                    $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'La fecha Fin no puede ser menor a la fecha Inicio.<br> Lista N°: '.$value['idLista']));
                    goto responder;
                }
            }
			$value['idProyecto']=$this->session->userdata('idProyecto');
            $rs = $this->model->registrarLista_HT($value);
            $idLista = $this->db->insert_id();
            
            if(!$rs){
                $insertMasivo = false;
                break;
            }

			foreach($elementos as $row){

                if($row['idLista'] == $value['idLista']){
                    $multiDataRefactorizada[] = [
						//'elemento_lista' => $row[$this->model->tablas['elemento']['id']]
						'elemento_lista' => $row['elemento_lista']
                    ];

                }
			}
            $insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista);
			
		}

		if (!$insertMasivo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }

	//LISTA INICIATIVA
	public function getTablaListaIniciativa()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListasIniciativa($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewListaIniciativa()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['elementos'] = $this->model->getIniciativasElementos()->result_array();
		$dataParaVista['iniciativas'] = $this->model->getIniciativas($params)->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($params)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['lista_elementos'] =  array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;
		
		// $sl_clientes = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);
		$class = 'formNewLista';
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function registrarListaIniciativa()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;


		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
			//'grupoCanal' => ['selectRequerido'],
		];

		$elementosAValidarMulti = [
			// 'elemento_lista'=>['selectRequerido']

		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$post['proyecto']=$this->session->userdata('idProyecto');
		$registro = $this->model->registrarListaIniciativa($post);

		$idLista = $this->db->insert_id();

		$registro_detalle = $this->model->registrarListaIniciativaDet($post,$idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if($insert == 'repetido'){
					$this->db->trans_rollback();
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
				}
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateListaIniciativa()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['elementos'] = $this->model->getIniciativasElementos()->result_array();
		$dataParaVista['iniciativas'] = $this->model->getIniciativas($params)->result_array();
		$dataParaVista['data'] = $this->model->getListasIniciativa($post)->row_array();
		if(!empty($dataParaVista['data']['idCanal'])) $dataParaVista['clientes'] = $this->model->getSegCliente($dataParaVista['data'])->result_array();
		
		$dataParaVista['lista_elementos'] =  $this->model->getListasIniciativaElementos($post)->result_array();

		$post='';
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($params)->result_array();
		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();

		$class = 'formUpdateLista';
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$dataParaVista['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarListaIniciativa()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$idLista = $post['idlst'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;
		
		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
			//'grupoCanal' => ['requerido'],
		];
		$elementosAValidarMulti = [
			// 'elemento_lista'=>['selectRequerido']

		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);

		
		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;
		
		
		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->actualizarListaIniciativa($post);

		//BORRAR
		$delete = $this->model->deleteMasivoDetalleListaIniciativa($idLista);

		$registro_detalle = $this->model->registrarListaIniciativaDet($post,$idLista);

		//UPDATE
		//$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
		//INSERT
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');

				if($insert == 'repetido'){
					$this->db->trans_rollback();
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
				}
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

    public function getFormCargaMasivaListaIniciativa()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

		$gruposCanal = $this->model->getGrupoCanales()->result_array();
        $canales = $this->model->getCanales()->result_array();
		$post = '';
        // $clientes = $this->model->getClientes()->result_array();
		$clientes = [];

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
        $iniciativas = $this->model->getIniciativas($params)->result_array();

		//REFACTORIZANDO DATA
		$gruposCanalRefactorizado = [];
		foreach ($gruposCanal as $row) {
			if (!in_array($row['nombre'], $gruposCanalRefactorizado)) $gruposCanalRefactorizado[] = $row['nombre'];
		}
        $gruposCanal = !empty($gruposCanalRefactorizado) ? $gruposCanalRefactorizado : [' '];
        
		$canalesRefactorizado = [];
		foreach ($canales as $row) {
			if (!in_array($row['nombre'], $canalesRefactorizado)) $canalesRefactorizado[] = $row['nombre'];
		}
        $canales = !empty($canalesRefactorizado) ? $canalesRefactorizado : [' '];
        
		// $clientesRefactorizado = [];
		// foreach ($clientes as $row) {
		// 	if (!in_array($row['idCliente'], $clientesRefactorizado)) $clientesRefactorizado[] = $row['idCliente'];
		// }
        // $clientes = !empty($clientesRefactorizado) ? $clientesRefactorizado : [' '];
        
		$elementosRefactorizado = [];
		foreach ($iniciativas as $row) {
			if (!in_array($row['nombre'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['nombre'];
		}
		$iniciativas = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		$elementosIniciativa = [];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
				['idLista' => null
                , 'grupoCanal' => null
                , 'canal' => null 
                , 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
			'headers' => ['Id Lista'
                , 'Grupo Canal'
                , 'Canal'
                , 'Id Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'grupoCanal', 'type' => 'myDropdown', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'idCliente', 'type' => 'numeric', 'placeholder' => 'ID Cliente', 'source' => $clientes/*, 'strict'=> false*/],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];
        
		$HT[1] = [
			'nombre' => 'Iniciativas',
			'data' => [
                ['idLista' => null
                , 'iniciativa_lista' => null
				 , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Iniciativa'
				, 'Elemento'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'iniciativa_lista', 'type' => 'myDropdown_iniciativa', 'placeholder' => 'Iniciativa', 'source' => $iniciativas],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementosIniciativa, 'strict'=> false],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }

	public function guardarCargaMasivaListaIniciativa(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
		$elementosParmas['grupos'][0] = ['columnas' => ['iniciativa_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['iniciativa']['tabla'], 'idTabla' => $this->model->tablas['iniciativa']['id']];
		$elementosParmas['grupos'][1] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elemento']['tabla'], 'idTabla' => $this->model->tablas['elemento']['id']];
        $elementos = $this->getIdsCorrespondientes($elementosParmas);
		array_pop($elementos);

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][0] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' => 'idGrupoCanal'];
		$listasParams['grupos'][1] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		//$listasParams['grupos'][3] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);

		if(!$listas_unicas){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que todas las listas tengan un ID único'));
			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
        foreach($listas as $index => $value){

			$listasInsertadas = [];
			$multiDataRefactorizada = [] ;
			
			$value['idProyecto']=$this->session->userdata('idProyecto');
			/*if(empty($value['idGrupoCanal'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Grupo Canal.<br> Lista N°: '.$value['idLista']));
				goto responder;
			}*/
            if(empty($value['fechaInicio'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe registrar una fecha de Inicio.<br> Lista N°: '.$value['idLista']));
		        goto responder;
            }
            if(!empty($value['fechaFin'])){
                $fechaInicio = strtotime(str_replace('/','-',$value['fechaInicio']));
                $fechaFin = strtotime(str_replace('/','-',$value['fechaFin']));

               
                if($fechaFin < $fechaInicio){
                    $result['result'] = 0;
                    $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'La fecha Fin no puede ser menor a la fecha Inicio.<br> Lista N°: '.$value['idLista']));
                    goto responder;
                }
			}

			$rs = $this->model->registrarListaIniciativa_HT($value);
            $idLista = $this->db->insert_id();
            
            if(!$rs){
                $insertMasivo = false;
                break;
            }
			
			foreach($elementos as $row){

                if($row['idLista'] == $value['idLista']){
                    $multiDataRefactorizada[] = [
                        'iniciativa_lista' => $row[$this->model->tablas['iniciativa']['id']],
						'elemento_lista' =>  $row[$this->model->tablas['elemento']['id']],
                    ];

                }
            }
            $insert = $this->model->guardarMasivoListaIniciativa($multiDataRefactorizada, $idLista);
			
		}

		if (!$insertMasivo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }

	public function cambiarEstado()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['cambiarEstado'];

		$post = json_decode($this->input->post('data'), true);

		$seccionActivo = $post['seccionActivo'];
		$ids = $post['ids'];
		$estado = ($post['estado'] == 0) ? 1 : 0;

		switch ($seccionActivo) {
			case 'Lista':
				$tabla = $this->model->tablas['lista']['tabla'];
				$idTabla = $this->model->tablas['lista']['id'];
				break;
			case 'ListaIniciativa':
				$tabla = $this->model->tablas['listaIniciativa']['tabla'];
				$idTabla = $this->model->tablas['listaIniciativa']['id'];
				break;
		}

		$update = [];
		$actualDateTime = getActualDateTime();

		foreach ($ids as $id) {
			$update[] = [
				$idTabla => $id,
				'estado' => $estado,
				'fechaModificacion' => $actualDateTime
			];
		}
		

		$cambioEstado = $this->model->actualizarMasivo($tabla, $update, $idTabla);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}













	public function getTablaListaModulacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListasModulacion($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function getFormNewListaModulacion()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrarListaIniciativa'];
		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$post['idProyecto']=$this->session->userdata('idProyecto');

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['lista_elementos'] =  array();


		$dataParaVista['tipo_elementos'] =  array();
		foreach($dataParaVista['elementos'] as $row){
			$dataParaVista['tipo_elementos'][$row['idTipoElementoVisibilidad']]=$row['tipo'];
		}

		$dataParaVista['elementos_visibilidad'] =  array();
		foreach($dataParaVista['elementos'] as $row){
			$dataParaVista['elementos_visibilidad'][$row['idTipoElementoVisibilidad']][$row['idElementoVis']]=$row['nombre'];
		}

		$result['result'] = 1;
		$result['data']['width'] = '80%';
		$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function registrarListaModulacion()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$total_elemento=count($post)-3;

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
		];

		$elementosAValidarMulti = [
			'elemento_lista'=>['selectRequerido']

		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);
		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->registrarListaModulacion($post);

		$idLista = $this->db->insert_id();
		
		$elementos_unicos=array();

		if($total_elemento>0){
			for($i=1;$i<=$total_elemento;$i++){
				if(!empty($post['elemento_lista-'.$i])){
					$elementos_unicos[$post['elemento_lista-'.$i]]['idLista']=$post['elemento_lista-'.$i];
					$elementos_unicos[$post['elemento_lista-'.$i]]['orden']=$post['orden_lista-'.$i];
				}
			}
		}
		
		if(count($elementos_unicos)>0){
			foreach($elementos_unicos as $row){
				$insert = array(
					'idLista' => $idLista,
					'idElementoVisibilidad' => $row['idLista'],
					'orden' => $row['orden']
				);
				$insert = $this->db->insert('trade.master_listaElementosDet', $insert);
			}
		}
       
		
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if($insert == 'repetido'){
					$this->db->trans_rollback();
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
				}
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	
	public function getFormUpdateListaModulacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();

		$dataParaVista['data'] = $this->model->getListasModulacion($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementosModulacion($post)->result_array();

		$post='';

		$dataParaVista['tipo_elementos'] =  array();
		foreach($dataParaVista['elementos'] as $row){
			$dataParaVista['tipo_elementos'][$row['idTipoElementoVisibilidad']]=$row['tipo'];
		}

		$dataParaVista['elementos_visibilidad'] =  array();
		foreach($dataParaVista['elementos'] as $row){
			$dataParaVista['elementos_visibilidad'][$row['idTipoElementoVisibilidad']][$row['idElementoVis']]=$row['nombre'];
		}

		$result['result'] = 1;
		$result['data']['width'] = '65%';
		$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarListaModulacion()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$idLista = $post['idlst'];
		
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;
		
		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido']
		];
		$elementosAValidarMulti = [
			'elemento_lista'=>['selectRequerido']

		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);

		
		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;
		
		
		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->actualizarListaModulacion($post);

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo('trade.master_listaElementosDet','idListaDet', $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoListaModulacion($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoListaModulacion($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if($insert == 'repetido'){
					$this->db->trans_rollback();
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
				}
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}


	public function getProyectos(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$data3 = $this->model->obtenerCanalCuenta($post)->result_array();

		$post['idUsuario']=$this->session->userdata('idUsuario');
		$data2 = $this->model->obtenerProyectos($post)->result_array();
		$data = $this->model->getSegCliente($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
			foreach($data as $row){
				$html .= '<option value='.$row['idCliente'].'>'.$row['razonSocial'].'</option>';
			}
		
		$proyecto_unico=false;
		$html2 = "<option value=''>-- Seleccionar --</option>";
		if( count($data2)==1){
			$proyecto_unico=true;
			foreach($data2 as $row){
				$html2 .= '<option value='.$row['idProyecto'].' SELECTED>'.$row['proyecto'].'</option>';
			}
		}else{
			foreach($data2 as $row){
				$html2 .= '<option value='.$row['idProyecto'].'>'.$row['proyecto'].'</option>';
			}
		}
			
			
		$arr_grupoCanal=array();
		foreach($data3 as $row){
			$arr_grupoCanal[$row['idGrupoCanal']]=$row['grupoCanal'];
		}
		$html3 = "<option value=''>-- Seleccionar --</option>";
		foreach($arr_grupoCanal as $id => $row){
			$html3 .= '<option value='.$id.'>'.$row.'</option>';
		}

		$arr_canal=array();
		foreach($data3 as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}

		$result['data']['html'] = $html; 
		$result['data']['html2'] = $html2; 
		$result['data']['html3'] = $html3; 
		$result['data']['proyecto_unico'] = $proyecto_unico; 
		$result['data']['grupoCanal'] = $arr_canal; 
		$result['result'] = 1;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getSegCliente(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getSegCliente($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
			foreach($data as $row){
				$html .= '<option value='.$row['idCliente'].'>'.$row['razonSocial'].'</option>';
			}

		$result['data']['html'] = $html; 
		$result['result'] = 1;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormCargaMasivaListaModulacion(){
		$result = $this->result;
		
        $elementos = $this->model->getElementos()->result_array();
		//REFACTORIZANDO DATA
		$elementosRefactorizado = [];
		foreach ($elementos as $row) {
			if (!in_array($row['idElementoVis'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['idElementoVis'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
                ['idLista' => null
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];
        
		$HT[1] = [
			'nombre' => 'Elemento',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
				, 'orden_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Id Elemento'
				, 'Orden'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementos],
				['data' => 'orden_lista', 'type' => 'numeric', 'placeholder' => 'Orden', 'width' => 100]
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];

		$result['result'] = 1;
		$result['msg']['title'] = $this->titulo['masivoListaIniciativa'];
		$result['data']['htmlWidth'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['listaIniciativa']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarCargaMasivaListaModulacion(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$dataArray = $post['dataArray'];
		$dataArrayLista= array();

		if (!empty($dataArray)) {
			foreach ($dataArray[0] as $kle => $index) {
				$dataArrayLista[$index[0]]['idLista'] = $index[0];
				$dataArrayLista[$index[0]]['fecIni'] = ( !empty($index[1]) ? $index[1] : date('Y-m-d') );
				$dataArrayLista[$index[0]]['fecFin'] = ( !empty($index[2]) ? $index[2] : NULL );
				$dataArrayLista[$index[0]]['elementos'] = array();
			}

			foreach ($dataArray[1] as $key => $elemento) {
				if( isset($dataArrayLista[$index[0]]['elementos']) ){
					array_push($dataArrayLista[$elemento[0]]['elementos'], ( array('elemento'=>$elemento[1],'orden'=>$elemento[2]) ) );
				}
			}

			//INTERMANOS LOS DATOS
			foreach ($dataArrayLista as $key => $cabecera) {
				$arrayCabecera=array();
				if($cabecera['fecIni']!=null){

					$arrayCabecera['fecIni'] = $cabecera['fecIni'];
					$arrayCabecera['fecFin'] = $cabecera['fecFin'];
					$arrayCabecera['estado'] = 1;

					$rs_verificarExisitencia = $this->model->verificar_lista_modulacion($arrayCabecera);
					$idListaModulacion = NULL;

					if (!empty($rs_verificarExisitencia)) {
						//EXISTE UN VALOR CON LA CABECERA
						$idListaModulacion = $rs_verificarExisitencia[0]['idLista'];
					} else {
						//NO EXISTE REGISTRO DE ESTA MODULACIÓN
						$rs_registrarLista = $this->model->insertar_lista_modulacion($arrayCabecera);
						if ($rs_registrarLista) {
							//SE REGISTRO CORRECTAMENTE
							$idListaModulacion = $this->db->insert_id();
						}
					}

					//DETALLE DE LOS ELEMENTOS
					foreach ($cabecera['elementos'] as $kle => $elemento) {
						//
						$arrayDetalle=array();
						$arrayDetalle['idLista']=$idListaModulacion;
						$arrayDetalle['idElementoVisibilidad'] = $elemento['elemento'];
						$arrayDetalle['estado']=1;

						$rs_verificarExisitenciaDetalle = $this->model->verificar_lista_modulacion_detalle($arrayDetalle);
						$arrayDetalle['orden'] = $elemento['orden'];

						if (empty($rs_verificarExisitenciaDetalle)) {
							//AGREGAMOS EL ELEMENTO
							$rs_registrarListaDetalle = $this->model->insertar_lista_modulacion_detalle($arrayDetalle);
						}
					}

				}
				
			}

			$result['result']=1;
			$html = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ EL REGISTRO DE LA INFORMACIÓN CORRECTAMENTE.</div>';
		} else {
			$html = $this->htmlNoResultado;
		}

		$result['msg']['title'] = 'REGISTRAR LISTA DE ELEMENTOS DE MODULACIÓN MASIVO';
		$result['msg']['message'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
}
