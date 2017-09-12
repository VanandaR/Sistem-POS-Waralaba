<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_log extends RAST_Model {

    function get_list() {
        $query = $this->db->query
        ('
                    SELECT
                         l.*
                         , u.user_name
                         , timestampdiff(MINUTE,timestamp,now()) as yanglalu
                    FROM
                        log l, user u
                    WHERE
                        l.user_id=u.user_id
                    order by timestamp desc
         '
        );

        return $query->result_array();
    }

    function get_isi($id) {
        $query = $this->db->query
        ('
                    SELECT
                        *
                    FROM
                        log'
        );

        return $query->result_array();
    }

}
