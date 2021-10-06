<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carpetas extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/maestros/m_carpetas', 'm_carpetas');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',
			'carpetas' => ['actualizar' => 'Actualizar Carpeta', 'registrar' => 'Registrar Carpeta'],
		];

		$this->carpetaHtml = 'modulos/Configuraciones/Maestros/Carpetas/';

		$this->html = [
			'carpetas' => [
				'tabla' => $this->carpetaHtml .  'carpetasTabla',
				'new' => $this->carpetaHtml .  'carpetasFormNew',
				'update' => $this->carpetaHtml .  'carpetasFormUpdate',
			],
		];
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '76';
		$config['css']['style'] = [
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/maestros/carpetas',
		];

		$config['data']['icon'] = 'fal fa-cabinet-filing';
		$config['data']['title'] = 'Fichero Web';
		$config['data']['message'] = 'Módulo para las carpetas de los archivos';
		$config['data']['grupos'] = $this->m_carpetas->getGrupos()->result_array();
		$config['view'] = $this->carpetaHtml . 'index';

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
			case 'Carpetas':
				$tabla = $this->m_carpetas->tablas['carpetas']['tabla'];
				$idTabla = $this->m_carpetas->tablas['carpetas']['id'];
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

		$cambioEstado = $this->m_carpetas->actualizarMasivo($tabla, $update, $idTabla);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}
		echo json_encode($result);
	}

	// SECCION CARPETAS
	public function getTablaCarpetas()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$resultados = $this->m_carpetas->getCarpetas($post)->result_array();

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['carpetas']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewCarpetas()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['carpetas']['registrar'];

		$dataParaVista['grupos'] = $this->m_carpetas->getGrupos()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '30%';
		$result['data']['html'] = $this->load->view($this->html['carpetas']['new'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarCarpetas()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['carpetas']['registrar'];
		$post = json_decode($this->input->post('data'), true);
		$post['idUsuario'] = $this->idUsuario;

		$elementosAValidar = [
			'grupo' => ['selectRequerido'],
			'carpeta' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		if ($this->m_carpetas->checkNombreCarpetaRepetida($post)) $validaciones['carpeta'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_carpetas->registrarCarpeta($post);
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

	public function getFormUpdateCarpetas()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['carpetas']['actualizar'];
		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['carpeta'] = $this->m_carpetas->getCarpetas($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['carpetas']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarCarpetas()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['carpetas']['actualizar'];
		$post = json_decode($this->input->post('data'), true);
		$post['idUsuario'] = $this->idUsuario;

		$elementosAValidar = [
			'grupo' => ['selectRequerido'],
			'carpeta' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		if ($this->m_carpetas->checkNombreCarpetaRepetida($post)) $validaciones['carpeta'][] = getMensajeGestion('registroRepetido');
		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->m_carpetas->actualizarCarpeta($post);

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
}
