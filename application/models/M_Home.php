<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Home extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function find_data(){
		$sql = "
			SELECT TOP 1000 * FROM trade.data_asistencia
		";
		return $this->db->query($sql);
	}

	public function get_latest_fotos(){

        $filtros ='';
        $idCanal =$this->session->userdata('idCanal');
        $idCuenta =$this->session->userdata('idCuenta');
        $idProyecto =$this->session->userdata('idProyecto');

        if(!empty($idCanal)){$filtros.= " AND v.idCanal = {$idCanal} ";}
        if(!empty($idCuenta)){$filtros.= " AND r.idCuenta = {$idCuenta} ";}
        if(!empty($idProyecto)){$filtros.= " AND r.idProyecto = {$idProyecto} ";}


        $sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
        if( $sessIdTipoUsuario != 4 ){
            if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
            else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
        }
		$sql = "
        DECLARE @fecha DATE = GETDATE();
        WITH lista_fotos AS (
            SELECT 
                v.idVisita
                , vf.idVisitaFoto
                , vf.hora
                , ROW_NUMBER() OVER ( PARTITION BY v.idVisita ORDER BY ISNULL(vf.hora, v.horaFin) DESC ) fila
            FROM 
                trade.data_visita v
                JOIN trade.data_ruta r ON v.idRuta = r.idRuta
                JOIN trade.data_visitaFotos vf ON v.idVisita  = vf.idVisita
            WHERE 
                r.fecha = @fecha
                AND r.estado = 1 AND v.estado = 1 
        ) 
        
        SELECT TOP 20
            v.idVisita
            , UPPER(v.razonSocial) razonSocial
            , UPPER(ISNULL(vmf.nombreTipoFoto, am.nombre)) nombreTipoFoto
            , vf.fotoUrl
            , ISNULL(vf.hora, v.horaFin) hora
            , CONVERT(VARCHAR,r.fecha,103) fecha
            , r.nombreUsuario
            , r.tipoUsuario
            , vf.idModulo
            , ISNULL(v.latIni,0) lati_ini
            , ISNULL(v.lonIni,0) long_ini
            , ISNULL(v.latFin,0) lati_fin
            , ISNULL(v.lonFin,0) long_fin
            , ISNULL(c.latitud,0) latitud
            , ISNULL(c.longitud,0) longitud
            , CONVERT(VARCHAR(8), v.horaIni) hora_ini
            , CONVERT(VARCHAR(8), v.horaFin) hora_fin
        FROM trade.data_visita v
            JOIN trade.data_ruta r ON v.idRuta = r.idRuta
            JOIN trade.data_visitaFotos vf ON v.idVisita = vf.idVisita
            LEFT JOIN trade.data_visitaModuloFotos vmf ON vmf.idVisita = v.idVisita AND vf.idVisitaFoto = vmf.idVisitaFoto
            LEFT JOIN trade.aplicacion_modulo am ON am.idModulo = vf.idModulo
            JOIN trade.cliente c ON c.idCliente = v.idCliente

            --
            JOIN lista_fotos lf on lf.idVisita = v.idVisita AND vf.idVisitaFoto = lf.idVisitaFoto AND lf.fila = 1
        WHERE (r.fecha) = @fecha
        $filtros
        ORDER BY hora DESC
		";
		
		return $this->db->query($sql);

    }
    public function get_efectividad(){

        $filtros ='';
        $idCanal =$this->session->userdata('idCanal');
        $idCuenta =$this->session->userdata('idCuenta');
        $idProyecto =$this->session->userdata('idProyecto');

        if(!empty($idCanal)){$filtros.= " AND v.idCanal = {$idCanal} ";}
        if(!empty($idCuenta)){$filtros.= " AND r.idCuenta = {$idCuenta} ";}
        if(!empty($idProyecto)){$filtros.= " AND r.idProyecto = {$idProyecto} ";}

        $sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
        if( $sessIdTipoUsuario != 4 ){
            if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
            else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
        }

        $sql = "
        DECLARE 
        @hoy DATE = GETDATE(),--@fecFin
        @inicio_mes DATE = DATEADD(dd,-(DAY(GETDATE())-1),GETDATE());--@fecIni
    --
    WITH lista_visitas AS(
    SELECT DISTINCT
         v.idVisita
        , CASE WHEN (r.fecha = @hoy) THEN 1 ELSE 0 END hoy
        , r.fecha
        , CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND v.numFotos >= 1 AND estadoIncidencia <> 1 ) THEN
                3
            ELSE
                CASE WHEN (v.horaIni IS NOT NULL ) THEN
                        1
            ELSE
                CASE WHEN (estadoIncidencia IS NOT NULL OR estadoIncidencia = 1) THEN
                        2
                    ELSE
                        0
                    END
                END
            END condicion
    FROM 
        trade.data_ruta r WITH(NOLOCK)
        JOIN trade.data_visita v ON r.idRuta = v.idRuta
    WHERE 
        r.fecha BETWEEN @inicio_mes AND @hoy
        AND r.estado = 1
        AND v.estado = 1


        $filtros
    ), lista_final AS (SELECT DISTINCT
        COUNT(idVisita) OVER () totalProg
        , COUNT(CASE WHEN condicion = 3 THEN 1 END) OVER () totalEfectiva
        , COUNT(CASE WHEN condicion = 2 THEN 1 END) OVER () totalIncidencia
        , COUNT(CASE WHEN condicion = 1 THEN 1 END) OVER () totalProcesos
        , COUNT(CASE WHEN condicion = 0 THEN 1 END) OVER () totalNoVisitados
        , fecha
        , CASE WHEN (fecha = @hoy) THEN 1 ELSE 0 END hoy
        , COUNT(idVisita) OVER (PARTITION BY fecha) totalProgHoy
        , COUNT(CASE WHEN condicion = 3 THEN 1 END) OVER (PARTITION BY fecha) totalEfectivaHoy
        , COUNT(CASE WHEN condicion = 2 THEN 1 END) OVER (PARTITION BY fecha) totalIncidenciaHoy
        , COUNT(CASE WHEN condicion = 1 THEN 1 END) OVER (PARTITION BY fecha) totalProcesoHoy
        , COUNT(CASE WHEN condicion = 0 THEN 1 END) OVER (PARTITION BY fecha) totalNoVisitadosHoy
    FROM lista_visitas
    )
    SELECT * FROM lista_final WHERE hoy = 1
     
        ";

        return $this->db->query($sql);

    }


	public function get_cobertura(){
        $filtros ='';
        $idCanal =$this->session->userdata('idCanal');
        $idCuenta =$this->session->userdata('idCuenta');
        $idProyecto =$this->session->userdata('idProyecto');

        if(!empty($idCanal)){$filtros.= " AND v.idCanal = {$idCanal} ";}
        if(!empty($idCuenta)){$filtros.= " AND r.idCuenta = {$idCuenta} ";}
        if(!empty($idProyecto)){$filtros.= " AND r.idProyecto = {$idProyecto} ";}

        $sessIdTipoUsuario = $this->idTipoUsuario;
		$sessDemo = $this->demo;
        if( $sessIdTipoUsuario != 4 ){
            if( empty($sessDemo) ) $filtros .=  " AND r.demo = 0";
            else $filtros .=  " AND (r.demo = 0 OR r.idUsuario = {$this->idUsuario})";
        }
        $sql = "
        DECLARE 
        @hoy DATE = GETDATE(),--@fecFin
        @inicio_mes DATE = DATEADD(dd,-(DAY(GETDATE())-1),GETDATE());--@fecIni
        --
        WITH lista_visitas AS(
        SELECT DISTINCT
            v.idVisita
            , v.idCliente
            , CASE WHEN (r.fecha = @hoy) THEN 1 ELSE 0 END hoy
            , r.fecha
            , CASE WHEN (v.horaIni IS NOT NULL AND v.horaFin IS NOT NULL AND v.numFotos >= 1 AND estadoIncidencia <> 1  ) THEN
                    3
                ELSE
                    CASE WHEN (v.horaIni IS NOT NULL ) THEN
                            1
                    ELSE
                        CASE WHEN (estadoIncidencia IS NOT NULL OR estadoIncidencia = 1) THEN
                            2
                        ELSE
                            0
                        END
                    END
                END condicion
        FROM 
            trade.data_ruta r WITH(NOLOCK)
            JOIN trade.data_visita v ON r.idRuta = v.idRuta
        WHERE 
            r.fecha BETWEEN @inicio_mes AND @hoy
            AND r.estado = 1
            AND v.estado = 1
           
            $filtros
        ), lista_cliente AS (
        SELECT
            idCliente
            , SUM(CASE WHEN condicion = 3 OR condicion = 2 THEN 1 ELSE 0 END) OVER (PARTITION BY idCliente) cobertura
            --
            , fecha
            , hoy
            , condicion
            , ROW_NUMBER() OVER (PARTITION BY idCliente ORDER BY fecha DESC) fila
        FROM lista_visitas
        )
        SELECT
            COUNT(CASE WHEN fila = 1 THEN 1 END) totalCartera
            , COUNT(CASE WHEN fila = 1 AND cobertura > 0 THEN 1 END) totalCobertura
            --
            , COUNT(CASE WHEN hoy = 1 AND fila = 1 THEN 1 END) carteraHoy
            , COUNT(CASE WHEN hoy = 1 AND fila = 1 AND (condicion = 3 OR condicion = 2) THEN 1 END) coberturaHoy
        FROM
            lista_cliente
         ";
            
        return $this->db->query($sql);

    }
}