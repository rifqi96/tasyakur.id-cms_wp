<?php
namespace Tasyakur\Queues\Handlers;

use Tasyakur\Adapters\MessageQueue\Contracts\Handler;
use Tasyakur\Facades\Mail\Mail;
use Tasyakur\Facades\MessageQueue\Job;
use Exception;

class SendEmailHandler extends Handler
{
    /**
     * @var Mail
     */
    protected $mail;

    public function __construct(Job $job, Mail $mail)
    {
        $this->mail = $mail;

        parent::__construct($job);
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->send();
    }

    /**
     * Method for sending the email
     * @return void
     * @throws \Exception
     */
    protected function send(): void
    {
        try {
            // Send email logic
            $data = $this->job->getData();
            $res = $this->mail::send($data['to'], $data['subject'], $data['message'], $data['headers'], $data['attachments']);

            if (!$res)
                throw new Exception('Mailer library returned false');

            echo "SendEmailHandler: Email successfully sent \n";
            echo "\n";
            $this->job->delete();
        } catch (Exception $e) {
            echo "SendEmailHandler: Error sending email - {$e->getMessage()} - in {$e->getFile()} at line {$e->getLine()} - Trace: \n";
            var_dump($e->getTrace());
            add_action('wp_mail_failed', [$this, 'dumpWpMailFailed']);
            remove_action('wp_mail_failed', [$this, 'dumpWpMailFailed']);
            echo "\n";
            echo "Burying the job";
            echo "\n";
            $this->job->bury();
        }
    }

    /**
     * Handles wp_mail_failed action
     * @param $e
     */
    protected function dumpWpMailFailed( $e )
    {
        echo "WP Mail trace: \n";
        var_dump($e);
    }
}