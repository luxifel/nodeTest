<?php

declare(strict_types=1);

namespace ScalapayTask\model;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use ScalapayTask\api\OrderApiInterface;
use ScalapayTask\utils\DbHelper;

/**
 * Class OrderApiManager
 * @package ScalapayTask\model
 */
class OrderApiManager implements OrderApiInterface
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var DbHelper
     */
    protected $dbHelper;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * OrderApiManager constructor.
     * @param Client $httpClient
     * @param DbHelper $dbHelper
     * @param OrderRepository $orderRepository
     */
    public function __construct(Client $httpClient, DbHelper $dbHelper, OrderRepository $orderRepository)
    {
        $this->httpClient = $httpClient;
        $this->dbHelper = $dbHelper;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param string $body
     * @return array
     */
    public function createOrder(string $body): array
    {
        $configsData = $this->dbHelper->getConfigs(['staging_api_url', 'staging_api_token', 'redirect_cancel_url']);

        try {
            $response = $this->httpClient
                ->request('POST', $configsData['staging_api_url'].'/v2/orders', [
                    'body' => $body,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $configsData['staging_api_token'],
                        'Content-Type' => 'application/json',
                    ],
                ]);

            if (200 === $response->getStatusCode()) {
                $decodedResponse = json_decode((string)$response->getBody());
                $body = json_decode($body);

                // todo create also shipping + customer entity

                $order = new Order((float)$body->totalAmount->amount, $body->totalAmount->currency, null, null, $body->items);
                $this->orderRepository->save($order);
                $responseData['redirectUrl'] = $decodedResponse->checkoutUrl;
            }
        } catch (GuzzleException $e) {
            $responseData['redirectUrl'] = $configsData['redirect_cancel_url'];
            error_log($e->getMessage());
        }

        return $responseData;
    }


}