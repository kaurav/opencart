<?php
class ModelCatalogvideo extends Model {
	public function updateViewed($video_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "video SET viewed = (viewed + 1) WHERE video_id = '" . (int)$video_id . "'");
	}

	public function getTotalvideos($data = array()) {
		$sql = "SELECT COUNT(DISTINCT v.video_id) AS total FROM " . DB_PREFIX . "video v LEFT JOIN " . DB_PREFIX . "video_description vd ON (v.video_id = vd.video_id)";

		$sql .= " WHERE vd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND vd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND v.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	public function getvideos($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "video v LEFT JOIN " . DB_PREFIX . "video_description vd ON (v.video_id = vd.video_id) WHERE vd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND vd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND v.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY v.video_id";

		$sort_data = array(
			'vd.title',
			'v.status',
			'v.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vd.title";
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

	public function getvideo($video_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "video v LEFT JOIN " . DB_PREFIX . "video_description vd ON (v.video_id = vd.video_id) WHERE v.video_id = '" . (int)$video_id . "' AND vd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getvideoDescriptions($video_id) {
		$description = array();
		$video = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");
		if($query->num_rows > 0) {
			$video[0]= array(
				'url'             => $query->row['url'],
				'video_id'        => $query->row['video_id'],
				'sort_order'      => $query->row['sort_order'],
			);
		
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
				        
		foreach ($query1->rows as $result) {
			$description[$result['language_id']] = array(
				'description' => $result['description'],
				'title'       => $result['title'],
			);
		}

		$video[0]['description'] = $description;

		}
//print_r($video); die();
		return $video;
	}

public function addvideo($data) {

		$date = date('Y-m-d H:i:s');

		$this->db->query("INSERT INTO " . DB_PREFIX . "video SET 
			url = '" . $this->db->escape($data['url']) . "', 	 
			sort_order = '" . $this->db->escape($data['sort_order']) . "', 
			date_added = '" . $this->db->escape($date) . "', 
			date_modified = '".$this->db->escape($date)."'");

//status = '" . $this->db->escape($data['status']) . "',
		$video_id = $this->db->getLastId();


		foreach ($data['description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."video_description SET video_id  = '" . (int)$video_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '".$this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('video');

		return $video_id;
	}


	public function editvideo($video_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "video SET status = '" . $this->db->escape($data['status']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', date_modified = NOW() WHERE video_id = '" . (int)$video_id . "'");





$this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");

		foreach ($data['description'] as $language_id => $value) {
			#echo "helloooo";
#print_r($data['video_description']);die();

			$this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "',  description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('product');

	}


}