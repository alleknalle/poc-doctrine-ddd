<?php

declare(strict_types=1);

namespace App\Domain\Order\Entity;

use App\Domain\Shared\ValueObject\UserId;

final class Order
{
    public function __construct(
        private OrderId $orderId,
        private UserId $userId,
        private array $orderLines,
    ) {
    }
}
