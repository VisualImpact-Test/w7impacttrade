<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_liveStorecheck extends CI_Model{

	var $aSessTrack = [];
	var $aCC = [];

	public function __construct(){
		parent::__construct();

		// $this->aCC = [
				// 'jefry.mallma@visualimpact.com.pe'
			// ];
	}

	public function listTipoCliente( $input = [] ){
		$filtro = "";
			if( !empty($input['estado']) ) $filtro = " AND tc.estado = {$input['estado']}";
		$sql = "
SELECT
	tc.idTipoCliente,
	tc.nombre
FROM lsck.tipoCliente tc
WHERE 1 = 1{$filtro}
ORDER BY nombre
";
		return $this->db->query($sql)->result_array();
	}

	public function listPlaza( $input = [] ){
		if( empty($input['fecha']) ) $input['fecha'] = date('d/m/Y');
		if( empty($input['fecIni']) ) $input['fecIni'] = $input['fecha'];
		if( empty($input['fecFin']) ) $input['fecFin'] = $input['fecha'];

		$filtro = "";
			if( !empty($input['idPlaza']) ) $filtro .= " AND pz.idPlaza = {$input['idPlaza']}";

		$sql = "
DECLARE
	@fecIni DATE = '{$input['fecIni']}',
	@fecFin DATE = '{$input['fecFin']}';

SELECT
	ds.nombre + ' - ' + ubi_dsc.distrito AS distribuidora,
	pz.idPlaza,
	UPPER(pz.descripcion) AS nombre,
	ubi_pz.distrito AS distrito,
	COUNT(c.idCliente) AS totalTienda
FROM pg.auditoria.plazaCliente pz
JOIN pg.dbo.distribuidoraSucursal dsc ON pz.idDistribuidoraSucursal = dsc.idDistribuidoraSucursal
JOIN pg.dbo.distribuidora ds ON dsc.idDistribuidora = ds.idDistribuidora
JOIN General.dbo.ubigeo ubi_dsc ON dsc.cod_ubigeo = ubi_dsc.cod_ubigeo
LEFT JOIN General.dbo.ubigeo ubi_pz ON pz.cod_ubigeo = ubi_pz.cod_ubigeo
JOIN pg.dbo.cliente c ON pz.idPlaza = c.idPlaza
JOIN pg.dbo.clienteHistorico ch ON c.idCliente = ch.idCliente
	AND pg.fn.datesBetween(ch.fecCreacion, ch.fecTermino, @fecIni, @fecFin) = 1
JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON c.idCliente = cc.idCliente
	AND pg.fn.datesBetween(cc.fecIni, cc.fecFin, @fecIni, @fecFin) = 1
JOIN lsck.tipoCliente tc ON cc.idTipoCliente = tc.idTipoCliente
WHERE c.estado2 = 1{$filtro}
GROUP BY
	ds.nombre + ' - ' + ubi_dsc.distrito,
	pz.idPlaza,
	pz.descripcion,
	ubi_pz.distrito
ORDER BY 1,2,3

";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.auditoria.plazaCliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function listTienda( $input = [] ){
		if( empty($input['fecha']) ) $input['fecha'] = date('d/m/Y');
		if( empty($input['fecIni']) ) $input['fecIni'] = $input['fecha'];
		if( empty($input['fecFin']) ) $input['fecFin'] = $input['fecha'];

		$filtro = "";
			if( !empty($input['idPlaza']) ) $filtro .= " AND pz.idPlaza = {$input['idPlaza']}";
			if( !empty($input['idCliente']) ){
				if( !is_array($input['idCliente']) ) $input['idCliente'] = [ $input['idCliente'] ];
				$filtro .= " AND c.idCliente IN (".implode(',', $input['idCliente']).")";
			}
			if( !empty($input['buscar']) ) $filtro .= " AND CONVERT(VARCHAR, c.idCliente) + ' - ' + c.razonSocial + ' ' + c.direccion LIKE '%".trim($input['buscar'])."%'";

		$top = "";
			if( !empty($input['top']) )
				$top = " TOP {$input['top']}";

		$sql = "
DECLARE
	@fecIni DATE = '{$input['fecIni']}',
	@fecFin DATE = '{$input['fecFin']}';

SELECT{$top}
	c.idCliente,
	c.razonSocial,
	UPPER(c.direccion) AS direccion,
	tc.idTipoCliente,
	UPPER(tc.nombre) AS tipoCliente
FROM pg.auditoria.plazaCliente pz
JOIN pg.dbo.distribuidoraSucursal dsc ON pz.idDistribuidoraSucursal = dsc.idDistribuidoraSucursal
JOIN pg.dbo.distribuidora ds ON dsc.idDistribuidora = ds.idDistribuidora
JOIN General.dbo.ubigeo ubi_dsc ON dsc.cod_ubigeo = ubi_dsc.cod_ubigeo
LEFT JOIN General.dbo.ubigeo ubi_pz ON pz.cod_ubigeo = ubi_pz.cod_ubigeo
JOIN pg.dbo.cliente c ON pz.idPlaza = c.idPlaza
JOIN pg.dbo.clienteHistorico ch ON c.idCliente = ch.idCliente
	AND pg.fn.datesBetween(ch.fecCreacion, ch.fecTermino, @fecIni, @fecFin) = 1
JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON c.idCliente = cc.idCliente
	AND pg.fn.datesBetween(cc.fecIni, cc.fecFin, @fecIni, @fecFin) = 1
JOIN lsck.tipoCliente tc ON cc.idTipoCliente = tc.idTipoCliente
LEFT JOIN General.dbo.ubigeo ubi_c ON c.cod_ubigeo = ubi_c.cod_ubigeo
WHERE c.estado2 = 1{$filtro}
ORDER BY tipoCliente, razonSocial, direccion 
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'pg.dbo.cliente' ];
		return $this->db->query($sql)->result_array();
	}

	public function listInfo( $input = [] ){
		$filtro = "";
			if( isset($input['estado']) ) $filtro .= " AND estado = {$input['estado']}";

		$sql = "SELECT idInfo, nombre FROM lsck.tipoInfo WHERE 1 = 1{$filtro}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'lsck.tipoInfo' ];
		return $this->db->query($sql)->result_array();
	}

	public function listPlazaInfo( $input = [] ){
		$fecha = date('d/m/Y');
		$filtro = "";
			if( !empty($input['fecha']) ) $fecha = $input['fecha'];
			if( !empty($input['idPlaza']) ) $filtro .= " AND pzi.idPlaza = {$input['idPlaza']}";

		$sql = "
DECLARE @fecha DATE = '{$fecha}'
SELECT
	ti.idInfo,
	ti.nombre AS info,
	pzi.valor,
	tem.idEmpresa,
	tem.nombre AS empresa
FROM {$this->sessBDCuenta}.lsck.conf_plazaInfo pzi
JOIN lsck.tipoInfo ti ON pzi.idInfo = ti.idInfo
LEFT JOIN lsck.tipoEmpresa tem ON pzi.idEmpresa = tem.idEmpresa
WHERE @fecha BETWEEN pzi.fecIni AND ISNULL(pzi.fecFin, @fecha)
AND pzi.estado = 1{$filtro}
ORDER BY ti.idInfo
";
		return $this->db->query($sql)->result_array();
	}

	public function listPlazaTipoCliente( $input = [] ){
		$sql = "
DECLARE @fecha DATE = GETDATE();

SELECT
	cpz.idPlaza,
	cpz.idTipoCliente,
	exadt.idExtAudTipo,
	exadt.nombre AS extAudTipo,
	cpz.extAudPromedio,
	(
		SELECT COUNT(1)
		FROM pg.dbo.cliente c
		JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON c.idCliente = cc.idCliente
		WHERE c.idPlaza = cpz.idPlaza
		AND cc.idTipoCliente = cpz.idTipoCliente
	) AS totalTienda,
	(
		SELECT COUNT(idTipoClienteAudDet)
		FROM {$this->sessBDCuenta}.lsck.conf_tipoClienteAud ctca
		JOIN lsck.conf_tipoClienteAudDet ctcad ON ctca.idTipoClienteAud = ctcad.idTipoClienteAud
		WHERE ctca.idTipoCliente = cpz.idTipoCliente
		AND ctca.idExtAudTipo = exadt.idExtAudTipo
		AND @fecha BETWEEN ctca.fecIni AND ISNULL(ctca.fecFin, @fecha)
	) AS audTotal
FROM {$this->sessBDCuenta}.lsck.conf_plaza cpz
JOIN lsck.ext_auditoriaTipo exadt ON cpz.idExtAudTipo = exadt.idExtAudTipo
WHERE @fecha BETWEEN cpz.fecIni AND ISNULL(cpz.fecFin, @fecha)
AND cpz.idPlaza = {$input['idPlaza']}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.conf_plaza" ];
		return $this->db->query($sql)->result_array($sql);
	}

	public function listPlazaEvaluacion( $input = [] ){
		$filtro = "";
		$sql = "
DECLARE @fecha DATE = GETDATE();

SELECT
	ev.idEvaluacion,
	ev.nombre As evaluacion,
	evd.idEvaluacionDet,
	evd.nombre AS evaluacionDet,
	evd.detallar,
	levd.idEncuesta
FROM lsck.listEvaluacion lev
JOIN lsck.listEvaluacionDet levd ON lev.idListEval = levd.idListEval
JOIN lsck.tipoEvaluacionDet evd ON levd.idEvaluacionDet = evd.idEvaluacionDet
JOIN lsck.tipoEvaluacion ev ON evd.idEvaluacion = ev.idEvaluacion
WHERE @fecha BETWEEN lev.fecIni AND ISNULL(lev.fecFin, @fecha)
AND lev.idTipoAuditoria = 1 AND lev.estado = 1 AND levd.estado = 1
AND evd.estado = 1 AND ev.estado = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'lsck.listEvaluacion' ];
		return $this->db->query($sql)->result_array();
	}

	public function listPlazaAuditoria( $input = [] ){
		$filtro = "";

		$sql = "
SELECT
	pz.idPlaza,
	ds.nombre + ' - ' + ubi_dsc.distrito AS distribuidora,
	UPPER(pz.descripcion) AS plaza,
	ubi_pz.distrito AS distrito,
	COUNT(audpz.idAudPlaza) AS totalAud
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza audpz
JOIN pg.auditoria.plazaCliente pz ON audpz.idPlaza = pz.idPlaza
JOIN pg.dbo.distribuidoraSucursal dsc ON pz.idDistribuidoraSucursal = dsc.idDistribuidoraSucursal
JOIN pg.dbo.distribuidora ds ON dsc.idDistribuidora = ds.idDistribuidora
JOIN General.dbo.ubigeo ubi_dsc ON dsc.cod_ubigeo = ubi_dsc.cod_ubigeo
LEFT JOIN General.dbo.ubigeo ubi_pz ON pz.cod_ubigeo = ubi_pz.cod_ubigeo
WHERE audpz.estado = 1{$filtro}
GROUP BY pz.idPlaza, ds.nombre + ' - ' + ubi_dsc.distrito, pz.descripcion, ubi_pz.distrito
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlaza" ];
		return $this->db->query($sql)->result_array();
	}

	public function listPlazaHistorico( $input = [] ){
		$filtro = "";
			if( !empty($input['idPlaza']) ){
				if( !is_array($input['idPlaza']) ) $input['idPlaza'] = [ $input['idPlaza'] ];
				$filtro .= " AND pz.idPlaza IN (".implode(',', $input['idPlaza']).")";
			}

		$sql = "
SELECT
	apz.idAudPlaza,
	pz.idPlaza,
	CONVERT(VARCHAR, apz.fecha, 103) AS fecha,
	CONVERT(VARCHAR, apz.horaReg, 108) AS hora,
	aca.pregNota,
	aca.perfNota,
	aca.perfPorcentaje,
	UPPER(prf.nombre) AS perfCalificacion,
	(
		SELECT COUNT(ac.idCliente)
		FROM {$this->sessBDCuenta}.lsck.auditoriaCLiente ac
		WHERE ac.idAudPlaza = apz.idAudPlaza
		AND ac.estado = 1
	) AS totalCliente,
	UPPER(u.nombres + ISNULL(' ' + u.apePaterno, '') + ISNULL(' ' + u.apeMaterno, '')) AS usuario,
	apz.estado
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN {$this->sessBDCuenta}.lsck.auditoriaCalculo aca ON apz.idAudCalculo = aca.idAudCalculo
JOIN lsck.perfectOms prf ON aca.idPerfectOms = prf.idPerfectOms
JOIN trade.usuario u ON apz.idUsuario = u.idUsuario
WHERE apz.estado = 1 {$filtro}
ORDER BY apz.fecha DESC, apz.horaReg DESC
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlaza" ];
		return $this->db->query($sql)->result_array();
	}

	public function listTiendaEvaluacion( $input = [] ){
		$filtro = "";
			if( !empty($input['idCliente']) ){
				if( !is_array($input['idCliente']) ) $input['idCliente'] = [ $input['idCliente'] ];
				$filtro .= " AND cc.idCliente IN (".implode(',', $input['idCliente']).")";
			}

		$sql = "
DECLARE @fecha DATE = GETDATE();

SELECT
	cc.idTipoCliente,
	ev.idEvaluacion,
	ev.nombre As evaluacion,
	evd.idEvaluacionDet,
	evd.nombre AS evaluacionDet,
	evd.detallar,
	levd.idEncuesta
FROM {$this->sessBDCuenta}.lsck.conf_cliente cc
JOIN lsck.listEvaluacion lev ON cc.idTipoCliente = lev.idTipoCliente
JOIN lsck.listEvaluacionDet levd ON lev.idListEval = levd.idListEval
JOIN lsck.tipoEvaluacionDet evd ON levd.idEvaluacionDet = evd.idEvaluacionDet
JOIN lsck.tipoEvaluacion ev ON evd.idEvaluacion = ev.idEvaluacion
WHERE @fecha BETWEEN cc.fecIni AND ISNULL(cc.fecFin, @fecha)
AND @fecha BETWEEN lev.fecIni AND ISNULL(lev.fecFin, @fecha)
AND lev.idTipoAuditoria = 2{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlaza" ];
		return $this->db->query($sql)->result_array();
	}

	public function listTiendaExtAud( $input = [] ){
		$filtro = "";
			if( !empty($input['idCliente']) ){
				if( !is_array($input['idCliente']) ) $input['idCliente'] = [$input['idCliente']];
				$filtro .= " AND c.idCliente IN (".implode(',', $input['idCliente']).")";
			}

		$sql = "
DECLARE @fecha DATE = GETDATE();

SELECT
	c.idCliente,
	ca.idExtAudTipo,
	xam.idExtAudMat,
	xam.nombre AS material,
	cad.presencia
FROM {$this->sessBDCuenta}.lsck.conf_cliente c
JOIN {$this->sessBDCuenta}.lsck.conf_clienteAud ca ON c.idConfCliente = ca.idConfCliente
JOIN {$this->sessBDCuenta}.lsck.conf_clienteAudDet cad ON ca.idConfClienteAud = cad.idConfClienteAud
JOIN lsck.ext_auditoriaMaterial xam ON cad.idExtAudMat = xam.idExtAudMat
WHERE @fecha BETWEEN c.fecIni AND ISNULL(c.fecFin, @fecha){$filtro}
ORDER BY idCliente, idExtAudTipo, nombre
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.conf_cliente" ];
		return $this->db->query($sql)->result_array();
	}

	public function listTiendaAltNo( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudClienteEvalPreg']) ){
				if( !is_array($input['idAudClienteEvalPreg']) )
					$input['idAudClienteEvalPreg'] = [ $input['idAudClienteEvalPreg'] ];

				$filtro .= " AND acevp.idAudClienteEvalPreg IN (".implode(',', $input['idAudClienteEvalPreg']).")";
			}

		$sql = "
SELECT
	acevp.idAudClienteEvalPreg,
	pregalt.nombre AS item
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
JOIN lsck.tipoEncuestaPreg preg ON acevp.idPregunta = preg.idPregunta
JOIN lsck.tipoEncuestaPregAlt pregalt ON preg.idPregunta = pregalt.idPregunta
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt acevpa ON acevp.idAudClienteEvalPreg = acevpa.idAudClienteEvalPreg AND pregalt.idAlternativa = acevpa.idAlternativa
WHERE preg.idTipoPregunta = 3
AND acevpa.idAlternativa IS NULL{$filtro}

UNION

SELECT
	acevp.idAudClienteEvalPreg,
	exam.nombre AS item
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
JOIN lsck.tipoEncuestaPreg preg ON acevp.idPregunta = preg.idPregunta
JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON ac.idCliente = cc.idCliente AND apz.fecha BETWEEN cc.fecIni AND ISNULL(cc.fecFin, apz.fecha)
JOIN {$this->sessBDCuenta}.lsck.conf_clienteAud cca ON cc.idConfCliente = cca.idConfCliente AND preg.idExtAudTipo = cca.idExtAudTipo
JOIN {$this->sessBDCuenta}.lsck.conf_clienteAudDet ccad ON cca.idConfClienteAud = ccad.idConfClienteAud AND preg.extAudPresencia = ccad.presencia
JOIN lsck.ext_auditoriaMaterial exam ON ccad.idExtAudMat = exam.idExtAudMat
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt acevpa ON acevp.idAudClienteEvalPreg = acevpa.idAudClienteEvalPreg AND ccad.idExtAudMat = acevpa.idExtAudMat
WHERE acevpa.idExtAudMat IS NULL{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEval" ];
		return $this->db->query($sql)->result_array();
	}

	public function listTiendaHistorico( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				if( !is_array($input['idAudPlaza']) ) $input['idAudPlaza'] = [ $input['idAudPlaza'] ];
				$filtro .= " AND apz.idAudPlaza IN (".implode(',', $input['idAudPlaza']).")";
			}

		$sql = "
SELECT
	ac.idAudCliente,
	c.idCliente,
	c.razonSocial,
	c.direccion,
	tc.idTipoCliente,
	UPPER(tc.nombre) AS tipoCliente
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON ac.idCliente = cc.idCliente AND apz.fecha BETWEEN cc.fecIni AND ISNULL(cc.fecFin, apz.fecha)
JOIN lsck.tipoCliente tc ON cc.idTipoCliente = tc.idTipoCliente
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
WHERE ac.estado = 1{$filtro}
ORDER BY apz.fecha DESC, apz.horaReg DESC
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCLiente" ];
		return $this->db->query($sql)->result_array();
	}

	public function listFotoHistorico( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudCliente']) ) $filtro .= " AND af.idAudCliente = {$input['idAudCliente']}";
			if( !empty($input['idAudPlaza']) ) $filtro .= " AND af.idAudPlaza = {$input['idAudPlaza']}";

		$sql = "
SELECT
	ev.idEvaluacion,
	UPPER(ev.nombre) AS evaluacion,
	af.idAudFoto,
	af.estado
FROM {$this->sessBDCuenta}.lsck.auditoriaFoto af
JOIN lsck.tipoEvaluacion ev ON af.idEvaluacion = ev.idEvaluacion
WHERE 1 = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto" ];
		return $this->db->query($sql)->result_array();
	}

	public function listEncuesta( $input = [] ){
		$filtro = "";
			if( !empty($input['idEncuesta']) ){
				if( !is_array($input['idEncuesta']) ) $input['idEncuesta'] = [$input['idEncuesta']];
				$filtro .= " AND en.idEncuesta IN (".implode(',', $input['idEncuesta']).")";
			}

		$sql = "
SELECT
	en.idEncuesta,
	en.nombre AS encuesta,
	en.cliente,
	enp.idPregunta,
	enp.idTipoPregunta AS idTipo,
	enp.nombre AS pregunta,
	enp.idExtAudTipo,
	enp.extAudPresencia,
	enp.extAudDetalle,
	enpa.idAlternativa,
	enpa.nombre AS alternativa
FROM lsck.tipoEncuesta en
JOIN lsck.tipoEncuestaPreg enp ON en.idEncuesta = enp.idEncuesta
LEFT JOIN lsck.tipoEncuestaPregAlt enpa ON enp.idPregunta = enpa.idPregunta AND enpa.estado = 1
WHERE en.estado = 1 AND enp.estado = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto" ];
		return $this->db->query($sql)->result_array();
	}

	public function listEncuestaTienda( $input = [] ){
		$filtro = "";
			if( !empty($input['idEncuesta']) ){
				if( !is_array($input['idEncuesta']) ) $input['idEncuesta'] = [$input['idEncuesta']];
				$filtro .= " AND en.idEncuesta IN (".implode(',', $input['idEncuesta']).")";
			}

		$sql = "
SELECT
	en.idEncuesta,
	en.nombre AS encuesta,
	enp.idPregunta,
	enp.idTipoPregunta AS idTipo,
	enp.nombre AS pregunta,
	enp.idExtAudTipo,
	enp.extAudPresencia,
	enp.extAudDetalle,
	enpa.idAlternativa,
	enpa.nombre AS alternativa
FROM lsck.tipoEncuesta en
JOIN lsck.tipoEncuestaPreg enp ON en.idEncuesta = enp.idEncuesta
LEFT JOIN lsck.tipoEncuestaPregAlt enpa ON enp.idPregunta = enpa.idPregunta AND enpa.estado = 1
WHERE en.estado = 1 AND enp.estado = 1 AND en.cliente = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'lsck.tipoEncuesta' ];
		return $this->db->query($sql)->result_array();
	}

	public function listResponsable( $input = [] ){
		$sql = "
DECLARE
	@fecha DATE = GETDATE();

SELECT
	rspt.idTipo,
	rspt.nombre AS tipo,
	rsp.idResponsable,
	rsp.nombres,
	rsp.apellidos,
	rsp.email
FROM lsck.responsable rsp
JOIN lsck.responsableTipo rspt ON rsp.idTipo = rspt.idTipo
WHERE rsp.estado = 1
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'lsck.responsable' ];
		return $this->db->query($sql)->result_array();
	}

	public function listIndicador( $input = [] ){
		$sql = "
SELECT
	i.idIndicador,
	i.nombre AS indicador,
	ti.idTipoIndicador,
	ti.nombre AS tipoIndicador,
	i.idTipoCalculo,
	i.array,
	i.id_01,
	i.id_02,
	ip.idIndicadorPunt,
	ip.operador,
	ip.valor_01,
	ip.valor_02,
	ip.punto
FROM lsck.indicador i
JOIN lsck.indicadorPuntaje ip ON i.idIndicador = ip.idIndicador
JOIN lsck.tipoIndicador ti ON i.idTipoIndicador = ti.idTipoIndicador
WHERE i.estado = 1 AND ip.estado = 1
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'lsck.indicador' ];
		return $this->db->query($sql)->result_array();
	}

	public function listPerfectOms(){
		$sql = "SELECT idPerfectOms, nombre, condicion FROM lsck.perfectOms WHERE estado = 1";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'lsck.perfectOms' ];
		return $this->db->query($sql)->result_array();
	}

	public function listOrdenTrabajo( $input = [] ){
		$filtro = "";
			$filtro .= !empty($input['idCliente']) ? " AND c.idCliente = {$input['idCliente']}" : "";
			$filtro .= !empty($input['idAudCliente']) ? " AND ac.idAudCliente = {$input['idAudCliente']}" : "";
			if( !empty($input['idAudClienteEvalPreg']) ){
				if( !is_array($input['idAudClienteEvalPreg']) ){
					$input['idAudClienteEvalPreg'] = [ $input['idAudClienteEvalPreg'] ];
				}

				$filtro .= " AND acevp.idAudClienteEvalPreg IN (".implode(',', $input['idAudClienteEvalPreg']).")";
			}

		$sql = "
SELECT
	acevp.idAudClienteEvalPreg,
	c.idCliente,
	c.razonSocial AS cliente,
	apz.fecha,
	preg.nombre AS pregunta,
	acevp.ordenTrabajo,
	acevp.ordenTrabajoEstado as status,
	CONVERT(VARCHAR, acevp.fecRespuesta, 103) AS fecRespuesta,
	acevp.observacion
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
JOIN lsck.tipoEncuestaPreg preg ON acevp.idPregunta = preg.idPregunta
WHERE LEN(ISNULL(acevp.ordenTrabajo, '')) > 0{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg" ];
		return $this->db->query($sql)->result_array();
	}

	public function listOrdenTrabajoResp( $input = [] ){
		$filtro = "";
			$filtro .= !empty($input['idCliente']) ? " AND c.idCliente = {$input['idCliente']}" : "";
			$filtro .= !empty($input['idAudCliente']) ? " AND ac.idAudCliente = {$input['idAudCliente']}" : "";
			if( !empty($input['idAudClienteEvalPreg']) ){
				if( !is_array($input['idAudClienteEvalPreg']) ){
					$input['idAudClienteEvalPreg'] = [ $input['idAudClienteEvalPreg'] ];
				}

				$filtro .= " AND acevp.idAudClienteEvalPreg IN (".implode(',', $input['idAudClienteEvalPreg']).")";
			}

		$sql = "
SELECT
	acevp.idAudClienteEvalPreg,
	rsp.idResponsable,
	rsp.nombres + ISNULL(' ' + rsp.apellidos, '') AS responsable,
	rsp.email
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp acevpr ON acevp.idAudClienteEvalPreg = acevpr.idAudClienteEvalPreg
JOIN lsck.responsable rsp ON acevpr.idResponsable = rsp.idResponsable
WHERE LEN(ISNULL(acevp.ordenTrabajo, '')) > 0{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp" ];
		return $this->db->query($sql)->result_array();
	}

	public function listOrdenTrabajoNotif( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudClienteEvalPreg']) ){
				if( !is_array($input['idAudClienteEvalPreg']) ){
					$input['idAudClienteEvalPreg'] = array( $input['idAudClienteEvalPreg'] );
				}

				$filtro .= " AND acevp.idAudClienteEvalPreg IN (".implode(',', $input['idAudClienteEvalPreg']).")";
			}

		$sql = "
SELECT
	acevp.idAudClienteEvalPreg,
	pz.idPlaza,
	pz.descripcion AS plaza,
	c.idCliente,
	c.razonSocial AS cliente,
	apz.fecha,
	preg.nombre AS pregunta,
	acevp.ordenTrabajo,
	acevp.ordenTrabajoEstado as status,
	CONVERT(VARCHAR, acevp.fecRespuesta, 103) AS fecRespuesta,
	acevp.observacion,
	rsp.idResponsable,
	rsp.nombres + ISNULL(' ' + rsp.apellidos, '') AS responsable,
	rsp.email
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
JOIN lsck.tipoEncuestaPreg preg ON acevp.idPregunta = preg.idPregunta
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp acevpr ON acevp.idAudClienteEvalPreg = acevpr.idAudClienteEvalPreg
JOIN lsck.responsable rsp ON acevpr.idResponsable = rsp.idResponsable
WHERE LEN(ISNULL(acevp.ordenTrabajo, '')) > 0{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp" ];
		return $this->db->query($sql)->result_array();
	}

	public function getPlazaAuditoria( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				if( !is_array($input['idAudPlaza']) )
					$input['idAudPlaza'] = [ $input['idAudPlaza'] ];

				$filtro .= " AND apz.idAudPlaza IN (".implode(',', $input['idAudPlaza']).")";
			}

		$sql = "
SELECT
	apz.idAudPlaza,
	pz.idPlaza,
	ds.nombre + ' - ' + ubi_dsc.distrito AS distribuidora,
	UPPER(pz.descripcion) AS plaza,
	ubi_pz.distrito AS distrito,
	CONVERT(VARCHAR, apz.fecha, 103) AS fecha,
	prf.idPerfectOms,
	prf.nombre AS perfectOms,
	aca.pregTotal,
	aca.pregAprobadas,
	aca.pregNota,
	aca.perfNota,
	aca.perfPorcentaje
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN pg.auditoria.plazaCliente pz ON apz.idPlaza = pz.idPlaza
JOIN pg.dbo.distribuidoraSucursal dsc ON pz.idDistribuidoraSucursal = dsc.idDistribuidoraSucursal
JOIN pg.dbo.distribuidora ds ON dsc.idDistribuidora = ds.idDistribuidora
JOIN General.dbo.ubigeo ubi_dsc ON dsc.cod_ubigeo = ubi_dsc.cod_ubigeo
LEFT JOIN General.dbo.ubigeo ubi_pz ON pz.cod_ubigeo = ubi_pz.cod_ubigeo
JOIN {$this->sessBDCuenta}.lsck.auditoriaCalculo aca ON apz.idAudCalculo = aca.idAudCalculo
JOIN lsck.perfectOms prf ON aca.idPerfectOms = prf.idPerfectOms
WHERE apz.estado = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlaza" ];
		return $this->db->query($sql)->result_array();
	}

	public function getPlazaCalculo( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				$filtro .= " AND apz.idAudPlaza = {$input['idAudPlaza']}";
			}

		$sql = "
SELECT
	acapz.idIndicador,
	acapz.punto
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCalculo aca ON apz.idAudCalculo = aca.idAudCalculo
JOIN {$this->sessBDCuenta}.lsck.auditoriaCalculoPlaza acapz ON aca.idAudCalculo = acapz.idAudCalculo
WHERE 1 = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCalculo" ];
		return $this->db->query($sql)->result_array();
	}

	public function getPlazaEval( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				$filtro .= " AND apz.idAudPlaza = {$input['idAudPlaza']}";
			}

		$sql = "
