<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactReqRepository")
 */
class ContactReq
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fk_receiving_user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_sending_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="contactReqs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_receiving_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getFkSendingUser(): ?User
    {
        return $this->fk_sending_user;
    }

    public function setFkSendingUser(?User $fk_sending_user): self
    {
        $this->fk_sending_user = $fk_sending_user;

        return $this;
    }

    public function getFkReceivingUser(): ?User
    {
        return $this->fk_receiving_user;
    }

    public function setFkReceivingUser(?User $fk_receiving_user): self
    {
        $this->fk_receiving_user = $fk_receiving_user;

        return $this;
    }
}
