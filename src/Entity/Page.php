<?php

declare(strict_types=1);

namespace App\Entity;

use App\Service\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $topPage;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $resume;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $content;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="page")
     *
     * @var Collection|Image[]
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="childs")
     *
     * @var Page
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="parent")
     *
     * @var Collection|Page[]
     */
    private $childs;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", inversedBy="topPage", cascade={"persist", "remove"})
     *
     * @var Image|null
     */
    private $topImage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UploadFile", mappedBy="page")
     *
     * @var Collection|UploadFile[]
     */
    private $attachments;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->childs = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
    }

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
        $slugger = new Slugger();
        $this->slug = $slugger->slugify($title);

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTopPage(): ?bool
    {
        return $this->topPage;
    }

    public function setTopPage(bool $topPage): self
    {
        $this->topPage = $topPage;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (! $this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPage($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPage() === $this) {
                $image->setPage(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): self
    {
        if (! $this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->childs->contains($child)) {
            $this->childs->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getTopImage(): ?Image
    {
        return $this->topImage;
    }

    public function setTopImage(?Image $topImage): self
    {
        $this->topImage = $topImage;

        return $this;
    }

    /**
     * @return Collection|UploadFile[]
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(UploadFile $attachment): self
    {
        if (! $this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setPage($this);
        }

        return $this;
    }

    public function removeAttachment(UploadFile $attachment): self
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->removeElement($attachment);
            // set the owning side to null (unless already changed)
            if ($attachment->getPage() === $this) {
                $attachment->setPage(null);
            }
        }

        return $this;
    }
}
