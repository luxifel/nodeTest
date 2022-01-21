<?php

declare(strict_types=1);

namespace ScalapayTask\api;

/**
 * Interface OrderApiInterface
 * @package ScalapayTask\api
 */
interface OrderApiInterface
{

    /**
     * @param string $body
     * @return array
     */
    public function createOrder(string $body): array;

}