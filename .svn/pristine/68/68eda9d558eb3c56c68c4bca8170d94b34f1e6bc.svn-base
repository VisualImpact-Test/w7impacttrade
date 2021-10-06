<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventario extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_inventario', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarLista' => 'Actualizar Lista Inventario',
			'registrarLista' => 'Registrar Lista Inventario',
			'masivoLista' => 'Guardar Masivo Lista Inventario',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/inventario/';

		$this->html = [
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaInventario',
				'new' => $this->carpetaHtml .  'formNewListaInventario',
				'update' => $this->carpetaHtml .  'formUpdateListaInventario',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaInventario'
			],
		];
	}

	public function index()
	{
		$this->aSessTrack = [ 'idAccion' => 4 ];

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
			'assets/custom/js/configuraciones/gestion/inventario'
		];

		$config['nav']['menu_active']='93';
		$config['data']['icon'] = 'fa fa-list';
		$config['data']['title'] = 'Inventario';
		$config['data']['message'] = 'Módulo Inventario';
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
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->model->getProyectos($params)->result_array();
		$dataParaVista['lista_elementos'] =  array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->model->aSessTrack;
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
			'fechaInicio' => ['requerido'],
			'canal' => ['requerido'],
			'proyecto' => ['selectRequerido'],
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
			'canal' => ['requerido'],
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

        $canales = $this->model->getCanales()->result_array();
        $post = '';
        $proyectos = $this->model->getProyectos($params)->result_array();
        $clientes = $this->model->getClientes()->result_array();
        $elementos = $this->model->getElementos()->result_array();

		//REFACTORIZANDO DATA
        
		$canalesRefactorizado = [];
		foreach ($canales as $row) {
			if (!in_array($row['nombre'], $canalesRefactorizado)) $canalesRefactorizado[] = $row['nombre'];
		}
        $canales = !empty($canalesRefactorizado) ? $canalesRefactorizado : [' '];
        
		$proyectosRefactorizado = [];
		foreach ($proyectos as $row) {
			if (!in_array($row['nombre'], $proyectosRefactorizado)) $proyectosRefactorizado[] = $row['nombre'];
		}
        $proyectos = !empty($proyectosRefactorizado) ? $proyectosRefactorizado : [' '];
        
		$clientesRefactorizado = [];
		foreach ($clientes as $row) {
			if (!in_array($row['idCliente'], $clientesRefactorizado)) $clientesRefactorizado[] = $row['idCliente'];
		}
        $clientes = !empty($clientesRefactorizado) ? $clientesRefactorizado : [' '];
        
		$elementosRefactorizado = [];
		foreach ($elementos as $row) {
			if (!in_array($row['idProducto'], $elementosRefactorizado)) $elementosRefactorizado[] = $row['idProducto'];
		}
		$elementos = !empty($elementosRefactorizado) ? $elementosRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
                ['idLista' => null
				, 'proyecto' => null 
				, 'canal' => null 
                , 'idCliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
			'headers' => ['Id Lista'
				, 'Proyecto'
                , 'Canal'
                , 'ID Cliente'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'proyecto', 'type' => 'myDropdown', 'placeholder' => 'Proyecto', 'source' => $proyectos],
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
                , 'idProducto' => null
                ]
			],
            'headers' => ['Id Lista'
                , 'ID Producto'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'idProducto', 'type' => 'myDropdown', 'placeholder' => 'ID Producto', 'source' => $elementos],
                
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
		//$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elemento']['tabla'], 'idTabla' => $this->model->tablas['elemento']['id']];
        //$elementos = $this->getIdsCorrespondientes($elementosParmas);
        
        array_pop($elementos);
		$idCuenta=$this->session->userdata('idCuenta');
        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][0] = ['columnas' => ['proyecto'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.proyecto', 'idTabla' => 'idProyecto' , 'extra' => array( 'idCuenta'=> $idCuenta ) ];
		$listasParams['grupos'][1] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
		//$listasParams['grupos'][2] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
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
			if(empty($value['idCanal'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un  Canal.<br> Lista N°: '.$value['idLista']));
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
		$data2 = $this->model->obtenerProyectos($post)->result_array();
		$data = $this->model->getSegCliente($post)->result_array();

		$html = "<option value=''>-- Seleccionar --</option>";
			foreach($data as $row){
				$html .= '<option value='.$row['idCliente'].'>'.$row['razonSocial'].'</option>';
			}
			
		$html2 = "<option value=''>-- Seleccionar --</option>";
			foreach($data2 as $row){
				$html2 .= '<option value='.$row['idProyecto'].'>'.$row['proyecto'].'</option>';
			}
			
		$html3 = "<option value=''>-- Seleccionar --</option>";
			foreach($data3 as $row){
				$html3 .= '<option value='.$row['idCanal'].'>'.$row['nombre'].'</option>';
			}

		$result['data']['html'] = $html; 
		$result['data']['html2'] = $html2; 
		$result['data']['html3'] = $html3; 
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
