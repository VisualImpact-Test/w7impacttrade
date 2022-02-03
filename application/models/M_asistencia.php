<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_asistencia extends MY_Model{

	var $CI;
	
	public function __construct(){
		parent::__construct();

		$this->CI =& get_instance();
	}

	public function obtener_usuarios_asistencia($input=array()){
		$filtros = "";$filtroTipoUsuario = '';
		$sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
		$bdcuenta = $this->sessBDCuenta;
		if(empty($input['cuenta_filtro'])){
			$filtros.= getPermisos('cuenta');
		}else{
		// $filtros .= !empty($input['idCuenta']) ? ' AND cu.idCuenta='.$input['idCuenta'] : '';
		// $filtros .= !empty($input['idProyecto']) ? ' AND py.idProyecto='.$input['idProyecto'] : '';
		$filtros .= !empty($input['cuenta_filtro']) ? ' AND cu.idCuenta='.$input['cuenta_filtro'] : '';
		$filtros .= !empty($input['proyecto_filtro']) ? ' AND py.idProyecto='.$input['proyecto_filtro'] : '';
		$filtros .= !empty($input['grupo_filtro']) ? ' AND  gc.idGrupoCanal='.$input['grupo_filtro'] : '';
		$filtros .= !empty($input['canal_filtro']) ? ' AND ca.idCanal='.$input['canal_filtro'] : '';
		$filtros .= !empty($input['tipoUsuario_filtro']) ? ' AND tu.idTipoUsuario='.$input['tipoUsuario_filtro'] : '';
		$filtros .= !empty($input['usuario_filtro']) ? ' AND u.idUsuario='.$input['usuario_filtro'] : '';
		$filtros .= !empty($input['distribuidora_filtro']) ? ' AND d.idDistribuidora='.$input['distribuidora_filtro'] : '';
		$filtros .= !empty($input['zona_filtro']) ? ' AND z.idZona='.$input['zona_filtro'] : '';
		$filtros .= !empty($input['plaza_filtro']) ? ' AND uhp.idPlaza='.$input['plaza_filtro'] : '';
		$filtros .= !empty($input['cadena_filtro']) ? ' AND cd.idCadena='.$input['cadena_filtro'] : '';
		$filtros .= !empty($input['banner_filtro']) ? ' AND b.idBanner='.$input['banner_filtro'] : '';
		$filtros .= !empty($input['zonausuario']) ? ' AND uhz.idZona='.$input['zonausuario'] : '';
		}

		// DATOS DEMO
		if( $sessIdTipoUsuario != 4 ){
			if( empty($sessDemo) ) $filtros .=  " AND u.demo = 0";
			else $filtros .=  " AND (u.demo = 0 OR u.idUsuario = {$this->idUsuario})";
		}
		$distribuidoras_usuario = getPermisosUsuario(['segmentacion'=>1]);
		!empty($distribuidoras_usuario) ? $filtros .= " AND ds.idDistribuidoraSucursal IN({$distribuidoras_usuario})" : '' ;

		$filtros .= !in_array($sessIdTipoUsuario,[8,13,14,4]) ? " AND tu.idTIpoUsuario NOT IN (8,13,14)" : "" ;
		
		$sql = "
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
			WITH lista_visita_inicio AS (
			SELECT DISTINCT
					r.fecha
					, r.idUsuario
					, v.horaIni
					, c.latitud
					, c.longitud
					, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaIni ASC ) row
					
				FROM 
					{$this->sessBDCuenta}.trade.data_ruta r
					JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta 
					JOIN trade.cliente c ON c.idCliente = v.idCliente
				WHERE
					r.fecha BETWEEN @fecIni AND @fecFin
					AND r.demo = 0 
					AND v.horaIni IS NOT NULL
					
		),lista_visita_final AS (
			SELECT DISTINCT
				r.fecha
				, r.idUsuario
				, v.horaFin
				, c.latitud
				, c.longitud
				, row_number() OVER (PARTITION BY r.idUsuario, r.fecha ORDER BY v.horaFin DESC ) row
			FROM 
				{$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v ON r.idRuta = v.idRuta 
				JOIN trade.cliente c ON c.idCliente = v.idCliente
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0 AND v.horaFin IS NOT NULL
				
		),lista_horario AS (
			SELECT 
				h.horaIngreso
				, h.horaSalida
				, h.horaProg
				, dh.idDia
				, dh.idCargoTrabajo
				, dh.idEmpleado
				, t.fecha
				, t.idFeriado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha BETWEEN @fecIni AND @fecFin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
		) 
		, lista_horario_empleado AS (
			SELECT DISTINCT
				dh.idEmpleado
			FROM 
				rrhh.asistencia.horarioAdmin h 
				JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
			WHERE
				h.estado = 1
				AND (
					dh.fecIni <= ISNULL( dh.fecFin, @fecFin)
					AND (
						dh.fecIni BETWEEN @fecIni AND @fecFin 
						OR
						ISNULL( dh.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
						OR
						@fecIni BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin ) 
						OR
						@fecFin BETWEEN dh.fecIni AND ISNULL( dh.fecFin, @fecFin )
					)
				) 
				AND dh.idEmpleado IS NOT NULL
		)	
		SELECT DISTINCT
			u.idUsuario
			, isnull(u.idEmpleado,u.numDocumento) idEmpleado
			, u.numDocumento
			, tu.idTipoUsuario
			, tu.nombre tipoUsuario
			, u.apePaterno+' '+u.apeMaterno+', '+u.nombres usuario
			, CONVERT(varchar(10),t.fecha,103) fecha
			, CONVERT(VARCHAR(8),t.fecha,112) fecha_id
			, cu.idCuenta
			, cu.nombre cuenta
			, py.idProyecto
			, py.nombre proyecto
			, gc.idGrupoCanal
			, gc.nombre grupoCanal
			, ca.idCanal
			, ca.nombre canal
			, t.feriado
			, toc.nombre ocurrencia
			, vd.idEmpleado vacaciones
			, u.estado         
			, ub.departamento
			, ub.provincia
			, ub.distrito
			, CONVERT(VARCHAR(8),vi.horaIni) horaIniVisita
			, ISNULL(vi.latitud,0) latiIniVisita
			, ISNULL(vi.longitud,0) longIniVisita
			, CONVERT(VARCHAR(8),vf.horaFin) horaFinVisita
			, ISNULL(vf.latitud,0) latiFinVisita
			, ISNULL(vf.longitud,0) longFinVisita
			, t.idDia  idDia
			, t.dia 
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
			, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
			, eq.numero movil
			, u_e.apePaterno+' '+u_e.apeMaterno+', '+u_e.nombres encargado
		FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
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
				)
			) 
			LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
			LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
			LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
			LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta

			LEFT JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
			--LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.empleado e ON e.numTipoDocuIdent = u.numDocumento 
			-- AND e.flag IN ('activo')
			LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
			
			
			LEFT JOIN General.dbo.tiempo t ON t.fecha BETWEEN @fecIni AND @fecFin
			
			
			LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado AND lh_1.fecha=t.fecha
			LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
			LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado  
			
			

			LEFT JOIN rrhh.asistencia.asistencia at ON e.idEmpleado=at.idEmpleado and at.fechaIngreso=t.fecha
			LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
			LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
				AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
			LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
			LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
				AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
			LEFT JOIN lista_visita_inicio vi ON vi.fecha = t.fecha AND u.idUsuario = vi.idUsuario AND vi.row = 1
			LEFT JOIN lista_visita_final vf ON vf.fecha = t.fecha AND u.idUsuario = vf.idUsuario AND vf.row = 1
			LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha)
				AND eq.idTipoEquipo=1
			
			LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario AND sub.estado=1
			LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
			LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
			LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
			LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
			LEFT JOIN trade.usuario_historicoZona uhz ON uhz.idUsuarioHist = uh.idUsuarioHist AND uhz.estado = 1
			LEFT JOIN trade.usuario_historicoPlaza uhp ON uhp.idUsuarioHist = uh.idUsuarioHist AND uhp.estado = 1
			LEFT JOIN trade.zona z ON z.idZona = uhz.idZona AND z.estado = 1
			LEFT JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist AND uhb.estado = 1
			LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner AND b.estado = 1
		WHERE
			uh.idAplicacion IN (1, 4, 8)
			$filtros
			
		ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, usuario, fecha ASC";

		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $result;
	}

	public function obtener_asistencias($input=array()){
		$filtros = "";

		$sql = "
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
			SELECT 
				CONVERT(VARCHAR(8),a.fecha,112) fecha_id
				,a.idUsuario, a.fecha
				, CONVERT(varchar(10),a.fecha,103) fechaFormato
				, CONVERT(VARCHAR(8),a.hora) hora
				, ISNULL(a.latitud,0) latitud
				, ISNULL(a.longitud,0) longitud
				, a.fotoUrl foto
				, a.idTipoAsistencia
				, tia.nombre tipoAsistencia
				, a.observacion                  
				, oc.idOcurrencia
				, oc.nombre ocurrencia
			FROM 
				{$this->sessBDCuenta}.trade.data_asistencia a
				JOIN General.dbo.tiempo ti ON a.fecha = ti.fecha
				JOIN master.tipoAsistencia tia ON a.idTipoAsistencia=tia.idTipoAsistencia
				LEFT JOIN master.ocurrencias oc ON oc.idOcurrencia=a.idOcurrencia AND oc.estado=1 AND oc.flagAsistencia=1
			WHERE
				a.fecha BETWEEN @fecIni AND @fecFin --AND a.demo = 0
			ORDER BY  fecha_id, idUsuario DESC";

		$query = $this->db->query($sql);

		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_asistencia" ];
		return $result;
	}

	public function obtener_tiempo($input=array()){
		$sql = "
			DECLARE @fecha DATE=GETDATE(), @fecIni DATE='".$input['fecIni']."', @fecFin DATE='".$input['fecFin']."';
			SELECT 
				t.idMes, UPPER(t.mes) mes, diaFecha
				, t.idDia, UPPER(t.dia) dia
				, DAY(fecha) fecha
                , CONVERT(VARCHAR(8),t.fecha,112) fecha_id
                , CONVERT(VARCHAR, t.fecha,103) fechaFormato
			FROM General.dbo.tiempo t WHERE t.fecha BETWEEN @fecIni AND @fecFin
			ORDER BY t.fecha ASC
		";

		$query = $this->db->query($sql);

		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'dbo.tiempo' ];
		return $result;
	}

	public function obtener_ocurrencias($input=array()){

		$sql = "SELECT idOcurrencia,nombre ocurrencia,abreviatura FROM master.ocurrencias
			WHERE estado=1 AND flagAsistencia=1";

		$query = $this->db->query($sql);

		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.ocurrencias' ];
		return $result;
	}

	public function obtener_foto($input=array()){

		$sql="select fotoUrl from {$this->sessBDCuenta}.trade.data_asistencia  where idUsuario='".$input['idUsuario']."' 
			AND fecha='".$input['fecha']."' AND idTipoAsistencia='".$input['type']."' ";

		$query = $this->db->query($sql);

		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_asistencia" ];
		return $result;
	}
}
?>