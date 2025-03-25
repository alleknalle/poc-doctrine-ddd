<?php

declare(strict_types=1);

namespace App\Tests\Fixture;

use App\Infrastructure\Doctrine\User\Entity\UserGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

final class UserGroupFixture extends AbstractFixture
{
    public const string ADMIN = 'group1';
    public const string MANAGER = 'group2';

    public function load(ObjectManager $manager): void
    {
        $adminUserGroup = new UserGroup(
            self::ADMIN,
            'admin',
            'Administrator'
        );

        $manager->persist($adminUserGroup);

        $managerUserGroup = new UserGroup(
            self::MANAGER,
            'manager',
            'Manager'
        );

        $manager->persist($managerUserGroup);
        $manager->flush();

        $this->addReference(self::ADMIN, $adminUserGroup);
        $this->addReference(self::MANAGER, $managerUserGroup);
    }
}
