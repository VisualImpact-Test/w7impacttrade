<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveStorecheck extends MY_Controller{

	var $frm = 'frm-lsck-auditoria';

	public function __construct(){
		parent::__construct();
		$this->load->model('M_liveStorecheck', 'm_liveStorecheck');
		$this->load->model('M_control', 'm_control');
		$this->load->helper('html');

		$this->bsModal = true;
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$data = [
			'title' => 'Live Storecheck',
			'icon' => 'far fa-video',
			'message' => ''
		];

		$config = [
			'nav' => ['menu_active' => 74],
			'data' => $data,
			'view' => 'modulos/liveStorecheck/index',
			'js' => [
				'script' => [
					'assets/libs/datatables/datatables.min',
					'assets/libs/datatables/responsive.bootstrap4.min',
					'assets/libs/fileDownload/jquery.fileDownload',
					'assets/libs/bootstraptoggle/bootstrap4-toggle.min',
					'assets/custom/js/core/datatables-defaults',
					'assets/custom/js/liveStorecheck'
				]
			],
			'css' => [
				'style' => [
					'assets/libs/datatables/dataTables.bootstrap4.min',
					'assets/libs/datatables/buttons.bootstrap4.min',
					'assets/libs/bootstraptoggle/bootstrap4-toggle.min',
					'assets/custom/css/liveStorecheck'
				]
			]
		];

		$this->view($config);
	}

	public function plazas(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = [
					'idModal' => $input['idModal'],
					'plaza' => $this->m_liveStorecheck->listPlaza()
				];

			$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/plazas', $data, true);
		echo json_encode($result);
	}

	public function tiendas(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = [
					'idModal' => $input['idModal'],
					'tienda' => $this->m_liveStorecheck->listTienda()
				];

			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/tiendas', $data, true);
		echo json_encode($result);
	}

	public function buscar($idPlaza, $buscar){
		$result = [ 'results' => [] ];
			$query = $this->m_liveStorecheck->listTienda([ 'top' => 7, 'idPlaza' => $idPlaza, 'buscar' => urldecode($buscar) ]);

			foreach($query as $k => $row){
				if( !isset($result['results']['category'.$row['idTipoCliente']]) ){
					$result['results']['category'.$row['idTipoCliente']]['name'] = $row['tipoCliente'];
					$result['results']['category'.$row['idTipoCliente']]['results'] = [];
				}
				$result['results']['category'.$row['idTipoCliente']]['results'][] = [
						'id' => $row['idCliente'],
						'title' => $row['idCliente']." - ".$row['razonSocial'],
						'description' => $row['direccion']
					];
			}
		echo json_encode($result);
	}

	public function formulario(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = [
					'idModal' => $input['idModal'],
					'frm' => $this->frm,
					'info' => $this->m_liveStorecheck->listInfo([ 'estado' => 1 ]),
					'tipoCliente' => $this->m_liveStorecheck->listTipoCliente([ 'estado' => 1 ]),
					'plaza' => [],
					'plazaInfo' => [],
					'plazaTipoCliente' => [],
					'responsable' => [],
					'responsableTipo' => [],
					'extAudTipo' => [],
					'extAudTipoProm' => [],
					'audTipoTotal' => [],
					'evaluacionPlaza' => [],
					'evaluacionDetPlaza' => [],
					'encuestas' => [],
					'preguntas' => [],
					'alternativas' => [],
				];

			$query = $row = [];
			$query = $this->m_liveStorecheck->listPlaza([ 'idPlaza' => $input['idPlaza'] ]);
			foreach($query as $row){
				$data['plaza']['id'] = $row['idPlaza'];
				$data['plaza']['nombre'] = $row['nombre'];
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listPlazaInfo([ 'idPlaza' => $input['idPlaza'] ]);
			foreach($query as $row){
				$data['plazaInfo'][$row['idInfo']]['nombre'] = $row['info'];
				$data['plazaInfo'][$row['idInfo']]['valor'] = $row['valor'];
				$data['plazaInfo'][$row['idInfo']]['idEmpresa'] = $row['idEmpresa'];
				$data['plazaInfo'][$row['idInfo']]['empresa'] = $row['empresa'];
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listPlazaTipoCliente([ 'idPlaza' => $input['idPlaza'] ]);
			foreach($query as $row){
				$data['plazaTipoCliente'][$row['idTipoCliente']]['totalTienda'] = $row['totalTienda'];
				
				$data['extAudTipo'][$row['idExtAudTipo']]['nombre'] = $row['extAudTipo'];
				$data['extAudTipoProm'][$row['idTipoCliente']][$row['idExtAudTipo']]['valor'] = $row['extAudPromedio'];

				$data['audTipoTotal'][$row['idTipoCliente']][$row['idExtAudTipo']]['valor'] = $row['audTotal'];
			}

			$aEncuesta = [];
			$query = $row = [];
			$query = $this->m_liveStorecheck->listPlazaEvaluacion();
			foreach($query as $row){
				$data['evaluacionPlaza'][$row['idEvaluacion']]['nombre'] = $row['evaluacion'];
				$data['evaluacionDetPlaza'][$row['idEvaluacion']][$row['idEvaluacionDet']]['nombre'] = $row['evaluacionDet'];
				$data['evaluacionDetPlaza'][$row['idEvaluacion']][$row['idEvaluacionDet']]['idEncuesta'] = $row['idEncuesta'];
				$data['evaluacionDetPlaza'][$row['idEvaluacion']][$row['idEvaluacionDet']]['detallar'] = $row['detallar'];

				if( !empty($row['idEncuesta']) )
				$aEncuesta[$row['idEncuesta']] = $row['idEncuesta'];
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listEncuesta([ 'idEncuesta' => $aEncuesta ]);
			foreach($query as $row){
				$data['encuestas'][$row['idEncuesta']]['nombre'] = $row['encuesta'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['nombre'] = $row['pregunta'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['tipo'] = $row['idTipo'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['idExtAudTipo'] = $row['idExtAudTipo'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['extAudPresencia'] = $row['extAudPresencia'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['extAudDetalle'] = $row['extAudDetalle'];
				$data['alternativas'][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];
			}

			$result['result'] = 1;
			$result['data']['frm'] = $data['frm'];
			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/formulario', $data, true);

		responder:
		echo json_encode($result);
	}

	public function formularioTienda(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = [
					'frm' => $this->frm,
					'tienda' => [],
					'numTienda' => $input['numTienda'],
					'responsable' => [],
					'responsableTipo' => [],
					'extAudTipo' => [],
					'evaluacion' => [],
					'evaluacionDet' => [],
					'encuestas' => [],
					'preguntas' => [],
					'alternativas' => [],
					'tiendaExtAud' => []
				];
			$aEncuesta = [];

			$query = $row = [];
			$query = $this->m_liveStorecheck->listPlazaTipoCliente([ 'idPlaza' => $input['idPlaza'] ]);
			foreach($query as $row){
				// $data['plazaTipoCliente'][$row['idTipoCliente']]['totalTienda'] = $row['totalTienda'];

				$data['extAudTipo'][$row['idExtAudTipo']]['nombre'] = $row['extAudTipo'];
				// $data['extAudTipoProm'][$row['idTipoCliente']][$row['idExtAudTipo']]['valor'] = $row['extAudPromedio'];
			}

			$tipoCliente = '';
			$query = $row = [];
			$query = $this->m_liveStorecheck->listTienda([ 'idCliente' => $input['idCliente'] ]);
			foreach($query as $row){
				$data['tienda'][$row['idCliente']]['nombre'] = $row['razonSocial'];
				$data['tienda'][$row['idCliente']]['idTipoCliente'] = $row['idTipoCliente'];
				$data['tienda'][$row['idCliente']]['tipoCliente'] = $row['tipoCliente'];

				$tipoCliente = $row['tipoCliente'];
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listTiendaEvaluacion([ 'idCliente' => $input['idCliente'] ]);
			foreach($query as $row){
				$data['evaluacion'][$row['idTipoCliente']][$row['idEvaluacion']]['nombre'] = $row['evaluacion'];
				$data['evaluacionDet'][$row['idTipoCliente']][$row['idEvaluacion']][$row['idEvaluacionDet']]['nombre'] = $row['evaluacionDet'];
				$data['evaluacionDet'][$row['idTipoCliente']][$row['idEvaluacion']][$row['idEvaluacionDet']]['idEncuesta'] = $row['idEncuesta'];

				if( !empty($row['idEncuesta']) )
				$aEncuesta[$row['idEncuesta']] = $row['idEncuesta'];
			}

			if( empty($data['evaluacion']) ){
				$result['msg']['content'] = 'No se encontraron evaluaciones para el tipo de cliente '.$tipoCliente;
				goto responder;
			}

			if( !empty($aEncuesta) ){
				$query = $row = [];
				$query = $this->m_liveStorecheck->listEncuesta([ 'idEncuesta' => $aEncuesta ]);
				foreach($query as $row){
					$data['encuestas'][$row['idEncuesta']]['nombre'] = $row['encuesta'];
					$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['nombre'] = $row['pregunta'];
					$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['tipo'] = $row['idTipo'];
					$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['idExtAudTipo'] = $row['idExtAudTipo'];
					$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['extAudPresencia'] = $row['extAudPresencia'];
					$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['extAudDetalle'] = $row['extAudDetalle'];
					$data['alternativas'][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];
				}
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listEncuestaTienda();
			foreach($query as $row){
				$data['encuestas'][$row['idEncuesta']]['nombre'] = $row['encuesta'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['nombre'] = $row['pregunta'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['tipo'] = $row['idTipo'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['idExtAudTipo'] = $row['idExtAudTipo'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['extAudPresencia'] = $row['extAudPresencia'];
				$data['preguntas'][$row['idEncuesta']][$row['idPregunta']]['extAudDetalle'] = $row['extAudDetalle'];
				$data['alternativas'][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];

				$data['encuestasTienda'][$row['idEncuesta']] = $row['idEncuesta'];
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listTiendaExtAud([ 'idCliente' => $input['idCliente'] ]);
			foreach($query as $row){
				$data['tiendaExtAud'][$row['idCliente']][$row['idExtAudTipo']][$row['idExtAudMat']]['nombre'] = $row['material'];
				$data['tiendaExtAud'][$row['idCliente']][$row['idExtAudTipo']][$row['idExtAudMat']]['presencia'] = $row['presencia'];
			}

			$query = $row = [];
			$query = $this->m_liveStorecheck->listResponsable($input);
			foreach($query as $row){
				$data['responsableTipo'][$row['idTipo']]['nombre'] = $row['tipo'];
				$data['responsable'][$row['idTipo']][$row['idResponsable']]['nombres'] = $row['nombres'];
				$data['responsable'][$row['idTipo']][$row['idResponsable']]['apellidos'] = $row['apellidos'];
			}

		$result['result'] = 1;
		$result['data']['view'] = $this->load->view('modulos/liveStorecheck/formularioTienda', $data, true);

		responder:
		echo json_encode($result);
	}

	public function calcular(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			if( !is_array($input['tienda']) ){
				$input['tienda'] = [ $input['tienda'] ];
			}

			// NOTA PERFECT OMS
			$aTipoIndicador = []; $aIndicador = []; $aIndicadorPunt = [];
			$aPuntaje = [
					1 => [],
					2 => [],
					'total' => 0,
					'nota' => 0,
					'porcentaje' => 0,
					'idPerfectOms' => 0,
					'perfectOms' => ''
				];

			$query = $this->m_liveStorecheck->listIndicador();
			foreach($query as $row){
				$aIndicador[$row['idTipoIndicador']][$row['idIndicador']]['nombre'] = $row['indicador'];
				$aIndicador[$row['idTipoIndicador']][$row['idIndicador']]['idTipoCalculo'] = $row['idTipoCalculo'];
				$aIndicador[$row['idTipoIndicador']][$row['idIndicador']]['array'] = $row['array'];
				$aIndicador[$row['idTipoIndicador']][$row['idIndicador']]['id_01'] = $row['id_01'];
				$aIndicador[$row['idTipoIndicador']][$row['idIndicador']]['id_02'] = $row['id_02'];

				$aIndicadorPunt[$row['idIndicador']][$row['idIndicadorPunt']]['operador'] = $row['operador'];
				$aIndicadorPunt[$row['idIndicador']][$row['idIndicadorPunt']]['valor_01'] = $row['valor_01'];
				$aIndicadorPunt[$row['idIndicador']][$row['idIndicadorPunt']]['valor_02'] = $row['valor_02'];
				$aIndicadorPunt[$row['idIndicador']][$row['idIndicadorPunt']]['punto'] = $row['punto'];

				$aTipoIndicador[$row['idTipoIndicador']]['nombre'] = $row['tipoIndicador'];
			}

			foreach($aTipoIndicador as $idTipoIndicador => $vtind){
				foreach($aIndicador[$idTipoIndicador] as $idIndicador => $vind){
					if( $idTipoIndicador == 1 ){ // PLAZA
						$index_01 = 'punto['.$vind['array'].']['.$vind['id_01'].']';
						$index_02 = 'punto['.$vind['array'].']['.$vind['id_02'].']';

						$dato_01 = 0;
						$dato_02 = 0;

						if( isset($input[$index_01]) ) $dato_01 = preg_replace('/[^0-9.]/', '', $input[$index_01]);
						if( isset($input[$index_02]) ) $dato_02 = preg_replace('/[^0-9.]/', '', $input[$index_02]);

						$valor = 0;
						if( $vind['idTipoCalculo'] == 1 ){ // NINGUNO
							$valor = $dato_01;
						}
						elseif( $vind['idTipoCalculo'] == 2 ){ // COMPARAR
							$valor = $dato_01 - $dato_02;
						}

						$aPuntaje[$idTipoIndicador][$idIndicador] = 0;
						if( !empty($valor) ){
							foreach($aIndicadorPunt[$idIndicador] as $vindpt){
								if( !empty($aPuntaje[$idTipoIndicador][$idIndicador]) ) continue;

								if( $vindpt['operador'] != '<>' )
									$exec = "\$punto = ({$valor} {$vindpt['operador']} {$vindpt['valor_01']}) ? {$vindpt['punto']} : 0;";
								else
									$exec = "\$punto = ({$valor} > {$vindpt['valor_01']} && {$valor} < {$vindpt['valor_02']}) ? {$vindpt['punto']} : 0;";

								eval($exec);
								$aPuntaje[$idTipoIndicador][$idIndicador] = $punto;
							}
						}
					}
					elseif( $idTipoIndicador == 2 ){
						foreach($input['tienda'] as $idCliente){
							$presentes = 0;
							$marcados = 0;

							$index = 'punto['.$vind['array'].']['.$idCliente.']['.$vind['id_01'].']';

							if( isset($input[$index.'[presentes]']) )
								$presentes = preg_replace('/[^0-9.]/', '', $input[$index.'[presentes]']);

							if( !is_array($input["evaluacion[{$idCliente}]"]) )
								$input["evaluacion[{$idCliente}]"] = [ $input["evaluacion[{$idCliente}]"] ];

							if( isset($input["evaluacion[{$idCliente}]"]) ){
								if( !is_array($input["evaluacion[{$idCliente}]"]) )
									$input["evaluacion[{$idCliente}]"] = [ $input["evaluacion[{$idCliente}]"] ];

								foreach($input["evaluacion[{$idCliente}]"] as $idEvaluacion){
									if( isset($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"]) ){
										if( !is_array($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"]) )
											$input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] = [ $input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] ];

										foreach($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] as $idEvaluacionDet){
											if( isset($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"]) ){
												if( !is_array($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"]) )
													$input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] = [ $input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] ];

												foreach($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] as $idPregunta){
													if( $idPregunta == $vind['id_01'] ){
														if( isset($input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
															if( !is_array($input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) )
																$input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] = [ $input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] ];

															$marcados = count($input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]);
														}
														elseif( isset($input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
															if( !is_array($input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) )
																$input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] = [ $input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] ];

															$marcados = count($input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]);
														}
													}
												}
											}
										}
									}
								}
							}

							$valor = 0;
							if( $vind['idTipoCalculo'] == 3 ){ // PORCENTAJE
								if( $marcados != 0 && $presentes != 0 ){
									$valor = ROUND($marcados / $presentes * 100, 2);
								}
							}
							elseif( $vind['idTipoCalculo'] == 4 ){ // TOTAL
								$valor = $presentes + $marcados;
							}

							$aPuntaje[$idTipoIndicador][$idIndicador][$idCliente] = 0;
							if( !empty($valor) ){
								foreach($aIndicadorPunt[$idIndicador] as $vindpt){
									if( !empty($aPuntaje[$idTipoIndicador][$idIndicador][$idCliente]) ) continue;

									if( $vindpt['operador'] != '<>' )
										$exec = "\$punto = ({$valor} {$vindpt['operador']} {$vindpt['valor_01']}) ? {$vindpt['punto']} : 0;";
									else
										$exec = "\$punto = ({$valor} > {$vindpt['valor_01']} && {$valor} < {$vindpt['valor_02']}) ? {$vindpt['punto']} : 0;";

									eval($exec);
									$aPuntaje[$idTipoIndicador][$idIndicador][$idCliente] = $punto;
								}
							}
						}
					}
				}
			}

			/* INDICADOR PLAZA - PUNTOS */
			foreach($aPuntaje[1] as $idIndicador => $v){
				$aPuntaje['nota'] += $v;
				$aPuntaje['total'] += 2;
			}

			/* INDICADOR PDV - PUNTOS */
			foreach($aPuntaje[2] as $idIndicador => $v){
				$aPuntaje[1][$idIndicador] = round(array_sum($v) / count($v), 2);

				$aPuntaje['nota'] += $aPuntaje[1][$idIndicador];
				$aPuntaje['total'] += 2;
			}

			if( $aPuntaje['total'] != 0 && $aPuntaje['nota'] != 0 ){
				$aPuntaje['porcentaje'] = round($aPuntaje['nota'] / $aPuntaje['total'] * 100, 2);
			}

			/* PERFECT OMS */
			$perfectOms = $this->m_liveStorecheck->listPerfectOms();
			foreach($perfectOms as $row){
				if( !empty($aPuntaje['idPerfectOms']) ) continue;

				$condicion = str_replace('??', $aPuntaje['porcentaje'], $row['condicion']);

				$exec = "\$idPerfectOms = ({$condicion}) ? {$row['idPerfectOms']} : 0;";
				eval($exec);

				if( !empty($idPerfectOms) ){
					$aPuntaje['idPerfectOms'] = $idPerfectOms;
					$aPuntaje['perfectOms'] = $row['nombre'];
				}
			}

			// NOTA GENERAL
			$aPregunta = [
					1 => [ 'total' => 0, 'aprobadas' => 0, 'nota' => 0 ],
					2 => [ 'total' => [], 'aprobadas' => [] ]
				];

			foreach($input['tienda'] as $idCliente){
				$aPregunta[2]['total'][$idCliente] = 0;
				$aPregunta[2]['aprobadas'][$idCliente] = 0;

				if( isset($input["evaluacion[{$idCliente}]"]) ){
					if( !is_array($input["evaluacion[{$idCliente}]"]) )
						$input["evaluacion[{$idCliente}]"] = [ $input["evaluacion[{$idCliente}]"] ];

					foreach($input["evaluacion[{$idCliente}]"] as $idEvaluacion){						
						if( isset($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"]) ){
							if( !is_array($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"]) )
								$input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] = [ $input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] ];

							foreach($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] as $idEvaluacionDet){
								if( isset($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"]) ){
									if( !is_array($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"]) )
										$input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] = [ $input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] ];

									$aPregunta[2]['total'][$idCliente] += count($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"]);

									foreach($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] as $idPregunta){
										if( !isset($input["resultado[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) )
											continue;

										$aPregunta[2]['aprobadas'][$idCliente] += $input["resultado[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"];
									}
								}
							}
						}
					}
				}
			}

			$aPregunta[1]['total'] = array_sum($aPregunta[2]['total']);
			$aPregunta[1]['aprobadas'] = array_sum($aPregunta[2]['aprobadas']);

			if( $aPregunta[1]['total'] && $aPregunta[1]['aprobadas'] )
				$aPregunta[1]['nota'] = round($aPregunta[1]['aprobadas'] / $aPregunta[1]['total'] * 100, 2);

			// GUARDAR CALCULO
			$aCalculo = [
					'idPlaza' => $input['idPlaza'],
					'pregunta' => $aPregunta[1],
					'tipoIndicador' => $aTipoIndicador,
					'indicador' => $aIndicador,
					'puntaje' => $aPuntaje
				];
			$idCalculo = $this->m_liveStorecheck->calculo($aCalculo);

			if( empty($idCalculo) ){
				$result['msg']['title'] = 'Auditoria';
				$result['msg']['content'] = 'Ocurrio un problema para calcular la nota de la auditoria';
				goto responder;
			}
			else{
				$result['data']['idCalculo'] = $idCalculo;
				$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;
			}

			$data = [
					'tienda' => $input['tienda'],
					'puntaje' => $aPuntaje,
					'tipoIndicador' => $aTipoIndicador,
					'indicador' => $aIndicador,
					'pregunta' => $aPregunta,
				];

			$result['result'] = 1;
			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/calculo', $data, true);

		responder:
		echo json_encode($result);
	}

	public function guardar(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			if( empty($input['fecha']) ) $input['fecha'] = date('Ymd');
			if( empty($input['idUsuario']) ) $input['idUsuario'] = $this->idUsuario;

			$query = $this->m_liveStorecheck->guardar($input);

			if( $query ){
				$result['result'] = 1;
				$result['msg']['content'] = 'Se registró correctamente la auditoria';

				$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;
			}
			else{
				$result['msg']['content'] = 'La auditoria no se registró. Comunicarse con el administrador';
			}

		$result['msg']['title'] = 'Live Storecheck';
		echo json_encode($result);
	}

	public function guardarFotosEstado(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->guardarFotosEstado($input);
			if( $query ){
				$result['result'] = 1;
				$result['msg']['content'] = 'Se registró correctamente el estado de las fotos';

				$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;
			}
			else{
				$result['msg']['content'] = 'No se logró guardar los cambios. Comunicarse con el administrador';
			}

		echo json_encode($result);
	}

	public function auditorias(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);
			$data['data'] = $this->m_liveStorecheck->listPlazaAuditoria($input);
			$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

			$result['data']['html'] = getMensajeGestion('noRegistros');
			if( !empty($data['data']) ){
				$result['data']['html'] = $this->load->view('modulos/liveStorecheck/plazasAuditadas', $data, true);
			}
		echo json_encode($result);
	}

	public function historicoPlaza(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = $input;
			$data['data'] = $this->m_liveStorecheck->listPlazaHistorico($input);
			$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/historico/plaza', $data, true);
		echo json_encode($result);
	}

	public function historicoTienda(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = $input;
			$data['data'] = $this->m_liveStorecheck->listTiendaHistorico($input);
			$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/historico/tienda', $data, true);
		echo json_encode($result);
	}

	public function historicoFoto(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->listFotoHistorico($input);
			$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

			$data = [
					'frm' => 'frm-lsck-auditoria-fotos',
					'evaluaciones' => [],
					'fotos' => [],
					
				];

			if( empty($query) ){
				$result['data']['view'] = createMessage([ 'type' => 2, 'message' => 'No se encontraron fotos en esta auditoria' ]);
			}
			else{
				foreach($query as $row){
					$data['evaluaciones'][$row['idEvaluacion']]['nombre'] = $row['evaluacion'];
					$data['fotos'][$row['idEvaluacion']][$row['idAudFoto']]['estado'] = $row['estado'];
				}

				$result['result'] = 1;
				$result['data']['frm'] = $data['frm'];
				$result['data']['view'] = $this->load->view('modulos/liveStorecheck/historico/foto', $data, true);
			}
		echo json_encode($result);
	}

	public function historicoOrden(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

		$query = $this->m_liveStorecheck->listOrdenTrabajo($input);
		$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

		if( empty($query) ){
			$result['data']['view'] = createMessage(['type' => 2, 'message' => 'No se encontraron ordenes de trabajo']);
		}
		else{
			$data['data'] = $query;
			$data['responsable'] = [];

			$query = $this->m_liveStorecheck->listOrdenTrabajoResp($input);
			foreach($query as $row){
				$data['responsable'][$row['idAudClienteEvalPreg']][$row['idResponsable']]['nombre'] = $row['responsable'];
				$data['responsable'][$row['idAudClienteEvalPreg']][$row['idResponsable']]['email'] = $row['email'];
			}

			$result['data']['view'] = $this->load->view('modulos/liveStorecheck/historico/orden', $data, true);
		}

		echo json_encode($result);
	}

	public function historicoOrdenNotificar(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->listOrdenTrabajoNotif($input);

			$plaza = '';
			$contacto = [];
			$notificar = [];

			$noEmail = [];
			$noNotificados = [];

			foreach($query as $row){
				if( empty($row['email']) ){
					array_push($noEmail, $row['responsable']);
				}
				else{
					$plaza = $row['plaza'];
					$contacto[$row['email']] = $row['responsable'];
					$notificar[$row['email']][$row['idAudClienteEvalPreg']]['idCliente'] = $row['idCliente'];
					$notificar[$row['email']][$row['idAudClienteEvalPreg']]['cliente'] = $row['cliente'];
					$notificar[$row['email']][$row['idAudClienteEvalPreg']]['pregunta'] = $row['pregunta'];
					$notificar[$row['email']][$row['idAudClienteEvalPreg']]['ordenTrabajo'] = $row['ordenTrabajo'];
				}
			}

			if( !empty($noEmail) ){
				$html = '';
					$html .= '<div class="row">';
						$html .= '<div class="col-md-12">';
							$html .= createMessage(array('type' => 2, 'message' => 'Las siguientes personas no tienen un email para notificar'));
						$html .= '</div>';
						$html .= '<div class="col-md-12" style="padding: 0 2rem;">';
							foreach($noEmail as $responsable){
								$html .= "<ul>{$responsable}</ul>";
							}
						$html .= '</div>';
					$html .= '</div>';

				$result['msg']['content'] = $html;
				goto responder;
			}

			foreach($notificar as $correo => $content){
				$item = [];
				$query = $this->m_liveStorecheck->listTiendaAltNo([ 'idAudClienteEvalPreg' => array_keys($content) ]);
				foreach($query as $row){
					$item[$row['idAudClienteEvalPreg']][] = $row['item'];
				}

				$emailConf = [
						'to' => $correo,
						'asunto' => "LSC - {$plaza}",
						'contenido' => $this->load->view('modulos/LiveStorecheck/orden/notificar', [ 'datos' => $content, 'item' => $item ], true)
					];

				if( !email($emailConf) ){
					array_push($noNotificados, $correo);
				}
			}
			unset($correo);

			$this->aSessTrack = $this->m_liveStorecheck->aSessTrack;

			if( empty($noNotificados) ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage([ 'type' => 1, 'message' => 'Notificación realizada correctamente' ]);
			}
			else{
				$html = '';
					$html .= '<div class="row">';
						$html .= '<div class="col-md-12">';
							$html .= createMessage([ 'type' => 2, 'message' => 'No se logró notificar a estos contactos:' ]);
						$html .= '</div>';
						$html .= '<div class="col-md-12" style="padding: 0 2rem;">';
							foreach($noNotificados as $correo){
								$html .= "<ul>{$contacto[$correo]}</ul>";
							}
						$html .= '</div>';
					$html .= '</div>';

				$result['msg']['content'] = $html;
			}

		responder:
		echo json_encode($result);
	}

	public function historicoPDF(){
        ini_set('memory_limit','1024M');
		set_time_limit(0);

		$this->aSessTrack[] = [ 'idAccion' => 9 ];

		$input = json_decode($this->input->post('data'), true);

		$data = [
				'plaza' => [],
				'plazaInfo' => [],
				'plazaTipoCliente' => [],
				'plazaEva' => [],
				'plazaEvaDet' => [],
				'plazaEvaDetPreg' => [],
				'plazaEvaDetPregAlt' => [],
				'plazaEvaFoto' => [],
				'info' => [],
				'tipoCliente' => [],
				'extAudTipo' => [],
				'extAudTipoProm' => [],
				'cliente' => [],
				'clienteEnc' => [],
				'clienteEncPreg' => [],
				'clienteEncAlt' => [],
				'clienteEva' => [],
				'clienteEvaDet' => [],
				'clienteEvaDetPreg' => [],
				'clienteEvaDetPregAlt' => [],
				'clienteEvaFoto' => [],
				'tipoIndicador' => [],
				'indicador' => [],
				'indicadorPlaza' => [],
				'indicadorCliente' => [],
			];

		$query = $this->m_liveStorecheck->getPlazaAuditoria($input);

		$idPlaza = $query[0]['idPlaza'];
		$plaza = $query[0]['plaza'];
		$fecha = $query[0]['fecha'];

		$data['plaza'] = $query[0];
		unset($query);

		$query = $this->m_liveStorecheck->listPlazaInfo([ 'idPlaza' => $idPlaza, 'fecha' => $fecha ]);
		foreach($query as $row){
			$data['plazaInfo'][$row['idInfo']]['valor'] = $row['valor'];
			$data['plazaInfo'][$row['idInfo']]['empresa'] = $row['empresa'];

			$data['info'][$row['idInfo']]['nombre'] = $row['info'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->listTipoCliente([ 'estado' => 1 ]);
		foreach($query as $row){
			$data['tipoCliente'][$row['idTipoCliente']]['nombre'] = $row['nombre'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->listPlazaTipoCliente([ 'idPlaza' => $idPlaza ]);
		foreach($query as $row){
			$data['plazaTipoCliente'][$row['idTipoCliente']]['totalTienda'] = $row['totalTienda'];
			
			$data['extAudTipo'][$row['idExtAudTipo']]['nombre'] = $row['extAudTipo'];
			$data['extAudTipoProm'][$row['idTipoCliente']][$row['idExtAudTipo']]['valor'] = $row['extAudPromedio'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->listIndicador();
		foreach($query as $row){
			$data['tipoIndicador'][$row['idTipoIndicador']]['nombre'] = $row['tipoIndicador'];
			$data['indicador'][$row['idTipoIndicador']][$row['idIndicador']]['nombre'] = $row['indicador'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->getPlazaCalculo($input);
		foreach($query as $row){
			$data['indicadorPlaza'][$row['idIndicador']]['punto'] = $row['punto'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->getTiendaCalculo($input);
		foreach($query as $row){
			$data['indicadorCliente'][$row['idCliente']][$row['idIndicador']]['punto'] = $row['punto'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->getPlazaEval($input);
		foreach($query as $row){
			$data['plazaEva'][$row['idEvaluacion']]['nombre'] = $row['evaluacion'];
			$data['plazaEvaDet'][$row['idEvaluacion']][$row['idEvaluacionDet']]['nombre'] = $row['evaluacionDet'];
			$data['plazaEvaDetPreg'][$row['idEvaluacionDet']][$row['idPregunta']]['nombre'] = $row['pregunta'];
			$data['plazaEvaDetPreg'][$row['idEvaluacionDet']][$row['idPregunta']]['respuesta'] = $row['respuesta'];

			if( !empty($row['idAlternativa']) )
				$data['plazaEvaDetPregAlt'][$row['idEvaluacionDet']][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];
		}
		unset($query, $row);

		$query = $this->m_liveStorecheck->getPlazaFoto([ 'idAudPlaza' => $input['idAudPlaza'], 'estado' => 1 ]);
		foreach($query as $row){
			$data['plazaEvaFoto'][$row['idEvaluacion']][$row['idAudFoto']] = $row['idAudFoto'];
		}

		unset($query, $row);
		$query = $this->m_liveStorecheck->getTiendaAuditoria($input);
		foreach($query as $row){
			$data['cliente'][$row['idCliente']]['nombre'] = $row['cliente'];
			$data['cliente'][$row['idCliente']]['tipoCliente'] = $row['tipoCliente'];
		}

		unset($query, $row);
		$query = $this->m_liveStorecheck->getTiendaAuditoriaEncuesta($input);
		foreach($query as $row){
			$data['clienteEnc'][$row['idCliente']][$row['idEncuesta']]['nombre'] = $row['encuesta'];

			$data['clienteEncPreg'][$row['idCliente']][$row['idEncuesta']][$row['idPregunta']]['nombre'] = $row['pregunta'];
			$data['clienteEncPreg'][$row['idCliente']][$row['idEncuesta']][$row['idPregunta']]['respuesta'] = $row['respuesta'];
			
			if( !empty($row['idAlternativa']) ){
				$data['clienteEncAlt'][$row['idCliente']][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];
			}
		}

		unset($query, $row);
		$query = $this->m_liveStorecheck->getTiendaAuditoriaEvaluacion($input);
		foreach($query as $row){
			$data['clienteEva'][$row['idCliente']][$row['idEvaluacion']]['nombre'] = $row['evaluacion'];
			$data['clienteEvaDet'][$row['idCliente']][$row['idEvaluacion']][$row['idEvaluacionDet']]['nombre'] = $row['evaluacionDet'];

			$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['nombre'] = $row['pregunta'];
			$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['tipo'] = $row['idTipoPregunta'];
			$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['idExtAudTipo'] = $row['idExtAudTipo'];
			$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['respuesta'] = $row['respuesta'];

			if( !empty($row['ordenTrabajo']) ){
				$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['ordenTrabajo'] = $row['ordenTrabajo'];

				$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['ordenTrabajoEstado'] = $row['ordenTrabajoEstado'];
				if( !empty($row['ordenTrabajoEstado']) && !empty($row['ordenTrabajoObs']) ){
					$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['ordenTrabajoEstado'] .=  " / {$row['ordenTrabajoObs']}";
				}
			}

			if( !empty($row['idResponsable']) ){
				$data['clienteEvaDetPreg'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['responsable'][$row['idResponsable']] = $row['responsable'];
			}

			if( !empty($row['idItem']) ){
				$data['clienteEvaDetPregAlt'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['total'][$row['idItem']] = $row['item'];
				if( !empty($row['marcados']) ){
					$data['clienteEvaDetPregAlt'][$row['idCliente']][$row['idEvaluacionDet']][$row['idPregunta']]['marcados'][$row['idItem']] = $row['item'];
				}
			}
		}

		$query = $this->m_liveStorecheck->getTiendaFoto([ 'idAudPlaza' => $input['idAudPlaza'], 'estado' => 1 ]);
		foreach($query as $row){
			$data['clienteEvaFoto'][$row['idCliente']][$row['idEvaluacion']][$row['idAudFoto']] = $row['idAudFoto'];
		}

		array_merge($this->aSessTrack, $this->m_liveStorecheck->aSessTrack);

		$body = $this->load->view("modulos/liveStorecheck/pdf/body", $data, true);

		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();

		$mpdf->setFooter('{PAGENO}');
		$mpdf->AddPage('L');
		$mpdf->WriteHTML($body);	

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		$mpdf->Output("LSCK - {$plaza}.pdf", \Mpdf\Output\Destination::DOWNLOAD);

	}

}
