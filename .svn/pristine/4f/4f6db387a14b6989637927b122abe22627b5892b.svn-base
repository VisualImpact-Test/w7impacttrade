<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_muro extends MY_Model{

	public function __construct(){
		parent::__construct();
	}

	public function estado( $input = [] ){
		$sql = "SELECT estado_usuario AS estado FROM impactTrade_red.dbo.usuario_configuracion WHERE idUsuario = {$input['idUsuario']}";
		return $this->db->query($sql)->result_array();
	}

	public function usuarios( $input = [] ){
		$filtro = "";
			if( !empty($input['texto']) ){
				$aTexto = explode(' ', $input['texto']);

				$filtro .= " AND ";
					$filtro .= "( nombres + ISNULL(' ' + apePaterno, '') + ISNULL(' ' + apeMaterno, '') LIKE '%{$input['texto']}%'";
						if( count($aTexto) > 1 ){
							$filtro .= " OR ( ";

								$aTextoFiltro = [];
								foreach($aTexto as $k => $v){
									array_push($aTextoFiltro, "nombres + ISNULL(' ' + apePaterno, '') + ISNULL(' ' + apeMaterno, '') LIKE '%{$v}%'");
								}

								$filtro .= implode(' AND ', $aTextoFiltro);
							$filtro .= " )";
						}
					$filtro .= " )";
			}

		$sql = "
SELECT TOP 10
	*
FROM (
	SELECT DISTINCT
		idUsuario AS id,
		UPPER(nombres + ISNULL(' ' + apePaterno, '') + ISNULL(' ' + apeMaterno, '')) AS nombre
	FROM trade.usuario
	WHERE estado = 1{$filtro}
) u
";
		return $this->db->query($sql)->result_array();
	}

	public function lugares( $input = [] ){
		$filtro = "";
			if( !empty($input['texto']) ){
				$aTexto = explode(' ', $input['texto']);

				$filtro .= " AND ";
					$filtro .= "( direccionExt LIKE '%{$input['texto']}%'";
						if( count($aTexto) > 1 ){
							$filtro .= " OR ( ";

								$aTextoFiltro = [];
								foreach($aTexto as $k => $v){
									array_push($aTextoFiltro, "direccionExt LIKE '%{$v}%'");
								}

								$filtro .= implode(' AND ', $aTextoFiltro);
							$filtro .= " )";
						}
					$filtro .= " )";
			}

		$sql = "
SELECT TOP 10
	*
FROM (
	SELECT DISTINCT '' AS id, direccionExt AS nombre
	FROM Impacttrade_red.dbo.publicacion
	WHERE direccionExt IS NOT NULL{$filtro}
) lg
";
		return $this->db->query($sql)->result_array();
	}


	public function usuarioFiltroProyecto($idUsuario)
	{
		$sql = "
			DECLARE @fecha date=getdate();
			select u.idProyecto,p.nombre as 'proyecto',
			c.idCuenta,c.nombre as 'cuenta',
			u.idTipoUsuario,tu.nombre as 'tipoUsuario'
			from 
			trade.usuario_historico u 
			JOIN trade.proyecto p ON p.idProyecto=u.idProyecto
			JOIN trade.cuenta c ON c.idCuenta=p.idCuenta
			JOIN trade.usuario_tipo tu ON tu.idTipoUsuario=u.idTipoUsuario
			where 
			@fecha between u.fecIni and ISNULL(u.fecFin,@fecha) and
			u.estado=1 and u.idUsuario=".$idUsuario;
			return $this->db->query($sql);
	}

	public function usuarioGrupos($idUsuario)
	{
		$sql = "
			DECLARE @fecha date=getdate();
			select DISTINCT u.idProyecto,p.nombre as 'proyecto',
			c.idCuenta,c.nombre as 'cuenta',
			u.idTipoUsuario, g.idGrupo, g.nombre as 'grupo'
			from 
			trade.usuario_historico u 
			JOIN trade.proyecto p ON p.idProyecto=u.idProyecto
			JOIN trade.cuenta c ON c.idCuenta=p.idCuenta
			JOIN Impacttrade_red.dbo.grupo g ON (g.idProyecto=u.idProyecto and g.idCuenta=c.idCuenta) OR (u.idTipoUsuario=4) 
			where 
			@fecha between u.fecIni and ISNULL(u.fecFin,@fecha) and
			u.estado=1 and u.idUsuario=".$idUsuario;
			return $this->db->query($sql);
	}

}
