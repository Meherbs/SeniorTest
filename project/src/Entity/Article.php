<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $picture;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $last_updated_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->last_updated_at;
    }

    public function setLastUpdatedAt(\DateTimeImmutable $last_updated_at): self
    {
        $this->last_updated_at = $last_updated_at;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'description'=> $this->description,
            'picture' => $this->picture,
            'created_at'=> $this->created_at,
            'last_updated_at'=> $this->last_updated_at,
        );
    }
}
