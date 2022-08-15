<?php

    class BaseController {

        public function response($status, $message, $data) {
            header("HTTP/1.1 ".$status);
	
            $response['status'] = $status;
            $response['status_message'] = $message;
            $response['data'] = $data;
            
            $json_response = json_encode($response);
            return $json_response;
        }
    }