<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MapeoMuebles extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('gestionGerencial/M_visibilidad', 'model');
    }

    public function index()
    {
        $config = [];
        $config['nav']['menu_active'] = $idMenu = '146';
        $config['css']['style'] = array(
            'assets/custom/css/gestionGerencial/iniciativas'
        );
        $config['js']['script'] = array(
            'assets/libs/fileDownload/jquery.fileDownload',
            'assets/libs/datatables/responsive.bootstrap4.min',
            'assets/custom/js/core/datatables-defaults',
            'assets/custom/js/gestionGerencial/mapeoMuebles'
        );
        $tabs = getTabPermisos(['idMenuOpcion' => $idMenu])->result_array();

        $config['data']['icon'] = 'fas fa-couch';
        $config['data']['title'] = 'Mapeo de Muebles';
        $config['data']['message'] = 'Mapeo de Muebles';
        if (empty($tabs)) {
            $config['view'] = 'oops';
        } else {
            $config['view'] = 'modulos/gestionGerencial/mapeoMuebles/index';
            $config['data']['tabs'] = $tabs;
        }

        $this->view($config);
    }

    public function filtrar()
    {
        $result = $this->result;
        $data = json_decode($this->input->post('data'));

        $fechas = explode(' - ', $data->{'txt-fechas'});

        $input = array();
        $input['fecIni'] = $fechas[0];
        $input['fecFin'] = $fechas[1];

        $input['proyecto_filtro'] = $data->{'proyecto_filtro'};
        $input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
        $input['canal_filtro'] = $data->{'canal_filtro'};

        $input['distribuidoraSucursal_filtro'] = empty($data->{'distribuidoraSucursal_filtro'}) ? '' : $data->{'distribuidoraSucursal_filtro'};
        $input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
        $input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
        $input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
        $input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
        $input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

        $array = [];
        $result['result'] = 1;
        $result['data']['views']['idContentMapeoMuebles']['datatable'] = 'tb-mapeoMuebles';
        $result['data']['views']['idContentMapeoMuebles']['html'] = $this->load->view("modulos/gestionGerencial/mapeoMuebles/detalle", $array, true);
        $result['data']['configTable'] = [];

        respuesta:
        echo json_encode($result);
    }

    public function filtrarSummary()
    {
        $result = $this->result;
        $data = json_decode($this->input->post('data'));

        $fechas = explode(' - ', $data->{'txt-fechas'});

        $input = array();
        $input['fecIni'] = $fechas[0];
        $input['fecFin'] = $fechas[1];

        $input['proyecto_filtro'] = $data->{'proyecto_filtro'};
        $input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};
        $input['canal_filtro'] = $data->{'canal_filtro'};

        $input['distribuidoraSucursal_filtro'] = empty($data->{'distribuidoraSucursal_filtro'}) ? '' : $data->{'distribuidoraSucursal_filtro'};
        $input['distribuidora_filtro'] = empty($data->{'distribuidora_filtro'}) ? '' : $data->{'distribuidora_filtro'};
        $input['zona_filtro'] = empty($data->{'zona_filtro'}) ? '' : $data->{'zona_filtro'};
        $input['plaza_filtro'] = empty($data->{'plaza_filtro'}) ? '' : $data->{'plaza_filtro'};
        $input['cadena_filtro'] = empty($data->{'cadena_filtro'}) ? '' : $data->{'cadena_filtro'};
        $input['banner_filtro'] = empty($data->{'banner_filtro'}) ? '' : $data->{'banner_filtro'};

        $array = [];
        $result['result'] = 1;
        $result['data']['views']['idContentMMSummary']['datatable'] = 'tb-mapeoMueblesSummary';
        $result['data']['views']['idContentMMSummary']['html'] = $this->load->view("modulos/gestionGerencial/mapeoMuebles/summary", $array, true);
        $result['data']['configTable'] = [];

        respuesta:
        echo json_encode($result);
    }
}
