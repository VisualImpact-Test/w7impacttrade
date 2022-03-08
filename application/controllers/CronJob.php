<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronJob extends CI_Controller{

	public function __construct(){
		parent::__construct();
        $this->load->model('M_cronjob', 'model');
    }

    function pg_ejecucion_total_hfs()
    {
        $fecha=date("d/m/Y");
        $distribuidoras=$this->model->get_distribuidoras_sucursal()->result_array();
        $contactos=$this->model->get_contactos_pg(['tradicional'=>true])->result_array();
        $visitas=$this->model->get_visitas_pg(['idGrupoCanal'=>4])->result_array();
        $resultados=$this->model->get_resultados_pg(['idGrupoCanal'=>4])->result_array();
        
		//Auditoria PG
        $email=array();
		$array=array();
		foreach($distribuidoras as $k_d=>$v_d){
			unset($email); unset($array);
			foreach($contactos as $k_c=>$v_c){
				if($v_d['id']==$v_c['idDistribuidoraSucursal']){
					$email[]=$v_c['email'];
				}
			}

			foreach($visitas as $k_v=>$v_v){
				if($v_d['id']==$v_v['idDistribuidoraSucursal']){
					$array['data'][]=$v_v;
				}
			}
			foreach($resultados as $v_r){
				if($v_d['id']==$v_r['idDistribuidoraSucursal']){
					$array['resultados'][$v_r['idVisita']]['porcentajeEO']=$v_r['porcentajeEO'];
					$array['resultados'][$v_r['idVisita']]['porcentajeINI']=$v_r['porcentajeINI'];
					$array['resultados'][$v_r['idVisita']]['porcentajeEA']=$v_r['porcentajeEA'];
					$array['resultados'][$v_r['idVisita']]['porcentajePM']=$v_r['porcentajePM'];
				}
			}

			if(!empty($array['data']) && isset($email) ){
				$contenido=$this->load->view('cronjob/ejecucion_total/hfs_correo',$array,true);
				$correo['to']=implode(",",$email);
				$titulo='PG - Ejecucion Total HFS '.$v_d['nombre'].' '.$fecha;
				$config = [
					'to'=>$correo,
					'asunto'=>$titulo,
					'contenido'=>$contenido
				];
				$config['cc']='team.sistemas@visualimpact.com.pe,cristihan.rivera@visualimpact.com.pe, ingrid.peralta@visualimpact.com.pe, walter.becerra@visualimpact.com.pe, proyectos.hfs@visualimpact.com.pe';
				email($config);
			}
		}
		$this->pg_ejecucion_total_whls();
    }
    function pg_ejecucion_total_whls()
    {
        $fecha=date("d/m/Y");
        $plazas=$this->model->get_plazas()->result_array();
        $contactos=$this->model->get_contactos_pg(['mayorista'=>true])->result_array();
        $visitas=$this->model->get_visitas_pg(['idGrupoCanal'=>5])->result_array();
        $resultados=$this->model->get_resultados_pg(['idGrupoCanal'=>5])->result_array();
        
		//Auditoria PG
        $email=array();
		$array=array();
		foreach($plazas as $k_d=>$v_d){
			unset($email); unset($array);
			foreach($contactos as $k_c=>$v_c){
				if($v_d['id']==$v_c['idPlaza']){
					$email[]=$v_c['email'];
				}
			}

			foreach($visitas as $k_v=>$v_v){
				if($v_d['id']==$v_v['idPlaza']){
					$array['data'][]=$v_v;
				}
			}
			foreach($resultados as $v_r){
				if($v_d['id']==$v_r['idPlaza']){
					$array['resultados'][$v_r['idVisita']]['porcentajeEO']=$v_r['porcentajeEO'];
					$array['resultados'][$v_r['idVisita']]['porcentajeINI']=$v_r['porcentajeINI'];
					$array['resultados'][$v_r['idVisita']]['porcentajeEA']=$v_r['porcentajeEA'];
					$array['resultados'][$v_r['idVisita']]['porcentajePM']=$v_r['porcentajePM'];
				}
			}

			if(!empty($array['data']) && isset($email) ){
				$contenido=$this->load->view('cronjob/ejecucion_total/whls_correo',$array,true);
				$correo['to']=implode(",",$email);
				$titulo='PG - Ejecucion Total WHLS '.$v_d['nombre'].' '.$fecha;
				$config = [
					'to'=>$correo,
					'asunto'=>$titulo,
					'contenido'=>$contenido
				];
				$config['cc']='team.sistemas@visualimpact.com.pe,cristihan.rivera@visualimpact.com.pe, ingrid.peralta@visualimpact.com.pe, walter.becerra@visualimpact.com.pe, proyectos.hfs@visualimpact.com.pe';
				email($config);
			}
		}

    }

	public function sustento_fotos_tradicional($iniFecha, $finFecha)
	{
		$desde = 1;
		$hasta = 10000;

		$response_query_1 = $this->model->sustento_fotos_tradicional($iniFecha, $finFecha, $desde, $hasta);

		/*while ($response_query_1 !== 0) {
			yield $response_query_1;
					
			$desde = $hasta + 1;
			$hasta += 10000;
			$response_query_1 = $this->model->sustento_fotos_tradicional($iniFecha, $finFecha, $desde, $hasta);	
		}*/
	}

	public function email_excel_sustento_fotos_tradicional()
	{
		ini_set('memory_limit', '-1');

		date_default_timezone_set('America/Lima');

		require APPPATH . '/vendor/autoload.php';

		$start = new DateTime();
		$end = clone $start;
		$iniFecha = $start->modify("first day of previous month")->format("Y-m-d");
		$finFecha = $end->modify("last day of previous month")->format("Y-m-d");
		$ruta_excel = FCPATH . 'public\\' . sprintf("%s-sustento-fotos-%s.xlsx", $start->format("F"), 'Tradicional');

		$sustento_fotos_tradicional =  $this->model->sustento_fotos_tradicional($iniFecha, $finFecha, 1, 10000);  //$this->sustento_fotos_tradicional($iniFecha, $finFecha);

		$this->generar_excel_sustento_fotos_tradicional($sustento_fotos_tradicional, $ruta_excel);

		$usuarios = $this->usuarios_enviar_excel();

		$asunto = sprintf('Sustento de Fotos - %s/%s - Tradicional', $start->format("Y"), $start->format("m"));
		foreach($usuarios as $usuario) {
			$response = $this->sendEmail([
				'to' => $usuario['email'],
				// 'cc' => 'daviddlcruz@outlook.com',
				'asunto' => $asunto,
				'contenido' => $asunto,
				'adjunto' => $ruta_excel
			]);	
		}	
	}

	public function email_excel_sustento_fotos_moderno()
	{
		date_default_timezone_set('America/Lima');

		require APPPATH . '/vendor/autoload.php';

		$start = new DateTime();
		$end = clone $start;
		$iniFecha = $start->modify("first day of previous month")->format("Y-m-d");
		$finFecha = $end->modify("last day of previous month")->format("Y-m-d");
		$ruta_excel = FCPATH . 'public\\' . sprintf("%s-sustento-fotos-%s.xlsx", $start->format("F"), 'moderno');

		$sustento_fotos_moderno = $this->model->sustento_fotos_moderno($iniFecha, $finFecha);

		$this->generar_excel_sustento_fotos_moderno($sustento_fotos_moderno, $ruta_excel);

		$usuarios = $this->usuarios_enviar_excel();

		$asunto = sprintf('Sustento de Fotos - %s/%s - Moderno', $start->format("Y"), $start->format("m"));
		foreach($usuarios as $usuario) {
			$response = $this->sendEmail([
				'to' => $usuario['email'],
				// 'cc' => 'daviddlcruz@outlook.com',
				'asunto' => $asunto,
				'contenido' => $asunto,
				'adjunto' => $ruta_excel
			]);	
		}
	}

	protected function generar_excel_sustento_fotos_moderno($query_data, $ruta_excel)
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("VisualImpact")
			->setTitle("Office 2007 XLSX Test Document");

		$sheet = $spreadsheet->getActiveSheet();

		$headers = ["#", "ID VISITA", "ID TIENDA", "COD TIENDA", "NOMBRE EMPRESA", "DEPARTAMENTO", "FECHA", "HORA INICIO", "HORA FIN", "LATITUD", "LONGITUD", "ID VISITA FOTO", "MODULO"];
		array_walk($headers, function($value, $key) use ($sheet) {
			$sheet->setCellValue(chr(65 + $key) . "1", $value);
		});

		$sheet->getStyle('A1:M1')->applyFromArray([
			'font'  => array(
				'color' => array('rgb' => '000000'),
				'size'  => 11,
				'name'  => 'Calibri',
				'bold' => true,
			)
		]);

		$ubicacionFila = 2;
		foreach($query_data as $visitaPrecio) {
			echo "count: " . ($ubicacionFila - 1) . PHP_EOL;
			$sheet->setCellValue("A" . $ubicacionFila, $ubicacionFila - 1);
			$sheet->setCellValue("B" . $ubicacionFila, !empty($visitaPrecio["idVisita"]) ? $visitaPrecio["idVisita"] : '-');
			$sheet->setCellValue("C" . $ubicacionFila, !empty($visitaPrecio["idTienda"]) ? $visitaPrecio["idTienda"] : '-');
			$sheet->setCellValue("D" . $ubicacionFila, !empty($visitaPrecio["codigoTienda"]) ? $visitaPrecio["codigoTienda"] : '-');
			$sheet->setCellValue("E" . $ubicacionFila, !empty($visitaPrecio["razonSocial"]) ? $visitaPrecio["razonSocial"] : '-');
			$sheet->setCellValue("F" . $ubicacionFila, !empty($visitaPrecio["departamento"]) ? $visitaPrecio["departamento"] : '-');
			$sheet->setCellValue("G" . $ubicacionFila, !empty($visitaPrecio["fecha"]) ? $visitaPrecio["fecha"] : '-');
			$sheet->setCellValue("H" . $ubicacionFila, !empty($visitaPrecio["horaIni"]) ? $visitaPrecio["horaIni"] : '-');
			$sheet->setCellValue("I" . $ubicacionFila, !empty($visitaPrecio["horaFin"]) ? $visitaPrecio["horaFin"] : '-');
			$sheet->setCellValue("J" . $ubicacionFila, !empty($visitaPrecio["latitud"]) ? $visitaPrecio["latitud"] : '-');
			$sheet->setCellValue("K" . $ubicacionFila, !empty($visitaPrecio["longitud"]) ? $visitaPrecio["longitud"] : '-');
			$sheet->setCellValue("L" . $ubicacionFila, !empty($visitaPrecio["idVisitaFoto"]) ? $visitaPrecio["idVisitaFoto"] : '-');
			$sheet->setCellValue("M" . $ubicacionFila, !empty($visitaPrecio["modulo"]) ? $visitaPrecio["modulo"] : '-');
			$ubicacionFila++;
		}
		echo 'generando excel' . PHP_EOL;

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save($ruta_excel);

		return true;
	}

	protected function generar_excel_sustento_fotos_tradicional($query_data,  $ruta_excel)
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("VisualImpact")
			->setTitle("Office 2007 XLSX Test Document");

		$sheet = $spreadsheet->getActiveSheet();

		$headers = ["#", "ID CLIENTE", "COD CLIENTE", "NOMBRE EMPRESA", "CUIDAD", "FECHA", "HORA INICIO", "LAT INICIAL", "LONG FINAL", "MODULO", "ID MODULO", "FOTO"];
		array_walk($headers, function($value, $key) use ($sheet) {
			$sheet->setCellValue(chr(65 + $key) . "1", $value);
		});

		$sheet->getStyle('A1:L1')->applyFromArray([
			'font'  => array(
				'color' => array('rgb' => '000000'),
				'size'  => 11,
				'name'  => 'Calibri',
				'bold' => true,
			)
		]);

		$ubicacionFila = 2;
		foreach($query_data as $data) {
			echo "count: " . count($data) . PHP_EOL;
			foreach ($data as $visitaPrecio) {
				$sheet->setCellValue("A" . $ubicacionFila, $ubicacionFila - 1);
				$sheet->setCellValue("B" . $ubicacionFila, !empty($visitaPrecio["idCliente"]) ? $visitaPrecio["idCliente"] : '-');
				$sheet->setCellValue("C" . $ubicacionFila, !empty($visitaPrecio["codCliente"]) ? $visitaPrecio["codCliente"] : '-');
				$sheet->setCellValue("D" . $ubicacionFila, !empty($visitaPrecio["empresa"]) ? $visitaPrecio["empresa"] : '-');
				$sheet->setCellValue("E" . $ubicacionFila, !empty($visitaPrecio["cuidad"]) ? $visitaPrecio["cuidad"] : '-');
				$sheet->setCellValue("F" . $ubicacionFila, !empty($visitaPrecio["fecha"]) ? $visitaPrecio["fecha"] : '-');
				$sheet->setCellValue("G" . $ubicacionFila, !empty($visitaPrecio["horaIni"]) ? $visitaPrecio["horaIni"] : '-');
				$sheet->setCellValue("H" . $ubicacionFila, !empty($visitaPrecio["latIni"]) ? $visitaPrecio["latIni"] : '-');
				$sheet->setCellValue("I" . $ubicacionFila, !empty($visitaPrecio["lonFin"]) ? $visitaPrecio["lonFin"] : '-');
				$sheet->setCellValue("J" . $ubicacionFila, !empty($visitaPrecio["modulo"]) ? $visitaPrecio["modulo"] : '-');
				$sheet->setCellValue("K" . $ubicacionFila, !empty($visitaPrecio["idModulo"]) ? $visitaPrecio["idModulo"] : '-');
				$sheet->setCellValue("L" . $ubicacionFila, !empty($visitaPrecio["foto"]) ? $visitaPrecio["foto"] : '-');
				$ubicacionFila++;
			}
		}
		echo 'generando excel' . PHP_EOL;

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save($ruta_excel);

		return true;
	}

	protected function usuarios_enviar_excel()
	{
		$correos = $this->model->correos_sustento();
		
		$array = array();
		$i=0;
		foreach($correos as $row){
			$array[$i]['nombre']=$row['nombre'];
			$array[$i]['email']=$row['correo'];
			$array[$i]['can_view']=$row['can_view'];
			$i++;
		}
		
		return $array;
		
		/*return [
			[
				'nombre' => 'David gmail',
				'email' => 'gpalomino9690@gmail.com',
				'can_view' => 1
			],
			[
				'nombre' => 'Luis Armando Durand Martinez',
				'email' => 'gustavo.palomino@visualimpact.com.pe',
				'can_view' => 2
			],
			[
				'nombre' => 'David visualimpact',
				'email' => 'gustavo.palomino@visualimpact.com.pe',
				'can_view' => 3
			],
		];*/
	}

	public function sendEmail( $email = array() ){
		$result = false;
		$defaults = array(
			'to' => '',
			'cc' => '',
			'asunto' => '',
			'contenido' => '',
			'adjunto' => ''
		);
		
		$email += $defaults;

		if( !empty($email['to']) && !empty($email['asunto']) ){

			$this->load->library('email');

			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_timeout' => 20,
				'smtp_user' => 'requerimiento.visual@visualimpact.com.pe',
				'smtp_pass' => 'Req.2020',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'newline' => "\r\n"
			);

			$this->email->initialize($config);
			$this->email->clear(true);

			$this->email->from('team.sistemas@visualimpact.com.pe', 'Visual Impact - Intranet');
			$this->email->to($email['to']);

			if( !empty($email['cc']) ){
				$this->email->cc($email['cc']);
			}

			$this->email->subject($email['asunto']);
			$this->email->message($email['contenido']);
			if( !empty($email['adjunto']) ){
				$this->email->attach($email['adjunto']);
			}

			if( $this->email->send() ){
				$result = true;
			}
		}

		return $result;
	}
}
?>