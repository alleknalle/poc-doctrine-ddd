<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Mapper;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\Entity\UserGroup as DomainUserGroup;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Slug;
use App\Infrastructure\Doctrine\User\Entity\UserGroup;

final class UserGroupMapper
{
    public function fromDomain(DomainUserGroup $userGroup): UserGroup
    {
        return new UserGroup(
            $userGroup->getUserGroupId()->getUserGroupId(),
            $userGroup->getSlug()->getSlug(),
            $userGroup->getName()->getName(),
        );
    }

    public function toDomain(UserGroup $userGroup): DomainUserGroup
    {
        return new DomainUserGroup(
            new UserGroupId($userGroup->getId()),
            new Slug($userGroup->getSlug()),
            new Name($userGroup->getName()),
        );
    }
}
