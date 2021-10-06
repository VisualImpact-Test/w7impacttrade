<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Surtido extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_surtido','model');
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '130';
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/surtido'
		);

		$config['data']['icon'] = 'fas fa-blender';
		$config['data']['title'] = 'Surtido';
		$config['data']['message'] = 'Detalle Surtido';
		$config['view'] = 'modulos/gestionGerencial/surtido/index';

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$elementos = $this->model->obtener_elementos($params);
		$config['data']['elementos'] = $elementos;

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

			$rs_det=$this->model->obtener_detalle_surtido($input);
			foreach($rs_det as $det){
				$array['categorias'][$det['idCategoria']]=$det['categoria'];
				$array['elementos'][$det['idCategoria']][$det['idProducto']]=$det['elemento'];
			}

			$rs_lista=$this->model->obtener_lista_elementos_surtido($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idProducto']]='1';
			}

			$array['detalle'] = $rs_det;

			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/surtido/detalle_surtido",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentSurtido']['datatable'] = 'tb-visibilidad';
		$result['data']['views']['idContentSurtido']['html'] = $html;
		$result['data']['configTable'] =  [];
	
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
		$result['data'] = $this->load->view("modulos/gestionGerencial/surtido/verFotos", $array, true);

		echo json_encode($result);
    }


	

}
?>