<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_ModulosApp extends My_Model{

	var $CI;

	public function __construct(){
        parent::__construct();
        $this->CI =& get_instance();
    }

    public function listCuenta( $input = [] ){
        $filtro = "";

            if( !empty($this->permisos['cuenta']) ){
                if( is_array($this->permisos['cuenta']) )
                    $filtro .= " AND idCuenta IN (".implode(',', $this->permisos['cuenta']).")";
                else 
                    $filtro .= " AND idCuenta = ".$this->permisos['cuenta'];
            }

            if( !empty($input['idCuenta']) ) $filtro .= " AND idCuenta = ".$input['idCuenta'];
            if( !empty($input['estado']) ) $filtro .= " AND estado = 1";

        $sql = "SELECT idCuenta, nombre, estado FROM trade.cuenta WHERE 1 = 1{$filtro} ORDER BY nombre";

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
        return $this->db->query($sql)->result_array();
    }

    public function listAplicacion( $input = [] ){
        $filtro = "";

            if( isset($input['estado']) ) $filtro .= " AND estado = ".$input['estado'];
            if( !empty($input['idCuenta']) ) $filtro .= " AND idCuenta = ".$input['idCuenta'];

        $sql = "SELECT idAplicacion, nombre, estado FROM trade.aplicacion WHERE flagAndroid = 1{$filtro} ORDER BY nombre";

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.aplicacion' ];
        return $this->db->query($sql)->result_array();
    }

    public function listModulo( $input = [] ){
        $filtro = "";
            if( isset($input['estado']) ) $filtro .= " AND estado = ".$input['estado'];
            if( !empty($input['idAplicacion']) ) $filtro .= " AND idAplicacion = {$input['idAplicacion']}";

        $sql = "SELECT idModulo, nombre, estado, orden FROM trade.aplicacion_modulo WHERE 1 = 1{$filtro} ORDER BY nombre";

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.aplicacion_modulo' ];
        return $this->db->query($sql)->result_array();
    }

    public function listTipoUsuario( $input = [] ){
        $filtro = "";
        $sql = "SELECT idTipoUsuario, nombre, estado FROM trade.usuario_tipo WHERE 1 = 1{$filtro} ORDER BY nombre";

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.usuario_tipo' ];
        return $this->db->query($sql)->result_array();
    }

    public function listCanal( $input = [] ){
        $filtro = "";
            if( isset($input['estado']) ) $filtro .= " AND ca.estado = ".$input['estado'];
            if( !empty($input['idCuenta']) ) $filtro .= " AND cuca.idCuenta = ".$input['idCuenta'];

        $sql = "
SELECT ca.idCanal, ca.nombre, ca.estado
FROM trade.canal ca
JOIN trade.cuenta_canal cuca ON ca.idCanal = cuca.idCanal AND cuca.estado = 1
WHERE 1 = 1{$filtro}
ORDER BY ca.nombre";

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
        return $this->db->query($sql)->result_array();
    }

    public function consultar( $input = [] ){
        $filtro = "";

            if( !empty($this->permisos['cuenta']) ){
                if( is_array($this->permisos['cuenta']) )
                    $filtro .= " AND cu.idCuenta IN (".implode(',', $this->permisos['cuenta']).")";
                else 
                    $filtro .= " AND cu.idCuenta = ".$this->permisos['cuenta'];
            }

            if( !empty($input['idCuenta']) ) $filtro .= " AND cu.idCuenta = ".$input['idCuenta'];
            if( !empty($input['idAplicacion']) ) $filtro .= " AND app.idAplicacion = ".$input['idAplicacion'];
            if( !empty($input['idModulo']) ) $filtro .= " AND mo.idModulo = ".$input['idModulo'];
            if( array_key_exists('idTipoUsuario', $input) ){
                if( is_null($input['idTipoUsuario']) ) $filtro .= " AND ut.idTipoUsuario IS NULL";
                elseif( !empty($input['idTipoUsuario']) ) $filtro .= " AND ut.idTipoUsuario = ".$input['idTipoUsuario'];
            }
            if( array_key_exists('idCanal', $input) ){
                if( is_null($input['idCanal']) ) $filtro .= " AND ca.idCanal IS NULL";
                elseif( !empty($input['idCanal']) ) $filtro .= " AND ca.idCanal = ".$input['idCanal'];
            }

        $sql = "
SELECT
    app.idAplicacion,
    app.nombre AS aplicacion,
    mout.idModuloTipo,
    mo.idModulo,
    mo.nombre AS modulo,
    ut.idTipoUsuario,
    ut.nombre AS tipoUsuario,
    ca.idCanal,
    ca.nombre AS canal,
    mout.estado,
    mout.flagObligatorio AS obligatorio,
    mo.orden,
    CASE
        WHEN ut.idTipoUsuario IS NOT NULL AND ca.idCanal IS NOT NULL THEN 1
        WHEN ut.idTipoUsuario IS NOT NULL AND ca.idCanal IS NULL THEN 2
        WHEN ut.idTipoUsuario IS NULL AND ca.idCanal IS NOT NULL THEN 3
        ELSE 4 END
    AS idPrioridad,
    CASE
        WHEN ut.idTipoUsuario IS NOT NULL AND ca.idCanal IS NOT NULL THEN 'Tipo Usuario & Canal'
        WHEN ut.idTipoUsuario IS NOT NULL AND ca.idCanal IS NULL THEN 'Tipo Usuario'
        WHEN ut.idTipoUsuario IS NULL AND ca.idCanal IS NOT NULL THEN 'Canal'
        ELSE 'General' END
    AS prioridad,
    CONVERT(VARCHAR, ISNULL(ut.idTipoUsuario, 0)) + '-' + CONVERT(VARCHAR, ISNULL(ca.idCanal, 0)) AS cabecera,
    COUNT(mo.idModulo)OVER(PARTITION BY ut.idTipoUsuario, ca.idCanal) AS totalModulos
FROM trade.aplicacion_modulo_tipoUsuario mout
JOIN trade.aplicacion_modulo mo ON mout.idModulo = mo.idModulo
JOIN trade.aplicacion app ON mo.idAplicacion = app.idAplicacion
JOIN trade.cuenta cu ON app.idCuenta = cu.idCuenta
LEFT JOIN trade.usuario_tipo ut ON mout.idTipoUsuario = ut.idTipoUsuario
LEFT JOIN trade.canal ca ON mout.idCanal = ca.idCanal
WHERE 1 = 1{$filtro}
ORDER BY idPrioridad, totalModulos DESC, tipoUsuario, canal, orden
";

        $this->CI->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.aplicacion_modulo_tipoUsuario' ];
        return $this->db->query($sql)->result_array();
    }

    public function guardar( $input = [] ){
        $aSessTrack = [];
        $result = [ 'status' => 0, 'msg' => '' ];

            $this->db->trans_begin();

                if( !is_array($input['idModulo']) ) $input['idModulo'] = [ $input['idModulo'] ];
                foreach($input['idModulo'] as $idModulo){
                    $aInsert = [
                        'idTipoUsuario' => empty($input['idTipoUsuario']) ? null : $input['idTipoUsuario'],
                        'idCanal' => empty($input['idCanal']) ? null : $input['idCanal'],
                        'idModulo' => $idModulo
                    ];

                    $query = $this->consultar($aInsert);
                    if( !empty($query) ){
                        $result['msg'] = 'Configuración que intentar ingresar ya existe';
                        goto responder;
                    }

                    $aInsert['flagObligatorio'] = empty($input["flagObligatorio[{$idModulo}]"]) ? null : $input["flagObligatorio[{$idModulo}]"];
                    $aInsert['estado'] = 1;

                    $this->db->insert('trade.aplicacion_modulo_tipoUsuario', $aInsert);
                    $aSessTrack = [ 'idAccion' => 6, 'tabla' => 'trade.aplicacion_modulo_tipoUsuario', 'id' => $this->db->insert_id() ];
                }

            responder:
            if( !$this->db->trans_status() || !empty($result['msg']) ){
                $this->db->trans_rollback();

                if( !empty($result['msg']) )
                    $result['status'] = 2;
                else
                    $result['msg'] = 'Ocurrio un error inesperado en el sistema, comunicar al administrador.';
            }
            else{
                $this->db->trans_commit();
                $this->CI->aSessTrack[] = $aSessTrack;

                $result['status'] = 1;
                $result['msg'] = 'Datos registrados correctamente.';
            }

        return $result;
    }

    public function editar( $input = [] ){
        $aSessTrack = [];
        $result = [ 'status' => 0, 'msg' => '' ];

            $this->db->trans_begin();

                if( !empty($input['idModuloTipo']) ){
                    if( isset($input['flagObligatorio']) )
                        $this->db->set('flagObligatorio', $input['flagObligatorio']);

                    $this->db->where('idModuloTipo', $input['idModuloTipo']);
                    $this->db->update('trade.aplicacion_modulo_tipoUsuario');

                    $aSessTrack = [ 'idAccion' => 7, 'tabla' => 'trade.aplicacion_modulo_tipoUsuario', 'id' => $input['idModuloTipo'] ];
                }

            responder:
            if( !$this->db->trans_status() || !empty($result['msg']) ){
                $this->db->trans_rollback();

                if( !empty($result['msg']) )
                    $result['status'] = 2;
                else
                    $result['msg'] = 'Ocurrio un error inesperado en el sistema, comunicar al administrador.';
            }
            else{
                $this->db->trans_commit();
                $this->CI->aSessTrack[] = $aSessTrack;

                $result['status'] = 1;
                $result['msg'] = 'Datos registrados correctamente.';
            }

        return $result;
    }

    public function eliminar( $input = [] ){
        $aSessTrack = [];
        $result = [ 'status' => 0, 'msg' => '' ];

            $this->db->trans_begin();

                if( !empty($input['grupo']) ){
                    foreach($input['grupo'] as $grupo){
                        $this->db->where('idTipoUsuario', empty($grupo['idTipoUsuario']) ? null : $grupo['idTipoUsuario'], false);
                        $this->db->where('idCanal', empty($grupo['idCanal']) ? null : $grupo['idCanal'], false);
                        $this->db->delete('trade.aplicacion_modulo_tipoUsuario');

                        $aSessTrack[] = [
                                'idAccion' => 8,
                                'tabla' => 'trade.aplicacion_modulo_tipoUsuario',
                                'id' => arrayToString([
                                        'idTipoUsuario' => empty($grupo['idTipoUsuario']) ? 'null' : $grupo['idTipoUsuario'],
                                        'idCanal' => empty($grupo['idCanal']) ? 'null' : $grupo['idCanal']
                                    ])
                            ];
                    }
                }
                elseif( !empty($input['idModuloTipo']) ){
                    $this->db->where('idModuloTipo', $input['idModuloTipo']);
                    $this->db->delete('trade.aplicacion_modulo_tipoUsuario');

                    $aSessTrack[] = [
                        'idAccion' => 8,
                        'tabla' => 'trade.aplicacion_modulo_tipoUsuario',
                        'id' => $input['idModuloTipo']
                    ];
                }

            responder:
            if( !$this->db->trans_status() || !empty($result['msg']) ){
                $this->db->trans_rollback();

                if( !empty($result['msg']) )
                    $result['status'] = 2;
                else
                    $result['msg'] = 'Ocurrio un error inesperado en el sistema, comunicar al administrador.';
            }
            else{
                $this->db->trans_commit();
                $this->CI->aSessTrack = array_merge($this->CI->aSessTrack, $aSessTrack);

                $result['status'] = 1;
                $result['msg'] = 'Datos registrados correctamente.';
            }

        return $result;
    }

}