<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_user extends RAST_Model {

    function get_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        user
                    WHERE
                        user_status = 1
                    ORDER BY
                        level asc
		');


        return $query->result_array();
    }

    function get_isi($a) {
        $query = $this->db->query
                ('
			SELECT
                            *
                        FROM
                            user
			WHERE
			    user_id = ' . $a
        );

        return $query->result_array();
    }

    function changePassword_process($post) {
        $aa = $this->db->query
                ('
			SELECT
                            password
                        FROM
                            user
			WHERE
			    user_id = ' . $this->session->userdata('user_id')
        );

        $op = $aa->row()->password;

        $query = FALSE;
        if ($op == md5($post['old_password'])) {
            $query = $this->db->query
                    ('
			UPDATE user SET
                            password = ' . "MD5('" . $post['new_password'] . "')" . '
			WHERE
			    user_id = ' . $this->session->userdata('user_id')
            );
        }

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['user_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO user VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['username'] . "'" . '
                            , ' . "MD5('" . $a['password'] . "')" . '
                            , ' . "'" . $a['user_name'] . "'" . '
                            , ' . "'" . $a['user_address'] . "'" . '
                            , ' . "'" . $a['user_id_card'] . "'" . '
                            , ' . "'" . $a['user_phone'] . "'" . '
                            , ' . "'" . $a['user_procentase'] . "'" . '
                            , ' . "'" . $a['level'] . "'" . '
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah user ".$a['user_name'];
        } else {
            $query = $this->db->query
                    ('
						UPDATE user SET
                            username = ' . "'" . $a['username'] . "'" . '
                            ' . (($a['password'] != '') ? (', password = ' . "MD5('" . $a['password'] . "')") : '') . '
                            , user_name = ' . "'" . $a['user_name'] . "'" . '
                            , user_address = ' . "'" . $a['user_address'] . "'" . '
                            , user_id_card = ' . "'" . $a['user_id_card'] . "'" . '
                            , user_phone = ' . "'" . $a['user_phone'] . "'" . '
                            , user_procentase = ' . "'" . $a['user_procentase'] . "'" . '
                            , level = ' . "'" . $a['level'] . "'" . '
						WHERE
							user_id = ' . $a['user_id']
            );
            $deskripsi=$deskripsi."Mengedit user ".$a['user_name'];
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

    function outlet_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        outlet
                    WHERE
                        outlet_status = 1
		');

        return $query->result_array();
    }

    function user_name($user_id) {
        $query = $this->db->query
                ('
                    SELECT
                        user_name
                    FROM
                        user
                    WHERE
                        user_id = ' . $user_id . '
                        AND user_status = 1
                    LIMIT 1
		');

        return $query->row()->user_name;
    }

    function get_user_outlet_list($user_id) {
        $query = $this->db->query
                ('
                    SELECT
                        ou.outlet_user_id
                        , u.user_name
                        , o.outlet_name
                    FROM
                    	outlet o
                        , outlet_user ou
                        , user u
                    WHERE
                        ou.user_id = ' . $user_id . '
                        AND ou.user_id = u.user_id
                        AND ou.outlet_id = o.outlet_id
                        AND user_status = 1
		');

        return $query->result_array();
    }

    function process_outlet($a, $kind) {
        $query = FALSE;
        if ($kind == 'process') {
            $query = $this->db->query
                    ('
                        INSERT INTO outlet_user VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['outlet_id'] . "'" . '
                            , ' . "'" . $a['user_id'] . "'" . '
                        )
                    ');
        } else if ($kind == 'delete') {
            $query = $this->db->query
                    ('
                        DELETE FROM outlet_user
                        WHERE outlet_user_id = ' . $a
            );
        } else {
            return FALSE;
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
                    UPDATE user SET
                        user_status = 0
                    WHERE
                        user_id = ' . $a
        );
        $deskripsi="Menghapus user dengan ID ".$a;
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
