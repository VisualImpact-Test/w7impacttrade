<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Muro extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('social/M_muro','model');
	}

	public function index(){
		$config = array();
		$config['nav']['menu_active']='106';
		$config['css']['style']=array('assets/libs/datatables/dataTables.bootstrap4.min', 'assets/libs/datatables/buttons.bootstrap4.min', 'assets/custom/css/social/muro');
		$config['js']['script'] = array('assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults','assets/custom/js/muro');

		$config['data']['icon'] = 'fa fa-chart-line';
		$config['data']['title'] = 'Red Visual';
		$config['data']['message'] = 'Red Visual';
        $config['view']='social/index';
        
        $usuario=array();
        $usuario['idUsuario']=$this->session->userdata('idUsuario');
        $usuario['usuario']=$this->session->userdata('apeNom');
        $usuario['idTipoUsuario']=$this->session->userdata('idTipoUsuario');
        $usuario['tipoUsuario']=$this->session->userdata('tipoUsuario');
        $usuario['idCanal']=$this->session->userdata('idCanal');
        $usuario['idGrupoCanal']=$this->session->userdata('idGrupoCanal');
        $usuario['idBanner']=$this->session->userdata('idBanner');
        $usuario['idCadena']=$this->session->userdata('idCadena');
        $usuario['idCuenta']="3";
        //$usuario['idCuenta']=$this->session->userdata('idCuenta');
        //$usuario['idProyecto']=$this->session->userdata('idProyecto');
        $usuario['idProyecto']="2";
		$config['data']['usuario'] = $usuario;
		$this->view($config);
	}

	public function publicaciones(){
		
        $result = $this->result;

        $usuario=array();
        $usuario['idUsuario']=$this->session->userdata('idUsuario');
        $usuario['usuario']=$this->session->userdata('apeNom');
        $usuario['idTipoUsuario']=$this->session->userdata('idTipoUsuario');
        $usuario['tipoUsuario']=$this->session->userdata('tipoUsuario');
        $usuario['idCanal']=$this->session->userdata('idCanal');
        $usuario['idGrupoCanal  ']=$this->session->userdata('idGrupoCanal ');
        $usuario['idBanner']=$this->session->userdata('idBanner');
        $usuario['idCadena']=$this->session->userdata('idCadena');
        $usuario['idCuenta']=$this->session->userdata('idCuenta');
        $usuario['idProyecto']=$this->session->userdata('idProyecto');

		$data = json_decode($this->input->post('data'));

		$input = array(); 
		echo json_encode($result);
    }	
    
    public function getFormNewPublicacion()
	{
		$result = $this->result;
		$result['msg']['title'] = "Nueva Publicacion";

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("social/formNewPublicacion", null, true);

		echo json_encode($result);
	}

}
?>