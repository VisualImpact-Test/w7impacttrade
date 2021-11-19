<?php
class PremiacionesSimple extends MY_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_premiaciones', 'model');
	}

	public function index()
	{
		$config = array();

		$config['nav']['menu_active'] = '140';
		$config['css']['style'] = array(
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/premiacionesSimple'
		);

		$config['data']['icon'] = 'fal fa-trophy-alt';
		$config['data']['title'] = 'Premiaciones Simple';
		$config['data']['message'] = 'Premiaciones';
		$config['view'] = 'modulos/premiacionesSimple/index';

		$array=array();
		$array['idCuenta']=$this->session->userdata('idCuenta');
		$config['data']['premiaciones'] = $this->model->obtener_premiaciones($array)['datos'];

		$this->view($config);
	}

	public function lista_premiaciones()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		
		$fechas = explode('-', $post['txt-fechas']);
		$fechaIni = $fechas[0];
		$fechaFin = $fechas[1];

		$params = array(
			'fecIni' => $fechaIni, 'fecFin' => $fechaFin, 
			'idPremiacion' => $post['sel-premiacion'], 
			'idGrupoCanal' => $post['grupoCanal_filtro'], 
			'idCanal' => $post['canal_filtro'],
			
			'tipoUsuario' => empty($post['tipoUsuario_filtro']) ? '' : $post['tipoUsuario_filtro'],
			'usuario' => empty($post['usuario_filtro']) ? '' : $post['usuario_filtro'],
			
			'distribuidoraSucursal' => empty($post['distribuidoraSucursal_filtro']) ? '' : $post['distribuidoraSucursal_filtro'],
			'distribuidora' => empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'],
			'zona' => empty($post['zona_filtro']) ? '' : $post['zona_filtro'],
			'plaza' => empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'],
			'cadena' => empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'],
			'banner' => empty($post['banner_filtro']) ? '' : $post['banner_filtro'],
	
		);
		$array['premiaciones'] = $this->model->obtener_premiacionesvisitaSimple($params);

		if (count($array['premiaciones']) < 1) {
			$result['result'] = 0;
			$result['data']['html'] = getMensajeGestion("noRegistros");
		} else {
			$result['result'] = 1;
			$segmentacion = getSegmentacion($post);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/premiacionesSimple/lista_premiaciones", $array, true);

			$result['data']['views']['contentPremiaciones']['datatable'] = 'tb-premiaciones';
			$result['data']['views']['contentPremiaciones']['html'] = $html;
			$result['data']['configTable'] =  [];
		}

		echo json_encode($result);
	}
	
	public function premiaciones_pdf(){
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');

		$post=json_decode($this->input->post('data'),true);
		$fecIni = $post['datos']['fecIni'];
		$fecFin = $post['datos']['fecFin'];
		
		$params = array(
			  'fecIni' => $fecIni,
			   'fecFin' => $fecFin,
			'idPremiacion' => $post['datos']['sel-premiacion'],
			'idGrupoCanal' => $post['datos']['grupoCanal_filtro'], 
			'idCanal' => $post['datos']['canal_filtro'],
			
			'tipoUsuario' => empty( $post['datos']['tipoUsuario_filtro']) ? '' :  $post['datos']['tipoUsuario_filtro'],
			'usuario' => empty( $post['datos']['usuario_filtro']) ? '' :  $post['datos']['usuario_filtro'],
			
			'distribuidoraSucursal' => empty( $post['datos']['distribuidoraSucursal_filtro']) ? '' :  $post['datos']['distribuidoraSucursal_filtro'],
			'distribuidora' => empty( $post['datos']['distribuidora_filtro']) ? '' :  $post['datos']['distribuidora_filtro'],
			'zona' => empty( $post['datos']['zona_filtro']) ? '' :  $post['datos']['zona_filtro'],
			'plaza' => empty( $post['datos']['plaza_filtro']) ? '' :  $post['datos']['plaza_filtro'],
			'cadena' => empty( $post['datos']['cadena_filtro']) ? '' :  $post['datos']['cadena_filtro'],
			'banner' => empty( $post['datos']['banner_filtro']) ? '' :  $post['datos']['banner_filtro'],
		);

		$visitasTotal = $this->model->obtener_premiacionesvisitaSimple($params);

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
				$header .= '<td class="title" >PREMIACIONES</td>';
			$header .= '</tr>';
		$header .= '</table>';

		ini_set('memory_limit','1024M');
		set_time_limit(0);

		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$newPage = 0;
		
		if( count($visitasTotal)>400 ){

			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Tiene que filtrar mejor la información.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($visitasTotal)>0 && count($visitasTotal)<400 ){
			$html = ''; $num=1; $cant=0;
			foreach($visitasTotal as $row){ $cant++;
					$tipo = !empty($row['tipoPremiacion'])? $row['tipoPremiacion'] : '-';
					$motivo = '-';

					$html .= '<br /><br />';
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
								$html .= '<td>POS</td>';
								$html .= '<td style="font-weight:bold;">'.$row['razonSocial'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>PREMIACION</td>';
								$html .= '<td style="font-weight:bold;">'.$row['premiacion'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>PREMIADO</td>';
								$html .= '<td style="font-weight:bold;">'.$row['premiado'].'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								if($row['premiado']=='SI'){
									$html .= '<td>TIPO PREMIACION</td>';
									$html .= '<td style="font-weight:bold;">'.$tipo.'</td>';
								} else {
									$html .= '<td>MOTIVO NO PREMIO</td>';
									$html .= '<td style="font-weight:bold;">'.$motivo.'</td>';
								}
							$html .= '</tr>';
							$html .= '<tr>';
								if($row['fotoUrl']!=null){
									$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="http://movil.visualimpact.com.pe/fotos/impacttrade_android/premiacion/'.$row['fotoUrl'].'" width="320" height="240" /></td>';
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
						if(count($visitasTotal)==$cant){
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
		$mpdf->Output("premiaciones.pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}

	public function mostrarFoto()
	{
		$data['foto'] = $this->input->post('foto');

		$this->load->view("modulos/premiaciones/foto", $data);
	}
	
}
