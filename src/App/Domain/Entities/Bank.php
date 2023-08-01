<?php

namespace App\Domain\Entities;

use Common\Domain\Entities\Trait\UuidTrait;
use User\Infrastructure\Repositories\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Defines the properties of the User entity to represent the application users.
 * See https://symfony.com/doc/current/doctrine.html#creating-an-entity-class.
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See https://symfony.com/doc/current/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
#[ORM\Entity()]
#[ORM\Table(name: 'banks')]
class Bank
{
    use UuidTrait;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $bankName = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $bankSlug = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $imageUrl = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $swiftCode = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $mainAddress = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $bankCode = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $web = null;

    /**
     * @return string|null
     */
    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    /**
     * @param string|null $bankName
     */
    public function setBankName(?string $bankName): void
    {
        $this->bankName = $bankName;
    }

    /**
     * @return string|null
     */
    public function getBankSlug(): ?string
    {
        return $this->bankSlug;
    }

    /**
     * @param string|null $bankSlug
     */
    public function setBankSlug(?string $bankSlug): void
    {
        $this->bankSlug = $bankSlug;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     */
    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string|null
     */
    public function getSwiftCode(): ?string
    {
        return $this->swiftCode;
    }

    /**
     * @param string|null $swiftCode
     */
    public function setSwiftCode(?string $swiftCode): void
    {
        $this->swiftCode = $swiftCode;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getMainAddress(): ?string
    {
        return $this->mainAddress;
    }

    /**
     * @param string|null $mainAddress
     */
    public function setMainAddress(?string $mainAddress): void
    {
        $this->mainAddress = $mainAddress;
    }

    /**
     * @return string|null
     */
    public function getBankCode(): ?string
    {
        return $this->bankCode;
    }

    /**
     * @param string|null $bankCode
     */
    public function setBankCode(?string $bankCode): void
    {
        $this->bankCode = $bankCode;
    }

    /**
     * @return string|null
     */
    public function getWeb(): ?string
    {
        return $this->web;
    }

    /**
     * @param string|null $web
     */
    public function setWeb(?string $web): void
    {
        $this->web = $web;
    }



}
