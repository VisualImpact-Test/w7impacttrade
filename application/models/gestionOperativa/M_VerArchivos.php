<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_VerArchivos extends MY_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getFiles($idUsuario, $idFolder){
		$idCuenta = $this->sessIdCuenta;
        $filtros = '';
			if( !empty($idFolder) ) $filtros .= " AND c.idCarpeta = {$idFolder}";
			!empty($idCuenta) ? $filtros .= " AND g.idCuenta = {$idCuenta}": '';
        $sql = "    
		SELECT
			a.idArchivo,
			a.nombre nombreRegistrado,
			a.nombreArchivo,
			a.peso,
			a.extension,
			ta.nombre tipoArchivo,
			a.fechaCreacion,
			a.fechaModificacion,
			a.eliminado,
			a.estado,
            u.idUsuario idUsuarioCreador,
            /* u.correo correoCreador, */
			c.idCarpeta,
			c.nombre nombreCarpeta,
			g.idGrupo,
			CONVERT(VARCHAR(10),a.fechaCreacion,103) fecha,
			CONVERT(VARCHAR(8),CONVERT(time,a.fechaCreacion)) hora,
			g.nombre nombreGrupo,
			u.nombres + ' ' + u.apePaterno nombreUsuarioCreador,
			u2.idUsuario idUsuarioEditor,
			u2.nombres + ' ' + u2.apePaterno nombreUsuarioEditor
			FROM {$this->sessBDCuenta}.trade.gestorArchivos_archivo a
			JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON a.idCarpeta = c.idCarpeta
			JOIN {$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta pc ON pc.idCarpeta = c.idCarpeta
			JOIN {$this->sessBDCuenta}.trade.gestorArchivos_grupo g ON c.idGrupo = g.idGrupo
			JOIN trade.usuario u on a.idUsuarioCreador = u.idUsuario
			JOIN {$this->sessBDCuenta}.trade.gestorArchivos_tipoArchivo ta ON a.idTipoArchivo = ta.idTipoArchivo
			LEFT JOIN trade.usuario u2 on a.idUsuarioEditor = u2.idUsuario
		WHERE
			pc.estado = 1
			AND a.estado = 1
            AND pc.idUsuario = {$idUsuario}
            AND c.estado = 1
			{$filtros}
		ORDER BY g.orden ASC, nombreCarpeta ASC, nombreRegistrado ASC";

        return $this->db->query($sql);
	}
	
	public function getInformacionUsuario($idUsuario){
        $sql = "
		SELECT
            nombres + ' ' + apePaterno + ' ' + apeMaterno nombreCompleto, *
        FROM trade.usuario
        WHERE idUsuario = {$idUsuario}
		";

        return $this->db->query($sql);
    }
}
