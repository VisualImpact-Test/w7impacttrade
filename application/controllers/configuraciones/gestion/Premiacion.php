<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Premiacion extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuraciones/gestion/m_premiacion', 'm_tipopremiacion');
        $this->load->model('m_control');

        $this->titulo = [
            'cambiarEstado' => 'Activar/Desactivar',

            'actualizarPremiacion' => 'Actualizar Premiacion',
            'registrarPremiacion' => 'Registrar Premiacion',
            'masivoPremiacion' => 'Guardar Masivo Premiacion',
        ];

        $this->carpetaHtml = 'modulos/Configuraciones/gestion/premiacion/';

        $this->html = [
            'lista' => [
                'tabla' => $this->carpetaHtml .  'listaTabla',
                'new' => $this->carpetaHtml .  'listaFormNew',
                'update' => $this->carpetaHtml .  'listaFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'listaFormCargaMasiva'
            ],

            'tipoPremiacion' => [
                'tabla' => $this->carpetaHtml .  'premiacionTabla',
                'new' => $this->carpetaHtml .  'premiacionFormNew',
                'update' => $this->carpetaHtml .  'premiacionFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'premiacionFormCargaMasiva'
            ],
        ];
    }

    public function index()
    {
        $config = array();
        $config['nav']['menu_active'] = '139';
        $config['css']['style'] = [
            'assets/libs/dataTables-1.10.20/datatables',
            'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
        ];
        $config['js']['script'] = [
            'assets/libs/datatables/responsive.bootstrap4.min',
            'assets/custom/js/core/datatables-defaults',
            'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/languages/all',
            'assets/libs/handsontable@7.4.2/dist/moment/moment',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
            'assets/custom/js/core/HTCustom',
            'assets/custom/js/core/gestion',
            'assets/custom/js/configuraciones/gestion/premiacion',
        ];

        $config['data']['icon'] = 'fal fa-trophy-alt';
        $config['data']['title'] = 'Premiaciones';
        $config['data']['message'] = 'Módulo para cambiar Premiaciones';
        $config['view'] = $this->carpetaHtml . 'index';

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
            case 'TipoPremiacion':
                $tabla = $this->m_tipopremiacion->tablas['tipoPremiacion']['tabla'];
                $idTabla = $this->m_tipopremiacion->tablas['tipoPremiacion']['id'];
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

        $cambioEstado = $this->m_tipopremiacion->actualizarMasivo($tabla, $update, $idTabla);

        if (!$cambioEstado) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
        }
        echo json_encode($result);
    }

    public function getTablaPremiacion()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_tipopremiacion->getPremiacion($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewPremiacion()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarPremiacion'];

        $dataParaVista = [];

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarPremiacion()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarPremiacion'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta_tipoPremiacion' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_tipopremiacion->checkTipoPremiacionRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_tipopremiacion->registrarTipoPremiacion($post);
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

    public function getFormUpdatePremiacion(){
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarPremiacion'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['tipoPremiacion'] = $this->m_tipopremiacion->getPremiacion($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarPremiacion()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarPremiacion'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta_tipoPremiacion' => ['requerido']
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_tipopremiacion->checkTipoPremiacionRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_tipopremiacion->actualizarTipoPremiacion($post);

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

	public function getFormCargaMasivaPremiacion(){
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoPremiacion'];

		//REFACTORIZANDO DATA

		//ARMANDO HANDSONTABLE
		$HT[0] = [
			'nombre' => 'Lista',
			'data' => [
				['nombre' => null
				, 'fecInicio' => null 
				, 'fecCaducidad' => null 
                ]
			],
			'headers' => ['NOMBRE PREMIACION'
				, 'FECHA INICIO'
                , 'FECHA CADUCIDAD'
            ],
			'columns' => [
				['data' => 'nombre', 'type' => 'text', 'placeholder' => 'ID Lista'],
				['data' => 'fecInicio', 'type' => 'myDate'],
				['data' => 'fecCaducidad', 'type' => 'myDate']
			],
			'colWidths' => 200,
        ];
        
	

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['cargaMasiva'], $dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
    }

	
	public function guardarCargaMasivaPremiacion(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['masivoPremiacion'];

        $post = json_decode($this->input->post('data'), true);

		$dataArray= $post['HT'][0];
		$idCuenta= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";

		foreach($dataArray as $index => $value){
			if(!empty($value['nombre'])){
				$array = array(
					'nombre'=>$value['nombre']
					,'fechaInicio'=>$value['fecInicio']
					,'idCuenta'=>$idCuenta
				);
				if(!empty($value['fecCaducidad'])){
					$array['fechaCaducidad'] = $value['fecCaducidad'];
				}
				$this->db->insert("{$this->sessBDCuenta}.trade.premiacion",$array);
			}
		}

		$this->db->trans_complete();

		$html='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR PREMIACIONES CORRECTAMENTE.</div>';
		$result['msg']['content'] = $html;

		
		echo json_encode($result);
	}

    public function getFormCargaMasivaLista(){
		$result = $this->result;
		$result['msg']['title'] = 'Carga Masiva';

		$gruposCanal = $this->m_control->get_grupoCanal();
        $canales = $this->m_control->get_canal();
		$post = '';
		$params=array();
		$params['idUsuario']=$this->session->userdata('idUsuario');
		//$cuentas=$this->m_encuestas->getCuentas($params)->result_array();
		
        $clientes = $this->m_tipopremiacion->getClientes()->result_array();
		$elementos = $this->m_tipopremiacion->getPremiacion()->result_array();
		$tipos = $this->m_control->get_tiposUsuario();

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

		$HT[1] = [
			'nombre' => 'Premiaciones',
			'data' => [
                ['idLista' => null
                , 'elemento_lista' => null
                ]
			],
            'headers' => ['ID Lista'
                , 'Premiacion'
            ],
			'columns' => [
				['data' => 'idLista', 'type' => 'numeric', 'placeholder' => 'ID Lista', 'width' => 100],
				['data' => 'elemento_lista', 'type' => 'myDropdown', 'placeholder' => 'Encuesta', 'source' => $elementos],
                
			],
			'colWidths' => 200,
		];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'],1 => $HT[1]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '70%';
		$result['data']['html'] = $this->load->view("formCargaMasivaGeneral", $dataParaVista, true);
		$result['data']['ht'] = $HT;

		$this->aSessTrack = $this->m_tipopremiacion->aSessTrack;
		echo json_encode($result);
    }

	public function guardarCargaMasivaLista(){
        $this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = 'Carga Masiva';

        $post = json_decode($this->input->post('data'), true);
        
		$elementos = $post['HT']['1'];
		$elementosParmas['tablaHT'] = $elementos;
		$elementosParmas['grupos'][0] = ['columnas' => ['elemento_lista'], 'columnasReales' => ['nombre'], 'tabla' => $this->m_tipopremiacion->tablas['tipoPremiacion']['tabla'], 'idTabla' =>  $this->m_tipopremiacion->tablas['tipoPremiacion']['id'] ];
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

		$listas_unicas = $this->m_tipopremiacion->validar_filas_unicas_HT($listas);

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
			
			$rs = $this->m_tipopremiacion->registrarLista_HT($value);
            $idLista = $this->db->insert_id();
            
            if(!$rs){
                $insertMasivo = false;
                break;
            }

			foreach($elementos as $row){

                if($row['idLista'] == $value['idLista']){
                    $multiDataRefactorizada[] = [
                        'elemento_lista' => $row[$this->m_tipopremiacion->tablas['tipoPremiacion']['id']],
                    ];
                }
            }
            $insert = $this->m_tipopremiacion->guardarMasivoLista($multiDataRefactorizada, $idLista);

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

		$this->aSessTrack = $this->m_tipopremiacion->aSessTrack;
		echo json_encode($result);
    }

}
