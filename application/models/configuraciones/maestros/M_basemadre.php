<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_basemadre extends My_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
	}

	public function obtener_maestros_basemadre_distribuidoras($input=array()){
		$filtros = "";
			//$filtros .= !empty($input['proyecto_filtro']) ? " AND p.idProyecto=".$input['proyecto_filtro'] : "";
			// $filtros .= !empty($input['canal_filtro']) ? " AND cn.idCanal=".$input['canal_filtro'] : "";
			$filtros .= !empty($input['idCuenta']) ? " AND cu.idCuenta=".$input['idCuenta'] : "";
			$filtros .= !empty($input['idProyecto']) ? " AND p.idProyecto=".$input['idProyecto'] : "";

			if(!empty($input['clientes'])){
				
				$array=array(); $clientes=array(); $i=0;
				$array=explode("\r\n",($input['clientes']));
				$fl="";
				$array_res=array();
				if(is_array($array)){
					$fl=" AND ch.nombreComercial IN ('";

					foreach($array as $row){
						array_push($array_res,preg_replace("/\s+/u", " ", $row));
					}
					$string_=implode("','",$array_res);
					$fl=$fl.$string_."')";
				}else{
					$cl=trim($input['clientes']);
					$fl=" AND ch.nombreComercial IN ('". preg_replace("/\s+/u", " ", $cl) . "' )'";
				}
				$filtros .=$fl;
			}
			
		$sql = "DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		------
		SELECT 
			DISTINCT 
			ch.idClienteHist
			, ch.idCliente
			, dd.nombre+'-'+ubid.distrito  distribuidorasSucursal
		FROM trade.cliente c 
		JOIN ImpactTrade_pg.trade.cliente_historico ch ON ch.idCliente=c.idCliente
		JOIN trade.cuenta cu ON cu.idCuenta=ch.idCuenta
		JOIN trade.proyecto p ON p.idProyecto=ch.idProyecto

		JOIN trade.segmentacionClienteTradicionalDet sct ON sct.idSegClienteTradicional=ch.idSegClienteTradicional
		JOIN trade.distribuidorasucursal dss ON dss.idDistribuidoraSucursal=sct.idDistribuidoraSucursal
		JOIN trade.distribuidora dd ON dd.idDistribuidora=dss.idDistribuidora
		JOIN General.dbo.Ubigeo ubid ON ubid.cod_ubigeo=dss.cod_ubigeo

		WHERE c.estado=1 
		{$filtros}
		--AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
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
		)
		ORDER BY ch.idClienteHist DESC";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_maestros_basemadre($input=array()){
		$filtros = "";
			//$filtros .= !empty($input['proyecto_filtro']) ? " AND p.idProyecto=".$input['proyecto_filtro'] : "";
			$filtros .= !empty($input['grupoCanal_filtro']) ? " AND gc.idGrupoCanal =".$input['grupoCanal_filtro'] : "";
			$filtros .= !empty($input['canal_filtro']) ? " AND cn.idCanal=".$input['canal_filtro'] : "";
			$filtros .= !empty($input['idCuenta']) ? " AND cu.idCuenta=".$input['idCuenta'] : "";
			$filtros .= !empty($input['idProyecto']) ? " AND p.idProyecto=".$input['idProyecto'] : "";

			if(!empty($input['clientes'])){
				
				$array=array(); $clientes=array(); $i=0;
				$array=explode("\r\n",($input['clientes']));
				$fl="";
				$array_res=array();
				if(is_array($array)){
					$fl=" AND ch.nombreComercial IN ('";

					foreach($array as $row){
						array_push($array_res,preg_replace("/\s+/u", " ", $row));
					}
					$string_=implode("','",$array_res);
					$fl=$fl.$string_."')";
				}else{
					$cl=trim($input['clientes']);
					$fl=" AND ch.nombreComercial IN ('". preg_replace("/\s+/u", " ", $cl) . "' )'";
				}
				$filtros .=$fl;
			}
			
		$sql = "DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		------
		SELECT 
			--TOP 100
			ch.idClienteHist
			, ch.idCliente
			, ISNULL(ch.razonSocial, c.razonSocial) AS razonSocial
			, ISNULL(ch.nombreComercial, c.nombreComercial) AS nombreComercial
			, ISNULL(ch.direccion, c.direccion) AS direccion
			, ISNULL(ch.codCliente, c.codCliente) AS codCliente
			, ISNULL(c.dni, c.dni) AS dni
			, ISNULL(c.ruc, c.ruc) AS ruc
			, CONVERT(VARCHAR,ch.fecIni,103) AS fecIni
			, CONVERT(VARCHAR,ch.fecFin,103) AS fecFin
			, cu.nombre AS cuenta
			, p.nombre AS proyecto
			, sg.idCanal
			, cn.nombre AS canal
			, ubi.cod_ubigeo
			, ubi.departamento
			, ubi.provincia
			, ubi.distrito
			, ctp.nombre AS clienteTipo
		FROM trade.cliente c 
		JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=c.idCliente
		LEFT JOIN trade.cuenta cu ON cu.idCuenta=ch.idCuenta
		LEFT JOIN trade.proyecto p ON p.idProyecto=ch.idProyecto
		LEFT JOIN trade.segmentacionNegocio sg ON sg.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sg.idCanal
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = cn.idGrupoCanal
		LEFT JOIN trade.cliente_tipo ctp ON sg.idClienteTipo = ctp.idClienteTipo
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ch.cod_ubigeo
		WHERE c.estado=1 
		{$filtros}
		--AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
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
		)
		ORDER BY ch.idClienteHist DESC";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
		
	}

	public function update_estado_basemadre($input=array()){
		$aSessTrack = [];

		$table = getClienteHistoricoCuenta();
		$where = array('idCliente'=>$input['idCliente'], 'idClienteHist'=>$input['idClienteHist']);
		$params['fecFin'] = $input['fecFin'];

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

	public function obtener_lista_basemadre(){
		$sql = "
		SELECT DISTINCT --TOP 1000
		c.idCliente,c.nombreComercial,c.razonSocial
		FROM trade.cliente c
		WHERE c.estado=1
		ORDER BY c.idCliente DESC";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_data_cliente($idCliente){
		$sql = "
		SELECT
		idCliente,nombreComercial,razonSocial,ruc,dni
		FROM trade.cliente
		WHERE estado=1 AND idCliente=$idCliente";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_listado_regiones(){
		$sql = "SELECT
			LTRIM(RTRIM(ubi.cod_ubigeo)) AS cod_ubigeo
			, LTRIM(RTRIM(ubi.cod_departamento)) AS cod_departamento, ubi.departamento
			, LTRIM(RTRIM(ubi.cod_provincia)) AS cod_provincia, ubi.provincia
			, LTRIM(RTRIM(ubi.cod_distrito)) AS cod_distrito, ubi.distrito
		FROM General.dbo.ubigeo ubi
		WHERE ubi.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.ubigeo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_listado_regiones_concatenado(){
		$sql = "SELECT
			LTRIM(RTRIM(ubi.cod_ubigeo)) AS cod_ubigeo
			, ubi.departamento+'-'+ubi.provincia+'-'+ubi.distrito AS departamentoProvinciaDistrito
		FROM General.dbo.ubigeo ubi
		WHERE ubi.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.ubigeo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_zona_peligrosa(){
		$sql = "
		SELECT zp.idZonaPeligrosa
			, UPPER(zp.descripcion) AS descripcion
			, zp.color
		FROM trade.zonaPeligrosa zp
		WHERE zp.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zonaPeligrosa' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cuenta_proyecto($input=array()){
		$filtros = "";
			$filtros .= !empty($input['listaCuentas']) ? " AND c.idCuenta IN (".$input['listaCuentas'].")":"";
			$filtros .= !empty($input['listaProyectos']) ? " AND p.idProyecto IN (".$input['listaProyectos'].")":"";

		$sql = "
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
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_grupocanal_canal_usuarioHistCanal($input=array()){
		$filtros = "";
			$filtros .= !empty($input['idUsuario']) ? " AND uh.idUsuario IN (".$input['idUsuario'].")":"";

		$sql = "DECLARE @fecha DATE=GETDATE();
		SELECT 
			cc.idCuenta
			, gc.idGrupoCanal, UPPER(gc.nombre) AS grupoCanal
			, cn.idCanal, UPPER(cn.nombre) AS canal
			, sbc.idSubCanal, UPPER(sbc.nombre) AS subCanal
			, ct.idClienteTipo, UPPER(ct.nombre) AS clienteTipo
		FROM trade.usuario_historico uh
		JOIN trade.usuario_historicoCanal uhc ON uhc.idUsuarioHist=uh.idUsuarioHist
		JOIN trade.canal cn ON cn.idCanal=uhc.idCanal
		JOIN trade.cuenta_canal cc ON cc.idCanal=cn.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal=cn.idGrupoCanal
		LEFT JOIN trade.subCanal sbc ON sbc.idCanal=cn.idCanal
		LEFT JOIN trade.cliente_tipo ct ON ct.idCanal=cn.idCanal
		WHERE uh.estado=1 AND uhc.estado=1 AND uh.idAplicacion IN (2)
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoCanal' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_grupo_canal(){ 
		$sql = "SELECT 
				idGrupoCanal,nombre 
			FROM 
				trade.grupoCanal gc
			WHERE 
				gc.estado=1";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_canal(){
		$sql="SELECT idCanal,idGrupoCanal,nombre FROM trade.canal WHERE estado=1";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_grupocanal_canal($input=array()){
		$filtros = "";
			$filtros .= !empty($input['listaCuentas']) ? " AND cc.idCuenta IN (".$input['listaCuentas'].")":"";

		$sql = "SELECT 
				cc.idCuenta
			, gc.idGrupoCanal, UPPER(gc.nombre) AS grupoCanal
			, cc.idCanal, UPPER(c.nombre) AS canal
			, sbc.idSubCanal, UPPER(sbc.nombre) AS subCanal
			, ct.idClienteTipo, UPPER(ct.nombre) AS clienteTipo
		FROM trade.cuenta_canal cc
		JOIN trade.canal c ON c.idCanal=cc.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal=c.idGrupoCanal
		LEFT JOIN trade.subCanal sbc ON sbc.idCanal=c.idCanal
		LEFT JOIN trade.cliente_tipo ct ON ct.idCanal=c.idCanal
		WHERE cc.estado=1 AND c.estado=1 AND gc.estado=1
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta_canal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_frecuencia(){
		$sql = "SELECT 
			f.idFrecuencia
			, UPPER(f.nombre) AS frecuencia
		FROM trade.frecuencia f
		WHERE f.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.frecuencia' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_zonas_usuarioHistZona($input=array()){
		$filtros = "";
			$filtros .= !empty($input['idUsuario']) ? " AND uh.idUsuario IN (".$input['idUsuario'].")":"";

		$sql = "DECLARE @fecha DATE=GETDATE();
		SELECT
			uhz.idZona
			, UPPER(z.nombre) AS zona
			, p.idCuenta, uh.idProyecto
		FROM trade.usuario_historico uh
		JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist=uh.idUsuarioHist
		JOIN trade.zona z ON z.idZona=uhz.idZona
		JOIN trade.proyecto p ON p.idProyecto=uh.idProyecto
		WHERE uh.estado=1 AND uhz.estado=1 AND uh.idAplicacion IN (2)
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoZona' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_zonas($input=array()){
		$filtros = "";
			$filtros .= !empty($input['listaCuentas']) ? " AND z.idCuenta IN (".$input['listaCuentas'].")":"";
			$filtros .= !empty($input['listaProyectos']) ? " AND z.idProyecto IN (".$input['listaProyectos'].")":"";

		$sql = "
		SELECT
			z.idZona
			, UPPER(z.nombre) AS zona
			, z.idCuenta, z.idProyecto
		FROM trade.zona z WHERE z.estado=1
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zona' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cadena_banner_usuarioHistBanner(){
		$filtros = "";
			$filtros .= !empty($input['idUsuario']) ? " AND uh.idUsuario IN (".$input['idUsuario'].")":"";

		$sql = "DECLARE @fecha DATE=GETDATE();
		------
		SELECT 
			cd.idCadena
			, UPPER(cd.nombre) AS cadena
			, bn.idBanner
			, UPPER(bn.nombre) AS banner
		FROM trade.usuario_historico uh
		JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist=uh.idUsuarioHist
		JOIN trade.banner bn ON bn.idBanner=uhb.idBanner
		JOIN trade.cadena cd ON cd.idCadena=bn.idCadena
		WHERE uh.estado=1 AND uhb.estado=1 AND uh.idAplicacion IN (2)
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoBanner' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cadena_banner(){
		$sql = "SELECT 
			c.idCadena
			, UPPER(c.nombre) AS cadena
			, b.idBanner
			, UPPER(b.nombre) AS banner
		FROM trade.cadena c
		JOIN trade.banner b ON b.idCadena=c.idCadena
		WHERE c.estado=1 AND b.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.banner' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_plazas_todos_usuarioHistPlaza($input){
		$filtros = "";
			$filtros .= !empty($input['idUsuario']) ? " AND uh.idUsuario IN (".$input['idUsuario'].")":"";

		$sql = "DECLARE @fecha DATE=GETDATE();
		----
		SELECT 
			uhp.idPlaza
			,p.nombre AS plaza
		FROM trade.usuario_historico uh 
		JOIN trade.usuario_historicoPlaza uhp ON uhp.idUsuarioHist=uh.idUsuarioHist
		JOIN trade.plaza p ON p.idPlaza=uhp.idPlaza
		WHERE uh.estado=1 AND uhp.estado=1 AND uh.idAplicacion IN (2)
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		{$filtros}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoPlaza' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_plazas_todos(){
		$sql = "
		SELECT
			p.idPlaza,p.nombre AS plaza
		FROM trade.plaza p
		WHERE p.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.plaza' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_plazas_mayoristas(){
		$sql = "
		SELECT idPlaza, nombreMayorista AS plaza 
		FROM trade.plaza WHERE flagMayorista = 1 AND estado = 1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.plaza' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_distribuidora_sucursal_usuarioHistDS($input=array()){
		$filtros = "";
			$filtros .= !empty($input['idUsuario']) ? " AND uh.idUsuario IN (".$input['idUsuario'].")":"";

		$sql = "DECLARE @fecha DATE=GETDATE();
		----
		SELECT
			uh.idProyecto
			, uhds.idDistribuidoraSucursal
			, d.idDistribuidora
			, ds.cod_ubigeo
			, d.nombre+' - '+ ubi.distrito AS distribuidoraSucursal
		FROM trade.usuario_historico uh
		JOIN trade.usuario_historicoDistribuidoraSucursal uhds ON uhds.idUsuarioHist=uh.idUsuarioHist
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=uhds.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		WHERE uh.estado=1 AND uhds.estado=1 AND uh.idAplicacion IN (2)
		AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
		{$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoDistribuidoraSucursal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_distribuidora_sucursal(){
		$sql = "SELECT
			ds.idDistribuidoraSucursal
			, d.idDistribuidora
			, ds.cod_ubigeo
			, d.nombre+' - '+ ubi.distrito AS distribuidoraSucursal
		FROM trade.distribuidoraSucursal ds
		JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		WHERE ds.estado=1 AND d.estado=1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.distribuidoraSucursal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_verificacion_existente($input=array()){

		$query = $this->db->select('idCliente')
				->where( $input )
				->get('trade.cliente');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $query->result_array();
	}

	public function obtener_verificacion_existente_historico($input=array()){
		$query= $this->db->select('idCliente')
				->where( $input )
				->where( 'fecIni <=', DATE('d/m/Y') )
				->where( "ISNULL(fecFin,'".DATE('d/m/Y')."') >= ", DATE('d/m/Y') )
				->get( getClienteHistoricoCuenta() );

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $query->result_array();
	}

	public function obtener_verificacion_posibles_existentes($input=array()){
		$sql = "
		DECLARE @fecha DATE=GETDATE();
		SELECT c.idCliente,c.nombreComercial,c.razonSocial,c.direccion, c.dni,c.ruc 
		, ch.idCuenta, cu.nombre AS cuenta
		, ch.idProyecto, py.nombre AS proyecto
		, sg.idCanal
		, cn.nombre AS canal
		FROM trade.cliente c
		LEFT JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=c.idCliente
		LEFT JOIN trade.cuenta cu ON cu.idCuenta=ch.idCuenta
		LEFT JOIN trade.proyecto py ON py.idProyecto=ch.idProyecto
		LEFT JOIN trade.segmentacionNegocio sg ON sg.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sg.idCanal
		WHERE @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
		AND c.nombreComercial LIKE '%".$input['nombreComercial']."%'
		AND c.razonSocial LIKE '%".$input['razonSocial']."%'
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' =>  getClienteHistoricoCuenta() ];
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
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function obtener_segmentacion_negocio($input=array()){
		$query = $this->db->select('idSegNegocio')
				->where( $input )
				->get('trade.segmentacionNegocio');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio' ];
		return $query->result_array();
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
			$this->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	public function obtener_segmentacion_cliente_tradicional($where){
		$sql = "
			SELECT sct.idSegClienteTradicional
			FROM trade.segmentacionClienteTradicional sct
			LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional
			WHERE 1=1 {$where}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionClienteTradicional' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_segmentacion_cliente_tradicional_v2($where){
		$sql = "
		SELECT * 
		FROM (
			SELECT
				idSegClienteTradicional,
				idPlaza,
				(
					SELECT STUFF((
						SELECT
							',' + CONVERT(VARCHAR, idDistribuidoraSucursal)
						FROM trade.segmentacionClienteTradicionalDet
						WHERE idSegClienteTradicional = sct.idSegClienteTradicional
						ORDER BY idDistribuidoraSucursal
						FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 1, '')
				) AS idDistribuidoraSucursal
			FROM trade.segmentacionClienteTradicional sct
		) as data
		WHERE 1=1 {$where}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionClienteTradicional' ];
		return $this->db->query($sql)->result_array();
	}

	public function insert_segmentacion_cliente_tradicional($idPlaza){
		$aSessTrack = [];

		$table = 'trade.segmentacionClienteTradicional';
		$this->db->trans_begin();
			$insert = $this->db->insert($table, array('idPlaza'=>$idPlaza));
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
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
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
			$this->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function obtener_segmentacion_cliente_moderno($idBanner){
		$query = $this->db->select('idSegClienteModerno')
				->where( array('idBanner'=>$idBanner) )
				->get('trade.segmentacionClienteModerno');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionClienteModerno' ];
		return $query->result_array();
	}

	public function insertar_cliente_historico($input=array()){
		$aSessTrack = [];

		$table = getClienteHistoricoCuenta();
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

	public function obtener_cliente_historico($input=array()){
		$sql = "
		DECLARE @idClienteHist INT=".$input['idClienteHist'].";
		SELECT
			ch.idClienteHist
			, ch.idCliente
			, ch.razonSocial
			, ch.nombreComercial
			, c.ruc
			, c.dni
			, cn.idGrupoCanal
			, sn.idCanal
			, sn.idClienteTipo
			, ch.idSegNegocio
			, ch.idSegClienteTradicional
			, sct.idPlaza
			, sctd.idDistribuidoraSucursal
			, d.nombre+' - '+ubi2.distrito AS distribuidoraSucursal
			, ch.idSegClienteModerno
			, bn.idCadena
			, scm.idBanner
			, ch.fecIni
			, ch.fecFin
			, ch.idFrecuencia
			, ch.idCuenta
			, ch.idProyecto
			, ch.idZona
			, ch.flagCartera
			, ch.codCliente
			, LTRIM(RTRIM(ubi.cod_departamento)) AS cod_departamento
			, ubi.departamento
			, LTRIM(RTRIM(ubi.cod_provincia)) AS cod_provincia
			, ubi.provincia
			, LTRIM(RTRIM(ubi.cod_distrito)) AS cod_distrito
			, ubi.distrito
			, ch.cod_ubigeo
			, ch.direccion
			, ch.referencia
			, ch.latitud
			, ch.longitud
			, ch.idZonaPeligrosa
			, cu.nombre AS cuenta
			, p.nombre AS proyecto
		FROM ".getClienteHistoricoCuenta()." ch
		JOIN trade.cliente c ON c.idCliente=ch.idCliente
		LEFT JOIN trade.cuenta cu ON cu.idCuenta=ch.idCuenta 
		LEFT JOIN trade.proyecto p ON p.idProyecto=ch.idProyecto 
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ch.cod_ubigeo
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sn.idCanal
		LEFT JOIN trade.segmentacionClienteTradicional sct ON sct.idSegClienteTradicional=ch.idSegClienteTradicional 
		LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sctd.idSegClienteTradicional=sct.idSegClienteTradicional
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=sctd.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d On d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi2 ON ubi2.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno=ch.idSegClienteModerno
		LEFT JOIN trade.banner bn ON bn.idBanner=scm.idBanner
		WHERE ch.idClienteHist=@idClienteHist";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $this->db->query($sql)->result_array();
	}

	public function update_cliente_historico($input=array()){
		$aSessTrack = [];

		$table = getClienteHistoricoCuenta();
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

	public function update_cliente_historico_proyectos($input=array()){
		$aSessTrack = [];

		$table = getClienteHistoricoCuenta();
		$params = $input['arrayParams'];
		$idClienteHist = $input['idClienteHist'];

		$this->db->trans_begin();
			$this->db->where_in('idClienteHist', $idClienteHist);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($idClienteHist) ];

				
		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		return $update;
	}

	public function update_cliente($input=array()){
		$aSessTrack = [];

		$table = 'trade.cliente';
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

	public function obtener_id_zona_peligrosa($zonaPeligrosa){
		$sql = "SELECT idZonaPeligrosa FROM trade.zonaPeligrosa WHERE descripcion LIKE '{$zonaPeligrosa}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zonaPeligrosa' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_canal($canal){
		$sql = "SELECT c.idCanal FROM trade.canal c WHERE c.nombre LIKE '{$canal}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_subCanal($subCanal){
		$sql = "SELECT sb.idSubCanal FROM trade.subCanal sb WHERE sb.nombre LIKE '{$subCanal}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.subCanal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_clienteTipo($clienteTipo){
		$sql = "SELECT ct.idClienteTipo FROM trade.cliente_tipo ct WHERE ct.nombre LIKE'{$clienteTipo}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente_tipo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_segmentacion_negocio($canal){
		$sql = "SELECT sn.idSegNegocio
			FROM trade.segmentacionNegocio sn
			JOIN trade.canal c ON c.idCanal=sn.idCanal
			WHERE c.nombre LIKE '{$canal}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_segmentacion_cliente_moderno($banner){
		$sql = "
			SELECT
				scm.idSegClienteModerno
			FROM trade.segmentacionClienteModerno scm
			JOIN trade.banner bn ON bn.idBanner=scm.idBanner
			WHERE bn.nombre LIKE '{$banner}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionClienteModerno' ];
		return $this->db->query($sql)->result_array();
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
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionClienteTradicional' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_plaza_todo($plaza){
		$sql = "
		SELECT p.idPlaza, p.nombre AS plaza
		FROM trade.plaza p WHERE p.estado=1
		AND p.nombre LIKE '{$plaza}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.plaza' ];
		return $this->db->query($sql)->result_array();	
	}

	public function obtener_id_plaza_mayorista($plaza){
		$sql = "
		SELECT
			pl.idPlaza, pl.nombreMayorista AS plaza, pl.flagMayorista
		FROM trade.plaza pl WHERE pl.estado=1 AND pl.flagMayorista=1
		AND pl.nombreMayorista LIKE '{$plaza}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.plaza' ];
		return $this->db->query($sql)->result_array();
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

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.distribuidoraSucursal' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_frecuencia($frecuencia){
		$sql = "SELECT idFrecuencia FROM trade.frecuencia WHERE nombre LIKE '{$frecuencia}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.frecuencia' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_cuenta($cuenta){
		$sql = "SELECT idCuenta FROM trade.cuenta WHERE nombreComercial LIKE '{$cuenta}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_proyecto($proyecto, $idCuenta){
		$sql = "SELECT idProyecto FROM trade.proyecto WHERE idCuenta={$idCuenta} AND nombre LIKE '{$proyecto}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_id_zona($zona){
		$sql = "SELECT idZona FROM trade.zona WHERE nombre LIKE '{$zona}'";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zona' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_verificacion_existente_pg_v1($input=array()){
		$query = $this->db->select('idClientePg')
			->where( $input )
			->get("{$this->sessBDCuenta}.trade.cliente_pg_v1");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.cliente_pg_v1" ];
		return $query->result_array();
	}

	public function obtener_verificacion_existente_historico_pg_v1($input=array()){
		$query= $this->db->select('idClientePg')
			->where( $input )
			->where( 'fecIni <=', DATE('d/m/Y') )
			->where( "ISNULL(fecFin,'".DATE('d/m/Y')."') >= ", DATE('d/m/Y') )
			->get( "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1" );

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1" ];
		return $query->result_array();
	}

	public function insertar_cliente_pg_v1($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_v1";
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

	public function insertar_cliente_historico_v1($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1";
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

	public function obtener_maestros_basemadre_agregados($input=array()){
		$filtros = "";
			$filtros .= !empty($input['idSolicitudTipo']) ? " AND ch.idSolicitudTipo=".$input['idSolicitudTipo'] : "";
			$filtros .= !empty($input['idUsuarioSolicitud']) ? " AND ch.idUsuarioSolicitud=".$input['idUsuarioSolicitud'] : "";
			//$filtros .= !empty($input['idCuenta']) ? " AND cu.idCuenta=".$input['idCuenta'] : "";
			//$filtros .= !empty($input['idProyecto']) ? " AND py.idProyecto=".$input['idProyecto'] : "";
			
			if(!empty($input['clientes'])){
				
				$array=array(); $clientes=array(); $i=0;
				$array=explode("\r\n",($input['clientes']));
				$fl="";
				$array_res=array();
				if(is_array($array)){
					$fl=" AND ch.nombreComercial IN ('";

					foreach($array as $row){
						array_push($array_res,preg_replace("/\s+/u", " ", $row));
					}
					$string_=implode("','",$array_res);
					$fl=$fl.$string_."')";
				}else{
					$cl=trim($input['clientes']);
					$fl=" AND ch.nombreComercial IN ('". preg_replace("/\s+/u", " ", $cl) . "' )'";
				}
				$filtros .=$fl;
			}

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		----
		SELECT
			ch.idClienteHistPg
			, ch.idClientePg
			, ch.nombreComercial
			, ch.razonSocial
			, c.ruc, c.dni
			, ch.idSegNegocio, gc.nombre AS grupoCanal, cn.nombre AS canal
			, ch.idSegClienteTradicional
			, sct.idPlaza, pl.nombre AS plaza
			, sctd.idDistribuidoraSucursal
			, ds.idDistribuidora, ds.cod_ubigeo
			, d.nombre+' - '+ubi_ds.distrito AS distribuidoraSucursal
			, ch.idSegClienteModerno, cd.nombre AS cadena, bn.nombre AS banner
			, CONVERT(VARCHAR,ch.fecIni,103) AS fecIni
			, CONVERT(VARCHAR,ch.fecFin,103) AS fecFin
			, ch.idCuenta, cu.nombre AS cuenta
			, ch.idProyecto, py.nombre AS proyecto
			, ch.idFrecuencia, fr.nombre AS frecuencia
			, ch.idZona, zn.nombre AS zona
			, ch.idZonaPeligrosa, zp.descripcion AS zonaPeligrosa
			, ch.flagCartera
			, ch.codCliente
			, ch.cod_ubigeo
			, ubi.departamento, ubi.provincia, ubi.distrito
			, ch.direccion
			, ch.referencia
			, ch.idUsuarioSolicitud
			, us.apePaterno+' '+us.apeMaterno+' '+us.nombres AS usuarioSolicitud
			, ch.idSolicitudTipo, sot.nombre AS solicitudTipo
			, ch.flagTransferido
			, ch.observacionRechazo
			, ctp.nombre AS clienteTipo
		FROM {$this->sessBDCuenta}.trade.cliente_pg_historico_v1 ch
		JOIN {$this->sessBDCuenta}.trade.cliente_pg_v1 c ON c.idClientePg=ch.idClientePg
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ch.cod_ubigeo
		LEFT JOIN trade.zonaPeligrosa zp ON zp.idZonaPeligrosa=ch.idZonaPeligrosa
		LEFT JOIN trade.cuenta cu ON ch.idCuenta=cu.idCuenta
		LEFT JOIN trade.proyecto py ON py.idProyecto=ch.idProyecto
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sn.idCanal
		LEFT JOIN trade.cliente_Tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo
		LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=cn.idGrupoCanal
		LEFT JOIN trade.frecuencia fr ON fr.idFrecuencia=ch.idFrecuencia
		LEFT JOIN trade.zona zn ON zn.idZona=ch.idZona
		LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno=ch.idSegClienteModerno
		LEFT JOIN trade.banner bn ON bn.idBanner=scm.idBanner
		LEFT JOIN trade.cadena cd ON cd.idCadena=bn.idCadena
		LEFT JOIN trade.segmentacionClienteTradicional sct ON sct.idSegClienteTradicional=ch.idSegClienteTradicional
		LEFT JOIN trade.plaza pl ON pl.idPlaza=sct.idPlaza
		LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sctd.idSegClienteTradicional=sct.idSegClienteTradicional
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=sctd.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi_ds ON ubi_ds.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.usuario us ON us.idUsuario=ch.idUsuarioSolicitud
		LEFT JOIN trade.solicitudes_tipo sot ON sot.idSolicitudTipo=ch.idSolicitudTipo
		WHERE ch.estado=1 
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
		)
		{$filtros}
		ORDER BY ch.idClienteHistPg DESC ";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.cliente_pg_v1" ];
		return $this->db->query($sql)->result_array();
	}

	public function update_estado_basemadre_pg_v1($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1";
		$where = array('idClientePg'=>$input['idClientePg'], 'idClienteHistPg'=>$input['idClienteHistPg']);
		$params['fecFin'] = $input['fecFin'];

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

	public function obtener_cliente_historico_v1($input=array()){
		$sql = "
		DECLARE @idClienteHistPg INT=".$input['idClienteHistPg'].";
		SELECT
			ch.idClienteHistPg AS idClienteHist
			, ch.idClientePg AS idCliente
			, ch.razonSocial
			, ch.nombreComercial
			, c.ruc
			, c.dni
			, ch.idSegNegocio, cn.idGrupoCanal
			, sn.idCanal
			, sn.idClienteTipo
			, ch.idSegClienteTradicional
			, sct.idPlaza, sctd.idDistribuidoraSucursal
			, d.nombre+' - '+ubi2.distrito AS distribuidoraSucursal
			, ch.idSegClienteModerno
			, bn.idCadena, scm.idBanner
			, ch.fecIni
			, ch.fecFin
			, ch.idFrecuencia
			, ch.idCuenta
			, ch.idProyecto
			, ch.idZona
			, ch.flagCartera
			, ch.codCliente
			, LTRIM(RTRIM(ubi.cod_departamento)) AS cod_departamento
			, ubi.departamento
			, LTRIM(RTRIM(ubi.cod_provincia)) AS cod_provincia
			, ubi.provincia
			, LTRIM(RTRIM(ubi.cod_distrito)) AS cod_distrito
			, ubi.distrito
			, ch.cod_ubigeo
			, ch.direccion
			, ch.referencia
			, ch.latitud
			, ch.longitud
			, ch.idZonaPeligrosa
			, cu.nombre AS cuenta
			, p.nombre AS proyecto
		FROM {$this->sessBDCuenta}.trade.cliente_pg_historico_v1 ch
		JOIN {$this->sessBDCuenta}.trade.cliente_pg_v1 c ON c.idClientePg=ch.idClientePg
		LEFT JOIN trade.cuenta cu ON cu.idCuenta=ch.idCuenta 
		LEFT JOIN trade.proyecto p ON p.idProyecto=ch.idProyecto 
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ch.cod_ubigeo
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sn.idCanal
		LEFT JOIN trade.segmentacionClienteTradicional sct ON sct.idSegClienteTradicional=ch.idSegClienteTradicional 
		LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sctd.idSegClienteTradicional=sct.idSegClienteTradicional
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=sctd.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d On d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi2 ON ubi2.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno=ch.idSegClienteModerno
		LEFT JOIN trade.banner bn ON bn.idBanner=scm.idBanner
		WHERE ch.idClienteHistPg=@idClienteHistPg";


		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'cliente_pg_historico_v1' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_cliente_historico_v1($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1";
		$params = $input['arrayParams'];
		$where = $input['arrayWhere'];

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => $where['idClienteHistPg'] ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function obtener_tranferir_cliente_pg_v1($input=array()){
		$sql = "
		DECLARE @idCliente INT=".$input['idClientePg'].";
		---
		SELECT
			c.nombreComercial
			, c.razonSocial
			, c.ruc
			, c.dni
		FROM {$this->sessBDCuenta}.trade.cliente_pg_v1 c
		WHERE c.estado=1
			AND c.idClientePg=@idCliente";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'cliente_pg_v1' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tranferir_cliente_historico_v1($input=array()){
		$sql = "
		DECLARE @idClienteHist INT=".$input['idClienteHistPg'].";
		---
		SELECT
			ch.nombreComercial
			, ch.razonSocial
			, ch.idSegNegocio
			, ch.idSegClienteTradicional
			, ch.idSegClienteModerno
			, ch.fecIni
			, ch.fecFin
			, ch.idCuenta
			, ch.idProyecto
			, ch.idFrecuencia
			, ch.idZona
			, ch.idZonaPeligrosa
			, ch.flagCartera
			, ch.codCliente
			, ch.cod_ubigeo
			, ch.direccion
			, ch.referencia
			, ch.latitud
			, ch.longitud
		FROM {$this->sessBDCuenta}.trade.cliente_pg_historico_v1 ch
		WHERE ch.estado=1
			AND ch.idClienteHistPg=@idClienteHist";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'cliente_pg_historico_v1' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_cliente_historico_transferir($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1";
		$where = array('idClientePg'=>$input['idClientePg'], 'idClienteHistPg'=>$input['idClienteHistPg']);
		$params['flagTransferido'] = 1;
		$params['idSolicitudTipo'] = 2;

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

	public function obtener_maestros_deBaja($input=array()){
		$filtros = "";
			$filtros .= !empty($input['cuenta_filtro']) ? " AND cu.idCuenta=".$input['cuenta_filtro'] : "";
			$filtros .= !empty($input['proyecto_filtro']) ? " AND p.idProyecto=".$input['proyecto_filtro'] : "";
			$filtros .= !empty($input['canal_filtro']) ? " AND cn.idCanal=".$input['canal_filtro'] : "";

		$sql = "DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		------
		SELECT 
			--TOP 100
			ch.idClienteHist
			, ch.idCliente
			, ISNULL(ch.razonSocial, c.razonSocial) AS razonSocial
			, ISNULL(ch.nombreComercial, c.nombreComercial) AS nombreComercial
			, ISNULL(ch.direccion, c.direccion) AS direccion
			,  ch.codCliente AS codCliente
			, c.dni
			, c.ruc
			, CONVERT(VARCHAR,ch.fecIni,103) AS fecIni
			, CONVERT(VARCHAR,ch.fecFin,103) AS fecFin
			, cu.nombre AS cuenta
			, p.nombre AS proyecto
			, sg.idCanal
			, cn.nombre AS canal
			, ubi.cod_ubigeo
			, ubi.departamento
			, ubi.provincia
			, ubi.distrito
		FROM trade.cliente c 
		JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=c.idCliente
		LEFT JOIN trade.cuenta cu ON cu.idCuenta=ch.idCuenta
		LEFT JOIN trade.proyecto p ON p.idProyecto=ch.idProyecto
		LEFT JOIN trade.segmentacionNegocio sg ON sg.idSegNegocio=ch.idSegNegocio
		LEFT JOIN trade.canal cn ON cn.idCanal=sg.idCanal
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ch.cod_ubigeo
		WHERE c.estado=1 
		AND ch.estado=1
		{$filtros}
		AND ch.fecIni IS NOT NULL
		AND ch.fecFin IS NOT NULL
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
		)
		ORDER BY ch.idClienteHist DESC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function update_rechazo_basemadre_pg_v1($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1";
		$where = array('idClientePg'=>$input['idClientePg'], 'idClienteHistPg'=>$input['idClienteHistPg']);
		$params['observacionRechazo'] = $input['observacionRechazo'];
		$params['idSolicitudTipo'] = $input['idSolicitudTipo'];

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

	public function obtener_motivo_rechazo($input=array()){
		$query = $this->db->select('observacionRechazo')
				->where( $input )
				->get("{$this->sessBDCuenta}.trade.cliente_pg_historico_v1");

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1" ];
		return $query->result_array();
	}

	public function update_cliente_historico_rechazar($where=array(), $params=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.cliente_pg_historico_v1";

		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params );

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => $where['idClienteHistPg'] ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function obtener_correo_aprobar_solicitudes(){
		$query = $this->db->select('correo')
				->where( array('estado'=>1) )
				->get('trade.solicitudes_registro_correo');

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.solicitudes_registro_correo' ];
		return $query->result_array();
	}

	public function obtener_segmentacion_cliente($idUsuario){
		$sql = "SELECT 
		usc.flagClienteTradicional
		, usc.flagClienteModerno
		, usc.flagClienteMayorista
		FROM trade.usuario_segmentacionCliente usc
		WHERE usc.estado=1 AND usc.idUsuario={$idUsuario}
		ORDER BY usc.idUsuarioSegCliente DESC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_segmentacionCliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_listado_solicitudesTipo(){
		$sql = "SELECT st.idSolicitudTipo, st.nombre AS solicitudTipo
		FROM trade.solicitudes_tipo st
		WHERE st.estado=1";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.solicitudes_tipo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cliente_historico_vigente($input=array(),$inputProyectos=array()){
		$query= $this->db->select('idClienteHist,convert(varchar,fecIni,103) fecIni')
				->where( $input )
				->where( 'fecIni <=', DATE('d/m/Y') )
				->where( "ISNULL(fecFin,'".DATE('d/m/Y')."') >= ", DATE('d/m/Y') )
				->where_in('idProyecto', $inputProyectos)
				->get( getClienteHistoricoCuenta() );
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		
		return $query->result_array();
	}

	public function obtener_cliente_historico_por_fecha($input=array(),$inputProyectos=array()){
		$proyectos= implode(",",$inputProyectos);
		$fecFin= ( ($input['fecFin']!='' && !empty($input['fecFin']) )? "'".($input['fecFin'])."'" : "null" );
		
		$filtros = "";
		$sql = "
			DECLARE @fecIni DATE='".($input['fecIni'])."';
			DECLARE @fecFin DATE=ISNULL(".$fecFin.",@fecIni);

			SELECT idClienteHist,convert(varchar,fecIni,103) fecIni
			FROM ".getClienteHistoricoCuenta()."
			WHERE General.dbo.fn_fechaVigente(fecIni,fecFin,@fecIni,@fecFin)=1
			AND idProyecto IN (".$proyectos.")
			AND idCliente=".$input['idCliente']."
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_cliente_historico_ultimo($input=array()){
		$filtros = "";
		$sql = "
			DECLARE @fecha DATE= GETDATE();
			SELECT 
			TOP 1
			idClienteHist,idCliente,nombreComercial,razonSocial,
			idSegNegocio,idSegClienteTradicional,idSegClienteModerno,
			fecIni,fecFin,idCuenta,idProyecto,idFrecuencia,idZona,idZonaPeligrosa,
			flagCartera,codCliente,cod_ubigeo,direccion,referencia,latitud,longitud,estado
			FROM ".getClienteHistoricoCuenta()."
			WHERE idCliente=".$input['idCliente']."
			AND idProyecto=".$input['idProyecto']."
			ORDER BY idClienteHist desc
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $this->db->query($sql)->result_array();
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
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.ubigeo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_estado_carga_alternativa($idCarga=null){
		$idCuenta=$this->session->userdata('idCuenta');
		$filtros="";
		if($idCarga!=null){
			$filtros=" AND cm.idCarga=".$idCarga." ";
		}
		$filtros.=" AND cm.idCuenta=".$idCuenta." ";
		$sql ="  
			SELECT 
					*
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				,(
					SELECT count(*) FROM {$this->sessBDCuenta}.trade.cargaClienteClientesNoProcesados WHERE idCarga=cm.idCarga
				) error
			FROM 
				{$this->sessBDCuenta}.trade.cargaCliente cm
			 WHERE 1=1 ".$filtros."
			 ORDER BY cm.idCarga DESC
			 ";
		return $this->db->query($sql)->result_array();
	}

	////ERRORES
	public function obtener_clientes_no_procesado($id){
		$sql="SELECT * FROM {$this->sessBDCuenta}.trade.cargaClienteClientesNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}






	public function obtener_estado_carga_alternativa_cliente_proyecto($idCarga=null){
		$filtros="";
		if($filtros!=null){
			$filtros=" AND cm.idCarga=".$idCarga."' ";
		}
		$sql ="  
			SELECT 
					*
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				,(
					SELECT count(*) FROM trade.cargaClienteProyectoNoProcesados WHERE idCarga=cm.idCarga
				) error
			FROM 
				trade.cargaClienteProyecto cm
			 WHERE 1=1 ".$filtros."
			 ORDER BY cm.idCarga DESC
			 ";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_clientes_proyecto_no_procesado($id){
		$sql="SELECT * FROM trade.cargaClienteProyectoNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}

	public function validar_proyecto_auditoria( $input = [] ){
		$aProyectos = [];
		if( !empty($input['idProyecto']) ){
			$sql = "
				SELECT pya.idProyecto
				FROM trade.proyecto pya
				WHERE pya.idProyectoGeneral <> 2
				AND pya.idProyecto =  {$input['idProyecto']}
			";
			$aProyectos = $this->db->query($sql)->result_array();
		}

		return $aProyectos;
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

	public function actualizar_visitas($input=array()){
		$clientes= implode(",",$input);
		$sql = "
			DECLARE @fecha date=GETDATE();
			UPDATE {$this->sessBDCuenta}.trade.data_visita
			SET estado=estado
			WHERE idVisita IN (
			SELECT idVisita FROM {$this->sessBDCuenta}.trade.data_visita v 
			JOIN {$this->sessBDCuenta}.trade.data_ruta r ON r.fecha>=@fecha AND v.idRuta=r.idRuta
			AND v.idCliente IN (".$clientes.")
			)
			;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'data_visita' ];
		return $this->db->query($sql)->result_array();
	}


	public function validar_cliente_historico_por_fecha($input=array(),$inputProyectos=array()){
		$proyectos= implode(",",$inputProyectos);
		
		$filtros = "";
		$sql = "
			SELECT idClienteHist,convert(varchar,fecIni,103) fecIni
			FROM ".getClienteHistoricoCuenta()."
			WHERE  
			  idProyecto IN (".$proyectos.")
			AND idCliente=".$input['idCliente']."
			AND fecFin IS NULL;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $this->db->query($sql)->result_array();
	}

	public function validar_cliente_historico_fechaFin($input=array(),$inputProyectos=array()){
		$proyectos= implode(",",$inputProyectos);
		
		$filtros = "";
		$sql = "
			DECLARE @fecha date=GETDATE();
			DECLARE @fechaFin date='".$input['fechaFin']."';
			SELECT idClienteHist,convert(varchar,fecIni,103) fecIni,fecFin
			FROM ".getClienteHistoricoCuenta()."
			WHERE  
				idProyecto IN (".$proyectos.")
			AND idCliente=".$input['idCliente']."
			and @fecha between fecIni and ISNULL(fecFin,@fecha)
			AND @fechaFin <fecIni;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => getClienteHistoricoCuenta() ];
		return $this->db->query($sql)->result_array();
	}

	

}
?>