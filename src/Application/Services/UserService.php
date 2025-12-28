<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\User\Repository\UserRepository;

final readonly class UserService
{

	public function __construct(
		private readonly UserRepository $userRepository,
	) {
	}



	public function storeUserWithGroups()
	{

	}

}