<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GifRepository::class)
 * @Vich\Uploadable
 */
class Gif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre du quiz ne peut pas être vide.")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;
    
    /**
     * @Vich\UploadableField(mapping="gif_images", fileNameProperty="picture")
     * @var File|null
     *
     * @Assert\File(
     *     maxSize = "30M",
     *     maxSizeMessage = "Le fichier est trop volumineux. La taille maximale autorisée est {{ limit }}",
     * )
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $soundstrack;

    /**
     * @Vich\UploadableField(mapping="soundstrack_images", fileNameProperty="soundstrack")
     * @var File|null
     *
     * @Assert\File(
     *     maxSize = "30M",
     *     maxSizeMessage = "Le fichier est trop volumineux. La taille maximale autorisée est {{ limit }}",
     * )
     */
    private $soundstrackFile;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
    /**
     * Get the value of pictureFile
     *
     * @return File|null
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * Set the value of pictureFile
     *
     * @param File|null $pictureFile
     * @return self
     */
    public function setPictureFile(?File $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getSoundstrack(): ?string
    {
        return $this->soundstrack;
    }

    public function setSoundstrack(?string $soundstrack): self
    {
        $this->soundstrack = $soundstrack;

        return $this;
    }

    /**
     * Get the value of soundstrackFile
     *
     * @return  File|null
     */ 
    public function getSoundstrackFile()
    {
        return $this->soundstrackFile;
    }
    
    /**
     * Set the value of soundstrackFile
     *
     * @param  File|null  $soundstrackFile
     *
     * @return  self
     */ 
    public function setSoundstrackFile($soundstrackFile)
    {
        $this->soundstrackFile = $soundstrackFile;

        return $this;
    }
}
