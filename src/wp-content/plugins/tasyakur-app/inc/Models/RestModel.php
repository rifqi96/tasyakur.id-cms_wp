<?php
namespace Tasyakur\Models;

abstract class RestModel extends Model
{
    protected $id;

    protected $method;

    protected $route;

    protected $headers = [];

    protected $params = [];

    public function __construct(array $params = [])
    {
        if (!isset($params['id']))
            throw new \Exception('Id is not set', 400);

        if (!isset($params['route']))
            throw new \Exception('Method is not set', 400);

        $this->id = $params['id'];
        $this->route = $params['route'];
        $this->method = $params['method'] ?? 'GET';
        $this->headers = $params['header'] ?? [];
        $this->params = $params['params'] ?? [];
        parent::__construct();
    }

    public function getFullRoute(): string
    {
        return "$this->route/$this->id";
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route)
    {
        $this->route = $route;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

}