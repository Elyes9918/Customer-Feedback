<?php 

namespace App\DataTransferObjects;

class FileDto {

    private ?string $id=null;
    private ?string $fileName=null;
    private ?string $fileExtension=null;
    private ?string $fileUrl=null;
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
     * Get the value of fileName
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     */
    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of fileExtension
     */
    public function getFileExtension(): ?string
    {
        return $this->fileExtension;
    }

    /**
     * Set the value of fileExtension
     */
    public function setFileExtension(?string $fileExtension): self
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Get the value of fileUrl
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * Set the value of fileUrl
     */
    public function setFileUrl(?string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

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