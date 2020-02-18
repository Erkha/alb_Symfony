<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Safe\DateTime as SafeDateTime;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UploadFileRepository")
 * @ORM\Entity
 *
 * @Vich\Uploadable
 */
class UploadFile
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
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var SafeDateTime
     */
    private $updatedAt;

    /**
     * @Vich\UploadableField(mapping="upload_files", fileNameProperty="fileName")
     * @var File
     */
    private $uploadedFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="attachments")
     *
     * @var Page|null
     */
    private $page;

    public function __toString(): string
    {
        return $this->fileName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function setUploadedFile(?File $file = null): void
    {
        $this->uploadedFile = $file;
        if (! $file) {
            return;
        }

        $this->updatedAt = new SafeDateTime('now');
    }

    public function getUploadedFile(): ?File
    {
        return $this->uploadedFile;
    }

    public function getUpdatedAt(): ?SafeDateTime
    {
        return $this->updatedAt;
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

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }
}
