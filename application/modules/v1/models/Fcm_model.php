<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fcm_model extends CI_Model {
	/*
    public $table = 'FCMs'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
	public $protected = array(); // ...Or you can set an array with the fields that cannot be filled by insert/update
	public function __construct(){
        $this->timestamps = TRUE;
        $this->soft_deletes = FALSE;
		parent::__construct();
	}*/

	private $tblName = "FCMs";
	public function __construct(){
		parent::__construct();
	}
	

	public function insert($data){
		$this->load->database();
		$this->db->insert($this->tblName, $data);
		if($this->db->affected_rows() > 0){
			return true;
		}
		return false;
	}
}

?>