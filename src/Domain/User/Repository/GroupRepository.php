<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Entity\Group;
use App\Domain\Entity\Ids\GroupId;
use App\Domain\Entity\Ids\UserId;
use App\Domain\ValueObject\Slug;

interface GroupRepository
{
    public function getByGroupId(GroupId $groupId): Group;

    public function getBySlug(Slug $slug): Group;

	/**
	 * @param array<Group> $groups
	 */
    public function storeForUser(UserId $userId, array $groups): void;
}
