<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface {
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
	 * @ORM\Column(type="datetime")
	 */
	private $created_at;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updated_at;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\License", mappedBy="user", orphanRemoval=true)
	 */
	private $licenses;

	/**
	 * @ORM\Column(type="json")
	 */
	private $roles = [];

	/**
	 * @ORM\Column(type="string", length=150)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $token;

	public function __construct() {
		$this->licenses = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName( string $name ): self {
		$this->name = $name;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->created_at;
	}

	public function setCreatedAt( \DateTimeInterface $created_at ): self {
		$this->created_at = $created_at;

		return $this;
	}

	public function getUpdatedAt(): ?\DateTimeInterface {
		return $this->updated_at;
	}

	public function setUpdatedAt( \DateTimeInterface $updated_at ): self {
		$this->updated_at = $updated_at;

		return $this;
	}

	/**
	 * @return Collection|License[]
	 */
	public function getLicenses() {
		return $this->licenses;
	}

	public function addLicense( License $license ): self {
		if ( ! $this->licenses->contains( $license ) ) {
			$this->licenses[] = $license;
			$license->setUser( $this );
		}

		return $this;
	}

	public function removeLicense( License $license ): self {
		if ( $this->licenses->contains( $license ) ) {
			$this->licenses->removeElement( $license );
			// set the owning side to null (unless already changed)
			if ( $license->getUser() === $this ) {
				$license->setUser( null );
			}
		}

		return $this;
	}

	public function getRoles() {
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique( $roles );
	}

	public function setRoles( array $roles ): self {
		$this->roles = $roles;

		return $this;
	}

	public function getPassword() {
		return $this->token;
	}

	public function getSalt() {
		// TODO: Implement getSalt() method.
	}

	public function getUsername() {
		return $this->email;
	}

	public function eraseCredentials() {
		// TODO: Implement eraseCredentials() method.
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail( string $email ): self {
		$this->email = $email;

		return $this;
	}

	public function getToken(): ?string {
		return $this->token;
	}

	public function setToken( string $token ): self {
		$this->token = $token;

		return $this;
	}
}
