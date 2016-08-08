<?php
class ModelCatalogactivitycategory extends Model {
	public function addactivitycategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$activitycategory_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "activitycategory SET image = '" . $this->db->escape($data['image']) . "' WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		}

		foreach ($data['activitycategory_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_description SET activitycategory_id = '" . (int)$activitycategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "activitycategory_path` SET `activitycategory_id` = '" . (int)$activitycategory_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "activitycategory_path` SET `activitycategory_id` = '" . (int)$activitycategory_id . "', `path_id` = '" . (int)$activitycategory_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['activitycategory_filter'])) {
			foreach ($data['activitycategory_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_filter SET activitycategory_id = '" . (int)$activitycategory_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['activitycategory_store'])) {
			foreach ($data['activitycategory_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_to_store SET activitycategory_id = '" . (int)$activitycategory_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this activitycategory
		if (isset($data['activitycategory_layout'])) {
			foreach ($data['activitycategory_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_to_layout SET activitycategory_id = '" . (int)$activitycategory_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'activitycategory_id=" . (int)$activitycategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('activitycategory');

		return $activitycategory_id;
	}

	public function editactivitycategory($activitycategory_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "activitycategory SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "activitycategory SET image = '" . $this->db->escape($data['image']) . "' WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_description WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		foreach ($data['activitycategory_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_description SET activitycategory_id = '" . (int)$activitycategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "activitycategory_path` WHERE path_id = '" . (int)$activitycategory_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $activitycategory_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$activitycategory_path['activitycategory_id'] . "' AND level < '" . (int)$activitycategory_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$activitycategory_path['activitycategory_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "activitycategory_path` SET activitycategory_id = '" . (int)$activitycategory_path['activitycategory_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "activitycategory_path` SET activitycategory_id = '" . (int)$activitycategory_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "activitycategory_path` SET activitycategory_id = '" . (int)$activitycategory_id . "', `path_id` = '" . (int)$activitycategory_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_filter WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		if (isset($data['activitycategory_filter'])) {
			foreach ($data['activitycategory_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_filter SET activitycategory_id = '" . (int)$activitycategory_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_to_store WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		if (isset($data['activitycategory_store'])) {
			foreach ($data['activitycategory_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_to_store SET activitycategory_id = '" . (int)$activitycategory_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_to_layout WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		if (isset($data['activitycategory_layout'])) {
			foreach ($data['activitycategory_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "activitycategory_to_layout SET activitycategory_id = '" . (int)$activitycategory_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'activitycategory_id=" . (int)$activitycategory_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'activitycategory_id=" . (int)$activitycategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('activitycategory');
	}

	public function deleteactivitycategory($activitycategory_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_path WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activitycategory_path WHERE path_id = '" . (int)$activitycategory_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteactivitycategory($result['activitycategory_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_description WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_filter WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_to_store WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "activitycategory_to_layout WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_activitycategory WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'activitycategory_id=" . (int)$activitycategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_activitycategory WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		$this->cache->delete('activitycategory');
	}

	public function repairactivitycategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activitycategory WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $activitycategory) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$activitycategory['activitycategory_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "activitycategory_path` WHERE activitycategory_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "activitycategory_path` SET activitycategory_id = '" . (int)$activitycategory['activitycategory_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "activitycategory_path` SET activitycategory_id = '" . (int)$activitycategory['activitycategory_id'] . "', `path_id` = '" . (int)$activitycategory['activitycategory_id'] . "', level = '" . (int)$level . "'");

			$this->repairactivitycategories($activitycategory['activitycategory_id']);
		}
	}

	public function getactivitycategory($activitycategory_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "activitycategory_path cp LEFT JOIN " . DB_PREFIX . "activitycategory_description cd1 ON (cp.path_id = cd1.activitycategory_id AND cp.activitycategory_id != cp.path_id) WHERE cp.activitycategory_id = c.activitycategory_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.activitycategory_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'activitycategory_id=" . (int)$activitycategory_id . "') AS keyword FROM " . DB_PREFIX . "activitycategory c LEFT JOIN " . DB_PREFIX . "activitycategory_description cd2 ON (c.activitycategory_id = cd2.activitycategory_id) WHERE c.activitycategory_id = '" . (int)$activitycategory_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getactivitycategories($data = array()) {
		$sql = "SELECT cp.activitycategory_id AS activitycategory_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "activitycategory_path cp LEFT JOIN " . DB_PREFIX . "activitycategory c1 ON (cp.activitycategory_id = c1.activitycategory_id) LEFT JOIN " . DB_PREFIX . "activitycategory c2 ON (cp.path_id = c2.activitycategory_id) LEFT JOIN " . DB_PREFIX . "activitycategory_description cd1 ON (cp.path_id = cd1.activitycategory_id) LEFT JOIN " . DB_PREFIX . "activitycategory_description cd2 ON (cp.activitycategory_id = cd2.activitycategory_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.activitycategory_id";

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

	public function getactivitycategoryDescriptions($activitycategory_id) {
		$activitycategory_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activitycategory_description WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		foreach ($query->rows as $result) {
			$activitycategory_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $activitycategory_description_data;
	}

	public function getactivitycategoryFilters($activitycategory_id) {
		$activitycategory_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activitycategory_filter WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		foreach ($query->rows as $result) {
			$activitycategory_filter_data[] = $result['filter_id'];
		}

		return $activitycategory_filter_data;
	}

	public function getactivitycategoryStores($activitycategory_id) {
		$activitycategory_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activitycategory_to_store WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		foreach ($query->rows as $result) {
			$activitycategory_store_data[] = $result['store_id'];
		}

		return $activitycategory_store_data;
	}

	public function getactivitycategoryLayouts($activitycategory_id) {
		$activitycategory_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "activitycategory_to_layout WHERE activitycategory_id = '" . (int)$activitycategory_id . "'");

		foreach ($query->rows as $result) {
			$activitycategory_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $activitycategory_layout_data;
	}

	public function getTotalactivitycategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "activitycategory");

		return $query->row['total'];
	}
	
	public function getTotalactivitycategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "activitycategory_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
