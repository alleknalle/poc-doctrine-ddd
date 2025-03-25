<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\ValueObject\Slug;

interface UserGroupRepository
{
    public function getByUserGroupId(UserGroupId $userGroupId): UserGroup;

    public function getBySlug(Slug $slug): UserGroup;

    public function store(UserGroup $userGroup): void;
}
