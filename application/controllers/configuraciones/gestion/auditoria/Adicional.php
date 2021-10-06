<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adicional extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/auditoria/m_adicional', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarElemento' => 'Actualizar Elemento Visibilidad Adicional',
			'registrarElemento' => 'Registrar Elemento Visibilidad Adicional',
			'masivoElemento' => 'Guardar Masivo Elemento Visibilidad Adicional',

			'actualizarLista' => 'Actualizar Lista Visibilidad Adicional',
			'registrarLista' => 'Registrar Lista Visibilidad Adicional',
			'masivoLista' => 'Guardar Masivo Lista Visibilidad Adicional',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/auditoria/vistas_generales/';
        
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
		];
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			// 'assets/libs/dataTables/datatables',
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
			'assets/custom/js/configuraciones/gestion/auditoria/adicional'
		];

		$config['nav']['menu_active']='91';
		$config['data']['icon'] = 'fa fa-eye';
		$config['data']['title'] = 'Visibilidad Auditoria Adicional';
		$config['data']['message'] = 'Gestión';
        $config['view'] = 'modulos/configuraciones/gestion/auditoria/adicional/index';


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
			case 'Lista':
				$tabla = $this->model->tablas['lista']['tabla'];
				$idTabla = $this->model->tablas['lista']['id'];
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
		$dataParaVista['tipos'] = $this->model->getTiposElemento()->result_array();


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
			'nombre' => ['requerido'],
			'tipo' => ['selectRequerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$registro = $this->model->registrarElemento	($post);
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
		$dataParaVista['tipos'] = $this->model->getTiposElemento()->result_array();

		
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
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'tipo' => ['selectRequerido'],
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

	public function nuevoElementoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth = '60%';

		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$array=array();

		$rs_categorias = $this->model->obtener_lista_categoria();
		$array['listaCategoriasNombre'] = array();
		foreach ($rs_categorias as $klc => $row) {
			if ( !in_array($row['categoria'], $array['listaCategoriasNombre'])) {
				array_push($array['listaCategoriasNombre'], $row['categoria']);
			}
		}

		//LISTADO DE LA CUENTA-PROYECTO
		$rs_cuentaProyecto = $this->model->obtener_cuenta_proyecto($input);
		$array['listaProyectosNombre'] = array();
		foreach ($rs_cuentaProyecto as $klcp => $row) {
			if ( !in_array($row['proyecto'], $array['listaProyectosNombre'])) {
				array_push($array['listaProyectosNombre'], $row['proyecto']);
			}
		}

		$html .= $this->load->view("modulos/configuraciones/gestion/auditoria/Adicional/elementosNuevoMasivo", $array, true);

		$result['result'] = 1;
		$result['msg']['title'] = 'CARGAR ELEMENTOS VISIBILIDAD MASIVO';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoElementoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataElementos = $data->{'dataArray'};
		$htmlWidth='50%';
		$html=''; $htmlInserted=''; $htmlInsertedError='';
		$rowInserted=0; $rowInsertedError=0;

		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		if (!empty($dataElementos)) {
			foreach ($dataElementos as $kde => $row) {
				$idTipoElementoVis=3;
				$nombreElemento = !empty($row[0]) ? $row[0] : NULL;
				$nombreCategoria = !empty($row[1]) ? $row[1] : NULL;
					$categoria = $this->model->obtener_id_categoria( $nombreCategoria );
					$idCategoria = ( !empty($categoria) ? $categoria[0]['idCategoria'] : NULL );
				$nombreProyecto = !empty($row[2]) ? $row[2] : NULL;
					$input['proyectoNombre'] = $nombreProyecto;
					$proyecto = $this->model->obtener_cuenta_proyecto( $input );
					$idProyecto = ( !empty($proyecto) ? $proyecto[0]['idProyecto'] : NULL );

				$input=array();
				$input['nombre'] = $nombreElemento;
				$input['idTipoElementoVisibilidad'] = $idTipoElementoVis;
				$input['idCategoria'] = $idCategoria;
				$input['idProyecto'] = $idProyecto;

				$rs_insertarElemento = $this->model->insertar_elemento_visibilidad($input);
				if ($rs_insertarElemento) {
					$rowInserted++;
					$htmlInserted .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ REGISTRAR EL ELEMENTO <strong>'.$input['nombre'].'</strong> CORRECTAMENTE.</div>';
				} else{
					$rowUpdatedError++;
					$htmlInsertedError .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> HUBO INCONVENIENTES AL REGISTRAR EL ELEMENTO <strong>'.$input['nombre'].'</strong>.</div>';
				}
			}

			//VALORES REGISTRADOS CORRECTAMENTE
			if ( $rowInserted>0 ) {
				if ( $rowInserted>5 ) {
					$html.= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REALIZÓ EL <strong>REGISTRO DE '.$rowInserted.'</strong> ELEMENTOS DE VISIBILIDAD CORRECTAMENTE.</div>';
				} else {
					$html.= $htmlInserted;
				}
				$result['result'] = 1;
			}

			//VALORES REGISTRADOS INCORRECTAMENTE
			if ( $rowInsertedError>0) {
				if ( $rowInsertedError>5) {
					$html.= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> NO SE LOGRÓ REGISTRAR <strong>'.$rowUpdatedError.'</strong> ELEMENTOS DE VISIBLIDAD CORRECTAMENTE.</div>';
				} else {
					$html .= $htmlInsertedError;
				}
			}
		} else {
			$html.= $this->htmlNoResultado;
		}
		
		$result['msg']['title'] = 'REGISTRAR ELEMENTOS DE VISIBILIDAD MASIVO';
		$result['msg']['content'] = $html;
		$result['data']['htmlWidth'] =$htmlWidth ;

		$this->aSessTrack = $this->model->aSessTrack;
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

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewLista()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['lista_elementos'] =  array();

		// $sl_clientes = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);
		$result['result'] = 1;
		$result['data']['width'] = '45%';
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

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post='';
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();

		
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
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			'canal' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
			'proyecto' => ['selectRequerido'],
			'grupoCanal' => ['selectRequerido'],
		];

		$elementosAValidarMulti = [
			'elemento_lista'=>['selectRequerido']

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
			'proyecto' => ['requerido'],
			'grupoCanal' => ['requerido'],
		];
		$elementosAValidarMulti = [
			'elemento_lista'=>['selectRequerido']

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

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();

		$gruposCanal = $this->model->getGrupoCanales()->result_array();
        $canales = $this->model->getCanales()->result_array();
        $post = '';
        $proyectos = $this->model->getProyectos($params)->result_array();
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
        
		$proyectosRefactorizado = [];
		foreach ($proyectos as $row) {
			if (!in_array($row['proyecto'], $proyectosRefactorizado)) $proyectosRefactorizado[] = $row['proyecto'];
		}
        $proyectos = !empty($proyectosRefactorizado) ? $proyectosRefactorizado : [' '];
        
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

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
                ['idLista' => null
                , 'grupoCanal' => null
                , 'canal' => null 
                , 'proyecto' => null 
                , 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
			'headers' => ['Id Lista'
				, 'Proyecto'
                , 'Grupo Canal'
                , 'Canal'
                , 'ID Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'proyecto', 'type' => 'myDropdown', 'placeholder' => 'Proyecto', 'source' => $proyectos],
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
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Elemento'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Elemento', 'source' => $elementos],
                
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
		$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elemento']['tabla'], 'idTabla' => $this->model->tablas['elemento']['id']];
        $elementos = $this->getIdsCorrespondientes($elementosParmas);
        
        array_pop($elementos);
		$idCuenta=$this->session->userdata('idCuenta');

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][0] = ['columnas' => ['proyecto'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.proyecto', 'idTabla' => 'idProyecto' , 'extra' => array( 'idCuenta'=> $idCuenta ) ];
		$listasParams['grupos'][1] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' => 'idGrupoCanal'];
		$listasParams['grupos'][2] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
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

            if(empty($value['idProyecto'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Proyecto.<br> Lista N°: '.$value['idLista']));
                goto responder;
            }
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
                        'elemento_lista' => $row[$this->model->tablas['elemento']['id']]
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
	
	public function getProyectos(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data3 = $this->model->obtenerCanalCuenta($post)->result_array();

		$post['idUsuario']=$this->session->userdata('idUsuario');
		$data2 = $this->model->obtenerProyectos($post)->result_array();
		$data = $this->model->getSegCliente($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
			foreach($data as $row){
				$html .= '<option value='.$row['idCliente'].'>'.$row['razonSocial'].'</option>';
			}
		
		$proyecto_unico=false;
		$html2 = "<option value=''>-- Seleccionar --</option>";
		if( count($data2)==1){
			$proyecto_unico=true;
			foreach($data2 as $row){
				$html2 .= '<option value='.$row['idProyecto'].' SELECTED>'.$row['proyecto'].'</option>';
			}
		}else{
			foreach($data2 as $row){
				$html2 .= '<option value='.$row['idProyecto'].'>'.$row['proyecto'].'</option>';
			}
		}
			
			
		$arr_grupoCanal=array();
		foreach($data3 as $row){
			$arr_grupoCanal[$row['idGrupoCanal']]=$row['grupoCanal'];
		}
		$html3 = "<option value=''>-- Seleccionar --</option>";
		foreach($arr_grupoCanal as $id => $row){
			$html3 .= '<option value='.$id.'>'.$row.'</option>';
		}

		$arr_canal=array();
		foreach($data3 as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
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

}
