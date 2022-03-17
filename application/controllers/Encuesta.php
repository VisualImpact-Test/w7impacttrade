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

		$idMenu = '5';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = [
			'assets/custom/css/asistencia'
		];
		$config['js']['script'] = [
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/core/anyChartCustom',
			'assets/custom/js/encuesta'
		];

		$tabs = getTabPermisos(['idMenuOpcion'=>$idMenu])->result_array();

		$config['data']['icon'] = 'fal fa-file-alt';
		$config['data']['title'] = 'Encuesta';
		$config['data']['message'] = 'Aquí encontrará datos de las encuestas.';
		$config['data']['tabs'] = $tabs;
		$config['view'] = 'modulos/encuesta/index';
		$config['data']['tiposPregunta'] = $this->m_encuesta->getTiposDePregunta()->result_array();


		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$config['data']['encuestasActivas'] = $this->m_encuesta->getEncuestasActivas($params)->result_array();


		$this->view($config);
	}

	protected function getDataEncuestas($post)
	{
		
		ini_set('memory_limit', '2048M');
		
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuesta" ];
		$dataParaVista['visitas'] = $visitas = $this->m_encuesta->query_visitaEncuesta($post)->result_array();
		
		if (count($visitas) > 0) {
			$lista = $this->m_encuesta->list_encuesta($post)->result_array();
			$encuesta = $this->m_encuesta->query_visitaEncuestaDet($post);
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
				$dataParaVista['listaPregunta'][$fila['idEncuesta']][$fila['idPregunta']]['idPregunta'] = $fila['idPregunta'];
				$dataParaVista['listaPregunta'][$fila['idEncuesta']][$fila['idPregunta']]['idTipoPregunta'] = $fila['idTipoPregunta'];
				$dataParaVista['listaPregunta'][$fila['idEncuesta']][$fila['idPregunta']]['imagen'] = $fila['imagenPreg'];
				
				if(!empty($fila['idAlternativaOpcion'])){
					$dataParaVista['listaOpciones'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativaOpcion']]['idAlternativaOpcion'] = $fila['idAlternativaOpcion'];
					$dataParaVista['listaOpciones'][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativaOpcion']]['nombre'] = $fila['opcion'];

					$dataParaVista['listaOpciones'][$fila['idEncuesta']]['opciones'][$fila['idAlternativaOpcion']] = 1;
				}
			}

			$array_grafico = array();
			$dataParaVista['dataEncuestaVertical'] = $encuesta;
			foreach ($visitas as $k => $v) {

					$dataParaVista['dataVisitaVertical'][$v['idVisita']] = $v;
			}

			foreach ($encuesta as $fila) {
				$dataParaVista['visitaFoto'][$fila['idVisita']][$fila['idEncuesta']] = $fila['imgRef'];
				$dataParaVista['visitaFotoPreg'][$fila['idVisita']][$fila['idEncuesta']][$fila['idPregunta']] = $fila['imgPreg'];

				if(!empty($fila['imgRefSub'])){
				}
				// $dataParaVista['visitaFotoSub'][$fila['idVisita']][$fila['idEncuesta']][$fila['idPregunta']][$fila['idAlternativa']] = !empty($fila['imgRefSub']) ? 1 : 0;
				// $dataParaVista['visitaFotoSub'][$fila['idVisita']][$fila['idEncuesta']] = !empty($fila['imgRefSub']) ? 1 : 0;;
				$dataParaVista['idVisitaEncuesta'][$fila['idVisita']][$fila['idEncuesta']] = $fila['idVisitaEncuesta'];
				$dataParaVista['flagFotoMultiple'][$fila['idVisita']][$fila['idEncuesta']] = empty($fila['flagFotoMultiple']) ? 0 : 1;
				$dataParaVista['visitaEncuesta'][$fila['idVisita']][$fila['idPregunta']][] = $fila['respuesta'];
				$dataParaVista['visitaFotoSub'][$fila['idVisita']][$fila['idPregunta']][] = !empty($fila['imgRefSub']) ? 1 : 0;
				$dataParaVista['visitaEncuesta'][$fila['idVisita']]['opciones'][$fila['idPregunta']][$fila['idAlternativaOpcion']][] = $fila['respuesta'];
				 
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
	public function getTablaVertical($dataEncuesta,$segmentacion){
		$dataEncuestaVertical = $dataEncuesta['dataEncuestaVertical'];
		$dataVisitaVertical = $dataEncuesta['dataVisitaVertical'];
		$new_data = [];

		foreach ($dataEncuestaVertical as $k => $data) {
			if(empty($dataVisitaVertical[$data['idVisita']])) continue;
			$visita = $dataVisitaVertical[$data['idVisita']]; 

			$new_data[$k] = [
				($k + 1 ) ,
				!empty($visita['fecha']) ? $visita['fecha'] : ' - ',
				!empty($visita['tipoUsuario']) ? $visita['tipoUsuario'] : ' - ',
				!empty($visita['idUsuario']) ? $visita['idUsuario'] : ' - ',
				!empty($visita['usuario']) ? $visita['usuario'] : ' - ',
				!empty($visita['grupoCanal']) ? $visita['grupoCanal'] : ' - ',
				!empty($visita['canal']) ? $visita['canal'] : ' - ',
			];

			foreach ($segmentacion['headers'] as $k1 => $v) { 
				array_push($new_data[$k],
					!empty($visita[($v['columna'])]) ? "<p class='text-left'>{$visita[($v['columna'])]}</p>" : '-'
				);
			}

			$fotoEncuesta =  !empty($data['imgRef']) ? rutafotoModulo(['foto'=>$data['imgRef'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : '';
			$fotoPregunta =  !empty($data['imgPreg']) ? rutafotoModulo(['foto'=>$data['imgPreg'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : '';
			$fotoAlternativa =  !empty($data['imgPreg']) ? rutafotoModulo(['foto'=>$data['imgRefSub'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : '';

			array_push($new_data[$k],
				!empty($visita['idCliente']) ? $visita['idCliente'] : ' - ',
				!empty($visita['codCliente']) ? $visita['codCliente'] : ' - ',
				!empty($visita['codDist']) ? $visita['codDist'] : ' - ',
				!empty($visita['razonSocial']) ? $visita['razonSocial'] : ' - ',
				!empty($visita['subCanal']) ? $visita['subCanal'] : ' - ',
				!empty($visita['incidencia']) ? $visita['incidencia'] : ' - ',
				!empty($data['encuesta']) ? $data['encuesta'] : '-' . $fotoEncuesta,
				!empty($data['tipoPregunta']) ? $data['tipoPregunta'] : ' - ',
				!empty($data['pregunta']) ? $data['pregunta'] : '-'  .  $fotoPregunta,
				!empty($data['respuesta']) ? $data['respuesta'] : '-' .  $fotoAlternativa ,
				($data['idTipoPregunta'] == 4 && !empty($data['alternativaOpcion'])) ? $data['alternativaOpcion'] : '-'
			);

		}

		return $new_data;

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
		$params['subcanal'] = empty($post['subcanal_filtro']) ? "" : $post['subcanal_filtro'];
		$params['idCanal'] = empty($post['canal_filtro']) ? "" : $post['canal_filtro'];
		$params['idEncuesta'] = empty($post['idEncuesta']) ? "" : $post['idEncuesta'];
		$params['tipoPregunta'] = empty($post['tipoPregunta']) ? "" : $post['tipoPregunta'];
		$params['txt-fechas'] = empty($post['txt-fechas']) ? "" : $post['txt-fechas'];
	
		$params['distribuidora_filtro'] = empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'];
		$params['zona_filtro'] = empty($post['zona_filtro']) ? '' : $post['zona_filtro'];
		$params['plaza_filtro'] = empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'];
		$params['cadena_filtro'] = empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'];
		$params['banner_filtro'] = empty($post['banner_filtro']) ? '' : $post['banner_filtro'];

		$params['departamento_filtro'] = empty($post['departamento_filtro']) ? "" : $post['departamento_filtro'];
		$params['provincia_filtro'] = empty($post['provincia_filtro']) ? "" : $post['provincia_filtro'];
		$params['distrito_filtro'] = empty($post['distrito_filtro']) ? "" : $post['distrito_filtro'];

		$dataParaVista = $this->getDataEncuestas($params);

		$result['result'] = 1;
		if (count($dataParaVista['visitas']) < 1 OR empty($dataParaVista['listaEncuesta'])) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $params['idGrupoCanal'] ]);
			$dataParaVista['segmentacion'] = $segmentacion;
			

			
			$contador = 0;
			$new_data = [];

         $listaEncuesta = $dataParaVista['listaEncuesta'];
         $listaPregunta = $dataParaVista['listaPregunta'];
         $listaOpciones = !empty($dataParaVista['listaOpciones']) ? $dataParaVista['listaOpciones'] : [] ;
         $visitaFoto = $dataParaVista['visitaFoto'];
         $visitaFotoPreg = $dataParaVista['visitaFotoPreg'];
         $idVisitaEncuesta = $dataParaVista['idVisitaEncuesta'];
         $flagFotoMultiple = $dataParaVista['flagFotoMultiple'];
         $visitaEncuesta = $dataParaVista['visitaEncuesta'];
         $visitaFotoSub = $dataParaVista['visitaFotoSub'];

		if($post['chk-reporte'] == 'vertical') {

			$this->getTablaVertical($dataParaVista,$segmentacion);
			$result['data']['html'] = $this->load->view("modulos/Encuesta/tablaDetalladoEncuestaVertical", $dataParaVista, true);
			$result['data']['configTable'] =  [];
			echo json_encode($result);
			exit();
		}

		if($post['chk-reporte'] == 'horizontal') {
			$result['data']['html'] = $this->load->view("modulos/Encuesta/tablaDetalladoEncuesta", $dataParaVista, true);
		}

			foreach ($dataParaVista['visitas'] as $i => $visita) {

            $contador++;

				$new_data[$i] = [
					$contador,
					"<input name='check[]' id='check' class='check' type='checkbox' value='{$visita['idVisita']}' />",
					verificarEmpty($visita["fecha"], 3),
					verificarEmpty($visita["grupoCanal"], 3),
					verificarEmpty($visita["canal"], 3),
					verificarEmpty($visita["subCanal"], 3)
				];

				foreach ($segmentacion['headers'] as $k => $v) { 
					array_push($new_data[$i],
						!empty($visita[($v['columna'])]) ? "<p class='text-left'>{$visita[($v['columna'])]}</p>" : '-'
					);
			  	}
				
				  array_push($new_data[$i],
				  !empty($visita['idCliente']) ? "<p class='text-center'>{$visita['idCliente']}</p>" : '-', 
				  !empty($visita['codCliente']) ? "<p class='text-center'>{$visita['codCliente']}</p>" : '-', 
				  !empty($visita['codDist']) ? "<p class='text-center'>{$visita['codDist']}</p>" : '-', 
				  verificarEmpty($visita["razonSocial"], 3),
				  verificarEmpty($visita["tipoCliente"], 3),
				  verificarEmpty($visita["ciudad"], 3),
				  verificarEmpty($visita["provincia"], 3),
				  verificarEmpty($visita["distrito"], 3),
				  !empty($visita['idUsuario']) ? "<p class='text-center'>{$visita['idUsuario']}</p>" : '-', 
				  verificarEmpty($visita["tipoUsuario"], 3),
				  verificarEmpty($visita["usuario"], 3),
				  verificarEmpty($visita['incidencia'], 3),
				  !empty($visita['encuestado']) ? 'SÍ' : '-' 
				  );

				  foreach ($dataParaVista['listaEncuesta'] as $keyEncuesta => $encuesta) {
					  foreach ($dataParaVista['listaPregunta'][$keyEncuesta] as $keyPregunta => $pregunta) {
						  $respuesta = (isset($visitaEncuesta[$visita['idVisita']][$keyPregunta])) ? implode(", ", array_unique($visitaEncuesta[$visita['idVisita']][$keyPregunta])) : '-';

						  $tieneFotoAlternativa = false;
						  if(!empty($visitaFotoSub[$visita['idVisita']][$keyPregunta])){
							  foreach($visitaFotoSub[$visita['idVisita']][$keyPregunta] AS $k => $v){
								  if(!empty($v)){
									  $tieneFotoAlternativa = true;
								  }
							  }
						  }

                        if ($tieneFotoAlternativa == true) {
                           $fotoSub = '<a href="javascript:;" class="lk-alternativa-foto a-fa" data-foto="" data-modulo="encuestas" data-comentario="" data-idvisitaencuesta="' . $idVisitaEncuesta[$visita['idVisita']][$keyEncuesta] . '" data-idpregunta="' . $keyPregunta . '"><i class="fa fa-camera" ></i></a>';
                        } else {
                           $fotoSub = "-";
                        }

                        if (!empty($visitaFotoPreg[$visita['idVisita']][$keyEncuesta][$keyPregunta])) {
                           $fotoPreg = '<a href="javascript:;" class="lk-pregunta-foto a-fa"  data-modulo="encuestas" data-comentario="" data-idvisitaencuesta="' . $idVisitaEncuesta[$visita['idVisita']][$keyEncuesta] . '" data-idpregunta="' . $keyPregunta . '"><i class="fa fa-camera" ></i></a>';
                        } else {
                           $fotoPreg = "-";
                        }


                        array_push($new_data[$i],
                           $respuesta,
                           "<p class='text-center'>{$fotoSub}</p>"
                        );

                        if($pregunta['idTipoPregunta'] != 4 ){
                           array_push($new_data[$i],
                           "<p class='text-center'>{$fotoPreg}</p>"
                           );
                        }

                        if(empty($listaOpciones[$keyEncuesta][$keyPregunta])) continue;

                        foreach($listaOpciones[$keyEncuesta][$keyPregunta] as $keyOpcion => $opcion){
                           if( empty($opcion['nombre'])) continue;

                           $alternativasOpcion = !empty($visitaEncuesta[$visita['idVisita']]['opciones'][$keyPregunta][$opcion['idAlternativaOpcion']]) ? implode(", ", array_unique($visitaEncuesta[$visita['idVisita']]['opciones'][$keyPregunta][$opcion['idAlternativaOpcion']])): '';
                           
						   array_push($new_data[$i],
                              "<p class='text-center'>{$alternativasOpcion}</p>"
                           );
						   
                        }
						
						if($pregunta['idTipoPregunta'] == 4 ){
						   array_push($new_data[$i],
						   "<p class='text-center'>{$fotoPreg}</p>"
						   );
						}

                  }

                  if ($encuesta["foto"] == 1) {
                     if (!empty($visitaFoto[$visita['idVisita']][$keyEncuesta]) || !empty($flagFotoMultiple[$visita['idVisita']][$keyEncuesta])) {
                         $foto = '<a href="javascript:;" class="lk-encuesta-foto a-fa text-center" data-foto="' . $visitaFoto[$visita['idVisita']][$keyEncuesta] . '" data-modulo="encuestas" data-comentario="" data-idvisitaencuesta="' . $idVisitaEncuesta[$visita['idVisita']][$keyEncuesta] . '"><i class="fa fa-camera" ></i></a>';
                     } else {
                         $foto = "-";
                     }
                  }else{
                        $foto = "-";
                  }

                  array_push($new_data[$i],
                        "<p class='text-center'>{$foto}</p>"
                  );
				  }
				  
			}	

		$result['data']['configTable'] =  [
            'data' => $new_data, 
		];
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


	public function encuesta_pdf(){ 

		//
		$post=json_decode($this->input->post('data'),true);
		$elementos = $post['elementos_det'];

		$params = array();
	

		$params= array();
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

		if(is_array($elementos)){
			$params['elementos_det'] = implode(",",$elementos);
		}else{
			$params['elementos_det']=$elementos;
		}

		$visitas = $this->m_encuesta->query_visitaEncuestaPdf($params)->result_array();



		ini_set('memory_limit','1024M');
		set_time_limit(0);
		//
		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		
		if (count($visitas) > 0) {
			$encuesta = $this->m_encuesta->query_visitaEncuestaDetPdf($params)->result_array();
			$array_resultados = array();
			foreach ($visitas as $row) {
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['fecha'] = $row['fecha'];
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['usuario'] = $row['usuario'];
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['hora'] = $row['horaIni'];
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['razonSocial'] = $row['razonSocial'];
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['distribuidora'] = (!empty($row['distribuidora']) ? $row['distribuidora'] : '' );
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['cliente'] = $row['razonSocial'];
				$array_resultados[$row['idVisita']][$row['idEncuesta']]['encuesta'] = $row['encuesta'];
			}

			$array_grafico = array();
			foreach ($encuesta as $fila) {

				if($fila['imgRef']!=null){
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['fotos'][$fila['idVisitaFoto']]= $fila['imgRef'];
				}

				if($fila['imgRefAlt']!=null){
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['fotos'][$fila['idVisitaFotoAlt']]= $fila['imgRefAlt'];
				}
				
				if ($fila['idTipoPregunta'] == 1) {
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['nombre']= $fila['pregunta'];
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['respuesta']= $fila['respuesta'];
				}

				if ($fila['idTipoPregunta'] == 2) {
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['nombre']= $fila['pregunta'];
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['respuesta']= $fila['respuesta'];
				}

				if ($fila['idTipoPregunta'] == 3) {
					$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['nombre']= $fila['pregunta'];

					if( isset($array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['respuesta'])){
						$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['respuesta'][$fila['idAlternativa']]=$fila['respuesta'];
					}else{
						$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['respuesta']= array();
						$array_resultados[$fila['idVisita']][$fila['idEncuesta']]['preguntas'][$fila['idPregunta']]['respuesta'][$fila['idAlternativa']]=$fila['respuesta'];
					}
					
				}
			}
			
			$visitasTotal=count($visitas);

			$www=base_url().'public/';
			$style="
			<style>
					body{ 
						font-family: 'Century Gothic', 
						CenturyGothic, AppleGothic,
						 sans-serif; 
						font-size: 12px 
					}
					span{ color: #1370C5; font-size: 11px; }
					.content{ display: table; width: 100%; }
					.descripcion{ margin: 0 auto; width: 100% }
					.descripcion th, .descripcion td{ padding: 3px; }
					.descripcion .img td{ border-top: 1px solid #000; border-bottom: 1px solid #000; }
					.detalle{ border-collapse: collapse; width: 100%; margin: 0 auto; }
					.detalle th{ background-color: #1370C5; color: white; text-align: center; }
					.detalle th, .detalle td{ padding: 8px; }
					.detalle tr:nth-child(even){ background-color: #f2f2f2 }
					.ancho10{ display: table; width: 100%; margin: 10px 0px; }
					.ancho50{ display: table; width: 100%;}
					.left{ display: inline-block; width: 100%;  }
					.foto{ height: 180px; width: 300px; margin:5px; }
					.head{ display: table; width: 100%; border: 1px solid #000; border-radius: 8px; }
					.head2{ display: inline-block; float: left; width: 5%; height: 35px; background-color: #ffffff ; border-radius: 8px 0px 0px 8px; }
					.head3{ display: inline-block; float: left; width: 95%; height: 35px; background-color: #1370C5; color: #ffffff; border-radius: 0px 8px 8px 0px;}
					.head4{ padding: 10px; }
					.imgicon{ width: 100%; padding: 5px }
			</style>
			";

			$header='<div class="head" >';
				$header.='<div class="head2">';
						$header.='<img class="imgicon" src="'.$www.'/assets/images/pg-2.png"  >';
				$header.='</div>';
				$header.='<div class="head3">';
					$header.='<div class="head4">';
						$header.='<strong>Reporte Fotográfico de Encuesta </strong>';
					$header.='</div>';
				$header.='</div>';
			$header.='</div>';
			
			$newPage = 0;
			//
			if( $visitasTotal>400 ){
				//
				$html='<br>Se encontraron más de 400 registros. Excedio el maximo permitido.';
				//
				$mpdf->SetHTMLHeader($header);
				$mpdf->setFooter('{PAGENO}');
				$mpdf->AddPage();
				$mpdf->WriteHTML($style);
				$mpdf->WriteHTML($html);
			} elseif( $visitasTotal>0 && $visitasTotal<400 ){
				$html = ''; $num=1; $cant=0;
					foreach($array_resultados as $rowVisita){ 

						foreach($rowVisita as $row){ 
							
						//if (in_array($row->idUsuario, $arrayGTM)) { 
							$cant++;
							//
							$html.='<br>';
							$html.='<div class="content">';
								$html .= '<table class="descripcion">';
									$html .= '<tbody>';
										$html .= '<tr>';
											$html .= '<td>ENCUESTA: <span>'.$row['encuesta'].'</span> </td>';
										$html .= '</tr>';
										$html .= '<tr>';
											$html .= '<td>FECHA: <span>'.$row['fecha'].'</span> </td>';
										$html .= '</tr>';
										$html .= '<tr>';
											$html .= '<td>USUARIO: <span>'.$row['usuario'].'</span>  </td>';
										$html .= '</tr>';
										$html .= '<tr>';
											$html .= '<td>HORA: <span>'.time_change_format($row['hora']).'</span> </td>';
										$html .= '</tr>';
										$html .= '<tr>';
											$html .= '<td>DISTRIBUIDORA: <span>'.$row['distribuidora'].'</span> </td>';
										$html .= '</tr>';
										$html .= '<tr>';
											$html .= '<td>CLIENTE: <span>'.$row['cliente'].'</span> </td>';
										$html .= '</tr>';
										$html .= '<tr class="img">';
											if(!empty($row['fotos'])){
												$html .= '<td >';
												if( count($row['fotos'])>0)
												{
													foreach($row['fotos'] as $rowFotos){
														if($rowFotos!=null){
															$params = explode("_",$rowFotos);
															$last = end($params);
															$pos = strpos($last,"WASABI");
															$ruta = '';
															if($pos === false ) $ruta = 'http://movil.visualimpact.com.pe/fotos/impactTrade_android/';
															else $ruta = 'https://s3.us-west-1.wasabisys.com/visualimpact.app/fotos/impactTrade_Android/';
															$html .= '<img class="foto" src="'.$ruta.'encuestas/'.$rowFotos.'" width="280" height="200" />';
														}
													}
												}
												
												$html.=' </td> ';
											} else {
												$html .= '<td >Sin Fotos.</td>';
											}
										$html .= '</tr>';

										if(!empty($row['preguntas'])){
											
											foreach($row['preguntas'] as $rowPreguntas){
												$html .= '<tr>';
													if( $rowPreguntas!=null){
														if( is_array($rowPreguntas['respuesta'])){
															$resp= implode(" , ", $rowPreguntas['respuesta'] );
															$html .= '<td>'.$rowPreguntas['nombre'].': <span> '.$resp.'</span> </td>';
														}else{
															$html .= '<td>'.$rowPreguntas['nombre'].': <span> '.$rowPreguntas['respuesta'].'</span> </td>';
														}
													}
												$html .= '</tr>';
											}
										}


									$html .= '</tbody>';
								$html .= '</table>';
							$html .= '</div>';
							//
							//
							$mpdf->SetHTMLHeader($header);
							$mpdf->setFooter('{PAGENO}');
							$mpdf->AddPage();
							$mpdf->WriteHTML($style);
							$mpdf->WriteHTML($html);
							//
							$html = '';
							
							$num++;
						
						}
					}
			} else {
				//
				$html='No se encontraron resultados para la consulta realizada.';
				//
				$mpdf->SetHTMLHeader($header);
				$mpdf->setFooter('{PAGENO}');
				$mpdf->AddPage();
				$mpdf->WriteHTML($style);
				$mpdf->WriteHTML($html);
			}
			//


		}

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		$mpdf->Output("Encuesta.pdf", \Mpdf\Output\Destination::DOWNLOAD);

		
	}

	public function getTablaEncuestasConsolidado()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Encuestas';
		$post = json_decode($this->input->post('data'), true);

		if (isset($post['idEncuesta'])) {
			$encuestas = $post['idEncuesta'];
			if (is_array($encuestas)) {
				$post['idEncuesta'] = implode(",", $encuestas);
			} else {
				$post['idEncuesta'] = $encuestas;
			}
		}

		$params = [];
		$params['idCuenta'] = empty($post['cuenta_filtro']) ? "" : $post['cuenta_filtro'];
		$params['idProyecto'] = empty($post['proyecto_filtro']) ? "" : $post['proyecto_filtro'];
		$params['idGrupoCanal'] = empty($post['grupo_filtro']) ? "" : $post['grupo_filtro'];
		$params['subcanal'] = empty($post['subcanal_filtro']) ? "" : $post['subcanal_filtro'];
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

		foreach ($this->m_encuesta->getVisitaEncuesta(['fecIni' => getFechasDRP($params["txt-fechas"])[0], 'fecFin' => getFechasDRP($params["txt-fechas"])[1]])->result_array() as $fila) {
			$dataParaVista['visita_encuesta'][$fila['idCliente']][$fila['idUsuario']][$fila['idEncuesta']]['num'] = $fila['num'];
		}

		$result['result'] = 1;
		if (count($dataParaVista['visitas']) < 1 or empty($dataParaVista['listaEncuesta'])) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$segmentacion = getSegmentacion(['grupoCanal_filtro' => $params['idGrupoCanal']]);
			$dataParaVista['segmentacion'] = $segmentacion;
			$result['data']['html'] = $this->load->view("modulos/Encuesta/HSM/tablaDetalladoEncuestaConsolidado", $dataParaVista, true);
			$result['data']['configTable'] = [];
		}

		echo json_encode($result);
	}

	public function descargarExcel()
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);

		$result = $this->result;
		$result['msg']['title'] = 'Encuestas';
		$post = json_decode($this->input->post('data'), true);

		if (isset($post['idEncuesta'])) {
			$encuestas = $post['idEncuesta'];
			if (is_array($encuestas)) {
				$post['idEncuesta'] = implode(",", $encuestas);
			} else {
				$post['idEncuesta'] = $encuestas;
			}
		}

		$post['fecIni'] = getFechasDRP($post["txt-fechas"])[0];
		$post['fecFin'] = getFechasDRP($post["txt-fechas"])[1];

		$encuestasClientes = $this->m_encuesta->getVisitaEncuestaDetallado($post)->result_array();
		$result['result'] = 1;
		$result['data']['tablaExcel'] = $this->load->view("modulos/Encuesta/reporteParaExcel", ['encuestasClientes' => $encuestasClientes], true);

		echo json_encode($result);
	}

	public function mostrarFotos()
	{
		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos"];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$idVisitaEncuesta = $data->{'idVisitaEncuesta'};

		$array = [];
		$array['moduloFotos'] = $this->m_encuesta->obtenerFotosEncuesta($idVisitaEncuesta);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/encuesta/verFotos", $array, true);

		echo json_encode($result);
	}

	public function mostrarFotosAlternativas()
	{
		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos"];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$idVisitaEncuesta = $data->{'idVisitaEncuesta'};
		$idPregunta = $data->{'idPregunta'};

		$array = [];
		$array['moduloFotos'] = $this->m_encuesta->obtenerFotosEncuestaAlternativa($idVisitaEncuesta, $idPregunta);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/encuesta/verFotosAlternativa", $array, true);

		echo json_encode($result);
	}
	public function mostrarFotosPreguntas()
	{
		$this->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos"];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		//Datos Generales
		$idVisitaEncuesta = $data->{'idVisitaEncuesta'};
		$idPregunta = $data->{'idPregunta'};

		$array = [];
		$array['moduloFotos'] = $this->m_encuesta->obtenerFotosEncuestaPregunta($idVisitaEncuesta, $idPregunta);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'FOTOS';
		$result['data'] = $this->load->view("modulos/encuesta/verFotosAlternativa", $array, true);

		echo json_encode($result);
	}

}
