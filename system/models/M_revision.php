<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_revision extends RAST_Model {

    function get_list() {
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
                        SELECT 
                            r.* 
                            , m.material_name
                            , s.supplier_name
                            , s.outlet_id 
                            
                        FROM 
                            revision r 
                            , material m 
                            , supplier s 
                        WHERE 
                            r.material_id=m.material_id 
                            AND m.supplier_id = s.supplier_id 
                            AND s.outlet_id= '.$this->session->userdata('outlet_id').'
                        ORDER BY 
                            timestamp desc'
            );
        } else {
            $query = $this->db->query
            ('
                        SELECT 
                            r.* 
                            , m.material_name
                            , s.supplier_name
                            , s.outlet_id
                            , o.outlet_name
                        FROM 
                            revision r 
                            , material m 
                            , supplier s 
                            , outlet o
                        WHERE 
                            r.material_id=m.material_id 
                            AND m.supplier_id = s.supplier_id 
                            AND s.outlet_id=o.outlet_id 
                        ORDER BY 
                            timestamp desc
			');
        }

        return $query->result_array();
    }


}
