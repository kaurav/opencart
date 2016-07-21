<?php
class ControllerCatalogevent extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('catalog/event');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/event');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/event');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/event');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {


			$this->model_catalog_event->addevent($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/event');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/event'); 


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

		#		print_r($this->request->post);

		#die();

			$this->model_catalog_event->editevent($this->request->get['event_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/event');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/event');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $event_id) {
				$this->model_catalog_event->deleteevent($event_id);
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

			$this->response->redirect($this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/event');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/event');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $event_id) {
				$this->model_catalog_event->copyevent($event_id);
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

			$this->response->redirect($this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		//echo "Hi"; die();
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
			$sort = 'pd.name';
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
			'href' => $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/event/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('catalog/event/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/event/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['events'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			
			
			
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$event_total = $this->model_catalog_event->getTotalevents($filter_data);

		$results = $this->model_catalog_event->getevents($filter_data);

		//print_r($results); die();
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			
			$data['events'][] = array(
				'event_id' => $result['event_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/event/edit', 'token=' . $this->session->data['token'] . '&event_id=' . $result['event_id'] . $url, true)
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
		$data['column_model'] = $this->language->get('column_model');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_copy'] = $this->language->get('button_copy');
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

		$data['sort_name'] = $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

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
		$pagination->total = $event_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($event_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($event_total - $this->config->get('config_limit_admin'))) ? $event_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $event_total, ceil($event_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		
		
		
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/event_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['event_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['entry_color'] = $this->language->get('entry_color');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		

		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_additional_image'] = $this->language->get('entry_additional_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_recurring'] = $this->language->get('entry_recurring');

		$data['help_keyword'] = $this->language->get('help_keyword');
		
		
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_recurring'] = $this->language->get('tab_recurring');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');

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
			'href' => $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['event_id'])) {
			$data['action'] = $this->url->link('catalog/event/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/event/edit', 'token=' . $this->session->data['token'] . '&event_id=' . $this->request->get['event_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/event', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['event_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$event_info = $this->model_catalog_event->getevent($this->request->get['event_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['event_description'])) {
			$data['event_description'] = $this->request->post['event_description'];
		} elseif (isset($this->request->get['event_id'])) {
			$data['event_description'] = $this->model_catalog_event->geteventDescriptions($this->request->get['event_id']);
		} else {
			$data['event_description'] = array();
		}

		


		

		

		
		

		

		

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['event_store'])) {
			$data['event_store'] = $this->request->post['event_store'];
		} elseif (isset($this->request->get['event_id'])) {
			$data['event_store'] = $this->model_catalog_event->geteventStores($this->request->get['event_id']);
		} else {
			$data['event_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($event_info)) {
			$data['keyword'] = $event_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		

		

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['event_recurrings'])) {
			$data['event_recurrings'] = $this->request->post['event_recurrings'];
		} elseif (!empty($event_info)) {
			$data['event_recurrings'] = $this->model_catalog_event->getRecurrings($event_info['event_id']);
		} else {
			$data['event_recurrings'] = array();
		}

		

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($event_info)) {
			$data['date_available'] = ($event_info['date_available'] != '0000-00-00') ? $event_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		


		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($event_info)) {
			$data['sort_order'] = $event_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($event_info)) {
			$data['status'] = $event_info['status'];
		} else {
			$data['status'] = true;
		}

		

		

		
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($event_info)) {
			$data['width'] = $event_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($event_info)) {
			$data['height'] = $event_info['height'];
		} else {
			$data['height'] = '';
		}

		

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($event_info)) {
			$data['manufacturer_id'] = $event_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($event_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($event_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['event_category'])) {
			$categories = $this->request->post['event_category'];
		} elseif (isset($this->request->get['event_id'])) {
			$categories = $this->model_catalog_event->geteventCategories($this->request->get['event_id']);
		} else {
			$categories = array();
		}

		$data['event_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['event_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['event_filter'])) {
			$filters = $this->request->post['event_filter'];
		} elseif (isset($this->request->get['event_id'])) {
			$filters = $this->model_catalog_event->geteventFilters($this->request->get['event_id']);
		} else {
			$filters = array();
		}

		$data['event_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['event_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['event_attribute'])) {
			$event_attributes = $this->request->post['event_attribute'];
		} elseif (isset($this->request->get['event_id'])) {
			$event_attributes = $this->model_catalog_event->geteventAttributes($this->request->get['event_id']);
		} else {
			$event_attributes = array();
		}

		$data['event_attributes'] = array();

		foreach ($event_attributes as $event_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($event_attribute['attribute_id']);

			if ($attribute_info) {
				$data['event_attributes'][] = array(
					'attribute_id'                  => $event_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'event_attribute_description' => $event_attribute['event_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['event_option'])) {
			$event_options = $this->request->post['event_option'];
		} elseif (isset($this->request->get['event_id'])) {
			$event_options = $this->model_catalog_event->geteventOptions($this->request->get['event_id']);
		} else {
			$event_options = array();
		}

		$data['event_options'] = array();

		foreach ($event_options as $event_option) {
			$event_option_value_data = array();

			if (isset($event_option['event_option_value'])) {
				foreach ($event_option['event_option_value'] as $event_option_value) {
					$event_option_value_data[] = array(
						'event_option_value_id' => $event_option_value['event_option_value_id'],
						'option_value_id'         => $event_option_value['option_value_id'],

			'points'                  => $event_option_value['points'],
						'points_prefix'           => $event_option_value['points_prefix'],
					);
				}
			}

			$data['event_options'][] = array(
				'event_option_id'    => $event_option['event_option_id'],
				'event_option_value' => $event_option_value_data,
				'option_id'            => $event_option['option_id'],
				'name'                 => $event_option['name'],
				'type'                 => $event_option['type'],
				'value'                => isset($event_option['value']) ? $event_option['value'] : '',
				'required'             => $event_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['event_options'] as $event_option) {
			if ($event_option['type'] == 'select' || $event_option['type'] == 'radio' || $event_option['type'] == 'checkbox' || $event_option['type'] == 'image') {
				if (!isset($data['option_values'][$event_option['option_id']])) {
					$data['option_values'][$event_option['option_id']] = $this->model_catalog_option->getOptionValues($event_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['event_discount'])) {
			$event_discounts = $this->request->post['event_discount'];
		} elseif (isset($this->request->get['event_id'])) {
			$event_discounts = $this->model_catalog_event->geteventDiscounts($this->request->get['event_id']);
		} else {
			$event_discounts = array();
		}

		$data['event_discounts'] = array();

		foreach ($event_discounts as $event_discount) {
			$data['event_discounts'][] = array(
				'customer_group_id' => $event_discount['customer_group_id'],
				'priority'          => $event_discount['priority'],
				'date_start'        => ($event_discount['date_start'] != '0000-00-00') ? $event_discount['date_start'] : '',
				'date_end'          => ($event_discount['date_end'] != '0000-00-00') ? $event_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['event_special'])) {
			$event_specials = $this->request->post['event_special'];
		} elseif (isset($this->request->get['event_id'])) {
			$event_specials = $this->model_catalog_event->geteventSpecials($this->request->get['event_id']);
		} else {
			$event_specials = array();
		}

		$data['event_specials'] = array();

		foreach ($event_specials as $event_special) {
			$data['event_specials'][] = array(
				'customer_group_id' => $event_special['customer_group_id'],
				'priority'          => $event_special['priority'],
				'date_start'        => ($event_special['date_start'] != '0000-00-00') ? $event_special['date_start'] : '',
				'date_end'          => ($event_special['date_end'] != '0000-00-00') ? $event_special['date_end'] :  ''
			);
		}
		
		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($event_info)) {
			$data['image'] = $event_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($event_info) && is_file(DIR_IMAGE . $event_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($event_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->post['event_image'])) {
			$event_images = $this->request->post['event_image'];
		} elseif (isset($this->request->get['event_id'])) {
			$event_images = $this->model_catalog_event->geteventImages($this->request->get['event_id']);
		} else {
			$event_images = array();
		}

		$data['event_images'] = array();

		foreach ($event_images as $event_image) {
			if (is_file(DIR_IMAGE . $event_image['image'])) {
				$image = $event_image['image'];
				$thumb = $event_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['event_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $event_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['event_download'])) {
			$event_downloads = $this->request->post['event_download'];
		} elseif (isset($this->request->get['event_id'])) {
			$event_downloads = $this->model_catalog_event->geteventDownloads($this->request->get['event_id']);
		} else {
			$event_downloads = array();
		}

		$data['event_downloads'] = array();

		foreach ($event_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['event_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['event_related'])) {
			$events = $this->request->post['event_related'];
		} elseif (isset($this->request->get['event_id'])) {
			$events = $this->model_catalog_event->geteventRelated($this->request->get['event_id']);
		} else {
			$events = array();
		}

		$data['event_relateds'] = array();

		foreach ($events as $event_id) {
			$related_info = $this->model_catalog_event->getevent($event_id);

			if ($related_info) {
				$data['event_relateds'][] = array(
					'event_id' => $related_info['event_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($event_info)) {
			$data['points'] = $event_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['event_reward'])) {
			$data['event_reward'] = $this->request->post['event_reward'];
		} elseif (isset($this->request->get['event_id'])) {
			$data['event_reward'] = $this->model_catalog_event->geteventRewards($this->request->get['event_id']);
		} else {
			$data['event_reward'] = array();
		}

		if (isset($this->request->post['event_layout'])) {
			$data['event_layout'] = $this->request->post['event_layout'];
		} elseif (isset($this->request->get['event_id'])) {
			$data['event_layout'] = $this->model_catalog_event->geteventLayouts($this->request->get['event_id']);
		} else {
			$data['event_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/event_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/event')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['event_description'] as $language_id => $value) {
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

			if ($url_alias_info && isset($this->request->get['event_id']) && $url_alias_info['query'] != 'event_id=' . $this->request->get['event_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['event_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/event')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/event')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/event');
			$this->load->model('catalog/option');

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

			$results = $this->model_catalog_event->getevents($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$event_options = $this->model_catalog_event->geteventOptions($result['event_id']);

				foreach ($event_options as $event_option) {
					$option_info = $this->model_catalog_option->getOption($event_option['option_id']);

					if ($option_info) {
						$event_option_value_data = array();

						foreach ($event_option['event_option_value'] as $event_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($event_option_value['option_value_id']);

							if ($option_value_info) {
								$event_option_value_data[] = array(
									'event_option_value_id' => $event_option_value['event_option_value_id'],
									'option_value_id'         => $event_option_value['option_value_id'],
									'name'                    => $option_value_info['name']
								);
							}
						}

						$option_data[] = array(
							'event_option_id'    => $event_option['event_option_id'],
							'event_option_value' => $event_option_value_data,
							'option_id'            => $event_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $event_option['value'],
							'required'             => $event_option['required']
						);
					}
				}

				$json[] = array(
					'event_id' => $result['event_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
