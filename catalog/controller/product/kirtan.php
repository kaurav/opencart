<?php
class ControllerProductKirtan extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('product/kirtan');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);


		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('kirtan/search', $url)
			);
		}

	
		$url = '';
			
		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . $this->request->get['tag'];
		}

		if (isset($this->request->get['description'])) {
			$url .= '&description=' . $this->request->get['description'];
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

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_select'] = $this->language->get('text_select');
		
		$data['text_tags'] = $this->language->get('text_tags');
		$data['text_related'] = $this->language->get('text_related');
		$data['text_loading'] = $this->language->get('text_loading');

		$this->load->model('catalog/kirtan');

		$activities = $this->model_catalog_kirtan->getAllActivities();

		//print_r($activities);die();
		
         $this->load->model('tool/image');

    foreach ($activities as $result) {
        if ($result['image']) {
          $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
        } else {
          $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
        }


        $date = date($this->language->get('date_format_short'), strtotime( $result['date_available']  ) );



		

        $data['activities'][] = array(
          'kirtan_id'  => $result['kirtan_id'],
          'thumb'       => $image,
          'image'       => $this->model_tool_image->getFullImage( $result['image']),
          'name'        => character_limiter( $result['name'],60 ),
          'date'        =>  $date,
          'related_images' => $result['related_images'],
        
        );
      }


      
     // print_r($data);die();

		$data['text_no_result'] = $this->language->get('text_no_result');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/kirtan', $data));
		 
	}
	public function mp3(){

		$dir    = 'cdn/mp3';
		$files1 = scandir($dir);
//		$files2 = scandir($dir, 1);
		//print_r($files1);
		//echo filemtime($dir);
		//echo "<br><br>Last modified: ".date("F d Y H:i:s.",filemtime($dir));
		//print_r($chk);

		// $file = new SplFileInfo('path/to/file');
		// echo $file->getMTime();


		foreach ($files1 as $file) {

			if($file != '.' && $file != '..'){
			 $file1 = stat($dir.'/'.$file);
			 // $text = strtolower(pathinfo($path.$file,PATHINFO_EXTENSION));
			 // $name = pathinfo($path.$file,PATHINFO_FILENAME);
				// echo "<br>".date('Y-m-d',$file1['ctime']);
			// //print_r($file);
			// //echo "<br>".$file['mtime'];
			// $date = date('Y-m-d',$file['mtime']);
			// print_r(filemtime($dir.'/'.$file));
			// // echo "<br>";
			// print_r($date);
//echo $file->getMTime();
			// echo "<br>".$file."&nbsp;&nbsp;&nbsp;&nbsp;Last modified: ".date("F d Y H:i:s.",filemtime($dir.'/'.$file));;

			// echo "<br>".date('Y-m-d',$file1['mtime']);
			// echo "<br>".date('Y-m-d',$file1['atime']);
			// echo "<br>".date('Y-m-d',$file1['ctime']);

		}
		}
		//c::/cdn/



	}

}
