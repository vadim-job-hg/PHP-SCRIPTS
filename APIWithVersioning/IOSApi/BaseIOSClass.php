<?php
namespace Multiple\Library\IOSApi;

class BaseIOSClass {
    public
        $_request = null,
        $_errors = array(),
        $_errorCode = 0,
        $_resultInfo = [],
        $_success = true;

    public function run(){
        static::runMethod();
        $this->setResultInfo('success', $this->_success);
        $this->setResultInfo('errors', $this->_errors);
        $this->setResultInfo('errorCode', $this->_errorCode);
    }

    public function setResuest($request){
        $this->_request = $request;
    }

    public function setError($error, $errorCode){
        $this->_errors= [$error];
        $this->_errorCode = $errorCode;
        $this->_success = false;
    }

    public function getMessages(){
        return $this->_errors;
    }

    public function getCode(){
        return $this->_errorCode;
    }

    public function getResultInfo(){
        return $this->_resultInfo;
    }



    public function setResultInfo($key, $value){
        $this->_resultInfo[$key] = $value;
    }
 }