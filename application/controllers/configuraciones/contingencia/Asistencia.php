<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/contingencia/m_contingenciaasistencia','model');
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config = array();
		$config['nav']['menu_active'] = '53';
		$config['css']['style'] = array(
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/custom/css/configuraciones/contingencia/estilos'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/configuraciones/contingencia/asistencia'
		);

		$config['data']['icon'] = 'fa fa-clock';
		$config['data']['title'] = 'Contingencia Asistencia';
		$config['data']['message'] = 'Lista de Gtm';
		$config['view'] = 'modulos/configuraciones/contingencia/asistencia/index';

		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
		$input['fecha'] = $data->{'txt-fechas_simple'};

		$input['cuenta_filtro'] = $data->{'cuenta_filtro'};
		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['usuario_dni'] = $data->{'usuario_dni'};
		$input['usuario_nombre'] = $data->{'usuario_nombre'};

		$rs_usuarios = $this->model->obtener_usuarios_asistencia($input);

		$html = '';

		if ( !empty($rs_usuarios) ) {
			$result['result'] = 1;
			$array = array();

			$rs_ocurrencias = $this->model->obtener_ocurrencias();
			$array['listaOcurrencias'] = $rs_ocurrencias;

			$rs_tipoAsistencia = $this->model->obtener_tipo_asistencia($input);
			foreach ($rs_tipoAsistencia as $ka => $tipoAsistencia) {
				$array['tipoAsistencias'][$tipoAsistencia['idTipoAsistencia']]['idTipoAsistencia'] = $tipoAsistencia['idTipoAsistencia'];
				$array['tipoAsistencias'][$tipoAsistencia['idTipoAsistencia']]['asistencia'] = $tipoAsistencia['nombre'];

				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['idCuenta'] = $tipoAsistencia['idCuenta'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['cuenta'] = $tipoAsistencia['cuenta'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['proyectos'][$tipoAsistencia['idProyecto']]['idProyecto'] = $tipoAsistencia['idProyecto'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['proyectos'][$tipoAsistencia['idProyecto']]['proyecto'] = $tipoAsistencia['proyecto'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['proyectos'][$tipoAsistencia['idProyecto']]['tipoUsuarios'][$tipoAsistencia['idTipoUsuario']]['idTipoUsuario'] = $tipoAsistencia['idTipoUsuario'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['proyectos'][$tipoAsistencia['idProyecto']]['tipoUsuarios'][$tipoAsistencia['idTipoUsuario']]['tipoUsuario'] = $tipoAsistencia['tipoUsuario'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['proyectos'][$tipoAsistencia['idProyecto']]['tipoUsuarios'][$tipoAsistencia['idTipoUsuario']]['tipoAsistencias'][$tipoAsistencia['idTipoAsistencia']]['idTipoAsistencia'] = $tipoAsistencia['idTipoAsistencia'];
				$array['tipoAsistenciasUsuarios'][$tipoAsistencia['idCuenta']]['proyectos'][$tipoAsistencia['idProyecto']]['tipoUsuarios'][$tipoAsistencia['idTipoUsuario']]['tipoAsistencias'][$tipoAsistencia['idTipoAsistencia']]['asistencia'] = $tipoAsistencia['nombre'];
			}

			foreach ($rs_usuarios as $ku => $row) {
				$array['listaUsuarios'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
				$array['listaUsuarios'][$row['idUsuario']]['fecha'] = $row['fecha'];
				$array['listaUsuarios'][$row['idUsuario']]['idCuenta'] = $row['idCuenta'];
				$array['listaUsuarios'][$row['idUsuario']]['idProyecto'] = $row['idProyecto'];
				$array['listaUsuarios'][$row['idUsuario']]['proyecto'] = $row['proyecto'];
				$array['listaUsuarios'][$row['idUsuario']]['grupoCanal'] = $row['grupoCanal'];
				$array['listaUsuarios'][$row['idUsuario']]['canal'] = $row['canal'] ;
				$array['listaUsuarios'][$row['idUsuario']]['encargado'] = $row['encargado'];
				$array['listaUsuarios'][$row['idUsuario']]['departamento'] = $row['departamento'];
				$array['listaUsuarios'][$row['idUsuario']]['idTipoUsuario'] = $row['idTipoUsuario'];
				$array['listaUsuarios'][$row['idUsuario']]['perfil'] = $row['tipoUsuario'];
				$array['listaUsuarios'][$row['idUsuario']]['codUsuario'] = $row['idUsuario'];
				$array['listaUsuarios'][$row['idUsuario']]['codEmpleado'] = $row['idEmpleado'];
				$array['listaUsuarios'][$row['idUsuario']]['dni'] = $row['numDocumento'];
				$array['listaUsuarios'][$row['idUsuario']]['nombreUsuario'] = $row['nombreUsuario'];
				$array['listaUsuarios'][$row['idUsuario']]['movil'] = $row['movil'];
				$array['listaUsuarios'][$row['idUsuario']]['horarioIng'] = $row['horarioIng'];
				$array['listaUsuarios'][$row['idUsuario']]['horarioSal'] = $row['horarioSal'];

				$array['listaUsuarios'][$row['idUsuario']]['tipoAsistencias'][$row['idTipoAsistencia']]['idTipoAsistencia'] = $row['idTipoAsistencia'];
				$array['listaUsuarios'][$row['idUsuario']]['tipoAsistencias'][$row['idTipoAsistencia']]['hora'] = $row['hora'];
				$array['listaUsuarios'][$row['idUsuario']]['tipoAsistencias'][$row['idTipoAsistencia']]['flagContingencia'] = $row['flagContingencia'];
				$array['listaUsuarios'][$row['idUsuario']]['tipoAsistencias'][$row['idTipoAsistencia']]['idOcurrencia'] = $row['idOcurrencia'];
				$array['listaUsuarios'][$row['idUsuario']]['tipoAsistencias'][$row['idTipoAsistencia']]['ocurrencia'] = $row['ocurrencia'];
				
			}

			$html .= $this->load->view("modulos/configuraciones/contingencia/asistencia/CtnAsistenciaDetalle", $array, true);
			$result['data']['html'] = $html;
			$result['data']['datatable'] = 'tb-contingenciaAsistenciaDetalle';
		} else {
			$html = getMensajeGestion('noRegistros');

			$result['data']['html'] = $html;
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarUsuarioAsistencia(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$idUsuario = $data->{'usuario'};
		$dataAsistencias = $data->{'dataAsistencias'};
		$content = ''; $arrayText = array();

		if ( !empty($dataAsistencias)) {
			foreach ($dataAsistencias as $ka => $asistencias) {
				$arrayInsert = array(
					'idUsuario' => $idUsuario
					,'fecha' => !empty($asistencias->{'fecha'}) ? $asistencias->{'fecha'} : NULL
					,'hora' => !empty($asistencias->{'hora'}) ? $asistencias->{'hora'} : NULL
					,'nombreUsuario' => !empty($asistencias->{'nombreUsuario'}) ? $asistencias->{'nombreUsuario'} : NULL
					,'idTipoUsuario' => !empty($asistencias->{'tipoUsuario'}) ? $asistencias->{'tipoUsuario'} : NULL
					,'tipoUsuario' => !empty($asistencias->{'perfil'}) ? $asistencias->{'perfil'} : NULL
					,'numDocumento' => !empty($asistencias->{'numDocumento'}) ? $asistencias->{'numDocumento'} : NULL
					,'demo' => 1
					,'flagContingencia' => 1
					,'idOcurrencia' => !empty($asistencias->{'ocurrencia'}) ? $asistencias->{'ocurrencia'} : NULL
					,'idTipoAsistencia' => !empty($asistencias->{'tipoAsistencia'}) ? $asistencias->{'tipoAsistencia'} : NULL
				);

				$insertarAsistencia = $this->model->insertar_detalle_asistencia($arrayInsert);
				if ( $insertarAsistencia  ) {
					//AUDITORIA
					$arrayAuditoria = array(
						'idUsuario' => $this->idUsuario
						,'accion' => 'GUARDAR'
						,'tabla' => "ImpactTrade_bd.trade.data_asistencia"
						,'sql' => $this->db->last_query()
					);
					guardarAuditoria($arrayAuditoria);

					$arrayText[$arrayInsert['idTipoAsistencia']]['hora'] =$arrayInsert['hora'];
					$arrayText[$arrayInsert['idTipoAsistencia']]['textOcurrencia'] = $asistencias->{'ocurrenciaText'};
					$arrayText[$arrayInsert['idTipoAsistencia']]['tipo'] = 'WEB';

					$content .= getMensajeGestion('siRegistros');
					$content .= '<div class="alert alert-success m-3" role="alert">';
						$content .= '<i class="fas fa-list-alt fa-lg"></i>  <strong>Usuario: </strong>'. $arrayInsert['nombreUsuario']. '<br>';
						$content .= '<i class="fas fa-list-alt fa-lg"></i>  <strong>Perfil: </strong>'. $arrayInsert['tipoUsuario'].'<br>';
						$content .= '<i class="fas fa-list-alt fa-lg"></i>  <strong>Tipo Asistencia: </strong>'. (($arrayInsert['idTipoAsistencia']==1) ? 'INGRESO' : 'SALIDA').'<br>';
					$content .= '</div>';

				} else {
					$content = getMensajeGestion('noRegistros');
					
				}
			}
			
			$result['result'] = 1;
			$result['msg']['content'] = $content;
		} else {
			$content = getMensajeGestion('noRegistros');
		}

		//RESULTADOS
		$result['msg']['title'] = 'Actualizar Asistencia - Contingencia';
		$result['msg']['content'] = $content;
		$result['data'] = $arrayText;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarAsistencia(){
		$result=$this->result;
		$dataAsistencia = json_decode($this->input->post('data'));
		
		$total = count($dataAsistencia);
		$correctas=0; $incorrectas=0; $contentError='';
		foreach ($dataAsistencia as $kd => $data) {
			$arrayInsert = array(
				'idUsuario' => !empty($data->{'usuario'}) ? $data->{'usuario'} : NULL
				,'fecha' => !empty($data->{'fecha'}) ? $data->{'fecha'} : NULL
				,'hora' => !empty($data->{'hora'}) ? $data->{'hora'} : NULL
				,'nombreUsuario' => !empty($data->{'nombreUsuario'}) ? $data->{'nombreUsuario'} : NULL
				,'idTipoUsuario' => !empty($data->{'tipoUsuario'}) ? $data->{'tipoUsuario'} : NULL
				,'tipoUsuario' => !empty($data->{'perfil'}) ? $data->{'perfil'} : NULL
				,'numDocumento' => !empty($data->{'numDocumento'}) ? $data->{'numDocumento'} : NULL
				,'demo' => 1
				,'flagContingencia' => 1
				,'idOcurrencia' => !empty($data->{'ocurrencia'}) ? $data->{'ocurrencia'} : NULL
				,'idTipoAsistencia' => !empty($data->{'tipoAsistencia'}) ? $data->{'tipoAsistencia'} : NULL
			);

			$insertarAsistencia = $this->model->insertar_detalle_asistencia($arrayInsert);
		
			if ( $insertarAsistencia ) {
				$correctas++;
				//AUDITORIA
				$arrayAuditoria = array(
					'idUsuario' => $this->idUsuario
					,'accion' => 'GUARDAR'
					,'tabla' => "ImpactTrade_bd.trade.data_asistencia"
					,'sql' => $this->db->last_query()
				);
				guardarAuditoria($arrayAuditoria);
			} else {
				$incorrectas++;
				$contentError .= '<div class="alert alert-danger" role="alert">';
					$contentError .= '<i class="fas fa-list-alt fa-lg"></i>  <strong>Usuario: </strong>'. $arrayInsert['nombreUsuario']. '<br>';
					$contentError .= '<i class="fas fa-list-alt fa-lg"></i>  <strong>Perfil: </strong>'. $arrayInsert['tipoUsuario'].'<br>';
					$contentError .= '<i class="fas fa-list-alt fa-lg"></i>  <strong>Tipo Asistencia: </strong>'. (($arrayInsert['tipoUsuario']==1) ? 'INGRESO' : 'SALIDA').'<br>';
				$contentError .= '</div>';
			}
		}

		$html = '<h4>Total de Registros: '.$total.'</h4>';
		$html .= '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> Registrados <strong>Correctamente:</strong> '.$correctas.' .</div>';
		$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> Registrados <strong>Incorrectamente:</strong> '.$incorrectas.' .</div>';
		$html .= $contentError;

		$result['result'] = 1;
		$result['msg']['title'] = 'Actualizar Asistencia - Contingencia';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
}
?>