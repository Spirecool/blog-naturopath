<?php

namespace App\Entity\Post;

use App\Entity\Post\Post;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Post\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', message: 'Ce slug existe déjà.')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank()]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank()]
    private string $slug = '';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'categories')]
    #[JoinTable(name: 'categories_posts')]
    private Collection $posts;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
    }

    #[ORM\PrePersist]
    // Permet de générer automatiquement les slugs lors de la cration des Catégories
    public function prePersist()
    {
        $this->slug = (new Slugify())->slugify($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }


    public function setSlug($slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    // le point d'interrogation avant le string veut dire que cela peut être nul
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPosts() : Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post) : self
    {
        if(!$this->posts->contains($post)) {
            $this->posts[] = $post;
        }
        return $this;
    }

    public function removePost(Post $post) : self
    {
        $this->posts->removeElement($post);
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}