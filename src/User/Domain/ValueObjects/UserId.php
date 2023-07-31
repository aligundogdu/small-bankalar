<?php

namespace User\Domain\ValueObjects;

use Symfony\Component\Uid\Uuid;

class UserId
{
    private Uuid|string $id;

    public function __construct(string|Uuid $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        if ($this->id instanceof Uuid) {
            return $this->id->toRfc4122();
        }

        return $this->id;
    }

    public function setId(Uuid|string $id): void
    {
        $this->id = $id;
    }
}