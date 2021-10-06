<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveStorecheck extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/gestion/M_liveStorecheck', 'm_liveStorecheck');
		$this->load->model('M_control', 'm_control');
		$this->load->helper('html');
	}

	public function index()
	{
		$config = [
			'nav' => ['menu_active' => 111],
			'data' => ['title' => 'Live Storecheck', 'icon' => 'far-fa-video', 'message' => ''],
			'view' => 'modulos/configuraciones/gestion/liveStorecheck/index',
			'js' => [
				'script' => [
					'assets/libs/datatables/datatables', 'assets/libs/datatables/responsive.bootstrap4.min', 'assets/custom/js/core/datatables-defaults',
					'assets/custom/js/configuraciones/gestion/liveStorecheck'
				]
			],
			'css' => [
				'style' => [
					'assets/libs/dataTables-1.10.20/datatables',
					'assets/custom/css/liveStorecheck'
				]
			]
		];

		$this->view($config);
	}

	public function banner(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = [];
			$query = $this->m_liveStorecheck->listBanner($input);
			foreach($query as $row){
				$data[$row['id']] = $row['nombre'];
			}

			$result['data'] = $data;
		echo json_encode($result);
	}

	public function tienda(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$data = array(
					'region' => [],
					'tienda' => []
				);
			$query = $this->m_liveStorecheck->listTienda($input);
			foreach($query as $row){
				$data['region'][$row['idRegion']] = $row['region'];
				$data['tienda'][$row['idRegion']][$row['idCliente']] = $row['razonSocial'];
			}

			$result['data'] = $data;
		echo json_encode($result);
	}

	public function consultar(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);


			
			$query = $this->m_liveStorecheck->consultar($input);
			if( empty($query) ){
				$result['data']['html'] = createMessage(array('type' => 2, 'message'=> 'No se encontraron resultados'));
			}
			else{
				$data['idGrupoCanal'] = (isset($input['idGrupoCanal'])? $input['idGrupoCanal'] :0 ) ?: 0;
				$data['data'] = $query;
				$result['data']['html'] = $this->load->view('modulos/Configuraciones/Gestion/LiveStorecheck/consultar', $data, true);
			}
		echo json_encode($result);
	}

	public function ver(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);
			$idListCategoria = $input['id'];

			$data = array(
					'categorias' => [],
					'evaluaciones' => [],
					'evaluacionesDet' => []
				);

			$query = $this->m_liveStorecheck->liveListCategoriaDet(array('idListCategoria' => $idListCategoria));
			foreach($query as $row){
				$data['categorias'][$row['idCategoria']]['nombre'] = $row['categoria'];
				$data['categorias'][$row['idCategoria']]['peso'] = $row['pesoCategoria'];

				$data['evaluaciones'][$row['idCategoria']][$row['idEvaluacion']]['nombre'] = $row['evaluacion'];

				$data['evaluacionesDet'][$row['idCategoria']][$row['idEvaluacion']][$row['idEvaluacionDet']]['nombre'] = $row['evaluacionDet'];
				$data['evaluacionesDet'][$row['idCategoria']][$row['idEvaluacion']][$row['idEvaluacionDet']]['peso'] = $row['pesoEvaluacion'];
				$data['evaluacionesDet'][$row['idCategoria']][$row['idEvaluacion']][$row['idEvaluacionDet']]['idEncuesta'] = $row['idEncuesta'];
				$data['evaluacionesDet'][$row['idCategoria']][$row['idEvaluacion']][$row['idEvaluacionDet']]['encuesta'] = $row['encuesta'];
			}

			$result['data']['view'] = $this->load->view('modulos/Configuraciones/Gestion/LiveStorecheck/ver', $data, true);
		echo json_encode($result);
	}

	public function cambiarEstado(){
		$result  = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->cambiarEstado($input);
			if( $query ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array( 'type' => 1, 'message'=> 'Se cambió el estado del registro correctamente'));
			}
			else{
				$result['msg']['content'] = createMessage(array( 'type' => 0 ));
			}
		echo json_encode($result);
	}

	public function darAlta(){
		$result  = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->darAlta($input);
			if( $query ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array( 'type' => 1, 'message' => 'Se realizó el alta correctamente'));
			}
			else{
				$result['msg']['content'] = createMessage(array( 'type' => 0 ));
			}
		echo json_encode($result);
	}

	public function darBaja(){
		$result  = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->darBaja($input);
			if( $query['status'] ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array( 'type' => 1, 'message' => 'Se realizó la baja correctamente'));
			}
			else{
				if( !empty($query['msg']) ){
					$result['msg']['content'] = createMessage(array( 'type' => 0, 'message' => $query['msg'] ));
				}
				else{
					$result['msg']['content'] = createMessage(array( 'type' => 0 ));
				}
			}
		echo json_encode($result);
	}

	public function nuevo(){
		$result = $this->result;
			$data = json_decode($this->input->post('data'), true);
			$idModal = $data['idModal'];

			$data = array(
					'frm' => 'frm-live-gestor-nuevo',
					'idModal' => $idModal,
					'cuenta' => [],
					'cadena' => [],
					'evaluacion' => [],
					'evaluacionDet' => [],
					'categoria' => [],
				);

			$query = $this->m_control->get_cuenta();
			foreach($query as $row){
				$data['cuenta'][$row['id']]['nombre'] = $row['nombre'];
			}
			unset($query, $row);

			// $query = $this->m_liveStorecheck->listCadena();
			// foreach($query as $row){
				// $data['cadena'][$row['id']]['nombre'] = $row['nombre'];
			// }
			// unset($query, $row);

			$query = $this->m_liveStorecheck->listCategoria();
			foreach($query as $row){
				$data['categoria'][$row['id']]['nombre'] = $row['nombre'];
			}
			unset($query, $row);

			$result['data']['frm'] = $data['frm'];
			$result['data']['view'] = $this->load->view('modulos/Configuraciones/Gestion/LiveStorecheck/nuevo', $data, true);
		echo json_encode($result);
	}

	public function construir(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->liveListCategoria($input);
			if( !empty($query) ){
				$result['msg']['content'] = createMessage(array('type' => 2, 'message' => 'Se encontró un registro activo con los datos seleccionados'));
			}
			else{
				$data = array(
						'categorias' => [],
						'evaluaciones' => [],
						'evaluacionesDet' => [],
						'encuestas' => []
					);

				$query = $this->m_liveStorecheck->listCategoria($input);
				foreach($query as $row){
					$data['categorias'][$row['id']]['nombre'] = $row['nombre'];
				}
				unset($query, $row);

				$query = $this->m_liveStorecheck->listEvaluacion($input);
				foreach($query as $row){
					$data['evaluaciones'][$row['id']]['nombre'] = $row['nombre'];
				}
				unset($query, $row);

				$query = $this->m_liveStorecheck->listEvaluacionDet($input);
				
				if( empty($query) ){
					$result['msg']['content'] = createMessage(array('type' => 2, 'message' => 'No se encontraron evaluaciones'));
				}
				else{
					foreach($query as $row){
						$data['evaluacionesDet'][$row['idEvaluacion']][$row['id']]['nombre'] = $row['nombre'];
					}
					unset($query, $row);

					$query = $this->m_liveStorecheck->listEncuesta($input);
					foreach($query as $row){
						$data['encuestas'][$row['id']]['nombre'] = $row['nombre'];
					}
					unset($query, $row);

					$result['result'] = 1;
					$result['data']['view'] = $this->load->view('modulos/Configuraciones/Gestion/LiveStorecheck/construir', $data, true);
				}
			}
		echo json_encode($result);
	}

	public function calcular(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$peso["categoria"] = [];
			$peso["evaluacionDet"] = [];

			$message = "";
			if( !empty($input["categoria"]) ){
				if( !is_array($input["categoria"]) ){
					$input["categoria"] = array($input["categoria"]);
				}

				foreach($input["categoria"] as $idCategoria){
					$peso["categoria"][$idCategoria] = 0;
						if( !empty($input["peso[{$idCategoria}]"]) ){
							$peso["categoria"][$idCategoria] = $input["peso[{$idCategoria}]"];
						}

					if( !empty($input["evaluacionDet[{$idCategoria}]"]) ){
						if( !is_array($input["evaluacionDet[{$idCategoria}]"]) ){
							$input["evaluacionDet[{$idCategoria}]"] = array($input["evaluacionDet[{$idCategoria}]"]);
						}

						$peso["evaluacionDet"][$idCategoria] = [];
						foreach($input["evaluacionDet[{$idCategoria}]"] as $idEvaluacionDet){
							$peso["evaluacionDet"][$idCategoria][$idEvaluacionDet] = 0;
								if( !empty($input["peso[{$idCategoria}][{$idEvaluacionDet}]"]) ){
									$peso["evaluacionDet"][$idCategoria][$idEvaluacionDet] = $input["peso[{$idCategoria}][{$idEvaluacionDet}]"];
								}

							if( !empty($input["calificar[{$idCategoria}][{$idEvaluacionDet}]"]) ){
								if(
									$input["calificar[{$idCategoria}][{$idEvaluacionDet}]"] == 2 &&
									empty($input["encuesta[{$idCategoria}][{$idEvaluacionDet}]"])
								){
									$message = "<b>".$input["categoria[{$idCategoria}][nombre]"]." / ".$input["evaluacionDet[{$idCategoria}][{$idEvaluacionDet}][nombre]"]."</b> ";
										$message .= "se calificará en base a preguntas, por tal motivo debe elegir una formato de preguntas";
									goto responder;						
								}
							}
						}

						$pesoEvaluacionDet = array_sum($peso["evaluacionDet"][$idCategoria]);
						if( $pesoEvaluacionDet < 100 || $pesoEvaluacionDet > 100 ){
							$message = "La suma de los pesos de las evaluaciones en <b>".$input["categoria[{$idCategoria}][nombre]"]."</b> debe ser 100. <b>(suma: ".$pesoEvaluacionDet.")</b>";
							goto responder;
						}
					}
				}
			}

			$pesoCategoria = array_sum($peso["categoria"]);
				if( $pesoCategoria < 100 || $pesoCategoria > 100 ){
					$message = "La suma de los pesos de las <b>categorias</b> debe sumar 100 <b>(suma: ".$pesoCategoria.")</b>";
					goto responder;
				}

			responder:
				if( empty($message) ){
					$result['result'] = 1;
				}
				else{
					$result['msg']['content'] = createMessage(array('type' => 2, 'message' => $message));
				}
		echo json_encode($result);
	}

	public function guardar(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->guardar($input);
			if( $query ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array('type' => 1, 'message' => 'Datos registrados correctamente'));
			}
			else{
				$result['msg']['content'] = createMessage(array('type' => 0, 'message' => 'Los datos no se registraron. Comunicarse con el administrador'));
			}
		echo json_encode($result);
	}

}
