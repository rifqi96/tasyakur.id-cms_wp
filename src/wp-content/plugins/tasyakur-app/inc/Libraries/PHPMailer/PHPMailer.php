<?php

namespace Tasyakur\Libraries\PHPMailer;

use Tasyakur\Adapters\Mail\Contracts\AbstractMail;
use Pheanstalk\Exception;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerLib;
use PHPMailer\PHPMailer\SMTP;

class PHPMailer extends AbstractMail
{
    private $phpMailer;

    public function __construct(PHPMailerLib $mail)
    {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mailDriver = getenv('MAIL_DRIVER') ?: 'smtp';
        if ($mailDriver === 'smtp') {
            $mail->isSMTP();                                            // Send using SMTP
        }
        else if ($mailDriver === 'sendmail') {
            $mail->isSendmail();
        }
        else if ($mailDriver === 'qmail') {
            $mail->isQmail();
        }
        // mail
        else {
            $mail->isMail();
        }
        $mail->Host       = getenv('MAIL_HOST');                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = getenv('MAIL_USERNAME');                     // SMTP username
        $mail->Password   = getenv('MAIL_PASSWORD');                               // SMTP password
        $mail->SMTPSecure = getenv('MAIL_ENCRYPTION') ?? PHPMailerLib::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = getenv('MAIL_PORT') ?? 587;                                    // TCP port to connect to
        $mail->From = getenv('MAIL_FROM');
        $mail->FromName = getenv('APP_NAME');

        $this->phpMailer = $mail;
    }

    /**
     * Sends email
     * @param string|array $to          Array or comma-separated list of email addresses to send message.
     * @param string       $subject     Email subject
     * @param string       $message     Message contents
     * @param string|array $headers     Optional. Additional headers.
     * @param string|array $attachments Optional. Files to attach.
     * @return bool Whether the email contents were sent successfully.
     */
    public function send($to, string $subject, string $message, $headers = '', $attachments = []): bool
    {
        try {
            if ($this->from && $this->fromName)
                $this->phpMailer->setFrom($this->from, $this->fromName, false);
            if ($this->body)
                $this->phpMailer->Body = $this->body;
            if ($this->subject)
                $this->phpMailer->Subject = $this->subject;

            return $this->phpMailer->send();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function setFrom(string $address, string $name = ''): void
    {
        parent::setFrom($address, $name);
    }

    public function setSubject(string $subject): void
    {
        parent::setSubject($subject);
        $this->phpMailer->Subject = $subject;
    }

    public function setBody(string $body): void
    {
        parent::setBody($body);
        $this->phpMailer->Body = $body;
    }

    /**
     * @return PHPMailerLib
     */
    public function getPhpMailer(): PHPMailerLib
    {
        return $this->phpMailer;
    }
}