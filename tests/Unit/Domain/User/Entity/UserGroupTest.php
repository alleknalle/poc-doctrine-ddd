<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User\Entity;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Slug;
use PHPUnit\Framework\TestCase;

final class UserGroupTest extends TestCase
{
    public function testUserGroupCanBeCreated(): void
    {
        new UserGroup(
            UserGroupId::fromString('test'),
            Slug::fromString('cool'),
            Name::fromString('blaat'),
        );

        $this->expectNotToPerformAssertions();
    }
}
