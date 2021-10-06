<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends MY_Model{

	public function __construct(){
		parent::__construct();
	

	}

	public function find_usuario($input){
		$filtros = "";
		$value=array($input['usuario'],$input['clave']);
		$sql = "
			DECLARE @fecha DATE = GETDATE(), @usuario VARCHAR(250) = ?, @clave VARCHAR(250) = ?;
			WITH lista_empleados AS (
				SELECT e.idEmpleado, e.numTipoDocuIdent, e.archFoto urlFoto
				FROM rrhh.dbo.Empleado e
				WHERE e.flag = 'ACTIVO'
			)
			SELECT DISTINCT
				u.idUsuario
				, e.idEmpleado
				, u.apePaterno + ' ' + ISNULL(u.apeMaterno, '') + ' ' + u.nombres apeNom
				, u.apePaterno + ', ' + u.nombres apeNom_corto
				, u.apePaterno
				, u.apeMaterno 
				, u.nombres
				, td.breve tipoDocumento
				, u.numDocumento 
				, u.demo
				, u.externo
				, ut.idTipoUsuario
				, ut.nombre tipoUsuario
				, le.urlFoto foto
				, py.idProyecto
				, py.nombre proyecto
				, cu.idCuenta
				, ISNULL(cu.abreviacion,'CUENTA') abreviacionCuenta
				, cu.nombre cuenta
				, cu.urlLogo logoCuenta
				, cu.urlCSS cssCuenta
				, ca.idCanal
				, ca.idGrupoCanal
				, b.idBanner
				, b.idCadena
				, ub_pl.cod_provincia codCiudad
				, pl.idPlaza
				, z.idZona
				, ds.idDistribuidoraSucursal
				, ds.idDistribuidora
				, uh.idUsuarioHist
				, u.flag_gestorDeArchivos
				--, u.flag_modulacion
				,u.ultimo_cambio_pwd
				,DATEDIFF(day, u.ultimo_cambio_pwd, getdate()) AS dias_pasados
				, (
					SELECT TOP 1 nombre
					FROM (
						SELECT TOP 1 ct.nombre, 1 AS num
						FROM rrhh.dbo.empleadoCargoTrabajo ect
						JOIN rrhh.dbo.CargoTrabajo ct ON ect.idCargoTrabajo = ct.idCargoTrabajo
						WHERE ect.idEmpleado = e.idEmpleado
						AND @fecha BETWEEN ect.fecInicio AND ISNULL(ect.fecFin, @fecha)

						UNION

						SELECT TOP 1 ct.nombre, 2 AS num
						FROM rrhh.dbo.empleadoCargoTrabajo ect
						JOIN rrhh.dbo.CargoTrabajo ct ON ect.idCargoTrabajo = ct.idCargoTrabajo
						WHERE ect.idEmpleado = e.idEmpleado
						ORDER BY ect.fecInicio DESC
					) ect
					ORDER BY num
				) AS cargo
				, (
					SELECT TOP 1 nombre
					FROM (
						SELECT TOP 1 em.nombre, 1 AS num
						FROM rrhh.dbo.empleadoCargoTrabajo ect
						JOIN rrhh.dbo.CargoTrabajo ct ON ect.idCargoTrabajo = ct.idCargoTrabajo
						JOIN rrhh.dbo.Area a ON ct.idArea = a.idArea
						JOIN rrhh.dbo.Empresa em ON a.idEmpresa = em.idEmpresa
						WHERE ect.idEmpleado = e.idEmpleado
						AND @fecha BETWEEN ect.fecInicio AND ISNULL(ect.fecFin, @fecha)

						UNION

						SELECT TOP 1 em.nombre, 2 AS num
						FROM rrhh.dbo.empleadoCargoTrabajo ect
						JOIN rrhh.dbo.CargoTrabajo ct ON ect.idCargoTrabajo = ct.idCargoTrabajo
						JOIN rrhh.dbo.Area a ON ct.idArea = a.idArea
						JOIN rrhh.dbo.Empresa em ON a.idEmpresa = em.idEmpresa
						WHERE ect.idEmpleado = e.idEmpleado
						ORDER BY ect.fecInicio DESC
					) ect
					ORDER BY num
				) AS unidad
				, flag_anuncio_visto
			FROM
				trade.usuario u
				JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
					AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha) AND uh.estado = 1 AND uh.idAplicacion = 2 -- iAplicacion de intranet
				LEFT JOIN trade.proyecto py ON py.idProyecto = uh.idProyecto
					AND @fecha BETWEEN py.fecIni AND ISNULL(py.fecFin, @fecha) AND py.estado = 1
				LEFT JOIN trade.cuenta cu ON cu.idCuenta = py.idCuenta AND cu.estado = 1
				LEFT JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = uh.idTipoUsuario AND ut.estado = 1
				LEFT JOIN trade.usuario_tipoDocumento td ON td.idTipoDocumento = u.idTipoDocumento
				LEFT JOIN lista_empleados le ON le.numTipoDocuIdent = u.numDocumento--le.idEmpleado = u.idEmpleado
				LEFT JOIN trade.usuario_historicoCanal uhdc ON uhdc.idUsuarioHist = uh.idUsuarioHist AND uhdc.estado = 1
				LEFT JOIN trade.canal ca ON ca.idCanal = uhdc.idCanal AND ca.estado = 1
				LEFT JOIN trade.usuario_historicoBanner uhdb ON uhdb.idUsuarioHist = uh.idUsuarioHist AND uhdb.estado = 1
				LEFT JOIN trade.banner b ON b.idBanner = uhdb.idBanner AND b.estado = 1
				LEFT JOIN trade.usuario_historicoZona uhdz ON uhdz.idUsuarioHist = uh.idUsuarioHist AND uhdz.estado = 1
				LEFT JOIN trade.zona z ON z.idZona = uhdz.idZona AND z.estado = 1
				LEFT JOIN trade.usuario_historicoPlaza uhdp ON uhdp.idUsuarioHist = uh.idUsuarioHist AND uhdp.estado = 1
				LEFT JOIN trade.plaza pl ON pl.idPlaza = uhdp.idPlaza AND pl.estado = 1
				LEFT JOIN General.dbo.ubigeo ub_pl ON ub_pl.cod_ubigeo = pl.cod_ubigeo
				LEFT JOIN trade.usuario_historicoDistribuidoraSucursal uhdd ON uhdd.idUsuarioHist = uh.idUsuarioHist AND uhdd.estado = 1
				LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhdd.idDistribuidoraSucursal AND ds.estado = 1
				LEFT JOIN rrhh.dbo.Empleado e ON u.numDocumento = e.numTipoDocuIdent 
			WHERE
				u.usuario = @usuario
				AND u.claveEncriptada = HASHBYTES('SHA1', @clave)
				AND u.estado = 1
				AND u.flag_activo = 1
				$filtros
			;
		";

		return $this->db->query($sql,$value);
	}
	
	public function find_menu($input){
		$value=array($input['idUsuario']);
		$sql="
			SELECT 
				mo.*
				, gm.idGrupoMenu
				, gm.nombre grupoMenu
				, gm.cssIcono grupoIcono
				, gm.page grupoPage
				, sgm.idSubGrupoMenu
				, sgm.nombre subGrupoMenu
				, sgm.cssIcono subGrupoIcono
				, sgm.page subGrupoPage
			FROM 
				trade.usuario_menuOpcion amo
				JOIN trade.menuOpcion mo ON amo.idMenuOpcion = mo.idMenuOpcion AND mo.estado = 1
				JOIN trade.grupoMenu gm ON gm.idGrupoMenu = mo.idGrupoMenu AND gm.estado = 1
				LEFT JOIN trade.subGrupoMenu sgm ON sgm.idSubGrupoMenu = mo.idsubGrupoMenu AND sgm.estado = 1	
			WHERE
				amo.idUsuario = ?
				AND amo.estado = 1
			ORDER BY gm.orden,mo.nombre
			";
		return $this->db->query($sql,$value);
	}

	public function navbar_permiso($idUsuario){
		$value=array($idUsuario);
		$sql="
			select
			umo.idUsuarioMenuOpcion, umo.idUsuario, umo.idMenuOpcion, mo.page
			from trade.usuario_menuOpcion umo
			join trade.menuOpcion mo on mo.idMenuOpcion = umo.idMenuOpcion
			JOIN trade.intranet_menu im ON im.idMenuOpcion=mo.idMenuOpcion AND im.idIntranet=1
			where umo.estado='1' and umo.idUsuario=?
			";
		return $this->db->query($sql,$value);
	}

	public function verificar_usuario( $data = [] ){
		$sql = "
DECLARE @fecha DATE = GETDATE();
SELECT
u.idUsuario
, u.idTipoDocumento
, u.numDocumento
, u.usuario
, u.clave
, u.nombres
, u.apePaterno
, u.apeMaterno
, u.demo
, u.estado
, u.externo
, u.idEmpleado
, u.fechaCreacion
, u.fechaModificacion
, u.flag_gestorDeArchivos
, u.intentos
, u.ultimo_cambio_pwd
, u.flag_activo
, u.claveEncriptada
, e.email
, e.email_corp
FROM trade.usuario u
JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha) AND uh.estado = 1 AND uh.idAplicacion = 2
LEFT JOIN rrhh.dbo.Empleado e ON u.numDocumento = e.numTipoDocuIdent
WHERE u.estado = 1 AND u.usuario = '".$data['usuario']."'
		";

		return $this->db->query($sql)->row_array();
	}

	public function actualizar_intentos( $data = [] ){
		$this->db->trans_begin();

		$update = array(
			'intentos' => isset($data['intentos']) ? $data['intentos']+1 : '0',
		);

		if(isset($data['intentos']) AND $data['intentos']+1 >= 3){
			$update['flag_activo'] = 0;
		}

		$this->db->where('idUsuario', $data['idUsuario']);
		$result = $this->db->update('trade.usuario', $update);

		if ($this->db->trans_status() === FALSE || !$result){
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
	}

	public function insertar_auditoria( $data = [] ){
		$this->db->trans_begin();

		$result = $this->db->insert('trade.usuario_auditoria_ingreso', $data);

		if ($this->db->trans_status() === FALSE || !$result){
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
	}
	
	public function registrar_intentos( $data = [] ){
		$CI =& get_instance();

		$usuario = $this->db->get_where('trade.usuario',['usuario' =>$data['usuario']])->row_array();

		$input = [
			'idUsuario' => !empty($usuario['idUsuario']) ? $usuario['idUsuario']: NULL,
			'ipAddress' => !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : NULL,
			'browser' => !empty($CI->agent->browser()) ? $CI->agent->browser() : NULL,
			'browserVer' => !empty($CI->agent->version()) ? $CI->agent->version() : NULL,
			'platform' => !empty($CI->agent->platform()) ? $CI->agent->platform() : NULL,
			'nro_intento' => !empty($usuario)  ? ($usuario['intentos']+1) : NULL, 
		];

		return $this->db->insert('web.sessionFailedAttemps',$input);

	}

}