SELECT
	ev.idEvaluacion,
	ev.nombre AS evaluacion,
	evd.idEvaluacionDet,
	evd.nombre AS evaluacionDet,
	ep.idPregunta,
	ep.nombre AS pregunta,
	apzep.respuesta,
	epa.idAlternativa,
	epa.nombre AS alternativa
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaPlazaEval apze ON apz.idAudPlaza = apze.idAudPlaza
JOIN lsck.tipoEvaluacionDet evd ON apze.idEvaluacionDet = evd.idEvaluacionDet
JOIN lsck.tipoEvaluacion ev ON evd.idEvaluacion = ev.idEvaluacion
JOIN {$this->sessBDCuenta}.lsck.auditoriaPlazaEvalPreg apzep ON apze.idAudPlazaEval = apzep.idAudPlazaEval
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaPlazaEvalPregAlt apzepa ON apzep.idAudPlazaEvalPreg = apzepa.idAudPlazaEvalPreg
JOIN lsck.tipoEncuestaPreg ep ON apzep.idPregunta = ep.idPregunta
LEFT JOIN lsck.tipoEncuestaPregAlt epa ON apzepa.idAlternativa = epa.idAlternativa
WHERE 1 = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlazaEval" ];
		return $this->db->query($sql)->result_array();
	}

	public function getPlazaFoto( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ) $filtro .= " AND af.idAudPlaza = {$input['idAudPlaza']}";
			if( isset($input['estado']) && strlen($input['estado']) > 0 ) $filtro .= " AND af.estado = {$input['estado']} ";

		$sql = "SELECT idAudFoto, idEvaluacion FROM {$this->sessBDCuenta}.lsck.auditoriaFoto af WHERE 1 = 1{$filtro}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto" ];
		return $this->db->query($sql)->result_array();
	}

	public function getTiendaAuditoria( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				if( !is_array($input['idAudPlaza']) )
					$input['idAudPlaza'] = [ $input['idAudPlaza'] ];

				$filtro .= " AND apz.idAudPlaza IN (".implode(',', $input['idAudPlaza']).")";
			}

		$sql = "
