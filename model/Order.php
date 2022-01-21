<?php

declare(strict_types=1);

namespace ScalapayTask\model;

/**
 * Class Order
 * @package ScalapayTask\model
 */
class Order // todo order interface & abstract entity class
{
    /**
     * @var float
     */
    protected $totalAmount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var int|null
     */
    protected $customerId;

    /**
     * @var int|null
     */
    protected $shippingId;

    /**
     * @var array
     */
    protected $items;

    /**
     * Order constructor.
     * @param float $totalAmount
     * @param string $currency
     * @param int|null $customerId
     * @param int|null $shippingId
     * @param array $items
     */
    public function __construct(float $totalAmount, string $currency, ?int $customerId, ?int $shippingId, array $items)
    {
        $this->totalAmount = $totalAmount;
        $this->currency = $currency;
        $this->customerId = $customerId;
        $this->shippingId = $shippingId;
        $this->items = $items;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     */
    public function setCustomerId(?int $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int|null
     */
    public function getShippingId(): ?int
    {
        return $this->shippingId;
    }

    /**
     * @param int|null $shippingId
     */
    public function setShippingId(?int $shippingId): void
    {
        $this->shippingId = $shippingId;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

}