<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_carga_masiva extends CI_Model{

	var $CI;

	public function __construct()	{
		parent::__construct();
		$this->CI = &get_instance();
	}

	public function obtener_carpetas(){
		$filtro ='';
		$filtro.= ( isset($cuenta) && !empty($cuenta) )? " AND idCuenta=".$cuenta:'';
		$sql ="SELECT idCarga,idPermiso,fecIni,fecFin,estado,carpeta FROM trade.cargaModulacion WHERE estado=1";

		return $this->db->query($sql)->result_array();
	}
	
	public function carga_modulacion(){
		$sql = "
			 SELECT 
				  cd.idCliente
				, c.fecIni
				, c.fecFin
				, c.idPermiso
				, cd.idElemento
				, c.idCarga
				, cd.idCargaDet
				, cd.cantidad
			FROM 
				trade.cargaModulacion c
				JOIN trade.cargaModulacionDet cd
					ON cd.idCarga=c.idCarga
			WHERE 
				c.estado = 1
				AND cd.estado = 1
		";

		return $this->db->query($sql);
	}

	public function obtener_codigo_elemento($elemento){
		$sql="SELECT idElementoVis FROM trade.elementoVisibilidadTrad WHERE estado=1 and nombre='".$elemento."'";
		return $this->db->query($sql);
	}


	public function carga_ruta(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.fecIni,
				c.fecFin,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.generado,
				c.idCuenta,
				c.idProyecto
			FROM 
				trade.cargaRuta c
			WHERE 
				c.estado = 1 
		";
		return $this->db->query($sql);
	}

	public function carga_ruta_no_procesado(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.fecIni,
				c.fecFin,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.generado,
				c.idCuenta,
				c.idProyecto
			FROM 
				trade.cargaRuta c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		";
		return $this->db->query($sql);
	}

	public function carga_ruta_det($params){
		$sql = "
			 SELECT 
				c.*
			FROM 
				trade.cargaRutaDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}


	public function insertar_carga_ruta($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaRuta';
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

	public function insertar_carga_ruta_det($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaRutaDet';
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

	public function insertar_carga_ruta_no_procesado($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaRutaNoProcesados';
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

	public function update_carga_ruta($where=array(), $params=array()){
		$aSessTrack = [];



		$table = 'trade.cargaRuta';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function insertar_visita_ruta($params){
		$sql="
			DECLARE
			@fecha DATE,
			@idRuta INT,
			@idVisita INT,
			@num INT;
			
			SET @fecha=CONVERT(DATE,'{$params['fecha']}');
			SELECT
				@num=COUNT(idRuta)
			FROM trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha AND idCuenta = {$params['idCuenta']} AND idProyecto = {$params['idProyecto']};

			IF( @num=0 )BEGIN
				INSERT INTO trade.data_ruta (fecha,idUsuario,idEncargado,idProyecto,idCuenta) VALUES (@fecha,{$params['idUsuario']},null,{$params['idProyecto']},{$params['idCuenta']})
			END

			SELECT
				@idRuta=idRuta
			FROM trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha AND idProyecto = {$params['idProyecto']} AND idCuenta = {$params['idCuenta']};

			SELECT
				@num=COUNT(idVisita)
			FROM trade.data_visita
			WHERE idRuta=@idRuta
			AND idCliente={$params['idCliente']} 

			IF( @num=0 )BEGIN
				INSERT INTO trade.data_visita (idRuta,idCliente) VALUES (@idRuta,{$params['idCliente']});
			END
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.data_visita', 'id' => $params['idCliente'] ];
		return $this->db->query($sql);
	}

	public function update_carga_ruta_clientes_count($params){
		$sql ="
			UPDATE trade.cargaRuta
			SET totalClientes= (select count(*) from trade.cargaRutaDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaRuta' ];
		return $this->db->query($sql);
	}

	public function update_carga_ruta_fecha($params){
		$sql ="
			update  trade.cargaRuta 
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaRuta' ];
		return $this->db->query($sql);
	}


	public function obtener_ruta_programada_visitas_clientes($idCarga){
		$sql ="
		DECLARE 
			@fecIni DATE = getdate(),@fecFin DATE = getdate();
		SELECT
			distinct
			rpd.idCliente
		FROM
			trade.cargaRuta rp
			JOIN trade.cargaRutaDet rpd 
				ON rpd.idCarga=rp.idCarga
		WHERE 
			rp.idCarga={$idCarga};
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_rutaProgramada' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_ruta_programada_visitas($idCarga,$idCliente){
		$sql ="
		SELECT
			rpd.idUsuario
			, t.fecha 
		FROM
				trade.cargaRuta rp
			JOIN trade.cargaRutaDet rpd 
				ON rpd.idCarga=rp.idCarga
			JOIN General.dbo.tiempo t 
				ON t.fecha between rp.fecIni and rp.fecFin 
				AND (
					(rpd.lunes=1 and t.idDia=1) OR
					(rpd.martes=1 and t.idDia=2) OR
					(rpd.miercoles=1 and t.idDia=3) OR
					(rpd.jueves=1 and t.idDia=4) OR
					(rpd.viernes=1 and t.idDia=5) OR
					(rpd.sabado=1 and t.idDia=6) OR
					(rpd.domingo=1 and t.idDia=7)
				)
		WHERE 
			rp.idCarga={$idCarga}
			and rpd.idCliente={$idCliente}
			;
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_rutaProgramada' ];
		return $this->db->query($sql)->result_array();
	}




	public function carga_permiso_no_procesado(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.fecIniLista,
				c.fecFinLista,
				c.procesado
			FROM 
				trade.cargaPermiso c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		";
		return $this->db->query($sql);
	}

	public function carga_permiso(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.fecIniLista,
				c.fecFinLista,
				c.procesado,
				c.idCuenta,
				c.idProyecto,
				c.auditoria
			FROM 
				trade.cargaPermiso c
			WHERE 
				c.estado = 1 
		";
		return $this->db->query($sql);
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

	public function update_carga_permiso($where=array(), $params=array()){
		$aSessTrack = [];

		$table = 'trade.cargaPermiso';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}


	public function carga_permisos_det_clientes($params){
		$sql = "
			 SELECT 
			 	distinct
				c.idCliente
			FROM 
				trade.cargaPermisoDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}

	public function carga_permisos_det($params){
		$filtros="";
		if( !empty($params['idCliente'])){
			$filtros=" AND c.idCliente='".$params['idCliente']."' ";
		}
		$sql = "
			 SELECT 
				c.*
			FROM 
				trade.cargaPermisoDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']}
				".$filtros." ";

		return $this->db->query($sql);
	}

	public function insertar_master_permiso($input=array()){
		$aSessTrack = [];

		$table = 'trade.master_permisos';
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

	public function update_carga_permiso_clientes_count($params){
		$sql ="
			UPDATE trade.cargaPermiso
			SET totalClientes= (
				SELECT COUNT(*) FROM (
					SELECT 
					 distinct
						 c.idCliente
					FROM 
						trade.cargaPermisoDet c
					WHERE 
						c.estado = 1 
					AND c.idCarga={$params['idCarga']}
				) A )
			WHERE idCarga ={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaPermiso' ];
		return $this->db->query($sql);
	}

	public function update_carga_permiso_fecha($params){
		$sql ="
			update  trade.cargaPermiso 
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaPermiso' ];
		return $this->db->query($sql);
	}



	//clientes

	public function carga_cliente(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.idCuenta,
				c.idProyecto,
				c.tipo,
				c.procesado
			FROM 
				trade.cargaCliente c
			WHERE 
				c.estado = 1 
		";
		return $this->db->query($sql);
	}

	public function carga_cliente_no_procesado(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.tipo,
				c.idCuenta,
				c.idProyecto
			FROM 
				trade.cargaCliente c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		";
		return $this->db->query($sql);
	}

	public function carga_cliente_det($params){
		$sql = "
			 SELECT 
				c.*
			FROM 
				trade.cargaClienteDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}


	public function insertar_carga_cliente($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaCliente';
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

	public function insertar_carga_cliente_det($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaClienteDet';
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

	public function insertar_carga_cliente_no_procesado($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaClienteClientesNoProcesados';
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

	public function update_carga_cliente($where=array(), $params=array()){
		$aSessTrack = [];

		$table = 'trade.cargaCliente';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function update_carga_cliente_clientes_count($params){
		$sql ="
			UPDATE trade.cargaCliente
			SET totalClientes= (select count(*) from trade.cargaClienteDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaCliente' ];
		return $this->db->query($sql);
	}

	public function update_carga_cliente_fecha($params){
		$sql ="
			update  trade.cargaCliente 
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaCliente' ];
		return $this->db->query($sql);
	}



	public function obtener_verificacion_cliente($input=array()){
		$tablahistorico="trade.cliente_historico";
		if( !empty($input['idCuenta'])){
			if($input['idCuenta']=="3"){
				$tablahistorico="trade.cliente_historico_pg";
			}else if($input['idCuenta']=="13"){
				$tablahistorico="trade.cliente_historico_visualimpact";
			}else{
				$tablahistorico="trade.cliente_historico";
			}
		}
		$sql ="
			Declare @fecha date=getdate();
			select
			idCliente 
			from $tablahistorico
			WHERE
			@fecha between fecIni and ISNULL(fecFin,@fecha) AND
			razonSocial ='{$input['razonSocial']}' AND
			direccion='{$input['direccion']}' AND
			idCuenta={$input['idCuenta']} AND
			idProyecto={$input['idProyecto']} 
		";
		return  $this->db->query($sql)->result_array();
	}

	public function obtener_verificacion_cliente_header($input=array()){
		$sql ="
			select
			idCliente 
			from trade.cliente
			WHERE
			razonSocial ='{$input['razonSocial']}' AND
			direccion='{$input['direccion']}'  
		";
		return  $this->db->query($sql)->result_array();
	}
	
	public function obtener_id_segmentacion_cliente_tradicional($where){
		$sql = "
		SELECT * 
			FROM (
				SELECT
					idSegClienteTradicional,
					sct.idPlaza,
					p.nombre AS plaza,
					p.nombreMayorista AS plazaMayorista,
					(
						SELECT STUFF(
						(
							SELECT ',' + CONVERT(VARCHAR, sctd.idDistribuidoraSucursal)
							FROM trade.segmentacionClienteTradicionalDet sctd
							WHERE sctd.idSegClienteTradicional = sct.idSegClienteTradicional
							ORDER BY sctd.idDistribuidoraSucursal
							FOR XML PATH(''), TYPE
						).value('.', 'VARCHAR(MAX)'), 1, 1, '')
					) AS idDistribuidoraSucursal,
					(
						SELECT STUFF(
						(
							SELECT ',' + CONVERT(VARCHAR, data2.distribuidoraSucursal)
							FROM (
								SELECT
									sctd.idSegClienteTradicional
									, data.idDistribuidoraSucursal
									, data.distribuidoraSucursal
								FROM trade.segmentacionClienteTradicionalDet sctd
								JOIN (
									SELECT
										ds.idDistribuidoraSucursal
										, d.idDistribuidora
										, ds.cod_ubigeo
										, d.nombre+' - '+ ubi.distrito AS distribuidoraSucursal
									FROM trade.distribuidoraSucursal ds
									JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
									LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
									WHERE ds.estado=1 AND d.estado=1
								) AS data ON data.idDistribuidoraSucursal=sctd.idDistribuidoraSucursal
							) AS data2
							WHERE data2.idSegClienteTradicional=sct.idSegClienteTradicional
							ORDER BY data2.distribuidoraSucursal
							FOR XML PATH(''), TYPE
						).value('.', 'VARCHAR(MAX)'), 1, 1, '')
					) AS distribuidoraSucursal
				FROM trade.segmentacionClienteTradicional sct
				LEFT JOIN trade.plaza p ON p.idPlaza=sct.idPlaza
			) as data3
			WHERE 1=1 {$where}";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionClienteTradicional' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_segmentacion_negocio($input=array()){
		$query = $this->db->select('idSegNegocio')
				->where( $input )
				->get('trade.segmentacionNegocio');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio' ];
		return $query->result_array();
	}

	public function obtener_id_clienteTipo($clienteTipo){
		$sql = "SELECT ct.idClienteTipo FROM trade.cliente_tipo ct WHERE ct.nombre LIKE'{$clienteTipo}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente_tipo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_canal($canal){
		$sql = "SELECT c.idCanal FROM trade.canal c WHERE c.nombre LIKE '{$canal}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_cliente($input=array()){
		$aSessTrack = [];

		$table = 'trade.cliente';
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

	public function obtener_ubigeo($input=array()){
		$filtros = "";
		$sql = "
			select cod_ubigeo
			from General.dbo.ubigeo
			WHERE estado=1
			and departamento='".$input['departamento']."'
			and provincia='".$input['provincia']."'
			and distrito='".$input['distrito']."'
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.ubigeo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_frecuencia($frecuencia){
		$sql = "SELECT idFrecuencia FROM trade.frecuencia WHERE nombre LIKE '{$frecuencia}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.frecuencia' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_zona($zona){
		$sql = "SELECT idZona FROM trade.zona WHERE nombre LIKE '{$zona}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zona' ];
		return $this->db->query($sql)->result_array();
	}
	public function obtener_id_zona_peligrosa($zonaPeligrosa){
		$sql = "SELECT idZonaPeligrosa FROM trade.zonaPeligrosa WHERE descripcion LIKE '{$zonaPeligrosa}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zonaPeligrosa' ];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_segmentacion_negocio($input=array()){
		$aSessTrack = [];

		$table = 'trade.segmentacionNegocio';
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

	public function obtener_id_plaza_todo($plaza){
		$sql = "
		SELECT p.idPlaza, p.nombre AS plaza
		FROM trade.plaza p WHERE p.estado=1
		AND p.nombre LIKE '{$plaza}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.plaza' ];
		return $this->db->query($sql)->result_array();	
	}

	public function obtener_id_plaza_mayorista($plaza){
		$sql = "
		SELECT
			pl.idPlaza, pl.nombreMayorista AS plaza, pl.flagMayorista
		FROM trade.plaza pl WHERE pl.estado=1 AND pl.flagMayorista=1
		AND pl.nombreMayorista LIKE '{$plaza}'";

		return $this->db->query($sql)->result_array();
	}

	public function insert_segmentacion_cliente_tradicional_v1($input=array()){
		$aSessTrack = [];

		$table='trade.segmentacionClienteTradicional';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function obtener_id_distribuidora_sucursal($distribuidoraSucursal){
		$sql = "
		SELECT * FROM (
			SELECT
				ds.idDistribuidoraSucursal
				, d.idDistribuidora
				, ds.cod_ubigeo
				, d.nombre+' - '+ ubi.distrito AS distribuidoraSucursal
			FROM trade.distribuidoraSucursal ds
			JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
			WHERE ds.estado=1 AND d.estado=1
		) AS data
		WHERE 1=1 AND data.distribuidoraSucursal LIKE '{$distribuidoraSucursal}'";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.distribuidoraSucursal' ];
		return $this->db->query($sql)->result_array();
	}
	public function insert_segmentacion_cliente_tradicional_detalle($input=array()){
		$aSessTrack = [];

		$table = 'trade.segmentacionClienteTradicionalDet';
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

	public function obtener_carga_permiso_elemento_tipo($params=array()){
		$sql="
		SELECT 
			c.*
		FROM 
			trade.cargaPermisoDet c
		JOIN trade.elementoVisibilidadTrad ev 
			ON ev.idElementoVis=c.idElemento
		WHERE 
			c.estado = 1 
			and ev.idTipoElementoVisibilidad={$params['idTipoElemento']}
			AND c.idCarga={$params['idCarga']}
			AND c.idCliente={$params['idCliente']}
		";
		return $this->db->query($sql)->result_array();
	}

	public function verificar_lista_tradicional($input=array()){
		$query = $this->db->select('idListVisibilidadObl')
				->where( $input )
				->get('trade.list_visibilidadTradObl');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTradObl' ];
		return $query->result_array();
	}

	public function delete_lista_tradicional_detalle($idListVisibilidad){
		$sql="DELETE FROM trade.list_visibilidadTradOblDet WHERE idListVisibilidadObl={$idListVisibilidad}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.list_visibilidadTradObl', 'id' => $idListVisibilidad ];
		return $this->db->query($sql);
	}

	public function insertar_lista_tradicional_detalle($input=array()){
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

	public function insertar_lista_tradicional($input=array()){
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

	// TRADE
	public function verificar_lista_visibilidadTrad( $input = [] ){
		$query = $this->db->select('idListVisibilidad')
					->where( $input )
					->get('trade.list_visibilidadTrad');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTrad' ];
		return $query->result_array();
	}

	public function delete_lista_visibilidadTradDet($idListVisibilidad){
		$sql = "DELETE FROM trade.list_visibilidadTradDet WHERE idListVisibilidad = {$idListVisibilidad}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.list_visibilidadTradDet', 'id' => $idListVisibilidad ];
		return $this->db->query($sql);
	}

	public function insertar_lista_visibilidadTrad($input=array()){
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
	
	public function verificar_lista_iniciativa( $input = [] ){
		$this->db->select('idListVisibilidadIni');
		$this->db->where($input);
		$query = $this->db->get('trade.list_visibilidadTradIni');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_visibilidadTradIni' ];
		return $query->result_array();
	}

	public function verificar_lista_iniciativa_trade( $input = [] ){
		$this->db->select('idListIniciativaTrad');
		$this->db->where($input);
		$query = $this->db->get('trade.list_iniciativaTrad');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_iniciativaTrad' ];
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

	public function delete_lista_iniciativa_detalle_elementos_trade($idListVisibilidadIni){
		$sql = "
			DELETE trade.list_iniciativaTradDetElemento 
			WHERE idListIniciativaTradDet IN ( 
				SELECT idListIniciativaTradDet
				FROM trade.list_iniciativaTradDet 
				WHERE idListIniciativaTrad = {$idListVisibilidadIni}
			)
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8,
				'tabla' => 'trade.list_iniciativaTradDetElemento',
				'id' => arrayToString([ 'idListIniciativaTrad' => $idListVisibilidadIni])
			];
		return $this->db->query($sql);
	}

	public function delete_lista_iniciativa_detallle($idListVisibilidadIni){
		$sql = "DELETE FROM trade.list_visibilidadTradIniDet WHERE idListVisibilidadIni = {$idListVisibilidadIni}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8,
				'tabla' => 'trade.list_visibilidadTradIniDet',
				'id' => arrayToString([ 'idListVisibilidadIni' => $idListVisibilidadIni])
			];
		return $this->db->query($sql);
	}

	public function delete_lista_iniciativa_detallle_trade($idListVisibilidadIni){
		$sql = "DELETE FROM trade.list_iniciativaTradDet WHERE idListIniciativaTrad = {$idListVisibilidadIni}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 8,
				'tabla' => 'trade.list_iniciativaTradDet',
				'id' => arrayToString([ 'idListIniciativaTrad' => $idListVisibilidadIni])
			];
		return $this->db->query($sql);
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

	public function insertar_lista_iniciativa_trade($input=array()){
		$aSessTrack = [];

		$table = 'trade.list_iniciativaTrad';
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

	public function insertar_lista_iniciativa_detalle( $input = [] ){
		$rs_iniciativa = $this->db->get_where('trade.elementoVisibilidadTrad',array('idElementoVis'=>$input['idElementoVis']))->row_array();
		$idIniciativa=$rs_iniciativa['idIniciativa'];

		$arrayDetalle=array();
		$arrayDetalle['idIniciativa'] = $idIniciativa;
		$arrayDetalle['idListVisibilidadIni'] = $input['idListVisibilidadIni'];
		$arrayDetalle['estado'] = 1;

		//validar existencia
		$rs = $this->db->get_where('trade.list_visibilidadTradIniDet', $arrayDetalle)->result_array();
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

	public function obtener_cliente($input=array()){
		$filtros = '';
		$tablahistorico="trade.cliente_historico";
		if( !empty($input['idCuenta'])){
			if($input['idCuenta']=="3"){
				$tablahistorico="trade.cliente_historico_pg";
			}else if($input['idCuenta']=="13"){
				$tablahistorico="trade.cliente_historico_visualimpact";
			}else{
				$tablahistorico="trade.cliente_historico";
			}
		}
		$filtros .= !empty($input['idCliente']) ? " AND c.idCliente=".$input['idCliente'] : "";

		$sql="DECLARE @fecha DATE=GETDATE();
		SELECT c.razonSocial AS cliente
		, ch.idProyecto, cn.idGrupoCanal
		FROM trade.cliente c 
		JOIN $tablahistorico ch ON ch.idCliente=c.idCliente
		JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sn.idCanal
		WHERE c.estado=1
		AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecha,@fecha)=1
		{$filtros}";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}


	//iniciativas


	public function carga_iniciativa_no_procesado(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.fecIni,
				c.fecFin,
				c.procesado,
				c.idCuenta,
				c.idProyecto
			FROM 
				trade.cargaIniciativa c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		";
		return $this->db->query($sql);
	}

	public function update_carga_iniciativa($where=array(), $params=array()){
		$aSessTrack = [];

		$table = 'trade.cargaIniciativa';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function update_carga_iniciativa_clientes_count($params){
		$sql ="
			UPDATE trade.cargaIniciativa
			SET totalClientes= (
				SELECT COUNT(*) FROM (
					SELECT 
					 *
					FROM 
						trade.cargaIniciativaDet c
					WHERE 
						c.estado = 1 
					AND c.idCarga={$params['idCarga']}
				) A )
			WHERE idCarga ={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaIniciativa' ];
		return $this->db->query($sql);
	}

	public function carga_iniciativa(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.fecIni,
				c.fecFin,
				c.procesado,
				c.idCuenta,
				c.idProyecto
			FROM 
				trade.cargaIniciativa c
			WHERE 
				c.estado = 1 
				and c.procesado=1
		";
		return $this->db->query($sql);
	}


	public function carga_iniciativa_det_clientes($params){
		$sql = "
			 SELECT 
			 	distinct
				c.idCliente
			FROM 
				trade.cargaIniciativaDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}

	public function carga_iniciativa_det($params){
		$filtros="";
		if( !empty($params['idCliente'])){
			$filtros=" AND c.idCliente='".$params['idCliente']."' ";
		}
		$sql = "
			 SELECT 
				c.*
			FROM 
				trade.cargaIniciativaDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']}
				".$filtros." ";

		return $this->db->query($sql);
	}


	public function obtener_carga_iniciativa_elementos($params=array()){
		$sql="
		SELECT 
			ev.idElementoVis
		FROM 
			trade.cargaIniciativaDet c
		JOIN trade.iniciativaTradElemento ite 
			ON ite.idIniciativa=c.idIniciativa
		JOIN trade.elementoVisibilidadTrad ev 
			ON ev.idElementoVis=ite.idElementoVis
		WHERE 
			c.estado = 1 and ev.estado=1 
			and c.idIniciativa={$params['idIniciativa']}
			AND c.idCarga={$params['idCarga']}
			AND c.idCliente={$params['idCliente']}
		";
		return $this->db->query($sql)->result_array();
	}
	

	public function insertar_lista_iniciativa_det($input=array()){
		$aSessTrack = [];
		$table = 'trade.list_iniciativaTradDet';
		$this->db->trans_begin();
			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();
		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $insert;
	}

	public function insertar_lista_iniciativa_det_trade($input=array()){
		$aSessTrack = [];
		$table = 'trade.list_iniciativaTradDet';
		$this->db->trans_begin();
			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();
		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $insert;
	}

	public function update_carga_iniciativa_fecha($params){
		$sql ="
			update  trade.cargaIniciativa
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaIniciativa' ];
		return $this->db->query($sql);
	}



	public function carga_cliente_proyecto(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.idCuenta,
				c.idProyecto,
				c.procesado
			FROM 
				trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 
		";
		return $this->db->query($sql);
	}

	public function carga_cliente_proyecto_no_procesado(){
		$sql = "
			 SELECT 
				c.idCarga,
				c.carpeta,
				c.totalRegistros,
				c.totalClientes,
				c.total_procesados,
				c.estado,
				c.fechaRegistro,
				c.finRegistro,
				c.idCuenta,
				c.idProyecto
			FROM 
				trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		";
		return $this->db->query($sql);
	}

	public function update_carga_cliente_proyecto($where=array(), $params=array()){
		$aSessTrack = [];

		$table = 'trade.cargaClienteProyecto';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function update_carga_cliente_proyecto_clientes_count($params){
		$sql ="
			UPDATE trade.cargaClienteProyecto
			SET totalClientes= (select count(*) from trade.cargaClienteProyectoDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaClienteProyecto' ];
		return $this->db->query($sql);
	}

	public function update_carga_cliente_proyecto_fecha($params){
		$sql ="
			update  trade.cargaClienteProyecto
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaClienteProyecto' ];
		return $this->db->query($sql);
	}

	public function obtener_verificacion_cliente_proyecto($input=array()){
		
		$sql ="
			Declare @fecha date=getdate();
			select
				idCliente,razonSocial,nombreComercial,idSegNegocio,idSegClienteTradicional,idSegClienteModerno,fecIni,fecFin,idFrecuencia,idCuenta,idZona,flagCartera,codCliente,cod_ubigeo,direccion,referencia,latitud,longitud,idZonaPeligrosa
			from ".$input['historico']."
			WHERE
			@fecha between fecIni and ISNULL(fecFin,@fecha) AND
			idCliente ='{$input['idCliente']}' AND
			idProyecto='{$input['idProyecto']}'  
		";
		return  $this->db->query($sql)->result_array();
	}

	public function obtener_cliente_proyecto_existente($input=array()){
		
		$sql ="
			Declare @fecha date=getdate();
			select
				idCliente
			from ".$input['historico']."
			WHERE
			@fecha between fecIni and ISNULL(fecFin,@fecha) AND
			idCliente ='{$input['idCliente']}' AND
			idProyecto='{$input['idProyecto']}'  

		";
		return  $this->db->query($sql)->result_array();
	}


	public function obtener_cliente_proyecto($input=array()){
		
		$sql ="
			Declare @fecha date=getdate();
			select
				idCliente,razonSocial,nombreComercial,idSegNegocio,idSegClienteTradicional,idSegClienteModerno,fecIni,fecFin,idFrecuencia,idCuenta,idZona,flagCartera,idSegCliente,codCliente,cod_ubigeo,direccion,referencia,latitud,longitud,idZonaPeligrosa,dni,ruc
			from ".$input['historico']."
			WHERE
			@fecha between fecIni and ISNULL(fecFin,@fecha) AND
			idCliente ='{$input['idCliente']}' AND
			idProyecto='{$input['idProyecto']}'  
		";
		return  $this->db->query($sql)->result_array();
	}

	public function insertar_carga_cliente_proyecto_no_procesado($input=array()){
		$aSessTrack = [];
		$table = 'trade.cargaClienteProyectoNoProcesados';
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

	public function update_carga_cliente_proyecto_count($params){
		$sql ="
			UPDATE trade.cargaClienteProyecto
			SET totalClientes= (select count(*) from trade.cargaClienteProyectoDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cargaCliente' ];
		return $this->db->query($sql);
	}

	public function carga_cliente_proyecto_det($params){
		$sql = "
			 SELECT 
				c.*
			FROM 
				trade.cargaClienteProyectoDet c
			WHERE 
				c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}
	

	public function obtener_id_segmentacion_cliente_moderno($banner){
		$sql = "
			SELECT
				scm.idSegClienteModerno
			FROM trade.segmentacionClienteModerno scm
			JOIN trade.banner bn ON bn.idBanner=scm.idBanner
			WHERE bn.nombre LIKE '{$banner}'";

		return $this->db->query($sql)->result_array();
	}

}

 ?>