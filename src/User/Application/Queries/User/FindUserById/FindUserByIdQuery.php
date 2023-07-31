<?php

namespace User\Application\Queries\User\FindUserById;

use Common\Domain\Bus\Query\Query;
use User\Domain\ValueObjects\UserId;

class FindUserByIdQuery extends UserId implements Query
{
}