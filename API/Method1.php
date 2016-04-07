<?php
class Method1 extends GeneralMethod {

    public
        $_method = 'Method1';

    public function get_xml_xpress_data(){
        $object = $this->_xml_object->Body->Method1;
        if($object->Success=='true')
            return $object->Result->Method1;
        else {
            $this->_errors[] = $object->ErrorList->UserDescription;
            return false;
        }

    }
}
