<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_inmaterial_storage extends RAST_Model {

    function get_list() {
        $query = $this->db->query
                ('
                    SELECT
                        ti.*
                        , material_name
                    FROM
                        tmp_inmaterial_storage ti
                        , storage_pra m
                    WHERE
                        ti.storage_pra_id = m.storage_pra_id
		');

        return $query->result_array();
    }

    function get_isi($id) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        tmp_inmaterial_storage
                    WHERE
                        tmp_inmaterial_storage = ' . $id
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

    function process($a) {
    	$mi = explode(";", $a['storage_pra_id']);
//     	print_r($mi);
//         if ($mi[0] == '') {
        if ($a['inmaterial_storage_id'] == '') {
            $aa = $this->db->query
                    ('
                        SELECT
                            storage_pra_id
                        FROM
                            tmp_inmaterial_storage
                        WHERE
                            storage_pra_id = ' . $mi[0]
            );
//                             material_id = ' . $a['material_id']

            $id = ($aa->num_rows() == 0) ? NULL : $aa->row()->storage_pra_id;

            if ($id == NULL) {
                $query = $this->db->query
                        ('
                            INSERT INTO tmp_inmaterial_storage VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $mi[0] . '
                                , ' . $a['amount'] . '
                            )
                        ');
//                                 , ' . $a['material_id'] . '
            } else {
                $query = $this->db->query
                        ('
                            UPDATE tmp_inmaterial_storage SET
                                amount = amount + ' . $a['amount'] . '
                            WHERE
                                storage_pra_id = ' . $mi[0]
                );
//                                 material_id = ' . $a['material_id']
            }
        } else {
            $query = $this->db->query
                    ('
                        UPDATE tmp_inmaterial_storage SET
                            amount = ' . $a['amount'] . '
                        WHERE
                            tmp_inmaterial_storage = ' . $a['inmaterial_storage_id']
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
                        tmp_inmaterial_storage
                    WHERE
                        tmp_inmaterial_storage = ' . $id
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
                    INSERT INTO inmaterial_storage VALUES
                    (
                        ' . "'" . "'" . '
                        , NOW()
                        , ' . $this->session->userdata('user_id') . '
                    )
                ');
        $aa = $this->db->query
                ('
                    SELECT
                        inmaterial_storage_id
                    FROM
                        inmaterial_storage
                    ORDER BY
                        inmaterial_storage_id DESC
                    LIMIT 1
                ');
        $id = $aa->row()->inmaterial_storage_id;

        $bb = $this->db->query
                ('
                    SELECT
                        storage_pra_id
                        , amount
                    FROM
                        tmp_inmaterial_storage
                ');
        $list = $bb->result_array();

        foreach ($list as $l) {
            $this->db->query
                    ('
                        INSERT INTO inmaterial_storage_details VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . $id . '
                            , ' . $l['storage_pra_id'] . '
                            , ' . $l['amount'] . '
                        )
                    ');

            $this->db->query
                    ('
                        UPDATE storage_pra SET
                            amount = amount + ' . $l['amount'] . '
                        WHERE
                            storage_pra_id = ' . $l['storage_pra_id']
                    );
        }


        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            $this->db->query
                    ('
                        DELETE FROM tmp_inmaterial_storage
                    ');
            return TRUE;
        } else {
            $this->db->trans_rollback();
            return FALSE;
        }
    }

}
