<?php

declare(strict_types=1);

namespace ScalapayTask\controller;

use ScalapayTask\utils\OrderHelper;
use ScalapayTask\model\OrderApiManager;

/**
 * Class Order
 * @package ScalapayTask\controller
 */
class Order
{
    /**
     * @var OrderHelper
     */
    protected $orderHelper;

    /**
     * @var OrderApiManager
     */
    protected $orderManager;

    /**
     * Order constructor.
     * @param OrderHelper $orderHelper
     * @param OrderApiManager $orderManager
     */
    public function __construct(OrderHelper $orderHelper, OrderApiManager $orderManager)
    {
        $this->orderHelper = $orderHelper;
        $this->orderManager = $orderManager;
    }

    /**
     * @param array $data
     * @return array
     */
    public function execCreateOrder(array $data): array
    {
        $body = $this->orderHelper->preparePayload($data);
        $returnData = [];

        if (false !== $body) {
            $response = $this->orderManager->createOrder($body);

            $returnData = [
                'redirectUrl' => $response['redirectUrl'],
            ];
        }

        return $returnData;
    }

}