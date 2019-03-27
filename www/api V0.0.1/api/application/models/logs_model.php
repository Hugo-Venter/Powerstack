<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_model extends CI_Model
{
	
	public function insert_client($data){
		
		$data = array('apiKey' => $data['apiKey'], 'computerName' => $data['computerName'], 'ip' => $data['ip'], 'dateCreated' => date('Y-m-d H:i:s'), 'dateCreated' => date('Y-m-d H:i:s'));
		$this->db->insert('clients',$data);

	}
	
	public function get_all_clients($status = 0){

		$this->db->select('*');
		$this->db->from('clients');
		$this->db->order_by('computerName');
			
		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}
	
	public function insert_log($data){

		$update = array('clientId' => $data['clientId'],'process' => $data['process'], 'errorcode' => $data['errorcode'], 'data' => $data['data'], 'datestamp' => $data['datestamp']);
		$this->db->insert('log',$update);

	}
	
	public function get_client_by_id($data){
		
		if ($data['client_id']){
			//$rs = $this->get_currency_by_desc($data['currency']);
			$sql = "select * from clients where id = '" . $data['client_id'] . "'";
			
			$query = $this->db->query($sql);

			$rs = $query->result_array();
			return $rs;
		}

	}
	
	public function get_client_groups_by_id($data){
		if ($data['client_id']){
			$this->db->select('b.groupId');
			$this->db->from('clients a');
			$this->db->join('clientGroups b', 'a.id = b.clientId');
			$this->db->where(array("a.id" => $data['client_id']));
				
			$query = $this->db->get();
	
			$rs = $query->result_array();
			//echo $this->db->last_query();
			return $rs;
		}
	}
	
	
	
	public function get_all_groups(){

		$this->db->select('*');
		$this->db->from('groups');
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