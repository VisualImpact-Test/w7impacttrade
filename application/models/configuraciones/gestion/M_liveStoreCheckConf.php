<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_liveStorecheckConf extends My_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'infoPlaza' => ['tabla' => 'lsck.tipoInfo', 'id' => 'idInfo'],
			'tipoCliente' => ['tabla' => 'lsck.tipoCliente', 'id' => 'idTipoCliente'],
			'tipoResponsable' => ['tabla' => 'lsck.responsableTipo', 'id' => 'idTipo'],
			'responsable' => ['tabla' => 'lsck.responsable', 'id' => 'idResponsable'],
			'tipoAuditoria' => ['tabla' => 'lsck.ext_auditoriaTipo', 'id' => 'idExtAudTipo'],
			'empresa' => ['tabla' => 'lsck.tipoEmpresa', 'id' => 'idEmpresa'],
			'infPlaza' => ['tabla' => 'lsck.conf_plazaInfo', 'id' => 'idPlazaInfo'],
			'confPlaza' => ['tabla' => 'lsck.conf_plaza', 'id' => 'idConfPlaza'],
			'confCliente' => ['tabla' => 'lsck.conf_cliente', 'id' => 'idConfCliente'],
			'confTipoCliente' => ['tabla' => 'lsck.conf_tipoClienteAud', 'id' => 'idTipoClienteAud','tablaDet' => 'lsck.conf_tipoClienteAudDet'],
			'listaEvaluacion' => ['tabla' => 'lsck.listEvaluacion', 'id' => 'idListEval','tablaDet' => 'lsck.listEvaluacionDet'],
			'preguntas' => ['tabla' => 'lsck.tipoEncuesta', 'id' => 'idEncuesta'],
			'tipoEvaluacion' => ['tabla' => 'lsck.tipoEvaluacion', 'id' => 'idEvaluacion'],
			'evaluacion' => ['tabla' => 'lsck.tipoEvaluacionDet', 'id' => 'idEvaluacionDet'],
			'materiales' => ['tabla'=> 'lsck.ext_auditoriaMaterial','id' => 'idExtAudMat'],
		];
	}

	public function getInfoPlaza($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['infoPlaza']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,c.nombre cuenta
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
                FROM
                ".$this->tablas['infoPlaza']['tabla']." p
				LEFT JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
                $filtros
			";

		return $this->db->query($sql);
	}

	public function regitrarInfoPlaza($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
			'idCuenta' => $post['sl_cuentas']
        ];

		$insert = $this->db->insert($this->tablas['infoPlaza']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarInfoPlaza($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'idCuenta' => $post['sl_cuentas'],
			'fechaModificacion'=>getActualDateTime(),
			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['infoPlaza']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['infoPlaza']['tabla'], $update);
		return $update;
    }
    
	public function checkNombreElementoRepetido($post,$tabla='')
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas[$tabla]['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas[$tabla]['tabla'], $where);
	}

	public function getCuentas(){
		$sql ="
		SELECT
		idCuenta id
		,nombre value
		FROM 
		trade.cuenta
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getInfos(){
		$sql ="
		SELECT
		idInfo id
		,nombre value
		FROM 
		lsck.tipoInfo
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getEmpresas(){
		$sql ="
		SELECT
		idEmpresa id
		,nombre value
		FROM 
		lsck.tipoEmpresa
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getTiposCliente(){
		$sql ="
		SELECT
		idTipoCliente id
		,nombre value
		FROM 
		lsck.tipoCliente
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getTiposAuditoria(){
		$sql ="
		SELECT
		idTipoAuditoria id
		,nombre value
		FROM 
		lsck.tipoAuditoria
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getEvaluacionesDet(){
		$sql ="
		SELECT
		idEvaluacionDet id
		,nombre value
		FROM 
		lsck.tipoEvaluacionDet
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getEncuestas(){
		$sql ="
		SELECT
		idEncuesta id
		,nombre value
		FROM 
		lsck.tipoEncuesta
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getTiposResponsable(){
		$sql ="
		SELECT
		idTipo id
		,nombre value
		FROM 
		lsck.responsableTipo
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getTiposPregunta(){
		$sql ="
		SELECT
		idTipoPregunta id
		,nombre value
		FROM 
		master.tipoPregunta
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getPreguntas(){
		$sql ="
		SELECT
		idPregunta id
		,nombre value
		FROM 
		lsck.tipoEncuestaPreg
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getPreguntasEncuesta(){
		$sql ="
		SELECT
		idPregunta id
		,nombre value
		,idEncuesta idEncuesta
		FROM 
		lsck.tipoEncuestaPreg
		WHERE estado = 1
		";
		return $this->db->query($sql);
	}
	public function getTipoAud($id = ''){
		$filtros = '';

		!empty($id) ? $filtros = " AND idExtAudTipo = {$id} " : '';
		$sql ="
		SELECT
		idExtAudTipo id
		,nombre value
		FROM 
		lsck.ext_auditoriaTipo
		WHERE estado = 1
		$filtros
		";
		return $this->db->query($sql);
	}

	public function getClientes($post = array()){
		$filtros = 'WHERE 1 = 1 ';

		!empty($post['idPlaza']) ? $filtros .= " AND idPlaza = {$post['idPlaza']} " : '';
		(!empty($post['idCliente'])) ? $filtros .= " AND idCliente = {$post['idCliente']} " : '';
		$sql ="
		SELECT 
		idCliente id
		,razonSocial value
		FROM pg.dbo.cliente
		$filtros
		";
		return $this->db->query($sql);
	}

	public function getMatExtByTipoAud($idTipoAud,$buscar = ''){
		$sql_top = '';
		$filtros = '';
		!empty($top) ? $sql_top .= " TOP {$top} ": "" ;	
		!empty($buscar) ? $filtros .=" AND am.nombre LIKE '%{$buscar}%'": "";
		
		$sql = "
		SELECT 
		am.idExtAudMat id
		,am.nombre value
		,ta.nombre tipoAuditoria
		FROM lsck.ext_auditoriaMaterial am
		LEFT JOIN lsck.ext_auditoriaTipo ta ON ta.idExtAudTipo =am.idExtAudTipo
		WHERE am.estado = 1 AND am.idExtAudTipo = {$idTipoAud} $filtros
		";
		return $this->db->query($sql);
	}
	public function getMatExt($params = array()){
		$sql = "
		SELECT 
		idExtAudMat id
		,nombre value
		,idExtAudTipo
		FROM lsck.ext_auditoriaMaterial
		WHERE estado = 1 
		";
		return $this->db->query($sql);
	}
	public function getConfClienteTipoCb(){
		$sql = "
		SELECT  
		p.idConfCliente id
		,UPPER(c.razonSocial  + ' - ' + tc.nombre) as value
		FROM
		lsck.conf_cliente p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN lsck.tipoCliente tc ON tc.idTipoCliente = p.idTipoCliente
		LEFT JOIN pg.dbo.cliente c ON c.idCliente = p.idCliente
		WHERE  ISNULL(fecFin,GETDATE()) BETWEEN fecIni AND GETDATE()
		";
		return $this->db->query($sql);
	}
	public function getTiposEvaluacion(){
		$sql = "
		SELECT 
		idEvaluacion id
		,nombre value
		FROM lsck.tipoEvaluacion
		WHERE estado = 1 
		";
		return $this->db->query($sql);
	}
	public function getPlazas($post = array()){
		$filtros = '';

		!empty($post['idPlaza']) ? $filtros = " OR pz.idPlaza = {$post['idPlaza']} " : '';

		$sql ="
		SELECT  pz.idPlaza id, 
		ISNULL(d.nombre,'NULL')+' - '+ISNULL(u_d.distrito,'NULL')+' '+ pz.descripcion value
		FROM pg.auditoria.plazaCliente pz
		JOIN pg.dbo.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = pz.idDistribuidoraSucursal AND ds.estado = 1
		JOIN pg.dbo.distribuidora d ON d.idDistribuidora = ds.idDistribuidora AND d.estado = 1
		JOIN General.dbo.ubigeo u_d ON u_d.cod_ubigeo = ds.cod_ubigeo
		WHERE 1 = 1{$filtros}
		ORDER BY value
		";
		return $this->db->query($sql);
	}
	public function getTipoCliente($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['tipoCliente']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
                FROM
                ".$this->tablas['tipoCliente']['tabla']." p
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
                $filtros
			";

		return $this->db->query($sql);
	}

	public function registrarTipoCliente($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
        ];

		$insert = $this->db->insert($this->tablas['tipoCliente']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarTipoCliente($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'fechaModificacion'=>getActualDateTime(),
			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['tipoCliente']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['tipoCliente']['tabla'], $update);
		return $update;
    }
	public function getTipoResponsable($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['tipoResponsable']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
                FROM
                ".$this->tablas['tipoResponsable']['tabla']." p
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
                $filtros
			";

		return $this->db->query($sql);
	}
	public function getResponsable($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['responsable']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
				,rt.nombre tipoResponsable
                FROM
                ".$this->tablas['responsable']['tabla']." p
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
				LEFT JOIN lsck.responsableTipo rt ON rt.idTipo = p.idTipo
                $filtros
			";

		return $this->db->query($sql);
	}

	public function registrarTipoResponsable($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];

		$insert = $this->db->insert($this->tablas['tipoResponsable']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarTipoResponsable($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'fechaModificacion'=>getActualDateTime(),

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['tipoResponsable']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['tipoResponsable']['tabla'], $update);
		return $update;
    }
	public function registrarResponsable($post)
	{
		$insert = [
            'nombres' => trim($post['nombres']),
            'apellidos' => trim($post['apellidos']),
            'email' => trim($post['email']),
            'idTipo' => trim($post['sl_tipo']),

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];

		$insert = $this->db->insert($this->tablas['responsable']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarResponsable($post)
	{

		$update = [
			'nombres' => trim($post['nombres']),
            'apellidos' => trim($post['apellidos']),
            'email' => trim($post['email']),
            'idTipo' => trim($post['sl_tipo']),

			'fechaModificacion'=>getActualDateTime(),

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['responsable']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['responsable']['tabla'], $update);
		return $update;
    }
	public function getEmpresa($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['empresa']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
                FROM
                ".$this->tablas['empresa']['tabla']." p
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
                $filtros
			";

		return $this->db->query($sql);
	}

	public function registrarEmpresa($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
        ];

		$insert = $this->db->insert($this->tablas['empresa']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarEmpresa($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'fechaModificacion'=>getActualDateTime(),
			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['empresa']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['empresa']['tabla'], $update);
		return $update;
    }
	public function getInfPlaza($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['infPlaza']['id']." = " . $post['id'];
		}

		$sql = "
		SELECT
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,plz.descripcion plaza
		,ti.nombre info
		,te.nombre empresa
		,d.nombre + ' - ' + u_d.distrito distribuidora
		FROM
		lsck.conf_plazaInfo p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN pg.auditoria.plazaCliente plz ON plz.idPlaza = p.idPlaza
		LEFT JOIN lsck.tipoInfo ti ON ti.idInfo = p.idInfo
		LEFT JOIN lsck.tipoEmpresa te ON te.idEmpresa = p.idEmpresa
		LEFT JOIN pg.dbo.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = plz.idDistribuidoraSucursal
		LEFT JOIN pg.dbo.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo u_d ON u_d.cod_ubigeo = ds.cod_ubigeo
		$filtros
			";

		return $this->db->query($sql);
	}

	public function registrarInfPlaza($post)
	{
		$insert = [
            'idPlaza' => trim($post['sl_plazas']),
            'idInfo' => trim($post['sl_tipoInfo']),
            'valor' => trim($post['valor']),
			'fecIni' => $post['fechaInicio'],
 
			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
			
		];
		!empty($post['sl_empresas']) ? $insert['idEmpresa'] = $post['sl_empresas']: $insert['idEmpresa'] = NULL ;
		!empty($post['fechaFin'])? $insert['fecFin'] = $post['fechaFin']: '';

		$insert = $this->db->insert($this->tablas['infPlaza']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarInfPlaza($post)
	{

		$update = [
            'idPlaza' => trim($post['sl_plazas']),
            'idInfo' => trim($post['sl_tipoInfo']),
            'valor' => trim($post['valor']),
			'fecIni' => $post['fechaInicio'],
			
			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),

			'fechaModificacion'=>getActualDateTime(),

        ];
        
		$where = [
			$this->tablas['infPlaza']['id'] => $post['idx']
		];
	
		!empty($post['sl_empresas']) ? $update['idEmpresa'] = $post['sl_empresas']: $update['idEmpresa'] = NULL ;
		!empty($post['fechaFin'])? $update['fecFin'] = $post['fechaFin']: '';

		$this->db->where($where);
		$update = $this->db->update($this->tablas['infPlaza']['tabla'], $update);
		return $update;
    }

	public function getConfPlaza($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['confPlaza']['id']." = " . $post['id'];
		}

		$sql = "
		SELECT
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,plz.descripcion plaza
		,tc.nombre tipoCliente
		,tae.nombre tipoAuditoriaExt 
		,d.nombre + ' - ' + u_d.distrito distribuidora
		FROM
		lsck.conf_plaza p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN pg.auditoria.plazaCliente plz ON plz.idPlaza = p.idPlaza
		LEFT JOIN lsck.tipoCliente tc ON tc.idTipoCliente = p.idTipoCliente
		LEFT JOIN lsck.ext_auditoriaTipo tae ON tae.idExtAudTipo = p.idExtAudTipo
		LEFT JOIN pg.dbo.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = plz.idDistribuidoraSucursal
		LEFT JOIN pg.dbo.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo u_d ON u_d.cod_ubigeo = ds.cod_ubigeo
		$filtros
		";

		return $this->db->query($sql);
	}

	public function registrarConfPlaza($post)
	{
		$insert = [
            'idPlaza' => trim($post['sl_plazas']),
            'idTipoCliente' => trim($post['sl_tipoCliente']),
            'idExtAudTipo' => trim($post['sl_tipoAuditoria']),
            'extAudPromedio' => trim($post['audPromedio']),
			'fecIni' =>  $post['fechaInicio'],

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
			
		];

		!empty($post['audTotal'])? $insert['extAudTotal'] = $post['audTotal']: '';
		!empty($post['fechaFin'])? $insert['fecFin'] = $post['fechaFin']: '';

		$insert = $this->db->insert($this->tablas['confPlaza']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarConfPlaza($post)
	{

		$update = [
            'idPlaza' => trim($post['sl_plazas']),
            'idTipoCliente' => trim($post['sl_tipoCliente']),
            'idExtAudTipo' => trim($post['sl_tipoAuditoria']),
            'extAudPromedio' => trim($post['audPromedio']),
			'fecIni' =>  $post['fechaInicio'],

 
			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),

			'fechaModificacion'=>getActualDateTime(),

        ];
		!empty($post['audTotal'])? $update['extAudTotal'] = $post['audTotal']: '';
		!empty($post['fechaFin'])? $update['fecFin'] = $post['fechaFin']: '';

		$where = [
			$this->tablas['confPlaza']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['confPlaza']['tabla'], $update);
		return $update;
    }
	public function getTipoAuditoria($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['tipoAuditoria']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
                FROM
                ".$this->tablas['tipoAuditoria']['tabla']." p
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
                $filtros
			";

		return $this->db->query($sql);
	}

	public function registrarTipoAuditoria($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];

		$insert = $this->db->insert($this->tablas['tipoAuditoria']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarTipoAuditoria($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'fechaModificacion'=>getActualDateTime(),

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['tipoAuditoria']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['tipoAuditoria']['tabla'], $update);
		return $update;
    }

	public function getConfCliente($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['confCliente']['id']." = " . $post['id'];
			if (!empty($post['idCliente'])) $filtros .= " AND p.idCliente = " . $post['idCliente'];
			if (!empty($post['idTipoCliente'])) $filtros .= " AND p.idTipoCliente = " . $post['idTipoCliente'];
			if (!empty($post['idCuenta'])) $filtros .= " AND p.idCuenta = " . $post['idCuenta'];
			if (!empty($post['idProyecto'])) $filtros .= " AND p.idProyecto = " . $post['idProyecto'];
		}

		$sql = "
		SELECT  
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,UPPER(c.razonSocial) razonSocial
		,tc.nombre tipoCliente
		,c.codigo
		,c.idPlaza
		,d.nombre + ' - ' + u_d.distrito distribuidora
		,pz.descripcion plaza
		FROM
		lsck.conf_cliente p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN lsck.tipoCliente tc ON tc.idTipoCliente = p.idTipoCliente
		LEFT JOIN pg.dbo.cliente c ON c.idCliente = p.idCliente
		LEFT JOIN pg.auditoria.plazaCliente pz ON pz.idPlaza = c.idPlaza
		LEFT JOIN pg.dbo.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = pz.idDistribuidoraSucursal
		LEFT JOIN pg.dbo.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
		LEFT JOIN General.dbo.ubigeo u_d ON u_d.cod_ubigeo = ds.cod_ubigeo
		$filtros
		";

		return $this->db->query($sql);
	}
	public function getConfClientesAud($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND cc.".$this->tablas['confCliente']['id']." = " . $post['id'];
			if (!empty($post['idClienteAud'])) $filtros .= " AND p.idConfClienteAud = " . $post['idClienteAud'];

		}

		$sql = "
		SELECT
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,UPPER(c.razonSocial) razonSocial
		,aut.nombre tipoAuditoria
		,tc.nombre tipoCliente
		,ISNULL(c.idCliente,cc.idCliente) idCliente	
		FROM
		lsck.conf_clienteAud p
		LEFT JOIN lsck.conf_cliente cc ON cc.idConfCliente = p.idConfCliente
		LEFT JOIN pg.dbo.cliente c ON c.idCliente = cc.idCliente
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN lsck.ext_auditoriaTipo aut ON aut.idExtAudTipo = p.idExtAudTipo
		LEFT JOIN lsck.tipoCliente tc ON tc.idTipoCliente = cc.idTipoCliente
		$filtros
		";

		return $this->db->query($sql);
	}
	public function getConfClientesAudDet($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND p.idConfClienteAud = " . $post['id'];
		}

		$sql = "
		SELECT
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,aum.nombre material
		,aut.nombre tipoAuditoria
		,aum.idExtAudMat codigoSKU
		,CASE WHEN p.presencia = 1 THEN 'SI' ELSE 'NO' END flag_presencia
		FROM
		lsck.conf_clienteAudDet p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN lsck.ext_auditoriaMaterial aum ON aum.idExtAudMat = p.idExtAudMat AND aum.estado = 1
		LEFT JOIN lsck.conf_clienteAud cca ON cca.idConfClienteAud = p.idConfClienteAud
		LEFT JOIN lsck.ext_auditoriaTipo aut ON aut.idExtAudTipo = cca.idExtAudTipo
		$filtros
		";

		return $this->db->query($sql);
	}

	public function registrarConfCliente($post)
	{
		$insert = [
            'idCliente' => trim($post['sl_clientes']),
            'idTipoCliente' => trim($post['sl_tipoCliente']),
			'fecIni' =>  $post['fechaInicio'],

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
			
		];

		!empty($post['fechaFin'])? $insert['fecFin'] = $post['fechaFin']: '';

		$insert = $this->db->insert($this->tablas['confCliente']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
	public function registrarConfClienteAud($post)
	{
		$insert = [
            'idExtAudTipo' => trim($post['sl_tipoAuditoria']),
            'valor' => trim($post['valor_aud']),
			'idConfCliente' =>$post['idConfCliente'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
			
		];

		$insert = $this->db->insert('lsck.conf_clienteAud', $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
	public function registrarConfClienteAudDet($post)
	{
		$insert = [
            'idConfClienteAud' => trim($post['idConfClienteAud']),
            'idExtAudMat' => trim($post['sl_materiales']),
			'presencia' =>(!empty($post['sl_presencia']) && $post['sl_presencia'] == "SI") ? true : false ,

			'idUsuarioReg' => $this->session->userdata('idUsuario'),
			
		];

		$insert = $this->db->insert('lsck.conf_clienteAudDet', $insert);
		$this->insertId = $this->db->insert_id();

		$where = array(
			'presencia' => 1,
			'idConfClienteAud' => $post['idConfClienteAud'],
		);
		$valor = $this->db->get_where('lsck.conf_clienteAudDet',$where)->num_rows();
	
		$update = array(
			'valor' => $valor
		);
	
		return 	$this->db->update('lsck.conf_clienteAud', $update, array('idConfClienteAud'=>$post['idConfClienteAud']));

    }
	public function actualizarEstadoConfClienteAudDet($post)
	{
		$sql = "
		UPDATE lsck.conf_clienteAudDet set presencia = ~presencia where idConfClienteAudDet = {$post['id']}
		";
		$this->db->query($sql);

		$where = array(
			'presencia' => 1,
			'idConfClienteAud' => $post['idConfClienteAud'],
		);
		$valor = $this->db->get_where('lsck.conf_clienteAudDet',$where)->num_rows();
	
		$update = array(
			'valor' => $valor
		);
	
		return 	$this->db->update('lsck.conf_clienteAud', $update, array('idConfClienteAud'=>$post['idConfClienteAud']));

    }
    
    public function actualizarConfCliente($post)
	{

		$update = [
            'idCliente' => trim($post['sl_clientes']),
            'idTipoCliente' => trim($post['sl_tipoCliente']),
			'fecIni' =>  $post['fechaInicio'],
 
			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),

			'fechaModificacion'=>getActualDateTime(),

        ];
		!empty($post['fechaFin'])? $update['fecFin'] = $post['fechaFin']: '';

		$where = [
			$this->tablas['confCliente']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['confCliente']['tabla'], $update);
		return $update;
    }
	public function getConfTipoCliente($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND p.".$this->tablas['confTipoCliente']['id']." = " . $post['id'];
		}

		$sql = "
		SELECT DISTINCT
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,aut.nombre tipoAuditoria
		,tc.nombre tipoCliente
		,COUNT(pd.idTipoClienteAudDet) OVER (PARTITION BY p.idTipoClienteAud) total
		FROM
		lsck.conf_tipoClienteAud p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN lsck.ext_auditoriaTipo aut ON aut.idExtAudTipo = p.idExtAudTipo
		LEFT JOIN lsck.tipoCliente tc ON tc.idTipoCliente = p.idTipoCliente
		LEFT JOIN lsck.conf_tipoClienteAudDet pd ON pd.idTipoClienteAud = p.idTipoClienteAud
		$filtros
		";

		return $this->db->query($sql);
	}
	public function getConfTipoClienteDet($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1 AND p.estado = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['confTipoCliente']['id']." = " . $post['id'];
		}

		$sql = "
		SELECT  
		p.*
		,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
		,aem.nombre material
		FROM
		lsck.conf_tipoClienteAudDet p
		LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
		LEFT JOIN lsck.ext_auditoriaMaterial aem ON aem.idExtAudMat = p.idExtAudMat
		$filtros
		ORDER BY p.idExtAudMat ASC
		";

		return $this->db->query($sql);
	}
	public function registrarConfTipoCliente($post)
	{
		$insert = [
           
            'idTipoCliente' => trim($post['sl_tipoCliente']),
			'idExtAudTipo'=> $post['sl_tipoAuditoria'],
			'fecIni' =>  $post['fechaInicio'],

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
			
		];

		!empty($post['fechaFin'])? $insert['fecFin'] = $post['fechaFin']: '';

		$insert = $this->db->insert($this->tablas['confTipoCliente']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
	public function actualizarConfTipoClienteDet($post,$insertDet)
	{
		$update = [
            'idTipoCliente' => trim($post['sl_tipoCliente']),
			'idExtAudTipo'=> $post['sl_tipoAuditoria'],
			'fecIni' =>  $post['fechaInicio'],

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),

			'fechaModificacion'=>getActualDateTime(),

        ];
		!empty($post['fechaFin'])? $update['fecFin'] = $post['fechaFin']: '';

		$where = [
			$this->tablas['confTipoCliente']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['confTipoCliente']['tabla'], $update);


		$this->db->delete($this->tablas['confTipoCliente']['tablaDet'],array('idTipoClienteAud'=>$post['idx']));
		if(!empty($insertDet)){

			return $this->registrarConfTipoClienteDet($insertDet);
		}else{
			return true;
		}
    }
    
    public function actualizarConfTipoCliente($post)
	{

		$update = [
            'idCliente' => trim($post['sl_clientes']),
            'idTipoCliente' => trim($post['sl_tipoCliente']),
			'fecIni' =>  $post['fechaInicio'],
 
			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),

			'fechaModificacion'=>getActualDateTime(),

        ];
		!empty($post['fechaFin'])? $update['fecFin'] = $post['fechaFin']: '';

		$where = [
			$this->tablas['confCliente']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['confCliente']['tabla'], $update);
		return $update;
    }
	public function checkConfTipoClienteAudRepetido($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idTipoClienteAud NOT IN({$post['idx']})": '';


		$sql = "
		WITH list AS(
			SELECT 
			c.*
			,(General.dbo.fn_fechaVigente(fecIni,fecFin,GETDATE(),GETDATE())) as vigente
			FROM lsck.conf_tipoClienteAud  c
			)
			SELECT * FROM list
			WHERE idTipoCliente = {$post['sl_tipoCliente']} AND idExtAudTipo = {$post['sl_tipoAuditoria']} AND vigente = 1
			$filtros
		";
		$flag = $this->db->query($sql);
		if($flag->num_rows()){
			return $flag->row_array()['idTipoClienteAud'];
		}else{
			return false; 
		}
	}
	public function checkConfPlazaRepetido($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idConfPlaza NOT IN({$post['idx']})": '';

		$sql = "
		WITH list AS(
		SELECT 
		c.*
		,(General.dbo.fn_fechaVigente(fecIni,fecFin,GETDATE(),GETDATE())) as vigente
		FROM lsck.conf_plaza  c
		)
		SELECT * FROM list
		WHERE idPlaza = {$post['sl_plazas']} AND vigente = 1 AND idTipoCliente = {$post['sl_tipoCliente']} AND idExtAudTipo = {$post['sl_tipoAuditoria']}
		$filtros
		";
		$flag = $this->db->query($sql);
		if($flag->num_rows()){
			return $flag->row_array()['idConfPlaza'];
		}else{
			return false; 
		}
	}
	public function checkConfInfoPlazaRepetido($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idPlazaInfo NOT IN({$post['idx']})": '';

		$sql = "
		WITH list AS(
		SELECT 
		c.*
		,(General.dbo.fn_fechaVigente(fecIni,fecFin,GETDATE(),GETDATE())) as vigente
		FROM lsck.conf_plazaInfo  c
		)
		SELECT * FROM list
		WHERE idPlaza = {$post['sl_plazas']} AND vigente = 1 AND idInfo = {$post['sl_tipoInfo']} 
		$filtros
		";
		$flag = $this->db->query($sql);
		if($flag->num_rows()){
			return $flag->row_array()['idPlazaInfo'];
		}else{
			return false; 
		}
	}
	public function checkListaEvaluacionRepetida($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idListEval NOT IN({$post['idx']})": '';
		!empty($post['sl_tipoCliente']) && $post['sl_tipoAuditoria'] == 2  ?  $filtros .= " AND idTipoCliente = {$post['sl_tipoCliente']}": '';

		$sql = "
		WITH list AS(
			SELECT 
			c.*
			,(General.dbo.fn_fechaVigente(fecIni,fecFin,GETDATE(),GETDATE())) as vigente
			FROM lsck.listEvaluacion  c
			)
			SELECT * FROM list
			WHERE idTipoAuditoria = {$post['sl_tipoAuditoria']} AND vigente = 1
		$filtros
		";
		$flag = $this->db->query($sql);
		if($flag->num_rows()){
			return $flag->row_array()['idListEval'];
		}else{
			return false; 
		}

		return $flag; 
	}
	
	public function checkConfClienteRepetido($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idConfCliente NOT IN({$post['idx']})": '';

		$sql = "
		WITH list AS(
		SELECT 
		c.*
		,(General.dbo.fn_fechaVigente(fecIni,fecFin,GETDATE(),GETDATE())) as vigente
		FROM lsck.conf_cliente  c
		)
		SELECT * FROM list
		WHERE idCliente = {$post['idCliente']} AND vigente = 1
		$filtros
		";
		$flag = $this->db->query($sql);

		if($flag->num_rows()){
			return $flag->row_array()['idConfCliente'];
		}else{
			return false; 
		}

		return $flag; 
	}
	public function getConfigClienteAud($params = []){

		$filtros = 'WHERE 1=1';
		!empty($params['vigente']) ? $filtros.= " AND vigente = 1": ''; 
		!empty($params['activo']) ? $filtros.= " AND estado = 1": ''; 
		$sql = "
		WITH list AS(
		SELECT 
		c.*,
		ca.idConfClienteAud,
		ca.idExtAudTipo
		,(General.dbo.fn_fechaVigente(fecIni,fecFin,GETDATE(),GETDATE())) as vigente
		FROM lsck.conf_cliente  c
		LEFT JOIN lsck.conf_clienteAud ca ON c.idConfCliente = ca.idConfCliente
		)
		SELECT * FROM list
		$filtros
		";
	 	return $this->db->query($sql);
	}
	public function checkClienteAudRepetido($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idTipoClienteAud NOT IN({$post['idx']})": '';

		$sql = "
		SELECT 
		*
		FROM lsck.conf_clienteAud
		WHERE idConfCliente = {$post['idConfCliente']} AND idExtAudTipo = {$post['sl_tipoAuditoria']} 
		$filtros
		";
		$flag = $this->db->query($sql);

		if($flag->num_rows()){
			return $flag->row_array()['idConfClienteAud'];
		}else{
			return false; 
		}
	}
	public function checkClienteAudDetRepetido($post){
		$filtros = '';
		!empty($post['idx']) ?  $filtros = " AND idTipoClienteAud NOT IN({$post['idx']})": '';

		$sql = "
		SELECT 
		*
		FROM lsck.conf_clienteAudDet
		WHERE idConfClienteAud = {$post['idConfClienteAud']} AND idExtAudMat = {$post['idExtAudMat']} 
		$filtros
		";
		$flag = $this->db->query($sql);

		if($flag->num_rows()){
			return $flag->row_array()['idConfClienteAudDet'];
		}else{
			return false; 
		}
	}

	// LISTA EVALUACION 

	public function getListaEvaluacion($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND p.".$this->tablas['listaEvaluacion']['id']." = " . $post['id'];
		}

		$sql = "
			SELECT DISTINCT
			p.*
			,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
			,tc.nombre tipoCliente
			,ta.nombre tipoAuditoria
			,COUNT(ed.idListEvalDet) OVER (PARTITION BY p.idListEval) categorias
			FROM
			lsck.listEvaluacion p
			LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
			LEFT JOIN lsck.tipoCliente tc ON tc.idTipoCliente = p.idTipoCliente
			LEFT JOIN lsck.tipoAuditoria ta ON ta.idTipoAuditoria = p.idTipoAuditoria
			LEFT JOIN lsck.listEvaluacionDet ed ON ed.idListEval = p.idListEval
            $filtros
			";
		return $this->db->query($sql);
	}
	public function getListaEvaluacionDet($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['idListEval'])) $filtros .= " AND p.idListEval = " . $post['idListEval'];
			if (!empty($post['idEvaluacionDet'])) $filtros .= " AND p.idEvaluacionDet = " . $post['idEvaluacionDet'];
			if (!empty($post['idEncuesta'])) $filtros .= " AND p.idEncuesta = " . $post['idEncuesta'];
		}

		$sql = "
			SELECT 
			p.*
			,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
			,te.nombre encuesta
			,ed.nombre evaluacion
			FROM
			lsck.listEvaluacionDet p
			LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
			LEFT JOIN lsck.tipoEvaluacionDet ed ON ed.idEvaluacionDet = p.idEvaluacionDet
			LEFT JOIN lsck.tipoEncuesta te ON te.idEncuesta = p.idEncuesta
            $filtros
			";
		return $this->db->query($sql);
	}

	public function registrarListaEvaluacion($post)
	{
		$insert = [
            'idTipoAuditoria' => trim($post['sl_tipoAuditoria']),
			'fecIni' =>  $post['fechaInicio'],

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'idUsuarioReg' => $this->session->userdata('idUsuario'),
        ];
		!empty($post['sl_tipoCliente']) ? $insert['idTipoCliente'] = $post['sl_tipoCliente'] : '' ;
		!empty($post['fechaFin'])? $insert['fecFin'] = $post['fechaFin']: '';

		$insert = $this->db->insert($this->tablas['listaEvaluacion']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarListaEvaluacion($post)
	{

		$update = [
			'fecIni' =>  $post['fechaInicio'],

			'idCuenta' => $post['sl_cuenta'],
			'idProyecto' => $post['sl_proyecto'],
			'fechaModificacion'=>getActualDateTime(),
			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];
        
		!empty($post['fechaFin'])? $update['fecFin'] = $post['fechaFin']: '';

		$where = [
			$this->tablas['listaEvaluacion']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['listaEvaluacion']['tabla'], $update);
		return $update;
    }

	//SECCION TIPO EVAL

	public function getTipoEvaluacion($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['tipoEvaluacion']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,c.nombre cuenta
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
                FROM
                ".$this->tablas['tipoEvaluacion']['tabla']." p
				LEFT JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
                $filtros
			";

		return $this->db->query($sql);
	}

	public function regitrarTipoEvaluacion($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
			'idCuenta' => 3,
			'idProyecto' => 3,

			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];

		$insert = $this->db->insert($this->tablas['tipoEvaluacion']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarTipoEvaluacion($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'idCuenta' =>3,
			'idProyecto' =>3,
			'fechaModificacion'=>getActualDateTime(),
			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['tipoEvaluacion']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['tipoEvaluacion']['tabla'], $update);
		return $update;
    }
	//SECCION EVALUACION
	public function getEvaluacion($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['evaluacion']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT
                p.*
				,c.nombre cuenta
				,(u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno) usuario
				,te.nombre tipoEvaluacion
                FROM
                ".$this->tablas['evaluacion']['tabla']." p
				LEFT JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				LEFT JOIN trade.usuario u ON u.idUsuario = p.idUsuarioReg
				LEFT JOIN lsck.tipoEvaluacion te ON te.idEvaluacion = p.idEvaluacion
                $filtros
			";

		return $this->db->query($sql);
	}

	public function registrarEvaluacion($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
            'idEvaluacion' => trim($post['tipoEvaluacion']),
			'detallar' => !empty($post['detallar']) ? 1 : NULL ,
			'idCuenta' => 3,
			'idProyecto' => 3,

			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];

		$insert = $this->db->insert($this->tablas['evaluacion']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
    
    public function actualizarEvaluacion($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
            'idEvaluacion' => trim($post['tipoEvaluacion']),
			'detallar' => !empty($post['detallar']) ? 1 : NULL ,
			'idCuenta' => 3,
			'idProyecto' => 3,
			
			'fechaModificacion'=>getActualDateTime(),
			'idUsuarioReg'=> $this->session->userdata('idUsuario'),
        ];
        
		$where = [
			$this->tablas['evaluacion']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['evaluacion']['tabla'], $update);
		return $update;
    }

	public function registroMasivoInfoPlaza($insert){
		return $this->db->insert_batch($this->tablas['infoPlaza']['tabla'], $insert);
	}
	public function registroMasivoTipoCliente($insert){
		return $this->db->insert_batch($this->tablas['tipoCliente']['tabla'], $insert);
	}
	public function registroMasivoTipoResponsable($insert){
		return $this->db->insert_batch($this->tablas['tipoResponsable']['tabla'], $insert);
	}
	public function registroMasivoResponsable($insert){
		return $this->db->insert_batch($this->tablas['responsable']['tabla'], $insert);
	}
	public function registroMasivoEmpresa($insert){
		return $this->db->insert_batch($this->tablas['empresa']['tabla'], $insert);
	}
	public function registroMasivoInfPlaza($insert){
		return $this->db->insert_batch($this->tablas['infPlaza']['tabla'], $insert);
	}
	public function registroMasivoConfPlaza($insert){
		return $this->db->insert_batch($this->tablas['confPlaza']['tabla'], $insert);
	}
	public function registroMasivoConfCliente($insert_arr){
		$confClienteId = [];
		foreach ($insert_arr as $key => $insert) {

				$rs = $this->db->insert($this->tablas['confCliente']['tabla'], $insert);
				if(!$rs){
					return false;
				}
				$confClienteId[$insert['idCliente']] = $this->db->insert_id();
		}
		return $confClienteId;
	}
	public function registroMasivoConfClienteBatch($insert_arr){
		return $this->db->insert_batch($this->tablas['confCliente']['tabla'], $insert_arr);
	}
	public function registroMasivoConfClienteAud($insert){
		return $this->db->insert_batch('lsck.conf_clienteAud', $insert);
	}
	public function registroMasivoConfClienteAudDet($insert){
		return $this->db->insert_batch('lsck.conf_clienteAudDet', $insert);
	}
	public function registroMasivoConfClienteAudDet2($insert){

		$rs = $this->db->insert_batch('lsck.conf_clienteAudDet', $insert);
		return $this->calcularValorConfClienteAud();
	}
	public function registroMasivoConfTipoCliente($insert){
		return $this->db->insert_batch($this->tablas['confTipoCliente']['tabla'], $insert);
	}
	public function registrarConfTipoClienteDet($insert){
		return $this->db->insert_batch($this->tablas['confTipoCliente']['tablaDet'], $insert);
	}
	public function registrarListaEvaluacionDet($insert){
		return $this->db->insert_batch($this->tablas['listaEvaluacion']['tablaDet'], $insert);
	}
	public function registroMasivoTipoAuditoriaExt($insert){
		return $this->db->insert_batch($this->tablas['tipoAuditoria']['tabla'], $insert);
	}
	public function registroMasivoTipoEvaluacion($insert){
		return $this->db->insert_batch($this->tablas['tipoEvaluacion']['tabla'], $insert);
	}
	public function registroMasivoEvaluacion($insert){
		return $this->db->insert_batch($this->tablas['evaluacion']['tabla'], $insert);
	}
	public function registrarMatExt($insert){
		return $this->db->insert('lsck.ext_auditoriaMaterial', $insert);
	}
	public function registrarEncuesta($insert){
		return $this->db->insert('lsck.tipoEncuesta', $insert);
	}
	public function registrarPreguntaEncuesta($insert){
		return $this->db->insert('lsck.tipoEncuestaPreg', $insert);
	}
	public function registrarEncPregAlt($insert){
		return $this->db->insert_batch('lsck.tipoEncuestaPregAlt', $insert);
	}
	public function consultarPreguntas($input){
		$filtro = "";
			$filtro .= !empty($input['idCuenta']) ? " AND cu.idCuenta = {$input['idCuenta']}" : "";
		$sql = "
			SELECT
				cu.idCuenta,
				cu.nombre AS cuenta,
				enc.idEncuesta,
				enc.nombre,
				(
					SELECT COUNT(1)
					FROM lsck.tipoEncuestaPreg
					WHERE idEncuesta = enc.idEncuesta
				) AS numPreg,
				enc.estado
				,enc.cliente flag_cliente
			FROM lsck.tipoEncuesta enc
			JOIN trade.cuenta cu ON enc.idCuenta = cu.idCuenta
			WHERE 1 = 1{$filtro}
			ORDER BY enc.fechaReg DESC, enc.horaReg DESC
			";
		return $this->db->query($sql)->result_array();
	}
	public function listTipoPreg($input = array()){
		$sql = "
SELECT
	enpt.idTipoPregunta AS id,
	enpt.nombre
FROM master.tipoPregunta enpt
WHERE enpt.estado = 1
ORDER BY nombre
";
		return $this->db->query($sql)->result_array();
	}
	public function guardarPregEval($input = array()){
		$return['status'] = false;
		$return['msg'] = '';

			$error = false;
			$this->db->trans_begin();

				$iEncuesta = array(
						'idCuenta' => $input['idCuenta'],
						'nombre' => trim($input['encuesta']),
						'idUsuarioReg' => $this->idUsuario,
						'cliente' => !empty($input['flag_cliente'])? 1 : 0 ,
					);
				$this->db->insert('lsck.tipoEncuesta', $iEncuesta);
				$idEncuesta = $this->db->insert_id();

				if( !is_array($input["aPregunta"]) ){
					$input["aPregunta"] = array($input["aPregunta"]);
				}

				foreach($input["aPregunta"] as $num){
					$iPregunta = array(
							'idEncuesta' => $idEncuesta,
							'idTipoPregunta' => $input["tipo[{$num}]"],
							'nombre' => $input["pregunta[{$num}]"],
					);
					!empty($input["tipoAuditoria[{$num}]"]) ? $iPregunta['idExtAudTipo'] = $input["tipoAuditoria[{$num}]"] : '';
					!empty($input["presencia[{$num}]"]) &&  $input["presencia[{$num}]"] == "SI" ?  $iPregunta['extAudPresencia'] = 1: $iPregunta['extAudPresencia'] =  0;
					!empty($input["checkDetalle[{$num}]"] )  &&  $input["checkDetalle[{$num}]"] == "on"? $iPregunta['extAudDetalle'] = 1 : $iPregunta['extAudDetalle'] = 0;
					
					$this->db->insert('lsck.tipoEncuestaPreg', $iPregunta);
					$idPregunta = $this->db->insert_id();

					if(empty($input["tipoAuditoria[{$num}]"])){
						if( in_array($input["tipo[{$num}]"], array(2,3)) &&
						empty($input["alternativa[{$num}]"])
						
						){
							$error = true;
							$return['msg'] = 'Se identificó una pregunta(cerrada o múltiple) <b>sin alternativas</b>';
							break;
						}
					}

					if( !empty($input["alternativa[{$num}]"]) ){
						if( !is_array($input["alternativa[{$num}]"]) ){
							$input["alternativa[{$num}]"] = array($input["alternativa[{$num}]"]);
						}

						foreach($input["alternativa[{$num}]"] as $alt){
							$iAlternativa = array(
									'idPregunta' => $idPregunta,
									'nombre' => $alt,
								);
							$this->db->insert('lsck.tipoEncuestaPregAlt', $iAlternativa);
						}
					}
				}

			if( !$this->db->trans_status() || $error ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$return['status'] = true;
			}

		return $return;
	}
	public function listEncuestasPregEval($input = array()){
		$sql = "
	SELECT
		en.idEncuesta,
		en.nombre AS encuesta,
		enp.idPregunta,
		enp.nombre AS pregunta,
		enpt.idTipoPregunta AS idTipo,
		enpt.nombre AS tipo,
		enpa.idAlternativa,
		enpa.nombre AS alternativa,
		enp.idExtAudTipo,
		aut.nombre tipoAuditoria
		,en.cliente flag_cliente
		,enp.extAudPresencia flag_presencia
	FROM lsck.tipoEncuesta en
	JOIN lsck.tipoEncuestaPreg enp ON en.idEncuesta = enp.idEncuesta
	JOIN master.tipoPregunta enpt ON enp.idTipoPregunta = enpt.idTipoPregunta
	LEFT JOIN lsck.tipoEncuestaPregAlt enpa ON enp.idPregunta = enpa.idPregunta
	LEFT JOIN lsck.ext_auditoriaTipo aut ON aut.idExtAudTipo = enp.idExtAudTipo
WHERE en.idEncuesta = {$input['idEncuesta']}
";
		return $this->db->query($sql)->result_array();
	}

	public function checkConfTipoClienteAudDetRepetido($params = []){
		$where = $params;

		return $this->db->get_where('lsck.conf_tipoClienteAudDet',$where)->result_array();
	}

	public function registrarExtauditoriaMaterial($insert){
		return $this->db->insert('lsck.ext_auditoriaMaterial',$insert);
	}
	public function registrarMasivoConfClienteAudDet($insert,$post = []){
		$where = array(
			'idConfClienteAud' => $post['idConfClienteAud'],
		);
		$d = $this->db->delete('lsck.conf_clienteAudDet',$where);

		$rs = $this->db->insert_batch('lsck.conf_clienteAudDet',$insert);
		$where = array(
			'presencia' => 1,
			'idConfClienteAud' => $post['idConfClienteAud'],
		);
		$valor = $this->db->get_where('lsck.conf_clienteAudDet',$where)->num_rows();
	
		$update = array(
			'valor' => $valor
		);
	
		return 	$this->db->update('lsck.conf_clienteAud', $update, array('idConfClienteAud'=>$post['idConfClienteAud']));
	}
	public function calcularValorConfClienteAud(){
		$sql = "
		WITH list_presencia AS(
			SELECT DISTINCT
			ca.*,
			CASE WHEN cad.presencia = 1 THEN COUNT(cad.idConfClienteAudDet) OVER (PARTITION BY ca.idConfClienteAud )END valor_presencia
			FROM
			lsck.conf_clienteAud ca
			LEFT JOIN lsck.conf_clienteAudDet cad ON ca.idConfClienteAud = cad.idConfClienteAud
			WHERE cad.presencia = 1
			)
			UPDATE
				ca
			SET 
				ca.valor = lp.valor_presencia
			FROM lsck.conf_clienteAud ca
			JOIN list_presencia lp ON lp.idConfClienteAud = ca.idConfClienteAud
		";

		return $this->db->query($sql);
	}


}
