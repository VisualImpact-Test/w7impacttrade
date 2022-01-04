<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_contingenciaAsistencia extends My_Model{

	var $aSessTrack = [];

	public function __construct(){
		parent::__construct();
	}

	public function obtener_ocurrencias(){
		$sql="
			SELECT idOcurrencia, nombre AS ocurrencia, abreviatura
			FROM master.ocurrencias WHERE flagAsistencia=1
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.ocurrencias' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tipo_asistencia($input=array()){
		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? " AND idCuenta=".$input['idCuenta'] : "";
		$filtros .= !empty($input['idProyecto']) ? " AND idProyecto=".$input['idProyecto'] : "";
		$filtros .= !empty($input['idCanal']) ? " AND idCanal=".$input['idCanal'] : "";

		$sql="
			SELECT 
				tuta.*, c.idCuenta, c.nombre cuenta, p.nombre proyecto
				, ta.* , ut.nombre tipoUsuario
			FROM trade.cuenta_tipo_usuario_tipo_asistencia tuta
			JOIN master.tipoAsistencia ta ON ta.idTipoAsistencia=tuta.idTipoAsistencia
			JOIN trade.proyecto p ON p.idProyecto=tuta.idProyecto
			LEFT JOIN trade.cuenta c ON c.idCuenta=p.idCuenta
			LEFT JOIN trade.usuario_tipo ut ON ut.idTipoUsuario=tuta.idTipoUsuario
			WHERE tuta.estado=1 AND ta.estado=1
			{$filtros}
			ORDER BY tuta.idProyecto, tuta.idTipoUsuario, tuta.idTipoAsistencia ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'master.tipoAsistencia' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_usuarios_asistencia($input=array()){

		$sessIdTipoUsuario = $this->idTipoUsuario;
		$filtros = '';
			$filtros .= !empty($input['cuenta_filtro']) ? " AND cu.idCuenta=".$input['cuenta_filtro'] : "";
			$filtros .= !empty($input['proyecto_filtro']) ? " AND py.idProyecto=".$input['proyecto_filtro'] : "";
			$filtros .= !empty($input['grupoCanal_filtro']) ? " AND gc.idGrupoCanal=".$input['grupoCanal_filtro'] : "";
			$filtros .= !empty($input['canal_filtro']) ? " AND ca.idCanal=".$input['canal_filtro'] : "";
			$filtros .= !empty($input['usuario_dni']) ? " AND u.numDocumento='".$input['usuario_dni']."'" : "";
			$filtros .= !empty($input['usuario_nombre']) ? " AND u.nombres+' '+u.apePaterno+' '+u.apeMaterno LIKE'%".$input['usuario_nombre']."%'" : "";

			$filtros .= !in_array($sessIdTipoUsuario,[8,13,14,4]) ? " AND tu.idTIpoUsuario NOT IN (8,13,14)" : "" ;
		$sql="
			DECLARE @fecha DATE='".$input['fecha']."';
			WITH lista_horario AS (
				SELECT 
					h.horaIngreso
					, h.horaSalida
					, h.horaProg
					, dh.idDia
					, dh.idCargoTrabajo
					, dh.idEmpleado
					, t.idFeriado
				FROM 
					rrhh.asistencia.horarioAdmin h 
					JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
					JOIN general.dbo.tiempo t ON t.idDia = dh.idDia AND t.fecha=@fecha
				WHERE
					h.estado = 1
					AND ( @fecha BETWEEN dh.fecIni AND ISNULL(dh.fecFin,@fecha) )
			), lista_horario_empleado AS (
				SELECT DISTINCT
					dh.idEmpleado
				FROM 
					rrhh.asistencia.horarioAdmin h 
					JOIN rrhh.asistencia.detalleHorario dh ON dh.idHorarioAdmin = h.idHorarioAdmin
				WHERE
					h.estado = 1
					AND ( @fecha BETWEEN dh.fecIni AND ISNULL(dh.fecFin,@fecha))
					AND dh.idEmpleado IS NOT NULL
			)
			SELECT 
				da.idTipoAsistencia
				, da.hora
				, da.flagContingencia
				, da.idOcurrencia
				, u.*
				, tu.idTipoUsuario
                , tu.nombre tipoUsuario
				, CONVERT(VARCHAR,t.fecha,103) AS fecha
				, uh.idProyecto, py.nombre proyecto, py.idCuenta, cu.nombre cuenta
				, ca.idCanal, ca.nombre canal, ca.idGrupoCanal, gc.nombre grupoCanal
				, enc.idEncargado, u.apePaterno+' '+u.apeMaterno+' '+u.nombres encargado, enc.idUsuario idUsuarioEncargado
				, ub.cod_departamento, ub.departamento, ub.cod_provincia, ub.provincia, ub.cod_distrito, ub.distrito
				, ocu.nombre ocurrencia
				, u.apePaterno+' '+u.apeMaterno+', '+u.nombres nombreUsuario
				, eq.numero movil
				, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaIngreso ELSE lh_2.horaIngreso END horarioIng
				, CASE WHEN (lh_e.idEmpleado IS NOT NULL ) THEN lh_1.horaSalida ELSE lh_2.horaSalida END horarioSal
		 	FROM trade.usuario u
                JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
                AND ( @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha))
				LEFT JOIN trade.usuario_historicoCanal uhd ON uhd.idUsuarioHist = uh.idUsuarioHist
				LEFT JOIN trade.canal ca ON ca.idCanal = uhd.idCanal
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = ca.idGrupoCanal
				LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
				LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta
				
				JOIN trade.usuario_tipo tu ON uh.idTipoUsuario = tu.idTipoUsuario
				--LEFT JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado AND e.flag IN ('activo')
				LEFT JOIN rrhh.dbo.empleado e ON e.numTipoDocuIdent = u.numDocumento 
					AND e.flag IN ('activo')
				LEFT JOIN rrhh.dbo.CargoTrabajo ct ON ct.idCargoTrabajo = e.idCargoTrabajo
				
				LEFT JOIN lista_horario lh_1 ON lh_1.idEmpleado = e.idEmpleado
				LEFT JOIN lista_horario lh_2 ON lh_2.idEmpleado IS NULL AND lh_2.idCargoTrabajo = ct.idCargoTrabajo
				LEFT JOIN lista_horario_empleado lh_e ON lh_e.idEmpleado = e.idEmpleado

				LEFT JOIN General.dbo.tiempo t ON t.fecha=@fecha
				LEFT JOIN general.dbo.ubigeo ub ON ub.cod_ubigeo = uh.cod_ubigeo
                LEFT JOIN rrhh.dbo.Ocurrencias o ON o.idEmpleado = e.idEmpleado
                    AND t.fecha BETWEEN o.fecInicio AND ISNULL( o.fecTermino, t.fecha)
                LEFT JOIN rrhh.dbo.TipoOcurrencia toc ON toc.idTipoOcurrencia = o.idTipoOcurrencia
                LEFT JOIN rrhh.dbo.vacacionesDetalle vd ON  vd.idEmpleado = e.idEmpleado AND vd.estado = 1
                    AND t.fecha BETWEEN vd.fecSalida AND ISNULL(vd.fecRetorno, t.fecha)
				LEFT JOIN rrhh.Equipos_new.asignacion eq ON eq.idEmpleado = e.idEmpleado AND t.fecha BETWEEN eq.fechaEntrega AND ISNULL(eq.fechaDevolucion, t.fecha) AND eq.idTipoEquipo=1
				
				LEFT JOIN trade.encargado_usuario sub ON sub.idUsuario=u.idUsuario
				LEFT JOIN trade.encargado enc ON enc.idEncargado=sub.idEncargado
				LEFT JOIN trade.usuario u_e ON u_e.idUsuario=enc.idUsuario
				LEFT JOIN {$this->sessBDCuenta}.trade.data_asistencia da ON da.idUsuario = u.idUsuario AND da.fecha =@fecha
				LEFT JOIN master.ocurrencias ocu ON ocu.idOcurrencia=da.idOcurrencia

				JOIN trade.aplicacion app ON uh.idAplicacion = app.idAplicacion
			WHERE
				1 = 1 
				AND uh.idAplicacion IN (1, 4, 8) 
				AND u.demo = 0
				{$filtros}
			ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, nombreUsuario, fecha ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}

	function insertar_detalle_asistencia($input=array()){
		$aSessTrack = [];

		$table = "{$this->sessBDCuenta}.trade.data_asistencia";
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
}
?>