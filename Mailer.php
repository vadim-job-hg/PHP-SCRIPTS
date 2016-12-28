<?php
namespace Multiple\Library;

use Phalcon\Di;
use Multiple\Library\PHPMailer\smtp,
    Multiple\Library\PHPMailer\PHPMailer as PHPMailer;
use Phalcon\Mvc\View;

class Mailer
{

    public static function get($embeddedImages = ['mail_logo' => 'mail_logo.jpg'])
    {
        $di = DI::getDefault();
        $cf = $di->get("mail");
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->SMTPAuth = true;
        $mail->Username = $cf['username'];
        $mail->Password = $cf['password'];
        //$mail->SMTPDebug = 1;
        $mail->CharSet = $cf['charset'];
        $mail->Host = $cf['host'];
        $mail->Port = $cf['port'];
        $mail->SMTPSecure = $cf['security'];
        $mail->SetFrom($cf['email'], $cf['from']);
        foreach ($embeddedImages as $key => $value)
            $mail->AddEmbeddedImage('images/' . $value, $key, $value, "base64", "application/octet-stream");
        return $mail;
    }

    public static function getCronMail()
    {
        $config = new \Phalcon\Config\Adapter\Php(PUBLIC_PATH . "/../config/config.php");
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->SMTPAuth = true;
        $mail->Username = $config->username;
        $mail->Password = $config->password;
        //$mail->SMTPDebug = 1;
        $mail->CharSet = $config->charset;
        $mail->Host = $config->host;
        $mail->Port = $config->port;
        $mail->SMTPSecure = $config->security;
        $mail->SetFrom($config->email, $config->from);
        //foreach ($config->adminemail as $ml)
        //    $mail->AddAddress($ml);
        $mail->AddAddress('vadim-job-hg@yandex.ru');
        return $mail;
    }

    public static function getExceptionsMail()
    {
        $config = new \Phalcon\Config\Adapter\Php(PUBLIC_PATH ."/../config/config.php");
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->SMTPAuth = true;
        $mail->Username = $config->username;
        $mail->Password = $config->password;
        //$mail->SMTPDebug = 1;
        $mail->CharSet = $config->charset;
        $mail->Host = $config->host;
        $mail->Port = $config->port;
        $mail->SMTPSecure = $config->security;
        $mail->SetFrom($config->email, $config->from);
        if (isset($_SERVER['HTTP_HOST']))
            $mail->Subject = 'Джентельмены - у нас проблемы на http://' . $_SERVER['HTTP_HOST'];
        else $mail->Subject = 'Error on BCA';
        foreach ($config->adminemail as $ml)
            $mail->AddAddress($ml);
        return $mail;
    }

    public static function getTemplate($data = [], $folder, $template, $language = 'en')
    {

        $view = new View();
        $view->setViewsDir(PUBLIC_PATH.'/../apps/mailviews/');
        $view->setDI(new \Phalcon\DI\FactoryDefault());
        $view->registerEngines(array(".phtml" => "\Phalcon\Mvc\View\Engine\Volt"));
        $view->setRenderLevel(View::LEVEL_NO_RENDER);
        $view->setVar('curserver', 'http://' . $_SERVER['HTTP_HOST']);
        $view->setVar('t', Di::getDefault()->get("translate", [$language . 'mail']));
        return $view->getRender($folder, $template, $data);
    }
}
