<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\User;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User
{
	#[ORM\Id]
	#[ORM\Column(length: 255)]
	public string $id;

	#[ORM\Column(length: 255)]
	public string $username;

	#[ORM\Column(length: 255)]
	public string $name;

	 #[ORM\Column(type: Types::INTEGER, length: 10)]
	 public int $groupId;

	public function __construct(
		string $userId,
		string $username,
		string $name,
	 	int $groupId
	) {
		$this->id = $userId;
		$this->username = $username;
		$this->name = $name;
		$this->groupId = $groupId;
//		$this->userGroup = $userGroup;
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

	public function getGroupId(): int
	{
		return $this->groupId;
	}

//	public function getUserGroup(): UserGroup
//	{
//		return $this->userGroup;
//	}
}