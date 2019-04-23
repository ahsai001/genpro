<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 

class ASR_Controller extends MY_Controller {
    public $CI;
    public $Authorization;
    public $screensize;
    public $model;
    public $meid;
    public $packagename;
    public $versionname;
    public $versioncode;
    public $lang;
    public $platform;
    public $os;
    public $deviceid;
    public $useragent;

    public $returnArr;

    function __construct() {
        parent::__construct();
        $this->getMetaData();
        $this->CI = &get_instance();
    }

    function getMetaData(){
        $this->Authorization = base64_decode($this->input->get_request_header('Authorization', TRUE));
        $this->screensize = $this->input->get_request_header('x-screensize', TRUE);
        $this->model = $this->input->get_request_header('x-model', TRUE);
        $this->meid = $this->input->get_request_header('x-meid', TRUE);
        $this->packagename = $this->input->get_request_header('x-packagename', TRUE);
        $this->versionname = $this->input->get_request_header('x-versionname', TRUE);
        $this->versioncode = $this->input->get_request_header('x-versioncode', TRUE);
        $this->lang = $this->input->get_request_header('x-lang', TRUE);
        
        $this->platform = $this->input->get_request_header('x-platform', TRUE);
        if(!isset($this->platform) || empty($this->platform)){
            $this->platform = 'android';
        }
        
        $this->os = $this->input->get_request_header('x-os', TRUE);
        $this->deviceid = $this->input->get_request_header('x-deviceid', TRUE);
        $this->useragent = $this->input->get_request_header('x-useragent', TRUE);
    }


    public function doAuthorizeAndRun($anonFunction){
        $query = 'APIKEY';
        if(isset($this->Authorization) && !empty($this->Authorization) && substr($this->Authorization, 0, strlen($query)) === $query){
            $dataAuthArray = explode('=', $this->Authorization);
            if(count($dataAuthArray) >= 2){
                $this->load->model('apikeys_model');
                if($this->apikeys_model->isAuthorized($dataAuthArray[1], $this->packagename, $this->platform)){
                    $anonFunction();
                } else {
                    $this->sendResultArray(array(
                        'status' => -3, 
                        'message' => 'UnAuthorized')); 
                }
            } else {
                $this->sendResultArray(array(
                    'status' => -2, 
                    'message' => 'UnAuthorized')); 
            }
        } else {
            $this->sendResultArray(array(
                'status' => -1, 
                'message' => 'UnAuthorized')); 
        }
    }

    public function sendResultArray($resultArray){
        $this->returnArr = $resultArray;
        echo json_encode($this->returnArr);
    }
 
}