<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Ids\OrderId;
use App\Domain\Entity\Ids\UserId;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\Username;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Cents;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Price;

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
