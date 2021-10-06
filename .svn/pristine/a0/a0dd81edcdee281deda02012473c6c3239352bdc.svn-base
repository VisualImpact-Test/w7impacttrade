<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_productos', 'model');
		$this->load->model('configuraciones/maestros/m_filtros', 'm_filtros');
		$this->load->model('configuraciones/gestion/m_visibilidad', 'm_visibilidad');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarProducto' => 'Actualizar Producto',
			'registrarProducto' => 'Registrar Producto',
			'masivoProducto' => 'Guardar Masivo Producto',

			'actualizarLista' => 'Actualizar Lista Producto',
			'registrarLista' => 'Registrar Lista Producto',
			'masivoLista' => 'Guardar Masivo Lista Producto',

			'registrarPrecio' => 'Registrar Precio',
			'actualizarPrecio' => 'Actualizar Precio',

			'registrarListaPrecio' => 'Registrar Lista Precio',
			'actualizarListaPrecio' => 'Actualizar Lista Precio',

			'registrarMarca' => 'Registrar Marca',
			'actualizarMarca' => 'Actualizar Marca',
			'masivoMarca' => 'Guardar Masivo Marcas',

			'registrarUnidadMedidaProducto' => 'Registrar Producto Unidad Medida',
			'actualizarUnidadMedidaProducto' => 'Actualizar Producto Unidad Medida',
			'masivoUnidadMedidaProducto' => 'Guardar Masivo Producto Unidad Medida',

			'actualizarCategoria' => 'Actualizar Categoría',
			'registrarCategoria' => 'Registrar Categoría',
			'masivoCategoria' => 'Guardar Masivo Categoría',

			'registrarMotivo' => 'Registrar Motivo',
			'actualizarMotivo' => 'Actualizar Motivo',
			'masivoMotivo' => 'Guardar Masivo Motivos',

        ];

        $this->carpetaHtml = 'modulos/configuraciones/gestion/productos/';

		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaProducto',
				'new' => $this->carpetaHtml .  'formNewProducto',
				'update' => $this->carpetaHtml .  'formUpdateProducto',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaProducto'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaProductos',
				'new' => $this->carpetaHtml .  'formNewListaProductos',
				'update' => $this->carpetaHtml .  'formUpdateListaProductos',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaProducto',
				'clientes' =>$this->carpetaHtml. 'sl_clientes'
			],
			'precio' => [
				'tabla' => $this->carpetaHtml .  'tablaPrecio',
				'new' => $this->carpetaHtml .  'formNewPrecio',
				'update' => $this->carpetaHtml .  'formUpdatePrecio',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaPrecio',
			],
			'listaPrecio' => [
				'tabla' => $this->carpetaHtml .  'tablaListaPrecio',
				'new' => $this->carpetaHtml .  'formNewListaPrecio',
				'update' => $this->carpetaHtml .  'formUpdateListaPrecio',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaPrecio',
			],
			'marca' => [
				'tabla' => $this->carpetaHtml .  'tablaMarca',
				'new' => $this->carpetaHtml .  'formNewMarca',
				'update' => $this->carpetaHtml .  'formUpdateMarca',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaProducto',
			],
			'unidadMedidaProducto' => [
				'tabla' => $this->carpetaHtml .  'tablaUnidadMedidaProducto',
				'new' => $this->carpetaHtml .  'formNewUnidadMedidaProducto',
				'update' => $this->carpetaHtml .  'formUpdateUnidadMedidaProducto',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaUnidadMedidaProducto',
			],
			'categoria' => [
				'tabla' => $this->carpetaHtml .  'tablaCategoria',
				'new' => $this->carpetaHtml .  'formNewCategoria',
				'update' => $this->carpetaHtml .  'formUpdateCategoria',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaInteligenciaCompetitiva'
			],
			'motivo' => [
				'tabla' => $this->carpetaHtml .  'tablaMotivo',
				'new' => $this->carpetaHtml .  'formNewMotivo',
				'update' => $this->carpetaHtml .  'formUpdateMotivo',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaMotivo',
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
			'assets/custom/js/configuraciones/gestion/productos'
		];

		$config['nav']['menu_active']='87';
		$config['data']['icon'] = 'fa fa-shopping-cart';
		$config['data']['title'] = 'Productos';
		$config['data']['message'] = 'Checklist Productos';
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
			case 'Producto':
				$tabla = $this->model->tablas['elemento']['tabla'];
				$idTabla = $this->model->tablas['elemento']['id'];
				break;
			case 'Lista':
				$tabla = $this->model->tablas['lista']['tabla'];
				$idTabla = $this->model->tablas['lista']['id'];
				break;
			case 'Precio':
				$tabla = $this->model->tablas['precio']['tabla'];
				$idTabla = $this->model->tablas['precio']['id'];
				break;
			case 'ListaPrecio':
				$tabla = $this->model->tablas['listaPrecio']['tabla'];
				$idTabla = $this->model->tablas['listaPrecio']['id'];
				break;
			case 'Marca':
				$tabla = $this->model->tablas['marca']['tabla'];
				$idTabla = $this->model->tablas['marca']['id'];
				break;
			case 'UnidadMedidaProducto':
				$tabla = $this->model->tablas['unidadMedidaProducto']['tabla'];
				$idTabla = $this->model->tablas['unidadMedidaProducto']['id'];
				break;
			case 'Surtido':
				$tabla = $this->model->tablas['surtido']['tabla'];
				$idTabla = $this->model->tablas['surtido']['id'];
				break;
			case 'Motivo':
				$tabla = $this->model->tablas['motivo']['tabla'];
				$idTabla = $this->model->tablas['motivo']['id'];
				break;
		}

		$update = [];
		$actualDateTime = getActualDateTime();
		foreach ($ids as $id) {
			$update[] = [
				$idTabla => $id,
				'estado' => $estado,
			];
			if(!$seccionActivo=='Marca' && !$seccionActivo=='Motivo' ) $update['fechaModificacion'] =$actualDateTime;
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

	//Seccion Lista Precio
	public function getTablaListaPrecio()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListaPrecios($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['listaPrecio']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = array_merge($this->aSessTrack, $this->model->aSessTrack);
		echo json_encode($result);
	}

	public function getFormNewListaPrecio()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales()->result_array();
		$rs_canal = $this->model->getCanales()->result_array();
 
		$arr_canal=array();
		foreach($rs_canal as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['arr_grupoCanal'] = $arr_canal; 

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaPrecio']['new'], $dataParaVista, true);

		$this->aSessTrack = array_merge($this->aSessTrack, $this->model->aSessTrack);
		echo json_encode($result);
	}
	
	public function registrarListaPrecio()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'grupoCanal' => ['selectRequerido'],
			'valorMin' => ['requerido','numerico'],
			'valorMax' => ['requerido','numerico'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$post['cuenta']=$this->session->userdata('idCuenta');
		$registro = $this->model->registrarListaPrecio($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();
		
		$this->aSessTrack = array_merge($this->aSessTrack, $this->model->aSessTrack);
		echo json_encode($result);
	}

	public function getFormUpdateListaPrecio()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getListaPrecios($post)->row_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['arr_grupoCanal'] = $arr_canal; 

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaPrecio']['update'], $dataParaVista, true);

		$this->aSessTrack = array_merge($this->aSessTrack, $this->model->aSessTrack);
		echo json_encode($result);
	}

	public function actualizarListaPrecio()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'grupoCanal' => ['selectRequerido'],
			'valorMin' => ['requerido','numerico'],
			'valorMax' => ['requerido','numerico'],

		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarListaPrecio($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = array_merge($this->aSessTrack, $this->model->aSessTrack);
		echo json_encode($result);
	}

	//Seccion Precio
	public function getTablaPrecio()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$data = $this->model->getPrecioProductos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['precio']['tabla'], $dataParaVista, true);
		}

		$this->aSessTrack = array_merge($this->aSessTrack, $this->model->aSessTrack);
		echo json_encode($result);
	}

	public function getFormNewPrecio()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$dataParaVista['productos'] = $this->model->getElementos($params)->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['precio']['new'], $dataParaVista, true);

		echo json_encode($result);
	}
	
	public function registrarPrecio()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];


		$elementosAValidar = [
			'producto' => ['requerido'],
			'precioSugerido' => ['requerido','numerico'],
			'precioPromedio' => ['requerido','numerico'],
			'fechaInicio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$registro = $this->model->registrarPrecio($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	public function getFormUpdatePrecio()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$dataParaVista['data'] = $this->model->getPrecioProductos($params)->row_array();
		$dataParaVista['productos'] = $this->model->getElementos($params)->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['precio']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarPrecio()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'producto' => ['requerido'],
			'precioSugerido' => ['requerido','numerico'],
			'precioPromedio' => ['requerido','numerico'],
			'fechaInicio' => ['requerido'],

		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarPrecio($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	//Seccion Marca
	public function getTablaMarca()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);


		$data = $this->model->getMarcas($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['marca']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewMarca()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista=array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['marca']['new'], $dataParaVista, true);

		echo json_encode($result);
	}
	
	public function registrarMarca()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$idCuenta=$this->session->userdata('idCuenta');

		$elementosAValidar = [
			'marca' => ['requerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		
		if ($this->model->checkNombreMarcaRepetido($post)) $validaciones['marca'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['cuenta']=$idCuenta;
		$registro = $this->model->registrarMarca($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	public function getFormUpdateMarca()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$dataParaVista['data'] = $this->model->getMarcas($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['marca']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarMarca()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'marca' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreMarcaRepetido($post)) $validaciones['marca'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarMarca($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	public function getMarcas(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getMarcasCuenta($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
			foreach($data as $row){
				$html .= '<option value='.$row['idMarca'].'>'.$row['nombre'].'</option>';
			}

		$result['data']['html'] = $html; 
		$result['result'] = 1;

		echo json_encode($result);
	}

	// SECCION ELEMENTOS
	public function getTablaProducto()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$post['cuenta']= $this->sessIdCuenta;
		;
		
		$data = $this->model->getElementos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['elemento']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewProducto()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['marcas'] = $this->model->getMarcas($params)->result_array();
		$dataParaVista['categorias'] = $this->model->getCategorias()->result_array();
		$dataParaVista['envases'] = $this->model->getEnvases()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['new'], $dataParaVista, true);

		echo json_encode($result);
    }

    public function registrarProducto()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'marca' => ['requerido'],
			// 'envase' => ['requerido'],
			'categoria' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreElementoRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		$post['cuenta']=$this->session->userdata('idCuenta');
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
		echo json_encode($result);
	}

	public function getFormUpdateProducto()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['data'] = $this->model->getElementos($post)->row_array();
		$dataParaVista['marcas'] = $this->model->getMarcasCuenta($dataParaVista['data'])->result_array();
		$dataParaVista['categorias'] = $this->model->getCategorias()->result_array();
		$dataParaVista['envases'] = $this->model->getEnvases()->result_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarProducto()
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
		echo json_encode($result);
	}

	public function getTablaLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListas($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
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
		
		if( empty($post['cuenta']) ){
			$post['cuenta']=$this->session->userdata('idCuenta');
		}

		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['elementos'] = $this->model->getElementos($post)->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas($post)->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();
		$dataParaVista['canales'] = $this->m_filtros->getCanales($post)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes($post)->result_array();
		$dataParaVista['lista_elementos'] =  array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;

		$class="formNewLista";
		$dataParaVista['class'] =  $class;
		$result['result'] = 1;
		$result['data']['width'] = '60%';
		$result['data']['html'] = $this->load->view($this->html['lista']['new'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function getClientesProyecto(){
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$dataParaVista['clientes'] = $this->model->getClientes($post)->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);

	}

	public function getElementoLista(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getElementos($post)->row_array();
		$marca = $this->model->getMarcas($post)->row_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$html = "";
			$html .= "<tr id='fila_temporal_encuesta'>";
				$html .= "<td ><i class='fas fa-trash' id='eliminar_encuesta'></i></td>";
				$html .= "<td><input  readonly='readonly' style='border:none;' class ='form-control' id='elemento_".$data[$this->model->tablas['elemento']['id']]."' name='elemento_".$data[$this->model->tablas['elemento']['id']]."' value='".$data['nombre']."'></td>";
			$html .= "</tr>";
			$result['data']['html'] = $html;
		}

		echo json_encode($result);
	}

	public function getElementos(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getElementosProyecto($post)->result();

		$result['result'] = 1;
		if (count($data) <0) {
			$result['data']['elementos'] = array();
		} else {
			$result['data']['elementos'] = $data;
		}

		echo json_encode($result);
	}

	public function getFormUpdateLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$params=array();
		if( empty($post['cuenta']) ){
			$params['cuenta']=$this->session->userdata('idCuenta');
		}else{
			$params['cuenta']=$post['cuenta'];
		}

		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales()->result_array();
		$dataParaVista['elementos'] = $this->model->getElementos($params)->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas($params)->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();
		if(!empty($dataParaVista['data']['idCanal'])) $dataParaVista['clientes'] = $this->model->getSegCliente($dataParaVista['data'])->result_array();

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$dataParaVista['canales'] = $this->m_filtros->getCanales()->result_array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['update'], $dataParaVista, true);

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
			'grupoCanal' => ['requerido'],
			'fechaInicio' => ['requerido'],
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
		$post['proyecto']=$this->session->userdata('idProyecto');
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
		echo json_encode($result);
	}

	public function getProyectos(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data3 = $this->model->obtenerCanalCuenta($post)->result_array();
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
		$result['data']['grupoCanal'] = $arr_canal; 
		$result['result'] = 1;

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
			'canal' => ['requerido'],
			'fechaInicio' => ['requerido']
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
		$post['proyecto']=$this->session->userdata('idProyecto');
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
		echo json_encode($result);
	}

	public function getFormCargaMasivaLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

		$cadenas = $this->model->getCadenas()->result_array();
		$banners = $this->model->getBanners()->result_array();
        $canales = $this->model->getCanales()->result_array();
		$gruposCanal = $this->model->getGrupoCanales()->result_array();

		$post = '';
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
        $clientes = $this->model->getClientes($params)->result_array();
        $elementos = $this->model->getElementos($params)->result_array();

		//REFACTORIZANDO DATA
		$cadenasRefactorizado = [];
		foreach ($cadenas as $row) {
			if (!in_array($row['nombre'], $cadenasRefactorizado)) $cadenasRefactorizado[] = $row['nombre'];
		}
		$cadenas = !empty($cadenasRefactorizado) ? $cadenasRefactorizado : [' '];
		
		$dataRefac = [];
		foreach ($gruposCanal as $row) {
			if (!in_array($row['nombre'], $dataRefac)) $dataRefac[] = $row['nombre'];
		}
        $gruposCanal = !empty($dataRefac) ? $dataRefac : [' '];

		$bannerRefactorizado = [];
		foreach ($banners as $row) {
			if (!in_array($row['nombre'], $bannerRefactorizado)) $bannerRefactorizado[] = $row['nombre'];
		}
        $banners = !empty($bannerRefactorizado) ? $bannerRefactorizado : [' '];
        
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

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
                ['idLista' => null
				, 'grupoCanal' => null 
				, 'canal' => null 
                , 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
            'headers' => ['Id Lista'
				, 'Grupo Canal'
				, 'Canal'
                , 'ID Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
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
			'nombre' => 'Productos',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Productos'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Producto', 'source' => $elementos, 'width' => 400],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['lista']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

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
		$listasParams['grupos'][0] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		$listasParams['grupos'][1] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' =>'idGrupoCanal'];
		
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);

		if(!$listas_unicas){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que todas las listas tengan un ID único'));
			goto respuesta;
		}
		$insertMasivo  = true;
		$fila = 1;

		$idProyecto=$this->session->userdata('idProyecto');

        foreach($listas as $index => $value){

			$listasInsertadas = [];
			$multiDataRefactorizada = [] ;

			$value['idProyecto']=$idProyecto;
			if(empty($value['idGrupoCanal'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Grupo Canal.<br> Fila N°: '.($index + 1) ));
				goto respuesta;
			}
            if(empty($value['fechaInicio'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe registrar una fecha de Inicio.<br> Lista N°: '.$value['idLista']));
		        goto respuesta;
            }
            if(!empty($value['fechaFin'])){
                $fechaInicio = strtotime(str_replace('/','-',$value['fechaInicio']));
                $fechaFin = strtotime(str_replace('/','-',$value['fechaFin']));

                if($fechaFin < $fechaInicio){
                    $result['result'] = 0;
                    $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'La fecha Fin no puede ser menor a la fecha Inicio.<br> Lista N°: '.$value['idLista']));
                    goto respuesta;
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

		$this->db->trans_complete();
		respuesta:
		echo json_encode($result);
	}

	public function getFormCargaMasivaMarca()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoMarca'];
		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');

		$post = '';
		
		//REFACTORIZANDO DATA
		
		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Marcas',
			'data' => [
				['nombre' => null
                ]
			],
            'headers' => ['Marca'
            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'Marca', 'width' => 300],
			],
			'colWidths' => 500,
        ];
        
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['marca']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaMarca(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoMarca'];

        $post = json_decode($this->input->post('data'), true);

        $elementos = $post['HT']['0'];
		$elementosParams['tablaHT'] = $elementos;

		array_pop($elementos);

		$elementos_unicos = $this->model->validar_elementos_unicos_HT($elementos);

		$idCuenta=$this->session->userdata('idCuenta');
		if(!$elementos_unicos){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que los elementos no se repiten'));
			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;
        foreach($elementos as $index => $value){
			$multiDataRefactorizada[] = [
				'nombre' => trim($value['nombre']),
				'idCuenta' =>  $idCuenta,
			];

			$fila++;
		}

		$masivo = $this->model->registrar_marcas_HT($multiDataRefactorizada);

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

	public function getProductos()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$rs_productos = $this->model->getElementos($post)->result_array();

		$html2 = "<option value=''>-- Seleccionar --</option>";
		foreach($rs_productos as $row){
			$html2 .= '<option value='.$row['idProducto'].'>'.$row['nombre'].'</option>';
		}

		$result['result'] = 1;
		$result['data']['productos'] = $html2;

		echo json_encode($result);
	}
	

	public function getFormCargaMasivaProducto()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoProducto'];

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$categorias = $this->model->getCategorias($params)->result_array();
		$marcas = $this->model->getMarcas($params)->result_array();
		$envases = $this->model->getEnvases()->result_array();
		

		//REFACTORIZANDO DATA
		$categoriasRefactorizado = [];
		foreach ($categorias as $row) {
			if (!in_array($row['nombre'], $categoriasRefactorizado)) $categoriasRefactorizado[] = $row['nombre'];
		}
        $categorias = !empty($categoriasRefactorizado) ? $categoriasRefactorizado : [' '];
		
		$marcaRefactorizado = [];
		foreach ($marcas as $row) {
			if (!in_array($row['nombre'], $marcaRefactorizado)) $marcaRefactorizado[] = $row['nombre'];
		}
        $marcas = !empty($marcaRefactorizado) ? $marcaRefactorizado : [' '];
        
		$envasesRefactorizado = [];
		foreach ($envases as $row) {
			if (!in_array($row['descripcion'], $envasesRefactorizado)) $envasesRefactorizado[] = $row['descripcion'];
		}
        $envases = !empty($envasesRefactorizado) ? $envasesRefactorizado : [' '];

		$flag = [
			0=>'SI',
			1=>'NO',
		];
		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Productos',
			'data' => [
                [ 'nombre' => null 
                , 'nombreCorto' => null
                , 'ean' => null 
				, 'flagCompetencia' => null
				, 'categoria' => null 
                , 'marca' => null 
                ]
			],
            'headers' => [
			  'Nombre Producto (*)'
			, 'Nombre Corto'
			, 'Ean'
			, 'Competencia'
			, 'Categoria (*)'
			, 'Marca (*)'
            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'Nombre' ],
				['data' => 'nombreCorto', 'type' => 'text', 'placeholder' => 'Nombre Corto' ],
				['data' => 'ean', 'type' => 'text', 'placeholder' => 'ean' ],
				['data' => 'flagCompetencia', 'type' => 'myDropdown', 'placeholder' => 'Competencia' , 'source' => $flag],
				['data' => 'categoria', 'type' => 'myDropdown', 'placeholder' => 'Categoria', 'source' => $categorias],
				['data' => 'marca', 'type' => 'myDropdown', 'placeholder' => 'Marca', 'source' => $marcas],
			],
			'colWidths' => 200,
        ];
         

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'] ];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaProducto(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoProducto'];

        $post = json_decode($this->input->post('data'), true);

        $elementos = $post['HT']['0'];
        $listasParams['tablaHT'] = $elementos;
		$listasParams['grupos'][3] = ['columnas' => ['categoria'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.producto_categoria', 'idTabla' =>'idCategoria'];
		$listasParams['grupos'][4] = ['columnas' => ['marca'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.producto_marca', 'idTabla' =>'idMarca'];
        $elementos = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($elementos);

	
		$idCuenta=$this->session->userdata('idCuenta');
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;
        foreach($elementos as $index => $value){

			if(empty($value['idCategoria'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar una categoría. <br> Fila: '.($index+1)));
				goto responder;
			}
			if(empty($value['idMarca'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar una marca. <br> Fila: '.($index+1)));
				goto responder;
			}
			if(empty($value['nombre'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'El nombre del producto no puede estar vacío. <br> Fila: '.($index+1)));
				goto responder;
			}

			$multiDataRefactorizada[] = [
				'idCuenta' => $idCuenta,
				'idCategoria' => trim($value['idCategoria']),
				'idMarca' => trim($value['idMarca']),
				'nombre' => trim($value['nombre']),
				'nombreCorto' => !empty($value['nombreCorto']) ? trim($value['nombreCorto']): '',
				'ean' => !empty($value['ean']) ? trim($value['ean']) : NULL,
				'flagCompetencia' => !empty($value['flagCompetencia']) && $value['flagCompetencia']  == "SI"? 1 : 0,
			
			];
			$fila++;
		}

		$masivo = $this->model->registrar_elementos_HT($multiDataRefactorizada);

		if(!$masivo){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 0,'message'=>'No se pudo Completar la operación'));
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = createMessage(array('type'=> 1,'message'=>'Se completó la operacion Correctamente'));
		}

		$this->db->trans_complete();
		responder:
		echo json_encode($result);
	}

	public function getTablaUnidadMedidaProducto()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getUnidadMedidaProducto($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['unidadMedidaProducto']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewUnidadMedidaProducto()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$dataParaVista['productos'] = $this->model->getElementos($params)->result_array();
		$dataParaVista['unidadMedidas'] = $this->model->getUnidadMedida()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['unidadMedidaProducto']['new'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function getFormUpdateUnidadMedidaProducto()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');

		$dataParaVista['productos'] = $this->model->getElementos($params)->result_array();
		$dataParaVista['unidadMedidas'] = $this->model->getUnidadMedida()->result_array();

		$dataParaVista['data'] = $this->model->getUnidadMedidaProducto($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['unidadMedidaProducto']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarUnidadMedidaProducto()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$elementosAValidar = [
			'producto' => ['requerido'],
			'unidadMedida' => ['requerido'],
			'precio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		
		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$registro = $this->model->registrarUnidadMedidaProducto($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	public function actualizarUnidadMedidaProducto()
	{
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'producto' => ['requerido'],
			'unidadMedida' => ['requerido'],
			'precio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarUnidadMedidaProducto($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	public function getFormCargaMasivaUnidadMedidaProducto()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoUnidadMedidaProducto'];

		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$productos = $this->model->getElementos($params)->result_array();
		$unidadMedidas = $this->model->getUnidadMedida()->result_array();

		$post = '';
		
		//REFACTORIZANDO DATA
		$productosRefactorizado = [];
		foreach ($productos as $row) {
			if (!in_array($row['idProducto'], $productosRefactorizado)) $productosRefactorizado[] = $row['idProducto'];
		}
		$productos = !empty($productosRefactorizado) ? $productosRefactorizado : [' '];
		
		$unidadMedidasRefactorizado = [];
		foreach ($unidadMedidas as $row) {
			if (!in_array($row['nombre'], $unidadMedidasRefactorizado)) $unidadMedidasRefactorizado[] = $row['nombre'];
		}
		$unidadMedidas = !empty($unidadMedidasRefactorizado) ? $unidadMedidasRefactorizado : [' '];


		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Unidad Medida Productos',
			'data' => [
				['idProducto' => null,
				'unidadMedida'=> null,
				'precio'=> null
                ]
			],
            'headers' => ['ID Producto','Unidad Medida','Precio'
            ],
			'columns' => [
				['data' => 'idProducto', 'type' => 'myDropdown', 'placeholder' => 'ID Producto', 'source' => $productos ,"strict"=>true ],
				['data' => 'unidadMedida', 'type' => 'myDropdown', 'placeholder' => 'Unidad Medida', 'source' => $unidadMedidas],
				['data' => 'precio', 'type' => 'text', 'placeholder' => 'Precio', 'width' => 200],

			],
			'colWidths' => 200,
        ];
        
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['unidadMedidaProducto']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaUnidadMedidaProducto(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoUnidadMedidaProducto'];

        $post = json_decode($this->input->post('data'), true);

		$elementosParams=array();
		$elementos = $post['HT']['0'];
		$elementosParams['tablaHT'] = $elementos;
		$elementosParams['grupos'][1] = ['columnas' => ['unidadMedida'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.unidadMedida', 'idTabla' => 'idUnidadMedida'];

		$elementos = $this->getIdsCorrespondientes($elementosParams);
		array_pop($elementos);

		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;
        foreach($elementos as $index => $value){

			
			$multiDataRefactorizada[] = [
				'idProducto' => trim($value['idProducto']),
				'idUnidadMedida' => trim($value['idUnidadMedida']),
				'precio' => trim($value['precio']),
				'fechaCreacion' => getActualDateTime(),
			];

			$fila++;
		}

		$masivo = $this->model->registrarUnidadMedidaProductoHT($multiDataRefactorizada);

		if(!$masivo){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 0,'message'=>'No se pudo Completar la operación'));
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = createMessage(array('type'=> 1,'message'=>'Se completó la operacion Correctamente'));
		}

		$this->db->trans_complete();
		echo json_encode($result);
	}
	public function getTablaSurtido()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		
		$data = $this->model->getSurtidos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/productos/tablaSurtido', $dataParaVista, true);
		}

		echo json_encode($result);
	}
	public function getFormNewSurtido()
	{
		$result = $this->result;
		$post= json_decode($this->input->post('data'), true);

		$result['msg']['title'] = 'Registrar Lista Surtido';
		
		if( empty($post['cuenta']) ){
			$post['cuenta']=$this->session->userdata('idCuenta');
		}

		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['elementos'] = $this->model->getElementos($post)->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas($post)->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();
		$dataParaVista['canales'] = $this->m_filtros->getCanales($post)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes($post)->result_array();
		$dataParaVista['lista_elementos'] =  array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;

		$class="formNewLista";
		$dataParaVista['class'] =  $class;
		$result['result'] = 1;
		$result['data']['width'] = '60%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/productos/formNewListaSurtido', $dataParaVista, true);

		echo json_encode($result);
	}
	public function registrarSurtido()
	{
		$this->db->trans_start();
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Registrar Lista Surtido';

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			'grupoCanal' => ['requerido'],
			'fechaInicio' => ['requerido'],
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
		$post['proyecto']=$this->session->userdata('idProyecto');
		$registro = $this->model->registrarListaSurtido($post);

		$idLista = $this->db->insert_id();

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['surtidoDet']['tabla'], $this->model->tablas['surtidoDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoListaSurtido($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoListaSurtido($multiDataRefactorizada, $idLista);

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
		echo json_encode($result);
	}
	public function getFormUpdateSurtido()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Actualizar Lista Surtido';

		$params=array();
		if( empty($post['cuenta']) ){
			$params['cuenta']=$this->session->userdata('idCuenta');
		}else{
			$params['cuenta']=$post['cuenta'];
		}

		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales()->result_array();
		$dataParaVista['elementos'] = $this->model->getElementos($params)->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas($params)->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();
		if(!empty($dataParaVista['data']['idCanal'])) $dataParaVista['clientes'] = $this->model->getSegCliente($dataParaVista['data'])->result_array();

		$dataParaVista['data'] = $this->model->getSurtidos($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getSurtidoElementos($post)->result_array();

		$dataParaVista['canales'] = $this->m_filtros->getCanales()->result_array();

		$arr_canal=array();
		foreach($dataParaVista['canales'] as $row){
			$arr_canal[$row['idGrupoCanal']][$row['idCanal']]=$row['nombre'];
		}
		$dataParaVista['grupoCanal_canales']=$arr_canal;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/productos/formUpdateListaSurtido', $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarSurtido()
	{
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Actualizar Lista Surtido';
		$idLista = $post['idlst'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			'grupoCanal' => ['requerido'],
			'fechaInicio' => ['requerido']
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
		$post['proyecto']=$this->session->userdata('idProyecto');
		$registro = $this->model->actualizarLista($post);

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['surtidoDet']['tabla'], $this->model->tablas['surtidoDet']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoListaSurtido($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoListaSurtido($multiDataRefactorizada, $idLista);

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
		echo json_encode($result);
	}
	public function getFormCargaMasivaSurtido()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Carga masiva Lista Surtidos';

		$cadenas = $this->model->getCadenas()->result_array();
		$banners = $this->model->getBanners()->result_array();
        $canales = $this->model->getCanales()->result_array();
		$gruposCanal = $this->model->getGrupoCanales()->result_array();
		$post = '';
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
        $clientes = $this->model->getClientes($params)->result_array();
        $elementos = $this->model->getElementos($params)->result_array();

		//REFACTORIZANDO DATA
		$cadenasRefactorizado = [];
		foreach ($cadenas as $row) {
			if (!in_array($row['nombre'], $cadenasRefactorizado)) $cadenasRefactorizado[] = $row['nombre'];
		}
		$cadenas = !empty($cadenasRefactorizado) ? $cadenasRefactorizado : [' '];
		
		$dataRefac = [];
		foreach ($gruposCanal as $row) {
			if (!in_array($row['nombre'], $dataRefac)) $dataRefac[] = $row['nombre'];
		}
        $gruposCanal = !empty($dataRefac) ? $dataRefac : [' '];
        
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

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
                ['idLista' => null
                , 'cadena' => null
				, 'grupoCanal' => null
				, 'canal' => null 
                , 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
            'headers' => ['Id Lista'
				, 'Grupo Canal'
				, 'Canal'
                , 'ID Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
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
			'nombre' => 'Productos',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'Productos'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Producto', 'source' => $elementos, 'width' => 400],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['lista']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
    }

	public function guardarCargaMasivaSurtido(){
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
		$listasParams['grupos'][0] = ['columnas' => ['cadena'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.cadena', 'idTabla' => 'idCadena'];
		$listasParams['grupos'][1] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' =>'idGrupoCanal'];
		$listasParams['grupos'][2] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);

		if(!$listas_unicas){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que todas las listas tengan un ID único'));
			goto respuesta;
		}
		$insertMasivo  = true;
		$fila = 1;

		$idProyecto=$this->session->userdata('idProyecto');

        foreach($listas as $index => $value){

			$listasInsertadas = [];
			$multiDataRefactorizada = [] ;

			$value['idProyecto']=$idProyecto;
            if(empty($value['fechaInicio'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe registrar una fecha de Inicio.<br> Lista N°: '.$value['idLista']));
		        goto respuesta;
            }
            if(!empty($value['fechaFin'])){
                $fechaInicio = strtotime(str_replace('/','-',$value['fechaInicio']));
                $fechaFin = strtotime(str_replace('/','-',$value['fechaFin']));

                if($fechaFin < $fechaInicio){
                    $result['result'] = 0;
                    $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'La fecha Fin no puede ser menor a la fecha Inicio.<br> Lista N°: '.$value['idLista']));
                    goto respuesta;
                }
            }

            $rs = $this->model->registrarListaSurtido_HT($value);
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
            $insert = $this->model->guardarMasivoListaSurtido($multiDataRefactorizada, $idLista);
			
		}
		if (!$insertMasivo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
		}

		$this->db->trans_complete();
		respuesta:
		echo json_encode($result);
	}

	public function getTablaCategoria()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getElementoCategorias($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['categoria']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewCategoria()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista = array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['categoria']['new'], $dataParaVista, true);

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

		if ($this->model->checkNombreCategoriaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$registro = $this->model->registrarCategoria($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();

		echo json_encode($result);
	}
	
	public function getFormUpdateCategoria()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getElementoCategorias($post)->row_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['categoria']['update'], $dataParaVista, true);

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

		if ($this->model->checkNombreCategoriaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarCategoria($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();

		echo json_encode($result);
	}
	public function getFormCargaMasivaCategoria()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoCategoria'];

        $post = '';

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Categorías',
			'data' => [
                ['categoria' => null
                ]
			],
            'headers' => ['Categorías'
            ],
			'columns' => [
				['data' => 'categoria', 'type' => 'text', 'placeholder' => 'Categoría', 'width' => 300],
			],
			'colWidths' => 200,
        ];
        
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarCargaMasivaCategoria(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoCategoria'];

        $post = json_decode($this->input->post('data'), true);
        

        $elementos = $post['HT']['0'];
		$elementosParams['tablaHT'] = $elementos;
        
        
		array_pop($elementos);

		$elementos_unicos = $this->model->validar_categorias_unicas_HT($elementos);

		if(!$elementos_unicos){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que los elementos no se repitan'));
			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;
        foreach($elementos as $index => $value){

			
			$multiDataRefactorizada[] = [
				'nombre' => trim($value['categoria']),
			];

			$fila++;
		}

		$masivo = $this->model->registrar_categoria_HT($multiDataRefactorizada);

		if(!$masivo){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 0,'message'=>'No se pudo Completar la operación'));
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = createMessage(array('type'=> 1,'message'=>'Se completó la operacion Correctamente'));
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }


	//Seccion Motivo
	public function getTablaMotivo()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);


		$data = $this->model->getMotivos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['motivo']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewMotivo()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista=array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['motivo']['new'], $dataParaVista, true);

		echo json_encode($result);
	}
	
	public function registrarMotivo()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];

		$idCuenta=$this->session->userdata('idCuenta');

		$elementosAValidar = [
			'motivo' => ['requerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		
		$post['cuenta']=$idCuenta;
		if ($this->model->checkNombreMotivoRepetido($post)) $validaciones['motivo'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}
		
		$registro = $this->model->registrarMotivo($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

	public function getFormUpdateMotivo()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];
		$dataParaVista['data'] = $this->model->getMotivos($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['motivo']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarMotivo()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'motivo' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		$idCuenta=$this->session->userdata('idCuenta');
		$post['cuenta']=$idCuenta;
		if ($this->model->checkNombreMotivoRepetido($post)) $validaciones['motivo'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$actualizo = $this->model->actualizarMotivo($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();
		echo json_encode($result);
	}

}
