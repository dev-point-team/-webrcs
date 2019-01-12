<?php

class Funcs extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function is_authenticated() {
		if ($this->session->userdata('admin')) {
			return true;
		} else {
			return false;
		}
	}
	public function do_authenticated($secrete) {

		if ($this->config->item('secrete') == $secrete) {
			$this->session->set_userdata('admin', true);
		} else {
			$this->session->set_userdata('admin', false);
		}
	}

	public function json_result($title, $message, $data = '') {
		if ($data) {
			echo json_encode(array('title' => $title, 'message' => $message, 'data' => $data));
		} else {
			echo json_encode(array('title' => $title, 'message' => $message));
		}

	}

}

?>