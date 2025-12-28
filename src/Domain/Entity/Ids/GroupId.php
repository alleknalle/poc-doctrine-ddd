<?php

declare(strict_types=1);

namespace App\Domain\Entity\Ids;

final readonly class GroupId
{
    private function __construct(
		private int $groupId
	) {
    }

    public static function fromInt(int $groupId): self
    {
        return new self($groupId);
    }

    public function toInt(): int
    {
        return $this->groupId;
    }
}
