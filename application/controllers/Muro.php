<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muro extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('M_muro', 'm_muro');
	}

	public function index(){
		$estado = '';
			$query = $this->m_muro->estado([ 'idUsuario' => $this->idUsuario ]);
			if( !empty($query) ) $estado = $query[0]['estado'];

		$usuario = [
				'idUsuario' => $this->idUsuario,
				'idEmpleado' => $this->idEmpleado,
				'fotoEmpleado' => $this->foto,
				'nombres' => $this->session->userdata('nombres'),
				'apePaterno' => $this->session->userdata('apePaterno'),
				'apeMaterno' => $this->session->userdata('apeMaterno'),
				'cargo' => $this->session->userdata('cargo'),
				'unidad' => $this->session->userdata('unidad'),
				'usuario' => $this->session->userdata('apeNom'),
				'idTipoUsuario' => $this->session->userdata('idTipoUsuario'),
				'tipoUsuario' => $this->session->userdata('tipoUsuario'),
				'idCanal' => $this->session->userdata('idCanal'),
				'idGrupoCanal' => $this->session->userdata('idGrupoCanal'),
				'idBanner' => $this->session->userdata('idBanner'),
				'idCadena' => $this->session->userdata('idCadena'),


				'idCuenta' => null,
				'idProyecto' => null,
				'idGrupo' => null,
				'estado' => $estado,
				'device' => 'web'
			];


			$usuario_grupos=$this->m_muro->usuarioGrupos($this->session->userdata('idUsuario'))->result_array();
			if( count($usuario_grupos)==1){
				foreach($usuario_grupos as $row){
					$usuario['idCuenta']=$row['idCuenta'];
					$usuario['idProyecto']=$row['idProyecto'];
					$usuario['idGrupo']=$row['idGrupo'];
				}
			}
			

		$query_usuarioFiltroProyecto= $this->m_muro->usuarioFiltroProyecto($this->session->userdata('idUsuario'))->result_array();
		$usuarioFiltroProyecto=array();
		foreach($query_usuarioFiltroProyecto as $row){
			$usuarioFiltroProyecto[$row['idCuenta']]['cuenta']=$row['cuenta'];
			$usuarioFiltroProyecto[$row['idCuenta']]['idCuenta']=$row['idCuenta'];
			$usuarioFiltroProyecto[$row['idCuenta']]['proyectos'][$row['idProyecto']]['proyecto']=$row['proyecto'];
			$usuarioFiltroProyecto[$row['idCuenta']]['proyectos'][$row['idProyecto']]['idTipoUsuario']=$row['idTipoUsuario'];
			$usuarioFiltroProyecto[$row['idCuenta']]['proyectos'][$row['idProyecto']]['tipoUsuario']=$row['tipoUsuario'];
			$usuarioFiltroProyecto[$row['idCuenta']]['proyectos'][$row['idProyecto']]['idProyecto']=$row['idProyecto'];
		}
		
		$config = [
				'nav' => ['menu_active' => 'muro'],
				'view' => 'muro',
				'data' => [
						'usuario' => $usuario,
						'usuario_filtro' => $usuarioFiltroProyecto,
						'icon' => 'fas fa-bullhorn',
						'title' => 'Publicaciones',
						'message' => 'Bienvenido al área de publicaciones'
					],
				'css' => ['style' => [
						'assets/libs/jquery-ui/jquery-ui.min',
						'assets/libs/images-grid/images-grid',
						'assets/custom/css/muro'
					]],
				'js' => ['script' => [
						'assets/libs/jquery-ui/jquery-ui.min',
						'assets/libs/images-grid/images-grid',
						'assets/custom/js/muro'
					]]
			];		

		$this->view($config);
	}

	public function buscar(){
		$input = json_decode($this->input->post('data'), true);

		$query = [];
		if( $input['buscar'] == 'usuario' )
			$query = $this->m_muro->usuarios($input);
		else
			$query = $this->m_muro->lugares($input);

		$data = [];
		foreach($query as $v){
			array_push($data, [ 'id' => $v['id'], 'value' => $v['nombre'] ]);
		}

		echo json_encode($data);
	}

}