
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/administracion/M_Usuarios','m_usuarios');
		$this->load->model('M_control','m_control');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',
			'actualizarUsuarios' => 'Actualizar Usuarios',
			'registrarUsuarios' => 'Registrar Usuarios',
			'registrarUsuarioExterno' => 'Registrar Usuario Externo',
			'registrarUsuarioInterno' => 'Registrar Usuario Interno',
			'masivoUsuarios' => 'Guardar Masivo Usuarios',
			'editarHistoricoUsuarios' => 'Editar Históricos de Usuario',
			'editarHistoricoCanalUsuarios' => 'Editar Canales de histórico',
			'editarHistoricoZonaUsuarios' => 'Editar Zonas de histórico',
			'editarHistoricoPermisosMovilUsuarios' => 'Editar Permisos de Movil de histórico',
			'editarHistoricoPermisosIntranetUsuarios' => 'Editar Permisos de Intranet de histórico',
			'editarHistoricoDistribuidoraSucursalUsuarios' => 'Editar Distribuidoras Sucursales de histórico',
			'editarHistoricoPlazaUsuarios' => 'Editar Plazas de histórico',
		];
		$this->carpetaHtml = 'modulos/Configuraciones/Administracion/Usuarios/';

		$this->html = [
			'usuarios' => [
				'tabla' => $this->carpetaHtml .  'usuariosTabla',
				'new' => $this->carpetaHtml .  'usuariosFormNew',
				'update' => $this->carpetaHtml .  'usuariosFormUpdate',
				'cargaMasiva' => $this->carpetaHtml .  'usuariosFormCargaMasiva',
				'editarHistoricosDeUsuario' => $this->carpetaHtml .  'usuariosFormEditarHistoricosDeUsuario',
				'editarHistoricoDetalles' => $this->carpetaHtml .  'usuariosFormEditarHistoricoDetalles',
				'editarHistoricoCanal' => $this->carpetaHtml .  'usuariosFormEditarHistoricoCanal',
				'editarHistoricoZona' => $this->carpetaHtml .  'usuariosFormEditarHistoricoZona',
				'editarHistoricoPermivosMovil' => $this->carpetaHtml .  'usuariosFormEditarHistoricoPermisosMovil',
				'editarHistoricoPermisosIntranet' => $this->carpetaHtml .  'usuariosFormEditarHistoricoPermisosIntranet',
				'editarHistoricoPermisosCarpetas' => $this->carpetaHtml .  'usuariosFormEditarHistoricoPermisosCarpetas',
				'editarHistoricoBanner' => $this->carpetaHtml .  'usuariosFormEditarHistoricoBanner',
				'editarHistoricoDistribuidoraSucursal' => $this->carpetaHtml .  'usuariosFormEditarHistoricoDistribuidoraSucursal',
				'editarHistoricoPlaza' => $this->carpetaHtml .  'usuariosFormEditarHistoricoPlaza',
			],
		];
	}

	public function index()
	{
		
		$this->aSessTrack[] = ['idAccion' => 4];

		$config = array();
		$config['css']['style'] = [
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs/handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/configuraciones/administracion/usuarios',
		];

		$config['nav']['menu_active'] = '78';
		$config['data']['icon'] = 'fa fa-users';
		$config['data']['title'] = 'Usuarios';
		$config['data']['message'] = 'Módulo para administrar los usuarios.';

		$config['data']['tiposDeDocumento'] = $this->m_usuarios->getTiposDeDocumento()->result_array();
		$config['view'] = $this->carpetaHtml . 'index';

		$this->view($config);
	}

	public function cambiarEstado()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['cambiarEstado'];

		$post = json_decode($this->input->post('data'), true);

		$seccionActivo = $post['seccionActivo'];
		$ids = $post['ids'];
		$estado = ($post['estado'] == 0) ? 1 : 0;

		switch ($seccionActivo) {
			case 'Usuarios':
				$tabla = $this->m_usuarios->tablas['usuarios']['tabla'];
				$idTabla = $this->m_usuarios->tablas['usuarios']['id'];
				break;
		}

		$update = [];
		$actualDateTime = getActualDateTime();
		foreach ($ids as $id) {
			$update[] = [
				$idTabla => $id,
				'estado' => $estado,
				'fechaModificacion' => $actualDateTime
			];
		}

		$cambioEstado = $this->m_usuarios->actualizarMasivo($tabla, $update, $idTabla);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function cambiarActivo()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['cambiarEstado'];

		$post = json_decode($this->input->post('data'), true);

		$seccionActivo = $post['seccionActivo'];
		$ids = $post['ids'];
		$activo = ($post['activo'] == 0) ? 1 : 0;

		switch ($seccionActivo) {
			case 'Usuarios':
				$tabla = $this->m_usuarios->tablas['usuarios']['tabla'];
				$idTabla = $this->m_usuarios->tablas['usuarios']['id'];
				break;
		}

		$update = [];
		$actualDateTime = getActualDateTime();
		foreach ($ids as $id) {
			$update[] = [
				$idTabla => $id,
				'flag_activo' => $activo,
				'intentos' => 0
			];
		}

		$cambioEstado = $this->m_usuarios->actualizarMasivo($tabla, $update, $idTabla);

		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function getTablaUsuarios()
	{

		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'idCuenta' => ['selectRequerido'],
			'idProyecto' => ['selectRequerido'],
		];

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		$result['data']['validaciones'] = $validaciones;
		$result['data']['form'] = 'seccionUsuarios';
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$usuarios = $this->m_usuarios->getUsuarios($post)->result_array();
		$usuariosRefactorizados = [];
		foreach ($usuarios as $value) {
			$usuariosRefactorizados[$value['idUsuario']] = $value;
		}
		$resultados = $usuarios;
		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['usuarios']['tabla'], $dataParaVista, true);
		}

		responder:
		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function getFormNewUsuarios()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		//$dataExtra = json_decode($post['dataExtra'], true);
		//print_r($dataExtra);
		if(!empty($post['dataExtra'])){
			$dataParaVista['default'] = json_decode($post['dataExtra'], true);
			
			if($post['dataExtra']==1){
				$result['msg']['title'] = $this->titulo['registrarUsuarioInterno'];
			}elseif($post['dataExtra']==2){
				$result['msg']['title'] = $this->titulo['registrarUsuarioExterno'];
			}else{
				$dataParaVista['default'] = json_decode($post['dataExtra'], true);
				$result['msg']['title'] = $this->titulo['registrarUsuarioInterno'];
			}
		}else{
			$result['msg']['title'] = $this->titulo['registrarUsuarioExterno'];
		}
		$dataParaVista['tiposDeDocumento'] = $this->m_usuarios->getTiposDeDocumento()->result_array();
		$tiposDeUsuario = $this->m_usuarios->getTiposDeUsuario()->result_array();
		$tiposDeUsuarioRefactorizado = [];
		foreach ($tiposDeUsuario as $value) {
			$tiposDeUsuarioRefactorizado[$value['idCuenta']][$value['idTipoUsuario']]['idTipoUsuario'] = $value['idTipoUsuario'];
			$tiposDeUsuarioRefactorizado[$value['idCuenta']][$value['idTipoUsuario']]['tipoUsuario'] = $value['tipoUsuario'];
		}
		$dataParaVista['tiposDeUsuario'] = $tiposDeUsuarioRefactorizado;

		$dataParaVista['cuentas'] = $this->m_usuarios->getCuentas()->result_array();

		$aplicaciones = $this->m_usuarios->getAplicaciones()->result_array();
		$aplicacionesRefactorizado = [];
		foreach ($aplicaciones as $value) {
			$aplicacionesRefactorizado[$value['idCuenta']][$value['idAplicacion']]['idAplicacion'] = $value['idAplicacion'];
			$aplicacionesRefactorizado[$value['idCuenta']][$value['idAplicacion']]['nombre'] = $value['nombre'];
		}
		$dataParaVista['aplicaciones'] = $aplicacionesRefactorizado;

		$proyectos = $this->m_usuarios->getProyectos()->result_array();
		$proyectosRefactorizado = [];
		foreach ($proyectos as $value) {
			$proyectosRefactorizado[$value['idCuenta']][$value['idProyecto']]['idProyecto'] = $value['idProyecto'];
			$proyectosRefactorizado[$value['idCuenta']][$value['idProyecto']]['nombre'] = $value['nombre'];
		}
		$dataParaVista['proyectos'] = $proyectosRefactorizado;

		$result['result'] = 1;
		$result['data']['width'] = '50%';
		$result['data']['html'] = $this->load->view($this->html['usuarios']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function registrarUsuarios()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['registrarUsuarios'];

		$post = json_decode($this->input->post('data'), true);
		$tieneEncargado = !empty($post['tieneEncargado']) && $post['tieneEncargado'] == 1;
		$esExterno = $post['externo'] == 2;
		$seleccionoTipoDeDocumento = !empty($post['tipoDocumento']);
		$documentoRepetido = false;

		//VALIDACIONES BASICAS
		$elementosAValidar = [
			'nombres' => ['requerido'],
			'apePaterno' => ['requerido'],
			// 'apeMaterno' => ['requerido'],
			'email' => ['requerido', 'email'],
			// 'tipoDocumento' => ['selectRequerido'],
			// 'numDocumento' => ['requerido', 'numerico'],
			'usuario' => ['requerido'],
			'clave' => ['requerido', 'claveOchoDigitosAlfanumerico'],
			'aplicacionHistorico' => ['selectRequerido'],
			'cuentaHistorico' => ['selectRequerido'],
			'proyectoHistorico' => ['selectRequerido'],
			'tipoUsuarioHistorico' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
		];
		if ($tieneEncargado) $elementosAValidar['idUsuarioSuperior'] = ['requerido'];
		if($seleccionoTipoDeDocumento || !$esExterno){
			$elementosAValidar['numDocumento'] = ['requerido', 'numerico'];
			$elementosAValidar['tipoDocumento'] = ['requerido'];
		}else{
			$elementosAValidar['numDocumento'] = [];
			$elementosAValidar['tipoDocumento'] = [];
		}
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		//VALIDACIONES CON DB
		if($esExterno){
			if ($this->m_usuarios->checkNumDocumentoRepetido($post)){
				$validaciones['numDocumento'][] = 'Ya existe un usuario con el mismo número de documento.';
				$documentoRepetido = true;
			}
			if(!$documentoRepetido && $esExterno){
				if ($this->m_usuarios->checkNumDocumentoRepetidoEnRRHH($post)){
					$validaciones['numDocumento'][] = 'Ya existe un colaborador con el mismo documento en RRHH, busque el colaborador en la cuenta correspondiente y finalice la creación de su usuario.';
				}
			}
		}
		
		if ($this->m_usuarios->checkUsuarioRepetido($post)) $validaciones['usuario'][] = 'Ya existe un registro con el mismo usuario.';
		if ($this->m_usuarios->checkEmailRepetido($post)) $validaciones['email'][] = 'Ya existe un registro con el mismo email.';

		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$registroUsuario = $this->m_usuarios->registrarUsuario($post);
		$post['idUsuario'] = $this->m_usuarios->insertId;
		$registroHistorico = $this->m_usuarios->registrarHistorico($post);
		$post['idUsuarioHistorico'] = $this->m_usuarios->insertId;
		$registroPermisos = $this->m_usuarios->registraPermisosIniciales($post);

		if ($tieneEncargado) $insert = $this->m_usuarios->agregarEncargado($post);
		
		if (!$registroUsuario || !$registroHistorico || !$registroPermisos) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();
		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateUsuarios()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarUsuarios'];
		$post = json_decode($this->input->post('data'), true);
		$idUsuario = $post['id']; 

		$dataParaVista = [];
		$dataParaVista['usuario'] = $this->m_usuarios->getDatosDeUsuario($idUsuario)->row_array();
		$dataParaVista['tiposDeDocumento'] = $this->m_usuarios->getTiposDeDocumento()->result_array();
		$dataParaVista['subordinados'] = $this->m_usuarios->getSubordinados($idUsuario)->result_array();
		$dataParaVista['encargado'] = $this->m_usuarios->getEncargado($idUsuario)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '50%';
		$result['data']['html'] = $this->load->view($this->html['usuarios']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarUsuarios()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarUsuarios'];
		$post = json_decode($this->input->post('data'), true);
		$tieneEncargado = !empty($post['tieneEncargado']) && $post['tieneEncargado'] == 1;
		$esExterno = $post['externo'] == 1;
		$seleccionoTipoDeDocumento = !empty($post['tipoDocumento']);
		$documentoRepetido = false;
		$update = true;
		$insert = true;
		$delete = true;

		//VALIDACIONES BASICAS
		$elementosAValidar = [
			'nombres' => ['requerido'],
			'apePaterno' => ['requerido'],
			// 'apeMaterno' => ['requerido'],
			'email' => ['requerido', 'email'],
			// 'tipoDocumento' => ['selectRequerido'],
			// 'numDocumento' => ['requerido', 'numerico'],
			'usuario' => ['requerido'],
			'clave' => ['requerido', 'claveOchoDigitosAlfanumerico'],
		];
		if ($tieneEncargado) $elementosAValidar['idUsuarioSuperior'] = ['requerido'];
		if($seleccionoTipoDeDocumento || !$esExterno){
			$elementosAValidar['numDocumento'] = ['requerido', 'numerico'];
			$elementosAValidar['tipoDocumento'] = ['requerido'];
		}else{
			$elementosAValidar['numDocumento'] = [];
			$elementosAValidar['tipoDocumento'] = [];
		}

		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		//VALIDACIONES CON DB
		// if ($this->m_usuarios->checkNumDocumentoRepetido($post)){
		// 	$validaciones['numDocumento'][] = 'Ya existe un usuario con el mismo número de documento.';
		// 	$documentoRepetido = true;
		// }
		// if(!$documentoRepetido && $esExterno){
		// 	if ($this->m_usuarios->checkNumDocumentoRepetidoEnRRHH($post)){
		// 		$validaciones['numDocumento'][] = 'Ya existe un colaborador con el mismo documento en RRHH, busque el colaborador en la cuenta correspondiente y finalice la creación de su usuario.';
		// 	}
		// }
		
		if ($this->m_usuarios->checkUsuarioRepetido($post)) $validaciones['usuario'][] = 'Ya existe un registro con el mismo usuario.';
		if ($this->m_usuarios->checkEmailRepetido($post)) $validaciones['email'][] = 'Ya existe un registro con el mismo email.';

		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$update = $this->m_usuarios->actualizarUsuario($post);
		$delete = $this->m_usuarios->eliminarSubordinado($post);
		if ($tieneEncargado) $insert = $this->m_usuarios->agregarEncargado($post);

		if (!$update || !$delete || !$insert) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function getFormEditarHistoricosDeUsuario()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarUsuarios'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['idUsuario'] = $post['id'];
		$dataParaVista['historicos'] = $this->m_usuarios->getHistoricos($post)->result_array();
		$tiposDeUsuario = $this->m_usuarios->getTiposDeUsuario()->result_array();
		$tiposDeUsuarioRefactorizado = [];
		foreach ($tiposDeUsuario as $value) {
			$tiposDeUsuarioRefactorizado[$value['idCuenta']][$value['idTipoUsuario']]['idTipoUsuario'] = $value['idTipoUsuario'];
			$tiposDeUsuarioRefactorizado[$value['idCuenta']][$value['idTipoUsuario']]['tipoUsuario'] = $value['tipoUsuario'];
		}
		$dataParaVista['tiposDeUsuario'] = $tiposDeUsuarioRefactorizado;

		$idTipoUsuario = $this->idTipoUsuario;
		if(!empty($idTipoUsuario) && $idTipoUsuario == ID_TIPOUSUARIO_TI){
			$dataParaVista['cuentas'] = $this->m_usuarios->getCuentas()->result_array();
		}else {
			$dataParaVista['cuentas'] = $this->m_control->get_cuenta();
		}

		$aplicaciones = $this->m_usuarios->getAplicaciones()->result_array();
		$aplicacionesRefactorizado = [];
		foreach ($aplicaciones as $value) {
			$aplicacionesRefactorizado[$value['idCuenta']][$value['idAplicacion']]['idAplicacion'] = $value['idAplicacion'];
			$aplicacionesRefactorizado[$value['idCuenta']][$value['idAplicacion']]['nombre'] = $value['nombre'];
		}
		$dataParaVista['aplicaciones'] = $aplicacionesRefactorizado;

		$proyectos = $this->m_usuarios->getProyectos()->result_array();
		$proyectosRefactorizado = [];
		foreach ($proyectos as $value) {
			$proyectosRefactorizado[$value['idCuenta']][$value['idProyecto']]['idProyecto'] = $value['idProyecto'];
			$proyectosRefactorizado[$value['idCuenta']][$value['idProyecto']]['nombre'] = $value['nombre'];
		}
		$dataParaVista['proyectos'] = $proyectosRefactorizado;

		$class = 'formEditarHistoricosDeUsuario';
		$dataParaVista['class'] = $class;
		$result['result'] = 1;
		$result['data']['width'] = '60%';
		$result['data']['class'] = $class;
		$result['data']['html'] = $this->load->view($this->html['usuarios']['editarHistoricosDeUsuario'], $dataParaVista, true);

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function registrarHistoricoUsuario()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarUsuarios'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'aplicacionHistorico' => ['selectRequerido'],
			'cuentaHistorico' => ['selectRequerido'],
			'proyectoHistorico' => ['selectRequerido'],
			'tipoUsuarioHistorico' => ['selectRequerido'],
			'fechaInicio' => ['requerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		if ($this->m_usuarios->checkUsuarioHistoricoActivoRepetido($post)) {
			$mensajeRepetidoActivo = "Ya existe un historico activo de este usuario con el mismo proyecto,aplicacion y tipo de usuario";
			$validaciones['proyectoHistorico'][] = $mensajeRepetidoActivo;
			$validaciones['aplicacionHistorico'][] = $mensajeRepetidoActivo;
			$validaciones['tipoUsuarioHistorico'][] = $mensajeRepetidoActivo;
		}

		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');

			goto responder;
		}

		$registro = $this->m_usuarios->registrarHistorico($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		responder:
		$this->db->trans_complete();

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function getFormEditarHistorico()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$menu = $post['menu'];
		$dataParaVista['menu'] = $menu;
		$dataParaVista['idUsuarioHistorico'] = $post['idUsuarioHistorico'];
		$dataParaVista['idUsuario'] = $post['idUsuario'];
		$dataParaVista['idProyecto'] = $post['idProyecto'];
		$dataParaVista['idAplicacion'] = $post['idAplicacion'];

		switch ($menu) {
			case 'Detalles':
				$titulo = 'Actualizar Histórico';
				$width = '50%';
				$html = $this->html['usuarios']['editarHistoricoDetalles'];
				$dataParaVista['historico'] = $this->m_usuarios->getHistoricos($post)->row_array();
				break;

			case 'Canal':
				$titulo = 'Actualizar Canales';
				$width = '70%';
				$html = $this->html['usuarios']['editarHistoricoCanal'];
				$dataParaVista['canalesDeHistorico'] = $this->m_usuarios->getGrupoCanalYCanalDeHistorico($post)->result_array();
				$grupoCanalYCanal = $this->m_usuarios->getGrupoCanalYCanal($post)->result_array();
				$canales = [];
				$grupoCanales = [];
				foreach ($grupoCanalYCanal as $value) {
					$grupoCanales[$value['idGrupoCanal']]['idGrupoCanal'] = $value['idGrupoCanal'];
					$grupoCanales[$value['idGrupoCanal']]['grupoCanal'] = $value['grupoCanal'];
					$canales[$value['idGrupoCanal']][$value['idCanal']]['idCanal'] = $value['idCanal'];
					$canales[$value['idGrupoCanal']][$value['idCanal']]['canal'] = $value['canal'];
				}
				$dataParaVista['grupoCanales'] = $grupoCanales;
				$dataParaVista['canales'] = $canales;
				break;

			case 'Zona':
				$titulo = 'Actualizar Zonas';
				$width = '50%';
				$html = $this->html['usuarios']['editarHistoricoZona'];
				$dataParaVista['zonasDeHistorico'] = array_column($this->m_usuarios->getZonasDeHistorico($post)->result_array(), 'idZona');
				$dataParaVista['zonas'] = $this->m_usuarios->getZonas($post)->result_array();
				break;

			case 'PermisosMovil':
				$titulo = 'Actualizar Permisos de Móvil';
				$width = '50%';
				$html = $this->html['usuarios']['editarHistoricoPermivosMovil'];
				$post['idTipoUsuario'] = $this->m_usuarios->getHistoricos($post)->row_array()['idTipoUsuario'];
				$dataParaVista['modulosDeMovilDeUsuario'] = array_column($this->m_usuarios->getModulosMovilDeUsuario($post)->result_array(), 'idModulo');
				$dataParaVista['modulosDeMovil'] = $this->m_usuarios->getModulosMovil($post)->result_array();

				break;

			case 'PermisosIntranet':
				$titulo = 'Actualizar Permisos de Intranet';
				$width = '50%';
				$html = $this->html['usuarios']['editarHistoricoPermisosIntranet'];
				$dataParaVista['modulosDeIntranetDeUsuario'] = array_column($this->m_usuarios->getModulosIntranetDeUsuario($post)->result_array(), 'idMenuOpcion');
				$menusYGrupoMenus = $this->m_usuarios->getMenusYGrupoMenus()->result_array();
				$grupoMenus = [];
				$menuOpciones = [];
				foreach ($menusYGrupoMenus as $key => $value) {
					$grupoMenus[$value['idGrupoMenu']]['idGrupoMenu'] = $value['idGrupoMenu'];
					$grupoMenus[$value['idGrupoMenu']]['grupoMenu'] = $value['grupoMenu'];
					$menuOpciones[$value['idGrupoMenu']][$value['idMenuOpcion']]['idMenuOpcion'] = $value['idMenuOpcion'];
					$menuOpciones[$value['idGrupoMenu']][$value['idMenuOpcion']]['menuOpcion'] = $value['nombre'];
					$menuOpciones[$value['idGrupoMenu']][$value['idMenuOpcion']]['icono'] = !empty($value['icono']) ?  $value['icono'] : '' ;
				}
				$dataParaVista['grupoMenus'] = $grupoMenus;
				$dataParaVista['menuOpciones'] = $menuOpciones;
				break;

			case 'PermisosCarpetas':
				$titulo = 'Actualizar Permisos de Carpetas';
				$width = '50%';
				$html = $this->html['usuarios']['editarHistoricoPermisosCarpetas'];
				$dataParaVista['carpetasDeUsuario'] = array_column($this->m_usuarios->getCarpetasDeUsuario($post)->result_array(), 'idCarpeta');
				$gruposYCarpetas = $this->m_usuarios->getGruposYCarpetas()->result_array();
				$grupos = [];
				$carpetas = [];
				foreach ($gruposYCarpetas as $value) {
					$grupos[$value['idGrupo']]['idGrupo'] = $value['idGrupo'];
					$grupos[$value['idGrupo']]['nombreGrupo'] = $value['nombreGrupo'];
					$carpetas[$value['idGrupo']][$value['idCarpeta']]['idCarpeta'] = $value['idCarpeta'];
					$carpetas[$value['idGrupo']][$value['idCarpeta']]['nombreCarpeta'] = $value['nombreCarpeta'];
				}
				$dataParaVista['grupos'] = $grupos;
				$dataParaVista['carpetas'] = $carpetas;
				break;

			case 'Banner':
				$titulo = 'Actualizar Segmentación Moderno';
				$width = '70%';
				$html = $this->html['usuarios']['editarHistoricoBanner'];
				$dataParaVista['bannersDeHistorico'] = $this->m_usuarios->getCadenaYBannerDeHistorico($post)->result_array();
				$cadenaYBanner = $this->m_usuarios->getCadenaYBanner($post)->result_array();
				$cadenas = [];
				$banners = [];
				foreach ($cadenaYBanner as $value) {
					$cadenas[$value['idCadena']]['idCadena'] = $value['idCadena'];
					$cadenas[$value['idCadena']]['nombreCadena'] = $value['nombreCadena'];
					$banners[$value['idCadena']][$value['idBanner']]['idBanner'] = $value['idBanner'];
					$banners[$value['idCadena']][$value['idBanner']]['nombreBanner'] = $value['nombreBanner'];
				}
				$dataParaVista['cadenas'] = $cadenas;
				$dataParaVista['banners'] = $banners;
				break;

			case 'DistribuidoraSucursal':
				$titulo = 'Actualizar Segmentación Tradicional';
				$width = '70%';
				$html = $this->html['usuarios']['editarHistoricoDistribuidoraSucursal'];
				$dataParaVista['distribuidorasSucursalesDeHistorico'] = $this->m_usuarios->getDistribuidorasSucursalesDeHistorico($post)->result_array();
				$distribuidorasSucursales = $this->m_usuarios->getDistribuidorasSucursales($post)->result_array();
				$distribuidoras = [];
				$sucursales = [];
				foreach ($distribuidorasSucursales as $value) {
					$distribuidoras[$value['idDistribuidora']]['idDistribuidora'] = $value['idDistribuidora'];
					$distribuidoras[$value['idDistribuidora']]['distribuidora'] = $value['distribuidora'];
					$sucursales[$value['idDistribuidora']][$value['idDistribuidoraSucursal']]['idDistribuidoraSucursal'] = $value['idDistribuidoraSucursal'];
					$sucursales[$value['idDistribuidora']][$value['idDistribuidoraSucursal']]['distribuidoraSucursal'] = $value['distribuidoraSucursal'];
				}
				$dataParaVista['distribuidoras'] = $distribuidoras;
				$dataParaVista['sucursales'] = $sucursales;
				break;

			case 'Plaza':
				$titulo = 'Actualizar Segmentación Mayorista';
				$width = '70%';
				$html = $this->html['usuarios']['editarHistoricoPlaza'];
				$dataParaVista['plazasDeHistorico'] = $this->m_usuarios->getPlazasDeHistorico($post)->result_array();
				$dataParaVista['plazas'] = $this->m_usuarios->getPlazas($post)->result_array();
				break;
		}

		$class = 'formEditarHistorico';
		$dataParaVista['class'] = $class;

		$result['result'] = 1;
		$result['msg']['title'] = $titulo;
		$result['data']['width'] = $width;
		$result['data']['class'] = $class;
		$result['data']['html'] = $this->load->view($html, $dataParaVista, true);

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarDatosDeHistorico()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$menu = $post['menu'];
		$idUsuarioHistorico = !empty($post['idUsuarioHistorico']) ? $post['idUsuarioHistorico'] : '';
		$idUsuario = !empty($post['idUsuario']) ? $post['idUsuario'] : '';
		$multiDataRefactorizada = getDataRefactorizadaMulti($post);
		$delete = true;
		$update = true;
		$insert = true;

		switch ($menu) {
			case 'Detalles':
				$titulo = 'Actualizar Histórico';
				$update = $this->m_usuarios->actualizarHistorico($post);
				break;

			case 'Canal':
				$titulo = 'Actualizar Canales';
				$elementosAValidar = [
					'grupoCanal' => ['selectRequerido'],
					'canal' => ['selectRequerido']
				];
				$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);

				//LOGICA DE VALIDACIONES ESPECIALES

				$validaciones = validacionesMultiToSimple($validacionesMulti);
				$result['data']['validaciones'] = $validaciones;
				if (!verificarSeCumplenValidaciones($validaciones)) {
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
					break;
				}

				//BORRAR
				if (!empty($post['elementosEliminados'])) {
					$elementosEliminados = $post['elementosEliminados'];
					if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
					$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['historicoCanal']['tabla'], $this->m_usuarios->tablas['historicoCanal']['id'], $elementosEliminados);
				}
				//UPDATE
				$update = $this->m_usuarios->actualizarMasivoHistoricoCanal($multiDataRefactorizada);
				//INSERT
				$insert = $this->m_usuarios->guardarMasivoHistoricoCanal($multiDataRefactorizada, $idUsuarioHistorico);
				break;

			case 'Zona':
				$titulo = 'Actualizar Zonas';
				if (empty($post['zonas'])) $post['zonas'] = [];
				if (!is_array($post['zonas'])) $post['zonas'] = [$post['zonas']];
				$zonas = $post['zonas'];
				$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['historicoZona']['tabla'], 'idUsuarioHist', [$idUsuarioHistorico]);
				$insert = $this->m_usuarios->guardarMasivoHistoricoZonas($zonas, $idUsuarioHistorico);
				break;

			case 'PermisosMovil':
				$titulo = 'Actualizar Permisos Móvil';
				if (empty($post['modulosMovil'])) $post['modulosMovil'] = [];
				if (!is_array($post['modulosMovil'])) $post['modulosMovil'] = [$post['modulosMovil']];
				$modulosMovil = $post['modulosMovil'];
				$delete = $this->m_usuarios->deletePermisosMovil($post);
				$insert = $this->m_usuarios->guardarMasivoModulosMovil($modulosMovil, $idUsuario);
				$this->m_usuarios->actualizar_flag_nuevo($idUsuario);
				break;

			case 'PermisosIntranet':
				$titulo = 'Actualizar Permisos de Intranet';
				if (empty($post['menuOpcion'])) $post['menuOpcion'] = [];
				if (!is_array($post['menuOpcion'])) $post['menuOpcion'] = [$post['menuOpcion']];
				$modulosIntranet = $post['menuOpcion'];
				$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['modulosIntranet']['tabla'], 'idUsuario', [$idUsuario]);
				$insert = $this->m_usuarios->guardarMasivoModulosIntranet($modulosIntranet, $idUsuario);
				$this->m_usuarios->actualizar_flag_nuevo($idUsuario);
				break;

			case 'PermisosCarpetas':
				$titulo = 'Actualizar Permisos de Carpetas';
				if (empty($post['idCarpeta'])) $post['idCarpeta'] = [];
				if (!is_array($post['idCarpeta'])) $post['idCarpeta'] = [$post['idCarpeta']];
				$idsCarpetas = $post['idCarpeta'];
				$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['permisosCarpetas']['tabla'], 'idUsuario', [$idUsuario]);
				$post['idsCarpetas'] = $idsCarpetas;
				$post['idUsuarioCreador'] = $this->idUsuario;
				$post['ipUsuarioCreador'] = getIp();
				$insert = $this->m_usuarios->guardarMasivoPermisosCarpetas($post);
				break;

			case 'Banner':
				$titulo = 'Actualizar Segmentación Moderno';
				$elementosAValidar = [
					'cadena' => ['selectRequerido'],
					'banner' => ['selectRequerido'],
				];
				$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);

				//LOGICA DE VALIDACIONES ESPECIALES - FALTA

				$validaciones = validacionesMultiToSimple($validacionesMulti);
				$result['data']['validaciones'] = $validaciones;
				if (!verificarSeCumplenValidaciones($validaciones)) {
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
					break;
				}

				if (!empty($post['elementosEliminados'])) {
					$elementosEliminados = $post['elementosEliminados'];
					if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
					$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['historicoBanner']['tabla'], $this->m_usuarios->tablas['historicoBanner']['id'], $elementosEliminados);
				}
				$update = $this->m_usuarios->actualizarMasivoHistoricoBanner($multiDataRefactorizada);
				$insert = $this->m_usuarios->guardarMasivoHistoricoBanner($multiDataRefactorizada, $idUsuarioHistorico);
				break;

			case 'DistribuidoraSucursal':
				$titulo = 'Actualizar Segmentación Tradicional';
				$elementosAValidar = [
					'distribuidora' => ['selectRequerido'],
					'sucursal' => ['selectRequerido'],
				];
				$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);

				//LOGICA DE VALIDACIONES ESPECIALES - FALTA

				$validaciones = validacionesMultiToSimple($validacionesMulti);
				$result['data']['validaciones'] = $validaciones;
				if (!verificarSeCumplenValidaciones($validaciones)) {
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
					break;
				}

				if (!empty($post['elementosEliminados'])) {
					$elementosEliminados = $post['elementosEliminados'];
					if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
					$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['historicoDistribuidoraSucursal']['tabla'], $this->m_usuarios->tablas['historicoDistribuidoraSucursal']['id'], $elementosEliminados);
				}
				$update = $this->m_usuarios->actualizarMasivoHistoricoDistribuidoraSucursal($multiDataRefactorizada);
				$insert = $this->m_usuarios->guardarMasivoHistoricoDistribuidoraSucursal($multiDataRefactorizada, $idUsuarioHistorico);
				break;

			case 'Plaza':
				$titulo = 'Actualizar Segmentación Mayorista';
				$elementosAValidar = [
					'plaza' => ['selectRequerido'],
				];

				$validacionesMulti = verificarValidacionesBasicasMulti($elementosAValidar, $multiDataRefactorizada);

				//LOGICA DE VALIDACIONES ESPECIALES - FALTA

				$validaciones = validacionesMultiToSimple($validacionesMulti);
				$result['data']['validaciones'] = $validaciones;
				if (!verificarSeCumplenValidaciones($validaciones)) {
					$result['result'] = 0;
					$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
					break;
				}

				if (!empty($post['elementosEliminados'])) {
					$elementosEliminados = $post['elementosEliminados'];
					if (!is_array($elementosEliminados)) $elementosEliminados = [$elementosEliminados];
					$delete = $this->m_usuarios->deleteMasivo($this->m_usuarios->tablas['historicoPlaza']['tabla'], $this->m_usuarios->tablas['historicoPlaza']['id'], $elementosEliminados);
				}
				$update = $this->m_usuarios->actualizarMasivoHistoricoPlaza($multiDataRefactorizada);
				$insert = $this->m_usuarios->guardarMasivoHistoricoPlaza($multiDataRefactorizada, $idUsuarioHistorico);
				break;
		}

		$result['msg']['title'] = $titulo;
		if (empty($result['msg']['content'])) {
			if (!$update || !$delete || !$insert) {
				$result['result'] = 0;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
			} else {
				$result['result'] = 1;
				$result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
			}
		}

		$this->db->trans_complete();

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function findSuperior()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Buscar Superior';
		$post = json_decode($this->input->post('data'), true);

		$numDocumento = $post['numDocumento'];
		$idTipoDocumento = $post['idTipoDocumento'];
		$idCuenta = isset($post['idCuenta']) ? $post['idCuenta'] : NULL ;
		$idProyecto = isset($post['idProyecto']) ? $post['idProyecto'] : NULL ;

		$superior = $this->m_usuarios->findSuperior($numDocumento, $idTipoDocumento, $idCuenta, $idProyecto)->row_array();

		$result['result'] = !empty($superior) ? 1 : 0;
		$result['msg']['content'] = !empty($superior) ? "Se encontró el superior" : "No se encontró un usuario con el documento ingresado.";

		$result['data']['superior'] = $superior;

		$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function buscar_rrhh(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		
		$data_empleado = $this->m_usuarios->getDataRecursosHumanos($post['documento'])->row_array();
		
		$result['result'] = 1;
		$result['data']['nombres'] = $data_empleado['nombres'];
		$result['data']['apePaterno'] = $data_empleado['apePaterno'];
		$result['data']['apeMaterno'] = $data_empleado['apeMaterno'];

		echo json_encode($result);
	}
	

	public function usuarioNuevoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$array=array();

		$input=array();
		
		
		$res_documentos= $this->m_usuarios->getTiposDeDocumento()->result_array();
		$res_proyectos = $this->m_usuarios->getCuentaProyecto()->result_array();
		$res_tipoUsuario = $this->m_usuarios->getTiposDeUsuario()->result_array();
		$res_aplicaciones = $this->m_usuarios->getAplicaciones()->result_array();
		
		foreach($res_documentos as $row ){
			$array['tipoDocumento'][]=$row['nombre'];
			
		}
		
		foreach($res_proyectos as $row ){
			$array['listaProyectos'][]=$row['proyecto'];
		}
		
		foreach($res_tipoUsuario as $row ){
			$array['tipoUsuario'][]=$row['tipoUsuarioCuenta'];
		}

		foreach($res_aplicaciones as $row ){
			$array['aplicacion'][]=$row['nombre'];
		}

		$html .= $this->load->view("modulos/configuraciones/administracion/usuarios/nuevoUsuarioMasivo", $array, true);
		//Result
		$result['result']=1;
		$result['msg']['title'] = 'REGISTRAR NUEVA VISITA';
		$result['data']['html'] = $html;

		//$this->aSessTrack = $this->m_usuarios->aSessTrack;
		echo json_encode($result);
	}

	public function guardarNuevoUsuarioMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));
		foreach($data as $row){
			$tipoDocumento = $row[0];
			$documento = $row[1];
			$nombres = $row[2];
			$apePaterno = $row[3];
			$apeMaterno = $row[4];
			$email = $row[5];
			$usuario = $row[6];
			$clave = $row[7];
			$fechaInicio = $row[8];
			$proyecto = $row[9];
			$tipoUsuario = $row[10];
			$aplicacion = $row[11];
			
			$idTipoDocumento = $this->m_usuarios->obtenerTipoDocumento($tipoDocumento)->row_array();
			$dataEmpleado = $this->m_usuarios->getDataRecursosHumanos($documento)->row_array();
			if(count($dataEmpleado)>0){ $externo=0; $idEmpleado=$dataEmpleado['idEmpleado'];}else{$externo=1;$idEmpleado=null;}
			$insert = [
				'idTipoDocumento' => $idTipoDocumento['idTipoDocumento'],
				'numDocumento' => trim($documento),
				'usuario' => trim($usuario),
				'clave' => trim($clave),
				'nombres' => trim($nombres),
				'apePaterno' => trim($apePaterno),
				'apeMaterno' => trim($apeMaterno),
				'email' => trim($email),
				'externo' => $externo,
				'idEmpleado' =>$idEmpleado,
			];

			$insert = $this->db->insert('trade.usuario', $insert);
			$idUsuario = $this->db->insert_id();
			$idProyecto = $this->m_usuarios->getCuentaProyecto($proyecto)->row_array();
			$idTipoUsuario = $this->m_usuarios->getTiposDeUsuario($tipoUsuario)->row_array();
			$idAplicacion = $this->m_usuarios->getAplicaciones($tipoUsuario)->row_array();
			$insert = [
				'idUsuario' => $idUsuario,
				'idProyecto' => $idProyecto['idProyecto'],
				'idTipoUsuario' => $idTipoUsuario['idTipoUsuario'],
				'idAplicacion' => $idAplicacion['idAplicacion'],
				'fecIni' => trim($fechaInicio),
			];

			$insert = $this->db->insert('trade.usuario_historico', $insert);
			$this->insertId = $this->db->insert_id();
			
			
		}
		
		$result['result']=1;
			$result['msg']['title'] = 'REGISTRAR NUEVO USUARIO MASIVA';
			$result['msg']['content'] = 'SE REGISTRO DATA CON EXITO';

			
			echo json_encode($result);

	}

	public function getFormActualizacionMasivaPermisosUsuarios(){
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
	
		$result['msg']['title'] = 'Carga masiva usuarios';

		$gruposMenu = array();
		$subGruposMenu = array();
		$menusOpcion = array();
		$documentos = array();

		$modulos = array();
		$aplicacion = array();

		$array['permisos'] = $this->m_usuarios->obtener_permisos()->result_array();
		$array['aplicacion'] = $this->m_usuarios->obtener_aplicacion()->result_array();

		$array['usuarios_permisos'] = $this->m_usuarios->obtener_usuarios_permisos($post['id'])->result_array();
		$array['menuOpcion'] = $this->m_usuarios->menuOpcion()->result_array();

		$array['usuarios_permisos_movil'] = $this->m_usuarios->obtener_usuarios_permisos_movil($post['id'])->result_array();
		$array['menuOpcion_movil'] = $this->m_usuarios->menuOpcion_movil()->result_array();

		//REFACTORIZANDO DATA
		$dataRefactorizada = [];
		foreach ($array['permisos'] as $row) {
			if (!in_array($row['grupoMenu'], $dataRefactorizada)) $dataRefactorizada[] = $row['grupoMenu'];
		}
        $gruposMenu = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

		$dataRefactorizada = [];
		foreach ($array['permisos'] as $row) {
			if (!in_array($row['subGrupoMenu'], $dataRefactorizada)) $dataRefactorizada[] = $row['subGrupoMenu'];
		}
		array_filter($dataRefactorizada);
        $subGruposMenu = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

		$dataRefactorizada = [];
		foreach ($array['permisos'] as $row) {
			if (!in_array($row['nombre'], $dataRefactorizada)) $dataRefactorizada[] = $row['nombre'];
		}
        $menusOpcion = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

		$dataRefactorizada = [];
		foreach ($array['usuarios_permisos'] as $row) {
			if (!in_array($row['documento'], $dataRefactorizada)) $dataRefactorizada[] = $row['documento'];
		}
        $documentos = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

		$dataRefactorizada = [];
		foreach ($array['aplicacion'] as $row) {
			if (!in_array($row['nombre'], $dataRefactorizada)) $dataRefactorizada[] = $row['nombre'];
		}
        $aplicacion = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

		$dataRefactorizada = [];
		foreach ($array['menuOpcion_movil'] as $row) {
			if (!in_array($row['modulo'], $dataRefactorizada)) $dataRefactorizada[] = $row['modulo'];
		}
		array_filter($dataRefactorizada);
        $modulos = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

		//ARMANDO HANDSONTABLE
		// $tiposAcceso = array(
			// 0 => "INTRANET",
			// 1 => "APLICATIVO"
		// );

		$HT[0] = [
			'nombre' => 'Usuarios (Carga Masiva)',
			'data' => $array['usuarios_permisos'],
            'headers' => [
				'NOMBRES ',
				//'TIPO DOCUMENTO (*)',
				'N° DOCUMENTO (*)',
				// 'USUARIO (*)',
				// 'ID ACCESO (*)',
				'GRUPOS PERMISOS ',
				'SUB GRUPO PERMISOS ',
				'PERMISOS ',
				'ESTADO (*)',
            ],
			'columns' => [
				['data' => 'nombres', 'type' => 'text', 'placeholder' => 'Nombres', 'width' => 300],
				//['data' => 'tipoDoc', 'type' => 'myDropdown', 'placeholder' => 'Tipo documento', 'width' => 200, 'source'=>$tiposDocumento, 'readOnly' => true],
				['data' => 'documento', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'N° documento', 'width' => 200, 'source'=>$documentos],
				// ['data' => 'usuario', 'type' => 'text', 'placeholder' => 'Usuario', 'width' => 200, 'readOnly' => true],
				// ['data' => 'id', 'type' => 'text', 'placeholder' => 'ID', 'width' => 200],
				// ['data' => 'tipoAcceso', 'type' => 'myDropdown', 'placeholder' => 'Tipo acceso', 'width' => 200, 'source'=>$tiposAcceso],
				['data' => 'grupoMenu', 'type' => 'myDropdown', 'placeholder' => 'Grupo permisos', 'width' => 200, 'source'=>$gruposMenu],
				['data' => 'subGrupoMenu', 'type' => 'myDropdown', 'placeholder' => 'Sub grupo permisos', 'width' => 200, 'source'=>$subGruposMenu],
				['data' => 'menuOpcion', 'type' => 'myDropdown', 'placeholder' => 'Permisos', 'width' => 200, 'source'=>$menusOpcion],
				['data' => 'estado', 'type' => 'checkbox', 'placeholder' => 'Demo', 'width' => 100],
			],
			'colWidths' => 200,
			// 'hideColumns'=> [1, 2],
        ];

		$HT[1] = [
			'nombre' => 'Menus Opcion',
			'data' => $array['menuOpcion'],
            'headers' => [
				'GRUPO MENU ',
				'SUB GRUPO MENU ',
				'MENU ',
				'ESTADO ',
            ],
			'columns' => [
				['data' => 'grupoMenu', 'type' => 'myDropdown', 'placeholder' => 'Grupo permisos', 'width' => 200, 'source'=>$gruposMenu],
				['data' => 'subGrupoMenu', 'type' => 'myDropdown', 'placeholder' => 'Sub grupo permisos', 'width' => 200, 'source'=>$subGruposMenu],
				['data' => 'grupo', 'type' => 'myDropdown', 'placeholder' => 'Permisos', 'width' => 200, 'source'=>$menusOpcion],
				['data' => 'estado', 'type' => 'checkbox', 'placeholder' => 'Demo', 'width' => 100],
			],
			'colWidths' => 200,
			// 'hideColumns'=> [1, 2],
        ];

		$HT[2] = [
			'nombre' => 'Usuarios (Carga Masiva Movil)',
			'data' => $array['usuarios_permisos_movil'],
            'headers' => [
				'NOMBRES ',
				'N° DOCUMENTO (*)',
				'APLICACION ',
				'MODULOS ',
				'ESTADO (*)',
            ],
			'columns' => [
				['data' => 'nombres', 'type' => 'text', 'placeholder' => 'Nombres', 'width' => 300],
				['data' => 'documento', 'type' => 'myDropdownAlsoNew', 'placeholder' => 'N° documento', 'width' => 200, 'source'=>$documentos],
				['data' => 'app', 'type' => 'myDropdown', 'placeholder' => 'Aplicacion', 'width' => 200, 'source'=>$aplicacion],
				['data' => 'modulo', 'type' => 'myDropdown', 'placeholder' => 'Modulos', 'width' => 200, 'source'=>$modulos],
				['data' => 'estado', 'type' => 'checkbox', 'placeholder' => 'Estado', 'width' => 100],
			],
			'colWidths' => 200,
			// 'hideColumns'=> [1, 2],
        ];

		$HT[3] = [
			'nombre' => 'Modulos de Aplicativo',
			'data' => $array['menuOpcion_movil'],
            'headers' => [
				'APLICACION ',
				'MODULOS ',
				'ESTADO ',
            ],
			'columns' => [
				['data' => 'app', 'type' => 'myDropdown', 'placeholder' => 'Aplicacion', 'width' => 300, 'source'=>$aplicacion],
				['data' => 'modulo', 'type' => 'myDropdown', 'placeholder' => 'Modulos', 'width' => 200, 'source'=>$modulos],
				['data' => 'estado', 'type' => 'checkbox', 'placeholder' => 'Estado', 'width' => 100],
			],
			'colWidths' => 200,
			// 'hideColumns'=> [1, 2],
        ];

		//MOSTRANDO VISTA
		$dataParaVista['hojas'] = [0 => $HT[0]['nombre'], 1 => $HT[1]['nombre'], 2 => $HT[2]['nombre'], 3 => $HT[3]['nombre']];
		$result['result'] = 1;
		$result['data']['width'] = '90%';
		$result['data']['html'] = $this->load->view('modulos/configuraciones/administracion/usuarios/formCargaMasivaUsuarios',$dataParaVista, true);
		$result['data']['ht'] = $HT;

		echo json_encode($result);
	}

	public function guardarActualizacionMasivaPermisosUsuarios(){
		$this->db->trans_start();
		$result = $this->result;

		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Carga masiva usuarios';

		$array = array(
			'tiposDocumento' => array(),
			'tiposUsuario' => array(),
			'gruposMenu' => array(),
			'subGruposMenu'=> array(),
			'menusOpcion' => array(),
			'canales' => array(),
			'usuariosAplicativo' => array(),
			'usuariosIntranet' => array(),
			'documentosAplicativo' => array(),
			'documentosIntranet'=> array(),
		);

		$permisos = $this->m_usuarios->obtener_permisos()->result_array();

		$usuarioIntranet  = $this->m_usuarios->obtener_usuarios_web()->result_array();

		$modulos  = $this->m_usuarios->menuOpcion_movil()->result_array();

		foreach ($permisos as $key => $row) {
			$array['gruposMenu'][$row['grupoMenu']] = $row['idGrupoMenu'];
		}
		foreach ($permisos as $key => $row) {
			$array['subGruposMenu'][$row['idGrupoMenu']][$row['subGrupoMenu']] = $row['idSubGrupoMenu'];
		}
		foreach ($permisos as $key => $row) {
			empty($row['subGrupoMenu']) ? $row['idSubGrupoMenu'] = 0: '' ;
			$array['menusOpcion'][$row['idGrupoMenu']][$row['idSubGrupoMenu']][$row['nombre']] = $row['idMenuOpcion'];
		}
		foreach ($usuarioIntranet as $key => $row) {
			$array['usuariosIntranet'][$row['usuario']] = $row['idUsuario'];
		}
		foreach ($usuarioIntranet as $key => $row) {
			$array['documentosIntranet'][$row['numDocumento']] = $row['idUsuario'];
		}
		foreach ($modulos as $key => $row) {
			$array['modulos'][$row['app']][$row['modulo']] = $row['idModulo'];
		}

		array_pop($post['HT'][0]);

		if(empty($post['HT'][0])){
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type'=>2,'message'=>'La carga masiva no contiene datos']);
			goto respuesta;
		}

		$usuarios_id_acceso = [];

		foreach ($post['HT'][0] as $key => $value) {

			if(
			   empty($value['documento'])
			){
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Los campos con (*) son obligatorios, asegúrese de completarlos']);
				goto respuesta;
			}

			if(!empty($value['menuOpcion'])){
				if(empty($value['grupoMenu'])){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(['type'=>2,'message'=>'Debe seleccionar un grupo menú.<br> Fila:'.($key+1)]);
					goto respuesta;
				}
				$idGrupoMenu = $array['gruposMenu'][$value['grupoMenu']];
				if(empty($value['subGrupoMenu'])){
				$idSubGrupoMenu = 0;
				}else{
					$idSubGrupoMenu = !empty($array['subGruposMenu'][$idGrupoMenu][$value['subGrupoMenu']])? $array['subGruposMenu'][$idGrupoMenu][$value['subGrupoMenu']]: NULL ; 
					if(empty($idSubGrupoMenu)){
						$result['result'] = 0;
						$result['msg']['content'] = createMessage(['type'=>2,'message'=>'El <strong>SUB GRUPO MENÚ</strong> no corresponde al grupo menú.<br> Fila:'.($key+1)]);
						goto respuesta;
					}
				}

				$idMenuOpcion = !empty($array['menusOpcion'][$idGrupoMenu][$idSubGrupoMenu][$value['menuOpcion']])? $array['menusOpcion'][$idGrupoMenu][$idSubGrupoMenu][$value['menuOpcion']] : NULL;

				if(empty($idMenuOpcion)){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(['type'=>2,'message'=>'El menú opción <strong>'.$value['menuOpcion'].'</strong> no corresponde al grupo menú o sub grupo menú.<br> Fila:'.($key+1)]);
					goto respuesta;
				}

				$usuarios_id_acceso[$value['documento']] = $array['documentosIntranet'][$value['documento']];

				$input_permisos_acceso[] = array(
					'idUsuario' => $array['documentosIntranet'][$value['documento']],
					'idMenuOpcion' => $idMenuOpcion,
					'estado' => ($value['estado'] == true) ? 1 : 0,
				);
			}
		}

		$idsUsuarios = [];

		foreach($usuarios_id_acceso AS $k => $r){
			array_push($idsUsuarios, $r);
		}

		if(!empty($input_permisos_acceso)){
			$delete = $this->m_usuarios->delete_permisos($idsUsuarios);
			$registro = $this->db->insert_batch('trade.usuario_menuOpcion', array_unique($input_permisos_acceso, SORT_REGULAR));
		}

		array_pop($post['HT'][2]);

		if (empty($post['HT'][2])) {
			$result['result'] = 0;
			$result['msg']['content'] = createMessage(['type' => 2, 'message' => 'La carga masiva de permisos de móviles no contiene datos']);
			goto respuesta;
		}

		foreach ($post['HT'][2] as $key => $value) {

			if (
				empty($value['documento'])
			) {
				$result['result'] = 0;
				$result['msg']['content'] = createMessage(['type' => 2, 'message' => 'Los campos con (*) son obligatorios, asegúrese de completarlos en la carga masiva de permisos de móviles']);
				goto respuesta;
			}

			if (!empty($value['modulo'])) {
				$idModulo = $array['modulos'][$value['app']][$value['modulo']];

				if(empty($idModulo)){
					$result['result'] = 0;
					$result['msg']['content'] = createMessage(['type' => 2, 'message' => 'Alguno de los permisos asignados en la sección de aplicativos no se relaciona con la aplicación seleccionada']);	
					goto respuesta;
				}

				$usuarios_id_acceso_movil[$value['documento']] = $array['documentosIntranet'][$value['documento']];

				$input_permisos_acceso_movil[] = array(
					'idUsuario' => $array['documentosIntranet'][$value['documento']],
					'idModulo' => $idModulo,
					'estado' => ($value['estado'] == true) ? 1 : 0,
				);
			}
		}

		if (!empty($input_permisos_acceso_movil)) {
			$delete = $this->m_usuarios->delete_permisos_movil($idsUsuarios);
			// $update = $this->model->update_flag_nuevo_movil($idsUsuarios);
			$registro = $this->db->insert_batch('trade.usuario_modulo', array_unique($input_permisos_acceso_movil, SORT_REGULAR));
		}

		$registro = true;

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$this->m_usuarios->actualizar_flag_nuevo($idsUsuarios);
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
        echo json_encode($result);
	}

}
