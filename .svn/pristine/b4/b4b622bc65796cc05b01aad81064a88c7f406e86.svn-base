<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Promociones extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_promociones','model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '129';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
            'assets/custom/js/gestionGerencial/promociones'
		);

		$config['data']['icon'] = 'far fa-gift';
		$config['data']['title'] = 'Promociones';
		$config['data']['message'] = 'CheckList Productos';
		$config['view'] = 'modulos/gestionGerencial/promociones/index';

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');
		$elementos = $this->model->obtener_elementos($params);
		$meses = $this->model->obtener_meses();
		$anios = $this->model->obtener_anios();
		$empresas = $this->model->obtener_empresas();

		$config['data']['elementos'] = $elementos;
		$config['data']['idMenu'] = $idMenu;
		$config['data']['meses'] = $meses;
		$config['data']['anios'] = $anios;
		$config['data']['empresas'] = $empresas;

		$tabs = $this->model->get_tab_menu_opcion(['idMenuOpcion'=>$idMenu])->result_array();
		
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

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}

		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;

			$rs_det=$this->model->obtener_detalle_promociones($input);

			if(empty($rs_det)){
				$html = getMensajeGestion('noRegistros');
				$result['result'] = 0;
				$result['data']['views']['idContentPromociones']['datatable'] = 'tb-promociones';
				$result['data']['views']['idContentPromociones']['html'] = $html;
				goto respuesta;
			}
			foreach($rs_det as $det){
				$array['categorias'][$det['idTipoPromocion']]=$det['categoria'];
				$array['elementos'][$det['idTipoPromocion']][$det['idPromocion']]=$det['elemento'];
			}

			$rs_lista=$this->model->obtener_lista_promociones($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idPromocion']]='1';
			}

			$array['detalle'] = $rs_det;

			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/promociones/detalle_promociones",$array,true);
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentPromociones']['datatable'] = 'tb-promociones';
		$result['data']['views']['idContentPromociones']['html'] = $html;
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

	public function filtrar_aje()
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

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		if(isset( $data->{'idElemento'})){
			$elementos = $data->{'idElemento'};
			if(is_array($elementos)){
				$input['idElemento'] = implode(",",$elementos);
			}else{
				$input['idElemento'] = $elementos;
			}
		}
		
		$rs_visitas = $this->model->obtener_visitas_aje($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/promociones/detalle_promociones_aje",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentPromocionesAje']['datatable'] = 'tb-promociones';
		$result['data']['views']['idContentPromocionesAje']['html'] = $html;
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

	public function Filtrar_resumen_aje()
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

		$input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
		$input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
		$input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
		$input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
		$input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

		$input['mes_filtro'] = empty($data->{'mes_filtro'}) ? '' : $data->{'mes_filtro'};
		$input['anio_filtro'] = empty($data->{'anio_filtro'}) ? '' : $data->{'anio_filtro'};
		$input['empresa_filtro'] = empty($data->{'empresa_filtro'}) ? '' : $data->{'empresa_filtro'};
		$input['categoria_filtro'] = empty($data->{'categoria_filtro'}) ? '' : $data->{'categoria_filtro'};
		
		$rs_visitas = $this->model->obtener_visitas_resumen_aje($input);

		$html = '';
		$array['visitas'] = $rs_visitas;

		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;
			$segmentacion = getSegmentacion($input);
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/promociones/detalle_promociones_resumen_aje",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['result'] = 1;
		$result['data']['views']['idContentPromocionesAjeResumen']['datatable'] = 'tb-promociones-resumen';
		$result['data']['views']['idContentPromocionesAjeResumen']['html'] = $html;
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
		$result['data'] = $this->load->view("modulos/gestionGerencial/promociones/verFotos", $array, true);

		echo json_encode($result);
    }

	public function cargarCategorias()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$categorias = $this->model->obtener_categorias($post);

		$html = '';
		$html .= '<select class="form-control form-control-sm ui my_select2Full" name="categoria_filtro" id="categoria_filtro" patron="requerido">';
			$html .= htmlSelectOptionArray2(['query' => $categorias, 'id' => 'idCategoria', 'value' => 'categoria', 'title' => '-- Categoria --']);
		$html .= '</select>';

		$result['result'] = 1;
		$result['data']['htmlcategorias'] = $html;

		echo json_encode($result);
	}

}
?>