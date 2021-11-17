<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitas extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/gestion/M_visitas','model');
	}
	
	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active'] = '73';
		$config['css']['style'] = array(
			'assets/libs/dataTables-1.10.20/datatables'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/css/configuraciones/gestion/visitas'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/languages/all'
			, 'assets/libs/handsontable@7.4.2/dist/moment/moment'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/js/core/HTCustom'
			, 'assets/custom/js/configuraciones/gestion/visitas'
			
		);

		$config['data']['icon'] = 'fas fa-route';
		$config['data']['title'] = 'Programacion Rutas';
		$config['data']['message'] = 'Lista de Rutas - Visitas';
		$config['view'] = 'modulos/configuraciones/gestion/visitas/index';

		$input=array();
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);
		
		$idCuenta = $_SESSION['idCuenta'];
		$idProyecto = $_SESSION['idProyecto'];
		
		$idProyectoGeneral = $this->model->obtener_proyecto_general($idProyecto);
		$rs_usuarios = $this->model->obtener_lista_usuarios($input);
		$tipoUsuario = $this->model->obtener_tipo_usuario($idProyectoGeneral['idProyectoGeneral']);
		$zona = $this->model->obtener_zona();
		$cadena = $this->model->obtener_cadena();
		$ciudad = $this->model->obtener_ciudad();

		$config['data']['listaUsuarios'] = $rs_usuarios;
		$config['data']['tipoUsuario'] = $tipoUsuario;
		$config['data']['ciudad'] = $ciudad;
		$config['data']['zona'] = $zona;
		$config['data']['cadena'] = $cadena;
		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);
		$fechas = explode(' - ', $data['txt-fechas']);
		$tipoGestor = $data['tipoGestor'];

		$html='';
		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		/*====Filtrado=====*/
		$input['cuenta'] = isset($data['cuenta_filtro']) ? $data['cuenta_filtro']:NULL;
		$input['proyecto'] = isset($data['proyecto_filtro']) ? $data['proyecto_filtro']:NULL;
		$input['grupoCanal'] = isset($data['grupo_filtro']) ? $data['grupo_filtro']:NULL;
		$input['canal'] = isset($data['canal_filtro']) ? $data['canal_filtro']:NULL;
		$input['usuario'] = isset($data['usuario']) ? $data['usuario']:NULL;
		/****/

		/////HFS
		$input['zona'] = isset($data['zona']) ? $data['zona']:NULL;
		$input['distribuidora'] = isset($data['distribuidora']) ? $data['distribuidora']:NULL;
		$input['sucursal'] = isset($data['ciudad_hfs']) ? $data['ciudad_hfs']:NULL;
		/////WHLS
		$input['ciudad'] = isset($data['ciudad_whls']) ? $data['ciudad_whls']:NULL;
		$input['plaza'] = isset($data['plaza']) ? $data['plaza']:NULL;
		/////MODERNO
		$input['cadena'] = isset($data['cadena']) ? $data['cadena']:NULL;
		$input['banner'] = isset($data['banner']) ? $data['banner']:NULL;
		
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);
		
		$input['cod_usuario']=isset($data['cod_usuario']) ? $data['cod_usuario']:NULL;
		$input['cod_cliente']=isset($data['cod_cliente']) ? $data['cod_cliente']:NULL;

		$input['tipoUsuario'] = !empty($data['tipoUsuario_filtro']) ? $data['tipoUsuario_filtro'] : '';
		$input['plaza'] = !empty($data['plaza_filtro']) ? $data['plaza_filtro'] : '';
		$input['distribuidora'] = !empty($data['distribuidora_filtro']) ? $data['distribuidora_filtro'] : '';
		$input['sucursal'] = !empty($data['distribuidoraSucursal_filtro']) ? $data['distribuidoraSucursal_filtro'] : '';
		$input['zona'] = !empty($data['zona_filtro']) ? $data['zona_filtro'] : '';
		$input['cadena'] = !empty($data['cadena_filtro']) ? $data['cadena_filtro'] : '';
		$input['banner'] = !empty($data['banner_filtro']) ? $data['banner_filtro'] : '';

		/*======*/
		switch ($tipoGestor) {
			case 1:
				$rs_rutas = $this->model->obtener_lista_rutas($input);
				if (!empty($rs_rutas)) {
					$array=array();
					$array['listaRutas'] = $rs_rutas;

					$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestorReporteRutas", $array, true);

					$result['result'] = 1;
					$result['data']['views']['tab-content-0']['html'] = $html;
					$result['data']['views']['tab-content-0']['datatable'] = 'tb-gestorReporteRutas';
				} else {
					$html = getMensajeGestion('noRegistros');
					$result['data']['views']['tab-content-0']['html'] = $html;
				}
				break;

			case 2:
				$rs_visitas = $this->model->obtener_lista_visitas($input);
				if (!empty($rs_visitas)) {
					$array=array();
					$array['listaVisitas'] = $rs_visitas;

					$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestorReporteVisitas", $array, true);

					$result['result'] = 1;
					$result['data']['views']['tab-content-1']['html'] = $html;
					$result['data']['views']['tab-content-1']['datatable'] = 'tb-gestorReporteVisitas';
				} else {
					$html = getMensajeGestion('noRegistros');
					$result['data']['views']['tab-content-1']['html'] = $html;
				}
				break;
			default:
				$html = getMensajeGestion('noRegistros');
				$result['data']['html'] = $html;
				break;
		}
		if( !empty($data['grupo_filtro'])){
			$grupoCanal = $this->db->get_where('trade.grupoCanal',['idGrupoCanal' =>$data['grupo_filtro'] ])->row_array();
		}
		$result['data']['grupoCanal'] = !empty($grupoCanal) ? strtoupper($grupoCanal['nombre']): NULL;
		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function cambiarEstadoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tipoGestor = $data->{'tipoGestor'};
		$dataRutas = $data->{'dataRutas'};
		$dataRutasInactivas = $data->{'dataRutasInactivas'};
		$dataVisitasActivas = $data->{'dataVisitasActivas'};
		$dataVisitasInactivas = $data->{'dataVisitasInactivas'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		switch ($tipoGestor) {
			case 'rutas':
				if (!empty($dataRutas) || !empty($dataRutasInactivas)) {
					$input=array();
					//DESACTIVAR RUTAS: ESTADO => 0
					foreach ($dataRutas as $kldr => $ruta) {
						$input['tabla'] = 'rutas';
						$input['idRuta'] = $ruta;
						$input['estado'] = 0;

						$rs_updateEstado = $this->model->update_estado_ruta_visita($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					//ACTIVAR RUTAS: ESTADO => 1
					foreach ($dataRutasInactivas as $klri => $ruta) {
						$input['tabla'] = 'rutas';
						$input['idRuta'] = $ruta;
						$input['estado'] = 1;

						$rs_updateEstado = $this->model->update_estado_ruta_visita($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html = getMensajeGestion('noRegistros');
				}
				break;
			
			case 'visitas':
				if (!empty($dataVisitasActivas) || !empty($dataVisitasInactivas)) {
					$input=array();
					foreach ($dataVisitasActivas as $klva => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 0;

						$rs_updateEstado = $this->model->update_estado_ruta_visita($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					foreach ($dataVisitasInactivas as $klvi => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 1;

						$rs_updateEstado = $this->model->update_estado_ruta_visita($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html = getMensajeGestion('noRegistros');
				}
				break;

			default:
				$html = getMensajeGestion('noRegistros');
				break;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	public function cambiarContingenciaMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tipoGestor = $data->{'tipoGestor'};
		$dataRutas = $data->{'dataRutas'};
		$dataRutasInactivas = $data->{'dataRutasInactivas'};
		$dataVisitasActivas = $data->{'dataVisitasActivas'};
		$dataVisitasInactivas = $data->{'dataVisitasInactivas'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		switch ($tipoGestor) {			
			case 'visitas':
				if (!empty($dataVisitasActivas) || !empty($dataVisitasInactivas)) {
					$input=array();
					foreach ($dataVisitasActivas as $klva => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 0;

						$rs_updateEstado = $this->model->update_estado_contingencia_visita($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					foreach ($dataVisitasInactivas as $klvi => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 1;

						$rs_updateEstado = $this->model->update_estado_contingencia_visita($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html = getMensajeGestion('noRegistros');
				}
				break;

			default:
				$html = getMensajeGestion('noRegistros');
				break;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function cambiarContingenciaMasivoDes(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tipoGestor = $data->{'tipoGestor'};
		$dataRutas = $data->{'dataRutas'};
		$dataRutasInactivas = $data->{'dataRutasInactivas'};
		$dataVisitasActivas = $data->{'dataVisitasActivas'};
		$dataVisitasInactivas = $data->{'dataVisitasInactivas'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		switch ($tipoGestor) {			
			case 'visitas':
				if (!empty($dataVisitasActivas) || !empty($dataVisitasInactivas)) {
					$input=array();
					foreach ($dataVisitasActivas as $klva => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 0;

						$rs_updateEstado = $this->model->update_estado_contingencia_visita_desactivar($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					foreach ($dataVisitasInactivas as $klvi => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 1;

						$rs_updateEstado = $this->model->update_estado_contingencia_visita_desactivar($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html = getMensajeGestion('noRegistros');
				}
				break;

			default:
				$html = getMensajeGestion('noRegistros');
				break;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function activarExclusionesMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tipoGestor = $data->{'tipoGestor'};
		$dataRutas = $data->{'dataRutas'};
		$dataRutasInactivas = $data->{'dataRutasInactivas'};
		$dataVisitasActivas = $data->{'dataVisitasActivas'};
		$dataVisitasInactivas = $data->{'dataVisitasInactivas'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		switch ($tipoGestor) {			
			case 'visitas':
				if (!empty($dataVisitasActivas) || !empty($dataVisitasInactivas)) {
					$input=array();
					foreach ($dataVisitasActivas as $klva => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 0;

						$rs_updateEstado = $this->model->update_exclusion_visita_desactivar($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					foreach ($dataVisitasInactivas as $klvi => $visita) {
						$input['tabla'] = 'visitas';
						$input['idVisita'] = $visita;
						$input['estado'] = 1;

						$rs_updateEstado = $this->model->update_exclusion_visita_desactivar($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html = getMensajeGestion('noRegistros');
				}
				break;

			default:
				$html = getMensajeGestion('noRegistros');
				break;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function rutaNuevo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$array=array();

		$rs_cuentaProyecto = $this->model->obtener_cuenta_proyecto($input);
		foreach ($rs_cuentaProyecto as $klcp => $row) {
			$array['listaCuentaProyecto'][$row['idCuenta']]['idCuenta'] = $row['idCuenta'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['cuenta'] = $row['cuenta'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['listaProyectos'][$row['idProyecto']]['idProyecto'] = $row['idProyecto'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['listaProyectos'][$row['idProyecto']]['proyecto'] = $row['proyecto'];
		}
	
		//LISTADO DE CUENTA - GRUPO CANAL - CANAL
		//VERIFICAMOS SI ES QUE EXISTE EL PERMISO DE CANAL
		$rs_grupoCanalCanal = ( !empty($this->permisos['canal']) ? $this->model->obtener_grupocanal_canal_usuarioHistorico($input) : $this->model->obtener_grupocanal_canal() );
		//$rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal();
		foreach ($rs_grupoCanalCanal as $kgc => $row) {
			$array['listaCuentaGrupoCanal'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['idGrupoCanal'] = $row['idGrupoCanal'];
			$array['listaCuentaGrupoCanal'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['grupoCanal'] = $row['grupoCanal'];
			$array['listaCuentaGrupoCanal'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['idCanal'] = $row['idCanal'];
			$array['listaCuentaGrupoCanal'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['canal'] = $row['canal'];
		}

		$rs_cuentaProyectoTipoUsuarioUsuario = $this->model->obtener_cuenta_proyecto_tipousuario_usuario($input);
		foreach ($rs_cuentaProyectoTipoUsuarioUsuario as $kcptuu => $row) {
			$array['listaCuentaProyectoTipoUsuarioUsuario'][$row['idCuenta']][$row['idProyecto']]['idProyecto'] = $row['idProyecto'];
			$array['listaCuentaProyectoTipoUsuarioUsuario'][$row['idCuenta']][$row['idProyecto']]['listaTipoUsuario'][$row['idTipoUsuario']]['idTipoUsuario'] = $row['idTipoUsuario'];
			$array['listaCuentaProyectoTipoUsuarioUsuario'][$row['idCuenta']][$row['idProyecto']]['listaTipoUsuario'][$row['idTipoUsuario']]['tipoUsuario'] = $row['tipoUsuario'];
			$array['listaCuentaProyectoTipoUsuarioUsuario'][$row['idCuenta']][$row['idProyecto']]['listaTipoUsuario'][$row['idTipoUsuario']]['listaUsuario'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
			$array['listaCuentaProyectoTipoUsuarioUsuario'][$row['idCuenta']][$row['idProyecto']]['listaTipoUsuario'][$row['idTipoUsuario']]['listaUsuario'][$row['idUsuario']]['nombreUsuario'] = $row['nombreUsuario'];
		}

		$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestor_nuevaRuta", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVA RUTA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function buscarClientes(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input=array();
		$input['fecha'] = $data->{'fecha'};
		$input['idCuenta'] = $data->{'cuenta'};
		$input['idProyecto'] = $data->{'proyecto'};
		$input['idCanal'] = $data->{'canal'};

		$rs_clientes = $this->model->obtener_lista_clientes($input);

		if (!empty($rs_clientes)) {
			$result['result'] = 1;
			$result['data']['clientes'] = $rs_clientes;
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevaRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$dataClientes =  ( isset($data->{'clientesAnadidos'}) && !empty($data->{'clientesAnadidos'}) ) ? $data->{'clientesAnadidos'} : NULL;

		$html='';
		$arrayVerificacion = array();
		$arrayVerificacion['idUsuario'] = $data->{'usuario'};
		$arrayVerificacion['fecha'] = $data->{'fecha'};
		$arrayVerificacion['idCuenta'] = $this->session->userdata('idCuenta');
		$arrayVerificacion['idProyecto'] = $this->session->userdata('idProyecto');
		$arrayVerificacion['estado'] = 1;

		$rs_verificacionRuta = $this->model->obtener_verificacion_existente($arrayVerificacion);

		if (empty($rs_verificacionRuta)) {

			$arrayInsertarRuta=array();
			$arrayInsertarRuta['idUsuario'] = $data->{'usuario'};
			$arrayInsertarRuta['fecha'] = $data->{'fecha'};
			$arrayInsertarRuta['numVisita'] = ( !empty($dataClientes) ? (is_array($dataClientes)? count($dataClientes) : 1 ) : 0 );
			$arrayInsertarRuta['idTipoUsuario'] = $data->{'tipoUsuario'};
			$arrayInsertarRuta['agregado'] = 1;
			$arrayInsertarRuta['idCuenta'] = $data->{'cuenta'};
			$arrayInsertarRuta['idProyecto'] = $data->{'proyecto'};

			$insertarRuta = $this->model->insertar_ruta($arrayInsertarRuta);

			if ( $insertarRuta) {
				$insertIdRuta = $this->db->insert_id();
				$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR LA RUTA PARA EL USUARIO CON LA FECHA CORRECTAMENTE.</div>';

				if (!empty($dataClientes)) {
					$rowInserted=0; $rowInsertedError=0;
					$arrayInsertarVisita=array();

					if ( is_array($dataClientes)) {
						foreach ($dataClientes as $kc => $cliente) {
							$arrayInsertarVisita['idRuta'] = $insertIdRuta;
							$arrayInsertarVisita['idCliente'] = $cliente;

							$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
							if ($insertarVisita) $rowInserted++;
							else $rowInsertedError++;
						}
					} else {
						$arrayInsertarVisita['idRuta'] = $insertIdRuta;
						$arrayInsertarVisita['idCliente'] = $dataClientes;

						$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
						if ($insertarVisita) $rowInserted++;
						else $rowInsertedError++;
					}

					$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR '.$rowInserted.' VISITAS CORRECTAMENTE.</div>';
					if ( $rowInsertedError>0) {
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR '.$rowInsertedError.' CLIENTES CON LA FECHA INDICADA.</div>';
					}
				}
				$result['result'] = 1 ;
			} else {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR AL USUARIO CON LA FECHA INDICADA.</div>';
			}

		} else {
			$idRuta=$rs_verificacionRuta[0]['idRuta'];
			
			if (!empty($dataClientes)) {
				$rowInserted=0; $rowInsertedError=0;
				$arrayInsertarVisita=array();

				if ( is_array($dataClientes)) {
					foreach ($dataClientes as $kc => $cliente) {
						$arrayInsertarVisita['idRuta'] = $idRuta;
						$arrayInsertarVisita['idCliente'] = $cliente;

						$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
						if ($insertarVisita) $rowInserted++;
						else $rowInsertedError++;
					}
				} else {
					$arrayInsertarVisita['idRuta'] = $idRuta;
					$arrayInsertarVisita['idCliente'] = $dataClientes;

					$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
					if ($insertarVisita) $rowInserted++;
					else $rowInsertedError++;
				}

				$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR '.$rowInserted.' VISITAS CORRECTAMENTE.</div>';
				if ( $rowInsertedError>0) {
					$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR '.$rowInsertedError.' CLIENTES CON LA FECHA INDICADA.</div>';
				}
			}
			$result['result'] = 1 ;
		}

		$result['msg']['title'] = 'REGISTRAR PUNTO DE VENTA';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function duplicarRuta(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$array=array();
		$html = $this->load->view("modulos/configuraciones/gestion/visitas/gestor_duplicarRuta", $array, true);

		$result['result']=1;
		$result['msg']['title'] = 'DUPLICAR RUTA';
		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function guardarDuplicarRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataForm = $data->{'dataForm'};
		$dataListaRutas = $data->{'dataListaRutas'};

		$html='';

		if (!empty($dataListaRutas)) {
			foreach ($dataListaRutas as $klr => $ruta) {
				$rs_ruta = $this->model->obtener_ruta_actual($ruta);

				//VERIFICAMOS LA EXISTENCIA DE ESA RUTA 
				$arrayVerificacion = array();
				$arrayVerificacion['idUsuario'] = $rs_ruta[0]['idUsuario'];
				$arrayVerificacion['fecha'] = $dataForm->{'nuevaFecha'};
				$arrayVerificacion['idCuenta'] = $this->session->userdata('idCuenta');
				$arrayVerificacion['idProyecto'] = $this->session->userdata('idProyecto');
				$arrayVerificacion['estado'] = 1;

				$rs_verificacionRuta = $this->model->obtener_verificacion_existente($arrayVerificacion);

				if ( empty($rs_verificacionRuta) ) {
					//LISTAMOS LAS VISITAS
					$rs_visitas = $this->model->obtener_lista_ruta_visitas($ruta);

					//INSERTAMOS LA RUTA
					$arrayInsertarRuta=array();
					$arrayInsertarRuta['idUsuario'] = $rs_ruta[0]['idUsuario'];
					$arrayInsertarRuta['fecha'] = $dataForm->{'nuevaFecha'};
					$arrayInsertarRuta['numVisita'] = ( !empty($rs_visitas) ? count($rs_visitas) : 0 );
					$arrayInsertarRuta['idTipoUsuario'] = $rs_ruta[0]['idTipoUsuario'];
					$arrayInsertarRuta['agregado'] = 1;
					$arrayInsertarRuta['idCuenta'] = $rs_ruta[0]['idCuenta'];
					$arrayInsertarRuta['idProyecto'] = $rs_ruta[0]['idProyecto'];

					$insertarRuta = $this->model->insertar_ruta($arrayInsertarRuta);

					//VERIFICAMOS LA INSERCIÓN
					if (!empty($insertarRuta)) {
						//FUE TRUE LA INSERCIÓN
						$insertIdRuta = $this->db->insert_id();
						$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR LA RUTA PARA EL USUARIO <strong>'.$rs_ruta[0]['nombreUsuario'].'</strong> CON LA FECHA ASIGNADA CORRECTAMENTE.</div>';

						if (!empty($rs_visitas)) {
							$rowInserted=0; $rowInsertedError=0;
							$arrayInsertarVisita=array();
							
							foreach ($rs_visitas as $klv => $cliente) {
								$arrayInsertarVisita['idRuta'] = $insertIdRuta;
								$arrayInsertarVisita['idCliente'] = $cliente['idCliente'];

								$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
								if ($insertarVisita) $rowInserted++;
								else $rowInsertedError++;	
							}

							$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR <strong>'.$rowInserted.'</strong> VISITA(S) CORRECTAMENTE, PARA EL USUARIO <strong>'.$rs_ruta[0]['nombreUsuario'].'</strong>.</div>';
							if ( $rowInsertedError>0) {
								$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR <strong>'.$rowInsertedError.'</strong> CLIENTE(S) PARA EL USUARIO '.$rs_ruta[0]['nombreUsuario'].' CON LA FECHA INDICADA.</div>';
							}
						}

						$result['result'] = 1;
					} else {
						//FUE FALSE LA INSERCIÓN
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR AL USUARIO <strong>'.$rs_ruta[0]['nombreUsuario'].'</strong> CON LA FECHA INDICADA.</div>';
					}
				} else {
					//LA RUTA YA EXISTE PARA ESA FECHA
					$html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> EL USUARIO <strong>'.$rs_ruta[0]['nombreUsuario'].'</strong> YA <strong>CUENTA</strong> CON UNA <strong>RUTA</strong> PARA LA FECHA ASIGNADA.</div>';
				}
			}
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		$result['msg']['title'] = 'DUPLICAR RUTAS';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function reprogramarRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataListaRutas = $data->{'dataListaRutas'};
		
		$html='';

		if ( !empty($dataListaRutas)) {
			$input=array();
			$input['idRutasString'] = implode(",", $dataListaRutas);
			$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
			$input['listaProyectos']=implode(',', $this->permisos['proyecto']);
		
			$rs_rutas = $this->model->obtener_lista_rutas_reprogramar($input);

			$array=array();
			$array['listaRutas'] = $rs_rutas;

			$rs_listaUsuarios = $this->model->obtener_lista_usuarios($input);
			$array['listaUsuarios'] = $rs_listaUsuarios;

			$html = $this->load->view("modulos/configuraciones/gestion/visitas/gestor_reprogramarRuta", $array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		
		$result['result']=1;
		$result['msg']['title'] = 'REPROGRAMAR RUTA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarReprogramarRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataRutas = $data->{'dataRutas'};

		$html='';

		if (!empty($dataRutas)) {
			$rowUpdated=0; $rowUpdatedError=0;

			foreach ($dataRutas as $klr => $ruta) {
				$idRuta = ( isset($ruta->{'ruta'}) && !empty($ruta->{'ruta'}) ) ? $ruta->{'ruta'} : NULL;
				$idUsuario = ( isset($ruta->{'usuario'}) && !empty($ruta->{'usuario'}) ) ? $ruta->{'usuario'} : NULL;
				$idUsuarioTexto = ( isset($ruta->{'usuarioTexto'}) && !empty($ruta->{'usuarioTexto'}) ) ? $ruta->{'usuarioTexto'} : NULL;
				$fecha = ( isset($ruta->{'fecha'}) && !empty($ruta->{'fecha'}) ) ? $ruta->{'fecha'} : $data->{'fechaGrupal'};

				//VERIFICAMOS LA EXISTENCIA DE ESA RUTA 
				$arrayVerificacion = array();
				$arrayVerificacion['idUsuario'] = $idUsuario;
				$arrayVerificacion['fecha'] = $fecha;
				$arrayVerificacion['estado'] = 1;

				$rs_verificacionRuta = $this->model->obtener_verificacion_existente($arrayVerificacion);

				if ( empty($rs_verificacionRuta)) {
					//ACTUALIZAMOS LA RUTA
					$arrayUpdateRuta=array();
					$arrayUpdateRuta['arrayParams'] = array('idUsuario'=>$idUsuario, 'fecha'=>$fecha);
					$arrayUpdateRuta['arrayWhere'] = array('idRuta'=>$idRuta);

					$updateRuta = $this->model->update_reprogramar_ruta($arrayUpdateRuta);

					if ($updateRuta) $rowUpdated++;
					else $rowUpdatedError++;			

					$result['result']=1;
				} else {
					//LA RUTA YA EXISTE PARA ESA FECHA
					$html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> EL USUARIO <strong>'.$idUsuarioTexto.'</strong> YA <strong>CUENTA</strong> CON UNA <strong>RUTA</strong> PARA LA FECHA ASIGNADA.</div>';
				}
			}

			$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ ACTUALIZAR <strong>'.$rowUpdated.'</strong> RUTA(S) CORRECTAMENTE.</div>';
			if ( $rowUpdatedError>0) {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR <strong>'.$rowUpdatedError.'</strong> RUTA(S).</div>';
			}
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		
		$result['msg']['title'] = 'REPROGRAMAR RUTA';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function editarRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idRuta = $data->{'ruta'};

		$html='';
		$rs_lista_ruta_visita = $this->model->obtener_lista_editar_ruta_visitas($idRuta);

		if ( !empty($rs_lista_ruta_visita)) {
			$array=array();
			$array['idRuta'] = $idRuta;

			foreach ($rs_lista_ruta_visita as $klrv => $row) {
				$array['ruta']['fecha'] = $row['fecha'];
				$array['ruta']['nombreUsuario'] = $row['nombreUsuario'];
				if ( !empty($row['idCliente'])) {
					$array['ruta']['listaClientes'][$row['idCliente']]['idCliente'] = $row['idCliente'];
					$array['ruta']['listaClientes'][$row['idCliente']]['razonSocial'] = $row['razonSocial'];
					$array['ruta']['listaClientes'][$row['idCliente']]['direccion'] = $row['direccion'];
				}
			}

			$input=array();
			$input['fecha'] = $rs_lista_ruta_visita[0]['fecha'];
			$input['idCuenta'] = $rs_lista_ruta_visita[0]['idCuenta'];
			$input['idProyecto'] = $rs_lista_ruta_visita[0]['idProyecto'];

			$rs_clientes = $this->model->obtener_lista_clientes($input);
			$array['listaClientes'] = $rs_clientes;
			
			$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestor_editarRuta", $array, true);
		} else{
			$html = getMensajeGestion('noRegistros');
		}
		
		$result['result']=1;
		$result['msg']['title'] = 'EDITAR RUTA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarEditarRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idRuta = $data->{'ruta'};
		$dataClientesAdicionales = $data->{'dataClientesAdicionales'};
		$dataClientesQuitar = $data->{'dataClientesQuitar'};

		$html='';
		$rowInserted=0; $rowInsertedError=0;
		$rowDeleted=0; $rowDeletedError=0;

		if ( !empty($dataClientesAdicionales)) {
			foreach ($dataClientesAdicionales as $lca => $clientes) {
				$idRuta = ( isset($clientes->{'ruta'}) && !empty($clientes->{'ruta'}) ) ? $clientes->{'ruta'} : NULL;
				$idCliente = ( isset($clientes->{'cliente'}) && !empty($clientes->{'cliente'}) ) ? $clientes->{'cliente'} : NULL;

				$arrayVerificacion = array();
				$arrayVerificacion['idRuta'] = $idRuta;
				$arrayVerificacion['idCliente'] = $idCliente;

				$rs_verificacionVisita = $this->model->obtener_verificacion_existente_visita($arrayVerificacion);

				if (empty($rs_verificacionVisita)) {
					$arrayInsertarVisita=array();
					$arrayInsertarVisita['idRuta'] = $idRuta;
					$arrayInsertarVisita['idCliente'] = $idCliente;

					$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
					if ($insertarVisita) $rowInserted++;
					else $rowInsertedError++;
				}
			}

			$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR '.$rowInserted.' VISITAS CORRECTAMENTE.</div>';
			if ( $rowInsertedError>0) {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR '.$rowInsertedError.' CLIENTES CON LA FECHA INDICADA.</div>';
			}
		}

		if ( !empty($dataClientesQuitar)) {
			foreach ($dataClientesQuitar as $key => $clientes) {
				$idRuta = ( isset($clientes->{'ruta'}) && !empty($clientes->{'ruta'}) ) ? $clientes->{'ruta'} : NULL;
				$idCliente = ( isset($clientes->{'cliente'}) && !empty($clientes->{'cliente'}) ) ? $clientes->{'cliente'} : NULL;

				$arrayDeleteVisita = array();
				$arrayDeleteVisita['idRuta'] = $idRuta;
				$arrayDeleteVisita['idCliente'] = $idCliente;

				$deleteVisita = $this->model->delete_visita_detalle($arrayDeleteVisita);
				$deleteVisita = $this->model->delete_visita($arrayDeleteVisita);
				if ($deleteVisita) $rowDeleted++;
				else $rowDeletedError++;
			}

			$rs_visitas = $this->model->obtener_lista_ruta_visitas_total($idRuta);
			//ACTUALIZAMOS LA RUTA
			$arrayUpdateRuta=array();
			$arrayUpdateRuta['arrayParams'] = array('numVisita'=>count($rs_visitas));
			$arrayUpdateRuta['arrayWhere'] = array('idRuta'=>$idRuta);

			$updateRuta = $this->model->update_reprogramar_ruta($arrayUpdateRuta);

			$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ ELIMINAR '.$rowDeleted.' CLIENTES CORRECTAMENTE.</div>';
			if ( $rowDeletedError>0) {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL ELIMINAR '.$rowDeletedError.' CLIENTES.</div>';
			}
		}

		$result['result']=1;
		$result['msg']['title'] = 'REPROGRAMAR RUTA';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function reprogramarVisita(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$dataListaVisitas = $data->{'dataListaVisitas'};
		
		$html='';

		if ( !empty($dataListaVisitas)) {
			$input=array();
			$input['idVisitasString'] = implode(",", $dataListaVisitas);
			$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
			$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

			$rs_visitas = $this->model->obtener_lista_visitas_reprogramar($input);

			$array=array();
			$array['listaVisitas'] = $rs_visitas;

			$rs_listaUsuarios = $this->model->obtener_lista_usuarios($input);
			$array['listaUsuarios'] = $rs_listaUsuarios;

			$html = $this->load->view("modulos/configuraciones/gestion/visitas/gestor_reprogramarVisita", $array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		
		$result['result']=1;
		$result['msg']['title'] = 'REPROGRAMAR VISITA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarReprogramarVisita(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataVisitas = $data->{'dataVisitas'};

		$html='';
		if ( !empty($dataVisitas)) {
			foreach ($dataVisitas as $klv => $visita) {
				if( $visita->{'flagProgramar'}=='1' ){
					$idRuta = ( isset($visita->{'ruta'}) && !empty($visita->{'ruta'}) ) ? $visita->{'ruta'} : NULL;
					$idVisita = ( isset($visita->{'visita'}) && !empty($visita->{'visita'}) ) ? $visita->{'visita'} : NULL;
					$idUsuario = ( isset($visita->{'usuario'}) && !empty($visita->{'usuario'}) ) ? $visita->{'usuario'} : NULL;
					$idUsuarioTexto = ( isset($visita->{'usuarioTexto'}) && !empty($visita->{'usuarioTexto'}) ) ? $visita->{'usuarioTexto'} : NULL;
					$fecha = ( isset($visita->{'fecha'}) && !empty($visita->{'fecha'}) ) ? $visita->{'fecha'} : $data->{'fechaGrupal'};
					$idCliente = ( isset($visita->{'cliente'}) && !empty($visita->{'cliente'}) ) ? $visita->{'cliente'} : NULL;
					$idClienteTexto = ( isset($visita->{'clienteTexto'}) && !empty($visita->{'clienteTexto'}) ) ? $visita->{'clienteTexto'} : NULL;

					//VERIFICACIÓN DE LA EXISTENCIA DE LA RUTA
					$arrayVerificacion = array();
					$arrayVerificacion['idUsuario'] = $idUsuario;
					$arrayVerificacion['fecha'] = $fecha;
					$arrayVerificacion['estado'] = 1;

					$rs_verificacionRuta = $this->model->obtener_verificacion_existente($arrayVerificacion);
					$obtener_data_ruta = $this->model->obtener_data_ruta($idRuta);
					
					if ( empty($rs_verificacionRuta)) {
						//NO HAY REGISTRO DE DATA
						//INSERTAMOS LA RUTA
						$arrayInsertarRuta=array();
						$arrayInsertarRuta['idUsuario'] = $idUsuario;
						$arrayInsertarRuta['fecha'] = $fecha;
						if(!empty($obtener_data_ruta)){
							$arrayInsertarRuta['idCuenta'] = $obtener_data_ruta['idCuenta'];
							$arrayInsertarRuta['idProyecto'] = $obtener_data_ruta['idProyecto'];
						}
						$arrayInsertarRuta['agregado'] = 1;

						$insertarRuta = $this->model->insertar_ruta($arrayInsertarRuta);

						if ( $insertarRuta) {
							$insertIdRuta = $this->db->insert_id();
							$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-user"></i> SE LOGRÓ REGISTRAR LA RUTA PARA EL USUARIO <strong>'.$idUsuarioTexto.'</strong> CON LA FECHA CORRECTAMENTE.</div>';

							//INSERTAMOS LA VISITA
							$arrayInsertarVisita=array();
							$arrayInsertarVisita['idRuta'] = $insertIdRuta;
							$arrayInsertarVisita['idCliente'] = $idCliente;

							$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);
							if ( $insertarVisita) {
								$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR AL CLIENTE <strong>'.$idClienteTexto.'</strong> PARA EL USUARIO <strong>'.$idUsuarioTexto.'</strong> CON LA FECHA CORRECTAMENTE.</div>';

								//ELIMINAMOS LA VISITA
								$arrayDeleteVisita=array();
								$arrayDeleteVisita['idVisita'] =$idVisita;
								$deleteVisita= $this->model->delete_visita_det($arrayDeleteVisita);
								$deleteVisita= $this->model->delete_visita($arrayDeleteVisita);
								//ACTUALIZAMOS LA RUTA
								$rs_visitas = $this->model->obtener_lista_ruta_visitas_total($idRuta);
								$arrayUpdateRuta=array();
								$arrayUpdateRuta['arrayParams'] = array('numVisita'=>count($rs_visitas));
								$arrayUpdateRuta['arrayWhere'] = array('idRuta'=>$idRuta);
								$updateRuta = $this->model->update_reprogramar_ruta($arrayUpdateRuta);
							} else {
								$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR AL CLIENTE <strong>'.$idClienteTexto.'</strong> PARA EL USUARIO <strong>'.$idUsuarioTexto.'</strong> CON LA FECHA INDICADA.</div>';
							}
						} else{
							$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-user-times"></i> HUBO INCONVENIENTES AL REGISTRAR AL USUARIO <strong>'.$idUsuarioTexto.'</strong> CON LA FECHA INDICADA.</div>';
						}
					} else {
						//HAY REGISTRO DE DATA
						$idRutaNueva = $rs_verificacionRuta[0]['idRuta'];

						//VERIFICAMOS EXISTENCIA DE VISITA
						$arrayVerificacion=array();
						$arrayVerificacion['idRuta'] = $idRutaNueva;
						$arrayVerificacion['idCliente'] = $idCliente;

						$rs_verificacionVisita = $this->model->obtener_verificacion_existente_visita($arrayVerificacion);

						if ( empty($rs_verificacionVisita)) {
							//INSERTAMOS LA VISITA
							$arrayInsertarVisita=array();
							$arrayInsertarVisita['idRuta'] = $idRutaNueva;
							$arrayInsertarVisita['idCliente'] = $idCliente;

							$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);

							if ( $insertarVisita) {
								$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR AL CLIENTE <strong>'.$idClienteTexto.'</strong> PARA EL USUARIO <strong>'.$idUsuarioTexto.'</strong> CON LA FECHA CORRECTAMENTE.</div>';

								//ELIMINAMOS LA VISITA
								$arrayDeleteVisita=array();
								$arrayDeleteVisita['idVisita'] =$idVisita;
								$deleteVisita= $this->model->delete_visita_det($arrayDeleteVisita);
								$deleteVisita= $this->model->delete_visita($arrayDeleteVisita);
								//ACTUALIZAMOS LA RUTA
								$rs_visitas = $this->model->obtener_lista_ruta_visitas_total($idRuta);
								$arrayUpdateRuta=array();
								$arrayUpdateRuta['arrayParams'] = array('numVisita'=>count($rs_visitas));
								$arrayUpdateRuta['arrayWhere'] = array('idRuta'=>$idRuta);
								$updateRuta = $this->model->update_reprogramar_ruta($arrayUpdateRuta);
							} else {
								$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR AL CLIENTE <strong>'.$idClienteTexto.'</strong> PARA EL USUARIO <strong>'.$idUsuarioTexto.'</strong> CON LA FECHA INDICADA.</div>';
							}
						} else {
							//YA EXISTE LA RUTA Y EL CLIENTE
							$html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-user"></i> EL USUARIO <strong>'.$idUsuarioTexto.'</strong> YA <strong>CUENTA</strong> CON EL CLIENTE <strong>'.$idClienteTexto.'</strong> PARA LA FECHA ASIGNADA.</div>';
						}
					}
				}
			}

			$result['result']=1;
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		$result['msg']['title'] = 'REPROGRAMAR VISITA';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function rutaNuevoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$array=array();

		$rs_listaUsuarios = $this->model->obtener_lista_usuarios($input);
		$array['listaUsuarios']=array();
		foreach ($rs_listaUsuarios as $klu => $row) {
			array_push($array['listaUsuarios'], $row['idUsuario']);
		}
	
		$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestor_nuevaRutaMasivo", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVA RUTA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoPuntoMasivoRuta(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html=''; $htmlDuplicados='';
		if ( !empty($data)) {
			$contDuplicados = 0;
			//VERIFICAR DUPLICIDAD DE TODOS
			//VERIFICAR FECHA ACORDE A SU HISTÓRICO
			foreach ($data as $klu => $row) {
				//ARRAY BUSQUEDA
				$inputBusqueda=array();
				$inputBusqueda['idUsuario'] = (isset($row[0]) && !empty($row[0]))? $row[0]:NULL;
				$inputBusqueda['fecha'] = (isset($row[1]) && !empty($row[1]))? $row[1]:NULL;

				$rs_verificarRuta = $this->model->obtener_verificacion_existente($inputBusqueda);
				if (!empty($rs_verificarRuta)) {
					$contDuplicados++;
					$htmlDuplicados .= '<div class="alert alert-warning fade show" role="alert"> <i class="fas fa-exclamation-triangle"></i> EL COLABORADOR INGRESADO CON ID USUARIO <strong>'.$inputBusqueda['idUsuario'] .'</strong> CON LA FECHA <strong>'.$inputBusqueda['fecha'].'</strong> YA SE ENCUENTRA REGISTRADO.</div>';
				}
			}

			if ( $contDuplicados>0 ) {
				$html .= '<h5>VERIFICAR LA INFORMACIÓN:</h5>';
				$html .= $htmlDuplicados;
			} else {
				foreach ($data as $klu => $row) {
					//ARRAY RUTA
					$input=array();
					$cuentaProyectoUsuario = $this->model->obtenerProyectoCuentaUsuario($input)->row_array();
					
					$input['idUsuario'] = (isset($row[0]) && !empty($row[0]))? $row[0]:NULL;
					$input['fecha'] = (isset($row[1]) && !empty($row[1]))? $row[1]:NULL;
					$input['idCuenta'] = (isset($cuentaProyectoUsuario['idCuenta']) && !empty($cuentaProyectoUsuario['idCuenta']))? $cuentaProyectoUsuario['idCuenta']:NULL;
					$input['idProyecto'] = (isset($cuentaProyectoUsuario['idProyecto']) && !empty($cuentaProyectoUsuario['idProyecto']))? $cuentaProyectoUsuario['idProyecto']:NULL;

					$insertarRuta = $this->model->insertar_ruta($input);

					if ( $insertarRuta) {
						$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-user"></i> SE LOGRÓ REGISTRAR LA RUTA PARA EL USUARIO <strong>'.$input['idUsuario'].'</strong> CON LA FECHA <strong>'.$input['fecha'].'</strong> CORRECTAMENTE.</div>';
					} else {
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-user-times"></i> HUBO INCONVENIENTES AL REGISTRAR AL USUARIO <strong>'.$input['idUsuario'].'</strong> CON LA FECHA <strong>'.$input['fecha'].'</strong> INDICADA.</div>';
					}
				}
			}
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVA RUTA MASIVA';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function visitaNuevoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$array=array();

		$input=array();
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$rs_listaUsuarios = $this->model->obtener_lista_usuarios($input);
		$array['listaUsuarios']=array();
		foreach ($rs_listaUsuarios as $klu => $row) {
			array_push($array['listaUsuarios'], $row['idUsuario']);
		}
		
		$input['fecha'] = date('d/m/Y');

		$rs_clientes = $this->model->obtener_lista_clientes($input);
		$array['listaClientes'] = array();
		foreach ($rs_clientes as $klc => $row) {
			array_push($array['listaClientes'], $row['idCliente']);
		}
		$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestor_nuevaVisitaMasivo", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVA VISITA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoPuntoMasivoRutaVisita(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		
		$html=''; $htmlNoRegistrados=''; $htmlDuplicados='';
		$arrayListaUsuariosNoRegistrados = array();

		$idCuenta=$this->session->userdata('idCuenta');
		$idProyecto=$this->session->userdata('idProyecto');

		if ( !empty($data)) {
			$contNoRegistrados = 0;
			foreach ($data as $klu => $row) {
				//ARRAY BUSQUEDA
				$inputBusqueda=array();
				$idUsuario= (isset($row[1]) && !empty($row[1]))? $row[1]:NULL;
				$inputBusqueda['idUsuario']=$idUsuario;

				$inputBusqueda['fecha'] = (isset($row[0]) && !empty($row[0]))? $row[0]:NULL;
				$idCliente = (isset($row[2]) && !empty($row[2]))? $row[2]:NULL;
				$rs_verificarRuta = $this->model->obtener_verificacion_existente($inputBusqueda);
				

				if (empty($rs_verificarRuta)) {
					//no tiene ruta
					
						//BUSCAMOS EL ID DEL CLIENTE
						$inputBusquedaCliente = array();
						$inputBusquedaCliente['fecha'] = date('d/m/Y');
						$inputBusquedaCliente['idCliente'] = $idCliente;
						$rs_clientes = $this->model->obtener_lista_clientes($inputBusquedaCliente);

				
						if ( !empty($rs_clientes)) {
							$arrayInsertarRuta=array();
							$arrayInsertarRuta['idUsuario']=$inputBusqueda['idUsuario'];
							$arrayInsertarRuta['fecha']=$inputBusqueda['fecha'];
							$arrayInsertarRuta['idCuenta']=$idCuenta;
							$arrayInsertarRuta['idProyecto']=$idProyecto;
							$inputUsuario =array();
							$inputUsuario['idUsuario'] =$idUsuario;
							$rs_usuarios = $this->model->obtener_lista_usuarios($inputUsuario);
							
							$insertarRuta = $this->model->insertar_ruta($arrayInsertarRuta);

								if ( $insertarRuta) {
									$idRutaNueva = $this->model->insertId;
									//crear ruta
									

									$idCliente = $rs_clientes[0]['idCliente'];
									$razonSocial = $rs_clientes[0]['razonSocial'];
									$nombreComercial = $rs_clientes[0]['nombreComercial'];
									
									$nombreUsuario = $rs_usuarios[0]['nombreUsuario'];

									//INSERTAMOS LA VISITA
									$arrayInsertarVisita=array();
									$arrayInsertarVisita['idRuta'] = $idRutaNueva;
									$arrayInsertarVisita['idCliente'] = $idCliente;
									$arrayInsertarVisita['razonSocial'] = $razonSocial;
									$arrayInsertarVisita['nombreComercial'] = $nombreComercial;
									
									$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);

								if ( $insertarVisita) {
									$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR AL CLIENTE <strong>'.$razonSocial.'</strong> PARA EL USUARIO <strong>'.$nombreUsuario.'</strong> CON LA FECHA <strong>'.$inputBusqueda['fecha'].'</strong> CORRECTAMENTE.</div>';
								} else {
									$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR AL CLIENTE <strong>'.$razonSocial.'</strong> PARA EL USUARIO <strong>'.$nombreUsuario.'</strong> CON LA FECHA '.$inputBusqueda['fecha'].'.</div>';
								} 
							}
						}
				}else{
					//si tiene ruta

					$inputBusqueda=array();
					$idUsuario=(isset($row[1]) && !empty($row[1]))? $row[1]:NULL;
					$inputBusqueda['idUsuario'] = $idUsuario;
					$inputBusqueda['fecha'] = (isset($row[0]) && !empty($row[0]))? $row[0]:NULL;
					$idCliente = (isset($row[2]) && !empty($row[2]))? $row[2]:NULL;

					$rs_verificarRuta = $this->model->obtener_verificacion_existente($inputBusqueda);
					if (!empty($rs_verificarRuta)) {
						//HAY REGISTRO DE DATA
						$idRutaNueva = $rs_verificarRuta[0]['idRuta'];

						//VERIFICAMOS EXISTENCIA DE VISITA 
						$arrayVerificacion=array();
						$arrayVerificacion['idRuta'] = $idRutaNueva;
						$arrayVerificacion['idCliente'] = $idCliente;

						// ESTA FUNCION NO EXISTE
						$rs_verificacionVisita = $this->model->obtener_verificacion_existente_visita_cliente($arrayVerificacion);
						
						if ( empty($rs_verificacionVisita) ) {
							//BUSCAMOS EL ID DEL CLIENTE
							$inputBusquedaCliente = array();
							$inputBusquedaCliente['fecha'] = date('d/m/Y');
							$inputBusquedaCliente['idCliente'] = $idCliente;
							$rs_clientes = $this->model->obtener_lista_clientes($inputBusquedaCliente);

					
							if ( !empty($rs_clientes)) {
								$idCliente = $rs_clientes[0]['idCliente'];
								$razonSocial = $rs_clientes[0]['razonSocial'];
								$nombreComercial = $rs_clientes[0]['nombreComercial'];

								//INSERTAMOS LA VISITA
								$arrayInsertarVisita=array();
								$arrayInsertarVisita['idRuta'] = $idRutaNueva;
								$arrayInsertarVisita['idCliente'] = $idCliente;
								$arrayInsertarVisita['razonSocial'] = $razonSocial;
								$arrayInsertarVisita['nombreComercial'] = $nombreComercial;

	
								
								$insertarVisita = $this->model->insertar_visita($arrayInsertarVisita);

								if ( $insertarVisita) {
									$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR AL CLIENTE <strong>'.$idCliente.'</strong> PARA EL USUARIO <strong>'.$idUsuario.'</strong> CON LA FECHA <strong>'.$inputBusqueda['fecha'].'</strong> CORRECTAMENTE.</div>';
								} else {
									$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR AL CLIENTE <strong>'.$idCliente.'</strong> PARA EL USUARIO <strong>'.$idUsuario.'</strong> CON LA FECHA '.$inputBusqueda['fecha'].'.</div>';
								}
							}
						} else {
							//YA EXISTE LA RUTA Y EL CLIENTE
							$html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-user"></i> EL USUARIO <strong>'.$idUsuario.'</strong> YA <strong>CUENTA</strong> CON EL CLIENTE <strong>'.$idCliente.'</strong> PARA LA FECHA <strong>'.$inputBusqueda['fecha'].'</strong>.</div>';
						}
					}
				}
			}

			
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVA VISITA MASIVA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarListas(){
		$result = $this->result;
		$array=array();
		$params=array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$this->model->actualizar_listas($params);
		$result['result']=1;
		$result['msg']['title'] = 'ACTUALIZAR LISTAS';
		$result['msg']['content'] = 'Listas actualizadas correctamente.';

		echo json_encode($result);
	}

	public function excluirVisitas(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$array=array();
		$array['tipos']= $this->model->obtener_tipo_exclusion();

		$html .= $this->load->view("modulos/configuraciones/gestion/visitas/gestor_excluirVisita", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'EXCLUIR VISITA';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function excluirVisitasActivar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataVisitasIncluido = $data->{'dataVisitasIncluido'};
		$dataVisitasExcluido = $data->{'dataVisitasExcluido'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		if (!empty($dataVisitasIncluido) || !empty($dataVisitasExcluido)) {
			$input=array();
			foreach ($dataVisitasExcluido as $klva => $visita) {
				$input['tabla'] = 'visitas';
				$input['idVisita'] = $visita;
				$input['idTipoExclusion'] = null;
				$input['comentarioExclusion'] = null;

				$rs_updateEstado = $this->model->update_estado_exclusion_visita($input);
				if ( $rs_updateEstado) { $rowUpdated++; } 
				else { $rowUpdatedError++;	}
			}
			$input=array();
			foreach ($dataVisitasIncluido as $klvi => $visita) {
				$input['tabla'] = 'visitas';
				$input['idVisita'] = $visita;
				$input['idTipoExclusion'] =null;
				$input['comentarioExclusion'] = null;

				$rs_updateEstado = $this->model->update_estado_exclusion_visita($input);
				if ( $rs_updateEstado) { $rowUpdated++; } 
				else { $rowUpdatedError++;	}
			}

			$result['result'] = 1;
			$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
			if ( $rowUpdatedError>0) {
				$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
			}
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		
		$result['msg']['title'] = 'ACTUALIZAR ESTADO EXCLUSION MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}


	public function cambiarEstadoExclusionMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataVisitasIncluido = $data->{'dataVisitasIncluido'};
		$dataVisitasExcluido = $data->{'dataVisitasExcluido'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		if (!empty($dataVisitasIncluido) || !empty($dataVisitasExcluido)) {
			$input=array();
			foreach ($dataVisitasExcluido as $klva => $visita) {
				$input['tabla'] = 'visitas';
				$input['idVisita'] = $visita;
				$input['idTipoExclusion'] = null;
				$input['comentarioExclusion'] = null;

				$rs_updateEstado = $this->model->update_estado_exclusion_visita($input);
				if ( $rs_updateEstado) { $rowUpdated++; } 
				else { $rowUpdatedError++;	}
			}
			$input=array();
			foreach ($dataVisitasIncluido as $klvi => $visita) {
				$input['tabla'] = 'visitas';
				$input['idVisita'] = $visita;
				$input['idTipoExclusion'] = $data->{'idTipoExclusion'};
				$input['comentarioExclusion'] = $data->{'comentarioExclusion'};

				$rs_updateEstado = $this->model->update_estado_exclusion_visita($input);
				if ( $rs_updateEstado) { $rowUpdated++; } 
				else { $rowUpdatedError++;	}
			}

			$result['result'] = 1;
			$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
			if ( $rowUpdatedError>0) {
				$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
			}
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		
		$result['msg']['title'] = 'ACTUALIZAR ESTADO EXCLUSION MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function obtener_distribuidora(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input=array();
		$input['idZona'] = $data->{'zona'};

		$rs_zona = $this->model->obtener_distribuidora($input);

		if (!empty($rs_zona)) {
			$result['result'] = 1;
			$result['data']['zona'] = $rs_zona;
		}

		echo json_encode($result);
	}
	
	public function obtener_plazas(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input=array();
		$input['cod_departamento'] = $data->{'ciudad'};

		$rs_plaza = $this->model->obtener_plazas($input);

		if (!empty($rs_plaza)) {
			$result['result'] = 1;
			$result['data']['plazas'] = $rs_plaza;
		}

		echo json_encode($result);
	}
	
	public function obtener_banner(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input=array();
		$input['idCadena'] = $data->{'idCadena'};

		$rs_banner = $this->model->obtener_banner($input);

		if (!empty($rs_banner)) {
			$result['result'] = 1;
			$result['data']['banner'] = $rs_banner;
		}

		echo json_encode($result);
	}
	
	public function obtener_distribuidora_sucursal(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input=array();
		$input['idDistribuidora'] = $data->{'distribuidora'};
		$input['idZona'] = $data->{'zona'};

		$rs_distribuidora = $this->model->obtener_distribuidora_sucursal($input);

		if (!empty($rs_distribuidora)) {
			$result['result'] = 1;
			$result['data']['distribuidora'] = $rs_distribuidora;
		}

		echo json_encode($result);
	}

	
	public function cargaMasivaExcel(){
		$result= $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();

		$array = array();
		$html = '';
		$htmlWidth = '90%';
		$data=$this->model->obtener_estado_carga();
		$array['data_carga']=$data;
		$idProyectoGeneral = $this->model->obtener_proyecto_general($_SESSION['idProyecto']);
		$array['tipoUsuario'] =$this->model->obtener_tipo_usuario($idProyectoGeneral['idProyectoGeneral']);
		
		$html.= $this->load->view("modulos/configuraciones/gestion/visitas/formCargaMasivo", $array, true);
		

		$result['result'] = 1;
		$result['msg']['title'] = 'Registrar Visitas Masivo';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}
	
	public function cargarArchivo(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		//
		$datetime = date('dmYHis');
		$archivo = $_FILES['file']['name'];
		$nombre_carpeta = 'visitas_'.$datetime;
		$idTipoUsuario = $_POST['tipoUsuario'];
		
		//LIMPIAR TABLAS
		//$this->model->limpiar_tablas_modulacion ($idPermiso);
		//
		
		//
		$ruta = 'public/csv/visitas/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/visitas/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/modulacion__'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/modulacion__'.$datetime.'.csv';
		$to_read_files = $rutaFiles.'/';
		//
		$done = false;
		$part = 0;
		
		
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);

			while ($done == false) {
				$locA = ftell($handle);
				fseek($handle, $size, SEEK_CUR);
				$tmp = fgets($handle);
				$locB = ftell($handle);
				$span = ($locB - $locA);
				fseek($handle, $locA, SEEK_SET);
				$chunk = fread($handle,$span);
				file_put_contents($to_read_files.'modulacion_'.$part.'.csv',$header.$chunk);
				$part++;
				if (strlen($chunk) < $size) $done = true;
			}
			fclose($handle);
		}
		$sum = 0;
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);
			while (($registro = fgetcsv ($handle))!== false) {
				$sum++;
			}
		
		}
		$total = $sum;

		$carga = array();
		$carga = array(
			'idTipoUsuario' => $idTipoUsuario,
			'carpeta' => $nombre_carpeta,
			'idUsuarioRegistro' => $this->session->idUsuario,
			'totalRegistros' => $total
		);

		$this->db->insert('impactTrade_bd.trade.cargaProgramacionRutas',$carga);
 
		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>HORA FIN</th>';	 
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL CLIENTES PROCESADOS</th>';					 
						$html.='<th>ERRORES</th>';		
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
					$html.='<tr>';
						$html.='<td>'.$row['idCarga'].'</td>';
						$html.='<td>'.$row['fechaRegistro'].'</td>';
						$html.='<td>'.$row['horaRegistro'].'</td>';
						$html.='<td id="horaFin_'.$row['idCarga'].'">'.$row['horaFinRegistro'].'</td>';													 
						$html.='<td>'.$row['totalRegistros'].'</td>';
						$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
						$html.='<td id="errores_'.$row['idCarga'].'"></td>';													   							  
						$html.='<td class="text-center" id="barraprogreso_'.$row['idCarga'].'">';
							$porcentaje = 0;
							if( !empty($row['totalRegistros']) )
								$porcentaje = round($row['total_procesados']/$row['totalRegistros']*100,0);
								$mensaje=($row['estado']==1)?'Registrando data en Base de datos.':'procesando';
								$html.=$mensaje.'<br>';
								$html.='<meter min="0" max="100" low="0" high="0" optimum="100" value="'.$porcentaje.'" style="font-size:20px;">';
						$html.='</td>';
					$html.='</tr>';
					}
				$html.='</tbody>';
			$html.='</table>';
		}else{
			$html.='<div>
										<h4 style="border: 1px solid;
    background: #f2f2f2;
    padding: 20px;
    width: 50%;
    margin: auto;
    text-transform: uppercase;
}">Aun no ha realizado ninguna carga. </h4>
									</div>';	
		} 
		
		$result['data']=$html;
		echo json_encode($result);
	
		
	}
	
	
	public function cargarArchivoExclusiones(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		//
		$datetime = date('dmYHis');
		$archivo = $_FILES['file']['name'];
		$nombre_carpeta = 'exclusiones_'.$datetime;
		$idTipoUsuario = $_POST['tipoUsuario'];
		
		//LIMPIAR TABLAS
		//$this->model->limpiar_tablas_modulacion ($idPermiso);
		//
		
		//
		$ruta = 'public/csv/exclusiones/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/exclusiones/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/exclusiones__'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/exclusiones__'.$datetime.'.csv';
		$to_read_files = $rutaFiles.'/';
		//
		$done = false;
		$part = 0;
		
		
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);

			while ($done == false) {
				$locA = ftell($handle);
				fseek($handle, $size, SEEK_CUR);
				$tmp = fgets($handle);
				$locB = ftell($handle);
				$span = ($locB - $locA);
				fseek($handle, $locA, SEEK_SET);
				$chunk = fread($handle,$span);
				file_put_contents($to_read_files.'exclusiones__'.$part.'.csv',$header.$chunk);
				$part++;
				if (strlen($chunk) < $size) $done = true;
			}
			fclose($handle);
		}
		$sum = 0;
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);
			while (($registro = fgetcsv ($handle))!== false) {
				$sum++;
			}
		
		}
		$total = $sum;

		$carga = array();
		$carga = array(
			'idTipoUsuario' => $idTipoUsuario,
			'carpeta' => $nombre_carpeta,
			'idUsuarioRegistro' => $this->session->idUsuario,
			'totalRegistros' => $total
		);

		$this->db->insert('impactTrade_bd.trade.cargaExclusionesRutas',$carga);
 
		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga_exclusiones();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>HORA FIN</th>';	 
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL CLIENTES PROCESADOS</th>';					 
						$html.='<th>ERRORES</th>';		
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
					$html.='<tr>';
						$html.='<td>'.$row['idCarga'].'</td>';
						$html.='<td>'.$row['fechaRegistro'].'</td>';
						$html.='<td>'.$row['horaRegistro'].'</td>';
						$html.='<td id="horaFin_'.$row['idCarga'].'">'.$row['horaFinRegistro'].'</td>';													 
						$html.='<td>'.$row['totalRegistros'].'</td>';
						$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
						$html.='<td id="errores_'.$row['idCarga'].'"></td>';													   							  
						$html.='<td class="text-center" id="barraprogreso_'.$row['idCarga'].'">';
							$porcentaje = 0;
							if( !empty($row['totalRegistros']) )
								$porcentaje = round($row['total_procesados']/$row['totalRegistros']*100,0);
								$mensaje=($row['estado']==1)?'Registrando data en Base de datos.':'procesando';
								$html.=$mensaje.'<br>';
								$html.='<meter min="0" max="100" low="0" high="0" optimum="100" value="'.$porcentaje.'" style="font-size:20px;">';
						$html.='</td>';
					$html.='</tr>';
					}
				$html.='</tbody>';
			$html.='</table>';
		}else{
			$html.='<div>
										<h4 style="border: 1px solid;
    background: #f2f2f2;
    padding: 20px;
    width: 50%;
    margin: auto;
    text-transform: uppercase;
}">Aun no ha realizado ninguna carga. </h4>
									</div>';	
		} 
		
		$result['data']=$html;
		echo json_encode($result);
	
		
	}

	public function estado_carga(){
		$resultados=$this->model->obtener_estado_carga();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['horaFin']=$row['horaFinRegistro'];
			$data_carga[$i]['error']=$row['error'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
		
	}
	
	public function estado_carga_exclusiones(){
		$resultados=$this->model->obtener_estado_carga_exclusiones();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['horaFin']=$row['horaFinRegistro'];
			$data_carga[$i]['error']=$row['error'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
		
	}
	
	public function generar_formato_errores($id){
		////
		$errores = $this->model->obtener_errores($id);
		
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		$sheet = $objPHPExcel->getActiveSheet();

			//Start adding next sheets
		$i=0;
		
		if(count($errores)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'IDCLIENTE');
			 $objWorkSheet->setCellValue('B1', 'IDEMPLEADO');
			 $objWorkSheet->setCellValue('C1', 'FECHA');
			 $objWorkSheet->setCellValue('D1', 'ERRORES');
			 $m=2;
			 foreach($errores as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['idCliente']);
				  $objWorkSheet->setCellValue('B'.$m, $row['idEmpleado']);
				  $objWorkSheet->setCellValue('C'.$m, $row['fecha']);
				  $objWorkSheet->setCellValue('D'.$m, $row['comentario']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("ERRORES");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		$i++;

		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="errores_carga.xlsx"');
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');	
		////
	}									 


	public function obtener_proyecto_general(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		
		$idTipoUsuario = $data->{'idTipoUsuario'};
		$idProyecto = $data->{'idProyecto'};

		$tipoUsuario = $this->model->obtener_proyecto_general_1($idTipoUsuario,$idProyecto);

		if (!empty($tipoUsuario)) {
			$result['result'] = 1;
			$result['data']['idProyecto'] = $tipoUsuario['idProyectoGeneral'];
		}

		echo json_encode($result);
	}
	
	public function obtener_grupocanal_general(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		
		$idGrupoCanal = $data->{'idGrupoCanal'};

		$idGrupoCanal = $this->model->obtener_grupocanal_general($idGrupoCanal);

		if (!empty($idGrupoCanal)) {
			$result['result'] = 1;
			$result['data']['idGrupoCanal'] = $idGrupoCanal['idGrupoCanalGeneral'];
		}

		echo json_encode($result);
	}


	public function cargaMasivaExcelExclusiones(){
		$result= $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();

		$array = array();
		$html = '';
		$htmlWidth = '90%';
		$data=$this->model->obtener_estado_carga_exclusiones();
		$array['data_carga']=$data;
		$idProyectoGeneral = $this->model->obtener_proyecto_general($_SESSION['idProyecto']);
		$array['tipoUsuario'] =$this->model->obtener_tipo_usuario($idProyectoGeneral['idProyectoGeneral']);
		
		$html.= $this->load->view("modulos/configuraciones/gestion/visitas/formCargaMasivoExclusiones", $array, true);
		

		$result['result'] = 1;
		$result['msg']['title'] = 'Registrar Visitas Masivo';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}


}

?>