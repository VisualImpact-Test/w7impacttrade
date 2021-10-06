<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archivos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gestionOperativa/m_archivos', 'm_archivos');

		$this->titulo = [
			'cambiarEstado' => 'Activar/Desactivar',
			'archivos' => ['actualizar' => 'Actualizar Archivo', 'registrar' => 'Subir Archivos'],
		];

		$this->carpetaHtml = 'modulos/GestionOperativa/Archivos/';

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
		$this->aSessTrack = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active']='80';
		$config['css']['style'] = [
			'assets/libs/datatables/datatables',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
		];
		$config['js']['script'] = [
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/libs/datatables/datatables',
			'assets/custom/js/core/datatables-defaults',
			'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
			'assets/libs/handsontable@7.4.2/dist/languages/all',
			'assets/libs//handsontable@7.4.2/dist/moment/moment',
			'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
			'assets/custom/js/core/gestion',
			'assets/custom/js/gestionOperativa/archivos',
		];

		$config['data']['icon'] = 'fa fa-file';
		$config['data']['title'] = 'Archivos';
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
		}

		$cambioEstado = $this->m_archivos->actualizarMasivo($tabla, $update, $idTabla);


		if (!$cambioEstado) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
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
			$result['data']['html'] = getMensajeGestion('noRegistros');
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

		$this->aSessTrack = $this->m_archivos->aSessTrack;
		//FALTA VALIDACION getInformacionParaSubirArchivo();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['archivos']['new'], $dataParaVista, true);

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
			goto responder;
		}

		if (strlen($nombreRegistrado) > 125) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre del archivo no debe ser mayor a 125 caracteres.';
			goto responder;
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
			goto responder;
		}

		$esDuplicado = $this->m_archivos->duplicado($tabla, $filtros);

		if ($esDuplicado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre escogido para el archivo ya esta siendo usado por usted u otro usuario en la misma carpeta.';
			goto responder;
		}

		if ($peso > (30 * 1024 * 1024)) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No puedo subir archivos que pesen más de 30MB.';
			goto responder;
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

		if (!$guardado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No se pudo cargar el archivo. Intentelo nuevamente.';
			goto responder;
		}

		$result['result'] = 1;
		$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-check-circle" ></i></a> Se subió el archivo exitosamente.';

		responder:
		$this->aSessTrack = $this->m_archivos->aSessTrack;
		echo json_encode($result);
	}

	public function getFormUpdateArchivos()
	{
		$result = $this->result;
		$result['msg']['title'] = $this->titulo['actualizarCuenta'];

		$post = json_decode($this->input->post('data'), true);

		$dataParaVista['cuenta'] = $this->m_archivos->getCuentas($post)->row_array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view($this->html['cuenta']['update'], $dataParaVista, true);

		$this->aSessTrack = $this->m_archivos->aSessTrack;
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
			goto responder;
		}

		$actualizo = $this->m_archivos->actualizarCuenta($post);

		if (!$actualizo) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('actualizacionErronea');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('actualizacionExitosa');
		}

		$this->db->trans_complete();

		responder:
		$this->aSessTrack = $this->m_archivos->aSessTrack;
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
		$this->aSessTrack = $this->m_archivos->aSessTrack;
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

		if (!$eliminado) {
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No se pudo eliminar el archivo. Intentelo nuevamente.';
			goto responder;
		}

		$result['result'] = 1;
		$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-check-circle" ></i></a> El archivo se elimino correctamente.';

		responder:
		$this->aSessTrack = $this->m_archivos->aSessTrack;
		echo json_encode($result);
	}

	public function getTablaCarpetas(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$post['flagGestorDeArchivos'] = $this->flagGestorDeArchivos;
		$post['idUsuario'] = $this->idUsuario;

		$resultados = $this->m_archivos->getCarpetas()->result_array();
		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view('modulos/GestionOperativa/Archivos/tablaCarpeta', $dataParaVista, true);
		}

		echo json_encode($result);
	}
	public function getFormNewCarpetas(){
		$result = $this->result;
		$result['msg']['title'] = 'Registrar carpeta';

		$post = json_decode($this->input->post('data'), true);
		$post['idUsuario'] = $this->idUsuario;

		$dataParaVista['grupos'] = $this->m_archivos->getGrupos($post)->result_array();

		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/GestionOperativa/Archivos/formNewcarpeta' ,$dataParaVista, true);

		echo json_encode($result);
	}

	public function registrarCarpetas()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Registrar Carpeta';


		$elementosAValidar = [
			'nombre' => ['requerido'],
			'grupo' =>['selectRequerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_archivos->checkCarpetaGrupoRepetida($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_archivos->registrarCarpetas($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}
	public function getFormUpdateCarpetas()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Actualizar carpeta';

		$post = json_decode($this->input->post('data'), true);
		$post['idUsuario'] = $this->idUsuario;
		$dataParaVista['data'] = $this->m_archivos->getCarpetas($post)->row_array();
		$dataParaVista['grupos'] = $this->m_archivos->getGrupos($post)->result_array();

		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/GestionOperativa/Archivos/formUpdateCarpeta' ,$dataParaVista, true);

		echo json_encode($result);
	}

	public function actualizarCarpetas()
	{
		$this->db->trans_start();
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$result['msg']['title'] = 'Actualizar Carpeta';


		$elementosAValidar = [
			'nombre' => ['requerido'],
			'grupo' =>['selectRequerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

		if ($this->m_archivos->checkCarpetaGrupoRepetida($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}

		$registro = $this->m_archivos->actualizarCarpetas($post);
		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroErroneo');
		} else {
			$result['result'] = 1;
			$result['msg']['content'] = getMensajeGestion('registroExitoso');
		}

		$this->db->trans_complete();

		respuesta:
		echo json_encode($result);
	}

	public function getTablaPermisos(){
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$post['flagGestorDeArchivos'] = $this->flagGestorDeArchivos;
		$post['idUsuario'] = $this->idUsuario;

		$resultados = $this->m_archivos->getUsuarios()->result_array();
		$this->aSessTrack = $this->m_archivos->aSessTrack;

		$result['result'] = 1;
		if (count($resultados) < 1) {
			$result['data']['html'] = getMensajeGestion('noRegistros');
		} else {
			$dataParaVista['resultados'] = $resultados;
			$result['data']['html'] = $this->load->view('modulos/GestionOperativa/Archivos/tablaPermisos', $dataParaVista, true);
		}

		echo json_encode($result);
	}

	public function getFormUpdatePermisos()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Actualizar Permisos';

		$post = json_decode($this->input->post('data'), true);

        $permisosDeUnUsuario = $this->m_archivos->getPermisosDeUnUsuario($post['id'])->result_array();
        $grupos = $this->m_archivos->getGrupos()->result_array();
        $categorias = $this->m_archivos->getCarpetas()->result_array();

        $dataParaVista = array();
        foreach ($permisosDeUnUsuario as $permiso) {
            $dataParaVista['permisos'][$permiso['idGrupo']][$permiso['idCarpeta']] = $permiso;
        }

        foreach ($categorias as $categoria) {
            $dataParaVista['categorias'][$categoria['idGrupo']][$categoria['idCarpeta']] = $categoria;
        }

        $dataParaVista['grupos'] = $grupos;
		$dataParaVista['idUsuario'] = $post['id'];

		$this->aSessTrack = $this->m_archivos->aSessTrack;
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view('modulos/GestionOperativa/Archivos/formUpdatePermisos' ,$dataParaVista, true);

		echo json_encode($result);
	}
	public function actualizarPermisos(){
		$result = $this->result;
		$result['msg']['title'] = 'Actualizar Permisos';

		$post = json_decode($this->input->post('data'), true);

		$idUsuario = $post['idx'];
        $permisos = array();
        $permisosAgregados = array();
        $permisosRemovidos = array();
        $idUsuarioCreadorOEditor = $this->idUsuario;
        $ip = $this->ip = $_SERVER['REMOTE_ADDR'];

        foreach ($post as $indice => $row) {
            if ((strpos($indice, '-') != false) and (strpos($indice, 'a') == false) and (strpos($indice, 'b') == false)) {
                $permisos[$indice] = $row;
            }
        }

        foreach ($permisos as $indice => $row) {
            $grupoCategoria = explode("-", $indice);

            if (isset($post[$indice . 'a']) and !isset($post[$indice . 'b'])) {
                array_push(
                    $permisosAgregados,
                    array(
                        "idUsuario" => $idUsuario,
                        "idCarpeta" => $grupoCategoria[1],
                        "fechaCreacion" => getActualDateTime(),
                        "idUsuarioCreador" => $idUsuarioCreadorOEditor,
                        "ipUsuarioCreador" => $ip,
                        "estado" => "1"
                    )
                );
            }

            if (!isset($post[$indice . 'a']) and isset($post[$indice . 'b'])) {
                array_push(
                    $permisosRemovidos,
                    array(
                        "idUsuario" => $idUsuario,
                        "idCarpeta" => $grupoCategoria[1],
                        "fechaModificacion" => getActualDateTime(),
                        "idUsuarioEditor" => $idUsuarioCreadorOEditor,
                        "ipUsuarioEditor" => $ip,
                        "estado" => "0"
                    )
                );
            }
        }

        $resultado = $this->m_archivos->guardarPermisos($permisosAgregados, $permisosRemovidos);

        if ($resultado == 0) {
            $result['msg']['content'] = getMensajeGestion('registroErroneo');
            echo json_encode($result);
            exit();
        }

        $result['result'] = 1;
        $result['msg']['content'] = getMensajeGestion('registroExitoso');
        echo json_encode($result);
	}

}
