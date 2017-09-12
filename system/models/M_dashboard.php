<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_dashboard extends RAST_Model {

    function getPenjualan() {
        $query = NULL;
        if ($this->session->userdata('level') == 1) {
            $query = $this->db->query
                    ('
                        SELECT
                            SUM(IFNULL(t.totalan, 0)) as total
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
                            MONTH(c.tanggal) = MONTH(NOW())
                    ');
//                            c.tanggal >= DATE(DATE_SUB(NOW(),INTERVAL 7 DAY))
            return $query->row()->total;
        } else if ($this->session->userdata('level') == 2) {
            $query = $this->db->query
                    ('
                        SELECT
                            SUM(IFNULL(t.totalan, 0)) as total
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
                                    s.user_id = ' . $this->session->userdata('user_id') . '
                                    AND s.sales_id = sd.sales_id
                                GROUP BY
                                    tanggalan
                            ) t
                            ON (c.tanggal = t.tanggalan)
                        WHERE
                            c.tanggal = DATE(NOW())
                    ');
            return $query->row()->total;
        }
    }

    function getBagi() {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        user
                    WHERE
                        level = 4
                        AND user_status = 1
		');

        return $query->result_array();
    }

    function getOutlet() {
        $query = $this->db->query
                ('
                    SELECT
                            SUM(IFNULL(t.totalan, 0)) as total
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
                            c.tanggal = DATE(NOW())
		');

        return $query->row()->total;
    }

    function getTransaksi() {
        $query = $this->db->query
                ('
			SELECT
                            COUNT(s.sales_id) as jumlah
                        FROM
                            sales s
                        WHERE
                            MONTH(s.sales_date) = MONTH(NOW())
		');
//                            DATE(s.sales_date) >= DATE(DATE_SUB(NOW(),INTERVAL 7 DAY))

        return $query->row()->jumlah;
    }
    
    function getKomisi() {
        $query = $this->db->query
                ('
                    SELECT
                        SUM(sd.commision) AS komisi
                    FROM
                        sales s
                        , sales_details sd
                        , food_menu fm
                        , user u
                    WHERE
                        s.sales_id = sd.sales_id
                        AND sd.food_menu_id = fm.food_menu_id
                        AND s.user_id = u.user_id
                        AND MONTH(NOW()) = MONTH(s.sales_date)
                        AND s.user_id = ' . $this->session->userdata('user_id') . '
                    ORDER BY
                        s.sales_id ASC
		');

        return $query->row()->komisi;
    }
}
