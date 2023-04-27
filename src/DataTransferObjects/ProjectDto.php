<?php 

namespace App\DataTransferObjects;

class ProjectDto {

    private ?string $id=null;
    private ?string $title=null;
    private ?string $client=null;
    private ?string $status=null;
    private ?string $description=null;
    private ?string $repo=null;
    private ?String $createdAt=null;
    private ?String $modifiedAt=null;
    private array $usersId= [];
    private array $feedbacks= [];
    private array $creator = [];

    public function __construct(
        ) {}

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
     * Get the value of client
     */
    public function getClient(): ?string
    {
        return $this->client;
    }

    /**
     * Set the value of client
     */
    public function setClient(?string $client): self
    {
        $this->client = $client;

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
     * Get the value of feedbacks
     */
    public function getFeedbacks(): array
    {
        return $this->feedbacks;
    }

    /**
     * Set the value of feedbacks
     */
    public function setFeedbacks(array $feedbacks): self
    {
        $this->feedbacks = $feedbacks;

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