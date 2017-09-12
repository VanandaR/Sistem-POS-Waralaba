<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_login extends RAST_Model {

    function login($u, $p) {
        $query = $this->db->query
                ('
					SELECT
						user_id
						, user_name
						, level
					FROM
						user
					WHERE
						username = "' . $u . '"
						AND password = "' . md5($p) . '"
						AND user_status = 1
		');
        
        if ($query->num_rows() == 1 && $query->row()->level > 0) {
            $this->session->set_userdata('user_id', $query->row()->user_id);
            $this->session->set_userdata('user_name', $query->row()->user_name);
            $this->session->set_userdata('level', $query->row()->level);
            
			$query2 = $this->db->query
					('
						SELECT
							ou.outlet_id
							, o.outlet_name
						FROM
							outlet_user ou
							, outlet o
						WHERE
							o.outlet_id = ou.outlet_id
							AND ou.user_id = "' . $this->session->userdata('user_id') . '"
			');

            $this->session->set_userdata('list_outlet', $query2->result_array());
            $deskripsi="Login";
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
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getUser() {
        if ($this->session->userdata('user_id') != FALSE && $this->session->userdata('level') > 0) {
            return $this->session->userdata('level');
        } else {
            return NULL;
        }
    }
}
