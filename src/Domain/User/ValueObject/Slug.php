<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class Slug
{
    private function __construct(private string $slug)
    {
    }

    public static function fromString(string $slug): self
    {
        return new self($slug);
    }

    public function toString(): string
    {
        return $this->slug;
    }
}
