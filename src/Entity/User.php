<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contacts", mappedBy="fk_user")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactReq", mappedBy="fk_sending_user")
     */
    private $fk_receiving_user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactReq", mappedBy="fk_receiving_user")
     */
    private $contactReqs;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->fk_receiving_user = new ArrayCollection();
        $this->contactReqs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Contacts[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setFkUser($this);
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getFkUser() === $this) {
                $contact->setFkUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContactReq[]
     */
    public function getFkReceivingUser(): Collection
    {
        return $this->fk_receiving_user;
    }

    public function addFkReceivingUser(ContactReq $fkReceivingUser): self
    {
        if (!$this->fk_receiving_user->contains($fkReceivingUser)) {
            $this->fk_receiving_user[] = $fkReceivingUser;
            $fkReceivingUser->setFkSendingUser($this);
        }

        return $this;
    }

    public function removeFkReceivingUser(ContactReq $fkReceivingUser): self
    {
        if ($this->fk_receiving_user->contains($fkReceivingUser)) {
            $this->fk_receiving_user->removeElement($fkReceivingUser);
            // set the owning side to null (unless already changed)
            if ($fkReceivingUser->getFkSendingUser() === $this) {
                $fkReceivingUser->setFkSendingUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContactReq[]
     */
    public function getContactReqs(): Collection
    {
        return $this->contactReqs;
    }

    public function addContactReq(ContactReq $contactReq): self
    {
        if (!$this->contactReqs->contains($contactReq)) {
            $this->contactReqs[] = $contactReq;
            $contactReq->setFkReceivingUser($this);
        }

        return $this;
    }

    public function removeContactReq(ContactReq $contactReq): self
    {
        if ($this->contactReqs->contains($contactReq)) {
            $this->contactReqs->removeElement($contactReq);
            // set the owning side to null (unless already changed)
            if ($contactReq->getFkReceivingUser() === $this) {
                $contactReq->setFkReceivingUser(null);
            }
        }

        return $this;
    }
}
