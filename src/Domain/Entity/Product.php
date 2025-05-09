<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Ids\ProductId;
use App\Domain\Product\ValueObject\Name;
use App\Domain\ValueObject\Price;

final class Product
{
    public function __construct(
        private ProductId $productId,
        private Name $name,
        private Price $price,
    ) {
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
