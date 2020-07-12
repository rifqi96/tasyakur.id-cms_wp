<?php

namespace Tasyakur\Queues\Messages;

use Tasyakur\Adapters\MessageQueue\Contracts\Message;
use Tasyakur\Queues\Handlers\SendEmailHandler;

class SendWpMailMessage extends Message
{
    public function __construct($to, string $subject, string $message, $headers = '', $attachments = [])
    {
        $queueId = 'email_queue';
        $handlerClass = SendEmailHandler::class;
        $data = compact('to', 'subject', 'message', 'headers', 'attachments');
        parent::__construct($queueId, $handlerClass, $data);
    }
}