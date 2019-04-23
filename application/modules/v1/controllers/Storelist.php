<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Storelist extends REST_Controller {

    function index_post($countperpage=10, $page=0) {
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
                    $arr = array(
                        'status' => 1, 
                        'message' => 'success',
                        'paging' => array(
                            'countperpage' => (int)$countperpage, 
                            'prev' => -1, 
                            'next' => -1), 
                        'data' => array(
                            /*
                            array('image' => 'https://drive.google.com/uc?export=view&id=1imbPH8LM87JdTeZJ1Auzv6bnlCbyOokY', 'title' => 'Speaker Quds F2', 'desc' => 'Speaker Quds F2 : HI-FI suara jernih, micro-sd 16GB Sandisk class 10, support radio AM Rodja, terdapat fungsi repeat sangat bagus untuk program hafalan anak dan orang tua.

Untuk detail silakan klik item ini', 'unique' => '', 'url' => 'https://www.instagram.com/toko.almuwahhid' )*/

                            /*
                            array('image' => 'http://cina.panduanwisata.id/files/2012/08/b7adbc0a2cca9d3e12d77836_Wutong_Mountain.jpg', 'title' => 'Paket pariwisata 1', 'desc' => 'paket ini terdiri dari beberapa tempat wisata menarik yaitu pemandangan indah dari pegunungan di indonesia', 'unique' => '', 'url' => 'http://www.review1st.com' ),
                            array('image' => 'https://www.yukpiknik.com/wp-content/uploads/2016/01/Eco-Green-Park.jpg', 'title' => 'Sahabat Muslim', 'desc' => 'paket ini terdiri dari beberapa tempat wisata menarik yaitu pemandangan indah dari pegunungan di indonesia','unique' => '', 'url' => 'http://www.review1st.com' ) */



                            
                            )); 
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