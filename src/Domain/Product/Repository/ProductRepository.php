<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Entity\Product;
use App\Domain\Shared\ValueObject\ProductId;

interface ProductRepository
{
    public function getOneByProductId(ProductId $productId): Product;

    public function store(Product $product): void;
}
