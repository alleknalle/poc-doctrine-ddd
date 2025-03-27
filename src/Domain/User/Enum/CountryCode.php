<?php

declare(strict_types=1);

namespace App\Domain\User\Enum;

enum CountryCode: string
{
    case NL = 'nl';
    case BE = 'be';
    case FR = 'fr';
    case DE = 'de';
}
