<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Validaciones extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/master/m_modulacion','model');
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style']=array(
			'assets/libs/dataTables-1.10.20/datatables',
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults'
			,'assets/custom/js/configuraciones/master/validacion'
		);
		
		$config['nav']['menu_active']='98';
		$config['data']['icon'] = 'fa fa-clock';
		$config['data']['title'] = 'VALIDACIONES';
		$config['data']['message'] = '';
		$config['view'] = 'modulos/configuraciones/master/validaciones/index';

		$this->view($config);
	}

	public function nuevo(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$data = json_decode($this->input->post('data'));

		$input = array();
		$array = array();
		$html = '';
		
		$result['result'] = 1;
		$sql = "
			SELECT 
				idSubCanal,nombre
			FROM 
				trade.subCanal 
		";

		$array['modulos'] = $this->db->query($sql)->result_array();
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.subCanal' ];

		$html = $this->load->view("modulos/configuraciones/master/validaciones/nuevo", $array, true);
		$result['data'] = $html;
		
		echo json_encode($result);
	} 
	
	public function editar(){
		$data = json_decode($this->input->post('data'));
		$idValidacion= $data->{'idValidacion'};
		$input = array();
		$array = array();
		$html = '';
		
		$result['result'] = 1;
		$sql = "
			SELECT 
				idSubCanal,nombre
			FROM 
				trade.subCanal 
		";
		$array['modulos'] = $this->db->query($sql)->result_array();
		
		$sql = "
			SELECT 
	*
FROM 
	{$this->sessBDCuenta}.trade.master_modulacion_validaciones v
	JOIN trade.subCanal sc
		ON sc.idSubCanal = v.idClienteTipo
		WHERE idValidacion=$idValidacion
		";
		$validacion = $this->db->query($sql)->result_array();
		$array['validacion'] = $validacion;
		$html = $this->load->view("modulos/configuraciones/master/validaciones/editar", $array, true);
		
		$result['data'] = $html;

		echo json_encode($result);
	} 
	
	public function filtrar(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$input = array();
		$fecha = explode('-',$data->{'fechas'});
		$input['fecha'] = $fecha[0];

		$sql = "
			SELECT 
	*
FROM 
	{$this->sessBDCuenta}.trade.master_modulacion_validaciones v
	JOIN trade.subCanal sc
		ON sc.idSubCanal = v.idClienteTipo
		";
		$validacion = $this->db->query($sql)->result_array();
		$html = '';

		if ( !empty($validacion) ) {
			$result['result'] = 1;
			$array = array();
		
			$array['validacion'] = $validacion;
			
			$html .= $this->load->view("modulos/configuraciones/master/validaciones/lista", $array, true);
			$result['data']['html'] = $html;
			$result['data']['datatable'] = 'tb-modulacion';
		} else {
			$html .= $this->htmlNoResultado;

			$result['data']['html'] = $html;
		}

		echo json_encode($result);
	}

	public function registrar_permiso(){
		$data = json_decode($this->input->post('data'));
		$idValidacion = isset($data->{'idValidacion'})?$data->{'idValidacion'}:'';
		$clientetipo = $data->{'clientetipo'};
		$mincategoria = $data->{'mincategoria'};
		$minelemento = $data->{'minelementos'};
		if($idValidacion==''){
		$insert_permiso = array(
			'idClienteTipo' => $clientetipo,
			'minCategorias' => $mincategoria,
			'minElementosOblig' => $minelemento,
			'fecIni'=> date("d/m/Y")
		);
		
		$this->db->insert("{$this->sessBDCuenta}.trade.master_modulacion_validaciones",$insert_permiso);
		$mensaje = 'SE REGISTRO CON EXITO.';
		}else{
			$data = array(
				'idClienteTipo' => $clientetipo,
				'minCategorias' => $mincategoria,
				'minElementosOblig' => $minelemento,
			);

			$this->db->where('idValidacion', $idValidacion);
			$this->db->update("{$this->sessBDCuenta}.trade.master_modulacion_validaciones", $data);
			$mensaje = 'SE ACTUALIZO CON EXITO.';
		}
		
		//RESULTADOS
		$result['data'] = $mensaje;
		$result['result'] = 1;
		echo json_encode($result);
		
	}
	
	public function registrar_modulacion(){
		$post=json_decode($this->input->post('data'),true);
		
		$idUsuario = $this->session->userdata('idUsuario');
		//print_r($post);exit;
		$fecIni = $post['fecIni'];
		$fecFin = $post['fecFin'];
		//$idGrupoCanal = $post['idGrupoCanal'];
		$total = count($post);
		for($i=0;$i<$total;$i++){
			if(isset($post[$i]['idCliente'])){
				$idCliente = $post[$i]['idCliente'];
				$total_elementos = count( $post[$i]['modulacion']);
				$total_categorias=0;
				$filtro_categoria = '';
				if($total_elementos>0){
					for($m=0;$m<$total_elementos;$m++){
						if($m==$total_elementos-1){
							$filtro_categoria.=$post[$i]['modulacion'][$m];
						}else{
							$filtro_categoria.=$post[$i]['modulacion'][$m].',';
						}
					}
					$sql = "SELECT DISTINCT idCategoria FROM trade.elementoVisibilidadTrad WHERE idElementoVis IN ( $filtro_categoria ) ";
					$categorias = $this->db->query($sql)->result();
					$total_categorias=count($categorias);
				}
				
				$params=array(
					  'fecIni'			=>	$fecIni //.'-'.$fecFin
					, 'fecFin'			=>	$fecFin
					, 'idCliente' 		=>	$idCliente
				);
				
				$result['result']=1;
				$idUsuario = $this->session->userdata('idUsuario');
					$clientes=$this->model->obtener_clientes($params);
					$idClienteTipo =$clientes[0]['subcanal'];
			
				$sql = "SELECT DISTINCT ISNULL(minCategorias,0) minCategorias, ISNULL(minElementosOblig,0) minElementosOblig FROM {$this->sessBDCuenta}.trade.master_modulacion_validaciones WHERE idClienteTipo = 1 AND General.dbo.fn_fechaVigente(fecIni,fecFin,'$fecIni','$fecFin')=1";
				$validaciones_carga = $this->db->query($sql)->result_array();

				$minCategorias=0;
				$minElementosOblig=0;
				if(count($validaciones_carga)>0){
					$minCategorias=$validaciones_carga[0]['minCategorias'];
					$minElementosOblig=$validaciones_carga[0]['minElementosOblig'];
				}
				$validacion_elementos=0;
				$validacion_categorias=0;
				//if($minElementosOblig!=0){
					if($minElementosOblig<=$total_elementos){
						$validacion_elementos=1;
					}
				//}
				
				//if($minCategorias!=0){
					if($minCategorias<=$total_categorias){
						$validacion_categorias=1;
					}
				//}
				$procesar_carga=0;
				if($validacion_categorias==1 && $validacion_elementos==1){
					$procesar_carga=1;
				}
				

				if($total_elementos>0 && $procesar_carga==1){

					
					$data_cliente = $this->db->query($sql)->row_array();
					$idCanal = $data_cliente['idCanal'];
					$validar_lista = "SELECT idListVisibilidad,count(*) OVER () total FROM {$this->sessBDCuenta}.trade.list_visibilidadTrad WHERE idCliente= $idCliente AND fecIni='".$fecIni."' AND fecFin = '".$fecFin."' ";
					$res_validacion = $this->db->query($validar_lista)->row_array();
					$total =$res_validacion['total'];
					if($total==0){
						$insert = array(
							  'idCliente'	 	=> $idCliente
							, 'fecIni' 			=> $fecIni
							, 'fecFin' 			=> $fecFin
							, 'idProyecto'		=> 2 
						);
						$this->db->insert("{$this->sessBDCuenta}.trade.list_visibilidadTrad",$insert);
						$id = $this->db->insert_id();
						for($j=0;$j<$total_elementos;$j++){
							$idElemento = $post[$i]['modulacion'][$j];
							$insert_elementos = array(
								  'idListVisibilidad' => $id
								, 'idElementoVis' => $idElemento
								, 'estado' => 2
							);
							$this->db->insert("{$this->sessBDCuenta}.trade.list_visibilidadTradDet",$insert_elementos);
						}
					}else{
						$id =$res_validacion['idListVisibilidad'];
						$delete = "delete from  {$this->sessBDCuenta}.trade.list_visibilidadTradDet WHERE idListVisibilidad=".$id;
						$this->db->query($delete);
						for($j=0;$j<$total_elementos;$j++){
							
							$idElemento = $post[$i]['modulacion'][$j];
							$insert_elementos = array(
								  'idListVisibilidad' => $id
								, 'idElementoVis' => $idElemento
								, 'estado' => 1
							);
							$this->db->insert("{$this->sessBDCuenta}.trade.list_visibilidadTradDet",$insert_elementos);
						}
						
					}
					$mensaje='Se registro data con exito.';
				}
				else{
					$mensaje='NO SE PROCESARON TODOS LOS CLIENTES DEBIDO A QUE NO TIENEN LAS CANTIDAD DE CATEGORIAS Y/O ELEMENTOS MINIMO.<br>LOS CLIENTE EN COLOR ROJO SON LOS PUNTOS NO PROCESADOS. <br>VALIDAR EN LA COLUMNA VALIDACIONES DEL REPORTE.';
				}
			}
		}
		
		$response = array( 'msg' => array('title' => 'Confirmacion', 'content' => $mensaje), 'data' => $mensaje, 'result' => 1);

		echo json_encode($response);
	}
	
}
?>