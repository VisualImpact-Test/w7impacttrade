<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cobertura extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_cobertura', 'm_cobertura');
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$idMenu = '145';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = [
			'assets/custom/css/asistencia'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/cobertura'
		];
		$config['data']['icon'] = 'fal fa-signal-alt';
		$config['data']['title'] = 'Cobertura';
		$config['data']['message'] = 'Aquí encontrará datos de Cobertura.';

		$tabs = getTabPermisos(['idMenuOpcion' => $idMenu])->result_array();
		if (empty($tabs)) {
			$config['view'] =  'oops';
		} else {
			$config['data']['tabs'] = $tabs;
			$config['view'] = 'modulos/cobertura/index';
		}

		$this->view($config);
	}

	public function detallado()
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);

		$result = $this->result;
		$result['msg']['title'] = 'Cobertura';
		$post = json_decode($this->input->post('data'), true);

		$post['fecIni'] = getFechasDRP($post["txt-fechas"])[0];
		$post['fecFin'] = getFechasDRP($post["txt-fechas"])[1];

		$data = [];

		$data['tiendas'] = $this->m_cobertura->getClientesProgramados($post);

		$data['fechas'] = $this->m_cobertura->getFechas($post);

		$prog = $this->m_cobertura->getHorasProgramadas($post);

		$visitas = $this->m_cobertura->getVisitas($post);

		if (count($data['tiendas']->result()) <= 0) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
			goto responder;
		}
		foreach ($prog->result() as $row) {
			$data['prog'][$row->idCliente]['HP'] = $row->HP;
			$data['prog'][$row->idCliente][$row->idTiempo]['hp_dia'] = $row->hp_dia;
			if ($row->hp_dia > 0) {
				$data['frecuencias'][$row->idCliente][$row->idTiempo]['frecuencia'] = 1;
			}
		}

		foreach ($visitas->result() as $row) {
			$data['visitas'][$row->idCliente][$row->idTiempo]['HT'] = $row->HT;
		}

		foreach ($data['tiendas']->result() as $row) {
			$data['canal'][$row->idCanal]['canal'] = $row->canal;
			$data['canal'][$row->idCanal]['total'] = $row->total_canal;
			$data['tiendas_segmento'][$row->idCanal][$row->idCliente] = 1;
		}

		$result['result'] = 1;
		if (count($data['tiendas']->result()) < 1 or empty($visitas->result())) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $post['grupo_filtro']]);
			$dataParaVista['segmentacion'] = $segmentacion;
			$result['data']['html'] = $this->load->view("modulos/Cobertura/detalle", $data, true);
			$result['data']['configTable'] = [];
		}

		responder:
		echo json_encode($result);
	}

	public function resumen()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Resumen';
		$post = json_decode($this->input->post('data'), true);

		$post['fecIni'] = getFechasDRP($post["txt-fechas"])[0];
		$post['fecFin'] = getFechasDRP($post["txt-fechas"])[1];

		$data = [];

		$data['tiendas'] = $this->m_cobertura->getClientesProgramadosSpoc($post);

		$data['fechas'] = $this->m_cobertura->getFechas($post);

		$prog = $this->m_cobertura->getHorasProgramadas($post);

		$visitas = $this->m_cobertura->getVisitaSpoc($post);

		if (count($data['tiendas']->result()) <= 0) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
			goto responder;
		}
		foreach ($prog->result() as $row) {
			$data['prog'][$row->idUsuario][$row->idCliente][$row->idTiempo]['HP'] = 1;
		}

		foreach ($visitas->result() as $row) {
			$data['visitas'][$row->idUsuario][$row->idCliente][$row->idTiempo]['HT'] = 1;
		}

		foreach ($data['tiendas']->result() as $row) {
			$data['supervisor'][$row->idUsuario]['supervisor'] = $row->usuario;
		}

		$result['result'] = 1;
		if (count($data['tiendas']->result()) < 1 or empty($visitas->result())) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $post['grupo_filtro']]);
			$dataParaVista['segmentacion'] = $segmentacion;
			$result['data']['html'] = $this->load->view("modulos/Cobertura/resumen", $data, true);
			$result['data']['configTable'] = [];
		}

		responder:
		echo json_encode($result);
	}
}
