<?php
class ControllerCatalogvideo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/video');

		$this->getList();
	}
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/video')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['product_video'])) {
			$this->error['warning'] = $this->language->get('no video added');
					}

		if (!empty($this->request->post['product_video'])) {
		

foreach ($this->request->post['product_video'] as $key => $product_video) {
	if(empty($product_video['url'])){
		$this->error['product_video'][$key]['url']=$this->language->get('error_videoUrl');	
	}
	
	foreach($product_video['description'] as $key1 => $description )
	{
		if(empty($description['title'])) {
			$this->error['product_video'][$key]['description'][$key1]['title'] = $this->language->get('error_videotitle');
		}

	}
}
	}	


		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}


	public function add() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/video');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

//print_r($this->request->post); die();

			if(!empty($this->request->post['product_video'])) { 
			foreach( $this->request->post['product_video'] as $product_video )  { 
				$this->model_catalog_video->addvideo($product_video);
			}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

public function edit() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/video'); 


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_video->editvideo($this->request->get['video_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}



	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['video_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');

		$data['entry_videodescription'] = $this->language->get('entry_videodescription');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_videourl'] = $this->language->get('entry_videourl');
		$data['entry_videotitle'] = $this->language->get('entry_videotitle');

		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_video_add'] =  $this->language->get('button_add');

		$data['button_remove'] = $this->language->get('button_remove');

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

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['video_id'])) {
			$data['action'] = $this->url->link('catalog/video/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/video/edit', 'token=' . $this->session->data['token'] . '&video_id=' . $this->request->get['video_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['video_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$video_info = $this->model_catalog_video->getvideo($this->request->get['video_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		// print_r($data['languages']); die();
		if (isset($this->request->post['product_video'])) {
			$data['product_videos'] = $this->request->post['product_video'];
		} elseif (isset($this->request->get['video_id'])) {
			$data['product_videos'] = $this->model_catalog_video->getvideoDescriptions($this->request->get['video_id']);
		} else {
			$data['product_videos'] = array();
		}
//
//print_r($data['product_videos']);die();


		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($video_info)) {
			$data['sort_order'] = $video_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}


		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($video_info)) {
			$data['status'] = $video_info['status'];
		} else {
			$data['status'] = true;
		}

				$this->load->model('tool/image');

		$data['placeholder'] =  $this->model_tool_image->resize('no_image.png', 100, 100);;

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/video_form', $data));
	}

		protected function getList() {
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = null;
		}

	
if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'vd.name';
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

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/video/add', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['delete'] = $this->url->link('catalog/video/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['videos'] = array( );

		$title_data = array(
			'filter_title'	  => $filter_title,
			//'filter_button'   => $filter_button,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$video_total = $this->model_catalog_video->getTotalvideos($title_data);

		$results = $this->model_catalog_video->getvideos($title_data);
		foreach ($results as $result) {

			$image = $this->model_tool_image->resize('no_image.png', 40, 40);


			$data['videos'][] = array(
				'video_id' => $result['video_id'],
				'image'      => $image,
				'title'       => $result['title'],				
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/video/edit', 'token=' . $this->session->data['token'] . '&video_id=' . $result['video_id'] . $url, true)
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
		$data['button_title'] = $this->language->get('button_title');
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

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
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

		$data['sort_name'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=vd.name' . $url, true);
	
		$data['sort_status'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
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
		$pagination->total = $video_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($video_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($video_total - $this->config->get('config_limit_admin'))) ? $video_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $video_total, ceil($video_total / $this->config->get('config_limit_admin')));

		$data['filter_title'] = $filter_title;
		
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/video_list', $data));
	}

	
}
