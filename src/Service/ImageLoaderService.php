<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Image;
use App\Entity\Page;
use App\Exceptions\ImageLoaderException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function in_array;
use function md5;
use function uniqid;

/**
 * Class ContentService which manage content business logic.
 */
class ImageLoaderService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    private const IMAGE_DIR = 'img/pages';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Upload a file and link it to a content
     *
     * @param Page $content content related to the upload
     * @param UploadedFile $file file to upload
     *
     * @return Image the created Image object
     *
     * @throws ImageLoaderException
     */
    public function uploadPicture(Page $page, UploadedFile $file): Image
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (! in_array($file->guessExtension(), $extensions)) {
            throw new ImageLoaderException('Wrong extension');
        }

        return $this->upload($page, $file);
    }

    public function upload(Page $page, UploadedFile $file): Image
    {
        $filename = $this->generateFilename();
        $filename  .= '.' . $file->guessExtension();
        $file->move(self::IMAGE_DIR, $filename);

        $image = new Image();
        $image->setImage($filename);
        $image->setUpdatedAt();
        $page->addImage($image);

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    /**
     * Delete the picture related to the content in parameter.
     *
     * @param Page $page related content
     * @param Image $image SiFIle to delete
     */
    public function deletePicture(Page $page, Image $image): void
    {
        $fs = new Filesystem();
        $filepath = self::IMAGE_DIR . '/' . $image->getImage();
        if ($fs->exists($filepath)) {
            $fs->remove($filepath);
        }

        $page->removeImage($image);

        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    /**
     * Return an unique filename.
     *
     * @return string the unique file name
     */
    private function generateFilename(): string
    {
        return md5(uniqid());
    }
}
