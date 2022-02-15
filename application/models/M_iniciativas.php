<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_iniciativas extends MY_Model{

	var $CI;
	
	public function __construct(){
		parent::__construct();
		$this->CI = &get_instance();
	}
	
	public function query($sql){
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_iniciativas($input = []){

		$filtros = "";
		$filtros .= !empty($input['cuenta']) ? ' AND r.idCuenta='.$input['cuenta'] : '';
		$filtros .= !empty($input['proyecto']) ? ' AND r.idProyecto='.$input['proyecto'] : '';
		$filtros .= !empty($input['grupoCanal']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal'] : '';
		$filtros .= !empty($input['canal']) ? ' AND v.idCanal='.$input['canal'] : '';
		$filtros .= !empty($input['subcanal']) ? ' AND ct.idClienteTipo ='.$input['subcanal'] : '';

		$filtros .= !empty($input['tipoUsuario']) ? " AND uh.idTipoUsuario=".$input['tipoUsuario'] : "";
		$filtros .= !empty($input['usuario']) ? " AND uh.idUsuario=".$input['usuario'] : "";

		$filtros .= !empty($input['distribuidoraSucursal']) ? ' AND ds.idDistribuidoraSucursal IN ('.$input['distribuidoraSucursal'].')' : '';
		$filtros .= !empty($input['distribuidora']) ? ' AND d.idDistribuidora='.$input['distribuidora'] : '';
		$filtros .= !empty($input['zona']) ? ' AND z.idZona='.$input['zona'] : '';
		$filtros .= !empty($input['plaza']) ? ' AND pl.idPlaza='.$input['plaza'] : '';
		$filtros .= !empty($input['cadena']) ? ' AND cad.idCadena='.$input['cadena'] : '';
		$filtros .= !empty($input['banner']) ? ' AND ba.idBanner='.$input['banner'] : '';
		$filtros .= !empty($input['usuario']) ? ' AND r.idUsuario='.$input['usuario'] : '';

		$filtros .= !empty($input['externo']) ? ' AND id.validacion_analista = 1' : '';

		$idProyecto = $this->sessIdProyecto;

		if(!empty($input['foto'])){
			if($input['foto'] == "si"){
				$filtros .=' AND vf.idVisitaFoto IS NOT NULL';
			}else if($input['foto'] == "no"){
				$filtros .=' AND vf.idVisitaFoto IS NULL';
			}
		}
		if(!empty($input['validado'])){
			if($input['validado'] == "si"){
				$filtros .=' AND id.validacion_ejecutivo = 1';
			}else if($input['foto'] == "no"){
				$filtros .=' AND (id.validacion_ejecutivo IS NULL OR id.validacion_ejecutivo = 0 )';
			}
		}
		if(!empty($input['habilitado'])){
			if($input['habilitado'] == "si"){
				$filtros .=' AND id.validacion_analista = 1';
			}else if($input['habilitado'] == "no"){
				$filtros .=' AND (id.validacion_analista IS NULL OR id.validacion_analista = 0 )';
			}
		}

		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}

		$filtros .= !empty($input['elementos']) ? ' AND id.idElementoIniciativa IN ('.$input['elementos'].')' : '';
		$filtros .= !empty($input['iniciativas']) ? ' AND id.idIniciativa IN ('.$input['iniciativas'].')' : '';
		$filtros .= !empty($input['idDistribuidoraSucursal']) ? ' AND sct.idDistribuidoraSucursal IN ('.$input['idDistribuidoraSucursal'].')' : '';

		$segmentacion = getSegmentacion(['grupoCanal_filtro'=>$input['grupoCanal']]);

		$sql = "
			DECLARE
				@fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			SELECT TOP 10
				  gc.idGrupoCanal
				, gc.nombre grupoCanal
				, ca.idCanal
				, ca.nombre canal
				, v.idCliente
				, v.razonSocial
				, r.idUsuario
				, r.nombreUsuario
				, r.tipoUsuario
				, CONVERT(varchar,r.fecha,103) fecha
				, CONVERT(varchar,i.hora,108) hora
				, it.idIniciativa
				, it.nombre iniciativa
				, ei.idElementoVis idElementoIniciativa
				, ei.nombre elementoIniciativa
				, eit.idEstadoIniciativa
				, eit.nombre estadoIniciativa
				, ISNULL(id.presencia,0) presencia
				, ISNULL(id.cantidad,0) cantidad
				, ISNULL(vf.fotoURL,'') foto
				, id.validacion_ejecutivo
				, id.validacion_analista
				, id.editado
				, id.idVisitaIniciativaTradDet
				, ISNULL(id.producto, 0) AS cuentaConProducto
				, c.codDist
				, c.codCliente
				, ct.nombre subCanal
				{$segmentacion['columnas_bd']}

			FROM 
				{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad i
				JOIN {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet id
					ON id.idVisitaIniciativaTrad = i.idVisitaIniciativaTrad
				JOIN {$this->sessBDCuenta}.trade.data_visita v
					ON v.idVisita = i.idVisita
				JOIN {$this->sessBDCuenta}.trade.data_ruta r
					ON r.idRuta = v.idRuta
				JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
					AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
					AND uh.idProyecto=r.idProyecto

				JOIN trade.cliente c 
					ON c.idCliente = v.idCliente
				LEFT JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = v.idCliente
					AND General.dbo.fn_fechavigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
					AND ch.idProyecto={$idProyecto}
				LEFT JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				LEFT JOIN trade.cliente_tipo ct
					ON ct.idClienteTipo = sn.idClienteTipo
				JOIN trade.canal ca
					ON ca.idCanal = v.idCanal
				LEFT JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
				LEFT JOIN trade.subCanal subca 
					ON subca.idSubCanal = sn.idSubcanal
				JOIN {$this->sessBDCuenta}.trade.iniciativaTrad it
					ON it.idIniciativa = id.idIniciativa
				JOIN trade.elementoVisibilidadTrad ei
					ON ei.idElementoVis=id.idElementoIniciativa
				LEFT JOIN trade.estadoIniciativaTrad eit
					ON eit.idEstadoIniciativa=id.idEstadoIniciativa
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf
					ON vf.idVisitaFoto = id.idVisitaFoto
				{$segmentacion['join']}

			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
			{$filtro_demo}
		";

		return $this->query($sql);
	}
	
	public function obtener_iniciativas_det($params = []){
		$filtros = "";

		$sql = "
			SELECT 
				eit.idEstadoIniciativa
				, eit.nombre estadoIniciativa
				, ISNULL(id.presencia,0) presencia
				, ISNULL(id.cantidad,0) cantidad
				, id.idVisitaIniciativaTradDet
			FROM 
			{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad i
			JOIN {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet id
				ON id.idVisitaIniciativaTrad = i.idVisitaIniciativaTrad
			JOIN {$this->sessBDCuenta}.trade.iniciativaTrad it
				ON it.idIniciativa = id.idIniciativa
			LEFT JOIN trade.elementoIniciativaTrad ei
				ON ei.idElementoIniciativa=id.idElementoIniciativa
			LEFT JOIN trade.estadoIniciativaTrad eit
				ON eit.idEstadoIniciativa=id.idEstadoIniciativa
			WHERE it.estado = 1
			AND id.idVisitaIniciativaTradDet='".$params['idIniciativaDet']."'
			{$filtros}
		";

		return $this->query($sql);
	}
	
	public function obtener_estados(){
		$sql = "
			SELECT idEstadoIniciativa,nombre FROM trade.estadoIniciativaTrad WHERE estado=1
		";

		return $this->query($sql);
	}
	
	public function obtener_estado_validacion($id){
		$sql = "
			SELECT validacion_ejecutivo,validacion_analista FROM {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet WHERE idVisitaIniciativaTradDet = $id
		";

		return $this->query($sql);
	}
	
	
	public function visitas_pdf($filtro,$fecIni,$fecFin){
		$sql = "
			DECLARE
				  @fecIni DATE = '".$fecIni."'
				, @fecFin DATE = '".$fecFin."'
			SELECT
				  gc.idGrupoCanal
				, gc.nombre grupoCanal
				, ca.idCanal
				, ca.nombre canal
				, d.idDistribuidora
				, d.nombre+' - '+ubd.departamento distribuidoraSucursal
				, ubp.departamento
				, pl.nombre plaza
				, v.idCliente
				, v.razonSocial
				, r.idUsuario
				, r.nombreUsuario
				, CONVERT(varchar,r.fecha,103) fecha
				, CONVERT(varchar,i.hora,108) hora
				, it.idIniciativa
				, it.nombre iniciativa
				, ei.idElementoVis AS idElementoIniciativa
				, ei.nombre elementoIniciativa
				, eit.idEstadoIniciativa
				, eit.nombre estadoIniciativa
				, ISNULL(id.presencia,0) presencia
				, ISNULL(id.cantidad,0) cantidad
				, ISNULL(vf.fotoURL,'') foto
				, id.validacion_ejecutivo
				, id.validacion_analista
				, id.editado
				, id.idVisitaIniciativaTradDet
			FROM 
				{$this->sessBDCuenta}.trade.data_visitaIniciativaTrad i
				JOIN {$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet id
					ON id.idVisitaIniciativaTrad = i.idVisitaIniciativaTrad
				JOIN {$this->sessBDCuenta}.trade.data_visita v
					ON v.idVisita = i.idVisita
				JOIN {$this->sessBDCuenta}.trade.data_ruta r
					ON r.idRuta = v.idRuta
				JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = v.idCliente
					AND General.dbo.fn_fechavigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
					AND ch.idProyecto= {$this->sessIdProyecto}
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				JOIN trade.canal ca
					ON ca.idCanal = sn.idCanal
				JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
				JOIN trade.segmentacionClienteTradicional sct
					ON sct.idSegClienteTradicional = ch.idSegClienteTradicional
				LEFT JOIN trade.distribuidoraSucursal ds
					ON ds.idDistribuidoraSucursal = sct.idDistribuidoraSucursal
				LEFT JOIN trade.distribuidora d
					ON d.idDistribuidora = ds.idDistribuidora
				LEFT JOIN general.dbo.ubigeo ubd
					ON ubd.cod_ubigeo = ds.cod_ubigeo
				LEFT JOIN trade.plaza pl
					ON pl.idPlaza = sct.idPlaza
				LEFT JOIN general.dbo.ubigeo ubp
					ON ubp.cod_ubigeo = pl.cod_ubigeo
				LEFT JOIN {$this->sessBDCuenta}.trade.iniciativaTrad it
					ON it.idIniciativa = id.idIniciativa
				LEFT JOIN trade.elementoVisibilidadTrad ei
					ON ei.idElementoVis=id.idElementoIniciativa
				LEFT JOIN trade.estadoIniciativaTrad eit
					ON eit.idEstadoIniciativa=id.idEstadoIniciativa
				LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf
					ON vf.idVisitaFoto = id.idVisitaFoto
			WHERE 
				1=1
				$filtro
		";

		return $this->query($sql);
	}

	public function obtener_tipos_usuarios($input=array())
	{
		$filtros= '';
		$filtros.= !empty($input['cuenta']) ? (" AND tuc.idCuenta =".$input['cuenta'] ) : '';
		$sql = "
			SELECT tuc.idCuenta, 
				ut.idTipoUsuario, 
				ut.nombre tipoUsuario
			FROM trade.tipoUsuarioCuenta tuc
				INNER JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = tuc.idTipoUsuario
			WHERE
				1=1
				$filtros
		";

		return $this->db->query($sql)->result_array();
	}


	public function obtener_usuarios($input=array()){
		$filtros = "";
		$filtros.= !empty($input['cuenta']) ? (" AND py.idCuenta =".$input['cuenta'] ) : '';
		$filtros.= !empty($input['idTipoUsuario']) ? (" AND uh.idTipoUsuario =".$input['idTipoUsuario'] ) : '';

		$sql="
		DECLARE @fecha DATE=GETDATE();
		----
		SELECT
			distinct	
			uh.idUsuario
			, u.apePaterno+' '+u.apeMaterno+' '+u.nombres AS nombreUsuario
		FROM trade.usuario_historico uh
		JOIN trade.aplicacion ap ON ap.idAplicacion=uh.idAplicacion
		JOIN trade.usuario u ON u.idUsuario=uh.idUsuario
		JOIN trade.proyecto py ON py.idProyecto=uh.idProyecto
		WHERE uh.estado=1
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		AND ap.estado=1  
		AND u.estado=1 AND u.demo=0
		{$filtros}";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_elementos_visibilidad($input=array()){
		$filtros = "";
		$filtros.= !empty($input['cuenta']) ? (" AND et.idCuenta =".$input['cuenta'] ) : '';

		$sql="
			select 
				distinct
				et.idElementoVis,
				et.nombre
				from trade.elementoVisibilidadTrad et
				where et.idTipoElementoVisibilidad=2
				and et.estado=1
				{$filtros}
			ORDER BY et.nombre 
		";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_distribuidora_sucursal(){
		$sql = "SELECT
			ds.idDistribuidoraSucursal
			, d.nombre+' - '+ ubi.distrito AS distribuidoraSucursal
		FROM trade.distribuidoraSucursal ds
		JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		WHERE ds.estado=1 AND d.estado=1";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_elementos_iniciativas($params = [])
	{
		$filtros = "";
		$filtros .= !empty($params['cuenta']) ? (" AND idCuenta =" . $params['cuenta']) : '';
		// $filtros .= !empty($params['proyecto']) ? (" AND idProyecto =" . $params['proyecto']) : '';

		$sql = "
			DECLARE @fechaHoy DATE = GETDATE();
			SELECT
				idIniciativa
				, nombre
				, descripcion
			FROM {$this->sessBDCuenta}.trade.iniciativaTrad
			WHERE estado = 1
			AND fn.datesBetween(fecIni, fecFin, @fechaHoy, @fechaHoy) = 1
			{$filtros}
		";
		return $this->db->query($sql)->result_array();
	}

	public function actualizarIniciativa($params = [])
	{
		$result = [
			'status' => false,
			'id' => '',
		];
		
		$this->db->trans_begin();

		foreach($params AS $key => $row){
			if(!empty($row['iniciativas'])){
				$this->db->where('idVisitaIniciativaTradDet',  $row['iniciativas'] );
				$this->db->update("{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet", ['validacion_analista' => $row['tipoHabilitar']]);
			}
		}

		$id = $this->db->insert_id();
		$aSessTrack = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet", 'id' => $id ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$result['status'] = true;
			$result['id'] = $id;

			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $result;
	}

	public function editarIniciativa($params = [])
	{
		$result = [
			'status' => false,
			'id' => '',
		];
		
		$this->db->trans_begin();

		$this->db->where('idVisitaIniciativaTradDet',  $params['idIniciativaDet'] );
		$this->db->update("{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet", $params['editar']);

		$id = $this->db->insert_id();
		$aSessTrack = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaIniciativaTradDet", 'id' => $id ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$result['status'] = true;
			$result['id'] = $id;

			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $result;
	}

}
?>