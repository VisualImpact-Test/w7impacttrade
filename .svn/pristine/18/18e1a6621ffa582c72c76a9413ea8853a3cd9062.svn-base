<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CheckProductos extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_checkproductos','model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '128';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/checkProductos'
		);

		$config['data']['icon'] = 'far fa-clipboard-list-check';
		$config['data']['title'] = 'Check Productos';
		$config['data']['message'] = 'Check Productos';
		$config['view'] = 'modulos/gestionGerencial/checkProducto/index';

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$elementos = $this->model->obtener_elementos($params);
		$config['data']['elementos'] = $elementos;

		$tabs = getTabPermisos(['idMenuOpcion'=>$idMenu])->result_array();
		$config['data']['tabs'] = $tabs;
		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};

		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ?$data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;

			$rs_det=$this->model->obtener_detalle_checklist($input);
			foreach($rs_det as $det){
				$array['categorias'][$det['idCategoria']]=$det['categoria'];
				$array['elementos'][$det['idCategoria']][$det['idProducto']]=$det['elemento'];
				$array['detalle'][$det['idVisita']]=$det;
			}

			$rs_lista=$this->model->obtener_lista_elementos_visibilidad($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idProducto']]='1';
			}

			$segmentacion = getSegmentacion($input);
			
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/checkProducto/detalle_checklist",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentChecklistProductos']['datatable'] = 'tb-checkproductos';
		$result['data']['views']['idContentChecklistProductos']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					// "targets" => [5,6,7,8,9,10]
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];
	
		echo json_encode($result);
	}

	public function mostrarFotos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$idVisita = $data->{'idVisita'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'cliente'};
		$array['perfil'] = $data->{'perfil'};
		$array['fotos'] = $this->model->obtener_fotos($idVisita);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/gestionGerencial/checkProducto/verFotos", $array, true);

		echo json_encode($result);
    }

	public function filtrar_quiebres()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		//Obligandolo
		if(empty($data->{'grupoCanal_filtro'})){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe seleccionar un grupo canal'));
			goto respuesta;
		}

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['quiebre'] = empty($data->{'ch-quiebre'}) ? 0 : 1;

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$rs_quiebres = $this->model->obtener_quiebre($input);

		$html = '';
		$array['quiebres'] = $rs_quiebres;

		if(!empty($rs_quiebres)){
			$array = [];
			$array['quiebres'] = $rs_quiebres;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;

			$html = $this->load->view("modulos/gestionGerencial/checkProducto/detalle_quiebres",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentQuiebres']['datatable'] = 'tb-quiebres';
		$result['data']['views']['idContentQuiebres']['html'] = $html;
		$result['data']['configTable'] =  [];
	
		respuesta:
		echo json_encode($result);
	}
	public function filtrar_fifo()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		//Obligandolo
		if(empty($data->{'grupoCanal_filtro'})){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe seleccionar un grupo canal'));
			goto respuesta;
		}

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		// $input['quiebre'] = empty($data->{'ch-quiebre'}) ? 0 : 1;

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$rs_quiebres = $this->model->obtener_fifo($input);

		$html = '';
		$array['quiebres'] = $rs_quiebres;

		if(!empty($rs_quiebres)){
			$array = [];
			$array['quiebres'] = $rs_quiebres;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;

			$html = $this->load->view("modulos/gestionGerencial/checkProducto/detalle_fifo",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentFifo']['datatable'] = 'tb-fifo';
		$result['data']['views']['idContentFifo']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					"targets" => []
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];
	
		respuesta:
		echo json_encode($result);
	}
}
?>