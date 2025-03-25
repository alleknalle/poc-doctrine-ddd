<?php

declare(strict_types=1);

namespace App\Domain\Order\Entity;

use App\Domain\Order\ValueObject\Money;
use App\Domain\Order\ValueObject\Name;
use App\Domain\Order\ValueObject\OrderLineId;

final class OrderLine
{
    public function __construct(
        private Order $order,
        private OrderLineId $orderLineId,
        private Name $name,
        private Money $price,
    ) {
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOrderLineId(): OrderLineId
    {
        return $this->orderLineId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }
}
