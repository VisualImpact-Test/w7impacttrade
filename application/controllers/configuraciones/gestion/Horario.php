<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Horario extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_horario', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarElemento' => 'Actualizar Horario',
			'registrarElemento' => 'Registrar Horario',
			'masivoElemento' => 'Guardar Masivo Horario',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/horario_hsm/';
        
		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaHorario',
				'new' => $this->carpetaHtml .  'formNewHorario',
				'update' => $this->carpetaHtml .  'formUpdateHorario',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaHorario'
			],
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
			// 'assets/libs/dataTables/datatables',
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/horario'
		];

		$config['nav']['menu_active']='97';
		$config['data']['icon'] = 'fas fa-calendar';
		$config['data']['title'] = 'Gestor Horarios HSM';
		$config['data']['message'] = '';
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
			case 'Elemento':
				$tabla = $this->model->tablas['elemento']['tabla'];
				$idTabla = $this->model->tablas['elemento']['id'];
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

	// SECCION ELEMENTOS
	public function getTablaElemento()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

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

    public function getFormNewElemento()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$dataParaVista = [];
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['new'], $dataParaVista, true);

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
            'horaIni' => ['requerido'],
            'horaFin' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkHorarioRepetido($post)) {
            $validaciones['horaIni'][] = createMessage(['type'=>2,'message'=>'Ya existe un horario igual al que está intentando registrar']);
            $validaciones['horaFin'][] = "";
        }

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$registro = $this->model->registrarElemento($post);
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

		$dataParaVista['data'] = $this->model->getElementos($post)->row_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function actualizarElemento()
	{
		$this->db->trans_start();
		$result = $this->result;
        
        $idCuenta = $this->session->userdata('idCuenta');

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
            'horaIni' => ['requerido'],
            'horaFin' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkHorarioRepetido($post)) {
            $validaciones['horaIni'][] = createMessage(['type'=>2,'message'=>'Ya existe un horario igual al que está intentando registrar']);
            $validaciones['horaFin'][] = "";
        }

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$actualizo = $this->model->actualizarElemento($post);

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

    public function getFormCargaMasivaElemento(){
		$result = $this->result;
		$result['msg']['title'] = "Carga masiva Horarios";

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Horarios',
			'data' => [
                [
                'horaIni' => null,
                'horaFin' => null ,
                ]
			],
            'headers' => [
                  'Hora Ingreso',
                  'Hora Salida'
            ],
			'columns' => [
				['data' => 'horaIni', 'type' => 'text', 'placeholder' => '00:00:00', 'width' => 200],
				['data' => 'horaFin', 'type' => 'text', 'placeholder' => '00:00:00', 'width' => 200],
			],
			'colWidths' => 200,
        ];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view('formCargaMasivaGeneral',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaElemento(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = "Carga masiva Horarios";

		$horarios = $this->model->getElementos([])->result_array();
		$horarios_existentes = [];
		foreach ($horarios as $h) {
			$horarios_existentes[$h['horaIni'].'-'.$h['horaFin']] = 1;
		}

		$dataInsertMasivo = array();

		foreach ($post['HT'][0] as $key => $value) {

			if(empty($value['horaIni']) && empty($value['horaFin'])) continue;

			if((!empty($value['horaIni']) && empty($value['horaFin'])) || (empty($value['horaIni']) && !empty($value['horaFin'])) ){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe completar la Hora de Ingreso y la Hora de Salida. <br> Fila:'.($key+1)));
				goto respuesta;
			}
			
			if (!empty($horarios_existentes[$value['horaIni'].'-'.$value['horaFin']])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Ya existe un horario igual registrado. <br> Fila:'.($key+1)));
				goto respuesta;
			}

			$dataInsertMasivo[] = array(
				'idCuenta' => $this->sessIdCuenta,
				'horaIni' => $value['horaIni'],
				'horaFin' => $value['horaFin'],
			);
		}

		$registro = $this->model->registroMasivoHorarios($dataInsertMasivo);

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
	
}
