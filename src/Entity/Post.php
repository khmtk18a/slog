<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ApiResource(operations: [new Get(), new GetCollection()])]
#[HasLifecycleCallbacks]
#[ApiFilter(SearchFilter::class, properties: ['tags' => SearchFilter::STRATEGY_EXACT, 'title' => SearchFilter::STRATEGY_PARTIAL])]
#[ApiFilter(OrderFilter::class, properties: ['createdAt', 'updatedAt', 'score'])]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements Timestampable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column]
    private int $score = 0;

    #[ApiProperty(readableLink: true)]
    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /** @var Collection<int,Tag> */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'posts')]
    private Collection $tags;

    /** @var Collection<int,Comment> */
    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    /** @var Collection<int,Vote> */
    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Vote::class, orphanRemoval: true)]
    private Collection $votes;

    private int $commentsCount;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    #[PrePersist]
    public function prePersist(): void
    {
        $now = new \DateTime();

        $this->createdAt = $this->updatedAt = $now;
    }

    #[PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection<int,Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getCommentsCount(): int
    {
        return $this->commentsCount;
    }

    public function setCommentsCount(int $commentsCount): self
    {
        $this->commentsCount = $commentsCount;

        return $this;
    }
}
