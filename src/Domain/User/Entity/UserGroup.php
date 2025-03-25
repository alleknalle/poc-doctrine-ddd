<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Slug;

final class UserGroup
{
    public function __construct(
        private UserGroupId $userGroupId,
        private Slug $slug,
        private Name $name
    ) {
    }

    public function getUserGroupId(): UserGroupId
    {
        return $this->userGroupId;
    }

    public function getSlug(): Slug
    {
        return $this->slug;
    }

    public function getName(): Name
    {
        return $this->name;
    }

}
