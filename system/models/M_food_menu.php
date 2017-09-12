<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_food_menu extends RAST_Model {

    function get_list() {
        if ($this->session->userdata('outlet_id') != 'all') {
			$query = $this->db->query
					('
							SELECT
								f.*
								, category_name
							FROM
								food_menu f
								, category c
							WHERE
								food_menu_status = 1
								AND f.category_id = c.category_id
								AND c.outlet_id = ' . $this->session->userdata('outlet_id')
			);
		} else {
			$query = $this->db->query
					('
							SELECT
								f.*
								, category_name
								, outlet_name
							FROM
								food_menu f
								, category c
								, outlet o
							WHERE
								food_menu_status = 1
								AND f.category_id = c.category_id
								AND c.outlet_id = o.outlet_id
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
                        food_menu
                    WHERE
                        food_menu_id = ' . $a
        );

        return $query->result_array();
    }

    function category_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        category
                    WHERE
                        category_status = 1
                        AND outlet_id = ' . $this->session->userdata('outlet_id')
		);

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['food_menu_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO food_menu VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['category_id'] . "'" . '
                            , ' . "'" . $a['food_menu_name'] . "'" . '
                            , ' . "'" . $a['food_menu_hpp_price'] . "'" . '
                            , ' . "'" . $a['food_menu_price'] . "'" . '
                            , ' . "'" . $a['food_menu_commision'] . "'" . '
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah menu makanan ".$a['food_menu_name'];

        } else {
            $query = $this->db->query
                    ('
			UPDATE food_menu SET
                            category_id = ' . "'" . $a['category_id'] . "'" . '
                            , food_menu_name = ' . "'" . $a['food_menu_name'] . "'" . '
                            , food_menu_hpp_price = ' . "'" . $a['food_menu_hpp_price'] . "'" . '
                            , food_menu_price = ' . "'" . $a['food_menu_price'] . "'" . '
                            , food_menu_commision = ' . "'" . $a['food_menu_commision'] . "'" . '
			WHERE
			    food_menu_id = ' . $a['food_menu_id']
            );
            $deskripsi=$deskripsi."Mengedit menu makanan ".$a['food_menu_name'];
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

    function material_list() {
        $query = $this->db->query
                ('
                    SELECT
                        m.*
                    FROM
                        material m
                        , supplier s
                    WHERE
                        m.material_status = 1
                        AND m.supplier_id = s.supplier_id
                        AND s.outlet_id = ' . $this->session->userdata('outlet_id')
		);

        return $query->result_array();
    }

    function get_food_menu_material_list($food_menu_id) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                        , m.material_name
                    FROM
                        food_menu_material fm
                        , material m
                    WHERE
                        fm.food_menu_id = ' . $food_menu_id . '
                        AND fm.material_id = m.material_id
                        AND material_status = 1
		');

        return $query->result_array();
    }

    function process_material($a, $kind) {
        $query = FALSE;
        if ($kind == 'process') {
            $query = $this->db->query
                    ('
                        INSERT INTO food_menu_material VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['food_menu_id'] . "'" . '
                            , ' . "'" . $a['material_id'] . "'" . '
                            , ' . "'" . $a['amount'] . "'" . '
                        )
                    ');
        } else if ($kind == 'delete') {
            $query = $this->db->query
                    ('
                        DELETE FROM food_menu_material
                        WHERE food_menu_material_id = ' . $a
            );
        } else {
            return FALSE;
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
                    UPDATE food_menu SET
                        food_menu_status = 0
                    WHERE
                        food_menu_id = ' . $a
        );
        $deskripsi="Menghapus menu makananan dengan ID ".$a;
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
