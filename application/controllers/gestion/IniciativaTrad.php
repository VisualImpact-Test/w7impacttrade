<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Iniciativatrad extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_IniciativaTrad', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarMotivo' => 'Actualizar Motivo',
			'registrarMotivo' => 'Registrar Motivo',
			'masivoMotivo' => 'Guardar Masivo Motivo',
	
			'actualizarElemento' => 'Actualizar Elemento',
			'registrarElemento' => 'Registrar Elemento',
			'masivoElemento' => 'Guardar Masivo Elemento',
		
			'actualizarIniciativa' => 'Actualizar Iniciativa',
			'registrarIniciativa' => 'Registrar Iniciativa',
			'masivoIniciativa' => 'Guardar Masivo Iniciativa',

			'actualizarLista' => 'Actualizar Lista Iniciativas ',
			'registrarLista' => 'Registrar Lista Iniciativas',
			'masivoLista' => 'Guardar Masivo Lista Iniciativas ',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/iniciativatrad/';
        
		$this->html = [
			'motivo' => [
				'tabla' => $this->carpetaHtml .  'tablaMotivo',
				'new' => $this->carpetaHtml .  'formNewMotivo',
				'update' => $this->carpetaHtml .  'formUpdateMotivo',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaMotivo'
			],
			'elementoIniciativa' => [
				'tabla' => $this->carpetaHtml .  'tablaElemento',
				'new' => $this->carpetaHtml .  'formNewElemento',
				'update' => $this->carpetaHtml .  'formUpdateElemento',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaElemento'
			],

			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaIniciativa',
				'new' => $this->carpetaHtml .  'formNewIniciativa',
				'update' => $this->carpetaHtml .  'formUpdateIniciativa',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaIniciativa'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaIniciativa',
				'new' => $this->carpetaHtml .  'formNewListaIniciativa',
				'update' => $this->carpetaHtml .  'formUpdateListaIniciativa',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaIniciativa',
			],
		];
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/iniciativaTrad'
		];

		$config['nav']['menu_active']='95';
		$config['data']['icon'] = 'fa fa-eye';
		$config['data']['title'] = 'Iniciativa Tradicional';
		$config['data']['message'] = 'Iniciativa Trad';
        $config['view'] = $this->carpetaHtml.'index';


		$this->view($config);
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

			case 'Motivo':
				$tabla = $this->model->tablas['motivoIniciativa']['tabla'];
				$idTabla = $this->model->tablas['motivoIniciativa']['id'];
				break;
			case 'Elemento':
				$tabla = $this->model->tablas['elementoIniciativa']['tabla'];
				$idTabla = $this->model->tablas['elementoIniciativa']['id'];
				break;
			case 'Iniciativa':
				$tabla = $this->model->tablas['elemento']['tabla'];
				$idTabla = $this->model->tablas['elemento']['id'];
				break;
			case 'Lista':
				$tabla = $this->model->tablas['lista']['tabla'];
				$idTabla = $this->model->tablas['lista']['id'];
				break;
		}

		$update = [];
		$actualDateTime = getActualDateTime();

		foreach ($ids as $id) {
			
			if($seccionActivo!='Motivo' && $seccionActivo!='Elemento'){
				$update[] = [
					$idTabla => $id,
					'estado' => $estado,
					'fechaModificacion' => $actualDateTime
				];
			}else{
				$update[] = [
					$idTabla => $id,
					'estado' => $estado, 
				];
			}
			
			
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

	public function getElementosIniciativa(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
	 

		$data = $this->model->getElementosPoriniciativa($post)->result_array();

		$html = "";
			foreach($data as $row){
				$html .= '<option value='.$row['idElementoVis'].'>'.$row['nombre'].'</option>';
			}

		$result['data']['html'] = $html; 
		$result['result'] = 1;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	// SECCION MOTIVOS
	public function getTablaMotivo()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getMotivos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['motivo']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

    public function getFormNewMotivo()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$dataParaVista = array();
		$dataParaVista['iniciativas'] = $this->model->getElementos()->result_array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['motivo']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function registrarMotivo()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];


		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreMotivoniciativaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$registro = $this->model->registrarMotivoIniciativa($post);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateMotivo()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getMotivos($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['motivo']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarMotivo()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
        ];
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreMotivoniciativaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarMotivoIniciativa($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	// SECCION ELEMENTOS INICIATIVA
	public function getTablaElemento()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getElementosIniciativa($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['elementoIniciativa']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

    public function getFormNewElemento()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$dataParaVista = array();

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$dataParaVista['iniciativas'] = $this->model->getElementos($params)->result_array();

		$class="formNewElemento";
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$dataParaVista['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['elementoIniciativa']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function registrarElemento()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'iniciativa' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoIniciativaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['proyecto']=$this->session->userdata('idProyecto');
		$post['cuenta']=$this->session->userdata('idCuenta');
		$registro = $this->model->registrarElementoIniciativa($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateElemento()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['data'] = $this->model->getElementosIniciativa($post)->row_array();
		$dataParaVista['iniciativas'] = $this->model->getElementos($params)->result_array();
		$dataParaVista['motivos'] = $this->model->getMotivos()->result_array();
		$dataParaVista['elementoMotivos'] = $this->model->getMotivoElementoVisibilidad($post)->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elementoIniciativa']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function actualizarElemento()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$delete = true;$update = true;$insert = true;
		
		$elementosAValidar = [
			'nombre' => ['requerido'],
			'iniciativa' => ['requerido'],
        ];
        
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarElementoIniciativa($post);

		//
		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo("{$this->sessBDCuenta}.trade.motivoElementoVisibilidadTrad",'idMotivoElementoVis', $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoMotivoElementoVisibilidad($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoMotivoElementoVisibilidad($multiDataRefactorizada, $post['idx']);


		if (!$actualizo || !$update || !$delete || !$insert || $insert === 'repetido') {
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

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	// SECCION INICIATIVAS
	public function getTablaIniciativa()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$post['cuenta']=$this->session->userdata('idCuenta');
		$data = $this->model->getElementos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['elemento']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

    public function getFormNewIniciativa()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$dataParaVista = array();
		$dataParaVista['elementos'] = $this->model->getElementosIniciativaDistinct()->result_array();
		$dataParaVista['motivos'] = $this->model->getMotivos()->result_array();
		$dataParaVista['elementos_iniciativa'] = array();


		$class = 'formNewIniciativa';
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$dataParaVista['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['elemento']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }
    public function registrarIniciativa()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$delete = true;$update = true;$insert = true;
	
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$elementosAValidarSimple = [
			'nombre' => ['requerido'],
            'fechaInicio' => ['requerido'],
        ];
		
		$elementosAValidarMulti = [
			'elemento_iniciativa'=>['selectRequerido']
		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);
		
		
		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		
		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;
		
		
		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['proyecto']=$this->session->userdata('idProyecto');
		$actualizo = $this->model->registrarElemento($post);
		$idIniciativa = $this->db->insert_id();

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['elementoIniciativa']['tabla'], $this->model->tablas['elementoIniciativa']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoIniciativaElemento($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoIniciativaElemento($multiDataRefactorizada, $idIniciativa);

		if (!$actualizo) {
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
	public function getFormUpdateIniciativa()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getElementos($post)->row_array();
		$dataParaVista['elementos'] = $this->model->getElementosIniciativaDistinct()->result_array();
		$dataParaVista['elementos_iniciativa'] = $this->model->getListaElementosIniciativa($post)->result_array();
		$dataParaVista['motivos'] = $this->model->getMotivos()->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function actualizarIniciativa()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$delete = true;$update = true;$insert = true;
		$idIniciativa = $post['idx'];
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		
		$elementosAValidarSimple = [
			'nombre' => ['requerido'],
            'fechaInicio' => ['requerido'],
        ];
		
		$elementosAValidarMulti = [
			'elemento_iniciativa'=>['selectRequerido'],
			//'motivo_iniciativa'=>['selectRequerido']

		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);
		
		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		
		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;
		
		
		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarElemento($post);

		//UPDATE
		$update = $this->model->actualizarMasivoIniciativaElemento($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoIniciativaElemento($multiDataRefactorizada, $idIniciativa);

		if (!$actualizo) {
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

	public function getTablaLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListas($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['lista']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function getFormNewLista()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['elementos'] = $this->model->getElementosIniciativa($params)->result_array();
		$dataParaVista['iniciativas'] = $this->model->getIniciativas($params)->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
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
		$result['data']['html'] = $this->load->view($this->html['lista']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function getClientesProyecto(){
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$dataParaVista['clientes'] = $this->model->getClientes($post)->result_array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);

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

		$dataParaVista['elementos'] = $this->model->getElementosIniciativa()->result_array();
		$dataParaVista['iniciativas'] = $this->model->getIniciativas()->result_array();
		$dataParaVista['data'] = $this->model->getListasDet($post)->row_array();
		if(!empty($dataParaVista['data']['idCanal'])) $dataParaVista['clientes'] = $this->model->getSegCliente($dataParaVista['data'])->result_array();
		
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post='';
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();

		
		$class = 'formUpdateLista';
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$dataParaVista['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['lista']['update'], $dataParaVista, true);

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
			'fechaInicio' => ['requerido'],
			'grupoCanal' => ['selectRequerido'],
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
		$registro = $this->model->registrarLista($post);

		$idLista = $this->db->insert_id();

		$registro_detalle = $this->model->registrarDetalleLista($post,$idLista);

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
			'grupoCanal' => ['requerido'],
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
		$registro = $this->model->actualizarLista($post);

		//BORRAR
		$delete = $this->model->deleteMasivoDetalleLista($idLista);

		$registro_detalle = $this->model->registrarDetalleLista($post,$idLista);

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
	
    public function getFormCargaMasivaLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

		$gruposCanal = $this->model->getGrupoCanales()->result_array();
        $canales = $this->model->getCanales()->result_array();
		$post = '';
        $clientes = $this->model->getClientes()->result_array();
        $elementos = $this->model->getElementosIniciativa()->result_array();

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
		// foreach ($elementos as $row) {
		// 	if (!in_array($row['nombre'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['nombre'];
		// }
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
                , 'Id Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'grupoCanal', 'type' => 'myDropdown_grupoCanal', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown_canal', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'idCliente', 'type' => 'myDropdown', 'placeholder' => 'ID Cliente', 'source' => $clientes, 'strict'=> false],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];
        
		$HT[1] = [
			'nombre' => 'Elementos',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Elemento'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'autocomplete', 'placeholder' => 'Elemento', 'source' => $elementos, 'strict'=> false],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['lista']['cargaMasiva'], $dataParaVista, true);
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
		$elementosParmas['tablaHT'] = $elementos;
		//$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elementoIniciativa']['tabla'], 'idTabla' => $this->model->tablas['elementoIniciativa']['id']];
        //$elementos = $this->getIdsCorrespondientes($elementosParmas);
        
		array_pop($elementos);
		$idCuenta=$this->session->userdata('idCuenta');

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
			if(empty($value['idGrupoCanal'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Grupo Canal.<br> Lista N°: '.$value['idLista']));
				goto responder;
			}
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

			$rs = $this->model->registrarLista_HT($value);
            $idLista = $this->db->insert_id();
            
            if(!$rs){
                $insertMasivo = false;
                break;
            }
			
			foreach($elementos as $row){

                if($row['idLista'] == $value['idLista']){
                    $multiDataRefactorizada[] = [
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

	public function getFormCargaMasivaIniciativa()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoIniciativa'];

        $post = '';

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Iniciativas',
			'data' => [
                ['iniciativa' => null
                ,'descripcion' => null
                ,'fechaInicio' => null
                ,'fechaFin' => null
                ]
			],
            'headers' => ['Iniciativas','Descripción','Fecha Inicio','Fecha Fin'
            ],
			'columns' => [
				['data' => 'iniciativa', 'type' => 'text', 'placeholder' => 'Iniciativa', 'width' => 300],
				['data' => 'descripcion', 'type' => 'text', 'placeholder' => 'Descripción', 'width' => 300],
				['data' => 'fechaInicio', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio'],
				['data' => 'fechaFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin' ],
			],
			'colWidths' => 200,
        ];
        
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarCargaMasivaIniciativa(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoIniciativa'];

        $post = json_decode($this->input->post('data'), true);
        

        $elementos = $post['HT']['0'];
		$elementosParams['tablaHT'] = $elementos;
        
        
		array_pop($elementos);

		$elementos_unicos = $this->model->validar_elementos_unicos_HT($elementos);

		if(!$elementos_unicos){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que los elementos no se repiten'));
			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;
        foreach($elementos as $index => $value){

			
            if(empty($value['fechaInicio'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe registrar una fecha de Inicio.<br> Fila N°: '.$fila));
		        goto responder;
            }
            if(!empty($value['fechaFin'])){
                $fechaInicio = strtotime(str_replace('/','-',$value['fechaInicio']));
                $fechaFin = strtotime(str_replace('/','-',$value['fechaFin']));

               
                if($fechaFin < $fechaInicio){
                    $result['result'] = 0;
                    $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'La fecha Fin no puede ser menor a la fecha Inicio.<br> Fila N°: '.$fila));
                    goto responder;
                }
			}

			$idCuenta=$this->session->userdata('idCuenta');
			$multiDataRefactorizada[] = [
				'nombre' => trim($value['iniciativa']),
				'descripcion' => (!empty($value['descripcion']))? trim($value['descripcion']) : null,
				'fecIni' => $value['fechaInicio'],
				'fecFin' => (!empty($value['fechaFin']))? trim($value['fechaFin']) : null,
				'idCuenta' => $idCuenta
			];

			$fila++;
		}

		$masivo = $this->model->registrar_elementos_HT($multiDataRefactorizada);

		if(!$masivo){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 0,'message'=>'No se pudo Completar la operación'));
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = createMessage(array('type'=> 1,'message'=>'Se completó la operacion Correctamente'));
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	


	public function getFormCargaMasivaElemento()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoElemento'];

		$post = '';
        $iniciativas = $this->model->getIniciativas()->result_array();
		$motivos = $this->model->getMotivos()->result_array();
		//REFACTORIZANDO DATA
	
		$iniciativasRefactorizado = [];
		foreach ($iniciativas as $row) {
			if (!in_array($row['nombre'], $iniciativasRefactorizado)) $iniciativasRefactorizado[] = $row['nombre'];
		}
		$iniciativas = !empty($iniciativasRefactorizado) ? $iniciativasRefactorizado : [' '];

		$motivosRefactorizado = [];
		foreach ($motivos as $row) {
			if (!in_array($row['idEstadoIniciativa'], $motivosRefactorizado)) $motivosRefactorizado[] = $row['idEstadoIniciativa'];
		}
		$motivos = !empty($motivosRefactorizado) ? $motivosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Elementos',
			'data' => [
                [  
					'idLista' => null 
					,'iniciativa' => null 
                , 'elemento' => null 
                ]
			],
            'headers' => [ 
                'IdLista'
				,'Iniciativa'
                , 'Elemento' 
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'iniciativa', 'type' => 'myDropdown', 'placeholder' => 'Iniciativa', 'source' => $iniciativas],
				['data' => 'elemento', 'type' => 'text', 'placeholder' => 'Elemento'], 
			],
			'colWidths' => 250,
        ];

		$HT[1] = [
			'nombre' => 'Motivos',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Id Motivo'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'autocomplete', 'placeholder' => 'Motivo', 'source' => $motivos, 'strict'=> false],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['lista']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function guardarCargaMasivaElemento(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = json_decode($this->input->post('data'), true);
		$idCuenta=$this->session->userdata('idCuenta');
		

		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
        
		array_pop($elementos);
		
        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][0] = ['columnas' => ['iniciativa'], 'columnasReales' => ['nombre'], 'tabla' => "{$this->sessBDCuenta}.trade.iniciativaTrad", 'idTabla' => 'idIniciativa'];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$insertMasivo  = true;
		$rsinsertMasivo="";
		$fila = 1;
		$idCuenta=$this->session->userdata('idCuenta');
		$idProyecto=$this->session->userdata('idProyecto');
        foreach($listas as $index => $value){
			if($value['idLista']!=null){

				$listasInsertadas = [];
				$multiDataRefactorizada = [] ;

				if(empty($value['idIniciativa'])){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar una Iniciativa.<br> Lista N°: '.$value['idLista']));
					goto responder;
				}
				$params=$value;
				
				$params['idCuenta']=$idCuenta;
				$params['idProyecto']=$idProyecto;
				$rs = $this->model->registrarElemento_HT($params);
				$idLista = $this->db->insert_id();
				
				if(!$rs || (strcmp($rs, 'repetido')==1) ){
					$insertMasivo = $rs;
					break;
				}

				foreach($elementos as $row){
					if( $row['elemento_lista']!=null ){
						if($row['idLista'] == $value['idLista']){
							$multiDataRefactorizada[] = [
								'elemento_lista' => $row['elemento_lista']
							];
						}
					}
				}
				if( !empty($multiDataRefactorizada)){
					$insert = $this->model->guardarMasivoMotivoElementoVisibilidad($multiDataRefactorizada, $idLista);
				}
			}
		}
		
		
		if (!$insertMasivo || (strcmp($insertMasivo, 'repetido')==1)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			if((strcmp($insertMasivo, 'repetido')==1)){
				$this->db->trans_rollback();
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
			}
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }
}
