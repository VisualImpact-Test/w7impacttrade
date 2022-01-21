<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archivo extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_archivo', 'model');
		$this->load->model('configuraciones/maestros/m_filtros', 'm_filtros');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarPromocion' => 'Actualizar Archivo',
			'registrarPromocion' => 'Registrar Archivo',
			'masivoPromocion' => 'Guardar Masivo Archivo',

			'actualizarLista' => 'Actualizar Lista Archivo',
			'registrarLista' => 'Registrar Lista Archivo',
			'masivoLista' => 'Guardar Masivo Lista Archivo',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/archivo/';

		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaArchivo',
				'new' => $this->carpetaHtml .  'formNewArchivo',
				'update' => $this->carpetaHtml .  'formUpdateArchivo',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaArchivo'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaArchivo',
				'new' => $this->carpetaHtml .  'formNewListaArchivo',
				'update' => $this->carpetaHtml .  'formUpdateListaArchivo',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaArchivo'
			],
		];
	}

	public function index()
	{
		$config = array();
		$config['css']['style'] = [
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
			'assets/custom/js/configuraciones/gestion/archivo'
		];

		$config['nav']['menu_active']='96';
		$config['data']['icon'] = 'fa fa-gift';
		$config['data']['title'] = 'Archivo';
		$config['data']['message'] = 'Módulo Archivo';
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

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');

		$cuentas = $this->model->getCuentas($params)->result_array();

		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();
		$dataParaVista['proyectos'] = $this->m_filtros->getProyectos($post)->result_array();
		$dataParaVista['lista_elementos'] = array();
		// $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
		// $dataParaVista['grupoCanales'] = $this->m_filtros->getGrupoCanales()->result_array();
		// $dataParaVista['clientes'] = $this->model->getClientes()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['new'], $dataParaVista, true);

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

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();

		$post='';
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
			'nombre' => ['requerido'],
			'proyecto' => ['selectRequerido'],
		];

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);

		$result['data']['validaciones'] = $validaciones; 

		if ( !verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		$registro = $this->model->registrarLista($post);

		$idLista = $this->db->insert_id();

		//BORRAR
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
			'nombre' => ['requerido'],
			'proyecto' => ['requerido']
		];

		$validaciones = verificarValidacionesBasicas($elementosAValidarSimple, $post);

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones) ) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		$registro = $this->model->actualizarLista($post);

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

	public function getFormCargaMasivaLista()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoLista'];

        $post = '';
        $proyectos = $this->model->getProyectos($post)->result_array();
		
		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$cuentas = $this->model->getCuentas($params)->result_array();

		//REFACTORIZANDO DATA
		$proyectosRefactorizado = [];
		foreach ($proyectos as $row) {
			if (!in_array($row['nombre'], $proyectosRefactorizado)) $proyectosRefactorizado[] = $row['nombre'];
		}
		$proyectos = !empty($proyectosRefactorizado) ? $proyectosRefactorizado : [' '];
		
		$cuentasRefactorizado = [];
		foreach ($cuentas as $row) {
			if (!in_array($row['nombre'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['nombre'];
		}
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];
         

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
                [ 
				'cuenta' => null 
				, 'proyecto' => null 	
				,  'nombre' => null
				, 'url' => null 
                ]
			],
            'headers' => ['Cuenta'
                , 'Proyecto'
                , 'Nombre'
                , 'Url Archivo' 
            ],
			'columns' => [
				['data' => 'cuenta', 'type' => 'myDropdown', 'placeholder' => 'Cuenta', 'source' => $cuentas],
				['data' => 'proyecto', 'type' => 'myDropdown', 'placeholder' => 'Proyecto', 'source' => $proyectos],
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'Nombre', 'width' => 300],
				['data' => 'url', 'type' => 'text', 'placeholder' => 'Url Archivo', 'width' => 300],
			],
			'colWidths' => 200,
        ];
         

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
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
		
		
		$idCuenta=$this->session->userdata('idCuenta');

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][0] = ['columnas' => ['cuenta'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.cuenta', 'idTabla' => 'idCuenta'];
		$listasParams['grupos'][1] = ['columnas' => ['proyecto'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.proyecto', 'idTabla' =>'idProyecto' , 'extra' => array( 'idCuenta'=> $idCuenta ) ];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$insertMasivo  = true;
		$fila = 1;
        foreach($listas as $index => $value){
			$listasInsertadas = [];
			$multiDataRefactorizada = [] ;

			if(empty($value['idCuenta'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar una Cuenta.<br>'));
				goto respuesta;
			}
            if(empty($value['idProyecto'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Proyecto.<br>'));
                goto respuesta;
            }

			$rs = $this->model->registrarLista_HT($value);
            $idLista = $this->db->insert_id();

            if(!$rs){
                $insertMasivo = false;
                break;
            }
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

	public function getProyectos(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data2 = $this->model->obtenerProyectos($post)->result_array();
		$html2 = "<option value=''>-- Seleccionar --</option>";
			foreach($data2 as $row){
				$html2 .= '<option value='.$row['idProyecto'].'>'.$row['proyecto'].'</option>';
			}

		$result['data']['html2'] = $html2; 
		$result['result'] = 1;
		echo json_encode($result);
	}
	
}
