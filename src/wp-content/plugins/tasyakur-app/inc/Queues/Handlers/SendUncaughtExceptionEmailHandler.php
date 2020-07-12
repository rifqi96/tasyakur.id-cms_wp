<?php
namespace Tasyakur\Queues\Handlers;

use Tasyakur\Core\Exceptions\SafeException;
use Tasyakur\Facades\FileSystem\FileCreator;
use Tasyakur\Facades\Mail\Mail;
use Tasyakur\Facades\MessageQueue\Job;
use Exception;

class SendUncaughtExceptionEmailHandler extends SendEmailHandler
{
    public function __construct(Job $job, Mail $mail)
    {
        parent::__construct($job, $mail);
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

            //Recipients
            $recipients = getenv('ADMIN_EMAILS') ?? get_option('admin_email');
            $recipients = explode(',', $recipients);

            // Exit if no recipient
            if (!is_array($recipients) || count($recipients) < 1) {
                $this->job->delete();
                throw new SafeException('No recipient');
            }

            // Content
            $serverName = ENVIRONMENT ?? getenv('ENVIRONMENT') ?? 'local';
            $appName = getenv('APP_NAME') ?? 'Tasyakur';
            $subject = "[$appName] Uncaught exception error report on $serverName server";
            $data = $this->job->getData();
            ob_start();
            include(app()::getBasePath() . '/resources/views/error_mail.php');
            $body = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $logFilePath = '/var/www/html/wp-content/uploads/uncaught-exception.log';
            $fileCreated = FileCreator::create($logFilePath, $data['exception']);
            if (!$fileCreated)
                $logFilePath = '';

            $res = $this->mail::send($recipients, $subject, $body, $headers, $logFilePath);

            if ($logFilePath && $fileCreated)
                FileCreator::remove($logFilePath);

            if (!$res)
                throw new Exception('Mailer library returned false');

            echo "SendUncaughtExceptionEmailHandler: Email successfully sent \n";
            echo "\n";
            $this->job->delete();
        } catch (Exception $e) {
            echo "SendUncaughtExceptionEmailHandler: Error sending email - {$e->getMessage()} - in {$e->getFile()} at line {$e->getLine()} - Trace: \n";
            var_dump($e->getTrace());
            add_action('wp_mail_failed', [$this, 'dumpWpMailFailed']);
            remove_action('wp_mail_failed', [$this, 'dumpWpMailFailed']);
            echo "\n";
            echo "Burying the job";
            echo "\n";
            $this->job->bury();
        }
    }
}