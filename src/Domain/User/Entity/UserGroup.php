<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Shared\ValueObject\UserGroupId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Slug;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table(name: 'user_groups')]
#[ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
class UserGroup
{
    #[Column(name: 'user_group_id', type: 'string', length: 32, nullable: false)]
    #[Id]
    private string $columnUserGroupId;

    #[Column(name: 'slug', type: 'string', nullable: false)]
    private string $columnSlug;

    #[Column(name: 'name', type: 'string', nullable: false)]
    private string $columnName;

    public function __construct(
        private UserGroupId $userGroupId {
            get => UserGroupId::fromString($this->columnUserGroupId);
            set (UserGroupId $userGroupId) {
                $this->columnUserGroupId = $userGroupId->toString();
            }
        },
        private Slug $slug {
            get => Slug::fromString($this->columnSlug);
            set (Slug $slug) {
                $this->columnSlug = $slug->toString();
            }
        },
        private Name $name {
            get => Name::fromString($this->columnName);
            set (Name $name) {
                $this->columnName = $name->toString();
            }
        }
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
