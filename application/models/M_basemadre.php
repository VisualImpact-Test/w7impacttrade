<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_basemadre extends MY_Model{

	var $CI;

	public function __construct(){
		parent::__construct();

		$this->CI =& get_instance();
	}

	public function verificar_cuenta($input=array()){
		$filtros = "";
			$filtros .= !empty($input['idUsuario']) ? ' AND uh.idUsuario='.$input['idUsuario'] : '';

		$sql= "
			DECLARE @fecha date=getdate();
			select p.idCuenta,p.idProyecto from trade.usuario_historico uh
			JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
			WHERE @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha) and 
			uh.estado=1
			{$filtros}
		";

		$query = $this->db->query($sql);
		$result = array();
		$result = $query->result_array();
		$arr_result=array();
		foreach($result as $row){
			array_push($arr_result,$row['idCuenta']);
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $arr_result;
	}

	public function obtener_basemadre_pg($input=array()){
		$filtros = "";

		if( empty($input['idCuenta']) ){
			$filtros.= getPermisos('cuenta');
		}
		else{
			$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta='.$input['idCuenta'] : '';
			$filtros .= !empty($input['idProyecto']) ? ' AND ch.idProyecto='.$input['idProyecto'] : '';
			$filtros .= !empty($input['cartera']) ? ' AND ch.flagCartera='.$input['cartera'] : ' AND ch.flagCartera=0';
		}
		$sql = "
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT DISTINCT
			c.idCliente, c.razonSocial, c.codCliente, c.direccion, c.nombreComercial, ch.idFrecuencia frecuencia
			, ub.departamento, ub.provincia, ub.distrito, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
			, ca.idCanal, ca.nombre canal
			, map.id_anychartmaps idMap
			, cu.nombre cuenta
			, py.nombre proyecto
			, ch.flagCartera
			, b.idBanner
			, b.nombre banner
			, cd.nombre cadena
			, scm.idSegClienteModerno moderno
			, 0 monto
		FROM
			trade.cliente c
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente 
				AND (
					ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
					AND (
						ch.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
					)
				) --AND ch.flagCartera = 1
			JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal AND ca.estado = 1
			LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno = ch.idSegClienteModerno
			LEFT JOIN trade.banner b ON b.idBanner = scm.idBanner
			LEFT JOIN trade.cadena cd ON cd.idCadena = b.idCadena
			JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = c.cod_ubigeo
			JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
		WHERE
			c.estado = 1
			{$filtros}
		ORDER BY canal, departamento, provincia, distrito, cadena, banner, razonSocial ASC
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_basemadre($input=array()){
		$filtros = "";
			if( empty($input['idCuenta']) ){
				$filtros.= getPermisos('cuenta');
			}
			else{
				$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta='.$input['idCuenta'] : '';
				$filtros .= !empty($input['idProyecto']) ? ' AND ch.idProyecto='.$input['idProyecto'] : '';
				$filtros .= !empty($input['cartera']) ? ' AND ch.flagCartera='.$input['cartera'] : ' AND ch.flagCartera=0';
				$filtros .= !empty($input['grupoCanal']) ? ' AND gc.idGrupoCanal='.$input['grupoCanal'] : '';
				$filtros .= !empty($input['canal']) ? ' AND ca.idCanal='.$input['canal'] : '';
				$filtros .= !empty($input['subcanal']) ? ' AND ctp.idClienteTipo='.$input['subcanal'] : '';
				$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND tu.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
				$filtros .= !empty($input['usuario_filtro']) ? ' AND u.idUsuario='.$input['usuario_filtro'] : '';
				$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
				$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
				$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
				$filtros .= !empty($input['plaza_filtro']) ? ' AND sct.idPlaza='.$input['plaza_filtro'] : '';
				$filtros .= !empty($input['cadena_filtro']) ? ' AND cd.idCadena='.$input['cadena_filtro'] : '';
				$filtros .= !empty($input['banner_filtro']) ? ' AND b.idBanner='.$input['banner_filtro'] : '';

				//Ubigeo
				$filtros .= !empty($input['departamento_filtro']) ? ' AND ub.cod_departamento='.$input['departamento_filtro'] : '';
				$filtros .= !empty($input['provincia_filtro']) ? ' AND ub.cod_provincia='.$input['provincia_filtro'] : '';
				$filtros .= !empty($input['distrito_filtro']) ? ' AND ub.cod_ubigeo='.$input['distrito_filtro'] : '';
				
			
			}

		if($input['idProyecto']==14){
			$tabla_historico= "{$this->sessBDCuenta}.trade.cliente_historico";
		}else{
			$tabla_historico= getClienteHistoricoCuenta();
		}
		
		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal']]);
		$sql = "
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT DISTINCT
			c.idCliente
			, c.razonSocial
			, c.codCliente
			, c.codDist codPdv
			, c.direccion, c.ruc, c.dni
			, c.nombreComercial, ch.idFrecuencia , fe.nombre as frecuencia
			, ub.departamento, ub.provincia, ub.distrito, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
			, gc.idGrupoCanal
			, ISNULL(pgc.nombre,gc.nombre) grupoCanal
			, ca.idCanal, ca.nombre canal
			, ctp.idClienteTipo
			, ctp.nombre subCanal
			, map.id_anychartmaps idMap
			, cu.nombre cuenta
			, py.nombre proyecto
			, ch.flagCartera
			, 0 monto
			{$segmentacion['columnas_bd']}
			, ctp.nombre AS clienteTipo
		FROM
			trade.cliente c WITH (NOLOCK)
			JOIN ".$tabla_historico." ch WITH (NOLOCK) ON ch.idCliente = c.idCliente 
				AND (
					ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
					AND (
						ch.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
					)
				) --AND ch.flagCartera = 1
			JOIN trade.proyecto py WITH (NOLOCK) ON py.idProyecto = ch.idProyecto
			JOIN trade.cuenta cu WITH (NOLOCK) ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.segmentacionNegocio sn WITH (NOLOCK) ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.canal ca WITH (NOLOCK) ON ca.idCanal = sn.idCanal AND ca.estado = 1
			LEFT JOIN trade.grupoCanal gc WITH (NOLOCK) ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN trade.subCanal subc WITH (NOLOCK) ON sn.idSubCanal = subc.idSubCanal
			LEFT JOIN trade.cliente_tipo ctp WITH (NOLOCK) ON sn.idClienteTipo = ctp.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub WITH (NOLOCK) ON ub.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN master.anychartmaps_ubigeo map WITH (NOLOCK) ON map.cod_departamento = ub.cod_departamento 
			LEFT JOIN trade.frecuencia fe WITH (NOLOCK) ON fe.idFrecuencia=ch.idFrecuencia
			LEFT JOIN trade.proyectoGrupoCanal pgc ON pgc.idGrupoCanal = gc.idGrupoCanal AND pgc.idProyecto = ch.idProyecto
			{$segmentacion['join']}
		WHERE
			c.estado = 1 
			{$filtros}
		ORDER BY canal, departamento, provincia, distrito, razonSocial ASC
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_visita($input=array()){
		$filtros = "";
		// $filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta='.$input['idCuenta'] : '';
		// $filtros .= !empty($input['idProyecto']) ? ' AND ch.idProyecto='.$input['idProyecto'] : '';

		$sql = "
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			WITH lista_visita AS (
				SELECT DISTINCT 
					  v.idVisita
					, r.nombreUsuario
					, v.idCliente
					, ROW_NUMBER() OVER (PARTITION BY v.idCliente ORDER BY r.fecha DESC) fila 
				FROM 
					{$this->sessBDCuenta}.trade.data_ruta r WITH (NOLOCK)
					JOIN {$this->sessBDCuenta}.trade.data_visita v WITH (NOLOCK) ON r.idRuta = v.idRuta
					LEFT JOIN trade.banner b WITH (NOLOCK) ON b.idBanner = v.idBanner
					JOIN General.dbo.ubigeo ub WITH (NOLOCK) ON ub.cod_ubigeo = v.cod_ubigeo
					JOIN trade.canal ca WITH (NOLOCK) ON ca.idCanal = v.idCanal
				WHERE 
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.estado = 1 AND v.estado = 1
					AND r.demo = 0
					{$filtros}
			)
			SELECT * FROM lista_visita WHERE fila = 1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_basemadre_hsm($input = []){
		$filtros = "";
			if( empty($input['idCuenta']) ){
				$filtros.= getPermisos('cuenta');
			}
			else{
				$filtros .= !empty($input['idCuenta']) ? ' AND py.idCuenta='.$input['idCuenta'] : '';
				$filtros .= !empty($input['idProyecto']) ? ' AND ch.idProyecto='.$input['idProyecto'] : '';
				$filtros .= !empty($input['cartera']) ? ' AND ch.flagCartera='.$input['cartera'] : ' AND ch.flagCartera=0';
				$filtros .= !empty($input['grupoCanal']) ? ' AND gc.idGrupoCanal='.$input['grupoCanal'] : '';
				$filtros .= !empty($input['canal']) ? ' AND ca.idCanal='.$input['canal'] : '';
				$filtros .= !empty($input['subcanal']) ? ' AND ctp.idClienteTipo='.$input['subcanal'] : '';
				$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND tu.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
				$filtros .= !empty($input['usuario_filtro']) ? ' AND u.idUsuario='.$input['usuario_filtro'] : '';
				$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
				$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
				$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
				$filtros .= !empty($input['plaza_filtro']) ? ' AND sct.idPlaza='.$input['plaza_filtro'] : '';
				$filtros .= !empty($input['cadena_filtro']) ? ' AND cd.idCadena='.$input['cadena_filtro'] : '';
				$filtros .= !empty($input['banner_filtro']) ? ' AND b.idBanner='.$input['banner_filtro'] : '';
				$filtros .= !empty($input['ciudad_filtro']) ? ' AND ub.cod_departamento='.$input['ciudad_filtro'] : '';
				if(!$input['atendidos'] && !$input['desatendidos']){
					$filtros .= "";
				}else if($input['atendidos'] && !$input['desatendidos']){
					$filtros .= "AND pv.idProgVisita IS NOT NULL";
				}else if(!$input['atendidos'] && $input['desatendidos']){
					$filtros .= "AND pv.idProgVisita IS NULL";
				}else{
					$filtros .= "";
				}
			}

		if($input['idProyecto']==14){
			$tabla_historico= "{$this->sessBDCuenta}.trade.cliente_historico";
		}else{
			$tabla_historico= getClienteHistoricoCuenta();
		}
		
		$segmentacion = getSegmentacion(['grupoCanal_filtro' => $input['grupoCanal']]);
		$sql = "
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT DISTINCT
			c.idCliente
			, c.razonSocial
			, c.codCliente
			, c.codDist codPdv
			, c.direccion, c.ruc, c.dni
			, c.nombreComercial, ch.idFrecuencia , fe.nombre as frecuencia
			, ub.departamento, ub.provincia, ub.distrito, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
			, gc.idGrupoCanal, gc.nombre grupoCanal
			, ca.idCanal, ca.nombre canal
			, ctp.idClienteTipo
			, ctp.nombre subCanal
			, map.id_anychartmaps idMap
			, cu.nombre cuenta
			, py.nombre proyecto
			, ch.flagCartera
			, 0 monto
			{$segmentacion['columnas_bd']}
			, ctp.nombre AS clienteTipo
		FROM trade.cliente c WITH (NOLOCK)
			LEFT JOIN ImpactTrade_pg.trade.programacion_visita pv ON pv.idCliente = c.idCliente
			LEFT JOIN ImpactTrade_pg.trade.programacion_ruta pr ON pr.idProgRuta = pv.idProgRuta
			JOIN ".$tabla_historico." ch WITH (NOLOCK) ON ch.idCliente = c.idCliente 
				AND (
					ch.fecIni <= ISNULL( ch.fecFin, @fecFin)
					AND (
						ch.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( ch.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN ch.fecIni AND ISNULL( ch.fecFin, @fecFin )
					)
				) --AND ch.flagCartera = 1
			JOIN trade.proyecto py WITH (NOLOCK) ON py.idProyecto = ch.idProyecto
			JOIN trade.cuenta cu WITH (NOLOCK) ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.segmentacionNegocio sn WITH (NOLOCK) ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
			LEFT JOIN trade.canal ca WITH (NOLOCK) ON ca.idCanal = sn.idCanal AND ca.estado = 1
			LEFT JOIN trade.grupoCanal gc WITH (NOLOCK) ON ca.idGrupoCanal = gc.idGrupoCanal
			LEFT JOIN trade.subCanal subc WITH (NOLOCK) ON sn.idSubCanal = subc.idSubCanal
			LEFT JOIN trade.cliente_tipo ctp WITH (NOLOCK) ON sn.idClienteTipo = ctp.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub WITH (NOLOCK) ON ub.cod_ubigeo = ch.cod_ubigeo
			LEFT JOIN master.anychartmaps_ubigeo map WITH (NOLOCK) ON map.cod_departamento = ub.cod_departamento 
			LEFT JOIN trade.frecuencia fe WITH (NOLOCK) ON fe.idFrecuencia=ch.idFrecuencia
			{$segmentacion['join']}
		WHERE
			c.estado = 1 
			{$filtros}
		ORDER BY canal, departamento, provincia, distrito, razonSocial ASC
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function getCiudades(){
		$sql = "
		SELECT DISTINCT
		ubi.cod_departamento AS id
		, ubi.departamento AS value
		FROM General.dbo.ubigeo ubi
		WHERE ubi.estado = 1
		";
		return $this->db->query($sql)->result_array();
	}
}

?>