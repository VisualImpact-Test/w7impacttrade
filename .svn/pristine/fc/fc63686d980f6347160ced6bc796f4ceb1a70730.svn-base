<?php
class Iniciativas extends MY_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_iniciativas', 'model');
	}

	public function index(){
		$config = array();
		$config['nav']['menu_active'] = '85';
		$config['css']['style'] = array(
			'assets/libs/datatables/dataTables.bootstrap4.min',
			'assets/libs/datatables/buttons.bootstrap4.min',
			'assets/custom/css/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/iniciativas'
		);

		$config['data']['icon'] = 'fad fa-chart-pie';
		$config['data']['title'] = 'Iniciativas';
		$config['data']['message'] = 'Iniciativas';
		$config['view'] = 'modulos/iniciativas/index';

		$params = array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$rs_tipo_usuario = $this->model->obtener_tipos_usuarios($params);
		$config['data']['tipoUsuario'] = $rs_tipo_usuario;

		$rs_elementos = $this->model->obtener_elementos_visibilidad($params);
		$config['data']['elementos'] = $rs_elementos;

		$rs_distribuidora = $this->model->obtener_distribuidora_sucursal();
		$config['data']['distribuidoras'] = $rs_distribuidora;


		$this->view($config);
	}
	
	public function lista_iniciativas(){
		$post = json_decode($this->input->post('data'), true);
		
		$fechas = explode('-',$post['txt-fechas']);
		$fechaIni = $fechas[0];
		$fechaFin = $fechas[1];
		$params = array(
			  'fecIni' => $fechaIni
			, 'fecFin' => $fechaFin
		);

		$params['cuenta'] =$post['cuenta_filtro'];
		$params['proyecto'] =$post['proyecto_filtro'];
		$params['grupoCanal'] =$post['grupoCanal_filtro'];
		$params['canal']  =$post['canal_filtro'];
		$params['subcanal'] =$post['subcanal_filtro'];
		$params['foto'] =$post['conFoto'];
		$params['validado'] =$post['validado'];	
		$params['usuario'] =$post['usuario'];	

		$elementos="";
		if( !empty($post['idElemento'])){
			if( is_array($post['idElemento'])){
				$elementos=implode(",",$post['idElemento']);
			}else{
				$elementos=$post['idElemento'];
			}
		}
		$params['elementos'] =$elementos;

		$idDistribuidoraSucursal="";
		if( !empty($post['idDistribuidoraSucursal'])){
			if( is_array($post['idDistribuidoraSucursal'])){
				$idDistribuidoraSucursal=implode(",",$post['idDistribuidoraSucursal']);
			}else{
				$idDistribuidoraSucursal=$post['idDistribuidoraSucursal'];
			}
		}
		$params['idDistribuidoraSucursal'] =$idDistribuidoraSucursal;
		$array['iniciativas'] = $this->model->obtener_iniciativas($params);
		
		 if( count($array['iniciativas']) < 1 ) {
			$result['result']=1;
			$result['data']=getMensajeGestion('noRegistros');
		}
		else{
			$segmentacion = getSegmentacion($post);
			$array['segmentacion'] = $segmentacion;
			$result['result']=1;
			$result['data']=$this->load->view("modulos/iniciativas/lista_iniciativas", $array, true);
		}
		
		echo json_encode($result);
	}
	
	public function editar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);

		$params = array(
			  'idIniciativaDet' => $post['idIniciativaDet']
		);
		$array['iniciativas'] = $this->model->obtener_iniciativas_det($params);
		$array['estados'] = $this->model->obtener_estados();
		
		$result['result']=1;
		$result['data']=$this->load->view("modulos/iniciativas/editar_iniciativas", $array, true);
		
		echo json_encode($result);
	}
	
	public function actualizar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);
		// [sel-presencia] => 1 [] => 0 [idIniciativaDet] => 13 [idMotivo]
		$editar = array(
			   'presencia' => $post['sel-presencia']
			,  'cantidad' => $post['txt-cantidad']
			,  'idEstadoIniciativa' => $post['idMotivo']
			,  'editado' => 1
		);

		$this->db->where('idVisitaIniciativaTradDet', $post['idIniciativaDet'] );
		$this->db->update('trade.data_visitaIniciativaTradDet', $editar);
		
		$result['result']=1;
		$result['data']='<div style="margin-top:15px;background:#6cde6c;color:black;padding:15px;border-radius:20px;font-weight:bold;">SE ACTUALIZO DATA CON EXITO.</div>';
		
		echo json_encode($result);
	}
	
	public function actualizar_estado_analista(){
		$post = json_decode($this->input->post('data'), true);
		$idIniciativaDet = $post['idIniciativaDet'];
		
		$estado_analista = $this->model->obtener_estado_validacion($idIniciativaDet);

		$estado = ($estado_analista[0]['validacion_analista']==1)?0:1;
		$editar = array(
			   'validacion_analista' => $estado
		);

		$this->db->where('idVisitaIniciativaTradDet', $idIniciativaDet );
		$this->db->update('trade.data_visitaIniciativaTradDet', $editar);
		
		$result['result']=1;
		$result['data']=$estado;
		
		echo json_encode($result);
	}
	
	public function inhabilitar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);
		$total = count($post);

		for($i=0; $i<$total;$i++){
			if(!empty($post[$i]['iniciativas'])){
				$editar = array(
					'validacion_analista' => 0
				);

				$this->db->where('idVisitaIniciativaTradDet',  $post[$i]['iniciativas'][0] );
				$this->db->update('trade.data_visitaIniciativaTradDet', $editar);
			}
		}

		$result['result']=1;
		$result['data']='SE ACTUALIZO CON EXITO.';
		
		echo json_encode($result); 
	}
	
	public function validar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);
		$total = count($post);

		for($i=0; $i<$total;$i++){
			if(!empty($post[$i]['iniciativas'])){
				$editar = array(
					'validacion_ejecutivo' => 1
				);

				$this->db->where('idVisitaIniciativaTradDet',  $post[$i]['iniciativas'][0] );
				$this->db->update('trade.data_visitaIniciativaTradDet', $editar);
			}
		}

		$result['result']=1;
		$result['data']='SE ACTUALIZO CON EXITO.';
		
		echo json_encode($result); 
	}
	
	public function iniciativas_pdf(){
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		//
		$post=json_decode($this->input->post('data'),true);
		$fecIni = $post['datos']['fecIni'];
		$fecFin = $post['datos']['fecFin'];
		
		$filtro = "";
		$total = count($post['datos']);
		$id = array();
		$j=0;
		for($i=0; $i<$total;$i++){
			if(!empty($post['datos'][$i]['iniciativas'][0])){
				$id[$j]=$post['datos'][$i]['iniciativas'][0];
				$j++;
			}
		}
		$total_id =count($id) ;
		
		if($total_id>1){
			for($z=0; $z<$total_id;$z++){
				if($z == 0){
					$filtro.='AND id.idVisitaIniciativaTradDet IN ( '.$id[$z].',';
				}
				else if($z!=0 && $z!=($total_id-1) ){
					$filtro.=$id[$z].',';
				}
				else if($z==($total_id-1)){
					$filtro.=$id[$z].')';
				} 
			}
		}else if($total_id==1){
			$filtro.="AND id.idVisitaIniciativaTradDet IN ( ".$id[0].")";
		}

		$visitasTotal = $this->model->visitas_pdf($filtro,$fecIni,$fecFin);
		
		//
		$www=base_url().'public/';
		$style="
		<style>
				.head {
					background-color:#1370C5;
					padding: 5px;
					font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
					font-size: 10px;
					width: 100%;
				}
				table{width: 100%;}
				.title { font-weight: bold; color: #FFFFFF !important; text-align: right; }
				img.foto{ border: 0.3em solid #0E7BEF; margin: 0.5em;}
				.item { 
					text-align: center;
					font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
					font-size: 12px;
				}
		</style>
		";
		$header = '<table class="head" >';
			$header .= '<tr>';
				$header .= '<td ><img src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/logos/pg.png" /></td>';
				$header .= '<td class="title" >INICIATIVAS</td>';
			$header .= '</tr>';
		$header .= '</table>';
		//
		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$newPage = 0;
		//
		
		if( count($visitasTotal)>400 ){
			//
			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Tiene que filtrar mejor la información.</b>';
			//
			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($visitasTotal)>0 && count($visitasTotal)<400 ){
			$html = ''; $num=1; $cant=0;
			foreach($visitasTotal as $row){ 
					$presencia = ($row['presencia']=='1')? 'SI' : 'NO';
					$motivo = !empty($row['estadoIniciativa'])? $row['estadoIniciativa'] : '-';
					$cantidad = !empty($row['cantidad'])? $row['cantidad'] : '-'; 
					//
					$html .= '<br /><br/>';
					$html .= '<table>';
						$html .= '<thead>';
							$html .= '<tr><th colspan="2" style="background-color:#CCC;">INFORMACIÓN VISITA</th></tr>';
						$html .= '</thead>';
						$html .= '<tbody>';
							$html .= '<tr>';
								$html .= '<td>FECHA</td>';
								$html .= '<td style="font-weight:bold;">'.$row['fecha'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>HORA</td>';
								$html .= '<td style="font-weight:bold;">'.$row['hora'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>CANAL</td>';
								$html .= '<td style="font-weight:bold;">'.$row['grupoCanal'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>SUBCANAL</td>';
								$html .= '<td style="font-weight:bold;">'.$row['canal'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>POS</td>';
								$html .= '<td style="font-weight:bold;">'.$row['razonSocial'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>INICIATIVA</td>';
								$html .= '<td style="font-weight:bold;">'.$row['iniciativa'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>ELEMENTO</td>';
								$html .= '<td style="font-weight:bold;">'.$row['elementoIniciativa'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>PRESENCIA</td>';
								$html .= '<td style="font-weight:bold;">'.$presencia.'</td>';
							$html .= '</tr>';
							if($row['presencia']=='0'){
								$html .= '<tr>';
									$html .= '<td>MOTIVO</td>';
									$html .= '<td style="font-weight:bold;">'.$motivo.'</td>';
								$html .= '</tr>';
							}
							$html .= '<tr>';
							    if(!empty($row['foto'])){
									$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="http://movil.visualimpact.com.pe/fotos/impactTrade_android/iniciativa/'.$row['foto'].'" width="280" height="200" /></td>';
								} else {
									$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/no_image_600x600.png" width="280" height="200" /></td>';
								}
								$html .= '</tr>';
						$html .= '</tbody>';
					$html .= '</table>';
					//
					if($num%2==0) {
						$mpdf->SetHTMLHeader($header);
						$mpdf->setFooter('{PAGENO}');
						$mpdf->AddPage();
						$mpdf->WriteHTML($style);
						$mpdf->WriteHTML($html);
						//
						$html = '';
					} else {
						//if(count($visitasTotal)==$cant){
							$mpdf->SetHTMLHeader($header);
							$mpdf->setFooter('{PAGENO}');
							$mpdf->AddPage();
							$mpdf->WriteHTML($style);
							$mpdf->WriteHTML($html);
							//
							$html = '';
						//}
					}
					//
					$num++;
			    
			}
		} else {
			//
			$html='<br/><br/><br/><b>No se encontraron resultados para la consulta realizada.</b>';
			//
			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		}
		//
		$mpdf->Output('ppp.pdf','D');
	}


	public function obtener_usuarios(){
		$post = json_decode($this->input->post('data'), true);
		$idTipoUsuario= $post['idTipoUsuario'];

		$params = array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$params['idTipoUsuario']=$idTipoUsuario;

		$result=array();
		$rs_usuarios = $this->model->obtener_usuarios($params);
		$result['data']['usuarios'] = $rs_usuarios;
		$result['result']=1;
		echo json_encode($result);
	}


}
