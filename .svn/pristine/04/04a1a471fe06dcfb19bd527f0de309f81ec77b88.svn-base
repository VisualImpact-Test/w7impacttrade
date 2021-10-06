<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gestortiendainfo extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_info', 'model');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarElemento' => 'Actualizar Info',
			'registrarElemento' => 'Registrar Info',
			'masivoElemento' => 'Guardar Masivo Info',

			'actualizarLista' => 'Actualizar Tienda ',
			'registrarLista' => 'Registrar Tienda',
			'masivoLista' => 'Guardar Masivo Tiendas ',

        ];
        
        $this->carpetaHtml = 'modulos/configuraciones/gestion/info/';
        
		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaInfo',
				'new' => $this->carpetaHtml .  'formNewInfo',
				'update' => $this->carpetaHtml .  'formUpdateInfo',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaInfo'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaInfoTienda',
				'new' => $this->carpetaHtml .  'formNewInfoTienda',
				'update' => $this->carpetaHtml .  'formUpdateInfoTienda',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaInfoTienda',
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
			'assets/custom/js/configuraciones/gestion/info'
		];

		$config['nav']['menu_active']='97';
		$config['data']['icon'] = 'fa fa-store';
		$config['data']['title'] = 'Gestor Información Tienda';
		$config['data']['message'] = '';
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
		$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();


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
            'cuenta' => ['selectRequerido'],
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
		$dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();

		
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
        
        $idCuenta = $this->session->userdata('idCuenta');

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta' => ['selectRequerido'],
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

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['canales'] = $this->model->getCanales($post)->result_array();
		$dataParaVista['gruposCanal'] = $this->model->getGrupoCanales($post)->result_array();
		$dataParaVista['proyectos'] = $this->model->getProyectos($post)->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();
		$dataParaVista['lista_elementos'] =  array();

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

		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['clientes'] = $this->model->getClientes()->result_array();

		$dataParaVista['data'] = $this->model->getClientes($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post='';
		$dataParaVista['canales'] = $this->model->getCanales()->result_array();

		$dataParaVista['proyectos'] = $this->model->getProyectos($post)->result_array();

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
            'cliente' => ['requerido'],
            'fechaInicio' =>['requerido']
            
		];

		$elementosAValidarMulti = [
            'elemento_lista'=>['selectRequerido'],
            'valor' =>['requerido','numerico'],

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

		$idCliente = $post['cliente'];

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['lista']['tabla'], $this->model->tablas['lista']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
		//INSERT
		$insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idCliente, $post);


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

		];
		$elementosAValidarMulti = [
            'fechaInicio' => ['requerido'],
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

		//BORRAR
		if (!empty($post['elementosEliminados'])) {
			$elementosEliminados = $post['elementosEliminados'];
			if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
			$delete = $this->model->deleteMasivo($this->model->tablas['lista']['tabla'], $this->model->tablas['lista']['id'], $elementosEliminados);
		}
		//UPDATE
		$update = $this->model->actualizarMasivoLista($multiDataRefactorizada);
        //INSERT
        $insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista, $post);


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

		$gruposCanal = $this->model->getGrupoCanales()->result_array();
        $canales = $this->model->getCanales()->result_array();
        $post = '';
        $proyectos = $this->model->getProyectos($post)->result_array();
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
			if (!in_array($row['nombre'], $proyectosRefactorizado)) $proyectosRefactorizado[] = $row['nombre'];
		}
        $proyectos = !empty($proyectosRefactorizado) ? $proyectosRefactorizado : [' '];
        
		$clientesRefactorizado = [];
		foreach ($clientes as $row) {
			if (!in_array($row['razonSocial'], $clientesRefactorizado)) $clientesRefactorizado[] = $row['razonSocial'];
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
                [
                  'idLista' => null
                , 'info' => null
                , 'canal' => null 
                , 'proyecto' => null 
                , 'cliente' => null 
                , 'fechaInicio' => null
                , 'fechaFin' => null
                ]
			],
            'headers' => 
            [
                  'Cliente'
                , 'Información'
                , 'valor'
                , 'Fecha Inicio'
                , 'Fecha Fin'
            ],
			'columns' => [
				['data' => 'cliente', 'type' => 'myDropdown', 'placeholder' => 'Cliente', 'source' => $clientes],
				['data' => 'info', 'type' => 'myDropdown', 'placeholder' => 'Info', 'source' => $elementos],
				['data' => 'valor', 'type' => 'numeric', 'placeholder' => 'Valor'],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];
        

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
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

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][0] = ['columnas' => ['cliente'], 'columnasReales' => ['razonSocial'], 'tabla' => 'trade.cliente', 'idTabla' => 'idCliente'];
		$listasParams['grupos'][1] = ['columnas' => ['info'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.live_tipoInfo', 'idTabla' =>'idInfo'];
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

            if(empty($value['idCliente'])){
                $result['result'] = 0;
                $result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un Cliente.<br> Lista N°: '.$value['idLista']));
                goto responder;
            }
			if(empty($value['idInfo'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un tipo de información.<br> Lista N°: '.$value['idLista']));
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
	
}
