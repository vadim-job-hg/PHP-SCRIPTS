<?php
class Method3 extends GeneralMethod {
    public
        $_method = 'Method3',
        $_url = 'https://another_url';

    public function get_xml_xpress_data(){
        $object = $this->_xml_object->Body->Method3;
        if($object->Success=='true')
            return $object->Result;
        else {
            $this->_errors[] = $object->ErrorList->UserDescription;
            return false;
        }

    }
}
