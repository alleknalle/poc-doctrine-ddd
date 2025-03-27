<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Product\ValueObject\Name;
use App\Domain\Product\ValueObject\Price;
use App\Domain\Shared\ValueObject\ProductId;

class Product
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
