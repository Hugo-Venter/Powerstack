<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_model extends CI_Model
{

	public function get_backup_count(){
		$yesterday_start = date("Y-m-d 00:00:00", strtotime( '-1 days' ));
		$yesterday_end = date("Y-m-d 23:59:59", strtotime( '-1 days' ));
		$this->db->select('count(*) as count');
		$this->db->from('log');
		$this->db->where(array('process' => 'Backups', 'errorcode' => 'A0001'));
		$this->db->where('datestamp >=', $yesterday_start);
		$this->db->where('datestamp <=', $yesterday_end);

		$query = $this->db->get();

		$rs = $query->result_array();
		//echo $this->db->last_query();
		//die();
		return $rs;

	}
	
	public function get_backups(){
		$yesterday_start = date("Y-m-d 00:00:00", strtotime( '-1 days' ));
		$yesterday_end = date("Y-m-d 23:59:59", strtotime( '-1 days' ));
		//$sql = "Select a.*, b.* from log a left join clients b on a.clientId = b.id union all Select a.*, b.* from log a right join clients b on a.clientId = b.id";
		//$sql .= " where a.process = 'Backups' and a.datestamp between '" . $yesterday_start . "' and '" . $yesterday_end . "'";
		$this->db->select('a.*,b.*');
		$this->db->from('log a');
		$this->db->where(array('a.process' => 'Backups'));
		$this->db->join('clients b', 'a.clientId = b.id');
		$this->db->where('datestamp >=', $yesterday_start);
		$this->db->where('datestamp <=', $yesterday_end);
		$this->db->order_by('b.computerName');

		$query = $this->db->get();
		//$query = $this->db->query($sql);

		$rs = $query->result_array();
		//echo $this->db->last_query();
		//die();
		return $rs;
	}
	
	public function get_backups_missing(){
		$yesterday_start = date("Y-m-d 00:00:00", strtotime( '-1 days' ));
		$yesterday_end = date("Y-m-d 23:59:59", strtotime( '-1 days' ));
		$sql = "select id, computerName from clients where id not in (";
		$sql .= "Select b.id from log a join clients b on a.clientId = b.id ";
		$sql .= " where a.process = 'Backups' and a.datestamp between '" . $yesterday_start . "' and '" . $yesterday_end . "') order by computerName";
		//$this->db->select('a.*,b.*');
		//$this->db->from('log a');
		//$this->db->where(array('a.process' => 'Backups'));
		//$this->db->join('clients b', 'a.clientId = b.id');
		//$this->db->where('datestamp >=', $yesterday_start);
		//$this->db->where('datestamp <=', $yesterday_end);

		//$query = $this->db->get();
		$query = $this->db->query($sql);


		$rs = $query->result_array();
		//echo $this->db->last_query();
		//die();
		return $rs;
	}
}