<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_distribution extends RAST_Model {

    function get_list() {
        $query = $this->db->query
                ('
                    SELECT
                        ti.*
                        , o.outlet_name
                        , m.material_name
                        , s.material_name AS material_name_storage
                    FROM
                        tmp_distribution_storage ti
                        , material m
                        , storage s
                        , supplier su
                        , outlet o
                    WHERE
                        ti.storage_id = s.storage_id
                        AND ti.material_id = m.material_id
                        AND su.supplier_id = m.supplier_id
                        AND su.outlet_id = o.outlet_id
		');

        return $query->result_array();
    }

    function get_isi($id) {
        $query = $this->db->query
                ('
                    SELECT
                        ti.*
                        , o.outlet_id
                    FROM
                        tmp_distribution_storage ti
                        , material m
                        , storage s
                        , supplier su
                        , outlet o
                    WHERE
                        ti.storage_id = s.storage_id
                        AND ti.material_id = m.material_id
                        AND su.supplier_id = m.supplier_id
                        AND su.outlet_id = o.outlet_id
                        AND tmp_distribution_storage = ' . $id
        );

        return $query->result_array();
    }

    function storage_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        storage
                    WHERE
                        storage_status = 1
		');

        return $query->result_array();
    }

    function outlet_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        outlet
                    WHERE
                        outlet_status = 1
		');

        return $query->result_array();
    }

    function material_list($id) {
        $query = $this->db->query
                ('
                    SELECT
                        m.*
                    FROM
                        material m
                        , supplier s
                    WHERE
                        material_status = 1
                        AND m.supplier_id = s.supplier_id
                        AND s.outlet_id = ' . $id
		);

        return $query->result_array();
    }

    function process($a) {
    	$mi = explode(";", $a['storage_id']);

        if ($a['distribution_id'] == '') {
            $aa = $this->db->query
                    ('
                        SELECT
                            storage_id
                            , material_id
                        FROM
                            tmp_distribution_storage
                        WHERE
                            storage_id = ' . $mi[0] . '
                            AND material_id = ' . $a['material']
            );
//                             material_id = ' . $a['material_id']

            $id = ($aa->num_rows() == 0) ? NULL : $aa->row()->storage_id;
            $id2 = ($aa->num_rows() == 0) ? NULL : $aa->row()->material_id;

            if ($id == NULL && $id2 == NULL) {
                $query = $this->db->query
                        ('
                            INSERT INTO tmp_distribution_storage VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $a['material'] . '
                                , ' . $mi[0] . '
                                , ' . $a['amount'] . '
                            )
                        ');
//                                 , ' . $a['material_id'] . '
            } else {
                $query = $this->db->query
                        ('
                            UPDATE tmp_distribution_storage SET
                                amount = amount + ' . $a['amount'] . '
                            WHERE
								storage_id = ' . $mi[0] . '
								AND material_id = ' . $a['material']
                );
//                                 material_id = ' . $a['material_id']
            }
        } else {
            $query = $this->db->query
                    ('
                        UPDATE tmp_distribution_storage SET
                            amount = ' . $a['amount'] . '
                        WHERE
                            tmp_distribution_storage = ' . $a['distribution_id']
            );
        }

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete($id) {
        $query = $this->db->query
                ('
                    DELETE FROM
                        tmp_distribution_storage
                    WHERE
                        tmp_distribution_storage = ' . $id
        );

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function save() {
        $this->db->trans_start();
        $this->db->query
                ('
                    INSERT INTO storage_distribution VALUES
                    (
                        ' . "'" . "'" . '
                        , NOW()
                        , ' . $this->session->userdata('user_id') . '
                    )
                ');
        $aa = $this->db->query
                ('
                    SELECT
                        storage_distribution_id
                    FROM
                        storage_distribution
                    ORDER BY
                        storage_distribution_id DESC
                    LIMIT 1
                ');
        $id = $aa->row()->storage_distribution_id;

        $bb = $this->db->query
                ('
                    SELECT
                        material_id
                        , storage_id
                        , amount
                    FROM
                        tmp_distribution_storage
                ');
        $list = $bb->result_array();

        foreach ($list as $l) {
            $this->db->query
                    ('
                        INSERT INTO storage_distribution_details VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . $id . '
                            , ' . $l['material_id'] . '
                            , ' . $l['storage_id'] . '
                            , ' . $l['amount'] . '
                        )
                    ');

            $this->db->query
                    ('
                        UPDATE storage SET
                            amount = amount - ' . $l['amount'] . '
                        WHERE
                            storage_id = ' . $l['storage_id']
                    );
        }


        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            $this->db->query
                    ('
                        DELETE FROM tmp_distribution_storage
                    ');
            return TRUE;
        } else {
            $this->db->trans_rollback();
            return FALSE;
        }
    }

}
