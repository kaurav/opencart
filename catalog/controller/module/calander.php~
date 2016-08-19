<?php
class ControllerModulesikhethehas extends Controller {
	public function index($setting) {

		$this->load->language('module/sikhethehas');
		
		static $module = 0;
		
		
		$data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('cdn/js/fullcalendar/fullcalendar.css');
		$this->document->addScript('cdn/js/fullcalendar/lib/moment.min.js','footer');
		$this->document->addScript('cdn/js/fullcalendar/fullcalendar.js','footer');
		$this->document->addScript('cdn/js/events.js','footer');

		$data['text_sikh_itehas'] = $this->language->get('text_sikh_itehas');

		$data['fullalender'] = $this->url->link('information/calender');


		$data['module'] = $module++;//??

		$filter_data = array(
			'day' => 17,//date("d"),
			'month' => date("m")
			);
		//print_r($filter_data);die();
		$this->load->model("catalog/sikhethehas");

		$results = $this->model_catalog_sikhethehas->getevents($filter_data);
		

		$rows = array(); // created a blank array which will store the rows in array


		if($results->num_rows > 0){  // to see whether results contains rows more than 0 or not blank

			
			$rows['totaldata'] = $results->rows; // retrieve the rows 
			foreach ($rows['totaldata'] as $key => $value) {
				

				$time=strtotime($data['date_available']);
				$rows['totaldata'][$key]['year'] = date("Y",$time);

				$rows['totaldata'][$key]['href'] =  $this->url->link('product/sikhethehas','sikhethehas_id='.$value['sikhethehas_id']   );

			}


			print_r($rows['totaldata']); die();

			
		}


		$data['events'] = $this->load->view('module/sikhethehasevents', $rows, true);


		return $this->load->view('module/sikhethehas', $data);
	}

	public function getallevents(){

	$this->load->language('module/sikhethehas');
	$this->load->model('catalog/sikhethehas');

		//echo "string";die();
// what is $day ? variable to store the day... but ehh ta key hai na,, but tu $day use kr rhi...han .. takyu ? mtlb ethe q? 
	// inj ni hona chahi da c ?? hnmm but ehh edan v ta chali janda?=.. lets check.
		// $data = array(
		// 	$day = $_POST['day'],
		// 	$month = $_POST['month']
		// 	);
// echo "avi say its working \n\n";
// 		print_r($data);
// 		die();
// its means.. apna syntax error hai 15 no. line te. 
		// i am not sure..why its not giving error. but its wrong. see the output. // this was actually i want to say.. :/
//		SON.parse: unexpected character at line 1 column 1 of the JSON data
		// forget that. see response.
		// hmm m v ehhi bolan wali c 0,1 di jagah te day month display krone aa
		//te naale 7 nu + 1 krna...ohh javascript ch hi krna...hmm ehh?  this one i selected.hmm

// don;t remove above code.. we will need to debug. how and why it not giving error.kk
		$data = array(
			'day' => $_POST['day'],
			'month' => $_POST['month']
			);
		$results = $this->model_catalog_sikhethehas->getevents($data);
		//print_r($results);die();

		$rows = array(); // created a blank array which will store the rows in array


		if($results->num_rows > 0){  // to see whether results contains rows more than 0 or not blank

			
			$rows['totaldata'] = $results->rows; // retrieve the rows

			foreach ($rows['totaldata'] as $key => $value) {
				

				$time=strtotime($value['date_available']);
				$rows['totaldata'][$key]['year'] = date("Y",$time);

				$rows['totaldata'][$key]['href'] =  $this->url->link('product/sikhethehas','sikhethehas_id='.$value['sikhethehas_id']   );

			}

		}


		$result['json'] = $this->load->view('module/sikhethehasevents', $rows, true);
		

		// print_r($result['json'] ); die();
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($result));
	}
	// $this->load->view('module/sikhethehas', $data);
// now good night. bye bye hmm bye

	
}
