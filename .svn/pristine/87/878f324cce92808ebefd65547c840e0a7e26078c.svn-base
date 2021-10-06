<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_visitas extends MY_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
	}

	public function obtener_lista_rutas($input=array()){
		$filtros = "";
		$filtros.= !empty($input['listaCuentas']) ? " AND r.idCuenta IN (".$input['listaCuentas'].")":"";
		$filtros.= !empty($input['listaProyectos']) ? " AND r.idProyecto IN (".$input['listaProyectos'].")":"";
		$filtros.= !empty($input['cuenta']) ? " AND r.idCuenta=".$input['cuenta']:"";
		$filtros.= !empty($input['proyecto']) ? " AND r.idProyecto=".$input['proyecto']:"";
		$filtros.= !empty($input['usuario']) ? " AND r.idUsuario=".$input['usuario']:"";

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT 
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idUsuario
			, r.nombreUsuario
			, r.numVisita
			, r.idTipoUsuario
			, r.tipoUsuario
			, r.estado
			, c.idCuenta
			, c.nombre AS cuenta
			, py.idProyecto
			, py.nombre AS proyecto
			, ec.idUsuario AS idUsuarioEncargado
			, u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS nombreUsuarioEncargado
		FROM trade.data_ruta r
		LEFT JOIN trade.cuenta c ON c.idCuenta=r.idCuenta
		LEFT JOIN trade.proyecto py ON py.idProyecto=r.idProyecto
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario u ON u.idUsuario=ec.idUsuario
		WHERE 1=1 --AND r.demo=0
		AND r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY r.fecha, r.idCuenta, r.idProyecto, r.nombreUsuario ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_visitas($input=array()){
		$filtros = "";
		$filtros.= !empty($input['listaCuentas']) ? " AND r.idCuenta IN (".$input['listaCuentas'].")":"";
		$filtros.= !empty($input['listaProyectos']) ? " AND r.idProyecto IN (".$input['listaProyectos'].")":"";
		
		$filtros.= !empty($input['cuenta']) ? " AND r.idCuenta=".$input['cuenta']:"";
		$filtros.= !empty($input['proyecto']) ? " AND r.idProyecto=".$input['proyecto']:"";
		$filtros.= !empty($input['grupoCanal']) ? " AND cn.idGrupoCanal=".$input['grupoCanal'] : "";
		$filtros.= !empty($input['canal']) ? " AND v.idCanal=".$input['canal'] : "";
		$filtros.= !empty($input['usuario']) ? " AND r.idUsuario=".$input['usuario']:"";
		
		$filtros.= !empty($input['zona']) ? " AND v.idZona=".$input['idZona']:"";
		$filtros.= !empty($input['idDistribuidoraSucursal']) ? " AND v.idDistribuidoraSucursal=".$input['sucursal']:"";
		
		$filtros.= !empty($input['plaza']) ? " AND v.idPlaza=".$input['idPlaza']:"";
		
		$filtros.= !empty($input['banner']) ? " AND v.idBanner=".$input['banner']:"";
		
		$filtros.= !empty($input['cod_usuario']) ? " AND r.idUsuario=".$input['cod_usuario']:"";
		$filtros.= !empty($input['cod_cliente']) ? " AND v.idCliente=".$input['cod_cliente']:"";
		

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT 
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idUsuario
			, r.nombreUsuario
			, r.numVisita
			, v.idVisita
			, v.idCliente
			, v.estadoIncidencia
			, v.razonSocial
			, v.idCanal
			, v.canal
			, cn.idGrupoCanal
			, v.direccion
			, v.idPlaza
			, pl.nombre AS plaza
			, v.idDistribuidoraSucursal
			, d.nombre+' '+ubi.distrito AS distribuidora
			, v.estado
			, v.idTipoExclusion
			, v.flagContingencia
		FROM trade.data_ruta r
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.canal cn ON cn.idCanal=v.idCanal
		WHERE 1=1 AND r.estado=1 --AND r.demo=0
		{$filtros} 
		AND r.fecha BETWEEN @fecIni AND @fecFin
		ORDER BY r.fecha ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_estado_ruta_visita($input=array()){
		$aSessTrack = [];

		if ($input['tabla']=='rutas') {
			$table = 'trade.data_ruta';
			$where = array('idRuta'=>$input['idRuta']);
		} elseif ($input['tabla']=='visitas') {
			$table = 'trade.data_visita';
			$where = array('idVisita'=>$input['idVisita']);
		}
		
		$params['estado'] = $input['estado'];

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

		return $update;
	}

	public function obtener_cuenta_proyecto($input=array()){
		$filtros = "";
			$filtros.= !empty($input['listaCuentas']) ? " AND c.idCuenta IN (".$input['listaCuentas'].")":"";
			$filtros.= !empty($input['listaProyectos']) ? " AND p.idProyecto IN (".$input['listaProyectos'].")":"";

		$sql="
		DECLARE @fecha DATE=GETDATE();
		SELECT
			c.idCuenta
			, UPPER(c.nombreComercial) AS cuenta
			, p.idProyecto
			, UPPER(p.nombre) AS proyecto
		FROM trade.cuenta c 
		JOIN trade.proyecto p ON p.idCuenta=c.idCuenta
		WHERE c.estado=1 AND p.estado=1
		AND @fecha BETWEEN p.fecIni AND ISNULL(p.fecFin,@fecha)
		{$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_grupocanal_canal_usuarioHistorico($input=array()){
		$filtros='';
		$filtros.= !empty($input['idUsuario']) ? " AND uh.idUsuario IN (".$input['idUsuario'].")":"";

		$sql="DECLARE @fecha DATE=GETDATE();
		-----
		SELECT
			cc.idCuenta
			, gc.idGrupoCanal, UPPER(gc.nombre) AS grupoCanal
			, cc.idCanal, UPPER(cn.nombre) AS canal
		FROM trade.usuario_historico uh
		JOIN trade.usuario_historicoCanal uhc ON uhc.idUsuarioHist=uh.idUsuarioHist
		JOIN trade.canal cn ON cn.idCanal=uhc.idCanal
		JOIN trade.cuenta_canal cc ON cc.idCanal=cn.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal=cn.idGrupoCanal
		WHERE uh.estado=1 AND uhc.estado=1 AND uh.idAplicacion IN (2)
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		{$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoCanal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_grupocanal_canal(){
		$sql="SELECT 
			cc.idCuenta
			, gc.idGrupoCanal, UPPER(gc.nombre) AS grupoCanal
			, cc.idCanal, UPPER(c.nombre) AS canal
		FROM trade.cuenta_canal cc
		JOIN trade.canal c ON c.idCanal=cc.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal=c.idGrupoCanal
		WHERE cc.estado=1 AND c.estado=1 AND gc.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta_canal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cuenta_proyecto_tipousuario_usuario($input=array()){
		$filtros = "";
		$filtros.= !empty($input['listaCuentas']) ? " AND ap.idCuenta IN (".$input['listaCuentas'].")":"";
		$filtros.= !empty($input['listaProyectos']) ? " AND uh.idProyecto IN (".$input['listaProyectos'].")":"";

		$sql="
		DECLARE @fecha DATE=GETDATE();
		SELECT
			ap.idCuenta
			, uh.idProyecto
			, uh.idTipoUsuario
			, ut.nombre AS tipoUsuario
			, uh.idUsuario
			, u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS nombreUsuario
		FROM trade.usuario_historico uh
		JOIN trade.aplicacion ap ON ap.idAplicacion=uh.idAplicacion
		JOIN trade.usuario_tipo ut ON ut.idTipoUsuario=uh.idTipoUsuario
		JOIN trade.usuario u ON u.idUsuario=uh.idUsuario
		WHERE uh.estado=1 
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		AND ap.estado=1 AND ap.flagAndroid = 1
		AND ut.estado=1
		AND u.estado=1 --AND u.demo=0
		{$filtros}
		ORDER BY ap.idCuenta, uh.idProyecto, uh.idTipoUsuario, uh.idUsuario ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_tipo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_clientes($input=array()){
		$filtros = "";
			$filtros .= ( isset($input['idCuenta']) && !empty($input['idCuenta']) ) ? " AND ch.idCuenta IN (".$input['idCuenta'].")" : "";
			$filtros .= ( isset($input['idProyecto']) && !empty($input['idProyecto']) ) ? " AND ch.idProyecto IN (".$input['idProyecto'].")" : "";
			$filtros .= ( isset($input['idCanal']) && !empty($input['idCanal']) ) ? " AND sn.idCanal IN (".$input['idCanal'].")" : '';
			$filtros .= ( isset($input['razonSocial']) && !empty($input['razonSocial']) ) ? " AND REPLACE(REPLACE(ch.razonSocial,NCHAR(34),''),NCHAR(39),'') like ('%{$input['razonSocial']}%')": '';
			$filtros .= ( isset($input['idCliente']) && !empty($input['idCliente']) ) ? " AND c.idCliente ='".$input['idCliente']."' " : '';
		$sql="
		DECLARE @fecha DATE='".$input['fecha']."'
		---------------
		SELECT 
			ch.idCliente
			, ch.razonSocial
			, ch.nombreComercial
			, ch.direccion
		FROM trade.cliente c
		JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=c.idCliente
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
		WHERE c.estado=1 AND ch.estado=1
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_verificacion_existente($input=array()){

		$query = $this->db->select('idRuta')
				->where( array('idUsuario'=>$input['idUsuario'],'fecha'=>$input['fecha'], 'estado'=>1 ) )
				->get('trade.data_ruta');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];
		return $query->result_array();
	}

	public function insertar_ruta($input=array()){
		$aSessTrack = [];

		$table = 'trade.data_ruta';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$this->insertId = $this->db->insert_id();
			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $this->insertId ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insertar_visita($input=array()){
		$aSessTrack = [];

		$table = 'trade.data_visita';
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

	public function obtener_ruta_actual($idRuta){
		$query = $this->db->select('*')
				->where( array('idRuta'=>$idRuta) )
				->get('trade.data_ruta');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];
		return $query->result_array();
	}

	public function obtener_lista_ruta_visitas($idRuta){
		$query = $this->db->select('idCliente')
				->where( array('idRuta'=>$idRuta, 'estado'=>1) )
				->get('trade.data_visita');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $query->result_array();
	}

	public function obtener_lista_rutas_reprogramar($input=array()){
		$filtros = "";
		$filtros .= ( isset($input['idRutasString']) && !empty($input['idRutasString']) ) ? ' AND r.idRuta IN ('.$input['idRutasString'].')' : '';

		$sql = "
		SELECT 
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idUsuario
			, r.nombreUsuario
			, r.numVisita
			, r.estado
		FROM trade.data_ruta r
		WHERE 1=1 --AND r.demo=0
		{$filtros}
		ORDER BY r.fecha ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_usuarios($input=array()){
		$filtros = "";
		$filtros.= !empty($input['listaCuentas']) ? " AND py.idCuenta IN (".$input['listaCuentas'].")":"";
		$filtros.= !empty($input['listaProyectos']) ? " AND uh.idProyecto IN (".$input['listaProyectos'].")":"";
		$filtros.= !empty($input['idUsuario']) ? " AND u.idUsuario IN (".$input['idUsuario'].")":"";

		$sql=" 
		DECLARE @fecha DATE=GETDATE();
		----
		SELECT
			uh.idUsuario
			, u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS nombreUsuario
		FROM trade.usuario_historico uh
		JOIN trade.aplicacion ap ON ap.idAplicacion=uh.idAplicacion
		JOIN trade.usuario u ON u.idUsuario=uh.idUsuario
		LEFT JOIN trade.proyecto py ON py.idProyecto=uh.idProyecto
		WHERE uh.estado=1
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		AND ap.estado=1 AND ap.flagAndroid=1
		AND u.estado=1 --AND u.demo=0
		{$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_reprogramar_ruta($input=array()){
		$aSessTrack = [];

		$table = 'trade.data_ruta';
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

		return $update;
	}

	public function obtener_lista_editar_ruta_visitas($idRuta){
		$sql="
		SELECT
			CONVERT(VARCHAR, r.fecha,103) AS fecha
			,r.nombreUsuario
			, r.idCuenta
			, r.idProyecto
			, v.idCliente
			, v.razonSocial
			, v.direccion
		FROM trade.data_ruta r
		LEFT JOIN trade.data_visita v ON v.idRuta=r.idRuta
		WHERE r.idRuta={$idRuta}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_ruta' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_verificacion_existente_visita($input=array()){

		$query = $this->db->select('idVisita')
				->where( $input )
				->get('trade.data_visita');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $query->result_array();
	}
	public function obtener_verificacion_existente_visita_cliente($input=array()){
		$sql = "
		SELECT idVisita 
		FROM
		trade.data_visita
		WHERE idRuta = {$input['idRuta']} AND idCliente ='{$input['idCliente']}'
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $this->db->query($sql)->result_array();

	}

	public function delete_visita_det($input=array()){
		$aSessTrack = [];
		$table = 'trade.data_visitaDet';
		
		$this->db->trans_begin();
			$delete = $this->db->delete($table, $input);
			$aSessTrack = [ 'idAccion' => 8, 'tabla' => $table, 'id' => arrayToString($input) ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $delete;
	}

	public function delete_visita_detalle($input=array()){
		$sql="
		DECLARE @idRuta INT= ".$input['idRuta'].", @idCliente INT=".$input['idCliente']." ;
		DELETE FROM trade.data_visitaDet WHERE idVisita IN (
			SELECT idVisita FROM trade.data_visita WHERE idRuta IN (@idRuta) AND idCliente IN (@idCliente)
		)";

		$this->aSessTrack[] = [
				'idAccion' => 8,
				'tabla' => 'trade.data_visitaDet',
				'id' => arrayToString([ 'idRuta' => $input['idRuta'], 'idCliente' => $input['idCliente'] ])
			];
		return $this->db->query($sql)->result_array();
	}

	public function delete_visita($input=array()){
		$aSessTrack = [];

		$table = 'trade.data_visita';
		$this->db->trans_begin();

			$delete = $this->db->delete($table, $input);
			$aSessTrack = [ 'idAccion' => 8, 'tabla' => $table, 'id' => arrayToString($input) ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $delete;
	}

	public function obtener_lista_ruta_visitas_total($idRuta){
		$query = $this->db->select('idCliente')
				->where( array('idRuta'=>$idRuta) )
				->get('trade.data_visita');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $query->result_array();
	}

	public function obtener_lista_visitas_reprogramar($input=array()){
		$filtros = "";
		$filtros .= ( isset($input['idVisitasString']) && !empty($input['idVisitasString']) ) ? ' AND v.idVisita IN ('.$input['idVisitasString'].')' : '';

		$sql = "
		SELECT 
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idUsuario
			, r.nombreUsuario
			, r.numVisita
			, r.estado
			, v.idVisita
			, v.idCliente
			, v.razonSocial
			, v.direccion
			, v.horaIni
			, v.horaFin
		FROM trade.data_ruta r
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		WHERE 1=1 --AND r.demo=0
		{$filtros}
		ORDER BY r.fecha, r.idUsuario ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $this->db->query($sql)->result_array();
	}


	public function actualizar_listas($input=array()){
		$filtros="";
		if (!empty($input['cuenta'])) $filtros .= " AND idCuenta= " . $input['cuenta'];
		$sql="
			DECLARE @fecha date=getdate();
			update trade.data_visita 
			set estado=estado
			where idRuta in(
			select idRuta from trade.data_ruta
			WHERE fecha >=@fecha
			{$filtros}
			);";
		return $this->db->query($sql);
	}

	public function obtenerProyectoCuentaUsuario($input = array()){
		$filtros = "";
		$filtros .= ( isset($input['idUsuario']) && !empty($input['idUsuario']) ) ? ' AND u.idUsuario = ('.$input['idUsuario'].')' : '';

		$sql="
		SELECT TOP 1
			uh.idProyecto
			, c.idCuenta
		FROM trade.usuario u
		JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
		JOIN trade.proyecto p ON uh.idProyecto = p.idProyecto
		JOIN trade.cuenta c ON p.idCuenta = c.idCuenta
		WHERE 1 = 1 {$filtros}
		ORDER BY uh.idUsuarioHist DESC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}

	public function obtener_tipo_exclusion(){
		$sql="
			select idTipoExclusion,nombre 
			from trade.exclusion_tipo
			where estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.exclusion_tipo' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_estado_exclusion_visita($input=array()){
		$aSessTrack = [];
		$table = 'trade.data_visita';
		$where = array('idVisita'=>$input['idVisita']);
		
		$params['idTipoExclusion'] = $input['idTipoExclusion'];
		$params['comentarioExclusion'] = $input['comentarioExclusion'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);
			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => $input['idVisita'] ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function obtener_proyecto_general($idProyecto){
		$sql="
			SELECT 
				idProyectoGeneral 
			FROM 
				trade.proyecto 
			WHERE 
				idProyecto=$idProyecto 
				AND estado=1
		";
		return $this->db->query($sql)->row_array();
	}
	
	
	public function obtener_tipo_usuario($idProyecto){
		$sql="
			SELECT DISTINCT
				  idTipoUsuario
				, nombre 
			FROM 
				trade.usuario_tipo 
			WHERE 
				idTipoUsuario IN (
					SELECT idTipoUsuario FROM trade.tipo_usuario_proyecto WHERE idProyectoGeneral=$idProyecto
				) 
				AND estado=1
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_proyecto_general_1($idTipoUsuario,$idProyecto){
		$sql="
			SELECT DISTINCT
				up.idProyectoGeneral
			FROM 
				trade.proyecto p
				JOIN trade.tipo_usuario_proyecto up 
					ON p.idProyectoGeneral=up.idProyectoGeneral
			WHERE 
				up.idTipoUsuario=$idTipoUsuario
				AND idProyecto=$idProyecto
				AND up.estado=1
				AND p.estado=1
	
		";
		return $this->db->query($sql)->row_array();
	}
	
	public function obtener_grupocanal_general($id){
		$sql="
			SELECT DISTINCT
				idGrupoCanalGeneral
			FROM 
				trade.grupoCanal
			WHERE 
				idGrupoCanal=$id
				AND estado=1
	
		";
		return $this->db->query($sql)->row_array();
	}
	
	
	public function obtener_zona(){
		$sql="SELECT idZona,nombre FROM trade.zona z WHERE estado = 1 AND idCuenta=3 AND idProyecto=3 ORDER BY z.nombre";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_cadena(){
		$sql="SELECT idCadena,nombre FROM trade.cadena WHERE estado=1";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_banner($input=array()){
		$sql="
			SELECT * FROM trade.banner WHERE estado=1 AND idCadena= ".$input['idCadena']."
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_ciudad(){
		$sql="SELECT DISTINCT cod_departamento,departamento FROM General.dbo.ubigeo WHERE estado=1";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_plazas($input=array()){
		$sql="
			SELECT DISTINCT
				  p.idPlaza
				, p.nombre
			FROM 
				trade.plaza p
				JOIN General.dbo.ubigeo ub
					ON ub.cod_ubigeo = p.cod_ubigeo
					AND ub.estado=1
			WHERE 
				p.estado=1
				AND ub.cod_departamento= ".$input['cod_departamento']." ";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_distribuidora($input=array()){
		$sql="
			SELECT DISTINCT
				  ds.idDistribuidora
				, d.nombre
			FROM 
				trade.distribuidoraSucursal ds
				JOIN trade.distribuidora d
					ON d.idDistribuidora = ds.idDistribuidora
			WHERE 
				ds.idZona= ".$input['idZona']."
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_distribuidora_sucursal($input=array()){
		$sql="
			SELECT 
				  ds.idDistribuidoraSucursal
				, ub.provincia
			FROM 
				trade.distribuidoraSucursal ds
				JOIN trade.distribuidora d
					ON d.idDistribuidora = ds.idDistribuidora
				JOIN General.dbo.ubigeo ub
					ON ub.cod_ubigeo=ds.cod_ubigeo
			WHERE 
				ds.idDistribuidora=".$input['idDistribuidora']."
				AND ds.idZona=".$input['idZona']."
		";
		return $this->db->query($sql)->result_array();
	}
	
	
	public function update_estado_contingencia_visita($input=array()){
		$aSessTrack = [];

		if ($input['tabla']=='rutas') {
			$table = 'trade.data_ruta';
			$where = array('idRuta'=>$input['idRuta']);
		} elseif ($input['tabla']=='visitas') {
			$table = 'trade.data_visita';
			$where = array('idVisita'=>$input['idVisita']);
		}
		
		$params['flagContingencia'] = 1;

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

		return $update;
	}
	
	public function update_estado_contingencia_visita_desactivar($input=array()){
		$aSessTrack = [];

		if ($input['tabla']=='rutas') {
			$table = 'trade.data_ruta';
			$where = array('idRuta'=>$input['idRuta']);
		} elseif ($input['tabla']=='visitas') {
			$table = 'trade.data_visita';
			$where = array('idVisita'=>$input['idVisita']);
		}
		
		$params['flagContingencia'] = 0;

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

		return $update;
	}

	public function obtener_estado_carga(){
		$sql="
			SELECT 
				  c.idCarga
				, c.carpeta
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
				, totalRegistros
				, (SELECT count(*) FROM trade.cargaProgramacionRutasDet  WHERE idCarga= c.idCarga) total_procesados
				, CONVERT(VARCHAR,fechaRegistro,103) fechaRegistro
				, CONVERT(VARCHAR,fechaRegistro,108) horaRegistro
				, CONVERT(VARCHAR,finRegistro,108) horaFinRegistro
				, c.estado
				, (SELECT count(*) FROM trade.cargaProgramacionRutasDet  WHERE idCarga= c.idCarga AND  comentario <>'' ) error
			FROM 
				trade.cargaProgramacionRutas c
				JOIN trade.usuario_tipo ut
					ON ut.idTipoUsuario=c.idTipoUsuario
				JOIN trade.usuario u
					ON u.idUsuario = c.idUsuarioRegistro
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_estado_carga_exclusiones(){
		$sql="
			SELECT 
				  c.idCarga
				, c.carpeta
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
				, totalRegistros
				, (SELECT count(*) FROM trade.cargaExclusionesRutasDet  WHERE idCarga= c.idCarga) total_procesados
				, CONVERT(VARCHAR,fechaRegistro,103) fechaRegistro
				, CONVERT(VARCHAR,fechaRegistro,108) horaRegistro
				, CONVERT(VARCHAR,finRegistro,108) horaFinRegistro
				, c.estado
				, (SELECT count(*) FROM trade.cargaExclusionesRutasDet  WHERE idCarga= c.idCarga AND  comentario <>'' ) error
			FROM 
				trade.cargaExclusionesRutas c
				JOIN trade.usuario_tipo ut
					ON ut.idTipoUsuario=c.idTipoUsuario
				JOIN trade.usuario u
					ON u.idUsuario = c.idUsuarioRegistro
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_errores($id){
		$sql="
			SELECT * FROM trade.cargaProgramacionRutasDet  WHERE idCarga=$id AND comentario <>''
		";
		return $this->db->query($sql)->result_array();
	}
	
}
?>