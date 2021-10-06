<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CarteraObjetivo extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_cartera_objetivo', 'model');
    }

    public function index()
    {
        $this->aSessTrack = ['idAccion' => 4];

        $config = array();
        $config['nav']['menu_active'] = '131';
        $config['css']['style'] = array(
            'assets/libs/handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
        );
        $config['js']['script'] = array(
            'assets/libs/datatables/responsive.bootstrap4.min',
            'assets/custom/js/core/datatables-defaults',
            'assets/libs//handsontable@7.4.2/dist/handsontable.full.min',
            'assets/libs/handsontable@7.4.2/dist/languages/all',
            'assets/libs/handsontable@7.4.2/dist/moment/moment',
            'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday',
            'assets/custom/js/core/HTCustom',
            'assets/custom/js/carteraObjetivo'
        );

        $config['data']['icon'] = 'fas fa-bullseye-arrow';
        $config['data']['title'] = 'Cartera Objetivo';
        $config['data']['message'] = 'Cartera Objetivo';
        $config['view'] = 'modulos/CarteraObjetivo/index';

        $this->view($config);
    }

    public function reporte()
    {
        $result = $this->result;
        $post = json_decode($this->input->post('data'), true);

        $datos = $this->model->obtener_cartera_objetivo($post);

        $html = getMensajeGestion('noRegistros');
        if (!empty($datos['datos'])) {
            $html = $this->load->view("modulos/CarteraObjetivo/reporte", $datos, true);
        }

        $result['result'] = 1;
        $result['data']['views']['idContentCarteraObjetivo']['datatable'] = 'tb-carteraobjetivo';
        $result['data']['views']['idContentCarteraObjetivo']['html'] = $html;
        $result['data']['configTable'] =  [
            'columnDefs' =>
            [
                0 =>
                [
                    "visible" => false,
                    "targets" => [2, 3]
                ]
            ],
            // 'dom' => '<"ui icon input"f>tip',
        ];

        echo json_encode($result);
    }

    public function carga_masiva()
    {
        $result = $this->result;

        $post = json_decode($this->input->post('data'), true);

        $idProyecto = $this->sessIdProyecto;

        $cuenta = [];
        $proyecto = [];
        // $grupoCanal = [];
        // $canal = [];
        $subCanal = [];
        $distribuidoraSucursal = [];
        $plaza = [];

        $array['cuentas'] = $this->model->get_cuenta(['idProyecto' => $idProyecto]);
        $array['proyectos'] = $this->model->get_proyecto(['idProyecto' => $idProyecto]);
        // $array['gruposCanales'] = $this->model->get_grupoCanal(['idProyecto' => $idProyecto]);
        // $array['canales'] = $this->model->get_canal(['idProyecto' => $idProyecto]);
        $array['subcanales'] = $this->model->get_subCanal(['idProyecto' => $idProyecto]);
        $array['distribuidorasSucursales'] = $this->model->get_distribuidoraSucursal(['idProyecto' => $idProyecto]);
        $array['plazas'] = $this->model->get_plaza(['idProyecto' => $idProyecto]);

        $dataRefactorizada = [];
        foreach ($array['cuentas'] as $row) {
            if (!in_array($row['cuenta'], $dataRefactorizada)) $dataRefactorizada[] = $row['cuenta'];
        }
        $cuenta = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        $dataRefactorizada = [];
        foreach ($array['proyectos'] as $row) {
            if (!in_array($row['proyecto'], $dataRefactorizada)) $dataRefactorizada[] = $row['proyecto'];
        }
        $proyecto = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        // $dataRefactorizada = [];
        // foreach ($array['gruposCanales'] as $row) {
        // 	if (!in_array($row['grupoCanal'], $dataRefactorizada)) $dataRefactorizada[] = $row['grupoCanal'];
        // }
        // $grupoCanal = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        // $dataRefactorizada = [];
        // foreach ($array['canales'] as $row) {
        // 	if (!in_array($row['canal'], $dataRefactorizada)) $dataRefactorizada[] = $row['canal'];
        // }
        // $canal = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        $dataRefactorizada = [];
        foreach ($array['subcanales'] as $row) {
            if (!in_array($row['subCanal'], $dataRefactorizada)) $dataRefactorizada[] = $row['subCanal'];
        }
        $subCanal = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        $dataRefactorizada = [];
        foreach ($array['distribuidorasSucursales'] as $row) {
            if (!in_array($row['distribuidoraSucursal'], $dataRefactorizada)) $dataRefactorizada[] = $row['distribuidoraSucursal'];
        }
        $distribuidoraSucursal = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        $dataRefactorizada = [];
        foreach ($array['plazas'] as $row) {
            if (!in_array($row['plaza'], $dataRefactorizada)) $dataRefactorizada[] = $row['plaza'];
        }
        $plaza = !empty($dataRefactorizada) ? ($dataRefactorizada) : [' '];

        $HT[0] = [
            'nombre' => 'Cartera (Carga Masiva)',
            'data' => [
                0 => [
                    'cuenta' => null,
                    'proyecto' => null,
                    // 'grupoCanal' => null,
                    // 'canal' => null,
                    'subCanal' => null,
                    'distribuidoraSucursal' => null,
                    'plaza' => null,
                    'fechaIni' => null,
                    'fechaFin' => null,
                    'cartera' => null
                ]
            ],
            'headers' => [
                'CUENTA(*) ',
                'PROYECTO(*) ',
                // 'GRUPO CANAL(*) ',
                // 'CANAL(*) ',
                'SUB CANAL(*) ',
                'DISTRIBUIDORA SUCURSAL ',
                'PLAZA ',
                'FECHA INICIO(*) ',
                'FECHA FIN ',
                'CARTERA(*) ',
            ],
            'columns' => [
                ['data' => 'cuenta', 'type' => 'myDropdown', 'placeholder' => 'Cuenta', 'width' => '100%', 'source' => $cuenta],
                ['data' => 'proyecto', 'type' => 'myDropdown', 'placeholder' => 'Proyecto', 'width' => '100%', 'source' => $proyecto],
                // ['data' => 'grupoCanal', 'type' => 'myDropdown', 'placeholder' => 'Grupo Canal', 'width' => '100%', 'source'=>$grupoCanal],
                // ['data' => 'canal', 'type' => 'myDropdown', 'placeholder' => 'Canal', 'width' => '100%', 'source'=>$canal],
                ['data' => 'subCanal', 'type' => 'myDropdown', 'placeholder' => 'Sub Canal', 'width' => '100%', 'source' => $subCanal],
                ['data' => 'distribuidoraSucursal', 'type' => 'myDropdown', 'placeholder' => 'Distribuidora Sucursal', 'width' => '100%', 'source' => $distribuidoraSucursal],
                ['data' => 'plaza', 'type' => 'myDropdown', 'placeholder' => 'Plaza', 'width' => '100%', 'source' => $plaza],
                ['data' => 'fechaIni', 'type' => 'date', 'placeholder' => 'Fecha Inicio', 'width' => '100%'],
                ['data' => 'fechaFin', 'type' => 'date', 'placeholder' => 'Fecha Fin', 'width' => '100%'],
                ['data' => 'cartera', 'type' => 'text', 'placeholder' => 'Cartera', 'width' => '100%'],
            ],
            'colWidths' => '100%',
            // 'hideColumns'=> [1, 2],
        ];
        $data['hojas'] = [0 => $HT[0]['nombre']];
        $result['result'] = 1;
        $result['data']['ht'] = $HT;

        $result['data']['html'] = $this->load->view("modulos/CarteraObjetivo/form_masivo", $data, true);

        echo json_encode($result);
    }

    public function guardar_carga_masiva()
    {
        $this->db->trans_start();
        $result = $this->result;

        $idProyecto = $this->sessIdProyecto;
        $idCuenta = $this->sessIdCuenta;

        $post = json_decode($this->input->post('data'), true);
        $result['msg']['title'] = 'Carga masiva de cartera';

        $array = [
            'cuentas' => [],
            'proyectos' => [],
            // 'grupoCanales' => [],
            // 'canales' => [],
            'subCanales' => [],
            'distribuidorasSucursales' => [],
            'plazas' => []
        ];

        $cuentas = $this->model->get_cuenta(['idProyecto' => $idProyecto]);
        $proyectos = $this->model->get_proyecto(['idProyecto' => $idProyecto]);
        // $grupoCanales = $this->model->get_grupoCanal(['idProyecto' => $idProyecto]);
        // $canales = $this->model->get_canal(['idProyecto' => $idProyecto]);
        $subCanales = $this->model->get_subCanal(['idProyecto' => $idProyecto]);
        $distribuidorasSucursales = $this->model->get_distribuidoraSucursal(['idProyecto' => $idProyecto]);
        $plazas  = $this->model->get_plaza(['idProyecto' => $idProyecto]);

        foreach ($cuentas as $key => $row) {
            $array['cuentas'][$row['cuenta']] = $row['id'];
        }
        foreach ($proyectos as $key => $row) {
            $array['proyectos'][$row['proyecto']] = $row['id'];
        }
        // foreach ($grupoCanales as $key => $row) {
        // 	$array['grupoCanales'][$row['grupoCanal']] = $row['id'];
        // }
        // foreach ($canales as $key => $row) {
        // 	$array['canales'][$row['canal']] = $row['id'];
        // }
        foreach ($subCanales as $key => $row) {
            $array['subCanales'][$row['subCanal']] = $row['id'];
        }
        foreach ($distribuidorasSucursales as $key => $row) {
            $array['distribuidorasSucursales'][$row['distribuidoraSucursal']] = $row['id'];
        }
        foreach ($plazas as $key => $row) {
            $array['plazas'][$row['plaza']] = $row['id'];
        }

        array_pop($post['HT'][0]);

        if (empty($post['HT'][0])) {
            $result['result'] = 0;
            $result['msg']['title'] = 'Alerta!';
            $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'La carga masiva no contiene datos']);
            goto respuesta;
        }

        $insert = [];

        foreach ($post['HT'][0] as $key => $value) {
            if (empty($value['cuenta']) or empty($value['proyecto']) or empty($value['subCanal']) or empty($value['cartera']) or empty($value['fechaIni'])) {
                $result['result'] = 0;
                $result['msg']['title'] = 'Alerta!';
                $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'Los campos con (*) son obligatorios, asegúrese de completarlos']);
                goto respuesta;
            }

            $idCuenta = !empty($array['cuentas'][$value['cuenta']]) ? $array['cuentas'][$value['cuenta']] : NULL;
            if (empty($idCuenta)) {
                $result['result'] = 0;
                $result['msg']['title'] = 'Alerta!';
                $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'La <strong>CUENTA</strong> ingresado no existe en el sistema.<br> Fila:' . ($key + 1)]);
                goto respuesta;
            }
            $idProyecto = !empty($array['proyectos'][$value['proyecto']]) ? $array['proyectos'][$value['proyecto']] : NULL;
            if (empty($idProyecto)) {
                $result['result'] = 0;
                $result['msg']['title'] = 'Alerta!';
                $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'El <strong>PROYECTO</strong> ingresado no existe en el sistema.<br> Fila:' . ($key + 1)]);
                goto respuesta;
            }
            $idSubCanal = !empty($array['subCanales'][$value['subCanal']]) ? $array['subCanales'][$value['subCanal']] : NULL;
            if (empty($idSubCanal)) {
                $result['result'] = 0;
                $result['msg']['title'] = 'Alerta!';
                $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'El <strong>SUB CANAL</strong> ingresado no existe en el sistema.<br> Fila:' . ($key + 1)]);
                goto respuesta;
            }

            $idDistribuidoraSucursal = NULL;
            if (!empty($value['distribuidoraSucursal'])) {
                $idDistribuidoraSucursal = !empty($array['distribuidorasSucursales'][$value['distribuidoraSucursal']]) ? $array['distribuidorasSucursales'][$value['distribuidoraSucursal']] : NULL;
                if (empty($idDistribuidoraSucursal)) {
                    $result['result'] = 0;
                    $result['msg']['title'] = 'Alerta!';
                    $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'La <strong>DISTRIBUIDORA SUCURSAL</strong> ingresado no existe en el sistema.<br> Fila:' . ($key + 1)]);
                    goto respuesta;
                }
            }

            $idPlaza = NULL;
            if (!empty($value['plaza'])) {
                $idPlaza = !empty($array['plazas'][$value['plaza']]) ? $array['plazas'][$value['plaza']] : NULL;
                if (empty($idPlaza)) {
                    $result['result'] = 0;
                    $result['msg']['title'] = 'Alerta!';
                    $result['msg']['content'] = createMessage(['type' => 2, 'message' => 'La <strong>PLAZA</strong> ingresado no existe en el sistema.<br> Fila:' . ($key + 1)]);
                    goto respuesta;
                }
            }

            $canal_grupoCanal = $this->model->get_canal_grupoCanal(['idSubCanal' => $idSubCanal]);

            $insert[] = [
                'idCuenta' => $idCuenta,
                'idProyecto' => $idProyecto,
                'idSubCanal' => $idSubCanal,
                'idGrupoCanal' => $canal_grupoCanal['idGrupoCanal'],
                'idCanal' => $canal_grupoCanal['idCanal'],
                'idDistribuidoraSucursal' => $idDistribuidoraSucursal,
                'idPlaza' => $idPlaza,
                'fecIni' => $value['fechaIni'],
                'fecFin' => verificarEmpty($value['fechaFin'], 4),
                'cartera' => $value['cartera']
            ];
        }

        $registro = false;

        if (!empty($insert)) {
            $registro = $this->model->insertarMasivoCarteraObjetivo($insert);
        }

        if (!$registro['insert']) {
            $result['result'] = 0;
            $result['msg']['title'] = 'Alerta!';
            $result['msg']['content'] = getMensajeGestion('registroErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['title'] = 'Hecho!';
            $result['msg']['content'] = getMensajeGestion('registroExitoso');
        }

        $this->db->trans_complete();

        respuesta:
        echo json_encode($result);
    }

    public function formulario()
    {
        $result = $this->result;

        $post = json_decode($this->input->post('data'), true);

        $post['cuenta_filtro'] = $this->sessIdCuenta;
        $post['proyecto_filtro'] = $this->sessIdProyecto;

        $datos = $this->model->obtener_cartera_objetivo($post);
        $datos['datos'] = $datos['datos'][0];

        $datos['cuentas'] = $this->model->get_cuenta(['idProyecto' => $this->sessIdProyecto]);
        $datos['proyectos'] = $this->model->get_proyecto(['idProyecto' => $this->sessIdProyecto]);
        $datos['subCanales'] = $this->model->get_subCanal(['idProyecto' => $this->sessIdProyecto]);
        $datos['distribuidorasSucursales'] = $this->model->get_distribuidoraSucursal(['idProyecto' => $this->sessIdProyecto]);
        $datos['plazas']  = $this->model->get_plaza(['idProyecto' => $this->sessIdProyecto]);

        $result['result'] = 1;
        $result['msg']['title'] = 'Actualizar Cartera';
        $result['data']['html'] = $this->load->view("modulos/CarteraObjetivo/formulario", $datos, true);

        respuesta:
        echo json_encode($result);
    }

    public function actualizar()
    {
        $result = $this->result;

        $post = json_decode($this->input->post('data'), true);

        $canal_grupoCanal = $this->model->get_canal_grupoCanal(['idSubCanal' => $post['sel-cartera-sub-canal']]);

        $post['idGrupoCanal'] = $canal_grupoCanal['idGrupoCanal'];
        $post['idCanal'] = $canal_grupoCanal['idCanal'];

        $verif = [];

        $verif['verificar'] = true;
        $verif['proyecto_filtro'] = $post['sel-cartera-proyecto'];
        $verif['cuenta_filtro'] = $post['sel-cartera-cuenta'];
        $verif['grupoCanal_filtro'] = $post['idGrupoCanal'];
        $verif['canal_filtro'] = $post['idCanal'];
        $verif['subcanal_filtro'] = $post['sel-cartera-sub-canal'];
        $verif['verificar_distribuidoraSucursal'] = $post['sel-cartera-rd'];
        $verif['verificar_plaza'] = $post['sel-cartera-plaza'];
        $verif['verificar_fechaFin'] = $post['fechaFin'];
        $verif['verificar_fechaInicio'] = $post['fechaIni'];
        $verif['verificar_idObjetivo'] = $post['id'];

        $verificar_duplicado = $this->model->obtener_cartera_objetivo($verif);

        if (!empty($verificar_duplicado['datos'])) {
            $result['result'] = 0;
            $result['msg']['title'] = 'Alerta!';
            $result['msg']['content'] = getMensajeGestion('registroRepetido');
            goto respuesta;
        }

        $registro = $this->model->actualizarCarteraObjetivo($post);

        if (!$registro['status']) {
            $result['result'] = 0;
            $result['msg']['title'] = 'Alerta!';
            $result['msg']['content'] = getMensajeGestion('registroErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['title'] = 'Hecho!';
            $result['msg']['content'] = getMensajeGestion('registroExitoso');
        }

        respuesta:
        echo json_encode($result);
    }

    public function actualizar_estado()
    {
        $result = $this->result;

        $post = json_decode($this->input->post('data'), true);

        if (!empty($post)) {
            $registro = $this->model->actualizarEstadoCarteraObjetivo($post);
        }

        if (!$registro['status']) {
            $result['result'] = 0;
            $result['msg']['title'] = 'Alerta!';
            $result['msg']['content'] = getMensajeGestion('registroErroneo');
        } else {
            $result['result'] = 1;
            $result['msg']['title'] = 'Hecho!';
            $result['msg']['content'] = getMensajeGestion('registroExitoso');
        }

        respuesta:
        echo json_encode($result);
    }
}
