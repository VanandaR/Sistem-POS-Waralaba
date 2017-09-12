<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_category extends RAST_Model {

    function get_list() {
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

        $i = 0;
        foreach ($hasil as $h) :
            $each = $this->list_each_category($hasil[$i]['category_id'], 1);
            $hasil[$i]['menu_count'] = $each[0]['menu_count'];
            $i++;
        endforeach;

        return $hasil;
    }

    function list_each_category($a, $limit = 0) {
        $query = $this->db->query
                ('
                    SELECT
                        *, IFNULL(COUNT(food_menu_id), 0) as menu_count
                    FROM
                        food_menu
                    WHERE 
                        food_menu_status = 1 
                        AND category_id  = ' . $a .
                    (($limit != 0) ? (' LIMIT ' . $limit) : '')
                );

        return $query->result_array();
    }
    
    function get_isi($a) {
        $query = $this->db->query
                ('
                    SELECT
                        *
                    FROM
                        category
                    WHERE
                        category_id = ' . $a
                );
        if ($query->num_rows == 0) {
            $this->session->set_userdata('category_id', NULL);
            return NULL;
        } else {
            return $query->result_array();
        }
    }

    function process($a) {
        $query = FALSE;
        $deskripsi="";
        if ($a['category_id'] == '') {
            $query = $this->db->query
                    ('
                        INSERT INTO category VALUES
                        (
                            ' . "'" . "'" . '
                            , ' . "'" . $a['category_name'] . "'" . '
                            , ' . $this->session->userdata('outlet_id') . '
                            , 1
                        )
                    ');
            $deskripsi=$deskripsi."Menambah Kategori ".$a['category_name'];
        } else {
            $query = $this->db->query
                    ('
						UPDATE category SET
                            category_name = ' . "'" . $a['category_name'] . "'" . '
						WHERE
                            category_status = 1
							AND category_id = ' . $a['category_id']
                    );
            $deskripsi=$deskripsi."Mengedit Kategori ".$a['category_name'];
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
                    UPDATE category SET
                        category_status = 0
                    WHERE
                        category_id = ' . $a
                );
        $deskripsi="Menghapus Kategori Dengan ID ".$a;
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

    function kategori_produk($a, $b) {
        $query = $this->db->query
                ('
                        SELECT
                            *
                        FROM
                            barang
                        WHERE
                            status_barang = 1
                            AND id_kategori = ' . $a
        );
        $hasil = $query->result_array();

        $i = 0;
        foreach ($hasil as $h) :
            $jual = $this->kategori_jual($hasil[$i]['id_barang'], $b);
            $hasil[$i]['jual'] = $jual;
            $i++;
        endforeach;

        return $hasil;
    }

    function kategori_jual($a, $b) {
        $query = $this->db->query
                ('
                        SELECT
                                SUM(jumlah) as jual
                        FROM
                                penjualan pen
                                , penjualan_detail pend
                        WHERE 
                                pend.id_penjualan = pen.id_penjualan
                                AND pen.tanggal_penjualan >= DATE(DATE_SUB(NOW(),INTERVAL ' . $b . '))
                                AND pend.id_barang  = ' . $a . '
                        GROUP BY 
                                pend.id_barang
		');

        if ($query->num_rows() != 0) {
            return $query->row()->jual;
        } else {
            return 0;
        }
    }

    function nama_kategori($a) {
        $query = $this->db->query
                ('
			SELECT
				nama_kategori
			FROM
				kategori
			WHERE
				id_kategori = ' . $a . '
                                AND status_kategori = 1
		');

        return $query->row()->nama_kategori;
    }
}
