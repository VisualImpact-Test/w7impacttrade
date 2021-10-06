<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_storecheck extends MY_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function getPuntosDeVenta($fecha, $post = [])
	{
		$fechas = getPrimerYUltimoDia($fecha);

		if (empty($post)) {
			$aliasParaConsulta = [
				'cuenta' => 'cu.idCuenta',
				'proyecto' => 'py.idProyecto',
				'grupoCanal' => 'ca.idGrupocanal',
				'canal' => 'ca.idCanal',
				'cadena' => 'cd.idCadena'
			];
			$filtros = getPermisos($aliasParaConsulta);
		} else {
			$filtros = '';
			if (!empty($post['cuenta'])) $filtros .= ' AND cu.idCuenta = ' . $post['cuenta'];
			if (!empty($post['proyecto'])) $filtros .= ' AND py.idProyecto = ' . $post['proyecto'];
			if (!empty($post['grupoCanal'])) $filtros .= ' AND ca.idGrupocanal = ' . $post['grupoCanal'];
			if (!empty($post['canal'])) $filtros .= ' AND ca.idCanal = ' . $post['canal'];
			//if (!empty($post['cadena'])) $filtros .= ' AND cd.idCadena = ' . $post['cadena'];
		}

		$sql = "
			DECLARE @fecIni DATE= '" . $fechas[0] . "', @fecFin DATE= '" . $fechas[1] . "';
			SELECT DISTINCT
				c.idCliente, 
				c.razonSocial
			FROM trade.cliente c
				JOIN trade.cliente_historico_pg ch ON ch.idCliente = c.idCliente
				JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
				LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
														AND sn.estado = 1
				LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal
											AND ca.estado = 1
				LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno = ch.idSegClienteModerno
				LEFT JOIN trade.banner b ON b.idBanner = scm.idBanner
				LEFT JOIN trade.cadena cd ON cd.idCadena = b.idCadena
			WHERE 1 = 1
			AND fn.datesBetween(ch.fecIni, ch.fecFin, @fecIni, @fecFin) = 1
			AND c.estado = 1
			{$filtros}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];

		$sqlTest = "
			DECLARE @fecIni DATE= '01/01/2020', @fecFin DATE= '31/01/2020';
			SELECT DISTINCT 
				c.idCliente, 
				c.razonSocial
			FROM trade.cliente c
				JOIN trade.cliente_historico_pg ch ON ch.idCliente = c.idCliente
				JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
				JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
				LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
														AND sn.estado = 1
				LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal
											AND ca.estado = 1
				LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno = ch.idSegClienteModerno
				LEFT JOIN trade.banner b ON b.idBanner = scm.idBanner
				LEFT JOIN trade.cadena cd ON cd.idCadena = b.idCadena
			WHERE 1 = 1
				AND c.estado = 1
				AND cu.idCuenta = 3
				AND py.idProyecto = 2;
		";

		return $this->db->query($sql);
	}

	public function getInfoPuntoDeVenta($post)
	{
		$sql = "
			DECLARE @fecIni DATE= '" . $post['fechas'][0] . "', @fecFin DATE= '" . $post['fechas'][1] . "';
			SELECT DISTINCT 
				c.idCliente, 
				c.codCliente, 
				c.razonSocial, 
				cd.nombre cadena, 
				c.direccion
			FROM trade.cliente c
				INNER JOIN trade.cliente_historico_pg ch ON ch.idCliente = c.idCliente
				INNER JOIN trade.proyecto py ON py.idProyecto = ch.idProyecto
				INNER JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
				LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
				LEFT JOIN trade.canal ca ON ca.idCanal = sn.idCanal
				LEFT JOIN trade.segmentacionClienteModerno scm ON scm.idSegClienteModerno = ch.idSegClienteModerno
				LEFT JOIN trade.banner b ON b.idBanner = scm.idBanner
				LEFT JOIN trade.cadena cd ON cd.idCadena = b.idCadena
			WHERE fn.datesBetween(ch.fecIni, ch.fecFin, @fecIni, @fecFin) = 1
			AND c.idCliente = " . $post['idPuntoDeVenta'];
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}

	public function getVisitas($post)
	{
		$filtros='';
			if (!empty($post['cuenta'])) $filtros .= ' AND r.idCuenta = ' . $post['cuenta'];
			if (!empty($post['proyecto'])) $filtros .= ' AND r.idProyecto = ' . $post['proyecto'];

		$sql = "
			DECLARE @fecIni DATE= '" . $post['fechas'][0] ."', @fecFin DATE= '" . $post['fechas'][1] ."';
			SELECT v.idVisita, 
				r.fecha, 
				r.tipoUsuario, 
				r.nombreUsuario, 
					(CASE
						WHEN(v.horaFin IS NOT NULL
							AND (v.estadoIncidencia IS NULL
								OR v.estadoIncidencia = 0))
						THEN 1
						ELSE 0
					END) efectiva, 
				i.idIncidencia, 
				i.nombre incidencia, 
				vi.observacion, 
				vi.fotoUrl
			FROM trade.data_ruta r
				INNER JOIN trade.data_visita v ON r.idRuta = v.idRuta
				LEFT JOIN trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita
				LEFT JOIN master.incidencias i ON i.idIncidencia = vi.idIncidencia
			WHERE r.fecha BETWEEN @fecIni AND @fecFin
			AND r.demo = 0
			AND v.estado = 1
			AND v.idCliente =".$post['idPuntoDeVenta'] ." 
			{$filtros}
			ORDER BY v.idVisita DESC;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visita' ];
		return $this->db->query($sql);
	}

	public function getVisitasFotos($post)
	{
		$sql = "
			SELECT v.idVisita, 
				vmf.idVisitaModuloFoto, 
				r.fecha, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				ft.nombre fotoTipo, 
				vmf.hora, 
				vf.fotoUrl
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaModuloFotos vmf ON vmf.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vmf.idVisitaFoto
				LEFT JOIN trade.foto_tipo ft ON ft.idTipoFoto = vmf.idTipoFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids'].")
			ORDER BY v.idVisita DESC, 
					vmf.idVisitaModuloFoto;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaFotos' ];
		return $this->db->query($sql);
	}

	public function getVisitasPrecios($post)
	{
		$sql = "
			SELECT v.idVisita, 
				r.fecha, 
				vp.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				pro.idProducto, 
				pro.nombre producto, 
				m.idMarca, 
				m.nombre marca, 
				c.idCategoria, 
				c.nombre categoria, 
				vpd.precio
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaPrecios vp ON vp.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaPreciosDet vpd ON vpd.idVisitaPrecios = vp.idVisitaPrecios
				LEFT JOIN trade.producto pro ON pro.idProducto = vpd.idProducto
				LEFT JOIN trade.producto_marca m ON m.idMarca = pro.idMarca
				LEFT JOIN trade.producto_categoria c ON c.idCategoria = pro.idCategoria
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaPrecios' ];
		return $this->db->query($sql);
	}

	public function getVisitasEncuestas($post)
	{
		$sql = "
			SELECT DISTINCT 
				v.horaIni, 
				v.horaFin, 
				v.idVisita, 
				ved.idVisitaEncuestaDet, 
				r.fecha, 
				ve.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				e.idEncuesta, 
				e.nombre encuesta, 
				ep.idPregunta, 
				ep.nombre pregunta, 
				ep.idTipoPregunta, 
				tp.nombre tipoPregunta, 
				ea.idAlternativa, 
				ea.nombre alternativa, 
				ved.respuesta, 
				ve.idVisitaFoto, 
				ved.idVisitaFoto idVisitaFotoDet, 
				vf.fotoUrl, 
				vf2.fotoUrl fotoUrlDet
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaEncuesta ve ON ve.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaEncuestaDet ved ON ved.idVisitaEncuesta = ve.idVisitaEncuesta
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = ve.idVisitaFoto
				LEFT JOIN trade.data_visitaFotos vf2 ON vf2.idVisitaFoto = ved.idVisitaFoto
				LEFT JOIN trade.encuesta_pregunta ep ON ep.idPregunta = ved.idPregunta
				LEFT JOIN master.tipoPregunta tp ON tp.idTipoPregunta = ep.idtipoPregunta
				LEFT JOIN trade.encuesta_alternativa ea ON ea.idAlternativa = ved.idAlternativa
				LEFT JOIN trade.encuesta e ON e.idEncuesta = ep.idEncuesta
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					ved.idVisitaEncuestaDet, 
					e.idEncuesta;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaEncuesta' ];
		return $this->db->query($sql);
	}

	public function getVisitasSos($post)
	{

		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vsos.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vsos.idCategoria, 
				vsos.idVisitaFoto,
				vf.fotoUrl,
				vsos.numDet, 
				vsos.cm cmCategoria, 
				vsos.frentes frentesCategoria,
				vsosd.idVisitaSosDet,
				vsosd.cm cmDet, 
				vsosd.frentes frentesDet, 
				vsosd.flagCompetencia flagCompetenciaDet, 
				vsosd.idMarca idMarcaDet, 
				pc.nombre categoria, 
				pm.nombre marca
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaSos vsos ON vsos.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaSosDet vsosd ON vsosd.idVisitaSos = vsos.idVisitaSos
				LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = vsosd.idCategoria
				LEFT JOIN trade.producto_marca pm ON pm.idMarca = vsosd.idMarca
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vsos.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vsos.idCategoria;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaSos' ];
		return $this->db->query($sql);
	}

	public function getVisitasSod($post)
	{

		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vsod.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vsod.cant, 
				vsoddf.idVisitaFoto, 
				vf.fotoUrl, 
				vsod.idCategoria, 
				vsoddf.idMarca, 
				vsoddf.idTipoElementoVisibilidad, 
				pc.nombre categoria, 
				pm.nombre marca, 
				tev.nombre tipoElementoVisibilidad, 
				vsoddf.idVisitaSodDetFoto
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaSod vsod ON vsod.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaSodDetFotos vsoddf ON vsoddf.idVisitaSod = vsod.idVisitaSod
				LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = vsoddf.idCategoria
				LEFT JOIN trade.producto_marca pm ON pm.idMarca = vsoddf.idMarca
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vsoddf.idVisitaFoto
				LEFT JOIN trade.tipoElementoVisibilidad tev ON tev.idTipoElementoVisibilidad = vsoddf.idTipoElementoVisibilidad
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vsod.idCategoria;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaSod' ];
		return $this->db->query($sql);
	}

	public function getVisitasSeguimientoPlan($post)
	{

		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vsp.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vsp.numDet, 
				vspd.idVisitaSeguimientoPlanDet, 
				sp.nombre seguimientoPlan, 
				vspd.idTipoElementoVisibilidad, 
				tev.nombre tipoElementoVisibilidad, 
				vspd.armado, 
				vspd.revestido, 
				vspd.comentario, 
				vspd.idMotivo, 
				m.nombre motivo, 
				vspd.idMarca, 
				pm.nombre marca, 
				vf.fotoUrl,
				vfdet.fotoUrl fotoUrlDet
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaSeguimientoPlan vsp ON vsp.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaSeguimientoPlanDet vspd ON vspd.idVisitaSeguimientoPlan = vsp.idVisitaSeguimientoPlan
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vsp.idVisitaFoto
				LEFT JOIN trade.data_visitaFotos vfdet ON vfdet.idVisitaFoto = vspd.idVisitaFoto
				LEFT JOIN trade.tipoElementoVisibilidad tev ON tev.idTipoElementoVisibilidad = vspd.idTipoElementoVisibilidad
				LEFT JOIN trade.producto_marca pm ON pm.idMarca = vspd.idMarca
				LEFT JOIN trade.motivo m ON m.idMotivo = vspd.idMotivo
				LEFT JOIN trade.seguimientoPlan sp ON sp.idSeguimientoPlan = vsp.idSeguimientoPlan
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vspd.idVisitaSeguimientoPlanDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaSeguimientoPlan' ];
		return $this->db->query($sql);
	}

	public function getVisitasPromociones($post)
	{

		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vp.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vpd.idVisitaPromocionesDet, 
				p.nombre promocion, 
				tp.nombre tipoPromocion, 
				vpd.presencia, 
				vf.fotoUrl
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaPromociones vp ON vp.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaPromocionesDet vpd ON vpd.idVisitaPromociones = vp.idVisitaPromociones
				LEFT JOIN trade.promocion p ON p.idPromocion = vpd.idPromocion
				LEFT JOIN trade.tipoPromocion tp ON tp.idTipoPromocion = vpd.idTipoPromocion
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vpd.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vpd.idVisitaPromocionesDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaPromociones' ];
		return $this->db->query($sql);
	}

	public function getVisitasDespacho($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vd.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vdd.idVisitaDesapachosDet, 
				vdd.placa, 
				vdd.horaIni, 
				vdd.horaFin, 
				i.nombre incidencia, 
				vdd.comentario, 
				vf.fotoUrl
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaDespachos vd ON vd.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaDespachosDet vdd ON vdd.idVisitaDespachos = vd.idVisitaDespachos
				LEFT JOIN master.incidencias i ON i.idIncidencia = vdd.idIncidencia
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vdd.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vdd.idVisitaDesapachosDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaDespachos' ];
		return $this->db->query($sql);
	}

	public function getVisitasIniciativaTrad($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vit.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vitd.idVisitaIniciativaTradDet, 
				it.nombre iniciativaTrad, 
				eit.nombre elementoIniciativaTrad, 
				esit.nombre estadoIniciativa, 
				vf.fotoUrl
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaIniciativaTrad vit ON vit.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaIniciativaTradDet vitd ON vitd.idVisitaIniciativaTrad = vit.idVisitaIniciativaTrad
				LEFT JOIN trade.iniciativaTrad it ON it.idIniciativa = vitd.idIniciativa
				LEFT JOIN trade.elementoVisibilidadTrad eit ON eit.idElementoVis = vitd.idElementoIniciativa
				LEFT JOIN trade.estadoIniciativaTrad esit ON esit.idEstadoIniciativa = vitd.idEstadoIniciativa
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vitd.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN ( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vitd.idVisitaIniciativaTradDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaIniciativaTrad' ];
		return $this->db->query($sql);
	}

	public function getVisitasInteligenciaTrad($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vit.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vitd.idVisitaInteligenciaTradDet, 
				pc.nombre categoria, 
				pm.nombre marca, 
				ct.nombre tipoCompetencia, 
				vitd.comentario, 
				vf.fotoUrl, 
				vf.idVisitaFoto
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaInteligenciaTrad vit ON vit.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaInteligenciaTradDet vitd ON vitd.idVisitaInteligenciaTrad = vit.idVisitaInteligenciaTrad
				LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = vitd.idCategoria
				LEFT JOIN trade.producto_marca pm ON pm.idMarca = vitd.idMarca
				LEFT JOIN trade.competencia_tipo ct ON ct.idTipoCompetencia = vitd.idTipoCompetencia
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vitd.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vitd.idVisitaInteligenciaTradDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaInteligenciaTrad' ];
		return $this->db->query($sql);
	}

	public function getVisitasOrden($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				v.horaIni, 
				v.horaFin, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vf.fotoUrl, 
				vf.idVisitaFoto, 
				o.nombre orden, 
				oe.nombre ordenEstado, 
				vo.descripcion, 
				vo.flagOtro
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaOrden vo ON vo.idVisita = v.idVisita
				LEFT JOIN trade.orden o ON o.idOrden = vo.idOrden
				LEFT JOIN trade.orden_estado oe ON oe.idOrdenEstado = vo.idOrdenEstado
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vo.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaOrden' ];
		return $this->db->query($sql);
	}

	public function getVisitasVisibilidadTrad($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vvt.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vvt.idVisitaVisibilidad, 
				vvtd.idVisitaVisibilidadDet, 
				vvtd.idElementoVis, 
				evt.nombre elementoVisibilidadTrad, 
				tevt.idTipoElementoVis, 
				tevt.nombre tipoElementoVisibilidadTrad, 
				vvtd.presencia, 
				vvtd.cantidad, 
				vvtd.idEstadoElemento, 
				eev.nombre estadoElementoVisibilidad, 
				vvtd.condicion_elemento, 
				vf.fotoUrl, 
				vf.idVisitaFoto
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaVisibilidadTrad vvt ON vvt.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaVisibilidadTradDet vvtd ON vvtd.idVisitaVisibilidad = vvt.idVisitaVisibilidad
				LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis = vvtd.idElementoVis
				LEFT JOIN trade.tipoElementoVisibilidadTrad tevt ON tevt.idTipoElementoVis = evt.idTipoElementoVisibilidad
				LEFT JOIN trade.estadoElementoVisibilidad eev ON eev.idEstadoElemento = vvtd.idEstadoElemento
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vvtd.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vvtd.idVisitaVisibilidadDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaVisibilidadTrad' ];
		return $this->db->query($sql);
	}

	public function getVisitasCheckList($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vp.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vp.idVisitaProductos, 
				vpd.idVisitaProductosDet, 
				p.nombre producto, 
				pm.nombre marca, 
				pc.nombre categoria, 
				vpd.presencia, 
				vpd.quiebre, 
				vpd.stock, 
				um.nombre unidadMedida, 
				vpd.precio, 
				m.nombre motivo, 
				vf.fotoUrl, 
				vf.idVisitaFoto
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaProductos vp ON vp.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaProductosDet vpd ON vpd.idVisitaProductos = vp.idVisitaProductos
				LEFT JOIN trade.producto p ON p.idProducto = vpd.idProducto
				LEFT JOIN trade.producto_marca pm ON pm.idMarca = p.idMarca
				LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = p.idCategoria
				LEFT JOIN trade.unidadMedida um ON um.idUnidadMedida = vpd.idUnidadMedida
				LEFT JOIN trade.motivo m ON m.idMotivo = vpd.idMotivo
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vpd.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vpd.idVisitaProductosDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaProductos' ];
		return $this->db->query($sql);
	}

	public function getVisitasInventario($post)
	{
		$sql = "
			SELECT DISTINCT 
				r.fecha, 
				vi.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				v.idVisita, 
				vid.idVisitaInventarioDet, 
				vid.idProducto, 
				p.nombre producto, 
				pm.nombre marca, 
				pc.nombre categoria, 
				vid.stock_inicial, 
				vid.sellin, 
				vid.stock, 
				vid.validacion, 
				vid.obs, 
				vid.comentario, 
				vid.fecVenc
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaInventario vi ON vi.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaInventarioDet vid ON vid.idVisitaInventario = vi.idVisitaInventario
				LEFT JOIN trade.producto p ON p.idProducto = vid.idProducto
				LEFT JOIN trade.producto_marca pm ON pm.idMarca = p.idMarca
				LEFT JOIN trade.producto_categoria pc ON pc.idCategoria = p.idCategoria
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vid.idVisitaInventarioDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaInventario' ];
		return $this->db->query($sql);
	}

	public function getVisitasIpp($post)
	{
		$sql = "
			SELECT v.horaIni, 
				v.horaFin, 
				v.idVisita, 
				vid.idVisitaIppDet, 
				r.fecha, 
				vi.hora,
				vi.puntaje,
				vid.puntaje puntajeAlternativa,
				r.tipoUsuario, 
				r.nombreUsuario, 
				i.idIpp, 
				i.nombre ipp, 
				ip.idPregunta, 
				ip.nombre pregunta, 
				tp.idTipoPregunta, 
				tp.nombre tipoPregunta, 
				ic.idCriterio, 
				ic.nombre criterio, 
				ia.idAlternativa, 
				ia.nombre alternativa, 
				vf.idVisitaFoto, 
				vf.fotoUrl
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaIpp vi ON vi.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaIppDet vid ON vid.idVisitaIpp = vi.idVisitaIpp
				LEFT JOIN trade.ipp i ON i.idIpp = vi.idIpp
				LEFT JOIN trade.ipp_alternativa ia ON ia.idAlternativa = vid.idAlternativa
				LEFT JOIN trade.ipp_pregunta ip ON ip.idPregunta = vid.idPregunta
				LEFT JOIN trade.ipp_criterio ic ON ic.idCriterio = ip.idCriterio
				LEFT JOIN master.tipoPregunta tp ON tp.idTipoPregunta = ip.idTipoPregunta
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vi.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vid.idVisitaIppDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaIpp' ];
		return $this->db->query($sql);
	}

	public function getVisitasEncuestaPremio($post)
	{
		$sql = "
			SELECT v.horaIni, 
				v.horaFin, 
				v.idVisita, 
				vepd.idVisitaEncuestaDet, 
				r.fecha, 
				vep.hora, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				ep.idEncuesta, 
				ep.nombre encuestaPremio, 
				ep.descripcion descripcionEncuestaPremio, 
				ep.fechaInicio fechaInicioEncuestaPremio, 
				ep.fechaCaducidad fechaCaducidadEncuestaPremio, 
				epp.idPregunta, 
				epp.enunciado pregunta, 
				tp.idTipoPregunta, 
				tp.nombre tipoPregunta, 
				vf.idVisitaFoto, 
				vf.fotoUrl, 
				vepd.respuesta, 
				epa.idAlternativa, 
				epa.enunciado alternativa
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaEncuestaPremio vep ON vep.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaEncuestaPremioDet vepd ON vepd.idVisitaEncuesta = vep.idVisitaEncuesta
				LEFT JOIN trade.encuesta_premio_pregunta epp ON epp.idPregunta = vepd.idPregunta
				LEFT JOIN trade.encuesta_premio_alternativa epa ON epa.idAlternativa = CASE
					WHEN ISNUMERIC(vepd.respuesta) = 1
					THEN vepd.respuesta
					ELSE 0
				END
				LEFT JOIN master.tipoPregunta tp ON tp.idTipoPregunta = epp.idPreguntaTipo
				LEFT JOIN trade.encuesta_premio ep ON ep.idEncuesta = vep.idEncuesta
				LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto = vep.idVisitaFoto
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vepd.idVisitaEncuestaDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaEncuestaPremio' ];
		return $this->db->query($sql);
	}

	public function getVisitasVisibilidadAuditoriaObligatorio($post)
	{
		$sql = "
			SELECT v.horaIni, 
				v.horaFin, 
				v.idVisita, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				r.fecha, 
				vvo.idVisitaVisibilidad, 
				vvo.hora, 
				vvo.porcentaje, 
				vvo.porcentajeV, 
				vvo.porcentajePM, 
				vvod.idVisitaVisibilidadDet, 
				evt.idElementoVis, 
				evt.nombre elementoVisibilidad, 
				tevt.idTipoElementoVis, 
				tevt.nombre tipoElementoVisibilidad, 
				vv.idVariable, 
				vv.descripcion variable,
				vv.nomCorto variableNombreCorto,
				vvod.presencia, 
				oevi.idObservacion, 
				oevi.descripcion observacion, 
				vvod.comentario, 
				vvod.cantidad
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaVisibilidadObligatorio vvo ON vvo.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaVisibilidadObligatorioDet vvod ON vvod.idVisitaVisibilidad = vvo.idVisitaVisibilidad
				LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis = vvod.idElementoVis
				LEFT JOIN trade.tipoElementoVisibilidadTrad tevt ON tevt.idTipoElementoVis = evt.idTipoElementoVisibilidad
				LEFT JOIN trade.variableVisibilidad vv ON vv.idVariable = vvod.idVariable
				LEFT JOIN trade.observacionElementoVisibilidadIniciativa oevi ON oevi.idObservacion = vvod.idObservacion
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vvod.idVisitaVisibilidadDet, 
					vvod.idElementoVis, 
					vvod.idVariable;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaVisibilidadObligatorio' ];
		return $this->db->query($sql);
	}

	public function getVisitasVisibilidadAuditoriaIniciativa($post)
	{
		$sql = "
			SELECT v.horaIni, 
				v.horaFin, 
				v.idVisita, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				r.fecha, 
				vvi.idVisitaVisibilidad, 
				vvi.hora, 
				vvi.porcentaje, 
				vvid.idVisitaVisibilidadDet, 
				evt.idElementoVis, 
				evt.nombre elementoVisibilidad, 
				tevt.idTipoElementoVis, 
				tevt.nombre tipoElementoVisibilidad, 
				vvid.presencia, 
				vvid.comentario, 
				oevi.idObservacion, 
				oevi.descripcion observacion
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaVisibilidadIniciativa vvi ON vvi.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaVisibilidadIniciativaDet vvid ON vvid.idVisitaVisibilidad = vvi.idVisitaVisibilidad
				LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis = vvid.idElementoVis
				LEFT JOIN trade.tipoElementoVisibilidadTrad tevt ON tevt.idTipoElementoVis = evt.idTipoElementoVisibilidad
				LEFT JOIN trade.observacionElementoVisibilidadIniciativa oevi ON oevi.idObservacion = vvid.idObservacion
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vvid.idVisitaVisibilidadDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaVisibilidadIniciativa' ];
		return $this->db->query($sql);
	}

	public function getVisitasVisibilidadAuditoriaAdicional($post)
	{
		$sql = "
			SELECT v.horaIni, 
				v.horaFin, 
				v.idVisita, 
				r.tipoUsuario, 
				r.nombreUsuario, 
				r.fecha, 
				vva.idVisitaVisibilidad, 
				vva.hora, 
				vva.porcentaje, 
				vvad.idVisitaVisibilidadDet, 
				evt.idElementoVis, 
				evt.nombre elementoVisibilidad, 
				tevt.idTipoElementoVis, 
				tevt.nombre tipoElementoVisibilidad, 
				vvad.presencia, 
				vvad.comentario, 
				vvad.cant
			FROM trade.data_visita v
				INNER JOIN trade.data_visitaVisibilidadAdicional vva ON vva.idVisita = v.idVisita
				LEFT JOIN trade.data_visitaVisibilidadAdicionalDet vvad ON vvad.idVisitaVisibilidad = vva.idVisitaVisibilidad
				LEFT JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis = vvad.idElementoVis
				LEFT JOIN trade.tipoElementoVisibilidadTrad tevt ON tevt.idTipoElementoVis = evt.idTipoElementoVisibilidad
				INNER JOIN trade.data_ruta r ON r.idRuta = v.idRuta
			WHERE v.idVisita IN( ".$post['ids']." )
			ORDER BY v.idVisita DESC, 
					vvad.idVisitaVisibilidadDet;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.data_visitaVisibilidadAdicional' ];
		return $this->db->query($sql);
	}
}
