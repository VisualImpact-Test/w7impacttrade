<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_tracking','model');
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active']='142';
		$config['css']['style']=array(
		 'assets/custom/css/rutas'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min'
			,'assets/custom/js/core/datatables-defaults'
			,'assets/custom/js/tracking'
		);

		$config['data']['icon'] = 'fa fa-street-view';
		$config['data']['title'] = 'Tracking';
		$config['data']['message'] = 'Geolocalicacion de los puntos visitados.';
		$config['view'] = 'modulos/tracking/index';
		$rutaHoy = $this->model->getLatestRuta();
		$config['data']['tipoUsuarioRuta'] = !empty($rutaHoy['idTipoUsuario']) ? $rutaHoy['idTipoUsuario'] : '';
		$config['data']['usuarioRuta'] = !empty($rutaHoy['idUsuario']) ? $rutaHoy['idUsuario'] : '' ;

		$this->view($config);
	}
	
	
	public function filtrar(){
		ini_set('memory_limit','2048M');
		set_time_limit(0);
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		
        if( empty($this->sessIdCuenta) && empty($this->sessIdProyecto) ){
			$html = getMensajeGestion('noCuentaProyecto');

			$result['data']['views']['idContentRutas']['html'] = $html;
			$result['data']['views']['idContentGeneral']['html'] = $html;
			$result['data']['views']['idContentRegional']['html'] = $html;
			$result['data']['views']['idContentCanal']['html'] = $html;

            goto responder;
        }

		$input = array();
		$input['fecIni'] = $data->{'txt-fechas_simple'};
		$input['fecFin'] = $data->{'txt-fechas_simple'};
		
		/*====Filtrado=====*/
		
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro_tipo'}) ?  $data->{'usuario_filtro_tipo'} : '' ;

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		if ( !empty($rs_visitas) ) {
			$result['result'] = 1;
			$array = array();
			$fotos_visita = $this->model->obtener_fotos_visita($input);

			foreach($fotos_visita as $f){
				$array['fotos'][$f['idVisita']][$f['idVisitaFoto']] = $f;
				$array['fotos'][$f['idVisita']]['cantFotos'] = $f['cantFotos'];
			}
			//
			$puntos=array();
			$usuario = [];
			$ruta = array();
	        $j=0;
			$total = count($rs_visitas);
	        foreach ($rs_visitas as $row) {

				$usuario['fecha'] = !empty($row['fecha']) ? $row['fecha'] : '' ;
				$usuario['nombre'] = !empty($row['nombreUsuario']) ? $row['nombreUsuario'] : '' ;

				$usuario['horaIni_primera_visita'] = !empty($row['horaIni_primera_visita']) ? $row['horaIni_primera_visita'] : '' ;
				$usuario['horaFin_primera_visita'] = !empty($row['horaFin_primera_visita']) ? $row['horaFin_primera_visita'] : '' ;

				$usuario['horaIni_ultima_visita'] = !empty($row['horaIni_ultima_visita']) ? $row['horaIni_ultima_visita'] : '' ;
				$usuario['horaFin_ultima_visita'] = !empty($row['horaFin_ultima_visita']) ? $row['horaFin_ultima_visita'] : '' ;
				$usuario['programados'] = $total;
				$usuario['visitados'] = $row['visitados'];
				$usuario['incidencias'] = $row['incidencias'];

					$puntos[$j]['idVisita']=$row['idVisita'];
					$puntos[$j]['idAsignacion']=$j;
					$puntos[$j]['fecha']=!empty($row['fecha']) ? date_change_format($row['fecha']) : '' ;
					$puntos[$j]['direccion']= !empty($row['direccion']) ? $row['direccion'] : '' ;
					$puntos[$j]['destino']=$row['razonSocial'];
					$puntos[$j]['latitud']=!empty($row['lati_ini']) ? $row['lati_ini'] : $row['latitud'];
					$puntos[$j]['longitud']=!empty($row['long_ini']) ? $row['long_ini'] : $row['longitud'] ;
					$puntos[$j]['hora']=!empty($row['hora_ini'])? $row['hora_ini'] : '-';
					$puntos[$j]['hora_fin']=!empty($row['hora_fin'])? $row['hora_fin'] : '-';

					$gpsIni = ((empty($row['lati_ini']) || $row['lati_ini'] == 0 || empty($row['long_ini']) || $row['long_ini'] == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $row['lati_ini'] . '" data-longitud="' . $row['long_ini'] . '" data-latitud-cliente="' . $row['latitud'] . '" data-longitud-cliente="' . $row['longitud'] . '" data-type="ini" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
					$puntos[$j]['gpsIni'] = $gpsIni;
					
					$m_distance =  (distance($row['lati_ini'],$row['long_ini'],$row['latitud'],$row['longitud'],'K'));
					$puntos[$j]['distance'] = kmtom($m_distance);
					if(($m_distance*1000) >= 100){
						$puntos[$j]['fuera_de_rango'] = 1;
					}else{
						$puntos[$j]['fuera_de_rango'] = 0;
					}
					$puntos[$j]['primera_visita']= ($row['hora_ini'] == $row['horaIni_primera_visita']) ? 1 : 0;
					$puntos[$j]['ultima_visita'] = ($row['hora_ini'] == $row['horaIni_ultima_visita']) ? 1 : 0 ;

					$i = 0 ;
					if(!empty($array['fotos'][$row['idVisita']])){
						$cantidadFotos = $array['fotos'][$row['idVisita']]['cantFotos'];
							foreach ( $array['fotos'][$row['idVisita']] as $k => $vf) {
								if(!empty($vf['idVisitaFoto'])){
									
								if($i == 3){
									break;
								}
								
								$puntos[$j]['foto'.$i]['ruta'] = "{$vf['carpetaFoto']}/{$vf['fotoUrl']}";
								$puntos[$j]['foto'.$i]['foto'] = "{$vf['fotoUrl']}";
								$puntos[$j]['foto'.$i]['carpeta'] = "{$vf['carpetaFoto']}";
								
								$i++;
							}
						}
					}
					$puntos[$j]['cantFotos'] = $i;

					if($row['PDV_EFECTIVO'] == 1) $puntos[$j]['accion']='efectivo';
					else {
						if($row['idTipoIncidencia'] != 0) $puntos[$j]['accion']='incidencia';
						if($row['idTipoIncidencia'] != 0) $puntos[$j]['incidencia']=$row['indicencia_nombre'];
						else {
							$puntos[$j]['accion']='sinvisita';
							
						}
					}
						
					if($row['PDV_EFECTIVO'] == 1) $puntos[$j]['accion']='efectivo';

					if(!empty($row['hora_ini']) || !empty($row['idTipoIncidencia'])){

						$ruta[$j]['primero']= $puntos[$j]['primera_visita'];
						$ruta[$j]['ultimo']=0;
						$ruta[$j]['latitud']=!empty($row['lati_ini']) ? $row['lati_ini'] : $row['latitud'];
						$ruta[$j]['longitud']=!empty($row['long_ini']) ? $row['long_ini'] : $row['longitud'] ;
						
						if($puntos[$j]['ultima_visita'] == true){
							$ruta[$j]['ultimo']=1;
							if(!empty($row['hora_ini']) && empty($row['hora_fin'])) $puntos[$j]['accion']='encurso';
						}
					}
							
					$j++;

	        } 
			
			$array=array();
			$array['destinos'] = $puntos;
			$array['geolocalizacion'] = $ruta;
			$array['usuario'] = $usuario;
			//
			$html .= $this->load->view("modulos/tracking/seguimiento", $array, true);
			$result['data']['html'] = $html;
			
		} else {
			$html .= getMensajeGestion('noRegistros');

			$result['data']['views']['idContentRutas']['html'] = $html;
			$result['data']['views']['idContentGeneral']['html'] = $html;
			$result['data']['views']['idContentRegional']['html'] = $html;
			$result['data']['views']['idContentCanal']['html'] = $html;
			$result['data']['html'] = $html;
		}
		$result['result'] = 1;
        responder:
		echo json_encode($result);
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