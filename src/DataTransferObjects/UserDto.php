<?php 

namespace App\DataTransferObjects;


class UserDto {

    private ?string $id=null;
    private ?string $email=null;
    private ?String $createdAt=null;
    private ?String $modifiedAt=null;
    private ?string $firstName=null;
    private ?string $lastName=null;
    private ?string $birthDate=null;
    private ?string $status=null;
    private ?string $address=null;
    private ?string $phoneNumber=null;
    private ?string $company=null;
    private ?string $country=null;
    private ?string $lastLogin=null;
    private ?bool $isVerified=null;
    private ?string $notificationIsOn=null;
    private array $projectsId= [];
    private array $feedbacksId= [];
    private array $roles= [];


    
    public function __construct(
    ) {}


     /**
     * Get the value of country
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of country
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

     /**
     * Get the value of country
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Set the value of country
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }


      /**
     * Get the value of isVerified
     */
    public function getIsVerified(): ?int
    {
        return $this->isVerified;
    }

    /**
     * Set the value of isVerified
     */
    public function setIsVerified(?int $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
     * Get the value of lastLogin
     */
    public function getLastLogin(): ?String
    {
        return $this->lastLogin;
    }

    /**
     * Set the value of lastLogin
     */
    public function setLastLogin(?String $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

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
     * Get the value of firstName
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of birthDate
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * Set the value of birthDate
     */
    public function setBirthDate(?string $birthDate): self
    {
        $this->birthDate = $birthDate;

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
     * Get the value of address
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Set the value of address
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of company
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * Set the value of company
     */
    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of projectsId
     */
    public function getProjectsId(): array
    {
        return $this->projectsId;
    }

    /**
     * Set the value of projectsId
     */
    public function setProjectsId(array $projectsId): self
    {
        $this->projectsId = $projectsId;

        return $this;
    }

    /**
     * Get the value of feedbacksId
     */
    public function getFeedbacksId(): array
    {
        return $this->feedbacksId;
    }

    /**
     * Set the value of feedbacksId
     */
    public function setFeedbacksId(array $feedbacksId): self
    {
        $this->feedbacksId = $feedbacksId;

        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of notificationIsOn
     */
    public function getNotificationIsOn(): ?string
    {
        return $this->notificationIsOn;
    }

    /**
     * Set the value of notificationIsOn
     */
    public function setNotificationIsOn(?string $notificationIsOn): self
    {
        $this->notificationIsOn = $notificationIsOn;

        return $this;
    }
}
