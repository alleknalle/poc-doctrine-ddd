<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User\Entity;

use App\Domain\Entity\Group;
use App\Domain\Entity\Ids\GroupId;
use App\Domain\User\ValueObject\Name;
use App\Domain\ValueObject\Slug;
use PHPUnit\Framework\TestCase;

final class UserGroupTest extends TestCase
{
    public function testUserGroupCanBeCreated(): void
    {
        new Group(
            GroupId::fromInt('test'),
            Slug::fromString('cool'),
            Name::fromString('blaat'),
        );

        $this->expectNotToPerformAssertions();
    }
}
