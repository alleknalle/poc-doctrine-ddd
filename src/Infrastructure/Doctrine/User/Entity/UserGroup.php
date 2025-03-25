<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserGroup
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $slug;

    #[ORM\Column(length: 255)]
    private string $name;

    public function __construct(
        string $userGroupId,
        string $slug,
        string $name
    ) {
        $this->id = $userGroupId;
        $this->slug = $slug;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
