<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryVision extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_visibilidad','model');
	}

    public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = $idMenu = '144';
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/categoryVision'
		);

		$config['data']['icon'] = 'fas fa-share-alt';
		$config['data']['title'] = 'Category Vision';
		$config['data']['message'] = 'Category Vision';
		$config['view'] = 'modulos/gestionGerencial/categoryVision/index';
        $config['data']['tabs']  = $tabs = getTabPermisos(['idMenuOpcion'=>$idMenu])->result_array();
		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$this->view($config);
	}


}