SELECT
	c.idCliente,
	c.razonSocial AS cliente,
	UPPER(tc.nombre) AS tipoCliente
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN pg.dbo.cliente c ON ac.idCliente = c.idCliente
JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON c.idCliente = cc.idCliente
	AND apz.fecha BETWEEN cc.fecIni AND ISNULL(fecFin, apz.fecha)
JOIN lsck.tipoCliente tc ON cc.idTipoCliente = tc.idTipoCliente
WHERE ac.estado = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCLiente" ];
		return $this->db->query($sql)->result_array();
	}

	public function getTiendaAuditoriaEncuesta( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				if( !is_array($input['idAudPlaza']) )
					$input['idAudPlaza'] = [ $input['idAudPlaza'] ];

				$filtro .= " AND apz.idAudPlaza IN (".implode(',', $input['idAudPlaza']).")";
			}

		$sql = "
SELECT
	ac.idCliente,
	e.idEncuesta,
	e.nombre AS encuesta,
	ep.idPregunta,
	ep.nombre AS pregunta,
	acp.respuesta,
	epa.idAlternativa,
	epa.nombre AS alternativa
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN {$this->sessBDCuenta}.lsck.auditoriaClientePreg acp ON ac.idAudCliente = acp.idAudCliente
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClientePregAlt acpa ON acp.idAudClientePreg = acpa.idAudClientePreg
LEFT JOIN lsck.tipoEncuestaPregAlt epa ON acpa.idAlternativa = epa.idAlternativa
JOIN lsck.tipoEncuestaPreg ep ON acp.idPregunta = ep.idPregunta
JOIN lsck.tipoEncuesta e ON ep.idEncuesta = e.idEncuesta
WHERE ac.estado = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClientePreg" ];
		return $this->db->query($sql)->result_array();
	}

	public function getTiendaAuditoriaEvaluacion( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				if( !is_array($input['idAudPlaza']) )
					$input['idAudPlaza'] = [ $input['idAudPlaza'] ];

				$filtro .= " AND apz.idAudPlaza IN (".implode(',', $input['idAudPlaza']).")";
			}

		$sql = "
