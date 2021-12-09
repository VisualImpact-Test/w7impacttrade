<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ipp extends CI_Model{

	var $CI;

	public function __construct(){
		parent::__construct();
		$this->CI = &get_instance();
	} 

	public function obtener_cliente(){
		$sql="
			DECLARE @fecha DATE =GETDATE();
			SELECT c.idCliente, c.razonSocial FROM trade.cliente c
			JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON c.idCliente = ch.idCliente 
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha) AND ch.flagCartera=1
			WHERE ch.estado=1
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}

	public function obtener_data(){
		$sql="SELECT DISTINCT lid.idPregunta, ip.nombre pregunta, lid.idAlternativa, ia.nombre alternativa, lid.puntaje, ip.idCriterio, c.nombre criterio
		FROM {$this->sessBDCuenta}.trade.list_ippDet lid
		LEFT JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip ON ip.idPregunta=lid.idPregunta
		LEFT JOIN {$this->sessBDCuenta}.trade.ipp_alternativa ia ON ia.idAlternativa=lid.idAlternativa
		JOIN {$this->sessBDCuenta}.trade.ipp_criterio c ON c.idCriterio=ip.idCriterio
		WHERE 1=1 ";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_ippDet" ];
		return $this->db->query($sql);
	}
	
	public function obtener_meses(){
		$sql="SELECT DISTINCT idMes,mes FROM general.dbo.tiempo ORDER BY idMes";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'general.dbo.tiempo' ];
		return $this->db->query($sql);
	}
	
	public function obtener_tienda($input){

		$filtros = '';
		// if(!empty($input['idUsuarioSub']) ) $filtros .= " AND sub.idEncargadoUsuario = '".$input['idUsuarioSub']."'";
		// if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND enc.idEncargado = '".$input['idUsuarioEnc']."'";

		$sql="
		DECLARE @fecIni DATE = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
		SELECT DISTINCT r.idRuta, CONVERT(VARCHAR(10),r.fecha,103) fecha, r.tipoUsuario, r.idUsuario, r.nombreUsuario usuario
		, v.idVisita, v.canal, v.idCliente, v.razonSocial, v.codCliente, v.direccion
		, i.idVisitaIpp, i.puntaje puntajeGlobal
		, id.idPregunta, id.idAlternativa, id.puntaje, p.idCriterio
		FROM {$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i ON i.idVisita=v.idVisita
		JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet id ON id.idVisitaIpp=i.idVisitaIpp
		JOIN trade.cliente c ON c.idCliente = v.idCliente
		JOIN {$this->sessBDCuenta}.trade.ipp_pregunta p ON p.idPregunta= id.idPregunta

		JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON ch.idCliente = c.idCliente
		AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1
		
		WHERE r.estado=1 AND r.demo=0
		AND r.fecha BETWEEN @fecIni AND @fecFin
		AND v.idCliente= ".$input['idCliente']." 
		$filtros
		ORDER BY fecha, v.idVisita, v.idCliente, id.idPregunta, id.idAlternativa ASC";
		
		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}

	public function obtener_detallado($input){
		
		$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND r.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['subCanal']) ) $filtros.=" AND ctp.idClienteTipo =".$input['subCanal'];
    	if( !empty($input['sl-tienda']) ) $filtros.=" AND c.idCliente =".$input['sl-tienda'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
		
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";

        $sql="
		DECLARE @fecIni DATE = '".$input['fecIni']."', @fecFin DATE = '".$input['fecFin']."';
		SELECT DISTINCT r.idRuta, CONVERT(VARCHAR(10),r.fecha,103) fecha, r.tipoUsuario, r.idUsuario, r.nombreUsuario usuario
		, v.idVisita, v.canal, v.idCliente, v.razonSocial, v.codCliente, v.direccion
		, ubi.departamento, ubi.provincia, ubi.distrito
		, i.idVisitaIpp, i.puntaje puntajeGlobal
		, id.idVisitaIpp, id.idPregunta, id.idAlternativa, id.puntaje 
		, b.nombre banner, ca.nombre cadena, ca.idCadena, b.idBanner
		, cc.idCriterio, cn.idCanal
		FROM {$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
		JOIN {$this->sessBDCuenta}.trade.data_visita v ON v.idRuta=r.idRuta
		JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i ON i.idVisita=v.idVisita
		JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet id ON id.idVisitaIpp=i.idVisitaIpp
		JOIN trade.cliente c ON c.idCliente = v.idCliente
		JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo = c.cod_ubigeo
		JOIN trade.canal cn ON cn.idCanal=v.idCanal
		JOIN trade.banner b ON b.idBanner=v.idBanner
		JOIN trade.cadena ca ON ca.idCadena =b.idCadena
		--
		JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip ON ip.idPregunta=id.idPregunta
		JOIN {$this->sessBDCuenta}.trade.ipp_criterio cc ON cc.idCriterio=ip.idCriterio

		JOIN {$this->sessBDCuenta}.trade.cliente_historico ch ON ch.idCliente = c.idCliente
			AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) AND ch.flagCartera=1
		LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
		LEFT JOIN trade.cliente_tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo

		WHERE r.estado=1 AND r.demo=0
		AND r.fecha BETWEEN @fecIni AND @fecFin
		$filtros
		ORDER BY v.canal, cadena, banner ASC";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}
	
	public function obtenerFiltro_clientesModerno($input){
		$filtros = '';
		if(!empty($input['idCadena']) ) $filtros .= "  bn.idCadena= ".$input['idCadena'];
		if(!empty($input['idBanner']) ) $filtros .= " AND scm.idBanner= ".$input['idBanner'];

		$sql="
		SELECT DISTINCT bn.idCadena,scm.idBanner, ch.idCliente,ch.razonSocial 
		FROM {$this->sessBDCuenta}.trade.cliente_historico ch
		JOIN trade.segmentacionClienteModerno scm ON ch.idSegClienteModerno=scm.idSegClienteModerno
		JOIN trade.banner bn ON bn.idBanner=scm.idBanner
		WHERE $filtros
		ORDER BY ch.razonSocial
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.cliente_historico" ];
		return $this->db->query($sql);
	}
	
	//NUEVO DETALLADO
	
	public function obtener_mensual($input){
		
		$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND r.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
		if( !empty($input['subCanal']) ) $filtros.=" AND ctp.idClienteTipo =".$input['subCanal'];
    	if( !empty($input['sl-tienda']) ) $filtros.=" AND c.idCliente =".$input['sl-tienda'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
		
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";

        $sql="
			DECLARE 
				  @fecIni DATE = '01/01/".$input['anio']."'
				, @fecFin DATE = '31/12/".$input['anio']."';
			SELECT DISTINCT
				  mes
				, anio
				, idPregunta
				, idCriterio
				, objetivo
				, ROUND(promPuntajePregunta,2) promPuntajePregunta
				, ROUND(SUM(promPuntajePregunta) OVER(PARTITION BY anio,mes,idCriterio),2) totalCriterio
				, ROUND(SUM(promPuntajePregunta) OVER(PARTITION BY anio,mes),2) totalGeneral
			FROM (
				SELECT DISTINCT
					  mes
					, anio
					, idPregunta
					, idCriterio
					, objetivo
					, promPuntajePregunta
				FROM (
					SELECT DISTINCT
						  mes
						, anio
						, idPregunta
						, idCriterio
						, promPuntajePregunta
						, objetivo
						
					FROM (
						SELECT DISTINCT
							  idRuta
							, fecha
							, mes
							, anio
							, tipoUsuario
							, idUsuario
							, usuario
							, idVisita
							, canal
							, idCliente
							, razonSocial
							, codCliente
							, direccion
							, departamento
							, provincia
							, distrito
							, idVisitaIpp
							, puntajeGlobal
							, idPregunta
							, idAlternativa
							, puntaje 
							, banner
							, cadena
							, idCadena
							, idBanner
							, idCriterio
							, idCanal
							, AVG(puntaje) OVER (PARTITION BY anio,mes,idPregunta) promPuntajePregunta
							, objetivo
						FROM (
						SELECT DISTINCT 
							  r.idRuta
							, CONVERT(VARCHAR(10),r.fecha,103) fecha
							, DATEPART(MONTH,fecha) mes
							, DATEPART(YEAR,fecha) anio
							, r.tipoUsuario
							, r.idUsuario
							, r.nombreUsuario usuario
							, v.idVisita
							, v.canal
							, v.idCliente
							, v.razonSocial
							, v.codCliente
							, v.direccion
							, ubi.departamento
							, ubi.provincia
							, ubi.distrito
							, i.idVisitaIpp
							, i.puntaje puntajeGlobal
							, id.idPregunta
							, id.idAlternativa
							, id.puntaje 
							, b.nombre banner
							, ca.nombre cadena
							, ca.idCadena
							, b.idBanner
							, cc.idCriterio
							, cn.idCanal
							, a.objetivo
							, ctp.nombre subCanal
						FROM 
							{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
							JOIN {$this->sessBDCuenta}.trade.data_visita v 
								ON v.idRuta=r.idRuta
							JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i 
								ON i.idVisita=v.idVisita
							JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet id 
								ON id.idVisitaIpp=i.idVisitaIpp
							JOIN trade.cliente c 
								ON c.idCliente = v.idCliente
							JOIN General.dbo.ubigeo ubi 
								ON ubi.cod_ubigeo = c.cod_ubigeo
							JOIN trade.canal cn 
								ON cn.idCanal=v.idCanal
							JOIN trade.banner b 
								ON b.idBanner=v.idBanner
							JOIN trade.cadena ca 
								ON ca.idCadena =b.idCadena
							--
							JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip 
								ON ip.idPregunta=id.idPregunta
							JOIN {$this->sessBDCuenta}.trade.ipp_criterio cc 
								ON cc.idCriterio=ip.idCriterio
							JOIN {$this->sessBDCuenta}.trade.cliente_historico ch 
								ON ch.idCliente = c.idCliente
								AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) 
								AND ch.flagCartera=1
							LEFT JOIN trade.segmentacionNegocio sn ON sn.idSegNegocio = ch.idSegNegocio AND sn.estado = 1
							LEFT JOIN trade.cliente_tipo ctp ON sn.idClienteTipo = ctp.idClienteTipo
							JOIN (
								SELECT DISTINCT
									anio,idMes,o.objetivo
								FROM 
									trade.dashboard_objetivos o
									JOIN General.dbo.tiempo t	
										ON t.fecha BETWEEN o.fecIni AND ISNULL(o.fecFin,@fecFin)
										AND o.idModulo=1
								)a
								ON a.anio= DATEPART(YEAR,r.fecha)
								AND a.idMes = DATEPART(MONTH,r.fecha)
						WHERE
							r.estado=1 
							AND r.demo=0
							AND r.fecha BETWEEN @fecIni AND @fecFin
							$filtros
						)a
						WHERE
							puntaje > 0
					)b
				)c
			)d
			";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}

	public function obtener_banner($input){
		$sql ="
			DECLARE 
				  @fecIni DATE = '01/".$input['mes']."/".$input['anio']."'
			DECLARE @fecFin DATE =  DATEADD(MONTH, DATEDIFF(MONTH, -1, @fecIni), -1); ;
			SELECT DISTINCT 
				  v.idBanner
				, v.banner
			FROM 
				{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
				JOIN {$this->sessBDCuenta}.trade.data_visita v 
					ON v.idRuta=r.idRuta
				JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i 
					ON i.idVisita=v.idVisita
				JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet id 
					ON id.idVisitaIpp=i.idVisitaIpp
			WHERE
				r.estado=1 
				AND r.demo=0
				AND r.fecha BETWEEN @fecIni AND @fecFin
			ORDER BY idBanner
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}
	
	public function obtener_data_semanal($input){
		$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND r.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-tienda']) ) $filtros.=" AND c.idCliente =".$input['sl-tienda'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
		
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";

		$sql ="
			DECLARE 
				  @fecIni DATE = '01/".$input['mes']."/".$input['anio']."'
			DECLARE @fecFin DATE =  DATEADD(MONTH, DATEDIFF(MONTH, -1, @fecIni), -1); ;
			SELECT DISTINCT
				  mes
				, anio
				, idBanner
				, semana
				, idPregunta
				, idCriterio
				, objetivo
				, ROUND(promPuntajePregunta,2) promPuntajePregunta
				, ROUND(SUM(promPuntajePregunta) OVER(PARTITION BY anio,mes,semana,idBanner,idCriterio),2) totalCriterio
				, ROUND(SUM(promPuntajePregunta) OVER(PARTITION BY anio,mes,semana,idBanner),2) totalGeneral
			FROM (
				SELECT DISTINCT
					  mes
					, anio
					, semana
					, idBanner
					, idPregunta
					, idCriterio
					, objetivo
					, promPuntajePregunta
					--, COUNT(idVisita) OVER(PARTITION BY anio,mes,semana,idBanner) encuestas
				FROM (
					SELECT DISTINCT
						  mes
						, anio
						, idPregunta
						, idCriterio
						, semana
						, idBanner
						, promPuntajePregunta
						, objetivo
						--, idVisita
					FROM (
						SELECT DISTINCT
							  idRuta
							, fecha
							, mes
							, anio
							, tipoUsuario
							, idUsuario
							, usuario
							, idVisita
							, canal
							, idCliente
							, razonSocial
							, codCliente
							, direccion
							, departamento
							, provincia
							, distrito
							, idVisitaIpp
							, puntajeGlobal
							, idPregunta
							, idAlternativa
							, puntaje 
							, banner
							, cadena
							, idCadena
							, idBanner
							, idCriterio
							, idCanal
							, AVG(puntaje) OVER (PARTITION BY anio,mes,semana,idBanner,idPregunta) promPuntajePregunta
							, objetivo
							, semana
						FROM (
						SELECT DISTINCT 
							  r.idRuta
							, CONVERT(VARCHAR(10),r.fecha,103) fecha
							, DATEPART(MONTH,r.fecha) mes
							, DATEPART(YEAR,r.fecha) anio
							, r.tipoUsuario
							, r.idUsuario
							, r.nombreUsuario usuario
							, v.idVisita
							, v.canal
							, v.idCliente
							, v.razonSocial
							, v.codCliente
							, v.direccion
							, ubi.departamento
							, ubi.provincia
							, ubi.distrito
							, i.idVisitaIpp
							, i.puntaje puntajeGlobal
							, id.idPregunta
							, id.idAlternativa
							, id.puntaje 
							, b.nombre banner
							, ca.nombre cadena
							, ca.idCadena
							, b.idBanner
							, cc.idCriterio
							, cn.idCanal
							, a.objetivo
							, a.semana
						FROM 
							{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
							JOIN {$this->sessBDCuenta}.trade.data_visita v 
								ON v.idRuta=r.idRuta
							JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i 
								ON i.idVisita=v.idVisita
							JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet id 
								ON id.idVisitaIpp=i.idVisitaIpp
							JOIN trade.cliente c 
								ON c.idCliente = v.idCliente
							JOIN General.dbo.ubigeo ubi 
								ON ubi.cod_ubigeo = c.cod_ubigeo
							JOIN trade.canal cn 
								ON cn.idCanal=v.idCanal
							JOIN trade.banner b 
								ON b.idBanner=v.idBanner
							JOIN trade.cadena ca 
								ON ca.idCadena =b.idCadena
							--
							JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip 
								ON ip.idPregunta=id.idPregunta
							JOIN {$this->sessBDCuenta}.trade.ipp_criterio cc 
								ON cc.idCriterio=ip.idCriterio
							JOIN {$this->sessBDCuenta}.trade.cliente_historico ch 
								ON ch.idCliente = c.idCliente
								AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) 
								AND ch.flagCartera=1
							JOIN (
								SELECT DISTINCT
									t.fecha,anio,idMes,o.objetivo,semana
								FROM 
									trade.dashboard_objetivos o
									JOIN General.dbo.tiempo t	
										ON t.fecha BETWEEN o.fecIni AND ISNULL(o.fecFin,@fecFin)
										AND o.idModulo=1
								)a
								ON a.fecha=r.fecha
						WHERE
							r.estado=1 
							AND r.demo=0
							AND r.fecha BETWEEN @fecIni AND @fecFin
							$filtros
						)a
						WHERE
							puntaje > 0
					)b
				)c
			)d

		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}
	
	public function obtener_encuestas_semanal($input){
		$filtros = '';
    	if( !empty($input['sl-cuenta']) ) $filtros.=" AND r.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-tienda']) ) $filtros.=" AND c.idCliente =".$input['sl-tienda'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
		
		if(!empty($input['idUsuarioEnc']) ) $filtros .= " AND r.idUsuario = ".$input['idUsuarioEnc']."";
		$sql ="
			DECLARE 
				  @fecIni DATE = '01/".$input['mes']."/".$input['anio']."'
			DECLARE @fecFin DATE =  DATEADD(MONTH, DATEDIFF(MONTH, -1, @fecIni), -1); ;
			SELECT DISTINCT
				  mes
				, anio
				, semana
				, idBanner
				, COUNT(idVisita) OVER(PARTITION BY anio,mes,semana,idBanner) encuestas
			FROM (
				SELECT DISTINCT
					  idRuta
					, fecha
					, mes
					, anio
					, tipoUsuario
					, idUsuario
					, usuario
					, idVisita
					, canal
					, idCliente
					, razonSocial
					, codCliente
					, direccion
					, departamento
					, provincia
					, distrito
					, banner
					, cadena
					, idCadena
					, idBanner
					, idCanal
					, objetivo
					, semana
				FROM (
				SELECT DISTINCT 
					  r.idRuta
					, CONVERT(VARCHAR(10),r.fecha,103) fecha
					, DATEPART(MONTH,r.fecha) mes
					, DATEPART(YEAR,r.fecha) anio
					, r.tipoUsuario
					, r.idUsuario
					, r.nombreUsuario usuario
					, v.idVisita
					, v.canal
					, v.idCliente
					, v.razonSocial
					, v.codCliente
					, v.direccion
					, ubi.departamento
					, ubi.provincia
					, ubi.distrito
					, i.idVisitaIpp
					, i.puntaje puntajeGlobal
					, id.idPregunta
					, id.idAlternativa
					, id.puntaje 
					, b.nombre banner
					, ca.nombre cadena
					, ca.idCadena
					, b.idBanner
					, cc.idCriterio
					, cn.idCanal
					, a.objetivo
					, a.semana
				FROM 
					{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
					JOIN {$this->sessBDCuenta}.trade.data_visita v 
						ON v.idRuta=r.idRuta
					JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i 
						ON i.idVisita=v.idVisita
					JOIN {$this->sessBDCuenta}.trade.data_visitaIppDet id 
						ON id.idVisitaIpp=i.idVisitaIpp
					JOIN trade.cliente c 
						ON c.idCliente = v.idCliente
					JOIN General.dbo.ubigeo ubi 
						ON ubi.cod_ubigeo = c.cod_ubigeo
					JOIN trade.canal cn 
						ON cn.idCanal=v.idCanal
					JOIN trade.banner b 
						ON b.idBanner=v.idBanner
					JOIN trade.cadena ca 
						ON ca.idCadena =b.idCadena
					--
					JOIN {$this->sessBDCuenta}.trade.ipp_pregunta ip 
						ON ip.idPregunta=id.idPregunta
					JOIN {$this->sessBDCuenta}.trade.ipp_criterio cc 
						ON cc.idCriterio=ip.idCriterio
					JOIN {$this->sessBDCuenta}.trade.cliente_historico ch 
						ON ch.idCliente = c.idCliente
						AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) 
						AND ch.flagCartera=1
					JOIN (
						SELECT DISTINCT
							t.fecha,anio,idMes,o.objetivo,semana
						FROM 
							trade.dashboard_objetivos o
							JOIN General.dbo.tiempo t	
								ON t.fecha BETWEEN o.fecIni AND ISNULL(o.fecFin,@fecFin)
								AND o.idModulo=1
						)a
						ON a.fecha=r.fecha
				WHERE
					r.estado=1 
					AND r.demo=0
					AND r.fecha BETWEEN @fecIni AND @fecFin
				)a
			)b

		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}
	
	public function obtener_encuestas_resumen($input){
		$filtros="";
		if( !empty($input['sl-cuenta']) ) $filtros.=" AND r.idCuenta =".$input['sl-cuenta'];
    	if( !empty($input['sl-proyecto']) ) $filtros.=" AND r.idProyecto =".$input['sl-proyecto'];
    	if( !empty($input['sl-grupoCanal']) ) $filtros.=" AND cn.idGrupoCanal =".$input['sl-grupoCanal'];
    	if( !empty($input['sl-canal']) ) $filtros.=" AND cn.idCanal =".$input['sl-canal'];
    	if( !empty($input['sl-tienda']) ) $filtros.=" AND c.idCliente =".$input['sl-tienda'];
    	if( !empty($input['sl-departamento']) ) $filtros.=" AND ubi.cod_departamento =".$input['sl-departamento'];
    	if( !empty($input['sl-provincia']) ) $filtros.=" AND ubi.cod_provincia =".$input['sl-provincia'];
    	if( !empty($input['sl-distrito']) ) $filtros.=" AND ubi.cod_distrito =".$input['sl-distrito'];
    	if( !empty($input['sl-cadena']) ) $filtros.=" AND b.idCadena =".$input['sl-cadena'];
    	if( !empty($input['sl-banner']) ) $filtros.=" AND b.idBanner =".$input['sl-banner'];
		$sql = "
			DECLARE 
				  @fecIni DATE = '01/01/".$input['anio']."'
				, @fecFin DATE = '31/12/".$input['anio']."';
			SELECT DISTINCT
				  mes
				, anio
				, COUNT(idVisita) OVER(PARTITION BY anio,mes) encuestas
			FROM (
				SELECT DISTINCT
					  mes
					, anio
					, idVisita
					
				FROM (
					SELECT DISTINCT
						  idRuta
						, fecha
						, mes
						, anio
						, idVisita
						, departamento
						, provincia
						, distrito
						, banner
						, idBanner
						, idCanal
					FROM (
					SELECT DISTINCT 
						  r.idRuta
						, CONVERT(VARCHAR(10),r.fecha,103) fecha
						, DATEPART(MONTH,fecha) mes
						, DATEPART(YEAR,fecha) anio
						, v.idVisita
						, ubi.departamento
						, ubi.provincia
						, ubi.distrito
						, v.banner
						, v.idBanner
						, v.idCanal
					FROM  
						{$this->sessBDCuenta}.trade.data_ruta r WITH(NOLOCK)
						JOIN {$this->sessBDCuenta}.trade.data_visita v 
							ON v.idRuta=r.idRuta
						JOIN {$this->sessBDCuenta}.trade.data_visitaIpp i 
							ON i.idVisita=v.idVisita
						JOIN trade.cliente c 
							ON c.idCliente = v.idCliente
						JOIN General.dbo.ubigeo ubi 
							ON ubi.cod_ubigeo = c.cod_ubigeo

						JOIN trade.canal cn 
							ON cn.idCanal=v.idCanal
						JOIN trade.banner b 
							ON b.idBanner=v.idBanner
						--
						JOIN {$this->sessBDCuenta}.trade.cliente_historico ch 
							ON ch.idCliente = c.idCliente
							AND r.fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,r.fecha) 
							AND ch.flagCartera=1
					WHERE
						r.estado=1 
						AND r.demo=0
						AND r.fecha BETWEEN @fecIni AND @fecFin
						$filtros
					)a
					
				)b
			)c
		";

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.data_ruta" ];
		return $this->db->query($sql);
	}
}

?>