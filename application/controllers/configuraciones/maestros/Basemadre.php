<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Basemadre extends MY_Controller{

	var $htmlClienteActivar=false;
	var $htmlTranferirAgregados=false;
	var $htmlResultado = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE LA INFORMACIÓN CORRECTAMENTE.</div>';
	var $htmlNoResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
	var $htmlNoUpdateResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA REALIZADO LA ACTUALZIACIÓN DE LA INFORMACIÓN CORRECTAMENTE, VERIFICAR DATO.</div>';

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/maestros/m_basemadre','model');
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		if (in_array($this->idTipoUsuario, [4,10])) {
			$this->htmlClienteActivar=true;
			$this->htmlTranferirAgregados=true;
		}
		$config = array();
		$config['nav']['menu_active'] = '68';
		$config['css']['style'] = array(
			'assets/libs/dataTables-1.10.20/datatables'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			,'assets/custom/css/configuraciones/maestros/basemadre'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/languages/all'
			, 'assets/libs/handsontable@7.4.2/dist/moment/moment'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/js/configuraciones/maestros/basemadre'
			, 'assets/custom/js/carga_masiva_general'
		);

		$rs_solicitudesTipo = $this->model->obtener_listado_solicitudesTipo();

		$config['data']['icon'] = 'far fa-store';
		$config['data']['title'] = 'Basemadre';
		$config['data']['message'] = 'Lista de PDV';
		$config['data']['listaSolicictud'] = $rs_solicitudesTipo;
		$config['data']['htmlClienteActivar'] = $this->htmlClienteActivar;
		$config['data']['htmlTranferirAgregados'] = $this->htmlTranferirAgregados;
		$config['view'] = 'modulos/configuraciones/maestros/basemadre/index';

		$this->view($config);
	}

	public function resumen(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$cuenta = $data->{'cuenta_filtro'};
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input=array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		switch ($cuenta) {
			case '3':
				$rs_resumen = array();
				break;
			
			default:
				$rs_resumen = array();
				break;
		}

		$html='';
		if ( !empty($rs_resumen)) {
			$array=array();

			$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/MstBasemadreResumen", $array, true);
			
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['result'] = 1;
		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function filtrar(){
		if (in_array($this->idTipoUsuario, [4,10])) {
			$this->htmlClienteActivar=true;
			$this->htmlTranferirAgregados=true;
		}

		ini_set('memory_limit','4096M');
		set_time_limit(0);
		$result = $this->result;
		$data  = json_decode($this->input->post('data'));
		$cuenta = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['clientes'] = $data->{'txt-nombres'};
		//$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['idCuenta']=$cuenta;
		$input['idProyecto']= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		// 
	
		$rs_basemadre = $this->model->obtener_maestros_basemadre($input);

		$html='';
		if ( !empty($rs_basemadre)) {
			$array=array();
			$array['htmlClienteActivar'] = $this->htmlClienteActivar;

			foreach ($rs_basemadre as $kb => $row) {
				$array['listaBasemadre'][$row['idClienteHist']] = $row;
			}
			$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/MstBasemadreDetalle", $array, true);

			$result['result'] = 1;
		} else {
			$html .= $this->htmlNoResultado;
		}
		$result['data']['html'] = $html;
		$result['data']['datatable'] = 'tb-maestrosBasemadreDetalle';

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function cambiarEstado(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		
		$tabla = $data->{'tabla'};
		$html=''; $htmlEstado=''; $htmlEstadoChkb=''; $htmlEstadoFecFin='';
		$input=array();

		switch ($tabla) {
			case 'basemadre':
				$input['estado'] = !empty($data->{'estado'}) ? $data->{'estado'}:0;
				$input['idCliente'] = $data->{'cliente'};
				$input['idClienteHist'] = $data->{'clienteHistorico'};
				$input['fecFin'] = ($input['estado']==0 ? NULL : date('Y-m-d') );
				$fechaFin = date('d/m/Y');

				$rs_updateEstado = $this->model->update_estado_basemadre($input);
				if ( $rs_updateEstado) {
					$result['result'] = 1;
					$html.= $this->htmlResultado;

					if ( $input['estado']==0 ) {
						$htmlEstado = '<a href="javascript:;" id="ch-'.$input['idClienteHist'].'" class="btn btn-primary cambiarEstado" title="ACTIVO" data-cliente="'.$input['idCliente'].'" data-clienteHistorico="'.$input['idClienteHist'].'" data-estado="1" data-tabla="basemadre"><i class="fas fa-toggle-on fa-lg"></i></a>';
						$htmlEstadoChkb='<input type="checkbox" name="deBaja" class="dataDeBaja" data-cliente="'.$input['idCliente'].'" data-clienteHistorico="'.$input['idClienteHist'].'">';
						$htmlEstadoFecFin='<span>-</span>';
					} else {
						$htmlEstado ='<a href="javascript:;" id="ch-'.$input['idClienteHist'].'" class="btn btn-danger cambiarEstado" title="DESACTIVADO" data-cliente="'.$input['idCliente'].'" data-clienteHistorico="'.$input['idClienteHist'].'" data-estado="0" data-tabla="basemadre"><i class="fas fa-toggle-off fa-lg"></i></a>';
						$htmlEstadoChkb='<span>-</span>';
						$htmlEstadoFecFin='<span>'.$fechaFin.'</span>';
					}
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;

			case 'pg_v1':
				$input['estado'] = !empty($data->{'estado'}) ? $data->{'estado'}:0;
				$input['idClientePg'] = $data->{'cliente'};
				$input['idClienteHistPg'] = $data->{'clienteHistorico'};
				$input['fecFin'] = ($input['estado']==0 ? NULL : date('Y-m-d') );
				$fechaFin = date('d/m/Y');
				
				$rs_updateEstado = $this->model->update_estado_basemadre_pg_v1($input);
				if ( $rs_updateEstado) {
					$result['result'] = 1;
					$html.= $this->htmlResultado;

					if ( $input['estado']==0 ) {
						$htmlEstado = '<a href="javascript:;" id="ch-ca-'.$input['idClienteHistPg'].'" class="btn btn-primary cambiarEstado" title="ACTIVO" data-cliente="'.$input['idClientePg'].'" data-clienteHistorico="'.$input['idClienteHistPg'].'" data-estado="1" data-tabla="pg_v1"><i class="fas fa-toggle-on fa-lg"></i></a>';
						$htmlEstadoChkb='<input type="checkbox" name="solicitudRegistro" class="dataSolicitudRegistro" data-cliente="'.$input['idClientePg'].'" data-clienteHistorico="'.$input['idClienteHistPg'].'">';
						$htmlEstadoFecFin='<span>-</span>';
					} else {
						$htmlEstado ='<a href="javascript:;" id="ch-ca-'.$input['idClienteHistPg'].'" class="btn btn-danger cambiarEstado" title="DESACTIVADO" data-cliente="'.$input['idClientePg'].'" data-clienteHistorico="'.$input['idClienteHistPg'].'" data-estado="0" data-tabla="pg_v1"><i class="fas fa-toggle-off fa-lg"></i></a>';
						$htmlEstadoChkb='<span>-</span>';
						$htmlEstadoFecFin='<span>'.$fechaFin.'</span>';
					}
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;

			case 'clienteDeBaja':
				$input['estado'] = !empty($data->{'estado'}) ? $data->{'estado'}:0;
				$input['idCliente'] = $data->{'cliente'};
				$input['idClienteHist'] = $data->{'clienteHistorico'};
				$input['fecFin'] = ($input['estado']==0 ? NULL : date('Y-m-d') );
				$fechaFin = date('d/m/Y');

				$rs_updateEstado = $this->model->update_estado_basemadre($input);
				if ( $rs_updateEstado) {
					$result['result'] = 1;
					$html.= $this->htmlResultado;

					if ( $input['estado']==0 ) {
						$htmlEstado = '<a href="javascript:;" id="ch-'.$input['idClienteHist'].'" class="btn btn-primary cambiarEstado" title="ACTIVO" data-cliente="'.$input['idCliente'].'" data-clienteHistorico="'.$input['idClienteHist'].'" data-estado="1" data-tabla="clienteDeBaja"><i class="fas fa-toggle-on fa-lg"></i></a>';
						$htmlEstadoChkb='<span>-</span>';
						$htmlEstadoFecFin='<span>-</span>';
					} else {
						$htmlEstado ='<a href="javascript:;" id="ch-'.$input['idClienteHist'].'" class="btn btn-danger cambiarEstado" title="DESACTIVADO" data-cliente="'.$input['idCliente'].'" data-clienteHistorico="'.$input['idClienteHist'].'" data-estado="0" data-tabla="clienteDeBaja"><i class="fas fa-toggle-off fa-lg"></i></a>';
						$htmlEstadoChkb='<input type="checkbox" name="deAlta" class="dataDeAlta" data-cliente="'.$input['idCliente'].'" data-clienteHistorico="'.$input['idClienteHist'].'">';
						$htmlEstadoFecFin='<span>'.$fechaFin.'</span>';
					}
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;
			
			default:
				$html.= $this->htmlNoUpdateResultado;
				break;
		}
		
		$result['msg']['title'] = 'ACTUALIZAR ESTADO';
		$result['msg']['content'] = $html;
		$result['data']['tabla'] = $tabla;
		$result['data']['html'] = $htmlEstado;
		$result['data']['htmlChkb'] = $htmlEstadoChkb;
		$result['data']['htmlFechaFin'] = $htmlEstadoFecFin;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function cambiarEstadoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tabla = $data->{'tabla'};
		$dataClienteHistorico = $data->{'dataClienteHistorico'};
		$fecFin = $data->{'fecFin'};
		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		switch ($tabla) {
			case 'basemadre':
				if ( !empty($dataClienteHistorico)) {
					$input=array();			
					foreach ($dataClienteHistorico as $kl => $row) {
						$input['idCliente'] = !empty($row->{'cliente'}) ? $row->{'cliente'} : NULL;
						$input['idClienteHist'] = !empty($row->{'clienteHistorico'}) ? $row->{'clienteHistorico'} : NULL;
						$input['fecFin'] = $fecFin;

						$idCuenta= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
						$rs_updateEstado = $this->model->update_estado_basemadre($input);

						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= $this->htmlResultado;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html .= $this->htmlNoResultado;
				}
				break;

			case 'pg_v1':
				if ( !empty($dataClienteHistorico)) {
					$input=array();			
					foreach ($dataClienteHistorico as $kl => $row) {
						$input['idClientePg'] = !empty($row->{'cliente'}) ? $row->{'cliente'} : NULL;
						$input['idClienteHistPg'] = !empty($row->{'clienteHistorico'}) ? $row->{'clienteHistorico'} : NULL;
						$input['fecFin'] = $fecFin;

						$rs_updateEstado = $this->model->update_estado_basemadre_pg_v1($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= $this->htmlResultado;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html .= $this->htmlNoResultado;
				}
				break;

			case 'clienteDeBaja':
				if ( !empty($dataClienteHistorico)) {
					$input=array();			
					foreach ($dataClienteHistorico as $kl => $row) {
						$input['idCliente'] = !empty($row->{'cliente'}) ? $row->{'cliente'} : NULL;
						$input['idClienteHist'] = !empty($row->{'clienteHistorico'}) ? $row->{'clienteHistorico'} : NULL;
						$input['fecFin'] = NULL;


						$idCuenta= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
						$rs_updateEstado = $this->model->update_estado_basemadre($input);
						if ( $rs_updateEstado) { $rowUpdated++; } 
						else { $rowUpdatedError++;	}
					}

					$result['result'] = 1;
					$html .= $this->htmlResultado;
					$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
					if ( $rowUpdatedError>0) {
						$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
					}
				} else {
					$html .= $this->htmlNoResultado;
				}
				break;
			
			default:
				$html .= $this->htmlNoResultado;
				break;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;
		$result['data']['tabla'] = $tabla;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	/**=REGISTRAR NUEVO CLIENTE - CLIENTE HISTÓRICO=**/
	public function seleccionarPunto(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$array=array();

		$rs_basemadre = $this->model->obtener_lista_basemadre();
		if ( !empty($rs_basemadre)) {
			foreach ($rs_basemadre as $klb => $row) {
				$array['listaBasemadre'][$row['idCliente']] = $row;
			}
		}	
		
		$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_seleccionarPunto", $array, true);
		
		$result['result'] =1 ;
		$result['msg']['title'] = 'SELECCIONAR TIPO REGISTRO';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function nuevoPunto(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tipoRegistroCliente = $data->{'tipoRegistro'};
		$clienteSeleccionado = $data->{'clienteRegistro'};

		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$array=array();
		$array['tabla'] = 'buscarTabla';

		/*==NO ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LAS REGIONES DEPARTAMENTOS PROVINCIAS DISTRITOS
		$rs_regiones = $this->model->obtener_listado_regiones();
		foreach ($rs_regiones as $klr => $row) {
			$array['listaRegiones'][$row['cod_departamento']]['cod_departamento'] = $row['cod_departamento'];
			$array['listaRegiones'][$row['cod_departamento']]['departamento'] = $row['departamento'];
			$array['listaRegiones'][$row['cod_departamento']]['cod_ubigeo'] = $row['cod_ubigeo'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['cod_provincia'] = $row['cod_provincia'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['provincia'] = $row['provincia'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['cod_ubigeo'] = $row['cod_ubigeo'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['cod_distrito'] = $row['cod_distrito'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['distrito'] = $row['distrito'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['cod_ubigeo'] = $row['cod_ubigeo'];
		}

		//LISTADO DE ZONAS PELIGROSAS
		$rs_zonaPeligrosa = $this->model->obtener_zona_peligrosa();
		foreach ($rs_zonaPeligrosa as $klzp => $row) {
			$array['listaZonaPeligrosa'][$row['idZonaPeligrosa']] = $row;
		}

		//LISTADO DE FRECUENCIAS
		$rs_frecuencia = $this->model->obtener_frecuencia();
		foreach ($rs_frecuencia as $klf => $row) {
			$array['listaFrecuencia'][$row['idFrecuencia']] = $row;
		}

		/*==ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LA CUENTA-PROYECTO
		$rs_cuentaProyecto = $this->model->obtener_cuenta_proyecto($input);
		foreach ($rs_cuentaProyecto as $klcp => $row) {
			$array['listaCuentaProyecto'][$row['idCuenta']]['idCuenta'] = $row['idCuenta'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['cuenta'] = $row['cuenta'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['listaProyectos'][$row['idProyecto']]['idProyecto'] = $row['idProyecto'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['listaProyectos'][$row['idProyecto']]['proyecto'] = $row['proyecto'];
		}

		//LISTADO DE CUENTA - GRUPO CANAL - CANAL
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CANAL
		if (!empty($this->permisos['canal'])) { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal_usuarioHistCanal($input); } 
		else { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal($input); }
		//
		foreach ($rs_grupoCanalCanal as $kgc => $row) {
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['idGrupoCanal'] = $row['idGrupoCanal'];
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['grupoCanal'] = $row['grupoCanal'];
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['idCanal'] = $row['idCanal'];
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['canal'] = $row['canal'];
			if (!empty($row['idSubCanal'])) {
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaSubCanal'][$row['idSubCanal']]['idSubCanal'] = $row['idSubCanal'];
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaSubCanal'][$row['idSubCanal']]['subCanal'] = $row['subCanal'];
			}
			if (!empty($row['idClienteTipo'])) {
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaClienteTipo'][$row['idClienteTipo']]['idClienteTipo'] = $row['idClienteTipo'];
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaClienteTipo'][$row['idClienteTipo']]['clienteTipo'] = $row['clienteTipo'];
			}
		}

		//LISTADO DE CUENTA-PROYECTO-ZONA
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE ZONAS
		if ( !empty($this->permisos['zona'])) { $rs_zona = $this->model->obtener_zonas_usuarioHistZona($input); }
		else { $rs_zona = $this->model->obtener_zonas($input); }
		//
		foreach ($rs_zona as $klz => $row) {
			$array['listaCuentaProyectoZona'][$row['idCuenta']][$row['idProyecto']]['listaZonas'][$row['idZona']]['idZona'] = $row['idZona'];
			$array['listaCuentaProyectoZona'][$row['idCuenta']][$row['idProyecto']]['listaZonas'][$row['idZona']]['zona'] = $row['zona'];
		}

		//LISTADO DE LAS PLAZAS
		//VERIFICAMOS QUE EXISTA PERMISOS DE PLAZAS
		if ( !empty($this->permisos['plaza'])) { $rs_plaza = $this->model->obtener_plazas_todos_usuarioHistPlaza($input); }
		else { $rs_plaza = $this->model->obtener_plazas_todos(); }
		//
		foreach ($rs_plaza as $klp => $row) {
			$array['listaPlazaTodo'][$row['idPlaza']] = $row;
		}

		//OBTENER PLAZAS MAYORISTAS
		$rs_plaza = $this->model->obtener_plazas_mayoristas();
		foreach ($rs_plaza as $klp => $row) {
			$array['listaPlazaMayorista'][$row['idPlaza']] = $row;
		}

		//LISTADO DE DISTRIBUDIORA SUCURSAL
		//VERIFICAMOS SI ES QUE EXISTEN PERMISOS DE DISTRIBUDIORA SUCURSAL
		if (!empty($this->permisos['distribuidoraSucursal'])) {	$rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal_usuarioHistDS($input); } 
		else { $rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal($input); }
		//
		foreach ($rs_distribuidoraSucursal as $klds => $row) {
			$array['listaDistribuidoraSucursal'][$row['idDistribuidoraSucursal']] = $row;
		}

		//LISTADO DE CADENA - BANNER
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CADENA-BANNER
		if ( !empty($this->permisos['banner']) ) { $rs_cadenaBanner = $this->model->obtener_cadena_banner_usuarioHistBanner(); }
		else { $rs_cadenaBanner = $this->model->obtener_cadena_banner(); }
		//
		foreach ($rs_cadenaBanner as $klcb => $row) {
			$array['listaCadenaBanner'][$row['idCadena']]['idCadena'] = $row['idCadena'];
			$array['listaCadenaBanner'][$row['idCadena']]['cadena'] = $row['cadena'];
			$array['listaCadenaBanner'][$row['idCadena']]['listaBanner'][$row['idBanner']]['idBanner'] = $row['cadena'];
			$array['listaCadenaBanner'][$row['idCadena']]['listaBanner'][$row['idBanner']]['banner'] = $row['banner'];
		}

		//TIPO DE REGISTRO CLIENTE - EXISTENTE O NO EXISTENTE
		if ($data->{'tipoRegistro'}==1) {
			$rs_dataCliente = $this->model->obtener_data_cliente($clienteSeleccionado);
			foreach ($rs_dataCliente as $klc => $row) {
				$array['clienteHistorico']['idCliente'] = $row['idCliente'];
				$array['clienteHistorico']['nombreComercial'] = $row['nombreComercial'];
				$array['clienteHistorico']['razonSocial'] = $row['razonSocial'];
				$array['clienteHistorico']['ruc'] = $row['ruc'];
				$array['clienteHistorico']['dni'] = $row['dni'];
			}
		}

		$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_nuevoEditarPunto", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVO PUNTO';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoPunto(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$idUsuario = $this->idUsuario;

		$html='';
		$htmlWidth= '50%';
		$htmlButtons = 1;
		$htmlGuardar = '';
		$rowInserted=0;
		//$html.= $this->htmlResultado;
		
		$deTodosModos = ( !empty($data->{'deTodosModos'}) && isset($data->{'deTodosModos'}) ) ? $data->{'deTodosModos'} : 0;

		$nombreComercial = ( !empty($data->{'nombreComercial'}) && isset($data->{'nombreComercial'}) ) ? $data->{'nombreComercial'} : NULL;
		$razonSocial = ( !empty($data->{'razonSocial'}) && isset($data->{'razonSocial'}) ) ? $data->{'razonSocial'} : NULL;
		$numeroRuc = ( !empty($data->{'numeroRuc'}) && isset($data->{'numeroRuc'}) ) ? $data->{'numeroRuc'} : NULL;
		$numeroDni = ( !empty($data->{'numeroDni'}) && isset($data->{'numeroDni'}) ) ? $data->{'numeroDni'} : NULL;

		$codigoUbigeo = ( !empty($data->{'cod_ubigeo'}) && isset($data->{'cod_ubigeo'}) ) ? $data->{'cod_ubigeo'} : NULL;
		$direccion = ( !empty($data->{'direccion'}) && isset($data->{'direccion'}) ) ? $data->{'direccion'} : NULL;
		$referencia = ( !empty($data->{'referencia'}) && isset($data->{'referencia'}) ) ? $data->{'referencia'} : NULL;

		$idZonaPeligrosa = ( !empty($data->{'zonaPeligrosa'}) && isset($data->{'zonaPeligrosa'}) ) ? $data->{'zonaPeligrosa'} : NULL;
		$latitud = ( !empty($data->{'latitud'}) && isset($data->{'latitud'}) ) ? $data->{'latitud'} : NULL;
		$longitud = ( !empty($data->{'longitud'}) && isset($data->{'longitud'}) ) ? $data->{'longitud'} : NULL;

		/*$departamento= ( !empty($data->{'departamento'}) && isset($data->{'departamento'}) ) ? $data->{'departamento'} : NULL;
		$provincia = ( !empty($data->{'provincia'}) && isset($data->{'provincia'}) ) ? $data->{'provincia'} : NULL;
		$distrito = ( !empty($data->{'distrito'}) && isset($data->{'distrito'}) ) ? $data->{'distrito'} : NULL;*/

		$fechaInicio = ( !empty($data->{'fechaInicio'}) && isset($data->{'fechaInicio'}) ) ? $data->{'fechaInicio'} : NULL;
		$fechaFin = ( !empty($data->{'fechaFin'}) && isset($data->{'fechaFin'}) ) ? $data->{'fechaFin'} : NULL;
		$idFrecuencia = ( !empty($data->{'frecuencia'}) && isset($data->{'frecuencia'}) ) ? $data->{'frecuencia'} : NULL;
		$idCuenta = ( !empty($data->{'cuenta'}) && isset($data->{'cuenta'}) ) ? $data->{'cuenta'} : NULL;
		$idProyecto = ( !empty($data->{'proyecto'}) && isset($data->{'proyecto'}) ) ? $data->{'proyecto'} : NULL;
		$idZona = ( !empty($data->{'zona'}) && isset($data->{'zona'}) ) ? $data->{'zona'} : NULL;
		$flagCartera = ( !empty($data->{'flagCartera'}) && isset($data->{'flagCartera'}) ) ? $data->{'flagCartera'} : 1;
		$codigoCliente = ( !empty($data->{'codCliente'}) && isset($data->{'codCliente'}) ) ? $data->{'codCliente'} : NULL;

		$idGrupoCanal = ( !empty($data->{'grupoCanal'}) && isset($data->{'grupoCanal'}) ) ? $data->{'grupoCanal'} : NULL;
		$idCanal = ( !empty($data->{'canal'}) && isset($data->{'canal'}) ) ? $data->{'canal'} : NULL;
		$idClienteTipo = ( !empty($data->{'clienteTipo'}) && isset($data->{'clienteTipo'}) ) ? $data->{'clienteTipo'} : NULL;

		$idPlaza = ( !empty($data->{'plaza'}) && isset($data->{'plaza'}) ) ? $data->{'plaza'} : NULL;
		$dataDistribuidoraSucursal = ( !empty($data->{'distribuidoraSucursalSelected'}) && isset($data->{'distribuidoraSucursalSelected'}) ) ? $data->{'distribuidoraSucursalSelected'} : NULL;

		$idCadena = ( !empty($data->{'cadena'}) && isset($data->{'cadena'}) ) ? $data->{'cadena'} : NULL;
		$idBanner = ( !empty($data->{'banner'}) && isset($data->{'banner'}) ) ? $data->{'banner'} : NULL;

		$idSegNegocio = NULL; $idSegClienteTradicional = NULL; $idSegClienteModerno = NULL;

		/********************SEGMETACIÓN NEGOCIO******************/
		$arraySegNegocio=array();
		$arraySegNegocio['idCanal']=$idCanal;
		$arraySegNegocio['idClienteTipo']=$idClienteTipo;
		//
		$rs_segmentacionNegocio = $this->model->obtener_segmentacion_negocio($arraySegNegocio);
		if ( !empty($rs_segmentacionNegocio)) {
			$idSegNegocio = $rs_segmentacionNegocio[0]['idSegNegocio'];
		} else {
			$insertarSegNegocio = $this->model->insertar_segmentacion_negocio($arraySegNegocio);
			if ($insertarSegNegocio) {
				$idSegNegocio = $this->db->insert_id();
			}
		}

		/************SEGMENTACION CLIENTE TRADICIONAL**********/
		$filtroWhere='';
		if ( !empty($idPlaza) || !empty($dataDistribuidoraSucursal)) {
			//PLAZA
			$filtroWhere.= ( !empty($idPlaza) ? " AND data.idPlaza IN (".$idPlaza.")" : " AND data.idPlaza IS NULL" );
			//DISTRIBUIDORA SUCURSAL
			if (!empty($dataDistribuidoraSucursal)) {
				if ( is_array($dataDistribuidoraSucursal)) {
					$stringDS = implode(",", $dataDistribuidoraSucursal);
					$filtroWhere.= " AND data.idDistribuidoraSucursal IN ('".$stringDS."')";
				} else {
					$filtroWhere.= " AND data.idDistribuidoraSucursal IN ('".$dataDistribuidoraSucursal."')";
				}
			} else {
				$filtroWhere.= " AND data.idSegClienteTradicional IS NULL";
			}
			//
			
			/***VERIFICAMOS EXISTENCIA***/
			$rs_segmentacionClienteTradicional = $this->model->obtener_segmentacion_cliente_tradicional_v2($filtroWhere);
			if (!empty($rs_segmentacionClienteTradicional)) {
				//EXISTE DATA
				$idSegClienteTradicional = $rs_segmentacionClienteTradicional[0]['idSegClienteTradicional'];
			} else {
				//NO EXISTE DATA
				$arrayCabecera=array();
				$arrayCabecera['idPlaza']= ( !empty($idPlaza) ? $idPlaza:NULL );
				$arrayCabecera['idDistribuidoraSucursal']=NULL;

				//INSERTAMOS LA CABECERA DE LA SEGMENTACION CLIENTE TRADICIONAL
				$insertSegmentacionClienteTradicional = $this->model->insert_segmentacion_cliente_tradicional_v1($arrayCabecera);
				if ( $insertSegmentacionClienteTradicional) {
					$idSegClienteTradicional = $this->db->insert_id();
				} else {
					$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR LA PLAZA.</div>';
				}

				//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
				if (!empty($dataDistribuidoraSucursal)) {
					if (is_array($dataDistribuidoraSucursal)) {
						foreach ($dataDistribuidoraSucursal as $kdd => $value) {
							$arrayDetalleDS=array();
							$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
							$arrayDetalleDS['idDistribuidoraSucursal']=$value;
							//
							$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
						}
					} else {
						$arrayDetalleDS=array();
						$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
						$arrayDetalleDS['idDistribuidoraSucursal']=$dataDistribuidoraSucursal;
						//
						$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
					}
				}				
			}
		}

		/***********SEGMENTACION CLIENTE MODERNO**********/
		if ( !empty($idBanner)) {
			$rs_segmentacionClienteModeno = $this->model->obtener_segmentacion_cliente_moderno($idBanner);
			if ( !empty($rs_segmentacionClienteModeno)) {
				$idSegClienteModerno = $rs_segmentacionClienteModeno[0]['idSegClienteModerno'];
			}
		}

		/******VERIFICACIÓN DE LA EXISTENCIA DEL NUEVO PUNTO A CREAR*****/
		//VERIFICACIÓN DE LA EXISTENCIA DE CLIENTE
		$arrayData=array();
		$arrayData['nombreComercial'] = $nombreComercial;
		$arrayData['razonSocial'] = $razonSocial;
		$arrayData['ruc'] = $numeroRuc;
		$arrayData['dni'] = $numeroDni;

		$rs_verificarExistencia = $this->model->obtener_verificacion_existente_pg_v1($arrayData);

		//VERIFICACIÓN DE LA EXISTENCIA DE CLIENTE HISTÓRICO
		$arrayDataHistorico=array();
		$arrayDataHistorico['nombreComercial'] = $nombreComercial;
		$arrayDataHistorico['razonSocial'] = $razonSocial;
		//$arrayDataHistorico['ruc'] = $numeroRuc;
		//$arrayDataHistorico['dni'] = $numeroDni;
		$arrayDataHistorico['idCuenta'] = $idCuenta;
		$arrayDataHistorico['idProyecto'] = $idProyecto;
		$arrayDataHistorico['idSegNegocio'] = $idSegNegocio;
		$arrayDataHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
		$arrayDataHistorico['idSegClienteModerno'] = $idSegClienteModerno;

		$rs_verificarExistenciaHistorico = $this->model->obtener_verificacion_existente_historico_pg_v1($arrayDataHistorico);

		//VERIFICACIÓN DE POSIBLES EXISTENTES CLIENTES
		//$rs_verificarPosiblesExistencia = $this->model->obtener_verificacion_posibles_existentes($arrayData);
		/*Esta verificación se cumplía anteriormente, porque se enviaba la información directo a la tabla trade.cliente,
		pero ahora se envíara a una tabla temporal y desde ahí se validara si se carga a la trade.cliente.*/
		$rs_verificarPosiblesExistencia = array();

		//HACEMOS UNA LÓGICA PARA MANDAR UN MENSAJE A LA VENTANA DEL USUARIO REGISTRADOR
		if ( !empty($rs_verificarExistencia) && !empty($rs_verificarExistenciaHistorico) && $deTodosModos==0 ) {
			$html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-store-alt"></i> EL CLIENTE INGRESADO, <strong>'.$arrayData['nombreComercial'].'</strong>; YA SE ENCUENTRA REGISTRADO</div>';
			$htmlWidth = '50%';

		} elseif ( !empty($rs_verificarPosiblesExistencia) && $deTodosModos==0 ) {
			$array=array();
			$array['listaClientes'] = $rs_verificarPosiblesExistencia;
			//
			$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_posiblesPuntos", $array, true);
			$htmlWidth = '60%';
			$htmlButtons = 2;
			$htmlGuardar = 'Basemadre.confirmarGuardarNuevoPunto();';

		} elseif ( !empty( $rs_verificarExistencia ) && empty( $rs_verificarExistenciaHistorico )) {
			//INSERTAMOS EL REGISTRO HISTÓRICO YA QUE EL CLIENTE SI EXISTE
			$idClienteVerificado = $rs_verificarExistencia[0]['idClientePg'];

			$inputHistorico = array();
			$inputHistorico['idClientePg'] = $idClienteVerificado;
			$inputHistorico['nombreComercial'] = $nombreComercial;
			$inputHistorico['razonSocial'] = $razonSocial;
			//$inputHistorico['dni'] = $numeroDni;
			//$inputHistorico['ruc'] = $numeroRuc;
			$inputHistorico['idSegNegocio'] = $idSegNegocio;
			$inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
			$inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
			$inputHistorico['fecIni'] = $fechaInicio;
			$inputHistorico['fecFin'] = $fechaFin;
			$inputHistorico['idCuenta'] = $idCuenta;
			$inputHistorico['idProyecto'] = $idProyecto;
			$inputHistorico['idFrecuencia'] = $idFrecuencia;
			$inputHistorico['idZona'] = $idZona;
			$inputHistorico['idZonaPeligrosa'] = $idZonaPeligrosa;
			$inputHistorico['flagCartera'] = $flagCartera;
			$inputHistorico['codCliente'] = $codigoCliente;
			$inputHistorico['cod_ubigeo'] = $codigoUbigeo;
			$inputHistorico['direccion'] = $direccion;
			$inputHistorico['referencia'] = $referencia;
			$inputHistorico['latitud'] = $latitud;
			$inputHistorico['longitud'] = $longitud;

			$insertClienteHistorico = $this->model->insertar_cliente_historico_v1($inputHistorico);
			if ($insertClienteHistorico) {
				$rowInserted++;
				$result['result']=1;
				$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEL CLIENTE <strong>'.$arrayData['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
				$this->enviarNotificacionNuevoRegistro($rowInserted);
			} else {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> NO SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEL CLIENTE <strong>'.$arrayData['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
			}

		} elseif ( empty( $rs_verificarExistencia ) && empty( $rs_verificarExistenciaHistorico ) ) {
			//INSERTAMOS AL CLIENTE
			$inputCliente=array();
			$inputCliente['nombreComercial'] = $nombreComercial;
			$inputCliente['razonSocial'] = $razonSocial;
			$inputCliente['ruc'] = $numeroRuc;
			$inputCliente['dni'] = $numeroDni;
			//$inputCliente['cod_ubigeo'] = $codigoUbigeo;
			//$inputCliente['direccion'] = $direccion;
			//$inputCliente['idZonaPeligrosa'] = $idZonaPeligrosa;
			//$inputCliente['latitud'] = $latitud;
			//$inputCliente['longitud'] = $longitud;
			

			$insertCliente = $this->model->insertar_cliente_pg_v1($inputCliente);

			if ( $insertCliente ) {
				$idClienteInserted = $this->db->insert_id();
				$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR EL CLIENTE <strong>'.$arrayData['nombreComercial'].'</strong> CORRECTAMENTE.</div>';

				$inputHistorico = array();
				$inputHistorico['idClientePg'] = $idClienteInserted;
				$inputHistorico['nombreComercial'] = $nombreComercial;
				$inputHistorico['razonSocial'] = $razonSocial;
				//$inputHistorico['dni'] = $numeroDni;
				//$inputHistorico['ruc'] = $numeroRuc;
				$inputHistorico['idSegNegocio'] = $idSegNegocio;
				$inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
				$inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
				$inputHistorico['fecIni'] = $fechaInicio;
				$inputHistorico['fecFin'] = $fechaFin;
				$inputHistorico['idCuenta'] = $idCuenta;
				$inputHistorico['idProyecto'] = $idProyecto;
				$inputHistorico['idFrecuencia'] = $idFrecuencia;
				$inputHistorico['idZona'] = $idZona;
				$inputHistorico['idZonaPeligrosa'] = $idZonaPeligrosa;
				$inputHistorico['flagCartera'] = $flagCartera;
				$inputHistorico['codCliente'] = $codigoCliente;
				$inputHistorico['cod_ubigeo'] = $codigoUbigeo;
				$inputHistorico['direccion'] = $direccion;
				$inputHistorico['referencia'] = $referencia;
				$inputHistorico['latitud'] = $latitud;
				$inputHistorico['longitud'] = $longitud;
				$inputHistorico['idUsuarioSolicitud'] = $idUsuario;

				$insertClienteHistorico = $this->model->insertar_cliente_historico_v1($inputHistorico);
				if ($insertClienteHistorico) {
					$rowInserted++;
					$result['result']=1;
					$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEl CLIENTE <strong>'.$arrayData['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
					$this->enviarNotificacionNuevoRegistro($rowInserted);
				} else {
					$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> NO SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEL CLIENTE <strong>'.$arrayData['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
				}

			} else {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR EL CLIENTE <strong>'.$arrayData['nombreComercial'].'</strong>.</div>';
			}
		}	

		$result['msg']['title'] = 'REGISTRAR PUNTO DE VENTA';
		$result['msg']['content'] = $html;
		$result['data']['width'] = $htmlWidth;
		$result['data']['htmlButtons'] = $htmlButtons;
		$result['data']['htmlGuardar'] = $htmlGuardar;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function editarPunto(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$tablaOperacion = $data->{'tabla'};
		$htmlWidth = '90%';
		$enviarGrupoCanal = NULL;
		
		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;

		$idCuenta= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$idProyecto= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$input['listaCuentas']= $idCuenta;
		$input['listaProyectos']= $idProyecto;

		$array=array();
		$array['tabla'] = $tablaOperacion;

		/*==NO ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LAS REGIONES DEPARTAMENTOS PROVINCIAS DISTRITOS
		$rs_regiones = $this->model->obtener_listado_regiones();
		foreach ($rs_regiones as $klr => $row) {
			$array['listaRegiones'][$row['cod_departamento']]['cod_departamento'] = $row['cod_departamento'];
			$array['listaRegiones'][$row['cod_departamento']]['departamento'] = $row['departamento'];
			$array['listaRegiones'][$row['cod_departamento']]['cod_ubigeo'] = $row['cod_ubigeo'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['cod_provincia'] = $row['cod_provincia'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['provincia'] = $row['provincia'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['cod_ubigeo'] = $row['cod_ubigeo'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['cod_distrito'] = $row['cod_distrito'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['distrito'] = $row['distrito'];
			$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['cod_ubigeo'] = $row['cod_ubigeo'];
		}

		//LISTADO DE ZONAS PELIGROSAS
		$rs_zonaPeligrosa = $this->model->obtener_zona_peligrosa();
		foreach ($rs_zonaPeligrosa as $klzp => $row) {
			$array['listaZonaPeligrosa'][$row['idZonaPeligrosa']] = $row;
		}

		//LISTADO DE FRECUENCIAS
		$rs_frecuencia = $this->model->obtener_frecuencia();
		foreach ($rs_frecuencia as $klf => $row) {
			$array['listaFrecuencia'][$row['idFrecuencia']] = $row;
		}

		/*==ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LA CUENTA-PROYECTO
		$rs_cuentaProyecto = $this->model->obtener_cuenta_proyecto($input);
		foreach ($rs_cuentaProyecto as $klcp => $row) {
			$array['listaCuentaProyecto'][$row['idCuenta']]['idCuenta'] = $row['idCuenta'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['cuenta'] = $row['cuenta'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['listaProyectos'][$row['idProyecto']]['idProyecto'] = $row['idProyecto'];
			$array['listaCuentaProyecto'][$row['idCuenta']]['listaProyectos'][$row['idProyecto']]['proyecto'] = $row['proyecto'];
		}

		//LISTADO DE CUENTA - GRUPO CANAL - CANAL
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CANAL
		if (!empty($this->permisos['canal'])) { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal_usuarioHistCanal($input); } 
		else { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal($input); }
		//
		foreach ($rs_grupoCanalCanal as $kgc => $row) {
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['idGrupoCanal'] = $row['idGrupoCanal'];
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['grupoCanal'] = $row['grupoCanal'];
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['idCanal'] = $row['idCanal'];
			$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['canal'] = $row['canal'];
			if (!empty($row['idSubCanal'])) {
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaSubCanal'][$row['idSubCanal']]['idSubCanal'] = $row['idSubCanal'];
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaSubCanal'][$row['idSubCanal']]['subCanal'] = $row['subCanal'];
			}
			if (!empty($row['idClienteTipo'])) {
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaClienteTipo'][$row['idClienteTipo']]['idClienteTipo'] = $row['idClienteTipo'];
				$array['listaCuentaGrupoCanalSubCanalClienteTipo'][$row['idCuenta']]['listaGrupoCanal'][$row['idGrupoCanal']]['listaCanal'][$row['idCanal']]['listaClienteTipo'][$row['idClienteTipo']]['clienteTipo'] = $row['clienteTipo'];
			}
		}

		//LISTADO DE CADENA - BANNER
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CADENA-BANNER
		if ( !empty($this->permisos['banner']) ) { $rs_cadenaBanner = $this->model->obtener_cadena_banner_usuarioHistBanner(); }
		else { $rs_cadenaBanner = $this->model->obtener_cadena_banner(); }
		//
		foreach ($rs_cadenaBanner as $klcb => $row) {
			$array['listaCadenaBanner'][$row['idCadena']]['idCadena'] = $row['idCadena'];
			$array['listaCadenaBanner'][$row['idCadena']]['cadena'] = $row['cadena'];
			$array['listaCadenaBanner'][$row['idCadena']]['listaBanner'][$row['idBanner']]['idBanner'] = $row['idBanner'];
			$array['listaCadenaBanner'][$row['idCadena']]['listaBanner'][$row['idBanner']]['banner'] = $row['banner'];
		}

		//LISTADO DE CUENTA-PROYECTO-ZONA
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE ZONAS
		if ( !empty($this->permisos['zona'])) { $rs_zona = $this->model->obtener_zonas_usuarioHistZona($input); }
		else { $rs_zona = $this->model->obtener_zonas($input); }
		//
		foreach ($rs_zona as $klz => $row) {
			$array['listaCuentaProyectoZona'][$row['idCuenta']][$row['idProyecto']]['listaZonas'][$row['idZona']]['idZona'] = $row['idZona'];
			$array['listaCuentaProyectoZona'][$row['idCuenta']][$row['idProyecto']]['listaZonas'][$row['idZona']]['zona'] = $row['zona'];
		}

		//LISTADO DE LAS PLAZAS
		//VERIFICAMOS QUE EXISTA PERMISOS DE PLAZAS
		if ( !empty($this->permisos['plaza'])) { $rs_plaza = $this->model->obtener_plazas_todos_usuarioHistPlaza($input); }
		else { $rs_plaza = $this->model->obtener_plazas_todos(); }
		//
		foreach ($rs_plaza as $klp => $row) {
			$array['listaPlazaTodo'][$row['idPlaza']] = $row;
		}

		//OBTENER PLAZAS MAYORISTAS
		$rs_plaza = $this->model->obtener_plazas_mayoristas();
		foreach ($rs_plaza as $klp => $row) {
			$array['listaPlazaMayorista'][$row['idPlaza']] = $row;
		}

		//LISTADO DE DISTRIBUDIORA SUCURSAL
		//VERIFICAMOS SI ES QUE EXISTEN PERMISOS DE DISTRIBUDIORA SUCURSAL
		if (!empty($this->permisos['distribuidoraSucursal'])) {	$rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal_usuarioHistDS($input); } 
		else { $rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal(); }
		//
		foreach ($rs_distribuidoraSucursal as $klds => $row) {
			$array['listaDistribuidoraSucursal'][$row['idDistribuidoraSucursal']] = $row;
		}

		/*OBTENEMOS DATA CLIENTE HISTÓRICO*/
		$input=array();

		switch ($tablaOperacion) {
			case 'basemadre':

				$idCuenta= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
				$input['idCliente'] = !empty($data->{'cliente'}) ? $data->{'cliente'}:NULL;
				$input['idClienteHist'] = !empty($data->{'clienteHistorico'}) ? $data->{'clienteHistorico'}:NULL;
				$rs_clienteHistorico = $this->model->obtener_cliente_historico($input);
				break;
			
			case 'pg_v1':
				$input['idClientePg'] = !empty($data->{'cliente'}) ? $data->{'cliente'}:NULL;
				$input['idClienteHistPg'] = !empty($data->{'clienteHistorico'}) ? $data->{'clienteHistorico'}:NULL;

				$rs_clienteHistorico = $this->model->obtener_cliente_historico_v1($input);
				break;

			default:
				$rs_clienteHistorico = array();
				break;
		}
		
		if ( !empty($rs_clienteHistorico)) {
			foreach ($rs_clienteHistorico as $klc => $row) {
				$array['clienteHistorico']['idClienteHist'] = $row['idClienteHist'];
				$array['clienteHistorico']['idCliente'] = $row['idCliente'];
				$array['clienteHistorico']['nombreComercial'] = $row['nombreComercial'];
				$array['clienteHistorico']['razonSocial'] = $row['razonSocial'];
				$array['clienteHistorico']['ruc'] = $row['ruc'];
				$array['clienteHistorico']['dni'] = $row['dni'];
				$array['clienteHistorico']['idGrupoCanal'] = $row['idGrupoCanal'];
				$array['clienteHistorico']['idCanal'] = $row['idCanal'];
				$array['clienteHistorico']['idClienteTipo'] = $row['idClienteTipo'];
				$array['clienteHistorico']['idSegNegocio'] = $row['idSegNegocio'];
				$array['clienteHistorico']['idSegClienteTradicional'] = $row['idSegClienteTradicional'];
				$array['clienteHistorico']['idPlaza'] = $row['idPlaza'];
				$array['clienteHistorico']['distribuidoraSucursal'][$row['idDistribuidoraSucursal']]['idDistribuidoraSucursal'] = $row['idDistribuidoraSucursal'];
				$array['clienteHistorico']['distribuidoraSucursal'][$row['idDistribuidoraSucursal']]['distribuidoraSucursal'] = $row['distribuidoraSucursal'];
				$array['clienteHistorico']['idSegClienteModerno'] = $row['idSegClienteModerno'];
				$array['clienteHistorico']['idCadena'] = $row['idCadena'];
				$array['clienteHistorico']['idBanner'] = $row['idBanner'];
				$array['clienteHistorico']['fecIni'] = $row['fecIni'];
				$array['clienteHistorico']['fecFin'] = $row['fecFin'];
				$array['clienteHistorico']['idFrecuencia'] = $row['idFrecuencia'];
				$array['clienteHistorico']['idCuenta'] = $row['idCuenta'];
				$array['clienteHistorico']['cuenta'] = $row['cuenta'];
				$array['clienteHistorico']['idProyecto'] = $row['idProyecto'];
				$array['clienteHistorico']['proyecto'] = $row['proyecto'];
				$array['clienteHistorico']['idZona'] = $row['idZona'];
				$array['clienteHistorico']['flagCartera'] = $row['flagCartera'];
				//$array['clienteHistorico']['idSegCliente'] = $row['idSegCliente'];
				$array['clienteHistorico']['codCliente'] = $row['codCliente'];
				$array['clienteHistorico']['cod_departamento'] = $row['cod_departamento'];
				$array['clienteHistorico']['departamento'] = $row['departamento'];
				$array['clienteHistorico']['cod_provincia'] = $row['cod_provincia'];
				$array['clienteHistorico']['provincia'] = $row['provincia'];
				$array['clienteHistorico']['cod_distrito'] = $row['cod_distrito'];
				$array['clienteHistorico']['distrito'] = $row['distrito'];
				$array['clienteHistorico']['cod_ubigeo'] = $row['cod_ubigeo'];
				$array['clienteHistorico']['direccion'] = $row['direccion'];
				$array['clienteHistorico']['referencia'] = $row['referencia'];
				$array['clienteHistorico']['latitud'] = $row['latitud'];
				$array['clienteHistorico']['longitud'] = $row['longitud'];
				$array['clienteHistorico']['idZonaPeligrosa'] = $row['idZonaPeligrosa'];
			}

			/*=Datos de la vista=*/
			$idCuenta=$array['clienteHistorico']['idCuenta'];
			$idProyecto=$array['clienteHistorico']['idProyecto'];
			$idZona=$array['clienteHistorico']['idZona'];
			$idGrupoCanal = $array['clienteHistorico']['idGrupoCanal'];
			$idCanal = $array['clienteHistorico']['idCanal'];
			$idClienteTipo = $array['clienteHistorico']['idClienteTipo'];
			$idPlaza = $array['clienteHistorico']['idPlaza'];
			$distribuidoraSucursal = $array['clienteHistorico']['distribuidoraSucursal'];

			$idCadena = $array['clienteHistorico']['idCadena'];
			$idBanner = $array['clienteHistorico']['idBanner'];

			$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_nuevoEditarPunto", $array, true);
		} else {
			$htmlWidth = '40%';
			$html .= $this->htmlNoResultado;
		}
		
		//RESULT
		$result['result'] = 1;
		$result['msg']['title'] = 'EDITAR CLIENTE HISTÓRICO';
		$result['data']['html'] = $html;
		$result['data']['cuenta'] = !empty($idCuenta) ? $idCuenta:NULL;
		$result['data']['proyecto'] = !empty($idProyecto) ? $idProyecto:NULL;
		$result['data']['zona'] = !empty($idZona) ? $idZona:NULL;
		$result['data']['grupoCanal'] = !empty($idGrupoCanal) ? $idGrupoCanal:NULL;
		$result['data']['canal'] = !empty($idCanal) ? $idCanal:NULL;
		$result['data']['clienteTipo'] = !empty($idClienteTipo) ? $idClienteTipo:NULL;
		$result['data']['plaza'] = !empty($idPlaza) ? $idPlaza:NULL;
		$result['data']['distribuidoraSucursal'] = !empty($distribuidoraSucursal) ? $distribuidoraSucursal:NULL;
		$result['data']['cadena'] = !empty($idCadena) ? $idCadena:NULL;
		$result['data']['banner'] = !empty($idBanner) ? $idBanner:NULL;
		$result['data']['htmlWidth'] = $htmlWidth;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarPunto(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth= '30%';
		$htmlButtons = 1;
		$tablaOperacion = $data->{'tabla'};

		if ( !empty($data->{'clienteHistorico'})) {
			$idSegNegocio = NULL; $idSegClienteTradicional = NULL; $idSegClienteModerno = NULL;

			/******SEGMETACIÓN NEGOCIO*******/
			$idGrupoCanal = ( !empty($data->{'grupoCanal'}) && isset($data->{'grupoCanal'}) ) ? $data->{'grupoCanal'} : NULL;
			$idCanal = ( !empty($data->{'canal'}) && isset($data->{'canal'}) ) ? $data->{'canal'} : NULL;
			$idClienteTipo = ( !empty($data->{'clienteTipo'}) && isset($data->{'clienteTipo'}) ) ? $data->{'clienteTipo'} : NULL;
			//
			$arraySegNegocio=array();
			$arraySegNegocio['idCanal']=$idCanal;
			$arraySegNegocio['idClienteTipo']=$idClienteTipo;

			$rs_segmentacionNegocio = $this->model->obtener_segmentacion_negocio($arraySegNegocio);
			if ( !empty($rs_segmentacionNegocio)) {
				$idSegNegocio = $rs_segmentacionNegocio[0]['idSegNegocio'];
			} else {
				$insertarSegNegocio = $this->model->insertar_segmentacion_negocio($arraySegNegocio);
				if ($insertarSegNegocio) {
					$idSegNegocio = $this->db->insert_id();
				}
			}

			/*******SEGMENTACION CLIENTE TRADICIONAL******/
			$filtroWhere='';
			$idPlaza = ( !empty($data->{'plaza'}) && isset($data->{'plaza'}) ) ? $data->{'plaza'} : NULL;
			$dataDistribuidoraSucursal = ( !empty($data->{'distribuidoraSucursalSelected'}) && isset($data->{'distribuidoraSucursalSelected'}) ) ? $data->{'distribuidoraSucursalSelected'} : NULL;
			
			if($idGrupoCanal=="1" || $idGrupoCanal=="4" || $idGrupoCanal=="5"){
				if ( !empty($idPlaza) || !empty($dataDistribuidoraSucursal)) {
					//PLAZA
					$filtroWhere.= ( !empty($idPlaza) ? " AND data.idPlaza IN (".$idPlaza.")" : " AND data.idPlaza IS NULL" );
					//DISTRIBUIDORA SUCURSAL
					if (!empty($dataDistribuidoraSucursal)) {
						if ( is_array($dataDistribuidoraSucursal)) {
							$stringDS = implode(",", $dataDistribuidoraSucursal);
							$filtroWhere.= " AND data.idDistribuidoraSucursal IN ('".$stringDS."')";
						} else {
							$filtroWhere.= " AND data.idDistribuidoraSucursal IN ('".$dataDistribuidoraSucursal."')";
						}
					} else {
						$filtroWhere.= " AND data.idSegClienteTradicional IS NULL";
					}
					//
					
					/***VERIFICAMOS EXISTENCIA***/
	
						$rs_segmentacionClienteTradicional = $this->model->obtener_segmentacion_cliente_tradicional_v2($filtroWhere);
						if (!empty($rs_segmentacionClienteTradicional)) {
							//EXISTE DATA
							$idSegClienteTradicional = $rs_segmentacionClienteTradicional[0]['idSegClienteTradicional'];
						} else {
							//NO EXISTE DATA
							$arrayCabecera=array();
							$arrayCabecera['idPlaza']= ( !empty($idPlaza) ? $idPlaza:NULL );
							$arrayCabecera['idDistribuidoraSucursal']=NULL;
		
							//INSERTAMOS LA CABECERA DE LA SEGMENTACION CLIENTE TRADICIONAL
							$insertSegmentacionClienteTradicional = $this->model->insert_segmentacion_cliente_tradicional_v1($arrayCabecera);
							if ( $insertSegmentacionClienteTradicional) {
								$idSegClienteTradicional = $this->db->insert_id();
							} else {
								$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR LA PLAZA.</div>';
							}
		
							//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
							if (!empty($dataDistribuidoraSucursal)) {
								if (is_array($dataDistribuidoraSucursal)) {
									foreach ($dataDistribuidoraSucursal as $kdd => $value) {
										$arrayDetalleDS=array();
										$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
										$arrayDetalleDS['idDistribuidoraSucursal']=$value;
										//
										$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
									}
								} else {
									if($dataDistribuidoraSucursal!="null"){
										$arrayDetalleDS=array();
										$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
										$arrayDetalleDS['idDistribuidoraSucursal']=$dataDistribuidoraSucursal;
										//
										$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
									}
								}
							}				
						} 
					
				}
			}
			
			/***SEGMENTACION CLIENTE MODERNO***/
			$idCadena = ( !empty($data->{'cadena'}) && isset($data->{'cadena'}) ) ? $data->{'cadena'} : NULL;
			$idBanner = ( !empty($data->{'banner'}) && isset($data->{'banner'}) ) ? $data->{'banner'} : NULL;
			if($idGrupoCanal=="2"){
				if ( !empty($idBanner)) {
					$rs_segmentacionClienteModeno = $this->model->obtener_segmentacion_cliente_moderno($idBanner);
					if ( !empty($rs_segmentacionClienteModeno)) {
						$idSegClienteModerno = $rs_segmentacionClienteModeno[0]['idSegClienteModerno'];
					}
				}
			}

			//ACTUALIZAR CLIENTE
			$inputCliente = array();
			$inputCliente['dni'] = ( !empty($data->{'numeroDni'}) ) ? $data->{'numeroDni'} : NULL;
			$inputCliente['ruc'] = ( !empty($data->{'numeroRuc'}) ) ? $data->{'numeroRuc'} : NULL;
			$inputWhereCliente = array();
			$inputWhereCliente['idCliente'] = ( !empty($data->{'cliente'}) && isset($data->{'cliente'}) ) ? $data->{'cliente'} : NULL;

			$arrayUpdateCliente['arrayParams'] = $inputCliente;
			$arrayUpdateCliente['arrayWhere'] = $inputWhereCliente;
			$updateCliente = $this->model->update_cliente($arrayUpdateCliente);

			//ARMAMOS EL ARRAY DEL HISTÓRICO
			$inputHistorico = array();
			$inputHistorico['nombreComercial'] = ( !empty($data->{'nombreComercial'}) && isset($data->{'nombreComercial'}) ) ? $data->{'nombreComercial'} : NULL;
			$inputHistorico['razonSocial'] = ( !empty($data->{'razonSocial'}) && isset($data->{'razonSocial'}) ) ? $data->{'razonSocial'} : NULL;
			
			$inputHistorico['idSegNegocio'] = $idSegNegocio;
			$inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
			$inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
			$inputHistorico['fecIni'] = ( !empty($data->{'fechaInicio'}) && isset($data->{'fechaInicio'}) ) ? $data->{'fechaInicio'} : NULL;
			$inputHistorico['fecFin'] = ( !empty($data->{'fechaFin'}) && isset($data->{'fechaFin'}) ) ? $data->{'fechaFin'} : NULL;
			$inputHistorico['idFrecuencia'] = ( !empty($data->{'frecuencia'}) && isset($data->{'frecuencia'}) ) ? $data->{'frecuencia'} : NULL;
			$inputHistorico['idCuenta'] = ( !empty($data->{'cuenta'}) && isset($data->{'cuenta'}) ) ? $data->{'cuenta'} : NULL;
			$inputHistorico['idProyecto'] = ( !empty($data->{'proyecto'}) && isset($data->{'proyecto'}) ) ? $data->{'proyecto'} : NULL;
			$inputHistorico['idZona'] = ( !empty($data->{'zona'}) && isset($data->{'zona'}) ) ? $data->{'zona'} : NULL;
			$inputHistorico['flagCartera'] = ( !empty($data->{'flagCartera'}) && isset($data->{'flagCartera'}) ) ? $data->{'flagCartera'} : 1;
			$inputHistorico['codCliente'] = ( !empty($data->{'codCliente'}) && isset($data->{'codCliente'}) ) ? $data->{'codCliente'} : NULL;
			$inputHistorico['cod_ubigeo'] = ( !empty($data->{'cod_ubigeo'}) && isset($data->{'cod_ubigeo'}) ) ? $data->{'cod_ubigeo'} : NULL;
			$inputHistorico['direccion'] = ( !empty($data->{'direccion'}) && isset($data->{'direccion'}) ) ? $data->{'direccion'} : NULL;
			$inputHistorico['referencia'] = ( !empty($data->{'referencia'}) && isset($data->{'referencia'}) ) ? $data->{'referencia'} : NULL;
			$inputHistorico['latitud'] = ( !empty($data->{'latitud'}) && isset($data->{'latitud'}) ) ? $data->{'latitud'} : NULL;
			$inputHistorico['longitud'] = ( !empty($data->{'longitud'}) && isset($data->{'longitud'}) ) ? $data->{'longitud'} : NULL;
			$inputHistorico['idZonaPeligrosa'] = ( !empty($data->{'zonaPeligrosa'}) && isset($data->{'zonaPeligrosa'}) ) ? $data->{'zonaPeligrosa'} : NULL;

			switch ($tablaOperacion) {
				case 'basemadre':
					$inputWhere = array();
					$inputWhere['idCliente'] = ( !empty($data->{'cliente'}) && isset($data->{'cliente'}) ) ? $data->{'cliente'} : NULL;
					$inputWhere['idClienteHist'] = ( !empty($data->{'clienteHistorico'}) && isset($data->{'clienteHistorico'}) ) ? $data->{'clienteHistorico'} : NULL;

					$arrayUpdateClienteHistorico['arrayParams'] = $inputHistorico;
					$arrayUpdateClienteHistorico['arrayWhere'] = $inputWhere;
					//
					$updateClienteHistorico = $this->model->update_cliente_historico($arrayUpdateClienteHistorico);
					break;
				case 'pg_v1':
					$inputWhere = array();
					$inputWhere['idClientePg'] = ( !empty($data->{'cliente'}) && isset($data->{'cliente'}) ) ? $data->{'cliente'} : NULL;
					$inputWhere['idClienteHistPg'] = ( !empty($data->{'clienteHistorico'}) && isset($data->{'clienteHistorico'}) ) ? $data->{'clienteHistorico'} : NULL;

					$arrayUpdateClienteHistorico['arrayParams'] = $inputHistorico;
					$arrayUpdateClienteHistorico['arrayWhere'] = $inputWhere;
					//
					$updateClienteHistorico = $this->model->update_cliente_historico_v1($arrayUpdateClienteHistorico);
					break;
				default:
					$updateClienteHistorico = false;
					break;
			}
			

			if ( $updateClienteHistorico) {
				$html .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> SE LOGRO ACTUALIZAR LA INFORMACIÓN CORRECTAMENTE.</div>';
				$result['result'] = 1;
			} else {
				$html .= $this->htmlNoUpdateResultado;
			}

		} else {
			$html = $this->htmlNoUpdateResultado;
		}

		$result['msg']['title'] = 'ACTUALIZAR PUNTO DE VENTA';
		$result['msg']['content'] = $html;
		$result['data']['tabla'] = $tablaOperacion;
		$result['data']['width'] = $htmlWidth;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function seleccionarSegmentacionCliente(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$idUsuario = $this->idUsuario;
		$htmlButtons=1;

		$rs_segmentacion = $this->model->obtener_segmentacion_cliente($idUsuario);

		$array=array();
		if (!empty($rs_segmentacion)) {
			$array['listaSegmentacion']['flagClienteTradicional'] = $rs_segmentacion[0]['flagClienteTradicional'];
			$array['listaSegmentacion']['flagClienteModerno'] = $rs_segmentacion[0]['flagClienteModerno'];

			$htmlButtons=2;
		}
		$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_seleccionarSegmentacionCliente", $array, true);
		
		$result['result'] =1 ;
		$result['msg']['title'] = 'SELECCIONAR SEGMENTACION CLIENTE';
		$result['data']['html'] = $html;
		$result['data']['htmlButtons'] = $htmlButtons;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function nuevoPuntoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$array=array();
		$array['tipoSegmentacion'] = $data->{'tipoSegmentacion'};
		
		/*==NO ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LAS REGIONES DEPARTAMENTOS PROVINCIAS DISTRITOS
		$rs_regiones = $this->model->obtener_listado_regiones();
		$array['listaRegionesNombre'] = array();
		$array['listaProvinciasNombre'] = array();
		$array['listaDistritosNombre'] = array();
		foreach ($rs_regiones as $klr => $row) {
			if ( !in_array($row['departamento'], $array['listaRegionesNombre'])) {
				array_push($array['listaRegionesNombre'],$row['departamento']);
			}
			if ( !in_array($row['provincia'], $array['listaProvinciasNombre'])) {
				array_push($array['listaProvinciasNombre'], $row['provincia']);
			}
			if ( !in_array($row['distrito'], $array['listaDistritosNombre'])) {
				array_push($array['listaDistritosNombre'], $row['distrito']);
			}
		}

		$rs_regiones = $this->model->obtener_listado_regiones_concatenado();
		$array['listaRegionesConcatenado'] = $rs_regiones;

		//LISTADO DE ZONAS PELIGROSAS
		$rs_zonaPeligrosa = $this->model->obtener_zona_peligrosa();
		$array['listaZonaPeligrosaNombre'] = array();
		foreach ($rs_zonaPeligrosa as $klzp => $row) {
			if ( !in_array($row['descripcion'], $array['listaZonaPeligrosaNombre'])) {
				array_push($array['listaZonaPeligrosaNombre'], $row['descripcion']);
			}
		}

		//LISTADO DE FRECUENCIAS
		$array['listaFrecuenciaNombre'] = array();
		$rs_frecuencia = $this->model->obtener_frecuencia();
		foreach ($rs_frecuencia as $klf => $row) {
			if ( !in_array($row['frecuencia'], $array['listaFrecuenciaNombre'])) {
				array_push($array['listaFrecuenciaNombre'], $row['frecuencia']);
			}
		}

		/*==ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LA CUENTA-PROYECTO
		$array['listaCuentaNombre'] = array();
		$array['listaProyectoNombre'] = array();
		$rs_cuentaProyecto = $this->model->obtener_cuenta_proyecto($input);
		foreach ($rs_cuentaProyecto as $klcp => $row) {
			if ( !in_array($row['cuenta'], $array['listaCuentaNombre'])) {
				array_push($array['listaCuentaNombre'], $row['cuenta']);
			}
			if ( !in_array($row['proyecto'], $array['listaProyectoNombre'])) {
				array_push($array['listaProyectoNombre'], $row['proyecto']);
			}
		}
		
		//LISTADO DE CUENTA-PROYECTO-ZONA
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE ZONAS
		$array['listaZonaNombre'] = array();
		if ( !empty($this->permisos['zona'])) { $rs_zona = $this->model->obtener_zonas_usuarioHistZona($input); }
		else { $rs_zona = $this->model->obtener_zonas($input); }
		//
		foreach ($rs_zona as $klz => $row) {
			if ( !in_array($row['zona'], $array['listaZonaNombre'])) {
				array_push($array['listaZonaNombre'], $row['zona']);
			}
		}

		//LISTADO DE CUENTA - GRUPO CANAL - CANAL
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CANAL
		$array['listaGrupoCanalNombre'] = array();
		$array['listaCanalNombre'] = array();
		$array['listaClienteTipoNombre'] = array();
		if (!empty($this->permisos['canal'])) { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal_usuarioHistCanal($input); } 
		else { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal($input); }
		//
		foreach ($rs_grupoCanalCanal as $kgc => $row) {
			if ( !in_array($row['grupoCanal'], $array['listaGrupoCanalNombre'])) {
				array_push($array['listaGrupoCanalNombre'], $row['grupoCanal']);
			}
			if ( !in_array($row['canal'], $array['listaCanalNombre'])) {
				array_push($array['listaCanalNombre'], $row['canal']);
			}
			if ( !in_array($row['clienteTipo'], $array['listaClienteTipoNombre'])) {
				array_push($array['listaClienteTipoNombre'], $row['clienteTipo']);
			}
		}

		//LISTADO DE CADENA - BANNER
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CADENA-BANNER
		$array['listaCadenaNombre'] = array();
		$array['listaBannerNombre'] = array();
		if ( !empty($this->permisos['banner']) ) { $rs_cadenaBanner = $this->model->obtener_cadena_banner_usuarioHistBanner(); }
		else { $rs_cadenaBanner = $this->model->obtener_cadena_banner(); }
		//
		foreach ($rs_cadenaBanner as $klcb => $row) {
			if ( !in_array($row['cadena'], $array['listaCadenaNombre'])) {
				array_push($array['listaCadenaNombre'], $row['cadena']);
			}
			if ( !in_array($row['banner'], $array['listaBannerNombre'])) {
				array_push($array['listaBannerNombre'], $row['banner']);
			}
		}

		//LISTADO DE LAS PLAZAS
		//VERIFICAMOS QUE EXISTA PERMISOS DE PLAZAS
		$array['listaPlazaNombre'] = array();
		if ( !empty($this->permisos['plaza'])) { $rs_plaza = $this->model->obtener_plazas_todos_usuarioHistPlaza($input); }
		else { $rs_plaza = $this->model->obtener_plazas_todos(); }
		
		//
		foreach ($rs_plaza as $klp => $row) {
			if ( !in_array($row['plaza'], $array['listaPlazaNombre'])) {
				array_push($array['listaPlazaNombre'], $row['plaza']);
			}
		}
		$rs_plaza = $this->model->obtener_plazas_mayoristas();
		foreach ($rs_plaza as $klp => $row) {
			if ( !in_array($row['plaza'], $array['listaPlazaNombre'])) {
				array_push($array['listaPlazaNombre'], $row['plaza']);
			}
		}
		

		//LISTADO DE DISTRIBUDIORA SUCURSAL
		//VERIFICAMOS SI ES QUE EXISTEN PERMISOS DE DISTRIBUDIORA SUCURSAL
		$array['listaDistribuidoraSucursalNombre'] = array();
		if (!empty($this->permisos['distribuidoraSucursal'])) {	$rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal_usuarioHistDS($input); } 
		else { $rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal($input); }
		//
		foreach ($rs_distribuidoraSucursal as $klds => $row) {
			if ( !in_array($row['distribuidoraSucursal'], $array['listaDistribuidoraSucursalNombre'])) {
				array_push($array['listaDistribuidoraSucursalNombre'], $row['distribuidoraSucursal']);
			}
		}

		$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_nuevoPuntoMasivo", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVO PUNTO MASIVO';
		$result['data']['html'] = $html;	

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoPuntoMasivo(){
		set_time_limit(0);
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$idUsuario = $this->idUsuario;
		$tipoSegmentacion = $data->{'tipoSegmentacion'};
		$dataArray = $data->{'dataArray'};

		$html=''; $htmlDuplicados='';
		$rowInsertedCliente=0; $rowInsertedClienteHistorico=0;

		$idCuenta = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$idProyecto = !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";



		if ( !empty($dataArray)) {
			$contDuplicados=0;
			//VERIFICAMOS DUPLICIDAD DE TODOS
			foreach ($dataArray as $kld => $row) {
				$nombreComercial = (isset($row[0]) && !empty($row[0])) ? trim($row[0]) : NULL;
				$razonSocial = (isset($row[1]) && !empty($row[1])) ? trim($row[1]) : NULL;


				$ruc = (isset($row[2]) && !empty($row[2])) ? trim($row[2]) : NULL;


				$dni = (isset($row[3]) && !empty($row[3])) ? trim($row[3]) : NULL;
		

				// $proyecto = (isset($row[18]) && !empty($row[18])) ? $row[18] : NULL;
				// 	$idProyecto = $this->model->obtener_id_proyecto($proyecto, $idCuenta);
				// 	$idProyecto = ( !empty($idProyecto) ? $idProyecto[0]['idProyecto'] : NULL );
				$direccion = (isset($cliente[7]) && !empty($cliente[7])) ? trim($cliente[7]) : NULL;
				$grupoCanal = (isset($row[18]) && !empty($row[18])) ? trim($row[18]) : NULL;
				$canal = (isset($row[19]) && !empty($row[19])) ? trim($row[19]) : NULL;
				$clienteTipo = (isset($row[20]) && !empty($row[20])) ? trim($row[20]) : NULL;

				//VERIFICAMOS LA SEGMETACIÓN DEL CLIENTE
				$plaza=NULL; $dataDistribuidoraSucursal=NULL; 
				$cadena=NULL; $banner=NULL;

				if ( $tipoSegmentacion==1 ) {
					//SEGMENTACIÓN CLIENTE TRADICIONAL
					$plaza = (isset($row[21]) && !empty($row[21])) ? trim($row[21]) : NULL;
					if ( count($row) > 23 ) {
						$dataDistribuidoraSucursal = array();
						for ($i=22; $i < count($row); $i++) { 
							if ( $row[$i] !== null ) array_push($dataDistribuidoraSucursal, trim($row[$i]));
						}
					} else {
						$dataDistribuidoraSucursal = (isset($row[22]) && !empty($row[22])) ? trim($row[22]) : NULL;
					}
				} elseif( $tipoSegmentacion==2){
					//SEGMENTACIÓN CLIENTE MODERNO
					$cadena = (isset($row[21]) && !empty($row[21])) ? trim($row[21]) : NULL;
					$banner = (isset($row[22]) && !empty($row[22])) ? trim($row[22]) : NULL;
				}

				/****************SEGMENTACIONES*******************/
				$idSegNegocio = NULL; $idSegClienteTradicional = NULL; $idSegClienteModerno = NULL;
				
				/************SEGMETACIÓN NEGOCIO*********************/
				if ( !empty($canal) ) {
					$rs_idCanal = $this->model->obtener_id_canal($canal);
					//$rs_idSubCanal = $this->model->obtener_id_subCanal($subCanal);
					$rs_idClienteTipo = $this->model->obtener_id_clienteTipo($clienteTipo);

					$arraySegNegocio=array();
					$arraySegNegocio['idCanal'] = (!empty($rs_idCanal) ? $rs_idCanal[0]['idCanal']:NULL);
					$arraySegNegocio['idClienteTipo']= (!empty($rs_idClienteTipo) ? $rs_idClienteTipo[0]['idClienteTipo']:NULL);

					//$rs_segmentacionNegocio = $this->model->obtener_id_segmentacion_negocio($canal);
					$rs_segmentacionNegocio = $this->model->obtener_segmentacion_negocio($arraySegNegocio);
					if ( !empty($rs_segmentacionNegocio)) {
						$idSegNegocio = $rs_segmentacionNegocio[0]['idSegNegocio'];
					} else {
						$insertarSegNegocio = $this->model->insertar_segmentacion_negocio($arraySegNegocio);
						if ($insertarSegNegocio) {
							$idSegNegocio = $this->db->insert_id();
						}
					}
				}
				/***********SEGMENTACION CLIENTE MODERNO**************/
				if ( !empty($banner)) {
					$rs_segmentacionClienteModeno = $this->model->obtener_id_segmentacion_cliente_moderno($banner);
					if ( !empty($rs_segmentacionClienteModeno)) {
						$idSegClienteModerno = $rs_segmentacionClienteModeno[0]['idSegClienteModerno'];
					}
				}
				/**********SEGMENTACION CLIENTE TRADICIONAL*********/
				$filtroWhere='';
				if ( !empty($plaza) || !empty($dataDistribuidoraSucursal)) {
					//PLAZA
					$filtroWhere.= ( !empty($plaza) ? " AND data3.plaza LIKE '".$plaza."'" : " AND data3.plaza IS NULL" );
					//DISTRIBUIDORA SUCURSAL
					if (!empty($dataDistribuidoraSucursal)) {
						if ( is_array($dataDistribuidoraSucursal)) {
							$stringDS = implode(",", $dataDistribuidoraSucursal);
							$filtroWhere.= " AND data3.distribuidoraSucursal LIKE'".$stringDS."'";
						} else {
							$filtroWhere.= " AND data3.distribuidoraSucursal LIKE '".$dataDistribuidoraSucursal."'";
						}
					} else {
						$filtroWhere.= " AND data3.distribuidoraSucursal IS NULL";
					}
					//

					//BUSCAMOS EL VALOR DEL ID SEGMENTACION CLIENTE TRADICIONAL
					$rs_segmentacionClienteTradicional = $this->model->obtener_id_segmentacion_cliente_tradicional($filtroWhere);
					
					/***VERIFICAMOS EXISTENCIA***/
					if (!empty($rs_segmentacionClienteTradicional)) {
						//EXISTE DATA
						$idSegClienteTradicional = $rs_segmentacionClienteTradicional[0]['idSegClienteTradicional'];
					} else {
						//NO EXISTE DATA
						$idPlaza=NULL;
						if (!empty($plaza)) {
							$rs_idPlaza = ( in_array($grupoCanal, ['HFS']) ? $this->model->obtener_id_plaza_todo($plaza) : $this->model->obtener_id_plaza_mayorista($plaza) );
							$idPlaza = ( !empty($rs_idPlaza) ) ? $rs_idPlaza[0]['idPlaza'] : NULL;
						}
						//
						$arrayCabecera=array();
						$arrayCabecera['idPlaza']= $idPlaza;
						$arrayCabecera['idDistribuidoraSucursal']=NULL;

						//INSERTAMOS LA CABECERA DE LA SEGMENTACION CLIENTE TRADICIONAL
						$insertSegmentacionClienteTradicional = $this->model->insert_segmentacion_cliente_tradicional_v1($arrayCabecera);
						if ( $insertSegmentacionClienteTradicional) {
							$idSegClienteTradicional = $this->db->insert_id();
						} else {
							$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR LA PLAZA.</div>';
						}

						//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
						if (!empty($dataDistribuidoraSucursal)) {
							if (is_array($dataDistribuidoraSucursal)) {
								foreach ($dataDistribuidoraSucursal as $kdd => $value) {
									$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($value);
									$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
									//INSERTAMOS EL DETALLE
									$arrayDetalleDS=array();
									$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
									$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
									//
									$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
								}
							} else {
								$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($dataDistribuidoraSucursal);
								if($rs_idDistribuidoraSucursal!=null){
									$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
									//INSERTAMOS EL DETALLE
									$arrayDetalleDS=array();
									$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
									$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
									//
									$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	

								}
								
							}
						}				
					}
				}

				/******VERIFICACIÓN DE LA EXISTENCIA DE LOS NUEVOS PUNTOS A CREAR*****/
				//VERIFICACIÓN DE LA EXISTENCIA DE CLIENTE
				$inputBusqueda=array();
				//$inputBusqueda['nombreComercial'] = $nombreComercial;
				$inputBusqueda['razonSocial'] = $razonSocial;
				//$inputBusqueda['ruc'] = $ruc;
				//$inputBusqueda['dni'] = $dni;
				$inputBusqueda['direccion'] = $direccion;

				$rs_verificarExistencia = $this->model->obtener_verificacion_existente_pg_v1($inputBusqueda);
				
				// //VERIFICACIÓN DE LA EXISTENCIA DE CLIENTE HISTÓRICO
				// $arrayDataHistorico=array();
				// $arrayDataHistorico['nombreComercial'] = $nombreComercial;
				// $arrayDataHistorico['razonSocial'] = $razonSocial;
				// //$arrayDataHistorico['ruc'] = $ruc;
				// //$arrayDataHistorico['dni'] = $dni;
				// $arrayDataHistorico['idCuenta'] = $idCuenta;
				// $arrayDataHistorico['idProyecto'] = $idProyecto;
				// $arrayDataHistorico['idSegNegocio'] = $idSegNegocio;
				// $arrayDataHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
				// $arrayDataHistorico['idSegClienteModerno'] = $idSegClienteModerno;

				// $rs_verificarExistenciaHistorico = $this->model->obtener_verificacion_existente_historico_pg_v1($arrayDataHistorico);

				//VERIFICAMOS SI ES QUE EXISTE EL DUPLICADO DEL PDV Y SU HISTÓRICO CON EL CUAL SE VA A GUARDAR
				if (!empty($rs_verificarExistencia) ) {
					//$contDuplicados++;
					$htmlDuplicados .= '<div class="alert alert-warning fade show" role="alert"> <i class="fas fa-exclamation-triangle"></i> EL CLIENTE INGRESADO, <strong>'.$inputBusqueda['razonSocial'].' - '.$inputBusqueda['direccion'].'</strong>; YA SE ENCUENTRA REGISTRADO .</div>';
				}
			}

			if ( $contDuplicados>0) {
				$html .= '<h5><i class="fas fa-check-circle"></i> Verificar la información:</h5>';
				$html .= $htmlDuplicados;
			} else {
				foreach ($dataArray as $kd => $cliente) {


					$nombreComercial = (isset($cliente[0]) && !empty($cliente[0])) ? trim($cliente[0]) : NULL;
					$razonSocial = (isset($cliente[1]) && !empty($cliente[1])) ? ($cliente[1]) : NULL;
					$ruc = (isset($cliente[2]) && !empty($cliente[2])) ? trim($cliente[2]) : NULL;
					$dni = (isset($cliente[3]) && !empty($cliente[3])) ? trim($cliente[3]) : NULL;

					$codigoUbigeo =  NULL;

					$departamento = (isset($row[4]) && !empty($row[4])) ? trim($row[4]) : NULL;
					$provincia = (isset($row[5]) && !empty($row[5])) ? trim($row[5]) : NULL;
					$distrito = (isset($row[6]) && !empty($row[6])) ? trim($row[6]) : NULL;
					if($departamento!=null && $provincia!=null && $distrito!=null){
						$params=array();
						$params['departamento']=$departamento;
						$params['provincia']=$provincia;
						$params['distrito']=$distrito;
						
						$rs_ubigeo=$this->model->obtener_ubigeo($params);
						if ( !empty($rs_ubigeo)) {
							$codigoUbigeo=$rs_ubigeo[0]['cod_ubigeo'];
						}
					}	
					
					$direccion = (isset($cliente[7]) && !empty($cliente[7])) ? trim($cliente[7]) : NULL;
					$referencia = (isset($cliente[8]) && !empty($cliente[8])) ? trim($cliente[8]) : NULL;
					$latitud = (isset($cliente[9]) && !empty($cliente[9])) ? $cliente[9] : NULL;
					$longitud = (isset($cliente[10]) && !empty($cliente[10])) ? $cliente[10] : NULL;
					$zonaPeligrosa = (isset($cliente[11]) && !empty($cliente[11])) ? $cliente[11] : NULL;
						$idZonaPeligrosa = $this->model->obtener_id_zona_peligrosa($zonaPeligrosa);
						$idZonaPeligrosa = ( !empty($idZonaPeligrosa) ? $idZonaPeligrosa[0]['idZonaPeligrosa'] : NULL );

					$codigoCliente = (isset($cliente[12]) && !empty($cliente[12])) ? $cliente[12] : NULL;
					$flagCartera = (isset($cliente[13]) && !empty($cliente[13])) ? ($cliente[13]=='SI' ? 1 : 0) : 1;

					$fechaInicio = (isset($cliente[14]) && !empty($cliente[14])) ? $cliente[14] : date('Y-m-d');
					$fechaFin = (isset($cliente[15]) && !empty($cliente[15])) ? $cliente[15] : NULL;

					// $cuenta = (isset($cliente[17]) && !empty($cliente[17])) ? $cliente[17] : NULL;
					// 	$idCuenta = $this->model->obtener_id_cuenta($cuenta);
					// 	$idCuenta = ( !empty($idCuenta) ? $idCuenta[0]['idCuenta'] : NULL );

					// $proyecto = (isset($cliente[18]) && !empty($cliente[18])) ? $cliente[18] : NULL;
					// 	$idProyecto = $this->model->obtener_id_proyecto( $proyecto, $idCuenta );
					// 	$idProyecto = ( !empty($idProyecto) ? $idProyecto[0]['idProyecto'] : NULL );

					$frecuencia = (isset($cliente[16]) && !empty($cliente[16])) ? $cliente[16] : NULL;
						$idFrecuencia = $this->model->obtener_id_frecuencia($frecuencia);
						$idFrecuencia = ( !empty($idFrecuencia) ? $idFrecuencia[0]['idFrecuencia'] : NULL );

					$zona = (isset($cliente[17]) && !empty($cliente[17])) ? trim($cliente[17]) : NULL;
						$idZona = $this->model->obtener_id_zona($zona);
						$idZona = ( !empty($idZona) ? $idZona[0]['idZona'] : NULL ) ;

					$grupoCanal = (isset($cliente[18]) && !empty($cliente[18])) ? $cliente[18] : NULL;
					$canal = (isset($cliente[19]) && !empty($cliente[19])) ? $cliente[19] : NULL;
					$clienteTipo = (isset($cliente[20]) && !empty($cliente[20])) ? $cliente[20] : NULL;

					//VERIFICAMOS LA SEGMETACIÓN DEL CLIENTE
					$plaza=NULL; $dataDistribuidoraSucursal=NULL; 
					$cadena=NULL; $banner=NULL;

					if ( $tipoSegmentacion==1 ) {
						//SEGMENTACIÓN CLIENTE TRADICIONAL
						$plaza = (isset($cliente[21]) && !empty($cliente[21])) ? trim($cliente[21]) : NULL;
						if ( count($cliente) > 23 ) {
							$dataDistribuidoraSucursal = array();
							for ($i=22; $i < count($cliente); $i++) { 
								if ( $cliente[$i] !== null ) array_push($dataDistribuidoraSucursal, $cliente[$i]);
							}
						} else {
							$dataDistribuidoraSucursal = (isset($cliente[22]) && !empty($cliente[22])) ? trim($cliente[22]) : NULL;
						}
					} elseif( $tipoSegmentacion==2){
						//SEGMENTACIÓN CLIENTE MODERNO
						$cadena = (isset($cliente[21]) && !empty($cliente[21])) ? trim($cliente[21]) : NULL;
						$banner = (isset($cliente[22]) && !empty($cliente[22])) ? ($cliente[22]) : NULL;
					}

					/****************SEGMENTACIONES*******************/
					$idSegNegocio = NULL; $idSegClienteTradicional = NULL; $idSegClienteModerno = NULL;

					/************SEGMETACIÓN NEGOCIO*********************/
					if ( !empty($canal) ) {
						$rs_idCanal = $this->model->obtener_id_canal($canal);
						//$rs_idSubCanal = $this->model->obtener_id_subCanal($subCanal);
						$rs_idClienteTipo = $this->model->obtener_id_clienteTipo($clienteTipo);

						$arraySegNegocio=array();
						$arraySegNegocio['idCanal'] = (!empty($rs_idCanal) ? $rs_idCanal[0]['idCanal']:NULL);
						$arraySegNegocio['idClienteTipo']= (!empty($rs_idClienteTipo) ? $rs_idClienteTipo[0]['idClienteTipo']:NULL);

						//$rs_segmentacionNegocio = $this->model->obtener_id_segmentacion_negocio($canal);
						$rs_segmentacionNegocio = $this->model->obtener_segmentacion_negocio($arraySegNegocio);
						if ( !empty($rs_segmentacionNegocio)) {
							$idSegNegocio = $rs_segmentacionNegocio[0]['idSegNegocio'];
						} else {
							$insertarSegNegocio = $this->model->insertar_segmentacion_negocio($arraySegNegocio);
							if ($insertarSegNegocio) {
								$idSegNegocio = $this->db->insert_id();
							}
						}
					}
					/***********SEGMENTACION CLIENTE MODERNO**************/
					if ( !empty($banner)) {
						$rs_segmentacionClienteModeno = $this->model->obtener_id_segmentacion_cliente_moderno($banner);
						if ( !empty($rs_segmentacionClienteModeno)) {
							$idSegClienteModerno = $rs_segmentacionClienteModeno[0]['idSegClienteModerno'];
						}
					}
					/**********SEGMENTACION CLIENTE TRADICIONAL*********/
					$filtroWhere='';
						if ( !empty($plaza) || !empty($dataDistribuidoraSucursal)) {
						//PLAZA
						$filtroWhere.= ( !empty($plaza) ? " AND data3.plaza LIKE '".$plaza."'" : " AND data3.plaza IS NULL" );
						//DISTRIBUIDORA SUCURSAL
						if (!empty($dataDistribuidoraSucursal)) {
							if ( is_array($dataDistribuidoraSucursal)) {
								$stringDS = implode(",", $dataDistribuidoraSucursal);
								$filtroWhere.= " AND data3.distribuidoraSucursal LIKE'".$stringDS."'";
							} else {
								$filtroWhere.= " AND data3.distribuidoraSucursal LIKE '".$dataDistribuidoraSucursal."'";
							}
						} else {
							$filtroWhere.= " AND data3.distribuidoraSucursal IS NULL";
						}

						//

						//BUSCAMOS EL VALOR DEL ID SEGMENTACION CLIENTE TRADICIONAL
						$rs_segmentacionClienteTradicional = $this->model->obtener_id_segmentacion_cliente_tradicional($filtroWhere);
						
						/***VERIFICAMOS EXISTENCIA***/
						if (!empty($rs_segmentacionClienteTradicional)) {
							//EXISTE DATA
							$idSegClienteTradicional = $rs_segmentacionClienteTradicional[0]['idSegClienteTradicional'];
						} else {
							//NO EXISTE DATA
							$idPlaza=NULL;
							if (!empty($plaza)) {
								$rs_idPlaza = ( in_array($grupoCanal, ['HFS']) ? $this->model->obtener_id_plaza_todo($plaza) : $this->model->obtener_id_plaza_mayorista($plaza) );
								$idPlaza = ( !empty($rs_idPlaza) ) ? $rs_idPlaza[0]['idPlaza'] : NULL;
							}
							//
							$arrayCabecera=array();
							$arrayCabecera['idPlaza']= $idPlaza;
							$arrayCabecera['idDistribuidoraSucursal']=NULL;

							//INSERTAMOS LA CABECERA DE LA SEGMENTACION CLIENTE TRADICIONAL
							$insertSegmentacionClienteTradicional = $this->model->insert_segmentacion_cliente_tradicional_v1($arrayCabecera);
							if ( $insertSegmentacionClienteTradicional) {
								$idSegClienteTradicional = $this->db->insert_id();
							} else {
								$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR LA PLAZA.</div>';
							}

							//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
							
							if (!empty($dataDistribuidoraSucursal)) {
								if (is_array($dataDistribuidoraSucursal)) {
									foreach ($dataDistribuidoraSucursal as $kdd => $value) {
										$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($value);
										$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
										//INSERTAMOS EL DETALLE
										$arrayDetalleDS=array();
										$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
										$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
										//
										$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
									}
								} else {
									$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($dataDistribuidoraSucursal);
									if($rs_idDistribuidoraSucursal!=null){
										$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
										//INSERTAMOS EL DETALLE
										$arrayDetalleDS=array();
										$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
										$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
										//
										$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
									}
									
								}
							}				
						}
					}

					/******VERIFICACIÓN DE LA EXISTENCIA DE LOS NUEVOS PUNTOS A CREAR*****/
					//VERIFICACIÓN DE LA EXISTENCIA DE CLIENTE
					$inputBusqueda=array();
					//$inputBusqueda['nombreComercial'] = $nombreComercial;
					$inputBusqueda['razonSocial'] = $razonSocial;
					//$inputBusqueda['ruc'] = $ruc;
					//$inputBusqueda['dni'] = $dni;
					$inputBusqueda['direccion'] = $direccion;

					$rs_verificarExistencia = $this->model->obtener_verificacion_existente_pg_v1($inputBusqueda);

					if ( empty($rs_verificarExistencia) ) {
						//NO EXISTE UN REGISTRO DEL CLIENTE					
						//CABECERA
						$input=array();
						$input['nombreComercial'] = $nombreComercial;
						$input['razonSocial'] = $razonSocial;
						$input['ruc'] = $ruc;
						$input['dni'] = $dni;
						$input['direccion'] = $direccion;
						//$input['cod_ubigeo'] = $codigoUbigeo;
						//$input['direccion'] = $direccion;
						//$input['idZonaPeligrosa'] = $idZonaPeligrosa;
						//$input['latitud'] = $latitud;
						//$input['longitud'] = $longitud;

						$insertCliente = $this->model->insertar_cliente_pg_v1($input);
						if ( $insertCliente ) {
							$insertIdCliente = $this->db->insert_id();
							$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR AL NUEVO CLIENTE <strong>'.$input['razonSocial'].' - '.$input['direccion'].'</strong> CORRECTAMENTE.</div>';
							$rowInsertedCliente++;

							$inputHistorico = array();
							$inputHistorico['idClientePg'] = $insertIdCliente;
							$inputHistorico['nombreComercial'] = $nombreComercial;
							$inputHistorico['razonSocial'] = $razonSocial;
							$inputHistorico['idSegNegocio'] = $idSegNegocio;
							$inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
							$inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
							$inputHistorico['fecIni'] = $fechaInicio;
							$inputHistorico['fecFin'] = $fechaFin;
							$inputHistorico['idCuenta'] = $idCuenta;
							$inputHistorico['idProyecto'] = $idProyecto;
							$inputHistorico['idFrecuencia'] = $idFrecuencia;
							$inputHistorico['idZona'] = $idZona;
							$inputHistorico['idZonaPeligrosa'] = $idZonaPeligrosa;
							$inputHistorico['flagCartera'] = $flagCartera;
							$inputHistorico['codCliente'] = $codigoCliente;
							$inputHistorico['cod_ubigeo'] = $codigoUbigeo;
							$inputHistorico['direccion'] = $direccion;
							$inputHistorico['referencia'] = $referencia;
							$inputHistorico['latitud'] = $latitud;
							$inputHistorico['longitud'] = $longitud;
							$inputHistorico['idUsuarioSolicitud'] = $idUsuario;

							$insertClienteHistorico = $this->model->insertar_cliente_historico_v1($inputHistorico);
							//VERIFICAMOS EL CORRECTO ALMACENAMIENTO DEL HISTÓRICO
							if ($insertClienteHistorico) {
								$rowInsertedClienteHistorico++;
								//$html .= '<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR EL CLIENTE HISTÓRICO DE <strong>'.$nombreComercial.'</strong> CORRECTAMENTE.</div>';
							} else {
								//$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE LOGRÓ REGISTRAR EL CLIENTE HISTÓRICO DE <strong>'.$nombreComercial.'</strong> CORRECTAMENTE.</div>';
							}
						} else {
							$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i>NO SE LOGRÓ REGISTRAR EL CLIENTE <strong>'.$razonSocial.' - '.$direccion.'</strong> CORRECTAMENTE.</div>';
						}

					} else {
						//YA EXISTE EL CLIENTE
						//INSERTAMOS EL CLIENTE HISTORICO
						// $idClienteVerificado = $rs_verificarExistencia[0]['idClientePg'];
						// $html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-check-circle"></i> EL CLIENTE <strong>'.$nombreComercial.'</strong> YA SE ENCUENTRA REGISTRADO.</div>';

						// $inputHistorico = array();
						// $inputHistorico['idClientePg'] = $idClienteVerificado;
						// $inputHistorico['nombreComercial'] = $nombreComercial;
						// $inputHistorico['razonSocial'] = $razonSocial;
						// //$inputHistorico['dni'] = $dni;
						// //$inputHistorico['ruc'] = $ruc;
						// $inputHistorico['idSegNegocio'] = $idSegNegocio;
						// $inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
						// $inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
						// $inputHistorico['fecIni'] = $fechaInicio;
						// $inputHistorico['fecFin'] = $fechaFin;
						// $inputHistorico['idCuenta'] = $idCuenta;
						// $inputHistorico['idProyecto'] = $idProyecto;
						// $inputHistorico['idFrecuencia'] = $idFrecuencia;
						// $inputHistorico['idZona'] = $idZona;
						// $inputHistorico['idZonaPeligrosa'] = $idZonaPeligrosa;
						// $inputHistorico['flagCartera'] = $flagCartera;
						// $inputHistorico['codCliente'] = $codigoCliente;
						// $inputHistorico['cod_ubigeo'] = $codigoUbigeo;
						// $inputHistorico['direccion'] = $direccion;
						// $inputHistorico['referencia'] = $referencia;
						// $inputHistorico['latitud'] = $latitud;
						// $inputHistorico['longitud'] = $longitud;
						// $inputHistorico['idUsuarioSolicitud'] = $idUsuario;

						// $insertClienteHistorico = $this->model->insertar_cliente_historico_v1($inputHistorico);
						// if ($insertClienteHistorico) {
						// 	$rowInsertedClienteHistorico++;
						// 	$html .= '<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR EL CLIENTE HISTÓRICO DE <strong>'.$nombreComercial.'</strong> CORRECTAMENTE.</div>';
						// } else {
						// 	$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE LOGRÓ REGISTRAR EL CLIENTE HISTÓRICO DE <strong>'.$nombreComercial.'</strong> CORRECTAMENTE.</div>';
						// }

						
						$html .= '<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO EL CLIENTE EXISTENTE <strong>'.$razonSocial.' - '.$direccion.'</strong> , NO SE REALIZO CAMBIOS.</div>';
					}
				}
			}
		} else {
			$html .= $this->htmlNoUpdateResultado;
		}

		if ($rowInsertedCliente>0 || $rowInsertedClienteHistorico>0) {
			$result['result']=1;
			$this->enviarNotificacionNuevoRegistro($rowInsertedClienteHistorico);

			$mensaje='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR <strong>'.$rowInsertedClienteHistorico.' CLIENTES</strong> CORRECTAMENTE.</div>';
			$mensaje.=$html;
			$html=$mensaje;
		}

		$result['msg']['title'] = 'REGISTRAR PUNTO DE VENTA MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function darBajaMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$htmlWidth='60%';
		
		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$array=array();

		$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_bajaPuntoMasivo", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'BAJA MASIVA DE CLIENTES';
		$result['data']['htmlWidth'] = $htmlWidth;
		$result['data']['html'] = $html;	

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function bajaMasivoFechas(){
		set_time_limit(0);
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$idUsuario = $this->idUsuario;
		$dataArray = $data->{'dataArray'};

		$html=''; $htmlDuplicados='';
		$rowUpdatedClienteHistorico=0;

		$idCuenta = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$idProyecto = !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$inputProyectos=array();
		$aProyectos =array();
		
		$aProyectos = $this->model->lista_proyectosAuditoria([ 'idProyecto' => $idProyecto ]);
		foreach($aProyectos as $rowProyectos){
			$inputProyectos[$rowProyectos['idProyecto']]=$rowProyectos['idProyecto'];
		}
		$inputProyectos[$idProyecto]=$idProyecto;


		$actualizar=true;
		if ( !empty($dataArray)) {
			foreach ($dataArray as $kd => $cliente) {

				$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
				$fechaFin = (isset($cliente[1]) && !empty($cliente[1])) ? $cliente[1] : NULL;

				if( !empty($idCliente) && !empty($fechaFin ) ){
					$inputBusquedaHistorico=array();
					$inputBusquedaHistorico['idCliente'] = $idCliente;
					$inputBusquedaHistorico['fechaFin'] = $fechaFin;
					$rs_verificarCambioValidoHistorico = $this->model->validar_cliente_historico_fechaFin($inputBusquedaHistorico,$inputProyectos);
					
					if($rs_verificarCambioValidoHistorico!=null && count($rs_verificarCambioValidoHistorico)>0){
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> EL CLIENTE <strong>'.$idCliente.'</strong> LA FECHA FIN NO PUEDE SER MENOR A LA FECHA INICIO.</div>';
						$actualizar=false;
					}

				}
			}
		}

		
		if ( !empty($dataArray) && $actualizar==true ) {
			foreach ($dataArray as $kd => $cliente) {

				$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
				$fechaFin = (isset($cliente[1]) && !empty($cliente[1])) ? $cliente[1] : NULL;
				if( !empty($idCliente) && !empty($fechaFin ) ){

					$inputBusqueda=array();
					$inputBusqueda['idCliente'] = $idCliente;

					$rs_verificarExistenciaCliente=null;
					$rs_verificarExistenciaCliente = $this->model->obtener_verificacion_existente($inputBusqueda);

					if( !empty($rs_verificarExistenciaCliente) ){

						$inputBusquedaHistorico=array();
						$inputBusquedaHistorico['idCliente'] = $idCliente;
						$inputBusquedaHistorico['idCuenta'] = $idCuenta;
						$rs_verificarExistenciaClienteHistorico = $this->model->obtener_cliente_historico_vigente($inputBusquedaHistorico,$inputProyectos);
					
						$inputIdClienteHist=array();
						if( !empty($rs_verificarExistenciaClienteHistorico) ){
							if( count($rs_verificarExistenciaClienteHistorico)>0){
								foreach($rs_verificarExistenciaClienteHistorico as $clienteHist){
									$inputIdClienteHist[$clienteHist['idClienteHist']]=$clienteHist['idClienteHist'];
								}
							}
						}
						
						
						
						if( !empty($inputIdClienteHist) ){
							if( count($inputIdClienteHist)>0){
								//actualizar historico
								$inputHistorico = array();
								$inputHistorico['idCliente'] = $idCliente;
								$inputHistorico['fecFin'] = $fechaFin;

								$arrayUpdateClienteHistorico['arrayParams'] = $inputHistorico;
								$arrayUpdateClienteHistorico['idClienteHist'] = $inputIdClienteHist;
								//
								$updateClienteHistorico = $this->model->update_cliente_historico_proyectos($arrayUpdateClienteHistorico);
								
								if ($updateClienteHistorico) {
									$rowUpdatedClienteHistorico++;
								} else {
									$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE LOGRÓ ACTUALIZAR EL CLIENTE HISTÓRICO DE <strong>'.$razonSocial.' - '.$direccion.'</strong> CORRECTAMENTE.</div>';
								}
							}
						} 
					}else{
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE LOGRÓ REGISTRAR EL CLIENTE HISTÓRICO DE <strong>'.$razonSocial.' - '.$direccion.'</strong> CORRECTAMENTE.</div>';
					}

				}
			}
		}

		if ($rowUpdatedClienteHistorico>0) {
			$result['result']=1;
			$this->enviarNotificacionNuevoRegistro($rowUpdatedClienteHistorico);
			$mensaje=$html;
			$html.='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ ACTUALIZAR <strong>'.$rowUpdatedClienteHistorico.' CLIENTE HISTORICO(S) </strong> CORRECTAMENTE.</div>';
			$html.=$mensaje;
		}

		$result['msg']['title'] = 'BAJA MASIVA DE CLIENTES';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}




	public function nuevoHistoricoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$input=array();
		$input['idUsuario'] = $this->idUsuario;
		$input['listaCuentas']=implode(',', $this->permisos['cuenta']);
		$input['listaProyectos']=implode(',', $this->permisos['proyecto']);

		$array=array();
		$array['tipoSegmentacion'] = $data->{'tipoSegmentacion'};
		
		/*==NO ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LAS REGIONES DEPARTAMENTOS PROVINCIAS DISTRITOS
		$rs_regiones = $this->model->obtener_listado_regiones();
		$array['listaRegionesNombre'] = array();
		$array['listaProvinciasNombre'] = array();
		$array['listaDistritosNombre'] = array();
		foreach ($rs_regiones as $klr => $row) {
			if ( !in_array($row['departamento'], $array['listaRegionesNombre'])) {
				array_push($array['listaRegionesNombre'],$row['departamento']);
			}
			if ( !in_array($row['provincia'], $array['listaProvinciasNombre'])) {
				array_push($array['listaProvinciasNombre'], $row['provincia']);
			}
			if ( !in_array($row['distrito'], $array['listaDistritosNombre'])) {
				array_push($array['listaDistritosNombre'], $row['distrito']);
			}
		}

		$rs_regiones = $this->model->obtener_listado_regiones_concatenado();
		$array['listaRegionesConcatenado'] = $rs_regiones;

		//LISTADO DE ZONAS PELIGROSAS
		$rs_zonaPeligrosa = $this->model->obtener_zona_peligrosa();
		$array['listaZonaPeligrosaNombre'] = array();
		foreach ($rs_zonaPeligrosa as $klzp => $row) {
			if ( !in_array($row['descripcion'], $array['listaZonaPeligrosaNombre'])) {
				array_push($array['listaZonaPeligrosaNombre'], $row['descripcion']);
			}
		}

		//LISTADO DE FRECUENCIAS
		$array['listaFrecuenciaNombre'] = array();
		$rs_frecuencia = $this->model->obtener_frecuencia();
		foreach ($rs_frecuencia as $klf => $row) {
			if ( !in_array($row['frecuencia'], $array['listaFrecuenciaNombre'])) {
				array_push($array['listaFrecuenciaNombre'], $row['frecuencia']);
			}
		}

		/*==ES NECESARIO VERIFICAR PERMISOS==*/
		//LISTADO DE LA CUENTA-PROYECTO
		$array['listaCuentaNombre'] = array();
		$array['listaProyectoNombre'] = array();
		$rs_cuentaProyecto = $this->model->obtener_cuenta_proyecto($input);
		foreach ($rs_cuentaProyecto as $klcp => $row) {
			if ( !in_array($row['cuenta'], $array['listaCuentaNombre'])) {
				array_push($array['listaCuentaNombre'], $row['cuenta']);
			}
			if ( !in_array($row['proyecto'], $array['listaProyectoNombre'])) {
				array_push($array['listaProyectoNombre'], $row['proyecto']);
			}
		}
		
		//LISTADO DE CUENTA-PROYECTO-ZONA
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE ZONAS
		$array['listaZonaNombre'] = array();
		if ( !empty($this->permisos['zona'])) { $rs_zona = $this->model->obtener_zonas_usuarioHistZona($input); }
		else { $rs_zona = $this->model->obtener_zonas($input); }
		//
		foreach ($rs_zona as $klz => $row) {
			if ( !in_array($row['zona'], $array['listaZonaNombre'])) {
				array_push($array['listaZonaNombre'], $row['zona']);
			}
		}

		//LISTADO DE CUENTA - GRUPO CANAL - CANAL
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CANAL
		$array['listaGrupoCanalNombre'] = array();
		$array['listaCanalNombre'] = array();
		$array['listaClienteTipoNombre'] = array();
		if (!empty($this->permisos['canal'])) { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal_usuarioHistCanal($input); } 
		else { $rs_grupoCanalCanal = $this->model->obtener_grupocanal_canal($input); }
		//
		foreach ($rs_grupoCanalCanal as $kgc => $row) {
			if ( !in_array($row['grupoCanal'], $array['listaGrupoCanalNombre'])) {
				array_push($array['listaGrupoCanalNombre'], $row['grupoCanal']);
			}
			if ( !in_array($row['canal'], $array['listaCanalNombre'])) {
				array_push($array['listaCanalNombre'], $row['canal']);
			}
			if ( !in_array($row['clienteTipo'], $array['listaClienteTipoNombre'])) {
				array_push($array['listaClienteTipoNombre'], $row['clienteTipo']);
			}
		}

		//LISTADO DE CADENA - BANNER
		//VERIFICAMOS SI ES QUE EXISTE PERMISOS DE CADENA-BANNER
		$array['listaCadenaNombre'] = array();
		$array['listaBannerNombre'] = array();
		if ( !empty($this->permisos['banner']) ) { $rs_cadenaBanner = $this->model->obtener_cadena_banner_usuarioHistBanner(); }
		else { $rs_cadenaBanner = $this->model->obtener_cadena_banner(); }
		//
		foreach ($rs_cadenaBanner as $klcb => $row) {
			if ( !in_array($row['cadena'], $array['listaCadenaNombre'])) {
				array_push($array['listaCadenaNombre'], $row['cadena']);
			}
			if ( !in_array($row['banner'], $array['listaBannerNombre'])) {
				array_push($array['listaBannerNombre'], $row['banner']);
			}
		}

		//LISTADO DE LAS PLAZAS
		//VERIFICAMOS QUE EXISTA PERMISOS DE PLAZAS
		$array['listaPlazaNombre'] = array();
		if ( !empty($this->permisos['plaza'])) { $rs_plaza = $this->model->obtener_plazas_todos_usuarioHistPlaza($input); }
		else { $rs_plaza = $this->model->obtener_plazas_todos(); }
		
		//
		foreach ($rs_plaza as $klp => $row) {
			if ( !in_array($row['plaza'], $array['listaPlazaNombre'])) {
				array_push($array['listaPlazaNombre'], $row['plaza']);
			}
		}
		$rs_plaza = $this->model->obtener_plazas_mayoristas();
		foreach ($rs_plaza as $klp => $row) {
			if ( !in_array($row['plaza'], $array['listaPlazaNombre'])) {
				array_push($array['listaPlazaNombre'], $row['plaza']);
			}
		}
		

		//LISTADO DE DISTRIBUDIORA SUCURSAL
		//VERIFICAMOS SI ES QUE EXISTEN PERMISOS DE DISTRIBUDIORA SUCURSAL
		$array['listaDistribuidoraSucursalNombre'] = array();
		if (!empty($this->permisos['distribuidoraSucursal'])) {	$rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal_usuarioHistDS($input); } 
		else { $rs_distribuidoraSucursal = $this->model->obtener_distribuidora_sucursal($input); }
		//
		foreach ($rs_distribuidoraSucursal as $klds => $row) {
			if ( !in_array($row['distribuidoraSucursal'], $array['listaDistribuidoraSucursalNombre'])) {
				array_push($array['listaDistribuidoraSucursalNombre'], $row['distribuidoraSucursal']);
			}
		}

		$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_historicoPuntoMasivo", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVO PUNTO MASIVO';
		$result['data']['html'] = $html;	

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	

	public function guardarHistoricoMasivo(){
		set_time_limit(0);
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$idUsuario = $this->idUsuario;
		$tipoSegmentacion = $data->{'tipoSegmentacion'};
		$registrar = $data->{'registrar'};
		$dataArray = $data->{'dataArray'};

		

		$html=''; $htmlDuplicados='';
		$rowInsertedClienteHistorico=0;
		$rowUpdatedClienteHistorico=0;

		$idCuenta = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$idProyecto = !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$inputProyectos=array();
		$aProyectos =array();
		
		$aProyectos = $this->model->lista_proyectosAuditoria([ 'idProyecto' => $idProyecto ]);
		foreach($aProyectos as $rowProyectos){
			$inputProyectos[$rowProyectos['idProyecto']]=$rowProyectos['idProyecto'];
		}
		$inputProyectos[$idProyecto]=$idProyecto;

		

		$inputClientesActualizar=array();

		$validacion_cliente=true;
		//actualizar
		if($registrar=="0"){

			
			if ( !empty($dataArray)) {

				//validacion cliente
				foreach ($dataArray as $kd => $cliente) {

					$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
					$inputBusqueda=array();
					$inputBusqueda['idCliente'] = $idCliente;

					$rs_verificarExistenciaCliente=null;
					$rs_verificarExistenciaCliente = $this->model->obtener_verificacion_existente($inputBusqueda);
					if( empty($rs_verificarExistenciaCliente) ){
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE ENCONTRO EL CLIENTE CON ID CLIENTE  <strong>'.$idCliente.'</strong> .</div>';
						$validacion_cliente=false;
					}
				}

				//validacion cliente historico existente
				if($validacion_cliente){

					foreach ($dataArray as $kd => $cliente) {
						$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
						$fechaInicio = (isset($cliente[16]) && !empty($cliente[16])) ? $cliente[16] : date('Y-m-d');
						if( strpos($fechaInicio,"-") !== false ){
							$fechaInicio = date_change_format($fechaInicio);
						}
						$fechaFin = (isset($cliente[17]) && !empty($cliente[17])) ? $cliente[17] : NULL;

						$inputBusquedaHistorico=array();
						$inputBusquedaHistorico['idCliente'] = $idCliente;
						$inputBusquedaHistorico['idCuenta'] = $idCuenta;

						$inputBusquedaHistorico['fecIni'] = $fechaInicio;
						$inputBusquedaHistorico['fecFin'] = $fechaFin;
						$rs_verificarExistenciaClienteHistorico = $this->model->obtener_cliente_historico_por_fecha($inputBusquedaHistorico,$inputProyectos);
					
						$inputIdClienteHist=array();
						if( empty($rs_verificarExistenciaClienteHistorico) ){
							$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO EXISTE CLIENTE HISTORICO VIGENTE DEL CLIENTE <strong>'.$idCliente.'</strong> .</div>';
							$validacion_cliente=false;
						}
					}
				}

				//actualizacion de historicos
				if($validacion_cliente){

					foreach ($dataArray as $kd => $cliente) {

						$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
	
						if( !empty($idCliente) ){
							$inputClientesActualizar[$idCliente] = $idCliente;
	
							$nombreComercial = (isset($cliente[1]) && !empty($cliente[1])) ? $cliente[1] : NULL;
							$razonSocial = (isset($cliente[2]) && !empty($cliente[2])) ? $cliente[2] : NULL;
							$ruc = (isset($cliente[3]) && !empty($cliente[3])) ? $cliente[3] : NULL;
							$dni = (isset($cliente[4]) && !empty($cliente[4])) ? $cliente[4] : NULL;
							$codigoUbigeo = (isset($cliente[8]) && !empty($cliente[8])) ? $cliente[8] : NULL;
							$direccion = (isset($cliente[9]) && !empty($cliente[9])) ? $cliente[9] : NULL;
							$referencia = (isset($cliente[10]) && !empty($cliente[10])) ? $cliente[10] : NULL;
							$latitud = (isset($cliente[11]) && !empty($cliente[11])) ? $cliente[11] : NULL;
							$longitud = (isset($cliente[12]) && !empty($cliente[12])) ? $cliente[12] : NULL;
							$zonaPeligrosa = (isset($cliente[13]) && !empty($cliente[13])) ? $cliente[13] : NULL;
								$idZonaPeligrosa = $this->model->obtener_id_zona_peligrosa($zonaPeligrosa);
								$idZonaPeligrosa = ( !empty($idZonaPeligrosa) ? $idZonaPeligrosa[0]['idZonaPeligrosa'] : NULL );
	
							$codigoCliente = (isset($cliente[14]) && !empty($cliente[14])) ? $cliente[14] : NULL;
							$flagCartera = (isset($cliente[15]) && !empty($cliente[15])) ? ($cliente[15]=='SI' ? 1 : 0) : 1;
	
							$fechaInicio = (isset($cliente[16]) && !empty($cliente[16])) ? $cliente[16] : date('Y-m-d');
							if( strpos($fechaInicio,"-") !== false ){
								$fechaInicio = date_change_format($fechaInicio);
							}
							$fechaFin = (isset($cliente[17]) && !empty($cliente[17])) ? $cliente[17] : NULL;
	
							$frecuencia = (isset($cliente[18]) && !empty($cliente[18])) ? $cliente[18] : NULL;
								$idFrecuencia = $this->model->obtener_id_frecuencia($frecuencia);
								$idFrecuencia = ( !empty($idFrecuencia) ? $idFrecuencia[0]['idFrecuencia'] : NULL );
	
							$zona = (isset($cliente[19]) && !empty($cliente[19])) ? $cliente[19] : NULL;
								$idZona = $this->model->obtener_id_zona($zona);
								$idZona = ( !empty($idZona) ? $idZona[0]['idZona'] : NULL ) ;
	
							$grupoCanal = (isset($cliente[20]) && !empty($cliente[20])) ? $cliente[20] : NULL;
							$canal = (isset($cliente[21]) && !empty($cliente[21])) ? $cliente[21] : NULL;
							$clienteTipo = (isset($cliente[22]) && !empty($cliente[22])) ? $cliente[22] : NULL;
	
							//VERIFICAMOS LA SEGMETACIÓN DEL CLIENTE
							$plaza=NULL; $dataDistribuidoraSucursal=NULL; 
							$cadena=NULL; $banner=NULL;
	
							if ( $tipoSegmentacion==1 ) {
								//SEGMENTACIÓN CLIENTE TRADICIONAL
								$plaza = (isset($cliente[23]) && !empty($cliente[23])) ? $cliente[23] : NULL;
								if ( count($cliente) > 25 ) {
									$dataDistribuidoraSucursal = array();
									for ($i=24; $i < count($cliente); $i++) { 
										if ( $cliente[$i] !== null ) array_push($dataDistribuidoraSucursal, $cliente[$i]);
									}
								} else {
									$dataDistribuidoraSucursal = (isset($cliente[24]) && !empty($cliente[24])) ? $cliente[24] : NULL;
								}
							} elseif( $tipoSegmentacion==2){
								//SEGMENTACIÓN CLIENTE MODERNO
								$cadena = (isset($cliente[23]) && !empty($cliente[23])) ? $cliente[23] : NULL;
								$banner = (isset($cliente[24]) && !empty($cliente[24])) ? $cliente[24] : NULL;
							}
	
							/****************SEGMENTACIONES*******************/
							$idSegNegocio = NULL; $idSegClienteTradicional = NULL; $idSegClienteModerno = NULL;
	
							/************SEGMETACIÓN NEGOCIO*********************/
							if ( !empty($canal) ) {
								$rs_idCanal = $this->model->obtener_id_canal($canal);
								//$rs_idSubCanal = $this->model->obtener_id_subCanal($subCanal);
								$rs_idClienteTipo = $this->model->obtener_id_clienteTipo($clienteTipo);
	
								$arraySegNegocio=array();
								$arraySegNegocio['idCanal'] = (!empty($rs_idCanal) ? $rs_idCanal[0]['idCanal']:NULL);
								$arraySegNegocio['idClienteTipo']= (!empty($rs_idClienteTipo) ? $rs_idClienteTipo[0]['idClienteTipo']:NULL);
	
								//$rs_segmentacionNegocio = $this->model->obtener_id_segmentacion_negocio($canal);
								$rs_segmentacionNegocio = $this->model->obtener_segmentacion_negocio($arraySegNegocio);
								if ( !empty($rs_segmentacionNegocio)) {
									$idSegNegocio = $rs_segmentacionNegocio[0]['idSegNegocio'];
								} else {
									$insertarSegNegocio = $this->model->insertar_segmentacion_negocio($arraySegNegocio);
									if ($insertarSegNegocio) {
										$idSegNegocio = $this->db->insert_id();
									}
								}
							}
							/***********SEGMENTACION CLIENTE MODERNO**************/
							if ( !empty($banner)) {
								$rs_segmentacionClienteModeno = $this->model->obtener_id_segmentacion_cliente_moderno($banner);
								if ( !empty($rs_segmentacionClienteModeno)) {
									$idSegClienteModerno = $rs_segmentacionClienteModeno[0]['idSegClienteModerno'];
								}
							}
							/**********SEGMENTACION CLIENTE TRADICIONAL*********/
							$filtroWhere='';
								if ( !empty($plaza) || !empty($dataDistribuidoraSucursal)) {
								//PLAZA
								$filtroWhere.= ( !empty($plaza) ? " AND data3.plaza LIKE '".$plaza."'" : " AND data3.plaza IS NULL" );
								//DISTRIBUIDORA SUCURSAL
								if (!empty($dataDistribuidoraSucursal)) {
									if ( is_array($dataDistribuidoraSucursal)) {
										$stringDS = implode(",", $dataDistribuidoraSucursal);
										$filtroWhere.= " AND data3.distribuidoraSucursal LIKE'".$stringDS."'";
									} else {
										$filtroWhere.= " AND data3.distribuidoraSucursal LIKE '".$dataDistribuidoraSucursal."'";
									}
								} else {
									$filtroWhere.= " AND data3.distribuidoraSucursal IS NULL";
								}
								//
	
								//BUSCAMOS EL VALOR DEL ID SEGMENTACION CLIENTE TRADICIONAL
								$rs_segmentacionClienteTradicional = $this->model->obtener_id_segmentacion_cliente_tradicional($filtroWhere);
								
								/***VERIFICAMOS EXISTENCIA***/
								if (!empty($rs_segmentacionClienteTradicional)) {
									//EXISTE DATA
									$idSegClienteTradicional = $rs_segmentacionClienteTradicional[0]['idSegClienteTradicional'];
								} else {
									//NO EXISTE DATA
									$idPlaza=NULL;
									if (!empty($plaza)) {
										$rs_idPlaza = ( in_array($grupoCanal, ['HFS']) ? $this->model->obtener_id_plaza_todo($plaza) : $this->model->obtener_id_plaza_mayorista($plaza) );
										$idPlaza = ( !empty($rs_idPlaza) ) ? $rs_idPlaza[0]['idPlaza'] : NULL;
									}
									//
									$arrayCabecera=array();
									$arrayCabecera['idPlaza']= $idPlaza;
									$arrayCabecera['idDistribuidoraSucursal']=NULL;
	
									//INSERTAMOS LA CABECERA DE LA SEGMENTACION CLIENTE TRADICIONAL
									$insertSegmentacionClienteTradicional = $this->model->insert_segmentacion_cliente_tradicional_v1($arrayCabecera);
									if ( $insertSegmentacionClienteTradicional) {
										$idSegClienteTradicional = $this->db->insert_id();
									} else {
										$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR LA PLAZA.</div>';
									}
	
									//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
									if (!empty($dataDistribuidoraSucursal)) {
										if (is_array($dataDistribuidoraSucursal)) {
											foreach ($dataDistribuidoraSucursal as $kdd => $value) {
												$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($value);
												$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
												//INSERTAMOS EL DETALLE
												$arrayDetalleDS=array();
												$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
												$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
												//
												$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
											}
										} else {
											$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($dataDistribuidoraSucursal);
											$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
											//INSERTAMOS EL DETALLE
											$arrayDetalleDS=array();
											$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
											$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
											//
											$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
										}
									}				
								}
							}
	


							$inputBusquedaHistorico=array();
							$inputBusquedaHistorico['idCliente'] = $idCliente;
							$inputBusquedaHistorico['idCuenta'] = $idCuenta;
							//$inputBusquedaHistorico['idProyecto'] = $idProyecto;

							$inputBusquedaHistorico['fecIni'] = $fechaInicio;
							$inputBusquedaHistorico['fecFin'] = $fechaFin;
							$rs_verificarExistenciaClienteHistorico = $this->model->obtener_cliente_historico_por_fecha($inputBusquedaHistorico,$inputProyectos);
						
							$inputIdClienteHist=array();
							if( !empty($rs_verificarExistenciaClienteHistorico) ){
								if( count($rs_verificarExistenciaClienteHistorico)>0){
									foreach($rs_verificarExistenciaClienteHistorico as $clienteHist){
										$inputIdClienteHist[$clienteHist['idClienteHist']]=$clienteHist['idClienteHist'];
									}
								}
							}
							
							if( !empty($inputIdClienteHist) ){
								if( count($inputIdClienteHist)>0){

									//actualizar cliente
									$inputCliente = array();
									if(!empty($dni) || !empty($ruc)){
										if( !empty($dni) ) $inputCliente['dni'] = $dni;
										if( !empty($ruc) ) $inputCliente['ruc'] = $ruc;
		
										$inputWhereCliente = array();
										$inputWhereCliente['idCliente'] = $idCliente;
		
										$arrayUpdateCliente['arrayParams'] = $inputCliente;
										$arrayUpdateCliente['arrayWhere'] = $inputWhereCliente;
										$updateCliente = $this->model->update_cliente($arrayUpdateCliente);
									}


									//actualizar historico
									$inputHistorico = array();
									$inputHistorico['idCliente'] = $idCliente;

									if( !empty($nombreComercial) ) $inputHistorico['nombreComercial'] = $nombreComercial;
									if( !empty($razonSocial) ) $inputHistorico['razonSocial'] = $razonSocial;
									
									if( !empty($idSegNegocio) ) $inputHistorico['idSegNegocio'] = $idSegNegocio;
									if( !empty($idSegClienteTradicional) ) $inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
									if( !empty($idSegClienteModerno) ) $inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
									//if( !empty($fechaInicio) ) $inputHistorico['fecIni'] = $fechaInicio;
									//if( !empty($fechaFin) ) $inputHistorico['fecFin'] = $fechaFin;

									// $inputHistorico['idCuenta'] = $idCuenta;
									// $inputHistorico['idProyecto'] = $idProyecto;

									if( !empty($idFrecuencia) ) $inputHistorico['idFrecuencia'] = $idFrecuencia;
									if( !empty($idZona) ) $inputHistorico['idZona'] = $idZona;
									if( !empty($idZonaPeligrosa) ) $inputHistorico['idZonaPeligrosa'] = $idZonaPeligrosa;
									if( !empty($flagCartera) ) $inputHistorico['flagCartera'] = $flagCartera;
									if( !empty($codigoCliente) ) $inputHistorico['codCliente'] = $codigoCliente;
									if( !empty($codigoUbigeo) ) $inputHistorico['cod_ubigeo'] = $codigoUbigeo;
									if( !empty($direccion) ) $inputHistorico['direccion'] = $direccion;
									if( !empty($referencia) ) $inputHistorico['referencia'] = $referencia;
									if( !empty($latitud) ) $inputHistorico['latitud'] = $latitud;
									if( !empty($longitud) ) $inputHistorico['longitud'] = $longitud;


									
									$arrayUpdateClienteHistorico['arrayParams'] = $inputHistorico;
									$arrayUpdateClienteHistorico['idClienteHist'] = $inputIdClienteHist;
									//
									$updateClienteHistorico = $this->model->update_cliente_historico_proyectos($arrayUpdateClienteHistorico);
									
									if ($updateClienteHistorico) {
										$rowUpdatedClienteHistorico++;
									} else {
										$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE LOGRÓ ACTUALIZAR EL CLIENTE HISTÓRICO DE <strong>'.$razonSocial.' - '.$direccion.'</strong> CORRECTAMENTE.</div>';
									}
								}
							}
						}
					}

				}

				//actualizar visitas
				if( count($inputClientesActualizar)>0){
					$this->model->actualizar_visitas($inputClientesActualizar);
				}
			}

		}

		//registrar
		if($registrar=="1"){
			if ( !empty($dataArray)) {

				//validacion cliente
				foreach ($dataArray as $kd => $cliente) {

					$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
					$fechaInicio = (isset($cliente[16]) && !empty($cliente[16])) ? $cliente[16] : date('Y-m-d');
							
					$inputBusqueda=array();
					$inputBusqueda['idCliente'] = $idCliente;

					$rs_verificarExistenciaCliente=null;
					$rs_verificarExistenciaCliente = $this->model->obtener_verificacion_existente($inputBusqueda);
					if( empty($rs_verificarExistenciaCliente) ){
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE ENCONTRO EL CLIENTE CON ID CLIENTE  <strong>'.$idCliente.'</strong> .</div>';
						$validacion_cliente=false;
					}
					if( empty($fechaInicio)){
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE ENCONTRO LA FECHA INICIO PARA EL ID CLIENTE  <strong>'.$idCliente.'</strong> .</div>';
						$validacion_cliente=false;
					}
				}


				if($validacion_cliente){
					foreach ($dataArray as $kd => $cliente) {

						$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? $cliente[0] : NULL;
	
						if( !empty($idCliente) ){
							$inputClientesActualizar[$idCliente] = $idCliente;
	
							$nombreComercial = (isset($cliente[1]) && !empty($cliente[1])) ? $cliente[1] : NULL;
							$razonSocial = (isset($cliente[2]) && !empty($cliente[2])) ? $cliente[2] : NULL;
							$ruc = (isset($cliente[3]) && !empty($cliente[3])) ? $cliente[3] : NULL;
							$dni = (isset($cliente[4]) && !empty($cliente[4])) ? $cliente[4] : NULL;
							$codigoUbigeo = (isset($cliente[8]) && !empty($cliente[8])) ? $cliente[8] : NULL;
							$direccion = (isset($cliente[9]) && !empty($cliente[9])) ? $cliente[9] : NULL;
							$referencia = (isset($cliente[10]) && !empty($cliente[10])) ? $cliente[10] : NULL;
							$latitud = (isset($cliente[11]) && !empty($cliente[11])) ? $cliente[11] : NULL;
							$longitud = (isset($cliente[12]) && !empty($cliente[12])) ? $cliente[12] : NULL;
							$zonaPeligrosa = (isset($cliente[13]) && !empty($cliente[13])) ? $cliente[13] : NULL;
								$idZonaPeligrosa = $this->model->obtener_id_zona_peligrosa($zonaPeligrosa);
								$idZonaPeligrosa = ( !empty($idZonaPeligrosa) ? $idZonaPeligrosa[0]['idZonaPeligrosa'] : NULL );
	
							$codigoCliente = (isset($cliente[14]) && !empty($cliente[14])) ? $cliente[14] : NULL;
							$flagCartera = (isset($cliente[15]) && !empty($cliente[15])) ? ($cliente[15]=='SI' ? 1 : 0) : 1;
	
							$fechaInicio = (isset($cliente[16]) && !empty($cliente[16])) ? $cliente[16] : date('Y-m-d');
							if( strpos($fechaInicio,"-") !== false ){
								$fechaInicio = date_change_format($fechaInicio);
							}
							$fechaFin = (isset($cliente[17]) && !empty($cliente[17])) ? $cliente[17] : NULL;
	
							$frecuencia = (isset($cliente[18]) && !empty($cliente[18])) ? $cliente[18] : NULL;
								$idFrecuencia = $this->model->obtener_id_frecuencia($frecuencia);
								$idFrecuencia = ( !empty($idFrecuencia) ? $idFrecuencia[0]['idFrecuencia'] : NULL );
	
							$zona = (isset($cliente[19]) && !empty($cliente[19])) ? $cliente[19] : NULL;
								$idZona = $this->model->obtener_id_zona($zona);
								$idZona = ( !empty($idZona) ? $idZona[0]['idZona'] : NULL ) ;
	
							$grupoCanal = (isset($cliente[20]) && !empty($cliente[20])) ? $cliente[20] : NULL;
							$canal = (isset($cliente[21]) && !empty($cliente[21])) ? $cliente[21] : NULL;
							$clienteTipo = (isset($cliente[22]) && !empty($cliente[22])) ? $cliente[22] : NULL;
	
							//VERIFICAMOS LA SEGMETACIÓN DEL CLIENTE
							$plaza=NULL; $dataDistribuidoraSucursal=NULL; 
							$cadena=NULL; $banner=NULL;
	
							if ( $tipoSegmentacion==1 ) {
								//SEGMENTACIÓN CLIENTE TRADICIONAL
								$plaza = (isset($cliente[23]) && !empty($cliente[23])) ? $cliente[23] : NULL;
								if ( count($cliente) > 25 ) {
									$dataDistribuidoraSucursal = array();
									for ($i=24; $i < count($cliente); $i++) { 
										if ( $cliente[$i] !== null ) array_push($dataDistribuidoraSucursal, $cliente[$i]);
									}
								} else {
									$dataDistribuidoraSucursal = (isset($cliente[24]) && !empty($cliente[24])) ? $cliente[24] : NULL;
								}
							} elseif( $tipoSegmentacion==2){
								//SEGMENTACIÓN CLIENTE MODERNO
								$cadena = (isset($cliente[23]) && !empty($cliente[23])) ? $cliente[23] : NULL;
								$banner = (isset($cliente[24]) && !empty($cliente[24])) ? $cliente[24] : NULL;
							}
	
							/****************SEGMENTACIONES*******************/
							$idSegNegocio = NULL; $idSegClienteTradicional = NULL; $idSegClienteModerno = NULL;
	
							/************SEGMETACIÓN NEGOCIO*********************/
							if ( !empty($canal) ) {
								$rs_idCanal = $this->model->obtener_id_canal($canal);
								//$rs_idSubCanal = $this->model->obtener_id_subCanal($subCanal);
								$rs_idClienteTipo = $this->model->obtener_id_clienteTipo($clienteTipo);
	
								$arraySegNegocio=array();
								$arraySegNegocio['idCanal'] = (!empty($rs_idCanal) ? $rs_idCanal[0]['idCanal']:NULL);
								$arraySegNegocio['idClienteTipo']= (!empty($rs_idClienteTipo) ? $rs_idClienteTipo[0]['idClienteTipo']:NULL);
	
								//$rs_segmentacionNegocio = $this->model->obtener_id_segmentacion_negocio($canal);
								$rs_segmentacionNegocio = $this->model->obtener_segmentacion_negocio($arraySegNegocio);
								if ( !empty($rs_segmentacionNegocio)) {
									$idSegNegocio = $rs_segmentacionNegocio[0]['idSegNegocio'];
								} else {
									$insertarSegNegocio = $this->model->insertar_segmentacion_negocio($arraySegNegocio);
									if ($insertarSegNegocio) {
										$idSegNegocio = $this->db->insert_id();
									}
								}
							}
							/***********SEGMENTACION CLIENTE MODERNO**************/
							if ( !empty($banner)) {
								$rs_segmentacionClienteModeno = $this->model->obtener_id_segmentacion_cliente_moderno($banner);
								if ( !empty($rs_segmentacionClienteModeno)) {
									$idSegClienteModerno = $rs_segmentacionClienteModeno[0]['idSegClienteModerno'];
								}
							}
							/**********SEGMENTACION CLIENTE TRADICIONAL*********/
							$filtroWhere='';
								if ( !empty($plaza) || !empty($dataDistribuidoraSucursal)) {
								//PLAZA
								$filtroWhere.= ( !empty($plaza) ? " AND data3.plaza LIKE '".$plaza."'" : " AND data3.plaza IS NULL" );
								//DISTRIBUIDORA SUCURSAL
								if (!empty($dataDistribuidoraSucursal)) {
									if ( is_array($dataDistribuidoraSucursal)) {
										$stringDS = implode(",", $dataDistribuidoraSucursal);
										$filtroWhere.= " AND data3.distribuidoraSucursal LIKE'".$stringDS."'";
									} else {
										$filtroWhere.= " AND data3.distribuidoraSucursal LIKE '".$dataDistribuidoraSucursal."'";
									}
								} else {
									$filtroWhere.= " AND data3.distribuidoraSucursal IS NULL";
								}
								//
	
								//BUSCAMOS EL VALOR DEL ID SEGMENTACION CLIENTE TRADICIONAL
								$rs_segmentacionClienteTradicional = $this->model->obtener_id_segmentacion_cliente_tradicional($filtroWhere);
								
								/***VERIFICAMOS EXISTENCIA***/
								if (!empty($rs_segmentacionClienteTradicional)) {
									//EXISTE DATA
									$idSegClienteTradicional = $rs_segmentacionClienteTradicional[0]['idSegClienteTradicional'];
								} else {
									//NO EXISTE DATA
									$idPlaza=NULL;
									if (!empty($plaza)) {
										$rs_idPlaza = ( in_array($grupoCanal, ['HFS']) ? $this->model->obtener_id_plaza_todo($plaza) : $this->model->obtener_id_plaza_mayorista($plaza) );
										$idPlaza = ( !empty($rs_idPlaza) ) ? $rs_idPlaza[0]['idPlaza'] : NULL;
									}
									//
									$arrayCabecera=array();
									$arrayCabecera['idPlaza']= $idPlaza;
									$arrayCabecera['idDistribuidoraSucursal']=NULL;
	
									//INSERTAMOS LA CABECERA DE LA SEGMENTACION CLIENTE TRADICIONAL
									$insertSegmentacionClienteTradicional = $this->model->insert_segmentacion_cliente_tradicional_v1($arrayCabecera);
									if ( $insertSegmentacionClienteTradicional) {
										$idSegClienteTradicional = $this->db->insert_id();
									} else {
										$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR LA PLAZA.</div>';
									}
	
									//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
									if (!empty($dataDistribuidoraSucursal)) {
										if (is_array($dataDistribuidoraSucursal)) {
											foreach ($dataDistribuidoraSucursal as $kdd => $value) {
												$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($value);
												$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
												//INSERTAMOS EL DETALLE
												$arrayDetalleDS=array();
												$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
												$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
												//
												$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
											}
										} else {
											$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($dataDistribuidoraSucursal);
											$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
											//INSERTAMOS EL DETALLE
											$arrayDetalleDS=array();
											$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
											$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
											//
											$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
										}
									}				
								}
							}
	
						
	
							$inputBusquedaHistorico=array();
							$inputBusquedaHistorico['idCliente'] = $idCliente;
							$inputBusquedaHistorico['idCuenta'] = $idCuenta;
							$inputBusquedaHistorico['fecIni'] = $fechaInicio;
							$inputBusquedaHistorico['fecFin'] = $fechaFin;
							$rs_verificarExistenciaClienteHistorico = $this->model->obtener_cliente_historico_por_fecha($inputBusquedaHistorico,$inputProyectos);
						
							
							$inputIdClienteHistFinalizar=array();
							if( !empty($rs_verificarExistenciaClienteHistorico) ){
								if( count($rs_verificarExistenciaClienteHistorico)>0){
									foreach($rs_verificarExistenciaClienteHistorico as $clienteHist){
											$inputIdClienteHistFinalizar[$clienteHist['idClienteHist']]=$clienteHist['idClienteHist'];
									}

									if( count($inputIdClienteHistFinalizar)>0){
										$inputHistoricoFinalizar=array();

										if( strpos($fechaInicio,"/") !== false ){
											$fecha = explode('/', $fechaInicio);
											$fechaInicio = $fecha[0] . '-' . $fecha[1] . '-' . $fecha[2];
										}

										$fechaFinFinalizar= date('d/m/Y', strtotime($fechaInicio."-1 day"));
										
										$inputHistoricoFinalizar['fecFin']=$fechaFinFinalizar;
										$arrayUpdateClienteHistorico['arrayParams'] = $inputHistoricoFinalizar;
										$arrayUpdateClienteHistorico['idClienteHist'] = $inputIdClienteHistFinalizar;
										$updateClienteHistorico = $this->model->update_cliente_historico_proyectos($arrayUpdateClienteHistorico);
									}
								}
							}

									

								
							//nuevo historico
							foreach($inputProyectos as $proyectoRegistrar){

								//finalizar historicos
								$inputUltimoHistorico=array();
								$inputUltimoHistorico['idCliente'] = $idCliente;
								$inputUltimoHistorico['idProyecto'] = $proyectoRegistrar;
								$rs_ultimoHistorico = $this->model->obtener_cliente_historico_ultimo($inputUltimoHistorico);
								$inputHistorico = array();
								if(!empty($rs_ultimoHistorico)){
									if( count($rs_ultimoHistorico)>0){
										$inputHistorico['nombreComercial']=$rs_ultimoHistorico[0]['nombreComercial'];
										$inputHistorico['razonSocial']=$rs_ultimoHistorico[0]['razonSocial'];
										$inputHistorico['idSegNegocio']=$rs_ultimoHistorico[0]['idSegNegocio'];
										$inputHistorico['idSegClienteTradicional']=$rs_ultimoHistorico[0]['idSegClienteTradicional'];
										$inputHistorico['idSegClienteModerno']=$rs_ultimoHistorico[0]['idSegClienteModerno'];
										$inputHistorico['idFrecuencia']=$rs_ultimoHistorico[0]['idFrecuencia'];
										$inputHistorico['idZona']=$rs_ultimoHistorico[0]['idZona'];
										$inputHistorico['idZonaPeligrosa']=$rs_ultimoHistorico[0]['idZonaPeligrosa'];
										$inputHistorico['flagCartera']=$rs_ultimoHistorico[0]['flagCartera'];
										$inputHistorico['codCliente']=$rs_ultimoHistorico[0]['codCliente'];
										$inputHistorico['cod_ubigeo']=$rs_ultimoHistorico[0]['cod_ubigeo'];
										$inputHistorico['direccion']=$rs_ultimoHistorico[0]['direccion'];
										$inputHistorico['referencia']=$rs_ultimoHistorico[0]['referencia'];
										$inputHistorico['latitud']=$rs_ultimoHistorico[0]['latitud'];
										$inputHistorico['longitud']=$rs_ultimoHistorico[0]['longitud'];
									}
								}

								
								$inputHistorico['idCliente'] = $idCliente;
				
								if( !empty($nombreComercial) ) $inputHistorico['nombreComercial'] = $nombreComercial;
								if( !empty($razonSocial) ) $inputHistorico['razonSocial'] = $razonSocial;
								//if( !empty($dni) ) $inputHistorico['dni'] = $dni;
								//if( !empty($ruc) ) $inputHistorico['ruc'] = $ruc;
								if( !empty($idSegNegocio) ) $inputHistorico['idSegNegocio'] = $idSegNegocio;
								if( !empty($idSegClienteTradicional) ) $inputHistorico['idSegClienteTradicional'] = $idSegClienteTradicional;
								if( !empty($idSegClienteModerno) ) $inputHistorico['idSegClienteModerno'] = $idSegClienteModerno;
								$inputHistorico['fecIni'] = $fechaInicio;
								if( !empty($fechaFin) ) $inputHistorico['fecFin'] = $fechaFin;
				
								$inputHistorico['idCuenta'] = $idCuenta;
								$inputHistorico['idProyecto'] = $proyectoRegistrar;
				
								if( !empty($idFrecuencia) ) $inputHistorico['idFrecuencia'] = $idFrecuencia;
								if( !empty($idZona) ) $inputHistorico['idZona'] = $idZona;
								if( !empty($idZonaPeligrosa) ) $inputHistorico['idZonaPeligrosa'] = $idZonaPeligrosa;
								if( !empty($flagCartera) ) $inputHistorico['flagCartera'] = $flagCartera;
								if( !empty($codigoCliente) ) $inputHistorico['codCliente'] = $codigoCliente;
								if( !empty($codigoUbigeo) ) $inputHistorico['cod_ubigeo'] = $codigoUbigeo;
								if( !empty($direccion) ) $inputHistorico['direccion'] = $direccion;
								if( !empty($referencia) ) $inputHistorico['referencia'] = $referencia;
								if( !empty($latitud) ) $inputHistorico['latitud'] = $latitud;
								if( !empty($longitud) ) $inputHistorico['longitud'] = $longitud;
				
								$insertClienteHistorico = $this->model->insertar_cliente_historico($inputHistorico);
								
								if ($insertClienteHistorico) {
									$rowInsertedClienteHistorico++;
								} else {
									$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> NO SE LOGRÓ REGISTRAR EL CLIENTE HISTÓRICO DE <strong>'.$razonSocial.' - '.$direccion.'</strong> CORRECTAMENTE.</div>';
								}
							}

								
	
						}
					}

				}
				

				if( count($inputClientesActualizar)>0){
					$this->model->actualizar_visitas($inputClientesActualizar);
				}
			}


			
		}


		

		if ($validacion_cliente==false) {
			$result['result']=0;
		}
		else if ($rowUpdatedClienteHistorico>0 || $rowInsertedClienteHistorico>0) {
			$result['result']=1;
			//$this->enviarNotificacionNuevoRegistro($rowInsertedClienteHistorico);
			$mensaje=$html;

			$html='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ REGISTRAR <strong>'.$rowInsertedClienteHistorico.' CLIENTE HISTORICO(S) </strong> CORRECTAMENTE.</div>';
			$html.='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> SE LOGRÓ ACTUALIZAR <strong>'.$rowUpdatedClienteHistorico.' CLIENTE HISTORICO(S) </strong> CORRECTAMENTE.</div>';
			$html.=$mensaje;

		}else{
			$html='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-check-circle"></i> NO SE HA REALIZADO CAMBIOS.</div>';
		}

		$result['msg']['title'] = 'REGISTRAR PUNTO DE VENTA MASIVO';
		$result['msg']['content'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function filtrarAgregados(){
		if (in_array($this->idTipoUsuario, [4,10])) {
			$this->htmlTranferirAgregados=true;
		}

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input=array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['idSolicitudTipo'] = $data->{'slSolicitud'};

		$input['clientes'] = $data->{'txt-nombres'};


		if (in_array($this->idTipoUsuario, [2,6])) {
			$input['idUsuarioSolicitud'] = $this->idUsuario;
		}

		$input['idCuenta']= !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$input['idProyecto']= !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";

		$rs_basemadre_agregados=$this->model->obtener_maestros_basemadre_agregados($input);

		$html='';
		if ( !empty($rs_basemadre_agregados)) {
			$array=array();
			$array['htmlTranferirAgregados'] = $this->htmlTranferirAgregados;

			foreach ($rs_basemadre_agregados as $kb => $row) {
				$array['listaAgregados'][$row['idClienteHistPg']]['idClienteHistPg'] = $row['idClienteHistPg'];
				$array['listaAgregados'][$row['idClienteHistPg']]['idClientePg'] = $row['idClientePg'];
				$array['listaAgregados'][$row['idClienteHistPg']]['nombreComercial'] = $row['nombreComercial'];
				$array['listaAgregados'][$row['idClienteHistPg']]['razonSocial'] = $row['razonSocial'];
				$array['listaAgregados'][$row['idClienteHistPg']]['ruc'] = $row['ruc'];
				$array['listaAgregados'][$row['idClienteHistPg']]['dni'] = $row['dni'];
				$array['listaAgregados'][$row['idClienteHistPg']]['departamento'] = $row['departamento'];
				$array['listaAgregados'][$row['idClienteHistPg']]['provincia'] = $row['provincia'];
				$array['listaAgregados'][$row['idClienteHistPg']]['distrito'] = $row['distrito'];
				$array['listaAgregados'][$row['idClienteHistPg']]['direccion'] = $row['direccion'];
				$array['listaAgregados'][$row['idClienteHistPg']]['referencia'] = $row['referencia'];
				$array['listaAgregados'][$row['idClienteHistPg']]['zonaPeligrosa'] = $row['zonaPeligrosa'];
				$array['listaAgregados'][$row['idClienteHistPg']]['codCliente'] = $row['codCliente'];
				$array['listaAgregados'][$row['idClienteHistPg']]['carteraCliente'] = $row['flagCartera']==1 ? 'SI':'NO';
				$array['listaAgregados'][$row['idClienteHistPg']]['fecIni'] = $row['fecIni'];
				$array['listaAgregados'][$row['idClienteHistPg']]['fecFin'] = $row['fecFin'];
				$array['listaAgregados'][$row['idClienteHistPg']]['cuenta'] = $row['cuenta'];
				$array['listaAgregados'][$row['idClienteHistPg']]['proyecto'] = $row['proyecto'];
				$array['listaAgregados'][$row['idClienteHistPg']]['grupoCanal'] = $row['grupoCanal'];
				$array['listaAgregados'][$row['idClienteHistPg']]['canal'] = $row['canal'];
				$array['listaAgregados'][$row['idClienteHistPg']]['clienteTipo'] = $row['clienteTipo'];
				$array['listaAgregados'][$row['idClienteHistPg']]['frecuencia'] = $row['frecuencia'];
				$array['listaAgregados'][$row['idClienteHistPg']]['zona'] = $row['zona'];
				$array['listaAgregados'][$row['idClienteHistPg']]['plaza'] = $row['plaza'];
				$array['listaAgregados'][$row['idClienteHistPg']]['distribuidoraSucursal'][$row['idDistribuidoraSucursal']] = $row['distribuidoraSucursal'];
				$array['listaAgregados'][$row['idClienteHistPg']]['cadena'] = $row['cadena'];
				$array['listaAgregados'][$row['idClienteHistPg']]['banner'] = $row['banner'];
				$array['listaAgregados'][$row['idClienteHistPg']]['idUsuarioSolicitud'] = $row['idUsuarioSolicitud'];
				$array['listaAgregados'][$row['idClienteHistPg']]['usuarioSolicitud'] = $row['usuarioSolicitud'];
				$array['listaAgregados'][$row['idClienteHistPg']]['idSolicitudTipo'] = $row['idSolicitudTipo'];
				$array['listaAgregados'][$row['idClienteHistPg']]['solicitudTipo'] = $row['solicitudTipo'];
				$array['listaAgregados'][$row['idClienteHistPg']]['observacionRechazo'] = $row['observacionRechazo'];
				$array['listaAgregados'][$row['idClienteHistPg']]['flagTransferido'] = $row['flagTransferido'];
			}

			$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/MstBasemadreDetalleAgregados", $array, true);
			$result['result'] = 1;
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['data']['html'] = $html;
		$result['data']['datatable'] = 'tb-maestrosClientesAgregados';

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function transferirClientesAgregados(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tabla = $data->{'tabla'};
		$dataClienteHistorico = $data->{'dataClienteHistorico'};

		$html=''; $rowInserted=0; $rowInsertedError=0;

		switch ($tabla) {
			case 'pg_v1':
				if (!empty($dataClienteHistorico)) {
					foreach ($dataClienteHistorico as $kl => $row) {
						$input['idClientePg'] = !empty($row->{'cliente'}) ? $row->{'cliente'} : NULL;
						$input['idClienteHistPg'] = !empty($row->{'clienteHistorico'}) ? $row->{'clienteHistorico'} : NULL;

						$rs_obtenerTransferirCliente = $this->model->obtener_tranferir_cliente_pg_v1($input);

						//VERIFICAMOS LA EXISTENCIA DE DATA
						if (!empty($rs_obtenerTransferirCliente)) {
							//ARRAY CABECERA
							$arrayCabecera=array();
							$arrayCabecera['nombreComercial'] = $rs_obtenerTransferirCliente[0]['nombreComercial'];
							$arrayCabecera['razonSocial'] = $rs_obtenerTransferirCliente[0]['razonSocial'];
							$arrayCabecera['ruc'] = $rs_obtenerTransferirCliente[0]['ruc'];
							$arrayCabecera['dni'] = $rs_obtenerTransferirCliente[0]['dni'];

							//VERIFICAMOS LA EXISTENCIA DEL CLIENTE
							$rs_verificarExistencia = $this->model->obtener_verificacion_existente($arrayCabecera);

							if ( empty($rs_verificarExistencia)) {
								//INSERTAMOS EL CLIENTE YA QUE NO EXISTE
								$insertarCliente = $this->model->insertar_cliente($arrayCabecera);

								if ( $insertarCliente ) {
									$idClienteInserted = $this->db->insert_id();
									$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR EL CLIENTE <strong>'.$arrayCabecera['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
								
									//CLIENTE HISTÓRICO
									$rs_obtenerTransferirClienteHistorico = $this->model->obtener_tranferir_cliente_historico_v1($input);

									if (!empty($rs_obtenerTransferirClienteHistorico)) {
										//ARRAY HISTORICO
										$arrayHistorico=array();
										$arrayHistorico['idCliente'] = $idClienteInserted;
										$arrayHistorico['nombreComercial'] = $rs_obtenerTransferirClienteHistorico[0]['nombreComercial'];
										$arrayHistorico['razonSocial'] = $rs_obtenerTransferirClienteHistorico[0]['razonSocial'];
										$arrayHistorico['idSegNegocio'] = $rs_obtenerTransferirClienteHistorico[0]['idSegNegocio'];
										$arrayHistorico['idSegClienteTradicional'] = $rs_obtenerTransferirClienteHistorico[0]['idSegClienteTradicional'];
										$arrayHistorico['idSegClienteModerno'] = $rs_obtenerTransferirClienteHistorico[0]['idSegClienteModerno'];
										$arrayHistorico['fecIni'] = $rs_obtenerTransferirClienteHistorico[0]['fecIni'];
										$arrayHistorico['fecFin'] = $rs_obtenerTransferirClienteHistorico[0]['fecFin'];
										$arrayHistorico['idCuenta'] = $rs_obtenerTransferirClienteHistorico[0]['idCuenta'];
										$arrayHistorico['idProyecto'] = $rs_obtenerTransferirClienteHistorico[0]['idProyecto'];
										$arrayHistorico['idFrecuencia'] = $rs_obtenerTransferirClienteHistorico[0]['idFrecuencia'];
										$arrayHistorico['idZona'] = $rs_obtenerTransferirClienteHistorico[0]['idZona'];
										$arrayHistorico['idZonaPeligrosa'] = $rs_obtenerTransferirClienteHistorico[0]['idZonaPeligrosa'];
										$arrayHistorico['flagCartera'] = $rs_obtenerTransferirClienteHistorico[0]['flagCartera'];
										$arrayHistorico['codCliente'] = $rs_obtenerTransferirClienteHistorico[0]['codCliente'];
										$arrayHistorico['cod_ubigeo'] = $rs_obtenerTransferirClienteHistorico[0]['cod_ubigeo'];
										$arrayHistorico['direccion'] = $rs_obtenerTransferirClienteHistorico[0]['direccion'];
										$arrayHistorico['referencia'] = $rs_obtenerTransferirClienteHistorico[0]['referencia'];
										$arrayHistorico['latitud'] = $rs_obtenerTransferirClienteHistorico[0]['latitud'];
										$arrayHistorico['longitud'] = $rs_obtenerTransferirClienteHistorico[0]['longitud'];

										$insertClienteHistorico = $this->model->insertar_cliente_historico($arrayHistorico);
										if ($insertClienteHistorico) {
											$rowInserted++;
											$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEl CLIENTE <strong>'.$arrayHistorico['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
											$rs_updateFlagTranferir = $this->model->update_cliente_historico_transferir($input);
										} else {
											$rowInsertedError++;
											$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> NO SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEL CLIENTE <strong>'.$arrayHistorico['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
										}
									} else {
										//NO HAY DATA DEL CLIENTE HISTÓRICO
										$html .= $this->htmlNoResultado;	
									}
								} else {
									$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR EL CLIENTE <strong>'.$arrayCabecera['nombreComercial'].'</strong>.</div>';
								}
							} else {
								//YA EXISTE UN REGISTRO CON LOS 4 DATOS DEL CLIENTE
								$idCliente = $rs_verificarExistencia[0]['idCliente'];

								//CLIENTE HISTÓRICO
								$rs_obtenerTransferirClienteHistorico = $this->model->obtener_tranferir_cliente_historico_v1($input);

								if (!empty($rs_obtenerTransferirClienteHistorico)) {
									//ARRAY HISTORICO
									$arrayHistorico=array();
									$arrayHistorico['idCliente'] = $idCliente;
									$arrayHistorico['nombreComercial'] = $rs_obtenerTransferirClienteHistorico[0]['nombreComercial'];
									$arrayHistorico['razonSocial'] = $rs_obtenerTransferirClienteHistorico[0]['razonSocial'];
									$arrayHistorico['idSegNegocio'] = $rs_obtenerTransferirClienteHistorico[0]['idSegNegocio'];
									$arrayHistorico['idSegClienteTradicional'] = $rs_obtenerTransferirClienteHistorico[0]['idSegClienteTradicional'];
									$arrayHistorico['idSegClienteModerno'] = $rs_obtenerTransferirClienteHistorico[0]['idSegClienteModerno'];
									$arrayHistorico['fecIni'] = $rs_obtenerTransferirClienteHistorico[0]['fecIni'];
									$arrayHistorico['fecFin'] = $rs_obtenerTransferirClienteHistorico[0]['fecFin'];
									$arrayHistorico['idCuenta'] = $rs_obtenerTransferirClienteHistorico[0]['idCuenta'];
									$arrayHistorico['idProyecto'] = $rs_obtenerTransferirClienteHistorico[0]['idProyecto'];
									$arrayHistorico['idFrecuencia'] = $rs_obtenerTransferirClienteHistorico[0]['idFrecuencia'];
									$arrayHistorico['idZona'] = $rs_obtenerTransferirClienteHistorico[0]['idZona'];
									$arrayHistorico['idZonaPeligrosa'] = $rs_obtenerTransferirClienteHistorico[0]['idZonaPeligrosa'];
									$arrayHistorico['flagCartera'] = $rs_obtenerTransferirClienteHistorico[0]['flagCartera'];
									$arrayHistorico['codCliente'] = $rs_obtenerTransferirClienteHistorico[0]['codCliente'];
									$arrayHistorico['cod_ubigeo'] = $rs_obtenerTransferirClienteHistorico[0]['cod_ubigeo'];
									$arrayHistorico['direccion'] = $rs_obtenerTransferirClienteHistorico[0]['direccion'];
									$arrayHistorico['referencia'] = $rs_obtenerTransferirClienteHistorico[0]['referencia'];
									$arrayHistorico['latitud'] = $rs_obtenerTransferirClienteHistorico[0]['latitud'];
									$arrayHistorico['longitud'] = $rs_obtenerTransferirClienteHistorico[0]['longitud'];

									$rs_verificarExistenciaHistorico = $this->model->obtener_verificacion_existente_historico($arrayHistorico);

									if ( empty($rs_verificarExistenciaHistorico)) {
										//EL CLIENTE HISTÓRICO NO EXISTE
										$insertClienteHistorico = $this->model->insertar_cliente_historico($arrayHistorico);
										if ($insertClienteHistorico) {
											$rowInserted++;
											$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEl CLIENTE <strong>'.$arrayHistorico['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
											$rs_updateFlagTranferir = $this->model->update_cliente_historico_transferir($input);
										} else {
											$rowInsertedError++;
											$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> NO SE LOGRÓ REGISTRAR EL <strong>CLIENTE HISTÓRICO</strong> DEL CLIENTE <strong>'.$arrayHistorico['nombreComercial'].'</strong> CORRECTAMENTE.</div>';
										}
									} else {
										//EL CLIENTE HISTÓRICO YA EXISTE
										$html .= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-store-alt"></i> EL REGISTRO DEL <strong>CLIENTE HISTÓRICO</strong> DEL CLIENTE <strong>'.$arrayHistorico['nombreComercial'].'</strong> YA EXISTE.</div>';
									}
								}
							}
						} else {
							$html .= $this->htmlNoResultado;	
						}
					}

					//MENSAJE FINAL DE SALIDA
					if ($rowInserted>0) {
						$html='<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR <strong>'.$rowInserted.' CLIENTE(S)</strong> CORRECTAMENTE.</div>';
					}
					if ($rowInsertedError>0) {
						$html='<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> HUBO INCONVENIENTES AL REGISTRAR <strong>'.$rowInsertedError.' CLIENTE(S)</strong> CORRECTAMENTE.</div>';
					}
				} else {
					$html .= $this->htmlNoResultado;	
				}
			break;
			
			default:
				$html .= $this->htmlNoResultado;
			break;
		}

		$result['result'] = 1;
		$result['msg']['title'] = 'TRANSFERIR CLIENTES AGREGADOS';
		$result['msg']['content'] = $html;
		$result['data']['tabla'] = $tabla;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function verDeBaja(){
		$result = $this->result;
		$data  = json_decode($this->input->post('data'));
		$cuenta = !empty($this->session->userdata('idCuenta'))? $this->session->userdata('idCuenta') :"";
		$proyecto = !empty($this->session->userdata('idProyecto'))? $this->session->userdata('idProyecto') :"";
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['cuenta_filtro'] = $cuenta;
		$input['proyecto_filtro'] = $proyecto;


		$rs_deBaja = $this->model->obtener_maestros_deBaja($input);

		$html='';
		if ( !empty($rs_deBaja)) {
			$array=array();
			foreach ($rs_deBaja as $klb => $row) {
				$array['listaClientes'][$row['idClienteHist']] = $row;
			}

			$result['result'] = 1;
			$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/MstBasemadreDeBaja", $array, true);
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['data']['html'] = $html;
		$result['data']['datatable'] = 'tb-maestrosBasemadreDeBaja';

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function enviarNotificacionNuevoRegistro($cantRowInserted){
		$this->aSessTrack[] = [ 'idAccion' => 10 ];

		$rs_correoSolicitudes = $this->model->obtener_correo_aprobar_solicitudes();
		array_merge($this->aSessTrack, $this->model->aSessTrack);


		$email = array();
		$email['to'] = array('franklin.juarez@visualimpact.com.pe');

		if (!empty($rs_correoSolicitudes)) {
			foreach ($rs_correoSolicitudes as $klc => $correo) {
				array_push( $email['to'] , $correo['correo'] );
			}
		}
		
		$email['cc'] = array();
		//array_push($email['cc'], 'luis.durand@visualimpact.com.pe');
		//array_push($email['cc'], 'team.seleccion@visualimpact.com.pe');
		//array_push($email['cc'], $this->usuarioEmail);
		// array_push($email['cc'], $dataContenidoCorreo['dataRequerimiento']['emailAnalista']);

		$email['asunto'] = 'VISUAL IMPACT SAC - SOLICITUDES DE REGISTRO';

		$array=array();
		$array['cantidadSolicitudes'] = $cantRowInserted;
		$email['contenido'] = $this->load->view("modulos/configuraciones/maestros/basemadre/basemadre_enviarNotificacion", $array, true);
		$this->sendEmail($email);
	}

	public function rechazarSolicitud(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tabla = $data->{'tabla'};
		$html=''; $htmlEstadoChkb=''; $htmlEstadoTransferir=''; $htmlEstadoRechazar=''; $htmlEstadoPdv=''; $htmlEditarPdv='';
		$input=array();

		switch ($tabla) {
			case 'pg_v1':
				$input['idClientePg'] = $data->{'cliente'};
				$input['idClienteHistPg'] = $data->{'clienteHistorico'};
				$input['observacionRechazo'] = $data->{'motivoRechazo'};
				$input['idSolicitudTipo'] = 3;

				$rs_updateRechazo = $this->model->update_rechazo_basemadre_pg_v1($input);
				if ( $rs_updateRechazo ) {
					$result['result'] = 1;
					$html.= $this->htmlResultado;

					$htmlEstadoChkb='<span>-</span>';
					$htmlEstadoTransferir='<span class="pdv-rechazado">RECHAZADO</span>';
					$htmlEstadoRechazar='<button class="btn btn-danger verRechazo" title="VER MOTIVO RECHAZO" data-cliente="'.$input['idClientePg'].'" data-clienteHistorico="'.$input['idClienteHistPg'].'" data-tabla="pg_v1"><i class="fas fa-eye"></i></button>';
					$htmlEstadoPdv='<span>-</span>';
					$htmlEditarPdv='<span>-</span>';
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;
			
			default:
				$html.= $this->htmlNoUpdateResultado;
				break;
		}

		$result['msg']['title'] = 'RECHAZAR SOLICITUD';
		$result['msg']['content'] = $html;

		$result['data']['tabla'] = $tabla;
		$result['data']['htmlEstadoChkb'] = $htmlEstadoChkb;
		$result['data']['htmlEstadoTransferir'] = $htmlEstadoTransferir;
		$result['data']['htmlEstadoRechazar'] = $htmlEstadoRechazar;
		$result['data']['htmlEstadoPdv'] = $htmlEstadoPdv;
		$result['data']['htmlEditarPdv'] = $htmlEditarPdv;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function verRechazo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$tablaOperacion = $data->{'tabla'};
		
		$html='';
		$input=array();
		$input['idClientePg'] = $data->{'cliente'};
		$input['idClienteHistPg'] = $data->{'clienteHistorico'};

		switch ($tablaOperacion) {
			case 'pg_v1':
				$rs_obtenerRechazo = $this->model->obtener_motivo_rechazo($input);
				if ( !empty($rs_obtenerRechazo)) {
					$array=array();
					$array['motivoRechazo'] = $rs_obtenerRechazo[0]['observacionRechazo'];

					$result['result'] = 1;
					$html .= $this->load->view("modulos/configuraciones/maestros/basemadre/verMotivoRechazo", $array, true);
				} else {
					$html.= $this->htmlNoResultado;
				}
				break;
			
			default:
				$html.= $this->htmlNoResultado;
				break;
		}

		$result['msg']['title'] = 'VER RECHAZAR';
		$result['data']['html'] = $html;
		$result['data']['tabla'] = $tablaOperacion;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function rechazarSolicitudMasiva(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$tablaOperacion = $data->{'tabla'};

		$tablaOperacion = $data->{'tabla'};
		$dataClienteHistorico = $data->{'dataClienteHistorico'};
		$motivoRechazo = $data->{'motivoRechazo'};

		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		if (!empty($dataClienteHistorico)) {
			foreach ($dataClienteHistorico as $kch => $cliente) {
				$idClientePg = ( isset($cliente->{'cliente'}) && !empty($cliente->{'cliente'}) ? $cliente->{'cliente'} : NULL );
				$idClienteHistPg = ( isset($cliente->{'clienteHistorico'}) && !empty($cliente->{'clienteHistorico'}) ? $cliente->{'clienteHistorico'} : NULL );

				$input=array();
				$input['idClientePg'] = $idClientePg;
				$input['idClienteHistPg'] = $idClienteHistPg;

				$params=array();
				$params['observacionRechazo'] = $motivoRechazo;
				$params['idSolicitudTipo'] = 3;

				switch ($tablaOperacion) {
					case 'pg_v1':
						$rs_updateRechazo = $this->model->update_cliente_historico_rechazar($input, $params);

						if ( $rs_updateRechazo) { $rowUpdated++;
						} else { $rowUpdatedError++; }
						
						break;
					
					default:
						$html.= $this->htmlNoUpdateResultado;
						break;
				}
			}

			if ( $rowUpdated> 0) {
				$result['result'] = 1;
				$html.= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE REALIZÓ EL <strong>RECHAZO DE '.$rowUpdated.'</strong> SOLICITUDES CORRECTAMENTE.</div>';
			}

			if ( $rowUpdatedError>0) $html.= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> NO SE LOGRÓ ACTUALIZAR EL <strong>RECHAZO DE '.$rowUpdatedError.'</strong> SOLICITUDES CORRECTAMENTE.</div>';
		
		} else {
			$html.= $this->htmlNoResultado;
		}

		
		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;
		$result['data']['tabla'] = $tablaOperacion;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}



	public function clienteCargaMasivaAlternativa(){
		
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);


		$idUsuario=$this->session->userdata('idUsuario');
		$rs_segmentacion = $this->model->obtener_segmentacion_cliente($idUsuario);

		$array=array();
		if (!empty($rs_segmentacion)) {
			$array['flagClienteTradicional'] = $rs_segmentacion[0]['flagClienteTradicional'];
			$array['flagClienteModerno'] = $rs_segmentacion[0]['flagClienteModerno'];
		}

		$idProyecto=$this->session->userdata('idProyecto');
		$validarProyectoAuditoria=$this->model->validar_proyecto_auditoria(array('idProyecto'=>$idProyecto));
		$mostrarCheckAuditoria=false;
		if($validarProyectoAuditoria!=null){
			if( count($validarProyectoAuditoria)>0){
				$mostrarCheckAuditoria=true;
			}
		}
		$array['mostrarCheckAuditoria']= $mostrarCheckAuditoria;
		
		$html='';
		$htmlWidth='80%';
		$data_carga=array();
		$i=0;
		$resultados=$this->model->obtener_estado_carga_alternativa();
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['fecRegistro']=$row['fecRegistro'];
			$data_carga[$i]['horaRegistro']=$row['horaRegistro'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$data_carga[$i]['noProcesados']=$row['error'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['estado']=$row['estado'];
			$i++;
		}
		$array['data_carga']= $data_carga;

		$html.= $this->load->view("modulos/configuraciones/maestros/basemadre/registrar_masivo_alternativa", $array, true);

		$result['msg']['title'] = 'GENERAR CARGA BASEMADRE';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function generar_formato_carga_masiva_alternativa_tradicional(){
		////
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		/**ESTILOS**/
		$estilo_cabecera_visita =  
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '920000')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_disponibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '558636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_visibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '001636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		$estilo_cabecera_accesibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '00ced1')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$style_gris =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'd4d0cd')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		$style_disponibles =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		/**FIN ESTILOS**/
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'NOMBRE COMERCIAL')
					->setCellValue('B1', 'RAZON SOCIAL')
					->setCellValue('C1', 'RUC')
					->setCellValue('D1', 'DNI')
					->setCellValue('E1', 'DEPARTAMENTO')
					->setCellValue('F1', 'PROVINCIA')
					->setCellValue('G1', 'DISTRITO')
					->setCellValue('H1', 'DIRECCION')
					->setCellValue('I1', 'REFERENCIA')
					->setCellValue('J1', 'LATITUD')
					->setCellValue('K1', 'LONGITUD')
					->setCellValue('L1', 'ZONA PELIGROSA')
					->setCellValue('M1', 'CODIGO CLIENTE')
					->setCellValue('N1', 'CLIENTE CARTERA')
					->setCellValue('O1', 'FECHA INICIO')
					->setCellValue('P1', 'FECHA FIN')
					->setCellValue('Q1', 'FRECUENCIA')
					->setCellValue('R1', 'ZONA')
					->setCellValue('S1', 'GRUPO CANAL')
					->setCellValue('T1', 'CANAL')
					->setCellValue('U1', 'CLIENTE TIPO')
					->setCellValue('V1', 'PLAZA')
					->setCellValue('W1', 'DISTRIBUIDORA SUCURSAL 1');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="basemadre_formato.xlsx"');
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
	public function generar_formato_carga_masiva_alternativa_moderno(){
		////
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		/**ESTILOS**/
		$estilo_cabecera_visita =  
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '920000')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_disponibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '558636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_visibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '001636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		$estilo_cabecera_accesibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '00ced1')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$style_gris =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'd4d0cd')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		$style_disponibles =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		/**FIN ESTILOS**/
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'NOMBRE COMERCIAL')
					->setCellValue('B1', 'RAZON SOCIAL')
					->setCellValue('C1', 'RUC')
					->setCellValue('D1', 'DNI')
					->setCellValue('E1', 'DEPARTAMENTO')
					->setCellValue('F1', 'PROVINCIA')
					->setCellValue('G1', 'DISTRITO')
					->setCellValue('H1', 'DIRECCION')
					->setCellValue('I1', 'REFERENCIA')
					->setCellValue('J1', 'LATITUD')
					->setCellValue('K1', 'LONGITUD')
					->setCellValue('L1', 'ZONA PELIGROSA')
					->setCellValue('M1', 'CODIGO CLIENTE')
					->setCellValue('N1', 'CLIENTE CARTERA')
					->setCellValue('O1', 'FECHA INICIO')
					->setCellValue('P1', 'FECHA FIN')
					->setCellValue('Q1', 'FRECUENCIA')
					->setCellValue('R1', 'ZONA')
					->setCellValue('S1', 'GRUPO CANAL')
					->setCellValue('T1', 'CANAL')
					->setCellValue('U1', 'CLIENTE TIPO')
					->setCellValue('V1', 'CADENA')
					->setCellValue('W1', 'BANNER');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="basemadre_formato.xlsx"');
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

	public function estado_carga_alternativa(){
		$resultados=$this->model->obtener_estado_carga_alternativa();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['noProcesados']=$row['error'];
			$data_carga[$i]['error']=$row['error'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
		
	}

	public function carga_masiva_alternativa(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		//
		$archivo = $_FILES['file']['name'];

		$tipo = $_POST['tipo'];
		$auditoria = $_POST['auditoria'];


		$datetime = date('dmYHis');
		$nombre_carpeta = 'clientes_'.$datetime;
		//
		$ruta = 'public/csv/clientes/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/clientes/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/clientes_'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/clientes_'.$datetime.'.csv';
		$to_read_files = $rutaFiles.'/';
		//
		$done = false;
		$part = 0;
		
		
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);
			
			/* while (($registro = fgetcsv ($handle))!== false) {
				$sum++;
			} */

			while ($done == false) {
				$locA = ftell($handle);
				fseek($handle, $size, SEEK_CUR);
				$tmp = fgets($handle);
				$locB = ftell($handle);
				$span = ($locB - $locA);
				fseek($handle, $locA, SEEK_SET);
				$chunk = fread($handle,$span);
				file_put_contents($to_read_files.'clientes_'.$part.'.csv',$header.$chunk);
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

		$idProyecto= $this->session->userdata('idProyecto') ;
		$idCuenta=$this->session->userdata('idCuenta');
		$carga = array();
		$carga = array(
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
			'idCuenta' => $idCuenta,
			'idProyecto' => $idProyecto,
			'tipo' => $tipo,
			'auditoria' => $auditoria
		);

		$this->db->insert("{$this->sessBDCuenta}.trade.cargaCliente",$carga);

		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga_alternativa();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL FILAS EXCEL CARGADAS</th>';
						$html.='<th>TOTAL FILAS PROCESADOS</th>';
						$html.='<th>TOTAL FILAS NO PROCESADOS</th>';
						$html.='<th>ERRORES</th>';
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
					$html.='<tr>';
						$html.='<td>'.$row['idCarga'].'</td>';
						$html.='<td>'.$row['fecRegistro'].'</td>';
						$html.='<td>'.$row['horaRegistro'].'</td>';
						$html.='<td>'.$row['totalRegistros'].'</td>';
						$html.='<td id="clientes_'.$row['idCarga'].'">'.$row['totalClientes'].'</td>';
						$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
						$html.='<td id="noprocesados_'.$row['idCarga'].'">'.$row['error'].'</td>';
						$html.='<td id="errores_'.$row['idCarga'].'">-</td>';
						$html.='<td class="text-center">';
							$porcentaje = 0;
							if( !empty($row['totalClientes']) )
							$porcentaje = round(($row['total_procesados'])/$row['totalClientes']*100,0);
							$mensaje=($row['estado']==1)?' Preparando .':' Completado ';
							$html.='<label id="estado_'.$row['idCarga'].'">'.$mensaje.'</label><br>';
							$html.='<meter id="barraprogreso_'.$row['idCarga'].'" min="0" max="100" low="0" high="0" optimum="100" value="'.$porcentaje.'" style="font-size:20px;">';
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

	public function generar_formato_errores_alternativo($id){
		////
		$rs_rutas = $this->model->obtener_clientes_no_procesado($id);
		
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
		
		if(count($rs_rutas)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'NOMBRE COMERCIAL');
			 $objWorkSheet->setCellValue('B1', 'RAZON SOCIAL');
			 $objWorkSheet->setCellValue('C1', 'DATO INGRESADO');
			 $objWorkSheet->setCellValue('D1', 'ERROR');
			 $m=2;
			 foreach($rs_rutas as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['nombreComercial']);
				  $objWorkSheet->setCellValue('B'.$m, $row['razonSocial']);
				  $objWorkSheet->setCellValue('C'.$m, $row['datoIngresado']);
				  $objWorkSheet->setCellValue('D'.$m, $row['tipoError']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("RUTAS NO PROCESADOS");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="rutas_errores_carga.xlsx"');
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



	//cliente proyecto

	public function clienteProyectoCargaMasivaAlternativa(){	
		
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);

		$html='';
		$htmlWidth='80%';
		$array=array();
		$data_carga=array();
		$i=0;
		$resultados=$this->model->obtener_estado_carga_alternativa_cliente_proyecto();
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['fecRegistro']=$row['fecRegistro'];
			$data_carga[$i]['horaRegistro']=$row['horaRegistro'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$data_carga[$i]['noProcesados']=$row['error'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['estado']=$row['estado'];
			$i++;
		}
		$array['data_carga']= $data_carga;

		$html.= $this->load->view("modulos/configuraciones/maestros/basemadre/registrar_masivo_alternativa_cliente_proyecto", $array, true);

		$result['msg']['title'] = 'ACTUALIZAR PROYECTO BASEMADRE ';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function generar_formato_carga_masiva_alternativa_cliente_proyecto(){
		////
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		/** Include PHPExcel */
		require_once '../phpExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		/**ESTILOS**/
		$estilo_cabecera_visita =  
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '920000')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_disponibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '558636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$estilo_cabecera_visibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '001636')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		$estilo_cabecera_accesibilidad = 
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '00ced1')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		
		$style_gris =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'd4d0cd')
				),
				'font'  => array(
					'color' => array('rgb' => 'ffffff'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
		$style_disponibles =
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);
			
		/**FIN ESTILOS**/
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'IDCLIENTE')
					->setCellValue('B1', 'ID PROYECTO');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="basemadre_proyecto_formato.xlsx"');
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

	public function estado_carga_alternativa_cliente_proyecto(){
		$resultados=$this->model->obtener_estado_carga_alternativa_cliente_proyecto();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['noProcesados']=$row['error'];
			$data_carga[$i]['error']=$row['error'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
		
	}

	public function carga_masiva_alternativa_cliente_proyecto(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		//
		$archivo = $_FILES['file']['name'];

		$datetime = date('dmYHis');
		$nombre_carpeta = 'clientesproyecto_'.$datetime;
		//
		$ruta = 'public/csv/clientesproyecto/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/clientesproyecto/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/clientesproyecto_'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/clientesproyecto_'.$datetime.'.csv';
		$to_read_files = $rutaFiles.'/';
		//
		$done = false;
		$part = 0;
		
		
		if (($handle = fopen($to_read, "r")) !== FALSE) {
			$header = fgets($handle);
			
			/* while (($registro = fgetcsv ($handle))!== false) {
				$sum++;
			} */

			while ($done == false) {
				$locA = ftell($handle);
				fseek($handle, $size, SEEK_CUR);
				$tmp = fgets($handle);
				$locB = ftell($handle);
				$span = ($locB - $locA);
				fseek($handle, $locA, SEEK_SET);
				$chunk = fread($handle,$span);
				file_put_contents($to_read_files.'clientesproyecto_'.$part.'.csv',$header.$chunk);
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

		$idProyecto=$this->session->userdata('idProyecto');
		$idCuenta=$this->session->userdata('idCuenta');
		$carga = array();
		$carga = array(
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
			'idCuenta' => $idCuenta,
			'idProyecto' => $idProyecto
		);

		$this->db->insert('trade.cargaClienteProyecto',$carga);

		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga_alternativa_cliente_proyecto();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL FILAS EXCEL CARGADAS</th>';
						$html.='<th>TOTAL FILAS PROCESADOS</th>';
						$html.='<th>TOTAL FILAS NO PROCESADOS</th>';
						$html.='<th>ERRORES</th>';
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
					$html.='<tr>';
						$html.='<td>'.$row['idCarga'].'</td>';
						$html.='<td>'.$row['fecRegistro'].'</td>';
						$html.='<td>'.$row['horaRegistro'].'</td>';
						$html.='<td>'.$row['totalRegistros'].'</td>';
						$html.='<td id="clientes_'.$row['idCarga'].'">'.$row['totalClientes'].'</td>';
						$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
						$html.='<td id="noprocesados_'.$row['idCarga'].'">'.$row['error'].'</td>';
						$html.='<td id="errores_'.$row['idCarga'].'">-</td>';
						$html.='<td class="text-center">';
							$porcentaje = 0;
							if( !empty($row['totalClientes']) )
							$porcentaje = round(($row['total_procesados'])/$row['totalClientes']*100,0);
							$mensaje=($row['estado']==1)?' Preparando .':' Completado ';
							$html.='<label id="estado_'.$row['idCarga'].'">'.$mensaje.'</label><br>';
							$html.='<meter id="barraprogreso_'.$row['idCarga'].'" min="0" max="100" low="0" high="0" optimum="100" value="'.$porcentaje.'" style="font-size:20px;">';
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

	public function generar_formato_errores_alternativo_cliente_proyecto($id){
		////
		$rs_rutas = $this->model->obtener_clientes_proyecto_no_procesado($id);
		
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
		
		if(count($rs_rutas)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'NOMBRE COMERCIAL');
			 $objWorkSheet->setCellValue('B1', 'RAZON SOCIAL');
			 $objWorkSheet->setCellValue('C1', 'DATO INGRESADO');
			 $objWorkSheet->setCellValue('D1', 'ERROR');
			 $m=2;
			 foreach($rs_rutas as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['nombreComercial']);
				  $objWorkSheet->setCellValue('B'.$m, $row['razonSocial']);
				  $objWorkSheet->setCellValue('C'.$m, $row['datoIngresado']);
				  $objWorkSheet->setCellValue('D'.$m, $row['tipoError']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("CLIENTES NO PROCESADOS");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="clientes_proyecto_errores_carga.xlsx"');
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

	public function generar_maestros(){
		////
		$rs_grupoCanal = $this->model->obtener_grupo_canal();
		$rs_canal = $this->model->obtener_canal();
		
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
		
		if(count($rs_grupoCanal)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'ID GRUPOCANAL');
			 $objWorkSheet->setCellValue('B1', 'NOMBRE');
			 $m=2;
			 foreach($rs_grupoCanal as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['idGrupoCanal']);
				  $objWorkSheet->setCellValue('B'.$m, $row['nombre']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("GrupoCanal");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		$i++;
		
		if(count($rs_canal)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'ID CANAL');
			 $objWorkSheet->setCellValue('B1', 'ID GRUPOCANAL');
			 $objWorkSheet->setCellValue('C1', 'NOMBRE');
			 $m=2;
			 foreach($rs_canal as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['idCanal']);
				  $objWorkSheet->setCellValue('B'.$m, $row['idGrupoCanal']);
				  $objWorkSheet->setCellValue('C'.$m, $row['nombre']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("Canal");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		$i++;

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="maestro_carga.xlsx"');
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

}
?>