<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_receipt extends RAST_Model {

    function get_list() {
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
						SELECT
							m.*
							, fmm.*
							, fm.*
						FROM
							food_menu_material fmm
							, food_menu fm
							, material m
						WHERE
							m.material_status = 1
							AND m.material_status=1
							AND fmm.food_menu_id = fm.food_menu_id
							AND fmm.material_id=m.material_id'
            );
        } else {
            $query = $this->db->query
            ('
						SELECT
							m.*
							, supplier_name
							, outlet_name
						FROM
							receipt m
							, supplier s
							, outlet o
						WHERE
							receipt_status = 1
							AND m.supplier_id = s.supplier_id
							AND s.outlet_id = o.outlet_id
			');
        }

        return $query->result_array();
    }
    function material_list() {
        $query = $this->db->query
        ('
                    SELECT
                        m.*
                    FROM
                        material m
                        , supplier s
                    WHERE
                        material_status = 1
                        AND s.supplier_id = m.supplier_id
                        AND outlet_id = ' . $this->session->userdata('outlet_id')
        );

        return $query->result_array();
    }

    function get_isi($a) {
        $query = $this->db->query
        ('
                    SELECT
                        *
                    FROM
                        receipt
                    WHERE
                        receipt_id = ' . $a
        );

        return $query->result_array();
    }
    function food_menu_list() {
        $query = $this->db->query
        ('
							SELECT
								f.*
							FROM
								food_menu f
							WHERE
								food_menu_status = 1
			');

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
        if ($a['receipt_id'] == '') {
            for ($i=0;$i<10;$i++){
                if (($a['material_id'.$i])!=""){
                    $query = $this->db->query
                    ('
                        INSERT INTO food_menu_material VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['food_menu'] . "'" . '
                            , ' . "'" . $a['material_id'.$i] . "'" . '
                            , ' . "'" . $a['amount'.$i] . "'" . '
                        )
                    ');
                }
            }

        } else {
            $query = $this->db->query
            ('
						UPDATE receipt SET
                            supplier_id = ' . "'" . $a['supplier_id'] . "'" . '
                            , receipt_name = ' . "'" . $a['receipt_name'] . "'" . '
                            , units = ' . "'" . $a['units'] . "'" . '
                            , receipt_notes = ' . "'" . $a['receipt_notes'] . "'" . '
						WHERE
							receipt_id = ' . $a['receipt_id']
            );
        }

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete($a) {
        $query = $this->db->query
        ('
                    UPDATE receipt SET
                        receipt_status = 0
                    WHERE
                        receipt_id = ' . $a
        );

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
