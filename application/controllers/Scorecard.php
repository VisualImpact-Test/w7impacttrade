<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Scorecard extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_scorecard','model');
	}

	public function index()
	{
		$this->aSessTrack = ['idAccion' => 4];

		$config = array();
		$config['nav']['menu_active'] = '70';
		$config['css']['style'] = array(
			'assets/custom/css/scorecard'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/scorecard'
		);

		$config['data']['icon'] = 'fa fa-chart-line';
		$config['data']['title'] = 'Scorecard';
		$config['data']['message'] = 'Scorecard';
		$config['view'] = 'modulos/scorecard/index';

		$this->view($config);
	}

	public function detallado(){
		ini_set('memory_limit','2048M');
		set_time_limit(0);

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['idCuenta'] = $data->{'cuenta_filtro'};
		$input['idProyecto'] = $data->{'proyecto_filtro'};
		$input['idGrupoCanal'] = $data->{'grupoCanal_filtro'};
		$input['idCanal'] = $data->{'canal_filtro'};

		$array = array();

		$array['fecIni'] = $fechas[0];
		$array['fecFin'] = $fechas[1];

		$canales = $this->model->obtener_canales($input);
		$cartera = $this->model->obtener_cartera($input);
		$visitas = $this->model->obtener_visitas($input);

		$this->aSessTrack = $this->model->aSessTrack;

		foreach($canales as $row){
			$array['grupoCanal'][$row['idGrupoCanal']]['nombre'] = $row['grupoCanal'];
			$array['grupoCanal'][$row['idGrupoCanal']]['rowspan'] = $row['rowspangc'];
			$array['canal'][$row['idGrupoCanal']][$row['idCanal']]['nombre'] = $row['canal'];
			$array['canal'][$row['idGrupoCanal']][$row['idCanal']]['rowspan'] = $row['rowspanc'];
			$array['subcanal'][$row['idGrupoCanal']][$row['idCanal']][$row['idSubCanal']]['nombre'] = $row['subCanal'];
		}

		foreach($cartera as $row){
			$array['carteraObjetivo'][$row['idSubCanal']]= $row['cartera'];
			$array['cartera'][$row['idSubCanal']]= $row['total_subcanal'];
			$array['carteraTotal']= $row['total'];
			
		}
		$array['carteraTotalObjetivo']=0;

		if(!empty($array['carteraObjetivo'])){
			foreach($array['carteraObjetivo'] as $row => $value){
				$array['carteraTotalObjetivo'] = $array['carteraTotalObjetivo']+ $value;
			}
		}
		
		//VISITAS

		$vcliente_efectiva = [];
		$vcliente_incidencia= [];
		$vcliente_noefectiva = [];
		foreach($visitas as $row){
			$array['carteraPlaneada'][$row['idSubCanal']]= $row['total_subcanal'];
			$array['visitaProgramada'][$row['idSubCanal']]= $row['visitas_programadas'];
			if($row['estadoVisita']=='EXCLUSION'){
				$array['carteraExclusion'][$row['idSubCanal']]= $row['total_subcanal'];
				$array['visitaExclusion'][$row['idSubCanal']]= $row['total_subcanal'];
			}
			
			elseif($row['estadoVisita']=='EFECTIVA'){
				$array['carteraCobertura'][$row['idSubCanal']]= $row['cobertura_subcanal'];
				$array['visitaEfectiva'][$row['idSubCanal']]= $row['total_subcanal'];
				$vcliente_efectiva[$row['idSubCanal']][] = $row['idCliente'];
				$vcliente_efectiva['total'][] = $row['idCliente'];
			}

			elseif($row['estadoVisita']=='NO EFECTIVA'){
				$array['visitaNoEfectiva'][$row['idSubCanal']]= $row['total_subcanal'];
				$vcliente_noefectiva[$row['idSubCanal']][] = $row['idCliente'];
				$vcliente_noefectiva['total'][] = $row['idCliente'];
			}

			elseif($row['estadoVisita']=='INCIDENCIA'){
				$array['visitaIncidencia'][$row['idSubCanal']]= $row['total_subcanal'];
				$vcliente_incidencia[$row['idSubCanal']][] = $row['idCliente'];
				$vcliente_incidencia['total'][] = $row['idCliente'];

			}	
		}

		$array['vcliente_efectiva'] = !empty($vcliente_efectiva) ? $vcliente_efectiva : '' ;
		$array['vcliente_noefectiva'] = !empty($vcliente_efectiva) ? $vcliente_noefectiva : '' ;
		$array['vcliente_incidencia'] = !empty($vcliente_incidencia) ? $vcliente_incidencia : '' ;

		$html = getMensajeGestion('noRegistros');

		if ( !empty($canales) OR !empty($cartera) OR !empty($visitas)) {
			$result['result'] = 1;
			$html = $this->load->view("modulos/scorecard/detallado", $array, true);
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}	

	public function detalle_cartera(){
		//$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
		$input['fecIni'] = $data->{'fecIni'};
		$input['fecFin'] = $data->{'fecFin'};
		$input['idsubcanal'] = $data->{'idSubCanal'};
		$input['tipo'] = $data->{'tipo'};
		$input['str_clientes'] = !empty($data->{'str_clientes'}) ?  $data->{'str_clientes'} : '' ;
		$input['grupoCanal'] = !empty($data->{'grupoCanal'}) ?  $data->{'grupoCanal'} : '' ;
		
		$array['cartera'] = $this->model->obtener_cartera_seg($input);
		$this->aSessTrack = $this->model->aSessTrack;
		$html = '';
		if ( !empty($array['cartera'])) {

			$array['segmentacion'] = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal']]);
			$array['usuarios'] = $this->permisos_usuarios($array['segmentacion']['tipoSegmentacion'],$input);

			$result['result'] = 1;
			$html = $this->load->view("modulos/scorecard/detalle_cartera", $array, true);
		} else {
			$html = '<div class="alert alert-danger" role="alert">';
				$html .= '<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.';
			$html .= '</div>';
		}

		$result['data'] = $html;

		echo json_encode($result);
		
	}
	
	public function detalle_visita(){
		//$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
		$input['fecIni'] = $data->{'fecIni'};
		$input['fecFin'] = $data->{'fecFin'};
		$input['idsubcanal'] = $data->{'idSubCanal'};
		$input['tipo'] = $data->{'tipo'};
		$input['grupoCanal'] = !empty($data->{'grupoCanal'}) ?  $data->{'grupoCanal'} : '' ;
		
		$array['cartera'] = $this->model->obtener_visitas_seg($input);
		$this->aSessTrack = $this->model->aSessTrack;
		
		$html = '';
		if ( !empty($array['cartera'])) {

			$array['segmentacion'] = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal']]);
			$array['usuarios'] = $this->permisos_usuarios($array['segmentacion']['tipoSegmentacion'],$input);

			$result['result'] = 1;
			$html = $this->load->view("modulos/scorecard/detalle_visita", $array, true);
		} else {
			$html = '<div class="alert alert-danger" role="alert">';
				$html .= '<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.';
			$html .= '</div>';
		}

		$result['data'] = $html;

		echo json_encode($result);
	}
	public function permisos_usuarios($tipoSegmentacion = '',$input = []){
		$array['usuarios'] = [];
		if($tipoSegmentacion == 'tradicional'){
			$permisos_usuarios = $this->model->obtenerUsuariosPermisosDistribuidoraSucursal($input);
			foreach ($permisos_usuarios as $k => $v) {
				$array['usuarios'][$v['idTipoUsuario']][$v['idDistribuidoraSucursal']] = $v['nombreUsuario'];
			}
		}else if($tipoSegmentacion == 'mayorista'){
			$permisos_usuarios = $this->model->obtenerUsuariosPermisosPlaza($input);
			foreach ($permisos_usuarios as $k => $v) {
				$array['usuarios'][$v['idTipoUsuario']][$v['idPlaza']] = $v['nombreUsuario'];
			}
		}else if($tipoSegmentacion == 'moderno'){
			$permisos_usuarios = $this->model->obtenerUsuariosPermisosBanner($input);
			foreach ($permisos_usuarios as $k => $v) {
				$array['usuarios'][$v['idTipoUsuario']][$v['idBanner']] = $v['nombreUsuario'];
			}
		}

		return $array['usuarios'] ;
	}
	public function mostrarMapa(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		//Datos Generales
		$type = $data->{'type'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'usuario'};
		$array['perfil'] = $data->{'perfil'};
		$array['latitud']= $data->{'latitud'};
		$array['longitud']= $data->{'longitud'};
		$array['latitud_cliente']= $data->{'latitud_cliente'};
		$array['longitud_cliente']= $data->{'longitud_cliente'};

		$result['result'] = 1;
		$result['msg']['title'] = 'GOOGLE MAPS';
		if( $type == 'ini' ){ 
			$result['data'] = $this->load->view("modulos/rutas/verMapa_inicio", $array, true); 
		}
		elseif( $type == 'fin' ){
			$result['data'] = $this->load->view("modulos/rutas/verMapa_fin", $array, true); 
		}

		echo json_encode($result);
	}
}
?>