<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_sales extends RAST_Model {

    function food_menu_list() {
        $query = $this->db->query
                ('
                    SELECT
                        fm.*
                        , c.category_id
                        , category_name
                    FROM
                        food_menu fm
                        , category c
                    WHERE
                        fm.category_id = c.category_id
                        AND c.outlet_id = ' . $this->session->userdata('outlet_id') . '
                        AND food_menu_status = 1
                    ORDER BY
                        c.category_id ASC
                        , fm.food_menu_id ASC
		');
//                        , fm.food_menu_name ASC

        return $query->result_array();
    }
    function get_discount($id_makanan){
        $query = $this->db->query
        ('
                    SELECT 
                          * 
                    FROM 
                          discount d, 
                          discount_product dp, 
                          discount_type dt 
                    WHERE 
                          d.discount_id=dp.discount_id 
                          and dp.discount_product in ('.$id_makanan.') 
                          and discount_product_type = 2
                          and dt.discount_id=dp.discount_id
		');
//                        , fm.food_menu_name ASC

        return $query->result_array();
    }

    function member_list() {
        $query = $this->db->query
                ('
                    SELECT
                        member_id
                        , member_card
                        , member_name
                    FROM
                        member m
                    WHERE
                        member_status = 1
                    ORDER BY
                        member_id ASC
		');

        return $query->result_array();
    }

    function delete($id) {
        $query = $this->db->query
                ('
                    DELETE FROM
                        tmp_sales
                    WHERE
                        tmp_sales = ' . $id
		);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function save($post) {
        $l = $post;
        if ($this->session->userdata('user_id') == '' || $this->session->userdata('user_id') == NULL) {
            return FALSE;
        } else if ($l["total_items"] == 0) {
            return FALSE;
        }


        $this->db->trans_start();
        if($l['member']!=''){
            $ss = $this->db->query
            ('
                    INSERT INTO sales VALUES
                    (
                        ' . "'" . "'" . '
                        , NOW()
                        ,'. $l["member"].'
                        , 1
                        , 0
                        , ' . $this->session->userdata('user_id') . '
                    )
                ');
        } else{
            $ss = $this->db->query
            ('
                    INSERT INTO sales VALUES
                    (
                        ' . "'" . "'" . '
                        , NOW()
                        , NULL
                        , 1
                        , 0
                        , ' . $this->session->userdata('user_id') . '
                    )
                ');
        }


//                        , ' . "'" . $post['dtv'] . "'" . '
        $aa = $this->db->query
                ('
                    SELECT
                        sales_id
                    FROM
                        sales
                    ORDER BY
                        sales_id DESC
                    LIMIT 1
                ');
        $id = $aa->row()->sales_id;
        $this->session->set_userdata('sales_id_print', $id);

        $deskripsi="Menjual :";
        $totalharga=0;
        for ($i = 0, $mx = count($l['food']); $i < $mx; $i++) {
            if ($l['food'][$i][3] > 0) {
                $cc = $this->db->query
                        ('
                            SELECT
                                material_id
                                , amount
                            FROM
                                food_menu_material
                            WHERE
                                food_menu_id = ' . $l['food'][$i][0]
                        );
                $matt = $cc->result_array();

                foreach ($matt as $m) {
                    $this->db->query
                            ('
                                UPDATE material SET
                                    stock = stock - ' . ($m['amount'] * $l['food'][$i][3]) . '
                                WHERE
                                    material_id = ' . $m['material_id'] . ';
                            ');
                }

                $this->db->query
                        ('
                            INSERT INTO sales_details VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $id . '
                                , ' . $l['food'][$i][0] . '
                                , ' . $l['food'][$i][3] . '
                                , ' . $l['food'][$i][1] . '
                                , ' . $l['food'][$i][2] . '
                            )
                        ');
                $totalharga+=$l['food'][$i][1];
                $deskripsi=$deskripsi." ".$i.". ".$l['food'][$i][4];
            }
        }
        $deskripsi=$deskripsi.". Dengan total harga : Rp".$totalharga;
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

        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
            return FALSE;
        }
    }
}
