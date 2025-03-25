<?php

declare(strict_types=1);

namespace App\Domain\Order\ValueObject;

use App\Domain\User\Enum\Currency;

final class Money
{
    public function __construct(
        private Currency $currency,
        private int $amount
    ) {
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
