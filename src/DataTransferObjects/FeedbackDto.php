<?php 

namespace App\DataTransferObjects;

class FeedbackDto {

    private ?string $id=null;
    private ?string $sujet=null;
    private ?string $description=null;
    private ?string $project_id=null;
    private ?string $status=null;
    private ?String $realised=null;
    private ?string $estimated_time=null;
    private ?string $priority=null;
    private ?string $rating=null;
    private ?String $createdAt=null;
    private ?String $modifiedAt=null;
    private array $usersId= [];


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
     * Get the value of sujet
     */
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    /**
     * Set the value of sujet
     */
    public function setSujet(?string $sujet): self
    {
        $this->sujet = $sujet;

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
     * Get the value of project_id
     */
    public function getProjectId(): ?string
    {
        return $this->project_id;
    }

    /**
     * Set the value of project_id
     */
    public function setProjectId(?string $project_id): self
    {
        $this->project_id = $project_id;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of realised
     */
    public function getRealised(): ?String
    {
        return $this->realised;
    }

    /**
     * Set the value of realised
     */
    public function setRealised(?String $realised): self
    {
        $this->realised = $realised;

        return $this;
    }

    /**
     * Get the value of estimated_time
     */
    public function getEstimatedTime(): ?string
    {
        return $this->estimated_time;
    }

    /**
     * Set the value of estimated_time
     */
    public function setEstimatedTime(?string $estimated_time): self
    {
        $this->estimated_time = $estimated_time;

        return $this;
    }

    /**
     * Get the value of priority
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     */
    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get the value of rating
     */
    public function getRating(): ?string
    {
        return $this->rating;
    }

    /**
     * Set the value of rating
     */
    public function setRating(?string $rating): self
    {
        $this->rating = $rating;

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
     * Get the value of usersId
     */
    public function getUsersId(): array
    {
        return $this->usersId;
    }

    /**
     * Set the value of usersId
     */
    public function setUsersId(array $usersId): self
    {
        $this->usersId = $usersId;

        return $this;
    }
}