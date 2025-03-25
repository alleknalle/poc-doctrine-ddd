<?php

declare(strict_types=1);

namespace App\Tests\Fixture;

use App\Infrastructure\Doctrine\User\Entity\User;
use App\Infrastructure\Doctrine\User\Entity\UserGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $scientaUser = new User(
            'user1',
            'scienta',
            'Scienta B.V.',
            // $this->getReference(UserGroupFixture::ADMIN, UserGroup::class)->getId(),
            $this->getReference(UserGroupFixture::ADMIN, UserGroup::class),
        );

        $manager->persist($scientaUser);

        $jilleUser = new User(
            'user2',
            'alleknalle',
            'Jille',
            // $this->getReference(UserGroupFixture::MANAGER, UserGroup::class)->getId(),
            $this->getReference(UserGroupFixture::MANAGER, UserGroup::class),
        );

        $manager->persist($jilleUser);

        $annerUser = new User(
            'user3',
            'anner',
            'Anner',
            // $this->getReference(UserGroupFixture::MANAGER, UserGroup::class)->getId(),
            $this->getReference(UserGroupFixture::MANAGER, UserGroup::class),
        );

        $manager->persist($annerUser);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserGroupFixture::class,
        ];
    }
}
