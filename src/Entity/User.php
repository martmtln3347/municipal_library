<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'adresse email n'est pas valide.")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(min: 8, minMessage: "Le mot de passe doit contenir au moins 8 caractères.")]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le nom doit contenir au moins 2 caractères.")]
    private ?string $lastName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le prénom doit contenir au moins 2 caractères.")]
    private ?string $firstName = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire.")]
    #[Assert\Length(min: 5, max: 150, minMessage: "L'adresse doit contenir au moins 5 caractères.")]
    private ?string $address = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank(message: "Le code postal est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[0-9]{5}$/",
        message: "Le code postal doit contenir exactement 5 chiffres."
    )]
    private ?string $zipCode = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date de naissance est obligatoire.")]
    #[Assert\LessThan("today", message: "La date de naissance doit être dans le passé.")]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Book::class, cascade: ['remove'])]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    // --- Getters & setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        // garantit au moins le rôle ROLE_USER
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setUser($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            if ($book->getUser() === $this) {
                $book->setUser(null);
            }
        }

        return $this;
    }

    // === Méthodes requises par UserInterface ===

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
        // Si tu stockes des infos sensibles temporaires, nettoie-les ici
    }

    public function getUsername(): string
    {
        // Compatibilité ascendante (anciennes versions)
        return (string) $this->email;
    }
}
