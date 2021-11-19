<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cartera_objetivo extends MY_Model
{

    var $aSessTrack = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_cartera_objetivo($input = array())
    {
        $result = [];
        $filtros = "";

        $filtros .= !empty($input['grupoCanal_filtro']) ? " AND gc.idGrupoCanal = " . $input['grupoCanal_filtro'] : "";
        $filtros .= !empty($input['canal_filtro']) ? " AND ca.idCanal = " . $input['canal_filtro'] : "";
        $filtros .= !empty($input['subcanal_filtro']) ? " AND sca.idSubCanal = " . $input['subcanal_filtro'] : "";
        $filtros .= !empty($input['idObjetivo']) ? " AND co.idObjetivo = " . $input['idObjetivo'] : "";

        if(!empty($input['verificar'])){
            $filtros .= !empty($input['verificar_distribuidoraSucursal']) ? " AND ds.idDistribuidoraSucursal = " . $input['verificar_distribuidoraSucursal'] : " AND ds.idDistribuidoraSucursal IS NULL";
            $filtros .= !empty($input['verificar_plaza']) ? " AND pl.idPlaza = " . $input['verificar_plaza'] : " AND pl.idPlaza IS NULL";
            $fechaFin = empty($input['verificar_fechaFin']) ? "NULL" : "'" . $input['verificar_fechaFin'] . "'";
            $filtros .= !empty($input['verificar_fechaInicio']) ? " AND fn.datesBetween(co.fecIni, co.fecFin, '" . $input['verificar_fechaInicio'] . "', " . $fechaFin . ") = 1 " : " AND fn.datesBetween(co.fecIni, co.fecFin, NULL, NULL) = 1";
            $filtros .= !empty($input['verificar_idObjetivo']) ? " AND co.idObjetivo != " . $input['verificar_idObjetivo'] : "";
        }

        $values = [
            'idCuenta' => verificarEmpty($input['cuenta_filtro'], 2),
            'idProyecto' => verificarEmpty($input['proyecto_filtro'], 2)
        ];

        $sql = "
		SELECT
        co.idObjetivo
        , co.idCuenta
        , c.nombre AS cuenta
        , co.idProyecto
        , p.nombre AS proyecto
        , co.idGrupoCanal
        , gc.nombre AS grupoCanal
        , co.idCanal
        , ca.nombre AS canal
        , co.idSubCanal
        , sca.nombre AS subCanal
        , co.idDistribuidoraSucursal
        , ds.nombre AS distribuidoraSucursal
        , co.idPlaza
        , pl.nombre AS plaza
        , CONVERT(VARCHAR, co.fecIni, 103) AS fecIni
        , CONVERT(VARCHAR, co.fecFin, 103) AS fecFin
        , co.cartera
        , co.estado
        FROM {$this->sessBDCuenta}.trade.cartera_objetivo co
        JOIN trade.cuenta c ON co.idCuenta = c.idCuenta
        JOIN trade.proyecto p ON co.idProyecto = p.idProyecto
        LEFT JOIN trade.grupoCanal gc ON co.idGrupoCanal = gc.idGrupoCanal
        LEFT JOIN trade.canal ca ON co.idCanal = ca.idCanal
        LEFT JOIN trade.subCanal sca ON co.idSubCanal = sca.idSubCanal
        LEFT JOIN trade.distribuidoraSucursal ds ON co.idDistribuidoraSucursal = ds.idDistribuidoraSucursal
        LEFT JOIN trade.plaza pl ON co.idPlaza = pl.idPlaza
		WHERE c.idCuenta = ? AND p.idProyecto = ?{$filtros}
		";

        $result['datos'] = $this->db->query($sql, $values)->result_array();

        return $result;
    }

    public function get_grupoCanal($input = array())
    {
        $idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

        $filtro = "";
        $filtro .= getPermisos('grupoCanal', $idProyecto);

        $sql = "SELECT gca.idGrupoCanal AS id, gca.nombre AS grupoCanal FROM trade.grupoCanal gca WHERE gca.estado = 1{$filtro} ORDER BY gca.nombre";
        return $this->db->query($sql)->result_array();
    }

    public function get_canal($input = array())
    {
        $idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

        $filtro = "";
        $filtro .= getPermisos('canal', $idProyecto);

        $sql = "SELECT ca.idCanal AS id, ca.nombre AS canal, ca.idGrupoCanal FROM trade.canal ca WHERE ca.estado = 1{$filtro} ORDER BY ca.nombre";
        return $this->db->query($sql)->result_array();
    }

    public function get_subCanal($input = array())
    {
        $idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

        $filtro = "";
        $filtro .= getPermisos('subCanal', $idProyecto);

        if (!empty($input['idCanal'])) {
            $filtro .= " AND sca.idCanal = {$input['idCanal']}";
        }
        if (!empty($input['idSubCanal'])) {
            $filtro .= " AND sca.idSubCanal = {$input['idSubCanal']}";
        }

        $sql = "SELECT sca.idSubCanal AS id, sca.nombre AS subCanal FROM trade.subCanal sca WHERE sca.estado = 1{$filtro} ORDER BY sca.nombre";
        return $this->db->query($sql)->result_array();
    }

    public function get_plaza($input = array())
    {
        $idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

        $filtro = "";
        $filtro .= getPermisos('plaza', $idProyecto);

        $sql = "SELECT pl.idPlaza AS id, pl.nombre AS plaza FROM trade.plaza pl WHERE pl.estado = 1 AND pl.flagMayorista = 1{$filtro} ORDER BY pl.nombre";
        return $this->db->query($sql)->result_array();
    }

    public function get_distribuidoraSucursal($input = array())
    {
        $idProyecto = !empty($input['idProyecto']) ? $input['idProyecto'] : 0;

        $filtro = "";
        $filtro .= getPermisos('distribuidora', $idProyecto);

        $sql = "SELECT d.idDistribuidoraSucursal AS id, d.nombre AS distribuidoraSucursal FROM trade.distribuidoraSucursal d WHERE d.estado = 1 AND nombre IS NOT NULL{$filtro} ORDER BY d.nombre";
        return $this->db->query($sql)->result_array();
    }

    public function get_cuenta($input = array())
    {
        $column = "";

        !empty($input['idCuenta']) ? $column = ",'{$input['idCuenta']}' as idSelect " : '';

        $filtro = "";
        $filtro .= getPermisos('cuenta');

        $sql = "
			DECLARE @fecha date=getdate();
			SELECT DISTINCT c.idCuenta AS id,c.nombre AS cuenta
			FROM trade.usuario_historico uh 
			JOIN trade.proyecto p ON p.idProyecto = uh.idProyecto
			JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
			WHERE uh.estado = 1 
			AND @fecha BETWEEN uh.fecIni AND ISNULL(uh.fecFin, @fecha)
			AND uh.idUsuario = " . $this->session->userdata('idUsuario');

        return $this->db->query($sql)->result_array();
    }

    public function get_proyecto($input = array())
    {

        $columna = "";

        !empty($input['idProyecto']) ? $columna = ",'{$input['idProyecto']}' as idSelect " : '';

        $filtro = "";
        $filtro .= getPermisos('proyecto');

        if (!empty($input['idCuenta'])) {
            $filtro .= " AND py.idCuenta = {$input['idCuenta']}";
        }

        $sql = "SELECT py.idProyecto AS id, py.nombre AS proyecto FROM trade.proyecto py WHERE estado = 1{$filtro} ORDER BY py.nombre";
        return $this->db->query($sql)->result_array();
    }

    public function get_canal_grupoCanal($input = [])
    {
        $sql = "
        SELECT
        sc.idSubCanal
        , c.idCanal
        , gc.idGrupoCanal
        FROM trade.subCanal sc
        JOIN trade.canal c ON sc.idCanal = c.idCanal
        JOIN trade.grupoCanal gc ON c.idGrupoCanal = gc.idGrupoCanal
        WHERE sc.idSubCanal = ?
        ";
        return $this->db->query($sql, ['idSubCanal' => $input['idSubCanal']])->row_array();
    }

    public function insertarMasivoCarteraObjetivo($params = [])
    {
        $result = [];

        $result['insert'] = $this->db->insert_batch("{$this->sessBDCuenta}.trade.cartera_objetivo", array_unique($params, SORT_REGULAR));

        return $result;
    }

    public function insertarCargosPremiacion($params = [])
    {
        $result = [];

        $this->db->trans_begin();

        $insert = [
            'idPremiacion' => $params['idPremiacion'],
            'idGrupoCanal' => $params['idCanal'],
            'idPlaza' => (!empty($params['idPlaza']) ? $params['idPlaza'] : NULL),
            'idDistribuidora' => (!empty($params['idDistribuidora']) ? $params['idDistribuidora'] : NULL),
            'foto' => $params['foto']
        ];
        $query = $this->db->insert("{$this->sessBDCuenta}.trade.data_visitaPremiacionCargo", $insert);
        $result['id'] = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE || !$query) {
            $this->db->trans_rollback();
            $result['status'] = 0;
        } else {
            $this->db->trans_commit();
            $result['status'] = 1;
        }

        return $result;
    }

    public function actualizarCarteraObjetivo($params = [])
    {
        $result = [];

        $this->db->trans_begin();

        $update = [
            'idCuenta' => $params['sel-cartera-cuenta'],
            'idProyecto' => $params['sel-cartera-proyecto'],
            'idGrupoCanal' => $params['idGrupoCanal'],
            'idCanal' => $params['idCanal'],
            'idSubCanal' => $params['sel-cartera-sub-canal'],
            'idDistribuidoraSucursal' => verificarEmpty($params['sel-cartera-rd'], 4),
            'idPlaza' => verificarEmpty($params['sel-cartera-plaza'], 4),
            'cartera' => $params['cartera'],
            'fecIni' => $params['fechaIni'],
            'fecFin' => verificarEmpty($params['fechaFin'], 4),
        ];

        $this->db->where('idObjetivo', $params['id']);
        $this->db->update("{$this->sessBDCuenta}.trade.cartera_objetivo", $update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['status'] = false;
        } else {
            $this->db->trans_commit();
            $result['status'] = true;
        }

        return $result;
    }

    public function actualizarEstadoCarteraObjetivo($params = [])
    {
        $result = [];

        $this->db->trans_begin();

        $update = [
            'estado' => ($params['estado'] == 1) ? 0 : 1
        ];

        $this->db->where('idObjetivo', $params['idObjetivo']);
        $this->db->update("{$this->sessBDCuenta}.trade.cartera_objetivo", $update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['status'] = false;
        } else {
            $this->db->trans_commit();
            $result['status'] = true;
        }

        return $result;
    }
}
