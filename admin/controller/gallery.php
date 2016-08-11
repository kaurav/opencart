<?php
class ControllerCataloggallery extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/gallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallery');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/gallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_gallery->addgallery($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/gallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_gallery->editgallery($this->request->get['gallery_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}


			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/gallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallery');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $gallery_id) {
				$this->model_catalog_gallery->deletegallery($gallery_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}


	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'gd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/gallery/add', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['delete'] = $this->url->link('catalog/gallery/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['galleries'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$gallery_total = $this->model_catalog_gallery->getTotalgalleries($filter_data);

		$results = $this->model_catalog_gallery->getgalleries($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			
			$data['galleries'][] = array(
				'gallery_id' => $result['gallery_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/gallery/edit', 'token=' . $this->session->data['token'] . '&gallery_id=' . $result['gallery_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}


		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . '&sort=gd.name' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . '&sort=g.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . '&sort=g.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $gallery_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($gallery_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($gallery_total - $this->config->get('config_limit_admin'))) ? $gallery_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $gallery_total, ceil($gallery_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/gallery_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['gallery_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		
		$data['text_select'] = $this->language->get('text_select');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_additional_image'] = $this->language->get('entry_additional_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_gallerycategory'] = $this->language->get('entry_gallerycategory');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_text'] = $this->language->get('entry_text');

		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['entry_tag'] = $this->language->get('entry_tag');
		
		$data['entry_layout'] = $this->language->get('entry_layout');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_gallerycategory'] = $this->language->get('help_gallerycategory');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_design'] = $this->language->get('tab_design');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}


		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['gallery_id'])) {
			$data['action'] = $this->url->link('catalog/gallery/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/gallery/edit', 'token=' . $this->session->data['token'] . '&gallery_id=' . $this->request->get['gallery_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['gallery_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$gallery_info = $this->model_catalog_gallery->getgallery($this->request->get['gallery_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['gallery_description'])) {
			$data['gallery_description'] = $this->request->post['gallery_description'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$data['gallery_description'] = $this->model_catalog_gallery->getgalleryDescriptions($this->request->get['gallery_id']);
		} else {
			$data['gallery_description'] = array();
		}

		

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['gallery_store'])) {
			$data['gallery_store'] = $this->request->post['gallery_store'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$data['gallery_store'] = $this->model_catalog_gallery->getgalleriestores($this->request->get['gallery_id']);
		} else {
			$data['gallery_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($gallery_info)) {
			$data['keyword'] = $gallery_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($gallery_info)) {
			$data['date_available'] = ($gallery_info['date_available'] != '0000-00-00') ? $gallery_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}


		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($gallery_info)) {
			$data['sort_order'] = $gallery_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

	
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($gallery_info)) {
			$data['status'] = $gallery_info['status'];
		} else {
			$data['status'] = true;
		}

		// Categories
		$this->load->model('catalog/gallerycategory');

		if (isset($this->request->post['gallery_gallerycategory'])) {
			$categories = $this->request->post['gallery_gallerycategory'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$categories = $this->model_catalog_gallery->getgalleryCategories($this->request->get['gallery_id']);
		} else {
			$categories = array();
		}

		$data['gallery_categories'] = array();

		foreach ($categories as $gallerycategory_id) {
			$gallerycategory_info = $this->model_catalog_gallerycategory->getgallerycategory($gallerycategory_id);

			if ($gallerycategory_info) {
				$data['gallery_categories'][] = array(
					'gallerycategory_id' => $gallerycategory_info['gallerycategory_id'],
					'name' => ($gallerycategory_info['path']) ? $gallerycategory_info['path'] . ' &gt; ' . $gallerycategory_info['name'] : $gallerycategory_info['name']
				);
			}
		}
		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['gallery_filter'])) {
			$filters = $this->request->post['gallery_filter'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$filters = $this->model_catalog_gallery->getgalleryFilters($this->request->get['gallery_id']);
		} else {
			$filters = array();
		}

		$data['gallery_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['gallery_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}
		
		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($gallery_info)) {
			$data['image'] = $gallery_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($gallery_info) && is_file(DIR_IMAGE . $gallery_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($gallery_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->post['gallery_image'])) {
			$gallery_images = $this->request->post['gallery_image'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$gallery_images = $this->model_catalog_gallery->getgalleryImages($this->request->get['gallery_id']);
		} else {
			$gallery_images = array();
		}

		$data['gallery_images'] = array();

		foreach ($gallery_images as $gallery_image) {
			if (is_file(DIR_IMAGE . $gallery_image['image'])) {
				$image = $gallery_image['image'];
				$thumb = $gallery_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['gallery_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $gallery_image['sort_order']
			);
		}

		
		if (isset($this->request->post['gallery_related'])) {
			$galleries = $this->request->post['gallery_related'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$galleries = $this->model_catalog_gallery->getgalleryRelated($this->request->get['gallery_id']);
		} else {
			$galleries = array();
		}

		$data['gallery_relateds'] = array();

		foreach ($galleries as $gallery_id) {
			$related_info = $this->model_catalog_gallery->getgallery($gallery_id);

			if ($related_info) {
				$data['gallery_relateds'][] = array(
					'gallery_id' => $related_info['gallery_id'],
					'name'       => $related_info['name']
				);
			}
		}

		

		if (isset($this->request->post['gallery_layout'])) {
			$data['gallery_layout'] = $this->request->post['gallery_layout'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$data['gallery_layout'] = $this->model_catalog_gallery->getgalleryLayouts($this->request->get['gallery_id']);
		} else {
			$data['gallery_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/gallery_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['gallery_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}


		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['gallery_id']) && $url_alias_info['query'] != 'gallery_id=' . $this->request->get['gallery_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['gallery_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/gallery');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_gallery->getgalleries($filter_data);

			foreach ($results as $result) {
				
				$json[] = array(
					'gallery_id' => $result['gallery_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
