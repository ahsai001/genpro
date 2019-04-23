<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Waapi extends REST_Controller {

    function index_post() {
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
                       $nowa = $this->post("nowa");
                       $message = $this->post("message");

                       //$linkwa = 'https://wa.me/'.(empty($nowa)?'':($nowa.'/')).'?text='.$message;
                       $linkwa = 'https://api.whatsapp.com/send?phone='.(empty($nowa)?'':$nowa).'&text='.$message;

                       $long_url = $linkwa;

                        //using tinyurl
                        
                       $api_url = "https://tinyurl.com/api-create.php?url=".$long_url;
                         $arr = array(
                            'status' => 1, 
                            'message' => 'success',
                            'data' => array(
                                'linkwa' => $long_url,
                                'linkshort' => file_get_contents($api_url)
                            ));


                        //using htt.nu
                       /*
                       $api_token = '200d75c4f3d2dc6b494935af3fb7b36f8d148a34';
                       $api_url = "https://htt.nu/api?api={$api_token}&url={$long_url}";
                       $result = @json_decode(file_get_contents($api_url),TRUE);
                       
                       
                       if($result["status"] === 'error') {
                            $arr = array(
                            'status' => 1, 
                            'message' => 'success',
                            'data' => array(
                                'linkwa' => $linkwa,
                                'linkshort' => $result["message"]
                            ));
                       } else {
                            $arr = array(
                            'status' => 1, 
                            'message' => 'success',
                            'data' => array(
                                'linkwa' => $linkwa,
                                'linkshort' => $result["shortenedUrl"]
                            ));
                        }
                        */

                        
                } else {
                    $arr = array(
                        'status' => -1, 
                        'message' => 'UnAuthorized'); 
                }
            } else {
                $arr = array(
                    'status' => -2, 
                    'message' => 'UnAuthorized'); 
            }
        } else {
            $arr = array(
                'status' => -3, 
                'message' => 'UnAuthorized'); 
        }
        
        $this->response($arr,200);
    }
}
?>