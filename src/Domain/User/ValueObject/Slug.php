<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final class Slug
{
    public function __construct(private string $slug)
    {
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
