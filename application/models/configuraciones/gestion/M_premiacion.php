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
            'tipoPremiacion' => ['tabla' => "{$this->sessBDCuenta}.trade.premiacion", 'id' => 'idPremiacion'],
            'lista' => ['tabla' => "{$this->sessBDCuenta}.trade.list_premiaciones", 'id' => 'idListPremiacion'],
            'listaDet' => ['tabla' => "{$this->sessBDCuenta}.trade.list_premiacionesDet", 'id' => 'idListPremiacionDet'],
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
				FROM {$this->sessBDCuenta}.trade.premiacion
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
		

        $insert = $this->db->insert("{$this->sessBDCuenta}.trade.premiacion", $insert);
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
        $update = $this->db->update("{$this->sessBDCuenta}.trade.premiacion", $update);
        return $update;
    }


    public function getClientes($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.estado=1 AND ch.idProyecto = " . $post['id'];
		}

		$sql = "
			DECLARE @fecha DATE=GETDATE();
			SELECT 
			c.idCliente, c.razonSocial
			FROM trade.cliente c
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
    }


    public function registrarLista_HT($post)
	{

		$insert = [
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'idCanal' =>trim($post['idCanal']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}
		if(!empty($post['idTipoUsuario'])){$insert['idTipoUsuario']=$post['idTipoUsuario'];}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

    public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (empty($value['id'])) {
				$input[] = [
					'idListPremiacion' => $idLista,
					'idPremiacion' =>$value['elemento_lista'],
				];
			}
		}
		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->m_tipopremiacion->tablas['listaDet']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 11, 'tabla' => $this->m_tipopremiacion->tablas['listaDet']['tabla'] ];
		return $insert;
	}

}
