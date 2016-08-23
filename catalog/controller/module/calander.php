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



		/*Get events list starts*/
		$filter_data = array(
			'month' => date('n'),
			'day' => date('d'),
			'year' => date('Y'),
		);
		$getdate = $this->model_catalog_sikhethehas->getdate($filter_data);
		


		$data['event_dates'] = array();
		if($getdate->num_rows > 0){
			foreach($getdate->rows as $key => $value ) {

				$data['event_dates'][] = $value['date_available'];
				
			}
		}

		/*get events lists ends*/


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
		$this->response->addHeader('Content-Type: application/json');
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


		
			$this->response->setOutput(json_encode($json));		
	 }

	 public function geteventslists() {
	 	$this->response->addHeader('Content-Type: application/json');
	 	$json = array();
	 	if(empty($this->request->post['month']) || empty($this->request->post['year'])) {
	 		$json = array('success' => false, 'msg' => 'Invalid Request!');
	 		$this->response->setOutput(json_encode($json));
	 		exit();
	 	}
	 	$this->load->language('module/calander');
		$this->load->model('catalog/sikhethehas');


		/*Get events list starts*/
		$filter_data = array(
			'month' => $this->request->post['month'],
			'day' => $this->request->post['day'],
			'year' => $this->request->post['year'],
		);
		$getdate = $this->model_catalog_sikhethehas->getdate($filter_data);
		
		$json['success'] = true;

		$json['event_dates'] = array();
		if($getdate->num_rows > 0){
			foreach($getdate->rows as $key => $value ) {

				$json['event_dates'][] = $value['date_available'];
				
			}
		}

		/*get events lists ends*/

		


			
		$this->response->setOutput(json_encode($json));		
	 }


	
}
