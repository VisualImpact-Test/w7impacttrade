<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archivos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuraciones/administracion/M_Archivos', 'm_archivos');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',
			'archivos' => ['actualizar' => 'Actualizar Archivo', 'registrar' => 'Subir Archivos'],
		];

		$this->carpetaHtml = 'modulos/Configuraciones/Administracion/Archivos/';

		$this->carpetaArchivos = "C:/archivos/";

		$this->html = [
			'archivos' => [
				'tabla' => $this->carpetaHtml .  'archivosTabla',
				'new' => $this->carpetaHtml .  'archivosFormNew',
				'update' => $this->carpetaHtml .  'archivosFormUpdate',
			],
		];
	}

	public function index()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults',
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs//handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/HTCustom',
			'assets/custom/js/core/gestion',
			'assets/custom/js/gestionOperativa/archivos',
		];

		$config['nav']['menu_active'] = '80';
		$config['data']['icon'] = 'fal fa-cabinet-filing';
		$config['data']['title'] = 'Fichero Web';
		$config['data']['message'] = 'Módulo para gestionar archivos';
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
			case 'Archivos':
				$tabla = $this->m_archivos->tablas['archivos']['tabla'];
				$idTabla = $this->m_archivos->tablas['archivos']['id'];
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

			$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $id ];
		}

		$cambioEstado = $this->m_archivos->actualizarMasivo($tabla, $update, $idTabla);


		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');

			$this->aSessTrack = [];
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
		}
		echo json_encode($result);
	}

	public function getTablaArchivos()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$post['flagGestorDeArchivos'] = $this->flagGestorDeArchivos;
		$post['idUsuario'] = $this->idUsuario;

		$resultados = $this->m_archivos->getArchivos($post)->result_array();
		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noResultados');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view($this->html['archivos']['tabla'], $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormNewArchivos()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['archivos']['registrar'];

		$post = json_decode($this->input->post('data'), true);
		$post['idUsuario'] = $this->idUsuario;

		$gruposCarpetasDeUsuario = $this->m_archivos->getGruposCarpetasDeUsuario($post)->result_array();
		$grupos = [];
		$carpetas = [];
		foreach ($gruposCarpetasDeUsuario as $value) {
			$grupos[$value['idGrupo']]['idGrupo'] = $value['idGrupo'];
			$grupos[$value['idGrupo']]['nombreGrupo'] = $value['nombreGrupo'];
			$carpetas[$value['idGrupo']][$value['idCarpeta']]['idCarpeta'] = $value['idCarpeta'];
			$carpetas[$value['idGrupo']][$value['idCarpeta']]['nombreCarpeta'] = $value['nombreCarpeta'];
		}
		$dataParaVista['grupos'] = $grupos;
		$dataParaVista['carpetas'] = $carpetas;
		$dataParaVista['tiposDeArchivos'] = $this->m_archivos->getTiposDeArchivos();

		//FALTA VALIDACION getInformacionParaSubirArchivo();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['archivos']['new'], $dataParaVista, true);

		$this->aSessTrack = $this->m_archivos->aSessTrack;
		echo json_encode($result);
	}

	public function registrarArchivos()
	{
		$post = $this->input->post();

		$result = $this->result;
		$result['msg']['title'] = $this->titulo['archivos']['registrar'];
		$result['result'] = 0;

		$nombreRegistrado = trim($post['nombreRegistrado']);
		$idCategoria = $post['idCategoria'];
		$tabla = 'trade.gestorArchivos_archivo';
		$idUsuarioCreador = $this->idUsuario;
		$ip = $this->ip = getIp();
		$fechaHoraDeSubida = getActualDateTime();

		$carpeta = $this->carpetaArchivos;

		$tabla = "trade.gestorArchivos_archivo";
		$filtros = " AND idCarpeta = " . $idCategoria;
		$filtros .= " AND nombre = '" . $nombreRegistrado . "'";
		$filtros .= " AND eliminado = 0";

		if (empty($_FILES)) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> Tiene que seleccionar un archivo.';
			goto respuesta;
		}

		if (strlen($nombreRegistrado) > 125) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre del archivo no debe ser mayor a 125 caracteres.';
			goto respuesta;
		}

		$archivoNuevo = true;
		$nombreArchivo = explode('.', $_FILES['file']['name']);
		$extension = array_pop($nombreArchivo);

		$tipoDeArchivo = $this->m_archivos->getTipoArchivo($extension)->row_array();
		$idTipoArchivo = !empty($tipoDeArchivo['idTipoArchivo']) ? $tipoDeArchivo['idTipoArchivo'] : 6;

		$tipoArchivo = $_FILES['file']['type'];
		$nombreTemporal = $_FILES['file']['tmp_name'];
		$peso = $_FILES['file']['size'];

		//Nombre de archivo no valido
		$nombreArchivoValido = "/^[a-z\d\-_\s]+$/i";
		if (!preg_match($nombreArchivoValido, $nombreRegistrado)) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre del archivo solo puede tener caracteres alfanumericos, guiones(-) y guiones abajo(_).';
			goto respuesta;
		}

		$esDuplicado = $this->m_archivos->duplicado($tabla, $filtros);

		if ($esDuplicado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre escogido para el archivo ya esta siendo usado por usted u otro usuario en la misma carpeta.';
			goto respuesta;
		}

		if ($peso > (30 * 1024 * 1024)) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No puedo subir archivos que pesen más de 30MB.';
			goto respuesta;
		}

		do {
			$nombreArchivo = 'file-' . substr(sha1(rand()), 0, 10);
			$rutaArchivo = $carpeta . $nombreArchivo;
		} while (glob($rutaArchivo . '.*') != false);
		$rutaArchivo = $rutaArchivo . '.' . $extension;
		$movioArchivo = rename($nombreTemporal, $rutaArchivo);

		if ($movioArchivo) {
			$input = array(
				"nombre" => $nombreRegistrado,
				"nombreArchivo" => $nombreArchivo,
				"idCarpeta" => $idCategoria,
				"idUsuarioCreador" => $idUsuarioCreador,
				"ipUsuarioCreador" => $ip,
				"peso" => $peso,
				"extension" => $extension,
				"eliminado" => 0,
				"idTipoArchivo" => $idTipoArchivo
			);

			$guardado = $this->m_archivos->guardar($tabla, $input);

			$lastIdArchivo = $this->m_archivos->getLastIdArchivo()->row_array();
			$idArchivo = $lastIdArchivo['idArchivo'];
		}

		$this->aSessTrack = $this->m_archivos->aSessTrack;

		if (!$guardado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No se pudo cargar el archivo. Intentelo nuevamente.';
			goto respuesta;
		}

		$result['result'] = 1;
		$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-check-circle" ></i></a> Se subió el archivo exitosamente.';

		respuesta:
		echo json_encode($result);
	}

	public function getFormUpdateArchivos()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarCuenta'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['cuenta'] = $this->m_archivos->getCuentas($post)->row_array();
		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['cuenta']['update'], $dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarArchivos()
	{
		$this->db->trans_start();
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarCuenta'];

		$post = json_decode($this->input->post('data'), true);

		$elementosAValidar = [
			'nombre' => ['requerido'],
			'ruc' => ['requerido', 'numerico'],
			'nombreComercial' => ['requerido'],
			'razonSocial' => ['requerido'],
			'direccion' => ['requerido'],
			'ubigeo' => ['requerido', 'numerico'],
			'urlCss' => [],
			'urlLogo' => [],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_archivos->checkNombreCuentaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
		if ($this->m_archivos->checkRucCuentaRepetido($post)) $validaciones['ruc'][] = getMensajeGestion('registroRepetido');
		if ($this->m_archivos->checkNombreComercialCuentaRepetido($post)) $validaciones['nombreComercial'][] = getMensajeGestion('registroRepetido');
		if ($this->m_archivos->checkRazonSocialCuentaRepetido($post)) $validaciones['razonSocial'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$actualizo = $this->m_archivos->actualizarCuenta($post);
		$this->aSessTrack = $this->m_archivos->aSessTrack;

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function verificarCondicionesDb()
	{
		$result = $this->result;
		$result['msg']['title'] = "Archivos";
		$post = json_decode($this->input->post('data'), true);

		$idCategoria = $post['idCategoria'];
		$nombreRegistrado = $post['nombreRegistrado'];
		$size = $post['size'];
		$idGrupo = $post['idGrupo'];

		$tabla = "trade.gestorArchivos_archivo";
		$filtros = " AND idCarpeta = " . $idCategoria;
		$filtros .= " AND nombre = '" . $nombreRegistrado . "'";
		$filtros .= " AND eliminado = 0";

		$esDuplicado = $this->m_archivos->duplicado($tabla, $filtros);
		$espacios = $this->m_archivos->getEspacioGrupo($idGrupo)->row_array();

		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$espacioRestante = $espacios['espacioRestante'];

		if ($esDuplicado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre escogido para el archivo ya esta siendo usado por usted u otro usuario en la misma carpeta.';
			goto responder;
		}

		if ($size > $espacioRestante) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No hay suficiente espacio en el grupo. El espacio restante es ' . formatBytes($espacioRestante) . ' .';
			goto responder;
		}

		$result['result'] = 1;

		responder:
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
	}


	public function eliminarArchivo()
	{
		$post = json_decode($this->input->post('data'), true);

		$result = $this->result;
		$result['msg']['title'] = 'Eliminar archivo';

		$idArchivo = $post['id'];

		$carpeta = $this->carpetaArchivos;

		$archivo = $this->m_archivos->getArchivo($idArchivo)->row_array();

		$nombreArchivo = $archivo['nombreArchivo'];
		$extension = $archivo['extension'];

		$rutaArchivo = $carpeta . $nombreArchivo . '.' . $extension;

		$eliminoArchivo = (file_exists($rutaArchivo)) ?  unlink($rutaArchivo) : true;

		if (!$eliminoArchivo) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No se pudo eliminar el archivo. Intentelo nuevamente.';
			goto responder;
		}

		$eliminado = $this->m_archivos->agregarEstadoEliminado($idArchivo);

		$this->aSessTrack = $this->m_archivos->aSessTrack;

		if (!$eliminado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No se pudo eliminar el archivo. Intentelo nuevamente.';
			goto responder;
		}

		$result['result'] = 1;
		$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-check-circle" ></i></a> El archivo se elimino correctamente.';

		responder:
		echo json_encode($result);
	}
}
