<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auditoriabd extends MY_Model{

	public function __construct(){
		parent::__construct();
    }

    public function listaAuditoria( $data = [] ){

        $filtro = "";
        ( !empty($data['fecha']) ) ? $filtro .= " AND (st.fecha BETWEEN '".trim(explode("-",$data['fecha'])[0])."' AND '".trim(explode("-",$data['fecha'])[1])."')" : $filtro .= "";
        ( !empty($data['idAccion']) ) ? $filtro .= " AND st.idAccion = ".$data['idAccion'] : $filtro .= "";
        ( !empty($data['idUsuario']) ) ? $filtro .= " AND st.idUsuario = ".$data['idUsuario'] : $filtro .= "";
        $query = "
SELECT
st.idTracking
,st.idUsuario
,u.usuario
,UPPER(u.nombres)+' '+UPPER(ISNULL(u.apePaterno, ''))+' '+UPPER(ISNULL(u.apeMaterno, '')) AS nombreUsuario
,st.uri
,st.controlador
,st.metodo
,st.idAccion
,sa.nombre AS accion
,st.tabla
,st.id
,st.sessionId
,st.ipAddress
,st.browser
,st.browserVer
,st.browserSess
,st.platform
,CONVERT(varchar, st.fecha, 103) AS fecha
,st.hora
FROM web.sessionTracking st
JOIN web.sessionAccion sa ON st.idAccion = sa.idAccion
JOIN trade.usuario u ON st.idUsuario = u.idUsuario
WHERE 1 = 1{$filtro}
ORDER BY idTracking DESC
        ";
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function obtener_accion(){
      $filtro = "";
      $query = "
SELECT
idAccion
,nombre AS accion
FROM web.sessionAccion
WHERE 1 = 1{$filtro}
        ";
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function obtener_usuarios(){
      $filtro = "";
      $query = "
SELECT
u.idUsuario
,UPPER(u.nombres)+' '+UPPER(ISNULL(u.apePaterno, ''))+' '+UPPER(ISNULL(u.apeMaterno, '')) AS nombreUsuario
FROM trade.usuario u
WHERE 1 = 1{$filtro}
        ";
        $result = $this->db->query($query)->result_array();
        return $result;
    }
}