<?php

namespace App\Model;

use App\Traits\PartiallyInitializedTrait;
use Symfony\Component\Uid\Uuid;

class UserOutput implements PartiallyInitializedModelInterface
{
	use PartiallyInitializedTrait;

	public Uuid $id;
	public string $username;
	public string $pseudo;
	public int $tag;
	public string $email;

	public function getId(): Uuid
	{
		return $this->id;
	}

	public function setId(Uuid $id): self
	{
		$this->id = $id;
		$this->addInitializedProperty('id');

		return $this;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function setUsername(string $username): self
	{
		$this->username = $username;
		$this->addInitializedProperty('username');

		return $this;
	}

	public function getPseudo(): string
	{
		return $this->username;
	}

	public function setPseudo(string $pseudo): self
	{
		$this->pseudo = $pseudo;
		$this->addInitializedProperty('pseudo');

		return $this;
	}

	public function getTag(): int
	{
		return $this->tag;
	}

	public function setTag(int $tag): self
	{
		$this->tag = $tag;
		$this->addInitializedProperty('tag');

		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		$this->addInitializedProperty('email');

		return $this;
	}
}
