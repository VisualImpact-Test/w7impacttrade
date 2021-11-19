<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_carga_masiva_general extends CI_Model{
	
	public function obtener_tipo_carga($tipo){
		$sql = "SELECT * FROM trade.TipoCargaMasiva WHERE idTipoCarga=$tipo ";
		return $this->db->query($sql);
	}
	
	public function obtener_tablas($tipo){
		$sql=" SELECT * FROM trade.validarTablasCargaMasiva WHERE validar=1 AND idTipoCarga=$tipo ";
		return $this->db->query($sql);
	}
	
	public function consultar_tabla($tabla,$campos,$valor){
		$sql=" SELECT count(*) total FROM  $tabla WHERE $campos =$valor ";
		return $this->db->query($sql);
	}
	
	public function limpiar_tabla_detalle($tabla,$campos,$valor,$tabla_dependencia,$campo_dependencia){
		$sql=
		" 
			DELETE FROM  $tabla WHERE $campos IN (
				SELECT $campos FROM $tabla_dependencia WHERE $campo_dependencia=$valor
			)
		";
		return $this->db->query($sql);
	}
	
	public function limpiar_tabla($tabla,$campos,$valor,$tabla_dependencia){
		$sql=
		" 
			DELETE FROM  $tabla WHERE $campos=$valor
		";
		return $this->db->query($sql);
	}
	
	public function obtener_tabla_campos($idTipoCarga){
		$sql=" SELECT * FROM trade.tablaCargaMasiva WHERE principal = 1 AND idTipoCarga  = $idTipoCarga ";
		return $this->db->query($sql);
	}
	
	//Base Madre
	
	public function obtener_segmentacion_cliente($idUsuario){
		$sql = "
			SELECT 
				  usc.flagClienteTradicional
				, usc.flagClienteModerno
			FROM 
				trade.usuario_segmentacionCliente usc
			WHERE 
				usc.estado=1 
				AND usc.idUsuario={$idUsuario}
			ORDER BY 
				usc.idUsuarioSegCliente DESC
		";

		return $this->db->query($sql);
	}
	
	
	public function data_carga_base_madre($idUsuario){
		$sql = "
			SELECT 
				idCarga
				,idUsuario
				,idGrupoCanal
				,convert(varchar,fechaCarga,103) fechacarga
				,convert(varchar,fechaCarga,108) horacarga
				,convert(varchar,fechaFinCarga,103) fechaFincarga
				,convert(varchar,fechaFinCarga,108) horaFincarga
				,totalRegistros
				,ISNULL(totalClientes,0) totalClientes
				,ISNULL(totalProcesados,0) totalProcesados
				,estado 
			FROM 
				{$this->sessBDCuenta}.trade.cargaMasivaBaseMadre
			WHERE 
				idUsuario={$idUsuario}
		";

		return $this->db->query($sql);
	}

	public function obtener_carpetas_base_madre(){
		$filtro ='';
		$filtro.= ( isset($cuenta) && !empty($cuenta) )? " AND idCuenta=".$cuenta:'';
		$sql ="SELECT idCarga,idUsuario,estado,carpeta,idGrupoCanal canal,totalRegistros FROM {$this->sessBDCuenta}.trade.cargaMasivaBaseMadre WHERE estado=1";

		return $this->db->query($sql)->result_array();
	}
	
	public function validar_segmentacion_negocio($grupocanal,$canal){
		$sql ="
			SELECT * FROM trade.segmentacionNegocio WHERE idCanal IN (
				SELECT idCanal FROM trade.canal WHERE nombre='".$canal."' AND idGrupoCanal IN (
					SELECT idGrupoCanal FROM trade.grupoCanal WHERE nombre='".$grupocanal."'
				)
			) 
		";
		
		return $this->db->query($sql);
	}
	
	public function validar_segmentacion_moderno($banner){
		$sql ="
			SELECT idSegClienteModerno FROM trade.segmentacionClienteModerno WHERE idBanner IN ( SELECT idBanner FROM trade.banner WHERE nombre='".$banner."'  )
		";
		return $this->db->query($sql);
	}

	public function obtener_idplaza ($plaza){
		$sql = "SELECT idPlaza FROM trade.plaza	WHERE nombre ='".$plaza."'";
		return $this->db->query($sql);
	}
	
	public function obtener_iddistribuidora($distribuidora){
		$sql="
			SELECT
				ds.idDistribuidoraSucursal
			FROM trade.distribuidoraSucursal ds
				JOIN trade.distribuidora d ON d.idDistribuidora=ds.idDistribuidora
				LEFT JOIN General.dbo.ubigeo ubi ON ubi.cod_ubigeo=ds.cod_ubigeo
			WHERE ds.estado=1 AND d.estado=1 AND  d.nombre+' - '+ ubi.distrito ='".$distribuidora."'"
		;
		return $this->db->query($sql);
		
	}
	
	public function insertar_segmentacion_tradicional ($idPlaza){
		if(!empty($idPlaza)){
			$sql="insert into trade.segmentacionClienteTradicional(idPlaza) values ('".$idPlaza."')";
		}else{
			$sql="insert into trade.segmentacionClienteTradicional(estado) values (1)";
		}
		$this->db->query($sql);
		
		return $this->db->insert_id();
	}
	
	public function insertar_segmentacion_tradicional_detalle ($idSegTradicional,$iddistribuidora){
		
		$sql="insert into trade.segmentacionClienteTradicionalDet(idSegClienteTradicional,idDistribuidoraSucursal) values ($idSegTradicional,$iddistribuidora)";
		return $this->db->query($sql);
	}
	
	public function actualizar_procesados($idCarga){
		$update_="UPDATE {$this->sessBDCuenta}.trade.cargaMasivaBaseMadre SET totalProcesados=ISNULL(totalProcesados,0)+1,fechaFinCarga=getdate() WHERE idCarga=$idCarga ";
		$this->db->query($update_);
	}
	
	public function actualizar_clientes($idCarga,$totalRegistros){
		$update_="UPDATE {$this->sessBDCuenta}.trade.cargaMasivaBaseMadre SET totalClientes=$totalRegistros WHERE idCarga=$idCarga ";
		$this->db->query($update_);
	}
	
	public function actualizar_estado_carga($idCarga){
		$update_="UPDATE {$this->sessBDCuenta}.trade.cargaMasivaBaseMadre SET estado=0 WHERE idCarga=$idCarga ";
		$this->db->query($update_);
	} 
	
	public function estado_carga(){
		$update_="SELECT *,convert(varchar,fechaFinCarga,108)horaFin FROM {$this->sessBDCuenta}.trade.cargaMasivaBaseMadre ";
		return $this->db->query($update_);
	} 
	
	
	//VISITAS
	
	public function obtener_carpetas_visitas(){

		$sql ="SELECT idCarga,idTipoUsuario,carpeta FROM {$this->sessBDCuenta}.trade.cargaProgramacionRutas WHERE estado=1";

		return $this->db->query($sql)->result_array();
	}
	
	public function registrar_detalle($tabla,$array){
		$this->db->insert($tabla,$array);
	}
	
	public function validar_cliente($idTipoUsuario,$idCliente,$fecha){
		if($idTipoUsuario==1 || $idTipoUsuario==6){
			$sql="
				DECLARE @fecha DATE ='".$fecha."';
				SELECT 
					*
				FROM
					trade.cliente c
					JOIN {$this->sessBDCuenta}.trade.cliente_historico ch
						ON ch.idCliente=c.idCliente
						AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
						AND ch.idProyecto=3
						AND ch.idCliente=$idCliente
		
			";
		}else if($idTipoUsuario==5){
			$sql="
				DECLARE @fecha DATE ='".$fecha."';
				SELECT 
					*
				FROM
					trade.cliente c
					JOIN {$this->sessBDCuenta}.trade.cliente_historico ch
						ON ch.idCliente=c.idCliente
						AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
						AND ch.idProyecto=13
						AND ch.idCliente=$idCliente
		
			";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function validar_usuario($idTipoUsuario,$idUsuario,$fecha){
		if($idTipoUsuario==1 || $idTipoUsuario==6){
			$sql="
				DECLARE @fecha DATE ='".$fecha."';
				SELECT 
					*
				FROM
					trade.usuario u
					JOIN trade.usuario_historico uh
						ON uh.idUsuario=u.idUsuario
						AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
						AND uh.idTipoUsuario=$idTipoUsuario
						AND uh.idProyecto=3
						AND uh.idUsuario=$idUsuario
			";
		}else if($idTipoUsuario==5){
			$sql="
				DECLARE @fecha DATE ='".$fecha."';
				SELECT 
					*
				FROM
					trade.usuario u
					JOIN trade.usuario_historico uh
						ON uh.idUsuario=u.idUsuario
						AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin,@fecha)
						AND uh.idTipoUsuario=$idTipoUsuario
						AND uh.idProyecto=13
						AND uh.idUsuario=$idUsuario
			";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function validar_visita($idTipoUsuario,$idCliente,$idUsuario,$fecha){
		
		$sql="
			DECLARE @fecha DATE ='".$fecha."';
			SELECT 
				*
			FROM
				{$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v
					ON v.idRuta=r.idRuta
					AND @fecha = r.fecha
					AND r.idUsuario=$idUsuario
					AND v.idCliente=$idCliente
		
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function obtener_ruta($idUsuario,$fecha){
		$sql="
			DECLARE @fecha DATE ='".$fecha."';
			SELECT 
				idRuta
			FROM
				{$this->sessBDCuenta}.trade.data_ruta
			WHERE
				idUsuario=$idUsuario
				AND fecha=@fecha
		";
		return $this->db->query($sql)->row_array();
	}
	
	public function actualizar_estado_carga_visita($idCarga){
		$update_="UPDATE {$this->sessBDCuenta}.trade.cargaProgramacionRutas SET estado=0,finRegistro=getdate() WHERE idCarga=$idCarga ";
		$this->db->query($update_);
	}

	//EXCLUSIONES 
	
	public function obtener_carpetas_exclusiones(){

		$sql ="SELECT idCarga,idTipoUsuario,carpeta FROM {$this->sessBDCuenta}.trade.cargaExclusionesRutas WHERE estado=1";

		return $this->db->query($sql)->result_array();
	}
	
	public function validar_visita_exclusion($idTipoUsuario,$idCliente,$idUsuario,$fecha){
		$sql ="
			SELECT 
				v.idVisita 
			FROM
				{$this->sessBDCuenta}.trade.data_ruta r
				JOIN {$this->sessBDCuenta}.trade.data_visita v
					ON v.idRuta=r.idRuta
			WHERE 
				r.fecha='".$fecha."'
				AND r.idUsuario=".$idUsuario."
				AND v.idCliente=".$idCliente."
		";
		
		return $this->db->query($sql)->row_array();
	}
	
	public function actualizar_estado_carga_exclusion($idCarga){
		$update_="UPDATE {$this->sessBDCuenta}.trade.cargaExclusionesRutas SET estado=0,finRegistro=getdate() WHERE idCarga=$idCarga ";
		$this->db->query($update_);
	}


}
?>