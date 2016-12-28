<?php
namespace Multiple\Library;

use Phalcon\Di;
use Multiple\Library\PHPMailer\smtp,
    Multiple\Library\PHPMailer\PHPMailer as PHPMailer;
use Phalcon\Mvc\View;

class ExceptionHandler
{

    public static function handle($exception, $render = true)
    {
        $config = new \Phalcon\Config\Adapter\Php(PUBLIC_PATH ."/../config/config.php");
        $debug = new \Phalcon\Debug();
        if($config->appmode=='debug'){
            $debug->onUncaughtException($exception);
        } else {
            ob_start();
            $debug->onUncaughtException($exception);
            $contents = ob_get_contents();
            ob_end_clean();
            self::sendEmail($contents, $exception->getMessage()."<br/>".$exception->getTraceAsString()."<br/>");
            if ($render) {
                self::render($contents);
                exit;
            }
        }
    }

    public static function handleFatal($error){
        $contents = htmlspecialchars(json_encode($error));
        self::sendEmail($contents, $contents);
        self::render($contents);
        exit;
    }

    public static function sendEmail($contents, $text = ''){
        $path = self::saveErrToFile($contents);
        $mail = \Multiple\Library\Mailer::getExceptionsMail();
        $mail->Body = \Multiple\Library\Mailer::getTemplate(['name' => 'ADMIN', 'sendername' => 'Admin', 'text'=>$text,'path' => $path], 'exceptions', 'send');
        $mail->Send();
    }

    public static function render($contents){
        $assets = new \Phalcon\Assets\Manager();
        $assets
            ->addCss('css/jquery-ui.css')
            ->addCss('css/style.css')
            ->addCss('css/media.css');
        $assets->outputCss();
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir(PUBLIC_PATH.'/../apps/frontend/views/');
        $view->setDI(new \Phalcon\DI\FactoryDefault());
        $view->registerEngines(array(".phtml" => "\Phalcon\Mvc\View\Engine\Volt"));
        $view->setVar('t', \Phalcon\Di::getDefault()->get("translate", ['sw']));
        $view->setVar('assets', $assets);
        echo $view->getRender('errors', 'show500');
    }

    public static function saveErrToFile($content)
    {
        $name_file = date("Ymdhis") . "_" . rand(1, 100) . ".html";
        $fp = fopen(PUBLIC_PATH .'/exceptions/' . $name_file, 'w');
        fwrite($fp, $content);
        fclose($fp);
        return "/public/exceptions/" . $name_file;
    }
}
