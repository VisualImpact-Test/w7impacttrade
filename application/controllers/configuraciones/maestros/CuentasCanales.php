<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CuentasCanales extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuraciones/maestros/m_cuentascanales', 'm_cuentascanales');

        $this->titulo = [
            'cambiarEstado' => 'Activar/Desactivar',

            'actualizarCuenta' => 'Actualizar Cuenta',
            'registrarCuenta' => 'Registrar Cuenta',
            'masivoCuenta' => 'Guardar Masivo Cuenta',

            'actualizarTipoUsuarioCuenta' => 'Actualizar Tipo Usuario de Cuenta',
            'registrarTipoUsuarioCuenta' => 'Registrar Tipo Usuario de Cuenta',
            'masivoTipoUsuarioCuenta' => 'Guardar Masivo Tipo Usuario de Cuenta',

            'actualizarProyecto' => 'Actualizar Proyecto',
            'registrarProyecto' => 'Registrar Proyecto',
            'masivoProyecto' => 'Guardar Masivo Proyecto',

            'actualizarGrupoCanal' => 'Actualizar GrupoCanal',
            'registrarGrupoCanal' => 'Registrar GrupoCanal',
            'masivoGrupoCanal' => 'Guardar Masivo GrupoCanal',

            'actualizarCanal' => 'Actualizar Canal',
            'registrarCanal' => 'Registrar Canal',
            'masivoCanal' => 'Guardar Masivo Canal',

            'actualizarSubCanal' => 'Actualizar SubCanal',
            'registrarSubCanal' => 'Registrar SubCanal',
            'masivoSubCanal' => 'Guardar Masivo SubCanal',
        ];

        $this->carpetaHtml = 'modulos/Configuraciones/Maestros/CuentasCanales/';

        $this->html = [
            'cuenta' => [
                'tabla' => $this->carpetaHtml .  'cuentaTabla',
                'new' => $this->carpetaHtml .  'cuentaFormNew',
                'update' => $this->carpetaHtml .  'cuentaFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'cuentaFormCargaMasiva'
            ],
            'tipoUsuarioCuenta' => [
                'tabla' => $this->carpetaHtml .  'tipoUsuarioCuentaTabla',
                'new' => $this->carpetaHtml .  'tipoUsuarioCuentaFormNew',
                'update' => $this->carpetaHtml .  'tipoUsuarioCuentaFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'tipoUsuarioCuentaFormCargaMasiva'
            ],
            'proyecto' => [
                'tabla' => $this->carpetaHtml .  'proyectoTabla',
                'new' => $this->carpetaHtml .  'proyectoFormNew',
                'update' => $this->carpetaHtml .  'proyectoFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'proyectoFormCargaMasiva'
            ],
            'grupoCanal' => [
                'tabla' => $this->carpetaHtml .  'grupoCanalTabla',
                'new' => $this->carpetaHtml .  'grupoCanalFormNew',
                'update' => $this->carpetaHtml .  'grupoCanalFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'grupoCanalFormCargaMasiva'
            ],
            'canal' => [
                'tabla' => $this->carpetaHtml .  'canalTabla',
                'new' => $this->carpetaHtml .  'canalFormNew',
                'update' => $this->carpetaHtml .  'canalFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'canalFormCargaMasiva'
            ],
            'subCanal' => [
                'tabla' => $this->carpetaHtml .  'subCanalTabla',
                'new' => $this->carpetaHtml .  'subCanalFormNew',
                'update' => $this->carpetaHtml .  'subCanalFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'subCanalFormCargaMasiva'
            ]
        ];
    }

    public function index()
    {
        $config = array();
        $config['nav']['menu_active'] = '127';
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
            'assets/custom/js/configuraciones/maestros/cuentascanales',
        ];

        $config['data']['icon'] = 'far fa-copyright';
        $config['data']['title'] = 'Cuentas y Canales';
        $config['data']['message'] = 'Módulo para cambiar los filtros';
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
            case 'Cuenta':
                $tabla = $this->m_cuentascanales->tablas['cuenta']['tabla'];
                $idTabla = $this->m_cuentascanales->tablas['cuenta']['id'];
                break;
            case 'TipoUsuarioCuenta':
                $tabla = $this->m_cuentascanales->tablas['tipoUsuarioCuenta']['tabla'];
                $idTabla = $this->m_cuentascanales->tablas['tipoUsuarioCuenta']['id'];
                break;
            case 'Proyecto':
                $tabla = $this->m_cuentascanales->tablas['proyecto']['tabla'];
                $idTabla = $this->m_cuentascanales->tablas['proyecto']['id'];
                break;
            case 'GrupoCanal':
                $tabla = $this->m_cuentascanales->tablas['grupoCanal']['tabla'];
                $idTabla = $this->m_cuentascanales->tablas['grupoCanal']['id'];
                break;
            case 'Canal':
                $tabla = $this->m_cuentascanales->tablas['canal']['tabla'];
                $idTabla = $this->m_cuentascanales->tablas['canal']['id'];
                break;
            case 'SubCanal':
                $tabla = $this->m_cuentascanales->tablas['subCanal']['tabla'];
                $idTabla = $this->m_cuentascanales->tablas['subCanal']['id'];
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

        $cambioEstado = $this->m_cuentascanales->actualizarMasivo($tabla, $update, $idTabla);

        if (!$cambioEstado) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
        }
        echo json_encode($result);
    }

    // SECCION CUENTAS
    public function getTablaCuenta()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_cuentascanales->getCuentas($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['cuenta']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewCuenta()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarCuenta'];

        $dataParaVista = [];

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['cuenta']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarCuenta()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarCuenta'];

        // $post = json_decode($this->input->post('data'), true);
        $post = $_POST;
        $archivo = $_FILES['file']['name'];

        $post['urlLogo'] = $archivo;

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

        if ($this->m_cuentascanales->checkNombreCuentaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
        if ($this->m_cuentascanales->checkRucCuentaRepetido($post)) $validaciones['ruc'][] = getMensajeGestion('registroRepetido');
        if ($this->m_cuentascanales->checkNombreComercialCuentaRepetido($post)) $validaciones['nombreComercial'][] = getMensajeGestion('registroRepetido');
        if ($this->m_cuentascanales->checkRazonSocialCuentaRepetido($post)) $validaciones['razonSocial'][] = getMensajeGestion('registroRepetido');

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_cuentascanales->registrarCuenta($post);
        if (!$registro) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('registroExitoso');

            copy($_FILES['file']['tmp_name'], 'public/assets/images/logos/' . $archivo);
        }

        $this->db->trans_complete();

        respuesta:
        echo json_encode($result);
    }

    public function getFormUpdateCuenta()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista['cuenta'] = $this->m_cuentascanales->getCuentas($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['cuenta']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarCuenta()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $post = $_POST;

        if (!empty($_FILES)) {
            $archivo = $_FILES['file']['name'];
            $post['urlLogo'] = $archivo;
        }

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'ruc' => ['requerido', 'numerico'],
            'nombreComercial' => ['requerido'],
            'razonSocial' => ['requerido'],
            'direccion' => ['requerido'],
            'ubigeo' => ['requerido', 'numerico'],
            'urlCss' => [],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkNombreCuentaRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');
        if ($this->m_cuentascanales->checkRucCuentaRepetido($post)) $validaciones['ruc'][] = getMensajeGestion('registroRepetido');
        if ($this->m_cuentascanales->checkNombreComercialCuentaRepetido($post)) $validaciones['nombreComercial'][] = getMensajeGestion('registroRepetido');
        if ($this->m_cuentascanales->checkRazonSocialCuentaRepetido($post)) $validaciones['razonSocial'][] = getMensajeGestion('registroRepetido');

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_cuentascanales->actualizarCuenta($post);

        if (!$actualizo) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('actualizacionErronea');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('actualizacionExitosa');

            if (!empty($_FILES)) {
                copy($_FILES['file']['tmp_name'], 'public/assets/images/logos/' . $archivo);
            }
        }

        $this->db->trans_complete();

        respuesta:
        echo json_encode($result);
    }

    // SECCION PROYECTO
    public function getTablaProyecto()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_cuentascanales->getProyectos($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['proyecto']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewProyecto()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarProyecto'];

        $dataParaVista = [];
        $dataParaVista['cuentas'] = $this->m_cuentascanales->getCuentas()->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['proyecto']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarProyecto()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarProyecto'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta' => ['selectRequerido'],
            'fechaInicio' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkProyectoYCuentaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un proyecto con el mismo nombre y cuenta asociada.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_cuentascanales->registrarProyecto($post);
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

    public function getFormUpdateProyecto()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarProyecto'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista['cuentas'] = $this->m_cuentascanales->getCuentas()->result_array();
        $dataParaVista['proyecto'] = $this->m_cuentascanales->getProyectos($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['proyecto']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarProyecto()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarProyecto'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta' => ['selectRequerido'],
            'fechaInicio' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkProyectoYCuentaRepetido($post)) $validaciones['nombre'][] = 'Ya existe un proyecto con el mismo nombre y cuenta asociada.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_cuentascanales->actualizarProyecto($post);

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

    public function getFormCargaMasivaProyecto()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['masivoProyecto'];

        $cuentas = $this->m_cuentascanales->getCuentas()->result_array();

        //REFACTORIZANDO DATA
        $cuentasRefactorizado = [];
        foreach ($cuentas as $row) {
            if (!in_array($row['nombre'], $cuentasRefactorizado)) $cuentasRefactorizado[] = $row['nombre'];
        }
        $cuentas = !empty($cuentasRefactorizado) ? $cuentasRefactorizado : [' '];

        //ARMANDO HANDSONTABLE
        $HT[0] = [
            'nombre' => 'Proyectos',
            'data' => [
                ['nombre' => null, 'cuenta' => null, 'fechaInicio' => null, 'fechaFin' => null]
            ],
            'headers' => ['Nombre', 'Cuenta', 'Fecha Inicio', 'Fecha Fin'],
            'columns' => [
                ['data' => 'nombre', 'type' => 'text', 'placeholder' => 'Nombre'],
                ['data' => 'cuenta', 'type' => 'myDropdown', 'placeholder' => 'Cuenta', 'source' => $cuentas],
                ['data' => 'fechaInicio', 'type' => 'myDate'],
                ['data' => 'fechaFin', 'type' => 'myDate']
            ],
            'colWidths' => 200,
        ];

        //MOSTRANDO VISTA
        $dataParaVista['hojas'] = [0 => $HT[0]['nombre']];
        $result['result'] = 1;
        $result['data']['width'] = '70%';
        $result['data']['html'] = $this->load->view($this->html['proyecto']['cargaMasiva'], $dataParaVista, true);
        $result['data']['ht'] = $HT;

        echo json_encode($result);
    }

    public function guardarCargaMasivaProyecto()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['masivoProyecto'];

        $post = json_decode($this->input->post('data'), true);

        $proyectos = $post['HT']['0'];
        $proyectosParams['tablaHT'] = $proyectos;
        $proyectosParams['grupos'][0] = ['columnas' => ['cuenta'], 'columnasReales' => ['nombre'], 'tabla' => 'trade.cuenta', 'idTabla' => 'idCuenta'];
        $proyectos = $this->getIdsCorrespondientes($proyectosParams);
        array_pop($proyectos);

        $insertMasivo = $this->m_cuentascanales->guardarMasivoProyecto($proyectos);

        if (!$insertMasivo) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('guardadoMasivoErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('guardadoMasivoExitoso');
        }

        $this->db->trans_complete();
        echo json_encode($result);
    }

    // SECCION GRUPO CANAL
    public function getTablaGrupoCanal()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_cuentascanales->getGrupoCanales($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['grupoCanal']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewGrupoCanal()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarGrupoCanal'];

        $dataParaVista = [];

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['grupoCanal']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarGrupoCanal()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarGrupoCanal'];

        $post = json_decode($this->input->post('data'), true);

        $post['idCuenta'] = $this->sessIdCuenta;
        $post['idProyecto'] = $this->sessIdProyecto;

        $elementosAValidar = [
            'nombre' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkNombreGrupoCanalRepetido($post)) $validaciones['nombre'][] = 'El nombre ya esta registrado.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_cuentascanales->registrarGrupoCanal($post);
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

    public function getFormUpdateGrupoCanal()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarGrupoCanal'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista['grupoCanal'] = $this->m_cuentascanales->getGrupoCanales($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['grupoCanal']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarGrupoCanal()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarGrupoCanal'];

        $post = json_decode($this->input->post('data'), true);

        $post['idCuenta'] = $this->sessIdCuenta;
        $post['idProyecto'] = $this->sessIdProyecto;

        $elementosAValidar = [
            'nombre' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkNombreGrupoCanalRepetido($post)) $validaciones['nombre'][] = getMensajeGestion('registroRepetido');

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_cuentascanales->actualizarGrupoCanal($post);

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

    // SECCION CANAL
    public function getTablaCanal()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_cuentascanales->getCanales($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['canal']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewCanal()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarCanal'];

        $params = [];
        $params['proyecto_filtro'] = $this->sessIdProyecto;

        $dataParaVista = [];
        $dataParaVista['grupoCanales'] = $this->m_cuentascanales->getGrupoCanales($params)->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['canal']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarCanal()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarCanal'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'grupoCanal' => ['selectRequerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkCanalYGrupoCanalRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo canal y grupo canal.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_cuentascanales->registrarCanal($post);
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

    public function getFormUpdateCanal()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarCanal'];

        $post = json_decode($this->input->post('data'), true);

        $params = [];
        $params['proyecto_filtro'] = $this->sessIdProyecto;

        $dataParaVista['canal'] = $this->m_cuentascanales->getCanales($post)->row_array();
        $dataParaVista['grupoCanales'] = $this->m_cuentascanales->getGrupoCanales($params)->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['canal']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarCanal()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarCanal'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'grupoCanal' => ['selectRequerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkCanalYGrupoCanalRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo canal y grupo canal.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_cuentascanales->actualizarCanal($post);

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

    // SECCION SUBCANAL
    public function getTablaSubCanal()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_cuentascanales->getSubCanales($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['subCanal']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewSubCanal()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarSubCanal'];

        $dataParaVista = [];

        $params = [];
        $params['proyecto_filtro'] = $this->sessIdProyecto;

        $dataParaVista['canales'] = $this->m_cuentascanales->getCanales($params)->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['subCanal']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarSubCanal()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarSubCanal'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'canal' => ['selectRequerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkSubCanalYCanalRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo subcanal y canal.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_cuentascanales->registrarSubCanal($post);
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

    public function getFormUpdateSubCanal()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarSubCanal'];

        $post = json_decode($this->input->post('data'), true);

        $params = [];
        $params['proyecto_filtro'] = $this->sessIdProyecto;

        $dataParaVista['subCanal'] = $this->m_cuentascanales->getSubCanales($post)->row_array();
        $dataParaVista['canales'] = $this->m_cuentascanales->getCanales($params)->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['subCanal']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarSubCanal()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarSubCanal'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'canal' => ['selectRequerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkSubCanalYCanalRepetido($post)) $validaciones['idTipoUsuario'][] = 'Ya existe un registro con el mismo subcanal y canal.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_cuentascanales->actualizarSubCanal($post);

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

    public function mostrarFoto()
    {
        $data['foto'] = $this->input->post('foto');

        $this->load->view("modulos/configuraciones/maestros/cuentascanales/fotos", $data);
    }

    // SECCION TIPO USUARIO CUENTA
    public function getTablaTipoUsuarioCuenta()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_cuentascanales->getTipoUsuarioCuenta($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['tipoUsuarioCuenta']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewTipoUsuarioCuenta()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarTipoUsuarioCuenta'];

        $dataParaVista = [];
        $dataParaVista['cuentas'] = $this->m_cuentascanales->getCuentas()->result_array();
        $dataParaVista['tiposUsuarios'] = $this->m_cuentascanales->getTipoUsuario()->result_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['tipoUsuarioCuenta']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarTipoUsuarioCuenta()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarTipoUsuarioCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'cuenta' => ['selectRequerido'],
            'idTipoUsuario' => ['selectRequerido']
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkTipoUsuarioCuentaRepetido($post)) $validaciones['idTipoUsuario'][] = 'Ya existe el tipo de usuario en la cuenta seleccionada.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_cuentascanales->registrarTipoUsuarioCuenta($post);
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

    public function getFormUpdateTipoUsuarioCuenta()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarTipoUsuarioCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista['cuentas'] = $this->m_cuentascanales->getCuentas()->result_array();
        $dataParaVista['tiposUsuarios'] = $this->m_cuentascanales->getTipoUsuario()->result_array();
        $dataParaVista['tipoUsuarioCuenta'] = $this->m_cuentascanales->getTipoUsuarioCuenta($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['tipoUsuarioCuenta']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarTipoUsuarioCuenta()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarTipoUsuarioCuenta'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'cuenta' => ['selectRequerido'],
            'idTipoUsuario' => ['selectRequerido']
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_cuentascanales->checkTipoUsuarioCuentaRepetido($post)) $validaciones['idTipoUsuario'][] = 'Ya existe el tipo de usuario en la cuenta seleccionada.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_cuentascanales->actualizarTipoUsuarioCuenta($post);

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
