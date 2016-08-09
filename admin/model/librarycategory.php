<?php
class ModelCataloglibrarycategory extends Model {
	public function addlibrarycategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$librarycategory_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "librarycategory SET image = '" . $this->db->escape($data['image']) . "' WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		}

		foreach ($data['librarycategory_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_description SET librarycategory_id = '" . (int)$librarycategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "librarycategory_path` SET `librarycategory_id` = '" . (int)$librarycategory_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "librarycategory_path` SET `librarycategory_id` = '" . (int)$librarycategory_id . "', `path_id` = '" . (int)$librarycategory_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['librarycategory_filter'])) {
			foreach ($data['librarycategory_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_filter SET librarycategory_id = '" . (int)$librarycategory_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['librarycategory_store'])) {
			foreach ($data['librarycategory_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_to_store SET librarycategory_id = '" . (int)$librarycategory_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this librarycategory
		if (isset($data['librarycategory_layout'])) {
			foreach ($data['librarycategory_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_to_layout SET librarycategory_id = '" . (int)$librarycategory_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'librarycategory_id=" . (int)$librarycategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('librarycategory');

		return $librarycategory_id;
	}

	public function editlibrarycategory($librarycategory_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "librarycategory SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "librarycategory SET image = '" . $this->db->escape($data['image']) . "' WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_description WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		foreach ($data['librarycategory_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_description SET librarycategory_id = '" . (int)$librarycategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "librarycategory_path` WHERE path_id = '" . (int)$librarycategory_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $librarycategory_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$librarycategory_path['librarycategory_id'] . "' AND level < '" . (int)$librarycategory_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$librarycategory_path['librarycategory_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "librarycategory_path` SET librarycategory_id = '" . (int)$librarycategory_path['librarycategory_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "librarycategory_path` SET librarycategory_id = '" . (int)$librarycategory_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "librarycategory_path` SET librarycategory_id = '" . (int)$librarycategory_id . "', `path_id` = '" . (int)$librarycategory_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_filter WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		if (isset($data['librarycategory_filter'])) {
			foreach ($data['librarycategory_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_filter SET librarycategory_id = '" . (int)$librarycategory_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_to_store WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		if (isset($data['librarycategory_store'])) {
			foreach ($data['librarycategory_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_to_store SET librarycategory_id = '" . (int)$librarycategory_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_to_layout WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		if (isset($data['librarycategory_layout'])) {
			foreach ($data['librarycategory_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "librarycategory_to_layout SET librarycategory_id = '" . (int)$librarycategory_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'librarycategory_id=" . (int)$librarycategory_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'librarycategory_id=" . (int)$librarycategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('librarycategory');
	}

	public function deletelibrarycategory($librarycategory_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_path WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "librarycategory_path WHERE path_id = '" . (int)$librarycategory_id . "'");

		foreach ($query->rows as $result) {
			$this->deletelibrarycategory($result['librarycategory_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_description WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_filter WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_to_store WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "librarycategory_to_layout WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_librarycategory WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'librarycategory_id=" . (int)$librarycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_librarycategory WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		$this->cache->delete('librarycategory');
	}

	public function repairlibrarycategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "librarycategory WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $librarycategory) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$librarycategory['librarycategory_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "librarycategory_path` WHERE librarycategory_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "librarycategory_path` SET librarycategory_id = '" . (int)$librarycategory['librarycategory_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "librarycategory_path` SET librarycategory_id = '" . (int)$librarycategory['librarycategory_id'] . "', `path_id` = '" . (int)$librarycategory['librarycategory_id'] . "', level = '" . (int)$level . "'");

			$this->repairlibrarycategories($librarycategory['librarycategory_id']);
		}
	}

	public function getlibrarycategory($librarycategory_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "librarycategory_path cp LEFT JOIN " . DB_PREFIX . "librarycategory_description cd1 ON (cp.path_id = cd1.librarycategory_id AND cp.librarycategory_id != cp.path_id) WHERE cp.librarycategory_id = c.librarycategory_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.librarycategory_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'librarycategory_id=" . (int)$librarycategory_id . "') AS keyword FROM " . DB_PREFIX . "librarycategory c LEFT JOIN " . DB_PREFIX . "librarycategory_description cd2 ON (c.librarycategory_id = cd2.librarycategory_id) WHERE c.librarycategory_id = '" . (int)$librarycategory_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getlibrarycategories($data = array()) {
		$sql = "SELECT cp.librarycategory_id AS librarycategory_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "librarycategory_path cp LEFT JOIN " . DB_PREFIX . "librarycategory c1 ON (cp.librarycategory_id = c1.librarycategory_id) LEFT JOIN " . DB_PREFIX . "librarycategory c2 ON (cp.path_id = c2.librarycategory_id) LEFT JOIN " . DB_PREFIX . "librarycategory_description cd1 ON (cp.path_id = cd1.librarycategory_id) LEFT JOIN " . DB_PREFIX . "librarycategory_description cd2 ON (cp.librarycategory_id = cd2.librarycategory_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.librarycategory_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getlibrarycategoryDescriptions($librarycategory_id) {
		$librarycategory_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "librarycategory_description WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		foreach ($query->rows as $result) {
			$librarycategory_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $librarycategory_description_data;
	}

	public function getlibrarycategoryFilters($librarycategory_id) {
		$librarycategory_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "librarycategory_filter WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		foreach ($query->rows as $result) {
			$librarycategory_filter_data[] = $result['filter_id'];
		}

		return $librarycategory_filter_data;
	}

	public function getlibrarycategoryStores($librarycategory_id) {
		$librarycategory_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "librarycategory_to_store WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		foreach ($query->rows as $result) {
			$librarycategory_store_data[] = $result['store_id'];
		}

		return $librarycategory_store_data;
	}

	public function getlibrarycategoryLayouts($librarycategory_id) {
		$librarycategory_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "librarycategory_to_layout WHERE librarycategory_id = '" . (int)$librarycategory_id . "'");

		foreach ($query->rows as $result) {
			$librarycategory_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $librarycategory_layout_data;
	}

	public function getTotallibrarycategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "librarycategory");

		return $query->row['total'];
	}
	
	public function getTotallibrarycategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "librarycategory_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
