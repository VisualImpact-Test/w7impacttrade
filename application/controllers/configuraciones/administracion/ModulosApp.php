<?php defined('BASEPATH') or exit('No direct script access allowed');

class ModulosApp extends MY_Controller{

	var $folderView = 'modulos/Configuraciones/Administracion/ModulosApp/';

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/administracion/M_ModulosApp', 'm_modulosApp', true);
    }

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$input = [];
		$input['estado'] = true;

		($this->idTipoUsuario != 4) ? $input['idCuenta'] = $this->sessIdCuenta : ''; 
		

		$config = [
			'nav' => [ 'menu_active' => '123' ],
			'js' => [ 'script' => [ 'assets/custom/js/configuraciones/administracion/modulosApp' ] ],
			'view' => $this->folderView.'index',
			'data' => [
				'icon' => 'fal fa-mobile-alt',
				'title' => 'Módulos App',
				'message' => 'Administrar permisos en los módulos del aplicativo.',
				'aListCuenta' => $this->m_modulosApp->listCuenta($input),
				'aListTipoUsuario' => $this->m_modulosApp->listTipoUsuario(),
			]
		];

		$this->view($config);
	}

	public function consultar(){
		$result = $this->result;
		$input = json_decode($this->input->post('data'), true);

		$query = $this->m_modulosApp->consultar($input);
		$data = [
				'aplicacion' => [],
				'prioridad' => [],
				'cabecera' => [],
				'modulos' => []
			];

		foreach($query as $r){
			$data['aplicacion'][$r['idAplicacion']] = $r['aplicacion'];
			$data['prioridad'][$r['idAplicacion']][$r['idPrioridad']] = $r['prioridad'];

			$data['cabecera'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']]['idTipoUsuario'] = $r['idTipoUsuario'];
			$data['cabecera'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']]['tipoUsuario'] = $r['tipoUsuario'];
			$data['cabecera'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']]['idCanal'] = $r['idCanal'];
			$data['cabecera'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']]['canal'] = $r['canal'];

			$data['modulos'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']][$r['idModuloTipo']]['nombre'] = $r['modulo'];
			$data['modulos'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']][$r['idModuloTipo']]['estado'] = $r['estado'];
			$data['modulos'][$r['idAplicacion']][$r['idPrioridad']][$r['cabecera']][$r['idModuloTipo']]['obligatorio'] = $r['obligatorio'];
		}
		if(!empty($query)){
			$result['data']['view'] = $this->load->view($this->folderView.'reporte', $data, true);
		}else{
			$result['data']['view'] = getMensajeGestion('noRegistros');
		}

		echo json_encode($result);
	}

	public function datos(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);
			$input['estado'] = 1;

			if( !is_array($input['list']) ) $input['list'] = [ $input['list'] ];

			foreach($input['list'] as $list){
				switch($list){
					case 'cuenta':{
						$result['data'][$list] = $this->m_modulosApp->listCuenta($input);
						break;
					}
					case 'aplicacion':{
						$result['data'][$list] = $this->m_modulosApp->listAplicacion($input);
						break;
					}
					case 'canal':{
						$result['data'][$list] = $this->m_modulosApp->listCanal($input);
						break;
					}
					case 'modulos':{
						$result['data'][$list] = $this->m_modulosApp->listModulo($input);
						break;
					}
				}
			}

		echo json_encode($result);
	}

	public function formulario(){
		$result = $this->result;

		$input = [];
		$input['estado'] = true;
		($this->idTipoUsuario != 4) ? $input['idCuenta'] = $this->sessIdCuenta : ''; 

		$data = [
			'aListCuenta' => $this->m_modulosApp->listCuenta($input),
			'aListAplicacion' => $this->m_modulosApp->listAplicacion([ 'estado' => 1 ]),
			'aListModulos' => $this->m_modulosApp->listModulo([ 'estado' => 1 ]),
			'aListTipoUsuario' => $this->m_modulosApp->listTipoUsuario([ 'estado' => 1 ]),
			'aListCanal' => $this->m_modulosApp->listCanal([ 'estado' => 1 ])
		];

		$result['data']['view'] = $this->load->view($this->folderView.'formulario', $data, true);
		$result['data']['width'] = '70%';
		echo json_encode($result);
	}

	public function guardar(){
		$result = $this->result;
		$input = json_decode($this->input->post('data'), true);
		$query = $this->m_modulosApp->guardar($input);

		$result['result'] = $query['status'] != 1 ? 0 : 1;
		$result['msg']['content'] = createMessage([ 'type' => $query['status'], 'message' => $query['msg'] ]);
		echo json_encode($result);
	}

	public function editar(){
		$result = $this->result;
		$input = json_decode($this->input->post('data'), true);
		$query = $this->m_modulosApp->editar($input);

		$result['result'] = $query['status'] != 1 ? 0 : 1;
		$result['msg']['content'] = createMessage([ 'type' => $query['status'], 'message' => $query['msg'] ]);
		echo json_encode($result);
	}

	public function eliminar(){
		$result = $this->result;
		$input = json_decode($this->input->post('data'), true);

		if( empty($input['grupo']) && empty($input['idModuloTipo']) ){
			$result['msg']['content'] = createMessage([ 'type' => 2, 'message' => 'No se identifica los datos a eliminar' ]);
			goto responder;
		}

		$query = $this->m_modulosApp->eliminar($input);

		$result['result'] = $query['status'] != 1 ? 0 : 1;
		$result['msg']['content'] = createMessage([ 'type' => $query['status'], 'message' => $query['msg'] ]);

		responder:
		echo json_encode($result);
	}

}