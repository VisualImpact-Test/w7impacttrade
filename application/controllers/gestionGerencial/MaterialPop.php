<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MaterialPop extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/M_materialpop','model');
	}

	public function index()
	{
		$config = array();
		$idMenu = '141';
		$config['nav']['menu_active'] = $idMenu;
		$config['css']['style'] = array(
			'assets/custom/css/gestionGerencial/iniciativas',
			'assets/libs/tableTools/datatables.min',

		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/materialpop'
		);

		$config['data']['icon'] = 'far fa-clipboard-list-check';
		$config['data']['title'] = 'Material POP';
		$config['data']['message'] = '';
		$config['view'] = 'modulos/gestionGerencial/MaterialPop/index';

		$params = array();
		$params['idCuenta'] = $this->session->userdata('idCuenta');

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
		$input['subcanal'] = $data->{'subcanal_filtro'};
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

		$input['departamento_filtro'] = !empty($data->{'departamento_filtro'}) ? $data->{'departamento_filtro'} : '' ;
		$input['provincia_filtro'] = !empty($data->{'provincia_filtro'}) ? $data->{'provincia_filtro'} : '' ;
		$input['distrito_filtro'] = !empty($data->{'distrito_filtro'}) ? $data->{'distrito_filtro'} : '' ;


		$rs_visitas = $this->model->obtener_visitas($input);

		$html = '';
		$array['visitas'] = $rs_visitas;
		$segmentacion = getSegmentacion($input);
		if(!empty($rs_visitas)){
			$array=array();
			$array['visitas'] = $rs_visitas;

			$rs_det=$this->model->obtener_detalle_material_pop($input);
			foreach($rs_det as $det){
				$array['materiales'][$det['idTipoMaterial']]=$det['tipoMaterial'];
				$array['elementos'][$det['idTipoMaterial']][$det['idMarca']]['nombre']=$det['marca'];
                $array['elementos'][$det['idTipoMaterial']][$det['idMarca']]['flagCompetencia'] = 0;
				$array['detalle'][$det['idVisita']][$det['idMarca']] = $det;
			}

			$rs_lista=$this->model->obtener_lista_elementos_material_pop($input);
			foreach($rs_lista as $list){
				$array['lista'][$list['idVisita']][$list['idMarca']]='1';
			}

			
			
			$array['segmentacion'] = $segmentacion;
			$html = $this->load->view("modulos/gestionGerencial/MaterialPop/detalle_material_pop",$array,true);
			$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		} else {
			$html = getMensajeGestion('noRegistros');
		}
		$result['data']['grupoCanal'] = $segmentacion['grupoCanal'];
		$result['result'] = 1;
		$result['data']['views']['idContentMaterialPop']['datatable'] = 'tb-material-pop';
		$result['data']['views']['idContentMaterialPop']['html'] = $html;
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
}
?>