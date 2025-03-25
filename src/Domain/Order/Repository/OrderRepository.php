<?php

declare(strict_types=1);

namespace App\Domain\Order\Repository;

use App\Domain\Order\Entity\Order;
use App\Domain\Shared\ValueObject\OrderId;

interface OrderRepository
{
    public function getOneByOrderId(OrderId $orderId): Order;

    public function store(Order $order): void;
}
