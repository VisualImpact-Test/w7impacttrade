<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MantenimientoCliente extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_mantenimientoCliente','model');
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '117';
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/mantenimientoCliente'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/custom/js/gestionGerencial/mantenimientoCliente'
		);
		$config['data']['icon'] = 'fas fa-briefcase';
		$config['data']['title'] = 'Mantenimiento Cliente ';
		$config['data']['message'] = 'Mantenimiento Cliente';
		$config['view'] = 'modulos/gestionGerencial/mantenimientoCliente/index';

		$this->view($config);
	}

	public function filtrar()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();

		/*====Filtrado=====*/
		$idCuenta = !empty($this->session->userdata("idCuenta")) ? $this->session->userdata("idCuenta") : "";
		$input['idCuenta'] = $idCuenta;
		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['idTipo'] = $data->{'idTipo'};

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if ( empty($rs_visitas)) {
			$html = getMensajeGestion('noRegistros');
		}else{
			$html = $this->load->view("modulos/gestionGerencial/mantenimientoCliente/detalle_mantenimientoCliente", $array, true);
		}
		$result['result'] = 1;
		$result['data']['views']['idContentMantenimientoCliente']['datatable'] = 'tb-mantenimientoCliente';
		$result['data']['views']['idContentMantenimientoCliente']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					"targets" => [5,6,7,8,10,13,17,18,19,20,21]
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];

		echo json_encode($result);
	}

	public function getFormValidar()
    {
        $result = $this->result;
        $result['msg']['title'] = "Validar Mantenimiento Cliente";

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['data'] = $this->model->obtener_detalle($post)->row_array();


        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/gestionGerencial/mantenimientoCliente/form_validar_matenimientoCliente', $dataParaVista, true);

        echo json_encode($result);
    }


	
	public function validar_mantenimiento_cliente()
    {
        $result = $this->result;
        $result['msg']['title'] = "Actualizar Cliente";

		$post = json_decode($this->input->post('data'), true);

		$params=array();
		$params['idVisitaMantCliente']=$post['idVisitaMantCliente'];

		$this->model->actualizar_mantenimiento_cliente($params);
		
		$actualizo= $this->model->actualizar_cliente_historico($post);


		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		}else{
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}
        echo json_encode($result);
    }


}
?>