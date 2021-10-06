<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Precios extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_precios', 'm_precios');
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];
		$idMenu = '42';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array();
		$config['js']['script'] = array(
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/custom/js/precios'
		);

		$config['data']['icon'] = 'fas fa-sack-dollar';
		$config['data']['title'] = 'Precios';
		$config['data']['message'] = 'Aquí encontrará precios.';
		$config['view'] = 'modulos/precios/index';

		$config['data']['tipoUsuario'] = $this->m_precios->getTiposDeUsuario()->result_array();
		$config['data']['marcas'] = $this->m_precios->getMarcas()->result_array();
		$config['data']['categorias'] = $this->m_precios->getCategorias()->result_array();

		$params['idUsuario'] = $this->session->userdata('idUsuario');
		$config['data']['productos'] = $this->m_precios->getProductos($params)->result_array();

		$config['data']['usuarios'] = $this->m_precios->getUsuarios($params)->result_array();

		$tabs = getTabPermisos(['idMenuOpcion'=>$idMenu])->result_array();
		$config['data']['tabs'] = $tabs;

		$config['data']['anios'] = $this->m_precios->getAnios()->result_array();
		$config['data']['nsemanas'] = $this->m_precios->getSemanas()->result_array();
		$config['data']['semanaActual'] = $this->m_precios->getSemanas()->row_array()['idSemana'];

		$config['data']['empresas'] = $this->m_precios->obtener_empresas_filtros();

		$this->view($config);
	}

	public function getProductosForSelect()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$post['idUsuario']=$this->session->userdata('idUsuario');
		$productos = $this->m_precios->getProductos($post)->result_array();

		$result['data']['productos'] = $productos;
		echo json_encode($result);
	}

	public function getMarcasForSelect()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$marcas = $this->m_precios->getMarcas($post)->result_array();

		$result['data']['marcas'] = $marcas;
		echo json_encode($result);
	}

	public function getVisitasPrecios()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Precios';
		$post = json_decode($this->input->post('data'), true);
		if (!empty($post["ch-competencia"]) && !is_array($post["ch-competencia"])) $post["ch-competencia"] = [$post["ch-competencia"]];

		$visitasPrecios = $this->m_precios->getVisitasPrecios($post)->result_array();
		$this->aSessTrack = $this->m_precios->aSessTrack;

		$result['result'] = 1;
		if (count($visitasPrecios) < 1) {
			$result['data']['html'] = getMensajeGestion("noRegistros");
		} else {
			$dataParaVista = [];
			$dataParaVista['visitasPrecios'] = $visitasPrecios;
			$segmentacion = getSegmentacion($post);
			$dataParaVista['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/Precios/tablaPrecios", $dataParaVista, true);

			$result['data']['views']['contentPrecios']['datatable'] = 'tablaVisitasPrecios';
			$result['data']['views']['contentPrecios']['html'] = $html;
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
		}

		echo json_encode($result);
	}

	protected function agruparVisitasPorCiudad($visitasPrecios)
	{
		$departamentos = [];
		foreach ($visitasPrecios as $key => $visita) {
			$departamentos[$visita["cod_departamento"]]["cod_departamento"] = $visita["cod_departamento"];
			$departamentos[$visita["cod_departamento"]]["departamento"] = $visita["departamento"];
			$departamentos[$visita["cod_departamento"]]["provincia"] = $visita["provincia"];
			$departamentos[$visita["cod_departamento"]]["distrito"] = $visita["distrito"];

			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["grupoCanal"] = $visita["grupoCanal"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["canal"] = $visita["canal"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["subCanal"] = $visita["subCanal"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["categoria"] = $visita["categoria"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["marca"] = $visita["marca"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["ean"] = $visita["ean"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["sku"] = $visita["producto"];
			if ($visita["precio"] != 0 && $visita["precio"] != null) $departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["precios"][] = (string) $visita["precio"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["clientes"][] = $visita["codCliente"];
			$departamentos[$visita["cod_departamento"]]["productos"][$visita["idProducto"]]["visitas"][] = $visita["idVisita"];
		}

		foreach ($departamentos as $keyDepartamento => $departamento) {
			foreach ($departamento["productos"] as $keyProducto => $producto) {

				$departamentos[$keyDepartamento]["productos"][$keyProducto]["totalClientes"] = count(array_unique($producto["clientes"]));
				$departamentos[$keyDepartamento]["productos"][$keyProducto]["totalVisitas"] = count(array_unique($producto["visitas"]));

				if (isset($producto["precios"])) {
					$precioPromedio = round(array_sum($producto["precios"]) / count($producto["precios"]), 2);
					$conteo = array_count_values($producto["precios"]);
					arsort($conteo);
					$valoresModas = array_values(array_filter(array_keys($conteo)));
					$modas[0] = isset($valoresModas[0]) ? $valoresModas[0] : null;
					$modas[1] = isset($valoresModas[1]) ? $valoresModas[1] : null;
					$modas[2] = isset($valoresModas[2]) ? $valoresModas[2] : null;
					$departamentos[$keyDepartamento]["productos"][$keyProducto]["precioPromedio"] = $precioPromedio;
					$departamentos[$keyDepartamento]["productos"][$keyProducto]["modas"] = $modas;
				}
				unset($departamentos[$keyDepartamento]["productos"][$keyProducto]["precios"]);
				unset($departamentos[$keyDepartamento]["productos"][$keyProducto]["clientes"]);
				unset($departamentos[$keyDepartamento]["productos"][$keyProducto]["visitas"]);
			}
		}

		$visitasPrecios = $departamentos;
		return $visitasPrecios;
	}

	public function agruparVisitasPorZona($visitasPrecios)
	{
		return $visitasPrecios;
	}

	public function getReporteFinanzas()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Precios';
		$post = json_decode($this->input->post('data'), true);

		$visitasPrecios = $this->m_precios->getVisitasPrecios($post)->result_array();
		
		$post["rd-agrupacion"] = 'ciudad';

		if ($post["rd-agrupacion"] == "zona") {
			$visitasPrecios = $this->agruparVisitasPorZona($visitasPrecios);
			$vista = "modulos/Precios/tablaPreciosReporteFinanzasPorZona";
		} elseif ($post["rd-agrupacion"] == "ciudad") {
			$visitasPrecios = $this->agruparVisitasPorCiudad($visitasPrecios);
			$vista = "modulos/Precios/tablaPreciosReporteFinanzasPorCiudad";
		}

		$result['result'] = 1;
		if (count($visitasPrecios) < 1) {
			$result['data']['html'] = getMensajeGestion("noRegistros");
		} else {
			$dataParaVista = [];
			$dataParaVista['visitasPrecios'] = $visitasPrecios;
			$html = $this->load->view($vista, $dataParaVista, true);

			$result['data']['views']['contentFinanzas']['datatable'] = 'tablaReporteFinanzas';
			$result['data']['views']['contentFinanzas']['html'] = $html;
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
		}

		echo json_encode($result);
	}

	public function exportarDetalladoExcel()
	{
		$this->aSessTrack[] = [ 'idAccion' => 9 ];

		$result = $this->result;
		$result['msg']['title'] = 'Precios';
		$post = json_decode($this->input->post('data'), true);

		$visitasPrecios = $this->m_precios->getVisitasPrecios($post)->result_array();

		// Cargar el autoload del composer cuando se necesiten una de las librerias alojadas en vendor.
		require APPPATH . '/vendor/autoload.php';
		$configPHPSpreadsheet["nombreArchivo"] = "Precios";
		$spreadsheet = $this->getDefaultPHPSpreadSheetForDownload($configPHPSpreadsheet);

		// Seleccionando una hoja en la que escribir.
		$sheet = $spreadsheet->getActiveSheet();

		if (count($visitasPrecios) < 1) {
			$sheet->setCellValue('A1', "La consulta no ha generado resultados");
		} else {
			// Modificando la hoja seleccionada
			$headers = ["#", "CIUDAD", "CANAL", "COD GTM", "GTM", "PLAZA", "DIRECCIÓN", "CATEGORÍA", "MARCA", "COD VISUAL", "SKU", "PRECIO"];
			$ubicacionHeader = 0;
			foreach (range('A', 'L') as $columna) {
				$sheet->setCellValue($columna . '1', $headers[$ubicacionHeader]);
				$ubicacionHeader++;
			}

			$ubicacionFila = 2;
			foreach ($visitasPrecios as $key => $visitaPrecio) {
				$sheet->setCellValue("A" . $ubicacionFila, $ubicacionFila - 1);
				$sheet->setCellValue("B" . $ubicacionFila, !empty($visitaPrecio["departamento"]) ? $visitaPrecio["departamento"] : '-');
				$sheet->setCellValue("C" . $ubicacionFila, !empty($visitaPrecio["canal"]) ? $visitaPrecio["canal"] : '-');
				$sheet->setCellValue("D" . $ubicacionFila, !empty($visitaPrecio["idEmpleado"]) ? $visitaPrecio["idEmpleado"] : '-');
				$sheet->setCellValue("E" . $ubicacionFila, $visitaPrecio["apePaterno"] . $visitaPrecio["apeMaterno"] . $visitaPrecio["nombres"]);
				$sheet->setCellValue("F" . $ubicacionFila, !empty($visitaPrecio["plaza"]) ? $visitaPrecio["plaza"] : '-');
				$sheet->setCellValue("G" . $ubicacionFila, !empty($visitaPrecio["direccion"]) ? $visitaPrecio["direccion"] : '-');
				$sheet->setCellValue("H" . $ubicacionFila, !empty($visitaPrecio["categoria"]) ? $visitaPrecio["categoria"] : '-');
				$sheet->setCellValue("I" . $ubicacionFila, !empty($visitaPrecio["marca"]) ? $visitaPrecio["marca"] : '-');
				$sheet->setCellValue("J" . $ubicacionFila, !empty($visitaPrecio["idProducto"]) ? $visitaPrecio["idProducto"] : '-');
				$sheet->setCellValue("K" . $ubicacionFila, !empty($visitaPrecio["producto"]) ? $visitaPrecio["producto"] : '-');
				$sheet->setCellValue("L" . $ubicacionFila, !empty($visitaPrecio["precio"]) ? $visitaPrecio["precio"] : '-');
				$ubicacionFila++;
			}
		}

		// Obteniendo objeto writer y enviando archivo excel para su descarga.
		$configPHPSpreadsheetWriter["spreadsheet"] = $spreadsheet;
		$writer = $this->getDefaultPHPSpreadSheetWriter($configPHPSpreadsheetWriter);
		$writer->save('php://output');
	}

	public function getDetalladoPrecios()
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

		$rs_quiebres = $this->m_precios->obtener_detalle_precios_new($input);

		$html = '';
		$array['quiebres'] = $rs_quiebres;

		if(!empty($rs_quiebres)){
			$array = [];
			$array['quiebres'] = $rs_quiebres;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;

			$html = $this->load->view("modulos/Precios/tablaDetalladoPrecios",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['contentDetalladoPrecios']['datatable'] = 'tb-precios';
		$result['data']['views']['contentDetalladoPrecios']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					"targets" => [2,3,4]
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];
	
		respuesta:
		echo json_encode($result);
	}
	public function getVariabilidadPrecios()
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
		if(empty($data->{'sl_semanas'})){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(array('type'=>2,'message'=>'Debe seleccionar una semana como mínimo'));
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
		
		$input['nanio'] = empty($data->{'sl_anio'}) ? '' : $data->{'sl_anio'};

		if(is_array($data->{'sl_semanas'})){
			$semanas = $data->{'sl_semanas'};
			$data->{'sl_semanas'} = implode(',',$data->{'sl_semanas'});
		}else{
			$semanas[0] = $data->{'sl_semanas'};
		}

		$input['nsemanas'] = empty($data->{'sl_semanas'}) ? '' : $data->{'sl_semanas'};

		$input['empresa_filtro'] = empty($data->{'empresa_filtro'}) ? '' : $data->{'empresa_filtro'};
		$input['categoria_filtro'] = empty($data->{'categoria_filtro'}) ? '' : $data->{'categoria_filtro'};

		$rs_precios = $this->m_precios->obtener_detalle_precios_variabilidad($input);

		$html = '';
		$array['precios'] = $rs_precios;

		if(!empty($rs_precios)){
			$array = [];
			$array['precios'] = $rs_precios;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			$precios = [];
			sort($semanas);
			$array['semanas'] =  $semanas;
			foreach ($rs_precios as $k => $v) {
				$precios['cadenas'][$v['idCadena']][$v['idProducto']] = $v;
				$precios['semana'][$v['semana']][$v['idProducto']]['promedio'] = $v['promedio_semana'];
			}
			$array['precios'] = $precios;
			$html = $this->load->view("modulos/Precios/tablaDetalladoPreciosVariabilidad",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['contentVariabilidadPrecios']['datatable'] = 'tb-precios-variabilidad';
		$result['data']['views']['contentVariabilidadPrecios']['html'] = $html;
		$result['data']['configTable'] =  [
			'columnDefs' =>
			[
				0 =>
				[
					"visible" => false,
					"targets" => [2,3,4,5,6]
				]
			],
			// 'dom' => '<"ui icon input"f>tip',
		];
	
		respuesta:
		echo json_encode($result);
	}
	
	public function cargarCategorias()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$categorias = $this->m_precios->obtener_categorias_filtros($post);

		$html = '';
		$html .= '<select class="form-control form-control-sm ui my_select2Full" name="categoria_filtro" id="categoria_filtro" patron="requerido">';
			$html .= htmlSelectOptionArray2(['query' => $categorias, 'id' => 'idCategoria', 'value' => 'categoria', 'title' => '-- Categoria --']);
		$html .= '</select>';

		$result['result'] = 1;
		$result['data']['htmlcategorias'] = $html;

		echo json_encode($result);
	}
}
