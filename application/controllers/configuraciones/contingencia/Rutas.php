<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rutas extends MY_Controller{

	var $htmlResultado = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> SE REALIZÓ LA ACTUALIZACIÓN DE LA INFORMACIÓN CORRECTAMENTE.</div>';
	var $htmlNoResultado = '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>';
	var $htmlButtons = 1;

	public function __construct(){
		parent::__construct();
		$this->load->model('configuraciones/contingencia/m_contingenciarutas','model');
	}

	function guardarAuditoria($table){
		$arrayAuditoria = array(
			'idUsuario' => $this->idUsuario
			,'accion' => 'INSERTAR'
			,'tabla' => $table
			,'sql' => $this->db->last_query()
		);
		guardarAuditoria($arrayAuditoria);
	}

	function generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, $moduloVisita){
		$mensajeRespuesta='';
		if ( $rowInsert > 0)
			$mensajeRespuesta .= getMensajeGestion('registroExitoso');

		if ( $rowUpdated > 0)
			$mensajeRespuesta .= getMensajeGestion('actualizacionExitosa');

		if ( $rowInsert==0 && $rowUpdated==0)
			$mensajeRespuesta .= $this->htmlNoResultado;
		
		//TRUE MODULO
		if ( $rowInsert>0 || $rowUpdated>0)
			$this->model->update_visita_modulo($idVisita, $moduloVisita);

		return $mensajeRespuesta;
	}

	function generarMensajeAlmacenanmientoFotos($rowInsertFotoError){
		$mensajeRespuesta='';
		if ( $rowInsertFotoError>0) {
			$mensajeRespuesta .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> VERIFICAR EL ALMACENAIENTO DE LAS FOTOS, PARECE QUE SE HA GENERADO UN INCONVENIENTE, CIERRE LA VENTANA DEL DETALLADO Y VUELVA A ABRIRLA PARA CORROBORAR EL ALMACENAMIENTO.</div>';
		}

		return $mensajeRespuesta;
	}

	public function index()
	{
		$this->aSessTrack[] = ['idAccion' => 4];

		$config = array();
		$config['nav']['menu_active'] = '64';
		$config['css']['style'] = array(
			'assets/libs/dataTables-1.10.20/datatables',
			'assets/custom/css/configuraciones/contingencia/estilos'
		);
		$config['js']['script'] = array(
			'assets/libs/datatables/datatables',
			'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/configuraciones/contingencia/rutas'
		);

		$config['data']['icon'] = 'fas fa-route';
		$config['data']['title'] = 'Contingencia Rutas';
		$config['data']['message'] = 'Lista de Visitas';
		$config['view'] = 'modulos/configuraciones/contingencia/rutas/index';

		$this->view($config);
	}

	public function filtrar(){
		$result = $this->result;
		$data  = json_decode($this->input->post('data'));
		
		$input = array();
		$input['fecha'] = $data->{'txt-fechas_simple'};
		$input['grupoCanal_filtro'] = $data->{'grupoCanal_filtro'};

		if(empty($data->{'chk-usuario-inactivo'}) || empty($data->{'chk-usuario-activo'}) ){
			$input['estadoUsuario'] = empty($data->{'chk-usuario-activo'}) ? 2 : 1;
		}
		if(empty($data->{'chk-usuario-inactivo'}) && empty($data->{'chk-usuario-activo'}) ){
			$input['estadoUsuario'] = 3;
		}

		$rs_visitas = $this->model->obtener_rutas_visitas($input);
		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal_filtro']]);

		$html = getMensajeGestion('noRegistros');

		if ( !empty($rs_visitas)) {
			$result['result'] = 1;
			$array=array();

			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idVisita']] = $row;
			}

			$rs_usuario_modulos = $this->model->obtener_modulos_usuario($input);

			if ( empty($rs_usuario_modulos)) {
				goto respuesta;
			}
			foreach ($rs_usuario_modulos as $klum => $row) {
				$array['listaUsuarioModulo'][$row['idUsuario']]['listaModulos'][$row['idModulo']] = $row['idModulo'];
			}


			$new_data = [];
			$ix=1;$listaUsuarioModulo = $array['listaUsuarioModulo'];$e=0;
			foreach ($array['listaVisitas'] as $ku => $row) {

				$cesado = !empty($row['cesado']) ? "text-danger" : "" ;
				//HORARIOS-
					//$incidencia = isset($row['estadoIncidencia']) ? ( $row['estadoIncidencia']==1 ? 'checked':'' ): '';
					$incidencia = isset($row['estadoIncidencia']) ? ( $row['estadoIncidencia']==1 ?'checked':''): '';
					$bloqueado="";
					$estiloBloqueado="";
					if ( $incidencia!=="" ) {
						$estiloBloqueado="tdBloqueado";
						$bloqueado="disabled";
					}
					/****/
					$textHoraInicio="";
					if ( !empty($row['horaIni']) ) {
						$textHoraInicio = $row['horaIni'];
					} else {
						$textHoraInicio = "<input type='time' name='horaInicio-".$row['idVisita']."' id='horaInicio-".$row['idVisita']."' class='form-control hora' value=''>";
						$estiloBloqueado="tdBloqueado";
						$bloqueado="disabled";
					}

					$textHoraFin="";
					if ( !empty($row['horaIni'])) {
						if ( !empty($row['horaFin'])) {
							$textHoraFin = $row['horaFin'];
						} else {
							$textHoraFin = "<input type='time' name='horaFin-".$row['idVisita']."' id='horaFin-".$row['idVisita']."' class='form-control hora' value=''>";
						}
					} else {
						$textHoraFin='Ingrese<br>Hora Inicio';
					}
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][1]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][12])) $btnEncuesta = ( $row['encuesta']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][2]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][13])) $btnIpp = ( $row['ipp']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][3]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][14])) $btnProductos = ( $row['productos']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][10]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][21])) $btnPrecios = ( $row['precios']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][7]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][18])) $btnPromociones = ( $row['promociones']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][5])) $btnSos = ( $row['sos']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][5]))  $btnSod = ( $row['sod']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][5])) $btnEncartes = ( $row['encartes']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][4]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][15])) $btnSeguimientoPlan = ( $row['seguimientoPlan']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][8]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][19])) $btnDespachos = ( $row['despachos']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][9]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][20])) $btnFotos = ( $row['moduloFotos']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][11]))  $btnInventario = ( $row['inventario']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][16])) $btnVisibilidad = ( $row['visibilidad']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][24])) $btnMantenimiento = ( $row['mantenimiento']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][22])) $btnIniciativa = ( $row['iniciativa']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][23]))   $btnInteligencia = ( $row['inteligencia']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][25])) $btnOrdenes = ( $row['ordenes']==1 ? 'btn-outline-success' : 'btn-outline-danger' );
					if (isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][27])) $btnVisibilidadAudit = ( $row['visibilidad_aud']==1 ? 'btn-outline-success' : 'btn-outline-danger' );

					$codUsuario =  !empty($row['codUsuario']) ? $row['codUsuario'] : '';
					$usuario =  !empty($row['usuario']) ? $row['usuario'] : '';

					$condicion = $row['condicion'];
					$condicion_ = '';
					$condicion_f = '';

					if ($condicion == 0 || $condicion == 4) {
						$condicion_ = 'SV <span class="color-F" ><i class="fa fa-circle" ></i></span>';
						$condicion_f = 'SV';
					} elseif ($condicion == 1) {
						$condicion_ = 'NE <span class="color-N" ><i class="fa fa-circle" ></i></span>';
						$condicion_f = 'NE';
					} elseif ($condicion == 2) {
						$condicion_ = 'IN <span class="color-I" ><i class="fa fa-circle" ></i></span>';
						$condicion_f = 'IN';
					} elseif ($condicion == 3) {
						$condicion_ = 'EF <span class="color-C" ><i class="fa fa-circle" ></i></span>';
						$condicion_f = 'EF';
					}

				$new_data[$e] = [
					//Columnas
					$ix++, 
					!empty($row['fecha'])?$row['fecha']:'-',
					!empty($row['codUsuario'])?$row['codUsuario']:'-',
					!empty($row['cesado']) ? "<h4 class='text-center'><span class=' badge badge-danger'>Cesado</span></h4>" : "<h4 class='text-center'><span class='badge badge-primary'>Activo</span></h4>", 
					!empty($row['usuario']) ? "<p class='text-left {$cesado}'> {$row['usuario']} </p>" : '-', 
					!empty($row['grupoCanal'])?$row['grupoCanal']:'-',
					!empty($row['canal'])?$row['canal']:'-',
				];
				foreach ($segmentacion['headers'] as $k => $v) { 
					array_push($new_data[$e],
						!empty($row[($v['columna'])]) ? "<p class='text-left'>{$row[($v['columna'])]}</p>" : '-'
					);
			   	}
				array_push($new_data[$e],
					!empty($row['departamento'])?$row['departamento']:'-',
					!empty($row['provincia'])?$row['provincia']:'-',
					!empty($row['distrito'])?$row['distrito']:'-',
					!empty($row['pdv'])?$row['pdv']:'-',
					!empty($row['codVisual'])?$row['codVisual']:'-',
					!empty($row['codCliente'])?$row['codCliente']:'-',
					!empty($row['direccion'])?$row['direccion']:'-',
					"<p class='text-center {$condicion_f}'>{$condicion_}</p>",
					$textHoraInicio,
					$textHoraFin,
					"<button type='button' class='btn border-0 btn-outline-danger saveHorarioVisita' data-visita='{$row['idVisita']}' title='ACTUALIZAR HORARIOS'><i class='fas fa-upload fa-lg'></i></button>",
					"<input type='checkbox' class='incidenciaVisita' name='incidencia' id='incidenciaVisita-{$row['idVisita']}' data-visita='{$row['idVisita']}' {$incidencia} data-cliente='{$row['pdv']}' data-width='90%'>",
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][1]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][12]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0 {$btnEncuesta} {$bloqueado}' data-title='ENCUESTA' data-modulo='encuesta' data-visita='{$row['idVisita']}' data-lista='{$row['idListEncuesta']}' data-columna='idListEncuesta' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-', 
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][2]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][13]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnIpp} {$bloqueado}' data-title='IPP' data-modulo='ipp' data-visita='{$row['idVisita']}' data-lista='{$row['idListIpp']}' data-columna='idListIpp' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][3]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][14]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnProductos} {$bloqueado}' data-title='CHECKLIST PRODUCTOS' data-modulo='productos' data-visita='{$row['idVisita']}' data-lista='{$row['idListProductos']}' data-columna='idListProductos' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][10]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][21]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnPrecios} {$bloqueado}' data-title='PRECIOS' data-modulo='precios' data-visita='{$row['idVisita']}' data-lista='{$row['idListPrecios']}' data-columna='idListProductos' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][7]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][18]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnPromociones} {$bloqueado}' data-title='PROMOCIONES' data-modulo='promociones' data-visita='{$row['idVisita']}' data-lista='{$row['idListPromociones']}' data-columna='idListPromociones' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][5])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnSos} {$bloqueado}' data-title='SHARE OF SHELF' data-modulo='sos' data-visita='{$row['idVisita']}' data-lista='{$row['idListSos']}' data-columna='idListVisibilidad' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][5])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnSod} {$bloqueado}' data-title='SHARE OF DISPLAY' data-modulo='sod' data-visita='{$row['idVisita']}' data-lista='{$row['idListSod']}' data-columna='idListVisibilidad' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][5])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnEncartes} {$bloqueado}' data-title='ENCARTES' data-modulo='encartes' data-visita='{$row['idVisita']}' data-lista='{$row['idListEncartes']}' data-columna='idListVisibilidad' data-cliente='{$row['pdv']}' data-width='50%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][4]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][15]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnSeguimientoPlan} {$bloqueado}' data-title='SEGUIMIENTO DE PLAN' data-modulo='seguimientoPlan' data-visita='{$row['idVisita']}' data-lista='{$row['idListSeguimientoPlan']}' data-columna='idListSeguimientoPlan' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][8]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][19]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnDespachos} {$bloqueado}' data-title='DESPACHOS' data-modulo='despachos' data-visita='{$row['idVisita']}' data-lista='{$row['idListDespachos']}' data-columna='idListPromociones' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][9]) || isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][20]))? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnFotos} {$bloqueado}' data-title='FOTOS' data-modulo='moduloFotos' data-visita='{$row['idVisita']}' data-lista='{$row['idListFotos']}' data-columna='idListFotos' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][11])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnInventario} {$bloqueado}' data-title='INVENTARIO' data-modulo='inventario' data-visita='{$row['idVisita']}' data-lista='{$row['idListInventario']}' data-columna='idListInventario' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][16])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnVisibilidad} {$bloqueado}' data-title='VISIBILIDAD TRADICIONAL' data-modulo='visibilidadTrad' data-visita='{$row['idVisita']}' data-lista='{$row['idListVisibilidadTrad']}' data-columna='idListVisibilidadTrad' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][24])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnMantenimiento} {$bloqueado}' data-title='MANTENIMIENTO CLIENTE' data-modulo='mantenimiento' data-visita='{$row['idVisita']}' data-lista='{$row['idListMantenimiento']}' data-columna='idListMantenimiento' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][22])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnIniciativa} {$bloqueado}' data-title='INICIATIVAS TRADICIONAL' data-modulo='iniciativaTrad' data-visita='{$row['idVisita']}' data-lista='{$row['idListIniciativa']}' data-columna='idListIniciativa' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][23])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnInteligencia} {$bloqueado}' data-title='INTELIGENCIA COMPETITIVA' data-modulo='inteligencia' data-visita='{$row['idVisita']}' data-lista='{$row['idListCategoriaMarcaComp']}' data-columna='idListCategoriaMarcaComp' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][25])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnOrdenes} {$bloqueado}' data-title='ORDENES DE TRABAJO' data-modulo='ordenes' data-visita='{$row['idVisita']}' data-lista='{$row['idListOrdenes']}' data-columna='idListOrdenes' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>" : '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][27])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnVisibilidadAudit} {$bloqueado}' data-title='VISIBILIDAD AUDITORIA OBLIGATORIA' data-modulo='visibilidad_aud_obl' data-visita='{$row['idVisita']}' data-lista='{$row['idListVisibilidadTradObl']}' data-columna='idListVisibilidadTradObl' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][27])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnVisibilidadAudit} {$bloqueado}' data-title='VISIBILIDAD AUDITORIA INICIATIVA' data-modulo='visibilidad_aud_ini' data-visita='{$row['idVisita']}' data-lista='{$row['idListIniciativasTrad']}' data-columna='idListIniciativasTrad' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-',
					(isset($listaUsuarioModulo[$row['idUsuario']]['listaModulos'][27])) ? "<a href='javascript:;' class='visitaModulo opcionModulo btn border-0  {$btnVisibilidadAudit} {$bloqueado}' data-title='VISIBILIDAD AUDITORIA ADICIONAL' data-modulo='visibilidad_aud_adc' data-visita='{$row['idVisita']}' data-lista='{$row['idListVisibilidadTradAdc']}' data-columna='idListVisibilidadTradAdc' data-cliente='{$row['pdv']}' data-width='90%'><i class='fas fa-check fa-lg'></i></a>": '-'
					// "<a href='javascript:;' class='opcionCargarData btn border-0 btn-outline-danger' data-title='CARGAR DATA' data-width='90%' data-codUsuario='{$codUsuario}' data-usuario='{$usuario}'><i class='fas fa-upload fa-lg'></i></a>",
				);
				$e++;
			}

			$result['data']['configTable'] =  [
					'data' => $new_data,
					'columnDefs' => 
					[ 
						0 => ["className"=> 'text-left',"targets" => [2,3,4,5,6,7,10] ],
						1 => ["className"=> 'text-center',"targets" => '_all' ],
						// 2 => ["visible"=> false,"targets" => [4,5,8,9,18,22,23,24,25,26,34] ],
					],

			];
			  
			$array['segmentacion'] = $segmentacion;
			switch ( $data->{'tipoFormato'} ) {
				case 1:
					$array['idDataTableDetalle'] = 'tb-contingenciaRutasDetalleGtm';

					$html = $this->load->view("modulos/configuraciones/contingencia/rutas/CtnRutasDetalle", $array, true);
					$result['data']['views']['contentGtm']['html'] = $html;
					$result['data']['views']['contentGtm']['datatable'] = 'tb-contingenciaRutasDetalleGtm';
					
					break;
				
				case 2:
					$array['idDataTableDetalle'] = 'tb-contingenciaRutasDetalleSupervisor';

					$html = $this->load->view("modulos/configuraciones/contingencia/rutas/CtnRutasDetalle", $array, true);
					$result['data']['views']['contentSupervisor']['html'] = $html;
					$result['data']['views']['contentSupervisor']['datatable'] = 'tb-contingenciaRutasDetalleSupervisor';
					break;
				
				default:
					$html = getMensajeGestion('noRegistros');
					break;	
			}
		} else {
			$html = getMensajeGestion('noRegistros');
			$result['data']['html'] = $html;
		}

		$this->aSessTrack = $this->model->aSessTrack;
		respuesta:
		echo json_encode($result);
	}

	public function visitaIncidencia(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$array=array();
		$array['idVisita'] = $data->{'visita'};
		
		$rs_tipoIncidencia = $this->model->obtener_tipo_incidencia();
		$array['listaTipoIncidencia'] = $rs_tipoIncidencia;
		$array['estadoIncidencia'] = $data->{'estado'};

		$html='';
		if ( $data->{'estado'}==1) {
			$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaIncidencia","guardarIncidencia");';
		} else {
			$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaIncidencia","actualizarIncidencia");';
		}
		$html .= $this->load->view("modulos/configuraciones/contingencia/rutas/visita_incidencia", $array, true);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'VISITA INCIDENCIA';
		$result['data']['html'] = $html;
		$result['data']['htmlGuardar'] = $htmlGuardar;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function visitaModulos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$modulo = $data->{'modulo'}; //Puede cambiar
		$idVisita = $data->{'visita'}; //Puede cambiar
		$columna = $data->{'columna'}; // No puede cambiar
		$idLista = $data->{'lista'}; //Puede cambiar

		$idListaVisita = 0;
		if ( $idLista != 0) {
			$idListaVisita = $this->model->obtener_lista_visita($idVisita, $columna);

			$idListaVisita = $idListaVisita[0][$columna];
			$idListaVisita = !empty($idListaVisita) ? $idListaVisita : 0;
		}

		$html=''; $htmlGuardar='';
		$input=array();
		$input['idVisita'] = $idVisita;
		$input['idListaModuloVisita'] = $idListaVisita;

		switch ($modulo) {
			case 'encuesta':
				$html = $this->obtener_visita_encuesta($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaEncuesta","guardarEncuestas");';
				break;
			case 'ipp':
				$html = $this->obtener_visita_ipp($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaIpp","guardarIpp");';
				break;
			case 'productos':
				$html = $this->obtener_visita_productos($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaProductos","guardarProductos");';
				break;
			case 'precios':
				$html = $this->obtener_visita_precios($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaPrecios","guardarPrecios");';
				break;
			case 'promociones':
				$html = $this->obtener_visita_promociones($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaPromociones","guardarPromociones");';
				break;
			case 'sos':
				$html = $this->obtener_visita_sos($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaSos","guardarSos");';
				break;
			case 'sod':
				$html = $this->obtener_visita_sod($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaSod","guardarSod");';
				break;
			case 'encartes':
				$html = $this->obtener_visita_encartes($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaEncartes","guardarEncartes");';
				break;
			case 'seguimientoPlan':
				$html = $this->obtener_visita_seguimientoPlan($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaSeguimientoPlan","guardarSeguimientoPlan");';
				break;
			case 'despachos':
				$html = $this->obtener_visita_despachos($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaDespachos","guardarDespachos");';
				break;
			case 'moduloFotos':
				$html = $this->obtener_visita_moduloFotos($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaFotos","guardarFotos");';
				break;
			case 'inventario':
				$html = $this->obtener_visita_inventario($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaInventario","guardarInventario");';
				break;
			case 'visibilidadTrad':
				$html = $this->obtener_visita_visibilidad($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaVisibilidad","guardarVisibilidad");';
				break;
			case 'mantenimiento':
				$html = $this->obtener_visita_mantenimiento($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaMantenimiento","guardarMantenimiento");';
				break;
			case 'iniciativaTrad':
				$html = $this->obtener_visita_iniciativa($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaIniciativaTrad","guardarIniciativaTrad");';
				break;
			case 'inteligencia':
				$html = $this->obtener_visita_inteligencia($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaInteligencia","guardarInteligencia");';
				break;
			case 'ordenes':
				$html = $this->obtener_visita_ordenes($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaOrden","guardarOrdenes");';
				break;
			case 'visibilidad_aud_obl':
				$html = $this->obtener_visita_visibilidadAuditoriaObligatoria($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaVisibilidadAuditoriaObligatoria","guardarVisibilidadAuditoriaObligatoria");';
				break;
			case 'visibilidad_aud_ini':
				$html = $this->obtener_visita_visibilidadAuditoriaIniciativa($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaVisibilidadAuditoriaIniciativa","guardarVisibilidadAuditoriaIniciativa");';
				break;
			case 'visibilidad_aud_adc':
				$html = $this->obtener_visita_visibilidadAuditoriaAdicional($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaVisibilidadAuditoriaAdicional","guardarVisibilidadAuditoriaAdicional");';
				break;
			case 'premio':
				$html = $this->obtener_visita_premio($input);
				$htmlGuardar = 'ContingenciaRutas.verificarFormulario("frm-visitaEncuestaPremio","guardarEncuestaPremio");';
				break;
			default:
				$html = $this->htmlNoResultado;
				break;
		}

		//Result
		$result['result'] = 1;
		$result['data']['html'] = $html;
		$result['data']['htmlButtons'] = $this->htmlButtons;
		$result['data']['htmlGuardar'] = $htmlGuardar;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	function obtener_visita_encuesta($input=array()){
		$rs_detalle = $this->model->obtener_lista_visita_encuesta($input);

		if ( !empty($rs_detalle) ) {
			$array=array();
			$array['idVisita'] = $input['idVisita'];
			$this->htmlButtons = 2;

			foreach ($rs_detalle as $kle => $row) {
				$array['listaEncuestas'][$row['idEncuesta']]['idEncuesta'] = $row['idEncuesta'];
				$array['listaEncuestas'][$row['idEncuesta']]['encuesta'] = $row['encuesta'];
				$array['listaEncuestas'][$row['idEncuesta']]['fotoEncuesta'] = $row['fotoEncuesta'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['idTipoPregunta'] = $row['idTipoPregunta'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['tipoPregunta'] = $row['tipoPregunta'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['obligatorio'] = $row['obligatorio'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['fotoPregunta'] = $row['fotoPregunta'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['idAlternativaPadre'] = $row['idAlternativaPadre'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['alternativa'] = $row['alternativa'];
				$array['listaEncuestas'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['fotoAlternativa'] = $row['fotoAlternativa'];
			}

			$rs_detalleVisita = $this->model->obtener_data_visita_encuesta($input);
			foreach ($rs_detalleVisita as $kv => $row) {
				$array['visita'][$row['idEncuesta']]['idVisitaEncuesta'] = $row['idVisitaEncuesta'];
				$array['visita'][$row['idEncuesta']]['idEncuesta'] = $row['idEncuesta'];
				$array['visita'][$row['idEncuesta']]['hora'] = $row['hora'];
				$array['visita'][$row['idEncuesta']]['idVisitaFoto'] = $row['idVisitaFoto'];
				$array['visita'][$row['idEncuesta']]['fotoEncuesta'] = $row['fotoEncuesta'];
				$array['visita'][$row['idEncuesta']]['numDet'] = $row['numDet'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['idTipoPregunta'] = $row['idTipoPregunta'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				//$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['idVisitaFotoAlternativa'] = $row['idVisitaFotoAlternativa'];
				//$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['fotoAlternativa'] = $row['fotoAlternativa'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['respuestas']['idVisitaEncuestaDet'] = $row['idVisitaEncuestaDet'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['respuestas']['respuesta'] = $row['respuesta'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['respuestas']['idVisitaFotoAlternativa'] = $row['idVisitaFotoAlternativa'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['respuestas']['fotoAlternativa'] = $row['fotoAlternativa'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idVisitaEncuestaDet'] = $row['idVisitaEncuestaDet'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idVisitaFotoAlternativa'] = $row['idVisitaFotoAlternativa'];
				$array['visita'][$row['idEncuesta']]['tipoPreguntas'][$row['idTipoPregunta']]['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['fotoAlternativa'] = $row['fotoAlternativa'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_encuesta",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_ipp($input=array()){
		$rs_detalle = $this->model->detalle_visita_ipp($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				$array['listaIpp'][$row['idIpp']]['idIpp'] = $row['idIpp'];
				$array['listaIpp'][$row['idIpp']]['ipp'] = $row['ipp'];
				$array['listaIpp'][$row['idIpp']]['foto'] = $row['foto'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['idCriterio'] = $row['idCriterio'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['criterio'] = $row['criterio'];
				//$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listTipoPreguntas'][$row['idTipoPregunta']]['idTipoPregunta'] = $row['idTipoPregunta'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['idTipoPregunta'] = $row['idTipoPregunta'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['orden'] = $row['orden'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['obligatorio'] = $row['obligatorio'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['alternativa'] = $row['alternativa'];
				$array['listaIpp'][$row['idIpp']]['listaCriterios'][$row['idCriterio']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['puntaje'] = $row['puntaje'];
			}

			$rs_detalleVisita = $this->model->obtener_data_visita_ipp($input);
			foreach ($rs_detalleVisita as $kv => $row) {
				$array['visita'][$row['idIpp']]['idIpp'] = $row['idIpp'];
				$array['visita'][$row['idIpp']]['idVisitaIpp'] = $row['idVisitaIpp'];
				$array['visita'][$row['idIpp']]['puntaje'] = $row['puntaje'];
				$array['visita'][$row['idIpp']]['listaPreguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['visita'][$row['idIpp']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['visita'][$row['idIpp']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['idVisitaIppDet'] = $row['idVisitaIppDet'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_ipp",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_productos($input=array()){
		$rs_detalle = $this->model->detalle_visita_productos($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				$array['listaCompetencia'][$row['flagCompetencia']]['flagCompetencia'] = $row['flagCompetencia'];
				$array['listaCompetencia'][$row['flagCompetencia']]['competencia'] = $row['competencia'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaProductos'][$row['idProducto']]['idProducto'] = $row['idProducto'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaProductos'][$row['idProducto']]['producto'] = $row['producto'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaProductos'][$row['idProducto']]['ean'] = $row['ean'];
			}

			$rs_unidadMedida = $this->model->obtener_unidad_medida();
			$array['unidadMedida'] = $rs_unidadMedida;

			$rs_motivos = $this->model->obtener_motivo();
			$array['motivos'] = $rs_motivos;

			$rs_visitas = $this->model->obtener_data_visita_productos($input);
			foreach ($rs_visitas as $kv => $visita) {
				$array['listaVisitas'][$visita['flagCompetencia']][$visita['idProducto']] = $visita;
			}

			$rs_visitaCanal = $this->model->obtener_visita_canal($input);
			$array['grupoCanal'] = $rs_visitaCanal[0]['idGrupoCanal'];
			$idGrupoCanal = getGrupoCanalDeVisita($input['idVisita']);
			$array['columnasAdicionales'] = getColumnasAdicionales(['idModulo' => 3, 'idGrupoCanal' => $idGrupoCanal])['body_adicionales'];

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_productos",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_precios($input=array()){
		$rs_detalle = $this->model->detalle_visita_precios($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				$array['listaCompetencia'][$row['flagCompetencia']]['flagCompetencia'] = $row['flagCompetencia'];
				$array['listaCompetencia'][$row['flagCompetencia']]['competencia'] = $row['competencia'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaProductos'][$row['idProducto']]['idProducto'] = $row['idProducto'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaProductos'][$row['idProducto']]['producto'] = $row['producto'];
				$array['listaCompetencia'][$row['flagCompetencia']]['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaProductos'][$row['idProducto']]['ean'] = $row['ean'];
			}

			$rs_visitas = $this->model->obtener_data_visita_precios($input);
			foreach ($rs_visitas as $kv => $visita) {
				$array['listaVisitas'][$visita['flagCompetencia']][$visita['idProducto']] = $visita;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_precios",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_promociones($input=array()){
		$rs_detalle = $this->model->detalle_visita_promociones($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $promocion) {
				$array['listaPromociones'][$promocion['idPromocion']] = $promocion;
			}

			$rs_visitas = $this->model->obtener_data_visita_promociones($input);
			foreach ($rs_visitas as $kv => $visita) {
				$array['listaVisitas'][$visita['idVisitaPromocionesDet']] = $visita;
			}

			$rs_tipoPromociones = $this->model->obtener_tipo_promocion();
			$array['listaTipoPromociones'] = $rs_tipoPromociones;
			
			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_promociones",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_sos($input=array()){
		$rs_detalle = $this->model->detalle_visita_sos($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				//$array['flagCompetencia'] = $row['flagCompetencia'];
				//$array['competencia'] = $row['competencia'];
				$array['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['flagCompetencia'] = $row['flagCompetencia'];
			}

			$rs_visitas = $this->model->obtener_data_visita_sos($input);
			foreach ($rs_visitas as $kv => $visita) {
				//$array['listaVisitas']['flagCompetencia'] = $visita['flagCompetencia'];
				//$array['listaVisitas']['competencia'] = $visita['competencia'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['idVisitaSos'] = $visita['idVisitaSos'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['idCategoria'] = $visita['idCategoria'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['categoria'] = $visita['categoria'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['numDet'] = $visita['numDet'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['cm'] = $visita['categoriaCm'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['frentes'] = $visita['categoriaFrentes'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['idVisitaFoto'] = $visita['idVisitaFoto'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['foto'] = $visita['foto'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['listaMarcas'][$visita['idMarca']]['idVisitaSosDet'] = $visita['idVisitaSosDet'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['listaMarcas'][$visita['idMarca']]['idMarca'] = $visita['idMarca'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['listaMarcas'][$visita['idMarca']]['marca'] = $visita['marca'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['listaMarcas'][$visita['idMarca']]['cm'] = $visita['marcaCm'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['listaMarcas'][$visita['idMarca']]['frentes'] = $visita['marcaFrentes'];
				$array['listaVisitas']['listaCategorias'][$visita['idCategoria']]['listaMarcas'][$visita['idMarca']]['flagCompetencia'] = $visita['flagCompetencia'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_sos",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_sod($input=array()){
		$rs_detalle = $this->model->detalle_visita_sod($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				//$array['flagCompetencia'] = $row['flagCompetencia'];
				//$array['competencia'] = $row['competencia'];
				$array['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['flagCompetencia'] = $row['flagCompetencia'];
			}

			$rs_tipoElementoVisibilidad = $this->model->obtener_tipo_elemento_visibilidad();
			foreach ($rs_tipoElementoVisibilidad as $kev => $elemento) {
				$array['listaElementoVisibilidad'][$elemento['idTipoElementoVisibilidad']] = $elemento;
			}

			$rs_visitas = $this->model->obtener_data_visita_sod($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['idVisitaSod'] = $row['idVisitaSod'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['cant'] = $row['cant'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['cantidaMarca'] = isset($array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['cantidaMarca']) ? $array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['cantidaMarca']+$row['cantDet'] : $row['cantDet'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idVisitaSodDet'] = $row['idVisitaSodDet'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idTipoElementoVisibilidad'] = $row['idTipoElementoVisibilidad'];
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['cant'] = $row['cantDet'];
				
				$array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['cant'] = isset($array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['cant']) ? $array['listaVisitas']['listaCategorias'][$row['idCategoria']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['cant'] + $row['cantDet']: $row['cantDet'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_sod",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_encartes($input=array()){
		$rs_detalle = $this->model->detalle_visita_encartes($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				//$array['flagCompetencia'] = $row['flagCompetencia'];
				//$array['competencia'] = $row['competencia'];
				$array['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				//$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				//$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
				//$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['flagCompetencia'] = $row['flagCompetencia'];
			}
			$rs_visitas = $this->model->obtener_data_visita_encartes($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idVisitaEncartesDet']] = $row;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_encartes",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_seguimientoPlan($input=array()){
		$rs_detalle = $this->model->detalle_visita_seguimientoPlan($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $key => $row) {
				$array['listaSeguimientoPlan'][$row['idSeguimientoPlan']]['idSeguimientoPlan'] = $row['idSeguimientoPlan'];
				$array['listaSeguimientoPlan'][$row['idSeguimientoPlan']]['seguimientoPlan'] = $row['seguimientoPlan'];
				$array['listaSeguimientoPlan'][$row['idSeguimientoPlan']]['idListSeguimientoPlan'] = $row['idListSeguimientoPlan'];
				$array['listaSeguimientoPlan'][$row['idSeguimientoPlan']]['listaTipoElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idTipoElementoVisibilidad'] = $row['idTipoElementoVisibilidad'];
				$array['listaSeguimientoPlan'][$row['idSeguimientoPlan']]['listaTipoElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['tipoElementoVisibilidad'] = $row['tipoElementoVisibilidad'];
				$array['listaSeguimientoPlan'][$row['idSeguimientoPlan']]['listaTipoElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idListSeguimientoPlanDet'] = $row['idListSeguimientoPlanDet'];
			}

			$rs_motivos = $this->model->obtener_motivo();
			$array['motivos'] = $rs_motivos;

			$rs_marcas = $this->model->obtener_marca();
			$array['marcas'] = $rs_marcas;

			$rs_visitas = $this->model->obtener_data_visita_seguimientoPlan($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['idSeguimientoPlan'] = $row['idSeguimientoPlan'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['idVisitaSeguimientoPlan'] = $row['idVisitaSeguimientoPlan'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['numDet'] = $row['numDet'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idVisitaSeguimientoPlan'] = $row['idVisitaSeguimientoPlan'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idVisitaSeguimientoPlanDet'] = $row['idVisitaSeguimientoPlanDet'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idTipoElementoVisibilidad'] = $row['idTipoElementoVisibilidad'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['armado'] = $row['armado'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['revestido'] = $row['revestido'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idMotivo'] = $row['idMotivo'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['comentario'] = $row['comentario'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idMarca'] = $row['idMarca'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['idVisitaFoto'] = $row['idVisitaFoto'];
				$array['listaVisitasSegPlan'][$row['idSeguimientoPlan']]['listaElementoVisibilidad'][$row['idTipoElementoVisibilidad']]['foto'] = $row['foto'];
			};

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_seguimientoPlan",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_despachos($input=array()){
		$rs_detalle = $this->model->obtener_incidencias($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			$array['listaIncidencias'] = $rs_detalle;

			$rs_visitas = $this->model->obtener_data_visita_despachos($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['visita']['idVisitaDesapachosDet'] = $row['idVisitaDesapachosDet'];
				$array['visita']['idVisitaDespachos'] = $row['idVisitaDespachos'];
				$array['visita']['placa'] = $row['placa'];
				$array['visita']['horaIni'] = $row['horaIni'];
				$array['visita']['horaFin'] = $row['horaFin'];
				$array['visita']['idIncidencia'] = $row['idIncidencia'];
				$array['visita']['comentario'] = $row['comentario'];
				$array['visita']['listaDias'][$row['idDia']]['idDia'] = $row['idDia'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_despachos",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_moduloFotos($input=array()){
		$rs_detalle = $this->model->obtener_tipo_foto($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];
			
			$array['listaTipoFoto'] = $rs_detalle;

			$rs_visitas = $this->model->obtener_data_visita_fotos($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idVisitaModuloFoto']] = $row;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_fotos",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_inventario($input=array()){
		$rs_detalle = $this->model->obtener_lista_visita_inventario($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kp => $row) {
				$array['listaProductos'][$row['idProducto']] = $row;
			}

			$rs_productoInventario = $this->model->obtener_lista_inventario_producto($input);
			foreach ($rs_productoInventario as $klpi => $row) {
				$array['listaInventarioProductos'][$row['idProducto']] = $row;
			}

			$rs_visitas = $this->model->obtener_data_visita_inventario($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idProducto']] = $row;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_inventario",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_visibilidad($input=array()){
		$rs_detalle = $this->model->detalle_visita_visibilidadTrad($input);
		$rs_detalle2 = $this->model->detalle_visita_visibilidadTrad_nomodulados($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kvs => $row) {
				$array['listaElementoVisibilidad'][$row['idElementoVis']] = $row;
			}
			foreach ($rs_detalle2 as $kvs => $row) {
				$array['listaElementoVisibilidadNoModulados'][$row['idElementoVis']] = $row;
			}

			$rs_estadoElementos = $this->model->obtener_estado_elementos($input);
			foreach ($rs_estadoElementos as $kee => $row) {
				$array['listaEstadoElementos'][$row['idEstadoElemento']] = $row;
			}

			$rs_visitas = $this->model->obtener_data_visita_visibilidadTrad($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idVisitaVisibilidadDet']] = $row;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_visibilidad",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_mantenimiento($input=array()){
		$rs_detalle = $this->model->obtener_regiones($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kr => $row) {
				$array['listaRegiones'][$row['cod_departamento']]['cod_departamento'] = $row['cod_departamento'];
				$array['listaRegiones'][$row['cod_departamento']]['departamento'] = $row['departamento'];
				$array['listaRegiones'][$row['cod_departamento']]['cod_ubigeo'] = $row['cod_ubigeo'];
				$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['cod_provincia'] = $row['cod_provincia'];
				$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['provincia'] = $row['provincia'];
				$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['cod_ubigeo'] = $row['cod_ubigeo'];
				$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['cod_distrito'] = $row['cod_distrito'];
				$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['distrito'] = $row['distrito'];
				$array['listaRegiones'][$row['cod_departamento']]['listaProvincias'][$row['cod_provincia']]['listaDistritos'][$row['cod_distrito']]['cod_ubigeo'] = $row['cod_ubigeo'];
			}

			$rs_visitas = $this->model->obtener_data_visita_mantenimiento($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['visita']['idVisitaMantCliente'] = $row['idVisitaMantCliente'];
				$array['visita']['codCliente'] = $row['codCliente'];
				$array['visita']['nombreComercial'] = $row['nombreComercial'];
				$array['visita']['razonSocial'] = $row['razonSocial'];
				$array['visita']['ruc'] = $row['ruc'];
				$array['visita']['dni'] = $row['dni'];
				$array['visita']['cod_ubigeo'] = $row['cod_ubigeo'];
				$array['visita']['direccion'] = $row['direccion'];
				$array['visita']['latitud'] = $row['latitud'];
				$array['visita']['longitud'] = $row['longitud'];
				$array['visita']['cod_departamento'] = $row['cod_departamento'];
				$array['visita']['cod_distrito'] = $row['cod_distrito'];
				$array['visita']['cod_provincia'] = $row['cod_provincia'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_mantenimiento",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_iniciativa($input=array()){
		$rs_detalle = $this->model->detalle_visita_iniciativas($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kin => $row) {
				$array['listaIniciativas'][$row['idIniciativa']]['idListIniciativaTrad'] = $row['idListIniciativaTrad'];
				$array['listaIniciativas'][$row['idIniciativa']]['idListIniciativaTradDet'] = $row['idListIniciativaTradDet'];
				$array['listaIniciativas'][$row['idIniciativa']]['idIniciativa'] = $row['idIniciativa'];
				$array['listaIniciativas'][$row['idIniciativa']]['iniciativa'] = $row['iniciativa'];
				$array['listaIniciativas'][$row['idIniciativa']]['iniciativaDescripcion'] = $row['iniciativaDescripcion'];
				$array['listaIniciativas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['idElementoIniciativa'] = $row['idElementoIniciativa'];
				$array['listaIniciativas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['elementoIniciativa'] = $row['elementoIniciativa'];
				$array['listaIniciativas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['estado'][$row['idEstadoIniciativa']] = $row['estadoIniciativa'];
			}

			// $rs_estadoIniciativas = $this->model->obtener_estado_iniciativa();
			// foreach ($rs_estadoIniciativas as $kri => $estados) {
			// 	$array['listaEstadoIniciativa'][$estados['idEstadoIniciativa']] = $estados;
			// }

			$rs_visitas = $this->model->obtener_data_visita_iniciativas($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idIniciativa']]['idIniciativa'] = $row['idIniciativa'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['idVisitaIniciativaTrad'] = $row['idVisitaIniciativaTrad'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['idVisitaIniciativaTradDet'] = $row['idVisitaIniciativaTradDet'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['idElementoIniciativa'] = $row['idElementoIniciativa'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['presencia'] = $row['presencia'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['cantidad'] = $row['cantidad'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['idEstadoIniciativa'] = $row['idEstadoIniciativa'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['producto'] = $row['producto'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['idVisitaFoto'] = $row['idVisitaFoto'];
				$array['listaVisitas'][$row['idIniciativa']]['listaElementosIniciativa'][$row['idElementoIniciativa']]['foto'] = $row['foto'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_iniciativaTrad",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_inteligencia($input=array()){
		$rs_detalle = $this->model->detalle_visita_inteligencia($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kr => $row) {
				$array['listaCategorias'][$row['idCategoria']]['idCategoria'] = $row['idCategoria'];
				$array['listaCategorias'][$row['idCategoria']]['categoria'] = $row['categoria'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['idMarca'] = $row['idMarca'];
				$array['listaCategorias'][$row['idCategoria']]['listaMarcas'][$row['idMarca']]['marca'] = $row['marca'];
			}

			$rs_visitas = $this->model->obtener_data_visita_inteligenciaCompetitiva($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idVisitaInteligenciaTradDet']] = $row;
			}

			$rs_tipoCompetencias = $this->model->obtener_tipo_competencia($input);
			$array['tipoCompetencias'] = $rs_tipoCompetencias;

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_inteligencia",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_ordenes($input=array()){
		$rs_detalle = $this->model->obtener_ordenes($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $ko => $ordenes) {
				$array['listaOrdenes'][$ordenes['idOrden']] = $ordenes;
			}

			$rs_estadoOrdenes = $this->model->obtener_orden_estado();
			foreach ($rs_estadoOrdenes as $keo => $orden) {
				$array['listaEstadoOrden'][$orden['idOrdenEstado']] = $orden;
			}

			$rs_visitas = $this->model->obtener_data_visita_ordenes($input);
			if (!empty($rs_visitas)) {
				$array['visita']['idVisitaOrden'] = $rs_visitas[0]['idVisitaOrden'];
				$array['visita']['idOrden'] = $rs_visitas[0]['idOrden'];
				$array['visita']['descripcion'] = $rs_visitas[0]['descripcion'];
				$array['visita']['idOrdenEstado'] = $rs_visitas[0]['idOrdenEstado'];
				$array['visita']['flagOtro'] = $rs_visitas[0]['flagOtro'];
				$array['visita']['idVisitaFoto'] = $rs_visitas[0]['idVisitaFoto'];
				$array['visita']['foto'] = $rs_visitas[0]['foto'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_ordenes",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_visibilidadAuditoriaObligatoria($input=array()){
		$rs_detalle = $this->model->obtener_lista_visita_visibilidadAudObligatoria($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kl => $row) {
				$array['listaElementoVisibilidad'][$row['idElementoVis']] = $row;
			}

			$rs_variablesVisibilidad = $this->model->obtener_variables_visibilidad();
			foreach ($rs_variablesVisibilidad as $kvv => $variables) {
				$array['listaVariablesVisibilidad'][$variables['idVariable']] = $variables;
			}

			$rs_observaciones = $this->model->obtener_observaciones_obligatoria();
			foreach ($rs_observaciones as $koo => $row) {
				$array['listaVariablesObs'][$row['idVariable']]['idVariable'] = $row['idVariable'];
				$array['listaVariablesObs'][$row['idVariable']]['listaObservaciones'][$row['idObservacion']]['idObservacion'] = $row['idObservacion'];
				$array['listaVariablesObs'][$row['idVariable']]['listaObservaciones'][$row['idObservacion']]['descripcion'] = $row['descripcion'];
			}

			$rs_visitas = $this->model->obtener_visita_visibilidad_obligatoria($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idElementoVis']]['idElementoVis'] = $row['idElementoVis'];
				$array['listaVisitas'][$row['idElementoVis']]['cantidad'] = $row['cantidad'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['idVisitaVisibilidad'] = $row['idVisitaVisibilidad'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['idVisitaVisibilidadDet'] = $row['idVisitaVisibilidadDet'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['idVariable'] = $row['idVariable'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['presencia'] = $row['presencia'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['idObservacion'] = $row['idObservacion'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['comentario'] = $row['comentario'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['idVisitaFoto'] = $row['idVisitaFoto'];
				$array['listaVisitas'][$row['idElementoVis']]['listaVariables'][$row['idVariable']]['foto'] = $row['foto'];

			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_visibilidadAuditoriaObligatoria",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_visibilidadAuditoriaIniciativa($input=array()){
		$rs_detalle = $this->model->obtener_lista_visita_visibilidadAudIniciativa($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kl => $row) {
				$array['listaElementoVisibilidad'][$row['idElementoVis']] = $row;
			}

			$rs_observaciones = $this->model->obtener_observaciones_iniciativa();
			foreach ($rs_observaciones as $klo => $observaciones) {
				$array['listaObservaciones'][$observaciones['idObservacion']] = $observaciones;
			}

			$rs_visitas = $this->model->obtener_data_visita_visibilidad_iniciativa($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idElementoVis']] = $row;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_visibilidadAuditoriaIniciativa",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_visibilidadAuditoriaAdicional($input=array()){
		$rs_detalle = $this->model->obtener_lista_visita_visibilidadAudAdicional($input);

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kl => $row) {
				$array['listaElementoVisibilidad'][$row['idElementoVis']] = $row;
			}

			$rs_visitas = $this->model->obtener_data_visita_visibilidad_adicional($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitas'][$row['idElementoVis']] = $row;
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_visibilidadAuditoriaAdicional",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}

	function obtener_visita_premio($input=array()){
		$rs_detalle = $this->model->detalle_visita_encuesta_premio();

		if ( !empty($rs_detalle) ) {
			$this->htmlButtons = 2;
			$array = array();
			$array['idVisita'] = $input['idVisita'];

			foreach ($rs_detalle as $kl => $row) {
				$array['listaEncuestasPremio'][$row['idEncuesta']]['idEncuesta'] = $row['idEncuesta'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['encuestaPremio'] = $row['encuestaPremio'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['descripcion'] = $row['descripcion'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['foto_obligatoria'] = $row['foto_obligatoria'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['idPreguntaTipo'] = $row['idPreguntaTipo'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['obligatoria'] = $row['obligatoria'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['listaEncuestasPremio'][$row['idEncuesta']]['listaPreguntas'][$row['idPregunta']]['listaAlternativas'][$row['idAlternativa']]['alternativa'] = $row['alternativa'];
			}

			$rs_visitas = $this->model->obtener_data_visita_encuesta_premio($input);
			foreach ($rs_visitas as $kv => $row) {
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['idEncuesta'] = $row['idEncuesta'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['idVisitaEncuesta'] = $row['idVisitaEncuesta'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['idVisitaFoto'] = $row['idVisitaFoto'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['foto'] = $row['foto'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['listaTipoPreguntas'][$row['idPreguntaTipo']]['idPreguntaTipo'] = $row['idPreguntaTipo'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['listaTipoPreguntas'][$row['idPreguntaTipo']]['listaPreguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['listaTipoPreguntas'][$row['idPreguntaTipo']]['listaPreguntas'][$row['idPregunta']]['listaRespuestas'][0] = $row['respuesta'];
				$array['listaVisitasEncuesta'][$row['idEncuesta']]['listaTipoPreguntas'][$row['idPreguntaTipo']]['listaPreguntas'][$row['idPregunta']]['listaRespuestas'][$row['respuesta']] = $row['respuesta'];
			}

			$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_encuestaPremio",$array, true);
		} else {
			$html = $this->htmlNoResultado;
		}

		return $html;
	}
	/*****************ACTUALIZAR HORARIOS*****************/
	public function actualizarHorarios(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'visita'};
		$horaInicio = $data->{'horaInicio'};
		$horaFin = $data->{'horaFin'};

		//ACTUALIZAR VISITA INCIDENCIA
		$arrayParams = array();
		if (!empty($horaInicio)) 
		{ 
			$arrayParams['horaIni'] = $horaInicio; 
			$arrayParams['porContingencia'] = true; 
			$arrayParams['idUsuarioContingencia'] = $this->idUsuario; 
		};
		
		if (!empty($horaFin)) 
		{ 
			$arrayParams['horaFin'] = $horaFin;
			$arrayParams['porContingencia'] = true; 
			$arrayParams['idUsuarioContingencia'] = $this->idUsuario; 
		};
		$arrayWhere = array('idVisita' => $idVisita);
		$arrayUpdateVisita['arrayParams'] = $arrayParams;
		$arrayUpdateVisita['arrayWhere'] = $arrayWhere;
		//
		$updateVisitaHorarios = $this->model->update_visita_visita($arrayUpdateVisita);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'ACTUALIZAR HORARIOS';
		$result['data']['html'] = $this->htmlResultado;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	/*****************GUARDAR VISITA MODULOS********************/
	public function guardarIncidencia(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$dataIncidencia = $data->{'dataIncidencia'};
		$dataIncidenciaFotos = $data->{'dataIncidenciaFotos'};

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if (!empty($dataIncidenciaFotos)) {
			$idVisita = (isset($dataIncidencia->{'idVisita'}) && !empty($dataIncidencia->{'idVisita'})) ? $dataIncidencia->{'idVisita'}: NULL;
			$idIncidencia = (isset($dataIncidencia->{'tipoIncidencia'}) && !empty($dataIncidencia->{'tipoIncidencia'})) ? $dataIncidencia->{'tipoIncidencia'}: NULL;
			$nombreIncidencia = (isset($dataIncidencia->{'nombreIncidencia'}) && !empty($dataIncidencia->{'nombreIncidencia'})) ? $dataIncidencia->{'nombreIncidencia'}: NULL;
			$observacion = (isset($dataIncidencia->{'comentarioIncidencia'}) && !empty($dataIncidencia->{'comentarioIncidencia'})) ? $dataIncidencia->{'comentarioIncidencia'}: NULL;
			$fotoUrl = isset($dataIncidenciaFotos[0]) ? $dataIncidenciaFotos[0]: NULL;

			$arrayInsertIncidencia = array(
				'idVisita' => $idVisita
				,'idIncidencia' => $idIncidencia
				,'observacion' => $observacion
				,'nombreIncidencia' => $nombreIncidencia
				,'hora' => date('H:i:s')
				,'fotoUrl' => $fotoUrl
			);
			$insertarVisitaIncidencia = $this->model->insert_visita_incidencia($arrayInsertIncidencia);
			$rowInsert++;

			$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'estadoIncidencia');
			$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);
			$result['result'] = 1;
		} else {
			$result['result'] = 0;
			$content .= $this->htmlNoResultado;
		}

		//Result
		$result['msg']['title'] = 'GUARDAR INCIDENCIA';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function actualizarIncidencia(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};

		//ACTUALIZAR VISITA INCIDENCIA
		$arrayParams = array('estado' => 0);
		$arrayWhere = array('idVisita' => $idVisita);
		$arrayUpdateIncidencia['arrayParams'] = $arrayParams;
		$arrayUpdateIncidencia['arrayWhere'] = $arrayWhere;
		//
		$updateVisitaIncidencia = $this->model->update_visita_incidencia($arrayUpdateIncidencia);

		//ACTUALIZAR VISITA ESTADO INCIDENCIA
		$arrayParams = array('estadoIncidencia' => NULL);
		$arrayWhere = array('idVisita' => $idVisita);
		$arrayUpdateIncidencia['arrayParams'] = $arrayParams;
		$arrayUpdateIncidencia['arrayWhere'] = $arrayWhere;
		//
		$updateVisitaIncidencia = $this->model->update_visita_visita($arrayUpdateIncidencia);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'ACTUALIZAR INCIDENCIA';
		$result['data']['html'] = $this->htmlResultado;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarEncuestas(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'visita'};
		$dataEncuestas = $data->{'dataEncuestas'};
		$dataEncuestaFoto = json_decode(json_encode($data->{'dataEncuestaFoto'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0; $content='';

		if (!empty($dataEncuestas)) {
			foreach ($dataEncuestas as $ke => $encuestas) {
				$idEncuesta = ( isset($encuestas->{'encuesta'}) && !empty($encuestas->{'encuesta'}) ) ? $encuestas->{'encuesta'} : NULL;
				$idVisitaEncuesta = ( isset($encuestas->{'visitaEncuesta'}) && !empty($encuestas->{'visitaEncuesta'}) ) ? $encuestas->{'visitaEncuesta'} : NULL;
				$fotoEncuesta = ( isset($encuestas->{'fotoEncuesta'}) && !empty($encuestas->{'fotoEncuesta'}) ) ? $encuestas->{'fotoEncuesta'} : NULL;
				$foto = ( isset($encuestas->{'foto'}) && !empty($encuestas->{'foto'}) ) ? $encuestas->{'foto'} : NULL;
				$listaPreguntas = ( isset($encuestas->{'dataEncuestasPreguntas'}) && !empty($encuestas->{'dataEncuestasPreguntas'}) ) ? $encuestas->{'dataEncuestasPreguntas'} : NULL;

				$numDet = count($listaPreguntas);
				$idVisitaFoto = NULL;

				//VERIFICACIÓN DE FOTOS
				if ( isset($dataEncuestaFoto[$idEncuesta]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataEncuestaFoto[$idEncuesta]
						,'hora' => date('H:i:s')
						,'idModulo' => 1
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
				}
				//

				//VERIFICAMOS LA CABECERA
				if ( empty($idVisitaEncuesta) ) {
					//INSERTAMOS LA CABECERA
					$arrayInsertEncuesta = array(
						'idVisita' => $idVisita
						,'idEncuesta' => $idEncuesta
						,'hora' => date('H:i:s')
						,'numDet' => $numDet
					);
					if ( !empty($idVisitaFoto)) $arrayInsertEncuesta['idVisitaFoto'] = $idVisitaFoto;

					$insertarVisitaEncuesta = $this->model->insertar_visita_encuesta($arrayInsertEncuesta);
					//VERIFICAMOS LA INFORMACIÓN CABECERA ALMACENADA
					if ( $insertarVisitaEncuesta) {
						$insertId = $this->db->insert_id();
						$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaSos");
						$rowInsert++;

						//VERIFICACIÓN DE LOS DETALLES
						if ( $numDet>0) {
							foreach ($listaPreguntas as $klp => $prAlternativas) {
								$idPregunta = ( isset($prAlternativas->{'pregunta'}) && !empty($prAlternativas->{'pregunta'}) ) ? $prAlternativas->{'pregunta'} : NULL;
								$idTipoPregunta = ( isset($prAlternativas->{'tipoPregunta'}) && !empty($prAlternativas->{'tipoPregunta'}) ) ? $prAlternativas->{'tipoPregunta'} : NULL;
								$alternativaFoto = ( isset($prAlternativas->{'alternativaFoto'}) && !empty($prAlternativas->{'alternativaFoto'}) ) ? $prAlternativas->{'alternativaFoto'} : NULL;
								$respuesta = ( isset($prAlternativas->{'respuesta'}) && !empty($prAlternativas->{'respuesta'}) ) ? $prAlternativas->{'respuesta'} : NULL;
								$idAlternativa = ( isset($prAlternativas->{'alternativa'}) && !empty($prAlternativas->{'alternativa'}) ) ? $prAlternativas->{'alternativa'} : NULL;
								$indexFoto = ( isset($prAlternativas->{'indexFoto'}) && !empty($prAlternativas->{'indexFoto'}) ) ? $prAlternativas->{'indexFoto'} : NULL;
								$idVisitaFoto = ( isset($prAlternativas->{'visitaFoto'}) && !empty($prAlternativas->{'visitaFoto'}) ) ? $prAlternativas->{'visitaFoto'} : NULL;

								//VERIFICACIÓN DE FOTOS
								if ( isset($dataEncuestaFoto[$idEncuesta.'-'.$idPregunta.'-'.$indexFoto]) ) {
									//
									$arrayInsertVisitaFoto = array(
										'idVisita' => $idVisita
										,'fotoUrl' => $dataEncuestaFoto[$idEncuesta.'-'.$idPregunta.'-'.$indexFoto]
										,'hora' => date('H:i:s')
										,'idModulo' => 1
									);

									$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
									if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
									else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
								}

								//INSERTAMOS EL DETALLE
								$arrayInsertEncuestaDetalle = array(
									'idVisitaEncuesta' => $insertId
									,'idPregunta' => $idPregunta
									,'idAlternativa' => $idAlternativa
									,'respuesta' => $respuesta
									,'idVisitaFoto' => $idVisitaFoto
								);

								$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayInsertEncuestaDetalle);
								$rowInsert++;
							}
						}
					}
				} else {
					//ACTUALIZAMOS LA CABECERA
					$arrayParams = array('numDet' => $numDet);
					if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
					$arrayWhere = array('idVisitaEncuesta' => $idVisitaEncuesta );

					$arrayUpdateEncuesta['arrayParams'] = $arrayParams;
					$arrayUpdateEncuesta['arrayWhere'] = $arrayWhere;

					$updateVisitaEncuesta = $this->model->update_visita_encuesta($arrayUpdateEncuesta);
					$rowUpdated++;

					//ACTUALIZAMOS LOS DETALLES
					if ($numDet>0) {
						//ACTUALIZAMOS LOS TIPOS 3
						$updateaVisitaEncuestaTipo3 = $this->model->update_visita_encuesta_detalle_tipoPregunta($idVisitaEncuesta);

						foreach ($listaPreguntas as $klp => $prAlternativas) {
							$idPregunta = ( isset($prAlternativas->{'pregunta'}) && !empty($prAlternativas->{'pregunta'}) ) ? $prAlternativas->{'pregunta'} : NULL;
							$idTipoPregunta = ( isset($prAlternativas->{'tipoPregunta'}) && !empty($prAlternativas->{'tipoPregunta'}) ) ? $prAlternativas->{'tipoPregunta'} : NULL;
							$alternativaFoto = ( isset($prAlternativas->{'alternativaFoto'}) && !empty($prAlternativas->{'alternativaFoto'}) ) ? $prAlternativas->{'alternativaFoto'} : NULL;
							$respuesta = ( isset($prAlternativas->{'respuesta'}) && !empty($prAlternativas->{'respuesta'}) ) ? $prAlternativas->{'respuesta'} : NULL;
							$idAlternativa = ( isset($prAlternativas->{'alternativa'}) && !empty($prAlternativas->{'alternativa'}) ) ? $prAlternativas->{'alternativa'} : NULL;
							$indexFoto = ( isset($prAlternativas->{'indexFoto'}) && !empty($prAlternativas->{'indexFoto'}) ) ? $prAlternativas->{'indexFoto'} : NULL;
							$idVisitaFoto = ( isset($prAlternativas->{'visitaFoto'}) && !empty($prAlternativas->{'visitaFoto'}) ) ? $prAlternativas->{'visitaFoto'} : NULL;

							//VERIFICACIÓN DE FOTOS
							if ( isset($dataEncuestaFoto[$idEncuesta.'-'.$idPregunta.'-'.$indexFoto]) ) {
								//
								$arrayInsertVisitaFoto = array(
									'idVisita' => $idVisita
									,'fotoUrl' => $dataEncuestaFoto[$idEncuesta.'-'.$idPregunta.'-'.$indexFoto]
									,'hora' => date('H:i:s')
									,'idModulo' => 1
								);

								$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
								if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
								else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
							}

							//TIPO DE PREGUNTA
							if ( $idTipoPregunta==3) {
								//INSERTAMOS EL DETALLE
									$arrayInsertEncuestaDetalle = array(
										'idVisitaEncuesta' => $idVisitaEncuesta
										,'idPregunta' => $idPregunta
										,'idAlternativa' => $idAlternativa
										,'respuesta' => $respuesta
										,'idVisitaFoto' => $idVisitaFoto
									);
									$insertVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayInsertEncuestaDetalle);
									$rowInsert++;
							} else {
								//BUSCAMOS EL DETALLE
								$arrayBusquedaEncuestaDetalle = array(
									'idVisitaEncuesta' => $idVisitaEncuesta
									,'idPregunta' => $idPregunta
								);
								$selectVisitaEncuestaDetalle = $this->model->select_visita_encuesta_detalle($arrayBusquedaEncuestaDetalle);

								if ( empty($selectVisitaEncuestaDetalle)) {
									//INSERTAMOS EL DETALLE
									$arrayInsertEncuestaDetalle = array(
										'idVisitaEncuesta' => $idVisitaEncuesta
										,'idPregunta' => $idPregunta
										,'idAlternativa' => $idAlternativa
										,'respuesta' => $respuesta
										,'idVisitaFoto' => $idVisitaFoto
									);
									$insertVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayInsertEncuestaDetalle);
									$rowInsert++;
								} else{
									$idVisitaEncuestaDet = $selectVisitaEncuestaDetalle[0]['idVisitaEncuestaDet'];

									$arrayParams = array(
										'idAlternativa' => $idAlternativa
										,'respuesta' => $respuesta
									);
									if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
									$arrayWhere = array('idVisitaEncuestaDet' => $idVisitaEncuestaDet);

									$arrayUpdateEncuestaDetalle['arrayParams'] = $arrayParams;
									$arrayUpdateEncuestaDetalle['arrayWhere'] = $arrayWhere;
									//
									$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle($arrayUpdateEncuestaDetalle);
									$rowUpdated++;
								}
							}
						}
					}
				}

			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'encuesta');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR SOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarEncuestas_delete(){
		$result = $this->result;
		$datosGenerales = json_decode($this->input->post('data'));

		$data = $datosGenerales->{'data'};
		//$dataFotosEncuesta = $datosGenerales->{'dataFotosEncuesta'};
		$dataFotosEncuesta = json_decode(json_encode($datosGenerales->{'dataFotosEncuesta'}), true);

		$idVisita = $data->{'idVisita'};
		$idEncuesta = $data->{'idEncuesta'};
		$idVisitaEncuesta = $data->{'idVisitaEncuesta'};
		$idVisitaFoto = NULL;

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';
		
		if ( isset($idVisitaEncuesta) ) {
			if (is_array($idVisitaEncuesta)){
				foreach ($idVisitaEncuesta as $kve => $idVisEnc) {
					if ( empty($idVisEnc)) {

						$idVisitaFoto = NULL;
						//VERIFICACIÓN DE FOTOS
						if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve]]) ) {
							//
							$arrayInsertVisitaFoto = array(
								'idVisita' => $idVisita
								,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve]]
								,'hora' => date('H:i:s')
								,'idModulo' => 1
							);

							$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
							if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
							else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
						}

						//INSERT ENCUESTA CABECERA
						$arrayVisitaEncuesta = array(
							'idVisita' => $idVisita
							, 'idEncuesta' => $idEncuesta[$kve]
							, 'hora' => date('H:i:s')
							,'idVisitaFoto' => $idVisitaFoto
						);

						$insertarVisitaEncuesta = $this->model->insertar_visita_encuesta($arrayVisitaEncuesta);

						if ( $insertarVisitaEncuesta ) {
							//VISITA ENCUESTA DETALLE
							$insertId = $this->db->insert_id();
							$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaEncuesta");
							$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> NO SE LOGRO INGRESAR LA ENCUESTA '.$idEncuesta[$kve].'.</div>';

							//PREGUNTAS TIPO 01
							if ( isset( $data->{'pregunta-tp1-'.$idEncuesta[$kve]} )) {
								$preguntasTipo1 = $data->{'pregunta-tp1-'.$idEncuesta[$kve]};
								
								for ($ixtp1=0; $ixtp1 < count($preguntasTipo1); $ixtp1++) {

									$ixtp1++;
									$idPregunta =  $preguntasTipo1[$ixtp1]; 
									$ixtp1++;
									$respuesta =  $preguntasTipo1[$ixtp1];
									
									//VERIFICACIÓN DE FOTOS
									if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$idPregunta]) ) {
										//
										$arrayInsertVisitaFoto = array(
											'idVisita' => $idVisita
											,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$idPregunta]
											,'hora' => date('H:i:s')
											,'idModulo' => 1
										);

										$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
										if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
										else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
									}

									$arrayVisitaEncuestaDetalleTipo1 = array(
										'idVisitaEncuesta' => $insertId
										,'idPregunta' => $idPregunta
										,'respuesta' => $respuesta
									);
									if ( !empty($idVisitaFoto)) $arrayVisitaEncuestaDetalleTipo1['idVisitaFoto'] = $idVisitaFoto;

									$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo1);
								}
							}
							//PREGUNTAS TIPO 02
							if ( isset( $data->{'pregunta-tp2-'.$idEncuesta[$kve]})) {
								$preguntasTipo2 = $data->{'pregunta-tp2-'.$idEncuesta[$kve]};

								if ( is_array($preguntasTipo2) ) {
									foreach ($preguntasTipo2 as $kvep => $pregunta) {
										if ( isset( $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$pregunta} ) ) {
											$alternativa = $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$pregunta};

											//VERIFICACIÓN DE FOTOS
											if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]) ) {
												//
												$arrayInsertVisitaFoto = array(
													'idVisita' => $idVisita
													,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]
													,'hora' => date('H:i:s')
													,'idModulo' => 1
												);

												$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
												if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
												else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
											}

											$arrayVisitaEncuestaDetalleTipo2 = array(
												'idVisitaEncuesta' => $insertId
												,'idPregunta' => $pregunta
												,'idAlternativa' => $alternativa
											);
											if ( !empty($idVisitaFoto)) $arrayVisitaEncuestaDetalleTipo2['idVisitaFoto'] = $idVisitaFoto;
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo2);
										}
									}
								} else {
									if (isset( $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$preguntasTipo2} ) ){
										$alternativa = $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$preguntasTipo2};

										$arrayVisitaEncuestaDetalleTipo2 = array(
											'idVisitaEncuesta' => $insertId
											,'idPregunta' => $preguntasTipo2
											,'idAlternativa' => $alternativa
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo2);
									}
								}
							}
							//PREGUNTAS TIPO 03
							if ( isset( $data->{'pregunta-tp3-'.$idEncuesta[$kve]}) ) {
								$preguntasTipo3 = $data->{'pregunta-tp3-'.$idEncuesta[$kve]};

								if ( is_array($preguntasTipo3) ) {
									foreach ($preguntasTipo3 as $kvep => $pregunta) {
										if ( isset( $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$pregunta} )) {
											$alternativas = $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$pregunta};

											//VERIFICACIÓN DE FOTOS
											if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]) ) {
												//
												$arrayInsertVisitaFoto = array(
													'idVisita' => $idVisita
													,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]
													,'hora' => date('H:i:s')
													,'idModulo' => 1
												);

												$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
												if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
												else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
											}

											if ( is_array($alternativas) ) {
												foreach ($alternativas as $kvepa => $idAlternativa) {
													$arrayVisitaEncuestaDetalleTipo3 = array(
														'idVisitaEncuesta' => $insertId
														,'idPregunta' => $pregunta
														,'idAlternativa' => $idAlternativa
													);
													if ( !empty($idVisitaFoto)) $arrayVisitaEncuestaDetalleTipo3['idVisitaFoto'] = $idVisitaFoto;
													$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
												}
											} else {
												$arrayVisitaEncuestaDetalleTipo3 = array(
													'idVisitaEncuesta' => $insertId
													,'idPregunta' => $pregunta
													,'idAlternativa' => $alternativas
												);
												if ( !empty($idVisitaFoto)) $arrayVisitaEncuestaDetalleTipo3['idVisitaFoto'] = $idVisitaFoto;
												$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
											}
										}
									}
								} else {
									if ( isset( $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$preguntasTipo3} )) {
										$alternativas = $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$preguntasTipo3};

										//VERIFICACIÓN DE FOTOS
										if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$preguntasTipo3]) ) {
											//
											$arrayInsertVisitaFoto = array(
												'idVisita' => $idVisita
												,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$preguntasTipo3]
												,'hora' => date('H:i:s')
												,'idModulo' => 1
											);

											$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
											if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
											else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
										}

										if ( is_array($alternativas) ) {
											foreach ($alternativas as $kvepa => $idAlternativa) {
												$arrayVisitaEncuestaDetalleTipo3 = array(
													'idVisitaEncuesta' => $insertId
													,'idPregunta' => $preguntasTipo3
													,'idAlternativa' => $idAlternativa
												);
												if ( !empty($idVisitaFoto)) $arrayVisitaEncuestaDetalleTipo3['idVisitaFoto'] = $idVisitaFoto;
												$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
											}
										} else {
											$arrayVisitaEncuestaDetalleTipo3 = array(
												'idVisitaEncuesta' => $insertId
												,'idPregunta' => $preguntasTipo3
												,'idAlternativa' => $alternativas
											);
											if ( !empty($idVisitaFoto)) $arrayVisitaEncuestaDetalleTipo3['idVisitaFoto'] = $idVisitaFoto;
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
										}
									}
								}
							}
						} else {
							$content .= '<div class="alert alert-warning" role="alert"><i class="fas fa-info-circle"></i> NO SE LOGRO INGRESAR LA ENCUESTA '.$idEncuesta[$kve].'.</div>';
						}
					} else {
						//VERIFICACIÓN DE FOTOS
						if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve]]) ) {
							//
							$arrayInsertVisitaFoto = array(
								'idVisita' => $idVisita
								,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve]]
								,'hora' => date('H:i:s')
								,'idModulo' => 1
							);

							$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
							if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
							else { $idVisitaFoto = NULL; $rowInsertFotoError++; }

							//UPDATE CABECERA DE ENCUESTA
							$arrayParams = array(
								'idVisitaFoto' => $idVisitaFoto
							);
							$arrayWhere = array(
								'idVisitaEncuesta' => $idVisitaEncuesta
							);
							$arrayUpdateEncuesta['arrayParams'] = $arrayParams;
							$arrayUpdateEncuesta['arrayWhere'] = $arrayWhere;
							//
							$updateVisitaEncuesta = $this->model->update_visita_encuesta($arrayUpdateEncuesta);
						}

						//UPDATE
						$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> SE LOGRÓ ACTUALIZAR LA ENCUESTA '.$idEncuesta[$kve].'.</div>';
						//PREGUNTAS TIPO 01
						if ( isset( $data->{'pregunta-tp1-'.$idEncuesta[$kve]} )) {
							$preguntasTipo1 = $data->{'pregunta-tp1-'.$idEncuesta[$kve]};
							
							for ($ixtp1=0; $ixtp1 < count($preguntasTipo1); $ixtp1++) {

								$idVisitaEncuestaDet = $preguntasTipo1[$ixtp1]; $ixtp1++;
								$idPregunta = $preguntasTipo1[$ixtp1]; 	$ixtp1++;
								$respuesta = $preguntasTipo1[$ixtp1];

								//VERIFICACIÓN DE FOTOS
								if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$idPregunta]) ) {
									//
									$arrayInsertVisitaFoto = array(
										'idVisita' => $idVisita
										,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$idPregunta]
										,'hora' => date('H:i:s')
										,'idModulo' => 1
									);

									$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
									if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
									else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
								}

								//UPDATE CABECERA DE ENCUESTA
								$arrayParams = array(
									'respuesta' => $respuesta
								);
								if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
								$arrayWhere = array(
									'idVisitaEncuestaDet' => $idVisitaEncuestaDet
								);
								$arrayUpdateEncuestaDetalle['arrayParams'] = $arrayParams;
								$arrayUpdateEncuestaDetalle['arrayWhere'] = $arrayWhere;
								//
								$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v2($arrayUpdateEncuestaDetalle);
							}
						}
						//PREGUNTAS TIPO 02
						if ( isset( $data->{'pregunta-tp2-'.$idEncuesta[$kve]})) {
							$preguntasTipo2 = $data->{'pregunta-tp2-'.$idEncuesta[$kve]};

							if ( is_array($preguntasTipo2) ) {
								foreach ($preguntasTipo2 as $kvep => $pregunta) {
									if ( isset( $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$pregunta} ) ) {
										$idVisitaEncuestaDet = $data->{'pregunta-tp2-'.$idEncuesta[$kve].'-idVisita'}[$kvep];
										$alternativa = $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$pregunta};

										//VERIFICACIÓN DE FOTOS
										if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]) ) {
											//
											$arrayInsertVisitaFoto = array(
												'idVisita' => $idVisita
												,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]
												,'hora' => date('H:i:s')
												,'idModulo' => 1
											);

											$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
											if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
											else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
										}

										//UPDATE CABECERA DE ENCUESTA
										$arrayParams = array(
											'idAlternativa' => $alternativa
										);
										if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
										$arrayWhere = array(
											'idVisitaEncuestaDet' => $idVisitaEncuestaDet
										);
										$arrayUpdateEncuestaDetalle['arrayParams'] = $arrayParams;
										$arrayUpdateEncuestaDetalle['arrayWhere'] = $arrayWhere;
										//
										$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v2($arrayUpdateEncuestaDetalle);
									}
								}
							} else {
								if (isset( $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$preguntasTipo2} ) ){
									$idVisitaEncuestaDet = $data->{'pregunta-tp2-'.$idEncuesta[$kve].'-idVisita'};
									$alternativa = $data->{'alternativa-tp2-'.$idEncuesta[$kve].'-'.$preguntasTipo2};

									//VERIFICACIÓN DE FOTOS
									if ( isset($dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]) ) {
										//
										$arrayInsertVisitaFoto = array(
											'idVisita' => $idVisita
											,'fotoUrl' => $dataFotosEncuesta["ECS-".$idEncuesta[$kve].'-PG-'.$pregunta]
											,'hora' => date('H:i:s')
											,'idModulo' => 1
										);

										$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
										if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
										else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
									}

									//UPDATE CABECERA DE ENCUESTA
									$arrayParams = array(
										'idAlternativa' => $alternativa
									);
									if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
									$arrayWhere = array(
										'idVisitaEncuestaDet' => $idVisitaEncuestaDet
									);
									$arrayUpdateEncuestaDetalle['arrayParams'] = $arrayParams;
									$arrayUpdateEncuestaDetalle['arrayWhere'] = $arrayWhere;
									//
									$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v2($arrayUpdateEncuestaDetalle);
								}
							}
						}
						//PREGUNTAS TIPO 03
						if ( isset( $data->{'pregunta-tp3-'.$idEncuesta[$kve]}) ) {
							$idVisitaEnc = $idVisitaEncuesta[$kve];
							$preguntasTipo3 = $data->{'pregunta-tp3-'.$idEncuesta[$kve]};

							if ( is_array($preguntasTipo3) ) {
								foreach ($preguntasTipo3 as $kvep => $pregunta) {
									//CAMBIAR ESTADO A LOS EXISTENTES
									$arrayUpdateVisitaEncuestaDetalleTipo3 = array(
										'idVisitaEncuesta' => $idVisitaEnc
										,'idPregunta' => $pregunta
									);
									$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v1($arrayUpdateVisitaEncuestaDetalleTipo3);

									if ( isset( $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$pregunta} )) {
										$alternativas = $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$pregunta};

										//REGISTRAR A LOS NUEVOS INGRESOS
										if ( is_array($alternativas) ) {
											foreach ($alternativas as $kvepa => $idAlternativa) {
												$arrayVisitaEncuestaDetalleTipo3 = array(
													'idVisitaEncuesta' => $idVisitaEnc
													,'idPregunta' => $pregunta
													,'idAlternativa' => $idAlternativa
												);
												$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
											}
										} else {
											$arrayVisitaEncuestaDetalleTipo3 = array(
												'idVisitaEncuesta' => $idVisitaEnc
												,'idPregunta' => $pregunta
												,'idAlternativa' => $alternativas
											);
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
										}
									}
								}
							} else {
								//CAMBIAR ESTADO A LOS EXISTENTES
								$arrayUpdateVisitaEncuestaDetalleTipo3 = array(
									'idVisitaEncuesta' => $idVisitaEnc
									,'idPregunta' => $preguntasTipo3
								);
								$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v1($arrayUpdateVisitaEncuestaDetalleTipo3);

								if ( isset( $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$preguntasTipo3} )) {
									$alternativas = $data->{'alternativa-tp3-'.$idEncuesta[$kve].'-'.$preguntasTipo3};

									//REGISTRAR A LOS NUEVOS INGRESOS
									if ( is_array($alternativas) ) {
										foreach ($alternativas as $kvepa => $idAlternativa) {
											$arrayVisitaEncuestaDetalleTipo3 = array(
												'idVisitaEncuesta' => $idVisitaEnc
												,'idPregunta' => $preguntasTipo3
												,'idAlternativa' => $idAlternativa
											);
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
										}
									} else {
										$arrayVisitaEncuestaDetalleTipo3 = array(
											'idVisitaEncuesta' => $idVisitaEnc
											,'idPregunta' => $preguntasTipo3
											,'idAlternativa' => $alternativas
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
									}
								}
							}
						}
					}
				}
			} else {
				//IDVISITAENCUESTA NO ES ARRAY
				if ( empty($idVisitaEncuesta) ) {
					//NO EXISTE EL VALOR GUARDADO
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataFotosEncuesta['ECS-'.$idEncuesta]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataFotosEncuesta['ECS-'.$idEncuesta]
							,'hora' => date('H:i:s')
							,'idModulo' => 1
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}
					//INSERT
					$arrayVisitaEncuesta = array(
						'idVisita' => $idVisita
						, 'idEncuesta' => $idEncuesta
						, 'hora' => date('H:i:s')
						,'idVisitaFoto' => $idVisitaFoto
					);

					$insertarVisitaEncuesta = $this->model->insertar_visita_encuesta($arrayVisitaEncuesta);

					if ( $insertarVisitaEncuesta ) {
						//VISITA ENCUESTA DETALLE
						$insertId = $this->db->insert_id();
						$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaEncuesta");
						$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle "></i> SE LOGRO INGRESAR LA ENCUESTA '.$idEncuesta.' CORRECTAMENTE.</div>';
						//PREGUNTAS TIPO 01
						if ( isset( $data->{'pregunta-tp1-'.$idEncuesta} )) {
							$preguntasTipo1 = $data->{'pregunta-tp1-'.$idEncuesta};
							
							for ($ixtp1=0; $ixtp1 < count($preguntasTipo1); $ixtp1++) {

								$ixtp1++;
								$idPregunta =  $preguntasTipo1[$ixtp1]; 
								$ixtp1++;
								$respuesta =  $preguntasTipo1[$ixtp1];
								
								$arrayVisitaEncuestaDetalleTipo1 = array(
									'idVisitaEncuesta' => $insertId
									,'idPregunta' => $idPregunta
									,'respuesta' => $respuesta
								);
								$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo1);
							}
						}
						//PREGUNTAS TIPO 02
						if ( isset( $data->{'pregunta-tp2-'.$idEncuesta})) {
							$preguntasTipo2 = $data->{'pregunta-tp2-'.$idEncuesta};

							if ( is_array($preguntasTipo2) ) {
								foreach ($preguntasTipo2 as $kvep => $pregunta) {
									if ( isset( $data->{'alternativa-tp2-'.$idEncuesta.'-'.$pregunta} ) ) {
										$alternativa = $data->{'alternativa-tp2-'.$idEncuesta.'-'.$pregunta};

										$arrayVisitaEncuestaDetalleTipo2 = array(
											'idVisitaEncuesta' => $insertId
											,'idPregunta' => $pregunta
											,'idAlternativa' => $alternativa
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo2);
									}
								}
							} else {
								if (isset( $data->{'alternativa-tp2-'.$idEncuesta.'-'.$preguntasTipo2} ) ){
									$alternativa = $data->{'alternativa-tp2-'.$idEncuesta.'-'.$preguntasTipo2};

									$arrayVisitaEncuestaDetalleTipo2 = array(
										'idVisitaEncuesta' => $insertId
										,'idPregunta' => $preguntasTipo2
										,'idAlternativa' => $alternativa
									);
									$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo2);
								}
							}
						}
						//PREGUNTAS TIPO 03
						if ( isset( $data->{'pregunta-tp3-'.$idEncuesta}) ) {
							$preguntasTipo3 = $data->{'pregunta-tp3-'.$idEncuesta};

							if ( is_array($preguntasTipo3) ) {
								foreach ($preguntasTipo3 as $kvep => $pregunta) {
									if ( isset( $data->{'alternativa-tp3-'.$idEncuesta.'-'.$pregunta} )) {
										$alternativas = $data->{'alternativa-tp3-'.$idEncuesta.'-'.$pregunta};

										if ( is_array($alternativas) ) {
											foreach ($alternativas as $kvepa => $idAlternativa) {
												$arrayVisitaEncuestaDetalleTipo3 = array(
													'idVisitaEncuesta' => $insertId
													,'idPregunta' => $pregunta
													,'idAlternativa' => $idAlternativa
												);
												$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
											}
										} else {
											$arrayVisitaEncuestaDetalleTipo3 = array(
												'idVisitaEncuesta' => $insertId
												,'idPregunta' => $pregunta
												,'idAlternativa' => $alternativas
											);
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
										}
									}
								}
							} else {
								if ( isset( $data->{'alternativa-tp3-'.$idEncuesta.'-'.$preguntasTipo3} )) {
									$alternativas = $data->{'alternativa-tp3-'.$idEncuesta.'-'.$preguntasTipo3};

									if ( is_array($alternativas) ) {
										foreach ($alternativas as $kvepa => $idAlternativa) {
											$arrayVisitaEncuestaDetalleTipo3 = array(
												'idVisitaEncuesta' => $insertId
												,'idPregunta' => $preguntasTipo3
												,'idAlternativa' => $idAlternativa
											);
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
										}
									} else {
										$arrayVisitaEncuestaDetalleTipo3 = array(
											'idVisitaEncuesta' => $insertId
											,'idPregunta' => $preguntasTipo3
											,'idAlternativa' => $alternativas
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
									}
								}
							}
						}
					} else {
						$content .= '<div class="alert alert-warning" role="alert"><i class="fas fa-info-circle"></i> NO SE LOGRO INGRESAR LA ENCUESTA '.$idEncuesta.'.</div>';
					}
				} else {
					//UPDATE VISITA ENCUESTA
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataFotosEncuesta['ECS-'.$idEncuesta]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataFotosEncuesta['ECS-'.$idEncuesta]
							,'hora' => date('H:i:s')
							,'idModulo' => 1
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }

						//UPDATE CABECERA DE ENCUESTA
						$arrayParams = array(
							'idVisitaFoto' => $idVisitaFoto
						);
						$arrayWhere = array(
							'idVisitaEncuesta' => $idVisitaEncuesta
						);
						$arrayUpdateEncuesta['arrayParams'] = $arrayParams;
						$arrayUpdateEncuesta['arrayWhere'] = $arrayWhere;
						//
						$updateVisitaEncuesta = $this->model->update_visita_encuesta($arrayUpdateEncuesta);
					}

					//UPDATE VISITA ENCUESTA DETALLE
					$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> SE LOGRO ACTUALIZAR LA ENCUESTA '.$idEncuesta.' CORRECTAMENTE.</div>';
					//PREGUNTAS TIPO 01
					if ( isset( $data->{'pregunta-tp1-'.$idEncuesta} )) {
						$preguntasTipo1 = $data->{'pregunta-tp1-'.$idEncuesta};
						
						for ($ixtp1=0; $ixtp1 < count($preguntasTipo1); $ixtp1++) {

							$idVisitaEncuestaDet = $preguntasTipo1[$ixtp1]; $ixtp1++;
							$idPregunta = $preguntasTipo1[$ixtp1]; 	$ixtp1++;
							$respuesta = $preguntasTipo1[$ixtp1];

							$arrayUpdateVisitaEncuestaDetalleTipo1 = array(
								'columnaWhere' => 'idVisitaEncuestaDet'
								,'idVisitaEncuestaDet' => $idVisitaEncuestaDet
								,'columnaParams' => 'respuesta'
								,'valorParams' => $respuesta
							);
							$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle($arrayUpdateVisitaEncuestaDetalleTipo1);
						}
					}
					//PREGUNTAS TIPO 02
					if ( isset( $data->{'pregunta-tp2-'.$idEncuesta})) {
						$preguntasTipo2 = $data->{'pregunta-tp2-'.$idEncuesta};

						if ( is_array($preguntasTipo2) ) {
							foreach ($preguntasTipo2 as $kvep => $pregunta) {
								if ( isset( $data->{'alternativa-tp2-'.$idEncuesta.'-'.$pregunta} ) ) {
									$idVisitaEncuestaDet = $data->{'pregunta-tp2-'.$idEncuesta.'-idVisita'}[$kvep];
									$alternativa = $data->{'alternativa-tp2-'.$idEncuesta.'-'.$pregunta};

									if ( !empty($idVisitaEncuestaDet)) {
										$arrayUpdateVisitaEncuestaDetalleTipo2 = array(
											'columnaWhere' => 'idVisitaEncuestaDet'
											,'idVisitaEncuestaDet' => $idVisitaEncuestaDet
											,'columnaParams' => 'idAlternativa'
											,'valorParams' => $alternativa
										);
										$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle($arrayUpdateVisitaEncuestaDetalleTipo2);
									} else {
										$arrayVisitaEncuestaDetalleTipo2 = array(
											'idVisitaEncuesta' => $idVisitaEncuesta
											,'idPregunta' => $pregunta
											,'idAlternativa' => $alternativa
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo2);
									}
								}
							}
						} else {
							if (isset( $data->{'alternativa-tp2-'.$idEncuesta.'-'.$preguntasTipo2} ) ){
								$idVisitaEncuestaDet = $data->{'pregunta-tp2-'.$idEncuesta.'-idVisita'};
								$alternativa = $data->{'alternativa-tp2-'.$idEncuesta.'-'.$preguntasTipo2};

								if ( !empty($idVisitaEncuestaDet)) {
									$arrayUpdateVisitaEncuestaDetalleTipo2 = array(
										'columnaWhere' => 'idVisitaEncuestaDet'
										,'idVisitaEncuestaDet' => $idVisitaEncuestaDet
										,'columnaParams' => 'idAlternativa'
										,'valorParams' => $alternativa
									);
									$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle($arrayUpdateVisitaEncuestaDetalleTipo2);
								} else {
									$arrayVisitaEncuestaDetalleTipo2 = array(
										'idVisitaEncuesta' => $idVisitaEncuesta
										,'idPregunta' => $preguntasTipo2
										,'idAlternativa' => $alternativa
									);
									$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo2);
								}
							}
						}
					}
					//PREGUNTAS TIPO 03
					if ( isset( $data->{'pregunta-tp3-'.$idEncuesta}) ) {
						$idVisitaEnc = $idVisitaEncuesta;
						$preguntasTipo3 = $data->{'pregunta-tp3-'.$idEncuesta};

						if ( is_array($preguntasTipo3) ) {
							foreach ($preguntasTipo3 as $kvep => $pregunta) {
								//CAMBIAR ESTADO A LOS EXISTENTES
								$arrayUpdateVisitaEncuestaDetalleTipo3 = array(
									'idVisitaEncuesta' => $idVisitaEnc
									,'idPregunta' => $pregunta
								);
								$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v1($arrayUpdateVisitaEncuestaDetalleTipo3);

								if ( isset( $data->{'alternativa-tp3-'.$idEncuesta.'-'.$pregunta} )) {
									$alternativas = $data->{'alternativa-tp3-'.$idEncuesta.'-'.$pregunta};
									//REGISTRAR A LOS NUEVOS INGRESOS
									if ( is_array($alternativas) ) {
										foreach ($alternativas as $kvepa => $idAlternativa) {
											$arrayVisitaEncuestaDetalleTipo3 = array(
												'idVisitaEncuesta' => $idVisitaEnc
												,'idPregunta' => $pregunta
												,'idAlternativa' => $idAlternativa
											);
											$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
										}
									} else {
										$arrayVisitaEncuestaDetalleTipo3 = array(
											'idVisitaEncuesta' => $idVisitaEnc
											,'idPregunta' => $pregunta
											,'idAlternativa' => $alternativas
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
									}
								}
							}
						} else {
							//CAMBIAR ESTADO A LOS EXISTENTES
							$arrayUpdateVisitaEncuestaDetalleTipo3 = array(
								'idVisitaEncuesta' => $idVisitaEnc
								,'idPregunta' => $preguntasTipo3
							);
							$updateVisitaEncuestaDetalle = $this->model->update_visita_encuesta_detalle_v1($arrayUpdateVisitaEncuestaDetalleTipo3);

							if ( isset( $data->{'alternativa-tp3-'.$idEncuesta.'-'.$preguntasTipo3} )) {
								$alternativas = $data->{'alternativa-tp3-'.$idEncuesta.'-'.$preguntasTipo3};

								//REGISTRAR A LOS NUEVOS INGRESOS
								if ( is_array($alternativas) ) {
									foreach ($alternativas as $kvepa => $idAlternativa) {
										$arrayVisitaEncuestaDetalleTipo3 = array(
											'idVisitaEncuesta' => $idVisitaEnc
											,'idPregunta' => $preguntasTipo3
											,'idAlternativa' => $idAlternativa
										);
										$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
									}
								} else {
									$arrayVisitaEncuestaDetalleTipo3 = array(
										'idVisitaEncuesta' => $idVisitaEnc
										,'idPregunta' => $preguntasTipo3
										,'idAlternativa' => $alternativas
									);
									$insertarVisitaEncuestaDetalle = $this->model->insertar_visita_encuesta_detalle($arrayVisitaEncuestaDetalleTipo3);
								}
							}
						}
					}	
				}
			}

			$this->model->update_visita_modulo($idVisita,'encuesta');
		} else {
			$content .= $this->htmlNoResultado;
		}

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR ENCUESTAS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarIpp(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataIpps = (array)$data->{'dataIpp'};
		$dataIppFoto = json_decode(json_encode($data->{'dataIppFoto'}), true);
		$arrayIpps = array();
		$arrayIppsPuntaje = array();
		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataIpps) ) {
			$arrayUpdateVisitaIppTipo3 = $this->model->update_visita_ipp_detalle_tipoPregunta($idVisita);

			//UPDATE ALTERNATIVAS Y PUNTAJES
			foreach ($dataIpps as $kli => $ipp) {
				$idIpp = $ipp->{'ipp'};
				$idTipoPregunta = $ipp->{'tipoPregunta'};
				$idPregunta = $ipp->{'pregunta'};
				$idAlternativa = $ipp->{'alternativa'};
				$puntaje = !empty($ipp->{'puntaje'}) ? $ipp->{'puntaje'} : NULL;

				$idVisitaIpp = $ipp->{'visitaIpp'};
				$idVisitaIppDet = $ipp->{'visitaIppDet'};

				$idVisitaFoto = NULL;

				if ( $idTipoPregunta==2) {
					if ( !empty($idVisitaIpp) ) {
						$arrayBusquedaIppDet = array(
							'idVisitaIpp' => $idVisitaIpp
							,'idPregunta' => $idPregunta
						);
						$selectVisitaIppDet = $this->model->select_visita_ipp_det($arrayBusquedaIppDet);

						if ( empty($selectVisitaIppDet) ) {
							$arrayInsertIppDetalle = array(
								'idVisitaIpp' => $idVisitaIpp
								,'idPregunta' => $idPregunta
								,'idAlternativa' => $idAlternativa
								,'puntaje' => $puntaje
							);
							$insertVisitaIppDetalle = $this->model->insert_visita_ipp_detalle($arrayInsertIppDetalle);

						} elseif ( !empty( $idAlternativa )) {
							$arrayParams = array(
								'idAlternativa' => $idAlternativa
								,'puntaje' => $puntaje
							);
							$arrayWhere = array(
								'idVisitaIpp' => $idVisitaIpp
								,'idPregunta' => $idPregunta
							);
							$arrayUpdateIppDet['arrayParams'] = $arrayParams;
							$arrayUpdateIppDet['arrayWhere'] = $arrayWhere;

							$updateVisitaIppDetalle = $this->model->update_visita_ipp_detalle($arrayUpdateIppDet);
							$rowUpdated++;
						}
						
					} else {
						$arrayBusquedaIpp = array(
							'idVisita' => $idVisita
							,'idIpp' => $idIpp
						);

						$selectVisitaIpp = $this->model->select_visita_ipp($arrayBusquedaIpp);
						
						if ( empty($selectVisitaIpp) ) {
							$arrayInsertIpp = array(
								'idVisita' => $idVisita
								,'idIpp' => $idIpp
								,'hora' => date('H:i:s')
							);

							$insertarVisitaIpp = $this->model->insert_visita_ipp($arrayInsertIpp);

							if ( $insertarVisitaIpp) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaIpp");
								$rowInsert++;

								$arrayInsertIppDetalle = array(
									'idVisitaIpp' => $insertId
									,'idPregunta' => $idPregunta
									,'idAlternativa' => $idAlternativa
									,'puntaje' => $puntaje
								);
								$insertVisitaIppDetalle = $this->model->insert_visita_ipp_detalle($arrayInsertIppDetalle);
								$rowInsert++;
							}
						} else {
							$idVisitaIpp = $selectVisitaIpp[0]['idVisitaIpp'];

							$arrayInsertIppDetalle = array(
								'idVisitaIpp' => $idVisitaIpp
								,'idPregunta' => $idPregunta
								,'idAlternativa' => $idAlternativa
								,'puntaje' => $puntaje
							);
							$insertVisitaIppDetalle = $this->model->insert_visita_ipp_detalle($arrayInsertIppDetalle);
							$rowInsert++;
						}
					}
				} elseif ( $idTipoPregunta==3 ) {
					if ( !empty($idVisitaIpp) ) {
						$arrayInsertIppDetalle = array(
							'idVisitaIpp' => $idVisitaIpp
							,'idPregunta' => $idPregunta
							,'idAlternativa' => $idAlternativa
							,'puntaje' => $puntaje
						);
						$insertVisitaIppDetalle = $this->model->insert_visita_ipp_detalle($arrayInsertIppDetalle);
						$rowInsert++;
					} else {
						$arrayBusquedaIpp = array(
							'idVisita' => $idVisita
							,'idIpp' => $idIpp
						);
						$selectVisitaIpp = $this->model->select_visita_ipp($arrayBusquedaIpp);
						$rowInsert++;

						if ( empty($selectVisitaIpp) ) {
							$arrayInsertIpp = array(
								'idVisita' => $idVisita
								,'idIpp' => $idIpp
								,'hora' => date('H:i:s')
							);

							$insertarVisitaIpp = $this->model->insert_visita_ipp($arrayInsertIpp);
							$rowInsert++;

							if ( $insertarVisitaIpp) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaIpp");
								$rowInsert++;

								$arrayInsertIppDetalle = array(
									'idVisitaIpp' => $insertId
									,'idPregunta' => $idPregunta
									,'idAlternativa' => $idAlternativa
									,'puntaje' => $puntaje
								);
								$insertVisitaIppDetalle = $this->model->insert_visita_ipp_detalle($arrayInsertIppDetalle);
								$rowInsert++;
							}
						} else {
							$idVisitaIpp = $selectVisitaIpp[0]['idVisitaIpp'];

							$arrayInsertIppDetalle = array(
								'idVisitaIpp' => $idVisitaIpp
								,'idPregunta' => $idPregunta
								,'idAlternativa' => $idAlternativa
								,'puntaje' => $puntaje
							);
							$insertVisitaIppDetalle = $this->model->insert_visita_ipp_detalle($arrayInsertIppDetalle);
							$rowInsert++;
						}
					}
				}

				if ( !in_array( $idIpp, $arrayIpps)){
					array_push($arrayIpps, $idIpp);
					$arrayIppsPuntaje[$idIpp] = 0;
				}
				$arrayIppsPuntaje[$idIpp] = $arrayIppsPuntaje[$idIpp] + $puntaje;
				
			}
			//UPDATE PUNTAJES
			foreach ($arrayIpps as $kip => $ipp) {
				//VERIFICACIÓN DE FOTOS
				if ( isset($dataIppFoto[$ipp]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataIppFoto[$ipp]
						,'hora' => date('H:i:s')
						,'idModulo' => 2
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
				}
				//
				$arrayParams = array( 'puntaje' => $arrayIppsPuntaje[$ipp] );
				if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
				$arrayWhere = array( 'idVisita'=>$idVisita, 'idIpp'=> $ipp );
				$arrayUpdateIpp['arrayParams'] = $arrayParams;
				$arrayUpdateIpp['arrayWhere'] = $arrayWhere;
				$updateVisitaIpp = $this->model->update_visita_ipp($arrayUpdateIpp);
				$rowUpdated++;
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'ipp');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR IPP';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarProductos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataProductos = $data->{'dataProductos'};
		$dataProductosFotos = json_decode(json_encode($data->{'dataProductosFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataProductos)) {
			foreach ($dataProductos as $kp => $producto) {
				$competencia = $producto->{'competencia'};
				$idCategoria = $producto->{'categoria'};
				$idMarca = $producto->{'marca'};
				$idProducto = $producto->{'producto'};
				$idVisitaProducto = $producto->{'visitaproducto'};
				$idVisitaProductoDet = $producto->{'visitaproductodet'};

				$presencia = ( isset($producto->{'presencia'}) && !empty($producto->{'presencia'}) ) ? $producto->{'presencia'} : NULL;
				$quiebre = ( isset($producto->{'quiebre'}) && !empty($producto->{'quiebre'}) ) ? $producto->{'quiebre'} : NULL;
				$stock = ( isset($producto->{'stock'}) && !empty($producto->{'stock'}) ) ? $producto->{'stock'} : NULL;
				$idUnidadMedida = ( isset($producto->{'unidadMedida'}) && !empty($producto->{'unidadMedida'}) ) ? $producto->{'unidadMedida'} : NULL;
				$precio = ( isset($producto->{'precio'}) && !empty($producto->{'precio'}) ) ? $producto->{'precio'} : NULL;
				$idMotivo = ( isset($producto->{'motivo'}) && !empty($producto->{'motivo'}) ) ? $producto->{'motivo'} : NULL;
				$foto = ( isset($producto->{'foto'}) && !empty($producto->{'foto'}) ) ? $producto->{'foto'} : NULL;

				$idVisitaFoto = NULL;

				//VERIFICACIÓN DE FOTOS
				if ( isset($dataProductosFotos[$idProducto]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataProductosFotos[$idProducto]
						,'hora' => date('H:i:s')
						,'idModulo' => 3
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
				}

				//VERIFICACIÓN DE LA DATA
				if ( !empty($presencia) || !empty($quiebre) ){
					if ( empty($idVisitaProductoDet) ) {
						$arrayBusquedaProducto = array('idVisita' => $idVisita);
						$selectVisitaProducto = $this->model->select_visita_producto($arrayBusquedaProducto);

						if ( empty($selectVisitaProducto) ) {
							//INSERT CABECERA
							$arrayInsertProducto = array( 'idVisita' => $idVisita,'hora' => date('H:i:s') );
							$insertarVisitaProducto = $this->model->insert_visita_producto($arrayInsertProducto);

							//INSERT DETALLE
							if ( $insertarVisitaProducto ) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaProductos");
								$rowInsert++;

								$arrayInsertProductoDet = array(
									'idVisitaProductos' => $insertId
									,'idProducto' => $idProducto
									,'presencia' => $presencia
									,'quiebre' => $quiebre
									,'stock' => $stock
									,'idUnidadMedida' => $idUnidadMedida
									,'precio' => $precio
									,'idMotivo' => $idMotivo
								);
								if ( !empty($idVisitaFoto)) $arrayInsertProductoDet['idVisitaFoto'] = $idVisitaFoto;

								$insertarVisitaProductoDet = $this->model->insert_visita_producto_detalle($arrayInsertProductoDet);
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
							}

						} else {
							//UPDATE VALORES
							$idVisitaProductos = $selectVisitaProducto[0]['idVisitaProductos'];

							//VERIFICAR PRODUCTO EN DETALLES
							$arrayBusquedaProductosDet = array(
								'idVisitaProductos' => $idVisitaProductos
								,'idProducto' => $idProducto
							);
							$selectVisitaProductoDet = $this->model->select_visita_producto_det($arrayBusquedaProductosDet);

							if ( empty($selectVisitaProductoDet)) {
								//INSERTAR PRODUCTO
								$arrayInsertProductoDet = array(
									'idVisitaProductos' => $idVisitaProductos
									,'idProducto' => $idProducto
									,'presencia' => $presencia
									,'quiebre' => $quiebre
									,'stock' => $stock
									,'idUnidadMedida' => $idUnidadMedida
									,'precio' => $precio
									,'idMotivo' => $idMotivo
								);
								if ( !empty($idVisitaFoto)) $arrayInsertProductoDet['idVisitaFoto'] = $idVisitaFoto;

								$insertarVisitaProductoDet = $this->model->insert_visita_producto_detalle($arrayInsertProductoDet);
							} else {

								//ACTUALIZAR PRODUCTO
								$arrayParams = array(
									'presencia' => $presencia
									,'quiebre' => $quiebre
									,'stock' => $stock
									,'idUnidadMedida' => $idUnidadMedida
									,'precio' => $precio
									,'idMotivo' => $idMotivo
								);
								if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;

								$arrayWhere = array(
									'idVisitaProductos' => $idVisitaProductos
									,'idProducto' => $idProducto
								);
								$arrayUpdateProductoDet['arrayParams'] = $arrayParams;
								$arrayUpdateProductoDet['arrayWhere'] = $arrayWhere;
								//
								$updateVisitaProductoDet = $this->model->update_visita_producto_detalle($arrayUpdateProductoDet);
							}
						}
					} else {
						//ACTUALIZAR PRODUCTO
						$arrayParams = array(
							'presencia' => $presencia
							,'quiebre' => $quiebre
							,'stock' => $stock
							,'idUnidadMedida' => $idUnidadMedida
							,'precio' => $precio
							,'idMotivo' => $idMotivo
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;

						$arrayWhere = array(
							'idVisitaProductosDet' => $idVisitaProductoDet
						);
						$arrayUpdateProductoDet['arrayParams'] = $arrayParams;
						$arrayUpdateProductoDet['arrayWhere'] = $arrayWhere;
						//
						$updateVisitaProductoDet = $this->model->update_visita_producto_detalle($arrayUpdateProductoDet);

						$rowUpdated++;
						
					}
				}
			};

		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'productos');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR CHECK PRODUCTOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarPrecios(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataPrecios = $data->{'dataPrecios'};

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataPrecios) ) {
			foreach ($dataPrecios as $kp => $precios) {
				$competencia = $precios->{'competencia'};
				$idCategoria = $precios->{'categoria'};
				$idMarca = $precios->{'marca'};
				$idProducto = $precios->{'producto'};
				$idVisitaPrecios = $precios->{'visitaPrecios'};
				$idVisitaPreciosDet = $precios->{'visitaPreciosDet'};

				$precio = ( isset($precios->{'precio'}) && !empty($precios->{'precio'}) ) ? $precios->{'precio'} : NULL;
				$precioRegular = ( isset($precios->{'precioRegular'}) && !empty($precios->{'precioRegular'}) ) ? $precios->{'precioRegular'} : NULL;
				$precioOferta = ( isset($precios->{'precioOferta'}) && !empty($precios->{'precioOferta'}) ) ? $precios->{'precioOferta'} : NULL;
				$precioProm1 = ( isset($precios->{'precioProm1'}) && !empty($precios->{'precioProm1'}) ) ? $precios->{'precioProm1'} : NULL;
				$precioProm2 = ( isset($precios->{'precioProm2'}) && !empty($precios->{'precioProm2'}) ) ? $precios->{'precioProm2'} : NULL;
				$precioProm3 = ( isset($precios->{'precioProm3'}) && !empty($precios->{'precioProm3'}) ) ? $precios->{'precioProm3'} : NULL;

				if ( !empty($precio) || !empty($precioOferta) || !empty($precioRegular) || !empty($precioProm1) || !empty($precioProm2) || !empty($precioProm3) ) {
					if ( empty($idVisitaPreciosDet)) {
						$arrayBusquedaPrecio = array('idVisita' => $idVisita);
						$selectVisitaPrecio = $this->model->select_visita_precio($arrayBusquedaPrecio);

						if ( empty($selectVisitaPrecio) ) {
							//INSERTAR CABECERA
							$arrayInsertPrecio = array(	'idVisita' => $idVisita,'hora' => date('H:i:s')	);
							$insertarVisitaPrecio = $this->model->insert_visita_precio($arrayInsertPrecio);

							//INSERTAR DETALLE
							if ( $insertarVisitaPrecio ) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaPrecios");
								$rowInsert++;

								$arrayInsertPrecioDet = array(
									'idVisitaPrecios' => $insertId
									,'idProducto' => $idProducto
									,'flagCompetencia' => $competencia
									,'precio' => $precio
									,'precioRegular' => $precioRegular
									,'precioOferta' => $precioOferta
									,'precioProm1' => $precioProm1
									,'precioProm2' => $precioProm2
									,'precioProm3' => $precioProm3
								);
								$insertarVisitaPrecioDet = $this->model->insert_visita_precio_detalle($arrayInsertPrecioDet);
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
							}
						} else {
							//UPDATE VALORES
							$idVisitaPrecios = $selectVisitaPrecio[0]['idVisitaPrecios'];

							//VERIFICAR PRODUCTO EN DETALLES
							$arrayBusquedaPreciosDet = array( 'idVisitaPrecios' => $idVisitaPrecios, 'idProducto' => $idProducto );
							$selectVisitaPrecioDet = $this->model->select_visita_precio_det($arrayBusquedaPreciosDet);

							if ( empty($selectVisitaPrecioDet) ) {
								//INSERTAR PRECIO PRODUCTO
								$arrayInsertPrecioDet = array(
									'idVisitaPrecios' => $idVisitaPrecios
									,'idProducto' => $idProducto
									,'flagCompetencia' => $competencia
									,'precio' => $precio
									,'precioRegular' => $precioRegular
									,'precioOferta' => $precioOferta
									,'precioProm1' => $precioProm1
									,'precioProm2' => $precioProm2
									,'precioProm3' => $precioProm3
								);
								$insertarVisitaPrecioDet = $this->model->insert_visita_precio_detalle($arrayInsertPrecioDet);
							} else {
								//ACTUALZIAR PRECIO
								$arrayParams = array(
									'precio' => $precio
									,'precioRegular' => $precioRegular
									,'precioOferta' => $precioOferta
									,'precioProm1' => $precioProm1
									,'precioProm2' => $precioProm2
									,'precioProm3' => $precioProm3
								);
								$arrayWhere = array(
									'idVisitaPrecios' => $idVisitaPrecios
									,'idProducto' => $idProducto
								);
								$arrayUpdatePreciosDet['arrayParams'] = $arrayParams;
								$arrayUpdatePreciosDet['arrayWhere'] = $arrayWhere;
								//
								$updateVisitaPreciosDet = $this->model->update_visita_precio_detalle($arrayUpdatePreciosDet);
							}
						}

					} else {
						//ACTUALZIAR PRECIO
						$arrayParams = array(
							'precio' => $precio
							,'precioRegular' => $precioRegular
							,'precioOferta' => $precioOferta
							,'precioProm1' => $precioProm1
							,'precioProm2' => $precioProm2
							,'precioProm3' => $precioProm3
						);
						$arrayWhere = array(
							'idVisitaPreciosDet' => $idVisitaPreciosDet
						);

						$arrayUpdatePreciosDet['arrayParams'] = $arrayParams;
						$arrayUpdatePreciosDet['arrayWhere'] = $arrayWhere;

						$updateVisitaPreciosDet = $this->model->update_visita_precio_detalle($arrayUpdatePreciosDet);
						$rowUpdated++;
					}
				}
			}

		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'precios');

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR PRECIOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarPromociones(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataPromociones = $data->{'dataPromociones'};
		$dataPromocionesFotos = json_decode(json_encode($data->{'dataPromocionesFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataPromociones)) {
			foreach ($dataPromociones as $kpm => $promociones) {
				$idVisitaPromociones = $promociones->{'visitaPromociones'};
				$idVisitaPromocionesDet = $promociones->{'visitaPromocionesDet'};
				$idPromocion = ( isset($promociones->{'promocion'}) && !empty($promociones->{'promocion'}) ) ? $promociones->{'promocion'} : NULL;
				$nombrePromocion = ( isset($promociones->{'nombrePromocion'}) && !empty($promociones->{'nombrePromocion'}) ) ? $promociones->{'nombrePromocion'} : NULL;
				$idTipoPromocion = ( isset($promociones->{'tipoPromocion'}) && !empty($promociones->{'tipoPromocion'}) ) ? $promociones->{'tipoPromocion'} : NULL;
				$presencia = ( isset($promociones->{'presencia'}) && !empty($promociones->{'presencia'}) ) ? $promociones->{'presencia'} : NULL;
				$foto = ( isset($promociones->{'foto'}) && !empty($promociones->{'foto'}) ) ? $promociones->{'foto'} : NULL;

				$idVisitaFoto = NULL;
				//VERIFICACIÓN DE FOTOS
				if ( isset($dataPromocionesFotos[$idVisitaPromocionesDet]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataPromocionesFotos[$idVisitaPromocionesDet]
						,'hora' => date('H:i:s')
						,'idModulo' => 7
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
				}

				//VERIFICACIÓN DE GUARDADO
				if ( $idVisitaPromociones==1 ) {
					//YA ESXISTE EN LA BD
					$arrayParams = array(
						'idPromocion' => $idPromocion
						,'idTipoPromocion' => $idTipoPromocion
						,'presencia' => $presencia
					);
					if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;

					$arrayWhere = array(
						'idVisitaPromocionesDet' => $idVisitaPromocionesDet
					);
					$arrayUpdatePromocionesDet['arrayParams'] = $arrayParams;
					$arrayUpdatePromocionesDet['arrayWhere'] = $arrayWhere;

					$updateVisitaPromocionesDet = $this->model->update_visita_promociones_detalle($arrayUpdatePromocionesDet);
					$rowUpdated++;
				} else {
					//NO EXISTE EN LA BD
					//BUSCAR CABECERA
					$arrayBusquedaPromocion = array('idVisita' => $idVisita);
					$selectVisitaPromocion = $this->model->select_visita_promocion($arrayBusquedaPromocion);

					if ( empty($selectVisitaPromocion) ) {
						//INSERTAR CABECERA
						$arrayInsertPromocion = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
						$insertarVisitaPromocion = $this->model->insert_visita_promocion($arrayInsertPromocion);
						
						//INSERTAR DETALLE
						if ( $insertarVisitaPromocion ) {
							$insertId = $this->db->insert_id();
							$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaPromociones");
							//$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i>SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
							$rowInsert++;

							$arrayInsertPromocionesDet = array(
								'idVisitaPromociones' => $insertId
								,'idPromocion' => $idPromocion
								,'idTipoPromocion' => $idTipoPromocion
								,'nombrePromocion' => $nombrePromocion
								,'presencia' => $presencia
							);
							if ( !empty($idVisitaFoto)) $arrayInsertPromocionesDet['idVisitaFoto'] = $idVisitaFoto;

							$insertarVisitaPromocionesDet = $this->model->insert_visita_promocion_detalle($arrayInsertPromocionesDet);	
						} else {
							$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
						}
					} else {
						//INSERTAR DETALLE PROMOCIONES
						$idVisitaPromociones = $selectVisitaPromocion[0]['idVisitaPromociones'];

						$arrayInsertPromocionesDet = array(
							'idVisitaPromociones' => $idVisitaPromociones
							,'idPromocion' => $idPromocion
							,'idTipoPromocion' => $idTipoPromocion
							,'nombrePromocion' => $nombrePromocion
							,'presencia' => $presencia
						);
						if ( !empty($idVisitaFoto)) $arrayInsertPromocionesDet['idVisitaFoto'] = $idVisitaFoto;

						$insertarVisitaPromocionesDet = $this->model->insert_visita_promocion_detalle($arrayInsertPromocionesDet);	
					}
				}
			}

		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'promociones');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR PROMOCIONES';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarSos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataSos = $data->{'dataSos'};
		$dataCategoriaFotos = json_decode(json_encode($data->{'dataCategoriaFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataSos)) {
			foreach ($dataSos as $ks => $sos) {
				$idVisitaSos = ( isset($sos->{'visitaSos'}) && !empty($sos->{'visitaSos'}) ) ? $sos->{'visitaSos'} : NULL;
				$idCategoria = ( isset($sos->{'categoria'}) && !empty($sos->{'categoria'}) ) ? $sos->{'categoria'} : NULL;
				$categoriaCm = ( isset($sos->{'categoriaCm'}) && !empty($sos->{'categoriaCm'}) ) ? $sos->{'categoriaCm'} : NULL;
				$categoriaFrentes = ( isset($sos->{'categoriaFrentes'}) && !empty($sos->{'categoriaFrentes'}) ) ? $sos->{'categoriaFrentes'} : NULL;
				$foto = ( isset($sos->{'foto'}) && !empty($sos->{'foto'}) ) ? $sos->{'foto'} : NULL;
				$idVisitaFoto = NULL;

				//VERIFICACIÓN DE FOTOS
				if ( isset($dataCategoriaFotos[$idCategoria]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataCategoriaFotos[$idCategoria]
						,'hora' => date('H:i:s')
						,'idModulo' => 5
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
				}
				//

				$listaMarcas = ( isset($sos->{'listaMarcas'}) && !empty($sos->{'listaMarcas'}) ) ? $sos->{'listaMarcas'} : NULL;
				$numDet = count($listaMarcas);

				if ( !empty($idVisitaSos)) { //SOS GUARDADO
					//ACTUALIZAMOS LA CABECERA
					$arrayParams = array(
						'cm' => $categoriaCm
						,'frentes' => $categoriaFrentes
					);
					if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
					$arrayWhere = array(
						'idVisitaSos' => $idVisitaSos
					);
					$arrayUpdateSos['arrayParams'] = $arrayParams;
					$arrayUpdateSos['arrayWhere'] = $arrayWhere;

					$updateVisitaSos = $this->model->update_visita_sos($arrayUpdateSos);
					$rowUpdated++;

					//ACTUALIZAMOS LOS DETALLES
					if ( $numDet>0 ) {
						foreach ($listaMarcas as $klm => $marcas) {
							$idVisitaSosDet = ( isset($marcas->{'visitaSosDet'}) && !empty($marcas->{'visitaSosDet'}) ) ? $marcas->{'visitaSosDet'} : NULL;
							$idCategoriaMarca = $idCategoria;
							$idMarca = ( isset($marcas->{'marca'}) && !empty($marcas->{'marca'}) ) ? $marcas->{'marca'} : NULL;
							$marcaCm = ( isset($marcas->{'marcaCm'}) && !empty($marcas->{'marcaCm'}) ) ? $marcas->{'marcaCm'} : NULL;
							$marcaFrentes = ( isset($marcas->{'marcaFrentes'}) && !empty($marcas->{'marcaFrentes'}) ) ? $marcas->{'marcaFrentes'} : NULL;
							$flagCompetencia = ( isset($marcas->{'flagCompetencia'}) && !empty($marcas->{'flagCompetencia'}) ) ? $marcas->{'flagCompetencia'} : NULL;

							if ( !empty($idVisitaSosDet)) { //SOS DETALLE GUARDADO
								//UPDATE DETALLE
								$arrayParams = array(
									'cm' => $marcaCm
									,'frentes' => $marcaFrentes
								);
								$arrayWhere = array(
									'idVisitaSosDet' => $idVisitaSosDet
								);
								$arrayUpdateDetSos['arrayParams'] = $arrayParams;
								$arrayUpdateDetSos['arrayWhere'] = $arrayWhere;

								$updateVisitaSos = $this->model->update_visita_sos_detalle($arrayUpdateDetSos);
							} else { //SOS DETALLE NUEVO
								//INSERT DETALLE
								$arrayInsertSosDet = array(
									'idVisitaSos' => $idVisitaSos
									,'idCategoria' => $idCategoriaMarca
									,'idMarca' => $idMarca
									,'cm' => $marcaCm
									,'frentes' => $marcaFrentes
									,'flagCompetencia' => $flagCompetencia
								);

								$insertarVisitaSosDet = $this->model->insert_visita_sos_detalle($arrayInsertSosDet);
								if ( $insertarVisitaSosDet) {
									$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i>SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
								}
							}
						}
					}
				} else {//SOS SIN GUARDAR
					$arrayInsertSos = array(
						'idVisita' => $idVisita
						,'idCategoria' => $idCategoria
						,'hora' => date('H:i:s')
						,'numDet' => $numDet
						,'cm' => $categoriaCm
						,'frentes' => $categoriaFrentes
					);
					if ( !empty($idVisitaFoto)) $arrayInsertSos['idVisitaFoto'] = $idVisitaFoto;

					$insertarVisitaSos = $this->model->insert_visita_sos($arrayInsertSos);
					//VERIFICAMOS LA INFORMACIÓN CABECERA ALMACENADA
					if ( $insertarVisitaSos) {
						$insertId = $this->db->insert_id();
						$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaSos");
						$rowInsert++;

						//VERIFICAMOS LOS DETALLES
						if ( $numDet > 0) {
							foreach ($listaMarcas as $klm => $marcas) {
								$idVisitaSosDet = ( isset($marcas->{'visitaSosDet'}) && !empty($marcas->{'visitaSosDet'}) ) ? $marcas->{'visitaSosDet'} : NULL;
								$idCategoriaMarca = $idCategoria;
								$idMarca = ( isset($marcas->{'marca'}) && !empty($marcas->{'marca'}) ) ? $marcas->{'marca'} : NULL;
								$marcaCm = ( isset($marcas->{'marcaCm'}) && !empty($marcas->{'marcaCm'}) ) ? $marcas->{'marcaCm'} : NULL;
								$marcaFrentes = ( isset($marcas->{'marcaFrentes'}) && !empty($marcas->{'marcaFrentes'}) ) ? $marcas->{'marcaFrentes'} : NULL;
								$flagCompetencia = ( isset($marcas->{'flagCompetencia'}) && !empty($marcas->{'flagCompetencia'}) ) ? $marcas->{'flagCompetencia'} : NULL;

								//SOS DETALLE NUEVO
								//INSERT DETALLE
								$arrayInsertSosDet = array(
									'idVisitaSos' => $insertId
									,'idCategoria' => $idCategoriaMarca
									,'idMarca' => $idMarca
									,'cm' => $marcaCm
									,'frentes' => $marcaFrentes
									,'flagCompetencia' => $flagCompetencia
								);

								$insertarVisitaSosDet = $this->model->insert_visita_sos_detalle($arrayInsertSosDet);
								//if ( $insertarVisitaSosDet) {
									//$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i>SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
								//}
							}
						}
					}
				}
			}

		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'sos');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR SOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarSod(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataCategorias = $data->{'dataCategorias'};
		$dataMarcaElementos = $data->{'dataMarcaElementos'};
		$rowUpdated = 0; $rowInsert=0;

		$content='';
		if ( !empty($dataCategorias)) {
			foreach ($dataCategorias as $kdc => $categorias) {
				$idCategoria = ( isset($categorias->{'categoria'}) && !empty($categorias->{'categoria'}) ) ? $categorias->{'categoria'} : NULL;
				$categoriaCantidad = ( isset($categorias->{'categoriaCantidad'}) && !empty($categorias->{'categoriaCantidad'}) ) ? $categorias->{'categoriaCantidad'} : NULL;
				$listaMarcaElementos = ( isset($categorias->{'listaMarcaElementos'}) && !empty($categorias->{'listaMarcaElementos'}) ) ? $categorias->{'listaMarcaElementos'} : NULL;

				if ( !empty($idCategoria)) {
					$arrayBusquedaSod = array('idVisita'=>$idVisita,'idCategoria'=>$idCategoria);
					$selectVisitaSod = $this->model->select_visita_sod($arrayBusquedaSod);

					if (empty($selectVisitaSod)) {
						//INSERT CABECERA
						$arrayInsertSod = array( 'idVisita' => $idVisita,'idCategoria'=>$idCategoria,'hora' => date('H:i:s') ,'cant'=>$categoriaCantidad );
						$insertarVisitaSod = $this->model->insert_visita_sod($arrayInsertSod);

						//INSERT DETALLE
						if ( $insertarVisitaSod ) {
							$insertId = $this->db->insert_id();
							$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaSod");
							$rowInsert++;

							if ( !empty($listaMarcaElementos)) {
								foreach ($listaMarcaElementos as $klme => $marcasElementos) {
									$idCategoriaMarca = ( isset($marcasElementos->{'marcaCategoria'}) && !empty($marcasElementos->{'marcaCategoria'}) ) ? $marcasElementos->{'marcaCategoria'} : NULL;
									$idMarca = ( isset($marcasElementos->{'marcaMarca'}) && !empty($marcasElementos->{'marcaMarca'}) ) ? $marcasElementos->{'marcaMarca'} : NULL;
									$idTipoElementoVisibilidad = ( isset($marcasElementos->{'marcaElementoVisbilidad'}) && !empty($marcasElementos->{'marcaElementoVisbilidad'}) ) ? $marcasElementos->{'marcaElementoVisbilidad'} : NULL;
									$cant = ( isset($marcasElementos->{'marcaCantidad'}) && !empty($marcasElementos->{'marcaCantidad'}) ) ? $marcasElementos->{'marcaCantidad'} : NULL;

									if ( !empty($cant)) {
										$arrayInsertSodDetalle = array(
											'idVisitaSod' => $insertId
											,'idCategoria' => $idCategoriaMarca
											,'idMarca' => $idMarca
											,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
											,'cant' => $cant
										);
										$insertarVisitaSodDetalle = $this->model->insert_visita_sod_detalle($arrayInsertSodDetalle);
										$rowInsert++;
									}
								}
							}
						} else {
							$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
						}
					} else {
						//YA EXISTE LA CABECERA
						$idVisitaSod = $selectVisitaSod[0]['idVisitaSod'];

						//UPDATE LA CABECERA
						$arrayParams = array('cant' => $categoriaCantidad );
						$arrayWhere = array('idVisitaSod' => $idVisitaSod);
						$arrayUpdateSod['arrayParams'] = $arrayParams;
						$arrayUpdateSod['arrayWhere'] = $arrayWhere;
						//
						$updateVisitaSod = $this->model->update_visita_sod($arrayUpdateSod);
						$rowUpdated++;
						
						//VERIFICAMOS LISTA DE MARCAS
						if (!empty($listaMarcaElementos)) {
							foreach ($listaMarcaElementos as $klme => $marcasElementos) {
								$idCategoriaMarca = ( isset($marcasElementos->{'marcaCategoria'}) && !empty($marcasElementos->{'marcaCategoria'}) ) ? $marcasElementos->{'marcaCategoria'} : NULL;
								$idMarca = ( isset($marcasElementos->{'marcaMarca'}) && !empty($marcasElementos->{'marcaMarca'}) ) ? $marcasElementos->{'marcaMarca'} : NULL;
								$idTipoElementoVisibilidad = ( isset($marcasElementos->{'marcaElementoVisbilidad'}) && !empty($marcasElementos->{'marcaElementoVisbilidad'}) ) ? $marcasElementos->{'marcaElementoVisbilidad'} : NULL;
								$cant = ( isset($marcasElementos->{'marcaCantidad'}) && !empty($marcasElementos->{'marcaCantidad'}) ) ? $marcasElementos->{'marcaCantidad'} : NULL;

								//BUSCAMOS EL DETALLE
								$arrayBusquedaSodDetalle = array('idVisitaSod'=>$idVisitaSod,'idCategoria'=>$idCategoriaMarca,'idMarca'=>$idMarca,'idTipoElementoVisibilidad'=>$idTipoElementoVisibilidad);
								$selectVisitaSodDetalle = $this->model->select_visita_sod_detalle($arrayBusquedaSodDetalle);

								if ( empty($selectVisitaSodDetalle)) {
									//INSERTAMOS EL DETALLE
									if ( !empty($cant)) {
										//LA CANTIDAD ES MAYOR A CERO
										$arrayInsertSodDetalle = array( 
											'idVisitaSod' => $idVisitaSod
											,'idCategoria'=>$idCategoriaMarca
											,'idMarca'=>$idMarca
											,'idTipoElementoVisibilidad'=>$idTipoElementoVisibilidad
											,'cant'=>$cant
										);
										$insertarVisitaSodDetalle = $this->model->insert_visita_sod_detalle($arrayInsertSodDetalle);
										$rowInsert++;
									}
								} else {
									//UPDATE LA INFORMACIÓN
									$arrayParams = array('cant' => $cant);
									$arrayWhere = array(
										'idVisitaSod' => $idVisitaSod
										,'idCategoria' => $idCategoriaMarca
										,'idMarca' => $idMarca
										,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
									);
									$arrayUpdateSodDetalle['arrayParams'] = $arrayParams;
									$arrayUpdateSodDetalle['arrayWhere'] = $arrayWhere;
									//
									$updateVisitaSodDetalle = $this->model->update_visita_sod_detalle($arrayUpdateSodDetalle);
									$rowUpdated++;
								}
							}
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'sod');

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR SOD';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function verFotosSod(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$idCategoria = $data->{'categoria'};
		$idMarca = $data->{'marca'};
		$idTipoElementoVisibilidad = $data->{'elementoVisibilidad'};

		$input = array(
			'idVisita' => $idVisita
			,'idCategoria' => $idCategoria
			,'idMarca' => $idMarca
			,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
		);

		$rs_sodFotos = $this->model->obtener_visita_sod_fotos($input);

		$array=array();
		$array['datos'] = $input;
		$array['listaSodFotos'] = $rs_sodFotos;

		$html = $this->load->view("modulos/configuraciones/contingencia/rutas/visita_sod_fotos",$array, true);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR SOD FOTOS ';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarSodFotos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataSodFotos = $data->{'dataSodFotos'};
		$dataFotos = json_decode(json_encode($data->{'dataFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataSodFotos)) {
			foreach ($dataSodFotos as $kdf => $rowFotos) {
				$idVisita = ( isset($rowFotos->{'visita'}) && !empty($rowFotos->{'visita'}) ) ? $rowFotos->{'visita'} : NULL;
				$indice = ( isset($rowFotos->{'indice'}) && !empty($rowFotos->{'indice'}) ) ? $rowFotos->{'indice'} : NULL;
				$idCategoria = ( isset($rowFotos->{'categoria'}) && !empty($rowFotos->{'categoria'}) ) ? $rowFotos->{'categoria'} : NULL;
				$idMarca = ( isset($rowFotos->{'marca'}) && !empty($rowFotos->{'marca'}) ) ? $rowFotos->{'marca'} : NULL;
				$idTipoElementoVisibilidad = ( isset($rowFotos->{'tipoElementoVisibilidad'}) && !empty($rowFotos->{'tipoElementoVisibilidad'}) ) ? $rowFotos->{'tipoElementoVisibilidad'} : NULL;
				$foto = ( isset($rowFotos->{'foto'}) && !empty($rowFotos->{'foto'}) ) ? $rowFotos->{'foto'} : NULL;
				
				$idVisitaFoto = NULL;

				//VERIFICACIÓN DE FOTOS
				if ( isset($dataFotos[$indice]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataFotos[$indice]
						,'hora' => date('H:i:s')
						,'idModulo' => 5
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }

					//VERIFICACION DE CABECERA
					$arrayBusquedaSod = array('idVisita' => $idVisita, 'idCategoria'=>$idCategoria );
					$selectVisitaSod = $this->model->select_visita_sod($arrayBusquedaSod);

					if ( empty($selectVisitaSod) ) {
						//INSERTAMOS LA CABECERA
						$arrayInsertSod = array( 'idVisita' => $idVisita,'idCategoria'=>$idCategoria,'hora' => date('H:i:s') );
						$insertarVisitaSod = $this->model->insert_visita_sod($arrayInsertSod);

						//INSERT DETALLE
						if ( $insertarVisitaSod ) {
							$insertId = $this->db->insert_id();
							$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaSod");
							$rowInsert++;

							$arrayInsertSodDet = array(
								'idVisitaSod' => $insertId
								,'idCategoria' => $idCategoria
								,'idMarca' => $idMarca
								,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
								,'idVisitaFoto' => $idVisitaFoto
							);
							$insertarVisitaSodFotoDet = $this->model->insert_visita_sodFoto_detalle($arrayInsertSodDet);
							$rowInsert++;
						} else {
							$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
						}
					} else {
						$idVisitaSod = $selectVisitaSod[0]['idVisitaSod'];

						$arrayInsertSodDet = array(
							'idVisitaSod' => $idVisitaSod
							,'idCategoria' => $idCategoria
							,'idMarca' => $idMarca
							,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
							,'idVisitaFoto' => $idVisitaFoto
						);
						$insertarVisitaSodFotoDet = $this->model->insert_visita_sodFoto_detalle($arrayInsertSodDet);
						$rowInsert++;
					}
				}

			}	
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'sod');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR SOD FOTOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarEncartes(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataEncartes = $data->{'dataEncartes'};
		$dataEncartesFotos = json_decode(json_encode($data->{'dataEncartesFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataEncartes)) {
			foreach ($dataEncartes as $ke => $encartes) {
				$idVisitaEncartes = ( isset($encartes->{'visitaEncartes'}) && !empty($encartes->{'visitaEncartes'}) ) ? $encartes->{'visitaEncartes'}:NULL;
				$idVisitaEncartesDet = ( isset($encartes->{'visitaEncartesDet'}) && !empty($encartes->{'visitaEncartesDet'}) ) ? $encartes->{'visitaEncartesDet'}:NULL;
				$idCategoria = ( isset($encartes->{'categoria'}) && !empty($encartes->{'categoria'}) ) ? $encartes->{'categoria'}:NULL;
				$foto = ( isset($encartes->{'foto'}) && !empty($encartes->{'foto'}) ) ? $encartes->{'foto'}:NULL;
				
				$idVisitaFoto = NULL;
				if ( !empty($foto)) {
					if ( isset($dataEncartesFotos[$idVisitaEncartesDet]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataEncartesFotos[$idVisitaEncartesDet]
							,'hora' => date('H:i:s')
							,'idModulo' => 5
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}

					//VERIFICACIÓN DE GUARDADO
					if ( $idVisitaEncartes==1 ) {
						//YA EXISTE EN LA BD
						$arrayParams = array(
							//'idVisitaFoto' => $idVisitaFoto
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
						$arrayWhere = array(
							'idVisitaEncartesDet' => $idVisitaEncartesDet
						);
						$arrayUpdateEncartesDet['arrayParams'] = $arrayParams;
						$arrayUpdateEncartesDet['arrayWhere'] = $arrayWhere;

						$updateVisitaEncartesDet = $this->model->update_visita_encartes_detalle($arrayUpdateEncartesDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaEncarte = array('idVisita' => $idVisita);
						$selectVisitaEncarte = $this->model->select_visita_encarte($arrayBusquedaEncarte);

						if ( empty($selectVisitaEncarte)) {
							//INSERTAR CABECERA
							$arrayInsertEncarte = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaEncarte = $this->model->insert_visita_encarte($arrayInsertEncarte);

							//INSERTAR DETALLE
							if ( $insertarVisitaEncarte ) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaEncartes");
								//$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i>SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
								$rowInsert++;

								$arrayInsertEncartesDet = array(
									'idVisitaEncartes' => $insertId
									,'idCategoria' => $idCategoria
									//,'idVisitaFoto' => $idVisitaFoto
								);
								if ( !empty($idVisitaFoto)) $arrayInsertEncartesDet['idVisitaFoto'] = $idVisitaFoto;
								$insertarVisitaEncartesDet = $this->model->insert_visita_encartes_detalle($arrayInsertEncartesDet);	
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
							}
						} else {
							//INSERTAR DETALLE ENCARTES
							$idVisitaEncartes = $selectVisitaEncarte[0]['idVisitaEncartes'];

							$arrayInsertEncartesDet = array(
								'idVisitaEncartes' => $idVisitaEncartes
								,'idCategoria' => $idCategoria
							);
							if ( !empty($idVisitaFoto)) $arrayInsertEncartesDet['idVisitaFoto'] = $idVisitaFoto;
							$insertarVisitaEncartesDet = $this->model->insert_visita_encartes_detalle($arrayInsertEncartesDet);
						}
					}
				}
			}

		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'encartes');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR ENCARTES';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarSeguimientoPlan(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataSegPlan = $data->{'dataSegPlan'};
		$dataSegPlanFotos = json_decode(json_encode($data->{'dataSegPlanFotos'}), true);
		
		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;

		$content='';
		if ( !empty($dataSegPlan)) {
			foreach ($dataSegPlan as $ksp => $planes) {
				$idSeguimientoPlan = (!empty($planes->{'segPlan'}) && isset($planes->{'segPlan'})) ? $planes->{'segPlan'} : NULL ;
				$idVisitaSeguimientoPlan = (!empty($planes->{'visitaSegPlan'}) && isset($planes->{'visitaSegPlan'})) ? $planes->{'visitaSegPlan'} : NULL ;
				$idVisitaSeguimientoPlanDet = (!empty($planes->{'visitaSegPlanDet'}) && isset($planes->{'visitaSegPlanDet'})) ? $planes->{'visitaSegPlanDet'} : NULL ;
				$idTipoElementoVisibilidad = (!empty($planes->{'elementoVisibilidad'}) && isset($planes->{'elementoVisibilidad'})) ? $planes->{'elementoVisibilidad'} : NULL ;
				$presencia = (!empty($planes->{'presencia'}) && isset($planes->{'presencia'})) ? $planes->{'presencia'} : NULL ;
				$armado = (!empty($planes->{'armado'}) && isset($planes->{'armado'})) ? $planes->{'armado'} : NULL ;
				$revestido = (!empty($planes->{'revestido'}) && isset($planes->{'revestido'})) ? $planes->{'revestido'} : NULL ;
				$idMotivo = (!empty($planes->{'motivo'}) && isset($planes->{'motivo'})) ? $planes->{'motivo'} : NULL ;
				$comentario = (!empty($planes->{'comentario'}) && isset($planes->{'comentario'})) ? $planes->{'comentario'} : NULL ;
				$idMarca = (!empty($planes->{'marca'}) && isset($planes->{'marca'})) ? $planes->{'marca'} : NULL ;
				$foto = (!empty($planes->{'foto'}) && isset($planes->{'foto'})) ? $planes->{'foto'} : NULL ;
				
				$idVisitaFoto = NULL;
				$index = $idSeguimientoPlan.'-'.$idTipoElementoVisibilidad;

				//TRABAJAMOS CON LOS MARCADOS
				if ( !empty($presencia)) {
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataSegPlanFotos[$index]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataSegPlanFotos[$index]
							,'hora' => date('H:i:s')
							,'idModulo' => 7
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}

					//VERIFICAMOS EXISTENCIA DETALLE
					if ( empty($idVisitaSeguimientoPlanDet)) {
						//INSERTAR LA DATA
						//VERIFICAR EXISTENCIA DE LA CABECERA
						$arrayBusquedaSegPlan = array('idVisita'=> $idVisita, 'idSeguimientoPlan'=>$idSeguimientoPlan);
						$selectVisitaSeguimientoPlan = $this->model->select_visita_seguimientoPlan($arrayBusquedaSegPlan);

						if ( empty($selectVisitaSeguimientoPlan)) {
							//INSERT CABECERA
							$arrayInsertSeguimientoPlan = array(
								'idVisita' => $idVisita
								,'idSeguimientoPlan' => $idSeguimientoPlan
								,'hora' => date('H:i:s')
							);

							$insertarVisitaSeguimientoPlan = $this->model->insert_visita_seguimientoPlan($arrayInsertSeguimientoPlan);

							//INSERTAR DETALLE
							if ( $insertarVisitaSeguimientoPlan) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan");
								$rowInsert++;

								$arrayInsertSeguimientoPlanDet = array(
									'idVisitaSeguimientoPlan' => $insertId
									,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
									,'armado' => $armado
									,'revestido' => $revestido
									,'idMotivo' => $idMotivo
									,'comentario' => $comentario
									,'idMarca' => $idMarca
								);
								if ( !empty($idVisitaFoto)) $arrayInsertSeguimientoPlanDet['idVisitaFoto'] = $idVisitaFoto;
								$insertarVisitaSeguimientoPlanDet = $this->model->insert_visita_seguimientoPlan_detalle($arrayInsertSeguimientoPlanDet);
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
							}

						} else {
							$idVisitaSeguimientoPlan = $selectVisitaSeguimientoPlan[0]['idVisitaSeguimientoPlan'];

							//INSERTAR DETALLE
							//(Anteriormente se buscaba el detalle, pero se anailizo el CODE y no es necesario, eso espero.)
								//INSERTAR TIPO ELEMENTO VISIBILIDAD
								$arrayInsertSeguimientoPlanDet = array(
									'idVisitaSeguimientoPlan' => $idVisitaSeguimientoPlan
									,'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
									,'armado' => $armado
									,'revestido' => $revestido
									,'idMotivo' => $idMotivo
									,'comentario' => $comentario
									,'idMarca' => $idMarca
								);
								if ( !empty($idVisitaFoto)) $arrayInsertSeguimientoPlanDet['idVisitaFoto'] = $idVisitaFoto;
								$insertarVisitaSeguimientoPlanDet = $this->model->insert_visita_seguimientoPlan_detalle($arrayInsertSeguimientoPlanDet);
						}
					} else {
						//UPDATE LA  DATA
						$arrayParams = array(
							'idTipoElementoVisibilidad' => $idTipoElementoVisibilidad
							,'armado' => $armado
							,'revestido' => $revestido
							,'idMotivo' => $idMotivo
							,'comentario' => $comentario
							,'idMarca' => $idMarca
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
						$arrayWhere = array(
							'idVisitaSeguimientoPlanDet' => $idVisitaSeguimientoPlanDet
						);
						$arrayUpdateSeguimientoPlanDet['arrayParams'] = $arrayParams;
						$arrayUpdateSeguimientoPlanDet['arrayWhere'] = $arrayWhere;
						//var_dump($arrayUpdateProductoDet);
						$updateVisitaSeguimientoPlanDet = $this->model->update_visita_seguimientoPlan_detalle($arrayUpdateSeguimientoPlanDet);

						$rowUpdated++;
					}
				}
			}

		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'seguimientoPlan');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR SEGUIMIENTO PLAN';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarDespachos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$idVisitaDespachos = $data->{'idVisitaDespachos'};
		$idVisitaDesapachosDet = $data->{'idVisitaDesapachosDet'};
		$placa = $data->{'despachoPlaca'};
		$horaIni = $data->{'horarioDesde'};
		$horaFin = $data->{'horarioHasta'};
		$idIncidencia = $data->{'incidencia'};
		$comentario = $data->{'despachoComentario'};
		$dataFrecuencias = $data->{'frecuencias'};

		$rowUpdated = 0;
		$content='';

		if ( empty($idVisitaDesapachosDet) ) {
			//NO EXISTE EN LA BD
			//INSERT CABECERA
			$arrayInsertDespacho = array(
				'idVisita' => $idVisita
				,'hora' => date('H:i:s')
			);

			$insertarVisitaDespacho = $this->model->insert_visita_despacho($arrayInsertDespacho);

			//INSERTAMOES EL DETALLE
			if ( $insertarVisitaDespacho) {
				$insertId = $this->db->insert_id();
				$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaDespachos");
				$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i>SE LOGRO INGRESAR LA INFORMACIÓN.</div>';

				$arrayInsertDespachoDet = array(
					'idVisitaDespachos' => $insertId
					,'placa' => $placa
					,'horaIni' => $horaIni
					,'horaFin' => $horaFin
					,'idIncidencia' => $idIncidencia
					,'comentario' => $comentario
					//,'idVisitaFoto' => $idVisitaFoto
				);
				$insertarVisitaDespachosDet = $this->model->insert_visita_despacho_detalle($arrayInsertDespachoDet);

				//INSERTAMOS LAS FRECUENCIAS
				if ( !empty($dataFrecuencias)) {
					if ( is_array($dataFrecuencias)) {
						foreach ($dataFrecuencias as $kf => $dia) {
							$arrayInsertDespachoDia = array(
								'idVisitaDespachos' => $insertId
								,'idDia' => $dia
								,'presencia' => 1
							);
							$insertarVisitaDespachoDia = $this->model->insert_visita_despacho_dia($arrayInsertDespachoDia);
						}
					} else {
						$arrayInsertDespachoDia = array(
							'idVisitaDespachos' => $idVisitaDespachos
							,'idDia' => $dataFrecuencias
							,'presencia' => 1
						);
						$insertarVisitaDespachoDia = $this->model->insert_visita_despacho_dia($arrayInsertDespachoDia);
					}
				} else {
					$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LAS FRECUENCIAS DE DÍAS.</div>';
				}
			} else {
				$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
			}			
		} else {
			//EXISTE EN LA BD
			//UPDATE LA  DATA
			$arrayParams = array(
				'placa' => $placa
				,'horaIni' => $horaIni
				,'horaFin' => $horaFin
				,'idIncidencia' => $idIncidencia
				,'comentario' => $comentario
				//,'idVisitaFoto' => $idVisitaFoto
			);
			$arrayWhere = array(
				'idVisitaDesapachosDet' => $idVisitaDesapachosDet
			);
			$arrayUpdateDespachosDet['arrayParams'] = $arrayParams;
			$arrayUpdateDespachosDet['arrayWhere'] = $arrayWhere;
			//var_dump($arrayUpdateProductoDet);
			$updateVisitaDespachosDet = $this->model->update_visita_despachos_detalle($arrayUpdateDespachosDet);
			$rowUpdated++;

			//CAMBIAMOS ESTADO DE FRECUENCIAS
			$arrayParams = array(
				'presencia' => 0
			);
			$arrayWhere = array(
				'idVisitaDespachos' => $idVisitaDespachos
			);
			$arrayUpdateDespachosDias['arrayParams'] = $arrayParams;
			$arrayUpdateDespachosDias['arrayWhere'] = $arrayWhere;
			//var_dump($arrayUpdateProductoDet);
			$updateVisitaDespachosDias = $this->model->update_visita_despachos_dias($arrayUpdateDespachosDias);

			if ( !empty($dataFrecuencias)) {
				if ( is_array($dataFrecuencias)) {
					foreach ($dataFrecuencias as $kf => $dia) {
						$arrayInsertDespachoDia = array(
							'idVisitaDespachos' => $idVisitaDespachos
							,'idDia' => $dia
							,'presencia' => 1
						);
						$insertarVisitaDespachoDia = $this->model->insert_visita_despacho_dia($arrayInsertDespachoDia);
					}
				} else {
					$arrayInsertDespachoDia = array(
						'idVisitaDespachos' => $idVisitaDespachos
						,'idDia' => $dataFrecuencias
						,'presencia' => 1
					);
					$insertarVisitaDespachoDia = $this->model->insert_visita_despacho_dia($arrayInsertDespachoDia);
				}
			} else {
				$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LAS FRECUENCIAS DE DÍAS.</div>';
			}
		}

		if ( $rowUpdated>0) {
			$content .= '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i>SE LOGRO ACTUALIZAR LA INFORMACIÓN CORRECTAMENTE.</div>';
		}
		//TRUE SEGUIMIENTO PLAN
		$this->model->update_visita_modulo($idVisita,'despachos');

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR DESPACHOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarFotoEstado(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisitaModuloFoto = $data->{'visitaModuloFoto'};
		$content='';

		if ( !empty($idVisitaModuloFoto)) {
			$arrayParams = array( 'estado' => 0 );
			$arrayWhere = array( 'idVisitaModuloFoto'=>$idVisitaModuloFoto );
			$arrayUpdateModuloFoto['arrayParams'] = $arrayParams;
			$arrayUpdateModuloFoto['arrayWhere'] = $arrayWhere;
			$updateVisitaModuloFoto = $this->model->update_visita_modulo_foto($arrayUpdateModuloFoto);

			$content .= $this->htmlResultado;
		} else {
			$content .= $this->htmlNoResultado;
		}

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'ELIMINAR FOTOS';
		$result['data']['html'] = $content;
		echo json_encode($result);
	}

	public function guardarFotos(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataModuloFotos = $data->{'dataModuloFotos'};
		$dataFotosFotos = json_decode(json_encode($data->{'dataFotosFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';

		if ( !empty($dataModuloFotos)) {
			foreach ($dataModuloFotos as $kf => $fotos) {
				$visitaModuloFoto = ( isset($fotos->{'visitaModuloFoto'}) && !empty($fotos->{'visitaModuloFoto'})) ? $fotos->{'visitaModuloFoto'} : NULL;
				$idTipoFoto = ( isset($fotos->{'tipoFoto'}) && !empty($fotos->{'tipoFoto'})) ? $fotos->{'tipoFoto'} : NULL;
				$nombreTipoFoto = ( isset($fotos->{'tipoFotoText'}) && !empty($fotos->{'tipoFotoText'})) ? $fotos->{'tipoFotoText'} : NULL;
				$comentario = ( isset($fotos->{'comentario'}) && !empty($fotos->{'comentario'})) ? $fotos->{'comentario'} : NULL;
			
				$idVisitaFoto = NULL;

				//VERIFICACIÓN DE FOTOS
				if ( isset($dataFotosFotos[$visitaModuloFoto]) ) {
					//
					$arrayInsertVisitaFoto = array(
						'idVisita' => $idVisita
						,'fotoUrl' => $dataFotosFotos[$visitaModuloFoto]
						,'hora' => date('H:i:s')
						,'idModulo' => 9
					);

					$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
					if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
					else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
				}

				//INSERTAMOS DATA
				$arrayInsertModuloFoto = array(
					'idVisita' => $idVisita
					,'idTipoFoto' => $idTipoFoto
					,'nombreTipoFoto' => $nombreTipoFoto
					,'idVisitaFoto' => $idVisitaFoto
					,'comentario' => $comentario
				);
				$insertVisitaModuloFoto = $this->model->insert_visita_modulo_foto($arrayInsertModuloFoto);
				$rowInsert++;

			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'moduloFotos');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR FOTOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarInventario(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataInventario = $data->{'dataInventario'};
		$rowUpdated = 0; $rowInsert=0;

		$content='';
		if ( !empty($dataInventario)) {
			foreach ($dataInventario as $kli => $inventario) {
				$idVisitaInventario = (!empty($inventario->{'visitaInventario'}) && isset($inventario->{'visitaInventario'})) ? $inventario->{'visitaInventario'} : NULL ;
				$idVisitaInventarioDet = (!empty($inventario->{'visitaInventarioDet'}) && isset($inventario->{'visitaInventarioDet'})) ? $inventario->{'visitaInventarioDet'} : NULL ;
				$idProducto = (!empty($inventario->{'producto'}) && isset($inventario->{'producto'})) ? $inventario->{'producto'} : NULL ;
				$stock_inicial = (!empty($inventario->{'stockInicial'}) && isset($inventario->{'stockInicial'})) ? $inventario->{'stockInicial'} : NULL ;
				$sellin = (!empty($inventario->{'sellin'}) && isset($inventario->{'sellin'})) ? $inventario->{'sellin'} : NULL ;
				$stock = (!empty($inventario->{'stock'}) && isset($inventario->{'stock'})) ? $inventario->{'stock'} : NULL ;
				$validacion = (!empty($inventario->{'validacion'}) && isset($inventario->{'validacion'})) ? $inventario->{'validacion'} : NULL ;
				$obs = (!empty($inventario->{'obs'}) && isset($inventario->{'obs'})) ? $inventario->{'obs'} : NULL ;
				$comentario = (!empty($inventario->{'comentario'}) && isset($inventario->{'comentario'})) ? $inventario->{'comentario'} : NULL ;
				$fecVenc = (!empty($inventario->{'fecVenc'}) && isset($inventario->{'fecVenc'})) ? $inventario->{'fecVenc'} : NULL ;

				if ( !empty($stock_inicial) || !empty($sellin) || !empty($stock) || !empty($validacion) || !empty($obs) || !empty($comentario) || !empty($fecVenc)) {
					//VERIFICACIÓN DE EXISTENTE
					if ( empty($idVisitaInventarioDet)) {
						//INSERT DATA //NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaInventario = array('idVisita' => $idVisita);
						$selectVisitaInventario = $this->model->select_visita_inventario($arrayBusquedaInventario);

						if ( empty($selectVisitaInventario)) {
							//LA CABECERA NO EXISTE
							//INSERTAR CABECERA
							$arrayInsertInventario = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaInventario = $this->model->insert_visita_inventario($arrayInsertInventario);

							//INSERTAR DETALLE
							if ( $insertarVisitaInventario ) {
								//SE INSERTO LA CABECERA
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaInventario");
								$rowInsert++;
								

								$arrayInsertInventarioDet = array(
									'idVisitaInventario' => $insertId
									,'idProducto' => $idProducto
									,'stock_inicial' => $stock_inicial
									,'sellin' => $sellin
									,'stock' => $stock
									,'validacion' => $validacion
									,'obs' => $obs
									,'comentario' => $comentario
									,'fecVenc' => $fecVenc
								);
								$insertarVisitaInventarioDet = $this->model->insert_visita_inventario_detalle($arrayInsertInventarioDet);	
							} else {
								//NO SE INSERTO LA CABECERA
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';
							}
						} else {
							//LA CABCERA EXISTE
							//INSERTAMOS EL DETALLE INVENTARIO
							$idVisitaInventario = $selectVisitaInventario[0]['idVisitaInventario'];

							$arrayInsertInventarioDet = array(
								'idVisitaInventario' => $idVisitaInventario
								,'idProducto' => $idProducto
								,'stock_inicial' => $stock_inicial
								,'sellin' => $sellin
								,'stock' => $stock
								,'validacion' => $validacion
								,'obs' => $obs
								,'comentario' => $comentario
								,'fecVenc' => $fecVenc
							);
							$insertarVisitaInventarioDet = $this->model->insert_visita_inventario_detalle($arrayInsertInventarioDet);
						}
					
					} else {
						//UPDATE DATA
						//YA EXISTE EN LA BD
						$arrayParams = array(
							'stock_inicial' => $stock_inicial
							,'sellin' => $sellin
							,'stock' => $stock
							,'validacion' => $validacion
							,'obs' => $obs
							,'comentario' => $comentario
							,'fecVenc' => $fecVenc
						);
						$arrayWhere = array(
							'idVisitaInventarioDet' => $idVisitaInventarioDet
						);
						$arrayUpdateInventarioDet['arrayParams'] = $arrayParams;
						$arrayUpdateInventarioDet['arrayWhere'] = $arrayWhere;

						$updateVisitaEncartesDet = $this->model->update_visita_inventario_detalle($arrayUpdateInventarioDet);
						$rowUpdated++;
					}
				}
			}

			$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'inventario');
		} else {
			$content .= $this->htmlNoResultado;
		}

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR INVENTARIO';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarMantenimiento(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = ( isset($data->{'idVisita'}) && !empty($data->{'idVisita'}) ) ? $data->{'idVisita'} : NULL;
		$idVisitaMantCliente = ( isset($data->{'idVisitaMantCliente'}) && !empty($data->{'idVisitaMantCliente'}) ) ? $data->{'idVisitaMantCliente'} : NULL;
		$codCliente = ( isset($data->{'codCliente'}) && !empty($data->{'codCliente'}) ) ? $data->{'codCliente'} : NULL;
		$nombreComercial = ( isset($data->{'nombreComercial'}) && !empty($data->{'nombreComercial'}) ) ? $data->{'nombreComercial'} : NULL;
		$razonSocial = ( isset($data->{'razonSocial'}) && !empty($data->{'razonSocial'}) ) ? $data->{'razonSocial'} : NULL;
		$ruc = ( isset($data->{'ruc'}) && !empty($data->{'ruc'}) ) ? $data->{'ruc'} : NULL;
		$dni = ( isset($data->{'dni'}) && !empty($data->{'dni'}) ) ? $data->{'dni'} : NULL;
		//$cod_departamento = $data->{'cod_departamento'};
		//$cod_departamento = $data->{'cod_provincia'};
		//$cod_departamento = $data->{'cod_distrito'};
		$direccion = ( isset($data->{'direccion'}) && !empty($data->{'direccion'}) ) ? $data->{'direccion'} : NULL;
		$cod_ubigeo = ( isset($data->{'cod_ubigeo'}) && !empty($data->{'cod_ubigeo'}) ) ? $data->{'cod_ubigeo'} : NULL;
		$latitud = ( isset($data->{'latitud'}) && !empty($data->{'latitud'}) ) ? $data->{'latitud'} : NULL;
		$longitud = ( isset($data->{'longitud'}) && !empty($data->{'longitud'}) ) ? $data->{'longitud'} : NULL;

		$rowUpdated=0; $rowInsert=0;
		$content='';

		if ( empty($idVisitaMantCliente)) {
			//INSERTAMOS NUEVA DATA
			$arrayInsertMantCliente = array(
				'idVisita' => $idVisita
				,'hora' => date('H:i:s')
				,'codCliente' => $codCliente
				,'nombreComercial' => $nombreComercial
				,'razonSocial' => $razonSocial
				,'ruc' => $ruc
				,'dni' => $dni
				,'cod_ubigeo' => $cod_ubigeo
				,'direccion' => $direccion
				,'latitud' => $latitud
				,'longitud' => $longitud
				,'estado' => 1
			);
			$insertarVisitaMantCliente = $this->model->insert_visita_mantenimientoCliente($arrayInsertMantCliente);
			$rowInsert++;
		} else {
			//CAMBIAMOS ESTADO DE VISITAS ANTERIORES
			$arrayParams = array('estado' => 0);
			$arrayWhere = array('idVisita' => $idVisita);
			$arrayUpdateMantCliente['arrayParams'] = $arrayParams;
			$arrayUpdateMantCliente['arrayWhere'] = $arrayWhere;
			//var_dump($arrayUpdateProductoDet);
			$updateVisitaMantCliente = $this->model->update_visita_mantenimientoCliente($arrayUpdateMantCliente);
			$rowUpdated++;

			//INSERTAMOS NUEVA DATA
			$arrayInsertMantCliente = array(
				'idVisita' => $idVisita
				,'hora' => date('H:i:s')
				,'codCliente' => $codCliente
				,'nombreComercial' => $nombreComercial
				,'razonSocial' => $razonSocial
				,'ruc' => $ruc
				,'dni' => $dni
				,'cod_ubigeo' => $cod_ubigeo
				,'direccion' => $direccion
				,'latitud' => $latitud
				,'longitud' => $longitud
				,'estado' => 1
			);
			$insertarVisitaMantCliente = $this->model->insert_visita_mantenimientoCliente($arrayInsertMantCliente);
		}		

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'mantenimiento');

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR DESPACHOS';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarCompetencias(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataCompetencias = $data->{'dataCompetencias'};
		$dataCompetenciaFotos = json_decode(json_encode($data->{'dataCompetenciaFotos'}), true);
		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';

		if ( !empty($dataCompetencias)) {
			foreach ($dataCompetencias as $kp => $competencias) {
				$visitaInteligencia = (!empty($competencias->{'visitaInteligencia'}) && isset($competencias->{'visitaInteligencia'})) ? $competencias->{'visitaInteligencia'} : NULL ;
				$idVisitaInteligenciaTradDet = (!empty($competencias->{'visitaInteligenciaCompetitiva'}) && isset($competencias->{'visitaInteligenciaCompetitiva'})) ? $competencias->{'visitaInteligenciaCompetitiva'} : NULL ;
				$idCategoria = (!empty($competencias->{'categoria'}) && isset($competencias->{'categoria'})) ? $competencias->{'categoria'} : NULL ;
				$idMarca = (!empty($competencias->{'marca'}) && isset($competencias->{'marca'})) ? $competencias->{'marca'} : NULL ;
				$idTipoCompetencia = (!empty($competencias->{'tipoCompetencia'}) && isset($competencias->{'tipoCompetencia'})) ? $competencias->{'tipoCompetencia'} : NULL ;
				$comentario = (!empty($competencias->{'comentario'}) && isset($competencias->{'comentario'})) ? $competencias->{'comentario'} : NULL ;
				$foto = (!empty($competencias->{'foto'}) && isset($competencias->{'foto'})) ? $competencias->{'foto'} : NULL ;
				$idVisitaFoto = NULL;
				
				//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
				if ( !empty($idTipoCompetencia) || !empty($comentario) || !empty($foto)) {
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataCompetenciaFotos[$idVisitaInteligenciaTradDet]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataCompetenciaFotos[$idVisitaInteligenciaTradDet]
							,'hora' => date('H:i:s')
							,'idModulo' => 23
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}

					//VERIFICACIÓN DE GUARDADO
					if ( $visitaInteligencia==1 ) {
						//YA ESXISTE EN LA BD
						$arrayParams = array(
							'idCategoria' => $idCategoria
							,'idMarca' => $idMarca
							,'idTipoCompetencia' => $idTipoCompetencia
							,'comentario' => $comentario
							//,'idVisitaFoto' => $idVisitaFoto
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;

						$arrayWhere = array(
							'idVisitaInteligenciaTradDet' => $idVisitaInteligenciaTradDet
						);
						$arrayUpdateInteligenciaTradDet['arrayParams'] = $arrayParams;
						$arrayUpdateInteligenciaTradDet['arrayWhere'] = $arrayWhere;

						$updateVisitaInteligenciaTradDet = $this->model->update_visita_inteligenciaTrad_detalle($arrayUpdateInteligenciaTradDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaInteligencia = array('idVisita' => $idVisita);
						$selectVisitaInteligencia = $this->model->select_visita_inteligencia($arrayBusquedaInteligencia);

						if ( empty($selectVisitaInteligencia)) {
							//INSERTAR CABECERA
							$arrayInsertInteligenciaTrad = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaInteligenciaTrad = $this->model->insert_visita_inteligenciaTrad($arrayInsertInteligenciaTrad);

							//INSERTAR DETALLE
							if ( $insertarVisitaInteligenciaTrad ) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad");
								$rowInsert++;

								$arrayInsertInteligenciaTradDet = array(
									'idVisitaInteligenciaTrad' => $insertId
									,'idCategoria' => $idCategoria
									,'idMarca' => $idMarca
									,'idTipoCompetencia' => $idTipoCompetencia
									,'comentario' => $comentario
									//,'idVisitaFoto' => $idVisitaFoto
								);
								if ( !empty($idVisitaFoto)) $arrayInsertInteligenciaTradDet['idVisitaFoto'] = $idVisitaFoto;

								$insertarVisitaInteligenciaTradDet = $this->model->insert_visita_inteligenciaTrad_detalle($arrayInsertInteligenciaTradDet);	
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
							}

						} else {
							//INSERTAR DETALLE INTELIGENCIA COMPETETIVIA
							$idVisitaInteligenciaTrad = $selectVisitaInteligencia[0]['idVisitaInteligenciaTrad'];

							$arrayInsertInteligenciaTradDet = array(
								'idVisitaInteligenciaTrad' => $idVisitaInteligenciaTrad
								,'idCategoria' => $idCategoria
								,'idMarca' => $idMarca
								,'idTipoCompetencia' => $idTipoCompetencia
								,'comentario' => $comentario
								//,'idVisitaFoto' => $idVisitaFoto
							);
							if ( !empty($idVisitaFoto)) $arrayInsertInteligenciaTradDet['idVisitaFoto'] = $idVisitaFoto;

							$insertarVisitaInteligenciaTradDet = $this->model->insert_visita_inteligenciaTrad_detalle($arrayInsertInteligenciaTradDet);	
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'inteligencia');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR INTELIGENCIA COMPETITIVA';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarOrdenes(){
		$result = $this->result;
		$dataTotal = json_decode($this->input->post('data'));

		$data = $dataTotal->{'dataOrden'};
		$dataOrdenFotos = json_decode(json_encode($dataTotal->{'dataOrdenFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';

		$idVisita = $data->{'idVisita'};
		$idVisitaOrden = ( isset($data->{'idVisitaOrden'}) && !empty($data->{'idVisitaOrden'}) ) ? $data->{'idVisitaOrden'} : NULL;
		$idOrden = ( isset($data->{'tipoOrden'}) && !empty($data->{'tipoOrden'}) ) ? $data->{'tipoOrden'} : NULL;
		$flagOtro = ( isset($data->{'otro'}) && !empty($data->{'otro'}) ) ? $data->{'otro'} : NULL;
		$descripcion = ( isset($data->{'descripcion'}) && !empty($data->{'descripcion'}) ) ? $data->{'descripcion'} : NULL;
		$idOrdenEstado = ( isset($data->{'estadoOrden'}) && !empty($data->{'estadoOrden'}) ) ? $data->{'estadoOrden'} : NULL;
		$foto = ( isset($data->{'fotoprincipal'}) && !empty($data->{'fotoprincipal'}) ) ? $data->{'fotoprincipal'} : NULL;
		$idVisitaFoto = NULL;

		//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
		if ( !empty($idOrden) || !empty($flagOtro)) {
			//VERIFICACIÓN DE FOTOS
			if ( isset($dataOrdenFotos[1]) ) {
				//
				$arrayInsertVisitaFoto = array(
					'idVisita' => $idVisita
					,'fotoUrl' => $dataOrdenFotos[1]
					,'hora' => date('H:i:s')
					,'idModulo' => 25
				);

				$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
				if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
				else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
			}

			//VERIFICACIÓN DE GUARDADO
			if ( !empty($idVisitaOrden)) {
				//YA ESXISTE EN LA BD
				$arrayParams = array(
					'idOrden' => $idOrden
					,'descripcion' => $descripcion
					,'idOrdenEstado' => $idOrdenEstado
					,'flagOtro' => !empty($flagOtro)?$flagOtro:0
				);
				if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
				$arrayWhere = array(
					'idVisitaOrden' => $idVisitaOrden
				);
				$arrayUpdateOrden['arrayParams'] = $arrayParams;
				$arrayUpdateOrden['arrayWhere'] = $arrayWhere;

				$updateVisitaOrden = $this->model->update_visita_orden($arrayUpdateOrden);
				$rowUpdated++;
			} else {
				//NO EXISTE EN LA BD
				//INSERTAMOS VALORES
				$arrayInsertOrden = array(
					'idVisita' => $idVisita
					,'idOrden' => $idOrden
					,'descripcion' => $descripcion
					,'idOrdenEstado' => $idOrdenEstado
					,'flagOtro' => !empty($flagOtro)?$flagOtro:0
				);
				if ( !empty($idVisitaFoto)) $arrayInsertOrden['idVisitaFoto'] = $idVisitaFoto;
				$insertarVisitaOrden = $this->model->insert_visita_orden($arrayInsertOrden);
				$rowInsert++;
			}
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'ordenes');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR ORDEN DE TRABAJO';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarVisibilidad(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataVisibilidadTrad = $data->{'dataVisibilidadTrad'};
		$dataVisibilidadTradFotos = json_decode(json_encode($data->{'dataVisibilidadTradFotos'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';

		if ( !empty($dataVisibilidadTrad)) {
			foreach ($dataVisibilidadTrad as $kvt => $visibilidades) {
				$visitaVisibilidad = (!empty($visibilidades->{'visitaVisibilidad'}) && isset($visibilidades->{'visitaVisibilidad'})) ? $visibilidades->{'visitaVisibilidad'} : NULL ;
				$idVisitaVisibilidadDet = (!empty($visibilidades->{'visitaVisibilidadDet'}) && isset($visibilidades->{'visitaVisibilidadDet'})) ? $visibilidades->{'visitaVisibilidadDet'} : NULL ;
				$idElementoVis = (!empty($visibilidades->{'elementoVisibilidad'}) && isset($visibilidades->{'elementoVisibilidad'})) ? $visibilidades->{'elementoVisibilidad'} : NULL ;
				$condicion_elemento = (!empty($visibilidades->{'condicion'}) && isset($visibilidades->{'condicion'})) ? $visibilidades->{'condicion'} : NULL ;
				$presencia = (!empty($visibilidades->{'presencia'}) && isset($visibilidades->{'presencia'})) ? $visibilidades->{'presencia'} : NULL ;
				$cantidad = (!empty($visibilidades->{'cantidad'}) && isset($visibilidades->{'cantidad'})) ? $visibilidades->{'cantidad'} : NULL ;
				$idEstadoElemento = (!empty($visibilidades->{'estadoElemento'}) && isset($visibilidades->{'estadoElemento'})) ? $visibilidades->{'estadoElemento'} : NULL ;
				$foto = (!empty($visibilidades->{'foto'}) && isset($visibilidades->{'foto'})) ? $visibilidades->{'foto'} : NULL ;
				$idVisitaFoto = NULL;

				//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
				if ( !empty($presencia) || !empty($cantidad) || !empty($idEstadoElemento) ) {
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataVisibilidadTradFotos[$idVisitaVisibilidadDet]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataVisibilidadTradFotos[$idVisitaVisibilidadDet]
							,'hora' => date('H:i:s')
							,'idModulo' => 1
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}

					//VERIFICACIÓN DE GUARDADO
					if ( $visitaVisibilidad==1) {
						//YA ESXISTE EN LA BD
						$arrayParams = array(
							'presencia' => $presencia
							,'cantidad' => $cantidad
							,'idEstadoElemento' => $idEstadoElemento
							,'condicion_elemento' => $condicion_elemento
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
						$arrayWhere = array(
							'idVisitaVisibilidadDet' => $idVisitaVisibilidadDet
						);
						$arrayUpdateVisibilidadTradDet['arrayParams'] = $arrayParams;
						$arrayUpdateVisibilidadTradDet['arrayWhere'] = $arrayWhere;

						$updateVisitaVisibilidadTradDet = $this->model->update_visita_visibilidadTrad_detalle($arrayUpdateVisibilidadTradDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaVisibilidadTrad = array('idVisita' => $idVisita);
						$selectVisitaVisibilidadTrad = $this->model->select_visita_visibilidadTrad($arrayBusquedaVisibilidadTrad);

						if ( empty($selectVisitaVisibilidadTrad)) {
							//INSERTAR CABECERA
							$arrayInsertVisibilidadTrad = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaVisibilidadTrad = $this->model->insert_visita_visibilidadTrad($arrayInsertVisibilidadTrad);

							//INSERTAR DETALLE
							if ( $insertarVisitaVisibilidadTrad) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad");
								$rowInsert++;

								$arrayInsertVisibilidadTradDet = array(
									'idVisitaVisibilidad' => $insertId
									,'idElementoVis' => $idElementoVis
									,'presencia' => $presencia
									,'cantidad' => $cantidad
									,'idEstadoElemento' => $idEstadoElemento
									,'condicion_elemento' => $condicion_elemento
								);
								if ( !empty($idVisitaFoto)) $arrayInsertVisibilidadTradDet['idVisitaFoto'] = $idVisitaFoto;
								$insertarVisitaVisibilidadTradDet = $this->model->insert_visita_visibilidadTrad_detalle($arrayInsertVisibilidadTradDet);	
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
							}
						} else {
							//INSERTAR DETALLE VISIBILIDAD TRADICIONAL
							$idVisitaVisibilidad = $selectVisitaVisibilidadTrad[0]['idVisitaVisibilidad'];

							$arrayInsertVisibilidadTradDet = array(
								'idVisitaVisibilidad' => $idVisitaVisibilidad
								,'idElementoVis' => $idElementoVis
								,'presencia' => $presencia
								,'cantidad' => $cantidad
								,'idEstadoElemento' => $idEstadoElemento
								,'condicion_elemento' => $condicion_elemento
							);
							if ( !empty($idVisitaFoto)) $arrayInsertVisibilidadTradDet['idVisitaFoto'] = $idVisitaFoto;
							$insertarVisitaVisibilidadTradDet = $this->model->insert_visita_visibilidadTrad_detalle($arrayInsertVisibilidadTradDet);	
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'visibilidad');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR VISIBILIDAD TRADICIONAL';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarIniciativaTrad(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataIniciativasTrad = $data->{'dataIniciativas'};
		$dataIniciativaTradFotos = json_decode(json_encode($data->{'dataIniciativaTradFotos'}), true);
		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';

		if ( !empty($dataIniciativasTrad)) {
			foreach ($dataIniciativasTrad as $kli => $iniciativas) {
				$idVisitaIniciativaTrad = (!empty($iniciativas->{'visitaIniciativaTrad'}) && isset($iniciativas->{'visitaIniciativaTrad'})) ? $iniciativas->{'visitaIniciativaTrad'} : NULL ;
				$idVisitaIniciativaTradDet = (!empty($iniciativas->{'visitaIniciativaTradDet'}) && isset($iniciativas->{'visitaIniciativaTradDet'})) ? $iniciativas->{'visitaIniciativaTradDet'} : NULL ;
				$idIniciativa = (!empty($iniciativas->{'iniciativa'}) && isset($iniciativas->{'iniciativa'})) ? $iniciativas->{'iniciativa'} : NULL ;
				$idElementoIniciativa = (!empty($iniciativas->{'elementoIniciativa'}) && isset($iniciativas->{'elementoIniciativa'})) ? $iniciativas->{'elementoIniciativa'} : NULL ;
				$presencia = (!empty($iniciativas->{'presencia'}) && isset($iniciativas->{'presencia'})) ? $iniciativas->{'presencia'} : NULL ;
				$cantidad = (!empty($iniciativas->{'cantidad'}) && isset($iniciativas->{'cantidad'})) ? $iniciativas->{'cantidad'} : NULL ;
				$idEstadoIniciativa = (!empty($iniciativas->{'estadoIniciativa'}) && isset($iniciativas->{'estadoIniciativa'})) ? $iniciativas->{'estadoIniciativa'} : NULL ;
				$producto = (!empty($iniciativas->{'producto'}) && isset($iniciativas->{'producto'})) ? $iniciativas->{'producto'} : NULL ;
				$foto = (!empty($iniciativas->{'foto'}) && isset($iniciativas->{'foto'})) ? $iniciativas->{'foto'} : NULL ;
				$idVisitaFoto = NULL;
				$index = $idIniciativa.'-'.$idElementoIniciativa;

				//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
				if ( !empty($presencia) || !empty($cantidad) || !empty($idEstadoIniciativa) || !empty($producto) ) {
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataIniciativaTradFotos[$index]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataIniciativaTradFotos[$index]
							,'hora' => date('H:i:s')
							,'idModulo' => 22
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}

					//VERIFICACIÓN DE GUARDADO
					if ( !empty($idVisitaIniciativaTradDet)) {
						//YA ESXISTE EN LA BD
						$arrayParams = array(
							'presencia' => $presencia
							,'cantidad' => $cantidad
							,'idEstadoIniciativa' => $idEstadoIniciativa
							,'producto' => $producto
							//,'idVisitaFoto' => $idVisitaFoto
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;

						$arrayWhere = array(
							'idVisitaIniciativaTradDet' => $idVisitaIniciativaTradDet
						);
						$arrayUpdateIniciativasTradDet['arrayParams'] = $arrayParams;
						$arrayUpdateIniciativasTradDet['arrayWhere'] = $arrayWhere;

						$updateVisitaIniciativasTradDet = $this->model->update_visita_iniciativasTrad_detalle($arrayUpdateIniciativasTradDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaIniciativaTrad = array('idVisita' => $idVisita);
						$selectVisitaIniciativaTrad = $this->model->select_visita_iniciativaTrad($arrayBusquedaIniciativaTrad);

						if ( empty($selectVisitaIniciativaTrad)) {
							//INSERTAR CABECERA
							$arrayInsertIniciativaTrad = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaIniciativaTrad = $this->model->insert_visita_iniciativaTrad($arrayInsertIniciativaTrad);

							//INSERTAR DETALLE
							if ( $insertarVisitaIniciativaTrad) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad");
								$rowInsert++;

								$arrayInsertIniciativaTradDet = array(
									'idVisitaIniciativaTrad' => $insertId
									,'idIniciativa' => $idIniciativa
									,'idElementoIniciativa' => $idElementoIniciativa
									,'presencia' => $presencia
									,'cantidad' => $cantidad
									,'idEstadoIniciativa' => $idEstadoIniciativa
									,'producto' => $producto
									//,'idVisitaFoto' => $idVisitaFoto
								);
								if ( !empty($idVisitaFoto)) $arrayInsertIniciativaTradDet['idVisitaFoto'] = $idVisitaFoto;

								$insertarVisitaIniciativaTradDet = $this->model->insert_visita_iniciativaTrad_detalle($arrayInsertIniciativaTradDet);	
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
							}
						} else {
							//INSERTAR DETALLE VISIBILIDAD TRADICIONAL
							$idVisitaIniciativaTrad = $selectVisitaIniciativaTrad[0]['idVisitaIniciativaTrad'];

							$arrayInsertIniciativaTradDet = array(
								'idVisitaIniciativaTrad' => $idVisitaIniciativaTrad
								,'idIniciativa' => $idIniciativa
								,'idElementoIniciativa' => $idElementoIniciativa
								,'presencia' => $presencia
								,'cantidad' => $cantidad
								,'idEstadoIniciativa' => $idEstadoIniciativa
								,'producto' => $producto
								//,'idVisitaFoto' => $idVisitaFoto
							);
							if ( !empty($idVisitaFoto)) $arrayInsertIniciativaTradDet['idVisitaFoto'] = $idVisitaFoto;

							$insertarVisitaIniciativaTradDet = $this->model->insert_visita_iniciativaTrad_detalle($arrayInsertIniciativaTradDet);	
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'iniciativa');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR INICIATIVA TRADICIONAL';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarVisibilidadAuditoriaObligatoria(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataVisibilidadObligatoria = $data->{'dataVisibilidadObligatoria'};
		$dataVisibilidadObligatoriaFotos = json_decode(json_encode($data->{'dataVisibilidadObligatoriaFotos'}), true);
		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0; $content='';

		if ( !empty($dataVisibilidadObligatoria)) {
			foreach ($dataVisibilidadObligatoria as $klvo => $visibilidades) {
				$idVisitaVisibilidad = (!empty($visibilidades->{'visitaVisibilidad'}) && isset($visibilidades->{'visitaVisibilidad'})) ? $visibilidades->{'visitaVisibilidad'} : NULL ;
				$idVisitaVisibilidadDet = (!empty($visibilidades->{'visitaVisibilidadDet'}) && isset($visibilidades->{'visitaVisibilidadDet'})) ? $visibilidades->{'visitaVisibilidadDet'} : NULL ;
				$idElementoVis = (!empty($visibilidades->{'elementoVisibilidad'}) && isset($visibilidades->{'elementoVisibilidad'})) ? $visibilidades->{'elementoVisibilidad'} : NULL ;
				$idVariable = (!empty($visibilidades->{'variable'}) && isset($visibilidades->{'variable'})) ? $visibilidades->{'variable'} : NULL ;
				$cantidad = (!empty($visibilidades->{'cantidad'}) && isset($visibilidades->{'cantidad'})) ? $visibilidades->{'cantidad'} : NULL ;
				$presencia = (!empty($visibilidades->{'presencia'}) && isset($visibilidades->{'presencia'})) ? $visibilidades->{'presencia'} : NULL ;
				$idObservacion = (!empty($visibilidades->{'observacion'}) && isset($visibilidades->{'observacion'})) ? $visibilidades->{'observacion'} : NULL ;
				$comentario = (!empty($visibilidades->{'comentario'}) && isset($visibilidades->{'comentario'})) ? $visibilidades->{'comentario'} : NULL ;
				$idVisitaFoto = NULL;

				//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
				if ( !empty($presencia) || !empty($cantidad) || !empty($idObservacion) || !empty($comentario) ) {
					
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataVisibilidadObligatoriaFotos[$idElementoVis.'-'.$idVariable]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataVisibilidadObligatoriaFotos[$idElementoVis.'-'.$idVariable]
							,'hora' => date('H:i:s')
							,'idModulo' => 27
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}
					//

					//VERIFICACIÓN DE GUARDADO
					if ( !empty($idVisitaVisibilidadDet)) {
						//YA ESXISTE EN LA BD
						$arrayParams = array(
							'presencia' => !empty($presencia)?$presencia:0
							,'cantidad' => $cantidad
							,'idObservacion' => $idObservacion
							,'comentario' => $comentario
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
						$arrayWhere = array(
							'idVisitaVisibilidadDet' => $idVisitaVisibilidadDet
						);
						$arrayUpdateVisibilidadObligatoriaDet['arrayParams'] = $arrayParams;
						$arrayUpdateVisibilidadObligatoriaDet['arrayWhere'] = $arrayWhere;

						$updateVisitaVisibilidadObligatoriaDet = $this->model->update_visita_visibilidadObligatoria_detalle($arrayUpdateVisibilidadObligatoriaDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaVisibilidadObligatoria = array('idVisita' => $idVisita);
						$selectVisitaVisibilidadObligatoria = $this->model->select_visita_visibilidadObligatoria($arrayBusquedaVisibilidadObligatoria);

						if ( empty($selectVisitaVisibilidadObligatoria)) {
							//INSERTAR CABECERA
							$arrayInsertVisibilidadObligatoria = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaVisibilidadObligatoria = $this->model->insert_visita_visibilidadObligatoria($arrayInsertVisibilidadObligatoria);

							//INSERTAR DETALLE
							if ( $insertarVisitaVisibilidadObligatoria) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio");
								$rowInsert++;

								$arrayInsertVisibilidadObligatoriaDet = array(
									'idVisitaVisibilidad' => $insertId
									,'idElementoVis' => $idElementoVis
									,'idVariable' => $idVariable
									,'presencia' => !empty($presencia)?$presencia:0
									,'idObservacion' => $idObservacion
									,'comentario' => $comentario
									,'cantidad' => $cantidad
									,'idVisitaFoto' => $idVisitaFoto
								);
								$insertarVisitaVisibilidadObligatoriaDet = $this->model->insert_visita_visibilidadObligatoria_detalle($arrayInsertVisibilidadObligatoriaDet);
								$rowInsert++;
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
							}
						} else {
							//INSERTAR DETALLE VISIBILIDAD OBLIGATORIA
							$idVisitaVisibilidad = $selectVisitaVisibilidadObligatoria[0]['idVisitaVisibilidad'];

							$arrayInsertVisibilidadObligatoriaDet = array(
								'idVisitaVisibilidad' => $idVisitaVisibilidad
								,'idElementoVis' => $idElementoVis
								,'idVariable' => $idVariable
								,'presencia' => !empty($presencia)?$presencia:0
								,'idObservacion' => $idObservacion
								,'comentario' => $comentario
								,'cantidad' => $cantidad
								,'idVisitaFoto' => $idVisitaFoto
							);
							$insertarVisitaVisibilidadObligatoriaDet = $this->model->insert_visita_visibilidadObligatoria_detalle($arrayInsertVisibilidadObligatoriaDet);
							$rowInsert++;	
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'visibilidad_aud');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR VISIBILIDAD AUDITORIA OBLIGATORIA';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarVisibilidadAuditoriaIniciativa(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataVisibilidadIniciativa = $data->{'dataVisibilidadIniciativa'};
		$dataVisibilidadIniciativaFotos = json_decode(json_encode($data->{'dataVisibilidadIniciativaFotos'}), true);
		$rowUpdated = 0; $rowInsert=0;$rowInsertFotoError=0; $content='';

		if ( !empty($dataVisibilidadIniciativa)) {
			foreach ($dataVisibilidadIniciativa as $klvi => $visibilidades) {
				$idVisitaVisibilidad = (!empty($visibilidades->{'visitaVisibilidad'}) && isset($visibilidades->{'visitaVisibilidad'})) ? $visibilidades->{'visitaVisibilidad'} : NULL ;
				$idVisitaVisibilidadDet = (!empty($visibilidades->{'visitaVisibilidadDet'}) && isset($visibilidades->{'visitaVisibilidadDet'})) ? $visibilidades->{'visitaVisibilidadDet'} : NULL ;
				$idElementoVis = (!empty($visibilidades->{'elementoVisibilidad'}) && isset($visibilidades->{'elementoVisibilidad'})) ? $visibilidades->{'elementoVisibilidad'} : NULL ;
				$presencia = (!empty($visibilidades->{'presencia'}) && isset($visibilidades->{'presencia'})) ? $visibilidades->{'presencia'} : NULL ;
				$idObservacion = (!empty($visibilidades->{'observacion'}) && isset($visibilidades->{'observacion'})) ? $visibilidades->{'observacion'} : NULL ;
				$comentario = (!empty($visibilidades->{'comentario'}) && isset($visibilidades->{'comentario'})) ? $visibilidades->{'comentario'} : NULL ;
				$idVisitaFoto = NULL;

				//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
				if ( !empty($presencia) || !empty($idObservacion) || !empty($comentario) ) {
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataVisibilidadIniciativaFotos[$idElementoVis]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataVisibilidadIniciativaFotos[$idElementoVis]
							,'hora' => date('H:i:s')
							,'idModulo' => 27
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}
					//

					//VERIFICACIÓN DE GUARDADO
					if ( !empty($idVisitaVisibilidadDet)) {
						//YA ESXISTE EN LA BD
						$arrayParams = array(
							'presencia' => !empty($presencia)?$presencia:0
							,'idObservacion' => $idObservacion
							,'comentario' => $comentario
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
						$arrayWhere = array(
							'idVisitaVisibilidadDet' => $idVisitaVisibilidadDet
						);
						$arrayUpdateVisibilidaIniciativaDet['arrayParams'] = $arrayParams;
						$arrayUpdateVisibilidaIniciativaDet['arrayWhere'] = $arrayWhere;

						$updateVisitaVisibilidadIniciativaDet = $this->model->update_visita_visibilidadIniciativa_detalle($arrayUpdateVisibilidaIniciativaDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaVisibilidadIniciativa = array('idVisita' => $idVisita);
						$selectVisitaVisibilidadIniciativa = $this->model->select_visita_visibilidadIniciativa($arrayBusquedaVisibilidadIniciativa);

						if ( empty($selectVisitaVisibilidadIniciativa)) {
							//INSERTAR CABECERA
							$arrayInsertVisibilidadIniciativa = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaVisibilidadIniciativa = $this->model->insert_visita_visibilidadIniciativa($arrayInsertVisibilidadIniciativa);

							//INSERTAR DETALLE
							if ( $insertarVisitaVisibilidadIniciativa) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa");
								$rowInsert++;

								$arrayInsertVisibilidadIniciativaDet = array(
									'idVisitaVisibilidad' => $insertId
									,'idElementoVis' => $idElementoVis
									,'presencia' => !empty($presencia)?$presencia:0
									,'idObservacion' => $idObservacion
									,'comentario' => $comentario
									,'idVisitaFoto' => $idVisitaFoto
								);
								$insertarVisitaVisibilidadIniciativaDet = $this->model->insert_visita_visibilidadIniciativa_detalle($arrayInsertVisibilidadIniciativaDet);	
								$rowInsert++;
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
							}
						} else {
							//INSERTAR DETALLE VISIBILIDAD INICIATIVA
							$idVisitaVisibilidad = $selectVisitaVisibilidadIniciativa[0]['idVisitaVisibilidad'];

							$arrayInsertVisibilidadIniciativaDet = array(
								'idVisitaVisibilidad' => $idVisitaVisibilidad
								,'idElementoVis' => $idElementoVis
								,'presencia' => !empty($presencia)?$presencia:0
								,'idObservacion' => $idObservacion
								,'comentario' => $comentario
								,'idVisitaFoto' => $idVisitaFoto
							);
							$insertarVisitaVisibilidadIniciativaDet = $this->model->insert_visita_visibilidadIniciativa_detalle($arrayInsertVisibilidadIniciativaDet);	
							$rowInsert++;
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'visibilidad_aud');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR VISIBILIDAD AUDITORIA INICIATIVA';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarVisibilidadAuditoriaAdicional(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataVisibilidadAdicional = $data->{'dataVisibilidadAdicional'};
		$dataVisibilidadAdicionalFotos = json_decode(json_encode($data->{'dataVisibilidadAdicionalFotos'}), true);
		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0; $content='';
		$content='';

		if ( !empty($dataVisibilidadAdicional)) {
			foreach ($dataVisibilidadAdicional as $klva => $visibilidades) {
				$idVisitaVisibilidad = (!empty($visibilidades->{'visitaVisibilidad'}) && isset($visibilidades->{'visitaVisibilidad'})) ? $visibilidades->{'visitaVisibilidad'} : NULL ;
				$idVisitaVisibilidadDet = (!empty($visibilidades->{'visitaVisibilidadDet'}) && isset($visibilidades->{'visitaVisibilidadDet'})) ? $visibilidades->{'visitaVisibilidadDet'} : NULL ;
				$idElementoVis = (!empty($visibilidades->{'elementoVisibilidad'}) && isset($visibilidades->{'elementoVisibilidad'})) ? $visibilidades->{'elementoVisibilidad'} : NULL ;
				$presencia = (!empty($visibilidades->{'presencia'}) && isset($visibilidades->{'presencia'})) ? $visibilidades->{'presencia'} : NULL ;
				$cantidad = (!empty($visibilidades->{'cantidad'}) && isset($visibilidades->{'cantidad'})) ? $visibilidades->{'cantidad'} : NULL ;
				$comentario = (!empty($visibilidades->{'comentario'}) && isset($visibilidades->{'comentario'})) ? $visibilidades->{'comentario'} : NULL ;
				$idVisitaFoto = NULL;

				//VERIFICACIÓN EXISTE DATA EN ALGUNOS DE LOS DETALLES
				if ( !empty($presencia) || !empty($cantidad) || !empty($comentario) ) {
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataVisibilidadAdicionalFotos[$idElementoVis]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataVisibilidadAdicionalFotos[$idElementoVis]
							,'hora' => date('H:i:s')
							,'idModulo' => 27
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}
					//

					//VERIFICACIÓN DE GUARDADO
					if ( !empty($idVisitaVisibilidadDet)) {
						//YA ESXISTE EN LA BD
						$arrayParams = array(
							'presencia' => !empty($presencia)?$presencia:0
							,'cant' => $cantidad
							,'comentario' => $comentario
						);
						if ( !empty($idVisitaFoto)) $arrayParams['idVisitaFoto'] = $idVisitaFoto;
						$arrayWhere = array(
							'idVisitaVisibilidadDet' => $idVisitaVisibilidadDet
						);
						$arrayUpdateVisibilidaAdicionalDet['arrayParams'] = $arrayParams;
						$arrayUpdateVisibilidaAdicionalDet['arrayWhere'] = $arrayWhere;

						$updateVisitaVisibilidadVisibilidadDet = $this->model->update_visita_visibilidadAdicional_detalle($arrayUpdateVisibilidaAdicionalDet);
						$rowUpdated++;
					} else {
						//NO EXISTE EN LA BD
						//BUSCAR CABECERA
						$arrayBusquedaVisibilidadAdicional = array('idVisita' => $idVisita);
						$selectVisitaVisibilidadAdicional = $this->model->select_visita_visibilidadAdicional($arrayBusquedaVisibilidadAdicional);

						if ( empty($selectVisitaVisibilidadAdicional)) {
							//INSERTAR CABECERA
							$arrayInsertVisibilidadAdicional = array('idVisita'=>$idVisita, 'hora' => date('H:i:s'));
							$insertarVisitaVisibilidadAdicional = $this->model->insert_visita_visibilidadAdicional($arrayInsertVisibilidadAdicional);

							//INSERTAR DETALLE
							if ( $insertarVisitaVisibilidadAdicional) {
								$insertId = $this->db->insert_id();
								$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional");
								$rowInsert++;

								$arrayInsertVisibilidadAdicionalDet = array(
									'idVisitaVisibilidad' => $insertId
									,'idElementoVis' => $idElementoVis
									,'presencia' => !empty($presencia)?$presencia:0
									,'cant' => $cantidad
									,'comentario' => $comentario
									,'idVisitaFoto' => $idVisitaFoto
								);
								$insertarVisitaVisibilidadAdicionalDet = $this->model->insert_visita_visibilidadAdicional_detalle($arrayInsertVisibilidadAdicionalDet);
								$rowInsert++;	
							} else {
								$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
							}
						} else {
							//INSERTAR DETALLE VISIBILIDAD INICIATIVA
							$idVisitaVisibilidad = $selectVisitaVisibilidadAdicional[0]['idVisitaVisibilidad'];

							$arrayInsertVisibilidadAdicionalDet = array(
								'idVisitaVisibilidad' => $idVisitaVisibilidad
								,'idElementoVis' => $idElementoVis
								,'presencia' => !empty($presencia)?$presencia:0
								,'cant' => $cantidad
								,'comentario' => $comentario
								,'idVisitaFoto' => $idVisitaFoto
							);
							//var_dump($arrayInsertVisibilidadAdicionalDet);
							$insertarVisitaVisibilidadAdicionalDet = $this->model->insert_visita_visibilidadAdicional_detalle($arrayInsertVisibilidadAdicionalDet);	
							$rowInsert++;
						}
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'visibilidad_aud');
		$content .= $this->generarMensajeAlmacenanmientoFotos($rowInsertFotoError);

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR VISIBILIDAD AUDITORIA ADICIONAL';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

	public function guardarEncuestaPremio(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idVisita = $data->{'idVisita'};
		$dataVisitaEncuestaPremio = $data->{'dataVisitaEncuestaPremio'};
		$dataEncuestaPremioFoto = json_decode(json_encode($data->{'dataEncuestaPremioFoto'}), true);

		$rowUpdated = 0; $rowInsert=0; $rowInsertFotoError=0;
		$content='';

		if ( !empty($dataVisitaEncuestaPremio)) {
			//CAMBIAR ESTADO CERO TIPO PREGUNTA 3
			$updateVisitaEncuestaDetalleTipo3 = $this->model->update_visita_encuestaPremio_detalle_tipo3($idVisita);

			foreach ($dataVisitaEncuestaPremio as $ke => $encuestas) {
				$idEncuesta = (!empty($encuestas->{'encuesta'}) && isset($encuestas->{'encuesta'})) ? $encuestas->{'encuesta'} : NULL ;
				$idTipoPregunta = (!empty($encuestas->{'tipoPregunta'}) && isset($encuestas->{'tipoPregunta'})) ? $encuestas->{'tipoPregunta'} : NULL ;
				$idPregunta = (!empty($encuestas->{'pregunta'}) && isset($encuestas->{'pregunta'})) ? $encuestas->{'pregunta'} : NULL ;
				$respuesta = (!empty($encuestas->{'respuesta'}) && isset($encuestas->{'respuesta'})) ? $encuestas->{'respuesta'} : NULL ;
				$idVisitaFoto = NULL;

				//BUSCAMOS LA CABECERA
				$arrayBusquedaVisitaEncuesta = array('idVisita' => $idVisita, 'idEncuesta'=>$idEncuesta );
				$selectVisitaEncuesta = $this->model->select_visita_encuestaPremio($arrayBusquedaVisitaEncuesta);

				if ( empty($selectVisitaEncuesta)) {
					//NO EXISTE EN LA BASE DE DATOS
					//VERIFICACIÓN DE FOTOS
					if ( isset($dataEncuestaPremioFoto[$idEncuesta]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataEncuestaPremioFoto[$idEncuesta]
							,'hora' => date('H:i:s')
							,'idModulo' => 28
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }
					}
					//

					//INSERTAR CABECERA
					$arrayInsertVisitaEncuesta = array('idVisita'=>$idVisita, 'idEncuesta'=>$idEncuesta, 'hora' => date('H:i:s'));
					if ( !empty($idVisitaFoto)) $arrayInsertVisitaEncuesta['idVisitaFoto'] = $idVisitaFoto;
					$insertarVisitaEncuestaPremio = $this->model->insert_visita_encuestaPremio($arrayInsertVisitaEncuesta);

					//INSERTAR DETALLE
					if ( $insertarVisitaEncuestaPremio) {
						$insertId = $this->db->insert_id();
						$this->guardarAuditoria("{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio");
						$rowInsert++;

						$arrayInsertEncuestaPremio = array(
							'idVisitaEncuesta' => $insertId
							,'idPregunta' => $idPregunta
							,'respuesta' => $respuesta
						);
						$insertarVisitaEncuestaPremioDet = $this->model->insert_visita_encuestaPremio_detalle($arrayInsertEncuestaPremio);	
					} else {
						$content .= '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>NO SE LOGRO INGRESAR LA INFORMACIÓN.</div>';	
					}
				} else {
					$idVisitaEncuesta = $selectVisitaEncuesta[0]['idVisitaEncuesta'];

					//VERIFICACIÓN DE FOTOS
					if ( isset($dataEncuestaPremioFoto[$idEncuesta]) ) {
						//
						$arrayInsertVisitaFoto = array(
							'idVisita' => $idVisita
							,'fotoUrl' => $dataEncuestaPremioFoto[$idEncuesta]
							,'hora' => date('H:i:s')
							,'idModulo' => 28
						);

						$insertarVisitaFoto = $this->model->insert_visita_foto($arrayInsertVisitaFoto);
						if ($insertarVisitaFoto) { $idVisitaFoto =  $this->db->insert_id();	} 
						else { $idVisitaFoto = NULL; $rowInsertFotoError++; }

						//ACTUALZIAMOS LA CABECERA
						$arrayParams = array('idVisitaFoto' => $idVisitaFoto);
						$arrayWhere = array('idVisitaEncuesta' => $idVisitaEncuesta );

						$arrayUpdateEncuestaPremio['arrayParams'] = $arrayParams;
						$arrayUpdateEncuestaPremio['arrayWhere'] = $arrayWhere;

						$updateVisitaEncuestaPremio = $this->model->update_visita_encuesta_premio($arrayUpdateEncuestaPremio);
						$rowUpdated++;
					}
					//

					//BUSCAMOS LA PREGUNTA EN LOS DETALLES
					if ( $idTipoPregunta==1 || $idTipoPregunta==2) {
						//BUSCAMOS LOS DETALLES
						$arrayBusquedaVisitaEncuestaDetalle = array('idVisitaEncuesta' => $idVisitaEncuesta, 'idPregunta'=>$idPregunta );
						$selectVisitaEncuestaDetalle = $this->model->select_visita_encuestaPremio_detalle($arrayBusquedaVisitaEncuestaDetalle);

						if ( empty($selectVisitaEncuestaDetalle) ) {
							$arrayInsertEncuestaPremio = array(
								'idVisitaEncuesta' => $idVisitaEncuesta
								,'idPregunta' => $idPregunta
								,'respuesta' => $respuesta
							);
							$insertarVisitaEncuestaPremioDet = $this->model->insert_visita_encuestaPremio_detalle($arrayInsertEncuestaPremio);	
						} else {
							$idVisitaEncuestaDet = $selectVisitaEncuestaDetalle[0]['idVisitaEncuestaDet'];
							//YA ESXISTE EN LA BD
							$arrayParams = array('respuesta' => $respuesta);
							$arrayWhere = array('idVisitaEncuestaDet' => $idVisitaEncuestaDet);

							$arrayUpdateEncuestaPremioDet['arrayParams'] = $arrayParams;
							$arrayUpdateEncuestaPremioDet['arrayWhere'] = $arrayWhere;

							$updateVisitaEncuestaPremioDetalle = $this->model->update_visita_encuestaPremio_detalle($arrayUpdateEncuestaPremioDet);
							$rowUpdated++;
						}

					} elseif ( $idTipoPregunta==3) {
						//INSERTAMOS NUEVOS VALORES
						$arrayInsertEncuestaPremio = array(
							'idVisitaEncuesta' => $idVisitaEncuesta
							,'idPregunta' => $idPregunta
							,'respuesta' => $respuesta
						);
						$insertarVisitaEncuestaPremioDet = $this->model->insert_visita_encuestaPremio_detalle($arrayInsertEncuestaPremio);	
					}
				}
			}
		} else {
			$content .= $this->htmlNoResultado;
		}

		$content .= $this->generarMensajeResultado($rowInsert, $rowUpdated, $idVisita, 'premio');

		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'GUARDAR ENCUESTA PREMIO';
		$result['data']['html'] = $content;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}


	public function cargarData(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$array=array();
		$html='';
		$array['codUsuario'] = $data->{'codUsuario'};
		$array['usuario'] =$data->{'usuario'};
		$array['fecha'] =$data->{'fecha'};

		$html .= $this->load->view("modulos/configuraciones/contingencia/rutas/cargar_data", $array, true);
		//Result
		$result['result'] = 1;
		$result['msg']['title'] = 'CARGAR DATA VISITAS';
		$result['data']['html'] = $html; 
		echo json_encode($result);
	}

	public function cargarDataTabla(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		$idUsuario=1;

		if(isset($data->{'archivoData'})){

			$base_64=explode(",",$data->{'archivoData'});
			$urlTemporal="public/";

			if($base_64[0]=="data:application/octet-stream;base64"){

				$archivo = base64_decode( ($base_64[1]));
				$file_name = date("Ymd").date("hms"). '.db';
				file_put_contents($urlTemporal.$file_name, $archivo);

				$db = new SQLite3($urlTemporal.$file_name);

				$results = $db->query('SELECT * FROM acceso_table'); 
		
				$res_usuario=false;
				while($row = $results->fetchArray(SQLITE3_ASSOC)){ 
					if($idUsuario==$row['idUsuario']){
						$res_usuario=true;
						break;
					}
				}

				if($res_usuario){
					$array=array();
					$array_response=array();

					//visita
					$fecha = new DateTime($data->{'fecha'});
					$fecha=$fecha->format('Y-d-m');
					
					$results = $db->query('SELECT * FROM visitas WHERE idUsuario='.$idUsuario.' and fecha="'.$fecha.'"');

					while($row=$results->fetchArray(SQLITE3_ASSOC)){
						$array['visitas'][$row['idVisita']]=$row;
						
						$array_response['visitas'][$row['idVisita']]['canal']=$row['canal'];
						$array_response['visitas'][$row['idVisita']]['razonSocial']=$row['razonSocial'];
					}


					//visita
					if(isset($array['visitas'] )){
						foreach($array['visitas'] as $idVisita => $row_){

							//encuesta
							$cont=0;
							$results = $db->query('SELECT * FROM visita_encuesta WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_encuesta'][$idVisita][$row['id']]=$row; 
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_encuesta_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_encuesta_det'][$idVisita][$row['id']]=$row; 
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaEncuesta ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_encuesta'][$idVisita]['estado']=$rs_;
							$array_response['visita_encuesta'][$idVisita]['cant']=$cont;
	
	
							//ipp
							$cont=0;
							$results = $db->query('SELECT * FROM visita_ipp WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_ipp'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_ipp_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_ipp_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaIpp ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_ipp'][$idVisita]['estado']=$rs_;
							$array_response['visita_ipp'][$idVisita]['cant']=$cont;
	
	

							//CHECKLIST PRODUCTOS
							$cont=0;
							$results = $db->query('SELECT * FROM visita_producto WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_producto'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_producto_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_producto_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaProductos ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_producto'][$idVisita]['estado']=$rs_;
							$array_response['visita_producto'][$idVisita]['cant']=$cont;


							//PRECIOS
							$cont=0;
							$results = $db->query('SELECT * FROM visita_precio WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_precio'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_precio_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_precio_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaPrecios ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_precio'][$idVisita]['estado']=$rs_;
							$array_response['visita_precio'][$idVisita]['cant']=$cont;


							//PROMOCION
							$cont=0;
							$results = $db->query('SELECT * FROM visita_promociom WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_promocion'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_promocion_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_promocion_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaPromociones ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_promocion'][$idVisita]['estado']=$rs_;
							$array_response['visita_promocion'][$idVisita]['cant']=$cont;


							//SOS
							$cont=0;
							$results = $db->query('SELECT * FROM visita_sos WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_sos'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_sos_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_sos_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaSos ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_sos'][$idVisita]['estado']=$rs_;
							$array_response['visita_sos'][$idVisita]['cant']=$cont;
	
	

							//SOD
							$cont=0;
							$results = $db->query('SELECT * FROM visita_sod WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_sod'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_sod_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_sod_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaSod ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_sod'][$idVisita]['estado']=$rs_;
							$array_response['visita_sod'][$idVisita]['cant']=$cont;
	
	

							//ENCARTE
							$cont=0;
							$results = $db->query('SELECT * FROM visita_encarte WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_encarte'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_encarte_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_encarte_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaEncartes",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_encarte'][$idVisita]['estado']=$rs_;
							$array_response['visita_encarte'][$idVisita]['cant']=$cont;
	
	
							//SEGUIMIENTO PLAN
							$cont=0;
							$results = $db->query('SELECT * FROM visita_seguimiento_plan WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_seguimiento_plan'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_seguimiento_plan_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_seguimiento_plan_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_seguimiento_plan'][$idVisita]['estado']=$rs_;
							$array_response['visita_seguimiento_plan'][$idVisita]['cant']=$cont;
	
	
	
							//DESPACHOS
							$cont=0;
							$results = $db->query('SELECT * FROM visita_despacho WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_despacho'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_despacho_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_despacho_det'][$idVisita][$row['id']]=$row;
							}
							$results = $db->query('SELECT * FROM visita_despacho_dias WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_despacho_dias'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaDespachos ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_despacho'][$idVisita]['estado']=$rs_;
							$array_response['visita_despacho'][$idVisita]['cant']=$cont;
	
	
							//FOTOS
							$cont=0;
							$results = $db->query('SELECT * FROM visita_foto WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_foto'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaModuloFotos ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_foto'][$idVisita]['estado']=$rs_;
							$array_response['visita_foto'][$idVisita]['cant']=$cont;
	
	
	
	
							//INVENTARIO	
							$cont=0;
							$results = $db->query('SELECT * FROM visita_inventario WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_inventario'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_inventario_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_inventario_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaInventario ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_inventario'][$idVisita]['estado']=$rs_;
							$array_response['visita_inventario'][$idVisita]['cant']=$cont;
	
	
	
							//VISIBILIDAD
							$cont=0;
							$results = $db->query('SELECT * FROM visita_visibilidad_trad WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_trad'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_visibilidad_trad_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_trad_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_visibilidad_trad'][$idVisita]['estado']=$rs_;
							$array_response['visita_visibilidad_trad'][$idVisita]['cant']=$cont;
	
	
							//MANTENIMIENTO CLIENTE
							$cont=0;
							$results = $db->query('SELECT * FROM visita_mantenimiento_cliente WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_mantenimiento_cliente'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_mantenimiento_cliente'][$idVisita]['estado']=$rs_;
							$array_response['visita_mantenimiento_cliente'][$idVisita]['cant']=$cont;
	
	
							//INICIATIVAS
							$cont=0;
							$results = $db->query('SELECT * FROM visita_iniciativa WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_iniciativa'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_iniciativa_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_iniciativa_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_iniciativa'][$idVisita]['estado']=$rs_;
							$array_response['visita_iniciativa'][$idVisita]['cant']=$cont;
	
							
	
							//INTELIGENCIA COMPETITIVA 
							$cont=0;
							$results = $db->query('SELECT * FROM visita_inteligencia WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_inteligencia'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_inteligencia_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_inteligencia_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_inteligencia'][$idVisita]['estado']=$rs_;
							$array_response['visita_inteligencia'][$idVisita]['cant']=$cont;
	
	
	
	
							//ORDEN TRABAJO
							$cont=0;
							$results = $db->query('SELECT * FROM visita_orden WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_orden'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaOrden ",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_orden'][$idVisita]['estado']=$rs_;
							$array_response['visita_orden'][$idVisita]['cant']=$cont;
	
	
	
							//VISITA AUDITORIA
							//OBLIGATORIO
							$cont=0;
							$results = $db->query('SELECT * FROM visita_visibilidad_obligatorio WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_obligatorio'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_visibilidad_obligatorio_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_obligatorio_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_visibilidad_obligatorio'][$idVisita]['estado']=$rs_;
							$array_response['visita_visibilidad_obligatorio'][$idVisita]['cant']=$cont;
	
	
							//INICIATIVA
							$cont=0;
							$results = $db->query('SELECT * FROM visita_visibilidad_iniciativa WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_iniciativa'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_visibilidad_iniciativa_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_iniciativa_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_visibilidad_iniciativa'][$idVisita]['estado']=$rs_;
							$array_response['visita_visibilidad_iniciativa'][$idVisita]['cant']=$cont;
	
	
	
	
							//ADICIONAL
							$cont=0;
							$results = $db->query('SELECT * FROM visita_visibilidad_adicional WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_adicional'][$idVisita][$row['id']]=$row;
								$cont++;
							}
							$results = $db->query('SELECT * FROM visita_visibilidad_adicional_det WHERE idVisita='.$idVisita); 
							while($row=$results->fetchArray(SQLITE3_ASSOC)){
								$array['visita_visibilidad_adicional_det'][$idVisita][$row['id']]=$row;
							}
							//validar 
							$input=array(
								'tabla' =>"{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional",'arrayWhere'=>array('idVisita'=>$idVisita)
							);
							$rs_=$this->model->validar_existencia_modulo($input);
							$array_response['visita_visibilidad_adicional'][$idVisita]['estado']=$rs_;
							$array_response['visita_visibilidad_adicional'][$idVisita]['cant']=$cont;
	
						}

						//guardar registros del archivo termporalmente
						$this->session->set_userdata($array);

						$html='';
						$html .= $this->load->view("modulos/configuraciones/contingencia/rutas/cargar_data_tabla", $array_response, true);
						$result['result'] = 1;
						$result['msg']['title'] = 'CARGAR DATA VISITAS';
						$result['data']['html'] = $html;
					}else{
						$array=array();
						$html='';
						$html .= "No se encontraron resultados para la fecha seleccionada.";
						$result['result'] = 1;
						$result['msg']['title'] = 'CARGAR DATA VISITAS';
						$result['data']['html'] = $html;
					}
				}else{
					$array=array();
					$html='';
					$html .= "No se ha encontrado data del usuario seleccionado.";
					$result['result'] = 1;
					$result['msg']['title'] = 'CARGAR DATA VISITAS';
					$result['data']['html'] = $html;
				}
				$db->close();
				if (file_exists($urlTemporal.$file_name)) {
					unlink($urlTemporal.$file_name);
				}

			}else{
				$array=array();
				$html='';
				$html .= "Archivo incorrecto.Verifique que sea un archivo .db .";
				$result['result'] = 1;
				$result['msg']['title'] = 'CARGAR DATA VISITAS';
				$result['data']['html'] = $html;
			}
		}else{
			$array=array();
			$html='';
			$html .= "Archivo incorrecto.Verifique que sea un archivo .db .";
			$result['result'] = 1;
			$result['msg']['title'] = 'CARGAR DATA VISITAS';
			$result['data']['html'] = $html;
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}


	public function guardarDataTabla(){
		$result = $this->result;
		$data = json_decode($this->input->post('data'));

		//$idUsuario=$data->{'idUsuario'};
		$idUsuario=1;
 
		//cargar data temporal
		$visitas =$this->session->userdata('visitas');
		
		$visita_encuesta =$this->session->userdata('visita_encuesta');
		$visita_encuesta_det =$this->session->userdata('visita_encuesta_det');
		
		$visita_ipp =$this->session->userdata('visita_ipp');
		$visita_ipp_det =$this->session->userdata('visita_ipp_det');
		
		$visita_producto =$this->session->userdata('visita_producto');
		$visita_producto_det =$this->session->userdata('visita_producto_det');
		
		$visita_precio =$this->session->userdata('visita_precio');
		$visita_precio_det =$this->session->userdata('visita_precio_det');
		
		$visita_promocion =$this->session->userdata('visita_promocion');
		$visita_promocion_det =$this->session->userdata('visita_promocion_det');
		
		$visita_sos =$this->session->userdata('visita_sos');
		$visita_sos_det =$this->session->userdata('visita_sos_det');
		
		$visita_sod =$this->session->userdata('visita_sod');
		$visita_sod_det =$this->session->userdata('visita_sod_det');
		
		$visita_encarte =$this->session->userdata('visita_encarte');
		$visita_encarte_det =$this->session->userdata('visita_encarte_det');
		
		$visita_seguimiento_plan =$this->session->userdata('visita_seguimiento_plan');
		$visita_seguimiento_plan_det =$this->session->userdata('visita_seguimiento_plan_det');
		
		$visita_encuesta =$this->session->userdata('visita_encuesta');
		$visita_encuesta_det =$this->session->userdata('visita_encuesta_det');
		
		$visita_despacho =$this->session->userdata('visita_despacho');
		$visita_despacho_det =$this->session->userdata('visita_despacho_det');
		$visita_despacho_dias =$this->session->userdata('visita_despacho_dias');
		
		
		$visita_foto =$this->session->userdata('visita_foto');

		$visita_inventario =$this->session->userdata('visita_inventario');
		$visita_inventario_det =$this->session->userdata('visita_inventario_det');
		
		$visita_visibilidad_trad =$this->session->userdata('visita_visibilidad_trad');
		$visita_visibilidad_trad_det =$this->session->userdata('visita_visibilidad_trad_det');
		
		$visita_mantenimiento_cliente =$this->session->userdata('visita_mantenimiento_cliente');
		
		$visita_iniciativa =$this->session->userdata('visita_iniciativa');
		$visita_iniciativa_det =$this->session->userdata('visita_iniciativa_det');
		
		$visita_inteligencia =$this->session->userdata('visita_inteligencia');
		$visita_inteligencia_det =$this->session->userdata('visita_inteligencia_det');
		
		$visita_orden =$this->session->userdata('visita_orden');
		
		$visita_visibilidad_obligatorio =$this->session->userdata('visita_visibilidad_obligatorio');
		$visita_visibilidad_obligatorio_det =$this->session->userdata('visita_visibilidad_obligatorio_det');

		$visita_visibilidad_iniciativa =$this->session->userdata('visita_visibilidad_iniciativa');
		$visita_visibilidad_iniciativa_det =$this->session->userdata('visita_visibilidad_iniciativa_det');

		$visita_visibilidad_adicional =$this->session->userdata('visita_visibilidad_adicional');
		$visita_visibilidad_adicional_det =$this->session->userdata('visita_visibilidad_adicional_det');

		
		foreach($data as $key => $value) {
			if(strpos($key, '_') !== false){
				$modulo=substr($key,0,strrpos($key, '_'));
				$idVisita=substr($key,strrpos($key, '_')+1);

				if($modulo=="mod_encuesta"){
					if(isset($visita_encuesta[$idVisita])){
						if( count($visita_encuesta[$idVisita])>0){
							foreach ($visita_encuesta[$idVisita] as $row_) {
								$insertId=null;
								$arrayInsertEncuesta = array(
									'idVisita' => $row_['idVisita']
									,'idEncuesta' => $row_['idEncuesta']
									,'hora' => $row_['hora'] 
								);
								$this->model->insertar_visita_encuesta($arrayInsertEncuesta);
								$insertId = $this->db->insert_id();
							}

							//detalle
							if($insertId!=null){
								if(isset($visita_encuesta_det[$idVisita])){
									foreach ($visita_encuesta_det[$idVisita] as $row_) {
										$arrayInsertEncuestaDetalle = array(
											'idVisitaEncuesta' => $insertId
											,'idPregunta' => $row_['idPregunta']
											,'idAlternativa' => $row_['idAlternativa']
											,'respuesta' => $row_['respuesta']
											//idVisitaFoto
										);
										$this->model->insertar_visita_encuesta_detalle($arrayInsertEncuestaDetalle);
									}
								}
							}
						}
					}
					 
				}else if($modulo=="mod_ipp"){
					//modulo ipp
					if(isset($visita_ipp[$idVisita])){
						if( count($visita_ipp[$idVisita])>0){
							$insertId=null;
							foreach ($visita_ipp[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaIpp";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'idIpp' => !empty($row['idIpp']) ? $row['idIpp'] : null
									,'hora' => $row['hora'] 
									,'puntaje' => !empty($row['puntaje']) ? $row['puntaje'] : null
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();
							}

							//detalle
							if($insertId!=null){
								if(isset($visita_ipp_det[$idVisita])){
									$tabla="{$this->sessBDCuenta}.trade.data_visitaIppDet";
									foreach ($visita_ipp_det[$idVisita] as $row_) {
										$arrayInsertDetalle = array(
											'idVisitaIpp' => $insertId
											,'idPregunta' => !empty($row_['idPregunta']) ? $row_['idPregunta'] : null
											,'idAlternativa' => !empty($row_['idAlternativa']) ? $row_['idAlternativa'] : null
											,'puntaje' => !empty($row_['puntaje']) ? $row_['puntaje'] : null
										);
										$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_producto"){
					//modulo productos
					if(isset($visita_producto[$idVisita])){
						if( count($visita_producto[$idVisita])>0){
							$insertId=null;
							foreach ($visita_producto[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaProductos";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();
							}

							//detalle
							if($insertId!=null){
								if(isset($visita_producto_det[$idVisita])){
									$tabla="{$this->sessBDCuenta}.trade.data_visitaProductosDet";
									foreach ($visita_producto_det[$idVisita] as $row_) {
										$arrayInsertDetalle = array(
											'idVisitaProductos' => $insertId
											,'idProducto' => $row_['idProducto']
											,'presencia' => !empty($row_['presencia']) ? $row_['presencia'] : null	
											,'quiebre' => !empty($row_['quiebre']) ? $row_['quiebre'] : null											
											,'stock' =>  !empty($row_['stock'])? $row_['stock']: null
											,'idUnidadMedida' => !empty($row_['idUnidadMedida'])? $row_['idUnidadMedida']: null
											,'precio' => !empty($row_['precio'])? $row_['precio']: null
											,'idMotivo' => !empty($row_['idMotivo'])? $row_['idMotivo']: null
										);
										$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_precio"){
					//modulo precios
					if(isset($visita_precio[$idVisita])){
						if( count($visita_precio[$idVisita])>0){
							$insertId=null;
							foreach ($visita_precio[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaPrecios";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();
							}

							//detalle
							if($insertId!=null){
								if(isset($visita_precio_det[$idVisita])){
									$tabla="{$this->sessBDCuenta}.trade.data_visitaPreciosDet";
									foreach ($visita_precio_det[$idVisita] as $row_) {
										$arrayInsertDetalle = array(
											'idVisitaPrecios' => $insertId
											,'idProducto' => $row_['idProducto']
											,'precio' =>  !empty($row_['precio'])? $row_['precio'] : null
											,'precioProm1' => !empty($row_['precioProm1'])? $row_['precioProm1'] : null
											,'precioProm2' => !empty($row_['precioProm2'])? $row_['precioProm2'] : null
											,'precioProm3' => !empty($row_['precioProm3'])? $row_['precioProm3'] : null
											,'precioRegular' => !empty($row_['precioRegular'])? $row_['precioRegular'] : null
											,'precioOferta' => !empty($row_['precioOferta'])? $row_['precioOferta'] : null
											
										);
										$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_promocion"){
					//modulo promocion
					if(isset($visita_promocion[$idVisita])){
						if( count($visita_promocion[$idVisita])>0){
							$insertId=null;
							foreach ($visita_promocion[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaPromociones";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();

								//detalle
								if($insertId!=null){
									if(isset($visita_promocion_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaPromocionesDet";
										foreach ($visita_promocion_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaPromociones' => $insertId
												,'idPromocion' => !empty($row_['idPromocion']) ? $row_['idPromocion']  : null
												,'idTipoPromocion' => !empty($row_['idTipoPromocion']) ? $row_['idTipoPromocion']  : null
												,'nombrePromocion' => !empty($row_['nombrePromocion']) ? $row_['nombrePromocion']  : null
												,'presencia' => !empty($row_['presencia']) ? $row_['presencia']  : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}

							
						}
					}
					
				}else if($modulo=="mod_sos"){
					//modulo sos
					if(isset($visita_sos[$idVisita])){
						if( count($visita_sos[$idVisita])>0){
							$insertId=null;
							foreach ($visita_sos[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaSos";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'idCategoria' => $row['idCategoria'] 
									,'hora' => !empty($row['hora'] ) ? $row['hora'] : null
									,'cm' => !empty($row['cm'] ) ? $row['cm'] : null
									,'frentes' => !empty($row['frentes'] ) ? $row['frentes'] : null
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_sos_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaSosDet";
										foreach ($visita_sos_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaSos' => $insertId
												,'idCategoria' => !empty($row_['idCategoria'] ) ? $row_['idCategoria'] : null
												,'idMarca' =>  !empty($row_['idMarca'] ) ? $row_['idMarca'] : null
												,'cm' =>  !empty($row_['cm'] ) ? $row_['cm'] : null
												,'frentes' => !empty($row_['frentes'] ) ? $row_['frentes'] : null
												,'flagCompetencia' => !empty($row_['competencia'] ) ? $row_['competencia'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}


							}

							
						}
					}
					
				}else if($modulo=="mod_sod"){
					//modulo sos
					if(isset($visita_sod[$idVisita])){
						if( count($visita_sod[$idVisita])>0){
							$insertId=null;
							foreach ($visita_sod[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaSod";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'idCategoria' => $row['idCategoria'] 
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_sos_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaSodDet";
										foreach ($visita_sos_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaSod' => $insertId
												,'idCategoria' => !empty($row_['idCategoria']) ? $row_['idCategoria'] : null
												,'idMarca' => !empty($row_['idMarca']) ? $row_['idMarca'] : null
												,'idTipoElementoVisibilidad' => !empty($row_['idTipoElemento']) ? $row_['idTipoElemento'] : null
												,'indice' => !empty($row_['indice']) ? $row_['indice'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_encarte"){
					//modulo encarte
					if(isset($visita_encarte[$idVisita])){
						if( count($visita_encarte[$idVisita])>0){
							$insertId=null;
							foreach ($visita_encarte[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaEncartes";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_encarte_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaEncartesDet";
										foreach ($visita_encarte_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaEncartes' => $insertId
												,'idCategoria' => !empty($row_['idCategoria']) ? $row_['idCategoria'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_seguimiento"){
					//modulo seguimiento plan
					if(isset($visita_seguimiento_plan[$idVisita])){
						if( count($visita_seguimiento_plan[$idVisita])>0){
							$insertId=null;
							foreach ($visita_seguimiento_plan[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'idSeguimientoPlan' => $row['idPlan']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_seguimiento_plan_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlanDet";
										foreach ($visita_seguimiento_plan_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaSeguimientoPlan' => $insertId
												,'idTipoElementoVisibilidad' => !empty($row_['idTipoElemento']) ? $row_['idTipoElemento'] : null
												,'armado' => !empty($row_['armado']) ? $row_['armado'] : null
												,'revestido' => !empty($row_['revestido']) ? $row_['revestido'] : null
												,'idMotivo' => !empty($row_['idMotivo']) ? $row_['idMotivo'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
												,'idMarca' => !empty($row_['idMarca']) ? $row_['idMarca'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_despacho"){
					//modulo seguimiento plan
					if(isset($visita_despacho[$idVisita])){
						if( count($visita_despacho[$idVisita])>0){
							$insertId=null;
							foreach ($visita_despacho[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaDespachos";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_despacho_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaDespachosDet";
										foreach ($visita_despacho_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaDespachos' => $insertId
												,'placa' => !empty($row_['placa']) ? $row_['placa'] : null
												,'horaIni' => !empty($row_['horaIni']) ? $row_['horaIni'] : null
												,'horaFin' => !empty($row_['horaFin']) ? $row_['horaFin'] : null
												,'idIncidencia' => !empty($row_['idIncidencia']) ? $row_['idIncidencia'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
								//detalle dias
								if($insertId!=null){
									if(isset($visita_despacho_dias[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaDespachosDias";
										foreach ($visita_despacho_dias[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaDespachos' => $insertId
												,'idDia' => $row_['dia']
												,'presencia' => $row_['presencia']
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_foto"){
					//modulo foto
					if(isset($visita_foto[$idVisita])){
						if( count($visita_foto[$idVisita])>0){
							$insertId=null;
							foreach ($visita_foto[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaModuloFotos";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'idTipoFoto' => !empty($row['idTipoFoto']) ? $row['idTipoFoto'] : null 
									,'nombreTipoFoto' => !empty($row['tipoFoto']) ? $row['tipoFoto'] : null 
									,'hora' => !empty($row['hora']) ? $row['hora'] : null 
									,'comentario' => !empty($row['obs']) ? $row['obs'] : null 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();
 
							}
						}
					}
					
				}else if($modulo=="mod_inventario"){
					//modulo inventario
					if(isset($visita_inventario[$idVisita])){
						if( count($visita_inventario[$idVisita])>0){
							$insertId=null;
							foreach ($visita_inventario[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaInventario";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_inventario_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaInventarioDet";
										foreach ($visita_inventario_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaInventario' => $insertId
												,'idProducto' => $row_['idProducto']
												,'stock_inicial' => !empty($row_['stockInicial']) ? $row_['stockInicial'] : null 
												,'sellin' => !empty($row_['sellIn']) ? $row_['sellIn'] : null
												,'stock' => !empty($row_['stock']) ? $row_['stock'] : null
												,'validacion' => !empty($row_['validacion']) ? $row_['validacion'] : null
												,'obs' => !empty($row_['obs']) ? $row_['obs'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
												,'fecVenc' => !empty($row_['fecVenc']) ? $row_['fecVenc'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_visibilidad"){
					//modulo iniciativa
					if(isset($visita_visibilidad_trad[$idVisita])){
						if( count($visita_visibilidad_trad[$idVisita])>0){
							$insertId=null;
							foreach ($visita_visibilidad_trad[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_visibilidad_trad_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet";
										foreach ($visita_visibilidad_trad_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaVisibilidad' => $insertId
												,'idElementoVis' =>  !empty($row_['idElementoVis']) ? $row_['idElementoVis'] : null
												,'presencia' => !empty($row_['presencia']) ? $row_['presencia'] : null
												,'cantidad' => !empty($row_['cantidad']) ? $row_['cantidad'] : null
												,'idEstadoElemento' => !empty($row_['idEstadoElemento']) ? $row_['idEstadoElemento'] : null
												,'condicion_elemento' => !empty($row_['condicion']) ? $row_['condicion'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_mantenimiento"){
					//modulo mantenimiento
					if(isset($visita_mantenimiento_cliente[$idVisita])){
						if( count($visita_mantenimiento_cliente[$idVisita])>0){
							$insertId=null;
							foreach ($visita_mantenimiento_cliente[$idVisita] as $row_) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente";
								$arrayInsert = array(
									'idVisita' => $row_['idVisita']
									,'hora' => $row_['hora'] 
									,'codCliente' => !empty($row_['codCliente']) ? $row_['codCliente'] : null
									,'nombreComercial' => !empty($row_['nombreComercial']) ? $row_['nombreComercial'] : null
									,'razonSocial' => !empty($row_['razonSocial']) ? $row_['razonSocial'] : null
									,'ruc' => !empty($row_['ruc']) ? $row_['ruc'] : null
									,'dni' => !empty($row_['dni']) ? $row_['dni'] : null
									,'cod_ubigeo' => !empty($row_['codUbigeo']) ? $row_['codUbigeo'] : null
									,'direccion' => !empty($row_['direccion']) ? $row_['direccion'] : null
									,'latitud' => !empty($row_['latitud']) ? $row_['latitud'] : null
									,'longitud' => !empty($row_['longitud']) ? $row_['longitud'] : null
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();
 
							}
						}
					}
					
				}else if($modulo=="mod_iniciativa"){
					//modulo iniciativa
					if(isset($visita_iniciativa[$idVisita])){
						if( count($visita_iniciativa[$idVisita])>0){
							$insertId=null;
							foreach ($visita_iniciativa[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_iniciativa_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet";
										foreach ($visita_iniciativa_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaIniciativaTrad' => $insertId
												,'idIniciativa' =>  !empty($row_['idIniciativa']) ? $row_['idIniciativa'] : null
												,'idElementoIniciativa' => !empty($row_['idElementoIniciativa']) ? $row_['idElementoIniciativa'] : null
												,'presencia' => !empty($row_['presencia']) ? $row_['presencia'] : null
												,'cantidad' => !empty($row_['cantidad']) ? $row_['cantidad'] : null
												,'idEstadoIniciativa' => !empty($row_['idEstadoIniciativa']) ? $row_['idEstadoIniciativa'] : null
												,'producto' => !empty($row_['producto']) ? $row_['producto'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_inteligencia"){
					//modulo iniciativa
					if(isset($visita_inteligencia[$idVisita])){
						if( count($visita_inteligencia[$idVisita])>0){
							$insertId=null;
							foreach ($visita_inteligencia[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_inteligencia_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaInteligenciaTradDet";
										foreach ($visita_inteligencia_det[$idVisita] as $row_) {
											$arrayInsertDetalle = array(
												'idVisitaInteligenciaTrad' => $insertId
												,'idCategoria' => !empty($row_['idCategoria']) ? $row_['idCategoria'] : null
												,'idMarca' => !empty($row_['idMarca']) ? $row_['idMarca'] : null
												,'idTipoCompetencia' => !empty($row_['idTipoCompetencia']) ? $row_['idTipoCompetencia'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_orden"){
					//modulo iniciativa
					if(isset($visita_orden[$idVisita])){
						if( count($visita_orden[$idVisita])>0){
							$insertId=null;
							foreach ($visita_orden[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaOrden";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'idOrden' => !empty($row['idOrden']) ? $row['idOrden'] : null
									,'descripcion' => !empty($row['descripcion']) ? $row['descripcion'] : null
									,'idOrdenEstado' => !empty($row['idOrden']) ? $row['idOrden'] : null
									,'flagOtro' => !empty($row['flagOtro']) ? $row['flagOtro'] : null
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();
							}
						}
					}
					
				}else if($modulo=="mod_visibilidad_obligatorio"){
					//modulo visibilidad auditoria obligatorio
					if(isset($visita_visibilidad_obligatorio[$idVisita])){
						if( count($visita_visibilidad_obligatorio[$idVisita])>0){
							$insertId=null;
							foreach ($visita_visibilidad_obligatorio[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_visibilidad_obligatorio_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet";
										foreach ($visita_visibilidad_obligatorio_det[$idVisita] as $row_) {

											$arrayInsertDetalle = array(
												'idVisitaVisibilidad' => $insertId
												,'idElementoVis' => !empty($row_['idElementoVis']) ? $row_['idElementoVis'] : null
												,'idVariable' => !empty($row_['idVariable']) ? $row_['idVariable'] : null
												,'presencia' => !empty($row_['presencia']) ? $row_['presencia'] : null
												,'idObservacion' => !empty($row_['idObservacion']) ? $row_['idObservacion'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
												,'cantidad' => !empty($row_['cantidad']) ? $row_['cantidad'] : null

											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										
											$arrayInsertDetalle = array(
												'idVisitaVisibilidad' => $insertId
												,'idElementoVis' => !empty($row_['idElementoVis']) ? $row_['idElementoVis'] : null
												,'idVariable' => !empty($row_['idVariable2']) ? $row_['idVariable2'] : null
												,'presencia' => !empty($row_['presencia2']) ? $row_['presencia2'] : null
												,'idObservacion' => !empty($row_['idObservacion2']) ? $row_['idObservacion2'] : null
												,'comentario' => !empty($row_['comentario2']) ? $row_['comentario2'] : null
												,'cantidad' => !empty($row_['cantidad']) ? $row_['cantidad'] : null

											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);


											$arrayInsertDetalle = array(
												'idVisitaVisibilidad' => $insertId
												,'idElementoVis' => !empty($row_['idElementoVis']) ? $row_['idElementoVis'] : null
												,'idVariable' => !empty($row_['idVariable3']) ? $row_['idVariable3'] : null
												,'presencia' => !empty($row_['presencia3']) ? $row_['presencia3'] : null
												,'idObservacion' => !empty($row_['idObservacion3']) ? $row_['idObservacion3'] : null
												,'comentario' => !empty($row_['comentario3']) ? $row_['comentario3'] : null
												,'cantidad' => !empty($row_['cantidad']) ? $row_['cantidad'] : null

											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_visibilidad_iniciativa"){
					//modulo visibilidad auditoria iniciativa
					if(isset($visita_visibilidad_iniciativa[$idVisita])){
						if( count($visita_visibilidad_iniciativa[$idVisita])>0){
							$insertId=null;
							foreach ($visita_visibilidad_iniciativa[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
									,'porcentaje' => !empty($row['porcentaje']) ? $row['porcentaje'] : null
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_visibilidad_iniciativa_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet";
										foreach ($visita_visibilidad_iniciativa_det[$idVisita] as $row_) {

											$arrayInsertDetalle = array(
												'idVisitaVisibilidad' => $insertId
												,'idElementoVis' => !empty($row_['idElementoVis']) ? $row_['idElementoVis'] : null
												,'presencia' => !empty($row_['presencia']) ? $row_['presencia'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
												,'idObservacion' => !empty($row_['idObservacion']) ? $row_['idObservacion'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}else if($modulo=="mod_visibilidad_adicional"){
					//modulo visibilidad auditoria iniciativa
					if(isset($visita_visibilidad_adicional[$idVisita])){
						if( count($visita_visibilidad_adicional[$idVisita])>0){
							$insertId=null;
							foreach ($visita_visibilidad_adicional[$idVisita] as $row) {
								$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional";
								$arrayInsert = array(
									'idVisita' => $row['idVisita']
									,'hora' => $row['hora'] 
									,'porcentaje' => !empty($row['porcentaje']) ? $row['porcentaje'] : null
								);
								$this->model->insertar_tabla($tabla,$arrayInsert);
								$insertId = $this->db->insert_id();


								//detalle
								if($insertId!=null){
									if(isset($visita_visibilidad_adicional_det[$idVisita])){
										$tabla="{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet";
										foreach ($visita_visibilidad_adicional_det[$idVisita] as $row_) {

											$arrayInsertDetalle = array(
												'idVisitaVisibilidad' => $insertId
												,'idElementoVis' => !empty($row_['idElementoVis']) ? $row_['idElementoVis'] : null
												,'presencia' => !empty($row_['presencia']) ? $row_['presencia'] : null
												,'cant' => !empty($row_['cant']) ? $row_['cant'] : null
												,'comentario' => !empty($row_['comentario']) ? $row_['comentario'] : null
											);
											$this->model->insertar_tabla($tabla,$arrayInsertDetalle);
										}
									}
								}
							}
						}
					}
					
				}

			}
		}

		$array=array();
		$html='';
		$html .= "Se han registrado los elementos seleccionados.";
		$result['result'] = 1;
		$result['msg']['title'] = 'CARGAR DATA VISITAS';
		$result['data']['html'] = $html;

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}

}
?>