<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Filtros extends My_Model
{

	var $CI;
	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'cuenta' => ['tabla' => 'trade.cuenta', 'id' => 'idCuenta'],
			'proyecto' => ['tabla' => 'trade.proyecto', 'id' => 'idProyecto'],
			'grupoCanal' => ['tabla' => 'trade.grupoCanal', 'id' => 'idGrupoCanal'],
			'canal' => ['tabla' => 'trade.canal', 'id' => 'idCanal'],
			'subCanal' => ['tabla' => 'trade.subCanal', 'id' => 'idSubCanal'],
			'distribuidora' => ['tabla' => 'trade.distribuidora', 'id' => 'idDistribuidora'],
			'distribuidoraSucursal' => ['tabla' => 'trade.distribuidoraSucursal', 'id' => 'idDistribuidoraSucursal'],
			'plaza' => ['tabla' => 'trade.plaza', 'id' => 'idPlaza'],
			'zona' => ['tabla' => 'trade.zona', 'id' => 'idZona'],
			'tipoPremiacion' => ['tabla' => 'trade.tipo_premiacion', 'id' => 'idTipoPremiacion'],
		];

		$this->CI =& get_instance();
	}

	// SECCION CUENTAS
	public function getCuentas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idCuenta = " . $post['id'];
		}

		$sql = "
				SELECT *
				FROM trade.cuenta
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function registrarCuenta($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'ruc' => trim($post['ruc']),
			'direccion' => trim($post['direccion']),
			'cod_ubigeo' => trim($post['ubigeo']),
			'nombreComercial' => trim($post['nombreComercial']),
			'razonSocial' => trim($post['razonSocial']),
			'urlCss' =>  !empty($post['urlCss']) ? trim($post['urlCss']) : null,
			'urlLogo' => !empty($post['urlLogo']) ? trim($post['urlLogo']) : null,
		];

		$insert = $this->db->insert($this->tablas['cuenta']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarCuenta($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'ruc' => trim($post['ruc']),
			'direccion' => trim($post['direccion']),
			'cod_ubigeo' => trim($post['ubigeo']),
			'nombreComercial' => trim($post['nombreComercial']),
			'razonSocial' => trim($post['razonSocial']),
			'urlCss' =>  !empty($post['urlCss']) ? trim($post['urlCss']) : null,
			'urlLogo' => !empty($post['urlLogo']) ? trim($post['urlLogo']) : null,
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['cuenta']['id'] => $post['idCuenta']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['cuenta']['tabla'], $update);
		return $update;
	}

	public function checkNombreCuentaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id'] . " != " . $post['idCuenta'];
		return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
	}

	public function checkRucCuentaRepetido($post)
	{
		$where = "ruc = '" . trim($post['ruc']) . "'";
		if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id']  . " != " . $post['idCuenta'];
		return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
	}

	public function checkNombreComercialCuentaRepetido($post)
	{
		$where = "nombreComercial = '" . trim($post['nombreComercial']) . "'";
		if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id']  . " != " . $post['idCuenta'];
		return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
	}

	public function checkRazonSocialCuentaRepetido($post)
	{
		$where = "razonSocial = '" . trim($post['razonSocial']) . "'";
		if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id'] . " != " . $post['idCuenta'];
		return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
	}

	// SECCION PROYECTOS
	public function getProyectos($post)
	{
		$idCuenta = $this->sessIdCuenta;
		$filtros = "WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
		if (!empty($idCuenta)) $filtros .= " AND c.idCuenta = " . $idCuenta;

		$sql = "
				SELECT p.*, 
					c.nombre cuenta
				FROM trade.proyecto p
					INNER JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				{$filtros}
			";

		// $this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql);
	}

	public function registrarProyecto($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta']),
			'fecIni' => trim($post['fechaInicio']),
			'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
		];

		$insert = $this->db->insert($this->tablas['proyecto']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarProyecto($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta']),
			'fecIni' => trim($post['fechaInicio']),
			'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['proyecto']['id'] => $post['idProyecto']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['proyecto']['tabla'], $update);
		return $update;
	}

	public function guardarMasivoProyecto($proyectos)
	{
		$input = [];
		foreach ($proyectos as $key => $value) {
			$input[$key] = [
				'nombre' => $value['nombre'],
				'idCuenta' => $value['idCuenta'],
				'fecIni' => date_change_format_bd($value['fechaInicio']),
				'fecFin' => date_change_format_bd($value['fechaFin'])
			];
		}

		$insert = $this->db->insert_batch($this->tablas['proyecto']['tabla'], $input);
		return $insert;
	}

	public function checkProyectoYCuentaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "' AND idCuenta = " . ((!empty($post['cuenta'])) ? $post['cuenta'] : 0);
		if (!empty($post['idProyecto'])) $where .= " AND " . $this->tablas['proyecto']['id'] . " != " . $post['idProyecto'];
		return $this->verificarRepetido($this->tablas['proyecto']['tabla'], $where);
	}

	// SECCION GRUPO CANAL
	public function getGrupoCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idGrupoCanal = " . $post['id'];
		}

		$sql = "
				SELECT *
				FROM trade.grupoCanal
				$filtros
			";

		return $this->db->query($sql);
	}

	public function registrarGrupoCanal($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
		];

		$insert = $this->db->insert($this->tablas['grupoCanal']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarGrupoCanal($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['grupoCanal']['id'] => $post['idGrupoCanal']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['grupoCanal']['tabla'], $update);
		return $update;
	}

	public function checkNombreGrupoCanalRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idGrupoCanal'])) $where .= " AND " . $this->tablas['grupoCanal']['id'] . " != " . $post['idGrupoCanal'];
		return $this->verificarRepetido($this->tablas['grupoCanal']['tabla'], $where);
	}

	// SECCION CANAL
	public function getCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.idCanal = " . $post['id'];
		}

		$sql = "
				SELECT c.*, 
					gc.nombre grupoCanal
				FROM trade.canal c
					INNER JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
				{$filtros}
			";

		// $this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		return $this->db->query($sql);
	}

	public function registrarCanal($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idGrupoCanal' => trim($post['grupoCanal']),
		];

		$insert = $this->db->insert($this->tablas['canal']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarCanal($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'idGrupoCanal' => trim($post['grupoCanal']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['canal']['id'] => $post['idCanal']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['canal']['tabla'], $update);
		return $update;
	}

	public function checkCanalYGrupoCanalRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "' AND idGrupoCanal = " . ((!empty($post['grupoCanal'])) ? $post['grupoCanal'] : 0);
		if (!empty($post['idCanal'])) $where .= " AND " . $this->tablas['canal']['id'] . " != " . $post['idCanal'];
		return $this->verificarRepetido($this->tablas['canal']['tabla'], $where);
	}

	// SECCION SUBCANAL
	public function getSubCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND s.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND s.idSubCanal = " . $post['id'];
		}

		$sql = "
			SELECT s.*, 
				c.nombre canal
			FROM trade.subCanal s
				INNER JOIN trade.canal c ON c.idCanal = s.idCanal
				$filtros
			";

		return $this->db->query($sql);
	}

	public function registrarSubCanal($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idCanal' => trim($post['canal']),
		];

		$insert = $this->db->insert($this->tablas['subCanal']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarSubCanal($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'idCanal' => trim($post['canal']),
			'fechaModificacion' => getActualDateTime(),
		];

		$where = [
			$this->tablas['subCanal']['id'] => $post['idSubCanal']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['subCanal']['tabla'], $update);
		return $update;
	}

	public function checkSubCanalYCanalRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "' AND idCanal = " . ((!empty($post['canal'])) ? $post['canal'] : 0);
		if (!empty($post['idSubCanal'])) $where .= " AND " . $this->tablas['subCanal']['id'] . " != " . $post['idSubCanal'];
		return $this->verificarRepetido($this->tablas['subCanal']['tabla'], $where);
	}

	public function getDistribuidoraSucursal($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['distribuidora']['id']." = " . $post['id'];
		}

		$sql = "
				SELECT
				ds.*
				,d.nombre distribuidora
				,u.cod_departamento
				,u.departamento
				,u.provincia
				,u.cod_provincia
				,u.distrito
				,u.cod_distrito
				FROM trade.distribuidoraSucursal ds
				JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
				JOIN General.dbo.ubigeo u ON u.cod_ubigeo = ds.cod_ubigeo
                $filtros
			";

		return $this->db->query($sql);
	}

	public function checkDistribuidoraSucursalRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idDistribuidoraSucursal'])) $where .= " AND idDistribuidoraSucursal != " . $post['idDistribuidoraSucursal'];
		if (!empty($post['idDistribuidora'])) $where .= " AND idDistribuidora = " . trim($post['idDistribuidora']);
		if (!empty($post['cod_ubigeo'])) $where .= " AND cod_ubigeo = " . trim($post['cod_ubigeo']);
		return $this->verificarRepetido('trade.distribuidoraSucursal', $where);
	}

	public function registrarDistribuidoraSucursal($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'cod_ubigeo' => trim($post['cod_ubigeo']),
			'idDistribuidora' => trim($post['distribuidora']),
			'correoDistribuidoraSucursal' => trim($post['correo'])
		];

		$insert = $this->db->insert('trade.distribuidoraSucursal', $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarDistribuidoraSucursal($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'correoDistribuidoraSucursal' => trim($post['correo']),
			'cod_ubigeo' => trim($post['cod_ubigeo']),
			'idDistribuidora' => trim($post['distribuidora']),
			'fechaModificacion' => getActualDateTime()
		];

		$where = [
			'idDistribuidoraSucursal' => $post['idDistribuidoraSucursal']
		];

		$this->db->where($where);
		$update = $this->db->update('trade.distribuidoraSucursal', $update);
		return $update;
	}

	public function getUbigeo($post = []){
		$sql = "
		SELECT DISTINCT
		cod_departamento
		,departamento
		FROM General.dbo.ubigeo
		WHERE estado = 1
		";
		
		$filtros = " AND estado = 1";
		!empty($post['cod_departamento']) ? $sql = " SELECT DISTINCT cod_provincia,provincia FROM General.dbo.ubigeo WHERE cod_departamento = {$post['cod_departamento']} {$filtros}" : '';
		!empty($post['cod_provincia']) AND !empty($post['cod_departamento']) ? $sql = " SELECT  cod_ubigeo,cod_distrito,distrito FROM General.dbo.ubigeo WHERE cod_provincia = {$post['cod_provincia']} AND cod_departamento = {$post['cod_departamento']} {$filtros}" : '';

		return $this->db->query($sql);
	}

	public function getDistribuidoras($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idDistribuidora = " . $post['id'];
		}

		$sql = "
				SELECT
				idDistribuidora AS cod_distribuidora,
				nombre AS distribuidora,
				correoDistribuidora,
				estado
				FROM trade.distribuidora
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function registrarDistribuidora($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'correoDistribuidora' => trim($post['correoDistribuidora'])
		];

		$insert = $this->db->insert('trade.distribuidora', $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarDistribuidora($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'correoDistribuidora' => trim($post['correoDistribuidora']),
			'fechaModificacion' => getActualDateTime()
		];

		$where = [
			'idDistribuidora' => $post['idDistribuidora']
		];

		$this->db->where($where);
		$update = $this->db->update('trade.distribuidora', $update);
		return $update;
	}

	public function checkDistribuidoraRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']). "'";
		if (!empty($post['idDistribuidora'])) $where .= " AND idDistribuidora != " . $post['idDistribuidora'];
		return $this->verificarRepetido('trade.distribuidora', $where);
	}

	public function getPlazas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idPlaza = " . $post['id'];
		}

		$sql = "
				SELECT *
				FROM trade.plaza
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function registrarPlaza($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'cod_ubigeo' => trim($post['cod_ubigeo']),
			'direccion' => trim($post['direccion']),
			'nombreMayorista' => trim($post['nombreMayorista']),
			'flagMayorista' => empty($post['nombreMayorista']) ? 0 : 1
		];

		$insert = $this->db->insert('trade.plaza', $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarPlaza($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'cod_ubigeo' => trim($post['cod_ubigeo']),
			'direccion' => trim($post['direccion']),
			'nombreMayorista' => trim($post['nombreMayorista']),
			'flagMayorista' => empty($post['nombreMayorista']) ? 0 : 1,
			'fechaModificacion' => getActualDateTime()
		];

		$where = [
			'idPlaza' => $post['idPlaza']
		];

		$this->db->where($where);
		$update = $this->db->update('trade.plaza', $update);
		return $update;
	}

	public function checkPlazaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']). "'";
		if (!empty($post['idPlaza'])) $where .= " AND idPlaza != " . $post['idPlaza'];
		return $this->verificarRepetido('trade.plaza', $where);
	}

	public function getZonas($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idZona = " . $post['id'];
			if (!empty($post['cuenta_filtro'])) $filtros .= " AND idCuenta = " . $post['cuenta_filtro'];
			if (!empty($post['idProyecto'])) $filtros .= " AND proyecto_filtro = " . $post['proyecto_filtro'];
		}

		$sql = "
				SELECT *
				FROM trade.zona
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function checkZonaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']). "' AND idCuenta = " . trim($post['cuenta_zona']). " AND idProyecto = " . trim($post['proyecto_zona']);
		if (!empty($post['idZona'])) $where .= " AND idZona != " . $post['idZona'];
		return $this->verificarRepetido('trade.zona', $where);
	}

	public function registrarZona($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta_zona']),
			'idProyecto' => trim($post['proyecto_zona']),
		];

		$insert = $this->db->insert('trade.zona', $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarZona($post)
	{
		$update = [
			'nombre' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta_zona']),
			'idProyecto' => trim($post['proyecto_zona'])
		];

		$where = [
			'idZona' => $post['idZona']
		];

		$this->db->where($where);
		$update = $this->db->update('trade.zona', $update);
		return $update;
	}

	public function getTipoPremiacion($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idTipoPremiacion = " . $post['id'];
			if (!empty($post['cuenta_filtro'])) $filtros .= " AND idCuenta = " . $post['cuenta_filtro'];
		}

		$sql = "
				SELECT *
				FROM trade.tipo_premiacion
				{$filtros}
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function checkTipoPremiacionRepetido($post)
	{
		$where = "descripcion = '" . trim($post['nombre']). "' AND idCuenta = " . trim($post['cuenta_tipoPremiacion']);
		if (!empty($post['idTipoPremiacion'])) $where .= " AND idTipoPremiacion != " . $post['idTipoPremiacion'];
		return $this->verificarRepetido('trade.tipo_premiacion', $where);
	}

	public function registrarTipoPremiacion($post)
	{
		$insert = [
			'descripcion' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta_tipoPremiacion']),
			'detalle' => 1,
			'estado' => 1
		];

		$insert = $this->db->insert('trade.tipo_premiacion', $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
	}

	public function actualizarTipoPremiacion($post)
	{
		$update = [
			'descripcion' => trim($post['nombre']),
			'idCuenta' => trim($post['cuenta_tipoPremiacion'])
		];

		$where = [
			'idTipoPremiacion' => $post['idTipoPremiacion']
		];

		$this->db->where($where);
		$update = $this->db->update('trade.tipo_premiacion', $update);
		return $update;
	}
}
