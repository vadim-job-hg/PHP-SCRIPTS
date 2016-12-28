<?php
function UncachedErrorsCheck( ) {
    $lasterror = error_get_last();
    switch ($lasterror['type'])
    {
        case E_ERROR:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_USER_ERROR:
        case E_RECOVERABLE_ERROR:
        case E_CORE_WARNING:
        case E_COMPILE_WARNING:
        case E_PARSE:
            $loader = new \Phalcon\Loader();
            $loader->registerNamespaces(array('Multiple\Library' => PUBLIC_PATH.'/../apps/library/'))->registerDirs(array(PUBLIC_PATH . '/../apps/library/',PUBLIC_PATH . '/../apps/library/PHPMailer'))->register();
            \Multiple\Library\ExceptionHandler::handleFatal($lasterror);
    }
}
register_shutdown_function('UncachedErrorsCheck');