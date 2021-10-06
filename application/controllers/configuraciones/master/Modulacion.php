<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Modulacion extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/master/m_modulacion','model');
	}

	var $htmlInfoResultado = '<div class="alert alert-info" role="alert"><i class="fas fa-info-circle" aria-hidden="true"></i> NO SE HA GENERADO NINGUN REGISTRO.</div>';
	var $htmlNoResultado = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
	var $htmlUpdateResultado = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE LA INFORMACIÓN CORRECTAMENTE.</div>';
	var $htmlNoUpdateResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA REALIZADO LA ACTUALZIACIÓN DE LA INFORMACIÓN CORRECTAMENTE, VERIFICAR DATO.</div>';

	var $htmlNoDeleteResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> SE DETECTARÓN INCONVENIENTES AL ELIMINAR LA INFORMACIÓN DE PERMISOS DE USUARIO, VERIFICAR PROCESO.</div>';
	var $htmlNoPermiso = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-users"></i> NO EXISTE NINGÚN PERMISO CON LA DATA MENCIONADA.</div>';
	var $htmlNoCliente = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-users"></i> NO EXISTE NINGÚN CLIENTE A ASIGNAR.</div>';
	var $htmlNoElementos = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-cubes icon-solid "></i> NO EXISTE NINGÚN ELEMENTO A ASIGNAR.</div>';

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$htmlGenerarLista=true;
		if (in_array($this->idTipoUsuario, [2,6])) {
			$htmlGenerarLista=false;
		}

		$config = array();
		$config['css']['style']=array(
			'assets/libs/dataTables-1.10.20/datatables'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/css/configuraciones/master/modulacion'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables'
			,'assets/libs/datatables/responsive.bootstrap4.min'
			,'assets/custom/js/core/datatables-defaults'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/languages/all'
			, 'assets/libs/handsontable@7.4.2/dist/moment/moment'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/js/configuraciones/master/modulacion'
			, 'assets/libs/filedownload/jquery.fileDownload'
		);
		
		$config['nav']['menu_active'] = '69';
		$config['data']['icon'] = 'fas fa-brain';
		$config['data']['title'] = 'Modulación Visibilidad';
		$config['data']['message'] = 'Gestor de Modulación';
		$config['data']['htmlGenerarLista'] = $htmlGenerarLista;
		$config['view'] = 'modulos/configuraciones/master/modulacion/index';

		$this->view($config);
	}

	public function nuevo(){
		$data = json_decode($this->input->post('data'));

		$input = array();
		$array = array();
		$html = '';
		
		$result['result'] = 1;
		$array['modulos'] = $this->model->obtener_modulos();
		$array['usuarios'] = $this->model->obtener_usuarios();
		$html = $this->load->view("modulos/configuraciones/master/permisos/nuevo_permiso", $array, true);
		
		$result['data'] = $html;

		echo json_encode($result);
	}
	
	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$tipoModulacion = $data->{'tipoModulacion'};
		
		$html='';
		$htmlDatatable=true;
		$htmlGenerarLista=true;
		$input=array();
		$array=array();

		$input['idCuenta'] = $this->sessIdCuenta;
		//$input['idProyecto'] = $this->sessIdProyecto;

		//VERIFICAMOS SI ES QUE ES SUPERVISOR/EJECUTIVO/COORDINADOR/TI
		//VALORES[2=>Supervisor, 6=>Ejecutivo]
		if (in_array($this->idTipoUsuario, [2,6])) {
			$input['idUsuario'] = $this->idUsuario;
			$htmlGenerarLista=false;
			$htmlDatatable=false;
		}	

		switch ($tipoModulacion) {
			case 'antigua':
				/*$fechas = explode('-',$data->{'fechas'});
				$input['fecIni']=$fechas[0];
				$input['fecFin']=$fechas[1];*/
				//BUSQUEDA TIPO MODULACION
				$input['tipo'] = 'antigua';

				$rs_obtenerPermiso = $this->model->obtener_master_permiso_tipoModulacion($input);
				if (!empty($rs_obtenerPermiso)) {
					$array['htmlGenerarLista'] = $htmlGenerarLista;
					$array['listaPermisos'] = $rs_obtenerPermiso;

					$html .= $this->load->view("modulos/configuraciones/master/modulacion/listaAntiguos", $array, true);
			
					$result['result'] = 1;
					if ($htmlDatatable) {
						$result['data']['datatable'] = 'tb-permisosAntiguos';
					}
				} else {
					$html.= getMensajeGestion('noRegistros');
				}
				break;

			case 'actual':
				//BUSQUEDA TIPO MODULACION
				$input['tipo'] = 'actual';

				$rs_obtenerPermiso = $this->model->obtener_master_permiso_tipoModulacion($input);
				if ($rs_obtenerPermiso) {
					$array['htmlGenerarLista'] = $htmlGenerarLista;
					$array['listaPermisos'] = $rs_obtenerPermiso;

					$html .= $this->load->view("modulos/configuraciones/master/modulacion/listaActuales", $array, true);
			
					$result['result'] = 1;
					if ($htmlDatatable) {
						$result['data']['datatable'] = 'tb-permisosActuales';
					}
				} else {
					$html.= getMensajeGestion('noRegistros');
				}
				break;

			default:
				$html.= getMensajeGestion('noRegistros');
				break;
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function verPermisoModulacion(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idUsuario = $data->{'usuario'};
		$idPermiso = $data->{'permiso'};
		$tipoLista = $data->{'lista'};

		$input=array();
		$input['idUsuario'] = $idUsuario;
		$input['idPermiso'] = $idPermiso;

		$rs_permiso = $this->model->obtener_master_permiso_tipoModulacion($input);

		$input['fecIniCarga'] = "";
		$input['fecFinCarga'] = "";
		if( !empty($rs_permiso)){
			if( is_array($rs_permiso)){
				if( count($rs_permiso)>=1 ){
					$input['fecIniCarga']=$rs_permiso[0]['fecIniCarga'];
					$input['fecFinCarga']=$rs_permiso[0]['fecFinCarga'];
				}
			}
		}
		
		$rs_clientes = $this->model->obtener_clientes_permiso($input);
		$rs_elementos = $this->model->obtener_elementos($input);
		$rs_modulacion = $this->model->obtener_modulacion($input);

		

		$html='';
		if ( empty($rs_permiso)) {
			//NO EXISTE EL PERMISO
			$html .= $this->htmlNoPermiso;
		}elseif ( empty($rs_clientes)) {
			//NO HAY CLIENTES A QUIEN ASIGNAR
			$html .= $this->htmlNoCliente;

		} elseif ( empty($rs_elementos)) {
			//NO HAY ELEMENTOS QUE ASIGNAR
			$html .= $this->htmlNoElementos;

		} elseif ( !empty($rs_clientes) && !empty($rs_elementos) ) {
			//SI HAY CLIENTES Y ELEMENTOS
			$array = array();
			//LISTA DE CLIENTES
			$array['listaClientes'] = $rs_clientes;

			//LISTA DE ELEMENTOS DE VISIBILIDAD
			foreach( $rs_elementos as $row ){
				$array['listaCategoria'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategoria'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCategoria'][$row['idCategoria']]['listaElementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
				$array['listaCategoria'][$row['idCategoria']]['listaElementos'][$row['idElementoVis']]['elemento'] = $row['elemento'];
			}

			//LISTA DE MODULACION DE ELEMENTOS
			foreach( $rs_modulacion as $row ){
				$array['listaModulacion'][$row['idCliente']]['flagListaGenerada'] = $row['flagListaGenerada'];
				$array['listaModulacion'][$row['idCliente']]['listaModuElementos'][$row['idElementoVis']]['elemento'] = $row['idElementoVis'];
				$array['listaModulacion'][$row['idCliente']]['listaModuElementos'][$row['idElementoVis']]['cantidad'] = $row['cantidad'];
			}

			//TIPO DE LISTA EN LA VIEW HTML
			switch ($tipoLista) {
				case 'actual':
					$tableListaNombre = 'tb-modulacionActual';
					break;
				case 'antigua':
					$tableListaNombre = 'tb-modulacionAntigua';
					break;		
				default:
					$tableListaNombre = 'tb-modulacion';
					break;
			}

			$array['idPermiso'] = $idPermiso;
			$array['flagEditar'] = $rs_permiso[0]['flagEditar'];
			$array['tableListaNombre'] = $tableListaNombre;

			$html .= $this->load->view("modulos/configuraciones/master/modulacion/lista", $array, true);

			$result['result'] = 1;
			$result['data']['datatable'] = $tableListaNombre;
		} else {
			$html .= $this->htmlInfoResultado;
		}

		$result['data']['html'] = $html;
		echo json_encode($result);
	}

	public function filtrarModulacion(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fecha = explode('-',$data->{'fechas'});

		$input = array();
		$input['idProyecto'] = $data->{'proyecto'};
		$input['idGrupoCanal'] = $data->{'grupoCanal'};
		$input['idCanal'] = $data->{'canal'};
		$input['idCliente'] = $data->{'idCliente'};

		$rs_clientes = $this->model->obtener_clientes($input);
		$rs_elementos = $this->model->obtener_elementos($input);
		$modulacion = $this->model->obtener_modulacion($input);

		$html = '';
		if ( empty($rs_clientes )) {
			//NO HAY CLIENTES A QUIEN ASIGNAR
			$html .= $this->htmlNoCliente;

		} elseif( empty($rs_elementos) ) {
			//NO HAY ELEMENTOS QUE ASIGNAR
			$html .= $this->htmlNoElementos;

		} elseif ( !empty($rs_clientes) && !empty($rs_elementos) ) {
			//SI HAY CLIENTES Y ELEMENTOS
			$array = array();
			foreach( $rs_elementos as $row ){
				//$array['categoria'][$row['idCategoria']]['categoria'] = $row['categoria'];
				//$array['elementos'][$row['idCategoria']][$row['idElementoVis']]['elemento'] = $row['elemento'];
				$array['listaCategoria'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategoria'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCategoria'][$row['idCategoria']]['listaElementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
				$array['listaCategoria'][$row['idCategoria']]['listaElementos'][$row['idElementoVis']]['elemento'] = $row['elemento'];
			}
			foreach( $modulacion as $row ){
				$array['listamodulacion'][$row['idCliente']][$row['idElementoVis']]['elemento'] = $row['idElementoVis'];
				$array['listamodulacion'][$row['idCliente']][$row['idElementoVis']]['cantidad'] = $row['cantidad'];
			}
			$array['listaClientes'] = $rs_clientes;
			
			$html .= $this->load->view("modulos/configuraciones/master/modulacion/lista", $array, true);
			
			$result['result'] = 1;
			$result['data']['datatable'] = 'tb-modulacion';
		} else {
			$html .= $this->htmlInfoResultado;
		}

		$result['data']['html'] = $html;
		echo json_encode($result);
	}

	public function registrarModulacionMasivo(){
		$result= $this->result;
		$data = json_decode($this->input->post('data'));

		$idUsuario = $data->{'usuario'};
		$idPermiso = $data->{'permiso'};

		$input = array();
		$input['idUsuario'] = $idUsuario;
		$input['idPermiso'] = $idPermiso;

		$array = array();
		$html = '';
		$htmlWidth = '90%';

		$rs_permiso = $this->model->obtener_master_permiso_tipoModulacion($input);
		$data_carga = $this->model->obtener_estado_carga($idPermiso);

		$input['fecIniCarga'] = "";
		$input['fecFinCarga'] = "";
		if( !empty($rs_permiso)){
			if( is_array($rs_permiso)){
				if( count($rs_permiso)>=1 ){
					$input['fecIniCarga']=$rs_permiso[0]['fecIniCarga'];
					$input['fecFinCarga']=$rs_permiso[0]['fecFinCarga'];
				}
			}
		}
		$rs_clientes = $this->model->obtener_clientes($input);
		$rs_elementos = $this->model->obtener_elementos($input);

		$input['idPermiso']=NULL;
		$input['tipo']='antigua';

		$rs_permiso_anterior = $this->model->obtener_master_permiso_tipoModulacion($input);
		$permiso_anterior = !empty($rs_permiso_anterior) ? $rs_permiso_anterior[0]: array();

		if ( empty($rs_clientes)) {
			//NO HAY CLIENTES A QUIEN ASIGNAR
			$html .= $this->htmlNoCliente;
			$htmlWidth = '40%';
		} elseif ( empty($rs_elementos)) {
			//NO HAY ELEMENTOS QUE ASIGNAR
			$html .= $this->htmlNoElementos;
			$htmlWidth = '40%';
		} elseif ( !empty($rs_clientes) && !empty($rs_elementos)) {
			//DATE PERMISO ANTERIOR
			$array['dataPermisoAnterior'] = $permiso_anterior;
			//DATA PERMISO
			$array['dataPermiso'] = $rs_permiso[0];
			$array['data_carga'] = $data_carga;
			$html.= $this->load->view("modulos/configuraciones/master/modulacion/modulacionRegistrarMasivo", $array, true);
		}

		$result['result'] = 1;
		$result['msg']['title'] = 'REGISTRAR MODULACIÓN';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}
	
	public function registrarModulacion(){
		$result= $this->result;
		$data = json_decode($this->input->post('data'));

		$idUsuario = $data->{'usuario'};
		$idPermiso = $data->{'permiso'};

		$input = array();
		$input['idUsuario'] = $idUsuario;
		$input['idPermiso'] = $idPermiso;

		$array = array();
		$html = '';
		$htmlWidth = '90%';

		$rs_permiso = $this->model->obtener_master_permiso_tipoModulacion($input);

		$input['fecIniCarga'] = "";
		$input['fecFinCarga'] = "";
		if( !empty($rs_permiso)){
			if( is_array($rs_permiso)){
				if( count($rs_permiso)>=1 ){
					$input['fecIniCarga']=$rs_permiso[0]['fecIniCarga'];
					$input['fecFinCarga']=$rs_permiso[0]['fecFinCarga'];
				}
			}
		}
		$rs_clientes = $this->model->obtener_clientes($input);
		$rs_elementos = $this->model->obtener_elementos($input);

		$input['idPermiso']=NULL;
		$input['tipo']='antigua';

		$rs_permiso_anterior = $this->model->obtener_master_permiso_tipoModulacion($input);
		$permiso_anterior = !empty($rs_permiso_anterior) ? $rs_permiso_anterior[0]: array();

		if ( empty($rs_clientes)) {
			//NO HAY CLIENTES A QUIEN ASIGNAR
			$html .= $this->htmlNoCliente;
			$htmlWidth = '40%';
		} elseif ( empty($rs_elementos)) {
			//NO HAY ELEMENTOS QUE ASIGNAR
			$html .= $this->htmlNoElementos;
			$htmlWidth = '40%';
		} elseif ( !empty($rs_clientes) && !empty($rs_elementos)) {
			//DATE PERMISO ANTERIOR
			$array['dataPermisoAnterior'] = $permiso_anterior;
			//DATA PERMISO
			$array['dataPermiso'] = $rs_permiso[0];

			//DATA LISTA DE CLIENTES
			$array['listaClientes'] = array();
			$array['listaClientesMinimos']=array();
			foreach ($rs_clientes as $klc => $row) {
				if ( !in_array($row['idCliente'], $array['listaClientes'])) {
					array_push($array['listaClientes'], $row['idCliente']);
				}
				//LISTA DE MINIMAS VALIDACIONES
				$array['listaClientesMinimos'][$row['idCliente']]['minCategoria']=$row['minCategorias'];
				$array['listaClientesMinimos'][$row['idCliente']]['minElemento'] =$row['minElementosOblig'];
			}

			//DATA LISTA DE ELEMENTOS
			$array['listaElementos'] = $rs_elementos;
			/* foreach ($rs_elementos as $kle => $row) {
				$array['listaElementos'][$row['idElementoVis']]['idCategoria'] = $row['idCategoria'];
				$array['listaElementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
				$array['listaElementos'][$row['idElementoVis']]['elemento'] = $row['elemento'];
			} */

			$html.= $this->load->view("modulos/configuraciones/master/modulacion/modulacionRegistrar", $array, true);
		}
		
		//$array['modulos'] = $this->model->obtener_modulos();
		//$array['usuarios'] = $this->model->obtener_usuarios();
		//$html = $this->load->view("modulos/configuraciones/master/modulacion/modulacionRegistrar", $array, true);
		
		$result['result'] = 1;
		$result['msg']['title'] = 'REGISTRAR MODULACIÓN';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function modulacionAnterior(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);

		$input=array();
		$input['idPermiso'] = $data['permiso'];
		$input['idCliente'] = $data['item'][3];

		$rs_elementos = $this->model->obtener_modulacion_anterior($input);

		$result['data']['elementos'] = $rs_elementos;
		echo json_encode($result); 
	}

	public function registrarElementosMasivo(){
		set_time_limit(0);
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);

		//INICIALIZAMOS LAS VARIABLES
		$idPermiso = $data['permiso'];
		$dataElementos = $data['dataElementos'];
		$dataTablaElementos = $data['dataArray'];
		//VALIDACIONES DE OPERACIÓN
		$htmlWidth='50%';
		$html=''; $htmlInserted=''; $htmlInsertedError='';
		$rowInserted=0; $rowInsertedError=0;
		$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
		//CONTADORES DE REGISTRO
		$contClientes=0; $contClientesError=0;
		$contElementos=0; $contElementosError=0;

		$input=array();
		$input['idPermiso'] = $idPermiso;

		$rs_permiso = $this->model->obtener_master_permiso_tipoModulacion($input);

		if (!empty($dataTablaElementos)) {
			//POR CADA FILA DE LA TABLA
			foreach ($dataTablaElementos as $klte => $row) {
				$idCliente = !empty($row[0]) ? $row[0]:NULL;
				$fecIni = $rs_permiso[0]['fecIniCarga'];
				$fecFin = $rs_permiso[0]['fecFinCarga'];

				$input=array();
				$input['idCliente'] = $idCliente;

				$rs_cliente = $this->model->obtener_cliente($input);
				if($rs_cliente!=null){
					if(count($rs_cliente)>0){
						if(!empty($rs_cliente[0])){
							$clienteNombre = $rs_cliente[0]['cliente'];

							$arrayModulacion=array();
							$arrayModulacion['idCliente']=$idCliente;
							$arrayModulacion['fecIni']=$fecIni;
							$arrayModulacion['fecFin']=$fecFin;
							$arrayModulacion['idPermiso']=$idPermiso;

							$rs_verificarModulacion = $this->model->verificar_master_modulacion($arrayModulacion);

							//VERIFCAMOS LA EXISTENCIA DE LA CABECERA
							if (!empty($rs_verificarModulacion)) {
								//EXISTE UN VALOR CON LA MISMA INFORMACIÓN
								$idModulacionSelected = $rs_verificarModulacion[0]['idModulacion'];
								$rowInserted++;
								$contClientes++;
								$html.='<div class="alert alert-warning fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> EL <strong>CLIENTE '.$idCliente.' - '.$clienteNombre.'</strong>, YA SE ENCUENTRA REGISTRADO CON LA DATA BRINDADA.</div>';

								//ELIMINAMOS LOS DETALLES DE LA MODULACIÓN
								$rs_eliminarModulacion = $this->model->delete_master_modulacion_detalle($idModulacionSelected);

								//VERIFICAMOS QUE LA ELIMINACIÓN SE REALIZO CORRECTAMENTE
								if ($rs_eliminarModulacion) {
									//CARGAMOS LOS NUEVOS DETALLES DE LA MODULACIÓN
									//LIMPIAMOS VARIABLES CONTADORES
									$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
									//FOREACH POR CADA ELEMENTO
									foreach ($dataElementos as $kle => $elemento) {
										//NO EXISTE UN ELEMENTO CON EL ID ==> 0
										if ($elemento!=0) {
											$idElementoVis = !empty($elemento) ? $elemento:NULL;
											$cantidad = !empty($row[$kle]) ? $row[$kle]:NULL;

											//CANTIDAD DEBE DE TENER UN VALOR
											if (!empty($cantidad)) {
												$arrayModulacionDet=array();
												$arrayModulacionDet['idModulacion']=$idModulacionSelected;
												$arrayModulacionDet['idElementoVis']=$idElementoVis;
												$arrayModulacionDet['cantidad']=$cantidad;

												$rs_registrarModDet = $this->model->insertar_master_modulacion_det($arrayModulacionDet);
												//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
												if ($rs_registrarModDet) {
													$rowInsertedDetalle++; $contElementos++;
												} else {
													$rowInsertedDetalleError++; $contElementosError++;
												}
											}
										}
									}

									//VERIFICAMOS SI TODO SE REALIZO CORRECTAMENTE O HAY ERRORES
									if ($rowInsertedDetalle>0) {
										$rowInserted++;
										$html.= '<div class="alert alert-warning fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ ACTUALIZAR LOS <strong>'.$rowInsertedDetalle.' ELEMENTOS</strong> CORRECTAMENTE.</div>';
									}
									if ($rowInsertedDetalleError>0) {
										$rowInsertedError++; 
										$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REPORTÓ <strong>'.$rowInsertedDetalleError.' ELEMENTOS</strong> REGISTRADOS INCORRECTAMENTE.</div>';
									}
								} else {
									$rowInsertedError++;
									$contElementosError++;
									$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES CON EL CLIENTE <strong>'.$idCliente.' - '.$clienteNombre.'</strong>, AL ELIMINAR SUS ANTIGUOS REGISTRO DE MODULACIÓN.</div>';
								}				
							} else {
								//NO EXISTE REGISTRO DE ESTA MODULACIÓN
								$rs_registrarMod = $this->model->insertar_master_modulacion($arrayModulacion);

								if ($rs_registrarMod) {
									//SE REGISTRO CORRECTAMENTE
									$idModulacionInserted = $this->db->insert_id();
									$rowInserted++; 
									$contClientes++;
									$html.='<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> EL <strong>CLIENTE '.$idCliente.' - '.$clienteNombre.'</strong> FUE REGISTRADO CORRECTAMENTE.</div>';

									//LIMPIAMOS VARIABLES CONTADORES
									$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
									//FOREACH POR CADA ELEMENTO
									foreach ($dataElementos as $kle => $elemento) {
										//NO EXISTE ELEMENTO CON EL ID ==> 0
										if ($elemento!=0) {
											$idElementoVis = !empty($elemento) ? $elemento:NULL;
											$cantidad = !empty($row[$kle]) ? $row[$kle]:NULL;

											//CANTIDAD DEBE DE TENER UN VALOR
											if (!empty($cantidad)) {
												$arrayModulacionDet=array();
												$arrayModulacionDet['idModulacion']=$idModulacionInserted;
												$arrayModulacionDet['idElementoVis']=$idElementoVis;
												$arrayModulacionDet['cantidad']=$cantidad;

												$rs_registrarModDet = $this->model->insertar_master_modulacion_det($arrayModulacionDet);
												//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
												if ($rs_registrarModDet) {
													$rowInsertedDetalle++; $contElementos++;
												} else {
													$rowInsertedDetalleError++; $contElementosError++;
												}
											}
										}
									}

									//VERIFICAMOS SI TODO SE REALIZO CORRECTAMENTE O HAY ERRORES
									if ($rowInsertedDetalle>0) {
										$rowInserted++;
										$html.= '<div class="alert alert-primary fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ REGISTRAR LO(S) <strong>'.$rowInsertedDetalle.' ELEMENTOS</strong> CORRECTAMENTE.</div>';
									}
									if ($rowInsertedDetalleError>0) {
										$rowInsertedError++;
										$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REPORTÓ <strong>'.$rowInsertedDetalleError.' ELEMENTOS</strong> REGISTRADOS INCORRECTAMENTE.</div>';
									}
								} else {
									$rowInsertedError++;
									$contClientesError++;
									$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL REGISTRAR EL <strong>CLIENTE '.$idCliente.' - '.$clienteNombre.'</strong> CON LA DATA BRINDADA.</div>';
								}
							}
						}
						else{
							$contClientesError++;
						}
					}
					else{
						$contClientesError++;
					}
				}
				else{
					$contClientesError++;
				}
				
			}

			//VERIFCAMOS LOS OKEYS Y ERRORES
			if ($rowInserted>0) {
				$result['result'] = 1;
				if ( $contClientes>1) {
					$html='<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR <strong>'.$contClientes.' CLIENTE(S)</strong> CORRECTAMENTE.</div>';
					if ( $contClientesError>0 ) $html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL REGISTRAR EL <strong>'.$contClientesError.' CLIENTE(S)</strong> CON LA DATA BRINDADA.</div>';
					if ( $contElementos>0 ) $html.='<div class="alert alert-primary fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ REGISTRAR LO(S) <strong>'.$contElementos.' ELEMENTO(S)</strong> CORRECTAMENTE.</div>';
					if ( $contElementosError>0 ) $html.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REPORTÓ <strong>'.$contElementosError.' ELEMENTO(S)</strong> REGISTRADOS INCORRECTAMENTE.</div>';
				}
			}
			if ($rowInsertedError>0) {
				$result['result']=2;
			}

		} else {
			$html.= getMensajeGestion('noRegistros');
		}

		$result['msg']['title'] = 'REGISTRAR MODULACIÓN DE ELEMENTOS DE VISIBILIDAD MASIVO';
		$result['msg']['content'] = $html;
		$result['data']['htmlWidth'] =$htmlWidth ;

		echo json_encode($result);
	}

	public function generarListasElementos(){
		set_time_limit(0);
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);
		$arrayPermisos = array();

		//INICIALIZAMOS VARIABLES
		$dataPermiso = $data['permiso'];
		if (is_array($dataPermiso)) {
			$arrayPermisos = $dataPermiso;
		} else {
			$arrayPermisos[0] = $dataPermiso;
		}

		//VALIDACIONES DE OPERACIÓN
		$htmlWidth='50%';
		$html=''; $htmlInserted=''; $htmlInsertedError='';
		
		$contClientes=0;
		$rowInserted=0; $rowInsertedError=0;
		$rowInsertedDetalle=0; $rowInsertedDetalleError=0;

		//POR CADA PERMISO DENTROL DEL ARRAY
		foreach ($arrayPermisos as $key => $permiso) {
			$idPermiso = $permiso;
		
			$input=array();
			$input['idPermiso']= $idPermiso;

			//OBTENEMOS LOS DATOS DEL PERMISO(FECHAS DE LISTA)
			$rs_permiso = $this->model->obtener_master_permiso_tipoModulacion($input);
			$html.='<div class="alert alert-primary" role="alert"><i class="fas fa-users"></i> <strong>Usuario: </strong> '.$rs_permiso[0]['usuario'].' </div>';

			//OBTENEMOS LA MODULACIÓN (CLIENTE Y SUS ELEMENTOS)
			$rs_modulacionCliente = $this->model->obtener_modulacion_clientes($input);

			if (!empty($rs_modulacionCliente)) {
				//POR CADA CLIENTE DE LA MODULACIÓN
				foreach ($rs_modulacionCliente as $klc => $cliente) {
					$contClientes++;
					//INICIALIZAMOS LAS VISTAS
					$htmlCliente=''; $htmlTipoElemento='';

					//OBTENEMOS EL NOMBRE DEL CLIENTE, PROYECTO Y GRUPO CANAL
					$inputCliente=array();
					$inputCliente['idCliente'] = $cliente['idCliente'];

					$rs_cliente = $this->model->obtener_cliente($inputCliente);
					if($rs_cliente!=null){
						$clienteNombre = $rs_cliente[0]['cliente'];
						$idProyecto = ( (isset($rs_cliente[0]['idProyecto']) && !empty($rs_cliente[0]['idProyecto'])) ? $rs_cliente[0]['idProyecto']:NULL );
						$idGrupoCanal = ( (isset($rs_cliente[0]['idGrupoCanal']) && !empty($rs_cliente[0]['idGrupoCanal'])) ? $rs_cliente[0]['idGrupoCanal']:NULL );
	
						$arrayCabecera=array();
						$arrayCabecera['fecIni'] = $rs_permiso[0]['fecIniLista'];
						$arrayCabecera['fecFin'] = $rs_permiso[0]['fecFinLista'];
						$arrayCabecera['idCliente'] = $cliente['idCliente'];
						$arrayCabecera['idProyecto'] = $idProyecto;
						$arrayCabecera['idGrupoCanal'] = $idGrupoCanal;
	
						//EXISTE UN CLIENTE DENTRO DE LA MODULACIÓN
						$htmlCliente.='<div class="alert alert-secondary" role="alert"><i class="fas fa-store-alt"></i> LISTAS PARA EL <strong>CLIENTE '.$cliente['idCliente'].' - '.$clienteNombre.'</strong>.</div>';
						//CARGAMOS EL ID DE MODULACIÓN AL INPUT DE BUSQUEDA
						$input['idModulacion'] = $cliente['idModulacion'];
	
						//VERIFICAMOS TIPO DE ELEMENTOS
						//TIPO 1 ==> ELEMENTOS OBLIGATORIOS
						$input['idTipoElemento'] = 1;
						$rs_obtenerElementos = $this->model->obtener_elementos_tipo($input);
						//VERIFICAMOS QUE EXISTA DATA PARA LOS ELEMENTOS OBLIGATORIOS
						//CREAMOS LA LISTA DE VISIBILIDAD TRADICIONAL
						if (!empty($rs_obtenerElementos)) {
							//EXISTE ELEMENTOS DENTRO DE LA MODULACION
							$rs_verificarListaTradicional = $this->model->verificar_lista_tradicional($arrayCabecera);
	
							if (!empty($rs_verificarListaTradicional)) {
								//EXISTE UNA LISTA CON LA CABECERA
								$idListVisibilidad = $rs_verificarListaTradicional[0]['idListVisibilidad'];
	
								//ELIMINAMOS LOS DETALLES DE LA LISTA TRADICIONAL
								$rs_eliminarListaDet = $this->model->delete_lista_tradicional_detalle($idListVisibilidad);
	
								if ($rs_eliminarListaDet) {
									$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
									//FOREACH POR CADA ELEMENTO
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										//OBTENEMOS EL ARRAY DETALLE DE LA LISTA
										$arrayDetalle=array();
										$arrayDetalle['idListVisibilidad']=$idListVisibilidad;
										$arrayDetalle['idElementoVis']=$elemento['idElementoVis'];
	
										$rs_listaTradicionalDet = $this->model->insertar_lista_tradicional_detalle($arrayDetalle);
										//VERIFICAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
										if($rs_listaTradicionalDet){ $rowInsertedDetalle++; }
										else { $rowInsertedDetalleError++; }
									}
	
									//ARMAMOS LA VISTA EN HTML
									if ($rowInsertedDetalle>0) {
										$htmlTipoElemento.='<div class="alert alert-success" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD TRADICIONAL: Se registro la lista con <strong>'.$rowInsertedDetalle.' elementos</strong> tipo obligatorios.</div>';
									}
									if ($rowInsertedDetalleError>0) {
										$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD TRADICIONAL: Hubo inconvenientes al generar la lista con <strong>'.$rowInsertedDetalleError.' elementos</strong> tipo obligatorios.</div>';
									}
								} else{
									$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES CON EL CLIENTE, AL ELIMINAR EL DETALLE DE LA LISTA DE TRADICIONAL.</div>';
								}
							} else {
								//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
								$rs_listaTradicional = $this->model->insertar_lista_tradicional($arrayCabecera);
	
								if ($rs_listaTradicional) {
									//SE REGISTRO CORRECTAMENTE
									$idListTradicionalInserted = $this->db->insert_id();
	
									//LIMPIAMOS VARIABLES CONTADORES
									$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
									//FOREACH POR CADA ELEMENTO
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										//ARMAMOS EL ARRAY DETALLE DE LA LISTA
										$arrayDetalle=array();
										$arrayDetalle['idListVisibilidad']=$idListTradicionalInserted;
										$arrayDetalle['idElementoVis'] = $elemento['idElementoVis'];
	
										$rs_listaTradicionalDet = $this->model->insertar_lista_tradicional_detalle($arrayDetalle);
										//VERIFICAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
										if($rs_listaTradicionalDet){ $rowInsertedDetalle++; }
										else { $rowInsertedDetalleError++; }
									}
	
									//ARMAMOS LA VISTA EN HTML
									if ($rowInsertedDetalle>0) {
										$htmlTipoElemento.='<div class="alert alert-success" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD TRADICIONAL: Se registro la lista con <strong>'.$rowInsertedDetalle.' elementos</strong> tipo obligatorios.</div>';
									}
									if ($rowInsertedDetalleError>0) {
										$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD TRADICIONAL: Hubo inconvenientes al generar la lista con <strong>'.$rowInsertedDetalleError.' elementos</strong> tipo obligatorios.</div>';
									}
								} else {
									$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL GUARDAR LA LISTA TRADICIONAL.</div>';
								}
							}
						} else {
							$htmlTipoElemento.='<div class="alert alert-warning" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD TRADICIONAL: No existen elementos tipo obligatorios.</div>';
						}
	
						//AUDITOR
						//CREAMOS LOS ELEMENTOS DE AUDITORIA VISIBILIDAD OBLIGATORIA
						if (!empty($rs_obtenerElementos)) {
							//EXISTE ELEMENTOS
							if( !empty($data['auditoria']) ){
								$aProyectos = $this->model->lista_proyectosAuditoria([ 'idProyecto' => $idProyecto ]);
								foreach($aProyectos as $vproyecto){
									$aCabecera = [
										'fecIni' => $rs_permiso[0]['fecIniLista'],
										'fecFin' => $rs_permiso[0]['fecFinLista'],
										'idCliente' => $cliente['idCliente'],
										'idProyecto' => $vproyecto['idProyecto'],
										'idGrupoCanal' => $idGrupoCanal
									];


									$rs_verificarListaObligatoria = $this->model->verificar_lista_obligatoria($aCabecera);
			
									if (!empty($rs_verificarListaObligatoria)) {
										//EXISTE UNA LISTA CON LA CABECERA
										$idListVisibilidadOblSelected = $rs_verificarListaObligatoria[0]['idListVisibilidadObl'];
			
										//ELIMINAMOS LOS DETALLES DE LA LISTA
										$rs_eliminarListaDet = $this->model->delete_lista_obligatoria_detallle($idListVisibilidadOblSelected);
			
										//VERIFICAMOS QUE LA ELIMINACIÓN SE REALIZO CORRECTAMENTE
										if ($rs_eliminarListaDet) {
											//CARGAMOS LOS NUEVOS DETALLES DE LAS LISTAS
											//LIMPIAMOS VARIABLES CONTADORES
											$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
											//FOREACH POR CADA ELEMENTO
											foreach ($rs_obtenerElementos as $kle => $elemento) {
												//ARMAMOS EL ARRAY DETALLE DE LA LISTA
												$arrayDetalle=array();
												$arrayDetalle['idListVisibilidadObl'] = $idListVisibilidadOblSelected;
												$arrayDetalle['idElementoVis'] = $elemento['idElementoVis'];
			
												$rs_listaObligatoriaDet = $this->model->insertar_lista_obligatoria_detalle($arrayDetalle);
												//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
												if ($rs_listaObligatoriaDet) { $rowInsertedDetalle++; }
												else { $rowInsertedDetalleError++; }
											}
			
											//ARMAMOS LA VISTA EN HTML
											if ($rowInsertedDetalle>0) {
												$htmlTipoElemento.='<div class="alert alert-success" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA OBLIGATORIO: Se registro la lista con <strong>'.$rowInsertedDetalle.' elementos</strong> tipo obligatorios.</div>';
											}
											if ($rowInsertedDetalleError>0) {
												$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA OBLIGATORIO: Hubo inconvenientes al generar la lista con <strong>'.$rowInsertedDetalleError.' elementos</strong> tipo obligatorios.</div>';
											}
										} else {
											$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES CON EL CLIENTE, AL ELIMINAR EL DETALLE DE LA LISTA DE OBLIGATORIOS.</div>';
										}
									} else {
										//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
										$rs_listaObligatoria = $this->model->insertar_lista_obligatoria($aCabecera);
			
										if ($rs_listaObligatoria) {
											//SE REGISTRO CORRECTAMENTE
											$idListVisibilidadOblInserted = $this->db->insert_id();
			
											//LIMPIAMOS VARIABLES CONTADORES
											$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
											//FOREACH POR CADA ELEMENTO
											foreach ($rs_obtenerElementos as $kle => $elemento) {
												//ARMAMOS EL ARRAY DETALLE DE LA LISTA
												$arrayDetalle=array();
												$arrayDetalle['idListVisibilidadObl'] = $idListVisibilidadOblInserted;
												$arrayDetalle['idElementoVis'] = $elemento['idElementoVis'];
			
												$rs_listaObligatoriaDet = $this->model->insertar_lista_obligatoria_detalle($arrayDetalle);
												//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
												if ($rs_listaObligatoriaDet) { $rowInsertedDetalle++; } 
												else { $rowInsertedDetalleError++; }
											}
			
											//ARMAMOS LA VISTA EN HTML
											if ($rowInsertedDetalle>0) {
												$htmlTipoElemento.='<div class="alert alert-success" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA OBLIGATORIO: Se registro la lista con <strong>'.$rowInsertedDetalle.' elementos</strong> tipo obligatorios.</div>';
											}
											if ($rowInsertedDetalleError>0) {
												$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA OBLIGATORIO: Hubo inconvenientes al generar la lista con <strong>'.$rowInsertedDetalleError.' elementos</strong> tipo obligatorios.</div>';
											}
										} else {
											$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL GUARDAR LA LISTA DE VISIBILIDAD OBLIGATORIO.</div>';
										}
									}
								}
							}
						} else {
							$htmlTipoElemento.='<div class="alert alert-warning" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA OBLIGATORIO: No existen elementos tipo obligatorios.</div>';
						}
	
						//TIPO 2 ==> ELEMENTOS INICIATIVAS
						$input['idTipoElemento'] = 2;
						$rs_obtenerElementos = $this->model->obtener_elementos_tipo($input);
	
						//VERIFICAMOS QUE EXISTA DATA PARA LOS ELEMENTOS OBLIGATORIOS
						if (!empty($rs_obtenerElementos)) {
							//EXISTE ELEMENTOS
							$rs_verificarListaIniciativa = $this->model->verificar_lista_iniciativa($arrayCabecera);
							
							if (!empty($rs_verificarListaIniciativa)) {
								//EXISTE UNA LISTA CON LA CABECERA
								$idListVisibilidadIniSelected = $rs_verificarListaIniciativa[0]['idListVisibilidadIni'];
	
								//ELIMINAMOS LOS ELEMENTOS DEL DETALLE DE LA LISTA
								$rs_eliminarListaDetElemento = $this->model->delete_lista_iniciativa_detalle_elementos($idListVisibilidadIniSelected);
	
								//ELIMINAMOS LOS DETALLES DE LA LISTA
								$rs_eliminarListaDet = $this->model->delete_lista_iniciativa_detalle($idListVisibilidadIniSelected);
	
	
								//VERIFICAMOS QUE LA ELIMINACIÓN SE REALIZO CORRECTAMENTE
								if ($rs_eliminarListaDet) {
									//CARGAMOS LOS NUEVOS DETALLES DE LAS LISTAS
									//LIMPIAMOS VARIABLES CONTADORES
									$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
									//FOREACH POR CADA ELEMENTO
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										//ARMAMOS EL ARRAY DETALLE DE LA LISTA
										$arrayDetalle=array();
										$arrayDetalle['idListVisibilidadIni'] = $idListVisibilidadIniSelected;
										$arrayDetalle['idElementoVis'] = $elemento['idElementoVis'];
	
										$rs_listaIniciativaDet = $this->model->insertar_lista_iniciativa_detalle($arrayDetalle);
										//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
										if ($rs_listaIniciativaDet) { $rowInsertedDetalle++; } 
										else { $rowInsertedDetalleError++; }
									}
	
									//ARMAMOS LA VISTA EN HTML
									if ($rowInsertedDetalle>0) {
										$htmlTipoElemento.='<div class="alert alert-success" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA INICIATIVAS: Se registro la lista con <strong>'.$rowInsertedDetalle.' elementos</strong> tipo iniciativas.</div>';
									}
									if ($rowInsertedDetalleError>0) {
										$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA INICIATIVAS: Hubo inconvenientes al generar la lista con <strong>'.$rowInsertedDetalleError.' elementos</strong> tipo iniciativas.</div>';
									}
								} else {
									$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES CON EL CLIENTE, AL ELIMINAR EL DETALLE DE LA LISTA DE INICIATIVAS.</div>';
								}
							} else {
								//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
								$rs_listaIniciativa = $this->model->insertar_lista_iniciativa($arrayCabecera);
	
								if ($rs_listaIniciativa) {
									//SE REGISTRO CORRECTAMENTE
									$idListVisibilidadIniInserted = $this->db->insert_id();
	
									//LIMPIAMOS VARIABLES CONTADORES
									$rowInsertedDetalle=0; $rowInsertedDetalleError=0;
									//FOREACH POR CADA ELEMENTO
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										//ARMAMOS EL ARRAY DETALLE DE LA LISTA
										$arrayDetalle=array();
										$arrayDetalle['idListVisibilidadIni'] = $idListVisibilidadIniInserted;
										$arrayDetalle['idElementoVis'] = $elemento['idElementoVis'];
	
										$rs_listaIniciativaDet = $this->model->insertar_lista_iniciativa_detalle($arrayDetalle);
										//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
										if ($rs_listaIniciativaDet) { $rowInsertedDetalle++; } 
										else { $rowInsertedDetalleError++; }
									}
	
									//ARMAMOS LA VISTA EN HTML
									if ($rowInsertedDetalle>0) {
										$htmlTipoElemento.='<div class="alert alert-success" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA INICIATIVAS: Se registro la lista con <strong>'.$rowInsertedDetalle.' elementos</strong> tipo iniciativas.</div>';
									}
									if ($rowInsertedDetalleError>0) {
										$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA INICIATIVAS: Hubo inconvenientes al generar la lista con <strong>'.$rowInsertedDetalleError.' elementos</strong> tipo iniciativas.</div>';
									}
								} else {
									$htmlTipoElemento.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL GUARDAR LA LISTA DE VISIBILIDAD INICIATIVA.</div>';
								}
							}
						} else {
							$htmlTipoElemento.='<div class="alert alert-warning" role="alert"><i class="fas fa-cubes icon-solid "></i> LISTA VISIBILIDAD AUDITORIA INICIATIVAS: No existen elementos tipo iniciativas.</div>';
						}
	
						//UPDATE FLAG LISTA GENERADA DE LA MODULACIÓN
						$arrayWhere=array();
						$arrayWhere['idModulacion'] = $cliente['idModulacion'];
						$arrayUpdate = array();
						$arrayUpdate['flagListaGenerada']=1;
	
						$rs_updateModulacionLista = $this->model->update_modulacion_listaGenerada($arrayWhere, $arrayUpdate);
	
						//CARGAMOS LAS VISTAS EN UNA SOLA
						$html.= $htmlCliente;
						$html.= $htmlTipoElemento;
					}
					
				}
				
				//MOSTRAR UN SOLO MENSAJE DE MANERA GLOBAL
				if ($contClientes>1) {
					$html='<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA GENERACIÓN DE LAS LISTA DE VISIBILIDAD PARA <strong>'.$contClientes.' CLIENTES</strong>.</div>';
					$htmlWidth='40%';
				} else {
					$htmlWidth = '80%';
				}
				$result['result'] = 1;
			} else {
				$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA REPORTADO <strong>CLIENTES Y ELEMENTOS CARGADOS</strong> PARA ESTA MODULACIÓN.</div>';
			}
		}

		$result['msg']['title'] = 'GENERAR LISTA DE VISIBILIDAD AUDITORIA';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function clientesModulacion(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);
		$idPermiso = $data['permiso'];

		$html='';
		$htmlWidth='40%';

		if (!empty($idPermiso)) {
			$rs_cantidadClientes = $this->model->obtener_cantidad_modulacion_clientes($idPermiso);
			if (!empty($rs_cantidadClientes)) {
				$array=array();
				$array['cantidadClientes'] = $rs_cantidadClientes[0]['numClientes'];

				$html.= $this->load->view("modulos/configuraciones/master/modulacion/clientesModulacion", $array, true);
			} else {
				$html .= getMensajeGestion('noRegistros');
			}
		} else {
			$html .= getMensajeGestion('noRegistros');
		}

		$result['msg']['title'] = 'GENERAR LISTAS';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function generar_listas(){
		$sql = "
			select idCliente,fecIni,fecFin,idModulacion from trade.master_modulacion where estado=1
		";
		$res = $this->db->query($sql)->result_array();
		if(count($res)>0){
			foreach($res as $row){
				$insert = array(
					  'idCliente'=> $row['idCliente']
					, 'fecIni'=>$row['fecIni']
					, 'fecFin'=>$row['fecFin']
				);
				$this->db->insert('trade.list_visibilidadTrad',$insert);
				$id = $this->db->insert_id();
				
				$sql ='
					insert into trade.list_visibilidadTradDet (idListVisibilidad,idElementoVis)
					select '.$id.',idElementoVis from trade.master_modulacionDet where idModulacion='.$row['idModulacion'];
				$this->db->query($sql);
				
				$update = 'update trade.master_modulacion SET estado=0 WHERE idModulacion='.$row['idModulacion'];
				$this->db->query($update);
			}
		}
		//RESULTADOS

			$mensaje='Se registro data con exito.';
	
				
		$response = array( 'msg' => array('title' => 'Confirmacion', 'content' => $mensaje), 'data' => $mensaje, 'result' => 1);

		echo json_encode($response);
	}
	
	public function registrar_modulacion(){
		$post=json_decode($this->input->post('data'),true);
		$mensaje="";
		$idUsuario = $this->session->userdata('idUsuario');
		$fechas = explode('-',$post['fechas']);
		$fecIni = $fechas[0];
		$fecFin = $fechas[1];

		$total = count($post)-1;
		$proceso=0;
		for($i=0;$i<$total;$i++){
			$total_elementos = count($post[$i]['modulacion']);
			if($total_elementos>0){
				$idCliente = $post[$i]['idCliente'];
				$validar_lista = "SELECT idModulacion FROM impactTrade_bd.trade.master_modulacion WHERE idCliente= $idCliente AND fecIni='".$fecIni."' AND fecFin = '".$fecFin."' ";
				$res_validacion = $this->db->query($validar_lista)->row_array();
				$total_listas = count($res_validacion).'<br>';
					if($total_listas==0){
						$insert = array(
							  'idCliente'	 	=> $idCliente
							, 'fecIni' 			=> $fecIni
							, 'fecFin' 			=> $fecFin
						);
						$this->db->insert('trade.master_modulacion',$insert);
						$id = $this->db->insert_id();
						for($j=0;$j<$total_elementos;$j++){
							$idElemento = $post[$i]['modulacion'][$j];
							$cantidad = $post[$i]['cantidad'][$j];
							$insert_elementos = array(
								  'idModulacion' => $id
								, 'idElementoVis' => $idElemento
								, 'cantidad' => $cantidad
							);
							$this->db->insert('trade.master_modulacionDet',$insert_elementos);
						}
					}else{
						$id =$res_validacion['idModulacion'];
						$delete = "delete from  trade.master_modulacionDet WHERE idModulacion=".$id;
						$this->db->query($delete);
						for($j=0;$j<$total_elementos;$j++){
							$idElemento = $post[$i]['modulacion'][$j];
							$cantidad = $post[$i]['cantidad'][$j];
							$insert_elementos = array(
								  'idModulacion' => $id
								, 'idElementoVis' => $idElemento
								, 'cantidad' => $cantidad
							);
							$this->db->insert('trade.master_modulacionDet',$insert_elementos);
						}
						
					} 
				
				$proceso=1;
			}
			
		}
		
		if($proceso==1){
			$mensaje='Se registro data con exito.';
		}else{
			$mensaje='No ingreso ninguna cantidad valida.';
		}
				
		$response = array( 'msg' => array('title' => 'Confirmacion', 'content' => $mensaje), 'data' => $mensaje, 'result' => 1);

		echo json_encode($response);
	}

	public function editarPermisoClienteMod(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$idPermiso = $data->{'permiso'};
		$idCliente = $data->{'cliente'};

		$input=array();
		$input['idPermiso'] = $idPermiso;
		$input['idCliente'] = $idCliente;

		$html='';
		$htmlWidth='80%';

		$rs_cliente = $this->model->obtener_cliente($input);
		$rs_elementos = $this->model->obtener_elementos();
		$rs_modulacion = $this->model->obtener_modulacion($input);

		if (!empty($rs_elementos)) {
			$array = array();
			$array['idPermiso'] = $idPermiso;
			$array['idCliente'] = $idCliente;
			$array['clienteNombre'] = $rs_cliente[0]['cliente'];

			//LISTA DE ELEMENTOS
			foreach ($rs_elementos as $kle => $row) {
				$array['listaCategoria'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategoria'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCategoria'][$row['idCategoria']]['listaElementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
				$array['listaCategoria'][$row['idCategoria']]['listaElementos'][$row['idElementoVis']]['elemento'] = $row['elemento'];
			}

			//LISTA DE MODULACION DE ELEMENTOS
			foreach( $rs_modulacion as $row ){
				$array['listaModuElementos'][$row['idElementoVis']]['elemento'] = $row['idElementoVis'];
				$array['listaModuElementos'][$row['idElementoVis']]['cantidad'] = $row['cantidad'];
			}

			$html.= $this->load->view("modulos/configuraciones/master/modulacion/modulacionEditar", $array, true);
		} else {
			//NO HAY ELEMENTOS QUE ASIGNAR
			$html .= $this->htmlNoElementos;
			$htmlWidth='40%';
		}

		$result['msg']['title'] = 'EDITAR MODULACIÓN CLIENTE';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] =$htmlWidth ;

		echo json_encode($result);
	}

	public function actualizarModulacion(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth='40%';
		$rowInserted=0; $rowInsertedError=0;

		$idPermiso = $data->{'permiso'};
		$idCliente = $data->{'cliente'};
		$dataElementos = $data->{'elemento'};
		$dataCantidadElementos = $data->{'cantidadElemento'};

		if (!is_array($dataElementos)) { $dataElementos[0] = $dataElementos; }
		if (!is_array($dataCantidadElementos)) { $dataCantidadElementos[0] = $dataCantidadElementos; }

		$input=array();
		$input['idPermiso'] = $idPermiso;

		$rs_permiso = $this->model->obtener_master_permiso_tipoModulacion($input);

		$arrayModulacion=array();
		$arrayModulacion['idCliente'] = $idCliente;
		$arrayModulacion['fecIni'] = $rs_permiso[0]['fecIniCarga'];
		$arrayModulacion['fecFin'] = $rs_permiso[0]['fecFinCarga'];
		$arrayModulacion['idPermiso'] = $idPermiso;

		$rs_verificarModulacion = $this->model->verificar_master_modulacion($arrayModulacion);
		//VERIFCAMOS LA EXISTENCIA DE LA CABECERA
		if (!empty($rs_verificarModulacion)) {
			//EXISTE UN VALOR CON LA MISMA INFORMACIÓN
			$idModulacionSelected = $rs_verificarModulacion[0]['idModulacion'];

			//ELIMINAMOS LOS DETALLES DE LA MODULACIÓN
			$rs_eliminarModulacion = $this->model->delete_master_modulacion_detalle($idModulacionSelected);

			//VERIFICAMOS QUE LA ELIMINACIÓN SE REALIZO CORRECTAMENTE
			if ($rs_eliminarModulacion) {
				//CARGAMOS LOS NUEVOS DETALLES DE LA MODULACIÓN
				//FOREACH POR CADA ELEMENTO
				foreach ($dataElementos as $kle => $elemento) {
					$idElementoVis = $elemento;
					$cantidad = $dataCantidadElementos[$kle];

					//CANTIDAD DEBE DE TENER UN VALOR
					if (!empty($cantidad)) {
						$arrayModulacionDet=array();
						$arrayModulacionDet['idModulacion']=$idModulacionSelected;
						$arrayModulacionDet['idElementoVis']=$idElementoVis;
						$arrayModulacionDet['cantidad']=$cantidad;

						$rs_registrarModDet = $this->model->insertar_master_modulacion_det($arrayModulacionDet);
						//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
						if ($rs_registrarModDet) { $rowInserted++; } 
						else { $rowInsertedError++; }
					}
				}

				//VERIFICAMOS SI TODO SE REALIZO CORRECTAMENTE O HAY ERRORES
				if ($rowInserted>0) {
					$html.= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR LOS <strong>'.$rowInserted.' ELEMENTOS</strong> CORRECTAMENTE.</div>';
				}
				if ($rowInsertedError>0) {
					$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> SE REPORTÓ <strong>'.$rowInsertedError.' ELEMENTOS</strong> REGISTRADOS INCORRECTAMENTE.</div>';
				}
			} else {
				$rowInsertedError++;
				$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES CON EL CLIENTE <strong>'.$idCliente.'</strong>, AL ELIMINAR SUS ANTIGUOS REGISTRO DE MODULACIÓN.</div>';
			}
		} else {
			//NO EXISTE REGISTRO DE ESTA MODULACIÓN
			$rs_registrarMod = $this->model->insertar_master_modulacion($arrayModulacion);

			if ($rs_registrarMod) {
				//SE REGISTRO CORRECTAMENTE
				$idModulacionInserted = $this->db->insert_id();
				$rowInserted++;

				//FOREACH POR CADA ELEMENTO
				foreach ($dataElementos as $kle => $elemento) {
					$idElementoVis = $elemento;
					$cantidad = $dataCantidadElementos[$kle];

					//CANTIDAD DEBE DE TENER UN VALOR
					if (!empty($cantidad)) {
						$arrayModulacionDet=array();
						$arrayModulacionDet['idModulacion']=$idModulacionInserted;
						$arrayModulacionDet['idElementoVis']=$idElementoVis;
						$arrayModulacionDet['cantidad']=$cantidad;

						$rs_registrarModDet = $this->model->insertar_master_modulacion_det($arrayModulacionDet);
						//VERIFCAMOS QUE LA DATA SE INSERTO CORRECTAMENTE
						if ($rs_registrarModDet) { $rowInserted++; } 
						else { $rowInsertedError++; }
					}
				}

				//VERIFICAMOS SI TODO SE REALIZO CORRECTAMENTE O HAY ERRORES
				if ($rowInserted>0) {
					$html.= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR LOS <strong>'.$rowInserted.' ELEMENTOS</strong> CORRECTAMENTE.</div>';
				}
				if ($rowInsertedError>0) {
					$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> SE REPORTÓ <strong>'.$rowInsertedError.' ELEMENTOS</strong> REGISTRADOS INCORRECTAMENTE.</div>';
				}
			} else {
				$rowInsertedError++;
				$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL REGISTRAR EL <strong>CLIENTE '.$idCliente.'</strong> CON LA DATA BRINDADA.</div>';
			}
		}

		if ($rowInserted>0) { $result['result']=1; }
		if ($rowInsertedError>0){ $result['result']==2 ;}

		$result['msg']['title'] = 'ACTUALIZAR MODULACIÓN CLIENTE';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] =$htmlWidth ;

		echo json_encode($result);
	}	

	public function cargaMasivaModulacion(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		//
		$archivo = $_FILES['file']['name'];

		$idPermiso = $_POST['idPermiso'];
		$fecIni = $_POST['fecIni'];
		$fecFin = $_POST['fecFin'];
		$datetime = date('dmYHis');
		$nombre_carpeta = 'modulacion_'.$datetime;
		
		//LIMPIAR TABLAS
		$this->model->limpiar_tablas_modulacion ($idPermiso);
		//
		
		//
		$ruta = 'public/csv/modulacion/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/modulacion/'.$nombre_carpeta.'/archivos';

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
			'idPermiso' => $idPermiso,
			'fecIni' => $fecIni,
			'fecFin' => $fecFin,
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
		);

		$this->db->insert('impactTrade_bd.trade.cargaModulacion',$carga);

		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga($idPermiso);
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>HORA FIN</th>';	 
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL CLIENTES</th>';
						$html.='<th>TOTAL CLIENTES PROCESADOS</th>';
						$html.='<th>TOTAL CLIENTES NO PROCESADOS</th>';						 
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
						$html.='<td id="horaFin_'.$row['idCarga'].'">'.$row['horaFin'].'</td>';													 
						$html.='<td>'.$row['totalRegistros'].'</td>';
						$html.='<td id="clientes_'.$row['idCarga'].'">'.$row['totalClientes'].'</td>';
						$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
						$html.='<td id="noprocesados_'.$row['idCarga'].'">'.$row['noProcesados'].'</td>';
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
		$resultados=$this->model->obtener_estado_carga_1();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['noProcesados']=$row['noProcesados'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$data_carga[$i]['error']=$row['error'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
		
	}

	public function generar_formato(){
		////
		$rs_elementos = $this->model->obtener_elementos();
		
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
					->setCellValue('A1', 'N°')
					->setCellValue('B1', 'idCliente');
						
		$cont_columnas = 'C';

		foreach($rs_elementos as $row){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($cont_columnas.'1', $row['elemento'] );
			$cont_columnas++;
		} 

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="modulacion_formato.xlsx"');
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



	public function cargaMasivaAlternativa(){
		
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);

		$html='';
		$htmlWidth='80%';
		$array=array();

		$data_carga = array();
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
			$data_carga[$i]['fecIniL']=$row['fecIniL'];
			$data_carga[$i]['fecFinL']=$row['fecFinL'];
			$i++;
		}
		$array['data_carga']= $data_carga;

		$array['listaModulos'] = $this->model->obtener_modulos();
		$array['listaUsuarios'] = $this->model->obtener_usuarios();

		$html.= $this->load->view("modulos/configuraciones/master/modulacion/registrar_masivo_alternativa", $array, true);

		$result['msg']['title'] = 'GENERAR CARGA MASIVA MODULACION';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function generar_formato_carga_masiva_alternativa(){
		////
		$rs_elementos = $this->model->obtener_elementos();
		
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
					->setCellValue('A1', 'ID CLIENTE');
		$cont_columnas = 'B';

		foreach($rs_elementos as $row){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($cont_columnas.'1', $row['elemento'] );
			$cont_columnas++;
		} 

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="modulacion_formato.xlsx"');
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
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['fecIniL']=$row['fecIniL'];
			$data_carga[$i]['fecFinL']=$row['fecFinL'];
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
		
		$fechaLista = $_POST['fechaLista'];
		$fechaIniLista= explode("-",$fechaLista)[0];
		$fechaFinLista= explode("-",$fechaLista)[1];


		$datetime = date('dmYHis');
		$nombre_carpeta = 'permisos_'.$datetime;
		//
		$ruta = 'public/csv/permisos/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/permisos/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/permisos_'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/permisos_'.$datetime.'.csv';
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
				file_put_contents($to_read_files.'permisos_'.$part.'.csv',$header.$chunk);
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

		//$idProyecto=($this->session->userdata('idProyecto')=='13')? '3': $this->session->userdata('idProyecto') ;
		$idCuenta=$this->session->userdata('idCuenta');
		$auditoria = !empty($_POST['auditoria']) ? 1 : 0;
	
		$carga = array(
			'fecIniLista' => $fechaIniLista,
			'fecFinLista' => $fechaFinLista,
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
			'idCuenta' => $idCuenta,
			'auditoria' => $auditoria
		);

		$this->db->insert('impactTrade_bd.trade.cargaPermiso',$carga);
		$idCarga=$this->db->insert_id();

		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga_alternativa();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA INICIO LISTA</th>';
						$html.='<th>FECHA FIN LISTA</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL FILAS EXCEL CARGADAS</th>';
						$html.='<th>TOTAL LISTAS PROCESADAS</th>';
						$html.='<th>TOTAL LISTAS NO PROCESADAS</th>';
						$html.='<th>ERRORES</th>';
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
					$html.='<tr>';
						$html.='<td>'.$row['idCarga'].'</td>';
						$html.='<td>'.$row['fecIniL'].'</td>';
						$html.='<td>'.$row['fecFinL'].'</td>';
						$html.='<td>'.$row['fecRegistro'].'</td>';
						$html.='<td>'.$row['horaRegistro'].'</td>';
						$html.='<td>'.$row['totalRegistros'].'</td>';
						$html.='<td id="clientes_'.$row['idCarga'].'">'.$row['totalClientes'].'</td>';
						$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
						$html.='<td id="noprocesados_'.$row['idCarga'].'">'.$row['error'].'</td>';
						$html.='<td id="errores_'.$row['idCarga'].'">-</td>';
						$html.='<td class="text-center" >';
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
					<h4 style="border: 1px solid;background: #f2f2f2;padding: 20px;width: 50%;margin: auto;text-transform: uppercase;
					}">Aun no ha realizado ninguna carga. </h4>
					</div>';	
		}
		$result['data']=$html;
		echo json_encode($result);

	}


	public function generar_formato_errores_alternativa($id){
		////
		$rs_permisos_clientes = $this->model->obtener_permisos_cliente_no_procesado($id);
		
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
		
		if(count($rs_permisos_clientes)>0){
			 $objWorkSheet = $objPHPExcel->createSheet($i);
			 $objWorkSheet->setCellValue('A1', 'ID CLIENTE');
			 $objWorkSheet->setCellValue('B1', 'DATO INGRESADO');
			 $objWorkSheet->setCellValue('C1', 'ERROR');
			 $m=2;
			 foreach($rs_permisos_clientes as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['idCliente']);
				  $objWorkSheet->setCellValue('B'.$m, $row['datoIngresado']);
				  $objWorkSheet->setCellValue('C'.$m, $row['tipoError']);
				  $m++;
			 }
			 $objWorkSheet->setTitle("CLIENTES NO PROCESADOS");
		}
		
		$objPHPExcel->setActiveSheetIndex($i);
		$i++;


		$rs_permisos_elementos = $this->model->obtener_permisos_elementos_no_procesado($id);

		if(count($rs_permisos_elementos)>0){
			$objWorkSheet = $objPHPExcel->createSheet($i);
			$objWorkSheet->setCellValue('A1', 'ID ELEMENTO');
			$objWorkSheet->setCellValue('B1', 'DATO INGRESADO');
			$objWorkSheet->setCellValue('C1', 'ERROR');
			$m=2;
			foreach($rs_permisos_elementos as $row){
				 $objWorkSheet->setCellValue('A'.$m, $row['idElemento']);
				 $objWorkSheet->setCellValue('B'.$m, $row['datoIngresado']);
				 $objWorkSheet->setCellValue('C'.$m, $row['tipoError']);
				 $m++;
			}
			$objWorkSheet->setTitle("ELMENTOS NO PROCESADOS");
	   }
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="modulacion_errores_carga.xlsx"');
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



	public function validar_carga(){
		
		$idPermiso = $_POST['idPermiso'];
		$fecIni = $_POST['fecIni'];
		$fecFin = $_POST['fecFin'];
		$datetime = date('dmYHis');
		
		$sql = "SELECT * FROM trade.cargaModulacion WHERE idPermiso= $idPermiso ";
		$res = $this->db->query($sql)->result_array();
		$total = count($res);
		$result=array();
		$result['data']= $total;
		echo json_encode($result);
	}
}
?>