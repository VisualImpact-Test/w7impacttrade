<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EvidenciaFoto extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('gestionGerencial/M_evidenciaFoto', 'model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '136';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/evidenciaFoto'
		);

		$config['data']['icon'] = 'far fa-images';
		$config['data']['title'] = 'Evidencia Fotográfica';
		$config['data']['message'] = '';
		$config['view'] = 'modulos/gestionGerencial/evidenciaFotografica/index';

		$this->view($config);
	}

	public function filtrar()
	{
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
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ? $data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",", $data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '';

		$input['departamento_filtro'] = !empty($data->{'departamento_filtro'}) ? $data->{'departamento_filtro'} : '' ;
		$input['provincia_filtro'] = !empty($data->{'provincia_filtro'}) ? $data->{'provincia_filtro'} : '' ;
		$input['distrito_filtro'] = !empty($data->{'distrito_filtro'}) ? $data->{'distrito_filtro'} : '' ;

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;
		$segmentacion = getSegmentacion($input);
		if (!empty($rs_visitas)) {
			$array = array();
			$array['visitas'] = $rs_visitas;

			$rs_det = $this->model->obtener_detalle_evidencia_fotografica($input);
			foreach ($rs_det as $det) {
				!empty($det['foto']) ? $array['fotos'][$det['idVisita']][$det['idTipoFoto']][$det['idTipoFotoEvidencia']][] = $det['idVisitaFoto'] : '';
				$array['elementos'][$det['idTipoFoto']] = $det['tipoFoto'];
				$array['detalle'][$det['idVisita']][$det['idTipoFoto']] = $det;
			}
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/evidenciaFotografica/detalle_evidenciaFoto", $array, true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		$result['data']['views']['idContentEvidenciaFotografica']['datatable'] = 'tb-evidenciaFoto';
		$result['data']['views']['idContentEvidenciaFotografica']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					// "targets" => [5,6,7,8,9,10]
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];

		echo json_encode($result);
	}

	public function mostrarFotos()
	{
		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos"];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$fotos = $data->{'idVisitaFotos'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'usuario'};
		$array['perfil'] = $data->{'perfil'};
		$array['fotos'] = $this->model->obtener_fotos($fotos);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/gestionGerencial/evidenciaFotografica/verFotos", $array, true);

		echo json_encode($result);
	}

	public function getFormEvidenciaFotoPdf(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$array = array();
		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'Generar reporte fotográfico de evidencia fotográfica';
		$result['data']['width'] = '50%';
 		$result['data']['html'] = $this->load->view("modulos/gestionGerencial/evidenciaFotografica/frmPdf", $array, true);

		echo json_encode($result);
	}

	public function evidenciaFotografica_pdf()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$clientes = !empty($data->frmPdf->clientes) && is_array($data->frmPdf->clientes) ? implode(',',$data->frmPdf->clientes) : '' ;

		if(empty($clientes)){
			$clientes = !empty($data->frmPdf->clientes) && !is_array($data->frmPdf->clientes) ? $data->frmPdf->clientes : '' ;
		}

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['subcanal'] = $data->{'subcanal_filtro'};
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ? $data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",", $data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '';

		$input['departamento_filtro'] = !empty($data->{'departamento_filtro'}) ? $data->{'departamento_filtro'} : '' ;
		$input['provincia_filtro'] = !empty($data->{'provincia_filtro'}) ? $data->{'provincia_filtro'} : '' ;
		$input['distrito_filtro'] = !empty($data->{'distrito_filtro'}) ? $data->{'distrito_filtro'} : '' ;

		$input['topClientes']= $data->frmPdf->topClientes;
		$topClientesId = $this->model->getTopClientes($input)->result_array();
		$input['clientes'] = !empty($clientes) ? $clientes : implode(',', array_map('array_shift', $topClientesId));;

		$rs_evidenciaFotografica = $this->model->obtener_evidenciaFotografica($input);

		$segmentacion = getSegmentacion($input);
		$dataPdf = []; 
		
		if(!empty($rs_evidenciaFotografica)){
			foreach ($rs_evidenciaFotografica as $k => $v) {

				if(empty($v['foto'])){
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

				$dataPdf[$v['idVisita']]['evidenciaFotografica'][$v['idTipoFotoEvidencia']]['tipoFoto'] = !empty($v['tipoFoto']) ? strtoupper($v['tipoFoto']) : (!empty($v['comentario']) ? $v['comentario'] : '-') ;
				$dataPdf[$v['idVisita']]['evidenciaFotografica'][$v['idTipoFotoEvidencia']]['foto'] = !empty($v['foto']) ? $v['foto'] : ''  ;
				$dataPdf[$v['idVisita']]['evidenciaFotografica'][$v['idTipoFotoEvidencia']]['carpetaFoto'] = !empty($v['carpetaFoto']) ? $v['carpetaFoto'] : '-' ;
				$dataPdf[$v['idVisita']]['evidenciaFotografica'][$v['idTipoFotoEvidencia']]['tipoFotoEvidencia'] = !empty($v['tipoFotoEvidencia']) ? $v['tipoFotoEvidencia'] : '-' ;

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
			  'content' => 'REPORTE DE EVIDENCIA FOTOGRÁFICA',
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

		if( count($rs_evidenciaFotografica) > 400 ){
			//
			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Excedio el maximo permitido.</b>';
			//
			$mpdf->SetHTMLHeader('');
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($rs_evidenciaFotografica) >= 1 && count($rs_evidenciaFotografica) < 400 ){
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
				$mpdf->WriteHTML($this->load->view("modulos/gestionGerencial/evidenciaFotografica/pdf/header_cliente",$v,true));
				$mpdf->WriteHTML($this->load->view("modulos/gestionGerencial/evidenciaFotografica/pdf/body_promociones",$v,true));
				
				
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
		$mpdf->Output("Promociones".$fechas[0].'-'.$fechas[1].".pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}
}
