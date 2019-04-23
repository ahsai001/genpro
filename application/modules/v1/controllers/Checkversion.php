<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Checkversion extends ASR_Controller {
    public $appid;
    function __construct() {
        parent::__construct();
    }
 
    function index() {
        $this->appid = $this->input->post('appid');

        $CI = &$this;
        $this->doAuthorizeAndRun(function() use ($CI) {
            $CI->load->model('apps_model');
            $appInfo = $CI->apps_model->getAppInfo($CI->appid);
            if((int)$CI->versioncode < $appInfo['newest_version_code']){
                //need update
                $arr = array(
                    'status' => 2,
                    'title' => $appInfo['download_title'],
                    'message' => $appInfo['download_message'],
                    'detail' => $appInfo['download_detail']
                );
            } else {
                $arr = array(
                    'status' => 1,
                    'title' => 'Info',
                    'message' => 'Success',
                    'detail' => ''
                );
            }
        
        

            $CI->sendResultArray($arr);
        });
    }
}