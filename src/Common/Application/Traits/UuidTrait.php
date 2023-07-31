<?php

namespace Common\Application\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
trait UuidTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    protected UuidInterface $id;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface|string|null $id = null)
    {
        if ($id instanceof UuidInterface) {
            $this->id = $id;

            return;
        }

        if (null === $id || '' === trim($id)) {
            $this->id = Uuid::uuid4();

            return;
        }

        $this->id = Uuid::fromString($id);
    }
}
