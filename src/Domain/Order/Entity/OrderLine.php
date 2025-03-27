<?php

declare(strict_types=1);

namespace App\Domain\Order\Entity;

use App\Domain\Order\ValueObject\Amount;
use App\Domain\Order\ValueObject\OrderLineId;
use App\Domain\Product\ValueObject\Cents;
use App\Domain\Product\ValueObject\Name;
use App\Domain\Product\ValueObject\Price;
use App\Domain\Shared\ValueObject\ProductId;

class OrderLine
{
    private Price $totalPrice;

    public function __construct(
        private Order $order,
        private OrderLineId $orderLineId,
        private ProductId $productId,
        private Name $productName,
        private Price $productPrice,
        private Amount $amount,
    ) {
        $this->calculateTotalPrice();
        $this->order->addOrderLine($this);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOrderLineId(): OrderLineId
    {
        return $this->orderLineId;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getProductName(): Name
    {
        return $this->productName;
    }

    public function getProductPrice(): Price
    {
        return $this->productPrice;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getTotalPrice(): Price
    {
        return $this->totalPrice;
    }

    private function calculateTotalPrice(): void
    {
        $this->totalPrice = Price::fromCurrencyAndCents($this->productPrice->getCurrency(), Cents::fromInt($this->productPrice->getCents()->toInt() * $this->amount->toInt()));
    }
}
