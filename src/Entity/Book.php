<?php

namespace App\Entity;

use App\Repository\BookRepository;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, unique: true, nullable: true)]
    #[Assert\Regex(
        pattern: "/^[0-9]{10,13}$/",
        message: "L'ISBN doit contenir entre 10 et 13 chiffres."
    )]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le titre doit contenir au moins 2 caractères."
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Le résumé est obligatoire.")]
    #[Assert\Length(
        min: 10,
        minMessage: "Le résumé doit contenir au moins 10 caractères."
    )]
    private ?string $summary = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank(message: "L'année de publication est obligatoire.")]
    #[Assert\Range(
        min: 1500,
        max: 2100,
        notInRangeMessage: "L'année de publication doit être comprise entre 1500 et aujourd'hui."
    )]
    private ?int $publicationYear = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $issueDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    // --- Getters / Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publicationYear;
    }

    public function setPublicationYear(int $publicationYear): self
    {
        $this->publicationYear = $publicationYear;
        return $this;
    }

    public function getIssueDate(): ?\DateTimeInterface
    {
        return $this->issueDate;
    }

    public function setIssueDate(?\DateTimeInterface $issueDate): self
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
