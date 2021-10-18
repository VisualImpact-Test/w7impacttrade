<?
class IniciativasSimple extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_iniciativas', 'model');
	}

	public function index()
	{
		$config = [];
		$config['nav']['menu_active'] = '137';
		$config['css']['style'] = [
			'assets/libs/datatables/dataTables.bootstrap4.min',
			'assets/libs/datatables/buttons.bootstrap4.min',
			'assets/custom/css/iniciativas'
		];
		$config['js']['script'] = [
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/iniciativasSimple'
		];

		$config['data']['icon'] = 'fad fa-chart-pie';
		$config['data']['title'] = 'Iniciativas Simple';
		$config['data']['message'] = 'Iniciativas Simple';
		$config['view'] = 'modulos/iniciativasSimple/index';

		$params = [];
		$params['cuenta'] = $this->sessIdCuenta;
		$params['proyecto'] = $this->sessIdProyecto;

		$config['data']['tipoUsuario'] = $this->model->obtener_tipos_usuarios($params);
		$config['data']['elementos'] = $this->model->obtener_elementos_visibilidad($params);
		$config['data']['iniciativas'] = $this->model->obtener_elementos_iniciativas($params);
		$config['data']['distribuidoras'] = $this->model->obtener_distribuidora_sucursal();

		$this->view($config);
	}

	public function lista_iniciativas()
	{
		$post = json_decode($this->input->post('data'), true);

		$fechas = explode('-', $post['txt-fechas']);
		$fechaIni = $fechas[0];
		$fechaFin = $fechas[1];
		$params = array(
			'fecIni' => $fechaIni, 'fecFin' => $fechaFin
		);

		$params['cuenta'] = $post['cuenta_filtro'];
		$params['proyecto'] = $post['proyecto_filtro'];
		$params['grupoCanal'] = $post['grupoCanal_filtro'];
		$params['canal']  = $post['canal_filtro'];
		$params['subcanal'] = $post['subcanal_filtro'];
		$params['foto'] = $post['conFoto'];
		$params['validado'] = $post['validado'];
		$params['habilitado'] = $post['habilitado'];

		$params['tipoUsuario'] = empty($post['tipoUsuario_filtro']) ? '' : $post['tipoUsuario_filtro'];
		$params['usuario'] = empty($post['usuario_filtro']) ? '' : $post['usuario_filtro'];

		$params['distribuidora'] = empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'];
		$params['zona'] = empty($post['zona_filtro']) ? '' : $post['zona_filtro'];
		$params['plaza'] = empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'];
		$params['cadena'] = empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'];
		$params['banner'] = empty($post['banner_filtro']) ? '' : $post['banner_filtro'];

		$params['externo'] = $this->session->userdata('externo');

		$elementos = "";
		if (!empty($post['idElemento'])) {
			if (is_array($post['idElemento'])) {
				$elementos = implode(",", $post['idElemento']);
			} else {
				$elementos = $post['idElemento'];
			}
		}
		$params['elementos'] = $elementos;

		$iniciativas = "";
		if (!empty($post['idIniciativa'])) {
			if (is_array($post['idIniciativa'])) {
				$iniciativas = implode(",", $post['idIniciativa']);
			} else {
				$iniciativas = $post['idIniciativa'];
			}
		}
		$params['iniciativas'] = $iniciativas;

		$distribuidoraSucursal = "";
		if (!empty($post['distribuidoraSucursal_filtro'])) {
			if (is_array($post['distribuidoraSucursal_filtro'])) {
				$distribuidoraSucursal = implode(",", $post['distribuidoraSucursal_filtro']);
			} else {
				$distribuidoraSucursal = $post['distribuidoraSucursal_filtro'];
			}
		}
		$params['distribuidoraSucursal'] = $distribuidoraSucursal;
		$array['iniciativas'] = $this->model->obtener_iniciativas($params);

		if (count($array['iniciativas']) < 1) {
			$result['result'] = 1;
			$result['data'] = getMensajeGestion('noRegistros');
		} else {
			$segmentacion = getSegmentacion($post);
			$array['segmentacion'] = $segmentacion;
			$result['result'] = 1;
			$result['data'] = $this->load->view("modulos/iniciativasSimple/lista_iniciativas", $array, true);
		}

		echo json_encode($result);
	}
}
