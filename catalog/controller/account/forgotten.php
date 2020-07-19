<?php
require_once './public/vendor/autoload.php';
use Twilio\Rest\Client;

class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_account_customer->editCode($this->request->post['telephone'], token(40));

			$this->session->data['success'] = $this->language->get('text_success');

			// $this->response->redirect($this->url->link('account/login', '', true));
			// if customer forgot their password they can confirm by phone number
			$otpCode = mt_rand(100000,999999);
			// Your Account SID and Auth Token from twilio.com/console
			$sid = $this->config->get('config_twilio_sid');
			$token = $this->config->get('config_twilio_token');
			$client = new Client($sid, $token);
			$telephone = preg_replace('/[^0-9]/', '', $this->request->post["telephone"]);
			$convertTel = (int)$telephone;
			// Use the client to do fun stuff like send text messages!
			$client->messages->create(
				// the number you'd like to send the message to
				'+855'.$convertTel,
				array(
					// A Twilio phone number you purchased at twilio.com/console
					'from' => $this->config->get('config_twilio_number'),
					// the body of the text message you'd like to send
					'body' => 'NWCambodia confirm code: '.$otpCode.''
				)
			);
			$customer_info = $this->model_account_customer->getCustomerByTelephone($this->request->post['telephone']);
			$this->model_account_customer->addCustomerOTP($customer_info["customer_id"], $this->request->post['telephone'], $otpCode, $customer_info["salt"]);
			$customer_info = $this->model_account_customer->getCustomerByTelephone($this->request->post['telephone']);
			// $this->session->data['customer_id'] = $customer_info["customer_id"];
			$this->response->redirect($this->url->link('account/confirm&customer_id='.$customer_info["customer_id"].'&telephone='.$this->request->post["telephone"].'&forgot_password=true'));
		}

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
			'text' => $this->language->get('text_forgotten'),
			'href' => $this->url->link('account/forgotten', '', true)
		);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = $this->url->link('account/forgotten', '', true);

		$data['back'] = $this->url->link('account/login', '', true);

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/forgotten', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['telephone'])) {
			$this->error['warning'] = $this->language->get('error_telephone');
		} elseif (!$this->model_account_customer->getTotalCustomersByTelephone($this->request->post['telephone'])) {
			$this->error['warning'] = $this->language->get('error_telephone');
		}
		
		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByTelephone($this->request->post['telephone']);

		if ($customer_info && !$customer_info['status']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		return !$this->error;
	}
}
