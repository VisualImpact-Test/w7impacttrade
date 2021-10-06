<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_precios extends CI_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
    }

    public function obtener_categorias(){
    	$sql="SELECT DISTINCT pc.idCategoria, pc.nombre categoria, pm.idMarca, pm.nombre marca FROM trade.producto p
        JOIN trade.producto_marca pm ON pm.idMarca = p.idMarca AND pm.estado = 1
        JOIN trade.producto_categoria pc ON pc.idCategoria = p.idCategoria AND pc.estado = 1
        WHERE p.estado = 1
        ORDER BY pc.nombre, pm.nombre ASC";

    	return $this->db->query($sql);
	}
	
	public function obtener_banners(){
		$sql="
			select idBanner,nombre banner from trade.banner where estado=1
		";
		return $this->db->query($sql);
	}

    public function query_productos($input){

    	$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND ch.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-categoria']) ) $filtros.=" AND p.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";

		$sql = "
		DECLARE
			@fecIni date = '{$input['fecIni']}',
			@fecFin date = '{$input['fecFin']}';

		WITH
			w_producto AS (
				SELECT
					p.idProducto,
					p.ean,
					p.nombre,
					p.unidadPack,
					p.formato,
					p.flagCompetencia,
					pc.idCategoria,
					pc.nombre AS categoria,
					pm.idMarca,
					pm.nombre AS marca,
					pev.idEnvase,
					pev.descripcion AS envase
				FROM trade.producto p
				JOIN trade.producto_categoria pc ON pc.idCategoria=p.idCategoria
				JOIN trade.producto_marca pm ON p.idMarca = pm.idMarca
				LEFT JOIN trade.producto_envase pev ON p.idEnvase = pev.idEnvase
			),
			w_visita AS (
				SELECT
					v.idVisita,
					ubi.departamento,
					ubi.provincia,
					ubi.distrito,
					v.idCliente,
					v.idCanal,
					c.codCliente,
					v.razonSocial,
					v.direccion,
					CONVERT(VARCHAR,r.fecha,103) AS fecha,
					r.idUsuario,
					r.nombreUsuario AS usuario,
					v.canal,
					UPPER(r.tipoUsuario) AS tipoUsuario,
					p.idProducto,
					p.nombre AS producto,
					p.ean,
					p.idMarca,
					p.marca,
					p.idCategoria,
					p.categoria,
					dvpd.precio,
					dvpd.precioRegular,
					dvpd.precioOferta,
					p.flagCompetencia,
					p.idEnvase,
					p.envase,
					p.unidadPack,
					p.formato,
					v.banner
				FROM trade.data_ruta r
				JOIN trade.data_visita v ON v.idRuta=r.idRuta
				JOIN trade.data_visitaPrecios dvp ON dvp.idVisita=v.idVisita
				JOIN trade.data_visitaPreciosDet dvpd ON dvpd.idVisitaPrecios=dvp.idVisitaPrecios
				JOIN w_producto p ON dvpd.idProducto = p.idProducto
				JOIN trade.canal cn ON cn.idCanal=v.idCanal
				JOIN trade.cliente c ON c.idCliente=v.idCliente
				JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=c.cod_ubigeo
				JOIN trade.banner b ON b.idBanner=v.idBanner
				JOIN trade.list_productos lp ON lp.idListProductos=v.idListProductos				
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1
				WHERE r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo=0{$filtros}
			)

		SELECT
			v.*
		FROM w_visita v
		LEFT JOIN w_producto p ON v.idProducto = p.idProducto
		WHERE p.idProducto IS NOT NULL
		ORDER BY canal, departamento, provincia, distrito, razonSocial, fecha, categoria, marca, producto ASC 
		";
		return $this->db->query($sql);
	}
		
	public function query_resumen_enc($input){

    	$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND ch.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-categoria']) ) $filtros.=" AND p.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
    	//if( !empty($input['sl-hfs']) ) $filtros.=" AND  =".$input['sl-hfs'];
		//if( !empty($input['sl-whls']) ) $filtros.=" AND  =".$input['sl-whls'];
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";

    	$sql="
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			SELECT   
			cc.nombre cuenta,
			pc.idCategoria,pc.nombre categoria,pm.idMarca,pm.nombre marca,p.idProducto,p.nombre producto,p.presentacion
			,p.formato,pp.precioSugerido,pp.precioPromedio  
				
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.data_visitaPrecios dvp ON dvp.idVisita=v.idVisita
			JOIN trade.data_visitaPreciosDet dvpd ON dvpd.idVisitaPrecios=dvp.idVisitaPrecios
			JOIN trade.producto p ON p.idProducto=dvpd.idProducto
			JOIN trade.producto_categoria pc ON pc.idCategoria=p.idCategoria
			JOIN trade.producto_marca pm ON pm.idMarca=p.idMarca
			
			LEFT JOIN trade.producto_precios pp ON pp.idProducto=p.idProducto
			AND r.fecha BETWEEN pp.fecIni AND ISNULL(pp.fecFin,r.fecha) 
			
			JOIN trade.canal cn ON cn.idCanal=v.idCanal
			JOIN trade.cliente c ON c.idCliente=v.idCliente
			JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=c.cod_ubigeo
			JOIN trade.banner b ON b.idBanner=v.idBanner
			JOIN trade.list_productos lp ON lp.idListProductos=v.idListProductos

			
			
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			JOIN trade.cuenta cc ON cc.idCuenta= ch.idCuenta
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1

			WHERE r.fecha BETWEEN @fecIni AND @fecFin  
			AND r.demo=0
				$filtros
			ORDER BY canal,departamento,provincia,distrito, categoria, marca, producto  ASC 
		";
		
    	return $this->db->query($sql);
	}
	
	public function query_resumen_det($input){
		$sql="
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		with lista as (
			select distinct
			 v.idVisita
			 , v.idCliente
			 , v.idBanner
			 , r.fecha 
			from trade.data_ruta r
			join trade.data_visita v ON r.idRuta = v.idRuta
			join trade.data_visitaPrecios vp ON vp.idVisita = v.idVisita
			join trade.data_visitaPreciosDet vpd ON vpd.idVisitaPrecios = vp.idVisitaPrecios AND vpd.precio IS NOT NULL 
			where
			r.fecha between @fecIni and @fecFin
			), lista2 as (
			select 
			*
			, ROW_NUMBER() over (PARTITIon by idCliente,idBanner ORDER BY fecha DESC ) ord
			from 
			lista
			)
			select * from lista2 l
			join trade.data_visitaPrecios pv on pv.idVisita = l.idVisita
			join trade.data_visitaPreciosDet pvd ON pvd.idVisitaPrecios = pv.idVisitaPrecios and precio is not null
			where l.ord = 1
		";
		
		return $this->db->query($sql);
	}

	public function obtener_marcas(){
		$sql ="select pme.idMarca,me.nombre empresa from trade.producto_marca_empresa pme
		JOIN trade.marca_empresa me ON me.idEmpresa=pme.idEmpresa 
		where me.estado=1 and pme.estado=1";
		return $this->db->query($sql);
	}

	public function query_comparativo_enc($input){

    	$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND ch.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-categoria']) ) $filtros.=" AND p.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
    	//if( !empty($input['sl-hfs']) ) $filtros.=" AND  =".$input['sl-hfs'];
		//if( !empty($input['sl-whls']) ) $filtros.=" AND  =".$input['sl-whls'];
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";

    	$sql="
    	DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
    	SELECT 
			v.idVisita, ubi.departamento, ubi.provincia, ubi.distrito, v.idCliente, v.idCanal, c.codCliente, v.razonSocial, v.direccion, convert(varchar,r.fecha,103) fecha
			, r.idUsuario, r.nombreUsuario usuario, v.canal, UPPER(r.tipoUsuario) tipoUsuario, p.idProducto, p.nombre producto, p.ean, pm.idMarca, pm.nombre marca
			, pc.idCategoria, pc.nombre categoria, dvpd.precio, p.flagCompetencia
		FROM trade.data_ruta r
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		JOIN trade.data_visitaPrecios dvp ON dvp.idVisita=v.idVisita
		JOIN trade.data_visitaPreciosDet dvpd ON dvpd.idVisitaPrecios=dvp.idVisitaPrecios and dvpd.precio IS NOT NULL
		JOIN trade.producto_top pt ON pt.idProducto=dvpd.idProducto
		
		JOIN trade.producto p ON p.idProducto=dvpd.idProducto and p.flagCompetencia=0
		
		JOIN trade.producto_categoria pc ON pc.idCategoria=p.idCategoria
		JOIN trade.producto_marca pm ON pm.idMarca=p.idMarca
		JOIN trade.canal cn ON cn.idCanal=v.idCanal
		JOIN trade.cliente c ON c.idCliente=v.idCliente
		JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=c.cod_ubigeo
		JOIN trade.banner b ON b.idBanner=v.idBanner
		JOIN trade.list_productos lp ON lp.idListProductos=v.idListProductos
		
		
		JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
		AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1

		WHERE r.fecha BETWEEN @fecIni AND @fecFin
			AND r.demo=0
			$filtros
		ORDER BY canal,departamento,provincia,distrito, razonSocial, fecha, categoria, marca, producto  ASC 
		";
	 
    	return $this->db->query($sql);
	}

	public function query_comparativo_det($input){
		$filtros = '';
		if( !empty($input['sl-cuenta']) ) $filtros.=" AND ch.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-categoria']) ) $filtros.=" AND pcat.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
		if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
		
		$filtros2 = '';
		if( !empty($input['sl-banner']) ) $filtros2.=" AND pc.idBanner =".$input['sl-banner'];
		$sql="
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			with lista as (
				select distinct
				v.idVisita
				, v.idCliente
				, v.idBanner
				, r.fecha 
				from trade.data_ruta r
				join trade.data_visita v ON r.idRuta = v.idRuta
				join trade.data_visitaPrecios vp ON vp.idVisita = v.idVisita
				join trade.data_visitaPreciosDet vpd ON vpd.idVisitaPrecios = vp.idVisitaPrecios AND vpd.precio IS NOT NULL 
				
				JOIN trade.producto p ON p.idProducto=vpd.idProducto
				JOIN trade.producto_categoria pcat ON pcat.idCategoria=p.idCategoria
				JOIN trade.producto_marca pm ON pm.idMarca=p.idMarca
				JOIN trade.canal cn ON cn.idCanal=v.idCanal
				JOIN trade.cliente c ON c.idCliente=v.idCliente
				JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=c.cod_ubigeo
				JOIN trade.banner b ON b.idBanner=v.idBanner
				JOIN trade.list_productos lp ON lp.idListProductos=v.idListProductos
				
				
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
				AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1
				
				where
				r.fecha between @fecIni and @fecFin 
				$filtros
				), lista2 as (
				select 
				*
				, ROW_NUMBER() over (PARTITIon by idCliente,idBanner ORDER BY fecha DESC ) ord
				from 
				lista
				)
				select l.fecha,l.idVisita,pv.hora,pvd.precio,pt.idProducto idProductoTop,pc.idProductoCompetencia  from lista2 l
				join trade.data_visitaPrecios pv on pv.idVisita = l.idVisita
				join trade.data_visitaPreciosDet pvd ON pvd.idVisitaPrecios = pv.idVisitaPrecios and precio is not null
				
				JOIN trade.producto_competencia pc ON pc.idProductoCompetencia=pvd.idProducto
				JOIN trade.producto_top pt ON pt.idTop=pc.idTop 
					AND (
							pt.fecIni <= ISNULL( pt.fecFin, @fecFin)
							AND (
							pt.fecIni BETWEEN @fecIni AND @fecFin 
							OR
							ISNULL( pt.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
							OR
							@fecIni BETWEEN pt.fecIni AND ISNULL( pt.fecFin, @fecFin ) 
							OR
							@fecFin BETWEEN pt.fecIni AND ISNULL( pt.fecFin, @fecFin )
							)
						) 
				
				where l.ord = 1 AND pc.estado=1 AND pt.estado=1
				$filtros2
		";
		
		return $this->db->query($sql);
	}

	public function obtener_tops($input){
		$filtros="";
		if( !empty($input['sl-categoria']) ) $filtros.=" AND p.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
		$sql="
			DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
			select pc.nombre categoria,pm.nombre marca, p.idProducto,p.nombre producto ,pcom.idProductoCompetencia,p_c.nombre productoComp  from trade.producto p
			join trade.producto_top pt ON pt.idProducto=p.idProducto 
			AND (pt.fecIni <= ISNULL( pt.fecFin, @fecFin)
				AND (
				pt.fecIni BETWEEN @fecIni AND @fecFin 
				
				OR
				ISNULL( pt.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
				OR
				@fecIni BETWEEN pt.fecIni AND ISNULL( pt.fecFin, @fecFin ) 
				OR
				@fecFin BETWEEN pt.fecIni AND ISNULL( pt.fecFin, @fecFin )
				)
			) 
			join trade.producto_marca pm ON pm.idMarca=p.idMarca
			join trade.producto_categoria pc ON pc.idCategoria=p.idCategoria

			join trade.producto_competencia pcom ON pcom.idTop=pt.idTop
			join trade.producto p_c ON p_c.idProducto=pcom.idProductoCompetencia
			where pt.estado=1
			$filtros
		";
		return $this->db->query($sql);
	}

	public function query_cadena($input){
		$filtros = '';
    	if( !empty($input['sl-cluster']) ) $filtros.=" AND v.idCluster =".$input['sl-cluster'];
    	//if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	//if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND v.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-categoria']) ) $filtros.=" AND p.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-formato']) ) $filtros.=" AND p.formato =".$input['sl-formato'];
    	//if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	//if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	//if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	//if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
    	if( !empty($input['sl-producto']) ) $filtros.=" AND p.idProducto =".$input['sl-producto'];
		//if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";
		
		$sql = 
		"
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT 
			  banner
			, idBanner
			, idFecha
			, fecha
			, canal
			, idProducto
			, producto
			, idMarca
			, marca
			, idCategoria
			, categoria
			, precio
			, flagCompetencia
			, formato
			, mayor
			, minimo
			, promedio
			, row
			, moda
			, cod_departamento
			, departamento
			, codigo_mapa
		FROM (
			SELECT 
				  banner
				, idBanner
				, idFecha
				, fecha
				, canal
				, idProducto
				, producto
				, idMarca
				, marca
				, idCategoria
				, categoria
				, precio
				, flagCompetencia
				, formato
				, mayor
				, minimo
				, promedio
				, row
				, ROW_NUMBER() OVER (PARTITION BY idProducto,idBanner ORDER BY row DESC) moda
				, cod_departamento
				, departamento
				, codigo_mapa
			FROM (
				SELECT
					  v.banner
					, v.idBanner
					, convert(varchar,r.fecha,112) idFecha
					, convert(varchar,r.fecha,103) fecha
					, v.canal
					, p.idProducto
					, p.nombre producto
					, p.ean
					, pm.idMarca
					, pm.nombre marca
					, pc.idCategoria
					, pc.nombre categoria
					, dvpd.precio
					, p.flagCompetencia
					, p.formato
					, MAX(dvpd.precio) OVER (PARTITION BY p.idProducto,v.idBanner) mayor
					, MIN(dvpd.precio) OVER (PARTITION BY p.idProducto,v.idBanner) minimo
					, ROUND(AVG(dvpd.precio) OVER (PARTITION BY p.idProducto,v.idBanner),2) promedio
					, COUNT(dvpd.precio) OVER (PARTITION BY p.idProducto,v.idBanner,dvpd.precio) row
					, ub.cod_departamento
					, ub.departamento
					, ddm.codigo_mapa
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v 
						ON v.idRuta=r.idRuta
					JOIN trade.data_visitaPrecios dvp 
						ON dvp.idVisita=v.idVisita
					JOIN trade.data_visitaPreciosDet dvpd 
						ON dvpd.idVisitaPrecios=dvp.idVisitaPrecios
					JOIN trade.producto p 
						ON p.idProducto=dvpd.idProducto
					JOIN trade.producto_categoria pc 
						ON pc.idCategoria=p.idCategoria
					JOIN trade.producto_marca pm 
						ON pm.idMarca=p.idMarca
					JOIN trade.canal cn 
						ON cn.idCanal=v.idCanal
					JOIN trade.cliente c 
						ON c.idCliente=v.idCliente
					JOIN General.dbo.ubigeo ubi 
						ON ubi.cod_ubigeo=c.cod_ubigeo
					JOIN trade.dashboard_departamento_mapa ddm
						ON ddm.cod_departamento = ubi.cod_departamento
					JOIN trade.banner b 
						ON b.idBanner=v.idBanner
					JOIN trade.list_productos lp 
						ON lp.idListProductos=v.idListProductos
					JOIN ".getClienteHistoricoCuenta()." ch 
						ON ch.idCliente = c.idCliente
						AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1
					JOIN General.dbo.ubigeo ub
						ON ub.cod_ubigeo=v.cod_ubigeo
				WHERE 
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo=0

					$filtros
			)a
		)b
		WHERE moda = 1
		ORDER BY 
			fecha
		";
		return $this->db->query($sql);
	}

	public function query_matriz($input){
		$filtros = '';
    	if( !empty($input['sl-cluster']) ) $filtros.=" AND v.idCluster =".$input['sl-cluster'];
    	//if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	//if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND v.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-categoria']) ) $filtros.=" AND p.idCategoria =".$input['sl-categoria'];
    	if( !empty($input['sl-formato']) ) $filtros.=" AND p.formato =".$input['sl-formato'];
    	//if( !empty($input['sl-marca']) ) $filtros.=" AND p.idMarca =".$input['sl-marca'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	//if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	//if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	//if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
    	if( !empty($input['sl-producto']) ) $filtros.=" AND p.idProducto =".$input['sl-producto'];
		//if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";
		
		$sql = 
		"
		DECLARE @fecIni date='".$input['fecIni']."',@fecFin date='".$input['fecFin']."';
		SELECT 
			  banner
			, idBanner
			, idFecha
			, fecha
			, canal
			, idProducto
			, producto
			, idMarca
			, marca
			, idCategoria
			, categoria
			, precio
			, flagCompetencia
			, formato
			, mayor
			, minimo
			, promedio
			, row
			, moda
			, cod_departamento
			, departamento
			, codigo_mapa
		FROM (
			SELECT 
				  banner
				, idBanner
				, idFecha
				, fecha
				, canal
				, idProducto
				, producto
				, idMarca
				, marca
				, idCategoria
				, categoria
				, precio
				, flagCompetencia
				, formato
				, mayor
				, minimo
				, promedio
				, row
				, ROW_NUMBER() OVER (PARTITION BY idProducto,idBanner ORDER BY row DESC) moda
				, cod_departamento
				, departamento
				, codigo_mapa
			FROM (
				SELECT
					  v.banner
					, v.idBanner
					, convert(varchar,r.fecha,112) idFecha
					, convert(varchar,r.fecha,103) fecha
					, v.canal
					, p.idProducto
					, p.nombre producto
					, p.ean
					, pm.idMarca
					, pm.nombre marca
					, pc.idCategoria
					, pc.nombre categoria
					, dvpd.precio
					, p.flagCompetencia
					, p.formato
					, MAX(
					
						CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 AND dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
								CASE WHEN (dvpd.precioOferta < dvpd.precioRegular) THEN 
									dvpd.precioOferta 
								ELSE 
									dvpd.precioRegular
								END
						ELSE 
							CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 ) THEN 
								dvpd.precioOferta 
							ELSE 
								CASE WHEN (dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
									dvpd.precioRegular 
								ELSE
									dvpd.precio
								END
							END
						END
					
					
					) OVER (PARTITION BY p.idProducto,v.idBanner) mayor
					, MIN(
					
						CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 AND dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
								CASE WHEN (dvpd.precioOferta < dvpd.precioRegular) THEN 
									dvpd.precioOferta 
								ELSE 
									dvpd.precioRegular
								END
						ELSE 
							CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 ) THEN 
								dvpd.precioOferta 
							ELSE 
								CASE WHEN (dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
									dvpd.precioRegular 
								ELSE
									dvpd.precio
								END
							END
						END
					
					
					) OVER (PARTITION BY p.idProducto,v.idBanner) minimo
					, ROUND(AVG(
					
						CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 AND dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
								CASE WHEN (dvpd.precioOferta < dvpd.precioRegular) THEN 
									dvpd.precioOferta 
								ELSE 
									dvpd.precioRegular
								END
						ELSE 
							CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 ) THEN 
								dvpd.precioOferta 
							ELSE 
								CASE WHEN (dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
									dvpd.precioRegular 
								ELSE
									dvpd.precio
								END
							END
						END
					
					) OVER (PARTITION BY p.idProducto,v.idBanner),2) promedio
					, COUNT(
					
						CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 AND dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
								CASE WHEN (dvpd.precioOferta < dvpd.precioRegular) THEN 
									dvpd.precioOferta 
								ELSE 
									dvpd.precioRegular
								END
						ELSE 
							CASE WHEN (dvpd.precioOferta IS NOT NULL AND dvpd.precioOferta<>0 ) THEN 
								dvpd.precioOferta 
							ELSE 
								CASE WHEN (dvpd.precioRegular IS NOT NULL AND dvpd.precioRegular<>0) THEN 
									dvpd.precioRegular 
								ELSE
									dvpd.precio
								END
							END
						END
					) OVER (PARTITION BY p.idProducto,v.idBanner,dvpd.precio) row
					, ub.cod_departamento
					, ub.departamento
					, ddm.codigo_mapa
				FROM 
					trade.data_ruta r
					JOIN trade.data_visita v 
						ON v.idRuta=r.idRuta
					JOIN trade.data_visitaPrecios dvp 
						ON dvp.idVisita=v.idVisita
					JOIN trade.data_visitaPreciosDet dvpd 
						ON dvpd.idVisitaPrecios=dvp.idVisitaPrecios
					JOIN trade.producto p 
						ON p.idProducto=dvpd.idProducto
					JOIN trade.producto_categoria pc 
						ON pc.idCategoria=p.idCategoria
					JOIN trade.producto_marca pm 
						ON pm.idMarca=p.idMarca
					JOIN trade.canal cn 
						ON cn.idCanal=v.idCanal
					JOIN trade.cliente c 
						ON c.idCliente=v.idCliente
					JOIN General.dbo.ubigeo ubi 
						ON ubi.cod_ubigeo=c.cod_ubigeo
					JOIN trade.dashboard_departamento_mapa ddm
						ON ddm.cod_departamento = ubi.cod_departamento
					JOIN trade.banner b 
						ON b.idBanner=v.idBanner
					JOIN trade.list_productos lp 
						ON lp.idListProductos=v.idListProductos
					JOIN ".getClienteHistoricoCuenta()." ch 
						ON ch.idCliente = c.idCliente
						AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1
					JOIN General.dbo.ubigeo ub
						ON ub.cod_ubigeo=v.cod_ubigeo
				WHERE 
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo=0

					$filtros
			)a
		)b
		WHERE moda = 1
		ORDER BY 
			fecha
		";
		return $this->db->query($sql);
	}
	
	public function obtener_departamentos(){
		$sql = "
			SELECT DISTINCT
				  cod_departamento
				, departamento
			FROM
				General.dbo.ubigeo
			 WHERE 
				cod_departamento IS NOT NULL
			ORDER BY departamento
		";
		return $this->db->query($sql);
	}
	
	public function obtener_canales(){
		$sql ="
			SELECT DISTINCT
				ca.idCanal
				,ca.nombre
			FROM
				trade.canal ca
				JOIN trade.cuenta_canal cc
					ON cc.idCanal = ca.idCanal
			 WHERE 
				idCuenta=2
		";
		return $this->db->query($sql);
	}
	
	public function obtener_productos(){
		$sql ="
			SELECT DISTINCT
				 idProducto
				,nombre
			FROM
				trade.producto
			 WHERE 
				idCuenta=2
				AND estado=1
		";
		return $this->db->query($sql);
	}
	
	public function obtener_categorias2(){
		$sql = "
			select DISTINCT
				  pc.idCategoria
				, pc.nombre
			from 
				trade.producto_categoria pc
				JOIN trade.producto p
					ON p.idCategoria=pc.idCategoria
					AND p.idCuenta=2
		";
		return $this->db->query($sql);
	}
	
	public function obtener_formato(){
		$sql = "
			select DISTINCT
				 formato
			from 
				trade.producto
			where 
				idCuenta=2
		";
		return $this->db->query($sql);
	}

	public function obtener_cluster(){
		$sql ="
			SELECT DISTINCT
				idCluster
				,nombre
			FROM
				trade.cluster
			 WHERE 
				estado=1
		";
		return $this->db->query($sql);
	}
	
	public function getTiposDeUsuario()
	{
		$sql = "
			SELECT
				ut.idTipoUsuario, 
				ut.nombre  
			FROM  trade.usuario_tipo ut  
		";

		return $this->db->query($sql);
	}

	public function getMarcas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= "";
		} else {
			if (!empty($post['id'])) $filtros .= " AND m.idMarca = " . $post['id'];
		}
		if(!empty($post['cuenta']))$filtros .= " AND c.idCuenta=".$post['cuenta'];


		$sql = "
				SELECT
				 m.*
				 ,c.nombre cuenta
                FROM
				trade.producto_marca m
				JOIN trade.cuenta c ON c.idCuenta = m.idCuenta
				$filtros
				
			";
		return $this->db->query($sql);
	}
	public function getCategorias($post = 'nulo')
	{
		$sql = "
                SELECT *
                FROM
					impactTrade_bd.trade.producto_categoria
				WHERE
					estado=1
			";
		return $this->db->query($sql);
	}

	public function getProductos($post)
	{
		$filtros = '';
		if( !empty($post['categoria']) ) $filtros.=" AND pro.idCategoria =".$post['categoria'];
		
		$sql = "
			DECLARE @fecha date =getdate();
			select distinct pro.idProducto,pro.nombre from trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario=u.idUsuario and uh.estado=1 
			and @fecha between uh.fecIni and isnull(uh.fecFin,@fecha)
			JOIN trade.proyecto p ON p.idProyecto=uh.idProyecto 
			JOIN trade.producto pro ON pro.idCuenta=p.idCuenta
			WHERE pro.estado=1 and pro.flagCompetencia=0 
			and u.idUsuario=".$post['idUsuario']."
			$filtros
			order by pro.nombre";
		return $this->db->query($sql);
	}

	public function getUsuarios($post)
	{
		$sql = "
			DECLARE @fecha date =getdate();
			select distinct us.* from trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario=u.idUsuario and uh.estado=1 AND u.idUsuario=".$post['idUsuario']."
			and @fecha between uh.fecIni and isnull(uh.fecFin,@fecha)
			JOIN trade.proyecto p ON p.idProyecto=uh.idProyecto 
			JOIN trade.producto pro ON pro.idCuenta=p.idCuenta
			JOIN trade.usuario us ON us.estado=1 
			JOIN trade.usuario_historico ush ON ush.idUsuario=us.idUsuario and ush.idProyecto=p.idProyecto and ush.estado=1
			WHERE pro.estado=1 and pro.flagCompetencia=0";
		return $this->db->query($sql);
	}
	

	public function getVisitasPrecios($post)
	{
		$fechas = getFechasDRP($post['txt-fechas']);

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		$filtros = "";
		if (isset($post["ch-competencia"]) && !in_array("pg", $post["ch-competencia"]) && in_array("competencia", $post["ch-competencia"])) $filtros .= " AND pro.flagCompetencia = 1";
		if (isset($post["ch-competencia"]) && in_array("pg", $post["ch-competencia"]) && !in_array("competencia", $post["ch-competencia"])) $filtros .= " AND pro.flagCompetencia = 0";
		if (!empty($post["tipoUsuario"])) $filtros .= " AND uh.idTipoUsuario = " . $post["tipoUsuario"];
		if (!empty($post["usuario"])) $filtros .= " AND u.idUsuario = " . $post["usuario"];
		if (!empty($post["categoria"])) $filtros .= " AND p.idCategoria = " . $post["categoria"];
		if (!empty($post["marca"])) $filtros .= " AND p.idMarca = " . $post["marca"];
		if (!empty($post["producto"])) $filtros .= " AND p.idProducto = " . $post["producto"];
		if (!empty($post["idCuenta"])) $filtros .= " AND r.idCuenta = " . $post["idCuenta"];

		$filtros .= !empty($post['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$post['distribuidora_filtro'] : '';
		$filtros .= !empty($post['zona_filtro']) ? ' AND z.idZona='.$post['zona_filtro'] : '';
		$filtros .= !empty($post['plaza_filtro']) ? ' AND pl.idPlaza='.$post['plaza_filtro'] : '';
		$filtros .= !empty($post['cadena_filtro']) ? ' AND cad.idCadena='.$post['cadena_filtro'] : '';
		$filtros .= !empty($post['banner_filtro']) ? ' AND ba.idBanner='.$post['banner_filtro'] : '';

		// DATOS DEMO
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
			else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
		}

		$segmentacion = getSegmentacion($post);

		$sql = "
			DECLARE @fecIni date='" . $fechas[0] . "',@fecFin date='" . $fechas[1] . "';
			SELECT DISTINCT
				ubi.departamento,
				ubi.provincia,
				ubi.distrito,
				gc.nombre AS grupoCanal,
				ca.nombre AS canal,
				sc.nombre subCanal,
				r.idUsuario,
				r.nombreUsuario,
				ut.nombre AS tipoUsuario,
				r.fecha,
				c.codCliente,
				c.idCliente,
				c.codDist,
				c.razonSocial,
				c.direccion,
				ct.nombre AS tipoCliente,
				procat.nombre AS categoria,
				promar.nombre AS marca,
				pro.idProducto,
				pro.nombre AS producto,
				pro.ean,
				vpd.precio,
				v.idZona,
				ubi.cod_departamento,
				vp.idVisita
				{$segmentacion['columnas_bd']}
			FROM trade.data_ruta r
				JOIN trade.data_visita v ON v.idRuta = r.idRuta and (r.fecha BETWEEN @fecIni AND @fecFin)
				JOIN trade.data_visitaprecios vp ON vp.idVisita=v.idVisita
				JOIN trade.data_visitaPreciosDet vpd ON vp.idVisitaPrecios = vpd.idVisitaPrecios
				JOIN trade.producto pro ON vpd.idProducto = pro.idProducto
				JOIN trade.producto_categoria procat ON pro.idCategoria = procat.idCategoria
				LEFT JOIN trade.producto_marca promar ON pro.idMarca = promar.idMarca

				LEFT JOIN trade.usuario_tipo ut ON r.idTipoUsuario = ut.idTipoUsuario
				LEFT JOIN General.dbo.ubigeo ubi ON v.cod_ubigeo = ubi.cod_ubigeo
				JOIN trade.producto p ON vpd.idProducto = p.idProducto
				JOIN trade.cliente c ON v.idCliente = c.idCliente
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente AND ch.estado=1
					AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
				LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio=ch.idSegNegocio
				LEFT JOIN trade.subCanal sc ON sn.idSubCanal = sc.idSubCanal
				LEFT JOIN trade.cliente_tipo ct
					ON ct.idClienteTipo = sn.idClienteTipo
				JOIN trade.canal ca ON v.idCanal = ca.idCanal
				LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal

				--LEFT JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional
				--LEFT JOIN trade.plaza pla ON sct.idPlaza = pla.idPlaza
				{$segmentacion['join']}
			WHERE 1 = 1
				AND v.estado = 1
				$filtros
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaprecios' ];

		return $this->db->query($sql);
	}

	public function obtener_detalle_precios_new($params = [])
	{
		$filtros = "";
		if(empty($params['proyecto_filtro'])){
			$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta='.$params['idCuenta'] : '';
			$filtros .= !empty($params['proyecto_filtro']) ? ' AND r.idProyecto='.$params['proyecto_filtro'] : '';
			$filtros .= !empty($params['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$params['grupoCanal_filtro'] : '';
			$filtros .= !empty($params['canal_filtro']) ? ' AND ca.idCanal='.$params['canal_filtro'] : '';
			// $filtros .= ' AND dvd.quiebre='.$params['quiebre'];

			$filtros .= !empty($params['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$params['distribuidora_filtro'] : '';
			$filtros .= !empty($params['zona_filtro']) ? ' AND z.idZona='.$params['zona_filtro'] : '';
			$filtros .= !empty($params['plaza_filtro']) ? ' AND pl.idPlaza='.$params['plaza_filtro'] : '';
			$filtros .= !empty($params['cadena_filtro']) ? ' AND cad.idCadena='.$params['cadena_filtro'] : '';
			$filtros .= !empty($params['banner_filtro']) ? ' AND ba.idBanner='.$params['banner_filtro'] : '';
		}

		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion($params);

		$sql = "
			DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecFin']."';
			SELECT
				cu.nombre AS cuenta
				, gca.nombre AS grupoCanal
				, ca.nombre AS canal
				, v.idCliente
				, v.codCliente
				, v.nombreComercial
				, ele.nombre AS producto
				, r.fecha 
				, me.nombre AS empresa
				, cat.nombre AS categoria
				, m.nombre AS marca
				, ele.formato
				, dvd.precio 
				, t.mes
				, t.idSemana semana
				, t.diaFecha dia
				, t.anio
				{$segmentacion['columnas_bd']}
				
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cliente cli ON v.idCliente = cli.idCliente
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$params['proyecto_filtro']}
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			JOIN trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
			LEFT JOIN trade.producto_marca m ON m.idMarca = ele.idMarca
			LEFT JOIN trade.producto_categoria cat ON cat.idCategoria = ele.idCategoria
			LEFT JOIN trade.producto_marca_empresa pme ON pme.idMarca = m.idMarca
			LEFT JOIN trade.marca_empresa me ON me.idEmpresa = pme.idEmpresa
			LEFT JOIN General.dbo.tiempo t ON t.fecha = r.fecha
			{$segmentacion['join']}
			WHERE r.estado = 1 AND v.estado = 1 AND r.demo = 0
			AND r.fecha BETWEEN @fecIni AND @fecFin
			$filtros
			ORDER BY nombreComercial
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getAnios($input = [])
	{
		$sql = "
		SELECT DISTINCT 
		anio, CASE WHEN anio = YEAR(GETDATE()) THEN '1' ELSE '0' END   actual 
		FROM  General.dbo.tiempo order by actual desc, anio asc";

		return $this->db->query($sql);
	}
	public function getSemanas($input = [])
	{
		$sql = "
		SELECT DISTINCT 
		idSemana, 
		CASE WHEN idSemana = DATEPART(week, GETDATE()) THEN '1' ELSE '0' END actual
		FROM  General.dbo.tiempo 
		order by actual desc, idSemana asc";

		return $this->db->query($sql);
	}

	public function obtener_detalle_precios_variabilidad($params = [])
	{
		$filtros = "";
		if(empty($params['proyecto_filtro'])){
			$filtros.= getPermisos('cuenta');
		}else{
			$filtros .= !empty($params['idCuenta']) ? ' AND r.idCuenta='.$params['idCuenta'] : '';
			$filtros .= !empty($params['proyecto_filtro']) ? ' AND r.idProyecto='.$params['proyecto_filtro'] : '';
			$filtros .= !empty($params['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$params['grupoCanal_filtro'] : '';
			$filtros .= !empty($params['canal_filtro']) ? ' AND ca.idCanal='.$params['canal_filtro'] : '';
			// $filtros .= ' AND dvd.quiebre='.$params['quiebre'];

			$filtros .= !empty($params['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$params['distribuidora_filtro'] : '';
			$filtros .= !empty($params['zona_filtro']) ? ' AND z.idZona='.$params['zona_filtro'] : '';
			$filtros .= !empty($params['plaza_filtro']) ? ' AND pl.idPlaza='.$params['plaza_filtro'] : '';
			$filtros .= !empty($params['cadena_filtro']) ? ' AND cad.idCadena='.$params['cadena_filtro'] : '';
			$filtros .= !empty($params['banner_filtro']) ? ' AND ba.idBanner='.$params['banner_filtro'] : '';

			$filtros .= !empty($params['empresa_filtro']) ? ' AND pme.idEmpresa='.$params['empresa_filtro'] : '';
			$filtros .= !empty($params['categoria_filtro']) ? ' AND cat.idCategoria='.$params['categoria_filtro'] : '';
		}

		$cliente_historico = getClienteHistoricoCuenta();
		$segmentacion = getSegmentacion($params);

		$sql = "
			DECLARE @fecIni date='".$params['fecIni']."',@fecFin date='".$params['fecFin']."';
			SELECT DISTINCT
			cu.nombre AS cuenta
			, gca.nombre AS grupoCanal
			, ca.nombre AS canal
			, ele.nombre AS producto
			, me.nombre AS empresa
			, cat.nombre AS categoria
			, m.nombre AS marca
			, ele.formato
			, t.idSemana semana
			, t.anio
			, me.idEmpresa
			, cat.idCategoria
			, m.idMarca
			, ele.idProducto
			, AVG(dvd.precio) OVER(PARTITION BY cad.idCadena,ba.idBanner,ele.idProducto,t.idSemana) AS promedio_semana
			{$segmentacion['columnas_bd']}
				
			FROM trade.data_ruta r
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.cliente cli ON v.idCliente = cli.idCliente
			JOIN {$cliente_historico} ch ON cli.idCliente = ch.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,GETDATE(),GETDATE())=1 AND ch.idProyecto = {$params['proyecto_filtro']}
			JOIN trade.cuenta cu ON cu.idCuenta=r.idCuenta
			LEFT JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gca ON ca.idGrupoCanal=gca.idGrupoCanal
			JOIN trade.data_visitaProductos dvv ON dvv.idVisita=v.idVisita
			JOIN trade.data_visitaProductosDet dvd ON dvd.idVisitaProductos=dvv.idVisitaProductos
			JOIN trade.producto ele ON ele.idProducto=dvd.idProducto
			LEFT JOIN trade.producto_marca m ON m.idMarca = ele.idMarca
			LEFT JOIN trade.producto_categoria cat ON cat.idCategoria = ele.idCategoria
			LEFT JOIN trade.producto_marca_empresa pme ON pme.idMarca = m.idMarca
			LEFT JOIN trade.marca_empresa me ON me.idEmpresa = pme.idEmpresa
			LEFT JOIN General.dbo.tiempo t ON t.fecha = r.fecha
			{$segmentacion['join']}
			WHERE r.estado = 1 AND v.estado = 1 AND r.demo = 0
			-- AND r.fecha BETWEEN @fecIni AND @fecFin
			AND t.anio = {$params['nanio']}  AND t.idSemana IN({$params['nsemanas']}) 
			$filtros
			ORDER BY cad.nombre,ele.nombre
		";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function obtener_categorias_filtros($params = [])
	{
		$filtro = "";

		if (!empty($params['idCategoria'])) $filtro .= " AND c.idCategoria = " . $params['idCategoria'];
		if (!empty($params['idEmpresa'])) $filtro .= " AND pme.idEmpresa = " . $params['idEmpresa'];

		$sql = "
			SELECT DISTINCT
				pc.idCategoria
				, pc.nombre AS categoria
			FROM trade.producto p
			JOIN trade.producto_marca pm ON p.idMarca = pm.idMarca
			JOIN trade.producto_marca_empresa pme ON pm.idMarca = pme.idMarca
			JOIN trade.producto_categoria pc ON p.idCategoria = pc.idCategoria
			WHERE pme.estado = 1{$filtro}
			ORDER BY categoria ASC
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_empresas_filtros($params = [])
	{
		$filtro = "";

		if (!empty($params['idEmpresa'])) $filtro .= " AND e.idEmpresa = " . $params['idEmpresa'];

		$sql = "
			SELECT DISTINCT
				e.idEmpresa
				, e.nombre AS empresa
			FROM trade.marca_empresa e
			WHERE e.estado = 1{$filtro}
			ORDER BY empresa ASC
		";

		return $this->db->query($sql)->result_array();
	}
}
?>