<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_supplier extends RAST_Model {

    function get_list() {
    	if ($this->session->userdata('outlet_id') != 'all') {
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
		} else {
			$query = $this->db->query
					('
						SELECT
							s.*
							, o.outlet_name
						FROM
							supplier s
							, outlet o
						WHERE
							supplier_status = 1
							AND s.outlet_id = o.outlet_id
			');
		}		

        $hasil = $query->result_array();

        $i = 0;
        foreach ($hasil as $h) :
            $each = $this->list_each_supplier($hasil[$i]['supplier_id'], 0);
            $hasil[$i]['material_count'] = $each[0]['material_count'];
            $i++;
        endforeach;

        return $hasil;
    }

    function list_each_supplier($a, $limit = 0) {
        $query = $this->db->query
                ('
                    SELECT
                        IFNULL(COUNT(material_id), 0) as material_count
                    FROM
                        material
                    WHERE 
                        material_status = 1
                        AND supplier_id  = ' . $a .
					(($limit != 0) ? (' LIMIT ' . $limit) : '')
        );

        return $query->result_array();
    }

    function get_isi($a) {
        $query = $this->db->query
                ('
					SELECT
						*
					FROM
						supplier
					WHERE
						supplier_id = ' . $a
        );

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['supplier_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO supplier VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['supplier_name'] . "'" . '
                            , ' . "'" . $a['supplier_address'] . "'" . '
                            , ' . "'" . $a['supplier_phone'] . "'" . '
                            , ' . $this->session->userdata('outlet_id') . '
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah supplier ".$a['supplier_name'];
        } else {
            $query = $this->db->query
                    ('
						UPDATE supplier SET
                            supplier_name = ' . "'" . $a['supplier_name'] . "'" . '
                            , supplier_address = ' . "'" . $a['supplier_address'] . "'" . '
                            , supplier_phone = ' . "'" . $a['supplier_phone'] . "'" . '
						WHERE
							supplier_id = ' . $a['supplier_id']
                    );
            $deskripsi=$deskripsi."Mengedit supplier ".$a['supplier_name'];
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

    function delete($a) {
        $query = $this->db->query
                ('
					UPDATE supplier SET
						supplier_status = 0
					WHERE
						supplier_id = ' . $a
        );
        $deskripsi="Menghapus supplier dengan ID ".$a;
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
