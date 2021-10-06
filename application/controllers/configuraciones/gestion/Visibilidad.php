<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visibilidad extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_visibilidad', 'model');
		$this->load->model('configuraciones/maestros/m_filtros', 'm_filtros');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarCategoria' => 'Actualizar Categoria',
			'registrarCategoria' => 'Registrar Categoria',
			'masivoCategoria' => 'Guardar Masivo Categoria',

			'actualizarLista' => 'Actualizar Lista Visibilidad',
			'registrarLista' => 'Registrar Lista Visibilidad',
			'masivoLista' => 'Guardar Masivo Lista Visibilidad',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/visibilidad/';

		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaProductoCategoria',
				'new' => $this->carpetaHtml .  'formNewProductoCategoria',
				'update' => $this->carpetaHtml .  'formUpdateProductoCategoria',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaProductoCategoria'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaVisibilidad',
				'new' => $this->carpetaHtml .  'formNewListaVisibilidad',
				'update' => $this->carpetaHtml .  'formUpdateListaVisibilidad',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaVisibilidad'
			],
		];
	}

	public function index()
	{
		$config = array();
		$config['css']['style'] = [
			'assets/libs/dataTables/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/dataTables/datatables',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/visibilidad'
		];

		$config['nav']['menu_active'] = '';
		$config['data']['icon'] = 'fas fa-share-alt';
		$config['data']['title'] = 'Visibilidad';
		$config['data']['message'] = 'Módulo SOS/SOD/ENCARTES';
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
			case 'Categoria':
				$tabla = $this->model->tablas['elemento']['tabla'];
				$idTabla = $this->model->tablas['elemento']['id'];
				break;
			case 'Lista':
				$tabla = $this->model->tablas['lista']['tabla'];
				$idTabla = $this->model->tablas['lista']['id'];
				break;
			case 'Pregunta':
				$tabla = $this->model->tablas['pregunta']['tabla'];
				$idTabla = $this->model->tablas['pregunta']['id'];
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
		echo json_encode($result);
	}


	// SECCION ELEMENTOS
	public function getTablaCategoria()
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

		echo json_encode($result);
	}

    public function getFormNewCategoria()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['new'], $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarCategoria()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->model->registrarElemento	($post);
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
	public function actualizarCategoria()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],

		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->model->actualizarElemento($post);

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


	public function getFormUpdateCategoria()
	{
		$result = $this->result;
        
        $post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getElementos($post)->row_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['update'], $dataParaVista, true);

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

		echo json_encode($result);
	}
	public function getFormNewLista()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$dataParaVista['categorias'] = $this->model->getElementos()->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas()->result_array();
		$dataParaVista['canales'] = $this->m_filtros->getCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->m_filtros->getProyectos($post)->result_array();

		// $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
		// $dataParaVista['grupoCanales'] = $this->m_filtros->getGrupoCanales()->result_array();
		// $dataParaVista['clientes'] = $this->model->getClientes()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['new'], $dataParaVista, true);

		echo json_encode($result);
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
				$html .= "<td><input  readonly='readonly' style='border:none;' class ='form-control' id='marca_".$marca[$this->model->tablas['marca']['id']]."' name='marca_".$marca[$this->model->tablas['marca']['id']]."' value='".$marca['nombre']."'></td>";
			$html .= "</tr>";
			$result['data']['html'] = $html;
		}

		echo json_encode($result);
	}

	public function getFormUpdateLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas()->result_array();

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post='';
		$dataParaVista['canales'] = $this->m_filtros->getCanales()->result_array();

		$dataParaVista['proyectos'] = $this->m_filtros->getProyectos($post)->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarLista'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'canal' => ['requerido'],
			'fechaInicio' => ['requerido'],
			'proyecto' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$array_encuestas_1 = array_slice($post, 5);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		$registro = $this->model->registrarLista($post);

		$idLista = $this->db->insert_id();

		$registro_detalle = true;
		foreach($array_encuestas_1 as $row){
			$x = is_array($row);
			if(!$x){
				$encuesta = $this->model->getIdEncuesta($row)->row_array();
				$registro2 = $this->model->registrarListaDetalle($idLista,$encuesta['idEncuesta']);
			}else{
				$registro_detalle = false;
				break;
			}
		}

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}else if($registro_detalle == false){
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
			$this->db->trans_rollback();
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');

		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function actualizarLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'canal' => ['requerido'],
			'fechaInicio' => ['requerido'],
			'proyecto' => ['requerido'],

		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$array_encuestas_1 = array_slice($post, 5);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		$registro = $this->model->actualizarLista($post);

		$idLista = $post['idlst'];

		$registro_detalle = true;
		foreach($array_encuestas_1 as $row){
			$x = is_array($row);
			if(!$x){
				$encuesta = $this->model->getIdEncuesta($row)->row_array();
				$registro2 = $this->model->registrarListaDetalle($idLista,$encuesta['idEncuesta']);
			}else{
				$registro_detalle = false;
				break;
			}
		}
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}else if($registro_detalle == false){
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('listaElementoRepetido');
			$this->db->trans_rollback();
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');

		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	
}
