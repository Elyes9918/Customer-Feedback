<?php 

namespace App\DataTransferObjects;

class ImageDto {

    private ?string $id=null;
    private ?string $imageName=null;
    private ?string $imageExtension=null;
    private ?string $imageUrl=null;
    private ?String $createdAt=null;
    private ?String $modifiedAt=null;
    private ?String $creatorId=null;

    


    /**
     * Get the value of id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of imageUrl
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * Set the value of imageUrl
     */
    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): ?String
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */
    public function setCreatedAt(?String $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of modifiedAt
     */
    public function getModifiedAt(): ?String
    {
        return $this->modifiedAt;
    }

    /**
     * Set the value of modifiedAt
     */
    public function setModifiedAt(?String $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get the value of imageName
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get the value of imageExtension
     */
    public function getImageExtension(): ?string
    {
        return $this->imageExtension;
    }

    /**
     * Set the value of imageExtension
     */
    public function setImageExtension(?string $imageExtension): self
    {
        $this->imageExtension = $imageExtension;

        return $this;
    }

    /**
     * Get the value of creatorId
     */
    public function getCreatorId(): ?String
    {
        return $this->creatorId;
    }

    /**
     * Set the value of creatorId
     */
    public function setCreatorId(?String $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }
}