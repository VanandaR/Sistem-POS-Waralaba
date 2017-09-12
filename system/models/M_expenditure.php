<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_expenditure extends RAST_Model {

    function get_list() {
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
                        SELECT 
                        
                            e.*
                            , o.outlet_name
                            , u.user_name
                            
                        FROM 
                            expenditure e
                            , user u
                            , outlet_user ou
                            , outlet o
                        WHERE 
                            e.user_id=u.user_id 
                            AND ou.user_id=u.user_id 
                            AND ou.outlet_id= '.$this->session->userdata('outlet_id').'
                            AND e.status=1
                        ORDER BY 
                            timestamp desc'
            );
        } else {
            $query = $this->db->query
            ('
                        SELECT 
                        
                            e.*
                            , o.outlet_name
                            , u.user_name
                            
                        FROM 
                            expenditure e
                            , user u
                            , outlet_user ou
                            , outlet o
                        WHERE 
                            e.user_id=u.user_id 
                            AND ou.user_id=u.user_id 
                            AND ou.outlet_id=o.outlet_id
                        ORDER BY 
                            timestamp desc
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
                        expenditure
                    WHERE
                        expenditure_id = ' . $a
        );

        return $query->result_array();
    }
    function delete($a) {
        $query = $this->db->query
        ('
                    UPDATE expenditure SET
                        status = 0
                    WHERE
                        expenditure_id = ' . $a
        );
        $deskripsi="Menghapus Pengeluaran Dengan ID ".$a;
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


    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['food_menu_id'] == '') {
            $query = $this->db->query
            ('
                        INSERT INTO expenditure VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['expenditure_name'] . "'" . '
                            , ' . "'" . $a['expenditure_price'] . "'" . '
                            , now()
                            , '.$this->session->userdata('user_id').'
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah pengeluaran ".$a['expenditure_name'];
        } else {
            $query = $this->db->query
            ('
			UPDATE expenditure SET
                            expenditure_name = ' . "'" . $a['expenditure_name'] . "'" . '
                            , price = ' . $a['expenditure_price'] . '
                            , timestamp = now()
			WHERE
			    expenditure_id = ' . $a['expenditure_id']
            );
            $deskripsi=$deskripsi."Mengedit pengeluaran ".$a['expenditure_name'];
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


}
