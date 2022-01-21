<?php

declare(strict_types=1);

namespace ScalapayTask\router;

/**
 * Class Main
 * @package ScalapayTask\router
 */
class Main
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $requestUri;

    /**
     * @param string $requestUri
     * @param string $method
     */
    public function resolveUri(string $requestUri, string $method): void
    {
        $this->method = $method;
        $this->requestUri = $requestUri;
    }

    /**
     * @param string $path
     * @param \Closure $callback
     */
    public function get(string $path, \Closure $callback): void
    {
        if ('GET' === $this->method && $path === $this->requestUri) {
            $callback();
        }
    }

    /**
     * @param string $path
     * @param \Closure $callback
     */
    public function post(string $path, \Closure $callback): void
    {
        if ('POST' === $this->method && $path === $this->requestUri) {
            $callback($_POST);
        }
    }

}