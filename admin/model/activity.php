<?php
class ModelCatalogactivity extends Model {
	public function addactivity($data) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "',  sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$activity_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "activity SET image = '" . $this->db->escape($data['image']) . "' WHERE activity_id = '" . (int)$activity_id . "'");
		}

		foreach ($data['activity_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "activity_description SET activity_id = '" . (int)$activity_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['activity_store'])) {
			foreach ($data['activity_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_to_store SET activity_id = '" . (int)$activity_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['activity_attribute'])) {
			foreach ($data['activity_attribute'] as $activity_attribute) {
				if ($activity_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "' AND attribute_id = '" . (int)$activity_attribute['attribute_id'] . "'");

					foreach ($activity_attribute['activity_attribute_description'] as $language_id => $activity_attribute_description) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "' AND attribute_id = '" . (int)$activity_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");

						$this->db->query("INSERT INTO " . DB_PREFIX . "activity_attribute SET activity_id = '" . (int)$activity_id . "', attribute_id = '" . (int)$activity_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($activity_attribute_description['text']) . "'");
					}
				}
			}
		}

		

		
		if (isset($data['activity_image'])) {
			foreach ($data['activity_image'] as $activity_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_image SET activity_id = '" . (int)$activity_id . "', image = '" . $this->db->escape($activity_image['image']) . "', sort_order = '" . (int)$activity_image['sort_order'] . "'");
			}
		}

		
		if (isset($data['activity_activitycategory'])) {
			foreach ($data['activity_activitycategory'] as $activitycategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_to_activitycategory SET activity_id = '" . (int)$activity_id . "', activitycategory_id = '" . (int)$activitycategory_id . "'");
			}
		}

		if (isset($data['activity_filter'])) {
			foreach ($data['activity_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_filter SET activity_id = '" . (int)$activity_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['activity_related'])) {
			foreach ($data['activity_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$activity_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_related SET activity_id = '" . (int)$activity_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$related_id . "' AND related_id = '" . (int)$activity_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_related SET activity_id = '" . (int)$related_id . "', related_id = '" . (int)$activity_id . "'");
			}
		}

		if (isset($data['activity_layout'])) {
			foreach ($data['activity_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_to_layout SET activity_id = '" . (int)$activity_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'activity_id=" . (int)$activity_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		

		$this->cache->delete('activity');

		return $activity_id;
	}

	public function editactivity($activity_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "activity SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "',sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE activity_id = '" . (int)$activity_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "activity SET image = '" . $this->db->escape($data['image']) . "' WHERE activity_id = '" . (int)$activity_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_description WHERE activity_id = '" . (int)$activity_id . "'");

		foreach ($data['activity_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "activity_description SET activity_id = '" . (int)$activity_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_to_store WHERE activity_id = '" . (int)$activity_id . "'");

		if (isset($data['activity_store'])) {
			foreach ($data['activity_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_to_store SET activity_id = '" . (int)$activity_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "'");

		if (!empty($data['activity_attribute'])) {
			foreach ($data['activity_attribute'] as $activity_attribute) {
				if ($activity_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "' AND attribute_id = '" . (int)$activity_attribute['attribute_id'] . "'");

					foreach ($activity_attribute['activity_attribute_description'] as $language_id => $activity_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "activity_attribute SET activity_id = '" . (int)$activity_id . "', attribute_id = '" . (int)$activity_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($activity_attribute_description['text']) . "'");
					}
				}
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_image WHERE activity_id = '" . (int)$activity_id . "'");

		if (isset($data['activity_image'])) {
			foreach ($data['activity_image'] as $activity_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_image SET activity_id = '" . (int)$activity_id . "', image = '" . $this->db->escape($activity_image['image']) . "', sort_order = '" . (int)$activity_image['sort_order'] . "'");
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_to_activitycategory WHERE activity_id = '" . (int)$activity_id . "'");

		if (isset($data['activity_activitycategory'])) {
			foreach ($data['activity_activitycategory'] as $activitycategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_to_activitycategory SET activity_id = '" . (int)$activity_id . "', activitycategory_id = '" . (int)$activitycategory_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$activity_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE related_id = '" . (int)$activity_id . "'");

		if (isset($data['activity_related'])) {
			foreach ($data['activity_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$activity_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_related SET activity_id = '" . (int)$activity_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$related_id . "' AND related_id = '" . (int)$activity_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_related SET activity_id = '" . (int)$related_id . "', related_id = '" . (int)$activity_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_to_layout WHERE activity_id = '" . (int)$activity_id . "'");

		if (isset($data['activity_layout'])) {
			foreach ($data['activity_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activity_to_layout SET activity_id = '" . (int)$activity_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'activity_id=" . (int)$activity_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'activity_id=" . (int)$activity_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('activity');
	}

	

	public function deleteactivity($activity_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity WHERE activity_id = '" . (int)$activity_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_description WHERE activity_id = '" . (int)$activity_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_image WHERE activity_id = '" . (int)$activity_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$activity_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_related WHERE related_id = '" . (int)$activity_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_to_activitycategory WHERE activity_id = '" . (int)$activity_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_to_layout WHERE activity_id = '" . (int)$activity_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activity_to_store WHERE activity_id = '" . (int)$activity_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'activity_id=" . (int)$activity_id . "'");
	
		$this->cache->delete('activity');
	}

	public function getactivity($activity_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'activity_id=" . (int)$activity_id . "') AS keyword FROM " . DB_PREFIX . "activity p LEFT JOIN " . DB_PREFIX . "activity_description pd ON (p.activity_id = pd.activity_id) WHERE p.activity_id = '" . (int)$activity_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getactivities($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "activity p LEFT JOIN " . DB_PREFIX . "activity_description pd ON (p.activity_id = pd.activity_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.activity_id";

		$sort_data = array(
			'pd.name',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getactivitiesByactivitycategoryId($activitycategory_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity p LEFT JOIN " . DB_PREFIX . "activity_description pd ON (p.activity_id = pd.activity_id) LEFT JOIN " . DB_PREFIX . "activity_to_activitycategory p2c ON (p.activity_id = p2c.activity_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.activitycategory_id = '" . (int)$activitycategory_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getactivityDescriptions($activity_id) {
		$activity_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_description WHERE activity_id = '" . (int)$activity_id . "'");

		foreach ($query->rows as $result) {
			$activity_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $activity_description_data;
	}

	public function getactivityCategories($activity_id) {
		$activity_activitycategory_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_to_activitycategory WHERE activity_id = '" . (int)$activity_id . "'");

		foreach ($query->rows as $result) {
			$activity_activitycategory_data[] = $result['activitycategory_id'];
		}

		return $activity_activitycategory_data;
	}


	// public function getactivityAttributes($activity_id) {
	// 	$activity_attribute_data = array();

	// 	$activity_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "' GROUP BY attribute_id");

	// 	foreach ($activity_attribute_query->rows as $activity_attribute) {
	// 		$activity_attribute_description_data = array();

	// 		$activity_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_attribute WHERE activity_id = '" . (int)$activity_id . "' AND attribute_id = '" . (int)$activity_attribute['attribute_id'] . "'");

	// 		foreach ($activity_attribute_description_query->rows as $activity_attribute_description) {
	// 			$activity_attribute_description_data[$activity_attribute_description['language_id']] = array('text' => $activity_attribute_description['text']);
	// 		}

	// 		$activity_attribute_data[] = array(
	// 			'attribute_id'                  => $activity_attribute['attribute_id'],
	// 			'activity_attribute_description' => $activity_attribute_description_data
	// 		);
	// 	}

	// 	return $activity_attribute_data;
	// }
	


	public function getactivityImages($activity_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_image WHERE activity_id = '" . (int)$activity_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	
	public function getactivitiestores($activity_id) {
		$activity_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_to_store WHERE activity_id = '" . (int)$activity_id . "'");

		foreach ($query->rows as $result) {
			$activity_store_data[] = $result['store_id'];
		}

		return $activity_store_data;
	}

	public function getactivityLayouts($activity_id) {
		$activity_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_to_layout WHERE activity_id = '" . (int)$activity_id . "'");

		foreach ($query->rows as $result) {
			$activity_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $activity_layout_data;
	}

	public function getactivityRelated($activity_id) {
		$activity_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activity_related WHERE activity_id = '" . (int)$activity_id . "'");

		foreach ($query->rows as $result) {
			$activity_related_data[] = $result['related_id'];
		}

		return $activity_related_data;
	}

	
	public function getTotalactivities($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.activity_id) AS total FROM " . DB_PREFIX . "activity p LEFT JOIN " . DB_PREFIX . "activity_description pd ON (p.activity_id = pd.activity_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalactivitiesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "activity_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
