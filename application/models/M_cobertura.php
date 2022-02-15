<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cobertura extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getClientesProgramados($params = [])
	{
		$filtros = "";
		$filtros .= !empty($params['idCuenta']) ? ' AND e.idCuenta = ' . $params['idCuenta'] : '';

		$sql = "
		DECLARE
			@fecIni DATE = '{$params['fecIni']}'
			, @fecFin DATE = '{$params['fecFin']}'
		SELECT * , COUNT(idCliente) OVER(PARTITION BY idCanal) total_canal FROM (
		SELECT DISTINCT
			c.codCliente
			, c.idCliente
			, c.razonSocial AS cliente
			, ca.idCanal
			, ca.nombre AS canal
		FROM
			ImpactTrade_pg.trade.programacion_ruta pr
			JOIN ImpactTrade_pg.trade.programacion_visita pv ON pr.idProgRuta = pv.idProgRuta
			LEFT JOIN ImpactTrade_bd.trade.cliente c ON pv.idCliente = c.idCliente
			LEFT JOIN ImpactTrade_pg.trade.cliente_historico ch ON c.idCliente = ch.idCliente AND ch.idProyecto = pr.idProyecto-- AND ch.fecFin IS NULL
			LEFT JOIN ImpactTrade_bd.trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
			JOIN ImpactTrade_bd.trade.canal ca ON sn.idCanal = ca.idCanal
		WHERE fn.datesBetween(pr.fecIni, pr.fecFin, @fecIni, @fecFin) = 1
		) AS a
		";

		return $this->db->query($sql);
	}

	public function getFechas($params = [])
	{
		$sql = "
		DECLARE
			@fecIni DATE = '{$params['fecIni']}'
			, @fecFin DATE = '{$params['fecFin']}'
		SELECT
			idTiempo,
			CONVERT(VARCHAR(10), fecha, 103) fecha,
			dia
		FROM
			general.dbo.tiempo tt
		WHERE
			fecha BETWEEN @fecIni
			AND @fecFin
		ORDER BY
			tt.fecha ASC
		";

		return $this->db->query($sql);
	}

	public function getHorasProgramadas($params = [])
	{
		$sql = "
		DECLARE
			@fecIni DATE = '{$params['fecIni']}'
			, @fecFin DATE = '{$params['fecFin']}';
		WITH horario_programado AS (
			SELECT
			DISTINCT 
			pv.idCliente
			, prd.idUsuario
			, tt.fecha
			, tt.idTiempo
			, h.horaIni
			, h.horaFin
			, (CONVERT(float,DATEDIFF(mi, h.horaIni, h.horaFin))/60)
				- CONVERT(TINYINT, ISNULL(pvd.flagRefrigerio, 0))
			AS hp_dia
			FROM 
			ImpactTrade_pg.trade.programacion_ruta pr
			JOIN ImpactTrade_pg.trade.programacion_rutaDet prd ON pr.idProgRuta = prd.idProgRuta
			JOIN ImpactTrade_pg.trade.programacion_visita pv ON pr.idProgRuta = pv.idProgRuta
			JOIN ImpactTrade_pg.trade.programacion_visitaDet pvd ON pv.idProgVisita = pvd.idProgVisita
			JOIN ImpactTrade_pg.trade.horarios h ON pvd.idHorario = h.idHorario
		
			JOIN general.dbo.tiempo tt ON tt.idDia = pvd.dia
			AND tt.fecha BETWEEN @fecIni
			AND @fecFin
			JOIN ImpactTrade_bd.trade.cliente c ON pv.idCliente = c.idCliente
			JOIN ImpactTrade_pg.trade.cliente_historico ch ON c.idCliente = ch.idCliente AND ch.idProyecto = pr.idProyecto
			AND fn.datesBetween(ch.fecIni, ch.fecFin, @fecIni,@fecFin) = 1
			WHERE
			prd.estado = 1
			AND c.estado = 1
			AND tt.fecha BETWEEN prd.fecIni AND ISNULL(prd.fecFin,tt.fecha)
		)
		SELECT DISTINCT
			idCliente,
			HP,
			SUM(hp_dia) OVER (PARTITION BY idCliente,fecha) hp_dia,
			fecha,
			idTiempo,
			idUsuario
		FROM (
		SELECT
			DISTINCT idCliente,
			SUM(hp_dia) OVER (PARTITION BY idCliente) HP,
			hp_dia,
			idUsuario,
			fecha,
			idTiempo
		FROM horario_programado
		)a
		";

		return $this->db->query($sql);
	}

	public function getVisitas($params = [])
	{
		$sql = "
		DECLARE
			@fecIni DATE = '{$params['fecIni']}'
			, @fecFin DATE = '{$params['fecFin']}';
		SELECT DISTINCT
			idCliente 
			, idTiempo
			, SUM(HT) OVER (PARTITION BY idCliente,idTiempo ) HT
			, idUsuario
		
		FROM (
			SELECT DISTINCT
					r.idUsuario
				, v.idCliente 
				, tt.idTiempo
				, ROUND(CONVERT(FLOAT, (
						DATEDIFF(MI, v.horaIni, v.horaFin)/*- (
							CASE pvd.flagRefrigerio
								WHEN 1 THEN DATEDIFF(MI,
									ISNULL(asi.horaIniRefrigerio, '00:00:00'),
									ISNULL(asi.horaFinRefrigerio, '00:00:00')
								)
								ELSE 0
							END
						)*/
					)) / 60, 1) AS HT
		
			FROM
				ImpactTrade_pg.trade.data_ruta r
				JOIN ImpactTrade_pg.trade.data_visita v ON r.idRuta = v.idRuta
				JOIN ImpactTrade_bd.trade.cliente t ON v.idCliente = t.idCliente
				LEFT JOIN ImpactTrade_bd.trade.cliente_historico ht ON t.idCliente = ht.idCliente
				AND r.fecha BETWEEN ht.fecIni AND ISNULL(ht.fecFin, r.fecha) AND ht.idProyecto = r.idProyecto
		
				JOIN ImpactTrade_pg.trade.programacion_rutaDet pr ON r.idUsuario = pr.idUsuario AND r.fecha BETWEEN pr.fecIni AND ISNULL(pr.fecFin, r.fecha)
				JOIN ImpactTrade_pg.trade.programacion_visita pv ON v.idCliente = pv.idCliente AND pr.idProgRuta = pv.idProgRuta
				JOIN ImpactTrade_pg.trade.programacion_visitaDet pvd ON pv.idProgVisita = pvd.idProgVisita
		
				JOIN General.dbo.tiempo tt ON tt.fecha = r.fecha
				JOIN ImpactTrade_bd.trade.usuario u on r.idUsuario = u.idUsuario AND u.demo = 0
		
			WHERE 
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0
				AND v.horaIni IS NOT NULL
				AND v.horaFin IS NOT NULL
				--AND dso.idDescanso IS NULL
		)a
		ORDER BY
			idCliente ASC
		";

		return $this->db->query($sql);
	}

	public function getClientesProgramadosSpoc($params = [])
	{
		$filtros = "";
		$filtros .= !empty($params['idCuenta']) ? ' AND e.idCuenta = ' . $params['idCuenta'] : '';

		$sql = "
		DECLARE
			@fecIni DATE = '{$params['fecIni']}'
			, @fecFin DATE = '{$params['fecFin']}'
		SELECT * , COUNT(idCliente) OVER(PARTITION BY idCanal) total_canal FROM (
		SELECT DISTINCT
			c.codCliente
			, c.idCliente
			, c.razonSocial AS cliente
			, ca.idCanal
			, ca.nombre AS canal
			, u.nombres + ' ' +ISNULL(u.apePaterno,'') + ' ' + ISNULL(u.apeMaterno,'') usuario
			, u.idUsuario
		FROM
			ImpactTrade_pg.trade.programacion_ruta pr
			JOIN ImpactTrade_pg.trade.programacion_rutaDet prd ON pr.idProgRuta = prd.idProgRuta
			JOIN ImpactTrade_bd.trade.usuario u ON u.idUsuario = prd.idUsuario
			JOIN ImpactTrade_bd.trade.usuario_historico uh ON uh.idUsuario = prd.idUsuario
				AND fn.datesBetween(uh.fecIni, uh.fecFin, @fecIni, @fecFin) = 1
				AND uh.idTipoUsuario IN(2)
			JOIN ImpactTrade_pg.trade.programacion_visita pv ON pr.idProgRuta = pv.idProgRuta
			LEFT JOIN ImpactTrade_bd.trade.cliente c ON pv.idCliente = c.idCliente
			LEFT JOIN ImpactTrade_pg.trade.cliente_historico ch ON c.idCliente = ch.idCliente AND ch.idProyecto = pr.idProyecto-- AND ch.fecFin IS NULL
			LEFT JOIN ImpactTrade_bd.trade.segmentacionNegocio sn ON ch.idSegNegocio = sn.idSegNegocio
			JOIN ImpactTrade_bd.trade.canal ca ON sn.idCanal = ca.idCanal
		WHERE fn.datesBetween(pr.fecIni, pr.fecFin, @fecIni, @fecFin) = 1
		) AS a
		";

		return $this->db->query($sql);
	}

	public function getVisitaSpoc($params = [])
	{
		$sql = "
		DECLARE
			@fecIni DATE = '{$params['fecIni']}'
			, @fecFin DATE = '{$params['fecFin']}';
		SELECT DISTINCT
			idCliente 
			, idTiempo
			, SUM(HT) OVER (PARTITION BY idCliente,idTiempo ) HT
			, idUsuario
		
		FROM (
			SELECT DISTINCT
					r.idUsuario
				, v.idCliente 
				, tt.idTiempo
				, ROUND(CONVERT(FLOAT, (
						DATEDIFF(MI, v.horaIni, v.horaFin)/*- (
							CASE pvd.flagRefrigerio
								WHEN 1 THEN DATEDIFF(MI,
									ISNULL(asi.horaIniRefrigerio, '00:00:00'),
									ISNULL(asi.horaFinRefrigerio, '00:00:00')
								)
								ELSE 0
							END
						)*/
					)) / 60, 1) AS HT
		
			FROM
				ImpactTrade_pg.trade.data_ruta r
				JOIN ImpactTrade_pg.trade.data_visita v ON r.idRuta = v.idRuta
				JOIN ImpactTrade_bd.trade.cliente t ON v.idCliente = t.idCliente
				LEFT JOIN ImpactTrade_bd.trade.cliente_historico ht ON t.idCliente = ht.idCliente
				AND r.fecha BETWEEN ht.fecIni AND ISNULL(ht.fecFin, r.fecha) AND ht.idProyecto = r.idProyecto
		
				JOIN ImpactTrade_pg.trade.programacion_rutaDet pr ON r.idUsuario = pr.idUsuario AND r.fecha BETWEEN pr.fecIni AND ISNULL(pr.fecFin, r.fecha)
				JOIN ImpactTrade_pg.trade.programacion_visita pv ON v.idCliente = pv.idCliente AND pr.idProgRuta = pv.idProgRuta
				JOIN ImpactTrade_pg.trade.programacion_visitaDet pvd ON pv.idProgVisita = pvd.idProgVisita
		
				JOIN General.dbo.tiempo tt ON tt.fecha = r.fecha
				JOIN ImpactTrade_bd.trade.usuario u on r.idUsuario = u.idUsuario AND u.demo = 0
			WHERE 
				r.fecha BETWEEN @fecIni AND @fecFin
				AND r.demo = 0
				AND v.horaIni IS NOT NULL
				AND v.horaFin IS NOT NULL
				--AND r.idTipoUsuario IN(2)
				--AND dso.idDescanso IS NULL
		)a
		ORDER BY
			idCliente ASC
		";

		return $this->db->query($sql);
	}
}
