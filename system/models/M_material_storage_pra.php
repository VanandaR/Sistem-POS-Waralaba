<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_material_storage_pra extends RAST_Model {

    function get_list() {
		$query = $this->db->query
				('
					SELECT
						*
					FROM
						storage_pra m
					WHERE
						storage_pra_status = 1
		');

        return $query->result_array();
    }

    function get_isi($a) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        storage_pra
                    WHERE
                        storage_pra_id = ' . $a
        );

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        if ($a['storage_pra_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO storage_pra VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['material_name'] . "'" . '
                            , 0
                            , ' . "'" . $a['units'] . "'" . '
                            , ' . "'" . $a['notes'] . "'" . '
                            , 1
                        )
                    ');
        } else {
            $query = $this->db->query
                    ('
						UPDATE storage_pra SET
                            material_name = ' . "'" . $a['material_name'] . "'" . '
                            , units = ' . "'" . $a['units'] . "'" . '
                            , notes = ' . "'" . $a['notes'] . "'" . '
						WHERE
							storage_pra_id = ' . $a['storage_pra_id']
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
                    UPDATE storage_pra SET
                        storage_pra_status = 0
                    WHERE
                        storage_pra_id = ' . $a
        );

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
