<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_seguridadbd extends MY_Model{

	public function __construct(){
		parent::__construct();
    }

    public function listaIntentos( $data = [] ){

        $filtro = "";
        ( !empty($data['fecha']) ) ? $filtro .= " AND (fa.fecha BETWEEN '".trim(explode("-",$data['fecha'])[0])."' AND '".trim(explode("-",$data['fecha'])[1])."')" : $filtro .= "";
        ( !empty($data['idUsuario']) ) ? $filtro .= " AND fa.idUsuario = ".$data['idUsuario'] : $filtro .= "";
        $query = "
SELECT
fa.idAttempt
,fa.idUsuario
,u.usuario
,UPPER(u.nombres)+' '+UPPER(ISNULL(u.apePaterno, ''))+' '+UPPER(ISNULL(u.apeMaterno, '')) AS nombreUsuario
,fa.ipAddress
,fa.browser
,fa.browserVer
,fa.platform
,CONVERT(varchar, fa.fecha, 103) AS fecha
,fa.hora
,fa.nro_intento
FROM web.sessionFailedAttemps fa
LEFT JOIN trade.usuario u ON fa.idUsuario = u.idUsuario
WHERE 1 = 1
{$filtro}
ORDER BY idAttempt DESC
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