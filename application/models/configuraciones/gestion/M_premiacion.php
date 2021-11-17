<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_premiacion extends My_Model
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

    public function getPremiacion($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
          
        } else {
            if (!empty($post['id'])) $filtros .= " AND idPremiacion = " . $post['id'];
            if (!empty($post['cuenta_filtro'])) $filtros .= " AND idCuenta = " . $post['cuenta_filtro'];
        }

        $sql = "
				SELECT *
				FROM trade.premiacion
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
            'nombre' => trim($post['nombre']),
            'idCuenta' => trim($post['cuenta_tipoPremiacion']),
            'fechaInicio' => trim($post['fechaInicio']),
        ];

		if(!empty($post['fechaFin'])){
			 $insert['fechaCaducidad']=trim($post['fechaFin']);
		}
		

        $insert = $this->db->insert('trade.premiacion', $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarTipoPremiacion($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'idCuenta' => trim($post['cuenta_tipoPremiacion']),
            'fechaInicio' => trim($post['fechaInicio']),
        ];
		
		if(!empty($post['fechaFin'])){
			 $update = [
				'fechaCaducidad' => trim($post['fechaFin'])
			];
		}

        $where = [
            'idPremiacion' => $post['idPremiacion']
        ];

        $this->db->where($where);
        $update = $this->db->update('trade.premiacion', $update);
        return $update;
    }
}
