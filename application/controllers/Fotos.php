<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fotos extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Fotos', 'm_foto');
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config['nav']['menu_active'] = '47';
		$config['css']['style'] = [
			'assets/custom/css/pagination/pagination',
			'assets/custom/css/fotos'
		];
		$config['js']['script'] = [
			'assets/libs/pagination/pagination.min',
			'assets/libs/filedownload/jquery.fileDownload',
			'assets/custom/js/fotos'
		];

		$config['data']['icon'] = 'fa fa-camera';
		$config['data']['title'] = 'Fotos';
		$config['data']['message'] = 'Aquí encontrará fotos.';
		$config['view'] = 'modulos/fotos/index';
		$config['data']['tipoFotos'] = $this->m_foto->getTipoFotos()->result_array();
		$config['data']['tipoCliente'] = $this->m_foto->getTipoCliente()->result_array();
		$this->view($config);
	}

	protected function getFotos($post)
	{
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaFotos' ];
		$fotosClientes = $this->m_foto->getFotos($post)->result_array();

		$fotosClientesRefactorizado = [];
		foreach ($fotosClientes as $key => $row) {
			$fotosClientesRefactorizado[$row['idCliente']]['idCliente'] = $row['idCliente'];
			$fotosClientesRefactorizado[$row['idCliente']]['codCliente'] = $row['codCliente'];
			$fotosClientesRefactorizado[$row['idCliente']]['canal'] = $row['canal'];
			$fotosClientesRefactorizado[$row['idCliente']]['departamento'] = $row['departamento'];
			$fotosClientesRefactorizado[$row['idCliente']]['provincia'] = $row['provincia'];
			$fotosClientesRefactorizado[$row['idCliente']]['distrito'] = $row['distrito'];
			$fotosClientesRefactorizado[$row['idCliente']]['direccion'] = $row['direccion'];
			$fotosClientesRefactorizado[$row['idCliente']]['razonSocial'] = $row['razonSocial'];
			$fotosClientesRefactorizado[$row['idCliente']]['cliente_tipo'] = $row['cliente_tipo'];

			if (empty($fotosClientesRefactorizado[$row['idCliente']]['visitas'])) $fotosClientesRefactorizado[$row['idCliente']]['visitas'] = [];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['idVisita'] = $row['idVisita'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['usuario'] = $row['usuario'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['tipoUsuario'] = $row['tipoUsuario'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fecha'] = $row['fecha'];

			if (empty($fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'])) $fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'] = [];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['idVisitaFoto'] = $row['idVisitaFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['horaFoto'] = $row['horaFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['tipoFoto'] = $row['tipoFoto'];
			$fotosClientesRefactorizado[$row['idCliente']]['visitas'][$row['idVisita']]['fotos'][$row['idVisitaFoto']]['imgRef'] = $row['imgRef'];
		}
		$fotosClientes = $fotosClientesRefactorizado;

		return $fotosClientes;
	}

	public function getFotosClientes()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Fotos';
		$post = json_decode($this->input->post('data'), true);

		$fotosClientes = $this->getFotos($post);

		$result['result'] = 1;
		if (count($fotosClientes) < 1) {
			$result['data']['html'] = '';
				$result['data']['html'] .= '<div class="col-md-12">';
					$result['data']['html'] .= '<div class="card mb-3 ">';
						$result['data']['html'] .= '<div class="card-body">';
							$result['data']['html'] .= getMensajeGestion('noRegistros');
						$result['data']['html'] .= '</div>';
					$result['data']['html'] .= '</div>';
				$result['data']['html'] .= '</div>';

		} else {
			$dataParaVista = [];
			$result['data']['fotosClientes'] = $fotosClientes;
			$result['data']['html'] = $this->load->view("modulos/Fotos/vistaFotos", $dataParaVista, true);

			$result['data']['tablaExcel'] = $this->load->view("modulos/Fotos/reporteParaExcel", [ 'fotosClientes' => $fotosClientes ], true);
		}
		$result['data']['urlfotos'] = site_url().'ControlFoto/obtener_carpeta_foto/moduloFotos/';
		
		echo json_encode($result);
	}

	public function getVistaMasFotos()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$result['msg']['title'] = 'FECHA: ' . $post['fecha'] . ' | ' . $post['tipoUsuario'] . ': ' . $post['usuario'];

		$result['result'] = 1;
		$dataParaVista['fotosClientes'] = $post['fotosClientes'];
		$result['data']['html'] = $this->load->view("modulos/Fotos/verMasFotos", $dataParaVista, true);
		$result['data']['width'] = '60%';

		echo json_encode($result);
	}

	public function getFormExportarPdf()
	{
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;
		$result['msg']['title'] = 'Exportar Fotos';

		$dataParaVista = [];
		$result['data']['html'] = $this->load->view("modulos/Fotos/formExportarPdf", $dataParaVista, true);
		$result['data']['width'] = '25%';

		echo json_encode($result);
	}

	public function exportarPdf2()
	{
		$this->aSessTrack[] = [ 'idAccion' => 9 ];
		$post = json_decode($this->input->post('data'), true);
		
		$config = [
			'title' => "Reporte Fotográfico",
			'subject' => "Reporte Fotográfico",
			'logo' => "pg-logo.jpg",
			'logoWidth' => 20,
			'headerDescription' => "Fecha Impresión: ".getFechaActual()."\nElaborado por: Visual Impact S.A.C.",
			'margenIzquierdo' => 15,
			'margenSuperior' => 30,
			'margenDerecho' => 15,
			'margenHeader' => 5,
			'margenFooter' => 10,
		];

		$pdf = $this->setDefaultTCPDF($config);

		$fotosClientes = $this->getFotos($post);

		if (count($fotosClientes) < 1) {
			$dataParaVista = [];
			$html = $this->load->view("modulos/Fotos/formatoFotograficoPdfVacio", $dataParaVista, true);

			$pdf->AddPage();
			$pdf->writeHTML($html, true, false, false, false, '');
			$pdf->lastPage();
		} else {
			$contadorLimiteDeClientes = 0;
			foreach ($fotosClientes as $key => $fotoCliente) {

				$contadorLimiteDeClientes++;
				if ($contadorLimiteDeClientes == $post["top"]) break;

				$dataParaVista['fotosCliente'] = $fotoCliente;
				$html = $this->load->view("modulos/Fotos/formatoFotograficoPdf", $dataParaVista, true);

				$pdf->AddPage();
				$pdf->writeHTML($html, true, false, false, false, '');
				$pdf->lastPage();
			}
		}

		$pdf->Output('Reporte Fotográfico.pdf', 'D');
	}

	public function exportarPdf()
	{
		$post = json_decode($this->input->post('data'), true);
		$fotosClientes = $this->getFotos($post);
		$this->aSessTrack[] = [ 'idAccion' => 9 ];

		// Cargar el autoload del composer cuando se necesiten una de las librerias alojadas en vendor.
		require APPPATH . '/vendor/autoload.php';

		$styles = $this->load->view("pdf/modulos/fotos/formatoFotograficoStyles", [], true);
		$config = [
			"styles" => $styles,
			"logo" => base_url() . "public/assets/images/logos/pg-big.png",
			"nombreReporte" => "Reporte Fotográfico",
			"tipo" => "descargaConFileDownload",
		];

		$mpdf = $this->getDefaultMpdf($config);

		if (count($fotosClientes) < 1) {
			$html = $this->load->view("pdf/modulos/fotos/formatoFotograficoVacio", [], true);
			$mpdf->WriteHTML($html);
		} else {
			$contadorLimiteDeClientes = 0;
			foreach ($fotosClientes as $key => $fotoCliente) {

				$dataParaVista['fotosCliente'] = $fotoCliente;
				$html = $this->load->view("pdf/modulos/fotos/formatoFotografico", $dataParaVista, true);
				$mpdf->WriteHTML($html);

				end($fotosClientes);
				if ($key === key($fotosClientes) || $contadorLimiteDeClientes == $post["top"]) {
					break;
				} else {
					$mpdf->AddPage();
				}
				$contadorLimiteDeClientes++;
			}
		}

		$mpdf->Output('Fotos.pdf', \Mpdf\Output\Destination::DOWNLOAD);
	}
}
