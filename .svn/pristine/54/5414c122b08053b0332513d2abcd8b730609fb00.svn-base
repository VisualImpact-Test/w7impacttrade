<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filtros extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/maestros/m_filtros', 'm_filtros');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarDistribuidora' => 'Actualizar Distribuidora',
			'registrarDistribuidora' => 'Registrar Distribuidora',
			'masivoDistribuidora' => 'Guardar Masivo Distribuidora',

			'actualizarDistribuidoraSucursal' => 'Actualizar Distribuidora Sucursal',
			'registrarDistribuidoraSucursal' => 'Registrar Distribuidora Sucursal',
			'masivoDistribuidoraSucursal' => 'Guardar Masivo Distribuidora Sucursal',

			'actualizarPlaza' => 'Actualizar Plaza',
			'registrarPlaza' => 'Registrar Plaza',
			'masivoPlaza' => 'Guardar Masivo Plaza',
			
			'actualizarZona' => 'Actualizar Zona',
			'registrarZona' => 'Registrar Zona',
			'masivoZona' => 'Guardar Masivo Zona',
		];

		$this->carpetaHtml = 'modulos/Configuraciones/Maestros/Filtros/';

		$this->html = [
			'distribuidora' => [
				'tabla' => $this->carpetaHtml .  'distribuidora/distribuidoraTabla',
				'new' => $this->carpetaHtml .  'distribuidora/distribuidoraFormNew',
				'update' => $this->carpetaHtml .  'distribuidora/distribuidoraFormUpdate',
				'cargaMasiva' => $this->carpetaHtml .  'distribuidora/distribuidoraFormCargaMasiva'
			],
			'distribuidoraSucursal' => [
				'tabla' => $this->carpetaHtml .  'distribuidoraSucursalTabla',
				'new' => $this->carpetaHtml .  'distribuidoraSucursalFormNew',
				'update' => $this->carpetaHtml .  'distribuidoraSucursalFormUpdate',
				'cargaMasiva' => $this->carpetaHtml .  'distribuidoraSucursalFormCargaMasiva'
			],
			'plaza' => [
				'tabla' => $this->carpetaHtml .  'plaza/plazaTabla',
				'new' => $this->carpetaHtml .  'plaza/plazaFormNew',
				'update' => $this->carpetaHtml .  'plaza/plazaFormUpdate',
				'cargaMasiva' => $this->carpetaHtml .  'plaza/plazaFormCargaMasiva'
			],
			'zona' => [
				'tabla' => $this->carpetaHtml .  'zona/zonaTabla',
				'new' => $this->carpetaHtml .  'zona/zonaFormNew',
				'update' => $this->carpetaHtml .  'zona/zonaFormUpdate',
				'cargaMasiva' => $this->carpetaHtml .  'zona/zonaFormCargaMasiva'
			],
		];
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '77';
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
			'assets/custom/js/configuraciones/maestros/filtros',
		];

		$config['data']['icon'] = 'fas fa-filter';
		$config['data']['title'] = 'Segmentación';
		$config['data']['message'] = 'Módulo para cambiar los filtros';
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
			case 'Distribuidora':
				$tabla = $this->m_filtros->tablas['distribuidora']['tabla'];
				$idTabla = $this->m_filtros->tablas['distribuidora']['id'];
				break;
			case 'DistribuidoraSucursal':
				$tabla = $this->m_filtros->tablas['distribuidoraSucursal']['tabla'];
				$idTabla = $this->m_filtros->tablas['distribuidoraSucursal']['id'];
				break;
			case 'Plaza':
				$tabla = $this->m_filtros->tablas['plaza']['tabla'];
				$idTabla = $this->m_filtros->tablas['plaza']['id'];
				break;
			case 'Zona':
				$tabla = $this->m_filtros->tablas['zona']['tabla'];
				$idTabla = $this->m_filtros->tablas['zona']['id'];
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

		$cambioEstado = $this->m_filtros->actualizarMasivo($tabla, $update, $idTabla);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}
		echo json_encode($result);
	}

	public function getTablaDistribuidora()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$resultados = $this->m_filtros->getDistribuidoras($post)->result_array();

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['distribuidora']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewDistribuidora()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarDistribuidora'];

		$dataParaVista = [];

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['distribuidora']['new'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarDistribuidora()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarDistribuidora'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkDistribuidoraRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_filtros->registrarDistribuidora($post);
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

	public function getFormUpdateDistribuidora()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarDistribuidora'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista = [];
		$dataParaVista['distribuidora'] = $this->m_filtros->getDistribuidoras($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['distribuidora']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarDistribuidora()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarDistribuidora'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkDistribuidoraRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->m_filtros->actualizarDistribuidora($post);

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

	public function getTablaDistribuidoraSucursal()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->m_filtros->getDistribuidoraSucursal($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Filtros/tablaDistribuidoraSucursal', $dataParaVista, true);
			
		}

		echo json_encode($result);
	}

	public function getFormNewDistribuidoraSucursal()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrarDistribuidoraSucursal'];
		$dataParaVista = array();
		$dataParaVista['ubigeo'] = $this->m_filtros->getUbigeo()->result_array();
		$dataParaVista['distribuidoras'] = $this->m_filtros->getDistribuidoras()->result_array();
		$dataParaVista['departamentos'] = [];

		foreach ($dataParaVista['ubigeo'] as $k => $v) {
			if(!empty($v['cod_departamento'])){
				$dataParaVista['departamentos'][$v['cod_departamento']] = [
					'departamento' =>$v['departamento'],
					'cod_departamento' =>$v['cod_departamento'],
				];
			}
		}

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['distribuidoraSucursal']['new'], $dataParaVista, true);

		echo json_encode($result);
    }

	public function registrarDistribuidoraSucursal()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarDistribuidoraSucursal'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'correo' => ['requerido'],
			'departamento' => ['selectRequerido'],
			'provincia' => ['selectRequerido'],
			'cod_ubigeo' => ['selectRequerido'],
			'distribuidora' => ['selectRequerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkDistribuidoraSucursalRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre, distribuidora o distrito.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_filtros->registrarDistribuidoraSucursal($post);
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

	public function getFormUpdateDistribuidoraSucursal()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarDistribuidoraSucursal'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista = [];
		$dataParaVista['distribuidoraSucursal'] = $this->m_filtros->getDistribuidoraSucursal($post)->row_array();
		$dataParaVista['ubigeo'] = $this->m_filtros->getUbigeo()->result_array();
		$dataParaVista['distribuidoras'] = $this->m_filtros->getDistribuidoras()->result_array();
		$dataParaVista['departamentos'] = [];

		foreach ($dataParaVista['ubigeo'] as $k => $v) {
			if(!empty($v['cod_departamento'])){
				$dataParaVista['departamentos'][$v['cod_departamento']] = [
					'departamento' =>$v['departamento'],
					'cod_departamento' =>$v['cod_departamento'],
				];
			}
		}

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['distribuidoraSucursal']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarDistribuidoraSucursal()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarPlaza'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'correo' => ['requerido'],
			'departamento' => ['selectRequerido'],
			'provincia' => ['selectRequerido'],
			'cod_ubigeo' => ['selectRequerido'],
			'distribuidora' => ['selectRequerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkDistribuidoraSucursalRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->m_filtros->actualizarDistribuidoraSucursal($post);

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

	public function getProvincias(){
        $result = $this->result;
		$post = $this->input->post();
		$dataParaVista = array();
		$dataParaVista['ubigeo'] = $this->m_filtros->getUbigeo(['cod_departamento'=>$post['cod_departamento']])->result_array();
		$result['result'] = 1;
		$provincias = [];
		foreach ($dataParaVista['ubigeo'] as $k => $v) {
			if(!in_array($v['provincia'],$provincias)){
				$provincias[] = [
					'id'=> $v['cod_provincia'],
					'text'=> $v['provincia'],
				];
			}
		}

		$result['items'] = $provincias;

		echo json_encode($result);
	}
	public function getDistritos(){
        $result = $this->result;
		$post = $this->input->post();
		$dataParaVista = array();
		$dataParaVista['ubigeo'] = $this->m_filtros->getUbigeo(['cod_provincia'=>$post['cod_provincia'], 'cod_departamento'=>$post['cod_departamento']])->result_array();
		$result['result'] = 1;
		$distritos = [];
		foreach ($dataParaVista['ubigeo'] as $k => $v) {
			if(!in_array($v['distrito'],$distritos)){
				$distritos[] = [
					'id'=> $v['cod_ubigeo'],
					'text'=> $v['distrito'],
				];
			}
		}

		$result['items'] = $distritos;

		echo json_encode($result);
	}

	//PLAZA

	public function getTablaPlaza()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$resultados = $this->m_filtros->getPlazas($post)->result_array();

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['plaza']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewPlaza()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarPlaza'];

		$dataParaVista = [];

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['plaza']['new'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarPlaza()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarPlaza'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'cod_ubigeo' => ['requerido'],
			'direccion' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkPlazaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_filtros->registrarPlaza($post);
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

	public function getFormUpdatePlaza()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarPlaza'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista = [];
		$dataParaVista['plaza'] = $this->m_filtros->getPlazas($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['plaza']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarPlaza()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarPlaza'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'cod_ubigeo' => ['requerido'],
			'direccion' => ['requerido'],
			// 'nombreMayorista' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkPlazaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->m_filtros->actualizarPlaza($post);

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

	//ZONA

	public function getTablaZona()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$resultados = $this->m_filtros->getZonas($post)->result_array();

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['zona']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewZona()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarPlaza'];

		$dataParaVista = [];

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['zona']['new'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarZona()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarPlaza'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'cuenta_zona' => ['requerido'],
			'proyecto_zona' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkZonaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_filtros->registrarZona($post);
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

	public function getFormUpdateZona()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarZona'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista = [];
		$dataParaVista['zonas'] = $this->m_filtros->getZonas($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['zona']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarZona()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarZona'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'cuenta_zona' => ['requerido'],
			'proyecto_zona' => ['requerido'],
			// 'nombreMayorista' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_filtros->checkZonaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->m_filtros->actualizarZona($post);

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
