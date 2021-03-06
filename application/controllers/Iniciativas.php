<?php
class Iniciativas extends MY_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_iniciativas', 'model');
	}

	public function index(){
		$config = array();
		$config['nav']['menu_active'] = $idMenu = '85';
		$config['css']['style'] = array(
			'assets/libs/datatables/dataTables.bootstrap4.min',
			'assets/libs/datatables/buttons.bootstrap4.min',
			'assets/custom/css/iniciativas'
		);
		$config['js']['script'] = array(
			'assets/libs/fileDownload/jquery.fileDownload',
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/iniciativas'
		);

		$tabs = getTabPermisos(['idMenuOpcion' => $idMenu])->result_array();

		$config['data']['icon'] = 'fad fa-chart-pie';
		$config['data']['title'] = 'Iniciativas';
		$config['data']['message'] = 'Iniciativas';

		if (empty($tabs)) {
            $config['view'] = 'oops';
        } else {
            $config['view'] = 'modulos/iniciativas/index';
            $config['data']['tabs'] = $tabs;
        }

		$params = [];
		$params['cuenta'] = $this->sessIdCuenta;
		$params['proyecto'] = $this->sessIdProyecto;

		$config['data']['tipoUsuario'] = $this->model->obtener_tipos_usuarios($params);
		$config['data']['elementos'] = $this->model->obtener_elementos_visibilidad($params);
		$config['data']['iniciativas'] = $this->model->obtener_elementos_iniciativas($params);
		$config['data']['distribuidoras'] = $this->model->obtener_distribuidora_sucursal();

		$this->view($config);
	}

	public function lista_iniciativas(){
		ini_set('memory_limit','4096M');
		set_time_limit(0);

		$post = json_decode($this->input->post('data'), true);
		$input['status'] = '0';

		
		$fechas = explode('-', $post['txt-fechas']);
		$fechaIni = $fechas[0];
		$fechaFin = $fechas[1];
		$params = array(
			  'fecIni' => $fechaIni
			, 'fecFin' => $fechaFin
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

		$elementos="";
		if( !empty($post['idElemento'])){
			if( is_array($post['idElemento'])){
				$elementos=implode(",",$post['idElemento']);
			}else{
				$elementos=$post['idElemento'];
			}
		}
		$params['elementos'] = $elementos;

		$iniciativas = "";
		if( !empty($post['idIniciativa']) ){
			if( is_array($post['idIniciativa']) ){
				$iniciativas = implode(",", $post['idIniciativa']);
			}else{
				$iniciativas = $post['idIniciativa'];
			}
		}
		$params['iniciativas'] = $iniciativas;

		$distribuidoraSucursal="";
		if( !empty($post['distribuidoraSucursal_filtro'])){
			if( is_array($post['distribuidoraSucursal_filtro'])){
				$distribuidoraSucursal = implode(",",$post['distribuidoraSucursal_filtro']);
			}else{
				$distribuidoraSucursal = $post['distribuidoraSucursal_filtro'];
			}
		}
		$params['distribuidoraSucursal'] = $distribuidoraSucursal;
		$array['iniciativas'] = $this->model->obtener_iniciativas($params);
		
		 if( count($array['iniciativas']) < 1 ) {
			$result['result']=1;
			$html =getMensajeGestion('noRegistros');
		}
		else{
			$segmentacion = getSegmentacion($post);
			$array['segmentacion'] = $segmentacion;
			$result['result']=1;
			$html =$this->load->view("modulos/iniciativas/lista_iniciativas", $array, true);
		}
		$result['status'] = 1;
		$result['data']['views']['contentIniciativas']['datatable'] = 'tb-Iniciativas';
		$result['data']['views']['contentIniciativas']['html'] = $html;
		$result['data']['configTable'] =  [
			'targets' => [1],
			'ordering' => false
		];
		
		echo json_encode($result);
	}

	public function filtrarHsm(){
		$result = $this->result;
        $data = json_decode($this->input->post('data'));

		$array = [];
        $result['result'] = 1;
        $result['data']['views']['contentIniciativasHsm']['html'] = $this->load->view("modulos/iniciativas/listaIniciativasHsm", $array, true);
        $result['data']['views']['contentIniciativasHsm']['datatable'] = 'tb-iniciativasHsm';
        $result['data']['configTable'] = [];

        respuesta:
        echo json_encode($result);
	}

	public function editar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);

		$params = array(
			'idIniciativaDet' => $post['idIniciativaDet'],
			'idCuenta' => $this->sessIdCuenta
		);
		$array['iniciativas'] = $this->model->obtener_iniciativas_det($params);

		$array['estados'] = $this->model->obtener_estados();
		
		$result['result'] = 1;
		$result['data'] = $this->load->view("modulos/iniciativas/editar_iniciativas", $array, true);
		
		echo json_encode($result);
	}

	public function actualizar_iniciativas()
	{
		$post = json_decode($this->input->post('data'), true);
		$result = $this->result;

		$post['editar'] = [
			'presencia' => $post['sel-presencia'],
			'cantidad' => $post['txt-cantidad'],
			'idEstadoIniciativa' => verificarEmpty($post['sel-motivo'], 4),
			'editado' => 1
		];

		$result['result'] = $this->model->editarIniciativa($post)['status'];

		$result['msg']['title'] = 'Alerta!';
		$result['msg']['content'] = getMensajeGestion('actualizacionErronea');

		if ($result['result'] == true) {
			$result['msg']['title'] = 'Hecho!';
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		echo json_encode($result);
	}

	public function actualizar_estado_analista(){
		$post = json_decode($this->input->post('data'), true);
		$idIniciativaDet = $post['idIniciativaDet'];
		
		$estado_analista = $this->model->obtener_estado_validacion($idIniciativaDet);

		$estado = ($estado_analista[0]['validacion_analista']==1)?0:1;
		$editar = array(
			   'validacion_analista' => $estado
		);

		$this->db->where('idVisitaIniciativaTradDet', $idIniciativaDet );
		$this->db->update("{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet", $editar);
		
		$result['result']=1;
		$result['data']=$estado;
		
		echo json_encode($result);
	}

	public function inhabilitar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);
		$result = $this->result;

		$result['result'] = $this->model->actualizarIniciativa($post)['status'];

		$result['msg']['title'] = 'Alerta!';
		$result['msg']['content'] = getMensajeGestion('actualizacionErronea');

		if($result['result'] == true){
			$result['msg']['title'] = 'Hecho!';
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}
		
		echo json_encode($result); 
	}

	public function validar_iniciativas(){
		$post = json_decode($this->input->post('data'), true);
		$total = count($post);

		for($i=0; $i<$total;$i++){
			if(!empty($post[$i]['iniciativas'])){
				$editar = array(
					'validacion_ejecutivo' => 1
				);

				$this->db->where('idVisitaIniciativaTradDet',  $post[$i]['iniciativas'][0] );
				$this->db->update("{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet", $editar);
			}
		}

		$result['result']=1;
		$result['data']='SE ACTUALIZO CON EXITO.';
		
		echo json_encode($result); 
	}

	public function iniciativas_pdf(){
		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');

		$input = [];
		$post=json_decode($this->input->post('data'),true);
		$fecIni = $post['datos']['fecIni'];
		$fecFin = $post['datos']['fecFin'];

		$input['fecIni'] = $fecIni;
		$input['fecFin'] = $fecFin;

		$nombreArchivo = 'Iniciativas '.$fecIni.'-'.$fecFin.'.pdf';
		
		$filtro = "";

		$input['idIniciativaDet'] = implode(',', $post['datos']['idIniciativaDet']);

		$visitasTotal = $this->model->visitas_pdf($input);
		// $visitasTotal = $this->model->obtener_iniciativas($input);

		$www=base_url().'public/';
		$style="
		<style>
				.head {
					background-color:#1370C5;
					padding: 5px;
					font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
					font-size: 10px;
					width: 100%;
				}
				table{width: 100%;}
				.title { font-weight: bold; color: #FFFFFF !important; text-align: right; }
				img.foto{ border: 0.3em solid #0E7BEF; margin: 0.5em;}
				.item { 
					text-align: center;
					font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
					font-size: 12px;
				}
		</style>
		";
		$header = '<table class="head" >';
			$header .= '<tr>';
				$header .= '<td ><img src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/logos/pg.png" /></td>';
				$header .= '<td class="title" >INICIATIVAS</td>';
			$header .= '</tr>';
		$header .= '</table>';

		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$newPage = 0;
		
		if( count($visitasTotal)>400 ){

			$html='<br/><br/><br/><b>Se encontraron m??s de 400 registros. Tiene que filtrar mejor la informaci??n.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		} elseif( count($visitasTotal)>0 && count($visitasTotal)<400 ){
			$html = ''; $num=1; $cant=0;
			foreach($visitasTotal as $row){ 
				$presencia = ($row['presencia']=='1')? 'SI' : 'NO';
				$motivo = !empty($row['estadoIniciativa'])? $row['estadoIniciativa'] : '-';
				$cantidad = !empty($row['cantidad'])? $row['cantidad'] : '-'; 

				$html .= '<br /><br/>';
				$html .= '<table>';
					$html .= '<thead>';
						$html .= '<tr><th colspan="2" style="background-color:#CCC;">INFORMACI??N VISITA</th></tr>';
					$html .= '</thead>';
					$html .= '<tbody>';
						$html .= '<tr>';
							$html .= '<td>FECHA</td>';
							$html .= '<td style="font-weight:bold;">'.$row['fecha'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>HORA</td>';
							$html .= '<td style="font-weight:bold;">'.$row['hora'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>CANAL</td>';
							$html .= '<td style="font-weight:bold;">'.$row['grupoCanal'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>SUBCANAL</td>';
							$html .= '<td style="font-weight:bold;">'.$row['canal'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>POS</td>';
							$html .= '<td style="font-weight:bold;">'.$row['razonSocial'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>INICIATIVA</td>';
							$html .= '<td style="font-weight:bold;">'.$row['iniciativa'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>ELEMENTO</td>';
							$html .= '<td style="font-weight:bold;">'.$row['elementoIniciativa'].'</td>';
						$html .= '</tr>';
						$html .= '<tr>';
							$html .= '<td>PRESENCIA</td>';
							$html .= '<td style="font-weight:bold;">'.$presencia.'</td>';
						$html .= '</tr>';
						if($row['presencia']=='0'){
							$html .= '<tr>';
								$html .= '<td>MOTIVO</td>';
								$html .= '<td style="font-weight:bold;">'.$motivo.'</td>';
							$html .= '</tr>';
						}
						$html .= '<tr>';
							if(!empty($row['foto'])){
								$url = verificarUrlFotos($row['foto']) . 'iniciativa/'.$row['foto'];
								$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="'.$url.'" width="280" height="200" /></td>';
							} else {
								$html .= '<td colspan="2" style="text-align:center;"><img class="foto" src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/no_image_600x600.png" width="280" height="200" /></td>';
							}
							$html .= '</tr>';
					$html .= '</tbody>';
				$html .= '</table>';

				if($num%2==0) {
					$mpdf->SetHTMLHeader($header);
					$mpdf->setFooter('{PAGENO}');
					$mpdf->AddPage();
					$mpdf->WriteHTML($style);
					$mpdf->WriteHTML($html);

					$html = '';
				} else {
					$mpdf->SetHTMLHeader($header);
					$mpdf->setFooter('{PAGENO}');
					$mpdf->AddPage();
					$mpdf->WriteHTML($style);
					$mpdf->WriteHTML($html);

					$html = '';
				}

				$num++;
			}
		} else {

			$html='<br/><br/><br/><b>No se encontraron resultados para la consulta realizada.</b>';

			$mpdf->SetHTMLHeader($header);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->AddPage();
			$mpdf->WriteHTML($style);
			$mpdf->WriteHTML($html);
		}

		$mpdf->Output($nombreArchivo,'D');
	}

	public function obtener_usuarios(){
		$post = json_decode($this->input->post('data'), true);
		$idTipoUsuario= $post['idTipoUsuario'];

		$params = array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$params['idTipoUsuario']=$idTipoUsuario;

		$result=array();
		$rs_usuarios = $this->model->obtener_usuarios($params);
		$result['data']['usuarios'] = $rs_usuarios;
		$result['result']=1;
		echo json_encode($result);
	}

	public function actualizar_vigentes(){
		$post = json_decode($this->input->post('data'), true);
		$idTipoUsuario= $post['idTipoUsuario'];

		$params = array();
		$params['cuenta']=$this->session->userdata('idCuenta');
		$params['idTipoUsuario']=$idTipoUsuario;

		$result=array();
		$rs_usuarios = $this->model->obtener_usuarios($params);
		$result['data']['usuarios'] = $rs_usuarios;
		$result['result']=1;
		echo json_encode($result);
	}
}
