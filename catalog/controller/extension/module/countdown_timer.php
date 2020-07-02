<?php
class ControllerExtensionModuleCountdownTimer extends Controller {
	public function index($setting) {
		static $module = 0;
		// print_r($setting);
		$old_date = date('y-m-d-h-i-s');
		$new_date = date('m/d/y H:i:s', strtotime($setting["end_time"]));
		$data["data"] = array(
			"start_time" => $setting["start_time"],
			"end_time" => $setting["end_time"],
			"time_expired" => $new_date
		);
		return $this->load->view('extension/module/countdown_timer', $data);
	}
}