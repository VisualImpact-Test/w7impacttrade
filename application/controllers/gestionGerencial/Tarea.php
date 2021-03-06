<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('gestionGerencial/M_tareas', 'model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '135';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/tareas'
		);

		$config['data']['icon'] = 'far fa-clipboard-list-check';
		$config['data']['title'] = 'Tareas';
		$config['data']['message'] = 'Tareas';
		$config['view'] = 'modulos/gestionGerencial/tareas/index';

		$this->view($config);
	}

	public function filtrar()
	{
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
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ? $data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",", $data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '';
		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if (!empty($rs_visitas)) {
			$array = array();
			$array['visitas'] = $rs_visitas;

			$rs_det = $this->model->obtener_detalle_tareas($input);
			foreach ($rs_det as $det) {
				!empty($det['foto']) ? $array['fotos'][$det['idVisita']][$det['idTarea']][] = $det['idVisitaFoto'] : '';
				$array['elementos'][$det['idTarea']] = $det['elemento'];
				$array['detalle'][$det['idVisita']][$det['idTarea']] = $det;
			}

			$rs_lista = $this->model->obtener_lista_tareas($input);
			foreach ($rs_lista as $list) {
				$array['lista'][$list['idVisita']][$list['idTarea']] = '1';
			}

			$segmentacion = getSegmentacion($input);

			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/tareas/detalle_tareas", $array, true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentTareas']['datatable'] = 'tb-tareas';
		$result['data']['views']['idContentTareas']['html'] = $html;
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

	public function mostrarFotos()
	{
		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos"];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$fotos = $data->{'idVisitaFotos'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'usuario'};
		$array['perfil'] = $data->{'perfil'};
		$array['fotos'] = $this->model->obtener_fotos($fotos);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/gestionGerencial/tareas/verFotos", $array, true);

		echo json_encode($result);
	}
}
