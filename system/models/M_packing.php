<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_packing extends RAST_Model {

    function get_list() {
        $query = $this->db->query
                ('
                    SELECT
                        ti.*
                        , m1.material_name AS material_name_pra
                        , m2.material_name AS material_name_after
                    FROM
                        tmp_production_storage ti
                        , storage_pra m1
                        , storage m2
                    WHERE
                        ti.storage_pra_id = m1.storage_pra_id
                        AND ti.storage_id = m2.storage_id
		');

        return $query->result_array();
    }

    function get_isi($id) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        tmp_production_storage
                    WHERE
                        tmp_production_storage = ' . $id
        );

        return $query->result_array();
    }

    function material_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        storage_pra
                    WHERE
                        storage_pra_status = 1
		');

        return $query->result_array();
    }

    function material2_list() {
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

    function process($a) {
    	$mi = explode(";", $a['storage_pra_id']);
    	$mi2 = explode(";", $a['storage_id']);
//     	print_r($mi);
//         if ($mi[0] == '') {
        if ($a['production_storage_id'] == '') {
            $aa = $this->db->query
                    ('
                        SELECT
                            storage_pra_id
                            , storage_id
                        FROM
                            tmp_production_storage
                        WHERE
                            storage_pra_id = ' . $mi[0] . '
                            AND storage_id = ' . $mi2[0]
            );
//                             material_id = ' . $a['material_id']

            $id = ($aa->num_rows() == 0) ? NULL : $aa->row()->storage_pra_id;
            $id2 = ($aa->num_rows() == 0) ? NULL : $aa->row()->storage_id;

            if ($id == NULL && $id2 == NULL) {
                $query = $this->db->query
                        ('
                            INSERT INTO tmp_production_storage VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $mi[0] . '
                                , ' . $a['amount'] . '
                                , ' . $mi2[0] . '
                                , ' . $a['amount_storage'] . '
                            )
                        ');
//                                 , ' . $a['material_id'] . '
            } else {
                $query = $this->db->query
                        ('
                            UPDATE tmp_production_storage SET
                                amount = amount + ' . $a['amount'] . '
                                amount_storage = amount_storage + ' . $a['amount_storage'] . '
                            WHERE
                                storage_pra_id = ' . $mi[0] . '
								AND storage_id = ' . $mi2[0]
                );
//                                 material_id = ' . $a['material_id']
            }
        } else {
            $query = $this->db->query
                    ('
                        UPDATE tmp_production_storage SET
                            amount = ' . $a['amount'] . '
                            , amount_storage = ' . $a['amount_storage'] . '
                        WHERE
                            tmp_production_storage = ' . $a['production_storage_id']
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
                        tmp_production_storage
                    WHERE
                        tmp_production_storage = ' . $id
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
                    INSERT INTO storage_production VALUES
                    (
                        ' . "'" . "'" . '
                        , NOW()
                        , ' . $this->session->userdata('user_id') . '
                    )
                ');
        $aa = $this->db->query
                ('
                    SELECT
                        storage_production_id
                    FROM
                        storage_production
                    ORDER BY
                        storage_production_id DESC
                    LIMIT 1
                ');
        $id = $aa->row()->storage_production_id;

        $bb = $this->db->query
                ('
                    SELECT
                        storage_pra_id
                        , amount
                        , storage_id
                        , amount_storage
                    FROM
                        tmp_production_storage
                ');
        $list = $bb->result_array();

        foreach ($list as $l) {
            $this->db->query
                    ('
                        INSERT INTO storage_production_details VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . $id . '
                            , ' . $l['storage_id'] . '
                            , ' . $l['amount_storage'] . '
                            , ' . $l['storage_pra_id'] . '
                            , ' . $l['amount'] . '
                        )
                    ');

            $this->db->query
                    ('
                        UPDATE storage_pra SET
                            amount = amount - ' . $l['amount'] . '
                        WHERE
                            storage_pra_id = ' . $l['storage_pra_id']
                    );

            $this->db->query
                    ('
                        UPDATE storage SET
                            amount = amount + ' . $l['amount_storage'] . '
                        WHERE
                            storage_id = ' . $l['storage_id']
                    );
        }


        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            $this->db->query
                    ('
                        DELETE FROM tmp_production_storage
                    ');
            return TRUE;
        } else {
            $this->db->trans_rollback();
            return FALSE;
        }
    }

}
