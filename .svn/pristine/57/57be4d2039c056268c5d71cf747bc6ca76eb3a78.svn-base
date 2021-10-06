<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveStorecheckEnc extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/gestion/M_liveStorecheckEnc', 'm_liveStorecheckEnc');
		$this->load->model('M_control', 'm_control');
		$this->load->helper('html');
	}

	public function index(){
		$config = [
				'nav' => [ 'menu_active' => 82 ],
				'data' => [ 'title' => 'Live Storecheck - Preguntas', 'icon' => 'fa fa-video-camera', 'message' => '' ],
				'view' => 'modulos/configuraciones/gestion/liveStorecheck/encuesta/index',
				'js' => [ 'script' => [
								// 'assets/libs/datatables/datatables.min',
								// 'assets/libs/datatables/responsive.bootstrap4.min',
								'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
								'assets/custom/js/configuraciones/gestion/liveStorecheckEnc'
							]
					],
				'css' => [ 'style' => [
									// 'assets/libs/datatables/dataTables.bootstrap4.min',
									// 'assets/libs/datatables/buttons.bootstrap4.min'
									'assets/libs/dataTables-1.10.20/datatables'
								]
						]
			];

		$this->view($config);
	}

	public function consultar(){
		$result = $this->result;
		$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheckEnc->consultar($input);
			if( empty($query) ){
				$result['data']['html'] = createMessage(array('type' => 2, 'message'=> 'No se encontraron resultados'));
			}
			else{
				$data['data'] = $query;
				$result['data']['html'] = $this->load->view('modulos/configuraciones/gestion/liveStorecheck/encuesta/consultar', $data, true);
			}
		echo json_encode($result);
	}

	public function estado(){
		$result  = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheckEnc->estado($input);
			if( $query ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array( 'type' => 1, 'message'=> 'Se cambió el estado del registro correctamente'));
			}
			else{
				$result['msg']['content'] = createMessage(array( 'type' => 0 ));
			}
		echo json_encode($result);
	}

	public function ver(){
		$result = $this->result;
			$input = json_decode($this->input->post('data'), true);
			$idEncuesta = $input['id'];

			$data = array(
					'encuesta' => '',
					'preguntas' => array(),
					'alternativas' => array()
				);

			$query = $this->m_liveStorecheckEnc->listEncuesta(array('idEncuesta' => $idEncuesta));
			foreach($query as $row){
				$data['encuesta'] = $row['encuesta'];
				
				$data['preguntas'][$row['idPregunta']]['nombre'] = $row['pregunta'];
				$data['preguntas'][$row['idPregunta']]['tipo'] = $row['tipo'];
				$data['preguntas'][$row['idPregunta']]['tipoAuditoria'] = $row['tipoAuditoria'];

				if( !empty($row['idAlternativa']) ){
					$data['alternativas'][$row['idPregunta']][$row['idAlternativa']]['nombre'] = $row['alternativa'];
				}
			}

			$result['data']['view'] = $this->load->view('modulos/configuraciones/gestion/liveStorecheck/encuesta/ver', $data, true);
		echo json_encode($result);
	}

	public function nuevo(){
		$result = $this->result;
			$data = array(
					'frm' => 'frm-live-encuesta-nuevo',
					'tipos' => array()
				);

			$query = $this->m_liveStorecheckEnc->listTipo();
			foreach($query as $row){
				$data['tipos'][$row['id']]['nombre'] = $row['nombre'];
			}
			unset($query, $row);

			$data['cuenta'] = $this->m_control->get_cuenta();

			$result['data']['frm'] = $data['frm'];
			$result['data']['view'] = $this->load->view('modulos/configuraciones/gestion/liveStorecheck/encuesta/nuevo', $data, true);
		echo json_encode($result);
	}

	public function guardar(){
		$result  = $this->result;
			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheckEnc->guardar($input);
			if( $query['status'] ){
				$result['result'] = 1;
				$result['msg']['content'] = createMessage(array( 'type' => 1, 'message'=> 'Se cambió el estado del registro correctamente'));
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

}
