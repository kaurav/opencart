<?php
class ModelCataloglibrary extends Model {
	public function addlibrary($data) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "',  sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$library_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "library SET image = '" . $this->db->escape($data['image']) . "' WHERE library_id = '" . (int)$library_id . "'");
		}

		foreach ($data['library_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "library_description SET library_id = '" . (int)$library_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['library_store'])) {
			foreach ($data['library_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_to_store SET library_id = '" . (int)$library_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['library_attribute'])) {
			foreach ($data['library_attribute'] as $library_attribute) {
				if ($library_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "' AND attribute_id = '" . (int)$library_attribute['attribute_id'] . "'");

					foreach ($library_attribute['library_attribute_description'] as $language_id => $library_attribute_description) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "' AND attribute_id = '" . (int)$library_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");

						$this->db->query("INSERT INTO " . DB_PREFIX . "library_attribute SET library_id = '" . (int)$library_id . "', attribute_id = '" . (int)$library_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($library_attribute_description['text']) . "'");
					}
				}
			}
		}

		

		
		if (isset($data['library_image'])) {
			foreach ($data['library_image'] as $library_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_image SET library_id = '" . (int)$library_id . "', image = '" . $this->db->escape($library_image['image']) . "', sort_order = '" . (int)$library_image['sort_order'] . "'");
			}
		}

		
		if (isset($data['library_librarycategory'])) {
			foreach ($data['library_librarycategory'] as $librarycategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_to_librarycategory SET library_id = '" . (int)$library_id . "', librarycategory_id = '" . (int)$librarycategory_id . "'");
			}
		}

		if (isset($data['library_filter'])) {
			foreach ($data['library_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_filter SET library_id = '" . (int)$library_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['library_related'])) {
			foreach ($data['library_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$library_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_related SET library_id = '" . (int)$library_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$related_id . "' AND related_id = '" . (int)$library_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_related SET library_id = '" . (int)$related_id . "', related_id = '" . (int)$library_id . "'");
			}
		}

		if (isset($data['library_layout'])) {
			foreach ($data['library_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_to_layout SET library_id = '" . (int)$library_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'library_id=" . (int)$library_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		

		$this->cache->delete('library');

		return $library_id;
	}

	public function editlibrary($library_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "library SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "',sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE library_id = '" . (int)$library_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "library SET image = '" . $this->db->escape($data['image']) . "' WHERE library_id = '" . (int)$library_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "library_description WHERE library_id = '" . (int)$library_id . "'");

		foreach ($data['library_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "library_description SET library_id = '" . (int)$library_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "library_to_store WHERE library_id = '" . (int)$library_id . "'");

		if (isset($data['library_store'])) {
			foreach ($data['library_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_to_store SET library_id = '" . (int)$library_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "'");

		if (!empty($data['library_attribute'])) {
			foreach ($data['library_attribute'] as $library_attribute) {
				if ($library_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "' AND attribute_id = '" . (int)$library_attribute['attribute_id'] . "'");

					foreach ($library_attribute['library_attribute_description'] as $language_id => $library_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "library_attribute SET library_id = '" . (int)$library_id . "', attribute_id = '" . (int)$library_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($library_attribute_description['text']) . "'");
					}
				}
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "library_image WHERE library_id = '" . (int)$library_id . "'");

		if (isset($data['library_image'])) {
			foreach ($data['library_image'] as $library_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_image SET library_id = '" . (int)$library_id . "', image = '" . $this->db->escape($library_image['image']) . "', sort_order = '" . (int)$library_image['sort_order'] . "'");
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "library_to_librarycategory WHERE library_id = '" . (int)$library_id . "'");

		if (isset($data['library_librarycategory'])) {
			foreach ($data['library_librarycategory'] as $librarycategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_to_librarycategory SET library_id = '" . (int)$library_id . "', librarycategory_id = '" . (int)$librarycategory_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$library_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE related_id = '" . (int)$library_id . "'");

		if (isset($data['library_related'])) {
			foreach ($data['library_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$library_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_related SET library_id = '" . (int)$library_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$related_id . "' AND related_id = '" . (int)$library_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_related SET library_id = '" . (int)$related_id . "', related_id = '" . (int)$library_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "library_to_layout WHERE library_id = '" . (int)$library_id . "'");

		if (isset($data['library_layout'])) {
			foreach ($data['library_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "library_to_layout SET library_id = '" . (int)$library_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'library_id=" . (int)$library_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'library_id=" . (int)$library_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('library');
	}

	

	public function deletelibrary($library_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "library WHERE library_id = '" . (int)$library_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_description WHERE library_id = '" . (int)$library_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_image WHERE library_id = '" . (int)$library_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$library_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_related WHERE related_id = '" . (int)$library_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_to_librarycategory WHERE library_id = '" . (int)$library_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_to_layout WHERE library_id = '" . (int)$library_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "library_to_store WHERE library_id = '" . (int)$library_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'library_id=" . (int)$library_id . "'");
	
		$this->cache->delete('library');
	}

	public function getlibrary($library_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'library_id=" . (int)$library_id . "') AS keyword FROM " . DB_PREFIX . "library p LEFT JOIN " . DB_PREFIX . "library_description pd ON (p.library_id = pd.library_id) WHERE p.library_id = '" . (int)$library_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getgalleries($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "library p LEFT JOIN " . DB_PREFIX . "library_description pd ON (p.library_id = pd.library_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.library_id";

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

	public function getgalleriesBylibrarycategoryId($librarycategory_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library p LEFT JOIN " . DB_PREFIX . "library_description pd ON (p.library_id = pd.library_id) LEFT JOIN " . DB_PREFIX . "library_to_librarycategory p2c ON (p.library_id = p2c.library_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.librarycategory_id = '" . (int)$librarycategory_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getlibraryDescriptions($library_id) {
		$library_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_description WHERE library_id = '" . (int)$library_id . "'");

		foreach ($query->rows as $result) {
			$library_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $library_description_data;
	}

	public function getlibraryCategories($library_id) {
		$library_librarycategory_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_to_librarycategory WHERE library_id = '" . (int)$library_id . "'");

		foreach ($query->rows as $result) {
			$library_librarycategory_data[] = $result['librarycategory_id'];
		}

		return $library_librarycategory_data;
	}


	public function getlibraryAttributes($library_id) {
		$library_attribute_data = array();

		$library_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "' GROUP BY attribute_id");

		foreach ($library_attribute_query->rows as $library_attribute) {
			$library_attribute_description_data = array();

			$library_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_attribute WHERE library_id = '" . (int)$library_id . "' AND attribute_id = '" . (int)$library_attribute['attribute_id'] . "'");

			foreach ($library_attribute_description_query->rows as $library_attribute_description) {
				$library_attribute_description_data[$library_attribute_description['language_id']] = array('text' => $library_attribute_description['text']);
			}

			$library_attribute_data[] = array(
				'attribute_id'                  => $library_attribute['attribute_id'],
				'library_attribute_description' => $library_attribute_description_data
			);
		}

		return $library_attribute_data;
	}


	public function getlibraryImages($library_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_image WHERE library_id = '" . (int)$library_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	
	public function getgalleriestores($library_id) {
		$library_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_to_store WHERE library_id = '" . (int)$library_id . "'");

		foreach ($query->rows as $result) {
			$library_store_data[] = $result['store_id'];
		}

		return $library_store_data;
	}

	public function getlibraryLayouts($library_id) {
		$library_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_to_layout WHERE library_id = '" . (int)$library_id . "'");

		foreach ($query->rows as $result) {
			$library_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $library_layout_data;
	}

	public function getlibraryRelated($library_id) {
		$library_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "library_related WHERE library_id = '" . (int)$library_id . "'");

		foreach ($query->rows as $result) {
			$library_related_data[] = $result['related_id'];
		}

		return $library_related_data;
	}

	
	public function getTotalgalleries($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.library_id) AS total FROM " . DB_PREFIX . "library p LEFT JOIN " . DB_PREFIX . "library_description pd ON (p.library_id = pd.library_id)";

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

	public function getTotalgalleriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "library_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
