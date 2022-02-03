<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Encuestas extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_encuestas', 'm_encuestas');
		$this->load->model('configuraciones/maestros/m_filtros', 'm_filtros');
		$this->load->model('M_control', 'm_control');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarEncuesta' => 'Actualizar Encuesta',
			'registrarEncuesta' => 'Registrar Encuesta',
			'masivoEncuesta' => 'Guardar Masivo Encuesta',

			'actualizarLista' => 'Actualizar Lista Encuesta',
			'registrarLista' => 'Registrar Lista Encuesta',
			'masivoLista' => 'Guardar/Actualizar Masivo Lista Encuesta',

		];

		$this->carpetaHtml = 'modulos/configuraciones/gestion/encuestas/';
        
		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaElemento',
				'new' => $this->carpetaHtml .  'formNewElemento',
				'update' => $this->carpetaHtml .  'formUpdateElemento',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaEncuesta'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaVisibilidad',
				'new' => $this->carpetaHtml .  'formNewListaVisibilidad',
				'update' => $this->carpetaHtml .  'formUpdateListaVisibilidad',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaEncuesta',
			],
		];
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/bootstraptoggle/bootstrap4-toggle.min',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/libs/bootstraptoggle/bootstrap4-toggle.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/encuestas'
		];

		$config['nav']['menu_active'] = '86';
		$config['data']['icon'] = 'fal fa-file-alt';
		$config['data']['title'] = 'Encuestas';
		$config['data']['message'] = 'Módulo encuestas';
		$config['view'] = 'modulos/configuraciones/gestion/encuestas/index';

		$tipos = $this->m_encuestas->getTiposUsuario()->result_array();
		$config['data']['tipos'] = $tipos;
		
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
			case 'Encuesta':
				$tabla = $this->m_encuestas->tablas['encuesta']['tabla'];
				$idTabla = $this->m_encuestas->tablas['encuesta']['id'];
				break;
			case 'Lista':
				$tabla = $this->m_encuestas->tablas['lista']['tabla'];
				$idTabla = $this->m_encuestas->tablas['lista']['id'];
				break;
			case 'Pregunta':
				$tabla = $this->m_encuestas->tablas['pregunta']['tabla'];
				$idTabla = $this->m_encuestas->tablas['pregunta']['id'];
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

		$cambioEstado = $this->m_encuestas->actualizarMasivo($tabla, $update, $idTabla);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	//Obtener Cliente
	public function getSegCliente(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$idCuenta = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$post['idCuenta']=$idCuenta;

		$idProyecto = !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";
		$post['idProyecto']=$idProyecto;


		$data = $this->m_encuestas->getSegCliente($post)->result_array();
		
		$html = "<option value=''>-- Seleccionar --</option>";
		foreach($data as $row){
			$html .= '<option value='.$row['idCliente'].'>'.$row['razonSocial'].'</option>';
		}

		$result['data']['html'] = $html; 
		$result['result'] = 1;

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	// SECCION ALTERNATIVAS
	public function getTablaAlternativa()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->m_encuestas->getAlternativas($post)->result_array();
		$dataParaVista['pregunta'] = $this->m_encuestas->getPregunta($post)->row_array();
		
		//clase
		$class = 'formEditarAlternativas';
		$dataParaVista['class'] = $class;

		$result['result'] = 1;
		if (count($data) < 1) {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaAlternativa", $dataParaVista, true);

		} else {
			$dataParaVista['data'] = $data;

			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaAlternativa", $dataParaVista, true);
		}

		$titulo = '';
		$width = '';
		$result['msg']['title'] = $titulo;
		$result['data']['width'] = $width;
		$result['data']['class'] = $class;
		$result['result'] = 1;

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}
	// SECCION PREGUNTAS
	public function getTablaPregunta()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->m_encuestas->getPreguntas($post)->result_array();
		
		//clase
		$class = 'formEditarPreguntas';

		$result['result'] = 1;
		if (count($data) < 1) {
			$dataParaVista['data'] = $data;
			$dataParaVista['tiposPregunta'] = $this->m_encuestas->getTiposPreguntas()->result_array();
			$dataParaVista['encuesta'] = $this->m_encuestas->getEncuestas($post)->row_array();
			$dataParaVista['class'] = $class;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaPregunta_", $dataParaVista, true);

		} else {
			$dataParaVista['data'] = $data;
			$dataParaVista['tiposPregunta'] = $this->m_encuestas->getTiposPreguntas()->result_array();
			$dataParaVista['encuesta'] = $this->m_encuestas->getEncuestas($post)->row_array();
			$dataParaVista['class'] = $class;

			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaPregunta_", $dataParaVista, true);
		}

		$titulo = '';
		$width = '';
		$result['msg']['title'] = $titulo;
		$result['data']['width'] = $width;
		$result['data']['class'] = $class;
		$result['result'] = 1;

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}
	
	public function actualizarPreguntas()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarEncuesta'];
		
		$post = json_decode($this->input->post('data'), true);
		
		$idEncuesta = !empty($post['idEncuesta']) ? $post['idEncuesta'] : '';
		$delete = true;$update = true;$insert = true;

		
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);

		$elementosAValidar = [
			'tipoPregunta' => ['selectRequerido'],
			'textoPregunta' => ['requerido'],
			'txtOrden' => ['requerido','numerico'],
			'estadoPregunta' => ['minimoUnCheck'],
		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);


		$validaciones = validacionesMultiToSimple($validacionesMulti);
		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->m_encuestas->deleteMasivo($this->m_encuestas->tablas['pregunta']['tabla'], $this->m_encuestas->tablas['pregunta']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->m_encuestas->actualizarMasivoPreguntas($multiDataRefactorizada);
		//INSERT
		$insert = $this->m_encuestas->guardarMasivoPreguntas($multiDataRefactorizada, $idEncuesta);

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarAlternativas()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = "Actualizar Alternativas";
		
		$post = json_decode($this->input->post('data'), true);
		
		$idPregunta = !empty($post['idPregunta']) ? $post['idPregunta'] : '';
		$delete = true;$update = true;$insert = true;
		
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);

		$elementosAValidar = [
			'textoAlternativa' => ['requerido'],
			'estadoAlternativa' => ['minimoUnCheck'],
		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);


		$validaciones = validacionesMultiToSimple($validacionesMulti);
		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->m_encuestas->deleteMasivo($this->m_encuestas->tablas['alternativa']['tabla'], $this->m_encuestas->tablas['alternativa']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->m_encuestas->actualizarMasivoAlternativas($multiDataRefactorizada);
		//INSERT
		$insert = $this->m_encuestas->guardarMasivoAlternativas($multiDataRefactorizada, $idPregunta);

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	// SECCION ENCUESTAS
	public function getTablaEncuesta()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
 
		$post['idCuenta']=$post['cuenta_encuesta'];
 
		$data = $this->m_encuestas->getEncuestas($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaEncuesta", $dataParaVista, true);
		}

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function getTablaLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$fechas = explode(' - ', $post['txt-fechas']);

		$post['fecIni'] = $fechas[0];
		$post['fecFin'] = $fechas[1];

		if( empty($post['proyecto']) ){
			$post['proyecto']=$this->session->userdata('idProyecto');
		}
		$data = $this->m_encuestas->getListas($post)->result_array();
		$array_encuesta = array();

		foreach($data as $row){
			$array_encuesta['encuesta'][$row['idListEncuesta']]['idListEncuesta']=$row['idListEncuesta'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['idCliente']=$row['idCliente'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['codCliente']=$row['codCliente'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['razonSocial']=$row['razonSocial'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['tipo']=$row['tipo'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['grupoCanal']=$row['grupoCanal'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['canal']=$row['canal'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['proyecto']=$row['proyecto'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['fecIni']= $row['fecIni'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['fecFin']= $row['fecFin'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['fechaModificacion']= $row['fechaModificacion'];
			$array_encuesta['encuesta'][$row['idListEncuesta']]['estado']= $row['estado'];
			$array_encuesta['encuestaDet'][$row['idListEncuesta']][$row['idEncuesta']]= $row['encuesta'];
		}
		
		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $array_encuesta;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaListaEncuesta", $dataParaVista, true);
		}

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarLista'];
		$post = json_decode($this->input->post('data'), true);

		$idCuentas = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		
		$params=array();
		$params['idCuenta']=$post['cuenta_encuesta'];

		$dataParaVista['encuestas'] = $this->m_encuestas->getEncuestas($params)->result_array();
		$dataParaVista['canales'] = $this->m_filtros->getCanales($post)->result_array();
		$dataParaVista['tipoUsuario'] = $this->m_encuestas->getTipoUsuario($post)->result_array();

		$dataParaVista['lista_encuesta'] =  array();
		$canalCuenta = $this->m_encuestas->obtenerCanalCuenta($idCuentas)->result_array();
		foreach($canalCuenta as $row){
			$dataParaVista['grupocanal'][$row['idGrupoCanal']]=$row['grupoCanal'];
		}
		foreach($canalCuenta as $row){
			$dataParaVista['canales'][$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$result['data']['grupoCanal'] = $dataParaVista['canales']; 

		$class = "modalNew";
		$dataParaVista['class'] = $class;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['class'] = $class;
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/formNewListaEncuesta", $dataParaVista, true);

		$this->aSessTrack = array_merge($this->aSessTrack, $this->m_encuestas->aSessTrack);
		$this->aSessTrack = array_merge($this->aSessTrack, $this->m_filtros->aSessTrack);

		echo json_encode($result);
	}

	public function getFormUpdateLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarLista'];

		$post = json_decode($this->input->post('data'), true);

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->m_encuestas->getCuentas($params)->result_array();
		$dataParaVista['tipoUsuario'] = $this->m_encuestas->getTipoUsuario($post)->result_array();

		$list_cuentas=array();
		if( count($dataParaVista['cuentas'])>0){
			foreach($dataParaVista['cuentas'] as $row){
				array_push($list_cuentas, $row['idCuenta']);
			}
		}
		$params['cuentas']= implode(",",$list_cuentas); 

		$dataParaVista['encuestas'] = $this->m_encuestas->getEncuestas($params)->result_array();
		$dataParaVista['data'] = $this->m_encuestas->getListas($post)->row_array();
		
		//
		$data_lista=array();
		$data_lista['idCanal']=$dataParaVista['data']['idCanal'];
		$data_lista['idProyecto']=$dataParaVista['data']['idProyecto'];
		$dataParaVista['clientes'] = $this->m_encuestas->getSegCliente($data_lista)->result_array();
		//
		$dataParaVista['lista_encuesta'] =  $this->m_encuestas->getListaEncuestas($post)->result_array();
		$post='';
		$dataParaVista['grupoCanal'] = $this->m_encuestas->getGrupoCanales()->result_array();
		$dataParaVista['canales'] = $this->m_encuestas->getCanales()->result_array();

		$arr=array();
		foreach($dataParaVista['canales'] as $row){
			$arr[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr;

		$dataParaVista['proyectos'] = $this->m_encuestas->getProyectos($params)->result_array();
		$class = 'modalUpdate';
		$dataParaVista['class'] = $class;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['class'] = $class;
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/formUpdateListaEncuesta", $dataParaVista, true);

		$this->aSessTrack = array_merge($this->aSessTrack, $this->m_encuestas->aSessTrack);
		$this->aSessTrack = array_merge($this->aSessTrack, $this->m_filtros->aSessTrack);

		echo json_encode($result);
	}

	public function getEncuesta(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->m_encuestas->getEncuestas($post)->row_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$html = "";
			$html .= "<tr id='fila_temporal_encuesta'>";
				$html .= "<td ><i class='fas fa-trash' id='eliminar_encuesta'></i></td>";
				$html .= "<td><input  readonly='readonly' style='border:none;' class ='form-control' id='encuesta_".$data['idEncuesta']."' name='encuesta_".$data['idEncuesta']."' value='".$data['nombre']."'></td>";
			$html .= "</tr>";
			$result['data']['html'] = $html;
		}

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewEncuesta()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarEncuesta'];

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/formNewEncuesta", [], true);

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function registrarLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarEncuesta'];

		$post = json_decode($this->input->post('data'), true);

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
		];

		$elementosAValidarMulti = [
			'sl_encuesta'=>['selectRequerido']
		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;

		$post["proyecto"]= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->m_encuestas->registrarLista($post);

		$idLista = $this->m_encuestas->insertId;

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->m_encuestas->deleteMasivo($this->m_encuestas->tablas['listaDet']['tabla'], $this->m_encuestas->tablas['listaDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->m_encuestas->actualizarMasivoListaEncuesta($multiDataRefactorizada);
		//INSERT
		$insert = $this->m_encuestas->guardarMasivoListaEncuesta($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function registrarEncuesta()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarEncuesta'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'foto' => ['requerido'],
			// 'razonSocial' => ['requerido'],
			// 'direccion' => ['requerido'],
			// 'ubigeo' => ['requerido', 'numerico'],
			// 'urlCss' => [],
			// 'urlLogo' => [],
			// 'checktest' => ['minimoUnCheck'],
			// 'checktest2' => ['minimoUnCheck'],
			// 'radiotest' => ['radioRequerido'],
			// 'radiotest2' => [],
			// 'fecIni' => ['requerido'],
			// 'fecIni2' => ['requerido'],
			// 'fecFin2' => ['requerido'],
			// 'selectTest' => ['selectRequerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_encuestas->checkNombreEncuestaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$post['cuenta']= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";

		$registro = $this->m_encuestas->registrarEncuesta($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateEncuesta()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarEncuesta'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['data'] = $this->m_encuestas->getEncuestas($post)->row_array();

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->m_encuestas->getCuentas($params)->result_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/formUpdateEncuesta", $dataParaVista, true);

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarEncuesta()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarEncuesta'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'foto' => ['requerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_encuestas->checkNombreEncuestaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->m_encuestas->actualizarEncuesta($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarEncuesta'];

		$post = json_decode($this->input->post('data'), true);
		$idLista = $post['idLista'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;
		
		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido']
		];
		$elementosAValidarMulti = [
			'sl_encuesta'=>['selectRequerido']

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
		$registro = $this->m_encuestas->actualizarLista($post);

		
		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->m_encuestas->deleteMasivo($this->m_encuestas->tablas['listaDet']['tabla'], $this->m_encuestas->tablas['listaDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->m_encuestas->actualizarMasivoListaEncuesta($multiDataRefactorizada);
		//INSERT
		$insert = $this->m_encuestas->guardarMasivoListaEncuesta($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function getFormCargaMasivaLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

		$gruposCanal = $this->m_encuestas->getGrupoCanales()->result_array();
        $canales = $this->m_encuestas->getCanales()->result_array();
		$post = '';
		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		//$cuentas=$this->m_encuestas->getCuentas($params)->result_array();
		
		// $list_cuentas=array();
		// if( count($cuentas)>0){
		// 	foreach($cuentas as $row){
		// 		array_push($list_cuentas, $row['idCuenta']);
		// 	}
		// }
		// $params['cuentas']= implode(",",$list_cuentas);


        $clientes = $this->m_encuestas->getClientes()->result_array();
		$elementos = $this->m_encuestas->getEncuestas($params)->result_array();
		$tipos = $this->m_encuestas->getTiposUsuario()->result_array();

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

		$tiposRefactorizado = [];
		foreach ($tipos as $row) {
			if (!in_array($row['nombre'], $tiposRefactorizado)) $tiposRefactorizado[] = $row['nombre'];
		}
        $tipos = !empty($tiposRefactorizado) ? $tiposRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
				['idLista' => null
				, 'grupoCanal' => null 
				, 'canal' => null 
				, 'tipoUsuario' => null 
				, 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
			'headers' => ['ID Lista'
				, 'GRUPO CANAL'
                , 'CANAL'
				, 'TIPO USUARIO'
				, 'COD VISUAL'
                , 'FECHA INICIO'
                , 'FECHA FIN'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'grupoCanal', 'type' => 'myDropdown', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'tipoUsuario', 'type' => 'myDropdown', 'placeholder' => 'Tipo Usuario', 'source' => $tipos],
				['data' => 'idCliente', 'type' => 'myDropdown', 'placeholder' => 'COD VISUAL (ID Cliente)', 'source' => $clientes],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];
        $flag = [
			0 => "NO",
			1 => "SÍ",
		];

		$HT[1] = [
			'nombre' => 'Encuesta',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                , 'obligatorio' => null
                ]
			],
            'headers' => ['ID Lista'
                , 'Elemento'
                , 'Obligatorio'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Encuesta', 'source' => $elementos],
				['data' => 'obligatorio', 'type' => 'myDropdown', 'placeholder' => 'Obligatorio', 'source' => $flag],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['lista']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
    }
    
	public function guardarCargaMasivaLista(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
		$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->m_encuestas->tablas['encuesta']['tabla'], 'idTabla' => $this->m_encuestas->tablas['encuesta']['id']];
        $elementos = $this->getIdsCorrespondientes($elementosParmas);
        
        array_pop($elementos);

		$idCuenta=$this->session->userdata('idCuenta');

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][1] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		//$listasParams['grupos'][2] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
		$listasParams['grupos'][2] = ['columnas' => ['tipoUsuario'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.usuario_tipo', 'idTabla' =>'idTipoUsuario'];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$idProyecto= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$listas_unicas = $this->m_encuestas->validar_filas_unicas_HT($listas);

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

			$value['idProyecto']=$idProyecto;

            if(empty($value['idCanal'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Canal.<br> Lista N°: '.$value['idLista']));
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
			
			$rs = $this->m_encuestas->registrarLista_HT($value);
            $idLista = $this->db->insert_id();
            
            if(!$rs){
                $insertMasivo = false;
                break;
            }

			foreach($elementos as $row){

                if($row['idLista'] == $value['idLista']){
                    $multiDataRefactorizada[] = [
                        'elemento_lista' => $row[$this->m_encuestas->tablas['encuesta']['id']],
                        'obligatorio' => empty($row["obligatorio"]) || $row["obligatorio"] == "NO"? 0 : 1,
                    ];
                }
            }
            $insert = $this->m_encuestas->guardarMasivoLista($multiDataRefactorizada, $idLista);

			if($insert == 'repetido'){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,"message"=> 'Se encontraron encuestas repetidas para la lista N:'.$value['idLista']]);
				echo json_encode($result);
				exit();
			}
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

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
    }

	public function getFormCargaMasivaEncuesta()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoEncuesta'];

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');

        $cuentas = $this->m_encuestas->getTipoPregunta()->result_array();
        $post = '';


		//REFACTORIZANDO DATA
		$tipoPreguntaRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['nombre'], $tipoPreguntaRefactorizado)) $tipoPreguntaRefactorizado[] = $row['nombre'];
		}
        $tipos = !empty($tipoPreguntaRefactorizado) ? $tipoPreguntaRefactorizado : [' '];


		
		$obligatorio =  ['Si','No'];
        

		$array=array();
		$array['tipoPregunta'] = $tipos;
		$array['obligatorio'] = $obligatorio;



		// //ARMANDO HANDSONTABLE
		// $HT[0] = [
		// 	'nombre' => 'Encuestas',
		// 	'data' => [
        //         [
		// 		'encuesta' => null
		// 		, 'foto' => null 
		// 		, 'tipoPregunta' => null 
		// 		, 'pregunta' => null 
		// 		, 'obligatorio' => null 
		// 		, 'orden' => null 
		// 		, 'alternativa' => null 
        //         ]
		// 	],
        //     'headers' => [
		// 		'Encuesta'
		// 		, 'Foto'
		// 		, 'Tipo Pregunta'
		// 		, 'Pregunta'
		// 		, 'Obligatorio'
		// 		, 'Orden'
		// 		, 'Alternativa'

        //     ],
		// 	'columns' => [
		// 		['data' => 'encuesta', 'type' => 'text', 'placeholder' => 'Encuesta', 'width' => 200, 'color'=>'red'],
		// 		['data' => 'foto', 'type' => 'myDropdown', 'placeholder' => 'Foto', 'source' => $obligatorio, 'width' => 70],
		// 		['data' => 'tipoPregunta', 'type' => 'myDropdown', 'placeholder' => 'Foto', 'source' => $tipos],
		// 		['data' => 'pregunta', 'type' => 'text', 'placeholder' => 'Pregunta', 'width' => 200 ],
		// 		['data' => 'obligatorio', 'type' => 'myDropdown', 'placeholder' => 'Obligatorio', 'source' => $obligatorio ],
		// 		['data' => 'orden', 'type' => 'text', 'placeholder' => 'Orden', 'width' => 100],
		// 		['data' => 'alternativa', 'type' => 'text', 'placeholder' => 'Alternativa', 'width' => 300]
		// 	],
		// 	'colWidths' => 200,
        // ];
        
		// //MOSTRANDO VISTA
		// $dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		// $result['result'] = 1;
		// $result['data']['width'] = '70%';
		// $result['data']['html'] = $this->load->view($this->html['elemento']['cargaMasiva'], $dataParaVista, true);
		// $result['data']['ht'] = $HT;

		// $this->aSessTrack = $this->m_encuestas->aSessTrack;
		// echo json_encode($result);

		$html='';
		$html .= $this->load->view($this->html['elemento']['cargaMasiva'], $array, true);
		//Result
		$result['result']=1;
		$result['data']['html'] = $html;	

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);

    }
    
	public function guardarCargaMasivaEncuesta(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoEncuesta'];

		$contEncuestas=0;
		$contPreguntas=0;
		$contAlternativas=0;
		

        $post = json_decode($this->input->post('data'), true);

		$dataArray= $post["dataArray"];
		$idCuenta= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
        
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;

		$arrDataEncuesta= [] ;
		$arrDataPregunta= [] ;
		$arrData= [] ;
		foreach($dataArray as $index => $value){
			$arrDataEncuesta[$value[0]]=$value;
			$arrDataPregunta[$value[0]][$value[3]]=$value;
			$arrData[$value[0]][$value[3]][$index]= $value[6];
		}

        foreach($arrDataEncuesta as $index_encuesta => $value_enc){
			//registrar encuesta
			$params = [] ;
			$params['nombre']=$value_enc[0];
			$params['foto']= ($value_enc[1]=="Si")? 1 : 0 ;
			$params['cuenta']=$idCuenta;
			
			
			$registro = $this->m_encuestas->registrarEncuesta($params);
			$idEncuesta=$this->m_encuestas->insertId;
			if ($registro) {
				$contEncuestas++;
				foreach($arrDataPregunta[$index_encuesta] as $index_pregunta => $value_preg){

					$params_pregunta = [] ;
					$params_pregunta['idEncuesta']=$idEncuesta;
					$params_pregunta['nombre']= $value_preg[3];
					$params_pregunta['obligatorio']= ($value_enc[4]=="Si")? 1 : 0 ;;	
					$params_pregunta['orden']= $value_preg[5];	
					if($value_preg[2]=="Abierta"){
						$params_pregunta['idTipoPregunta']=1;
					}
					else if($value_preg[2]=="Cerrada"){
						$params_pregunta['idTipoPregunta']=2;
					}
					else if($value_preg[2]=="Multiple"){
						$params_pregunta['idTipoPregunta']=3;
					}
					
					$registroPregunta = $this->m_encuestas->registrarEncuestaPregunta($params_pregunta);
					$idPregunta=$this->m_encuestas->insertId;
					if ($registroPregunta) {
						$contPreguntas++;
						if($params_pregunta['idTipoPregunta']==2 || $params_pregunta['idTipoPregunta']==3){
							if( !empty($arrData[$index_encuesta][$index_pregunta]) ){

								foreach($arrData[$index_encuesta][$index_pregunta] as $index_alternativa => $value_alt){
									$params_pregunta_alternativa = [] ;
									$params_pregunta_alternativa['idPregunta']=$idPregunta;
									$params_pregunta_alternativa['nombre']=$value_alt;

									$registroAlternativa = $this->m_encuestas->registrarPreguntaAlternativa($params_pregunta_alternativa);
									if($registroAlternativa){
										$contAlternativas++;
									}
								}
							} 
						}
					}

				}
			}
		}

		$this->db->trans_complete();

		$html='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR <strong>'.$contEncuestas.' ENCUESTAS</strong> CORRECTAMENTE.</div>';
		// $masivo = $this->m_encuestas->registrar_elementos_HT($multiDataRefactorizada);
		$result['msg']['content'] = $html;

		
		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}
	

	// SECCION PREGUNTAS HIJO
	public function getTablaPreguntaHijo()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->m_encuestas->getPreguntasHijo($post)->result_array();
		$dataParaVista['alternativa'] = $this->m_encuestas->getAlternativa($post)->row_array();
		$parms=array("id"=> $dataParaVista['alternativa']['idEncuesta'] );
		$dataParaVista['preguntas'] = $this->m_encuestas->getPreguntas($parms)->result_array();
		
		
		//clase
		$class = 'formEditarPreguntasHijo';
		$dataParaVista['class'] = $class;

		$result['result'] = 1;
		if (count($data) < 1) {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaPreguntaHijo", $dataParaVista, true);

		} else {
			$dataParaVista['data'] = $data;

			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/encuestas/tablaPreguntaHijo", $dataParaVista, true);
		}

		$titulo = '';
		$width = '';
		$result['msg']['title'] = $titulo;
		$result['data']['width'] = $width;
		$result['data']['class'] = $class;
		$result['result'] = 1;

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}


	public function actualizarPreguntasHijo()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = "Actualizar Preguntas Hijo";
		
		$post = json_decode($this->input->post('data'), true);
		
		$idAlternativa = !empty($post['idAlternativa']) ? $post['idAlternativa'] : '';
		$delete = true;$update = true;$insert = true;
		
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);

		$elementosAValidar = [
		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);


		$validaciones = validacionesMultiToSimple($validacionesMulti);
		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$this->m_encuestas->deleteMasivoPreguntaHijo($elementosEliminados,$idAlternativa);

		}
		//UPDATE
		$update = $this->m_encuestas->actualizarMasivoPreguntaHijo($multiDataRefactorizada,$idAlternativa,$post);

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function getCanales(){

		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data3 = $this->m_encuestas->obtenerCanalCuenta($post)->result_array();

		$arr_canal=array();
		foreach($data3 as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}

		$result['data']['grupoCanal'] = $arr_canal; 
		$result['result'] = 1;

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarCargaMasivaLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
		$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->m_encuestas->tablas['encuesta']['tabla'], 'idTabla' => $this->m_encuestas->tablas['encuesta']['id']];
        $elementos = $this->getIdsCorrespondientes($elementosParmas);
        
        array_pop($elementos);

		$idCuenta=$this->session->userdata('idCuenta');

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][1] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		//$listasParams['grupos'][2] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
		$listasParams['grupos'][2] = ['columnas' => ['tipoUsuario'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.usuario_tipo', 'idTabla' =>'idTipoUsuario'];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$idProyecto= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$listas_unicas = $this->m_encuestas->validar_filas_unicas_HT($listas);

		if(!$listas_unicas){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que todas las listas tengan un ID único'));
			goto responder;
		}

		$insertMasivo  = true;
		$fila = 1;
		$updateListas = [];
		$insertEncuestas = [];
		$deleteListaDetalle = [];

		$listasExistentes= [];
		$listasrs = $this->m_encuestas->getListas(['all' => 1])->result_array();
		foreach ($listasrs as $k => $row) {
			$listasExistentes['listas'][$row['idListEncuesta']] = 1;
			$listasExistentes['encuestas'][$row['idListEncuesta']][$row['idEncuesta']] = 1;
		}

        foreach($listas as $ix => $value){
			if(empty($value['idLista'])) continue;

			$value['idProyecto']=$idProyecto;

			if(empty($listasExistentes['listas'][$value['idLista']])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>"El ID de Lista no existe. <br> Fila:".($ix+1). "<br> <strong>Hoja de Listas</strong>"]);
				goto responder;
			}

            if(!empty($value['fechaFin']) && !empty($value['fechaInicio'])){
                $fechaInicio = strtotime(str_replace('/','-',$value['fechaInicio']));
                $fechaFin = strtotime(str_replace('/','-',$value['fechaFin']));

               
                if($fechaFin < $fechaInicio){
                    $result['result'] = 0;
                    $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'La fecha Fin no puede ser menor a la fecha Inicio.<br> Lista N°: '.$value['idLista']));
                    goto responder;
                }
			}
			$updateListas[$ix] = [
				'idListEncuesta' => $value['idLista'],
				'idProyecto' => trim($value['idProyecto']),
			];
			
			!empty($value['fechaInicio']) ? $updateListas[$ix]['fecIni'] = trim($value['fechaInicio']) : '';
			!empty($value['idCanal']) ? $updateListas[$ix]['idCanal'] = trim($value['idCanal']) : '';
			!empty($value['fechaFin']) ? $updateListas[$ix]['fecFin'] = trim($value['fechaFin']) : '';
			!empty($value['idCliente']) ? $updateListas[$ix]['idCliente'] = trim($value['idCliente']) : '';
			!empty($value['idTipoUsuario']) ? $updateListas[$ix]['idTipoUsuario'] = trim($value['idTipoUsuario']) : '';

			

		}

		$idsLista = [];
		$detalleParaInsertar = [];

		foreach ($elementos as $ix => $v) {

			if(empty($v['idLista'])) continue;

			if(empty($listasExistentes['listas'][$v['idLista']])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>"El ID de Lista no existe. <br> Fila:".($ix+1). "<br> <strong>Hoja de Encuestas</strong>"]);
				goto responder;
			}
			
			($v['obligatorio'] == "NO") ? $v['obligatorio'] = 0 : $v['obligatorio'] = 1;

			$deleteListaDetalle[] = $v['idLista'];
			$insertEncuestas[] = [
				'idListEncuesta' => $v['idLista'],
				'idEncuesta' => $v['idEncuesta'],
				'obligatorio' => $v['obligatorio'],
			];

			if(!empty($detalleParaInsertar[$v['idLista']][$v['idEncuesta']])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>"No se pueden repetir encuestas dentro de una Lista. <br> Fila:".($ix+1). "<br> <strong>Hoja de Encuestas</strong>"]);
				goto responder;
			}

			$detalleParaInsertar[$v['idLista']][$v['idEncuesta']] = ($ix+1);

			$idsLista [] = $v['idLista'];
		
		}

		if(!empty($updateListas)){
			$rs = $idLista = $this->m_encuestas->actualizarLista_HT($updateListas);

			if(!$rs){
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				goto responder;
			}
		}

		if(!empty($insertEncuestas)){

			if(empty($post['chk-nuevo'])) {
				$deleteListaDetalle = [] ;
				
				foreach ($listasrs as $ix => $ls) {
					if(!empty($detalleParaInsertar[$ls['idListEncuesta']][$ls['idEncuesta']])){
						$fila = $detalleParaInsertar[$ls['idListEncuesta']][$ls['idEncuesta']];
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(['type'=>2,'message'=>"La encuesta ya existe dentro de la lista. <br> Fila:".$fila. "<br> <strong>Hoja de Encuestas</strong>"]);
						goto responder;
					}
				}
			} 

			$rsEncuestas = $this->m_encuestas->actualizarMasivoLista($insertEncuestas,$deleteListaDetalle);

			if(!$rsEncuestas){
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				goto responder;
			}
		}

		
		$result['result'] = 1;
		$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
		

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_encuestas->aSessTrack;
		echo json_encode($result);
	}

}
