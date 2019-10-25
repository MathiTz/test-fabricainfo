<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $Type_person;

    /**
     * @ORM\Column(type="integer")
     */
    private $Identifier;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePerson(): ?string
    {
        return $this->Type_person;
    }

    public function setTypePerson(string $Type_person): self
    {
        $this->Type_person = $Type_person;

        return $this;
    }

    public function getIdentifier(): ?int
    {
        return $this->Identifier;
    }

    public function setIdentifier(int $Identifier): self
    {
        $this->Identifier = $Identifier;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }
}
