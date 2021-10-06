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
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaProductos',
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
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaProductos',
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
			'assets/custom/js/configuraciones/gestion/productos'
		];

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

	//Seccion Lista Precio
	public function getTablaListaPrecio()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getListaPrecios($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['listaPrecio']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}
	public function getFormNewListaPrecio()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaPrecio']['new'], $dataParaVista, true);

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
			goto respuesta;
		}

		$registro = $this->model->registrarListaPrecio($post);
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
	public function getFormUpdateListaPrecio()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getListaPrecios($post)->row_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['listaPrecio']['update'], $dataParaVista, true);

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
			goto respuesta;
		}

		$actualizo = $this->model->actualizarListaPrecio($post);

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
	//Seccion Precio
	public function getTablaPrecio()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getPrecioProductos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['precio']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}
	public function getFormNewPrecio()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['productos'] = $this->model->getElementos()->result_array();


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
			goto respuesta;
		}

		$registro = $this->model->registrarPrecio($post);
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

	public function getFormUpdatePrecio()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getPrecioProductos($post)->row_array();
		$dataParaVista['productos'] = $this->model->getElementos()->result_array();

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
			goto respuesta;
		}

		$actualizo = $this->model->actualizarPrecio($post);

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
	//Seccion Marca
	public function getTablaMarca()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getPrecioProductos($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view($this->html['precio']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}
	public function getFormNewMarca()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['productos'] = $this->model->getElementos()->result_array();


		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['precio']['new'], $dataParaVista, true);

		echo json_encode($result);
	}
	
	public function registrarMarca()
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
			goto respuesta;
		}

		$registro = $this->model->registrarPrecio($post);
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

	public function getFormUpdateMarca()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getPrecioProductos($post)->row_array();
		$dataParaVista['productos'] = $this->model->getElementos()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['precio']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarMarca()
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
			goto respuesta;
		}

		$actualizo = $this->model->actualizarPrecio($post);

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
	// SECCION ELEMENTOS
	public function getTablaProducto()
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

    public function getFormNewProducto()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['cuentas'] = $this->m_visibilidad->getCuentas()->result_array();
		$dataParaVista['marcas'] = $this->m_visibilidad->getMarcas()->result_array();
		$dataParaVista['categorias'] = $this->m_visibilidad->getElementos()->result_array();
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
			'cuenta' => ['requerido'],
			'marca' => ['requerido'],
			'categoria' => ['requerido'],
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

	public function getFormUpdateProducto()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['data'] = $this->model->getElementos($post)->row_array();
		$dataParaVista['cuentas'] = $this->m_visibilidad->getCuentas()->result_array();
		$dataParaVista['marcas'] = $this->m_visibilidad->getMarcas()->result_array();
		$dataParaVista['categorias'] = $this->m_visibilidad->getElementos()->result_array();
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

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas()->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();
		$dataParaVista['canales'] = $this->m_filtros->getCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->m_filtros->getProyectos($post)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['lista_elementos'] =  array();

		// $sl_clientes = $this->load->view($this->html['lista']['clientes'], $dataParaVista, true);
		$result['result'] = 1;
		$result['data']['width'] = '45%';
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

		echo json_encode($result);
	}

	public function getFormUpdateLista()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['marcas'] = $this->model->getMarcas()->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();

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
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;

		$elementosAValidarSimple = [
			'canal' => ['requerido'],
			'fechaInicio' => ['requerido'],
			'proyecto' => ['requerido'],
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
			goto respuesta;
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
		$idLista = $post['idlst'];

		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;$update = true;$insert = true;
		
		$elementosAValidarSimple = [
			'canal' => ['requerido'],
			'fechaInicio' => ['requerido'],
			'proyecto' => ['requerido'],
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
			goto respuesta;
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

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	
}
