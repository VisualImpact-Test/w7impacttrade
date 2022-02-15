<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rutas extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_rutas','model');
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active']='2';
		$config['css']['style']=array(
		 'assets/custom/css/rutas'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min'
			,'assets/custom/js/core/datatables-defaults'
			,'assets/custom/js/rutas'
		);

		$config['data']['icon'] = 'fas fa-route';
		$config['data']['title'] = 'Rutas';
		$config['data']['message'] = 'Lista de Rutas';
		$config['view'] = 'modulos/rutas/index';

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

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		
		/*====Filtrado=====*/
		$input['grupo_filtro'] = $data->{'grupo_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['subcanal'] = $data->{'subcanal_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		$input['plaza_filtro'] = !empty($data->{'plaza_filtro'}) ?$data->{'plaza_filtro'} : '';
		$input['distribuidora_filtro'] = !empty($data->{'distribuidora_filtro'}) ? $data->{'distribuidora_filtro'} : '';
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ?$data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = !empty($data->{'zona_filtro'}) ?$data->{'zona_filtro'} : '';
		$input['cadena_filtro'] = !empty($data->{'cadena_filtro'}) ?$data->{'cadena_filtro'} : '';
		$input['banner_filtro'] = !empty($data->{'banner_filtro'}) ?$data->{'banner_filtro'} : '';

		$input['frecuencia_filtro'] = $data->{'frecuencia_filtro'} ;
		$input['tienda_perfecta'] = !empty($data->{'tienda_perfecta'})? $data->{'tienda_perfecta'}  : '' ;
		$input['gps'] = !empty($data->{'gps'})? $data->{'gps'}  : '' ;
		$input['tienda_perfecta'] = !empty($data->{'tienda_perfecta'})? $data->{'tienda_perfecta'}  : '' ;
		$input['inc'] = !empty($data->{'inc'})? true : false ;
		$input['foto'] = !empty($data->{'foto'})? true : false ;
		$input['inc_desactivado'] = !empty($data->{'inc_desactivado'})? true : false ;
		$input['obs'] = !empty($data->{'obs'})? true : false ;

		if(empty($data->{'chk-usuario-inactivo'}) || empty($data->{'chk-usuario-activo'}) ){
			$input['estadoUsuario'] = empty($data->{'chk-usuario-activo'}) ? 2 : 1;
		}
		if(empty($data->{'chk-usuario-inactivo'}) && empty($data->{'chk-usuario-activo'}) ){
			$input['estadoUsuario'] = 3;
		}

		$input['departamento_filtro'] = !empty($data->{'departamento_filtro'}) ? $data->{'departamento_filtro'} : '' ;
		$input['provincia_filtro'] = !empty($data->{'provincia_filtro'}) ? $data->{'provincia_filtro'} : '' ;
		$input['distrito_filtro'] = !empty($data->{'distrito_filtro'}) ? $data->{'distrito_filtro'} : '' ;

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		if ( !empty($rs_visitas) ) {
			$result['result'] = 1;
			$array = array();

			switch ( $data->{'tipoFormato'}) {
				case 1:
					$rs_permisos_modulos = $this->model->obtener_permisos_modulos($input);
					$array['permisos_modulos_cuenta'] = $this->model->obtener_permisos_modulos_cuenta($input);
					
					foreach($rs_permisos_modulos as $row){
						$array['permisos_modulos'][$row['idTipoUsuario']][$row['idModuloGrupo']] = $row;
					}
					

					$array['visitas'] = $rs_visitas;
					$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupo_filtro']]);
					$usuariosSegmentacion = permisos_usuarios($segmentacion['tipoSegmentacion'],$input);

					$array['segmentacion'] = $segmentacion;

					$new_data = [];
					$i = 1;

					$disabledTH['Encuestas'] = 'tdDisabledRutacuenta';
					$disabledTH['CheckProducto'] = 'tdDisabledRutacuenta';
					$disabledTH['Precios'] = 'tdDisabledRutacuenta';
					$disabledTH['Promociones'] = 'tdDisabledRutacuenta';
					$disabledTH['Fotos'] = 'tdDisabledRutacuenta';
					$disabledTH['Inventario'] = 'tdDisabledRutacuenta';
					$disabledTH['Visibilidad'] = 'tdDisabledRutacuenta';
					$disabledTH['MantenimientoCliente'] = 'tdDisabledRutacuenta';
					$disabledTH['Iniciativas'] = 'tdDisabledRutacuenta';
					$disabledTH['InteligenciaCompetitiva'] = 'tdDisabledRutacuenta';
					$disabledTH['OrdenTrabajo'] = 'tdDisabledRutacuenta';
					$disabledTH['VisibilidadAuditoria'] = 'tdDisabledRutacuenta';
					$disabledTH['Premiacion'] = 'tdDisabledRutacuenta';
					$disabledTH['Surtido'] = 'tdDisabledRutacuenta';
					$disabledTH['Observacion'] = 'tdDisabledRutacuenta';
					$disabledTH['Tareas'] = 'tdDisabledRutacuenta';
					$disabledTH['EvidenciaFotografica'] = 'tdDisabledRutacuenta';
					$disabledTH['OrdenAuditoria'] = 'tdDisabledRutacuenta';
					$disabledTH['Modulacion'] = 'tdDisabledRutacuenta';

					
					foreach ($array['permisos_modulos_cuenta'] as $key => $row) {
						$disabledTH[preg_replace('/\s+/', '', $row['nombre'])] = '';
					}

					$array['disabledTH'] = $disabledTH;


					$permisos_modulos = $array['permisos_modulos'];

					$arrayTipoUsuarioData=array();

					foreach ($rs_visitas as $kr => $row) {
						$segmentacionUsuarios = segmentacion_usuarios($usuariosSegmentacion, $row);
						$arrayTipoUsuarioData[$row['idTipoUsuario']]=$row['idTipoUsuario'];
						$latiIni = $row['lati_ini'];
						$longIni = $row['long_ini'];
						$latitud = $row['latitud'];
						$longitud = $row['longitud'];
						$gpsIni = ((empty($latiIni) || $latiIni == 0 || empty($longIni) || $longIni == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latiIni . '" data-longitud="' . $longIni . '" data-latitud-cliente="' . $latitud . '" data-longitud-cliente="' . $longitud . '" data-type="ini" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
						/* ---- */
						$latiFin = $row['lati_fin'];
						$longFin = $row['long_fin'];
						$latitud = $row['latitud'];
						$longitud = $row['longitud'];
						$gpsFin = ((empty($latiFin) || $latiFin == 0 || empty($longFin) || $longFin == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latiFin . '" data-longitud="' . $longFin . '" data-latitud-cliente="' . $latitud . '" data-longitud-cliente="' . $longitud . '" data-type="fin" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
						
						$incidencia = !empty($row['indicencia_nombre']) ? (!empty($row['incidencia_foto']) ? '<a href="javascript:;" data-fotoUrl="' . $row['incidencia_foto'] . '" data-hora ="' . $row['incidencia_hora'] . '" data-html="' . $row['incidencia_nombre'] . '" class="lk-incidencia-foto"  data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-camera" ></i><br />' : '') . $row['incidencia_nombre'] : '<center>-</center>';

						$condicion = $row['condicion'];
						$condicion_ = '';
						$condicion_f = '';

						$cesado = !empty($row['cesado']) ? "text-danger" : "" ;

						if ($condicion == 0) {
							$condicion_ = 'SV <span class="color-F" ><i class="fa fa-circle" ></i></span>';
							$condicion_f = 'SV';
						} elseif ($condicion == 1) {
							$condicion_ = 'NE <span class="color-N" ><i class="fa fa-circle" ></i></span>';
							$condicion_f = 'NE';
						} elseif ($condicion == 2) {
							$condicion_ = 'IN <span class="color-I" ><i class="fa fa-circle" ></i></span>';
							$condicion_f = 'IN';
						} elseif ($condicion == 3) {
							$condicion_ = 'EF <span class="color-C" ><i class="fa fa-circle" ></i></span>';
							$condicion_f = 'EF';
						}

						$new_data[$kr] = [
							//Columnas
							$i++, 
							!empty($row['fecha']) ? "<p class='text-center a'>{$row['fecha']}</p>" : '-',
							!empty($segmentacionUsuarios) ? "<p class='text-center a'>{$segmentacionUsuarios['supervisor']}</p>" : '-',
							!empty($row['tipoUsuario']) ? "<p class='text-left'>{$row['tipoUsuario']}</p>" : '-', 
							!empty($row['cod_empleado']) ? "<p class='text-center'>{$row['cod_empleado']}</p>" : '-', 
							!empty($row['cod_usuario']) ? "<p class='text-center'>{$row['cod_usuario']}</p>" : '-', 
							!empty($row['cesado']) ? "<h4 class='text-center'><span class=' badge badge-danger'>Cesado</span></h4>" : "<h4 class='text-center'><span class='badge badge-primary'>Activo</span></h4>", 
							!empty($row['nombreUsuario']) ? "<p class='text-left {$cesado}'> {$row['nombreUsuario']} </p>" : '-', 
							!empty($row['grupoCanal']) ? "<p class='text-left'>{$row['grupoCanal']}</p>" : '-', 
							!empty($row['canal']) ? "<p class='text-left'>{$row['canal']}</p>" : '-', 
							!empty($row['subCanal']) ? "<p class='text-left'>{$row['subCanal']}</p>" : '-',
						];
						foreach ($segmentacion['headers'] as $k => $v) { 
							 array_push($new_data[$kr],
							 	!empty($row[($v['columna'])]) ? "<p class='text-left'>{$row[($v['columna'])]}</p>" : '-'
							 );
						} 
						array_push($new_data[$kr],
						!empty($row['cod_visual']) ? "<p class='text-center'>{$row['cod_visual']}</p>" : '-', 
						!empty($row['codCliente']) ? "<p class='text-center'>{$row['codCliente']}</p>" : '-', 
						!empty($row['codDist']) ? "<p class='text-center'>{$row['codDist']}</p>" : '-', 
						!empty($row['ciudad']) ? "<p class='text-left'>{$row['ciudad']}</p>" : '-', 
						!empty($row['provincia']) ? "<p class='text-left'>{$row['provincia']}</p>" : '-', 
						!empty($row['distrito']) ? "<p class='text-left'>{$row['distrito']}</p>" : '-', 
						!empty($row['razonSocial']) ? "<p class='text-left'>{$row['razonSocial']}</p>" : '-', 
						!empty($row['frecuencia']) ? "<p class='text-center'>{$row['frecuencia']}</p>" : '-',
						!empty($row['hora_ini']) ? $gpsIni . $row['hora_ini'] : '-',
						!empty($latiIni) ? $latiIni : '-',
						!empty($longIni) ? $longIni : '-',
						!empty($row['hora_fin']) ? $gpsFin . $row['hora_fin'] : '-',
						!empty($latiFin) ? $latiFin : '-',
						!empty($longFin) ? $longFin : '-',
						!empty($row['minutos']) ? $row['minutos'] : '-',
						!empty($row['incidencia_hora']) ? "<p class='text-center' >{$row['incidencia_hora']} </p>" : '-',
						$incidencia,
						"<p class='text-center {$condicion_f}'>{$condicion_}</p>"
						);
						//--------Encuesta
							$encuesta = $row['encuesta'];
							if (!empty($encuesta)) {
								$encuesta = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="encuesta" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="ENCUESTAS" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][1])) {
								$disabled = 'tdDisabledRuta';
							} 
							
							if(empty($encuesta)){
								$encuesta = "<p class='text-center {$disabledTH['Encuestas']} {$disabled}'>".'-'."</p>" ;
							}
							array_push($new_data[$kr],
								$encuesta  
							);
						
						//--------Check Producto
							$echeck_Producto = $row['productos'];
							if (!empty($echeck_Producto)) {
								$echeck_Producto = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="check_Producto" data-title="CHECK PRODUCTOS" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][3])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($echeck_Producto)){
								$echeck_Producto = "<p class='text-center {$disabledTH['CheckProducto']} {$disabled}'>".'-'."</p>" ;
							} 
							array_push($new_data[$kr],
								$echeck_Producto
							);


						//--------Precios
							$mod = $row['precios'];
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="precios"  data-title="PRECIOS" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][10])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Precios']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);


						//--------Promociones
							$mod = $row['promociones'];
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="promociones"  data-title="PROMOCIONES" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][7])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Promociones']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							); 


						//--------Fotos
							$fotos = $row['fotos'];
							$fotosTotales=$row['fotosOtrosModulos'];
							
							if (!empty($fotos) || !empty($fotosTotales) ) {
								if(empty($fotos)){
									$fotos="0";
								}
								if(empty($fotosTotales)){
									$fotosTotales="0";
								}
								$fotos = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-ruta-foto text-center" data-visita="' . $row['idVisita'] . '" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" ><i class="fa fa-camera"></i> ' . $fotos . ' | '. $fotosTotales .' </a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][9])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($fotos) && empty($fotosTotales)){
								$fotos = "<p class='text-center {$disabledTH['Fotos']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$fotos
							);  
						// NEW FORMATOS



						//--------Inventanrio
							$mod = isset($row['inventario']) ? $row['inventario'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="inventario" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="INVENTARIO" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][11])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Inventario']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  


						//--------Visibilidad
							$mod = isset($row['visibilidad']) ? $row['visibilidad'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="visibilidad" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="VISIBILIDAD" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][5])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Visibilidad']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  



						//--------Mantenimiento Cliente
							$mod = isset($row['mantenimientoCliente']) ? $row['mantenimientoCliente'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="mantenimientoCliente" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="MANTENIMIENTO CLIENTE" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][14])) {
								$disabled = 'tdDisabledRuta';
							} 
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['MantenimientoCliente']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  



						//--------Iniciativas
							$mod = isset($row['iniciativas']) ? $row['iniciativas'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="iniciativas" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="INICIATIVAS" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][12])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Iniciativas']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  


						//--------inteligenciaCompetitiva
							$mod = isset($row['inteligenciaCompetitiva']) ? $row['inteligenciaCompetitiva'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="inteligenciaCompetitiva" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="INTELIGENCIA COMPETITIVA" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][13])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['InteligenciaCompetitiva']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  


						//--------Orden Trabajo
							$mod = isset($row['ordenTrabajo']) ? $row['ordenTrabajo'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="ordenTrabajo" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="ORDEN TRABAJO" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][22])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['OrdenTrabajo']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							); 



						//--------Visibilidad Auditoria
							$mod = isset($row['visibilidadAuditoria']) ? $row['visibilidadAuditoria'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="visibilidadAuditoria" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="VISIBILIDAD AUDITORÍA" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][17])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['VisibilidadAuditoria']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  



						//--------Premio
							$mod = isset($row['premio']) ? $row['premio'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="premiacion" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="PREMIACION" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][24])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Premiacion']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);



						//--------Surtido
							$mod = isset($row['surtido']) ? $row['surtido'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="surtido" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="SURTIDO" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][23])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Surtido']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);  



						//--------Observacion
							$mod = isset($row['observacion']) ? $row['observacion'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="observacion" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="OBSERVACION" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][20])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Observacion']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);

						
						//--------Tareas
							$mod = isset($row['tarea']) ? $row['tarea'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="tarea" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="TAREA" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][25])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Tareas']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);

						
						//--------Evidencia Fotografica
							$mod = isset($row['evidenciaFotografica']) ? $row['evidenciaFotografica'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="evidenciaFotografica" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="EVIDENCIA FOTOGRAFICA" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][26])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['EvidenciaFotografica']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							);


						//--------Orden Auditoria
							$mod = isset($row['ordenAuditoria']) ? $row['ordenAuditoria'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="ordenAuditoria" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="ORDEN AUDITORIA" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][15])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['OrdenAuditoria']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							); 


						//--------Modulacion
							$mod = isset($row['modulacion']) ? $row['modulacion'] : '';
							if (!empty($mod)) {
								$mod = '<custom data-clases=" text-center"></custom><a href="javascript:;" class="lk-detalle" data-modulo="modulacion" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '" data-title="MODULACION" data-visita="' . $row['idVisita'] . '" >SI <i class="fa fa-file-text"></i></a>';
							}
							$disabled = '';
							if (!isset($permisos_modulos[$row['idTipoUsuario']][16])) {
								$disabled = 'tdDisabledRuta';
							}
							if(empty($mod)){
								$mod = "<p class='text-center {$disabledTH['Modulacion']} {$disabled}'>".'-'."</p>" ;
							}  
							array_push($new_data[$kr],
								$mod
							); 

					}
					
					//columnas segun la tipoUsuario a mostrar
					$arrayColumnasVisibles=array();
					if($array['permisos_modulos']!=null){
						foreach($arrayTipoUsuarioData as $rowTipoUsuario){

							if(!empty($array['permisos_modulos'][$rowTipoUsuario])  && $array['permisos_modulos'][$rowTipoUsuario]!=null){
								if(count($array['permisos_modulos'][$rowTipoUsuario])>0){
									foreach($array['permisos_modulos'][$rowTipoUsuario] as $rowModulo){
										$arrayColumnasVisibles[$rowModulo['idModuloGrupo']]=$rowModulo['idModuloGrupo'];
									}
								}
							}
						}
					}
					$array['arrayColumnasVisibles'] = $arrayColumnasVisibles;

					$html .= $this->load->view("modulos/rutas/rutasDetalle", $array, true);

					$result['data']['data'] = $new_data;
					$result['data']['configTable'] =  [
						'data' => $new_data, 
					];
					$result['data']['datatable'] = 'tb-rutasDetalle';
					$result['data']['html'] = $html;
					break;
				case 2:

					$array['contRsVisitas'] = count($rs_visitas);
					foreach ($rs_visitas as $kv => $row) {
						//VISITAS
						if ( $row['condicion']==0) {
							$array['universoVisitas']['valueSV'] = isset($array['universoVisitas']['valueSV']) ? $array['universoVisitas']['valueSV'] + 1 : 1;
						} elseif ( $row['condicion']==1 ) {
							$array['universoVisitas']['valueNE'] = isset($array['universoVisitas']['valueNE']) ? $array['universoVisitas']['valueNE'] + 1 : 1;
						} elseif ( $row['condicion']==2 ) {
							$array['universoVisitas']['valueIN'] = isset($array['universoVisitas']['valueIN']) ? $array['universoVisitas']['valueIN'] + 1 : 1;
						} elseif ( $row['condicion']==3 ) {
							$array['universoVisitas']['valueEF'] = isset($array['universoVisitas']['valueEF']) ? $array['universoVisitas']['valueEF'] + 1 : 1;
						}

						//VISITAS - CANALES
						$array['canales'][$row['idCanal']]['nombre'] = $row['canal'];
						if ( $row['condicion']==0) {
							$array['canales'][$row['idCanal']]['valueSV'] = isset($array['canales'][$row['idCanal']]['valueSV']) ? $array['canales'][$row['idCanal']]['valueSV'] + 1 : 1;
						} elseif ( $row['condicion']==1 ) {
							$array['canales'][$row['idCanal']]['valueNE'] = isset($array['canales'][$row['idCanal']]['valueNE']) ? $array['canales'][$row['idCanal']]['valueNE'] + 1 : 1;
						} elseif ( $row['condicion']==2 ) {
							$array['canales'][$row['idCanal']]['valueIN'] = isset($array['canales'][$row['idCanal']]['valueIN']) ? $array['canales'][$row['idCanal']]['valueIN'] + 1 : 1;
						} elseif ( $row['condicion']==3 ) {
							$array['canales'][$row['idCanal']]['valueEF'] = isset($array['canales'][$row['idCanal']]['valueEF']) ? $array['canales'][$row['idCanal']]['valueEF'] + 1 : 1;
						}

						//VISITAS REGIONES
						$array['regiones'][$row['cod_departamento']]['cod_departamento'] = $row['cod_departamento'];
						$array['regiones'][$row['cod_departamento']]['departamento'] = $row['ciudad'];
						$array['regiones'][$row['cod_departamento']]['idMap'] = $row['idMap'];
						$array['regiones'][$row['cod_departamento']]['value'] = !empty( $array['regiones'][$row['cod_departamento']]['value'] ) ? $array['regiones'][$row['cod_departamento']]['value'] + 1 : 1;
						if ( $row['condicion']==0) {
							$array['regiones'][$row['cod_departamento']]['valueSV'] = isset($array['regiones'][$row['cod_departamento']]['valueSV']) ? $array['regiones'][$row['cod_departamento']]['valueSV'] + 1 : 1;
						} elseif ( $row['condicion']==1 ) {
							$array['regiones'][$row['cod_departamento']]['valueNE'] = isset($array['regiones'][$row['cod_departamento']]['valueNE']) ? $array['regiones'][$row['cod_departamento']]['valueNE'] + 1 : 1;
						} elseif ( $row['condicion']==2 ) {
							$array['regiones'][$row['cod_departamento']]['valueIN'] = isset($array['regiones'][$row['cod_departamento']]['valueIN']) ? $array['regiones'][$row['cod_departamento']]['valueIN'] + 1 : 1;
						} elseif ( $row['condicion']==3 ) {
							$array['regiones'][$row['cod_departamento']]['valueEF'] = isset($array['regiones'][$row['cod_departamento']]['valueEF']) ? $array['regiones'][$row['cod_departamento']]['valueEF'] + 1 : 1;
						}

					}

					$result['data']['views']['idContentGeneral']['html'] = $this->load->view("modulos/rutas/rutasGeneral", $array,true);
					$result['data']['views']['idContentRegional']['html'] = $this->load->view("modulos/rutas/rutasRegional", $array,true);
					$result['data']['views']['idContentCanal']['html'] = $this->load->view("modulos/rutas/rutasCanal", $array,true);
					break;
			}

		} else {
			$html .= getMensajeGestion('noRegistros');

			$result['data']['views']['idContentRutas']['html'] = $html;
			$result['data']['views']['idContentGeneral']['html'] = $html;
			$result['data']['views']['idContentRegional']['html'] = $html;
			$result['data']['views']['idContentCanal']['html'] = $html;
		}

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

	public function mostrarFotos(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos" ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$idVisita = $data->{'idVisita'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'usuario'};
		$array['perfil'] = $data->{'perfil'};
		$array['moduloFotos'] = $this->model->obtener_moduloFotos($idVisita);
		$array['fotos'] = $this->model->obtener_fotos($idVisita);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/rutas/verFotos", $array, true);

		echo json_encode($result);
	}

	public function detalle(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$modulo	= $data->{'modulo'};

		switch ($modulo) {
			case 'encuesta':
				$html = $this->detalle_encuesta($idVisita);
				break;

			case 'ipp':
				$html = $this->detalle_ipp($idVisita);
				break;

			case 'check_Producto':
				$html = $this->detalle_checkproducto($idVisita);
				break;

			case 'precios':
				$html = $this->detalle_precios($idVisita);
				break;

			case 'promociones':
				$html = $this->detalle_promociones($idVisita);
				break;

			case 'sos':
				$html = $this->detalle_sos($idVisita);
				break;

			case 'sod':
				$html = $this->detalle_sod($idVisita);
				break;

			case 'encartes':
				$html = $this->detalle_encarte($idVisita);
				break;

			case 'seguimientoPlan':
				$html = $this->detalle_seguimiento_plan($idVisita);
				break;

			case 'despachos':
				$html = $this->detalle_despacho($idVisita);
				break;

			/***Nuevos Formatos***/
			case 'inventario':
				$html = $this->detalle_inventario($idVisita);
				break;

			case 'visibilidad':
				$html = $this->detalle_visibilidad($idVisita);
				break;

			case 'mantenimientoCliente':
				$html = $this->detalle_mantenimientoCliente($idVisita);
				break;

			case 'iniciativas':
				$html = $this->detalle_iniciativas($idVisita);
				break;

			case 'inteligenciaCompetitiva':
				$html = $this->detalle_inteligenciaCompetitiva($idVisita);
				break;
				
			case 'ordenTrabajo':
				$html = $this->detalle_ordenTrabajo($idVisita);
				break;

			case 'visibilidadAuditoria':
				$html = $this->detalle_visibilidadAuditoria($idVisita);
				break;

			case 'premiacion':
				$html = $this->detalle_premiacion($idVisita);
				break;

			case 'surtido':
				$html = $this->detalle_surtido($idVisita);
				break;

			case 'observacion':
				$html = $this->detalle_observacion($idVisita);
				break;

			case 'encuestaPremio':
				$html = $this->detalle_encuestaPremio($idVisita);
				break;

			case 'tarea':
				$html = $this->detalle_tarea($idVisita);
				break;
			case 'evidenciaFotografica':
				$html = $this->detalle_evidenciaFotografica($idVisita);
				break;

			case 'ordenAuditoria':
				$html = $this->detalle_orden($idVisita);
				break;

			case 'modulacion':
				$html = $this->detalle_modulacion($idVisita);
				break;
		}
		
		//Result
		$result['result'] = 1;
		$result['data'] = $html;

		echo json_encode($result);
	}

	public function detalle_encuesta($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuesta" ];

		$data = [
			'encuesta' => [],
			'pregunta' => [],
			'alternativa' => [],
		];
		$query = $this->model->detalle_encuesta($idVisita);

		if( empty($query) ) $html = getMensajeGestion('noRegistros');
		else {
			foreach($query as $row){
				$data['encuesta'][$row['idEncuesta']]['id'] = $row['idEncuesta'];
				$data['encuesta'][$row['idEncuesta']]['name'] = $row['encuesta'];
				$data['encuesta'][$row['idEncuesta']]['foto'] = $row['fotoEncuesta'];

				$data['pregunta'][$row['idEncuesta']][$row['idPregunta']]['id'] = $row['idPregunta'];
				$data['pregunta'][$row['idEncuesta']][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$data['pregunta'][$row['idEncuesta']][$row['idPregunta']]['respuesta'] = $row['respuesta'];

				if( !empty($row['idAlternativa']) ){
					$data['alternativa'][$row['idPregunta']][$row['idAlternativa']]['respuesta'] = $row['respuesta'];
					$data['alternativa'][$row['idPregunta']][$row['idAlternativa']]['foto'] = $row['fotoRespuesta'];
				}
			}

			$html = $this->load->view("modulos/rutas/detalle_encuesta", $data, true);
		}

		return $html;
	}

	public function detalle_ipp($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIpp" ];

		$rs_det= $this->model->detalle_ipp($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['encuesta'][$row['idIpp']]['id'] = $row['idIpp'];
				$array['encuesta'][$row['idIpp']]['name'] = $row['encuesta'];
				$array['pregunta'][$row['idIpp']][$row['idPregunta']]['id'] = $row['idPregunta'];
				$array['pregunta'][$row['idIpp']][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['pregunta'][$row['idIpp']][$row['idPregunta']]['respuesta'] = $row['alternativa'];
				$array['pregunta'][$row['idIpp']][$row['idPregunta']]['puntaje'] = $row['puntaje'];
				$array['pregunta'][$row['idIpp']][$row['idPregunta']]['respuestas'][$row['idAlternativa']] = $row['alternativa'];
				$array['encuesta'][$row['idIpp']]['foto'] = $row['foto'];
			}
			$html = $this->load->view("modulos/rutas/detalle_ipp",$array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_checkproducto($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaProductosDet" ];

		$idGrupoCanal = getGrupoCanalDeVisita($idVisita);
		$rs_det = $this->model->detalle_checkproducto($idVisita, $idGrupoCanal);
		if(!empty($rs_det)){
			$array=array();
			
			$array['columnasAdicionales'] = getColumnasAdicionales(['idModulo' => 3, 'idGrupoCanal' => $idGrupoCanal]);
			
			if($array['columnasAdicionales']!=null){
				if (strpos($array['columnasAdicionales']['columnas_adicionales'], 'fechaVencido') !== false) {
					$array['columnasAdicionales']['columnas_adicionales']=$array['columnasAdicionales']['columnas_adicionales'].",cantidadVencida";
					$array['columnasAdicionales']['headers_adicionales'].='<th class="text-center align-middle">CANTIDAD VENCIDA</th>';
					array_push($array['columnasAdicionales']['body_adicionales'], "cantidadVencida");
				}
				
			}

			$arrayCheckproducto=array();
			$arrayCheckproductoComp=array();
			foreach($rs_det as $row){
				if($row['flagCompetencia']==1){
					array_push($arrayCheckproductoComp,$row);
				}else{
					array_push($arrayCheckproducto,$row);
				}
			}
			
			$array['checkproducto']=$arrayCheckproducto;
			$array['checkproductoComp']=$arrayCheckproductoComp;
			$html = $this->load->view("modulos/rutas/detalle_checkproducto",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_precios($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPrecios" ];

		$idGrupoCanal = getGrupoCanalDeVisita($idVisita);
		$rs_det = $this->model->detalle_precio($idVisita, $idGrupoCanal);
		if(!empty($rs_det)){
			$array=array();
			$array['precio']=$rs_det;
			$array['columnasAdicionales'] = getColumnasAdicionales(['idModulo' => 10, 'idGrupoCanal' => $idGrupoCanal]);
			$html = $this->load->view("modulos/rutas/detalle_precio",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_promociones($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPromociones" ];

		$idGrupoCanal = getGrupoCanalDeVisita($idVisita);
		$rs_det = $this->model->detalle_promociones($idVisita, $idGrupoCanal);
		if(!empty($rs_det)){
			$array=array();
			$array['promociones']=$rs_det;
			$array['columnasAdicionales'] = getColumnasAdicionales(['idModulo' => 7, 'idGrupoCanal' => $idGrupoCanal]);

			if($array['columnasAdicionales']!=null){
				if (strpos($array['columnasAdicionales']['columnas_adicionales'], 'fechaVigencia') !== false) {
					$array['columnasAdicionales']['columnas_adicionales']=str_replace("fechaVigencia", "fechaVigenciaInicio", $array['columnasAdicionales']['columnas_adicionales']);
					$array['columnasAdicionales']['columnas_adicionales']=$array['columnasAdicionales']['columnas_adicionales'].",fechaVigenciaFin";
					$array['columnasAdicionales']['headers_adicionales']=str_replace("FECHA VIGENCIA", "FECHA VIGENCIA INICIO", $array['columnasAdicionales']['headers_adicionales']);

					$array['columnasAdicionales']['headers_adicionales'].='<th class="text-center align-middle">FECHA VIGENCIA FIN</th>';
				}
			}

			$html = $this->load->view("modulos/rutas/detalle_promociones",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		
		return $html;
	}

	public function detalle_sos($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSoS" ];

		$rs_det = $this->model->detalle_sos($idVisita);
		if(!empty($rs_det)){
			$array=array();
			$array['sos']=$rs_det;
			$html = $this->load->view("modulos/rutas/detalle_sos",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_sod($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSod" ];

		$rs_det=$this->model->detalle_sod($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['categorias'][$row['idVisitaSod']] = $row;
				$array['elementos'][$row['idVisitaSod']][$row['idVisitaSodDet']] = $row;
				$array['fotos'][$row['idVisitaSod']][$row['idVisitaSodDet']][$row['idVisitaFoto']] = $row;
			}
			$html = $this->load->view("modulos/rutas/detalle_sod",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_encarte($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncartes" ];

		$rs_det=$this->model->detalle_encarte($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['categorias'][$row['idCategoria']] = $row;
				$array['encartes'][$row['idCategoria']][$row['id']] = $row;
			}
			$html = $this->load->view("modulos/rutas/detalle_encarte",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_seguimiento_plan($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan" ];

		$rs_det=$this->model->detalle_seguimiento_plan($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['planes'][$row['idSeguimientoPlan']] = $row;
				$array['seguimiento'][$row['idSeguimientoPlan']][$row['idVisitaSeguimientoPlanDet']] = $row;
			}
			$html = $this->load->view("modulos/rutas/detalle_seguimiento_plan",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_despacho($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaDespachos" ];

		$rs_det=$this->model->detalle_despacho($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['despachos'][$row['idVisitaDespachos']] = $row;
				$array['despachos_det'][$row['idVisitaDespachos']][$row['idVisitaDespachosDias']] = $row;
			}
			$html = $this->load->view("modulos/rutas/detalle_despacho",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_inventario($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaInventario" ];

		$rs_det=$this->model->detalle_inventario($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['listaProductos'][$row['idProducto']]['idProducto'] = $row['idProducto'];
				$array['listaProductos'][$row['idProducto']]['producto'] = $row['producto'];
				$array['listaProductos'][$row['idProducto']]['stock_inicial'] = $row['stock_inicial'];
				$array['listaProductos'][$row['idProducto']]['sellin'] = $row['sellin'];
				$array['listaProductos'][$row['idProducto']]['stock'] = $row['stock'];
				$array['listaProductos'][$row['idProducto']]['validacion'] = $row['validacion'];
				$array['listaProductos'][$row['idProducto']]['observacion'] = $row['observacion'];
				$array['listaProductos'][$row['idProducto']]['comentario'] = $row['comentario'];
				$array['listaProductos'][$row['idProducto']]['fechaVencimiento'] = $row['fechaVencimiento'];
			}

			$html = $this->load->view("modulos/rutas/detalle_inventario",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_visibilidad($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad" ];

		$query = $this->model->detalle_visibilidad($idVisita);
		if( !empty($query) ){
			$data = [
				'modulado' => [],
				'nomodulado' => []
			];

			foreach($query as $row){
				$data[($row['condicion'] ? 'nomodulado' : 'modulado')][] = $row;
			}

			$html = $this->load->view("modulos/rutas/detalle_visibilidad", $data, true);

		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_mantenimientoCliente($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente" ];

		$rs_det=$this->model->detalle_mantenimientoCliente($idVisita);
		if(!empty($rs_det)){
			$array=array();
			$array['listaMantenimientoCliente'] = $rs_det;
			$html = $this->load->view("modulos/rutas/detalle_mantenimientoCliente",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_iniciativas($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad" ];

		$query = $this->model->detalle_iniciativas($idVisita);
		if( !empty($query) ){
			$data = [
				'iniciativa' => [],
				'elementos' => []
			];
			foreach($query as $row){
				$data['iniciativa'][$row['idIniciativa']]['nombre'] = $row['iniciativa'];

				$data['elementos'][$row['idIniciativa']][$row['idElementoVis']]['nombre'] = $row['elementoIniciativa'];
				$data['elementos'][$row['idIniciativa']][$row['idElementoVis']]['producto'] = $row['producto'];
				$data['elementos'][$row['idIniciativa']][$row['idElementoVis']]['presencia'] = $row['presencia'];
				$data['elementos'][$row['idIniciativa']][$row['idElementoVis']]['cantidad'] = $row['cantidad'];
				$data['elementos'][$row['idIniciativa']][$row['idElementoVis']]['estado'] = $row['estadoIniciativa'];
				$data['elementos'][$row['idIniciativa']][$row['idElementoVis']]['foto'] = $row['foto'];

				$data['iniciativa'][$row['idIniciativa']]['total'] = count($data['elementos'][$row['idIniciativa']]);
			}

			$html = $this->load->view("modulos/rutas/detalle_iniciativas", $data, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_inteligenciaCompetitiva($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad" ];

		$rs_det=$this->model->detalle_inteligenciaCompetitiva($idVisita);
		if(!empty($rs_det)){
			$array=array();
			$array['listaInteligenciaCompetitiva'] = $rs_det;

			$html = $this->load->view("modulos/rutas/detalle_inteligenciaCompetitiva",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_ordenTrabajo($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaOrden" ];

		$rs_det=$this->model->detalle_ordenTrabajo($idVisita);
		if(!empty($rs_det)){
			$array=array();
			$array['orden'] = $rs_det;

			$html = $this->load->view("modulos/rutas/detalle_ordenTrabajo",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_visibilidadAuditoria($idVisita){
		$rs_detObligatoria = $this->model->detalle_visibilidadAuditoriaObligatoria($idVisita);
		$rs_detIniciativa = $this->model->detalle_visibilidadAuditoriaIniciativa($idVisita);
		$rs_detAdicional = $this->model->detalle_visibilidadAuditoriaAdicional($idVisita);

		if( !empty($rs_detObligatoria) || !empty($rs_detIniciativa) || !empty($rs_detAdicional) ){
			$html = '';
			if ( !empty($rs_detObligatoria) ) {
				$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio" ];

				$array = array();
				foreach($rs_detObligatoria as $row){
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['idVisitaVisibilidad'] = $row['idVisitaVisibilidad'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['porcentaje'] = $row['porcentaje'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['porcentajeV'] = $row['porcentajeV'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['porcentajePM'] = $row['porcentajePM'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['porcentajePM'] = $row['porcentajePM'];

					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['elementoVisibilidad'] = $row['elementoVisibilidad'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['cantidad'] = $row['cantidad'];

					if( !isset($array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['foto']) )
						$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['foto'] = '';

					if( !empty($row['foto']) ){
						$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['foto'] = $row['foto'];
					}

					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['variable'] = $row['variable'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['presencia'] = $row['presencia'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['observacion'] = $row['observacion'];
					$array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['comentario'] = $row['comentario'];
					// $array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['cantidad'] = $row['cantidad'];
					// $array['listaAuditoriaObligatoria'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['foto'] = $row['foto'];
				}

				$html .= $this->load->view("modulos/rutas/detalle_visibilidadAuditoriaObligatoria",$array,true);
			}

			if ( !empty($rs_detIniciativa) ) {
				$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa" ];

				$array = array();
				foreach($rs_detIniciativa as $row){
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['idVisitaVisibilidad'] = $row['idVisitaVisibilidad'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['porcentaje'] = $row['porcentaje'];

					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['idIniciativa'] = $row['idIniciativa'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['iniciativa'] = $row['iniciativa'];
					
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['elementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['elementos'][$row['idElementoVis']]['elementoVisibilidad'] = $row['elementoVisibilidad'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['elementos'][$row['idElementoVis']]['presencia'] = $row['presencia'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['elementos'][$row['idElementoVis']]['comentario'] = $row['comentario'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['elementos'][$row['idElementoVis']]['observacion'] = $row['observacion'];
					$array['listaAuditoriaIniciativa'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idIniciativa']]['elementos'][$row['idElementoVis']]['foto'] = $row['foto'];
				}

				$html .= $this->load->view("modulos/rutas/detalle_visibilidadAuditoriaIniciativa",$array,true);
			}

			if ( !empty($rs_detAdicional) ) {
				$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional" ];

				$array = array();
				foreach($rs_detAdicional as $row){
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['idVisitaVisibilidad'] = $row['idVisitaVisibilidad'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['porcentaje'] = $row['porcentaje'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['cantidadCabecera'] = $row['cantidadCabecera'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['elementoVisibilidad'] = $row['elementoVisibilidad'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['presencia'] = $row['presencia'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['cantidad'] = $row['cantidad'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['comentario'] = $row['comentario'];
					$array['listaAuditoriaAdicional'][$row['idVisitaVisibilidad']]['listaElementos'][$row['idElementoVis']]['foto'] = $row['foto'];
				}

				$html .= $this->load->view("modulos/rutas/detalle_visibilidadAuditoriaAdicional",$array,true);
			}
			
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_encuestaPremio($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio" ];

		$rs_det=$this->model->detalle_encuestaPremio($idVisita);
		if(!empty($rs_det)){
			$array=array();
			foreach($rs_det as $row){
				$array['encuestas'][$row['idEncuesta']]['idEncuesta'] = $row['idEncuesta'];
				$array['encuestas'][$row['idEncuesta']]['encuesta'] = $row['encuesta'];
				$array['encuestas'][$row['idEncuesta']]['foto'] = $row['foto'];
				$array['encuestas'][$row['idEncuesta']]['preguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['encuestas'][$row['idEncuesta']]['preguntas'][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['encuestas'][$row['idEncuesta']]['preguntas'][$row['idPregunta']]['respuesta'] = $row['respuesta'];
			}

			$html = $this->load->view("modulos/rutas/detalle_encuestaPremio",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_premiacion($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPremiacion" ];

		$query = $this->model->detalle_premiacion($idVisita);
		if( !empty($query) ){
			$data = [ 'premiacion' => $query ];
			$html = $this->load->view("modulos/rutas/detalle_premiacion", $data, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	public function detalle_surtido($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSurtido" ];

		$aSurtido = $this->model->detalle_surtido($idVisita);
		$aSugerido = $this->model->detalle_sugerido($idVisita);

		if( !empty($aSurtido) || !empty($aSugerido) ){
			$html = $this->load->view("modulos/rutas/detalle_surtido", [ 'surtido' => $aSurtido, 'sugerido' => $aSugerido ], true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	public function detalle_observacion($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaObservacion" ];

		$rs_det= $this->model->detalle_observacion($idVisita);
		if(!empty($rs_det)){
			$array=array();
			$array['observacion']=$rs_det;
			
			$html = $this->load->view("modulos/rutas/detalle_observacion",$array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_tarea($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaTarea" ];

		$rs_det = $this->model->detalle_tarea($idVisita);

		$list_tareas = [];

		foreach($rs_det AS $key => $row){
			$list_tareas['tareas'][$row['idTarea']]['idVisitaTarea'] = $row['idVisitaTarea'];
			$list_tareas['tareas'][$row['idTarea']]['idVisita'] = $row['idVisita'];
			$list_tareas['tareas'][$row['idTarea']]['presencia'] = $row['presencia'];
			$list_tareas['tareas'][$row['idTarea']]['tarea'] = $row['tarea'];
			$list_tareas['tareas'][$row['idTarea']]['comentario'] = $row['comentario'];
			$list_tareas['tareas'][$row['idTarea']]['fotos'][] = $row['fotoUrl'];
		}

		if(!empty($rs_det)){
			$array = [];
			$array['tareas'] = $list_tareas['tareas'];
			
			$html = $this->load->view("modulos/rutas/detalle_tarea",$array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_evidenciaFotografica($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEvidenciaFotografica" ];

		$rs_det = $this->model->detalle_evidenciaFotografica($idVisita);

		$list_evidencias = [];

		foreach($rs_det AS $key => $row){
			$list_evidencias['evidencias'][$row['idVisita']]['idVisitaEvidenciaFotografica'] = $row['idVisitaEvidenciaFotografica'];
			$list_evidencias['evidencias'][$row['idVisita']]['idVisita'] = $row['idVisita'];
			$list_evidencias['evidencias'][$row['idVisita']]['comentario'] = $row['comentario'];
			$list_evidencias['evidencias'][$row['idVisita']]['fotos'][$row['idTipoFotoEvidencia']][] = $row['fotoUrl'];
		}

		if(!empty($rs_det)){
			$array = [];
			$array['evidencias'] = $list_evidencias['evidencias'];
			
			$html = $this->load->view("modulos/rutas/detalle_evidenciaFotografica",$array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}

		return $html;
	}

	public function detalle_orden($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaOrden" ];

		$query = $this->model->detalle_orden($idVisita);
		if( !empty($query) ){
			$data = [ 'ordenAuditoria' => $query ];
			$html = $this->load->view("modulos/rutas/detalle_orden", $data, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	public function detalle_modulacion($idVisita){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaModulacion" ];

		$query = $this->model->detalle_modulacion($idVisita);

		$flagCorrecto=null;
		foreach($query AS $key => $row){
			$flagCorrecto=$row['flagCorrecto'];
		}
		$modulacion=array();
		foreach($query AS $key => $row){
			if($row['idElementoVis']!=null){
				array_push($modulacion,$row);
			}
		}

		if( !empty($query) ){
			$data = [ 'modulacion' => $modulacion,'flagCorrecto' => $flagCorrecto];
			$html = $this->load->view("modulos/rutas/detalle_modulacion", $data, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

}
?>