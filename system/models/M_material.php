<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_material extends RAST_Model {

    function get_list() {
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
						SELECT
							m.*
							, supplier_name
						FROM
							material m
							, supplier s
						WHERE
							material_status = 1
							AND m.supplier_id = s.supplier_id
							AND s.outlet_id = ' . $this->session->userdata('outlet_id')
            );
        } else {
            $query = $this->db->query
            ('
						SELECT
							m.*
							, supplier_name
							, outlet_name
						FROM
							material m
							, supplier s
							, outlet o
						WHERE
							material_status = 1
							AND m.supplier_id = s.supplier_id
							AND s.outlet_id = o.outlet_id
			');
        }

        return $query->result_array();
    }

    function get_isi($a) {
        $query = $this->db->query
        ('
                    SELECT
                        *
                    FROM
                        material
                    WHERE
                        material_id = ' . $a
        );

        return $query->result_array();
    }

    function supplier_list() {
        $query = $this->db->query
        ('
                    SELECT
                        *
                    FROM
                        supplier
                    WHERE
                        supplier_status = 1
                        AND outlet_id = ' . $this->session->userdata('outlet_id')
        );

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['material_id'] == '') {
            $query = $this->db->query
            ('
                        INSERT INTO material VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['supplier_id'] . "'" . '
                            , ' . "'" . $a['material_name'] . "'" . '
                            , 0
                            , ' . "'" . $a['units'] . "'" . '
                            , ' . "'" . $a['material_notes'] . "'" . '
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah Bahan Baku ".$a['material_name'];
        } else {
            $query = $this->db->query
            ('
						UPDATE material SET
                            supplier_id = ' . "'" . $a['supplier_id'] . "'" . '
                            , material_name = ' . "'" . $a['material_name'] . "'" . '
                            , units = ' . "'" . $a['units'] . "'" . '
                            , material_notes = ' . "'" . $a['material_notes'] . "'" . '
						WHERE
							material_id = ' . $a['material_id']
            );
            $deskripsi=$deskripsi."Mengedit Bahan Baku ".$a['material_name'];
        }
        $log = $this->db->query
        ('
                    INSERT INTO log VALUES
                    (
                        ' . "'" . "'" . '
                        , '.$this->session->userdata('user_id').'
                        , "'. $deskripsi.'"
                        , now()
                    )
                ');

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function revision($a) {
        $query = FALSE;
        $deskripsi="";

        $query = $this->db->query
        ('
                        INSERT INTO revision VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['material_id'] . "'" . '
                            , ' . "'" . $a['stok_lama'] . "'" . '
                            , ' . "'" . $a['stok'] . "'" . '
                            , ' . "'" . $a['alasan_revisi'] . "'" . '
                            , now()
                        )
                    ');

        $query = $this->db->query
        ('
						UPDATE material SET
                            stock = '  . $a['stok']  . '
						WHERE
							material_id = ' . $a['material_id']
        );
        $deskripsi=$deskripsi."Melakukan Revisi Stok Bahan Baku ".$a['material_name']." dari ".$a['stok_lama']." ke ".$a['stok'];
        $log = $this->db->query
        ('
                    INSERT INTO log VALUES
                    (
                        ' . "'" . "'" . '
                        , '.$this->session->userdata('user_id').'
                        , "'. $deskripsi.'"
                        , now()
                    )
                ');
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete($a) {
        $query = $this->db->query
        ('
                    UPDATE material SET
                        material_status = 0
                    WHERE
                        material_id = ' . $a
        );
        $deskripsi="Menghapus Bahan Baku Dengan ID ".$a;
        $log = $this->db->query
        ('
                    INSERT INTO log VALUES
                    (
                        ' . "'" . "'" . '
                        , '.$this->session->userdata('user_id').'
                        , "'. $deskripsi.'"
                        , now()
                    )
                ');

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
