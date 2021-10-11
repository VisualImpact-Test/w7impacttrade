<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_fotografico extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function query($sql){
		$query = $this->db->query($sql);
		$result = array();
		if ( $query ) {
			$result = $query->result_array();
		}
		return $result;
	}

	public function obtener_visitas($input=array()){
		$filtros = "";

		!empty($input['grupoCanal']) ? $filtros .= " AND gc.idGrupoCanal = {$input['grupoCanal']} ":  '';
		!empty($input['canal']) ? $filtros .= " AND ca.idCanal = {$input['canal']} ":  '';

		$filtros .= !empty($input['tipoUsuario']) ? " AND uh.idTipoUsuario=".$input['tipoUsuario'] : "";
		$filtros .= !empty($input['usuario']) ? " AND uh.idUsuario=".$input['usuario'] : "";

		$filtros .= !empty($input['distribuidoraSucursal']) ? ' AND ds.idDistribuidoraSucursal='.$input['distribuidoraSucursal'] : '';
		$filtros .= !empty($input['distribuidora']) ? ' AND d.idDistribuidora='.$input['distribuidora'] : '';
		$filtros .= !empty($input['zona']) ? ' AND z.idZona='.$input['zona'] : '';
		$filtros .= !empty($input['plaza']) ? ' AND pl.idPlaza='.$input['plaza'] : '';
		$filtros .= !empty($input['cadena']) ? ' AND cad.idCadena='.$input['cadena'] : '';
		$filtros .= !empty($input['banner']) ? ' AND ba.idBanner='.$input['banner'] : '';

		
		$demo = $this->demo;
		$filtro_demo = '';
		if(!$demo){
			$filtro_demo = " AND r.demo = 0";
		}
		$segmentacion = getSegmentacion(['grupoCanal_filtro'=>$input['grupoCanal']]);
		$sql = "
			DECLARE 
				  @fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			SELECT 
				  convert(varchar,r.fecha,103) fecha
				, r.idUsuario
				, r.nombreUsuario
				, r.tipoUsuario
				, v.idCliente
				, c.codCliente
				, c.codDist codPdv
				, v.razonSocial
				, gc.nombre grupoCanal
				, ca.nombre canal
				, sc.nombre subCanal
				, v.idVisita
				, zp.descripcion zonaPeligrosa
				, af.resultado
				{$segmentacion['columnas_bd']}
			FROM 
				trade.data_visita v
				JOIN trade.data_ruta r
					ON r.idRuta = v.idRuta
				JOIN trade.usuario_historico uh On uh.idUsuario=r.idUsuario
					and General.dbo.fn_fechaVigente(uh.fecIni,uh.fecFin,@fecIni,@fecFin)=1
					and uh.idProyecto=r.idProyecto
				JOIN trade.cliente c 
					ON c.idCliente = v.idCliente
				JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = v.idCliente
					AND General.dbo.fn_fechavigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
					AND ch.idProyecto = {$input['idProyecto']}
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				JOIN trade.canal ca
					ON ca.idCanal = v.idCanal
				LEFT JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
				LEFT JOIN trade.subCanal sc
					ON sn.idSubCanal = sc.idSubCanal
				LEFT JOIN trade.zonaPeligrosa zp
					ON zp.idZonaPeligrosa=v.idZonaPeligrosa
				JOIN  trade.auditoriaFotografica af
					ON af.idVisita = v.idVisita
				{$segmentacion['join']}
			WHERE
				r.fecha BETWEEN @fecIni AND @fecFin
				{$filtros}
				{$filtro_demo}
		";
		return $this->query($sql);
	}
	
	public function obtener_visitas_auditar($input = []){
		
		$sql = "
			SELECT
				  convert(varchar,r.fecha,103) fecha
				, r.idUsuario
				, r.nombreUsuario
				, v.idCliente
				, v.razonSocial
				, gc.nombre grupoCanal
				, ca.nombre canal
				, v.idVisita
				, zp.descripcion zonaPeligrosa
				, af.resultado
			FROM 
				trade.data_visita v
				JOIN trade.data_ruta r
					ON r.idRuta = v.idRuta
				JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = v.idCliente
					AND ch.idProyecto= {$this->sessIdProyecto}
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				JOIN trade.canal ca
					ON ca.idCanal = sn.idCanal
				JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
				JOIN trade.segmentacionClienteTradicional sct
					ON sct.idSegClienteTradicional = ch.idSegClienteTradicional
				LEFT JOIN trade.distribuidoraSucursal ds
					ON ds.idDistribuidoraSucursal = sct.idDistribuidoraSucursal
				LEFT JOIN trade.distribuidora d
					ON d.idDistribuidora = ds.idDistribuidora
				LEFT JOIN general.dbo.ubigeo ubd
					ON ubd.cod_ubigeo = ds.cod_ubigeo
				LEFT JOIN trade.plaza pl
					ON pl.idPlaza = sct.idPlaza
				LEFT JOIN general.dbo.ubigeo ubp
					ON ubp.cod_ubigeo = pl.cod_ubigeo
				LEFT JOIN trade.zonaPeligrosa zp
					ON zp.idZonaPeligrosa=v.idZonaPeligrosa
				LEFT JOIN  trade.auditoriaFotografica af
					ON af.idVisita = v.idVisita
			WHERE
				1=1 
				{$input['filtro']} 
				-- AND v.idVisita IN(251570,305829,305629)
		";

		return $this->query($sql);
	}
	
	public function obtener_fotos_visitas($input=array()){
		$filtros = "WHERE 1=1";

		!empty($input['filtro']) ? $filtros .= "{$input['filtro']}": '';
		$sql = "
			DECLARE
				  @fecIni DATE = '".$input['fecIni']."'
				, @fecFin DATE = '".$input['fecFin']."'
			SELECT
				  v.idVisita
				, vf.fotoUrl
				, vf.idModulo
				, am.nombre modulo
			FROM 
				trade.data_visita v
				JOIN trade.data_ruta r
					ON r.idRuta = v.idRuta
				JOIN ".getClienteHistoricoCuenta()." ch
					ON ch.idCliente = v.idCliente
					AND General.dbo.fn_fechavigente(ch.fecIni,ch.fecFin,@fecIni,@fecFin)=1
					AND ch.idProyecto= {$this->sessIdProyecto}
				JOIN trade.segmentacionNegocio sn
					ON sn.idSegNegocio = ch.idSegNegocio
				JOIN trade.canal ca
					ON ca.idCanal = sn.idCanal
				JOIN trade.grupoCanal gc
					ON gc.idGrupoCanal = ca.idGrupoCanal
				JOIN trade.segmentacionClienteTradicional sct
					ON sct.idSegClienteTradicional = ch.idSegClienteTradicional
				LEFT JOIN trade.distribuidoraSucursal ds
					ON ds.idDistribuidoraSucursal = sct.idDistribuidoraSucursal
				LEFT JOIN trade.distribuidora d
					ON d.idDistribuidora = ds.idDistribuidora
				LEFT JOIN general.dbo.ubigeo ubd
					ON ubd.cod_ubigeo = ds.cod_ubigeo
				LEFT JOIN trade.plaza pl
					ON pl.idPlaza = sct.idPlaza
				LEFT JOIN general.dbo.ubigeo ubp
					ON ubp.cod_ubigeo = pl.cod_ubigeo
				LEFT JOIN trade.zonaPeligrosa zp
					ON zp.idZonaPeligrosa=v.idZonaPeligrosa
				LEFT JOIN  trade.auditoriaFotografica af
					ON af.idVisita = v.idVisita
				JOIN trade.data_visitaFotos vf
					ON vf.idVisita = v.idVisita
				JOIN trade.aplicacion_modulo am
					ON am.idModulo = vf.idModulo
			{$filtros}
		";

		return $this->query($sql);
	}
	
	public function obtener_visibilidad($filtro){
		$sql = "
		SELECT
			  evt.idElementoVis
			, evt.nombre
			, vdd.presencia
			, vdd.idVisitaFoto
			, vd.idVisita
			, vdd.pc
			, vdd.pl
			, vdd.idVisitaVisibilidadDet
		FROM 
			trade.data_visitaVisibilidadTrad vd
			JOIN trade.data_visitaVisibilidadTradDet vdd
				ON vdd.idVisitaVisibilidad = vd.idVisitaVisibilidad
			JOIN trade.elementoVisibilidadTrad evt
				ON evt.idElementoVis = vdd.idElementoVis
		WHERE
			1=1
			{$filtro}
		";
		return $this->query($sql);
	}
	
	public function guardarVisitaAuditarCartera($idVisita,$resultado,$elementos,$precios){
		$this->db->trans_begin();
		//
		$cabecera = array(
			'idVisita'=>$idVisita,
			'resultado'=>$resultado,
			'tienePrecios'=>$precios
		);
		$insertAuditoria = $this->db->insert('trade.auditoriaFotografica',$cabecera);
		$idAuditoria = $this->db->insert_id();
		//
		/* foreach ($elementos as $elemento){
			$arrayDatosElemento = explode("-", $elemento);
			$idElemento = $arrayDatosElemento[0];
			$valorPC = $arrayDatosElemento[1];
			$valorPL = $arrayDatosElemento[2];
			$valorResultado = $arrayDatosElemento[3];
			//
			$detalle = array(
				'idAuditoria'=> $idAuditoria,
				'idElemento'=>$idElemento,
				'valorPC'=> $valorPC,
				'valorPL'=>$valorPL,
				'valorResultado'=>$valorResultado
			);
			$this->db->insert('pg.multicanal.auditoriaFotograficaCarteraDetalle',$detalle);
		} */
		//
		if ($this->db->trans_status() === FALSE || !$insertAuditoria)
        {
            $this->db->trans_rollback();
            return 0;
        }
        else
        {
            $this->db->trans_commit();
            return 1;
        }
	}

}
?>