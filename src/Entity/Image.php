<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Safe\DateTime as SafeDateTime;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 *
 * @Vich\Uploadable
 */
class Image
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
    private $image;

    /**
     * @Vich\UploadableField(mapping="page_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var SafeDateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="images")
     *
     * @var Page
     */
    private $page;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page", mappedBy="topImage", cascade={"persist", "remove"})
     *
     * @var Page
     */
    private $topPage;

    public function __toString(): string
    {
        return $this->image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;
        if (! $image) {
            return;
        }

        $this->updatedAt = new SafeDateTime('now');
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;

        return;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getUpdatedAt(): ?SafeDateTime
    {
        return $this->updatedAt;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getTopPage(): ?Page
    {
        return $this->topPage;
    }

    public function setTopPage(?Page $topPage): self
    {
        $this->topPage = $topPage;

        // set (or unset) the owning side of the relation if necessary
        $newTopImage = $topPage === null ? null : $this;
        if ($topPage->getTopImage() !== $newTopImage) {
            $topPage->setTopImage($newTopImage);
        }

        return $this;
    }
}
