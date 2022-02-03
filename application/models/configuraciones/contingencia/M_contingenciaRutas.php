<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_contingenciaRutas extends My_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
	}

	public function obtener_modulos_usuario($input=array()){
		$filtros = '';
			$filtros .= !empty($input['idCuenta']) ? " AND r.idCuenta=".$input['idCuenta'] : "";
			$filtros .= !empty($input['idProyecto']) ? " AND r.idProyecto=".$input['idProyecto'] : "";
			$filtros .= !empty($input['idCanal']) ? " AND v.idCanal=".$input['idCanal'] : "";
			//$filtros .= !empty($input['idTipoUsuario']) ? " AND r.idTipoUsuario=".$input['idTipoUsuario'] : "";

		$idProyecto = $this->sessIdProyecto;
		$sql="
		DECLARE @fecha DATE='".$input['fecha']."';
		SELECT
			r.idUsuario
			, um.idModulo
		FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN trade.usuario_modulo um ON um.idUsuario=r.idUsuario
			JOIN trade.usuario_historico uh ON uh.idUsuario = r.idUsuario AND uh.idProyecto = r.idProyecto AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecha,@fecha)= 1
		WHERE  r.estado=1
			AND um.estado=1
			AND r.fecha = @fecha
			AND r.idProyecto = {$idProyecto}
		UNION
			SELECT
			r.idUsuario
			, um.idModulo
		FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN trade.aplicacion_modulo_tipoUsuario um ON um.idTipoUsuario=r.idTipoUsuario
			JOIN trade.usuario_historico uh ON uh.idUsuario = r.idUsuario AND uh.idProyecto = r.idProyecto AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecha,@fecha)= 1
			JOIN trade.aplicacion_modulo appm ON appm.idAplicacion = uh.idAplicacion AND um.idModulo = appm.idModulo
		WHERE r.estado=1
			AND um.estado=1
			AND r.fecha = @fecha
			AND r.idProyecto = {$idProyecto}
			
		ORDER BY r.idUsuario, um.idModulo ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_modulo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_rutas_visitas($input=array()){

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
		$filtros = '';
		// $input['idProyecto'] = $this->sessIdProyecto;
		$input['idProyecto'] = 3;
		$filtros .= !empty($input['idCuenta']) ? " AND r.idCuenta=".$input['idCuenta'] : "";
		$filtros .= !empty($input['idProyecto']) ? " AND r.idProyecto=".$input['idProyecto'] : "";
		$filtros .= !empty($input['idCanal']) ? " AND v.idCanal=".$input['idCanal'] : "";
		$filtros .= !empty($input['idTipoUsuario']) ? " AND r.idTipoUsuario=".$input['idTipoUsuario'] : "";

		$filtros .= !empty($input['departamento_filtro']) ? ' AND ub.cod_departamento='.$input['departamento_filtro'] : '';
		$filtros .= !empty($input['provincia_filtro']) ? ' AND ub.cod_provincia='.$input['provincia_filtro'] : '';
		$filtros .= !empty($input['distrito_filtro']) ? ' AND ub.cod_ubigeo='.$input['distrito_filtro'] : '';

		// $filtros .= " AND v.horaFin is null";

		if(!empty($input['estadoUsuario']) && ($input['estadoUsuario'] == 1 || $input['estadoUsuario'] == 2)){
			$filtros .= $input['estadoUsuario'] == 1  ? ' AND r.idUsuario IN(SELECT idUsuario FROM list_usuarios_activos)' : ''; 
			$filtros .= $input['estadoUsuario'] == 2  ? ' AND r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos)' : ''; 
		}else{
			$filtros .= !empty($input['estadoUsuario']) && $input['estadoUsuario'] == 3  ? ' AND 1<>1 ' : ''; 
		}

		// DATOS DEMO
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal_filtro']]);

		$sql="
			DECLARE 
				@fecha DATE='".$input['fecha']."',
				@hoy DATE = GETDATE();
			WITH list_usuarios_activos as(
				SELECT DISTINCT
				u.idUsuario
				FROM
				trade.usuario u 
				JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
				WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@hoy,@hoy) = 1 AND uh.idProyecto = {$input['idProyecto']}
			), lista_visitas AS (
				SELECT
				CONVERT(VARCHAR,r.fecha,103) AS fecha
				, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
				, r.idUsuario
				, r.idUsuario AS codUsuario
				, r.nombreUsuario AS usuario
				, r.idTipoUsuario
				, r.tipoUsuario
				, u.idEmpleado AS codEmpleado
				, r.idProyecto
				, p.nombre AS proyecto
				, CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1 ) THEN  --Efectiva
						CASE 
							WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 3 --Efectiva
							ELSE 
								CASE 
								WHEN v.numFotos >=1 THEN 3 --Efectiva
								ELSE 1 --No efectiva
								END
						END 
					   WHEN (v.estadoIncidencia = 1 ) THEN 2 --INCIDENCIA
					   WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND ISNULL(v.numFotos,0) = 0  AND estadoIncidencia IS NULL ) THEN 
					   		CASE WHEN r.fecha <= GETDATE() THEN 4 -- NO EFECTIVA
							ELSE 0 -- No Visitado 
							END
					   ELSE	1 --No Efectiva
					END condicion
				, v.idVisita
				, v.idCliente
				, v.razonSocial AS pdv
				, v.nombreComercial
				, v.codCliente, v.direccion
				, CONVERT(VARCHAR(8),v.horaIni) AS horaIni
				, CONVERT(VARCHAR(8), v.horaFin) AS horaFin
				, v.estadoIncidencia
				, v.idCanal 
				, v.canal

				, ub.cod_departamento
				, ub.departamento
				, ub.provincia
				, ub.distrito

				, vi.idIncidencia
				, vi.nombreIncidencia

				, v.encuesta, v.idListEncuesta
				, v.ipp, v.idListIpp
				, v.productos, v.idListProductos
				, v.precios, v.idListProductos AS idListPrecios
				, v.seguimientoPlan, v.idListSeguimientoPlan
				, v.sos, v.idListVisibilidad AS idListSos
				, v.sod, v.idListVisibilidad AS idListSod
				, v.encartes, v.idListVisibilidad AS idListEncartes
				, v.promociones, v.idListPromociones
				, v.despachos, v.idListPromociones AS idListDespachos
				, v.moduloFotos, 0 AS idListFotos
				, v.inventario, v.idListInventario
				, v.visibilidad, v.idListVisibilidadTrad
				, v.iniciativa, v.idListIniciativa
				, v.inteligencia, v.idListCategoriaMarcaComp
				, v.mantenimiento, 0 AS idListMantenimiento
				, v.ordenes, 0 AS idListOrdenes
				, v.premio, 0 AS idListEncuestaPremio
				, v.visibilidad_aud, 0 AS idListVisibilidadAudit
				, v.idListIniciativasTrad
				, v.idListVisibilidadTradObl
				, v.idListVisibilidadTradAdc
				, '0' tablaTemporal
				, v.flagContingencia
				{$segmentacion['columnas_bd']}
			FROM {$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
				LEFT JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = v.idCliente 
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,r.fecha,r.fecha)=1 AND ch.idProyecto = {$input['idProyecto']}
				LEFT JOIN trade.usuario u ON u.idUsuario=r.idUsuario
				LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo=v.cod_ubigeo
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON vi.idVisita=v.idVisita
				LEFT JOIN trade.proyecto p ON p.idProyecto=r.idProyecto
				{$segmentacion['join']}
			WHERE r.fecha=@fecha
				AND r.estado=1
				AND v.estado=1
				{$filtros}
		)
		SELECT * FROM lista_visitas
		WHERE condicion IN(1,4) 
		AND flagContingencia = 1
		ORDER BY fecha, idUsuario ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_visita($idVisita, $columna){
		$query = $this->db->select($columna)
				->where( array('idVisita' => $idVisita) )
				->get("{$this->sessBDCuenta}.trade.data_visita");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $query->result_array();
	}

	/************FUNCIONES GENERALES***********/
	public function update_visita_modulo($idVisita, $modulo){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visita";
		$params[$modulo] = 1;
		$where = array( 'idVisita' => $idVisita);

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);
			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => $idVisita ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function obtener_motivo(){
		$sql = "
			SELECT idMotivo, nombre as motivo
			FROM trade.motivo WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.motivo' ];
		return $this->db->query($sql)->result_array();
	}

	public function insert_visita_foto($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaFotos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {

			$rs = $this->get_cantidad_fotos_visita($input)->row_array();
			$update = [
				'numFotos' => !empty($rs['fotos']) ? $rs['fotos'] : 0, 
			];
			$where = [
				'idVisita' => $input['idVisita'],
			];

			$this->db->update("{$this->sessBDCuenta}.trade.data_visita",$update,$where);

			if ( $this->db->trans_status()===FALSE ) {
				$this->db->trans_rollback();

			}else{
				$this->db->trans_commit();
				$this->aSessTrack[] = $aSessTrack;
			}
		}
		return $insert;
	}

	/*************VISITA INCIDENCIA***********/
	public function obtener_tipo_incidencia(){
		$sql = "
			SELECT
				idIncidencia
				,nombre AS tipoIncidencia
			FROM master.incidencias WHERE flagVisita=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.incidencias' ];
		return $this->db->query($sql)->result_array();
	}

	public function insert_visita_incidencia($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIncidencia";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();
			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function update_visita_incidencia($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIncidencia";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();
		$this->db->where($where);

			$update = $this->db->update($table, $params );
			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_visita($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visita";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	/*************VISITA ENCUESTAS************/
	public function obtener_lista_visita_encuesta($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idList INT={$idLista};
			SELECT 
				le.idListEncuesta
				, le.idCanal, le.idProyecto
				, led.idListEncuestaDet
				, led.idEncuesta
				, e.nombre AS encuesta
				, e.foto AS fotoEncuesta
				, ep.idPregunta
				, ep.idTipoPregunta, tp.nombre AS tipoPregunta
				, ep.orden
				, ep.nombre AS pregunta
				, ep.obligatorio
				, ep.idAlternativaPadre
				, ep.foto AS fotoPregunta
				, ea.idAlternativa
				, ea.nombre AS alternativa
				, ea.foto AS fotoAlternativa
			FROM {$this->sessBDCuenta}.trade.list_encuesta le
			JOIN {$this->sessBDCuenta}.trade.list_encuestaDet led ON led.idListEncuesta=le.idListEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta e ON e.idEncuesta=led.idEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ep.idEncuesta=e.idEncuesta
			LEFT JOIN master.tipoPregunta tp ON tp.idTipoPregunta=ep.idTipoPregunta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_alternativa ea ON ea.idPregunta=ep.idPregunta
			WHERE e.estado=1 AND ep.estado=1 
			AND le.idListEncuesta=@idList
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_encuesta" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_encuesta($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT={$idVisita};
		SELECT 
			e.idVisita, e.idVisitaEncuesta, e.idEncuesta, e.hora
			, e.idVisitaFoto, vf.fotoUrl AS fotoEncuesta, e.numDet
			, ed.idVisitaEncuestaDet
			, ed.idPregunta, ea.idTipoPregunta
			, ed.idAlternativa, ed.respuesta
			, ed.idVisitaFoto AS idVisitaFotoRespuesta, vfa.fotoUrl AS fotoRespuesta
			, ed.idVisitaFoto AS idVisitaFotoAlternativa, vfa.fotoUrl AS fotoAlternativa
		FROM {$this->sessBDCuenta}.trade.data_visitaEncuesta e
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ed ON ed.idVisitaEncuesta=e.idVisitaEncuesta
		LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ea On ea.idPregunta= ed.idPregunta
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=e.idVisitaFoto
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vfa ON vfa.idVisitaFoto=ed.idVisitaFoto
		WHERE 1=1 AND e.idVisita=@idVisita AND ed.estado=1
		ORDER BY e.idEncuesta, ed.idPregunta, ed.idAlternativa ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuesta" ];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_visita_encuesta($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuesta";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	public function insertar_visita_encuesta_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function update_visita_encuesta($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuesta";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();
			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_encuesta_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();
			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_encuesta_detalle($input=array()){
		$query = $this->db->select('idVisitaEncuestaDet')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaEncuestaDet");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaDet" ];
		return $query->result_array();
	}

	public function update_visita_encuesta_detalle_v2($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaDet";
		$params[$input['columnaParams']] = $input['valorParams'];
		$where = array( $input['columnaWhere'] => $input['idVisitaEncuestaDet'] );

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => $input['idVisitaEncuestaDet'] ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_encuesta_detalle_v1($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaDet";
		$params['estado'] = 0;
		$where = $input;

		$this->db->trans_begin();
		
			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_encuesta_detalle_tipoPregunta($idVisitaEncuesta){
		$sql = "
		DECLARE @idVisitaEncuesta INT=$idVisitaEncuesta;
		UPDATE {$this->sessBDCuenta}.trade.data_visitaEncuestaDet SET estado=0 WHERE idVisitaEncuestaDet IN (
		SELECT DISTINCT idVisitaEncuestaDet
		FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaDet ved
		LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_pregunta ep ON ep.idPregunta=ved.idPregunta
		WHERE ep.idTipoPregunta=3 AND ved.idVisitaEncuesta=@idVisitaEncuesta)";

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaDet", 'id' => arrayToString([ 'idVisitaEncuesta' => $idVisitaEncuesta ]) ];
		return $this->db->query($sql);
	}


	/***********VISITA IPP**********/
	public function detalle_visita_ipp($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				li.idListIpp
				, li.idCanal, li.idProyecto
				, lid.idListIppDet
				, lid.idIpp
				, i.nombre AS ipp
				, i.foto
				, ip.idCriterio
				, c.nombre AS criterio
				, lid.idPregunta
				, ip.nombre AS pregunta
				, ip.idTipoPregunta
				, ip.orden, ip.obligatorio
				, lid.idAlternativa
				, ia.nombre AS alternativa
				, lid.puntaje
			FROM {$this->sessBDCuenta}.trade.list_ipp li
			JOIN {$this->sessBDCuenta}.trade.list_ippDet lid ON lid.idListIpp=li.idListIpp
			LEFT JOIN {$this->sessBDCuenta}.trade.ipp i ON i.idIpp=lid.idIpp
			LEFT JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip ON ip.idIpp=i.idIpp 
				AND lid.idPregunta=ip.idPregunta
			LEFT JOIN {$this->sessBDCuenta}.trade.ipp_alternativa ia ON ia.idPregunta=ip.idPregunta
				AND lid.idAlternativa=ia.idAlternativa
			LEFT JOIN {$this->sessBDCuenta}.trade.ipp_criterio c ON c.idCriterio=ip.idCriterio
			WHERE 1=1 AND li.idListIpp=@idLista
				AND i.estado=1 AND ip.estado=1 AND ia.estado=1
			ORDER BY c.idCriterio, ip.idPregunta, ia.idAlternativa ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_ipp" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_ipp($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT 
			vi.idVisitaIpp
			, vi.idIpp
			, vi.puntaje
			, vid.idVisitaIppDet
			, vid.idPregunta, vid.idAlternativa
			, vid.puntaje AS puntajeAlternativa
		FROM {$this->sessBDCuenta}.trade.data_visitaIpp vi
		JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet vid ON vid.idVisitaIpp=vi.idVisitaIpp
		WHERE 1=1 AND vi.idVisita=@idVisita AND vid.estado=1
		ORDER BY vi.idIpp,vid.idPregunta, vid.idAlternativa ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIpp" ];
		return $this->db->query($sql)->result_array();
	}

	public function select_visita_ipp($input=array()){
		$query = $this->db->select('idVisitaIpp')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaIpp");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIpp" ];
		return $query->result_array();
	}

	public function select_visita_ipp_det($input=array()){
		$query = $this->db->select('idVisitaIppDet')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaIppDet");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIppDet" ];
		return $query->result_array();
	}

	public function update_visita_ipp_detalle_tipoPregunta($idVisita){
		$sql = "
		UPDATE {$this->sessBDCuenta}.trade.data_visitaIppDet SET estado=0 WHERE idPregunta IN (
			SELECT 
				DISTINCT vid.idPregunta
			FROM {$this->sessBDCuenta}.trade.data_visitaIpp vi 
			JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet vid ON vid.idVisitaIpp=vi.idVisitaIpp
			LEFT JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip ON ip.idIpp=vi.idIpp AND ip.idPregunta=vid.idPregunta
			WHERE vi.idVisita=$idVisita AND ip.idTipoPregunta=3 AND vid.estado=1
		)";

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIppDet", 'id' => $idVisita ];
		return $this->db->query($sql);
	}

	public function update_visita_ipp($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIpp";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_ipp_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIppDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_ipp($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIpp";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_ipp_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIppDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/**********VISITA CHECKLIST PRODUCTOS*********/
	public function detalle_visita_productos($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				lpd.idProducto
				, p.idCategoria
				, pc.nombre AS categoria
				, p.idMarca
				, pm.nombre AS marca
				, p.nombre AS producto
				, p.flagCompetencia
				, CASE p.flagCompetencia WHEN 0 THEN 'PROPIOS' WHEN 1 THEN 'COMPETENCIA' END AS competencia
				, p.ean
			FROM {$this->sessBDCuenta}.trade.list_productos lp
			JOIN {$this->sessBDCuenta}.trade.list_productosDet lpd ON lpd.idListProductos=lp.idListProductos
			JOIN trade.producto p ON p.idProducto=lpd.idProducto
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=p.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=p.idMarca
			WHERE 1=1 AND p.estado=1 AND lp.idListProductos=@idLista
			ORDER BY p.flagCompetencia, p.idCategoria, p.idMarca ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_productos" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_unidad_medida(){
		$sql = "
			SELECT idUnidadMedida, nombre as unidadMedida
			FROM trade.unidadMedida WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.unidadMedida' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_productos($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT
			vpd.idProducto
			, p.flagCompetencia
			, vpd.idVisitaProductos
			, vpd.idVisitaProductosDet
			, vpd.presencia
			, vpd.quiebre
			, vpd.idVisitaFoto
			, vf.fotoUrl AS foto
			, vpd.stock
			, vpd.idUnidadMedida
			, vpd.precio
			, vpd.idMotivo
		FROM {$this->sessBDCuenta}.trade.data_visitaProductos vp
		JOIN {$this->sessBDCuenta}.trade.data_visitaProductosDet vpd ON vpd.idVisitaProductos=vp.idVisitaProductos
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vpd.idVisitaFoto
		LEFT JOIN trade.producto p ON p.idProducto=vpd.idProducto
		WHERE vp.idVisita=@idVisita
		ORDER BY vpd.idProducto ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaProductos" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_visita_canal($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT
			c.idGrupoCanal
		FROM {$this->sessBDCuenta}.trade.data_visita v
		LEFT JOIN trade.canal c ON c.idCanal=v.idCanal
		WHERE v.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();
	}

	public function select_visita_producto($input=array()){
		$query = $this->db->select('idVisitaProductos')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaProductos");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaProductos" ];
		return $query->result_array();
	}

	public function select_visita_producto_det($input=array()){
		$query = $this->db->select('idVisitaProductosDet')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaProductosDet");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaProductosDet" ];
		return $query->result_array();
	}

	public function update_visita_producto_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaProductosDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_producto($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaProductos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}
	
	public function insert_visita_producto_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaProductosDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/***************VISITA PRECIOS***********************/

	public function detalle_visita_precios($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				lpd.idProducto
				, p.idCategoria
				, pc.nombre AS categoria
				, p.idMarca
				, pm.nombre AS marca
				, p.nombre AS producto
				, p.flagCompetencia
				, CASE p.flagCompetencia WHEN 0 THEN 'PROPIOS' WHEN 1 THEN 'COMPETENCIA' END AS competencia
				, p.ean
			FROM {$this->sessBDCuenta}.trade.list_productos lp
			JOIN {$this->sessBDCuenta}.trade.list_productosDet lpd ON lpd.idListProductos=lp.idListProductos
			JOIN trade.producto p ON p.idProducto=lpd.idProducto
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=p.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=p.idMarca
			WHERE 1=1 AND p.estado=1 AND lp.idListProductos=@idLista
			ORDER BY p.flagCompetencia, p.idCategoria, p.idMarca ASC
		";

		$this->aSessTrack = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_productos" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_precios($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT
			vpd.idProducto
			, p.flagCompetencia
			, vpd.idVisitaPrecios
			, vpd.idVisitaPreciosDet
			, vpd.precio
			, vpd.precioRegular
			, vpd.precioOferta
			, vpd.precioProm1
			, vpd.precioProm2
			, vpd.precioProm3
		FROM {$this->sessBDCuenta}.trade.data_visitaPrecios vp
		JOIN {$this->sessBDCuenta}.trade.data_visitaPreciosDet vpd ON vpd.idVisitaPrecios=vp.idVisitaPrecios
		LEFT JOIN trade.producto p ON p.idProducto=vpd.idProducto
		WHERE vp.idVisita=@idVisita
		ORDER BY vpd.idProducto ASC";

		$this->aSessTrack = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPrecios" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_precio_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaPreciosDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_precio($input=array()){
		$query = $this->db->select('idVisitaPrecios')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaPrecios");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPrecios" ];
		return $query->result_array();
	}

	public function select_visita_precio_det($input=array()){
		$query = $this->db->select('idVisitaPreciosDet')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaPreciosDet");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPreciosDet" ];
		return $query->result_array();
	}

	public function insert_visita_precio($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaPrecios";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_precio_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaPreciosDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/**************VISITA PROMOCIONES****************/
	public function detalle_visita_promociones($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				pd.idListPromociones
				, pd.idPromocion
				, pm.nombre AS promocion
				, pm.idTipoPromocion
				, tpm.nombre AS tipoPromocion
			FROM {$this->sessBDCuenta}.trade.list_promociones p
			JOIN {$this->sessBDCuenta}.trade.list_promocionesDet pd ON pd.idListPromociones=p.idListPromociones
			LEFT JOIN trade.promocion pm ON pm.idPromocion=pd.idPromocion
			LEFT JOIN trade.tipoPromocion tpm ON tpm.idTipoPromocion=pm.idTipoPromocion
			WHERE 1=1 AND pm.estado=1 AND p.idListPromociones=@idLista
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_promociones" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_promociones($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT
			vpd.idVisitaPromocionesDet
			, vpd.idVisitaPromociones
			, vpd.idPromocion
			, vpd.idTipoPromocion
			, tp.nombre AS tipoPromocion
			, vpd.nombrePromocion
			, vpd.presencia
			, vpd.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaPromociones vp
		JOIN {$this->sessBDCuenta}.trade.data_visitaPromocionesDet vpd ON vpd.idVisitaPromociones=vp.idVisitaPromociones
		LEFT JOIN trade.tipoPromocion tp ON tp.idTipoPromocion= vpd.idTipoPromocion
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vpd.idVisitaFoto
		WHERE vp.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPromociones" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tipo_promocion(){
		$sql = "
			SELECT idTipoPromocion, nombre as tipoPromociones
			FROM trade.tipoPromocion WHERE estado=1 AND flagTipo=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tipoPromocion' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_promociones_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaPromocionesDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_promocion($input=array()){
		$query = $this->db->select('idVisitaPromociones')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaPromociones");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaPromociones" ];
		return $query->result_array();
	}

	public function insert_visita_promocion($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaPromociones";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_promocion_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaPromocionesDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/*************VISITA SOS****************/
	public function detalle_visita_sos($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				vd.idListVisibilidad
				, vd.idCategoria
				, pc.nombre AS categoria
				, vd.idMarca
				, pm.nombre AS marca
				, pm.flagCompetencia
				, CASE pm.flagCompetencia WHEN 0 THEN 'PROPIOS' WHEN 1 THEN 'COMPETENCIA' END AS competencia
			FROM {$this->sessBDCuenta}.trade.list_visibilidad v
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadDet vd ON vd.idListVisibilidad=v.idListVisibilidad
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=vd.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=vd.idMarca
			WHERE 1=1 AND v.idListVisibilidad=@idLista
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidad" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_sos($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT 
			s.idVisitaSos
			, s.idCategoria
			, pc.nombre AS categoria
			, s.numDet
			, s.cm AS categoriaCm
			, s.frentes AS categoriaFrentes
			, s.idVisitaFoto
			, vf.fotoUrl AS foto
			, sd.idVisitaSosDet
			, sd.idCategoria AS idCategoriaDet
			, sd.idMarca
			, pm.nombre AS marca
			, sd.cm AS marcaCm
			, sd.frentes AS marcaFrentes
			, ISNULL(sd.flagCompetencia,0) AS flagCompetencia
			, CASE ISNULL(sd.flagCompetencia,0) WHEN 0 THEN 'PROPIOS' WHEN 1 THEN 'COMPETENCIA' END AS competencia
		FROM {$this->sessBDCuenta}.trade.data_visitaSos s
		JOIN {$this->sessBDCuenta}.trade.data_visitaSosDet sd ON sd.idVisitaSos=s.idVisitaSos
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=s.idVisitaFoto
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=s.idCategoria
		LEFT JOIN trade.producto_marca pm ON pm.idMarca=sd.idMarca
		WHERE 1=1 AND s.idVisita=@idVisita
		ORDER BY pm.flagCompetencia ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSos" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_sos($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSos";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_sos_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSosDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_sos($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_sos_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSosDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/**************VISITA SOD*****************/
	public function detalle_visita_sod($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				vd.idListVisibilidad
				, vd.idCategoria
				, pc.nombre AS categoria
				, vd.idMarca
				, pm.nombre AS marca
				, pm.flagCompetencia
				, CASE pm.flagCompetencia WHEN 0 THEN 'PROPIOS' WHEN 1 THEN 'COMPETENCIA' END AS competencia
			FROM {$this->sessBDCuenta}.trade.list_visibilidad v
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadDet vd ON vd.idListVisibilidad=v.idListVisibilidad
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=vd.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=vd.idMarca
			WHERE 1=1 AND v.idListVisibilidad=@idLista
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidad" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tipo_elemento_visibilidad(){
		$sql="
			SELECT
				ev.idTipoElementoVisibilidad
				, ev.nombre AS elementoVisibilidad
			FROM trade.tipoElementoVisibilidad ev WHERE ev.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tipoElementoVisibilidad' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_sod($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			s.idVisitaSod
			, s.idCategoria
			, pc.nombre AS categoria
			, s.cant
			, sd.idVisitaSodDet
			, sd.idCategoria AS idCategoriaDet
			, sd.idMarca
			, pm.nombre AS marca
			, sd.idTipoElementoVisibilidad
			, sd.cant AS cantDet
			, count(sdf.idVisitaFoto) AS cantFotos
		FROM {$this->sessBDCuenta}.trade.data_visitaSod s
		JOIN {$this->sessBDCuenta}.trade.data_visitaSodDet sd ON sd.idVisitaSod=s.idVisitaSod
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaSodDetFotos sdf ON sdf.idVisitaSod=s.idVisitaSod
			--AND sdf.idCategoria=s.idCategoria AND sdf.idMarca=sd.idMarca
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=s.idCategoria
		LEFT JOIN trade.producto_marca pm ON pm.idMarca=sd.idMarca
		WHERE 1=1 AND s.idVisita=@idVisita
		GROUP BY s.idVisitaSod,s.idCategoria,pc.nombre,s.cant,sd.idVisitaSodDet
			, sd.idCategoria,sd.idMarca,pm.nombre,sd.idTipoElementoVisibilidad,sd.cant";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSod" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_visita_sod_fotos($input=array()){

		$sql="
			SELECT 
				vf.idVisitaFoto
				, vf.idVisita
				, vf.fotoUrl AS foto
			FROM {$this->sessBDCuenta}.trade.data_visitaSodDetFotos sdf
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=sdf.idVisitaFoto
			WHERE sdf.idCategoria=".$input['idCategoria']." AND sdf.idMarca=".$input['idMarca']."
				AND sdf.idTipoElementoVisibilidad=".$input['idTipoElementoVisibilidad']." AND vf.idVisita=".$input['idVisita'];

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSodDetFotos" ];
		return $this->db->query($sql)->result_array();
	}

	public function select_visita_sod($input=array()){
		$query = $this->db->select('idVisitaSod')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaSod");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSod" ];
		return $query->result_array();
	}

	public function insert_visita_sod($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSod";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_sod_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSodDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function insert_visita_sodFoto_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSodDetFotos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function select_visita_sod_detalle($input=array()){
		$query = $this->db->select('idVisitaSodDet')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaSodDet");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSodDet" ];
		return $query->result_array();
	}

	public function update_visita_sod($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSod";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_sod_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSodDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	/**************VISITA ENCARTES*************/
	public function detalle_visita_encartes($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				vd.idListVisibilidad
				, vd.idCategoria
				, pc.nombre AS categoria
				, vd.idMarca
				, pm.nombre AS marca
				, pm.flagCompetencia
				, CASE pm.flagCompetencia WHEN 0 THEN 'PROPIOS' WHEN 1 THEN 'COMPETENCIA' END AS competencia
			FROM {$this->sessBDCuenta}.trade.list_visibilidad v
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadDet vd ON vd.idListVisibilidad=v.idListVisibilidad
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=vd.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=vd.idMarca
			WHERE 1=1 AND v.idListVisibilidad=@idLista
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidad" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_encartes($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			e.numDet
			, ed.idVisitaEncartes
			, ed.idVisitaEncartesDet
			, ed.idCategoria
			, pc.nombre AS categoria
			, ed.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaEncartes e
		JOIN {$this->sessBDCuenta}.trade.data_visitaEncartesDet ed ON ed.idVisitaEncartes=e.idVisitaEncartes
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=ed.idVisitaFoto
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=ed.idCategoria
		WHERE 1=1 AND e.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncartes" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_encartes_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncartesDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_encarte($input=array()){
		$query = $this->db->select('idVisitaEncartes')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaEncartes");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncartes" ];
		return $query->result_array();
	}

	public function insert_visita_encarte($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncartes";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_encartes_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncartesDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/**************VISITA SEGUIMIENTO PLAN******************/
	public function detalle_visita_seguimientoPlan($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT
				sd.idListSeguimientoPlan
				, sd.idListSeguimientoPlanDet
				, sd.idSeguimientoPlan
				, sp.nombre AS seguimientoPlan
				, sd.idTipoElementoVisibilidad
				, ev.nombre AS tipoElementoVisibilidad
			FROM {$this->sessBDCuenta}.trade.list_seguimientoPlan s
			JOIN {$this->sessBDCuenta}.trade.list_seguimientoPlanDet sd ON sd.idListSeguimientoPlan=s.idListSeguimientoPlan
			LEFT JOIN {$this->sessBDCuenta}.trade.seguimientoPlan sp ON sp.idSeguimientoPlan=sd.idSeguimientoPlan
			LEFT JOIN trade.tipoElementoVisibilidad ev ON ev.idTipoElementoVisibilidad=sd.idTipoElementoVisibilidad
			WHERE 1=1 AND s.idListSeguimientoPlan=@idLista
			ORDER BY sd.idTipoElementoVisibilidad ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_seguimientoPlan" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_marca(){
		$sql = "
			SELECT idMarca, nombre as marca
			FROM trade.producto_marca WHERE estado=1 AND flagMarca=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.producto_marca' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_seguimientoPlan($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT
			sp.idVisitaSeguimientoPlan
			, sp.idSeguimientoPlan
			, sp.numDet
			, spd.idVisitaSeguimientoPlanDet
			, spd.idTipoElementoVisibilidad
			, spd.armado
			, spd.revestido
			, spd.idMotivo
			, spd.comentario
			, spd.idMarca
			, spd.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan sp
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaSeguimientoPlanDet spd ON spd.idVisitaSeguimientoPlan=sp.idVisitaSeguimientoPlan
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=spd.idVisitaFoto
		WHERE sp.idVisita=@idVisita
		ORDER BY sp.idSeguimientoPlan, spd.idTipoElementoVisibilidad ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan" ];
		return $this->db->query($sql)->result_array();
	}

	public function select_visita_seguimientoPlan($input=array()){
		$query = $this->db->select('idVisitaSeguimientoPlan')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan" ];
		return $query->result_array();
	}

	public function insert_visita_seguimientoPlan($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlan";
		$this->db->trans_begin();
		
			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_seguimientoPlan_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlanDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function update_visita_seguimientoPlan_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaSeguimientoPlanDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	/**************VISITA DESPACHOS***********/
	public function obtener_incidencias(){
		$sql = "
			SELECT idIncidencia, nombre as incidencias
			FROM master.incidencias WHERE estado=1 AND flagDespacho=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.incidencias' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_despachos($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT
			dd.idVisitaDesapachosDet
			, dd.idVisitaDespachos
			, dd.placa
			, CONVERT(VARCHAR(5),dd.horaIni) as horaIni
			, CONVERT(VARCHAR(5),dd.horaFin) as horaFin
			, dd.idIncidencia
			, dd.comentario
			, ddd.idDia
			, ddd.presencia
		FROM {$this->sessBDCuenta}.trade.data_visitaDespachos d
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaDespachosDet dd ON dd.idVisitaDespachos=d.idVisitaDespachos
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaDespachosDias ddd ON ddd.idVisitaDespachos=d.idVisitaDespachos
		WHERE d.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaDespachos" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_despachos_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaDespachosDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();
		
			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_despachos_dias($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaDespachosDias";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();
		
			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_despacho_dia($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaDespachosDias";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function insert_visita_despacho($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaDespachos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_despacho_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaDespachosDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/**************VISITA FOTOS***************/
	public function detalle_visita_fotos_visita($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		SELECT
			vf.idVisitaFoto
			, vf.fotoUrl AS foto
			, vf.idModulo
			, m.nombre AS modulo
		FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
		LEFT JOIN trade.aplicacion_modulo m ON m.idModulo=vf.idModulo
		WHERE vf.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaFotos" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tipo_foto($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			ft.idTipoFoto
			, ft.nombre AS tipoFoto
		FROM {$this->sessBDCuenta}.trade.data_visita v
		JOIN {$this->sessBDCuenta}.trade.data_ruta r ON r.idRuta=v.idRuta
		LEFT JOIN trade.foto_tipo ft ON ft.idProyecto=r.idProyecto
		WHERE v.idVisita=@idVisita AND ft.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_fotos($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT
			mf.idVisitaModuloFoto
			, mf.idTipoFoto
			, mf.nombreTipoFoto
			, mf.idVisitaFoto
			, vf.fotoUrl AS foto
			, mf.comentario
		FROM {$this->sessBDCuenta}.trade.data_visitaModuloFotos mf
		JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=mf.idVisitaFoto
		WHERE mf.idVisita=@idVisita AND mf.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaModuloFotos" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_modulo_foto($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaModuloFotos";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_modulo_foto($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaModuloFotos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/***************VISITA INVENTARIO********************/
	public function obtener_lista_visita_inventario($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT DISTINCT
				id.idListInventario
				--, id.idListInventarioDet
				, id.idProducto
				, p.nombre AS producto
			FROM {$this->sessBDCuenta}.trade.list_inventario i
			LEFT JOIN {$this->sessBDCuenta}.trade.list_inventarioDet id ON id.idListInventario=i.idListInventario
			LEFT JOIN trade.producto p ON p.idProducto=id.idProducto
			WHERE i.idListInventario=@idLista
			ORDER BY id.idProducto ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_inventario" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_inventario($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			id.idVisitaInventarioDet
			, id.idVisitaInventario
			, id.idProducto
			, id.stock_inicial
			, id.sellin
			, id.stock
			, id.validacion
			, id.obs
			, id.comentario
			--, CONVERT(VARCHAR, id.fecVenc,103) AS fecVence
			, id.fecVenc AS fecVence
		FROM {$this->sessBDCuenta}.trade.data_visitaInventario i
		JOIN {$this->sessBDCuenta}.trade.data_visitaInventarioDet id ON id.idVisitaInventario=i.idVisitaInventario
		WHERE i.idVisita=@idVisita
		ORDER BY idProducto ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaInventario" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_inventario_producto($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		WITH sellin AS(
			SELECT DISTINCT
				v.idCliente
				, si.idProducto
				, SUM(si.sellin) AS sellin
			FROM {$this->sessBDCuenta}.trade.data_visita v
			JOIN {$this->sessBDCuenta}.trade.data_ruta r ON r.idRuta=v.idRuta
			JOIN {$this->sessBDCuenta}.trade.inventario_periodo ip ON ip.idCliente=v.idCliente AND r.fecha BETWEEN ip.fecIni AND ISNULL(ip.fecFin,r.fecha) AND ip.estado=1
			JOIN {$this->sessBDCuenta}.trade.inventario_sellin si ON si.idCliente=v.idCliente AND si.fecha BETWEEN ip.fecIni AND ISNULL(ip.fecFin,r.fecha)
			WHERE v.idVisita=@idVisita 
			GROUP BY v.idCliente, si.idProducto
		), stock_inicial AS (
		SELECT DISTINCT
			v.idCliente
			, ii.idProducto
			, ii.fecha
			, SUM(ii.stock) AS stockInicial
		FROM {$this->sessBDCuenta}.trade.data_visita v
		JOIN {$this->sessBDCuenta}.trade.data_ruta r ON r.idRuta=v.idRuta
		JOIN {$this->sessBDCuenta}.trade.inventario_periodo ip ON ip.idCliente=v.idCliente AND r.fecha BETWEEN ip.fecIni AND ISNULL(ip.fecFin,r.fecha) --AND ip.estado=1
		JOIN {$this->sessBDCuenta}.trade.inventario_inicial ii ON ii.idCliente=v.idCliente AND ii.fecha BETWEEN ip.fecIni AND ISNULL(ip.fecFin,r.fecha) AND ii.estado=1
		WHERE v.idVisita=@idVisita 
		GROUP BY v.idCliente, ii.idProducto, ii.fecha)
		SELECT 
			v.idCliente
			, sti.idProducto
			--, CONVERT(VARCHAR(10), sti.fecha, 103) fecStock
			, SUM(sti.stockInicial) as stockInicial
			, si.sellin
		FROM {$this->sessBDCuenta}.trade.data_visita v 
		JOIN stock_inicial sti ON sti.idCliente = v.idCliente --AND sti.stockInicial IS NOT NULL
		LEFT JOIN sellin si ON si.idCliente=sti.idCliente AND si.idProducto=sti.idProducto --AND si.sellin IS NOT NULL
		WHERE v.idVisita=@idVisita
			AND sti.stockInicial IS NOT NULL AND si.sellin IS NOT NULL
		GROUP BY v.idCliente, sti.idProducto, si.sellin;";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.inventario_periodo" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_inventario_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaInventarioDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_inventario($input=array()){
		$query = $this->db->select('idVisitaInventario')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaInventario");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaInventario" ];
		return $query->result_array();
	}

	public function insert_visita_inventario($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaInventario";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_inventario_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaInventarioDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/******************VISITA VISIBILIDAD*******************/
	public function detalle_visita_visibilidadTrad($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT 
				vtd.idListVisibilidadDet
				, vtd.idElementoVis
				, evt.nombre AS elementoVisibilidad
			FROM {$this->sessBDCuenta}.trade.list_visibilidadTrad vt
			LEFT JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradDet vtd ON vtd.idListVisibilidad=vt.idListVisibilidad
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vtd.idElementoVis
			WHERE vtd.estado=1 AND evt.estado=1 
			AND vt.idListVisibilidad=@idLista";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_estado_elementos(){
		$sql = "
			SELECT
				ee.idEstadoElemento
				, ee.nombre AS estadoElemento
			FROM trade.estadoElementoVisibilidad ee
			WHERE ee.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.estadoElementoVisibilidad' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_visibilidadTrad($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			vtd.idVisitaVisibilidadDet
			, vtd.idVisitaVisibilidad
			, vtd.idElementoVis
			, evt.nombre AS elementoVisibilidadTrad
			, vtd.presencia
			, vtd.cantidad
			, vtd.idEstadoElemento
			, vtd.condicion_elemento
			, vtd.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad vt
		JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet vtd ON vtd.idVisitaVisibilidad=vt.idVisitaVisibilidad
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vtd.idVisitaFoto
		LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vtd.idElementoVis
		WHERE vt.idVisita=@idVisita
		ORDER BY vtd.idElementoVis ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_visibilidadTrad_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_visibilidadTrad($input=array()){
		$query = $this->db->select('idVisitaVisibilidad')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad" ];
		return $query->result_array();
	}

	public function insert_visita_visibilidadTrad($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadTrad";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_visibilidadTrad_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadTradDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/**************VISITA MANTENIMIENTO CLIENTE**************/
	public function obtener_regiones(){
		$sql = "
			SELECT
				LTRIM(RTRIM(ubi.cod_ubigeo)) AS cod_ubigeo
				, LTRIM(RTRIM(ubi.cod_departamento)) AS cod_departamento, ubi.departamento
				, LTRIM(RTRIM(ubi.cod_provincia)) AS cod_provincia, ubi.provincia
				, LTRIM(RTRIM(ubi.cod_distrito)) AS cod_distrito, ubi.distrito
			FROM General.dbo.ubigeo ubi
			WHERE ubi.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.ubigeo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_mantenimiento($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT
			m.idVisitaMantCliente
			, m.codCliente
			, LTRIM(RTRIM(m.nombreComercial)) AS nombreComercial
			, LTRIM(RTRIM(m.razonSocial)) AS razonSocial
			, m.ruc
			, m.dni
			, m.cod_ubigeo
			, m.direccion
			, m.latitud
			, m.longitud
			, ubi.cod_departamento
			, ubi.cod_distrito
			, ubi.cod_provincia
		FROM {$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente m
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=m.cod_ubigeo
		WHERE m.idVisita=@idVisita AND m.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_mantenimientoCliente($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_mantenimientoCliente($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}


	/****************VISITA INTELIGENCIA COMPETITIVA*************/
	public function detalle_visita_inteligencia($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT 
				cd.idListCategoriaMarcaCompDet
				, cd.idCategoria
				, pc.nombre AS categoria
				, cdm.idMarca
				, pm.nombre AS marca
			FROM {$this->sessBDCuenta}.trade.list_categoria_marca_competenciaTrad c
			JOIN {$this->sessBDCuenta}.trade.list_categoria_marca_competenciaTradDet cd ON cd.idListCategoriaMarcaComp=c.idListCategoriaMarcaComp
			JOIN {$this->sessBDCuenta}.trade.list_categoria_marca_competenciaTradDet_elemento cdm ON cdm.idListCategoriaMarcaCompDet=cd.idListCategoriaMarcaCompDet
			LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=cd.idCategoria
			LEFT JOIN trade.producto_marca pm ON pm.idMarca=cdm.idMarca
			WHERE cd.estado=1 AND cdm.estado=1 
			AND c.idListCategoriaMarcaComp=@idLista";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_categoria_marca_competenciaTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tipo_competencia(){
		$sql = "
			SELECT
				idTipoCompetencia
				, nombre AS tipoCompetencia
			FROM trade.competencia_tipo";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.competencia_tipo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_inteligenciaCompetitiva($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			vid.idVisitaInteligenciaTradDet
			, vid.idVisitaInteligenciaTrad
			, vid.idCategoria
			, pc.nombre AS categoria
			, vid.idMarca
			, pm.nombre AS marca
			, vid.idTipoCompetencia
			, ct.nombre AS tipoCompetencia
			, vid.comentario
			, vid.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad vi
		JOIN {$this->sessBDCuenta}.trade.data_visitaInteligenciaTradDet vid ON vid.idVisitaInteligenciaTrad=vi.idVisitaInteligenciaTrad
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vid.idVisitaFoto
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=vid.idCategoria
		LEFT JOIN trade.producto_marca pm ON pm.idMarca=vid.idMarca
		LEFT JOIN trade.competencia_tipo ct ON ct.idTipoCompetencia=vid.idTipoCompetencia
		WHERE vi.idVisita=@idVisita
		ORDER BY pc.idCategoria, pm.idMarca ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_inteligenciaTrad_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaInteligenciaTradDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_inteligencia($input=array()){
		$query = $this->db->select('idVisitaInteligenciaTrad')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad" ];
		return $query->result_array();
	}

	public function insert_visita_inteligenciaTrad($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaInteligenciaTrad";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_inteligenciaTrad_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaInteligenciaTradDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/*****************VISITA ORDENES*************************/
	public function obtener_ordenes(){
		$sql = "
			SELECT
				idOrden, nombre AS orden
			FROM trade.orden 
			WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.orden' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_orden_estado(){
		$sql = "
			SELECT
			idOrdenEstado
			, UPPER(nombre) AS ordenEstado
		FROM trade.orden_estado WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.orden_estado' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_ordenes($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			o.idVisitaOrden
			, o.idOrden
			, o.descripcion
			, o.idOrdenEstado
			, o.flagOtro
			, o.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaOrden o
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=o.idVisitaFoto
		WHERE o.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaOrden" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_orden($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaOrden";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function insert_visita_orden($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaOrden";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/******************VISITA INICIATIVAS*******************/
	public function detalle_visita_iniciativas($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT 
				itd.idListIniciativaTrad
				, itd.idListIniciativaTradDet
				, itd.idIniciativa
				, itr.nombre AS iniciativa
				, itr.descripcion AS iniciativaDescripcion
				, itde.idElementoVis idElementoIniciativa
				, eli.nombre AS elementoIniciativa
				,eit.idEstadoIniciativa
				,eit.nombre AS estadoIniciativa
			FROM {$this->sessBDCuenta}.trade.list_iniciativaTrad it
			JOIN {$this->sessBDCuenta}.trade.list_iniciativaTradDet itd ON itd.idListIniciativaTrad=it.idListIniciativaTrad
			JOIN {$this->sessBDCuenta}.trade.iniciativaTrad itr ON itr.idIniciativa=itd.idIniciativa
			LEFT JOIN {$this->sessBDCuenta}.trade.list_iniciativaTradDetElemento itde ON itde.idListIniciativaTradDet=itd.idListIniciativaTradDet
			LEFT JOIN trade.elementoVisibilidadTrad eli ON eli.idElementoVis=itde.idElementoVis
			LEFT JOIN {$this->sessBDCuenta}.trade.motivoElementoVisibilidadTrad mev ON mev.idElementoVis = eli.idElementoVis
			LEFT JOIN trade.estadoIniciativaTrad eit ON eit.idEstadoIniciativa = mev.idEstadoIniciativa
			WHERE 1=1 AND itd.estado=1 AND itde.estado=1 
			AND it.idListIniciativaTrad=@idLista";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_iniciativaTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_estado_iniciativa(){
		$sql = "
			SELECT
			idEstadoIniciativa
			, UPPER(nombre) AS estadoIniciativa
		FROM trade.estadoIniciativaTrad WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.estadoIniciativaTrad' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_iniciativas($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			vitd.*
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaIniciativaTrad vit
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet vitd ON vitd.idVisitaIniciativaTrad=vit.idVisitaIniciativaTrad
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vitd.idVisitaFoto
		WHERE vit.idVisita=@idVisita
		ORDER BY vitd.idIniciativa, vitd.idElementoIniciativa ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_iniciativasTrad_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_iniciativaTrad($input=array()){
		$query = $this->db->select('idVisitaIniciativaTrad')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad" ];
		return $query->result_array();
	}

	public function insert_visita_iniciativaTrad($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_iniciativaTrad_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/********************VISITA VISIBILIDAD AUDITORIA OBLIGATORIA********************/
	public function obtener_lista_visita_visibilidadAudObligatoria($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT 
				vaod.idListVisibilidadObl
				, vaod.idListVisibilidadOblDet
				, vaod.idElementoVis
				, evt.nombre AS elementoVisibilidad
			FROM {$this->sessBDCuenta}.trade.list_visibilidadTradObl vao
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet vaod ON vaod.idListVisibilidadObl=vao.idListVisibilidadObl
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vaod.idElementoVis
			WHERE 1=1 AND vaod.estado=1 
			AND vao.idListVisibilidadObl=@idLista
			ORDER BY evt.idElementoVis ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradObl" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_variables_visibilidad(){
		$sql = "
			SELECT
			idVariable
			, descripcion AS variableVisibilidad
			, nomCorto
		FROM trade.variableVisibilidad WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.variableVisibilidad' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_observaciones_obligatoria(){
		$sql = "
			SELECT * 
			FROM trade.observacionElementoVisibilidadObligatorio 
			WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.observacionElementoVisibilidadObligatorio' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_visita_visibilidad_obligatoria($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			vvod.idVisitaVisibilidad
			, vvod.idVisitaVisibilidadDet
			, vvod.idElementoVis
			, vvod.idVariable
			, vvod.presencia
			, vvod.idObservacion
			, vvod.comentario
			, vvod.cantidad
			, vvod.idVisitaFoto
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio vvo
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet vvod ON vvod.idVisitaVisibilidad=vvo.idVisitaVisibilidad
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vvod.idVisitaFoto
		WHERE vvo.idVisita=@idVisita
		ORDER BY vvod.idElementoVis, vvod.idVariable ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_visibilidadObligatoria_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_visibilidadObligatoria($input=array()){
		$query = $this->db->select('idVisitaVisibilidad')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio" ];
		return $query->result_array();
	}

	public function insert_visita_visibilidadObligatoria($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorio";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_visibilidadObligatoria_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadObligatorioDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/********************VISITA VISIBILIDAD AUDITORIA INICIATIVA******************/
	public function obtener_lista_visita_visibilidadAudIniciativa($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT 
				vtid.idListVisibilidadIni
				, vtid.idListVisibilidadIniDet
				, vtid.idElementoVis
				, evt.nombre AS elementoVisibilidad
			FROM {$this->sessBDCuenta}.trade.list_visibilidadTradIni vti
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradIniDet vtid ON vtid.idListVisibilidadIni=vti.idListVisibilidadIni
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vtid.idElementoVis
			WHERE 1=1 AND vtid.estado=1 
			AND vti.idListVisibilidadIni=@idLista
			ORDER BY evt.idElementoVis ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradIni" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_observaciones_iniciativa(){
		$sql = "
			SELECT * 
			FROM trade.observacionElementoVisibilidadIniciativa
			WHERE estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.observacionElementoVisibilidadIniciativa' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_visibilidad_iniciativa($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			vvid.*
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa vvi
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet vvid ON vvid.idVisitaVisibilidad=vvi.idVisitaVisibilidad
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vvid.idVisitaFoto
		WHERE vvi.idVisita=@idVisita
		ORDER BY vvid.idElementoVis ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_visibilidadIniciativa_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_visibilidadIniciativa($input=array()){
		$query = $this->db->select('idVisitaVisibilidad')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa" ];
		return $query->result_array();
	}

	public function insert_visita_visibilidadIniciativa($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativa";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_visibilidadIniciativa_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadIniciativaDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	/******************VISITA VISIBILIDAD AUDITORIA ADICIONAL**********************/
	public function obtener_lista_visita_visibilidadAudAdicional($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			SELECT 
				vvad.idListVisibilidadAdc
				, vvad.idListVisibilidadAdcDet
				, vvad.idElementoVis
				, evt.nombre AS elementoVisibilidad
			FROM {$this->sessBDCuenta}.trade.list_visibilidadTradAdc vva
			JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradAdcDet vvad ON vvad.idListVisibilidadAdc=vva.idListVisibilidadAdc
			LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vvad.idElementoVis
			WHERE 1=1 AND vvad.estado=1 
			AND vva.idListVisibilidadAdc=@idLista
			ORDER BY evt.idElementoVis ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTradAdc" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_visibilidad_adicional($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		--------------------
		SELECT 
			vvad.*
			, vf.fotoUrl AS foto
		FROM {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional vva
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet vvad ON vvad.idVisitaVisibilidad=vva.idVisitaVisibilidad
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisitaFoto=vvad.idVisitaFoto
		WHERE vva.idVisita=@idVisita
		ORDER BY vvad.idElementoVis ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_visita_visibilidadAdicional_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function select_visita_visibilidadAdicional($input=array()){
		$query = $this->db->select('idVisitaVisibilidad')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional" ];
		return $query->result_array();
	}

	public function insert_visita_visibilidadAdicional($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicional";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_visibilidadAdicional_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaVisibilidadAdicionalDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}


	/*******************VISITA ENCUESTA************************/
	public function detalle_visita_encuesta_premio(){
		$sql="
			SELECT
				ep.idEncuesta
				, ep.nombre AS encuestaPremio
				, ep.descripcion
				, ep.foto_obligatoria
				, epp.idPregunta
				, epp.idPreguntaTipo
				, epp.enunciado AS pregunta
				, epp.obligatoria
				, epa.idAlternativa
				, epa.enunciado AS alternativa
			FROM {$this->sessBDCuenta}.trade.encuesta_premio ep
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_premio_pregunta epp ON epp.idEncuesta=ep.idEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_premio_alternativa epa ON epa.idPregunta=epp.idPregunta
			WHERE ep.estado=1 AND epp.estado=1 --AND epa.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.encuesta_premio" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_visita_encuesta_premio($input=array()){
		$idVisita = $input['idVisita'];

		$sql="
		DECLARE @idVisita INT=$idVisita;
		-----------------------
		SELECT 
			vep.idVisitaEncuesta
			, vep.idEncuesta
			, vep.idVisitaFoto
			, vf.fotoUrl AS foto
			, vepd.idVisitaEncuestaDet
			, vepd.idPregunta
			, epp.idPreguntaTipo
			, vepd.respuesta
		FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaPremio vep
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet vepd ON vepd.idVisitaEncuesta=vep.idVisitaEncuesta
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf On vf.idVisitaFoto=vep.idVisitaFoto
		LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_premio_pregunta epp ON epp.idPregunta=vepd.idPregunta
		WHERE vep.idVisita=@idVisita";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio" ];
		return $this->db->query($sql)->result_array();
	}

	public function select_visita_encuestaPremio($input=array()){
		$query = $this->db->select('idVisitaEncuesta')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio" ];
		return $query->result_array();
	}

	public function select_visita_encuestaPremio_detalle($input=array()){
		$query = $this->db->select('idVisitaEncuestaDet')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet" ];
		return $query->result_array();
	}

	public function insert_visita_encuestaPremio($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insert_visita_encuestaPremio_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $insert ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'INSERTAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $insert;
	}

	public function update_visita_encuesta_premio($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_encuestaPremio_detalle($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function update_visita_encuestaPremio_detalle_tipo3($idVisita){
		$sql = "
			UPDATE {$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet SET estado=0
			WHERE idVisitaEncuestaDet IN (
			SELECT idVisitaEncuestaDet
			FROM {$this->sessBDCuenta}.trade.data_visitaEncuestaPremio vep 
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaEncuestaPremioDet vepd ON vepd.idVisitaEncuesta=vep.idVisitaEncuesta
			LEFT JOIN {$this->sessBDCuenta}.trade.encuesta_premio_pregunta epp ON epp.idPregunta=vepd.idPregunta
			WHERE vep.idVisita=$idVisita AND epp.idPreguntaTipo=3)
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaEncuestaPremio" ];
		return $this->db->query($sql);
	}

	// CARGA DE DATOS FUNCIONES

	public function validar_existencia_modulo($input=array()){
		$table = $input['tabla']; 
		$where = $input['arrayWhere'];
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$result=$this->db->get();
		if(count($result->result_array())>0){
			return true;
		}else{
			return false;
		}
	}


	public function insertar_tabla($table,$input=array()){
		$aSessTrack = [];

		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	public function insertar_visita_foto($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visitaFotos";
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	public function update_visita($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visita";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		/****GUARDAR AUDITORIA****/
		if ( $update ){
			$arrayAuditoria = array(
				'idUsuario' => $this->idUsuario
				,'accion' => 'ACTUALIZAR'
				,'tabla' => $table
				,'sql' => $this->db->last_query()
			);
			guardarAuditoria($arrayAuditoria);
		}
		/****FIN GUARDAR AUDITORIA****/

		return $update;
	}

	public function detalle_visita_visibilidadTrad_nomodulados($input=array()){
		$idLista = $input['idListaModuloVisita'];

		$sql="
			DECLARE @idLista INT=$idLista;
			---------
			WITH elementos_modulados AS (
				---------
				SELECT 
					vtd.idListVisibilidadDet
					, vtd.idElementoVis
					, evt.nombre AS elementoVisibilidad
				FROM {$this->sessBDCuenta}.trade.list_visibilidadTrad vt
				LEFT JOIN {$this->sessBDCuenta}.trade.list_visibilidadTradDet vtd ON vtd.idListVisibilidad=vt.idListVisibilidad
				LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vtd.idElementoVis
				WHERE vtd.estado=1 AND evt.estado=1 
				AND vt.idListVisibilidad=@idLista 
			) 
			SELECT 
			evt.idElementoVis
			, evt.nombre AS elementoVisibilidad
			FROM {$this->sessBDCuenta}.trade.master_listaElementos me
			JOIN {$this->sessBDCuenta}.trade.master_listaElementosDet med ON med.idLista = me.idLista AND med.idElementoVisibilidad  NOT IN(SELECT idElementoVis FROM elementos_modulados)
			LEFT JOIN  trade.elementoVisibilidadTrad evt ON evt.idElementoVis=med.idElementoVisibilidad
			WHERE General.dbo.fn_fechaVigente(me.fecIni,me.fecFin,GETDATE(),GETDATE())=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_visibilidadTrad" ];
		return $this->db->query($sql)->result_array();
	}

	public function get_cantidad_fotos_visita($input)
	{
		$filtros = '';

		!empty($input['idVisita']) ? $filtros .= " AND vf.idVisita = {$input['idVisita']}" : '';
		$sql = "
		SELECT 
		COUNT(vf.idVisitaFoto) fotos
		FROM {$this->sessBDCuenta}.trade.data_visitaFotos vf
		JOIN trade.aplicacion_modulo m ON m.idModulo = vf.idModulo
		WHERE m.idModuloGrupo = 9  {$filtros}
		";

		return $this->db->query($sql);
	}

}
?>