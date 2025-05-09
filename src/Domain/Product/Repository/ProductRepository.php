<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Entity\Ids\ProductId;
use App\Domain\Entity\Product;

interface ProductRepository
{
    public function getOneByProductId(ProductId $productId): Product;

    public function store(Product $product): void;
}
