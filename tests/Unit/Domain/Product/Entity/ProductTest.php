<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Product\Entity;

use App\Domain\Entity\Ids\ProductId;
use App\Domain\Entity\Product;
use App\Domain\Product\ValueObject\Name;
use App\Domain\ValueObject\Cents;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Price;
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
