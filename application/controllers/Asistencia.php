<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_asistencia','model');
	}

	public function index(){
		$config = array();
		$config['nav']['menu_active'] = '1';
		$config['css']['style'] = array(
			'assets/custom/css/asistencia'
		);

		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/asistencia'
		);

		$config['data']['icon'] = 'fal fa-clock';
		$config['data']['title'] = 'Asistencia';
		$config['data']['message'] = 'Control de asistencia';
		$config['view']='modulos/asistencia/index';
		
		$this->view($config);
	}

	public function filtrar(){
		$this->aSessTrack[] = [ 'idAccion' => 5 ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		/*===FILTROS===*/
		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['cuenta_filtro'] = $data->{'cuenta_filtro'};
		$input['grupo_filtro'] = $data->{'grupo_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = $data->{'usuario_filtro'};
		$input['plaza_filtro'] = !empty($data->{'plaza_filtro'}) ?$data->{'plaza_filtro'} : '';
		$input['distribuidora_filtro'] = !empty($data->{'distribuidora_filtro'}) ? $data->{'distribuidora_filtro'} : '';
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ?$data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = !empty($data->{'zona_filtro'}) ?$data->{'zona_filtro'} : '';
		$input['cadena_filtro'] = !empty($data->{'cadena_filtro'}) ?$data->{'cadena_filtro'} : '';
		$input['banner_filtro'] = !empty($data->{'banner_filtro'}) ?$data->{'banner_filtro'} : '';
		/*=======*/
		$rs_usuarios = $this->model->obtener_usuarios_asistencia($input);
		$rs_asistencia = $this->model->obtener_asistencias($input);

		$html = '';
		if ( !empty($rs_usuarios)) {
			$result['result'] = 1;
			$array = array();

			foreach ($rs_asistencia as $ka => $row) {
				$array['asistencias'][$row['fecha_id']]['fecha'] = $row['fecha_id'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['idTipoAsistencia'] = $row['idTipoAsistencia'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['tipoAsistencia'] = $row['tipoAsistencia'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['hora'] = $row['hora'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['latitud'] = $row['latitud'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['longitud'] = $row['longitud'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['foto'] = $row['foto'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['idOcurrencia'] = $row['idOcurrencia'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['fecha'] = $row['fecha'];
				$array['asistencias'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][$row['idTipoAsistencia']]['observacion'] = $row['observacion'];
			}
			
			switch ( $data->{'tipoFormato'} ) {
				case 1:
					$result['data']['datatable'] = 'tb-asistenciaDetalle';
					foreach ($rs_usuarios as $kr => $row) {
						$array['listaUsuarios'][$row['fecha']]['fecha'] = $row['fecha'];
						$array['listaUsuarios'][$row['fecha']]['fecha_id'] = $row['fecha_id'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['idEmpleado'] = $row['idEmpleado'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['numDocumento'] = $row['numDocumento'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['usuario'] = $row['usuario'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['tipoUsuario'] = $row['tipoUsuario'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['empresa'] = $row['cuenta'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['departamento'] = $row['departamento'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['provincia'] = $row['provincia'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['distrito'] = $row['distrito'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['grupoCanal'] = $row['grupoCanal'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['canal'] = $row['canal'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['movil'] = $row['movil'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['feriado'] = $row['feriado'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['vacaciones'] = $row['vacaciones'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['ocurrencia'] = $row['ocurrencia'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['horarioIng'] = $row['horarioIng'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['horarioSal'] = $row['horarioSal'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['horaIniVisita'] = $row['horaIniVisita'];
						$array['listaUsuarios'][$row['fecha']]['usuarios'][$row['idUsuario']]['horaFinVisita'] = $row['horaFinVisita'];
					}

					$html .= $this->load->view("modulos/asistencia/asistenciaDetalle", $array, true);

					$result['data']['html'] = $html;
					break;
				case 2:
					
					foreach ($rs_usuarios as $ku => $row) {
						$array['listaUsuarios'][$row['idUsuario']]['idEmpleado'] = $row['idEmpleado'];
						$array['listaUsuarios'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
						$array['listaUsuarios'][$row['idUsuario']]['numDocumento'] = $row['numDocumento'];
						$array['listaUsuarios'][$row['idUsuario']]['usuario'] = $row['usuario'];
						$array['listaUsuarios'][$row['idUsuario']]['tipoUsuario'] = $row['tipoUsuario'];
						$array['listaUsuarios'][$row['idUsuario']]['empresa'] = $row['cuenta'];
						$array['listaUsuarios'][$row['idUsuario']]['ciudad'] = $row['distrito'];
						$array['listaUsuarios'][$row['idUsuario']]['canal'] = $row['canal'];
						$array['listaUsuarios'][$row['idUsuario']]['movil'] = $row['movil'];
						$array['listaUsuarios'][$row['idUsuario']]['fechas'][$row['fecha_id']]['fecha_id'] = $row['fecha_id'];
						$array['listaUsuarios'][$row['idUsuario']]['fechas'][$row['fecha_id']]['feriado'] = $row['feriado'];
						$array['listaUsuarios'][$row['idUsuario']]['fechas'][$row['fecha_id']]['vacaciones'] = $row['vacaciones'];
						$array['listaUsuarios'][$row['idUsuario']]['fechas'][$row['fecha_id']]['ocurrencia'] = $row['ocurrencia'];
						$array['listaUsuarios'][$row['idUsuario']]['fechas'][$row['fecha_id']]['horarioIng'] = $row['horarioIng'];
						$array['listaUsuarios'][$row['idUsuario']]['fechas'][$row['fecha_id']]['horarioSal'] = $row['horarioSal'];
					}

					$rs_tiempo = $this->model->obtener_tiempo($input);
					$notColVis = array();
					$columnas = 11;
					foreach ($rs_tiempo as $kt => $row) {
						$array['tiempo'][$row['idMes']]['idMes'] = $row['idMes'];
						$array['tiempo'][$row['idMes']]['mes'] = $row['mes'];
						$array['tiempo'][$row['idMes']]['dias'][$row['diaFecha']]['idDia'] = $row['idDia'];
						$array['tiempo'][$row['idMes']]['dias'][$row['diaFecha']]['dia'] = $row['dia'];
						$array['tiempo'][$row['idMes']]['dias'][$row['diaFecha']]['fecha'] = $row['fecha'];
						$array['tiempo'][$row['idMes']]['dias'][$row['diaFecha']]['fecha_id'] = $row['fecha_id'];
						$array['tiempo'][$row['idMes']]['dias'][$row['diaFecha']]['fechaFormato'] = $row['fechaFormato'];
						$columnas ++;
						array_push($notColVis,$columnas);
					}
					$html .= $this->load->view("modulos/asistencia/asistenciaConsolidado", $array, true);

					$result['data']['configTable'] =  [];

					$result['data']['views']['idDetalleVertical']['html'] = $html;
					$result['data']['views']['idDetalleVertical']['datatable'] = 'tb-asistenciaConsolidado';
					break;

				case 3:
					foreach ($rs_usuarios as $kr => $row) {
						$array['listaUsuarios'][$row['fecha_id']]['fecha_id'] = $row['fecha_id'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['fecha'] = $row['fecha'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['feriado'] = $row['feriado'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['vacaciones'] = $row['vacaciones'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['ocurrencia'] = $row['ocurrencia'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['horarioIng'] = $row['horarioIng'];
						$array['listaUsuarios'][$row['fecha_id']]['usuarios'][$row['idUsuario']]['horarioSal'] = $row['horarioSal'];
					}
					//
					foreach ($rs_asistencia as $ka => $row) {
						$array['fechas'][$row['fecha_id']] = $row['fechaFormato'];
					}
					//
					$rs_ocurrencia=$this->model->obtener_ocurrencias();
					foreach($rs_ocurrencia as $row){
						$array['ocurrencias'][$row['idOcurrencia']]=$row['ocurrencia'];
					}

					$html .= $this->load->view("modulos/asistencia/asistenciaResumen", $array, true);

					$result['data']['views']['idDetalleGraficas']['html'] = $html;
					break;
				default:
					# code...
					break;
			}

			
		} else {
			$html = getMensajeGestion("noRegistros");

			$result['data']['html'] = $html;
		}

		echo json_encode($result);
	}

	public function mostrarMapa(){
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

	public function mostrarFoto(){
		$result  = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$input=array();
		$input['type'] = $data->{'type'};
		$input['idUsuario'] = $data->{'idUsuario'};
		$input['fecha'] = $data->{'fecha'};
		//
		$foto = $this->model->obtener_foto($input);
		$array['foto']=$foto[0]['fotoUrl'];

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/asistencia/foto", $array, true);

		echo json_encode($result);
	}
}
?>