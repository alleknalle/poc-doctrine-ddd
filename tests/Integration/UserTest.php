<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserGroup;
use App\Domain\User\Repository\UserGroupRepository;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Slug;
use App\Domain\User\ValueObject\Username;
use App\Tests\Fixture\UserFixture;
use App\Tests\Fixture\UserGroupFixture;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserTest extends KernelTestCase
{
    protected AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

    public function testStoreUsersAndGroups(): void
    {
        $this->databaseTool->loadFixtures([]);

        $userGroupRepo = self::getContainer()->get(UserGroupRepository::class);

        $adminUserGroup = new UserGroup(
            new UserGroupId('group1'),
            new Slug('admin'),
            new Name('Administrator'),
        );

        $userGroupRepo->store($adminUserGroup);

        $userRepo = self::getContainer()->get(UserRepository::class);

        $user = new User(
            new UserId('user1'),
            new Username('scienta'),
            new Name('Scienta B.V.'),
            $adminUserGroup
        );
        $userRepo->store($user);

        $user2 = new User(
            new UserId('user2'),
            new Username('scienta2'),
            new Name('Scienta B.V.2'),
            $adminUserGroup,
        );
        $userRepo->store($user2);

        $this->expectNotToPerformAssertions();
    }

    public function testGetUsersAndGroups(): void
    {
        $this->databaseTool->loadFixtures([UserFixture::class]);

        /** @var UserRepository $userRepo */
        $userRepo = self::getContainer()->get(UserRepository::class);

        $adminUser = $userRepo->getByUserId(new UserId('user1'));

        self::assertInstanceOf(User::class, $adminUser);
        self::assertSame('user1', $adminUser->getUserId()->getUserId());
        self::assertSame('scienta', $adminUser->getUsername()->getUsername());
        self::assertSame('Scienta B.V.', $adminUser->getName()->getName());

        self::assertSame('group1', $adminUser->getUserGroup()->getUserGroupId()->getUserGroupId());
        self::assertSame('admin', $adminUser->getUserGroup()->getSlug()->getSlug());
        self::assertSame('Administrator', $adminUser->getUserGroup()->getName()->getName());

        /** @var UserGroupRepository $userGroupRepo */
        $userGroupRepo = self::getContainer()->get(UserGroupRepository::class);

        $managerGroup = $userGroupRepo->getByUserGroupId(new UserGroupId(UserGroupFixture::MANAGER));

        $users = $userRepo->getByUserGroup($managerGroup);

        self::assertCount(2, $users);
    }

    public function testUpdateUser(): void
    {
        $this->databaseTool->loadFixtures([UserFixture::class]);

        /** @var UserRepository $userRepo */
        $userRepo = self::getContainer()->get(UserRepository::class);

        $adminUser = $userRepo->getByUserId(new UserId('user1'));

        $adminUser->update(
            new Username('nieuwe-naam'),
            new Name('nieuwe naam'),
        );

        $userRepo->store($adminUser);
    }
}
