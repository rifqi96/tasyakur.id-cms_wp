<?php

namespace Tasyakur\Middleware;

use Tasyakur\Core\Exceptions\ValidationException;

class PrivateClient
{
    /**
     * @var string
     */
    private $clientKey;

    public function __construct()
    {
        $this->clientKey = getenv('PRIVATE_CLIENT_KEY');
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function handle(): bool
    {
        $requestKey = $_SERVER['HTTP_CLIENT_KEY'] ?? '';

        if (!$this->clientKey)
            throw new ValidationException([
                'client_key' => 'Client key is not set'
            ], 400);

        return $requestKey === $this->clientKey;
    }
}