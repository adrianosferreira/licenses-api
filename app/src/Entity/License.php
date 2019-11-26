<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LicenseRepository")
 */
class License {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 */
	private $user;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $expires_at;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $status;

	public function getId(): ?int {
		return $this->id;
	}

	public function getUser(): ?User {
		return $this->user;
	}

	public function setUser( ?User $user ): self {
		$this->user = $user;

		return $this;
	}

	public function getExpiresAt(): ?\DateTimeInterface {
		return $this->expires_at;
	}

	public function setExpiresAt( \DateTimeInterface $expires_at ): self {
		$this->expires_at = $expires_at;

		return $this;
	}

	public function getStatus(): ?int {
		return $this->status;
	}

	public function setStatus( int $status ): self {
		$this->status = $status;

		return $this;
	}
}
