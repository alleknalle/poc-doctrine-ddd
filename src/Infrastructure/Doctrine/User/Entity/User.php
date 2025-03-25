<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $username;

    #[ORM\Column(length: 255)]
    private string $name;

    // #[ORM\Column(type: Types::INTEGER, length: 10)]
    // private int $userGroupId;

    #[ORM\ManyToOne(targetEntity: UserGroup::class, inversedBy: 'users')]
    private UserGroup $userGroup;

    public function __construct(
        string $userId,
        string $username,
        string $name,
        // int $userGroupId
        UserGroup $userGroup,
    ) {
        $this->id = $userId;
        $this->username = $username;
        $this->name = $name;
        // $this->userGroupId = $userGroupId;
        $this->userGroup = $userGroup;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserGroupId(): int
    {
        return $this->userGroupId;
    }

    public function getUserGroup(): UserGroup
    {
        return $this->userGroup;
    }
}
