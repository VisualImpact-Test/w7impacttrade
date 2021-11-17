<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auditoria extends MY_Controller{

	public function __construct(){  
		parent::__construct();
		$this->load->model('M_auditoria','model');
	}

	public function index(){
		$config = array();
		$config['css']['style'] = array(
			'assets/libs/datatables/dataTables.bootstrap4.min',
			'assets/libs/datatables/buttons.bootstrap4.min',
			'assets/custom/css/auditoria'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/auditoria'
		);

		$config['nav']['menu_active']='65';
		$config['data']['icon'] = 'fas fa-gavel';
		$config['data']['title'] = 'Auditoria';
		$config['data']['message'] = 'Auditoria';
		$config['view']='modulos/auditoria/index';
		
		$this->view($config);
	}

	public function visibilidad(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['visibFormato'] = $data->{'rd-visib-formato'};
		$input['visibColumn'] = isset($data->{'chk-visib-column'}) ? $data->{'chk-visib-column'} : [];
			if( !is_array($input['visibColumn']) ) $input['visibColumn'] = [ $input['visibColumn'] ];

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data->{'grupo_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$input['frecuencia_filtro'] = $data->{'frecuencia_filtro'} ;

		$data = [];
		$data['visibColumn'] = $input['visibColumn'];

		$data['visitas'] = $this->model->obtener_visitas($input);
		$data['clienteTipo'] = $this->model->obtener_clienteTipo($input);

		$data['obligatorios'] = $this->model->obtener_elementos_obligatorios($input);
		$data['adicionales'] = $this->model->obtener_elementos_adicionales($input);
		$data['iniciativas'] = $this->model->obtener_iniciativas($input);

		$resultado_obligatorio = $this->model->obtener_resultados_obligatorios($input);
		$resultado_adicionales = $this->model->obtener_resultados_adicionales($input);
		$resultado_iniciativas = $this->model->obtener_resultados_iniciativas($input);
		$resultados_foto = $this->model->obtener_num_fotos($input);

		$data['resultados_obligatorios'] = array();
		$data['resultados_adicionales'] = array();
		$data['resultados_iniciativas'] = array();
		$data['resultados_foto'] = array();

		$data['total_eo'] = [];
		$data['total_eo_si'] = [];
		$data['total_eo_no'] = [];
		$data['total_eo_ad'] = [];

		foreach( $resultados_foto as $row){
			$data['resultados_foto'][$row['idVisita']]['numFotos'] = $row['totalFotos'];
		}
		
		foreach( $resultado_obligatorio as $row){
			$data['resultados_obligatorios'][$row['idVisita']]['porcentajeEo'] = $row['porcentaje'];

			if( !isset($data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']]['cantidad']) ||
				empty($data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']]['cantidad'])
			)
				$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']]['cantidad'] = $row['cantidad'];


			$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['presencia'] = $row['presencia'];
			$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['comentario'] = $row['descripcion'];
			$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['foto'] = $row['fotoUrl'];
			$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']]['modulado'] = $row['modulado'];

			if( !isset($data['total_eo'][$row['idVisita']]) ) $data['total_eo'][$row['idVisita']] = [];
			if( !isset($data['total_eo_si'][$row['idVisita']]) ) $data['total_eo_si'][$row['idVisita']] = [];
			if( !isset($data['total_eo_no'][$row['idVisita']]) ) $data['total_eo_no'][$row['idVisita']] = [];
			if( !isset($data['total_eo_ad'][$row['idVisita']]) ) $data['total_eo_ad'][$row['idVisita']] = [];

			if( isset($data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][2]['presencia']) &&
				isset($data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][3]['presencia']) &&
				$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][2]['presencia'] == 1 &&
				$data['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][3]['presencia'] == 1
			){
				$data['total_eo_si'][$row['idVisita']][$row['idElementoVis']] = $row['idElementoVis'];
				if( isset($data['total_eo_no'][$row['idVisita']][$row['idElementoVis']]) )
					unset($data['total_eo_no'][$row['idVisita']][$row['idElementoVis']]);
			}
			else{
				$data['total_eo_no'][$row['idVisita']][$row['idElementoVis']] = $row['idElementoVis'];
			}

			$data['total_eo'][$row['idVisita']][$row['idElementoVis']] = $row['idElementoVis'];
			$data['total_eo_ad'][$row['idVisita']]["o-{$row['idElementoVis']}"] = $row['idElementoVis'];
		}

		foreach( $resultado_adicionales as $row){
			$data['resultados_adicionales'][$row['idVisita']]['porcentajeAd'] = $row['porcentaje'];
			$data['resultados_adicionales'][$row['idVisita']][$row['idElementoVis']] = $row['presencia'];

			if( !isset($data['total_eo_ad'][$row['idVisita']]) ) $data['total_eo_ad'][$row['idVisita']] = [];
			$data['total_eo_ad'][$row['idVisita']]["o-{$row['idElementoVis']}"] = $row['idElementoVis'];
		}

		foreach( $resultado_iniciativas as $row){
			$data['resultados_iniciativas'][$row['idVisita']]['porcentajeI'] = $row['porcentaje'];
			$data['resultados_iniciativas'][$row['idVisita']][$row['idElementoVis']] = $row['presencia'];
		}

		$html = '';
		if ( !empty($data['visitas'])) {
			$result['result'] = 1;
			$result['data']['table'] = 'tb-auditoria';
			$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
			$data['segmentacion'] = $segmentacion;
			$html .= $this->load->view("modulos/auditoria/visibilidad", $data, true);
		} else {
			$html .= getMensajeGestion('noRegistros');
			
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}	

	public function modulacion(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);
			$query = $this->model->get_visitas_modulacion($input);
			if( empty($query) )
				$result['data']['view'] = createMessage([ 'type' => 2, 'message' => 'No se ha generado ningún registro' ]);
			else
				$result['data']['view'] = $this->load->view('modulos/auditoria/modulacion', [ 'data' => $query ], true);

		echo json_encode($result);
	}

	public function observaciones(){
		
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data->{'grupo_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$input['frecuencia_filtro'] = $data->{'frecuencia_filtro'} ;
		
		$array = array();
		$array['visitas'] = $this->model->get_visitas_observaciones($input)->result_array();
		$html = '';
		if ( !empty($array['visitas'])) {
			$result['result'] = 1;
			$result['data']['table'] = 'tb-observaciones';
			$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
			$array['segmentacion'] = $segmentacion;
			$html .= $this->load->view("modulos/auditoria/observaciones", $array, true);
			$result['data']['configTable'] =  [	
				'columnDefs' => 
					[ 0 => 
						[
							"visible"=> false, 
							"targets" => []
						]
					],
			  ];
		} else {
			$html .= getMensajeGestion('noRegistros');
			
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}	
	
	public function preciomarcado(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['visibFormato'] = 1;

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data->{'grupo_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$input['frecuencia_filtro'] = $data->{'frecuencia_filtro'} ;
		
		$array = array();
		$array['visitas'] = $this->model->obtener_visitas($input);
		$array['elementos'] = $this->model->obtener_elementos_obligatorios($input);

		$resultado_obligatorio = $this->model->obtener_resultados_obligatorios($input);
		$data_resultados = $this->model->hfs_data_resultados_precios_marcados($input)->result_array();
		$elementos_pm=$this->model->obtener_elementos_obligatorios_pm($input);

		foreach( $data_resultados as $row){
			$array['data_resultados'][$row['idVisita']]['porcentajePM'] = $row['porcentajePM'];
		}

		$array['resultados_obligatorios'] = array();
		$array['elementos_visita'] = array();
	
		foreach( $resultado_obligatorio as $row){
			$array['resultados_obligatorios'][$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['presencia'] = $row['presencia'];
		}
		foreach($elementos_pm as $fila){
			$array['elementos_visita'][$fila['idListVisibilidadObl']][$fila['idGrupoCanal']][$fila['idElementoVis']] = '1';
		}
		

		$html = '';
		if ( !empty($array['visitas'])) {
			$result['result'] = 1;
			$result['data']['table'] = 'tb-preciomarcado';
			$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/auditoria/preciomarcado", $array, true);

			$result['data']['configTable'] =  [	
				'columnDefs' =>
					[ 0 =>
						[
							"visible"=> false, 
							"targets" => [] 
						]
					],
			];

		} else {
			$html = getMensajeGestion('noRegistros');
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function resultados(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data->{'grupo_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$input['frecuencia_filtro'] = $data->{'frecuencia_filtro'} ;
		$array = array();
		$array['clientes'] = $this->model->get_clientes($input)->result_array();
		$html = '';
		if ( !empty($array['clientes'])) {
			$result['result'] = 1;
			$resultados=$this->model->obtener_resultados_auditores($input)->result_array();

			foreach($resultados as $fila){
				$array['porcentajeCliente'][$fila['idCliente']]['pCliente']=$fila['porcentajeCliente'];
				$array['porcentajeGTM'][$fila['idCliente']]['pGTM']=$fila['porcentajeGTM'];
			}

			$result['data']['table'] = 'tb-resultados';
			$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
			$array['segmentacion'] = $segmentacion;
			$html .= $this->load->view("modulos/auditoria/resultados", $array, true);
			$result['data']['configTable'] =  [	
				'columnDefs' => 
					[ 0 => 
						[
							"visible"=> false, 
							"targets" => []
						]
					],
			  ];
		} else {
			$html .= getMensajeGestion('noRegistros');
			
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function resumen(){
		ini_set('memory_limit','4096M');
		set_time_limit(0);

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data->{'grupo_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};
		$array = array();
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$input['frecuencia_filtro'] = $data->{'frecuencia_filtro'} ;
		$array['usuarios'] = $this->model->get_usuarios($input)->result_array();
		$html = '';
		if ( !empty($array['usuarios'])) {
			$result['result'] = 1;

			$array['fechas'] = $this->model->listar_fechas($input)->result_array();
			$resumen=$this->model->obtener_resumen_usuarios($input)->result_array();

			foreach($resumen as $fila){
				$array['vProgramadas'][$fila['idUsuario']][$fila['fecha']]['vProg']=$fila['vProg'];
				$array['vRealizadas'][$fila['idUsuario']][$fila['fecha']]['vReal']=$fila['vReal'];
				$array['vEfectivas'][$fila['idUsuario']][$fila['fecha']]['vEfec']=$fila['vEfec'];
				$array['vProgramadasTotalEmpleado'][$fila['idUsuario']]['vProgTotalEmpleado']=$fila['vProgTotalEmpleado'];
				$array['vRealizadasTotalEmpleado'][$fila['idUsuario']]['vRealTotalEmpleado']=$fila['vRealTotalEmpleado'];
				$array['vEfectivasTotalEmpleado'][$fila['idUsuario']]['vEfecTotalEmpleado']=$fila['vEfecTotalEmpleado'];
				$array['vProgramadasTotalFecha'][$fila['fecha']]['vProgTotalFecha']=$fila['vProgTotalFecha'];
				$array['vRealizadasTotalFecha'][$fila['fecha']]['vRealTotalFecha']=$fila['vRealTotalFecha'];
				$array['vEfectivasTotalFecha'][$fila['fecha']]['vEfecTotalFecha']=$fila['vEfecTotalFecha'];
			}

			$result['data']['table'] = 'tb-resumen';
			$html .= $this->load->view("modulos/auditoria/resumen", $array, true);
			$result['data']['configTable'] =  [	
				'columnDefs' => 
					[ 0 => 
						[
							"visible"=> false, 
							"targets" => [3] 
						]
					],
			  ];
		} else {
			$html .= getMensajeGestion('noRegistros');
			
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function cobertura()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data->{'grupo_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};
		$input['idClienteTipo'] = $data->{'sl_tipo_cliente'};

		$array = array();
		$array['distribuidoras'] = $this->model->listar_distribuidoras($input)->result_array();
		$html = '';
		if (!empty($array['distribuidoras'])) {
			$result['result'] = 1;
			$array['canales'] = $this->model->listar_canales($input)->result_array();
			$clientes_basemadre = $this->model->obtener_clientes_distribuidoras($input)->result_array();

			foreach ($clientes_basemadre AS $fila) {
				$array['clientesBaseMadreDistCanal'][$fila['idDistribuidoraSucursal']][$fila['idCanal']]['cliDistCanal'] = $fila['cliDistCanal'];
				$array['clientesBaseMadreDist'][$fila['idDistribuidoraSucursal']]['cliDist'] = $fila['cliDist'];
				$array['clientesBaseMadreCanal'][$fila['idCanal']]['cliCanal'] = $fila['cliCanal'];
			}

			$clientes_programados = $this->model->obtener_clientes_programados_distribuidoras($input)->result_array();

			foreach ($clientes_programados AS $fila) {
				$array['clientesProgramadosDistCanal'][$fila['idDistribuidoraSucursal']][$fila['idCanal']]['cliDistCanal'] = $fila['cliDistCanal'];
				$array['clientesProgramadosDist'][$fila['idDistribuidoraSucursal']]['cliDist'] = $fila['cliDist'];
				$array['clientesProgramadosCanal'][$fila['idCanal']]['cliCanal'] = $fila['cliCanal'];
			}

			$result['data']['table'] = 'tb-cobertura';
			$html .= $this->load->view("modulos/auditoria/cobertura", $array, true);
			$result['data']['configTable'] =  [
				'columnDefs' =>
				[
					0 =>
					[
						"visible" => false,
						"targets" => []
					]
				],
			];
		} else {
			$html .= getMensajeGestion('noRegistros');
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	function cobertura_detalle(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);
		$fechas = explode(' - ', $data['txt-fechas']);

		$input = [];
		$array = [];
		$html = getMensajeGestion('noRegistros');

		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $data['grupo_filtro'];
		$input['idCanal'] = $data['canal_filtro'];

		$input['distSucursal'] = $data['distSucursal'];
		$input['canal'] = $data['canal'];
		$input['idClienteTipo'] = $data['sl_tipo_cliente'];

		if($data['tipo'] == 'cbm'){
			$array['clientes'] = $this->model->detalle_cobertura_auditores($input)->result_array();
		}
		if($data['tipo'] == 'cp'){
			$array['clientes'] = $this->model->detalle_cobertura_programados_auditores($input)->result_array();
		}

		if(!empty($array['clientes'])){
			$html = $this->load->view("modulos/auditoria/cobertura_detalle", $array, true);
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function descargar_excel(){
		////
		$fechas = explode(' - ', $this->input->post('txt-fechas'));
		
		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		
		$input['visibFormato'] = $this->input->post('rd-visib-formato');
		if(!empty($this->input->post('chk-visib-column'))){
			$input['visibColumn'] = $this->input->post('chk-visib-column');
			if( !is_array($input['visibColumn']) ) $input['visibColumn'] = [ $input['visibColumn'] ];
		}else{
			$input['visibColumn']=[];
		}
		

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$input['idGrupoCanal'] = $this->input->post('grupo_filtro');
		$input['idCanal'] = $this->input->post('canal_filtro');

		$input['distribuidora_filtro'] = empty($this->input->post('distribuidora_filtro')) ? '' : $this->input->post('distribuidora_filtro');
		$input['zona_filtro'] = empty($this->input->post('zona_filtro')) ? '' : $this->input->post('zona_filtro');
		$input['plaza_filtro'] = empty($this->input->post('plaza_filtro')) ? '' : $this->input->post('plaza_filtro');
		$input['cadena_filtro'] = empty($this->input->post('cadena_filtro')) ? '' : $this->input->post('cadena_filtro');
		$input['banner_filtro'] = empty($this->input->post('banner_filtro')) ? '' : $this->input->post('banner_filtro');

		$input['tipoUsuario_filtro'] = $this->input->post('tipoUsuario_filtro');
		$input['usuario_filtro'] = !empty($this->input->post('usuario_filtro')) ? (is_array($this->input->post('usuario_filtro')) ? implode(",",$this->input->post('usuario_filtro')) : $this->input->post('usuario_filtro')) : '' ;
		$input['frecuencia_filtro'] = $this->input->post('frecuencia_filtro');
		
		$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
		$data['segmentacion'] = $segmentacion;
		$data = [];
		$visibColumn = $input['visibColumn'];

		$visitas = $this->model->obtener_visitas($input);
		$clienteTipo = $this->model->obtener_clienteTipo($input);

		$obligatorios = $this->model->obtener_elementos_obligatorios($input);
		$adicionales = $this->model->obtener_elementos_adicionales($input);
		$iniciativas = $this->model->obtener_iniciativas($input); 

		$resultado_obligatorio = $this->model->obtener_resultados_obligatorios($input);
		$resultado_adicionales = $this->model->obtener_resultados_adicionales($input);
		$resultado_iniciativas = $this->model->obtener_resultados_iniciativas($input);
		$resul_foto = $this->model->obtener_num_fotos($input);
		
		$resultados_obligatorios = array();
		$resultados_adicionales = array();
		$resultados_iniciativas = array();

		$total_eo = [];
		$total_eo_si = [];
		$total_eo_no = [];
		$total_eo_ad = []; 
		
		foreach( $resul_foto as $row){
				$resultados_foto[$row['idVisita']]['numFotos'] = $row['totalFotos'];
			}
			
		
		foreach( $resultado_obligatorio as $row){
			$resultados_obligatorios[$row['idVisita']]['porcentajeEo'] = $row['porcentaje'];

			if( !isset($resultados_obligatorios[$row['idVisita']][$row['idElementoVis']]['cantidad']) ||
				empty($resultados_obligatorios[$row['idVisita']][$row['idElementoVis']]['cantidad'])
			)
			
			
			$resultados_obligatorios[$row['idVisita']][$row['idElementoVis']]['cantidad'] = $row['cantidad'];

			
			$resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['presencia'] = $row['presencia'];
			$resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['comentario'] = $row['descripcion'];
			$resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][$row['idVariable']]['foto'] = $row['fotoUrl'];

			if( !isset($total_eo[$row['idVisita']]) ) $total_eo[$row['idVisita']] = [];
			if( !isset($total_eo_si[$row['idVisita']]) ) $total_eo_si[$row['idVisita']] = [];
			if( !isset($total_eo_no[$row['idVisita']]) ) $total_eo_no[$row['idVisita']] = [];
			if( !isset($total_eo_ad[$row['idVisita']]) ) $total_eo_ad[$row['idVisita']] = [];

			if( isset($resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][2]['presencia']) &&
				isset($resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][3]['presencia']) &&
				$resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][2]['presencia'] == 1 &&
				$resultados_obligatorios[$row['idVisita']][$row['idElementoVis']][3]['presencia'] == 1
			){
				$total_eo_si[$row['idVisita']][$row['idElementoVis']] = $row['idElementoVis'];
				if( isset($total_eo_no[$row['idVisita']][$row['idElementoVis']]) )
					unset($total_eo_no[$row['idVisita']][$row['idElementoVis']]);
			}
			else{
				$total_eo_no[$row['idVisita']][$row['idElementoVis']] = $row['idElementoVis'];
			}

			$total_eo[$row['idVisita']][$row['idElementoVis']] = $row['idElementoVis'];
			$total_eo_ad[$row['idVisita']]["o-{$row['idElementoVis']}"] = $row['idElementoVis'];
		}

		foreach( $resultado_adicionales as $row){
			$resultados_adicionales[$row['idVisita']]['porcentajeAd'] = $row['porcentaje'];
			$resultados_adicionales[$row['idVisita']][$row['idElementoVis']] = $row['presencia'];

			if( !isset($total_eo_ad[$row['idVisita']]) ) $total_eo_ad[$row['idVisita']] = [];
			$total_eo_ad[$row['idVisita']]["o-{$row['idElementoVis']}"] = $row['idElementoVis'];
		}

		foreach( $resultado_iniciativas as $row){
			$resultados_iniciativas[$row['idVisita']]['porcentajeI'] = $row['porcentaje'];
			$resultados_iniciativas[$row['idVisita']][$row['idElementoVis']] = $row['presencia'];
		}
		

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		/**ESTILOS**/
		$estilo_cabecera_visita =  
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '920000')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_disponibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '558636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_inactivo = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'c7c7c7')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		
		$estilo_iniciativas = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'cc3333')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);	
		
		$estilo_adicional = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '5bb5ea')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);	
		
		$estilo_elementos = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '173366')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$style_gris =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '545152')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		$style_disponibles =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		$estilo_numeros =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		/**FIN ESTILOS**/
				
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '#')
					->setCellValue('B1', 'FECHA')
					->setCellValue('C1', 'GRUPO CANAL')
					->setCellValue('D1', 'CANAL')
					->setCellValue('E1', 'SUB CANAL');
		$val = 'F';
		
		$objPHPExcel->getActiveSheet()->mergeCells('A1:A3');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:B3');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:C3');
		$objPHPExcel->getActiveSheet()->mergeCells('D1:D3');
		$objPHPExcel->getActiveSheet()->mergeCells('E1:E3');
		
		foreach ($segmentacion['headers'] as $k => $v) { 
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', strtoupper($v['header']));
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$val++;
		}
		
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'COD VISUAL');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'COD '.$this->sessNomCuentaCorto);
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'COD PDV');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'PDV');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'TIPO CLIENTE');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'DEPARTAMENTO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'PROVINCIA');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'DISTRITO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'PERFIL USUARIO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'NOMBRE USUARIO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'ORDEN DE TRABAJO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'MODULACIÓN CORRECTA');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'FOTOS');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$val++;
		$r=$val;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'2', 'TIPO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'2:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'2', 'ESTADO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'2:'.$val.'3');
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'2', 'OBSERVACION');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'2:'.$val.'3');
		$val++;
		
		$s=$r;
		$s++;
		$s++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($r.'1', 'INCIDENCIA');
		$objPHPExcel->getActiveSheet()->mergeCells($r.'1:'.$s.'1');

		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'TOTAL PRESENTES (EO + AD)');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$val.'1')->applyFromArray($style_gris);
		$objPHPExcel->getActiveSheet()->getStyle('A2:'.$val.'2')->applyFromArray($style_gris);
		
		$val++;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'TOTAL EO PRESENTES');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($estilo_elementos);
		$val++;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'TOTAL EO NO PRESENTES');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($estilo_elementos);
		$val++;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'1', 'TOTAL EO');
		$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
		$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($estilo_elementos);
		$val++;
		$obl_2=$val;
		$obl_1=$val;
		$obliColumn = 2 + count($visibColumn);
		if (!empty($obligatorios)) {
			foreach ($obligatorios as $row) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'3', 'PC');
				$val++;
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'3', 'PL');
				$val++;

				if (in_array(1, $visibColumn)) { 
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'3', 'CANT');
					$val++;
				}
				if (in_array(2, $visibColumn)) { 
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'3', 'OBS');
					$val++;
				}
				if (in_array(3, $visibColumn)) { 
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.'3', 'FOTO');
					$val++;
				}
			} 
		}
		
		foreach ($obligatorios as $row) {
			$combina_2 = $obl_2;
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($obl_2.'2', $row['nombre']);
			$i=0;
			while($i<($obliColumn-1)){
				$obl_2++;
				$i++;
			}
			$objPHPExcel->getActiveSheet()->mergeCells($combina_2.'2:'.$obl_2.'2');
			$obl_2++;
		}
		
		if (count($obligatorios) > 0) {
			$total_obligatorios = count($obligatorios) * $obliColumn;
			$combina_1 = $obl_1;
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($obl_1.'1', 'ELEMENTOS OBLIGATORIOS');
			
			$i=0;
			while($i<($total_obligatorios-1)){
				$obl_1++;
				$i++;
			}
			
			$objPHPExcel->getActiveSheet()->mergeCells($combina_1.'1:'.$obl_1.'1');
			$objPHPExcel->getActiveSheet()->getStyle($combina_1.'1:'.$obl_1.'1')->applyFromArray($estilo_elementos);
			$objPHPExcel->getActiveSheet()->getStyle($combina_1.'2:'.$obl_1.'2')->applyFromArray($estilo_elementos);
			$objPHPExcel->getActiveSheet()->getStyle($combina_1.'3:'.$obl_1.'3')->applyFromArray($estilo_elementos);
		
		}
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($val.'1', 'TOTAL EO (60%)');
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($estilo_elementos);
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($val.'1', 'TOTAL ADIC. (10%)');
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($estilo_adicional);
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($val.'1', 'TOTAL INIC. (30%)');
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($estilo_iniciativas);
		$val++;
		foreach ($clienteTipo as $row) {
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($val.'1', $row['nombre']);
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($style_gris);
			$val++;
		}
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($val.'1', 'TOTAL VIS.');
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($style_gris);
		$val++;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($val.'1', 'FRECUENCIA');
			$objPHPExcel->getActiveSheet()->mergeCells($val.'1:'.$val.'3');
			$objPHPExcel->getActiveSheet()->getStyle($val.'1:'.$val.'3')->applyFromArray($style_gris);
		$val++;


		$i=4;
		$j=1;
		foreach ($visitas as $row) {
			
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $j)
					->setCellValue('B'.$i, verificarEmpty($row['fecha'], 3))
					->setCellValue('C'.$i, verificarEmpty($row['grupoCanal'], 3))
					->setCellValue('D'.$i, verificarEmpty($row['canal'], 3))
					->setCellValue('E'.$i, verificarEmpty($row['subCanal'], 3));
			$val = 'F';

			foreach ($segmentacion['headers'] as $k => $v) { 
				$columna = (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-');
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $columna);
				$val++;
			}
			
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.$i, verificarEmpty($row['idCliente'], 3));
			$val++;
			$codCliente = isset($row['codCliente']) && strlen($row['codCliente']) > 0 ? $row['codCliente'] : '-';
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $codCliente);
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['codDist'], 3));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['razonSocial'], 3));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['clienteTipo'], 3) );
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['departamento'], 3));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['provincia'], 3) );
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['distrito'], 3));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['tipoUsuario'], 3));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, verificarEmpty($row['usuario'], 3));
			$val++;
			$ordenTrabajo = (!empty($row['ordenTrabajo']) ? $row['ordenTrabajo'] : '-');
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $ordenTrabajo);
			$val++;
			$modulacion = '';
			if (!is_null($row['modulacion']))
				$modulacion = $row['modulacion'] ? 'SI' : 'NO';

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $modulacion);
			$val++;
			
			$fotos = '';
			if (!empty($resultados_foto[$row['idVisita']]['numFotos'])) {
				$fotos = $resultados_foto[$row['idVisita']]['numFotos']; //$row['fotos'];
			}
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $fotos);
			$val++;
				
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, (!empty($row['nombreIncidencia']) ? $row['nombreIncidencia'] : '-') );
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, ($row['estadoIncidencia'] == 1 ? 'ACTIVO' : (!empty($row['nombreIncidencia']) ? 'INACTIVO' : '-')));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, (!empty($row['observacion']) ? $row['observacion'] : '-'));
			$val++;
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,(!empty($total_eo_ad[$row['idVisita']]) ? count($total_eo_ad[$row['idVisita']]) : 0));
			$val++;
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,(!empty($total_eo_si[$row['idVisita']]) ? count($total_eo_si[$row['idVisita']]) : 0));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,(!empty($total_eo_no[$row['idVisita']]) ? count($total_eo_no[$row['idVisita']]) : 0));
			$val++;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,(!empty($total_eo[$row['idVisita']]) ? count($total_eo[$row['idVisita']]) : 0));
			$val++;
			
			
			foreach ($obligatorios as $row_e) {
				if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]))
					$obliBg = '';
					$obli_2 = '-';
					if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][2]['presencia'])) {
						$obli_2 = $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][2]['presencia'];
					}
					
					$obli_3 = '-';
					if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['presencia'])) {
						$obli_3 = $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['presencia'];
					}
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $obli_2 );
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);

					if($obli_2=='-'){
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_inactivo);
					}
					$val++;
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, $obli_3 );
					if($obli_3=='-'){
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_inactivo);
					}else{
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
					}
					$val++;
					if (in_array(1, $visibColumn)) { 
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['cantidad']) ? $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['cantidad'] : '-' );
						if(!isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['cantidad'])){
							$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_inactivo);
						}else{
							$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						}
						$val++;
					}
					if (in_array(2, $visibColumn)) { 
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i, isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['comentario']) ? $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['comentario'] : '-');
						if(!isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['comentario'])){
							$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_inactivo);
						}else{
							$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						}
						$val++;
						
					}

					if (in_array(3, $visibColumn)) { 
						$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($val.$i,'-');
					$val++;
					}

					/*
					*/
			}
			
			$porcentajeObli = 0;
					if (isset($resultados_obligatorios[$row['idVisita']]['porcentajeEo']))
						$porcentajeObli = $resultados_obligatorios[$row['idVisita']]['porcentajeEo'];

					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,$porcentajeObli.'%');
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						$val++;

		
					$porcentajeAdi = 0;
					if (isset($resultados_adicionales[$row['idVisita']]['porcentajeAd']))
						$porcentajeAdi = $resultados_adicionales[$row['idVisita']]['porcentajeAd'];
					
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,$porcentajeAdi.'%');
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						$val++;
	
					$porcentajeIni = 0;
					if (isset($resultados_iniciativas[$row['idVisita']]['porcentajeI']))
						$porcentajeIni = $resultados_iniciativas[$row['idVisita']]['porcentajeI'];
					
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,$porcentajeIni.'%');
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						$val++;
					
					foreach ($clienteTipo as $row_ct) {
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,'-');
						$val++;
					}

						$porcentajeVI = 0;
						$porcentajeVI = ($porcentajeObli * 60) / 100 + ($porcentajeAdi * 10) / 100 + ($porcentajeIni * 30) / 100;
						$porcentajeVI = round($porcentajeVI, 0);
						
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,$porcentajeVI.'%');
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						$val++;
						
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($val.$i,verificarEmpty($row['frecuencia'], 3));
						$objPHPExcel->getActiveSheet()->getStyle($val.$i.':'.$val.$i)->applyFromArray($estilo_numeros);
						$val++; 
					
			
			
			$i++;
			$j++;

					
					
					
					
					
					

		}
						
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Reporte Auditoria.xlsx"');
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');	
		
	
	}

}
?>