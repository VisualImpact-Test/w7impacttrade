<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Encuesta extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_encuesta', 'm_encuesta');
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config['nav']['menu_active'] = '5';
		$config['css']['style'] = [];
		$config['js']['script'] = [
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/core/anyChartCustom',
			'assets/custom/js/encuesta'
		];
		$config['data']['icon'] = 'fal fa-file-alt';
		$config['data']['title'] = 'Encuesta';
		$config['data']['message'] = 'Aquí encontrará datos de las encuestas.';
		$config['view'] = 'modulos/encuesta/index';
		$config['data']['tiposPregunta'] = $this->m_encuesta->getTiposDePregunta()->result_array();


		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$config['data']['encuestasActivas'] = $this->m_encuesta->getEncuestasActivas($params)->result_array();


		$this->view($config);
	}

	protected function getDataEncuestas($post)
	{
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaEncuesta' ];
		$dataParaVista['visitas'] = $visitas = $this->m_encuesta->query_visitaEncuesta($post)->result_array();

		if (count($visitas) > 0) {
			$lista = $this->m_encuesta->list_encuesta($post)->result_array();
			$encuesta = $this->m_encuesta->query_visitaEncuestaDet($post)->result_array();
			$array_resultados = array();
			foreach ($visitas as $row) {
				$array_resultados[$row['idCliente']]['departamento'] = $row['ciudad'];
				$array_resultados[$row['idCliente']]['provincia'] = $row['provincia'];
				$array_resultados[$row['idCliente']]['distrito'] = $row['distrito'];
				$array_resultados[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
				$array_resultados[$row['idCliente']]['direccion'] = $row['direccion'];
				$array_resultados[$row['idCliente']]['codCliente'] = $row['codCliente'];
			}

			foreach ($lista as $fila) {
				$dataParaVista['listaEncuesta'][$fila['idEncuesta']]['nombre'] = $fila['encuesta'];
				$dataParaVista['listaEncuesta'][$fila['idEncuesta']]['foto'] = $fila['foto'];
				$dataParaVista['listaPregunta'][$fila['idEncuesta']][$fila['idPregunta']]['nombre'] = $fila['pregunta'];
			}

			$array_grafico = array();
			foreach ($encuesta as $fila) {
				$dataParaVista['visitaFoto'][$fila['idVisita']][$fila['idEncuesta']] = $fila['imgRef'];
				$dataParaVista['visitaEncuesta'][$fila['idVisita']][$fila['idPregunta']][] = $fila['respuesta'];
				if (isset($array_resultados[$fila['idCliente']])) {
					if (!empty($fila['puntaje'])) $array_resultados[$fila['idCliente']]['puntaje'][$fila['idPregunta']] = floatval($fila['puntaje']);
				}

				if ($fila['idTipoPregunta'] != 1) {
					$array_grafico['encuestas'][$fila['idEncuesta']]['nombre'] = $fila['encuesta'];
					$array_grafico['preguntas'][$fila['idEncuesta']][$fila['idPregunta']]['nombre'] = $fila['pregunta'];
					$array_grafico['alternativas'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativa']]['nombre'] = $fila['respuesta'];
					$array_grafico['alternativas'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativa']]['cantidad'] = isset($array_grafico['alternativas'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativa']]['cantidad']) ? $array_grafico['alternativas'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativa']]['cantidad'] + 1 : 1;

					$array_grafico['respondientes'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idCliente']] = $fila['idCliente'];
				}
			}

			$resultados['resultados'] = $array_resultados;
		}

		return $dataParaVista;
	}

	public function getTablaEncuestas()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Encuestas';
		$post = json_decode($this->input->post('data'), true);

		if(isset( $post['idEncuesta'])){
			$encuestas = $post['idEncuesta'];
			if(is_array($encuestas)){
				$post['idEncuesta'] = implode(",",$encuestas);
			}else{
				$post['idEncuesta'] = $encuestas;
			}
		}

		$params = [];
		$params['idCuenta'] = empty($post['cuenta_filtro']) ? "" : $post['cuenta_filtro'];
		$params['idProyecto'] = empty($post['proyecto_filtro']) ? "" : $post['proyecto_filtro'];
		$params['idGrupoCanal'] = empty($post['grupo_filtro']) ? "" : $post['grupo_filtro'];
		$params['idCanal'] = empty($post['canal_filtro']) ? "" : $post['canal_filtro'];
		$params['idEncuesta'] = empty($post['idEncuesta']) ? "" : $post['idEncuesta'];
		$params['tipoPregunta'] = empty($post['tipoPregunta']) ? "" : $post['tipoPregunta'];
		$params['txt-fechas'] = empty($post['txt-fechas']) ? "" : $post['txt-fechas'];

		$params['distribuidora_filtro'] = empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'];
		$params['zona_filtro'] = empty($post['zona_filtro']) ? '' : $post['zona_filtro'];
		$params['plaza_filtro'] = empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'];
		$params['cadena_filtro'] = empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'];
		$params['banner_filtro'] = empty($post['banner_filtro']) ? '' : $post['banner_filtro'];

		$dataParaVista = $this->getDataEncuestas($params);

		$result['result'] = 1;
		if (count($dataParaVista['visitas']) < 1 OR empty($dataParaVista['listaEncuesta'])) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $params['idGrupoCanal'] ]);
			$dataParaVista['segmentacion'] = $segmentacion;
			$result['data']['html'] = $this->load->view("modulos/Encuesta/tablaDetalladoEncuesta", $dataParaVista, true);
			$result['data']['configTable'] = [];
		}

		echo json_encode($result);
	}

	public function getVistaResumen()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Encuestas';
		$post = json_decode($this->input->post('data'), true);

		if(isset( $post['idEncuesta'])){
			$encuestas = $post['idEncuesta'];
			if(is_array($encuestas)){
				$post['idEncuesta'] = implode(",",$encuestas);
			}else{
				$post['idEncuesta'] = $encuestas;
			}
		}

		$params = [];
		$params['idCuenta'] = empty($post['cuenta_filtro']) ? "" : $post['cuenta_filtro'];
		$params['idProyecto'] = empty($post['proyecto_filtro']) ? "" : $post['proyecto_filtro'];
		$params['idGrupoCanal'] = empty($post['grupo_filtro']) ? "" : $post['grupo_filtro'];
		$params['idCanal'] = empty($post['canal_filtro']) ? "" : $post['canal_filtro'];
		$params['idEncuesta'] = empty($post['idEncuesta']) ? "" : $post['idEncuesta'];
		$params['tipoPregunta'] = empty($post['tipoPregunta']) ? "" : $post['tipoPregunta'];
		$params['txt-fechas'] = empty($post['txt-fechas']) ? "" : $post['txt-fechas'];
		$params['idEncuesta'] = empty($post['idEncuesta']) ? "" : $post['idEncuesta'];

		$dataParaVista = $this->getDataEncuestas($params);

		$graficosPieAC = [
			0 => [
				"title" => "¿El cliente cuenta con film o plástico que cubra su puesto?",
				"tooltipHtml" => "'<span>Respondieron: ' + value.data[this.index]['value'] + '</span><br /><span>Total: ' + value.data[this.index]['total'] + '</span>'",
				"data" => [
					[
						"x" => "SÍ",
						"value" => "21",
						"total" => "40"
					],
					[
						"x" => "NO",
						"value" => "19",
						"total" => "40"
					],
				]
			],
			1 => [
				"title" => "¿Se ha retirado elementos del POS?",
				"tooltipHtml" => "'<span>Respondieron: ' + value.data[this.index]['value'] + '</span><br /><span>Total: ' + value.data[this.index]['total'] + '</span>'",
				"data" => [
					[
						"x" => "SÍ",
						"value" => "11",
						"total" => "35"
					],
					[
						"x" => "NO",
						"value" => "24",
						"total" => "35"
					],
				]
			],
		];

		$graficosColumnAC = [
			0 => [
				"title" => "Indicar cuales se ha retirado (lista multicheck)",
				"tooltipHtml" => "'<span>Porcentaje: ' + value.data[this.index]['porcentaje'] + '%</span><br /><span>Respondieron: ' + value.data[this.index]['respondidos'] + '</span>'",
				"data" => [
					[
						"x" => "OTA HAIR CARE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "MINI OTA HAIR CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHOS DE POLLO DE 1 A 4",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "EXTENSIÓN OTA",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "BIG OTA GILLETTE (1.2)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "OTA GILLETTE (0.9)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "MINI OTA GILLETTE (0.5)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA GILLETTE",
						"value" => "14",
						"porcentaje" => "14",
						"respondidos" => "3"
					],
					[
						"x" => "OTA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "VENTANA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "GANCHOS OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA CORPORATIVO",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "HANGER X6",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA DOWNY",
						"value" => "24",
						"porcentaje" => "24",
						"respondidos" => "5"
					],
					[
						"x" => "ANAQUEL AYUDÍN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "CAJA AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHERA AYUDIN",
						"value" => "19",
						"porcentaje" => "19",
						"respondidos" => "4"
					],
					[
						"x" => "GANCHERA DOWNY",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA PAMPERS",
						"value" => "10",
						"porcentaje" => "10",
						"respondidos" => "2"
					],
					[
						"x" => "ANQUEL PAMPERS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA PREMIUM CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA CONFORT SEC",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "ANAQUEL AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA HAIR CARE + OLD SPICE + ORAL B",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA CUIDADO DEL HOGAR",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
				]
			],
			1 => [
				"title" => "Indicar cuales se ha retirado (lista multicheck)",
				"tooltipHtml" => "'<span>Porcentaje: ' + value.data[this.index]['porcentaje'] + '%</span><br /><span>Respondieron: ' + value.data[this.index]['respondidos'] + '</span>'",
				"data" => [
					[
						"x" => "OTA HAIR CARE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "MINI OTA HAIR CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHOS DE POLLO DE 1 A 4",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "EXTENSIÓN OTA",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "BIG OTA GILLETTE (1.2)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "OTA GILLETTE (0.9)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "MINI OTA GILLETTE (0.5)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA GILLETTE",
						"value" => "14",
						"porcentaje" => "14",
						"respondidos" => "3"
					],
					[
						"x" => "OTA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "VENTANA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "GANCHOS OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA CORPORATIVO",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "HANGER X6",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA DOWNY",
						"value" => "24",
						"porcentaje" => "24",
						"respondidos" => "5"
					],
					[
						"x" => "ANAQUEL AYUDÍN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "CAJA AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHERA AYUDIN",
						"value" => "19",
						"porcentaje" => "19",
						"respondidos" => "4"
					],
					[
						"x" => "GANCHERA DOWNY",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA PAMPERS",
						"value" => "10",
						"porcentaje" => "10",
						"respondidos" => "2"
					],
					[
						"x" => "ANQUEL PAMPERS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA PREMIUM CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA CONFORT SEC",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "ANAQUEL AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA HAIR CARE + OLD SPICE + ORAL B",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA CUIDADO DEL HOGAR",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
				]
			],
		];

		$graficosBarAC = [
			0 => [
				"title" => "Indicar cuales se ha retirado (lista multicheck)",
				"tooltipHtml" => "'<span>Porcentaje: ' + value.data[this.index]['porcentaje'] + '%</span><br /><span>Respondieron: ' + value.data[this.index]['respondidos'] + '</span>'",
				"data" => [
					[
						"x" => "OTA HAIR CARE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "MINI OTA HAIR CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHOS DE POLLO DE 1 A 4",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "EXTENSIÓN OTA",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "BIG OTA GILLETTE (1.2)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "OTA GILLETTE (0.9)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "MINI OTA GILLETTE (0.5)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA GILLETTE",
						"value" => "14",
						"porcentaje" => "14",
						"respondidos" => "3"
					],
					[
						"x" => "OTA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "VENTANA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "GANCHOS OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA CORPORATIVO",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "HANGER X6",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA DOWNY",
						"value" => "24",
						"porcentaje" => "24",
						"respondidos" => "5"
					],
					[
						"x" => "ANAQUEL AYUDÍN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "CAJA AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHERA AYUDIN",
						"value" => "19",
						"porcentaje" => "19",
						"respondidos" => "4"
					],
					[
						"x" => "GANCHERA DOWNY",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA PAMPERS",
						"value" => "10",
						"porcentaje" => "10",
						"respondidos" => "2"
					],
					[
						"x" => "ANQUEL PAMPERS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA PREMIUM CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA CONFORT SEC",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "ANAQUEL AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA HAIR CARE + OLD SPICE + ORAL B",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA CUIDADO DEL HOGAR",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
				]
			],
			1 => [
				"title" => "Indicar cuales se ha retirado (lista multicheck)",
				"tooltipHtml" => "'<span>Porcentaje: ' + value.data[this.index]['porcentaje'] + '%</span><br /><span>Respondieron: ' + value.data[this.index]['respondidos'] + '</span>'",
				"data" => [
					[
						"x" => "OTA HAIR CARE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "MINI OTA HAIR CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHOS DE POLLO DE 1 A 4",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "EXTENSIÓN OTA",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "BIG OTA GILLETTE (1.2)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "OTA GILLETTE (0.9)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "MINI OTA GILLETTE (0.5)",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA GILLETTE",
						"value" => "14",
						"porcentaje" => "14",
						"respondidos" => "3"
					],
					[
						"x" => "OTA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "VENTANA ORAL B",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "GANCHOS OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL OLD SPICE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA CORPORATIVO",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "HANGER X6",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ARAÑA DOWNY",
						"value" => "24",
						"porcentaje" => "24",
						"respondidos" => "5"
					],
					[
						"x" => "ANAQUEL AYUDÍN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "CAJA AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "GANCHERA AYUDIN",
						"value" => "19",
						"porcentaje" => "19",
						"respondidos" => "4"
					],
					[
						"x" => "GANCHERA DOWNY",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "OTA PAMPERS",
						"value" => "10",
						"porcentaje" => "10",
						"respondidos" => "2"
					],
					[
						"x" => "ANQUEL PAMPERS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA PREMIUM CARE",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "RUMA CONFORT SEC",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VENTANA ALWAYS",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "ANAQUEL DETERGENTE",
						"value" => "5",
						"porcentaje" => "5",
						"respondidos" => "1"
					],
					[
						"x" => "ANAQUEL AYUDIN",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA HAIR CARE + OLD SPICE + ORAL B",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
					[
						"x" => "VITRINA CUIDADO DEL HOGAR",
						"value" => "0",
						"porcentaje" => "0",
						"respondidos" => "0"
					],
				]
			],
		];

		$result['result'] = 1;
		if (count($dataParaVista['visitas']) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
			$result['result'] =0;
		} else {
			$dataParaVista["graficosPieAC"] = $graficosPieAC;
			$dataParaVista["graficosColumnAC"] = $graficosColumnAC;
			$dataParaVista["graficosBarAC"] = $graficosBarAC;

			$result['data']['html'] = $this->load->view("modulos/Encuesta/resumen", $dataParaVista, true);
			$result['data']['graficosPieAC'] = $graficosPieAC;
			$result['data']['graficosColumnAC'] = $graficosColumnAC;
			$result['data']['graficosBarAC'] = $graficosBarAC;
		}

		echo json_encode($result);
	}
}
