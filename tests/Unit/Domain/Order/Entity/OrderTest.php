<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Order\Entity;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\OrderLine;
use App\Domain\Order\ValueObject\Amount;
use App\Domain\Order\ValueObject\OrderLineId;
use App\Domain\Product\Enum\Currency;
use App\Domain\Product\ValueObject\Cents;
use App\Domain\Product\ValueObject\Name;
use App\Domain\Product\ValueObject\Price;
use App\Domain\Shared\ValueObject\OrderId;
use App\Domain\Shared\ValueObject\ProductId;
use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Enum\CountryCode;
use App\Domain\User\ValueObject\Address;
use App\Domain\User\ValueObject\City;
use App\Domain\User\ValueObject\FirstName;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\HouseNumber;
use App\Domain\User\ValueObject\LastName;
use App\Domain\User\ValueObject\MiddleName;
use App\Domain\User\ValueObject\PostalCode;
use App\Domain\User\ValueObject\Street;
use App\Domain\User\ValueObject\Username;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    public function testOrderCanBeCreated(): void
    {
        $order = new Order(
            OrderId::fromString('my-order-id'),
            UserId::fromString('user-id'),
            Username::fromString('test-user'),
            FullName::fromNames(
                FirstName::fromString('Sebas'),
                MiddleName::fromString('van der'),
                LastName::fromString('Gekte'),
            ),
            Address::fromAddressLines(
                Street::fromString('test street'),
                HouseNumber::fromString('14'),
                PostalCode::fromString('1111AA'),
                City::fromString('Harderwijk'),
                CountryCode::NL
            ),
            Address::fromAddressLines(
                Street::fromString('berlinerstraße'),
                HouseNumber::fromString('11-a'),
                PostalCode::fromString('123456'),
                City::fromString('Berlin'),
                CountryCode::DE
            ),
        );

        $this->assertSame(0, $order->getTotalPrice()->getCents()->toInt());

        new OrderLine(
            $order,
            OrderLineId::fromString('my-order-line-id'),
            ProductId::fromString('my-product-id'),
            Name::fromString('my product'),
            Price::fromCurrencyAndCents(Currency::EURO, Cents::fromInt(150)),
            Amount::fromInt(2)
        );

        $this->assertSame(300, $order->getTotalPrice()->getCents()->toInt());

        new OrderLine(
            $order,
            OrderLineId::fromString('my-order-line-id-2'),
            ProductId::fromString('my-product-id-2'),
            Name::fromString('my product 2'),
            Price::fromCurrencyAndCents(Currency::EURO, Cents::fromInt(10)),
            Amount::fromInt(1)
        );

        $this->assertSame(310, $order->getTotalPrice()->getCents()->toInt());
    }
}
