<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VerArchivos extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('gestionOperativa/M_VerArchivos', 'm_verArchivos');
		$this->carpetaArchivos = "C:/archivos/";
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];

		$config = array();
		$config['css']['style'] = [
			'assets/libs/jslists/jsLists',
			'assets/libs/datatables/dataTables.bootstrap4.min', 'assets/libs/datatables/buttons.bootstrap4.min'
		];
		$config['js']['script'] = [
			'assets/libs/jslists/jsLists',
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionOperativa/verArchivos',
		];

		$config['nav']['menu_active'] = '81';
		$config['data']['icon'] = 'fal fa-cabinet-filing';
		$config['data']['title'] = 'Fichero Web';
		$config['data']['message'] = 'Módulo para ver los archivos';
		$config['view'] = 'modulos/GestionOperativa/VerArchivos/index';

		$idUsuario = $this->idUsuario;
		$rs = $this->m_verArchivos->getFiles($idUsuario, 0)->result();

		$grupo = array();
		$folder = array();
		$archivos = array();
		foreach ($rs as $row) {
			$grupo[$row->idGrupo] = $row;
			$folder[$row->idGrupo][$row->idCarpeta] = $row;
			$archivos[$row->idGrupo][$row->idCarpeta][$row->idArchivo] = $row;
		}

		$config['nav']['menu_active']='81';
		$config['data']['grupo'] = $grupo;
		$config['data']['folder'] = $folder;
		$config['data']['archivos'] = $archivos;

		$this->view($config);
	}

	public function getRoot()
	{
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];

		$result = $this->result;

		$idUsuario = $this->idUsuario;
		$informacionUsuario = $this->m_verArchivos->getInformacionUsuario($idUsuario)->row_array();
		$nombreCompleto = $informacionUsuario['nombreCompleto'];

		$rs = $this->m_verArchivos->getFiles($idUsuario, 0)->result();

		$array = array();
		$result['result'] = 1;

		if (count($rs) > 0) {
			$grupo = array();
			$folder = array();
			$archivos = array();
			foreach ($rs as $row) {
				$array['grupo'][$row->idGrupo] = $row;
				$array['folder'][$row->idGrupo][$row->idCarpeta] = $row;
				$array['archivos'][$row->idGrupo][$row->idCarpeta][$row->idArchivo] = $row;
				$array['nombreCompleto'] = $nombreCompleto;
			}

			$result['data'] = $this->load->view('modulos/GestionOperativa/VerArchivos/root', $array, true);
		} else {
			$result['data'] = 'Usted no tiene permisos configurados, comuniquese con su analista comercial.';
		}

		echo json_encode($result);
	}

	public function getFolder()
	{
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];

		$result = $this->result;

		$idUsuario = $this->idUsuario;
		$rs = $this->m_verArchivos->getFiles($idUsuario, 0)->result();

		$array = array();
		$result['result'] = 1;

		if (count($rs) > 0) {
			$grupo = array();
			$folder = array();
			$archivos = array();
			foreach ($rs as $row) {
				$array['grupo'][$row->idGrupo] = $row;
				$array['folder'][$row->idGrupo][$row->idCarpeta] = $row;
				$array['archivos'][$row->idGrupo][$row->idCarpeta][$row->idArchivo] = $row;
			}
			//
			$result['data'] = $this->load->view('modulos/GestionOperativa/VerArchivos/folder', $array, true);
		} else {
			$result['data'] = 'Usted no tiene permisos configurados, comuniquese con su analista comercial.';
		}

		echo json_encode($result);
	}

	public function getFiles()
	{
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];

		$result = $this->result;
		$post = json_decode($this->input->post('data'));

		$idUsuario = $this->idUsuario;
		$idFolder = isset($post->folder) ? $post->folder : 0;
		$rs = $this->m_verArchivos->getFiles($idUsuario, $idFolder)->result();

		$array = array();
		$result['result'] = 1;

		if (count($rs) > 0) {
			$grupo = array();
			$folder = array();
			$archivos = array();
			foreach ($rs as $row) {
				$array['grupo'][$row->idGrupo] = $row;
				$array['folder'][$row->idGrupo][$row->idCarpeta] = $row;
				$array['archivos'][$row->idGrupo][$row->idCarpeta][$row->idArchivo] = $row;
			}

			$result['data'] = $this->load->view('modulos/GestionOperativa/VerArchivos/files', $array, true);
		} else {
			$result['data'] = 'Usted no tiene permisos configurados, comuniquese con su analista comercial.';
		}

		echo json_encode($result);
	}

	public function descargar()
	{
		$this->aSessTrack[] = [ 'idAccion' => 9 ];

		$post = json_decode($this->input->post('data'));

		$fileName = $post->name;
		$extension = "." . $post->extension;
		$file = basename($post->file . $extension);

		$carpeta = $this->carpetaArchivos;
		$carpeta .= $file;

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . $fileName . $extension);

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		header("Content-Transfer-Encoding: binary");

		readfile($carpeta);
		exit;
	}
}
