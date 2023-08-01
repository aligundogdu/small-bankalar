<?php

namespace Common\Application\Traits;

use Symfony\Component\String\Slugger\AsciiSlugger;
use User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use function Symfony\Component\String\u;

trait Slugify
{

    private AsciiSlugger $slugger;


    public function makeSlug($string, $lower = true): string
    {
        $this->slugger = new AsciiSlugger();
        $string = u($string)->trim()->toString();
        if ($lower) {
            $string = u($string)->lower();
        }
        return $this->slugger->slug($string)->trim()->toString();
    }

}
