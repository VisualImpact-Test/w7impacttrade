<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cronjob extends CI_Model{

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
    public function get_plazas($params = array()){
		$sql = "
		SELECT pl.idPlaza AS id, pl.nombre 
		FROM trade.plaza pl 
		WHERE pl.estado = 1 AND pl.flagMayorista = 1
		ORDER BY pl.nombre";

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
        AND uh.idProyecto IN(13)
        ";

		return $this->db->query($sql);
    }

    public function get_visitas_pg($input = [])
    {
		$filtros = '';
        $segmentacion = $this->getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
        !empty($input['idGrupoCanal']) ? $filtros .= " AND gc.idGrupoCanal = {$input['idGrupoCanal']}" : '';
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
			, i.observacion observacionIncidencia
			, v.observacion 
			, dvvo.porcentajeV
			, dvvo.porcentajePM
			, vo.descripcion orden
            {$segmentacion['columnas_bd']}
		FROM
			ImpactTrade_pg.trade.data_ruta r
			JOIN ImpactTrade_pg.trade.data_visita v
				ON r.idRuta = v.idRuta
                AND (r.demo=0 OR r.demo IS NULL)
			JOIN trade.canal ca 
				ON ca.idCanal=v.idCanal
			LEFT JOIN trade.grupoCanal gc 
				ON ca.idGrupoCanal=gc.idGrupoCanal
			LEFT JOIN ImpactTrade_pg.trade.data_visitaIncidencia i
				ON i.idVisita = v.idVisita
			JOIN ImpactTrade_pg.trade.cliente_historico ch
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
			LEFT JOIN trade.data_visitaOrden vo 
				ON vo.idVisita = v.idVisita
            {$segmentacion['join']}
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(13)
			AND r.estado = 1
			AND v.estado = 1
			{$filtros}
		";

		return $this->db->query($sql);
    }
    public function get_resultados_pg($input = [])
    {
		$filtros = '';
        $segmentacion = $this->getSegmentacion([ 'grupoCanal_filtro' => $input['idGrupoCanal'] ]);
        !empty($input['idGrupoCanal']) ? $filtros .= " AND gc.idGrupoCanal = {$input['idGrupoCanal']}" : '';
        
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
			, i.observacion observacionIncidencia
			, v.observacion 
            , dvvo.porcentaje porcentajeEO
			, dvvo.porcentajeV
			, dvvo.porcentajePM
			, dvva.porcentaje porcentajeEA
			, dvvi.porcentaje porcentajeINI
			, vo.descripcion orden
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
			JOIN ImpactTrade_pg.trade.cliente_historico ch
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
            LEFT JOIN ImpactTrade_pg.trade.data_visitaVisibilidadObligatorio  dvvo 
				ON dvvo.idVisita = v.idVisita
			LEFT JOIN ImpactTrade_pg.trade.data_visitaVisibilidadAdicional dvva 
				ON dvva.idVisita = v.idVisita
			LEFT JOIN ImpactTrade_pg.trade.data_visitaVisibilidadIniciativa dvvi
				ON dvvi.idVisita = v.idVisita
			LEFT JOIN ImpactTrade_pg.trade.data_visitaOrden vo 
				ON vo.idVisita = v.idVisita
            {$segmentacion['join']}
		WHERE 
			r.fecha BETWEEN @fecha AND @fecha
            AND r.idProyecto IN(13)
			{$filtros}
		";

		return $this->db->query($sql);
    }

	public function get_grupos_canal_proyecto($params = [])
	{
		$filtros = '';
		$filtros .= !empty($params['idProyecto']) ? " AND pgc.idProyecto = {$params['idProyecto']}": '';

		$sql = "
		SELECT
			gca.idGrupoCanal AS id,
			gca.nombre
		FROM trade.grupoCanal gca
		JOIN trade.proyectoGrupoCanal pgc ON  gca.idGrupoCanal = pgc.idGrupoCanal 
			AND pgc.estado = 1
		JOIN trade.proyecto py ON py.idProyecto = pgc.idProyecto
			AND py.estado = 1
		WHERE gca.estado = 1 
		$filtros
		ORDER BY gca.nombre
		";

		return $this->db->query($sql)->result_array();
	}
	function getSegmentacion($input = [])
	{
		$result = [];
		$array = [];
		$filtro_permiso = "";
		
		$gruposCanal = $this->get_grupos_canal_proyecto();
		foreach ($gruposCanal as $key => $row) {
			$array['gruposCanal'][$row['id']] = $row['nombre'];
		}

		if (!empty($input['grupoCanal_filtro'])) {
			$grupoCanal = $array['gruposCanal'][$input['grupoCanal_filtro']];
			$join = '';
			$columnas = [];
			$columnas_bd = '';
			$tiposegmentacion = '';
			$orderBy = '';
			if (in_array($grupoCanal, GC_TRADICIONALES)) {
				$tiposegmentacion = 'tradicional';
				!empty($str_permisos) ? $filtro_permiso .= " AND sctd.idDistribuidoraSucursal IN ({$str_permisos})": '';
				$join .= " JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional ";
				$join .= " JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional {$filtro_permiso} ";

				if ($grupoCanal == 'HFS' || $grupoCanal == 'Tradicional') {
					array_push(
						$columnas,
						['header' => 'Distribuidora', 'columna' => 'distribuidora', 'align' => 'left'],
						['header' => 'Sucursal', 'columna' => 'ciudadDistribuidoraSuc', 'align' => 'left'],
						['header' => 'Zona', 'columna' => 'zona', 'align' => 'left']

					); //Columnas para la vista
					

					//Columnas para la consulta a base de datos
					$columnas_bd  .= '
						, d.nombre AS distribuidora
						, ubi1.provincia AS ciudadDistribuidoraSuc
						, ubi1.cod_ubigeo AS codUbigeoDisitrito
						, ds.idDistribuidoraSucursal
						, z.nombre AS zona
						';
					// JOINS para la consulta a base de datos
					$join .= " LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal ";
					$join .= " LEFT JOIN trade.distribuidora d ON d.idDistribuidora = ds.idDistribuidora ";
					$join .= " LEFT JOIN General.dbo.ubigeo ubi1 ON ubi1.cod_ubigeo=ds.cod_ubigeo";
					$join .= " LEFT JOIN trade.zona z ON ch.idZona = z.idZona";

					$orderBy = 'd.nombre,ubi1.provincia';
				};

			}
			if (in_array($grupoCanal, GC_MAYORISTAS)) {
				$tiposegmentacion = 'mayorista';
				!empty($str_permisos) ? $filtro_permiso .= " AND sct.idPlaza IN ({$str_permisos})": '';
				$join .= " JOIN trade.segmentacionClienteTradicional sct ON ch.idSegClienteTradicional = sct.idSegClienteTradicional {$filtro_permiso} ";
				$join .= " LEFT JOIN trade.segmentacionClienteTradicionalDet sctd ON sct.idSegClienteTradicional = sctd.idSegClienteTradicional ";

				if ($grupoCanal == 'WHLS') {
					array_push(
						$columnas,
						['header' => 'Plaza', 'columna' => 'plaza', 'align' => 'left']
					);
					$columnas_bd .= '
						, pl.nombre AS plaza 
						, pl.idPlaza
						, z.nombre AS zona
						, ds.idDistribuidoraSucursal
						, ubpl.provincia ciudadPlaza
						';

					$join .= " LEFT JOIN trade.plaza pl ON pl.idPlaza = sct.idPlaza";
					$join .= " LEFT JOIN trade.zona z ON ch.idZona = z.idZona";
					$join .= " LEFT JOIN trade.distribuidoraSucursal ds ON ds.idDistribuidoraSucursal = sctd.idDistribuidoraSucursal ";
					$join .= " LEFT JOIN General.dbo.ubigeo ubpl ON ubpl.cod_ubigeo = pl.cod_ubigeo ";

					$orderBy = 'pl.nombre,z.nombre';
				};
			}

			if (in_array($grupoCanal, GC_MODERNOS)) {
				$tiposegmentacion = 'moderno';
				!empty($str_permisos) ? $filtro_permiso .= " AND scm.idBanner IN ({$str_permisos})": '';
				$join .= " JOIN trade.segmentacionClienteModerno scm ON ch.idSegClienteModerno = scm.idSegClienteModerno {$filtro_permiso} ";

				if ($grupoCanal == 'HSM' || $grupoCanal == 'Moderno') {
					array_push(
						$columnas,
						['header' => 'Cadena', 'columna' => 'cadena', 'align' => 'left'],
						['header' => 'Banner', 'columna' => 'banner', 'align' => 'left']
					); //Columnas para la vista

					//Columnas para la consulta a base de datos
					$columnas_bd  .= '
						, cad.idCadena
						, ba.idBanner
						, ba.nombre AS banner
						, cad.nombre AS cadena
						';

					// JOINS para la consulta a base de datos
					$join .= " LEFT JOIN trade.banner ba ON ba.idBanner = scm.idBanner";
					$join .= " LEFT JOIN trade.cadena cad ON cad.idCadena = ba.idCadena";

					$orderBy = 'cad.nombre,ba.nombre';
				}
			}
		}

		$result['join'] = !empty($join) ? $join : '';
		$result['headers'] = !empty($columnas) ? $columnas : '';
		$result['columnas_bd'] = !empty($columnas_bd) ? $columnas_bd : '';
		$result['grupoCanal'] = !empty($grupoCanal) ? $grupoCanal : '';
		$result['tipoSegmentacion'] = !empty($tiposegmentacion) ? $tiposegmentacion : '';
		$result['orderBy'] = !empty($orderBy) ? $orderBy : '';

		return $result;
	}

	public function sustento_fotos_tradicional($iniFecha, $finFecha, $desde = null, $hasta = null)
	{
		$sql = "
			with cte as (
			select distinct
				v.idCliente
				, v.codCliente
				, replace(v.razonSocial,',',' ') empresa
				, (select ub.departamento from general.dbo.ubigeo ub where ub.cod_ubigeo =  v.cod_ubigeo) cuidad
				, r.fecha
				, v.horaIni
				, v.latIni
				, v.lonFin
				, m.nombre modulo
				, m.idModulo
				, 'http://movil.visualimpact.com.pe/Fotos/impactTrade_Android/'+mf.carpetaFoto +'/' + vf.fotoUrl foto
				, ROW_NUMBER() OVER (PARTITION BY v.idCliente ORDER BY v.idCliente) AS RowNum
			from ImpactTrade_pg.trade.data_ruta r
			join ImpactTrade_pg.trade.data_visita v on v.idRuta = r.idRuta
			join ImpactTrade_pg.trade.data_visitaFotos vf on vf.idVisita = v.idVisita
			join ImpactTrade_bd.trade.aplicacion_modulo m on m.idModulo = vf.idModulo
			join impacttrade_bd.trade.aplicacion_modulo_grupo mg on mg.idModuloGrupo = m.idModuloGrupo
			join impactTrade_bd.trade.aplicacion_modulo_grupo mf on mf.idModuloGrupo = mg.idModuloGrupo
			where 
				r.demo = 0 and 
				r.idProyecto = 3 and 
				r.estado = 1 and 
				v.estado = 1 and 
				r.idTipoUsuario = 1 and 
				(v.estadoIncidencia is null or v.estadoIncidencia = '') and 
				r.fecha between '{$iniFecha}' and '{$finFecha}')
			select TOP 10000 * from cte where RowNum between {$desde} and {$hasta}
		";

		$query = $this->db->query($sql);


		return $query->result_array();

	}

	public function sustento_fotos_moderno($iniFecha, $finFecha)
	{
		$sql = "
			DECLARE 
				@fecIni DATE ='{$iniFecha}',@fecFin DATE = '{$finFecha}'
			SELECT
				v.idVisita
				,v.idTienda
				, t.codigoTienda
				, t.razonSocial
				, ub.departamento
				,r.fecha
				, v.horaIni
				, v.horaFin
				, latIni latitud
				, lonIni longitud
				, vf.idVisitaFoto
				, 'https://www.visualimpact.com.pe/intranet/pg.php/c_get_img/img_autoservicio_spoc/'+ft.nombre modulo
			FROM 
				pg.autoservicio.spoc_visitaFoto vf
				JOIN pg.autoservicio.spoc_visita v
					ON v.idVisita = vf.idVisita
				JOIN pg.autoservicio.spoc_ruta r
					ON r.idRuta=v.idRuta
					AND r.fecha BETWEEN @fecIni AND @fecFin 
				JOIN pg.autoservicio.tienda t
					ON t.idTienda=v.idTienda
				JOIN General.dbo.ubigeo ub
					ON ub.cod_ubigeo=t.cod_ubigeo
				JOIN pg.autoservicio.spoc_fotoTipo ft
					ON ft.idFotoTipo=vf.idFotoTipo
		";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}

		return 0;
	}
	
	public function correos_sustento()
	{
		$sql = "
			SELECT * FROM ImpactTrade_bd.trade.correo_sustento WHERE estado=1
		";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}

		return 0;
	}
	
}
?>