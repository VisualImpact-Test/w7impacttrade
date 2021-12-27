<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_usuarios extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'usuarios' => ['tabla' => 'trade.usuario', 'id' => 'idUsuario'],
			'historicoCanal' => ['tabla' => 'trade.usuario_historicoCanal', 'id' => 'idUsuarioHistCanal'],
			'historicoBanner' => ['tabla' => 'trade.usuario_historicoBanner', 'id' => 'idUsuarioHistBanner'],
			'historicoDistribuidoraSucursal' => ['tabla' => 'trade.usuario_historicoDistribuidoraSucursal', 'id' => 'idUsuarioHistDistribuidoraSucursal'],
			'historicoPlaza' => ['tabla' => 'trade.usuario_historicoPlaza', 'id' => 'idUsuarioHistPlaza'],
			'historicoZona' => ['tabla' => 'trade.usuario_historicoZona', 'id' => 'idUsuarioHistZona'],
			'modulosMovil' => ['tabla' => 'trade.usuario_modulo', 'id' => 'idUsuarioModulo'],
			'modulosIntranet' => ['tabla' => 'trade.usuario_menuOpcion', 'id' => 'idUsuarioMenuOpcion'],
			'permisosCarpetas' => ['tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta", 'id' => 'idPermisoCarpeta'],
			'usuarioHistorico' => ['tabla' => 'trade.usuario_historico', 'id' => 'idUsuarioHist'],
		];
	}
	
	public function getDataRecursosHumanos($documento){
		$sql = "SELECT * FROM rrhh.dbo.Empleado WHERE numTipoDocuIdent='".$documento."' ";
		
		return $this->db->query($sql);
	}
	
	public function getUsuarios($post)
	{
		$post['idEmpresa'] = 0;

		if (!empty($post['idCuenta'])) {
			$getIdEmpresa = "
				SELECT idEmpresaRRHH
				FROM trade.cuentaToEmpresaRRHH
				WHERE idCuenta =  " . $post['idCuenta'] . "
			";

			$post['idEmpresa'] = $this->db->query($getIdEmpresa)->row_array()['idEmpresaRRHH'];
		}

		$filtros = " WHERE 1 = 1";
		if (!empty($post['idCuenta'])) $filtros .= " AND c.idCuenta = " . $post['idCuenta'];
		if (!empty($post['idProyecto'])) $filtros .= " AND uh.idProyecto = " . $post['idProyecto'];
		if (!empty($post['tipoUsuarioFiltro'])) $filtros .= " AND uh.idTipoUsuario = " . $post['tipoUsuarioFiltro'];
		if (!empty($post['tipoDocumentoFiltro'])) $filtros .= " AND u.idTipoDocumento = " . $post['tipoDocumentoFiltro'];
		if (!empty($post['numDocumentoFiltro'])) $filtros .= " AND u.numDocumento LIKE '%" . $post['numDocumentoFiltro'] . "%'";
		if (!empty($post['nombresApellidosFiltro'])) $filtros .= " AND u.nombres + ' - ' + u.apePaterno + ' - ' + u.apeMaterno LIKE '%" . $post['nombresApellidosFiltro'] . "%'";

		$filtrosRRHH = " WHERE (e.flag = 'nuevo' OR e.flag = 'activo' OR e.flag IS NULL OR e.flag = 'cesado')";
		if($this->session->idTipoUsuario==4){
			$filtrosRRHH .= !empty($post['usuariosActivos']) ? " AND u.historicoActivo = 1 " : "AND (u.historicoActivo = 0 OR u.historicoActivo IS NULL)";
		} else{
			$filtrosRRHH .= " AND u.historicoActivo = 1 ";
		}
		if (!empty($post['idCuenta'])) $filtrosRRHH .= " AND (" . (empty($post['idEmpresa']) ? '' : 'emp.idEmpresa = '. $post['idEmpresa']. 'OR ') . "u.idCuenta = " . $post['idCuenta'] . ")";
		if (!empty($post['tipoDocumentoFiltro'])) $filtrosRRHH .= " AND (e.idTipoDocuIdent = " . $post['tipoDocumentoFiltro'] . " OR u.idTipoDocumento = " . $post['tipoDocumentoFiltro'] . ")";
		if (!empty($post['numDocumentoFiltro'])) $filtrosRRHH .= " AND (e.numTipoDocuIdent LIKE '%" . $post['numDocumentoFiltro'] . "%' OR u.numDocumento LIKE '%" . $post['numDocumentoFiltro'] . "%')";
		if (!empty($post['nombresApellidosFiltro'])) $filtrosRRHH .= " AND (e.nombres + ' - ' + e.apePaterno + ' - ' + e.apeMaterno LIKE '%" . $post['nombresApellidosFiltro'] . "%' OR u.nombres + ' - ' + u.apePaterno + ' - ' + u.apeMaterno LIKE '%" . $post['nombresApellidosFiltro'] . "%')";

		$fechas = explode('-', $post['txt-fechas']);
		$fechaIni = $fechas[0];
		$fechaFin = $fechas[1];

		$sql = "
		DECLARE @fecIni DATE= '{$fechaIni}', @fecFin DATE= '{$fechaFin}';
		WITH usuariosTrade
			 AS (SELECT DISTINCT u.idUsuario, 
						u.idTipoDocumento, 
						td.breve tipoDocumento, 
						u.numDocumento, 
						u.usuario, 
						u.clave, 
						u.nombres, 
						u.apePaterno, 
						u.apeMaterno, 
						u.externo, 
						c.idCuenta, 
						c.nombre cuenta, 
						u.demo, 
						u.estado, 
						u.fechaCreacion, 
						u.fechaModificacion,
						CASE
							WHEN fn.datesBetween(uh.fecIni, uh.fecFin, @fecIni, @fecFin) = 1
							THEN 1
							ELSE 0
						END AS historicoActivo,
						u.flag_activo,
						u.flag_nuevo
				 FROM trade.usuario u
					  LEFT JOIN trade.usuario_historico uh ON uh.idUsuario = U.idUsuario
					  LEFT JOIN trade.proyecto p ON p.idProyecto = uh.idProyecto
					  LEFT JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
					  LEFT JOIN trade.usuario_tipoDocumento td ON td.idTipoDocumento = u.idTipoDocumento
					  {$filtros}
					  )
			 SELECT DISTINCT e.idEmpleado idEmpleadoRRHH, 
					e.apePaterno apePaternoRRHH, 
					e.apeMaterno apeMaternoRRHH, 
					e.nombres nombresRRHH, 
					e.numTipoDocuIdent numDocIdentRRHH, 
					e.idTipoDocuIdent idTipoDocIdentRRHH,
					tdi.nombre tipoDocumentoRRHH,
					e.email_corp email_corpRRHH, 
					emp.idEmpresa idEmpresaRRHH,
					tdi.nombre tipoDocumentoRRHH,
					cerh.idCuenta idCuentaRRHH,
					emp.nombre nombreEmpresaRRHH,
					u.idUsuario, 
					u.idTipoDocumento, 
					u.tipoDocumento, 
					u.numDocumento, 
					u.usuario, 
					u.clave, 
					u.nombres, 
					u.apePaterno, 
					u.apeMaterno, 
					u.externo, 
					u.idCuenta, 
					u.cuenta, 
					u.demo, 
					u.estado, 
					u.fechaCreacion, 
					u.fechaModificacion,
					u.flag_activo,
					u.flag_nuevo
			 FROM rrhh.dbo.Empleado e
				  INNER JOIN rrhh.dbo.CargoTrabajo ct ON e.idCargoTrabajo = ct.idCargoTrabajo
				  INNER JOIN rrhh.dbo.Area a ON ct.idArea = a.idArea
				  INNER JOIN rrhh.dbo.empresa emp ON a.idEmpresa = emp.idEmpresa
				  LEFT JOIN rrhh.dbo.TipoDocuIdent tdi ON tdi.idTipoDocuIdent = e.idTipoDocuIdent
				  LEFT JOIN trade.cuentaToEmpresaRRHH cerh ON cerh.idEmpresaRRHH = emp.idEmpresa
				  FULL OUTER JOIN usuariosTrade u ON u.numDocumento = e.numTipoDocuIdent
				  {$filtrosRRHH}
			 ORDER BY flag_nuevo DESC, u.idUsuario DESC;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'rrhh.dbo.Empleado' ];
		return $this->db->query($sql);
	}

	public function getDatosDeUsuario($idUsuario)
	{
		$sql = "
			SELECT u.*, 
				utd.breve tipoDocumento
			FROM trade.usuario u
				LEFT JOIN trade.usuario_tipoDocumento utd ON utd.idTipoDocumento = u.idTipoDocumento
			WHERE idUsuario = $idUsuario
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql);
	}

	public function getTiposDeDocumento()
	{
		$sql = "
			SELECT *
			FROM trade.usuario_tipoDocumento
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_tipoDocumento' ];
		return $this->db->query($sql);
	}

	public function getHistoricos($post)
	{
		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND uh.idUsuario = " . $post['id'];
		if (!empty($post['idUsuarioHistorico'])) $filtros .= " AND uh.idUsuarioHist = " . $post['idUsuarioHistorico'];

		$sql = "
			SELECT uh.idUsuarioHist, 
				uh.idUsuario,
				c.idCuenta,
				p.idProyecto,
				c.nombre cuenta, 
				p.nombre proyecto,
				tu.idTipoUsuario,
				tu.nombre tipoUsuario, 
				uh.fecIni, 
				uh.fecFin, 
				a.nombre aplicacion, 
				a.idAplicacion
			FROM trade.usuario_historico uh
				LEFT JOIN trade.proyecto p ON p.idProyecto = uh.idProyecto
				LEFT JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				LEFT JOIN trade.usuario_tipo tu ON tu.idTipoUsuario = uh.idTipoUsuario
				LEFT JOIN trade.aplicacion a ON a.idAplicacion = uh.idAplicacion
				{$filtros}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];
		return $this->db->query($sql);
	}

	public function actualizarMasivoHistoricoCanal($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_usuarios->tablas['historicoCanal']['id'] => $value['id'],
					'idCanal' => $value['canal'],
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_usuarios->tablas['historicoCanal']['tabla'], $input, $this->m_usuarios->tablas['historicoCanal']['id']);

		$tabla = $this->m_usuarios->tablas['historicoCanal']['tabla'];
		$id = $this->m_usuarios->tablas['historicoCanal']['id'];

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $id ];
		return $update;
	}

	public function actualizarMasivoHistoricoBanner($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_usuarios->tablas['historicoBanner']['id'] => $value['id'],
					'idBanner' => $value['banner'],
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_usuarios->tablas['historicoBanner']['tabla'], $input, $this->m_usuarios->tablas['historicoBanner']['id']);

		$tabla = $this->m_usuarios->tablas['historicoBanner']['tabla'];
		$id = $this->m_usuarios->tablas['historicoBanner']['id'];

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $id ];
		return $update;
	}

	public function actualizarMasivoHistoricoDistribuidoraSucursal($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_usuarios->tablas['historicoDistribuidoraSucursal']['id'] => $value['id'],
					'idDistribuidoraSucursal' => $value['sucursal'],
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_usuarios->tablas['historicoDistribuidoraSucursal']['tabla'], $input, $this->m_usuarios->tablas['historicoDistribuidoraSucursal']['id']);

		$tabla = $this->m_usuarios->tablas['historicoDistribuidoraSucursal']['tabla'];
		$id = $this->m_usuarios->tablas['historicoDistribuidoraSucursal']['id'];

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $id ];
		return $update;
	}

	public function actualizarMasivoHistoricoPlaza($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->m_usuarios->tablas['historicoPlaza']['id'] => $value['id'],
					'idPlaza' => $value['plaza'],
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->m_usuarios->tablas['historicoPlaza']['tabla'], $input, $this->m_usuarios->tablas['historicoPlaza']['id']);

		$tabla = $this->m_usuarios->tablas['historicoPlaza']['tabla'];
		$id = $this->m_usuarios->tablas['historicoPlaza']['id'];

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $id ];
		return $update;
	}

	public function guardarMasivoHistoricoCanal($multiDataRefactorizada, $idUsuarioHistorico)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idUsuarioHist' => $idUsuarioHistorico,
					'idCanal' => $value['canal'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['historicoCanal']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['historicoCanal']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoHistoricoBanner($multiDataRefactorizada, $idUsuarioHistorico)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idUsuarioHist' => $idUsuarioHistorico,
					'idBanner' => $value['banner'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['historicoBanner']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['historicoBanner']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoHistoricoDistribuidoraSucursal($multiDataRefactorizada, $idUsuarioHistorico)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idUsuarioHist' => $idUsuarioHistorico,
					'idDistribuidoraSucursal' => $value['sucursal'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['historicoDistribuidoraSucursal']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['historicoDistribuidoraSucursal']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoHistoricoPlaza($multiDataRefactorizada, $idUsuarioHistorico)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idUsuarioHist' => $idUsuarioHistorico,
					'idPlaza' => $value['plaza'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['historicoPlaza']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['historicoPlaza']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoHistoricoZonas($zonas, $idUsuarioHistorico)
	{
		$input = [];
		foreach ($zonas as $idZona) {
			$input[] = [
				'idUsuarioHist' => $idUsuarioHistorico,
				'idZona' => $idZona,
			];
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['historicoZona']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['historicoZona']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoModulosMovil($modulosMovil, $idUsuario)
	{
		$input = [];
		foreach ($modulosMovil as $idModulo) {
			$input[] = [
				'idUsuario' => $idUsuario,
				'idModulo' => $idModulo,
			];
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['modulosMovil']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['modulosMovil']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoModulosIntranet($modulosIntranet, $idUsuario)
	{
		$input = [];
		foreach ($modulosIntranet as $idMenuOpcion) {
			$input[] = [
				'idUsuario' => $idUsuario,
				'idMenuOpcion' => $idMenuOpcion,
			];
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['modulosIntranet']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['modulosIntranet']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function guardarMasivoPermisosCarpetas($post)
	{
		$idsCarpetas = $post['idsCarpetas'];
		$input = [];
		foreach ($idsCarpetas as $idCarpeta) {
			$input[] = [
				'idUsuario' => $post['idUsuario'],
				'idUsuarioCreador' => $post['idUsuarioCreador'],
				'ipUsuarioCreador' => $post['ipUsuarioCreador'],
				'idCarpeta' => $idCarpeta,
			];
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['permisosCarpetas']['tabla'], $input);

		$tabla = $this->m_usuarios->tablas['permisosCarpetas']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $tabla ];
		return $insert;
	}

	public function getGrupoCanalYCanalDeHistorico($post)
	{
		$idHistorico = $post['idUsuarioHistorico'];

		$sql = "
		SELECT uhc.*, 
			c.nombre canal, 
			gc.nombre grupoCanal,
			gc.idGrupoCanal
		FROM trade.usuario_historicoCanal uhc
			LEFT JOIN trade.canal c ON c.idCanal = uhc.idCanal
			LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
		WHERE uhc.estado = 1
			AND uhc.idUsuarioHist = $idHistorico
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoCanal' ];
		return $this->db->query($sql);
	}

	public function getGrupoCanalYCanal()
	{
		$sql = "
			SELECT gc.idGrupoCanal, 
				gc.nombre grupoCanal, 
				c.idCanal, 
				c.nombre canal
			FROM trade.canal c
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
											AND gc.estado = 1
			WHERE c.estado = 1
			ORDER BY gc.nombre ASC, 
					c.nombre DESC;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal' ];
		return $this->db->query($sql);
	}

	public function getCadenaYBannerDeHistorico($post)
	{

		$idHistorico = $post['idUsuarioHistorico'];

		$sql = "
			SELECT uhb.*, 
				cd.idCadena, 
				b.nombre banner, 
				cd.nombre cadena
			FROM trade.usuario_historicoBanner uhb
				LEFT JOIN trade.banner b ON b.idBanner = uhb.idBanner
				LEFT JOIN trade.cadena cd ON cd.idCadena = b.idCadena
			WHERE uhb.estado = 1
				AND uhb.idUsuarioHist = {$idHistorico}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoBanner' ];
		return $this->db->query($sql);
	}

	public function getDistribuidorasSucursalesDeHistorico($post)
	{

		$idHistorico = $post['idUsuarioHistorico'];

		$sql = "
			SELECT uhds.*, 
				d.idDistribuidora, 
				d.nombre distribuidora, 
				d.nombre + ' - ' + ubi.distrito AS distribuidoraSucursal
			FROM trade.usuario_historicoDistribuidoraSucursal uhds
				LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = uhds.idDistribuidoraSucursal
				LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
				LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo = ds.cod_ubigeo
			WHERE uhds.estado = 1
				AND uhds.idUsuarioHist = $idHistorico
			ORDER BY d.nombre, 
					distribuidoraSucursal
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoDistribuidoraSucursal' ];
		return $this->db->query($sql);
	}

	public function getPlazasDeHistorico($post)
	{

		$idHistorico = $post['idUsuarioHistorico'];

		$sql = "
			SELECT uhz.*, 
				p.nombre plaza
			FROM trade.usuario_historicoPlaza uhz
				LEFT JOIN trade.plaza p ON p.idPlaza = uhz.idPlaza
			WHERE uhz.estado = 1
				AND uhz.idUsuarioHist = $idHistorico
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoPlaza' ];
		return $this->db->query($sql);
	}

	public function getPlazas()
	{
		$sql = "
			SELECT *
			FROM trade.plaza
			WHERE estado = 1
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.plaza' ];
		return $this->db->query($sql);
	}

	public function getCadenaYBanner()
	{
		$sql = "
			SELECT c.idCadena, 
				c.nombre nombreCadena, 
				b.idBanner, 
				b.nombre nombreBanner
			FROM trade.cadena c
				JOIN trade.banner b ON c.idCadena = b.idCadena
										AND b.estado = 1
			ORDER BY c.nombre ASC, 
					b.nombre DESC;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cadena' ];
		return $this->db->query($sql);
	}

	public function getDistribuidorasSucursales()
	{
		$sql = "
			SELECT d.idDistribuidora, 
				d.nombre distribuidora, 
				ds.idDistribuidoraSucursal, 
				d.nombre + ' - ' + ubi.distrito AS distribuidoraSucursal
			FROM trade.distribuidoraSucursal ds
				JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
				LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo = ds.cod_ubigeo
			WHERE ds.estado = 1
				AND d.estado = 1
			ORDER BY d.nombre, 
					distribuidoraSucursal
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.distribuidoraSucursal' ];
		return $this->db->query($sql);
	}

	public function getZonasDeHistorico($post)
	{
		$idHistorico = $post['idUsuarioHistorico'];

		$sql = "
			SELECT idZona
			FROM trade.usuario_historicoZona
			WHERE idUsuarioHist = {$idHistorico}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historicoZona' ];
		return $this->db->query($sql);
	}

	public function getZonas($post)
	{
		$idCuenta = $post['idCuenta'];
		$idProyecto = $post['idProyecto'];

		$sql = "
			SELECT DISTINCT 
				*
			FROM trade.zona zn
			WHERE 1 = 1
				/* AND zn.idCuenta = $idCuenta
				AND zn.idProyecto = $idProyecto */
			ORDER BY zn.nombre
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.zona' ];
		return $this->db->query($sql);
	}

	public function getModulosMovilDeUsuario($params)
	{
		$result = [];
		$sql = "SELECT idModulo FROM trade.usuario_modulo WHERE estado=1 AND idUsuario = ?";
		$result = $this->db->query($sql, [ 'idUsuario' => $params['idUsuario'] ]);

		if(empty($result->result())){
			$sql = "
			DECLARE @fecha DATE = GETDATE();
			SELECT
			utm.idModulo
			FROM trade.usuario_tipo_modulo utm
			LEFT JOIN trade.usuario_historico uh ON uh.idTipoUsuario = utm.idTipoUsuario
			AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
			WHERE utm.estado = 1 AND uh.idUsuario = ?
			";
			$result = $this->db->query($sql, [ 'idUsuario' => $params['idUsuario'] ]);
		}

		return $result;
	}

	public function getModulosMovil($post)
	{
		$idAplicacion = $post['idAplicacion'];

		$sqlFiltro = "
			SELECT idTipoUsuario
			FROM trade.aplicacion_modulo_tipoUsuario
			WHERE estado = 1;
		";

		$tiposDeUsuarioConPermisosRestringidos = array_column($this->db->query($sqlFiltro)->result_array(), 'idTipoUsuario');

		if (!in_array($post['idTipoUsuario'], $tiposDeUsuarioConPermisosRestringidos)) {
			$sql = "
				SELECT *
				FROM trade.aplicacion_modulo
				WHERE estado = 1
					AND idAplicacion = {$idAplicacion}
				ORDER BY nombre;
			";
		} else {
			$sql = "
				SELECT amt.idModulo, am.nombre
				FROM trade.aplicacion_modulo_tipoUsuario amt
					JOIN trade.aplicacion_modulo am ON am.idModulo = amt.idModulo
				WHERE amt.idTipoUsuario = " . $post['idTipoUsuario'] . "
					AND amt.estado = 1
					AND am.idAplicacion = {$idAplicacion}
			";
		}

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.aplicacion_modulo' ];
		return $this->db->query($sql);
	}

	public function deletePermisosMovil($post)
	{
		$idAplicacion = $post['idAplicacion'];
		$idUsuario = $post['idUsuario'];

		$sqlGetModulosDeAplicacion = "
										SELECT idModulo
										FROM trade.aplicacion_modulo
										WHERE idAplicacion = $idAplicacion
									";
		$modulosDeAplicacion = array_column($this->db->query($sqlGetModulosDeAplicacion)->result_array(), 'idModulo');
		if (empty($modulosDeAplicacion)) return true;

		$this->db->where('idUsuario', $idUsuario);
		$this->db->where_in('idModulo', $modulosDeAplicacion);
		$delete = $this->db->delete($this->tablas['modulosMovil']['tabla']);

		$tabla = $this->tablas['modulosMovil']['tabla'];
		$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => $tabla, 'id' => arrayToString([ 'idUsuario' => $idUsuario ]) ];

		return $delete;
	}

	public function getModulosIntranetDeUsuario($post)
	{
		$idUsuario = $post['idUsuario'];

		$sql = "
			SELECT idMenuOpcion
			FROM trade.usuario_menuOpcion
			WHERE idUsuario = {$idUsuario}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_menuOpcion' ];
		return $this->db->query($sql);
	}

	public function getMenusYGrupoMenus()
	{
		$filtros = '';
		$ti = $this->flag_ti;
		(empty($ti)) ? $filtros.=" AND mo.flag_ti IS NULL OR mo.flag_ti = 0 ": "" ;
		$sql = "
			SELECT mo.idMenuOpcion, 
				mo.nombre, 
				mo.idGrupoMenu, 
				gm.nombre grupoMenu,
				mo.cssIcono icono
			FROM trade.menuOpcion mo
				JOIN trade.grupoMenu gm ON gm.idGrupoMenu = mo.idGrupoMenu
				JOIN trade.intranet_menu im ON im.idMenuOpcion=mo.idMenuOpcion AND im.idIntranet=1
			WHERE mo.estado = 1 $filtros
			ORDER BY mo.idGrupoMenu ASC
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.menuOpcion' ];
		return $this->db->query($sql);
	}

	public function actualizarHistorico($post)
	{
		$update = [
			// 'fecIni' => trim($post['fechaInicioHistoricoDetalle']),
			'fecFin' => !empty($post['fechaFinalHistoricoDetalle']) ? trim($post['fechaFinalHistoricoDetalle']) : null,
		];
		$where = [
			$this->tablas['usuarioHistorico']['id'] => $post['idUsuarioHistorico']
		];
		$this->db->where($where);
		$update = $this->db->update($this->tablas['usuarioHistorico']['tabla'], $update);

		$tabla = $this->tablas['usuarioHistorico']['tabla'];

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $post['idUsuarioHistorico'] ];
		return $update;
	}

	public function getSubordinados($idUsuario)
	{
		$sql = "
			SELECT u.idUsuario, 
				u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres AS nombre, 
				u.numDocumento
			FROM trade.encargado_usuario eu
				LEFT JOIN trade.usuario u ON u.idUsuario = eu.idUsuario
			WHERE eu.estado = 1
				AND idEncargado = $idUsuario
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.encargado_usuario' ];
		return $this->db->query($sql);
	}

	public function getEncargado($idUsuario)
	{
		$sql = "
			SELECT u.idTipoDocumento, 
				u.numDocumento, 
				u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres AS nombreSuperior, 
				u.idUsuario, 
				utd.*
			FROM trade.encargado_usuario eu
				LEFT JOIN trade.encargado e ON e.idEncargado=eu.idEncargado
				LEFT JOIN trade.usuario u ON u.idUsuario = e.idUsuario
				LEFT JOIN trade.usuario_tipoDocumento utd ON utd.idTipoDocumento = u.idTipoDocumento
			WHERE eu.idUsuario = {$idUsuario}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.encargado_usuario' ];
		return $this->db->query($sql);
	}

	public function findSuperior($numDocumento, $idTipoDocumento, $idCuenta, $idProyecto)
	{
		$filtros="";
		if (!empty($idCuenta)) $filtros .= " AND c.idCuenta = " . $idCuenta;
		if (!empty($idProyecto)) $filtros .= " AND p.idProyecto = " . $idProyecto;
		$sql = "
			DECLARE @fecIni DATE= GETDATE(), @fecFin DATE= GETDATE();
			SELECT DISTINCT 
				u.apePaterno + ' ' + u.apeMaterno + ' ' + u.nombres AS nombreSuperior, 
				u.idUsuario, 
				u.idTipoDocumento
			FROM trade.usuario u
				LEFT JOIN trade.usuario_historico uh ON uh.idUsuario = U.idUsuario
				LEFT JOIN trade.proyecto p ON p.idProyecto = uh.idProyecto
				LEFT JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				LEFT JOIN trade.usuario_tipoDocumento td ON td.idTipoDocumento = u.idTipoDocumento
			WHERE fn.datesBetween(uh.fecIni, uh.fecFin, @fecIni, @fecFin) = 1
				AND u.numDocumento = '" . $numDocumento . "'
				AND td.idTipoDocumento = {$idTipoDocumento}
				{$filtros}
				AND u.estado = 1;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql);
	}

	public function checkNumDocumentoRepetido($post)
	{
		$where = "numDocumento = '" . trim($post['numDocumento']) . "' AND idTipoDocumento = " . $post['tipoDocumento'];
		if (!empty($post['idUsuario'])) $where .= " AND " . $this->tablas['usuarios']['id'] . " != " . $post['idUsuario'];
		return $this->verificarRepetido($this->tablas['usuarios']['tabla'], $where);
	}

	public function checkNumDocumentoRepetidoEnRRHH($post)
	{
		$where = "numTipoDocuIdent = '" . trim($post['numDocumento']) . "'";
		if (!empty($post['idEmpleado'])) $where .= " AND idEmpleado != " . $post['idEmpleado'];
		return $this->verificarRepetido('rrhh.dbo.Empleado', $where);
	}

	public function checkUsuarioRepetido($post)
	{
		$where = "usuario = '" . trim($post['usuario']) . "'";
		if (!empty($post['idUsuario'])) $where .= " AND " . $this->tablas['usuarios']['id'] . " != " . $post['idUsuario'];
		return $this->verificarRepetido($this->tablas['usuarios']['tabla'], $where);
	}

	public function checkEmailRepetido($post)
	{
		$where = "email = '" . trim($post['email']) . "'";
		if (!empty($post['idUsuario'])) $where .= " AND " . $this->tablas['usuarios']['id'] . " != " . $post['idUsuario'];
		return $this->verificarRepetido($this->tablas['usuarios']['tabla'], $where);
	}

	public function registrarUsuario($post)
	{
		$insert = [
			'idTipoDocumento' => $post['tipoDocumento'],
			'numDocumento' => trim($post['numDocumento']),
			'usuario' => trim($post['usuario']),
			'clave' => trim($post['clave']),
			'nombres' => trim($post['nombres']),
			'apePaterno' => trim($post['apePaterno']),
			'apeMaterno' => trim($post['apeMaterno']),
			'email' => trim($post['email']),
			'externo' => $post['externo'],
			'idEmpleado' => (!empty($post['idEmpleado'])) ? $post['idEmpleado'] : null,
			'flag_activo'=>1
		];

		$insert = $this->db->insert($this->tablas['usuarios']['tabla'], $insert);
		
		$this->insertId = $this->db->insert_id();
		
		$update = "UPDATE trade.usuario SET claveEncriptada=HASHBYTES('sha1','".trim($post['clave'])."') WHERE idUsuario='".$this->insertId."'";
		$this->db->query($update);
		$this->aSessTrack[] = [
			'idAccion' => 6,
			'tabla' => $this->tablas['usuarios']['tabla'],
			'id' => $this->insertId
		];

		return $insert;
	}

	public function actualizarUsuario($post)
	{
		$update = [
			'idTipoDocumento' => $post['tipoDocumento'],
			'numDocumento' => trim($post['numDocumento']),
			'usuario' => trim($post['usuario']),
			'clave' => trim($post['clave']),
			'nombres' => trim($post['nombres']),
			'apePaterno' => trim($post['apePaterno']),
			'apeMaterno' => trim($post['apeMaterno']),
			'email' => trim($post['email']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['usuarios']['id'] => $post['idUsuario']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['usuarios']['tabla'], $update);

		$this->aSessTrack[] = [
			'idAccion' => 7,
			'tabla' => $this->tablas['usuarios']['tabla'],
			'id' => $post['idUsuario']
		];

		return $update;
	}

	public function agregarEncargado($post)
	{
		$insertoEncargado = true;
		$insertoSubordinado = true;

		$sqlGetEncargado = "
			SELECT *
			FROM trade.encargado
			WHERE idUsuario = '" . $post['idUsuarioSuperior'] .
			"'";
		$encargado = $this->db->query($sqlGetEncargado)->row_array();

		$idEncargado = '';
		if (empty($encargado)) {
			$insertEncargado = [
				'idUsuario' => $post['idUsuarioSuperior'],
			];
			$insertoEncargado = $this->db->insert('trade.encargado', $insertEncargado);
			$idEncargado = $this->db->insert_id();

			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => 'trade.encargado', 'id' => $idEncargado ];
		} else {
			$idEncargado = $encargado['idEncargado'];
		}

		$insertSubordinado = [
			'idEncargado' => $idEncargado,
			'idUsuario' => $post['idUsuario'],
		];

		$insertoSubordinado = $this->db->insert('trade.encargado_usuario', $insertSubordinado);
		$id = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => 'trade.encargado_usuario', 'id' => $id ];

		return $insertoEncargado && $insertoSubordinado;
	}

	public function eliminarSubordinado($post)
	{
		$this->db->where('idUsuario', $post['idUsuario']);
		$delete = $this->db->delete('trade.encargado_usuario');

		$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.encargado_usuario', 'id' => $post['idUsuario'] ];
		return $delete;
	}

	public function getTiposDeUsuario($nombre = NULL)
	{
		$filtro= '';
		if(!empty($nombre)){
			$filtro=" AND ut.nombre+' - '+cu.nombre='".$nombre."'";
		}
		$sql = "
			SELECT tuc.idCuenta, 
				ut.idTipoUsuario, 
				ut.nombre tipoUsuario
				,ut.nombre+' - '+cu.nombre  tipoUsuarioCuenta
			FROM trade.tipoUsuarioCuenta tuc
				INNER JOIN trade.usuario_tipo ut ON ut.idTipoUsuario = tuc.idTipoUsuario
				JOIN trade.cuenta cu
					ON cu.idCuenta = tuc.idCuenta
			WHERE
				1=1
				$filtro
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tipoUsuarioCuenta' ];
		return $this->db->query($sql);
	}

	public function getAplicaciones($nombre = NULL)
	{
		$filtro= '';
		if(!empty($nombre)){
			$filtro=" AND nombre='".$nombre."'";
		}
		$sql = "
			SELECT idAplicacion, nombre,ISNULL(idCuenta,0) AS idCuenta, flagAndroid
			FROM trade.aplicacion
			WHERE estado = 1 $filtro;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.aplicacion' ];
		return $this->db->query($sql);
	}
	
	public function getCuentaProyecto($nombre = null){
		$filtro='';
		if(!empty($nombre)){
			$filtro = "AND p.nombre+' - '+c.nombre  = '".$nombre."' ";
		}
		$sql="
			SELECT idProyecto,p.nombre+' - '+c.nombre proyecto
			FROM trade.proyecto p
			JOIN trade.cuenta c
				ON c.idCuenta = p.idCuenta
			WHERE p.estado = 1 $filtro
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql);
	}

	public function getProyectos()
	{
		$sql = "
			SELECT *
			FROM trade.proyecto
			WHERE estado = 1;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql);
	}

	public function getCuentas()
	{
		$sql = "
			SELECT 
			idCuenta AS id,
			nombre
			FROM trade.cuenta
			WHERE estado = 1;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function registrarHistorico($post)
	{
		$insert = [
			'idUsuario' => trim($post['idUsuario']),
			'idProyecto' => trim($post['proyectoHistorico']),
			'idTipoUsuario' => trim($post['tipoUsuarioHistorico']),
			'idAplicacion' => trim($post['aplicacionHistorico']),
			'fecIni' => trim($post['fechaInicio']),
		];

		$insert = $this->db->insert($this->tablas['usuarioHistorico']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [
				'idAccion' => 6,
				'tabla' => $this->tablas['usuarioHistorico']['tabla'],
				'id' => $this->insertId
			];

		return $insert;
	}

	public function checkUsuarioHistoricoActivoRepetido($post)
	{
		$idUsuario = $post['idUsuario'];
		$idAplicacion = !empty($post['aplicacionHistorico']) ? $post['aplicacionHistorico'] : 0;
		$idProyecto = !empty($post['proyectoHistorico']) ? $post['proyectoHistorico'] : 0;
		$idTipoUsuario = !empty($post['tipoUsuarioHistorico']) ? $post['tipoUsuarioHistorico'] : 0;
		$fechaIni = $post['fechaInicio'];
		$sql = "
			DECLARE @fecIni DATE= '{$fechaIni}', @fecFin DATE= '{$fechaIni}';
			SELECT *
			FROM trade.usuario_historico uh
			WHERE fn.datesBetween(uh.fecIni, uh.fecFin, @fecIni, @fecFin) = 1
			AND uh.idUsuario = $idUsuario
			AND uh.idAplicacion = $idAplicacion
			AND uh.idProyecto = $idProyecto
			AND uh.idTipoUsuario = $idTipoUsuario
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_historico' ];

		$historicosActivos = $this->db->query($sql)->result_array();

		if (count($historicosActivos) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function registraPermisosIniciales($post)
	{
		$idUsuario = $post['idUsuario'];
		$modulosIniciales = array_column($this->getModulosPorTipoDeusuario($post)->result_array(), 'idModulo');

		$input = [];
		foreach ($modulosIniciales as $idModulo) {
			$input[] = [
				'idUsuario' => $idUsuario,
				'idModulo' => $idModulo,
			];
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_usuarios->tablas['modulosMovil']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_usuarios->tablas['modulosMovil']['tabla'] ];
		return $insert;
	}

	public function getModulosPorTipoDeusuario($post)
	{
		$idTipoUsuario = $post['tipoUsuarioHistorico'];
		$idAplicacion = $post['aplicacionHistorico'];

		$sql = "
			SELECT amt.idModulo
			FROM trade.aplicacion_modulo_tipoUsuario amt
				JOIN trade.aplicacion_modulo am ON am.idModulo = amt.idModulo
			WHERE amt.idTipoUsuario = ?
				AND am.idAplicacion = ?
				AND amt.estado = 1;
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.aplicacion_modulo_tipoUsuario' ];
		return $this->db->query($sql, [$idTipoUsuario, $idAplicacion]);
	}

	public function getGruposYCarpetas()
	{
		$filtros = "";
		$idCuenta = $this->sessIdCuenta;
		!empty($idCuenta) ? $filtros .= " AND g.idCuenta = {$idCuenta}" : '' ;

		$sql = "
			SELECT g.idGrupo, 
				g.nombre nombreGrupo, 
				c.idCarpeta, 
				c.nombre nombreCarpeta
			FROM {$this->sessBDCuenta}.trade.gestorArchivos_grupo g
				INNER JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON c.idGrupo = g.idGrupo
			WHERE g.estado = 1
				AND c.estado = 1
				{$filtros}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_grupo" ];
		return $this->db->query($sql);
	}
	
	public function obtenerTipoDocumento($tipoDocumento)
	{
		$sql = "
			SELECT idTipoDocumento
			FROM trade.usuario_tipoDocumento
			WHERE nombre='".$tipoDocumento."'
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_tipoDocumento' ];
		return $this->db->query($sql);
	}

	public function getCarpetasDeUsuario($post)
	{
		$idUsuario = $post['idUsuario'];

		$sql = "
			SELECT pc.idCarpeta
			FROM {$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta pc
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON pc.idCarpeta = c.idCarpeta
			WHERE idUsuario = {$idUsuario}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta" ];
		return $this->db->query($sql);
	}

	public function obtener_permisos(){
		$sql ="
			SELECT 
				idMenuOpcion
				, mo.nombre 
				, gm.idGrupoMenu
				, gm.nombre grupoMenu
				, mo.idSubGrupoMenu
				, mo.cssIcono icono
				, sgm.idSubGrupoMenu
				, sgm.nombre subGrupoMenu
			FROM 
				trade.menuOpcion mo
				JOIN trade.grupoMenu gm ON gm.idGrupoMenu = mo.idGrupoMenu
				LEFT JOIN trade.subGrupoMenu sgm ON sgm.idSubGrupoMenu = mo.idSubGrupoMenu
			WHERE 
				mo.estado=1
			ORDER BY gm.orden, sgm.orden, mo.orden ASC
				--AND idGrupoMenu <>4
		";

		$query=$this->db->query($sql);
		//auditoria
		$array = array('empleado'=>$this->idEmpleado,'accion'=>'LISTA','tabla'=>"trade.menuOpcion",'sql'=>$this->db->last_query());
		guardarAuditoria($array);
		//

		return $query;
	}

	public function obtener_usuarios_permisos($ids){
		$filtro = "";

		if(!empty($ids)){
			$filtro = " AND a.idUsuario IN (".implode(",", $ids).")";
		}

		$sql ="
		SELECT
			CASE WHEN amo.estado = 1 THEN 'TRUE' ELSE 'FALSE' END AS estado
			, a.idUsuario AS id
			, a.nombres+' '+a.apePaterno+' '+ISNULL(a.apeMaterno,'') AS nombres
			--, a.nombres AS nombres
			--, a.apePaterno AS apePat
			--, a.apeMaterno AS apeMat
			--, a.idTipoDocumento
			, td.breve AS tipoDoc
			, a.numDocumento AS documento
			, a.usuario AS usuario
			--, mo.idGrupoMenu
			, gm.nombre AS grupoMenu
			--, mo.idSubGrupoMenu
			, sgm.nombre AS subGrupoMenu
			--, amo.idMenuOpcion
			, mo.nombre AS menuOpcion
		FROM trade.usuario a
		LEFT JOIN trade.usuario_menuOpcion amo ON a.idUsuario = amo.idUsuario
		LEFT JOIN trade.menuOpcion mo ON amo.idMenuOpcion = mo.idMenuOpcion
		LEFT JOIN trade.usuario_tipoDocumento td ON a.idTipoDocumento = td.idTipoDocumento
		LEFT JOIN trade.grupoMenu gm ON mo.idGrupoMenu = gm.idGrupoMenu
		LEFT JOIN trade.subGrupoMenu sgm ON mo.idSubGrupoMenu = sgm.idSubGrupoMenu
		WHERE a.estado = 1
		{$filtro}
		ORDER BY nombres, grupoMenu, subGrupoMenu, menuOpcion
		";

		$query=$this->db->query($sql);

		$array = array('empleado'=>$this->idEmpleado,'accion'=>'LISTA','tabla'=>"trade.menuOpcion",'sql'=>$this->db->last_query());
		guardarAuditoria($array);

		return $query;
	}

	public function menuOpcion(){
		$sql="
		SELECT
			gm.nombre AS grupoMenu
			, sgm.nombre AS subGrupoMenu
			, amo.nombre AS grupo
			, 'TRUE' AS estado
		FROM
			trade.menuOpcion amo
			JOIN trade.grupoMenu gm ON gm.idGrupoMenu = amo.idGrupoMenu AND gm.estado = 1
			LEFT JOIN trade.subGrupoMenu sgm ON sgm.idSubGrupoMenu = amo.idsubGrupoMenu AND sgm.estado = 1
		WHERE
			amo.estado = 1 
		ORDER BY gm.orden, sgm.orden, amo.orden ASC
		";
		return $this->db->query($sql);
	}

	public function obtener_usuarios_web(){
		$sql ="
			DECLARE @fecha date=getDate();
			SELECT
				a.idUsuario
				, a.nombres+' '+isnull(a.apePaterno,'')+' '+isnull(a.apeMaterno,'') empleado
				, t.breve
				, a.numDocumento
				, a.usuario
				, a.estado
			FROM
			trade.usuario a
			JOIN trade.usuario_tipoDocumento t
				ON t.idTipoDocumento = a.idTipoDocumento
			LEFT JOIN trade.usuario_historico ah ON ah.idUsuario = a.idUsuario 
			and @fecha between ah.fecIni AND ISNULL(ah.fecFin,@fecha)
		";

		$query=$this->db->query($sql);

		return $query;
	}

	public function delete_permisos($params = []){
		$result = [ 'status' => 0, 'msg' => '' ];

		$this->db->where_in('idUsuario', $params);
		$this->db->delete('trade.usuario_menuOpcion');

		return $result;
	}

	public function obtener_aplicacion(){
		$sql = "SELECT * FROM trade.aplicacion WHERE estado=1";

		return $this->db->query($sql);
	}

	public function obtener_usuarios_permisos_movil($ids){
		$filtro = "";

		if (!empty($ids)) {
			$filtro = " AND u.idUsuario IN (" . implode(",", $ids) . ")";
		}

		$sql = "
		DECLARE  @fecha DATE = GETDATE();
		SELECT
		u.idUsuario AS id
		, (u.nombres + ' ' + u.apePaterno + ' ' + ISNULL(u.apeMaterno,'')) AS nombres
		, u.numDocumento AS documento
		, app.nombre AS app
		, mo.nombre AS modulo
		, CASE WHEN umo.estado = 1 THEN 'TRUE' ELSE 'FALSE' END AS estado
		FROM 
		trade.usuario u
		LEFT JOIN trade.usuario_modulo umo ON u.idUsuario = umo.idUsuario
		LEFT JOIN trade.aplicacion_modulo mo ON umo.idModulo = mo.idModulo
		LEFT JOIN trade.aplicacion app ON mo.idAplicacion = app.idAplicacion
		WHERE 1 = 1
		{$filtro}
		ORDER by nombres, app, modulo
		";

		$query = $this->db->query($sql);

		return $query;
	}

	public function menuOpcion_movil(){
		$sql="
		SELECT
			amo.idModulo
			, app.nombre AS app
			, amo.nombre AS modulo
			, 'TRUE' AS estado
		FROM
			trade.aplicacion_modulo amo
			LEFT JOIN trade.aplicacion app ON amo.idAplicacion = app.idAplicacion
		WHERE
			amo.estado = 1
		ORDER BY app, amo.orden ASC
		";

		return $this->db->query($sql);
	}

	public function delete_permisos_movil($params = []){
		$result = [ 'status' => 0, 'msg' => '' ];

		$this->db->where_in('idUsuario', $params);
		$this->db->delete('trade.usuario_modulo');

		return $result;
	}

	public function actualizar_flag_nuevo($params = []){
		$result = [ 'status' => 0, 'msg' => '' ];

		$this->db->where_in('idUsuario', $params);
		$this->db->update('trade.usuario', [ 'flag_nuevo' => 0 ]);

		return $result;
	}
}
