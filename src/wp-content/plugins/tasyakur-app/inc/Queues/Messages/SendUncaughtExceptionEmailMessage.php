<?php
namespace Tasyakur\Queues\Messages;

use Tasyakur\Adapters\MessageQueue\Contracts\Message;
use Tasyakur\Queues\Handlers\SendUncaughtExceptionEmailHandler;

class SendUncaughtExceptionEmailMessage extends Message
{
    /**
     * @var int|string
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var \Throwable
     */
    private $exception;

    public function __construct($code, string $message, array $errors, \Throwable $exception)
    {
        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
        $this->exception;
        $queueId = 'email_queue';
        $handlerClass = SendUncaughtExceptionEmailHandler::class;
        $data = [
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
            'exception' => $exception,
        ];

        // Append the request (trigger) url if there's any to the data
        $requestUrl = '';
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI']))
            $requestUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (isset($requestUrl) && $requestUrl)
            $data['requestUrl'] = $requestUrl;

        parent::__construct($queueId, $handlerClass, $data);
    }

    /**
     * @return int|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return \Throwable
     */
    public function getException(): \Throwable
    {
        return $this->exception;
    }
}