<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rutas extends My_Model{

	var $CI;

	public function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
	}

	public function obtener_ruta($input){
		$modulacion = $this->session->flag_modulacion;
		$idUsuario = $this->session->idUsuario;
		$filtros='';
		$filtros.=!empty($input['id'])?'AND r.idRutaProg='.$input['id']:'';
		if($modulacion!=1){
			$filtros.='AND r.idUsuarioReg='.$idUsuario;
		}
		$sql ="
			DECLARE 
				  @fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			SELECT 
				  r.idRutaProg
				, r.nombreRuta
				, r.numClientes
				--, eu_spoc.idEncargado
				--, e_spoc.idUsuario
				--, spoc.apePaterno+' '+spoc.apeMaterno+' '+spoc.nombres spoc
				, rd.idUsuario
				, gtm.apePaterno+' '+gtm.apeMaterno+' '+gtm.nombres gtm
				, CONVERT(VARCHAR,r.fecIni,103) fecIni
				, CONVERT(VARCHAR,r.fecFin,103) fecFin
				, r.estado
				, r.generado
			FROM
				{$this->sessBDCuenta}.trade.master_rutaProgramada r
				LEFT JOIN {$this->sessBDCuenta}.trade.master_rutaProgramadaDet rd
					ON rd.idRutaProg = r.idRutaProg
					AND general.dbo.fn_fechaVigente(rd.fecIni,rd.fecFin,@fecIni,@fecFin)=1
				LEFT JOIN trade.usuario gtm
					ON gtm.idUsuario = rd.idUsuario
				--LEFT JOIN trade.encargado_usuario eu_spoc
				--	ON eu_spoc.idUsuario = gtm.idUsuario
				--LEFT JOIN trade.encargado e_spoc
				--	ON e_spoc.idEncargado = eu_spoc.idEncargado
				--LEFT JOIN trade.usuario spoc
				--	ON spoc.idUsuario = e_spoc.idUsuario
			WHERE 
				general.dbo.fn_fechaVigente(r.fecIni,r.fecFin,@fecIni,@fecFin)=1
				{$filtros}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_rutaProgramada" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_clientes_ruta($idCliente){
		$sql = "SELECT idCliente,razonSocial FROM trade.cliente WHERE idCliente IN ({$idCliente})";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_visitas_programadas($idCliente,$idRutaProg){
		$sql = "
			SELECT 
				  c.idCliente
				, c.razonSocial 
				, vpd.idDia
				, vp.idVisitaProg
			FROM 
				{$this->sessBDCuenta}.trade.master_visitaProgramada vp
				JOIN {$this->sessBDCuenta}.trade.master_visitaProgramadaDet vpd
					ON vpd.idVisitaProg = vp.idVisitaProg
				JOIN trade.cliente c
					ON c.idCliente = vp.idCliente
			WHERE 
				c.idCliente IN ({$idCliente})
				AND vp.idRutaProg = {$idRutaProg}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_visitaProgramada" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_rutas_activas(){
		$sql = "
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			SELECT
				  idRutaProg
				, nombreRuta

			FROM 
				{$this->sessBDCuenta}.trade.master_rutaProgramada 
			WHERE
				General.dbo.fn_fechaVigente(fecIni,fecFin,@fecIni,@fecFin)=1
				AND estado=1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_rutaProgramada" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_ruta_detalle($idRutaProg){
		$sql ="
			SELECT DISTINCT
				  rp.idRutaProg
				, vp.idVisitaProg
				, vp.idCliente
				, c.razonSocial
				, vpd.idDia
			FROM 
				{$this->sessBDCuenta}.trade.master_rutaProgramada rp
				JOIN {$this->sessBDCuenta}.trade.master_visitaProgramada vp
					ON vp.idRutaProg = rp.idRutaProg
				JOIN {$this->sessBDCuenta}.trade.master_visitaProgramadaDet vpd
					ON vpd.idVisitaProg = vp.idVisitaProg
				JOIN trade.cliente c
					ON c.idCliente = vp.idCliente
			WHERE
				rp.idRutaProg = {$idRutaProg}
			ORDER BY 
				idCliente
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_visitaProgramadaDet" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_data_carga($params = array()){
		$filtro='';
		$sql = "
			DECLARE 
				@fecha DATE=GETDATE();
			SELECT
				  c.idCliente
				, c.razonSocial 
				--, f.nombre frecuencia
			FROM 
				trade.cliente c 
				JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente=c.idCliente
				/* JOIN dbo.master_rutas_frecuencia mrf
					ON mrf.idCliente = c.idCliente
				JOIN dbo.frecuencia f
					ON f.idFrecuencia=mrf.idFrecuencia */
			WHERE 
				@fecha between ch.fecIni and ISNULL(ch.fecFin,@fecha) 
				{$filtro}
			ORDER BY c.razonSocial DESC
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_clientes($params = array()){
		$filtro='';
			if(!empty($params['idCliente'])) $filtro= 'AND c.idCliente='.$params['idCliente'];
		$sql = "
			DECLARE
				  @fecIni DATE = GETDATE()
				, @fecFin DATE = GETDATE()
			SELECT 
				  c.idCliente
				, gc.idGrupoCanal
				, gc.nombre grupoCanal
				, ca.idCanal
				, ca.nombre canal
				, sc.idSubCanal
				, sc.nombre subcanal
				, c.razonSocial
				, ub.departamento
			FROM
				trade.cliente c
				JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = c.idCliente
					AND ch.idProyecto IN (3)
					AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				JOIN trade.subCanal sc
					ON sc.idSubCanal = sn.idSubCanal
				JOIN trade.canal ca
					ON ca.idCanal = sc.idCanal
					AND sc.estado = 1
					AND sc.estado=1
				JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
					AND gc.estado=1
					AND sc.idSubCanal NOT IN (8)
				JOIN General.dbo.ubigeo ub
					ON ub.cod_ubigeo=c.cod_ubigeo
			WHERE 
				1=1
				{$filtro}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_usuario_ruta_tradicional($params){
		$sql = "
			SELECT 
				  rp.idRutaProgDet
				, rp.idRutaProg
				, u.idUsuario
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
				, CONVERT(VARCHAR,rp.fecIni,103) fecIni 
				, CONVERT(VARCHAR,rp.fecFin,103) fecFin
			FROM 
				{$this->sessBDCuenta}.trade.master_rutaProgramadaDet rp
				JOIN trade.usuario u
					ON u.idUsuario = rp.idUsuario
			WHERE
				rp.idRutaProg = ".$params['id']."
		
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_rutaProgramadaDet" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_gtm(){
		$sql = "
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			SELECT
				u.idUsuario
				,u.nombres+' '+u.apePaterno+' '+u.apeMaterno nombres
			FROM
				trade.usuario u
				JOIN trade.usuario_historico uh
					ON uh.idUsuario = u.idUsuario
					AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				JOIN trade.usuario_tipo ut
					ON ut.idTipoUsuario = uh.idTipoUsuario
					AND ut.idTipoUsuario=1
					AND uh.idAplicacion=4
					AND u.demo=0
				LEFT JOIN trade.encargado_usuario eu
					ON eu.idUsuario = u.idUsuario
				LEFT JOIN trade.encargado e
					ON e.idEncargado = eu.idEncargado
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario' ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_lista_permisos($input=array()){
		$filtros = '';

		$sql="
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			select 
				  mp.idPermiso
				, mp.fecIniCarga
				, mp.fecFinCarga 
				, mp.fecIniLista
				, mp.fecFinLista
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
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

	
	public function generar_rutas_manual(){
		$sql = "exec Procesar_rutas_master;";
		return $this->db->query($sql)->result_array();
	}


	public function obtenerRutaGenerada($idRutaProg){
		$sql ="
			
			DECLARE 
				@fecIni DATE = getdate(),@fecFin DATE = getdate()
				, @dia int
				, @total INT
				, @usuario INT
				, @cliente INT
				, @fecha DATE
				, @cont INT = 1
				, @actividades INT = 0
				, @idProyecto INT
				, @horaIni TIME
				, @horaFin TIME
				, @idCuenta INT
				, @idEncargado INT,
				@idRutaProg VARCHAR(25)='".$idRutaProg."';
			SELECT
				rpd.idUsuario
				, vp.idCliente
				, t.fecha
				, cc.nombreComercial
			FROM
				{$this->sessBDCuenta}.trade.master_rutaProgramada rp
				JOIN {$this->sessBDCuenta}.trade.master_rutaProgramadaDet rpd 
					ON rpd.idRutaProg=rp.idRutaProg
				JOIN {$this->sessBDCuenta}.trade.master_visitaProgramada vp
					ON vp.idRutaProg = rpd.idRutaProg
				JOIN trade.cliente cc
					ON cc.idCliente=vp.idCliente
				JOIN {$this->sessBDCuenta}.trade.master_visitaProgramadaDet vpd
					ON vpd.idVisitaProg=vp.idVisitaProg
				JOIN General.dbo.tiempo t 
					ON t.fecha between rp.fecIni and rp.fecFin and t.idDia=vpd.idDia
			WHERE 
				rp.idRutaProg=@idRutaProg;
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_rutaProgramada" ];
		return $this->db->query($sql)->result_array();
	}


	public function obtener_ruta_programada_visitas($idRutaProg){
		$sql ="
		DECLARE 
			@fecIni DATE = getdate(),@fecFin DATE = getdate();
		SELECT
			rpd.idUsuario
			, vp.idCliente
			, t.fecha 
		FROM
			{$this->sessBDCuenta}.trade.master_rutaProgramada rp
			JOIN {$this->sessBDCuenta}.trade.master_rutaProgramadaDet rpd 
				ON rpd.idRutaProg=rp.idRutaProg
			JOIN {$this->sessBDCuenta}.trade.master_visitaProgramada vp
				ON vp.idRutaProg = rpd.idRutaProg
			JOIN {$this->sessBDCuenta}.trade.master_visitaProgramadaDet vpd
				ON vpd.idVisitaProg=vp.idVisitaProg
			JOIN General.dbo.tiempo t 
				ON t.fecha between rp.fecIni and rp.fecFin and t.idDia=vpd.idDia
		WHERE 
			rp.idRutaProg={$idRutaProg};
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.master_rutaProgramada" ];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_visita_ruta($params){
		$sql="
			DECLARE
			@fecha DATE,
			@idRuta INT,
			@idVisita INT,
			@num INT;
			
			SET @fecha=CONVERT(DATE,'{$params['fecha']}');
			SELECT
				@num=COUNT(idRuta)
			FROM {$this->sessBDCuenta}.trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha AND idCuenta = {$params['idCuenta']} AND idProyecto = {$params['idProyecto']};

			IF( @num=0 )BEGIN
				INSERT INTO {$this->sessBDCuenta}.trade.data_ruta (fecha,idUsuario,idEncargado,idProyecto,idCuenta) VALUES (@fecha,{$params['idUsuario']},null,{$params['idProyecto']},{$params['idCuenta']})
			END

			SELECT
				@idRuta=idRuta
			FROM {$this->sessBDCuenta}.trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha AND idProyecto = {$params['idProyecto']} AND idCuenta = {$params['idCuenta']};

			SELECT
				@num=COUNT(idVisita)
			FROM {$this->sessBDCuenta}.trade.data_visita
			WHERE idRuta=@idRuta
			AND idCliente={$params['idCliente']} 

			IF( @num=0 )BEGIN
				INSERT INTO {$this->sessBDCuenta}.trade.data_visita (idRuta,idCliente) VALUES (@idRuta,{$params['idCliente']});
			END
		";
		$this->CI->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => "{$this->sessBDCuenta}.trade.data_visita", 'id' => $params['idCliente'] ];
		return $this->db->query($sql);
	}

	public function obtener_estado_carga(){
		$sql =" 
			SELECT 
					*
				, convert(varchar,fecIni,103) fecI
				, convert(varchar,fecFin,103) fecF
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				, (SELECT COUNT(*) FROM  {$this->sessBDCuenta}.trade.cargaRutaNoProcesados WHERE idCarga=cm.idCarga  ) noProcesados
				,(
					SELECT count(*) FROM {$this->sessBDCuenta}.trade.cargaRutaNoProcesados WHERE idCarga=cm.idCarga
				) error
			FROM 
				{$this->sessBDCuenta}.trade.cargaRuta cm
				order by cm.idCarga DESC

		";
		return $this->db->query($sql)->result_array();
	}


	////ERRORES
	public function obtener_rutas_no_procesado($id){
		$sql="SELECT * FROM {$this->sessBDCuenta}.trade.cargaRutaNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}

}
?>