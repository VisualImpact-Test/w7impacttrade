<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Fotos extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getTipoFotos()
	{
		$filtro = '';
			$filtro .= getPermisos('cuenta');
			$filtro .= getPermisos('proyecto');

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
			{$filtro}
		";

		return $this->db->query($sql);
	}

	public function getFotos($input){
		$fechas = getFechasDRP($input['txt-fechas']);

		$filtros = '';

			$input['idCuenta'] = $this->sessIdCuenta;
			$input['idProyecto'] = $this->sessIdProyecto;

			if(!empty($input['tipoFoto']) ) $filtros .= " AND mf.idTipoFoto = ".$input['tipoFoto'];

			$filtros .= !empty($input['idCuenta']) ? ' AND cu.idCuenta = '.$input['idCuenta'] : '';
			$filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto = '.$input['idProyecto'] : '';
			$filtros .= !empty($input['canal_filtro']) ? " AND ca.idCanal=".$input['canal_filtro'] : "";
			$filtros .= !empty($input['grupoCanal_filtro']) ? " AND gc.idGrupoCanal=".$input['grupoCanal_filtro'] : "";
			$filtros .= !empty($input['codCliente']) ? " AND ch.codCliente='".$input['codCliente']."'" : "";
			$filtros .= !empty($input['idClienteTipo']) ? " AND ct.idClienteTipo=".$input['idClienteTipo'] : "";

		$sql="
		DECLARE @fecIni date='".$fechas[0]."',@fecFin date='".$fechas[1]."';
		SELECT v.idVisita, 
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
			UPPER(r.tipoUsuario) tipoUsuario, 
			vf.idVisitaFoto, 
			tf.nombre tipoFoto, 
			vf.fotoUrl imgRef, 
			CONVERT(VARCHAR(8), vf.hora) horaFoto, 
			CONVERT(VARCHAR(8), v.horaIni) horaVisita,
			ct.idClienteTipo,
			ct.nombre AS cliente_tipo
		FROM trade.data_ruta r
			JOIN trade.data_visita v ON r.idRuta = v.idRuta
			JOIN trade.data_visitaFotos vf ON vf.idVisita = v.idVisita
			JOIN trade.data_visitaModuloFotos mf ON mf.idVisitaFoto = vf.idVisitaFoto
			JOIN trade.aplicacion_modulo m ON m.idModulo = vf.idModulo
			JOIN trade.foto_tipo tf ON tf.idTipoFoto = mf.idTipoFoto
			JOIN trade.cliente c ON v.idCliente = c.idCliente
			
			JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			JOIN trade.usuario u ON u.idUsuario = r.idUsuario
			JOIN trade.usuario_historico uh ON uh.idUsuario = U.idUsuario
												AND uh.estado = 1
			JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = uh.idTipoUsuario
			JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
			LEFT JOIN trade.banner bn ON bn.idBanner = v.idBanner
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario = r.idUsuario
			LEFT JOIN trade.encargado enc ON enc.idEncargado = sub.idEncargado
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
												AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, r.fecha)
												AND ch.flagCartera = 1
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ct ON ct.idClienteTipo = sn.idClienteTipo
			JOIN General.dbo.ubigeo ubi01 ON ch.cod_ubigeo = ubi01.cod_ubigeo
		WHERE r.fecha BETWEEN @fecIni AND @fecFin
			AND r.demo = 0
			AND v.estado = 1
			{$filtros}
		ORDER BY canal, 
				departamento, 
				provincia, 
				distrito, 
				razonSocial, 
				fecha, 
				tipoFoto ASC;
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
}
