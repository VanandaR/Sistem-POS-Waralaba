<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_member extends RAST_Model {

    function get_list() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        member
                    WHERE
                        member_status = 1
                    ORDER BY
                        member_id asc
		');

        return $query->result_array();
    }

    function get_isi($a) {
        $query = $this->db->query
                ('
			SELECT
                            *
                        FROM
                            member
			WHERE
			    member_id = ' . $a
        );

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['member_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO member VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['member_card'] . "'" . '
                            , ' . "'" . $a['member_name'] . "'" . '
                            , ' . "'" . $a['member_address'] . "'" . '
                            , ' . "'" . $a['member_id_card'] . "'" . '
                            , ' . "'" . $a['member_phone'] . "'" . '
                            , ' . "'" . $a['member_mail'] . "'" . '
                            , ' . "'" . $a['member_wa'] . "'" . '
                            , ' . "'" . $a['member_bbm'] . "'" . '
                            , ' . "'" . $a['member_instagram'] . "'" . '
                            , ' . "'" . $a['member_facebook'] . "'" . '
                            , ' . "'" . $a['member_twitter'] . "'" . '
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah member ".$a['member_name'];
        } else {
            $query = $this->db->query
                    ('
			UPDATE member SET
                            member_card = ' . "'" . $a['member_card'] . "'" . '
                            , member_name = ' . "'" . $a['member_name'] . "'" . '
                            , member_address = ' . "'" . $a['member_address'] . "'" . '
                            , member_id_card = ' . "'" . $a['member_id_card'] . "'" . '
                            , member_phone = ' . "'" . $a['member_phone'] . "'" . '
                            , member_mail = ' . "'" . $a['member_mail'] . "'" . '
                            , member_wa = ' . "'" . $a['member_wa'] . "'" . '
                            , member_bbm = ' . "'" . $a['member_bbm'] . "'" . '
                            , member_instagram = ' . "'" . $a['member_instagram'] . "'" . '
                            , member_facebook = ' . "'" . $a['member_facebook'] . "'" . '
                            , member_twitter = ' . "'" . $a['member_twitter '] . "'" . '
			WHERE
			    member_id = ' . $a['member_id']
            );
            $deskripsi=$deskripsi."Mengedit member ".$a['member_name'];

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
                    UPDATE member SET
                        member_status = 0
                    WHERE
                        member_id = ' . $a
        );
        $deskripsi="Menghapus member dengan ID ".$a;
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
