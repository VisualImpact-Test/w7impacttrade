<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_presellers extends MY_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();
	}

	function getDetalleVenta( $params, $filtros ){
		$fechas = $params['txtFechas'];
		$demo ='AND u.demo=0';
		$usuario = '';
		if(!empty($params['demo'])){
			$demo = 'AND u.demo=1';
			$usuario = 'AND u.idUsuario='.$params['demo'];
		}
		$arrayFechas = explode("-",$fechas);
	 $sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT 
				  z.idZona idUnidad
				, z.nombre unidad
				, ub_pl.cod_ubigeo idCiudad
				, ub_pl.provincia ciudad
				, pl.idPlaza
				, pl.nombre plaza
				, ve.idTopeSucursal idTope
				, UPPER(ve.nombreTopeSucursal) tope
				, ve.idTipoUsuario idPlataforma
				, u.idUsuario
				, UPPER(u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres) preseller
				, CONVERT(VARCHAR, ve.fecPreventa, 103) fecha_pv
				, CONVERT(VARCHAR, ve.fecVenta, 103) fecha_v
				, DATEDIFF(d,ve.fecPreventa,ve.fecVenta) difDias
				, ve.idSucursal idCliente
				, UPPER(ve.nombreSucursal) cliente
				, ve.nombreCategoriaCli catCliente
				, ve.nombreTipoPlan planCliente
				, ve.idVenta codVenta
				, UPPER(ISNULL(pc.nombre, '-')) categoria
				, UPPER(ISNULL(mr.nombre, '-')) marca
				, p.codigoPG ean
				, UPPER(p.nombreBreve) producto
				, UPPER(um.abr) um
				, ved.cant_real cant
				, ved.precio_real precio
				, ved.subTotal_real subTotal
				, 1 foto
				, p.idProducto
				, tp.nombre tipo_pago
				, ve.flagPulls
			FROM 
				pg.presellers.ventas ve 
				JOIN pg.presellers.venta_detalle ved 
					ON ved.idVenta = ve.idVenta 
					AND ved.estado = 1
				JOIN pg.dbo.producto p 
					ON p.idProducto = ved.idProducto
				LEFT JOIN pg.presellers.unidadMedida um 
					ON um.idUnidadMedida = ved.idUnidadMedida
				JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
				JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
				JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
				JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
				JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
				JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
				JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo
				JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
				JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
				{$demo}
				JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
					AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
					AND uh.idUsuarioTipo in (6,9)
					AND uh.estado=1
				LEFT JOIN pg.presellers.tipo_pago tp ON tp.idTipoPago = ve.idTipoPago
			WHERE
				ve.fecVenta BETWEEN @fecIni AND @fecFin
				AND ve.estado=1 
				AND ve.idEtapaVenta = 2
				{$filtros}
				{$usuario}
			--ORDER BY unidad, ciudad, plaza, tope, fecha_pv, cliente, codVenta, categoria, marca, producto ASC
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}
	
	function getDetalleVentaComprobante( $params, $filtros ){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT DISTINCT
				  ve.idVenta codVenta
				, vd.numDoc numComp
				, vd.imgRef foto
				, td.nombre tipo	
			FROM 
				pg.presellers.ventas ve 
				JOIN pg.presellers.venta_detalle ved 
					ON ved.idVenta = ve.idVenta 
				JOIN pg.dbo.producto p 
					ON p.idProducto = ved.idProducto
				JOIN pg.presellers.unidadMedida um 
					ON um.idUnidadMedida = ved.idUnidadMedida
				JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
				JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
				JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
				JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
				JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
				JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
				JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
				JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
				JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
				AND u.demo=0
				JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
				AND uh.idUsuarioTipo in (6,9)
				AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
				AND uh.estado=1
			WHERE
				ve.fecVenta BETWEEN @fecIni AND @fecFin
				AND ve.estado=1 
				AND ve.idEtapaVenta = 2
				{$filtros}
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}

	function getDetallePreVenta( $params, $filtros ){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		 $sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT
				  z.idZona idUnidad
				, z.nombre unidad
				, ub_pl.cod_ubigeo idCiudad
				, ub_pl.provincia ciudad
				, pl.idPlaza
				, pl.nombre plaza
				, ve.idTopeSucursal idTope
				, UPPER(ve.nombreTopeSucursal) tope
				, ve.idTipoUsuario idPlataforma
				, u.idUsuario
				, UPPER(u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres) preseller
				, CONVERT(VARCHAR, ve.fecPreventa, 103) fecha_pv
				, CONVERT(VARCHAR, ve.fecVenta, 103) fecha_v
				, DATEDIFF(d,ve.fecPreventa,ve.fecVenta) difDias
				, ve.idSucursal idCliente
				, UPPER(ve.nombreSucursal) cliente
				, ve.nombreCategoriaCli catCliente
				, ve.nombreTipoPlan planCliente
				, ve.idVenta codVenta
				, '-' numComp
				, UPPER(ISNULL(pc.nombre, '-')) categoria
				, UPPER(ISNULL(mr.nombre, '-')) marca
				, p.codigoPG ean
				, UPPER(p.nombreBreve) producto
				, UPPER(um.abr) um
				, ved.cant
				, ved.precio precio
				, ved.subTotal
				, 1 foto
				, p.idProducto
				, ve.idEtapaVenta as etapa
			FROM 
				pg.presellers.ventas ve 
				JOIN pg.presellers.venta_detalle ved 
					ON ved.idVenta = ve.idVenta 
				JOIN pg.dbo.producto p 
					ON p.idProducto = ved.idProducto
				LEFT JOIN pg.presellers.unidadMedida um 
					ON um.idUnidadMedida = ved.idUnidadMedida
				JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
				JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
				JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
				JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
				JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo
				JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
				JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
				AND u.demo=0
				JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
				AND uh.idUsuarioTipo in (6,9)
				AND ve.fecPreventa BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecPreventa)
				AND uh.estado=1
			WHERE
				ve.fecPreventa BETWEEN @fecIni AND @fecFin
				AND ve.estado=1 
				AND ve.idEtapaVenta IN (1)
				{$filtros}
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}

	function getSurte($params){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT DISTINCT
				ts.idTipoSurte
				, ts.nombre tipoSurte
				, s.idLineaSurte
				, s.nombre surte
				--
				, lds.idUnidadMedida
				, lds.cantidad
			FROM 
				pg.presellers.lista_surte ls
				JOIN pg.presellers.lista_detalle_surte lds ON lds.idListaSurte = ls.idListaSurte
				JOIN pg.presellers.tipo_surte ts ON ts.idTipoSurte = lds.idTipoSurte
				JOIN pg.presellers.lineas_surte s ON s.idLineaSurte = lds.idLineaSurte
			WHERE
				(
					ls.fecIni <= ISNULL( ls.fecfin, @fecFin)
					AND (
						ls.fecIni BETWEEN @fecIni AND @fecFin
						OR
						ISNULL( ls.fecfin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN ls.fecIni AND ISNULL( ls.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN ls.fecIni AND ISNULL( ls.fecFin, @fecFin )
					)	
				) AND lds.estado = 1
			ORDER BY tipoSurte, surte ASC
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.lista_surte' ];
		return $this->db->query($sql);
	}
	
	function get_modulo_configuracion($params,$modulo){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT idTipo, valor, monto_gana  FROM pg.presellers.configuracion c WHERE c.idModulo = ".$modulo." AND c.estado = 1 
			AND (
				c.fecIni <= ISNULL(c.fecFin, @fecFin )
				AND (
					c.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( c.fecfin, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN c.fecIni AND ISNULL( c.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN c.fecIni AND ISNULL( c.fecFin, @fecFin )
				)	
			)";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.configuracion' ];
		return $this->db->query($sql);
	}
	
	function getSurteConfiguracion($params){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT 
				* 
			FROM pg.presellers.surte_configuracion sc
				WHERE
					(
						sc.fecIni <= ISNULL( sc.fecfin, @fecFin)
						AND (
							sc.fecIni BETWEEN @fecIni AND @fecFin 
							OR
							ISNULL( sc.fecfin, @fecFin ) BETWEEN @fecIni AND @fecFin 
							OR
							@fecIni BETWEEN sc.fecIni AND ISNULL( sc.fecFin, @fecFin ) 
							OR
							@fecFin BETWEEN sc.fecIni AND ISNULL( sc.fecFin, @fecFin )
						)	
					)
			ORDER BY montoEscala DESC
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.surte_configuracion' ];
		return $this->db->query($sql);
	}
	
	function getSurteData($params,$filtros,$filtros_join){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
				SELECT 
	  idPlaza
	, nombrePlaza
	, idSucursal
	, codigoPG
	, nombreTipoPlan
	, nombreCliente
	, nombreSucursal
	, cuota
	, idVenta
	, total_real
	, idTipoSurte
	, idLineaSurte
	, surte
	, idDetVenta
	, cant_real
	--, subTotal_real	
	, por_visibilidad
	, cantidad_final
	, SUM (cantidad_final) OVER (PARTITION BY idTipoSurte, idLineaSurte,idSucursal) subTotal_real
FROM (
SELECT DISTINCT
	  idPlaza
	, nombrePlaza
	, idSucursal
	, codigoPG
	, nombreTipoPlan
	, nombreCliente
	, nombreSucursal
	, cuota
	, idVenta
	, total_real
	, idTipoSurte
	, idLineaSurte
	, surte
	, idDetVenta
	, cant_real
	, subTotal_real	
	, por_visibilidad
	, cantidad_final
	--, SUM (cantidad_final) OVER (PARTITION BY idLineaSurte,idSucursal) a
FROM (
SELECT DISTINCT
	  sc.idPlaza
	, sc.nombrePlaza
	, sc.idSucursal
	, sc.nombreSucursal
	, su.codigoPG
	, sc.nombreTipoPlan
	, sc.nombreCliente
	, sc.cuota
	, ve.idVenta
	, ve.total_real
	, ts.idTipoSurte
	, ls.idLineaSurte
	, ls.nombre surte
	, ved.idDetVenta
	, ved.idProducto
	, ved.cant_real
	, ved.subTotal_real	
	, svi.porcentaje por_visibilidad
	, ld.cantidad
	, CASE WHEN psu.cantidad=NULL AND psu1.cantidad=NULL THEN ved.cant_real ELSE (psu.cantidad*ved.cant)/psu.cantidad END cantidad_final
				FROM 
					pg.presellers.sucursal_configuracion sc
					JOIN pg.mayorista.sucursal su ON su.idSucursal = sc.idSucursal
					LEFT JOIN (
					SELECT ve.*, u.demo FROM 
						pg.presellers.ventas ve
						LEFT JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
						LEFT JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario AND uh.estado = 1 AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
						AND uh.idUsuarioTipo in (6,9)
					WHERE
						ve.fecVenta BETWEEN @fecIni AND @fecFin
						AND ve.estado=1 
						AND ve.idEtapaVenta = 2	 AND u.demo = 0
					
					)ve ON su.idSucursal = ve.idSucursal $filtros_join	
					LEFT JOIN pg.presellers.venta_detalle ved ON ved.idVenta = ve.idVenta  AND ved.estado = 1
					LEFT JOIN pg.dbo.producto p ON p.idProducto = ved.idProducto
					LEFT JOIN pg.presellers.detalle_lineas_surte dls ON dls.idProducto = p.idProducto AND dls.estado = 1
					LEFT JOIN pg.presellers.lineas_surte ls ON ls.idLineaSurte = dls.idLineaSurte
					LEFT JOIN pg.presellers.lista_detalle_surte ld ON ld.idLineaSurte = ls.idLineaSurte
						AND ld.estado = 1
					LEFT JOIN pg.presellers.lista_surte l ON l.idListaSurte = ld.idListaSurte
						AND ve.fecVenta BETWEEN l.fecIni AND ISNULL(l.fecFin,ve.fecVenta)
					LEFT JOIN pg.presellers.tipo_surte ts ON ts.idTipoSurte = ld.idTipoSurte
					LEFT JOIN pg.mayorista.unidadMedida um 
						ON um.idUnidadMedida = ved.idUnidadMedida
					LEFT JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
					LEFT JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
					LEFT JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
					LEFT JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
					JOIN pg.mayorista.plaza pl ON pl.idPlaza = sc.idPlaza
					JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
					JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
					JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
					LEFT JOIN pg.presellers.sucursal_visibilidad svi ON su.idSucursal = svi.idSucursal AND svi.estado = 1
						AND (
							svi.fecIni <= ISNULL( svi.fecfin, @fecFin)
							AND (
								svi.fecIni BETWEEN @fecIni AND @fecFin 
								OR
								ISNULL( svi.fecfin, @fecFin ) BETWEEN @fecIni AND @fecFin 
								OR
								@fecIni BETWEEN svi.fecIni AND ISNULL( svi.fecfin, @fecFin ) 
								OR
								@fecFin BETWEEN svi.fecIni AND ISNULL( svi.fecfin, @fecFin )
							)	
						)
					LEFT JOIN pg.presellers.productos_surte_unidades psu
						ON psu.idProducto=ved.idProducto 
						AND psu.idUnidadMedida = ved.idUnidadMedida
					LEFT JOIN pg.presellers.productos_surte_unidades psu1
						ON psu1.idUnidadMedida = ld.idUnidadMedida
						AND psu1.idProducto = ved.idProducto
						
				WHERE
					(
						sc.fecIni <= ISNULL( sc.fefin, @fecFin)
						AND (
							sc.fecIni BETWEEN @fecIni AND @fecFin 
							OR
							ISNULL( sc.fefin, @fecFin ) BETWEEN @fecIni AND @fecFin 
							OR
							@fecIni BETWEEN sc.fecIni AND ISNULL( sc.feFin, @fecFin ) 
							OR
							@fecFin BETWEEN sc.fecIni AND ISNULL( sc.feFin, @fecFin )
						)	
					)
					AND sc.idTipoSucursal = 1
					$filtros
			)a	
			)b
			ORDER BY nombrePlaza, nombreSucursal ASC";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.sucursal_configuracion' ];
		return $this->db->query($sql);	
	}

	function getDetalleCobranzas( $params, $filtros ){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
	$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
		SELECT DISTINCT
			  idUnidad
			, unidad
			, idCiudad
			, ciudad
			, idPlaza
			, plaza
			, idTope
			, tope
			, idPlataforma
			, idUsuario
			, preseller
			, fecha_v
			, idCliente
			, cliente
			, catCliente
			, planCliente
			, codVenta
			, idVentaCobranza
			, monto
			, fecha fechaPago
			, total_real
			, SUM (monto) OVER(PARTITION BY codVenta ) amortizacion
			, imgCargoPs
			, imgBoletaTope
		FROM (	
			SELECT DISTINCT
				  z.idZona idUnidad
				, z.nombre unidad
				, ub_pl.cod_ubigeo idCiudad
				, ub_pl.provincia ciudad
				, pl.idPlaza
				, pl.nombre plaza
				, ve.idTopeSucursal idTope
				, UPPER(ve.nombreTopeSucursal) tope
				, ve.idTipoUsuario idPlataforma
				, u.idUsuario
				, UPPER(u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres) preseller
				, CONVERT(VARCHAR, ve.fecVenta, 103) fecha_v
				, ve.idSucursal idCliente
				, UPPER(ve.nombreSucursal) cliente
				, ve.nombreCategoriaCli catCliente
				, ve.nombreTipoPlan planCliente
				, ve.idVenta codVenta
				, vc.idVentaCobranza
				, vc.monto
				, vc.fecha
				, ve.total_real
				, vc.imgCargoPs
				, vc.imgBoletaTope
			FROM 
				pg.presellers.ventas ve 
				JOIN pg.presellers.venta_detalle ved 
					ON ved.idVenta = ve.idVenta 
					AND ved.estado = 1
				JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
				JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
				JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
				JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
				JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo
				JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
				JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
				AND u.demo=0
				JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
					AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
					AND uh.idUsuarioTipo in (6,9)
					AND uh.estado=1
				LEFT JOIN pg.presellers.tipo_pago tp ON tp.idTipoPago = ve.idTipoPago
				JOIN pg.presellers.venta_cobranza vc
					ON vc.idVenta = ve.idVenta
			WHERE
				vc.fecha BETWEEN @fecIni AND @fecFin
				AND ve.estado=1 
				AND ve.idEtapaVenta = 2
				{$filtros}
		)a	
				
		ORDER BY
			codVenta
			,fecha
	
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}
	
	function getDetalleVentaComprobante2( $filtros ){
		$sql = "
			
			SELECT DISTINCT
				  ve.idVenta codVenta
				, vd.numDoc numComp
				, vd.imgRef foto
				, td.nombre tipo	
			FROM 
				pg.presellers.ventas ve 
				JOIN pg.presellers.venta_detalle ved 
					ON ved.idVenta = ve.idVenta 
				JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
				JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
			WHERE 1=1
			{$filtros}
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}

	function getLomitoData($params,$filtros){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."', @today DATE = GETDATE();;
			WITH lista_ventas AS (
	SELECT DISTINCT
		v.*
		, vd.idDetVenta
		, vd.idProducto
		, vd.idUnidadMedida
		, vd.cant_real
		, vd.precio_real
		, vd.subTotal_real
	FROM 
		pg.presellers.ventas v
		JOIN pg.presellers.venta_detalle vd ON v.idVenta = vd.idVenta
	WHERE
		v.estado = 1  AND v.idEtapaVenta = 2 AND v.fecVenta BETWEEN @fecIni AND @fecFin
), lista_ventas_f AS (
	SELECT DISTINCT
		idPlaza
		, idUsuario
		, idTipoUsuario
		, idSucursal
		, nombreSucursal
		, idProducto
		, idUnidadMedida
		, SUM(cant_real) OVER (PARTITION BY idSucursal, idUsuario, idProducto, idUnidadMedida) cant_all
		, SUM(subTotal_real) OVER (PARTITION BY idSucursal, idUsuario, idProducto, idUnidadMedida) subTotal_all
	FROM lista_ventas
)
--
	SELECT 
		* 
		,SUM (CASE WHEN (a.cant_surte >= a.cant_req and row_linea = 1) THEN 1 ELSE 0 END) OVER (PARTITION BY a.idUsuario, a.idSucursal) total_presentes
		,SUM (CASE WHEN (a.cant_surte >= a.cant_req and row_linea = 1) THEN 1 ELSE 0 END) OVER (PARTITION BY a.idUsuario) total_surte
	FROM 
		(
			SELECT DISTINCT
				v.idPlaza
				,pl.nombre plaza
				,v.idUsuario
				,UPPER(u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres) usuario
				,v.idSucursal
				,v.nombreSucursal
				,lds.idTipoSurte
				,dls.idLineaSurte
				--,lis.nombre surte
				--,vd.idDetVenta
				, v.idProducto
				, v.cant_all cant_real 
				, v.subTotal_all subTotal_real
				, lds.cantidad cant_req
				, SUM (v.cant_all) OVER (PARTITION BY v.idUsuario, v.idSucursal, lds.idLineaSurte) cant_surte
				, CASE WHEN (v.cant_all >= lds.cantidad) THEN 1 ELSE 0 END presente
				, SUM (v.subTotal_all) OVER (PARTITION BY v.idUsuario, v.idSucursal) total_real
				, ucs.cuota10 
				, ucs.cuota20
				, ROW_NUMBER() OVER (PARTITION BY v.idUsuario, v.idSucursal, lds.idLineaSurte ORDER BY v.idProducto) row_linea
			FROM 
				lista_ventas_f v
				JOIN pg.acceso.usuario u ON u.idUsuario = v.idUsuario AND u.demo = 0
				--
				JOIN pg.presellers.detalle_lineas_surte dls ON dls.idProducto = v.idProducto AND dls.estado = 1
				JOIN pg.presellers.lista_detalle_surte lds ON lds.idLineaSurte = dls.idLineaSurte
					AND lds.idUnidadMedida = v.idUnidadMedida
				JOIN pg.presellers.lista_surte ls ON ls.idListaSurte = lds.idListaSurte
					AND General.dbo.fn_fechaVigente(ls.fecIni,ls.fecFin,@fecIni,@fecFin)='1'
				JOIN pg.presellers.lineas_surte lis ON lis.idLineaSurte = dls.idLineaSurte
				--
				JOIN pg.mayorista.plaza pl ON pl.idPlaza = v.idPlaza
				JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
				JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
				JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
				LEFT JOIN pg.presellers.usuario_configuracion_surte ucs ON ucs.idUsuario = v.idUsuario
					AND General.dbo.fn_fechaVigente(ucs.fecIni,ucs.fecFin,@fecIni,@fecFin)=1
			WHERE 1 = 1 {$filtros}
		)a
		ORDER BY a.usuario, a.idSucursal
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.detalle_lineas_surte' ];
		return $this->db->query($sql);
	}
	
	function getTopesxUsuario1( $params, $filtros, $filtros_join ){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			WITH lista_usuarios AS(
				SELECT DISTINCT
					u.idUsuario idUsuario
					, u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres  usuario
					, uhd.whls_idSucursal idSucursal 
					, uh.idUsuarioTipo idTipoUsuario
					, uc.cuota
				FROM	
					pg.acceso.usuario u 
					JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario AND uh.estado = 1 
						AND uh.idSistema = 8 AND uh.idUsuarioTipo IN (6,9) 
						AND(
							uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
							AND (
								uh.fecIni BETWEEN @fecIni AND @fecFin 
								OR
								ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
								OR
								@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin ) 
								OR
								@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
							)	
						)
					JOIN pg.acceso.usuarioHistDet uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
						AND uhd.fecIni <= ISNULL( uhd.fecFin, @fecFin)
						AND (
							uhd.fecIni BETWEEN @fecIni AND @fecFin 
							OR
							ISNULL( uhd.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
							OR
							@fecIni BETWEEN uhd.fecIni AND ISNULL( uhd.fecFin, @fecFin ) 
							OR
							@fecFin BETWEEN uhd.fecIni AND ISNULL( uhd.fecFin, @fecFin )
						)
						AND uhd.idCanal=1 AND uhd.estado=1 AND uhd.idCanalGrupo=3 
					JOIN pg.presellers.usuario_configuracion uc ON uc.idUsuario = u.idUsuario
						AND uc.fecIni <= ISNULL( uc.fecFin, @fecFin)
						AND (
							uc.fecIni BETWEEN @fecIni AND @fecFin 
							OR
							ISNULL( uc.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
							OR
							@fecIni BETWEEN uc.fecIni AND ISNULL(uc.fecFin,@fecFin) 
							OR
							@fecFin BETWEEN uc.fecIni AND ISNULL(uc.fecFin,@fecFin)
						)
					WHERE
						u.estado = 1
						AND u.demo = 0
						{$filtros_join}
			)
			/**/
			SELECT DISTINCT
				z.idZona idUnidad
				, z.nombre unidad
				, ub_pl.cod_ubigeo idCiudad
				, ub_pl.provincia ciudad
				, pl.idPlaza
				, pl.nombre plaza
				, su.idSucursal as idSucursal
				, UPPER(ISNULL( su.nomCom, cl.razonSocial )) as sucursal 
				, lu.idUsuario
				, lu.idTipoUsuario
				, lu.usuario
				, lu.cuota
				, SUM(lu.cuota) OVER () cuota_total
				, SUM(lu.cuota) OVER (PARTITION BY z.idZona) cuota_unidad
				, SUM(lu.cuota) OVER (PARTITION BY z.idZona, ub_pl.cod_ubigeo) cuota_ciudad
				, SUM(lu.cuota) OVER (PARTITION BY z.idZona, ub_pl.cod_ubigeo, pl.idPlaza) cuota_plaza
				, SUM(lu.cuota) OVER (PARTITION BY z.idZona, ub_pl.cod_ubigeo, pl.idPlaza, su.idSucursal) cuota_sucursal
			FROM
				pg.presellers.sucursal_configuracion sc
				JOIN pg.mayorista.sucursal su ON su.idSucursal = sc.idSucursal
				JOIN pg.mayorista.cliente cl ON su.idCliente = cl.idCliente
				JOIN pg.mayorista.plaza pl ON pl.idPlaza = su.idPlaza
				JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
				JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
				JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona AND z.estado = 1
				--
				JOIN lista_usuarios lu ON lu.idSucursal = su.idSucursal
				--
			WHERE
				sc.flagTope = 1
				AND (
					sc.fecIni <= ISNULL( sc.feFin, @fecFin)
					AND (
						sc.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( sc.feFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN sc.fecIni AND ISNULL( sc.feFin, @fecFin ) 
						OR
						@fecFin BETWEEN sc.fecIni AND ISNULL( sc.feFin, @fecFin )
					)
				)
				{$filtros}
			ORDER BY unidad, ciudad, plaza, sucursal ASC
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.sucursal_configuracion' ];
		return $this->db->query($sql);
	}

	public function p3m($params, $filtros){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql ="
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SET @fecIni =  CONVERT(DATE, CONVERT( VARCHAR(2), DAY(@fecIni) ) + '/' + CONVERT( VARCHAR(2), MONTH(@fecFin) ) + '/' +  CONVERT( VARCHAR(4), YEAR(@fecFin) ), 103);
			DECLARE @fecIni_1 DATE = DATEADD( mm,-3,@fecIni);
			DECLARE @fecFin_1 DATE = DATEADD( mm,-3,@fecFin); 
			DECLARE @fecIni_2 DATE = DATEADD( mm,-2,@fecIni);
			DECLARE @fecFin_2 DATE = DATEADD( mm,-2,@fecFin); 
			DECLARE @fecIni_3 DATE = DATEADD( mm,-1,@fecIni);
			DECLARE @fecFin_3 DATE = DATEADD( mm,-1,@fecFin);
			SELECT 
				*
			FROM (
				SELECT  
					*
					, SUM( venta ) OVER( PARTITION BY anio, mes ) ventaTotal
					, SUM( venta ) OVER( PARTITION BY anio, mes, idUnidad ) ventaUnidad
					, SUM( venta ) OVER( PARTITION BY anio, mes, idUnidad, idCiudad  ) ventaCiudad
					, SUM( venta ) OVER( PARTITION BY anio, mes, idUnidad, idCiudad, idPlaza  ) ventaPlaza
					, SUM( venta ) OVER( PARTITION BY anio, mes, idUnidad, idCiudad, idPlaza, idSucursal  ) ventaTope
					, SUM ( venta ) OVER( PARTITION BY anio, mes, idUnidad, idCiudad, idPlaza, idSucursal, idUsuario  ) ventaUsuario
				FROM (
					(
						SELECT 
							  z.idZona idUnidad 
							, ub_pl.cod_ubigeo idCiudad
							, pl.idPlaza
							, ve.idTopeSucursal idSucursal
							, uh.idUsuarioTipo idTipoUsuario
							, ve.idUsuario
							, YEAR(ve.fecVenta) anio
							, MONTH(ve.fecVenta) mes
							, ve.idVenta
							, ve.total_real venta
						FROM
							pg.presellers.ventas ve 
							JOIN pg.presellers.venta_detalle ved 
								ON ved.idVenta = ve.idVenta
								AND ved.estado = 1
							JOIN pg.dbo.producto p 
								ON p.idProducto = ved.idProducto
							LEFT JOIN pg.presellers.unidadMedida um 
								ON um.idUnidadMedida = ved.idUnidadMedida
							JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
							JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
							JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
							JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
							JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
							JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
							JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
							JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
							JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
							AND u.demo=0
							JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
							AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
							AND uh.estado=1
						WHERE
							ve.fecVenta BETWEEN @fecIni_1 AND @fecFin_1
							AND ve.estado=1 
							AND ve.idEtapaVenta = 2
							{$filtros}
					) UNION (
						SELECT 
							  z.idZona idUnidad 
							, ub_pl.cod_ubigeo idCiudad
							, pl.idPlaza
							, ve.idTopeSucursal idSucursal
							, uh.idUsuarioTipo idTipoUsuario
							, ve.idUsuario
							, YEAR(ve.fecVenta) anio
							, MONTH(ve.fecVenta) mes
							, ve.idVenta
							, ve.total_real venta
						FROM
							pg.presellers.ventas ve 
							JOIN pg.presellers.venta_detalle ved 
								ON ved.idVenta = ve.idVenta 
								AND ved.estado = 1
							JOIN pg.dbo.producto p 
								ON p.idProducto = ved.idProducto
							LEFT JOIN pg.presellers.unidadMedida um 
								ON um.idUnidadMedida = ved.idUnidadMedida
							JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
							JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
							JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
							JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
							JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
							JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
							JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
							JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
							JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
							AND u.demo=0
							JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
							AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
							AND uh.estado=1
						WHERE
							ve.fecVenta BETWEEN @fecIni_2 AND @fecFin_2
							AND ve.estado=1 
							AND ve.idEtapaVenta = 2
							{$filtros}
					) UNION (
						SELECT 
							  z.idZona idUnidad 
							, ub_pl.cod_ubigeo idCiudad
							, pl.idPlaza
							, ve.idTopeSucursal idSucursal
							, uh.idUsuarioTipo idTipoUsuario
							, ve.idUsuario
							, YEAR(ve.fecVenta) anio
							, MONTH(ve.fecVenta) mes
							, ve.idVenta
							, ve.total_real venta
						FROM
							pg.presellers.ventas ve 
							JOIN pg.presellers.venta_detalle ved 
								ON ved.idVenta = ve.idVenta 
								AND ved.estado = 1
							JOIN pg.dbo.producto p 
								ON p.idProducto = ved.idProducto
							LEFT JOIN pg.presellers.unidadMedida um 
								ON um.idUnidadMedida = ved.idUnidadMedida
							JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
							JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
							JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
							JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
							JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
							JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
							JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
							JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
							JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
							AND u.demo=0
							JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
							AND uh.idUsuarioTipo in (6,9)
							AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
							AND uh.estado=1
						WHERE
							ve.fecVenta BETWEEN @fecIni_3 AND @fecFin_3
							AND ve.estado=1 
							AND ve.idEtapaVenta = 2
							{$filtros}
					)
				)DATA
			)DATA1
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}

	function avance_ventas($params, $filtros,$filtros_join=NULL){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
				DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
				DECLARE @dif_mes int = DATEDIFF( month, @fecIni, @fecFin)
				IF( @dif_mes > 0 ) BEGIN SET @fecIni =  DATEADD(MONTH, DATEDIFF(MONTH, 0, @fecFin), 0)  END
				SELECT
					*
					, SUM( venta_final ) OVER() ventaTotal
					, SUM( venta_final ) OVER( PARTITION BY idUnidad ) ventaUnidad
					, SUM( venta_final ) OVER( PARTITION BY idUnidad, idCiudad  ) ventaCiudad
					, SUM( venta_final ) OVER( PARTITION BY idUnidad, idCiudad, idPlaza  ) ventaPlaza
					, SUM( venta_final ) OVER( PARTITION BY idUnidad, idCiudad, idPlaza, idSucursal  ) ventaTope
					, SUM( venta_final ) OVER( PARTITION BY idUnidad, idCiudad, idPlaza, idSucursal, idUsuario  ) ventaUsuario
				FROM (
					SELECT DISTINCT
						  idUnidad 
						, idCiudad
						, idPlaza
						, idSucursal
						, idTipoUsuario
						, idUsuario
						, idVenta
						, SUM(venta) OVER(PARTITION BY idVenta ) venta_final
					FROM (
						SELECT
							  z.idZona idUnidad
							, z.nombre unidad
							, ub_pl.cod_ubigeo idCiudad
							, ub_pl.provincia ciudad
							, pl.idPlaza
							, pl.nombre plaza
							, ve.idTopeSucursal idSucursal
							, UPPER(ve.nombreTopeSucursal) tope
							, ve.idTipoUsuario
							, ve.idUsuario
							, UPPER(u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres) preseller
							, CONVERT(VARCHAR, ve.fecPreventa, 103) fecha_pv
							, CONVERT(VARCHAR, ve.fecVenta, 103) fecha_v
							, DATEDIFF(d,ve.fecPreventa,ve.fecVenta) difDias
							, ve.idSucursal idCliente
							, UPPER(ve.nombreSucursal) cliente
							, ve.nombreCategoriaCli catCliente
							, ve.nombreTipoPlan planCliente
							, ve.idVenta
							, UPPER(ISNULL(pc.nombre, '-')) categoria
							, UPPER(ISNULL(mr.nombre, '-')) marca
							, p.codigoPG ean
							, UPPER(p.nombreBreve) producto
							, UPPER(um.abr) um
							, ved.cant_real cant
							, ved.precio_real precio
							, ved.subTotal_real venta
							, 1 foto
							, p.idProducto
						FROM
							pg.presellers.ventas ve 
						JOIN pg.presellers.venta_detalle ved 
							ON ved.idVenta = ve.idVenta 
							AND ved.estado = 1
						JOIN pg.dbo.producto p 
							ON p.idProducto = ved.idProducto
						LEFT JOIN pg.presellers.unidadMedida um 
							ON um.idUnidadMedida = ved.idUnidadMedida
						JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
						JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
						JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
						JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
						JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
						JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
						JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo
						JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
						JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
						AND u.demo=0
						JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
							AND uh.idUsuarioTipo in (6,9)
							AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
							AND uh.estado=1
						WHERE
							ve.fecVenta BETWEEN @fecIni AND @fecFin
							AND ve.estado=1 
							AND ve.idEtapaVenta = 2
							{$filtros}
							{$filtros_join}
					)DATA1
				)DATA
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}
	
	function getTiempo($params){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecFin DATE = '".$arrayFechas[1]."'
			SELECT 
				COUNT(1) diasUtiles 
				, COUNT( CASE WHEN ( fecha <= @fecFin ) THEN 1 END ) diaUtilActual
			FROM 
				General.dbo.tiempo WHERE anio = YEAR(@fecFin) AND idMes=MONTH(@fecFin) AND idDia <>7 AND idFeriado IS NULL
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.tiempo' ];
		return $this->db->query($sql);
	}

	public function categorias($params){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
            SELECT 
				  pc.idProductoCategoria
				, pc.nombre categoria
				, ccld.porcentajeCuota
				, ccld.comparteCuota
			FROM 
				pg.presellers.cuotaXCategoriaListDet ccld
				join pg.presellers.cuotaXCategoriaList ccl 
					on ccl.idCuotaCategoria=ccld.idCuotaCategoria
				join pg.dbo.productoCategoria pc 
					on pc.idProductoCategoria=ccld.idProductoCategoria
			WHERE 
				ccl.estado=1
				AND ccl.fecIni <= ISNULL( ccl.fecFin, @fecFin)
				AND (
					ccl.fecIni BETWEEN @fecIni AND @fecFin 
					OR
					ISNULL( ccl.fecIni, @fecFin ) BETWEEN @fecIni AND @fecFin 
					OR
					@fecIni BETWEEN ccl.fecIni AND ISNULL( ccl.fecFin, @fecFin ) 
					OR
					@fecFin BETWEEN ccl.fecIni AND ISNULL( ccl.fecFin, @fecFin )
				)
			order by categoria
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.cuotaXCategoriaListDet' ];
		return $this->db->query($sql);
	}

	function getFechas($params){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT DISTINCT
				anio
				, idMes
				, UPPER(mes) mes
			FROM
				General.dbo.tiempo
			WHERE
				fecha BETWEEN @fecIni AND @fecFin
			ORDER BY anio, idMes ASC
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.tiempo' ];
		return $this->db->query($sql);
	}

	public function ventas_x_categoria($params,$filtros){
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			SELECT DISTINCT 
				  tt.*
				, SUM(tt.ventaXCategoria) OVER(PARTITION BY tt.anio, tt.mes ) ventaXMesAnio 
			FROM(
				SELECT DISTINCT 
					  t.anio
					, t.mes
					, t.idProductoCategoria
					, SUM(t.total) OVER(PARTITION BY t.anio, t.mes, t.idProductoCategoria ) ventaXCategoria
					FROM (
						SELECT  
							  YEAR(ve.fecVenta) anio
							, MONTH(ve.fecVenta)mes
							, pc.idProductoCategoria
							, pc.nombre categoria
							, ve.idVenta
							, ved.idProducto
							, ved.subTotal_real total
						FROM 
							pg.presellers.ventas ve 
							JOIN pg.presellers.venta_detalle ved 
								ON ved.idVenta = ve.idVenta
								AND ved.estado = 1
							JOIN pg.dbo.producto p 
								ON p.idProducto = ved.idProducto
							JOIN pg.presellers.unidadMedida um 
								ON um.idUnidadMedida = ved.idUnidadMedida
							JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
							JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
							JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
							JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
							JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
							JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
							JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
							JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
							JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
								AND u.demo=0
							JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
								AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
								AND uh.idUsuarioTipo in (6,9)
								AND uh.estado=1
						WHERE 
							ve.fecVenta BETWEEN @fecIni AND @fecFin 
							AND ve.idEtapaVenta=2
							{$filtros}
					)t
			)tt
			order by tt.anio,tt.mes,tt.idProductoCategoria
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}
	
	public function promedio_ventas($params,$filtros){

		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$sql = "
			DECLARE @fecIni DATE = '".$arrayFechas[0]."', @fecFin DATE = '".$arrayFechas[1]."';
			DECLARE @dif_mes int = DATEDIFF( month, @fecIni, @fecFin)
			IF( @dif_mes < 3 ) BEGIN
				SET @fecIni = DATEADD( mm,-3,@fecIni);
			END
			SELECT DISTINCT
				  anio
				, mes
				, idCategoria
				, SUM(venta) OVER( PARTITION BY anio, mes, idCategoria ) ventaCategoria


			FROM (
				SELECT 
					  ve.idVenta
					, YEAR(ve.fecVenta) anio
					, MONTH(ve.fecVenta) mes
					, z.idZona idUnidad
					, z.nombre unidad
					, ub_pl.cod_ubigeo idCiudad
					, UPPER( ub_pl.provincia ) ciudad
					, uh.idUsuarioTipo idPlataforma
					, u.idUsuario
					, UPPER(u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres) usuario
					, ve.idSucursal idCliente
					, ve.nombreSucursal cliente
					, pc.idProductoCategoria idCategoria
					, pc.nombre categoria
					, mr.idMarca
					, mr.nombre marca
					, p.idProducto
					, p.codigoPG ean
					, p.nombre producto
					, ved.subTotal_real venta
				FROM 
					pg.presellers.ventas ve 
					JOIN pg.presellers.venta_detalle ved 
						ON ved.idVenta = ve.idVenta 
						AND ved.estado = 1
					JOIN pg.dbo.producto p 
						ON p.idProducto = ved.idProducto
					JOIN pg.presellers.unidadMedida um 
						ON um.idUnidadMedida = ved.idUnidadMedida
					JOIN pg.dbo.marca mr on mr.idMarca = p.idMarca
					JOIN pg.dbo.productoCategoria pc on pc.idProductoCategoria = p.idProductoCategoria
					JOIN pg.presellers.venta_documentos vd ON vd.idVenta = ve.idVenta
					JOIN pg.presellers.tipo_documento td ON td.idTipoDoc = vd.idTipoDoc
					JOIN pg.mayorista.plaza pl ON pl.idPlaza = ve.idPlaza
					JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo_1 --UBIGEO PLAZA
					JOIN pg.mayorista.zona_ubigeo zu ON zu.codUbigeo = pl.cod_ubigeo_1
					JOIN pg.mayorista.zona z ON  z.idZona = zu.idZona
					JOIN pg.acceso.usuario u ON ve.idUsuario = u.idUsuario
						AND u.demo=0
					JOIN pg.acceso.usuarioHist uh ON uh.idUsuario = u.idUsuario
						AND uh.idUsuarioTipo in (6,9)
						AND ve.fecVenta BETWEEN uh.fecIni AND ISNULL(uh.fecFin, ve.fecVenta)
						AND uh.estado=1
				WHERE
					ve.fecVenta BETWEEN @fecIni AND @fecFin
					AND ve.idEtapaVenta = 2
					{$filtros}
			)DATA
			ORDER BY idCategoria ASC
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.presellers.ventas' ];
		return $this->db->query($sql);
	}
	
	

}
