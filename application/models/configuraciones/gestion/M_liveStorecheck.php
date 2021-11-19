<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_liveStorecheck extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function listCadena($input = array()){
		$sql = "SELECT idCadena AS id, UPPER(nombre) AS nombre FROM trade.cadena WHERE estado = 1 ORDER BY nombre";
		return $this->db->query($sql)->result_array();
	}

	public function listBanner($input = array()){
		$filtro = "";
			if( !empty($input['idCadena']) ) $filtro .= " AND idCadena = {$input['idCadena']}";

		$sql = "SELECT idBanner AS id, UPPER(nombre) AS nombre FROM trade.banner WHERE estado = 1{$filtro} ORDER BY nombre";
		return $this->db->query($sql)->result_array();
	}

	public function listTienda_($input = array()){
		$filtro = "";
			if( !empty($input['idCadena']) ) $filtro .= " AND cd.idCadena = {$input['idCadena']}";
			if( !empty($input['idBanner']) ) $filtro .= " AND bn.idBanner = {$input['idBanner']}";

		$sql = "
SELECT
	t.idTienda AS id,
	UPPER(t.razonSocial) AS nombre,
	t.direccion,
	ubi.cod_departamento AS idRegion,
	ubi.departamento AS region
FROM trade.tienda t
JOIN General.dbo.ubigeo ubi ON t.cod_ubigeo = ubi.cod_ubigeo
JOIN trade.banner bn ON t.idBanner = bn.idBanner
JOIN trade.cadena cd ON bn.idCadena = cd.idCadena
WHERE t.estado = 1 AND t.demo = 0{$filtro}
ORDER BY region, nombre";
		return $this->db->query($sql)->result_array();
	}

	public function listTienda($input = array()){
		$filtro = "";
			if( !empty($input['idCliente']) ){
				$filtro .= " AND c.idCliente = ".$input['idCliente'];
			}
			if( !empty($input['idCuenta']) ){
				$filtro .= " AND cu.idCuenta = ".$input['idCuenta'];
			}
			if( !empty($input['idProyecto']) ){
				$filtro .= " AND py.idProyecto = ".$input['idProyecto'];
			}
			if( !empty($input['idGrupoCanal']) ){
				$filtro .= " AND ISNULL(gca.idGrupoCanal, sca_gca.idGrupoCanal) = ".$input['idGrupoCanal'];
			}
			if( !empty($input['idCanal']) ){
				$filtro .= " AND ISNULL(ca.idCanal, sca_ca.idCanal) = ".$input['idCanal'];
			}
			if( !empty($input['idSubCanal']) ){
				$filtro .= " AND sca.idSubCanal = ".$input['idSubCanal'];
			}
			if( !empty($input['idDistribuidora']) ){
				$filtro .= " AND ds.idDistribuidora = ".$input['idDistribuidora'];
			}
			if( !empty($input['idDistribuidoraSucursal']) ){
				$filtro .= " AND dss.idDistribuidoraSucursal = ".$input['idDistribuidoraSucursal'];
			}
			if( !empty($input['idCadena']) ){
				$filtro .= " AND cd.idCadena = ".$input['idCadena'];
			}
			if( !empty($input['idBanner']) ){
				$filtro .= " AND bn.idBanner = ".$input['idBanner'];
			}
			if( !empty($input['idPlaza']) ){
				$filtro .= " AND pz.idPlaza = ".$input['idPlaza'];
			}

		$sql = "
DECLARE
	@fecha DATE = GETDATE();

SELECT
	c.idCliente,
	cu.idCuenta,
	py.idProyecto,
	ISNULL(gca.idGrupoCanal, sca_gca.idGrupoCanal) AS idGrupoCanal,
	UPPER(cu.nombre) AS cuenta,
	UPPER(py.nombre) AS proyecto,
	UPPER(ISNULL(ca.nombre, sca_ca.nombre)) AS canal,
	UPPER(z.nombre) AS zona,
	UPPER(clu.nombre) AS cluster,
	UPPER(cd.nombre) AS cadena,
	UPPER(bn.nombre) AS banner,
	UPPER(ds.nombre) AS distribuidora,
	UPPER(pz.nombre) AS plaza,
	ubi.cod_departamento AS idRegion,
	UPPER(ubi.departamento) AS region,
	UPPER(c.razonSocial) AS razonSocial,
	UPPER(c.nombreComercial) AS nombreComercial,
	UPPER(c.direccion) AS direccion
FROM trade.cliente c
JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON c.idCliente = ch.idCliente AND @fecha BETWEEN fecIni AND ISNULL(fecFin, @fecha)
JOIN trade.segmentacionNegocio sng ON ch.idSegNegocio = sng.idSegNegocio
LEFT JOIN trade.canal ca ON sng.idCanal = ca.idCanal
LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal = gca.idGrupoCanal
LEFT JOIN trade.subCanal sca ON sng.idSubCanal = sca.idSubCanal
LEFT JOIN trade.canal sca_ca ON sca.idCanal = sca_ca.idCanal
LEFT JOIN trade.grupoCanal sca_gca ON sca_ca.idGrupoCanal = sca_gca.idGrupoCanal
LEFT JOIN trade.cluster clu ON sng.idCluster = clu.idCluster
LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional
LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional
LEFT JOIN trade.distribuidoraSucursal dss ON sctd.idDistribuidoraSucursal = dss.idDistribuidoraSucursal
LEFT JOIN trade.distribuidora ds ON dss.idDistribuidora = ds.idDistribuidora
LEFT JOIN trade.plaza pz ON sct.idPlaza = pz.idPlaza
LEFT JOIN trade.zona z ON ch.idZona = z.idZona
LEFT JOIN General.dbo.ubigeo ubi_dss ON dss.cod_ubigeo = ubi_dss.cod_ubigeo
LEFT JOIN trade.segmentacionClienteModerno scm ON ch.idSegClienteModerno = scm.idSegClienteModerno
LEFT JOIN trade.banner bn ON scm.idBanner = bn.idBanner
LEFT JOIN trade.cadena cd ON bn.idCadena = cd.idCadena
JOIN General.dbo.ubigeo ubi ON c.cod_ubigeo = ubi.cod_ubigeo
JOIN trade.proyecto py ON ch.idProyecto = py.idProyecto
JOIN trade.cuenta cu ON py.idCuenta = cu.idCuenta
WHERE c.estado = 1{$filtro}
ORDER BY cuenta, proyecto, canal
";
		return $this->db->query($sql)->result_array();
	}

	public function listEvaluacion($input = array()){
		$filtro = "";
			$filtro .= !empty($input['idCuenta']) ? " AND ev.idCuenta = {$input['idCuenta']}" : "";

		$sql = "SELECT ev.idEvaluacion AS id, ev.nombre FROM trade.live_tipoEvaluacion ev WHERE ev.estado = 1{$filtro} ORDER BY nombre";
		return $this->db->query($sql)->result_array();
	}

	public function listEvaluacionDet($input = array()){
		$filtro = "";
			$filtro .= !empty($input['idCuenta']) ? " AND ev.idCuenta = {$input['idCuenta']}" : "";

		$sql = "
SELECT
	ev.idEvaluacion,
	evd.idEvaluacionDet AS id,
	evd.nombre
FROM trade.live_tipoEvaluacion ev
JOIN trade.live_tipoEvaluacionDet evd ON ev.idEvaluacion = evd.idEvaluacion
WHERE ev.estado = 1 AND evd.estado = 1{$filtro}
ORDER BY nombre
";
		return $this->db->query($sql)->result_array();
	}

	public function listCategoria($input = array()){
		$filtro = "";
			if( !empty($input['idCategoria']) ){
				if( !is_array($input['idCategoria']) ) $input['idCategoria'] = array($input['idCategoria']);
				$filtro .= " AND idCategoria IN (".implode(',', $input['idCategoria']).")";
			}

		$sql = "SELECT idCategoria AS id, UPPER(nombre) AS nombre FROM trade.producto_categoria WHERE estado = 1{$filtro} ORDER BY nombre";
		return $this->db->query($sql)->result_array();
	}

	public function listEncuesta($input = array()){
		$filtro = "";
			$filtro .= !empty($input['idCuenta']) ? "AND en.idCuenta = {$input['idCuenta']}" : "";

		$sql = "
SELECT DISTINCT
	en.idEncuesta AS id,
	en.nombre
FROM trade.live_tipoEncuesta en
JOIN trade.live_tipoEncuestaPreg enp ON en.idEncuesta = enp.idEncuesta
LEFT JOIN trade.live_tipoEncuestaPregAlt enpa ON enp.idPregunta = enpa.idPregunta AND enpa.estado = 1
WHERE en.estado = 1 AND enp.estado = 1{$filtro}
";
		return $this->db->query($sql)->result_array();
	}

	public function liveListCategoria($input = array()){
		$filtro = "";
			$filtro .= !empty($input['fecIni']) ? " AND '{$input['fecIni']}' BETWEEN fecIni AND ISNULL(fecFin, @fecha)" : "";
			$filtro .= !empty($input['idCuenta']) ? " AND idCuenta = {$input['idCuenta']}" : "";
			$filtro .= !empty($input['idProyecto']) ? " AND idCuenta = {$input['idProyecto']}" : "";
			$filtro .= !empty($input['idGrupoCanal']) ? " AND idGrupoCanal = {$input['idGrupoCanal']}" : "";
			$filtro .= !empty($input['idCanal']) ? " AND idCanal = {$input['idCanal']}" : "";
			$filtro .= !empty($input['idSubCanal']) ? " AND idSubCanal = {$input['idSubCanal']}" : "";
			$filtro .= " AND idDistribuidora".( !empty($input['idDistribuidora']) ? " = {$input['idDistribuidora']}" : " IS NULL" );
			$filtro .= " AND idDistribuidoraSucursal".( !empty($input['idDistribuidoraSucursal']) ? " = {$input['idDistribuidoraSucursal']}" : " IS NULL" );
			$filtro .= " AND idCadena".( !empty($input['idCadena']) ? " = {$input['idCadena']}" : " IS NULL" );
			$filtro .= " AND idBanner".( !empty($input['idBanner']) ? " = {$input['idBanner']}" : " IS NULL" );
			$filtro .= " AND idPlaza".( !empty($input['idPlaza']) ? " = {$input['idPlaza']}" : " IS NULL" );

			if( !empty($input['idCliente']) ){
				if( !is_array($input['idCliente']) ){
					$input['idCliente'] = array($input['idCliente']);
				}

				$filtro .= " AND idCliente IN (".implode(',', $input['idCliente']).")";
			}

		$sql = "
DECLARE
	@fecha DATE = GETDATE();

SELECT
	idListCategoria
FROM trade.live_listCategoria
WHERE estado = 1{$filtro}
";
		return $this->db->query($sql)->result_array();
	}

	public function liveListCategoriaDet($input = array()){
		$sql = "
SELECT
	lcg.idListCategoria,
	cg.idCategoria,
	cg.nombre AS categoria,
	lcgd.peso AS pesoCategoria,
	ev.idEvaluacion,
	ev.nombre AS evaluacion,
	ev.orden AS evaluacionOrden,
	evd.idEvaluacionDet,
	evd.nombre AS evaluacionDet,
	enc.idEncuesta,
	enc.nombre AS encuesta,
	lcge.peso AS pesoEvaluacion
FROM trade.live_listCategoria lcg
JOIN trade.live_listCategoriaDet lcgd ON lcg.idListCategoria = lcgd.idListCategoria
JOIN trade.producto_categoria cg ON lcgd.idCategoria = cg.idCategoria
LEFT JOIN trade.live_listCategoriaEval lcge ON lcgd.idListCategoriaDet = lcge.idListCategoriaDet
LEFT JOIN trade.live_tipoEvaluacionDet evd ON lcge.idEvaluacionDet = evd.idEvaluacionDet
LEFT JOIN trade.live_tipoEvaluacion ev ON evd.idEvaluacion = ev.idEvaluacion
LEFT JOIN trade.live_tipoEncuesta enc ON lcge.idEncuesta = enc.idEncuesta
WHERE lcg.idListCategoria = {$input['idListCategoria']}
ORDER BY evaluacionOrden
";
		return $this->db->query($sql)->result_array();
	}

	public function consultar($input = array()){
		$filtro = "";
			$filtro .= !empty($input['idCuenta']) ? " AND cu.idCuenta = {$input['idCuenta']}" : "";
			$filtro .= !empty($input['idProyecto']) ? " AND py.idProyecto = {$input['idProyecto']}" : "";
			$filtro .= !empty($input['idGrupoCanal']) ? " AND gca.idGrupoCanal = {$input['idGrupoCanal']}" : "";
			$filtro .= !empty($input['idCanal']) ? " AND ca.idCanal = {$input['idCanal']}" : "";
			$filtro .= !empty($input['idSubCanal']) ? " AND sca.idSubCanal = {$input['idSubCanal']}" : "";

		$sql = "
SELECT
	lcg.idListCategoria,
	lcg.idGrupoCanal,
	UPPER(cu.nombre) AS cuenta,
	UPPER(py.nombre) AS proyecto,
	UPPER(gca.nombre) AS grupoCanal,
	UPPER(ca.nombre) AS canal,
	UPPER(sca.nombre) AS subCanal,
	UPPER(cd.nombre) AS cadena,
	UPPER(bn.nombre) AS banner,
	UPPER(ds.nombre) AS distribuidora,
	UPPER(ds.nombre+ ' ' + ubi.provincia) AS distribuidoraSucursal,
	UPPER(pz.nombre) AS plaza,
	UPPER(c.razonSocial) AS tienda,
	(
		SELECT COUNT(idListCategoriaDet)
		FROM trade.live_listCategoriaDet lcgd
		WHERE lcgd.idListCategoria = lcg.idListCategoria
	) AS numCat,
	CONVERT(VARCHAR, lcg.fecIni, 103) AS fecIni,
	CONVERT(VARCHAR, lcg.fecFin, 103) AS fecFin,
	lcg.estado
FROM trade.live_listCategoria lcg
LEFT JOIN trade.cuenta cu ON lcg.idCuenta = cu.idCuenta
LEFT JOIN trade.proyecto py ON lcg.idProyecto = py.idProyecto
LEFT JOIN trade.grupoCanal gca ON lcg.idGrupoCanal = gca.idGrupoCanal
LEFT JOIN trade.canal ca ON lcg.idCanal = ca.idCanal
LEFT JOIN trade.subCanal sca ON lcg.idSubCanal = sca.idSubCanal
LEFT JOIN trade.cadena cd ON lcg.idCadena = cd.idCadena
LEFT JOIN trade.banner bn ON lcg.idBanner = bn.idBanner
LEFT JOIN trade.distribuidora ds ON lcg.idDistribuidora = ds.idDistribuidora
LEFT JOIN trade.distribuidoraSucursal dss ON lcg.idDistribuidoraSucursal = dss.idDistribuidoraSucursal
LEFT JOIN General.dbo.ubigeo ubi ON dss.cod_ubigeo = ubi.cod_ubigeo
LEFT JOIN trade.plaza pz ON lcg.idPlaza = pz.idPlaza
LEFT JOIN trade.cliente c ON lcg.idCliente = c.idCliente
WHERE 1 = 1{$filtro}
ORDER BY lcg.fechaReg DESC, lcg.horaReg DESC
";

		return $this->db->query($sql)->result_array();
	}

	public function guardar($input = array()){
		$status = false;
			$this->db->trans_begin();

				$total = 1;
				if( !empty($input['idCliente']) ){
					if( !is_array($input['idCliente']) ){
						$input['idCliente'] = array($input['idCliente']);
					}

					$total = count($input['idCliente']);
				}

				for($i = 0; $i < $total; $i++){
					$iListCategoria = array(
							'fecIni' => $input['fecIni'],
							'idCuenta' => $input['idCuenta'],
							'idProyecto' => $input['idProyecto'],
							'idGrupoCanal' => $input['idGrupoCanal'],
							'idCanal' => $input['idCanal'],
							'idSubCanal' => ( !empty($input['idSubCanal']) ? $input['idSubCanal'] : null ),
							'idCliente' => ( !empty($input['idCliente']) ? $input['idCliente'][$i] : null ),
							'idBanner' => ( !empty($input['idBanner']) ? $input['idBanner'] : null ),
							'idCadena' => ( !empty($input['idCadena']) ? $input['idCadena'] : null ),
							'idDistribuidora' => ( !empty($input['idDistribuidora']) ? $input['idDistribuidora'] : null ),
							'idDistribuidoraSucursal' => ( !empty($input['idDistribuidoraSucursal']) ? $input['idDistribuidoraSucursal'] : null ),
							'idPlaza' => ( !empty($input['idPlaza']) ? $input['idPlaza'] : null ),
							'idUsuarioReg' => $this->idUsuario
						);
					$this->db->insert('trade.live_listCategoria', $iListCategoria);
					$idListCategoria = $this->db->insert_id();

					if( !empty($input["categoria"]) ){
						if( !is_array($input["categoria"]) ){
							$input["categoria"] = array($input["categoria"]);
						}

						foreach($input["categoria"] as $idCategoria){
							$peso = $input["peso[{$idCategoria}]"];

							if( !is_array($input["evaluacionDet[{$idCategoria}]"]) ){
								$input["evaluacionDet[{$idCategoria}]"] = array($input["evaluacionDet[{$idCategoria}]"]);
							}

							$iListCategoriaDet = array(
									'idListCategoria' => $idListCategoria,
									'idCategoria' => $idCategoria,
									'peso' => $peso
								);
								$this->db->insert('trade.live_listCategoriaDet', $iListCategoriaDet);
								$idListCategoriaDet = $this->db->insert_id();

							foreach($input["evaluacionDet[{$idCategoria}]"] as $idEvaluacionDet){
								$peso = $input["peso[{$idCategoria}][{$idEvaluacionDet}]"];
								$idEncuesta = null;
									if( $input["calificar[{$idCategoria}][{$idEvaluacionDet}]"] == 2 ){
										$idEncuesta = $input["encuesta[{$idCategoria}][{$idEvaluacionDet}]"];
									}

								$iListCategoriaEval = array(
										'idListCategoriaDet' => $idListCategoriaDet,
										'idEvaluacionDet' => $idEvaluacionDet,
										'peso' => $peso,
										'idEncuesta' => $idEncuesta
									);
									$this->db->insert('trade.live_listCategoriaEval', $iListCategoriaEval);
							}
						}
					}
				}

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$status = true;
			}

		return $status;
	}

	public function cambiarEstado($input = array()){
		$status = false;
			$this->db->trans_begin();

				foreach($input['idListCategoria'] as $idListCategoria){
					$uListCategoria = array('estado' => $input['estado']);
					$wListCategoria = array('idListCategoria' => $idListCategoria);
					$this->db->update('trade.live_listCategoria', $uListCategoria, $wListCategoria);
				}

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$status = true;
			}

		return $status;
	}

	public function darAlta($input = array()){
		$status = false;

			$this->db->trans_begin();

				foreach($input['idListCategoria'] as $idListCategoria){

					$uListCategoria = array( 'fecFin' => null );
					$wListCategoria = array( 'idListCategoria' => $idListCategoria );
					$this->db->update('trade.live_listCategoria', $uListCategoria, $wListCategoria);
				}

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$status = true;
			}

		return $status;
	}

	public function darBaja($input = array()){
		$return['status'] = false;
		$return['msg'] = '';

			$error = false;
			$this->db->trans_begin();

				foreach($input['idListCategoria'] as $idListCategoria){

					$vrf = $this->db->query("SELECT DATEDIFF(DD, fecIni, '{$input['fecFin']}') AS dias FROM trade.live_listCategoria WHERE idListCategoria = {$idListCategoria}")->row()->dias;
						if( $vrf < 0 ){
							$error = true;
							$return['msg'] = 'Fecha Fin no puede ser menor a la Fecha de Inicio';
							break;
						}

					$uListCategoria = array( 'fecFin' => $input['fecFin'] );
					$wListCategoria = array( 'idListCategoria' => $idListCategoria );
					$this->db->update('trade.live_listCategoria', $uListCategoria, $wListCategoria);
				}

			if( !$this->db->trans_status() || $error ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$return['status'] = true;
			}

		return $return;
	}

}