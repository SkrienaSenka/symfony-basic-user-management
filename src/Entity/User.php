<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(fields: ['username'])]
#[ORM\UniqueConstraint(fields: ['pseudo', 'tag'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	public const ROLE_USER = 'ROLE_USER';
	public const ROLE_ADMIN = 'ROLE_ADMIN';

	public const ROLES = [
		self::ROLE_USER,
		self::ROLE_ADMIN,
	];

	public const PSEUDO_REGEX = '/^[A-Za-zÀ-ÿ0-9\'_.-]{1,20}$/';
	public const PASSWORD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,255}$/';

    #[ORM\Id]
	#[ORM\Column(type: 'uuid', unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

	#[ORM\Column(type: 'string', length: 50, unique: true)]
    private string $username;

	#[ORM\Column(type: 'string', length: 50)]
	private string $pseudo;

	#[ORM\Column(type: 'integer')]
	private int $tag;

	#[ORM\Column(type: 'string', length: 180)]
	private string $email;

	#[ORM\Column(type: 'boolean', options: ['default' => false])]
	private bool $isEmailVerified = false;

	/**
	 * @var string The hashed password
	 */
	#[ORM\Column(type: 'string', length: 255)]
	private string $password;

	#[ORM\Column(type: 'json')]
    private array $roles = [self::ROLE_USER];

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

	public function getPseudo(): string
	{
		return $this->pseudo;
	}

	public function setPseudo(string $pseudo): self
	{
		$this->pseudo = $pseudo;

		return $this;
	}

	public function getTag(): int
	{
		return $this->tag;
	}

	public function setTag(int $tag): self
	{
		$this->tag = $tag;

		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function isEmailVerified(): bool
	{
		return $this->isEmailVerified;
	}

	public function setIsEmailVerified(bool $isEmailVerified): self
	{
		$this->isEmailVerified = $isEmailVerified;

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
	public function getRoles(): array
	{
		return $this->roles;
	}

	public function setRoles(array $roles): self
	{
		if (!in_array(self::ROLE_USER, $roles)) {
			throw new \InvalidArgumentException(sprintf(
				'User roles must contain %s',
				self::ROLE_USER,
			));
		}

		if (count(array_diff($roles, self::ROLES))) {
			throw new \InvalidArgumentException(sprintf(
				'User roles must be an array of these [%s], [%s] given',
				implode(', ', self::ROLES),
				implode(', ', $roles),
			));
		}

		$this->roles = $roles;

		return $this;
	}

	public function addRole(string $role): self
	{
		if (!in_array($role, self::ROLES)) {
			throw new \InvalidArgumentException(sprintf(
				'User role must be one of the followings [%s], %s given',
				implode(', ', self::ROLES),
				$role,
			));
		}

		if (!in_array($role, $this->roles)) {
			$this->roles[] = $role;
		}

		return $this;
	}

	public function removeRole(string $role): self
	{
		if (self::ROLE_USER === $role) {
			throw new \InvalidArgumentException(sprintf(
				'User roles must contain %s',
				self::ROLE_USER,
			));
		}

		$this->roles = array_filter($this->roles, static fn (string $existingRole) => $existingRole !== $role);

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
}
