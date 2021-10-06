<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Iniciativas extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_iniciativas','model');
	}

	var $htmlNoResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active'] = '71';
		$config['css']['style'] = array(
			'assets/libs/datatables/dataTables.bootstrap4.min', 'assets/libs/datatables/buttons.bootstrap4.min'
			, 'assets/custom/css/gestionGerencial/iniciativas'
			, 'assets/libs/bootstrap-select/bootstrap-select.min'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults'
			, 'assets/libs/popper/popper.min'
			, 'assets/libs/bootstrap-select/bootstrap-select.min'
			, 'assets/custom/js/gestionGerencial/iniciativas'
		);

		$config['data']['icon'] = 'fas fa-rocket';
		$config['data']['title'] = 'Reporte de Iniciativas';
		$config['data']['message'] = 'Lista de Iniciativas - Elementos';

		$distribuidoras = $this->model->obtener_distribuidoras();
		$config['data']['distribuidoras']=$distribuidoras;

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$clientes = $this->model->obtener_clientes($params);
		$config['data']['clientes'] = $clientes;

		$elementos = $this->model->obtener_elementos($params);
		$config['data']['elementos'] = $elementos;

		$config['view'] = 'modulos/gestionGerencial/iniciativas/index';

		$this->view($config);
	}

	public function filtrar(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaIniciativaTrad' ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});
		$tipoReporte = $data->{'tipoReporte'};

		$html='';
		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		/*====Filtrado=====*/
		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['idCliente'] = $data->{'idCliente'};

		if(isset( $data->{'idDistribuidora'})){
			$distribuidoras = $data->{'idDistribuidora'};
			if(is_array($distribuidoras)){
				$input['idDistribuidora'] = implode(",",$distribuidoras);
			}else{
				$input['idDistribuidora'] = $distribuidoras;
			}
		}

		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}
		

		switch ($tipoReporte) {
			case 1:
				$rs_detallado = $this->model->obtener_lista_detallado_iniciativas($input);

				if (!empty($rs_detallado)) {
					$array = array();
					$array['listaVisitaIniciativas'] = $rs_detallado;

					$html .= $this->load->view("modulos/gestionGerencial/iniciativas/iniciativasDetallado", $array, true);

					$result['result'] = 1;
					$result['data']['views']['idDetalleDetallado']['html'] = $html;
					$result['data']['views']['idDetalleDetallado']['datatable'] = 'tb-iniciativasDetalle';
				} else {
					$html .= $this->htmlNoResultado;
					$result['data']['html'] = $html;
				}
				break;
			
			case 2:
				$tipoConsolidado = $data->{'tipoConsolidado'};
				if ( $tipoConsolidado==1) {
					$rs_consolidado = $this->model->obtener_lista_consolidado_iniciativas($input);
					if (!empty($rs_consolidado)) {
						$array=array();
						$array['listaVisitasConsolidado'] = $rs_consolidado;

						$html .= $this->load->view("modulos/gestionGerencial/iniciativas/iniciativasConsolidadoCobertura", $array, true);

						$result['result'] = 1;
						$result['data']['views']['idDetalleConsolidadoCobertura']['html'] = $html;
						$result['data']['views']['idDetalleConsolidadoCobertura']['datatable'] = 'tb-iniciativasConsolidadoCobertura';
					} else {
						$html .= $this->htmlNoResultado;
						$result['data']['views']['idDetalleConsolidadoCobertura']['html'] = $html;
					}
				} else {
					$rs_consolidado = $this->model->obtener_lista_consolidado_implementacion($input);
					if ( !empty($rs_consolidado)) {
						$array=array();
						foreach ($rs_consolidado as $klc => $row) {
							$array['listaVisitasConsolidado'][$row['idUsuarioSupervisor']]['idUsuarioSupervisor'] = $row['idUsuarioSupervisor'];
							$array['listaVisitasConsolidado'][$row['idUsuarioSupervisor']]['usuarioSupervisor'] = $row['usuarioSupervisor'];
							$array['listaVisitasConsolidado'][$row['idUsuarioSupervisor']]['listaUsuarios'][$row['idUsuario']]['idUsuario'] = $row['idUsuario'];
							$array['listaVisitasConsolidado'][$row['idUsuarioSupervisor']]['listaUsuarios'][$row['idUsuario']]['nombreUsuario'] = $row['nombreUsuario'];
							$array['listaVisitasConsolidado'][$row['idUsuarioSupervisor']]['listaUsuarios'][$row['idUsuario']]['listaElementos'][$row['idElementoIniciativa']]['idElementoIniciativa'] = $row['idElementoIniciativa'];
							$array['listaVisitasConsolidado'][$row['idUsuarioSupervisor']]['listaUsuarios'][$row['idUsuario']]['listaElementos'][$row['idElementoIniciativa']]['sumaElementosIniciativa'] = $row['suma_cantidad_elemento_iniciativa'];

							$array['listaElementosIniciativa'][$row['idElementoIniciativa']]['idElementoIniciativa'] = $row['idElementoIniciativa'];
							$array['listaElementosIniciativa'][$row['idElementoIniciativa']]['elementoIniciativa'] = $row['elementoIniciativa'];
						}
						$html .= $this->load->view("modulos/gestionGerencial/iniciativas/iniciativasConsolidadoImplementacion", $array, true);

						$result['result'] = 1;
						$result['data']['views']['idDetalleConsolidadoImplementacion']['html'] = $html;
						$result['data']['views']['idDetalleConsolidadoImplementacion']['datatable'] = 'tb-iniciativasConsolidadoImplementacion';
					} else {
						$html .= $this->htmlNoResultado;
						$result['data']['views']['idDetalleConsolidadoImplementacion']['html'] = $html;
					}
				}
				
				break;
			default:
				$html .= $this->htmlNoResultado;
				$result['data']['html'] = $html;
				break;
		}

		echo json_encode($result);
	}

	public function visitasDetallado(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaIniciativaTrad' ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataForm = $data->{'dataForm'};
		$fechas = explode(' - ', $dataForm->{'txt-fechas'});
		$tipoReporte = $dataForm->{'tipoReporte'};

		$html='';
		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['idSupervisor'] = ( $data->{'supervisor'}==0 ? NULL: $data->{'supervisor'} );
		$input['idUsuario'] = $data->{'usuario'};
		$input['tipoVisita'] = $data->{'tipoVisita'};

		$rs_visitas_detallado = $this->model->obtener_lista_visita_detallado($input);
		if ( !empty($rs_visitas_detallado)) {
			$array=array();
			$array['flagImplementacion'] = 0;
			$array['listaVisitasElemento'] = $rs_visitas_detallado;

			$html .= $this->load->view("modulos/gestionGerencial/iniciativas/iniciativasConsolidadoVisitas", $array, true);
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['result'] = 1;
		$result['msg']['title'] = 'VISITAS DETALLADO';
		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function elementoDetallado(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaIniciativaTrad' ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataForm = $data->{'dataForm'};
		$fechas = explode(' - ', $dataForm->{'txt-fechas'});
		$tipoReporte = $dataForm->{'tipoReporte'};

		$html='';
		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['idSupervisor'] = ( $data->{'supervisor'}==0 ? NULL: $data->{'supervisor'} );
		$input['idUsuario'] = $data->{'usuario'};
		$input['idElementoIniciativa'] = $data->{'elemento'};

		$rs_visitas_elemento = $this->model->obtener_lista_visita_elementos($input);
		if ( !empty($rs_visitas_elemento)) {
			$array=array();
			$array['flagImplementacion'] = 1;
			$array['listaVisitasElemento'] = $rs_visitas_elemento;

			$html .= $this->load->view("modulos/gestionGerencial/iniciativas/iniciativasConsolidadoVisitas", $array, true);
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['result'] = 1;
		$result['msg']['title'] = 'VISITAS DEL ELEMENTO';
		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function iniciativas_pdf(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaIniciativaTrad' ];
		$this->aSessTrack[] = [ 'idAccion' => 9 ];

		$post=json_decode($this->input->post('data'));
		$elementos = $post->{'elementos'};



		$params = array();
		$fechas = explode(' - ', $post->{'txt-fechas'});
		$params['fecIni'] = $fechas[0];
		$params['fecFin'] = $fechas[1];

		/*====Filtrado=====*/
		$params['proyecto_filtro'] = $post->{'proyecto_filtro'};
		$params['grupoCanal_filtro'] = $post->{'grupoCanal_filtro'};
		$params['canal_filtro'] = $post->{'canal_filtro'};

		if(is_array($elementos)){
			$params['elementos_det'] = implode(",",$elementos);
		}else{
			$params['elementos_det']=$elementos;
		}

		$filtros=''; $filtros_1=''; $filtros_3='';

		$idUsuario=$this->session->userdata('idUsuario');
		$idUsuarioTipo=$this->session->userdata('idUsuarioTipo');

		$filtro_gtm_activos = ''; $i = 0;

		$query=$this->model->obtener_detallado_pdf($params); 
		$visitasTotal=0;
		if(!empty($query)){
			$visitasTotal=count($query);
		}

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
				$header .= '<td class="title" >INICIATIVAS</td>';
			$header .= '</tr>';
		$header .= '</table>';

		ini_set('memory_limit','1024M');
		set_time_limit(0);

		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$newPage = 0;

		if( $visitasTotal>400 ){
			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Excedio el maximo permitido.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( $visitasTotal>0 && $visitasTotal<400 ){
			$html = ''; $num=1; $cant=0;
			foreach($query as $row){ 
				$cant++;
				$presencia =!empty($row['presencia'])? (  ($row['presencia']=='1')? 'SI' : 'NO' ) : '-';
				$motivo = !empty($row['motivo'])? $row['motivo'] : '-';
				$cantidad = !empty($row['cantidad'])? $row['cantidad'] : '-';

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
							$html .= '<td>INICIATIVA</td>';
							$html .= '<td style="font-weight:bold;">'.$row['iniciativa'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>ELEMENTO</td>';
							$html .= '<td style="font-weight:bold;">'.$row['elemento'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>PRESENCIA</td>';
							$html .= '<td style="font-weight:bold;">'.$presencia.'</td>';
						$html .= '</tr>';
						if($presencia!='SI'){
							$html .= '<tr>';
								$html .= '<td>MOTIVO</td>';
								$html .= '<td style="font-weight:bold;">'.$motivo.'</td>';
							$html .= '</tr>';
						}
						$html .= '<tr>';
							if(!empty($row['fotoUrl'])){
								$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="'.('http://movil.visualimpact.com.pe/fotos/impactTrade_Android/iniciativa/'.$row['fotoUrl']).'" width="280" height="200" /></td>';
							} else {
								$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="'.$www.'/images/sin-imagen.jpg" width="280" height="200" /></td>';
							}
							$html .= '</tr>';
					$html .= '</tbody>';
				$html .= '</table>';

				if($num%2==0) {
					$mpdf->SetHTMLHeader($header);
					$mpdf->setFooter('{PAGENO}');
					$mpdf->AddPage();
					$mpdf->WriteHTML($style);
					$mpdf->WriteHTML($html);

					$html = '';
				} else {
					if($visitasTotal==$cant){
						$mpdf->SetHTMLHeader($header);
						$mpdf->setFooter('{PAGENO}');
						$mpdf->AddPage();
						$mpdf->WriteHTML($style);
						$mpdf->WriteHTML($html);

						$html = '';
					}
				}

				$num++;
			}
		} else {
			$html='<br/><br/><br/><b>No se encontraron resultados para la consulta realizada.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		}

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		$mpdf->Output("Iniciativas.pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}
}


?>