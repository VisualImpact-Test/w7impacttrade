<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_permisos extends My_Model{

	var $CI;

	public function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
	}

	public function obtener_lista_permisos($input=array()){
		$sql="DECLARE
				  @fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			select 
				  mp.idPermiso
				, CONVERT(VARCHAR,mp.fecIniCarga,103) AS fecIniCarga
				, CONVERT(VARCHAR,mp.fecFinCarga,103) AS fecFinCarga
				, CONVERT(VARCHAR,mp.fecIniLista,103) AS fecIniLista
				, CONVERT(VARCHAR,mp.fecFinLista,103) AS fecFinLista
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
				, mp.estado
				, mp.flagEditar
			from 
				trade.master_permisos mp
				join trade.usuario u
					ON u.idUsuario = mp.idUsuario
			WHERE
				General.dbo.fn_fechaVigente(@fecIni,@fecFin,mp.fecIniCarga,mp.fecFinCarga)=1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permisos' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_usuarios( $input = [] ){
		$filtros = "";
			if( !empty($input['idCuenta']) ) $filtros .= " AND c.idCuenta = {$input['idCuenta']}";
			if( !empty($input['idProyecto']) ) $filtros .= " AND p.idProyecto = {$input['idProyecto']}";

		$sql = "
			DECLARE @fecha DATE = GETDATE();

			SELECT DISTINCT
				u.idUsuario,
				u.apePaterno + ISNULL(' '+u.apeMaterno, '') + ISNULL(' ' + u.nombres, '') AS usuario
			FROM trade.usuario u
			JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
				AND @fecha BETWEEN uh.fecIni AND ISNULL (uh.fecFin,@fecha)
				AND uh.idTipoUsuario IN (2,6)
			JOIN trade.proyecto p ON p.idProyecto = uh.idProyecto
			JOIN trade.cuenta c ON p.idCuenta = c.idcuenta
			WHERE u.demo = 0{$filtros}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_modulos(){
		$sql = "SELECT idModulo,modulo FROM trade.master_modulo WHERE estado=1";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_modulo' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_permisos_modulo($idPermiso){
		$sql="select * from ImpactTrade_bd.trade.master_permiso_modulo where idPermiso=$idPermiso";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permiso_modulo' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_permisos($id){
		$sql="
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			select 
				  mp.idPermiso
				, convert(varchar,mp.fecIniCarga,103) fecIniCarga
				, convert(varchar,mp.fecFinCarga,103) fecFinCarga
				, convert(varchar,mp.fecIniLista,103) fecIniLista
				, convert(varchar,mp.fecFinLista,103) fecFinLista
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
			from 
				trade.master_permisos mp
				join trade.usuario u
					ON u.idUsuario = mp.idUsuario
			WHERE
				mp.idPermiso={$id}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permisos' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_usuarios_asistencia($input=array()){
		$filtros = '';
		$filtros .= !empty($input['idCuenta']) ? " AND idCuenta=".$input['idCuenta'] : "";
		$filtros .= !empty($input['idProyecto']) ? " AND idProyecto=".$input['idProyecto'] : "";
		$filtros .= !empty($input['idCanal']) ? " AND idCanal=".$input['idCanal'] : "";

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
				JOIN rrhh.dbo.empleado e ON e.idEmpleado = u.idEmpleado
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
				LEFT JOIN trade.data_asistencia da ON da.idUsuario = u.idUsuario AND da.fecha =@fecha
				LEFT JOIN master.ocurrencias ocu ON ocu.idOcurrencia=da.idOcurrencia
			WHERE
				uh.idAplicacion = 1
				--AND u.demo = 0
				{$filtros}
			ORDER BY cuenta, proyecto, grupoCanal, canal, departamento, provincia, distrito, nombreUsuario, fecha ASC
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}

	function insertar_detalle_asistencia($input=array()){
		$aSessTrack = [];

		$table = 'trade.data_asistencia';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert($table, $input);

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $insert;
	}

	public function verificar_master_permiso($input=array()){
		$query = $this->db->select('idPermiso')
				->where( $input )
				->get('trade.master_permisos');

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_permisos' ];
		return $query->result_array();
	}

	public function delete_duplicado_modulos($input=array()){
		$sql="DELETE FROM trade.master_permiso_modulo 
		WHERE idPermiso IN(
			SELECT idPermiso FROM trade.master_permisos 
			WHERE idUsuario =".$input['idUsuario']." AND fecIniCarga='".$input['fecIniCarga']."' AND fecFinCarga='".$input['fecFinCarga']."')";

		$this->CI->aSessTrack[] = [
				'idAccion' => 8,
				'tabla' => 'trade.master_permiso_modulo',
				'id' => arrayToString([
						'idUsuario' => $input['idUsuario'],
						'fecIniCarga' => $input['fecIniCarga'],
						'fecFinCarga' => $input['fecFinCarga']
					])
			];
		return $this->db->query($sql);
	}

	public function delete_duplicado_permisos($input=array()){
		$sql="DELETE FROM trade.master_permisos 
		WHERE idUsuario =".$input['idUsuario']." AND fecIniCarga='".$input['fecIniCarga']."' AND fecFinCarga='".$input['fecFinCarga']."' ";

		$this->CI->aSessTrack[] = [
				'idAccion' => 8,
				'tabla' => 'trade.master_permisos',
				'id' => arrayToString([
						'idUsuario' => $input['idUsuario'],
						'fecIniCarga' => $input['fecIniCarga'],
						'fecFinCarga' => $input['fecFinCarga']
					])
			];
		return $this->db->query($sql);
	}

	public function insertar_master_permiso($input=array()){
		$aSessTrack = [];

		$table = 'trade.master_permisos';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function verificar_master_permiso_modulo($input=array()){
		$query = $this->db->select('idPermisoMod')
				->where( $input )
				->get('trade.master_permiso_modulo');

		$this->CI->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => 'trade.master_permiso_modulo' ];
		return $query->result_array();
	}

	public function delete_permiso_modulo($input=array()){
		$sql="DELETE FROM trade.master_permiso_modulo 
		WHERE idPermiso=".$input['idPermiso']." AND idModulo=".$input['idModulo'];

		$this->CI->aSessTrack[] = [ 'idAccion' => 8,
				'tabla' => 'trade.master_permiso_modulo',
				'id' => arrayToString([
						'idPermiso' => $input['idPermiso'],
						'idModulo' => $input['idModulo']
					])
			];
		return $this->db->query($sql);
	}

	public function insertar_permiso_modulo($input=array()){
		$aSessTrack = [];

		$table = 'trade.master_permiso_modulo';
		$this->db->trans_begin();

			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ( $this->db->trans_status()===FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}
		return $insert;
	}

	public function update_master_permiso($where=array(), $params=array()){
		$aSessTrack = [];

		$table = 'trade.master_permisos';
		$this->db->trans_begin();

			$this->db->where($where);
			$update = $this->db->update($table, $params);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $table, 'id' => arrayToString($where) ];

		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->CI->aSessTrack[] = $aSessTrack;
		}

		return $update;
	}

	public function delete_permiso_modulo_total($input=array()){
		$sql="DELETE FROM trade.master_permiso_modulo 
		WHERE 1=1 AND idPermiso=".$input['idPermiso'];

		$this->CI->aSessTrack = [ 'idAccion' => 8,
				'tabla' => 'trade.master_permiso_modulo',
				'id' => arrayToString([ 'idPermiso' => $input['idPermiso'] ])
			];
		return $this->db->query($sql);
	}

	public function update_fechas_carga_modulacion($where=array(), $update=array()){
		$sql="UPDATE trade.master_modulacion 
		SET fecIni='".$update['fecIniCarga']."', fecFin='".$update['fecFinCarga']."'
		WHERE idPermiso=".$where['idPermiso'];

		$this->CI->aSessTrack = [ 'idAccion' => 7,
				'tabla' => 'trade.master_modulacion',
				'id' => arrayToString([ 'idPermiso' => $where['idPermiso'] ])
			];
		return $this->db->query($sql);
	}


	public function obtener_elementos(){
		$sql="DECLARE @fecha DATE=GETDATE(), @fecIni DATE=GETDATE(), @fecFin DATE=GETDATE();
		---
		SELECT
			evt.idElementoVis
			, evt.nombre AS elemento
			, evt.idTipoElementoVisibilidad
			, ISNULL(evt.idCategoria,0) AS idCategoria
			, ISNULL(pc.nombre,'SIN CATEGORIA') AS categoria
		FROM trade.master_listaElementos le
		JOIN trade.master_listaElementosDet led ON led.idLista=le.idLista
		JOIN trade.elementoVisibilidadTrad evt ON evt.idElementoVis=led.idElementoVisibilidad
		LEFT JOIN trade.producto_categoria pc ON pc.idCategoria=evt.idCategoria
		WHERE 1=1 AND le.estado=1 AND led.estado=1 AND evt.estado=1
		AND @fecha BETWEEN le.fecIni AND ISNULL(le.fecFin,@fecha)
		/*AND (
			le.fecIni <= ISNULL( le.fecFin, @fecFin)
			AND (
				le.fecIni BETWEEN @fecIni AND @fecFin 
				OR
				ISNULL( le.fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin 
				OR
				@fecIni BETWEEN le.fecIni AND ISNULL( le.fecFin, @fecFin ) 
				OR
				@fecFin BETWEEN le.fecIni AND ISNULL( le.fecFin, @fecFin )
			)
		)*/
		--ORDER BY idCategoria, elemento ASC
		ORDER BY led.orden ";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.master_listaElementos' ];
		return $this->db->query($sql)->result_array();
	}


	public function obtener_estado_carga($idPermiso){
		$sql ="  
			SELECT 
				  *
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				,(
					SELECT count(*) FROM (
						SELECT idCarga FROM trade.cargaModulacionClientesNoProcesados WHERE idCarga=cm.idCarga
						UNION
						SELECT idCarga FROM trade.cargaModulacionElementosError  WHERE idCarga=cm.idCarga
					)a
				) error
			FROM 
				trade.cargaModulacion cm

			 WHERE cm.idPermiso='".$idPermiso."'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_estado_carga_1(){
		$sql =" 
			SELECT 
				  *
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				, (SELECT COUNT(*) FROM  trade.cargaModulacionClientesNoProcesados WHERE elemento IS NULL AND idCarga=cm.idCarga  ) noProcesados
				,(
					SELECT count(*) FROM (
						SELECT idCarga FROM trade.cargaModulacionClientesNoProcesados WHERE idCarga=cm.idCarga
						UNION
						SELECT idCarga FROM trade.cargaModulacionElementosError  WHERE idCarga=cm.idCarga
					)a
				) error
			FROM 
				trade.cargaModulacion cm

		";
		return $this->db->query($sql)->result_array();
	}
}
?>