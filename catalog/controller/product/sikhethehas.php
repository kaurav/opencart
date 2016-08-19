<?php
class ControllerProductsikhethehas extends Controller {
	public function index() {

		 $this->load->language('product/sikhethehas_view');

		$this->load->model('catalog/sikhethehas');


		if (isset($this->request->get['sikhethehas_id'])) {
			$sikhethehas_id = (int)$this->request->get['sikhethehas_id'];
		} else {
			$sikhethehas_id = 0;
		}

		$sikhethehas_info = $this->model_catalog_sikhethehas->getsikhethehas($sikhethehas_id);
		//print_r($sikhethehas_info);die();

		if ($sikhethehas_info) {
			$url = '';

			$data['breadcrumbs'][] = array(
				'text' => $sikhethehas_info['name'],
				'href' => $this->url->link('product/sikhethehas', $url . 'sikhethehas_id=' . $this->request->get['sikhethehas_id'])
			);

			$this->document->setTitle($sikhethehas_info['meta_title']);
			$this->document->setDescription($sikhethehas_info['meta_description']);
			$this->document->setKeywords($sikhethehas_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/sikhethehas', 'sikhethehas_id=' . $this->request->get['sikhethehas_id']), 'canonical');
			

			$data['heading_title'] = $sikhethehas_info['name'];
			$data['description'] = html_entity_decode($sikhethehas_info['description'], ENT_QUOTES, 'UTF-8');

			$valid_date = date( 'd/m/y', strtotime($sikhethehas_info['date_added']));
			$data['date_added'] = $valid_date;

			$data['text_tags'] = $this->language->get('text_tags');
		
		

			$this->load->model('tool/image');

			$data['popup'] = $this->model_tool_image->getFullImage($sikhethehas_info['image']);
			
			if ($sikhethehas_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($sikhethehas_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));

				$data['popup'] = $this->model_tool_image->getFullImage($sikhethehas_info['image']);

			} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));;

				$data['popup'] = $this->model_tool_image->getFullImage('no_image.png');
			}

			$data['images'] = array();

			$results = $this->model_catalog_sikhethehas->getsikhethehasImages($this->request->get['sikhethehas_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->getFullImage($result['image']),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
				);
			}


			$data['sikhethehass'] = array();

			$results = $this->model_catalog_sikhethehas->getsikhethehasRelated($this->request->get['sikhethehas_id']);

			foreach ($results as $result) {

				//print_r($result);die();
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));

				$fullImage = $this->model_tool_image->getFullImage($result['image']);

				$valid_date = date( 'd/m/y', strtotime($result['date_added']));
				
					$data['sikhethehass'][] = array(
					'sikhethehas_id'  	  => $result['sikhethehas_id'],
					'thumb'       => $image,
					'popup'		=>	$fullImage,
					'date_added' => $valid_date,
					'name'        => character_limiter( $result['name'],50),
					'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'href'		=> $this->url->link('product/sikhethehas', 'sikhethehas_id=' . $result['sikhethehas_id'])
				);





				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));

					$fullImage = $this->model_tool_image->getFullImage('placeholder.png');

				$valid_date = date( 'd/m/y', strtotime($result['date_added']));


					$data['sikhethehass'][] = array(
					'sikhethehas_id'  	  => $result['sikhethehas_id'],
					'thumb'       => $image,
					'popup'		=>	$fullImage,
					'name'        => $result['name'],
					'date_added' => $valid_date,
					'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				
					'href'        => $this->url->link('product/sikhethehas', 
					'sikhethehas_id=' . $result['sikhethehas_id'])
				);

				}


				
			}

			$data['tags'] = array();

			if ($sikhethehas_info['tag']) {
				$tags = explode(',', $sikhethehas_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			

		  // print_r($data); die();
		$data['related_sikhethehas'] = $this->language->get('related_sikhethehas');
		$data['related_pics'] = $this->language->get('related_pics');


		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/sikhethehas_view', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/sikhethehas', $url . '&sikhethehas_id=' . $sikhethehas_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
