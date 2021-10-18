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
			'assets/libs/datatables/dataTables.bootstrap4.min',
			'assets/libs/datatables/buttons.bootstrap4.min',
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/iniciativaTrad'
		];

		$config['nav']['menu_active'] = '95';
		$config['data']['icon'] = 'far fa-chart-pie';
		$config['data']['title'] = 'Iniciativas';
		$config['data']['message'] = 'Iniciativa Tradicional';
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
			'nombre' => ['requerido']
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
		$dataParaVista['data'] = $this->model->getElementosIniciativa($post)->row_array();
		
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
			'nombre' => ['requerido']
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

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista = array();
		$dataParaVista['elementos'] = $this->model->getElementosIniciativa($params)->result_array();
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

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);
		
		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		$result['data']['validaciones'] = $validaciones;
		
		if ( !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['cuenta']=$this->session->userdata('idCuenta');
		$actualizo = $this->model->registrarElemento($post);
		$idIniciativa = $this->db->insert_id();


		//leer elementos nuevos
		$array_elementos=array();
		foreach($post as $name => $row){
			if( strpos($name,'iniciativa_elemento-')!==false){
				$index=explode("-",$name)[1];
				$array_elementos[$index]['elemento']=$row;
			}
		}

		//leer motivos de elementos nuevos
		foreach($post as $name => $row){
			if( strpos($name,'iniciativa_elemento_motivo-')!==false){
				$index=explode("-",$name)[1];
				$row_d=json_decode($row, true);
				if(isset($array_elementos[$index])){
					$array_elementos[$index]['motivos']=$row_d;
				}
			}
		}


		foreach($array_elementos as $row){

			$params=array();
			$params['idIniciativa']=$idIniciativa;
			$params['idElementoVis']=$row['elemento'];
			
			$rs = $this->model->guardarIniciativaElemento($params);
			
			if ( !$rs || $rs === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto responder;
			}else{

				if( isset($row['motivos'])){
					foreach($row['motivos'] as $row_det){
						if( $row_det!=null){
							$params_det=array();
							$params_det['idIniciativa']=$idIniciativa;
							$params_det['idElementoVis']=$row['elemento'];
							$params_det['idEstadoIniciativa']=$row_det;
							$rs_det = $this->model->guardarMotivoIniciativaElemento($params_det);
							if ( !$rs || $rs === 'repetido') {
								$result['result'] = 0;
								$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
								goto responder;
							}
						}
					}
				}
			}
		}


		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
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
		
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['elementos'] = $this->model->getElementosIniciativa($params)->result_array();
		$dataParaVista['elementos_iniciativa'] = $this->model->getListaElementosIniciativa($post)->result_array();
		$dataParaVista['motivos'] = $this->model->getMotivos()->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateIniciativaMotivo()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = "Seleccionar motivos";
		$dataParaVista=array();

		$params=array();
		$params['id']=$post['idElementoVis'];
		$dataParaVista['elemento'] = $this->model->getElementosIniciativa($params)->row_array();

		$params=array();
		$params['id']=$post['idIniciativa'];
		$dataParaVista['iniciativa'] = $this->model->getElementos($params)->row_array();

		
		$dataParaVista['elementos_motivos'] = $this->model->getMotivosElementosIniciativa($post)->result_array();
		$dataParaVista['motivos'] = $this->model->getMotivos()->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->carpetaHtml.'formSelectIniciativaElementoMotivo', $dataParaVista, true);
		
		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewIniciativaMotivo()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = "Seleccionar motivos";
		$dataParaVista=array();

		$params=array();
		$dataParaVista['motivos'] = $this->model->getMotivos()->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->carpetaHtml.'formSelectIniciativaElementoMotivo', $dataParaVista, true);
		
		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function updateIniciativaElementoMotivo()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$dataParaVista=array();

		$params=array();
		$idElementoVis=$post['idElementoVis'];
		$idIniciativa=$post['idIniciativa'];

		$result['result'] = 1;

		$result['msg']['title'] = $this->titulo['actualizarMotivo'];
		$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		

		if( !empty($post['motivo_seleccion'])){
			foreach($post['motivo_seleccion'] as $row_det){
				if( !empty($row_det)){
					$params_det=array();
					$params_det['idIniciativa']=$idIniciativa;
					$params_det['idElementoVis']=$idElementoVis;
					$params_det['idEstadoIniciativa']=$row_det;
					$rs_det = $this->model->guardarMotivoIniciativaElemento($params_det);
				}
			}
		}

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];

			$params=array();
			$params['elementosEliminados']=$post['elementosEliminados'];
			$params['idIniciativa']=$idIniciativa;
			$params['idElementoVis']=$idElementoVis;
			$delete = $this->model->deleteMasivoIniciativaElementoMotivo($params);
		}

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

		
		$elementosAValidarSimple = [
			'nombre' => ['requerido'],
            'fechaInicio' => ['requerido'],
        ];

		//leer elementos nuevos
		$array_elementos=array();
		foreach($post as $name => $row){
			if( strpos($name,'iniciativa_elemento-')!==false){
				$index=explode("-",$name)[1];
				$array_elementos[$index]['elemento']=$row;
			}
		}

		//leer motivos de elementos nuevos
		foreach($post as $name => $row){
			if( strpos($name,'iniciativa_elemento_motivo-')!==false){
				$index=explode("-",$name)[1];
				$row_d=json_decode($row, true);
				if(isset($array_elementos[$index])){
					$array_elementos[$index]['motivos']=$row_d;
				}
			}
		}

		foreach($array_elementos as $row){

			$params=array();
			$params['idIniciativa']=$idIniciativa;
			$params['idElementoVis']=$row['elemento'];
			
			$rs = $this->model->guardarIniciativaElemento($params);
			
			if ( !$rs || $rs === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
				goto responder;
			}else{

				if( isset($row['motivos'])){
					foreach($row['motivos'] as $row_det){
						if( $row_det!=null){
							$params_det=array();
							$params_det['idIniciativa']=$idIniciativa;
							$params_det['idElementoVis']=$row['elemento'];
							$params_det['idEstadoIniciativa']=$row_det;
							$rs_det = $this->model->guardarMotivoIniciativaElemento($params_det);
							if ( !$rs || $rs === 'repetido') {
								$result['result'] = 0;
								$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
								goto responder;
							}
						}
					}
				}
			}
		}


		//print_r($this->input->post('data'));
		
		

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);
		
		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		
		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}



		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];

			$params=array();
			$params['elementosEliminados']=$post['elementosEliminados'];
			$params['idIniciativa']=$idIniciativa;
			
			$delete = $this->model->deleteMasivoIniciativaElementos($params);
			$delete = $this->model->deleteMasivoIniciativaElementoMotivoPorElementos($params);

		}

		$actualizo = $this->model->actualizarElemento($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
		}


		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getTablaLista()
	{
		ini_set('memory_limit', '1024M');
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$fechas = explode('-', $post['txt-fechas']);

		$params = [
			'fecIni' => $fechas[0]
			, 'fecFin' => $fechas[1]
		];

		$params['cuenta'] = $this->sessIdCuenta;
		$params['proyecto'] = $this->sessIdProyecto;

		$params['grupoCanal'] = $post['grupoCanal'];
		$params['canal']  = $post['canal'];

		$params['distribuidora'] = empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'];
		$params['zona'] = empty($post['zona_filtro']) ? '' : $post['zona_filtro'];
		$params['plaza'] = empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'];
		$params['cadena'] = empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'];
		$params['banner'] = empty($post['banner_filtro']) ? '' : $post['banner_filtro'];

		$distribuidoraSucursal="";
		if( !empty($post['distribuidoraSucursal_filtro'])){
			if( is_array($post['distribuidoraSucursal_filtro'])){
				$distribuidoraSucursal = implode(",",$post['distribuidoraSucursal_filtro']);
			}else{
				$distribuidoraSucursal = $post['distribuidoraSucursal_filtro'];
			}
		}
		$params['distribuidoraSucursal'] = $distribuidoraSucursal;

		$data = $this->model->getListas($params)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $post['grupoCanal']]);
			$dataParaVista['segmentacion'] = $segmentacion;
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
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

		$dataParaVista['elementos'] = $this->model->getListaElementosIniciativa()->result_array();
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

		$dataParaVista['elementos'] = $this->model->getListaElementosIniciativa()->result_array();
		$dataParaVista['iniciativas'] = $this->model->getIniciativas()->result_array();
		$dataParaVista['data'] = $this->model->getListasSinFiltros($post)->row_array();
		if(!empty($dataParaVista['data']['idCanal'])) $dataParaVista['clientes'] = $this->model->getSegCliente($dataParaVista['data'])->result_array();
		
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post='';
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
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

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
        $elementos = $this->model->getElementos($params)->result_array();

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
			if (!in_array($row['nombre'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['nombre'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

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
				['data' => 'grupoCanal', 'type' => 'myDropdown_grupoCanal', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown_canal', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'idCliente', 'type' => 'myDropdown', 'placeholder' => 'ID Cliente', 'source' => $clientes, 'strict'=> false],
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
				['data' => 'iniciativa_lista', 'type' => 'myDropdown_iniciativa', 'placeholder' => 'Iniciativa', 'source' => $elementos],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementosIniciativa, 'strict'=> false],
                
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
		$elementosParmas['grupos'][0] = ['columnas' => ['iniciativa_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elemento']['tabla'], 'idTabla' => $this->model->tablas['elemento']['id']];
		$elementosParmas['grupos'][1] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elementoIniciativa']['tabla'], 'idTabla' => $this->model->tablas['elementoIniciativa']['id']];
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
                        'iniciativa_lista' => $row[$this->model->tablas['elemento']['id']],
						'elemento_lista' =>  $row[$this->model->tablas['elementoIniciativa']['id']],
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
		
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
        $elementos = $this->model->getElementosIniciativa($params)->result_array();

		$params=array();
        $motivos = $this->model->getMotivos($params)->result_array();

		$elementosRefactorizado = [];
		foreach ($elementos as $row) {
			if (!in_array($row['nombre'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['nombre'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		$motivosRefactorizado = [];
		foreach ($motivos as $row) {
			if (!in_array($row['nombre'], $motivosRefactorizado)) $motivosRefactorizado[] = $row['nombre'];
		}
		$motivos = !empty($motivosRefactorizado) ? $motivosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Iniciativas',
			'data' => [
				['idLista' => 1
                ,'iniciativa' => null
                ,'descripcion' => null
                ,'fechaInicio' => null
                ,'fechaFin' => null
                ]
			],
            'headers' => ['Id Lista','Iniciativas','Descripción','Fecha Inicio','Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'iniciativa', 'type' => 'text', 'placeholder' => 'Iniciativa', 'width' => 300],
				['data' => 'descripcion', 'type' => 'text', 'placeholder' => 'Descripción', 'width' => 300],
				['data' => 'fechaInicio', 'type' => 'myDate', 'placeholder' => 'Fecha Inicio'],
				['data' => 'fechaFin', 'type' => 'myDate', 'placeholder' => 'Fecha Fin' ],
			],
			'colWidths' => 200,
        ];

		$HT[1] = [
			'nombre' => 'Elementos',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
				, 'motivo_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Elemento'
				, 'Motivo'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementos],
				['data' => 'motivo_lista', 'type' => 'myDropdown', 'placeholder' => 'Motivo', 'source' => $motivos],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
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
        


		$elementos_motivo = $post['HT']['1'];
		$elementos_motivoParmas['tablaHT'] = $elementos_motivo;
		$elementos_motivoParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elementoIniciativa']['tabla'], 'idTabla' => $this->model->tablas['elementoIniciativa']['id']];
		$elementos_motivoParmas['grupos'][1] = ['columnas' => ['motivo_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['motivoIniciativa']['tabla'], 'idTabla' => $this->model->tablas['motivoIniciativa']['id']];
        $elementos_motivo = $this->getIdsCorrespondientes($elementos_motivoParmas);
		array_pop($elementos_motivo);

		
       
        

		$elementos_unicos = $this->model->validar_elementos_unicos_HT($elementos);

		if(!$elementos_unicos){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que los elementos no se repiten'));
			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
        foreach($elementos as $index => $value){
			$multiDataRefactorizada = [] ;

			
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

			$value['idCuenta']=$this->session->userdata('idCuenta');
			$rs = $this->model->registrarIniciativa_HT($value);
            $idLista = $this->model->insertId;

			foreach($elementos_motivo as $row){

                if($row['idLista'] == $value['idLista']){
                    $multiDataRefactorizada[] = [
						'elemento_lista' => $row[$this->model->tablas['elementoIniciativa']['id']],
                        'motivo_lista' => $row[$this->model->tablas['motivoIniciativa']['id']]
                    ];

                }
            }
            $insert = $this->model->guardarMasivoIniciativaElementoMotivos($multiDataRefactorizada, $idLista);

			$fila++;
		}

		if(!$insertMasivo){
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
		//REFACTORIZANDO DATA

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Elementos',
			'data' => [
                [  
                'elemento' => null 
                ]
			],
            'headers' => [ 
                'Elemento' 
            ],
			'columns' => [
				['data' => 'elemento', 'type' => 'text', 'placeholder' => 'Elemento'] 
			],
			'colWidths' => 300,
        ];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
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
		
        $listas = $post['HT']['0'];
        
		array_pop($listas);

		$insertMasivo  = true;
		$rsinsertMasivo="";
		$fila = 1;
		$idCuenta=$this->session->userdata('idCuenta');
		$idProyecto=$this->session->userdata('idProyecto');
        foreach($listas as $index => $value){
			if($value['elemento']!=null){

				$listasInsertadas = [];
				$multiDataRefactorizada = [] ;

				
				$params=$value;
				
				$params['idCuenta']=$idCuenta;
				$params['idProyecto']=$idProyecto;
				$rs = $this->model->registrarElemento_HT($params);
				$idLista = $this->db->insert_id();
				
				if(!$rs || (strcmp($rs, 'repetido')==1) ){
					$insertMasivo = $rs;
					break;
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




	//


	public function iniciativaCargaMasivaAlternativa(){
		
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);

		$html='';
		$htmlWidth='90%';
		$array=array();

		$data_carga = array();
		$i=0;
		$resultados=$this->model->obtener_estado_carga();
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['fecRegistro']=$row['fecRegistro'];
			$data_carga[$i]['horaRegistro']=$row['horaRegistro'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$data_carga[$i]['noProcesados']=$row['noProcesados'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['estado']=$row['estado'];
			$data_carga[$i]['fecI']=$row['fecI'];
			$data_carga[$i]['fecF']=$row['fecF'];
			$i++;
		}
		$array['data_carga']= $data_carga;

		$html.= $this->load->view("modulos/configuraciones/gestion/iniciativaTrad/registrar_masivo_alternativa", $array, true);

		$result['msg']['title'] = 'GENERAR INICIATIVAS';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}


	public function generar_formato_carga_masiva_alternativa(){
		////
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		/**ESTILOS**/
		$estilo_cabecera_visita =  
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '920000')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_disponibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '558636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_visibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '001636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		$estilo_cabecera_accesibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '00ced1')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$style_gris =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'd4d0cd')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		$style_disponibles =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		/**FIN ESTILOS**/
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'ID CLIENTE')
					->setCellValue('B1', 'ID INICIATIVA')
					->setCellValue('C1', 'ID ELEMENTO');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="iniciativas_formato.xlsx"');
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');	
		////
	}


	public function estado_carga(){
		$resultados=$this->model->obtener_estado_carga();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['noProcesados']=$row['noProcesados'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
		
	}


	public function carga_masiva_alternativa(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		//
		$archivo = $_FILES['file']['name'];

		
		$fecIni = $_POST['fecIni'];
		$fecFin = $_POST['fecFin'];


		$datetime = date('dmYHis');
		$nombre_carpeta = 'iniciativas_'.$datetime;
		//
		$ruta = 'public/csv/iniciativas/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/iniciativas/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/iniciativas_'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/iniciativas_'.$datetime.'.csv';
		$to_read_files = $rutaFiles.'/';
		//
		$done = false;
		$part = 0;
		
		
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);
			
			/* while (($registro = fgetcsv ($handle))!== false) {
				$sum++;
			} */

			while ($done == false) {
				$locA = ftell($handle);
				fseek($handle, $size, SEEK_CUR);
				$tmp = fgets($handle);
				$locB = ftell($handle);
				$span = ($locB - $locA);
				fseek($handle, $locA, SEEK_SET);
				$chunk = fread($handle,$span);
				file_put_contents($to_read_files.'iniciativas_'.$part.'.csv',$header.$chunk);
				$part++;
				if (strlen($chunk) < $size) $done = true;
			}
			fclose($handle);
		}
		$sum = 0;
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);
			while (($registro = fgetcsv ($handle))!== false) {
				$sum++;
			}
		
		}
		$total = $sum;

		$idProyecto=($this->session->userdata('idProyecto')=='13')? '3': $this->session->userdata('idProyecto') ;
		$idCuenta=$this->session->userdata('idCuenta');
		$carga = array();
		$carga = array(
			'fecIni' => $fecIni,
			
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
			'idCuenta' => $idCuenta,
			'idProyecto' => $idProyecto,
		);
		if( !empty($fecFin)){
			$carga['fecFin']=$fecFin;
		}

		$this->db->insert('impactTrade_bd.trade.cargaIniciativa',$carga);

		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA INICIO</th>';
						$html.='<th>FECHA FIN</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>HORA FIN CARGA</th>';
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL FILAS EXCEL CARGADAS</th>';
						$html.='<th>TOTAL FILAS PROCESADAS</th>';
						$html.='<th>TOTAL FILAS NO PROCESADAS</th>';
						$html.='<th>ERRORES</th>';
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
					
						$html.='<tr>';
							$html.='<td>'.$row['idCarga'].'</td>';
							$html.='<td>'.$row['fecI'].'</td>';
							$html.='<td>'.$row['fecF'].'</td>';
							$html.='<td>'.$row['fecRegistro'].'</td>';
							$html.='<td>'.$row['horaRegistro'].'</td>';
							$html.='<td id="horaFin_'.$row['idCarga'].'">'.$row['horaFin'].'</td>';
							$html.='<td>'.$row['totalRegistros'].'</td>';
							$html.='<td id="clientes_'.$row['idCarga'].'">'.$row['totalClientes'].'</td>';
							$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
							$html.='<td id="noprocesados_'.$row['idCarga'].'">'.$row['noProcesados'].'</td>';
							$html.='<td id="errores_'.$row['idCarga'].'">-</td>';
							$html.='<td class="text-center">';
								$porcentaje = 0;
								if( !empty($row['totalClientes']) )
								$porcentaje = round(($row['total_procesados'])/$row['totalClientes']*100,0);
								$mensaje=($row['estado']==1)?' Preparando .':' Completado ';
								$html.='<label id="estado_'.$row['idCarga'].'">'.$mensaje.'</label><br>';
								$html.='<meter id="barraprogreso_'.$row['idCarga'].'" min="0" max="100" low="0" high="0" optimum="100" value="'.$porcentaje.'" style="font-size:20px;">';
							$html.='</td>';
						$html.='</tr>';
					}
				$html.='</tbody>';
			$html.='</table>';
		}else{
			$html.='<div>
					<h4 style="border: 1px solid;
						background: #f2f2f2;
						padding: 20px;
						width: 50%;
						margin: auto;
						text-transform: uppercase;
					}">Aun no ha realizado ninguna carga. </h4>
					</div>';	
		}
		$result['data']=$html;
		echo json_encode($result);

	}


	public function generar_formato_errores($id){
		////
		$rs_rutas = $this->model->obtener_iniciativas_no_procesado($id);
		
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		$sheet = $objPHPExcel->getActiveSheet();

			//Start adding next sheets
		$i=0;
		
		if(count($rs_rutas)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'ID CLIENTE');
			 $objWorkSheet->setCellValue('B1', 'ID INICIATIVA');
			 $objWorkSheet->setCellValue('C1', 'DATO INGRESADO');
			 $objWorkSheet->setCellValue('D1', 'ERROR');
			 $m=2;
			 foreach($rs_rutas as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['idCliente']);
				  $objWorkSheet->setCellValue('B'.$m, $row['idIniciativa']);
				  $objWorkSheet->setCellValue('C'.$m, $row['datoIngresado']);
				  $objWorkSheet->setCellValue('D'.$m, $row['tipoError']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("INICIATIVAS NO PROCESADOS");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="rutas_errores_carga.xlsx"');
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');	
		////
	}

	public function actualizarListasVigentes()
	{
		$post = json_decode($this->input->post('data'), true);
		$result = $this->result;

		$fechas = explode('-', $post['txt-fechas']);

		$post = [
			'fecIni' => $fechas[0],
			'fecFin' => $fechas[1]
		];

		$post['cuenta'] = $this->sessIdCuenta;
		$post['proyecto'] = $this->sessIdProyecto;

		$result['result'] = $this->model->actualizarListasVigentes($post)['status'];

		$result['msg']['title'] = 'Alerta!';
		$result['msg']['content'] = getMensajeGestion('actualizacionErronea');

		if ($result['result'] == true) {
			$result['msg']['title'] = 'Hecho!';
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		echo json_encode($result);
	}

}
