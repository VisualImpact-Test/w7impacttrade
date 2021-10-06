<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Storecheck extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Storecheck', 'm_storecheck');
	}

	public function index()
	{
		$this->aSessTrack = [ 'idAccion' => 4 ];

		$config = array();
		$config['css']['style'] = [
			// 'assets/libs/dataTables/datatables',
			'assets/libs/swiper@6.1.2/swiper-bundle.min',
			'assets/custom/css/storecheck'
		];
		$config['js']['script'] = [
			// 'assets/libs/dataTables/datatables',
			// 'assets/custom/js/core/datatables-defaults',
			'assets/libs/swiper@6.1.2/swiper-bundle.min',
			'assets/custom/js/storecheck'
		];

		$config['nav']['menu_active']='45';
		$config['data']['icon'] = 'fa fa-chart-line';
		$config['data']['title'] = 'Storecheck';
		$config['data']['message'] = 'Módulo para el Storecheck';
		$config['view'] = 'modulos/storecheck/index';

		$this->view($config);
	}

	public function getPuntosDeVenta()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Storecheck';

		$post = json_decode($this->input->post('data'), true);

		// VALIDACIONES
		$elementosAValidar = [
			'idMes' => ['selectRequerido'],
			'idAnio' => ['selectRequerido'],
			'cuenta' => ['selectRequerido'],
			'proyecto' => ['selectRequerido'],
			'grupoCanal' => ['selectRequerido'],
			'canal' => ['selectRequerido'],
			//'cadena' => ['selectRequerido'],
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		$result['data']['validaciones'] = $validaciones;

		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto responder;
		}

		$fecha = '01/' . $post["idMes"] . '/' . $post["idAnio"];
		$result["result"] = 1;
		$result["data"]["puntosDeVenta"] = $this->m_storecheck->getPuntosDeVenta($fecha, $post)->result_array();

		$this->aSessTrack = $this->m_storecheck->aSessTrack;

		responder:
		echo json_encode($result);
	}

	public function getStoreCheck()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Storecheck';
		$post = json_decode($this->input->post('data'), true);

		// VALIDACIONES
		$elementosAValidar = [
			'idMes' => ['selectRequerido'],
			'idAnio' => ['selectRequerido'],
			'idPuntoDeVenta' => ['selectRequerido']
		];
		$validaciones = verificarValidacionesBasicas($elementosAValidar, $post);
		$result['data']['validaciones'] = $validaciones;
		if (!verificarSeCumplenValidaciones($validaciones)) {
			$result['result'] = 0;
			$result['msg']['content'] = getMensajeGestion('registroConDatosInvalidos');
			goto respuesta;
		}
		

		$post['fechas'] = getPrimerYUltimoDia('01/' . $post["idMes"] . '/' . $post["idAnio"]);
		$infoPuntoDeVenta = $this->m_storecheck->getInfoPuntoDeVenta($post)->row_array();
		$visitas = $this->m_storecheck->getVisitas($post)->result_array();

		$post['idsVisitas'] = array_column($visitas, 'idVisita');
		array_push($post['idsVisitas'],'0');
		$post['ids']=implode(",",$post['idsVisitas']);


		$visitasFotos = $this->getVisitasFotos($post);
		$visitasPrecios = $this->getVisitasPrecios($post);
		$visitasEncuesta = $this->getVisitasEncuestas($post);
		$visitasSos = $this->getVisitasSos($post);
		$visitasSod = $this->getVisitasSod($post);
		$visitasSeguimientoPlan = $this->getVisitasSeguimientoPlan($post);
		$visitasPromociones = $this->getVisitasPromociones($post);
		$visitasDespacho = $this->getVisitasDespacho($post);
		$visitasIniciativaTrad = $this->getVisitasIniciativaTrad($post);
		$visitasInteligenciaTrad = $this->getVisitasInteligenciaTrad($post);
		$visitasOrden = $this->getVisitasOrden($post);
		$visitasVisibilidadTrad = $this->getVisitasVisibilidadTrad($post);
		$visitasCheckList = $this->getVisitasCheckList($post);
		$visitasInventario = $this->getVisitasInventario($post);
		$visitasIpp = $this->getVisitasIpp($post);
		$visitasEncuestaPremio = $this->getVisitasEncuestaPremio($post);
		$visitasVisibilidadAuditoriaObligatorio = $this->getVisitasVisibilidadAuditoriaObligatorio($post);
		$visitasVisibilidadAuditoriaIniciativa = $this->getVisitasVisibilidadAuditoriaIniciativa($post);
		$visitasVisibilidadAuditoriaAdicional = $this->getVisitasVisibilidadAuditoriaAdicional($post);
		$visitasVisibilidadAuditoria['obligatorio'] = $visitasVisibilidadAuditoriaObligatorio;
		$visitasVisibilidadAuditoria['iniciativa'] = $visitasVisibilidadAuditoriaIniciativa;
		$visitasVisibilidadAuditoria['adicional'] = $visitasVisibilidadAuditoriaAdicional;

		$this->aSessTrack = array_merge($this->aSessTrack, $this->m_storecheck->aSessTrack);

		$result['result'] = 1;
		$result['data']['html']['seccionInfoPuntoDeVenta'] = $this->load->view("modulos/storecheck/seccionInfoPuntoDeVenta", ['infoPuntoDeVenta' => $infoPuntoDeVenta], true);
		$result['data']['html']['seccionVisitas'] = $this->load->view("modulos/storecheck/seccionVisitas", ['visitas' => $visitas], true);
		$result['data']['html']['seccionModuloFotos'] = $this->load->view("modulos/storecheck/seccionModuloFotos", ['visitasFotos' => $visitasFotos], true);
		$result['data']['html']['seccionModuloEncuestas'] = $this->load->view("modulos/storecheck/seccionModuloEncuestas", ['visitasEncuesta' => $visitasEncuesta], true);
		$result['data']['html']['seccionModuloPrecios'] = $this->load->view("modulos/storecheck/seccionModuloPrecios", ['visitasPrecios' => $visitasPrecios], true);
		$result['data']['html']['seccionModuloSos'] = $this->load->view("modulos/storecheck/seccionModuloSos", ['visitasSos' => $visitasSos], true);
		$result['data']['html']['seccionModuloSod'] = $this->load->view("modulos/storecheck/seccionModuloSod", ['visitasSod' => $visitasSod], true);
		$result['data']['html']['seccionModuloSeguimientoPlan'] = $this->load->view("modulos/storecheck/seccionModuloSeguimientoPlan", ['visitasSeguimientoPlan' => $visitasSeguimientoPlan], true);
		$result['data']['html']['seccionModuloPromociones'] = $this->load->view("modulos/storecheck/seccionModuloPromociones", ['visitasPromociones' => $visitasPromociones], true);
		$result['data']['html']['seccionModuloDespacho'] = $this->load->view("modulos/storecheck/seccionModuloDespacho", ['visitasDespacho' => $visitasDespacho], true);
		$result['data']['html']['seccionModuloIniciativaTrad'] = $this->load->view("modulos/storecheck/seccionModuloIniciativaTrad", ['visitasIniciativaTrad' => $visitasIniciativaTrad], true);
		$result['data']['html']['seccionModuloInteligenciaTrad'] = $this->load->view("modulos/storecheck/seccionModuloInteligenciaTrad", ['visitasInteligenciaTrad' => $visitasInteligenciaTrad], true);
		$result['data']['html']['seccionModuloOrden'] = $this->load->view("modulos/storecheck/seccionModuloOrden", ['visitasOrden' => $visitasOrden], true);
		$result['data']['html']['seccionModuloVisibilidadTrad'] = $this->load->view("modulos/storecheck/seccionModuloVisibilidadTrad", ['visitasVisibilidadTrad' => $visitasVisibilidadTrad], true);
		$result['data']['html']['seccionModuloCheckList'] = $this->load->view("modulos/storecheck/seccionModuloCheckList", ['visitasCheckList' => $visitasCheckList], true);
		$result['data']['html']['seccionModuloInventario'] = $this->load->view("modulos/storecheck/seccionModuloInventario", ['visitasInventario' => $visitasInventario], true);
		$result['data']['html']['seccionModuloIpp'] = $this->load->view("modulos/storecheck/seccionModuloIpp", ['visitasIpp' => $visitasIpp], true);
		$result['data']['html']['seccionModuloEncuestasPremio'] = $this->load->view("modulos/storecheck/seccionModuloEncuestasPremio", ['visitasEncuestaPremio' => $visitasEncuestaPremio], true);
		$result['data']['html']['seccionModuloVisibilidadAuditoria'] = $this->load->view("modulos/storecheck/seccionModuloVisibilidadAuditoria", ['visitasVisibilidadAuditoria' => $visitasVisibilidadAuditoria], true);
		$result['data']['html']['tablaVisibilidadAuditoriaObligatorio'] = $this->load->view("modulos/storecheck/tablaVisibilidadAuditoriaObligatorio", ['visitasVisibilidadAuditoriaObligatorio' => $visitasVisibilidadAuditoriaObligatorio], true);
		$result['data']['html']['tablaVisibilidadAuditoriaIniciativa'] = $this->load->view("modulos/storecheck/tablaVisibilidadAuditoriaIniciativa", ['visitasVisibilidadAuditoriaIniciativa' => $visitasVisibilidadAuditoriaIniciativa], true);
		$result['data']['html']['tablaVisibilidadAuditoriaAdicional'] = $this->load->view("modulos/storecheck/tablaVisibilidadAuditoriaAdicional", ['visitasVisibilidadAuditoriaAdicional' => $visitasVisibilidadAuditoriaAdicional], true);

		respuesta:
		echo json_encode($result);
	}

	protected function getVisitasFotos($post)
	{
		$visitasFotos = $this->m_storecheck->getVisitasFotos($post)->result_array();

		$visitasFotosRefactorizado = [];
		foreach ($visitasFotos as $key => $value) {
			$visitasFotosRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasFotosRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasFotosRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasFotosRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasFotosRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasFotosRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasFotosRefactorizado[$value['idVisita']]['detallados'])) $visitasFotosRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasFotosRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaModuloFoto']]['idVisitaModuloFoto'] = $value['idVisitaModuloFoto'];
			$visitasFotosRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaModuloFoto']]['fotoTipo'] = $value['fotoTipo'];
			$visitasFotosRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaModuloFoto']]['hora'] = $value['hora'];
			$visitasFotosRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaModuloFoto']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaModuloFoto'])) $visitasFotosRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasFotos = $visitasFotosRefactorizado;

		return $visitasFotos;
	}

	protected function getVisitasPrecios($post)
	{
		$visitasPrecios = $this->m_storecheck->getVisitasPrecios($post)->result_array();

		$visitasPreciosRefactorizado = [];
		foreach ($visitasPrecios as $key => $value) {
			$visitasPreciosRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasPreciosRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasPreciosRefactorizado['visitas'][$value['idVisita']]['hora'] = $value['hora'];
			$visitasPreciosRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasPreciosRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['idProducto'] = $value['idProducto'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['producto'] = $value['producto'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['idMarca'] = $value['idMarca'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['marca'] = $value['marca'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['idCategoria'] = $value['idCategoria'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['categoria'] = $value['categoria'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['precios'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasPreciosRefactorizado['productos'][$value['idProducto']]['precios'][$value['idVisita']]['precio'] = $value['precio'];
		}
		$visitasPrecios = $visitasPreciosRefactorizado;

		return $visitasPrecios;
	}

	protected function getVisitasEncuestas($post)
	{
		$visitasEncuestas = $this->m_storecheck->getVisitasEncuestas($post)->result_array();

		$visitasEncuestasRefactorizado = [];

		foreach ($visitasEncuestas as $key => $value) {
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['horaFin'] = $value['horaFin'];

			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['idEncuesta'] = $value['idEncuesta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['encuesta'] = $value['encuesta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['hora'] = $value['hora'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['fotoUrl'] = $value['fotoUrl'];

			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idPregunta'] = $value['idPregunta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idTipoPregunta'] = $value['idTipoPregunta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['pregunta'] = $value['pregunta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idAlternativa'] = $value['idAlternativa'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['alternativa'] = $value['alternativa'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['respuesta'] = $value['respuesta'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['fotoUrlDet'] = $value['fotoUrlDet'];

			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['idAlternativa'] = $value['idAlternativa'];
			$visitasEncuestasRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['alternativa'] = $value['alternativa'];

			$visitasEncuestasRefactorizado['encuestas'][$value['idEncuesta']]['idEncuesta'] = $value['idEncuesta'];
			$visitasEncuestasRefactorizado['encuestas'][$value['idEncuesta']]['encuesta'] = $value['encuesta'];
			$visitasEncuestasRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idPregunta'] = $value['idPregunta'];
			$visitasEncuestasRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['pregunta'] = $value['pregunta'];
			$visitasEncuestasRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idTipoPregunta'] = $value['idTipoPregunta'];
			$visitasEncuestasRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];
		}

		$visitasEncuestas = $visitasEncuestasRefactorizado;
		return $visitasEncuestas;
	}

	protected function getVisitasSos($post)
	{
		$visitasSos = $this->m_storecheck->getVisitasSos($post)->result_array();

		$visitasSosRefactorizado = [];
		foreach ($visitasSos as $key => $value) {
			$visitasSosRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasSosRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasSosRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasSosRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['idCategoria'] = $value['idCategoria'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['categoria'] = $value['categoria'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['idVisitaFoto'] = $value['idVisitaFoto'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['numDet'] = $value['numDet'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['hora'] = $value['hora'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['fotoUrl'] = $value['fotoUrl'];
			if (empty($visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['cantidadCompetencia'])) $visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['cantidadCompetencia'] = 0;
			if ($value['flagCompetenciaDet'] == '1') $visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['cantidadCompetencia']++;

			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['idVisitaSosDet'] = $value['idVisitaSosDet'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['cmDet'] = $value['cmDet'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['frentesDet'] = $value['frentesDet'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['flagCompetenciaDet'] = $value['flagCompetenciaDet'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['idMarcaDet'] = $value['idMarcaDet'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['marca'] = $value['marca'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['idCategoria'] = $value['idCategoria'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['categoria'] = $value['categoria'];
			$visitasSosRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSosDet']]['fecha'] = $value['fecha'];
		}

		$visitasSos = $visitasSosRefactorizado;

		return $visitasSos;
	}

	protected function getVisitasSod($post)
	{
		$visitasSod = $this->m_storecheck->getVisitasSod($post)->result_array();

		$visitasSodRefactorizado = [];
		foreach ($visitasSod as $key => $value) {
			$visitasSodRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasSodRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasSodRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasSodRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['idCategoria'] = $value['idCategoria'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['categoria'] = $value['categoria'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['cant'] = $value['cant'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['hora'] = $value['hora'];

			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['idVisitaSodDetFoto'] = $value['idVisitaSodDetFoto'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['idVisitaFoto'] = $value['idVisitaFoto'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['fotoUrl'] = $value['fotoUrl'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['idCategoria'] = $value['idCategoria'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['categoria'] = $value['categoria'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['idMarca'] = $value['idMarca'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['marca'] = $value['marca'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['idTipoElementoVisibilidad'] = $value['idTipoElementoVisibilidad'];
			$visitasSodRefactorizado[$value['idVisita']]['categorias'][$value['idCategoria']]['detallados'][$value['idVisitaSodDetFoto']]['tipoElementoVisibilidad'] = $value['tipoElementoVisibilidad'];
		}

		$visitasSod = $visitasSodRefactorizado;

		return $visitasSod;
	}

	protected function getVisitasSeguimientoPlan($post)
	{
		$visitasSeguimientoPlan = $this->m_storecheck->getVisitasSeguimientoPlan($post)->result_array();

		$visitasSeguimientoPlanRefactorizado = [];
		foreach ($visitasSeguimientoPlan as $key => $value) {
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['fotoUrl'] = $value['fotoUrl'];
			$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['seguimientoPlan'] = $value['seguimientoPlan'];

			if (empty($visitasSeguimientoPlanRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasSeguimientoPlanRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'])) $visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'] = [];
			if (!empty($value['idVisitaSeguimientoPlanDet'])) {
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['idVisitaSeguimientoPlanDet'] = $value['idVisitaSeguimientoPlanDet'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['armado'] = $value['armado'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['revestido'] = $value['revestido'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['comentario'] = $value['comentario'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['marca'] = $value['marca'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['fotoUrlDet'] = $value['fotoUrlDet'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['motivo'] = $value['motivo'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaSeguimientoPlanDet']]['tipoElementoVisibilidad'] = $value['tipoElementoVisibilidad'];
				$visitasSeguimientoPlanRefactorizado[$value['idVisita']]['cantidadDetallados']++;
			}
		}

		$visitasSeguimientoPlan = $visitasSeguimientoPlanRefactorizado;
		return $visitasSeguimientoPlan;
	}

	protected function getVisitasPromociones($post)
	{
		$visitasPromociones = $this->m_storecheck->getVisitasPromociones($post)->result_array();

		$visitasPromocionesRefactorizado = [];
		foreach ($visitasPromociones as $key => $value) {
			$visitasPromocionesRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasPromocionesRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasPromocionesRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasPromocionesRefactorizado[$value['idVisita']]['detallados'])) $visitasPromocionesRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasPromocionesRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaPromocionesDet']]['idVisitaPromocionesDet'] = $value['idVisitaPromocionesDet'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaPromocionesDet']]['promocion'] = $value['promocion'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaPromocionesDet']]['tipoPromocion'] = $value['tipoPromocion'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaPromocionesDet']]['presencia'] = $value['presencia'];
			$visitasPromocionesRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaPromocionesDet']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaPromocionesDet'])) $visitasPromocionesRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasPromociones = $visitasPromocionesRefactorizado;

		return $visitasPromociones;
	}

	protected function getVisitasDespacho($post)
	{
		$visitasDespacho = $this->m_storecheck->getVisitasDespacho($post)->result_array();

		$visitasDespachoRefactorizado = [];
		foreach ($visitasDespacho as $key => $value) {
			$visitasDespachoRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasDespachoRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasDespachoRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasDespachoRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasDespachoRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasDespachoRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasDespachoRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasDespachoRefactorizado[$value['idVisita']]['detallados'])) $visitasDespachoRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasDespachoRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaDesapachosDet']]['idVisitaDesapachosDet'] = $value['idVisitaDesapachosDet'];
			$visitasDespachoRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaDesapachosDet']]['horaIni'] = $value['horaIni'];
			$visitasDespachoRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaDesapachosDet']]['horaFin'] = $value['horaFin'];
			$visitasDespachoRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaDesapachosDet']]['incidencia'] = $value['incidencia'];
			$visitasDespachoRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaDesapachosDet']]['comentario'] = $value['comentario'];
			$visitasDespachoRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaDesapachosDet']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaDesapachosDet'])) $visitasDespachoRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasDespacho = $visitasDespachoRefactorizado;
		return $visitasDespachoRefactorizado;
	}

	protected function getVisitasIniciativaTrad($post)
	{
		$visitasIniciativaTrad = $this->m_storecheck->getVisitasIniciativaTrad($post)->result_array();

		$visitasIniciativaTradRefactorizado = [];

		foreach ($visitasIniciativaTrad as $key => $value) {
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasIniciativaTradRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasIniciativaTradRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'])) $visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaIniciativaTradDet']]['idVisitaIniciativaTradDet'] = $value['idVisitaIniciativaTradDet'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaIniciativaTradDet']]['iniciativaTrad'] = $value['iniciativaTrad'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaIniciativaTradDet']]['elementoIniciativaTrad'] = $value['elementoIniciativaTrad'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaIniciativaTradDet']]['estadoIniciativa'] = $value['estadoIniciativa'];
			$visitasIniciativaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaIniciativaTradDet']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaIniciativaTradDet'])) $visitasIniciativaTradRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasIniciativaTrad = $visitasIniciativaTradRefactorizado;

		return $visitasIniciativaTrad;
	}

	protected function getVisitasInteligenciaTrad($post)
	{
		$visitasInteligenciaTrad = $this->m_storecheck->getVisitasInteligenciaTrad($post)->result_array();

		$visitasInteligenciaTradRefactorizado = [];
		foreach ($visitasInteligenciaTrad as $key => $value) {
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasInteligenciaTradRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasInteligenciaTradRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'])) $visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaInteligenciaTradDet']]['idVisitaInteligenciaTradDet'] = $value['idVisitaInteligenciaTradDet'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaInteligenciaTradDet']]['categoria'] = $value['categoria'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaInteligenciaTradDet']]['marca'] = $value['marca'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaInteligenciaTradDet']]['tipoCompetencia'] = $value['tipoCompetencia'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaInteligenciaTradDet']]['comentario'] = $value['comentario'];
			$visitasInteligenciaTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaInteligenciaTradDet']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaInteligenciaTradDet'])) $visitasInteligenciaTradRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasInteligenciaTrad = $visitasInteligenciaTradRefactorizado;
		return $visitasInteligenciaTrad;
	}

	protected function getVisitasOrden($post)
	{
		$visitasOrden = $this->m_storecheck->getVisitasOrden($post)->result_array();
		$visitasOrdenRefactorizado = [];

		foreach ($visitasOrden as $key => $value) {
			$visitasOrdenRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasOrdenRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasOrdenRefactorizado[$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasOrdenRefactorizado[$value['idVisita']]['horaFin'] = $value['horaFin'];
			$visitasOrdenRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasOrdenRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasOrdenRefactorizado[$value['idVisita']]['fotoUrl'] = $value['fotoUrl'];
			$visitasOrdenRefactorizado[$value['idVisita']]['orden'] = $value['orden'];
			$visitasOrdenRefactorizado[$value['idVisita']]['ordenEstado'] = $value['ordenEstado'];
			$visitasOrdenRefactorizado[$value['idVisita']]['descripcion'] = $value['descripcion'];
			$visitasOrdenRefactorizado[$value['idVisita']]['flagOtro'] = $value['flagOtro'];
		}

		$visitasOrden = $visitasOrdenRefactorizado;

		return $visitasOrden;
	}

	protected function getVisitasVisibilidadTrad($post)
	{
		$visitasVisibilidadTrad = $this->m_storecheck->getVisitasVisibilidadTrad($post)->result_array();
		$visitasVisibilidadTradRefactorizado = [];

		foreach ($visitasVisibilidadTrad as $key => $value) {
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasVisibilidadTradRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasVisibilidadTradRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'])) $visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['idVisitaVisibilidadDet'] = $value['idVisitaVisibilidadDet'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['elementoVisibilidadTrad'] = $value['elementoVisibilidadTrad'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['tipoElementoVisibilidadTrad'] = $value['tipoElementoVisibilidadTrad'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['presencia'] = $value['presencia'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['cantidad'] = $value['cantidad'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['estadoElementoVisibilidad'] = $value['estadoElementoVisibilidad'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['condicion_elemento'] = $value['condicion_elemento'];
			$visitasVisibilidadTradRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaVisibilidadDet']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaVisibilidadDet'])) $visitasVisibilidadTradRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasVisibilidadTrad = $visitasVisibilidadTradRefactorizado;

		return $visitasVisibilidadTrad;
	}

	protected function getVisitasCheckList($post)
	{
		$visitasCheckList = $this->m_storecheck->getVisitasCheckList($post)->result_array();

		$visitasCheckListRefactorizado = [];

		foreach ($visitasCheckList as $key => $value) {
			$visitasCheckListRefactorizado[$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasCheckListRefactorizado[$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasCheckListRefactorizado[$value['idVisita']]['hora'] = $value['hora'];
			$visitasCheckListRefactorizado[$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasCheckListRefactorizado[$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			if (empty($visitasCheckListRefactorizado[$value['idVisita']]['cantidadDetallados'])) $visitasCheckListRefactorizado[$value['idVisita']]['cantidadDetallados'] = 0;
			if (empty($visitasCheckListRefactorizado[$value['idVisita']]['detallados'])) $visitasCheckListRefactorizado[$value['idVisita']]['detallados'] = [];

			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['idVisitaProductosDet'] = $value['idVisitaProductosDet'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['producto'] = $value['producto'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['marca'] = $value['marca'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['categoria'] = $value['categoria'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['presencia'] = $value['presencia'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['quiebre'] = $value['quiebre'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['stock'] = $value['stock'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['unidadMedida'] = $value['unidadMedida'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['precio'] = $value['precio'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['motivo'] = $value['motivo'];
			$visitasCheckListRefactorizado[$value['idVisita']]['detallados'][$value['idVisitaProductosDet']]['fotoUrl'] = $value['fotoUrl'];

			if (!empty($value['idVisitaProductosDet'])) $visitasCheckListRefactorizado[$value['idVisita']]['cantidadDetallados']++;
		}

		$visitasCheckList = $visitasCheckListRefactorizado;

		return $visitasCheckList;
	}

	protected function getVisitasInventario($post)
	{
		$visitasInventario = $this->m_storecheck->getVisitasInventario($post)->result_array();

		$visitasInventarioRefactorizado = [];
		foreach ($visitasInventario as $key => $value) {
			$visitasInventarioRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasInventarioRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasInventarioRefactorizado['visitas'][$value['idVisita']]['hora'] = $value['hora'];
			$visitasInventarioRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasInventarioRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];

			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['idProducto'] = $value['idProducto'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['producto'] = $value['producto'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['categoria'] = $value['categoria'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['marca'] = $value['marca'];

			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['stock_inicial'] = $value['stock_inicial'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['sellin'] = $value['sellin'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['stock'] = $value['stock'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['validacion'] = $value['validacion'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['obs'] = $value['obs'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['comentario'] = $value['comentario'];
			$visitasInventarioRefactorizado['productos'][$value['idProducto']]['infoVisitas'][$value['idVisita']]['fecVenc'] = $value['fecVenc'];
		}

		$visitasInventario = $visitasInventarioRefactorizado;
		return $visitasInventario;
	}

	protected function getVisitasIpp($post)
	{

		$visitasIpp = $this->m_storecheck->getVisitasIpp($post)->result_array();

		$visitasIppRefactorizado = [];

		foreach ($visitasIpp as $key => $value) {
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['horaFin'] = $value['horaFin'];

			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['idIpp'] = $value['idIpp'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['ipp'] = $value['ipp'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['hora'] = $value['hora'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['puntaje'] = $value['puntaje'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['fotoUrl'] = $value['fotoUrl'];

			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idPregunta'] = $value['idPregunta'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idTipoPregunta'] = $value['idTipoPregunta'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idCriterio'] = $value['idCriterio'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['criterio'] = $value['criterio'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idAlternativa'] = $value['idAlternativa'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['alternativa'] = $value['alternativa'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['puntajeAlternativa'] = $value['puntajeAlternativa'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];

			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['idAlternativa'] = $value['idAlternativa'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['alternativa'] = $value['alternativa'];
			$visitasIppRefactorizado['visitas'][$value['idVisita']]['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['puntajeAlternativa'] = $value['puntajeAlternativa'];

			$visitasIppRefactorizado['ipp'][$value['idIpp']]['idIpp'] = $value['idIpp'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['ipp'] = $value['ipp'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idPregunta'] = $value['idPregunta'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['pregunta'] = $value['pregunta'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idTipoPregunta'] = $value['idTipoPregunta'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['idCriterio'] = $value['idCriterio'];
			$visitasIppRefactorizado['ipp'][$value['idIpp']]['preguntas'][$value['idPregunta']]['criterio'] = $value['criterio'];
		}

		$visitasIpp = $visitasIppRefactorizado;
		return $visitasIpp;
	}

	protected function getVisitasEncuestaPremio($post)
	{
		$visitasEncuestaPremio = $this->m_storecheck->getVisitasEncuestaPremio($post)->result_array();

		$visitasEncuestaPremioRefactorizado = [];
		foreach ($visitasEncuestaPremio as $key => $value) {
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['horaFin'] = $value['horaFin'];

			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['idEncuesta'] = $value['idEncuesta'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['encuestaPremio'] = $value['encuestaPremio'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['descripcionEncuestaPremio'] = $value['descripcionEncuestaPremio'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['hora'] = $value['hora'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['idVisitaFoto'] = $value['idVisitaFoto'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['fotoUrl'] = $value['fotoUrl'];

			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idPregunta'] = $value['idPregunta'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['pregunta'] = $value['pregunta'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idTipoPregunta'] = $value['idTipoPregunta'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idAlternativa'] = $value['idAlternativa'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['alternativa'] = $value['alternativa'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['respuesta'] = $value['respuesta'];

			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['idAlternativa'] = $value['idAlternativa'];
			$visitasEncuestaPremioRefactorizado['visitas'][$value['idVisita']]['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['alternativasMultiples'][$value['idAlternativa']]['alternativa'] = $value['alternativa'];

			$visitasEncuestaPremioRefactorizado['encuestas'][$value['idEncuesta']]['idEncuesta'] = $value['idEncuesta'];
			$visitasEncuestaPremioRefactorizado['encuestas'][$value['idEncuesta']]['encuestaPremio'] = $value['encuestaPremio'];
			$visitasEncuestaPremioRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idPregunta'] = $value['idPregunta'];
			$visitasEncuestaPremioRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['pregunta'] = $value['pregunta'];
			$visitasEncuestaPremioRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['idTipoPregunta'] = $value['idTipoPregunta'];
			$visitasEncuestaPremioRefactorizado['encuestas'][$value['idEncuesta']]['preguntas'][$value['idPregunta']]['tipoPregunta'] = $value['tipoPregunta'];
		}

		$visitasEncuestaPremio = $visitasEncuestaPremioRefactorizado;
		return $visitasEncuestaPremio;
	}

	protected function getVisitasVisibilidadAuditoriaIniciativa($post)
	{
		$visitasVisibilidadAuditoriaIniciativa = $this->m_storecheck->getVisitasVisibilidadAuditoriaIniciativa($post)->result_array();
		$visitasVisibilidadAuditoriaIniciativaRefactorizado = [];

		foreach ($visitasVisibilidadAuditoriaIniciativa as $key => $value) {
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['horaFin'] = $value['horaFin'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['hora'] = $value['hora'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['visitas'][$value['idVisita']]['porcentaje'] = $value['porcentaje'];

			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['idElementoVis'] = $value['idElementoVis'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['elementoVisibilidad'] = $value['elementoVisibilidad'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['idTipoElementoVis'] = $value['idTipoElementoVis'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['tipoElementoVisibilidad'] = $value['tipoElementoVisibilidad'];

			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['presencia'] = $value['presencia'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['comentario'] = $value['comentario'];
			$visitasVisibilidadAuditoriaIniciativaRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['observacion'] = $value['observacion'];
		}

		$visitasVisibilidadAuditoriaIniciativa = $visitasVisibilidadAuditoriaIniciativaRefactorizado;
		return $visitasVisibilidadAuditoriaIniciativa;
	}

	protected function getVisitasVisibilidadAuditoriaAdicional($post)
	{
		$visitasVisibilidadAuditoriaAdicional = $this->m_storecheck->getVisitasVisibilidadAuditoriaAdicional($post)->result_array();
		$visitasVisibilidadAuditoriaAdicionalRefactorizado = [];

		foreach ($visitasVisibilidadAuditoriaAdicional as $key => $value) {
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['horaFin'] = $value['horaFin'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['hora'] = $value['hora'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['visitas'][$value['idVisita']]['porcentaje'] = $value['porcentaje'];

			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['idElementoVis'] = $value['idElementoVis'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['elementoVisibilidad'] = $value['elementoVisibilidad'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['idTipoElementoVis'] = $value['idTipoElementoVis'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['tipoElementoVisibilidad'] = $value['tipoElementoVisibilidad'];

			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['presencia'] = $value['presencia'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['comentario'] = $value['comentario'];
			$visitasVisibilidadAuditoriaAdicionalRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['cant'] = $value['cant'];
		}

		$visitasVisibilidadAuditoriaAdicional = $visitasVisibilidadAuditoriaAdicionalRefactorizado;
		return $visitasVisibilidadAuditoriaAdicional;
	}

	protected function getVisitasVisibilidadAuditoriaObligatorio($post)
	{
		$visitasVisibilidadAuditoriaObligatorio = $this->m_storecheck->getVisitasVisibilidadAuditoriaObligatorio($post)->result_array();
		$visitasVisibilidadAuditoriaObligatorioRefactorizado = [];

		foreach ($visitasVisibilidadAuditoriaObligatorio as $key => $value) {
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['idVisita'] = $value['idVisita'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['horaIni'] = $value['horaIni'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['horaFin'] = $value['horaFin'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['hora'] = $value['hora'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['fecha'] = $value['fecha'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['tipoUsuario'] = $value['tipoUsuario'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['nombreUsuario'] = $value['nombreUsuario'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['porcentaje'] = $value['porcentaje'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['porcentajeV'] = $value['porcentajeV'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['visitas'][$value['idVisita']]['porcentajePM'] = $value['porcentajePM'];

			$visitasVisibilidadAuditoriaObligatorioRefactorizado['variables'][$value['idVariable']]['idVariable'] = $value['idVariable'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['variables'][$value['idVariable']]['variable'] = $value['variable'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['variables'][$value['idVariable']]['variableNombreCorto'] = $value['variableNombreCorto'];

			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['idElementoVis'] = $value['idElementoVis'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['elementoVisibilidad'] = $value['elementoVisibilidad'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['idTipoElementoVis'] = $value['idTipoElementoVis'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['tipoElementoVisibilidad'] = $value['tipoElementoVisibilidad'];

			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['variables'][$value['idVariable']]['idVariable'] = $value['idVariable'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['variables'][$value['idVariable']]['variable'] = $value['variable'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['variables'][$value['idVariable']]['presencia'] = $value['presencia'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['variables'][$value['idVariable']]['observacion'] = $value['observacion'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['variables'][$value['idVariable']]['comentario'] = $value['comentario'];
			$visitasVisibilidadAuditoriaObligatorioRefactorizado['elementosVisibilidad'][$value['idElementoVis']]['infoVisitas'][$value['idVisita']]['variables'][$value['idVariable']]['cantidad'] = $value['cantidad'];
		}

		$visitasVisibilidadAuditoriaObligatorio = $visitasVisibilidadAuditoriaObligatorioRefactorizado;
		return $visitasVisibilidadAuditoriaObligatorio;
	}

	public function getDetalladoModuloSos()
	{
		$result = $this->result;
		$result['msg']['title'] = 'Storecheck - Detallado SOS';

		$data = json_decode($this->input->post('data'), true);

		$result['result'] = 1;
		$result['data']['html'] = $this->load->view("modulos/storecheck/detalladoModuloSos", ['detallados' => $data['detallados']], true);
		$result['data']['width'] = '45%';

		echo json_encode($result);
	}
}
