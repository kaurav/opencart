<?php
class ModelCatalogsikhethehas extends Model {


	public function getevents($data = array()) {
		// echo "hiii";die();
		$query1 = "SELECT sd.name, s.sikhethehas_id, s.date_available from ".DB_PREFIX."sikhethehas s LEFT JOIN ". DB_PREFIX ."sikhethehas_description sd ON (s.sikhethehas_id = sd.sikhethehas_id) LEFT JOIN ".DB_PREFIX."sikhethehas_to_store s2s ON (s.sikhethehas_id = s2s.sikhethehas_id) where sd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND s.status= '1'";
		
		if(!empty($data['day']) && !empty($data['month'])) {
		 $query1 .= " AND date_format(s.date_available, '%d-%c') = '". $data["day"] ."-".$data["month"] . "' ";
		}

		//echo $query1; die();

		return $this->db->query($query1);
		
	}
	public function getsikhethehas($sikhethehas_id) {
		$query = $this->db->query("SELECT DISTINCT *, sd.name AS name, s.image, s.sort_order FROM " . DB_PREFIX . "sikhethehas s LEFT JOIN " . DB_PREFIX . "sikhethehas_description sd ON (s.sikhethehas_id = sd.sikhethehas_id) LEFT JOIN " . DB_PREFIX . "sikhethehas_to_store p2s ON (s.sikhethehas_id = p2s.sikhethehas_id)  WHERE s.sikhethehas_id = '" . (int)$sikhethehas_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND s.status = '1' AND s.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'sikhethehas_id'       => $query->row['sikhethehas_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],			
				'image'            => $query->row['image'],
				
				'date_available'   => $query->row['date_available'],
				
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				
			);
		} else {
			return false;
		}
	}

	public function getsikhethehasImages($sikhethehas_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sikhethehas_image WHERE sikhethehas_id = '" . (int)$sikhethehas_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}


	public function getsikhethehasRelated($sikhethehas_id) {
		$sikhethehas_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sikhethehas_related pr LEFT JOIN " . DB_PREFIX . "sikhethehas s ON (pr.related_id = s.sikhethehas_id) LEFT JOIN " . DB_PREFIX . "sikhethehas_to_store p2s ON (s.sikhethehas_id = p2s.sikhethehas_id) WHERE pr.sikhethehas_id = '" . (int)$sikhethehas_id . "' AND s.status = '1' AND s.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			//print_r($result);die();
			$sikhethehas_data[$result['related_id']] = $this->getsikhethehas($result['related_id']);
		}

		return $sikhethehas_data;
	}

	public function getsikhethehass($data = array()) {
		$sql = "SELECT s.sikhethehas_id";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "sikhethehas_to_category p2c ON (cs.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "sikhethehas_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "sikhethehas_filter pf ON (p2c.sikhethehas_id = pf.sikhethehas_id) LEFT JOIN " . DB_PREFIX . "sikhethehas s ON (pf.sikhethehas_id = s.sikhethehas_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "sikhethehas s ON (p2c.sikhethehas_id = s.sikhethehas_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "sikhethehas s";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "sikhethehas_description sd ON (s.sikhethehas_id = sd.sikhethehas_id) LEFT JOIN " . DB_PREFIX . "sikhethehas_to_store p2s ON (s.sikhethehas_id = p2s.sikhethehas_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND s.status = '1' AND s.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cs.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "sd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR sd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "sd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			

			$sql .= ")";
		}


		$sql .= " GROUP BY s.sikhethehas_id";

		$sort_data = array(
			'sd.name',
			's.sort_order',
			's.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'sd.name') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY s.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(sd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(sd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$sikhethehas_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$sikhethehas_data[$result['sikhethehas_id']] = $this->getsikhethehas($result['sikhethehas_id']);
		}

		return $sikhethehas_data;
	}

	public function getTotalsikhethehass($data = array()) {
		$sql = "SELECT COUNT(DISTINCT s.sikhethehas_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "sikhethehas_to_category p2c ON (cs.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "sikhethehas_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "sikhethehas_filter pf ON (p2c.sikhethehas_id = pf.sikhethehas_id) LEFT JOIN " . DB_PREFIX . "sikhethehas s ON (pf.sikhethehas_id = s.sikhethehas_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "sikhethehas s ON (p2c.sikhethehas_id = s.sikhethehas_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "sikhethehas s";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "sikhethehas_description sd ON (s.sikhethehas_id = sd.sikhethehas_id) LEFT JOIN " . DB_PREFIX . "sikhethehas_to_store p2s ON (s.sikhethehas_id = p2s.sikhethehas_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND s.status = '1' AND s.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cs.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "sd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR sd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "sd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
			}

			
			$sql .= ")";
		}

		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

}
?>