<?php
class Fotografico extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_fotografico', 'model');
	}

	public function index()
	{
		$config = array();
		$config['nav']['menu_active'] = '83';
		$config['css']['style'] = array(
			'assets/libs/owl.carousel/owl.carousel',
			'assets/libs/prettyPhoto/prettyPhoto',
			'assets/custom/css/hfs_fotografico',
			'assets/libs/photoswipe/default-skin',
			'assets/libs/photoswipe/photoswipe',
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/owl.carousel/owl.carousel.min',
			'assets/libs/jquery.prettyPhoto/jquery.prettyPhoto',
			'assets/libs/photoswipe/photoswipe.min',
			'assets/libs/photoswipe/photoswipe-ui-default.min',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/fotografico'
		);

		$config['data']['icon'] = 'fa fa-camera';
		$config['data']['title'] = 'Auditoría Fotográfica';
		$config['data']['message'] = 'Auditoría Fotográfica';
		$config['data']['tiposUsuario'] = $this->db->get_where('trade.usuario_tipo',['estado'=>1])->result_array();
		$config['view'] = 'modulos/fotografico/index';

		$this->view($config);
	}

	public function lista_fotografico()
	{
		$post = json_decode($this->input->post('data'), true);

		$fechas = explode('-', $post['txt-fechas']);
		$fechaIni = $fechas[0];
		$fechaFin = $fechas[1];
		$params = array(
			'fecIni' => $fechaIni
			, 'fecFin' => $fechaFin
			, 'idProyecto' => $this->sessIdProyecto
			, 'tipoUsuario' => !empty($post['sl_tipoUsuario']) ? $post['sl_tipoUsuario'] : ''
			, 'grupoCanal' => !empty($post['grupo_filtro']) ? $post['grupo_filtro'] : ''
			, 'canal' => !empty($post['canal_filtro']) ? $post['canal_filtro'] : ''


			, 'tipoUsuario' => !empty($post['tipoUsuario_filtro']) ? $post['tipoUsuario_filtro'] : ''
			, 'usuario' => !empty($post['usuario_filtro']) ? $post['usuario_filtro'] : ''
			
			, 'distribuidoraSucursal' => !empty($post['distribuidoraSucursal_filtro']) ? $post['distribuidoraSucursal_filtro'] : ''
			, 'distribuidora' => !empty($post['distribuidora_filtro']) ? $post['distribuidora_filtro'] : ''
			, 'zona' => !empty($post['zona_filtro']) ? $post['zona_filtro'] : ''
			, 'plaza' => !empty($post['plaza_filtro']) ? $post['plaza_filtro'] : ''
			, 'cadena' => !empty($post['cadena_filtro']) ? $post['cadena_filtro'] : ''
			, 'banner' => !empty($post['banner_filtro']) ? $post['banner_filtro'] : ''

		);

		$array['visitas'] = $this->model->obtener_visitas($params);

		if (count($array['visitas']) < 1) {
			$result['result'] = 1;
			$result['data'] = getMensajeGestion('noRegistros');
		} else {

			$segmentacion = getSegmentacion(['grupoCanal_filtro'=>$post['grupo_filtro']]);
			$array['segmentacion'] = $segmentacion;
			$result['result'] = 1;
			$result['data'] = $this->load->view("modulos/fotografico/lista_fotografico", $array, true);
		}

		echo json_encode($result);
	}
	
	public function fotografico_pdf(){
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');

		$post=json_decode($this->input->post('data'),true);
		$fechas = explode('-', $post['txt-fechas']);
		$fecIni = $fechas[0];
		$fecFin = $fechas[1];

		$params = array(
			  'fecIni' => $fecIni
			, 'fecFin' => $fecFin
			, 'idProyecto' => $this->sessIdProyecto
			, 'grupoCanal' => !empty($post['grupo_filtro'])? $post['grupo_filtro'] : ''
			, 'canal' => !empty($post['canal_filtro'])? $post['canal_filtro'] : ''
			, 'distribuidora' => !empty($post['distribuidora_filtro'])? $post['distribuidora_filtro'] : ''
			, 'zona' => !empty($post['zona_filtro'])? $post['zona_filtro'] : ''
		);

		$visitasTotal = $this->model->obtener_visitas($params);
		$fotos = $this->model->obtener_fotos_visitas($params);
		
		foreach($fotos as $row){
			$fotoVisita[$row['idVisita']]['tipoFoto'] = $row['modulo'];
			$fotoVisita[$row['idVisita']]['foto'] = $row['fotoUrl'];
		}
		
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
				$header .= '<td class="title" >AUDITORIA FOTOGRAFICA</td>';
			$header .= '</tr>';
		$header .= '</table>';

		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$newPage = 0;
		
		if( count($visitasTotal)>100 ){

			$html='<br/><br/><br/><b>Se encontraron más de 100 registros. Tiene que filtrar mejor la información.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($visitasTotal)>0 && count($visitasTotal)<100 ){

			foreach($visitasTotal as $row){ 
				$html = '';
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
							$html .= '<td>COD GTM</td>'; //} elseif ($tipoReporte == '13') { $html .= '<td>COD VENDEDOR</td>'; }
							$html .= '<td style="font-weight:bold;">'.$row['idUsuario'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>GTM</td>'; //} elseif ($tipoReporte == '13') { $html .= '<td>VENDEDOR</td>'; }
							$html .= '<td style="font-weight:bold;">'.$row['nombreUsuario'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>COD POS</td>';
							$html .= '<td style="font-weight:bold;">'.$row['idCliente'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>POS</td>';
							$html .= '<td style="font-weight:bold;">'.$row['razonSocial'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>Grupo Canal</td>';
							$html .= '<td style="font-weight:bold;">'.$row['grupoCanal'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>Canal</td>';
							$html .= '<td style="font-weight:bold;">'.$row['canal'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							//if ($tipoReporte == '1') { 
								$html .= '<td>RESULTADO</td>'; 
								$html .= '<td style="font-weight:bold;">'.$row['resultado'].'%</td>';
							/* } elseif ($tipoReporte == '13') { 
								$html .= '<td>RESULTADO - OBSERVACION</td>';
								$html .= '<td style="font-weight:bold;">'.$row->resultado.'%  -  '.$row->observacion.'</td>';
							} */
						$html .= '</tr>';
					$html .= '</tbody>';
				$html .= '</table>';
				$html .= '<table>';
				$html .= '<thead>';
				   $html .= '<tr><th colspan="2" style="background-color:#CCC;">FOTOS</th></tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				if( isset( $fotoVisita[$row['idVisita']] ) ){
					$h=0;
					foreach($fotoVisita[$row['idVisita']] as $row_f => $value_f){
						if($h%2==0) $html .= '<tr>';
							$html .= '<td class="item" >';
								$html .='<img class="foto" src="'.verificarUrlFotos($value_f['foto']).$value_f['tipoFoto'].'/'.$value_f['foto'].'" width="240" height="200" /><br />';
								$html .= 'Tipo Foto: '.$value_f['tipoFoto'].'<br />';
							$html .= '</td>';
						if($h%2==0) $html .= '</tr>';
						$h++;
					}
				} 
				$html .= '</tbody>';
				$html .= '</table>';

				$mpdf->SetHTMLHeader($header);
				$mpdf->setFooter('{PAGENO}');
				$mpdf->AddPage();
				$mpdf->WriteHTML($style);
				$mpdf->WriteHTML($html);
			}
		} else {

			$html='<br/><br/><br/><b>No se encontraron resultados para la consulta realizada.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		}

		$mpdf->Output('fotografico.pdf','D');
	}

	public function auditar_fotografico()
	{
		$post = json_decode($this->input->post('data'), true);
		
		$fecIni = $post['fecIni'];
		$fecFin = $post['fecFin'];

		$params = array(
			'fecIni' => $fecIni, 'fecFin' => $fecFin
		);

		$filtro = "";
		$params['filtro'] = $filtro;
		$filtro2 = "";
		$total = count($post);
		$id = array();
		$j = 0;
		for ($i = 0; $i < $total; $i++) {
			if (!empty($post[$i]['idVisita'][0])) {
				$id[$j] = $post[$i]['idVisita'][0];
				$j++;
			}
		}
		$total_id = count($id);

		if ($total_id > 1) {
			for ($z = 0; $z < $total_id; $z++) {
				if ($z == 0) {
					$filtro .= 'AND v.idVisita IN ( ' . $id[$z] . ',';
					$filtro2 .= 'AND vd.idVisita IN ( ' . $id[$z] . ',';
				} else if ($z != 0 && $z != ($total_id - 1)) {
					$filtro .= $id[$z] . ',';
					$filtro2 .= $id[$z] . ',';
				} else if ($z == ($total_id - 1)) {
					$filtro .= $id[$z] . ')';
					$filtro2 .= $id[$z] . ')';
				}
			}
			$params['filtro'] = $filtro;
		} else if ($total_id == 1) {
			$filtro .= "AND v.idVisita IN ( " . $id[0] . ")";
			$params['filtro'] = $filtro;
			$filtro2 .= "AND vd.idVisita IN ( " . $id[0] . ")";
		}

		if(empty($params['filtro'])){
			$result['result'] = 0;
			$result['data']['content'] = createMessage(['type'=>2,'message'=>'Debe seleccionar al menos una visita para generar la auditoría']);
			echo json_encode($result);
			exit();
		}

		$array['visitasAuditar'] = $this->model->obtener_visitas_auditar($params);
		$visibilidad = $this->model->obtener_visibilidad($filtro2);
		$fotos = $this->model->obtener_fotos_visitas($params);
		
		foreach ($visibilidad as $row) {
			$array['elementos'][$row['idVisita']][$row['idElementoVis']]['elemento'] = $row['nombre'];
			$array['elementos'][$row['idVisita']][$row['idElementoVis']]['pc'] = $row['pc'];
			$array['elementos'][$row['idVisita']][$row['idElementoVis']]['pl'] = $row['pl'];
			$array['elementos'][$row['idVisita']][$row['idElementoVis']]['presencia'] = $row['presencia'];
			$array['elementos'][$row['idVisita']][$row['idElementoVis']]['idVisitaVisibilidadDet'] = $row['idVisitaVisibilidadDet'];
		}
		$fotoVisita = [];
		foreach($fotos as $row){
			$fotoVisita[$row['idVisita']][] = [
				'tipoFoto' => $row['modulo'],
				'idModulo' => $row['idModulo'],
				'fotoUrl' => $row['fotoUrl'],
			];
		}

		if (count($array['visitasAuditar']) < 1) {
			$result['result'] = 1;
			$result['data'] = getMensajeGestion('noRegistros');
		} else {
			$result['result'] = 1;
			$array['fotosVisita'] = $fotoVisita;
			$result['data'] = $this->load->view("modulos/fotografico/auditar_fotografico", $array, true);
		}

		echo json_encode($result);
	}

	public function procesar_auditoria()
	{
		$idVisita = $this->input->post('idVisita');
		$resultado = $this->input->post('resultado');
		$precios = $this->input->post('precios');

		$elementos = $this->input->post('elementos');
		$Auditoria = $this->model->guardarVisitaAuditarCartera($idVisita, $resultado, $elementos, $precios);

		if ($Auditoria == 1) {
			$array = array('cod' => 1, 'msg' => 'RESULTADO AUDITORIA FOTOGRAFICA: ' . $resultado . '%');
		} else {
			$array = array('cod' => 0, 'msg' => 'ERROR: NO SE PUDO REGISTRAR LA AUDITORIA FOTOGRAFICA');
		}

		echo json_encode($array);
	}
	public function verFotoModal(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		if (empty($post)) {
			$result['result'] = 0;
			$result['data']['content'] = getMensajeGestion('noRegistros');
		} else {
			$result['result'] = 1;
			$result['data']['content'] = $this->load->view("modulos/fotografico/verFotoModal", $post, true);
		}

		echo json_encode($result);
	}

}
