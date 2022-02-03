<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Basemadre extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_basemadre','model');
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active'] = '3';
		$config['css']['style'] = array();
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/basemadre'
		);

		$config['data']['icon'] = 'fa fa-users';
		$config['data']['title'] = 'Basemadre';
		$config['data']['message'] = 'Lista de PDV';
		$config['view'] = 'modulos/basemadre/index';

		$this->view($config);
	}

	public function filtrar(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'table' => 'trade.cliente' ];

		ini_set('memory_limit','2048M');
		set_time_limit(0);

		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);

		$fechas = explode(' - ', $data['txt-fechas']);

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['idProyecto'] = $data['proyecto_filtro'];
		$input['idCuenta'] = $data['cuenta_filtro'];
		$input['cartera'] = $data['flag_cartera'];
		$input['grupoCanal'] = $data['grupo_filtro'];
		$input['canal'] = $data['canal_filtro'];
		$input['subcanal'] = $data['subcanal_filtro'];
		$input['plaza_filtro'] = !empty($data['plaza_filtro']) ? $data['plaza_filtro'] : '';
		$input['distribuidora_filtro'] = !empty($data['distribuidora_filtro']) ? $data['distribuidora_filtro'] : '';
		$input['distribuidoraSucursal_filtro'] = !empty($data['distribuidoraSucursal_filtro']) ? $data['distribuidoraSucursal_filtro'] : '';
		$input['zona_filtro'] = !empty($data['zona_filtro']) ? $data['zona_filtro'] : '';
		$input['cadena_filtro'] = !empty($data['cadena_filtro']) ? $data['cadena_filtro'] : '';
		$input['banner_filtro'] = !empty($data['banner_filtro']) ? $data['banner_filtro'] : '';
		$input['tipoUsuario_filtro'] = !empty($data['tipoUsuario_filtro']) ? $data['tipoUsuario_filtro'] : '';
		$input['usuario_filtro'] = !empty($data['usuario_filtro']) ? $data['usuario_filtro'] : '';

		$input['departamento_filtro'] = $data['departamento_filtro'];
		$input['provincia_filtro'] = $data['provincia_filtro'];
		$input['distrito_filtro'] = $data['distrito_filtro'];

		$idUsuario=$this->session->userdata('idUsuario');
		$idCuenta=$this->session->userdata('idCuenta');

		$rs_resultado = $this->model->obtener_basemadre($input);

		$rs_visita = $this->model->obtener_visita($input);

		$html = '';
		$result['data']['tipoFormato'] = $data['tipoFormato'];

		if ( !empty($rs_resultado) ) {
			$result['result'] = 1;
			$array = array();

			$array['fecIni'] = $input['fecIni'];
			$array['fecFin'] = $input['fecFin'];

			$array['total_venta'] = 0;
			
			$array['contRs'] = count($rs_resultado);
			$contCartera=0; $contFalgCartera=0;

			switch ( $data['tipoFormato']) {
				case 1:
					foreach ($rs_resultado as $kr => $row) {

						/********CARTERA*********/
						if ( !empty($row['flagCartera'])) {
							$contCartera++;
							$array['regiones_cartera'][$row['cod_departamento']]['value'] = isset($array['regiones_cartera'][$row['cod_departamento']]['value']) ? $array['regiones_cartera'][$row['cod_departamento']]['value'] + 1 : 1;
							$array['regiones_cartera'][$row['cod_departamento']]['id'] = $row['idMap'];
							$array['regiones_cartera'][$row['cod_departamento']]['cod_departamento'] = $row['cod_departamento'];
							$array['regiones_cartera'][$row['cod_departamento']]['monto'] = isset($array['regiones_cartera'][$row['cod_departamento']]['monto'])? $array['regiones_cartera'][$row['cod_departamento']]['monto'] + $row['monto'] : $row['monto'];
						} else {
							$contFalgCartera++;
							$array['regiones_fcartera'][$row['cod_departamento']]['value'] = isset($array['regiones_fcartera'][$row['cod_departamento']]['value'])? $array['regiones_fcartera'][$row['cod_departamento']]['value'] + 1 : 1;
							$array['regiones_fcartera'][$row['cod_departamento']]['id'] = $row['idMap'];
							$array['regiones_fcartera'][$row['cod_departamento']]['cod_departamento'] = $row['cod_departamento'];
							$array['regiones_fcartera'][$row['cod_departamento']]['monto'] = isset($array['regiones_fcartera'][$row['cod_departamento']]['monto'])? $array['regiones_fcartera'][$row['cod_departamento']]['monto'] + $row['monto'] : $row['monto'];
						}

						/*****CANALES*****/
						$array['canal'][$row['idCanal']]['nombre'] = $row['canal'];
						if( !empty($row['flagCartera']) ){
							$array['canal'][$row['idCanal']]['en_cartera'] = isset($array['canal'][$row['idCanal']]['en_cartera'])? $array['canal'][$row['idCanal']]['en_cartera'] + 1 : 1;
							$array['canal'][$row['idCanal']]['total_en_cartera_venta'] = isset($array['canal'][$row['idCanal']]['total_en_cartera_venta'])? $array['canal'][$row['idCanal']]['total_en_cartera_venta'] + $row['monto'] : $row['monto'];
						} else {
							$array['canal'][$row['idCanal']]['fuera_cartera'] = isset($array['canal'][$row['idCanal']]['fuera_cartera'])? $array['canal'][$row['idCanal']]['fuera_cartera']  + 1 : 1;
							$array['canal'][$row['idCanal']]['total_fuera_cartera_venta'] = isset($array['canal'][$row['idCanal']]['total_fuera_cartera_venta'])? $array['canal'][$row['idCanal']]['total_fuera_cartera_venta'] + $row['monto'] : $row['monto'];
						}

						/*******SEGMENTO-BANNER**********/
						if(isset($row['idBanner'])){
							$array['segmento'][$row['idBanner']][0] = $row['banner'];
							if(!empty($row['flagCartera'])){
								$array['segmento'][$row['idBanner']][1] = isset($array['segmento'][$row['idBanner']][1])? $array['segmento'][$row['idBanner']][1]  + 1 : 1;
								$array['segmento'][$row['idBanner']][3] = isset($array['segmento'][$row['idBanner']][3])? $array['segmento'][$row['idBanner']][3] + $row['monto'] : $row['monto'];
							} else {
								$array['segmento'][$row['idBanner']][2] = isset($array['segmento'][$row['idBanner']][2])? $array['segmento'][$row['idBanner']][2]  + 1 : 1;
								$array['segmento'][$row['idBanner']][4] = isset($array['segmento'][$row['idBanner']][4])? $array['segmento'][$row['idBanner']][4] + $row['monto'] : $row['monto'];
							}
						}

						/***************************************/
						$array['total_venta'] = $array['total_venta'] + $row['monto'];
						$array['total_canal'][$row['idCanal']] = isset($array['total_canal'][$row['idCanal']])? $array['total_canal'][$row['idCanal']] + $row['monto'] : $row['monto'];
						$array['total_dep'][$row['cod_departamento']] = isset($array['total_dep'][$row['cod_departamento']])? $array['total_dep'][$row['cod_departamento']] + $row['monto'] : $row['monto'];

						/******************************************/
						if(!empty($row['flagCartera'])){
							$array['en_cartera'][$row['idCliente']] = $row;
							$array['total_en_cartera_venta'] = isset($array['total_en_cartera_venta'])? $array['total_en_cartera_venta'] + $row['monto'] : $row['monto'];
						} else {
							$array['fuera_cartera'][$row['idCliente']] = $row;
							$array['total_fuera_cartera_venta'] = isset($array['total_fuera_cartera_venta'])? $array['total_fuera_cartera_venta'] + $row['monto'] : $row['monto'];
						}
					}

					/*************CLIENTES VISITADOS***************/
					foreach ($rs_visita as $kv => $row_visita) {
						$array['visita'][$row_visita['idCliente']] = $row_visita;
						if ( !empty($row_visita['idVisita']) ) {
							$array['programados'][$row_visita['idCliente']] = $row_visita;
						}
					}

					$array['arr_regiones_cartera'] = array();
					foreach ($array['regiones_cartera'] as $ix => $row) {
						$fcartera = isset($array['regiones_fcartera'][$ix]['value'])? $array['regiones_fcartera'][$ix]['value'] : 0;
						$mfcartera = isset($array['regiones_fcartera'][$ix]['monto'])? $array['regiones_fcartera'][$ix]['monto'] : 0;
						if($row['value'] > 0 ){
							$arr = array(
								'id' => $row['id']
								, 'cartera' => $row['value']
								, 'cartera_monto' => moneda($row['monto'])
								, 'por_cartera_1' => (($array['total_venta'] > 0)? round(($row['monto']/$array['total_venta'])*100,2).'%' : '-')
								, 'fcartera' => $fcartera
								, 'fcartera_monto' => moneda($mfcartera)
								, 'por_fcartera_1' => (($array['total_venta'] > 0)? round(($mfcartera/$array['total_venta'])*100,2).'%' : '-')
							);
							array_push($array['arr_regiones_cartera'], $arr);
						}
					}

					$array['arr_regiones_fcartera'] = array();
					if(isset($array['regiones_fcartera'])){
						foreach($array['regiones_fcartera'] as $ix => $row){
							$cartera = isset($array['regiones_cartera'][$ix]['value'])? $array['regiones_cartera'][$ix]['value'] : 0;
							$mcartera = isset($array['regiones_cartera'][$ix]['monto'])? $array['regiones_cartera'][$ix]['monto'] : 0;
							if($cartera <= 0 ){
								$arr = array(
									'id' => $row['id']
									, 'fcartera' => $row['value']
									, 'fcartera_monto' => moneda($row['monto'])
									, 'por_fcartera_1' => (($array['total_venta'] > 0)? round(($row['monto']/$array['total_venta'])*100,2).'%' : '-')
									, 'cartera' => $cartera
									, 'cartera_monto' => moneda($mcartera)
									, 'por_cartera_1' => (($array['total_venta'] > 0)? round(($mcartera/$array['total_venta'])*100,2).'%' : '-')
								);
								array_push($array['arr_regiones_fcartera'], $arr);
							}
						}
					}

					$result['data']['resumen'] = $this->load->view("modulos/basemadre/basemadreResumen", $array, true);
					$result['data']['canal'] = $this->load->view("modulos/basemadre/basemadreCanal", $array, true);
					$result['data']['mapa'] = $this->load->view("modulos/basemadre/basemadreMapa", $array, true);
						$result['data']['regiones'][0] = $array['arr_regiones_cartera'];
						$result['data']['regiones'][1] = $array['arr_regiones_fcartera'];
					$result['data']['segmento'] = $this->load->view("modulos/basemadre/basemadreSegmento", $array, true);
					break;
				
				case 2:
					$array['rs'] = $rs_resultado;
					$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal']]);
					$array['segmentacion'] = $segmentacion;
					$result['data']['detalle'] = $this->load->view("modulos/basemadre/basemadreDetalle", $array, true);
					$new_data = [];
					$i = 1;
					foreach ($array['rs'] as $kr => $row) {
						$row_visita = isset($visita[$row['idCliente']]) ? $visita[$row['idCliente']] : array();
						$prog = isset($row_visita['idVisita']) ? 1 : 0;
						$user = isset($row_visita['nombreUsuario']) ? $row_visita['nombreUsuario'] : '-';

						$new_data[$kr] = [
							//Columnas
							$i++, 
							!empty($row['grupoCanal']) ? "<p class='text-left'>{$row['grupoCanal']}</p>" : '-', 
							!empty($row['canal']) ? "<p class='text-left'>{$row['canal']}</p>" : '-', 
							!empty($row['subCanal']) ? "<p class='text-left'>{$row['subCanal']}</p>" : '-',
							!empty($row['clienteTipo']) ? "<p class='text-left'>{$row['clienteTipo']}</p>" : '-',
						];
						foreach ($segmentacion['headers'] as $k => $v) { 
							 array_push($new_data[$kr],
							 	!empty($row[($v['columna'])]) ? "<p class='text-left'>{$row[($v['columna'])]}</p>" : '-'
							 );
						} 
						array_push($new_data[$kr],
							!empty($row['departamento']) ? "<p class='text-left'>{$row['departamento']}</p>" : '-', 
							!empty($row['provincia']) ? "<p class='text-left'>{$row['provincia']}</p>" : '-', 
							!empty($row['distrito']) ? "<p class='text-left'>{$row['distrito']}</p>" : '-', 
							!empty($row['idCliente']) ? "<p class='text-center'>{$row['idCliente']}</p>" : '-', 
							!empty($row['codCliente']) ? "<p class='text-center'>{$row['codCliente']}</p>" : '-', 
							!empty($row['codPdv']) ? "<p class='text-center'>{$row['codPdv']}</p>" : '-', 
							!empty($row['razonSocial']) ? "<p class='text-left'>{$row['razonSocial']}</p>" : '-', 
							!empty($row['nombreComercial']) ? "<p class='text-left'>{$row['nombreComercial']}</p>" : '-', 
							!empty($row['direccion']) ? "<p class='text-left'>{$row['direccion']}</p>" : '-',
							!empty($row['ruc']) ? "<p class='text-left'>{$row['ruc']}</p>" : '-',
							!empty($row['dni']) ? "<p class='text-left'>{$row['dni']}</p>" : '-',
							!empty($row['frecuencia']) ? "<p class='text-left'>{$row['frecuencia']}</p>" : '-',
							!empty($row['flagCartera']) ? "<p class='text-center'>SÍ</p>" : '-'
						);

						if($idCuenta!="2"){
							array_push($new_data[$kr],
								!empty($row['monto']) ? "<p class='text-right'>".moneda($row['monto'])."</p>" : '-',
								($array['total_venta'] > 0)  ? "<p class='text-right'>".round(($row['monto'] / $array['total_venta']) * 100, 2) . '%'."</p>" : '-',
								isset($total_canal[$row['idCanal']]) ? "<p class='text-right'>".(($total_canal[$row['idCanal']] > 0) ? round(($row['monto'] / $total_canal[$row['idCanal']]) * 100, 2) . '%' : '-')."</p>" : '-',
								isset($total_dep[$row['cod_departamento']]) ? "<p class='text-right'>".(($total_dep[$row['cod_departamento']] > 0) ? round(($row['monto'] / $total_dep[$row['cod_departamento']]) * 100, 2) . '%' : '-')."</p>" : '-'
							);
						}
						
						
						array_push($new_data[$kr],
						!empty($prog) ? "<p class='text-center'>".'SÍ'."</p>" : '-',
						!empty($row['direccion']) ? "<p class='text-left'>".utf8_encode($user)."</p>" : '-'
						
						//Atributos para la fila
						// 'data-id'=> $v['idUsuario'],
						// 'data-estado'=> $v['estado'],
						// 'data-activo'=> !empty($v['flag_activo']) ? '1' : '0',
						);

					}
					$result['data']['data_table'] = $new_data;
					$result['data']['configTable'] =  [
						'data' => $new_data, 
						'columnDefs' =>
							[ 0 => 
								[
									"targets" => [],
									"className"=> 'noVis',
								],
							  1 => 
							  	[
									"visible"=> false, 
									"targets" => []
								],
							],
						// 'dom' => '<"ui icon input"f>tip',
					];
					break;
			}			
		} else {
			$html = getMensajeGestion('noRegistros');

			$result['data']['resumen'] = $html;
			$result['data']['canal'] = $html;
			$result['data']['mapa'] = $html;
			$result['data']['segmento'] = $html;
			$result['data']['detalle'] = $html;
			
		}

		echo json_encode($result);
	}

}
?>