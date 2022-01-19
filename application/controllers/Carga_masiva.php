<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Carga_masiva extends CI_Controller
{
	public $sessBDCuenta="";
	public function __construct(){
		parent::__construct();
		$this->load->model('m_carga_masiva','model');
	}

	public function procesar_archivos(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->obtener_carpetas();
		foreach($carpetas as $row){
			$this->cambiarBaseDatos($row['idCuenta']);
			$ruta = 'public/csv/modulacion/'.$row['carpeta'];
			$rutaFiles = 'public/csv/modulacion/'.$row['carpeta'].'/archivos/';
			$directorio_INS = opendir($rutaFiles);
			$arrayBody=array();
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
								$m=0;
								while($m<$total_columna){
									if($m!=0 && $m!=1){
									$res=$this->model->obtener_codigo_elemento(utf8_encode($data[$m]))->row_array();
										if(isset($res['idElementoVis'])){
											$codigoElemento[$m]=$res['idElementoVis'];
										}else{
											$error = array(
												  'idCarga'		=>$row['idCarga']
												, 'descripcion'	=>utf8_encode($data[$m])
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.cargaModulacionElementosError",$error);
										}
									}
									$m++;
								}
							}
							else if($header_!=1){
								$m=0;
								$cont =0;
								while($m<$total_columna){
									if($m!=0 && $m!=1){
										$validar_cliente="SELECT * FROM trade.cliente WHERE idCliente = ".$data[1];
										$res = $this->db->query($validar_cliente)->row_array();
										if(count($res)>0){
											if($data[$m]>0){
												if(!empty($codigoElemento[$m])){
													$arrayBody[$j]['idCarga'] = $row['idCarga'];
													$arrayBody[$j]['idCliente'] = $data[1];
													$arrayBody[$j]['idElemento']=$codigoElemento[$m];
													$arrayBody[$j]['cantidad']=$data[$m];
												}
												$j++;
												$cont++;
											}else if(!empty($data[$m])){
												if(!is_numeric()){
													$insert = "INSERT INTO {$this->sessBDCuenta}.trade.cargaModulacionClientesNoProcesados(idCarga,idCliente,tipoError,elemento,datoIngresado) VALUES (
														'".$row['idCarga']."' ,
														'".$data[1]."' ,
														'Dato no valido.',
														'".$codigoElemento[$m]."',
														'".$data[$m]."'
														)
														";
													$this->db->query($insert);
													$cont++;
												}
											}
										}else{
											$select = "SELECT * FROM {$this->sessBDCuenta}.trade.cargaModulacionClientesNoProcesados WHERE idCarga= '".$row['idCarga']."'
											AND idCliente= '".$data[1]."' ";
											$validar = $this->db->query($select)->result_array();
											if(count($validar)==0){
											$insert = "insert into {$this->sessBDCuenta}.trade.cargaModulacionClientesNoProcesados(idCarga,idCliente,tipoError) VALUES (
												'".$row['idCarga']."' ,
												'".$data[1]."' ,
												'Cliente no registrado en base de datos.' )
												";
											$this->db->query($insert);
											$cont++;
											}
										}
									}
									$m++;
									
								}
								if($cont==0){
									$insert = "insert into {$this->sessBDCuenta}.trade.cargaModulacionClientesNoProcesados(idCarga,idCliente,tipoError) VALUES (
												'".$row['idCarga']."' ,
												'".$data[1]."' ,
												'Cliente sin elementos.' )
												";
									$this->db->query($insert);
								}
								
								
							}
						}
						if(count($arrayBody)>0){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cargaModulacionDet", $arrayBody); 
						}
						fclose($handle_body);
					}
				} 
				$i++;
			}
			
			closedir($directorio_INS);
			clearstatcache();
		}
		
		$data = $this->model->carga_modulacion()->result_array();
		if(count($data)>0){
		$array_cabecera=array();
		$array_detalle=array();
		$idCarga='';
		foreach($data as $row){
			
			$array_cabecera[$row['idCliente']]['idCliente']=$row['idCliente'];
			$array_cabecera[$row['idCliente']]['idPermiso']=$row['idPermiso'];
			$array_cabecera[$row['idCliente']]['fecIni']=$row['fecIni'];
			$array_cabecera[$row['idCliente']]['fecFin']=$row['fecFin'];
			$array_detalle[$row['idCliente']][$row['idElemento']]['idElementoVis']=$row['idElemento'];
			$array_detalle[$row['idCliente']][$row['idElemento']]['cantidad']=$row['cantidad'];
			$array_detalle[$row['idCliente']][$row['idElemento']]['idCargaDet']=$row['idCargaDet'];
			$idCarga=$row['idCarga'];		
			$array_cabecera[$row['idCliente']]['idCargaDet']=$row['idCargaDet'];		
		}
		
		$total_clientes_ = "
			
			SELECT 
				count(*) total 
			FROM 
				( 

			select DISTINCT idCliente from {$this->sessBDCuenta}.trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga= $idCarga 
			UNION
			select DISTINCT idCliente from {$this->sessBDCuenta}.trade.cargaModulacionDet WHERE idCarga=$idCarga 

			)a
		";
		$res = $this->db->query($total_clientes_)->row_array();
		$update_clientes = "UPDATE {$this->sessBDCuenta}.trade.cargaModulacion SET totalClientes='".$res['total']."',finRegistro=getdate() WHERE idCarga= $idCarga ";
		$this->db->query($update_clientes);
		foreach($array_cabecera as $row => $value){
			$array = array(
				'idCliente'=>$value['idCliente'],
				'idPermiso'=>$value['idPermiso'],
				'fecIni'=>$value['fecIni'],
				'fecFin'=>$value['fecFin'],
			);
			$this->db->insert("{$this->sessBDCuenta}.trade.master_modulacion", $array);
			$id = $this->db->insert_id();
			foreach($array_detalle[$row] as $row_d => $value_d){
				$array_d = array(
					'idModulacion'=>$id,
					'idElementoVis'=>$value_d['idElementoVis'],
					'cantidad'=>$value_d['cantidad']
				);
				$this->db->insert("{$this->sessBDCuenta}.trade.master_modulacionDet", $array_d);
				$total_clientes = "SELECT count(*) total FROM (
								select DISTINCT idCliente from {$this->sessBDCuenta}.trade.cargaModulacionDet WHERE estado=0 AND idCarga= $idCarga 
								)a";
				$res = $this->db->query($total_clientes)->row_array();
				$update_det = "UPDATE {$this->sessBDCuenta}.trade.cargaModulacionDet SET estado=0 WHERE idCargaDet= ".$value_d['idCargaDet']." ";
				$this->db->query($update_det);
				$update = "UPDATE {$this->sessBDCuenta}.trade.cargaModulacion SET total_procesados='".$res['total']."',finRegistro=getdate() WHERE idCarga= $idCarga ";
				$this->db->query($update);
				
			}
		}
		$update = "UPDATE {$this->sessBDCuenta}.trade.cargaModulacion SET estado=0  WHERE idCarga= $idCarga ";
		
		$this->db->query($update); 
		
		}
	}

	public function delimiter_exists($csvHeader, $delimiter){
		return (bool)preg_match("/$delimiter/", $csvHeader); 
	}

	function eliminar_acentos($cadena){
		
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


	public function procesar_archivos_rutas($idCuenta){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$this->cambiarBaseDatos($idCuenta);
		$carpetas = $this->model->carga_ruta_no_procesado()->result_array();

		if(count($carpetas)>0){
			//marcar en proceso
			foreach($carpetas as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['procesado']=1;
				$this->model->update_carga_ruta($where,$params);
			}

			//convertir a detalle
			foreach($carpetas as $row){
				if( empty($row['totalClientes']) || $row['totalClientes']=='0' ){
					$this->cambiarBaseDatos($row['idCuenta']);


					$ruta = 'public/csv/rutas/'.$row['carpeta'];
					$rutaFiles = 'public/csv/rutas/'.$row['carpeta'].'/archivos/';
					$directorio_INS = opendir($rutaFiles);
					$arrayBody=array();
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
								while (($data = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) { 
									$arrayBody=array();
									$j=0;
									$header_++; $indice++;
									if($header_!=1){
										$total_columna=count($data);
										$m=0; 
										$cont =0;
	
	
										//validacion usuario
										if(empty($data[1])){
											$insert=array();
	
											$insert['idCarga']=$row['idCarga'];
											($data[2]!=null)? ( is_numeric($data[2])? $insert['idCliente']=$data[2] :null ) : null;
											$insert['tipoError']='Dato no valido.';
											$insert['datoIngresado']="NO SE INSERTÓ EL ID USUARIO";
	
											$this->model->insertar_carga_ruta_no_procesado($insert);
											$cont++;
											continue;
										}
										else{
											if(!is_numeric($data[1])){
												$insert=array();
	
												$insert['idCarga']=$row['idCarga'];
												($data[2]!=null)? ( is_numeric($data[2])? $insert['idCliente']=$data[2] :null ) : null;
												$insert['tipoError']='Dato no valido.';
												$insert['datoIngresado']="El idUsuario: {$data[1]} no es válido";
	
												$this->model->insertar_carga_ruta_no_procesado($insert);
												$cont++;
												continue;
											}
											else{
												$params = [
													'idUsuario' => $data[1],
													'idProyecto'=> $row['idProyecto'],
													'fecIni' => $row['fecIni'],
													'fecFin' => $row['fecFin'],
													'idTipoUsuario'=> $row['idTipoUsuario'],
												];
												$validar_usuario = $this->model->validar_usuario_historico($params);
												if($validar_usuario){
													$arrayBody[$j]['idUsuario']=$data[1];
												}else{
													$insert=array();
	
													$insert['idCarga']=$row['idCarga'];
													($data[2]!=null)? ( is_numeric($data[2])? $insert['idCliente']=$data[2] :null ) : null;
													$insert['tipoError']="Por favor verifique que el usuario {$data[1]} tenga un histórico activo con el Proyecto({$row['idProyecto']}) y Tipo de Usuario({$row['idTipoUsuario']}) indicados";
													$insert['datoIngresado']=$data[1];
	
													$this->model->insertar_carga_ruta_no_procesado($insert);
													$cont++;
													continue;
												}
											}
										}
	
										//validacion cliente
										if(empty($data[2])){
											$insert=array();
	
											$insert['idCarga']=$row['idCarga'];
											($data[1]!=null)? ( is_numeric($data[1])? $insert['idUsuario']=$data[1] :null ) : null;
											$insert['tipoError']='COD CLIENTE NO INGRESADO.';
											$insert['datoIngresado']="NO SE INSERTÓ EL COD CLIENTE";
	
											$this->model->insertar_carga_ruta_no_procesado($insert);
											$cont++;
											continue;
										}
										else{
											if(!is_numeric($data[2])){
												$insert=array();
	
												$insert['idCarga']=$row['idCarga'];
												($data[1]!=null)? ( is_numeric($data[1])? $insert['idUsuario']=$data[1] :null ) : null;
												$insert['tipoError']='COD CLIENTE NO VÁLIDO.';
												$insert['datoIngresado']="EL COD CLIENTE: {$data[2]} NO ES VÁLIDO";
	
												$this->model->insertar_carga_ruta_no_procesado($insert);
												$cont++;
												continue;
											}
											else{
	
												$validar_cliente="SELECT * FROM trade.cliente WHERE idCliente = ".$data[2];
												$res = $this->db->query($validar_cliente)->row_array();
												if(count($res)>0){
													$arrayBody[$j]['idCliente']=$data[2];
												}else{
													$insert=array();
	
													$insert['idCarga']=$row['idCarga'];
													($data[1]!=null)? ( is_numeric($data[1])? $insert['idUsuario']=$data[1] :null ) : null;
													$insert['tipoError']='No encontrado.';
													$insert['datoIngresado']=$data[2];
	
													$this->model->insertar_carga_ruta_no_procesado($insert);
													$cont++;
													continue;
												}
											}
										}
	
										$arrayBody[$j]['nombreRuta']=$data[0];
										$arrayBody[$j]['lunes']=$data[3];
										$arrayBody[$j]['martes']=$data[4];
										$arrayBody[$j]['miercoles']=$data[5];
										$arrayBody[$j]['jueves']=$data[6];
										$arrayBody[$j]['viernes']=$data[7];
										$arrayBody[$j]['sabado']=$data[8];
										$arrayBody[$j]['domingo']=$data[9];
										$arrayBody[$j]['idCarga'] = $row['idCarga'];
										$arrayBody[$j]['estado'] =1;
	
										$j++;
										$cont++;
	
									}

									if(count($arrayBody)>0){
										$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cargaRutaDet", $arrayBody); 
		
										$params =array();
										$params['idCarga']=$row['idCarga'];
										$this->model->update_carga_ruta_clientes_count($params);
									}
										
								}
								
								fclose($handle_body);
							}
						} 
						$i++;
					}
					
					closedir($directorio_INS);
					clearstatcache();
					//update carga ruta
					
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_ruta_clientes_count($params);
				}else{
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_ruta_clientes_count($params);
				}
			}
		}
		

		//transferir a tablas
		$data = $this->model->carga_ruta()->result_array();
		if(count($data)>0){


			//marcar estado 0
			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['estado']=0;
				$this->model->update_carga_ruta($where,$params);
			}

			$array_detalle=array();
			
			foreach($data as $row){
				if($row['totalClientes']>0 && ( empty($row['total_procesados']) || $row['total_procesados']=='0' )){
					$this->cambiarBaseDatos($row['idCuenta']);

					if($row['generado']==1){


						$data_ruta_visitas_prog = $this->model->obtener_ruta_programada_visitas_clientes($row['idCarga']);
						
						if($data_ruta_visitas_prog!=null){
							if( count($data_ruta_visitas_prog)>0){
								
								$cont_visitas=0;
								foreach($data_ruta_visitas_prog as $r){

									
									$data_ruta_visitas_prog_visitas = $this->model->obtener_ruta_programada_visitas($row['idCarga'],$r['idCliente']);
									if($data_ruta_visitas_prog_visitas!=null){
										if( count($data_ruta_visitas_prog_visitas)>0){

											foreach($data_ruta_visitas_prog_visitas as $r_d){

												$params=array();
												$params['idCuenta']=$row['idCuenta'];
												$params['idProyecto']=$row['idProyecto'];
												$params['fecha']=$r_d['fecha'];
												$params['idCliente']=$r['idCliente'];
												$params['idUsuario']=$r_d['idUsuario'];
												$params['idTipoUsuario'] = $row['idTipoUsuario'];
						
												$res=$this->model->insertar_visita_ruta($params);
											}
										}
									}
									$cont_visitas++;

									$where =array();
									$where['idCarga']=$row['idCarga'];
									$params =array();
									$params['total_procesados']=$cont_visitas;
									$this->model->update_carga_ruta($where,$params);
									
								}



								$where =array();
								$where['idCarga']=$row['idCarga'];
								$params =array();
								$params['estado']=0;
								$this->model->update_carga_ruta($where,$params);

								$this->model->update_carga_ruta_fecha($where);
							}
						}


						

					}else{
						//GENERAR LAS VISITAS

						$params=array();
						$cont_visitas=0;
						$params['idCarga']=$row['idCarga'];
						//
						$data_det = $this->model->carga_ruta_det($params)->result_array();
						foreach($data_det as $row_det){
							$array_detalle[$row_det['nombreRuta']][$row_det['idUsuario']][$row_det['idCliente']]=$row_det;
						}

						foreach($array_detalle as  $value_nombre => $row_d){

							//insert master_rutaProgramada
							$insert_ruta = array(
								'nombreRuta' => $value_nombre
								,'fecIni' =>  $row['fecIni']
								,'numClientes'=>0
								,'generado'=> $row['generado']
							);
							if(!empty($row['fecFin'])){
								$insert_ruta['fecFin'] = $row['fecFin'];
							}
							$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramada",$insert_ruta);
							$idRutaProg = $this->db->insert_id();

							//insert master_rutaProgramadaDet
							
							foreach($array_detalle[$value_nombre] as  $value_idUsuario  => $row_dn){

								$insert_gtm = array(
								'idRutaProg' => $idRutaProg
								, 'fecIni' => $row['fecIni']
								, 'idUsuario' => $value_idUsuario
								);
								if(!empty($row['fecFin'])){
									$insert_gtm['fecFin'] = $row['fecFin'];
								}
								$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramadaDet",$insert_gtm);
								//$idRutaProgDet = $this->db->insert_id();

								
								foreach($array_detalle[$value_nombre][$value_idUsuario] as $value_idCliente => $row_dc){

									//insert master_visitaProgramada
									$insert_visita = array(
										'idRutaProg' => $idRutaProg
										, 'idCliente' => $value_idCliente
									);
									$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada", $insert_visita);
									$idVisitaProg = $this->db->insert_id();

										$lunes = isset($row_dc['lunes'])? $row_dc['lunes'] : '';
										$martes = isset($row_dc['martes'])?$row_dc['martes']:'';
										$miercoles = isset($row_dc['miercoles'])?$row_dc['miercoles']:'';
										$jueves = isset($row_dc['jueves'])?$row_dc['jueves']:'';
										$viernes = isset($row_dc['viernes'])?$row_dc['viernes']:'';
										$sabado = isset($row_dc['sabado'])?$row_dc['sabado']:'';
										$domingo = isset($row_dc['domingo'])?$row_dc['domingo']:'';

										//insert master_visitaProgramadaDet
										if(!empty($lunes) && $lunes>=1 ){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' => 1
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}

										if(!empty($martes) && $martes>=1){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' => 2
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}
							
										if(!empty($miercoles) && $miercoles>=1 ){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' => 3
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}
									
										if(!empty($jueves) && $jueves>=1 ){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' => 4
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}
									
										if(!empty($viernes ) && $viernes>=1){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' => 5
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}

										if(!empty($sabado) && $sabado>=1){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' => 6
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}

										if(!empty($domingo) && $domingo>=1 ){
											$insert_visitaDet = array(
												'idVisitaProg' => $idVisitaProg
												, 'idDia' =>7
											);
											$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
										}

										$cont_visitas++;

										//actualizar contador 

										if($row['generado']!=1){
											$where =array();
											$where['idCarga']=$row['idCarga'];
											$params =array();
											$params['total_procesados']=$cont_visitas;
											$this->model->update_carga_ruta($where,$params);
										}
								}
								//$cont_visitas+=count($array_detalle[$value_nombre][$value_idUsuario]);
							}

						}

						$where =array();
						$where['idCarga']=$row['idCarga'];
						$params =array();
						$params['estado']=0;
						$this->model->update_carga_ruta($where,$params);
						$this->model->update_carga_ruta_fecha($where);
					}
				}
			}
		
	 
		}

	}

	public function procesar_archivos_permisos(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->carga_permiso_no_procesado()->result_array();

		// if(count($carpetas)>0){
		// 	//marcar en proceso
		// 	foreach($carpetas as $row){
		// 		$this->cambiarBaseDatos($row['idCuenta']);
		// 		$where =array();
		// 		$where['idCarga']=$row['idCarga'];
		// 		$params =array();
		// 		$params['procesado']=1;
		// 		$this->model->update_carga_permiso($where,$params);
		// 	}

		// 	//convertir a detalle
		// 	foreach($carpetas as $row){
		// 		if( empty($row['totalClientes']) || $row['totalClientes']=='0' ){
		// 			$this->cambiarBaseDatos($row['idCuenta']);
		// 			$ruta = 'public/csv/permisos/'.$row['carpeta'];
		// 			$rutaFiles = 'public/csv/permisos/'.$row['carpeta'].'/archivos/';
		// 			$directorio_INS = opendir($rutaFiles);
		// 			$arrayBody=array();
		// 			$i=0;
		// 			$j=0;

		// 			$count_elementos=0;
				
		// 			while (false !== ($archivo_INS = readdir($directorio_INS))){
		// 				if ($archivo_INS != '.' && $archivo_INS != '..') {
		// 					if(is_file($rutaFiles.$archivo_INS)) {
		// 						$rutaCSV = $rutaFiles.$archivo_INS;
		// 						$fp = fopen($rutaCSV, "r");
		// 						while (!feof($fp)){
		// 							$csvHeader = fgets($fp);
		// 							break;
		// 						}
		// 						fclose($fp);
		
		// 						$delimiter = $this->delimiter_exists($csvHeader, ',') ? ',' : ';'; 
		// 						$handle_body = fopen($rutaCSV, "r");
		// 						$header_=0;
		
		// 						$indice=-2;
		// 						$total_columna=0;
		
		// 						$codigoElemento=array();
		// 						while (($data = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) {
		// 							$j=0;
		// 							$arrayBody=array();
		// 							 $header_++; $indice++;
		// 							if($header_==1){
		// 								$total_columna=count($data);
		// 								$m=0;
		// 								while($m<$total_columna){
		// 									if($m!=0 ){
		// 									$res=$this->model->obtener_codigo_elemento($data[$m])->row_array();
		// 										if(isset($res['idElementoVis'])){
		// 											$codigoElemento[$m]=$res['idElementoVis'];
		// 										}else{
		// 											$error = array(
		// 												  'idCarga'		=>$row['idCarga']
		// 												, 'tipoError'	=>$data[$m]
		// 											);
		// 											$this->db->insert("{$this->sessBDCuenta}.trade.cargaPermisoElementoNoProcesados",$error);
		// 										}
		// 									}
		// 									$m++;
		// 								}
		// 							}
		// 							else if($header_!=1){
		// 								$m=0;
		// 								$cont =0;
		// 								while($m<$total_columna){
		// 									if($m!=0 ){
		// 										$validar_cliente="SELECT * FROM trade.cliente WHERE idCliente = ".$data[0];
		// 										$res = $this->db->query($validar_cliente)->row_array();
		// 										if(count($res)>0){
		// 											if($data[$m]>0){
		// 												if(!empty($codigoElemento[$m])){
		// 													$arrayBody[$j]['idCarga'] = $row['idCarga'];
		// 													$arrayBody[$j]['idCliente'] = $data[0];
		// 													$arrayBody[$j]['idElemento']=$codigoElemento[$m];
		// 													$arrayBody[$j]['cantidad']=$data[$m];
		// 												}
		// 												$j++;
		// 												$cont++;
		// 											}else if(!empty($data[$m])){
		// 												if(!is_numeric()){
		// 													$insert = "insert into {$this->sessBDCuenta}.trade.cargaPermisoClienteNoProcesados(idCarga,idCliente,tipoError,elemento,datoIngresado) VALUES (
		// 														'".$row['idCarga']."' ,
		// 														'".$data[0]."' ,
		// 														'Dato no valido.',
		// 														'".$codigoElemento[$m]."',
		// 														'".$data[$m]."'
		// 														)
		// 														";
		// 													$this->db->query($insert);
		// 													$cont++;
		// 												}
		// 											}
		// 										}else{
		// 											$select = "SELECT * FROM {$this->sessBDCuenta}.trade.cargaPermisoClienteNoProcesados WHERE idCarga= '".$row['idCarga']."'
		// 											AND idCliente= '".$data[0]."' ";
		// 											$validar = $this->db->query($select)->result_array();
		// 											if(count($validar)==0){
		// 											$insert = "insert into {$this->sessBDCuenta}.trade.cargaPermisoClienteNoProcesados(idCarga,idCliente,tipoError) VALUES (
		// 												'".$row['idCarga']."' ,
		// 												'".$data[0]."' ,
		// 												'Cliente no registrado en base de datos.' )
		// 												";
		// 											$this->db->query($insert);
		// 											$cont++;
		// 											}
		// 										}
		// 									}
		// 									$m++;
											
		// 								}
		// 								if($cont==0){
		// 									$insert = "insert into {$this->sessBDCuenta}.trade.cargaPermisoClienteNoProcesados(idCarga,idCliente,tipoError) VALUES (
		// 												'".$row['idCarga']."' ,
		// 												'".$data[0]."' ,
		// 												'Cliente sin elementos.' )
		// 												";
		// 									$this->db->query($insert);
		// 								}
										
										
		// 							}

		// 							if(count($arrayBody)>0){
		// 								$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cargaPermisoDet", $arrayBody); 
	
		// 								$params =array();
		// 								$params['idCarga']=$row['idCarga'];
		// 								$this->model->update_carga_permiso_clientes_count($params);
		// 							}

									
		// 						}

								
		// 						fclose($handle_body);
		// 					}
		// 				} 
		// 				$i++;
		// 			}
					
		// 			closedir($directorio_INS);
		// 			clearstatcache();
		// 			//update carga ruta
					
		// 			$params =array();
		// 			$params['idCarga']=$row['idCarga'];
		// 			$this->model->update_carga_permiso_clientes_count($params);
		// 		}else{
		// 			$params =array();
		// 			$params['idCarga']=$row['idCarga'];
		// 			$this->model->update_carga_permiso_clientes_count($params);
		// 		}
		// 	}
		// }


		$data = $this->model->carga_permiso()->result_array();
	
		if(count($data)>0){
			//marcar estado 0
			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['estado']=0;
				$this->model->update_carga_permiso($where,$params);
			}


			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$params=array();
				$params['idCarga']=$row['idCarga'];
				$data_det_cliente = $this->model->carga_permisos_det_clientes($params)->result_array();

				$cont_clientes=0;
				foreach($data_det_cliente as $row_d){

					$inputCliente=array();
					$inputCliente['idCliente'] = $row_d['idCliente'];
					$inputCliente['idCuenta'] = $row['idCuenta'];
					$rs_cliente = $this->model->obtener_cliente($inputCliente);

					if($rs_cliente!=null){
						$clienteNombre = $rs_cliente[0]['cliente'];
						$idGrupoCanal = ( (isset($rs_cliente[0]['idGrupoCanal']) && !empty($rs_cliente[0]['idGrupoCanal'])) ? $rs_cliente[0]['idGrupoCanal']:NULL );
						
						$arrayCabecera=array();
						$arrayCabecera['fecIni'] = $row['fecIniLista'];
						$arrayCabecera['fecFin'] = $row['fecFinLista'];
						$arrayCabecera['idCliente'] = $row_d['idCliente'];
						$arrayCabecera['idProyecto'] = $row['idProyecto'];
						$arrayCabecera['idGrupoCanal'] = $idGrupoCanal;

						//VERIFICAMOS TIPO DE ELEMENTOS
						//TIPO 1 ==> ELEMENTOS OBLIGATORIOS
						$input=array();
						$input['idTipoElemento'] = 1;
						$input['idCarga'] = $row['idCarga'];
						$input['idCliente'] = $row_d['idCliente'];
						$rs_obtenerElementos = $this->model->obtener_carga_permiso_elemento_tipo($input);
						//VERIFICAMOS QUE EXISTA DATA PARA LOS ELEMENTOS OBLIGATORIOS
						//CREAMOS LA LISTA DE VISIBILIDAD TRADICIONAL
						
						if (!empty($rs_obtenerElementos)) {
							if( !empty($row['auditoria']) ){
								$aProyectos = $this->model->lista_proyectosAuditoria([ 'idProyecto' => $row['idProyecto'] ]);
								foreach($aProyectos as $vproyecto){
									$aCabecera = [
										'fecIni' => $row['fecIniLista'],
										'fecFin' => $row['fecFinLista'],
										'idCliente' => $row_d['idCliente'],
										'idProyecto' => $vproyecto['idProyecto'],
										'idGrupoCanal' => $idGrupoCanal
									];

									//EXISTE ELEMENTOS DENTRO DE LA MODULACION
									$rs_verificarListaTradicional = $this->model->verificar_lista_tradicional($aCabecera);
			
									if (!empty($rs_verificarListaTradicional)) {
										//EXISTE UNA LISTA CON LA CABECERA
										$idListVisibilidad = $rs_verificarListaTradicional[0]['idListVisibilidadObl'];
			
										//ELIMINAMOS LOS DETALLES DE LA LISTA TRADICIONAL
										$rs_eliminarListaDet = $this->model->delete_lista_tradicional_detalle($idListVisibilidad);
			
										if ($rs_eliminarListaDet) {
											//FOREACH POR CADA ELEMENTO
											$arrayBody=array();
											$j=0;
											foreach ($rs_obtenerElementos as $kle => $elemento) {
												//OBTENEMOS EL ARRAY DETALLE DE LA LISTA
												$arrayBody[$j]['idListVisibilidadObl']=$idListVisibilidad;
												$arrayBody[$j]['idElementoVis']=$elemento['idElemento'];
												$j++;
											}
											$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.list_visibilidadTradOblDet", $arrayBody); 
										
										} 
									} else {
										//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
										$rs_listaTradicional = $this->model->insertar_lista_tradicional($aCabecera);
										$idListTradicionalInserted = $this->db->insert_id();

										if ($rs_listaTradicional) {
											//SE REGISTRO CORRECTAMENTE
											$arrayBody=array();
											$j=0;
											foreach ($rs_obtenerElementos as $kle => $elemento) {
												$arrayBody[$j]['idListVisibilidadObl']=$idListTradicionalInserted;
												$arrayBody[$j]['idElementoVis']=$elemento['idElemento'];
												$j++;
												
											}
											$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.list_visibilidadTradOblDet", $arrayBody); 
										}
									}
								}
							}
						}

						// GTM
						$input=array();
						$input['idTipoElemento'] = 1;
						$input['idCarga'] = $row['idCarga'];
						$input['idCliente'] = $row_d['idCliente'];
						$rs_obtenerElementos = $this->model->obtener_carga_permiso_elemento_tipo($input);

						if (!empty($rs_obtenerElementos)) {
							//EXISTE ELEMENTOS DENTRO DE LA MODULACION
							$rs_verificarListaTradicional = $this->model->verificar_lista_visibilidadTrad($arrayCabecera);
	
							if (!empty($rs_verificarListaTradicional)) {
								//EXISTE UNA LISTA CON LA CABECERA
								$idListVisibilidad = $rs_verificarListaTradicional[0]['idListVisibilidad'];
	
								//ELIMINAMOS LOS DETALLES DE LA LISTA TRADICIONAL
								$rs_eliminarListaDet = $this->model->delete_lista_visibilidadTradDet($idListVisibilidad);
	
								if ($rs_eliminarListaDet) {
									//FOREACH POR CADA ELEMENTO
									$arrayBody=array();
									$j=0;
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										//OBTENEMOS EL ARRAY DETALLE DE LA LISTA
										$arrayBody[$j]['idListVisibilidad']=$idListVisibilidad;
										$arrayBody[$j]['idElementoVis']=$elemento['idElemento'];
										$j++;
									}
									$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.list_visibilidadTradDet", $arrayBody); 
								
								} 
							} else {
								//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
								$rs_listaTradicional = $this->model->insertar_lista_visibilidadTrad($arrayCabecera);
								$idListVisibilidad = $this->db->insert_id();

								if ($rs_listaTradicional) {
									//SE REGISTRO CORRECTAMENTE
									$arrayBody=array();
									$j=0;
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										$arrayBody[$j]['idListVisibilidad']=$idListVisibilidad;
										$arrayBody[$j]['idElementoVis']=$elemento['idElemento'];
										$j++;
										
									}
									$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.list_visibilidadTradDet", $arrayBody); 
								}
							}
						}
						

						//TIPO 2 ==> ELEMENTOS INICIATIVAS
						$input=array();
						$input['idTipoElemento'] = 2;
						$input['idCarga'] = $row['idCarga'];
						$input['idCliente'] = $row_d['idCliente'];
						$rs_obtenerElementos = $this->model->obtener_carga_permiso_elemento_tipo($input);
	
						if (!empty($rs_obtenerElementos)) {
							//EXISTE ELEMENTOS
							$rs_verificarListaIniciativa = $this->model->verificar_lista_iniciativa($arrayCabecera);
							
							if (!empty($rs_verificarListaIniciativa)) {
								$idListVisibilidadIniSelected = $rs_verificarListaIniciativa[0]['idListVisibilidadIni'];

								$rs_eliminarListaDetElemento = $this->model->delete_lista_iniciativa_detalle_elementos($idListVisibilidadIniSelected);
								$rs_eliminarListaDet = $this->model->delete_lista_iniciativa_detallle($idListVisibilidadIniSelected);

								if ($rs_eliminarListaDet) {
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										$arrayDetalle=array();
										$arrayDetalle['idListVisibilidadIni'] = $idListVisibilidadIniSelected;
										$arrayDetalle['idElementoVis'] = $elemento['idElemento'];
	
										$rs_listaIniciativaDet = $this->model->insertar_lista_iniciativa_detalle($arrayDetalle);
									}
								} 
							} else {
								//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
								$rs_listaIniciativa = $this->model->insertar_lista_iniciativa($arrayCabecera);
	
								if ($rs_listaIniciativa) {
									$idListVisibilidadIni = $this->db->insert_id();
									foreach ($rs_obtenerElementos as $kle => $elemento) {
										$arrayDetalle=array();
										$arrayDetalle['idListVisibilidadIni'] = $idListVisibilidadIni;
										$arrayDetalle['idElementoVis'] = $elemento['idElemento'];
	
										$rs_listaIniciativaDet = $this->model->insertar_lista_iniciativa_detalle($arrayDetalle);
										
									}
	
								} 
							}
						} 
					}

					$cont_clientes++;
					$where =array();
					$where['idCarga']=$row['idCarga'];
					$params =array();
					$params['total_procesados']=$cont_clientes;
					$this->model->update_carga_permiso($where,$params);
					
				}
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$this->model->update_carga_permiso_fecha($where);
			}
		}
	}

	public function procesar_archivos_clientes(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		
		$carpetas = $this->model->carga_cliente_no_procesado()->result_array();

		if(count($carpetas)>0){
			//marcar en proceso
			foreach($carpetas as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['procesado']=1;
				$this->model->update_carga_cliente($where,$params);
			}

			//convertir a detalle
			foreach($carpetas as $row){
				if( empty($row['totalClientes']) || $row['totalClientes']=='0' ){
					$this->cambiarBaseDatos($row['idCuenta']);
	
					$ruta = 'public/csv/clientes/'.$row['carpeta'];
					$clienteFiles = 'public/csv/clientes/'.$row['carpeta'].'/archivos/';
					$directorio_INS = opendir($clienteFiles);
					$arrayBody=array();
					$i=0;
					$j=0;
					while (false !== ($archivo_INS = readdir($directorio_INS))){
						if ($archivo_INS != '.' && $archivo_INS != '..') {
							if(is_file($clienteFiles.$archivo_INS)) {
								$rutaCSV = $clienteFiles.$archivo_INS;
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
	
								$codigoElemento=array();

							
								$arrayBatch = array();
								while (($cliente = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) { 
									$arrayBatch = array();
									$j=0;
									$header_++; $indice++;
									if($header_!=1){
										$m=0; 
										$cont =0;
										$error=false;

										if(  strpos($cliente[0],',')!==false ){
											$cliente= explode(',',$cliente[0]); 
										} 
										///
										
										$nombreComercial = (isset($cliente[0]) && !empty($cliente[0])) ? trim($cliente[0]) : NULL;
									
										$razonSocial = (isset($cliente[1]) && !empty($cliente[1])) ? trim($cliente[1]) : NULL;
										$ruc = (isset($cliente[2]) && !empty($cliente[2])) ? trim($cliente[2]) : NULL;
										$dni = (isset($cliente[3]) && !empty($cliente[3])) ? trim($cliente[3]) : NULL;
								
						
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

										$frecuencia = (isset($cliente[16]) && !empty($cliente[16])) ? $cliente[16] : NULL;
											$idFrecuencia = $this->model->obtener_id_frecuencia($frecuencia);
											$idFrecuencia = ( !empty($idFrecuencia) ? $idFrecuencia[0]['idFrecuencia'] : NULL );

										$zona = (isset($cliente[17]) && !empty($cliente[17])) ? trim($cliente[17]) : NULL;
											$idZona = $this->model->obtener_id_zona($zona);
											$idZona = ( !empty($idZona) ? $idZona[0]['idZona'] : NULL ) ;
											
										
										$grupoCanal = (isset($cliente[18]) && !empty($cliente[18])) ? trim($cliente[18]) : NULL;
										$canal = (isset($cliente[19]) && !empty($cliente[19])) ? trim($cliente[19]) : NULL;
										$clienteTipo = (isset($cliente[20]) && !empty($cliente[20])) ? trim($cliente[20]) : NULL;

										if( empty($nombreComercial) ){

											$insert=array();
											$insert['idCarga']=$row['idCarga'];
											($nombreComercial!=null)? $insert['nombreComercial']=$nombreComercial :null ;
											($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
											$insert['tipoError']='La fila no contiene el Nombre Comercial.';
											$insert['datoIngresado']=$nombreComercial;
											$this->model->insertar_carga_cliente_no_procesado($insert);
											continue;
										}

										if( empty($fechaInicio) ){
											$insert=array();
											$insert['idCarga']=$row['idCarga'];
											($nombreComercial!=null)? $insert['nombreComercial']=$nombreComercial :null ;
											($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
											$insert['tipoError']='La fila no contiene la Fecha de Inicio.';
											$insert['datoIngresado']=$fechaInicio;
											$this->model->insertar_carga_cliente_no_procesado($insert);
											continue;
										}
										if( empty($grupoCanal) ){
											$insert=array();
											$insert['idCarga']=$row['idCarga'];
											($nombreComercial!=null)? $insert['nombreComercial']=$nombreComercial :null ;
											($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
											$insert['tipoError']='La fila no contiene el Grupo Canal.';
											$insert['datoIngresado']=$grupoCanal;
											$this->model->insertar_carga_cliente_no_procesado($insert);
											continue;
										}
										if( empty($canal) ){
											$insert=array();
											$insert['idCarga']=$row['idCarga'];
											($nombreComercial!=null)? $insert['nombreComercial']=$nombreComercial :null ;
											($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
											$insert['tipoError']='La fila no contiene el Canal.';
											$insert['datoIngresado']=$canal;
											$this->model->insertar_carga_cliente_no_procesado($insert);
											continue;
										}
										// if( empty($clienteTipo) ){
										// 	$insert=array();
										// 	$insert['idCarga']=$row['idCarga'];
										// 	($nombreComercial!=null)? $insert['nombreComercial']=$nombreComercial :null ;
										// 	($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
										// 	$insert['tipoError']='La fila no contiene el Cliente Tipo.';
										// 	$insert['datoIngresado']=$clienteTipo;
										// 	$this->model->insertar_carga_cliente_no_procesado($insert);
										// 	continue;
										// }


										//
										//VERIFICAMOS LA SEGMETACIÓN DEL CLIENTE
										$plaza=NULL; $dataDistribuidoraSucursal=NULL; 
										$cadena=NULL; $banner=NULL;

										if( $row['tipo']=="1"){
											//tradicionale
											//SEGMENTACIÓN CLIENTE TRADICIONAL
											$plaza = (isset($cliente[21]) && !empty($cliente[21])) ? trim($cliente[21]) : NULL;
											if ( count($cliente) > 23 ) {
												$dataDistribuidoraSucursal = array();
												for ($i=22; $i < count($cliente); $i++) { 
													if ( $cliente[$i] !== null ) array_push($dataDistribuidoraSucursal, trim($cliente[$i]));
												}
											} else {
												$dataDistribuidoraSucursal = (isset($cliente[22]) && !empty($cliente[22])) ? trim($cliente[22]) : NULL;
											}
			
										}else if($row['tipo']=="2"){
											//moderno
											$cadena = (isset($cliente[21]) && !empty($cliente[21])) ? trim($cliente[21]) : NULL;
											$banner = (isset($cliente[22]) && !empty($cliente[22])) ? trim($cliente[22]) : NULL;
			
										}else if($row['tipo']=="3"){

											$plaza = (isset($cliente[21]) && !empty($cliente[21])) ? trim($cliente[21]) : NULL;
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
												}
						
												//DETALLE DE LAS DISTRIBUDORAS SUCURSALES
												if (!empty($dataDistribuidoraSucursal)) {
													if (is_array($dataDistribuidoraSucursal)) {
														foreach ($dataDistribuidoraSucursal as $kdd => $value) {
															if($value!=";" && $value !=null){
																$rs_idDistribuidoraSucursal = $this->model->obtener_id_distribuidora_sucursal($value);
																if($rs_idDistribuidoraSucursal!=null){
																	$idDistribuidoraSucursal = $rs_idDistribuidoraSucursal[0]['idDistribuidoraSucursal'];
																	//INSERTAMOS EL DETALLE
																	$arrayDetalleDS=array();
																	$arrayDetalleDS['idSegClienteTradicional']=$idSegClienteTradicional;
																	$arrayDetalleDS['idDistribuidoraSucursal']=$idDistribuidoraSucursal;
																	//
																	$insertSegmentacionClienteTradicionalDetalle = $this->model->insert_segmentacion_cliente_tradicional_detalle($arrayDetalleDS);	
																}else{
																	$insert=array();
																	$insert['idCarga']=$row['idCarga'];
																	$insert['nombreComercial']=$nombreComercial ;
																	$insert['razonSocial']=$razonSocial;
																	$insert['tipoError']='No se pudo identificar la distribuidora sucursal.';
																	$insert['datoIngresado']=$value;
							
																	$this->model->insertar_carga_cliente_no_procesado($insert);
																	$error=true;
																}
															}
															
															
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

														}else{
															$insert=array();
															$insert['idCarga']=$row['idCarga'];
															$insert['nombreComercial']=$nombreComercial ;
															$insert['razonSocial']=$razonSocial;
															$insert['tipoError']='No se pudo identificar la distribuidora sucursal.';
															$insert['datoIngresado']=$value;
					
															$this->model->insertar_carga_cliente_no_procesado($insert);
															$error=true;

														}
													}
												}				
											}
										}

										if($error){
											continue;
										}



										$inputBusqueda=array();
										$inputBusqueda['razonSocial'] = $razonSocial;
										$inputBusqueda['direccion'] = $direccion;
										$inputBusqueda['idProyecto'] = $row['idProyecto'];
										$inputBusqueda['idCuenta'] = $row['idCuenta'];
					
										$rs_verificarExistencia = $this->model->obtener_verificacion_cliente($inputBusqueda);

										if ( empty($rs_verificarExistencia) ) {
											//NO EXISTE UN REGISTRO DEL CLIENTE					
											//CABECERA
												$departamento = (isset($cliente[4]) && !empty($cliente[4])) ? trim($cliente[4]) : NULL;
												$provincia = (isset($cliente[5]) && !empty($cliente[5])) ? trim($cliente[5]) : NULL;
												$distrito = (isset($cliente[6]) && !empty($cliente[6])) ? trim($cliente[6]) : NULL;
												
												$params=array();
												$params['departamento']=$departamento;
												$params['provincia']=$provincia;
												$params['distrito']=$distrito;
												$rs_ubigeo=$this->model->obtener_ubigeo($params);
												$codigoUbigeo=  NULL;
												if ( !empty($rs_ubigeo)) {
													if(count($rs_ubigeo)>0){
														$codigoUbigeo=$rs_ubigeo[0]['cod_ubigeo'];
													}
												}
					
												$arrayBatch[$j]['idCarga'] = $row['idCarga'];
												$arrayBatch[$j]['nombreComercial'] = $nombreComercial;
												$arrayBatch[$j]['razonSocial'] = $razonSocial;
												$arrayBatch[$j]['idSegNegocio'] = $idSegNegocio;
												$arrayBatch[$j]['idSegClienteTradicional'] = $idSegClienteTradicional;
												$arrayBatch[$j]['idSegClienteModerno'] = $idSegClienteModerno;
												$arrayBatch[$j]['fecIni'] = $fechaInicio;
												$arrayBatch[$j]['fecFin'] = $fechaFin;
												$arrayBatch[$j]['idCuenta'] = $row['idCuenta'];
												$arrayBatch[$j]['idProyecto'] = $row['idProyecto'];
												$arrayBatch[$j]['idFrecuencia'] = $idFrecuencia;
												$arrayBatch[$j]['idZona'] = $idZona;
												$arrayBatch[$j]['idZonaPeligrosa'] = $idZonaPeligrosa;
												$arrayBatch[$j]['flagCartera'] = $flagCartera;
												$arrayBatch[$j]['codCliente'] = $codigoCliente;
												$arrayBatch[$j]['cod_ubigeo'] = $codigoUbigeo;
												$arrayBatch[$j]['direccion'] = $direccion;
												$arrayBatch[$j]['referencia'] = $referencia;
												$arrayBatch[$j]['latitud'] = $latitud;
												$arrayBatch[$j]['longitud'] = $longitud;
												$arrayBatch[$j]['ruc'] = $ruc;
												$arrayBatch[$j]['dni'] = $dni;
												//cambiar por arreglo batch
												
										} else {
											//YA EXISTE EL CLIENTE
											$insert=array();
											$insert['idCarga']=$row['idCarga'];
											($nombreComercial!=null)? $insert['nombreComercial']=$nombreComercial :null ;
											($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
											$insert['tipoError']='El cliente ya se encuentra registrado.';
											$insert['datoIngresado']=$nombreComercial;
	
											$this->model->insertar_carga_cliente_no_procesado($insert);
											
										}
					
									}
									$j++;

									if(count($arrayBatch)>0){
										$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cargaClienteDet", $arrayBatch); 
		
										$params =array();
										$params['idCarga']=$row['idCarga'];
										$this->model->update_carga_cliente_clientes_count($params);
									}

								}
								
								fclose($handle_body);
							}
						} 
						$i++;
					}
					
					closedir($directorio_INS);
					clearstatcache();
					//update carga ruta
					
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_cliente_clientes_count($params);
				}else{
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_cliente_clientes_count($params);
				}
			}
		}
		

		//transferir a tablas
		$data = $this->model->carga_cliente()->result_array();
		if(count($data)>0){


			//marcar estado 0
			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['estado']=0;
				$this->model->update_carga_cliente($where,$params);
			}

			$array_detalle=array();
			
			foreach($data as $row){
				if($row['totalClientes']>0 && ( empty($row['total_procesados']) || $row['total_procesados']=='0' )){
					$this->cambiarBaseDatos($row['idCuenta']);
					$params=array();
					$params['idCarga']=$row['idCarga'];
					//
					$data_det = $this->model->carga_cliente_det($params)->result_array();
					$arrayBatch=array();
					$j=0;
					$filas=0;

					$aProyectos =array();
					if( !empty($row['auditoria']) ){
						$aProyectos = $this->model->lista_proyectosAuditoria([ 'idProyecto' => $row['idProyecto'] ]);
					}

					foreach($data_det as  $row_d){
						$j=0;
						//CABECERA
						$input=array();
						$input['nombreComercial'] = $row_d['nombreComercial'];
						$input['razonSocial'] = $row_d['razonSocial'];
						$input['ruc'] = $row_d['ruc'];
						$input['dni'] = $row_d['dni'];
						$input['direccion'] = $row_d['direccion'];

						$validar_cliente_header = $this->model->obtener_verificacion_cliente_header($input);
						if( empty($validar_cliente_header)){

							$input['codCliente'] = $row_d['codCliente'];
							$input['cod_ubigeo'] = $row_d['cod_ubigeo'];

							$insertCliente = $this->model->insertar_cliente($input);
							if($insertCliente){
								$idCliente = $this->db->insert_id();
	
								$arrayBatch[$j]['idCliente'] = $idCliente;
								$arrayBatch[$j]['nombreComercial'] =$row_d['nombreComercial'];
								$arrayBatch[$j]['razonSocial'] =$row_d['razonSocial'];
								$arrayBatch[$j]['idSegNegocio'] =$row_d['idSegNegocio'];
								$arrayBatch[$j]['idSegClienteTradicional'] =$row_d['idSegClienteTradicional'];
								$arrayBatch[$j]['idSegClienteModerno'] =$row_d['idSegClienteModerno'];
								$arrayBatch[$j]['fecIni'] =$row_d['fecIni'];
								$arrayBatch[$j]['fecFin'] =$row_d['fecFin'];
								$arrayBatch[$j]['idCuenta'] =$row_d['idCuenta'];
								$arrayBatch[$j]['idProyecto'] =$row_d['idProyecto'];
								$arrayBatch[$j]['idFrecuencia'] =$row_d['idFrecuencia'];
								$arrayBatch[$j]['idZona'] =$row_d['idZona'];
								$arrayBatch[$j]['idZonaPeligrosa'] =$row_d['idZonaPeligrosa'];
								$arrayBatch[$j]['flagCartera'] =$row_d['flagCartera'];
								$arrayBatch[$j]['codCliente'] =$row_d['codCliente'];
								$arrayBatch[$j]['cod_ubigeo'] =$row_d['cod_ubigeo'];
								$arrayBatch[$j]['direccion'] =$row_d['direccion'];
								$arrayBatch[$j]['referencia'] =$row_d['referencia'];
								$arrayBatch[$j]['latitud'] =$row_d['latitud'];
								$arrayBatch[$j]['longitud'] =$row_d['longitud'];
								
								$j++;
								$filas++;

								if( count($aProyectos)>0){
									foreach($aProyectos as $rowProyectos){
										
										$arrayBatch[$j]['idCliente'] = $idCliente;
										$arrayBatch[$j]['nombreComercial'] =$row_d['nombreComercial'];
										$arrayBatch[$j]['razonSocial'] =$row_d['razonSocial'];
										$arrayBatch[$j]['idSegNegocio'] =$row_d['idSegNegocio'];
										$arrayBatch[$j]['idSegClienteTradicional'] =$row_d['idSegClienteTradicional'];
										$arrayBatch[$j]['idSegClienteModerno'] =$row_d['idSegClienteModerno'];
										$arrayBatch[$j]['fecIni'] =$row_d['fecIni'];
										$arrayBatch[$j]['fecFin'] =$row_d['fecFin'];
										$arrayBatch[$j]['idCuenta'] =$row_d['idCuenta'];
										$arrayBatch[$j]['idProyecto'] =$rowProyectos['idProyecto'];
										$arrayBatch[$j]['idFrecuencia'] =$row_d['idFrecuencia'];
										$arrayBatch[$j]['idZona'] =$row_d['idZona'];
										$arrayBatch[$j]['idZonaPeligrosa'] =$row_d['idZonaPeligrosa'];
										$arrayBatch[$j]['flagCartera'] =$row_d['flagCartera'];
										$arrayBatch[$j]['codCliente'] =$row_d['codCliente'];
										$arrayBatch[$j]['cod_ubigeo'] =$row_d['cod_ubigeo'];
										$arrayBatch[$j]['direccion'] =$row_d['direccion'];
										$arrayBatch[$j]['referencia'] =$row_d['referencia'];
										$arrayBatch[$j]['latitud'] =$row_d['latitud'];
										$arrayBatch[$j]['longitud'] =$row_d['longitud'];
										
										$j++;
									}
								}
							}

						}else{
							$idCliente=$validar_cliente_header[0]['idCliente'];

							$arrayBatch[$j]['idCliente'] = $idCliente;
							$arrayBatch[$j]['nombreComercial'] =$row_d['nombreComercial'];
							$arrayBatch[$j]['razonSocial'] =$row_d['razonSocial'];
							$arrayBatch[$j]['idSegNegocio'] =$row_d['idSegNegocio'];
							$arrayBatch[$j]['idSegClienteTradicional'] =$row_d['idSegClienteTradicional'];
							$arrayBatch[$j]['idSegClienteModerno'] =$row_d['idSegClienteModerno'];
							$arrayBatch[$j]['fecIni'] =$row_d['fecIni'];
							$arrayBatch[$j]['fecFin'] =$row_d['fecFin'];
							$arrayBatch[$j]['idCuenta'] =$row_d['idCuenta'];
							$arrayBatch[$j]['idProyecto'] =$row_d['idProyecto'];
							$arrayBatch[$j]['idFrecuencia'] =$row_d['idFrecuencia'];
							$arrayBatch[$j]['idZona'] =$row_d['idZona'];
							$arrayBatch[$j]['idZonaPeligrosa'] =$row_d['idZonaPeligrosa'];
							$arrayBatch[$j]['flagCartera'] =$row_d['flagCartera'];
							$arrayBatch[$j]['codCliente'] =$row_d['codCliente'];
							$arrayBatch[$j]['cod_ubigeo'] =$row_d['cod_ubigeo'];
							$arrayBatch[$j]['direccion'] =$row_d['direccion'];
							$arrayBatch[$j]['referencia'] =$row_d['referencia'];
							$arrayBatch[$j]['latitud'] =$row_d['latitud'];
							$arrayBatch[$j]['longitud'] =$row_d['longitud'];
							
							$j++;
							$filas++;

							if( count($aProyectos)>0){
								foreach($aProyectos as $rowProyectos){
									
									$arrayBatch[$j]['idCliente'] = $idCliente;
									$arrayBatch[$j]['nombreComercial'] =$row_d['nombreComercial'];
									$arrayBatch[$j]['razonSocial'] =$row_d['razonSocial'];
									$arrayBatch[$j]['idSegNegocio'] =$row_d['idSegNegocio'];
									$arrayBatch[$j]['idSegClienteTradicional'] =$row_d['idSegClienteTradicional'];
									$arrayBatch[$j]['idSegClienteModerno'] =$row_d['idSegClienteModerno'];
									$arrayBatch[$j]['fecIni'] =$row_d['fecIni'];
									$arrayBatch[$j]['fecFin'] =$row_d['fecFin'];
									$arrayBatch[$j]['idCuenta'] =$row_d['idCuenta'];
									$arrayBatch[$j]['idProyecto'] =$rowProyectos['idProyecto'];
									$arrayBatch[$j]['idFrecuencia'] =$row_d['idFrecuencia'];
									$arrayBatch[$j]['idZona'] =$row_d['idZona'];
									$arrayBatch[$j]['idZonaPeligrosa'] =$row_d['idZonaPeligrosa'];
									$arrayBatch[$j]['flagCartera'] =$row_d['flagCartera'];
									$arrayBatch[$j]['codCliente'] =$row_d['codCliente'];
									$arrayBatch[$j]['cod_ubigeo'] =$row_d['cod_ubigeo'];
									$arrayBatch[$j]['direccion'] =$row_d['direccion'];
									$arrayBatch[$j]['referencia'] =$row_d['referencia'];
									$arrayBatch[$j]['latitud'] =$row_d['latitud'];
									$arrayBatch[$j]['longitud'] =$row_d['longitud'];
									
									$j++;
								}
							}
						}

					

						if($row['idCuenta']=="2"){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}else if($row['idCuenta']=="3"){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}else if($row['idCuenta']=="13"){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}else{
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}
						
	
						$where =array();
						$where['idCarga']=$row['idCarga'];
						$params =array();
						$params['total_procesados']=$filas;
						$params['estado']=0;
						$this->model->update_carga_cliente($where,$params);

					}
				}

				$where =array();
				$where['idCarga']=$row['idCarga'];
				$this->model->update_carga_cliente_fecha($where);
			}
		
	 
		}

	}

	public function procesar_archivos_iniciativas(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->carga_iniciativa_no_procesado()->result_array();

		if(count($carpetas)>0){
			//marcar en proceso
			foreach($carpetas as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['procesado']=1;
				$this->model->update_carga_iniciativa($where,$params);
			}

			//convertir a detalle
			foreach($carpetas as $row){
				if( empty($row['totalClientes']) || $row['totalClientes']=='0' ){
					$this->cambiarBaseDatos($row['idCuenta']);
					$ruta = 'public/csv/iniciativas/'.$row['carpeta'];
					$rutaFiles = 'public/csv/iniciativas/'.$row['carpeta'].'/archivos/';
					$directorio_INS = opendir($rutaFiles);
					$arrayBody=array();
					$i=0;
					$j=0;

					$count_elementos=0;
				
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
								while (($data = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) {
									$j=0;
									$arrayBody=array();
									 $header_++; $indice++;
									
									if($header_!=1){
										$m=0;
										$cont =0;

												if(!empty($data[0]) && is_numeric($data[0]) ){
													$validar_cliente="SELECT * FROM trade.cliente WHERE idCliente = ".$data[0];
													$res = $this->db->query($validar_cliente)->row_array();
													if(count($res)>0){
														
														if(!empty($data[1]) && is_numeric($data[1]) ){

															$validar_iniciativa="SELECT * FROM {$this->sessBDCuenta}.trade.iniciativaTrad WHERE idIniciativa = ".$data[1];
															$res_iniciativa = $this->db->query($validar_iniciativa)->row_array();

															if($res_iniciativa!=null){

																if(!empty($data[2]) && is_numeric($data[2]) ){

																	$validar_elemento="SELECT * FROM trade.elementoVisibilidadTrad WHERE idElementoVis = ".$data[2];
																	$res_elemento = $this->db->query($validar_elemento)->row_array();

																	if($res_elemento!=null){
																		$arrayBody[$j]['idCarga'] = $row['idCarga'];
																		$arrayBody[$j]['idCliente'] = $data[0];
																		$arrayBody[$j]['idIniciativa']=$data[1];
																		$arrayBody[$j]['idElementoVis']=$data[2];
																		$j++;
																		$cont++;
																	}else{
																		$insert = "insert into {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados(idCarga,idCliente,tipoError,datoIngresado) VALUES (
																			'".$row['idCarga']."' ,
																			'".( ($data[0]!=null )? $data[0] : '' )."' ,
																			'Elemento visiblidad no existente.',
																			'".$data[2]."'
																			)
																			";
																		$this->db->query($insert);
																		$cont++;
																	}
																}else{

																	$insert = "insert into {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados(idCarga,idCliente,tipoError,datoIngresado) VALUES (
																		'".$row['idCarga']."' ,
																		'".( ($data[0]!=null )? $data[0] : '' )."' ,
																		'Elemento visiblidad no valido.',
																		'".$data[2]."'
																		)
																		";
																	$this->db->query($insert);
																	$cont++;

																}
															

															}
															else{
																$insert = "insert into {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados(idCarga,idCliente,tipoError,datoIngresado) VALUES (
																	'".$row['idCarga']."' ,
																	'".( ($data[0]!=null )? $data[0] : '' )."' ,
																	'Iniciativa no existente.',
																	'".$data[1]."'
																	)
																	";
																$this->db->query($insert);
																$cont++;

															}

																
														}else{
															$insert = "insert into {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados(idCarga,idCliente,tipoError,datoIngresado) VALUES (
																'".$row['idCarga']."' ,
																'".( ($data[0]!=null )? $data[0] : '' )."' ,
																'Iniciativa no valida.',
																'".$data[1]."'
																)
																";
															$this->db->query($insert);
															$cont++;
														}
													}else{
														$select = "SELECT * FROM {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados WHERE idCarga= '".$row['idCarga']."'
														AND idCliente= '".$data[0]."' ";
														$validar = $this->db->query($select)->result_array();
														if(count($validar)==0){
														$insert = "insert into {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados(idCarga,tipoError,datoIngresado) VALUES (
															'".$row['idCarga']."' ,
															'Cliente no registrado en base de datos.',
															'".$data[0]."' )
															";
														$this->db->query($insert);
														$cont++;
														}
													}
													

												}
												else{
													$insert = "insert into {$this->sessBDCuenta}.trade.cargaIniciativaNoProcesados(idCarga,tipoError,datoIngresado) VALUES (
														'".$row['idCarga']."' ,
														'Cliente no valido.',
														'".$data[0]."' )
														";
													$this->db->query($insert);
													$cont++;
												}
									}
									

									if(count($arrayBody)>0){
										$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cargaIniciativaDet", $arrayBody); 
	
										$params =array();
										$params['idCarga']=$row['idCarga'];
										$this->model->update_carga_iniciativa_clientes_count($params);
									}
								}
								fclose($handle_body);
							}
						} 
						$i++;
					}
					
					closedir($directorio_INS);
					clearstatcache();
					//update carga iniciativa
					
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_iniciativa_clientes_count($params);
				}else{
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_iniciativa_clientes_count($params);
				}
			}
		}


		$data = $this->model->carga_iniciativa()->result_array();
		if(count($data)>0){
			//marcar estado 0
			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['estado']=0;
				$this->model->update_carga_iniciativa($where,$params);
			}

			
			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$params=array();
				$params['idCarga']=$row['idCarga'];
				$data_det_cliente = $this->model->carga_iniciativa_det_clientes($params)->result_array();

				
				$cont_clientes=0;
				$filas=0;
				foreach($data_det_cliente as $row_d){

					
					$inputCliente=array();
					$inputCliente['idCliente'] = $row_d['idCliente'];
					$inputCliente['idCuenta'] = $row['idCuenta'];
					$rs_cliente = $this->model->obtener_cliente($inputCliente);

					if($rs_cliente!=null){
						$clienteNombre = $rs_cliente[0]['cliente'];
						$idGrupoCanal = ( (isset($rs_cliente[0]['idGrupoCanal']) && !empty($rs_cliente[0]['idGrupoCanal'])) ? $rs_cliente[0]['idGrupoCanal']:NULL );
						
						$arrayCabecera=array();
						$arrayCabecera['fecIni'] = $row['fecIni'];
						$arrayCabecera['fecFin'] = $row['fecFin'];
						$arrayCabecera['idCliente'] = $row_d['idCliente'];
						$arrayCabecera['idProyecto'] = $row['idProyecto'];
						$arrayCabecera['idGrupoCanal'] = $idGrupoCanal;

						$params_det=array();
						$params_det['idCarga']=$row['idCarga'];
						$params_det['idCliente']=$row_d['idCliente'];
						$data_det_cliente_det = $this->model->carga_iniciativa_det($params_det)->result_array();

						$idListVisibilidadIniInserted=null;

						//validar si existe lista para el cliente actual
						if (!empty($data_det_cliente_det)) {
							//EXISTE ELEMENTOS
							$rs_verificarListaIniciativa = $this->model->verificar_lista_iniciativa_trade($arrayCabecera);
							
							if (!empty($rs_verificarListaIniciativa)) {
								$idListVisibilidadIniInserted = $rs_verificarListaIniciativa[0]['idListIniciativaTrad'];
	
								$rs_eliminarListaDetElemento = $this->model->delete_lista_iniciativa_detalle_elementos_trade($idListVisibilidadIniInserted);
	
								$rs_eliminarListaDet = $this->model->delete_lista_iniciativa_detallle_trade($idListVisibilidadIniInserted);
	
							} else {
								//NO EXISTE REGISTRO DE LISTA CON LA CABECERA
								$rs_listaIniciativa = $this->model->insertar_lista_iniciativa_trade($arrayCabecera);
								if ($rs_listaIniciativa) {
									$idListVisibilidadIniInserted = $this->db->insert_id();
								} 
							}
						}


						if($idListVisibilidadIniInserted!=null){

						
							foreach($data_det_cliente_det as $row_det_iniciativa){
								$arrayBody=array();
								$j=0;
								
									$validar_lista_iniciativaDet="SELECT * FROM {$this->sessBDCuenta}.trade.list_iniciativaTradDet WHERE idListIniciativaTrad = ".$idListVisibilidadIniInserted." AND idIniciativa=".$row_det_iniciativa['idIniciativa'];
									$res_lista_iniciativaDet = $this->db->query($validar_lista_iniciativaDet)->row_array();

									$idListVisibilidadDet=null;
									if($res_lista_iniciativaDet!=null){
										$idListVisibilidadDet=$res_lista_iniciativaDet['idListIniciativaTradDet'];
									}else{
										$arrayDet=array();
										$arrayDet['idIniciativa']=$row_det_iniciativa['idIniciativa'];
										$arrayDet['idListIniciativaTrad']=$idListVisibilidadIniInserted;
										$rs_listaIniciativa = $this->model->insertar_lista_iniciativa_det($arrayDet);
										$idListVisibilidadDet = $this->db->insert_id();
									}

									$validar_lista_iniciativaDetElemento="SELECT * FROM {$this->sessBDCuenta}.trade.list_iniciativaTradDetElemento WHERE idListIniciativaTradDet = ".$idListVisibilidadDet." AND idElementoVis=".$row_det_iniciativa['idElementoVis'];
									$res_lista_iniciativaDetElemento = $this->db->query($validar_lista_iniciativaDetElemento)->row_array();
									
									if($res_lista_iniciativaDetElemento==null){
										$arrayBody[$j]['idListIniciativaTradDet']=$idListVisibilidadDet;
										$arrayBody[$j]['idElementoVis']=$row_det_iniciativa['idElementoVis'];
										$arrayBody[$j]['estado'] =1;
										$j++;

									}

									if(count($arrayBody)>0){
										$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.list_iniciativaTradDetElemento", $arrayBody); 
									}
									
								$filas++;
							}

							$where =array();
							$where['idCarga']=$row['idCarga'];
							$params =array();
							$params['total_procesados']=$filas;
							$this->model->update_carga_iniciativa($where,$params);

						}

					}

					
					
				}
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$this->model->update_carga_iniciativa_fecha($where);
			}
		}
	}

	public function procesar_archivos_clientes_proyecto(){
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$carpetas = $this->model->carga_cliente_proyecto_no_procesado()->result_array();

		if(count($carpetas)>0){
			//marcar en proceso
			foreach($carpetas as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['procesado']=1;
				$this->model->update_carga_cliente_proyecto($where,$params);
			}

			//convertir a detalle
			foreach($carpetas as $row){
				if( empty($row['totalClientes']) || $row['totalClientes']=='0' ){
					$this->cambiarBaseDatos($row['idCuenta']);
					$ruta = 'public/csv/clientesproyecto/'.$row['carpeta'];
					$clienteFiles = 'public/csv/clientesproyecto/'.$row['carpeta'].'/archivos/';
					$directorio_INS = opendir($clienteFiles);
					$arrayBody=array();
					$i=0;
					$j=0;
					while (false !== ($archivo_INS = readdir($directorio_INS))){
						if ($archivo_INS != '.' && $archivo_INS != '..') {
							if(is_file($clienteFiles.$archivo_INS)) {
								$rutaCSV = $clienteFiles.$archivo_INS;
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
	
								$codigoElemento=array();

								$tablaHistorico="ImpactTrade_small.trade.cliente_historico";
								if( !empty($row['idCuenta']) ){
									if($row['idCuenta']=="2"){
										$tablaHistorico="ImpactTrade_aje.trade.cliente_historico";
									}else if($row['idCuenta']=="3"){
										$tablaHistorico="ImpactTrade_pg.trade.cliente_historico";
									}else if($row['idCuenta']=="13"){
										$tablaHistorico="ImpactTrade_small.trade.cliente_historico";
									}else{
										$tablaHistorico="ImpactTrade_small.trade.cliente_historico";
									}
								}
								
								$j=0;
								$arrayBatch = array();
								while (($cliente = fgetcsv($handle_body, 1000000, $delimiter)) !== FALSE) { 
									
									
									$header_++; $indice++;
									if($header_!=1){
										$m=0; 
										$cont =0;
										$error=false;

										///
										
										$idCliente = (isset($cliente[0]) && !empty($cliente[0])) ? trim($cliente[0]) : NULL;
										$idProyecto = (isset($cliente[1]) && !empty($cliente[1])) ? trim($cliente[1]) : NULL;

										$inputBusqueda=array();
										$inputBusqueda['idCliente'] = $idCliente;
										$inputBusqueda['idProyecto'] = $idProyecto;
										$inputBusqueda['historico'] = $tablaHistorico;
					
										$rs_verificarExistenciaHistorico = $this->model->obtener_verificacion_cliente_proyecto($inputBusqueda);
										if ( empty($rs_verificarExistenciaHistorico) ) {
											
											$inputCliente=array();
											$inputCliente['idCliente'] = $idCliente;
											$inputCliente['idProyecto'] = $row['idProyecto'];
											$inputCliente['historico'] = $tablaHistorico;
						
											$rs_verificarExistencia = $this->model->obtener_cliente_proyecto_existente($inputCliente);
											if ( !empty($rs_verificarExistencia) ) {
												$inputHistorico=array();
												$inputHistorico['idCarga'] = $row['idCarga'];
												$inputHistorico['idCliente'] = $idCliente;
												$inputHistorico['idProyecto'] = $idProyecto;
												$arrayBatch[$j]=$inputHistorico;
												$j++;
											}else{
												$insert=array();
												$insert['idCarga']=$row['idCarga'];
												$insert['tipoError']='No existe un cliente con el ID Cliente ingresado.';
												$insert['datoIngresado']=$idCliente;
												
												$this->model->insertar_carga_cliente_proyecto_no_procesado($insert);

											}

										} else {
											//YA EXISTE EL CLIENTE
											if( !empty($rs_verificarExistenciaHistorico[0])){
												$insert=array();
												$insert['idCarga']=$row['idCarga'];
												($rs_verificarExistenciaHistorico[0]['nombreComercial']!=null)? $insert['nombreComercial']=$rs_verificarExistenciaHistorico[0]['nombreComercial'] :null ;
												($razonSocial!=null)? $insert['razonSocial']=$razonSocial :null ;
												$insert['tipoError']='El cliente ya se encuentra registrado.';
												$insert['datoIngresado']=$idCliente;
		
												$this->model->insertar_carga_cliente_proyecto_no_procesado($insert);
											}
										}
					
										if(count($arrayBatch)>100){
											$insert = $this->db->insert_batch('trade.cargaClienteProyectoDet', $arrayBatch); 
			
											$params =array();
											$params['idCarga']=$row['idCarga'];
											$this->model->update_carga_cliente_clientes_count($params);
											$arrayBatch=array();
											$j=0;
										}

									}
								}

								if(count($arrayBatch)>0){
									$insert = $this->db->insert_batch('trade.cargaClienteProyectoDet', $arrayBatch); 
	
									$params =array();
									$params['idCarga']=$row['idCarga'];
									$this->model->update_carga_cliente_clientes_count($params);
								}

								
								fclose($handle_body);
							}
						} 
						$i++;
					}
					
					closedir($directorio_INS);
					clearstatcache();
					//update carga ruta
					
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_cliente_proyecto_count($params);
				}else{
					$params =array();
					$params['idCarga']=$row['idCarga'];
					$this->model->update_carga_cliente_proyecto_count($params);
				}
			}
		}
		

		//transferir a tablas
		$data = $this->model->carga_cliente_proyecto()->result_array();
		if(count($data)>0){


			//marcar estado 0
			foreach($data as $row){
				$this->cambiarBaseDatos($row['idCuenta']);
				$where =array();
				$where['idCarga']=$row['idCarga'];
				$params =array();
				$params['estado']=0;
				$this->model->update_carga_cliente_proyecto($where,$params);
			}

			$array_detalle=array();
			
			foreach($data as $row){
				if($row['totalClientes']>0 && ( empty($row['total_procesados']) || $row['total_procesados']=='0' )){
					$this->cambiarBaseDatos($row['idCuenta']);
					$params=array();
					$params['idCarga']=$row['idCarga'];

					$tablaHistorico="{$this->sessBDCuenta}.trade.cliente_historico";
					if( !empty($row['idCuenta']) ){
						if($row['idCuenta']=="2"){
							$tablaHistorico="{$this->sessBDCuenta}.trade.cliente_historico";
						}else if($row['idCuenta']=="3"){
							$tablaHistorico="{$this->sessBDCuenta}.trade.cliente_historico";
						}else if($row['idCuenta']=="13"){
							$tablaHistorico="{$this->sessBDCuenta}.trade.cliente_historico";
						}else{
							$tablaHistorico="{$this->sessBDCuenta}.trade.cliente_historico";
						}
					}
					
					//
					$data_det = $this->model->carga_cliente_proyecto_det($params)->result_array();
					$arrayBatch=array();
					$j=0;
					$filas=0;
					foreach($data_det as  $row_d){
						
						//CABECERA
						$input=array();
						$input['idCliente'] = $row_d['idCliente'];
						$input['idProyecto'] = $row['idProyecto'];
						$input['historico'] = $tablaHistorico;
	
						$rs_verificarExistencia = $this->model->obtener_verificacion_cliente_proyecto($input);
						if ( !empty($rs_verificarExistencia) ) {
							$inputHistorico=array();
							$inputHistorico= $rs_verificarExistencia[0];
							$inputHistorico['idProyecto'] = $row_d['idProyecto'];
							$arrayBatch[$j]=$inputHistorico;
							$j++;
						}else{
							$insert=array();
							$insert['idCarga']=$row['idCarga'];
							$insert['tipoError']='No se un cliente con el ID Cliente ingresado.';
							$insert['datoIngresado']=$idCliente;
							
							$this->model->insertar_carga_cliente_proyecto_no_procesado($insert);

						}


						if( count($arrayBatch)>100){
							if($row['idCuenta']=="2"){
								$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
							}else if($row['idCuenta']=="3"){
								$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
							}else if($row['idCuenta']=="13"){
								$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
							}else{
								$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
							}
							$where =array();
							$where['idCarga']=$row['idCarga'];
							$params =array();
							$params['total_procesados']=$filas;
						
							$this->model->update_carga_cliente_proyecto($where,$params);
							$j=0;
							$arrayBatch=array();
						}
						$filas++;
					}

					if( count($arrayBatch)>0){
						if($row['idCuenta']=="2"){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}else if($row['idCuenta']=="3"){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}else if($row['idCuenta']=="13"){
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}else{
							$insert = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cliente_historico", $arrayBatch); 
						}
						$where =array();
						$where['idCarga']=$row['idCarga'];
						$params =array();
						$params['total_procesados']=$filas;
					
						$this->model->update_carga_cliente_proyecto($where,$params);
						$j=0;
						$arrayBatch=array();
					}
				}

				$where =array();
				$where['idCarga']=$row['idCarga'];
				$this->model->update_carga_cliente_proyecto_fecha($where);
			}
		
	 
		}

	}


	public function procesar_peticiones_actualizar_visitas($idCuenta){

		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$this->cambiarBaseDatos($idCuenta);
		$rs_peticion=$this->model->get_peticiones_actualizar_visitas();
		if($rs_peticion!=null){
			foreach($rs_peticion as $row){
				$params_=array();
				$params_['idPeticion']=$row['idPeticion'];
				$params_['idRuta']=$row['idRuta'];

				$this->model->actualizar_visitas($params_);
				$this->model->actualizar_peticion_estado($params_);
				$this->model->actualizar_peticion_det($params_);

				$data_procesada = $this->model->data_procesada($params_)->row_array();
				$total= isset($data_procesada['total'])?$data_procesada['total']:0;
				$procesados= isset($data_procesada['procesados'])?$data_procesada['procesados']:0;

					$porcentaje= get_porcentaje($total,$procesados);
					$params2=array();
					$params2['idPeticion']=$row['idPeticion'];
					$porc=$porcentaje;
					$params2['porcentaje']=$porc;
					$this->model->actualizar_peticion($params2);
			}
		}


	}

	public function cambiarBaseDatos($idCuenta){
		if($idCuenta==2){
			$this->sessBDCuenta="ImpactTrade_aje";
			$this->model->sessBDCuenta="ImpactTrade_aje";
		}
		else if($idCuenta==3){
			$this->sessBDCuenta="ImpactTrade_pg";
			$this->model->sessBDCuenta="ImpactTrade_pg";
		}
		else  {
			$this->sessBDCuenta="ImpactTrade_small";
			$this->model->sessBDCuenta="ImpactTrade_small";
		}
	}
	

}
?>