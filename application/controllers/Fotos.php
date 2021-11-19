<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fotos extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Fotos', 'm_foto');
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config['nav']['menu_active'] = '47';
		$config['css']['style'] = [
			'assets/custom/css/pagination/pagination',
			'assets/custom/css/fotos'
		];
		$config['js']['script'] = [
			'assets/libs/pagination/pagination.min',
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/custom/js/fotos'
		];

		$config['data']['icon'] = 'fa fa-camera';
		$config['data']['title'] = 'Fotos';
		$config['data']['message'] = 'Aquí encontrará fotos.';
		$config['view'] = 'modulos/fotos/index';
		$config['data']['tipoFotos'] = $this->m_foto->getTipoFotos()->result_array();
		$config['data']['tipoCliente'] = $this->m_foto->getTipoCliente()->result_array();
		$this->view($config);
	}

	protected function getFotos($post,$visitas = null)
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaFotos' ];
		$fotosClientes = $this->m_foto->getFotosNew($post,$visitas)->result_array();

		$fotosClientesRefactorizado = [];
		
		foreach ($fotosClientes as $key => $row) {
			$fotosClientesRefactorizado[$row['idCliente']]['idCliente'] = $row['idCliente'];
			$fotosClientesRefactorizado[$row['idCliente']]['codCliente'] = $row['codCliente'];
			$fotosClientesRefactorizado[$row['idCliente']]['canal'] = $row['canal'];
			$fotosClientesRefactorizado[$row['idCliente']]['departamento'] = $row['departamento'];
			$fotosClientesRefactorizado[$row['idCliente']]['provincia'] = $row['provincia'];
			$fotosClientesRefactorizado[$row['idCliente']]['distrito'] = $row['distrito'];
			$fotosClientesRefactorizado[$row['idCliente']]['direccion'] = $row['direccion'];
			$fotosClientesRefactorizado[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$fotosClientesRefactorizado[$row['idCliente']]['cliente_tipo'] = $row['cliente_tipo'];
			
			$fotosClientesRefactorizado[$row['idCliente']]['cuenta'] = $row['cuenta'];
			$fotosClientesRefactorizado[$row['idCliente']]['proyecto'] = $row['proyecto'];

			if (empty($fotosClientesRefactorizado[$row['idCliente']]['visitas'])) $fotosClientesRefactorizado[$row['idCliente']]['visitas'] = [];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['idVisita'] = $row['idVisita'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['usuario'] = $row['usuario'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['tipoUsuario'] = $row['tipoUsuario'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fecha'] = $row['fecha'];

			if (empty($fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'])) $fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'] = [];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['idVisitaFoto'] = $row['idVisitaFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['horaFoto'] = $row['horaFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['tipoFoto'] = $row['tipoFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['carpetaFoto'] = $row['carpetaFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['imgRef'] = $row['imgRef'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['modulo'] = $row['modulo'];
			
		}
		$fotosClientes = $fotosClientesRefactorizado;

		return $fotosClientes;
	}

	public function getFotosClientes()
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$result = $this->result;
		$result['msg']['title'] = 'Fotos';
		$post = json_decode($this->input->post('data'), true);

		$fotosClientes = $this->getFotos($post);

		$result['result'] = 1;
		if (count($fotosClientes) < 1) {
			$result['data']['html'] = '';
				$result['data']['html'] .= '<div class="col-md-12">';
					$result['data']['html'] .= '<div class="card mb-3 ">';
						$result['data']['html'] .= '<div class="card-body">';
							$result['data']['html'] .= getMensajeGestion('noRegistros');
						$result['data']['html'] .= '</div>';
					$result['data']['html'] .= '</div>';
				$result['data']['html'] .= '</div>';

		} else {
			$dataParaVista = [];
			$result['data']['fotosClientes'] = $fotosClientes;
			$result['data']['html'] = $this->load->view("modulos/Fotos/vistaFotos", $dataParaVista, true);

			$result['data']['tablaExcel'] = $this->load->view("modulos/Fotos/reporteParaExcel", [ 'fotosClientes' => $fotosClientes ], true);
		}
		$result['data']['urlfotos'] = site_url().'ControlFoto/obtener_carpeta_foto/';
		
		echo json_encode($result);
	}

	public function getVistaMasFotos()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = 'FECHA: ' . $post['fecha'] . ' | ' . $post['tipoUsuario'] . ': ' . $post['usuario'];

		$result['result'] = 1;
		$dataParaVista['fotosClientes'] = $post['fotosClientes'];
		$result['data']['html'] = $this->load->view("modulos/Fotos/verMasFotos", $dataParaVista, true);
		$result['data']['width'] = '60%';

		echo json_encode($result);
	}

	public function getFormExportarPdf()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;
		$result['msg']['title'] = 'Exportar Fotos';

		$dataParaVista = [];
		$result['data']['html'] = $this->load->view("modulos/Fotos/formExportarPdf", $dataParaVista, true);
		$result['data']['width'] = '25%';

		echo json_encode($result);
	}

	public function exportarPdf2()
	{
		$this->aSessTrack[] = [ 'idAccion' => 9 ];
		$post = json_decode($this->input->post('data'), true);
		
		$config = [
			'title' => "Reporte Fotográfico",
			'subject' => "Reporte Fotográfico",
			'logo' => "pg-logo.jpg",
			'logoWidth' => 20,
			'headerDescription' => "Fecha Impresión: ".getFechaActual()."\nElaborado por: Visual Impact S.A.C.",
			'margenIzquierdo' => 15,
			'margenSuperior' => 30,
			'margenDerecho' => 15,
			'margenHeader' => 5,
			'margenFooter' => 10,
		];

		$pdf = $this->setDefaultTCPDF($config);

		$fotosClientes = $this->getFotos($post);

		if (count($fotosClientes) < 1) {
			$dataParaVista = [];
			$html = $this->load->view("modulos/Fotos/formatoFotograficoPdfVacio", $dataParaVista, true);

			$pdf->AddPage();
			$pdf->writeHTML($html, true, false, false, false, '');
			$pdf->lastPage();
		} else {
			$contadorLimiteDeClientes = 0;
			foreach ($fotosClientes as $key => $fotoCliente) {

				$contadorLimiteDeClientes++;
				if ($contadorLimiteDeClientes == $post["top"]) break;

				$dataParaVista['fotosCliente'] = $fotoCliente;
				$html = $this->load->view("modulos/Fotos/formatoFotograficoPdf", $dataParaVista, true);

				$pdf->AddPage();
				$pdf->writeHTML($html, true, false, false, false, '');
				$pdf->lastPage();
			}
		}

		$pdf->Output('Reporte Fotográfico.pdf', 'D');
	}

	public function exportarPdf(){
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$post = json_decode($this->input->post('data'), true);
		$visitas = $this->m_foto->getVisitas($post)->result_array();
		$filtro_visitas = '';
		if(count($visitas)>0){
			$filtro_visitas ='and v.idVisita IN (';
				$i=0;
				$total = count($visitas);
				foreach($visitas as $row ){
					if($i<($total-1)){
						$filtro_visitas.= $row['idVisita'].',';
					}else if($i==($total-1)){
						$filtro_visitas.= $row['idVisita'];
					}
					$i++;
				}
			$filtro_visitas.=')';
		}
		//$fotosClientes = $this->getFotos($post,$filtro_visitas);
		$fotosClientes = $this->m_foto->getFotos($post,$filtro_visitas)->result_array();
		
		//
		$fotoCiente=[];
		$arrayvisita=[];
		$arrayFoto=[];
		foreach ($fotosClientes as $key => $row) {
			$fotoCiente[$row['idCliente']]['idCliente'] = $row['idCliente'];
			$fotoCiente[$row['idCliente']]['codCliente'] = $row['codCliente'];
			$fotoCiente[$row['idCliente']]['canal'] = $row['canal'];
			$fotoCiente[$row['idCliente']]['departamento'] = $row['departamento'];
			$fotoCiente[$row['idCliente']]['provincia'] = $row['provincia'];
			$fotoCiente[$row['idCliente']]['distrito'] = $row['distrito'];
			$fotoCiente[$row['idCliente']]['direccion'] = $row['direccion'];
			$fotoCiente[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$fotoCiente[$row['idCliente']]['cliente_tipo'] = $row['cliente_tipo'];

			
			$arrayvisita[$row['idCliente']][$row['idVisita']]['idVisita'] = $row['idVisita'];
			$arrayvisita[$row['idCliente']][$row['idVisita']]['usuario'] = $row['usuario'];
			$arrayvisita[$row['idCliente']][$row['idVisita']]['tipoUsuario'] = $row['tipoUsuario'];
			$arrayvisita[$row['idCliente']][$row['idVisita']]['fecha'] = $row['fecha'];

			$arrayFoto[$row['idCliente']][$row['idVisita']][$row['idVisitaFoto']]['idVisitaFoto'] = $row['idVisitaFoto'];
			$arrayFoto[$row['idCliente']][$row['idVisita']][$row['idVisitaFoto']]['horaFoto'] = $row['horaFoto'];
			$arrayFoto[$row['idCliente']][$row['idVisita']][$row['idVisitaFoto']]['tipoFoto'] = $row['tipoFoto'];
			$arrayFoto[$row['idCliente']][$row['idVisita']][$row['idVisitaFoto']]['carpetaFoto'] = $row['carpetaFoto'];
			$arrayFoto[$row['idCliente']][$row['idVisita']][$row['idVisitaFoto']]['imgRef'] = $row['imgRef'];
			$arrayFoto[$row['idCliente']][$row['idVisita']][$row['idVisitaFoto']]['modulo'] = $row['modulo'];
		}
		
		//
		
		$this->aSessTrack[] = [ 'idAccion' => 9 ];
		
		// Cargar el autoload del composer cuando se necesiten una de las librerias alojadas en vendor.
		require APPPATH . '/vendor/autoload.php';
		
		
		$idCuenta = $this->sessIdCuenta;
		$logo = $this->m_foto->getLogo()->row_array();

		$styles = $this->load->view("pdf/modulos/fotos/formatoFotograficoStyles", [], true);
		$config = [
			"styles" => $styles,
			"logo" => base_url() . "public/assets/images/logos/".$logo['urlLogo'],
			"nombreReporte" => "Reporte Fotográfico",
			"tipo" => "descargaConFileDownload",
		];
		$mpdf = $this->getDefaultMpdf($config);
		if (count($fotosClientes) < 1) {
			$html = $this->load->view("pdf/modulos/fotos/formatoFotograficoVacio", [], true);
			$mpdf->WriteHTML($html);
		} else {
			$html='';
			$mpdf->useSubstitutions = false;
			$mpdf->simpleTables = true;
			foreach ($fotoCiente as $key => $value) {
				$html= '<div></div>';
					$html.= '<table class="informacionCliente">';
						$html.= '<tr>';
							$html.= '<td>';
								$html.= '<h2 class="razonSocial">'.$value['razonSocial'].'</h2>';
							$html.= '</td>';
						$html.= '</tr>';
						$html.= '<tr>';
							$html.= '<td colspan="2" class="nombresInfo">COD VI:</td>';
							$html.= '<td colspan="2">'.$value["idCliente"].'</td>';
							$html.= '<td colspan="2" class="nombresInfo">COD PDV:</td>';
							$html.= '<td colspan="2">'.$value["codCliente"].'</td>';
						$html.='</tr>';
						$html.='<tr>';
							$html.= '<td colspan="2" class="nombresInfo">CANAL:</td>';
							$html.= '<td colspan="2">'.$value["canal"].'</td>';
							$html.= '<td colspan="2" class="nombresInfo">UBICACIÓN:</td>';
							$html.= '<td colspan="4">'.$value["departamento"]. ' - ' . $value["provincia"] . ' - ' . $value["distrito"].'</td>';
						$html.= '</tr>';
							$html.= '<tr>';
							$html.= '<td colspan="2" class="nombresInfo">DIRECCIÓN:</td>';
							$html.= '<td colspan="4">'.$value["direccion"].'</td>';
						$html.= '</tr>';
						$html.= '<tr>';
							$html.= '<td></td>';
						$html.= '</tr>'; 
				$html.= '</table>';

				foreach ($arrayvisita[$key] as $keyVisita => $visita) {
					$cantidadFotos = count($arrayFoto[$key][$keyVisita]);
					$html.='<h6>FECHA: '.$visita["fecha"].' | '.$visita["tipoUsuario"].': '.$visita["usuario"].' | FOTOS: '.$cantidadFotos.' </h6>';
					$html.='<hr class="hrFotos" />';

					foreach ($arrayFoto[$key][$keyVisita] as $keyFoto => $foto) {
						$mpdf->imageVars[$foto["imgRef"]] = file_get_contents('http://movil.visualimpact.com.pe/fotos/impactTrade_android/'.$foto["carpetaFoto"].'/'.$foto["imgRef"] );
						$html.='<div style="float:left;width:50%">';
							$html.='<img class="foto" src="var:'.$foto["imgRef"].'" style="height:350px; border: 4px solid #cccccc;" />';
							$html.='<table class="infoFoto" style="width:550px;text-align:left;margin:0 auto;">';
							$html.='<tr>';
								$html.='<td class="nombreDatoInfoFoto">Hora:</td>';
								$html.='<td>'.$foto["horaFoto"].'</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="nombreDatoInfoFoto">Tipo Foto:</td>';
								$html.='<td>'.$foto["tipoFoto"].'</td>';
							$html.='</tr>';
						$html.='</table>';
						$html.='</div>';
					}  
					
					$mpdf->WriteHTML($html);
					$mpdf->AddPage(); 
				}	
			
				
			}
			//$mpdf->WriteHTML($html);
		}
		$mpdf->Output('Fotos.pdf', "D");
	}

	public function exportarPdfNewFormato(){
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);
		/*====Filtrado=====*/
		$visitas = $this->m_foto->getVisitas($data)->result_array();
		$filtro_visitas = '';
		if(count($visitas)>0){
			$filtro_visitas ='and v.idVisita IN (';
				$i=0;
				$total = count($visitas);
				foreach($visitas as $row ){
					if($i<($total-1)){
						$filtro_visitas.= $row['idVisita'].',';
					}else if($i==($total-1)){
						$filtro_visitas.= $row['idVisita'];
					}
					$i++;
				}
			$filtro_visitas.=')';
		}
		$fotosClientes = $this->m_foto->getFotosNew($data,$filtro_visitas)->result_array();
		
		$segmentacion = getSegmentacion($data);
		$dataPdf = []; 

		if(!empty($fotosClientes)){
			foreach ($fotosClientes as $k => $v) {

				if(empty($v['imgRef'])){
					continue;
				}
				
				$dataPdf[$v['idVisita']]['fecha'] = !empty($v['fecha']) ? $v['fecha'] : '-' ;
				$dataPdf[$v['idVisita']]['idCliente'] = !empty($v['idCliente']) ? $v['idCliente'] : '-' ;
				$dataPdf[$v['idVisita']]['codCliente'] = !empty($v['codCliente']) ? $v['codCliente'] : '-' ;
				$dataPdf[$v['idVisita']]['razonSocial'] = !empty($v['razonSocial']) ? $v['razonSocial'] : '-' ;
				$dataPdf[$v['idVisita']]['direccion'] = !empty($v['direccion']) ? $v['direccion'] : '-' ;
				$dataPdf[$v['idVisita']]['nombreUsuario'] = !empty($v['nombreUsuario']) ? $v['nombreUsuario'] : '-' ;
				$dataPdf[$v['idVisita']]['grupoCanal'] = !empty($v['grupoCanal']) ? $v['grupoCanal'] : '-' ;
				$dataPdf[$v['idVisita']]['canal'] = !empty($v['canal']) ? $v['canal'] : '-' ;
				$dataPdf[$v['idVisita']]['colDyn']['distribuidora'] = !empty($v['distribuidora']) ? strtoupper($v['distribuidora']) : '' ;
				$dataPdf[$v['idVisita']]['colDyn']['ciudadDistribuidoraSuc'] = !empty($v['ciudadDistribuidoraSuc']) ? strtoupper($v['ciudadDistribuidoraSuc']) : '' ;
				$dataPdf[$v['idVisita']]['colDyn']['zona'] = !empty($v['zona']) ? strtoupper($v['zona']) : '' ;
				$dataPdf[$v['idVisita']]['colDyn']['plaza'] = !empty($v['plaza']) ? strtoupper($v['plaza']) : '' ;
				$dataPdf[$v['idVisita']]['colDyn']['cadena'] = !empty($v['cadena']) ? strtoupper($v['cadena']) : '' ;
				$dataPdf[$v['idVisita']]['colDyn']['banner'] = !empty($v['banner']) ? strtoupper($v['banner']) : '' ;
				$dataPdf[$v['idVisita']]['fotos'][$v['idVisitaFoto']]['modulo'] = !empty($v['modulo']) ? strtoupper($v['modulo']) : '-' ;
				$dataPdf[$v['idVisita']]['fotos'][$v['idVisitaFoto']]['foto'] = !empty($v['imgRef']) ? $v['imgRef'] : ''  ;
				$dataPdf[$v['idVisita']]['fotos'][$v['idVisitaFoto']]['carpetaFoto'] = !empty($v['carpetaFoto']) ? $v['carpetaFoto'] : '-' ;
				$dataPdf[$v['idVisita']]['fotos'][$v['idVisitaFoto']]['tipoFoto'] = !empty($v['tipoFoto']) ? $v['tipoFoto'] : '-' ;
				$dataPdf[$v['idVisita']]['fotos'][$v['idVisitaFoto']]['hora'] = !empty($v['horaFoto']) ? $v['horaFoto'] : '' ;

			}
	
		}
		$www=base_url().'public/';
		$style = '';
		$arr_header = array (
			'L' => array (
			  'content' => '',
			  'font-size' => 10,
			  'font-style' => 'B',
			  'font-family' => 'tahoma',
			  'color'=>'#000000'
			),
			'C' => array (
			  'content' => '',
			  'font-size' => 10,
			  'font-style' => 'B',
			  'font-family' => 'tahoma',
			  'color'=>'#000000'
			),
			'R' => array (
			  'content' => 'REPORTE FOTOGRÁFICO',
			  'font-size' => 10,
			  'font-style' => 'B',
			  'font-family' => 'tahoma',
			  'color'=>'#000000',
			  'font-weight' => "bold",
			),
			'line' => 1,
		);
		  
		ini_set('memory_limit','1024M');
		set_time_limit(0);

		require_once('../vendor/autoload.php');
		$mpdf = new \Mpdf\Mpdf();

		if( count($fotosClientes) > 400 ){
			//
			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Excedio el maximo permitido.</b>';
			//
			$mpdf->SetHTMLHeader('');
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($fotosClientes) >= 1 && count($fotosClientes) < 400 ){
			$html = ''; $num=1; $cant=0;

			$mpdf->defHeaderByName(
				'myHeader',
				$arr_header
			);
			$mpdf->AddPageByArray(array(
				'orientation' => 'L',
				'condition' => 'NEXT-ODD',
				'ohname' => 'myHeader',
				'ehname' => 'html_myHeader2',
				'ohvalue' => 1,
				'ehvalue' => 1,
			));
			$mpdf->Image('public/assets/images/visualimpact/logo.png', 70, 70, 150, 50, 'png', '', true, false);


			foreach($dataPdf as $k => $v){
				$mpdf->setFooter('{PAGENO}');
				$arr_header['L']['content'] = date_change_format($v['fecha']);
				if($segmentacion['tipoSegmentacion'] == "tradicional"){
					$arr_header['C']['content'] = strtoupper($v['colDyn']['distribuidora']) . ' - ' . strtoupper($v['colDyn']['ciudadDistribuidoraSuc']);

				}else if($segmentacion['tipoSegmentacion'] == "mayorista") {
					$arr_header['C']['content'] = strtoupper($v['colDyn']['plaza']);

				}else if($segmentacion['tipoSegmentacion'] == "moderno") {
					$arr_header['C']['content'] = strtoupper($v['colDyn']['cadena']) . ' - ' . strtoupper($v['colDyn']['banner']);

				}
				
				$mpdf->defHeaderByName(
					'myHeader',
					$arr_header
				);

				$mpdf->AddPageByArray(array(
					'orientation' => 'L',
					'condition' => 'NEXT-ODD',
					'ohname' => 'myHeader',
					'ehname' => 'html_myHeader2',
					'ohvalue' => 1,
					'ehvalue' => 1,
				));
				$v['segmentacion'] = $segmentacion;
				$mpdf->WriteHTML($this->load->view("pdf/header_new",$v,true));
				$mpdf->WriteHTML($this->load->view("modulos/Fotos/pdf_fotografico/body_fotografico",$v,true));
				
				
			}
		} else {
			//
			$html='<br/><br/><br/><b>No se encontraron resultados para la consulta realizada.</b>';
			
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		}
		//
		$mpdf->useSubstitutions = false;
		$mpdf->simpleTables = true;

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		$fechas = getFechasDRP($data['txt-fechas']);
		$mpdf->Output("ReporteFotografico".$fechas[0].'-'.$fechas[1].".pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}
}
