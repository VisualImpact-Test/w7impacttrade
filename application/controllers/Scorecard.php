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

		for ($i=1; $i <= 3; $i++) { 
			$permisos = getPermisosUsuario(['segmentacion' => $i]);
			if(!empty($permisos)){
				break;
			}
		}

		$config['data']['permisos'] = empty($permisos) ? '-- Grupo Canal --' : false;
		

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

		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['idGrupoCanal']]);
		$array['segmentacion'] = $segmentacion;
		$this->aSessTrack = $this->model->aSessTrack;

		foreach($canales as $row){
			$array['grupoCanal'][$row['idGrupoCanal']]['nombre'] = $row['grupoCanal'];
			$array['grupoCanal'][$row['idGrupoCanal']]['rowspan'] = $row['rowspangc'];
			$array['canal'][$row['idGrupoCanal']][$row['idCanal']]['nombre'] = $row['canal'];
			$array['canal'][$row['idGrupoCanal']][$row['idCanal']]['rowspan'] = $row['rowspanc'];
			$array['subcanal'][$row['idGrupoCanal']][$row['idCanal']][$row['idSubCanal']]['nombre'] = $row['subCanal'];
		}

		foreach($cartera as $row){
			$array['carteraObjetivo'][$row['idCanal']][$row['idSubCanal']]= $row['cartera'];
			$array['carteraObjetivo2'][$row['idSubCanal']]= $row['cartera'];
			$array['cartera'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
			$array['carteraTotal']= $row['total'];
			
		}
		$array['carteraTotalObjetivo']=0;

		if(!empty($array['carteraObjetivo2'])){
			foreach($array['carteraObjetivo2'] as $row => $value){
				$array['carteraTotalObjetivo'] = $array['carteraTotalObjetivo']+ $value;
			}
		}
		
		//VISITAS
		/* Arreglos donde guardaremos los ID de clientes o visitas para el modal*/
		$vcliente_efectiva = [];
		$vcliente_incidencia= [];
		$vcliente_noefectiva = [];
		
		$vruta_efectiva = [];
		$vruta_incidencia = [];
		$vruta_noefectiva = [];
		$vruta_programada = [];
		$vruta_excluida = [];
		$vruta_habiles = [];

		$vruta_programada_total = [];
		$vruta_excluida_total = [];
		$vruta_habiles_total = [];
		$vruta_efectiva_total = [];
		$vruta_noefectiva_total = [];
		$vruta_incidencia_total = [];
		/* */
		
		foreach($visitas as $row){
			$array['carteraPlaneada'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
			$array['visitaProgramada'][$row['idCanal']][$row['idSubCanal']]= $row['visitas_programadas'];
			$vruta_programada[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];
			
			$vruta_programada_total[] = $row['idVisita'];
			
			
			if($row['estadoVisita']=='EXCLUSION'){
				$array['carteraExclusion'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
				$array['visitaExclusion'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
				$vruta_excluida[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];

				$vruta_excluida_total[] = $row['idVisita'];

			}
			
			elseif($row['estadoVisita']=='EFECTIVA'){
				$array['carteraCobertura'][$row['idCanal']][$row['idSubCanal']]= $row['cobertura_subcanal'];
				$array['visitaEfectiva'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
				$vcliente_efectiva[$row['idCanal']][$row['idSubCanal']][] = $row['idCliente'];
				$vcliente_efectiva['total'][] = $row['idCliente'];
				$vruta_efectiva[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];

				$vruta_efectiva_total[] = $row['idVisita'];
				$vruta_habiles[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];
				$vruta_habiles_total[] = $row['idVisita'];
			}

			elseif($row['estadoVisita']=='NO EFECTIVA'){
				$array['visitaNoEfectiva'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
				$vcliente_noefectiva[$row['idCanal']][$row['idSubCanal']][] = $row['idCliente'];
				$vcliente_noefectiva['total'][] = $row['idCliente'];
				$vruta_noefectiva[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];

				$vruta_noefectiva_total[] = $row['idVisita'];
				$vruta_habiles[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];
				$vruta_habiles_total[] = $row['idVisita'];
			}

			elseif($row['estadoVisita']=='INCIDENCIA'){
				$array['visitaIncidencia'][$row['idCanal']][$row['idSubCanal']]= $row['total_subcanal'];
				$vcliente_incidencia[$row['idCanal']][$row['idSubCanal']][] = $row['idCliente'];
				$vcliente_incidencia['total'][] = $row['idCliente'];
				$vruta_incidencia[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];

				$vruta_incidencia_total[] = $row['idVisita'];
				$vruta_habiles[$row['idCanal']][$row['idSubCanal']][] = $row['idVisita'];
				$vruta_habiles_total[] = $row['idVisita'];
			}	
		}
		//Clientes
		$array['vcliente_efectiva'] = !empty($vcliente_efectiva) ? $vcliente_efectiva : '' ;
		$array['vcliente_noefectiva'] = !empty($vcliente_efectiva) ? $vcliente_noefectiva : '' ;
		$array['vcliente_incidencia'] = !empty($vcliente_incidencia) ? $vcliente_incidencia : '' ;

		//Visitas
		$array['vruta_programada'] = !empty($vruta_programada) ? $vruta_programada : '' ;
		$array['vruta_excluida'] = !empty($vruta_excluida) ? $vruta_excluida : '' ;
		$array['vruta_habiles'] = !empty($vruta_habiles) ? $vruta_habiles : '' ;
		$array['vruta_efectiva'] = !empty($vruta_efectiva) ? $vruta_efectiva : '' ;
		$array['vruta_noefectiva'] = !empty($vruta_noefectiva) ? $vruta_noefectiva : '' ;
		$array['vruta_incidencia'] = !empty($vruta_incidencia) ? $vruta_incidencia : '' ;

		$array['vruta_programada_total'] = !empty($vruta_programada_total) ? $vruta_programada_total : '' ;
		$array['vruta_habiles_total'] = !empty($vruta_habiles_total) ? $vruta_habiles_total : '' ;
		$array['vruta_excluida_total'] = !empty($vruta_excluida_total) ? $vruta_excluida_total : '' ;
		$array['vruta_efectiva_total'] = !empty($vruta_efectiva_total) ? $vruta_efectiva_total : '' ;
		$array['vruta_noefectiva_total'] = !empty($vruta_noefectiva_total) ? $vruta_noefectiva_total : '' ;
		$array['vruta_incidencia_total'] = !empty($vruta_incidencia_total) ? $vruta_incidencia_total : '' ;


		$html = getMensajeGestion('noRegistros');

		if ( !empty($canales) OR !empty($cartera) OR !empty($visitas)) {
			$result['result'] = 1;
			$html = $this->load->view("modulos/scorecard/detallado", $array, true);
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}	

	public function detalle_cartera(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
		$input['fecIni'] = $data->{'fecIni'};
		$input['fecFin'] = $data->{'fecFin'};
		$input['idsubcanal'] = $data->{'idSubCanal'};
		$input['tipo'] = $data->{'tipo'};
		$input['str_clientes'] = !empty($data->{'str_clientes'}) ?  $data->{'str_clientes'} : '' ;
		$input['idGrupoCanal'] = !empty($data->{'grupoCanal'}) ?  $data->{'grupoCanal'} : '' ;
		$input['idCanal'] = !empty($data->{'canal'}) ?  $data->{'canal'} : '' ;
		$input['flagTotal'] = !empty($data->{'flagTotal'}) ?  $data->{'flagTotal'} : '' ;
		$array['cartera'] = $this->model->obtener_cartera_seg($input);
		$this->aSessTrack = $this->model->aSessTrack;
		$html = '';
		if ( !empty($array['cartera'])) {

			if(empty($input['flagTotal']))
			{
				$array['segmentacion'] = getSegmentacion(['grupoCanal_filtro' => $input['idGrupoCanal']]);
				$array['usuarios'] = $this->permisos_usuarios($array['segmentacion']['tipoSegmentacion'],$input);
			}

			if(!empty($input['flagTotal']))
			{
				$array['segmentacion']['headers'] = [['header' => 'Distribuidora', 'columna' => 'distribuidora', 'align' => 'left'],
				['header' => 'Sucursal', 'columna' => 'ciudadDistribuidoraSuc', 'align' => 'left'],
				['header' => 'Zona', 'columna' => 'zona', 'align' => 'left'],
				['header' => 'Plaza', 'columna' => 'plaza', 'align' => 'left']	
				];
				$array['segmentacion']['tipoSegmentacion'] = [[0=> 'tradicional'],[1=>'mayorista']];
				$array['usuarios'] = $this->permisos_usuarios_multi(['tipoSegmentacion' => [0=> 'tradicional', 1=>'mayorista'], 'fecIni'=>$input['fecIni'],'fecFin'=> $input['fecFin']]);

			}

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
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
		$input['fecIni'] = $data->{'fecIni'};
		$input['fecFin'] = $data->{'fecFin'};
		$input['idsubcanal'] = $data->{'idSubCanal'};
		$input['tipo'] = $data->{'tipo'};
		$input['idGrupoCanal'] = !empty($data->{'grupoCanal'}) ?  $data->{'grupoCanal'} : '' ;
		$input['idCanal'] = !empty($data->{'canal'}) ?  $data->{'canal'} : '' ;
		
		$input['flagTotal'] = !empty($data->{'flagTotal'}) ?  $data->{'flagTotal'} : '' ;
		$input['str_visitas'] = !empty($data->{'str_visitas'}) ?  $data->{'str_visitas'} : '' ;
		
		$array['cartera'] = $this->model->obtener_visitas_seg($input);
		$this->aSessTrack = $this->model->aSessTrack;
		
		$html = '';
		if ( !empty($array['cartera'])) {

			if(empty($input['flagTotal']))
			{
				$array['segmentacion'] = getSegmentacion(['grupoCanal_filtro' => $input['idGrupoCanal']]);
				$array['usuarios'] = $this->permisos_usuarios($array['segmentacion']['tipoSegmentacion'],$input);
			}

			if(!empty($input['flagTotal']))
			{
				$array['segmentacion']['headers'] = [['header' => 'Distribuidora', 'columna' => 'distribuidora', 'align' => 'left'],
				['header' => 'Sucursal', 'columna' => 'ciudadDistribuidoraSuc', 'align' => 'left'],
				['header' => 'Zona', 'columna' => 'zona', 'align' => 'left'],
				['header' => 'Plaza', 'columna' => 'plaza', 'align' => 'left']	
				];
				$array['segmentacion']['tipoSegmentacion'] = [[0=> 'tradicional'],[1=>'mayorista']];
				$array['usuarios'] = $this->permisos_usuarios_multi(['tipoSegmentacion' => [0=> 'tradicional', 1=>'mayorista'], 'fecIni'=>$input['fecIni'],'fecFin'=> $input['fecFin']]);

			}

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
				$array['usuarios']['tradicional'][$v['idTipoUsuario']][$v['idDistribuidoraSucursal']] = $v['nombreUsuario'];
			}
		}else if($tipoSegmentacion == 'mayorista'){
			$permisos_usuarios = $this->model->obtenerUsuariosPermisosPlaza($input);
			foreach ($permisos_usuarios as $k => $v) {
				$array['usuarios']['mayorista'][$v['idTipoUsuario']][$v['idPlaza']] = $v['nombreUsuario'];
			}
		}else if($tipoSegmentacion == 'moderno'){
			$permisos_usuarios = $this->model->obtenerUsuariosPermisosBanner($input);
			foreach ($permisos_usuarios as $k => $v) {
				$array['usuarios']['moderno'][$v['idTipoUsuario']][$v['idBanner']] = $v['nombreUsuario'];
			}
		}

		return $array['usuarios'] ;
	}
	public function permisos_usuarios_multi($input = []){
		$array['usuarios'] = [];

		foreach ($input['tipoSegmentacion'] as $k => $tipo) {
			$tipoSegmentacion = $tipo;
			if($tipoSegmentacion == 'tradicional')
			{
				$permisos_usuarios = $this->model->obtenerUsuariosPermisosDistribuidoraSucursal($input);
				foreach ($permisos_usuarios as $k => $v) {
					$array['usuarios']['tradicional'][$v['idTipoUsuario']][$v['idDistribuidoraSucursal']] = $v['nombreUsuario'];
				}
			} 
			if($tipoSegmentacion == 'mayorista')
			{
				$permisos_usuarios = $this->model->obtenerUsuariosPermisosPlaza($input);
				foreach ($permisos_usuarios as $k => $v) {
					$array['usuarios']['mayorista'][$v['idTipoUsuario']][$v['idPlaza']] = $v['nombreUsuario'];
				}
			} 
			if($tipoSegmentacion == 'moderno')
			{
				$permisos_usuarios = $this->model->obtenerUsuariosPermisosBanner($input);
				foreach ($permisos_usuarios as $k => $v) {
					$array['usuarios']['moderno'][$v['idTipoUsuario']][$v['idBanner']] = $v['nombreUsuario'];
				}
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