<?php

declare(strict_types=1);

namespace App\Domain\Product\Enum;

enum Currency: string
{
    case EURO = 'euro';
    case USD = 'usd';
}
