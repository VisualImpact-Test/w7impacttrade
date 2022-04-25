<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ServicioCobertura extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ServicioCobertura', 'model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '149';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/asistencia'
		);

		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/servicioCobertura'
		);

		$tabs = getTabPermisos(['idMenuOpcion' => $idMenu])->result_array();

		$config['data']['icon'] = 'fas fa-globe-americas';
		$config['data']['title'] = 'Servicio de Cobertura';
		$config['data']['message'] = 'Control de asistencia';
		$config['data']['tabs'] = $tabs;
		$config['view'] = 'modulos/ServicioCobertura/index';

		$this->view($config);
	}

	public function filtrar()
	{
		$this->aSessTrack[] = ['idAccion' => 5];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		// $fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		// $input['fecIni'] = $fechas[0];
		// $input['fecFin'] = $fechas[1];
		/*===FILTROS===*/
		$input['anno_filtro'] = $data->{'anno_filtro'};
		$input['mes_filtro'] = $data->{'mes_filtro'};
		$input['quincena_filtro'] = $data->{'quincena_filtro'};
		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['cuenta_filtro'] = $data->{'cuenta_filtro'};
		$input['grupo_filtro'] = $data->{'grupo_filtro'};
		// $input['canal_filtro'] = $data->{'canal_filtro'};
		// $input['plaza_filtro'] = !empty($data->{'plaza_filtro'}) ? $data->{'plaza_filtro'} : '';
		// $input['distribuidora_filtro'] = !empty($data->{'distribuidora_filtro'}) ? $data->{'distribuidora_filtro'} : '';
		// $input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ? $data->{'distribuidoraSucursal_filtro'} : '';
		// $input['zona_filtro'] = !empty($data->{'zona_filtro'}) ? $data->{'zona_filtro'} : '';
		// $input['cadena_filtro'] = !empty($data->{'cadena_filtro'}) ? $data->{'cadena_filtro'} : '';
		// $input['banner_filtro'] = !empty($data->{'banner_filtro'}) ? $data->{'banner_filtro'} : '';
		// $input['zonausuario'] = !empty($data->{'zonausuario'}) ? $data->{'zonausuario'} : '';

		$input['tipoFormato'] = $data->{'tipoFormato'};
		/*=======*/

		$rs_usuarios = 1;

		$html = '';

		// $this->model->generar_views($input);

		if (!empty($rs_usuarios)) {
			$result['result'] = 1;
			$array = array();

			switch ($data->{'tipoFormato'}) {
				case 1:
					//Cobertura
					$arregloData = $this->model->obtenerResumenCobertura(['tipo' => 1])->result_array();
					$arregloDataDetalle = $this->model->obtenerResumenCobertura(['tipo' => 0])->result_array();
					$arregloDataTotal = $this->model->obtenerResumenCobertura(['tipo' => 2])->row_array();

					$arregloDataH = $this->model->obtenerResumenHoras(['tipo' => 1])->result_array();
					$arregloDataDetalleH = $this->model->obtenerResumenHoras(['tipo' => 0])->result_array();
					$arregloDataTotalH= $this->model->obtenerResumenHoras(['tipo' => 2])->row_array();
					$html .= $this->load->view("modulos/ServicioCobertura/resumen", ['data' => $arregloData, 'dataDetalle' => $arregloDataDetalle, 'dataH' => $arregloDataH, 'dataDetalleH' => $arregloDataDetalleH, 'dataTotal' => $arregloDataTotal, 'dataTotalH' => $arregloDataTotalH], true);

					$result['data']['html'] = $html;
					break;
				case 2:

					// $jsonData = file_get_contents('public/assets/custom/json/baseCobertura.json');
					$arregloData = $this->model->obtenerCobertura();

					$html .= $this->load->view("modulos/ServicioCobertura/cobertura", ['data' => $arregloData], true);

					$result['data']['views']['idDivCobertura']['html'] = $html;
					$result['data']['views']['idDivCobertura']['datatable'] = 'tb-cobertura';
					break;

				case 3:
					$array['quincena'] = $this->model->obtenerQuincena($input);

					$base_servicio = $this->model->obtenerBaseServicio();
					$horas_trabajadas =  $this->model->obtenerDataAsistencia();
					$horas_ruta = [];

					foreach ($horas_trabajadas as $h) {
						$horas_ruta[$h['nombreRuta']][$h['fecha']] = ($h['hora']) >= 8 ? 8 : $h['hora'] ;

						empty($horas_ruta['totales'][$h['nombreRuta']]) ? $horas_ruta['totales'][$h['nombreRuta']] = 0 : '';
						$horas_ruta['totales'][$h['nombreRuta']] += ($h['hora'] >= 8 ? 8 : $h['hora']) ;
					}

					foreach ($base_servicio as $k => $v) {

						$array['data'][] = [
							"CANAL"=> $v["grupoCanal"]
							,"GERENTE"=> $v["gerenteZonal"] 
							,"SPOC"=> $v["supervisor"] 
							,"SUCURSAL"=> $v["sucursal_plaza"] 
							,"IDGTM"=> $v["cod_usuario"] 
							,"DNI"=> $v["numDocumento"] 
							,"GTM_NAME"=> $v["usuario"] 
							,"RUTA"=> $v["nombreRuta"] 
							,"DIAS"=> $v["dias"] 
							,"OBJ_Q"=> $v["obj_q"] 
							,"OBJ_DIARIO"=> $v["obj_diario"] 
							,"EFECTIVIDAD"=> get_porcentaje($v["obj_diario"],$horas_ruta['totales'][$v['nombreRuta']],0).'%' 
							,"HORA_SERVICIO"=> $horas_ruta['totales'][$v['nombreRuta']]
							,"VISITAS_MAYORES"=> get_porcentaje($v['visitasTotales'],$v['visitasMayores'],0).'%' 
							,"EFECTIVIDAD_HORAS"=> get_porcentaje($v['obj_diario'],$v['horas_efectivas'],0).'%'
							,"ALERTA_MARCACION"=> $v["alerta_marcacion"] 
							,"ACUMULADO_MARCACION"=> $v["acumulado_marcacion"] 
							,"ALERTA_GEO"=> $v["alerta_geo"]
							,"ACUMULADO_GEO"=> $v["acumulado_geo"]
							,"fecha" => !empty($horas_ruta[$v["nombreRuta"]]) ? $horas_ruta[$v["nombreRuta"]] : []
							,"fechaMax" => $v['fechaMax']
						];
					}

					$html .= $this->load->view("modulos/ServicioCobertura/servicio", $array, true);

					$result['data']['views']['idDivServicio']['html'] = $html;
					$result['data']['views']['idDivServicio']['datatable'] = 'tb-servicio';
					break;
				case 4:
					$jsonData = file_get_contents('public/assets/custom/json/recuperacion.json');
					$data = $this->model->obtenerDataRecuperacionSpc();
					$arregloData = [];
					foreach ($data as $k => $v) {
						$arregloData[] = [
							"GERENTE" => $v['gerente']
							,"SPOC"=> $v['spoc']
							,"SUCURSAL"=> $v['sucursal']
							,"RUTAS_PENDIENTES_GTM_Q"=> $v['rutas_pendientes']
							,"RUTAS_RECUPERADAS_POR_SPOC"=> ($v['recuperacion_spoc'] >= $v['rutas_pendientes']) ? $v['rutas_pendientes'] : $v['recuperacion_spoc']
							,"RECUPERACION_SPOC"=> (!empty($v['rutas_pendientes']) ? (get_porcentaje($v['rutas_pendientes'],$v['recuperacion_spoc'],0)) >= 100 ? 100 : get_porcentaje($v['rutas_pendientes'],$v['recuperacion_spoc'],0) : 0) . "%"
							,"RUTAS_RECUPERADAS_POR_GZ"=> $v['recuperacion_gz']
							,"RECUPERACION_GZ"=> (!empty($v['rutas_pendientes']) ? (get_porcentaje($v['rutas_pendientes'],$v['recuperacion_gz'],0)) >= 100 ? 100 : get_porcentaje($v['rutas_pendientes'],$v['recuperacion_gz'],0) : 0) . "%"
						];
					}
					$array['data'] = $arregloData;

					$html .= $this->load->view("modulos/ServicioCobertura/recuperacion", $array, true);

					$result['data']['views']['idDivRecuperacion']['html'] = $html;
					$result['data']['views']['idDivRecuperacion']['datatable'] = 'tb-recuperacion';
					break;
				default:
					# code...
					break;
			}
		} else {
			$html = getMensajeGestion("noRegistros");

			switch ($data->{'tipoFormato'}) {
				case 4:
					$result['data']['views']['idDetalleHsm']['html'] = $html;
					break;
				case 5:
					$result['data']['views']['idConsolidadoHsm']['html'] = $html;
					break;
				default:
					$result['data']['html'] = $html;
					break;
			}
		}

		echo json_encode($result);
	}

	public function view_detalle_servicio()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);
		$html = '';
		$array = [];
		switch ($data['tipoDetalle']) {
			
			// case 'alerta_marcacion':
			// case 'acumulado_marcacion':
			// case 'alerta_geo':
			case 'alerta_geo':
				$result['data']['title'] = $data['ruta'];
				$array['data'] = $this->model->get_alerta_geo($data);
				$html .= $this->load->view("modulos/ServicioCobertura/alerta_geo", $array, true);
				break;
			case 'alerta_marcacion':
				$result['data']['title'] = $data['ruta'];
				$array['data'] = $this->model->get_alerta_marcacion($data);
				$html .= $this->load->view("modulos/ServicioCobertura/alerta_marcacion", $array, true);
				break;

			default: break;
		}
		//Result
		$result['result'] = 1;
		$result['data']['width'] = '90%';
		$result['data']['html'] = $html;

		echo json_encode($result);
	}
	public function actualizarData()
	{
		$this->aSessTrack[] = ['idAccion' => 5];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
	
		$input['anno_filtro'] = $data->{'anno_filtro'};
		$input['mes_filtro'] = $data->{'mes_filtro'};
		$input['quincena_filtro'] = $data->{'quincena_filtro'};
		$input['tipoFormato'] = $data->{'tipoFormato'};


		$this->model->generar_views($input);

		$result['result'] = 1;
		$result['data']['width'] = '60%';
		$result['data']['html'] = createMessage(['type' => 1 , 'message' => "Data actualizada <b>{$input['mes_filtro']}/{$input['anno_filtro']}</b>, quincena No. <b>{$input['quincena_filtro']}</b> "]);
		echo json_encode($result);
	}

	public function mostrarMapa()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$type = $data->{'type'};

		$array = array();
		$array['latitud'] = $data->{'latitud'};
		$array['longitud'] = $data->{'longitud'};
		$array['latitud_cliente'] = !empty($data->{'latitud_cliente'}) ? $data->{'latitud_cliente'} : 0;
		$array['longitud_cliente'] = !empty($data->{'longitud_cliente'}) ? $data->{'longitud_cliente'} : 0;

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GOOGLE MAPS';
		$result['data'] = $this->load->view("modulos/asistencia/mapa", $array, true);

		echo json_encode($result);
	}

	public function mostrarFoto()
	{
		$result  = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$input = array();
		$input['type'] = $data->{'type'};
		$input['idUsuario'] = $data->{'idUsuario'};
		$input['fecha'] = $data->{'fecha'};
		//
		$foto = $this->model->obtener_foto($input);
		$array['foto'] = $foto[0]['fotoUrl'];

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/asistencia/foto", $array, true);

		echo json_encode($result);
	}
}
