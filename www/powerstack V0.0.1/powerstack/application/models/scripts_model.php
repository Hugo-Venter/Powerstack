<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Scripts_model extends CI_Model
{
	
	public function get_all_scripts($status = 0, $clientId = 0){

		$this->db->select('a.id, a.name, TO_BASE64(a.data) as data, a.location, a.type, a.cron, a.groupId, a.status');
		$this->db->from('scripts a');
		$this->db->join('groups b', 'a.groupId = b.id');
		$this->db->order_by('name');
			
		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}
	public function delete_script($data){
		
		$sqldata = array('id' => $data['id']);
		$this->db->delete('scripts',$sqldata);
	}
	
	public function update_script($data){
		$update = array('name' => $data['name'],'description' => $data['description'], 'data' => $data['data'], 'cron' => $data['cron'], 'status' => $data['status'], 'location' => $data['location'], 'type' => $data['type'], 'groupId' => $data['groupId']);
		$this->db->where("id",$data['id']);
		$this->db->update('scripts',$update);
	}
	
	public function insert_script($data){
		$insert = array('name' => $data['name'],'description' => $data['description'], 'data' => $data['data'], 'cron' => $data['cron'], 'status' => $data['status'], 'location' => $data['location'], 'type' => $data['type'], 'groupId' => $data['groupId']);
		$this->db->insert('scripts',$insert);
	}
	
	public function get_script_by_id($data){
		
		if ($data['script_id']){
			//$rs = $this->get_currency_by_desc($data['currency']);
			$sql = "select * from scripts where id = '" . $data['script_id'] . "'";
			
			$query = $this->db->query($sql);

			$rs = $query->result_array();
			return $rs;
		}

	}
	
	public function get_all_groups(){
		$sql = "select * from groups";
		
		$query = $this->db->query($sql);
        
		$rs = $query->result_array();
		return $rs;

	}
	
	public function get_clients_by_script_id($data){
		if ($data['script_id']){
			$this->db->select('c.*');
			$this->db->from('scripts a');
			$this->db->join('clientGroups b', 'a.groupId = b.groupId');
			$this->db->join('clients c', 'b.clientId = c.Id');
			$this->db->order_by('c.computerName');
			$this->db->where(array("a.id" => $data['script_id']));
				
			$query = $this->db->get();
	
			$rs = $query->result_array();
			//echo $this->db->last_query();
			return $rs;
		}

	}
	
	public function get_default_scripts(){

		$this->db->select('a.id, a.name, TO_BASE64(a.data) as data, a.location, a.type, a.cron, a.groupId, a.status');
		$this->db->from('scripts a');
		$this->db->join('clientgroups b', 'a.groupId = b.groupId');
		$this->db->where(array("a.groupId" => "1"));
			
		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}

}