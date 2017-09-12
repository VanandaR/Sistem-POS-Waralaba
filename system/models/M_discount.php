<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_discount extends RAST_Model {

    function get_list() {
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('        
        SELECT * 
        FROM 
            discount 
            ');
        } else {
            $query = $this->db->query
            ('          SELECT
							m.*
							, supplier_name
							, outlet_name
						FROM
							discount m
							, supplier s
							, outlet o
						WHERE
							discount_status = 1
							AND m.supplier_id = s.supplier_id
							AND s.outlet_id = o.outlet_id
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
                        discount
                    WHERE
                        discount_id = ' . $a
        );

        return $query->result_array();
    }

    function get_product(){
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
							SELECT
								f.*
								, category_name
							FROM
								food_menu f
								, category c
							WHERE
								food_menu_status = 1
								AND f.category_id = c.category_id
								AND c.outlet_id = ' . $this->session->userdata('outlet_id')
            );
        } else {
            $query = $this->db->query
            ('
							SELECT
								f.*
								, category_name
								, outlet_name
							FROM
								food_menu f
								, category c
								, outlet o
							WHERE
								food_menu_status = 1
								AND f.category_id = c.category_id
								AND c.outlet_id = o.outlet_id
			');
        }


        return $query->result_array();
    }
    function get_category(){
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
						SELECT
							*
						FROM
							category
						WHERE
							category_status = 1
							AND outlet_id = ' . $this->session->userdata('outlet_id')
            );
        } else {
            $query = $this->db->query
            ('
						SELECT
							c.*
							, o.outlet_name
						FROM
							category c
							, outlet o
						WHERE
							category_status = 1
							AND c.outlet_id = o.outlet_id
			');
        }

        $hasil = $query->result_array();

//        $i = 0;
//        foreach ($hasil as $h) :
//            $each = $this->list_each_category($hasil[$i]['category_id'], 1);
//            $hasil[$i]['menu_count'] = $each[0]['menu_count'];
//            $i++;
//        endforeach;

        return $hasil;
    }



    function discount_product_list() {
        $query = $this->db->query
        ('
            SELECT 
                dp.*,
                fm.food_menu_name, 
                c.category_name 
            FROM 
                discount_product dp ,
                food_menu fm , 
                category c 
            WHERE 
                dp.discount_product=fm.food_menu_id 
            OR 
                dp.discount_product_category=c.category_id 
            GROUP BY 
                dp.discount_product_id'

        );

        return $query->result_array();
    }
    function discount_type_list() {
        $query = $this->db->query
        ('
            SELECT 
                  *,
                  fm.food_menu_name 
            FROM 
                  discount_type dt,
                  food_menu fm 
            WHERE 
                  dt.discount_id=fm.food_menu_id 
            GROUP by 
                  dt.discount_type_id
            '

        );

        return $query->result_array();
    }

    function process($a) {
        $query = FALSE;
        $from=array();
        if($a['discount_date_from']==""){
            $from =array("00","00","0000");
        }else{
            $from = explode('/', $a['discount_date_from']);
        }
        if($a['discount_date_to']==""){
            $to =array("00","00","0000");
        }else{
            $to = explode('/', $a['discount_date_to']);
        }
        if ($a['discount_id'] == '') {

            $ss = $this->db->query
            ('
                        INSERT INTO discount VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['discount_date_type'] . "'" . '
                            , ' . "'" .$from[2].'-'.$from[0].'-'.$from[1]. "'" . '
                            , ' . "'" .$to[2].'-'.$to[0].'-'.$to[1]. "'" . '
                            , ' . "'" . $a['product_quantity_minimum'] . "'" . '
                            , ' . "'" . $a['product_total_sales_minimum'] . "'" . '
                            , ' . "" . $a['discount_for_member_type'] . "" . '
                            , 1
                        )
                    ');
            $aa = $this->db->query
            ('
                    SELECT
                        discount_id
                    FROM
                        discount
                    ORDER BY
                        discount_id DESC
                    LIMIT 1
                ');
            $id = $aa->row()->discount_id;

            if($a['discount_product_type']==3){
                foreach($a['discount_product_combination'] as $a['discount']){
                    $query = $this->db->query
                    ('
                            INSERT INTO discount_product VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $id . '
                                , ' . "'" . $a['discount_product_type'] . "'" . '
                                , ' . "'" . $a['discount_product_category'] . "'" . '
                                , ' . "'" . $a['discount'] . "'" . '
                            )
                        ');
                }
            }else{
                $query = $this->db->query
                ('
                            INSERT INTO discount_product VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $id . '
                                , ' . "'" . $a['discount_product_type'] . "'" . '
                                , ' . "'" . $a['discount_product_category'] . "'" . '
                                , ' . "'" . $a['discount_product'] . "'" . '
                            )
                        ');
            }

            if($a['discount_type']==1) {
                foreach($a['discount_free_product'] as $a['discount']) {
                    $query = $this->db->query
                    ('
                            INSERT INTO discount_type VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $id . '
                                , ' . "'" . $a['discount_type'] . "'" . '
                                , ' . "'" . $a['discount'] . "'" . '
                                , ' . "'" . $a['discount_percent'] . "'" . '
                                , ' . "'" . $a['discount_nominal'] . "'" . '
                            )
                        ');
                }
            }else{
                $query = $this->db->query
                ('
                            INSERT INTO discount_type VALUES
                            (
                                ' . "'" . "'" . '
                                , ' . $id . '
                                , ' . "'" . $a['discount_type'] . "'" . '
                                , ' . "'" . $a['discount_free_product'] . "'" . '
                                , ' . "'" . $a['discount_percent'] . "'" . '
                                , ' . "'" . $a['discount_nominal'] . "'" . '
                            )
                        ');
            }
        } else {
            $query = $this->db->query
            ('
						UPDATE discount SET
    						discount_date_type = ' . "'" . $a['discount_date_type'] . "'" . '
                            , discount_date_from = ' . "'" . $a['discount_date_from'] . "'" . '
                            , discount_date_to = ' . "'" . $a['discount_date_to'] . "'" . '
                            , discount_product_type = ' . "'" . $a['discount_product_type'] . "'" . '
                            , discount_product_category = ' . "'" . $a['discount_product_category'] . "'" . '
                            , discount_product = ' . "'" . $a['discount_product'] . "'" . '
                            , product_quantity_minimum = ' . "'" . $a['product_quantity_minimum'] . "'" . '
                            , product_total_sales_minimum = ' . "'" . $a['product_total_sales_minimum'] . "'" . '
                            , discount_type = ' . "'" . $a['discount_type'] . "'" . '
                            , discount_free_product = ' . "'" . $a['discount_free_product'] . "'" . '
                            , discount_percent = ' . "'" . $a['discount_percent'] . "'" . '
                            , discount_nominal = ' . "'" . $a['discount_nominal'] . "'" . '
                            , discount_for_member_type = ' . "'" . $a['discount_for_member_type'] . "'" . '
						WHERE
							discount_id = ' . $a['discount_id']
            );
        }


        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function discount_product($a) {
        $query = FALSE;
        if ($a['discount_id'] == '') {

            $query = $this->db->query
            ('
                        INSERT INTO discount_product VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['discount_id'] . "'" . '
                            , ' . "'" . $a['discount_product_type'] . "'" . '
                            , ' . "'" . $a['discount_product_category'] . "'" . '
                            , ' . "'" . $a['discount_product'] . "'" . '
                            , ' . "'" . $a['product_quantity_minimum'] . "'" . '
                            , ' . "'" . $a['product_total_sales_minimum'] . "'" . '
                            , ' . "'" . $a['discount_type'] . "'" . '
                            , ' . "'" . $a['discount_free_product'] . "'" . '
                            , ' . "'" . $a['discount_percent'] . "'" . '
                            , ' . "'" . $a['discount_nominal'] . "'" . '
                            , ' . "" . $a['discount_for_member_type'] . "" . '
                            , 1
                        )
                    ');
        } else {
            $query = $this->db->query
            ('
						UPDATE discount SET
    						discount_date_type = ' . "'" . $a['discount_date_type'] . "'" . '
                            , discount_date_from = ' . "'" . $a['discount_date_from'] . "'" . '
                            , discount_date_to = ' . "'" . $a['discount_date_to'] . "'" . '
                            , discount_product_type = ' . "'" . $a['discount_product_type'] . "'" . '
                            , discount_product_category = ' . "'" . $a['discount_product_category'] . "'" . '
                            , discount_product = ' . "'" . $a['discount_product'] . "'" . '
                            , product_quantity_minimum = ' . "'" . $a['product_quantity_minimum'] . "'" . '
                            , product_total_sales_minimum = ' . "'" . $a['product_total_sales_minimum'] . "'" . '
                            , discount_type = ' . "'" . $a['discount_type'] . "'" . '
                            , discount_free_product = ' . "'" . $a['discount_free_product'] . "'" . '
                            , discount_percent = ' . "'" . $a['discount_percent'] . "'" . '
                            , discount_nominal = ' . "'" . $a['discount_nominal'] . "'" . '
                            , discount_for_member_type = ' . "'" . $a['discount_for_member_type'] . "'" . '
						WHERE
							discount_id = ' . $a['discount_id']
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
                    UPDATE discount SET
                        discount_status = 0
                    WHERE
                        discount_id = ' . $a
        );

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
