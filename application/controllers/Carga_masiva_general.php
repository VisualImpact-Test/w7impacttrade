<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Carga_masiva_general extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('m_carga_masiva_general','model');
	}
	
	public function form_carga(){
		$idUsuario = $this->session->idUsuario;
	
		$data = json_decode($this->input->post('data'));
		$tipo=$data->{'tipo'};
		$tipo_carga = $this->model->obtener_tipo_carga($tipo)->row_array();
		
		
		$titulo=$tipo_carga['tituloFormulario'];
		
		$array=array();
		$array['tipo']=$tipo;
		if($tipo==2){
			$array['segmentacion'] = $this->model->obtener_segmentacion_cliente($idUsuario)->row_array();
			$array['data_carga'] = $this->model->data_carga_base_madre($idUsuario)->result_array();
		}
		$html=$this->load->view("modulos/cargaMasivaGeneral/form_carga", $array, true);
		
		$result['result']=1;
		$result['msg']['title'] = $titulo;
		$result['data']['html'] = $html;
		
		echo json_encode($result);
	}
	
	public function validar_carga(){
		$total=0;
		$tipo = $_POST['tipo'];
		$id = $_POST['id'];
		
		$tipo_carga = $this->model->obtener_tipo_carga($tipo)->row_array();
		
		$idTipoCarga = $tipo_carga['idTipoCarga'];
		$carpeta = $tipo_carga['carpeta'];
		
		$tablas = $this->model->obtener_tablas($tipo)->result_array();
		
		$total_tablas = count($tablas);
		
		if($total_tablas>0){
			foreach($tablas as $row){
				if($row['orden']==0){
					$validar = $this->model->consultar_tabla($row['tabla'],$row['campos'],$id)->row_array();
					$total = $total+$validar['total'];
				}
			}
		}
		
		$result=array();
		$result['result']=1;
		$result['data']=$total;

		echo json_encode($result);
	}
	
	public function cargar_archivos(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$archivo = $_FILES['file']['name'];
		$tipo = $_POST['tipo'];
		$idUsuario = $this->session->idUsuario;								 

		$id = $_POST['id'];
		$fecIni = $_POST['fecIni'];
		$fecFin = $_POST['fecFin'];
		$idGrupoCanal = $_POST['idGrupoCanal'];								 
		$datetime = date('dmYHis');
		
		$tipo_carga = $this->model->obtener_tipo_carga($tipo)->row_array();
		
		$carpeta = $tipo_carga['carpeta'];
		
		$tablas = $this->model->obtener_tablas($tipo)->result_array();
		
		//LIMPIAR TABLAS
		foreach($tablas as $row){	
			if($row['orden']==1){
				$validar = $this->model->limpiar_tabla_detalle($row['tabla'],$row['campos'],$id,$row['dependencia'],$row['campoDependencia']);
			}
		}
		foreach($tablas as $row){	
			if($row['orden']==0){
				$validar = $this->model->limpiar_tabla($row['tabla'],$row['campos'],$id,$row['dependencia']);
			}
		}
		$carpeta_servidor=$carpeta.'_'.$datetime;
		
		$ruta = 'public/csv/'.$carpeta.'/'.$carpeta_servidor;
		$rutaFiles = 'public/csv/'.$carpeta.'/'.$carpeta_servidor.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);	
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		copy($_FILES['file']['tmp_name'],$ruta.'/'.$carpeta.'__'.$datetime.'.csv');

		$size = 1000000; // 1kb
		$to_read = $ruta.'/'.$carpeta.'__'.$datetime.'.csv';
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
		
		$obtener_campos = $this->model->obtener_tabla_campos($tipo)->result_array();
		
		$variables = array (
			'id' => $_POST['id'],			
			'fecIni' => $_POST['fecIni'],
			'fecFin' => $_POST['fecFin'],
			'datetime' => date('dmYHis'),
			'carpeta' => $carpeta_servidor,
			'total' => $total,
			'idUsuario' => $this->session->idUsuario,
			'idGrupoCanal' => $idGrupoCanal,													   
		);
		if( !empty($_POST['id'])){
			$variables['id']= $_POST['id'];
		}
		
		
		$carga = array();
		foreach($obtener_campos as $row){
			$carga[$row['campos']] = $variables[$row['variable']];
			$tabla = $row['tabla'];
		}
		$this->db->insert($tabla,$carga);						   
		/* $carga = array(
			'idPermiso' => $idPermiso,
			'fecIni' => $fecIni,
			'fecFin' => $fecFin,
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
		); */

		if($tipo==2){
			$array['segmentacion'] = $this->model->obtener_segmentacion_cliente($idUsuario)->row_array();
			$array['data_carga'] = $this->model->data_carga_base_madre($idUsuario)->result_array();
		}																			  
		$html=$this->load->view("modulos/cargaMasivaGeneral/reporte_carga", $array, true);
		$result=array();
		$result['data']= $html;
		echo json_encode($result);
	}

	public function delimiter_exists($csvHeader, $delimiter){
		return (bool)preg_match("/$delimiter/", $csvHeader); 
	}

	public function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}

	public function procesar_base_madre_solicitud(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->obtener_carpetas_base_madre();
		///
		foreach($carpetas as $row){
			$ruta = 'public/csv/base_madre/'.$row['carpeta'];
			$rutaFiles = 'public/csv/base_madre/'.$row['carpeta'].'/archivos/';
			$directorio_INS = opendir($rutaFiles);
			$arrayBody=array();
			$canal_carga=$row['canal'];
			$idCarga=$row['idCarga'];
			$totalRegistros=$row['totalRegistros'];
			
			$this->model->actualizar_clientes($idCarga,$totalRegistros);
			
			$i=0;
			$j=0;
			while (false !== ($archivo_INS = readdir($directorio_INS))){
				if ($archivo_INS != '.' && $archivo_INS != '..') {
					if(is_file($rutaFiles.$archivo_INS)) {
						$rutaCSV = $rutaFiles.$archivo_INS;
						$fp = fopen($rutaCSV, "r");
						while (!feof($fp)){
							$csvHeader = fgets($fp);
							break;
						}
						fclose($fp);

						$delimiter = $this->delimiter_exists($csvHeader, ',') ? ',' : ';'; 
						$handle_body = fopen($rutaCSV, "r");
						$header_=0;

						$indice=-2;
						$total_columna=0;

						$codigoElemento=array();
						while (($data = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) { $header_++; $indice++;
							if($header_==1){
								$total_columna=count($data);
							}
							if($header_!=1){
								$cont =0;
									$grupocanal = utf8_encode($data[18]);
									$canal = utf8_encode($data[19]);
									
									
									
									$idSegNegocio = $this->model->validar_segmentacion_negocio($grupocanal,$canal)->row_array();
									if($canal_carga==1){
										$total_distribuidoras = $total_columna-21;
										$plaza = utf8_encode($data[20]);
										
										$idPlaza='';
										$idSegTradicional ='';
										if(!empty($plaza)){
											$res_plaza= $this->model->obtener_idplaza($plaza)->row_array();
											$idPlaza=$res_plaza['idPlaza'];
										}
										
										$idSegTradicional = $this->model->insertar_segmentacion_tradicional($idPlaza);
										if(!empty($idSegTradicional)){
											if($total_distribuidoras>0){
												for ($i=0;$i<$total_distribuidoras;$i++){
													$columna=21+$i;
													$distribuidora_d=utf8_encode($data[$columna]);
													if(!empty($distribuidora_d)){
														$idDistribuidora=$this->model->obtener_iddistribuidora($distribuidora_d)->row_array();
														if(!empty($idDistribuidora['idDistribuidoraSucursal'])){
															$this->model->insertar_segmentacion_tradicional_detalle($idSegTradicional,$idDistribuidora['idDistribuidoraSucursal']);
														}
													}
												}
											}
										}
										//	$idSegTradicional['idSegClienteTradicional']=$this->insert_id();
											
										
									}
									else if($canal_carga==2){
										$banner = utf8_encode($data[21]);
										$idSegModerno = $this->model->validar_segmentacion_moderno($banner)->row_array();
									}
									
									if(!empty($idSegNegocio['idSegNegocio']) || !empty($idSegTradicional) ){
										$insert= array(
											'nombreComercial'=>$data[0],
											'razonSocial'=>$data[1],
											'ruc'=>$data[2],
											'dni'=>$data[3],
											'direccion'=>$data[7],
										); 
										
										$this->db->insert("{$this->sessBDCuenta}.trade.cliente_pg_v1",$insert);
										$id = $this->db->insert_id();
										
										
										$insert_d=array(
											'idClientePg'=>$id,
											'nombreComercial'=>$data[0],
											'razonSocial'=>$data[1],
											'idSegNegocio'=>$idSegNegocio['idSegNegocio'],
											'fecIni'=>$data[14],
											'idCuenta'=>3,
											'idProyecto'=>3,
											'flagCartera'=>1,
											'direccion'=>$data[7],
											'referencia'=>$data[8],
											'latitud'=>$data[9],
											'longitud'=>$data[10],
											'idZonaPeligrosa'=>$data[11],
											'codCliente'=>$data[12],
										); 
										
										if($canal_carga==2){
											$insert_d['idSegClienteModerno']=$idSegModerno['idSegClienteModerno'];
										}elseif($canal_carga==1){
											$insert_d['idSegClienteTradicional']=$idSegTradicional;
										}
										$this->db->insert("{$this->sessBDCuenta}.trade.cliente_pg_historico_v1",$insert_d);
										
										$this->model->actualizar_procesados($idCarga);
									}
								
								$cont++;
								
								
							}
						}

						fclose($handle_body);
					}
				} 
				$this->model->actualizar_estado_carga($idCarga);
				$i++;
			}
			
			closedir($directorio_INS);
			clearstatcache();
		}
		
		///
		
		
	}
	
	public function estado_carga(){
		
		$resultados = $this->model->estado_carga()->result_array();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['totalProcesados'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$i++;
		}
		
		$result=array();
		$result['data']= $data_carga;
		
		echo json_encode($result);
	}
	
	
	
	public function procesar_visitas(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->obtener_carpetas_visitas();
		///
		foreach($carpetas as $row){
			$ruta = 'public/csv/visitas/'.$row['carpeta'];
			$rutaFiles = 'public/csv/visitas/'.$row['carpeta'].'/archivos/';
			$directorio_INS = opendir($rutaFiles);
			$arrayBody=array();
			$idTipoUsuario=$row['idTipoUsuario'];
			$idCarga=$row['idCarga'];
			//$totalRegistros=$row['totalRegistros'];
			
			//$this->model->actualizar_clientes($idCarga,$totalRegistros);
			
			$i=0;
			$j=0;
			while (false !== ($archivo_INS = readdir($directorio_INS))){
				if ($archivo_INS != '.' && $archivo_INS != '..') {
					if(is_file($rutaFiles.$archivo_INS)) {
						$rutaCSV = $rutaFiles.$archivo_INS;
						$fp = fopen($rutaCSV, "r");
						while (!feof($fp)){
							$csvHeader = fgets($fp);
							break;
						}
						fclose($fp);

						$delimiter = $this->delimiter_exists($csvHeader, ',') ? ',' : ';'; 
						$handle_body = fopen($rutaCSV, "r");
						$header_=0;

						$indice=-2;
						$total_columna=0;

						$codigoElemento=array();
						while (($data = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) { $header_++; $indice++;
							if($header_==1){
								$total_columna=count($data);
							}
							if($header_!=1){
								$cont =0;
									$fecha = utf8_encode($data[0]);
									$idUsuario = utf8_encode($data[1]);
									$idCliente = utf8_encode($data[2]);
									$mensaje='';
									$validar_cliente = $this->model->validar_cliente($idTipoUsuario,$idCliente,$fecha);
									$validar_usuario = $this->model->validar_usuario($idTipoUsuario,$idUsuario,$fecha);
									$validar_visita = $this->model->validar_visita($idTipoUsuario,$idCliente,$idUsuario,$fecha);
									if(count($validar_cliente)==0){
										$mensaje = 'Cliente no cuenta con historico activo para la fecha indicada.';
									}else if(count($validar_usuario)==0){
										$mensaje = 'Usuario no registrado en base de datos.';
									}else if(count($validar_visita)>0){
										$mensaje = 'Ya cuenta con una visita registrada en la fecha indicada.';
									}else{
										$idRuta = $this->model->obtener_ruta($idUsuario,$fecha);
										if(!empty($idRuta['idRuta'])){
											$idRuta_i = $idRuta['idRuta'];
										}else{
											$array = array();
											$array = array(
												'idUsuario'=>$idUsuario,
												'fecha'=>$fecha,
											);
											$this->model->registrar_detalle("{$this->sessBDCuenta}.trade.data_ruta",$array);
											
											$idRuta_i = $this->db->insert_id();
											
										}
										
										$array = array();
										$array = array(
											'idRuta'=>$idRuta_i,
											'idCliente'=>$idCliente,
										);
										$this->model->registrar_detalle("{$this->sessBDCuenta}.trade.data_visita",$array);
									}
									
									$array =array (
										'fecha' => $fecha,
										'idEmpleado' => $idUsuario,
										'idCliente' => $idCliente,
										'idCarga' => $idCarga,
										'comentario' => $mensaje
									);
									$this->model->registrar_detalle("{$this->sessBDCuenta}.trade.cargaProgramacionRutasDet",$array);
														
								$cont++;
							}
						}
						
						fclose($handle_body);
					}
				} 
				$this->model->actualizar_estado_carga_visita($idCarga);
				$i++;
			}
			
			closedir($directorio_INS);
			clearstatcache();
		}
		
		///
		
		
	}
	
	
	public function procesar_exclusiones(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->obtener_carpetas_exclusiones();
		///
		foreach($carpetas as $row){
			$ruta = 'public/csv/exclusiones/'.$row['carpeta'];
			$rutaFiles = 'public/csv/exclusiones/'.$row['carpeta'].'/archivos/';
			$directorio_INS = opendir($rutaFiles);
			$arrayBody=array();
			$idTipoUsuario=$row['idTipoUsuario'];
			$idCarga=$row['idCarga'];

			$i=0;
			$j=0;
			while (false !== ($archivo_INS = readdir($directorio_INS))){
				if ($archivo_INS != '.' && $archivo_INS != '..') {
					if(is_file($rutaFiles.$archivo_INS)) {
						$rutaCSV = $rutaFiles.$archivo_INS;
						$fp = fopen($rutaCSV, "r");
						while (!feof($fp)){
							$csvHeader = fgets($fp);
							break;
						}
						fclose($fp);

						$delimiter = $this->delimiter_exists($csvHeader, ',') ? ',' : ';'; 
						$handle_body = fopen($rutaCSV, "r");
						$header_=0;

						$indice=-2;
						$total_columna=0;

						$codigoElemento=array();
						while (($data = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) { $header_++; $indice++;
							if($header_==1){
								$total_columna=count($data);
							}
							if($header_!=1){
								$cont =0;
									$fecha = utf8_encode($data[0]);
									$idUsuario = utf8_encode($data[1]);
									$idCliente = utf8_encode($data[2]);
									$mensaje='';
									$validar_visita = $this->model->validar_visita_exclusion($idTipoUsuario,$idCliente,$idUsuario,$fecha);
									if(count($validar_visita)==0){
										$mensaje = 'No existe la visita.';
									}else {
										$idVisita = $validar_visita['idVisita'];
									
										$data = array();
									
										$data = array(
										   'comentarioExclusion' => 'Excluido',
										   'idTipoExclusion' => 2,
										  
										);

										$this->db->where('idVisita', $idVisita);
										$this->db->update("{$this->sessBDCuenta}.trade.data_visita", $data);
									}
									
									$array =array (
										'fecha' => $fecha,
										'idEmpleado' => $idUsuario,
										'idCliente' => $idCliente,
										'idCarga' => $idCarga,
										'comentario' => $mensaje
									);
									$this->model->registrar_detalle("{$this->sessBDCuenta}.trade.cargaExclusionesRutasDet",$array);
														
								$cont++;
							}
						}
						
						fclose($handle_body);
					}
				} 
				$this->model->actualizar_estado_carga_exclusion($idCarga);
				$i++;
			}
			
			closedir($directorio_INS);
			clearstatcache();
		}
		
		///
		
		
	}

}

?>