<?php

declare(strict_types=1);

namespace App\Domain\Order\Entity;

use App\Domain\Product\Enum\Currency;
use App\Domain\Product\ValueObject\Cents;
use App\Domain\Product\ValueObject\Price;
use App\Domain\Shared\ValueObject\OrderId;
use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\ValueObject\Address;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\Username;

final class Order
{
    private array $orderLines = [];
    private Price $totalPrice;

    public function __construct(
        private OrderId $orderId,
        private UserId|null $userId,
        private Username|null $userUsername,
        private FullName $userFullName,
        private Address $billingAddress,
        private Address $shippingAddress
    ) {
        $this->calculateTotalPrice();
    }

    public function addOrderLine(OrderLine $orderLine): void
    {
        $this->orderLines[] = $orderLine;
        $this->calculateTotalPrice();
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    public function getUserUsername(): ?Username
    {
        return $this->userUsername;
    }

    public function getUserFullName(): FullName
    {
        return $this->userFullName;
    }

    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }

    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    public function getOrderLines(): array
    {
        return $this->orderLines;
    }

    public function getTotalPrice(): Price
    {
        return $this->totalPrice;
    }

    private function calculateTotalPrice(): void
    {
        $cents = 0;
        foreach ($this->orderLines as $orderLine) {
            $orderLineTotalPrice = $orderLine->getTotalPrice();
            $cents += $orderLineTotalPrice->getCents()->toInt();
        }

        // Deze even altijd in euros...
        $this->totalPrice = Price::fromCurrencyAndCents(Currency::EURO, Cents::fromInt($cents));
    }
}
