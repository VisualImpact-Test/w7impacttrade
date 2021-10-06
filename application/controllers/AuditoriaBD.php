<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuditoriaBD extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('m_auditoriabd');
	}

    public function index(){
        $config['view'] = 'auditoriabd/index';
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
			'assets/custom/js/auditoriabd',
		];
		$config['data']['icon'] = 'fas fa-list-alt';
		$config['data']['title'] = 'Auditoria';
		$config['data']['message'] = 'Aquí encontrará datos de la auditoria en BD.';

        $config['data']['accion'] = $this->m_auditoriabd->obtener_accion();
        $config['data']['usuarios'] = $this->m_auditoriabd->obtener_usuarios();

        $this->view($config);
	}

    public function listaAuditoria(){
        $input = json_decode($this->input->post('data'), true);

        $result = [];
        $data = [];
        $result['result'] = 0;
        $result['url'] = '';
        $result['msg']['title'] = 'Alerta';
        $result['msg']['content'] = '';

        $data['listaResultado'] = $this->m_auditoriabd->listaAuditoria( $input );

		if ( !empty($data['listaResultado'])) {
            $result['result'] = 1;
            $result['data']['html'] = $this->load->view("auditoriabd/reporte", $data, true);
		} else {
			$result['msg']['title'] = 'Auditoria';
			$result['msg']['content'] = '<p class="p-info"><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p>';
		}

		echo json_encode($result);
    }
}