<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveStorecheckOrden extends MY_login{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_liveStorecheck', 'm_liveStorecheck');
		$this->load->helper('html');
	}

	public function formulario($idAudClienteEvalPreg = ''){
		$query = $this->m_liveStorecheck->listOrdenTrabajo([ 'idAudClienteEvalPreg' => $idAudClienteEvalPreg ]);
		$data = $query[0];
		$data['item'] = [];
		$data['onlyForm'] = false;

		$query = $this->m_liveStorecheck->listTiendaAltNo([ 'idAudClienteEvalPreg' => $idAudClienteEvalPreg ]);
		foreach($query as $row){
			$data['item'][$row['idAudClienteEvalPreg']][] = $row['item'];
		}

		$config = [
				'page' => [ 'title' => 'Live Storecheck' ],
				'view' => 'modulos/LiveStorecheck/orden/formulario',
				'data' => $data
			];

		$aStyle = [
				// 'global/style',
				'assets/custom/css/liveStorecheck'
			];

		$aScript = [
				'assets/custom/js/core/system',
				'assets/custom/js/core/functions',
				'assets/custom/js/liveStorecheckOrden'
			];

		$this->load->view('core/01_head', [ 'style' => $aStyle ]);
		$this->load->view('core/02_body');
		$this->load->view($config['view'], $data);
		$this->load->view('core/10_body_js', [ 'script' => $aScript ]);
		$this->load->view('core/12_body_end');
		$this->load->view('core/13_html_end');
	}

	public function guardar(){
		$result = [
				'result' => 0,
				'url' => '',
				'data' => [],
				'msg' => [ 'title' => 'Alerta', 'content' => '' ]
			];

			$input = json_decode($this->input->post('data'), true);

			$query = $this->m_liveStorecheck->guardarOrdenTrabajo($input);
			$result['result'] = $query ? 1 : 0;

			$html = '';
				$html .= '<div class="row">';
					$html .= '<div class="col-md-12">';
						if( $query ){
							$html .= createMessage(array( 'type' => 1, 'message' => 'Se registró correctamente la auditoria' ));
						}
						else{
							$html .= createMessage(array( 'type' => 0, 'message' => 'No se logró registrar los datos. Comunicarse con el administrador' ));
						}
					$html .= '</div>';
				$html .= '</div>';

			$result['msg']['content'] = $html;

		echo json_encode($result);
	}

}
