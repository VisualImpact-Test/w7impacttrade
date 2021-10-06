<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_iniciativas extends MY_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function obtener_lista_detallado_iniciativas($input=array()){
		$filtros = "";

			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';

			$filtros .= !empty($input['idCliente']) ? ' AND v.idCliente='.$input['idCliente'] : '';
			$filtros .= !empty($input['idDistribuidora']) ? ' AND d.idDistribuidora IN ('.$input['idDistribuidora'].')' : '';
			$filtros .= !empty($input['idElemento']) ? ' AND eit.idElementoVis IN ('.$input['idElemento'].')' : '';

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT
			r.idRuta
			, CONVERT(VARCHAR,r.fecha,103) AS fecha
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS supervisor
			, r.idUsuario
			, r.nombreUsuario
			, v.idVisita
			, v.canal
			, v.idCliente
			, v.codCliente
			, v.nombreComercial, v.razonSocial
			, v.cod_ubigeo
			, ubi.departamento
			, ubi.provincia
			, ubi.distrito
			, v.direccion
			, v.idPlaza
			, pl.nombre AS plaza
			, v.idDistribuidoraSucursal
			, ds.idDistribuidora
			, d.nombre AS distribuidora
			, ds.cod_ubigeo
			, ubi1.distrito AS ciudadDistribuidoraSuc
			, ubi1.cod_ubigeo AS codUbigeoDisitrito
			, vid.idIniciativa
			, it.nombre AS iniciativa
			, vid.idElementoIniciativa
			, eit.nombre AS elementoIniciativa
			, vid.presencia
			, vid.cantidad
			, vid.idEstadoIniciativa
			, esit.nombre AS motivo
			, vid.producto
			, vid.idVisitaFoto
			, vf.fotoUrl AS foto
			, vid.idVisitaIniciativaTradDet 
			, CONVERT(VARCHAR(8),vi.hora, 108) as hora
		FROM trade.data_ruta r
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		JOIN trade.data_visitaIniciativaTrad vi ON vi.idVisita=v.idVisita
		JOIN trade.canal ca ON ca.idCanal=v.idCanal
		LEFT JOIN trade.data_visitaIniciativaTradDet vid ON vid.idVisitaIniciativaTrad=vi.idVisitaIniciativaTrad
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.iniciativaTrad it ON it.idIniciativa=vid.idIniciativa
		LEFT JOIN trade.elementoVisibilidadTrad eit ON eit.idElementoVis=vid.idElementoIniciativa
		LEFT JOIN trade.estadoIniciativaTrad esit ON esit.idEstadoIniciativa=vid.idEstadoIniciativa
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=ec.idUsuario
		LEFT JOIN trade.data_visitaFotos vf ON vf.idVisitaFoto=vid.idVisitaFoto
		WHERE r.estado=1 AND v.estado=1 AND r.demo=0
		AND r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY  r.idUsuario, r.fecha ASC";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_consolidado_iniciativas($input=array()){
		$filtros = "";
			$filtros .= !empty($input['proyecto_filtro']) ? ' AND r.idProyecto='.$input['proyecto_filtro'] : '';
			$filtros .= !empty($input['grupoCanal_filtro']) ? ' AND ca.idGrupoCanal='.$input['grupoCanal_filtro'] : '';
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT DISTINCT
			data.idEncargado
			, data.idUsuarioSupervisor
			, data.usuarioSupervisor
			, data.total_supervisor_visitas
			, data.idUsuario
			, data.nombreUsuario
			, data.tipoUsuario
			, data.total_visitas
			, data.suma_visitas_iniciadas
			, data.suma_visitas_finalizadas
			, data.suma_visitas_no_finalizadas
			, data.total_visitas_incidencia
			, data.suma_visitas_iniciativas
		FROM(
			SELECT 
				r.fecha
				, r.idEncargado
				, en.idUsuario AS idUsuarioSupervisor
				, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS usuarioSupervisor
				, COUNT(us.idUsuario) OVER(PARTITION BY en.idUsuario) AS total_supervisor_visitas
				, r.idUsuario
				, r.nombreUsuario
				, r.idTipoUsuario
				, r.tipoUsuario
				, COUNT(r.idUsuario) OVER(PARTITION BY en.idUsuario,r.idUsuario) AS total_visitas
				, v.idCliente
				, v.horaIni, v.horaFin
				, SUM(CASE WHEN (v.horaIni IS NOT NULL) THEN 1 ELSE 0 END) OVER(PARTITION BY en.idUsuario, r.idUsuario) AS suma_visitas_iniciadas
				, SUM(CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL) THEN 1 ELSE 0 END) OVER(PARTITION BY ISNULl(en.idUsuario,1), r.idUsuario) AS suma_visitas_finalizadas
				, SUM(CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL) THEN 1 ELSE 0 END) OVER(PARTITION BY ISNULl(en.idUsuario,1), r.idUsuario) AS suma_visitas_no_finalizadas
				, v.estadoIncidencia
				, COUNT(CASE WHEN (v.estadoIncidencia=1) THEN 1 END) OVER(PARTITION BY en.idUsuario,r.idUsuario) AS total_visitas_incidencia
				, vit.idVisitaIniciativaTrad
				, SUM(CASE WHEN (vit.idVisitaIniciativaTrad IS NOT NULL) THEN 1 ELSE 0 END) OVER(PARTITION BY en.idUsuario, r.idUsuario) AS suma_visitas_iniciativas
			FROM trade.data_ruta r 
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			JOIN trade.canal ca ON ca.idCanal=v.idCanal
			LEFT JOIN trade.encargado en ON en.idEncargado=r.idEncargado
			LEFT JOIN trade.usuario us ON us.idUsuario=en.idUsuario
			LEFT JOIN trade.data_visitaIniciativaTrad vit ON vit.idVisita=v.idVisita
			WHERE r.estado=1 --AND r.demo=0
			AND v.estado=1
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
		) AS data
		ORDER BY data.idUsuarioSupervisor, data.idUsuario ASC
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_consolidado_implementacion($input=array()){
		$filtros = "";
			$filtros .= !empty($input['canal_filtro']) ? ' AND v.idCanal='.$input['canal_filtro'] : '';
		
		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT DISTINCT
			data.idUsuarioSupervisor
			, data.usuarioSupervisor
			, data.idUsuario
			, data.nombreUsuario
			, data.idElementoIniciativa
			, data.elementoIniciativa
			, data.suma_cantidad_elemento_iniciativa
		FROM(
			SELECT
				r.fecha
				, r.idEncargado
				, ISNULL(en.idUsuario,0) AS idUsuarioSupervisor
				, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS usuarioSupervisor
				, COUNT(us.idUsuario) OVER(PARTITION BY en.idUsuario) AS total_supervisor_visitas
				, r.idUsuario
				, r.nombreUsuario
				, r.idTipoUsuario
				, r.tipoUsuario
				, v.idCliente
				, v.horaIni, v.horaFin
				, v.estadoIncidencia
				, vit.idVisitaIniciativaTrad
				, vitd.idElementoIniciativa
				, eit.nombre AS elementoIniciativa
				, vitd.cantidad
				, SUM(vitd.cantidad) OVER(PARTITION BY en.idUsuario,r.idUsuario, vitd.idElementoIniciativa) AS suma_cantidad_elemento_iniciativa
			FROM trade.data_ruta r 
			JOIN trade.data_visita v ON v.idRuta=r.idRuta
			LEFT JOIN trade.encargado en ON en.idEncargado=r.idEncargado
			LEFT JOIN trade.usuario us ON us.idUsuario=en.idUsuario
			JOIN trade.data_visitaIniciativaTrad vit ON vit.idVisita=v.idVisita
			JOIN trade.data_visitaIniciativaTradDet vitd ON vitd.idVisitaIniciativaTrad=vit.idVisitaIniciativaTrad
			LEFT JOIN trade.elementoIniciativaTrad eit ON eit.idElementoIniciativa=vitd.idElementoIniciativa
			WHERE r.estado=1 --AND r.demo=0
			AND v.estado=1
			AND r.fecha BETWEEN @fecIni AND @fecFin
			{$filtros}
		) data
		ORDER BY data.idUsuarioSupervisor, data.idUsuario, data.idElementoIniciativa ASC";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_visita_detallado($input=array()){
		$filtros = "";
		$filtros .= ( isset($input['idSupervisor']) && !empty($input['idSupervisor']) ) ? ' AND en.idUsuario='.$input['idSupervisor'] : ' AND en.idUsuario IS NULL';
		$filtros .= ( isset($input['idUsuario']) && !empty($input['idUsuario']) ) ? ' AND r.idUsuario='.$input['idUsuario'] : '';
		
		if ( isset($input['tipoVisita']) && !empty($input['tipoVisita'])) {
			$filtros .= ( $input['tipoVisita'] == 'visitasIniciadas' ) ? ' AND v.horaIni IS NOT NULL' : '';
			$filtros .= ( $input['tipoVisita'] == 'visitasRealizadas' ) ? ' AND v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL' : '';
			$filtros .= ( $input['tipoVisita'] == 'visitasNoRealizadas' ) ? ' AND v.horaIni IS NULL AND v.horaFin IS NULL' : '';
			$filtros .= ( $input['tipoVisita'] == 'visitasConIncidencia' ) ? ' AND v.estadoIncidencia=1' : '';
			$filtros .= ( $input['tipoVisita'] == 'visitasIniciativas' ) ? ' AND vit.idVisitaIniciativaTrad IS NOT NULL' : '';
		}
				
		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT 
			CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idEncargado
			, en.idUsuario AS idUsuarioSupervisor
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS usuarioSupervisor
			, r.idUsuario
			, r.nombreUsuario
			, r.idTipoUsuario
			, r.tipoUsuario
			, v.idCliente
			, v.razonSocial
			, CONVERT(VARCHAR(8),v.horaIni) AS horaIni
			, CONVERT(VARCHAR(8),v.horaFin) AS horaFin
			, v.estadoIncidencia
			, v.canal
			, v.idDistribuidoraSucursal
			, d.nombre AS distribuidora
			, ubi.distrito AS ciudad
			, vit.idVisitaIniciativaTrad
		FROM trade.data_ruta r 
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		LEFT JOIN trade.encargado en ON en.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=en.idUsuario
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		LEFT JOIN trade.data_visitaIniciativaTrad vit ON vit.idVisita=v.idVisita
		WHERE r.estado=1 --AND r.demo=0
		AND v.estado=1
		AND r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY en.idUsuario, r.idUsuario, r.fecha ASC";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_visita_elementos($input=array()){
		$filtros = "";
		$filtros .= ( isset($input['idSupervisor']) && !empty($input['idSupervisor']) ) ? ' AND en.idUsuario='.$input['idSupervisor'] : ' AND en.idUsuario IS NULL';
		$filtros .= ( isset($input['idUsuario']) && !empty($input['idUsuario']) ) ? ' AND r.idUsuario='.$input['idUsuario'] : '';
		$filtros .= ( isset($input['idElementoIniciativa']) && !empty($input['idElementoIniciativa']) ) ? ' AND vitd.idElementoIniciativa='.$input['idElementoIniciativa'] : '';
		
		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		SELECT
			CONVERT(VARCHAR,r.fecha,103) AS fecha
			, r.idEncargado
			, ISNULL(en.idUsuario,0) AS idUsuarioSupervisor
			, us.nombres+' '+us.apePaterno+' '+us.apeMaterno AS usuarioSupervisor
			, r.idUsuario
			, r.nombreUsuario
			, r.idTipoUsuario
			, r.tipoUsuario
			, v.idCliente
			, v.razonSocial
			, CONVERT(VARCHAR(8),v.horaIni) AS horaIni
			, CONVERT(VARCHAR(8),v.horaFin) AS horaFin
			, v.estadoIncidencia
			, v.canal
			, v.idDistribuidoraSucursal
			, d.nombre AS distribuidora
			, ubi.distrito AS ciudad
			, vit.idVisitaIniciativaTrad
			, vitd.idElementoIniciativa
			, eit.nombre AS elementoIniciativa
			, vitd.presencia
			, vitd.cantidad
		FROM trade.data_ruta r 
		JOIN trade.data_visita v ON v.idRuta=r.idRuta
		LEFT JOIN trade.encargado en ON en.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario us ON us.idUsuario=en.idUsuario
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
		JOIN trade.data_visitaIniciativaTrad vit ON vit.idVisita=v.idVisita
		JOIN trade.data_visitaIniciativaTradDet vitd ON vitd.idVisitaIniciativaTrad=vit.idVisitaIniciativaTrad
		LEFT JOIN trade.elementoIniciativaTrad eit ON eit.idElementoIniciativa=vitd.idElementoIniciativa
		WHERE r.estado=1 --AND r.demo=0
		AND v.estado=1
		AND r.fecha BETWEEN @fecIni AND @fecFin
		{$filtros}
		ORDER BY en.idUsuario, r.idUsuario, r.fecha, vitd.idElementoIniciativa ASC
		";

		return $this->db->query($sql)->result_array();
	}


	public function obtener_lista_ejecutivos($input=array()){
		$filtros = "";

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		select 
		u_c.idUsuario as idEjecutivo ,
		u_c.apePaterno + ' '+u_c.apeMaterno+ ' '+u_c.nombres as ejecutivo,
		u.idUsuario as idGTM ,
		u.apePaterno + ' '+u.apeMaterno+ ' '+u.nombres as gtm,
		ut.idTipoUsuario
		from trade.data_visitaIniciativaTradDet vit
		JOIN trade.data_visitaIniciativaTrad vi ON vi.idVisitaIniciativaTrad=vit.idVisitaIniciativaTrad
		JOIN trade.data_visita v ON v.idVisita=vi.idVisita
		JOIN trade.data_ruta r ON r.idRuta=v.idRuta
		JOIN trade.usuario u ON u.idUsuario=r.idUsuario
		JOIN trade.usuario_historico uh ON uh.idUsuario=r.idUsuario 
			AND (
			uh.fecIni <= ISNULL( uh.fecFin, @fecFin)
			AND (
			uh.fecIni BETWEEN @fecIni AND @fecFin
			OR
			ISNULL( uh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
			OR
			@fecIni BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
			OR
			@fecFin BETWEEN uh.fecIni AND ISNULL( uh.fecFin, @fecFin )
			))
		JOIN trade.usuario_tipo ut ON ut.idTipoUsuario=uh.idTipoUsuario
		LEFT JOIN trade.encargado ec ON ec.idEncargado=r.idEncargado
		LEFT JOIN trade.usuario u_c ON u_c.idUsuario=ec.idEncargado
		where vit.idVisitaIniciativaTradDet IN ( ".$input['elementos_det']." )
		{$filtros}";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_detallado_pdf($input=array()){
		$filtros = "";

		$sql = "
		DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
		select 
			gc.idGrupoCanal,
			gc.nombre as grupoCanal,
			c.idCanal,
			c.nombre as canal,
			ds.idDistribuidoraSucursal,
			d.nombre + ' - ' + ubi.distrito as distribuidoraSucursal,
			v.idCliente,
			ch.razonSocial,
			ch.codCliente,
			r.idUsuario,
			u.apePaterno+' '+u.apeMaterno+' '+u.nombres as empleado,
			CONVERT(VARCHAR(10),r.fecha,103) as fecha,
			CONVERT(VARCHAR(8),vi.hora, 108) as hora,
			vit.idIniciativa,
			ini.nombre as iniciativa,
			vit.idVisitaIniciativaTradDet,
			evt.idElementoVis,
			evt.nombre as elemento,
			vit.presencia,
			esit.idEstadoIniciativa AS idMotivo,
			esit.nombre as motivo,
			vit.cantidad,

			vit.idVisitaFoto,
			vit.producto,
			dvf.fotoUrl

		from trade.data_visitaIniciativaTradDet vit
		JOIN trade.data_visitaIniciativaTrad vi ON vi.idVisitaIniciativaTrad=vit.idVisitaIniciativaTrad
		JOIN trade.data_visita v ON v.idVisita=vi.idVisita
		JOIN trade.data_ruta r ON r.idRuta=v.idRuta 
		JOIN trade.usuario u ON u.idUsuario=r.idUsuario
		JOIN trade.cliente_historico_pg ch ON ch.idCliente=v.idCliente  
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

		JOIN trade.canal c ON c.idCanal =  v.idCanal
		JOIN trade.grupoCanal gc ON gc.idGrupoCanal =  c.idGrupoCanal
		JOIN trade.iniciativaTrad ini ON ini.idIniciativa=vit.idIniciativa
		JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=vit.idElementoIniciativa
		LEFT JOIN trade.estadoIniciativaTrad esit ON esit.idEstadoIniciativa=vit.idEstadoIniciativa
		LEFT JOIN trade.data_visitaFotos dvf ON dvf.idVisitaFoto=vit.idVisitaFoto

		LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=v.cod_ubigeo
		LEFT JOIN trade.plaza pl ON pl.idPlaza=v.idPlaza
		LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal=v.idDistribuidoraSucursal
		LEFT JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo
		where vit.idVisitaIniciativaTradDet IN ( ".$input['elementos_det']." )
		{$filtros}";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_distribuidoras($input=array()){
		$sql = "
			SELECT idDistribuidora, nombre
			FROM trade.distribuidora
			WHERE estado = 1
			ORDER BY nombre
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_clientes($input=array()){
		$filtro = "";
			if( !empty($input['idCuenta']) ) $filtro .= "AND ch.idCuenta = {$input['idCuenta']}";

		$sql = "
			DECLARE @fecha DATE=GETDATE();

			SELECT
				ch.idCliente, ch.razonSocial
			FROM trade.cliente_historico_pg ch
			WHERE @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin, @fecha)
			AND ch.estado = 1 {$filtro}
			ORDER BY ch.razonSocial
		";

		return $this->db->query($sql)->result_array();
	}

	public function obtener_elementos($input=array()){
		$filtro = "";
			if( !empty($input['idCuenta']) ) $filtro .= " AND p.idCuenta = {$input['idCuenta']}";

		$sql = "
			SELECT DISTINCT
				ele.idElementoVis, ele.nombre 
			FROM trade.elementoVisibilidadTrad ele
			JOIN trade.proyecto p ON p.idProyecto = ele.idProyecto
			WHERE ele.estado = 1{$filtro}
			ORDER BY ele.nombre;
		";

		return $this->db->query($sql)->result_array();
	}
}
?>