<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reprogramacion extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/administracion/M_Reprogramacion', 'm_reprogramacion');

		$this->titulo = [
			'reprogramacion' => ['reprogramar' => 'Reprogramar Visita'],
		];
		$this->carpetaHtml = 'modulos/Configuraciones/Administracion/Reprogramacion/';

		$this->html = [
			'reprogramacion' => [
				'tabla' => $this->carpetaHtml .  'reprogramacionTabla',
				'reprogramar' => $this->carpetaHtml .  'reprogramacionForm',
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
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/administracion/reprogramacion',
		];

		$config['nav']['menu_active'] = '79';
		$config['data']['icon'] = 'far fa-calendar-edit';
		$config['data']['title'] = 'Reprogramación';
		$config['data']['message'] = 'Módulo para reprogramar visitas.';
		$config['data']['estadosReprogramacion'] = $this->m_reprogramacion->getEstadosReprogramacion()->result_array();
		$config['view'] = $this->carpetaHtml . 'index';

		$this->view($config);
	}

	public function getTablaReprogramacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'idCuentaFiltro' => ['selectRequerido'],
			'idProyectoFiltro' => ['selectRequerido'],
			'txt-fechas' => ['requerido'],
		];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;
		$result['data']['form'] = 'seccionReprogramacion';
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$visitasReprogramacion = $this->m_reprogramacion->getVisitasReprogramacion($post)->result_array();

		$resultados = $visitasReprogramacion;
		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['reprogramacion']['tabla'], $dataParaVista, true);
			$result['data']['configTable'] =  [
				'columnDefs' =>
				[
					0 =>
					[
						"visible" => false,
						"targets" => [3,5,6,7,10,11]
					]
				],
				// 'dom' => '<"ui icon input"f>tip',
			];
		}

		responder:
		$this->aSessTrack[] = $this->m_reprogramacion->aSessTrack;
		echo json_encode($result);
	}

	public function getFormReprogramacion()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['reprogramacion']['reprogramar'];
		$post = json_decode($this->input->post('data'), true);
		$class = "formReprogramacion";

		$dataParaVista = [];
		$dataParaVista["class"] = $class;
		$dataParaVista['reprogramacion'] = $this->m_reprogramacion->getVisitasReprogramacion($post)->row_array();

		$visitas = $this->m_reprogramacion->getVisitasDeCliente($post)->result_array();
		$rutas = $this->m_reprogramacion->getRutasDeUsuario($post)->result_array();

		$visitasRefactorizado = [];
		foreach ($visitas as $value) {
			$visitasRefactorizado[strtotime($value['fecha'])]['fecha'] = $value['fecha'];
		}
		$visitas = $visitasRefactorizado;
		$rutasRefactorizado = [];
		foreach ($rutas as $value) {
			$idRuta = !empty($value['idRuta']) ? $value['idRuta'] : 0;
			$rutasRefactorizado[strtotime($value['fecha'])]['fecha'] = $value['fecha'];
			$rutasRefactorizado[strtotime($value['fecha'])]['idRuta'] = $idRuta;
		}
		$rutas = $rutasRefactorizado;

		$eventos = [];
		foreach ($rutasRefactorizado as $fechaUnix => $ruta) {
			$eventos[$fechaUnix]['start'] = $ruta['fecha'];
			$eventos[$fechaUnix]['epIdRuta'] = $ruta['idRuta'];
			$eventos[$fechaUnix]['epFecha'] = $ruta['fecha'];

			if (!empty($visitas[$fechaUnix])) {
				$eventos[$fechaUnix]['title'] = 'Ruta Ocupada';
				$eventos[$fechaUnix]['color'] = 'red';
				continue;
			}

			if (!empty($ruta['idRuta'])) {
				$eventos[$fechaUnix]['title'] = 'Ruta Disponible';
				$eventos[$fechaUnix]['color'] = 'green';
			} else {
				$eventos[$fechaUnix]['title'] = 'Ruta Nueva';
				$eventos[$fechaUnix]['color'] = 'blue';
			}
		}

		$calendarEvents = array_values($eventos);

		$result['result'] = 1;
		$result['data']['width'] = '60%';
		$result['data']['fullCalendar'] = [];
		$result['data']['fullCalendar']['events'] = $calendarEvents;
		$result['data']['fullCalendar']['startDate'] = $this->m_reprogramacion->getFechaActual()->row_array()["fechaActual"];
		$result['data']['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['reprogramacion']['reprogramar'], $dataParaVista, true);

		$this->aSessTrack[] = $this->m_reprogramacion->aSessTrack;	
		echo json_encode($result);
	}

	public function reprogramar()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] =  $this->titulo['reprogramacion']['reprogramar'];
		$post = json_decode($this->input->post('data'), true);
		$seNecesitaNuevaRuta = (!empty($post['idRutaReprogramacion'])) ? false : true;
		$updateReprogramacion = true;
		$updateVisitaAntigua = true;
		$insertRuta = true;
		$insertVisita = true;
		$aprobarReprogramacion = $post['estadoReprogramacion'] == 1;
		$post['idUsuarioReprogramo'] = $this->idUsuario;

		// VALIDACIONES
		$elementosAValidar = [
			'comentario' => ['requerido'],
			'fechaReprogramacion' => [''],
		];
		if($aprobarReprogramacion) $elementosAValidar['fechaReprogramacion'] = ['requerido'];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_reprogramacion->checkIfVisitaYaFueReprogramada($post)) $validaciones['fechaReprogramacion'][] = "Esta ruta ya fue reprogramada.";
		if ($this->m_reprogramacion->checkRutaExistenteParaFechaUsuario($post)) $validaciones['fechaReprogramacion'][] = "El usuario ya tiene una ruta asignada para esa fecha.";
		if ($this->m_reprogramacion->checkVisitaExistenteParaRutaCliente($post)) $validaciones['fechaReprogramacion'][] = "El cliente ya tiene una visita en la misma ruta.";

		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		// INGRESANDO DATOS
		if(!$aprobarReprogramacion){
			$updateReprogramacion = $this->m_reprogramacion->actualizarReprogramacion($post);
		} else{
			if($seNecesitaNuevaRuta){
				$insertRuta = $this->m_reprogramacion->agregarNuevaRuta($post);
				$idRutaNueva = $this->m_reprogramacion->insertId;
			}
			$post['idRutaReprogramacion'] = (!empty($idRutaNueva)) ? $idRutaNueva : $post['idRutaReprogramacion'];
			$updateVisitaAntigua = $this->m_reprogramacion->actualizarVisitaAntigua($post);
			$insertVisita = $this->m_reprogramacion->insertVisita($post);
			$post['idNuevaVisita'] = $this->m_reprogramacion->insertId;
			$updateReprogramacion = $this->m_reprogramacion->actualizarReprogramacion($post);
		}

		// MENSAJE
		if (!$updateVisitaAntigua || !$updateReprogramacion || !$insertRuta || !$insertVisita) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		$this->aSessTrack[] = $this->m_reprogramacion->aSessTrack;

		respuesta:
		echo json_encode($result);
	}
}
