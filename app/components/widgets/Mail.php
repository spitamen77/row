<?php
namespace app\components;
use Uni;

class Mail
{
    public static function send($toEmail, $subject, $template, $data = [], $options = [])
    {
        //echo $template;exit;
        if(!filter_var($toEmail, FILTER_VALIDATE_EMAIL) || !$subject || !$template){
            return false;
        }
        $data['subject'] = trim($subject);

        $message = Uni::$app->mailer->compose($template, $data)
            ->setTo($toEmail)
            ->setSubject($data['subject']);

        if(filter_var('ax5165@gmail.com', FILTER_VALIDATE_EMAIL)){
            $message->setFrom('ax5165@gmail.com');
        }

        if(!empty($options['replyTo']) && filter_var($options['replyTo'], FILTER_VALIDATE_EMAIL)){
            $message->setReplyTo($options['replyTo']);
        }

        return $message->send();
    }
}