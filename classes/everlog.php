<?php

class Everlog {

    public $api_url = 'http://95.168.199.246:3001/';

    public function call($method, $args=NULL, $requestMethod='GET', $requestParams=NULL)
    {
        $out=array();
        if(is_array($args))
        {
            $out = array_map('urlencode', $args);
        }
        $query = http_build_query($out);
        $uri = $this->api_url.$method.($query ? '?'.$query : null);
        $resp = $this->file_get_contents_curl($uri, $requestMethod, $requestParams);
        if(!$resp)
        {
            throw new Exception('Couldn\'t connect to Everlog API.');
        }
        return json_decode($resp,true);
    }

    function file_get_contents_curl($url, $method='GET', $params=NULL) {
            $ch = curl_init();
     
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_URL, $url);

            if($method != 'GET')
            {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                if($params!=NULL)
                {
                    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
                }
            }
            $data = curl_exec($ch);
            curl_close($ch);
     
            return $data;
    }
}
