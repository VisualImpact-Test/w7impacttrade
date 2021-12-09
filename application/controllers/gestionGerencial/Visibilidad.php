<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Visibilidad extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_visibilidad','model');
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '109';
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/visibilidad'
		);

		$config['data']['icon'] = 'fas fa-share-alt';
		$config['data']['title'] = 'Visibilidad';
		$config['data']['message'] = 'Lista de Visibilidad';
		$config['view'] = 'modulos/gestionGerencial/visibilidad/index';

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$elementos = $this->model->obtener_elementos($params);
		$config['data']['elementos'] = $elementos;

		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['subcanal'] = $data->{'subcanal_filtro'};
		$input['subcanal_filtro'] = empty($data->{'subcanal_filtro'}) ? '' : $data->{'subcanal_filtro'};


		$input['tipoUsuario_filtro'] = empty($data->{'tipoUsuario_filtro'}) ? '' : $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = empty($data->{'usuario_filtro'}) ? '' : $data->{'usuario_filtro'};

		$input['distribuidoraSucursal_filtro'] = empty($data->{'distribuidoraSucursal_filtro'}) ? '' : $data->{'distribuidoraSucursal_filtro'};
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};



		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;

			$rs_det=$this->model->obtener_detalle_visibilidad($input);

			if(empty($rs_det)){
				$html = getMensajeGestion('noRegistros');
				$result['result'] = 0;
				$result['data']['views']['idContentVisibilidad']['datatable'] = 'tb-visibilidad';
				$result['data']['views']['idContentVisibilidad']['html'] = $html;
				goto respuesta;
			}
			foreach($rs_det as $det){
				$array['categorias'][$det['idCategoria']]=$det['categoria'];
				$array['elementos'][$det['idCategoria']][$det['idElementoVis']]=$det['elemento'];
			}

			$rs_lista=$this->model->obtener_lista_elementos_visibilidad($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idElementoVis']]='1';
			}

			$array['detalle'] = $rs_det;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/visibilidad/detalle_visibilidad",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentVisibilidad']['datatable'] = 'tb-visibilidad';
		$result['data']['views']['idContentVisibilidad']['html'] = $html;
		$result['data']['configTable'] = [];

		respuesta:
		echo json_encode($result);
	}

	public function mostrarFotos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$idVisita = $data->{'idVisita'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'cliente'};
		$array['perfil'] = $data->{'perfil'};
		$array['fotos'] = $this->model->obtener_fotos($idVisita);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/gestionGerencial/visibilidad/verFotos", $array, true);

		echo json_encode($result);
    }


	public function visibilidad_pdf(){ 

		//
		$post=json_decode($this->input->post('data'));
		$elementos = $post->{'elementos'};

		$params = array();
		$fechas = explode(' - ', $post->{'txt-fechas'});
		$params['fecIni'] = $fechas[0];	
		$params['fecFin'] = $fechas[1];

		$params['proyecto_filtro'] = $post->{'proyecto_filtro'};
		$params['grupoCanal_filtro'] = $post->{'grupoCanal_filtro'};
		$params['canal_filtro'] = $post->{'canal_filtro'};
		$params['subcanal'] = $post->{'subcanal_filtro'};

		$params['subcanal_filtro'] = empty($data->{'subcanal_filtro'}) ? '' : $data->{'subcanal_filtro'};


		$params['tipoUsuario_filtro'] = empty($data->{'tipoUsuario_filtro'}) ? '' : $data->{'tipoUsuario_filtro'};
		$params['usuario_filtro'] = empty($data->{'usuario_filtro'}) ? '' : $data->{'usuario_filtro'};

		$params['distribuidoraSucursal_filtro'] = empty($data->{'distribuidoraSucursal_filtro'}) ? '' : $data->{'distribuidoraSucursal_filtro'};
		$params['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$params['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$params['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$params['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$params['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		
		/*====Filtrado=====*/

		if(is_array($elementos)){
			$params['elementos_det'] = implode(",",$elementos);
		}else{
			$params['elementos_det']=$elementos;
		}
		
		//
		$filtros=''; $filtros_1=''; $filtros_3='';
		//
		$idUsuario=$this->session->userdata('idUsuario');
		$idUsuarioTipo=$this->session->userdata('idUsuarioTipo');

		$filtro_gtm_activos = ''; $i = 0;
		
		$query=$this->model->obtener_detallado_pdf($params); 
		//
		$visitasTotal=0;
		if(!empty($query)){
			$visitasTotal=count($query);
		}
		//foreach($query as $row){ if (in_array($row['idUsuario'], $arrayGTM)) { $visitasTotal=$visitasTotal+1; } }
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
				$header .= '<td ></td>';
				//$header .= '<td ><img src="'.$www.'/images/pg.png" /></td>';
				$header .= '<td class="title" >VISIBILIDAD</td>';
			$header .= '</tr>';
		$header .= '</table>';
		//
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		//
		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$newPage = 0;
		//
		if( $visitasTotal>400 ){
			//
			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Excedio el maximo permitido.</b>';
			//
			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( $visitasTotal>0 && $visitasTotal<400 ){
			$html = ''; $num=1; $cant=0;
			foreach($query as $row){ 
				//if (in_array($row->idUsuario, $arrayGTM)) { 
					$cant++;
					$presencia =!empty($row['presencia'])? (  ($row['presencia']=='1')? 'SI' : 'NO' ) : '-';
					$estado = !empty($row['estado'])? $row['estado'] : '-';
					$cantidad = !empty($row['cantidad'])? $row['cantidad'] : '-';
					$modulado =!empty($row['condicion_elemento'])? (  ($row['condicion_elemento']=='1')? 'SI' : 'NO' ) : '-';
					//
					$html .= '<br />';
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
								$html .= '<td>GRUPO CANAL</td>';
								$html .= '<td style="font-weight:bold;">'.$row['grupoCanal'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>CANAL</td>';
								$html .= '<td style="font-weight:bold;">'.$row['canal'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>POS</td>';
								$html .= '<td style="font-weight:bold;">'.$row['razonSocial'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>COD </td>';
								$html .= '<td style="font-weight:bold;">'.$row['codCliente'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>ELEMENTO</td>';
								$html .= '<td style="font-weight:bold;">'.$row['elemento'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>PRESENCIA</td>';
								$html .= '<td style="font-weight:bold;">'.$presencia.'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>MODULADO</td>';
								$html .= '<td style="font-weight:bold;">'.$modulado.'</td>';
							$html .= '</tr>';
							if($presencia!='SI'){
								$html .= '<tr>';
									$html .= '<td>ESTADO</td>';
									$html .= '<td style="font-weight:bold;">'.$estado.'</td>';
								$html .= '</tr>';
							}
							$html .= '<tr>';
							    if(!empty($row['fotoUrl'])){
									$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="'.('http://movil.visualimpact.com.pe/fotos/impactTrade_Android/visibilidad/'.$row['fotoUrl']).'" width="280" height="200" /></td>';
								} else {
									$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="'.$www.'/images/sin-imagen.jpg" width="280" height="200" /></td>';
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
						if($visitasTotal==$cant){
							$mpdf->SetHTMLHeader($header);
							$mpdf->setFooter('{PAGENO}');
							$mpdf->AddPage();
							$mpdf->WriteHTML($style);
							$mpdf->WriteHTML($html);
							//
							$html = '';
						}
					}
					//
					$num++;
			    //}
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
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		$mpdf->Output("Visibilidad.pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}

}
?>