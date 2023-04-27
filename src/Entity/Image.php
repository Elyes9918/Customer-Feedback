<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use App\Trait\DateTrait;
use App\Trait\TokenTrait;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    use DateTrait;
    use TokenTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $imageSize = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Feedback $feedback = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageExtension = null;

    #[ORM\Column(length: 255)]
    private ?string $creatorId = null;


    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    
    /**
     * Set the value of feedback
     */
    public function setFeedback(?Feedback $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get the value of feedback
     */
    public function getFeedback(): ?Feedback
    {
        return $this->feedback;
    }

    public function getImageExtension(): ?string
    {
        return $this->imageExtension;
    }

    public function setImageExtension(?string $imageExtension): self
    {
        $this->imageExtension = $imageExtension;

        return $this;
    }

    public function getCreatorId(): ?string
    {
        return $this->creatorId;
    }

    public function setCreatorId(string $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }
}
