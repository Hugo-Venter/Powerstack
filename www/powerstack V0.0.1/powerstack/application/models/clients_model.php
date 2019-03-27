<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients_model extends CI_Model
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
	
	public function delete_client($data){
		
		$sqldata = array('id' => $data['clientId']);
		$this->db->delete('clients',$sqldata);
		$sqldata = array('clientId' => $data['clientId']);
		$this->db->delete('clientgroups',$sqldata);
	}
	
	public function get_client_count(){

		$rs = $this->db->count_all('clients');
		//$query = $this->db->get();

		//$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}
	
	public function update_client($data){

		$update = array('computerName' => $data['computerName'],'ip' => $data['ip'], 'TVID' => $data['TVID'], 'status' => $data['status']);
		$this->db->where("id",$data['id']);
		$this->db->update('clients',$update);
	}
	
	public function update_client_groups($data){
		if (isset($data['groupIds'])){
			$delete = array('clientId' => $data['client_id']);
			$this->db->where($delete);
			$this->db->delete("clientgroups");
			for ($i = 0; $i < count($data['groupIds']);$i++){
				$groupinsert = array('clientId' => $data['client_id'], 'groupId' => $data['groupIds'][$i]);
				$this->db->insert('clientgroups',$groupinsert);
			}
		}
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
	
	public function get_accounts($data){
		
		if ($data['id']){
			//$rs = $this->get_currency_by_desc($data['currency']);
			$sql = "select a.*, b.desc as currency_desc from userDepositAddresses a join currency b on a.currency = b.id where a.user_id = '" . $data['id'] . "' order by a.currency";
			
			$query = $this->db->query($sql);

			$rs = $query->result_array();
			return $rs;
		}

	}
	
	public function get_address_by_id($id){
		
		if ($id){
				$sql1 = "select a.*, b.desc as currency_desc from userDepositAddresses a join currency b on a.currency = b.id where a.id = '" . $id . "'";	
				$query = $this->db->query($sql1);
				//echo $this->db->last_query();
				$rs = $query->result_array();
				
				if (!$rs){
					//Nothing found lets generate them
					
				}else{

					return $rs;
				}

		}
	}
}