<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_inmaterial extends RAST_Model {

    function get_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        tmp_inmaterial ti
                        , material m
                    WHERE
                        ti.material_id = m.material_id
						AND outlet_id = ' . $this->session->userdata('outlet_id')
		);

        return $query->result_array();
    }

    function get_isi($id) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        tmp_inmaterial
                    WHERE
                        tmp_inmaterial = ' . $id
        );

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

    function process($a) {
    	$mi = explode(";", $a['material_id']);
    	print_r($mi);
//         if ($mi[0] == '') {
        if ($a['inmaterial_id'] == '') {
            $aa = $this->db->query
                    ('
                        SELECT
                            material_id
                        FROM
                            tmp_inmaterial
                        WHERE
                            material_id = ' . $mi[0]
            );
//                             material_id = ' . $a['material_id']

            $id = ($aa->num_rows() == 0) ? NULL : $aa->row()->material_id;

            if ($id == NULL) {
                $query = $this->db->query
                        ('
                            INSERT INTO tmp_inmaterial VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $mi[0] . '
                                , ' . $a['amount'] . '
								, ' . $this->session->userdata('outlet_id') . '

                            )
                        ');
//                                 , ' . $a['material_id'] . '
            } else {
                $query = $this->db->query
                        ('
                            UPDATE tmp_inmaterial SET
                                amount = ' . $a['amount'] . '
                            WHERE
                                material_id = ' . $mi[0]
                );
//                                 material_id = ' . $a['material_id']
            }
        } else {
            $query = $this->db->query
                    ('
                        UPDATE tmp_inmaterial SET
                            amount = ' . $a['amount'] . '
                        WHERE
                            tmp_inmaterial = ' . $a['inmaterial_id']
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
                        tmp_inmaterial
                    WHERE
                        tmp_inmaterial = ' . $id
        );
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
    function tmp_inmaterial(){
        $query = $this->db->query
        ('
                    SELECT
                        material_id
                        , amount
                    FROM
                        tmp_inmaterial
                    WHERE
                    	outlet_id = ' . $this->session->userdata('outlet_id')
        );
        return $query->result_array();
    }

    function save() {
        $this->db->trans_start();
        $this->db->query
                ('
                    INSERT INTO inmaterial VALUES
                    (
                        ' . "'" . "'" . '
                        , NOW()
                        , ' . $this->session->userdata('user_id') . '
						, ' . $this->session->userdata('outlet_id') . '
                    )
                ');
        $aa = $this->db->query
                ('
                    SELECT
                        inmaterial_id
                    FROM
                        inmaterial
                    ORDER BY
                        inmaterial_id DESC
                    LIMIT 1
                ');
        $id = $aa->row()->inmaterial_id;

        $bb = $this->db->query
                ('
                    SELECT
                        material_id
                        , amount
                    FROM
                        tmp_inmaterial
                    WHERE
                    	outlet_id = ' . $this->session->userdata('outlet_id')
                );
        $list = $bb->result_array();

        foreach ($list as $l) {
            $this->db->query
                    ('
                        INSERT INTO inmaterial_details VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . $id . '
                            , ' . $l['material_id'] . '
                            , ' . $l['amount'] . '
                        )
                    ');

            $this->db->query
                    ('
                        UPDATE material SET
                            stock = stock + ' . $l['amount'] . '
                        WHERE
                            material_id = ' . $l['material_id']
                    );
        }


        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            $this->db->query
                    ('
                        DELETE FROM tmp_inmaterial
                    ');
            return TRUE;
        } else {
            $this->db->trans_rollback();
            return FALSE;
        }
    }

}
