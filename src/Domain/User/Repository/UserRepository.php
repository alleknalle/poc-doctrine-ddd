<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Entity\Ids\GroupId;
use App\Domain\Entity\Ids\UserId;
use App\Domain\Entity\User;

interface UserRepository
{
    public function getByUserId(UserId $userId): User;

    public function getByGroupId(GroupId $groupId): array;

    public function store(User $user): void;
}
