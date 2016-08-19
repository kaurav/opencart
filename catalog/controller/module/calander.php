<?php
class ControllerModulecalander extends Controller {
	public function index($setting) {

		$this->load->language('module/calander');
		
		static $module = 0;

		$this->load->model('catalog/sikhethehas');
		
		$data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('cdn/js/fullcalendar/fullcalendar.css');
		$this->document->addScript('cdn/js/fullcalendar/lib/moment.min.js','footer');
		$this->document->addScript('cdn/js/fullcalendar/fullcalendar.js','footer');
		$this->document->addScript('cdn/js/events.js','footer');

		$data['text_sikh_itehas'] = $this->language->get('text_sikh_itehas');

		$data['fullalender'] = $this->url->link('information/calender');


		$data['module'] = $module++;



		/*get current date month events starts*/
		$filter_data = array(
			'day' => date('d'),
			'month' => date('n')
		);

		$returndata = $this->model_catalog_sikhethehas->getevents($filter_data);

		$data['totaldata'] = array();
		if($returndata->num_rows > 0){
			foreach($returndata->rows as $key => $value ) {

				$da = new DateTime($value['date_available']);
				$year = $da->format('Y');

				$data['totaldata'][$key] = $value;
				$data['totaldata'][$key]['href'] =  $this->url->link('product/sikhethehas','sikhethehas_id='. $value['sikhethehas_id']);
				$data['totaldata'][$key]['year'] = $year;
			}
		}

		$data['text_noevent'] = $this->language->get('text_noevent');



		$data['events'] = $this->load->view('module/calanderevents', $data,true);
		/*get current date month events ends*/

		return $this->load->view('module/calander', $data);
	}



	/*return detail of event of particular date. from all years*/
	public function getallevents() {
		$json = array();
		$this->load->language('module/calander');
		//echo $_POST['day']."".$_POST['month']."".$_POST['year']; 
		$this->load->model('catalog/sikhethehas');
		$data = array(
			'day' => $_POST['day'],
			'month' => $_POST['month']
			);

		$returndata = $this->model_catalog_sikhethehas->getevents($data);
		//print_r($returndata);die();
		$data['totaldata'] = array();
		if($returndata->num_rows > 0){
			foreach($returndata->rows as $key => $value ) {

				$da = new DateTime($value['date_available']);
				$year = $da->format('Y');

				$data['totaldata'][$key] = $value;
				$data['totaldata'][$key]['href'] =  $this->url->link('product/sikhethehas','sikhethehas_id='. $value['sikhethehas_id']);
				$data['totaldata'][$key]['year'] = $year;
			}
		}



		$data['text_noevent'] = $this->language->get('text_noevent');

		$json['response'] = $this->load->view('module/calanderevents', $data,true);


		$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));		
	 }


	
}
