<?php
class Premiaciones extends MY_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_premiaciones', 'model');
	}

	public function index()
	{
		$config = array();

		$config['nav']['menu_active'] = '84';
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
			'assets/custom/js/premiaciones'
		);

		$config['data']['icon'] = 'fal fa-trophy-alt';
		$config['data']['title'] = 'Premiaciones';
		$config['data']['message'] = 'Premiaciones';
		$config['view'] = 'modulos/premiaciones/index';

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
			'subcanal' => $post['subcanal_filtro'],

			'tipoUsuario' => empty($post['tipoUsuario_filtro']) ? '' : $post['tipoUsuario_filtro'],
			'usuario' => empty($post['usuario_filtro']) ? '' : $post['usuario_filtro'],
			
			'distribuidoraSucursal' => empty($post['distribuidoraSucursal_filtro']) ? '' : $post['distribuidoraSucursal_filtro'],
			'distribuidora' => empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'],
			'zona' => empty($post['zona_filtro']) ? '' : $post['zona_filtro'],
			'plaza' => empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'],
			'cadena' => empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'],
			'banner' => empty($post['banner_filtro']) ? '' : $post['banner_filtro'],
	
		);
		$array['premiaciones'] = $this->model->obtener_premiacionesvisita($params);

		if (count($array['premiaciones']) < 1) {
			$result['result'] = 0;
			$result['data']['html'] = getMensajeGestion("noRegistros");
		} else {
			$result['result'] = 1;
			$segmentacion = getSegmentacion($post);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/premiaciones/lista_premiaciones", $array, true);

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
										$params = explode("_",$row['fotoUrl']);
										$last = end($params);
										$pos = strpos($last,"WASABI");
										$ruta = '';
										if($pos === false ) $ruta = 'http://movil.visualimpact.com.pe/fotos/impactTrade_android/';
										else $ruta = 'https://s3.us-west-1.wasabisys.com/visualimpact.app/fotos/impactTrade_Android/';
									$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="'.$ruta.'premiacion/'.$row['fotoUrl'].'" width="320" height="240" /></td>';
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

	public function actualizar_estado()
	{
		$result = $this->result;

		$input = [];
		$input = json_decode($this->input->post('data'), true);

		$resultadoEstado = 'Inactivo';
		$input['status'] = '0';

		if ($input['estado'] == '0') {
			$resultadoEstado = 'Activo';
			$input['status'] = '1';
		}

		$actualizar = $this->model->actualizarEstado($input);

		$result = array();
		if ($actualizar) {
			$result['status'] = '1';
			$result['result_texto'] = $resultadoEstado;
			$result['result_id'] = $input['status'];
		} else {
			$result['status'] = '0';
			$result['result_texto'] = $resultadoEstado;
			$result['result_id'] = $input['status'];
		}

		echo json_encode($result);
	}

	public function premiaciones_configuracion()
	{
		$result = $this->result;
		$array=array();
		$array['idCuenta']=$this->session->userdata('idCuenta');
		$data['premiaciones'] = $this->model->obtener_premiaciones($array)['datos'];
		$result['data']['html'] = $this->load->view("modulos/premiaciones/form_configuracion", $data, true);

		echo json_encode($result);
	}

	public function premiaciones_configuracion_cargos()
	{
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);

		$idProyecto = $this->sessIdProyecto;

		$data['premiaciones_cargos'] = $this->model->obtener_premiaciones_cargos($post)['datos'];
		$data['grupo_canal'] = $this->model->get_grupoCanal([ 'idProyecto' => $idProyecto] );
		$data['canal'] = $this->model->get_canal([ 'idProyecto' => $idProyecto] );
		$data['plaza'] = $this->model->get_plaza([ 'idProyecto' => $idProyecto] );
		$data['distribuidora'] = $this->model->get_distribuidora([ 'idProyecto' => $idProyecto] );
		$data['nombre_premiacion'] = $post['nombre'];
		$data['id_premiacion'] = $post['idPremiacion'];

		$result['data']['html'] = $this->load->view("modulos/premiaciones/form_cargos", $data, true);

		echo json_encode($result);
	}

	public function premiaciones_cargos_guardar()
	{
		$result = $this->result;

		$post = $_POST;

		$fecha = new DateTime();
		$key = $fecha->getTimestamp();
		$archivo = $_FILES['file']['name'];

		$archivo = 'imagen-' . $key . '.jpg';
		copy($_FILES['file']['tmp_name'], 'public/files/img/' . $archivo);

		$post['foto'] = $archivo;

		$guardar = $this->model->insertarCargosPremiacion($post);

		$result['status'] = $guardar['status'];

		$obtener_cargos = $this->model->obtener_premiaciones_cargos([ 'idPremiacion' => $post['idPremiacion'] ])['datos'];

		$html = '';

		foreach ($obtener_cargos AS $key => $row) {
			$html .= '<tr data-id="' . $row['idCargo'] . '">';
			$html .= '<td>';
			$html .= $key+1;
			$html .= '</td>';
			$html .= '<td>';
			$html .= $row['grupoCanal'];
			$html .= '</td>';
			$html .= '<td>';
			$html .= (!empty($row['plaza']) ? $row['plaza'] : $row['distribuidora']);
			$html .= '</td>';
			$html .= '<td class="text-center">';
			$html .= '<a href="javascript:;" data-foto="' . base_url() . 'public/files/img/' . $row['foto'] . '" class="prettyphoto"><i class="fa fa-file-image" style="font-size: 20px;"></i></a>';
			$html .= '</td>';
			$html .= '<td class="text-center">';
			$html .= '<a href="javascript:;" data-id="' . $row['idCargo'] . '" class="eliminarCargoPremiacion"><i class="fa fa-times" style="font-size: 20px;"></i></a>';
			$html .= '</td>';
			$html .= '</tr>';
		}

		$result['result'] = $html;

		echo json_encode($result);
	}

	public function mostrarFoto()
	{
		$data['foto'] = $this->input->post('foto');

		$this->load->view("modulos/premiaciones/foto", $data);
	}

	public function eliminar_cargo(){
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);

		$this->model->eliminar_cargo($post);
		$obtener_cargos = $this->model->obtener_premiaciones_cargos([ 'idPremiacion' => $post['idPremiacion'] ])['datos'];

		$html = '';

		foreach ($obtener_cargos AS $key => $row) {
			$html .= '<tr data-id="' . $row['idCargo'] . '">';
			$html .= '<td>';
			$html .= $key+1;
			$html .= '</td>';
			$html .= '<td>';
			$html .= $row['grupoCanal'];
			$html .= '</td>';
			$html .= '<td>';
			$html .= (!empty($row['plaza']) ? $row['plaza'] : $row['distribuidora']);
			$html .= '</td>';
			$html .= '<td class="text-center">';
			$html .= '<a href="javascript:;" data-foto="' . base_url() . 'public/files/img/' . $row['foto'] . '" class="prettyphoto"><i class="fa fa-file-image" style="font-size: 20px;"></i></a>';
			$html .= '</td>';
			$html .= '<td class="text-center">';
			$html .= '<a href="javascript:;" data-id="' . $row['idCargo'] . '" class="eliminarCargoPremiacion"><i class="fa fa-times" style="font-size: 20px;"></i></a>';
			$html .= '</td>';
			$html .= '</tr>';
		}

		$result['data']['html'] = getMensajeGestion('eliminacionExitosa');
		$result['data']['tabla'] = $html;

		echo json_encode($result);
	}

	public function premiaciones_configuracion_objetivos(){
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);

		$idProyecto = $this->sessIdProyecto;

		$HT[0] = [
			'nombre' => 'Objetivos (Carga Masiva)',
			'data' => [
				0 => [
				'idCanal' => null,
				'idCliente' => null
				]
			],
			'headers' => [
				'ID CANAL(*) ',
				'ID CLIENTE(*) ',
			],
			'columns' => [
				['data' => 'idCanal', 'type' => 'text', 'placeholder' => 'ID CANAL', 'width' => '100%'],
				['data' => 'idCliente', 'type' => 'text', 'placeholder' => 'ID CLIENTE', 'width' => '100%'],
			],
			'colWidths' => '100%',
			// 'hideColumns'=> [1, 2],
		];
		$data['hojas'] = [0 => $HT[0]['nombre']];
		$data['premiaciones_objetivos'] = $this->model->obtener_premiaciones_objetivos($post)['datos'];
		$data['nombre_premiacion'] = $post['nombre'];
		$data['id_premiacion'] = $post['idPremiacion'];
		$result['result'] = 1;
		$result['data']['ht'] = $HT;

		$result['data']['html'] = $this->load->view("modulos/premiaciones/form_objetivos", $data, true);

		echo json_encode($result);
	}

	public function premiaciones_objetivos_guardar()
	{
		$this->db->trans_start();
		$result = $this->result;

		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Carga masiva objetivos';

		$array = [
			'canales' => [],
			'clientes' => [],
		];

		$canales = $this->model->get_canal(['idProyecto' => $idProyecto]);
		$clientes  = $this->model->get_cliente(['idProyecto' => $idProyecto, 'idCuenta' => $idCuenta])['datos'];

		foreach ($canales as $key => $row) {
			$array['canales'][$row['id']] = $row['id'];
		}
		foreach ($clientes as $key => $row) {
			$array['clientes'][$row['id']] = $row['id'];
		}

		array_pop($post['HT'][0]);

		if (empty($post['HT'][0])) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Alerta!';
			$result['msg']['content'] = createMessage(['type' => 2, 'message' => 'La carga masiva no contiene datos']);
			goto respuesta;
		}

		$insert = [];

		foreach ($post['HT'][0] as $key => $value) {
			if (empty($value['idCanal']) or empty($value['idCliente'])) {
				$result['result'] = 0;
				$result['msg']['title'] = 'Alerta!';
				$result['msg']['content'] = createMessage(['type' => 2, 'message' => 'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}

			$idCanal = !empty($array['canales'][$value['idCanal']]) ? $array['canales'][$value['idCanal']] : NULL;
			if(empty($idCanal)){
				$result['result'] = 0;
				$result['msg']['title'] = 'Alerta!';
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'El <strong>CANAL</strong> ingresado no existe en el sistema.<br> Fila:'.($key+1)]);
				goto respuesta;
			}
			$idCliente = !empty($array['clientes'][$value['idCliente']]) ? $array['clientes'][$value['idCliente']] : NULL;
			if(empty($idCliente)){
				$result['result'] = 0;
				$result['msg']['title'] = 'Alerta!';
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'El <strong>CLIENTE</strong> ingresado no existe en el sistema.<br> Fila:'.($key+1)]);
				goto respuesta;
			}

			$insert[] = [
				'idPremiacion' => $post['idPremiacion_cargo'],
				'idGrupoCanal' => $idCanal,
				'idCliente' => $idCliente
			];
		}

		$registro = false;

		if (!empty($insert)) {
			$registro = $this->model->insertarMasivoObjetivos($insert);
		}

		if (!$registro['insert']) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Alerta!';
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['title'] = 'Hecho!';
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$obtener_objetivos = $this->model->obtener_premiaciones_objetivos(['idPremiacion' => $post['idPremiacion_cargo']])['datos'];

		$html = '';

		foreach ($obtener_objetivos as $key => $row) {
			$mensajeEstado = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
			$badge = $row['estado'] == 1 ? 'badge-success' : 'badge-danger';

			$html .= '<tr data-id="' . $row['idObjetivo'] . '">';
			$html .= '<td>';
			$html .= $key + 1;
			$html .= '</td>';
			$html .= '<td>';
			$html .= $row['grupoCanal'];
			$html .= '</td>';
			$html .= '<td>';
			$html .= $row['idCliente'];
			$html .= '</td>';
			$html .= '<td>';
			$html .= $row['cliente'];
			$html .= '</td>';
			$html .= '<td class="text-center" style="font-size: 20px;">';
			$html .= '<span class="badge ' . $badge . '" id="estado-' . $row['idObjetivo'] . '">' . $mensajeEstado . '</span>';
			$html .= '&nbsp;<a style="cursor:pointer;" class="btn-estado-objetivo" data-id="' . $row['idObjetivo'] . '"><i class="fa fa-pencil"></i></a>';
			$html .= '</td>';
			$html .= '</tr>';
		}

		$result['data']['html'] = $html;

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function premiaciones_configuracion_objetivos_estado()
	{
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);

		$data['premiaciones_objetivos_estado'] = $this->model->obtener_premiaciones_objetivos($post)['datos'];

		$result['data']['html'] = $this->load->view("modulos/premiaciones/form_objetivos_estado", $data, true);

		echo json_encode($result);
	}

	public function premiaciones_objetivos_guardar_estado(){
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);

		$registro = $this->model->actualizar_objetivos_estado($post);

		if (!$registro['status']) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Alerta!';
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['title'] = 'Hecho!';
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		echo json_encode($result);
	}
	
}
