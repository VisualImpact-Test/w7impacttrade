<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CheckProductos extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_checkproductos','model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '128';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas',
			'assets/libs/tableTools/datatables.min',

		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/checkProductos'
		);

		$config['data']['icon'] = 'far fa-clipboard-list-check';
		$config['data']['title'] = 'Check Productos';
		$config['data']['message'] = 'Check Productos';
		$config['view'] = 'modulos/gestionGerencial/checkProducto/index';

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$elementos = $this->model->obtener_elementos($params);
		$motivos = $this->model->obtener_motivos($params);
		$config['data']['elementos'] = $elementos;
		$config['data']['motivos'] = $motivos;

		$tabs = getTabPermisos(['idMenuOpcion'=>$idMenu])->result_array();
		$config['data']['tabs'] = $tabs;
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

		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['distribuidoraSucursal_filtro'] = !empty($data->{'distribuidoraSucursal_filtro'}) ?$data->{'distribuidoraSucursal_filtro'} : '';
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['tipoUsuario_filtro'] = $data->{'tipoUsuario_filtro'};
		$input['usuario_filtro'] = !empty($data->{'usuario_filtro'}) ? (is_array($data->{'usuario_filtro'}) ? implode(",",$data->{'usuario_filtro'}) : $data->{'usuario_filtro'}) : '' ;
		
		$input['flagPropios'] = !empty($data->{'ck-propios'}) ? true : '';
		$input['flagCompetencia'] = !empty($data->{'ck-competencia'}) ? true : '';

		$rs_visitas = $this->model->obtener_visitas($input);



		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;

			$rs_det=$this->model->obtener_detalle_checklist($input);
			foreach($rs_det as $det){
				$array['categorias'][$det['idCategoria']]=$det['categoria'];
				$array['elementos'][$det['idCategoria']][$det['idProducto']]['nombre']=$det['elemento'];
				$array['elementos'][$det['idCategoria']][$det['idProducto']]['flagCompetencia']=$det['flagCompetencia'];
				$array['detalle'][$det['idVisita']][$det['idProducto']] = $det;
			}

			$rs_lista=$this->model->obtener_lista_elementos_visibilidad($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idProducto']]='1';
			}

			$segmentacion = getSegmentacion($input);
			
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/checkProducto/detalle_checklist",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentChecklistProductos']['datatable'] = 'tb-checkproductos';
		$result['data']['views']['idContentChecklistProductos']['html'] = $html;
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
		$result['data'] = $this->load->view("modulos/gestionGerencial/checkProducto/verFotos", $array, true);

		echo json_encode($result);
    }

	public function filtrar_quiebres()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		//Obligandolo
		if(empty($data->{'grupoCanal_filtro'})){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe seleccionar un grupo canal'));
			goto respuesta;
		}

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['flagPropios'] = !empty($data->{'ck-propios'}) ? true : '';
		$input['flagCompetencia'] = !empty($data->{'ck-competencia'}) ? true : '';

		if(empty($data->{'ch-quiebre-inactivo'}) || empty($data->{'ch-quiebre-activo'}) ){

			$input['quiebre'] = empty($data->{'ch-quiebre-activo'}) ? 2 : 1;
			// $input['quiebre'] = empty($data->{'ch-quiebre'}) ? 0 : 1;
			
		}
		if(empty($data->{'ch-quiebre-inactivo'}) && empty($data->{'ch-quiebre-activo'}) ){
			$input['quiebre'] = 3;
		}

		$motivo = (!empty($data->{'motivo'}) ? $data->{'motivo'} : []);
		$motivo = is_array($motivo) ? $motivo : [$motivo];

		$input['motivo'] = implode(",", $motivo);
		
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$rs_quiebres = $this->model->obtener_quiebre($input);

		$html = '';
		$array['quiebres'] = $rs_quiebres;

		if(!empty($rs_quiebres)){
			$array = [];
			$array['quiebres'] = $rs_quiebres;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;

			$html = $this->load->view("modulos/gestionGerencial/checkProducto/detalle_quiebres",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentQuiebres']['datatable'] = 'tb-quiebres';
		$result['data']['views']['idContentQuiebres']['html'] = $html;
		$result['data']['configTable'] =  [];
	
		respuesta:
		echo json_encode($result);
	}
	public function filtrar_fifo()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		//Obligandolo
		if(empty($data->{'grupoCanal_filtro'})){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe seleccionar un grupo canal'));
			goto respuesta;
		}

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		// $input['quiebre'] = empty($data->{'ch-quiebre'}) ? 0 : 1;

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$input['flagPropios'] = !empty($data->{'ck-propios'}) ? true : '';
		$input['flagCompetencia'] = !empty($data->{'ck-competencia'}) ? true : '';
		
		if(empty($data->{'chk-fifo-vencido'}) || empty($data->{'chk-fifo-porVencer'}) ){
			$input['fifo'] = empty($data->{'chk-fifo-porVencer'}) ? 2 : 1;
		}
		if(empty($data->{'chk-fifo-vencido'}) && empty($data->{'chk-fifo-porVencer'}) ){
			$input['fifo'] = 3;
		}

		$rs_quiebres = $this->model->obtener_fifo($input);

		$html = '';
		$array['quiebres'] = $rs_quiebres;

		if(!empty($rs_quiebres)){
			$array = [];
			$array['quiebres'] = $rs_quiebres;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;

			$html = $this->load->view("modulos/gestionGerencial/checkProducto/detalle_fifo",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentFifo']['datatable'] = 'tb-fifo';
		$result['data']['views']['idContentFifo']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					"targets" => []
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];
	
		respuesta:
		echo json_encode($result);
	}

	public function quiebres_pdf()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$clientes = !empty($data->frmQuiebres->clientes) && is_array($data->frmQuiebres->clientes)  ? implode(',',$data->frmQuiebres->clientes) : '' ;
		if(empty($clientes)){
			$clientes = !empty($data->frmQuiebres->clientes) && !is_array($data->frmQuiebres->clientes) ? $data->frmQuiebres->clientes : '' ;
		}
		/*====Filtrado=====*/
		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		$input['flagPropios'] = !empty($data->{'ck-propios'}) ? true : '';
		$input['flagCompetencia'] = !empty($data->{'ck-competencia'}) ? true : '';

		$input['quiebre'] =  1;
		
		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		$input['clientes'] = $clientes;

		$motivo = (!empty($data->{'motivo'}) ? $data->{'motivo'} : []);
		$motivo = is_array($motivo) ? $motivo : [$motivo];

		$input['motivo'] = implode(",", $motivo);

		$rs_quiebres = $this->model->obtener_quiebre($input);
		$segmentacion = getSegmentacion($input);
		$dataPdf = []; 
		$topClientes= $data->frmQuiebres->topClientes;

		if(!empty($rs_quiebres)){
			foreach ($rs_quiebres as $k => $v) {

				if(empty($v['foto'])){
					continue;
				}
				if(empty($clientes)){
					if(count($dataPdf) >= $topClientes){
						continue;
					}
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
				$dataPdf[$v['idVisita']]['productos'][$v['idProducto']]['producto'] = !empty($v['producto']) ? $v['producto'] : '-' ;
				$dataPdf[$v['idVisita']]['productos'][$v['idProducto']]['foto'] = !empty($v['foto']) ? $v['foto'] : ''  ;
				$dataPdf[$v['idVisita']]['productos'][$v['idProducto']]['carpetaFoto'] = !empty($v['carpetaFoto']) ? $v['carpetaFoto'] : '-' ;
				$dataPdf[$v['idVisita']]['productos'][$v['idProducto']]['motivo'] = !empty($v['motivo']) ? $v['motivo'] : '-' ;

				
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
			  'content' => 'REPORTE FOTOGRÁFICO DE QUIEBRES',
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

		if( count($rs_quiebres) > 400 ){
			//
			$html='<br/><br/><br/><b>Se encontraron más de 400 registros. Excedio el maximo permitido.</b>';
			//
			$mpdf->SetHTMLHeader('');
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($rs_quiebres) >= 1 && count($rs_quiebres) < 400 ){
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
				$mpdf->WriteHTML($this->load->view("modulos/gestionGerencial/checkProducto/pdf_quiebres/header_cliente",$v,true));
				$mpdf->WriteHTML($this->load->view("modulos/gestionGerencial/checkProducto/pdf_quiebres/body_productos",$v,true));
				
				
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
		$mpdf->Output("Quiebres".$fechas[0].'-'.$fechas[1].".pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}

	public function getFormQuiebresPdf(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$array = array();
		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'Generar reporte fotográfico de quiebres';
		$result['data'] = $this->load->view("modulos/gestionGerencial/checkProducto/frmQuiebresPdf", $array, true);

		echo json_encode($result);
	}

	public function obtenerResumen(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];

		$input['proyecto_filtro'] = $data->{'proyecto_filtro'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
		$input['canal_filtro'] = $data->{'canal_filtro'};
		// $input['quiebre'] = empty($data->{'ch-quiebre'}) ? 0 : 1;

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};
		
		//Datos Generales
		$array = array();
		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'Generar reporte fotográfico de quiebres';
		$html  = $this->load->view("modulos/gestionGerencial/checkProducto/frmQuiebresPdf", $array, true);
		$result['data']['views']['contentResumenCheckProductos']['html'] = $html;
		echo json_encode($result);
	}
	public function getDetalladoResumen(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $data->{'txt-fechas'};
		$input['tipoResumen'] =  $data->{'tipoResumen'};
		$array = array();
		if(	$input['tipoResumen']  == 2){
			$array['tiendasVisitadas'] = $this->model->getTiendasVisitadasAcumulado($input); 
			$resumen = $this->model->getDataResumenAcumulado($input);

		} else{
			$resumen = $this->model->getDataResumen($input);
			$array['tiendasVisitadas'] = $this->model->getTiendasVisitadas($input); 
		}
		$array['tipoReporte'] = $data->{'tipoReporte'};
		foreach ($resumen as $k => $v) {

			//Rowspan
			$array['rowspan']['categorias'][$v['idCategoria']] = $v['cantidadProductosCategoria'];
			$array['rowspan']['marcas'][$v['idCategoria']][$v['idMarca']] = $v['cantidadProductos'];
			// 
			$array['productos'][$v['idProducto']]['idCategoria'] = $v['idCategoria'];
			$array['productos'][$v['idProducto']]['categoria'] = $v['categoria'];
			$array['productos'][$v['idProducto']]['idMarca'] = $v['idMarca'];
			$array['productos'][$v['idProducto']]['marca'] = $v['marca'];
			$array['productos'][$v['idProducto']]['producto'] = $v['producto'];
			$array['productos'][$v['idProducto']]['idBanner'] = $v['idBanner'];
			$array['productos'][$v['idProducto']]['banner'] = $v['cadena'].'-'.$v['banner'];
			
			$array['productos'][$v['idProducto']]['idTipoReporte'] = $v['idTipoReporte'];
			$array['productos'][$v['idProducto']]['fecha'] = $v['fecha'];

			$array['productos'][$v['idProducto']]['totalPresencia'] = $v['totalPresencia'];
			$array['productos'][$v['idProducto']]['totalQuiebres'] = $v['totalQuiebres'];
			$array['productos'][$v['idProducto']]['totalPrecio'] = !empty($v['totalPrecio']) ? moneda($v['totalPrecio']) : '-';

			$array['banners'][$v['idBanner']]['nombre'] = ($v['cadena'] == $v['banner']) ? strtoupper($v['banner']) : strtoupper($v['cadena']).'-'.strtoupper($v['banner']);

			$array['productos'][$v['idProducto']]['precio'][$v['idBanner']] = !empty($v['totalPrecioBanner']) ? moneda($v['totalPrecioBanner']) : '-' ;
			$array['productos'][$v['idProducto']]['presencia'][$v['idBanner']] = !empty($v['totalPresenciaBanner']) ? $v['totalPresenciaBanner'] : '-' ;
			$array['productos'][$v['idProducto']]['quiebres'][$v['idBanner']] = !empty($v['totalQuiebresBanner']) ? $v['totalQuiebresBanner'] : '-' ;

		}

		//Datos Generales
		$array['fecIni'] = $input['fecIni'];

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'Generar reporte fotográfico de quiebres';
		if(!empty($array['banners'])){
			$result['result'] = 1;
			$html  = $this->load->view("modulos/gestionGerencial/checkProducto/detalladoResumenCheckProductosNew", $array, true);
		}else{
			$result['result'] = 0;
			$html  = getMensajeGestion('noRegistros');
		}
		$result['data']['html'] = $html;
		$result['data']['tiendasVisitadas'] = $array['tiendasVisitadas']['tiendasVisitadas'];
		echo json_encode($result);
	}
	public function getCadenasPresencia(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $data->{'txt-fechas'};
		$input['tipoResumen'] =  $data->{'tipoResumen'};

		if(	$input['tipoResumen']  == 2){
			$clientesCadena = $this->model->getTopClientesCadenaAcumulado($input);

		} else{

			$clientesCadena = $this->model->getTopClientesCadena($input);

		}
		$array = array();
		foreach ($clientesCadena as $k => $v) {
			$array['data'][$v['cadena']]['id'] = $v['idCadena'];
			$array['data'][$v['cadena']]['value'] = $v['clientesCadena'];
			$array['data'][$v['cadena']]['color'] = !empty($v['color'])?$v['color'] : '#070a26';
		}

		//Result
		$result['result'] = 1;
		if(!empty($clientesCadena )){
			$html  = $this->load->view("modulos/gestionGerencial/checkProducto/viewTopCadenasPresencia", $array, true);
		}else{
			$html  = getMensajeGestion('noRegistros');
		}
		
		$result['data']['html'] = $html;
		echo json_encode($result);
	}
	public function getProductosPresencia(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input = array();
		$input['fecIni'] = $data->{'txt-fechas'};
		$input['tipoResumen'] =  $data->{'tipoResumen'};
		
		$array = array();
		if($input['tipoResumen'] == 2){
			$productosMasPresencia = $this->model->getTopProductosMasPresenciaAcumulado($input);
		}else{
			$productosMasPresencia = $this->model->getTopProductosMasPresencia($input);
		}

		foreach ($productosMasPresencia as $k => $v) {
			$array['productosMasPresencia'][$v['producto']]['id'] = $v['idProducto'];
			$array['productosMasPresencia'][$v['producto']]['value'] = $v['totalPresencia'];
			$array['productosMasPresencia'][$v['producto']]['color'] = '#FFB612';
		}
		if($input['tipoResumen'] == 2){
			$productosMenosPresencia = $this->model->getTopProductosMenosPresenciaAcumulado($input);
		}else{
			$productosMenosPresencia = $this->model->getTopProductosMenosPresencia($input);
		}
		foreach ($productosMenosPresencia as $k => $v) {

			$array['productosMenosPresencia'][$v['producto']]['id'] = $v['idProducto'];
			$array['productosMenosPresencia'][$v['producto']]['value'] = $v['totalQuiebres'];
			$array['productosMenosPresencia'][$v['producto']]['color'] = '#DCDCDD';
		}

		//Result
		$result['result'] = 1;
		if(!empty($productosMasPresencia)){
			$htmlMasPresencia  = $this->load->view("modulos/gestionGerencial/checkProducto/viewTopProductosMasPresencia", $array, true);
		}else{
			$htmlMasPresencia  = getMensajeGestion('noRegistros');
		}

		if(!empty($productosMenosPresencia)){
			$htmlMenosPresencia  = $this->load->view("modulos/gestionGerencial/checkProducto/viewTopProductosMenosPresencia", $array, true);
		}else{
			$htmlMenosPresencia  = getMensajeGestion('noRegistros');

		}
		
		$result['data']['htmlmasPresencia'] = $htmlMasPresencia;
		$result['data']['htmlmenosPresencia'] = $htmlMenosPresencia;
		echo json_encode($result);
	}

	public function getDetalleResumen()
	{
		$result = $this->result;
		$data = json_decode($this->input->post('data'),true);
		$input['idTipoResumen'] = !empty($data['idTipoResumen']) ?  $data['idTipoResumen'] : '' ;
		$input['idProducto'] = !empty($data['idProducto']) ?  $data['idProducto'] : '' ;
		$input['tipo'] = !empty($data['tipo']) ?  $data['tipo'] : '' ;
		$input['banner'] = !empty($data['idBanner']) ?  $data['idBanner'] : '' ;
		$input['fecha'] = !empty($data['fecha']) ?  $data['fecha'] : '' ;

		$array['data'] = $this->model->obtener_clientes_resumen($input);

		$gruposCanal = [];
		foreach ($array['data'] as $k => $v) {
			$gruposCanal[$v['idGrupoCanal']] = $v['grupoCanal'];
		}
		$array['segmentacion']['headers'] = [];
		foreach ($gruposCanal  as $idGrupoCanal => $grupoCanal) {
			if(in_array($grupoCanal, GC_TRADICIONALES)) {
				array_push($array['segmentacion']['headers'],
				['header' => 'Distribuidora', 'columna' => 'distribuidora', 'align' => 'left'],
				['header' => 'Sucursal', 'columna' => 'ciudadDistribuidoraSuc', 'align' => 'left'],
				['header' => 'Zona', 'columna' => 'zona', 'align' => 'left']);
			}else if(in_array($grupoCanal, GC_MAYORISTAS)){
				array_push($array['segmentacion']['headers'],
				['header' => 'Plaza', 'columna' => 'plaza', 'align' => 'left']
				);
			}else if(in_array($grupoCanal, GC_MODERNOS)){
				array_push($array['segmentacion']['headers'],
				['header' => 'Cadena', 'columna' => 'cadena', 'align' => 'left'],
				['header' => 'Banner', 'columna' => 'banner', 'align' => 'left']
				);
			}else{
			}
		}
		$result['data']['title']  = 'Tiendas';
		$result['data']['html']  = $this->load->view("modulos/gestionGerencial/checkProducto/viewDetalleResumen", $array, true);

		echo json_encode($result);
	}
	public function permisos_usuarios_multi($input = []){
		$array['usuarios'] = [];

		foreach ($input['tipoSegmentacion'] as $k => $tipo) {
			$tipoSegmentacion = $tipo;
			if($tipoSegmentacion == 'tradicional')
			{
				$permisos_usuarios = $this->model->obtenerUsuariosPermisosDistribuidoraSucursal($input);
				foreach ($permisos_usuarios as $k => $v) {
					$array['usuarios']['tradicional'][$v['idTipoUsuario']][$v['idDistribuidoraSucursal']] = $v['nombreUsuario'];
				}
			} 
			if($tipoSegmentacion == 'mayorista')
			{
				$permisos_usuarios = $this->model->obtenerUsuariosPermisosPlaza($input);
				foreach ($permisos_usuarios as $k => $v) {
					$array['usuarios']['mayorista'][$v['idTipoUsuario']][$v['idPlaza']] = $v['nombreUsuario'];
				}
			} 
			if($tipoSegmentacion == 'moderno')
			{
				$permisos_usuarios = $this->model->obtenerUsuariosPermisosBanner($input);
				foreach ($permisos_usuarios as $k => $v) {
					$array['usuarios']['moderno'][$v['idTipoUsuario']][$v['idBanner']] = $v['nombreUsuario'];
				}
			}
		}

		return $array['usuarios'] ;
	}

}
?>