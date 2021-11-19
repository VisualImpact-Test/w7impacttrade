<?php defined('BASEPATH') or exit('No direct script access allowed');

class Visibilidad extends MY_Controller
{
	var $htmlNoResultado = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/trade/m_visibilidad', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarElemento' => 'Actualizar Elemento Visibilidad',
			'registrarElemento' => 'Registrar Elemento Visibilidad',
			'masivoElemento' => 'Guardar Masivo Elemento Visibilidad',

			'actualizarLista' => 'Actualizar Lista Visibilidad',
			'registrarLista' => 'Registrar Lista Visibilidad',
			'masivoLista' => 'Guardar Masivo Lista Visibilidad',

			'actualizarListaModulacion' => 'Actualizar Lista Modulacion',
			'registrarListaModulacion' => 'Registrar Lista Modulacion',
			'masivoListaModulacion' => 'Guardar Masivo Lista Modulacion',

		];

		$this->carpetaHtml = 'modulos/configuraciones/gestion/trade/visibilidad/vistas_generales/';

		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaElemento',
				'new' => $this->carpetaHtml .  'formNewElemento',
				'update' => $this->carpetaHtml .  'formUpdateElemento',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaElemento'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaVisibilidad',
				'new' => $this->carpetaHtml .  'formNewListaVisibilidad',
				'update' => $this->carpetaHtml .  'formUpdateListaVisibilidad',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaVisibilidad',
			],
			'listaModulacion' => [
				'tabla' => $this->carpetaHtml .  'tablaListaModulacion',
				'new' => $this->carpetaHtml .  'formNewListaModulacion',
				'update' => $this->carpetaHtml .  'formUpdateListaModulacion',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaModulacion',
			],
		];
	}

	public function index()
	{
		$this->aSessTrack = ['idAccion' => 4];

		$config = array();
		$config['css']['style'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/datatables/datatables', 'assets/libs/datatables/responsive.bootstrap4.min', 'assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/trade/visibilidad'
		];

		$config['nav']['menu_active'] = '89';
		$config['data']['icon'] = 'fas fa-share-alt';
		$config['data']['title'] = 'Visibilidad';
		$config['data']['message'] = 'Gestión';
		$config['view'] = 'modulos/configuraciones/gestion/trade/visibilidad/index';

		$this->view($config);
	}

	public function cambiarEstado()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['cambiarEstado'];

		$post = json_decode($this->input->post('data'), true);

		$seccionActivo = $post['seccionActivo'];
		$ids = $post['ids'];
		//print_r($post['estado']);
		$estado = ($post['estado'] == 0) ? 1 : 0;

		switch ($seccionActivo) {
			case 'ListaModulacion':
				$tabla = $this->model->tablas['modulacion']['tabla'];
				$idTabla = $this->model->tablas['modulacion']['id'];
				break;
			case 'Elemento':
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
		if (is_array($ids)) {
			foreach ($ids as $id) {
				$update[] = [
					$idTabla => $id,
					'estado' => $estado,
					'fechaModificacion' => $actualDateTime
				];
			}
		} else {
			$update[] = [
				$idTabla => $ids,
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

		$data = $this->model->getElementosObligatorios($post)->result_array();

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

		$result['msg']['title'] = $this->titulo['registrar' . $post['seccionActivo']];
		$dataParaVista['categoria'] = $this->model->getCategoria()->result_array();

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
		$result['msg']['title'] = $this->titulo['registrar' . $post['seccionActivo']];


		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

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

		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getElementos($post)->row_array();
		$dataParaVista['categoria'] = $this->model->getCategoria()->result_array();

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

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'categoria' => ['selectRequerido']
		];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

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

	public function nuevoElementoMasivo()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html = '';
		$htmlWidth = '60%';

		$input = array();
		$input['idUsuario'] = $this->idUsuario;
		$array = array();

		$rs_categorias = $this->model->obtener_lista_categoria();
		$array['listaCategoriasNombre'] = array();
		foreach ($rs_categorias as $klc => $row) {
			if (!in_array($row['categoria'], $array['listaCategoriasNombre'])) {
				array_push($array['listaCategoriasNombre'], $row['categoria']);
			}
		}
		$html .= $this->load->view("modulos/configuraciones/gestion/trade/visibilidad/elementosNuevoMasivo", $array, true);

		$result['result'] = 1;
		$result['msg']['title'] = 'CARGAR ELEMENTOS VISIBILIDAD MASIVO';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoElementoMasivo()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataElementos = $data->{'dataArray'};
		$htmlWidth = '50%';
		$html = '';
		$htmlInserted = '';
		$htmlInsertedError = '';
		$rowInserted = $rowInsertedError = $rowUpdatedError = 0;

		$input = array();
		$input['idUsuario'] = $this->idUsuario;

		$idProyecto = $this->session->userdata('idProyecto');
		if (!empty($dataElementos)) {
			foreach ($dataElementos as $kde => $row) {
				$idTipoElementoVis = 1;
				$nombreElemento = !empty($row[0]) ? $row[0] : NULL;
				$nombreCategoria = !empty($row[1]) ? $row[1] : NULL;
				$categoria = $this->model->obtener_id_categoria($nombreCategoria);
				$idCategoria = (!empty($categoria) ? $categoria[0]['idCategoria'] : NULL);



				$params = array();
				$params['nombre'] = $nombreElemento;
				$params['idTipoElementoVisibilidad'] = $idTipoElementoVis;
				$params['idCategoria'] = $idCategoria;
				$params['idProyecto'] = $idProyecto;

				$rs_insertarElemento = $this->model->insertar_elemento_visibilidad($params);
				if ($rs_insertarElemento) {
					$rowInserted++;
					$htmlInserted .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ REGISTRAR EL ELEMENTO <strong>' . $params['nombre'] . '</strong> CORRECTAMENTE.</div>';
				} else {
					$rowUpdatedError++;
					$htmlInsertedError .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> HUBO INCONVENIENTES AL REGISTRAR EL ELEMENTO <strong>' . $params['nombre'] . '</strong>.</div>';
				}
			}

			//VALORES REGISTRADOS CORRECTAMENTE
			if ($rowInserted > 0) {
				if ($rowInserted > 5) {
					$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REALIZÓ EL <strong>REGISTRO DE ' . $rowInserted . '</strong> ELEMENTOS DE VISIBILIDAD CORRECTAMENTE.</div>';
				} else {
					$html .= $htmlInserted;
				}
				$result['result'] = 1;
			}

			//VALORES REGISTRADOS INCORRECTAMENTE
			if ($rowInsertedError > 0) {
				if ($rowInsertedError > 5) {
					$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> NO SE LOGRÓ REGISTRAR <strong>' . $rowUpdatedError . '</strong> ELEMENTOS DE VISIBLIDAD CORRECTAMENTE.</div>';
				} else {
					$html .= $htmlInsertedError;
				}
			}
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['msg']['title'] = 'REGISTRAR ELEMENTOS DE VISIBILIDAD MASIVO';
		$result['msg']['content'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	// SECCIÓN LISTA
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

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$params = array();
		$params['id'] = $this->session->userdata('idProyecto');
		$result['msg']['title'] = $this->titulo['registrar' . $post['seccionActivo']];
		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$post['idProyecto'] = $this->session->userdata('idProyecto');
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes($params)->result_array();
		$dataParaVista['lista_elementos'] =  array();


		$arr_canal = array();
		foreach ($dataParaVista['canales'] as $row) {
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']] = $row['nombre'];
		}
		$dataParaVista['grupoCanal_canales'] = $arr_canal;


		// $sl_clientes = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getClientesProyecto()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['clientes'] = $this->model->getClientes($post)->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
	}

	public function getElementoLista()
	{
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
			$html .= "<td><input  readonly='readonly' style='border:none;' class ='form-control' id='elemento_" . $data[$this->model->tablas['elemento']['id']] . "' name='elemento_" . $data[$this->model->tablas['elemento']['id']] . "' value='" . $data['nombre'] . "'></td>";
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
		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post = '';
		//$post['idProyecto'] = $this->session->userdata('idProyecto');
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();

		$params = array();
		$params['idUsuario'] = $this->session->userdata('idUsuario');
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$arr_canal = array();
		foreach ($dataParaVista['canales'] as $row) {
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']] = $row['nombre'];
		}
		$dataParaVista['grupoCanal_canales'] = $arr_canal;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function registrarLista()
	{
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;
		$update = true;
		$insert = true;

		$elementosAValidarSimple = [
			//'canal' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
			//'grupoCanal' => ['selectRequerido'],
		];

		$elementosAValidarMulti = [
			'elemento_lista' => ['selectRequerido']
		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['idProyecto'] = $this->session->userdata('idProyecto');
		$registro = $this->model->registrarLista($post);

		$idLista = $this->db->insert_id();

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['listaDet']['tabla'], $this->model->tablas['listaDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if ($insert == 'repetido') {
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

		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];
		$idLista = $post['idlst'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;
		$update = true;
		$insert = true;

		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
		];
		$elementosAValidarMulti = [
			'elemento_lista' => ['selectRequerido']

		];
		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->actualizarLista($post);

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['listaDet']['tabla'], $this->model->tablas['listaDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');

				if ($insert == 'repetido') {
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

		$post = [];
		$post['idProyecto'] = $this->session->userdata('idProyecto');
		$gruposCanal = $this->model->getGrupoCanales($post)->result_array();
		$canales = $this->model->getCanales($post)->result_array();

		$clientes = $this->model->getClientes()->result_array();
		$elementos = $this->model->getElementos()->result_array();

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
			if (!in_array($row['idElementoVis'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['idElementoVis'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
				[
					'idLista' => null, 'grupoCanal' => null, 'canal' => null, 'idCliente' => null, 'fechaInicio' => null, 'fechaFin' => null
				]
			],
			'headers' => [
				'Id Lista', 'Grupo Canal', 'Canal', 'ID Cliente', 'Fecha Inicio', 'Fecha Fin'
			],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'grupoCanal', 'type' => 'myDropdown_grupoCanal', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown_canal', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'idCliente', 'type' => 'myDropdown', 'placeholder' => 'ID Cliente', 'source' => $clientes],
				['data' => 'fechaInicio', 'type' => 'myDate'],
				['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
		];

		$HT[1] = [
			'nombre' => 'Elemento',
			'data' => [
				[
					'idLista' => null, 'elemento_lista' => null
				]
			],
			'headers' => [
				'Id Lista', 'Id Elemento'
			],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementos, 'strict' => true],

			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'], 1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['lista']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarCargaMasivaLista()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

		$post = json_decode($this->input->post('data'), true);

		$elementos = $post['HT']['1'];

		array_pop($elementos);

		$listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;

		$idCuenta = $this->session->userdata('idCuenta');

		$listasParams['grupos'][0] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' => 'idGrupoCanal'];
		$listasParams['grupos'][1] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' => 'idCanal'];
		//$listasParams['grupos'][3] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
		$listas = $this->getIdsCorrespondientes($listasParams);

		array_pop($listas);

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);

		if (!$listas_unicas) {
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type' => 2, 'message' => 'Asegúrese que todas las listas tengan un ID único'));

			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
		foreach ($listas as $index => $value) {


			$listasInsertadas = [];
			$multiDataRefactorizada = [];

			/*if (empty($value['idGrupoCanal'])) {
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type' => 2, 'message' => 'Debe seleccionar un Grupo Canal.<br> Lista N°: ' . $value['idLista']));
				goto responder;
			}*/
			if (empty($value['fechaInicio'])) {
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type' => 2, 'message' => 'Debe registrar una fecha de Inicio.<br> Lista N°: ' . $value['idLista']));
				goto responder;
			}
			if (!empty($value['fechaFin'])) {
				$fechaInicio = strtotime(str_replace('/', '-', $value['fechaInicio']));
				$fechaFin = strtotime(str_replace('/', '-', $value['fechaFin']));


				if ($fechaFin < $fechaInicio) {
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(array('type' => 2, 'message' => 'La fecha Fin no puede ser menor a la fecha Inicio.<br> Lista N°: ' . $value['idLista']));
					goto responder;
				}
			}
			$value['idProyecto'] = $this->session->userdata('idProyecto');
			$rs = $this->model->registrarLista_HT($value);
			$idLista = $this->db->insert_id();

			if (!$rs) {
				$insertMasivo = false;
				break;
			}

			foreach ($elementos as $row) {

				if ($row['idLista'] == $value['idLista']) {
					$multiDataRefactorizada[] = [
						//'elemento_lista' => $row[$this->model->tablas['elemento']['id']]
						'elemento_lista' => $row['elemento_lista']
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

	//LISTA MODULACION
	public function getTablaListaModulacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListasModulacion($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['listaModulacion']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewListaModulacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrarListaModulacion'];
		$params = array();
		$params['idUsuario'] = $this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$post['idProyecto'] = $this->session->userdata('idProyecto');

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['lista_elementos'] =  array();


		$dataParaVista['tipo_elementos'] =  array();
		foreach ($dataParaVista['elementos'] as $row) {
			$dataParaVista['tipo_elementos'][$row['idTipoElementoVisibilidad']] = $row['tipo'];
		}

		$dataParaVista['elementos_visibilidad'] =  array();
		foreach ($dataParaVista['elementos'] as $row) {
			$dataParaVista['elementos_visibilidad'][$row['idTipoElementoVisibilidad']][$row['idElementoVis']] = $row['nombre'];
		}

		$result['result'] = 1;
		$result['data']['width'] = '80%';
		$result['data']['html'] = $this->load->view($this->html['listaModulacion']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function registrarListaModulacion()
	{
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$total_elemento = count($post) - 3;

		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;
		$update = true;
		$insert = true;

		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido'],
		];

		$elementosAValidarMulti = [
			'elemento_lista' => ['selectRequerido']

		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);
		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->registrarListaModulacion($post);

		$idLista = $this->db->insert_id();

		$elementos_unicos = array();

		if ($total_elemento > 0) {
			for ($i = 1; $i <= $total_elemento; $i++) {
				if (!empty($post['elemento_lista-' . $i])) {
					$elementos_unicos[$post['elemento_lista-' . $i]]['idLista'] = $post['elemento_lista-' . $i];
					$elementos_unicos[$post['elemento_lista-' . $i]]['orden'] = $post['orden_lista-' . $i];
				}
			}
		}

		if (count($elementos_unicos) > 0) {
			foreach ($elementos_unicos as $row) {
				$insert = array(
					'idLista' => $idLista,
					'idElementoVisibilidad' => $row['idLista'],
					'orden' => $row['orden']
				);
				$insert = $this->db->insert("{$this->sessBDCuenta}.trade.master_listaElementosDet", $insert);
			}
		}


		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if ($insert == 'repetido') {
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

	public function getFormUpdateListaModulacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();

		$dataParaVista['data'] = $this->model->getListasModulacion($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementosModulacion($post)->result_array();

		$post = '';

		$dataParaVista['tipo_elementos'] =  array();
		foreach ($dataParaVista['elementos'] as $row) {
			$dataParaVista['tipo_elementos'][$row['idTipoElementoVisibilidad']] = $row['tipo'];
		}

		$dataParaVista['elementos_visibilidad'] =  array();
		foreach ($dataParaVista['elementos'] as $row) {
			$dataParaVista['elementos_visibilidad'][$row['idTipoElementoVisibilidad']][$row['idElementoVis']] = $row['nombre'];
		}

		$result['result'] = 1;
		$result['data']['width'] = '65%';
		$result['data']['html'] = $this->load->view($this->html['listaModulacion']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarListaModulacion()
	{
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar' . $post['seccionActivo']];
		$idLista = $post['idlst'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;
		$update = true;
		$insert = true;

		$elementosAValidarSimple = [
			'fechaInicio' => ['requerido']
		];
		$elementosAValidarMulti = [
			'elemento_lista' => ['selectRequerido']

		];

		$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidarMulti, $multiDataRefactorizada);
		$validacionesMulti = validacionesMultiToSimple($validacionesMulti);

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);


		$result['data']['validaciones'] = $validaciones;
		$result['data']['validacionesMulti'] = $validacionesMulti;


		if (!verificarSeCumplenValidaciones($validacionesMulti) || !verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$registro = $this->model->actualizarListaModulacion($post);

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo("{$this->sessBDCuenta}.trade.master_listaElementosDet", 'idListaDet', $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoListaModulacion($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoListaModulacion($multiDataRefactorizada, $idLista);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}

		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert || $insert === 'repetido') {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
				if ($insert == 'repetido') {
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

	public function getProyectos()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$data3 = $this->model->obtenerCanalCuenta($post)->result_array();

		$post['idUsuario'] = $this->session->userdata('idUsuario');
		$data2 = $this->model->obtenerProyectos($post)->result_array();
		$data = $this->model->getSegCliente($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
		foreach ($data as $row) {
			$html .= '<option value=' . $row['idCliente'] . '>' . $row['razonSocial'] . '</option>';
		}

		$proyecto_unico = false;
		$html2 = "<option value=''>-- Seleccionar --</option>";
		if (count($data2) == 1) {
			$proyecto_unico = true;
			foreach ($data2 as $row) {
				$html2 .= '<option value=' . $row['idProyecto'] . ' SELECTED>' . $row['proyecto'] . '</option>';
			}
		} else {
			foreach ($data2 as $row) {
				$html2 .= '<option value=' . $row['idProyecto'] . '>' . $row['proyecto'] . '</option>';
			}
		}


		$arr_grupoCanal = array();
		foreach ($data3 as $row) {
			$arr_grupoCanal[$row['idGrupoCanal']] = $row['grupoCanal'];
		}
		$html3 = "<option value=''>-- Seleccionar --</option>";
		foreach ($arr_grupoCanal as $id => $row) {
			$html3 .= '<option value=' . $id . '>' . $row . '</option>';
		}

		$arr_canal = array();
		foreach ($data3 as $row) {
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']] = $row['nombre'];
		}

		$result['data']['html'] = $html;
		$result['data']['html2'] = $html2;
		$result['data']['html3'] = $html3;
		$result['data']['proyecto_unico'] = $proyecto_unico;
		$result['data']['grupoCanal'] = $arr_canal;
		$result['result'] = 1;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getSegCliente()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getSegCliente($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
		foreach ($data as $row) {
			$html .= '<option value=' . $row['idCliente'] . '>' . $row['razonSocial'] . '</option>';
		}

		$result['data']['html'] = $html;
		$result['result'] = 1;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormCargaMasivaListaModulacion()
	{
		$result = $this->result;

		$elementos = $this->model->getElementos()->result_array();
		//REFACTORIZANDO DATA
		$elementosRefactorizado = [];
		foreach ($elementos as $row) {
			if (!in_array($row['idElementoVis'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['idElementoVis'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
				[
					'idLista' => null, 'fechaInicio' => null, 'fechaFin' => null
				]
			],
			'headers' => [
				'Id Lista', 'Fecha Inicio', 'Fecha Fin'
			],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'fechaInicio', 'type' => 'myDate'],
				['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
		];

		$HT[1] = [
			'nombre' => 'Elemento',
			'data' => [
				[
					'idLista' => null, 'elemento_lista' => null, 'orden_lista' => null
				]
			],
			'headers' => [
				'Id Lista', 'Id Elemento', 'Orden'
			],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementos],
				['data' => 'orden_lista', 'type' => 'numeric', 'placeholder' => 'Orden', 'width' => 100]

			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'], 1 => $HT[1]['nombre']];

		$result['result'] = 1;
		$result['msg']['title'] = $this->titulo['masivoListaModulacion'];
		$result['data']['htmlWidth'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['listaModulacion']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarCargaMasivaListaModulacion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$dataArray = $post['dataArray'];
		$dataArrayLista = array();

		if (!empty($dataArray)) {
			foreach ($dataArray[0] as $kle => $index) {
				$dataArrayLista[$index[0]]['idLista'] = $index[0];
				$dataArrayLista[$index[0]]['fecIni'] = (!empty($index[1]) ? $index[1] : date('Y-m-d'));
				$dataArrayLista[$index[0]]['fecFin'] = (!empty($index[2]) ? $index[2] : NULL);
				$dataArrayLista[$index[0]]['elementos'] = array();
			}

			foreach ($dataArray[1] as $key => $elemento) {
				if (isset($dataArrayLista[$index[0]]['elementos'])) {
					array_push($dataArrayLista[$elemento[0]]['elementos'], (array('elemento' => $elemento[1], 'orden' => $elemento[2])));
				}
			}

			//INTERMANOS LOS DATOS
			foreach ($dataArrayLista as $key => $cabecera) {
				$arrayCabecera = array();
				if ($cabecera['fecIni'] != null) {

					$arrayCabecera['fecIni'] = $cabecera['fecIni'];
					$arrayCabecera['fecFin'] = $cabecera['fecFin'];
					$arrayCabecera['estado'] = 1;

					$rs_verificarExisitencia = $this->model->verificar_lista_modulacion($arrayCabecera);
					$idListaModulacion = NULL;

					if (!empty($rs_verificarExisitencia)) {
						//EXISTE UN VALOR CON LA CABECERA
						$idListaModulacion = $rs_verificarExisitencia[0]['idLista'];
					} else {
						//NO EXISTE REGISTRO DE ESTA MODULACIÓN
						$rs_registrarLista = $this->model->insertar_lista_modulacion($arrayCabecera);
						if ($rs_registrarLista) {
							//SE REGISTRO CORRECTAMENTE
							$idListaModulacion = $this->db->insert_id();
						}
					}

					//DETALLE DE LOS ELEMENTOS
					foreach ($cabecera['elementos'] as $kle => $elemento) {
						//
						$arrayDetalle = array();
						$arrayDetalle['idLista'] = $idListaModulacion;
						$arrayDetalle['idElementoVisibilidad'] = $elemento['elemento'];
						$arrayDetalle['estado'] = 1;

						$rs_verificarExisitenciaDetalle = $this->model->verificar_lista_modulacion_detalle($arrayDetalle);
						$arrayDetalle['orden'] = $elemento['orden'];

						if (empty($rs_verificarExisitenciaDetalle)) {
							//AGREGAMOS EL ELEMENTO
							$rs_registrarListaDetalle = $this->model->insertar_lista_modulacion_detalle($arrayDetalle);
						}
					}
				}
			}

			$result['result'] = 1;
			$html = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ EL REGISTRO DE LA INFORMACIÓN CORRECTAMENTE.</div>';
		} else {
			$html = $this->htmlNoResultado;
		}

		$result['msg']['title'] = 'REGISTRAR LISTA DE ELEMENTOS DE MODULACIÓN MASIVO';
		$result['msg']['message'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
}
