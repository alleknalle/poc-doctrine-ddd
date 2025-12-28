<?php

declare(strict_types=1);

namespace App\Domain\Order\Repository;

use App\Domain\Entity\Ids\OrderId;
use App\Domain\Entity\Order;

interface OrderRepository
{
    public function getOneByOrderId(OrderId $orderId): Order;

    public function store(Order $order): void;
}
