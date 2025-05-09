<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum Currency: string
{
    case EURO = 'euro';
    case USD = 'usd';
}
