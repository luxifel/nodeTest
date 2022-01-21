<?php

declare(strict_types=1);


namespace ScalapayTask\utils;

/**
 * Class OrderHelper
 * @package ScalapayTask\utils
 */
class OrderHelper
{

    /**
     * @var DbHelper
     */
    protected $dbHelper;

    /**
     * OrderHelper constructor.
     * @param DbHelper $dbHelper
     */
    public function __construct(DbHelper $dbHelper)
    {
        $this->dbHelper = $dbHelper;
    }


    /**
     * @param array $data
     * @return string
     */
    public function preparePayload(array $data): string
    {
        $configsData = $this->dbHelper->getConfigs(['redirect_cancel_url', 'redirect_confirm_url']);

        $body = [
          'totalAmount' => [
              'amount' => (string)array_sum($data['items']['amount']),
              'currency' => 'EUR',
          ],
            'consumer' => [
                'givenNames' => $data['name'],
                'surname' => $data['surname'],
            ],
            'shipping' => [
                'countryCode' => $data['countrycode'],
                'name' => $data['sh_name'],
                'postcode' => $data['postcode'],
                'line1' => $data['address1'],
            ],
            'merchant' => [
                'redirectCancelUrl' => $configsData['redirect_cancel_url'],
                'redirectConfirmUrl' => $configsData['redirect_confirm_url']
            ]
        ];

        $items = [];
        for ($i = 0; $i < count($data['items']['sku']); $i++){
            $items[] = [
                'name' => $data['items']['name'][$i],
                'sku' => $data['items']['sku'][$i],
                'amount' => $data['items']['amount'][$i],
                'quantity' => $data['items']['qty'][$i],
                'category' => $data['items']['category'][$i],
            ];
        }


        foreach ($items as $item) {
            $body['items'][] = [
                'price' => [
                    'amount' => (string)$item['amount'],
                    'currency' => 'EUR',
                ],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
                'category' => $item['category'],
                'sku' => $item['sku'],
            ];
        }

        return json_encode($body);
    }

}