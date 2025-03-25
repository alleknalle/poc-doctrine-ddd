<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Exception;

final class UserNotFoundException extends Exception
{
    private const MESSAGE_TEMPLATE = 'User with %s "%s" not found"';

    public function __construct(string $field, mixed $value)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $field, $value));
    }
}
