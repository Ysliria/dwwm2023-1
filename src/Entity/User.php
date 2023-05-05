<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(
        message: "Nous devez saisir un email !"
    )]
    #[Assert\Email(
        message: 'L\'adresse mail {{value}} n\'est pas une adresse valide !',
        mode: 'strict'
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Le nom {{ value }} est trop court !',
        maxMessage: 'Le nom {{ value }} est trop long !'
    )]
    #[Assert\NotBlank(
        message: '{{ value }} n\'est pas un nom valide !'
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Le prénom {{ value }} est trop court !',
        maxMessage: 'Le prénom {{ value }} est trop long !'
    )]
    #[Assert\NotBlank(
        message: '{{ value }} n\'est pas un prénom valide !'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Length(
        min: 10,
        max: 13,
        minMessage: 'Votre numéro de téléphone est trop court !',
        maxMessage: 'Votre numéro de téléphone est trop long !'
    )]
    private ?string $phone = null;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
