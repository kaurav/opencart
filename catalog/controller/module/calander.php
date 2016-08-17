<?php
class ControllerModulecalander extends Controller {
	public function index($setting) {

		$this->load->language('module/calander');
		
		static $module = 0;
		
		
		$data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('cdn/js/fullcalendar/fullcalendar.css');
		$this->document->addScript('cdn/js/fullcalendar/lib/moment.min.js','footer');
		$this->document->addScript('cdn/js/fullcalendar/fullcalendar.js','footer');
		$this->document->addScript('cdn/js/events.js','footer');

		$data['text_sikh_itehas'] = $this->language->get('text_sikh_itehas');

		$data['fullalender'] = $this->url->link('information/calender');


		$data['module'] = $module++;



		return $this->load->view('module/calander', $data);
	}

	public function getallevents(){

	$this->load->language('module/calander');
	$this->load->model('catalog/calander');

		//echo "string";die();

		$data = array(
			$day = $_POST['day'],
			$month = $_POST['month']
			);
		$this->model_catalog_calander->getevents($data);
		print_r($_POST);die();
		//print_r($data);die();
		

	}
	// $this->load->view('module/calander', $data);


	
}