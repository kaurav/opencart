<?php
class ModelCataloggallery extends Model {
	public function addgallery($data) {

		print_r($data);die();
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "',  sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$gallery_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "gallery SET image = '" . $this->db->escape($data['image']) . "' WHERE gallery_id = '" . (int)$gallery_id . "'");
		}

		foreach ($data['gallery_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_description SET gallery_id = '" . (int)$gallery_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['gallery_store'])) {
			foreach ($data['gallery_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_store SET gallery_id = '" . (int)$gallery_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['gallery_attribute'])) {
			foreach ($data['gallery_attribute'] as $gallery_attribute) {
				if ($gallery_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "' AND attribute_id = '" . (int)$gallery_attribute['attribute_id'] . "'");

					foreach ($gallery_attribute['gallery_attribute_description'] as $language_id => $gallery_attribute_description) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "' AND attribute_id = '" . (int)$gallery_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");

						$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_attribute SET gallery_id = '" . (int)$gallery_id . "', attribute_id = '" . (int)$gallery_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($gallery_attribute_description['text']) . "'");
					}
				}
			}
		}

		

		
		if (isset($data['gallery_image'])) {
			foreach ($data['gallery_image'] as $gallery_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_image SET gallery_id = '" . (int)$gallery_id . "', image = '" . $this->db->escape($gallery_image['image']) . "', sort_order = '" . (int)$gallery_image['sort_order'] . "'");
			}
		}

		
		if (isset($data['gallery_gallerycategory'])) {
			foreach ($data['gallery_gallerycategory'] as $gallerycategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_gallerycategory SET gallery_id = '" . (int)$gallery_id . "', gallerycategory_id = '" . (int)$gallerycategory_id . "'");
			}
		}

		if (isset($data['gallery_filter'])) {
			foreach ($data['gallery_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_filter SET gallery_id = '" . (int)$gallery_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['gallery_related'])) {
			foreach ($data['gallery_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$gallery_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_related SET gallery_id = '" . (int)$gallery_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$related_id . "' AND related_id = '" . (int)$gallery_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_related SET gallery_id = '" . (int)$related_id . "', related_id = '" . (int)$gallery_id . "'");
			}
		}

		if (isset($data['gallery_layout'])) {
			foreach ($data['gallery_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_layout SET gallery_id = '" . (int)$gallery_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'gallery_id=" . (int)$gallery_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		

		$this->cache->delete('gallery');

		return $gallery_id;
	}

	public function editgallery($gallery_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "gallery SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "',sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "gallery SET image = '" . $this->db->escape($data['image']) . "' WHERE gallery_id = '" . (int)$gallery_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_description WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($data['gallery_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_description SET gallery_id = '" . (int)$gallery_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_store WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (isset($data['gallery_store'])) {
			foreach ($data['gallery_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_store SET gallery_id = '" . (int)$gallery_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (!empty($data['gallery_attribute'])) {
			foreach ($data['gallery_attribute'] as $gallery_attribute) {
				if ($gallery_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "' AND attribute_id = '" . (int)$gallery_attribute['attribute_id'] . "'");

					foreach ($gallery_attribute['gallery_attribute_description'] as $language_id => $gallery_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_attribute SET gallery_id = '" . (int)$gallery_id . "', attribute_id = '" . (int)$gallery_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($gallery_attribute_description['text']) . "'");
					}
				}
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_image WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (isset($data['gallery_image'])) {
			foreach ($data['gallery_image'] as $gallery_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_image SET gallery_id = '" . (int)$gallery_id . "', image = '" . $this->db->escape($gallery_image['image']) . "', sort_order = '" . (int)$gallery_image['sort_order'] . "'");
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_gallerycategory WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (isset($data['gallery_gallerycategory'])) {
			foreach ($data['gallery_gallerycategory'] as $gallerycategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_gallerycategory SET gallery_id = '" . (int)$gallery_id . "', gallerycategory_id = '" . (int)$gallerycategory_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_filter WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (isset($data['gallery_filter'])) {
			foreach ($data['gallery_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_filter SET gallery_id = '" . (int)$gallery_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$gallery_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE related_id = '" . (int)$gallery_id . "'");

		if (isset($data['gallery_related'])) {
			foreach ($data['gallery_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$gallery_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_related SET gallery_id = '" . (int)$gallery_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$related_id . "' AND related_id = '" . (int)$gallery_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_related SET gallery_id = '" . (int)$related_id . "', related_id = '" . (int)$gallery_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_layout WHERE gallery_id = '" . (int)$gallery_id . "'");

		if (isset($data['gallery_layout'])) {
			foreach ($data['gallery_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_layout SET gallery_id = '" . (int)$gallery_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'gallery_id=" . (int)$gallery_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'gallery_id=" . (int)$gallery_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('gallery');
	}

	

	public function deletegallery($gallery_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery WHERE gallery_id = '" . (int)$gallery_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_description WHERE gallery_id = '" . (int)$gallery_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_filter WHERE gallery_id = '" . (int)$gallery_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_image WHERE gallery_id = '" . (int)$gallery_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$gallery_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_related WHERE related_id = '" . (int)$gallery_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_gallerycategory WHERE gallery_id = '" . (int)$gallery_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_layout WHERE gallery_id = '" . (int)$gallery_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_store WHERE gallery_id = '" . (int)$gallery_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'gallery_id=" . (int)$gallery_id . "'");
	
		$this->cache->delete('gallery');
	}

	public function getgallery($gallery_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'gallery_id=" . (int)$gallery_id . "') AS keyword FROM " . DB_PREFIX . "gallery p LEFT JOIN " . DB_PREFIX . "gallery_description pd ON (p.gallery_id = pd.gallery_id) WHERE p.gallery_id = '" . (int)$gallery_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getgalleries($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "gallery p LEFT JOIN " . DB_PREFIX . "gallery_description pd ON (p.gallery_id = pd.gallery_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.gallery_id";

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

	public function getgalleriesBygallerycategoryId($gallerycategory_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery p LEFT JOIN " . DB_PREFIX . "gallery_description pd ON (p.gallery_id = pd.gallery_id) LEFT JOIN " . DB_PREFIX . "gallery_to_gallerycategory p2c ON (p.gallery_id = p2c.gallery_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.gallerycategory_id = '" . (int)$gallerycategory_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getgalleryDescriptions($gallery_id) {
		$gallery_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_description WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($query->rows as $result) {
			$gallery_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $gallery_description_data;
	}

	public function getgalleryCategories($gallery_id) {
		$gallery_gallerycategory_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_to_gallerycategory WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($query->rows as $result) {
			$gallery_gallerycategory_data[] = $result['gallerycategory_id'];
		}

		return $gallery_gallerycategory_data;
	}

	public function getgalleryFilters($gallery_id) {
		$gallery_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_filter WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($query->rows as $result) {
			$gallery_filter_data[] = $result['filter_id'];
		}

		return $gallery_filter_data;
	}


	public function getgalleryAttributes($gallery_id) {
		$gallery_attribute_data = array();

		$gallery_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "' GROUP BY attribute_id");

		foreach ($gallery_attribute_query->rows as $gallery_attribute) {
			$gallery_attribute_description_data = array();

			$gallery_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_attribute WHERE gallery_id = '" . (int)$gallery_id . "' AND attribute_id = '" . (int)$gallery_attribute['attribute_id'] . "'");

			foreach ($gallery_attribute_description_query->rows as $gallery_attribute_description) {
				$gallery_attribute_description_data[$gallery_attribute_description['language_id']] = array('text' => $gallery_attribute_description['text']);
			}

			$gallery_attribute_data[] = array(
				'attribute_id'                  => $gallery_attribute['attribute_id'],
				'gallery_attribute_description' => $gallery_attribute_description_data
			);
		}

		return $gallery_attribute_data;
	}


	public function getgalleryImages($gallery_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_image WHERE gallery_id = '" . (int)$gallery_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	
	public function getgalleriestores($gallery_id) {
		$gallery_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_to_store WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($query->rows as $result) {
			$gallery_store_data[] = $result['store_id'];
		}

		return $gallery_store_data;
	}

	public function getgalleryLayouts($gallery_id) {
		$gallery_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_to_layout WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($query->rows as $result) {
			$gallery_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $gallery_layout_data;
	}

	public function getgalleryRelated($gallery_id) {
		$gallery_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_related WHERE gallery_id = '" . (int)$gallery_id . "'");

		foreach ($query->rows as $result) {
			$gallery_related_data[] = $result['related_id'];
		}

		return $gallery_related_data;
	}

	
	public function getTotalgalleries($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.gallery_id) AS total FROM " . DB_PREFIX . "gallery p LEFT JOIN " . DB_PREFIX . "gallery_description pd ON (p.gallery_id = pd.gallery_id)";

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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallery_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
