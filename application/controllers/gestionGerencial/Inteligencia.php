<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Inteligencia extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_Inteligencia','model');
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '110';
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/inteligencia'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/inteligencia'
		);

		$config['data']['icon'] = 'fa fa-street-view';
		$config['data']['title'] = 'Inteligencia Competitiva ';
		$config['data']['message'] = 'Lista de Inteligencia Competitiva';
		$config['view'] = 'modulos/gestionGerencial/inteligencia/index';

		$tipos = $this->model->obtener_tipos();
		$config['data']['tipos'] = $tipos;

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
		$input['idTipo'] = $data->{'idTipo'};

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
				$array=array();
				$array['visitas'] = $rs_visitas;
				$rs_det=$this->model->obtener_detalle_inteligencia($input);
				$array['detalle'] = $rs_det;
	
				if(!empty($rs_det)){
					$segmentacion = getSegmentacion($input);
					$array['segmentacion'] = $segmentacion;
					$html = $this->load->view("modulos/gestionGerencial/inteligencia/detalle_inteligencia", $array, true);
				}else{
					$html = getMensajeGestion('noRegistros');
				}
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentInteligencia']['datatable'] = 'tb-inteligencia';
		$result['data']['views']['idContentInteligencia']['html'] = $html;
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
		$result['data'] = $this->load->view("modulos/gestionGerencial/inteligencia/verFotos", $array, true);

		echo json_encode($result);
    }



}
?>