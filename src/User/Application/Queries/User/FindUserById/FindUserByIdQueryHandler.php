<?php

namespace User\Application\Queries\User\FindUserById;

use User\Domain\Entities\User;
use Common\Domain\Bus\Query\QueryHandler;
use User\Domain\Repositories\UserRepositoryInterface;

class FindUserByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(FindUserByIdQuery $query): ?User
    {
        return $this->userRepository->findOneBy([
            'id' => $query->getId(),
        ]);
    }
}