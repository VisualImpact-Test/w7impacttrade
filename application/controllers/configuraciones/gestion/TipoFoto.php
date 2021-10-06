<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TipoFoto extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_tipoFoto', 'm_tipoFoto');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarTipoFoto' => 'Actualizar Tipo Foto',
			'registrarTipoFoto' => 'Registrar Tipo Foto',
			'masivoTipoFoto' => 'Guardar Tipo Foto',
		];

		$this->carpetaHtml = 'modulos/configuraciones/gestion/tipoFoto/';
        
		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaElemento',
				'new' => $this->carpetaHtml .  'formNewElemento',
				'update' => $this->carpetaHtml .  'formUpdateElemento',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaTipoFoto'
			]
		];
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/tipoFoto'
		];

		$config['nav']['menu_active'] = '125';
		$config['data']['icon'] = 'fa fa-camera';
		$config['data']['title'] = 'Tipo Foto';
		$config['data']['message'] = 'Tipo Fotos';
		$config['view'] = 'modulos/configuraciones/gestion/tipoFoto/index';
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
			case 'TipoFoto':
				$tabla = $this->m_tipoFoto->tablas['tipoFoto']['tabla'];
				$idTabla = $this->m_tipoFoto->tablas['tipoFoto']['id'];
				break;
		}

		$update = [];
		foreach ($ids as $id) {
			$update[] = [
				$idTabla => $id,
				'estado' => $estado
			];
		}

		$cambioEstado = $this->m_tipoFoto->actualizarMasivo($tabla, $update,  $idTabla	);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}


	// SECCION ENCUESTAS
	public function getTablaTipoFoto()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		//cuenta_encuesta

		$params=array();
		if( empty($post['cuenta_tipoFoto']) ) $params['cuenta']=$this->session->userdata('idCuenta');
		if( empty($post['proyecto_tipoFoto']) ) $params['proyecto']=$this->session->userdata('idProyecto');
		
 
		$data = $this->m_tipoFoto->getTipoFotos($params)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistro');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/tipoFoto/tablaTipoFoto", $dataParaVista, true);
		}

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}

	public function getEncuesta(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->m_tipoFoto->getTipoFotos($post)->row_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistro');
		} else {
			$dataParaVista['data'] = $data;
			$html = "";
			$html .= "<tr id='fila_temporal_encuesta'>";
				$html .= "<td ><i class='fas fa-trash' id='eliminar_encuesta'></i></td>";
				$html .= "<td><input  readonly='readonly' style='border:none;' class ='form-control' id='encuesta_".$data['idEncuesta']."' name='encuesta_".$data['idEncuesta']."' value='".$data['nombre']."'></td>";
			$html .= "</tr>";
			$result['data']['html'] = $html;
		}

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewTipoFoto()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarTipoFoto'];

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/tipoFoto/formNewTipoFoto", [], true);

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}


	public function registrarTipoFoto()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarTipoFoto'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		$idProyecto=$this->session->userdata('idProyecto');
		$post['proyecto']=$idProyecto;
		if ($this->m_tipoFoto->checkNombreTipoFotoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$post['proyecto']= $idProyecto;

		$registro = $this->m_tipoFoto->registrarTipoFoto($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateTipoFoto()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarTipoFoto'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['data'] = $this->m_tipoFoto->getTipoFotos($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/tipoFoto/formUpdateTipoFoto", $dataParaVista, true);

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarTipoFoto()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarTipoFoto'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$post['proyecto']=$this->session->userdata('idProyecto');
		if ($this->m_tipoFoto->checkNombreTipoFotoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->m_tipoFoto->actualizarTipoFoto($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
	}

	public function getFormCargaMasivaTipoFoto()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoTipoFoto'];

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		//REFACTORIZANDO DATA

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Tipo Foto',
			'data' => [
                [
				'nombre' => null
                ]
			],
            'headers' => [
				'nombre'
            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'Nombre', 'width' => 400]
			],
			'colWidths' => 400,
        ];
        
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->m_tipoFoto->aSessTrack;
		echo json_encode($result);
    }
    

	public function guardarCargaMasivaTipoFoto(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoTipoFoto'];

        $post = json_decode($this->input->post('data'), true);
        

        $elementos = $post['HT']['0'];
		$elementosParams['tablaHT'] = $elementos;
        
		array_pop($elementos);

		$elementos_unicos = $this->m_tipoFoto->validar_elementos_unicos_HT($elementos);

		if(!$elementos_unicos){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que los elementos no se repiten'));

			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;


		$idProyecto=$this->session->userdata('idProyecto');
        foreach($elementos as $index => $value){
			$multiDataRefactorizada[] = [
				'nombre' => trim($value['nombre']) ,
				'idProyecto' => $idProyecto
			];
			
			$value['proyecto']=$idProyecto;
			if ($this->m_tipoFoto->checkNombreTipoFotoRepetido($value)){
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('registroRepetido');
				goto responder;
			} 
			$fila++;
		}

	

		$masivo = $this->m_tipoFoto->registrar_elementos_HT($multiDataRefactorizada);

		if(!$masivo){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 0,'message'=>'No se pudo Completar la operación'));
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = createMessage(array('type'=> 1,'message'=>'Se completó la operacion Correctamente'));
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}
	
}
