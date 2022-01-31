<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_CuentasCanales extends My_Model
{

    var $CI;
    var $aSessTrack = [];

    public function __construct()
    {
        parent::__construct();

        $this->tablas = [
            'cuenta' => ['tabla' => 'trade.cuenta', 'id' => 'idCuenta'],
            'tipoUsuarioCuenta' => ['tabla' => 'trade.tipoUsuarioCuenta', 'id' => 'idTipoUsuarioCuenta'],
            'proyecto' => ['tabla' => 'trade.proyecto', 'id' => 'idProyecto'],
            'grupoCanal' => ['tabla' => 'trade.grupoCanal', 'id' => 'idGrupoCanal'],
            'canal' => ['tabla' => 'trade.canal', 'id' => 'idCanal'],
            'subCanal' => ['tabla' => 'trade.subCanal', 'id' => 'idSubCanal'],
        ];

        $this->CI = &get_instance();
    }

    // SECCION CUENTAS
    public function getCuentas($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND idCuenta = " . $post['id'];
        }

        $sql = "
				SELECT *
				FROM trade.cuenta
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
        return $this->db->query($sql);
    }

    public function registrarCuenta($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'ruc' => trim($post['ruc']),
            'direccion' => trim($post['direccion']),
            'cod_ubigeo' => trim($post['ubigeo']),
            'nombreComercial' => trim($post['nombreComercial']),
            'razonSocial' => trim($post['razonSocial']),
            'urlCss' =>  !empty($post['urlCss']) ? trim($post['urlCss']) : null,
            'urlLogo' => !empty($post['urlLogo']) ? trim($post['urlLogo']) : null,
        ];

        $insert = $this->db->insert($this->tablas['cuenta']['tabla'], $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarCuenta($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'ruc' => trim($post['ruc']),
            'direccion' => trim($post['direccion']),
            'cod_ubigeo' => trim($post['ubigeo']),
            'nombreComercial' => trim($post['nombreComercial']),
            'razonSocial' => trim($post['razonSocial']),
            'urlCss' =>  !empty($post['urlCss']) ? trim($post['urlCss']) : null,
            'urlLogo' => !empty($post['urlLogo']) ? trim($post['urlLogo']) : null,
            'fechaModificacion' => getActualDateTime(),
        ];

        $where = [
            $this->tablas['cuenta']['id'] => $post['idCuenta']
        ];

        $this->db->where($where);
        $update = $this->db->update($this->tablas['cuenta']['tabla'], $update);
        return $update;
    }

    public function checkNombreCuentaRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "'";
        if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id'] . " != " . $post['idCuenta'];
        return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
    }

    public function checkRucCuentaRepetido($post)
    {
        $where = "ruc = '" . trim($post['ruc']) . "'";
        if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id']  . " != " . $post['idCuenta'];
        return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
    }

    public function checkNombreComercialCuentaRepetido($post)
    {
        $where = "nombreComercial = '" . trim($post['nombreComercial']) . "'";
        if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id']  . " != " . $post['idCuenta'];
        return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
    }

    public function checkRazonSocialCuentaRepetido($post)
    {
        $where = "razonSocial = '" . trim($post['razonSocial']) . "'";
        if (!empty($post['idCuenta'])) $where .= " AND " . $this->tablas['cuenta']['id'] . " != " . $post['idCuenta'];
        return $this->verificarRepetido($this->tablas['cuenta']['tabla'], $where);
    }

    // SECCION PROYECTOS
    public function getProyectos($post)
    {
        $idCuenta = $this->sessIdCuenta;
        $filtros = "WHERE 1 = 1";
        if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
        if (!empty($idCuenta)) $filtros .= " AND c.idCuenta = " . $idCuenta;

        $sql = "
				SELECT p.*, 
					c.nombre cuenta
				FROM trade.proyecto p
					INNER JOIN trade.cuenta c ON c.idCuenta = p.idCuenta
				{$filtros}
			";

        // $this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.proyecto'];
        return $this->db->query($sql);
    }

    public function registrarProyecto($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'nombreCorto' => !empty($post['nombreCorto']) ? trim($post['nombreCorto']) : '',
            'idCuenta' => trim($post['cuenta']),
            'fecIni' => trim($post['fechaInicio']),
            'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
        ];

        $insert = $this->db->insert($this->tablas['proyecto']['tabla'], $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarProyecto($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'nombreCorto' => !empty($post['nombreCorto']) ? trim($post['nombreCorto']) : '',
            'idCuenta' => trim($post['cuenta']),
            'fecIni' => trim($post['fechaInicio']),
            'fecFin' => !empty($post['fechaFin']) ? trim($post['fechaFin']) : null,
            'fechaModificacion' => getActualDateTime(),
        ];

        $where = [
            $this->tablas['proyecto']['id'] => $post['idProyecto']
        ];

        $this->db->where($where);
        $update = $this->db->update($this->tablas['proyecto']['tabla'], $update);
        return $update;
    }

    public function guardarMasivoProyecto($proyectos)
    {
        $input = [];
        foreach ($proyectos as $key => $value) {
            $input[$key] = [
                'nombre' => $value['nombre'],
                'nombreCorto' => !empty($value['nombreCorto']) ? trim($value['nombreCorto']) : '',
                'idCuenta' => $value['idCuenta'],
                'fecIni' => date_change_format_bd($value['fechaInicio']),
                'fecFin' => date_change_format_bd($value['fechaFin'])
            ];
        }

        $insert = $this->db->insert_batch($this->tablas['proyecto']['tabla'], $input);
        return $insert;
    }

    public function checkProyectoYCuentaRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "' AND idCuenta = " . ((!empty($post['cuenta'])) ? $post['cuenta'] : 0);
        if (!empty($post['idProyecto'])) $where .= " AND " . $this->tablas['proyecto']['id'] . " != " . $post['idProyecto'];
        return $this->verificarRepetido($this->tablas['proyecto']['tabla'], $where);
    }

    // SECCION GRUPO CANAL
    public function getGrupoCanales($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND gc.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND gc.idGrupoCanal = " . $post['id'];
            if (!empty($post['proyecto_filtro'])) $filtros .= " AND pgc.idProyecto = " . $post['proyecto_filtro'];
        }

        $sql = "
				SELECT 
                gc.*,
                pgc.nombre nombreCorto,
                py.nombre proyecto
				FROM trade.grupoCanal gc
                LEFT JOIN trade.proyectoGrupoCanal pgc ON gc.idGrupoCanal = pgc.idGrupoCanal
                LEFT JOIN trade.proyecto py ON py.idProyecto = pgc.idProyecto
				$filtros
			";

        return $this->db->query($sql);
    }

    public function registrarGrupoCanal($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
        ];

        $result = [];
        $result['status'] = true;

        $insert = $this->db->insert($this->tablas['grupoCanal']['tabla'], $insert);
        $this->insertId = $this->db->insert_id();

        if (!$insert) {
            $result['status'] = false;
        }
        $insertPgc = [
            'idProyecto' => $post['idProyecto'],
            'idGrupoCanal' => $this->insertId,
            'estado' => 1,
            'nombre' => !empty($post['nombreCorto']) ? trim($post['nombreCorto']) : '',
        ];

        $insertPGC = $this->db->insert('trade.proyectoGrupoCanal', $insertPgc);

        if (!$insertPGC) {
            $result['status'] = false;
        }

        return $result['status'];
    }

    public function actualizarGrupoCanal($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'fechaModificacion' => getActualDateTime(),
        ];

        $result = [];
        $result['status'] = true;

        $where = [
            $this->tablas['grupoCanal']['id'] => $post['idGrupoCanal']
        ];

        $this->db->where($where);
        $update = $this->db->update($this->tablas['grupoCanal']['tabla'], $update);

        if (!$update) {
            $result['status'] = false;
        }

        $PGC = $this->db->query("SELECT * FROM trade.proyectoGrupoCanal WHERE idProyecto = ? AND idGrupoCanal = ?", [ 'idProyecto' => $post['idProyecto'], 'idGrupoCanal' => $post['idGrupoCanal'] ])->row_array();
        $insertPGC = false;

        if(count($PGC) == 0){

            $insertPgc = [
                'idProyecto' => $post['idProyecto'],
                'idGrupoCanal' => $this->insertId,
                'estado' => 1,
                'nombre' => !empty($post['nombreCorto']) ? trim($post['nombreCorto']) : '',
            ];

            $insertPGC = $this->db->insert('trade.proyectoGrupoCanal', $insertPgc);

            if (!$insertPGC) {
                $result['status'] = false;
            }
        }
        if(!empty($PGC)){

            $updatePgc = [
                'idProyecto' => $post['idProyecto'],
                'idGrupoCanal' =>  $PGC['idGrupoCanal'],
                'estado' => 1,
                'nombre' => !empty($post['nombreCorto']) ? trim($post['nombreCorto']) : '',
            ];

            $updatePGC = $this->db->update('trade.proyectoGrupoCanal', $updatePgc, ['idProyectoGrupoCanal' => $PGC['idProyectoGrupoCanal']]);
            
            if (!$updatePGC) {
                $result['status'] = false;
            }
        }

        return $result['status'];
    }

    public function checkNombreGrupoCanalRepetido($post)
    {
        $where = "gc.nombre = '" . trim($post['nombre']) . "'";
        if (!empty($post['idGrupoCanal'])) $where .= " AND gc." . $this->tablas['grupoCanal']['id'] . " != " . $post['idGrupoCanal'];
        if (!empty($post['idProyecto'])) $where .= " AND pgc.idProyecto = " . $post['idProyecto'];

        $sql = "
            SELECT
            *
            FROM {$this->tablas['grupoCanal']['tabla']} AS gc
            JOIN trade.proyectoGrupoCanal pgc ON gc.idGrupoCanal = pgc.idGrupoCanal
            WHERE
            {$where}
        ";

        $incidencias = count($this->db->query($sql)->result());

		if ($incidencias > 0) {
			return true;
		} else {
			return false;
		}
    }

    // SECCION CANAL
    public function getCanales($post = 'nulo')
    {
        $idCuenta = $this->sessIdCuenta;
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND c.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND c.idCanal = " . $post['id'];
            if (!empty($post['proyecto_filtro'])) $filtros .= " AND pgc.idProyecto = " . $post['proyecto_filtro'];
            // if (!empty($idCuenta)) $filtros .= " AND cc.idCuenta = " . $idCuenta;
        }

        $sql = "
				SELECT c.*, 
					gc.nombre grupoCanal,
                    cc.idCuentaCanal,
                    cc.estado
				FROM trade.canal c
					JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
                    LEFT JOIN trade.proyectoGrupoCanal pgc ON gc.idGrupoCanal = pgc.idGrupoCanal
                    LEFT JOIN trade.cuenta_canal cc ON cc.idCanal = c.idCanal
				{$filtros}
			";

        // $this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.canal'];
        return $this->db->query($sql);
    }

    public function registrarCanal($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'idGrupoCanal' => trim($post['grupoCanal']),
        ];

        $insert = $this->db->insert($this->tablas['canal']['tabla'], $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarCanal($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'idGrupoCanal' => trim($post['grupoCanal']),
            'fechaModificacion' => getActualDateTime(),
        ];

        $where = [
            $this->tablas['canal']['id'] => $post['idCanal']
        ];

        $this->db->where($where);
        $update = $this->db->update($this->tablas['canal']['tabla'], $update);
        return $update;
    }

    public function checkCanalYGrupoCanalRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "' AND idGrupoCanal = " . ((!empty($post['grupoCanal'])) ? $post['grupoCanal'] : 0);
        if (!empty($post['idCanal'])) $where .= " AND " . $this->tablas['canal']['id'] . " != " . $post['idCanal'];
        return $this->verificarRepetido($this->tablas['canal']['tabla'], $where);
    }

    // SECCION SUBCANAL
    public function getSubCanales($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND s.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND s.idSubCanal = " . $post['id'];
            if (!empty($post['proyecto_filtro'])) $filtros .= " AND pgc.idProyecto = " . $post['proyecto_filtro'];
        }

        $sql = "
			SELECT s.*, 
				c.nombre canal,
                gc.nombre AS grupoCanal
			FROM trade.subCanal s
				JOIN trade.canal c ON c.idCanal = s.idCanal
                JOIN trade.grupoCanal gc ON gc.idGrupoCanal = c.idGrupoCanal
                LEFT JOIN trade.proyectoGrupoCanal pgc ON gc.idGrupoCanal = pgc.idGrupoCanal
				$filtros
			";

        return $this->db->query($sql);
    }

    public function registrarSubCanal($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'idCanal' => trim($post['canal']),
        ];

        $insert = $this->db->insert($this->tablas['subCanal']['tabla'], $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarSubCanal($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'idCanal' => trim($post['canal']),
            'fechaModificacion' => getActualDateTime(),
        ];

        $where = [
            $this->tablas['subCanal']['id'] => $post['idSubCanal']
        ];

        $this->db->where($where);
        $update = $this->db->update($this->tablas['subCanal']['tabla'], $update);
        return $update;
    }

    public function checkSubCanalYCanalRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "' AND idCanal = " . ((!empty($post['canal'])) ? $post['canal'] : 0);
        if (!empty($post['idSubCanal'])) $where .= " AND " . $this->tablas['subCanal']['id'] . " != " . $post['idSubCanal'];
        return $this->verificarRepetido($this->tablas['subCanal']['tabla'], $where);
    }

    // SECCION TIPO USUARIO CUENTA
    public function getTipoUsuarioCuenta($post)
    {
        $idCuenta = $this->sessIdCuenta;
        $filtros = "WHERE 1 = 1";
        if (!empty($post['id'])) $filtros .= " AND tuc.idTipoUsuarioCuenta = " . $post['id'];
        if (!empty($idCuenta)) $filtros .= " AND c.idCuenta = " . $idCuenta;
        if (!empty($idTipoUsuario)) $filtros .= " AND ut.idTipoUsuario = " . $idTipoUsuario;

        $sql = "
				SELECT tuc.*,
					c.nombre cuenta,
					ut.nombre tipoUsuario
				FROM trade.tipoUsuarioCuenta tuc
					JOIN trade.cuenta c ON tuc.idCuenta = c.idCuenta
					JOIN trade.usuario_tipo ut ON tuc.idTipoUsuario = ut.idTipoUsuario
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.tipoUsuarioCuenta'];
        return $this->db->query($sql);
    }

    public function registrarTipoUsuarioCuenta($post)
    {
        $insert = [
            'idTipoUsuario' => $post['idTipoUsuario'],
            'idCuenta' => $post['cuenta'],
            'fechaCreacion' => getActualDateTime()
        ];

        $insert = $this->db->insert($this->tablas['tipoUsuarioCuenta']['tabla'], $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarTipoUsuarioCuenta($post)
    {
        $update = [
            'idTipoUsuario' => $post['idTipoUsuario'],
            'idCuenta' => $post['cuenta'],
            'fechaCreacion' => getActualDateTime(),
        ];

        $where = [
            $this->tablas['tipoUsuarioCuenta']['id'] => $post['idTipoUsuarioCuenta']
        ];

        $this->db->where($where);
        $update = $this->db->update($this->tablas['tipoUsuarioCuenta']['tabla'], $update);
        return $update;
    }

    public function checkTipoUsuarioCuentaRepetido($post)
    {
        $where = "1 = 1";
        if (!empty($post['idTipoUsuarioCuenta'])) $where .= " AND tuc." . $this->tablas['tipoUsuarioCuenta']['id'] . " != " . $post['idTipoUsuarioCuenta'];
        if (!empty($post['idProyecto'])) $where .= " AND tuc.idCuenta = " . $post['idProyecto'];
        if (!empty($post['idTipoUsuario'])) $where .= " AND tuc.idTipoUsuario = " . $post['idTipoUsuario'];

        $sql = "
            SELECT
            *
            FROM {$this->tablas['tipoUsuarioCuenta']['tabla']} AS tuc
            WHERE
            {$where}
        ";

        $incidencias = count($this->db->query($sql)->result());

		if ($incidencias > 0) {
			return true;
		} else {
			return false;
		}
    }

    //TIPO USUARIO

    public function getTipoUsuario($post = [])
    {
        $idCuenta = $this->sessIdCuenta;
        $filtros = "WHERE 1 = 1";
        if (!empty($post['id'])) $filtros .= " AND ut.idTipoUsuario = " . $post['id'];

        $sql = "
				SELECT ut.*
				FROM trade.usuario_tipo ut
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.usuario_tipo'];
        return $this->db->query($sql);
    }
}
