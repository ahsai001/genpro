<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apikeys_model extends CI_Model {
	/*
    public $table = 'APIKeys'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
	public $protected = array(); // ...Or you can set an array with the fields that cannot be filled by insert/update
	public function __construct(){
        $this->timestamps = TRUE;
        $this->soft_deletes = FALSE;
		parent::__construct();
	}*/
	private $tblName = "APIKeys";
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

	public function countWhere($api, $packagename, $platform){
		$this->db->select("*");
		$this->db->from($this->tblName);
		$this->db->join('Apps','Apps.id = '.$this->tblName.'.appid');
		$wherearray = array('api' => $api, 'Apps.packagename' => $packagename, 'Apps.platform' => $platform);
		$this->db->where($wherearray);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function isAuthorized($api, $packagename, $platform){
		return $this->countWhere($api, $packagename, $platform) > 0;
	}

}

?>