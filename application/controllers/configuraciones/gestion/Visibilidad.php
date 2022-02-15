<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visibilidad extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_visibilidad', 'model');
        $this->load->model('m_control');
		$this->load->model('configuraciones/gestion/m_productos', 'm_productos');


		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',

			'actualizarPromocion' => 'Actualizar Promoción',
			'registrarPromocion' => 'Registrar Promoción',
			'masivoPromocion' => 'Guardar Masivo Promoción',

			'actualizarLista' => 'Actualizar Lista SOS',
			'registrarLista' => 'Registrar Lista Promoción',
			'masivoLista' => 'Guardar Masivo Lista Promoción',

        ];
        
		$this->carpetaHtml = 'modulos/configuraciones/gestion/visibilidad/';

		$this->html = [
			'elemento' => [
				'tabla' => $this->carpetaHtml .  'tablaPromocion',
				'new' => $this->carpetaHtml .  'formNewPromocion',
				'update' => $this->carpetaHtml .  'formUpdateLista_sos',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaPromocion'
			],
			'lista' => [
				'tabla' => $this->carpetaHtml .  'tablaListaPromocion',
				'new' => $this->carpetaHtml .  'formNewListaPromocion',
				'update' => $this->carpetaHtml .  'formUpdateLista_sos',
				'cargaMasiva' => $this->carpetaHtml .  'FormCargaMasivaListaPromocion'
			],
		];
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/gestion/visibilidad'
		];

		$config['nav']['menu_active']='96';
		$config['data']['icon'] = 'far fa-share-alt';
		$config['data']['title'] = 'Visibilidad';
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
			case 'Lista_sos':
				$tabla = $this->model->tablas['lista_sos']['tabla'];
				$idTabla = $this->model->tablas['lista_sos']['id'];
				break;
			case 'Lista_sod':
				$tabla = $this->model->tablas['lista_sod']['tabla'];
				$idTabla = $this->model->tablas['lista_sod']['id'];
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

	// SECCION ELEMENTOS
	public function getTablaLista_sos()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		
		$fechas = explode(' - ', $post['txt-fechas']);
		$input = array();
		$post['fecIni'] = $fechas[0];
		$post['fecFin'] = $fechas[1];

		$data = $this->model->getListas_sos($post)->result_array();


		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/visibilidad/tablaListaSos", $dataParaVista, true);
		}

		echo json_encode($result);
	}

    public function getFormNewPromocion()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];
		$dataParaVista['tipos'] = $this->model->getTiposPromocion()->result_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['new'], $dataParaVista, true);

		echo json_encode($result);
    }
    public function registrarPromocion()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['registrar'.$post['seccionActivo']];


		$elementosAValidar = [
			'nombre' => ['requerido'],
			'tipo' => ['requerido'],
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
		echo json_encode($result);
	}

	public function getFormUpdateLista_sos()
	{
		$result = $this->result;
		
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'LISTA SOS';

		$dataParaVista['tipos'] = $this->m_productos->getMarcas()->result_array();
		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['update'], $dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarPromocion()
	{
		$this->db->trans_start();
		$result = $this->result;
        
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = $this->titulo['actualizar'.$post['seccionActivo']];

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'tipo' => ['requerido'],

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

		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$dataParaVista['cuentas'] = $this->model->getCuentas($params)->result_array();
		$dataParaVista['elementos'] = $this->model->getElementos()->result_array();
		$dataParaVista['cadenas'] = $this->model->getCadenas()->result_array();
		$dataParaVista['banners'] = $this->model->getBanners()->result_array();

		$dataParaVista['data'] = $this->model->getListas($post)->row_array();
		$dataParaVista['lista_elementos'] =  $this->model->getListaElementos($post)->result_array();

		$post='';
		$dataParaVista['canales'] = $this->m_filtros->getCanales()->result_array();

		$dataParaVista['proyectos'] = $this->m_filtros->getProyectos($params)->result_array();

		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['lista']['update'], $dataParaVista, true);

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
			// 'proyecto' => ['requerido'],
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
		echo json_encode($result);
	}

	public function getFormCargaMasivaLista_sos(){
		$result = $this->result;
		$result['msg']['title'] = 'Carga Masiva';

		$gruposCanal = $this->m_control->get_grupoCanal();
        $canales = $this->m_control->get_canal();
		$post = '';
		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		$elementos = $this->m_productos->getMarcas()->result_array();

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
			'headers' => [
				'COD LISTA'
				, 'GRUPO CANAL (*)'
                , 'CANAL'
				, 'COD VISUAL'
                , 'FECHA INICIO (*)'
                , 'FECHA FIN'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'COD Lista', 'width' => 100],
				['data' => 'grupoCanal', 'type' => 'myDropdown', 'placeholder' => 'Grupo Canal', 'source' => $gruposCanal],
				['data' => 'canal', 'type' => 'myDropdown', 'placeholder' => 'Canal', 'source' => $canales],
				['data' => 'idCliente', 'type' => 'numeric', 'placeholder' => 'COD VISUAL (ID Cliente)'],
				['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate'],
			],
			'colWidths' => 200,
        ];

		$HT[1] = [
			'nombre' => 'Marcas',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['COD LISTA'
                , 'MARCA'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'COD Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Marca', 'source' => $elementos],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view("modulos/Configuraciones/Gestion/premiacion/FormCargaMasivaListaPremiaciones", $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
    }
    
	public function guardarCargaMasivaLista_sos(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = 'Carga Masiva';

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
		$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => "trade.producto_marca", 'idTabla' => "idMarca" ];
        $elementos = $this->getIdsCorrespondientes($elementosParmas);
        array_pop($elementos);
		$idCuenta=$this->session->userdata('idCuenta');

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][1] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' =>'idGrupoCanal'];
		$listasParams['grupos'][2] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
        $listas = $this->getIdsCorrespondientes($listasParams);

		$idProyecto= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);
		
		if(!$listas_unicas){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que todas las listas tengan un ID único'));
			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
        foreach($listas as $index => $value){

			if(empty($value['idLista'])) continue;

			$listasInsertadas = [];
			$multiDataRefactorizada = [] ;

			$value['idProyecto']=$idProyecto;

            if(empty($value['grupoCanal'])){
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
                        'elemento_lista' => $row["idMarca"],
                    ];
                }
            }
			if(!empty($multiDataRefactorizada)){

				$insert = $this->model->guardarMasivoLista($multiDataRefactorizada, $idLista);
				if($insert == 'repetido'){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(['type'=>2,"message"=> 'Se encontraron encuestas repetidas para la lista N:'.$value['idLista']]);
					echo json_encode($result);
					exit();
				}
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
	
	public function getFormCargaMasivaPromocion()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoPromocion'];

        $post = '';
		$tipos = $this->model->getTiposPromocion()->result_array();
		//REFACTORIZANDO DATA
		$tiposRefactorizado = [];
		foreach ($tipos as $row) {
			if (!in_array($row['nombre'], $tiposRefactorizado)) $tiposRefactorizado[] = $row['nombre'];
		}
		$tipos = !empty($tiposRefactorizado) ? $tiposRefactorizado : [' '];

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Promociones',
			'data' => [
				['promocion' => null
				,'tipo' =>null
                ]
			],
            'headers' => ['Promoción','Tipo Promoción'
            ],
			'columns' => [
				['data' => 'promocion', 'type' => 'text', 'placeholder' => 'Promoción', 'width' => 300],
				['data' => 'tipo', 'type' => 'myDropdown', 'placeholder' => 'Tipo','source' => $tipos],
			],
			'colWidths' => 200,
        ];
        
		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['elemento']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarCargaMasivaPromocion(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoPromocion'];

        $post = json_decode($this->input->post('data'), true);
        

        $elementos = $post['HT']['0'];
		$elementosParams['tablaHT'] = $elementos;
		$elementosParams['grupos'][0] = ['columnas' => ['tipo'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.tipoPromocion', 'idTabla' => 'idTipoPromocion'];
        $elementos = $this->getIdsCorrespondientes($elementosParams);
        
		array_pop($elementos);

		$elementos_unicos = $this->model->validar_elementos_unicos_HT($elementos);

		if(!$elementos_unicos){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Asegúrese que los elementos no se repiten'));

			goto responder;
		}
		$insertMasivo  = true;
		$fila = 1;
		$multiDataRefactorizada = [] ;
        foreach($elementos as $index => $value){

			if(empty($value['idTipoPromocion'])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(array('type'=> 2,'message'=>'Debe seleccionar un  Tipo Promoción.<br> Fila N°: '.$fila));

				goto responder;
			}

			$multiDataRefactorizada[] = [
				'nombre' => trim($value['promocion']),
				'idTipoPromocion' => $value['idTipoPromocion']
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
		echo json_encode($result);
	}
	public function getTablaTipoPromocion()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$data = $this->model->getTiposPromocion($post)->result_array();

		$result['result'] = 1;
		if (count($data) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['data'] = $data;
			$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/promociones/tablaTipoPromocion", $dataParaVista, true);
		}

		echo json_encode($result);
	}
	public function getFormNewTipoPromocion()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = 'Registrar Tipo Promoción';
		$dataParaVista = [];
		$result['result'] = 1;
		$result['data']['width'] = '50%';
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/promociones/formNewTipoPromocion", $dataParaVista, true);

		echo json_encode($result);
    }

	public function registrarTipoPromocion()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Registrar Tipo Promoción';


		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreTipoPromocionRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$registro = $this->model->registrarTipoPromocion($post);
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

		public function getFormUpdateTipoPromocion()
	{
        $result = $this->result;
		$post = json_decode($this->input->post('data'), true);
        
		$result['msg']['title'] = 'Actualizar Tipo Promoción';
		$dataParaVista = [];
		$dataParaVista['data'] = $this->model->getTiposPromocion($post)->row_array();
		$result['result'] = 1;
		$result['data']['width'] = '50%';
		$result['data']['html'] = $this->load->view("modulos/configuraciones/gestion/promociones/formUpdateTipoPromocion", $dataParaVista, true);

		echo json_encode($result);
    }

	public function actualizarTipoPromocion()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Actualizar Tipo Promoción';


		$elementosAValidar = [
			'nombre' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->model->checkNombreTipoPromocionRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$update = $this->model->actualizarTipoPromocion($post);
		if (!$update) {
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


	public function actualizarCargaMasivaLista_sos()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = "Carga masiva de listas";

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
		$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->model->tablas['elemento_sos']['tabla'], 'idTabla' => $this->model->tablas['elemento_sos']['id']];
        $elementos = $this->getIdsCorrespondientes($elementosParmas);
        
        array_pop($elementos);

		$idCuenta=$this->session->userdata('idCuenta');

        $listas = $post['HT']['0'];
		$listasParams['tablaHT'] = $listas;
		$listasParams['grupos'][1] = ['columnas' => ['grupoCanal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.grupoCanal', 'idTabla' =>'idGrupoCanal'];
		$listasParams['grupos'][2] = ['columnas' => ['canal'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.canal', 'idTabla' =>'idCanal'];
        $listas = $this->getIdsCorrespondientes($listasParams);
        
		array_pop($listas);

		$idProyecto= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$listas_unicas = $this->model->validar_filas_unicas_HT($listas);

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
		$listasrs = $this->model->getListas_sos(['all' => 1])->result_array();
		foreach ($listasrs as $k => $row) {
			$listasExistentes['listas'][$row['idListSos']] = 1;
			$listasExistentes['marca'][$row['idListSos']][$row['idMarca']] = 1;
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
				'idListSos' => $value['idLista'],
				'idProyecto' => trim($value['idProyecto']),
			];
			
			!empty($value['fechaInicio']) ? $updateListas[$ix]['fecIni'] = trim($value['fechaInicio']) : '';
			!empty($value['idCanal']) ? $updateListas[$ix]['idCanal'] = trim($value['idCanal']) : '';
			!empty($value['fechaFin']) ? $updateListas[$ix]['fecFin'] = trim($value['fechaFin']) : '';
			!empty($value['idCliente']) ? $updateListas[$ix]['idCliente'] = trim($value['idCliente']) : '';

		}

		$idsLista = [];
		$detalleParaInsertar = [];


		foreach ($elementos as $ix => $v) {

			if(empty($v['idLista'])) continue;

			if(empty($listasExistentes['listas'][$v['idLista']])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>"El ID de Lista no existe. <br> Fila:".($ix+1). "<br> <strong>Hoja de Premiaciones</strong>"]);
				goto responder;
			}
			
			$deleteListaDetalle[] = $v['idLista'];
			$insertEncuestas[] = [
				'idListSos' => $v['idLista'],
				'idMarca' => $v['idMarca'],
			];

			if(!empty($detalleParaInsertar[$v['idLista']][$v['idMarca']])){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>"No se pueden repetir encuestas dentro de una Lista. <br> Fila:".($ix+1). "<br> <strong>Hoja de Premiaciones</strong>"]);
				goto responder;
			}

			$detalleParaInsertar[$v['idLista']][$v['idMarca']] = ($ix+1);

			$idsLista [] = $v['idLista'];
		
		}

		if(!empty($updateListas)){
			$rs = $idLista = $this->model->actualizarLista_HT($updateListas);

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
					if(!empty($detalleParaInsertar[$ls['idListSos']][$ls['idMarca']])){
						$fila = $detalleParaInsertar[$ls['idListSos']][$ls['idMarca']];
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(['type'=>2,'message'=>"La premiacion ya existe dentro de la lista. <br> Fila:".$fila. "<br> <strong>Hoja de Premiaciones</strong>"]);
						goto responder;
					}
				}
			} 

			$rsEncuestas = $this->model->actualizarMasivoLista($insertEncuestas,$deleteListaDetalle);

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

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

}
