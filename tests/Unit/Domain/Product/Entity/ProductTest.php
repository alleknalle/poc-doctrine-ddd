<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Product\Entity;

use App\Domain\Product\Entity\Product;
use App\Domain\Product\Enum\Currency;
use App\Domain\Product\ValueObject\Cents;
use App\Domain\Product\ValueObject\Name;
use App\Domain\Product\ValueObject\Price;
use App\Domain\Shared\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testProductCanBeCreated(): void
    {
        new Product(
            ProductId::fromString('my-product-id'),
            Name::fromString('My Product Name'),
            Price::fromCurrencyAndCents(
                Currency::EURO,
                Cents::fromInt(250)
            )
        );

        $this->expectNotToPerformAssertions();
    }
}
