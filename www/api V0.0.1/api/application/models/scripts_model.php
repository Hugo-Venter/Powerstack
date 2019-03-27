<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Scripts_model extends CI_Model
{
	
	public function insert_client($data){
		
		$data = array('apiKey' => $data['apiKey'], 'computerName' => $data['computerName'], 'ip' => $data['ip'], 'dateCreated' => date('Y-m-d H:i:s'), 'dateCreated' => date('Y-m-d H:i:s'));
		$this->db->insert('clients',$data);

	}
	
	public function get_all_scripts($status = 0, $clientId = 0){

		$this->db->select('a.id, a.name, TO_BASE64(a.data) as data, a.location, a.type, a.cron, a.groupId, a.status');
		$this->db->from('scripts a');
		$this->db->join('clientgroups b', 'a.groupId = b.groupId');
		$this->db->where(array("b.clientId" => $clientId));
			
		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}
	
	public function get_default_scripts(){

		$this->db->select('a.id, a.name, TO_BASE64(a.data) as data, a.location, a.type, a.cron, a.groupId, a.status');
		$this->db->from('scripts a');
		$this->db->join('groups b', 'a.groupId = b.id');
		$this->db->where(array("a.groupId" => "1"));
			
		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}
	
	public function update_client_last_con($apiKey){
		
		if ($apiKey){
			$data = (array('lastComs' => date('Y-m-d H:i:s')));
			$this->db->where("apiKey",$apiKey);
			$this->db->update('clients',$data);
			
		}

	}
}