<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tipoPremiacion extends My_Model
{

    var $CI;
    var $aSessTrack = [];

    public function __construct()
    {
        parent::__construct();

        $this->tablas = [
            'tipoPremiacion' => ['tabla' => 'trade.tipo_premiacion', 'id' => 'idTipoPremiacion'],
        ];

        $this->CI = &get_instance();
    }

    public function getTipoPremiacion($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND idTipoPremiacion = " . $post['id'];
            if (!empty($post['cuenta_filtro'])) $filtros .= " AND idCuenta = " . $post['cuenta_filtro'];
        }

        $sql = "
				SELECT *
				FROM trade.tipo_premiacion
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
        return $this->db->query($sql);
    }

    public function checkTipoPremiacionRepetido($post)
    {
        $where = "descripcion = '" . trim($post['nombre']) . "' AND idCuenta = " . trim($post['cuenta_tipoPremiacion']);
        if (!empty($post['idTipoPremiacion'])) $where .= " AND idTipoPremiacion != " . $post['idTipoPremiacion'];
        return $this->verificarRepetido('trade.tipo_premiacion', $where);
    }

    public function registrarTipoPremiacion($post)
    {
        $insert = [
            'descripcion' => trim($post['nombre']),
            'idCuenta' => trim($post['cuenta_tipoPremiacion']),
            'detalle' => 1,
            'estado' => 1
        ];

        $insert = $this->db->insert('trade.tipo_premiacion', $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarTipoPremiacion($post)
    {
        $update = [
            'descripcion' => trim($post['nombre']),
            'idCuenta' => trim($post['cuenta_tipoPremiacion'])
        ];

        $where = [
            'idTipoPremiacion' => $post['idTipoPremiacion']
        ];

        $this->db->where($where);
        $update = $this->db->update('trade.tipo_premiacion', $update);
        return $update;
    }
}
