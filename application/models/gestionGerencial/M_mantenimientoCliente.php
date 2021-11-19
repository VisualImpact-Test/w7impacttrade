<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mantenimientoCliente extends MY_Model{
	var $aSessTrack = [];
	public function __construct(){
		parent::__construct();
	}

	public function obtener_visitas($input=array()){
		$filtros = "";
		if(empty($input['proyecto_filtro'])){
		$filtros.= getPermisos('cuenta');
		}else{
		$filtros .= !empty($input['idCuenta']) ? ' AND r.idCuenta='.$input['idCuenta'] : '';
		$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
		$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
		$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
		}

		$sql = "
			DECLARE @fecIni DATE = '".$input['fecIni']."',@fecFin DATE = '".$input['fecFin']."';
			SELECT DISTINCT
				r.idRuta,
				CONVERT(VARCHAR,r.fecha,103) AS fecha,
				us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor,
				dvm.idVisitaMantCliente,
				dvm.idVisita,
				dvm.hora,
				dvm.codCliente,
				dvm.nombreComercial,
				dvm.razonSocial razonSociald,
				dvm.ruc,
				dvm.dni,
				dvm.cod_ubigeo,
				dvm.direccion,
				dvm.latitud,
				dvm.longitud,
				dvm.estado
				
				, r.idUsuario
				, r.nombreUsuario
				, v.idVisita
				, v.canal
				, v.idCliente
				, v.razonSocial
				, ubi.departamento
				, ubi.provincia
				, ubi.distrito

				, v.idDistribuidoraSucursal
				, ds.idDistribuidora
				, d.nombre AS distribuidora
				, ds.cod_ubigeo
				, ubi1.distrito AS ciudadDistribuidoraSuc
				, ubi1.cod_ubigeo AS codUbigeoDistrito
				,dvm.validado
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente dvm ON dvm.idVisita=v.idVisita
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=dvm.cod_ubigeo
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
			LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
			LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
			LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
			LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
			LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario

			WHERE r.estado=1 AND v.estado=1 AND r.demo=0
			AND r.fecha BETWEEN @fecIni AND @fecFin
			$filtros
			ORDER BY fecha, departamento, canal, supervisor, nombreUsuario  ASC
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_detalle($input=array()){
		$sql = "
			SELECT DISTINCT
				r.idRuta,
				CONVERT(VARCHAR,r.fecha,103) AS fecha,
				dvm.idVisitaMantCliente,
				dvm.idVisita,
				dvm.hora,
				dvm.codCliente,
				dvm.nombreComercial,
				dvm.razonSocial,
				dvm.ruc,
				dvm.dni,
				dvm.cod_ubigeo,
				dvm.direccion,
				dvm.latitud,
				dvm.longitud,
				dvm.estado
				, ubi.departamento
				, ubi.provincia
				, ubi.distrito

				
				,ch.idClienteHist
				, r.idUsuario
				, r.nombreUsuario
				, v.idVisita
				, ch.idCliente

				, ch.codCliente as codClienteH
				, ch.nombreComercial as nombreComercialH
				, ch.razonSocial as razonSocialH
				, c.ruc as rucH
				, c.dni as dniH
				, ch.cod_ubigeo as cod_ubigeoH
				, ubi1.departamento as departamentoH
				, ubi1.provincia as provinciaH
				, ubi1.distrito as distritoH
				, ch.direccion AS direccionH

			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
			JOIN {$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente dvm ON dvm.idVisita=v.idVisita

			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=v.idCliente
			JOIN trade.cliente c ON c.idCliente=v.idCliente
			
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
			LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ch.cod_ubigeo

			WHERE r.estado=1 AND v.estado=1 AND r.demo=0
			AND v.idVisita=".$input['idVisita']."";
		$query = $this->db->query($sql);
		return $query;
	}
  
	public function actualizar_mantenimiento_cliente($post)
	{
		$update = [
            'validado' => 1
        ];
		$where = [
			"idVisitaMantCliente" => $post['idVisitaMantCliente']
		];

		$this->db->where($where);
		$update = $this->db->update("{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente", $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.trade.data_visitaMantenimientoCliente", 'id' => "idVisitaMantCliente"];
		return $update;
	}


	public function actualizar_cliente($post)
	{
		$update = [];
		if( !empty($post['ruc']) ) $update['ruc']=$post['ruc'];
		if( !empty($post['dni']) ) $update['dni']=$post['dni'];

		$where = [
			"idCliente" => $post['idCliente']
		];

		$this->db->where($where);
		$update = $this->db->update("trade.cliente", $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => "trade.cliente", 'id' => "idVisitaMantCliente"];
		return $update;
	}

	public function actualizar_cliente_historico($post)
	{
		$update = [];
		if( !empty($post['codCliente']) ) $update['codCliente']=$post['codCliente'];
		if( !empty($post['nombreComercial']) ) $update['nombreComercial']=$post['nombreComercial'];
		if( !empty($post['razonSocial']) ) $update['razonSocial']=$post['razonSocial'];
		if( !empty($post['direccion']) ) $update['direccion']=$post['direccion'];
		if( !empty($post['latitud']) ) $update['latitud']=$post['latitud'];
		if( !empty($post['longitud']) ) $update['longitud']=$post['longitud'];

		$where = [
			"idClienteHist" => $post['idClienteHist']
		];

		$this->db->where($where);
		$update = $this->db->update(getClienteHistoricoCuenta(), $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => getClienteHistoricoCuenta(), 'id' => "idClienteHist"];
		return $update;
	}
}
?>