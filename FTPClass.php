<?php
namespace Multiple\Library;

use Phalcon\Di;

class FTPClass
{
    protected
        $_ftp,
        $_config = [];

    protected function getConfig(){
        $di = DI::getDefault();
        $this->_config = $di->get("ftp");
    }

    public function connect()
    {
        $this->getConfig();
        $this->_ftp = ftp_connect($this->_config['host']);
        if (!ftp_login($this->_ftp, $this->_config['user'], $this->_config['pass'])) {
            ftp_close($this->_ftp);
            return false;
        }
        ftp_pasv($this->_ftp, true);
        return true;
    }

    public function scanDir($path = '.') {
        return ftp_nlist($this->_ftp, $path);
    }

    public function goToDir($path)
    {
        return ftp_chdir($this->_ftp, $path);
    }

    public function getFile($lfile, $rfile)
    {
        return ftp_get($this->_ftp, $lfile, $rfile,  FTP_BINARY);
    }


    function __destruct(){
        if($this->_ftp) ftp_close($this->_ftp);
    }

}
