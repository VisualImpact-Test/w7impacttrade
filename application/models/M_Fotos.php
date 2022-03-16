<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Fotos extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getTipoFotos($params)
	{
		$filtro = '';
		$idCuenta = $this->sessIdCuenta;
		$idProyecto = $this->sessIdProyecto;
			
		$filtro .= ' AND py.idProyecto='.$idProyecto;
		$filtro .= ' AND cu.idCuenta='.$idCuenta;
		
		!empty($params['idGrupoCanal']) ? $filtro .= " AND ft.idGrupoCanal = {$params['idGrupoCanal']}"  : '';

		$sql = "
		select 
			ft.idTipoFoto
			, UPPER(ft.nombre) nombre
		from 
			trade.foto_tipo ft
			JOIN trade.proyecto py
				ON py.idProyecto= ft.idProyecto
			JOIN trade.cuenta cu
				ON py.idCuenta = cu.idCuenta
		WHERE 
			1=1
			AND ft.estado=1
			{$filtro}
		";

		return $this->db->query($sql);
	}

	public function getFotos($input,$visitas){
		$fechas = getFechasDRP($input['txt-fechas']);

		$filtros = '';

			$input['idCuenta'] = $this->sessIdCuenta;
			$input['idProyecto'] = $this->sessIdProyecto;

			if(!empty($input['tipoFoto']) ) $filtros .= " AND mf.idTipoFoto = ".$input['tipoFoto'];

			

			$filtros .= !empty($input['idCuenta']) ? ' AND cu.idCuenta = '.$input['idCuenta'] : '';
			$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? " AND gc.idGrupoCanal=".$input['grupoCanal_filtro'] : "";
			$filtros .= !empty($input['canal_filtro']) ? " AND ca.idCanal=".$input['canal_filtro'] : "";

			$filtros .= !empty($input['codCliente']) ? " AND ch.codCliente='".$input['codCliente']."'" : "";
			$filtros .= !empty($input['codVisual']) ? " AND v.idCliente='".$input['codVisual']."'" : "";

			$filtros .= !empty($input['tipoUsuario_filtro']) ? " AND uh.idTipoUsuario=".$input['tipoUsuario_filtro'] : "";
			$filtros .= !empty($input['usuario_filtro']) ? " AND uh.idUsuario=".$input['usuario_filtro'] : "";

			$filtros .= !empty($input['tipoFoto']) ? " AND tf.idTipoFoto=".$input['tipoFoto'] : "";
			$filtros .= !empty($input['idClienteTipo']) ? " AND sn.idClienteTipo=".$input['idClienteTipo'] : "";

			$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
			$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
			$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
			$filtros .= !empty($input['plaza_filtro']) ? ' AND ds.idPlaza='.$input['plaza_filtro'] : '';
			$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
			$filtros .= !empty($input['banner_filtro']) ? ' AND b.idBanner='.$input['banner_filtro'] : '';
			$filtros .= !empty($input['tipoModulo']) ? ' AND mg.idModuloGrupo='.$input['tipoModulo'] : '';
			
			$visitas_filtro = !empty($visitas)?$visitas:'';

			$segmentacion = getSegmentacion($input);

		$sql="
			DECLARE @fecIni DATE='".$fechas[0]."',@fecFin DATE='".$fechas[1]."';
			SELECT DISTINCT
				v.idVisita, 
				ubi01.departamento, 
				ubi01.provincia, 
				ubi01.distrito, 
				v.idCliente, 
				ch.codCliente, 
				v.razonSocial, 
				v.direccion, 
				CONVERT(VARCHAR, r.fecha, 103) fecha, 
				r.idUsuario, 
				r.nombreUsuario usuario, 
				v.canal, 
				gc.nombre grupoCanal,
				UPPER(r.tipoUsuario) tipoUsuario, 
				vf.idVisitaFoto, 
				ISNULL(tf.nombre,m.nombre) tipoFoto, 
				vf.fotoUrl imgRef, 
				CONVERT(VARCHAR(8), vf.hora) horaFoto, 
				CONVERT(VARCHAR(8), v.horaIni) horaVisita,
				ct.idClienteTipo,
				ISNULL(ct.nombre,'-') AS cliente_tipo,
				mg.carpetaFoto,
				m.nombre modulo
				{$segmentacion['columnas_bd']}
			FROM 
			{$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v 
				ON r.idRuta = v.idRuta 
				AND v.numFotos>0 
				AND r.demo = 0
				AND r.fecha BETWEEN @fecIni AND @fecFin
				AND v.estado=1
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf 
				ON vf.idVisita = v.idVisita
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModuloFotos mf 
				ON mf.idVisitaFoto = vf.idVisitaFoto
			JOIN trade.aplicacion_modulo m 
				ON m.idModulo = vf.idModulo
			JOIN trade.aplicacion_modulo_grupo mg 
				ON mg.idModuloGrupo = m.idModuloGrupo
			LEFT JOIN trade.foto_tipo tf 
				ON tf.idTipoFoto = mf.idTipoFoto			
			JOIN trade.canal ca 
				ON ca.idCanal = v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal = gc.idGrupoCanal
			/* JOIN trade.usuario u 
				ON u.idUsuario = r.idUsuario
			JOIN trade.usuario_historico uh 
				ON uh.idUsuario = U.idUsuario
				AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				AND uh.idProyecto=r.idProyecto */
			JOIN trade.usuario_tipo ut 
				ON ut.idTipoUsuario = r.idTipoUsuario
			JOIN trade.proyecto py 
				ON py.idProyecto = r.idProyecto
			JOIN trade.cuenta cu 
				ON cu.idCuenta = r.idCuenta
			LEFT JOIN trade.banner bn 
				ON bn.idBanner = v.idBanner
			LEFT JOIN trade.encargado_usuario sub 
				ON sub.idUsuario = r.idUsuario
			LEFT JOIN trade.encargado enc 
				ON enc.idEncargado = sub.idEncargado
			JOIN ".getClienteHistoricoCuenta()." ch 
				ON ch.idCliente = v.idCliente
				AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
				AND ch.flagCartera = 1
			LEFT JOIN trade.segmentacionNegocio sn 
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ct 
				ON ct.idClienteTipo = sn.idClienteTipo
			JOIN General.dbo.ubigeo ubi01 
				ON ch.cod_ubigeo = ubi01.cod_ubigeo
			{$segmentacion['join']}
			
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0
				AND v.estado = 1
				{$filtros}
				{$visitas_filtro}
			ORDER BY canal, 
				departamento, 
				provincia, 
				distrito, 
				razonSocial, 
				fecha, 
				tipoFoto DESC;
		";

		return $this->db->query($sql);
	}

	public function getTipoCliente()
	{
		$filtro = '';
			$filtro .= getPermisos('cuenta');
			$filtro .= getPermisos('proyecto');

		$sql = "
		SELECT
			ct.*
		FROM trade.cliente_tipo ct
		JOIN trade.canal c ON ct.idCanal = c.idCanal
		JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
		JOIN trade.proyectoGrupoCanal pgc ON gc.idGrupoCanal = pgc.idGrupoCanal
		JOIN trade.proyecto py ON pgc.idProyecto = py.idProyecto
		JOIN trade.cuenta cu ON py.idCuenta = cu.idCuenta
		WHERE 1=1
		{$filtro}
		";

		return $this->db->query($sql);
	}

	public function getLogo(){
		$idCuenta = $this->sessIdCuenta;
		
		$sql="SELECT urlLogo FROM trade.cuenta WHERE idCuenta=$idCuenta";
		return $this->db->query($sql);
	}
	
	public function getVisitas($input){
		$fechas = getFechasDRP($input['txt-fechas']);

		$filtros = '';

			$input['idCuenta'] = $this->sessIdCuenta;
			$input['idProyecto'] = $this->sessIdProyecto;

			if(!empty($input['tipoFoto']) ) $filtros .= " AND mf.idTipoFoto = ".$input['tipoFoto'];


			$filtros .= !empty($input['idCuenta']) ? ' AND cu.idCuenta = '.$input['idCuenta'] : '';
			$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? " AND gc.idGrupoCanal=".$input['grupoCanal_filtro'] : "";
			$filtros .= !empty($input['canal_filtro']) ? " AND ca.idCanal=".$input['canal_filtro'] : "";

			$filtros .= !empty($input['codCliente']) ? " AND ch.codCliente='".$input['codCliente']."'" : "";
			$filtros .= !empty($input['codVisual']) ? " AND v.idCliente='".$input['codVisual']."'" : "";

			$filtros .= !empty($input['tipoUsuario_filtro']) ? " AND r.idTipoUsuario=".$input['tipoUsuario_filtro'] : "";
			$filtros .= !empty($input['usuario_filtro']) ? " AND r.idUsuario=".$input['usuario_filtro'] : "";

			$filtros .= !empty($input['tipoFoto']) ? " AND tf.idTipoFoto=".$input['tipoFoto'] : "";
			$filtros .= !empty($input['idClienteTipo']) ? " AND sn.idClienteTipo=".$input['idClienteTipo'] : "";

			$filtros .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
			$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
			$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
			$filtros .= !empty($input['plaza_filtro']) ? ' AND ds.idPlaza='.$input['plaza_filtro'] : '';
			$filtros .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
			$filtros .= !empty($input['banner_filtro']) ? ' AND bn.idBanner='.$input['banner_filtro'] : '';
			$top = !empty($input['top']) ? ' TOP '.$input['top'] : '';

			$segmentacion = getSegmentacion($input);

		$sql="
			DECLARE @fecIni date='".$fechas[0]."',@fecFin date='".$fechas[1]."';
			SELECT DISTINCT $top
				v.idVisita
			FROM 
			{$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v 
				ON r.idRuta = v.idRuta 
				AND v.numFotos>0 
				AND r.demo = 0
				AND r.fecha BETWEEN @fecIni AND @fecFin
				AND v.estado=1
			JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf 
				ON vf.idVisita = v.idVisita
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModuloFotos mf 
				ON mf.idVisitaFoto = vf.idVisitaFoto
			JOIN trade.aplicacion_modulo m 
				ON m.idModulo = vf.idModulo
			JOIN trade.aplicacion_modulo_grupo mg 
				ON mg.idModuloGrupo = m.idModuloGrupo
			LEFT JOIN trade.foto_tipo tf 
				ON tf.idTipoFoto = mf.idTipoFoto			
			JOIN trade.canal ca 
				ON ca.idCanal = v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal = gc.idGrupoCanal
			/* JOIN trade.usuario u 
				ON u.idUsuario = r.idUsuario
			JOIN trade.usuario_historico uh 
				ON uh.idUsuario = U.idUsuario
				AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				AND uh.idProyecto=r.idProyecto */
			JOIN trade.usuario_tipo ut 
				ON ut.idTipoUsuario = r.idTipoUsuario
			JOIN trade.proyecto py 
				ON py.idProyecto = r.idProyecto
			JOIN trade.cuenta cu 
				ON cu.idCuenta = r.idCuenta
			LEFT JOIN trade.banner bn 
				ON bn.idBanner = v.idBanner
			LEFT JOIN trade.encargado_usuario sub 
				ON sub.idUsuario = r.idUsuario
			LEFT JOIN trade.encargado enc 
				ON enc.idEncargado = sub.idEncargado
			JOIN ".getClienteHistoricoCuenta()." ch 
				ON ch.idCliente = v.idCliente
				AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
				AND ch.flagCartera = 1
			LEFT JOIN trade.segmentacionNegocio sn 
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ct 
				ON ct.idClienteTipo = sn.idClienteTipo
			JOIN General.dbo.ubigeo ubi01 
				ON ch.cod_ubigeo = ubi01.cod_ubigeo
			{$segmentacion['join']}
			
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0
				AND v.estado = 1
				{$filtros}
		";
		return $this->db->query($sql);
	}

	public function getFotosNew($input,$visitas)
	{
		$fechas = getFechasDRP($input['txt-fechas']);
		$filtros = '';
		$filtros_cliente = '';
		$filtros_visita_foto = '';
			$input['idCuenta'] = $this->sessIdCuenta;
			$input['idProyecto'] = $this->sessIdProyecto;

			if(!empty($input['tipoFoto']) ) $filtros_visita_foto .= " AND mf.idTipoFoto = ".$input['tipoFoto'];

			$filtros .= !empty($input['idProyecto']) ? ' AND r.idProyecto = '.$input['idProyecto'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? " AND gca.idGrupoCanal=".$input['grupoCanal_filtro'] : "";
			$filtros .= !empty($input['canal_filtro']) ? " AND ca.idCanal=".$input['canal_filtro'] : "";

			$filtros .= !empty($input['codVisual']) ? " AND v.idCliente='".$input['codVisual']."'" : "";
			
			$filtros .= !empty($input['tipoUsuario_filtro']) ? " AND r.idTipoUsuario=".$input['tipoUsuario_filtro'] : "";
			$filtros .= !empty($input['usuario_filtro']) ? " AND r.idUsuario=".$input['usuario_filtro'] : "";
			
			$filtros_visita_foto .= !empty($input['tipoFoto']) ? " AND tf.idTipoFoto=".$input['tipoFoto'] : "";

			$filtros_cliente .= !empty($input['codCliente']) ? " AND ch.codCliente='".$input['codCliente']."'" : "";
			$filtros_cliente .= !empty($input['idClienteTipo']) ? " AND sn.idClienteTipo=".$input['idClienteTipo'] : "";

			$filtros_cliente .= !empty($input['distribuidoraSucursal_filtro']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal_filtro'] : '';
			$filtros_cliente .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
			$filtros_cliente .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
			$filtros_cliente .= !empty($input['plaza_filtro']) ? ' AND pl.idPlaza='.$input['plaza_filtro'] : '';
			$filtros_cliente .= !empty($input['cadena_filtro']) ? ' AND cad.idCadena='.$input['cadena_filtro'] : '';
			$filtros_cliente .= !empty($input['banner_filtro']) ? ' AND ba.idBanner='.$input['banner_filtro'] : '';

			$filtros_cliente .= !empty($input['departamento_filtro']) ? ' AND ubi01.cod_departamento='.$input['departamento_filtro'] : '';
			$filtros_visita_foto .= !empty($input['tipoModulo']) ? ' AND mg.idModuloGrupo='.$input['tipoModulo'] : '';
			$filtros_cliente .= !empty($input['provincia_filtro']) ? ' AND ubi01.cod_provincia='.$input['provincia_filtro'] : '';
			$filtros_cliente .= !empty($input['distrito_filtro']) ? ' AND ubi01.cod_ubigeo='.$input['distrito_filtro'] : '';
			
			$visitas_filtro = !empty($visitas)?$visitas:'';

			$segmentacion = getSegmentacion($input);
			$cliente_historico = getClienteHistoricoCuenta();

		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}

		$idProyecto = $this->sessIdProyecto;
		$columnas = '';
		if(in_array($segmentacion['grupoCanal'], GC_MODERNOS))
        {
            $columnas = '
            , ch.idCadena
            , ch.idBanner
            , ch.banner
            , ch.cadena
            ';
        }
        if(in_array($segmentacion['grupoCanal'], GC_MAYORISTAS))
        {
            $columnas = '
            , ch.plaza 
            , ch.idPlaza
            , ch.zona
            , ch.idDistribuidoraSucursal
            ';
        }
        if(in_array($segmentacion['grupoCanal'], GC_TRADICIONALES))
        {
            $columnas = '
            , ch.distribuidora
            , ch.ciudadDistribuidoraSuc
            , ch.codUbigeoDisitrito
            , ch.idDistribuidoraSucursal
            , ch.zona
            ';
        }

		$sql = "
			DECLARE @fecIni DATE='".$fechas[0]."',@fecFin DATE='".$fechas[1]."';
			WITH list_visitas AS (
				SELECT
					r.idRuta
					, r.fecha
					, r.idProyecto
					, ca.idGrupoCanal
					, ca.idCanal
					, v.idCliente
					, v.idVisita
					, r.idUsuario
					, r.nombreUsuario usuario
					, r.tipoUsuario
					, CONVERT(VARCHAR(8), v.horaIni) horaVisita
				FROM {$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
				LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
				LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
				WHERE r.estado = 1 AND v.estado = 1
				AND r.fecha BETWEEN @fecIni AND @fecFin
				{$filtros}
				{$filtro_demo} 
				{$visitas_filtro}
			),list_visitasFotos AS (
				SELECT
					lv.idRuta
					, lv.fecha
					, lv.idProyecto
					, lv.idGrupoCanal
					, lv.idCanal
					, lv.idCliente
					, vf.idVisitaFoto
					, ISNULL(tf.nombre,m.nombre) tipoFoto
					, vf.fotoUrl imgRef
					, CONVERT(VARCHAR(8), vf.hora) horaFoto
					, lv.horaVisita
					, lv.idVisita
					, lv.idUsuario
					, lv.usuario
					, lv.tipoUsuario
					, mg.carpetaFoto
					, m.nombre modulo
				FROM  list_visitas lv
				JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisita = lv.idVisita
				LEFT JOIN trade.aplicacion_modulo m ON m.idModulo = vf.idModulo
				LEFT JOIN trade.aplicacion_modulo_grupo mg ON mg.idModuloGrupo = m.idModuloGrupo
				   LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaModuloFotos mf ON mf.idVisitaFoto = vf.idVisitaFoto
				LEFT JOIN trade.foto_tipo tf ON tf.idTipoFoto = mf.idTipoFoto
				WHERE vf.idVisitaFoto IS NOT NULL
				${filtros_visita_foto}
			), lista_clientes AS (
			SELECT
				ch.idCliente
				, ch.idSegClienteModerno
				, ch.idSegClienteTradicional
				, ch.codCliente
				, cli.nombreComercial
				, cli.razonSocial
				, cli.direccion
				,ct.idClienteTipo
				,ISNULL(ct.nombre,'-') AS cliente_tipo
				,ubi01.departamento
				,ubi01.provincia
				,ubi01.distrito
				{$segmentacion['columnas_bd']}
			FROM trade.cliente cli
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
			LEFT JOIN General.dbo.ubigeo ubi01 ON ch.cod_ubigeo = ubi01.cod_ubigeo
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ct ON ct.idClienteTipo = sn.idClienteTipo
			{$segmentacion['join']}
			WHERE ch.idProyecto = {$idProyecto} 
			{$filtros_cliente}
			AND General.dbo.fn_fechaVigente(ch.fecIni, ch.fecFin, @fecIni, @fecFin) = 1
			)
			SELECT DISTINCT
				v.idVisita
				,ISNULL(ch.departamento,'') departamento
				,ISNULL(ch.provincia,'') provincia
				,ISNULL(ch.distrito,'') distrito
				,v.idCliente
				,ISNULL(ch.codCliente,'-') codCliente
				,ch.razonSocial
				,ISNULL(ch.direccion,'-') direccion
				,CONVERT(VARCHAR,v.fecha,103) AS fecha
				,v.idUsuario
				,v.usuario
				,ca.nombre canal
				,ISNULL(pgc.nombre,gca.nombre) grupoCanal
				,UPPER(v.tipoUsuario) tipoUsuario 
				,v.idVisitaFoto
				,v.tipoFoto
				,v.imgRef
				,v.horaFoto
				,v.horaVisita
				,ch.idClienteTipo
				,ch.cliente_tipo
				,v.carpetaFoto
				,v.modulo
				,c.nombre cuenta
				,py.nombre proyecto
				{$columnas}
			FROM list_visitasFotos v
			JOIN lista_clientes ch ON v.idCliente = ch.idCliente
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			LEFT JOIN trade.proyectoGrupoCanal pgc ON pgc.idGrupoCanal = gca.idGrupoCanal AND pgc.idProyecto = {$this->sessIdProyecto}
			LEFT JOIN trade.proyecto py ON py.idProyecto = v.idProyecto
			LEFT JOIN trade.cuenta c ON c.idCuenta = py.idCuenta
			ORDER BY canal,departamento, provincia, distrito, razonSocial, fecha, tipoFoto DESC;
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query;
		}

		return $result;
	}

	public function getPermisosModulos()
	{
		$filtros = "";

		$idCuenta = $this->sessIdCuenta;
		$idProyecto = $this->sessIdProyecto;
		$idTipoUsuario = $this->idTipoUsuario;

		!empty($idCuenta) ? $filtros .= ' AND a.idCuenta=' . $idCuenta : '';
		!empty($idProyecto) ? $filtros .= ' AND p.idProyecto=' . $idProyecto : '';
		!empty($idProyecto) ? $filtros .= ' AND m.idTipoUsuario=' . $idTipoUsuario : '';

		$sql = "
		SELECT DISTINCT 
		mo.idModulo
		, mo.nombre AS value
		, mo.idModuloGrupo AS id
		FROM trade.aplicacion_modulo_tipoUsuario m
		JOIN trade.aplicacion_modulo mo ON mo.idModulo = m.idModulo
		JOIN trade.aplicacion a ON a.idAplicacion = mo.idAplicacion
		JOIN trade.proyecto p ON p.idCuenta = a.idCuenta
		WHERE m.estado = 1 {$filtros}
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query;
		}

		return $result;
	}
}
