<?php

namespace Tasyakur\Adapters\Mail\Contracts;

abstract class AbstractMail
{
    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $fromName;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * Sets from address
     * @param string $address
     * @param string $name
     */
    public function setFrom(string $address, string $name = ''): void
    {
        $this->from = $address;
        $this->fromName = $name;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
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
    public abstract function send($to, string $subject, string $message, $headers = '', $attachments = []): bool;
}