<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_visitas extends MY_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
	}

	public function obtener_lista_rutas($input=array())
	{

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		$filtros = "";
		// $filtros.= !empty($input['listaCuentas']) ? " AND r.idCuenta IN (".$input['listaCuentas'].")":"";
		// $filtros.= !empty($input['listaProyectos']) ? " AND r.idProyecto IN (".$input['listaProyectos'].")":"";
		
		$filtros.= !empty($input['cuenta']) ? " AND r.idCuenta=".$input['cuenta']:"";
		$filtros.= !empty($input['proyecto']) ? " AND r.idProyecto=".$input['proyecto']:"";
		$filtros.= !empty($input['usuario']) ? " AND r.idUsuario=".$input['usuario']:"";
		$filtros.= !empty($input['cod_usuario']) ? " AND r.idUsuario=".$input['cod_usuario']:"";
		$filtros.= !empty($input['tipoUsuario']) ? " AND r.idTipoUsuario=".$input['tipoUsuario']:"";

		$filtros.= !empty($input['grupoCanal']) ? " AND gc.idGrupoCanal=".$input['grupoCanal'] : "";
		$filtros.= !empty($input['canal']) ? " AND uhc.idCanal=".$input['canal'] : "";
		$filtros.= !empty($input['zona']) ? " AND uhz.idZona=".$input['zona']:"";
		$filtros.= !empty($input['sucursal']) ? " AND uhds.idDistribuidoraSucursal=".$input['sucursal']:"";
		$filtros.= !empty($input['distribuidora']) ? " AND ds.idDistribuidora=".$input['distribuidora']:"";
		
		$filtros.= !empty($input['plaza']) ? " AND uhpl.idPlaza=".$input['plaza']:"";
		$filtros.= !empty($input['banner']) ? " AND uhb.idBanner=".$input['banner']:"";

		if(!empty($input['estadoUsuario']) && ($input['estadoUsuario'] == 1 || $input['estadoUsuario'] == 2)){
			$filtros .= $input['estadoUsuario'] == 1  ? ' AND r.idUsuario IN(SELECT idUsuario FROM list_usuarios_activos)' : ''; 
			$filtros .= $input['estadoUsuario'] == 2  ? ' AND r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos)' : ''; 
		}else{
			$filtros .= !empty($input['estadoUsuario']) && $input['estadoUsuario'] == 3  ? ' AND 1<>1 ' : ''; 
		}
		
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND (r.demo = 0 OR r.demo IS NULL)";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		WITH list_usuarios_activos as(
			SELECT DISTINCT
			u.idUsuario
			FROM
			trade.usuario u 
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@fecha,@fecha) = 1 AND uh.idProyecto IN (".$input['listaProyectos'].")
		)
		SELECT DISTINCT
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
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
			, SUM(CASE WHEN v.horaIni IS NOT NULL THEN 1 ELSE 0 END) OVER (PARTITION BY r.idRuta) visitasData
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta = r.idRuta
		LEFT JOIN trade.cuenta c ON c.idCuenta=r.idCuenta
		LEFT JOIN trade.proyecto py ON py.idProyecto=r.idProyecto
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario u ON u.idUsuario=ec.idUsuario
		LEFT JOIN trade.usuario_historico uh ON uh.idUsuario = r.idUsuario
			AND uh.idTipoUsuario = r.idTipoUsuario
			AND r.fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,r.fecha)
		LEFT JOIN trade.usuario_historicoCanal uhc ON uhc.idUsuarioHist = uh.idUsuarioHist
		LEFT JOIN trade.canal ca ON ca.idCanal = uhc.idCanal
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
		LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist
		LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhds ON uhds.idUsuarioHist = uh.idUsuarioHist
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhds.idDistribuidoraSucursal
		LEFT JOIN trade.usuario_historicoPlaza uhpl ON uhpl.idUsuarioHist = uh.idUsuarioHist
		LEFT JOIN trade.usuario_historicoZona  uhz ON uhz.idUsuarioHist = uh.idUsuarioHist
		WHERE 1=1 
		AND r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY fecha, nombreUsuario ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_visitas($input=array())
	{

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		$filtros = "";
		// $filtros.= !empty($input['listaCuentas']) ? " AND r.idCuenta IN (".$input['listaCuentas'].")":"";
		// $filtros.= !empty($input['listaProyectos']) ? " AND r.idProyecto IN (".$input['listaProyectos'].")":"";
		
		$filtros.= !empty($input['cuenta']) ? " AND r.idCuenta=".$input['cuenta']:"";
		$filtros.= !empty($input['proyecto']) ? " AND r.idProyecto=".$input['proyecto']:"";
		$filtros.= !empty($input['grupoCanal']) ? " AND cn.idGrupoCanal=".$input['grupoCanal'] : "";
		$filtros.= !empty($input['canal']) ? " AND cn.idCanal=".$input['canal'] : "";
		$filtros.= !empty($input['usuario']) ? " AND r.idUsuario=".$input['usuario']:"";
		
		$filtros.= !empty($input['cod_usuario']) ? " AND r.idUsuario=".$input['cod_usuario']:"";
		$filtros.= !empty($input['cod_cliente']) ? " AND v.idCliente=".$input['cod_cliente']:"";
		$filtros.= !empty($input['tipoUsuario']) ? " AND r.idTipoUsuario=".$input['tipoUsuario']:"";

		$filtros.= !empty($input['zona']) ? " AND z.idZona=".$input['zona']:"";
		$filtros.= !empty($input['sucursal']) ? " AND ds.idDistribuidoraSucursal=".$input['sucursal']:"";
		$filtros.= !empty($input['distribuidora']) ? " AND d.idDistribuidora=".$input['distribuidora']:"";
		$filtros.= !empty($input['plaza']) ? " AND pl.idPlaza=".$input['plaza']:"";
		$filtros.= !empty($input['banner']) ? " AND b.idBanner=".$input['banner']:"";
		
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND (r.demo = 0 OR r.demo IS NULL)";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal']]);

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		WITH list_usuarios_activos as(
			SELECT DISTINCT
			u.idUsuario
			FROM
			trade.usuario u 
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
			WHERE General.dbo.fn_fechaVigente (uh.fecIni,uh.fecFin,@fecha,@fecha) = 1 AND uh.idProyecto IN (".$input['listaProyectos'].")
		)
		SELECT 
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, CASE WHEN r.idUsuario NOT IN(SELECT idUsuario FROM list_usuarios_activos) THEN 1 ELSE 0 END cesado
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
			, v.horaIni
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.canal cn ON cn.idCanal=v.idCanal
		LEFT JOIN trade.zona z ON z.idZona = v.idZona
		WHERE 1=1 
		AND r.estado=1 
		{$filtros} 
		AND r.fecha BETWEEN @fecIni AND @fecFin
		ORDER BY r.fecha ASC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_estado_ruta_visita($input=array()){
		$aSessTrack = [];

		if ($input['tabla']=='rutas') {
			$table = "{$this->sessBDCuenta}.trade.data_ruta";
			$where = array('idRuta'=>$input['idRuta']);
		} elseif ($input['tabla']=='visitas') {
			$table = "{$this->sessBDCuenta}.trade.data_visita";
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

		$query = $this->db->select('idRuta,idProyecto,idCuenta')
				->where( 
						array(
						'idUsuario'=>$input['idUsuario'],
						'idTipoUsuario'=>$input['idTipoUsuario'],
						'fecha'=>$input['fecha'], 
						'estado'=>1 
						) 
				)
				->get("{$this->sessBDCuenta}.trade.data_ruta");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $query->result_array();
	}
	
	public function obtener_data_ruta($idRuta){

		$query = "SELECT * FROM {$this->sessBDCuenta}.trade.data_ruta WHERE idRuta=$idRuta";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($query)->row_array();
	}

	public function insertar_ruta($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_ruta";
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

		$table = "{$this->sessBDCuenta}.trade.data_visita";
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
				->get("{$this->sessBDCuenta}.trade.data_ruta");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $query->result_array();
	}

	public function obtener_lista_ruta_visitas($idRuta){
		$query = $this->db->select('idCliente')
				->where( array('idRuta'=>$idRuta, 'estado'=>1) )
				->get("{$this->sessBDCuenta}.trade.data_visita");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
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
			, r.idTipoUsuario
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		WHERE 1=1 --AND r.demo=0
		{$filtros}
		ORDER BY r.fecha ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_usuarios($input=array()){
		$filtros = "";
		$filtros.= !empty($input['listaCuentas']) ? " AND py.idCuenta IN (".$input['listaCuentas'].")":"";
		$filtros.= !empty($input['listaProyectos']) ? " AND uh.idProyecto IN (".$input['listaProyectos'].")":"";
		$filtros.= !empty($input['idUsuario']) ? " AND u.idUsuario IN (".$input['idUsuario'].")":"";

		$demo = $this->demo;$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND u.demo = 0";
		}
		$sql=" 
		DECLARE @fecha DATE=GETDATE();
		----
		SELECT DISTINCT
			uh.idUsuario
			, CONVERT(VARCHAR,u.idUsuario) + ' - ' + u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS nombreUsuario
		FROM trade.usuario_historico uh
		JOIN trade.aplicacion ap ON ap.idAplicacion=uh.idAplicacion
		JOIN trade.usuario u ON u.idUsuario=uh.idUsuario
		LEFT JOIN trade.proyecto py ON py.idProyecto=uh.idProyecto
		WHERE uh.estado=1
		--AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		AND ap.estado=1 AND ap.flagAndroid=1
		AND u.estado=1 
		{$filtros}
		{$filtro_demo}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}
	public function obtener_lista_usuarios_reprogramar($input=array()){
		$filtros = "";
		$filtros.= !empty($input['listaCuentas']) ? " AND py.idCuenta IN (".$input['listaCuentas'].")":"";
		$filtros.= !empty($input['listaProyectos']) ? " AND uh.idProyecto IN (".$input['listaProyectos'].")":"";
		$filtros.= !empty($input['idUsuario']) ? " AND u.idUsuario IN (".$input['idUsuario'].")":"";

		$demo = $this->demo;$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND u.demo = 0";
		}
		$sql=" 
		DECLARE @fecha DATE=GETDATE();
		----
		SELECT DISTINCT
			uh.idUsuario
			, CONVERT(VARCHAR,u.idUsuario) + ' - ' + u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS nombreUsuario
			, uh.idTipoUsuario
			, ut.nombre tipoUsuario
		FROM trade.usuario_historico uh
		JOIN trade.aplicacion ap ON ap.idAplicacion=uh.idAplicacion
		JOIN trade.usuario u ON u.idUsuario=uh.idUsuario
		LEFT JOIN trade.proyecto py ON py.idProyecto=uh.idProyecto
		LEFT JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = uh.idTipoUsuario
		WHERE uh.estado=1
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		AND ap.estado=1 AND ap.flagAndroid=1
		AND u.estado=1 
		AND uh.idAplicacion <> 2 
		{$filtros}
		{$filtro_demo}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_reprogramar_ruta($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_ruta";
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
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		LEFT JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		WHERE r.idRuta={$idRuta}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_verificacion_existente_visita($input=array()){

		$query = $this->db->select('idVisita')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.data_visita");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $query->result_array();
	}
	public function obtener_verificacion_existente_visita_cliente($input=array()){
		$sql = "
		SELECT idVisita 
		FROM
		{$this->sessBDCuenta}.trade.data_visita
		WHERE idRuta = {$input['idRuta']} AND idCliente ='{$input['idCliente']}'
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();

	}

	public function delete_visita_det($input=array()){
		$aSessTrack = [];
		$table = "{$this->sessBDCuenta}.trade.data_visitaDet";
		
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
		DELETE FROM {$this->sessBDCuenta}.trade.data_visitaDet WHERE idVisita IN (
			SELECT idVisita FROM {$this->sessBDCuenta}.trade.data_visita WHERE idRuta IN (@idRuta) AND idCliente IN (@idCliente)
		)";

		$this->aSessTrack[] = [
				'idAccion' => 8,
				'tabla' => "{$this->sessBDCuenta}.trade.data_visitaDet",
				'id' => arrayToString([ 'idRuta' => $input['idRuta'], 'idCliente' => $input['idCliente'] ])
			];
		return $this->db->query($sql)->result_array();
	}

	public function delete_visita($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_visita";
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
				->get("{$this->sessBDCuenta}.trade.data_visita");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $query->result_array();
	}

	public function obtener_lista_visitas_reprogramar($input=array()){
		$filtros = "";
		$filtros .= ( isset($input['idVisitasString']) && !empty($input['idVisitasString']) ) ? ' AND v.idVisita IN ('.$input['idVisitasString'].')' : '';

		$sql = "
		SELECT 
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idTipoUsuario
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
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		WHERE 1=1 
		--AND r.demo=0
		{$filtros}
		ORDER BY r.fecha, r.idUsuario ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita" ];
		return $this->db->query($sql)->result_array();
	}


	public function actualizar_listas($input=array()){
		$filtros="";
		if (!empty($input['cuenta'])) $filtros .= " AND idCuenta= " . $input['cuenta'];
		$sql="
			DECLARE @fecha date=getdate();
			update {$this->sessBDCuenta}.trade.data_visita 
			set estado=estado
			where idRuta in(
			select idRuta from {$this->sessBDCuenta}.trade.data_ruta
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
		$table = "{$this->sessBDCuenta}.trade.data_visita";
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
				  ut.idTipoUsuario
				, ut.nombre 
			FROM 
				trade.usuario_tipo ut
				JOIN trade.tipoUsuarioCuenta utc ON utc.idTipoUsuario = ut.idTipoUsuario
			WHERE 
				ut.estado=1
				AND utc.idCuenta = {$this->sessIdCuenta}
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
			$table = "{$this->sessBDCuenta}.trade.data_ruta";
			$where = array('idRuta'=>$input['idRuta']);
		} elseif ($input['tabla']=='visitas') {
			$table = "{$this->sessBDCuenta}.trade.data_visita";
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
			$table = "{$this->sessBDCuenta}.trade.data_ruta";
			$where = array('idRuta'=>$input['idRuta']);
		} elseif ($input['tabla']=='visitas') {
			$table = "{$this->sessBDCuenta}.trade.data_visita";
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
				, (SELECT count(*) FROM {$this->sessBDCuenta}.trade.cargaProgramacionRutasDet  WHERE idCarga= c.idCarga) total_procesados
				, CONVERT(VARCHAR,fechaRegistro,103) fechaRegistro
				, CONVERT(VARCHAR,fechaRegistro,108) horaRegistro
				, CONVERT(VARCHAR,finRegistro,108) horaFinRegistro
				, c.estado
				, (SELECT count(*) FROM {$this->sessBDCuenta}.trade.cargaProgramacionRutasDet  WHERE idCarga= c.idCarga AND  comentario <>'' ) error
			FROM 
				{$this->sessBDCuenta}.trade.cargaProgramacionRutas c
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
				, (SELECT count(*) FROM {$this->sessBDCuenta}.trade.cargaExclusionesRutasDet  WHERE idCarga= c.idCarga) total_procesados
				, CONVERT(VARCHAR,fechaRegistro,103) fechaRegistro
				, CONVERT(VARCHAR,fechaRegistro,108) horaRegistro
				, CONVERT(VARCHAR,finRegistro,108) horaFinRegistro
				, c.estado
				, (SELECT count(*) FROM {$this->sessBDCuenta}.trade.cargaExclusionesRutasDet  WHERE idCarga= c.idCarga AND  comentario <>'' ) error
			FROM 
				{$this->sessBDCuenta}.trade.cargaExclusionesRutas c
				JOIN trade.usuario_tipo ut
					ON ut.idTipoUsuario=c.idTipoUsuario
				JOIN trade.usuario u
					ON u.idUsuario = c.idUsuarioRegistro
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_errores($id){
		$sql="
			SELECT * FROM {$this->sessBDCuenta}.trade.cargaProgramacionRutasDet  WHERE idCarga=$id AND comentario <>''
		";
		return $this->db->query($sql)->result_array();
	}

	public function checkRutaConData($input)
	{
		$sql = "
		SELECT DISTINCT
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idUsuario
			, r.nombreUsuario
			, r.tipoUsuario
			--, v.idVisita
			--, v.horaIni
			-- , DENSE_RANK() OVER (PARTITION BY  r.idRuta order BY v.idVisita) + DENSE_RANK() OVER (PARTITION BY r.idRuta order BY v.idVisita desc) - 1
			, COUNT (v.idVisita) OVER (PARTITION BY r.idRuta) cantVisitas
		FROM ImpactTrade_pg.trade.data_ruta r
		LEFT JOIN ImpactTrade_pg.trade.data_visita v ON v.idRuta = r.idRuta
		WHERE 1=1 
		AND v.horaIni IS NOT NULL
		AND r.idRuta IN({$input['idRutasString']})
		";
		return $this->db->query($sql)->result_array();
		
	}
	
	public function cambioEstadoMasivoVisitas($params = [])
	{

		$sql = "
		SELECT 
		v.idVisita
		FROM
		{$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
		WHERE 
		r.idUsuario = {$params['idUsuario']}
		AND r.fecha = '{$params['fecha']}' 
		AND r.idTipoUsuario = {$params['idTipoUsuario']}
		AND v.idCliente = {$params['idCliente']}
		";

		$visita = $this->db->query($sql)->row_array();

		$update = [];

		if(!empty($visita['idVisita'])){
			$update = [
				'tabla' => 'visitas',
				'idVisita' => $visita['idVisita'],
				'estado' => $params['estado'],

			];

			return $this->update_estado_ruta_visita($update);
		}

		return false;
		
	}
}
?>