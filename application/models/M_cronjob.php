<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cronjob extends MY_Model{

	public function __construct(){
		parent::__construct();
	}

    public function get_distribuidoras_sucursal($params = array()){
		$sql = "
        SELECT DISTINCT
            ds.idDistribuidoraSucursal AS id,
            d.nombre +' - '+ ubi.provincia AS nombre
        FROM trade.distribuidoraSucursal ds
        JOIN General.dbo.ubigeo ubi ON ds.cod_ubigeo = ubi.cod_ubigeo
        JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora
        WHERE ds.estado = 1
        ORDER BY id;	
        ";

		return $this->db->query($sql);
	}

    public function get_contactos_pg($params = [])
    {
        $columna = '';
        $join = '';

        if(!empty($params['tradicional']))
        {
            $columna = ',uhds.idDistribuidoraSucursal';
            $join = "JOIN trade.usuario_historicoDistribuidoraSucursal uhds ON uhds.idUsuarioHist = uh.idUsuarioHist";
        }else if(!empty($params['mayorista']))
        {
            $columna = ',uhpz.idPlaza';
            $join = "JOIN trade.usuario_historicoPlaza uhpz ON uhpz.idUsuarioHist = uh.idUsuarioHist";
        }else if(!empty($params['moderno']))
        {
            $columna = ',uhb.idBanner';
            $join = "JOIN trade.usuario_historicoBanner uhb ON uhb.idUsuarioHist = uh.idUsuarioHist";
        } 

        
        $sql = "
        DECLARE @fecha DATE = GETDATE();
        SELECT DISTINCT
        u.idUsuario
        ,u.nombres + ' ' + u.apePaterno + ' ' + ISNULL(u.apeMaterno,'') usuario
        ,ISNULL(u.email,e.email_corp) email
        {$columna}
        FROM
        trade.usuario u
        JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario 
            AND General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecha,@fecha) = 1
            AND uh.idTipoUsuario IN(2,6,10,11)
            AND uh.estado = 1
            AND u.estado = 1
        JOIN rrhh.dbo.empleado e ON e.numTipoDocuIdent = u.numDocumento
        {$join}
        WHERE
        u.demo = 0
        AND uh.idProyecto IN(3,13)
        ";

		return $this->db->query($sql);
    }

    public function get_visitas_pg($input = [])
    {
        $segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
        
        $sql = "
		DECLARE @fecha Date = GETDATE();
		SELECT DISTINCT
			v.idVisita
			, CONVERT(varchar,r.fecha,103) fecha
			, v.idCliente
            , v.razonSocial
			, v.idCanal
			, gc.nombre AS grupoCanal
			, v.canal
			, sc.nombre AS subCanal
			, v.estadoIncidencia
			, ct.nombre clienteTipo
			, ub1.departamento
			, ub1.provincia
			, v.direccion
			, ut.nombre AS tipoUsuario
			, r.nombreUsuario AS usuario
			, i.nombreIncidencia 
			, v.estadoIncidencia
			, i.observacion
            {$segmentacion['columnas_bd']}
		FROM
			ImpactTrade_pg.trade.data_ruta r
			JOIN ImpactTrade_pg.trade.data_visita v
				ON r.idRuta = v.idRuta
                AND r.demo=0
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN ".getClienteHistoricoCuenta()." ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecha,@fecha)=1
			JOIN trade.cliente c
				ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc 
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub1
				ON ub1.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN trade.usuario_tipo ut
				ON r.idTipoUsuario = ut.idTipoUsuario
            {$segmentacion['join']}
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(3,13)
		";

		return $this->db->query($sql);
    }
    public function get_resultados_pg($input = [])
    {
        $segmentacion = getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
        
        $sql = "
		DECLARE @fecha Date = GETDATE();
		SELECT DISTINCT
			v.idVisita
			, CONVERT(varchar,r.fecha,103) fecha
			, v.idCliente
            , v.razonSocial
			, v.idCanal
			, gc.nombre AS grupoCanal
			, v.canal
			, sc.nombre AS subCanal
			, v.estadoIncidencia
			, ct.nombre clienteTipo
			, ub1.departamento
			, ub1.provincia
			, v.direccion
			, ut.nombre AS tipoUsuario
			, r.nombreUsuario AS usuario
			, i.nombreIncidencia 
			, v.estadoIncidencia
			, i.observacion
            , dvvo.porcentaje porcentajeEO
			, dvvo.porcentajeV
			, dvvo.porcentajePM
			, dvva.porcentaje porcentajeEA
			, dvvi.porcentaje porcentajeINI
            {$segmentacion['columnas_bd']}
		FROM
			ImpactTrade_pg.trade.data_ruta r
			JOIN ImpactTrade_pg.trade.data_visita v
				ON r.idRuta = v.idRuta
                AND r.demo=0
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN ".getClienteHistoricoCuenta()." ch
				ON ch.idCliente = v.idCliente
				AND General.dbo.fn_fechaVigente(ch.fecIni,ch.fecFin,@fecha,@fecha)=1
			JOIN trade.cliente c
				ON c.idCliente = v.idCliente
			LEFT JOIN trade.segmentacionNegocio sn
				ON sn.idSegNegocio = ch.idSegNegocio
			LEFT JOIN trade.subCanal sc 
				ON sn.idSubCanal=sc.idSubCanal
			LEFT JOIN trade.cliente_tipo ct
				ON ct.idClienteTipo = sn.idClienteTipo
			LEFT JOIN General.dbo.ubigeo ub1
				ON ub1.cod_ubigeo = c.cod_ubigeo
			LEFT JOIN trade.usuario_tipo ut
				ON r.idTipoUsuario = ut.idTipoUsuario
            LEFT JOIN trade.data_visitaVisibilidadObligatorio  dvvo
				ON dvvo.idVisita = v.idVisita
			LEFT JOIN trade.data_visitaVisibilidadAdicional dvva 
				ON dvva.idVisita = v.idVisita
			LEFT JOIN trade.data_visitaVisibilidadIniciativa dvvi
				ON dvvi.idVisita = v.idVisita
            {$segmentacion['join']}
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(3,13)
		";

		return $this->db->query($sql);
    }
}
?>