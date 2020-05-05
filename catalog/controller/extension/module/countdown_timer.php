<?php
class ControllerExtensionModuleCountdownTimer extends Controller {
	public function index($setting) {
		static $module = 0;
		$data["data"] = array();
		return $this->load->view('extension/module/countdown_timer', $data);
	}
}