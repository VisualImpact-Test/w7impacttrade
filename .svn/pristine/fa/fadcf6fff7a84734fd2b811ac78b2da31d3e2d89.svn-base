<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_modulacion extends My_Model{

	var $CI;

	public function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
	}

	public function obtener_master_permiso_tipoModulacion($input=array()){
		$filtros = '';
		$filtros .= !empty($input['idPermiso']) ? " AND mp.idPermiso=".$input['idPermiso'] : "";
		$filtros .= !empty($input['idUsuario']) ? " AND mp.idUsuario=".$input['idUsuario'] : "";
		if (isset($input['tipo']) ){
			$filtros .= ( $input['tipo']=='antigua' ? " AND mp.fecFinCarga<@fecha" : ( $input['tipo']=='actual' ? " AND @fecha BETWEEN mp.fecIniCarga AND ISNULL(mp.fecFinCarga,@fecha) ":"" ) );
		}

			if( !empty($input['idCuenta']) ) $filtros .= " AND mp.idCuenta = {$input['idCuenta']}";
			if( !empty($input['idProyecto']) ) $filtros .= " AND mp.idProyecto = {$input['idProyecto']}";
		
		$sql="DECLARE @fecha DATE=GETDATE();
		---
		SELECT
			mp.idPermiso
			, CONVERT(VARCHAR,mp.fecIniCarga,103) AS fecIniCarga
			, CONVERT(VARCHAR,mp.fecFinCarga,103) AS fecFinCarga
			, CONVERT(VARCHAR,mp.fecIniLista,103) AS fecIniLista
			, CONVERT(VARCHAR,mp.fecFinLista,103) AS fecFinLista
			, mp.flagEditar
			, mp.idUsuario
			, u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS usuario
		FROM trade.master_permisos mp
		JOIN trade.usuario u ON u.idUsuario=mp.idUsuario
		WHERE mp.estado=1 AND u.estado=1
		{$filtros}
		ORDER BY mp.fecFinCarga DESC";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permisos' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cliente($input=array()){
		$filtros = '';
		$filtros .= !empty($input['idCliente']) ? " AND c.idCliente=".$input['idCliente'] : "";

		$sql="DECLARE @fecha DATE=GETDATE();
		SELECT c.razonSocial AS cliente
		, ch.idProyecto, cn.idGrupoCanal
		FROM trade.cliente c 
		JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=c.idCliente
		JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sn.idCanal
		WHERE c.estado=1
		AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecha,@fecha)=1
		{$filtros}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_clientes_v1($params = array()){
		$filtro='';
		//if(!empty($params['idCliente'])) $filtro= 'AND c.idCliente='.$params['idCliente'];
		if(!empty($params['idProyecto'])) $filtro.= 'AND ch.idProyecto='.$params['idProyecto'];
		if(!empty($params['idGrupoCanal'])) $filtro.= 'AND gc.idGrupoCanal='.$params['idGrupoCanal'];
		if(!empty($params['idCanal'])) $filtro.= 'AND ca.idCanal='.$params['idCanal'];
		if(!empty($params['idCliente'])) $filtro.= 'AND c.idCliente in ('.$params['idCliente'].')';
		$sql = "
			DECLARE
				  @fecIni DATE = GETDATE()
				, @fecFin DATE = GETDATE()
			SELECT
				  c.idCliente
				, gc.idGrupoCanal
				, gc.nombre grupoCanal
				, ca.idCanal
				, ca.nombre canal
				, sc.idSubCanal
				, sc.nombre subCanal
				, c.razonSocial
				, ub.departamento
				, ISNULL(v.minCategorias,1) minCategorias
				, ISNULL(v.minElementosOblig,1) minElementosOblig
			FROM
				trade.cliente c
				JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = c.idCliente
					--AND ch.idProyecto = 3
					AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				JOIN trade.subCanal sc
					ON sc.idSubCanal = sn.idSubCanal AND sc.estado=1
					AND sc.idSubCanal NOT IN (8)
				JOIN trade.canal ca
					ON ( (ca.idCanal = sn.idCanal AND sn.idCanal IS NOT NULL) OR (ca.idCanal = sc.idCanal AND sc.idCanal IS NOT NULL) )
				JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
					AND gc.estado=1
				JOIN General.dbo.ubigeo ub
					ON ub.cod_ubigeo=c.cod_ubigeo
				LEFT JOIN trade.master_modulacion_validaciones v
					ON v.idSubCanal = sc.idSubCanal
			WHERE 
				1=1
				{$filtro}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_clientes($input=array()){
		$filtros='';
		//if(!empty($input['idCliente'])) $filtro= 'AND c.idCliente='.$input['idCliente'];
		$filtros.= !empty($input['idProyecto']) ? 'AND ch.idProyecto='.$input['idProyecto']:"";
		$filtros.= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal='.$input['idGrupoCanal']:"";
		$filtros.= !empty($input['idCanal']) ? 'AND ca.idCanal='.$input['idCanal']:"";
		$filtros.= !empty($input['idCliente']) ? 'AND c.idCliente in ('.$input['idCliente'].')': "";
		//$filtros.= !empty($input['idUsuario']) ? " AND uh.idUsuario=".$input['idUsuario']:"";

		$filtros_fecha_var="DECLARE @fecha DATE=GETDATE(),@fecIni DATE = GETDATE(), @fecFin DATE = GETDATE();";

		$filtros_fecha=" AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha) ";
		if( !empty($input['fecIniCarga']) && !empty($input['fecFinCarga']) ){
			$filtros_fecha_var="DECLARE @fecha DATE=GETDATE(),@fecIni DATE = '".$input['fecIniCarga']."', @fecFin DATE = '".$input['fecFinCarga']."';";
			$filtros_fecha="AND (
				ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
				AND (
				ch.fecIni BETWEEN @fecIni AND @fecFin
				OR
				ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
				OR
				@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				OR
				@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				) )";
		}

		$sql=$filtros_fecha_var."
		----
		SELECT DISTINCT
			c.idCliente
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, sc.idSubCanal
			, sc.nombre subCanal
			, c.razonSocial
			, ub.departamento
			, ISNULL(v.minCategorias,1) minCategorias
			, ISNULL(v.minElementosOblig,1) minElementosOblig
		FROM
			trade.cliente c
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			$filtros_fecha
				--AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
				--AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc ON sc.idSubCanal = sn.idSubCanal AND sc.estado=1 AND sc.idSubCanal NOT IN (8)
			JOIN trade.canal ca
				ON ( (ca.idCanal = sn.idCanal AND sn.idCanal IS NOT NULL) OR (ca.idCanal = sc.idCanal AND sc.idCanal IS NOT NULL) )
			JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
				AND gc.estado=1
			JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo=ch.cod_ubigeo
			LEFT JOIN trade.segmentacionClienteTradicional sct ON sct.idSegClienteTradicional=ch.idSegClienteTradicional
				AND sct.estado=1
			LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sctd.idSegClienteTradicional=sct.idSegClienteTradicional
				AND sctd.estado=1
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhds ON uhds.idDistribuidoraSucursal=sctd.idDistribuidoraSucursal
				AND uhds.estado=1
			LEFT JOIN trade.usuario_historico uh ON uh.idUsuarioHist=uhds.idUsuarioHist
				AND uh.estado=1 AND uh.idTipoUsuario IN (2,6) 
				AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
			LEFT JOIN trade.master_modulacion_validaciones v ON v.idSubCanal = sc.idSubCanal
		WHERE 
			1=1
			{$filtros}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}


	public function obtener_clientes_permiso($input=array()){
		$filtros='';
		//if(!empty($input['idCliente'])) $filtro= 'AND c.idCliente='.$input['idCliente'];
		$filtros.= !empty($input['idProyecto']) ? 'AND ch.idProyecto='.$input['idProyecto']:"";
		$filtros.= !empty($input['idGrupoCanal']) ? 'AND gc.idGrupoCanal='.$input['idGrupoCanal']:"";
		$filtros.= !empty($input['idCanal']) ? 'AND ca.idCanal='.$input['idCanal']:"";
		$filtros.= !empty($input['idCliente']) ? 'AND c.idCliente in ('.$input['idCliente'].')': "";
		$filtros.= !empty($input['idPermiso']) ? 'AND m.idPermiso in ('.$input['idPermiso'].')': "";
		//$filtros.= !empty($input['idUsuario']) ? " AND uh.idUsuario=".$input['idUsuario']:"";

		$filtros_fecha_var="DECLARE @fecha DATE=GETDATE(),@fecIni DATE = GETDATE(), @fecFin DATE = GETDATE();";

		$filtros_fecha=" AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha) ";
		if( !empty($input['fecIniCarga']) && !empty($input['fecFinCarga']) ){
			$filtros_fecha_var="DECLARE @fecha DATE=GETDATE(),@fecIni DATE = '".$input['fecIniCarga']."', @fecFin DATE = '".$input['fecFinCarga']."';";
			$filtros_fecha="AND (
				ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
				AND (
				ch.fecIni BETWEEN @fecIni AND @fecFin
				OR
				ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
				OR
				@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				OR
				@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
				) )";
		}

		$sql=$filtros_fecha_var."
		----
		SELECT DISTINCT
			c.idCliente
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, sc.idSubCanal
			, sc.nombre subCanal
			, c.razonSocial
			, ub.departamento
			, ISNULL(v.minCategorias,1) minCategorias
			, ISNULL(v.minElementosOblig,1) minElementosOblig
		FROM
			trade.master_modulacion m
			JOIN trade.cliente c ON c.idCliente =m.idCliente
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			$filtros_fecha
				--AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
				--AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
			JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc ON sc.idSubCanal = sn.idSubCanal AND sc.estado=1 AND sc.idSubCanal NOT IN (8)
			JOIN trade.canal ca
				ON ( (ca.idCanal = sn.idCanal AND sn.idCanal IS NOT NULL) OR (ca.idCanal = sc.idCanal AND sc.idCanal IS NOT NULL) )
			JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
				AND gc.estado=1
			JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo=ch.cod_ubigeo
			LEFT JOIN trade.master_modulacion_validaciones v ON v.idSubCanal = sc.idSubCanal
		WHERE 
			1=1
			{$filtros}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_modulacion($input=array()){
		$filtros = '';
		$filtros .= !empty($input['idCliente']) ? " AND m.idCliente=".$input['idCliente'] : "";

		$sql = "DECLARE @fecIni DATE=GETDATE(), @fecFin DATE=GETDATE(), @idPermiso INT=".$input['idPermiso'].";
		----
		SELECT
			m.idCliente
			, m.flagListaGenerada
			, md.idElementoVis
			, md.cantidad
		FROM trade.master_modulacion m
		JOIN trade.master_modulacionDet md ON md.idModulacion=m.idModulacion
		WHERE 1=1 AND m.estado=1 AND md.estado=1
		AND m.idPermiso = @idPermiso
		{$filtros}
		/*AND (
			m.fecIni <= ISNULL( m.fecFin, @fecFin)
			AND (
				m.fecIni BETWEEN @fecIni AND @fecFin 
				OR
				ISNULL( m.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
				OR
				@fecIni BETWEEN m.fecIni AND ISNULL( m.fecFin, @fecFin ) 
				OR
				@fecFin BETWEEN m.fecIni AND ISNULL( m.fecFin, @fecFin )
			)
		)*/";


		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_modulacion' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_elementos(){
		$sql="DECLARE @fecha DATE=GETDATE(), @fecIni DATE=GETDATE(), @fecFin DATE=GETDATE();
		---
		SELECT
			evt.idElementoVis
			, evt.nombre AS elemento
			, evt.idTipoElementoVisibilidad
			, ISNULL(evt.idCategoria,0) AS idCategoria
			, ISNULL(pc.nombre,'SIN CATEGORIA') AS categoria
		FROM trade.master_listaElementos le
		JOIN trade.master_listaElementosDet led ON led.idLista=le.idLista
		JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=led.idElementoVisibilidad
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=evt.idCategoria
		WHERE 1=1 AND le.estado=1 AND led.estado=1 AND evt.estado=1
		AND @fecha BETWEEN le.fecIni AND ISNULL(le.fecFin,@fecha)
		/*AND (
			le.fecIni <= ISNULL( le.fecFin, @fecFin)
			AND (
				le.fecIni BETWEEN @fecIni AND @fecFin 
				OR
				ISNULL( le.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
				OR
				@fecIni BETWEEN le.fecIni AND ISNULL( le.fecFin, @fecFin ) 
				OR
				@fecFin BETWEEN le.fecIni AND ISNULL( le.fecFin, @fecFin )
			)
		)*/
		--ORDER BY idCategoria, elemento ASC
		ORDER BY led.orden ";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_listaElementos' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_permisos($input=array()){
		$filtros = '';

		$sql="
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			select 
				  mp.idPermiso
				, mp.fecIniCarga
				, mp.fecFinCarga 
				, mp.fecIniLista
				, mp.fecFinLista
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
			from 
				trade.master_permisos mp
				join trade.usuario u
					ON u.idUsuario = mp.idUsuario
			WHERE
				General.dbo.fn_fechaVigente(@fecIni,@fecFin,mp.fecIniCarga,mp.fecFinCarga)=1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permisos' ];
		return $this->db->query($sql)->result_array();
	}

	public function verificar_master_modulacion($input=array()){
		$query = $this->db->select('idModulacion')
				->where( $input )
				->get('trade.master_modulacion');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_modulacion' ];
		return $query->result_array();
	}

	public function delete_master_modulacion_detalle($idModulacion){
		$sql="DELETE FROM trade.master_modulacionDet WHERE idModulacion={$idModulacion}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.master_modulacionDet', 'id' => $idModulacion ];
		return $this->db->query($sql);
	}

	public function insertar_master_modulacion_det($input=array()){
		$aSessTrack = [];

		$table = 'trade.master_modulacionDet';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insertar_master_modulacion($input=array()){
		$aSessTrack = [];

		$table = 'trade.master_modulacion';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function obtener_modulacion_clientes($input=array()){
		$sql="DECLARE @fecha DATE=GETDATE(), @idPermiso INT=".$input['idPermiso'].";
		---
		SELECT DISTINCT
			mm.idModulacion
			, mm.idCliente
		FROM trade.master_modulacion mm 
		JOIN trade.master_modulacionDet mmd ON mmd.idModulacion=mm.idModulacion
		WHERE mm.estado=1 AND mm.idPermiso=@idPermiso";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_modulacion' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_elementos_tipo($input=array()){
		$sql="DECLARE @fecha DATE=GETDATE(), @idPermiso INT=".$input['idPermiso']."
		,@idModulacion INT=".$input['idModulacion'].", @idTipoElemento INT=".$input['idTipoElemento'].";
		---
		SELECT
			mm.idModulacion
			, mm.idCliente
			, mmd.idElementoVis
		FROM trade.master_modulacion mm
		JOIN trade.master_modulacionDet mmd ON mmd.idModulacion=mm.idModulacion
		JOIN trade.elementoVisibilidadTrad ev ON ev.idElementoVis=mmd.idElementoVis
		WHERE mm.estado=1 AND mmd.estado=1
		AND mm.idPermiso=@idPermiso
		AND mmd.idModulacion=@idModulacion
		AND ev.idTipoElementoVisibilidad=@idTipoElemento";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.elementoVisibilidadTrad' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cantidad_modulacion_clientes($idPermiso){
		$sql="SELECT count(idModulacion) AS numClientes FROM trade.master_modulacion
		WHERE estado=1 AND idPermiso={$idPermiso}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_modulacion' ];
		return $this->db->query($sql)->result_array();
	}

	/*==LISTA VISIBILIDAD TRADICIONAL==*/
	public function verificar_lista_tradicional($input=array()){
		$query = $this->db->select('idListVisibilidad')
				->where( $input )
				->get('trade.list_visibilidadTrad');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTrad' ];
		return $query->result_array();
	}

	public function delete_lista_tradicional_detalle($idListVisibilidad){
		$sql="DELETE FROM trade.list_visibilidadTradDet WHERE idListVisibilidad={$idListVisibilidad}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.list_visibilidadTradDet', 'id' => $idListVisibilidad ];
		return $this->db->query($sql);
	}

	public function insertar_lista_tradicional_detalle($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTradDet';
		$this->db->trans_begin();
			
			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	public function insertar_lista_tradicional($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTrad';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	/*==LISTA DE VISIBILIDAD OBLIGATORIAS==*/
	public function verificar_lista_obligatoria($input=array()){
		$query = $this->db->select('idListVisibilidadObl')
				->where( $input )
				->get('trade.list_visibilidadTradObl');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTradObl' ];
		return $query->result_array();
	}

	public function delete_lista_obligatoria_detallle($idListVisibilidadObl){
		$sql="DELETE FROM trade.list_visibilidadTradOblDet WHERE idListVisibilidadObl={$idListVisibilidadObl}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.list_visibilidadTradOblDet', 'id' => $idListVisibilidadObl ];
		return $this->db->query($sql);
	}

	public function insertar_lista_obligatoria_detalle($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTradOblDet';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insertar_lista_obligatoria($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTradObl';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	/*==LISTA DE VISIBILIDAD INICIATIVAS==*/
	public function verificar_lista_iniciativa( $input = [] ){
		$this->db->select('idListVisibilidadIni');
		$this->db->where($input);
		$query = $this->db->get('trade.list_visibilidadTradIni');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTradIni' ];
		return $query->result_array();
	}

	public function delete_lista_iniciativa_detalle_elementos($idListVisibilidadIni){
		$sql = "
			DELETE trade.list_visibilidadTradIniDetElemento 
			WHERE idListVisibilidadIniDet IN ( 
				SELECT idListVisibilidadIniDet
				FROM trade.list_visibilidadTradIniDet 
				WHERE idListVisibilidadIni = {$idListVisibilidadIni}
			)
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8,
				'tabla' => 'trade.list_visibilidadTradIniDetElemento',
				'id' => arrayToString([ 'idListVisibilidadIni' => $idListVisibilidadIni])
			];
		return $this->db->query($sql);
	}

	public function delete_lista_iniciativa_detalle($idListVisibilidadIni){
		$sql = "DELETE FROM trade.list_visibilidadTradIniDet WHERE idListVisibilidadIni = {$idListVisibilidadIni}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8,
				'tabla' => 'trade.list_visibilidadTradIniDet',
				'id' => arrayToString([ 'idListVisibilidadIni' => $idListVisibilidadIni])
			];
		return $this->db->query($sql);
	}

	public function insertar_lista_iniciativa_detalle($input=array()){
		$rs_iniciativa = $this->db->get_where('trade.elementoVisibilidadTrad',array('idElementoVis'=>$input['idElementoVis']))->row_array();
		$idIniciativa=$rs_iniciativa['idIniciativa'];


		$arrayDetalle=array();
		$arrayDetalle['idIniciativa'] = $idIniciativa;
		$arrayDetalle['idListVisibilidadIni'] = $input['idListVisibilidadIni'];
		$arrayDetalle['estado'] = 1;

		//validar existencia
		$rs = $this->db->get_where('trade.list_visibilidadTradIniDet',$arrayDetalle)->result_array();
		if($rs!=null){
			if(count($rs) >=1){
				//si existe iniciativa agregar detalle elemento
				$idListDetalle=$rs[0]['idListVisibilidadIniDet'];
				$arrayDetalleElemento=array();
				$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
				$arrayDetalleElemento['idElementoVis']=$input['idElementoVis'];
				$arrayDetalleElemento['estado']=1;

				$aSessTrack = [];
				$table = 'trade.list_visibilidadTradIniDetElemento';
				$this->db->trans_begin();

					$insert = $this->db->insert($table, $arrayDetalleElemento);
					$id = $this->db->insert_id();

					$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

				if ( $this->db->trans_status()===FALSE ) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					$this->CI->aSessTrack[] = $aSessTrack;
				}
			}else{
				//insertar la iniciativa
				$aSessTrack = [];
				$table = 'trade.list_visibilidadTradIniDet';
				$this->db->trans_begin();

					$insert = $this->db->insert($table, $arrayDetalle);
					$id = $this->db->insert_id();

					$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

				if ( $this->db->trans_status()===FALSE ) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					$this->CI->aSessTrack[] = $aSessTrack;

					//detalle elemento
					$idListDetalle=$this->db->insert_id();
					$arrayDetalleElemento=array();
					$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
					$arrayDetalleElemento['idElementoVis']=$input['idElementoVis'];
					$arrayDetalleElemento['estado']=1;

					$aSessTrack = [];
					$table = 'trade.list_visibilidadTradIniDetElemento';
					$this->db->trans_begin();

						$insert = $this->db->insert($table, $arrayDetalleElemento);
						$id = $this->db->insert_id();

						$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

					if ( $this->db->trans_status()===FALSE ) {
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						$this->CI->aSessTrack[] = $aSessTrack;
					}
				}
			}
		}else{
			//insertar la iniciativa
			$aSessTrack = [];
			$table = 'trade.list_visibilidadTradIniDet';
			$this->db->trans_begin();

				$insert = $this->db->insert($table, $arrayDetalle);
				$id = $this->db->insert_id();

				$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

			if ( $this->db->trans_status()===FALSE ) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->CI->aSessTrack[] = $aSessTrack;

				//detalle elemento
				$idListDetalle=$this->db->insert_id();
				$arrayDetalleElemento=array();
				$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
				$arrayDetalleElemento['idElementoVis']=$input['idElementoVis'];
				$arrayDetalleElemento['estado']=1;

				$aSessTrack = [];
				$table = 'trade.list_visibilidadTradIniDetElemento';
				$this->db->trans_begin();

					$insert = $this->db->insert($table, $arrayDetalleElemento);
					$id = $this->db->insert_id();

					$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

				if ( $this->db->trans_status()===FALSE ) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					$this->CI->aSessTrack[] = $aSessTrack;
				}
			}
		}
		return $insert;
	}

	public function insertar_lista_iniciativa($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTradIni';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	/*==LISTA DE VISIBILIDAD ADICIONAL==*/
	public function verificar_lista_adicional($input=array()){
		$query = $this->db->select('idListVisibilidadAdc')
				->where( $input )
				->get('trade.list_visibilidadTradAdc');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTradAdc' ];
		return $query->result_array();
	}

	public function delete_lista_adicional_detallle($idListVisibilidadAdc){
		$sql="DELETE FROM trade.list_visibilidadTradAdcDet WHERE idListVisibilidadAdc={$idListVisibilidadAdc}";

		$this->CI->aSessTrack[] = [
				'idAccion' => 8,
				'tabla' => 'trade.list_visibilidadTradAdcDet',
				'id' => arrayToString([ 'idListVisibilidadAdc' => $idListVisibilidadAdc ])
			];
		return $this->db->query($sql);
	}

	public function insertar_lista_adicional_detalle($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTradAdcDet';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function insertar_lista_adicional($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_visibilidadTradAdc';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function update_modulacion_listaGenerada($where=array(), $params=array()){
		$aSessTrack = [];

		$table = 'trade.master_modulacion';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function obtener_modulacion_anterior($input=array()){
		$sql="DECLARE @idCliente INT=".$input['idCliente'].", @idPermiso INT=".(isset($input['idPermiso'])? $input['idPermiso'] : 0 ).";
		----
		SELECT
			mmd.idElementoVis, UPPER(el.nombre) AS elementoVisibilidad, mmd.cantidad
		FROM trade.master_permisos mp
		JOIN trade.master_modulacion mm ON mm.idPermiso=mp.idPermiso
		JOIN trade.master_modulacionDet mmd ON mmd.idModulacion=mm.idModulacion
		JOIN trade.elementoVisibilidadTrad el ON el.idElementoVis=mmd.idElementoVis
		WHERE mp.estado=1 AND mm.estado=1 AND mmd.estado=1
		AND mp.idPermiso IN (@idPermiso)
		AND mm.idCliente IN (@idCliente)
		ORDER BY mmd.idElementoVis ASC";

		return $this->db->query($sql)->result_array();
	}


	public function obtener_estado_carga($idPermiso){
		$sql ="  
			SELECT 
				  *
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				,(
					SELECT count(*) FROM (
						SELECT idCarga FROM trade.cargaModulacionClientesNoProcesados WHERE idCarga=cm.idCarga
						UNION
						SELECT idCarga FROM trade.cargaModulacionElementosError  WHERE idCarga=cm.idCarga
					)a
				) error
			FROM 
				trade.cargaModulacion cm

			 WHERE cm.idPermiso='".$idPermiso."'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_estado_carga_1(){
		$sql =" 
			SELECT 
				  *
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				,(
					SELECT count(*) FROM (
						SELECT idCarga FROM trade.cargaModulacionClientesNoProcesados WHERE idCarga=cm.idCarga
						UNION
						SELECT idCarga FROM trade.cargaModulacionElementosError  WHERE idCarga=cm.idCarga
					)a
				) error
			FROM 
				trade.cargaModulacion cm

		";
		return $this->db->query($sql)->result_array();
	}
	
	////ERRORES
	public function obtener_elementos_error($id){
		$sql="SELECT * FROM trade.cargaModulacionElementosError where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_clientes_no_procesados($id){
		$sql="SELECT * FROM trade.cargaModulacionClientesNoProcesados where tipoError='Cliente sin elementos.' OR tipoError='Cliente no registrado en base de datos.' AND idCarga= $id";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_clientes_procesados_con_error($id){
		$sql="
			SELECT 
				p.idCliente 
				,e.nombre
				,p.datoIngresado
			FROM 
				trade.cargaModulacionClientesNoProcesados p 
				JOIN trade.elementoVisibilidadTrad e
					ON e.idElementoVis=p.elemento where p.idCarga= $id";
		return $this->db->query($sql)->result_array();
	}
	
	public function limpiar_tablas_modulacion ($idPermiso){
		$sql = "
			DELETE FROM trade.master_modulacionDet WHERE idModulacion IN (
				SELECT idModulacion FROM trade.master_modulacion WHERE idPermiso=$idPermiso
			)
		"; 
		$this->db->query($sql);
		$sql = "DELETE FROM trade.master_modulacion WHERE idPermiso=$idPermiso ";
		$this->db->query($sql);
		
		$sql = "DELETE FROM trade.cargaModulacionDet WHERE idCarga IN (SELECT idCarga FROM trade.cargaModulacion WHERE idPermiso=$idPermiso) ";
		$this->db->query($sql);
		$sql = "DELETE FROM trade.cargaModulacionElementosError WHERE idCarga IN (SELECT idCarga FROM trade.cargaModulacion WHERE idPermiso=$idPermiso) ";
		$this->db->query($sql);
		$sql = "DELETE FROM trade.cargaModulacionClientesNoProcesados WHERE idCarga IN (SELECT idCarga FROM trade.cargaModulacion WHERE idPermiso=$idPermiso) ";
		$this->db->query($sql);
		$sql = "DELETE FROM trade.cargaModulacion WHERE idPermiso=$idPermiso ";
		$this->db->query($sql);
		
	}

	public function obtener_modulos(){
		$sql = "SELECT idModulo,modulo FROM trade.master_modulo WHERE estado=1";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_modulo' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_permisos_modulo($idPermiso){
		$sql="select * from ImpactTrade_bd.trade.master_permiso_modulo where idPermiso=$idPermiso";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permiso_modulo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_usuarios(){
		$sql="
			DECLARE @fecha DATE = getdate()
			SELECT DISTINCT
				u.idUsuario
				,u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
			FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
				AND uh.idTipoUsuario IN (2,6) 
				AND @fecha BETWEEN uh.fecIni AND ISNULL (uh.fecFin,@fecha)
			JOIN trade.proyecto p ON p.idProyecto=uh.idProyecto
				AND p.idCuenta IN (3) --(3,2)
				AND u.demo=0";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}


	public function obtener_estado_carga_alternativa($idPermiso=null){
		$filtros="";
		if($filtros!=null){
			$filtros=" AND cm.idPermiso=".$idPermiso."' ";
		}

		if ($this->session->userdata('idCuenta') != null) $filtros .= " AND cm.idCuenta=" . $this->session->userdata('idCuenta') ;


		$sql ="  
			SELECT 
					*
				, convert(varchar,fecIniLista,103) fecIniL
				, convert(varchar,fecFinLista,103) fecFinL
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				,(
					SELECT count(*) FROM (
						SELECT idCarga FROM trade.cargaPermisoClienteNoProcesados WHERE idCarga=cm.idCarga
						UNION
						SELECT idCarga FROM trade.cargaPermisoElementoNoProcesados  WHERE idCarga=cm.idCarga
					)a
				) error
			FROM 
				trade.cargaPermiso cm
			 WHERE 1=1 ".$filtros."
			 ORDER BY cm.idCarga DESC
			 ";
		return $this->db->query($sql)->result_array();
	}


	////ERRORES
	public function obtener_permisos_cliente_no_procesado($id){
		$sql="SELECT * FROM trade.cargaPermisoClienteNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_permisos_elementos_no_procesado($id){
		$sql="SELECT * FROM trade.cargaPermisoElementoNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}

	public function lista_proyectosAuditoria( $input = [] ){
		$aProyectos = [];
		if( !empty($input['idProyecto']) ){
			$sql = "
				SELECT pya.idProyecto
				FROM trade.proyecto pya
				JOIN trade.proyecto py ON pya.idCuenta = py.idCuenta
				WHERE pya.idProyectoGeneral = 2
				AND py.idProyecto = {$input['idProyecto']}
			";

			$aProyectos = $this->db->query($sql)->result_array();
		}

		return $aProyectos;
	}
	
}
?>