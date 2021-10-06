<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LiveStorecheckConf extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_livestorecheckconf', 'model');
		$this->load->model('M_control', 'm_control');
		$this->load->helper('html');
		
		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarInfoPlaza' => 'Actualizar Indicador',
			'registrarInfoPlaza' => 'Registrar Indicador',
			'masivoInfoPlaza' => 'Guardar Masivo Indicadores',

			'actualizarTipoCliente' => 'Actualizar Tipo Cliente',
			'registrarTipoCliente' => 'Registrar Tipo Cliente',
			'masivoTipoCliente' => 'Guardar Masivo Tipo Cliente',

			'actualizarTipoResponsable' => 'Actualizar Tipo Responsable',
			'registrarTipoResponsable' => 'Registrar Tipo Responsable',
			'masivoTipoResponsable' => 'Guardar Masivo Tipo Responsable',

			'actualizarResponsable' => 'Actualizar  Responsable',
			'registrarResponsable' => 'Registrar  Responsable',
			'masivoResponsable' => 'Guardar Masivo  Responsable',

			'actualizarTipoAuditoria' => 'Actualizar Tipo Auditoria',
			'registrarTipoAuditoria' => 'Registrar Tipo Auditoria',
			'masivoTipoAuditoria' => 'Guardar Masivo Tipo Auditoria',
			
			'actualizarEmpresa' => 'Actualizar Datos Empresa',
			'registrarEmpresa' => 'Registrar Datos Empresa',
			'masivoEmpresa' => 'Guardar Masivo Datos Empresa',

			'actualizarConfPlaza' => 'Actualizar Datos Configuración de Plaza',
			'registrarConfPlaza' => 'Registrar Datos Configuración de Plaza',
			'masivoConfPlaza' => 'Guardar Masivo Datos Configuración de Plaza',

			'actualizarInfPlaza' => 'Actualizar Datos Configuración de Plaza',
			'registrarInfPlaza' => 'Registrar Datos Configuración de Plaza',
			'masivoInfPlaza' => 'Guardar Masivo Datos Configuración de Plaza',

			'actualizarConfCliente' => 'Actualizar Datos Configuración de Cliente',
			'registrarConfCliente' => 'Registrar Datos Configuración de Cliente',
			'masivoConfCliente' => 'Guardar Masivo Datos Configuración de Cliente',

			'actualizarConfTipoCliente' => 'Actualizar Datos Configuración de Cliente',
			'registrarConfTipoCliente' => 'Registrar Datos Configuración de Cliente',
			'masivoConfTipoCliente' => 'Guardar Masivo Datos Configuración de Cliente',

			'actualizarListaEvaluacion' => 'Actualizar Lista Evaluación',
			'registrarListaEvaluacion' => 'Registrar Lista Evaluación',
			'masivoListaEvaluacion' => 'Guardar Masivo Lista Evaluación',

			'actualizarTipoEvaluacion' => 'Actualizar Tipo Evaluación',
			'registrarTipoEvaluacion' => 'Registrar Tipo Evaluación',
			'masivoTipoEvaluacion' => 'Guardar Masivo Tipo Evaluación',

			'actualizarEvaluacion' => 'Actualizar  Evaluación',
			'registrarEvaluacion' => 'Registrar  Evaluación',
			'masivoEvaluacion' => 'Guardar Masivo  Evaluación',




        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/livestorecheckconf/';
        
		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaInfoPlaza',
				'new' => $this->carpetaHtml .  'formNewInfoPlaza',
				'update' => $this->carpetaHtml .  'formUpdateInfoPlaza',
			
			],
		];
	}

	public function index()
	{
		
		$config = array();
		$config['css']['style'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/libs/chosen/chosen',
			'assets/libs/bootstraptoggle/bootstrap4-toggle.min',
			'assets/custom/css/configuraciones/gestion/liveStoreCheckConf',
			'assets/custom/css/liveStorecheck'
            
		];
		$config['js']['script'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/livestorecheckconf',
			'assets/libs/chosen/chosen.jquery',
			'assets/libs/chosen/handsontable-chosen-editor',
			'assets/libs/bootstraptoggle/bootstrap4-toggle.min',
			'assets/libs/sheetJs/xlsx.full.min',
			'assets/libs/fileSaver/FileSaver.min',
		];

		$config['nav']['menu_active']='111';
		$config['data']['icon'] = 'fa fa-cog';
		$config['data']['title'] = 'LiveStorecheck - Configuración';
		$config['data']['message'] = 'Gestión';
        $config['view'] = $this->carpetaHtml.'index';


		$this->view($config);
	}

	public function getClientesByPlaza(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$params = array(
			'idPlaza' => $post['id'],
		);
		$clientes = $this->model->getClientes($params)->result_array();
		
		$result['data']['clientes'] = htmlSelectOptionArray($clientes);
		$result['result'] = 1;
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
			case 'InfoPlaza':
				$tabla = $this->model->tablas['infoPlaza']['tabla'];
				$idTabla = $this->model->tablas['infoPlaza']['id'];
				break;
			case 'TipoCliente':
				$tabla = $this->model->tablas['tipoCliente']['tabla'];
				$idTabla = $this->model->tablas['tipoCliente']['id'];
				break;
			case 'TipoResponsable':
				$tabla = $this->model->tablas['tipoResponsable']['tabla'];
				$idTabla = $this->model->tablas['tipoResponsable']['id'];
				break;
			case 'Responsable':
				$tabla = $this->model->tablas['responsable']['tabla'];
				$idTabla = $this->model->tablas['responsable']['id'];
				break;
			case 'TipoAuditoria':
				$tabla = $this->model->tablas['tipoAuditoria']['tabla'];
				$idTabla = $this->model->tablas['tipoAuditoria']['id'];
				break;
			case 'Empresa':
				$tabla = $this->model->tablas['empresa']['tabla'];
				$idTabla = $this->model->tablas['empresa']['id'];
				break;
			case 'ConfPlaza':
				$tabla = $this->model->tablas['confPlaza']['tabla'];
				$idTabla = $this->model->tablas['confPlaza']['id'];
				break;
			case 'InfPlaza':
				$tabla = $this->model->tablas['infPlaza']['tabla'];
				$idTabla = $this->model->tablas['infPlaza']['id'];
				break;
			case 'ConfCliente':
				$tabla = $this->model->tablas['confCliente']['tabla'];
				$idTabla = $this->model->tablas['confCliente']['id'];
				break;
			case 'ConfTipoCliente':
				$tabla = $this->model->tablas['confTipoCliente']['tabla'];
				$idTabla = $this->model->tablas['confTipoCliente']['id'];
				break;
			case 'ListaEvaluacion':
				$tabla = $this->model->tablas['listaEvaluacion']['tabla'];
				$idTabla = $this->model->tablas['listaEvaluacion']['id'];
				break;
			case 'Preguntas':
				$tabla = $this->model->tablas['preguntas']['tabla'];
				$idTabla = $this->model->tablas['preguntas']['id'];
				break;
			case 'TipoEvaluacion':
				$tabla = $this->model->tablas['tipoEvaluacion']['tabla'];
				$idTabla = $this->model->tablas['tipoEvaluacion']['id'];
				break;
			case 'Evaluacion':
				$tabla = $this->model->tablas['evaluacion']['tabla'];
				$idTabla = $this->model->tablas['evaluacion']['id'];
				break;
		}

		$update = [];
		$actualDateTime = getActualDateTime();
		$idUsuarioSession = $this->session->userdata('idUsuario');
		foreach ($ids as $id) {
			$update[] = [
				$idTabla => $id,
				'estado' => $estado,
				'fechaModificacion' => $actualDateTime,
				'idUsuarioReg' => $idUsuarioSession,
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
		echo json_encode($result);
	}


	// SECCION INFO PLAZA
	public function getTablaInfoPlaza()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getInfoPlaza($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaInfoPlaza', $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormDarDeBaja()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formDarDeBaja', $dataParaVista, true);

		echo json_encode($result);
    }
    public function getFormNewInfoPlaza()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();
		$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewInfoPlaza', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarInfoPlaza()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];


		$elementosAValidar = [
			'nombre' => ['requerido'],
			'sl_cuentas' =>['selectRequerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'infoPlaza')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->regitrarInfoPlaza($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateInfoPlaza()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getInfoPlaza($post)->row_array();
		$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateInfoPlaza', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarInfoPlaza()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
        ];
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'infoPlaza')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarInfoPlaza($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaInfoPlaza(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoInfoPlaza'];

        $cuentas = $this->model->getCuentas()->result_array();
      

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Informacion',
			'data' => [
                ['nombre' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'NOMBRE TIPO INFO (*)'
  
            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],

	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaInfoPlaza(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoInfoPlaza'];

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {

			
			if(!empty($value['nombre'])){

				if ($this->model->checkNombreElementoRepetido($value,'infoPlaza')){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. <br> Fila:'.($key+1)));
					goto respuesta;
				}

				$dataInsertMasivo[] = array(
					'idCuenta' => '3',
					'idProyecto' => '3',
					'nombre' => $value['nombre'],
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoInfoPlaza($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	//TIPO CLIENTE
	public function getTablaTipoCliente()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getTipoCliente($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaTipoCliente', $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewTipoCliente()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewTipoCliente', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarTipoCliente()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];


		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'tipoCliente')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarTipoCliente($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateTipoCliente()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getTipoCliente($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateTipoCliente', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarTipoCliente()
	{
		$this->db->trans_start();

		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
        ];
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'tipoCliente')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarTipoCliente($post);

		if (!$actualizo) {
			
			$result['result'] = 0;

			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaTipoCliente(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoTipoCliente'];

        $cuentas = $this->model->getCuentas()->result_array();
      

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'TipoCliente',
			'data' => [
                ['nombre' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'Nombre Tipo de Cliente'

            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],

	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaTipoCliente(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoTipoCliente'];

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {


			if(!empty($value['nombre'])){
				if ($this->model->checkNombreElementoRepetido($value,'tipoCliente')){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. <br> Fila:'.($key+1)));
					goto respuesta;
				}

				$dataInsertMasivo[] = array(
					'idCuenta' => '3',
					'idProyecto' => '3',
					'nombre' => $value['nombre'],
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
				
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoTipoCliente($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	//TIPO RESPONSABLE
	public function getTablaTipoResponsable()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getTipoResponsable($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaTipoResponsable', $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewTipoResponsable()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewTipoResponsable', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarTipoResponsable()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'tipoResponsable')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarTipoResponsable($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateTipoResponsable()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getTipoResponsable($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateTipoResponsable', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarTipoResponsable()
	{
		$this->db->trans_start();
		
		$result = $this->result;

        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
        ];
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'tipoResponsable')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarTipoResponsable($post);

		if (!$actualizo) {
			
			$result['result'] = 0;

			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaTipoResponsable(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoTipoResponsable'];

        $cuentas = $this->model->getCuentas()->result_array();
      

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'TipoResponsable',
			'data' => [
                ['nombre' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'Nombre Tipo de Responsable'

            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],

	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}
	public function guardarCargaMasivaTipoResponsable(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoTipoResponsable'];

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {

			if(!empty($value['nombre'])){
				if ($this->model->checkNombreElementoRepetido($value,'tipoResponsable')){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. <br> Fila:'.($key+1)));
					goto respuesta;
				}

				$dataInsertMasivo[] = array(
					'idCuenta' => '3',
					'idProyecto' => '3',
					'nombre' => $value['nombre'],
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoTipoResponsable($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}

	//RESPONSABLES
	public function getTablaResponsable()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getResponsable($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaResponsable', $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewResponsable()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();
		$dataParaVista['tipos'] = $this->model->getTiposResponsable()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewResponsable', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarResponsable()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombres' => ['requerido'],
			'apellidos' => ['requerido'],
			'email' => ['requerido'],
			'sl_tipo' => ['selectRequerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarResponsable($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateResponsable()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getResponsable($post)->row_array();
		$dataParaVista['tipos'] = $this->model->getTiposResponsable()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateResponsable', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarResponsable()
	{
		$this->db->trans_start();

		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombres' => ['requerido'],
			'apellidos' => ['requerido'],
			'email' => ['requerido'],
			'sl_tipo' => ['selectRequerido'],
        ];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarResponsable($post);

		if (!$actualizo) {
			
			$result['result'] = 0;

			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaResponsable(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoResponsable'];

        $cuentas = $this->model->getCuentas()->result_array();
        $tipos = $this->model->getTiposResponsable()->result_array();
      

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
        
		$tiposRefactorizado = [];
		foreach ($tipos as $row) {
			if (!in_array($row['value'], $tiposRefactorizado)) $tiposRefactorizado[] = $row['value'];
		}
        $tipos = !empty($tiposRefactorizado) ? $tiposRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Responsable',
			'data' => [
                ['nombre' => null
                , 'apellidos' => null 
                , 'tipo' => null 
                , 'email' => null 
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'TIPO (*)'
                , 'NOMBRES (*) '
                , 'APELLIDOS (*) '
                , 'EMAIL (*)'

            ],
			'columns' => [
				['data' => 'tipo', 'type' => 'myDropdown', 'placeholder' => 'nombre', 'width' => 200,'source'=>$tipos],
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'Nombres', 'width' => 200],
				['data' => 'apellidos', 'type' => 'text', 'placeholder' => 'Apellidos', 'width' => 200],
				['data' => 'email', 'type' => 'text', 'placeholder' => 'Email', 'width' => 200],

	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}
	public function guardarCargaMasivaResponsable(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoResponsable'];

		$array['tipos'] = array();
		$tipos = $this->model->getTiposResponsable()->result_array();

		foreach ($tipos as $key => $row) {
			$array['tipos'][$row['id']] = $row['value'];
		}

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {
			if(!empty($value['nombre']) && !empty($value['apellidos']) && !empty($value['tipo']) && !empty($value['email'])){
				$dataInsertMasivo[] = array(
					'idCuenta' => '3',
					'idProyecto' => '3',
					'nombres' => $value['nombre'],
					'apellidos' => $value['apellidos'],
					'email' => $value['email'],
					'idTipo' => array_search($value['tipo'],$array['tipos']),
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoResponsable($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	
	//TIPO Auditoria
	public function getTablaTipoAuditoria()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getTipoAuditoria($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaTipoAuditoria', $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewTipoAuditoria()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewTipoAuditoria', $dataParaVista, true);

		echo json_encode($result);
    }

    public function registrarTipoAuditoria()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];


		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'tipoAuditoria')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarTipoAuditoria($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateTipoAuditoria()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getTipoAuditoria($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateTipoAuditoria', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarTipoAuditoria()
	{
		$this->db->trans_start();

		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
        ];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'tipoAuditoria')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarTipoAuditoria($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaTipoAuditoria(){
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoTipoAuditoria'];
        $cuentas = $this->model->getCuentas()->result_array();

		//REFACTORIZANDO DATA

		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'TipoAuditoria',
			'data' => [
                ['nombre' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
                ]
			],
            'headers' => [
                  'Nombre Tipo de Auditoria'
            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],
			],
			'colWidths' => 200,
        ];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaTipoAuditoria(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoTipoAuditoria'];

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {

			
			if(!empty($value['nombre'])){

				if ($this->model->checkNombreElementoRepetido($value,'tipoAuditoria')){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. <br> Fila:'.($key+1)));
					goto respuesta;
				}

				$dataInsertMasivo[] = array(
					'idCuenta' => '3',
					'idProyecto' => '3',
					'nombre' => $value['nombre'],
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoTipoAuditoriaExt($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	
	// SECCION EMPRESA(COMPETIDORES)
	public function getTablaEmpresa()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getEmpresa($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaEmpresa', $dataParaVista, true);
		}

		echo json_encode($result);
	}
    public function getFormNewEmpresa()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewEmpresa', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarEmpresa()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'empresa')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarEmpresa($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateEmpresa()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getEmpresa($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateEmpresa', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarEmpresa()
	{
		$this->db->trans_start();

		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
        ];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post,'empresa')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarEmpresa($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaEmpresa(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoEmpresa'];

        $cuentas = $this->model->getCuentas()->result_array();
      

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Competidores',
			'data' => [
                ['nombre' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'Nombre Empresa'

            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],

	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaEmpresa(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoEmpresa'];

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {


			if(!empty($value['nombre'])){

				if ($this->model->checkNombreElementoRepetido($value,'empresa')){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. <br> Fila:'.($key+1)));
					goto respuesta;
				}

				$dataInsertMasivo[] = array(
					'idCuenta' => '3',
					'idProyecto' => '3',
					'nombre' => $value['nombre'],
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoEmpresa($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	// SECCION INFORMACIÓN DE PLAZA
	public function getTablaInfPlaza()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getInfPlaza($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaInfPlaza', $dataParaVista, true);
		}

		echo json_encode($result);
	}
    public function getFormNewInfPlaza()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();
		$dataParaVista['plazas'] = $this->model->getPlazas()->result_array();
		$dataParaVista['infos'] = $this->model->getInfos()->result_array();
		$dataParaVista['empresas'] = $this->model->getEmpresas()->result_array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewInfPlaza', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarInfPlaza()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_plazas' => ['selectRequerido'],
			'sl_tipoInfo' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
			'valor' => ['requerido'],
		];
		if($post['sl_tipoInfo'] == 5){ 
			$elementosAValidar['sl_empresas'] =  ['selectRequerido'];
		}
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		if($this->model->checkConfInfoPlazaRepetido($post)){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Se encontró un registro activo para la plaza y su tipo info'));
			goto respuesta;
		}

		$registro = $this->model->registrarInfPlaza($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateInfPlaza()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getInfPlaza($post)->row_array();
		$dataParaVista['plazas'] = $this->model->getPlazas($dataParaVista['data'])->result_array();
		$dataParaVista['infos'] = $this->model->getInfos()->result_array();
		$dataParaVista['empresas'] = $this->model->getEmpresas()->result_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateInfPlaza', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarInfPlaza()
	{
		$this->db->trans_start();
		
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_plazas' => ['selectRequerido'],
			'sl_tipoInfo' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
			'valor' => ['requerido'],
        ];

		if($post['sl_tipoInfo'] == 5){
			$elementosAValidar['sl_empresas'] =  ['selectRequerido'];
		}
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		if($this->model->checkConfInfoPlazaRepetido($post)){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Se encontró un registro activo para la plaza y su tipo info'));
			goto respuesta;
		}

		$actualizo = $this->model->actualizarInfPlaza($post);

		if (!$actualizo) {
			
			$result['result'] = 0;

			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaInfPlaza(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoInfPlaza'];

        $cuentas = $this->model->getCuentas()->result_array();
		$plazas = $this->model->getPlazas()->result_array();
		$infos = $this->model->getInfos()->result_array();
		$empresas= $this->model->getEmpresas()->result_array();

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];

		$plazasRefactorizado = [];
		foreach ($plazas as $row) {
			if (!in_array($row['value'], $plazasRefactorizado)) $plazasRefactorizado[] = $row['value'];
		}
        $plazas = !empty($plazasRefactorizado) ? $plazasRefactorizado : [' '];

		$infosRefactorizado = [];
		foreach ($infos as $row) {
			if (!in_array($row['value'], $infosRefactorizado)) $infosRefactorizado[] = $row['value'];
		}
        $infos = !empty($infosRefactorizado) ? $infosRefactorizado : [' '];

		$empresasRefactorizado = [];
		foreach ($empresas as $row) {
			if (!in_array($row['value'], $empresasRefactorizado)) $empresasRefactorizado[] = $row['value'];
		}
        $empresas = !empty($empresasRefactorizado) ? $empresasRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'CONFIGURACIÓN DE PLAZA',
			'data' => [
                [
				  'plaza' => null
				, 'info' => null
				, 'Valor' => null
				, 'empresa' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
				, 'fecIni' => null
				, 'fecFin' => null
                ]
			],
            'headers' => [
                  'PLAZA(*)'
                , 'TIPO INFO(*)'
                , 'VALOR(*)'
                , 'EMPRESA (COMPETENCIA)'
                , 'FECHA INICIO(*)'
                , 'FECHA FIN'

            ],
			'columns' => [
				['data' => 'plaza', 'type' => 'myDropdown', 'placeholder' => 'Plaza', 'width' => 400, 'source' => $plazas],
				['data' => 'info', 'type' => 'myDropdown', 'placeholder' => 'Info', 'width' => 200, 'source' => $infos],
				['data' => 'valor', 'type' => 'text', 'placeholder' => 'Valor', 'width' => 200],
				['data' => 'empresa', 'type' => 'myDropdown', 'placeholder' => 'Empresa', 'width' => 200, 'source' => $empresas],
				['data' => 'fecIni', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio', 'width' => 200],
				['data' => 'fecFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin', 'width' => 200],
	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaInfPlaza(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoInfPlaza'];

		$array['plazas'] = array();
		$array['infos'] = array();
		$array['empresas'] = array();

		$plazas = $this->model->getPlazas()->result_array();
		$infos = $this->model->getInfos()->result_array();
		$empresas= $this->model->getEmpresas()->result_array();

		foreach ($plazas as $key => $row) {
			$array['plazas'][$row['id']] = $row['value'];
		}
		foreach ($infos as $key => $row) {
			$array['infos'][$row['id']] = $row['value'];
		}
		foreach ($empresas as $key => $row) {
			$array['empresas'][$row['value']] = $row['id'];
		}

		$dataInsertMasivo = array();

		array_pop($post['HT'][0]);
		foreach ($post['HT'][0] as $key => $value) {
			if(!empty($value['plaza']) && !empty($value['info'])  && !empty($value['valor']) && !empty($value['fecIni'])){

				$numFecFin = !empty($value['fecFin'])? strtotime(str_replace('/', '-', $value['fecFin'])): strtotime(date('Y-m-d')) ;
				$numFecIni = strtotime(date_change_format_bd($value['fecIni']));
				if(empty($value['fecFin']) || $numFecFin >= $numFecIni ){

					$params = array(
						'sl_plazas' => array_search($value['plaza'],$array['plazas']),
						'sl_tipoInfo' => array_search($value['info'],$array['infos']),
					);

					if($this->model->checkConfInfoPlazaRepetido($params)){
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Se encontró un registro activo para la plaza y su tipo info. </br> Fila: '.($key+1)));
						goto respuesta;
					}

					$dataInsertMasivo[] = array(
						
						'idPlaza' => array_search($value['plaza'],$array['plazas']),
						'idInfo' => array_search($value['info'],$array['infos']),
						'idEmpresa' => !empty($value['empresa']) && !empty($array['empresas'][$value['empresa']]) ? $array['empresas'][$value['empresa']] : NULL,
						'valor' => $value['valor'],
						'fecIni' =>$value['fecIni'],
						
						//IF NOT NULL
						'fecFin' => !empty($value['fecFin'])? $value['fecFin']: NULL,

						'idCuenta' => '3',
						'idProyecto' => '3',
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);

				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'La Fecha Final no puede ser menor a la Fecha Inicial </br> Fila: '.($key+1)));
					goto respuesta;
				}
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos. </br> Fila: '.($key+1)));
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoInfPlaza($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}

	// SECCION CONFIGURACION DE CLIENTE
	public function getTablaConfPlaza()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getConfPlaza($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaConfPlaza', $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewConfPlaza()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();
		$dataParaVista['plazas'] = $this->model->getPlazas()->result_array();
		$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();
		$dataParaVista['tiposAuditoria'] = $this->model->getTipoAud()->result_array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewConfPlaza', $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarConfPlaza()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_plazas' => ['selectRequerido'],
			'sl_tipoCliente' => ['selectRequerido'],
			'sl_tipoAuditoria' => ['selectRequerido'],
			'audPromedio' => ['requerido'],
			'fechaInicio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkConfPlazaRepetido($post)) {
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría'));
			goto respuesta;
		}

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarConfPlaza($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateConfPlaza()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getConfPlaza($post)->row_array();
		$dataParaVista['plazas'] = $this->model->getPlazas($dataParaVista['data'])->result_array();
		$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();
		$dataParaVista['tiposAuditoria'] = $this->model->getTipoAud()->result_array();


		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateConfPlaza', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarConfPlaza()
	{
		$this->db->trans_start();
		
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_plazas' => ['selectRequerido'],
			'sl_tipoCliente' => ['selectRequerido'],
			'sl_tipoAuditoria' => ['selectRequerido'],
			'audPromedio' => ['requerido'],
			'fechaInicio' => ['requerido'],
        ];
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		if ($this->model->checkConfPlazaRepetido($post)) {
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría'));
			goto respuesta;
		}

		$actualizo = $this->model->actualizarConfPlaza($post);

		if (!$actualizo) {
			
			$result['result'] = 0;

			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaConfPlaza(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoConfPlaza'];

        $cuentas = $this->model->getCuentas()->result_array();
		$plazas = $this->model->getPlazas()->result_array();
		$tiposCliente = $this->model->getTiposCliente()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];

		$plazasRefactorizado = [];
		foreach ($plazas as $row) {
			if (!in_array($row['value'], $plazasRefactorizado)) $plazasRefactorizado[] = $row['value'];
		}
        $plazas = !empty($plazasRefactorizado) ? $plazasRefactorizado : [' '];

		$tiposClienteRefactorizado = [];
		foreach ($tiposCliente as $row) {
			if (!in_array($row['value'], $tiposClienteRefactorizado)) $tiposClienteRefactorizado[] = $row['value'];
		}
        $tiposCliente = !empty($tiposClienteRefactorizado) ? $tiposClienteRefactorizado : [' '];

		$tiposAuditoriaRefactorizado = [];
		foreach ($tiposAuditoria as $row) {
			if (!in_array($row['value'], $tiposAuditoriaRefactorizado)) $tiposAuditoriaRefactorizado[] = $row['value'];
		}
        $tiposAuditoria = !empty($tiposAuditoriaRefactorizado) ? $tiposAuditoriaRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'CONFIGURACIÓN DE PLAZA',
			'data' => [
                [
				  'plaza' => null
				, 'tipoCliente' => null
				, 'tipoAudExt' => null
				, 'promedio' => null
				, 'fecIni' => null
				, 'fecFin' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'PLAZA(*)'
                , 'TIPO CLIENTE(*)'
                , 'TIPO AUDITORIA(*)'
                , 'PROMEDIO'
                , 'FECHA INICIO(*)'
                , 'FECHA FIN'
            ],
			'columns' => [
				['data' => 'plaza', 'type' => 'myDropdown', 'placeholder' => 'Plaza', 'width' => 400, 'source' => $plazas],
				['data' => 'tipoCliente', 'type' => 'myDropdown', 'placeholder' => 'Tipo Cliente', 'width' => 200, 'source' => $tiposCliente],
				['data' => 'tipoAudExt', 'type' => 'myDropdown', 'placeholder' => 'Tipo Auditoria', 'width' => 200, 'source' => $tiposAuditoria],
				['data' => 'promedio', 'type' => 'text', 'placeholder' => 'Promedio Auditoria', 'width' => 200],
				['data' => 'fecIni', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio', 'width' => 200],
				['data' => 'fecFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin', 'width' => 200],
	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}
	public function guardarCargaMasivaConfPlaza(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoConfPlaza'];

		$array['plazas'] = array();
		$array['tiposCliente'] = array();
		$array['tiposAuditoria'] = array();

		$plazas = $this->model->getPlazas()->result_array();
		$tiposCliente = $this->model->getTiposCliente()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();

		foreach ($plazas as $key => $row) {
			$array['plazas'][$row['id']] = $row['value'];
		}
		foreach ($tiposCliente as $key => $row) {
			$array['tiposCliente'][$row['id']] = $row['value'];
		}
		foreach ($tiposAuditoria as $key => $row) {
			$array['tiposAuditoria'][$row['id']] = $row['value'];
		}

		$dataInsertMasivo = array();
		
		array_pop($post['HT'][0]);
		foreach ($post['HT'][0] as $key => $value) {
			if(!empty($value['plaza']) && !empty($value['tipoCliente']) && !empty($value['tipoAudExt']) && !empty($value['fecIni'])){
				
				$numFecFin = !empty($value['fecFin'])? strtotime(str_replace('/', '-', $value['fecFin'])): strtotime(date('Y-m-d')) ;
				$numFecIni = strtotime(date_change_format_bd($value['fecIni']));
				if(empty($value['fecFin']) || $numFecFin >= $numFecIni ){
						$params = array(
							'sl_plazas' => array_search($value['plaza'],$array['plazas']),
							'sl_tipoCliente' => array_search($value['tipoCliente'],$array['tiposCliente']),
							'sl_tipoAuditoria' => array_search($value['tipoAudExt'],$array['tiposAuditoria']),
						);
						if ($this->model->checkConfPlazaRepetido($params)) {
							$result['result'] = 0;
							$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría  </br> Fila: '.($key+1)));
							goto respuesta;
						}

						$dataInsertMasivo[] = array(
							
						'idPlaza' => array_search($value['plaza'],$array['plazas']),
						'idTipoCliente' => array_search($value['tipoCliente'],$array['tiposCliente']),
						'idExtAudTipo' => array_search($value['tipoAudExt'],$array['tiposAuditoria']),
						'fecIni' =>$value['fecIni'],
						'extAudPromedio' => $value['promedio'],
						
						//IF NOT NULL
						'extAudTotal' => !empty($value['total'])? $value['total']: NULL,
						'fecFin' => !empty($value['fecFin'])? $value['fecFin']: NULL,
						
						'idCuenta' => '3',
						'idProyecto' => '3',
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
						);
				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'La Fecha Final no puede ser menor a la Fecha Inicial </br> Fila: '.($key+1)));
					goto respuesta;
				}
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos </br> Fila: '.($key+1)));
				goto respuesta;
			}
		}

		$registro = $this->model->registroMasivoConfPlaza($dataInsertMasivo);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	
	// SECCION CONFIGURACION DE CLIENTE
	public function getTablaConfCliente()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getConfCliente($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaConfCliente', $dataParaVista, true);
			
		}

		echo json_encode($result);
	}
    public function getFormNewConfCliente()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();
		$dataParaVista['plazas'] = $this->model->getPlazas()->result_array();
		$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewConfCliente', $dataParaVista, true);

		echo json_encode($result);
    }
    public function getFormClienteAud()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = 'Registrar Cliente Auditoria';
		$dataParaVista = array();
		$dataParaVista['data'] = $this->model->getConfClientesAud($post)->result_array();
		
		$dataParaVista['idConfCliente'] = $post['id'];

		$result['result'] = 1;
		$result['data']['width'] = '85%';
		
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formClienteAud', $dataParaVista, true);
		

		echo json_encode($result);
    }
	public function getFormNewClienteAud(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = 'Registrar Nuevo Cliente Auditoría';
		$dataParaVista = array();
		$dataParaVista['tiposAuditoria'] = $this->model->getTipoAud()->result_array();
		$dataParaVista['idConfCliente'] = $post['id'];
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewClienteAud', $dataParaVista, true);
		

		echo json_encode($result);
	}
	public function registrarClienteAud()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			// 'sl_tipoAuditoria' => ['selectRequerido'],
			// 'valor_aud' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkClienteAudRepetido($post)){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría.'));
			$result['function'] = "Gestion.funcionRegistrarActivo = 'registrar' + 'ClienteAud'";
			goto respuesta;
		}

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarConfClienteAud($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

    public function getFormClienteAudDet()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Detalle de Auditoría Cliente';
		$dataParaVista = array();
		$dataParaVista['data'] = $this->model->getConfClientesAudDet($post)->result_array();
		$dataParaVista['idConfClienteAud'] = $post['id'];

		$result['result'] = 1;
		$result['data']['width'] = '85%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formClienteAudDet', $dataParaVista, true);

		echo json_encode($result);
    }
	public function getFormNewClienteAudDet(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = 'Registrar Nuevo Cliente Auditoría';
		$dataParaVista = array();
		
		$params = array(
			'idClienteAud' => $post['id'],
		);
		$data = $this->model->getConfClientesAud($params)->row_array();
		// $dataParaVista['materiales'] = $this->model->getMatExtByTipoAud($data['idExtAudTipo'])->result_array();
		$dataParaVista['idConfClienteAud'] = $post['id'];

		$params = array(

		);

		$tiposAud = $this->model->getTipoAud($data['idExtAudTipo'])->row_array();
		$dataParaVista['nombreLista'] = 'Lista: <b>'.$tiposAud['value'].'</b>';
		$dataParaVista['idExtAudTipo'] = $data['idExtAudTipo'];
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewClienteAudDet', $dataParaVista, true);
		

		echo json_encode($result);
	}
	public function registrarClienteAudDet()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			// 'sl_materiales' => ['selectRequerido'],
			// 'valor_aud' => ['requerido'],
		];
		if(empty($post['sl_materiales'])){
			$confClienteAud = $this->model->getConfClientesAud(['idClienteAud'=>$post['idConfClienteAud']])->row_array();
			$insert = [
				'idExtAudTipo' => $confClienteAud['idExtAudTipo'],
				'nombre' => $post['sch-tiendas'],
				'estado' => 1,
			];
			$this->model->registrarExtauditoriaMaterial($insert);
			$post['sl_materiales'] = $this->db->insert_id();
		}
		if(empty($post['sl_materiales'])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe seleccionar al menos un Material'));
			goto respuesta;
		}

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		$params = array(
			'idConfClienteAud' => $post['idConfClienteAud'],
			'idExtAudMat' => $post['sl_materiales'],
		);
		if ($this->model->checkClienteAudDetRepetido($params)){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para la Auditoria de Cliente y Material'));
			goto respuesta;
		}

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarConfClienteAudDet($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

    public function registrarConfCliente()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_clientes' => ['selectRequerido'],
			'sl_tipoCliente' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		$params = array(
			'sl_tipoCliente'=> $post['sl_tipoCliente'],
			'idCliente' => $post['sl_clientes'],
		);

		if ($this->model->checkConfClienteRepetido($params)){
			$result['result'] = 3;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Cliente'));
			goto respuesta;
		} 

		$registro = $this->model->registrarConfCliente($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateConfCliente()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getConfCliente($post)->row_array();
		$dataParaVista['plazas'] = $this->model->getPlazas()->result_array();
		
		if(!empty($dataParaVista['data']['idPlaza'])){
			$params = array(
				'idPlaza' => $dataParaVista['data']['idPlaza'],
			);
		}else{
			$params = array(
				'idCliente' => !empty($dataParaVista['data']['idCliente']) ?$dataParaVista['data']['idCliente'] :-1,
			);
		}

		$dataParaVista['clientes'] = $this->model->getClientes($params)->result_array();
		$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateConfCliente', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarConfCliente()
	{
		$this->db->trans_start();
		
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_clientes' => ['selectRequerido'],
			'sl_tipoCliente' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
        ];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$params = array(
			'sl_tipoCliente'=> $post['sl_tipoCliente'],
			'idCliente' => $post['sl_clientes'],
			'idx' => $post['idx'],
		);
		if ($this->model->checkConfClienteRepetido($params)){
			$result['result'] = 3;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Cliente'));
			goto respuesta;
		} 

		$actualizo = $this->model->actualizarConfCliente($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function actualizarEstadoConfClienteAudDet()
	{
		$this->db->trans_start();
		
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Cambiar Presencia';

		$elementosAValidar = [
			// 'sl_clientes' => ['selectRequerido'],
			// 'sl_tipoCliente' => ['selectRequerido'],
			// 'fechaInicio' => ['requerido'],
        ];
        
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarEstadoConfClienteAudDet($post);

		if (!$actualizo) {
			
			$result['result'] = 0;
			$result['data']['html'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['data']['html'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaConfCliente(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoConfCliente'];

        $cuentas = $this->model->getCuentas()->result_array();
		$tiposCliente = $this->model->getTiposCliente()->result_array();
		$materiales = $this->model->getMatExt()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();

		$dataParaVista['confClientes'] = $this->model->getConfClienteTipoCb()->result_array();
		$dataParaVista['plazas'] = $this->model->getPlazas()->result_array();
		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];


		$tiposClienteRefactorizado = [];
		foreach ($tiposCliente as $row) {
			if (!in_array($row['value'], $tiposClienteRefactorizado)) $tiposClienteRefactorizado[] = $row['value'];
		}
        $tiposCliente = !empty($tiposClienteRefactorizado) ? $tiposClienteRefactorizado : [' '];


		$materialesfactorizado = [];
		foreach ($materiales as $row) {
			if (!in_array($row['value'], $materialesfactorizado)) $materialesfactorizado[] = $row['value'];
		}
        $materiales = !empty($materialesfactorizado) ? $materialesfactorizado : [' '];

		$tiposAuditoriaRefactorizado = [];
		foreach ($tiposAuditoria as $row) {
			if (!in_array($row['value'], $tiposAuditoriaRefactorizado)) $tiposAuditoriaRefactorizado[] = $row['value'];
		}
        $tiposAuditoria = !empty($tiposAuditoriaRefactorizado) ? $tiposAuditoriaRefactorizado : [' '];
        
		$flag = array(
			0 => "SI",
			1 => "NO",
		);

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'CONFIGURACIÓN DE CLIENTE',
			'data' => [
                [
				  'cliente' => null
				, 'tipoCliente' => null
				, 'fecIni' => null
				, 'fecFin' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
    
                ]
			],
            'headers' => [
                  'CÓDIGO CLIENTE(*)'
                , 'TIPO CLIENTE(*)'
                , 'FECHA INICIO(*)'
                , 'FECHA FIN'
            ],
			'columns' => [
				['data' => 'cliente', 'type' => 'numeric', 'placeholder' => 'Cliente', 'width' => 200],
				['data' => 'tipoCliente', 'type' => 'myDropdown', 'placeholder' => 'Tipo Cliente', 'width' => 200, 'source' => $tiposCliente],
				['data' => 'fecIni', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio', 'width' => 200],
				['data' => 'fecFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin', 'width' => 200],
	
			],
			'colWidths' => 200,
        ];
		$HT[1] = [
			'nombre' => 'CONFIGURACIÓN AUDITORÍA DE CLIENTE',
			'data' => [
                [
				  'idCliente' => null
				, 'tipoAuditoria' => null
				, 'material' => null
                , 'presencia' => null 
    
                ]
			],
            'headers' => [
                  'CÓDIGO CLIENTE(*)'
                , 'TIPO AUDITORÍA(*)'
				, 'MATERIAL(*)'
                , 'PRESENCIA'
            ],
			'columns' => [
				['data' => 'idCliente', 'type' => 'numeric', 'placeholder' => 'Código Cliente', 'width' => 200],
				['data' => 'tipoAuditoria', 'type' => 'myDropdown', 'placeholder' => 'Tipo Auditoría', 'width' => 200, 'source' => $tiposAuditoria],
				['data' => 'material', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'Material', 'source'=>$materiales, 'width' => 300],
				['data' => 'presencia', 'type' => 'myDropdown', 'placeholder' => 'Presencia','source'=> $flag ,'width' => 200],
	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'], 1=>$HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivConfCliente',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}
	public function guardarCargaMasivaConfCliente(){

		ini_set('memory_limit','2048M');
		set_time_limit(0);

		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoConfCliente'];

		$array['materiales'] = array();
		$array['tiposCliente'] = array();
		$array['tiposAuditoria'] = array();
		$array['confClientes'] = array();

		$tiposCliente = $this->model->getTiposCliente()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();
		$confClientes = $this->model->getConfigClienteAud(['vigente'=>1,'activo'=>1])->result_array();

	
		foreach ($tiposCliente as $key => $row) {
			$array['tiposCliente'][$row['id']] = $row['value'];
		}
		foreach ($tiposAuditoria as $key => $row) {
			$array['tiposAuditoria'][$row['id']] = $row['value'];
		}
		foreach ($confClientes as $key => $row) {
			$array['confClientes'][$row['idCliente']] = $row['idConfCliente'];
		}

		$dataInsertMasivo = array();
		
		//Configuracion de Cliente
		$confClienteId = [];
		array_pop($post['HT'][0]);
		foreach ($post['HT'][0] as $key => $value) {
			if(!empty($value['cliente']) && !empty($value['tipoCliente']) && !empty($value['fecIni'])){
				$numFecFin = !empty($value['fecFin'])? strtotime(str_replace('/', '-', $value['fecFin'])): strtotime(date('Y-m-d')) ;
				$numFecIni = strtotime(date_change_format_bd($value['fecIni']));
				if( empty($value['fecFin']) || $numFecFin >= $numFecIni ){
					$params = array(
						'idCliente' => $value['cliente'],
						'idCuenta' => '3',
						'idProyecto' => '3',
					);
				
					if (!empty($array['confClientes'][$value['cliente']])){
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe una configuración activa para el Cliente y su Tipo. </br> Fila:'.($key+1)));
						goto respuesta;
					} 
					if(empty($confCliente)){
						$dataInsertMasivo[] = array(
							'idCliente' => $value['cliente'],
							'idTipoCliente' => array_search($value['tipoCliente'],$array['tiposCliente']),
							'fecIni' =>$value['fecIni'],
							//IF NOT NULL
							'estado' => 1,
							'fecFin' => !empty($value['fecFin'])? $value['fecFin']: NULL,
							'idCuenta' => '3',
							'idProyecto' => '3',
							'idUsuarioReg'=> $this->session->userdata('idUsuario'),
						);
					}
				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'La fecha Final no puede ser menor a la Fecha inicial </br> Fila: '.($key+1)));
					goto respuesta;
				}
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos </br> Fila: '.($key+1)));
				goto respuesta;
			}
		}
		
		if(!empty($dataInsertMasivo)){
			$confClienteId = $this->model->registroMasivoConfClienteBatch($dataInsertMasivo);
			$registro = $confClienteId;
		}else{
			$registro = false;
		}
		//Configuracion auditoria de Cliente
		array_pop($post['HT'][1]);
		$confClienteAudInsert = [];


		if(!empty($post['HT'][1])){
			$materiales = $this->model->getMatExt()->result_array();
			foreach ($materiales as $key => $row) {
				$array['materiales'][$row['id']] = $row['value'];
			}
			$array['confClientes'] = array();
			$array['confClientesAud'] = array();
			$confClientes = $this->model->getConfigClienteAud(['vigente'=>1,'activo'=>1])->result_array();
			foreach ($confClientes as $key => $row) {
				$array['confClientes'][$row['idCliente']] = $row['idConfCliente'];
				$array['confClientesAud'][$row['idCliente']][$row['idExtAudTipo']] = $row['idConfClienteAud'];
			}
		}
		$updatewhere = [];
		$insertClienteAudDet = array();
		foreach ($post['HT'][1] as $key => $value) {
			if(!empty($value['idCliente']) && !empty($value['tipoAuditoria']) && !empty($value['material'])){
				
				$insertClienteAud = array();
				

				$params = array(
					'idCliente' => $value['idCliente'],
					'sl_tipoAuditoria' => array_search($value['tipoAuditoria'],$array['tiposAuditoria']),
				);

				$idExtAudTipo = array_search($value['tipoAuditoria'],$array['tiposAuditoria']);

				// if(empty($confClienteAudInsert[$idExtAudTipo][$value['idCliente']])){
				if(empty($array['confClientesAud'][$value['idCliente']][$idExtAudTipo])){
					if(!empty($array['confClientes'][$value['idCliente']])){

						$insertClienteAud[] = array(
							'idConfCliente' => $array['confClientes'][$value['idCliente']],
							'idExtAudTipo' => array_search($value['tipoAuditoria'],$array['tiposAuditoria']),
							'valor'=> 0,
						);
						$registro = $this->model->registroMasivoConfClienteAud($insertClienteAud);//Registro Cliente Aud
						$idClienteAud = $this->db->insert_id();
						// $confClienteAudInsert[array_search($value['tipoAuditoria'],$array['tiposAuditoria'])][$value['idCliente']] = $idClienteAud;
						$array['confClientesAud'][$value['idCliente']][$idExtAudTipo] = $idClienteAud;
					}else{
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'No se encontró una configuración de cliente activa para el ID: '.$value['idCliente'].'  </br> Hoja(2) - Fila: '.($key+1)));
						goto respuesta;
					}
				}else{
					$idClienteAud = $array['confClientesAud'][$value['idCliente']][$idExtAudTipo];
				}
				
				if(array_search($value['material'],$array['materiales'])){
					$idMaterial = array_search($value['material'],$array['materiales']);
				}else{
					$insertMatExt = array(
						'idExtAudTipo' => array_search($value['tipoAuditoria'],$array['tiposAuditoria']),
						'nombre'=>strtoupper($value['material']),
						'estado' => 1,
					);
					$this->model->registrarMatExt($insertMatExt);
					$idMaterial = $this->db->insert_id();
					$array['materiales'][$idMaterial] = strtoupper($value['material']);
				}

				$insertClienteAudDet[] = array(
					'idConfClienteAud' => $idClienteAud,
					'idExtAudMat' => $idMaterial,
					'presencia' =>(!empty($value['presencia']) && $value['presencia'] == "SI") ? true : false ,
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
				
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos </br> Hoja(2) - Fila: '.($key+1)));
				goto respuesta;
			}
		}

		if(!empty($insertClienteAudDet)){
			$registro = $this->model->registroMasivoConfClienteAudDet2($insertClienteAudDet);
		}

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	// SECCION CONFIGURACION DE CLIENTE
	public function getTablaConfTipoCliente()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getConfTipoCliente($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaConfTipoCliente', $dataParaVista, true);
		}

		echo json_encode($result);
	}
    public function getFormNewConfTipoCliente()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();
		$dataParaVista['tiposAuditoria'] = $this->model->getTipoAud()->result_array();
		$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewConfTipoCliente', $dataParaVista, true);

		echo json_encode($result);
    }
	public function getMatExtByTipoAud(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		
		$materiales = $this->model->getMatExtByTipoAud($post['id'])->result_array();
		
		$result['data']['materiales'] = htmlSelectOptionArray($materiales);
		$result['result'] = 1;
		echo json_encode($result);
	}
  
    public function registrarConfTipoCliente()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_tipoCliente' => ['selectRequerido'],
			'sl_tipoAuditoria' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		if ($this->model->checkConfTipoClienteAudRepetido($post)){
			$result['result'] = 3;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría '));
			goto respuesta;
		} 
		$registro = $this->model->registrarConfTipoCliente($post);
		$idConfTipoClienteAud = $this->db->insert_id();
		$insertAudDet = [];
		if(!empty($post['idMaterial'])){
			if(is_array($post['idMaterial'])){
				$insertAudDet['idExtAudMat'] = $post['idMaterial'];

			}else{
				$insertAudDet = array(
					'idExtAudMat' => $post['idMaterial'],
					'idTipoClienteAud'=>$idConfTipoClienteAud
				);
			}
		}
		//Redifinimos la variable insertAudDet
		
		$push_all = array(
			'idTipoClienteAud'=> $idConfTipoClienteAud,
		);

		$insertAudDet = getDataRefactorizada($insertAudDet,$push_all);//Push_all es opcional para añadir el elemento a todas las variables

		if(!empty($insertAudDet)){
			$registro2 = $this->model->registrarConfTipoClienteDet($insertAudDet);
		}
		
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	
	public function getFormUpdateConfTipoCliente()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getConfTipoCliente($post)->row_array();
		$dataParaVista['dataDet'] = $this->model->getConfTipoClienteDet($post)->result_array();
		$dataParaVista['tiposAuditoria'] = $this->model->getTipoAud()->result_array();
		$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();
		$dataParaVista['materiales']= $this->model->getMatExtByTipoAud($dataParaVista['data']['idExtAudTipo'])->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateConfTipoCliente', $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarConfTipoCliente()
	{
		$this->db->trans_start();
		
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'sl_tipoCliente' => ['selectRequerido'],
			'sl_tipoAuditoria' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
        ];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		if ($this->model->checkConfTipoClienteAudRepetido($post)){
			$result['result'] = 3;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría '));
			goto respuesta;
		} 

		$insertAudDet = [];
		if(!empty($post['idMaterial'])){
			if(is_array($post['idMaterial'])){
				$insertAudDet['idExtAudMat'] = $post['idMaterial'];

			}else{
				$insertAudDet = array(
					'idExtAudMat' => $post['idMaterial'],
					'idTipoClienteAud'=> $post['idx'] ,
				);
			}
		}
		//Redifinimos la variable insertAudDet
		$push_all = array(
			'idTipoClienteAud'=> $post['idx'] ,
		);

		$insertAudDet = getDataRefactorizada($insertAudDet,$push_all);//Push_all es opcional para añadir el elemento a todas las variables

		$actualizo = $this->model->actualizarConfTipoClienteDet($post,$insertAudDet);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaConfTipoCliente(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoConfTipoCliente'];

        $cuentas = $this->model->getCuentas()->result_array();
		$materiales = $this->model->getMatExt()->result_array();
		$tiposCliente = $this->model->getTiposCliente()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();

		//REFACTORIZANDO DATA
        
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];

		$matRefactorizado = [];
		foreach ($materiales as $row) {
			if (!in_array($row['value'], $matRefactorizado)) $matRefactorizado[] = $row['value'];
		}
        $materiales = !empty($matRefactorizado) ? $matRefactorizado : [' '];

		$tiposClienteRefactorizado = [];
		foreach ($tiposCliente as $row) {
			if (!in_array($row['value'], $tiposClienteRefactorizado)) $tiposClienteRefactorizado[] = $row['value'];
		}
        $tiposCliente = !empty($tiposClienteRefactorizado) ? $tiposClienteRefactorizado : [' '];

		$tiposAuditoriaRefactorizado = [];
		foreach ($tiposAuditoria as $row) {
			if (!in_array($row['value'], $tiposAuditoriaRefactorizado)) $tiposAuditoriaRefactorizado[] = $row['value'];
		}
        $tiposAuditoria = !empty($tiposAuditoriaRefactorizado) ? $tiposAuditoriaRefactorizado : [' '];
        

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'CONFIGURACIÓN DE TIPO CLIENTE',
			'data' => [
                [
				  'tipoCliente' => null
				, 'tipoAudExt' => null
				, 'material' => null
                , 'cuenta' => 'P&G' 
                , 'proyecto' => 'TRADE' 
				, 'fecIni' => null
				, 'fecFin' => null
    
                ]
			],
            'headers' => [
                  'TIPO CLIENTE(*)'
                , 'TIPO AUDITORIA(*)'
                , 'MATERIAL(*)'
                , 'FECHA INICIO(*)'
                , 'FECHA FIN'
            ],
			'columns' => [
				['data' => 'tipoCliente', 'type' => 'myDropdown', 'placeholder' => 'Tipo Cliente', 'width' => 200, 'source' => $tiposCliente],
				['data' => 'tipoAudExt', 'type' => 'myDropdown', 'placeholder' => 'Tipo Auditoria', 'width' => 200, 'source' => $tiposAuditoria],
				['data' => 'material', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'Materiales', 'width' => 350, 'source' => $materiales],
				['data' => 'fecIni', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio', 'width' => 200],
				['data' => 'fecFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin', 'width' => 200],
	
			],
			'colWidths' => 200,
        ];
        
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}
	public function guardarCargaMasivaConfTipoCliente(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoConfTipoCliente'];

		$array['materiales'] = array();
		$array['tiposCliente'] = array();
		$array['tiposAuditoria'] = array();

		$materiales = $this->model->getMatExt()->result_array();
		$tiposCliente = $this->model->getTiposCliente()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();


		foreach ($materiales as $key => $row) {
			$array['materiales'][$row['idExtAudTipo']][$row['id']] = $row['value'];
		}
		foreach ($tiposCliente as $key => $row) {
			$array['tiposCliente'][$row['id']] = $row['value'];
		}
		foreach ($tiposAuditoria as $key => $row) {
			$array['tiposAuditoria'][$row['id']] = $row['value'];
		}

		$dataInsertMasivo = array();
		
		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][0] as $key => $value) {
			if(!empty($value['tipoCliente']) && !empty($value['tipoAudExt']) && !empty($value['fecIni']) && !empty($value['material'])){
				
				$numFecFin = !empty($value['fecFin'])? strtotime(str_replace('/', '-', $value['fecFin'])): strtotime(date('Y-m-d')) ;
				$numFecIni = strtotime(date_change_format_bd($value['fecIni']));
				if( empty($value['fecFin']) || $numFecFin >= $numFecIni ){

					$params = array(
						'sl_tipoCliente' => array_search($value['tipoCliente'],$array['tiposCliente']),
						'sl_tipoAuditoria' =>  array_search($value['tipoAudExt'],$array['tiposAuditoria']),
						'fechaInicio' => $value['fecIni'],
					);

					if($this->model->checkConfTipoClienteAudRepetido($params)){
						$idTipoClienteAud = $this->model->checkConfTipoClienteAudRepetido($params);

					}else{
						$insertTipoCliente = array(
							'sl_tipoCliente' => array_search($value['tipoCliente'],$array['tiposCliente']),
							'sl_tipoAuditoria' =>  array_search($value['tipoAudExt'],$array['tiposAuditoria']),
							'sl_cuenta' =>3,
							'sl_proyecto'=>3,
							'fechaInicio' => $value['fecIni'],
							
						);
						!empty($value['fecFin']) ? $insertTipoCliente['fechaFin'] = $value['fecFin']: '';
						$this->model->registrarConfTipoCliente($insertTipoCliente);
						$idTipoClienteAud = $this->db->insert_id();
					}
					$idTipoAuditoria = array_search($value['tipoAudExt'],$array['tiposAuditoria']);
					$idMaterial = array_search($value['material'],$array['materiales'][$idTipoAuditoria]);

					if(!empty($idMaterial)){
						$idExtAudMat = array_search($value['material'],$array['materiales'][array_search($value['tipoAudExt'],$array['tiposAuditoria'])]);
					}else{

						$insertMaterial = array(
							'nombre' => $value['material'],
							'idExtAudTipo'=> array_search($value['tipoAudExt'],$array['tiposAuditoria'])
						);

						$this->model->registrarMatExt($insertMaterial);
						$idExtAudMat = $this->db->insert_id();
					}

					$params = array(
						'idTipoClienteAud' => $idTipoClienteAud,
						'idExtAudMat' => $idExtAudMat
					);

					if(!empty($this->model->checkConfTipoClienteAudDetRepetido($params))){
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Dentro de la Lista existe un registro duplicado para el Material <strong>'.$value['material'].'</strong> </br> Fila: '.($key+1)));
						goto respuesta;
					}

					$dataInsertMasivo[] = array(
						'idTipoClienteAud' =>	$idTipoClienteAud ,
						'idExtAudMat' => $idExtAudMat,
						'estado' =>1,
					);

				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'La fecha de fin no puede ser menor a la fecha inicial </br> Fila: '.($key+1)));
					goto respuesta;
				}
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos </br> Fila: '.($key+1)));
				goto respuesta;
			}
		}


		$registro = $this->model->registrarConfTipoClienteDet($dataInsertMasivo);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}
	
		// SECCION LISTA EVALUACIOn
		public function getTablaListaEvaluacion()
		{
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
	
			$data = $this->model->getListaEvaluacion($post)->result_array();
	
			$result['result'] = 1;
			if (count($data) < 1) {
				$result['data']['html'] = getMensajeGestion('noResultados');
			} else {
				$dataParaVista['data'] = $data;
				$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaListaEvaluacion', $dataParaVista, true);
			}
	
			echo json_encode($result);
		}
	
		public function getFormNewListaEvaluacion()
		{
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
			
			$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
			$dataParaVista = array();
			$dataParaVista['tiposAuditoria'] = $this->model->getTiposAuditoria()->result_array();
			$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();
			$dataParaVista['evaluaciones'] = $this->model->getEvaluacionesDet()->result_array();
			$dataParaVista['encuestas'] = $this->model->getEncuestas()->result_array();

			$result['result'] = 1;
			$result['data']['width'] = '60%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewListaEvaluacion', $dataParaVista, true);
	
			echo json_encode($result);
		}
		public function registrarListaEvaluacion()
		{
			$this->db->trans_start();
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
	
	
			$elementosAValidar = [
				'sl_tipoAuditoria' => ['selectRequerido'],
				'fechaInicio' => ['requerido'],
			];
			
			if(!empty($post['sl_tipoAuditoria']) && $post['sl_tipoAuditoria'] == 2){
				$elementosAValidar['sl_tipoCliente'] = ['selectRequerido'];
			}
			
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
	
			$result['data']['validaciones'] = $validaciones;
	
			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}
	
			if ($this->model->checkListaEvaluacionRepetida($post)){
				$result['result'] = 3;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un Registro activo para el Tipo de Cliente y Tipo Auditoría '));
				goto respuesta;
			} 
			$registro = $this->model->registrarListaEvaluacion($post);

			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
				goto respuesta;
			} 
			$idListaEvaluacion = $this->db->insert_id();

			$insertListaDet = [];
			if(!empty($post['idEvaluacion'])){
				if(is_array($post['idEvaluacion'])){
					$insertListaDet['idEvaluacionDet'] = $post['idEvaluacion'];
					// if($post['sl_tipoAuditoria'] == 2){
						$insertListaDet['idEncuesta'] = $post['idEncuesta'] ;
					// }
					
				}else{
					$insertListaDet = array(
						'idEvaluacionDet' => $post['idEvaluacion'],
					);
					// if($post['sl_tipoAuditoria'] == 2){
						$insertListaDet['idEncuesta'] = $post['idEncuesta'] ;
					// }
				}
			}
			//Redifinimos la variable insertListaDet

			$push_all = array(
				'idListEval'=> $idListaEvaluacion,
				'idUsuarioReg' => $this->session->userdata('idUsuario'),
			);

			$insertListaDet = getDataRefactorizada($insertListaDet,$push_all);//Push_all es opcional para añadir el elemento a todas las variables

			if(!empty($insertListaDet)){
				$registro2 = $this->model->registrarListaEvaluacionDet($insertListaDet);
			}

			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('registroExitoso');
			}

			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		
		public function getFormUpdateListaEvaluacion()
		{
			$result = $this->result;
			
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
	
			$dataParaVista['data'] = $this->model->getListaEvaluacion($post)->row_array();
			$dataParaVista['tiposAuditoria'] = $this->model->getTiposAuditoria()->result_array();
			$dataParaVista['tiposCliente'] = $this->model->getTiposCliente()->result_array();
			$dataParaVista['evaluaciones'] = $this->model->getEvaluacionesDet()->result_array();
			$dataParaVista['encuestas'] = $this->model->getEncuestas()->result_array();
			$dataParaVista['evalDet']= $this->model->getListaEvaluacionDet($dataParaVista['data'])->result_array();
			
			$result['result'] = 1;
			$result['data']['width'] = '60%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateListaEvaluacion', $dataParaVista, true);
	
			echo json_encode($result);
		}
		public function actualizarListaEvaluacion()
		{
			$this->db->trans_start();
		
			$result = $this->result;
			
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
	
			$elementosAValidar = [
				// 'nombre' => ['requerido'],
			];
			
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
	
			$result['data']['validaciones'] = $validaciones;
	
			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}

			if ($this->model->checkListaEvaluacionRepetida($post)){
				$result['result'] = 3;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe una lista activa para el Tipo Auditoría '));
				goto respuesta;
			} 
			$actualizo = $this->model->actualizarListaEvaluacion($post);
	
			if (!$actualizo) {
				
				$result['result'] = 0;
	
				$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		public function getFormCargaMasivaListaEvaluacion(){
			$result = $this->result;
		
			$result['msg']['title'] = $this->titulo['masivoListaEvaluacion'];
	
			$cuentas = $this->model->getCuentas()->result_array();
		  
			$tiposCliente = $this->model->getTiposCliente()->result_array();
			$tiposAuditoria= $this->model->getTiposAuditoria()->result_array();
			$evaluaciones = $this->model->getEvaluacionesDet()->result_array();
			$encuestas= $this->model->getEncuestas()->result_array();

			//REFACTORIZANDO DATA
			
			$cuentasRefactorizado = [];
			foreach ($cuentas as $row) {
				if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
			}
			$cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
			
			$tiposClienteRefactorizado = [];
			foreach ($tiposCliente as $row) {
				if (!in_array($row['value'], $tiposClienteRefactorizado)) $tiposClienteRefactorizado[] = $row['value'];
			}
			$tiposCliente = !empty($tiposClienteRefactorizado) ? $tiposClienteRefactorizado : [' '];
	
			$tiposAuditoriaRefactorizado = [];
			foreach ($tiposAuditoria as $row) {
				if (!in_array($row['value'], $tiposAuditoriaRefactorizado)) $tiposAuditoriaRefactorizado[] = $row['value'];
			}
			$tiposAuditoria = !empty($tiposAuditoriaRefactorizado) ? $tiposAuditoriaRefactorizado : [' '];

			$evalRefactorizado = [];
			foreach ($evaluaciones as $row) {
				if (!in_array($row['value'], $evalRefactorizado)) $evalRefactorizado[] = $row['value'];
			}
			$evaluaciones = !empty($evalRefactorizado) ? $evalRefactorizado : [' '];

			$encRefactorizado = [];
			foreach ($encuestas as $row) {
				if (!in_array($row['value'], $encRefactorizado)) $encRefactorizado[] = $row['value'];
			}
			$encuestas = !empty($encRefactorizado) ? $encRefactorizado : [' '];
			

			//ARMANDO HANDSONTABLE
			$HT[0] = [
				'nombre' => 'Lista Evaluación',
				'data' => [
					['tipoAuditoria' => null
					,'tipoCliente' => null
					,'fecIni' => null
					,'fecFin' => null
					,'evaluacion' => null
					,'encuesta' => null
					,'cuenta' => 'P&G' 
					,'proyecto' => 'TRADE' 
		
					]
				],
				'headers' => [
					  'TIPO AUDITORÍA'
					, 'TIPO CLIENTE'
					, 'FECHA INICIO (*)'
					, 'FECHA FIN'
					, 'EVALUACION (*)'
					, 'ENCUESTA'
				],
				'columns' => [
					['data' => 'tipoAuditoria', 'type' => 'myDropdown', 'placeholder' => 'Tipo Auditoria', 'width' => 200,'source'=>$tiposAuditoria],
					['data' => 'tipoCliente', 'type' => 'myDropdown', 'placeholder' => 'Tipo Cliente', 'width' => 200,'source'=>$tiposCliente],
					['data' => 'fecIni', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio', 'width' => 200],
					['data' => 'fecFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin', 'width' => 200],
					['data' => 'evaluacion', 'type' => 'myDropdown', 'placeholder' => 'Evaluaciones (*)', 'width' => 200,'source'=>$evaluaciones],
					['data' => 'encuesta', 'type' => 'myDropdown', 'placeholder' => 'Encuesta', 'width' => 200,'source'=>$encuestas],
		
				],
				'colWidths' => 200,
			];
			
		
			//MOSTRANDO VISTA
			$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
			$result['result'] = 1;
			$result['data']['width'] = '70%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
			$result['data']['ht'] = $HT;
	
			echo json_encode($result);
		}
		public function guardarCargaMasivaListaEvaluacion(){
			$this->db->trans_start();
			$result = $this->result;
	
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['masivoListaEvaluacion'];
			
			$array = array(
				'tiposCliente' => array(),
				'tiposAuditoria' => array(),
				'evaluaciones' => array(),
				'encuestas' => array(),
			);
			$tiposCliente = $this->model->getTiposCliente()->result_array();
			$tiposAuditoria= $this->model->getTiposAuditoria()->result_array();
			$evaluaciones = $this->model->getEvaluacionesDet()->result_array();
			$encuestas= $this->model->getEncuestas()->result_array();

			$dataInsertMasivo = array();

			foreach ($evaluaciones as $key => $row) {
				$array['evaluaciones'][$row['id']] = $row['value'];
			}

			foreach ($encuestas as $key => $row) {
				$array['encuestas'][$row['id']] = $row['value'];
			}
			foreach ($tiposCliente as $key => $row) {
				$array['tiposCliente'][$row['id']] = $row['value'];
			}
			foreach ($tiposAuditoria as $key => $row) {
				$array['tiposAuditoria'][$row['id']] = $row['value'];
			}	
		 	array_pop($post['HT'][0]);
	
			foreach ($post['HT'][0] as $key => $value) {
				if(!empty($value['tipoAuditoria']) && !empty($value['evaluacion']) && $value['fecIni']){

					$params = array(
						'sl_tipoAuditoria' => array_search($value['tipoAuditoria'],$array['tiposAuditoria']),
						'sl_tipoCliente' => array_search($value['tipoCliente'],$array['tiposCliente']),
						'fechaInicio' => $value['fecIni'],
					);
					if ($this->model->checkListaEvaluacionRepetida($params)){
						$idlistEval = $this->model->checkListaEvaluacionRepetida($params);
					}else{
						$insertListEval = array(
							'sl_tipoAuditoria' => $value['tipoAuditoria'],
							'fechaInicio' => $value['fecIni'],

							'sl_cuenta' => 3,
							'sl_proyecto' => 3,

							'sl_tipoCliente'=> !empty($value['tipoCliente'])? :'' ,
							'fechaFin'=> !empty($value['fecFin'])? :'' ,
						);
						$this->model->registrarListaEvaluacion();
						$idlistEval = $this->db->insert_id();
					}	
					$params = array(
						'idListEval'=>$idlistEval,
						'idEvaluacionDet' => array_search($value['evaluacion'],$array['evaluaciones']),
						'idEncuesta' => array_search($value['encuesta'],$array['encuestas']),
					);
					$listEvalDet = $this->model->getListaEvaluacionDet($params)->result_array();

					if(empty($listEvalDet)){
						$dataInsertMasivo[] = array(
							'idListEval'=>$idlistEval,
							'idEvaluacionDet' => array_search($value['evaluacion'],$array['evaluaciones']),
							'idEncuesta' => array_search($value['encuesta'],$array['encuestas']),
							'idUsuarioReg'=> $this->session->userdata('idUsuario'),
						);
					}else{
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe una evaluación/encuesta activa para esa Lista.<br> Fila: '.($key+1)));
						goto respuesta;
					}
				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos'));
					goto respuesta;
				}
			}
			$registro = 0;
			$registro = $this->model->registrarListaEvaluacionDet($dataInsertMasivo);
			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('registroExitoso');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}

	//SECCION PREGUNTAS

	public function getTablaPreguntas(){
		$result = $this->result;
		$input = json_decode($this->input->post('data'), true);

			$query = $this->model->consultarPreguntas($input);
			if( empty($query) ){
				$result['data']['html'] = getMensajeGestion('noResultados');
			}
			else{
				$data['data'] = $query;
				$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/encuesta/consultar', $data, true);
			}
		echo json_encode($result);
	}
	public function getFormNewPreguntas(){
		$result = $this->result;
		$data = array(
				'frm' => 'frm-live-encuesta-nuevo',
				'tipos' => array()
			);

		$query = $this->model->listTipoPreg();
		foreach($query as $row){
			$data['tipos'][$row['id']]['nombre'] = $row['nombre'];
		}
		unset($query, $row);

		$data['cuenta'] = $this->m_control->get_cuenta();
		$data['tiposAuditoria'] = $this->model->getTipoAud()->result_array();

		$result['msg']['title'] = 'Nuevo Formato';
		$result['data']['frm'] = $data['frm'];
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/encuesta/nuevo', $data, true);
		echo json_encode($result);
	}

	public function registrarPreguntas(){
		$result  = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$elementosAValidar = [
				'encuesta' => ['requerido'],
			];
			
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $input);
	
			$result['data']['validaciones'] = $validaciones;
	
			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}

			$where = array(
				'nombre'=>trim($input['encuesta']),
				'estado' => 1,
			);
			$checkEnc = $this->db->get_where('lsck.tipoEncuesta',$where)->result_array();

			if(!empty($checkEnc)){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un formato de preguntas con el nombre: '.$input['encuesta']));
				goto respuesta;
			}

			$query = $this->model->guardarPregEval($input);
			if( $query['status'] ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array( 'type' => 1, 'message'=> 'Se cambió el estado del registro correctamente'));
			}
			else{
				if( !empty($query['msg']) ){
					$result['msg']['content'] = createMessage(array( 'type' => 0, 'message' => $query['msg'] ));
				}
				else{
					$result['msg']['content'] = createMessage(array( 'type' => 0 ));
				}
			}

		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaPreguntas(){
		$result = $this->result;
	
		$result['msg']['title'] = $this->titulo['masivoListaEvaluacion'];

		$cuentas = $this->model->getCuentas()->result_array();
	  
		$tiposPregunta = $this->model->getTiposPregunta()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();
		$evaluaciones = $this->model->getEvaluacionesDet()->result_array();
		$encuestas= $this->model->getEncuestas()->result_array();
		$preguntas= $this->model->getPreguntas()->result_array();

		//REFACTORIZANDO DATA
		
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
		}
		$cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
		
		$tpPreguntaRefactorizado = [];
		foreach ($tiposPregunta as $row) {
			if (!in_array($row['value'], $tpPreguntaRefactorizado)) $tpPreguntaRefactorizado[] = $row['value'];
		}
		$tiposPregunta = !empty($tpPreguntaRefactorizado) ? $tpPreguntaRefactorizado : [' '];

		$tiposAuditoriaRefactorizado = [];
		foreach ($tiposAuditoria as $row) {
			if (!in_array($row['value'], $tiposAuditoriaRefactorizado)) $tiposAuditoriaRefactorizado[] = $row['value'];
		}
		$tiposAuditoria = !empty($tiposAuditoriaRefactorizado) ? $tiposAuditoriaRefactorizado : [' '];

		$evalRefactorizado = [];
		foreach ($evaluaciones as $row) {
			if (!in_array($row['value'], $evalRefactorizado)) $evalRefactorizado[] = $row['value'];
		}
		$evaluaciones = !empty($evalRefactorizado) ? $evalRefactorizado : [' '];

		$encRefactorizado = [];
		foreach ($encuestas as $row) {
			if (!in_array($row['value'], $encRefactorizado)) $encRefactorizado[] = $row['value'];
		}
		$encuestas = !empty($encRefactorizado) ? $encRefactorizado : [' '];

		$pregRefactorizada = [];
		foreach ($preguntas as $row) {
			if (!in_array($row['value'], $pregRefactorizada)) $pregRefactorizada[] = $row['value'];
		}
		$preguntas = !empty($pregRefactorizada) ? $pregRefactorizada : [' '];
		
		$flagPresencia = array(
			0 => "NO PRESENTES",
			1 => "PRESENTES",
		);
		$flag = array(
			0 => "SI",
			1 => "NO",
		);
		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'ENCUESTA / PREGUNTAS / ALTERNATIVAS',
			'data' => [
				['encuesta' => null
				,'tipoPregunta' => null
				,'tipoAuditoria' => null
				,'tipoPresencia' => null
				,'flagDetalle'=> null
				,'pregunta' => null
				,'alternativa'=>null
				,'cuenta' => 'P&G' 
				,'proyecto' => 'TRADE' 
	
				]
			],
			'headers' => [
				  'TÍTULO ENCUESTA(*)'
				, 'TIPO PREGUNTA(*)'
				, 'TIPO AUDITORIA'
				, 'TIPO PRESENCIA'
				, 'VER DETALLE'
				, 'PREGUNTA(*)'
				, 'ALTERNATIVA'
			],
			'columns' => [
				['data' => 'encuesta', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'Encuesta', 'width' => 200,'source'=>$encuestas],
				['data' => 'tipoPregunta', 'type' => 'myDropdown', 'placeholder' => 'Tipo Pregunta', 'width' => 200,'source'=>$tiposPregunta],
				['data' => 'tipoAuditoria', 'type' => 'myDropdown', 'placeholder' => 'Tipo Auditoria Externa', 'width' => 200,'source'=>$tiposAuditoria],
				['data' => 'tipoPresencia', 'type' => 'myDropdown', 'placeholder' => 'Tipo Presencia', 'width' => 200,'source'=>$flagPresencia],
				['data' => 'flagDetalle', 'type' => 'myDropdown', 'placeholder' => 'Flag Detalle', 'width' => 200,'source'=>$flag],
				['data' => 'pregunta', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'Preguntas', 'width' => 200,'source'=>$preguntas],
				['data' => 'alternativa', 'type' => 'text', 'placeholder' => 'Alternativa', 'width' => 200],
	
			],
			'colWidths' => 200,
		];
		
	
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}
	public function guardarCargaMasivaPreguntas(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoListaEvaluacion'];
		
		$array = array(
			'tiposPregunta' => array(),
			'tiposAuditoria' => array(),
			'evaluaciones' => array(),
			'encuestas' => array(),
			'preguntas' => array(),
			'preguntasEncuesta' => array(),
		);

		$tiposPregunta = $this->model->getTiposPregunta()->result_array();
		$tiposAuditoria= $this->model->getTipoAud()->result_array();
		$evaluaciones = $this->model->getEvaluacionesDet()->result_array();


		$dataInsertMasivo = array();

		foreach ($evaluaciones as $key => $row) {
			$array['evaluaciones'][$row['id']] = $row['value'];
		}

		foreach ($tiposPregunta as $key => $row) {
			$array['tiposPregunta'][$row['id']] = $row['value'];
		}
		foreach ($tiposAuditoria as $key => $row) {
			$array['tiposAuditoria'][$row['id']] = $row['value'];
		}	
		array_pop($post['HT'][0]);

		$insertEncPregAlt = [];
		foreach ($post['HT'][0] as $key => $value) {
			if(!empty($value['encuesta']) && !empty($value['tipoPregunta']) && $value['pregunta']){

				$encuestas= $this->model->getEncuestas()->result_array();
				$preguntas= $this->model->getPreguntas()->result_array();
				$preguntasEncuesta=$this->model->getPreguntasEncuesta()->result_array();
				
				foreach ($encuestas as $key => $row) {
					$array['encuestas'][$row['id']] = $row['value'];
				}
				foreach ($preguntas as $key => $row) {
					$array['preguntas'][$row['id']] = $row['value'];
				}
				foreach ($preguntasEncuesta as $key => $row) {
					$array['preguntasEncuesta'][$row['idEncuesta']][$row['id']] = $row['value'];
				}

				if(array_search($value['tipoPregunta'],$array['tiposPregunta']) == 2 && empty($value['alternativa'])){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Una pregunta Cerrada necesita Alternativas.<br> Fila: '.($key+1)));
					goto respuesta;
				}
				if(array_search($value['tipoPregunta'],$array['tiposPregunta']) == 3 && empty($value['tipoAuditoria']) && empty($value['alternativa'])){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Una pregunta Múltiple necesita Alternativas o Cargarlas de una Auditoría Externa.<br> Fila: '.($key+1)));
					goto respuesta;
				}
				//BUSCAR O REGISTRAR ENCUESTA
				if(array_search(trim($value['encuesta']),$array['encuestas'])){
					$idEncuesta = array_search($value['encuesta'],$array['encuestas']);
				}else{
					$insert = array(
						'idCuenta'=> 3,
						'idProyecto'=> 4,
						'nombre'=>trim($value['encuesta']),
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);
					$this->model->registrarEncuesta($insert);
					
					$idEncuesta = $this->db->insert_id();
				}
				//BUSCAR O REGISTRAR PREGUNTA
				if(array_search(trim($value['pregunta']),$array['preguntasEncuesta'][$idEncuesta])){
					$idPregunta = array_search($value['pregunta'],$array['preguntasEncuesta'][$idEncuesta]);
				}else{
					$insert = array(
						'idEncuesta'=> $idEncuesta,
						'idTipoPregunta'=>array_search($value['tipoPregunta'],$array['tiposPregunta']),
						'idExtAudTipo'=>!empty($value['tipoAuditoria']) ?array_search($value['tipoAuditoria'],$array['tiposAuditoria']) : NULL,
						'extAudPresencia'=>!empty($value['tipoPresencia']) && $value['tipoPresencia'] == 'PRESENTES'? 1: 0,
						'extAudDetalle'=>!empty($value['flagDetalle']) && $value['flagDetalle'] == 'SI' ? 1 : 0,
						'nombre'=>trim($value['pregunta']),
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);
					$this->model->registrarPreguntaEncuesta($insert);

					$idPregunta = $this->db->insert_id();
				}

				if(array_search($value['tipoPregunta'],$array['tiposPregunta']) == 2) {
					$insertEncPregAlt[] = array(
						'idPregunta'=> $idPregunta,
						'nombre'=> $value['alternativa'],
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);
				}
				else if(array_search($value['tipoPregunta'],$array['tiposPregunta']) == 3 && empty($value['tipoAuditoria'])){
					$insertEncPregAlt[] = array(
						'idPregunta'=> $idPregunta,
						'nombre'=> $value['alternativa'],
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);
				}
				

			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos'));
				goto respuesta;
			}
		}
		if(!empty($insertEncPregAlt)){
			$registro = $this->model->registrarEncPregAlt($insertEncPregAlt);
		}else{
			$registro = true;
		}

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	public function verDetallePreguntas(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);
			$idEncuesta = $input['id'];

			$data = array(
					'encuesta' => '',
					'preguntas' => array(),
					'alternativas' => array()
				);

			$query = $this->model->listEncuestasPregEval(array('idEncuesta' => $idEncuesta));
			foreach($query as $row){
				$data['encuesta'] = $row['encuesta'];
				
				$data['preguntas'][$row['idPregunta']]['nombre'] = $row['pregunta'];
				$data['preguntas'][$row['idPregunta']]['tipo'] = $row['tipo'];
				$data['preguntas'][$row['idPregunta']]['tipoAuditoria'] = $row['tipoAuditoria'];
				$data['preguntas'][$row['idPregunta']]['flag_cliente'] = $row['flag_cliente'];
				$data['preguntas'][$row['idPregunta']]['flag_presencia'] = $row['flag_presencia'];
				
				$data['flag_cliente'] = $row['flag_cliente'];
				if( !empty($row['idAlternativa']) ){
					$data['alternativas'][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];
				}
			}

			$result['data']['view'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/encuesta/ver', $data, true);
		echo json_encode($result);
	}

		// SECCION TIPO EVALUACION
		public function getTablaTipoEvaluacion()
		{
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
	
			$data = $this->model->getTipoEvaluacion($post)->result_array();
	
			$result['result'] = 1;
			if (count($data) < 1) {
				$result['data']['html'] = getMensajeGestion('noResultados');
			} else {
				$dataParaVista['data'] = $data;
				$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaTipoEvaluacion', $dataParaVista, true);
			}
	
			echo json_encode($result);
		}
	
		public function getFormNewTipoEvaluacion()
		{
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
			
			$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
			$dataParaVista = array();
			$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
	
			$result['result'] = 1;
			$result['data']['width'] = '45%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewTipoEvaluacion', $dataParaVista, true);
	
			echo json_encode($result);
		}
		public function registrarTipoEvaluacion()
		{
			$this->db->trans_start();
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

			$elementosAValidar = [
				'nombre' => ['requerido'],
			];
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

			if ($this->model->checkNombreElementoRepetido($post,'tipoEvaluacion')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

			$result['data']['validaciones'] = $validaciones;

			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}

			$registro = $this->model->regitrarTipoEvaluacion($post);
			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('registroExitoso');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		
		public function getFormUpdateTipoEvaluacion()
		{
			$result = $this->result;
			
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
	
			$dataParaVista['data'] = $this->model->getTipoEvaluacion($post)->row_array();
			$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
			
			$result['result'] = 1;
			$result['data']['width'] = '45%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateTipoEvaluacion', $dataParaVista, true);
	
			echo json_encode($result);
		}
		public function actualizarTipoEvaluacion()
		{
			$this->db->trans_start();
			$result = $this->result;
			
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
	
			$elementosAValidar = [
				'nombre' => ['requerido'],
			];
			
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
	
			if ($this->model->checkNombreElementoRepetido($post,'tipoEvaluacion')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
	
			$result['data']['validaciones'] = $validaciones;
	
			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}
	
			$actualizo = $this->model->actualizarTipoEvaluacion($post);
	
			if (!$actualizo) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		public function getFormCargaMasivaTipoEvaluacion(){
			$result = $this->result;
		
			$result['msg']['title'] = $this->titulo['masivoTipoEvaluacion'];
	
			$cuentas = $this->model->getCuentas()->result_array();
		  
	
			//REFACTORIZANDO DATA
			
			$cuentasRefactorizado = [];
			foreach ($cuentas as $row) {
				if (!in_array($row['value'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['value'];
			}
			$cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
			
	
			//ARMANDO HANDSONTABLE
			$HT[0] = [
				'nombre' => 'Tipo Evaluación',
				'data' => [
					['nombre' => null
					, 'cuenta' => 'P&G' 
					, 'proyecto' => 'TRADE' 
		
					]
				],
				'headers' => [
					  'NOMBRE TIPO EVALUACIÓN'

				],
				'columns' => [
					['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],
		
				],
				'colWidths' => 200,
			];
			
		
			//MOSTRANDO VISTA
			$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
			$result['result'] = 1;
			$result['data']['width'] = '70%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
			$result['data']['ht'] = $HT;
	
			echo json_encode($result);
		}
		public function guardarCargaMasivaTipoEvaluacion(){
			$this->db->trans_start();
			$result = $this->result;
	
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['masivoTipoEvaluacion'];
	
			$dataInsertMasivo = array();
	
			array_pop($post['HT'][0]);

			if(empty($post['HT'][0])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
				goto respuesta;
			}
			foreach ($post['HT'][0] as $key => $value) {

				if(!empty($value['nombre'])){

					if ($this->model->checkNombreElementoRepetido($value,'tipoEvaluacion')){
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. <br> Fila:'.($key+1)));
						goto respuesta;
					}

					$dataInsertMasivo[] = array(
						'idCuenta' => '3',
						'idProyecto' => '3',
						'nombre' => $value['nombre'],
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);
				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
					goto respuesta;
				}

			}
	
			$registro = $this->model->registroMasivoTipoEvaluacion($dataInsertMasivo);
			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('registroExitoso');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		// SECCION  EVALUACION
		public function getTablaEvaluacion()
		{
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
	
			$data = $this->model->getEvaluacion($post)->result_array();
	
			$result['result'] = 1;
			if (count($data) < 1) {
				$result['data']['html'] = getMensajeGestion('noResultados');
			} else {
				$dataParaVista['data'] = $data;
				$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/tablaEvaluacion', $dataParaVista, true);
			}
	
			echo json_encode($result);
		}
	
		public function getFormNewEvaluacion()
		{
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
			
			$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
			$dataParaVista = array();
			$dataParaVista['tiposEvaluacion'] = $this->model->getTiposEvaluacion()->result_array();
	
			$result['result'] = 1;
			$result['data']['width'] = '45%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formNewEvaluacion', $dataParaVista, true);
	
			echo json_encode($result);
		}
		public function registrarEvaluacion()
		{
			$this->db->trans_start();
			$result = $this->result;
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

			$elementosAValidar = [
				'nombre' => ['requerido'],
				'tipoEvaluacion' => ['selectRequerido'],
			];
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

			if ($this->model->checkNombreElementoRepetido($post,'evaluacion')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

			$result['data']['validaciones'] = $validaciones;

			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}

			$registro = $this->model->registrarEvaluacion($post);
			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('registroExitoso');
			}

			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		
		public function getFormUpdateEvaluacion()
		{
			$result = $this->result;
			
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
	
			$dataParaVista['data'] = $this->model->getEvaluacion($post)->row_array();
			$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
			$dataParaVista['tiposEvaluacion'] = $this->model->getTiposEvaluacion()->result_array();
			
			$result['result'] = 1;
			$result['data']['width'] = '45%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formUpdateEvaluacion', $dataParaVista, true);
	
			echo json_encode($result);
		}
		public function actualizarEvaluacion()
		{
			$this->db->trans_start();
			$result = $this->result;
			
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
	
			$elementosAValidar = [
				'nombre' => ['requerido'],
			];
			
			$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
	
			if ($this->model->checkNombreElementoRepetido($post,'evaluacion')) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
	
			$result['data']['validaciones'] = $validaciones;
	
			if (!verificarSeCumplenValidaciones($validaciones)) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto respuesta;
			}
	
			$actualizo = $this->model->actualizarEvaluacion($post);
	
			if (!$actualizo) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}
		public function getFormCargaMasivaEvaluacion(){
			$result = $this->result;
		
			$result['msg']['title'] = $this->titulo['masivoEvaluacion'];
	
			$tiposEvaluacion = $this->model->getTiposEvaluacion()->result_array();
		  
	
			//REFACTORIZANDO DATA
			
			$tEvalRefac = [];
			foreach ($tiposEvaluacion as $row) {
				if (!in_array($row['value'], $tEvalRefac)) $tEvalRefac[] = $row['value'];
			}
			$tiposEvaluacion = !empty($tEvalRefac) ? $tEvalRefac : [' '];
			
	
			//ARMANDO HANDSONTABLE
			$HT[0] = [
				'nombre' => 'Evaluación',
				'data' => [
					['nombre' => null
					, 'tipoEvaluacion' => null 
					, 'cuenta' => 'P&G' 
					, 'proyecto' => 'TRADE' 
		
					]
				],
				'headers' => [
					  'NOMBRE EVALUACION(*)'
					, 'TIPO EVALUACION(*)'

				],
				'columns' => [
					['data' => 'nombre', 'type' => 'text', 'placeholder' => 'nombre', 'width' => 200],
					['data' => 'tipoEvaluacion', 'type' => 'myDropdown', 'placeholder' => 'Tipo Evaluación', 'width' => 200,'source'=>$tiposEvaluacion],

		
				],
				'colWidths' => 200,
			];
			
		
			//MOSTRANDO VISTA
			$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
			$result['result'] = 1;
			$result['data']['width'] = '70%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaGeneral',$dataParaVista, true);
			$result['data']['ht'] = $HT;
	
			echo json_encode($result);
		}
		public function guardarCargaMasivaEvaluacion(){
			$this->db->trans_start();
			$result = $this->result;
	
			$post = json_decode($this->input->post('data'), true);
			$result['msg']['title'] = $this->titulo['masivoEvaluacion'];
	
			$array = array(
				'tiposEvaluacion' => array(),

			);

			$tiposEvaluacion = $this->model->getTiposEvaluacion()->result_array();
	
			foreach ($tiposEvaluacion as $key => $row) {
				$array['tiposEvaluacion'][$row['id']] = $row['value'];
			}

			$dataInsertMasivo = array();
			array_pop($post['HT'][0]);
			foreach ($post['HT'][0] as $key => $value) {

				if(!empty($value['nombre']) && !empty($value['tipoEvaluacion'])){
					if ($this->model->checkNombreElementoRepetido($value,'evaluacion')){
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Existe un registro igual activo. </br>'.($key+1)));
						goto respuesta;
					}

					$dataInsertMasivo[] = array(
						'idCuenta' => '3',
						'idProyecto' => '3',
						'nombre' => $value['nombre'],
						'idEvaluacion'=> array_search($value['tipoEvaluacion'],$array['tiposEvaluacion']),
						'idUsuarioReg'=> $this->session->userdata('idUsuario'),
					);
				}else{
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos. </br>'.($key+1)));
					goto respuesta;
				}
			}

			$registro = $this->model->registroMasivoEvaluacion($dataInsertMasivo);
			if (!$registro) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('registroExitoso');
			}
	
			$this->db->trans_complete();

			respuesta:
			echo json_encode($result);
		}

		public function getFormCargaMasivaClienteAudDet(){
			$result = $this->result;
		
			$result['msg']['title'] = 'Carga Masiva Detalle Auditoría';
			$post = json_decode($this->input->post('data'), true);
			$dataParaVista = [];

			$confClienteAud = $this->model->getConfClientesAud(['idClienteAud'=>$post['id']])->row_array();
			$confClienteAudDet = $this->model->getConfClientesAudDet(['id'=>$post['id']])->result_array();
			//REFACTORIZANDO DATA
			$dataParaVista['data'] = $confClienteAud;
			$tEvalRefac = [];
			$materiales = $this->model->getMatExtByTipoAud($confClienteAud['idExtAudTipo'])->result_array();
			foreach ($materiales as $row) {
				if (!in_array($row['value'], $tEvalRefac)) $tEvalRefac[] = $row['value'];
			}
			$arr_materiales = !empty($tEvalRefac) ? $tEvalRefac : [' '];
			$flag = [
				0 => 'NO',
				1 => 'SI'
			];
			
			//ARMANDO HANDSONTABLE
			if(empty($confClienteAudDet)){
				$confClienteAudDet[] = [
					'material' => null,
					'flag_presencia' => null,
				];
			};

			$HT[0] = [
				'nombre' => 'Detalle Auditoría',
				'data' => $confClienteAudDet
				,
				'headers' => [
					  'MATERIALES(*)'
					, 'PRESENCIA(*)'

				],
				'columns' => [
					['data' => 'material', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'Materiales', 'width' => 400,'source'=>$arr_materiales],
					['data' => 'flag_presencia', 'type' => 'myDropdown', 'placeholder' => 'Presencia', 'width' => 200,'source'=>$flag],
		
				],
				'colWidths' => 200,
			];
			
		
			//MOSTRANDO VISTA
			$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
			$result['result'] = 1;
			$result['data']['width'] = '70%';
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/livestorecheckconf/formCargaMasivaConfAudCliente',$dataParaVista, true);
			$result['data']['ht'] = $HT;
	
			echo json_encode($result);
		}

	public function guardarCargaMasivaAudDet(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['masivoEvaluacion'];

		$array = array(
			'materiales' => array(),
		);
		$confClienteAud = $this->model->getConfClientesAud(['idClienteAud'=>$post['idConfClienteAud']])->row_array();


		$materiales = $this->model->getMatExtByTipoAud($confClienteAud['idExtAudTipo'])->result_array();
		foreach ($materiales as $key => $row) {
			$array['materiales'][$row['value']] = $row['id'];
		}

		$dataInsertMasivo = array();
		array_pop($post['HT'][0]);
		foreach ($post['HT'][0] as $key => $value) {

			if( !empty($value['material'])){

				if(!empty($array['materiales'][$value['material']])){
					$idExtAudMat = $array['materiales'][$value['material']];
				}else{
					$insert = [
						'idExtAudTipo' => $confClienteAud['idExtAudTipo'],
						'nombre' => $value['material'],
						'estado' => 1,
					];
					$this->model->registrarExtauditoriaMaterial($insert);
					$idExtAudMat = $this->db->insert_id();
					$array['materiales'][$value['material']] = $idExtAudMat;
				}
			

				$dataInsertMasivo[] = array(
					'idConfClienteAud' => $confClienteAud['idConfClienteAud'],
					'idExtAudMat' => $idExtAudMat,
					'presencia' => (!empty($value['flag_presencia']) && $value['flag_presencia'] == "SI") ? 1 : 0 ,
					'idUsuarioReg'=> $this->session->userdata('idUsuario'),
				);
			}else{
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos. </br>'.($key+1)));
				goto respuesta;
			}
		}

		$registro = $this->model->registrarMasivoConfClienteAudDet($dataInsertMasivo,$confClienteAud);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function buscar_material	($idExtAudTipo ,$buscar = ""){
		$result = [ 'items' => [] ];
			$result['incomplete_results'] = false;
			$query = $this->model->getMatExtByTipoAud($idExtAudTipo, $buscar)->result_array();
			foreach($query as $k => $row){
				$result['items'][] = [
						'id' => $row['id'],
						'title' => $row['value'],
						'name' => $row['value'],
					];
			}
			$result['total_count'] = count($query);	
		echo json_encode($result);
	}
}
