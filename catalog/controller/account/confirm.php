<?php
require_once './public/vendor/autoload.php';
use Twilio\Rest\Client;

class ControllerAccountConfirm extends Controller {

	public function index() {
		// // Your Account SID and Auth Token from twilio.com/console
		// $sid = 'ACc75a1b052882fbbbe81e3a5b06d489aa';
		// $token = '804e478d147019b0ad1b29d53fedaa5c';
		// $client = new Client($sid, $token);
		// // Use the client to do fun stuff like send text messages!
		// $client->messages->create(
		// 	// the number you'd like to send the message to
		// 	'+85581397071',
		// 	array(
		// 		// A Twilio phone number you purchased at twilio.com/console
		// 		'from' => '+18473053455',
		// 		// the body of the text message you'd like to send
		// 		'body' => 'Hey Jenny! Good luck on the bar exam!'
		// 	)
		// );

		$this->load->language('account/success');

		$this->document->setTitle($this->language->get('heading_title_confirm'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_confirm'),
			'href' => $this->url->link('account/success')
		);

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_approval'), $this->config->get('config_name'), $this->url->link('information/contact'));
		}

		if ($this->cart->hasProducts()) {
			$data['continue'] = $this->url->link('checkout/cart');
		} else {
			$data['continue'] = $this->url->link('account/account', '', true);
		}

		$data['customer_id'] = $_REQUEST['customer_id'];
		$data['telephone'] = $_REQUEST['telephone'];

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/confirm', $data));
	}

	public function resentCode(){
		$customer_id = $this->request->get["customer_id"];
		$telephoneUser = $this->request->get["telephone"];
		$otpCode = mt_rand(100000,999999);
		$this->load->model('account/customer');
		$customerData = $this->model_account_customer->editOtpCustomer($customer_id, $otpCode);
		// Your Account SID and Auth Token from twilio.com/console
		$sid = 'ACc75a1b052882fbbbe81e3a5b06d489aa';
		$token = '804e478d147019b0ad1b29d53fedaa5c';
		$client = new Client($sid, $token);
		$telephone = preg_replace('/[^0-9]/', '', $telephoneUser);
		$convertTel = (int)$telephone;
		// Use the client to do fun stuff like send text messages!
		$client->messages->create(
			// the number you'd like to send the message to
			'+855'.$convertTel,
			array(
				// A Twilio phone number you purchased at twilio.com/console
				'from' => '+18473053455',
				// the body of the text message you'd like to send
				'body' => 'NWCambodia confirm code: '.$otpCode.''
			)
		);
		$json = array(
			"success" => true,
			"message" => "here is your code"
		);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function checkConfirmOTP(){
		$otpCode = $this->request->get["otpCode"];
		$customer_id = $this->request->get["customer_id"];
		$this->load->model('account/customer');
		$checkOTPCustomer = $this->model_account_customer->checkOTPCustomer($customer_id, $otpCode);
		$boolean = false;
		$message = '';
		if($checkOTPCustomer["boolean"] == true){
			$boolean = true;
			$message = "Verify success.";
			// $this->response->redirect($this->url->link('account/success&salt='.$checkOTPCustomer["salt"]));
			$json = array(
				"success" => $boolean,
				"message" => $message,
				"redirect" => $this->url->link('account/success&salt='.$checkOTPCustomer["salt"])
			);
		}else{
			$boolean = false;
			$message = "Confirm code you input is incorrect, please try again!";
			$json = array(
				"success" => $boolean,
				"message" => $message,
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));


	}
}