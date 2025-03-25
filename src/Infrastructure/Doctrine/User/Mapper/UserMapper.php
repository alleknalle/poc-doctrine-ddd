<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Mapper;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User as DomainUser;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Username;
use App\Infrastructure\Doctrine\User\Entity\User;
use App\Infrastructure\Doctrine\User\Repository\UserGroupRepository;

final class UserMapper
{
    public function __construct(
        private UserGroupRepository $userGroupRepository,
    ) {
    }

    public function fromDomain(DomainUser $user): User
    {
        return new User(
            $user->getUserId()->getUserId(),
            $user->getUsername()->getUsername(),
            $user->getName()->getName(),
            $this->userGroupRepository->getDoctrineByUserGroupId($user->getUserGroup()->getUserGroupId()->getUserGroupId()),
        );
    }

    public function toDomain(User $user): DomainUser
    {
        return new DomainUser(
            new UserId($user->getId()),
            new Username($user->getUsername()),
            new Name($user->getName()),
            $this->userGroupRepository->getByUserGroupId(new UserGroupId($user->getUserGroup()->getId())),
        );
    }
}
