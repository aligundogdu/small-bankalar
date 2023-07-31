<?php

namespace Common\Application\Traits;

use User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

trait Creation
{
    /**
     * @ORM\Column(type="datetime")
     * @Groups({"transaction", "formAnswerIndex"})
     */
    protected ?\DateTimeInterface $createdAt;


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt = null)
    {
        if (null === $createdAt) {
            $createdAt = new \DateTime();
        }

        $this->createdAt = $createdAt;

        return $this;
    }


}
