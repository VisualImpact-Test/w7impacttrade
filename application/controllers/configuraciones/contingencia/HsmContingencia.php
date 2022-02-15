<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class HsmContingencia extends MY_Controller{

	var $htmlResultado = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE LA INFORMACIÓN CORRECTAMENTE.</div>';
	var $htmlNoResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
	var $htmlButtons = 1;

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/contingencia/m_contingenciarutas','model');
	}

	function guardarAuditoria($table){
		$arrayAuditoria = array(
			'idUsuario' => $this->idUsuario
			,'accion' => 'INSERTAR'
			,'tabla' => $table
			,'sql' => $this->db->last_query()
		);
		guardarAuditoria($arrayAuditoria);
	}

	function generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, $moduloVisita){
		$mensajeRespuesta='';
		if ( $rowInsert > 0)
			$mensajeRespuesta .= getMensajeGestion('registroExitoso');

		if ( $rowUpdated > 0)
			$mensajeRespuesta .= getMensajeGestion('actualizacionExitosa');

		if ( $rowInsert==0 && $rowUpdated==0)
			$mensajeRespuesta .= $this->htmlNoResultado;
		
		//TRUE MODULO
		if ( $rowInsert>0 || $rowUpdated>0)
			$this->model->update_visita_modulo($idVisita, $moduloVisita);

		return $mensajeRespuesta;
	}

	function generarMensajeAlmacenanmientoFotos($rowInsertFotoError){
		$mensajeRespuesta='';
		if ( $rowInsertFotoError>0) {
			$mensajeRespuesta .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> VERIFICAR EL ALMACENAIENTO DE LAS FOTOS, PARECE QUE SE HA GENERADO UN INCONVENIENTE, CIERRE LA VENTANA DEL DETALLADO Y VUELVA A ABRIRLA PARA CORROBORAR EL ALMACENAMIENTO.</div>';
		}

		return $mensajeRespuesta;
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config = array();
		$config['nav']['menu_active'] = '64';
		$config['css']['style'] = array(
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/custom/css/configuraciones/contingencia/estilos'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/configuraciones/contingencia/rutas'
		);

		$config['data']['icon'] = 'fas fa-route';
		$config['data']['title'] = 'Contingencia Rutas';
		$config['data']['message'] = 'Lista de Visitas';
		$config['view'] = 'modulos/configuraciones/contingencia/rutas/index';

		$this->view($config);
	}
}