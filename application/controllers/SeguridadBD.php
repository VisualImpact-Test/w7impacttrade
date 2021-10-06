<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeguridadBD extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('m_seguridadbd');
	}

    public function index(){
        $config['view'] = 'seguridadbd/index';
        // $config['single'] = true;
        $config['nav']['menu_active']='5';
		$config['css']['style'] = [
			'assets/libs/datatables/dataTables.bootstrap4.min',
			'assets/libs/datatables/buttons.bootstrap4.min',
		];
		$config['js']['script'] = [
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/core/anyChartCustom',
			'assets/custom/js/seguridadbd',
		];
		$config['data']['icon'] = 'fas fa-lock';
		$config['data']['title'] = 'Seguridad';
		$config['data']['message'] = 'Aquí encontrará datos del reporte de SEGURIDAD en BD.';

        $config['data']['usuarios'] = $this->m_seguridadbd->obtener_usuarios();

        $this->view($config);
	}

    public function listaSeguridad(){
        $input = json_decode($this->input->post('data'), true);

        $result = [];
        $data = [];
        $result['result'] = 0;
        $result['url'] = '';
        $result['msg']['title'] = 'Alerta';
        $result['msg']['content'] = '';

        $data['listaResultado'] = $this->m_seguridadbd->listaIntentos( $input );

		if ( !empty($data['listaResultado'])) {
            $result['result'] = 1;
            $result['data']['html'] = $this->load->view("seguridadbd/reporte", $data, true);
		} else {
			$result['msg']['title'] = 'Seguridad';
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'No se generó ningún resultado']);
		}

		echo json_encode($result);
    }
}