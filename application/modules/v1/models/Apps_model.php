<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps_model extends CI_Model {
	private $tblName = "Apps";
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	

	public function insert($data){
		$this->db->insert($this->tblName, $data);
		if($this->db->affected_rows() > 0){
			return true;
		}
		return false;
	}

	public function getAppInfo($appid){
		$this->db->select("newest_version_code, download_title, download_message, download_detail");
		$this->db->from($this->tblName);
		$wherearray = array('id' => (int)$appid);
		$this->db->where($wherearray);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }
		return 0;
	}


}

?>