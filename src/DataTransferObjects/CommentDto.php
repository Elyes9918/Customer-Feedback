<?php 

namespace App\DataTransferObjects;

class CommentDto {

    private ?string $id=null;
    private ?string $description=null;
    private ?string $type=null;
    private ?String $createdAt=null;
    private ?String $modifiedAt=null;
    private ?array $user = [];
    private ?array $feedback = [];


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
     * Get the value of description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

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
     * Get the value of user
     */
    public function getUser(): ?array
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */
    public function setUser(?array $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of feedback
     */
    public function getFeedback(): ?array
    {
        return $this->feedback;
    }

    /**
     * Set the value of feedback
     */
    public function setFeedback(?array $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }
}