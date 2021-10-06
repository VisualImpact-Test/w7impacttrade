<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Find extends MY_Controller
{
	var $return = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_find', 'model');
		
	}

	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
        $config['view'] = 'find';
		$config['js']['script'] = array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','find');
		$config['data']['title'] = 'Resultado de búsqueda';
		$config['data']['icon'] = 'fa fa-search';
        
        $id_usuario = $this->session->userdata('idUsuario');
        
        $rs = $this->model->findMenuUsuario($id_usuario);
        
        $total = count($rs->result());
		$config['data']['message'] = 'Se encontraron '.$total.' resultados.';

        $config['data']['data'] = $rs;
		$this->view($config);
    }
    public function filtrado($filtros=''){

        $result = $this->result;
		$data=json_decode($this->input->post('data'));

        $params = array(
            'idUsuario'=>$this->session->userdata('idUsuario'),
            'filtro' => $filtros,
        );
        $array =array();


        $config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
        $config['view'] = 'find';
		$config['js']['script'] = array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','find');
		$config['data']['title'] = 'Resultado de búsqueda';
		$config['data']['icon'] = 'fa fa-search';
        
        $rs = $this->model->filtrado_findMenuUsuario($params);
        
        
        $total = count($rs->result());
		$config['data']['message'] = 'Se encontraron '.$total.' resultados.';

        $config['data']['data'] = $rs;
		$this->view($config);

    }

}
