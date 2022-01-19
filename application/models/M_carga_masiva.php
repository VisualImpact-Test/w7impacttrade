<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_carga_masiva extends CI_Model{

	public $sessBDCuenta="";

	public function __construct()	{
		parent::__construct();
	}

	public function obtener_carpetas(){
		$filtro ='';
		$filtro.= ( isset($cuenta) && !empty($cuenta) )? " AND idCuenta=".$cuenta:'';
		$sql ="
			SELECT 
				idCarga,idPermiso,fecIni,fecFin,estado,carpeta,idCuenta
			FROM Impacttrade_aje.trade.cargaModulacion 
			WHERE estado=1
			
			UNION 

			SELECT 
				idCarga,idPermiso,fecIni,fecFin,estado,carpeta,idCuenta
			FROM Impacttrade_pg.trade.cargaModulacion 
			WHERE estado=1

			UNION 

			SELECT 
				idCarga,idPermiso,fecIni,fecFin,estado,carpeta,idCuenta
			FROM Impacttrade_small.trade.cargaModulacion 
			WHERE estado=1
			
			";

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
				, c.idCuenta
			FROM 
				Impacttrade_aje.trade.cargaModulacion c
				JOIN Impacttrade_aje.trade.cargaModulacionDet cd
					ON cd.idCarga=c.idCarga
			WHERE 
				c.estado = 1
				AND cd.estado = 1

			UNION

			SELECT 
				  cd.idCliente
				, c.fecIni
				, c.fecFin
				, c.idPermiso
				, cd.idElemento
				, c.idCarga
				, cd.idCargaDet
				, cd.cantidad
				, c.idCuenta
			FROM 
				Impacttrade_pg.trade.cargaModulacion c
				JOIN Impacttrade_pg.trade.cargaModulacionDet cd
					ON cd.idCarga=c.idCarga
			WHERE 
				c.estado = 1
				AND cd.estado = 1

			UNION

			SELECT 
				  cd.idCliente
				, c.fecIni
				, c.fecFin
				, c.idPermiso
				, cd.idElemento
				, c.idCarga
				, cd.idCargaDet
				, cd.cantidad
				, c.idCuenta
			FROM 
				Impacttrade_small.trade.cargaModulacion c
				JOIN Impacttrade_small.trade.cargaModulacionDet cd
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
				c.idProyecto,
				c.idTipoUsuario
			FROM 
				{$this->sessBDCuenta}.trade.cargaRuta c
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
				c.idProyecto,
				c.idTipoUsuario
			FROM 
				{$this->sessBDCuenta}.trade.cargaRuta c
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
				{$this->sessBDCuenta}.trade.cargaRutaDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}


	public function insertar_carga_ruta($input=array()){
		
		$table = "{$this->sessBDCuenta}.trade.cargaRuta";
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

	public function insertar_carga_ruta_det($input=array()){
		
		$table = "{$this->sessBDCuenta}.trade.cargaRutaDet";
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

	public function insertar_carga_ruta_no_procesado($input=array()){
		
		$table = "{$this->sessBDCuenta}.trade.cargaRutaNoProcesados";
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

	public function update_carga_ruta($where=array(), $params=array()){
		$table = "{$this->sessBDCuenta}.trade.cargaRuta";
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			
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
			FROM {$this->sessBDCuenta}.trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha 
			AND idCuenta = {$params['idCuenta']} 
			AND idProyecto = {$params['idProyecto']}
			AND idTipoUsuario = {$params['idTipoUsuario']};

			IF( @num=0 )BEGIN
				INSERT INTO {$this->sessBDCuenta}.trade.data_ruta (fecha,idUsuario,idTipoUsuario,idEncargado,idProyecto,idCuenta) VALUES (@fecha,{$params['idUsuario']},{$params['idTipoUsuario']},null,{$params['idProyecto']},{$params['idCuenta']})
			END

			SELECT
				@idRuta=idRuta
			FROM {$this->sessBDCuenta}.trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha 
			AND idProyecto = {$params['idProyecto']} 
			AND idCuenta = {$params['idCuenta']}
			AND idTipoUsuario = {$params['idTipoUsuario']};

			SELECT
				@num=COUNT(idVisita)
			FROM {$this->sessBDCuenta}.trade.data_visita
			WHERE idRuta=@idRuta
			AND idCliente={$params['idCliente']} 

			IF( @num=0 )BEGIN
				INSERT INTO {$this->sessBDCuenta}.trade.data_visita (idRuta,idCliente) VALUES (@idRuta,{$params['idCliente']});
			END
		";
		
		return $this->db->query($sql);
	}

	public function update_carga_ruta_clientes_count($params){
		$sql ="
			UPDATE {$this->sessBDCuenta}.trade.cargaRuta
			SET totalClientes= (select count(*) from {$this->sessBDCuenta}.trade.cargaRutaDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		
		return $this->db->query($sql);
	}

	public function update_carga_ruta_fecha($params){
		$sql ="
			update  {$this->sessBDCuenta}.trade.cargaRuta 
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		
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
			{$this->sessBDCuenta}.trade.cargaRuta rp
			JOIN {$this->sessBDCuenta}.trade.cargaRutaDet rpd 
				ON rpd.idCarga=rp.idCarga
		WHERE 
			rp.idCarga={$idCarga};
		";

		
		return $this->db->query($sql)->result_array();
	}

	public function obtener_ruta_programada_visitas($idCarga,$idCliente){
		$sql ="
		SELECT
			rpd.idUsuario
			, t.fecha 
		FROM
				{$this->sessBDCuenta}.trade.cargaRuta rp
			JOIN {$this->sessBDCuenta}.trade.cargaRutaDet rpd 
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
				c.procesado,
				c.idCuenta
			FROM 
				Impacttrade_aje.trade.cargaPermiso c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				c.idCuenta
			FROM 
				Impacttrade_pg.trade.cargaPermiso c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				c.idCuenta
			FROM 
				Impacttrade_small.trade.cargaPermiso c
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
				impacttrade_pg.trade.cargaPermiso c
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
		

		$table = "{$this->sessBDCuenta}.trade.cargaPermiso";
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			
		}

		return $update;
	}


	public function carga_permisos_det_clientes($params){
		$sql = "
			 SELECT 
			 	distinct
				c.idCliente
			FROM 
				{$this->sessBDCuenta}.trade.cargaPermisoDet c
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
				{$this->sessBDCuenta}.trade.cargaPermisoDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']}
				".$filtros." ";

		return $this->db->query($sql);
	}

	public function insertar_master_permiso($input=array()){
		

		$table = 'trade.master_permisos';
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

	public function update_carga_permiso_clientes_count($params){
		$sql ="
			UPDATE {$this->sessBDCuenta}.trade.cargaPermiso
			SET totalClientes= (
				SELECT COUNT(*) FROM (
					SELECT 
					 distinct
						 c.idCliente
					FROM 
						{$this->sessBDCuenta}.trade.cargaPermisoDet c
					WHERE 
						c.estado = 1 
					AND c.idCarga={$params['idCarga']}
				) A )
			WHERE idCarga ={$params['idCarga']};
		";
		
		return $this->db->query($sql);
	}

	public function update_carga_permiso_fecha($params){
		$sql ="
			update  {$this->sessBDCuenta}.trade.cargaPermiso 
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		
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
				c.procesado,
				c.auditoria
			FROM 
			{$this->sessBDCuenta}.trade.cargaCliente c
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
				c.idProyecto,
				c.auditoria
			FROM 
				ImpactTrade_aje.trade.cargaCliente c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				c.idProyecto,
				c.auditoria
			FROM 
				ImpactTrade_pg.trade.cargaCliente c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				c.idProyecto,
				c.auditoria
			FROM 
				ImpactTrade_small.trade.cargaCliente c
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
				{$this->sessBDCuenta}.trade.cargaClienteDet c
			WHERE 
				c.estado = 1 
				AND c.idCarga={$params['idCarga']};
		";
		return $this->db->query($sql);
	}


	public function insertar_carga_cliente($input=array()){
		
		$table = "{$this->sessBDCuenta}.trade.cargaCliente";
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

	public function insertar_carga_cliente_det($input=array()){
		
		$table = "{$this->sessBDCuenta}.trade.cargaClienteDet";
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

	public function insertar_carga_cliente_no_procesado($input=array()){
		
		$table = "{$this->sessBDCuenta}.trade.cargaClienteClientesNoProcesados";
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

	public function update_carga_cliente($where=array(), $params=array()){
		

		$table = "{$this->sessBDCuenta}.trade.cargaCliente";
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			
		}

		return $update;
	}

	public function update_carga_cliente_clientes_count($params){
		$sql ="
			UPDATE {$this->sessBDCuenta}.trade.cargaCliente
			SET totalClientes= (select count(*) from {$this->sessBDCuenta}.trade.cargaClienteDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		
		return $this->db->query($sql);
	}

	public function update_carga_cliente_fecha($params){
		$sql ="
			update  {$this->sessBDCuenta}.trade.cargaCliente 
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		
		return $this->db->query($sql);
	}



	public function obtener_verificacion_cliente($input=array()){
		$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
		if( !empty($input['idCuenta'])){
			if($input['idCuenta']=="3"){
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
			}else if($input['idCuenta']=="13"){
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
			}else if($input['idCuenta']=="2"){
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
			}else{
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
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
		
		return $this->db->query($sql)->result_array();
	}

	public function obtener_segmentacion_negocio($input=array()){
		$query = $this->db->select('idSegNegocio')
				->where( $input )
				->get('trade.segmentacionNegocio');

		
		return $query->result_array();
	}

	public function obtener_id_clienteTipo($clienteTipo){
		$sql = "SELECT ct.idClienteTipo FROM trade.cliente_tipo ct WHERE ct.nombre LIKE'{$clienteTipo}'";

		
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_canal($canal){
		$sql = "SELECT c.idCanal FROM trade.canal c WHERE c.nombre LIKE '{$canal}'";

		
		return $this->db->query($sql)->result_array();
	}

	public function insertar_cliente($input=array()){
		

		$table = 'trade.cliente';
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
		
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_frecuencia($frecuencia){
		$sql = "SELECT idFrecuencia FROM trade.frecuencia WHERE nombre LIKE '{$frecuencia}'";

		
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_zona($zona){
		$sql = "SELECT idZona FROM trade.zona WHERE nombre LIKE '{$zona}'";

		
		return $this->db->query($sql)->result_array();
	}
	public function obtener_id_zona_peligrosa($zonaPeligrosa){
		$sql = "SELECT idZonaPeligrosa FROM trade.zonaPeligrosa WHERE descripcion LIKE '{$zonaPeligrosa}'";

		
		return $this->db->query($sql)->result_array();
	}

	public function insertar_segmentacion_negocio($input=array()){
		

		$table = 'trade.segmentacionNegocio';
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

	public function obtener_id_plaza_todo($plaza){
		$sql = "
		SELECT p.idPlaza, p.nombre AS plaza
		FROM trade.plaza p WHERE p.estado=1
		AND p.nombre LIKE '{$plaza}'";

		
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
		

		$table='trade.segmentacionClienteTradicional';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			

		if ( $this->db->trans_status()===FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			
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
			FROM impacttrade_bd.trade.distribuidoraSucursal ds
			JOIN impacttrade_bd.trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
			WHERE ds.estado=1 AND d.estado=1
		) AS data
		WHERE 1=1 AND data.distribuidoraSucursal LIKE '{$distribuidoraSucursal}'";

		
		return $this->db->query($sql)->result_array();
	}
	public function insert_segmentacion_cliente_tradicional_detalle($input=array()){
		

		$table = 'trade.segmentacionClienteTradicionalDet';
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

	public function obtener_carga_permiso_elemento_tipo($params=array()){
		$sql="
		SELECT 
			c.*
		FROM 
			{$this->sessBDCuenta}.trade.cargaPermisoDet c
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
				->get("{$this->sessBDCuenta}.trade.list_visibilidadTradObl");

		
		return $query->result_array();
	}

	public function delete_lista_tradicional_detalle($idListVisibilidad){
		$sql="DELETE FROM {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet WHERE idListVisibilidadObl={$idListVisibilidad}";

		
		return $this->db->query($sql);
	}

	public function insertar_lista_tradicional_detalle($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradObl";
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

	public function insertar_lista_tradicional($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradObl";
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

	public function verificar_lista_obligatoria($input=array()){
		$query = $this->db->select('idListVisibilidadObl')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.list_visibilidadTradObl");

		
		return $query->result_array();
	}

	public function delete_lista_obligatoria_detallle($idListVisibilidadObl){
		$sql="DELETE FROM {$this->sessBDCuenta}.trade.list_visibilidadTradOblDet WHERE idListVisibilidadObl={$idListVisibilidadObl}";

		
		return $this->db->query($sql);
	}
	public function insertar_lista_obligatoria_detalle($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradOblDet";
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

	public function insertar_lista_obligatoria($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradObl";
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

	// TRADE
	public function verificar_lista_visibilidadTrad( $input = [] ){
		$query = $this->db->select('idListVisibilidad')
					->where( $input )
					->get("{$this->sessBDCuenta}.trade.list_visibilidadTrad");

		
		return $query->result_array();
	}

	public function delete_lista_visibilidadTradDet($idListVisibilidad){
		$sql = "DELETE FROM {$this->sessBDCuenta}.trade.list_visibilidadTradDet WHERE idListVisibilidad = {$idListVisibilidad}";

		
		return $this->db->query($sql);
	}

	public function insertar_lista_visibilidadTrad($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_visibilidadTrad";
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
	
	public function verificar_lista_iniciativa( $input = [] ){
		$this->db->select('idListVisibilidadIni');
		$this->db->where($input);
		$query = $this->db->get("{$this->sessBDCuenta}.trade.list_visibilidadTradIni");

		
		return $query->result_array();
	}

	public function verificar_lista_iniciativa_trade( $input = [] ){
		$this->db->select('idListIniciativaTrad');
		$this->db->where($input);
		$query = $this->db->get("{$this->sessBDCuenta}.trade.list_iniciativaTrad");

		
		return $query->result_array();
	}

	public function delete_lista_iniciativa_detalle_elementos($idListVisibilidadIni){
		$sql = "
			DELETE {$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento 
			WHERE idListVisibilidadIniDet IN ( 
				SELECT idListVisibilidadIniDet
				FROM {$this->sessBDCuenta}.trade.list_visibilidadTradIniDet 
				WHERE idListVisibilidadIni = {$idListVisibilidadIni}
			)
		";
		return $this->db->query($sql);
	}

	public function delete_lista_iniciativa_detalle_elementos_trade($idListVisibilidadIni){
		$sql = "
			DELETE {$this->sessBDCuenta}.trade.list_iniciativaTradDetElemento 
			WHERE idListIniciativaTradDet IN ( 
				SELECT idListIniciativaTradDet
				FROM {$this->sessBDCuenta}.trade.list_iniciativaTradDet 
				WHERE idListIniciativaTrad = {$idListVisibilidadIni}
			)
		";
		return $this->db->query($sql);
	}

	public function delete_lista_iniciativa_detallle($idListVisibilidadIni){
		$sql = "DELETE FROM {$this->sessBDCuenta}.trade.list_visibilidadTradIniDet WHERE idListVisibilidadIni = {$idListVisibilidadIni}";
		return $this->db->query($sql);
	}

	public function delete_lista_iniciativa_detallle_trade($idListVisibilidadIni){
		$sql = "DELETE FROM {$this->sessBDCuenta}.trade.list_iniciativaTradDet WHERE idListIniciativaTrad = {$idListVisibilidadIni}";
		return $this->db->query($sql);
	}

	public function insertar_lista_iniciativa($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIni";
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

	public function insertar_lista_iniciativa_trade($input=array()){
		

		$table = "{$this->sessBDCuenta}.trade.list_iniciativaTrad";
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

	public function insertar_lista_iniciativa_detalle( $input = [] ){
		$rs_iniciativa = $this->db->get_where('trade.elementoVisibilidadTrad',array('idElementoVis'=>$input['idElementoVis']))->row_array();
		$idIniciativa=$rs_iniciativa['idIniciativa'];

		$arrayDetalle=array();
		$arrayDetalle['idIniciativa'] = $idIniciativa;
		$arrayDetalle['idListVisibilidadIni'] = $input['idListVisibilidadIni'];
		$arrayDetalle['estado'] = 1;

		//validar existencia
		$rs = $this->db->get_where("{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet", $arrayDetalle)->result_array();
		if($rs!=null){
			if(count($rs) >=1){
				//si existe iniciativa agregar detalle elemento
				$idListDetalle=$rs[0]['idListVisibilidadIniDet'];
				$arrayDetalleElemento=array();
				$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
				$arrayDetalleElemento['idElementoVis']=$input['idElementoVis'];
				$arrayDetalleElemento['estado']=1;

				
				$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
				$this->db->trans_begin();

					$insert = $this->db->insert($table, $arrayDetalleElemento);
					$id = $this->db->insert_id();

					

				if ( $this->db->trans_status()===FALSE ) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					
				}
			}else{
				//insertar la iniciativa
				
				$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet";
				$this->db->trans_begin();

					$insert = $this->db->insert($table, $arrayDetalle);
					$id = $this->db->insert_id();

					

				if ( $this->db->trans_status()===FALSE ) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					

					//detalle elemento
					$idListDetalle=$this->db->insert_id();
					$arrayDetalleElemento=array();
					$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
					$arrayDetalleElemento['idElementoVis']=$input['idElementoVis'];
					$arrayDetalleElemento['estado']=1;

					
					$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
					$this->db->trans_begin();

						$insert = $this->db->insert($table, $arrayDetalleElemento);
						$id = $this->db->insert_id();

						

					if ( $this->db->trans_status()===FALSE ) {
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						
					}
				}
			}
		}else{
			//insertar la iniciativa
			
			$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDet";
			$this->db->trans_begin();

				$insert = $this->db->insert($table, $arrayDetalle);
				$id = $this->db->insert_id();

				

			if ( $this->db->trans_status()===FALSE ) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				

				//detalle elemento
				$idListDetalle=$this->db->insert_id();
				$arrayDetalleElemento=array();
				$arrayDetalleElemento['idListVisibilidadIniDet']=$idListDetalle;
				$arrayDetalleElemento['idElementoVis']=$input['idElementoVis'];
				$arrayDetalleElemento['estado']=1;

				
				$table = "{$this->sessBDCuenta}.trade.list_visibilidadTradIniDetElemento";
				$this->db->trans_begin();

					$insert = $this->db->insert($table, $arrayDetalleElemento);
					$id = $this->db->insert_id();

					

				if ( $this->db->trans_status()===FALSE ) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					
				}
			}
		}
		return $insert;
	}

	public function obtener_cliente($input=array()){
		$filtros = '';
		$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
		if( !empty($input['idCuenta'])){
			if($input['idCuenta']=="3"){
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
			}else if($input['idCuenta']=="13"){
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
			}else if($input['idCuenta']=="2"){
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
			}else{
				$tablahistorico="{$this->sessBDCuenta}.trade.cliente_historico";
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
				Impacttrade_aje.trade.cargaIniciativa c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				Impacttrade_pg.trade.cargaIniciativa c
			WHERE 
				c.estado = 1 

			UNION

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
				Impacttrade_small.trade.cargaIniciativa c
			WHERE 
				c.estado = 1 
		";
		return $this->db->query($sql);
	}

	public function update_carga_iniciativa($where=array(), $params=array()){
		

		$table = "{$this->sessBDCuenta}.trade.cargaIniciativa";
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			
		}

		return $update;
	}

	public function update_carga_iniciativa_clientes_count($params){
		$sql ="
			UPDATE {$this->sessBDCuenta}.trade.cargaIniciativa
			SET totalClientes= (
				SELECT COUNT(*) FROM (
					SELECT 
					 *
					FROM 
					  	{$this->sessBDCuenta}.trade.cargaIniciativaDet c
					WHERE 
						c.estado = 1 
					AND c.idCarga={$params['idCarga']}
				) A )
			WHERE idCarga ={$params['idCarga']};
		";
		
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
				Impacttrade_aje.trade.cargaIniciativa c
			WHERE 
				c.estado = 1 
				and c.procesado=1

			UNION

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
				Impacttrade_pg.trade.cargaIniciativa c
			WHERE 
				c.estado = 1 
				and c.procesado=1

			UNION

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
				Impacttrade_small.trade.cargaIniciativa c
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
				{$this->sessBDCuenta}.trade.cargaIniciativaDet c
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
				{$this->sessBDCuenta}.trade.cargaIniciativaDet c
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
			{$this->sessBDCuenta}.trade.cargaIniciativaDet c
		JOIN {$this->sessBDCuenta}.trade.iniciativaTradElemento ite 
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
		
		$table = "{$this->sessBDCuenta}.trade.list_iniciativaTradDet";
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
		
		$table = "{$this->sessBDCuenta}.trade.list_iniciativaTradDet";
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
			update  {$this->sessBDCuenta}.trade.cargaIniciativa
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		
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
				Impacttrade_aje.trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 

			UNION 

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
				Impacttrade_pg.trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 

			UNION 

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
				Impacttrade_small.trade.cargaClienteProyecto c
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
				Impacttrade_aje.trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				Impacttrade_pg.trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')

			UNION

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
				Impacttrade_small.trade.cargaClienteProyecto c
			WHERE 
				c.estado = 1 
				and (c.procesado IS NULL or c.procesado='0')
		";
		return $this->db->query($sql);
	}

	public function update_carga_cliente_proyecto($where=array(), $params=array()){
		

		$table = "{$this->sessBDCuenta}.trade.cargaClienteProyecto";
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			
		}

		return $update;
	}

	public function update_carga_cliente_proyecto_clientes_count($params){
		$sql ="
			UPDATE {$this->sessBDCuenta}.trade.cargaClienteProyecto
			SET totalClientes= (select count(*) from {$this->sessBDCuenta}.trade.cargaClienteProyectoDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		
		return $this->db->query($sql);
	}

	public function update_carga_cliente_proyecto_fecha($params){
		$sql ="
			update  {$this->sessBDCuenta}.trade.cargaClienteProyecto
			set finRegistro=getdate()
			where idCarga={$params['idCarga']};
		";
		
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
		
		$table = "{$this->sessBDCuenta}.trade.cargaClienteProyectoNoProcesados";
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

	public function update_carga_cliente_proyecto_count($params){
		$sql ="
			UPDATE {$this->sessBDCuenta}.trade.cargaClienteProyecto
			SET totalClientes= (select count(*) from {$this->sessBDCuenta}.trade.cargaClienteProyectoDet where idCarga={$params['idCarga']})
			WHERE idCarga ={$params['idCarga']};
		";
		
		return $this->db->query($sql);
	}

	public function carga_cliente_proyecto_det($params){
		$sql = "
			 SELECT 
				c.*
			FROM 
				{$this->sessBDCuenta}.trade.cargaClienteProyectoDet c
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

	public function get_peticiones_actualizar_visitas(){
		$bdCuenta = $this->sessBDCuenta;
		$sql = "
		DECLARE @fecha date=getdate();
		SELECT  v.idPeticion,v.idUsuario,v.idProyecto,fechaIni,fechaFin,vd.hora,v.estado,v.porcentaje,
			CONVERT(varchar,fechaActualizacion,103) fechaActualizacion,
			CASE WHEN (fechaActualizacion IS NOT NULL) THEN 1 ELSE 0 END actualizado,
			idCuenta,idRuta
		FROM 
			{$this->sessBDCuenta}.trade.peticionActualizarVisitas v
			JOIN {$this->sessBDCuenta}.trade.peticionActualizarVisitasDet vd
				ON vd.idPeticion=v.idPeticion
		WHERE 
		v.estado=1 
		";
		return $this->db->query($sql)->result_array();
	}

	public function actualizar_peticion_estado($post)
	{
		$bdCuenta = $this->sessBDCuenta;

		$sql = "
			DECLARE @fecha date=GETDATE();
			UPDATE {$this->sessBDCuenta}.trade.peticionActualizarVisitas
				SET estado=0
			WHERE 
				idPeticion={$post['idPeticion']}
			;";
		return $this->db->query($sql);
	}

	public function actualizar_visitas($post)
	{
		$sql = "
			UPDATE {$this->sessBDCuenta}.trade.data_visita
			SET estado=estado
			where idRuta={$post['idRuta']}"
			;
		return $this->db->query($sql);
	}

	public function actualizar_peticion($post)
	{
		$sql = "
			DECLARE @fecha date=GETDATE();
			UPDATE {$this->sessBDCuenta}.trade.peticionActualizarVisitas
				SET estado=0,fechaActualizacion=GETDATE(),hora=GETDATE(),porcentaje={$post['porcentaje']}
			WHERE 
				idPeticion={$post['idPeticion']}
			;";
		return $this->db->query($sql);
	}

	public function actualizar_peticion_det($post){
		$sql = "
			DECLARE @fecha date=GETDATE();
			UPDATE {$this->sessBDCuenta}.trade.peticionActualizarVisitasDet
				SET estado=0,hora=GETDATE()
			WHERE 
				idPeticion={$post['idPeticion']} AND idRuta={$post['idRuta']} 
			;";
		return $this->db->query($sql);
	}

	public function data_procesada($post){
		$sql = "
		SELECT * FROM (
			SELECT DISTINCT 
			COUNT(estado) OVER () total,
			COUNT(estado) OVER (PARTITION BY estado) procesados, 
			estado  FROM {$this->sessBDCuenta}.trade.peticionActualizarVisitasDet 
			WHERE idPeticion={$post['idPeticion']}
			) a
		WHERE estado = 0"
			;
		return $this->db->query($sql);

	}

	public function validar_usuario_historico($params)
	{
		$sql = "
		DECLARE 
		@fecIni DATE = '{$params['fecIni']}', 
		@fecFin DATE = '{$params['fecFin']}';
		SELECT
		u.idUsuario
		FROM
		trade.usuario u
		JOIN trade.usuario_historico uh ON u.idUsuario = uh.idUsuario
		WHERE
		uh.idProyecto = {$params['idProyecto']}
		AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin) = 1
		AND u.idUsuario = {$params['idUsuario']}
		AND uh.idTipoUsuario = {$params['idTipoUsuario']}
		";
		$rs = $this->db->query($sql)->row_array();
		return (!empty($rs)) ? true: false ;

	}




}

 ?>