SELECT
	ac.idCliente,
	ev.idEvaluacion,
	ev.nombre AS evaluacion,
	evd.idEvaluacionDet,
	evd.nombre AS evaluacionDet,
	ep.idPregunta,
	ep.nombre AS pregunta,
	ep.idTipoPregunta,
	ep.idExtAudTipo,
	res.idResponsable,
	res.nombres + ISNULL(' ' + res.apellidos, '') AS responsable,
	acevp.ordenTrabajo,
	CASE
		WHEN acevp.ordenTrabajoEstado IS NULL THEN ''
		WHEN acevp.ordenTrabajoEstado = 0 THEN 'NO'
		WHEN acevp.ordenTrabajoEstado = 1 THEN 'SI'
	END AS 'ordenTrabajoEstado',
	acevp.observacion AS ordenTrabajoObs,
	acevp.respuesta,
	epa.idAlternativa AS idItem,
	epa.nombre AS item,
	CASE WHEN acevpa.idAlternativa IS NOT NULL
		THEN 1 ELSE 0 END marcados
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
LEFT JOIN lsck.tipoEncuestaPregAlt epa ON acevp.idPregunta = epa.idPregunta
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt acevpa ON acevp.idAudClienteEvalPreg = acevpa.idAudClienteEvalPreg AND epa.idAlternativa = acevpa.idAlternativa
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp acevpr ON acevp.idAudClienteEvalPreg = acevpr.idAudClienteEvalPreg
LEFT JOIN lsck.responsable res ON acevpr.idResponsable = res.idResponsable
JOIN lsck.tipoEncuestaPreg ep ON acevp.idPregunta = ep.idPregunta
JOIN lsck.tipoEvaluacionDet evd ON acev.idEvaluacionDet = evd.idEvaluacionDet
JOIN lsck.tipoEvaluacion ev ON evd.idEvaluacion = ev.idEvaluacion
WHERE ac.estado = 1 AND ep.idExtAudTipo IS NULL{$filtro}

