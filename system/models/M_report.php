<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_report extends RAST_Model {

    function inmaterial_list($from = '', $to = '', $range=0) {
        $from2 = explode('/', $from);
        $to2 = explode('/', $to);

        $a = '';
        if ($range==1){

            $a = " AND DATE(i.inmaterial_date) = CURDATE()";
        }
        if ($from != '') {

            $a = " AND DATE(i.inmaterial_date) BETWEEN '".$from2[2].'-'.$from2[0].'-'.$from2[1]."' AND '".$to2[2].'-'.$to2[0].'-'.$to2[1]."'";
        }

        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
						SELECT
							i.inmaterial_date
							, m.material_name
							, id.amount
							, u.user_name
						FROM
							inmaterial i
							, inmaterial_details id
							, material m
							, user u
						WHERE
							i.inmaterial_id = id.inmaterial_id
							AND id.material_id = m.material_id
							AND i.user_id = u.user_id
							' . $a . '
							AND i.outlet_id = ' . $this->session->userdata('outlet_id') . '
						ORDER BY
							i.inmaterial_date DESC
							, m.material_id ASC
			');
        } else {
            $query = $this->db->query
            ('
						SELECT
							i.inmaterial_date
							, m.material_name
							, id.amount
							, u.user_name
							, o.outlet_name
						FROM
							inmaterial i
							, inmaterial_details id
							, material m
							, user u
							, outlet o
						WHERE
							i.inmaterial_id = id.inmaterial_id
							AND id.material_id = m.material_id
							AND i.user_id = u.user_id
							' . $a . '
							AND i.outlet_id = o.outlet_id
						ORDER BY
							i.inmaterial_date DESC
							, m.material_id ASC
			');
        }

        return $query->result_array();
    }
    function food_menu_list() {
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

    function employee_list() {
        $query = $this->db->query
        ('
                    SELECT
                        user_id
                        , user_name
                    FROM
                        user
                    WHERE
                        level = 1 OR level = 2
                    ORDER BY
                        level DESC
                        , user_id ASC
		');

        return $query->result_array();
    }

    function sales_table_list($from = '', $to = '', $who = '',$member='', $foodmenu='') {

        $a = '';
        $b = '';
        $from2 = explode('/', $from);
        $to2 = explode('/', $to);
        if ($from != '') {

            $a = " AND DATE(s.sales_date) BETWEEN '".$from2[2].'-'.$from2[0].'-'.$from2[1]."' AND '".$to2[2].'-'.$to2[0].'-'.$to2[1]."'";
//            $a = " AND DATE(s.sales_date) BETWEEN '$from' AND '$to'";
        } else {
            $a = " AND DATE(NOW()) = DATE(s.sales_date)";
        }
        if ($who != 0) {
            $b = " AND s.user_id = $who";
        }
        if ($member!=0){
            $b = " AND s.member_id=".$member;
        }
        if ($foodmenu!=0){
            $b = " AND sd.food_menu_id=".$foodmenu;
        }


        if ($this->session->userdata('outlet_id') != 'all') {

            $query = $this->db->query
            ('
						SELECT
							s.sales_date
							, s.kind
							, s.discount
							, s.user_id
							, sd.sales_id
							, sd.amount
							, sd.price
							, sd.commision
							, m.member_name
							, food_menu_name
							, food_menu_price
							, user_name
						FROM
							sales s
							, sales_details sd
							, food_menu fm
							, category c
							, user u
							, member m 
						WHERE
							s.sales_id = sd.sales_id
							AND sd.food_menu_id = fm.food_menu_id
							AND fm.category_id = c.category_id
							AND m.member_id=s.member_id
							AND c.outlet_id = ' . $this->session->userdata('outlet_id') . '
							AND s.user_id = u.user_id
							' . $a . $b . '
						ORDER BY
							s.sales_id ASC
			');
        } else {

            $query = $this->db->query
            ('
						SELECT
							s.sales_date
							, s.kind
							, s.discount
							, s.user_id
							, sd.sales_id
							, sd.amount
							, sd.price
							, sd.commision
							, m.member_name
							, food_menu_name
							, food_menu_price
							, user_name
							, o.outlet_name
						FROM
							sales s
							, sales_details sd
							, food_menu fm
							, category c
							, outlet o
							, user u
							, member m
						WHERE
							s.sales_id = sd.sales_id
							AND sd.food_menu_id = fm.food_menu_id
							AND fm.category_id = c.category_id
							AND c.outlet_id = o.outlet_id
							AND s.user_id = u.user_id
							' . $a . $b . '
						ORDER BY
							s.sales_id ASC
			');
        }

        return $query->result_array();
    }
    function sales_member_list($from = '', $to = '') {
        $a = '';
        $b = '';

        $from2 = explode('/', $from);
        $to2 = explode('/', $to);
        if ($from != '') {
            $a = " AND DATE(s.sales_date) BETWEEN '".$from2[2].'-'.$from2[0].'-'.$from2[1]."' AND '".$to2[2].'-'.$to2[0].'-'.$to2[1]."'";

        } else {
            $a = " AND DATE(NOW()) = DATE(s.sales_date)";
        }
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
						SELECT
							m.member_name 
							, sum(sd.price) as totalbelanja
						FROM
							sales s
							, sales_details sd
							, food_menu fm
							, category c
							, user u
							, outlet o
							, member m 
						WHERE
							s.sales_id = sd.sales_id
							AND sd.food_menu_id = fm.food_menu_id
							AND fm.category_id = c.category_id
							AND m.member_id=s.member_id
							AND c.outlet_id = ' . $this->session->userdata('outlet_id') . '
							AND s.user_id = u.user_id
							' . $a . '
						GROUP BY m.member_id
						ORDER BY totalbelanja desc 
			');
        } else {
            $query = $this->db->query
            ('
						SELECT
							m.member_name 
							, sum(sd.price) as totalbelanja
						FROM
							sales s
							, sales_details sd
							, food_menu fm
							, category c
							, outlet o
							, user u
							, member m 
						WHERE
							s.sales_id = sd.sales_id
							AND sd.food_menu_id = fm.food_menu_id
							AND fm.category_id = c.category_id
							AND m.member_id=s.member_id
							AND c.outlet_id = o.outlet_id
							AND s.user_id = u.user_id
							' . $a . $b . '
						GROUP BY m.member_id
						ORDER BY totalbelanja desc 
			');
        }

        return $query->result_array();
    }
    function sales_produk_list($from = '', $to = '') {
        $a = '';
        $b = '';
        $from2 = explode('/', $from);
        $to2 = explode('/', $to);
        if ($from != '') {
            $a = " AND DATE(s.sales_date) BETWEEN '".$from2[2].'-'.$from2[0].'-'.$from2[1]."' AND '".$to2[2].'-'.$to2[0].'-'.$to2[1]."'";
        } else {
            $a = " AND DATE(NOW()) = DATE(s.sales_date)";
        }
        if ($this->session->userdata('outlet_id') != 'all') {
            $query = $this->db->query
            ('
						SELECT
							fm.food_menu_name
							, sum(sd.price) as totalbelanja
						FROM
							sales s
							, sales_details sd
							, food_menu fm
							, category c
							, user u
							, outlet o
							, member m 
						WHERE
							s.sales_id = sd.sales_id
							AND sd.food_menu_id = fm.food_menu_id
							AND fm.category_id = c.category_id
							AND m.member_id=s.member_id
							AND c.outlet_id = ' . $this->session->userdata('outlet_id') . '
							AND s.user_id = u.user_id
							' . $a . '
						GROUP BY fm.food_menu_id
						ORDER BY totalbelanja desc 
			');
        } else {
            $query = $this->db->query
            ('
						SELECT
							fm.food_menu_name
							, sum(sd.price) as totalbelanja
						FROM
							sales s
							, sales_details sd
							, food_menu fm
							, category c
							, user u
							, outlet o
							, member m 
						WHERE
							s.sales_id = sd.sales_id
							AND sd.food_menu_id = fm.food_menu_id
							AND fm.category_id = c.category_id
							AND m.member_id=s.member_id
							AND c.outlet_id = o.outlet_id
							AND s.user_id = u.user_id
							' . $a . $b . '
						GROUP BY fm.food_menu_id
						ORDER BY totalbelanja desc 
			');
        }

        return $query->result_array();
    }

    function sales_graph($from = '', $to = '') {
        $a = '';
        if ($from != '') {
//            $a = " DATE(c.tanggal) BETWEEN '$from' AND '$to'";
            $a = " DATE(c.tanggal) >= '$from' AND DATE(c.tanggal) <= '$to'";
        } else {
            $a = " MONTH(c.tanggal) = MONTH(NOW())";
        }
        $query = $this->db->query
        ('
                        SELECT
                            c.tanggal AS tanggal
                            , IFNULL(t.totalan, 0) as total
                        FROM
                            calendar c LEFT JOIN
                            (
                                SELECT
                                    DATE(s.sales_date) AS tanggalan
                                    , (
                                        CASE s.kind 
                                            WHEN 1 THEN (SUM(sd.amount * sd.price) - s.discount)
                                            ELSE (SUM(sd.amount * sd.price) - (SUM(sd.amount * sd.price) * s.discount / 100))
                                        END
                                    ) as totalan
                                FROM
                                    sales s
                                    , sales_details sd
                                WHERE
                                    s.sales_id = sd.sales_id
                                GROUP BY
                                    tanggalan
                            ) t
                            ON (c.tanggal = t.tanggalan)
                        WHERE
                            ' . $a . '
                        GROUP BY
                            tanggal
		');

        return $query->result_array();
    }

    function trans_min($from = '') {
        $a = '';
        if ($from != '') {
            $a = " sales_date >= '$from'";
        } else {
            $a = " MONTH(sales_date) = MONTH(NOW())";
        }
        $query = $this->db->query
        ('
                        SELECT
                            MIN(DATE(sales_date)) as tanggal
                        FROM
                            sales
                        WHERE ' . $a
        );

        return $query->row()->tanggal;
    }

    function laba() {
        $query = $this->db->query
        ('
                        SELECT
                            c.tanggal AS tanggal
                            , IFNULL(t.totalan, 0) as total
                        FROM
                            calendar c LEFT JOIN
                            (
                                SELECT
                                    DATE(p.tanggal_penjualan) AS tanggalan
                                    , SUM((pd.harga_jual - br.harga_beli) * pd.jumlah) AS totalan
                                FROM
                                    penjualan p
                                    , penjualan_detail pd
                                    , barang_record br
                                WHERE
                                    p.id_penjualan = pd.id_penjualan
                                    AND pd.id_record = br.id_record
                                GROUP BY
                                    tanggalan
                            ) t
                            ON (c.tanggal = t.tanggalan)
                        WHERE
                            (
                                c.tanggal
                                    BETWEEN 
                                        (SELECT MIN(DATE(tanggal_penjualan)) FROM penjualan)
                                    AND 
                                        (SELECT MAX(DATE(tanggal_penjualan)) FROM penjualan)
                            )
                        GROUP BY
                            tanggal
		');

        return $query->result_array();
    }
}
