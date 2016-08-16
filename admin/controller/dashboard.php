<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		// $data['order'] = $this->load->controller('dashboard/order');
		// $data['sale'] = $this->load->controller('dashboard/sale');
		$data['customer'] = $this->load->controller('dashboard/customer');
		// $data['online'] = $this->load->controller('dashboard/online');
		// $data['map'] = $this->load->controller('dashboard/map');
		// $data['chart'] = $this->load->controller('dashboard/chart');
		// $data['activity'] = $this->load->controller('dashboard/activity');
		// $data['recent'] = $this->load->controller('dashboard/recent');
		$data['members'] = $this->load->controller('dashboard/members');
		$data['footer'] = $this->load->controller('common/footer');

		// Run currency update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->refresh();
		}

		$this->response->setOutput($this->load->view('common/dashboard', $data));
	}

	public function memberprint() {
		$this->load->language('customer/customer');

		$this->load->model('customer/customer');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');		

		$data['title'] = $data['heading_title'] = $this->language->get('heading_title');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['token'] = $this->session->data['token'];

		

		$url = '';


		$data['customers'] = array();

		


		$results = $this->model_customer_customer->getCustomers();

		foreach ($results as $result) {
			
			$service = '';
			if( $result['service'] == 'TAN' ) {
				$service = $this->language->get('text_tan');
			}
			if( $result['service'] == 'MAN' ) {
				$service = $this->language->get('text_man');
			}
			if( $result['service'] == 'DHAN' ) {
				$service = $this->language->get('text_dhan');
			}

			$address = '';
			$xaddress = $this->model_customer_customer->getAddress($result['address_id']);
			if(!empty($xaddress)){
				$address = $xaddress['address_1'];
			}

			$data['customers'][] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'telephone'          => $result['telephone'],
				'service'          => $service,
				'address'          => $address,
				'facebookID'          => $result['facebookID'],
				
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_telephone'] = $this->language->get('column_telephone');
		$data['column_address'] = $this->language->get('column_address');
		$data['column_service'] = $this->language->get('column_service');
		$data['column_facebookID'] = $this->language->get('column_facebookID');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_date_added'] = $this->language->get('entry_date_added');


		$data['token'] = $this->session->data['token'];

		
			$data['error_warning'] = '';
		

		
			$data['success'] = '';
		

		
			$data['selected'] = array();
		

		$this->response->setOutput($this->load->view('dashboard/memberprint', $data));
	}
// on refresh all the data files in cdn will be inserted into database
	public function refresh(){
		$path    = DIR_CDN.'mp3/';
		$dirs = scandir($path);
		$this->load->model('catalog/kirtan');
		$this->model_catalog_kirtan->truncatekiratnmp3();
		foreach ($dirs as $dir) {

			if($dir != '.' && $dir != '..') {

			 	$file_stat = stat($path.$dir);
			 	echo "<br>".date('Y-m-d',$file1['ctime']);
			 	$fileinfo = array();
			 	$ext = strtolower(pathinfo($path.$file,PATHINFO_EXTENSION));
			 	$name = pathinfo($path.$file,PATHINFO_FILENAME);
				$ctime = date('Y-m-d',$file1['ctime']);
				$ctime1 = date('Y-m-d H:i:s',$file1['ctime']);
				$allowed = array('mp3');
				if(in_array($ext, $allowed)){
					$fileinfo= array(
						'name' => $name,
						'ext' => $ext,
						'date_available' => $ctime,
						'ctime' => $ctime1,
					);
					$this->model_catalog_kirtan->addkirtanmp3($fileinfo);
				}


			}
			

		}




			$this->session->data['success'] = $this->language->get('text_refresh');

		$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'] , true));

}


}
