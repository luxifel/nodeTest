<?php

declare(strict_types=1);

namespace ScalapayTask\model;

/**
 * Class OrderRepository
 * @package ScalapayTask\model
 */
class OrderRepository
{
    /**
     * @var DbResource
     */
    private $dbResource;

    /**
     * OrderRepository constructor.
     * @param DbResource $dbResource
     */
    public function __construct(DbResource $dbResource)
    {
        $this->dbResource = $dbResource;
    }

    /**
     * @param Order $order
     */
    public function save(Order $order): void
    {
        $sql1 = "INSERT INTO orders(total_amount, currency) 
        VALUES ({$order->getTotalAmount()}, '{$order->getCurrency()}')";

        try {
            $stm = $this->dbResource->getConnection()->prepare($sql1);
            $stm->execute();

            $lastOrderId = $this->dbResource->getConnection()->lastInsertId();

            foreach ($order->getItems() as $item){
                $sqlItems = "INSERT INTO order_items(id_order, sku, name, category, qty, amount, currency)  
            VALUES ({$lastOrderId}, '{$item->sku}', '{$item->name}', '{$item->category}', 
                    {$item->quantity}, {$item->price->amount}, '{$item->price->currency}')";

                $stm = $this->dbResource->getConnection()->prepare($sqlItems);
                $stm->execute();
            }

        } catch (\PDOException $e){
            error_log($e->getMessage());
        }

    }

}