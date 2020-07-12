<?php

namespace Tasyakur\Core\Exceptions;

use Tasyakur\Core\Exceptions\BaseHandler as ExceptionHandler;
use Tasyakur\Setup\Hooks\NotFoundRedirect;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;
use Whoops\Util\Misc;

class WhoopsHandler extends ExceptionHandler
{
    /**
     * List of exceptions that should not be reported
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        AuthenticationException::class,
        ValidationException::class,
        ResourceNotFoundException::class,
        PageNotFoundException::class,
        AttachmentNotServedByCloud::class,
        SafeException::class,
        NotFoundRedirect::class,
    ];

    public function __construct()
    {
        parent::__construct(
            new Whoops()
        );
    }

    /**
     * Register the handler for production environment (Don't show the env)
     * @return void
     */
    public function registerProduction()
    {
        $this->handler->prependHandler(function ($exception, $exceptionInspector, $run) {
            // Run the handler
            $this->handle($exception);

            // If it's handled by the handler and expecting a json response,
            // interrupt the handler with wp_send_json() and return the response immediately
            if ($this->isHandled && $this->expectsJson()) {
                $this->returnJson();
            } else if ($this->isHandled && !$this->expectsJson() && is_admin()) {
                $this->flashMessage();
            }

            // This area is already the unhandled exception area.
            // Return a nice error page

            try {
                if ($this->statusCode)
                    $this->handler->sendHttpCode($this->statusCode);
            }
            // Catch and fallback to 500 if the statusCode is not a valid httpStatusCode
            catch (\InvalidArgumentException $e) {
                $this->handler->sendHttpCode(500);
            }

            include_once(app()::getBasePath() . '/resources/views/error_view.php');

            // Report the exception, since it's unhandled.
            parent::report($exception);

            return \Whoops\Handler\Handler::DONE;
        });
    }

    /**
     * Register the handler with env
     * @return void
     */
    public function registerDebug()
    {
        // We want the error page to be shown by default, if this is a
        // regular request, so that's the first thing to go into the stack:
        $this->handler->prependHandler(
            new PrettyPageHandler()
        );

        // Now, we want a second handler that will run before the error page,
        // and immediately return an error message in JSON format, if something
        // goes awry.
        if ($this->expectsJson()) {
            $jsonHandler = new JsonResponseHandler();
            // Tell JsonResponseHandler to give you a full stack trace:
            $jsonHandler->addTraceToOutput(true);
            // You can also return a result compliant to the json:api spec
            // re: http://jsonapi.org/examples/#error-objects
            // tl;dr: error[] becomes errors[[]]
            $jsonHandler->setJsonApi(true);
            // And push it into the stack:
            $this->handler->prependHandler($jsonHandler);
        }

        // Register the first custom handler
        $this->handler->prependHandler(function ($exception) {
            // Run the handler
            $this->handle($exception);

            // If it's handled by the handler and expecting a json response,
            // interrupt the handler with wp_send_json() and return the response immediately
            if ($this->isHandled && $this->expectsJson()) {
                $this->returnJson();
            } else if ($this->isHandled && !$this->expectsJson() && is_admin()) {
                $this->flashMessage();
            }

            // This area is already the unhandled exception area.
            // Don't return anything! Since the exception is unhandled by our custom handler,
            // it should go to the JsonResponse/PrettyPage handler immediately to show out all the debugs and traces
        });
    }

    /**
     * Check whether the client requests json output
     * @return bool
     */
    public function expectsJson(): bool
    {
        return Misc::isAjaxRequest() || parent::expectsJson();
    }

    /**
     * Method to handle the exceptions
     *
     * @param \Throwable $exception
     * @return mixed|void
     */
    public function handle(\Throwable $exception)
    {
        // Form a basic response
        $statusCode = 500;
        $message = 'Something went wrong.';

        // Set fallback properties
        if (method_exists($exception, 'getCode') && $exception->getCode()) {
            $statusCode = $exception->getCode();
            $this->isHandled = !$this->isHandled ?: true;
        }
        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode()) {
            $statusCode = $exception->getStatusCode();
            $this->isHandled = !$this->isHandled ?: true;
        }
        if (method_exists($exception, 'getMessage') && $exception->getMessage()) {
            $message = $exception->getMessage();
            $this->isHandled = !$this->isHandled ?: true;
        }

        // Handle ValidationException
        if ($exception instanceof ValidationException) {
            $this->data = ['errors' => $exception->getErrors()];
            $this->isHandled = true;
        }

        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    /**
     * Return json message template
     */
    protected function returnJson(): void
    {
        $body = [
            'status' => $this->statusCode,
            'message' => $this->message,
        ];
        $body = array_merge($body, $this->data);
        wp_send_json($body, $this->statusCode);
    }

    /**
     * Return a flash message to the page
     */
    protected function flashMessage(): void
    {
        $statusCode = $this->statusCode;
        $message = $this->message;
        $data = $this->data;

        createSessionResponse($statusCode, $message, $data);

        flashAdminNotice($message, $statusCode, $data);
        //refreshPage();
    }
}