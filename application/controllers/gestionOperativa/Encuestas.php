<?
defined('BASEPATH') or exit('No direct script access allowed');

class Encuestas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('gestionOperativa/M_encuestas', 'model');
    }

    public function index()
    {
        $this->aSessTrack[] = ['idAccion' => 4];

        $idMenu = '143';
        $config['nav']['menu_active'] = $idMenu;
        $config['css']['style'] = [
            'assets/custom/css/asistencia'
        ];
        $config['js']['script'] = [
            'assets/libs/fileDownload/jquery.fileDownload',
            'assets/libs/datatables/responsive.bootstrap4.min',
            'assets/custom/js/core/datatables-defaults',
            'assets/custom/js/core/anyChartCustom',
            'assets/custom/js/gestionOperativa/encuestas'
        ];
        $config['data']['icon'] = 'fal fa-file-alt';
        $config['data']['title'] = 'Encuestas';
        $config['data']['message'] = 'Aquí encontrará datos de las encuestas.';
        $tabs = getTabPermisos(['idMenuOpcion' => $idMenu])->result_array();
        if (empty($tabs)) {
            $config['view'] =  'oops';
        } else {
            $config['data']['tabs'] = $tabs;
            $config['view'] = 'modulos/gestionOperativa/encuestas/index';
        }
        $config['data']['tiposPregunta'] = $this->model->getTiposDePregunta()['query']->result_array();

        $params = [];
        $params['idCuenta'] = $this->session->userdata('idCuenta');
        $config['data']['encuestasActivas'] = $this->model->getEncuestasActivas($params)['query']->result_array();

        $this->view($config);
    }

    public function getCantidadFotosPorEncuesta()
    {
        $result = $this->result;
        $result['msg']['title'] = 'Encuestas';
        $post = json_decode($this->input->post('data'), true);

        if (isset($post['idEncuesta'])) {
            $encuestas = $post['idEncuesta'];
            if (is_array($encuestas)) {
                $post['idEncuesta'] = implode(",", $encuestas);
            } else {
                $post['idEncuesta'] = $encuestas;
            }
        }

        $params = [];
        $dataParaVista = [];

        $params['idCuenta'] = empty($post['cuenta_filtro']) ? "" : $post['cuenta_filtro'];
        $params['idProyecto'] = empty($post['proyecto_filtro']) ? "" : $post['proyecto_filtro'];
        $params['idGrupoCanal'] = empty($post['grupo_filtro']) ? "" : $post['grupo_filtro'];
        $params['subcanal'] = empty($post['subcanal_filtro']) ? "" : $post['subcanal_filtro'];
        $params['idCanal'] = empty($post['canal_filtro']) ? "" : $post['canal_filtro'];
        $params['idEncuesta'] = empty($post['idEncuesta']) ? "" : $post['idEncuesta'];
        $params['tipoPregunta'] = empty($post['tipoPregunta']) ? "" : $post['tipoPregunta'];
        $params['txt-fechas'] = empty($post['txt-fechas']) ? "" : $post['txt-fechas'];

        $params['distribuidora_filtro'] = empty($post['distribuidora_filtro']) ? '' : $post['distribuidora_filtro'];
        $params['zona_filtro'] = empty($post['zona_filtro']) ? '' : $post['zona_filtro'];
        $params['plaza_filtro'] = empty($post['plaza_filtro']) ? '' : $post['plaza_filtro'];
        $params['cadena_filtro'] = empty($post['cadena_filtro']) ? '' : $post['cadena_filtro'];
        $params['banner_filtro'] = empty($post['banner_filtro']) ? '' : $post['banner_filtro'];

        $params['fecIni'] = getFechasDRP($post["txt-fechas"])[0];
        $params['fecFin'] = getFechasDRP($post["txt-fechas"])[1];

        $data = $this->model->getCantidadFotosPorEncuesta($params);
        $dataFotos = $this->model->getTotalFotosPorEncuesta($params);

        $maximoDeColumasEncuesta = 0;
        $maximoDeColumasPregunta = 0;
        $maximoDeColumasAlternativa = 0;
        foreach ($dataFotos['query']->result_array() as $key => $value) {
            $dataParaVista['fotosEncuesta'][$value['idVisitaEncuesta']][$value['tipo']][$value['idVisitaFoto']] = $value['fotoUrl'];
        }
        if (!empty($dataParaVista['fotosEncuesta'])) {
            foreach ($dataParaVista['fotosEncuesta'] as $key => $value) {
                !empty($value['ENCUESTA']) ? $maximoDeColumasEncuesta = max(count($value['ENCUESTA']), $maximoDeColumasEncuesta) : '' ;
                !empty($value['PREGUNTA']) ? $maximoDeColumasPregunta = max(count($value['PREGUNTA']), $maximoDeColumasPregunta) : '';
                !empty($value['ALTERNATIVA']) ? $maximoDeColumasAlternativa = max(count($value['ALTERNATIVA']), $maximoDeColumasAlternativa) : '' ;
            }
        }
        $dataParaVista['maximoDeColumasEncuesta'] = $maximoDeColumasEncuesta;
        $dataParaVista['maximoDeColumasPregunta'] = $maximoDeColumasPregunta;
        $dataParaVista['maximoDeColumasAlternativa'] = $maximoDeColumasAlternativa;

        $dataParaVista['visitas'] = $data['query']->result_array();

        $result['result'] = 1;
        if ($data['estado'] == false || empty($dataParaVista['visitas'])) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $segmentacion = getSegmentacion(['grupoCanal_filtro' => $params['idGrupoCanal']]);
            $dataParaVista['segmentacion'] = $segmentacion;
            $result['data']['html'] = $this->load->view("modulos/gestionOperativa/Encuestas/tablaDetalladoEncuesta", $dataParaVista, true);
            $result['data']['configTable'] = [];
        }

        echo json_encode($result);
    }

    public function getFotosPorEncuesta()
    {
        $result = $this->result;
        $result['msg']['title'] = 'Fotos de Encuestas';
        $post = json_decode($this->input->post('data'), true);

        $data = $this->model->getFotosPorEncuesta($post);

        $dataParaVista['fotos'] = $data['query']->result_array();

        $result['result'] = 1;
        if ($data['estado'] == false || empty($dataParaVista['fotos'])) {
            $result['data']['html'] = getMensajeGestion('noRegistros');
        } else {
            $result['data']['html'] = $this->load->view("modulos/gestionOperativa/Encuestas/formularioFotos", $dataParaVista, true);
        }

        echo json_encode($result);
    }

    function generar_pdf()
    {
        $dataLista = json_decode($this->input->post('data'));

        header('Set-Cookie: fileDownload=true; path=/');
        header('Cache-Control: max-age=60, must-revalidate');

        $www = base_url() . 'public/assets/images';
        $archivo = 'MODULO DE ENCUESTAS - REPORTE DE FOTOS SELECCIONADAS.pdf';

        $style = "
            <style>
                .divImagen{
                    margin: 5px !important;
                }
                img.foto{ 
                    border: 10px solid #848484; 
                }
                .head {
                    background-color:#c00002;
                    padding: 5px;
                    font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
                    font-size: 10px;
                    width: 100%;
                }
                .tdCuenta{
                    display: inline-flex;
                }
                .cuenta{
                    font-size: 20px;
                    color: #FFFFFF !important;
                    font-weight: bold;
                    text-align: left !important;
                }
                .espacio{
                    width: 140px !important;
                }
                .logo { height: 40px; }
                .logo_anio { height: 50px !important; }
                .title { font-weight: bold; color: #FFFFFF !important; text-align: right; }
                .table-item { 
                    margin-top: 20px !important; 
                    font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
                    font-size: 14px;
                    width: 100%;
                }
                /*.table-item td{
                    border: 1px solid #f00; 
                }*/
                .subTitle {
                    font-weight: bold;
                    color: #FFFFFF !important;
                    background-color: #848484;
                    text-align: center !important;
                }
                .tdNombreEncuesta{
                	height: 80px !important;
                    background-color: #ffc000;
                    color:  #000000;
                    width: 100%;
                    text-align: left;
                    font-size: 30px !important;
                    margin-top: 50px !important;
                    margin-bottom: 50px !important;
                }
                .tdNombreTienda{
                	height: 50px !important;
                    text-align:center; 
                    width: 100%;
                    font-size: 30px !important;
                    background-color: #bc3931;
                    color: #FFFFFF;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                .tdFoto{
                    padding: 15px !important;
                }
            </style>
            ";

        require APPPATH . '/vendor/autoload.php';

        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        $mpdf = new \Mpdf\Mpdf();
        $printHtml = '';

        foreach ($dataLista as $klc => $cliente) {
            $nombreEncuesta = $cliente->{'nombreEncuesta'};
            $nombreCliente = $cliente->{'nombreCliente'};
            $cantidadFotos = $cliente->{'cantidadFotos'};

            //Creamos la Cabecera
            $header = '<table class="head" >';
            $header .= '<tr>';
            $header .= '<td>';
            $header .= '<img class="logo" src="' . $www . '/visualimpact/logo.png" />';
            $header .= '</td>';
            $header .= '<td></td>';
            $header .= '<td class="title" >';
            $header .= 'Fecha Creación: ' . date('d/m/Y');
            $header .= '</td>';
            $header .= '</tr>';
            $header .= '</table>';

            $htmlCabecera = '';
            $htmlCabecera .= '<div style="margin:30px;display:table;">&nbsp;</div>';
            $htmlCabecera .= '<table class="table-item" >';
            $htmlCabecera .= '<tbody>';

            $htmlCabecera .= '<tr>';
            $htmlCabecera .= '<td class="tdNombreEncuesta">';
            $htmlCabecera .= '<div style="margin-top: 50px !important;">';
            $htmlCabecera .= '<strong> ' . $nombreEncuesta . ' </strong> <br />';
            $htmlCabecera .= '</div>';
            $htmlCabecera .= '</td>';
            $htmlCabecera .= '</tr>';
            $htmlCabecera .= '<tr>';
            $htmlCabecera .= '<td class="tdNombreTienda">';
            $htmlCabecera .= '<strong> ' . $nombreCliente . '</strong><br />';
            $htmlCabecera .= '</td>';
            $htmlCabecera .= '</tr>';
            $htmlCabecera .= '<tr>';
            $htmlCabecera .= '<td>&nbsp;</td>';
            $htmlCabecera .= '</tr>';

            /**====AQUI EL CONTENIDO======**/

            $htmlFooter = '';
            $htmlFooter .= '<tr>';
            $htmlFooter .= '<td>&nbsp;</td>';
            $htmlFooter .= '</tr>';
            $htmlFooter .= '</tbody>';
            $htmlFooter .= '</table>';

            if (!empty($cliente->dataFotos)) {
                foreach ($cliente->dataFotos as $klc => $arrayFotos) {
                    if (!empty($arrayFotos)) {

                        $htmlFoto = '';
                        $htmlFoto .= '<tr><td>';
                        $htmlFoto .= '<table>';
                        $contTdFotos = 0;
                        foreach ($arrayFotos as $kf => $fotoImage) {
                            if ($contTdFotos == 0) {
                                $htmlFoto .= '<tr>';
                            }

                            $htmlFoto .= '<td class="tdFoto" style="width:50% !important;">';
                            $htmlFoto .= '<img class="foto" src="'. verificarUrlFotos($fotoImage) .'encuestas/' . $fotoImage . '" />';
                            $htmlFoto .= '</td>';

                            $contTdFotos++;

                            if ($contTdFotos % 2 == 0) {
                                $htmlFoto .= '</tr>';
                                $contTdFotos = 0;
                            }
                        }
                        if ($contTdFotos == 1) {
                            $htmlFoto .= '<td class="tdFoto" style="width:50% !important;"></td>';
                            $htmlFoto .= '</tr>';
                        }

                        $htmlFoto .= '</table>';
                        $htmlFoto .= '</td></tr>';


                        $mpdf->SetHTMLHeader($header);
                        $mpdf->setFooter('{PAGENO}');
                        $mpdf->AddPage();
                        $mpdf->WriteHTML($style);
                        $mpdf->WriteHTML($htmlCabecera);
                        $mpdf->WriteHTML($htmlFoto);
                        $mpdf->WriteHTML($htmlFooter);
                    }
                }
            }
        }

        $mpdf->Output($archivo, 'D');
    }
}
