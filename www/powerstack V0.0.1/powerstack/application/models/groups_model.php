<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model
{
	
	public function insert_group($data){
		
		$data = array('name' => $data['groupName'], 'status' => 1);
		$this->db->insert('groups',$data);

	}
	
	public function delete_group($data){
		
		$sqldata = array('id' => $data['groupId']);
		$this->db->delete('groups',$sqldata);
		$sqldata = array('groupId' => $data['groupId']);
		$this->db->delete('clientgroups',$sqldata);
	}
	
	
	public function get_all_groups($status = 1){

		$this->db->select('*');
		$this->db->from('groups');
		$this->db->order_by('name');
			
		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		return $rs;

	}
	
	public function update_group($data){

		$update = array('name' => $data['groupName']);
		$this->db->where("id",$data['groupId']);
		$this->db->update('groups',$update);
	}
	
	public function get_group_by_id($data){
		
		if ($data['groupId']){
			//$rs = $this->get_currency_by_desc($data['currency']);
			$sql = "select * from groups where id = '" . $data['groupId'] . "'";
			
			$query = $this->db->query($sql);

			$rs = $query->result_array();
			return $rs;
		}

	}
}