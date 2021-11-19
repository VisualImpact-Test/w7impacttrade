<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aplicaciones extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuraciones/maestros/m_aplicaciones', 'model');

        $this->titulo = [
            'cambiarEstado' => 'Activar/Desactivar',

            'actualizarAplicaciones' => 'Actualizar Aplicaciones',
            'registrarAplicaciones' => 'Registrar Aplicaciones',
            'masivoAplicaciones' => 'Guardar Masivo Aplicaciones',

            'actualizarGrupoModulo' => 'Actualizar Grupo Modulo',
            'registrarGrupoModulo' => 'Registrar Grupo Modulo',
            'masivoGrupoModulo' => 'Guardar Masivo Grupo Modulo',

            'actualizarModulo' => 'Actualizar Modulo',
            'registrarModulo' => 'Registrar Modulo',
            'masivoModulo' => 'Guardar Masivo Modulo',

            'actualizarMenu' => 'Actualizar Menu',
            'registrarMenu' => 'Registrar Menu',
            'masivoMenu' => 'Guardar Masivo Menu',

            'actualizarMenuCuenta' => 'Actualizar Menu Cuenta',
            'registrarMenuCuenta' => 'Registrar Menu Cuenta',
            'masivoMenuCuenta' => 'Guardar Masivo Menu Cuenta',
        ];
    }

    public function index()
    {
        $config = array();
        $config['nav']['menu_active'] = '132';
        $config['css']['style'] = [
            'assets/libs/dataTables-1.10.20/datatables',
            'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
        ];
        $config['js']['script'] = [
            'assets/libs/datatables/responsive.bootstrap4.min',
            'assets/custom/js/core/datatables-defaults',
            'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/languages/all',
            'assets/libs/handsontable@7.4.2/dist/moment/moment',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
            'assets/custom/js/core/HTCustom',
            'assets/custom/js/core/gestion',
            'assets/custom/js/configuraciones/maestros/aplicaciones',
        ];

        $config['data']['icon'] = 'fal fa-tablet-alt';
        $config['data']['title'] = 'Configuración App';
        $config['data']['message'] = 'Módulo para gestionar las aplicaciones';
        $config['view'] = 'modulos/Configuraciones/Maestros/Aplicaciones/index';

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
            case 'Aplicaciones':
                $tabla = 'trade.aplicacion';
                $idTabla = 'idAplicacion';
                break;
            case 'GrupoModulo':
                $tabla = 'trade.aplicacion_modulo_grupo';
                $idTabla = 'idModuloGrupo';
                break;
            case 'Modulos':
                $tabla = 'trade.aplicacion_modulo';
                $idTabla = 'idModulo';
                break;
            case 'Menu':
                $tabla = 'trade.aplicacion_menu';
                $idTabla = 'idMenu';
                break;
            case 'MenuCuenta':
                $tabla = "{$this->sessBDCuenta}.trade.list_aplicacion_menu";
                $idTabla = 'idListAplicacionMenu';
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

        $cambioEstado = $this->model->actualizarMasivo($tabla, $update, $idTabla);

        if (!$cambioEstado) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
        }
        echo json_encode($result);
    }

    public function getTablaAplicaciones()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->model->getAplicaciones($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/reporte', $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewAplicaciones()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarAplicaciones'];

        $dataParaVista = [];
        $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/formNuevo', $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarAplicaciones()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarAplicaciones'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'form_idCuenta' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkAplicacionesRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta seleccionada.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->model->registrarAplicaciones($post);
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

    public function getFormUpdateAplicaciones()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarAplicaciones'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
        $dataParaVista['aplicaciones'] = $this->model->getAplicaciones($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/formActualizar', $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarAplicaciones()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarAplicaciones'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'form_idCuenta' => ['form_idCuenta'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkAplicacionesRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->model->actualizarAplicaciones($post);

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

    //MODULOS GRUPO

    public function getTablaGrupoModulo()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->model->getGrupoModulo($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/GrupoModulo/reporte', $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewGrupoModulo()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarGrupoModulo'];

        $dataParaVista = [];

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/GrupoModulo/formNuevo', $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarGrupoModulo()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarGrupoModulo'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkGrupoModuloRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta seleccionada.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->model->registrarGrupoModulo($post);
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

    public function getFormUpdateGrupoModulo()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarGrupoModulo'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
        $dataParaVista['grupoModulo'] = $this->model->getGrupoModulo($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/GrupoModulo/formActualizar', $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarGrupoModulo()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarGrupoModulo'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkGrupoModuloRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->model->actualizarGrupoModulo($post);

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

    //MODULOS

    public function getTablaModulos()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->model->getModulo($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/Modulo/reporte', $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewModulos()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarModulo'];

        $dataParaVista = [];
        $dataParaVista['aplicaciones'] = $this->model->getAplicaciones()->result_array();
        $dataParaVista['grupoModulo'] = $this->model->getGrupoModulo()->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/Modulo/formNuevo', $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarModulos()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarModulo'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'idAplicacion' => ['requerido'],
            'idModuloGrupo' => ['requerido'],
            'orden' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkModuloRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la aplicacion y grupo seleccionado.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->model->registrarModulo($post);
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

    public function getFormUpdateModulos()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarModulo'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['aplicaciones'] = $this->model->getAplicaciones()->result_array();
        $dataParaVista['grupoModulo'] = $this->model->getGrupoModulo()->result_array();
        $dataParaVista['modulos'] = $this->model->getModulo($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/Modulo/formActualizar', $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarModulos()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarModulo'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'idAplicacion' => ['requerido'],
            'idModuloGrupo' => ['requerido'],
            'orden' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkModuloRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la aplicacion y grupo seleccionado.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->model->actualizarModulo($post);

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


    //MENUS

    public function getTablaMenu()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->model->getMenu($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/Menu/reporte', $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewMenu()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarMenu'];

        $dataParaVista = [];

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/Menu/formNuevo', $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarMenu()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarMenu'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkMenuRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->model->registrarMenu($post);
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

    public function getFormUpdateMenu()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarMenu'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['menu'] = $this->model->getMenu($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/Menu/formActualizar', $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarMenu()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarMenu'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkMenuRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->model->actualizarMenu($post);

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


    //MENU CUENTA

    public function getTablaMenuCuenta()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->model->getMenuCuenta($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/MenuCuenta/reporte', $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewMenuCuenta()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarMenuCuenta'];

        $dataParaVista = [];
        $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
        
        $rs_cuentas_proyecto= $this->model->getCuentasProyecto()->result_array();
        foreach($rs_cuentas_proyecto as $row){
            $dataParaVista['proyectos'][$row['idCuenta']][$row['idProyecto']]=$row['proyecto'];
        }
       
        $rs_grupo_canal = $this->model->getGrupoCanal()->result_array();
        foreach($rs_grupo_canal as $row){
            $dataParaVista['grupoCanales'][$row['idCuenta']][$row['idGrupoCanal']]=$row['grupoCanal'];
        }

        $rs_tipo_usuario = $this->model->getTipoUsuario()->result_array();
        foreach($rs_tipo_usuario as $row){
            $dataParaVista['tipoUsuarios'][$row['idCuenta']][$row['idTipoUsuario']]=$row['tipoUsuario'];
        }


        $dataParaVista['aplicaciones'] = $this->model->getAplicaciones()->result_array();
        $dataParaVista['menus'] = $this->model->getMenu()->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/MenuCuenta/formNuevo', $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarMenuCuenta()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarMenuCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'idAplicacion' => ['requerido'],
            'idMenu' => ['requerido'], 
            'idCuenta' => ['requerido'],
            'idProyecto' => ['requerido'], 
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);


        if ($this->model->checkMenuCuentaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con los mismos datos.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->model->registrarMenuCuenta($post);
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

    public function getFormUpdateMenuCuenta()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarMenuCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['menuCuenta'] = $this->model->getMenuCuenta($post)->row_array();
        $dataParaVista['cuentas'] = $this->model->getCuentas()->result_array();
        $dataParaVista['aplicaciones'] = $this->model->getAplicaciones()->result_array();
        $dataParaVista['menus'] = $this->model->getMenu()->result_array();

        $rs_cuentas_proyecto= $this->model->getCuentasProyecto()->result_array();
        foreach($rs_cuentas_proyecto as $row){
            $dataParaVista['proyectos'][$row['idCuenta']][$row['idProyecto']]=$row['proyecto'];

            $dataParaVista['proyectos_'][$row['idProyecto']]['proyecto']=$row['proyecto'];
            $dataParaVista['proyectos_'][$row['idProyecto']]['idProyecto']=$row['idProyecto'];
        }
       
        $rs_grupo_canal = $this->model->getGrupoCanal()->result_array();
        foreach($rs_grupo_canal as $row){
            $dataParaVista['grupoCanales'][$row['idCuenta']][$row['idGrupoCanal']]=$row['grupoCanal'];
            $dataParaVista['grupoCanal_'][$row['idGrupoCanal']]['idGrupoCanal']=$row['idGrupoCanal'];
            $dataParaVista['grupoCanal_'][$row['idGrupoCanal']]['grupoCanal']=$row['grupoCanal'];
        }

        $rs_tipo_usuario = $this->model->getTipoUsuario()->result_array();
        foreach($rs_tipo_usuario as $row){
            $dataParaVista['tipoUsuarios'][$row['idCuenta']][$row['idTipoUsuario']]=$row['tipoUsuario'];
            $dataParaVista['tipoUsuario_'][$row['idTipoUsuario']]['idTipoUsuario']=$row['idTipoUsuario'];
            $dataParaVista['tipoUsuario_'][$row['idTipoUsuario']]['tipoUsuario']=$row['tipoUsuario'];
        }


        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view('modulos/Configuraciones/Maestros/Aplicaciones/MenuCuenta/formActualizar', $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarMenuCuenta()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarMenuCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'idAplicacion' => ['requerido'],
            'idMenu' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->model->checkMenuCuentaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con los mismos datos.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->model->actualizarMenuCuenta($post);

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
}