UNION

SELECT
	ac.idCliente,
	ev.idEvaluacion,
	ev.nombre AS evaluacion,
	evd.idEvaluacionDet,
	evd.nombre AS evaluacionDet,
	ep.idPregunta,
	ep.nombre AS pregunta,
	ep.idTipoPregunta,
	ep.idExtAudTipo,
	res.idResponsable,
	res.nombres + ISNULL(' ' + res.apellidos, '') AS responsable,
	acevp.ordenTrabajo,
	CASE
		WHEN acevp.ordenTrabajoEstado IS NULL THEN ''
		WHEN acevp.ordenTrabajoEstado = 0 THEN 'NO'
		WHEN acevp.ordenTrabajoEstado = 1 THEN 'SI'
	END AS 'ordenTrabajoEstado',
	acevp.observacion AS ordenTrabajoObs,
	acevp.respuesta,
	eam.idExtAudMat AS idItem,
	eam.nombre AS item,
	CASE WHEN acevpa.idExtAudMat IS NOT NULL
		THEN 1 ELSE 0 END marcados
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON apz.idAudPlaza = ac.idAudPlaza
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEval acev ON ac.idAudCliente = acev.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg acevp ON acev.idAudClienteEval = acevp.idAudClienteEval
JOIN lsck.tipoEncuestaPreg ep ON acevp.idPregunta = ep.idPregunta
JOIN {$this->sessBDCuenta}.lsck.conf_cliente cc ON ac.idCliente = cc.idCliente AND apz.fecha BETWEEN cc.fecIni AND ISNULL(cc.fecFin, apz.fecha)
JOIN {$this->sessBDCuenta}.lsck.conf_clienteAud cca ON cc.idConfCliente = cca.idConfCliente AND ep.idExtAudTipo = cca.idExtAudTipo
JOIN {$this->sessBDCuenta}.lsck.conf_clienteAudDet ccad ON cca.idConfClienteAud = ccad.idConfClienteAud AND ep.extAudPresencia = ccad.presencia
JOIN lsck.ext_auditoriaMaterial eam ON ccad.idExtAudMat = eam.idExtAudMat
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt acevpa ON acevp.idAudClienteEvalPreg = acevpa.idAudClienteEvalPreg AND eam.idExtAudMat = acevpa.idExtAudMat
LEFT JOIN {$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp acevpr ON acevp.idAudClienteEvalPreg = acevpr.idAudClienteEvalPreg
LEFT JOIN lsck.responsable res ON acevpr.idResponsable = res.idResponsable
JOIN lsck.tipoEvaluacionDet evd ON acev.idEvaluacionDet = evd.idEvaluacionDet
JOIN lsck.tipoEvaluacion ev ON evd.idEvaluacion = ev.idEvaluacion
WHERE ac.estado = 1 AND ep.idExtAudTipo IS NOT NULL{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEval" ];
		return $this->db->query($sql)->result_array();
	}

	public function getTiendaFoto( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ) $filtro .= " AND apz.idAudPlaza = {$input['idAudPlaza']}";
			if( isset($input['estado']) && strlen($input['estado']) > 0 ) $filtro .= " AND af.estado = {$input['estado']} ";

		$sql = "
SELECT
	af.idAudFoto,
	af.idEvaluacion,
	ac.idCliente
FROM {$this->sessBDCuenta}.lsck.auditoriaFoto af
JOIN {$this->sessBDCuenta}.lsck.auditoriaCLiente ac ON af.idAudCliente = ac.idAudCliente
JOIN {$this->sessBDCuenta}.lsck.auditoriaPlaza apz ON ac.idAudPlaza = apz.idAudPlaza
WHERE 1 = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto" ];
		return $this->db->query($sql)->result_array();
	}

	public function getTiendaCalculo( $input = [] ){
		$filtro = "";
			if( !empty($input['idAudPlaza']) ){
				$filtro .= " AND apz.idAudPlaza = {$input['idAudPlaza']}";
			}

		$sql = "
SELECT
	acac.idCliente,
	acac.idIndicador,
	acac.punto
FROM {$this->sessBDCuenta}.lsck.auditoriaPlaza apz
JOIN {$this->sessBDCuenta}.lsck.auditoriaCalculo aca ON apz.idAudCalculo = aca.idAudCalculo
JOIN {$this->sessBDCuenta}.lsck.auditoriaCalculoCliente acac ON aca.idAudCalculo = acac.idAudCalculo
WHERE 1 = 1{$filtro}
";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCalculoCliente" ];
		return $this->db->query($sql)->result_array();
	}

	public function calculo( $input = [] ){
		$aSessTrack = [];
		$idAudCalculo = 0;

			$this->db->trans_begin();

				$aCalculo = [
						'idUsuario' => $this->idUsuario,
						'idPlaza' => $input['idPlaza'],
						'idPerfectOms' => empty($input['puntaje']['idPerfectOms']) ? null : $input['puntaje']['idPerfectOms'],
						'pregTotal' => $input['pregunta']['total'],
						'pregAprobadas' => $input['pregunta']['aprobadas'],
						'pregNota' => $input['pregunta']['nota'],
						'perfTotal' => $input['puntaje']['total'],
						'perfNota' => $input['puntaje']['nota'],
						'perfPorcentaje' => $input['puntaje']['porcentaje'],
						'fechaReg' => date('d/m/Y'),
						'horaReg' => date('H:i:s')
					];
				$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaCalculo", $aCalculo);
				$idAudCalculo = $this->db->insert_id();

				$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCalculo", 'id' => $idAudCalculo ];

				foreach($input['tipoIndicador'] as $idTipoIndicador => $vtind){
					if( empty($input['puntaje'][1]) )
						continue;

					if( $idTipoIndicador == 1 ){
						unset($idIndicador, $punto);
						foreach($input['puntaje'][1] as $idIndicador => $punto){
							$aCalculoPlaza = [
									'idAudCalculo' => $idAudCalculo,
									'idIndicador' => $idIndicador,
									'punto' => $punto
								];

							$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaCalculoPlaza", $aCalculoPlaza);
							$idAudCalculoPlaza = $this->db->insert_id();
							$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCalculoPlaza", 'id' => $idAudCalculoPlaza ];
						}
					}
					elseif( $idTipoIndicador == 2 ){
						unset($idIndicador, $vind, $idCliente, $punto);
						foreach($input['puntaje'][2] as $idIndicador => $vind){
							foreach($vind as $idCliente => $punto){
								$aCalculoCliente = [
										'idAudCalculo' => $idAudCalculo,
										'idCliente' => $idCliente,
										'idIndicador' => $idIndicador,
										'punto' => $punto
									];

								$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaCalculoCliente", $aCalculoCliente);
								$idAudCalculoCliente = $this->db->insert_id();
								$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCalculoCliente", 'id' => $idAudCalculoCliente ];
							}
						}
					}
				}

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();

				$this->aSessTrack = [];
				$idAudCalculo = 0;
			}
			else{
				$this->db->trans_commit();
			}

		return $idAudCalculo;
	}

	public function guardar( $input = [] ){
		$status = false;

			$this->db->trans_begin();
				$error = false;

				$adjuntos = [];
				$notificar = [];

				$idPlaza = $input['idPlaza'];

				/* AUDITORIA PLAZA*/
				$iAudPlaza = [
						'fecha' => $input['fecha'],
						'idCuenta' => $input['idCuenta'],
						'idProyecto' => $input['idProyecto'],
						'idAudCalculo' => $input['idCalculo'],
						'idPlaza' => $idPlaza,
						'idUsuario' => $input['idUsuario'],
						'idUsuarioReg' => $this->idUsuario
					];
				$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaPlaza", $iAudPlaza);
				$idAudPlaza = $this->db->insert_id();
				$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlaza", 'id' => $idAudPlaza ];

				/* AUDITORIA PLAZA EVALUACION*/
				if( isset($input["plaza-evaluacion[{$idPlaza}]"]) ){
					if( !is_array($input["plaza-evaluacion[{$idPlaza}]"]) )
						$input["plaza-evaluacion[{$idPlaza}]"] = [ $input["plaza-evaluacion[{$idPlaza}]"] ];

					foreach($input["plaza-evaluacion[{$idPlaza}]"] as $idEvaluacion){
						/* CAPTURAS */
						if( isset($input["plaza-img[{$idPlaza}][{$idEvaluacion}]"]) ){
							if( !is_array($input["plaza-img[{$idPlaza}][{$idEvaluacion}]"]) ){
								$input["plaza-img[{$idPlaza}][{$idEvaluacion}]"] = [ $input["plaza-img[{$idPlaza}][{$idEvaluacion}]"] ];
							}

							foreach($input["plaza-img[{$idPlaza}][{$idEvaluacion}]"] as $capturas){
								$iAuditoriaFoto = [
										'idAudPlaza' => $idAudPlaza,
										'idEvaluacion' => $idEvaluacion
									];
								$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaFoto", $iAuditoriaFoto);
								$idAudFoto = $this->db->insert_id();
								$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto", 'id' => $idAudFoto ];

								$carpeta = $this->carpeta['raiz'].$this->carpeta['livestorecheck'];
								$archivo = $carpeta."{$idAudFoto}.png";

								if( !saveBase64Png($capturas, $archivo) ){
									$error = true;
									goto responder;
								}

								array_push($adjuntos, $archivo);
							}
						}

						if( isset($input["plaza-evaluacionDet[{$idPlaza}][{$idEvaluacion}]"]) ){
							if( !is_array($input["plaza-evaluacionDet[{$idPlaza}][{$idEvaluacion}]"]) )
								$input["plaza-evaluacionDet[{$idPlaza}][{$idEvaluacion}]"] = [ $input["plaza-evaluacionDet[{$idPlaza}][{$idEvaluacion}]"] ];

							foreach($input["plaza-evaluacionDet[{$idPlaza}][{$idEvaluacion}]"] as $idEvaluacionDet){
								$comentario = null;
								if( isset($input["plaza-comentario[{$idPlaza}][{$idEvaluacionDet}]"]) &&
									strlen($input["plaza-comentario[{$idPlaza}][{$idEvaluacionDet}]"]) > 0
								){
									$comentario = $input["plaza-comentario[{$idPlaza}][{$idEvaluacionDet}]"];
								}

								$iAudPlazaEval = array(
										'idAudPlaza' => $idAudPlaza,
										'idEvaluacionDet' => $idEvaluacionDet,
										'comentario' => $comentario
									);
								$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaPlazaEval", $iAudPlazaEval);
								$idAudPlazaEval = $this->db->insert_id();
								$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlazaEval", 'id' => $idAudPlazaEval ];

								if( !is_array($input["plaza-pregunta[{$idPlaza}][{$idEvaluacionDet}]"]) )
									$input["plaza-pregunta[{$idPlaza}][{$idEvaluacionDet}]"] = [ $input["plaza-pregunta[{$idPlaza}][{$idEvaluacionDet}]"] ];

								foreach($input["plaza-pregunta[{$idPlaza}][{$idEvaluacionDet}]"] as $idPregunta){
									/* RESPUESTA */
									$respuesta = null;
									if( isset($input["plaza-respuesta[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"]) &&
										!empty($input["plaza-respuesta[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"])
									){
										$respuesta = $input["plaza-respuesta[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"];
									}

									$iAudPlazaEvalPreg = [
											'idAudPlazaEval' => $idAudPlazaEval,
											'idPregunta' => $idPregunta,
											'respuesta' => $respuesta
										];
									$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaPlazaEvalPreg", $iAudPlazaEvalPreg);
									$idAudPlazaEvalPreg = $this->db->insert_id();
									$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlazaEvalPreg", 'id' => $idAudPlazaEvalPreg ];

									/* ALTERNATIVAS */
									if( isset($input["plaza-alternativa[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
										if( !is_array($input["plaza-alternativa[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
											$input["plaza-alternativa[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"] = [ $input["plaza-alternativa[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"] ];
										}

										foreach($input["plaza-alternativa[{$idPlaza}][{$idEvaluacionDet}][{$idPregunta}]"] as $idAlternativa){
											$iAudPlazaEvalPregAlt = array(
													'idAudPlazaEvalPreg' => $idAudPlazaEvalPreg,
													'idAlternativa' => $idAlternativa
												);
											$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaPlazaEvalPregAlt", $iAudPlazaEvalPregAlt);
											$idAudPlazaEvalPregAlt = $this->db->insert_id();
											$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaPlazaEvalPregAlt", 'id' => $idAudPlazaEvalPregAlt ];
										}
									}
								}
							}
						}
					}
				}

				if( !empty($input['tienda']) ){
					if( !is_array($input['tienda']) )
						$input['tienda'] = [ $input['tienda'] ];

					foreach($input['tienda'] as $idCliente){
						$cliente = $input["tienda-nombre[{$idCliente}]"];

						/* AUDITORIA TIENDA*/
						$iAudCliente = [
								'idAudPlaza' => $idAudPlaza,
								'idCliente' => $idCliente
							];
						$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaCLiente", $iAudCliente);
						$idAudCliente = $this->db->insert_id();
						$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaCLiente", 'id' => $idAudCliente ];

						/* ENCUESTA TIENDA */
						if( isset($input["tienda-pregunta[{$idCliente}]"]) ){
							if( !is_array($input["tienda-pregunta[{$idCliente}]"]) )
								$input["tienda-pregunta[{$idCliente}]"] = [ $input["tienda-pregunta[{$idCliente}]"] ];

							foreach($input["tienda-pregunta[{$idCliente}]"] as $idPregunta){
								/* RESPUESTA */
								$respuesta = null;
								if( isset($input["tienda-respuesta[{$idCliente}][{$idPregunta}]"]) &&
									!empty($input["tienda-respuesta[{$idCliente}][{$idPregunta}]"])
								){
									$respuesta = $input["tienda-respuesta[{$idCliente}][{$idPregunta}]"];
								}

								/* COMENTARIO */
								$comentario = null;
								if( isset($input["tienda-obs[{$idCliente}][{$idPregunta}]"]) &&
									!empty($input["tienda-obs[{$idCliente}][{$idPregunta}]"])
								){
									$comentario = $input["tienda-obs[{$idCliente}][{$idPregunta}]"];
								}

								$iAudClientePreg = [
										'idAudCliente' => $idAudCliente,
										'idPregunta' => $idPregunta,
										'respuesta' => $respuesta,
										'comentario' => $comentario
									];
								$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClientePreg", $iAudClientePreg);
								$idAudClientePreg = $this->db->insert_id();
								$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClientePreg", 'id' => $idAudClientePreg ];

								/* ALTERNATIVAS */
								if( isset($input["tienda-alternativa[{$idCliente}][{$idPregunta}]"]) ){
									if( !is_array($input["tienda-alternativa[{$idCliente}][{$idPregunta}]"]) ){
										$input["tienda-alternativa[{$idCliente}][{$idPregunta}]"] = [ $input["tienda-alternativa[{$idCliente}][{$idPregunta}]"] ];
									}

									foreach($input["tienda-alternativa[{$idCliente}][{$idPregunta}]"] as $idAlternativa){
										$iAudClientePregAlt = [
												'idAudClientePreg' => $idAudClientePreg,
												'idAlternativa' => $idAlternativa
											];
										$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClientePregAlt", $iAudClientePregAlt);
										$idAudClientePregAlt = $this->db->insert_id();
										$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClientePregAlt", 'id' => $idAudClientePregAlt ];
									}
								}
							}
						}

						if( isset($input["evaluacion[{$idCliente}]"]) ){
							if( !is_array($input["evaluacion[{$idCliente}]"]) )
								$input["evaluacion[{$idCliente}]"] = [ $input["evaluacion[{$idCliente}]"] ];

							foreach($input["evaluacion[{$idCliente}]"] as $idEvaluacion){

								/* CAPTURAS */
								if( isset($input["img[{$idCliente}][{$idEvaluacion}]"]) ){
									if( !is_array($input["img[{$idCliente}][{$idEvaluacion}]"]) ){
										$input["img[{$idCliente}][{$idEvaluacion}]"] = [ $input["img[{$idCliente}][{$idEvaluacion}]"] ];
									}

									foreach($input["img[{$idCliente}][{$idEvaluacion}]"] as $capturas){
										$iAuditoriaFoto = [
												'idAudCliente' => $idAudCliente,
												'idEvaluacion' => $idEvaluacion
											];
										$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaFoto", $iAuditoriaFoto);
										$idAudFoto = $this->db->insert_id();
										$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto", 'id' => $idAudFoto ];

										$carpeta = $this->carpeta['raiz'].$this->carpeta['livestorecheck'];
										$archivo = $carpeta."{$idAudFoto}.png";

										if( !saveBase64Png($capturas, $archivo) ){
											$error = true;
											goto responder;
										}

										array_push($adjuntos, $archivo);
									}
								}

								/* EVALUACION DET */
								if( isset($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"]) ){
									if( !is_array($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"]) )
										$input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] = [ $input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] ];

									foreach($input["evaluacionDet[{$idCliente}][{$idEvaluacion}]"] as $idEvaluacionDet){
										$comentario = null;
										if( isset($input["comentario[{$idCliente}][$idEvaluacionDet]"]) &&
											strlen($input["comentario[{$idCliente}][$idEvaluacionDet]"]) > 0
										){
											$comentario = $input["comentario[{$idCliente}][$idEvaluacionDet]"];
										}

										$iAudClienteEval = [
												'idAudCliente' => $idAudCliente,
												'idEvaluacionDet' => $idEvaluacionDet,
												'comentario' => $comentario
											];
										$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClienteEval", $iAudClienteEval);
										$idAudClienteEval = $this->db->insert_id();
										$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEval", 'id' => $idAudClienteEval ];

										if( !is_array($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"]) )
											$input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] = [ $input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] ];

										foreach($input["pregunta[{$idCliente}][{$idEvaluacionDet}]"] as $idPregunta){
											/* RESPUESTA */
											$respuesta = null;
											if( isset($input["respuesta[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) &&
												!empty($input["respuesta[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"])
											){
												$respuesta = $input["respuesta[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"];
											}

											/* RESULTADO */
											$resultado = null;
											if( isset($input["resultado[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
												$resultado = $input["resultado[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"];
											}

											/* ORDEN DE TRABAJO */
											$ordenTrabajo = null;
											if( isset($input["ordenTrabajo[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) &&
												!empty($input["ordenTrabajo[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"])
											){
												$ordenTrabajo = $input["ordenTrabajo[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"];
											}

											$iAudClienteEvalPreg = [
													'idAudClienteEval' => $idAudClienteEval,
													'idPregunta' => $idPregunta,
													'respuesta' => $respuesta,
													'resultado' => $resultado,
													'ordenTrabajo' => $ordenTrabajo
												];
											$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg", $iAudClienteEvalPreg);
											$idAudClienteEvalPreg = $this->db->insert_id();
											$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg", 'id' => $idAudClienteEvalPreg ];

											/* RESPONSABLE */
											if( isset($input["responsable[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) &&
												!empty($input["responsable[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"])
											){
												$responsable = $input["responsable[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"];
												if( !is_array($responsable) ){
													$responsable = [ $responsable ];
												}

												foreach($responsable as $v_responsable){
													$idResponsable = null;
													$idResponsableTipo = null;

													$aResponsable = explode('-', $v_responsable);

													$idResponsableTipo = $aResponsable[0];
													$idResponsable = $aResponsable[1];

													$sql = "";
														$sql .= "SELECT email ";
														$sql .= "FROM lsck.responsable ";
														$sql .= "WHERE idResponsable = {$idResponsable}";

													$responsableEmail = $this->db->query($sql)->row()->email;

													$iAudClienteEvalPregResp = array(
															'idAudClienteEvalPreg' => $idAudClienteEvalPreg,
															'idResponsable' => $idResponsable,
															'idResponsableTipo' => $idResponsableTipo
														);
													$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp", $iAudClienteEvalPregResp);
													$idAudClienteEvalPregResp = $this->db->insert_id();
													$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregResp", 'id' => $idAudClienteEvalPregResp ];

													if( !empty($ordenTrabajo) && !empty($responsableEmail) ){
														$pregunta = $this->db->get_where('lsck.tipoEncuestaPreg', array('idPregunta' => $idPregunta))->row()->nombre;

														$notificar[$responsableEmail][$idAudClienteEvalPreg]['idCliente'] = $idCliente;
														$notificar[$responsableEmail][$idAudClienteEvalPreg]['cliente'] = $cliente;
														$notificar[$responsableEmail][$idAudClienteEvalPreg]['pregunta'] = $pregunta;
														$notificar[$responsableEmail][$idAudClienteEvalPreg]['ordenTrabajo'] = $ordenTrabajo;
													}
												}
											}

											/* ALTERNATIVAS */
											if( isset($input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
												if( !is_array($input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
													$input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] = [ $input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] ];
												}

												foreach($input["alternativa[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] as $idAlternativa){
													$iAudClienteEvalPregAlt = array(
															'idAudClienteEvalPreg' => $idAudClienteEvalPreg,
															'idAlternativa' => $idAlternativa
														);
													$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt", $iAudClienteEvalPregAlt);
													$idAudClienteEvalPregAlt = $this->db->insert_id();
													$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt", 'id' => $idAudClienteEvalPregAlt ];
												}
											}

											/* ALTERNATIVAS MATERIALES */
											if( isset($input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
												if( !is_array($input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"]) ){
													$input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] = [ $input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] ];
												}

												foreach($input["extAudMat[{$idCliente}][{$idEvaluacionDet}][{$idPregunta}]"] as $idExtAudMat){
													$iAudClienteEvalPregAlt = array(
															'idAudClienteEvalPreg' => $idAudClienteEvalPreg,
															'idExtAudMat' => $idExtAudMat
														);
													$this->db->insert("{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt", $iAudClienteEvalPregAlt);
													$idAudClienteEvalPregAlt = $this->db->insert_id();
													$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPregAlt", 'id' => $idAudClienteEvalPregAlt ];
												}
											}
										}
									}
								}
							}
						}
					}
				}

			$plaza = $this->db->query("SELECT UPPER(descripcion) AS plaza FROM pg.auditoria.plazaCliente WHERE idPlaza = {$input['idPlaza']}")->row()->plaza;
			foreach($notificar as $correo => $content){
				$item = [];
				$query = $this->listTiendaAltNo([ 'idAudClienteEvalPreg' => array_keys($content) ]);
				foreach($query as $row){
					$item[$row['idAudClienteEvalPreg']][] = $row['item'];
				}

				$emailConf = [
						'to' => $correo,
						'cc' => $this->aCC,
						'asunto' => "LSC - {$plaza}",
						'contenido' => $this->load->view('modulos/LiveStorecheck/orden/notificar', [ 'datos' => $content, 'item' => $item ], true)
					];

				if( email($emailConf) ){
					foreach($content as $idAudClienteEvalPreg => $vcontent){
						$this->db->update("{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg", ['notificacion' => 1], ['idAudClienteEvalPreg' => $idAudClienteEvalPreg]);
						$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg", 'id' => $idAudClienteEvalPreg ];
					}
				}
			}

			responder:
			if( !$this->db->trans_status() || $error ){
				$this->db->trans_rollback();

				$this->aSessTrack = [];
				foreach($adjuntos as $img){
					if( is_file($img) ){
						unlink($img);
					}
				}
			}
			else{
				$this->db->trans_commit();
				$status = true;
			}

		return $status;
	}

	public function guardarFotosEstado( $input = [] ){
		$status = false;
			$this->db->trans_begin();

				if( !empty($input['idAudFoto']) ){
					if( !is_array($input['idAudFoto']) ){
						$input['idAudFoto'] = [ $input['idAudFoto'] ];
					}

					foreach($input['idAudFoto'] as $idAudFoto){
						$estado = 0;
						if( isset($input["foto[{$idAudFoto}]"]) ){
							$estado = 1;
						}

						$uAudFoto = [ 'estado' => $estado ];
						$wAudFoto = [ 'idAudFoto' => $idAudFoto ];
						$this->db->update("{$this->sessBDCuenta}.lsck.auditoriaFoto", $uAudFoto, $wAudFoto);
						$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => "{$this->sessBDCuenta}.lsck.auditoriaFoto", 'id' => $idAudFoto ];
					}
				}

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();
				$this->aSessTrack = [];
			}
			else{
				$this->db->trans_commit();
				$status = true;
			}
		return $status;
	}

	public function guardarOrdenTrabajo( $input = [] ){
		$result = false;

			$this->db->trans_begin();

				$aOrdenTrabajo = array(
						'ordenTrabajoEstado' => $input['estado'],
						'fecRespuesta' => date('Y-m-d'),
						'observacion' => !empty($input['observacion']) ? $input['observacion'] : null
					);

				$wOrdenTrabajo = array( 'idAudClienteEvalPreg' => $input['idAudClienteEvalPreg'] );
				$this->db->update("{$this->sessBDCuenta}.lsck.auditoriaClienteEvalPreg", $aOrdenTrabajo, $wOrdenTrabajo);

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$result = true;
			}

		return $result;
	}

}