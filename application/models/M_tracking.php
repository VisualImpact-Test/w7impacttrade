<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tracking extends MY_Model{

	public function __construct(){
		parent::__construct();
	}

	public function obtener_visitas($input = []){
		$sessIdCuenta = $this->sessIdCuenta;
		$sessIdProyecto = $this->sessIdProyecto;

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		$filtros = "";
            if( !empty($sessIdCuenta) ) $filtros .= " AND r.idCuenta = ".$sessIdCuenta;
            if( !empty($sessIdProyecto) ) $filtros .= " AND r.idProyecto = ".$sessIdProyecto;
			$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
			$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
			
			// DATOS DEMO
			if( $sessIdTipoUsuario != 4 ){
				if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
				else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
			}
		$sql = "
			DECLARE
				@fecIni date='{$input['fecIni']}',
				@fecFin date='{$input['fecFin']}';

			SELECT DISTINCT 
				r.fecha fecha
				, r.idUsuario cod_usuario
				, r.nombreUsuario
				, CONVERT(VARCHAR(8), v.horaIni) hora_ini
				, CONVERT(VARCHAR(8), v.horaFin) hora_fin
				, DATEDIFF(MINUTE,v.horaIni,v.horaFin) minutos
				, vi.nombreIncidencia indicencia_nombre
				, CASE 
					WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL  AND ISNULL(estadoIncidencia,0) <> 1 ) THEN 
					CASE 
						WHEN r.fecha BETWEEN '01/10/2021' AND '15/10/2021' THEN 3 --Efectiva
						ELSE 
							CASE 
							WHEN v.numFotos >=1 THEN 3 --Efectiva
							ELSE 1 --No efectiva
							END
					END 
					WHEN (v.estadoIncidencia = 1 ) THEN 2 --INCIDENCIA
					WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND ISNULL(v.numFotos,0) = 0  AND estadoIncidencia IS NULL ) THEN 0 -- No Visitado
					ELSE 1 --No Efectiva
					END condicion
				, v.idVisita
				, v.idCanal
				, v.canal
				, gc.nombre grupoCanal
				, gc.idGrupoCanal
				, LTRIM(RTRIM(ub.cod_departamento)) AS cod_departamento
				, ub.departamento ciudad
				, ub.cod_provincia
				, ub.provincia
				, ub.cod_distrito
				, ub.distrito
				, v.idCliente cod_visual
				, v.razonSocial
				, c.nombreComercial
				, c.direccion
				, v.numFotos fotos
				, v.frecuencia
				--
				, CASE WHEN (v.horaIni IS NULL) THEN 1 ELSE 0 END valHora
				, ISNULL(v.latIni,0) lati_ini
				, ISNULL(v.lonIni,0) long_ini
				, ISNULL(v.latFin,0) lati_fin
				, ISNULL(v.lonFin,0) long_fin
				, ISNULL(c.latitud,0) latitud
				, ISNULL(c.longitud,0) longitud
				, ISNULL(vi.idIncidencia,0) idTipoIncidencia
				, CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND vi.nombreIncidencia IS NULL ) OR (v.estadoIncidencia=0) THEN 1 ELSE 0 END as PDV_EFECTIVO
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL AND vi.nombreIncidencia IS NOT NULL) OR (v.estadoIncidencia=1) THEN 1 ELSE 0 END as PDV_NO_VISITADO
				, CASE WHEN (v.estadoIncidencia = 0) OR(v.estadoIncidencia IS NOT NULL)  THEN 1 ELSE 0 END as PDV_INCIDENCIA
				, CASE WHEN (v.horaIni IS NULL AND v.horaFin IS NULL) THEN 1 ELSE 0 END as PDV_SINVISITA
				, c.codCliente
				, vi.fotoUrl incidencia_foto
				, vi.nombreIncidencia incidencia_nombre
				, CONVERT(VARCHAR(8), vi.hora) incidencia_hora
				, vi.observacion incidencia_obs
				, r.idTipoUsuario
				, r.tipoUsuario
				, map.id_anychartmaps idMap
				----
				,MIN(CASE WHEN horaIni IS NOT NULL THEN CONVERT(TIME(0),horaIni) ELSE NULL END) OVER (PARTITION BY r.idRuta) horaIni_primera_visita
				,MIN(CASE WHEN horaIni IS NOT NULL THEN CONVERT(TIME(0),horaFin) ELSE NULL END) OVER (PARTITION BY r.idRuta) horaFin_primera_visita
				,MAX(CASE WHEN horaIni IS NOT NULL THEN CONVERT(TIME(0),horaIni) ELSE NULL END) OVER (PARTITION BY r.idRuta) horaIni_ultima_visita
				,MAX(CASE WHEN horaIni IS NOT NULL THEN CONVERT(TIME(0),horaFin) ELSE NULL END) OVER (PARTITION BY r.idRuta) horaFin_ultima_visita
				,SUM(CASE WHEN horaIni IS NOT NULL AND horaFin IS NOT NULL THEN 1 ELSE 0 END ) OVER (PARTITION BY r.idRuta) visitados
				,SUM(CASE WHEN v.estadoIncidencia = 1 THEN 1 ELSE 0 END ) OVER (PARTITION BY r.idRuta) incidencias
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta 
			LEFT JOIN General.dbo.ubigeo ub ON v.cod_ubigeo = ub.cod_ubigeo
			LEFT JOIN {$this->sessBDCuenta}.trade.data_asistencia a ON a.idUsuario = r.idUsuario AND r.fecha = a.fecha AND a.idTipoAsistencia = 1
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaIncidencia vi ON vi.idVisita = v.idVisita
			JOIN trade.cliente c ON c.idCliente = v.idCliente
			LEFT JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente 
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
			) AND ch.idProyecto = {$sessIdProyecto}
			JOIN trade.canal ca ON ca.idCanal = v.idCanal
			LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.cliente_tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo
			LEFT JOIN trade.grupoCanal gc ON ca.idGrupoCanal = gc.idGrupoCanal
			JOIN trade.cuenta cu ON cu.idCuenta = r.idCuenta
			LEFT JOIN master.anychartmaps_ubigeo map ON map.cod_departamento = ub.cod_departamento 
			WHERE 
			r.fecha BETWEEN @fecIni AND @fecFin 
			AND v.estado = 1 AND r.estado = 1
			AND v.idTipoExclusion IS NULL
			{$filtros} 
			-- AND r.idRuta = 103419
			ORDER BY fecha , hora_ini  ASC
		";
		//echo $sql;
		return $this->db->query($sql)->result_array();
	}
	public function obtener_fotos_visita($input = [])
	{
		$sessIdCuenta = $this->sessIdCuenta;
		$sessIdProyecto = $this->sessIdProyecto;

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;

		$filtros = "";
            if( !empty($sessIdCuenta) ) $filtros .= " AND r.idCuenta = ".$sessIdCuenta;
            if( !empty($sessIdProyecto) ) $filtros .= " AND r.idProyecto = ".$sessIdProyecto;
			$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND r.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
			$filtros .= !empty($input['usuario_filtro']) ? ' AND r.idUsuario IN ('.$input['usuario_filtro'].')': '';
			
			// DATOS DEMO
			if( $sessIdTipoUsuario != 4 ){
				if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
				else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
			}
		$sql = "
			DECLARE
				@fecIni date='{$input['fecIni']}',
				@fecFin date='{$input['fecFin']}';

			SELECT DISTINCT 
				vf.*,
				amg.carpetaFoto,
				COUNT(vf.idVisitaFoto) OVER(PARTITION BY v.idVisita) cantFotos
			FROM {$this->sessBDCuenta}.trade.data_ruta r
			JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
			LEFT JOIN {$this->sessBDCuenta}.trade.data_visitaFotos vf ON vf.idVisita = v.idVisita
			LEFT JOIN trade.aplicacion_modulo am ON vf.idModulo = am.idModulo
			LEFT JOIN trade.aplicacion_modulo_grupo amg ON amg.idModuloGrupo = am.idModuloGrupo
			WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
			AND v.idTipoExclusion IS NULL
			{$filtros} 
		";
		return $this->db->query($sql)->result_array();
	}

	public function getLatestRuta()
	{
		$sql = "
		DECLARE
			@fecIni date= GETDATE(),
			@fecFin date= GETDATE();
		SELECT DISTINCT 
			r.idRuta,
			r.idUsuario,
			r.idTipoUsuario
		FROM {$this->sessBDCuenta}.trade.data_ruta r
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta
		WHERE r.fecha BETWEEN @fecIni AND @fecFin AND v.estado = 1 AND r.estado = 1
		AND v.horaIni IS NOT NULL
		AND v.idTipoExclusion IS NULL
		AND r.demo = 0
		AND r.idProyecto = {$this->sessIdProyecto}
		ORDER BY r.idRuta DESC
		";
		return $this->db->query($sql)->row_array();
	}

}
?>