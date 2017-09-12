<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_material_storage_after extends RAST_Model {

    function get_list() {
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

    function get_isi($a) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        storage
                    WHERE
                        storage_id = ' . $a
        );

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        if ($a['storage_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO storage VALUES
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
						UPDATE storage SET
                            material_name = ' . "'" . $a['material_name'] . "'" . '
                            , units = ' . "'" . $a['units'] . "'" . '
                            , notes = ' . "'" . $a['notes'] . "'" . '
						WHERE
							storage_id = ' . $a['storage_id']
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
                    UPDATE storage SET
                        storage_status = 0
                    WHERE
                        storage_id = ' . $a
        );

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
