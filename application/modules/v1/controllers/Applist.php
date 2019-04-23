<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Applist extends REST_Controller {

    function index_get($countperpage=10, $page=1) {
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

                            array('image' => 'https://statics.zaitunlabs.com/genpro/images/applist/dzikirharian.png', 'title' => 'Dzikir Harian', 'desc' => 'Aplikasi Dzikir Harian mengandung bacaan dzikir seperti dzikir pagi & petang, dzikir setelah shalat, manfaat dzikirnya & referensi dzikirnya.
                            
Aplikasi ini disertai pula dengan audio/suara dzikirnya serta dengan adanya reminder/pengingat waktu untuk dzikir pagi dan petang, sehingga memudahkan kita untuk merutinkan membacanya setiap hari.
                            
Selain itu, aplikasi ini juga disertai dengan dalil-dalil yang melandasinya, sehingga semakin yakinlah kita untuk membacanya.
                            
Aplikasi ini dibuat untuk memudahkan penggunanya untuk jauh lebih mudah membaca dan menghafal dzikir harian berdasarkan Al-Quran dan hadits Shahih (hadits yang pasti datangnya dari Rasullullah Shallallahu ‘alaihi wa sallam)', 'unique' => 'com.zaitunlabs.dzikirharian', 'url' => 'https://zaitunlabs.com/yourls/downloaddzikirharianandroid' ),
                            array('image' => 'https://statics.zaitunlabs.com/genpro/images/applist/sahabatmuslim.png', 'title' => 'Sahabat Muslim', 'desc' => 'Sahabat Muslim adalah aplikasi yang berfungsi untuk mencari jadwal kajian sunnah yang ada di sekitar anda.
                            
Untuk saat ini jadwal kajian yang tertera masih sangat sedikit karena masih dalam tahap awal penambahan data kajian, bagi anda yang tertarik untuk membantu kami dalam menambahkan data, silahkan kirim email ke sahabatmuslim@zaitunlabs.com
                            
Kedepannya aplikasi sahabat muslim ini juga akan menjadi aplikasi portal yang tidak hanya menampilkan jadwal kajian, diantaranya akan berisi kisah-kisah muslim dan lain-lain.','unique' => 'com.zaitunlabs.salim', 'url' => 'https://zaitunlabs.com/yourls/sahabatmuslim' )


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