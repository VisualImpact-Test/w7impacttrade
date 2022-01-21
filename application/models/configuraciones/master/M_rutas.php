<?php

use Mpdf\Tag\I;

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
	
		$sql ="
			DECLARE 
				  @fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			SELECT 
				  r.idProgRuta
				, r.nombre nombreRuta
				, rd.idUsuario
				, gtm.apePaterno+' '+gtm.apeMaterno+' '+gtm.nombres gtm
				, CONVERT(VARCHAR,r.fecIni,103) fecIni
				, CONVERT(VARCHAR,r.fecFin,103) fecFin
				, r.estado
				, r.generado
			FROM
				{$this->sessBDCuenta}.trade.programacion_ruta r
				LEFT JOIN {$this->sessBDCuenta}.trade.programacion_rutaDet rd
					ON rd.idProgRuta = r.idProgRuta
					AND general.dbo.fn_fechaVigente(rd.fecIni,rd.fecFin,@fecIni,@fecFin)=1
				LEFT JOIN trade.usuario gtm
					ON gtm.idUsuario = rd.idUsuario
			WHERE 
				general.dbo.fn_fechaVigente(@fecIni,@fecFin,r.fecIni,r.fecFin)=1
				--{$filtros}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_ruta" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_clientes_ruta($idCliente){
		$sql = "SELECT idCliente,razonSocial FROM trade.cliente WHERE idCliente IN ({$idCliente})";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_visitas_programadas($idCliente,$idProgRuta){
		$sql = "
			SELECT 
				  c.idCliente
				, c.razonSocial 
				, vpd.dia idDia
				, vp.idProgVisita
			FROM 
				{$this->sessBDCuenta}.trade.programacion_visita vp
				JOIN {$this->sessBDCuenta}.trade.programacion_visitaDet vpd
					ON vpd.idProgVisita = vp.idProgVisita
				JOIN trade.cliente c
					ON c.idCliente = vp.idCliente
			WHERE 
				c.idCliente IN ({$idCliente})
				AND vp.idProgRuta = {$idProgRuta}
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_visita" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_rutas_activas(){
		$sql = "
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			SELECT
				  idProgRuta
				, nombre nombreRuta

			FROM 
				{$this->sessBDCuenta}.trade.programacion_ruta 
			WHERE
				General.dbo.fn_fechaVigente(fecIni,fecFin,@fecIni,@fecFin)=1
				AND estado=1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_ruta" ];
		return $this->db->query($sql)->result_array();
	}

	public function obtener_ruta_detalle($idProgRuta){
		$sql ="
			SELECT DISTINCT
				  rp.idProgRuta
				, vp.idProgVisita
				, vp.idCliente
				, c.razonSocial
				, vpd.dia idDia
			FROM 
				{$this->sessBDCuenta}.trade.programacion_ruta rp
				JOIN {$this->sessBDCuenta}.trade.programacion_visita vp
					ON vp.idProgRuta = rp.idProgRuta
				JOIN {$this->sessBDCuenta}.trade.programacion_visitaDet vpd
					ON vpd.idProgVisita = vp.idProgVisita
				JOIN trade.cliente c
					ON c.idCliente = vp.idCliente
			WHERE
				rp.idProgRuta = {$idProgRuta}
			ORDER BY 
				idCliente
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_visitaDet" ];
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

		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;
		$sessDemo = $this->demo;

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
					AND ch.idProyecto = {$idProyecto}
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
				  rp.idProgRutaDet
				, rp.idProgRuta
				, u.idUsuario
				, u.apePaterno+' '+u.apeMaterno+' '+u.nombres usuario
				, CONVERT(VARCHAR,rp.fecIni,103) fecIni 
				, CONVERT(VARCHAR,rp.fecFin,103) fecFin
			FROM 
				{$this->sessBDCuenta}.trade.programacion_rutaDet rp
				JOIN trade.usuario u
					ON u.idUsuario = rp.idUsuario
			WHERE
				rp.idProgRuta = ".$params['id']."
		
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_rutaDet" ];
		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_gtm(){

		$idProyecto = $this->sessIdProyecto;
		$idCuenta = $this->sessIdCuenta;
		$sessDemo = $this->demo;
		$filtros = '';

		empty($sessDemo) ? $filtros .= " AND u.demo = 0 " : '';

		$sql = "
			DECLARE
				  @fecIni DATE = getdate()
				, @fecFin DATE = getdate()
			SELECT
				u.idUsuario
				,u.nombres+' '+u.apePaterno+' '+u.apeMaterno nombres
				,ut.nombre tipoUsuario
			FROM
				trade.usuario u
				JOIN trade.usuario_historico uh
					ON uh.idUsuario = u.idUsuario
					AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
				JOIN trade.usuario_tipo ut
					ON ut.idTipoUsuario = uh.idTipoUsuario
				LEFT JOIN trade.encargado_usuario eu
					ON eu.idUsuario = u.idUsuario
				LEFT JOIN trade.encargado e
					ON e.idEncargado = eu.idEncargado
			WHERE 
				uh.idProyecto = {$idProyecto}
				{$filtros}
			ORDER BY u.idUsuario
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
		$sql = "EXEC {$this->sessBDCuenta}.dbo.sp_procesar_rutas";
		return $this->db->query($sql);
	}


	public function obtenerRutaGenerada($idProgRuta){
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
				@idProgRuta VARCHAR(25)='".$idProgRuta."';
			SELECT
				rpd.idUsuario
				, vp.idCliente
				, t.fecha
				, cc.nombreComercial
			FROM
				{$this->sessBDCuenta}.trade.programacion_ruta rp
				JOIN {$this->sessBDCuenta}.trade.programacion_rutaDet rpd 
					ON rpd.idProgRuta=rp.idProgRuta
				JOIN {$this->sessBDCuenta}.trade.programacion_visita vp
					ON vp.idProgRuta = rpd.idProgRuta
				JOIN trade.cliente cc
					ON cc.idCliente=vp.idCliente
				JOIN {$this->sessBDCuenta}.trade.programacion_visitaDet vpd
					ON vpd.idProgVisita=vp.idProgVisita
				JOIN General.dbo.tiempo t 
					ON t.fecha between rp.fecIni and rp.fecFin and t.idDia=vpd.dia
			WHERE 
				rp.idProgRuta=@idProgRuta;
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_ruta" ];
		return $this->db->query($sql)->result_array();
	}


	public function obtener_ruta_programada_visitas($idProgRuta){
		$sql ="
		DECLARE 
			@fecIni DATE = getdate(),@fecFin DATE = getdate();
		SELECT
			rpd.idUsuario
			, vp.idCliente
			, t.fecha 
		FROM
			{$this->sessBDCuenta}.trade.programacion_ruta rp
			JOIN {$this->sessBDCuenta}.trade.programacion_rutaDet rpd 
				ON rpd.idProgRuta=rp.idProgRuta
			JOIN {$this->sessBDCuenta}.trade.programacion_visita vp
				ON vp.idProgRuta = rpd.idProgRuta
			JOIN {$this->sessBDCuenta}.trade.programacion_visitaDet vpd
				ON vpd.idProgVisita=vp.idProgVisita
			JOIN General.dbo.tiempo t 
				ON t.fecha between rp.fecIni and rp.fecFin and t.idDia=vpd.dia
		WHERE 
			rp.idProgRuta={$idProgRuta};
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.programacion_ruta" ];
		return $this->db->query($sql)->result_array();
	}

	public function insertar_visita_ruta($params){
		$demo = $this->demo;

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
			AND fecha=@fecha AND idCuenta = {$params['idCuenta']} 
			AND idProyecto = {$params['idProyecto']}
			AND idTipoUsuario = {$params['idTipoUsuario']};

			IF( @num=0 )BEGIN
				INSERT INTO {$this->sessBDCuenta}.trade.data_ruta (fecha,idUsuario,idTipoUsuario,idEncargado,idProyecto,idCuenta) VALUES (@fecha,{$params['idUsuario']},{$params['idTipoUsuario']},null,{$params['idProyecto']},{$params['idCuenta']})
			END

			SELECT
				@idRuta=idRuta
			FROM {$this->sessBDCuenta}.trade.data_ruta
			WHERE idUsuario={$params['idUsuario']}
			AND fecha=@fecha 
			AND idProyecto = {$params['idProyecto']}
			AND idCuenta = {$params['idCuenta']}
			AND idTipoUsuario = {$params['idTipoUsuario']};

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
			WHERE 
				cm.idProyecto={$this->sessIdProyecto}
				order by cm.idCarga DESC

		";
		return $this->db->query($sql)->result_array();
	}


	////ERRORES
	public function obtener_rutas_no_procesado($id){
		$sql="SELECT * FROM {$this->sessBDCuenta}.trade.cargaRutaNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_tipo_usuario(){
		$sql="
			SELECT DISTINCT
				  ut.idTipoUsuario
				, ut.nombre 
			FROM 
				trade.usuario_tipo ut
				JOIN trade.tipoUsuarioCuenta utc ON utc.idTipoUsuario = ut.idTipoUsuario
			WHERE 
				ut.estado=1
				AND utc.idCuenta = {$this->sessIdCuenta}
		";
		return $this->db->query($sql)->result_array();
	}

	public function obtener_horarios(){
		$sql ="SELECT idHorario,CONVERT(VARCHAR,horaIni,108) horaIni,CONVERT(VARCHAR,horaFin,108) horaFin FROM {$this->sessBDCuenta}.trade.horarios WHERE estado=1";
		return $this->db->query($sql)->result_array();
	}

}
?>