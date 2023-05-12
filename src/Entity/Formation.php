<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['formation']]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'code' => 'partial'
    ]
)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 4,
        max: 100,
        minMessage: 'Le nom de la formation est trop court !',
        maxMessage: 'Le nom de la formation est trop long !'
    )]
    #[Assert\NotBlank(
        message: 'Le nom de la formation ne peut pas être vide'
    )]
    #[Groups('formation')]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    #[Assert\Length(
        min: 2,
        max: 5,
        minMessage: '{{ value }} est un code de formation trop court !',
        maxMessage: '{{ value }} est un code de formation trop long'
    )]
    #[Assert\NotBlank(
        message: 'Le code de la formation ne peut pas être vide'
    )]
    #[Groups('formation')]
    private ?string $code = null;

    #[ORM\Column(nullable: true)]
    #[Groups('formation')]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('formation')]
    #[Assert\GreaterThan(propertyPath: 'startedAt')]
    private ?\DateTimeImmutable $finishedAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups('formation')]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[Groups('formation')]
    private ?User $referent = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[Groups('formation')]
    private ?Filiere $filiere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeImmutable $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getReferent(): ?User
    {
        return $this->referent;
    }

    public function setReferent(?User $referent): self
    {
        $this->referent = $referent;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }
}
