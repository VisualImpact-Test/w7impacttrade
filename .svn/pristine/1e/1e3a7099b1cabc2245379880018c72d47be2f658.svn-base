<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejecucion extends My_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config = array();
		$config['nav']['menu_active'] = '66';
		$config['css']['style'] = array();
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/ejecucion'
		);
		$config['data']['icon'] = 'fa fa-gavel';
		$config['data']['title'] = 'Ejecución Total';
		$config['data']['message'] = 'Reporte de Ejecución Total';
		$config['view'] = 'modulos/ejecucion/index';

		$this->view($config);
	}

	public function filtrar(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;

		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$rs_ejecucion = array(1,2,3);

		$html = '';
		if( !empty($rs_ejecucion) ){
			$result['result'] = 1;
			$array = array();

			switch ( $data->{'tipoFormato'} ) {
				case 1:
					$result['data']['datatable'] = 'tb-ejecucionVisibilidad';
					$html .= $this->load->view("modulos/ejecucion/ejecucionVisibilidad", $array, true);
					break;
				case 2:
					$result['data']['datatable'] = 'tb-ejecucionVisibilidadEO';					
					$html .= $this->load->view("modulos/ejecucion/ejecucionVisibilidadEO", $array, true);
					break;

				case 3:
					$result['data']['datatable'] = 'tb-ejecucionObservacionesEO';
					$html .= $this->load->view("modulos/ejecucion/ejecucionObservacionesEO", $array, true);
					break;
				default:
					break;
			}
		}
		else{
			$html = getMensajeGestion("noRegistros");
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}
}

?>