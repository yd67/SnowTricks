<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity=Triks::class, inversedBy="image")
     */
    private $triks;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $path;

    /**
     *  @Assert\Image(
     *  maxSize = "10M",
     *  mimeTypes= {"image/*"},
     *  mimeTypesMessage = "seul les images  sont autorisé",
     *  maxSizeMessage = "le fichier est trop volumineux",
     *  )
     */
    protected $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTriks(): ?Triks
    {
        return $this->triks;
    }

    public function setTriks(?Triks $triks): self
    {
        $this->triks = $triks;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }
}
