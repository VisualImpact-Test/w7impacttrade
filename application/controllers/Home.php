<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Home', 'model');
		$this->load->model('M_muro', 'm_muro');
	}
	
	public function index()
	{
		$estado = '';
			$query = $this->m_muro->estado([ 'idUsuario' => $this->idUsuario ]);
			if( !empty($query) ) $estado = $query[0]['estado'];

		$usuario=array();
        $usuario['idUsuario']=$this->session->userdata('idUsuario');
        $usuario['usuario']=$this->session->userdata('apeNom');
        $usuario['idTipoUsuario']=$this->session->userdata('idTipoUsuario');
        $usuario['tipoUsuario']=$this->session->userdata('tipoUsuario');
        $usuario['idCanal']=$this->session->userdata('idCanal');
        $usuario['idGrupoCanal']=$this->session->userdata('idGrupoCanal');
        $usuario['idBanner']=$this->session->userdata('idBanner');
		$usuario['idCadena']=$this->session->userdata('idCadena');
		

		$usuario['idCuenta']=null;
		$usuario['idProyecto']=null;
		$usuario['idGrupo']=null;
		$usuario_grupos=$this->m_muro->usuarioGrupos($this->session->userdata('idUsuario'))->result_array();
		if( count($usuario_grupos)==1){
			foreach($usuario_grupos as $row){
				$usuario['idCuenta']=$row['idCuenta'];
				$usuario['idProyecto']=$row['idProyecto'];
				$usuario['idGrupo']=$row['idGrupo'];
			}
		}

        $usuario['estado'] = $estado;
        $usuario['device'] = 'web';
		$config['data']['usuario'] = $usuario;

		$config['css']['style'] = [
				'assets/libs/datatables/dataTables.bootstrap4.min', 
				'assets/libs/datatables/buttons.bootstrap4.min',
				'assets/libs/MagnificPopup/magnific-popup',
				'assets/custom/css/rutas'
			];

		$config['js']['script'] = [
				'assets/libs/FancyZoom/FancyZoom',
				'assets/libs/FancyZoom/FancyZoomHTML',
				'assets/libs/datatables/datatables',
				'assets/libs/datatables/responsive.bootstrap4.min',
				'assets/custom/js/core/datatables-defaults',
				'assets/libs/MagnificPopup/jquery.magnific-popup.min',
				'assets/custom/js/home'
			];

		$config['view'] = 'home';		
		$config['nav']['menu_active']='home';

		$config['data']['icon']='fa fa-home';
		$config['data']['title']='Inicio';
		$config['data']['message']='Bienvenido al sistema, '.$this->session->userdata('nombres').' '.$this->session->userdata('ape_paterno');

		$config['data']['fotos'] = $this->model->get_latest_fotos()->result_array();

		$efectividad = $this->model->get_efectividad()->row_array();		
		$config['data']['efectividad'] = $efectividad;

		$this->view($config);
	}

	public function get_cobertura(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];

		$result = $this->result;
		$array = array();

		$cobertura = $this->model->get_cobertura()->row_array();
		$array['cobertura']= $cobertura;

		$result['data']['html']=$this->load->view("home/cobertura", $array, true);
		
		echo json_encode($result);

	}

	public function get_efectividad(){
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];

		$result = $this->result;
		$array = array();

		$efectividad = $this->model->get_efectividad()->row_array();
		$array['efectividad']= $efectividad;

		$result['data']['html']=$this->load->view("home/efectividad", $array, true);
		
		echo json_encode($result);

	}

	public function get_fotos(){
		$result = $this->result;
		$array = array();

		$fotos = $this->model->get_latest_fotos()->result_array();
		$array['fotos']= $fotos;

		if(count($fotos)){
			$result['data']['html']=$this->load->view("home/last_fotos", $array, true);
		}else{
			$result['data']['html']="<i class='fa fa-info-circle'></i> No hay fotos registradas el día de hoy.";
			// $result['data']['html'] = date('m');
		}
		
		echo json_encode($result);

	}

	public function mostrarMapa(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		//Datos Generales
		$type = $data->{'type'};

		$array = array();
		$array['cliente'] = $data->{'cliente'};
		$array['usuario'] = $data->{'usuario'};
		$array['perfil'] = $data->{'perfil'};
		$array['latitud']= $data->{'latitud'};
		$array['longitud']= $data->{'longitud'};
		$array['latitud_cliente']= $data->{'latitud_cliente'};
		$array['longitud_cliente']= $data->{'longitud_cliente'};
        //Result
        $result['result'] = 1;
		$result['msg']['title'] = 'GOOGLE MAPS';
		if ($type=='ini') { 
			$result['data'] = $this->load->view("modulos/rutas/verMapa_inicio", $array, true); 
		} elseif ($type=='fin') { 
			$result['data'] = $this->load->view("modulos/rutas/verMapa_fin", $array, true); 
		}

		echo json_encode($result);
	}

}
