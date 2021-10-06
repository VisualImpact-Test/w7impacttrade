<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ElementosVisibilidad extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/gestion/m_elementosVisibilidad','model');
	}

	var $htmlNoResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
	var $htmlUpdateResultado = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE LA INFORMACIÓN CORRECTAMENTE.</div>';
	var $htmlNoUpdateResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA REALIZADO LA ACTUALZIACIÓN DE LA INFORMACIÓN CORRECTAMENTE, VERIFICAR DATO.</div>';


	public function index(){
		$config=array();
		$config['nav']['menu_active']='108';
		$config['css']['style']=array(
			'assets/libs/dataTables-1.10.20/datatables'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/css/configuraciones/gestion/elementos'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables'
			,'assets/libs/datatables/responsive.bootstrap4.min'
			,'assets/custom/js/core/datatables-defaults'
			, 'assets/libs/handsontable@7.4.2/dist/handsontable.full.min'
			, 'assets/libs/handsontable@7.4.2/dist/languages/all'
			, 'assets/libs/handsontable@7.4.2/dist/moment/moment'
			, 'assets/libs/handsontable@7.4.2/dist/pikaday/pikaday'
			, 'assets/custom/js/configuraciones/gestion/elementos'
		);

		$rs_obtenerTipos = $this->model->obtener_listado_tipoElementos();

		$config['data']['icon'] = 'fas fa-cubes';
		$config['data']['title'] = 'Elementos de Visibilidad Auditoria';
		$config['data']['message'] = 'Gestor de Elementos de Visibilidad Auditoria';
		$config['data']['listadoTipos'] = $rs_obtenerTipos;
		$config['view'] = 'modulos/configuraciones/gestion/elementosVisibilidad/index';

		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data  = json_decode($this->input->post('data'));

		$input=array();
		$input['tipoElemento'] = $data->{'slTipoElemento'};

		$rs_obtenerElementos = $this->model->obtener_lista_elementos($input);

		$html='';
		if ( !empty($rs_obtenerElementos)) {
			$array=array();
			foreach ($rs_obtenerElementos as $kle => $row) {
				$array['listaElementos'][$row['idElementoVis']] = $row;
			}

			$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/elementosDetalle", $array, true);
			$result['result'] = 1;
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['data']['html'] = $html;
		$result['data']['datatable'] = 'tb-elementosDetalle';

		echo json_encode($result);
	}

	public function cambiarEstado(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html=''; $htmlEstado=''; $htmlBtnEditar=''; $htmlVistaEstado='';
		
		$inputParams=array();
		$inputParams['estado'] = !empty($data->{'estado'}) ? $data->{'estado'}:0;
		
		$inputWhere=array();
		$inputWhere['idElementoVis'] = $data->{'elementosVisibilidad'};
		
		$rs_updateEstado = $this->model->update_estado_elementoVisibilidad($inputWhere, $inputParams);
		if ($rs_updateEstado) {
			$result['result'] = 1;
			$html.= $this->htmlUpdateResultado;

			if ( $inputParams['estado']==0) {
				$htmlEstado='<a href="javascript:;" id="aElemento-'.$inputWhere['idElementoVis'].'" class="btn btn-danger btnCambiarEstado" title="DESACTIVADO" data-elemento="'.$inputWhere['idElementoVis'].'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
				$htmlBtnEditar='<span>-</span>';
				$htmlVistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';
			} else {
				$htmlEstado='<a href="javascript:;" id="aElemento-'.$inputWhere['idElementoVis'].'" class="btn btn-primary btnCambiarEstado" title="ACTIVO" data-elemento="'.$inputWhere['idElementoVis'].'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
				$htmlBtnEditar='<button class="btn btn-success editarElemento" title="EDITAR ELEMENTO" data-elemento="'.$inputWhere['idElementoVis'].'"><i class="fas fa-edit fa-lg"></i></button>';
				$htmlVistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
			}
		} else {
			$html.= $this->htmlNoUpdateResultado;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO';
		$result['msg']['content'] = $html;
		$result['data']['htmlEstado'] = $htmlEstado;
		$result['data']['htmlBtnEditar'] = $htmlBtnEditar;
		$result['data']['htmlVistaEstado'] = $htmlVistaEstado;

		echo json_encode($result);
	}

	public function cambiarEstadoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataElementos = $data->{'dataElementos'};
		$html=''; $rowUpdated=0; $rowUpdatedError=0;

		if (!empty($dataElementos)) {
			$input=array();
			foreach ($dataElementos as $kle => $row) {
				$idElementoVis = !empty($row->{'elementosVisibilidad'}) ? $row->{'elementosVisibilidad'} : NULL;
				$estado = !empty($row->{'estado'}) ? $row->{'estado'} : 0;

				$inputParams=array();
				$inputParams['estado'] = $estado;
				$inputWhere=array();
				$inputWhere['idElementoVis'] = $idElementoVis;

				$rs_updateEstado = $this->model->update_estado_elementoVisibilidad($inputWhere, $inputParams);
				if ( $rs_updateEstado) { $rowUpdated++; } 
				else { $rowUpdatedError++;	}
			}

			$result['result'] = 1;
			$html .= $this->htmlUpdateResultado;
			$html .= '<div class="alert alert-primary" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE <strong>'.$rowUpdated.'</strong> REGISTROS CORRECTAMENTE.</div>';
			if ( $rowUpdatedError>0) {
				$html .= '<div class="alert alert-danger" role="alert"><i class="fas fa-check-circle"></i> SE ENCONTRO UN ERROR EN LA ACTUALIZACIÓN DE <strong>'.$rowUpdatedError.'</strong> REGISTROS, VERIFICAR LA INFORMACIÓN.</div>';
			}
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO MASIVO';
		$result['msg']['content'] = $html;

		echo json_encode($result);
	}

	public function editarElemento(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth = '50%';
		$idElementoVis = $data->{'elementosVisibilidad'};
		$array=array();

		$rs_categorias = $this->model->obtener_lista_categoria();
		foreach ($rs_categorias as $klc => $row) {
			$array['listaCategorias'][$row['idCategoria']] = $row;
		}

		$rs_tipoElementos = $this->model->obtener_listado_tipoElementos();
		foreach ($rs_tipoElementos as $kle => $row) {
			$array['listaTipoElementos'][$row['idTipoElementoVis']] = $row;
		}

		$rs_elemento = $this->model->obtener_elemento($idElementoVis);
		if ( !empty($rs_elemento)) {
			$array['elemento'] = $rs_elemento[0];
			$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/elementosEditar", $array, true);		
		} else {
			$html.= $this->htmlNoResultado;
		}
		
		$result['result'] = 1;
		$result['msg']['title'] = 'EDITAR ELEMENTO VISIBILIDAD';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function actualizarElemento(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth= '40%';

		if (!empty($data->{'elementoVisibilidad'})) {
			$inputParams=array();
			$inputParams['nombre'] = $data->{'nombreElemento'};
			$inputParams['idTipoElementoVisibilidad'] = !empty($data->{'slTipoElemento'}) ? $data->{'slTipoElemento'}:NULL;
			$inputParams['idCategoria'] = !empty($data->{'slCategoria'}) ? $data->{'slCategoria'}:NULL;

			$inputWhere=array();
			$inputWhere['idElementoVis'] = $data->{'elementoVisibilidad'};

			$rs_updateEstado = $this->model->update_estado_elementoVisibilidad($inputWhere, $inputParams);
			if ($rs_updateEstado) {
				$result['result'] = 1;
				$html.= $this->htmlUpdateResultado;
			} else {
				$html.= $this->htmlNoUpdateResultado;
			}
		} else {
			$html.= $this->htmlNoUpdateResultado;
		}

		$result['msg']['title'] = 'EDITAR ELEMENTO';
		$result['msg']['content'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function nuevoElemento(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth = '60%';
		$array=array();

		$rs_categorias = $this->model->obtener_lista_categoria();
		foreach ($rs_categorias as $klc => $row) {
			$array['listaCategorias'][$row['idCategoria']] = $row;
		}

		$rs_tipoElementos = $this->model->obtener_listado_tipoElementos();
		foreach ($rs_tipoElementos as $kle => $row) {
			$array['listaTipoElementos'][$row['idTipoElementoVis']] = $row;
		}

		if (!empty($rs_tipoElementos)) {
			$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/elementosEditar", $array, true);
		} else {
			$html.= $this->htmlNoResultado;
		}

		$result['result'] = 1;
		$result['msg']['title'] = 'NUEVO ELEMENTO VISIBILIDAD';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function guardarNuevoElemento(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth= '50%';

		if (!empty($data->{'nombreElemento'})) {
			$input=array();
			$input['nombre'] = $data->{'nombreElemento'};
			$input['idTipoElementoVisibilidad'] = !empty($data->{'slTipoElemento'}) ? $data->{'slTipoElemento'} : NULL;
			$input['idCategoria'] = !empty($data->{'slCategoria'}) ? $data->{'slCategoria'} : NULL;

			$rs_insertarElemento = $this->model->insertar_elemento_visibilidad($input);
			if ($rs_insertarElemento) {
				$html .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ REGISTRAR EL ELEMENTO <strong>'.$input['nombre'].'</strong> CORRECTAMENTE.</div>';

				$result['result']=1;
			} else{
				$html .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> HUBO INCONVENIENTES AL REGISTRAR EL ELEMENTO <strong>'.$input['nombre'].'</strong>.</div>';
			}
		} else {
			$html .= $this->htmlNoResultado;
		}

		$result['msg']['title'] = 'REGISTRAR PUNTO DE VENTA';
		$result['msg']['content'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function nuevoElementoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$html='';
		$htmlWidth = '60%';
		$array=array();

		$rs_categorias = $this->model->obtener_lista_categoria();
		$array['listaCategoriasNombre'] = array();
		foreach ($rs_categorias as $klc => $row) {
			if ( !in_array(strtoupper($row['categoria']), $array['listaCategoriasNombre'])) {
				array_push($array['listaCategoriasNombre'], strtoupper($row['categoria']));
			}
		}

		$rs_tipoElementos = $this->model->obtener_listado_tipoElementos();
		$array['listaTipoElementosNombre'] = array();
		foreach ($rs_tipoElementos as $kle => $row) {
			if ( !in_array($row['tipoElemento'], $array['listaTipoElementosNombre'])) {
				array_push($array['listaTipoElementosNombre'], $row['tipoElemento']);
			}
		}

		$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/elementosNuevoMasivo", $array, true);

		$result['result'] = 1;
		$result['msg']['title'] = 'CARGAR ELEMENTOS VISIBILIDAD MASIVO';
		$result['data']['html'] = $html;
		$result['data']['htmlWidth'] = $htmlWidth;

		echo json_encode($result);
	}

	public function guardarNuevoElementoMasivo(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataElementos = $data->{'dataArray'};
		$htmlWidth='50%';
		$html=''; $htmlInserted=''; $htmlInsertedError='';
		$rowInserted=0; $rowInsertedError=0;

		if (!empty($dataElementos)) {
			foreach ($dataElementos as $kde => $row) {
				$nombreElemento = !empty($row[0]) ? $row[0] : NULL;
				$nombreTipoElemento = !empty($row[1]) ? $row[1] : NULL;
					$tipoElementoVis = $this->model->obtener_id_tipoElemento( $nombreTipoElemento );
					$idTipoElementoVis = ( !empty($tipoElementoVis) ? $tipoElementoVis[0]['idTipoElementoVis'] : NULL );
				$nombreCategoria = !empty($row[2]) ? $row[2] : NULL;
					$categoria = $this->model->obtener_id_categoria( $nombreCategoria );
					$idCategoria = ( !empty($categoria) ? $categoria[0]['idCategoria'] : NULL );

				$input=array();
				$input['nombre'] = $nombreElemento;
				$input['idTipoElementoVisibilidad'] = $idTipoElementoVis;
				$input['idCategoria'] = $idCategoria;

				$rs_insertarElemento = $this->model->insertar_elemento_visibilidad($input);
				if ($rs_insertarElemento) {
					$rowInserted++;
					$htmlInserted .= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE LOGRÓ REGISTRAR EL ELEMENTO <strong>'.$input['nombre'].'</strong> CORRECTAMENTE.</div>';
				} else{
					$rowUpdatedError++;
					$htmlInsertedError .= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> HUBO INCONVENIENTES AL REGISTRAR EL ELEMENTO <strong>'.$input['nombre'].'</strong>.</div>';
				}
			}

			//VALORES REGISTRADOS CORRECTAMENTE
			if ( $rowInserted>0 ) {
				if ( $rowInserted>5 ) {
					$html.= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REALIZÓ EL <strong>REGISTRO DE '.$rowInserted.'</strong> ELEMENTOS DE VISIBILIDAD CORRECTAMENTE.</div>';
				} else {
					$html.= $htmlInserted;
				}
				$result['result'] = 1;
			}

			//VALORES REGISTRADOS INCORRECTAMENTE
			if ( $rowInsertedError>0) {
				if ( $rowInsertedError>5) {
					$html.= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> NO SE LOGRÓ REGISTRAR <strong>'.$rowUpdatedError.'</strong> ELEMENTOS DE VISIBLIDAD CORRECTAMENTE.</div>';
				} else {
					$html .= $htmlInsertedError;
				}
			}
		} else {
			$html.= $this->htmlNoResultado;
		}
		
		$result['msg']['title'] = 'REGISTRAR ELEMENTOS DE VISIBILIDAD MASIVO';
		$result['msg']['content'] = $html;
		$result['data']['htmlWidth'] =$htmlWidth ;

		echo json_encode($result);
	}

	/*===Auditoria Visibilidad==*/
	public function filtrarAuditoriaVisibilidad(){
		$result = $this->result;
		$data  = json_decode($this->input->post('data'));
		$tipoAuditoria = $data->{'visibilidad'};
		$fechas = explode(' - ', $data->{'txt-fechas'});

		$input=array();
		$input['fecIni'] = $fechas[0];
		$input['fecFin'] = $fechas[1];
		$input['proyecto'] = isset($data->{'proyecto'}) ? $data->{'proyecto'}:NULL;
		$input['grupoCanal'] = isset($data->{'grupoCanal'}) ? $data->{'grupoCanal'}:NULL;
		$input['canal'] = isset($data->{'canal'}) ? $data->{'canal'}:NULL;

		$html='';

		switch ($tipoAuditoria) {
			case 'obligatoria':
				$rs_obtenerListaObligatoria = $this->model->obtener_lista_auditoriaObligatoria($input);
				if ( !empty($rs_obtenerListaObligatoria)) {
					$array=array();
					foreach ($rs_obtenerListaObligatoria as $kle => $row) {
						$array['listaObligatorios'][$row['idListVisibilidadObl']] = $row;
					}

					$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/obligatorioDetalle", $array, true);
					$result['result'] = 1;
					$result['data']['datatable'] = 'tb-detalleObligatorio';
				} else {
					$html .= $this->htmlNoResultado;
				}
				break;
			case 'iniciativa':
				$rs_obtenerListaIniciativa = $this->model->obtener_lista_auditoriaIniciativa($input);
				if (!empty($rs_obtenerListaIniciativa)) {
					foreach ($rs_obtenerListaIniciativa as $kli => $row) {
						$array['listaIniciativas'][$row['idListVisibilidadIni']] = $row;
					}

					$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/iniciativaDetalle", $array, true);
					$result['result'] = 1;
					$result['data']['datatable'] = 'tb-detalleIniciativa';
				} else {
					$html .= $this->htmlNoResultado;
				}
				break;
			case 'adicional':
				$rs_obtenerListaAdicional = $this->model->obtener_lista_auditoriaAdicional($input);
				if (!empty($rs_obtenerListaAdicional)) {
					foreach ($rs_obtenerListaAdicional as $kla => $row) {
						$array['listaAdicional'][$row['idListVisibilidadAdc']] = $row;
					}

					$html .= $this->load->view("modulos/configuraciones/gestion/elementosVisibilidad/adicionalDetalle", $array, true);
					$result['result'] = 1;
					$result['data']['datatable'] = 'tb-detalleAdicional';
				} else {
					$html .= $this->htmlNoResultado;
				}
				break;
			default:
				$html .= $this->htmlNoResultado;
				break;
		}

		$result['data']['html'] = $html;

		echo json_encode($result);
	}

	public function cambiarEstadoLista(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$tipoListaVisibilidad = $data->{'tipoListaVisibilidad'};
		$idLista = $data->{'lista'};
		$valorEstado = !empty($data->{'estado'}) ? $data->{'estado'}:0;

		$html='';
		$htmlEstado=''; $htmlCheckBox=''; $htmlEditar=''; $htmlFecFin=''; $htmlVistaEstado='';

		switch ($tipoListaVisibilidad) {
			case 'obligatoria':
				$tabla = 'trade.list_visibilidadTradObl';
				$inputParams=array();
				$inputParams['fecFin'] = $valorEstado==0 ? date('Y-m-d'):NULL;
				$inputWhere=array();
				$inputWhere['idListVisibilidadObl'] = $idLista;

				$rs_updateEstado = $this->model->update_lista_visibilidad($tabla,$inputWhere,$inputParams);
				if ($rs_updateEstado) {
					$result['result'] = 1;
					$html.= $this->htmlUpdateResultado;

					if ($valorEstado==0) {
						$htmlCheckBox='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$idLista.'" value="1" data-tipo-visibilidad="obligatoria">';
						$htmlEstado='<a href="javascript:;" id="aObligatoria-'.$idLista.'" class="btn btn-danger btnCambiarListaFechaFin" title="DESACTIVADO" data-lista="'.$idLista.'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
						$htmlEditar='<span>-</span>';
						$htmlFecFin='<span>'.date('d/m/Y').'</span>';
						$htmlVistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';
					} else {
						$htmlCheckBox='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$idLista.'" value="0" data-tipo-visibilidad="obligatoria">';
						$htmlEstado='<a href="javascript:;" id="aObligatoria-'.$idLista.'" class="btn btn-primary btnCambiarListaFechaFin" title="ACTIVO" data-lista="'.$idLista.'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
						$htmlEditar='<button class="btn btn-success editarLista" title="EDITAR LISTA" data-lista="'.$idLista.'"><i class="fas fa-edit fa-lg"></i></button>';
						$htmlFecFin='<span>-</span>';
						$htmlVistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
					}
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;
			case 'iniciativa':
				$tabla = 'trade.list_visibilidadTradIni';
				$inputParams=array();
				$inputParams['fecFin'] = $valorEstado==0 ? date('Y-m-d'):NULL;
				$inputWhere=array();
				$inputWhere['idListVisibilidadIni'] = $idLista;

				$rs_updateEstado = $this->model->update_lista_visibilidad($tabla,$inputWhere,$inputParams);
				if ($rs_updateEstado) {
					$result['result'] = 1;
					$html.= $this->htmlUpdateResultado;

					if ($valorEstado==0) {
						$htmlCheckBox='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$idLista.'" value="1" data-tipo-visibilidad="iniciativa">';
						$htmlEstado='<a href="javascript:;" id="aIniciativa-'.$idLista.'" class="btn btn-danger btnCambiarListaFechaFin" title="DESACTIVADO" data-lista="'.$idLista.'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
						$htmlEditar='<span>-</span>';
						$htmlFecFin='<span>'.date('d/m/Y').'</span>';
						$htmlVistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';
					} else {
						$htmlCheckBox='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$idLista.'" value="0" data-tipo-visibilidad="iniciativa">';
						$htmlEstado='<a href="javascript:;" id="aIniciativa-'.$idLista.'" class="btn btn-primary btnCambiarListaFechaFin" title="ACTIVO" data-lista="'.$idLista.'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
						$htmlEditar='<button class="btn btn-success editarLista" title="EDITAR LISTA" data-lista="'.$idLista.'"><i class="fas fa-edit fa-lg"></i></button>';
						$htmlFecFin='<span>-</span>';
						$htmlVistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
					}
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;
			case 'adicional':
				$tabla = 'trade.list_visibilidadTradAdc';
				$inputParams=array();
				$inputParams['fecFin'] = $valorEstado==0 ? date('Y-m-d'):NULL;
				$inputWhere=array();
				$inputWhere['idListVisibilidadAdc'] = $idLista;

				$rs_updateEstado = $this->model->update_lista_visibilidad($tabla,$inputWhere,$inputParams);
				if ($rs_updateEstado) {
					$result['result'] = 1;
					$html.= $this->htmlUpdateResultado;

					if ($valorEstado==0) {
						$htmlCheckBox='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$idLista.'" value="1" data-tipo-visibilidad="adicional">';
						$htmlEstado='<a href="javascript:;" id="aAdicional-'.$idLista.'" class="btn btn-danger btnCambiarListaFechaFin" title="DESACTIVADO" data-lista="'.$idLista.'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
						$htmlEditar='<span>-</span>';
						$htmlFecFin='<span>'.date('d/m/Y').'</span>';
						$htmlVistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';
					} else {
						$htmlCheckBox='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$idLista.'" value="0" data-tipo-visibilidad="adicional">';
						$htmlEstado='<a href="javascript:;" id="aAdicional-'.$idLista.'" class="btn btn-primary btnCambiarListaFechaFin" title="ACTIVO" data-lista="'.$idLista.'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
						$htmlEditar='<button class="btn btn-success editarLista" title="EDITAR LISTA" data-lista="'.$idLista.'"><i class="fas fa-edit fa-lg"></i></button>';
						$htmlFecFin='<span>-</span>';
						$htmlVistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
					}
				} else {
					$html.= $this->htmlNoUpdateResultado;
				}
				break;
			default:
				$html = $this->htmlNoResultado;
				break;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO LISTA';
		$result['msg']['content'] = $html;
		$result['data']['htmlCheckBox'] = $htmlCheckBox;
		$result['data']['htmlEstado'] = $htmlEstado;
		$result['data']['htmlEditar'] = $htmlEditar;
		$result['data']['htmlFecFin'] = $htmlFecFin;
		$result['data']['htmlVistaEstado'] = $htmlVistaEstado;

		echo json_encode($result);
	}

	public function cambiarEstadoFecFinMasivo(){
		$result=$this->result;
		$data = json_decode($this->input->post('data'));

		$dataFecFin = !empty($data->{'fecFin'}) ? $data->{'fecFin'}:NULL;
		$dataListas = $data->{'dataListas'};

		$html='';
		$rowUpdated=0; $rowUpdatedError=0;

		if (!empty($dataListas)) {
			foreach ($dataListas as $kld => $lista) {
				
				$tipoListaVisibilidad = $lista->{'tabla'};
				$idLista = $lista->{'lista'};
				$fecFin = ( $lista->{'estado'}==0 ? $dataFecFin : NULL );

				$inputParams=array();
				$inputParams['fecFin'] = $fecFin;
				$inputWhere=array();

				switch ($tipoListaVisibilidad) {
					case 'obligatoria': 
						$tabla = 'trade.list_visibilidadTradObl'; 
						$inputWhere['idListVisibilidadObl'] = $idLista;
						break;
					case 'iniciativa':
						$tabla = 'trade.list_visibilidadTradIni';
						$inputWhere['idListVisibilidadIni'] = $idLista;
						break;
					case 'adicional':
						$tabla = 'trade.list_visibilidadTradAdc';
						$inputWhere['idListVisibilidadAdc'] = $idLista;
						break;
					default:
						$tabla='';
						break;
				}

				$rs_updateEstado = $this->model->update_lista_visibilidad($tabla,$inputWhere,$inputParams);
				if ($rs_updateEstado) { $rowUpdated++; }
				else{ $rowUpdatedError++; }
			}

			if ($rowUpdated>0) {
				$result['result']=1;
				$html.= '<div class="alert alert-success fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> SE REALIZÓ LA <strong>ACTUALIZACIÓN DE '.$rowUpdated.'</strong> LISTAS CORRECTAMENTE.</div>';
			}
			if ($rowUpdatedError>0) {
				$html.= '<div class="alert alert-danger fade show" role="alert"><i class="fas fa-cubes icon-solid"></i> NO SE LOGRÓ ACTUALIZAR <strong>'.$rowUpdatedError.'</strong> LISTAS CORRECTAMENTE.</div>';
			}
		} else {
			$html.= $this->htmlNoResultado;
		}

		$result['msg']['title'] = 'ACTUALIZAR ESTADO LISTA MASIVO';
		$result['msg']['content'] = $html;

		echo json_encode($result);
	}
}
?>