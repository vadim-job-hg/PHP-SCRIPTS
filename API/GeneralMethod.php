<?php
//abstract factory
abstract class GeneralMethod {
    protected
        $_config;
    public
        $_data = [],
        $_xml_data = '',
        $_header = '',
        $_method = 'method',
        $_url = 'https://url',
        $_curl_options = array(
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0
        );

    function __construct($data = null){
        if($data) $this->_data = $data;
        //get config
    }

    public function make_xml_data($data = null){
        if($data) $this->_data = $data;
        $request_xml = '';
        foreach($this->_data as $key=>$item)
            $request_xml .= "<$key>$item</$key>";
        $this->_xml_data = '<?xml version="1.0" encoding="utf-8"?>
           <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			  <soap:Body>
				<'.$this->_method.'  xmlns="CURRENTAPI">
                  <Username>'. $this->_config['username'].'</Username>
                  <Password>'.$this->_config['password'].'</Password>
                  <Token>'.$this->_config['token'].'</Token>
                  '.$request_xml.'
                </'.$this->_method.'>
              </soap:Body>
            </soap:Envelope>';
    }

    public function make_header(){
        $this->_header = array(
            "Content-Type: text/xml; charset=utf-8",
            'SOAPAction: "CURRENTAPI/'.$this->_method.'"',
            "Content-length: " . strlen($this->_xml_data),
        );
    }

    public function call_request($data = null){
        $this->make_xml_data($data);
        $this->make_header();
        $ch = curl_init($this->_url);
        $this->_curl_options[CURLOPT_POSTFIELDS] = $this->_xml_data;
        $this->_curl_options[CURLOPT_HTTPHEADER] = $this->_header;
        curl_setopt_array($ch, $this->_curl_options);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);        
        //exit;
    }
}



