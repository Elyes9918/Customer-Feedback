<?php 

namespace App\DataTransferObjects;

use phpDocumentor\Reflection\Types\Integer;

class FeedbackDto {

    private ?string $id=null;
    private ?string $title=null;
    private ?string $description=null;
    private ?string $project_id=null;
    private ?string $status=null;
    private ?string $estimated_time=null;
    private ?string $priority=null;
    private ?string $rating=null;
    private ?string $repo=null;
    private ?String $createdAt=null;
    private ?String $modifiedAt=null;
    private ?String $progress=null;
    private ?array $usersId= [];
    private ?array $creator = [];
    private ?array $project = [];



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
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    /**
     * Get the value of creator
     */
    public function getCreator(): array
    {
        return $this->creator;
    }

    /**
     * Set the value of creator
     */
    public function setCreator(array $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get the value of project
     */
    public function getProject(): array
    {
        return $this->project;
    }

    /**
     * Set the value of project
     */
    public function setProject(array $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get the value of progress
     */
    public function getProgress(): ?String
    {
        return $this->progress;
    }

    /**
     * Set the value of progress
     */
    public function setProgress(?String $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get the value of repo
     */
    public function getRepo(): ?string
    {
        return $this->repo;
    }

    /**
     * Set the value of repo
     */
    public function setRepo(?string $repo): self
    {
        $this->repo = $repo;

        return $this;
    }
}