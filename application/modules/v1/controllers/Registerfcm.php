<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Registerfcm extends REST_Controller {
    function index_post() {
        $fmcid = $this->post('fcmid');
        $appid = $this->post('appid');

        $Authorization = base64_decode($this->input->get_request_header('Authorization', TRUE));
        $screesize = $this->input->get_request_header('x-screensize', TRUE);
        $model = $this->input->get_request_header('x-model', TRUE);
        $meid = $this->input->get_request_header('x-meid', TRUE);
        $packagename = $this->input->get_request_header('x-packagename', TRUE);
        $versionname = $this->input->get_request_header('x-versionname', TRUE);
        $versioncode = $this->input->get_request_header('x-versioncode', TRUE);
        $lang = $this->input->get_request_header('x-lang', TRUE);
        
        $platform = $this->input->get_request_header('x-platform', TRUE);
        if(!isset($platform) || empty($platform)){
            $platform = 'android';
        }
        
        $os = $this->input->get_request_header('x-os', TRUE);
        $deviceid = $this->input->get_request_header('x-deviceid', TRUE);
        $useragent = $this->input->get_request_header('x-useragent', TRUE);


        $query = 'APIKEY';
        if(isset($Authorization) && !empty($Authorization) && substr($Authorization, 0, strlen($query)) === $query){
            $dataAuthArray = explode('=', $Authorization);
            if(count($dataAuthArray) >= 2){
                $this->load->model('apikeys_model');
                if($this->apikeys_model->isAuthorized($dataAuthArray[1], $packagename, $platform)){
                    $this->load->model('fcm_model');

                    $newdata = array(
                        'fcmid' => $fmcid,
                        'appid' => (int)$appid,
                        'screensize' => $screesize,
                        'model' => $model,
                        'meid' => $meid,
                        'packagename' => $packagename,
                        'versionname' => $versionname,
                        'versioncode' => $versioncode,
                        'lang' => $lang,
                        'platform' => $platform, 
                        'os' => $os, 
                        'deviceid' => $deviceid, 
                        'useragent' => $useragent
                    );

                    if($this->fcm_model->insert($newdata)){
                        $arr = array(
                            'status' => 1, 
                            'message' => 'success'); 
                    } else {
                        $arr = array(
                            'status' => -1, 
                            'message' => 'failed'); 
                    }
                } else {
                    $arr = array(
                        'status' => -1, 
                        'message' => 'UnAuthorized'); 
                }
            } else {
                $arr = array(
                    'status' => -1, 
                    'message' => 'UnAuthorized'); 
            }
        } else {
            $arr = array(
                'status' => -1, 
                'message' => 'UnAuthorized'); 
        }
        
        $this->response($arr,200);
    }
}
?>