<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TipoPremiacion extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuraciones/gestion/m_tipopremiacion', 'm_tipopremiacion');

        $this->titulo = [
            'cambiarEstado' => 'Activar/Desactivar',

            'actualizarTipoPremiacion' => 'Actualizar Tipo Premiacion',
            'registrarTipoPremiacion' => 'Registrar Tipo Premiacion',
            'masivoTipoPremiacion' => 'Guardar Masivo Tipo Premiacion',
        ];

        $this->carpetaHtml = 'modulos/Configuraciones/gestion/tipoPremiacion/';

        $this->html = [
            'tipoPremiacion' => [
                'tabla' => $this->carpetaHtml .  'tipoPremiacionTabla',
                'new' => $this->carpetaHtml .  'tipoPremiacionFormNew',
                'update' => $this->carpetaHtml .  'tipoPremiacionFormUpdate',
                'cargaMasiva' => $this->carpetaHtml .  'tipoPremiacionFormCargaMasiva'
            ],
        ];
    }

    public function index()
    {
        $config = array();
        $config['nav']['menu_active'] = '126';
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
            'assets/custom/js/configuraciones/gestion/tipopremiacion',
        ];

        $config['data']['icon'] = 'fal fa-trophy-alt';
        $config['data']['title'] = 'Tipo Premiaciones';
        $config['data']['message'] = 'Módulo para cambiar los Tipo Premiaciones';
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
            case 'TipoPremiacion':
                $tabla = $this->m_tipopremiacion->tablas['tipoPremiacion']['tabla'];
                $idTabla = $this->m_tipopremiacion->tablas['tipoPremiacion']['id'];
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

        $cambioEstado = $this->m_tipopremiacion->actualizarMasivo($tabla, $update, $idTabla);

        if (!$cambioEstado) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['content'] = getMensajeGestion('cambioEstadoExitoso');
        }
        echo json_encode($result);
    }

    public function getTablaTipoPremiacion()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $resultados = $this->m_tipopremiacion->getTipoPremiacion($post)->result_array();

        $result['result'] = 1;
        if (count($resultados) < 1) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $dataParaVista['resultados'] = $resultados;
            $result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['tabla'], $dataParaVista, true);
        }

        echo json_encode($result);
    }

    public function getFormNewTipoPremiacion()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarTipoPremiacion'];

        $dataParaVista = [];

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['new'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function registrarTipoPremiacion()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['registrarTipoPremiacion'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta_tipoPremiacion' => ['requerido'],
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_tipopremiacion->checkTipoPremiacionRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $registro = $this->m_tipopremiacion->registrarTipoPremiacion($post);
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

    public function getFormUpdateTipoPremiacion()
    {
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarTipoPremiacion'];

        $post = json_decode($this->input->post('data'), true);

        $dataParaVista = [];
        $dataParaVista['tipoPremiacion'] = $this->m_tipopremiacion->getTipoPremiacion($post)->row_array();

        $result['result'] = 1;
        $result['data']['width'] = '45%';
        $result['data']['html'] = $this->load->view($this->html['tipoPremiacion']['update'], $dataParaVista, true);

        echo json_encode($result);
    }

    public function actualizarTipoPremiacion()
    {
        $this->db->trans_start();
        $result = $this->result;
        $result['msg']['title'] = $this->titulo['actualizarTipoPremiacion'];

        $post = json_decode($this->input->post('data'), true);

        $elementosAValidar = [
            'nombre' => ['requerido'],
            'cuenta_tipoPremiacion' => ['requerido']
        ];
        $validaciones = verificarValidacionesBasicas($elementosAValidar, $post);

        if ($this->m_tipopremiacion->checkTipoPremiacionRepetido($post)) $validaciones['nombre'][] = 'Ya existe un registro con el mismo nombre en la cuenta.';

        $result['data']['validaciones'] = $validaciones;

        if (!verificarSeCumplenValidaciones($validaciones)) {
            $result['result'] = 0;
            $result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
            goto respuesta;
        }

        $actualizo = $this->m_tipopremiacion->actualizarTipoPremiacion($post);

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
