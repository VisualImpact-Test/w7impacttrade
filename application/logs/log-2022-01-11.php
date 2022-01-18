<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-11 21:19:06 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-11 21:20:30 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-11 21:26:44 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]La transacción (id. de proceso 56) quedó en interbloqueo en bloqueo recursos con otro proceso y fue elegida como sujeto del interbloqueo. Ejecute de nuevo la transacción. - Invalid query: 
        DECLARE @fecha DATE = GETDATE();
        WITH lista_fotos AS (
            SELECT 
                v.idVisita
                , vf.idVisitaFoto
                , vf.hora
                , ROW_NUMBER() OVER ( PARTITION BY v.idVisita ORDER BY ISNULL(vf.hora, v.horaFin) DESC ) fila
            FROM 
                ImpactTrade_pg.trade.data_visita v
                JOIN ImpactTrade_pg.trade.data_ruta r ON v.idRuta = r.idRuta
                JOIN ImpactTrade_pg.trade.data_visitaFotos vf ON v.idVisita  = vf.idVisita
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
        FROM ImpactTrade_pg.trade.data_visita v
            JOIN ImpactTrade_pg.trade.data_ruta r ON v.idRuta = r.idRuta
            JOIN ImpactTrade_pg.trade.data_visitaFotos vf ON v.idVisita = vf.idVisita
            LEFT JOIN ImpactTrade_pg.trade.data_visitaModuloFotos vmf ON vmf.idVisita = v.idVisita AND vf.idVisitaFoto = vmf.idVisitaFoto
            LEFT JOIN trade.aplicacion_modulo am ON am.idModulo = vf.idModulo
            JOIN trade.cliente c ON c.idCliente = v.idCliente

            --
            JOIN lista_fotos lf on lf.idVisita = v.idVisita AND vf.idVisitaFoto = lf.idVisitaFoto AND lf.fila = 1
        WHERE (r.fecha) = @fecha
         AND r.idCuenta = 3  AND r.idProyecto = 3 
        ORDER BY hora DESC
		
ERROR - 2022-01-11 22:04:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]La transacción (id. de proceso 78) quedó en interbloqueo en bloqueo recursos con otro proceso y fue elegida como sujeto del interbloqueo. Ejecute de nuevo la transacción. - Invalid query: 
        DECLARE @fecha DATE = GETDATE();
        WITH lista_fotos AS (
            SELECT 
                v.idVisita
                , vf.idVisitaFoto
                , vf.hora
                , ROW_NUMBER() OVER ( PARTITION BY v.idVisita ORDER BY ISNULL(vf.hora, v.horaFin) DESC ) fila
            FROM 
                ImpactTrade_pg.trade.data_visita v
                JOIN ImpactTrade_pg.trade.data_ruta r ON v.idRuta = r.idRuta
                JOIN ImpactTrade_pg.trade.data_visitaFotos vf ON v.idVisita  = vf.idVisita
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
        FROM ImpactTrade_pg.trade.data_visita v
            JOIN ImpactTrade_pg.trade.data_ruta r ON v.idRuta = r.idRuta
            JOIN ImpactTrade_pg.trade.data_visitaFotos vf ON v.idVisita = vf.idVisita
            LEFT JOIN ImpactTrade_pg.trade.data_visitaModuloFotos vmf ON vmf.idVisita = v.idVisita AND vf.idVisitaFoto = vmf.idVisitaFoto
            LEFT JOIN trade.aplicacion_modulo am ON am.idModulo = vf.idModulo
            JOIN trade.cliente c ON c.idCliente = v.idCliente

            --
            JOIN lista_fotos lf on lf.idVisita = v.idVisita AND vf.idVisitaFoto = lf.idVisitaFoto AND lf.fila = 1
        WHERE (r.fecha) = @fecha
         AND r.idCuenta = 3  AND r.idProyecto = 3 
        ORDER BY hora DESC
		
ERROR - 2022-01-11 22:13:49 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-11 22:14:26 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-11 22:25:18 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-11 22:26:09 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
ERROR - 2022-01-11 22:33:28 --> Severity: Notice --> Undefined index: SERVER_NAME C:\wamp64\visualimpact_test\w7impacttrade\application\config\config.php 26
