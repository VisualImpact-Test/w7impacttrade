<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sugeridos extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_visibilidad','model');
	}

    public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = $idMenu = '147';
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/sugeridos'
		);

		$config['data']['icon'] = 'fas fa-share-alt';
		$config['data']['title'] = 'Sugeridos';
		$config['data']['message'] = 'Sugeridos';
		$config['view'] = 'modulos/gestionGerencial/sugeridos/index';
        $config['data']['tabs']  = $tabs = getTabPermisos(['idMenuOpcion'=>$idMenu])->result_array();
		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
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
		$input['subcanal'] = $data->{'subcanal_filtro'};
		$input['subcanal_filtro'] = empty($data->{'subcanal_filtro'}) ? '' : $data->{'subcanal_filtro'};


		$input['tipoUsuario_filtro'] = empty($data->{'tipoUsuario_filtro'}) ? '' : $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = empty($data->{'usuario_filtro'}) ? '' : $data->{'usuario_filtro'};

		$input['distribuidoraSucursal_filtro'] = empty($data->{'distribuidoraSucursal_filtro'}) ? '' : $data->{'distribuidoraSucursal_filtro'};
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};



		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;

	
			if(empty($rs_det)){
				$html = getMensajeGestion('noRegistros');
				$result['result'] = 0;
				$result['data']['views']['idContentsugeridos']['datatable'] = 'tb-sugeridos';
				$result['data']['views']['idContentsugeridos']['html'] = $html;
				goto respuesta;
			}
			foreach($rs_det as $det){
				$array['categorias'][$det['idCategoria']]=$det['categoria'];
				$array['elementos'][$det['idCategoria']][$det['idElementoVis']]=$det['elemento'];
			}

			$rs_lista=$this->model->obtener_lista_elementos_sugeridos($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idElementoVis']]='1';
			}

			// $array['detalle'] = $rs_det;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			//$html = $this->load->view("modulos/gestionGerencial/sugeridos/detalle_sugeridos",$array,true);
		} else {
			//$html = getMensajeGestion('noRegistros');
			//$html = $this->load->view("modulos/gestionGerencial/sugeridos/detalle_sugeridos",$array,true);
		}
		$array=array();
		$result['result'] = 1;
		$result['data']['views']['idContentSugeridos']['html'] = $this->load->view("modulos/gestionGerencial/sugeridos/detalle_sugeridos",$array,true);
		$result['data']['views']['idContentsugeridos']['datatable'] = 'tb-sugeridos';
		$result['data']['configTable'] = [];

		respuesta:
		echo json_encode($result);
	}


}