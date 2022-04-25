<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ServicioCobertura extends MY_Model
{

    var $CI;

    public function __construct()
    {
        parent::__construct();

        $this->CI = &get_instance();
    }

    public function obtenerQuincena($params = [])
    {
        $anio = $params['anno_filtro'];
        $mes = $params['mes_filtro'];
        $quincena_filtro = $params['quincena_filtro'];

        $sql = "
        SELECT
            CONVERT(VARCHAR,fecha,103) fecha
            , anio
            , mes
            , dia
            , CONVERT(varchar,DAY(fecha)) + ' de ' + mes AS nombreDia
        FROM General.dbo.tiempo
        WHERE anio = '{$anio}' AND idMes = '{$mes}' AND quincena = {$quincena_filtro}
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

		$this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'General.dbo.tiempo' ];
		return $result;
    }

    public function obtenerResumenCobertura($params = []){
        $filtros = 'WHERE 1 = 1 ';

        !empty($params['tipo']) ? $filtros .= " AND ls.tipo = {$params['tipo']} ": $filtros .= " AND ls.tipo = 0 "; 
        $sql = "
        WITH list_usuarios_cobertura AS (
            SELECT DISTINCT
            v.idGerenteZonal,
            v.grupoCanal,
            v.gerenteZonal,
            v.coordinador,
            v.supervisor,
            v.cod_visual,
            v.razonSocial,
            MAX(v.cod_usuario) OVER (PARTITION BY v.nombreRuta,v.cod_visual) cod_usuario,
            CASE 
                WHEN v.idGrupoCanal = 4 THEN ub.provincia 
                WHEN v.idGrupoCanal = 5 THEN v.plaza
                ELSE '' 
            END SUCURSAL_PLAZA,
            SUM(CASE WHEN v.idTipoExclusion IS NULL THEN CONVERT(INT,v.obj) ELSE 0 END ) OVER (PARTITION BY v.nombreRuta,v.cod_visual) objetivo,
            SUM(CASE WHEN v.idTipoExclusion IS NULL THEN CONVERT(INT,v.cobertura) ELSE 0 END ) OVER (PARTITION BY v.nombreRuta,v.cod_visual) cobertura,
            v.nombreRuta
            FROM 
            trade.tmp_view_visitas v
            LEFT JOIN ImpactTrade_bd.trade.usuario u ON u.idUsuario = v.cod_usuario
            LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = v.cod_ubigeo 
            WHERE 
            v.idUsuarioReg = {$this->idUsuario}
        ) , lst_base_cobertura AS(

        SELECT DISTINCT
        v.grupoCanal ,
        ISNULL(v.gerenteZonal,v.coordinador) gerenteZonal,
        ISNULL(v.supervisor,v.coordinador) spoc,
        v.cod_visual ,
        v.SUCURSAL_PLAZA,
        v.razonSocial ,
        v.cod_usuario ,
        u.numDocumento ,
        ISNULL(u.nombres,'') + ' ' + ISNULL(u.apePaterno,'') + ' ' + ISNULL(u.apeMaterno,'') usuario,
        v.nombreRuta ,
        v.objetivo ,
        v.cobertura 
        FROM list_usuarios_cobertura v
        JOIN ImpactTrade_bd.trade.usuario u ON u.idUsuario = v.cod_usuario
        ),lst_resumen_cobertura_cabecera AS(
            SELECT DISTINCT 
            gerenteZonal,
            SUM(objetivo) OVER (PARTITION BY gerenteZonal) obj ,
            SUM(cobertura) OVER (PARTITION BY gerenteZonal) cobertura
            FROM
            lst_base_cobertura 
        ),lst_resumen_cobertura_detalle AS(
            SELECT DISTINCT 
            gerenteZonal,
            grupoCanal,
            sucursal_plaza,
            SUM(objetivo) OVER (PARTITION BY gerenteZonal,grupoCanal,sucursal_plaza) obj ,
            SUM(cobertura) OVER (PARTITION BY gerenteZonal,grupoCanal,sucursal_plaza) cobertura
            FROM
            lst_base_cobertura 
        ),lst_resumen_cobertura_total AS(
            SELECT DISTINCT 
            SUM(objetivo) OVER (PARTITION BY 1) obj ,
            SUM(cobertura) OVER (PARTITION BY 1) cobertura
            FROM
            lst_base_cobertura 
        ), lst_resumen_cobertura AS(
        SELECT 
        c.gerenteZonal nombre,
        '' canal,
        '' sucursal,
        c.obj objetivo,
        c.cobertura,
        ROUND(((CONVERT(FLOAT,c.cobertura) / CONVERT(FLOAT,c.obj)) * 100),2) efectividad,
        (c.obj - c.cobertura) diferencia,
        '1' tipo
        FROM lst_resumen_cobertura_cabecera c
        UNION
        SELECT 
        d.gerenteZonal nombre,
        d.grupoCanal canal,
        d.sucursal_plaza sucursal,
        d.obj objetivo,
        d.cobertura,
        ROUND(((CONVERT(FLOAT,d.cobertura) / CONVERT(FLOAT,d.obj)) * 100),2) efectividad,
        (d.obj - d.cobertura) diferencia,
        '0' tipo
        FROM lst_resumen_cobertura_detalle d
        UNION
        SELECT 
        '' nombre,
        '' canal,
        '' sucursal,
        t.obj objetivo,
        t.cobertura,
        ROUND(((CONVERT(FLOAT,t.cobertura) / CONVERT(FLOAT,t.obj)) * 100),2) efectividad,
        (t.obj - t.cobertura) diferencia,
        '2' tipo
        FROM lst_resumen_cobertura_total t

        )
        SELECT * FROM 
        lst_resumen_cobertura ls
        {$filtros}
        ORDER BY ls.nombre,ls.canal,ls.sucursal
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query;
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;

    }
    public function obtenerResumenHoras($params = []){
        $filtros = 'WHERE 1 = 1 ';

        !empty($params['tipo']) ? $filtros .= " AND ls.tipo = {$params['tipo']} ": $filtros .= " AND ls.tipo = 0 "; 
        $sql = "
        WITH lst_gerentes_coordinador AS(
            SELECT DISTINCT
            ISNULL(gerenteZonal,coordinador) gerenteZonal_coordinador,
            base.*
            FROM  
            ImpactTrade_bd.trade.tmp_view_base_servicio base 
            WHERE idUsuarioReg = {$this->idUsuario}
            ) , lst_horas_cabecera AS(
                SELECT DISTINCT 
                gerenteZonal_coordinador gerente,
                '' canal,
                '' sucursal,
                SUM(CONVERT(INT,obj_diario)) OVER (PARTITION BY gerenteZonal_coordinador) obj,
                SUM(CONVERT(INT,hora_servicio)) OVER (PARTITION BY gerenteZonal_coordinador) cobertura,
                SUM(CONVERT(INT,horas_efectivas)) OVER (PARTITION BY gerenteZonal_coordinador) horas_efectivas,
                '1' tipo
                FROM 
                lst_gerentes_coordinador
            ) , lst_horas_detalle AS(
                SELECT DISTINCT 
                gerenteZonal_coordinador gerente,
                grupoCanal canal,
                sucursal_plaza sucursal,
                SUM(CONVERT(INT,obj_diario)) OVER (PARTITION BY gerenteZonal_coordinador,grupoCanal,sucursal_plaza) obj,
                SUM(CONVERT(INT,hora_servicio)) OVER (PARTITION BY gerenteZonal_coordinador,grupoCanal,sucursal_plaza) cobertura,
                SUM(CONVERT(INT,horas_efectivas)) OVER (PARTITION BY gerenteZonal_coordinador,grupoCanal,sucursal_plaza) horas_efectivas,
                '0' tipo
                FROM 
                lst_gerentes_coordinador
            ) , lst_horas_total AS(
                SELECT DISTINCT 
                SUM(CONVERT(INT,obj_diario)) OVER (PARTITION BY 1) obj,
                SUM(CONVERT(INT,hora_servicio)) OVER (PARTITION BY 1) cobertura,
                SUM(CONVERT(INT,horas_efectivas)) OVER (PARTITION BY 1) horas_efectivas,
                '2' tipo
                FROM 
                lst_gerentes_coordinador
            ), lst_resumen_horas AS(
                SELECT 
                c.gerente nombre,
                c.canal,
                c.sucursal,
                c.obj objetivo,
                c.cobertura,
                ROUND(((CONVERT(FLOAT,c.horas_efectivas) / CONVERT(FLOAT,c.obj)) * 100),2) efectividad,
                ROUND(((CONVERT(FLOAT,c.cobertura) / CONVERT(FLOAT,c.obj)) * 100),2) porcentaje,
                (c.obj - c.cobertura) diferencia,
                c.tipo
                FROM 
                lst_horas_cabecera c
                UNION
                SELECT 
                d.gerente nombre,
                d.canal,
                d.sucursal,
                d.obj objetivo,
                d.cobertura,
                ROUND(((CONVERT(FLOAT,d.horas_efectivas) / CONVERT(FLOAT,d.obj)) * 100),2) efectividad,
                ROUND(((CONVERT(FLOAT,d.cobertura) / CONVERT(FLOAT,d.obj)) * 100),2) porcentaje,
                (d.obj - d.cobertura) diferencia,
                d.tipo
                FROM 
                lst_horas_detalle d
                UNION
                SELECT 
                '' nombre,
                '' canal,
                '' sucursal,
                t.obj objetivo,
                t.cobertura,
                ROUND(((CONVERT(FLOAT,t.horas_efectivas) / CONVERT(FLOAT,t.obj)) * 100),2) efectividad,
                ROUND(((CONVERT(FLOAT,t.cobertura) / CONVERT(FLOAT,t.obj)) * 100),2) porcentaje,
                (t.obj - t.cobertura) diferencia,
                t.tipo
                FROM 
                lst_horas_total t
            ) 
            SELECT * FROM lst_resumen_horas ls
            {$filtros}
            ORDER BY nombre, canal, sucursal
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query;
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_base_servicio' ];
		return $result;

    }
    public function obtenerCobertura($params = []){
        $filtros = 'WHERE 1 = 1 ';

        !empty($params['cabecera']) ? $filtros .= " AND ls.cabecera = 1 ": $filtros .= " AND ls.cabecera = 0 "; 
        $sql = "
        WITH list_usuarios_cobertura AS (
            SELECT DISTINCT
            v.idGerenteZonal,
            v.grupoCanal,
            v.gerenteZonal,
            v.coordinador,
            v.supervisor,
            v.cod_visual,
            v.razonSocial,
            MAX(v.cod_usuario) OVER (PARTITION BY v.nombreRuta,v.cod_visual) cod_usuario,
            CASE 
                WHEN v.idGrupoCanal = 4 THEN ub.provincia 
                WHEN v.idGrupoCanal = 5 THEN v.plaza
                ELSE '' 
            END SUCURSAL_PLAZA,
            SUM(CASE WHEN 
            v.idTipoExclusion IS NULL 
                THEN CONVERT(INT,v.obj) ELSE 0 END ) OVER (PARTITION BY v.nombreRuta,v.cod_visual) objetivo,
            SUM(CASE WHEN 
            v.idTipoExclusion IS NULL 
                THEN CONVERT(INT,v.cobertura) ELSE 0 END ) OVER (PARTITION BY v.nombreRuta,v.cod_visual) cobertura,
            v.nombreRuta
            FROM 
            trade.tmp_view_visitas v
            LEFT JOIN ImpactTrade_bd.trade.usuario u ON u.idUsuario = v.cod_usuario
            LEFT JOIN General.dbo.ubigeo ub ON ub.cod_ubigeo = v.cod_ubigeo 
            WHERE 
            v.idUsuarioReg = {$this->idUsuario}
        ) 
        SELECT DISTINCT
        v.grupoCanal CANAL,
        ISNULL(v.gerenteZonal,v.coordinador) GERENTE,
        ISNULL(v.supervisor,v.coordinador) SPOC,
        v.cod_visual CODIGO_VISUAL,
        v.SUCURSAL_PLAZA,
        v.razonSocial RAZON_SOCIAL,
        v.cod_usuario IDGTM,
        u.numDocumento DNI,
        ISNULL(u.nombres,'') + ' ' + ISNULL(u.apePaterno,'') + ' ' + ISNULL(u.apeMaterno,'') GTM_NAME,
        v.nombreRuta RUTA,
        v.objetivo OBJ,
        v.cobertura COB
        FROM list_usuarios_cobertura v
        JOIN ImpactTrade_bd.trade.usuario u ON u.idUsuario = v.cod_usuario
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;

    }
    public function obtenerBaseServicio($params = []){
        $filtros = 'WHERE 1 = 1 ';

        $sql = "
        SELECT 
        grupoCanal,
        ISNULL(gerenteZonal,coordinador) gerenteZonal,
        supervisor,
        sucursal_plaza,
        cod_usuario,
        u.numDocumento,
        ISNULL(u.nombres,'') + ' ' + ISNULL(u.apePaterno,'') + ' ' + ISNULL(u.apeMaterno,'') usuario,
        nombreRuta,
        dias,
        obj_q,
        obj_diario,
        '0' efectividad,
        '0' hora_servicio,
        s.visitasTotales,
        s.visitasMayores,
        s.horas_efectivas,
        s.alerta_marcacion,
        s.alerta_geo,
        s.acumulado_marcacion,
        s.acumulado_geo,
        (SELECT MAX(fecha) FROM trade.tmp_view_visitas where idUsuarioReg = {$this->idUsuario}) fechaMax
        FROM 
        trade.tmp_view_base_servicio s
        JOIN trade.usuario u ON u.idUsuario = s.cod_usuario
        {$filtros}
        AND s.idUsuarioReg = {$this->idUsuario}
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;

    }

    public function obtenerDataAsistencia($params = []){
        $filtros = 'WHERE 1 = 1 ';

        !empty($params['idUsuario']) ? $filtros .= " AND idUsuario = {$params['idUsuario']}" : ''; 

        $sql = "
        SELECT DISTINCT
        v.nombreRuta,
        v.fecha,
        (SELECT CONVERT(INT , SUM(CONVERT(INT,CAL)) / 60)  FROM trade.tmp_view_asistencia where idUsuarioReg = {$this->idUsuario}  AND fecha = v.fecha 
           AND  idUsuario IN( SELECT cod_usuario FROM trade.tmp_view_visitas WHERE nombreRuta = v.nombreRuta  ) 
        ) hora
        FROM trade.tmp_view_visitas v 
        {$filtros}
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;
    }

    public function obtenerDataRecuperacionSpc($params = []){

        $sql = "
        WITH lst_visitas AS (
            SELECT DISTINCT
            ISNULL(v.idGerenteZonal,v.idCoordinador) idGerente,
            ISNULL(v.idSupervisor,0) idSpoc,
            ISNULL(v.gerenteZonal,v.coordinador) gerente,
            ISNULL(v.supervisor,'') spoc,
            v.idRuta,
            v.cod_usuario,
            v.sucursal,
            SUM(CASE WHEN  (hora_ini IS NOT NULL ) THEN 1 ELSE 0 END ) OVER (PARTITION BY v.idRuta) visitas_llenas
            FROM 
            trade.tmp_view_visitas v
            WHERE idGrupoCanal = 4
            AND idTipoExclusion IS NULL 
            AND num_incidencia IS NULL
            AND idUsuarioReg = {$this->idUsuario}
        ) 
        SELECT DISTINCT
        ls.idGerente,
        ls.gerente,
        ls.idSpoc,
        ls.spoc,
        ls.sucursal,
        SUM(CASE WHEN ls.visitas_llenas = 0 THEN 1 ELSE 0 END) OVER (PARTITION BY ls.gerente,ls.spoc,ls.sucursal) rutas_pendientes,
        SUM(CASE WHEN ls.cod_usuario = ls.idGerente THEN 1 ELSE 0 END ) OVER (PARTITION BY ls.gerente,ls.spoc,ls.sucursal) recuperacion_gz,
        SUM(CASE WHEN ls.cod_usuario = ls.idSpoc THEN 1 ELSE 0 END ) OVER (PARTITION BY ls.gerente,ls.spoc,ls.sucursal) recuperacion_spoc
        FROM lst_visitas ls 
        ORDER BY ls.gerente, ls.spoc
        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;
    }

    public function generar_views($params = []){

        $filtros = "{$params['anno_filtro']},{$params['mes_filtro']},{$params['quincena_filtro']},{$this->sessIdProyecto},{$this->idUsuario}";
        $sqlViewVisitas = "EXEC trade.get_view_visitas {$filtros}";
        $queryVisitas = $this->db->query($sqlViewVisitas);
        
        // if($params['tipoFormato'] == 1 || $params['tipoFormato'] == 3){
            $sqlViewAsistencia = "EXEC trade.get_view_asistencia {$filtros}";
            $queryAsistencia= $this->db->query($sqlViewAsistencia);
        // }

        // if($params['tipoFormato'] == 1 || $params['tipoFormato'] == 3){
            $sqlViewBaseServicio = "EXEC trade.get_view_base_servicio {$params['anno_filtro']},{$params['mes_filtro']},{$params['quincena_filtro']},{$this->idUsuario}";
            $queryBaseServicio= $this->db->query($sqlViewBaseServicio);
        // }

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view' ];
		return ($queryVisitas || $queryAsistencia ||  $queryBaseServicio);
    }

    public function get_alerta_geo($params = [])
    {
        $filtros = "WHERE alerta_geo = 1 AND idUsuarioReg = {$this->idUsuario}";

        !empty($params['ruta']) ? $filtros .= " AND nombreRuta = '{$params['ruta']}'" : '';
        !empty($params["hoy"]) ? $filtros .= "AND v.fecha = '{$params['fechaTope']}'" : '';

        $sql = "
        SELECT DISTINCT
        v.fecha,
        grupoCanal,
        gerenteZonal,
        supervisor,
        coordinador,
        cod_usuario,
        nombreUsuario,
        sucursal,
        plaza,
        cod_visual,
        razonSocial,
        hora_ini,
        hora_fin,
        lati_ini,
        long_ini,
        lati_fin,
        long_fin,
        longitud,
        latitud,
        ut.idTipoUsuario,
        ut.nombre tipoUsuario
        FROM 
        ImpactTrade_bd.trade.tmp_view_visitas v 
        JOIN trade.usuario_tipo ut ON v.idTipoUsuario = ut.idTipoUsuario
        {$filtros}
        ORDER BY v.fecha,v.grupoCanal

        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;
    }
    public function get_alerta_marcacion($params = [])
    {
        $filtros = "WHERE a.alerta_marcacion = 1 AND a.idUsuarioReg = {$this->idUsuario}";

        !empty($params['ruta']) ? $filtros .= " AND v.nombreRuta = '{$params['ruta']}'" : '';
        !empty($params["hoy"]) ? $filtros .= "AND a.fecha = '{$params['fechaTope']}'" : '';

        $sql = "
        SELECT DISTINCT
            a.fecha,
            a.departamento,
            a.provincia,
            a.distrito,
            a.grupoCanal,
            a.canal,
            a.idUsuario,
            a.usuario,
            a.numDocumento,
            a.movil,
            a.horarioIng,
            a.horaSalida,
            a.horaIngreso,
            a.horarioSal,
            a.horaIniVisita,
            a.horaFinVisita,
            a.latIngreso,
            a.longIngreso,
            a.latSalida,
            a.longSalida,
            a.alerta_marcacion
        FROM 
        ImpactTrade_bd.trade.tmp_view_asistencia a
        JOIN ImpactTrade_bd.trade.tmp_view_visitas v ON 
            a.idUsuario = v.cod_usuario
            -- AND v.fecha = a.fecha
        {$filtros}

        ";

        $query = $this->db->query($sql);
		$result = [];
		if ( $query ) {
			$result = $query->result_array();
		}

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tmp_view_visitas' ];
		return $result;
    }
}
