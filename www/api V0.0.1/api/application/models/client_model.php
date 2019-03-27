<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model
{
	
	public function insert_client($data){
		
		$data = array('apiKey' => $data['apiKey'], 'computerName' => $data['computerName'], 'ip' => $data['ip'], 'dateCreated' => date('Y-m-d H:i:s'), 'dateCreated' => date('Y-m-d H:i:s'));
		$this->db->insert('clients',$data);
		$id = $this->db->insert_id();
		return $id;

	}
	
	public function insert_client_group($data){
		
		$data = array('clientId' => $data['clientId'], 'groupId' => $data['groupId']);
		$this->db->insert('clientgroups',$data);
		//$id = $this->db->insert_id();
		//return $id

	}
	
	public function get_client_by_key($apiKey){
		
		if ($apiKey){
			$this->db->select('*');
			$this->db->from('clients');
			$this->db->where("apiKey = '" . $apiKey . "'");
			
			$query = $this->db->get();

			$rs = $query->result_array();
			return $rs;
		}

	}
	
	public function update_client_last_con($apiKey){
		
		if ($apiKey){
			$data = (array('lastComs' => date('Y-m-d H:i:s')));
			$this->db->where("apiKey",$apiKey);
			$this->db->update('clients',$data);
			
		}

	}

}