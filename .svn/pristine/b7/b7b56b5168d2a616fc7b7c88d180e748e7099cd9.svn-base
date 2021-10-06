<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/master/m_permisos','model');
	}

	var $htmlInfoResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle" aria-hidden="true"></i> NO SE HA GENERADO NINGUN REGISTRO.</div>';
	var $htmlNoResultado = '<div class="alert alert-danger m-3" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
	var $htmlUpdateResultado = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE LA INFORMACIÓN CORRECTAMENTE.</div>';
	var $htmlNoUpdateResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA REALIZADO LA ACTUALZIACIÓN DE LA INFORMACIÓN CORRECTAMENTE, VERIFICAR DATO.</div>';

	var $htmlNoDeleteResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> SE DETECTARÓN INCONVENIENTES AL ELIMINAR LA INFORMACIÓN DE PERMISOS DE USUARIO, VERIFICAR PROCESO.</div>';


	public function index(){
		$config = array();

		$config['css']['style']=array(
			'assets/libs/dataTables-1.10.20/datatables'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables'
			,'assets/libs/datatables/responsive.bootstrap4.min'
			,'assets/custom/js/core/datatables-defaults'
			,'assets/custom/js/configuraciones/master/permisos'
		);
		
		$config['nav']['menu_active'] = '67';
		$config['data']['icon'] = 'fas fa-key-skeleton';
		$config['data']['title'] = 'Permisos de carga';
		$config['data']['message'] = 'Gestor de Permisos de carga - modulación.';
		$config['view'] = 'modulos/configuraciones/master/permisos/index';

		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fecha = $data->{'fecha'};
		$fechas = explode('-',$fecha);
		$html = '';

		$input = array();
		$input['fecIni']=$fechas[0];
		$input['fecFin']=$fechas[1];
		
		$rs_listaPermisos = $this->model->obtener_lista_permisos($input);
		if ( !empty($rs_listaPermisos) ) {
			$array = array();
			$array['permisos'] = $rs_listaPermisos;
			$html .= $this->load->view("modulos/configuraciones/master/permisos/lista_permisos", $array, true);
			
			$result['result'] = 1;
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		$result['data']['html'] = $html;
		$result['data']['datatable'] = 'tb-permisos';

		echo json_encode($result);
	}

	public function nuevo(){
		$data = json_decode($this->input->post('data'));

		$input = array();
		$array = array();
		$html = '';
		$htmlWidth = '60%';

		$input['idCuenta'] = $this->sessIdCuenta;
		$input['idProyecto'] = $this->sessIdProyecto;

		$array['listaModulos'] = $this->model->obtener_modulos();
		$array['listaUsuarios'] = $this->model->obtener_usuarios($input);
		$html = $this->load->view("modulos/configuraciones/master/permisos/nuevo_permiso", $array, true);
		
		$result['result'] = 1;
		$result['msg']['title'] = 'NUEVOS PERMISOS';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	} 
	
	public function editar(){
		$data = json_decode($this->input->post('data'));
		$idPermiso = $data->{'idPermiso'};
		$input = array();
		$array = array();
		$html = '';
		$htmlWidth = '40%';
		
		$result['result'] = 1;
		$array['modulos'] = $this->model->obtener_modulos();
		$array['usuarios'] = $this->model->obtener_usuarios();
		$array['permisos'] = $this->model->obtener_permisos($idPermiso);
		$permiso_modulo = $this->model->obtener_permisos_modulo($idPermiso);
		
		foreach($permiso_modulo as $row){
			$array['permiso'][$row['idModulo']] = $row['idModulo'];
		}
		
		$html = $this->load->view("modulos/configuraciones/master/permisos/editar_permiso", $array, true);
		
		$result['result'] = 1;
		$result['msg']['title'] = 'EDITAR PERMISOS';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function cambiarEstado(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$flagEditar= !empty($data->{'flagEditar'}) ? $data->{'flagEditar'}:0;
		$html=''; 
		$htmlEstado=''; $htmlHabilitarEditar=''; $htmlEditar='';

		$inputParams=array();
		$inputParams['estado'] = !empty($data->{'estado'}) ? $data->{'estado'}:0;

		$inputWhere=array();
		$inputWhere['idPermiso'] = $data->{'permiso'};

		$rs_updateEstado = $this->model->update_master_permiso($inputWhere, $inputParams);
		if ($rs_updateEstado) {
			$result['result'] = 1;
			$html.= $this->htmlUpdateResultado;

			if ( $inputParams['estado']==0) {
				$htmlEstado='<a href="javascript:;" id="aPermiso-'.$inputWhere['idPermiso'].'" class="btn btn-danger btnCambiarEstado" title="DESACTIVADO" data-permiso="'.$inputWhere['idPermiso'].'" data-estado="1" data-title-cambio="ACTIVAR" data-flag-editar="'.$flagEditar.'"><i class="fas fa-toggle-off fa-lg"></i></a>';
				$htmlHabilitarEditar='<span>-</span>';
				$htmlEditar='<span>-</span>';
			} else {
				if ($flagEditar==1) {
					$htmlHabilitarEditar='<button type="button" class="btn btn-success btnHabilitarEditar" title="HABILITADO" data-permiso="'.$inputWhere['idPermiso'].'" data-estado="0" data-title-cambio="DESABILITAR EDICIÓN"><i class="fas fa-bell fa-lg"></i></button>';
				} else {
					$htmlHabilitarEditar='<button type="button" class="btn btn-danger btnHabilitarEditar" title="DESHABILITADO" data-permiso="'.$inputWhere['idPermiso'].'" data-estado="1" data-title-cambio="HABILITAR EDICIÓN"><i class="fas fa-bell-slash fa-lg"></i></button>';
				}

				$htmlEstado='<a href="javascript:;" id="aPermiso-'.$inputWhere['idPermiso'].'" class="btn btn-primary btnCambiarEstado" title="ACTIVO" data-permiso="'.$inputWhere['idPermiso'].'" data-estado="0" data-title-cambio="DESACTIVAR" data-flag-editar="'.$flagEditar.'"><i class="fas fa-toggle-on fa-lg"></i></a>';
				$htmlEditar='<button class="btn btn-success editarPermiso" data-permiso="'.$inputWhere['idPermiso'].'" title="EDITAR PERMISO" ><i class="fas fa-edit fa-lg"></i></button>';
			}
		} else {
			$html.= $this->htmlNoUpdateResultado;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO';
		$result['msg']['content'] = $html;
		$result['data']['htmlEstado'] = $htmlEstado;
		$result['data']['htmlHabilitarEditar'] = $htmlHabilitarEditar;
		$result['data']['htmlEditar'] = $htmlEditar;

		echo json_encode($result);
	}

	public function cambiarEstadoEditar(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$html=''; 
		$htmlEstado=''; $htmlHabilitarEditar='';

		$inputParams=array();
		$inputParams['flagEditar'] = !empty($data->{'estado'}) ? $data->{'estado'}:0;

		$inputWhere=array();
		$inputWhere['idPermiso'] = $data->{'permiso'};

		$rs_updateEstado = $this->model->update_master_permiso($inputWhere, $inputParams);
		if ($rs_updateEstado) {
			$result['result'] = 1;
			$html.= $this->htmlUpdateResultado;

			if ($inputParams['flagEditar']==0) {
				$htmlHabilitarEditar='<button type="button" class="btn btn-danger btnHabilitarEditar" title="DESHABILITADO" data-permiso="'.$inputWhere['idPermiso'].'" data-estado="1" data-title-cambio="HABILITAR EDICIÓN"><i class="fas fa-bell-slash fa-lg"></i></button>';
			} else {
				$htmlHabilitarEditar='<button type="button" class="btn btn-success btnHabilitarEditar" title="HABILITADO" data-permiso="'.$inputWhere['idPermiso'].'" data-estado="0" data-title-cambio="DESABILITAR EDICIÓN"><i class="fas fa-bell fa-lg"></i></button>';
			}
		} else {
			$html.= $this->htmlNoUpdateResultado;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO EDITAR';
		$result['msg']['content'] = $html;
		$result['data']['htmlHabilitarEditar'] = $htmlHabilitarEditar;

		echo json_encode($result);
	}

	public function registrar_permiso(){
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth = '60%';

		$idPermiso = isset($data->{'idPermiso'}) && !empty($data->{'idPermiso'}) ? $data->{'idPermiso'} : NULL;
		$fechaCarga = $data->{'fechaCarga'};
		$fechaLista = $data->{'fechaLista'};
		$modulos = $data->{'modulos'};
		$idUsuario = isset($data->{'idUsuario'}) ? $data->{'idUsuario'} : array();
		$nombreUsuario = isset($data->{'usuario'}) ? $data->{'usuario'} : array();
		
		//FECHAS DE CARGA
		$fechasC = explode('-',$fechaCarga);
		$fecIniCarga = $fechasC[0];
		$fecFinCarga = $fechasC[1];
		
		//FECHAS DE LISTAS
		$fechasL = explode('-',$fechaLista);
		$fecIniLista = $fechasL[0];
		$fecFinLista = $fechasL[1];

		//LISTA USUARIOS
		$array_usuario=array();
		if(!empty($idUsuario)){
			if(!is_array($idUsuario)){
				$array_usuario[0] = $idUsuario; 
			}else{
				$array_usuario=$idUsuario;
			}
		}

		//LISTA DE MODULOS
		$array_modulo=array();
		if(!is_array($modulos)){
			$array_modulo[0] = $modulos; 
		}else{
			$array_modulo=$modulos;
		}

		//INICIALIAZAMOS LOS CONTADORES
		$rowInsertedUser=0; $rowInsertedUserError=0;
		$rowInsertedModulo=0; $rowInsertedModuloError=0;

		//VERIFICAMOS SI ES NUEVO - ACTUALIZAR
		if(empty($idPermiso)){
			//CARGAMOS EL ARRAY CON EL NOMBRE DEL USUARIO
			$array_nombreUsuario=array();
			if (!is_array($nombreUsuario)) {
				$array_nombreUsuario[0]=$nombreUsuario;
			} else {
				$array_nombreUsuario=$nombreUsuario;
			}

			//REGISTRAR NUEVO PERMISO
			if(!empty($array_usuario)){
				foreach($array_usuario as $klu => $row){
					$nombreUser = $array_nombreUsuario[$klu];
					//$validar = "SELECT * FROM trade.master_permisos WHERE idUsuario =".$row." AND fecIniCarga='".$fecIniCarga."' AND fecFinCarga='".$fecFinCarga."' ";
					//$validacion = $this->db->query($validar)->result_array();
					$inputPermiso=array();
					$inputPermiso['idUsuario'] = $row;
					$inputPermiso['fecIniCarga'] = $fecIniCarga;
					$inputPermiso['fecFinCarga'] = $fecFinCarga;
					$inputPermiso['idCuenta'] = $this->sessIdCuenta;
					$inputPermiso['idProyecto'] = $this->sessIdProyecto;

					$rs_verificarPermiso = $this->model->verificar_master_permiso($inputPermiso);
					
					if(!empty($rs_verificarPermiso)){
						/*$eliminar_duplicado_modulos = "DELETE FROM trade.master_permiso_modulo WHERE idPermiso IN(SELECT idPermiso FROM trade.master_permisos WHERE idUsuario =".$row." AND fecIniCarga='".$fecIniCarga."' AND fecFinCarga='".$fecFinCarga."' )  ";
						$eliminar_duplicado = "DELETE FROM trade.master_permisos WHERE idUsuario =".$row." AND fecIniCarga='".$fecIniCarga."' AND fecFinCarga='".$fecFinCarga."' ";
						$this->db->query($eliminar_duplicado_modulos);
						$this->db->query($eliminar_duplicado);*/

						//ELIMINAMOS LOS DETALLES
						$rs_eliminar_duplicado_modulos = $this->model->delete_duplicado_modulos($inputPermiso);
						
						if ($rs_eliminar_duplicado_modulos) {
							//ELIMINAMOS LA CABECERA
							$rs_eliminar_duplicado = $this->model->delete_duplicado_permisos($inputPermiso);
							if (!$rs_eliminar_duplicado) {
								$html.= $this->htmlNoDeleteResultado;
							}
						} else {
							$html .= $this->htmlNoDeleteResultado;
						}
					}
					
					//INSERTAMOS EL PERMISO
					$insert_permiso = array();
					$insert_permiso['fecIniCarga']= $fecIniCarga;
					$insert_permiso['fecFinCarga']= $fecFinCarga;
					$insert_permiso['fecIniLista']= $fecIniLista;
					$insert_permiso['fecFinLista']= $fecFinLista;
					$insert_permiso['idCuenta'] = $this->sessIdCuenta;
					$insert_permiso['idProyecto'] = $this->sessIdProyecto;
					$insert_permiso['idUsuario']= $row;

					$rs_insertarPermiso = $this->model->insertar_master_permiso($insert_permiso);

					if ( $rs_insertarPermiso) {
						$idPermisoInserted = $this->db->insert_id();
						$rowInsertedUser++;
						$rowInsertedModulo=0; $rowInsertedModuloError=0;

						//FOREACH PARA CADA MÓDULO
						foreach ($array_modulo as $klm => $modulo) {
							$inputModulo=array();
							$inputModulo['idPermiso']=$idPermisoInserted;
							$inputModulo['idModulo']=$modulo;

							//VERIFICAMOS LA EXISTENCIA
							$rs_verificarPermisoModulo = $this->model->verificar_master_permiso_modulo($inputModulo);
							if (!empty($rs_verificarPermisoModulo)) {
								//ELIMINAMOS EL REGISTRO SI ES QUE EXISTE
								//ESTOA HACEMOS POR QUE EL ANALISTA PUEDE ENVIAR EL MISMO USUARIO VARIAS VECES
								//SE DEBE DE IMPLEMENTAR UN MÉTODO QUE PERMITA SOLO REGISTRAR UN USUARIO EN LA VISTA
								$rs_eliminarPermisoModulo = $this->model->delete_permiso_modulo($inputModulo);
							}

							//INSERTAMOS NUEVO REGISTRO
							$rs_insertarPermisoModulo = $this->model->insertar_permiso_modulo($inputModulo);
							if ($rs_insertarPermisoModulo) { $rowInsertedModulo++; } 
							else { $rowInsertedModuloError++; }
						}

						//GENERAMOS LA VISTA EN HTML
						if ($rowInsertedModulo>0) {
							$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR <strong>'.$rowInsertedModulo.' MODULOS</strong>, PARA EL USUARIO <strong>'.$nombreUser.'</strong> CORRECTAMENTE.</div>';
						}
						if ($rowInsertedModuloError>0) {
							$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> HUBO INCONVENIENTES AL REGISTRAR <strong>'.$rowInsertedModuloError.' MODULOS</strong>, PARA EL USUARIO <strong>'.$nombreUser.'</strong>.</div>';
						}
					} else {
						$rowInsertedUserError++;
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL REGISTRAR EL PERMISO CON LAS FECHAS MENCIONADAS, PARA EL USUARIO <strong>'.$nombreUser.'</strong>.</div>';
					}
				}

				//VERIFICAMOS SI ES QUE EXISTE ALGÚN ERROR
				if ($rowInsertedUserError>0) { $result['result']=2; }
			}else{
				$html = 'SELECCIONE UN USUARIO.';
			}
		}else{
			//NOMBRE DEL USUARIO
			$nombreUser = $nombreUsuario;

			//ACTUALIZAMOS EL PERMISO - MODULO
			$arrayWhere=array();
			$arrayWhere['idPermiso'] = $idPermiso;

			$arrayUpdate = array();
			$arrayUpdate['fecIniCarga'] = $fecIniCarga;
			$arrayUpdate['fecFinCarga'] = $fecFinCarga;
			$arrayUpdate['fecIniLista'] = $fecIniLista;
			$arrayUpdate['fecFinLista'] = $fecFinLista;

			//ACTUALIZAMOS LA CABECERA DE PERMISOS
			$rs_actualizarPermiso = $this->model->update_master_permiso($arrayWhere,$arrayUpdate);

			if ($rs_actualizarPermiso) {
				//ELIMINAMOS LOS REGISTROS DE PERMISOS MODULOS - DETALLE
				$rs_eliminarPermisoModulo = $this->model->delete_permiso_modulo_total($arrayWhere);

				if ($rs_eliminarPermisoModulo) {
					//ELIMINACIÓN CORRECTA
					foreach ($array_modulo as $klm => $modulo) {
						$inputModulo=array();
						$inputModulo['idPermiso']=$idPermiso;
						$inputModulo['idModulo']=$modulo;

						//VERIFICAMOS LA EXISTENCIA
						$rs_verificarPermisoModulo = $this->model->verificar_master_permiso_modulo($inputModulo);
						if (!empty($rs_verificarPermisoModulo)) {
							//ELIMINAMOS EL REGISTRO SI ES QUE EXISTE
							//ESTO HACEMOS POR QUE EL ANALISTA PUEDE ENVIAR EL MISMO USUARIO VARIAS VECES
							//SE DEBE DE IMPLEMENTAR UN MÉTODO QUE PERMITA SOLO REGISTRAR UN USUARIO EN LA VISTA
							$rs_eliminarPermisoModulo = $this->model->delete_permiso_modulo($inputModulo);
						}

						//INSERTAMOS NUEVO REGISTRO
						$rs_insertarPermisoModulo = $this->model->insertar_permiso_modulo($inputModulo);
						if ($rs_insertarPermisoModulo) { $rowInsertedModulo++; } 
						else { $rowInsertedModuloError++; }

						//ACTUALISAMOS LA TABLA trade.master_modulacion
						$rs_updateFechasCarga = $this->model->update_fechas_carga_modulacion($arrayWhere, $arrayUpdate);
					}

					//ARMAMOS EL HTML
					if ($rowInsertedModulo>0) {
						$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ ACTUALIZAR LOS DATOS DEL USUARIO <strong>'.$nombreUser.'</strong> CORRECTAMENTE.</div>';
					}
					if ($rowInsertedModuloError>0) {
						$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-store-alt"></i> HUBO INCONVENIENTES AL ACTUALIZAR LOS DATOS DEL USUARIO <strong>'.$nombreUser.'</strong> CORRECTAMENTE.</div>';
					}
				} else {
					$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL ELIMINAR EL PERMISO - MODULO DEL USUARIO.</div>';
				}
			} else {
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> HUBO INCONVENIENTES AL ACTUALIZAR EL PERMISO CON LAS FECHAS MENCIONADAS.</div>';
			}		
		}
		
		//RESULTADOS
		$result['result'] = 1;
		$result['msg']['title'] = 'PERMISOS DE USUARIO';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}


	
	
}
?>