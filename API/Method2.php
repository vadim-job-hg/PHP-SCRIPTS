<?php
class Method2 extends GeneralMethod {
    public
        $_method = 'Method2',
        $_url = 'https://another_url';
    public function make_header(){ //another header
        $this->_header = array(
            "Content-Type: text/xml; charset=utf-8",
            'SOAPAction: "http://XpressWAIS_BLL/IMS/'.$this->_method.'"',
            "Content-length: " . strlen($this->_xml_data),
        );
        return $this->_header;
    }

    public function make_xml_data($data = null){ //another xml response
        if($data) $this->_data = $data;
        $request_xml = '';
        foreach($this->_data as $key=>$item)
            $request_xml .= "<$key>$item</$key>";
        $this->_xml_data = '<?xml version="1.0" encoding="utf-8"?>
           <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
             <soap:Body>
                <'.$this->_method.' xmlns="http://www.outsystems.com">
                  <UserName>'. $this->_config['username'].'</UserName>
                  <Password>'.$this->_config['password'].'</Password>
                  <Token>'.$this->_config['token'].'</Token>
                  '.$request_xml.'
                </'.$this->_method.'>
              </soap:Body>
            </soap:Envelope>';
        return $this->_xml_data;
    }

    public function get_xml_xpress_data(){
        $object = $this->_xml_object->Body->Method2;
        if($object->Result=='true')
            return $object;
        else {
            $this->_errors[] = $object->Message;
            return false;
        }
    }
}
