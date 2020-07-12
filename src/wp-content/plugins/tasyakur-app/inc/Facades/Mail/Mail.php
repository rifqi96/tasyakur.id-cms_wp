<?php
namespace Tasyakur\Facades\Mail;

use Tasyakur\Adapters\Mail\Contracts\AbstractMail;

class Mail
{
    use WpPhpMailer;

    /**
     * @var AbstractMail
     */
    private $mailer;

    /**
     * Hold the instance of the class
     *
     * @var self|null
     */
    protected static $instance = null;

    public function __construct(AbstractMail $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Call this method to get the singleton
     *
     * @return static|self
     */
    public static function getInstance(): self
    {
        if (!static::$instance) {
            static::$instance = app()->get(static::class);
        }

        return static::$instance;
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
    public static function send($to, string $subject, string $message, $headers = '', $attachments = []): bool
    {
        $mailFacade = static::getInstance();

        return $mailFacade->wp_mail($to, $subject, $message, $headers, $attachments);
    }
}
