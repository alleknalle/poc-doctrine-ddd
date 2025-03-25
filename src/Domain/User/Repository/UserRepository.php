<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\ValueObject\Username;

interface UserRepository
{
    public function getByUserId(UserId $userId): User;

    public function getByUsername(Username $username): User;

    public function getByUserGroup(UserGroup $userGroup): array;

    public function store(User $user): void;
}
