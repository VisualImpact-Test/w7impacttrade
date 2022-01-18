<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rutas extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/master/m_rutas','model');
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style']=array(
			  'assets/libs/dataTables-1.10.20/datatables'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		);
		$config['js']['script'] = array(
			  'assets/libs/datatables/datatables'
			  ,'assets/libs/datatables/responsive.bootstrap4.min'
			  ,'assets/custom/js/core/datatables-defaults'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/languages/all'
			, 'assets/libs/handsontable@7.4.2/dist/moment/moment'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/libs/filedownload/jquery.fileDownload'
			, 'assets/custom/js/configuraciones/master/rutas'
		);

		$config['nav']['menu_active'] = '92';
		$config['data']['icon'] = 'fas fa-route';
		$config['data']['title'] = 'Rutas';
		$config['data']['message'] = '';
		$config['view'] = 'modulos/configuraciones/master/rutas/index';

		$this->view($config);
	}
	
	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$input = array();
		$fecha = explode('-',$data->{'fechas'});
		$input['fecIni'] = $fecha[0];
		$input['fecFin'] = $fecha[1];
		
		$ruta = $this->model->obtener_ruta($input);

		$html = '';

		if ( !empty($ruta) ) {
			$result['result'] = 1;
			$array = array();
			$array['ruta'] = $ruta;			
			$html .= $this->load->view("modulos/configuraciones/master/rutas/lista", $array, true);
			$result['data']['html'] = $html;
			$result['data']['datatable'] = 'tb-modulacion';
		} else {
			$html .='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
			$result['data']['html'] = $html;
		}
		echo json_encode($result);
	}
	
	public function form_nueva_ruta(){
		$data = json_decode($this->input->post('data'));
		
		$input = array();
		$array = array();
		$html = '';
		
		$result['result'] = 1;
		
		//$array['modulos'] = $this->model->obtener_modulos();
		$array['data_gtm'] = $this->model->obtener_gtm();
		$html = $this->load->view("modulos/configuraciones/master/rutas/nueva_ruta", $array, true);
		
		$result['data'] = $html;

		echo json_encode($result);
	} 
	
	public function agregar_clientes(){
		$post=json_decode($this->input->post('data'),true);
		
		$idCliente = $post['idCliente'];
		$lunes = isset($post['lunes'])?'checked':'';
		$martes = isset($post['martes'])?'checked':'';
		$miercoles = isset($post['miercoles'])?'checked':'';
		$jueves = isset($post['jueves'])?'checked':'';
		$viernes = isset($post['viernes'])?'checked':'';
		$sabado = isset($post['sabado'])?'checked':'';
		$domingo = isset($post['domingo'])?'checked':'';
		
		if(!empty($idCliente)){
			$obtener_clientes = $this->model->obtener_clientes_ruta($idCliente);
			$html='';
			foreach($obtener_clientes as $row){
				$html.='<tr>';
				$html.='<td></td>';
				$html.='<td>'.$row['idCliente'].' <input type="hidden" name="idCliente_ruta" value="'.$row['idCliente'].'"></td>';
				$html.='<td>'.$row['razonSocial'].'</td>';
				$html.='<td><input type="checkbox" value="1" name="lunes_'.$row['idCliente'].'"  '.$lunes.' ></td>';
				$html.='<td><input type="checkbox" value="2" name="martes_'.$row['idCliente'].'"  '.$martes.' ></td>';
				$html.='<td><input type="checkbox" value="3" name="miercoles_'.$row['idCliente'].'"  '.$miercoles.' ></td>';
				$html.='<td><input type="checkbox" value="4" name="jueves_'.$row['idCliente'].'"  '.$jueves.' ></td>';
				$html.='<td><input type="checkbox" value="5" name="viernes_'.$row['idCliente'].'"  '.$viernes.' ></td>';
				$html.='<td><input type="checkbox" value="6" name="sabado_'.$row['idCliente'].'"  '.$sabado.' ></td>';
				$html.='<td><input type="checkbox" value="7" name="domingo_'.$row['idCliente'].'"  '.$domingo.' ></td>';
				$html.='</tr>';
			}
			$data['html']=$html;
			$data['result']=1;
		}
		echo json_encode($data);
	}
	
	public function filtrar_clientes(){
		$post=json_decode($this->input->post('data'),true);

		$idRutaProg = $post['idRutaProg'];
		$idCliente = $post['idCliente'];

		$arreglo= array();
		$result['result']=1;
		$data_ruta = $this->model->obtener_visitas_programadas($idCliente,$idRutaProg);

		foreach($data_ruta as $row){
			$clientes[$row['idCliente']]['id'] = $row['idCliente'];
			$clientes[$row['idCliente']]['idVisitaProg'] = $row['idVisitaProg'];
			$clientes[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$dias[$row['idCliente']][$row['idDia']]['dia'] = $row['idDia'];
		}
		$html='';
		$i=1;
		foreach($clientes as $row => $value ){
			$html.='<tr>';
			$html.='<td></td>';
			$html.='<td>'.$i.'</td>';
			$html.='<td>'.$value['id'].' <input type="hidden" name="idCliente_ruta" value="'.$value['idVisitaProg'].'"> </td>';
			$html.='<td>'.$value['razonSocial'].'</td>';
			$lunes = isset($dias[$row][1]['dia'])?'checked':'';
			$martes = isset($dias[$row][2]['dia'])?'checked':'';
			$miercoles = isset($dias[$row][3]['dia'])?'checked':'';
			$jueves = isset($dias[$row][4]['dia'])?'checked':'';
			$viernes = isset($dias[$row][5]['dia'])?'checked':'';
			$sabado = isset($dias[$row][6]['dia'])?'checked':'';
			$domingo = isset($dias[$row][7]['dia'])?'checked':'';
			$html.='<td><center><input type="checkbox" value="1" class="lunes" name="lunes_'.$value['idVisitaProg'].'" '.$lunes.'  ></center> </td>';
			$html.='<td><center><input type="checkbox" value="2" class="martes" name="martes_'.$value['idVisitaProg'].'" '.$martes.' ></center> </td>';
			$html.='<td><center><input type="checkbox" value="3" class="miercoles" name="miercoles_'.$value['idVisitaProg'].'" '.$miercoles.' ></center> </td>';
			$html.='<td><center><input type="checkbox" value="4" class="jueves" name="jueves_'.$value['idVisitaProg'].'" '.$jueves.'  > </center> </td>';
			$html.='<td><center><input type="checkbox" value="5" class="viernes" name="viernes_'.$value['idVisitaProg'].'" '.$viernes.'   > </center> </td>';
			$html.='<td><center><input type="checkbox" value="6" class="sabado" name="sabado_'.$value['idVisitaProg'].'" '.$sabado.'  >  </center> </td>';
			$html.='<td><center><input type="checkbox" value="7" class="domingo" name="domingo_'.$value['idVisitaProg'].'" '.$domingo.'   > </center> </td>';
			$html.='</tr>';
			$i++;
		}
		$result['data']=$html;
		echo json_encode($result);
	}
	
	public function filtrar_clientes_eliminar(){
		$post=json_decode($this->input->post('data'),true);

		$idRutaProg = $post['idRutaProg'];
		$idCliente = $post['idCliente'];

		$arreglo= array();
		$result['result']=1;
		$data_ruta = $this->model->obtener_visitas_programadas($idCliente,$idRutaProg);

		foreach($data_ruta as $row){
			$clientes[$row['idCliente']]['id'] = $row['idCliente'];
			$clientes[$row['idCliente']]['idVisitaProg'] = $row['idVisitaProg'];
			$clientes[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
		}
		$html='';
		$i=1;
		foreach($clientes as $row => $value ){
			$html.='<tr>';
			$html.='<td></td>';
			$html.='<td>'.$i.'</td>';
			$html.='<td>'.$value['id'].'</td>';
			$html.='<td>'.$value['razonSocial'].'</td>';
			$html.='<td><center><input type="checkbox" value="'.$value['idVisitaProg'].'" class="eliminar" name="eliminar" checked  ></center> </td>';
			$html.='</tr>';
			$i++;
		}
		$result['data']=$html;
		echo json_encode($result);
	}
	
	public function eliminar_ruta(){
		$post=json_decode($this->input->post('data'),true);
		
		$idRutaProg=$post['idRutaProg'];
		$array_eliminar =array();
		
		if( is_array($post['eliminar']) ){$array_eliminar=$post['eliminar'];}
		else{$array_eliminar=array('0'=>$post['eliminar']);}
		
		foreach( $array_eliminar as $row){
			$sql1 = 'delete from {$this->sessBDCuenta}.trade.master_visitaProgramadaDet where idVisitaProg = '.$row;
			$sql2 = 'delete from {$this->sessBDCuenta}.trade.master_visitaProgramada where idVisitaProg = '.$row;
			$this->db->query($sql1);
			$this->db->query($sql2);
		}
		
		$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
		$res = $this->db->query($total_clientes)->row_array();
		$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
		$this->db->query($update);
		
		$result = array( 
				  'msg' => array('title' => 'Confirmar', 'content' => 'Se registro ruta con exito.')
				, 'data' => 'Se elimino clientes con exito.'
				, 'result' => 1
			);
			
		echo json_encode($result);

	}
	
	public function registrar_ruta(){
		$post=json_decode($this->input->post('data'),true);
		$ruta = $post['nombreRuta'];
		$fecIni = $post['fecha_ini'];
		$fecFin = $post['fecha_fin'];
		$idGtm = $post['idGtm'];
		$idUsuario = $this->session->idUsuario;
		
		$idCliente = $post['idCliente_ruta'];
		
		$array_ruta = array();
		
		$array_ruta['nombreRuta']=$ruta;
		$array_ruta['idUsuarioReg']=$idUsuario;
		$array_ruta['fecIni']= $fecIni;
		$array_ruta['numClientes']= 0;
		if(!empty($fecFin)){
			$array_ruta['fecFin']=$fecFin;
		}
		$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramada",$array_ruta);
		
		$idRutaProg = $this->db->insert_id();
		
		$array_ruta_det = array();
		
		$array_ruta_det['idRutaProg'] = $idRutaProg;
		$array_ruta_det['idUsuario'] = $idGtm;
		$array_ruta_det['fecIni'] = $fecIni;
		if(!empty($fecFin)){
			$array_ruta_det['fecFin']=$fecFin;
		}
		$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramadaDet",$array_ruta_det);
		$idRutaProgDet = $this->db->insert_id();
		
		if(count($idCliente)){
			foreach( $idCliente as $row ){
				$array_visita = array();
				$array_visita['idRutaProg'] = $idRutaProgDet;
				$array_visita['idCliente'] = $row;
				
				$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada",$array_visita);
		
				$idVisita = $this->db->insert_id();
								
				if(!empty($post['lunes_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 1;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['martes_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 2;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['miercoles_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 3;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['jueves_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 4;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['viernes_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 5;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['sabado_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 6;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['domingo_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 7;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
			}
			
			$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
			$res = $this->db->query($total_clientes)->row_array();
			$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
			$this->db->query($update);
		}
		
		$result = array( 
				  'msg' => array('title' => 'Confirmar', 'content' => 'Se registro ruta con exito.')
				, 'data' => 'Se registro ruta con exito.'
				, 'result' => 1
			);
			
		echo json_encode($result);
		
	}
	
	public function actualizar_ruta(){
		$post=json_decode($this->input->post('data'),true);
//print_r($post);
		$idRutaProg = $post['idRutaProg'];
		$ruta = $post['nombre_ruta'];
		$fecIni = $post['fecIni'];
		$fecFin = $post['fecFin'];
		
		//$idCliente = $post['idCliente_ruta'];
		
		$array_eliminar = array();
		$array_cliente = array();
		$array_lunes = array();
		$array_martes = array();
		$array_miercoles = array();
		$array_jueves = array();
		$array_viernes = array();
		$array_sabado = array();
		$array_domingo = array();
	
		foreach( $post['clientes'] as $row ){
			$array_eliminar[$row[1]]=$row[0];
			$array_cliente[]=$row[1];
			$array_lunes[$row[1]]=$row[2];
			$array_martes[$row[1]]=$row[3];
			$array_miercoles[$row[1]]=$row[4];
			$array_jueves[$row[1]]=$row[5];
			$array_viernes[$row[1]]=$row[6];
			$array_sabado[$row[1]]=$row[7];
			$array_domingo[$row[1]]=$row[8];
		}
		
		/* print_r($array_cliente);
		print_r($array_lunes);
		print_r($array_martes);
		print_r($array_miercoles);
		print_r($array_jueves);
		print_r($array_viernes);
		print_r($array_sabado);
		print_r($array_domingo); */

		$array_ruta = array();
		
		$array_ruta['nombreRuta']=$ruta;
		$array_ruta['fecIni']= $fecIni;
		$array_ruta['numClientes']= 0;
		if(!empty($fecFin)){
			$array_ruta['fecFin']=$fecFin;
		}
		
		$this->db->where('idRutaProg', $idRutaProg);
        $this->db->update("{$this->sessBDCuenta}.trade.master_rutaProgramada", $array_ruta);

		$array_ruta_det = array();
		
		if(count($array_cliente)){
			foreach( $array_cliente as $row ){
				if($array_eliminar[$row]==0){
				$idCliente = $row;
				$sql = "SELECT idVisitaProg FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idCliente =".$idCliente." AND idRutaProg = ".$idRutaProg." " ;
				$res = $this->db->query($sql)->row_array();
				if(count($res)){
					$idVisitaProg=$res['idVisitaProg'];
					$delete = "DELETE FROM {$this->sessBDCuenta}.trade.master_visitaProgramadaDet WHERE idVisitaProg =".$idVisitaProg;
					$this->db->query($delete);
				}else {
					$array_visita = array();
					$array_visita['idRutaProg'] = $idRutaProg;
					$array_visita['idCliente'] = $idCliente;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada",$array_visita);
					$idVisitaProg=$this->db->insert_id();
				}
				
				$lunes = isset($array_lunes[$idCliente])?$array_lunes[$idCliente]:'';
				$martes = isset($array_martes[$idCliente])?$array_martes[$idCliente]:'';
				$miercoles = isset($array_miercoles[$idCliente])?$array_miercoles[$idCliente]:'';
				$jueves = isset($array_jueves[$idCliente])?$array_jueves[$idCliente]:'';
				$viernes = isset($array_viernes[$idCliente])?$array_viernes[$idCliente]:'';
				$sabado = isset($array_sabado[$idCliente])?$array_sabado[$idCliente]:'';
				$domingo = isset($array_domingo[$idCliente])?$array_domingo[$idCliente]:'';

					if(!empty($lunes) && $lunes==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 1
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($martes) && $martes==1){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 2
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
		
					if(!empty($miercoles) && $miercoles==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 3
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				
					if(!empty($jueves) && $jueves==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 4
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				
					if(!empty($viernes ) && $viernes==1){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 5
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($sabado) && $sabado==1){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 6
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($domingo) && $domingo==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' =>7
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				}else{
					$idCliente = $row;
					$sql = "SELECT idVisitaProg FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idCliente =".$idCliente." AND idRutaProg = ".$idRutaProg." " ;
					$res = $this->db->query($sql)->row_array();
					$idVisitaProg=$res['idVisitaProg'];
					$delete1 = "DELETE FROM {$this->sessBDCuenta}.trade.master_visitaProgramadaDet WHERE idVisitaProg =".$idVisitaProg;
					$delete2 = "DELETE FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idVisitaProg =".$idVisitaProg;
					$this->db->query($delete1);
					$this->db->query($delete2);
				}

			}
			
			$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
			$res = $this->db->query($total_clientes)->row_array();
			$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
			$this->db->query($update);
		}
		
		$result = array( 
				  'msg' => array('title' => 'Confirmar', 'content' => 'Se registro ruta con exito.')
				, 'data' => 'Se actualizo ruta con exito.'
				, 'result' => 1
			);
			
		echo json_encode($result);
	}
	
	public function agregar_usuario_ruta(){
		$post=json_decode($this->input->post('data'));
		$idRutaProg = $post->{'idRutaProg'};
		$idUsuario = $post->{'idUsuario'};
		$fecIni = $post->{'fechas_ini_rutas'};
		$fecFin = $post->{'fechas_fin_rutas'};
		if(empty($fecFin))$fecFinR=$fecIni;
		else{$fecFinR=$fecFin;}
		$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramadaDet SET fecFin= DATEADD(day,-1,'".$fecIni."') WHERE idRutaProgDet IN(
					SELECT idRutaProgDet FROM {$this->sessBDCuenta}.trade.master_rutaProgramadaDet WHERE general.dbo.fn_fechaVigente(fecIni,fecFin,'".$fecIni."','".$fecFinR."')=1
					AND idRutaProg=$idRutaProg
					) ";
		$this->db->query($update);
		if(empty($fecFin)){
			$insert = "insert into {$this->sessBDCuenta}.trade.master_rutaProgramadaDet VALUES($idRutaProg,$idUsuario,'".$fecIni."',null,getdate(),1) ";
		}else{
			$insert = "insert into {$this->sessBDCuenta}.trade.master_rutaProgramadaDet VALUES($idRutaProg,$idUsuario,'".$fecIni."','".$fecFin."',getdate(),1) ";
		}
		$this->db->query($insert);
		
		$params=array(
			'id'=>$idRutaProg
		);
		$data_ruta = $this->model->obtener_usuario_ruta_tradicional($params);
		$html='';
		
		$html.='<table class="table">';
			$html.='<thead>';
				$html.='<tr>';
					$html.='<th>#</th>';
					$html.='<th>USUARIO</th>';
					$html.='<th>FECHA INICIO</th>';
					$html.='<th>FECHA FIN</th>';
				$html.='</tr>';
			$html.='</thead>';
			$html.='<tbody>';
			$i=1; foreach($data_ruta as $row){ 
				$html.='<tr>';
					$html.='<td>'.$i.'</td>';
					$html.='<td>'.$row['usuario'].'</td>';
					$html.='<td>'.$row['fecIni'].'</td>';
					$html.='<td>'.$row['fecFin'].'</td>';
				$html.='</tr>';
			$i++; }
			$html.='</tbody>';
		$html.='</table>';
		
		$result['result']=1;
		$result['data']=$html;
		echo json_encode($result);
	}

	public function form_add_clientes(){
		$array['rutas'] = $this->model->obtener_rutas_activas();
		$html = $this->load->view("modulos/configuraciones/master/rutas/agregar_clientes", $array, true);
		$result['data'] = $html;
		$result['result'] = 1;
		echo json_encode($result);
	}
	
	public function agregar_visitas(){
		$post=json_decode($this->input->post('data'),true);
		$idRutaProg = $post['idRuta'];
		
		$idCliente = $post['idCliente_ruta'];

		if(count($idCliente)){
			foreach( $idCliente as $row ){
				$array_visita = array();
				$array_visita['idRutaProg'] = $idRutaProg;
				$array_visita['idCliente'] = $row;
				
				$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada",$array_visita);
		
				$idVisita = $this->db->insert_id();
								
				if(!empty($post['lunes_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 1;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['martes_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 2;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['miercoles_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 3;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['jueves_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 4;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['viernes_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 5;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['sabado_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 6;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
				if(!empty($post['domingo_'.$row])){
					$array_visitaDet = array();
					$array_visitaDet['idVisitaProg'] = $idVisita;
					$array_visitaDet['idDia'] = 7;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$array_visitaDet);
				}
			}
			
			$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
			$res = $this->db->query($total_clientes)->row_array();
			$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
			$this->db->query($update);
		}
		
		$result = array( 
				  'msg' => array('title' => 'Confirmar', 'content' => 'Se registro ruta con exito.')
				, 'data' => 'Se agregaron clientes con exito.'
				, 'result' => 1
			);
			
		echo json_encode($result);
	}
	
	public function form_editar_rutas(){
		$data=json_decode($this->input->post('data'));
		$id=$data->{'id'};
		$fecIni=$data->{'fecIni'};
		$fecFin=$data->{'fecFin'};
		
		$params=array(
			  'id'=>$id
			, 'fecIni'=>$fecIni
		);
		
		$params['fecFin'] = !empty($fecFin)?$fecFin:$fecIni;

		$arreglo= array();
		$result['result']=1;
		$data_ruta = $this->model->obtener_ruta($params);
		
		$arreglo['data_clientes'] = $this->model->obtener_data_carga($params);
		$data_ruta_visitas = $this->model->obtener_ruta_detalle($id);
		$clientes=array();
		foreach($data_ruta_visitas as $row){
			$clientes[$row['idCliente']]['id'] = $row['idCliente'];
			$clientes[$row['idCliente']]['idVisitaProg'] = $row['idVisitaProg'];
			$clientes[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$dias[$row['idCliente']][$row['idDia']]['dia'] = $row['idDia'];
		}
		
		$html='';
		
		foreach($clientes as $row => $value){
			//foreach($dias[$row] as $row_d => $value_d){
				$lunes = !empty($dias[$row][1])?'1':0;
				$martes = !empty($dias[$row][2])?'1':0;
				$miercoles = !empty($dias[$row][3])?'1':0;
				$jueves = !empty($dias[$row][4])?'1':0;
				$viernes = !empty($dias[$row][5])?'1':0;
				$sabado = !empty($dias[$row][6])?'1':0;
				$domingo = !empty($dias[$row][7])?'1':0;
			//}
			$html.='{ eliminar: 0, idCliente:'.$row.', lunes:'.$lunes.',martes:'.$martes.',miercoles:'.$miercoles.',jueves:'.$jueves.', viernes:'.$viernes.', sabado:'.$sabado.', domingo:'.$domingo.' },';
		}

		//$frecuencias = $this->m_frecuencias->obtener_frecuencias()->result();
		
		$arreglo['data']=$data_ruta;
		$arreglo['visitas']=$html;

		$result['data']=$this->load->view("modulos/configuraciones/master/rutas/editar_rutas", $arreglo, true); 
		echo json_encode($result);
	}
	
	public function agregar_visita_programada(){
		$data=json_decode($this->input->post('data'));
		$idUsuario = $this->session->idUsuario;
		$idRutaProg=$data->{'idRutaProg'};
		$fecIni=$data->{'fecIni'};
		$fecFin=$data->{'fecFin'};
		$idRutaProg=$data->{'idRutaProg'};
		$idCliente=$data->{'idCliente'};
		$lunes=isset($data->{'lunes'})?$data->{'lunes'}:'';
		$martes=isset($data->{'martes'})?$data->{'martes'}:'';
		$miercoles=isset($data->{'miercoles'})?$data->{'miercoles'}:'';
		$jueves=isset($data->{'jueves'})?$data->{'jueves'}:'';
		$viernes=isset($data->{'viernes'})?$data->{'viernes'}:'';
		$sabado=isset($data->{'sabado'})?$data->{'sabado'}:'';
		$domingo=isset($data->{'domingo'})?$data->{'domingo'}:'';
		
		
		$sum_lunes = (empty($lunes))?0:1;
		$sum_martes = (empty($martes))?0:1;
		$sum_miercoles = (empty($miercoles))?0:1;
		$sum_jueves = (empty($jueves))?0:1;
		$sum_viernes = (empty($viernes))?0:1;
		$sum_sabado = (empty($sabado))?0:1;
		$sum_domingo = (empty($domingo))?0:1;
		$suma = $sum_lunes+$sum_martes+$sum_miercoles+$sum_jueves+$sum_viernes+$sum_sabado+$sum_domingo;

		$max_visitas = 1;
		
		if($max_visitas==$suma){
			
			$delete = 'DELETE FROM trade.visitaProgramada WHERE idRutaProg='.$idRutaProg.' AND idCliente='.$idCliente;
			$this->db->query($delete);
			
			$insert = "INSERT INTO trade.visitaProgramada VALUES($idRutaProg,$idCliente,getdate(),1)";
			$this->db->query($insert);
			$id = $this->db->insert_id();

			if(!empty($lunes)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$lunes,getdate(),1)";
				$this->db->query($insert);
			}
			if(!empty($martes)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$martes,getdate(),1)";
				$this->db->query($insert);
			}
			if(!empty($miercoles)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$miercoles,getdate(),1)";
				$this->db->query($insert);
			}
			if(!empty($jueves)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$jueves,getdate(),1)";
				$this->db->query($insert);
			}
			if(!empty($viernes)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$viernes,getdate(),1)";
				$this->db->query($insert);
			}
			if(!empty($sabado)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$sabado,getdate(),1)";
				$this->db->query($insert);
			}
			if(!empty($domingo)){
				$insert = "INSERT INTO trade.visitaProgramadaDet VALUES($id,$domingo,getdate(),1)";
				$this->db->query($insert);
			}
			$mensaje='<a href="javascript:;"><i class="fa fa-check-circle" ></i></a> Información procesada con exíto. ';
			$resultado_final=1;
		} else{
			$mensaje = '<a href="javascript:;"><i class="fa fa-check-circle" ></i></a>No se registro el cliente seleccionado deber tener '. $max_visitas.' visitas por semana.';
			$resultado_final=2;
		}
		
		$params=array(
			'id'=>$idRutaProg
		);
		$data_ruta = $this->model->obtener_ruta($params);

			$data_ruta_visitas = $this->model->obtener_ruta_tradicional_detalle($params);
	
		foreach($data_ruta_visitas as $row){
			$arreglo['clientes'][$row['idCliente']]['id'] = $row['idCliente'];
			$arreglo['clientes'][$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$arreglo['dias'][$row['idCliente']][$row['idDia']]['dia'] = $row['idDia'];
		}
		
		$html='';
		$html.='<table class="table">';
			$html.='<thead>';
				$html.='<tr>';
					$html.='<th>			</th>';
					$html.='<th>#			</th>';
					$html.='<th>IDCLIENTE	</th>';
					$html.='<th>CLIENTE		</th>';
					$html.='<th>LUNES		</th>';
					$html.='<th>MARTES		</th>';
					$html.='<th>MIERCOLES	</th>';
					$html.='<th>JUEVES		</th>';
					$html.='<th>VIERNES		</th>';
					$html.='<th>SABADO		</th>';
					$html.='<th>DOMINGO		</th>';
				$html.='</tr>';
			$html.='<thead>';
			$html.='<tbody>';
				$i=1; if(isset($arreglo['clientes'])){foreach($arreglo['clientes'] as $row => $value ) {
					$html.='<tr>';
						$html.='<td>';
						/*$flagModulacion = $this->session->userdata('flag_modulacion');
						if($flagModulacion==1){
							$html.='<a href="javascript:;" class="eliminar_visita_programada btn btn-default btn-xs" data-idCliente="'.$row.'" data-idRutaProg="'.$idRutaProg.'" style="float: left;"><i class="fa fa-trash"></i></a>';
						}*/
						$html.='</td>';
						$html.='<td>'.$i.'</td>';
						$html.='<td>'.$value['id'].'</td>';
						$html.='<td>'.$value['razonSocial'].'</td>';
						$lunes_1=isset($arreglo['dias'][$row][1]['dia'])?1:'-';
						$martes_1=isset($arreglo['dias'][$row][2]['dia'])?1:'-';
						$miercoles_1=isset($arreglo['dias'][$row][3]['dia'])?1:'-';
						$jueves_1=isset($arreglo['dias'][$row][4]['dia'])?1:'-';
						$viernes_1=isset($arreglo['dias'][$row][5]['dia'])?1:'-';
						$sabado_1=isset($arreglo['dias'][$row][6]['dia'])?1:'-';
						$domingo_1=isset($arreglo['dias'][$row][7]['dia'])?1:'-';
						$html.='<td>'.$lunes_1.'</td>';
						$html.='<td>'.$martes_1.'</td>';
						$html.='<td>'.$miercoles_1.'</td>';
						$html.='<td>'.$jueves_1.'</td>';
						$html.='<td>'.$viernes_1.'</td>';
						$html.='<td>'.$sabado_1.'</td>';
						$html.='<td>'.$domingo_1.'</td>';
					$html.='</tr>';
				$i++; } }
			$html.='</tbody>';
		$html.='</table>';
		
		$response = array( 
				'msg' => array('title' => 'VALIDAR ACTUALIZACION', 'content' => $mensaje)
				, 'data' => $html
				, 'result' => $resultado_final
			);
			
		echo json_encode($response);
		
	}
	
	public function form_editar_usuarios_rutas_tradicional(){
		$data=json_decode($this->input->post('data'));
		$id=$data->{'id'};

		$params=array(
			  'id'=>$id
		);
		$arreglo= array();
		$result['result']=1;
		$data_ruta = $this->model->obtener_usuario_ruta_tradicional($params);
		$usuario = $this->model->obtener_gtm();
		
		$arreglo['data']=$data_ruta;
		$arreglo['usuario']=$usuario;

		$result['data']=$this->load->view("modulos/configuraciones/master/rutas/editar_usuarios_rutas_tradicional", $arreglo, true); 
		echo json_encode($result);
	}

	public function registrar_rutas(){
		$data = json_decode($this->input->post('data'));
		$fechaCarga = $data->{'fechaCarga'};
		$fechaLista = $data->{'fechaLista'};
		$modulos = $data->{'modulos'};
		$idUsuario = $data->{'idUsuario'};
		
		$fechasC = explode('-',$fechaCarga);
		$fechasL = explode('-',$fechaLista);
		$fecIniCarga = $fechasC[0];
		$fecFinCarga = $fechasC[1];
		
		$fecIniLista = $fechasL[0];
		$fecFinLista = $fechasL[1];
		$array_usuario=array();
		if(!is_array($idUsuario)){
			$array_usuario[0] = $idUsuario; 
		}else{
			$array_usuario=$idUsuario;
		}
		
		$array_modulo=array();
		if(!is_array($modulos)){
			$array_modulo[0] = $modulos; 
		}else{
			$array_modulo=$modulos;
		}
		
		foreach($array_usuario as $row){
			$validar = "SELECT * FROM trade.master_permisos WHERE idUsuario =".$row." AND fecIniCarga='".$fecIniCarga."' AND fecFinCarga='".$fecFinCarga."' ";
			$validacion = $this->db->query($validar)->result_array();
			if(count($validacion)>0){
				$eliminar_duplicado_modulos = "DELETE FROM trade.master_permiso_modulo WHERE idPermiso IN(SELECT idPermiso FROM trade.master_permisos WHERE idUsuario =".$row." AND fecIniCarga='".$fecIniCarga."' AND fecFinCarga='".$fecFinCarga."' )  ";
				$eliminar_duplicado = "DELETE FROM trade.master_permisos WHERE idUsuario =".$row." AND fecIniCarga='".$fecIniCarga."' AND fecFinCarga='".$fecFinCarga."' ";
				$this->db->query($eliminar_duplicado_modulos);
				$this->db->query($eliminar_duplicado);
			}
			
			$insert_permiso = array(
				'fecIniCarga' => $fecIniCarga,
				'fecFinCarga' => $fecFinCarga,
				'fecIniLista' => $fecIniLista,
				'fecFinLista' => $fecFinLista,
				'idUsuario' => $row,
			);
			$this->db->insert('trade.master_permisos',$insert_permiso);
			$id=$this->db->insert_id();
			foreach($array_modulo as $r){
				$validar_1 = "SELECT * FROM trade.master_permiso_modulo WHERE idPermiso = $id AND idModulo=$r ";
				$validar_mod = $this->db->query($validar_1)->result_array();
				if(count($validar_mod)>0){
					$eliminar = "DELETE FROM trade.master_permiso_modulo WHERE idPermiso = $id AND idModulo=$r ";
					$this->db->query($eliminar);
				}
				
				$insert_modulo = array(
					'idPermiso' => $id,
					'idModulo' => $r,
					'estado'=>1
				);
				$this->db->insert('trade.master_permiso_modulo',$insert_modulo);
			}
		}
		
		//RESULTADOS
		$result['data'] = 'SE REGISTRO CON EXITO.';
		$result['result'] = 1;
		echo json_encode($result);
		
	}
	
	public function registrar_modulacion(){
		$post=json_decode($this->input->post('data'),true);
		
		$idUsuario = $this->session->userdata('idUsuario');
		//print_r($post);exit;
		$fecIni = $post['fecIni'];
		$fecFin = $post['fecFin'];
		//$idGrupoCanal = $post['idGrupoCanal'];
		$total = count($post);
		for($i=0;$i<$total;$i++){
			if(isset($post[$i]['idCliente'])){
				$idCliente = $post[$i]['idCliente'];
				$total_elementos = count( $post[$i]['modulacion']);
				$total_categorias=0;
				$filtro_categoria = '';
				if($total_elementos>0){
					for($m=0;$m<$total_elementos;$m++){
						if($m==$total_elementos-1){
							$filtro_categoria.=$post[$i]['modulacion'][$m];
						}else{
							$filtro_categoria.=$post[$i]['modulacion'][$m].',';
						}
					}
					$sql = "SELECT DISTINCT idCategoria FROM trade.elementoVisibilidadTrad WHERE idElementoVis IN ( $filtro_categoria ) ";
					$categorias = $this->db->query($sql)->result();
					$total_categorias=count($categorias);
				}
				
				$params=array(
					  'fecIni'			=>	$fecIni //.'-'.$fecFin
					, 'fecFin'			=>	$fecFin
					, 'idCliente' 		=>	$idCliente
				);
				
				$result['result']=1;
				$idUsuario = $this->session->userdata('idUsuario');
					$clientes=$this->model->obtener_clientes($params);
					$idClienteTipo =$clientes[0]['subcanal'];
			
				$sql = "SELECT DISTINCT ISNULL(minCategorias,0) minCategorias, ISNULL(minElementosOblig,0) minElementosOblig FROM {$this->sessBDCuenta}.trade.master_modulacion_validaciones WHERE idClienteTipo = 1 AND General.dbo.fn_fechaVigente(fecIni,fecFin,'$fecIni','$fecFin')=1";
				$validaciones_carga = $this->db->query($sql)->result_array();

				$minCategorias=0;
				$minElementosOblig=0;
				if(count($validaciones_carga)>0){
					$minCategorias=$validaciones_carga[0]['minCategorias'];
					$minElementosOblig=$validaciones_carga[0]['minElementosOblig'];
				}
				$validacion_elementos=0;
				$validacion_categorias=0;
				//if($minElementosOblig!=0){
					if($minElementosOblig<=$total_elementos){
						$validacion_elementos=1;
					}
				//}
				
				//if($minCategorias!=0){
					if($minCategorias<=$total_categorias){
						$validacion_categorias=1;
					}
				//}
				$procesar_carga=0;
				if($validacion_categorias==1 && $validacion_elementos==1){
					$procesar_carga=1;
				}
				

				if($total_elementos>0 && $procesar_carga==1){

					
					$data_cliente = $this->db->query($sql)->row_array();
					$idCanal = $data_cliente['idCanal'];
					$validar_lista = "SELECT * FROM {$this->sessBDCuenta}.trade.list_visibilidadTrad WHERE idCliente= $idCliente AND fecIni='".$fecIni."' AND fecFin = '".$fecFin."' ";
					$res_validacion = $this->db->query($validar_lista)->row_array();
					$total =count($res_validacion);
					if($total==0){
						$insert = array(
							  'idCliente'	 	=> $idCliente
							, 'fecIni' 			=> $fecIni
							, 'fecFin' 			=> $fecFin
							, 'idProyecto'		=> 2
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.list_visibilidadTrad",$insert);
						$id = $this->db->insert_id();
						for($j=0;$j<$total_elementos;$j++){
							$idElemento = $post[$i]['modulacion'][$j];
							$insert_elementos = array(
								  'idListVisibilidad' => $id
								, 'idElementoVis' => $idElemento
								, 'estado' => 2
							);
							$this->db->insert("{$this->sessBDCuenta}.trade.list_visibilidadTradDet",$insert_elementos);
						}
					}else{
						$id =$res_validacion['idListVisibilidad'];
						$delete = "delete from  {$this->sessBDCuenta}.trade.list_visibilidadTradDet WHERE idListVisibilidad=".$id;
						$this->db->query($delete);
						for($j=0;$j<$total_elementos;$j++){
							
							$idElemento = $post[$i]['modulacion'][$j];
							$insert_elementos = array(
								  'idListVisibilidad' => $id
								, 'idElementoVis' => $idElemento
								, 'estado' => 1
							);
							$this->db->insert("{$this->sessBDCuenta}.trade.list_visibilidadTradDet",$insert_elementos);
						}
						
					}
					$mensaje='Se registro data con exito.';
				}
				else{
					$mensaje='NO SE PROCESARON TODOS LOS CLIENTES DEBIDO A QUE NO TIENEN LAS CANTIDAD DE CATEGORIAS Y/O ELEMENTOS MINIMO.<br>LOS CLIENTE EN COLOR ROJO SON LOS PUNTOS NO PROCESADOS. <br>VALIDAR EN LA COLUMNA VALIDACIONES DEL REPORTE.';
				}
			}
		}
		
		$response = array( 'msg' => array('title' => 'Confirmacion', 'content' => $mensaje), 'data' => $mensaje, 'result' => 1);

		echo json_encode($response);
	}
	
	public function form_eliminar_rutas(){
		$data=json_decode($this->input->post('data'));
		$id=$data->{'id'};

		$arreglo= array();
		$result['result']=1;

		$arreglo['idRutaProg'] = $id;
		$data_ruta_visitas = $this->model->obtener_ruta_detalle($id);
	
		foreach($data_ruta_visitas as $row){
			$arreglo['clientes'][$row['idCliente']]['id'] = $row['idCliente'];
			$arreglo['clientes'][$row['idCliente']]['idVisitaProg'] = $row['idVisitaProg'];
			$arreglo['clientes'][$row['idCliente']]['razonSocial'] = $row['razonSocial'];
		}
		
		$result['data']=$this->load->view("modulos/configuraciones/master/rutas/eliminar_rutas", $arreglo, true); 
		echo json_encode($result);
	}

	public function cargaMasivaRuta(){
		$result = $this->result;

		$html='';
		$array=array();
		$array['tiposUsuario'] = $this->model->obtener_tipo_usuario();
		$html .= $this->load->view("modulos/configuraciones/master/rutas/cargaMasivaRutas", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR RUTA MASIVO';
		$result['data']['html'] = $html;	

		echo json_encode($result);
	}
	
	public function clonarRuta(){
		$result = $this->result;

		$html='';
		$array=array();
		$array['rutas']= $this->model->obtener_rutas_activas();
		$array['gtm']= $this->model->obtener_gtm();
		$html .= $this->load->view("modulos/configuraciones/master/rutas/clonarRutas", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'CLONAR RUTA';
		$result['data']['html'] = $html;	
		echo json_encode($result);
	}
	
	public function importarRuta(){
		$data=json_decode($this->input->post('data'));
		$id=$data->{'idRuta'};

		$result = $this->result;

		$html='';
		
		$array=array();
		
		$data_ruta_visitas = $this->model->obtener_ruta_detalle($id);
	
		foreach($data_ruta_visitas as $row){
			$clientes[$row['idCliente']]['id'] = $row['idCliente'];
			$clientes[$row['idCliente']]['idVisitaProg'] = $row['idVisitaProg'];
			$clientes[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$dias[$row['idCliente']][$row['idDia']]['dia'] = $row['idDia'];
		}
		
		$html='';
		
		foreach($clientes as $row => $value){
			//foreach($dias[$row] as $row_d => $value_d){
				$lunes = !empty($dias[$row][1])?'1':0;
				$martes = !empty($dias[$row][2])?'1':0;
				$miercoles = !empty($dias[$row][3])?'1':0;
				$jueves = !empty($dias[$row][4])?'1':0;
				$viernes = !empty($dias[$row][5])?'1':0;
				$sabado = !empty($dias[$row][6])?'1':0;
				$domingo = !empty($dias[$row][7])?'1':0;
			//}
			$html.='{ idCliente:'.$row.', lunes:'.$lunes.',martes:'.$martes.',miercoles:'.$miercoles.',jueves:'.$jueves.', viernes:'.$viernes.', sabado:'.$sabado.', domingo:'.$domingo.' },';
		}
		
		$array['visitas'] = $html;
		
		$html= $this->load->view("modulos/configuraciones/master/rutas/rutaImportada", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'CLONAR RUTA';
		$result['data']['html'] = $html;	
		echo json_encode($result);
	}

	public function registrarClonacion(){
		$data = json_decode($this->input->post('data'),true);
		
		$fecIni=$data['fecIni'];
		$fecFin=$data['fecFin'];
		$nombreRuta=$data['nombreRuta'];
		$idGtm=$data['idGtm'];

		$array_cliente = array();
		$array_lunes = array();
		$array_martes = array();
		$array_miercoles = array();
		$array_jueves = array();
		$array_viernes = array();
		$array_sabado = array();
		$array_domingo = array();
	
		foreach($data['clientes'] as $row){
			$array_cliente[]=$row[0];
			$array_lunes[$row[0]]=$row[1];
			$array_martes[$row[0]]=$row[2];
			$array_miercoles[$row[0]]=$row[3];
			$array_jueves[$row[0]]=$row[4];
			$array_viernes[$row[0]]=$row[5];
			$array_sabado[$row[0]]=$row[6];
			$array_domingo[$row[0]]=$row[7];
		}
		

			$insert_ruta = array(
				'nombreRuta' => $nombreRuta
				,'fecIni' => $fecIni
				,'numClientes'=>0
			);
			if(!empty($fecFin)){
				$insert_ruta['fecFin'] = $fecFin;
			}
			
			$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramada",$insert_ruta);
			$idRutaProg = $this->db->insert_id();

			$insert_gtm = array(
				  'idRutaProg' => $idRutaProg
				, 'fecIni' => $fecIni
				, 'idUsuario' => $idGtm
			);
			if(!empty($fecFin)){
				$insert_gtm['fecFin'] = $fecFin;
			}
			$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramadaDet",$insert_gtm);
			$idRutaProgDet = $this->db->insert_id();
		
			
		if(count($array_cliente)){
			foreach( $array_cliente as $row ){
				$idCliente = $row;
				$sql = "SELECT idVisitaProg FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idCliente =".$idCliente." AND idRutaProg = ".$idRutaProg." " ;
				$res = $this->db->query($sql)->row_array();
				if($res!=null){
					if(count($res)){
						$idVisitaProg=$res['idVisitaProg'];
						$delete = "DELETE FROM {$this->sessBDCuenta}.trade.master_visitaProgramadaDet WHERE idVisitaProg =".$idVisitaProg;
						$this->db->query($delete);
					}else {
						$array_visita = array();
						$array_visita['idRutaProg'] = $idRutaProgDet;
						$array_visita['idCliente'] = $idCliente;
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada",$array_visita);
						$idVisitaProg=$this->db->insert_id();
					}
				}else {
					$array_visita = array();
					$array_visita['idRutaProg'] = $idRutaProgDet;
					$array_visita['idCliente'] = $idCliente;
					$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada",$array_visita);
					$idVisitaProg=$this->db->insert_id();
				}
				
				
				$lunes = isset($array_lunes[$idCliente])?$array_lunes[$idCliente]:'';
				$martes = isset($array_martes[$idCliente])?$array_martes[$idCliente]:'';
				$miercoles = isset($array_miercoles[$idCliente])?$array_miercoles[$idCliente]:'';
				$jueves = isset($array_jueves[$idCliente])?$array_jueves[$idCliente]:'';
				$viernes = isset($array_viernes[$idCliente])?$array_viernes[$idCliente]:'';
				$sabado = isset($array_sabado[$idCliente])?$array_sabado[$idCliente]:'';
				$domingo = isset($array_domingo[$idCliente])?$array_domingo[$idCliente]:'';

					if(!empty($lunes) && $lunes==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 1
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($martes) && $martes==1){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 2
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
		
					if(!empty($miercoles) && $miercoles==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 3
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				
					if(!empty($jueves) && $jueves==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 4
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				
					if(!empty($viernes ) && $viernes==1){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 5
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($sabado) && $sabado==1){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 6
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($domingo) && $domingo==1 ){
						$insert_visitaDet = array();
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' =>7
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				

			}
			
			$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
			$res = $this->db->query($total_clientes)->row_array();
			$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
			$this->db->query($update);
		}
			
			$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
			$res = $this->db->query($total_clientes)->row_array();
			$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
			$this->db->query($update);
		
		
		$response = array( 
				'msg' => array('title' => 'VALIDAR ACTUALIZACION', 'content' => 'Se registro con exito.' )
				, 'data' => 'Se registro con exito.'
				, 'result' => 1
			);
			
		echo json_encode($response);
	}
	
	public function registrarMasivo(){
		set_time_limit(0);
		$data = json_decode($this->input->post('data'),true);
		
		
		$fecIni=$data['fecIni'];
		$fecFin=$data['fecFin'];
		$array_ruta = array();
		$array_gtm = array();
		$array_cliente = array();
		$array_lunes = array();
		$array_martes = array();
		$array_miercoles = array();
		$array_jueves = array();
		$array_viernes = array();
		$array_sabado = array();
		$array_domingo = array();

		$cont_registrado=0;
		$cont_existentes=0;
		
	
		foreach($data['clientes'] as $row){
			$array_ruta[$row[0]]=$row[0];
			$array_gtm[$row[0]]=$row[1];
			$array_cliente[$row[0]][]=$row[2];
			$array_lunes[$row[0]][$row[2]]=$row[3];
			$array_martes[$row[0]][$row[2]]=$row[4];
			$array_miercoles[$row[0]][$row[2]]=$row[5];
			$array_jueves[$row[0]][$row[2]]=$row[6];
			$array_viernes[$row[0]][$row[2]]=$row[7];
			$array_sabado[$row[0]][$row[2]]=$row[8];
			$array_domingo[$row[0]][$row[2]]=$row[9];
		}

		$generado= ($data['generacion']=="completa")? 1 : 0; 
		
		foreach($array_ruta as $row => $value){
			$insert_ruta = array(
				'nombreRuta' => $value
				,'fecIni' => $fecIni
				,'numClientes'=>0
				,'idUsuarioReg'=>$this->session->idUsuario
				,'generado'=>$generado
			);
			if(!empty($fecFin)){
				$insert_ruta['fecFin'] = $fecFin;
			}
			
			$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramada",$insert_ruta);
			$idRutaProg = $this->db->insert_id();

			$insert_gtm = array(
				  'idRutaProg' => $idRutaProg
				, 'fecIni' => $fecIni
				, 'idUsuario' => $array_gtm[$row]
			);
			if(!empty($fecFin)){
				$insert_gtm['fecFin'] = $fecFin;
			}
			$this->db->insert("{$this->sessBDCuenta}.trade.master_rutaProgramadaDet",$insert_gtm);
		
			
			foreach($array_cliente[$row] as $row_c => $value_c){
				$insert_visita = array(
					  'idRutaProg' => $idRutaProg
					, 'idCliente' => $value_c
				);
				$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramada", $insert_visita);
				$idVisitaProg = $this->db->insert_id();
				
				$lunes = isset($array_lunes[$row][$value_c])?$array_lunes[$row][$value_c]:'';
				$martes = isset($array_martes[$row][$value_c])?$array_martes[$row][$value_c]:'';
				$miercoles = isset($array_miercoles[$row][$value_c])?$array_miercoles[$row][$value_c]:'';
				$jueves = isset($array_jueves[$row][$value_c])?$array_jueves[$row][$value_c]:'';
				$viernes = isset($array_viernes[$row][$value_c])?$array_viernes[$row][$value_c]:'';
				$sabado = isset($array_sabado[$row][$value_c])?$array_sabado[$row][$value_c]:'';
				$domingo = isset($array_domingo[$row][$value_c])?$array_domingo[$row][$value_c]:'';

					if(!empty($lunes) && $lunes==1 ){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 1
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($martes) && $martes==1){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 2
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
		
					if(!empty($miercoles) && $miercoles==1 ){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 3
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				
					if(!empty($jueves) && $jueves==1 ){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 4
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
				
					if(!empty($viernes ) && $viernes==1){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 5
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($sabado) && $sabado==1){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' => 6
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}

					if(!empty($domingo) && $domingo==1 ){
						$insert_visitaDet = array(
							  'idVisitaProg' => $idVisitaProg
							, 'idDia' =>7
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.master_visitaProgramadaDet",$insert_visitaDet);
					}
					
			}
			
			$total_clientes = "SELECT count(*) total FROM {$this->sessBDCuenta}.trade.master_visitaProgramada WHERE idRutaProg = ".$idRutaProg;
			$res = $this->db->query($total_clientes)->row_array();
			$update = "UPDATE {$this->sessBDCuenta}.trade.master_rutaProgramada SET numClientes=".$res['total']." WHERE idRutaProg = ".$idRutaProg;
			$this->db->query($update);

			
			$data_ruta_visitas_prog = $this->model->obtener_ruta_programada_visitas($idRutaProg);
			if($data_ruta_visitas_prog!=null){
				if( count($data_ruta_visitas_prog)>0){
					
					$idProyecto=($this->session->userdata('idProyecto')=='13')? '3': $this->session->userdata('idProyecto') ;
					$idCuenta=$this->session->userdata('idCuenta');
					foreach($data_ruta_visitas_prog as $r){
						$params=array();
						$params['idCuenta']=$idCuenta;
						$params['idProyecto']=$idProyecto;
						$params['fecha']=$r['fecha'];
						$params['idCliente']=$r['idCliente'];
						$params['idUsuario']=$r['idUsuario'];
						$params['idTipoUsuario']= $data['tipoUsuario'];

						$res=$this->model->insertar_visita_ruta($params);
						if($res){
							$cont_registrado++;
						}else{
							$cont_existentes++;
						}
					}
				}
			}

			//
			// if($generado){
			// 	$update = "exec [dbo].[procesar_rutas_master_manual] ".$idRutaProg."; ";
			// 	$this->db->query($update);

			// }
		}

		$html='Se registro con exito.<br>';
		$html.='<div class="alert alert-success fade show" role="alert"><i class="fas fa-store-alt"></i> SE LOGRÓ REGISTRAR <strong>'.$cont_registrado.' CLIENTE(S)</strong> CORRECTAMENTE.</div>';
		if($cont_existentes>1){
			$html.='<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> HUBO INCONVENIENTES AL REGISTRAR EL <strong>'.$cont_existentes.' CLIENTE(S)</strong> CON LA DATA BRINDADA.</div>';
		}
		$response = array( 
				'msg' => array('title' => 'VALIDAR ACTUALIZACION', 'content' => 'Se registro con exito.' )
				, 'data' => $html
				, 'result' => 1
			);
			
		echo json_encode($response);
	}

	public function descargar_data(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		require_once '../phpExcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		/* STYLES */
		$estilos_cabecera = 
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '00a985')
			),
			'font'  => array(
				'color' => array('rgb' => 'ffffff'),
				'size'  => 11,
				'name'  => 'Calibri'
			),
			'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$estilos = 
		array(
			'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		
		$celda = 
		array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '3b65b1')
			),
			'font'  => array(
				'color' => array('rgb' => 'ffffff'),
				'size'  => 11,
				'name'  => 'Calibri'
			),
			'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		/*FIN STYLES*/
		
		
		$objPHPExcel->getActiveSheet()->setTitle('GTM');
		$objPHPExcel->setActiveSheetIndex(0);	
		$clientes = $objPHPExcel->createSheet(1);
		$clientes->setTitle('CLIENTES');
		
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'IDGTM')
					->setCellValue('B1', 'GTM');
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($estilos_cabecera);
		$data = $this->model->obtener_gtm();
		$cont=2;
		foreach($data as $row){
		 	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$cont, $row['idUsuario'])
					->setCellValue('B'.$cont, $row['nombres']);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':B'.$cont)->applyFromArray($estilos);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
			$cont++;
		}
		
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue('A1', 'IDCLIENTE')
					->setCellValue('B1', 'RAZON SOCIAL');
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($estilos_cabecera);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$data = $this->model->obtener_clientes();
		
		$cont=2;
		foreach($data as $row){
		 	$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue('A'.$cont, $row['idCliente'])
					->setCellValue('B'.$cont, $row['razonSocial']);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':B'.$cont)->applyFromArray($estilos);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
			$cont++;
		}
		
		 
		/* $objPHPExcel->setActiveSheetIndex(8)
					->setCellValue('A1', 'NOMBRE')
					->setCellValue('B1', 'IDPROYECTO');
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($estilos_cabecera);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$data = $this->model->obtener_proyecto();
		$cont=2;
		foreach($data as $row){
			$objPHPExcel->setActiveSheetIndex(8)
					->setCellValue('A'.$cont, $row->nombre)
					->setCellValue('B'.$cont, $row->idProyecto);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':B'.$cont)->applyFromArray($estilos);
			$cont++;
		}
		
		$objPHPExcel->setActiveSheetIndex(9)
					->setCellValue('A1', 'PROMOCION')
					->setCellValue('B1', 'IDPROMOCION');
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($estilos_cabecera);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$data = $this->model->obtener_promociones();
		$cont=2;
		foreach($data->result() as $row){
			$objPHPExcel->setActiveSheetIndex(9)
					->setCellValue('A'.$cont, $row->nombre)
					->setCellValue('B'.$cont, $row->idPromocion);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$cont.':B'.$cont)->applyFromArray($estilos);
			$cont++;
		}
		

		 */
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="maestros.xlsx"');
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');

		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

	}

	public function generar_rutas_manual(){
		$result = $this->result;
		$array=array();
		$this->model->generar_rutas_manual();

		$result['result']=1;
		$result['msg']['title'] = 'GENERAR RUTAS/VISITAS DEL DIA';
		$result['msg']['content'] = 'RUTAS/VISITAS generadas correctamente.';

		echo json_encode($result);
	}

	public function formRutaGenerada(){
		$data=json_decode($this->input->post('data'));
		$id=$data->{'id'};
		$fecIni=$data->{'fecIni'};
		$fecFin=$data->{'fecFin'};

		$params=array(
			'id'=>$id
			, 'fecIni'=>$fecIni
		);
	  
	  	$params['fecFin'] = !empty($fecFin)?$fecFin:$fecIni;
		
		$arreglo= array();
		$result['result']=1;
		$data_ruta = $this->model->obtener_ruta($params);
		
		$data_ruta_visitas = $this->model->obtenerRutaGenerada($id);
	

		//calendar
		$eventos = [];
		foreach ($data_ruta_visitas as $fechaUnix => $ruta) {
			$eventos[$fechaUnix]['start'] = $ruta['fecha'];
			$eventos[$fechaUnix]['epFecha'] = $ruta['fecha'];
			$eventos[$fechaUnix]['title'] = $ruta['idCliente'];
			$eventos[$fechaUnix]['color'] = 'blue';
		}
		$calendarEvents = array_values($eventos);
		
		$arreglo['data']=$data_ruta;


		$result['data']['width'] = '60%';
		$result['data']['fullCalendar'] = [];
		$result['data']['fullCalendar']['events'] = $calendarEvents;

		$arrFecha= explode("/",$fecIni);
		$result['data']['fullCalendar']['startDate'] = $arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0];

		$result['data']['html']=$this->load->view("modulos/configuraciones/master/rutas/rutaGenerada", $arreglo, true); 
		echo json_encode($result);
	}

	public function rutasCargaMasivaAlternativa(){
		
		$result = $this->result;
		$data = json_decode($this->input->post('data'), true);

		$html='';
		$htmlWidth='90%';
		$array=array();

		$data_carga = array();
		$i=0;
		$resultados=$this->model->obtener_estado_carga();
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['fecRegistro']=$row['fecRegistro'];
			$data_carga[$i]['horaRegistro']=$row['horaRegistro'];
			$data_carga[$i]['horaFin']=$row['horaFin'];
			$data_carga[$i]['noProcesados']=$row['noProcesados'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['totalRegistros']=$row['totalRegistros'];
			$data_carga[$i]['estado']=$row['estado'];
			$data_carga[$i]['generado']=$row['generado'];
			$data_carga[$i]['fecI']=$row['fecI'];
			$data_carga[$i]['fecF']=$row['fecF'];
			$i++;
		}
		$array['data_carga']= $data_carga;
		$array['tiposUsuario'] = $this->model->obtener_tipo_usuario();
		$html.= $this->load->view("modulos/configuraciones/master/rutas/registrar_masivo_alternativa", $array, true);

		$result['msg']['title'] = 'GENERAR CARGA RUTAS';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}


	public function generar_formato_carga_masiva_alternativa(){
		////
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$idProyecto= $this->session->idProyecto;
		
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
					->setCellValue('A1', 'NOMBRE RUTA')
					->setCellValue('B1', 'ID GTM')
					->setCellValue('C1', 'ID CLIENTE')
					->setCellValue('D1', 'LUNES')
					->setCellValue('E1', 'MARTES')
					->setCellValue('F1', 'MIERCOLES')
					->setCellValue('G1', 'JUEVES')
					->setCellValue('H1', 'VIERNES')
					->setCellValue('I1', 'SABADO');
					
		if($idProyecto==17){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('J1', 'DOMINGO')
					->setCellValue('K1', 'REFRIGERIO')
					->setCellValue('L1', 'DESCANSO');
		}else{
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('J1', 'DOMINGO');
		}

		$i=1;
		if($idProyecto==17){
			$horarios = $this->model->obtener_horarios();

			if(count($horarios)>0){
				$objWorkSheet = $objPHPExcel->createSheet($i);
				$objWorkSheet->setCellValue('A1', 'IDHORARIO');
				$objWorkSheet->setCellValue('B1', 'HORA INGRESO');
				$objWorkSheet->setCellValue('C1', 'HORA SALIDA');
				$m=2;
				foreach($horarios as $row){
					 $objWorkSheet->setCellValue('A'.$m, $row['idHorario']);
					 $objWorkSheet->setCellValue('B'.$m, $row['horaIni']);
					 $objWorkSheet->setCellValue('C'.$m, $row['horaFin']);
					 $m++;
				}
				$objWorkSheet->setTitle("HORARIOS");
		  	}	

		}
	   $objPHPExcel->setActiveSheetIndex($i);
	   $i++;

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="rutas_formato.xlsx"');
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


	public function estado_carga(){
		$resultados=$this->model->obtener_estado_carga();
		$data_carga = array();
		$i=0;
		foreach($resultados as $row){
			$data_carga[$i]['idCarga']=$row['idCarga'];
			$data_carga[$i]['total']=$row['totalRegistros'];
			$data_carga[$i]['totalClientes']=$row['totalClientes'];
			$data_carga[$i]['total_procesados']=$row['total_procesados'];
			$data_carga[$i]['noProcesados']=$row['noProcesados'];
			$data_carga[$i]['error']=$row['error'];
			$data_carga[$i]['generado']=$row['generado'];
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

		
		$fecIni = $_POST['fecIni'];
		$fecFin = $_POST['fecFin'];
		
		$generado = $_POST['generado'];
		$idTipoUsuario = $_POST['tipoUsuario'];


		$datetime = date('dmYHis');
		$nombre_carpeta = 'rutas_'.$datetime;
		//
		$ruta = 'public/csv/rutas/'.$nombre_carpeta;
		$rutaFiles = 'public/csv/rutas/'.$nombre_carpeta.'/archivos';

		mkdir($ruta, 0777,true);
		mkdir($rutaFiles, 0777,true);
		
		chmod($ruta, 0777);
		chmod($rutaFiles, 0777);
		
		
		copy($_FILES['file']['tmp_name'],$ruta.'/rutas_'.$datetime.'.csv');
		
		$size = 100000; // 1kb
		$to_read = $ruta.'/rutas_'.$datetime.'.csv';
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
				file_put_contents($to_read_files.'rutas_'.$part.'.csv',$header.$chunk);
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

		$idProyecto=$this->session->userdata('idProyecto') ;
		$idCuenta=$this->session->userdata('idCuenta');
		$carga = array();
		$carga = array(
			'fecIni' => $fecIni,
			'fecFin' => $fecFin,
			'carpeta' => $nombre_carpeta,
			'totalRegistros' => $total,
			'generado' => $generado,
			'idCuenta' => $idCuenta,
			'idProyecto' => $idProyecto,
			'idTipoUsuario' => $idTipoUsuario
		);

		$this->db->insert("{$this->sessBDCuenta}.trade.cargaRuta",$carga);

		$result=array();
		$result['data']= '1';
		
		$html = "";
		
		$data=$this->model->obtener_estado_carga();
		
		if(count($data)>0){
			$html.='<table class="table table-striped table-bordered nowrap table-sm">';
				$html.='<thead>';
					$html.='<tr>';
						$html.='<th>IDCARGA</th>';
						$html.='<th>FECHA INICIO</th>';
						$html.='<th>FECHA FIN</th>';
						$html.='<th>GENERACION</th>';
						$html.='<th>FECHA CARGA</th>';
						$html.='<th>HORA CARGA</th>';
						$html.='<th>HORA FIN CARGA</th>';
						$html.='<th>TOTAL FILAS EXCEL</th>';
						$html.='<th>TOTAL FILAS EXCEL CARGADAS</th>';
						$html.='<th>TOTAL FILAS PROCESADAS</th>';
						$html.='<th>TOTAL FILAS NO PROCESADAS</th>';
						$html.='<th>ERRORES</th>';
						$html.='<th></th>';
					$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					foreach($data as $row){
						$estado_generado="Diaria";
						if($row['generado']=='1'){
							$estado_generado="Completo";
						}
						$html.='<tr>';
							$html.='<td>'.$row['idCarga'].'</td>';
							$html.='<td>'.$row['fecI'].'</td>';
							$html.='<td>'.$row['fecF'].'</td>';
							$html.='<td>'.$estado_generado.'</td>';
							$html.='<td>'.$row['fecRegistro'].'</td>';
							$html.='<td>'.$row['horaRegistro'].'</td>';
							$html.='<td>'.$row['horaFin'].'</td>';
							$html.='<td>'.$row['totalRegistros'].'</td>';
							$html.='<td id="clientes_'.$row['idCarga'].'">'.$row['totalClientes'].'</td>';
							$html.='<td id="procesados_'.$row['idCarga'].'">'.$row['total_procesados'].'</td>';
							$html.='<td id="noprocesados_'.$row['idCarga'].'">'.$row['noProcesados'].'</td>';
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


	public function generar_formato_errores($id){
		////
		$rs_rutas = $this->model->obtener_rutas_no_procesado($id);
		
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
			 $objWorkSheet->setCellValue('A1', 'ID CLIENTE');
			 $objWorkSheet->setCellValue('B1', 'ID USUARIO');
			 $objWorkSheet->setCellValue('C1', 'DATO INGRESADO');
			 $objWorkSheet->setCellValue('D1', 'ERROR');
			 $m=2;
			 foreach($rs_rutas as $row){
				  $objWorkSheet->setCellValue('A'.$m, $row['idCliente']);
				  $objWorkSheet->setCellValue('B'.$m, $row['idUsuario']);
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

	
}
?>