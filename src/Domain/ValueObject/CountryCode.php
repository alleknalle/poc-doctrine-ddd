<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum CountryCode: string
{
    case NL = 'nl';
    case BE = 'be';
    case FR = 'fr';
    case DE = 'de';
}
