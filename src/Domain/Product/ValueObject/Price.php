<?php

declare(strict_types=1);

namespace App\Domain\Product\ValueObject;

use App\Domain\Product\Enum\Currency;

final readonly class Price
{
    private function __construct(
        private Currency $currency,
        private Cents $cents
    ) {
    }

    public static function fromCurrencyAndCents(Currency $currency, Cents $cents): self
    {
        return new self($currency, $cents);
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getCents(): Cents
    {
        return $this->cents;
    }

    public function getFormatted(): string
    {
        return $this->currency->name . ' ' . number_format($this->getCents()->toInt() / 100, 2, ',', '');
    }
}
